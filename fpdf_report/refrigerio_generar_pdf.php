<?php
// Incluye el archivo de conexión y FPDF
require_once '../dashboard/includes/conexBD.php';
require_once 'rcs/fpdf.php'; 

// ... AQUÍ VA LA DEFINICIÓN COMPLETA DE LA CLASE PDF_Refrigerio ...
// (Todo el código refactorizado con la clase PDF_Refrigerio que te proporcioné antes)

include 'rptRefrigerio.php';

// --- Bloque de Ejecución para Generar el PDF ---

// 1. Obtener las fechas del usuario (Deberías enviarlas desde la página HTML)
// ¡Asumimos que las fechas se pasan como parámetros GET!
$fechaInicio = isset($_REQUEST["fecha_ini"]) ? $_REQUEST["fecha_ini"] : die("Falta fecha_ini");
$fechaFin = isset($_REQUEST["fecha_fin"]) ? $_REQUEST["fecha_fin"] : die("Falta fecha_fin");

// 2. Creación del objeto de la clase heredada
$pdf = new PDF_Refrigerio($fechaInicio, $fechaFin);
$pdf->SetMargins(10, 10, 10);
$pdf->AliasNbPages();

// 3. Generar el reporte
$pdf->printMeals();

// 4. Salida del PDF (Mostrar en el navegador como descarga o vista)
$pdf->Output('I', 'Reporte_Refrigerios_' . $fechaInicio . '_a_' . $fechaFin . '.pdf');

// Se cierra la conexión a la BD
if (isset($link)) {
	$link->close();
}
?>