<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if (!$id) {
  echo json_encode(['ok'=>false,'msg'=>'Falta el ID del bloqueo.']); exit;
}

// 1) Tomar candado (opcional, por robustez)
$lockKey = "bloqueo_lock_by_id:".$id;
$lockRes = $mysqli->query("SELECT GET_LOCK('".$mysqli->real_escape_string($lockKey)."', 5) AS got");
if ($lockRes && ($rowLk = $lockRes->fetch_assoc()) && (int)$rowLk['got'] !== 1) {
  echo json_encode(['ok'=>false,'msg'=>'Sistema ocupado. Intente nuevamente.']); exit;
}

// 2) Leer el registro actual (para la bitácora)
$selectSql = "SELECT localidad, capilla, fecha_inicio, hora_inicio, fecha_fin, hora_fin, motivo
                FROM sco_reserva
               WHERE id = ?
               LIMIT 1";
$foundRow = null;

if ($sel = $mysqli->prepare($selectSql)) {
  $sel->bind_param("i", $id);
  $sel->execute();
  $res = $sel->get_result();
  if ($res && $res->num_rows === 1) {
    $foundRow = $res->fetch_assoc(); // array asociativo con las columnas solicitadas
  }
  $sel->close();
} else {
  // si falla el prepare del SELECT, liberamos candado y respondemos
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode(['ok'=>false,'msg'=>'Error al preparar SELECT: '.$mysqli->error]); exit;
}

// 3) Borrar por ID
$ok = false; $aff = 0; $err = '';
if ($stmt = $mysqli->prepare("DELETE FROM sco_reserva WHERE id=? LIMIT 1")) {
  $stmt->bind_param("i", $id);
  $ok = $stmt->execute();
  $aff = $stmt->affected_rows;
  $err = $stmt->error;
  $stmt->close();
} else {
  $err = $mysqli->error;
}

// 4) Liberar candado
$mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");

// 5) Responder al cliente
if ($ok && $aff > 0) {
  echo json_encode(['ok'=>true,'msg'=>'Bloqueo eliminado.']);
} else {
  echo json_encode(['ok'=>false,'msg'=>$err ? ('Error: '.$err) : 'No se encontró el bloqueo.']);
}

// 6) Bitácora (usa tu helper audittrail_try definido en la conexión)
if (function_exists('audittrail_try')) {
  if ($ok && $aff > 0) {
    // hubo eliminación: registra con oldvalue = datos del bloqueo eliminado
    audittrail_try($link, [
      'action'   => 'DESBLOQUEAR',
      'table'    => 'sco_reserva',
      'keyvalue' => $id,
      'oldvalue' => $foundRow ?: null, // si por alguna razón no se leyó, va null
      // opcionalmente puedes enviar detalles extra:
      // 'newvalue' => null,
    ]);
  } else {
    // intento sin efecto (no existía o error)
    audittrail_try($link, [
      'action'   => 'DESBLOQUEAR',
      'table'    => 'sco_reserva',
      'keyvalue' => $id,
      'oldvalue' => null,
      'newvalue' => 'Intento de desbloqueo sin efecto',
    ]);
  }
}
