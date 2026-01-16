<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$expediente = (int)($_POST['expediente'] ?? 0);
$localidad  = $_POST['localidad'] ?? '';
$capilla    = $_POST['capilla'] ?? '';   // Nservicio (varchar)
$fecha      = $_POST['fecha'] ?? date('Y-m-d');
$time       = $_POST['time'] ?? '04:00';
$horas      = max(1, (int)($_POST['horas'] ?? 1)); // al menos 1

if (!$expediente || !$localidad || !$capilla) {
  echo json_encode(['ok'=>false,'msg'=>'Datos insuficientes']); exit;
}

/* 1) Unión del expediente ACTUAL:
   Solo se permite solapar si sco_expediente.unir_con_expediente (del EXPEDIENTE ACTUAL)
   apunta EXACTAMENTE al/los expediente(s) con los que se cruza. */
$stmt = $mysqli->prepare("SELECT unir_con_expediente FROM sco_expediente WHERE Nexpediente = ?");
$stmt->bind_param("i", $expediente);
$stmt->execute();
$stmt->bind_result($unirConActual);
$stmt->fetch();
$stmt->close();
$unirConActual = $unirConActual ? (int)$unirConActual : null;

/* 2) Construir rango */
$dtStart = sprintf('%s %s:00', $fecha, $time);
$dtEndTs = strtotime($dtStart) + ($horas * 3600);
$dtEnd   = date('Y-m-d H:i:s', $dtEndTs);
$hIni    = date('H:i:s', strtotime($dtStart));
$hFin    = date('H:i:s', $dtEndTs);

/* 3) Candado anti-carrera (MyISAM) */
$lockKey = "capilla_lock:{$localidad}:{$capilla}";
$lockRes = $mysqli->query("SELECT GET_LOCK('".$mysqli->real_escape_string($lockKey)."', 5) AS got");
if ($lockRes && ($row = $lockRes->fetch_assoc()) && (int)$row['got'] !== 1) {
  echo json_encode(['ok'=>false,'msg'=>'Sistema ocupado. Intente nuevamente.']); exit;
}

/* 4) Validar bloqueos
   NO hay solape cuando: nuevoFin <= bloqueInicio OR nuevoInicio >= bloqueFin
   ⇒ Hay solape cuando: NOT ( ? <= fecha_inicio OR ? >= fecha_fin )  */
$qBlk = "SELECT 1 FROM sco_reserva
          WHERE localidad=? AND capilla=?
            AND NOT ( ? <= fecha_inicio OR ? >= fecha_fin )
          LIMIT 1";
$stmt = $mysqli->prepare($qBlk);
$stmt->bind_param("ssss", $localidad, $capilla, $dtEnd, $dtStart);
$stmt->execute(); $stmt->store_result();
if ($stmt->num_rows > 0) {
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode(['ok'=>false,'msg'=>'Franja bloqueada por mantenimiento']); exit;
}
$stmt->close();

/* 5) Validar SOLAPES en la MISMA capilla:
   NO hay solape cuando: nuevoFin <= existenteInicio OR nuevoInicio >= existenteFin
   ⇒ Hay solape cuando: NOT ( ? <= o.fecha_inicio OR ? >= o.fecha_fin )
   - Recolectamos TODOS los expedientes con reservas que se cruzan.
   - Regla:
       * Si no hay solapes ⇒ OK.
       * Si hay solapes:
           - Si $unirConActual es NULL ⇒ RECHAZAR.
           - Si alguno de los solapes es distinto de $unirConActual ⇒ RECHAZAR.
           - Si todos los solapes son con $unirConActual ⇒ PERMITIR.
       * Si el mismo expediente cruza consigo mismo ⇒ RECHAZAR. */
$qSol = "SELECT DISTINCT o.expediente AS exp_solapa
           FROM sco_orden o
          WHERE o.servicio_tipo=? AND o.servicio=? AND COALESCE(o.anulada,'N')<>'S'
            AND NOT ( ? <= o.fecha_inicio OR ? >= o.fecha_fin )";
$stmt = $mysqli->prepare($qSol);
$stmt->bind_param("ssss", $localidad, $capilla, $dtEnd, $dtStart);
$stmt->execute();
$res = $stmt->get_result();

$solapes = [];
$chocaConSiMismo = false;
while ($row = $res->fetch_assoc()) {
  $otro = (int)$row['exp_solapa'];
  if ($otro === $expediente) { $chocaConSiMismo = true; }
  $solapes[] = $otro;
}
$stmt->close();

if ($chocaConSiMismo) {
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode(['ok'=>false,'msg'=>'Solapamiento no permitido: el expediente ya tiene una reserva que cruza en esta capilla/horario.']); 
  exit;
}

if (count($solapes) > 0) {
  if (is_null($unirConActual)) {
    $lista = implode(', ', $solapes);
    $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
    echo json_encode(['ok'=>false,'msg'=>"Solapamiento no permitido: la capilla ya está reservada en ese horario por el/los expediente(s): {$lista}."]); 
    exit;
  }
  // Si hay unión, TODOS los solapes deben ser exactamente con ese expediente unido
  $solapesDistintos = array_values(array_filter($solapes, function($e) use ($unirConActual){ return $e !== $unirConActual; }));
  if (count($solapesDistintos) > 0) {
    $lista = implode(', ', $solapesDistintos);
    $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
    echo json_encode(['ok'=>false,'msg'=>"Solapamiento no permitido: la capilla ya está reservada en ese horario por expediente(s) distinto(s) al permitido ({$unirConActual}): {$lista}."]); 
    exit;
  }
  // Si llegamos aquí: todos los solapes son exactamente con $unirConActual ⇒ permitir
}

/* 6) Insertar reserva */
$now   = date('Y-m-d H:i:s');
$user  = ''; // TODO: usuario de sesión si aplica
$paso  = 1;
$cant  = 1;
$total = 0.0;

$ins = "INSERT INTO sco_orden
        (expediente, proveedor, servicio_tipo, servicio, paso,
         fecha_inicio, hora_inicio, horas,
         fecha_fin,    hora_fin,
         cantidad, total, user_registra, fecha_registro, anulada)
        VALUES (?,1,?,?,?,?,?,?, ?,?,?, ?,?,?, 'N')";

$stmt = $mysqli->prepare($ins);
if (!$stmt) {
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode(['ok'=>false,'msg'=>'Error de preparación: '.$mysqli->error]); exit;
}
$stmt->bind_param(
  "issississidss",
  $expediente,   // i
  $localidad,    // s
  $capilla,      // s
  $paso,         // i
  $dtStart,      // s
  $hIni,         // s
  $horas,        // i
  $dtEnd,        // s
  $hFin,         // s
  $cant,         // i
  $total,        // d
  $user,         // s
  $now           // s
);
$ok = $stmt->execute();
$err = $ok ? '' : $stmt->error;
$stmt->close();

/* 7) liberar lock */
$mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");

/* 8) Registra bitacora */
audittrail_try($link, [
  'action'   => 'RESERVAR',
  'table'    => 'sco_orden',
  'field'    => 'expediente',
  'keyvalue' => $expediente, // PK (Norden)
  'newvalue' => [
    'expediente'   => (int)$expediente,
    'localidad'    => $localidad,
    'capilla'      => $capilla,
    'fecha_inicio' => $dtStart,
    'fecha_fin'    => $dtEnd,
    'horas'        => (int)$horas,
  ],
]);

echo json_encode(['ok'=>$ok, 'msg'=>$ok?'Reservado':('Error: '.$err)]);
