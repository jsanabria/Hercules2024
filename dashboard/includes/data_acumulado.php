<?php
include 'conexBD.php'; // Archivo que define la variable $link
date_default_timezone_set('America/La_Paz');

header('Content-Type: application/json');

$xmes = isset($_GET["xmes"]) ? (int)$_GET["xmes"] : 0;

function nombre_mes($num) {
    $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    return $meses[(int)$num] ?? '';
}

// 1. Total Acumulado (Equivalente al botón verde grande)
$sql_total = "SELECT COUNT(DISTINCT a.Nexpediente) AS cantidad 
              FROM sco_expediente AS a 
              LEFT JOIN sco_orden AS b ON b.expediente = a.Nexpediente 
              WHERE a.estatus BETWEEN 1 AND 6 AND IFNULL(b.capilla, 1) = 1 
              AND b.servicio IN ('SEPE000000', 'CREM000003')";
$res_total = $link->query($sql_total);
$total_historico = $res_total->fetch_assoc()['cantidad'];

// 2. Mes Seleccionado (Derecha - Verde)
$sql_mes1 = "SELECT MONTH(a.fecha_registro) AS mes, COUNT(DISTINCT a.Nexpediente) AS cantidad 
             FROM sco_expediente AS a 
             LEFT JOIN sco_orden AS b ON b.expediente = a.Nexpediente 
             WHERE a.estatus BETWEEN 1 AND 6 AND IFNULL(b.capilla, 1) = 1 
             AND b.servicio IN ('SEPE000000', 'CREM000003') 
             AND YEAR(a.fecha_registro) = YEAR(DATE_SUB(NOW(), INTERVAL $xmes MONTH)) 
             AND MONTH(a.fecha_registro) = MONTH(DATE_SUB(NOW(), INTERVAL $xmes MONTH))
             GROUP BY MONTH(a.fecha_registro)";
$res_mes1 = $link->query($sql_mes1);
$data_mes1 = $res_mes1->fetch_assoc();

// 3. Promedio Diario (Centro - Azul)
$sql_prom = "SELECT ROUND(AVG(sub.cantidad), 0) AS promedio FROM (
                SELECT COUNT(DISTINCT a.Nexpediente) AS cantidad 
                FROM sco_expediente AS a 
                LEFT JOIN sco_orden AS b ON b.expediente = a.Nexpediente 
                WHERE a.estatus BETWEEN 1 AND 6 AND IFNULL(b.capilla, 1) = 1 
                AND b.servicio IN ('SEPE000000', 'CREM000003')
                AND YEAR(a.fecha_registro) = YEAR(DATE_SUB(NOW(), INTERVAL $xmes MONTH)) 
                AND MONTH(a.fecha_registro) = MONTH(DATE_SUB(NOW(), INTERVAL $xmes MONTH))
                GROUP BY DATE(a.fecha_registro)
             ) AS sub";
$res_prom = $link->query($sql_prom);
$promedio = $res_prom->fetch_assoc()['promedio'] ?? 0;

// 4. Mes Anterior (Izquierda - Rojo)
$xmes_ant = $xmes + 1;
$sql_mes2 = "SELECT MONTH(a.fecha_registro) AS mes, COUNT(DISTINCT a.Nexpediente) AS cantidad 
             FROM sco_expediente AS a 
             LEFT JOIN sco_orden AS b ON b.expediente = a.Nexpediente 
             WHERE a.estatus BETWEEN 1 AND 6 AND IFNULL(b.capilla, 1) = 1 
             AND b.servicio IN ('SEPE000000', 'CREM000003') 
             AND YEAR(a.fecha_registro) = YEAR(DATE_SUB(NOW(), INTERVAL $xmes_ant MONTH)) 
             AND MONTH(a.fecha_registro) = MONTH(DATE_SUB(NOW(), INTERVAL $xmes_ant MONTH))
             GROUP BY MONTH(a.fecha_registro)";
$res_mes2 = $link->query($sql_mes2);
$data_mes2 = $res_mes2->fetch_assoc();

echo json_encode([
    "total" => number_format($total_historico, 0, "", "."),
    "mesActualNombre" => nombre_mes($data_mes1['mes'] ?? date('n', strtotime("-$xmes month"))),
    "mesActualCant" => $data_mes1['cantidad'] ?? 0,
    "promedio" => $promedio,
    "mesAnteriorNombre" => nombre_mes($data_mes2['mes'] ?? date('n', strtotime("-$xmes_ant month"))),
    "mesAnteriorCant" => $data_mes2['cantidad'] ?? 0,
    "xmes" => $xmes
]);
?>