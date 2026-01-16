<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;
header('Content-Type: application/json; charset=utf-8');

$exp = isset($_GET['exp']) ? (int)$_GET['exp'] : 0;
if ($exp <= 0) {
    echo json_encode(['rows' => [], 'total_servicios' => 0, 'total_monto' => 0.00]);
    exit;
}

// Consulta SQL ajustada para obtener Tipo de Servicio, Servicio, Cantidad, Costo y Total, 
// simulando la lógica de tu código de tabla HTML, pero usando MySQLi.
$sql = "
SELECT
    o.Norden,
    (SELECT ts.nombre FROM sco_servicio_tipo ts WHERE ts.Nservicio_tipo = o.servicio_tipo LIMIT 1) AS servicio_tipo,
    (SELECT s.nombre FROM sco_servicio s WHERE s.Nservicio = o.servicio LIMIT 1) AS servicio_nombre,
    o.cantidad,
    o.costo,
    o.total
    -- La columna 'image' ha sido eliminada
FROM sco_orden o
WHERE o.expediente = ?
ORDER BY o.paso, o.Norden
";

$rows = [];
$total_monto = 0.00;

if ($st = $mysqli->prepare($sql)) {
    $st->bind_param("i", $exp);
    $st->execute();
    $res = $st->get_result();
    
    while ($r = $res->fetch_assoc()) {
        $rows[] = $r;
        // Suma el total para obtener el monto final
        $total_monto += (float)($r['total'] ?? 0.00);
    }
    $st->close();
}

// Devuelve los datos en formato JSON, incluyendo los totales requeridos
echo json_encode([
    'rows' => $rows,
    'total_servicios' => count($rows),
    'total_monto' => $total_monto // El total no formateado
], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);