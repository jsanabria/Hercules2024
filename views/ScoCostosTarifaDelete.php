<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_costos_tarifadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifadelete")
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
<form name="fsco_costos_tarifadelete" id="fsco_costos_tarifadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos_tarifa">
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
<?php if ($Page->localidad->Visible) { // localidad ?>
        <th class="<?= $Page->localidad->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_localidad" class="sco_costos_tarifa_localidad"><?= $Page->localidad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_servicio->Visible) { // tipo_servicio ?>
        <th class="<?= $Page->tipo_servicio->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_tipo_servicio" class="sco_costos_tarifa_tipo_servicio"><?= $Page->tipo_servicio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
        <th class="<?= $Page->horas->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_horas" class="sco_costos_tarifa_horas"><?= $Page->horas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_activo" class="sco_costos_tarifa_activo"><?= $Page->activo->caption() ?></span></th>
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
<?php if ($Page->localidad->Visible) { // localidad ?>
        <td<?= $Page->localidad->cellAttributes() ?>>
<span id="">
<span<?= $Page->localidad->viewAttributes() ?>>
<?= $Page->localidad->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_servicio->Visible) { // tipo_servicio ?>
        <td<?= $Page->tipo_servicio->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_servicio->viewAttributes() ?>>
<?= $Page->tipo_servicio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
        <td<?= $Page->horas->cellAttributes() ?>>
<span id="">
<span<?= $Page->horas->viewAttributes() ?>>
<?= $Page->horas->getViewValue() ?></span>
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
