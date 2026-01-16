<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEmailCpfDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_email_cpf: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_email_cpfdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_email_cpfdelete")
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
<form name="fsco_email_cpfdelete" id="fsco_email_cpfdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_email_cpf">
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
<?php if ($Page->Nemail_cpf->Visible) { // Nemail_cpf ?>
        <th class="<?= $Page->Nemail_cpf->headerCellClass() ?>"><span id="elh_sco_email_cpf_Nemail_cpf" class="sco_email_cpf_Nemail_cpf"><?= $Page->Nemail_cpf->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
        <th class="<?= $Page->expediente->headerCellClass() ?>"><span id="elh_sco_email_cpf_expediente" class="sco_email_cpf_expediente"><?= $Page->expediente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
        <th class="<?= $Page->fecha_hora->headerCellClass() ?>"><span id="elh_sco_email_cpf_fecha_hora" class="sco_email_cpf_fecha_hora"><?= $Page->fecha_hora->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <th class="<?= $Page->codigo->headerCellClass() ?>"><span id="elh_sco_email_cpf_codigo" class="sco_email_cpf_codigo"><?= $Page->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_sco_email_cpf__email" class="sco_email_cpf__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_email_cpf_estatus" class="sco_email_cpf_estatus"><?= $Page->estatus->caption() ?></span></th>
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
<?php if ($Page->Nemail_cpf->Visible) { // Nemail_cpf ?>
        <td<?= $Page->Nemail_cpf->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nemail_cpf->viewAttributes() ?>>
<?= $Page->Nemail_cpf->getViewValue() ?></span>
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
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
        <td<?= $Page->fecha_hora->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <td<?= $Page->codigo->cellAttributes() ?>>
<span id="">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
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
