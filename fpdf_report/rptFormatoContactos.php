<?php
// Incluye el archivo de conexión que usa mysqli y define $link
// Asegúrate de que 'conexBD.php' esté en la ruta correcta
require('../dashboard/includes/conexBD.php'); 
require('rcs/fpdf.php'); 

// La variable $link (mysqli object) es asumida desde conexBD.php
$link = $GLOBALS['link']; 

// Se mantiene la zona horaria definida por el usuario
date_default_timezone_set('America/La_Paz'); 

$exe = isset($_REQUEST["exp"])?$_REQUEST["exp"]:"0";
$exe = str_replace("NaN,","",$exe);

// Global para usar en el Header del PDF
$GLOBALS["x_fecha_inicio"] = isset($_REQUEST["x_fecha_inicio"])?$_REQUEST["x_fecha_inicio"]:"0";

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		// Se asume que $GLOBALS["x_fecha_inicio"] tiene valor aquí
		global $x_fecha_inicio; // Acceso directo a la global si se usa un include globalmente
		
		$this->Image('../phpimages/logo_rif.jpg',10,15,70);
		
		$this->ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(270,8,"Fecha: ".date("d/m/Y"),0,0,'R');
		$this->ln();
		$this->Cell(270,8,"Hora: ".date("g:i:s a"),0,0,'R');

		$this->ln();
		// Usar $GLOBALS para acceder a la variable establecida al inicio
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

// Consulta Principal (se mantiene la inyección directa en IN clause, pero se debe asegurar que $exe esté sanitizado)
$sql = "SELECT 
			view_prepara.Nexpediente, substring(difunto,1,30) difunto, capilla, tipo_servicio, ataud, 
			date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio_fmt, hora_inicio,  
			date_format(fecha_fin, '%d/%m/%Y') as fecha_fin_fmt, hora_fin, 
			date_format(fecha_ofirel, '%d/%m/%Y') as fecha_ofirel_fmt, hora_ofirel, 
			date_format(fecha_sepelio, '%d/%m/%Y') as fecha_sepelio_fmt, hora_sepelio, concat(if(substring(hora_sepelio,6,2)='AM','0:',if(substring(hora_sepelio,1,2)='12','0:','1:')), substring(hora_sepelio,1,5)) as fs, 
			if(ifnull(expe.factura,'')='', 'N', 'S') as pagado, 
			expe.permiso, expe.telefono_contacto1, expe.telefono_contacto2, if(ifnull(unir_con_expediente, 0)=0,'N','S') as comparte 
		FROM view_prepara join sco_expediente as expe ON expe.Nexpediente = view_prepara.Nexpediente 
		WHERE view_prepara.Nexpediente in ($exe) AND IFNULL(view_prepara.fecha_inicio, '0000-00-00') <> '0000-00-00' ORDER BY fecha_sepelio, fs";

// Ejecución con mysqli
$resultado = $link->query($sql);

if (!$resultado) {
    // Manejo de errores con mysqli
    die("Error al ejecutar la consulta principal: " . $link->error);
}

$pdf->SetFont('Arial','',8);

// Bucle principal: usar fetch_assoc()
while($row = $resultado->fetch_assoc())
{
	$count_item ++;
    $Nexp = $row["Nexpediente"];
    $tipo_servicio_corto = trim(substr($row["tipo_servicio"] ?? '', 0, 10)); // Manejo de NULL
    $capilla_db = $row["capilla"] ?? ''; // Manejo de NULL
    $es_capilla_vacia = (trim($capilla_db) === '');

    // Llama a la función refactorizada para capilla compartida
    $capilla_compartida = buscar_capilla_compartida_mysqli($link, $Nexp);
    
    // --- Lógica de Capilla y Horas ---
    
    // 1. Determinar el nombre de la capilla y las horas
    $capilla_nombre_completo = '';
    $hora_inicio_display = $row["hora_inicio"];
    $hora_fin_display = $row["hora_fin"];

    if ($es_capilla_vacia) {
        if ($capilla_compartida) {
            // Usa datos de capilla compartida
            $capilla_nombre_completo = $capilla_compartida['capilla'] ?? ($tipo_servicio_corto . " DIRECTA");
            $hora_inicio_display = $capilla_compartida['hora_inicio'] ?? $row["hora_inicio"];
            $hora_fin_display = $capilla_compartida['hora_fin'] ?? $row["hora_fin"];
        } else {
            // No tiene capilla ni comparte (usa servicio + DIRECTA)
            $capilla_nombre_completo = $tipo_servicio_corto . " DIRECTA";
        }
    } else {
        // Usa la capilla de la BD
        $capilla_nombre_completo = strtoupper($capilla_db);
    }
    
    // 2. Formato corto de la capilla para la celda
    $cp = explode(" ", str_replace("CAPILLA ","", $capilla_nombre_completo));
    $capilla_display = (count($cp)>1?substr($cp[0],0,1) . ". ":"") . $cp[count($cp)-1];

    // --- Impresión de Celdas ---

	$pdf->Cell(15,7,$row["Nexpediente"],1,0,'C');
	$pdf->Cell(55,7,substr($row["difunto"], 0, 29),1,0,'L');
	$pdf->Cell(15,7, $capilla_display, 1, 0, 'C');
    
	// DESDE (Hora Inicio)
	$pdf->Cell(15,7, $hora_inicio_display, 1, 0, 'L');
	
    // HASTA (Hora Fin)
	$pdf->Cell(15,7, $hora_fin_display, 1, 0, 'L');
    
	$pdf->Cell(30,7,substr($row["permiso"] ?? '',0,15),1,0,'C'); // Uso de ?? ''
    
	// INH / CREM
	$pdf->Cell(10,7,($tipo_servicio_corto=="CREMACION"?"":"X"),1,0,'C');
	$pdf->Cell(10,7,($tipo_servicio_corto=="CREMACION"?"X":""),1,0,'C');
    
	// FECHA SEPELIO
	$pdf->Cell(30,7,($row["fecha_sepelio_fmt"] ?? '') . " ". ($row["hora_sepelio"] ?? ''),1,0,'C'); // Uso de ?? ''
    
	// TELEFONOS
    $t1 = str_replace(["(", ")", "-", " "], "", $row["telefono_contacto1"] ?? '');
    $t2 = str_replace(["(", ")", "-", " "], "", $row["telefono_contacto2"] ?? '');
	$pdf->Cell(40,7, $t1 . " / " . $t2, 1, 0, 'C');
    
	// OBSERVACIONES
	$observaciones = $es_capilla_vacia ? $tipo_servicio_corto . ($row["comparte"]=="S"?"": " DIRECTA") : '';
	$pdf->Cell(35,7, $observaciones, 1, 0, 'C');
    
	$pdf->ln();

}

$pdf->EndReport($count_item);

// Se cierra la conexión a la BD
if (isset($link)) {
    $link->close();
}

$pdf->Output();

// --- Función Refactorizada con mysqli y Prepared Statements ---

/**
 * Busca si un expediente comparte capilla (si 'unir_con_expediente' está lleno).
 * @param mysqli $link Conexión a la base de datos.
 * @param string $Nexp Número de expediente.
 * @return array|null Un array asociativo con 'capilla', 'hora_inicio', 'hora_fin' o null.
 */
function buscar_capilla_compartida_mysqli(mysqli $link, string $Nexp): ?array {
	// Se eliminó el require("connect.php") y se usa la conexión $link
	$sql = "SELECT 
				c.nombre AS capilla, 
                date_format(b.hora_inicio, '%h:%i%p') as hora_inicio, 
                date_format(b.hora_fin, '%h:%i%p') as hora_fin 
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
    
    // El valor de retorno se maneja directamente en el bucle principal.
    return null;
}
?>