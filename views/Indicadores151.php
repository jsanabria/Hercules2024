<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores151 = &$Page;
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

////////////////// (1) Unidades por Cantidad Siniestros ///////////////////////
$titulo = "Ventas de Parcelas Ultimos 6 meses";
$subtitulo = ""; // = "Desde el $fec_des Hasta el $fec_has";
$sql = "SELECT COUNT(a.cantidad) AS cantidad 
FROM 
	(SELECT 
	COUNT(Nparcela_ventas) AS cantidad, SUM(valor_venta) AS venta,  
	YEAR(fecha_venta) AS anho, MONTHNAME(fecha_venta) AS mes 
FROM 
	sco_parcela_ventas 
WHERE estatus = 'VENTA' 
GROUP BY YEAR(fecha_venta) DESC, MONTHNAME(fecha_venta) DESC LIMIT 0, 6) AS a";
$cantidad = ExecuteScalar($sql);
$out_data = "";
$out_data = "['$cantidad Meses', 'Monto Vendido', { role: 'annotation' }],";
$acumulador = 0;
$anho_mes = "";
for($i = 0; $i < $cantidad; $i++) {
	$sql = "SELECT 
				COUNT(Nparcela_ventas) AS cantidad, SUM(valor_venta) AS venta,  
				YEAR(fecha_venta) AS anho, MONTHNAME(fecha_venta) AS mes 
			FROM 
				sco_parcela_ventas 
			WHERE estatus = 'VENTA' 
			GROUP BY YEAR(fecha_venta), MONTHNAME(fecha_venta)
			ORDER BY YEAR(fecha_venta) DESC, MONTH(fecha_venta) DESC LIMIT $i, 1;";
	$row = ExecuteRow($sql);
	$cant = $row["venta"];
	$anho_mes = $row["anho"] . "-" . $row["mes"] . " (Parcelas " . $row["cantidad"] . " - " . number_format($cant, 2, ".", ",") . " Bs.)";
	$out_data .= "['$anho_mes', " . intval($cant) . ", '" . intval($cant) . "'] ,";
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
		  width: 900,
		  height:480,
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
			  distance: {label: '<?php echo number_format($acumulador, 2, ".", ","); ?> Bs.'}, // Bottom x-axis.
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
