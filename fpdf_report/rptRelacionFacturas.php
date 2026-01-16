<?php
// Incluye la librería FPDF
require('rcs/fpdf.php');
// El archivo conexBD.php debe establecer una conexión $link de mysqli
require('../dashboard/includes/conexBD.php'); 

date_default_timezone_set('America/La_Paz');

// --- 1. PROCESAMIENTO DE PARÁMETROS DE ENTRADA Y SEGURIDAD ---

// Función auxiliar para limpiar y obtener variables GET/POST
function clean_input($data) {
    return (isset($data) && trim($data) != "") ? trim($data) : "";
}

// Función de validación de fechas adaptada para devolver string Y-m-d
function validar_fechas($x_fecha)
{
	$x_date = explode("/", $x_fecha);

	// Verifica formato DD/MM/YYYY y que sean numéricos
	if (count($x_date) != 3 || !is_numeric($x_date[0]) || !is_numeric($x_date[1]) || !is_numeric($x_date[2])) {
        return FALSE;
    }

    // Verifica que sea una fecha válida
	if (checkdate((int) $x_date[1], (int) $x_date[0], (int) $x_date[2])) {
		return $x_date[2]."-".$x_date[1]."-".$x_date[0]; // Retorna YYYY-MM-DD
	} else {
		return FALSE;
    }
}

$exe = clean_input($_REQUEST["exp"]);
$exe = str_replace("NaN,","",$exe);

$fecha_desde = clean_input($_GET["fecha_desde"]);
$fecha_hasta = clean_input($_GET["fecha_hasta"]);
$tipo_doc = "ENTR"; // Valor fijo según el original
$clasificacion = "FACT"; // Valor fijo según el original

// Validación y transformación de fechas
$fecha_desde_db = validar_fechas($fecha_desde);
$fecha_hasta_db = validar_fechas($fecha_hasta);

if ($fecha_desde_db === FALSE || $fecha_hasta_db === FALSE) {
    die("Error: Formato de fecha(s) inválido. Debe ser DD/MM/YYYY.");
}

// La condición WHERE ahora es totalmente dinámica y segura
// Los valores fijos se incluyen directamente
$where = "a.tipo_doc = ? AND a.clasificacion = ? ";
$types = "ss";
$params = [$tipo_doc, $clasificacion];

// Manejo del filtro por Nentrada_salida (exp) - CRÍTICO: La lista debe ser de enteros.
if (!empty($exe)) {
    // Se asume que $exe es una lista de IDs separados por comas.
    // Para seguridad, se debe validar que solo contenga números y comas.
    // Nota: bind_param no funciona directamente con IN (?), por lo que se construye dinámicamente.
    
    $ids = explode(',', $exe);
    $valid_ids = [];
    foreach ($ids as $id) {
        if (is_numeric(trim($id)) && trim($id) > 0) {
            $valid_ids[] = (int)trim($id);
        }
    }
    
    if (count($valid_ids) > 0) {
        $in_placeholders = implode(',', array_fill(0, count($valid_ids), '?'));
        $where .= "AND a.Nentrada_salida IN ($in_placeholders) ";
        $types .= str_repeat('i', count($valid_ids));
        $params = array_merge($params, $valid_ids);
    } else {
        // Si no hay IDs válidos, forzar una no-coincidencia
        $where .= "AND 1=0 ";
    }
}

$GLOBALS["sub_titulo_reporte"] = "Fecha Desde: " . date("d/m/Y", strtotime($fecha_desde_db)) . " Fecha Hasta:" . date("d/m/Y", strtotime($fecha_hasta_db)); 
$GLOBALS["titulo_reporte"] = "RELACION DE FACTURACION PROVEEDORES";

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
	}
	
	// Pie de página
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Times','I',8);
		$this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
	}

    // Encabezados de detalle
    function PrintDetailHeaders()
    {
        $this->SetFont('Arial','B',10);
        $this->Cell(30,5,'FECHA.',1,0,'C');
        $this->Cell(35,5,'FACTURA',1,0,'L');
        $this->Cell(100,5,'NOTA',1,0,'L');
        $this->Cell(35,5,'MONTO',1,0,'R');
        $this->Ln();
    }
}

// --- 3. INICIALIZACIÓN Y CONSULTA PRINCIPAL ÚNICA (OPTIMIZACIÓN) ---

$pdf = new PDF('P','mm','LETTER');
$pdf->AliasNbPages();
$pdf->SetFont('Times','',8);
$pdf->AddPage();

$proveedor_actual = "";
$contar_facturas = 0;
$acumular_totales = 0.0;
$contar_facturas_proveedor = 0;
$acumular_totales_proveedor = 0.0;
$sw_first = false;

// Consulta principal: trae todos los detalles ordenados por proveedor
$sql_main = "SELECT 
                a.proveedor AS proveedor_id, 
                b.nombre AS proveedor_nombre, 
                DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, 
                a.nota, 
                a.documento AS factura, 
                a.monto
            FROM 
                sco_entrada_salida a 
                JOIN sco_proveedor b ON b.Nproveedor = a.proveedor 
            WHERE 
                $where 
            ORDER BY 
                b.nombre, a.fecha";

if ($stmt = $link->prepare($sql_main)) {
    // Preparación para bind_param usando referencias
    if (!empty($types)) {
        $bind_params = array_merge([$types], $params);
        $refs = [];
        foreach ($bind_params as $key => $value) {
            $refs[$key] = &$bind_params[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    // --- 4. GENERACIÓN DEL REPORTE CON CORTE DE CONTROL ---
    
    while($row = $resultado->fetch_assoc()) {
        $monto_actual = floatval($row["monto"]);
        
        // CORTE DE CONTROL: Nuevo Proveedor
        if ($proveedor_actual != $row["proveedor_nombre"]) {
            if ($sw_first) {
                // Imprimir total del proveedor anterior
                $pdf->SetFont('Arial','BI',10);
                $pdf->Cell(200,5,"TOTAL $contar_facturas_proveedor FACTURA(S) PROVEEDOR $proveedor_actual POR Bs.: " . number_format($acumular_totales_proveedor, 2, ",", "."),'T',0,'R');
                $pdf->Ln(8);
                
                // Reiniciar totales de proveedor
                $contar_facturas_proveedor = 0;
                $acumular_totales_proveedor = 0.0;
            }
            
            // Iniciar nuevo grupo de proveedor
            $proveedor_actual = $row["proveedor_nombre"];
            $sw_first = true;
            
            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(25,5,"PROVEEDOR: $proveedor_actual",0,0,'L');
            $pdf->Ln(6);
            
            $pdf->PrintDetailHeaders();
        }
        
        // Imprimir detalle de factura
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30,5,$row["fecha"],0,0,'C');
        $pdf->Cell(35,5,substr($row["factura"],0,16),0,0,'L');
        $pdf->Cell(100,5,substr($row["nota"] ?? '',0,45),0,0,'L');
        $pdf->Cell(35,5,number_format($monto_actual, 2, ",", "."),0,0,'R');
        $pdf->Ln();
        
        // Acumular totales
        $contar_facturas_proveedor++;
        $acumular_totales_proveedor += $monto_actual;
        $contar_facturas++;
        $acumular_totales += $monto_actual;
    }
    
    // Imprimir el último subtotal de proveedor
    if ($sw_first) {
        $pdf->SetFont('Arial','BI',10);
        $pdf->Cell(200,5,"TOTAL $contar_facturas_proveedor FACTURA(S) PROVEEDOR $proveedor_actual POR Bs.: " . number_format($acumular_totales_proveedor, 2, ",", "."),'T',0,'R');
        $pdf->Ln(8);
    }
    
    $stmt->close();
} else {
    // Manejo de error de la preparación de la consulta
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 10, 'ERROR DE CONSULTA PREPARADA: ' . $link->error, 0, 1, 'C');
}

// Imprimir total general del reporte
$pdf->SetFont('Arial','BI',10);
$pdf->Cell(200,5,"TOTAL " . number_format($contar_facturas, 0, ",", ".") . " FACTURA(S) POR Bs.: " . number_format($acumular_totales, 2, ",", "."),'0',0,'R');
$pdf->Ln(8);

// Cierre de la conexión (si es necesario)
// require("../dashboard/includes/desconexBD.php");

$pdf->Output();
?>