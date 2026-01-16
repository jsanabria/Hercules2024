<?php

namespace PHPMaker2024\hercules;

// Page object
$Indicadores20 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
$fecha_desde = trim($_REQUEST["fecha_desde"]);
$fecha_hasta = trim($_REQUEST["fecha_hasta"]);
?>
<div class="table-responsive">
<table border="0" width="100%">
	<tr><td>
		<div id="top_x_div1" class="col-lg-12" style="width: 1200px; height: 600px;">
			<iframe
				src="indicadores_201.php?fecha_desde=<?php echo $fecha_desde; ?>&fecha_hasta=<?php echo $fecha_hasta; ?>"
				width="100%" height="600"  align="middle" scrolling="yes" 
				marginheight="0" marginwidth="0"
				style="border:solid; border-width:thin; border-radius:5px 5px; border-color:#000000; overflow:scroll;">
			</iframe>
		</div>
	</td></tr>
	<tr><td>
		<div id="top_x_div2" class="col-lg-12" style="width: 1200px; height: 600px;">
			<iframe
				src="indicadores_202.php?fecha_desde=<?php echo $fecha_desde; ?>&fecha_hasta=<?php echo $fecha_hasta; ?>"
				width="100%" height="600" align="middle" scrolling="yes" 
				marginheight="0" marginwidth="0"
				style="border:solid; border-width:thin; border-radius:5px 5px; border-color:#000000; overflow:scroll;">
			</iframe>
		</div>
	</td></tr>
</table>
</div>

<?= GetDebugMessage() ?>
