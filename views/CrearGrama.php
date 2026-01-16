<?php

namespace PHPMaker2024\hercules;

// Page object
$CrearGrama = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// 1. Sanitizar entrada inicial
$id = (int)($_REQUEST["id"] ?? 0);
$pasconfirmar = $_REQUEST["confirmar"] ?? "N";
$sw = true;

// 2. Consulta de Parcela (PHPMaker 2024 compatible)
$idQuoted = QuotedValue($id, DataType::NUMBER);
$sql = "SELECT Nparcela, cedula, titular, contrato, seccion, modulo, sub_seccion, 
               parcela, boveda, ci_difunto, apellido1, apellido2, nombre1, nombre2 
        FROM sco_parcela WHERE Nparcela = $idQuoted";

$row = ExecuteRow($sql);

if (!$row) {
    die("Parcela no encontrada.");
}

// Limpieza de datos (PHP 8.1 compatible)
$seccion = trim($row["seccion"] ?? "");
$modulo = trim($row["modulo"] ?? "");
$sub_seccion = trim($row["sub_seccion"] ?? "");
$parcela = trim($row["parcela"] ?? "");
$ci_difunto = trim($row["ci_difunto"] ?? "");

// Construcción del nombre del beneficiario
$nombres = array_filter(array_map('trim', [$row["apellido1"], $row["apellido2"], $row["nombre1"], $row["nombre2"]]));
$nombre_beneficiario = implode(" ", $nombres);

// 3. Verificación de expedientes abiertos
if ($pasconfirmar == "N") {
    // Escapamos los valores para la búsqueda
    $qS = QuotedValue($seccion, DataType::STRING);
    $qM = QuotedValue($modulo, DataType::STRING);
    $qSub = QuotedValue($sub_seccion, DataType::STRING);
    $qP = QuotedValue($parcela, DataType::STRING);

    $sql_check = "SELECT Ngrama FROM sco_grama 
                  WHERE seccion = $qS AND modulo = $qM 
                  AND sub_seccion = $qSub AND parcela = $qP 
                  AND estatus IN ('E1','E2','E4')";
    
    if ($row_check = ExecuteRow($sql_check)) {
        ?>
        <div class="container py-5 text-center">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <h2 class="fw-light">Ubicación: <?php echo htmlspecialchars("$seccion-$modulo-$sub_seccion-$parcela"); ?></h2>
                    <p class="lead">El difunto <strong><?php echo htmlspecialchars($nombre_beneficiario); ?></strong> ya tiene expedientes abiertos.</p>
                    <div class="mt-4">
                        <a href="CrearGrama?id=<?php echo $id; ?>&confirmar=S" class="btn btn-primary shadow-sm">Aceptar y crear nuevo</a>
                        <a href="ViewFallecidosList?cmd=reset" class="btn btn-secondary shadow-sm">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $sw = false;
    }
}

if ($sw) {
    // 4. Obtener Tasa de Cambio
    /*
    $tasamonto = 0;
    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
    $urlTasa = "http://callcenter.interasist.com/ws/GetTasaCambio.php";
    $tasa_json = @file_get_contents($urlTasa, false, $ctx);
    
    if ($tasa_json) {
        $decoded_json = json_decode($tasa_json, true);
        $tasa_list = $decoded_json["listarTasa"] ?? [];
        $ultimo_elemento = end($tasa_list);
        $tasamonto = floatval($ultimo_elemento["tasa"] ?? 0);
    }
    */

    $tasamonto = 1.00;
    $moneda = "UE";
    $sql = "SELECT tasa FROM sco_tasa_usd WHERE moneda = '$moneda' ORDER BY fecha DESC, hora DESC LIMIT 1";
    if($row_tasa = ExecuteRow($sql)) {
        $tasamonto = floatval($row_tasa["tasa"]);
    }

    // 5. Buscar último solicitante (Seguridad manual)
    $qCiDifunto = QuotedValue($ci_difunto, DataType::STRING);
    $sql_sol = "SELECT ci_solicitante, solicitante, telefono1, telefono2, email 
                FROM sco_grama WHERE ci_difunto = $qCiDifunto ORDER BY Ngrama DESC LIMIT 1";
    $row_sol = ExecuteRow($sql_sol);
    
    // Preparar valores para la inserción
    $ci_sol = QuotedValue($row_sol["ci_solicitante"] ?? "", DataType::STRING);
    $sol = QuotedValue($row_sol["solicitante"] ?? "", DataType::STRING);
    $tel1 = QuotedValue($row_sol["telefono1"] ?? "", DataType::STRING);
    $tel2 = QuotedValue($row_sol["telefono2"] ?? "", DataType::STRING);
    $mail = QuotedValue($row_sol["email"] ?? "", DataType::STRING);
    $tasaQ = QuotedValue($tasamonto, DataType::NUMBER);
    $userQ = QuotedValue(CurrentUsername(), DataType::STRING);
    $fechaQ = QuotedValue(date("Y-m-d H:i:s"), DataType::STRING);
    $ceroQ = QuotedValue(0, DataType::NUMBER);

    // 6. Inserción mediante SELECT (Concatenación Segura 2024)
    $sql_ins = "INSERT INTO sco_grama (
                    ci_solicitante, solicitante, telefono1, telefono2, email, tasa, 
                    monto, monto_bs, 
                    contrato, seccion, modulo, sub_seccion, parcela, boveda, 
                    ci_difunto, apellido1, apellido2, nombre1, nombre2, 
                    estatus, fecha_registro, usuario_registro
                )
                SELECT 
                    $ci_sol, $sol, $tel1, $tel2, $mail, $tasaQ, 
                    $ceroQ, $ceroQ, 
                    contrato, seccion, modulo, sub_seccion, parcela, boveda, 
                    ci_difunto, apellido1, apellido2, nombre1, nombre2, 'E1', $fechaQ, $userQ
                FROM sco_parcela WHERE Nparcela = $idQuoted";
    
    Execute($sql_ins);

    // 7. Redirección al modo edición del nuevo registro
    $new_id = ExecuteScalar("SELECT LAST_INSERT_ID()");
    header("Location: ScoGramaEdit/$new_id?showdetail=");
    exit();
}
?>
<?= GetDebugMessage() ?>
