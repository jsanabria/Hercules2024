<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');

$exe = isset($_REQUEST["exp"])?$_REQUEST["exp"]:"0";
$exe = str_replace("NaN,","",$exe);

$Nservicio = isset($_GET["Nservicio"])?$_GET["Nservicio"]:"";
$fecha_desde = isset($_GET["fecha_desde"])?$_GET["fecha_desde"]:"";
$fecha_hasta = isset($_GET["fecha_hasta"])?$_GET["fecha_hasta"]:"";
if(strlen($fecha_desde) == 10 and strlen($fecha_hasta) == 10) {
	$bt = "AND b.fecha BETWEEN '$fecha_desde' AND '$fecha_hasta'";
	$bt2 = "AND b.fecha <= '$fecha_hasta'";
}

$GLOBALS["sub_titulo_reporte"] = "Fecha Desde: " .  $fecha_desde . " Fecha Hasta:" . $fecha_hasta . ""; // " Estatus: $estatus";
$GLOBALS["titulo_reporte"] = "RELACION ENTRADA SALIDA INSUMOS";

$sql = "SELECT c.nombre as art, d.nombre as cat FROM sco_servicio c join sco_servicio_tipo d on d.Nservicio_tipo = c.tipo WHERE c.Nservicio = '$Nservicio';";
$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);
$GLOBALS["articulo"] = $row["art"];
$GLOBALS["categoria"] = $row["cat"];

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		// Logo
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		// Fecha Hora
		$this->SetFont('Arial','',8);
		$this->Cell(200,10,'Fecha: '.date("d/m/Y"),0,0,'R');
		$this->ln(5);
		$this->Cell(200,10,'Hora: '.date("h:i:s A"),0,0,'R');
		$this->Ln(5);
		$this->SetFont('Arial','BI',15);
		$this->Ln(20);
		// Título
		$this->Cell(200,10,$GLOBALS["titulo_reporte"],0,0,'C');
		$this->Ln(8);

		$this->SetFont('Arial','I',12);
		$this->Cell(200,10,$GLOBALS["sub_titulo_reporte"],0,0,'C');
		// Salto de línea
		$this->Ln(15);

		$this->SetFont('Arial','B',12);
		$this->Cell(200,8,'Artículo: ' . $GLOBALS["categoria"] . " " . $GLOBALS["articulo"],1,0,'L');
		$this->Ln();

		$this->SetFont('Arial','B',10);
		$this->Cell(90,5,'Proveedor',1,0,'L');
		$this->Cell(25,5,'Tipo Mov.',1,0,'R');
		$this->Cell(25,5,'Cantidad',1,0,'R');
		$this->Cell(30,5,'Costo',1,0,'R');
		$this->Cell(30,5,'Total',1,0,'R');

		$this->Ln();
	}
	
	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Times','I',8);
		// Número de página
		$this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','LETTER');
$pdf->AliasNbPages();
$pdf->SetFont('Times','',8);
$pdf->AddPage();

$sql = "SELECT 
	a.articulo, c.nombre as art, a.proveedor, d.nombre as prov, a.tipo_doc, a.costo, sum(a.cantidad) as cantidad, sum(a.total) as total 
FROM 
	sco_entrada_salida_detalle a 
	JOIN sco_entrada_salida b ON b.Nentrada_salida = a.entrada_salida 
	JOIN sco_servicio c on c.Nservicio = a.articulo 
	JOIN sco_proveedor d on d.Nproveedor = a.proveedor 
WHERE 
	a.articulo = '$Nservicio' and a.cantidad >= 0 $bt 
GROUP BY a.articulo, c.nombre, a.proveedor, d.nombre, a.tipo_doc, a.costo
UNION ALL SELECT 
	a.articulo, c.nombre as art, a.proveedor, d.nombre as prov, a.tipo_doc, a.costo, sum(a.cantidad) as cantidad, sum(a.total) as total 
FROM 
	sco_entrada_salida_detalle a 
	JOIN sco_entrada_salida b ON b.Nentrada_salida = a.entrada_salida 
	JOIN sco_servicio c on c.Nservicio = a.articulo 
	JOIN sco_proveedor d on d.Nproveedor = a.proveedor 
WHERE 
	a.articulo = '$Nservicio' and a.cantidad < 0 $bt
GROUP BY a.articulo, c.nombre, a.proveedor, d.nombre, a.tipo_doc, a.costo
ORDER BY proveedor, cantidad;";


$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$contar_insumos = 0;

$pdf->SetFont('Arial','',10);
while($row = mysql_fetch_array($resultado)) {
	$pdf->Cell(90,5,$row["prov"],1,0,'L');
	$pdf->Cell(25,5,$row["tipo_doc"],1,0,'R');
	$pdf->Cell(25,5,number_format($row["cantidad"], 0, ",", "."),1,0,'R');
	$pdf->Cell(30,5,number_format($row["costo"], 2, ",", "."),1,0,'R');
	$pdf->Cell(30,5,number_format($row["total"], 2, ",", "."),1,0,'R');
	
	$pdf->Ln();

	$contar_insumos++;
}
$pdf->SetFont('Arial','BI',10);
$pdf->Cell(200,5,"TOTAL COMPRAS.: " . number_format($contar_insumos, 0, "", "."),'1',0,'R');
$pdf->Ln(8);



$pdf->Output();
?>