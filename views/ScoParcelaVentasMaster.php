<?php

namespace PHPMaker2024\hercules;

// Table
$sco_parcela_ventas = Container("sco_parcela_ventas");
$sco_parcela_ventas->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_parcela_ventas->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_parcela_ventasmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_parcela_ventas->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
        <tr id="r_Nparcela_ventas"<?= $sco_parcela_ventas->Nparcela_ventas->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->Nparcela_ventas->caption() ?></td>
            <td<?= $sco_parcela_ventas->Nparcela_ventas->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_Nparcela_ventas">
<span<?= $sco_parcela_ventas->Nparcela_ventas->viewAttributes() ?>>
<?= $sco_parcela_ventas->Nparcela_ventas->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->fecha_compra->Visible) { // fecha_compra ?>
        <tr id="r_fecha_compra"<?= $sco_parcela_ventas->fecha_compra->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->fecha_compra->caption() ?></td>
            <td<?= $sco_parcela_ventas->fecha_compra->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_fecha_compra">
<span<?= $sco_parcela_ventas->fecha_compra->viewAttributes() ?>>
<?= $sco_parcela_ventas->fecha_compra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->usuario_compra->Visible) { // usuario_compra ?>
        <tr id="r_usuario_compra"<?= $sco_parcela_ventas->usuario_compra->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->usuario_compra->caption() ?></td>
            <td<?= $sco_parcela_ventas->usuario_compra->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_usuario_compra">
<span<?= $sco_parcela_ventas->usuario_compra->viewAttributes() ?>>
<?= $sco_parcela_ventas->usuario_compra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->seccion->Visible) { // seccion ?>
        <tr id="r_seccion"<?= $sco_parcela_ventas->seccion->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->seccion->caption() ?></td>
            <td<?= $sco_parcela_ventas->seccion->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_seccion">
<span<?= $sco_parcela_ventas->seccion->viewAttributes() ?>>
<?= $sco_parcela_ventas->seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->modulo->Visible) { // modulo ?>
        <tr id="r_modulo"<?= $sco_parcela_ventas->modulo->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->modulo->caption() ?></td>
            <td<?= $sco_parcela_ventas->modulo->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_modulo">
<span<?= $sco_parcela_ventas->modulo->viewAttributes() ?>>
<?= $sco_parcela_ventas->modulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->subseccion->Visible) { // subseccion ?>
        <tr id="r_subseccion"<?= $sco_parcela_ventas->subseccion->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->subseccion->caption() ?></td>
            <td<?= $sco_parcela_ventas->subseccion->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_subseccion">
<span<?= $sco_parcela_ventas->subseccion->viewAttributes() ?>>
<?= $sco_parcela_ventas->subseccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->parcela->Visible) { // parcela ?>
        <tr id="r_parcela"<?= $sco_parcela_ventas->parcela->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->parcela->caption() ?></td>
            <td<?= $sco_parcela_ventas->parcela->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_parcela">
<span<?= $sco_parcela_ventas->parcela->viewAttributes() ?>>
<?= $sco_parcela_ventas->parcela->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->vendedor->Visible) { // vendedor ?>
        <tr id="r_vendedor"<?= $sco_parcela_ventas->vendedor->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->vendedor->caption() ?></td>
            <td<?= $sco_parcela_ventas->vendedor->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_vendedor">
<span<?= $sco_parcela_ventas->vendedor->viewAttributes() ?>>
<?= $sco_parcela_ventas->vendedor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_parcela_ventas->estatus->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->estatus->caption() ?></td>
            <td<?= $sco_parcela_ventas->estatus->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_estatus">
<span<?= $sco_parcela_ventas->estatus->viewAttributes() ?>>
<?= $sco_parcela_ventas->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_parcela_ventas->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_parcela_ventas->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_parcela_ventas->TableLeftColumnClass ?>"><?= $sco_parcela_ventas->fecha_registro->caption() ?></td>
            <td<?= $sco_parcela_ventas->fecha_registro->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_fecha_registro">
<span<?= $sco_parcela_ventas->fecha_registro->viewAttributes() ?>>
<?= $sco_parcela_ventas->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
