<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;
header('Content-Type: application/json; charset=utf-8');

// ===== Inputs =====
$expediente     = $_POST['expediente']     ?? '';
$tipo_servicio  = $_POST['tipo_servicio']  ?? '';
$servicio       = $_POST['servicio']       ?? '';
$proveedor      = $_POST['proveedor']      ?? ''; // id proveedor del servicio (usa tu UI)
$funeraria      = $_POST['funeraria']      ?? ''; // si deseas guardar funeraria asociada
$fecha_ser      = $_POST['fecha_ser']      ?? '';
$hora_ser       = $_POST['hora_ser']       ?? '';
$espera_cenizas = ($_POST['espera_cenizas'] ?? 'N') === 'S' ? 'S' : 'N';
$user           = $_POST['user']           ?? '';
$force          = isset($_POST['force']) ? (int)$_POST['force'] : 0;

if ($expediente === '' || $tipo_servicio === '' || $servicio === '' || $fecha_ser === '' || $hora_ser === '') {
  echo json_encode(['ok'=>false,'msg'=>'Datos insuficientes.']); exit;
}

// normaliza fecha/hora
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_ser) || !preg_match('/^\d{2}:\d{2}$/', $hora_ser)) {
  echo json_encode(['ok'=>false,'msg'=>'Formato de fecha u hora inválido.']); exit;
}

// ===== validaciones =====

// 1) Obtener funeraria paso=1
$funerariaPaso1 = null;
if ($stmt = $mysqli->prepare("SELECT proveedor FROM sco_orden WHERE expediente = ? AND paso = 1 LIMIT 1")) {
  $stmt->bind_param("s", $expediente);
  $stmt->execute();
  $stmt->bind_result($fun);
  if ($stmt->fetch()) $funerariaPaso1 = $fun;
  $stmt->close();
}

// 2) máximo de servicios (paso=2) por expediente (<=1 según regla)
$cantPaso2 = 0;
if ($stmt = $mysqli->prepare("SELECT COUNT(paso) AS cantidad FROM sco_orden WHERE expediente = ? AND paso = 2")) {
  $stmt->bind_param("s", $expediente);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($row = $res->fetch_assoc()) $cantPaso2 = (int)$row['cantidad'];
  $stmt->close();
}
if ($cantPaso2 > 1) {
  echo json_encode(['ok'=>false,'msg'=>'YA ALCANZÓ EL MÁXIMO DE SERVICIOS (paso 2) PARA EL EXPEDIENTE']); exit;
}

// 3) expediente activo
$estatus = null;
if ($stmt = $mysqli->prepare("SELECT estatus FROM sco_expediente WHERE Nexpediente = ?")) {
  $stmt->bind_param("s", $expediente);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($row = $res->fetch_assoc()) $estatus = $row['estatus'] ?? null;
  $stmt->close();
}
if ($estatus === '7') {
  echo json_encode(['ok'=>false,'msg'=>'EL EXPEDIENTE ESTÁ ANULADO']); exit;
}

// 4) no duplicar servicio (mismo servicio en paso=2)
$dup = false;
if ($stmt = $mysqli->prepare("SELECT Norden FROM sco_orden WHERE expediente = ? AND paso = '2' AND servicio = ? LIMIT 1")) {
  $stmt->bind_param("ss", $expediente, $servicio);
  $stmt->execute();
  $stmt->store_result();
  $dup = ($stmt->num_rows > 0);
  $stmt->close();
}
if ($dup) {
  echo json_encode(['ok'=>false,'msg'=>'HAY UN SERVICIO DE ESTE TIPO CREADO; VERIFIQUE.']); exit;
}

// 5) capacidad por bloque (para CREM/INHU), leyendo sco_parametro (019.valor2/valor4) y sco_bloque_horario
$xx_cant = null;
$x_field = ($tipo_servicio === 'CREM') ? 'valor2' : 'valor4';
if ($stmt = $mysqli->prepare("SELECT $x_field AS cantidad FROM sco_parametro WHERE codigo = '019'")) {
  $stmt->execute();
  $res = $stmt->get_result();
  if ($row = $res->fetch_assoc()) $xx_cant = (int)$row['cantidad'];
  $stmt->close();
}

$bloques = []; // 'HH:MM' => bloque
if ($stmt = $mysqli->prepare("SELECT hora, bloque FROM sco_bloque_horario WHERE servicio_tipo = ?")) {
  $stmt->bind_param("s", $tipo_servicio);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_assoc()) { $bloques[$row['hora']] = $row['bloque']; }
  $stmt->close();
}

$bloqueSel = $bloques[$hora_ser] ?? null;
if ($tipo_servicio !== 'EXHU') {
  if ($bloqueSel === null) {
    echo json_encode(['ok'=>false,'msg'=>'HORA DE SERVICIO NO VÁLIDA O NO CONFIGURADA.']); exit;
  }
}

// cuántos en el mismo bloque ya hay ese día
$xy_cant = 0;
if ($stmt = $mysqli->prepare("SELECT DATE_FORMAT(hora_fin,'%H:%i') AS hora FROM sco_orden WHERE paso = 2 AND servicio_tipo = ? AND DATE_FORMAT(fecha_fin,'%Y-%m-%d') = ?")) {
  $stmt->bind_param("ss", $tipo_servicio, $fecha_ser);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_assoc()) {
    $h = $row['hora'];
    if (isset($bloques[$h]) && $bloques[$h] == $bloqueSel) $xy_cant++;
  }
  $stmt->close();
}
if ($xx_cant !== null && $xy_cant >= $xx_cant) {
  echo json_encode(['ok'=>false,'msg'=>'SOBREPASÓ EL CUPO DEL BLOQUE PARA LA FECHA/HORA SELECCIONADA.']); exit;
}

// 6) capacidad diaria de cremación (código 051.valor1)
if ($tipo_servicio === 'CREM') {
  $CantTotalPizarra = null;
  if ($stmt = $mysqli->prepare("SELECT valor1 AS cantidad FROM sco_parametro WHERE codigo = '051'")) {
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) $CantTotalPizarra = (int)$row['cantidad'];
    $stmt->close();
  }
  if ($CantTotalPizarra !== null) {
    $CantEnPizarra = 0;
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) AS cantidad FROM sco_orden WHERE paso = 2 AND servicio_tipo = ? AND DATE_FORMAT(fecha_fin,'%Y-%m-%d') = ?")) {
      $stmt->bind_param("ss", $tipo_servicio, $fecha_ser);
      $stmt->execute();
      $res = $stmt->get_result();
      if ($row = $res->fetch_assoc()) $CantEnPizarra = (int)$row['cantidad'];
      $stmt->close();
    }
    if ($CantEnPizarra >= $CantTotalPizarra) {
      echo json_encode(['ok'=>false,'msg'=>'SOBREPASÓ EL CUPO MÁXIMO DIARIO PARA CREMACIÓN.']); exit;
    }
  }
}

// 7) Si la fecha/hora del servicio < fin de velación (paso=1) => advertir (requiere force=1)
$hayAnterior = false;
if ($stmt = $mysqli->prepare("
  SELECT 1
    FROM sco_orden
   WHERE expediente = ?
     AND paso = '1'
     AND STR_TO_DATE(CONCAT(DATE_FORMAT(fecha_fin,'%Y-%m-%d'),' ',DATE_FORMAT(hora_fin,'%H:%i:%s')), '%Y-%m-%d %H:%i:%s')
         > STR_TO_DATE(CONCAT(?, ' ', ?), '%Y-%m-%d %H:%i')
  ORDER BY fecha_fin DESC, hora_fin DESC
  LIMIT 1
")) {
  $stmt->bind_param("sss", $expediente, $fecha_ser, $hora_ser);
  $stmt->execute();
  $stmt->store_result();
  $hayAnterior = ($stmt->num_rows > 0);
  $stmt->close();
}
if ($hayAnterior && !$force) {
  echo json_encode([
    'ok'   => false,
    'code' => 'EARLIER_THAN_VELACION',
    'msg'  => 'La fecha/hora del servicio es ANTERIOR a la fecha/hora de culminación de la velación. ¿Desea continuar?'
  ]);
  exit;
}

// ===== Inserción principal (paso=2) =====
$costo = 0.0; $total = 0.0;
$fecha_fin_datetime = $fecha_ser . ' 00:00:00';

if ($stmt = $mysqli->prepare("
  INSERT INTO sco_orden
      (expediente, servicio_tipo, servicio, proveedor, paso, capilla, cantidad,
       costo, total, nota, fecha_fin, hora_fin, anulada, user_registra, fecha_registro, espera_cenizas)
  VALUES(?, ?, ?, ?, '2', ?, '1', ?, ?, '', ?, ?, 'N', ?, NOW(), ?)
")) {
  // Nota: uso $funeraria en 'capilla' solo si te interesa almacenarla allí. Ajusta según tu esquema.
  $stmt->bind_param("sssssddssss",
    $expediente, $tipo_servicio, $servicio, $proveedor, $funeraria,
    $costo, $total, $fecha_fin_datetime, $hora_ser, $user, $espera_cenizas
  );
  $ok = $stmt->execute();
  $err = $stmt->error;
  $norden = $ok ? $mysqli->insert_id : null;
  $stmt->close();
} else {
  echo json_encode(['ok'=>false,'msg'=>'Error preparando INSERT: '.$mysqli->error]); exit;
}

// audit trail (si tienes la función)
if (function_exists('audittrail_try')) {
  audittrail_try($mysqli, [
    'action'   => 'INSERT',
    'table'    => 'sco_orden',
    'field'    => 'paso',
    'keyvalue' => $norden,
    'oldvalue' => null,
    'newvalue' => json_encode([
      'expediente'=>$expediente,'servicio_tipo'=>$tipo_servicio,'servicio'=>$servicio,
      'proveedor'=>$proveedor,'paso'=>2,'fecha'=>$fecha_ser,'hora'=>$hora_ser,
      'espera_cenizas'=>$espera_cenizas,'user'=>$user
    ], JSON_UNESCAPED_UNICODE)
  ]);
}

echo json_encode([
  'ok'   => $ok ? true : false,
  'msg'  => $ok ? 'Servicio agregado.' : ('Error al insertar: '.$err),
  'norden' => $norden
]);
