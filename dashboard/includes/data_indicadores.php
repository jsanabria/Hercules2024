<?php
// data.php (ejemplo de cómo podrías obtener datos)

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
// var_dump($tasa);
// die();
// Combina todos los datos
$responseData = [
    'indicadores' => $indicadores,
    'ventasAnuales' => $ventasAnuales,
    'clientesPorFuente' => $clientesPorFuente,
    'tasaBCV' => $tasa
];

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