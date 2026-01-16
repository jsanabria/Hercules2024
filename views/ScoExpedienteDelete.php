<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_expedientedelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expedientedelete")
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
<form name="fsco_expedientedelete" id="fsco_expedientedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente">
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
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <th class="<?= $Page->Nexpediente->headerCellClass() ?>"><span id="elh_sco_expediente_Nexpediente" class="sco_expediente_Nexpediente"><?= $Page->Nexpediente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <th class="<?= $Page->nombre_contacto->headerCellClass() ?>"><span id="elh_sco_expediente_nombre_contacto" class="sco_expediente_nombre_contacto"><?= $Page->nombre_contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_cedula_fallecido" class="sco_expediente_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_nombre_fallecido" class="sco_expediente_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_apellidos_fallecido" class="sco_expediente_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <th class="<?= $Page->causa_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_causa_ocurrencia" class="sco_expediente_causa_ocurrencia"><?= $Page->causa_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
        <th class="<?= $Page->venta->headerCellClass() ?>"><span id="elh_sco_expediente_venta" class="sco_expediente_venta"><?= $Page->venta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <th class="<?= $Page->user_registra->headerCellClass() ?>"><span id="elh_sco_expediente_user_registra" class="sco_expediente_user_registra"><?= $Page->user_registra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_expediente_fecha_registro" class="sco_expediente_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_expediente_estatus" class="sco_expediente_estatus"><?= $Page->estatus->caption() ?></span></th>
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
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <td<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?= $Page->Nexpediente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <td<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <td<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
        <td<?= $Page->venta->cellAttributes() ?>>
<span id="">
<span<?= $Page->venta->viewAttributes() ?>>
<?= $Page->venta->getViewValue() ?></span>
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
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
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
