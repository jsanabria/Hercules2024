<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoBloqueHorarioDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_bloque_horario: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_bloque_horariodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_bloque_horariodelete")
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
<form name="fsco_bloque_horariodelete" id="fsco_bloque_horariodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_bloque_horario">
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><span id="elh_sco_bloque_horario_servicio_tipo" class="sco_bloque_horario_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hora->Visible) { // hora ?>
        <th class="<?= $Page->hora->headerCellClass() ?>"><span id="elh_sco_bloque_horario_hora" class="sco_bloque_horario_hora"><?= $Page->hora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bloque->Visible) { // bloque ?>
        <th class="<?= $Page->bloque->headerCellClass() ?>"><span id="elh_sco_bloque_horario_bloque" class="sco_bloque_horario_bloque"><?= $Page->bloque->caption() ?></span></th>
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hora->Visible) { // hora ?>
        <td<?= $Page->hora->cellAttributes() ?>>
<span id="">
<span<?= $Page->hora->viewAttributes() ?>>
<?= $Page->hora->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bloque->Visible) { // bloque ?>
        <td<?= $Page->bloque->cellAttributes() ?>>
<span id="">
<span<?= $Page->bloque->viewAttributes() ?>>
<?= $Page->bloque->getViewValue() ?></span>
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
