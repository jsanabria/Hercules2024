<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$Nreembolso = $_REQUEST["Nreembolso"];

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

$sql = "SELECT 
			a.expediente, DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, a.monto_usd, 
			DATE_FORMAT(a.fecha_tasa, '%d/%m/%Y') AS fecha_tasa, a.tasa, a.monto_bs, a.banco, 
			a.nro_cta, a.titular, a.ci_rif, a.correo, a.motivo, a.nro_ref, a.nota, 
			a.estatus, c.nombre AS coordinador, a.pagador, 
			DATE_FORMAT(a.fecha_pago, '%d/%m/%Y') AS fecha_pago, a.email_enviado, 
			b.nombre_fallecido, b.apellidos_fallecido 
		FROM 
			sco_reembolso AS a 
			JOIN sco_expediente AS b ON b.Nexpediente = a.expediente 
			LEFT OUTER JOIN sco_user AS c ON c.username = a.coordinador 
		WHERE a.Nreembolso = $Nreembolso;"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);
$expediente = $row["expediente"];
$fecha = $row["fecha"];
$monto_usd = number_format($row["monto_usd"], 2, ",", ".");;
$fecha_tasa = $row["fecha_tasa"];
$tasa = number_format($row["tasa"], 2, ".", ",");;
$monto_bs = number_format($row["monto_bs"], 2, ",", ".");
$banco = $row["banco"];
$nro_cta = $row["nro_cta"];
$titular = $row["titular"];
$ci_rif = $row["ci_rif"];
$correo = $row["correo"];
$motivo = $row["motivo"];
$nro_ref = $row["nro_ref"];
$nota = $row["nota"];
$estatus = $row["estatus"];
$coordinador = $row["coordinador"];
$pagador = $row["pagador"];
$fecha_pago = $row["fecha_pago"];
$email_enviado = $row["email_enviado"];
$nombre_fallecido = $row["nombre_fallecido"];
$apellidos_fallecido = $row["apellidos_fallecido"];

$pdf->AddPage();

$pdf->SetFont('Arial','B',24);
$pdf->Image('../phpimages/logo.jpg',20,15,40);
$pdf->Ln(25);
$pdf->SetFont('Arial','',10);
$pdf->Cell(190,7,"FECHA: " . $fecha,0,0,'R');
$pdf->Ln(15);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20);
$pdf->Cell(170,7,"SOLICITUD DE ABONO EN CUENTA",1,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"NOMBRE DEL DIFUTO: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(130,7,utf8_decode($row["nombre_fallecido"]) . " " . utf8_decode($row["apellidos_fallecido"]),0,0,'L');
$pdf->Ln(7);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"MONTO $: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,7,$monto_usd,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10);
$pdf->Cell(25,7,"FECHA TASA: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(15,7,$fecha_tasa,0,0,'L');
$pdf->Ln(7);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"EQUIVALENTE EN Bs.: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,7,$monto_bs,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10);
$pdf->Cell(25,7,"TASA Bs.: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(15,7,$tasa,0,0,'L');
$pdf->Ln(7);

$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20);
$pdf->Cell(170,7,"DATOS BANCARIOS",1,0,'L');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"BANCO: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,7,$banco,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(7);
$pdf->Cell(20);
$pdf->Cell(50,7,"Nro. DE CUENTA: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,7,$nro_cta,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(7);
$pdf->Cell(20);
$pdf->Cell(50,7,"TITULAR: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,7,$titular,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(7);
$pdf->Cell(20);
$pdf->Cell(50,7,"C.I.: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,7,$ci_rif,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(7);
$pdf->Cell(20);
$pdf->Cell(50,7,"CORREO: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,7,$correo,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(7);

$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20);
$pdf->Cell(170,7,"MOTIVO DE REINTEGRO",1,0,'L');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"MOTIVO: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(140,7,utf8_decode($motivo),0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(7);

$pdf->Ln(8);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20);
$pdf->Cell(170,7,"OBSERVACIONES",1,0,'L');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"OBSERVACIONES: ",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(140,7,utf8_decode($nota),0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Ln(20);

$pdf->SetFont('Arial','',10);
$pdf->Cell(10);
$pdf->Cell(190,7,utf8_decode($coordinador),0,0,'C');
$pdf->Ln(7);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20);
$pdf->Cell(50,7,"CLIENTE",'T',0,'C');
$pdf->Cell(10);
$pdf->Cell(50,7,"COORDINADOR",'T',0,'C');
$pdf->Cell(10);
$pdf->Cell(50,7,"RECIBIDO POR",'T',0,'C');
$pdf->Ln(7);


$pdf->EndReport($items);

	
require("desconnect.php");

$pdf->Output();
?>