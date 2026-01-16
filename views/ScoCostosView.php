<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosView = &$Page;
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
<form name="fsco_costosview" id="fsco_costosview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_costosview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costosview")
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
<input type="hidden" name="t" value="sco_costos">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_sco_costos_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_costos_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_costos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
    <tr id="r_costos_articulos"<?= $Page->costos_articulos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_costos_articulos"><?= $Page->costos_articulos->caption() ?></span></td>
        <td data-name="costos_articulos"<?= $Page->costos_articulos->cellAttributes() ?>>
<span id="el_sco_costos_costos_articulos">
<span<?= $Page->costos_articulos->viewAttributes() ?>>
<?= $Page->costos_articulos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->precio_actual->Visible) { // precio_actual ?>
    <tr id="r_precio_actual"<?= $Page->precio_actual->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_precio_actual"><?= $Page->precio_actual->caption() ?></span></td>
        <td data-name="precio_actual"<?= $Page->precio_actual->cellAttributes() ?>>
<span id="el_sco_costos_precio_actual">
<span<?= $Page->precio_actual->viewAttributes() ?>>
<?= $Page->precio_actual->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
    <tr id="r_porcentaje_aplicado"<?= $Page->porcentaje_aplicado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_porcentaje_aplicado"><?= $Page->porcentaje_aplicado->caption() ?></span></td>
        <td data-name="porcentaje_aplicado"<?= $Page->porcentaje_aplicado->cellAttributes() ?>>
<span id="el_sco_costos_porcentaje_aplicado">
<span<?= $Page->porcentaje_aplicado->viewAttributes() ?>>
<?= $Page->porcentaje_aplicado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
    <tr id="r_precio_nuevo"<?= $Page->precio_nuevo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_precio_nuevo"><?= $Page->precio_nuevo->caption() ?></span></td>
        <td data-name="precio_nuevo"<?= $Page->precio_nuevo->cellAttributes() ?>>
<span id="el_sco_costos_precio_nuevo">
<span<?= $Page->precio_nuevo->viewAttributes() ?>>
<?= $Page->precio_nuevo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
    <tr id="r_alicuota_iva"<?= $Page->alicuota_iva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_alicuota_iva"><?= $Page->alicuota_iva->caption() ?></span></td>
        <td data-name="alicuota_iva"<?= $Page->alicuota_iva->cellAttributes() ?>>
<span id="el_sco_costos_alicuota_iva">
<span<?= $Page->alicuota_iva->viewAttributes() ?>>
<?= $Page->alicuota_iva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_iva->Visible) { // monto_iva ?>
    <tr id="r_monto_iva"<?= $Page->monto_iva->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_monto_iva"><?= $Page->monto_iva->caption() ?></span></td>
        <td data-name="monto_iva"<?= $Page->monto_iva->cellAttributes() ?>>
<span id="el_sco_costos_monto_iva">
<span<?= $Page->monto_iva->viewAttributes() ?>>
<?= $Page->monto_iva->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <tr id="r_total"<?= $Page->total->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_total"><?= $Page->total->caption() ?></span></td>
        <td data-name="total"<?= $Page->total->cellAttributes() ?>>
<span id="el_sco_costos_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
    <tr id="r_cerrado"<?= $Page->cerrado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_cerrado"><?= $Page->cerrado->caption() ?></span></td>
        <td data-name="cerrado"<?= $Page->cerrado->cellAttributes() ?>>
<span id="el_sco_costos_cerrado">
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
