<?php

namespace PHPMaker2024\hercules;

// Table
$sco_reclamo = Container("sco_reclamo");
$sco_reclamo->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_reclamo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_reclamomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_reclamo->Nreclamo->Visible) { // Nreclamo ?>
        <tr id="r_Nreclamo"<?= $sco_reclamo->Nreclamo->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->Nreclamo->caption() ?></td>
            <td<?= $sco_reclamo->Nreclamo->cellAttributes() ?>>
<span id="el_sco_reclamo_Nreclamo">
<span<?= $sco_reclamo->Nreclamo->viewAttributes() ?>>
<?= $sco_reclamo->Nreclamo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->solicitante->Visible) { // solicitante ?>
        <tr id="r_solicitante"<?= $sco_reclamo->solicitante->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->solicitante->caption() ?></td>
            <td<?= $sco_reclamo->solicitante->cellAttributes() ?>>
<span id="el_sco_reclamo_solicitante">
<span<?= $sco_reclamo->solicitante->viewAttributes() ?>>
<?= $sco_reclamo->solicitante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->ci_difunto->Visible) { // ci_difunto ?>
        <tr id="r_ci_difunto"<?= $sco_reclamo->ci_difunto->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->ci_difunto->caption() ?></td>
            <td<?= $sco_reclamo->ci_difunto->cellAttributes() ?>>
<span id="el_sco_reclamo_ci_difunto">
<span<?= $sco_reclamo->ci_difunto->viewAttributes() ?>>
<?= $sco_reclamo->ci_difunto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->nombre_difunto->Visible) { // nombre_difunto ?>
        <tr id="r_nombre_difunto"<?= $sco_reclamo->nombre_difunto->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->nombre_difunto->caption() ?></td>
            <td<?= $sco_reclamo->nombre_difunto->cellAttributes() ?>>
<span id="el_sco_reclamo_nombre_difunto">
<span<?= $sco_reclamo->nombre_difunto->viewAttributes() ?>>
<?= $sco_reclamo->nombre_difunto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_reclamo->tipo->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->tipo->caption() ?></td>
            <td<?= $sco_reclamo->tipo->cellAttributes() ?>>
<span id="el_sco_reclamo_tipo">
<span<?= $sco_reclamo->tipo->viewAttributes() ?>>
<?= $sco_reclamo->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_reclamo->estatus->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->estatus->caption() ?></td>
            <td<?= $sco_reclamo->estatus->cellAttributes() ?>>
<span id="el_sco_reclamo_estatus">
<span<?= $sco_reclamo->estatus->viewAttributes() ?>>
<?= $sco_reclamo->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->registro->Visible) { // registro ?>
        <tr id="r_registro"<?= $sco_reclamo->registro->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->registro->caption() ?></td>
            <td<?= $sco_reclamo->registro->cellAttributes() ?>>
<span id="el_sco_reclamo_registro">
<span<?= $sco_reclamo->registro->viewAttributes() ?>>
<?= $sco_reclamo->registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->registra->Visible) { // registra ?>
        <tr id="r_registra"<?= $sco_reclamo->registra->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->registra->caption() ?></td>
            <td<?= $sco_reclamo->registra->cellAttributes() ?>>
<span id="el_sco_reclamo_registra">
<span<?= $sco_reclamo->registra->viewAttributes() ?>>
<?= $sco_reclamo->registra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->modifica->Visible) { // modifica ?>
        <tr id="r_modifica"<?= $sco_reclamo->modifica->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->modifica->caption() ?></td>
            <td<?= $sco_reclamo->modifica->cellAttributes() ?>>
<span id="el_sco_reclamo_modifica">
<span<?= $sco_reclamo->modifica->viewAttributes() ?>>
<?= $sco_reclamo->modifica->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->seccion->Visible) { // seccion ?>
        <tr id="r_seccion"<?= $sco_reclamo->seccion->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->seccion->caption() ?></td>
            <td<?= $sco_reclamo->seccion->cellAttributes() ?>>
<span id="el_sco_reclamo_seccion">
<span<?= $sco_reclamo->seccion->viewAttributes() ?>>
<?= $sco_reclamo->seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->modulo->Visible) { // modulo ?>
        <tr id="r_modulo"<?= $sco_reclamo->modulo->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->modulo->caption() ?></td>
            <td<?= $sco_reclamo->modulo->cellAttributes() ?>>
<span id="el_sco_reclamo_modulo">
<span<?= $sco_reclamo->modulo->viewAttributes() ?>>
<?= $sco_reclamo->modulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->sub_seccion->Visible) { // sub_seccion ?>
        <tr id="r_sub_seccion"<?= $sco_reclamo->sub_seccion->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->sub_seccion->caption() ?></td>
            <td<?= $sco_reclamo->sub_seccion->cellAttributes() ?>>
<span id="el_sco_reclamo_sub_seccion">
<span<?= $sco_reclamo->sub_seccion->viewAttributes() ?>>
<?= $sco_reclamo->sub_seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_reclamo->parcela->Visible) { // parcela ?>
        <tr id="r_parcela"<?= $sco_reclamo->parcela->rowAttributes() ?>>
            <td class="<?= $sco_reclamo->TableLeftColumnClass ?>"><?= $sco_reclamo->parcela->caption() ?></td>
            <td<?= $sco_reclamo->parcela->cellAttributes() ?>>
<span id="el_sco_reclamo_parcela">
<span<?= $sco_reclamo->parcela->viewAttributes() ?>>
<?= $sco_reclamo->parcela->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
