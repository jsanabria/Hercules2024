<?php
// Incluye la librería FPDF. Asegúrate de que esta ruta sea correcta.
require_once 'rcs/fpdf.php'; 

// Creamos una subclase de FPDF para manejar el encabezado y pie de página del reporte
class PDF_Sleeping extends FPDF
{
    private $fechaInicio;
    private $fechaFin;

    // Método para configurar las fechas en el objeto PDF
    public function setFechas(string $f1, string $f2) {
        $this->fechaInicio = $f1;
        $this->fechaFin = $f2;
    }

    // Cabecera de página
    function Header()
    {
        // Título Principal
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 8, mb_convert_encoding('REPORTE DE ENTREGA DE SLEEPING POR HALCÓN', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        
        // Rango de fechas
        $this->SetFont('Arial', '', 10);
        $fechaInicioDisplay = date("d/m/Y", strtotime($this->fechaInicio));
        $fechaFinDisplay = date("d/m/Y", strtotime($this->fechaFin));
        $this->Cell(0, 6, mb_convert_encoding("Periodo: Del {$fechaInicioDisplay} al {$fechaFinDisplay}", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(3);
        
        // Llamar al método para imprimir los encabezados de la tabla
        $this->printTableHeader();
    }

    // Pie de página
    function Footer()
    {
        // Posición a 15 mm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo() . '/{nb}', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    }

    // Encabezados de la tabla de detalles
    function printTableHeader()
    {
        // Anchuras de las columnas (suman 190mm, dejando 20mm de márgenes)
        $w = [20, 40, 35, 30, 20, 45]; 
        $header = ['Expediente', 'Apellido Difunto', 'Nombre Difunto', 'Fecha/Hora', 'ID Halcón', 'Nombre Halcón'];
        
        $this->SetFillColor(30, 144, 255); // Azul
        $this->SetTextColor(255); // Blanco
        $this->SetDrawColor(128, 128, 128); // Gris para el borde
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 8);

        // Imprimir las cabeceras
        for ($i = 0; $i < count($header); $i++) {
            // El último encabezado tiene ancho fijo, los demás pueden ajustarse
            $this->Cell($w[$i], 7, mb_convert_encoding($header[$i], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        }
        $this->Ln();
        
        $this->SetFillColor(240, 240, 240); // Resetear a color claro
        $this->SetTextColor(0); // Resetear a color negro
        $this->SetFont('Arial', '', 8);
    }
}

// ====================================================================
// CLASE PRINCIPAL QUE CONTIENE LA LÓGICA DE NEGOCIO Y GENERA EL PDF
// ====================================================================

class sleeping
{
    private string $fechaInicio;
    private string $fechaFin;

    public function __construct(string $fechaInicio, string $fechaFin) 
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    /**
     * Genera el reporte de entrega de Sleepings en formato PDF.
     */
    public function generarPDFSleepings()
    {
        global $link;
     
        $f1 = $this->fechaInicio;
        $f2_endOfDay = $this->fechaFin . ' 23:59:59';
        
        $sql = "
            SELECT 
                a.expediente, 
                b.nombre_fallecido, 
                b.apellidos_fallecido, 
                a.fecha_hora, 
                a.halcon, 
                c.nombre AS nombre_halcon 
            FROM 
                sco_expediente_estatus a 
                JOIN sco_expediente b ON b.Nexpediente = a.expediente 
                LEFT OUTER JOIN sco_user c ON c.username = a.halcon 
            WHERE 
                b.estatus <> 7 
                AND a.estatus = 2 
                AND IFNULL(a.halcon, '') <> '' 
                AND a.fecha_hora BETWEEN ? AND ? 
            ORDER BY 
                a.halcon, a.expediente;
        ";
        
        try {
            if (!($stmt = $link->prepare($sql))) {
                throw new Exception("Error al preparar la consulta de sleeping: " . $link->error);
            }
            $stmt->bind_param("ss", $f1, $f2_endOfDay);
            $stmt->execute();
            $rs = $stmt->get_result();

        } catch (Exception $e) {
            // Si la consulta falla, lanzamos una excepción o devolvemos un error
            error_log("Error DB en generarPDFSleepings: " . $e->getMessage());
            die("Error al generar el reporte PDF: " . htmlspecialchars($e->getMessage()));
        }
        
        // ----------------------------------------------------
        // INICIO DE LA GENERACIÓN DEL PDF
        // ----------------------------------------------------
        
        $pdf = new PDF_Sleeping('P', 'mm', 'A4');
        $pdf->AliasNbPages(); // Necesario para {nb} en el Footer
        $pdf->setFechas($f1, $this->fechaFin);
        $pdf->AddPage();

        $w = [20, 40, 35, 30, 20, 45]; // Anchos de las columnas
        $dy = 0; // Contador total
        $current_halcon = null;
        $halcon_count = 0;
        $fill = false; // Alternador de color de fila

        while ($row = $rs->fetch_assoc()) {
            
            // Lógica de Agrupamiento y Subtotales
            if ($row["halcon"] !== $current_halcon && $current_halcon !== null) {
                // Imprimir subtotal del Halcón anterior
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetFillColor(255, 255, 150); // Fondo amarillo suave
                
                // Celda total (colspain 4)
                $pdf->Cell($w[0] + $w[1] + $w[2] + $w[3], 7, utf8_decode('Total Sleeping para Halcón (' . $current_halcon . '):'), 1, 0, 'R', true);
                // Celda de conteo (colspain 2)
                $pdf->Cell($w[4] + $w[5], 7, number_format($halcon_count, 0, "", "."), 1, 1, 'L', true);
                
                $pdf->Ln(2); // Espacio entre subtotales
                
                // Reiniciar para el nuevo grupo
                $current_halcon = $row["halcon"];
                $halcon_count = 0;
                $pdf->SetFont('Arial', '', 8);
                $fill = false; // Reiniciar el color de fila
                
            } elseif ($current_halcon === null) {
                // Primer Halcón
                $current_halcon = $row["halcon"];
            }

            // Impresión de la fila
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetDrawColor(200, 200, 200); // Borde más claro
            $pdf->SetFillColor($fill ? 245 : 255); // Alternar fondo

            $fechaHoraDisplay = date("d/m/Y H:i:s", strtotime($row["fecha_hora"]));

            $pdf->Cell($w[0], 6, utf8_decode($row["expediente"]), 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, utf8_decode($row["apellidos_fallecido"]), 'LR', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, utf8_decode($row["nombre_fallecido"]), 'LR', 0, 'L', $fill);
            $pdf->Cell($w[3], 6, $fechaHoraDisplay, 'LR', 0, 'C', $fill);
            $pdf->Cell($w[4], 6, utf8_decode($row["halcon"]), 'LR', 0, 'C', $fill);
            $pdf->Cell($w[5], 6, utf8_decode($row["nombre_halcon"]), 'LR', 0, 'L', $fill);
            $pdf->Ln(); // Nueva línea

            $halcon_count++;
            $dy++; // Contador total
            $fill = !$fill; // Alternar color
            
            // Si hay un salto de página, FPDF llama a Header() automáticamente
        }
        
        // 4. Subtotal para el último Halcón
        if ($current_halcon !== null) {
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(255, 255, 150);
            $pdf->Cell($w[0] + $w[1] + $w[2] + $w[3], 7, utf8_decode('Total Sleeping para Halcón (' . $current_halcon . '):'), 1, 0, 'R', true);
            $pdf->Cell($w[4] + $w[5], 7, number_format($halcon_count, 0, "", "."), 1, 1, 'L', true);
        }

        $pdf->Ln(5);
        
        // 5. Total General
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(170, 255, 170); // Fondo verde suave
        $totalText = mb_convert_encoding('Total Sleepings Entregados en el Periodo: ', 'ISO-8859-1', 'UTF-8');
        
        // Celda para el texto (150mm)
        $pdf->Cell(150, 8, $totalText, 1, 0, 'R', true);
        // Celda para el valor (40mm)
        $pdf->Cell(40, 8, number_format($dy, 0, "", "."), 1, 1, 'C', true);
        
        $stmt->close();

        // Salida del PDF. 'I' envía el PDF al navegador (Inline)
        $pdf->Output('I', 'Reporte_Sleepings_' . $f1 . '_a_' . $this->fechaFin . '.pdf');
    }
}
?>