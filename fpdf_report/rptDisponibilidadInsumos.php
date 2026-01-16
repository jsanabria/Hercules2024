<?php
// Incluye la librería FPDF
require('rcs/fpdf.php');
// El archivo connect.php debe establecer una conexión $link de mysqli
require('../dashboard/includes/conexBD.php'); 
date_default_timezone_set('America/La_Paz');

// --- 1. PROCESAMIENTO DE PARÁMETROS DE ENTRADA Y SEGURIDAD ---

// Función auxiliar para limpiar y obtener variables GET/POST
function clean_input($data) {
    return (isset($data) && trim($data) != "") ? trim($data) : "";
}

$exe = clean_input($_REQUEST["exp"] ?? '');
$exe = str_replace("NaN,","",$exe); // La variable $exe no se usa en el SQL principal, pero se mantiene el procesamiento.

$fecha_desde = clean_input($_GET["fecha_desde"]);
$fecha_hasta = clean_input($_GET["fecha_hasta"]);

$bt = ""; // Condición BETWEEN para IN y OUT
$bt2 = ""; // Condición <= para STOCK

$fecha_desde_db = "";
$fecha_hasta_db = "";

if(strlen($fecha_desde) == 10 && strlen($fecha_hasta) == 10) {
    // Validar y normalizar las fechas (asumiendo formato YYYY-MM-DD del GET)
    // Si las fechas vinieran como DD/MM/YYYY, se debería usar DateTime::createFromFormat
    
    // Normalizamos para asegurar que sean formatos seguros para la DB
    $fecha_d = date('Y-m-d', strtotime($fecha_desde));
    $fecha_h = date('Y-m-d', strtotime($fecha_hasta));
    
    $fecha_desde_db = $fecha_d;
    $fecha_hasta_db = $fecha_h;

    // Las variables bt y bt2 ya no se concatenan, solo se define el WHERE para la pre-consulta
}

$GLOBALS["sub_titulo_reporte"] = "Fecha Desde: " . $fecha_desde . " Fecha Hasta: " . $fecha_hasta;
$GLOBALS["titulo_reporte"] = "RELACION EXISTENCIA INSUMOS FUNERARIOS";

// --- 2. CLASE FPDF ---

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->SetFont('Arial','',8);
		$this->Cell(200,10,'Fecha: '.date("d/m/Y"),0,0,'R');
		$this->ln(5);
		$this->Cell(200,10,'Hora: '.date("h:i:s A"),0,0,'R');
		$this->Ln(5);
		$this->SetFont('Arial','BI',15);
		$this->Ln(20);
		
		$this->Cell(200,10,$GLOBALS["titulo_reporte"],0,0,'C');
		$this->Ln(8);

		$this->SetFont('Arial','I',12);
		$this->Cell(200,10,$GLOBALS["sub_titulo_reporte"],0,0,'C');
		$this->Ln(15);

		$this->SetFont('Arial','B',10);
		$this->Cell(40,5,'Tipo.',1,0,'C');
		$this->Cell(70,5,'Descripción',1,0,'L');
		$this->Cell(15,5,'Art. Inv.',1,0,'R');
		$this->Cell(25,5,'IN',1,0,'R');
		$this->Cell(25,5,'OUT',1,0,'R');
		$this->Cell(25,5,'Stock',1,0,'R');

		$this->Ln();
	}
	
	// Pie de página
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Times','I',8);
		$this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

// --- 3. INICIALIZACIÓN Y PRE-CÁLCULOS DE INVENTARIO (OPTIMIZACIÓN) ---

$pdf = new PDF('P','mm','LETTER');
$pdf->AliasNbPages();
$pdf->SetFont('Times','',8);
$pdf->AddPage();

$data_in = [];
$data_out = [];
$data_stock = [];
$data_tipo_nombre = [];


// A. PRE-CALCULAR ENTRADAS (IN) PARA EL PERÍODO
$sql_in = "SELECT SUM(a.cantidad) as entradas, a.articulo
           FROM sco_entrada_salida_detalle a 
           JOIN sco_entrada_salida b ON b.Nentrada_salida = a.entrada_salida 
           WHERE a.cantidad >= 0 AND b.fecha BETWEEN ? AND ?
           GROUP BY a.articulo;";

if ($stmt = $link->prepare($sql_in)) {
    $stmt->bind_param("ss", $fecha_desde_db, $fecha_hasta_db);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($row = $resultado->fetch_assoc()) {
        $data_in[$row['articulo']] = $row['entradas'];
    }
    $stmt->close();
} else { echo "Error en SQL_IN: " . $link->error; }


// B. PRE-CALCULAR SALIDAS (OUT) PARA EL PERÍODO
$sql_out = "SELECT SUM(a.cantidad) as salidas, a.articulo
            FROM sco_entrada_salida_detalle a 
            JOIN sco_entrada_salida b ON b.Nentrada_salida = a.entrada_salida 
            WHERE a.cantidad < 0 AND b.fecha BETWEEN ? AND ?
            GROUP BY a.articulo;";

if ($stmt = $link->prepare($sql_out)) {
    $stmt->bind_param("ss", $fecha_desde_db, $fecha_hasta_db);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($row = $resultado->fetch_assoc()) {
        // Las salidas se almacenan como negativo en la DB, las convertimos a positivo para el reporte
        $data_out[$row['articulo']] = abs($row['salidas']); 
    }
    $stmt->close();
} else { echo "Error en SQL_OUT: " . $link->error; }


// C. PRE-CALCULAR STOCK ACUMULADO HASTA LA FECHA DE FIN
$sql_stock = "SELECT SUM(a.cantidad) as stock, a.articulo
              FROM sco_entrada_salida_detalle a 
              JOIN sco_entrada_salida b ON b.Nentrada_salida = a.entrada_salida 
              WHERE b.fecha <= ?
              GROUP BY a.articulo;";

if ($stmt = $link->prepare($sql_stock)) {
    $stmt->bind_param("s", $fecha_hasta_db);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($row = $resultado->fetch_assoc()) {
        $data_stock[$row['articulo']] = $row['stock'];
    }
    $stmt->close();
} else { echo "Error en SQL_STOCK: " . $link->error; }


// D. PRE-CALCULAR NOMBRES DE TIPOS DE SERVICIO
$sql_tipo = "SELECT Nservicio_tipo, nombre FROM sco_servicio_tipo;";
if ($resultado = $link->query($sql_tipo)) {
    while ($row = $resultado->fetch_assoc()) {
        $data_tipo_nombre[$row['Nservicio_tipo']] = $row['nombre'];
    }
} else { echo "Error en SQL_TIPO: " . $link->error; }


// --- 4. CONSULTA PRINCIPAL Y GENERACIÓN DEL REPORTE ---

$sql_main = "SELECT 
			a.tipo, a.Nservicio, a.nombre, IF(a.articulo_inventario='S', 'SI', 'NO') as articulo_inventario, 
			IF(a.activo='S', 'SI', 'NO') as activo, a.sto_min 
		FROM view_insumos a ORDER BY a.tipo, a.nombre;";

$contar_insumos = 0;

$pdf->SetFont('Arial','',10);

if ($resultado_main = $link->query($sql_main)) {
    while($row = $resultado_main->fetch_assoc()) {
        $Nservicio = $row["Nservicio"];
        
        // 1. Tipo de Servicio (Lookup)
        $tipo_nombre = isset($data_tipo_nombre[$row["tipo"]]) ? $data_tipo_nombre[$row["tipo"]] : 'N/D';
        
        // 2. Entradas (Lookup)
        $entradas = isset($data_in[$Nservicio]) ? $data_in[$Nservicio] : 0;
        
        // 3. Salidas (Lookup)
        $salidas = isset($data_out[$Nservicio]) ? $data_out[$Nservicio] : 0;
        
        // 4. Stock (Lookup)
        $stock = isset($data_stock[$Nservicio]) ? $data_stock[$Nservicio] : 0;

        // Imprimir fila
        $pdf->Cell(40,5,$tipo_nombre,'LR',0,'C');
        $pdf->Cell(70,5,$row["nombre"],'LR',0,'L');
        $pdf->Cell(15,5,$row["articulo_inventario"],'LR',0,'R');
        $pdf->Cell(25,5,number_format($entradas,0,"","."),'LR',0,'R');
        $pdf->Cell(25,5,number_format($salidas,0,"","."),'LR',0,'R');
        $pdf->Cell(25,5,number_format($stock,0,"","."),'LR',0,'R');
        
        $pdf->Ln();

        $contar_insumos++;
    }
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 10, 'ERROR EN CONSULTA PRINCIPAL: ' . $link->error, 0, 1, 'C');
}

// Imprimir total
$pdf->SetFont('Arial','BI',10);
$pdf->Cell(200,5,"TOTAL INSUMOS.: " . number_format($contar_insumos, 0, "", "."),'1',0,'R');
$pdf->Ln(8);

// Cierre de la conexión (si es necesario)
// require("desconnect.php");
// $link->close();

$pdf->Output();
?>