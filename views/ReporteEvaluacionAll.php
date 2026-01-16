<?php

namespace PHPMaker2024\hercules;

// Page object
$ReporteEvaluacionAll = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$fecha_desde = isset($_REQUEST["fecha_desde"]) ? $_REQUEST["fecha_desde"] : date("Y-m-d");
$fecha_hasta = isset($_REQUEST["fecha_hasta"]) ? $_REQUEST["fecha_hasta"] : date("Y-m-d");
?>
<div class="container">
	<hr>
	<h2>Reporte de Evaluaci&oacute;n</h2>
	<div class="row">
		<div class="col-sm-9">
			<form name="frm" method="get" action="reporte_evaluacion_all.php" class="form-inline">
				<h4>Desde: 
					<input name="fecha_desde" type="date" class="form-control" value="<?php echo $fecha_desde; ?>"> 
					Hasta: 
					<input name="fecha_hasta" type="date" class="form-control" value="<?php echo $fecha_hasta; ?>"> 
					<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</h4>
			</form>
		</div>
	</div>
	<hr>
	<h2>HERCULES</h2>
	<div class="row">
		<div class="col-sm-9">
		  <table class="table table-condensed table-stripped table-hover">
			<thead>
			  <tr>
				<th>#</th>
				<th>USUARIO</th>
				<th>SERVICIOS</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT
			  		d.nombre AS usuario,
					  COUNT(a.Norden) AS cantidad 
					FROM 
					  sco_orden AS a 
					  LEFT OUTER JOIN sco_servicio_tipo AS b ON b.Nservicio_tipo = a.servicio_tipo 
					  LEFT OUTER JOIN sco_servicio AS c ON c.Nservicio = a.servicio 
					  LEFT OUTER JOIN sco_user AS d ON d.username = a.user_registra 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'  
					  AND d.evaluacion = 'S' 
					GROUP BY a.user_registra) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT
					a.user_registra, 
					d.nombre AS usuario, 
					  COUNT(a.Norden) AS cantidad 
					FROM 
					  sco_orden AS a 
					  LEFT OUTER JOIN sco_servicio_tipo AS b ON b.Nservicio_tipo = a.servicio_tipo 
					  LEFT OUTER JOIN sco_servicio AS c ON c.Nservicio = a.servicio 
					  LEFT OUTER JOIN sco_user AS d ON d.username = a.user_registra 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59'  
					  AND d.evaluacion = 'S' 
					GROUP BY a.user_registra 
					ORDER BY cantidad DESC LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . ($i + 1) . '</td>';
				echo '<td><a href="reporte_evaluacion.php?username=' . $row["user_registra"] . '&fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '">' . $row["usuario"] . '</a></td>';
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
			  }
			  ?>
			  </tr>
			</tbody>
		  </table>			
		</div>
	</div>
	<hr>
	<h2>CEMANTICK</h2>
	<div class="row">
		<div class="col-sm-9">
		  <table class="table table-condensed table-stripped table-hover">
			<thead>
			  <tr>
				<th>#</th>
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  a.username,
					  d.nombre  AS usuario,
					  COUNT(a.Nticket) AS cantidad 
					FROM 
						cemantick_ticket AS a 
						LEFT OUTER JOIN cemantick_tipo_solicitud AS b ON b.Ntipo_solicitud = a.tipo_solicitud
						LEFT OUTER JOIN sco_user AS d ON d.username = a.username 
					WHERE 
					  a.fecha_pesca BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND d.evaluacion = 'S' 
					GROUP BY a.username) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  a.username,
					  d.nombre  AS usuario,
					  COUNT(a.Nticket) AS cantidad 
					FROM 
						cemantick_ticket AS a 
						LEFT OUTER JOIN cemantick_tipo_solicitud AS b ON b.Ntipo_solicitud = a.tipo_solicitud
						LEFT OUTER JOIN sco_user AS d ON d.username = a.username 
					WHERE 
					  a.fecha_pesca BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND d.evaluacion = 'S' 
					GROUP BY a.username ORDER BY cantidad DESC LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . ($i + 1) . '</td>';
				echo '<td><a href="reporte_evaluacion.php?username=' . $row["username"] . '&fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '">' . $row["usuario"] . '</a></td>'; 
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
			  }
			  ?>
			</tbody>
		  </table>			
		</div>
	</div>

	<hr>
	<h2>PARCELAS</h2>
	<div class="row">
		<div class="col-sm-9">
		  <table class="table table-condensed table-stripped table-hover">
			<thead>
			  <tr>
				<th>#</th>
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  a.usuario_vende AS username,
					  b.nombre  AS usuario,
					  COUNT(a.Nparcela_ventas) AS cantidad 
					FROM 
						sco_parcela_ventas AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.usuario_vende 
					WHERE 
					  a.fecha_venta BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.estatus = 'VENTA' 
					GROUP BY a.usuario_vende) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  a.usuario_vende AS username,
					  b.nombre  AS usuario,
					  COUNT(a.Nparcela_ventas) AS cantidad 
					FROM 
						sco_parcela_ventas AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.usuario_vende 
					WHERE 
					  a.fecha_venta BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.estatus = 'VENTA' 
					GROUP BY a.usuario_vende ORDER BY cantidad DESC LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . ($i + 1) . '</td>';
				echo '<td><a href="reporte_evaluacion.php?username=' . $row["username"] . '&fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '">' . $row["usuario"] . '</a></td>'; 
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
			  }
			  ?>
			</tbody>
		  </table>			
		</div>
	</div>

	<hr>
	<h2>EXPEDIENTES APERTURADOS</h2>
	<div class="row">
		<div class="col-sm-9">
		  <table class="table table-condensed table-stripped table-hover">
			<thead>
			  <tr>
				<th>#</th>
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  a.user_registra AS username,
					  b.nombre  AS usuario,
					  COUNT(a.Nexpediente) AS cantidad 
					FROM 
						sco_expediente AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.user_registra 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					GROUP BY a.user_registra) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  a.user_registra AS username,
					  b.nombre  AS usuario,
					  COUNT(a.Nexpediente) AS cantidad 
					FROM 
						sco_expediente AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.user_registra 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					GROUP BY a.user_registra ORDER BY cantidad DESC LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . ($i + 1) . '</td>';
				echo '<td><a href="reporte_evaluacion.php?username=' . $row["username"] . '&fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '">' . $row["usuario"] . '</a></td>'; 
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
			  }
			  ?>
			</tbody>
		  </table>			
		</div>
	</div>

	<hr>
	<h2>FACTURAS GENERADAS</h2>
	<div class="row">
		<div class="col-sm-9">
		  <table class="table table-condensed table-stripped table-hover">
			<thead>
			  <tr>
				<th>#</th>
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
				<th>MONTO</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  a.username AS username,
					  b.nombre  AS usuario,
					  COUNT(a.Nexpediente_cia) AS cantidad, 
					  SUM(a.monto) AS monto 
					FROM 
						sco_expediente_cia AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.username  
					WHERE 
						a.fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					GROUP BY a.username) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  a.username AS username,
					  b.nombre  AS usuario,
					  COUNT(a.Nexpediente_cia) AS cantidad, 
					  SUM(a.monto) AS monto 
					FROM 
						sco_expediente_cia AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.username  
					WHERE 
						a.fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					GROUP BY a.username ORDER BY cantidad DESC LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . ($i + 1) . '</td>';
				echo '<td><a href="reporte_evaluacion.php?username=' . $row["username"] . '&fecha_desde=' . $fecha_desde . '&fecha_hasta=' . $fecha_hasta . '">' . $row["usuario"] . '</a></td>'; 
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '<td>' . number_format($row["monto"], 2, ".", ",") . '</td>';
				echo '</tr>';
			  }
			  ?>
			</tbody>
		  </table>			
		</div>
	</div>
</div>

<?= GetDebugMessage() ?>
