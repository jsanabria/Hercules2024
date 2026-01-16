<?php

namespace PHPMaker2024\hercules;

// Table
$sco_flota_incidencia = Container("sco_flota_incidencia");
$sco_flota_incidencia->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_flota_incidencia->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_flota_incidenciamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_flota_incidencia->Nflota_incidencia->Visible) { // Nflota_incidencia ?>
        <tr id="r_Nflota_incidencia"<?= $sco_flota_incidencia->Nflota_incidencia->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->Nflota_incidencia->caption() ?></td>
            <td<?= $sco_flota_incidencia->Nflota_incidencia->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_Nflota_incidencia">
<span<?= $sco_flota_incidencia->Nflota_incidencia->viewAttributes() ?>>
<?= $sco_flota_incidencia->Nflota_incidencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_flota_incidencia->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->fecha_registro->caption() ?></td>
            <td<?= $sco_flota_incidencia->fecha_registro->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_fecha_registro">
<span<?= $sco_flota_incidencia->fecha_registro->viewAttributes() ?>>
<?= $sco_flota_incidencia->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->flota->Visible) { // flota ?>
        <tr id="r_flota"<?= $sco_flota_incidencia->flota->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->flota->caption() ?></td>
            <td<?= $sco_flota_incidencia->flota->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_flota">
<span<?= $sco_flota_incidencia->flota->viewAttributes() ?>>
<?= $sco_flota_incidencia->flota->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_flota_incidencia->tipo->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->tipo->caption() ?></td>
            <td<?= $sco_flota_incidencia->tipo->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_tipo">
<span<?= $sco_flota_incidencia->tipo->viewAttributes() ?>>
<?= $sco_flota_incidencia->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->falla->Visible) { // falla ?>
        <tr id="r_falla"<?= $sco_flota_incidencia->falla->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->falla->caption() ?></td>
            <td<?= $sco_flota_incidencia->falla->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_falla">
<span<?= $sco_flota_incidencia->falla->viewAttributes() ?>>
<?= $sco_flota_incidencia->falla->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->proveedor->Visible) { // proveedor ?>
        <tr id="r_proveedor"<?= $sco_flota_incidencia->proveedor->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->proveedor->caption() ?></td>
            <td<?= $sco_flota_incidencia->proveedor->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_proveedor">
<span<?= $sco_flota_incidencia->proveedor->viewAttributes() ?>>
<?= $sco_flota_incidencia->proveedor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->_username->Visible) { // username ?>
        <tr id="r__username"<?= $sco_flota_incidencia->_username->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->_username->caption() ?></td>
            <td<?= $sco_flota_incidencia->_username->cellAttributes() ?>>
<span id="el_sco_flota_incidencia__username">
<span<?= $sco_flota_incidencia->_username->viewAttributes() ?>>
<?= $sco_flota_incidencia->_username->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota_incidencia->fecha_reparacion->Visible) { // fecha_reparacion ?>
        <tr id="r_fecha_reparacion"<?= $sco_flota_incidencia->fecha_reparacion->rowAttributes() ?>>
            <td class="<?= $sco_flota_incidencia->TableLeftColumnClass ?>"><?= $sco_flota_incidencia->fecha_reparacion->caption() ?></td>
            <td<?= $sco_flota_incidencia->fecha_reparacion->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_fecha_reparacion">
<span<?= $sco_flota_incidencia->fecha_reparacion->viewAttributes() ?>>
<?= $sco_flota_incidencia->fecha_reparacion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
