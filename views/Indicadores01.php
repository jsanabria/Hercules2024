<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores01 = &$Page;
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

////////////////// Reclamos Registrados por Usuarios ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
		r.registra, IFNULL(u.nombre, r.registra) AS nombre, COUNT(r.registra) AS cantidad 
	FROM 
		sco_reclamo AS r 
		LEFT OUTER JOIN sco_user AS u ON u.username = r.registra 
	WHERE 
		 r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
	GROUP BY 
		r.registra, u.nombre) AS a";
$cantidad = ExecuteScalar($sql);

$out_data = "";
//$out_data = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
$out_data = "['Usuario', 'Reclamos Registrados', { role: 'annotation' }],";

$table = '<div class="table-responsive">';
$tabla .= '<table class="table table-condensed table-bordered table-sm">';
$tabla .= '<tr><th>Username</th><th>Nombre Gestor / Promedio Atenci&oacute;n</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.registra, IFNULL(u.nombre, r.registra) AS nombre, COUNT(r.registra) AS cantidad,
				ROUND(AVG(DATEDIFF(CONCAT(r.modificacion), CONCAT(r.registro)))) AS tiempo_atencion 
			FROM 
				sco_reclamo AS r 
				LEFT OUTER JOIN sco_user AS u ON u.username = r.registra 
			WHERE 
				r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY 
				r.registra, u.nombre
			ORDER BY nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data .= "['" . $row["registra"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla .= '<tr><td><a href="indicadores_02.php?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&user=' . $row["registra"] . '">' . $row["registra"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td>' . $row["nombre"] . ' <strong>(' . $row["tiempo_atencion"] . ' DIAS)</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla .= '<tr><td colspan="2"><strong>Total Atendidos: ' . $acumulador . '</strong></td></tr>';
$tabla .= '</table>';
$tabla .= '</div>';
$out_data = substr($out_data, 0, strlen($out_data)-1);
//die($out_data);
///////////////////////////////////////////////////////////////////

// **** //
////////////////// Reclamos Cerrados por Usuarios ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
		r.modifica, IFNULL(u.nombre, r.modifica) AS nombre, COUNT(r.modifica) AS cantidad 
	FROM 
		sco_reclamo AS r 
		LEFT OUTER JOIN sco_user AS u ON u.username = r.modifica 
	WHERE 
		 r.modificacion BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
	GROUP BY 
		r.modifica, u.nombre) AS a"; 
$cantidad = ExecuteScalar($sql);

$out_data4 = "";
//$out_data4 = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
$out_data4 = "['Usuario', 'Reclamos Cerrados', { role: 'annotation' }],";

$table4 = '<div class="table-responsive">';
$tabla4 .= '<table class="table table-condensed table-bordered table-sm">';
$tabla4 .= '<tr><th>Username</th><th>Nombre Gestor / Promedio Atenci&oacute;n</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.modifica, IFNULL(u.nombre, r.modifica) AS nombre, COUNT(r.modifica) AS cantidad,
				ROUND(AVG(DATEDIFF(CONCAT(r.modificacion), CONCAT(r.registro)))) AS tiempo_atencion 
			FROM 
				sco_reclamo AS r 
				LEFT OUTER JOIN sco_user AS u ON u.username = r.modifica 
			WHERE 
				r.modificacion BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY 
				r.modifica, u.nombre
			ORDER BY nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data4 .= "['" . $row["modifica"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla4 .= '<tr><td><a href="indicadores_03.php?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&user=' . $row["modifica"] . '">' . $row["modifica"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td>' . $row["nombre"] . ' <strong>(' . $row["tiempo_atencion"] . ' DIAS)</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla4 .= '<tr><td colspan="2"><strong>Total Atendidos: ' . $acumulador . '</strong></td></tr>';
$tabla4 .= '</table>';
$tabla4 .= '</div>';
$out_data4 = substr($out_data4, 0, strlen($out_data4)-1);
//die($out_data);
///////////////////////////////////////////////////////////////////
// **** //

////////////////// Reclamos Registrados por Dia ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
		date_format(r.registro, '%d/%m/%Y') AS registro, COUNT(r.registro) AS cantidad 
	FROM 
		sco_reclamo AS r 
		LEFT OUTER JOIN sco_user AS u ON u.username = r.registra 
	WHERE 
		 r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
	GROUP BY 
		date_format(r.registro, '%d/%m/%Y')) AS a";
$cantidad = ExecuteScalar($sql);

$out_data2 = "";
$out_data2 = "['Días', 'Reclamos Registrados', { role: 'annotation' }],";

$table2 = '<div class="table-responsive">';
$tabla2 .= '<table class="table table-condensed table-bordered table-sm">';
$tabla2 .= '<tr><th> </th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				date_format(r.registro, '%d/%m/%Y') AS registro, COUNT(r.registro) AS cantidad 
			FROM 
				sco_reclamo AS r 
				LEFT OUTER JOIN sco_user AS u ON u.username = r.registra 
			WHERE 
				r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY 
				date_format(r.registro, '%d/%m/%Y') 
			ORDER BY r.registro LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data2 .= "['" . $row["registro"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla2 .= '<tr><td>' . $row["registro"] . ' <strong>(' . floatval($row["cantidad"]) . ')</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla2 .= '<tr><td colspan="2"><strong>Reclamos Registrados: ' . $acumulador . '</strong></td></tr>';
$tabla2 .= '</table>';
$tabla2 .= '</div>';
$out_data2 = substr($out_data2, 0, strlen($out_data2)-1);
///////////////////////////////////////////////////////////////////



////////////////// Reclamos por Tipo de Servicio ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				r.tipo, COUNT(r.tipo) AS cantidad  
			FROM 
				sco_reclamo AS r 
			WHERE 
				r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
	GROUP BY 
		r.tipo) AS a";
$cantidad = ExecuteScalar($sql);

$out_data3 = "";
$out_data3 = "['Tipo Servicio', 'Reclamos Registrados', { role: 'annotation' }],";

$table3 = '<div class="table-responsive">';
$tabla3 .= '<table class="table table-condensed table-bordered table-sm">';
$tabla3 .= '<tr><th> </th><th>Tiempo Promedio</th></tr>';
$tabla3 .= '<tr><th>Tipo Servicio</th><th>Atenci&oacute;n</th></tr>';
$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.tipo, COUNT(r.tipo) AS cantidad,  
				ROUND(AVG(DATEDIFF(CONCAT(r.modificacion), CONCAT(r.registro)))) AS tiempo_atencion 
			FROM 
				sco_reclamo AS r 
			WHERE 
				r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY 
				r.tipo LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data3 .= "['" . $row["tipo"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla3 .= '<tr><td><a href="indicadores_03.php?fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '&tipo=' . $row["tipo"] . '">' . $row["tipo"] . '</a> <strong>(' . floatval($row["cantidad"]) . ')</strong></td><td><strong>(' . $row["tiempo_atencion"] . ' DIAS)</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla3 .= '<tr><td colspan="2"><strong>Total Atendidos: ' . $acumulador . '</strong></td></tr>';
$tabla3 .= '</table>';
$tabla3 .= '</div>';
$out_data3 = substr($out_data3, 0, strlen($out_data3)-1);
///////////////////////////////////////////////////////////////////

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawVisualization);

  google.charts.setOnLoadCallback(drawVisualization2);

  google.charts.setOnLoadCallback(drawVisualization3);

  google.charts.setOnLoadCallback(drawVisualization4);

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
	title: "Reclamos Atendidos por Gestor desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Reclamos Registrados por Gestor'},
		hAxis: {title: 'Gestores'},
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
	title: "Reclamos Cerrados por Gestor desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Reclamos Cerrados por Gestor'},
		hAxis: {title: 'Gestores'},
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


  function drawVisualization2() {
	// Some raw data (not necessarily accurate)
	var data = google.visualization.arrayToDataTable([
	  <?php echo $out_data2; ?>
	]);


  var options = {
	title: "Reclamos Registrados por Día desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Reclamos Registrados por Día'},
		hAxis: {title: 'Días'},
		bar: {groupWidth: '65%'},
			'height':450,
			'width' :900,
		legend: 'bottom',
			seriesType: 'bars',
  		series: {1: {type: 'line'}} 
	  };	  

	//var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));  --- oko con esto : legend: 'none', despue de width
	  var chart_div = document.getElementById('chart_div2');
	  var chart = new google.visualization.ColumnChart(chart_div);
	  google.visualization.events.addListener(chart, 'ready', function () {
	  	document.getElementById("chart2").value = chart.getImageURI();
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
	title: "Reclamos Registrados por Tipo de Servicio desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
			vAxis: {title: 'Reclamos Registrados por Tipo de Servicio'},
		hAxis: {title: 'Servicio'},
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
   <hr>

   <div class="row">
	<div class="col-sm-8">
	  <div id="chart_div2"></div>
	</div>
	<div class="col-sm-4">
	  <?php echo $tabla2; ?>
	</div>
  </div>
</div>

<input type="hidden" id="chart" name="chart" value="">
<input type="hidden" id="chart2" name="chart2" value="">
<input type="hidden" id="chart3" name="chart3" value="">
<input type="hidden" id="chart4" name="chart4" value="">


<?= GetDebugMessage() ?>
