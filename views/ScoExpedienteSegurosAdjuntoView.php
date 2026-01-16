<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteSegurosAdjuntoView = &$Page;
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
<form name="fsco_expediente_seguros_adjuntoview" id="fsco_expediente_seguros_adjuntoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_seguros_adjunto: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_expediente_seguros_adjuntoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_seguros_adjuntoview")
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
<input type="hidden" name="t" value="sco_expediente_seguros_adjunto">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nexpediente_seguros_adjunto->Visible) { // Nexpediente_seguros_adjunto ?>
    <tr id="r_Nexpediente_seguros_adjunto"<?= $Page->Nexpediente_seguros_adjunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_adjunto_Nexpediente_seguros_adjunto"><?= $Page->Nexpediente_seguros_adjunto->caption() ?></span></td>
        <td data-name="Nexpediente_seguros_adjunto"<?= $Page->Nexpediente_seguros_adjunto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_Nexpediente_seguros_adjunto">
<span<?= $Page->Nexpediente_seguros_adjunto->viewAttributes() ?>>
<?= $Page->Nexpediente_seguros_adjunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expediente_seguros->Visible) { // expediente_seguros ?>
    <tr id="r_expediente_seguros"<?= $Page->expediente_seguros->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_adjunto_expediente_seguros"><?= $Page->expediente_seguros->caption() ?></span></td>
        <td data-name="expediente_seguros"<?= $Page->expediente_seguros->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_expediente_seguros">
<span<?= $Page->expediente_seguros->viewAttributes() ?>>
<?= $Page->expediente_seguros->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <tr id="r_archivo"<?= $Page->archivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_adjunto_archivo"><?= $Page->archivo->caption() ?></span></td>
        <td data-name="archivo"<?= $Page->archivo->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_archivo">
<span>
<?= GetFileViewTag($Page->archivo, $Page->archivo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_adjunto_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
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
