<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaDetalleView = &$Page;
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
<form name="fsco_costos_tarifa_detalleview" id="fsco_costos_tarifa_detalleview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_costos_tarifa_detalleview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifa_detalleview")
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
<input type="hidden" name="t" value="sco_costos_tarifa_detalle">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->cap->Visible) { // cap ?>
    <tr id="r_cap"<?= $Page->cap->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_cap"><?= $Page->cap->caption() ?></span></td>
        <td data-name="cap"<?= $Page->cap->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_cap">
<span<?= $Page->cap->viewAttributes() ?>>
<?= $Page->cap->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
    <tr id="r_ata"<?= $Page->ata->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_ata"><?= $Page->ata->caption() ?></span></td>
        <td data-name="ata"<?= $Page->ata->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_ata">
<span<?= $Page->ata->viewAttributes() ?>>
<?= $Page->ata->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
    <tr id="r_obi"<?= $Page->obi->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_obi"><?= $Page->obi->caption() ?></span></td>
        <td data-name="obi"<?= $Page->obi->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_obi">
<span<?= $Page->obi->viewAttributes() ?>>
<?= $Page->obi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
    <tr id="r_fot"<?= $Page->fot->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_fot"><?= $Page->fot->caption() ?></span></td>
        <td data-name="fot"<?= $Page->fot->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_fot">
<span<?= $Page->fot->viewAttributes() ?>>
<?= $Page->fot->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
    <tr id="r_man"<?= $Page->man->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_man"><?= $Page->man->caption() ?></span></td>
        <td data-name="man"<?= $Page->man->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_man">
<span<?= $Page->man->viewAttributes() ?>>
<?= $Page->man->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
    <tr id="r_gas"<?= $Page->gas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_gas"><?= $Page->gas->caption() ?></span></td>
        <td data-name="gas"<?= $Page->gas->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_gas">
<span<?= $Page->gas->viewAttributes() ?>>
<?= $Page->gas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
    <tr id="r_com"<?= $Page->com->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_com"><?= $Page->com->caption() ?></span></td>
        <td data-name="com"<?= $Page->com->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_com">
<span<?= $Page->com->viewAttributes() ?>>
<?= $Page->com->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->base->Visible) { // base ?>
    <tr id="r_base"<?= $Page->base->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_base"><?= $Page->base->caption() ?></span></td>
        <td data-name="base"<?= $Page->base->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_base">
<span<?= $Page->base->viewAttributes() ?>>
<?= $Page->base->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->base_anterior->Visible) { // base_anterior ?>
    <tr id="r_base_anterior"<?= $Page->base_anterior->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_base_anterior"><?= $Page->base_anterior->caption() ?></span></td>
        <td data-name="base_anterior"<?= $Page->base_anterior->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_base_anterior">
<span<?= $Page->base_anterior->viewAttributes() ?>>
<?= $Page->base_anterior->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
    <tr id="r_variacion"<?= $Page->variacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_variacion"><?= $Page->variacion->caption() ?></span></td>
        <td data-name="variacion"<?= $Page->variacion->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_variacion">
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
    <tr id="r_porcentaje"<?= $Page->porcentaje->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_porcentaje"><?= $Page->porcentaje->caption() ?></span></td>
        <td data-name="porcentaje"<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_porcentaje">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
    <tr id="r_cerrado"<?= $Page->cerrado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tarifa_detalle_cerrado"><?= $Page->cerrado->caption() ?></span></td>
        <td data-name="cerrado"<?= $Page->cerrado->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_cerrado">
<span<?= $Page->cerrado->viewAttributes() ?>>
<?= $Page->cerrado->getViewValue() ?></span>
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
