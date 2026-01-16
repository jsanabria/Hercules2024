<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoChatDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_chat: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_chatdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_chatdelete")
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
<form name="fsco_chatdelete" id="fsco_chatdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_chat">
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
<?php if ($Page->Nchat->Visible) { // Nchat ?>
        <th class="<?= $Page->Nchat->headerCellClass() ?>"><span id="elh_sco_chat_Nchat" class="sco_chat_Nchat"><?= $Page->Nchat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_chat_fecha" class="sco_chat_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_sco_chat__username" class="sco_chat__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->texto->Visible) { // texto ?>
        <th class="<?= $Page->texto->headerCellClass() ?>"><span id="elh_sco_chat_texto" class="sco_chat_texto"><?= $Page->texto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->a_username->Visible) { // a_username ?>
        <th class="<?= $Page->a_username->headerCellClass() ?>"><span id="elh_sco_chat_a_username" class="sco_chat_a_username"><?= $Page->a_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->leido->Visible) { // leido ?>
        <th class="<?= $Page->leido->headerCellClass() ?>"><span id="elh_sco_chat_leido" class="sco_chat_leido"><?= $Page->leido->caption() ?></span></th>
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
<?php if ($Page->Nchat->Visible) { // Nchat ?>
        <td<?= $Page->Nchat->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nchat->viewAttributes() ?>>
<?= $Page->Nchat->getViewValue() ?></span>
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
<?php if ($Page->texto->Visible) { // texto ?>
        <td<?= $Page->texto->cellAttributes() ?>>
<span id="">
<span<?= $Page->texto->viewAttributes() ?>>
<?= $Page->texto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->a_username->Visible) { // a_username ?>
        <td<?= $Page->a_username->cellAttributes() ?>>
<span id="">
<span<?= $Page->a_username->viewAttributes() ?>>
<?= $Page->a_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->leido->Visible) { // leido ?>
        <td<?= $Page->leido->cellAttributes() ?>>
<span id="">
<span<?= $Page->leido->viewAttributes() ?>>
<?= $Page->leido->getViewValue() ?></span>
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
