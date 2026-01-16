<?php

namespace PHPMaker2024\hercules;

// Table
$sco_servicio_tipo = Container("sco_servicio_tipo");
$sco_servicio_tipo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_servicio_tipo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_servicio_tipomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_servicio_tipo->Nservicio_tipo->Visible) { // Nservicio_tipo ?>
        <tr id="r_Nservicio_tipo"<?= $sco_servicio_tipo->Nservicio_tipo->rowAttributes() ?>>
            <td class="<?= $sco_servicio_tipo->TableLeftColumnClass ?>"><?= $sco_servicio_tipo->Nservicio_tipo->caption() ?></td>
            <td<?= $sco_servicio_tipo->Nservicio_tipo->cellAttributes() ?>>
<span id="el_sco_servicio_tipo_Nservicio_tipo">
<span<?= $sco_servicio_tipo->Nservicio_tipo->viewAttributes() ?>>
<?= $sco_servicio_tipo->Nservicio_tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_servicio_tipo->nombre->Visible) { // nombre ?>
        <tr id="r_nombre"<?= $sco_servicio_tipo->nombre->rowAttributes() ?>>
            <td class="<?= $sco_servicio_tipo->TableLeftColumnClass ?>"><?= $sco_servicio_tipo->nombre->caption() ?></td>
            <td<?= $sco_servicio_tipo->nombre->cellAttributes() ?>>
<span id="el_sco_servicio_tipo_nombre">
<span<?= $sco_servicio_tipo->nombre->viewAttributes() ?>>
<?= $sco_servicio_tipo->nombre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
