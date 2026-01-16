<?php
// Asegúrate de que conexBD.php define una conexión MySQLi llamada $link
include 'includes/conexBD.php'; 
date_default_timezone_set('America/La_Paz');

// 1. Validar y Sanitizar entradas
// Uso de $_POST es más común y seguro para peticiones AJAX.
$fecha_desde = $_POST["fecha_desde"] ?? null; 
$fecha_hasta = $_POST["fecha_hasta"] ?? null;

// Salida temprana si faltan datos
if (empty($fecha_desde) || empty($fecha_hasta)) {
    echo '<p class="alert alert-danger">Error: Faltan fechas de búsqueda.</p>';
    exit;
}

$contar = 0;

// Definición de la consulta SQL
// NOTA: 'departamento' y 'sexo' no estaban en tu SELECT original. 
// He asumido que 'sexo' se refiere a alguna columna que quizás se llame 'departamento' en tu código (como se usó en el <td>), 
// o simplemente he dejado 'departamento' para que revises qué campo realmente contiene el sexo/departamento.
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

// 2. Preparar la sentencia
$stmt = $link->prepare($sql);

if ($stmt === false) {
    // Manejo de error en la preparación (ej: error de sintaxis en $sql)
    echo '<p class="alert alert-danger">Error al preparar la consulta: ' . $link->error . '</p>';
    exit;
}

// 3. Vincular parámetros (Sentencias Preparadas)
// Los valores de las variables se usan en lugar de concatenar en la SQL, 
// lo que es crucial para la seguridad (prevención de Inyección SQL).
// 's' = string. Bindamos las fechas con el formato completo.
$fecha_inicio_db = $fecha_desde . ' 00:00:00';
$fecha_fin_db    = $fecha_hasta . ' 23:59:59';
$stmt->bind_param("ss", $fecha_inicio_db, $fecha_fin_db);

// 4. Ejecutar la sentencia
$stmt->execute();

// 5. Obtener el resultado
$result = $stmt->get_result();

// --- Construcción del HTML de Salida ---
$out = '<div class="mb-3 d-flex justify-content-end">'; // Contenedor para alinear el botón a la derecha (Bootstrap 5)
$out .= '<a href="listar_servicios_buscar_excel.php?fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Exportar a Excel</a>';
$out .= '</div>';

// Tabla Bootstrap 5
$out .= '<div class="table-responsive">';
$out .= '<table class="table table-sm table-striped table-bordered table-hover">'; 
$out .= '<thead class="table-dark">';
$out .= '<tr>';
// Se han ajustado las columnas para que coincidan con el SELECT
$out .= '<th scope="col">Exp. #</th>';
$out .= '<th scope="col">Seguro</th>';
$out .= '<th scope="col">C.I. Difunto</th>';
$out .= '<th scope="col">Nombre Difunto</th>';
$out .= '<th scope="col">Edad</th>';
$out .= '<th scope="col">Sexo/Depto</th>'; // Ajustado, verifica el campo real
$out .= '<th scope="col">Causa Fallecimiento</th>';
$out .= '<th scope="col">Funeraria</th>';
$out .= '<th scope="col">Capilla</th>';
$out .= '<th scope="col">Horas</th>';
$out .= '<th scope="col">Servicio</th>';
$out .= '<th scope="col">Registro</th>';
$out .= '</tr>';
$out .= '</thead>';
$out .= '<tbody>';

// 6. Iterar sobre los resultados
while($row = $result->fetch_assoc()) {
    $out .= '<tr>';
    // Link al expediente
    $out .= '<th scope="row"><a href="../sco_expedienteview.php?showdetail=&Nexpediente=' . htmlspecialchars($row["Nexpediente"]) . '" target="_blank">' . htmlspecialchars($row["Nexpediente"]) . '</a></th>';
    $out .= '<td>' . htmlspecialchars($row["seguro"]) . '</td>';
    $out .= '<td>' . htmlspecialchars($row["cedula_fallecido"]) . '</td>';
    $out .= '<td>' . htmlspecialchars($row["nombre_fallecido"] . " " . $row["apellidos_fallecido"]) . '</td>';
    $out .= '<td>' . htmlspecialchars($row["edad_fallecido"]) . '</td>';
    $out .= '<td>' . htmlspecialchars($row["sexo"] ?? '') . '</td>'; 
    $out .= '<td>' . htmlspecialchars($row["causa_ocurrencia"] ?? '') . '</td>';
    $out .= '<td>' . htmlspecialchars($row["funeraria"] ?? '') . '</td>';
    $out .= '<td>' . htmlspecialchars($row["capilla"] ?? '') . '</td>';
    $out .= '<td>' . htmlspecialchars($row["horas"] ?? '') . '</td>';
    $out .= '<td>' . htmlspecialchars($row["servicio"] ?? '') . '</td>';
    $out .= '<td>' . htmlspecialchars($row["fecha_registro"]) . '</td>';
    $out .= '</tr>';
    $contar++;
}

// Fila de total
$out .= '<tr><th colspan="12" class="text-end table-info">Total Servicios: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
$out .= '</tbody>';
$out .= '</table>';
$out .= '</div>'; // Cierra table-responsive

// Botón de exportar repetido al final
$out .= '<div class="mb-3 d-flex justify-content-end">';
$out .= '<a href="listar_servicios_buscar_excel.php?fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Exportar a Excel</a>';
$out .= '</div>';

// 7. Liberar recursos y cerrar conexión (opcional, pero buena práctica)
$stmt->close();
$link->close(); // Si cierras la conexión aquí, asegúrate de que no se necesite en otro lugar.

echo $out;
?>