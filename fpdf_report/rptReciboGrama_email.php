<?php
// 1. Inclusión de librerías y dependencias
require('rcs/fpdf.php');
require('../dashboard/includes/conexBD.php'); // Conexión $link
require_once __DIR__ . '/../dashboard/funciones_mail_hercules.php'; // Función EnviarCorreo
date_default_timezone_set('America/Caracas');

// Helper para evitar error Deprecated de utf8_decode
if (!function_exists('codificar')) {
    function codificar($texto) {
        return mb_convert_encoding($texto ?? "", 'ISO-8859-1', 'UTF-8');
    }
}

// 2. Obtención de parámetros
$Ngrama = isset($_REQUEST["Ngrama"]) ? intval($_REQUEST["Ngrama"]) : 0;
if ($Ngrama <= 0) die("ID de registro no válido.");

// 3. Obtención de datos (Misma lógica optimizada anterior)
$sqlParam = "SELECT valor1 AS rif, valor2 AS nombre_cia, valor4 AS titulo_reporte FROM sco_parametro WHERE codigo = '062' LIMIT 1";
$resParam = mysqli_query($link, $sqlParam);
$infoGral = mysqli_fetch_assoc($resParam);

$sqlGrama = "SELECT a.ci_solicitante, a.solicitante, a.telefono1, a.email, a.subtipo AS codtipo, 
                c.valor2 AS subtipo, a.contrato, a.monto,
                DATE_FORMAT(a.fecha_desde, '%d/%m/%Y') AS fecha_desde, 
                DATE_FORMAT(a.fecha_hasta, '%d/%m/%Y') AS fecha_hasta,
                CONCAT(TRIM(a.seccion), '-', TRIM(a.modulo), '-', TRIM(a.sub_seccion), '-', TRIM(a.parcela)) AS parcela
            FROM sco_grama AS a 
            JOIN sco_parametro AS c ON c.valor1 = a.subtipo AND c.codigo = '059'
            WHERE a.Ngrama = ? LIMIT 1";

$stmt = $link->prepare($sqlGrama);
$stmt->bind_param("i", $Ngrama);
$stmt->execute();
$resGrama = $stmt->get_result();
$gramaData = $resGrama->fetch_assoc();

if (!$gramaData) die("Expediente no encontrado.");

// 4. Generación del PDF (Estructura estética corregida)
class PDF extends FPDF {
    public $data; public $info;
    function Header() {
        $this->Rect(10, 10, 130, 25); $this->Rect(145, 10, 55, 25);
        $this->SetXY(15, 14); $this->SetFont('Arial', 'B', 11);
        $this->Cell(80, 5, codificar($this->info["titulo_reporte"]), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(30, 5, "# " . str_pad($this->data["id"], 6, "0", STR_PAD_LEFT), 0, 1, 'R');
        $this->SetXY(15, 22); $this->SetFont('Arial', '', 9);
        $this->Cell(120, 5, "RIF.: " . $this->info["rif"], 0, 1, 'L');
        $this->SetXY(145, 12); $this->SetFont('Arial', '', 8);
        $this->Cell(25, 4, "Fecha: ", 0, 0, 'R'); $this->Cell(25, 4, date("d/m/Y"), 0, 1, 'R');
        $this->SetX(145); $this->Cell(25, 4, "Fecha Desde: ", 0, 0, 'R'); 
        $this->Cell(25, 4, $this->data["fecha_desde"], 0, 1, 'R');
        $this->SetX(145); $this->Cell(25, 4, "Fecha Hasta: ", 0, 0, 'R'); 
        $this->Cell(25, 4, $this->data["fecha_hasta"], 0, 1, 'R');
        $this->Rect(10, 38, 190, 25); $this->SetXY(12, 40); $this->SetFont('Arial', '', 9);
        $this->Cell(20, 6, "Cliente:", 0, 0, 'L'); $this->SetFont('Arial', 'B', 9);
        $this->Cell(110, 6, codificar($this->data["solicitante"]), 0, 0, 'L');
        $this->SetFont('Arial', '', 9); $this->Cell(25, 6, "CI / RIF:", 0, 0, 'L');
        $this->Cell(30, 6, $this->data["ci_solicitante"], 0, 1, 'L');
        $this->SetX(12); $this->Cell(20, 6, "Parcela:", 0, 0, 'L');
        $this->Cell(110, 6, $this->data["parcela"], 0, 0, 'L');
        $this->Cell(25, 6, "Ctto #:", 0, 0, 'L'); $this->Cell(30, 6, $this->data["contrato"], 0, 1, 'L');


        $this->SetX(12);
        $this->Cell(20, 6, "Telefonos:", 0, 0, 'L');
        $this->Cell(75, 6, $this->data["telefono1"], 0, 0, 'L');
        $this->Cell(15, 6, "Email:", 0, 0, 'L');
        $this->Cell(75, 6, substr($this->data["email"], 0, 30), 0, 1, 'L');

        $this->SetY(68); $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 8, codificar("Código"), 1, 0, 'L'); $this->Cell(125, 8, codificar("Descripción"), 1, 0, 'L');
        $this->Cell(10, 8, "Cant", 1, 0, 'C'); $this->Cell(20, 8, "EURO Monto", 1, 0, 'R');
        $this->Cell(20, 8, "EURO Total", 1, 1, 'R');
        $this->SetFont('Arial', '', 9); $this->Cell(15, 8, $this->data["codtipo"], 1, 0, 'L');
        $this->Cell(125, 8, strtoupper(codificar($this->data["subtipo"])), 1, 0, 'L');
        $this->Cell(10, 8, "1", 1, 0, 'C'); $this->Cell(20, 8, number_format($this->data["monto"], 2, ",", "."), 1, 0, 'R');
        $this->Cell(20, 8, number_format($this->data["monto"], 2, ",", "."), 1, 1, 'R');
    }
}

$pdf = new PDF('P', 'mm', 'LETTER');
$gramaData["id"] = $Ngrama;
$pdf->data = $gramaData; $pdf->info = $infoGral;
$pdf->AddPage();

// Listado de pagos
$pdf->SetY(95); $pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 7, "Tipo de Pago", "B", 0, 'L'); $pdf->Cell(45, 7, "Ref #", "B", 0, 'L');
$pdf->Cell(30, 7, "Fecha", "B", 0, 'L'); $pdf->Cell(20, 7, "Moneda", "B", 0, 'C');
$pdf->Cell(45, 7, "Monto", "B", 1, 'R');

$pdf->SetFont('Arial', '', 9);
$sqlPagos = "SELECT tipo, ref, DATE_FORMAT(fecha, '%d/%m/%Y') AS f_pago, monto, moneda FROM sco_grama_pagos WHERE grama = ?";
$stmtP = $link->prepare($sqlPagos); $stmtP->bind_param("i", $Ngrama); $stmtP->execute();
$resPagos = $stmtP->get_result();
while ($p = $resPagos->fetch_assoc()) {
    $pdf->Cell(50, 7, codificar($p["tipo"]), 0, 0, 'L'); $pdf->Cell(45, 7, $p["ref"], 0, 0, 'L');
    $pdf->Cell(30, 7, $p["f_pago"], 0, 0, 'L'); $pdf->Cell(20, 7, $p["moneda"], 0, 0, 'C');
    $pdf->Cell(45, 7, number_format($p["monto"], 2, ",", "."), 0, 1, 'R');
}

// 5. Guardar PDF temporalmente
$filename = "Recibo_Grama_" . $Ngrama . ".pdf";
$filepath = __DIR__ . "/temp/" . $filename;
if (!file_exists(__DIR__ . "/temp")) mkdir(__DIR__ . "/temp", 0777, true);
$pdf->Output('F', $filepath);

// 6. Preparar y enviar correo
$emailDestino = $gramaData['email'];
$enviado = false;

if (filter_var($emailDestino, FILTER_VALIDATE_EMAIL)) {
    $cuerpo = "<h3>Estimado(a) " . $gramaData['solicitante'] . "</h3>";
    $cuerpo .= "<p>Adjunto encontrará su recibo por concepto de mantenimiento de grama correspondiente al expediente <b>#" . $Ngrama . "</b>.</p>";
    $cuerpo .= "<p>Atentamente,<br>Sistema Hércules - Cementerio del Este</p>";

    $opcionesMail = [
        'to' => $emailDestino,
        'subject' => "Recibo de Mantenimiento de Grama #" . str_pad($Ngrama, 6, "0", STR_PAD_LEFT),
        'body' => $cuerpo,
        'attachments' => [$filepath]
    ];

    $enviado = EnviarCorreo($opcionesMail);

    // 7. Registrar en Bitácora (sco_grama_nota) si se envió con éxito
    if ($enviado) {
        $nota = "EMAIL ENVIADO EXITOSAMENTE A: " . $emailDestino;
        $sqlLog = "INSERT INTO sco_grama_nota (grama, fecha, nota, usuario) VALUES (?, NOW(), ?, 'SISTEMA')";
        $stmtL = $link->prepare($sqlLog);
        $stmtL->bind_param("is", $Ngrama, $nota);
        $stmtL->execute();
    }
}

// 8. Respuesta al usuario y limpieza
if ($enviado) {
    echo "<script>alert('Correo enviado exitosamente a: $emailDestino'); window.close();</script>";
} else {
    echo "<script>alert('Error: No se pudo enviar el correo. Verifique la dirección o el log del sistema.'); window.close();</script>";
}

// Eliminar archivo temporal después de enviar
if (file_exists($filepath)) unlink($filepath);

$stmt->close(); $stmtP->close(); mysqli_close($link);
?>