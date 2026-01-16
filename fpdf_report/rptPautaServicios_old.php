<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');

$Nexpediente = $_REQUEST["Nexpediente"];

$sql = "SELECT 
			a.cedula_fallecido, a.sexo, a.nombre_fallecido, a.apellidos_fallecido, 
			a.capilla, date_format(a.fecha_inicio, '%d/%m/%Y') as fecha_inicio, date_format(a.hora_inicio, '%h:%i%p') as hora_inicio, 
			date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin, 
			a.servicio, date_format(a.fecha_serv, '%d/%m/%Y') as fecha_serv, date_format(a.hora_serv, '%h:%i%p') as hora_serv, 
			a.horas, if(a.espera_cenizas='S', 'Espera Cenizas', 'No Espera Cenizas') AS espera_cenizas, a.nombre_contacto, a.email, 
            a.telefono_contacto1, a.telefono_contacto2   
		FROM 
			view_expediente_servicio a 
		WHERE 
			a.Nexpediente = '$Nexpediente'"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs); 
$cedula = $row["cedula_fallecido"];
$sexo = $row["sexo"]; 
$nombre_fallecido = $row["nombre_fallecido"]; 
$apellidos_fallecido = $row["apellidos_fallecido"]; 
$capilla = $row["capilla"]; 
$fecha_inicio = $row["fecha_inicio"]; 
$hora_inicio = $row["hora_inicio"]; 
$fecha_fin = $row["fecha_fin"]; 
$hora_fin = $row["hora_fin"]; 
$servicio = $row["servicio"]; 
$fecha_serv = $row["fecha_serv"]; 
$hora_serv = $row["hora_serv"];
$horas = $row["horas"];
$espera_cenizas = $row["espera_cenizas"];
$email = $row["email"];
$nombre_contacto = $row["nombre_contacto"];
$telefono_contacto1 = $row["telefono_contacto1"];
$telefono_contacto2 = $row["telefono_contacto2"];

$GLOBALS["titulo_reporte"] = "PAUTA DE SERVICIOS FUNERARIA MONUMENTAL";

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		// Logo
		$this->Image('../phpimages/logo_rif.jpg',10,10,70);
		// Fecha Hora
		$this->SetFont('Arial','',8);
		$this->Cell(200,10,'Fecha: '.date("d/m/Y"),0,0,'R');
		$this->ln(5);
		$this->Cell(200,10,'Hora: '.date("h:i:s A"),0,0,'R');
		$this->SetFont('Arial','BI',10);
		$this->Ln(20);
		// Título
		$this->Cell(200,10,$GLOBALS["titulo_reporte"],0,0,'C');
		// Salto de línea
		$this->Ln(10);
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

$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,5,'Difunto:',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(180,5,utf8_decode($nombre_fallecido . ' ' . $apellidos_fallecido . ' -- CI: ' . $cedula),0,0,'L');
$pdf->Ln();

$sql = "SELECT 
			a.Norden, b.nombre AS categoria, date_format(a.fecha_inicio, '%d/%m/%Y') as fecha_inicio, date_format(a.hora_inicio, '%h:%i%p') as hora_inicio , date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin 
		FROM 
			sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio 
		WHERE a.expediente = '$Nexpediente' AND a.paso = '1';";
$rs = mysql_query($sql); 
$paso = false;
while($row = mysql_fetch_array($rs)) {
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(20,6,'Capilla:',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(180,6,utf8_decode($row["categoria"] . ' --  Inicia: ' . $row["fecha_inicio"] . ' ' . $row["hora_inicio"] . ' -- Finaliza: ' . $row["fecha_fin"] . ' ' . $row["hora_fin"]),0,0,'L');
	$pdf->Ln();
}

$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,5,'Servicio:',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(180,5,utf8_decode($servicio . " -- " . (substr(strtoupper($servicio),0,5)=='CREMA'?' - ' . $espera_cenizas: '') . ' ' . $fecha_serv . ' ' . $hora_serv),0,0,'L');
$pdf->Ln();

$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,5,'Contacto:',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(180,5,utf8_decode($nombre_contacto . " Telfs: " . $telefono_contacto1 . ' ' . $telefono_contacto2. ' Email: ' . $email),0,0,'L');
$pdf->Ln();

$sql = "SELECT 
            a.Norden, b.nombre AS categoria, c.nota AS tema, a.nota AS voces, a.cantidad, 
            date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin, c.archivo, a.llevar_a, b.tipo   
        FROM 
            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        WHERE 
            a.paso = '3' AND a.expediente = '$Nexpediente';"; 
$rs = mysql_query($sql); 
$paso = false;
while($row = mysql_fetch_array($rs)) {
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(20,6,utf8_decode(($row["tipo"]=="ATAU"?"ATAUD":$row["tipo"]) . ":"),0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(80,6,$row["categoria"],0,0,'L');
    $paso = true;
}

if($paso == false) {
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(20,5,'Ataud:',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(180,5,'N/A',0,0,'L');
}
$pdf->Ln(8);

// OFICIO RELIGIOSO
/*
$sql = "SELECT 
            COUNT(a.Norden) AS CANTIDAD    
        FROM 
            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        WHERE 
            a.paso = '5' AND a.servicio_tipo = 'RELI' AND a.expediente = '$Nexpediente';";
$rs = mysql_query($sql); 
$paso = false;
$row = mysql_fetch_array($rs);
$CANTIDAD = $row["CANTIDAD"];
if($CANTIDAD>0) {
	$pdf->SetFont('Arial','BIU',8);
	$pdf->Cell(200,5,'OFICIO RELIGIOSO',0,0,'C');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(50,5,'Categoria',0,0,'C');
	$pdf->Cell(30,5,'Tema',0,0,'C');
	$pdf->Cell(30,5,'Voces',0,0,'C');
	$pdf->Cell(30,5,'Capilla',0,0,'C');
	$pdf->Cell(30,5,'Fecha',0,0,'C');
	$pdf->Cell(30,5,'Hora',0,0,'C');
	$pdf->Ln();
	$sql = "SELECT 
	            a.Norden, b.nombre AS categoria, c.nota AS tema, a.nota AS voces, a.cantidad, 
	            date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin, c.archivo, a.llevar_a   
	        FROM 
	            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
	        WHERE 
	            a.paso = '5' AND a.servicio_tipo = 'RELI' AND a.expediente = '$Nexpediente';";
	$rs = mysql_query($sql); 
	$paso = false;
	while($row = mysql_fetch_array($rs)) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(50,5,$row["categoria"],0,0,'C');
		$pdf->Cell(30,5,substr($row["tema"],0,15),0,0,'C');
		$pdf->Cell(30,5,substr($row["voces"],0,15),0,0,'C');
		$pdf->Cell(30,5,$row["llevar_a"],0,0,'C');
		$pdf->Cell(30,5,$row["fecha_fin"],0,0,'C');
		$pdf->Cell(30,5,$row["hora_fin"],0,0,'C');
		$pdf->Ln();

	    $paso = true;
	}

	if($paso == false) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(200,5,'N/A',0,0,'C');
		$pdf->Ln();
	}
	$pdf->Ln(4);
}
*/

// Honores Musicales
$sql = "SELECT 
            COUNT(a.Norden) AS CANTIDAD    
        FROM 
            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        WHERE 
            a.paso = '5' AND a.servicio_tipo = 'OFVO' AND a.expediente = '$Nexpediente';";
$rs = mysql_query($sql); 
$paso = false;
$row = mysql_fetch_array($rs);
$CANTIDAD = $row["CANTIDAD"];
if($CANTIDAD>0) {
	$pdf->SetFont('Arial','BIU',8);
	$pdf->Cell(200,5,'HONORES MUSICALES',0,0,'C');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(50,5,'Categoria',0,0,'C');
	$pdf->Cell(30,5,'Tema',0,0,'C');
	$pdf->Cell(30,5,'Voces',0,0,'C');
	$pdf->Cell(30,5,'Capilla',0,0,'C');
	$pdf->Cell(30,5,'Fecha',0,0,'C');
	$pdf->Cell(30,5,'Hora',0,0,'C');
	$pdf->Ln();
	$sql = "SELECT 
	            a.Norden, b.nombre AS categoria, c.nota AS tema, a.nota AS voces, a.cantidad, 
	            date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin, c.archivo, a.llevar_a   
	        FROM 
	            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
	        WHERE 
	            a.paso = '5' AND a.servicio_tipo = 'OFVO' AND a.expediente = '$Nexpediente';";
	$rs = mysql_query($sql); 
	$paso = false;
	while($row = mysql_fetch_array($rs)) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(50,5,$row["categoria"],0,0,'C');
		$pdf->Cell(30,5,utf8_decode(substr($row["tema"],0,15)),0,0,'C');
		$pdf->Cell(30,5,substr($row["voces"],0,15),0,0,'C');
		$pdf->Cell(30,5,$row["llevar_a"],0,0,'C');
		$pdf->Cell(30,5,$row["fecha_fin"],0,0,'C');
		$pdf->Cell(30,5,$row["hora_fin"],0,0,'C');
		$pdf->Ln();

	    $paso = true;
	}

	if($paso == false) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(200,5,'N/A',0,0,'C');
		$pdf->Ln();
	}
	$pdf->Ln(4);
}

// Arreglos Florales
$sql = "SELECT 
            COUNT(a.Norden) AS CANTIDAD    
        FROM 
            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        WHERE 
            a.paso = '4' AND a.expediente = '$Nexpediente';";
$rs = mysql_query($sql); 
$paso = false;
$row = mysql_fetch_array($rs);
$CANTIDAD = $row["CANTIDAD"];
if($CANTIDAD>0) {
	$pdf->SetFont('Arial','BIU',8);
	$pdf->Cell(200,5,'ARREGLOS FLORALES',0,0,'C');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(30,5,'Categoria',0,0,'C');
	$pdf->Cell(80,5,'Cinta',0,0,'C');
	$pdf->Cell(30,5,'Capilla',0,0,'C');
	$pdf->Cell(30,5,'Fecha',0,0,'C');
	$pdf->Cell(30,5,'Hora',0,0,'C');
	$pdf->Ln();
	$sql = "SELECT 
	            a.Norden, b.nombre AS categoria, c.nota AS tema, a.nota AS voces, a.cantidad, 
	            date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin, c.archivo, a.llevar_a   
	        FROM 
	            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
	        WHERE 
	            a.paso = '4' AND a.expediente = '$Nexpediente';";
	$rs = mysql_query($sql); 
	$paso = false;
	while($row = mysql_fetch_array($rs)) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(30,5,$row["categoria"] . " " . $row["tema"],0,0,'C');
		$pdf->Cell(80,5,substr(utf8_decode($row["voces"]),0,45),0,0,'C');
		$pdf->Cell(30,5,$row["llevar_a"],0,0,'C');
		$pdf->Cell(30,5,$row["fecha_fin"],0,0,'C');
		$pdf->Cell(30,5,$row["hora_fin"],0,0,'C');
		$pdf->Ln();

	    $paso = true;
	}

	if($paso == false) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(200,5,'N/A',0,0,'C');
		$pdf->Ln();
	}
	$pdf->Ln(4);
}

// OBITUARIOS
$sql = "SELECT 
            COUNT(a.Norden) AS CANTIDAD   
        FROM 
            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        WHERE 
            a.paso = '6' AND a.expediente = '$Nexpediente';";
$rs = mysql_query($sql); 
$paso = false;
$row = mysql_fetch_array($rs);
$CANTIDAD = $row["CANTIDAD"];
if($CANTIDAD>0) {
	$pdf->SetFont('Arial','BIU',8);
	$pdf->Cell(200,5,'OBITUARIOS',0,0,'C');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(30,5,'Medio',0,0,'C');
	$pdf->Cell(30,5,'Aviso',0,0,'C');
	$pdf->Cell(110,5,'Esquela',0,0,'C');
	$pdf->Cell(30,5,'Fecha Pauta',0,0,'C');
	$pdf->Ln();
	$sql = "SELECT 
	            a.Norden, b.nombre AS categoria, c.nota AS tema, a.nota AS voces, a.cantidad, 
	            date_format(a.fecha_fin, '%d/%m/%Y') as fecha_fin, date_format(a.hora_fin, '%h:%i%p') as hora_fin, c.archivo, a.llevar_a   
	        FROM 
	            sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio LEFT OUTER JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
	        WHERE 
	            a.paso = '6' AND a.expediente = '$Nexpediente';"; 
	$rs = mysql_query($sql); 
	$paso = false;
	while($row = mysql_fetch_array($rs)) {
		$esq = explode(" --- ", $row["voces"]);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(30,5,$row["categoria"],0,0,'C');
		$pdf->Cell(30,5,utf8_decode($row["tema"]),0,0,'C');
		$pdf->Cell(110,5,utf8_decode(substr(substr($esq[1],11,strlen($esq[1])),0,80)),0,0,'C');
		$pdf->Cell(30,5,$row["fecha_fin"],0,0,'C');
		if(strlen(substr($esq[1],11,strlen($esq[1]))) > 80) {
			$pdf->Ln();
			$pdf->Cell(60,5);
			$pdf->MultiCell(110,5,utf8_decode(substr(substr($esq[1],11,strlen($esq[1])),80)),0,'C');
		}
		$pdf->Ln();

	    $paso = true;
	}

	if($paso == false) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(200,5,'N/A',0,0,'C');
		$pdf->Ln();
	}
	$pdf->Ln(6);
}

$sql = "SELECT venta FROM sco_expediente WHERE Nexpediente = '$Nexpediente';"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$venta = $row["venta"];

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,utf8_decode('Valor de la contratación: Bs. ' . number_format($venta, 2, ",", ".")),0,0,'L');
$pdf->ln();
$pdf->Cell(20,5,utf8_decode('Condiciones de contratación del servicio funerario:'),0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','BU',8);
$pdf->Cell(20,4,utf8_decode('Oficio Religioso:'),0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',8);
$sql = "SELECT CONCAT(IFNULL(valor1,''), ' ', IFNULL(valor2,''), ' ', IFNULL(valor3,''), ' ', IFNULL(valor4,'')) as texto FROM sco_parametro WHERE codigo = '020';"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$texto = $row["texto"];
$text = $texto;
$pdf->MultiCell(200,4,utf8_decode($text),0,'L');
$pdf->ln();

$pdf->SetFont('Arial','BU',8);
$pdf->Cell(20,4,utf8_decode('Refrigerios:'),0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',8);
$sql = "SELECT CONCAT(IFNULL(valor1,''), ' ', IFNULL(valor2,''), ' ', IFNULL(valor3,''), ' ', IFNULL(valor4,'')) as texto FROM sco_parametro WHERE codigo = '021';"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$texto = $row["texto"];
$text = $texto;
$pdf->MultiCell(200,4,utf8_decode($text),0,'L');

$sql = "SELECT CONCAT(IFNULL(valor1,''), ' ', IFNULL(valor2,''), ' ', IFNULL(valor3,''), ' ', IFNULL(valor4,'')) as texto FROM sco_parametro WHERE codigo = '022';"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$texto = $row["texto"];
$pdf->Cell(200,6,utf8_decode($texto),0,0,'C');
$pdf->ln();

$pdf->SetFont('Arial','BU',8);
$pdf->Cell(20,4,utf8_decode('Recargos por cambios de pautas:'),0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',8);
$sql = "SELECT CONCAT(IFNULL(valor1,''), ' ', IFNULL(valor2,''), ' ', IFNULL(valor3,''), ' ', IFNULL(valor4,'')) as texto FROM sco_parametro WHERE codigo = '023';"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$texto = $row["texto"];
$text = $texto;
$pdf->MultiCell(200,4,utf8_decode($text),0,'L');
$pdf->ln();

$pdf->SetFont('Arial','BU',8);
$pdf->Cell(20,4,utf8_decode('Condiciones Generales:'),0,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',8);
$sql = "SELECT CONCAT(IFNULL(valor1,''), ' ', IFNULL(valor2,''), ' ', IFNULL(valor3,''), ' ', IFNULL(valor4,'')) as texto FROM sco_parametro WHERE codigo = '024';"; 
$rs = mysql_query($sql); 
$row = mysql_fetch_array($rs);
$texto = $row["texto"];
$text = $texto;
$pdf->MultiCell(200,4,utf8_decode($text),0,'L');
$pdf->ln();

$pdf->Cell(200,6,utf8_decode('El contratante acepta y está conforme con condiciones de los servicios brindados por Funeraria Monumental C.A'),0,0,'L');
$pdf->ln(10);

$pdf->Cell(80,6,utf8_decode('Por Funeraria Monumental'),0,0,'L');
$pdf->Cell(20,6,utf8_decode('Contratante:'),0,0,'L');
$pdf->Cell(30,6,utf8_decode('Nombre y Apellido:'),0,0,'R');
$pdf->Cell(70,6,utf8_decode('___________________________________'),0,0,'L');
$pdf->ln(10);

$pdf->Cell(130,6,utf8_decode('C.I.:'),0,0,'R');
$pdf->Cell(70,6,utf8_decode('___________________________________'),0,0,'L');
$pdf->ln(10);

$pdf->Cell(130,6,utf8_decode('Firma:'),0,0,'R');
$pdf->Cell(70,6,utf8_decode('___________________________________'),0,0,'L');
$pdf->ln(10);

$pdf->Output();
?>