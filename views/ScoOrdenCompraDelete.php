<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_orden_compradelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compradelete")
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
<form name="fsco_orden_compradelete" id="fsco_orden_compradelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden_compra">
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
<?php if ($Page->Norden_compra->Visible) { // Norden_compra ?>
        <th class="<?= $Page->Norden_compra->headerCellClass() ?>"><span id="elh_sco_orden_compra_Norden_compra" class="sco_orden_compra_Norden_compra"><?= $Page->Norden_compra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_orden_compra_fecha" class="sco_orden_compra_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_sco_orden_compra__username" class="sco_orden_compra__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <th class="<?= $Page->unidad_solicitante->headerCellClass() ?>"><span id="elh_sco_orden_compra_unidad_solicitante" class="sco_orden_compra_unidad_solicitante"><?= $Page->unidad_solicitante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_orden_compra_estatus" class="sco_orden_compra_estatus"><?= $Page->estatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->username_estatus->Visible) { // username_estatus ?>
        <th class="<?= $Page->username_estatus->headerCellClass() ?>"><span id="elh_sco_orden_compra_username_estatus" class="sco_orden_compra_username_estatus"><?= $Page->username_estatus->caption() ?></span></th>
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
<?php if ($Page->Norden_compra->Visible) { // Norden_compra ?>
        <td<?= $Page->Norden_compra->cellAttributes() ?>>
<span id="">
<span<?= $Page->Norden_compra->viewAttributes() ?>>
<?= $Page->Norden_compra->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <td<?= $Page->fecha->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td<?= $Page->_username->cellAttributes() ?>>
<span id="">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <td<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="">
<span<?= $Page->unidad_solicitante->viewAttributes() ?>>
<?= $Page->unidad_solicitante->getViewValue() ?></span>
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
<?php if ($Page->username_estatus->Visible) { // username_estatus ?>
        <td<?= $Page->username_estatus->cellAttributes() ?>>
<span id="">
<span<?= $Page->username_estatus->viewAttributes() ?>>
<?= $Page->username_estatus->getViewValue() ?></span>
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
