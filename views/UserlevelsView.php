<?php

namespace PHPMaker2024\hercules;

// Page object
$UserlevelsView = &$Page;
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
<form name="fuserlevelsview" id="fuserlevelsview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fuserlevelsview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fuserlevelsview")
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
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
    <tr id="r_userlevelname"<?= $Page->userlevelname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_userlevelname"><?= $Page->userlevelname->caption() ?></span></td>
        <td data-name="userlevelname"<?= $Page->userlevelname->cellAttributes() ?>>
<span id="el_userlevels_userlevelname">
<span<?= $Page->userlevelname->viewAttributes() ?>>
<?= $Page->userlevelname->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reserva->Visible) { // reserva ?>
    <tr id="r_reserva"<?= $Page->reserva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_reserva"><?= $Page->reserva->caption() ?></span></td>
        <td data-name="reserva"<?= $Page->reserva->cellAttributes() ?>>
<span id="el_userlevels_reserva">
<span<?= $Page->reserva->viewAttributes() ?>>
<?= $Page->reserva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->indicador->Visible) { // indicador ?>
    <tr id="r_indicador"<?= $Page->indicador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_indicador"><?= $Page->indicador->caption() ?></span></td>
        <td data-name="indicador"<?= $Page->indicador->cellAttributes() ?>>
<span id="el_userlevels_indicador">
<span<?= $Page->indicador->viewAttributes() ?>>
<?= $Page->indicador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
    <tr id="r_tipo_proveedor"<?= $Page->tipo_proveedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_tipo_proveedor"><?= $Page->tipo_proveedor->caption() ?></span></td>
        <td data-name="tipo_proveedor"<?= $Page->tipo_proveedor->cellAttributes() ?>>
<span id="el_userlevels_tipo_proveedor">
<span<?= $Page->tipo_proveedor->viewAttributes() ?>>
<?= $Page->tipo_proveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ver_alertas->Visible) { // ver_alertas ?>
    <tr id="r_ver_alertas"<?= $Page->ver_alertas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_ver_alertas"><?= $Page->ver_alertas->caption() ?></span></td>
        <td data-name="ver_alertas"<?= $Page->ver_alertas->cellAttributes() ?>>
<span id="el_userlevels_ver_alertas">
<span<?= $Page->ver_alertas->viewAttributes() ?>>
<?= $Page->ver_alertas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->financiero->Visible) { // financiero ?>
    <tr id="r_financiero"<?= $Page->financiero->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_financiero"><?= $Page->financiero->caption() ?></span></td>
        <td data-name="financiero"<?= $Page->financiero->cellAttributes() ?>>
<span id="el_userlevels_financiero">
<span<?= $Page->financiero->viewAttributes() ?>>
<?= $Page->financiero->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_grupo_funciones", explode(",", $Page->getCurrentDetailTable())) && $sco_grupo_funciones->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grupo_funciones", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGrupoFuncionesGrid.php" ?>
<?php } ?>
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
