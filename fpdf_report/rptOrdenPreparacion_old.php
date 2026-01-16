<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$exe = isset($_REQUEST["exp"])?$_REQUEST["exp"]:"0";
$exe = str_replace("NaN,","",$exe);

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(200,8,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(200,8,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln();
		$titulo = "ORDEN DE PREPARACION";
		$this->ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell(200,8,$titulo,0,0,'C');
		$this->ln(10);
	}
	
	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->ln();
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($items)
	{
		$this->SetFont('Arial','B',10);
		$this->ln();
		$this->Cell(0,5,'Total Ordenes de Preparación: ' . $items,0,0,'C');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();

$count_item = 0;
$items = 0;

$sql = "SELECT 
			Nexpediente, difunto, capilla, tipo_servicio, ataud, 
			date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio, hora_inicio,  
			date_format(fecha_fin, '%d/%m/%Y') as fecha_fin, hora_fin, fecha_inicio as fi   
		FROM view_prepara WHERE Nexpediente in ($exe) ORDER BY fi;"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
while($row = mysql_fetch_array($resultado))
{
	$count_item ++;
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(45,7,"NOMBRE DEL DIFUNTO: ",0,0,'L');
	$pdf->SetFont('Arial','UI',10);
	$pdf->Cell(145,7,$row["difunto"] . " ( Exp.: " . $row["Nexpediente"] . " ) " ,0,0,'L');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(35,7,"TIPO DE SERVICIO: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(35,7,$row["tipo_servicio"],0,0,'L');

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(35,7,"TIPO DE ATAUD: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(75,7,$row["ataud"],0,0,'L');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(20,7,"CAPILLA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(70,7,(trim($row["capilla"])==''?substr($row["tipo_servicio"], 0, 10) . " DIRECTA":$row["capilla"]),0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,7,"DESDE: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(35,7,$row["fecha_inicio"] . " " .  $row["hora_inicio"],0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,7,"HASTA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(35,7,$row["fecha_fin"] . " " .  $row["hora_fin"],0,0,'L');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(30,7,"PREPARADOR: ",0,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(70,7,"__________________________________",0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(25,7,"AYUDANTE: ",0,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(60,7,"________________________________",0,0,'L');
	$pdf->Ln(15);
	
	if($count_item == 6) { $pdf->AddPage(); $count_item = 0; }
	$items++;
}

$pdf->EndReport($items);

	
require("desconnect.php");

$pdf->Output();
?>