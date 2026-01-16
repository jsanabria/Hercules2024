<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores102 = &$Page;
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


////////////////// (2) Fallas ///////////////////////
$titulo = "Fallas en el Periodo";
$subtitulo = "Desde el $fec_des Hasta el $fec_has";
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
$out_data = "";
$out_data = "['$cantidad Fallas', 'Cantidad de Fallas', { role: 'annotation' }],";
$acumulador = 0;
$unidad = "";
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
	$out_data .= "['$falla', " . intval($cant) . ", '" . intval($cant) . "'] ,";
	$acumulador += floatval($cant);
}
$out_data = substr($out_data, 0, strlen($out_data)-1);
//die($out_data);
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
		  height: 600,
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
			  distance: {label: '<?php echo $acumulador; ?> Siniestros'}, // Bottom x-axis.
			  brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
			}
		  }
		};
	  	var chart = new google.charts.Bar(document.getElementById('xGrafico'));
		chart.draw(data, options);
	  };

	</script>

	<div id="xGrafico"></div>

<?= GetDebugMessage() ?>
