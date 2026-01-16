<?php

namespace PHPMaker2024\hercules;

// Table
$sco_mttotecnico = Container("sco_mttotecnico");
$sco_mttotecnico->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_mttotecnico->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_mttotecnicomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_mttotecnico->Nmttotecnico->Visible) { // Nmttotecnico ?>
        <tr id="r_Nmttotecnico"<?= $sco_mttotecnico->Nmttotecnico->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->Nmttotecnico->caption() ?></td>
            <td<?= $sco_mttotecnico->Nmttotecnico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_Nmttotecnico">
<span<?= $sco_mttotecnico->Nmttotecnico->viewAttributes() ?>>
<?= $sco_mttotecnico->Nmttotecnico->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_mttotecnico->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->fecha_registro->caption() ?></td>
            <td<?= $sco_mttotecnico->fecha_registro->cellAttributes() ?>>
<span id="el_sco_mttotecnico_fecha_registro">
<span<?= $sco_mttotecnico->fecha_registro->viewAttributes() ?>>
<?= $sco_mttotecnico->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->user_solicita->Visible) { // user_solicita ?>
        <tr id="r_user_solicita"<?= $sco_mttotecnico->user_solicita->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->user_solicita->caption() ?></td>
            <td<?= $sco_mttotecnico->user_solicita->cellAttributes() ?>>
<span id="el_sco_mttotecnico_user_solicita">
<span<?= $sco_mttotecnico->user_solicita->viewAttributes() ?>>
<?= $sco_mttotecnico->user_solicita->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->tipo_solicitud->Visible) { // tipo_solicitud ?>
        <tr id="r_tipo_solicitud"<?= $sco_mttotecnico->tipo_solicitud->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->tipo_solicitud->caption() ?></td>
            <td<?= $sco_mttotecnico->tipo_solicitud->cellAttributes() ?>>
<span id="el_sco_mttotecnico_tipo_solicitud">
<span<?= $sco_mttotecnico->tipo_solicitud->viewAttributes() ?>>
<?= $sco_mttotecnico->tipo_solicitud->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <tr id="r_unidad_solicitante"<?= $sco_mttotecnico->unidad_solicitante->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->unidad_solicitante->caption() ?></td>
            <td<?= $sco_mttotecnico->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_mttotecnico_unidad_solicitante">
<span<?= $sco_mttotecnico->unidad_solicitante->viewAttributes() ?>>
<?= $sco_mttotecnico->unidad_solicitante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->area_falla->Visible) { // area_falla ?>
        <tr id="r_area_falla"<?= $sco_mttotecnico->area_falla->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->area_falla->caption() ?></td>
            <td<?= $sco_mttotecnico->area_falla->cellAttributes() ?>>
<span id="el_sco_mttotecnico_area_falla">
<span<?= $sco_mttotecnico->area_falla->viewAttributes() ?>>
<?= $sco_mttotecnico->area_falla->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->prioridad->Visible) { // prioridad ?>
        <tr id="r_prioridad"<?= $sco_mttotecnico->prioridad->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->prioridad->caption() ?></td>
            <td<?= $sco_mttotecnico->prioridad->cellAttributes() ?>>
<span id="el_sco_mttotecnico_prioridad">
<span<?= $sco_mttotecnico->prioridad->viewAttributes() ?>>
<?= $sco_mttotecnico->prioridad->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_mttotecnico->estatus->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->estatus->caption() ?></td>
            <td<?= $sco_mttotecnico->estatus->cellAttributes() ?>>
<span id="el_sco_mttotecnico_estatus">
<span<?= $sco_mttotecnico->estatus->viewAttributes() ?>>
<?= $sco_mttotecnico->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->diagnostico->Visible) { // diagnostico ?>
        <tr id="r_diagnostico"<?= $sco_mttotecnico->diagnostico->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->diagnostico->caption() ?></td>
            <td<?= $sco_mttotecnico->diagnostico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_diagnostico">
<span<?= $sco_mttotecnico->diagnostico->viewAttributes() ?>>
<?= $sco_mttotecnico->diagnostico->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_mttotecnico->requiere_materiales->Visible) { // requiere_materiales ?>
        <tr id="r_requiere_materiales"<?= $sco_mttotecnico->requiere_materiales->rowAttributes() ?>>
            <td class="<?= $sco_mttotecnico->TableLeftColumnClass ?>"><?= $sco_mttotecnico->requiere_materiales->caption() ?></td>
            <td<?= $sco_mttotecnico->requiere_materiales->cellAttributes() ?>>
<span id="el_sco_mttotecnico_requiere_materiales">
<span<?= $sco_mttotecnico->requiere_materiales->viewAttributes() ?>>
<?= $sco_mttotecnico->requiere_materiales->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
