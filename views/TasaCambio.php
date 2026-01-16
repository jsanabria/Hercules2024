<?php

namespace PHPMaker2024\hercules;

// Page object
$TasaCambio = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$sql = "SELECT valor1 FROM sco_parametro WHERE codigo = '050';";
$tasa = floatval(ExecuteScalar($sql));
?>
<form name="frm" method="post" action="tasa_cambio_guardar.php">
  <div class="form-group">
	<label for="tasa">Tasa de Cambio Actual:</label>
	<input type="number" class="form-control" id="tasa" name="tasa" value="<?php echo $tasa; ?>">
  </div>
  <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

<?= GetDebugMessage() ?>
