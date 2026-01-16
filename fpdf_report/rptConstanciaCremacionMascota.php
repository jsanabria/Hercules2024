<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$Nmascota = $_REQUEST["Nmascota"];

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
	}
	
	// Pie de página
	function Footer()
	{
	}
	
	function EndReport($items)
	{
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AliasNbPages();

$items = 0;

$sql = "SELECT valor1 AS empleado, valor2 AS cedula, valor3 AS cargo, valor4 AS cia FROM sco_parametro WHERE codigo = '053';";
$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);
$empleado = $row["empleado"];
$cedula = $row["cedula"];
$cargo = $row["cargo"];
$cia = explode("|", $row["cia"]);
$rif_cia = $cia[1];
$nombre_cia = $cia[0];

$sql = "SELECT 
			a.fecha_cremacion AS fecha, 
			a.nombre_contratante, a.cedula_contratante, 
			IF(a.tipo = 'Otro', a.tipo_otro, a.tipo) AS tipo, a.raza, a.nombre_mascota, 
			DATE_FORMAT(a.fecha_cremacion, '%d/%m/%Y') AS fecha_cremacion 
		FROM 
			sco_mascota AS a 
		WHERE a.Nmascota = $Nmascota;"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);
$fecha = explode("-", $row["fecha"]);
$dia = $fecha[2];
$mes = $fecha[1];
$anho = $fecha[0];

$nombre_contratante = strtoupper($row["nombre_contratante"]);
$cedula_contratante = strtoupper($row["cedula_contratante"]);

$tipo = strtoupper($row["tipo"]);
$raza = strtoupper($row["raza"]);
$nombre_mascota = strtoupper($row["nombre_mascota"]);

$fecha_cremacion = $row["fecha_cremacion"];
$expediente = $Nmascota;


$texto = "Mediante la presente se deja constancia que el día ||fecha_cremacion||, ||nombre_contratante||, titular de la cédula de identidad No. ||cedula_contratante||, entregó el cadaver de un ||tipo|| de raza ||raza|| nombre ||nombre_mascota|| para ser incinerado en nuestras instalaciones CEMENTERIO METROPOLITANO DEL ESTE S.A.
\nConstancia que se expide a solicitud de la parte interesada en Caracas a los ||dia|| días del mes ||mes|| de ||anho||.
";

switch(intval($mes)) {
case 1: 
	$mes_nombre = "Enero";
	break;
case 2: 
	$mes_nombre = "Febrero";
	break;
case 3: 
	$mes_nombre = "Marzo";
	break;
case 4: 
	$mes_nombre = "Abril";
	break;
case 5: 
	$mes_nombre = "Mayo";
	break;
case 6: 
	$mes_nombre = "Junio";
	break;
case 7: 
	$mes_nombre = "Julio";
	break;
case 8: 
	$mes_nombre = "Agosto";
	break;
case 9: 
	$mes_nombre = "Septiembre";
	break;
case 10: 
	$mes_nombre = "Octubre";
	break;
case 11: 
	$mes_nombre = "Noviembre";
	break;
case 12: 
	$mes_nombre = "Diciembre";
	break;
default: 
	$mes_nombre = $mes;
}


$texto = str_replace("||empleado||", $empleado, $texto);
$texto = str_replace("||cedula||", $cedula, $texto);
$texto = str_replace("||nombre_cia||", $nombre_cia, $texto);
$texto = str_replace("||rif_cia||", $rif_cia, $texto);
$texto = str_replace("||dia||", $dia, $texto);
$texto = str_replace("||mes||", $mes_nombre, $texto);
$texto = str_replace("||anho||", $anho, $texto);
$texto = str_replace("||nombre_contratante||", $nombre_contratante, $texto);
$texto = str_replace("||cedula_contratante||", $cedula_contratante, $texto);
$texto = str_replace("||tipo||", $tipo, $texto);
$texto = str_replace("||raza||", $raza, $texto);
$texto = str_replace("||nombre_mascota||", $nombre_mascota, $texto);
$texto = str_replace("||fecha_cremacion||", $fecha_cremacion, $texto);

$pdf->AddPage();

$pdf->SetFont('Arial','B',24);
$pdf->Image('../phpimages/logokaufmanbio.jpg',20,15,40);
$pdf->Ln(40);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20);
$pdf->Cell(170,7,"A QUIEN PUEDA INTERESAR",0,0,'C');
$pdf->Ln(15);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20);
//$texto = stripslashes($texto);
$texto = iconv('windows-1252', 'UTF-8', $texto);
$pdf->MultiCell(170,7,utf8_decode($texto),0,'J');
$pdf->Ln(10);



$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(170,7,$empleado,0,0,'C');
$pdf->Ln(7);
$pdf->Cell(20);
$pdf->Cell(170,7,$cedula,0,0,'C');
$pdf->Ln(7);
$pdf->Cell(20);
$pdf->Cell(170,7,$cargo,0,0,'C');
$pdf->Ln(7);


$pdf->EndReport($items);

	
require("desconnect.php");

$pdf->Output();
?>