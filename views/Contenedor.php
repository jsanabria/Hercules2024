<?php

namespace PHPMaker2024\hercules;

// Page object
$Contenedor = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$Nexpediente = floatval($_GET["Nexpediente"] ?? 0);
$Norden = floatval($_GET["Norden"] ?? 0);
$username = CurrentUserName();

if($Nexpediente != 0) {
    header("Location: dashboard/servicios/app.php?exp=$Nexpediente&username=$username");
} 
else {
    echo '<div class="alert alert-danger" role="alert">
      <strong>Error!!!</strong> Debe seleccionar un expediente.
    </div>';
}
?>

<?= GetDebugMessage() ?>
