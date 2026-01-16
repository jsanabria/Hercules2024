<?php

namespace PHPMaker2024\hercules;

// Page object
$ReporteEvaluacion = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$username = $_REQUEST["username"];
$fecha_desde = isset($_REQUEST["fecha_desde"]) ? $_REQUEST["fecha_desde"] : date("Y-m-d");
$fecha_hasta = isset($_REQUEST["fecha_hasta"]) ? $_REQUEST["fecha_hasta"] : date("Y-m-d");
$sql = "SELECT nombre, cargo, foto FROM sco_user WHERE username = '$username';";
$row = ExecuteRow($sql);
$nombre = $row["nombre"];
$cargo = $row["cargo"];
$foto = $row["foto"];
if(!file_exists("../carpetacarga/$foto")) $foto = "silueta.jpg";
$arfec = explode("-", $fecha_desde);
$df = $arfec[2] . "/" . $arfec[1] . "/" . $arfec[0];
$arfec = explode("-", $fecha_hasta);
$dh = $arfec[2] . "/" . $arfec[1] . "/" . $arfec[0];
?>
<div class="container">
	<hr>
	<h2>Reporte de Evaluaci&oacute;n</h2>
	<div class="row">
		<div class="col-sm-3">
			<img src="../carpetacarga/<?php echo $foto; ?>" class="img-thumbnail" alt="Cinque Terre" width="120">
		</div>
		<div class="col-sm-9">
			<form name="frm" method="get" action="reporte_evaluacion.php" class="form-inline">
				<h3><?php echo "Nombre: $nombre - UserName = $username"; ?></h3>
				<h3><?php echo "Cargo: $cargo"; ?></h3>
				<h4>Desde: 
					<input name="fecha_desde" type="date" class="form-control" value="<?php echo $fecha_desde; ?>"> 
					Hasta: 
					<input name="fecha_hasta" type="date" class="form-control" value="<?php echo $fecha_hasta; ?>"> 
					<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
					<input name="username" type="hidden" class="form-control" value="<?php echo $username; ?>"> 
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
				<th>CATEGORIA</th>
				<th>TIPO</th>
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  CASE a.paso 
					  WHEN 1 THEN 'ASIGNACION DE CAPILLA'  
					  WHEN 2 THEN 'SEPELIO / CREMACION' 
					  WHEN 3 THEN 'ATAUD / COFRE' 
					  WHEN 4 THEN 'ARREGLOS FLORALES' 
					  WHEN 5 THEN 'OFRE. VOZ / OFIC. RELIGIOSO' 
					  ELSE 'OTRO' END AS categoria, 
					  b.nombre AS tipo,
					  IF(a.paso=1, b.nombre, c.nombre) AS servicio,
					  COUNT(a.Norden) AS cantidad 
					FROM 
					  sco_orden AS a 
					  LEFT OUTER JOIN sco_servicio_tipo AS b ON b.Nservicio_tipo = a.servicio_tipo 
					  LEFT OUTER JOIN sco_servicio AS c ON c.Nservicio = a.servicio 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' AND 
					  a.user_registra = '$username' 
					GROUP BY a.paso, b.nombre, IF(a.paso=1, b.nombre, c.nombre)) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  $ctg = "";
			  $ctd = 0;
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  CASE a.paso 
					  WHEN 1 THEN 'ASIGNACION DE CAPILLA'  
					  WHEN 2 THEN 'SEPELIO / CREMACION' 
					  WHEN 3 THEN 'ATAUD / COFRE' 
					  WHEN 4 THEN 'ARREGLOS FLORALES' 
					  WHEN 5 THEN 'OFRE. VOZ / OFIC. RELIGIOSO' 
					  ELSE 'OTRO' END AS categoria, 
					  b.nombre AS tipo,
					  IF(a.paso=1, b.nombre, c.nombre) AS servicio,
					  COUNT(a.Norden) AS cantidad 
					FROM 
					  sco_orden AS a 
					  LEFT OUTER JOIN sco_servicio_tipo AS b ON b.Nservicio_tipo = a.servicio_tipo 
					  LEFT OUTER JOIN sco_servicio AS c ON c.Nservicio = a.servicio 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' AND 
					  a.user_registra = '$username' 
					GROUP BY a.paso, b.nombre, IF(a.paso=1, b.nombre, c.nombre)
					ORDER BY a.paso LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				if($ctg != $row["categoria"]) {
					echo '<td>' . $row["categoria"] . '</td>';
					$ctg = $row["categoria"];
				}
				else
					echo '<td></td>';
				echo '<td>' . $row["tipo"] . '</td>';
				echo '<td>' . $row["servicio"] . '</td>';
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
				$ctd += $row["cantidad"];
			  }
			  ?>
			  <tr>
			  	<td colspan="4">
			  		<strong><?php echo "$ctd SERVICIO(S) en $cantidad CATEGORIAS"; ?></strong>
			  	</td>
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
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  b.nombre_tipo_solicitud, COUNT(a.Nticket) AS cantidad 
					FROM 
						cemantick_ticket AS a 
						LEFT OUTER JOIN cemantick_tipo_solicitud AS b ON b.Ntipo_solicitud = a.tipo_solicitud 
					WHERE 
					  a.fecha_pesca BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' AND 
					  a.username = '$username' 
					GROUP BY b.nombre_tipo_solicitud) AS a;";
			  $cantidad = ExecuteScalar($sql);
			  $ctg = "";
			  $ctd = 0;
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  b.nombre_tipo_solicitud, COUNT(a.Nticket) AS cantidad 
					FROM 
						cemantick_ticket AS a 
						LEFT OUTER JOIN cemantick_tipo_solicitud AS b ON b.Ntipo_solicitud = a.tipo_solicitud 
					WHERE 
					  a.fecha_pesca BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' AND 
					  a.username = '$username' 
					GROUP BY b.nombre_tipo_solicitud LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . $row["nombre_tipo_solicitud"] . '</td>';
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
				$ctd += $row["cantidad"];
			  }
			  ?>
			  <tr>
			  	<td colspan="2">
			  		<strong><?php echo "$ctd SERVICIO(S) en $cantidad CATEGORIAS"; ?></strong>
			  	</td>
			  </tr>
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
				<th>COMPRADOR</th>
				<th>PARCELA</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT 
					  COUNT(a.id_parcela) AS cantidad 
					FROM 
						sco_parcela_ventas AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.usuario_vende 
					WHERE 
					  a.fecha_venta BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.estatus = 'VENTA' 
					  AND a.usuario_vende = '$username';";
			  $cantidad = ExecuteScalar($sql);
			  $ctg = "";
			  $ctd = 0;
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  a.comprador, 
					  a.id_parcela
					FROM 
						sco_parcela_ventas AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.usuario_vende 
					WHERE 
					  a.fecha_venta BETWEEN '$fecha_desde' AND '$fecha_hasta' 
					  AND a.estatus = 'VENTA' 
					  AND a.usuario_vende = '$username' 
					ORDER BY a.fecha_venta DESC LIMIT $i, 1;";
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . $row["comprador"] . '</td>';
				echo '<td>' . $row["id_parcela"] . '</td>';
				echo '</tr>';
				$ctd ++;
			  }
			  ?>
			  <tr>
			  	<td colspan="2">
			  		<strong><?php echo "$ctd PARCELA(S)"; ?></strong>
			  	</td>
			  </tr>
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
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  a.servicio, 
					  COUNT(a.Nexpediente) AS cantidad
					FROM 
						sco_expediente AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.user_registra 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.user_registra = '$username' 
					GROUP BY a.servicio) AS a;"; 
			  $cantidad = ExecuteScalar($sql);
			  $ctg = "";
			  $ctd = 0;
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  (SELECT nombre FROM sco_servicio WHERE Nservicio = a.servicio) AS servicio, 
					  COUNT(a.Nexpediente) AS cantidad
					FROM 
						sco_expediente AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.user_registra 
					WHERE 
					  a.fecha_registro BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.user_registra = '$username' 
					GROUP BY a.servicio ORDER BY cantidad DESC LIMIT $i, 1;"; 
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . $row["servicio"] . '</td>';
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '</tr>';
				$ctd += $row["cantidad"];
			  }
			  ?>
			  <tr>
			  	<td colspan="2">
			  		<strong><?php echo "$ctd SERVICIO(S) en $cantidad CATEGORIAS"; ?></strong>
			  	</td>
			  </tr>
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
				<th>SERVICIO</th>
				<th>CANTIDAD</th>
				<th>MONTO</th>
			  </tr>
			</thead>
			<tbody>
			  <?php
			  $sql = "SELECT COUNT(*) AS cantidad FROM
			  		(SELECT 
					  (SELECT nombre FROM sco_servicio_tipo WHERE Nservicio_tipo = a.servicio_tipo) AS servicio, 
					  COUNT(a.Nexpediente_cia) AS cantidad, 
					  SUM(a.monto) AS monto 
					FROM 
						sco_expediente_cia AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.username  
					WHERE 
						a.fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.username = '$username' 
					GROUP BY a.servicio_tipo) AS a;"; 
			  $cantidad = ExecuteScalar($sql);
			  $ctg = "";
			  $ctd = 0;
			  $mont = 0;
			  for($i=0; $i<$cantidad; $i++) {
				$sql = "SELECT 
					  (SELECT nombre FROM sco_servicio_tipo WHERE Nservicio_tipo = a.servicio_tipo) AS servicio, 
					  COUNT(a.Nexpediente_cia) AS cantidad, 
					  SUM(a.monto) AS monto 
					FROM 
						sco_expediente_cia AS a 
						LEFT OUTER JOIN sco_user AS b ON b.username = a.username  
					WHERE 
						a.fecha BETWEEN '$fecha_desde 00:00:00' AND '$fecha_hasta 23:59:59' 
					  AND a.username = '$username' 
					GROUP BY a.servicio_tipo ORDER BY cantidad DESC LIMIT $i, 1;"; 
				$row = ExecuteRow($sql);
				echo '<tr>';
				echo '<td>' . $row["servicio"] . '</td>';
				echo '<td>' . $row["cantidad"] . '</td>';
				echo '<td>' . number_format($row["monto"], 2, ".", ",") . '</td>';
				echo '</tr>';
				$ctd += $row["cantidad"];
				$mont += $row["monto"];
			  }
			  ?>
			  <tr>
			  	<td colspan="3">
			  		<strong><?php echo "$ctd SERVICIO(S) en $cantidad SERVICIOS - MONTO TOTAL " . number_format($mont, 2, ".", ",") . " Bs"; ?></strong>
			  	</td>
			  </tr>
			</tbody>
		  </table>			
		</div>
	</div>
</div>

<?= GetDebugMessage() ?>
