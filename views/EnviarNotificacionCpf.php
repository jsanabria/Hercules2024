<?php

namespace PHPMaker2024\hercules;

// Page object
$EnviarNotificacionCpf = &$Page;
?>
<?php
$Page->showMessage();
?>
<div class="container">
  <h2>Enviar Notificaci&oacute;n CPF</h2>

	<?php
		if (isset($_SESSION['message']) && $_SESSION['message']) {
			echo '<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Muy bien!</strong> ' . $_SESSION['message'] . '
					</div>';
			//printf('<b>%s</b>', $_SESSION['message']);
			unset($_SESSION['message']);
		}
	?>
	<?php
		if (isset($_SESSION['error']) && $_SESSION['error']) {
			echo '<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Error!</strong> ' . $_SESSION['error'] . '
					</div>';
			// printf('<b>%s</b>', $_SESSION['error']);
			unset($_SESSION['error']);
		}
	?>

  <form class="form-horizontal" method="post" action="enviar_notificacion_guardar_cpf.php">
	<div class="form-group">
	  <label class="control-label col-sm-2" for="pwd">N&uacute;mero Expediente:</label>
	  <div class="col-sm-10">          
		<input type="number" class="form-control" id="expediente" name="expediente" placeholder="N&uacute;mero de Expediente">
	  </div>
	</div>
	<div class="form-group">
	  <label class="control-label col-sm-2" for="email">Email:</label>
	  <div class="col-sm-10">
		<input type="email" class="form-control" id="email" name="email" placeholder="Coloque email">
		<input type="hidden" id="username" name="username" value="<?php echo CurrentUserName(); ?>">
	  </div>
	</div>
	<div class="form-group">        
	  <div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-default">Enviar</button>
	  </div>
	</div>
  </form>
</div>

<?= GetDebugMessage() ?>
