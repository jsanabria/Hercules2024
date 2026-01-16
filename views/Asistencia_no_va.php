<?php

namespace PHPMaker2024\hercules;

// Page object
$Asistencia = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$Nexpediente = $_GET["Nexpediente"];
$Norden = isset($_GET["Norden"])?$_GET["Norden"]:0;
?>
<?php
$url = "dashboard/ContenedorServicios.php?Nexpediente=$Nexpediente&user=".CurrentUserName()."&Norden=$Norden";
?>
<iframe src="<?php echo $url; ?>"
	 width="100%" height="650" 
	 align="middle" frameborder="1" scrolling="yes" marginheight="0" marginwidth="0"
	 style="border:solid; border-width:thin; border-radius:5px 5px; border-color:#000000">


<?= GetDebugMessage() ?>
