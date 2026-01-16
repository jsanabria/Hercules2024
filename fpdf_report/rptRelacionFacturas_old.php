<?php
require('rcs/fpdf.php');
require("connect.php");
date_default_timezone_set('America/La_Paz');

$fecha_desde = isset($_GET["fecha_desde"])?$_GET["fecha_desde"]:"";
$fecha_hasta = isset($_GET["fecha_hasta"])?$_GET["fecha_hasta"]:"";
$proveedor = isset($_GET["proveedor"])?$_GET["proveedor"]:"";
$tipo_doc = "ENTR"; // isset($_GET["tipo_doc"])?$_GET["tipo_doc"]:"";
$clasificacion = "FACT"; // isset($_GET["clasificacion"])?$_GET["clasificacion"]:"";

if(validar_fechas($fecha_desde) == FALSE)	die("Error en fecha desde");
else $fecha_desde = validar_fechas($fecha_desde);
if(validar_fechas($fecha_hasta) == FALSE)	die("Error en fecha hasta");
else $fecha_hasta = validar_fechas($fecha_hasta);

function validar_fechas($x_fecha)
{
	$x_date = explode("/", $x_fecha);

	for($i=0; $i<count($x_date); $i++) if(!is_numeric($x_date[$i])) return FALSE;

	if(checkdate($x_date[1], $x_date[0], $x_date[2])) 
		// return $x_date[2]."-".$x_date[1]."-".$x_date[0];
		return mktime(0,0,0,(int) $x_date[1],(int) $x_date[0],(int) $x_date[2]);
	else 
		return FALSE;
}

$where = "where 0=0 ";
$where3 = "";
if($proveedor!='') $where .= "and a.proveedor = '$proveedor' ";
if($tipo_doc!='') $where3 = "and a.tipo_doc = '$tipo_doc' ";
if($clasificacion!='') $where3 .= "and a.clasificacion = '$clasificacion' ";
$where .= "and a.fecha between '".date("Ymd", $fecha_desde)."' and '".date("Ymd", $fecha_hasta)."' ";
$where .= $where3;
$where2 .= "and a.fecha between '".date("Ymd", $fecha_desde)."' and '".date("Ymd", $fecha_hasta)."' ";
$where2 .= $where3;

$GLOBALS["sub_titulo_reporte"] = "Fecha Desde: ".date("d/m/Y", $fecha_desde)." Fecha Hasta:".date("d/m/Y", $fecha_hasta).""; // " Estatus: $estatus";
$GLOBALS["titulo_reporte"] = "RELACION DE FACTURACION PROVEEDORES";

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		// Logo
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		// Fecha Hora
		$this->SetFont('Arial','',8);
		$this->Cell(200,10,'Fecha: '.date("d/m/Y"),0,0,'R');
		$this->ln(5);
		$this->Cell(200,10,'Hora: '.date("h:i:s A"),0,0,'R');
		$this->Ln(5);
		$this->SetFont('Arial','BI',15);
		$this->Ln(20);
		// Título
		$this->Cell(200,10,$GLOBALS["titulo_reporte"],0,0,'C');
		$this->Ln(8);

		$this->SetFont('Arial','I',12);
		$this->Cell(200,10,$GLOBALS["sub_titulo_reporte"],0,0,'C');
		// Salto de línea
		$this->Ln(15);
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

$sql = "SELECT DISTINCT a.proveedor Id, b.nombre proveedor FROM sco_entrada_salida a join sco_proveedor b on b.Nproveedor = a.proveedor $where ORDER BY b.nombre;";
$resultado = mysql_query($sql,$enlace) or die(mysql_error()); 
$contar_facturas = 0;
$acumular_totales = 0;
while($row = mysql_fetch_array($resultado)) {
	$proveedor_id = $row["Id"];
	$proveedor = $row["proveedor"];
	$contar_facturas_proveedor = 0;
	$acumular_totales_proveedor = 0;

	// Grupo facturas proveedor
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(25,5,"PROVEEDOR: $proveedor",0,0,'L');
	$pdf->Ln(6);

	// Títulos de columnas
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(30,5,'FECHA.',1,0,'C');
	$pdf->Cell(35,5,'FACTURA',1,0,'L');
	$pdf->Cell(100,5,'NOTA',1,0,'L');
	$pdf->Cell(35,5,'MONTO',1,0,'R');
	
	$pdf->Ln();

	$sql2 = "SELECT 
				a.proveedor, b.nombre as proveedor, date_format(a.fecha, '%d/%m/%Y') as fecha, a.nota, a.documento as factura, a.monto
			FROM 
				sco_entrada_salida a 
				join sco_proveedor b on b.Nproveedor = a.proveedor 
			WHERE
				a.proveedor = '$proveedor_id' $where2 
			ORDER BY a.fecha;"; 
	$resultado2 = mysql_query($sql2,$enlace) or die(mysql_error());
	$pdf->SetFont('Arial','',10);
	while($row2 = mysql_fetch_array($resultado2)) {
		$pdf->Cell(30,5,$row2["fecha"],0,0,'C');
		$pdf->Cell(35,5,substr($row2["factura"],0,16),0,0,'L');
		$pdf->Cell(100,5,substr($row2["nota"],0,45),0,0,'L');
		$pdf->Cell(35,5,number_format($row2["monto"], 2, ",", "."),0,0,'R');
		$pdf->Ln();

		$contar_facturas_proveedor++;
		$acumular_totales_proveedor += $row2["monto"];
	} 

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(200,5,"TOTAL $contar_facturas_proveedor FACTURA(S) PROVEEDOR $proveedor POR Bs.: " . number_format($acumular_totales_proveedor, 2, ",", "."),'T',0,'R');
	$pdf->Ln(8);
	$contar_facturas += $contar_facturas_proveedor;
	$acumular_totales += $acumular_totales_proveedor;
}
$pdf->SetFont('Arial','BI',10);
$pdf->Cell(200,5,"TOTAL " . number_format($contar_facturas, 0, ",", ".") . " FACTURA(S) POR Bs.: " . number_format($acumular_totales, 2, ",", "."),'0',0,'R');
$pdf->Ln(8);



$pdf->Output();
?>