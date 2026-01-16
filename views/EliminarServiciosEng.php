<?php

namespace PHPMaker2024\hercules;

// Page object
$EliminarServiciosEng = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$expediente = $_REQUEST["expediente"];
$user = $_REQUEST["user"]; 
$accion = $_REQUEST["accion"];

switch($accion) {
case 1: 
    echo '<div class="alert alert-success" role="alert">Proceso Realizado</div>';
    break;
case 2: 
    echo '<div class="alert alert-danger" role="alert">Proceso no Realizado. !!! Expediente ' . $expediente . ' y sus servicios no se pueden apagar !!!</div>';
    break;
default:
    echo '<div class="alert alert-danger" role="alert">Proceso no Realizado. !!! Expediente ' . $expediente . ' no existe !!!</div>';
    break;
}

echo '<br><button type="button" class="btn btn-outline-primary" onclick="js:window.location.href = \'ScoExpedienteList\';">Ir a Expedientes</button>';
?>
<?= GetDebugMessage() ?>
