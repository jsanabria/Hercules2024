<?php

namespace PHPMaker2024\hercules;

// Table
$sco_mascota = Container("sco_mascota");
$sco_mascota->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_mascota->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_mascotamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_mascota->Nmascota->Visible) { // Nmascota ?>
        <tr id="r_Nmascota"<?= $sco_mascota->Nmascota->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->Nmascota->caption() ?></td>
            <td<?= $sco_mascota->Nmascota->cellAttributes() ?>>
<span id="el_sco_mascota_Nmascota">
<span<?= $sco_mascota->Nmascota->viewAttributes() ?>>
<?= $sco_mascota->Nmascota->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->nombre_contratante->Visible) { // nombre_contratante ?>
        <tr id="r_nombre_contratante"<?= $sco_mascota->nombre_contratante->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->nombre_contratante->caption() ?></td>
            <td<?= $sco_mascota->nombre_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_nombre_contratante">
<span<?= $sco_mascota->nombre_contratante->viewAttributes() ?>>
<?= $sco_mascota->nombre_contratante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->cedula_contratante->Visible) { // cedula_contratante ?>
        <tr id="r_cedula_contratante"<?= $sco_mascota->cedula_contratante->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->cedula_contratante->caption() ?></td>
            <td<?= $sco_mascota->cedula_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_cedula_contratante">
<span<?= $sco_mascota->cedula_contratante->viewAttributes() ?>>
<?= $sco_mascota->cedula_contratante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->nombre_mascota->Visible) { // nombre_mascota ?>
        <tr id="r_nombre_mascota"<?= $sco_mascota->nombre_mascota->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->nombre_mascota->caption() ?></td>
            <td<?= $sco_mascota->nombre_mascota->cellAttributes() ?>>
<span id="el_sco_mascota_nombre_mascota">
<span<?= $sco_mascota->nombre_mascota->viewAttributes() ?>>
<?= $sco_mascota->nombre_mascota->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->raza->Visible) { // raza ?>
        <tr id="r_raza"<?= $sco_mascota->raza->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->raza->caption() ?></td>
            <td<?= $sco_mascota->raza->cellAttributes() ?>>
<span id="el_sco_mascota_raza">
<span<?= $sco_mascota->raza->viewAttributes() ?>>
<?= $sco_mascota->raza->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_mascota->tipo->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->tipo->caption() ?></td>
            <td<?= $sco_mascota->tipo->cellAttributes() ?>>
<span id="el_sco_mascota_tipo">
<span<?= $sco_mascota->tipo->viewAttributes() ?>>
<?= $sco_mascota->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->color->Visible) { // color ?>
        <tr id="r_color"<?= $sco_mascota->color->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->color->caption() ?></td>
            <td<?= $sco_mascota->color->cellAttributes() ?>>
<span id="el_sco_mascota_color">
<span<?= $sco_mascota->color->viewAttributes() ?>>
<?= $sco_mascota->color->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->procedencia->Visible) { // procedencia ?>
        <tr id="r_procedencia"<?= $sco_mascota->procedencia->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->procedencia->caption() ?></td>
            <td<?= $sco_mascota->procedencia->cellAttributes() ?>>
<span id="el_sco_mascota_procedencia">
<span<?= $sco_mascota->procedencia->viewAttributes() ?>>
<?= $sco_mascota->procedencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->factura->Visible) { // factura ?>
        <tr id="r_factura"<?= $sco_mascota->factura->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->factura->caption() ?></td>
            <td<?= $sco_mascota->factura->cellAttributes() ?>>
<span id="el_sco_mascota_factura">
<span<?= $sco_mascota->factura->viewAttributes() ?>>
<?= $sco_mascota->factura->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->username_registra->Visible) { // username_registra ?>
        <tr id="r_username_registra"<?= $sco_mascota->username_registra->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->username_registra->caption() ?></td>
            <td<?= $sco_mascota->username_registra->cellAttributes() ?>>
<span id="el_sco_mascota_username_registra">
<span<?= $sco_mascota->username_registra->viewAttributes() ?>>
<?= $sco_mascota->username_registra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mascota->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_mascota->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_mascota->TableLeftColumnClass ?>"><?= $sco_mascota->fecha_registro->caption() ?></td>
            <td<?= $sco_mascota->fecha_registro->cellAttributes() ?>>
<span id="el_sco_mascota_fecha_registro">
<span<?= $sco_mascota->fecha_registro->viewAttributes() ?>>
<?= $sco_mascota->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
