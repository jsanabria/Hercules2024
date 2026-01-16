<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;
header('Content-Type: application/json; charset=utf-8');

$id = $_POST['id'] ?? '';
if (!$id || !ctype_digit($id)) {
  echo json_encode(['ok'=>false, 'msg'=>'ID inválido']); exit;
}

$stmt = $mysqli->prepare("DELETE FROM sco_orden WHERE Norden=? LIMIT 1");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
  echo json_encode(['ok'=>false, 'msg'=>'Error al eliminar: '.$stmt->error]);
  exit;
}

$auditMsg = sprintf("Eliminado servicio ID %d", $id);
if (function_exists('audittrail_try')) {
  audittrail_try($mysqli, ['action'=>'DELETE','table'=>'sco_orden','keyvalue'=>$id,'newvalue'=>$auditMsg]);
}

echo json_encode(['ok'=>true,'msg'=>'Servicio eliminado']);
