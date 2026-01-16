<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');

$fecha_desde = (isset($_REQUEST["fecha_desde"]) AND trim($_REQUEST["fecha_desde"]) != "") ? $_REQUEST["fecha_desde"] : "00/00/0000";

$fecha_hasta = (isset($_REQUEST["fecha_hasta"]) AND trim($_REQUEST["fecha_hasta"]) != "") ? $_REQUEST["fecha_hasta"] : "00/00/0000";
$cia = isset($_REQUEST["cia"]) ? $_REQUEST["cia"] : "";
$username = isset($_REQUEST["username"]) ? $_REQUEST["username"] : "";

$where = "WHERE 0 = 0 ";

$fd = $fecha_desde;
$fh = $fecha_hasta;

$fecha = explode("/", $fecha_desde);
$fecha_desde = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
$fecha = explode("/", $fecha_hasta);
$fecha_hasta = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

if($fecha_desde == "0000-00-00" or $fecha_hasta == "0000-00-00") {
	$fecha_desde = (isset($_REQUEST["fecha_desde2"]) AND trim($_REQUEST["fecha_desde2"]) != "") ? $_REQUEST["fecha_desde2"] : "00/00/0000";
	$fecha_hasta = (isset($_REQUEST["fecha_hasta2"]) AND trim($_REQUEST["fecha_hasta2"]) != "") ? $_REQUEST["fecha_hasta2"] : "00/00/0000"; 

	$fd = $fecha_desde;
	$fh = $fecha_hasta;

	$fecha = explode("/", $fecha_desde);
	$fecha_desde = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
	$fecha = explode("/", $fecha_hasta);
	$fecha_hasta = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

	$where .= "AND a.fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' ";
} else {
	$where .= "AND a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' ";
}

if(trim($cia) != "") {
	$where .= "AND a.cia = $cia ";
}

if(trim($username) != "") {
	$where .= "a.username = $username ";
}

$titulo = "FACTURAS POR EXPEDIENTE DESDE: $fd HASTA: $fh";
$GLOBALS["titulo"] = $titulo;

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->ln(6);
		$this->SetFont('Arial','',8);
		$this->Cell(280,8,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(280,8,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(280,8,$GLOBALS["titulo"],0,0,'C');
		$this->ln(10);

		$this->SetFont('Arial','B',8);
		$this->Cell(10);
		$this->Cell(35,5,"CIA",1,0,'L');
		$this->Cell(35,5,"SERVICIO",1,0,'L');
		$this->Cell(15,5,"#EXP",1,0,'C');
		$this->Cell(20,5,"FECHA",1,0,'L');
		$this->Cell(35,5,"NOMBRE FALLECIDO",1,0,'L');
		$this->Cell(35,5,"APELLIDO FALLECIDO",1,0,'L');
		$this->Cell(20,5,"FACTURA",1,0,'C');
		$this->Cell(30,5,"MONTO",1,0,'R');
		$this->Cell(30,5,"USUARIO",1,0,'L');
		$this->Cell(20,5,"REGISTRO",1,0,'L');

		$this->ln();
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
	
	function EndReport($count_item, $monto)
	{
		$this->SetFont('Arial','B',8);
		$this->Cell(10);
		$this->Cell(195,5,'Total Facturas Por Expedientes: ' . $count_item, 1, 0, 'R');
		$this->Cell(30,5,number_format($monto, 2, ",", "."), 1, 0, 'R');
		$this->Cell(50,5,'', 1, 0, 'R');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage("L");

$items = 0;
$monto = 0;

$user = "...";
$xit = 0;
$xmon = 0;
$sw = false;

$sql = "SELECT 
			b.nombre AS cia, c.nombre AS servicio, 
			a.Nexpediente AS expediente, date_format(a.fecha_registro, '%d/%m/%Y') AS fecha_registro, 
			a.nombre_fallecido, a.apellidos_fallecido, a.factura, 
			a.monto, d.nombre AS username, date_format(a.fecha, '%d/%m/%Y') AS registro 
		FROM 
			view_exp_factura AS a 
			LEFT OUTER JOIN sco_cia AS b ON b.Ncia = a.cia 
			LEFT OUTER JOIN sco_servicio_tipo AS c ON c.Nservicio_tipo = a.servicio_tipo 
			LEFT OUTER JOIN sco_user AS d ON d.username = a.username 
		$where 
		ORDER BY 
			a.username, a.cia, a.fecha_registro;";

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
while($row = mysql_fetch_array($resultado))
{
	if($user != $row["username"]) { 
		if($sw) {
			$pdf->SetFont('Arial','BI',8);
			$pdf->Cell(10);
			$pdf->Cell(195,5,"Total Coordinador $xit",0,0,'R');
			$pdf->Cell(30,5,number_format($xmon, 2, ",", "."), 0, 0, 'R');
			$pdf->ln();

			$xit = 0;
			$xmon = 0;
		}

		$pdf->SetFont('Arial','BI',8);
		$pdf->Cell(10);
		$pdf->Cell(35,5,"Coordinador: " . $row["username"], 0, 0, 'L');
		$pdf->ln();
		$user = $row["username"];
		$sw = true;
	}

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10);
	$pdf->Cell(35,5,substr($row["cia"], 0, 15),0,0,'L');
	$pdf->Cell(35,5,substr($row["servicio"], 0, 15),0,0,'L');
	$pdf->Cell(15,5,$row["expediente"],0,0,'C');
	$pdf->Cell(20,5,$row["fecha_registro"],0,0,'L');
	$pdf->Cell(35,5,substr($row["nombre_fallecido"], 0, 15),0,0,'L');
	$pdf->Cell(35,5,substr($row["apellidos_fallecido"], 0, 15),0,0,'L');
	$pdf->Cell(20,5,$row["factura"],0,0,'C');
	$pdf->Cell(30,5,number_format($row["monto"], 2, ",", "."),0,0,'R');
	$pdf->Cell(30,5,substr($row["username"], 0, 15),0,0,'L');
	$pdf->Cell(20,5,$row["registro"],0,0,'L');
	$pdf->ln();

	$xit ++;
	$xmon += floatval($row["monto"]);

	$items ++;
	$monto += floatval($row["monto"]);

	// if($count_item == 12) { $pdf->AddPage(); $count_item = 0; }
	// $items++;
}
$pdf->SetFont('Arial','BI',8);
$pdf->Cell(10);
$pdf->Cell(195,5,"Total Coordinador $xit",0,0,'R');
$pdf->Cell(30,5,number_format($xmon, 2, ",", "."), 0, 0, 'R');
$pdf->ln();

$pdf->EndReport($items, $monto);

	
require("desconnect.php");

$pdf->Output();

?>