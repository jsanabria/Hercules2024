<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaView = &$Page;
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
<form name="fsco_costos_tarifaview" id="fsco_costos_tarifaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_costos_tarifaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifaview")
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
<input type="hidden" name="t" value="sco_costos_tarifa">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->localidad->Visible) { // localidad ?>
    <tr id="r_localidad"<?= $Page->localidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_localidad"><?= $Page->localidad->caption() ?></span></td>
        <td data-name="localidad"<?= $Page->localidad->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_localidad">
<span<?= $Page->localidad->viewAttributes() ?>>
<?= $Page->localidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_servicio->Visible) { // tipo_servicio ?>
    <tr id="r_tipo_servicio"<?= $Page->tipo_servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_tipo_servicio"><?= $Page->tipo_servicio->caption() ?></span></td>
        <td data-name="tipo_servicio"<?= $Page->tipo_servicio->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_tipo_servicio">
<span<?= $Page->tipo_servicio->viewAttributes() ?>>
<?= $Page->tipo_servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
    <tr id="r_horas"<?= $Page->horas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_horas"><?= $Page->horas->caption() ?></span></td>
        <td data-name="horas"<?= $Page->horas->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_horas">
<span<?= $Page->horas->viewAttributes() ?>>
<?= $Page->horas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_costos_tarifa_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_costos_tarifa_detalle->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_costos_tarifa_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoCostosTarifaDetalleGrid.php" ?>
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
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#tarifario").click(function(){
    	var url = "dashboard/tarifario.php";
    	$(location).attr('href',url);
    });
});
</script>
<?php } ?>
