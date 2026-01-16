<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewExpFacturaView = &$Page;
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
<form name="fview_exp_facturaview" id="fview_exp_facturaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_exp_factura: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fview_exp_facturaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_exp_facturaview")
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
<input type="hidden" name="t" value="view_exp_factura">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->cia->Visible) { // cia ?>
    <tr id="r_cia"<?= $Page->cia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_cia"><?= $Page->cia->caption() ?></span></td>
        <td data-name="cia"<?= $Page->cia->cellAttributes() ?>>
<span id="el_view_exp_factura_cia">
<span<?= $Page->cia->viewAttributes() ?>>
<?= $Page->cia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <tr id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></td>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_view_exp_factura_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
    <tr id="r_Nexpediente"<?= $Page->Nexpediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_Nexpediente"><?= $Page->Nexpediente->caption() ?></span></td>
        <td data-name="Nexpediente"<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="el_view_exp_factura_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?php if (!EmptyString($Page->Nexpediente->getViewValue()) && $Page->Nexpediente->linkAttributes() != "") { ?>
<a<?= $Page->Nexpediente->linkAttributes() ?>><?= $Page->Nexpediente->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->Nexpediente->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_view_exp_factura_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <tr id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></td>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_view_exp_factura_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <tr id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></td>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_view_exp_factura_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <tr id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_factura"><?= $Page->factura->caption() ?></span></td>
        <td data-name="factura"<?= $Page->factura->cellAttributes() ?>>
<span id="el_view_exp_factura_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <tr id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_monto"><?= $Page->monto->caption() ?></span></td>
        <td data-name="monto"<?= $Page->monto->cellAttributes() ?>>
<span id="el_view_exp_factura_monto">
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_view_exp_factura_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_view_exp_factura__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_view_exp_factura_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_exp_factura_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_view_exp_factura_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
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
