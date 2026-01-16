<?php
require('rcs/fpdf.php');
require("connect.php");

$fecha_desde = isset($_REQUEST["fecha_desde"])?$_REQUEST["fecha_desde"]:"0000-00-00";
$fecha_hasta = isset($_REQUEST["fecha_hasta"])?$_REQUEST["fecha_hasta"]:"0000-00-00";

$xFec = explode("-", $fecha_desde);
$GLOBALS["desde"] = $xFec[2] . "/" . $xFec[1] . "/" . $xFec[0];
$xFec = explode("-", $fecha_hasta);
$GLOBALS["hasta"] =  $xFec[2] . "/" . $xFec[1] . "/" . $xFec[0];
class PDF extends FPDF
{
	// Cabecera de pαgina
	function Header()
	{
		// Consulto datos de la compaρνa 
		require("connect.php");
		$sql = "select 
					valor1 as cia, valor2 as rif, valor3 as direccion, valor4 as telefono
				from sco_parametro where codigo = '001';"; 
		$resultado = mysql_query($sql,$enlace) or die(mysql_error());
		$row_datos = mysql_fetch_array($resultado);
		
		$cia =  $row_datos["cia"];
		$rif =  $row_datos["rif"];
		$direccion =  $row_datos["direccion"];
		$telefono =  $row_datos["telefono"];
		

		// Logo
		$this->Image('../phpimages/logo_rif.jpg',10,15,100);
		$this->Ln(20);
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'Fecha: ' . date("d/m/Y"),0,0,'R');
		$this->ln();
		//$this->Cell(200,5,"Tipo Proveedor: $tipo_proveedor",0,0,'R');

		$this->ln(15);
		$this->SetFont('Arial','B',14);
		//$this->Cell(200,8,utf8_decode($proveedor),0,0,'C');
		$this->Cell(200,8,"Estatus Registros de Lαpidas por ESTATUS",0,0,'C');
		$this->ln();
		$this->Cell(200,8,"Fecha Modificaciσn Desde: " . $GLOBALS["desde"] . " Hasta: " . $GLOBALS["hasta"],0,0,'C');
		$this->ln();

		$this->ln(10);

		require("desconnect.php");
		
		$this->SetFillColor(236, 236, 236);
		$this->SetFont('Arial','B',8);
		$this->Cell(15,5,'ID','B','0','C',true);
		$this->Cell(50,5,'SOLICITANTE','B','0','L',true);
		$this->Cell(20,5,'PARENT','B','0','L',true);
		$this->Cell(55,5,'DIFUNTO','B','0','L',true);
		$this->Cell(20,5,'FECHA MOD.','B','0','L',true);
		$this->Cell(40,5,'USUARIO MOD.','B','0','L',true);
		$this->Ln(6);
		
	}
	
	// Pie de pαgina
	function Footer()
	{
		// Posiciσn: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Nϊmero de pαgina
		$this->ln();
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($count)
	{
		$this->SetFillColor(236, 236, 236);
		$this->SetFont('Arial','B',8);
		$this->Cell(20);
		$this->Cell(160,5,"TOTAL REGISTROS: $count",'T','0','R',true);
		$this->Cell(20);
		$this->Ln(6);
	}
}

// Creaciσn del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$count = 0;

$sql = "SELECT 
			DISTINCT a.estatus 
		FROM 
			sco_lapidas_registro AS a 
			LEFT OUTER JOIN sco_user AS b ON b.username = a.modifica 
			LEFT OUTER JOIN sco_tabla AS c ON c.campo_codigo = a.parentesco 
		WHERE 
			a.modificacion BETWEEN '$fecha_desde' AND '$fecha_hasta' AND c.tabla = 'PARENTESCOS' 
		ORDER BY a.estatus;";
$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
while($row = mysql_fetch_array($resultado))
{
	$pdf->SetFont('Arial','BI', 8);
	$pdf->Cell(200,5,'ESTATUS: ' . $row["estatus"],'0','0','L',false);
	$pdf->ln(6);
	
	$pdf->SetFont('Arial','',8);
	$count_item = 0;
	
	$sql = "SELECT 
				a.Nlapidas_registro, a.solicitante, 
				c.campo_descripcion AS parentesco, a.nombre_difunto, 
				date_format(a.modificacion, '%d/%m/%Y') AS modificacion, b.nombre AS modifica, a.estatus 
			FROM 
				sco_lapidas_registro AS a 
				LEFT OUTER JOIN sco_user AS b ON b.username = a.modifica 
				LEFT OUTER JOIN sco_tabla AS c ON c.campo_codigo = a.parentesco 
			WHERE 
				a.modificacion BETWEEN '$fecha_desde' AND '$fecha_hasta' AND c.tabla = 'PARENTESCOS' 
				AND a.estatus = '" . $row["estatus"] . "' 
			ORDER BY a.estatus, a.modificacion;";
	$rs = mysql_query($sql,$enlace) or die(mysql_error()); 
	while($row2 = mysql_fetch_array($rs)) {
		$pdf->Cell(15,4,$row2["Nlapidas_registro"],'0','0','L',false);
		$pdf->Cell(50,4,substr($row2["solicitante"], 0, 20),'0','0','L',false);
		$pdf->Cell(20,4,$row2["parentesco"],'0','0','L',false);
		$pdf->Cell(55,4,substr($row2["nombre_difunto"], 0, 23),'0','0','L',false);
		$pdf->Cell(20,4,$row2["modificacion"],'0','0','L',false);
		$pdf->Cell(40,4,substr($row2["modifica"], 0, 20),'0','0','L',false);
		$pdf->Ln(4);
		$count_item ++;
	}
	$count += $count_item; 
	$pdf->SetFont('Arial','BI', 8);
	$pdf->Cell(200,5,'Total ESTATUS (' . $row["estatus"] . '): ' . $count_item,'0','0','R',false);
	$pdf->ln();
	$pdf->AddPage();
}


$pdf->EndReport($count);

	
require("desconnect.php");

$pdf->Output();
?>