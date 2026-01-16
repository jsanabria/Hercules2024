<?php
// Asegura que la conexión (que define $link) sea cargada una sola vez
require_once 'includes/conexBD.php';

class sleeping
{
    // Propiedades privadas con tipado (asumiendo PHP 7.4+)
    private string $fechaInicio;
    private string $fechaFin;

    /**
     * Constructor seguro.
     * @param string $fechaInicio Fecha inicial (Y-m-d).
     * @param string $fechaFin Fecha final (Y-m-d).
     */
    public function __construct(string $fechaInicio, string $fechaFin) 
    {
        // Limpieza básica de entradas antes de asignarlas a la propiedad
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    /**
     * Genera el HTML completo del reporte de entrega de Sleepings.
     * @return string HTML con la tabla de resultados.
     */
    public function imprimirSleepings(): string
    {
        global $link;
        
        $f1 = $this->fechaInicio;
        // La fecha de fin debe incluir el final del día (23:59:59) para el BETWEEN
        $f2_endOfDay = $this->fechaFin . ' 23:59:59';
        
        // La consulta utiliza signos de interrogación (?) para la seguridad
        $sql = "
            SELECT 
                a.expediente, 
                b.nombre_fallecido, 
                b.apellidos_fallecido, 
                a.fecha_hora, 
                a.halcon, 
                c.nombre AS nombre_halcon 
            FROM 
                sco_expediente_estatus a 
                JOIN sco_expediente b ON b.Nexpediente = a.expediente 
                LEFT OUTER JOIN sco_user c ON c.username = a.halcon 
            WHERE 
                b.estatus <> 7 
                AND a.estatus = 2 
                AND IFNULL(a.halcon, '') <> '' 
                AND a.fecha_hora BETWEEN ? AND ? 
            ORDER BY 
                a.halcon, a.expediente;
        "; 
        
        try {
            if (!($stmt = $link->prepare($sql))) {
                throw new Exception("Error al preparar la consulta de sleeping: " . $link->error);
            }

            // 1. Uso de Sentencias Preparadas (Bind de parámetros)
            // 'ss' indica que ambos parámetros son strings (las fechas)
            $stmt->bind_param("ss", $f1, $f2_endOfDay);
            $stmt->execute();
            $rs = $stmt->get_result();

        } catch (Exception $e) {
            // Manejo de errores de base de datos
            error_log("Error DB en imprimirSleepings: " . $e->getMessage());
            return '<div class="alert alert-danger" role="alert">Error al ejecutar la consulta: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        
        // Inicialización de contadores y variables de agrupamiento
        $out = '';
        $dy = 0; // Contador de Total Sleeping (Expedientes)
        $current_halcon = null;
        $halcon_count = 0;

        // --- Generación de HTML ---
        $out .= '<div class="container mt-4">';
        $out .= '<h2 class="text-info">Entrega de Sleeping desde el: ' . htmlspecialchars($f1) . ' hasta el: ' . htmlspecialchars($this->fechaFin) . '</h2>';
        $out .= '<div class="table-responsive"> ';
        $out .= '<table class="table table-bordered table-striped table-hover">';
        $out .= '<thead class="table-dark"><tr>';
        $out .= '<th>Expediente</th>';
        $out .= '<th>Apellido Difunto</th>';
        $out .= '<th>Nombre Difunto</th>';
        $out .= '<th>Fecha/Hora Entrega</th>';
        $out .= '<th>ID Halcón</th>';
        $out .= '<th>Nombre Halcón</th>';
        $out .= '</tr></thead>';
        $out .= '<tbody>';

        while ($row = $rs->fetch_assoc()) {
            // 2. Lógica de Agrupamiento y Subtotales
            if ($row["halcon"] !== $current_halcon) {
                // Si el halcón cambia y no es el primero
                if ($current_halcon !== null) {
                    $out .= '<tr class="table-warning fw-bold">';
                    $out .= '<td colspan="4" class="text-end">Total Sleeping para Halcón (' . htmlspecialchars($current_halcon) . '):</td>';
                    $out .= '<td colspan="2">' . number_format($halcon_count, 0, "", ".") . '</td>';
                    $out .= '</tr>';
                }
                // Iniciar nuevo grupo
                $current_halcon = $row["halcon"];
                $halcon_count = 0;
            }

            // 3. Impresión de la fila
            $out .= '<tr>';
            $out .= '<td>' . htmlspecialchars($row["expediente"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["apellidos_fallecido"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["nombre_fallecido"]) . '</td>';
            // Formatear la fecha/hora para mejor lectura (opcional)
            $out .= '<td>' . date("d/m/Y H:i:s", strtotime($row["fecha_hora"])) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["halcon"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["nombre_halcon"]) . '</td>';
            $out .= '</tr>';

            $halcon_count++;
            $dy++; // Contador total
        }
        
        // 4. Subtotal para el último Halcón
        if ($current_halcon !== null) {
            $out .= '<tr class="table-warning fw-bold">';
            $out .= '<td colspan="4" class="text-end">Total Sleeping para Halcón (' . htmlspecialchars($current_halcon) . '):</td>';
            $out .= '<td colspan="2">' . number_format($halcon_count, 0, "", ".") . '</td>';
            $out .= '</tr>';
        }

        $out .= '</tbody>';
        $out .= '</table>';
        $out .= '</div>';
        $out .= '</div>';
        
        // 5. Total General
        $out .= '<div class="container text-end mt-4">';
        $out .= '<h2 class="text-success">Total Sleepings Entregados en el Periodo: ' . number_format($dy, 0, "", ".") . '</h2><hr class="w-75 ms-auto" />';
        $out .= '</div>';
        
        $stmt->close();

        return $out;
    }
}
?>