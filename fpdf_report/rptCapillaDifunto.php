<?php
// Incluye el archivo de conexión que usa mysqli y define $link
require('../dashboard/includes/conexBD.php'); 
require('rcs/fpdf.php'); 

// La variable $link (mysqli object) es asumida desde conexBD.php
$link = $GLOBALS['link']; 

// Se mantiene la zona horaria definida por el usuario
date_default_timezone_set('America/La_Paz'); 

$exe = isset($_REQUEST["exp"])?$_REQUEST["exp"]:"0";
$exe = str_replace("NaN,","",$exe);

class PDF extends FPDF
{
	// Las funciones se dejan vacías ya que el contenido se añade en el bucle
	function Header() {}
	function Footer() {}
	function EndReport($items) {}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();

$items = 0;

// Consulta Principal
$sql = "SELECT a.Nexpediente, a.nombre_fallecido, a.apellidos_fallecido, a.capilla, date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, 
		DATE_FORMAT(DATE_SUB( STR_TO_DATE( concat(date_format(a.fecha_fin, '%Y-%m-%d'), ' ', if(a.espera_cenizas='S', a.hora_fin_servicio, a.hora_fin_capilla)), '%Y-%m-%d %H:%i:%s'),INTERVAL 15 MINUTE), '%h:%i%p') hora_fin 
		FROM view_expediente a WHERE a.Nexpediente in ($exe) ORDER BY a.capilla"; 

// Ejecución con mysqli
$resultado = $link->query($sql);

if (!$resultado) {
    // Manejo de errores con mysqli
    die("Error al ejecutar la consulta principal: " . $link->error);
}

// Bucle principal: usar fetch_assoc()
while($row = $resultado->fetch_assoc())
{
	$pdf->AddPage();

	$pdf->SetFont('Arial','B',24);
	$pdf->Image('../phpimages/logo_solo.jpg',85,30,35);
	
	$pdf->SetFont('Arial','B',24);
	$pdf->Ln(60);
	$pdf->Cell(200,7,"FUNERARIA MONUMENTAL",0,0,'C');
	
    // Manejo de la Capilla: Uso de ?? '' para evitar NULL en trim()
    $capilla_nombre = $row["capilla"] ?? "";
    $capilla_display = (trim($capilla_nombre) === "" ? "NINGUNA" : mb_convert_encoding($capilla_nombre, 'ISO-8859-1', 'UTF-8'));
    
	$pdf->Ln(10);
    // LÍNEA 58 CORREGIDA
	$pdf->Cell(200,7,"CAPILLA " . str_replace("CAPILLA ", "", $capilla_display),0,0,'C');
	$pdf->Ln(60);

    // Nombres: Uso de ?? '' para evitar NULL en strlen
    $nombre_fallecido = $row["nombre_fallecido"] ?? "";
    $apellidos_fallecido = $row["apellidos_fallecido"] ?? "";
    
	if(strlen($nombre_fallecido)>=18 || strlen($apellidos_fallecido) >=18) {
        $pdf->SetFont('Arial','B',36);
    } else {
        $pdf->SetFont('Arial','B',46);
    }

    // LÍNEA 74 CORREGIDA
	$pdf->Cell(200,7,mb_convert_encoding($nombre_fallecido, 'ISO-8859-1', 'UTF-8'),0,0,'C');
	$pdf->Ln(20);
    // LÍNEA 76 CORREGIDA
	$pdf->Cell(200,7,mb_convert_encoding($apellidos_fallecido, 'ISO-8859-1', 'UTF-8'),0,0,'C');
	$pdf->Ln(60);
	
	$pdf->SetFont('Arial','B',46);
	$pdf->Cell(200,7,'SALIDA',0,0,'C');
	
    // Fecha y Hora Fin: Uso de ?? ''
    $fecha_fin_display = $row["fecha_fin"] ?? "";
    $hora_fin_display = $row["hora_fin"] ?? "";
    
	$pdf->Ln(20);
	$pdf->Cell(200,7,$fecha_fin_display . " " . $hora_fin_display,0,0,'C');

	$items++;
}

$pdf->EndReport($items);

// Se cierra la conexión a la BD
if (isset($link)) {
    $link->close();
}

$pdf->Output();
?>