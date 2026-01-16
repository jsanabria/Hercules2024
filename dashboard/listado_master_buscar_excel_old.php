<?php
include 'includes/conexBD.php';
$id = $_GET["id"];

switch($id) {
case "reclamos":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];

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
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_reclamos_" . date('Ymd') . ".xls";
	break;
case "orden_salida":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];

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
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_ordenes_salida_" . date('Ymd') . ".xls";
	break;
case "mttotecnico":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];

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
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_mtto_tecnico_" . date('Ymd') . ".xls";
	break;
case "flotas":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];

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
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_flotas_" . date('Ymd') . ".xls";
	break;
case "lapidas":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];

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
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_lapidas_" . date('Ymd') . ".xls";
	break;
case "parcelas":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];
	$tipo_mov = $_REQUEST["tipo_mov"];

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
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_parcelas_" . date('Ymd') . ".xls";
	break;
case "compras":
	$fecha_desde = $_REQUEST["fd"];
	$fecha_hasta = $_REQUEST["fh"];

	$sql = "SELECT 
				*
			FROM sco_orden_compra 
			WHERE 
				fecha between '$fecha_desde 00:00:00' and '$fecha_hasta 23:59:59' 
			ORDER BY fecha desc;"; 
	$rs = mysql_query($sql);

	$developer_records = array();
	while( $row = mysql_fetch_assoc($rs) ) {
		$developer_records[] = $row;
	}

	$filename = "hercules_parcelas_" . date('Ymd') . ".xls";
	break;
case "otros": // Para configurarlo más adelante, por los momnetos funcionara el primero
	break;
default:
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");
$show_coloumn = false;
foreach($developer_records as $record) {
	if(!$show_coloumn) {
		// display field/column names in first row
		echo implode("\t", array_keys($record)) . "\n";
		$show_coloumn = true;
	}
	echo implode("\t", array_values($record)) . "\n";
}
exit;

?>
