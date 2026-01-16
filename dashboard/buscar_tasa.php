<?php
include 'includes/conexBD.php'; // Se asume que define la variable $link de tipo mysqli

// 1. Limpieza y preparación de la entrada
$moneda_raw = $_REQUEST["moneda"] ?? "";
$moneda = strtoupper(trim($moneda_raw));

// Inicializamos la respuesta con valores por defecto
$response = [
    "status" => "success",
    "tasa" => 1.00
];

if ($moneda !== "") {
    // Lógica para Bolívares (Tasa siempre 1)
    if (substr($moneda, 0, 2) == "BS") {
        $response["tasa"] = 1.00;
    } else {
        // --- CONSULTA A LA BASE DE DATOS ---
        $sql = "SELECT tasa FROM sco_tasa_usd WHERE moneda = ? ORDER BY fecha DESC, hora DESC LIMIT 1";
        
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $moneda);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Obtenemos el valor numérico
                $response["tasa"] = floatval($row["tasa"]);
            } else {
                // Si no se encuentra la moneda, se asume 1 y se puede indicar el error
                $response["status"] = "not_found";
                $response["tasa"] = 1.00;
            }
            $stmt->close();
        } else {
            $response["status"] = "error";
            $response["message"] = "Error en la preparación de la consulta";
        }
    }
} else {
    $response["status"] = "error";
    $response["message"] = "Moneda no especificada";
}

$link->close();

// 2. Salida siempre en formato JSON
// Nota: Ya no usamos str_replace(".", ",", ...) porque el JSON debe manejar 
// el punto decimal estándar. El formato visual se hace en el Frontend.
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
exit();