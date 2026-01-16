<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenSalidaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_salida: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_orden_salidadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_salidadelete")
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
<form name="fsco_orden_salidadelete" id="fsco_orden_salidadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden_salida">
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
<?php if ($Page->Norden_salida->Visible) { // Norden_salida ?>
        <th class="<?= $Page->Norden_salida->headerCellClass() ?>"><span id="elh_sco_orden_salida_Norden_salida" class="sco_orden_salida_Norden_salida"><?= $Page->Norden_salida->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
        <th class="<?= $Page->fecha_hora->headerCellClass() ?>"><span id="elh_sco_orden_salida_fecha_hora" class="sco_orden_salida_fecha_hora"><?= $Page->fecha_hora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_sco_orden_salida__username" class="sco_orden_salida__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->conductor->Visible) { // conductor ?>
        <th class="<?= $Page->conductor->headerCellClass() ?>"><span id="elh_sco_orden_salida_conductor" class="sco_orden_salida_conductor"><?= $Page->conductor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
        <th class="<?= $Page->placa->headerCellClass() ?>"><span id="elh_sco_orden_salida_placa" class="sco_orden_salida_placa"><?= $Page->placa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
        <th class="<?= $Page->motivo->headerCellClass() ?>"><span id="elh_sco_orden_salida_motivo" class="sco_orden_salida_motivo"><?= $Page->motivo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->autoriza->Visible) { // autoriza ?>
        <th class="<?= $Page->autoriza->headerCellClass() ?>"><span id="elh_sco_orden_salida_autoriza" class="sco_orden_salida_autoriza"><?= $Page->autoriza->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_orden_salida_estatus" class="sco_orden_salida_estatus"><?= $Page->estatus->caption() ?></span></th>
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
<?php if ($Page->Norden_salida->Visible) { // Norden_salida ?>
        <td<?= $Page->Norden_salida->cellAttributes() ?>>
<span id="">
<span<?= $Page->Norden_salida->viewAttributes() ?>>
<?= $Page->Norden_salida->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
        <td<?= $Page->fecha_hora->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
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
<?php if ($Page->conductor->Visible) { // conductor ?>
        <td<?= $Page->conductor->cellAttributes() ?>>
<span id="">
<span<?= $Page->conductor->viewAttributes() ?>>
<?= $Page->conductor->getViewValue() ?></span>
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
<?php if ($Page->motivo->Visible) { // motivo ?>
        <td<?= $Page->motivo->cellAttributes() ?>>
<span id="">
<span<?= $Page->motivo->viewAttributes() ?>>
<?= $Page->motivo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->autoriza->Visible) { // autoriza ?>
        <td<?= $Page->autoriza->cellAttributes() ?>>
<span id="">
<span<?= $Page->autoriza->viewAttributes() ?>>
<?= $Page->autoriza->getViewValue() ?></span>
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
