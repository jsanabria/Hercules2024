<?php
// Asegúrate de que conexBD.php define una conexión MySQLi llamada $link
include 'includes/conexBD.php';
date_default_timezone_set('America/La_Paz');

// 1. Validar y obtener parámetros GET
// Se usan GET porque el enlace del botón usa GET
$fecha_desde = $_GET["fd"] ?? null;
$fecha_hasta = $_GET["fh"] ?? null;

// Salida si faltan datos
if (empty($fecha_desde) || empty($fecha_hasta)) {
    // Podrías redirigir o mostrar un error más simple aquí
    die("Error: Faltan fechas de búsqueda para la exportación.");
}

// 2. Cabeceras HTTP para forzar la descarga de un archivo Excel (CSV)
// Se usa CSV porque es el formato más simple y compatible que Excel puede abrir.
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="reporte_servicios_' . date('Ymd_His') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// 3. Definición de la consulta SQL (Misma consulta del script original)
$sql = "SELECT
            a.Nexpediente, a.seguro, a.cedula_fallecido, a.nombre_fallecido, a.apellidos_fallecido,
            b.nombre AS funeraria, a.capilla, a.horas, a.servicio, a.factura, a.venta,
            DATE_FORMAT(a.fecha_registro, '%d/%m/%Y') AS fecha_registro, a.edad_fallecido,
            a.causa_ocurrencia, a.sexo
        FROM view_expediente_servicio a
        LEFT OUTER JOIN sco_proveedor b ON b.Nproveedor = a.funeraria
        WHERE
            a.fecha_registro BETWEEN ? AND ?
        ORDER BY a.fecha_registro DESC";

// 4. Preparar, vincular y ejecutar la sentencia
$stmt = $link->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $link->error);
}

// Vincular parámetros para Sentencias Preparadas
$fecha_inicio_db = $fecha_desde . ' 00:00:00';
$fecha_fin_db    = $fecha_hasta . ' 23:59:59';
$stmt->bind_param("ss", $fecha_inicio_db, $fecha_fin_db);

$stmt->execute();
$result = $stmt->get_result();

// 5. Imprimir las cabeceras (títulos de columna)
// NOTA: Los campos deben coincidir con el SELECT en el mismo orden.
$cabeceras = [
    'Exp. #', 'Seguro', 'C.I. Difunto', 'Nombre Difunto', 'Apellido Difunto',
    'Funeraria', 'Capilla', 'Horas', 'Servicio', 'Factura', 'Venta',
    'Fecha Registro', 'Edad', 'Causa Fallecimiento', 'Sexo/Depto'
];
echo implode("\t", $cabeceras) . "\n";

// 6. Imprimir el cuerpo de los datos
while ($row = $result->fetch_assoc()) {
    // 7. Generar una línea de datos separada por tabulaciones (\t)
    $linea = [
        // Uso de mb_convert_encoding para asegurar compatibilidad de caracteres especiales
        mb_convert_encoding($row["Nexpediente"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["seguro"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["cedula_fallecido"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["nombre_fallecido"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["apellidos_fallecido"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["funeraria"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["capilla"] ?? '', 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["horas"] ?? '', 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["servicio"] ?? '', 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["factura"] ?? '', 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["venta"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["fecha_registro"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["edad_fallecido"], 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["causa_ocurrencia"] ?? '', 'UTF-16LE', 'UTF-8'),
        mb_convert_encoding($row["sexo"], 'UTF-16LE', 'UTF-8'),
    ];
    // Imprime la línea, uniendo los elementos con el separador de tabulación
    echo implode("\t", $linea) . "\n";
}

// 8. Liberar recursos
$stmt->close();
$link->close();
exit;
?>