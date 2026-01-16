<?php
require_once 'includes/conexBD.php';

$username = isset($_REQUEST["username"]) ? trim($_REQUEST["username"]) : '';
$orden = isset($_REQUEST["orden"]) ? trim($_REQUEST["orden"]) : '';

if (empty($username) || empty($orden)) {
    echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong>Error: Datos incompletos.</strong></div>';
    exit;
}

$sql = "UPDATE sco_orden_salida SET estatus = 'NA', autoriza = ?, fecha_autoriza = NOW() WHERE Norden_salida = ?";
$stmt = $link->prepare($sql);

if ($stmt === false) {
    echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong>Error en la preparación de la consulta.</strong></div>';
    exit;
}

$stmt->bind_param("ss", $username, $orden);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span> <strong>Procesado No Autorizado</strong></div>';
    } else {
        echo '<div class="alert alert-warning"><span class="glyphicon glyphicon-info-sign"></span> <strong>Procesado. No se encontraron órdenes para actualizar.</strong></div>';
    }
} else {
    echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> <strong>Error al ejecutar la actualización.</strong></div>';
}

$stmt->close();

echo '<script type="text/JavaScript">setTimeout("location.href = \'../ScoOrdenSalidaView/' . $orden . '\';",1000);</script>';
$link->close(); 
?>