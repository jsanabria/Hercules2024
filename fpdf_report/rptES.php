<?php
// Incluye la librería FPDF
require('rcs/fpdf.php');
// El archivo conexBD.php debe establecer una conexión $link de mysqli
require('../dashboard/includes/conexBD.php'); 

// --- 1. PROCESAMIENTO DE PARÁMETROS DE ENTRADA Y SEGURIDAD ---

// Limpieza y validación de la variable ID
$ides = isset($_REQUEST["ides"]) ? filter_var($_REQUEST["ides"], FILTER_SANITIZE_NUMBER_INT) : "0";
$GLOBALS["ides"] = $ides;

// Se asume que 'connect.php' y 'desconnect.php' ya no son necesarios
// si 'conexBD.php' proporciona una conexión $link (mysqli)

class PDF extends FPDF
{
    protected $link;
    protected $data_company = [];
    protected $data_doc = [];

    function __construct($orientation = 'P', $unit = 'mm', $size = 'LETTER', $link = null)
    {
        parent::__construct($orientation, $unit, $size);
        $this->link = $link;
        $this->loadData();
    }

    // Carga todos los datos necesarios en el constructor
    protected function loadData()
    {
        if (!$this->link) return;

        // 1. Consultar datos de la compañía (sco_parametro)
        $sql_company = "SELECT valor1 AS cia, valor2 AS rif, valor3 AS direccion, valor4 AS telefono
                        FROM sco_parametro WHERE codigo = '001'";
        if ($resultado = $this->link->query($sql_company)) {
            $this->data_company = $resultado->fetch_assoc();
            $resultado->free();
        }

        // 2. Consultar datos del documento (sco_entrada_salida)
        $sql_doc = "SELECT Nentrada_salida, tipo_doc, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, nota, username, 
                        CASE tipo_doc
                            WHEN 'ENTR' THEN 'Entrada de Artículos'
                            WHEN 'SALI' THEN 'Salida de Artículos'
                            WHEN 'AJEN' THEN 'Ajuste de Entrada de Artículos'
                            WHEN 'AJSA' THEN 'Ajuste de Salida de Artículos'
                        END AS titulo
                    FROM sco_entrada_salida WHERE Nentrada_salida = ?";
        
        if ($stmt = $this->link->prepare($sql_doc)) {
            $stmt->bind_param("i", $GLOBALS["ides"]);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $this->data_doc = $resultado->fetch_assoc();
            $stmt->close();
        }
    }

	// Cabecera de página
	function Header()
	{
        $cia = $this->data_company["cia"] ?? '';
        $rif = $this->data_company["rif"] ?? '';
        $direccion = $this->data_company["direccion"] ?? '';
        // $telefono = $this->data_company["telefono"] ?? ''; // No se usa en el header original

        $Nentrada_salida = $this->data_doc["Nentrada_salida"] ?? 'N/D';
        $tipo_doc = $this->data_doc["tipo_doc"] ?? 'N/D';
        $fecha = $this->data_doc["fecha"] ?? 'N/D';
        // $nota = $this->data_doc["nota"] ?? ''; // No se usa en el header original
        $username = $this->data_doc["username"] ?? 'N/D';
        $titulo = $this->data_doc["titulo"] ?? 'Documento de Inventario';
        
		// Logo
		$this->Image('../phpimages/logo.jpg',10,15,50);
		
        // Títulos de Documento y Número
		$this->SetFont('Arial','B',20);
		$this->Cell(110);
		$this->Cell(90,6,$tipo_doc,0,0,'R'); // Tipo de documento (ENTR, SALI, etc.)
		$this->Ln(10);
		
        // Número de Documento, Fecha y Usuario
		$this->SetFont('Arial','B',10);
		$this->Cell(165,5,$tipo_doc.' #',0,0,'R');
		$this->Cell(35,5,$Nentrada_salida,0,0,'L');
		$this->ln();
		$this->Cell(165,5,'Fecha:',0,0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(35,5,$fecha,0,0,'L');
		$this->ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(165,5,'Usuario:',0,0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(35,5,$username,0,0,'L');
		$this->ln();

		// Título Central del Tipo de Operación
		$this->ln(15);
		$this->SetFont('Arial','B',14);
		$this->Cell(200,8,$titulo,0,0,'C');
		$this->ln();

        // Datos de la Compañía (Header del Reporte)
		$this->SetFont('Arial','',10);
		$this->Cell(5);
		$this->Cell(95,5,$cia,0,0,'L');
		$this->Cell(10);
		$this->Cell(90,5,"R.I.F.: " . $rif,0,0,'L');
		$this->ln(10);

		// Encabezados de la Tabla de Detalle
		$this->SetFillColor(236, 236, 236);
		$this->SetFont('Arial','B',10);
		$this->Cell(5);
		$this->Cell(43,5,'CODIGO','B','0','C',true);
		$this->Cell(90,5,'DESCRIPCION','B','0','L',true);
		$this->Cell(15,5,'CANTIDAD','B','0','C',true);
		$this->Cell(22,5,'PRECIO','B','0','R',true);
		$this->Cell(25,5,'TOTAL','B','0','R',true);
		$this->Ln(6);
		
	}
	
	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->ln();
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

// --- 2. CREACIÓN Y GENERACIÓN DEL DOCUMENTO ---

// Creación del objeto de la clase heredada, pasando el link de conexión
$pdf = new PDF('P','mm','LETTER', $link); 
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

$count_item = 0;
$monto_item = 0.0;

// Consulta de detalles (detalle de entrada/salida)
$sql = "SELECT 
			a.articulo, b.nombre, a.cantidad, a.costo, a.total
		FROM 
			sco_entrada_salida_detalle a 
			LEFT OUTER JOIN sco_servicio b ON b.Nservicio = a.articulo 
		WHERE a.entrada_salida = ?";

if ($stmt = $link->prepare($sql)) {
    $stmt->bind_param("i", $GLOBALS["ides"]);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while($row = $resultado->fetch_assoc())
    {
        $count_item ++;
        $pdf->SetFont('Arial','',10);
        
        $articulo = $row["articulo"];
        $nombre = trim($row["nombre"]);
        $cantidad = $row["cantidad"];
        $costo = $row["costo"];
        $total = $row["total"];
        $nombre_len = strlen($nombre);
        
        $pdf->Cell(5); // Margen inicial
        
        // Manejo de la descripción larga: 45 caracteres máximo por línea
        if ($nombre_len < 45) {
            $pdf->Cell(43,5,$articulo,0,0,'L');
            $pdf->Cell(90,5,$nombre,0,0,'L');
            $pdf->Cell(15,5,number_format($cantidad, 0, ".", ","),0,0,'C');
            $pdf->Cell(22,5,number_format($costo, 2, ".", ","),0,0,'R');
            $pdf->Cell(25,5,number_format($total, 2, ".", ","),0,0,'R');
            $pdf->Ln(5);
        } else {
            // Caso de texto largo (divide en dos o más líneas)
            $line1 = substr($nombre, 0, 45);
            $line2 = trim(substr($nombre, 45));

            // Primera línea con todos los datos
            $pdf->Cell(43,5,$articulo,0,0,'L');
            $pdf->Cell(90,5,$line1,0,0,'L');
            $pdf->Cell(15,5,number_format($cantidad, 0, ".", ","),0,0,'C');
            $pdf->Cell(22,5,number_format($costo, 2, ".", ","),0,0,'R');
            $pdf->Cell(25,5,number_format($total, 2, ".", ","),0,0,'R');
            $pdf->Ln(4);
            
            // Segunda línea solo con la continuación de la descripción
            $pdf->Cell(5);
            $pdf->Cell(43,4,"",0,0,'L');
            $pdf->MultiCell(90,4,$line2,0,'L'); // MultiCell para el resto del texto
            $pdf->Ln(2);
        }
            
        $monto_item += $total; // Usamos a.total directamente
    }
    
    $stmt->close();

    // Línea de Cierre y totales
    $pdf->Ln(2);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(5);
    $pdf->Cell(170, 5, 'TOTAL GENERAL', 'T', 0, 'R');
    $pdf->Cell(25, 5, number_format($monto_item, 2, ".", ","), 'T', 1, 'R');


} else {
    // Error en la preparación de la consulta
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 10, 'ERROR DE CONSULTA PREPARADA: ' . $link->error, 0, 1, 'C');
}

// Cierre de la conexión (si es necesario)
// require("../dashboard/includes/desconexBD.php");

$pdf->Output();
?>