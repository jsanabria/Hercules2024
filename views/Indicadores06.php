<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores06 = &$Page;
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

////////////////// Solicitudes Registradas ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				a.user_solicita, b.nombre AS nombre, COUNT(a.user_solicita) AS cantidad 
			FROM sco_mttotecnico AS a 
				LEFT OUTER JOIN sco_user AS b ON b.username = a.user_solicita  
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.user_solicita, b.nombre) AS a";
$cantidad = ExecuteScalar($sql);

$out_data = "";
//$out_data = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
//$out_data = "['Usuario', 'Reclamos Registrados', { role: 'annotation' }],";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.user_solicita, b.nombre AS nombre, COUNT(a.user_solicita) AS cantidad 
			FROM sco_mttotecnico AS a 
				LEFT OUTER JOIN sco_user AS b ON b.username = a.user_solicita  
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.user_solicita, b.nombre
			ORDER BY nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data .= "['" . $row["nombre"] . "', " . floatval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data = substr($out_data, 0, strlen($out_data)-1);
$titulo = "Solicitudes Registradas";
///////////////////////////////////////////////////////////////////


////////////////// Solicitudes por Diagnóstico ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
			a.user_diagnostico, b.nombre AS nombre, COUNT(a.user_diagnostico) AS cantidad 
		FROM sco_mttotecnico AS a 
			LEFT OUTER JOIN sco_user AS b ON b.username = a.user_diagnostico  
		WHERE 
			a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
		GROUP BY a.user_diagnostico, b.nombre) AS a"; 
$cantidad = ExecuteScalar($sql);

$out_data2 = "";
//$out_data2 = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
//$out_data2 = "['Usuario', 'Reclamos Cerrados', { role: 'annotation' }],";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
			IFNULL(a.user_diagnostico, 'S/D') AS user_diagnostico,
			IFNULL(b.nombre, 'SIN DIAGNOSTICO') AS nombre, COUNT(a.user_diagnostico) AS cantidad 
		FROM sco_mttotecnico AS a 
			LEFT OUTER JOIN sco_user AS b ON b.username = a.user_diagnostico  
		WHERE 
			a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
		GROUP BY a.user_diagnostico, b.nombre
			ORDER BY nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data2 .= "['" . $row["nombre"] . "', " . floatval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data2 = substr($out_data2, 0, strlen($out_data2)-1);
$titulo2 = "Diagnosticos";
///////////////////////////////////////////////////////////////////


////////////////// Solicitudes Tipo de Servicio ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				a.tipo_solicitud, COUNT(a.tipo_solicitud) AS cantidad 
			FROM sco_mttotecnico AS a 
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.tipo_solicitud) AS a";
$cantidad = ExecuteScalar($sql);

$out_data3 = "";
//$out_data3 = "['Tipo Servicio', 'Reclamos Registrados', { role: 'annotation' }],";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.tipo_solicitud, COUNT(a.tipo_solicitud) AS cantidad 
			FROM sco_mttotecnico AS a 
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.tipo_solicitud LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data3 .= "['" . $row["tipo_solicitud"] . "', " . floatval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data3 = substr($out_data3, 0, strlen($out_data3)-1);
$titulo3 = "Tipo de Servicio";
///////////////////////////////////////////////////////////////////


////////////////// Solicitudes por Estatus ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				a.estatus, COUNT(a.estatus) AS cantidad 
			FROM sco_mttotecnico AS a 
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.estatus) AS a";
$cantidad = ExecuteScalar($sql);

$out_data5 = "";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.estatus, COUNT(a.estatus) AS cantidad 
			FROM sco_mttotecnico AS a 
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.estatus LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data5 .= "['" . $row["estatus"] . "', " . floatval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data5 = substr($out_data5, 0, strlen($out_data5)-1);
$titulo5 = "Estatus Servicio";
//////////////////////////////////////////////////////////////////

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


	  // Draw the pie chart for Estatus when Charts is loaded.
	  google.charts.setOnLoadCallback(drawEstatusChart);

	  // Callback that draws the pie chart for Registro de Reclamos.
	  function drawGestorChart() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Gestor');
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
		data.addColumn('string', 'Gestor');
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
		data.addColumn('string', 'Servicio');
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


	  // Callback that draws the pie chart for Estatus.
	  function drawEstatusChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Estatus');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data5; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo5; ?>',
					   width:550,
					   height:400};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Estatus_chart_div'));
		chart.draw(data, options);
	  }
	</script>

<div class="container">
	<h2>Indicadores desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?></h2>
	<table class="columns">
	  <tr>
		<td><div id="Gestor_chart_div" style="border: 1px solid #ccc"></div></td>
		<td><div id="Gestor_chart_div2" style="border: 1px solid #ccc"></div></td>
	  </tr>
	  <tr>
		<td><div id="Servicio_chart_div" style="border: 1px solid #ccc"></div></td>
		<td><div id="Estatus_chart_div" style="border: 1px solid #ccc"></div></td>
	  </tr>
	</table>
</div>

<?= GetDebugMessage() ?>
