<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoAlertasDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_alertas: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_alertasdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_alertasdelete")
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
<form name="fsco_alertasdelete" id="fsco_alertasdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_alertas">
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
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_alertas_fecha" class="sco_alertas_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_end->Visible) { // fecha_end ?>
        <th class="<?= $Page->fecha_end->headerCellClass() ?>"><span id="elh_sco_alertas_fecha_end" class="sco_alertas_fecha_end"><?= $Page->fecha_end->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion_corta->Visible) { // descripcion_corta ?>
        <th class="<?= $Page->descripcion_corta->headerCellClass() ?>"><span id="elh_sco_alertas_descripcion_corta" class="sco_alertas_descripcion_corta"><?= $Page->descripcion_corta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion_larga->Visible) { // descripcion_larga ?>
        <th class="<?= $Page->descripcion_larga->headerCellClass() ?>"><span id="elh_sco_alertas_descripcion_larga" class="sco_alertas_descripcion_larga"><?= $Page->descripcion_larga->caption() ?></span></th>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
        <th class="<?= $Page->orden->headerCellClass() ?>"><span id="elh_sco_alertas_orden" class="sco_alertas_orden"><?= $Page->orden->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_sco_alertas_activo" class="sco_alertas_activo"><?= $Page->activo->caption() ?></span></th>
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
<?php if ($Page->fecha->Visible) { // fecha ?>
        <td<?= $Page->fecha->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_end->Visible) { // fecha_end ?>
        <td<?= $Page->fecha_end->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_end->viewAttributes() ?>>
<?= $Page->fecha_end->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descripcion_corta->Visible) { // descripcion_corta ?>
        <td<?= $Page->descripcion_corta->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion_corta->viewAttributes() ?>>
<?= $Page->descripcion_corta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descripcion_larga->Visible) { // descripcion_larga ?>
        <td<?= $Page->descripcion_larga->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion_larga->viewAttributes() ?>>
<?= $Page->descripcion_larga->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
        <td<?= $Page->orden->cellAttributes() ?>>
<span id="">
<span<?= $Page->orden->viewAttributes() ?>>
<?= $Page->orden->getViewValue() ?></span>
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
