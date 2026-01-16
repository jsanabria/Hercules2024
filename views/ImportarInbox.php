<?php

namespace PHPMaker2024\hercules;

// Page object
$ImportarInbox = &$Page;
?>
<?php
$Page->showMessage();
?>
<h2>Importar sms a Bandeja de Entrada</h2>
<?php
if(isset($_REQUEST["error"])) {
	if($_REQUEST["error"]=="NO") {
		?>
		<div class="alert alert-success" role="alert">
		  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		  <span class="sr-only">Exito:</span>
		  Proceso de Cargar de Archivo Exitoso
		</div>
		<?php
	}
	else {
		?>
		<div class="alert alert-danger" role="alert">
		  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		  <span class="sr-only">Error:</span>
		  Error en el Proceso de Carga de Archivo: <?php echo $_REQUEST["error"]; ?>
		</div>
		<?php
	}
}
?>
<div class="container">
  <form class="form-horizontal" action="importar_inbox_guardar.php" enctype="multipart/form-data" method="post">
	<div class="form-group">
	  <label class="control-label col-sm-2" for="Seleccione Archivo .txt:">Seleccione Archivo .txt:</label>
	  <div class="col-sm-4">
		<input type="file" class="form-control" name="myfile" placeholder="Archivo .txt">
	  </div>
	  <div class="col-sm-6">
		<a class="btn btn-info" href="../carpetacarga/Estructura de inbox.pdf" target="_blank" id="verDoc"><span class="glyphicon glyphicon-search"></span> Ver Estructura Requerida</a>
	  </div>
	</div>
	<div class="form-group"> 
	  <div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-primary">Enviar</button>
	  </div>
	</div>
  </form>
</div>


<?= GetDebugMessage() ?>
