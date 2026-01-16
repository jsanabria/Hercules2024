<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

// Para simplificar: anula todas las reservas del expediente que caen en ese rango exacto
$expediente = (int)($_POST['expediente'] ?? 0);
$localidad  = $_POST['localidad'] ?? '';
$capilla    = $_POST['capilla'] ?? '';
$fecha      = $_POST['fecha'] ?? '';
$timeIni    = $_POST['time_ini'] ?? '';
$timeFin    = $_POST['time_fin'] ?? '';

if (!$expediente || !$localidad || !$capilla) { echo json_encode(['ok'=>false]); exit; }

$upd = "UPDATE sco_orden 
           SET anulada='S' 
         WHERE expediente=?
           AND servicio_tipo=?
           AND servicio=?
           AND fecha_inicio=CONCAT(?, ' ', ?)
           AND fecha_fin=CONCAT(?, ' ', ?)";
$stmt = $mysqli->prepare($upd);
$stmt->bind_param("issssss", $expediente, $localidad, $capilla, $fecha, $timeIni, $fecha, $timeFin);
$ok = $stmt->execute();
$stmt->close();

echo json_encode(['ok'=>$ok?true:false]);
