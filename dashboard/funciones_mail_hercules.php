<?php
/**
 * Función unificada para envío de correos en Hércules
 * Ubicación sugerida: /dashboard/funciones_mail_hercules.php
 */

// Ajusta esta ruta para que apunte a la carpeta vendor de tu proyecto PHPMaker
// Si este archivo está en /dashboard/, la ruta suele ser '../vendor/autoload.php'
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function EnviarCorreo($opciones) {
    $mail = new PHPMailer(true);

    try {
        // --- CONFIGURACIÓN SMTP ---
        $mail->isSMTP();
        $mail->Host       = 'cementeriodeleste.com.ve'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@cementeriodeleste.com.ve';
        $mail->Password   = 'Windeco2022'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // --- BYPASS DE SEGURIDAD PARA LARAGON ---
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // --- DESTINATARIOS Y CONTENIDO ---
        $mail->setFrom('info@cementeriodeleste.com.ve', 'Sistema Hercules');
        
        if (isset($opciones['to']) && !empty($opciones['to'])) {
            $mail->addAddress($opciones['to']);
        } else {
            throw new Exception("No se especificó destinatario (to).");
        }
        
        if (!empty($opciones['cc'])) $mail->addCC($opciones['cc']);
        if (!empty($opciones['bcc'])) $mail->addBCC($opciones['bcc']);

        // Adjuntos
        if (!empty($opciones['attachments']) && is_array($opciones['attachments'])) {
            foreach ($opciones['attachments'] as $file) {
                if (file_exists($file)) {
                    $mail->addAttachment($file);
                }
            }
        }

        $mail->isHTML(true);
        $mail->Subject = $opciones['subject'] ?? 'Sin Asunto';
        $mail->Body    = $opciones['body'] ?? '';

        return $mail->send();

    } catch (Exception $e) {
        // Como ya no estamos dentro de PHPMaker, usamos error_log de PHP
        error_log("Error enviando correo Hercules: " . $mail->ErrorInfo);
        return false;
    }
}