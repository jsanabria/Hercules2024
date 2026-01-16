<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoSmsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="fsco_smsview" id="fsco_smsview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_sms: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_smsview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_smsview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_sms">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nsms->Visible) { // Nsms ?>
    <tr id="r_Nsms"<?= $Page->Nsms->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_Nsms"><?= $Page->Nsms->caption() ?></span></td>
        <td data-name="Nsms"<?= $Page->Nsms->cellAttributes() ?>>
<span id="el_sco_sms_Nsms">
<span<?= $Page->Nsms->viewAttributes() ?>>
<?= $Page->Nsms->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->celular->Visible) { // celular ?>
    <tr id="r_celular"<?= $Page->celular->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_celular"><?= $Page->celular->caption() ?></span></td>
        <td data-name="celular"<?= $Page->celular->cellAttributes() ?>>
<span id="el_sco_sms_celular">
<span<?= $Page->celular->viewAttributes() ?>>
<?= $Page->celular->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comando->Visible) { // comando ?>
    <tr id="r_comando"<?= $Page->comando->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_comando"><?= $Page->comando->caption() ?></span></td>
        <td data-name="comando"<?= $Page->comando->cellAttributes() ?>>
<span id="el_sco_sms_comando">
<span<?= $Page->comando->viewAttributes() ?>>
<?= $Page->comando->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <tr id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_cedula"><?= $Page->cedula->caption() ?></span></td>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el_sco_sms_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <tr id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_titular"><?= $Page->titular->caption() ?></span></td>
        <td data-name="titular"<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_sms_titular">
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->texto->Visible) { // texto ?>
    <tr id="r_texto"<?= $Page->texto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_texto"><?= $Page->texto->caption() ?></span></td>
        <td data-name="texto"<?= $Page->texto->cellAttributes() ?>>
<span id="el_sco_sms_texto">
<span<?= $Page->texto->viewAttributes() ?>>
<?= $Page->texto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_sms_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_sms_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
