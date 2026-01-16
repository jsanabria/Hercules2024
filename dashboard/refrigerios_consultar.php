<?php
// Establecer el encabezado para UTF-8, asegurando que los datos se envíen correctamente
header('Content-Type: text/html; charset=utf-8');

// Usar $_POST directamente (ya que la llamada AJAX usa ese método)
// y el operador de coalescencia de null (??) para evitar errores si las variables no existen.
$fecha_inicio = $_POST["fecha"] ?? null;
$fecha_fin = $_POST["fecha2"] ?? null;

// 1. Validación de parámetros y Manejo de Errores
if (empty($fecha_inicio) || empty($fecha_fin)) {
    // Si faltan datos, se devuelve un código de error HTTP 400 (Bad Request)
    // El método .fail() del AJAX en el cliente capturará esto.
    http_response_code(400); 
    echo "Error: Se requieren las fechas de inicio y fin para procesar la consulta.";
    exit;
}

// 2. Inclusión de la Clase
// Se usa require_once para asegurar que la clase exista y evitar redefiniciones.
require_once "refrigerio.php"; 

// 3. Ejecución de la Lógica
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
                let url = \'../fpdf_report/refrigerio_generar_pdf.php?fecha_ini=\' + fechaInicio + \'&fecha_fin=\' + fechaFin;
                
                // Abre el script generador de PDF en una nueva pestaña
                window.open(url, \'_blank\');
            }
            </script>';

    // Cuando necesites mostrarlo:
    echo $boton_pdf_html;


    // Se asume que la clase 'refrigerio' está disponible
    $refrig = new refrigerio($fecha_inicio, $fecha_fin);
    
    // Imprimir el resultado HTML
    echo $refrig->imprimirRefrigerios();
    
} catch (Throwable $e) {
    // Captura cualquier excepción o error fatal lanzado durante la ejecución
    http_response_code(500); // Internal Server Error
    error_log("Error al generar reporte de refrigerios: " . $e->getMessage());
    
    // Muestra un mensaje genérico al usuario (sin exponer detalles sensibles)
    echo "<div class='alert alert-danger' role='alert'>
            Ocurrió un error interno. Por favor, revise el log de errores del servidor.
          </div>";
}
?>