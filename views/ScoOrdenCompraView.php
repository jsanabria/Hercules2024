<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraView = &$Page;
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
<form name="fsco_orden_compraview" id="fsco_orden_compraview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_orden_compraview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compraview")
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
<input type="hidden" name="t" value="sco_orden_compra">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Norden_compra->Visible) { // Norden_compra ?>
    <tr id="r_Norden_compra"<?= $Page->Norden_compra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_Norden_compra"><?= $Page->Norden_compra->caption() ?></span></td>
        <td data-name="Norden_compra"<?= $Page->Norden_compra->cellAttributes() ?>>
<span id="el_sco_orden_compra_Norden_compra">
<span<?= $Page->Norden_compra->viewAttributes() ?>>
<?= $Page->Norden_compra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_orden_compra_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_orden_compra__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
    <tr id="r_unidad_solicitante"<?= $Page->unidad_solicitante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_unidad_solicitante"><?= $Page->unidad_solicitante->caption() ?></span></td>
        <td data-name="unidad_solicitante"<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_orden_compra_unidad_solicitante">
<span<?= $Page->unidad_solicitante->viewAttributes() ?>>
<?= $Page->unidad_solicitante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_orden_compra_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_orden_compra_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->username_estatus->Visible) { // username_estatus ?>
    <tr id="r_username_estatus"<?= $Page->username_estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_username_estatus"><?= $Page->username_estatus->caption() ?></span></td>
        <td data-name="username_estatus"<?= $Page->username_estatus->cellAttributes() ?>>
<span id="el_sco_orden_compra_username_estatus">
<span<?= $Page->username_estatus->viewAttributes() ?>>
<?= $Page->username_estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_aprobacion->Visible) { // fecha_aprobacion ?>
    <tr id="r_fecha_aprobacion"<?= $Page->fecha_aprobacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_fecha_aprobacion"><?= $Page->fecha_aprobacion->caption() ?></span></td>
        <td data-name="fecha_aprobacion"<?= $Page->fecha_aprobacion->cellAttributes() ?>>
<span id="el_sco_orden_compra_fecha_aprobacion">
<span<?= $Page->fecha_aprobacion->viewAttributes() ?>>
<?= $Page->fecha_aprobacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_orden_compra_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_orden_compra_detalle->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_orden_compra_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOrdenCompraDetalleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_nota_orden_compra", explode(",", $Page->getCurrentDetailTable())) && $sco_nota_orden_compra->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota_orden_compra", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaOrdenCompraGrid.php" ?>
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
