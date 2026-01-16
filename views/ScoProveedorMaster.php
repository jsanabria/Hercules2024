<?php

namespace PHPMaker2024\hercules;

// Table
$sco_proveedor = Container("sco_proveedor");
$sco_proveedor->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_proveedor->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_proveedormaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_proveedor->Nproveedor->Visible) { // Nproveedor ?>
        <tr id="r_Nproveedor"<?= $sco_proveedor->Nproveedor->rowAttributes() ?>>
            <td class="<?= $sco_proveedor->TableLeftColumnClass ?>"><?= $sco_proveedor->Nproveedor->caption() ?></td>
            <td<?= $sco_proveedor->Nproveedor->cellAttributes() ?>>
<span id="el_sco_proveedor_Nproveedor">
<span<?= $sco_proveedor->Nproveedor->viewAttributes() ?>>
<?= $sco_proveedor->Nproveedor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_proveedor->rif->Visible) { // rif ?>
        <tr id="r_rif"<?= $sco_proveedor->rif->rowAttributes() ?>>
            <td class="<?= $sco_proveedor->TableLeftColumnClass ?>"><?= $sco_proveedor->rif->caption() ?></td>
            <td<?= $sco_proveedor->rif->cellAttributes() ?>>
<span id="el_sco_proveedor_rif">
<span<?= $sco_proveedor->rif->viewAttributes() ?>>
<?= $sco_proveedor->rif->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_proveedor->nombre->Visible) { // nombre ?>
        <tr id="r_nombre"<?= $sco_proveedor->nombre->rowAttributes() ?>>
            <td class="<?= $sco_proveedor->TableLeftColumnClass ?>"><?= $sco_proveedor->nombre->caption() ?></td>
            <td<?= $sco_proveedor->nombre->cellAttributes() ?>>
<span id="el_sco_proveedor_nombre">
<span<?= $sco_proveedor->nombre->viewAttributes() ?>>
<?= $sco_proveedor->nombre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_proveedor->tipo_proveedor->Visible) { // tipo_proveedor ?>
        <tr id="r_tipo_proveedor"<?= $sco_proveedor->tipo_proveedor->rowAttributes() ?>>
            <td class="<?= $sco_proveedor->TableLeftColumnClass ?>"><?= $sco_proveedor->tipo_proveedor->caption() ?></td>
            <td<?= $sco_proveedor->tipo_proveedor->cellAttributes() ?>>
<span id="el_sco_proveedor_tipo_proveedor">
<span<?= $sco_proveedor->tipo_proveedor->viewAttributes() ?>>
<?= $sco_proveedor->tipo_proveedor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_proveedor->activo->Visible) { // activo ?>
        <tr id="r_activo"<?= $sco_proveedor->activo->rowAttributes() ?>>
            <td class="<?= $sco_proveedor->TableLeftColumnClass ?>"><?= $sco_proveedor->activo->caption() ?></td>
            <td<?= $sco_proveedor->activo->cellAttributes() ?>>
<span id="el_sco_proveedor_activo">
<span<?= $sco_proveedor->activo->viewAttributes() ?>>
<?= $sco_proveedor->activo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
