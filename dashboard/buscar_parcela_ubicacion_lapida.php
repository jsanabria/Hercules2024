<?php
include 'includes/conexBD.php';

// 1. Limpieza y normalización de la entrada
$ci_raw = $_REQUEST["ci_difunto"] ?? "";
$ci = strtoupper(trim($ci_raw));
$response = null;

if ($ci !== "") {
    // Limpieza de caracteres y prefijos para búsqueda en sco_parcela
    if (strpos($ci, ",")) $ci = substr($ci, 0, strpos($ci, ","));
    $ci_limpia = str_replace("-", "", $ci);
    
    // Si tiene prefijo V o E al inicio, se remueve para la tabla de parcelas
    if (in_array(substr($ci_limpia, 0, 1), ["V", "E", "J", "G", "M"])) {
        $ci_limpia = substr($ci_limpia, 1);
    }

    // --- PRIMERA BÚSQUEDA: sco_parcela (Datos de ubicación y contrato) ---
    $sql1 = "SELECT 
                CONCAT(RTRIM(LTRIM(IFNULL(nombre1, ''))), ' ', RTRIM(LTRIM(IFNULL(nombre2, ''))), ' ', 
                       RTRIM(LTRIM(IFNULL(apellido1, ''))), ' ', RTRIM(LTRIM(IFNULL(apellido2, '')))) AS nombre,  
                seccion, modulo, sub_seccion, parcela, boveda, contrato   
            FROM sco_parcela 
            WHERE RTRIM(LTRIM(ci_difunto)) = ? 
            LIMIT 1";

    $stmt = $link->prepare($sql1);
    $stmt->bind_param("s", $ci_limpia);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response = [
            "cedula"      => $ci_raw,
            "nombre"      => trim($row["nombre"]),
            "seccion"     => trim($row["seccion"]),
            "modulo"      => trim($row["modulo"]),
            "sub_seccion" => trim($row["sub_seccion"]),
            "parcela"     => trim($row["parcela"]),
            "boveda"      => trim($row["boveda"]),
            "contrato"    => trim($row["contrato"]),
            "alerta"      => ""
        ];

        // --- VALIDACIÓN DE DUPLICADOS EN LÁPIDAS ---
        $sql_check = "SELECT Nlapidas_registro FROM sco_lapidas_registro 
                      WHERE seccion = ? AND modulo = ? AND sub_seccion = ? AND parcela = ? 
                      LIMIT 1";
        
        $stmt_check = $link->prepare($sql_check);
        $stmt_check->bind_param("ssss", $response["seccion"], $response["modulo"], $response["sub_seccion"], $response["parcela"]);
        $stmt_check->execute();
        $res_check = $stmt_check->get_result();

        if ($res_check->num_rows > 0) {
            $response["alerta"] = "!!! ATENCION; YA UD. TIENE UN DISEÑO DE LAPIDAS AUTORIZADO!!!, ¿DESEA CREAR UNO NUEVO?";
        }
        $stmt_check->close();

    } else {
        // --- SEGUNDA BÚSQUEDA: sco_expediente (Si no hay parcela asignada aún) ---
        $sql2 = "SELECT cedula_fallecido, 
                    CONCAT(IFNULL(nombre_fallecido, ''), ' ', IFNULL(apellidos_fallecido, '')) AS nombre 
                FROM sco_expediente 
                WHERE cedula_fallecido = ? 
                LIMIT 1";
        
        $stmt2 = $link->prepare($sql2);
        $stmt2->bind_param("s", $ci_raw);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($row2 = $result2->fetch_assoc()) {
            $response = [
                "cedula"      => trim($row2["cedula_fallecido"]),
                "nombre"      => trim($row2["nombre"]),
                "seccion"     => "", "modulo" => "", "sub_seccion" => "", 
                "parcela"     => "", "boveda" => "", "contrato" => "",
                "alerta"      => "!!! DIFUNTO ENCONTRADO EN EXPEDIENTES, PERO SIN UBICACIÓN DE PARCELA !!!"
            ];
        }
        $stmt2->close();
    }
    $stmt->close();
}

$link->close();

// 4. Salida en formato JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
exit();