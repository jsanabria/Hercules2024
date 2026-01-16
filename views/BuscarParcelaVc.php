<?php

namespace PHPMaker2024\hercules;

// Page object
$BuscarParcelaVc = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Limpieza de entradas
$buscar     = trim($_REQUEST["buscar"] ?? "");
$seccion    = trim($_REQUEST["seccion"] ?? "");
$modulo     = trim($_REQUEST["modulo"] ?? "");
$subseccion = trim($_REQUEST["subseccion"] ?? "");
$parcela    = trim($_REQUEST["parcela"] ?? "");

$response = [
    "status" => "error",
    "item1" => "",
    "item2" => ""
];

// Solo proceder si hay datos
if (!empty($parcela)) {
    switch($buscar) {
        case "cedula":
            $sql = "SELECT DISTINCT nacionalidad, cedula, titular FROM sco_parcela 
                    WHERE LTRIM(seccion) = '$seccion' AND LTRIM(modulo) = '$modulo' 
                    AND LTRIM(sub_seccion) = '$subseccion' AND LTRIM(parcela) = '$parcela'";
            
            if($row = ExecuteRow($sql)) {
                $response["status"] = "success";
                $response["item1"]  = trim($row["nacionalidad"]) . "-" . trim($row["cedula"]);
                $response["item2"]  = trim($row["titular"]);
            }
            break;

        case "contrato":
            $sql = "SELECT DISTINCT contrato, titular FROM sco_parcela 
                    WHERE LTRIM(seccion) = '$seccion' AND LTRIM(modulo) = '$modulo' 
                    AND LTRIM(sub_seccion) = '$subseccion' AND LTRIM(parcela) = '$parcela'";
            
            if($row = ExecuteRow($sql)) {
                $response["status"] = "success";
                $response["item1"]  = trim($row["contrato"]);
                $response["item2"]  = trim($row["titular"]);
            }
            break;
    }
}

// Limpiar cualquier salida previa y enviar JSON
ob_clean(); 
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
?>
<?= GetDebugMessage() ?>
