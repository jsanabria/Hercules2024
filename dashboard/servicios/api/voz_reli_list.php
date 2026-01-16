<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;
header('Content-Type: application/json; charset=utf-8');

$exp = isset($_GET['exp']) ? (int)$_GET['exp'] : 0;
if ($exp <= 0) { echo json_encode(['rows'=>[]]); exit; }

// Subconsulta para funeraria de paso=1 (última)
$sql = "
SELECT
  o.Norden,
  (SELECT ts.nombre  FROM sco_servicio_tipo ts  WHERE ts.Nservicio_tipo = o.servicio_tipo  LIMIT 1) AS servicio_tipo,
  o.servicio,
  o.proveedor,
  DATE_FORMAT(o.fecha_fin, '%Y-%m-%d') AS fecha,
  DATE_FORMAT(o.hora_fin,  '%H:%i')   AS hora,
  COALESCE(o.espera_cenizas,'N')      AS espera_cenizas,
  (SELECT p2.nombre FROM sco_proveedor p2 WHERE p2.Nproveedor = o.proveedor LIMIT 1) AS proveedor_nombre,
  (SELECT s.nombre  FROM sco_servicio  s  WHERE s.Nservicio   = o.servicio  LIMIT 1) AS servicio_nombre, 
  (SELECT archivo FROM sco_adjunto WHERE servicio = o.servicio LIMIT 0,1) as image 
FROM sco_orden o
WHERE o.expediente = ?
  AND o.paso = 5
ORDER BY o.fecha_fin, o.hora_fin
";

$rows = [];
if ($st = $mysqli->prepare($sql)) {
  $st->bind_param("i", $exp);
  $st->execute();
  $res = $st->get_result();
  while ($r = $res->fetch_assoc()) $rows[] = $r;
  $st->close();
}

echo json_encode(['rows'=>$rows], JSON_UNESCAPED_UNICODE);
