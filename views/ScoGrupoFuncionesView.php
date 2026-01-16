<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGrupoFuncionesView = &$Page;
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
<form name="fsco_grupo_funcionesview" id="fsco_grupo_funcionesview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_grupo_funciones: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_grupo_funcionesview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_grupo_funcionesview")
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
<input type="hidden" name="t" value="sco_grupo_funciones">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Ngrupo_funciones->Visible) { // Ngrupo_funciones ?>
    <tr id="r_Ngrupo_funciones"<?= $Page->Ngrupo_funciones->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grupo_funciones_Ngrupo_funciones"><?= $Page->Ngrupo_funciones->caption() ?></span></td>
        <td data-name="Ngrupo_funciones"<?= $Page->Ngrupo_funciones->cellAttributes() ?>>
<span id="el_sco_grupo_funciones_Ngrupo_funciones">
<span<?= $Page->Ngrupo_funciones->viewAttributes() ?>>
<?= $Page->Ngrupo_funciones->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funcion->Visible) { // funcion ?>
    <tr id="r_funcion"<?= $Page->funcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grupo_funciones_funcion"><?= $Page->funcion->caption() ?></span></td>
        <td data-name="funcion"<?= $Page->funcion->cellAttributes() ?>>
<span id="el_sco_grupo_funciones_funcion">
<span<?= $Page->funcion->viewAttributes() ?>>
<?= $Page->funcion->getViewValue() ?></span>
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
