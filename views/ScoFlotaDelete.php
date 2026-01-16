<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_flotadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flotadelete")
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
<form name="fsco_flotadelete" id="fsco_flotadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_flota">
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
<?php if ($Page->tipo_flota->Visible) { // tipo_flota ?>
        <th class="<?= $Page->tipo_flota->headerCellClass() ?>"><span id="elh_sco_flota_tipo_flota" class="sco_flota_tipo_flota"><?= $Page->tipo_flota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->marca->Visible) { // marca ?>
        <th class="<?= $Page->marca->headerCellClass() ?>"><span id="elh_sco_flota_marca" class="sco_flota_marca"><?= $Page->marca->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modelo->Visible) { // modelo ?>
        <th class="<?= $Page->modelo->headerCellClass() ?>"><span id="elh_sco_flota_modelo" class="sco_flota_modelo"><?= $Page->modelo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
        <th class="<?= $Page->placa->headerCellClass() ?>"><span id="elh_sco_flota_placa" class="sco_flota_placa"><?= $Page->placa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
        <th class="<?= $Page->color->headerCellClass() ?>"><span id="elh_sco_flota_color" class="sco_flota_color"><?= $Page->color->caption() ?></span></th>
<?php } ?>
<?php if ($Page->anho->Visible) { // anho ?>
        <th class="<?= $Page->anho->headerCellClass() ?>"><span id="elh_sco_flota_anho" class="sco_flota_anho"><?= $Page->anho->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><span id="elh_sco_flota_tipo" class="sco_flota_tipo"><?= $Page->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->conductor->Visible) { // conductor ?>
        <th class="<?= $Page->conductor->headerCellClass() ?>"><span id="elh_sco_flota_conductor" class="sco_flota_conductor"><?= $Page->conductor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_sco_flota_activo" class="sco_flota_activo"><?= $Page->activo->caption() ?></span></th>
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
<?php if ($Page->tipo_flota->Visible) { // tipo_flota ?>
        <td<?= $Page->tipo_flota->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_flota->viewAttributes() ?>>
<?= $Page->tipo_flota->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->marca->Visible) { // marca ?>
        <td<?= $Page->marca->cellAttributes() ?>>
<span id="">
<span<?= $Page->marca->viewAttributes() ?>>
<?= $Page->marca->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->modelo->Visible) { // modelo ?>
        <td<?= $Page->modelo->cellAttributes() ?>>
<span id="">
<span<?= $Page->modelo->viewAttributes() ?>>
<?= $Page->modelo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
        <td<?= $Page->placa->cellAttributes() ?>>
<span id="">
<span<?= $Page->placa->viewAttributes() ?>>
<?= $Page->placa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
        <td<?= $Page->color->cellAttributes() ?>>
<span id="">
<span<?= $Page->color->viewAttributes() ?>>
<?= $Page->color->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->anho->Visible) { // anho ?>
        <td<?= $Page->anho->cellAttributes() ?>>
<span id="">
<span<?= $Page->anho->viewAttributes() ?>>
<?= $Page->anho->getViewValue() ?></span>
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
<?php if ($Page->conductor->Visible) { // conductor ?>
        <td<?= $Page->conductor->cellAttributes() ?>>
<span id="">
<span<?= $Page->conductor->viewAttributes() ?>>
<?= $Page->conductor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <td<?= $Page->activo->cellAttributes() ?>>
<span id="">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
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
