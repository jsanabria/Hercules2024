<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoProveedorDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_proveedor: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_proveedordelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_proveedordelete")
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
<form name="fsco_proveedordelete" id="fsco_proveedordelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_proveedor">
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
<?php if ($Page->Nproveedor->Visible) { // Nproveedor ?>
        <th class="<?= $Page->Nproveedor->headerCellClass() ?>"><span id="elh_sco_proveedor_Nproveedor" class="sco_proveedor_Nproveedor"><?= $Page->Nproveedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rif->Visible) { // rif ?>
        <th class="<?= $Page->rif->headerCellClass() ?>"><span id="elh_sco_proveedor_rif" class="sco_proveedor_rif"><?= $Page->rif->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
        <th class="<?= $Page->nombre->headerCellClass() ?>"><span id="elh_sco_proveedor_nombre" class="sco_proveedor_nombre"><?= $Page->nombre->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
        <th class="<?= $Page->tipo_proveedor->headerCellClass() ?>"><span id="elh_sco_proveedor_tipo_proveedor" class="sco_proveedor_tipo_proveedor"><?= $Page->tipo_proveedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_sco_proveedor_activo" class="sco_proveedor_activo"><?= $Page->activo->caption() ?></span></th>
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
<?php if ($Page->Nproveedor->Visible) { // Nproveedor ?>
        <td<?= $Page->Nproveedor->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nproveedor->viewAttributes() ?>>
<?= $Page->Nproveedor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rif->Visible) { // rif ?>
        <td<?= $Page->rif->cellAttributes() ?>>
<span id="">
<span<?= $Page->rif->viewAttributes() ?>>
<?= $Page->rif->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
        <td<?= $Page->nombre->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
        <td<?= $Page->tipo_proveedor->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_proveedor->viewAttributes() ?>>
<?= $Page->tipo_proveedor->getViewValue() ?></span>
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
