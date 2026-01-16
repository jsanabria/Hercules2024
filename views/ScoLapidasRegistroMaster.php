<?php

namespace PHPMaker2024\hercules;

// Table
$sco_lapidas_registro = Container("sco_lapidas_registro");
$sco_lapidas_registro->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_lapidas_registro->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_lapidas_registromaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_lapidas_registro->Nlapidas_registro->Visible) { // Nlapidas_registro ?>
        <tr id="r_Nlapidas_registro"<?= $sco_lapidas_registro->Nlapidas_registro->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->Nlapidas_registro->caption() ?></td>
            <td<?= $sco_lapidas_registro->Nlapidas_registro->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_Nlapidas_registro">
<span<?= $sco_lapidas_registro->Nlapidas_registro->viewAttributes() ?>>
<?= $sco_lapidas_registro->Nlapidas_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->solicitante->Visible) { // solicitante ?>
        <tr id="r_solicitante"<?= $sco_lapidas_registro->solicitante->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->solicitante->caption() ?></td>
            <td<?= $sco_lapidas_registro->solicitante->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_solicitante">
<span<?= $sco_lapidas_registro->solicitante->viewAttributes() ?>>
<?= $sco_lapidas_registro->solicitante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->parentesco->Visible) { // parentesco ?>
        <tr id="r_parentesco"<?= $sco_lapidas_registro->parentesco->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->parentesco->caption() ?></td>
            <td<?= $sco_lapidas_registro->parentesco->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_parentesco">
<span<?= $sco_lapidas_registro->parentesco->viewAttributes() ?>>
<?= $sco_lapidas_registro->parentesco->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->ci_difunto->Visible) { // ci_difunto ?>
        <tr id="r_ci_difunto"<?= $sco_lapidas_registro->ci_difunto->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->ci_difunto->caption() ?></td>
            <td<?= $sco_lapidas_registro->ci_difunto->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_ci_difunto">
<span<?= $sco_lapidas_registro->ci_difunto->viewAttributes() ?>>
<?= $sco_lapidas_registro->ci_difunto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->nombre_difunto->Visible) { // nombre_difunto ?>
        <tr id="r_nombre_difunto"<?= $sco_lapidas_registro->nombre_difunto->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->nombre_difunto->caption() ?></td>
            <td<?= $sco_lapidas_registro->nombre_difunto->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_nombre_difunto">
<span<?= $sco_lapidas_registro->nombre_difunto->viewAttributes() ?>>
<?= $sco_lapidas_registro->nombre_difunto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_lapidas_registro->tipo->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->tipo->caption() ?></td>
            <td<?= $sco_lapidas_registro->tipo->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_tipo">
<span<?= $sco_lapidas_registro->tipo->viewAttributes() ?>>
<?= $sco_lapidas_registro->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_lapidas_registro->estatus->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->estatus->caption() ?></td>
            <td<?= $sco_lapidas_registro->estatus->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_estatus">
<span<?= $sco_lapidas_registro->estatus->viewAttributes() ?>>
<?= $sco_lapidas_registro->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->registro->Visible) { // registro ?>
        <tr id="r_registro"<?= $sco_lapidas_registro->registro->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->registro->caption() ?></td>
            <td<?= $sco_lapidas_registro->registro->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_registro">
<span<?= $sco_lapidas_registro->registro->viewAttributes() ?>>
<?= $sco_lapidas_registro->registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->registra->Visible) { // registra ?>
        <tr id="r_registra"<?= $sco_lapidas_registro->registra->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->registra->caption() ?></td>
            <td<?= $sco_lapidas_registro->registra->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_registra">
<span<?= $sco_lapidas_registro->registra->viewAttributes() ?>>
<?= $sco_lapidas_registro->registra->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->modifica->Visible) { // modifica ?>
        <tr id="r_modifica"<?= $sco_lapidas_registro->modifica->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->modifica->caption() ?></td>
            <td<?= $sco_lapidas_registro->modifica->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_modifica">
<span<?= $sco_lapidas_registro->modifica->viewAttributes() ?>>
<?= $sco_lapidas_registro->modifica->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->seccion->Visible) { // seccion ?>
        <tr id="r_seccion"<?= $sco_lapidas_registro->seccion->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->seccion->caption() ?></td>
            <td<?= $sco_lapidas_registro->seccion->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_seccion">
<span<?= $sco_lapidas_registro->seccion->viewAttributes() ?>>
<?= $sco_lapidas_registro->seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->modulo->Visible) { // modulo ?>
        <tr id="r_modulo"<?= $sco_lapidas_registro->modulo->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->modulo->caption() ?></td>
            <td<?= $sco_lapidas_registro->modulo->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_modulo">
<span<?= $sco_lapidas_registro->modulo->viewAttributes() ?>>
<?= $sco_lapidas_registro->modulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->sub_seccion->Visible) { // sub_seccion ?>
        <tr id="r_sub_seccion"<?= $sco_lapidas_registro->sub_seccion->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->sub_seccion->caption() ?></td>
            <td<?= $sco_lapidas_registro->sub_seccion->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_sub_seccion">
<span<?= $sco_lapidas_registro->sub_seccion->viewAttributes() ?>>
<?= $sco_lapidas_registro->sub_seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->parcela->Visible) { // parcela ?>
        <tr id="r_parcela"<?= $sco_lapidas_registro->parcela->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->parcela->caption() ?></td>
            <td<?= $sco_lapidas_registro->parcela->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_parcela">
<span<?= $sco_lapidas_registro->parcela->viewAttributes() ?>>
<?= $sco_lapidas_registro->parcela->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_lapidas_registro->contrato->Visible) { // contrato ?>
        <tr id="r_contrato"<?= $sco_lapidas_registro->contrato->rowAttributes() ?>>
            <td class="<?= $sco_lapidas_registro->TableLeftColumnClass ?>"><?= $sco_lapidas_registro->contrato->caption() ?></td>
            <td<?= $sco_lapidas_registro->contrato->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_contrato">
<span<?= $sco_lapidas_registro->contrato->viewAttributes() ?>>
<?= $sco_lapidas_registro->contrato->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
