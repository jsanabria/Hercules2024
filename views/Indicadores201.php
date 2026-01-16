<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores201 = &$Page;
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

////////////////// (1) Unidades por Cantidad Ordenes de Compra ///////////////////////
$titulo = "Compras por Unidades Solicitante";
$subtitulo = "Desde el $fec_des Hasta el $fec_has";
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT unidad_solicitante, COUNT(unidad_solicitante) AS cantidad 
	FROM sco_orden_compra WHERE estatus = 'CERRADO' AND fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
	GROUP BY unidad_solicitante) AS a";
$cantidad = ExecuteScalar($sql);
$out_data = "";
$out_data = "['$cantidad Unidades Solicitantes', 'Cantidad de Ordenes de Compra', { role: 'annotation' }],";
$acumulador = 0;
$unidad = "";
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT unidad_solicitante, COUNT(unidad_solicitante) AS cantidad 
			FROM sco_orden_compra
			WHERE estatus = 'CERRADO' AND fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY unidad_solicitante
			ORDER BY cantidad DESC LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$unidad = $row["unidad_solicitante"];
	$cant = $row["cantidad"];
	$out_data .= "['$unidad', " . intval($cant) . ", '" . intval($cant) . "'] ,";
	$acumulador += floatval($cant);
}
$out_data = substr($out_data, 0, strlen($out_data)-1);

///////////////////////////////////////////////////////////////////

?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['bar']});
	  google.charts.setOnLoadCallback(drawStuff);

	  function drawStuff() { 
		var data = new google.visualization.arrayToDataTable([
		  <?php echo $out_data; ?>
		]);
		var options = {
		  width: 1200,
		  height:550,
		  chart: {
			title: '<?php echo $titulo; ?>',
			subtitle: '<?php echo $subtitulo; ?>'
		  },
		  bars: 'horizontal', // Required for Material Bar Charts.
		  series: {
			0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
			1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
		  },
		  axes: {
			x: {
			  distance: {label: '<?php echo $acumulador; ?> Ordenes de Compra'}, // Bottom x-axis.
			  brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
			}
		  }
		};
	  	var chart = new google.charts.Bar(document.getElementById('xGrafico'));
		chart.draw(data, options);
	  };

	</script>

	<div id="xGrafico" style="width: 900px; height: 600px;"></div>


<?= GetDebugMessage() ?>
