<?php
// Asegúrate de que el archivo fpdf.php esté en la ruta correcta
require('rcs/fpdf.php'); 
// El archivo connect.php debe establecer una conexión $link de mysqli
require('../dashboard/includes/conexBD.php'); 
date_default_timezone_set('America/La_Paz');

// --- 1. PROCESAMIENTO DE PARÁMETROS DE ENTRADA Y CONSTRUCCIÓN DE LA CLÁUSULA WHERE ---

// Función auxiliar para obtener y limpiar variables GET/POST
function clean_input($data) {
    return (isset($data) && trim($data) != "") ? trim($data) : "";
}

$fecha_desde_param = clean_input($_REQUEST["fecha_desde"]);
$fecha_hasta_param = clean_input($_REQUEST["fecha_hasta"]);
$cia_param = clean_input($_REQUEST["cia"]);
$username_param = clean_input($_REQUEST["username"]);

$where = "WHERE IFNULL(a.estatus, 0) = 0 ";
$fd = "00/00/0000";
$fh = "00/00/0000";
$params = [];
$types = "";

// Lógica de fechas
if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha_desde_param) && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha_hasta_param)) {
    // Formato dd/mm/yyyy
    $fd = $fecha_desde_param;
    $fh = $fecha_hasta_param;

    $fecha_d = DateTime::createFromFormat('d/m/Y', $fd);
    $fecha_h = DateTime::createFromFormat('d/m/Y', $fh);

    $fecha_desde_db = $fecha_d->format('Y-m-d') . " 00:00:00";
    $fecha_hasta_db = $fecha_h->format('Y-m-d') . " 23:59:59";
    
    // Se usa la columna 'fecha_registro'
    $where .= "AND a.fecha_registro BETWEEN ? AND ? ";
    $types .= "ss";
    $params[] = $fecha_desde_db;
    $params[] = $fecha_hasta_db;
    
} else {
    // Lógica alternativa para fechas (asumiendo fecha_desde2/fecha_hasta2)
    $fecha_desde_param2 = clean_input($_REQUEST["fecha_desde2"]);
    $fecha_hasta_param2 = clean_input($_REQUEST["fecha_hasta2"]);
    
    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha_desde_param2) && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha_hasta_param2)) {
        $fd = $fecha_desde_param2;
        $fh = $fecha_hasta_param2;
        
        $fecha_d = DateTime::createFromFormat('d/m/Y', $fd);
        $fecha_h = DateTime::createFromFormat('d/m/Y', $fh);
        
        $fecha_desde_db = $fecha_d->format('Y-m-d') . " 00:00:00";
        $fecha_hasta_db = $fecha_h->format('Y-m-d') . " 23:59:59";

        // Se usa la columna 'fecha'
        $where .= "AND a.fecha BETWEEN ? AND ? ";
        $types .= "ss";
        $params[] = $fecha_desde_db;
        $params[] = $fecha_hasta_db;
    }
}

// Filtro por Compañía (cia)
if (trim($cia_param) != "") {
    // Asumiendo que cia es un entero
    $where .= "AND a.cia = ? ";
    $types .= "i";
    $params[] = (int)$cia_param;
}

// Filtro por Nombre de Usuario (username)
if (trim($username_param) != "") {
    // Asumiendo que username es un string. Cuidado: el WHERE original no tiene AND inicial aquí.
    if (strpos($where, 'WHERE') !== false) {
        $where .= " AND a.username = ? ";
    } else {
        $where .= " a.username = ? ";
    }
    $types .= "s";
    $params[] = $username_param;
}

$titulo = "FACTURAS POR EXPEDIENTE DESDE: $fd HASTA: $fh";
$GLOBALS["titulo"] = $titulo;

// --- 2. DEFINICIÓN DE LA CLASE PDF ---

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->ln(6);
		$this->SetFont('Arial','',8);
		$this->Cell(280,8,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(280,8,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(280,8,$GLOBALS["titulo"],0,0,'C');
		$this->ln(10);

		$this->SetFont('Arial','B',8);
		$this->Cell(10);
		$this->Cell(35,5,"CIA",1,0,'L');
		$this->Cell(35,5,"SERVICIO",1,0,'L');
		$this->Cell(15,5,"#EXP",1,0,'C');
		$this->Cell(20,5,"FECHA REG.",1,0,'L'); // Ajustado para reflejar el campo
		$this->Cell(35,5,"NOMBRE FALLECIDO",1,0,'L');
		$this->Cell(35,5,"APELLIDO FALLECIDO",1,0,'L');
		$this->Cell(20,5,"FACTURA",1,0,'C');
		$this->Cell(30,5,"MONTO",1,0,'R');
		$this->Cell(30,5,"USUARIO",1,0,'L');
		$this->Cell(20,5,"FECHA FACT.",1,0,'L'); // Ajustado para reflejar el campo 'fecha'
		$this->ln();
	}
	
	// Pie de página
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->ln();
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($count_item, $monto)
	{
		$this->SetFont('Arial','B',8);
		$this->Cell(10);
		$this->Cell(195,5,'Total Facturas Por Expedientes: ' . $count_item, 1, 0, 'R');
		$this->Cell(30,5,number_format($monto, 2, ",", "."), 1, 0, 'R');
		$this->Cell(50,5,'', 1, 0, 'R');
	}
}

// --- 3. INICIALIZACIÓN DEL PDF ---

$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage("L");

$items = 0;
$monto = 0.0;
$cia_actual = "..."; // Variable para el control de corte
$xit = 0;
$xmon = 0.0;
$sw = false;

// --- 4. CONSULTA A LA BASE DE DATOS (CONSULTA PREPARADA) ---

$sql = "SELECT 
			b.nombre AS cia, c.nombre AS servicio, 
			a.Nexpediente AS expediente, DATE_FORMAT(a.fecha_registro, '%d/%m/%Y') AS fecha_registro, 
			a.nombre_fallecido, a.apellidos_fallecido, a.factura, 
			a.monto, d.nombre AS username, DATE_FORMAT(a.fecha, '%d/%m/%Y') AS registro 
		FROM 
			view_exp_factura AS a 
			LEFT OUTER JOIN sco_cia AS b ON b.Ncia = a.cia 
			LEFT OUTER JOIN sco_servicio_tipo AS c ON c.Nservicio_tipo = a.servicio_tipo 
			LEFT OUTER JOIN sco_user AS d ON d.username = a.username 
		$where 
		ORDER BY 
			a.cia, a.username, a.fecha_registro"; // Orden cambiado para agrupar por CIA

// Ejecutar la consulta preparada
if ($stmt = $link->prepare($sql)) {
    // Solo enlazar si hay parámetros (siempre habrá fechas)
    if (count($params) > 0) {
        // Preparación para bind_param usando referencias
        $bind_params = array_merge([$types], $params);
        $refs = [];
        foreach ($bind_params as $key => $value) {
            $refs[$key] = &$bind_params[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();

    // --- 5. GENERACIÓN DEL CONTENIDO DEL REPORTE ---
    
    while ($row = $resultado->fetch_assoc()) {
        $monto_actual = floatval($row["monto"]);

        // Cálculo de subtotales por Compañía (CIA)
        if ($cia_actual != $row["cia"]) { 
            if ($sw) {
                // Imprimir subtotal de la compañía anterior
                $pdf->SetFont('Arial','BI',8);
                $pdf->Cell(10);
                $pdf->Cell(195,5,"Total Compañia: " . $xit,0,0,'R');
                $pdf->Cell(30,5,number_format($xmon, 2, ",", "."), 0, 0, 'R');
                $pdf->Cell(50,5,"", 0, 0, 'R');
                $pdf->ln();

                $xit = 0;
                $xmon = 0.0;
            }

            // Iniciar nueva compañía
            $pdf->SetFont('Arial','BI',8);
            $pdf->Cell(10);
            $pdf->Cell(35,5,"Compañia: " . $row["cia"], 0, 0, 'L');
            $pdf->ln();
            $cia_actual = $row["cia"];
            $sw = true;
        }

        // Imprimir detalle de la fila
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(10);
        $pdf->Cell(35,5,substr($row["cia"] ?? '', 0, 15),0,0,'L');
        $pdf->Cell(35,5,substr($row["servicio"] ?? '', 0, 15),0,0,'L');
        $pdf->Cell(15,5,$row["expediente"],0,0,'C');
        $pdf->Cell(20,5,$row["fecha_registro"],0,0,'L');
        $pdf->Cell(35,5,substr($row["nombre_fallecido"], 0, 15),0,0,'L');
        $pdf->Cell(35,5,substr($row["apellidos_fallecido"], 0, 15),0,0,'L');
        $pdf->Cell(20,5,$row["factura"],0,0,'C');
        $pdf->Cell(30,5,number_format($monto_actual, 2, ",", "."),0,0,'R');
        $pdf->Cell(30,5,substr($row["username"] ?? '', 0, 15),0,0,'L');
        $pdf->Cell(20,5,$row["registro"],0,0,'L');
        $pdf->ln();

        // Acumular totales de subtotal y total general
        $xit ++;
        $xmon += $monto_actual;
        $items ++;
        $monto += $monto_actual;
    }

    // Imprimir el último subtotal de compañía
    if ($sw) {
        $pdf->SetFont('Arial','BI',8);
        $pdf->Cell(10);
        $pdf->Cell(195,5,"Total Compañia: " . $xit,0,0,'R');
        $pdf->Cell(30,5,number_format($xmon, 2, ",", "."), 0, 0, 'R');
        $pdf->Cell(50,5,"", 0, 0, 'R');
        $pdf->ln();
    }

    $stmt->close();
} else {
    // Manejo de error de la preparación de la consulta
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 10, 'ERROR DE CONSULTA PREPARADA: ' . $link->error, 0, 1, 'C');
}

// Imprimir el total general del reporte
$pdf->EndReport($items, $monto);

// Aquí se debería cerrar la conexión a la base de datos si es necesario
// $link->close(); 

$pdf->Output();

?>