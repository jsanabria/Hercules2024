<?php

namespace PHPMaker2024\hercules;

// Page object
$Disponibilidad = &$Page;
?>
<?php
$Page->showMessage();
?>
<iframe
	src="dashboard/DisponibilidadCapillas.php?username=<?= CurrentUserName() ?>"
	width="100%" height="650" align="middle" scrolling="yes"
	marginheight="0" marginwidth="0"
	style="border:solid; border-width:thin; border-radius:5px 5px; border-color:#000000; overflow:scroll;">
</iframe>


<?= GetDebugMessage() ?>
