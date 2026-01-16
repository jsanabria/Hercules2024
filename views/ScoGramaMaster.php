<?php

namespace PHPMaker2024\hercules;

// Table
$sco_grama = Container("sco_grama");
$sco_grama->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_grama->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_gramamaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_grama->Ngrama->Visible) { // Ngrama ?>
        <tr id="r_Ngrama"<?= $sco_grama->Ngrama->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->Ngrama->caption() ?></td>
            <td<?= $sco_grama->Ngrama->cellAttributes() ?>>
<span id="el_sco_grama_Ngrama">
<span<?= $sco_grama->Ngrama->viewAttributes() ?>>
<?= $sco_grama->Ngrama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->ci_solicitante->Visible) { // ci_solicitante ?>
        <tr id="r_ci_solicitante"<?= $sco_grama->ci_solicitante->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->ci_solicitante->caption() ?></td>
            <td<?= $sco_grama->ci_solicitante->cellAttributes() ?>>
<span id="el_sco_grama_ci_solicitante">
<span<?= $sco_grama->ci_solicitante->viewAttributes() ?>>
<?= $sco_grama->ci_solicitante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->solicitante->Visible) { // solicitante ?>
        <tr id="r_solicitante"<?= $sco_grama->solicitante->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->solicitante->caption() ?></td>
            <td<?= $sco_grama->solicitante->cellAttributes() ?>>
<span id="el_sco_grama_solicitante">
<span<?= $sco_grama->solicitante->viewAttributes() ?>>
<?= $sco_grama->solicitante->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $sco_grama->tipo->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->tipo->caption() ?></td>
            <td<?= $sco_grama->tipo->cellAttributes() ?>>
<span id="el_sco_grama_tipo">
<span<?= $sco_grama->tipo->viewAttributes() ?>>
<?= $sco_grama->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->monto->Visible) { // monto ?>
        <tr id="r_monto"<?= $sco_grama->monto->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->monto->caption() ?></td>
            <td<?= $sco_grama->monto->cellAttributes() ?>>
<span id="el_sco_grama_monto">
<span<?= $sco_grama->monto->viewAttributes() ?>>
<?= $sco_grama->monto->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->contrato->Visible) { // contrato ?>
        <tr id="r_contrato"<?= $sco_grama->contrato->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->contrato->caption() ?></td>
            <td<?= $sco_grama->contrato->cellAttributes() ?>>
<span id="el_sco_grama_contrato">
<span<?= $sco_grama->contrato->viewAttributes() ?>>
<?= $sco_grama->contrato->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->seccion->Visible) { // seccion ?>
        <tr id="r_seccion"<?= $sco_grama->seccion->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->seccion->caption() ?></td>
            <td<?= $sco_grama->seccion->cellAttributes() ?>>
<span id="el_sco_grama_seccion">
<span<?= $sco_grama->seccion->viewAttributes() ?>>
<?= $sco_grama->seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->modulo->Visible) { // modulo ?>
        <tr id="r_modulo"<?= $sco_grama->modulo->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->modulo->caption() ?></td>
            <td<?= $sco_grama->modulo->cellAttributes() ?>>
<span id="el_sco_grama_modulo">
<span<?= $sco_grama->modulo->viewAttributes() ?>>
<?= $sco_grama->modulo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->sub_seccion->Visible) { // sub_seccion ?>
        <tr id="r_sub_seccion"<?= $sco_grama->sub_seccion->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->sub_seccion->caption() ?></td>
            <td<?= $sco_grama->sub_seccion->cellAttributes() ?>>
<span id="el_sco_grama_sub_seccion">
<span<?= $sco_grama->sub_seccion->viewAttributes() ?>>
<?= $sco_grama->sub_seccion->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->parcela->Visible) { // parcela ?>
        <tr id="r_parcela"<?= $sco_grama->parcela->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->parcela->caption() ?></td>
            <td<?= $sco_grama->parcela->cellAttributes() ?>>
<span id="el_sco_grama_parcela">
<span<?= $sco_grama->parcela->viewAttributes() ?>>
<?= $sco_grama->parcela->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->estatus->Visible) { // estatus ?>
        <tr id="r_estatus"<?= $sco_grama->estatus->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->estatus->caption() ?></td>
            <td<?= $sco_grama->estatus->cellAttributes() ?>>
<span id="el_sco_grama_estatus">
<span<?= $sco_grama->estatus->viewAttributes() ?>>
<?= $sco_grama->estatus->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_grama->fecha_registro->Visible) { // fecha_registro ?>
        <tr id="r_fecha_registro"<?= $sco_grama->fecha_registro->rowAttributes() ?>>
            <td class="<?= $sco_grama->TableLeftColumnClass ?>"><?= $sco_grama->fecha_registro->caption() ?></td>
            <td<?= $sco_grama->fecha_registro->cellAttributes() ?>>
<span id="el_sco_grama_fecha_registro">
<span<?= $sco_grama->fecha_registro->viewAttributes() ?>>
<?= $sco_grama->fecha_registro->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
