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

// Globales para usar en el Header del PDF
$GLOBALS["fecha_sepelio_ini"] = isset($_REQUEST["fecha_sepelio_ini"])?$_REQUEST["fecha_sepelio_ini"]:"0";
$GLOBALS["fecha_sepelio_fin"] = isset($_REQUEST["fecha_sepelio_fin"])?$_REQUEST["fecha_sepelio_fin"]:"0";

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(200,8,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(200,8,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln();
		// Uso de GLOBALS
		$titulo = "ORDEN DE SERVICIO - DESDE: " . $GLOBALS["fecha_sepelio_ini"] . " HASTA: " . $GLOBALS["fecha_sepelio_fin"];
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
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($items)
	{
		$this->SetFont('Arial','B',10);
		$this->Cell(0,5,'Total Ordenes de Servicio: ' . $items,0,0,'C');
	}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();

$count_item = 0;
$items = 0;

// Consulta Principal
$sql = "SELECT 
			view_servicio.Nexpediente, substring(difunto,1,30) difunto, capilla, tipo_servicio, ataud, 
			date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio_fmt, hora_inicio,  
			date_format(fecha_fin, '%d/%m/%Y') as fecha_fin_fmt, hora_fin, 
			date_format(fecha_ofirel, '%d/%m/%Y') as fecha_ofirel_fmt, hora_ofirel, 
			date_format(fecha_sepelio, '%d/%m/%Y') as fecha_sepelio_fmt, hora_sepelio, concat(if(substring(hora_sepelio,6,2)='AM','0:',if(substring(hora_sepelio,1,2)='12','0:','1:')), substring(hora_sepelio,1,5)) as fs, 
			if(ifnull(expe.factura,'')='', 'N', 'S') as pagado, expe.religion 
		FROM view_servicio join sco_expediente as expe ON expe.Nexpediente = view_servicio.Nexpediente 
		WHERE view_servicio.Nexpediente in ($exe) AND IFNULL(fecha_inicio, '0000-00-00') <> '0000-00-00' ORDER BY fecha_sepelio, fs"; 

// Ejecución con mysqli
$resultado = $link->query($sql);

if (!$resultado) {
    die("Error al ejecutar la consulta principal: " . $link->error);
}

// Bucle principal: usar fetch_assoc()
while($row = $resultado->fetch_assoc())
{
	$count_item ++;
    $Nexp = $row["Nexpediente"];
    $tipo_servicio_corto = trim(substr($row["tipo_servicio"] ?? '', 0, 10));
    $capilla_db = $row["capilla"] ?? ''; 
    $es_capilla_vacia = (trim($capilla_db) === '');

    // Llama a la función refactorizada para capilla compartida
    $capilla_compartida = buscar_capilla_compartida_mysqli($link, $Nexp);
    
    // --- Lógica de Capilla y Horas ---
    
    // 1. Determinar el nombre de la capilla
    $capilla_nombre_display = $capilla_db;
    if ($es_capilla_vacia) {
        if ($capilla_compartida) {
            $capilla_nombre_display = $capilla_compartida['capilla'] ?? ($tipo_servicio_corto . " DIRECTA");
        } else {
            $capilla_nombre_display = $tipo_servicio_corto . " DIRECTA";
        }
    }

    // 2. Determinar la hora de inicio (DESDE)
    $hora_inicio_display = $row["hora_inicio"];
    $fecha_fin_hora_fin_display = $row["fecha_fin_fmt"] . " " . $row["hora_fin"];

    if ($es_capilla_vacia && $capilla_compartida) {
        // Si no tiene capilla y es compartida
        if (isset($capilla_compartida['hora_inicio'])) {
            $hora_inicio_display = $capilla_compartida['hora_inicio'];
        }
        if (isset($capilla_compartida['hora_fin'])) {
            // El campo compartido incluye fecha y hora de fin
            $fecha_fin_hora_fin_display = $capilla_compartida['hora_fin']; 
        }
    }
    
    // --- Impresión de Celdas ---
    
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(20,5,"DIFUNTO: ",0,0,'L');
	$pdf->SetFont('Arial','UI',10);
	$pdf->Cell(75,5,substr($row["difunto"] ?? '', 0, 35) ,0,0,'L'); // Uso de ?? ''
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(35,5,"OFICIO RELIGIOSO: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
    // Uso de ?? '' para evitar NULL si la fecha es NULL
	$pdf->Cell(40,5,($row["fecha_ofirel_fmt"] ?? '') . " - " . ($row["hora_ofirel"] ?? ''),0,0,'L');
	$pdf->Cell(20,5,($row["fecha_inicio_fmt"]==$row["fecha_sepelio_fmt"]?"(Entra y Sale)":""),0,0,'L');
	$pdf->Ln();

	$pdf->Cell(10);
	$pdf->SetFont('Arial','BI',10);

	$pdf->Cell(20,5,"CAPILLA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(40,5,$capilla_nombre_display,0,0,'L'); // Usa la variable ya calculada
    
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,5,"DESDE: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(20,5,$hora_inicio_display,0,0,'L'); // Usa la variable ya calculada
    
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,5,"HASTA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(35,5,$fecha_fin_hora_fin_display,0,0,'L'); // Usa la variable ya calculada

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(62,5,substr($row["tipo_servicio"] ?? '',0,3) . " (" . ($row["fecha_sepelio_fmt"] ?? '') . " " . ($row["hora_sepelio"] ?? '') .")",0,0,'L');
	$pdf->Cell(8,5,($row["pagado"]=='S'?chr(36):""),0,0,'L');

	$pdf->Ln();
	$pdf->Cell(10);
	$pdf->Cell(80,5,"RELIGION: " . ($row["religion"] ?? ''),0,0,'L'); // Uso de ?? ''
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(40,5," ( Exp.: " . $row["Nexpediente"] . " ) ",0,0,'L');

	$pdf->Ln(8);

	if($count_item == 12) { $pdf->AddPage(); $count_item = 0; }
	$items++;
}

$pdf->EndReport($items);

// Se cierra la conexión a la BD
if (isset($link)) {
    $link->close();
}

$pdf->Output();

// --- Función Refactorizada con mysqli y Prepared Statements ---

/**
 * Busca si un expediente comparte capilla (si 'unir_con_expediente' está lleno).
 * Retorna la información de la orden del expediente principal al que está unido.
 * @param mysqli $link Conexión a la base de datos.
 * @param string $Nexp Número de expediente.
 * @return array|null Un array asociativo con 'capilla', 'hora_inicio', 'hora_fin' o null.
 */
function buscar_capilla_compartida_mysqli(mysqli $link, string $Nexp): ?array {
	// Se usa la conexión $link
	$sql = "SELECT 
				c.nombre AS capilla, 
                date_format(b.hora_inicio, '%h:%i%p') as hora_inicio, 
				-- En este reporte, hora_fin devuelve la fecha y hora completa
                concat(date_format(b.fecha_fin, '%d/%m/%Y'), ' ', date_format(b.hora_fin, '%h:%i%p')) as hora_fin 
			FROM 
				sco_expediente a 
				JOIN sco_orden b ON b.expediente = a.unir_con_expediente AND b.paso = '1' 
				JOIN sco_servicio c on c.Nservicio = b.servicio 
			WHERE a.Nexpediente = ?";
    
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("s", $Nexp); // 's' para string
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if($row = $resultado->fetch_assoc()) {
            $stmt->close();
            return $row;
        }
        $stmt->close();
    } else {
        error_log("buscar_capilla_compartida_mysqli prepare error: " . $link->error);
    }
    
    return null;
}
?>