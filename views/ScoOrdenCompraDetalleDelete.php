<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDetalleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_orden_compra_detalledelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compra_detalledelete")
        .setPageId("delete")
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_orden_compra_detalledelete" id="fsco_orden_compra_detalledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden_compra_detalle">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <th class="<?= $Page->tipo_insumo->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_tipo_insumo" class="sco_orden_compra_detalle_tipo_insumo"><?= $Page->tipo_insumo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
        <th class="<?= $Page->articulo->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_articulo" class="sco_orden_compra_detalle_articulo"><?= $Page->articulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
        <th class="<?= $Page->unidad_medida->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_unidad_medida" class="sco_orden_compra_detalle_unidad_medida"><?= $Page->unidad_medida->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
        <th class="<?= $Page->cantidad->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_cantidad" class="sco_orden_compra_detalle_cantidad"><?= $Page->cantidad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_descripcion" class="sco_orden_compra_detalle_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
        <th class="<?= $Page->imagen->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_imagen" class="sco_orden_compra_detalle_imagen"><?= $Page->imagen->caption() ?></span></th>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
        <th class="<?= $Page->disponible->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_disponible" class="sco_orden_compra_detalle_disponible"><?= $Page->disponible->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <th class="<?= $Page->unidad_medida_recibida->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_unidad_medida_recibida" class="sco_orden_compra_detalle_unidad_medida_recibida"><?= $Page->unidad_medida_recibida->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <th class="<?= $Page->cantidad_recibida->headerCellClass() ?>"><span id="elh_sco_orden_compra_detalle_cantidad_recibida" class="sco_orden_compra_detalle_cantidad_recibida"><?= $Page->cantidad_recibida->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <td<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
        <td<?= $Page->articulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->articulo->viewAttributes() ?>>
<?= $Page->articulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
        <td<?= $Page->unidad_medida->cellAttributes() ?>>
<span id="">
<span<?= $Page->unidad_medida->viewAttributes() ?>>
<?= $Page->unidad_medida->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
        <td<?= $Page->cantidad->cellAttributes() ?>>
<span id="">
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td<?= $Page->descripcion->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
        <td<?= $Page->imagen->cellAttributes() ?>>
<span id="">
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
        <td<?= $Page->disponible->cellAttributes() ?>>
<span id="">
<span<?= $Page->disponible->viewAttributes() ?>>
<?= $Page->disponible->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <td<?= $Page->unidad_medida_recibida->cellAttributes() ?>>
<span id="">
<span<?= $Page->unidad_medida_recibida->viewAttributes() ?>>
<?= $Page->unidad_medida_recibida->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <td<?= $Page->cantidad_recibida->cellAttributes() ?>>
<span id="">
<span<?= $Page->cantidad_recibida->viewAttributes() ?>>
<?= $Page->cantidad_recibida->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
