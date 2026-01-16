<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');
$exe = isset($_REQUEST["exp"])?$_REQUEST["exp"]:"0";
$exe = str_replace("NaN,","",$exe);
$GLOBALS["x_fecha_inicio"] = isset($_REQUEST["x_fecha_inicio"])?$_REQUEST["x_fecha_inicio"]:"0";

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(270,8,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(270,8,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln();
		$titulo = "FORMATO DE CONTACTO -- INICIO SERVICIO: " . $GLOBALS["x_fecha_inicio"];
		$this->ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(260,8,$titulo,0,0,'C');
		$this->ln(10);

		$this->SetFont('Arial','BI',8);
		$this->Cell(15,7,"Exp.",1,0,'C');
		$this->Cell(55,7,"FALLECIDO",1,0,'C');
		$this->Cell(15,7,"CAPILLA",1,0,'C');
		$this->Cell(15,7,"DESDE",1,0,'C');
		$this->Cell(15,7,"HASTA",1,0,'C');
		$this->Cell(30,7,"CERTIF.",1,0,'C');
		$this->Cell(10,7,"INH",1,0,'C');
		$this->Cell(10,7,"CREM",1,0,'C');
		$this->Cell(30,7,"FECHA",1,0,'C');
		$this->Cell(40,7,"TELEFONOS",1,0,'C');
		$this->Cell(35,7,"OBSERVACIONES",1,0,'C');
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
	
	function EndReport($items)
	{
		$this->SetFont('Arial','B',10);
		$this->ln();
		$this->Cell(0,5,'Total Servicio: ' . $items,0,0,'C');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage('L','Letter');

$count_item = 0;

$sql = "SELECT 
			view_prepara.Nexpediente, substring(difunto,1,30) difunto, capilla, tipo_servicio, ataud, 
			date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio, hora_inicio,  
			date_format(fecha_fin, '%d/%m/%Y') as fecha_fin, hora_fin, 
			date_format(fecha_ofirel, '%d/%m/%Y') as fecha_ofirel, hora_ofirel, 
			date_format(fecha_sepelio, '%d/%m/%Y') as fecha_sepelio, hora_sepelio, concat(if(substring(hora_sepelio,6,2)='AM','0:',if(substring(hora_sepelio,1,2)='12','0:','1:')), substring(hora_sepelio,1,5)) as fs, 
			if(ifnull(expe.factura,'')='', 'N', 'S') as pagado, 
			expe.permiso, expe.telefono_contacto1, expe.telefono_contacto2 
		FROM view_prepara join sco_expediente as expe ON expe.Nexpediente = view_prepara.Nexpediente 
		WHERE view_prepara.Nexpediente in ($exe) AND IFNULL(view_prepara.fecha_inicio, '0000-00-00') <> '0000-00-00' ORDER BY fecha_sepelio, fs;";
		// WHERE date_format(fecha_inicio, '%d/%m/%Y') = '" . $GLOBALS["x_fecha_inicio"] . "' ORDER BY fecha_sepelio, fs;"; 

$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$pdf->SetFont('Arial','',8);
while($row = mysql_fetch_array($resultado))
{
	$count_item ++;

	$pdf->Cell(15,7,$row["Nexpediente"],1,0,'C');
	$pdf->Cell(55,7,substr($row["difunto"], 0, 29),1,0,'L');
	$cp = explode(" ", str_replace("CAPILLA ","",trim($row["capilla"])==''?(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "capilla")):strtoupper($row["capilla"])));
	$pdf->Cell(15,7, (count($cp)>1?substr($cp[0],0,1) . ". ":"") . $cp[count($cp)-1],1,0,'C');
	//$pdf->Cell(15,7,$row["hora_inicio"],1,0,'C');
	$pdf->Cell(15,7,(trim($row["capilla"])==''?(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "fecha_inicio"))=="1"?$row["hora_inicio"]:
	(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "hora_inicio")):$row["hora_inicio"]),1,0,'L');
	//$pdf->Cell(15,7,$row["hora_fin"],1,0,'C');
	$pdf->Cell(15,7,(trim($row["capilla"])==''?(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "fecha_inicio"))=="1"?$row["hora_fin"]:
	(buscar_capilla_compartida($row["Nexpediente"], substr($row["tipo_servicio"], 0, 10), "hora_fin")):$row["hora_fin"]),1,0,'L');
	$pdf->Cell(30,7,substr($row["permiso"],0,15),1,0,'C');
	$pdf->Cell(10,7,(trim(substr($row["tipo_servicio"], 0, 10))=="CREMACION"?"":"X"),1,0,'C');
	$pdf->Cell(10,7,(trim(substr($row["tipo_servicio"], 0, 10))=="CREMACION"?"X":""),1,0,'C');
	$pdf->Cell(30,7,$row["fecha_sepelio"] . " ". $row["hora_sepelio"],1,0,'C');
	$pdf->Cell(40,7,str_replace("(","",str_replace(")","",str_replace("-","",str_replace(" ","",$row["telefono_contacto1"])))) . " / " . str_replace("(","",str_replace(")","",str_replace("-","",str_replace(" ","",$row["telefono_contacto2"])))),1,0,'C');
	$pdf->Cell(35,7,(trim($row["capilla"])==''?substr($row["tipo_servicio"], 0, 10) . " DIRECTA":''),1,0,'C');
	$pdf->ln();

}

$pdf->EndReport($count_item);

	
require("desconnect.php");

$pdf->Output();

function buscar_capilla_compartida($Nexp, $serv, $campo) {
	require("connect.php");
	$sql = "SELECT 
				c.nombre AS capilla, date_format(b.hora_inicio, '%h:%i%p') as hora_inicio, date_format(b.hora_fin, '%h:%i%p') as hora_fin 
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