<?php

namespace PHPMaker2024\hercules;

// Table
$sco_servicio = Container("sco_servicio");
$sco_servicio->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_servicio->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_serviciomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_servicio->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_servicio->tipo->rowAttributes() ?>>
            <td class="<?= $sco_servicio->TableLeftColumnClass ?>"><?= $sco_servicio->tipo->caption() ?></td>
            <td<?= $sco_servicio->tipo->cellAttributes() ?>>
<span id="el_sco_servicio_tipo">
<span<?= $sco_servicio->tipo->viewAttributes() ?>>
<?= $sco_servicio->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_servicio->Nservicio->Visible) { // Nservicio ?>
        <tr id="r_Nservicio"<?= $sco_servicio->Nservicio->rowAttributes() ?>>
            <td class="<?= $sco_servicio->TableLeftColumnClass ?>"><?= $sco_servicio->Nservicio->caption() ?></td>
            <td<?= $sco_servicio->Nservicio->cellAttributes() ?>>
<span id="el_sco_servicio_Nservicio">
<span<?= $sco_servicio->Nservicio->viewAttributes() ?>>
<?= $sco_servicio->Nservicio->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_servicio->nombre->Visible) { // nombre ?>
        <tr id="r_nombre"<?= $sco_servicio->nombre->rowAttributes() ?>>
            <td class="<?= $sco_servicio->TableLeftColumnClass ?>"><?= $sco_servicio->nombre->caption() ?></td>
            <td<?= $sco_servicio->nombre->cellAttributes() ?>>
<span id="el_sco_servicio_nombre">
<span<?= $sco_servicio->nombre->viewAttributes() ?>>
<?= $sco_servicio->nombre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_servicio->activo->Visible) { // activo ?>
        <tr id="r_activo"<?= $sco_servicio->activo->rowAttributes() ?>>
            <td class="<?= $sco_servicio->TableLeftColumnClass ?>"><?= $sco_servicio->activo->caption() ?></td>
            <td<?= $sco_servicio->activo->cellAttributes() ?>>
<span id="el_sco_servicio_activo">
<span<?= $sco_servicio->activo->viewAttributes() ?>>
<?= $sco_servicio->activo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
