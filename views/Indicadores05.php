<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores05 = &$Page;
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

////////////////// Solicitudes Registrados por Solicitante ///////////////////////
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
$out_data = "['Usuario', 'Solicitudes Registradas', { role: 'annotation' }],";

$table = '<div class="table-responsive">';
$tabla .= '<table class="table table-condensed table-bordered table-sm">';
$tabla .= '<tr><th>Username</th><th>Nombre Solicitante</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				IFNULL(a.user_solicita, 'N/A') AS user_solicita,
				IFNULL(b.nombre, 'NO APLICA') AS nombre, COUNT(a.user_solicita) AS cantidad 
			FROM sco_mttotecnico AS a 
				LEFT OUTER JOIN sco_user AS b ON b.username = a.user_solicita  
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.user_solicita, b.nombre
			ORDER BY nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data .= "['" . $row["user_solicita"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla .= '<tr><td><a href="#?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&user=' . $row["user_solicita"] . '">' . $row["user_solicita"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td>' . $row["nombre"] . '</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla .= '<tr><td colspan="2"><strong>Total Solicitudes: ' . $acumulador . '</strong></td></tr>';
$tabla .= '</table>';
$tabla .= '</div>';
$out_data = substr($out_data, 0, strlen($out_data)-1);
//die($out_data);
///////////////////////////////////////////////////////////////////

// **** //
////////////////// Solicitudes por Diagnostico ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
			a.user_diagnostico, b.nombre AS nombre, COUNT(a.user_solicita) AS cantidad 
		FROM sco_mttotecnico AS a 
			LEFT OUTER JOIN sco_user AS b ON b.username = a.user_diagnostico  
		WHERE 
			a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
		GROUP BY a.user_diagnostico, b.nombre) AS a"; 
$cantidad = ExecuteScalar($sql);

$out_data4 = "";
//$out_data4 = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
$out_data4 = "['Usuario', 'Diagnosticos', { role: 'annotation' }],";

$table4 = '<div class="table-responsive">';
$tabla4 .= '<table class="table table-condensed table-bordered table-sm">';
$tabla4 .= '<tr><th>Username</th><th>Nombre Diagnostica</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
			IFNULL(a.user_diagnostico, 'S/D') AS user_diagnostico,
			IFNULL(b.nombre, 'SIN DIAGNOSTICO') AS nombre, COUNT(a.user_solicita) AS cantidad 
		FROM sco_mttotecnico AS a 
			LEFT OUTER JOIN sco_user AS b ON b.username = a.user_diagnostico  
		WHERE 
			a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
		GROUP BY a.user_diagnostico, b.nombre
			ORDER BY nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data4 .= "['" . $row["user_diagnostico"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla4 .= '<tr><td><a href="#?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&user=' . $row["user_diagnostico"] . '">' . $row["user_diagnostico"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td>' . $row["nombre"] . '</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla4 .= '<tr><td colspan="2"><strong>Total Diagnosticos: ' . $acumulador . '</strong></td></tr>';
$tabla4 .= '</table>';
$tabla4 .= '</div>';
$out_data4 = substr($out_data4, 0, strlen($out_data4)-1);
//die($out_data);
///////////////////////////////////////////////////////////////////
// **** //


////////////////// Mantenimiento por Tipo de Servicio ///////////////////////
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
$out_data3 = "['Tipo Servicio', 'Solicitudes Registradas', { role: 'annotation' }],";

$table3 = '<div class="table-responsive">';
$tabla3 .= '<table class="table table-condensed table-bordered table-sm">';
$tabla3 .= '<tr><th>Tipo Servicio</th><th>Cantidad</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.tipo_solicitud, COUNT(a.tipo_solicitud) AS cantidad 
			FROM sco_mttotecnico AS a 
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.tipo_solicitud LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data3 .= "['" . $row["tipo_solicitud"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	//$tabla3 .= '<tr><td><a href="#?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&tipo=' . $row["tipo_solicitud"] . '">' . $row["tipo_solicitud"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td></td></tr>';
	$tabla3 .= '<tr><td><strong>' . $row["tipo_solicitud"] . ' (' . floatval($row["cantidad"]) . ')</strong></td><td>' . floatval($row["cantidad"]) . '</td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla3 .= '<tr><td colspan="2"><strong>Total Solicitudes: ' . $acumulador . '</strong></td></tr>';
$tabla3 .= '</table>';
$tabla3 .= '</div>';
$out_data3 = substr($out_data3, 0, strlen($out_data3)-1);
///////////////////////////////////////////////////////////////////


////////////////// Mantenimiento por Estatus ///////////////////////
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
$out_data5 = "['Estatus Servicio', 'Solicitudes Registradas', { role: 'annotation' }],";

$table5 = '<div class="table-responsive">';
$tabla5 .= '<table class="table table-condensed table-bordered table-sm">';
$tabla5 .= '<tr><th>Estatus</th><th>Cantidad</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				a.estatus, COUNT(a.estatus) AS cantidad 
			FROM sco_mttotecnico AS a 
			WHERE 
				a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
			GROUP BY a.estatus LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data5 .= "['" . $row["estatus"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	//$tabla3 .= '<tr><td><a href="#?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&tipo=' . $row["tipo_solicitud"] . '">' . $row["tipo_solicitud"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td></td></tr>';
	$tabla5 .= '<tr><td><strong>' . $row["estatus"] . ' (' . floatval($row["cantidad"]) . ')</strong></td><td>' . floatval($row["cantidad"]) . '</td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla5 .= '<tr><td colspan="2"><strong>Total Solicitudes: ' . $acumulador . '</strong></td></tr>';
$tabla5 .= '</table>';
$tabla5 .= '</div>';
$out_data5 = substr($out_data5, 0, strlen($out_data5)-1);
////////////////////////////////////////////////////////////////////
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawVisualization);

  google.charts.setOnLoadCallback(drawVisualization3);

  google.charts.setOnLoadCallback(drawVisualization4);

  google.charts.setOnLoadCallback(drawVisualization5);

  function drawVisualization() {
	// Some raw data (not necessarily accurate)
	var data = google.visualization.arrayToDataTable([
	  <?php echo $out_data; ?>
	]);

	/*var options = {
	  title: 'Comparativo Gerencia INGENIERIA',
	  vAxis: {title: 'Ponderacion'},
	  hAxis: {title: 'Competencias'},
	  seriesType: 'bars',
  series: {1: {type: 'line'}}   };*/

  var options = {
	title: "Solicitudes Registradas por Solicitante desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Solicitudes Registrados por Gestor'},
		hAxis: {title: 'Solicitante'},
		bar: {groupWidth: '65%'},
			'height':450,
			'width' :900,
		legend: 'bottom',
			seriesType: 'bars',
  		series: {1: {type: 'line'}} 
	  };	  

	//var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));  --- oko con esto : legend: 'none', despue de width
	  var chart_div = document.getElementById('chart_div');
	  var chart = new google.visualization.ColumnChart(chart_div);
	  google.visualization.events.addListener(chart, 'ready', function () {
	  	document.getElementById("chart").value = chart.getImageURI();
		chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
		console.log(chart_div.innerHTML);
	  });

	chart.draw(data, options);
  }

  function drawVisualization4() {
	// Some raw data (not necessarily accurate)
	var data = google.visualization.arrayToDataTable([
	  <?php echo $out_data4; ?>
	]);

	/*var options = {
	  title: 'Comparativo Gerencia INGENIERIA',
	  vAxis: {title: 'Ponderacion'},
	  hAxis: {title: 'Competencias'},
	  seriesType: 'bars',
  series: {1: {type: 'line'}}   };*/

  var options = {
	title: "Solicitudes por Diagnostico desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Solicitudes por Diagnostico'},
		hAxis: {title: 'Usuarios Diagnostica'},
		bar: {groupWidth: '65%'},
			'height':450,
			'width' :900,
		legend: 'bottom',
			seriesType: 'bars',
  		series: {1: {type: 'line'}} 
	  };	  

	//var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));  --- oko con esto : legend: 'none', despue de width
	  var chart_div = document.getElementById('chart_div4');
	  var chart = new google.visualization.ColumnChart(chart_div);
	  google.visualization.events.addListener(chart, 'ready', function () {
	  	document.getElementById("chart4").value = chart.getImageURI();
		chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
		console.log(chart_div.innerHTML);
	  });

	chart.draw(data, options);
  }


  function drawVisualization3() {
	// Some raw data (not necessarily accurate)
	var data = google.visualization.arrayToDataTable([
	  <?php echo $out_data3; ?>
	]);


  var options = {
	title: "Solicitudes por Tipo de Servicio desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Mantenimiento por Tipo de Servicio'},
		hAxis: {title: 'Tipo Servicio'},
		bar: {groupWidth: '65%'},
			'height':450,
			'width' :900,
		legend: 'bottom',
			seriesType: 'bars',
  		series: {1: {type: 'line'}} 
	  };	  

	//var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));  --- oko con esto : legend: 'none', despue de width
	  var chart_div = document.getElementById('chart_div3');
	  var chart = new google.visualization.ColumnChart(chart_div);
	  google.visualization.events.addListener(chart, 'ready', function () {
	  	document.getElementById("chart3").value = chart.getImageURI();
		chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
		console.log(chart_div.innerHTML);
	  });

	chart.draw(data, options);
  }

  function drawVisualization5() {
	// Some raw data (not necessarily accurate)
	var data = google.visualization.arrayToDataTable([
	  <?php echo $out_data5; ?>
	]);


  var options = {
	title: "Solicitudes por Estatus desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Mantenimiento por Estatus'},
		hAxis: {title: 'Estatus Servicio'},
		bar: {groupWidth: '65%'},
			'height':450,
			'width' :900,
		legend: 'bottom',
			seriesType: 'bars',
  		series: {1: {type: 'line'}} 
	  };	  

	//var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));  --- oko con esto : legend: 'none', despue de width
	  var chart_div = document.getElementById('chart_div5');
	  var chart = new google.visualization.ColumnChart(chart_div);
	  google.visualization.events.addListener(chart, 'ready', function () {
	  	document.getElementById("chart5").value = chart.getImageURI();
		chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
		console.log(chart_div.innerHTML);
	  });

	chart.draw(data, options);
  }
  
</script>

<div class="container">
  <div class="row">
	<div class="col-sm-8">
	  <div id="chart_div"></div>
	</div>
	<div class="col-sm-4">
	  <?php echo $tabla; ?>
	</div>
  </div>

<br>
<hr>

  <div class="row">
	<div class="col-sm-8">
	  <div id="chart_div4"></div>
	</div>
	<div class="col-sm-4">
	  <?php echo $tabla4; ?>
	</div>
  </div>
</div>

<br>

<div class="container">
  
  <div class="row">
	<div class="col-sm-8">
	  <div id="chart_div3"></div>
	</div>
	<div class="col-sm-4">
	  <?php echo $tabla3; ?>
	</div>
  </div>
</div>

<br>

<div class="container">
  
  <div class="row">
	<div class="col-sm-8">
	  <div id="chart_div5"></div>
	</div>
	<div class="col-sm-4">
	  <?php echo $tabla5; ?>
	</div>
  </div>
</div>

<br>

<input type="hidden" id="chart" name="chart" value="">
<input type="hidden" id="chart3" name="chart3" value="">
<input type="hidden" id="chart4" name="chart4" value="">
<input type="hidden" id="chart5" name="chart5" value="">


<?= GetDebugMessage() ?>
