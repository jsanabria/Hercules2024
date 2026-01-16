<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores11 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$fecha_desde = trim($_REQUEST["fecha_desde"]);
$fecha_hasta = trim($_REQUEST["fecha_hasta"]);
if($fecha_desde == "" or $fecha_hasta == "") {
	$fecha_desde = date("Y-m-d");
	$fecha_hasta = date("Y-m-d");
}
$fecha = explode("-", $fecha_desde);
$fec_des = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];
$fecha = explode("-", $fecha_hasta);
$fec_has = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];

////////////////// Unidades Segun Cantidad de Siniestros ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				COUNT(b.placa) AS cantidad  
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY b.placa, c.nombre, d.nombre, b.color, b.anho) AS a"; 
$cantidad = ExecuteScalar($sql);
$out_data = "";

//$out_data = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
//$out_data = "['Usuario', 'Reclamos Registrados', { role: 'annotation' }],";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				b.placa, 
				c.nombre AS marca, d.nombre AS modelo, 
				b.color, b.anho, 
				COUNT(b.placa) AS cantidad 
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY b.placa, c.nombre, d.nombre, b.color, b.anho 
			ORDER BY cantidad DESC LIMIT $i, 1;"; 
	$row = ExecuteRow($sql);
	$unidad = $row["placa"] . " " . $row["marca"] . " " . $row["modelo"] . " " . $row["color"] . " " . $row["anho"];
	$cant = $row["cantidad"];
	$out_data .= "['$unidad', " . floatval($cant) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data = substr($out_data, 0, strlen($out_data)-1);
$titulo = "Unidades Segun Cantidad de Siniestros";

///////////////////////////////////////////////////////////////////
////////////////// Fallas en el Periodo ///////////////////////

$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				a.falla, f.campo_descripcion AS nom_falla, COUNT(a.falla) AS cantidad 
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY a.falla) AS a"; 
$cantidad = ExecuteScalar($sql);
$out_data2 = "";

//$out_data2 = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
//$out_data2 = "['Usuario', 'Reclamos Cerrados', { role: 'annotation' }],";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.falla, f.campo_descripcion AS nom_falla, COUNT(a.falla) AS cantidad 
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY a.falla
			ORDER BY cantidad DESC LIMIT $i, 1;"; 
	$row = ExecuteRow($sql);
	$falla = $row["nom_falla"];
	$cant = $row["cantidad"];
	$out_data2 .= "['$falla', " . intval($cant) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data2 = substr($out_data2, 0, strlen($out_data2)-1);
$titulo2 = "Fallas en el Periodo";

///////////////////////////////////////////////////////////////////
////////////////// Reparaciones por Proveedores en el Periodo ///////////////////////

$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
			a.proveedor, h.nombre AS nom_prov, COUNT(a.proveedor) AS cantidad 
		FROM 
			sco_flota_incidencia AS a 
			JOIN sco_flota AS b ON b.Nflota = a.flota 
			LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
			LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
			LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
			LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
			LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
			LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
		WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
		GROUP BY a.proveedor) AS a"; 
$cantidad = ExecuteScalar($sql);
$out_data3 = "";

//$out_data3 = "['Tipo Servicio', 'Reclamos Registrados', { role: 'annotation' }],";
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.proveedor, h.nombre AS nom_prov, COUNT(a.proveedor) AS cantidad 
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY a.proveedor
			ORDER BY cantidad DESC LIMIT $i, 1;"; 
	$row = ExecuteRow($sql);
	$proveedor = $row["nom_prov"];
	$cant = $row["cantidad"];
	$out_data3 .= "['$proveedor', " . intval($cant) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data3 = substr($out_data3, 0, strlen($out_data3)-1);
$titulo3 = "Reparaciones por Proveedores en el Periodo";

///////////////////////////////////////////////////////////////////
////////////////// Reparaciones en el Periodo ///////////////////////

$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
			a.reparacion, g.campo_descripcion AS nom_reparar, COUNT(a.reparacion) AS cantidad  
		FROM 
			sco_flota_incidencia AS a 
			JOIN sco_flota AS b ON b.Nflota = a.flota 
			LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
			LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
			LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
			LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
			LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
			LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
		WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
		GROUP BY a.reparacion) AS a"; 
$cantidad = ExecuteScalar($sql);
$out_data4 = "";

//$out_data3 = "['Tipo Servicio', 'Reclamos Registrados', { role: 'annotation' }],";
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.reparacion, g.campo_descripcion AS nom_reparar, COUNT(a.reparacion) AS cantidad  
			FROM 
				sco_flota_incidencia AS a 
				JOIN sco_flota AS b ON b.Nflota = a.flota 
				LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
				LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
				LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
				LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
				LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
				LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor 
			WHERE a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY a.reparacion
			ORDER BY cantidad DESC LIMIT $i, 1;"; 
	$row = ExecuteRow($sql);
	$reparacion = $row["nom_reparar"];
	$cant = $row["cantidad"];
	$out_data4 .= "['$reparacion', " . intval($cant) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data4 = substr($out_data4, 0, strlen($out_data4)-1);
$titulo4 = "Reparaciones en el Periodo";

///////////////////////////////////////////////////////////////////
?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

	  // Load Charts and the corechart package.
	  google.charts.load('current', {'packages':['corechart']});

	  // Draw the pie chart for Resgistro de Reclamos.
	  google.charts.setOnLoadCallback(drawGestorChart);

	  // Draw the pie chart for Cierre de Reclamos.
	  google.charts.setOnLoadCallback(drawGestorCloseChart);

	  // Draw the pie chart for Servicos de Reclamos when Charts is loaded.
	  google.charts.setOnLoadCallback(drawServicioChart);

	  // Draw the pie chart for Servicos de Reclamos when Charts is loaded.
	  google.charts.setOnLoadCallback(drawReparacionChart);

	  // Callback that draws the pie chart for Registro de Reclamos.
	  function drawGestorChart() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Unidad');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data; ?>
		]);

		// Set options for Sarah's pie chart.
		var options = {title:'<?php echo $titulo; ?>',
					   width:550,
					   height:400};

		// Instantiate and draw the chart for Sarah's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Gestor_chart_div'));
		chart.draw(data, options);
	  }

	  // Callback that draws the pie chart for Cierre de Reclamos.
	  function drawGestorCloseChart() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Falla');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data2; ?>
		]);

		// Set options for Sarah's pie chart.
		var options = {title:'<?php echo $titulo2; ?>',
					   width:550,
					   height:400};

		// Instantiate and draw the chart for Sarah's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Gestor_chart_div2'));
		chart.draw(data, options);
	  }

	  // Callback that draws the pie chart for Servicios de Reclamos.
	  function drawServicioChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Proveedor');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data3; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo3; ?>',
					   width:550,
					   height:400};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Servicio_chart_div'));
		chart.draw(data, options);
	  }

	  // Callback that draws the pie chart for Servicios de Reclamos.
	  function drawReparacionChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Reparacion');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data4; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo3; ?>',
					   width:550,
					   height:400};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Reparacion_chart_div'));
		chart.draw(data, options);
	  }
	</script>
<div class="container">
	<h2>Indicadores de Flotas desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?></h2>
	<table class="columns">
	  <tr>
		<td><div id="Gestor_chart_div" style="border: 1px solid #ccc"></div></td>
		<td><div id="Gestor_chart_div2" style="border: 1px solid #ccc"></div></td>
	  </tr>
	  <tr>
		<td><div id="Servicio_chart_div" style="border: 1px solid #ccc"></div></td>
		<td><div id="Reparacion_chart_div" style="border: 1px solid #ccc"></div></td>
	  </tr>
	</table>
</div>


<?= GetDebugMessage() ?>
