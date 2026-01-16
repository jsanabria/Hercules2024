<?php

namespace PHPMaker2024\hercules;

// Page object
$Tarifario = &$Page;
?>
<?php
$Page->showMessage();
?>
<h2>Tarifario</h2>
<div class="row">
	<div class="col-sm-9">
		<div class="list-group">
		  <a href="#" class="list-group-item active">
		  	Haga click en el lapiz para editar la tarifa
		  </a>
		  <div class="table-responsive">
		  	<table class="table table-bordered">
		  	    <thead>
			      <tr>
	  		        <th>CAPILLA</th>
			        <th>SERVICIO</th>
			        <th>TIEMPO</th>
			        <th align="right">MONTO</th>
			        <th align="center"></th>
			        <th align="center"></th>
			      </tr>
	  		    </thead>
			    <tbody>
			    <?php
			    $sql = "SELECT valor1 as iva FROM sco_parametro WHERE codigo = '002';";
			    $iva = ExecuteScalar($sql);
			    
			    $_SESSION["viene_tarifario"] = "S";
			    $sql = "SELECT 
							COUNT(localidad) AS cantidad 
						FROM 
							sco_costos_tarifa t 
							JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
							JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
							JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
						WHERE 
							t.activo = 'S' AND d.cerrado = 'N' 
						ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, t.horas;";
				$cantidad = ExecuteScalar($sql);

				$table = '';
				$ctrl1 = 1;
				$ctrl2 = 1;
				$ct = 0;
				$local = "";
				for($i=0; $i<$cantidad; $i++) {
				    $sql = "SELECT 
								(SELECT COUNT(localidad) 
								FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
								WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad) AS localidad, 
								c.nombre AS capilla, 
								(SELECT COUNT(tipo_servicio) 
								FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
								WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad AND tipo_servicio = t.tipo_servicio) AS tipo_servicio, 
								s.nombre AS servicio, 
								t.horas, 
								d.base, 
								d.Ncostos_tarifa_detalle, date_format(d.fecha, '%d/%m/%Y') AS fecha, t.Ncostos_tarifa,
								LPAD(SUBSTRING(t.horas, 1, POSITION(' ' IN t.horas)-1), 2, '0') as hr, 
								d.Ncostos_tarifa_detalle  
							FROM 
								sco_costos_tarifa t 
								JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
								JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
								JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
							WHERE 
								t.activo = 'S' AND d.cerrado = 'N' 
							ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, hr
							LIMIT $i, 1;";
					$row = ExecuteRow($sql);
					
					if($row["localidad"]!=$local) {
						$local = $row["localidad"];
						$ctrl1 = 1;
						$ctrl2 = 1;
					}
					$table .= '<tr>';
						for($j=0; $j<6; $j++) {
							switch ($j) {
							case 0:
								if($ctrl1<=$row["localidad"]) {
									if($row["localidad"]==1)
										$table .= '<td>' . $row["capilla"] . '</td>';
									else {
										if($ctrl1==1) {
											$table .= '<td rowspan="' . $row["localidad"] . '">' . $row["capilla"] . '</td>';		
										}
									}
									$ctrl1++;
								}
								else {
									$ctrl1 = 1;
									$ctrl2 = 1;
									$i--;
									$j=5;
								}
								break;
							case 1:
								if($ctrl2<$row["tipo_servicio"]) {
									if($row["tipo_servicio"]==1)
										$table .= '<td>' . $row["servicio"] . '</td>';
									else {
										if($ctrl2==1) {
											$table .= '<td rowspan="' . $row["tipo_servicio"] . '">' . $row["servicio"] . '</td>';		
										}
									}
									$ctrl2++;
								}
								else {
									if($ctrl2==1) {
										$table .= '<td>' . $row["servicio"] . '</td>';
										if($row["localidad"]==1) $ctrl1 = 1;
									}
									$ctrl2 = 1;
									//$i--;
									//$j=5;
								}
								break;
							case 2:
								$table .= '<td>' . $row["horas"] . '</td>';
								break;
							case 3:
								$precio_mas_iva = "Precio con IVA: Bs. " . number_format(($row["base"] + ($row["base"]*($iva/100))), 2, ",", ".");
								$table .= '<td align="right"><a onclick="js:alert(\'' . $precio_mas_iva . '\')">Bs. ' . number_format($row["base"], 2, ",", ".") . '</a></td>';
								break;
							case 4:
								$table .= '<td align="center"><a href="../sco_costos_tarifa_detalleedit.php?showmaster=sco_costos_tarifa&fk_Ncostos_tarifa=' . trim($row["Ncostos_tarifa"]) . '&Ncostos_tarifa_detalle=' . trim($row["Ncostos_tarifa_detalle"]) . '"><span class="glyphicon glyphicon-pencil"></span></a></td>';
								break;
							case 5:
								$sql = "select 
											((select precio from sco_costos_articulos where Ncostos_articulo = p.cap) + 
											(select precio from sco_costos_articulos where Ncostos_articulo = p.ata) + 
											(select precio from sco_costos_articulos where Ncostos_articulo = p.obi) + 
											(select precio from sco_costos_articulos where Ncostos_articulo = p.fot) + 
											(select precio from sco_costos_articulos where Ncostos_articulo = p.man) + 
											(select precio from sco_costos_articulos where Ncostos_articulo = p.gas) + 
											(select precio from sco_costos_articulos where Ncostos_articulo = p.com)) as precio, 
											p.base  
										from sco_costos_tarifa_detalle as p where p.Ncostos_tarifa_detalle = '" . $row["Ncostos_tarifa_detalle"] . "';";
								$row2 = ExecuteRow($sql);
								$precio = number_format($row2["precio"], 2, ",", ".");
								$base = number_format($row2["base"], 2, ",", ".");
								if($base == $precio) { 
									$table .= '<td align="center"><div class="alert alert-success" role="alert"><a onClick="js:alert(\'Precio de Venta Actualizado.\');" class="alert-link"><span class="glyphicon glyphicon-ok"></span></a></div></td>';
								}
								else {
									$table .= '<td align="center"><div class="alert alert-danger" role="alert"><a onClick="js:alert(\'Alerta!!! Precio de Venta Desactualizado. Precio Actual: ' . $base . ' -- Sugerido por la Estructura de costos: ' . $precio . '. Cierre la tarifa actual. \');" class="alert-link"><span class="glyphicon glyphicon-bell"></span></a></div></td>';
								}
								break;
							}
						}
					$table .= '</tr>';
				}

				echo $table;
			    ?>
	  		    </tbody>
		  	</table>
		  </div>
		</div>
	</div>
	<div class="col-sm-3"><button type="button" class="btn btn-primary" id="my_print" name="my_print"><span class="glyphicon glyphicon-print"></span> Imprimir</button></div>
</div>

<script>
$("#my_print").click(function(){
	window.open("../fpdf_report/tarifa.php");
});
</script>


<?= GetDebugMessage() ?>
