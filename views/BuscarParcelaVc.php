<?php

namespace PHPMaker2024\hercules;

// Page object
$BuscarParcelaVc = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// BuscarParcelaVc.php
$buscar     = trim($_REQUEST["buscar"] ?? "");
$seccion    = trim($_REQUEST["seccion"] ?? "");
$modulo     = trim($_REQUEST["modulo"] ?? "");
$subseccion = trim($_REQUEST["subseccion"] ?? "");
$parcela    = trim($_REQUEST["parcela"] ?? "");

$response = ["status" => "error", "item1" => "", "item2" => ""];

if (!empty($parcela)) {
    // Definimos la columna según el tipo de búsqueda
    $columna = ($buscar == "cedula") ? "nacionalidad, cedula" : "contrato";
    
    $sql = "SELECT DISTINCT $columna, titular FROM sco_parcela 
            WHERE LTRIM(seccion) = '$seccion' 
            AND LTRIM(modulo) = '$modulo' 
            AND LTRIM(sub_seccion) = '$subseccion' 
            AND LTRIM(parcela) = '$parcela'";
    
    if ($row = ExecuteRow($sql)) {
        $response["status"] = "success";
        if ($buscar == "cedula") {
            $response["item1"] = trim($row["nacionalidad"]) . "-" . trim($row["cedula"]);
        } else {
            $response["item1"] = trim($row["contrato"]);
        }
        $response["item2"] = trim($row["titular"]);
    }
}

ob_clean();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
exit;
?>
<?= GetDebugMessage() ?>
