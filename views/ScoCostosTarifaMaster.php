<?php

namespace PHPMaker2024\hercules;

// Table
$sco_costos_tarifa = Container("sco_costos_tarifa");
$sco_costos_tarifa->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_costos_tarifa->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_costos_tarifamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_costos_tarifa->localidad->Visible) { // localidad ?>
        <tr id="r_localidad"<?= $sco_costos_tarifa->localidad->rowAttributes() ?>>
            <td class="<?= $sco_costos_tarifa->TableLeftColumnClass ?>"><?= $sco_costos_tarifa->localidad->caption() ?></td>
            <td<?= $sco_costos_tarifa->localidad->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_localidad">
<span<?= $sco_costos_tarifa->localidad->viewAttributes() ?>>
<?= $sco_costos_tarifa->localidad->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_costos_tarifa->tipo_servicio->Visible) { // tipo_servicio ?>
        <tr id="r_tipo_servicio"<?= $sco_costos_tarifa->tipo_servicio->rowAttributes() ?>>
            <td class="<?= $sco_costos_tarifa->TableLeftColumnClass ?>"><?= $sco_costos_tarifa->tipo_servicio->caption() ?></td>
            <td<?= $sco_costos_tarifa->tipo_servicio->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_tipo_servicio">
<span<?= $sco_costos_tarifa->tipo_servicio->viewAttributes() ?>>
<?= $sco_costos_tarifa->tipo_servicio->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_costos_tarifa->horas->Visible) { // horas ?>
        <tr id="r_horas"<?= $sco_costos_tarifa->horas->rowAttributes() ?>>
            <td class="<?= $sco_costos_tarifa->TableLeftColumnClass ?>"><?= $sco_costos_tarifa->horas->caption() ?></td>
            <td<?= $sco_costos_tarifa->horas->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_horas">
<span<?= $sco_costos_tarifa->horas->viewAttributes() ?>>
<?= $sco_costos_tarifa->horas->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_costos_tarifa->activo->Visible) { // activo ?>
        <tr id="r_activo"<?= $sco_costos_tarifa->activo->rowAttributes() ?>>
            <td class="<?= $sco_costos_tarifa->TableLeftColumnClass ?>"><?= $sco_costos_tarifa->activo->caption() ?></td>
            <td<?= $sco_costos_tarifa->activo->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_activo">
<span<?= $sco_costos_tarifa->activo->viewAttributes() ?>>
<?= $sco_costos_tarifa->activo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
