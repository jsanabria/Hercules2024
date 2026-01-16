<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosArticulosDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_articulos: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_costos_articulosdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_articulosdelete")
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
<form name="fsco_costos_articulosdelete" id="fsco_costos_articulosdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos_articulos">
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
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><span id="elh_sco_costos_articulos_tipo" class="sco_costos_articulos_tipo"><?= $Page->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Ncostos_articulo->Visible) { // Ncostos_articulo ?>
        <th class="<?= $Page->Ncostos_articulo->headerCellClass() ?>"><span id="elh_sco_costos_articulos_Ncostos_articulo" class="sco_costos_articulos_Ncostos_articulo"><?= $Page->Ncostos_articulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_sco_costos_articulos_descripcion" class="sco_costos_articulos_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->precio->Visible) { // precio ?>
        <th class="<?= $Page->precio->headerCellClass() ?>"><span id="elh_sco_costos_articulos_precio" class="sco_costos_articulos_precio"><?= $Page->precio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <th class="<?= $Page->variacion->headerCellClass() ?>"><span id="elh_sco_costos_articulos_variacion" class="sco_costos_articulos_variacion"><?= $Page->variacion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_hercules->Visible) { // tipo_hercules ?>
        <th class="<?= $Page->tipo_hercules->headerCellClass() ?>"><span id="elh_sco_costos_articulos_tipo_hercules" class="sco_costos_articulos_tipo_hercules"><?= $Page->tipo_hercules->caption() ?></span></th>
<?php } ?>
<?php if ($Page->articulo_hercules->Visible) { // articulo_hercules ?>
        <th class="<?= $Page->articulo_hercules->headerCellClass() ?>"><span id="elh_sco_costos_articulos_articulo_hercules" class="sco_costos_articulos_articulo_hercules"><?= $Page->articulo_hercules->caption() ?></span></th>
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
<?php if ($Page->tipo->Visible) { // tipo ?>
        <td<?= $Page->tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Ncostos_articulo->Visible) { // Ncostos_articulo ?>
        <td<?= $Page->Ncostos_articulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->Ncostos_articulo->viewAttributes() ?>>
<?= $Page->Ncostos_articulo->getViewValue() ?></span>
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
<?php if ($Page->precio->Visible) { // precio ?>
        <td<?= $Page->precio->cellAttributes() ?>>
<span id="">
<span<?= $Page->precio->viewAttributes() ?>>
<?= $Page->precio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <td<?= $Page->variacion->cellAttributes() ?>>
<span id="">
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_hercules->Visible) { // tipo_hercules ?>
        <td<?= $Page->tipo_hercules->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_hercules->viewAttributes() ?>>
<?= $Page->tipo_hercules->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->articulo_hercules->Visible) { // articulo_hercules ?>
        <td<?= $Page->articulo_hercules->cellAttributes() ?>>
<span id="">
<span<?= $Page->articulo_hercules->viewAttributes() ?>>
<?= $Page->articulo_hercules->getViewValue() ?></span>
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
