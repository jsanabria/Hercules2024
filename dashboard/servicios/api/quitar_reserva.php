<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;

header('Content-Type: application/json; charset=utf-8');

$norden = isset($_POST['norden']) ? (int)$_POST['norden'] : 0;
$hard   = isset($_POST['hard']) ? (int)$_POST['hard'] : 0; // 0=anular (soft), 1=delete (hard)

if (!$norden) {
  echo json_encode(['ok'=>false,'msg'=>'Falta el ID de la reserva (Norden).']); exit;
}

// 1) Candado para evitar carreras
$lockKey = "reserva_lock_by_id:".$norden;
$lockRes = $mysqli->query("SELECT GET_LOCK('".$mysqli->real_escape_string($lockKey)."', 5) AS got");
if ($lockRes && ($rowLk = $lockRes->fetch_assoc()) && (int)$rowLk['got'] !== 1) {
  echo json_encode(['ok'=>false,'msg'=>'Sistema ocupado. Intente nuevamente.']); exit;
}

// 2) SELECT previo (para bitácora)
$selectSql = "SELECT Norden, expediente, servicio_tipo, servicio, fecha_inicio, hora_inicio, horas, fecha_fin, hora_fin
                FROM sco_orden
               WHERE Norden = ?
               LIMIT 1";
$beforeRow = null;

if ($sel = $mysqli->prepare($selectSql)) {
  $sel->bind_param("i", $norden);
  $sel->execute();
  $res = $sel->get_result();
  if ($res && $res->num_rows === 1) {
    $beforeRow = $res->fetch_assoc();
  }
  $sel->close();
} else {
  $mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");
  echo json_encode(['ok'=>false,'msg'=>'Error al preparar SELECT: '.$mysqli->error]); exit;
}

// 3) Operación: soft (anular) o hard (delete)
$ok = false; $aff = 0; $err = '';

if ($hard === 1) {
  // DELETE real
  if ($stmt = $mysqli->prepare("DELETE FROM sco_orden WHERE Norden=? LIMIT 1")) {
    $stmt->bind_param("i", $norden);
    $ok  = $stmt->execute();
    $aff = $stmt->affected_rows;
    $err = $stmt->error;
    $stmt->close();
  } else {
    $err = $mysqli->error;
  }
} else {
  // Soft: marcar anulada='S'
  if ($stmt = $mysqli->prepare("UPDATE sco_orden SET anulada='S' WHERE Norden=? LIMIT 1")) {
    $stmt->bind_param("i", $norden);
    $ok  = $stmt->execute();
    $aff = $stmt->affected_rows;
    $err = $stmt->error;
    $stmt->close();
  } else {
    $err = $mysqli->error;
  }
}

// 4) Liberar candado
$mysqli->query("DO RELEASE_LOCK('".$mysqli->real_escape_string($lockKey)."')");

// 5) Respuesta al cliente
if ($ok && $aff > 0) {
  echo json_encode(['ok'=>true,'msg'=> $hard ? 'Reserva eliminada.' : 'Reserva anulada.']);
} else {
  echo json_encode(['ok'=>false,'msg'=>$err ? ('Error: '.$err) : 'No se encontró la reserva o ya estaba en ese estado.']);
}

// 6) Bitácora
if (function_exists('audittrail_try')) {
  // Define acción según modo
  $action = ($hard === 1) ? 'BORRAR_RESERVA' : 'ANULAR_RESERVA';

  if ($ok && $aff > 0) {
    // Operación efectiva: registramos con oldvalue = SELECT previo
    $payload = [
      'action'   => $action,
      'table'    => 'sco_orden',
      'keyvalue' => $norden,
      'oldvalue' => $beforeRow ?: null,
    ];

    // En soft, guarda el cambio explícito
    if ($hard !== 1) {
      $payload['newvalue'] = ['anulada' => 'S'];
    }

    audittrail_try($link, $payload);
  } else {
    // Intento sin efecto (id inexistente o sin cambios)
    audittrail_try($link, [
      'action'   => $action,
      'table'    => 'sco_orden',
      'keyvalue' => $norden,
      'oldvalue' => $beforeRow ?: null,
      'newvalue' => 'Intento sin cambios',
    ]);
  }
}
