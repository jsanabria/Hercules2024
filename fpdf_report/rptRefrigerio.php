<?php
// Incluye el archivo de conexión que usa mysqli y define $link
require_once '../dashboard/includes/conexBD.php';
require_once 'rcs/fpdf.php'; // Asegúrate de que la ruta a fpdf.php sea correcta

// Aseguramos el acceso a la conexión global, que ya está disponible
global $link;

// Se mantiene la zona horaria definida por el usuario
date_default_timezone_set('America/La_Paz');

class PDF_Refrigerio extends FPDF
{
    private string $fechaInicio;
    private string $fechaFin;

    private array $desayuno = ['hd' => '', 'hh' => '', 'porc' => 0];
    private array $almuerzo = ['hd' => '', 'hh' => '', 'porc' => 0];
    private array $cena     = ['hd' => '', 'hh' => '', 'porc' => 0];

    private const CODIGO_DESAYUNO = '015';
    private const CODIGO_ALMUERZO = '016';
    private const CODIGO_CENA     = '017';
    
    // Propiedades para los totales del reporte
    private int $porciones_totales_periodo = 0;
    private array $dias = ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];

    /**
     * Constructor: Inicializa fechas y carga parámetros de comidas.
     */
    public function __construct(string $fechaInicio, string $fechaFin, $orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
        
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;

        // Carga los parámetros de horarios y porciones
        try {
            $this->desayuno = $this->fetchParametros(self::CODIGO_DESAYUNO);
            $this->almuerzo = $this->fetchParametros(self::CODIGO_ALMUERZO);
            $this->cena     = $this->fetchParametros(self::CODIGO_CENA);
        } catch (Exception $e) {
            // En un PDF no podemos lanzar excepciones directamente, mejor registrar el error
            error_log("Error al cargar parámetros de refrigerios: " . $e->getMessage());
            die("Error interno: Falló la carga de parámetros.");
        }
    }
    
    // --- FPDF MÉTODOS ESTÁNDAR ---

    // Cabecera de página
    function Header()
    {
        global $link;
        $this->Image('../phpimages/logo_rif.jpg',10,15,70);
        
        $this->ln(5);
        $this->SetFont('Arial','',10);
        $this->Cell(200,8,"Fecha: ".date("d/m/Y"),0,0,'R');
        $this->ln();
        $this->Cell(200,8,"Hora: ".date("g:i:s a"),0,0,'R');

        $this->ln();
        // Título del reporte
        $titulo = "REPORTE DE REFRIGERIOS - DESDE: " . date("d/m/Y", strtotime($this->fechaInicio)) . " HASTA: " . date("d/m/Y", strtotime($this->fechaFin));
        $this->ln(10);
        $this->SetFont('Arial','B',14);
        $this->Cell(200,8,$titulo,0,0,'C');
        $this->ln(10);
        
        // La cabecera de la tabla principal se dibuja en el método printMeals
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

    // --- MÉTODOS DE LÓGICA DE NEGOCIO (Adaptados de tu clase refrigerio) ---

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
        
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return [
            'hd' => $row['hora_desde'] ?? '',
            'hh' => $row['hora_hasta'] ?? '',
            'porc' => (int)($row['porciones'] ?? 0)
        ];
    }
    
    /**
     * Ejecuta la consulta e imprime la tabla para una comida específica.
     * @return array [expedientes, porciones]
     */
    private function fetchAndPrintMeal(string $mealName, string $horaDesde, string $horaHasta, int $porcionesPorExpediente, string $currentDate, string $myDate): array
    {
        global $link;
        $expedientesCount = 0; 
        $porcTotal = 0; 

        // Cabecera de la comida
        $this->SetFont('Arial','B',11);
        $this->SetFillColor(220, 220, 255); // Fondo azul claro para el título
        $this->Cell(190, 7, ucfirst($mealName) . ' en el horario de ' . $horaDesde . ' a ' . $horaHasta, 1, 1, 'L', true);
        
        // Cabecera de la tabla de detalles
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(200, 200, 200); // Fondo gris
        $this->Cell(15, 6, 'Exp.', 1, 0, 'C', true);
        $this->Cell(30, 6, 'Capilla', 1, 0, 'C', true);
        $this->Cell(25, 6, 'F. Inicio', 1, 0, 'C', true);
        $this->Cell(15, 6, 'H. Ini', 1, 0, 'C', true);
        $this->Cell(25, 6, 'F. Fin', 1, 0, 'C', true);
        $this->Cell(15, 6, 'H. Fin', 1, 0, 'C', true);
        $this->Cell(45, 6, 'Difunto', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Porciones', 1, 1, 'C', true); // 1 al final para nueva línea

        // Consulta SQL (la misma de tu código original)
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
             error_log("Error en preparación de consulta de {$mealName}: " . $link->error);
             return ['expedientes' => 0, 'porciones' => 0];
        }

        $stmt->bind_param("ssss", $currentDate, $horaDesde, $currentDate, $horaHasta);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Filas de datos
        $this->SetFont('Arial','',8);
        $fill = false; // Alternar color de fondo
        while($row = $resultado->fetch_assoc()) {
            $difunto = trim($row["nombre_fallecido"] . ' ' . $row["apellidos_fallecido"]);
            
            $this->SetFillColor(240, 240, 240); // Color para filas pares
            $this->Cell(15, 5, $row["Nexpediente"], 'LR', 0, 'C', $fill);
            $this->Cell(30, 5, $row["capilla"], 'R', 0, 'L', $fill);
            $this->Cell(25, 5, $row["fecha_inicio"], 'R', 0, 'C', $fill);
            $this->Cell(15, 5, $row["hora_inicio"], 'R', 0, 'C', $fill);
            $this->Cell(25, 5, $row["fecha_fin"], 'R', 0, 'C', $fill);
            $this->Cell(15, 5, $row["hora_fin"], 'R', 0, 'C', $fill);
            $this->Cell(45, 5, substr($difunto, 0, 30), 'R', 0, 'L', $fill); // Truncar nombre
            $this->Cell(20, 5, $porcionesPorExpediente, 'R', 1, 'R', $fill);
            
            $expedientesCount++;
            $porcTotal += $porcionesPorExpediente;
            $fill = !$fill;
        }
        
        // Fila de totales de la comida
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(180, 220, 255); // Fondo azul
        $this->Cell(170, 6, "Total Expedientes {$mealName}: " . number_format($expedientesCount, 0, "", "."), 'LRTB', 0, 'R', true);
        $this->Cell(20, 6, number_format($porcTotal, 0, "", "."), 'RTB', 1, 'R', true);
        
        $stmt->close();
        $this->Ln(3);

        return ['expedientes' => $expedientesCount, 'porciones' => $porcTotal];
    }
    
    /**
     * Genera el PDF completo con los refrigerios por día en el rango.
     */
    public function printMeals()
    {
        $f1 = $this->fechaInicio;
        $f2 = $this->fechaFin;

        // Bucle para iterar día por día
        $start_ts = strtotime($f1);
        $end_ts = strtotime($f2);
        
        for ($current_ts = $start_ts; $current_ts <= $end_ts; $current_ts += (24 * 3600)) {
            
            $currentDate = date("Y-m-d", $current_ts);
            
            $md = explode("-", $currentDate);
            $myDate = $md[2] . "/" . $md[1] . "/" . $md[0]; // Formato dd/mm/yyyy para display
            $dia_nombre = $this->dias[date("w", $current_ts)];

            $this->AddPage(); // Una página por día
            
            $porciones_dia = 0;
            $expedientes_dia = 0;

            // Título del Día
            $this->SetFont('Arial','B',12);
            $this->SetFillColor(150, 200, 150); // Fondo verde
            $this->Cell(190, 8, mb_convert_encoding('Día: ' . ucfirst($dia_nombre) . " " . $myDate, 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', true);
            $this->Ln(2);

            // --- 1. DESAYUNOS ---
            $desayunoData = $this->fetchAndPrintMeal(
                'Desayunos', 
                $this->desayuno['hd'], $this->desayuno['hh'], $this->desayuno['porc'], 
                $currentDate, $myDate
            );

            $porciones_dia += $desayunoData['porciones'];
            $expedientes_dia += $desayunoData['expedientes'];

            // --- 2. ALMUERZOS ---
            $almuerzoData = $this->fetchAndPrintMeal(
                'Almuerzos',
                $this->almuerzo['hd'], $this->almuerzo['hh'], $this->almuerzo['porc'], 
                $currentDate, $myDate
            );
            $porciones_dia += $almuerzoData['porciones'];
            $expedientes_dia += $almuerzoData['expedientes'];

            // --- 3. CENAS ---
            $cenaData = $this->fetchAndPrintMeal(
                'Cenas',
                $this->cena['hd'], $this->cena['hh'], $this->cena['porc'], 
                $currentDate, $myDate
            );
            $porciones_dia += $cenaData['porciones'];
            $expedientes_dia += $cenaData['expedientes'];
            
            // Totales diarios
            $this->Ln(3);
            $this->SetFont('Arial','B',12);
            $this->SetFillColor(255, 255, 200); // Fondo amarillo claro
            $this->Cell(190, 7, mb_convert_encoding("TOTAL DEL DÍA: Expedientes - ", 'ISO-8859-1', 'UTF-8') . number_format($expedientes_dia, 0, "", ".") . " | Unidades - " . number_format($porciones_dia, 0, "", "."), 1, 1, 'R', true);
            
            $this->porciones_totales_periodo += $porciones_dia;
        }

        // Totales Finales (Se imprime en la última página o donde se termine el loop)
        $this->Ln(10);
        $this->SetFont('Arial','B',14);
        $this->SetTextColor(255, 0, 0); // Texto rojo
        $this->Cell(190, 8, 'TOTAL UNIDADES DEL PERIODO: ' . number_format($this->porciones_totales_periodo, 0, "", ".") . '', 0, 1, 'R');
        $this->SetTextColor(0, 0, 0); // Restaurar color
    }
}
?>