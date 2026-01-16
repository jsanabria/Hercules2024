<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_mttotecnicodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnicodelete")
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
<form name="fsco_mttotecnicodelete" id="fsco_mttotecnicodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_mttotecnico">
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
<?php if ($Page->Nmttotecnico->Visible) { // Nmttotecnico ?>
        <th class="<?= $Page->Nmttotecnico->headerCellClass() ?>"><span id="elh_sco_mttotecnico_Nmttotecnico" class="sco_mttotecnico_Nmttotecnico"><?= $Page->Nmttotecnico->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_mttotecnico_fecha_registro" class="sco_mttotecnico_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_solicita->Visible) { // user_solicita ?>
        <th class="<?= $Page->user_solicita->headerCellClass() ?>"><span id="elh_sco_mttotecnico_user_solicita" class="sco_mttotecnico_user_solicita"><?= $Page->user_solicita->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
        <th class="<?= $Page->tipo_solicitud->headerCellClass() ?>"><span id="elh_sco_mttotecnico_tipo_solicitud" class="sco_mttotecnico_tipo_solicitud"><?= $Page->tipo_solicitud->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <th class="<?= $Page->unidad_solicitante->headerCellClass() ?>"><span id="elh_sco_mttotecnico_unidad_solicitante" class="sco_mttotecnico_unidad_solicitante"><?= $Page->unidad_solicitante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->area_falla->Visible) { // area_falla ?>
        <th class="<?= $Page->area_falla->headerCellClass() ?>"><span id="elh_sco_mttotecnico_area_falla" class="sco_mttotecnico_area_falla"><?= $Page->area_falla->caption() ?></span></th>
<?php } ?>
<?php if ($Page->prioridad->Visible) { // prioridad ?>
        <th class="<?= $Page->prioridad->headerCellClass() ?>"><span id="elh_sco_mttotecnico_prioridad" class="sco_mttotecnico_prioridad"><?= $Page->prioridad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_mttotecnico_estatus" class="sco_mttotecnico_estatus"><?= $Page->estatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
        <th class="<?= $Page->diagnostico->headerCellClass() ?>"><span id="elh_sco_mttotecnico_diagnostico" class="sco_mttotecnico_diagnostico"><?= $Page->diagnostico->caption() ?></span></th>
<?php } ?>
<?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
        <th class="<?= $Page->requiere_materiales->headerCellClass() ?>"><span id="elh_sco_mttotecnico_requiere_materiales" class="sco_mttotecnico_requiere_materiales"><?= $Page->requiere_materiales->caption() ?></span></th>
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
<?php if ($Page->Nmttotecnico->Visible) { // Nmttotecnico ?>
        <td<?= $Page->Nmttotecnico->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nmttotecnico->viewAttributes() ?>>
<?= $Page->Nmttotecnico->getViewValue() ?></span>
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
<?php if ($Page->user_solicita->Visible) { // user_solicita ?>
        <td<?= $Page->user_solicita->cellAttributes() ?>>
<span id="">
<span<?= $Page->user_solicita->viewAttributes() ?>>
<?= $Page->user_solicita->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
        <td<?= $Page->tipo_solicitud->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_solicitud->viewAttributes() ?>>
<?= $Page->tipo_solicitud->getViewValue() ?></span>
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
<?php if ($Page->area_falla->Visible) { // area_falla ?>
        <td<?= $Page->area_falla->cellAttributes() ?>>
<span id="">
<span<?= $Page->area_falla->viewAttributes() ?>>
<?= $Page->area_falla->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->prioridad->Visible) { // prioridad ?>
        <td<?= $Page->prioridad->cellAttributes() ?>>
<span id="">
<span<?= $Page->prioridad->viewAttributes() ?>>
<?= $Page->prioridad->getViewValue() ?></span>
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
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
        <td<?= $Page->diagnostico->cellAttributes() ?>>
<span id="">
<span<?= $Page->diagnostico->viewAttributes() ?>>
<?= $Page->diagnostico->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
        <td<?= $Page->requiere_materiales->cellAttributes() ?>>
<span id="">
<span<?= $Page->requiere_materiales->viewAttributes() ?>>
<?= $Page->requiere_materiales->getViewValue() ?></span>
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
