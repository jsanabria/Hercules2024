<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoNotasView = &$Page;
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
<form name="fsco_mttotecnico_notasview" id="fsco_mttotecnico_notasview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico_notas: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_mttotecnico_notasview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnico_notasview")
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
<input type="hidden" name="t" value="sco_mttotecnico_notas">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nmttotecnico_notas->Visible) { // Nmttotecnico_notas ?>
    <tr id="r_Nmttotecnico_notas"<?= $Page->Nmttotecnico_notas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_notas_Nmttotecnico_notas"><?= $Page->Nmttotecnico_notas->caption() ?></span></td>
        <td data-name="Nmttotecnico_notas"<?= $Page->Nmttotecnico_notas->cellAttributes() ?>>
<span id="el_sco_mttotecnico_notas_Nmttotecnico_notas">
<span<?= $Page->Nmttotecnico_notas->viewAttributes() ?>>
<?= $Page->Nmttotecnico_notas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mttotecnico->Visible) { // mttotecnico ?>
    <tr id="r_mttotecnico"<?= $Page->mttotecnico->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_notas_mttotecnico"><?= $Page->mttotecnico->caption() ?></span></td>
        <td data-name="mttotecnico"<?= $Page->mttotecnico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_notas_mttotecnico">
<span<?= $Page->mttotecnico->viewAttributes() ?>>
<?= $Page->mttotecnico->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_notas_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_mttotecnico_notas_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_notas__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_mttotecnico_notas__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
    <tr id="r_fecha_hora"<?= $Page->fecha_hora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_notas_fecha_hora"><?= $Page->fecha_hora->caption() ?></span></td>
        <td data-name="fecha_hora"<?= $Page->fecha_hora->cellAttributes() ?>>
<span id="el_sco_mttotecnico_notas_fecha_hora">
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
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
