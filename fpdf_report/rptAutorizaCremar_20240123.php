<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$id = isset($_REQUEST["id"])?$_REQUEST["id"]:"0";
$username = $_REQUEST["username"];

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_cremaciones.jpg',10,15,45);
		
		$this->ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(200,6,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(200,6,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln(10);
		$titulo = "AUTORIZACION PARA CREMACION";
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
		//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($items)
	{
		$this->SetFont('Arial','B',10);
		$this->ln();
		//$this->Cell(0,5,'Total Ordenes de Preparación: ' . $items,0,0,'C');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();

if(trim($username)!="") {
	$sql = "UPDATE sco_expediente SET autoriza_cremar='S', username_autoriza='$username', fecha_autoriza=now() WHERE Nexpediente = '$id';";
	mysql_query($sql,$enlace);
}

$count_item = 0;
$items = 0;

$sql = "SELECT valor1, valor2, valor3, valor4 FROM sco_parametro WHERE codigo = '049';";
$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);

$valor1 = trim(utf8_decode($row["valor1"]));
$valor2 = trim(utf8_decode($row["valor2"]));
$valor3 = trim(utf8_decode($row["valor3"]));
$valor4 = trim(utf8_decode($row["valor4"]));

$notadb = "$valor1 $valor2 $valor3 $valor4";

$sql = "SELECT 
			ex.nombre_contacto, ex.cedula_contacto, ex.nombre_fallecido, ex.apellidos_fallecido, ex.cedula_fallecido, 
			ex.marca_pasos, date_format(od.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(od.hora_fin, '%h:%i %p') as hora_fin,  
			ex.peso 
		FROM 
			sco_expediente ex 
			JOIN sco_orden od ON od.expediente = ex.Nexpediente AND od.paso = 2 AND od.servicio_tipo = 'CREM' 
		WHERE 
			ex.Nexpediente = '$id';"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);

$pdf->SetFont('Arial','',10);
//$pdf->ln();

$nota = "Yo, ________________________________________________________, titular de la Cédula de Identidad No., _____________________ declaro que los restos mortales de mi familiar Sr.(a) " . strtoupper($row["nombre_fallecido"] . " " . $row["apellidos_fallecido"]) . " titular de la cédula de identidad No., " . $row["cedula_fallecido"] . " seran cremados a las " . $row["hora_fin"] . " del día " . $row["fecha_fin"] . ".";
$nota = $nota;
$pdf->Cell(10);
$pdf->MultiCell(190,6,$nota,0,'J');
$pdf->Ln();

$nota = "Asimismo, hago constar que me despedí y realicé el reconocimiento de mi difunto (máximo 2 familiares) y nuevamente autorizo a Kaufman Bio Incineraciones, C.A. ha realizar el proceso cremación.";
$nota = $nota;
$pdf->Cell(10);
$pdf->MultiCell(190,6,$nota,0,'J');
$pdf->Ln();

//$pdf->SetFont('Arial','IB',10);
$nota = "Igualmente declaro que: 1) En el cuerpo del difunto " . ($row["marca_pasos"]=="S"?"*** SI tiene alojado MARCAPASOS ***. ":"no tiene alojado MARCAPASOS, prótesis o cualquier sistema de energía que funcione con mercurio u otro material que ponga en riesgo a los operadores y a los equipos. ");
$nota .= "2) El cuerpo del difunto no está sometido a un proceso de investigación penal o científica. ";
$nota .= "3) El difunto no haya sido tratado con nitroglicerina en un lapto de (3) días antes de su fallecimiento. ";
$nota .= "4) El difunto tiene un peso corporal menor a CIEN (100) kilos y que en caso contrario debo pagar un monto adicional por el proceso de cremación. Peso declarado: " . strtoupper($row["peso"]);
$nota = $nota;
$pdf->Cell(10);
$pdf->MultiCell(190,6,$nota,0,'J');
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
//$nota = "Queda entendido y aceptado al momento de la contratación del servicio de cremación, que las cenizas serán entregadas a las 24 horas siguientes desde el momento en que se asigna la pauta del proceso y deben ser retiradas en lapso no mayor a 48 horas, en el horario comprendido de 09:00am a 04:00pm.";

$nota = $notadb; 

$nota = $nota;
$pdf->Cell(10);
$pdf->MultiCell(190,6,$nota,0,'J');
$pdf->Ln();


$pdf->SetFont('Arial','IB',12);
$pdf->Cell(200,6,"Retiro de Cenizas",0,0,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',10);
$pdf->Cell(10);
$pdf->Cell(120,8,"Nombre y Apellido _____________________________",0,0,'L');
$pdf->Cell(60,8,"C.I _______________",0,0,'R');
$pdf->Ln();
$pdf->Cell(10);
$pdf->Cell(120,8,"Perentesco _____________________________",0,0,'L');
$pdf->Cell(60,8,"Fecha y Hora _______________",0,0,'R');
$pdf->Ln(20);


$pdf->SetFont('Arial','UB',10);
$nota = "Observaciones: _____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
$nota = $nota;
$pdf->Cell(10);
$pdf->MultiCell(190,6,$nota,0,'J');
$pdf->Ln(15);


$pdf->SetFont('Arial','',10);
$pdf->Cell(210,6,"Pulgar Derecho",0,0,'C');
//$pdf->Ln(10);

$sql = "SELECT nombre FROM sco_user WHERE username = '$username';";
$rs = mysql_query($sql,$enlace);
$row = mysql_fetch_array($rs);
$nombre_usuario = utf8_decode($row["nombre"]);

$pdf->Cell(140,6);
$pdf->Cell(60,6,"",0,0,'C');
$pdf->Ln(10);

$pdf->Cell(80,6,"Familiar / Telf.: ________________",0,0,'C');
$pdf->Cell(60,6);
$pdf->Cell(60,6,$nombre_usuario,0,0,'C');
$pdf->Ln(10);

$pdf->Cell(80,6,"C.I. No. _____________________",0,0,'C');
$pdf->Cell(60,6);
$pdf->Cell(60,6,"C.I. No. _____________________",0,0,'C');
$pdf->Ln(10);

$pdf->Cell(140,6,"",0,0,'C');
$pdf->Cell(60,6,"Gerencia de Servicios",0,0,'C');
$pdf->Ln(10);

//$pdf->Line(13, 188, 70, 188);
//$pdf->Rect(90, 210, 33, 35);
$pdf->Rect(90, 235, 33, 35);
//$pdf->Line(142, 188, 199, 188);

//$pdf->Line(13, 223, 70, 223);
//$pdf->Line(142, 223, 199, 223);

//$pdf->Line(13, 258, 70, 258);

$pdf->EndReport($items);

	
require("desconnect.php");

$pdf->Output();

?>