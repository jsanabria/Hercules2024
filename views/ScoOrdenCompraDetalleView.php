<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDetalleView = &$Page;
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
<form name="fsco_orden_compra_detalleview" id="fsco_orden_compra_detalleview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_orden_compra_detalleview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compra_detalleview")
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
<input type="hidden" name="t" value="sco_orden_compra_detalle">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
    <tr id="r_tipo_insumo"<?= $Page->tipo_insumo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_tipo_insumo"><?= $Page->tipo_insumo->caption() ?></span></td>
        <td data-name="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_tipo_insumo">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
    <tr id="r_articulo"<?= $Page->articulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_articulo"><?= $Page->articulo->caption() ?></span></td>
        <td data-name="articulo"<?= $Page->articulo->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_articulo">
<span<?= $Page->articulo->viewAttributes() ?>>
<?= $Page->articulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
    <tr id="r_unidad_medida"<?= $Page->unidad_medida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_unidad_medida"><?= $Page->unidad_medida->caption() ?></span></td>
        <td data-name="unidad_medida"<?= $Page->unidad_medida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_unidad_medida">
<span<?= $Page->unidad_medida->viewAttributes() ?>>
<?= $Page->unidad_medida->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <tr id="r_cantidad"<?= $Page->cantidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_cantidad"><?= $Page->cantidad->caption() ?></span></td>
        <td data-name="cantidad"<?= $Page->cantidad->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_cantidad">
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
    <tr id="r_imagen"<?= $Page->imagen->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_imagen"><?= $Page->imagen->caption() ?></span></td>
        <td data-name="imagen"<?= $Page->imagen->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
    <tr id="r_disponible"<?= $Page->disponible->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_disponible"><?= $Page->disponible->caption() ?></span></td>
        <td data-name="disponible"<?= $Page->disponible->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_disponible">
<span<?= $Page->disponible->viewAttributes() ?>>
<?= $Page->disponible->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
    <tr id="r_unidad_medida_recibida"<?= $Page->unidad_medida_recibida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_unidad_medida_recibida"><?= $Page->unidad_medida_recibida->caption() ?></span></td>
        <td data-name="unidad_medida_recibida"<?= $Page->unidad_medida_recibida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_unidad_medida_recibida">
<span<?= $Page->unidad_medida_recibida->viewAttributes() ?>>
<?= $Page->unidad_medida_recibida->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
    <tr id="r_cantidad_recibida"<?= $Page->cantidad_recibida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_compra_detalle_cantidad_recibida"><?= $Page->cantidad_recibida->caption() ?></span></td>
        <td data-name="cantidad_recibida"<?= $Page->cantidad_recibida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_cantidad_recibida">
<span<?= $Page->cantidad_recibida->viewAttributes() ?>>
<?= $Page->cantidad_recibida->getViewValue() ?></span>
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
