<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$NEmbalaje = $_REQUEST["NEmbalaje"];

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
			a.fecha, a.precinto1, a.precinto2, 
			a.certificado_defuncion, a.doctor, 
			a.doctor_nro, a.cremacion_nro, a.registro_civil, 
			a.dimension_cofre, b.nombre_fallecido, 
			b.apellidos_fallecido, IF(RTRIM(IFNULL(b.causa_otro, '')) = '', 
			b.causa_ocurrencia, b.causa_otro) AS causa, b.cedula_fallecido, 
			nombre_familiar, cedula_familiar, DATE_FORMAT(a.fecha_servicio, '%d/%m/%Y') AS fecha_cremacion, 
			b.Nexpediente AS expediente  
		FROM 
			sco_embalaje AS a 
			JOIN sco_expediente AS b ON b.Nexpediente = a.expediente 
			LEFT OUTER JOIN sco_orden AS c ON c.expediente = b.Nexpediente 
					AND paso = 2 AND c.servicio_tipo = 'CREM' 
		WHERE a.Nembalaje = $NEmbalaje;"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$row = mysql_fetch_array($resultado);
$fecha = explode("-", $row["fecha"]);
$dia = $fecha[2];
$mes = $fecha[1];
$anho = $fecha[0];
$precinto1 = $row["precinto1"];
$precinto2 = $row["precinto2"];
$certificado_defuncion = $row["certificado_defuncion"];
$doctor = $row["doctor"];
$doctor_nro = $row["doctor_nro"];
$cremacion_nro = $row["cremacion_nro"];
$registro_civil = $row["registro_civil"];
$dimension_cofre = $row["dimension_cofre"];

$nombre_familiar = $row["nombre_familiar"];
$cedula_familiar = $row["cedula_familiar"];

$nombre_fallecido = $row["nombre_fallecido"] . " " . $row["apellidos_fallecido"];

$causa = $row["causa"];
$cedula_fallecido = $row["cedula_fallecido"];

$fecha_cremacion = $row["fecha_cremacion"];
$expediente = $row["expediente"];


$sql = "SELECT servicio_tipo FROM sco_orden WHERE expediente = $expediente AND servicio_tipo = 'EXHU'"; 
$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
if($row = mysql_fetch_array($resultado)) {
	/*$texto = "Yo, ||empleado||, titular de la cédula de identidad No. ||cedula||, actuando  en  nombre  y representación  de ||nombre_cia||, sociedad mercantil inscrito en el registro de información fiscal RIF ||rif_cia||, empresa dedicada a los servicios funerarios y de cremación, CERTIFICO: que en fecha ||fecha_cremacion||, previo cumplimiento de  las  formalidades  exigidas por la ley, y en presencia del personal capacitado para tal fin, se  realizó el Servicio de Cremación de los restos  mortales de ||nombre_difunto||, titular de la cédula de identidad No. ||cedula_difunto||, según Certificado de Defunción No. ||certificado_defuncion||. Dicha Cremación se realizó con el permiso No. ||permiso_cremacion||. Emitido por la Coordinadora de La Oficina de Administración de Cementerios, Alcaldia del Municipio el Hatillo. Las  cenizas se introdujeron en una caja de madera cuyas medidas son ||dimension||, y se encuentra debidamente sellada y precintada bajo los nùmero $precinto1 y $precinto2.
	\n Este Certificado se expide a los ||dia|| días del mes ||mes|| de ||anho||.
	";*/
	$texto = "Yo, ||empleado||, titular de la cédula de identidad No. ||cedula||, actuando  en  nombre  y representación  de ||nombre_cia||, sociedad mercantil inscrito en el registro de información fiscal RIF ||rif_cia||, empresa dedicada a los servicios funerarios y de cremación, CERTIFICO: que en fecha ||fecha_cremacion||, previo cumplimiento de  las  formalidades  exigidas por la ley, y en presencia del personal capacitado para tal fin, se  realizó el Servicio de Cremación de los restos  mortales de ||nombre_difunto||, titular de la cédula de identidad No. ||cedula_difunto||, según Certificado de Defunción No. ||certificado_defuncion||. Las  cenizas se introdujeron en una caja de madera cuyas medidas son ||dimension||, y se encuentra debidamente sellada y precintada bajo los nùmero $precinto1 y $precinto2.
	\n Este Certificado se expide a los ||dia|| días del mes ||mes|| de ||anho||.
	";
}
else {
	/*$texto = "Yo, ||empleado||, titular de la cédula de identidad No. ||cedula||, actuando  en  nombre  y representación  de ||nombre_cia||, sociedad mercantil inscrito en el registro de información fiscal RIF ||rif_cia||, empresa dedicada a los servicios funerarios y de cremación, CERTIFICO: que en fecha ||fecha_cremacion||, previo cumplimiento de  las  formalidades  exigidas por la ley, y en presencia del personal capacitado para tal fin, se  realizó el Servicio de Cremación de los restos  mortales de ||nombre_difunto||, titular de la cédula de identidad No. ||cedula_difunto||, según Certificado de Defunción No. ||certificado_defuncion||. Dicha Cremación  se realizó con el permiso No. ||permiso_cremacion||. Emitido por el Registro  Civil  del  Municipio Bolivariano ||registro_civil||. Las  cenizas se introdujeron en una caja de madera cuyas medidas son ||dimension||, y se encuentra debidamente sellada y precintada bajo los nùmero $precinto1 y $precinto2.
	\n Este Certificado se expide a los ||dia|| días del mes ||mes|| de ||anho||.
	";*/
	$texto = "Yo, ||empleado||, titular de la cédula de identidad No. ||cedula||, actuando  en  nombre  y representación  de ||nombre_cia||, sociedad mercantil inscrito en el registro de información fiscal RIF ||rif_cia||, empresa dedicada a los servicios funerarios y de cremación, CERTIFICO: que en fecha ||fecha_cremacion||, previo cumplimiento de  las  formalidades  exigidas por la ley, y en presencia del personal capacitado para tal fin, se  realizó el Servicio de Cremación de los restos  mortales de ||nombre_difunto||, titular de la cédula de identidad No. ||cedula_difunto||, según Certificado de Defunción No. ||certificado_defuncion||. Las  cenizas se introdujeron en una caja de madera cuyas medidas son ||dimension||, y se encuentra debidamente sellada y precintada bajo los nùmero $precinto1 y $precinto2.
	\n Este Certificado se expide a los ||dia|| días del mes ||mes|| de ||anho||.
	";
}
$texto = stripslashes($texto);

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
$texto = str_replace("||mes||", $mes, $texto);
$texto = str_replace("||anho||", $anho, $texto);
$texto = str_replace("||nombre_familiar||", utf8_decode($nombre_familiar), $texto);
$texto = str_replace("||cedula_familiar||", $cedula_familiar, $texto);
$texto = str_replace("||nombre_difunto||", utf8_decode($nombre_fallecido), $texto);
$texto = str_replace("||cedula_difunto||", $cedula_fallecido, $texto);
$texto = str_replace("||causa_fallecimiento||", utf8_decode($causa), $texto);
$texto = str_replace("||certificado_defuncion||", $certificado_defuncion, $texto);
$texto = str_replace("||doctor||", $doctor, $texto);
$texto = str_replace("||nro_doctor||", $doctor_nro, $texto);
$texto = str_replace("||registro_civil||", $registro_civil, $texto);
$texto = str_replace("||dimension||", $dimension_cofre, $texto);
$texto = str_replace("||permiso_cremacion||", $cremacion_nro, $texto);
$texto = str_replace("||fecha_cremacion||", $fecha_cremacion, $texto);
// die("<br><br>PASO DOS: " . $texto);

$pdf->AddPage();

$pdf->SetFont('Arial','B',24);
$pdf->Image('../phpimages/logokaufmanbio.jpg',20,15,40);
$pdf->Ln(40);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20);
$pdf->Cell(170,7,"CERTIFICADO DE EMBALAJE",0,0,'C');
$pdf->Ln(15);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20);
//$texto = iconv('windows-1252', 'UTF-8', $texto);
$pdf->MultiCell(170,7,$texto,0,'J');
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