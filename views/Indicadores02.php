<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores02 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$fecha_desde = trim($_REQUEST["fecha_desde"]);
$fecha_hasta = trim($_REQUEST["fecha_hasta"]);
$user = trim($_REQUEST["user"]);

if($fecha_desde == "" or $fecha_hasta == "") {
	$fecha_desde = date("Y-m-d");
	$fecha_hasta = date("Y-m-d");
}

$fecha = explode("-", $fecha_desde);
$fec_des = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];
$fecha = explode("-", $fecha_hasta);
$fec_has = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];

$sql = "SELECT nombre FROM sco_user WHERE username = '$user';";
$usuario = ExecuteScalar($sql);

////////////////// Atendidos por Usuario ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
		date_format(r.registro, '%d/%m/%Y') AS registro, COUNT(r.registro) AS cantidad 
	FROM 
		sco_reclamo AS r 
		LEFT OUTER JOIN sco_user AS u ON u.username = r.registra 
	WHERE 
		 r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
		 AND r.registra = '$user' 
	GROUP BY 
		date_format(r.registro, '%d/%m/%Y')) AS a";
$cantidad = ExecuteScalar($sql);

$out_data = "";
//$out_data = "['Usuario', 'Atendidos', { role: 'style' }, { role: 'annotation' }],";
$out_data = "['Dias', 'Reclamos Atendidas', { role: 'annotation' }],";

$table = '<div class="table-responsive">';
$tabla .= '<table class="table table-condensed table-bordered table-sm">';
$tabla .= '<tr><th>D&iacute;a</th></tr>';

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				date_format(r.registro, '%d/%m/%Y') AS registro, COUNT(r.registro) AS cantidad 
			FROM 
				sco_reclamo AS r 
				LEFT OUTER JOIN sco_user AS u ON u.username = r.registra 
			WHERE 
		 		r.registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
		 		AND r.registra = '$user' 
		 	GROUP BY 
				date_format(r.registro, '%d/%m/%Y') 
			ORDER BY r.registro LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data .= "['" . $row["registro"] . "', " . floatval($row["cantidad"]) . ", '" . floatval($row["cantidad"]) . "'] ,";
	$tabla .= '<tr><td>' . $row["registro"] . ' <strong>(' . floatval($row["cantidad"]) . ')</strong></td></tr>';
	$acumulador += floatval($row["cantidad"]);
}
$tabla .= '<tr><td colspan="2"><strong>Total Reclamos: ' . $acumulador . '</strong></td></tr>';
$tabla .= '</table>';
$tabla .= '</div>';
$out_data = substr($out_data, 0, strlen($out_data)-1);
//die($out_data);
///////////////////////////////////////////////////////////////////

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawVisualization);

  google.charts.setOnLoadCallback(drawVisualization2);

  google.charts.setOnLoadCallback(drawVisualization3);

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
	title: "Reclamos Registrados por Gestor <?php echo $usuario; ?> desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?>",
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
</div>

<input type="hidden" id="chart" name="chart" value="">


<?= GetDebugMessage() ?>
