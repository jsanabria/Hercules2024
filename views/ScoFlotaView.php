<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaView = &$Page;
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
<form name="fsco_flotaview" id="fsco_flotaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_flotaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flotaview")
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
<input type="hidden" name="t" value="sco_flota">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->tipo_flota->Visible) { // tipo_flota ?>
    <tr id="r_tipo_flota"<?= $Page->tipo_flota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_tipo_flota"><?= $Page->tipo_flota->caption() ?></span></td>
        <td data-name="tipo_flota"<?= $Page->tipo_flota->cellAttributes() ?>>
<span id="el_sco_flota_tipo_flota">
<span<?= $Page->tipo_flota->viewAttributes() ?>>
<?= $Page->tipo_flota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marca->Visible) { // marca ?>
    <tr id="r_marca"<?= $Page->marca->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_marca"><?= $Page->marca->caption() ?></span></td>
        <td data-name="marca"<?= $Page->marca->cellAttributes() ?>>
<span id="el_sco_flota_marca">
<span<?= $Page->marca->viewAttributes() ?>>
<?= $Page->marca->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modelo->Visible) { // modelo ?>
    <tr id="r_modelo"<?= $Page->modelo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_modelo"><?= $Page->modelo->caption() ?></span></td>
        <td data-name="modelo"<?= $Page->modelo->cellAttributes() ?>>
<span id="el_sco_flota_modelo">
<span<?= $Page->modelo->viewAttributes() ?>>
<?= $Page->modelo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
    <tr id="r_placa"<?= $Page->placa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_placa"><?= $Page->placa->caption() ?></span></td>
        <td data-name="placa"<?= $Page->placa->cellAttributes() ?>>
<span id="el_sco_flota_placa">
<span<?= $Page->placa->viewAttributes() ?>>
<?= $Page->placa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <tr id="r_color"<?= $Page->color->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_color"><?= $Page->color->caption() ?></span></td>
        <td data-name="color"<?= $Page->color->cellAttributes() ?>>
<span id="el_sco_flota_color">
<span<?= $Page->color->viewAttributes() ?>>
<?= $Page->color->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->anho->Visible) { // anho ?>
    <tr id="r_anho"<?= $Page->anho->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_anho"><?= $Page->anho->caption() ?></span></td>
        <td data-name="anho"<?= $Page->anho->cellAttributes() ?>>
<span id="el_sco_flota_anho">
<span<?= $Page->anho->viewAttributes() ?>>
<?= $Page->anho->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serial_carroceria->Visible) { // serial_carroceria ?>
    <tr id="r_serial_carroceria"<?= $Page->serial_carroceria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_serial_carroceria"><?= $Page->serial_carroceria->caption() ?></span></td>
        <td data-name="serial_carroceria"<?= $Page->serial_carroceria->cellAttributes() ?>>
<span id="el_sco_flota_serial_carroceria">
<span<?= $Page->serial_carroceria->viewAttributes() ?>>
<?= $Page->serial_carroceria->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->serial_motor->Visible) { // serial_motor ?>
    <tr id="r_serial_motor"<?= $Page->serial_motor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_serial_motor"><?= $Page->serial_motor->caption() ?></span></td>
        <td data-name="serial_motor"<?= $Page->serial_motor->cellAttributes() ?>>
<span id="el_sco_flota_serial_motor">
<span<?= $Page->serial_motor->viewAttributes() ?>>
<?= $Page->serial_motor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_flota_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->conductor->Visible) { // conductor ?>
    <tr id="r_conductor"<?= $Page->conductor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_conductor"><?= $Page->conductor->caption() ?></span></td>
        <td data-name="conductor"<?= $Page->conductor->cellAttributes() ?>>
<span id="el_sco_flota_conductor">
<span<?= $Page->conductor->viewAttributes() ?>>
<?= $Page->conductor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_flota_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->km_oil_next->Visible) { // km_oil_next ?>
    <tr id="r_km_oil_next"<?= $Page->km_oil_next->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_km_oil_next"><?= $Page->km_oil_next->caption() ?></span></td>
        <td data-name="km_oil_next"<?= $Page->km_oil_next->cellAttributes() ?>>
<span id="el_sco_flota_km_oil_next">
<span<?= $Page->km_oil_next->viewAttributes() ?>>
<?= $Page->km_oil_next->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
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
