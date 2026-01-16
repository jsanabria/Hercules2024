<?php
// api/tipos_servicio.php
header('Content-Type: application/json; charset=utf-8');

require_once '../../includes/conexBD.php';
$mysqli = $link;

// Fuerza UTF-8
$mysqli->set_charset('utf8');

try {
  // Ajusta la tabla/campos si tu esquema difiere
  $sql = "SELECT Nservicio_tipo, nombre FROM sco_servicio_tipo 
  		WHERE Nservicio_tipo IN ('ATAU', 'COFR') ORDER BY nombre;";

  if (!($stmt = $mysqli->prepare($sql))) {
    echo json_encode([]); exit;
  }
  $stmt->execute();
  $res = $stmt->get_result();

  $rows = [];
  while ($row = $res->fetch_assoc()) {
    $rows[] = [
      'Nservicio_tipo' => $row['Nservicio_tipo'],
      'nombre'         => $row['nombre'],
    ];
  }
  $stmt->close();

  echo json_encode($rows, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
  echo json_encode([]);
}

