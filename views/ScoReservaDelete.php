<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReservaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_reserva: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_reservadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reservadelete")
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
<form name="fsco_reservadelete" id="fsco_reservadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_reserva">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_sco_reserva_id" class="sco_reserva_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
        <th class="<?= $Page->capilla->headerCellClass() ?>"><span id="elh_sco_reserva_capilla" class="sco_reserva_capilla"><?= $Page->capilla->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
        <th class="<?= $Page->fecha_inicio->headerCellClass() ?>"><span id="elh_sco_reserva_fecha_inicio" class="sco_reserva_fecha_inicio"><?= $Page->fecha_inicio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
        <th class="<?= $Page->hora_inicio->headerCellClass() ?>"><span id="elh_sco_reserva_hora_inicio" class="sco_reserva_hora_inicio"><?= $Page->hora_inicio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <th class="<?= $Page->user_registra->headerCellClass() ?>"><span id="elh_sco_reserva_user_registra" class="sco_reserva_user_registra"><?= $Page->user_registra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->localidad->Visible) { // localidad ?>
        <th class="<?= $Page->localidad->headerCellClass() ?>"><span id="elh_sco_reserva_localidad" class="sco_reserva_localidad"><?= $Page->localidad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
        <th class="<?= $Page->fecha_fin->headerCellClass() ?>"><span id="elh_sco_reserva_fecha_fin" class="sco_reserva_fecha_fin"><?= $Page->fecha_fin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <th class="<?= $Page->hora_fin->headerCellClass() ?>"><span id="elh_sco_reserva_hora_fin" class="sco_reserva_hora_fin"><?= $Page->hora_fin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
        <th class="<?= $Page->motivo->headerCellClass() ?>"><span id="elh_sco_reserva_motivo" class="sco_reserva_motivo"><?= $Page->motivo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_reserva_fecha_registro" class="sco_reserva_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
        <td<?= $Page->capilla->cellAttributes() ?>>
<span id="">
<span<?= $Page->capilla->viewAttributes() ?>>
<?= $Page->capilla->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
        <td<?= $Page->fecha_inicio->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_inicio->viewAttributes() ?>>
<?= $Page->fecha_inicio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
        <td<?= $Page->hora_inicio->cellAttributes() ?>>
<span id="">
<span<?= $Page->hora_inicio->viewAttributes() ?>>
<?= $Page->hora_inicio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <td<?= $Page->user_registra->cellAttributes() ?>>
<span id="">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->localidad->Visible) { // localidad ?>
        <td<?= $Page->localidad->cellAttributes() ?>>
<span id="">
<span<?= $Page->localidad->viewAttributes() ?>>
<?= $Page->localidad->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
        <td<?= $Page->fecha_fin->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_fin->viewAttributes() ?>>
<?= $Page->fecha_fin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <td<?= $Page->hora_fin->cellAttributes() ?>>
<span id="">
<span<?= $Page->hora_fin->viewAttributes() ?>>
<?= $Page->hora_fin->getViewValue() ?></span>
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
