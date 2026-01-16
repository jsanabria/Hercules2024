<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGramaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_grama: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_gramadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_gramadelete")
        .setPageId("delete")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_gramadelete" id="fsco_gramadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_grama">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->Ngrama->Visible) { // Ngrama ?>
        <th class="<?= $Page->Ngrama->headerCellClass() ?>"><span id="elh_sco_grama_Ngrama" class="sco_grama_Ngrama"><?= $Page->Ngrama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ci_solicitante->Visible) { // ci_solicitante ?>
        <th class="<?= $Page->ci_solicitante->headerCellClass() ?>"><span id="elh_sco_grama_ci_solicitante" class="sco_grama_ci_solicitante"><?= $Page->ci_solicitante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
        <th class="<?= $Page->solicitante->headerCellClass() ?>"><span id="elh_sco_grama_solicitante" class="sco_grama_solicitante"><?= $Page->solicitante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><span id="elh_sco_grama_tipo" class="sco_grama_tipo"><?= $Page->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
        <th class="<?= $Page->monto->headerCellClass() ?>"><span id="elh_sco_grama_monto" class="sco_grama_monto"><?= $Page->monto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <th class="<?= $Page->contrato->headerCellClass() ?>"><span id="elh_sco_grama_contrato" class="sco_grama_contrato"><?= $Page->contrato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th class="<?= $Page->seccion->headerCellClass() ?>"><span id="elh_sco_grama_seccion" class="sco_grama_seccion"><?= $Page->seccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th class="<?= $Page->modulo->headerCellClass() ?>"><span id="elh_sco_grama_modulo" class="sco_grama_modulo"><?= $Page->modulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <th class="<?= $Page->sub_seccion->headerCellClass() ?>"><span id="elh_sco_grama_sub_seccion" class="sco_grama_sub_seccion"><?= $Page->sub_seccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th class="<?= $Page->parcela->headerCellClass() ?>"><span id="elh_sco_grama_parcela" class="sco_grama_parcela"><?= $Page->parcela->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_grama_estatus" class="sco_grama_estatus"><?= $Page->estatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_grama_fecha_registro" class="sco_grama_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->Ngrama->Visible) { // Ngrama ?>
        <td<?= $Page->Ngrama->cellAttributes() ?>>
<span id="">
<span<?= $Page->Ngrama->viewAttributes() ?>>
<?= $Page->Ngrama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ci_solicitante->Visible) { // ci_solicitante ?>
        <td<?= $Page->ci_solicitante->cellAttributes() ?>>
<span id="">
<span<?= $Page->ci_solicitante->viewAttributes() ?>>
<?= $Page->ci_solicitante->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
        <td<?= $Page->solicitante->cellAttributes() ?>>
<span id="">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <td<?= $Page->tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
        <td<?= $Page->monto->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <td<?= $Page->contrato->cellAttributes() ?>>
<span id="">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <td<?= $Page->seccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <td<?= $Page->modulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <td<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <td<?= $Page->parcela->cellAttributes() ?>>
<span id="">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <td<?= $Page->estatus->cellAttributes() ?>>
<span id="">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
