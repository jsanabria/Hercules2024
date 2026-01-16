<?php

namespace PHPMaker2024\hercules;

// Table
$view_parcela_ventas = Container("view_parcela_ventas");
$view_parcela_ventas->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($view_parcela_ventas->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_view_parcela_ventasmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($view_parcela_ventas->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
        <tr id="r_Nparcela_ventas"<?= $view_parcela_ventas->Nparcela_ventas->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->Nparcela_ventas->caption() ?></td>
            <td<?= $view_parcela_ventas->Nparcela_ventas->cellAttributes() ?>>
<span id="el_view_parcela_ventas_Nparcela_ventas">
<span<?= $view_parcela_ventas->Nparcela_ventas->viewAttributes() ?>>
<?= $view_parcela_ventas->Nparcela_ventas->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->seccion->Visible) { // seccion ?>
        <tr id="r_seccion"<?= $view_parcela_ventas->seccion->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->seccion->caption() ?></td>
            <td<?= $view_parcela_ventas->seccion->cellAttributes() ?>>
<span id="el_view_parcela_ventas_seccion">
<span<?= $view_parcela_ventas->seccion->viewAttributes() ?>>
<?= $view_parcela_ventas->seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->modulo->Visible) { // modulo ?>
        <tr id="r_modulo"<?= $view_parcela_ventas->modulo->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->modulo->caption() ?></td>
            <td<?= $view_parcela_ventas->modulo->cellAttributes() ?>>
<span id="el_view_parcela_ventas_modulo">
<span<?= $view_parcela_ventas->modulo->viewAttributes() ?>>
<?= $view_parcela_ventas->modulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->subseccion->Visible) { // subseccion ?>
        <tr id="r_subseccion"<?= $view_parcela_ventas->subseccion->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->subseccion->caption() ?></td>
            <td<?= $view_parcela_ventas->subseccion->cellAttributes() ?>>
<span id="el_view_parcela_ventas_subseccion">
<span<?= $view_parcela_ventas->subseccion->viewAttributes() ?>>
<?= $view_parcela_ventas->subseccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->parcela->Visible) { // parcela ?>
        <tr id="r_parcela"<?= $view_parcela_ventas->parcela->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->parcela->caption() ?></td>
            <td<?= $view_parcela_ventas->parcela->cellAttributes() ?>>
<span id="el_view_parcela_ventas_parcela">
<span<?= $view_parcela_ventas->parcela->viewAttributes() ?>>
<?= $view_parcela_ventas->parcela->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->ci_comprador->Visible) { // ci_comprador ?>
        <tr id="r_ci_comprador"<?= $view_parcela_ventas->ci_comprador->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->ci_comprador->caption() ?></td>
            <td<?= $view_parcela_ventas->ci_comprador->cellAttributes() ?>>
<span id="el_view_parcela_ventas_ci_comprador">
<span<?= $view_parcela_ventas->ci_comprador->viewAttributes() ?>>
<?= $view_parcela_ventas->ci_comprador->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->comprador->Visible) { // comprador ?>
        <tr id="r_comprador"<?= $view_parcela_ventas->comprador->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->comprador->caption() ?></td>
            <td<?= $view_parcela_ventas->comprador->cellAttributes() ?>>
<span id="el_view_parcela_ventas_comprador">
<span<?= $view_parcela_ventas->comprador->viewAttributes() ?>>
<?= $view_parcela_ventas->comprador->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->usuario_vende->Visible) { // usuario_vende ?>
        <tr id="r_usuario_vende"<?= $view_parcela_ventas->usuario_vende->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->usuario_vende->caption() ?></td>
            <td<?= $view_parcela_ventas->usuario_vende->cellAttributes() ?>>
<span id="el_view_parcela_ventas_usuario_vende">
<span<?= $view_parcela_ventas->usuario_vende->viewAttributes() ?>>
<?= $view_parcela_ventas->usuario_vende->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->fecha_venta->Visible) { // fecha_venta ?>
        <tr id="r_fecha_venta"<?= $view_parcela_ventas->fecha_venta->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->fecha_venta->caption() ?></td>
            <td<?= $view_parcela_ventas->fecha_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_fecha_venta">
<span<?= $view_parcela_ventas->fecha_venta->viewAttributes() ?>>
<?= $view_parcela_ventas->fecha_venta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->valor_venta->Visible) { // valor_venta ?>
        <tr id="r_valor_venta"<?= $view_parcela_ventas->valor_venta->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->valor_venta->caption() ?></td>
            <td<?= $view_parcela_ventas->valor_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_valor_venta">
<span<?= $view_parcela_ventas->valor_venta->viewAttributes() ?>>
<?= $view_parcela_ventas->valor_venta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->moneda_venta->Visible) { // moneda_venta ?>
        <tr id="r_moneda_venta"<?= $view_parcela_ventas->moneda_venta->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->moneda_venta->caption() ?></td>
            <td<?= $view_parcela_ventas->moneda_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_moneda_venta">
<span<?= $view_parcela_ventas->moneda_venta->viewAttributes() ?>>
<?= $view_parcela_ventas->moneda_venta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->tasa_venta->Visible) { // tasa_venta ?>
        <tr id="r_tasa_venta"<?= $view_parcela_ventas->tasa_venta->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->tasa_venta->caption() ?></td>
            <td<?= $view_parcela_ventas->tasa_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_tasa_venta">
<span<?= $view_parcela_ventas->tasa_venta->viewAttributes() ?>>
<?= $view_parcela_ventas->tasa_venta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_parcela_ventas->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $view_parcela_ventas->estatus->rowAttributes() ?>>
            <td class="<?= $view_parcela_ventas->TableLeftColumnClass ?>"><?= $view_parcela_ventas->estatus->caption() ?></td>
            <td<?= $view_parcela_ventas->estatus->cellAttributes() ?>>
<span id="el_view_parcela_ventas_estatus">
<span<?= $view_parcela_ventas->estatus->viewAttributes() ?>>
<?= $view_parcela_ventas->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
