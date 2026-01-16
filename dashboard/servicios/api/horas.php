<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$q = "SELECT secuencia AS Nservicio, nombre FROM sco_servicio WHERE tipo = 'VELA' AND activo='S' ORDER BY secuencia, nombre;";
$res = $mysqli->query($q);

$out = [];
while ($row = $res->fetch_assoc()) {
  $out[] = $row;
}
echo json_encode($out);
