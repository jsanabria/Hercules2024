<?php

namespace PHPMaker2024\hercules;

// Table
$sco_flota = Container("sco_flota");
$sco_flota->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_flota->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_flotamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_flota->tipo_flota->Visible) { // tipo_flota ?>
        <tr id="r_tipo_flota"<?= $sco_flota->tipo_flota->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->tipo_flota->caption() ?></td>
            <td<?= $sco_flota->tipo_flota->cellAttributes() ?>>
<span id="el_sco_flota_tipo_flota">
<span<?= $sco_flota->tipo_flota->viewAttributes() ?>>
<?= $sco_flota->tipo_flota->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->marca->Visible) { // marca ?>
        <tr id="r_marca"<?= $sco_flota->marca->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->marca->caption() ?></td>
            <td<?= $sco_flota->marca->cellAttributes() ?>>
<span id="el_sco_flota_marca">
<span<?= $sco_flota->marca->viewAttributes() ?>>
<?= $sco_flota->marca->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->modelo->Visible) { // modelo ?>
        <tr id="r_modelo"<?= $sco_flota->modelo->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->modelo->caption() ?></td>
            <td<?= $sco_flota->modelo->cellAttributes() ?>>
<span id="el_sco_flota_modelo">
<span<?= $sco_flota->modelo->viewAttributes() ?>>
<?= $sco_flota->modelo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->placa->Visible) { // placa ?>
        <tr id="r_placa"<?= $sco_flota->placa->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->placa->caption() ?></td>
            <td<?= $sco_flota->placa->cellAttributes() ?>>
<span id="el_sco_flota_placa">
<span<?= $sco_flota->placa->viewAttributes() ?>>
<?= $sco_flota->placa->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->color->Visible) { // color ?>
        <tr id="r_color"<?= $sco_flota->color->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->color->caption() ?></td>
            <td<?= $sco_flota->color->cellAttributes() ?>>
<span id="el_sco_flota_color">
<span<?= $sco_flota->color->viewAttributes() ?>>
<?= $sco_flota->color->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->anho->Visible) { // anho ?>
        <tr id="r_anho"<?= $sco_flota->anho->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->anho->caption() ?></td>
            <td<?= $sco_flota->anho->cellAttributes() ?>>
<span id="el_sco_flota_anho">
<span<?= $sco_flota->anho->viewAttributes() ?>>
<?= $sco_flota->anho->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_flota->tipo->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->tipo->caption() ?></td>
            <td<?= $sco_flota->tipo->cellAttributes() ?>>
<span id="el_sco_flota_tipo">
<span<?= $sco_flota->tipo->viewAttributes() ?>>
<?= $sco_flota->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->conductor->Visible) { // conductor ?>
        <tr id="r_conductor"<?= $sco_flota->conductor->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->conductor->caption() ?></td>
            <td<?= $sco_flota->conductor->cellAttributes() ?>>
<span id="el_sco_flota_conductor">
<span<?= $sco_flota->conductor->viewAttributes() ?>>
<?= $sco_flota->conductor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_flota->activo->Visible) { // activo ?>
        <tr id="r_activo"<?= $sco_flota->activo->rowAttributes() ?>>
            <td class="<?= $sco_flota->TableLeftColumnClass ?>"><?= $sco_flota->activo->caption() ?></td>
            <td<?= $sco_flota->activo->cellAttributes() ?>>
<span id="el_sco_flota_activo">
<span<?= $sco_flota->activo->viewAttributes() ?>>
<?= $sco_flota->activo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
