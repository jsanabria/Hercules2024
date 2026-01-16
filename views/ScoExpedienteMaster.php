<?php

namespace PHPMaker2024\hercules;

// Table
$sco_expediente = Container("sco_expediente");
$sco_expediente->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_expediente->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_expedientemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_expediente->Nexpediente->Visible) { // Nexpediente ?>
        <tr id="r_Nexpediente"<?= $sco_expediente->Nexpediente->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->Nexpediente->caption() ?></td>
            <td<?= $sco_expediente->Nexpediente->cellAttributes() ?>>
<span id="el_sco_expediente_Nexpediente">
<span<?= $sco_expediente->Nexpediente->viewAttributes() ?>>
<?= $sco_expediente->Nexpediente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->nombre_contacto->Visible) { // nombre_contacto ?>
        <tr id="r_nombre_contacto"<?= $sco_expediente->nombre_contacto->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->nombre_contacto->caption() ?></td>
            <td<?= $sco_expediente->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_nombre_contacto">
<span<?= $sco_expediente->nombre_contacto->viewAttributes() ?>>
<?= $sco_expediente->nombre_contacto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <tr id="r_cedula_fallecido"<?= $sco_expediente->cedula_fallecido->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->cedula_fallecido->caption() ?></td>
            <td<?= $sco_expediente->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_cedula_fallecido">
<span<?= $sco_expediente->cedula_fallecido->viewAttributes() ?>>
<?= $sco_expediente->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <tr id="r_nombre_fallecido"<?= $sco_expediente->nombre_fallecido->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->nombre_fallecido->caption() ?></td>
            <td<?= $sco_expediente->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_nombre_fallecido">
<span<?= $sco_expediente->nombre_fallecido->viewAttributes() ?>>
<?= $sco_expediente->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <tr id="r_apellidos_fallecido"<?= $sco_expediente->apellidos_fallecido->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->apellidos_fallecido->caption() ?></td>
            <td<?= $sco_expediente->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_apellidos_fallecido">
<span<?= $sco_expediente->apellidos_fallecido->viewAttributes() ?>>
<?= $sco_expediente->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <tr id="r_causa_ocurrencia"<?= $sco_expediente->causa_ocurrencia->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->causa_ocurrencia->caption() ?></td>
            <td<?= $sco_expediente->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_causa_ocurrencia">
<span<?= $sco_expediente->causa_ocurrencia->viewAttributes() ?>>
<?= $sco_expediente->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->venta->Visible) { // venta ?>
        <tr id="r_venta"<?= $sco_expediente->venta->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->venta->caption() ?></td>
            <td<?= $sco_expediente->venta->cellAttributes() ?>>
<span id="el_sco_expediente_venta">
<span<?= $sco_expediente->venta->viewAttributes() ?>>
<?= $sco_expediente->venta->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->user_registra->Visible) { // user_registra ?>
        <tr id="r_user_registra"<?= $sco_expediente->user_registra->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->user_registra->caption() ?></td>
            <td<?= $sco_expediente->user_registra->cellAttributes() ?>>
<span id="el_sco_expediente_user_registra">
<span<?= $sco_expediente->user_registra->viewAttributes() ?>>
<?= $sco_expediente->user_registra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_expediente->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->fecha_registro->caption() ?></td>
            <td<?= $sco_expediente->fecha_registro->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_registro">
<span<?= $sco_expediente->fecha_registro->viewAttributes() ?>>
<?= $sco_expediente->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_expediente->estatus->rowAttributes() ?>>
            <td class="<?= $sco_expediente->TableLeftColumnClass ?>"><?= $sco_expediente->estatus->caption() ?></td>
            <td<?= $sco_expediente->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_estatus">
<span<?= $sco_expediente->estatus->viewAttributes() ?>>
<?= $sco_expediente->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
