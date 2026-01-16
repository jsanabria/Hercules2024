<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../../includes/conexBD.php';
$mysqli = $link;
$mysqli->set_charset('utf8mb4');

function jexit($ok, $msg) {
  echo json_encode(['ok' => $ok, 'msg' => $msg], JSON_UNESCAPED_UNICODE);
  exit;
}

try {
  // Entrada
  $expediente     = isset($_POST['expediente'])    ? trim($_POST['expediente'])    : '';
  $tipo_servicio  = isset($_POST['tipo_servicio']) ? trim($_POST['tipo_servicio']) : '';
  $servicio       = isset($_POST['servicio'])      ? trim($_POST['servicio'])      : '';
  $user           = isset($_POST['user'])          ? trim($_POST['user'])          : '';

  if ($expediente === '' || $tipo_servicio === '' || $servicio === '') {
    jexit(false, 'Faltan campos obligatorios (Expediente, Tipo o Servicio).');
  }

  $expediente_i    = (int)$expediente;
  $tipo_servicio_i = $tipo_servicio;
  $servicio_i      = $servicio;

  // Validar expediente activo
  $stmt = $mysqli->prepare("SELECT estatus FROM sco_expediente WHERE Nexpediente = ?");
  $stmt->bind_param('i', $expediente_i);
  $stmt->execute();
  $stmt->bind_result($est);
  if ($stmt->fetch()) {
    if ($est === '7') { $stmt->close(); jexit(false, 'EL EXPEDIENTE ESTA ANULADO'); }
  } else {
    $stmt->close(); jexit(false, 'Expediente no encontrado');
  }
  $stmt->close();

  // No duplicar por tipo en paso=3
  $stmt = $mysqli->prepare("
    SELECT 1 FROM sco_orden
    WHERE expediente = ? AND paso = 3 AND servicio_tipo = ? LIMIT 1
  ");
  $stmt->bind_param('ii', $expediente_i, $tipo_servicio_i);
  $stmt->execute(); $stmt->store_result();
  if ($stmt->num_rows > 0) { $stmt->close(); jexit(false, 'YA SE ASIGNO ATAUD Y COFRE; VERIFIQUE!'); }
  $stmt->close();

  // No duplicar mismo servicio en paso=3
  $stmt = $mysqli->prepare("
    SELECT 1 FROM sco_orden
    WHERE expediente = ? AND paso = 3 AND servicio = ? LIMIT 1
  ");
  $stmt->bind_param('ii', $expediente_i, $servicio_i);
  $stmt->execute(); $stmt->store_result();
  if ($stmt->num_rows > 0) { $stmt->close(); jexit(false, 'HAY UN SERVICIO DE ESTE TIPO CREADO; VERIFIQUE!'); }
  $stmt->close();

  // Transacción
  $mysqli->begin_transaction();

  // Insert sco_orden (proveedor=1, paso=3)
  $proveedor_i = 1; $cantidad_i = 1; $costo_d = 0.0; $total_d = 0.0; $nota_s = '';
  $stmt = $mysqli->prepare("
    INSERT INTO sco_orden
      (expediente, servicio_tipo, servicio, proveedor, paso, cantidad, costo, total, nota, anulada, user_registra, fecha_registro)
    VALUES (?, ?, ?, ?, 3, ?, ?, ?, ?, 'N', ?, NOW())
  ");
  $stmt->bind_param('issiiddss',
    $expediente_i, $tipo_servicio_i, $servicio_i, $proveedor_i,
    $cantidad_i, $costo_d, $total_d, $nota_s, $user
  );
  if (!$stmt->execute()) { throw new Exception('Error al insertar en sco_orden: ' . $stmt->error); }
  $norden = $mysqli->insert_id;
  $stmt->close();

  // Audit con audittrail_try (si existe)
  if (function_exists('audittrail_try')) {
    audittrail_try($mysqli, [
      'action'   => 'INSERT',
      'table'    => 'sco_orden',
      'field'    => 'paso',
      'keyvalue' => $norden,
      'oldvalue' => null,
      'newvalue' => json_encode([
        'expediente'    => $expediente_i,
        'servicio_tipo' => $tipo_servicio_i,
        'servicio'      => $servicio_i,
        'proveedor'     => 1,
        'paso'          => 3,
        'user'          => $user
      ], JSON_UNESCAPED_UNICODE)
    ]);
  }

  // Movimiento EXOU
  $nota_mov = "SALIDA AUTOMATICA POR CREACION DE ORDEN EN Exp.: $expediente_i";
  $stmt = $mysqli->prepare("
    INSERT INTO sco_entrada_salida
      (tipo_doc, proveedor, clasificacion, documento, fecha, nota, username, monto, registro)
    VALUES ('EXOU', -1, 'EXPE', ?, NOW(), ?, ?, 0, NOW())
  ");
  $stmt->bind_param('iss', $expediente_i, $nota_mov, $user);
  if (!$stmt->execute()) { throw new Exception('Error al insertar en sco_entrada_salida: ' . $stmt->error); }
  $idSali = $stmt->insert_id;
  $stmt->close();

  // Detalle: artículo = servicio, cantidad = -1
  $cantidad_det = -1; $costo_det = 0.0; $total_det = 0.0;
  $stmt = $mysqli->prepare("
    INSERT INTO sco_entrada_salida_detalle
      (entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
    VALUES (?, 'EXOU', -1, ?, ?, ?, ?)
  ");
  $stmt->bind_param('iiidd', $idSali, $servicio_i, $cantidad_det, $costo_det, $total_det);
  if (!$stmt->execute()) { throw new Exception('Error al insertar en sco_entrada_salida_detalle: ' . $stmt->error); }
  $stmt->close();

  // Recalcular costos
  $stmt = $mysqli->prepare("SELECT IFNULL(SUM(total),0) FROM sco_orden WHERE expediente = ?");
  $stmt->bind_param('i', $expediente_i);
  $stmt->execute(); $stmt->bind_result($costo_total); $stmt->fetch(); $stmt->close();

  $stmt = $mysqli->prepare("UPDATE sco_expediente SET costos = ? WHERE Nexpediente = ?");
  $stmt->bind_param('di', $costo_total, $expediente_i);
  if (!$stmt->execute()) { throw new Exception('Error al actualizar sco_expediente: ' . $stmt->error); }
  $stmt->close();

  $mysqli->commit();
  jexit(true, 'SE AGREGO EXITOSAMENTE EL SERVICIO');

} catch (Throwable $e) {
  @ $mysqli->rollback();
  jexit(false, 'Error: ' . $e->getMessage());
}
