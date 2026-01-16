<?php
/**
 * Remanufactura de enviar_email_boceto_lapidas.php
 * Salida optimizada en formato JSON e integración con PHPMailer.
 */

// Cabecera para respuesta JSON
header('Content-Type: application/json; charset=utf-8');

include 'includes/conexBD.php'; 
require_once 'funciones_mail_hercules.php'; 

$id  = $_REQUEST["xid"] ?? 0;
$ida = $_REQUEST["xida"] ?? 0;

$response = [
    "status"  => "error",
    "message" => "Ocurrió un error inesperado."
];

if ($id == 0 || $ida == 0) {
    $response["message"] = "Parámetros insuficientes (xid, xida).";
    echo json_encode($response);
    exit;
}

try {
    // 1. Obtención de datos del registro (MySQLi)
    $sql_reg = "SELECT solicitante, contrato, email, seccion, modulo, sub_seccion, parcela, boveda  
                FROM sco_lapidas_registro 
                WHERE Nlapidas_registro = ?";
    
    $stmt_reg = $link->prepare($sql_reg);
    $stmt_reg->bind_param("i", $id);
    $stmt_reg->execute();
    $res_reg = $stmt_reg->get_result();

    if ($row = $res_reg->fetch_assoc()) {
        $email = trim($row["email"]);
        $ubicacion = "{$row['seccion']}-{$row['modulo']}-{$row['sub_seccion']}-{$row['parcela']}-{$row['boveda']}";

        // 2. Consulta del archivo adjunto
        $sql_adj = "SELECT archivo FROM sco_lapidas_adjunto WHERE Nlapidas_adjunto = ?";
        $stmt_adj = $link->prepare($sql_adj);
        $stmt_adj->bind_param("i", $ida);
        $stmt_adj->execute();
        $res_adj = $stmt_adj->get_result();
        
        $archivo_path = "";
        if ($row_adj = $res_adj->fetch_assoc()) {
            $archivo_path = "carpetacarga/" . trim($row_adj["archivo"]);
        }
        $stmt_adj->close();

        // 3. Configuración del envío
        $opciones_mail = [
            'to'          => $email,
            'subject'     => "Cementerio Del Este - Envío de Boceto Ticket #$id",
            'body'        => "Estimado(a) {$row['solicitante']}, se adjunta el boceto para la parcela $ubicacion.",
            'attachments' => [ $archivo_path ]
        ];

        if (EnviarCorreo($opciones_mail)) {
            $response["status"] = "success";
            $response["message"] = "Correo Enviado Exitosamente";
        } else {
            $response["message"] = "No se pudo enviar el correo a través del servidor SMTP.";
        }

    } else {
        $response["message"] = "No se encontró el registro de lápida indicado.";
    }
    $stmt_reg->close();

} catch (Exception $e) {
    $response["message"] = "Error en el servidor: " . $e->getMessage();
}

$link->close();
echo json_encode($response);
exit;