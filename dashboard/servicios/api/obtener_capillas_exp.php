<?php
require_once '../../includes/conexBD.php';
$mysqli = $link;
header('Content-Type: application/json; charset=utf-8');

// Obtenemos el expediente
$exp = isset($_GET['exp']) ? (int)$_GET['exp'] : 0;

if ($exp <= 0) {
    echo json_encode([]);
    exit;
}

/**
 * Consulta: Trae los nombres de las capillas (servicios) 
 * que ya están asignados a este expediente en el paso 1 (Velación).
 */
$sql = "
    SELECT DISTINCT 
        b.nombre AS capilla 
    FROM 
        sco_orden AS a 
    INNER JOIN 
        sco_servicio AS b ON b.Nservicio = a.servicio 
    WHERE 
        a.expediente = ? 
        AND a.paso = 1 
    ORDER BY 1 ASC;
";

$rows = [];

if ($st = $mysqli->prepare($sql)) {
    $st->bind_param("i", $exp);
    $st->execute();
    $res = $st->get_result();
    
    while ($r = $res->fetch_assoc()) {
        // Solo necesitamos el nombre para el select
        $rows[] = $r;
    }
    $st->close();
}

// Retornamos un array simple de objetos para que sea fácil de iterar en JS
echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);