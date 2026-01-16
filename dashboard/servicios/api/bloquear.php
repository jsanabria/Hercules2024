<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

// Inputs
$localidad = $_POST['localidad'] ?? '';
$capilla   = $_POST['capilla'] ?? '';   // Nservicio (varchar)
$fecha     = $_POST['fecha'] ?? date('Y-m-d');
$time      = $_POST['time'] ?? '04:00';
$horas     = max(1, (int)($_POST['horas'] ?? 1));
$motivo    = trim($_POST['motivo'] ?? 'Bloqueo');

if ($localidad === '' || $capilla === '') {
  echo json_encode(['ok' => false, 'msg' => 'Datos insuficientes.']); exit;
}

// Rango
$dtStart = sprintf('%s %s:00', $fecha, $time);
$dtEndTs = strtotime($dtStart) + ($horas * 3600);
$dtEnd   = date('Y-m-d H:i:s', $dtEndTs);
$hIni    = date('H:i:s', strtotime($dtStart));
$hFin    = date('H:i:s', $dtEndTs);

// Candado anti-carrera
$lockKey = "bloqueo_lock:{$localidad}:{$capilla}";
$lockRes = $mysqli->query("SELECT GET_LOCK('".$mysqli->real_escape_string($lockKey)."', 5) AS got");
if ($lockRes && ($row = $lockRes->fetch_assoc()) && (int)$row['got'] !== 1) {
  echo json_encode(['ok'=>false,'msg'=>'Sistema ocupado. Intente nuevamente.']); exit;
}

/* 1) No permitir bloquear si se solapa con RESERVAS existentes en esa capilla/localidad.
   Solape correcto: NOT ( nuevoFin <= inicio OR nuevoInicio >= fin ) */
$qSolRes = "SELECT DISTINCT o.expediente AS exp_solapa
              FROM sco_orden o
             WHERE o.servicio_tipo = ?
               AND o.servicio      = ?
               AND COALESCE(o.anulada,'N') <> 'S'
               AND NOT ( ? <= o.fecha_inicio OR ? >= o.fecha_fin )";
$stmt = $mysqli->prepare($qSolRes);
$stmt->bind_param("ssss", $localidad, $capilla, $dtEnd, $dtStart);
$stmt->execute();
$r = $stmt->get_result();

$expConflictos = [];
while ($row = $r->fetch_assoc()) {
  $expConflictos[] = (int)$row['exp_solapa'];
}
$stmt->close();

if (!empty($expConflictos)) {
  $lista = implode(', ', $expConflictos);
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode([
    'ok'  => false,
    'msg' => "No se puede bloquear: existe(n) reserva(s) que se solapan en este horario para expediente(s): {$lista}."
  ]);
  exit;
}

/* 2) No permitir bloquear si se solapa con OTROS BLOQUEOS previos (para no duplicar) */
$qSolBlk = "SELECT 1
              FROM sco_reserva r
             WHERE r.localidad = ?
               AND r.capilla   = ?
               AND NOT ( ? <= r.fecha_inicio OR ? >= r.fecha_fin )
             LIMIT 1";
$stmt = $mysqli->prepare($qSolBlk);
$stmt->bind_param("ssss", $localidad, $capilla, $dtEnd, $dtStart);
$stmt->execute(); $stmt->store_result();
if ($stmt->num_rows > 0) {
  $stmt->close();
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode([
    'ok'  => false,
    'msg' => "Ya existe un bloqueo que se solapa en ese horario."
  ]);
  exit;
}
$stmt->close();

/* 3) Insertar el bloqueo */
$now  = date('Y-m-d H:i:s');
$user = ''; // TODO: usuario de sesión si aplica

$ins = "INSERT INTO sco_reserva
          (localidad, capilla, fecha_inicio, fecha_fin, hora_inicio, hora_fin, motivo, user_registra, fecha_registro)
        VALUES
          (?,?,?,?,?,?,?,?,?)";

$stmt = $mysqli->prepare($ins);
if (!$stmt) {
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode(['ok'=>false,'msg'=>'Error de preparación: '.$mysqli->error]); exit;
}
$stmt->bind_param(
  "sssssssss",
  $localidad,
  $capilla,
  $dtStart,
  $dtEnd,
  $hIni,
  $hFin,
  $motivo,
  $user,
  $now
);
$ok = $stmt->execute();
$err = $ok ? '' : $stmt->error;
$stmt->close();

// Liberar candado
$mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");


/* 8) Registra bitacora */
audittrail_try($link, [
  'action'   => 'BLOQUEAR',
  'table'    => 'sco_reserva',
  'newvalue' => [
    'localidad'    => $localidad,
    'capilla'      => $capilla,
    'fecha_inicio' => $dtStart,
    'fecha_fin'    => $dtEnd,
    'motivo'       => $motivo,
  ],
]);


echo json_encode(['ok'=>$ok, 'msg'=>$ok ? 'Franja bloqueada' : ('Error: '.$err)]);

