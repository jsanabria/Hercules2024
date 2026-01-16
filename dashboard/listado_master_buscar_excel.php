<?php
// 1. Incluir el archivo de conexión MySQLi.
// Este archivo debe definir el objeto de conexión global $link (tipo mysqli).
include 'includes/conexBD.php'; //

$id = $_GET["id"];

// 2. Obtención y Sanitización de Parámetros de Fecha
$fecha_desde_raw = $_REQUEST["fd"] ?? null;
$fecha_hasta_raw = $_REQUEST["fh"] ?? null;
$tipo_mov = $_REQUEST["tipo_mov"] ?? null; // Sólo necesario para "parcelas"

// 🚨 Sanitizar las fechas con mysqli_real_escape_string ANTES de usarlas en la consulta.
// Esto previene inyección SQL (SQL Injection).
$fecha_desde = mysqli_real_escape_string($link, $fecha_desde_raw);
$fecha_hasta = mysqli_real_escape_string($link, $fecha_hasta_raw);

$sql = "";
$filename = "reporte_" . date('Ymd') . ".csv"; // Nombre por defecto
$developer_records = array();

switch($id) {
    case "reclamos":
        $sql = "SELECT 
				Nreclamo, solicitante, telefono1, telefono2,
				email, ci_difunto, nombre_difunto, tipo,
				REPLACE(REPLACE(comentario,CHAR(10),''),CHAR(13),'') AS comentario,
				estatus, registro, registra, modificacion,
				modifica, replace(mensaje_cliente,'\n',' ') AS mensaje_cliente,
				seccion, modulo, sub_seccion, parcela, boveda 
			FROM sco_reclamo 
			WHERE registro between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59'
			ORDER BY registro desc;";
        $filename = "hercules_reclamos_" . date('Ymd') . ".csv";
        break;

    case "orden_salida":
        $sql = "SELECT 
				a.Norden_salida, a.fecha_hora, CONCAT(a.username, ' - ', b.nombre) AS solicitante, 
				g.userlevelname AS area, CONCAT(a.conductor, ' - ', c.nombre) AS conductor, 
				a.acompanantes, m.nombre AS marca, d.nombre AS modelo, 
				a.placa, f.tipo, f.anho, f.color, 
				a.motivo, a.observaciones, a.autoriza, a.fecha_autoriza, p.valor2 AS estatus 
			FROM sco_orden_salida AS a 
					LEFT OUTER JOIN sco_user AS b ON b.username = a.username 
					LEFT OUTER JOIN sco_user AS c ON c.username = a.conductor 
					LEFT OUTER JOIN userlevels AS g ON g.userlevelid = a.grupo 
					LEFT OUTER JOIN sco_flota AS f ON f.placa = a.placa 
					LEFT OUTER JOIN sco_marca AS m ON m.Nmarca = f.marca 
					LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = f.modelo 
					LEFT OUTER JOIN sco_parametro AS p ON p.valor1 = a.estatus AND p.codigo = '031' 
			WHERE a.fecha_hora between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59'
			ORDER BY a.fecha_hora desc;";
        $filename = "hercules_ordenes_salida_" . date('Ymd') . ".csv";
        break;

    case "mttotecnico":
        $sql = "SELECT 
				a.Nmttotecnico, a.fecha_registro, CONCAT(a.user_solicita, ' - ', b.nombre) AS solicitante, 
				a.tipo_solicitud, a.unidad_solicitante, 
				a.area_falla, a.comentario, 
				a.prioridad, a.estatus, a.falla_atendida_por, a.diagnostico, a.solucion, a.requiere_materiales, 
				a.materiales, CONCAT(a.user_diagnostico, ' - ', c.nombre) AS user_diagnostico, 
				a.fecha_solucion 
			FROM sco_mttotecnico AS a 
					LEFT OUTER JOIN sco_user AS b ON b.username = a.user_solicita
					LEFT OUTER JOIN sco_user AS c ON c.username = a.user_diagnostico 
			WHERE a.fecha_registro between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59'
			ORDER BY a.fecha_registro desc;";
        $filename = "hercules_mtto_tecnico_" . date('Ymd') . ".csv";
        break;

    case "flotas":
        $sql = "SELECT 
				a.Nflota_incidencia AS id, 
				a.fecha_registro, 
				e.nombre AS area, b.tipo, 
				c.nombre AS marcas, d.nombre AS modelo, 
				b.placa, b.color, b.anho, 
				b.serial_carroceria, b.serial_motor, 
				a.tipo AS estatus, 
				f.campo_descripcion AS falla, 
				g.campo_descripcion AS reparacion, 
				replace(a.diagnostico, '\r\n', '') AS diagnostico, a.solicitante, 
				replace(a.nota, '\r\n', '') AS nota, 
				h.nombre AS proveedor, 
				a.username AS regitra, 
				a.username_diagnostica, 
				a.fecha_reparacion 
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND f.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59'
			ORDER BY a.fecha_registro desc;"; 
        $filename = "hercules_flotas_" . date('Ymd') . ".csv";
        break;

    case "lapidas":
        $sql = "SELECT 
				a.Nlapidas_registro AS id, 
				a.solicitante, b.campo_descripcion AS parentesco, 
				a.telefono1, a.telefono2, a.email, a.ci_difunto, a.nombre_difunto, 
				a.tipo, replace(a.comentario, '\r\n', '') AS comentario, a.estatus,
				a.registro, a.registra, 
				a.modificacion, a.modifica, 
				a.seccion, a.modulo, a.sub_seccion, a.parcela, a.boveda, 
				a.contrato 
			FROM 
				sco_lapidas_registro AS a 
				LEFT OUTER JOIN sco_tabla AS b ON a.parentesco = b.campo_codigo AND b.tabla = 'PARENTESCOS' 
			WHERE a.registro between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59'
			ORDER BY a.registro desc;"; 
        $filename = "hercules_lapidas_" . date('Ymd') . ".csv";
        break;

    case "parcelas":
        $fechaSQL = "";
        switch($tipo_mov) {
            case "registro":
                $fechaSQL = "fecha_registro";
                break;
            case "compra":
                $fechaSQL = "fecha_compra";
                break;
            case "venta":
                $fechaSQL = "fecha_venta";
                break;
            default:
                die("Error: Tipo de movimiento (tipo_mov) es requerido para el reporte de parcelas.");
        }

        $sql = "SELECT 
				Nparcela_ventas AS id, ci_vendedor, vendedor,
				seccion, modulo, subseccion, parcela,
				usuario_compra, fecha_compra, valor_compra, moneda_compra,
				tasa_compra, ci_comprador, comprador, usuario_vende,
				fecha_venta, valor_venta, moneda_venta, tasa_venta,
				id_parcela, replace(nota, '\n ', ' ') AS nota, estatus, fecha_registro,
				numero_factura, orden_pago 
			FROM 
				sco_parcela_ventas 
			WHERE $fechaSQL between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59'
			ORDER BY $fechaSQL desc;"; 
        $filename = "hercules_parcelas_" . date('Ymd') . ".csv";
        break;

    case "compras":
        $sql = "SELECT 
				*
			FROM sco_orden_compra 
			WHERE 
				fecha between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59' 
			ORDER BY fecha desc;"; 
        $filename = "hercules_compras_" . date('Ymd') . ".csv";
        break;
        
    case "otros": 
    default:
        die("Error: ID de reporte inválido.");
}

// 3. Ejecución de la consulta con MySQLi
if (!empty($sql)) {
    $rs = mysqli_query($link, $sql); // Reemplaza mysql_query() con mysqli_query()

    if (!$rs) {
        die("Error al ejecutar la consulta: " . mysqli_error($link));
    }

    // 4. Recolección de resultados con MySQLi
    while ($row = mysqli_fetch_assoc($rs)) { // Reemplaza mysql_fetch_assoc() con mysqli_fetch_assoc()
        $developer_records[] = $row;
    }
    mysqli_free_result($rs);
} else {
    die("Error: No se pudo construir la consulta SQL.");
}

// 5. Exportación a CSV (compatible con Excel)
// Se reemplaza la lógica de exportación original por el método CSV de cxc_fact.php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
// Escribir la marca BOM (Byte Order Mark) para que Excel reconozca UTF-8 correctamente
fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

// Cabeceras (nombres de columna)
if (!empty($developer_records)) {
    $headers = array_keys($developer_records[0]);
    fputcsv($output, $headers, ';'); // Usamos ';' como separador de campo
    
    // Escribir los datos
    foreach ($developer_records as $row) {
        fputcsv($output, $row, ';');
    }
}

fclose($output);
mysqli_close($link); // Cerrar la conexión
exit;

?>