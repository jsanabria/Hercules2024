<?php
// sleeping_consultar.php
require_once 'includes/conexBD.php'; // Asegura la conexión

$fecha_inicio = $_POST["fecha"] ?? null;
$fecha_fin = $_POST["fecha2"] ?? null;

if (empty($fecha_inicio) || empty($fecha_fin)) {
    http_response_code(400); 
    echo "Error: Se requieren las fechas de inicio y fin para procesar la consulta.";
    exit;
}

require_once "sleepings.php"; 

try {
    // Asegúrate de que $f1 y $f2 están definidas
    $f1 = $fecha_inicio;
    $f2 = $fecha_fin;

    $boton_pdf_html = '<style>
            @media print {
                .no-print {
                    display: none !important;
                }
            }
            </style>

            <div class="container mt-5 text-center no-print">
                <button onclick="generarPDF(\'' . $f1 . '\', \'' . $f2 . '\')" class="btn btn-primary btn-lg">
                    <i class="bi bi-file-pdf-fill"></i> Generar Reporte PDF
                </button>
            </div>

            <script>
            function generarPDF(fechaInicio, fechaFin) {
                // Construye la URL con las fechas como parámetros GET
                let url = \'../fpdf_report/sleeping_generar_pdf.php?fecha_ini=\' + fechaInicio + \'&fecha_fin=\' + fechaFin;
                
                // Abre el script generador de PDF en una nueva pestaña
                window.open(url, \'_blank\');
            }
            </script>';

    // Cuando necesites mostrarlo:
    echo $boton_pdf_html;

    $sleeping = new sleeping($fecha_inicio, $fecha_fin);
    echo $sleeping->imprimirSleepings(); // O la función que genere tu HTML
    
} catch (Throwable $e) {
    http_response_code(500); 
    error_log("Error en reporte de sleeping: " . $e->getMessage());
    echo "<div class='alert alert-danger' role='alert'>Ocurrió un error interno al generar el reporte.</div>";
}
?>