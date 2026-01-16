<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores14 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$fecha_desde = trim($_REQUEST["fecha_desde"]);
$fecha_hasta = trim($_REQUEST["fecha_hasta"]);
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

if($fecha_desde == "" or $fecha_hasta == "") {
	$fecha_desde = date("Y-m-d");
	$fecha_hasta = date("Y-m-d");
}

$fecha = explode("-", $fecha_desde);
$fec_des = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];
$fecha = explode("-", $fecha_hasta);
$fec_has = $fecha[2] . "/" . $fecha[1] . "/" . $fecha[0];


////////////////// Estatus Compra / Ventas Parcelas ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				r.estatus, COUNT(r.estatus) AS cantidad 
			FROM 
				sco_parcela_ventas AS r 
			WHERE 
				r.$fechaSQL BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
	GROUP BY 
		r.estatus) AS a";
$cantidad = ExecuteScalar($sql);

$out_data = "";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.estatus, COUNT(r.estatus) AS cantidad  
			FROM 
				sco_parcela_ventas AS r 
			WHERE 
				r.$fechaSQL BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
			GROUP BY 
				r.estatus LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data .= "['" . $row["estatus"] . "', " . floatval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data = substr($out_data, 0, strlen($out_data)-1);
$titulo = "Estatus Disponibilidad / Ventas Parcelas";
///////////////////////////////////////////////////////////////////

////////////////// Disponibilidad por Terrazas ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				r.seccion, COUNT(r.seccion) AS cantidad  
			FROM 
				sco_parcela_ventas AS r 
			WHERE 
				r.estatus = 'COMPRA' 
			GROUP BY 
				r.seccion) AS a";
$cantidad = ExecuteScalar($sql);

$out_data1 = "";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.seccion AS terraza, COUNT(r.seccion) AS cantidad  
			FROM 
				sco_parcela_ventas AS r 
			WHERE 
				r.estatus = 'COMPRA' 
			GROUP BY 
				r.seccion 
			ORDER BY 2 DESC LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data1 .= "['" . $row["terraza"] . " - Parcelas (" . intval($row["cantidad"]) . ")', " . intval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data1 = substr($out_data1, 0, strlen($out_data1)-1);
$titulo1 = "Disponibilidad $acumulador Parcelas en $cantidad Terrazas";
///////////////////////////////////////////////////////////////////


////////////////// Parcelas por Usuario que Compra ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				r.usuario_compra, u.nombre AS usuario, COUNT(r.usuario_compra) AS cantidad 
			FROM 
				sco_parcela_ventas AS r LEFT OUTER JOIN sco_user AS u ON u.username = r.usuario_compra 
			WHERE 
				r.$fechaSQL BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
				AND r.estatus <> 'ANULADO' 
			GROUP BY 
				r.usuario_compra, u.nombre) AS a";
$cantidad = ExecuteScalar($sql);

$out_data2 = "";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.usuario_compra, u.nombre AS usuario, COUNT(r.usuario_compra) AS cantidad  
			FROM 
				sco_parcela_ventas AS r LEFT OUTER JOIN sco_user AS u ON u.username = r.usuario_compra 
			WHERE 
				r.$fechaSQL BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
				AND r.estatus <> 'ANULADO' 
			GROUP BY 
				r.usuario_compra, u.nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data2 .= "['" . $row["usuario"] . " - Parcelas (" . intval($row["cantidad"]) . ")', " . intval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data2 = substr($out_data2, 0, strlen($out_data2)-1);
$titulo2 = "$acumulador Parcelas Compradas por Usuario que Compra";
///////////////////////////////////////////////////////////////////

////////////////// Parcelas por Usuario que Vende ///////////////////////
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
				r.usuario_vende, u.nombre AS usuario, COUNT(r.usuario_compra) AS cantidad 
			FROM 
				sco_parcela_ventas AS r LEFT OUTER JOIN sco_user AS u ON u.username = r.usuario_vende 
			WHERE 
				r.$fechaSQL BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
				AND r.estatus = 'VENTA' 
			GROUP BY 
				r.usuario_vende, u.nombre) AS a";
$cantidad = ExecuteScalar($sql);

$out_data3 = "";

$acumulador = 0;
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				r.usuario_vende, u.nombre AS usuario, COUNT(r.usuario_compra) AS cantidad  
			FROM 
				sco_parcela_ventas AS r LEFT OUTER JOIN sco_user AS u ON u.username = r.usuario_vende 
			WHERE 
				r.$fechaSQL BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'
				AND r.estatus = 'VENTA' 
			GROUP BY 
				r.usuario_vende, u.nombre LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$out_data3 .= "['" . $row["usuario"] . " - Parcelas (" . intval($row["cantidad"]) . ")', " . intval($row["cantidad"]) . "] ,";
	$acumulador += floatval($row["cantidad"]);
}
$out_data3 = substr($out_data3, 0, strlen($out_data3)-1);
$titulo3 = "$acumulador Parcelas Vendidas por Usuario";
///////////////////////////////////////////////////////////////////

?>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

	  // Load Charts and the corechart package.
	  google.charts.load('current', {'packages':['corechart']});

	  // Draw the pie chart for Estatus Compra /Venta.
	  google.charts.setOnLoadCallback(drawCompraVentaChart);

	  // Draw the pie chart for Terrarzas.
	  google.charts.setOnLoadCallback(drawTerrazasChart);

	  // Draw the pie chart for Terrarzas.
	  google.charts.setOnLoadCallback(drawUsuarioCompraChart);

	  // Draw the pie chart for Terrarzas.
	  google.charts.setOnLoadCallback(drawUsuarioVendeChart);

	  // Callback that draws the pie chart for Compra /Venta.
	  function drawCompraVentaChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Estatus');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo; ?>',
					   width:750,
					   height:500};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Estatus_div'));
		chart.draw(data, options);
	  }


	  // Callback that draws the pie chart for Compra /Venta.
	  function drawTerrazasChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Terraza');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data1; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo1; ?>',
					   width:750,
					   height:500};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('Terrazas_div'));
		chart.draw(data, options);
	  }

	  // Callback that draws the pie chart for Compra /Venta.
	  function drawUsuarioCompraChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Usuario');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data2; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo2; ?>',
					   width:750,
					   height:500};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('UsuarioCompra_div'));
		chart.draw(data, options);
	  }

	  // Callback that draws the pie chart for Compra /Venta.
	  function drawUsuarioVendeChart() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Usuario');
		data.addColumn('number', 'Cantidad');
		data.addRows([
		  <?php echo $out_data3; ?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'<?php echo $titulo3; ?>',
					   width:750,
					   height:500};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('UsuarioVende_div'));
		chart.draw(data, options);
	  }
	</script>

<div class="container">
	<h2>Indicadores desde el <?php echo $fec_des; ?> hasta el <?php echo $fec_has; ?></h2>
	<table class="columns">
	  <tr>
		<td>
			<div id="Estatus_div" style="border: 1px solid #ccc"></div>
			<div id="Terrazas_div" style="border: 1px solid #ccc"></div>
		</td>
	  </tr>
	  <tr>
		<td>
			<div id="UsuarioCompra_div" style="border: 1px solid #ccc"></div>
			<div id="UsuarioVende_div" style="border: 1px solid #ccc"></div>
		</td>
	  </tr>
	</table>
</div>

<?= GetDebugMessage() ?>
