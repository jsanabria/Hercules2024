<?php
include 'conexBD.php'; // Archivo que define la variable $link
include 'funciones_hercules.php';
date_default_timezone_set('America/La_Paz');

header('Content-Type: application/json'); // Importante para indicar que la respuesta es JSON

// Simulación de datos (en un entorno real, aquí iría tu conexión a DB y consultas)
$indicadores = [
    'ventasMes' => '$15,250',
    'nuevosClientes' => 120,
    'tasaConversion' => 3.5,
    'satisfaccionCliente' => 4.7,
];

// Datos para gráficos (simulados)
$ventasAnuales = [
    'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul'],
    'data' => [1200, 1900, 3000, 5000, 2000, 3000, 4500]
];

$clientesPorFuente = [
    'labels' => ['Web', 'Referidos', 'Redes Sociales', 'Publicidad'],
    'data' => [300, 150, 100, 50]
];

$url = "http://callcenter.interasist.com/ws/GetTasaCambio.php";
$tasa_json = file_get_contents($url);
$decoded_json = json_decode($tasa_json, true);
$tasa = $decoded_json["listarTasa"];

// Combina todos los datos
$responseData = [
    'indicadores' => $indicadores,
    'ventasAnuales' => $ventasAnuales,
    'clientesPorFuente' => $clientesPorFuente,
    'tasaBCV' => $tasa
];

// INDICADOR 1
$expedientesPorDia = [];
$sqlExp = "SELECT 
                DATE_FORMAT(a.fecha_registro, '%W %d %M - %Y') AS dia_nombre, 
                DATE_FORMAT(a.fecha_registro, '%d/%m/%Y') AS fecha_corta, 
                COUNT(a.Nexpediente) AS cantidad 
            FROM sco_expediente AS a 
            GROUP BY dia_nombre, fecha_corta, DATE(a.fecha_registro)
            ORDER BY DATE(a.fecha_registro) DESC LIMIT 0, 7;";

$resExp = $link->query($sqlExp); // Usando el link de conexBD.php

if ($resExp) {
    while($row = $resExp->fetch_assoc()) {
        // Usamos tu lógica de traducción o una integrada
        $expedientesPorDia[] = [
            'etiqueta' => traducir_dia($row["dia_nombre"]) . " " . $row["fecha_corta"],
            'cantidad' => (int)$row["cantidad"]
        ];
    }
}
$responseData['expedientesPorDia'] = $expedientesPorDia;

// INDICADOR 2
$expedientesInhumados = [];
$sqlInhumados = "SELECT 
                    DATE_FORMAT(a.fecha_registro, '%W %d %M - %Y') AS dia_nombre, 
                    DATE_FORMAT(a.fecha_registro, '%d/%m/%Y') AS fecha_corta, 
                    COUNT(DISTINCT a.Nexpediente) AS cantidad 
                FROM 
                    sco_expediente AS a 
                    JOIN sco_orden AS b ON b.expediente = a.Nexpediente AND b.servicio_tipo = 'SEPE' 
                GROUP BY dia_nombre, fecha_corta, DATE(a.fecha_registro) 
                ORDER BY DATE(a.fecha_registro) DESC LIMIT 0, 7;";

$resInh = $link->query($sqlInhumados); // Usando la conexión $link de conexBD.php

if ($resInh) {
    while($row = $resInh->fetch_assoc()) {
        $expedientesInhumados[] = [
            'etiqueta' => traducir_dia($row["dia_nombre"]) . " " . $row["fecha_corta"],
            'cantidad' => (int)$row["cantidad"]
        ];
    }
}
$responseData['expedientesInhumados'] = $expedientesInhumados;

// INDICADOR 3
$expedientesCremados = [];
$sqlCrem = "SELECT 
                DATE_FORMAT(a.fecha_registro, '%W %d %M - %Y') AS dia_nombre, 
                DATE_FORMAT(a.fecha_registro, '%d/%m/%Y') AS fecha_corta, 
                COUNT(DISTINCT a.Nexpediente) AS cantidad 
            FROM 
                sco_expediente AS a 
                JOIN sco_orden AS b ON b.expediente = a.Nexpediente AND b.servicio_tipo = 'CREM' 
            GROUP BY dia_nombre, fecha_corta, DATE(a.fecha_registro) 
            ORDER BY DATE(a.fecha_registro) DESC LIMIT 0, 7;";

$resCrem = $link->query($sqlCrem);

if ($resCrem) {
    while($row = $resCrem->fetch_assoc()) {
        $expedientesCremados[] = [
            'etiqueta' => traducir_dia($row["dia_nombre"]) . " " . $row["fecha_corta"],
            'cantidad' => (int)$row["cantidad"]
        ];
    }
}
$responseData['expedientesCremados'] = $expedientesCremados;


// INDICADOR 4
$causasFallecimiento = [];
$sqlCausa = "SELECT 
                DATE_FORMAT(a.fecha_registro, '%W %d %M') AS dia_nombre, 
                a.causa_ocurrencia, 
                COUNT(a.Nexpediente) AS cantidad 
            FROM sco_expediente AS a 
            WHERE a.fecha_registro >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY dia_nombre, a.causa_ocurrencia, DATE(a.fecha_registro)
            ORDER BY DATE(a.fecha_registro) DESC;";

$resCausa = $link->query($sqlCausa);

if ($resCausa) {
    while($row = $resCausa->fetch_assoc()) {
        $causasFallecimiento[] = [
            'dia' => traducir_dia($row["dia_nombre"]),
            'causa' => mb_convert_encoding($row["causa_ocurrencia"], 'UTF-8', 'ISO-8859-1'), // Por si hay tildes
            'cantidad' => (int)$row["cantidad"]
        ];
    }
}
$responseData['causasFallecimiento'] = $causasFallecimiento;

// INDICADOR 5-
$estatusServicios = [];
$sqlEst = "SELECT 
                b.nombre, b.color, COUNT(a.Nexpediente) AS cantidad 
            FROM 
                sco_expediente AS a 
                JOIN sco_estatus AS b ON b.Nstatus = a.estatus AND b.activo = 'S' 
            GROUP BY b.nombre, b.color, a.estatus
            ORDER BY a.estatus;";

$resEst = $link->query($sqlEst);

if ($resEst) {
    while($row = $resEst->fetch_assoc()) {
        // Determinar color de texto según el nombre del estatus
        $textColor = (in_array($row["nombre"], ["ENVIO", "RESGUARDO", "VELACION"])) ? "black" : "white";
        
        $estatusServicios[] = [
            'nombre' => $row["nombre"],
            'color' => $row["color"],
            'textColor' => $textColor,
            'cantidad' => (int)$row["cantidad"]
        ];
    }
}
$responseData['estatusServicios'] = $estatusServicios;


// --- MONITOREO DE USUARIOS (Usando sco_users_online) ---
$usuariosActivos = [];
$sqlOnline = "SELECT 
                username, 
                MAX(file) AS file, 
                MAX(last_activity) AS last_activity 
              FROM sco_users_online 
              WHERE last_activity > DATE_SUB(NOW(), INTERVAL 5 MINUTE) 
              AND unlogin = 'N'
              GROUP BY username 
              ORDER BY last_activity DESC";

$resOnline = $link->query($sqlOnline);

if ($resOnline) {
    while($row = $resOnline->fetch_assoc()) {
        $usuariosActivos[] = [
            "nombre" => $row["username"],
            "ubicacion" => basename($row["file"]), // Muestra solo el nombre del archivo
            "hace" => date("i", time() - strtotime($row["last_activity"])) // Minutos transcurridos
        ];
    }
}
$responseData['usuariosActivos'] = $usuariosActivos;

$sql = "DELETE FROM sco_users_online WHERE last_activity < DATE_SUB(NOW(), INTERVAL 1 DAY)";
$link->query($sql);

echo json_encode($responseData);

/*
// En un escenario real, sería algo así:
// database.php (archivo de conexión)
require_once 'config/database.php'; // Asegúrate de tener un archivo con tus credenciales y PDO

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejemplo: Obtener ventas del mes
    $stmt = $pdo->prepare("SELECT SUM(monto) AS total_ventas FROM ventas WHERE MONTH(fecha) = MONTH(CURDATE()) AND YEAR(fecha) = YEAR(CURDATE())");
    $stmt->execute();
    $ventasMes = $stmt->fetch(PDO::FETCH_ASSOC)['total_ventas'];

    // ... y así sucesivamente para otros indicadores y datos de gráficos

    $indicadores['ventasMes'] = number_format($ventasMes, 2); // Formatear el número
    // ...

    echo json_encode($responseData);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
}
*/
?>