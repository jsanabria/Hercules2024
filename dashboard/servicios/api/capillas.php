<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$localidad = $_GET['localidad'] ?? '';
if ($localidad === '') { echo '[]'; exit; }

$stmt = $mysqli->prepare("SELECT Nservicio, nombre FROM sco_servicio WHERE tipo = ? AND activo='S' ORDER BY secuencia, nombre;");
$stmt->bind_param("s", $localidad);
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) {
  $out[] = $row; // {Nservicio, nombre}
}
echo json_encode($out);
