<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteCiaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_cia: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_expediente_ciadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_ciadelete")
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
<form name="fsco_expediente_ciadelete" id="fsco_expediente_ciadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente_cia">
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
<?php if ($Page->cia->Visible) { // cia ?>
        <th class="<?= $Page->cia->headerCellClass() ?>"><span id="elh_sco_expediente_cia_cia" class="sco_expediente_cia_cia"><?= $Page->cia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
        <th class="<?= $Page->expediente->headerCellClass() ?>"><span id="elh_sco_expediente_cia_expediente" class="sco_expediente_cia_expediente"><?= $Page->expediente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><span id="elh_sco_expediente_cia_servicio_tipo" class="sco_expediente_cia_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <th class="<?= $Page->factura->headerCellClass() ?>"><span id="elh_sco_expediente_cia_factura" class="sco_expediente_cia_factura"><?= $Page->factura->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_expediente_cia_fecha" class="sco_expediente_cia_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
        <th class="<?= $Page->monto->headerCellClass() ?>"><span id="elh_sco_expediente_cia_monto" class="sco_expediente_cia_monto"><?= $Page->monto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
        <th class="<?= $Page->nota->headerCellClass() ?>"><span id="elh_sco_expediente_cia_nota" class="sco_expediente_cia_nota"><?= $Page->nota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_sco_expediente_cia__username" class="sco_expediente_cia__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_expediente_cia_estatus" class="sco_expediente_cia_estatus"><?= $Page->estatus->caption() ?></span></th>
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
<?php if ($Page->cia->Visible) { // cia ?>
        <td<?= $Page->cia->cellAttributes() ?>>
<span id="">
<span<?= $Page->cia->viewAttributes() ?>>
<?= $Page->cia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
        <td<?= $Page->expediente->cellAttributes() ?>>
<span id="">
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <td<?= $Page->factura->cellAttributes() ?>>
<span id="">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
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
<?php if ($Page->monto->Visible) { // monto ?>
        <td<?= $Page->monto->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
        <td<?= $Page->nota->cellAttributes() ?>>
<span id="">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
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
