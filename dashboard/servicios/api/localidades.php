<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$q = "SELECT Nservicio_tipo, nombre FROM sco_servicio_tipo WHERE SUBSTRING(Nservicio_tipo,1,3)='CAP' ORDER BY nombre";
$res = $mysqli->query($q);

$out = [];
while ($row = $res->fetch_assoc()) {
  $out[] = $row;
}
echo json_encode($out);
