<?php
include_once "includes/conexBD.php"; 

$userLevel = $_POST["level"] ?? "";
$accion    = $_POST["accion"] ?? "";

$response = ["status" => "error", "message" => "Solicitud no válida"];

if ($userLevel !== "") {
    // Definimos el código según la acción
    $codigoPermiso = ($accion === "validar_reverso") ? "100" : "200";
    $mensajeError  = ($accion === "validar_reverso") 
        ? "No autorizado (Cód: 100) para REVERTIR a compra." 
        : "No autorizado (Cód: 200) para ANULAR.";

    $sql = "SELECT b.codigo 
            FROM sco_grupo_funciones AS a 
            JOIN sco_funciones AS b ON b.Nfuncion = a.funcion 
            WHERE a.grupo = ? AND b.codigo = ? 
            LIMIT 1";
    
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("ss", $userLevel, $codigoPermiso);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_assoc()) {
            $response = ["status" => "success", "message" => "Permiso concedido"];
        } else {
            $response = ["status" => "denied", "message" => $mensajeError];
        }
        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>