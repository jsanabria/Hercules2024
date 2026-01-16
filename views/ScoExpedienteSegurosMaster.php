<?php

namespace PHPMaker2024\hercules;

// Table
$sco_expediente_seguros = Container("sco_expediente_seguros");
$sco_expediente_seguros->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_expediente_seguros->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_expediente_segurosmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_expediente_seguros->seguro->Visible) { // seguro ?>
        <tr id="r_seguro"<?= $sco_expediente_seguros->seguro->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->seguro->caption() ?></td>
            <td<?= $sco_expediente_seguros->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_seguro">
<span<?= $sco_expediente_seguros->seguro->viewAttributes() ?>>
<?= $sco_expediente_seguros->seguro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->nombre_contacto->Visible) { // nombre_contacto ?>
        <tr id="r_nombre_contacto"<?= $sco_expediente_seguros->nombre_contacto->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->nombre_contacto->caption() ?></td>
            <td<?= $sco_expediente_seguros->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nombre_contacto">
<span<?= $sco_expediente_seguros->nombre_contacto->viewAttributes() ?>>
<?= $sco_expediente_seguros->nombre_contacto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <tr id="r_cedula_fallecido"<?= $sco_expediente_seguros->cedula_fallecido->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->cedula_fallecido->caption() ?></td>
            <td<?= $sco_expediente_seguros->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_cedula_fallecido">
<span<?= $sco_expediente_seguros->cedula_fallecido->viewAttributes() ?>>
<?= $sco_expediente_seguros->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <tr id="r_nombre_fallecido"<?= $sco_expediente_seguros->nombre_fallecido->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->nombre_fallecido->caption() ?></td>
            <td<?= $sco_expediente_seguros->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nombre_fallecido">
<span<?= $sco_expediente_seguros->nombre_fallecido->viewAttributes() ?>>
<?= $sco_expediente_seguros->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <tr id="r_apellidos_fallecido"<?= $sco_expediente_seguros->apellidos_fallecido->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->apellidos_fallecido->caption() ?></td>
            <td<?= $sco_expediente_seguros->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_apellidos_fallecido">
<span<?= $sco_expediente_seguros->apellidos_fallecido->viewAttributes() ?>>
<?= $sco_expediente_seguros->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <tr id="r_causa_ocurrencia"<?= $sco_expediente_seguros->causa_ocurrencia->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->causa_ocurrencia->caption() ?></td>
            <td<?= $sco_expediente_seguros->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_causa_ocurrencia">
<span<?= $sco_expediente_seguros->causa_ocurrencia->viewAttributes() ?>>
<?= $sco_expediente_seguros->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->user_registra->Visible) { // user_registra ?>
        <tr id="r_user_registra"<?= $sco_expediente_seguros->user_registra->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->user_registra->caption() ?></td>
            <td<?= $sco_expediente_seguros->user_registra->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_user_registra">
<span<?= $sco_expediente_seguros->user_registra->viewAttributes() ?>>
<?= $sco_expediente_seguros->user_registra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_expediente_seguros->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->fecha_registro->caption() ?></td>
            <td<?= $sco_expediente_seguros->fecha_registro->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_fecha_registro">
<span<?= $sco_expediente_seguros->fecha_registro->viewAttributes() ?>>
<?= $sco_expediente_seguros->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_expediente_seguros->estatus->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->estatus->caption() ?></td>
            <td<?= $sco_expediente_seguros->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_estatus">
<span<?= $sco_expediente_seguros->estatus->viewAttributes() ?>>
<?= $sco_expediente_seguros->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_expediente_seguros->funeraria->Visible) { // funeraria ?>
        <tr id="r_funeraria"<?= $sco_expediente_seguros->funeraria->rowAttributes() ?>>
            <td class="<?= $sco_expediente_seguros->TableLeftColumnClass ?>"><?= $sco_expediente_seguros->funeraria->caption() ?></td>
            <td<?= $sco_expediente_seguros->funeraria->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_funeraria">
<span<?= $sco_expediente_seguros->funeraria->viewAttributes() ?>>
<?= $sco_expediente_seguros->funeraria->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
