<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosArticulosView = &$Page;
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
<form name="fsco_costos_articulosview" id="fsco_costos_articulosview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_articulos: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_costos_articulosview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_articulosview")
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
<input type="hidden" name="t" value="sco_costos_articulos">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_costos_articulos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Ncostos_articulo->Visible) { // Ncostos_articulo ?>
    <tr id="r_Ncostos_articulo"<?= $Page->Ncostos_articulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_Ncostos_articulo"><?= $Page->Ncostos_articulo->caption() ?></span></td>
        <td data-name="Ncostos_articulo"<?= $Page->Ncostos_articulo->cellAttributes() ?>>
<span id="el_sco_costos_articulos_Ncostos_articulo">
<span<?= $Page->Ncostos_articulo->viewAttributes() ?>>
<?= $Page->Ncostos_articulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_sco_costos_articulos_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->precio->Visible) { // precio ?>
    <tr id="r_precio"<?= $Page->precio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_precio"><?= $Page->precio->caption() ?></span></td>
        <td data-name="precio"<?= $Page->precio->cellAttributes() ?>>
<span id="el_sco_costos_articulos_precio">
<span<?= $Page->precio->viewAttributes() ?>>
<?= $Page->precio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
    <tr id="r_variacion"<?= $Page->variacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_variacion"><?= $Page->variacion->caption() ?></span></td>
        <td data-name="variacion"<?= $Page->variacion->cellAttributes() ?>>
<span id="el_sco_costos_articulos_variacion">
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_hercules->Visible) { // tipo_hercules ?>
    <tr id="r_tipo_hercules"<?= $Page->tipo_hercules->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_tipo_hercules"><?= $Page->tipo_hercules->caption() ?></span></td>
        <td data-name="tipo_hercules"<?= $Page->tipo_hercules->cellAttributes() ?>>
<span id="el_sco_costos_articulos_tipo_hercules">
<span<?= $Page->tipo_hercules->viewAttributes() ?>>
<?= $Page->tipo_hercules->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->articulo_hercules->Visible) { // articulo_hercules ?>
    <tr id="r_articulo_hercules"<?= $Page->articulo_hercules->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_costos_articulos_articulo_hercules"><?= $Page->articulo_hercules->caption() ?></span></td>
        <td data-name="articulo_hercules"<?= $Page->articulo_hercules->cellAttributes() ?>>
<span id="el_sco_costos_articulos_articulo_hercules">
<span<?= $Page->articulo_hercules->viewAttributes() ?>>
<?= $Page->articulo_hercules->getViewValue() ?></span>
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
