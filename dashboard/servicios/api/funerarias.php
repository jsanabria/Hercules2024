<?php
// api/proveedores.php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q === '') { echo json_encode([]); exit; }

$sql = "
  SELECT Nproveedor, nombre
    FROM sco_proveedor
   WHERE tipo_proveedor = 'FUNERARIAS'
     AND nombre LIKE CONCAT('%', ?, '%')
ORDER BY nombre
   LIMIT 15
";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $q);
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($row = $res->fetch_assoc()) {
  $out[] = [
    'Nproveedor' => (int)$row['Nproveedor'],
    'nombre'     => $row['nombre'],
  ];
}
$stmt->close();

echo json_encode($out);
