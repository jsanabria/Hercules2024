<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$exe = isset($_REQUEST["exp"])?$_REQUEST["exp"]:"0";
$exe = str_replace("NaN,","",$exe);
$GLOBALS["fecha_sepelio_ini"] = isset($_REQUEST["fecha_sepelio_ini"])?$_REQUEST["fecha_sepelio_ini"]:"0";
$GLOBALS["fecha_sepelio_fin"] = isset($_REQUEST["fecha_sepelio_fin"])?$_REQUEST["fecha_sepelio_fin"]:"0";

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
		$titulo = "ORDEN DE SERVICIO - DESDE: " . $GLOBALS["fecha_sepelio_ini"] . " HASTA: " . $GLOBALS["fecha_sepelio_fin"];
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
		$this->Cell(0,5,'Total Ordenes de Servicio: ' . $items,0,0,'C');
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
			view_servicio.Nexpediente, substring(difunto,1,30) difunto, capilla, tipo_servicio, ataud, 
			date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio, hora_inicio,  
			date_format(fecha_fin, '%d/%m/%Y') as fecha_fin, hora_fin, 
			date_format(fecha_ofirel, '%d/%m/%Y') as fecha_ofirel, hora_ofirel, 
			date_format(fecha_sepelio, '%d/%m/%Y') as fecha_sepelio, hora_sepelio, concat(if(substring(hora_sepelio,6,2)='AM','0:',if(substring(hora_sepelio,1,2)='12','0:','1:')), substring(hora_sepelio,1,5)) as fs, 
			if(ifnull(expe.factura,'')='', 'N', 'S') as pagado, expe.religion 
		FROM view_servicio join sco_expediente as expe ON expe.Nexpediente = view_servicio.Nexpediente 
		WHERE view_servicio.Nexpediente in ($exe) AND IFNULL(fecha_inicio, '0000-00-00') <> '0000-00-00' ORDER BY fecha_sepelio, fs;"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
while($row = mysql_fetch_array($resultado))
{
	$count_item ++;
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(20,6,"DIFUNTO: ",0,0,'L');
	$pdf->SetFont('Arial','UI',10);
	$pdf->Cell(75,6,substr($row["difunto"], 0, 35)  ,0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(35,6,"OFICIO RELIGIOSO: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(40,6,$row["fecha_ofirel"] . " - " . $row["hora_ofirel"],0,0,'L');
	$pdf->Cell(20,6,($row["fecha_inicio"]==$row["fecha_sepelio"]?"(Entra y Sale)":""),0,0,'L');
	$pdf->Ln();

	$pdf->Cell(10);
	$pdf->SetFont('Arial','BI',10);

	$pdf->Cell(20,6,"CAPILLA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	//$pdf->Cell(40,6,(trim($row["capilla"])==''?substr($row["tipo_servicio"], 0, 10) . " DIRECTA":$row["capilla"]),0,0,'L');
	$pdf->Cell(40,6,(trim($row["capilla"])==''?(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "capilla")):$row["capilla"]),0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,6,"DESDE: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	//$pdf->Cell(20,6,$row["hora_inicio"],0,0,'L');
	$pdf->Cell(20,6,(trim($row["capilla"])==''?(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "fecha_inicio"))=="1"?$row["hora_inicio"]:
	(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "hora_inicio")):$row["hora_inicio"]),0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,6,"HASTA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	//$pdf->Cell(20,6,$row["hora_fin"],0,0,'L');
	$pdf->Cell(35,6,(trim($row["capilla"])==''?(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "fecha_inicio"))=="1"?$row["fecha_fin"] . " " .  $row["hora_fin"]:
	(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "hora_fin")):$row["fecha_fin"] . " " .  $row["hora_fin"]),0,0,'L');

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(62,6,substr($row["tipo_servicio"],0,3) . " (" . $row["fecha_sepelio"] . " " . $row["hora_sepelio"] .")",0,0,'L');
	$pdf->Cell(8,6,($row["pagado"]=='S'?chr(36):""),0,0,'L');

	$pdf->Ln();
	$pdf->Cell(10);
	$pdf->Cell(80,6,"RELIGION: " . $row["religion"],0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(40,6," ( Exp.: " . $row["Nexpediente"] . " ) ",0,0,'L');

	$pdf->Ln(8);

	if($count_item == 11) { $pdf->AddPage(); $count_item = 0; }
	$items++;
}

$pdf->EndReport($items);

	
require("desconnect.php");

$pdf->Output();

function buscar_capilla_compartida($Nexp, $serv, $campo) {
	require("connect.php");
	$sql = "SELECT 
				c.nombre AS capilla, date_format(b.hora_inicio, '%h:%i%p') as hora_inicio, 
				 concat(date_format(b.fecha_fin, '%d/%m/%Y'), ' ', date_format(b.hora_fin, '%h:%i%p')) as hora_fin 
			FROM 
				sco_expediente a 
				JOIN sco_orden b ON b.expediente = a.unir_con_expediente AND b.paso = '1' 
				JOIN sco_servicio c on c.Nservicio = b.servicio 
			WHERE a.Nexpediente = '$Nexp';"; 
	$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
	if($row = mysql_fetch_array($resultado)) return $row[$campo];
	else {
		if($campo=="capilla") return $serv . " DIRECTA";
		else return "1";
	}
}
?>