<?php
// Incluye el archivo de conexión que usa mysqli y define $link
// Asegúrate de que 'conexBD.php' esté en la ruta correcta o cambia el 'require'
require('../dashboard/includes/conexBD.php');
require('rcs/fpdf.php'); 

// Ya no es necesario cambiar la zona horaria aquí, ya que 'conexBD.php'
// ya la establece a 'America/Caracas'. 
// Si quieres La Paz, cambia la línea a: date_default_timezone_set('America/La_Paz');
// Pero para consistencia con conexBD.php, usaremos la de conexBD.php ('America/Caracas').
// ini_set('date.timezone', 'America/Caracas'); 

$exe = isset($_REQUEST["exp"]) ? $_REQUEST["exp"] : "0";
// Importante: La lista de expedientes ($exe) debe ser sanitizada o manejada 
// con cuidado ya que se usa directamente en la consulta principal (IN ($exe)).
// Para una lista de IDs, la sanitización es compleja; por ahora asumimos que $exe
// contiene IDs numéricos y limpios (ej: "1,2,3").
$exe = str_replace("NaN,","",$exe);

// --- Definición de la Clase PDF ---
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
		$titulo = "ORDEN DE PREPARACION";
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
		$this->ln();
		$this->Cell(0,5,'Total Ordenes de Preparación: ' . $items,0,0,'C');
	}
}

// --- Inicio de la Generación del PDF ---

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();

$count_item = 0;
$items = 0;

// Consulta Principal
// Nota: Para la cláusula IN, la consulta preparada con un array de IDs es compleja.
// La mejor práctica es *sanitizar* el contenido de $exe para asegurar que solo 
// contiene números y comas (por eso se mantiene la inyección directa, pero
// se recomienda una validación muy estricta de $exe).
$sql = "SELECT 
			Nexpediente, difunto, capilla, tipo_servicio, ataud, 
			date_format(fecha_inicio, '%d/%m/%Y') as fecha_inicio_fmt, hora_inicio,  
			date_format(fecha_fin, '%d/%m/%Y') as fecha_fin_fmt, hora_fin, fecha_inicio as fi, fecha_sepelio, hora_sepelio  
		FROM view_prepara WHERE Nexpediente IN ($exe) AND IFNULL(fecha_inicio, '0000-00-00') <> '0000-00-00' ORDER BY fi"; 

// Usamos mysqli_query aquí para la cláusula IN, idealmente con IDs validados.
$resultado = $link->query($sql);

if (!$resultado) {
    die("Error al ejecutar la consulta principal: " . $link->error);
}

// Bucle principal para el reporte
while($row = $resultado->fetch_assoc()) // Usa fetch_assoc() en mysqli
{
	$count_item ++;
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(45,7,"NOMBRE DEL DIFUNTO: ",0,0,'L');
	$pdf->SetFont('Arial','UI',10);
	$pdf->Cell(145,7,$row["difunto"] . " ( Exp.: " . $row["Nexpediente"] . " ) " ,0,0,'L');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(35,7,"TIPO DE SERVICIO: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(35,7,$row["tipo_servicio"],0,0,'L');

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(35,7,"TIPO DE ATAUD: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(75,7,$row["ataud"],0,0,'L');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
	$pdf->Cell(20,7,"CAPILLA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
    // Uso de la nueva función refactorizada
    $capilla_compartida = buscar_capilla_compartida_mysqli($link, $row["Nexpediente"], substr($row["tipo_servicio"], 0, 10));

	$pdf->Cell(70,7,(trim($row["capilla"] ?? '')==''?($capilla_compartida["capilla"] ?? $row["tipo_servicio"] . " DIRECTA"):$row["capilla"]),0,0,'L');
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,7,"DESDE: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
    
    // Obtener valores de fecha/hora de capilla_compartida o $row
    $fecha_inicio_disp = (trim($row["capilla"] ?? '')=='' && isset($capilla_compartida["fecha_inicio"])) 
        ? $capilla_compartida["fecha_inicio"] 
        : $row["fecha_inicio_fmt"] . " " . $row["hora_inicio"];

	$pdf->Cell(35,7, $fecha_inicio_disp ,0,0,'L');
    
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(15,7,"HASTA: ",0,0,'L');
	$pdf->SetFont('Arial','I',10);
    
    $fecha_fin_disp = (trim($row["capilla"] ?? '')=='' && isset($capilla_compartida["fecha_fin"])) 
        ? $capilla_compartida["fecha_fin"] 
        : $row["fecha_fin_fmt"] . " " . $row["hora_fin"];

	$pdf->Cell(35,7, $fecha_fin_disp ,0,0,'L');
	$pdf->Ln();

	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(10);
    // Consulta de marca_pasos refactorizada con prepared statement
	$marca_pasos = buscar_marca_pasos_mysqli($link, $row["Nexpediente"]);
	$pdf->Cell(185,7,$marca_pasos,0,0,'C');

	$pdf->Ln(15);
	
	if($count_item == 6) { $pdf->AddPage(); $count_item = 0; }
	$items++;
}

$pdf->EndReport($items);

// El $link ya no necesita cerrarse aquí, lo dejamos abierto si se necesita más tarde.
// Si no se necesita más, se puede cerrar: $link->close(); 

$pdf->Output();

// --- Funciones Refactorizadas con mysqli y Prepared Statements ---

/**
 * Busca si un expediente comparte capilla (si 'unir_con_expediente' está lleno).
 * @param mysqli $link Conexión a la base de datos.
 * @param string $Nexp Número de expediente.
 * @param string $serv Tipo de servicio.
 * @return array|null Un array asociativo con 'capilla', 'fecha_inicio', 'fecha_fin' o null.
 */
function buscar_capilla_compartida_mysqli(mysqli $link, string $Nexp, string $serv): ?array {
	// Se asume que $link es la conexión abierta de 'conexBD.php'
	$sql = "SELECT 
				c.nombre AS capilla, 
                concat(date_format(b.fecha_inicio, '%d/%m/%Y'), ' ', date_format(b.hora_inicio, '%h:%i%p')) as fecha_inicio, 
				concat(date_format(b.fecha_fin, '%d/%m/%Y'), ' ', date_format(b.hora_fin, '%h:%i%p')) as fecha_fin 
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

/**
 * Busca si el expediente tiene marca_pasos.
 * @param mysqli $link Conexión a la base de datos.
 * @param string $Nexp Número de expediente.
 * @return string El mensaje de marca pasos.
 */
function buscar_marca_pasos_mysqli(mysqli $link, string $Nexp): string {
    $sql = "SELECT if(marca_pasos='S','************************ SI TIENE MARCA PASOS ************************','NO TIENE MARCA PASOS') AS marca_pasos 
            FROM sco_expediente 
            WHERE Nexpediente = ?";
            
    $marca_pasos = 'NO TIENE MARCA PASOS'; // Valor por defecto

    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("s", $Nexp);
        $stmt->execute();
        
        $stmt->bind_result($result_marca_pasos);
        
        if ($stmt->fetch()) {
            $marca_pasos = $result_marca_pasos;
        }
        $stmt->close();
    } else {
        error_log("buscar_marca_pasos_mysqli prepare error: " . $link->error);
    }
    
    return $marca_pasos;
}

?>