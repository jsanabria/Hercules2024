<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$localidad = $_GET['localidad'] ?? '';
$fecha     = $_GET['fecha'] ?? date('Y-m-d');

if ($localidad === '') { echo json_encode(['times'=>[], 'capillas'=>[], 'slots'=>[]]); exit; }

// 1) Capillas
$stmt = $mysqli->prepare("SELECT Nservicio, nombre 
                            FROM sco_servicio 
                           WHERE tipo = ? AND activo='S'
                           ORDER BY secuencia, nombre");
$stmt->bind_param("s", $localidad);
$stmt->execute();
$capRes = $stmt->get_result();
$capillas = $capRes->fetch_all(MYSQLI_ASSOC);

// 2) Tiempos
function timeSlots($start='04:00', $end='22:30') {
  $out = [];
  $t  = strtotime($start);
  $to = strtotime($end);
  while ($t <= $to) {
    $out[] = date('H:i', $t);
    $t = strtotime('+30 minutes', $t);
  }
  return $out;
}
$times = timeSlots();

// 3) Reservas del día  ====> AÑADIR Norden
$qOrd = "SELECT o.Norden, o.expediente, o.servicio AS capilla,
                e.nombre_fallecido, e.apellidos_fallecido,
                o.fecha_inicio, o.fecha_fin
           FROM sco_orden o
      LEFT JOIN sco_expediente e ON e.Nexpediente = o.expediente
          WHERE o.servicio_tipo = ?
            AND COALESCE(o.anulada,'N') <> 'S'
            AND o.fecha_inicio <= CONCAT(?, ' 23:59:59')
            AND o.fecha_fin    >= CONCAT(?, ' 00:00:00')";
$stmt = $mysqli->prepare($qOrd);
$stmt->bind_param("sss", $localidad, $fecha, $fecha);
$stmt->execute();
$resOrd = $stmt->get_result();
$reservas = $resOrd->fetch_all(MYSQLI_ASSOC);

// 4) Bloqueos del día  ====> AÑADIR id
$qBlk = "SELECT id, capilla, fecha_inicio, fecha_fin, motivo
           FROM sco_reserva
          WHERE localidad = ?
            AND fecha_inicio <= CONCAT(?, ' 23:59:59')
            AND fecha_fin    >= CONCAT(?, ' 00:00:00')";
$stmt = $mysqli->prepare($qBlk);
$stmt->bind_param("sss", $localidad, $fecha, $fecha);
$stmt->execute();
$resBlk = $stmt->get_result();
$bloqueos = $resBlk->fetch_all(MYSQLI_ASSOC);

$slots = [];

// helper medias horas
function halfHoursWithinDay($fecha, $dtStart, $dtEnd) {
  $dStart = strtotime($dtStart);
  $dEnd   = strtotime($dtEnd);
  $dayStart = strtotime($fecha.' 00:00:00');
  $dayEnd   = strtotime($fecha.' 23:59:59');

  $start = max($dStart, $dayStart);
  $end   = min($dEnd,   $dayEnd);

  $out = [];
  for ($t = $start; $t < $end; $t = strtotime('+30 minutes', $t)) {
    $out[] = date('H:i', $t);
  }
  return $out;
}

// A) Bloqueos (prioridad)
foreach ($bloqueos as $b) {
  $cap = $b['capilla'];
  $motivo = $b['motivo'] ?: 'Bloqueo';
  foreach (halfHoursWithinDay($fecha, $b['fecha_inicio'], $b['fecha_fin']) as $h) {
    $key = "$cap|$h";
    $slots[$key] = [
      'estado'     => 'bloqueada',
      'text'       => $motivo,
      'items'      => [],
      'bloqueo_id' => (int)$b['id']   // 👈 guardamos el ID del bloqueo
    ];
  }
}

// B) Reservas (acumular múltiples)
foreach ($reservas as $r) {
  $cap = $r['capilla'];
  $nom = trim(($r['nombre_fallecido'] ?? '').' '.($r['apellidos_fallecido'] ?? ''));
  $label = '#'.$r['expediente'].' - '.$nom;
  foreach (halfHoursWithinDay($fecha, $r['fecha_inicio'], $r['fecha_fin']) as $h) {
    $key = "$cap|$h";
    if (isset($slots[$key]) && $slots[$key]['estado'] === 'bloqueada') continue;

    if (!isset($slots[$key])) {
      $slots[$key] = ['estado'=>'reservada', 'text'=>'', 'items'=>[]];
    } else {
      if (!isset($slots[$key]['estado']) || $slots[$key]['estado'] === 'disponible') {
        $slots[$key]['estado'] = 'reservada';
      }
      if (!isset($slots[$key]['items'])) $slots[$key]['items'] = [];
    }

    // evitar duplicados
    $already = false;
    foreach ($slots[$key]['items'] as $it) {
      if ((int)$it['expediente'] === (int)$r['expediente']) { $already = true; break; }
    }
    if (!$already) {
      $slots[$key]['items'][] = [
        'orden_id'  => (int)$r['Norden'],   // 👈 ID exacto de la orden
        'expediente'=> (int)$r['expediente'],
        'label'     => $label,
        'nombre'    => $nom
      ];
    }

    $labels = array_map(fn($it)=>$it['label'], $slots[$key]['items']);
    $slots[$key]['text'] = implode(' / ', $labels);
  }
}

echo json_encode([
  'times'    => $times,
  'capillas' => $capillas,
  'slots'    => $slots
]);
