<?php
// Asegura que la conexión (que define $link) sea cargada una sola vez
require_once 'includes/conexBD.php';

class refrigerio
{
    // Propiedades privadas con tipado de PHP 7.4+
    private string $fechaInicio;
    private string $fechaFin;

    // Usamos arrays para consolidar los datos de cada comida
    private array $desayuno = ['hd' => '', 'hh' => '', 'porc' => 0];
    private array $almuerzo = ['hd' => '', 'hh' => '', 'porc' => 0];
    private array $cena     = ['hd' => '', 'hh' => '', 'porc' => 0];

    // Constantes para los códigos de parámetros (para mejor legibilidad)
    private const CODIGO_DESAYUNO = '015';
    private const CODIGO_ALMUERZO = '016';
    private const CODIGO_CENA     = '017';

    /**
     * @param string $fechaInicio Fecha inicial (Y-m-d).
     * @param string $fechaFin Fecha final (Y-m-d).
     */
    public function __construct(string $fechaInicio, string $fechaFin) 
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        
        // Carga los parámetros de horarios y porciones
        try {
            $this->desayuno = $this->fetchParametros(self::CODIGO_DESAYUNO);
            $this->almuerzo = $this->fetchParametros(self::CODIGO_ALMUERZO);
            $this->cena     = $this->fetchParametros(self::CODIGO_CENA);
        } catch (Exception $e) {
            // Si la conexión o la consulta falla, lanzamos una excepción
            throw new Exception("Error al cargar parámetros de refrigerios: " . $e->getMessage());
        }
    }

    /**
     * Helper para obtener los parámetros de una comida específica (DRY + Seguridad).
     * @param string $codigo Código del parámetro (ej. '015').
     * @return array Array asociativo con 'hd', 'hh' y 'porc'.
     */
    private function fetchParametros(string $codigo): array
    {
        global $link; // Accede al objeto de conexión mysqli
        
        $sql = "SELECT valor1 AS hora_desde, valor2 AS hora_hasta, valor4 AS porciones FROM sco_parametro WHERE codigo = ?";
        
        if (!($stmt = $link->prepare($sql))) {
            throw new Exception("Error al preparar la consulta de parámetros: " . $link->error);
        }
        
        // Bind y ejecución de la consulta
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return [
            'hd' => $row['hora_desde'] ?? '',
            'hh' => $row['hora_hasta'] ?? '',
            'porc' => (int)($row['porciones'] ?? 0) // Aseguramos que sea entero
        ];
    }
    
    /**
     * Ejecuta la consulta y renderiza la tabla para una comida específica.
     * @return array [html, expedientes, porciones]
     */
    private function fetchAndRenderMeal(string $mealName, string $horaDesde, string $horaHasta, int $porcionesPorExpediente, string $currentDate, string $myDate, array $dias): array
    {
        global $link;
        $out = '';
        $expedientesCount = 0; 
        $porcTotal = 0; 

        // Consulta SQL con UNIX_TIMESTAMP y CONCAT para construir las fechas y horas a comparar.
        // Se usa ? en lugar de concatenar $currentDate para la seguridad.
        /*
        $sql = "
            SELECT
                e.Nexpediente, c.nombre AS capilla,
                DATE_FORMAT(o.fecha_inicio,'%d/%m/%Y') AS fecha_inicio, o.hora_inicio,
                DATE_FORMAT(o.fecha_fin,'%d/%m/%Y') AS fecha_fin, o.hora_fin,
                e.nombre_fallecido, e.apellidos_fallecido
            FROM
                sco_orden o
                JOIN sco_expediente e ON e.Nexpediente = o.expediente
                JOIN view_capillas c ON c.Nservicio = o.servicio
            WHERE
                o.paso = 1 AND o.horas > 1 AND
                (
                    UNIX_TIMESTAMP(CONCAT(?, ' ', ?)) BETWEEN UNIX_TIMESTAMP(o.fecha_inicio) AND UNIX_TIMESTAMP(o.fecha_fin)
                    OR
                    UNIX_TIMESTAMP(CONCAT(?, ' ', ?)) BETWEEN UNIX_TIMESTAMP(o.fecha_inicio) AND UNIX_TIMESTAMP(o.fecha_fin)
                )
            ORDER BY
                o.fecha_fin ASC;
        "; 
        */ 
        $sql = "SELECT
                    e.Nexpediente, c.nombre AS capilla,
                    DATE_FORMAT(o.fecha_inicio,'%d/%m/%Y') AS fecha_inicio, o.hora_inicio,
                    DATE_FORMAT(o.fecha_fin,'%d/%m/%Y') AS fecha_fin, o.hora_fin,
                    e.nombre_fallecido, e.apellidos_fallecido
                FROM
                    sco_orden o
                    JOIN sco_expediente e ON e.Nexpediente = o.expediente
                    JOIN view_capillas c ON c.Nservicio = o.servicio
                WHERE
                    o.paso = 1 AND o.horas > 1 AND
                    (
                        o.fecha_fin >= CONCAT(?, ' ', ?)  
                        AND
                        o.fecha_inicio <= CONCAT(?, ' ', ?) 
                    )
                ORDER BY
                    o.fecha_fin ASC;";
        
        if (!($stmt = $link->prepare($sql))) {
             throw new Exception("Error en preparación de consulta de {$mealName}: " . $link->error);
        }

        // Bind de los parámetros para la sentencia preparada (cuatro strings: currentDate, horaDesde, currentDate, horaHasta)
        $stmt->bind_param("ssss", $currentDate, $horaDesde, $currentDate, $horaHasta);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // --- Generación del HTML con estilos de Bootstrap mejorados ---
        $out .= '<div class="container mt-4">';
        $out .= '<h3 class="text-info">' . ucfirst($mealName) . ' para el día ' . $dias[date("w", strtotime($currentDate))] . " " . $myDate . ' en el horario de ' . $horaDesde . ' a ' . $horaHasta . '</h3>';
        $out .= '<div class="table-responsive"> ';
        $out .= '<table class="table table-striped table-hover">';
        $out .= '<thead class="table-dark"><tr>';
        $out .= '<th>Exp.</th><th>Capilla</th><th>F. Inicio</th><th>H. Inicio</th><th>F. Fin</th><th>H. Fin</th><th>Nombre</th><th>Apellido</th><th class="text-end">' . $mealName . '</th>';
        $out .= '</tr></thead>';
        $out .= '<tbody>';

        while($row = $resultado->fetch_assoc()) {
            $out .= '<tr>';
            $out .= '<td>' . htmlspecialchars($row["Nexpediente"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["capilla"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["fecha_inicio"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["hora_inicio"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["fecha_fin"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["hora_fin"]) . '</td>';
            // Nota: Uso htmlspecialchars para prevenir XSS al mostrar nombres
            $out .= '<td>' . htmlspecialchars($row["nombre_fallecido"]) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["apellidos_fallecido"]) . '</td>';
            $out .= '<td class="text-end">' . $porcionesPorExpediente . '</td>';
            $out .= '</tr>';
            
            $expedientesCount++;
            $porcTotal += $porcionesPorExpediente;
        }

        $out .= '<tr class="table-info">';
        $out .= '<td colspan="7" class="text-end fw-bold">Total Expedientes: ' . number_format($expedientesCount, 0, "", ".") . '</td>';
        $out .= '<td class="text-end fw-bold">Unidades:</td>';
        $out .= '<td class="text-end fw-bold">' . number_format($porcTotal, 0, "", ".") . '</td>';
        $out .= '</tr>';
        $out .= '</tbody>';
        $out .= '</table>';
        $out .= '</div>';
        $out .= '</div>';
        
        $stmt->close();

        return ['html' => $out, 'expedientes' => $expedientesCount, 'porciones' => $porcTotal];
    }
    
    /**
     * Genera el HTML completo con los refrigerios por día en el rango.
     */
    public function imprimirRefrigerios(): string
    {
        // Se corrigieron los acentos de la lista de días
        $dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];

        $f1 = $this->fechaInicio;
        $f2 = $this->fechaFin;

        $out = '';
        $porciones_totales_periodo = 0;

        // Bucle para iterar día por día
        $start_ts = strtotime($f1);
        $end_ts = strtotime($f2);
        
        for ($current_ts = $start_ts; $current_ts <= $end_ts; $current_ts += (24 * 3600)) {
            
            $currentDate = date("Y-m-d", $current_ts);
           
            $md = explode("-", $currentDate);
            $myDate = $md[2] . "/" . $md[1] . "/" . $md[0]; // Formato dd/mm/yyyy para display
            
            $porciones_dia = 0;
            $expedientes_dia = 0;
            
            // --- 1. DESAYUNOS ---
            $desayunoData = $this->fetchAndRenderMeal(
                'Desayunos', 
                $this->desayuno['hd'], $this->desayuno['hh'], $this->desayuno['porc'], 
                $currentDate, $myDate, $dias
            );

            $out .= $desayunoData['html'];
            $porciones_dia += $desayunoData['porciones'];
            $expedientes_dia += $desayunoData['expedientes'];

            // --- 2. ALMUERZOS ---
            $almuerzoData = $this->fetchAndRenderMeal(
                'Almuerzos',
                $this->almuerzo['hd'], $this->almuerzo['hh'], $this->almuerzo['porc'], 
                $currentDate, $myDate, $dias
            );
            $out .= $almuerzoData['html'];
            $porciones_dia += $almuerzoData['porciones'];
            $expedientes_dia += $almuerzoData['expedientes'];

            // --- 3. CENAS ---
            $cenaData = $this->fetchAndRenderMeal(
                'Cenas',
                $this->cena['hd'], $this->cena['hh'], $this->cena['porc'], 
                $currentDate, $myDate, $dias
            );
            $out .= $cenaData['html'];
            $porciones_dia += $cenaData['porciones'];
            $expedientes_dia += $cenaData['expedientes'];
           
            // Totales diarios
            $out .= '<div class="container text-end mt-4">';
            $out .= '<h2 class="text-success">Total expedientes con refrigerios para el día ' . $dias[date("w", $current_ts)] . ": " . number_format($expedientes_dia, 0, "", ".") . " &nbsp;&nbsp;&nbsp; Total Unidades:" . number_format($porciones_dia, 0, "", ".") . '</h2><hr class="w-75 ms-auto" />';
            $out .= '</div><br>';
            
            $porciones_totales_periodo += $porciones_dia;
        }

        // Totales Finales
        $md_f1 = explode("-", $f1);
        $xf1 = $md_f1[2] . "/" . $md_f1[1] . "/" . $md_f1[0];
        $md_f2 = explode("-", $f2);
        $xf2 = $md_f2[2] . "/" . $md_f2[1] . "/" . $md_f2[0];

        $out .= '<div class="container text-end mt-5">';
        $out .= '<h1 class="text-danger">Total Unidades para el periodo del ' . $xf1 . ' al ' . $xf2 . ': ' . number_format($porciones_totales_periodo, 0, "", ".") . '</h1>';
        $out .= '</div>';

        return $out;
    }
}
?>