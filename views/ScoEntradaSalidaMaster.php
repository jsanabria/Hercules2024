<?php

namespace PHPMaker2024\hercules;

// Table
$sco_entrada_salida = Container("sco_entrada_salida");
$sco_entrada_salida->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_entrada_salida->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_entrada_salidamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_entrada_salida->tipo_doc->Visible) { // tipo_doc ?>
        <tr id="r_tipo_doc"<?= $sco_entrada_salida->tipo_doc->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->tipo_doc->caption() ?></td>
            <td<?= $sco_entrada_salida->tipo_doc->cellAttributes() ?>>
<span id="el_sco_entrada_salida_tipo_doc">
<span<?= $sco_entrada_salida->tipo_doc->viewAttributes() ?>>
<?= $sco_entrada_salida->tipo_doc->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->proveedor->Visible) { // proveedor ?>
        <tr id="r_proveedor"<?= $sco_entrada_salida->proveedor->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->proveedor->caption() ?></td>
            <td<?= $sco_entrada_salida->proveedor->cellAttributes() ?>>
<span id="el_sco_entrada_salida_proveedor">
<span<?= $sco_entrada_salida->proveedor->viewAttributes() ?>>
<?= $sco_entrada_salida->proveedor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->clasificacion->Visible) { // clasificacion ?>
        <tr id="r_clasificacion"<?= $sco_entrada_salida->clasificacion->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->clasificacion->caption() ?></td>
            <td<?= $sco_entrada_salida->clasificacion->cellAttributes() ?>>
<span id="el_sco_entrada_salida_clasificacion">
<span<?= $sco_entrada_salida->clasificacion->viewAttributes() ?>>
<?= $sco_entrada_salida->clasificacion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->documento->Visible) { // documento ?>
        <tr id="r_documento"<?= $sco_entrada_salida->documento->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->documento->caption() ?></td>
            <td<?= $sco_entrada_salida->documento->cellAttributes() ?>>
<span id="el_sco_entrada_salida_documento">
<span<?= $sco_entrada_salida->documento->viewAttributes() ?>>
<?= $sco_entrada_salida->documento->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->fecha->Visible) { // fecha ?>
        <tr id="r_fecha"<?= $sco_entrada_salida->fecha->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->fecha->caption() ?></td>
            <td<?= $sco_entrada_salida->fecha->cellAttributes() ?>>
<span id="el_sco_entrada_salida_fecha">
<span<?= $sco_entrada_salida->fecha->viewAttributes() ?>>
<?= $sco_entrada_salida->fecha->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->_username->Visible) { // username ?>
        <tr id="r__username"<?= $sco_entrada_salida->_username->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->_username->caption() ?></td>
            <td<?= $sco_entrada_salida->_username->cellAttributes() ?>>
<span id="el_sco_entrada_salida__username">
<span<?= $sco_entrada_salida->_username->viewAttributes() ?>>
<?= $sco_entrada_salida->_username->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->monto->Visible) { // monto ?>
        <tr id="r_monto"<?= $sco_entrada_salida->monto->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->monto->caption() ?></td>
            <td<?= $sco_entrada_salida->monto->cellAttributes() ?>>
<span id="el_sco_entrada_salida_monto">
<span<?= $sco_entrada_salida->monto->viewAttributes() ?>>
<?= $sco_entrada_salida->monto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_entrada_salida->registro->Visible) { // registro ?>
        <tr id="r_registro"<?= $sco_entrada_salida->registro->rowAttributes() ?>>
            <td class="<?= $sco_entrada_salida->TableLeftColumnClass ?>"><?= $sco_entrada_salida->registro->caption() ?></td>
            <td<?= $sco_entrada_salida->registro->cellAttributes() ?>>
<span id="el_sco_entrada_salida_registro">
<span<?= $sco_entrada_salida->registro->viewAttributes() ?>>
<?= $sco_entrada_salida->registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
