<?php
// 1. Inclusión de librerías y conexión segura
require('rcs/fpdf.php');
require('../dashboard/includes/conexBD.php'); // Conexión $link
date_default_timezone_set('America/Caracas'); // Ajustado según conexBD.php

// Helper para evitar error Deprecated de utf8_decode en PHP 8.2+
if (!function_exists('codificar')) {
    function codificar($texto) {
        return mb_convert_encoding($texto ?? "", 'ISO-8859-1', 'UTF-8');
    }
}

// 2. Obtención de parámetros
$Ngrama = isset($_REQUEST["Ngrama"]) ? intval($_REQUEST["Ngrama"]) : 0;

if ($Ngrama <= 0) {
    die("ID de registro no válido.");
}

// 3. Obtención de datos maestros
$sqlParam = "SELECT valor1 AS rif, valor2 AS nombre_cia, valor4 AS titulo_reporte 
             FROM sco_parametro WHERE codigo = '062' LIMIT 1";
$resParam = mysqli_query($link, $sqlParam);
$infoGral = mysqli_fetch_assoc($resParam);

// Consulta Preparada para datos del expediente
$sqlGrama = "SELECT 
                a.ci_solicitante, a.solicitante, a.telefono1, a.email, a.subtipo AS codtipo, 
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

// 4. Clase PDF con diseño corregido
class PDF extends FPDF {
    public $data;
    public $info;

    function Header() {
        // Cuadros Superiores (Coordinación visual)
        $this->Rect(10, 10, 130, 25); // Izquierdo
        $this->Rect(145, 10, 55, 25);  // Derecho

        // Contenido Cuadro Izquierdo
        $this->SetXY(15, 14);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(80, 5, codificar($this->info["titulo_reporte"]), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(30, 5, "# " . str_pad($this->data["id"], 6, "0", STR_PAD_LEFT), 0, 1, 'R');
        
        $this->SetXY(15, 22);
        $this->SetFont('Arial', '', 9);
        $this->Cell(120, 5, "RIF.: " . $this->info["rif"], 0, 1, 'L');

        // Contenido Cuadro Derecho
        $this->SetXY(145, 12);
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 4, "Fecha: ", 0, 0, 'R'); $this->Cell(25, 4, date("d/m/Y"), 0, 1, 'R');
        $this->SetX(145);
        $this->Cell(25, 4, "Hora: ", 0, 0, 'R'); $this->Cell(25, 4, date("h:i:s A"), 0, 1, 'R');
        $this->SetX(145);
        $this->Cell(25, 4, "Fecha Desde: ", 0, 0, 'R'); $this->Cell(25, 4, $this->data["fecha_desde"], 0, 1, 'R');
        $this->SetX(145);
        $this->Cell(25, 4, "Fecha Hasta: ", 0, 0, 'R'); $this->Cell(25, 4, $this->data["fecha_hasta"], 0, 1, 'R');

        // Cuadro de Datos del Cliente (Ajustado)
        $this->Rect(10, 38, 190, 25);
        $this->SetXY(12, 40);
        $this->SetFont('Arial', '', 9);
        
        // Fila 1
        $this->Cell(20, 6, "Cliente:", 0, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(110, 6, codificar($this->data["solicitante"]), 0, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(25, 6, "CI / RIF:", 0, 0, 'L');
        $this->Cell(30, 6, $this->data["ci_solicitante"], 0, 1, 'L');

        // Fila 2
        $this->SetX(12);
        $this->Cell(20, 6, "Parcela:", 0, 0, 'L');
        $this->Cell(110, 6, $this->data["parcela"], 0, 0, 'L');
        $this->Cell(25, 6, "Ctto #:", 0, 0, 'L');
        $this->Cell(30, 6, $this->data["contrato"], 0, 1, 'L');

        // Fila 3
        $this->SetX(12);
        $this->Cell(20, 6, "Telefonos:", 0, 0, 'L');
        $this->Cell(75, 6, $this->data["telefono1"], 0, 0, 'L');
        $this->Cell(15, 6, "Email:", 0, 0, 'L');
        $this->Cell(75, 6, substr($this->data["email"], 0, 30), 0, 1, 'L');

        // Encabezado Detalle
        $this->SetY(68);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 8, codificar("Código"), 1, 0, 'L');
        $this->Cell(125, 8, codificar("Descripción"), 1, 0, 'L');
        $this->Cell(10, 8, codificar("Cant"), 1, 0, 'C');
        $this->Cell(20, 8, "EURO Monto", 1, 0, 'R');
        $this->Cell(20, 8, "EURO Total", 1, 0, 'R');
        $this->ln();

        // Fila Detalle
        $this->SetFont('Arial', '', 9);
        $this->Cell(15, 8, $this->data["codtipo"], 1, 0, 'L');
        $this->Cell(125, 8, strtoupper(codificar($this->data["subtipo"])), 1, 0, 'L');
        $this->Cell(10, 8, "1", 1, 0, 'C');
        $this->Cell(20, 8, number_format($this->data["monto"], 2, ",", "."), 1, 0, 'R');
        $this->Cell(20, 8, number_format($this->data["monto"], 2, ",", "."), 1, 1, 'R');
        
        $this->ln(5);
        // Títulos de Pagos
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 7, "Tipo de Pago", "B", 0, 'L');
        $this->Cell(45, 7, "Ref #", "B", 0, 'L');
        $this->Cell(30, 7, "Fecha", "B", 0, 'L');
        $this->Cell(20, 7, "Moneda", "B", 0, 'C');
        $this->Cell(45, 7, "Monto", "B", 1, 'R');
    }
}

// 5. Ejecución del reporte
$pdf = new PDF('P', 'mm', 'LETTER');
$gramaData["id"] = $Ngrama;
$pdf->data = $gramaData;
$pdf->info = $infoGral;

$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

// Consulta de pagos con Prepared Statement
$sqlPagos = "SELECT tipo, ref, DATE_FORMAT(fecha, '%d/%m/%Y') AS f_pago, monto, moneda 
             FROM sco_grama_pagos WHERE grama = ?";
$stmtP = $link->prepare($sqlPagos);
$stmtP->bind_param("i", $Ngrama);
$stmtP->execute();
$resPagos = $stmtP->get_result();

while ($p = $resPagos->fetch_assoc()) {
    $pdf->Cell(50, 7, codificar($p["tipo"]), 0, 0, 'L');
    $pdf->Cell(45, 7, $p["ref"], 0, 0, 'L');
    $pdf->Cell(30, 7, $p["f_pago"], 0, 0, 'L');
    $pdf->Cell(20, 7, $p["moneda"], 0, 0, 'C');
    $pdf->Cell(45, 7, number_format($p["monto"], 2, ",", "."), 0, 1, 'R');
}

// Cierre de conexiones
$stmt->close();
$stmtP->close();
$link->close();

$pdf->Output();