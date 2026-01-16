<?php

namespace PHPMaker2024\hercules;

// Page object
$EstableceCantidadServicios = &$Page;
?>
<?php
$Page->showMessage();
?>
<h2>Establecer Cantidad de Servicios de Cremaci&oacute;n e Inhumaci&oacute;n por Bloque Horarios</h2>
<?php
if(isset($_REQUEST["error"])) {
	if($_REQUEST["error"]=="NO") {
		?>
		<div class="alert alert-success" role="alert">
		  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		  <span class="sr-only">Exito:</span>
		  Actualizaci&oacute;n de Cantidad de Servicios Exitoso
		</div>
		<?php
	}
	else {
		?>
		<div class="alert alert-danger" role="alert">
		  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		  <span class="sr-only">Error:</span>
		  Error en los datos de actualizaci&oacute;n: <?php echo $_REQUEST["error"]; ?>
		</div>
		<?php
	}
}

$sql = "Select 
			valor1 AS cremacion, valor2 as cant_crem,
			valor3 AS sepelio, valor4 as cant_sepe 
		FROM sco_parametro WHERE codigo = '019';";
$row = ExecuteRow($sql);
$cremaciones = $row["cant_crem"];
$sepelios = $row["cant_sepe"];

$sql = "Select 
			valor1 AS cantidad 
		FROM sco_parametro WHERE codigo = '051';";
$cremaciones_maximas = intval(ExecuteScalar($sql));
?>
<div class="container">
  <form class="form-horizontal" method='post' action="establece_cantidad_servicios_guardar.php">
	<div class="form-group">
	  <label class="control-label col-sm-3" for="cremaciones">Cantidad de Cremaciones:</label>
	  <div class="col-sm-5">
		<input type="number" class="form-control" id="cremaciones" name="cremaciones" placeholder="" value="<?php echo $cremaciones; ?>">
	  </div>
	</div>
	<div class="form-group">
	  <label class="control-label col-sm-3" for="sepelios">Cantidad de Sepelios:</label>
	  <div class="col-sm-5">
		<input type="number" class="form-control" id="sepelios" name="sepelios" placeholder="" value="<?php echo $sepelios; ?>">
	  </div>
	</div>
	<div class="form-group">
	  <label class="control-label col-sm-3" for="sepelios">Cantidad M&aacute;xima de Cremaciones Diarias :</label>
	  <div class="col-sm-5">
		<input type="number" class="form-control" id="cremaciones_maximas" name="cremaciones_maximas" placeholder="" value="<?php echo $cremaciones_maximas; ?>">
	  </div>
	</div>
	<div class="form-group"> 
	  <div class="col-sm-offset-3 col-sm-10">
		<button type="submit" class="btn btn-primary">Enviar</button>
		<input type="hidden" class="form-control" id="username" name="username" value="<?php echo CurrentUserName(); ?>">
	  </div>
	</div>
  </form>
</div>

<?= GetDebugMessage() ?>
