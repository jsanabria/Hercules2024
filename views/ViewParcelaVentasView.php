<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewParcelaVentasView = &$Page;
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
<form name="fview_parcela_ventasview" id="fview_parcela_ventasview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_parcela_ventas: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fview_parcela_ventasview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_parcela_ventasview")
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
<input type="hidden" name="t" value="view_parcela_ventas">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
    <tr id="r_Nparcela_ventas"<?= $Page->Nparcela_ventas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_Nparcela_ventas"><?= $Page->Nparcela_ventas->caption() ?></span></td>
        <td data-name="Nparcela_ventas"<?= $Page->Nparcela_ventas->cellAttributes() ?>>
<span id="el_view_parcela_ventas_Nparcela_ventas">
<span<?= $Page->Nparcela_ventas->viewAttributes() ?>>
<?= $Page->Nparcela_ventas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->vendedor->Visible) { // vendedor ?>
    <tr id="r_vendedor"<?= $Page->vendedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_vendedor"><?= $Page->vendedor->caption() ?></span></td>
        <td data-name="vendedor"<?= $Page->vendedor->cellAttributes() ?>>
<span id="el_view_parcela_ventas_vendedor">
<span<?= $Page->vendedor->viewAttributes() ?>>
<?= $Page->vendedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <tr id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_seccion"><?= $Page->seccion->caption() ?></span></td>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el_view_parcela_ventas_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <tr id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_modulo"><?= $Page->modulo->caption() ?></span></td>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el_view_parcela_ventas_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
    <tr id="r_subseccion"<?= $Page->subseccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_subseccion"><?= $Page->subseccion->caption() ?></span></td>
        <td data-name="subseccion"<?= $Page->subseccion->cellAttributes() ?>>
<span id="el_view_parcela_ventas_subseccion">
<span<?= $Page->subseccion->viewAttributes() ?>>
<?= $Page->subseccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <tr id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_parcela"><?= $Page->parcela->caption() ?></span></td>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el_view_parcela_ventas_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ci_comprador->Visible) { // ci_comprador ?>
    <tr id="r_ci_comprador"<?= $Page->ci_comprador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_ci_comprador"><?= $Page->ci_comprador->caption() ?></span></td>
        <td data-name="ci_comprador"<?= $Page->ci_comprador->cellAttributes() ?>>
<span id="el_view_parcela_ventas_ci_comprador">
<span<?= $Page->ci_comprador->viewAttributes() ?>>
<?= $Page->ci_comprador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
    <tr id="r_comprador"<?= $Page->comprador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_comprador"><?= $Page->comprador->caption() ?></span></td>
        <td data-name="comprador"<?= $Page->comprador->cellAttributes() ?>>
<span id="el_view_parcela_ventas_comprador">
<span<?= $Page->comprador->viewAttributes() ?>>
<?= $Page->comprador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_vende->Visible) { // usuario_vende ?>
    <tr id="r_usuario_vende"<?= $Page->usuario_vende->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_usuario_vende"><?= $Page->usuario_vende->caption() ?></span></td>
        <td data-name="usuario_vende"<?= $Page->usuario_vende->cellAttributes() ?>>
<span id="el_view_parcela_ventas_usuario_vende">
<span<?= $Page->usuario_vende->viewAttributes() ?>>
<?= $Page->usuario_vende->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_venta->Visible) { // fecha_venta ?>
    <tr id="r_fecha_venta"<?= $Page->fecha_venta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_fecha_venta"><?= $Page->fecha_venta->caption() ?></span></td>
        <td data-name="fecha_venta"<?= $Page->fecha_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_fecha_venta">
<span<?= $Page->fecha_venta->viewAttributes() ?>>
<?= $Page->fecha_venta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->valor_venta->Visible) { // valor_venta ?>
    <tr id="r_valor_venta"<?= $Page->valor_venta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_valor_venta"><?= $Page->valor_venta->caption() ?></span></td>
        <td data-name="valor_venta"<?= $Page->valor_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_valor_venta">
<span<?= $Page->valor_venta->viewAttributes() ?>>
<?= $Page->valor_venta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->moneda_venta->Visible) { // moneda_venta ?>
    <tr id="r_moneda_venta"<?= $Page->moneda_venta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_moneda_venta"><?= $Page->moneda_venta->caption() ?></span></td>
        <td data-name="moneda_venta"<?= $Page->moneda_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_moneda_venta">
<span<?= $Page->moneda_venta->viewAttributes() ?>>
<?= $Page->moneda_venta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tasa_venta->Visible) { // tasa_venta ?>
    <tr id="r_tasa_venta"<?= $Page->tasa_venta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_tasa_venta"><?= $Page->tasa_venta->caption() ?></span></td>
        <td data-name="tasa_venta"<?= $Page->tasa_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_tasa_venta">
<span<?= $Page->tasa_venta->viewAttributes() ?>>
<?= $Page->tasa_venta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_view_parcela_ventas_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_parcela_ventas_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_view_parcela_ventas_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_parcela_ventas_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_parcela_ventas_nota->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_parcela_ventas_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoParcelaVentasNotaGrid.php" ?>
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
