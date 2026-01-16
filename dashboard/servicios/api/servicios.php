<?php
// api/servicios_por_tipo.php
header('Content-Type: application/json; charset=utf-8');

require_once '../../includes/conexBD.php';
$mysqli = $link;
$mysqli->set_charset('utf8');

$tipo = $_GET['tipo'] ?? '';
if ($tipo === '') {
  echo json_encode([]); exit;
}

try {
  // Consulta pedida: SELECT Nservicio, nombre FROM sco_servicio WHERE tipo = ? ORDER BY nombre
  $sql = "SELECT Nservicio, nombre
            FROM sco_servicio
           WHERE tipo = ?
        ORDER BY nombre";

  if (!($stmt = $mysqli->prepare($sql))) {
    echo json_encode([]); exit;
  }
  $stmt->bind_param("s", $tipo);
  $stmt->execute();
  $res = $stmt->get_result();

  $rows = [];
  while ($row = $res->fetch_assoc()) {
    $rows[] = [
      'Nservicio' => $row['Nservicio'],
      'nombre'    => $row['nombre'],
    ];
  }
  $stmt->close();

  echo json_encode($rows, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
  echo json_encode([]);
}
