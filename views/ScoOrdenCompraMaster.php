<?php

namespace PHPMaker2024\hercules;

// Table
$sco_orden_compra = Container("sco_orden_compra");
$sco_orden_compra->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_orden_compra->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_orden_compramaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_orden_compra->Norden_compra->Visible) { // Norden_compra ?>
        <tr id="r_Norden_compra"<?= $sco_orden_compra->Norden_compra->rowAttributes() ?>>
            <td class="<?= $sco_orden_compra->TableLeftColumnClass ?>"><?= $sco_orden_compra->Norden_compra->caption() ?></td>
            <td<?= $sco_orden_compra->Norden_compra->cellAttributes() ?>>
<span id="el_sco_orden_compra_Norden_compra">
<span<?= $sco_orden_compra->Norden_compra->viewAttributes() ?>>
<?= $sco_orden_compra->Norden_compra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_orden_compra->fecha->Visible) { // fecha ?>
        <tr id="r_fecha"<?= $sco_orden_compra->fecha->rowAttributes() ?>>
            <td class="<?= $sco_orden_compra->TableLeftColumnClass ?>"><?= $sco_orden_compra->fecha->caption() ?></td>
            <td<?= $sco_orden_compra->fecha->cellAttributes() ?>>
<span id="el_sco_orden_compra_fecha">
<span<?= $sco_orden_compra->fecha->viewAttributes() ?>>
<?= $sco_orden_compra->fecha->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_orden_compra->_username->Visible) { // username ?>
        <tr id="r__username"<?= $sco_orden_compra->_username->rowAttributes() ?>>
            <td class="<?= $sco_orden_compra->TableLeftColumnClass ?>"><?= $sco_orden_compra->_username->caption() ?></td>
            <td<?= $sco_orden_compra->_username->cellAttributes() ?>>
<span id="el_sco_orden_compra__username">
<span<?= $sco_orden_compra->_username->viewAttributes() ?>>
<?= $sco_orden_compra->_username->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_orden_compra->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <tr id="r_unidad_solicitante"<?= $sco_orden_compra->unidad_solicitante->rowAttributes() ?>>
            <td class="<?= $sco_orden_compra->TableLeftColumnClass ?>"><?= $sco_orden_compra->unidad_solicitante->caption() ?></td>
            <td<?= $sco_orden_compra->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_orden_compra_unidad_solicitante">
<span<?= $sco_orden_compra->unidad_solicitante->viewAttributes() ?>>
<?= $sco_orden_compra->unidad_solicitante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_orden_compra->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_orden_compra->estatus->rowAttributes() ?>>
            <td class="<?= $sco_orden_compra->TableLeftColumnClass ?>"><?= $sco_orden_compra->estatus->caption() ?></td>
            <td<?= $sco_orden_compra->estatus->cellAttributes() ?>>
<span id="el_sco_orden_compra_estatus">
<span<?= $sco_orden_compra->estatus->viewAttributes() ?>>
<?= $sco_orden_compra->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_orden_compra->username_estatus->Visible) { // username_estatus ?>
        <tr id="r_username_estatus"<?= $sco_orden_compra->username_estatus->rowAttributes() ?>>
            <td class="<?= $sco_orden_compra->TableLeftColumnClass ?>"><?= $sco_orden_compra->username_estatus->caption() ?></td>
            <td<?= $sco_orden_compra->username_estatus->cellAttributes() ?>>
<span id="el_sco_orden_compra_username_estatus">
<span<?= $sco_orden_compra->username_estatus->viewAttributes() ?>>
<?= $sco_orden_compra->username_estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
