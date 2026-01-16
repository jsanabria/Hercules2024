<?php
// sleeping_generar_pdf.php
require_once '../dashboard/includes/conexBD.php';

// Asumimos que rptSleeping.php YA incluye la conexión (conexBD.php)

// ASIGNACIÓN CORRECTA: $fechaInicio, $fechaFin
$fechaInicio = isset($_REQUEST["fecha_ini"]) ? $_REQUEST["fecha_ini"] : die("Falta fecha_ini");
$fechaFin = isset($_REQUEST["fecha_fin"]) ? $_REQUEST["fecha_fin"] : die("Falta fecha_fin");

// VALIDACIÓN CORREGIDA: Usar $fechaInicio y $fechaFin
if (empty($fechaInicio) || empty($fechaFin)) {
    // Al generar PDF, los errores deben ser texto plano (no HTML)
    die("Error: Se requieren las fechas de inicio y fin para procesar la consulta."); 
}

// 1. Incluir la clase refactorizada
include 'rptSleeping.php';

try {
    // INSTANCIACIÓN CORRECTA
    $sleeping = new sleeping($fechaInicio, $fechaFin); 
    
    // 2. Llamar al método que genera el PDF
    $sleeping->generarPDFSleepings(); 
    
} catch (Throwable $e) {
    // Manejo de errores fatales
    error_log("Error en reporte de sleeping: " . $e->getMessage());
    die("Ocurrió un error interno al generar el reporte: " . $e->getMessage());
}
?>