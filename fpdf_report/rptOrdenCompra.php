<?php
// Reporte de Orden de Compra (rptOrdenCompra.php)

// --- 1. CONFIGURACIÓN E INCLUSIONES ---
require('rcs/fpdf.php'); 
require('../dashboard/includes/conexBD.php'); 

$mysqli = $link; 

// --- 2. GESTIÓN Y SANITIZACIÓN DE ENTRADA ---
$nOrdenCompra = intval($_REQUEST["Norden_compra"] ?? 0);

if ($nOrdenCompra === 0) {
    die("Error: ID de Orden de Compra inválido.");
}

// --- 3. CLASE PDF (Corregida) ---

class PDF extends FPDF {
    
    protected $nOrdenCompra;
    protected $mysqli;
    protected $ordenData; 
    protected $ciaData;   

    // CORRECCIÓN: Cambiado de 'protected' a 'public' para permitir la llamada desde $pdf->strEncode()
    public function strEncode(string $str): string {
        // Asegura que la cadena sea tratada como string antes de la conversión
        return mb_convert_encoding((string)$str, 'ISO-8859-1', 'UTF-8');
    }

    // Constructor con parámetros requeridos primero
    public function __construct($nOrdenCompra, $mysqli, $orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
        $this->nOrdenCompra = $nOrdenCompra;
        $this->mysqli = $mysqli;
        $this->loadData();
    }
    
    // Método para cargar los datos de la cabecera (seguro)
    protected function loadData() {
        
        $this->ciaData = ['valor1' => '', 'valor2' => '', 'valor3' => '', 'valor4' => ''];
        $stmt_cia = $this->mysqli->prepare("SELECT valor1, valor2, valor3, valor4 FROM sco_parametro WHERE codigo = '001'");
        if ($stmt_cia && $stmt_cia->execute()) {
            $resultado_cia = $stmt_cia->get_result();
            if ($row_datos = $resultado_cia->fetch_assoc()) {
                $this->ciaData = $row_datos;
            }
        }

        $this->ordenData = [
            'Norden_compra' => $this->nOrdenCompra, 
            'proveedor' => '', 
            'fecha' => '', 
            'nota' => '', 
            'unidad_solicitante' => ''
        ];

        $sql_orden = "
            SELECT 
                p.nombre AS proveedor, 
                DATE_FORMAT(o.fecha, '%d/%m/%Y') AS fecha, o.nota, o.unidad_solicitante 
            FROM 
                sco_orden_compra AS o 
                LEFT OUTER JOIN sco_proveedor AS p ON p.Nproveedor = o.proveedor 
            WHERE 
                o.Norden_compra = ?
        ";
        
        $stmt_orden = $this->mysqli->prepare($sql_orden);
        $stmt_orden->bind_param("i", $this->nOrdenCompra); 

        if ($stmt_orden && $stmt_orden->execute()) {
            $resultado_orden = $stmt_orden->get_result();
            if ($row = $resultado_orden->fetch_assoc()) {
                $this->ordenData = array_merge($this->ordenData, $row);
            }
        }
    }


	function Header() {
        
        $nOrdenCompra = $this->ordenData["Norden_compra"];
        $fecha = $this->ordenData["fecha"];
        $unidad_solicitante = $this->ordenData["unidad_solicitante"];
        $cia = $this->ciaData["valor1"] ?? '';
        
		// Logo
		$this->Image('../phpimages/logo.jpg',10,15,50);
		$this->SetFont('Arial','B',20);
		$this->Cell(110);
		$this->Cell(90,6,$this->strEncode("Orden de Compra #: $nOrdenCompra"),0,0,'R');
		$this->Ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,5,'Fecha: ' . $fecha,0,0,'R');
		$this->ln();
		$this->SetFont('Arial','B',12);
		$this->Cell(200,5,$this->strEncode("Unidad Solicitante: $unidad_solicitante"),0,0,'R');
		$this->ln();

		$this->ln(15);
		$this->SetFont('Arial','B',14);
		$this->Cell(200,8,$this->strEncode($cia),0,0,'C');
		$this->ln();

		$this->SetFont('Arial','',10);
		$this->Cell(5);
		$this->ln(10);
		
        // --- Encabezados de tabla ---
		$this->SetFillColor(236, 236, 236);
		$this->SetFont('Arial','B',10);
		$this->Cell(20);
		$this->Cell(110,5,'ARTICULO','B','0','C',true);
		$this->Cell(20,5,'CANTIDAD','B','0','C',true);
		$this->Cell(30,5,$this->strEncode('PRESENTACIÓN'),'B','0','C',true);
		$this->Cell(20);
		$this->Ln(6);
	}
	
	function Footer() {
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->ln();
		$this->Cell(0,5,$this->strEncode('Página ').$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($count_item) {
        $nota = $this->ordenData["nota"] ?? '';
        
		$this->SetFillColor(236, 236, 236);
		$this->SetFont('Arial','B',10);
		$this->Cell(20);
		$this->Cell(160,5,$this->strEncode("TOTAL ARTÍCULOS: $count_item"),'T','0','R',true);
		$this->Cell(20);
		$this->Ln(8);

        // Mostrar la nota de la orden al final
        if (!empty($nota)) {
            $this->SetFont('Arial','B',10);
            $this->Cell(20);
            $this->Cell(160, 5, "Nota de la Orden:", 0, 1, 'L');
            $this->SetFont('Arial','',10);
            $this->Cell(20);
            $this->MultiCell(160, 5, $this->strEncode($nota), 0, 'L');
        }
	}
}

// --- 4. PROCESAMIENTO PRINCIPAL ---

// Llama al constructor con el nuevo orden de parámetros
$pdf = new PDF($nOrdenCompra, $mysqli, 'P', 'mm', 'A4'); 
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

$count_item = 0;

$sql_detalle = "
    SELECT 
        CONCAT(d.articulo, ' ', d.descripcion) AS articulo, d.cantidad, d.unidad_medida, d.disponible 
    FROM 
        sco_orden_compra_detalle AS d 
    WHERE 
        d.orden_compra = ? 
    ORDER BY 
        d.Norden_compra_detalle
";

$stmt_detalle = $mysqli->prepare($sql_detalle);
$stmt_detalle->bind_param("i", $nOrdenCompra); 

if ($stmt_detalle && $stmt_detalle->execute()) {
    $resultado_detalle = $stmt_detalle->get_result();

    while($row = $resultado_detalle->fetch_assoc()) {
        $count_item ++;
        $pdf->SetFont('Arial','',10);
        
        // CORRECCIÓN DE ERROR: Cambiado $this->strEncode() a $pdf->strEncode()
        $articulo = trim($pdf->strEncode($row["articulo"]));
        $disponible = $row["disponible"];
        $cantidad_fmt = number_format($row["cantidad"], 0, ".", ",");
        $unidad_medida = $row["unidad_medida"];
        
        // Lógica de impresión de MultiCell para artículos largos
        if(strlen($articulo) < 50) {
            $pdf->SetFont('ZapfDingbats','', 10);
            $pdf->Cell(20,5,($disponible == "S" ? "4" : ""),0,0,'R');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(110,5,$articulo,0,0,'L');
            $pdf->Cell(20,5,$cantidad_fmt,0,0,'C');
            $pdf->Cell(30,5,$unidad_medida,0,0,'C');
            $pdf->Cell(20);
            $pdf->Ln(6);
        } else {
            // Lógica de MultiCell para artículos largos
            $pdf->SetFont('ZapfDingbats','', 10);
            $pdf->Cell(20,5,($disponible == "S" ? "4" : ""),0,0,'R');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(110,5,substr($articulo, 0, 50),0,0,'L');
            $pdf->Cell(20,5,$cantidad_fmt,0,0,'C');
            $pdf->Cell(30,5,$unidad_medida,0,0,'C');
            $pdf->Cell(20);
            $pdf->Ln(4);
            $pdf->Cell(20,5,"",0,0,'L');
            $pdf->MultiCell(110,6,substr($articulo, 50),0,'L');
        }
    }
} else {
    // Manejar error en la consulta de detalle
    $pdf->SetFont('Arial','B',12);
    // CORRECCIÓN DE ERROR: Cambiado $this->strEncode() a $pdf->strEncode()
    $pdf->Cell(0, 10, $pdf->strEncode("Error al obtener los detalles de la orden."), 0, 1, 'C');
}

$pdf->EndReport($count_item);

$mysqli->close(); 

$pdf->Output();
?>