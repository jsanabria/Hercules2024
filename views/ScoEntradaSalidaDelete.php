<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEntradaSalidaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_entrada_salida: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_entrada_salidadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_entrada_salidadelete")
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
<form name="fsco_entrada_salidadelete" id="fsco_entrada_salidadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_entrada_salida">
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
<?php if ($Page->tipo_doc->Visible) { // tipo_doc ?>
        <th class="<?= $Page->tipo_doc->headerCellClass() ?>"><span id="elh_sco_entrada_salida_tipo_doc" class="sco_entrada_salida_tipo_doc"><?= $Page->tipo_doc->caption() ?></span></th>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <th class="<?= $Page->proveedor->headerCellClass() ?>"><span id="elh_sco_entrada_salida_proveedor" class="sco_entrada_salida_proveedor"><?= $Page->proveedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->clasificacion->Visible) { // clasificacion ?>
        <th class="<?= $Page->clasificacion->headerCellClass() ?>"><span id="elh_sco_entrada_salida_clasificacion" class="sco_entrada_salida_clasificacion"><?= $Page->clasificacion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->documento->Visible) { // documento ?>
        <th class="<?= $Page->documento->headerCellClass() ?>"><span id="elh_sco_entrada_salida_documento" class="sco_entrada_salida_documento"><?= $Page->documento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_entrada_salida_fecha" class="sco_entrada_salida_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_sco_entrada_salida__username" class="sco_entrada_salida__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
        <th class="<?= $Page->monto->headerCellClass() ?>"><span id="elh_sco_entrada_salida_monto" class="sco_entrada_salida_monto"><?= $Page->monto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
        <th class="<?= $Page->registro->headerCellClass() ?>"><span id="elh_sco_entrada_salida_registro" class="sco_entrada_salida_registro"><?= $Page->registro->caption() ?></span></th>
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
<?php if ($Page->tipo_doc->Visible) { // tipo_doc ?>
        <td<?= $Page->tipo_doc->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_doc->viewAttributes() ?>>
<?= $Page->tipo_doc->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <td<?= $Page->proveedor->cellAttributes() ?>>
<span id="">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->clasificacion->Visible) { // clasificacion ?>
        <td<?= $Page->clasificacion->cellAttributes() ?>>
<span id="">
<span<?= $Page->clasificacion->viewAttributes() ?>>
<?= $Page->clasificacion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->documento->Visible) { // documento ?>
        <td<?= $Page->documento->cellAttributes() ?>>
<span id="">
<span<?= $Page->documento->viewAttributes() ?>>
<?= $Page->documento->getViewValue() ?></span>
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
<?php if ($Page->monto->Visible) { // monto ?>
        <td<?= $Page->monto->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
        <td<?= $Page->registro->cellAttributes() ?>>
<span id="">
<span<?= $Page->registro->viewAttributes() ?>>
<?= $Page->registro->getViewValue() ?></span>
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
