<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewSeguimientoView = &$Page;
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
<form name="fview_seguimientoview" id="fview_seguimientoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_seguimiento: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fview_seguimientoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_seguimientoview")
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
<input type="hidden" name="t" value="view_seguimiento">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->expediente->Visible) { // expediente ?>
    <tr id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_expediente"><?= $Page->expediente->caption() ?></span></td>
        <td data-name="expediente"<?= $Page->expediente->cellAttributes() ?>>
<span id="el_view_seguimiento_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?php if (!EmptyString($Page->expediente->getViewValue()) && $Page->expediente->linkAttributes() != "") { ?>
<a<?= $Page->expediente->linkAttributes() ?>><?= $Page->expediente->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->expediente->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->difunto->Visible) { // difunto ?>
    <tr id="r_difunto"<?= $Page->difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_difunto"><?= $Page->difunto->caption() ?></span></td>
        <td data-name="difunto"<?= $Page->difunto->cellAttributes() ?>>
<span id="el_view_seguimiento_difunto">
<span<?= $Page->difunto->viewAttributes() ?>>
<?= $Page->difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_view_seguimiento__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_asigna->Visible) { // user_asigna ?>
    <tr id="r_user_asigna"<?= $Page->user_asigna->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_user_asigna"><?= $Page->user_asigna->caption() ?></span></td>
        <td data-name="user_asigna"<?= $Page->user_asigna->cellAttributes() ?>>
<span id="el_view_seguimiento_user_asigna">
<span<?= $Page->user_asigna->viewAttributes() ?>>
<?= $Page->user_asigna->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_seguimiento->Visible) { // fecha_seguimiento ?>
    <tr id="r_fecha_seguimiento"<?= $Page->fecha_seguimiento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_fecha_seguimiento"><?= $Page->fecha_seguimiento->caption() ?></span></td>
        <td data-name="fecha_seguimiento"<?= $Page->fecha_seguimiento->cellAttributes() ?>>
<span id="el_view_seguimiento_fecha_seguimiento">
<span<?= $Page->fecha_seguimiento->viewAttributes() ?>>
<?= $Page->fecha_seguimiento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
    <tr id="r_fecha_cierre"<?= $Page->fecha_cierre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_fecha_cierre"><?= $Page->fecha_cierre->caption() ?></span></td>
        <td data-name="fecha_cierre"<?= $Page->fecha_cierre->cellAttributes() ?>>
<span id="el_view_seguimiento_fecha_cierre">
<span<?= $Page->fecha_cierre->viewAttributes() ?>>
<?= $Page->fecha_cierre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->texto->Visible) { // texto ?>
    <tr id="r_texto"<?= $Page->texto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_texto"><?= $Page->texto->caption() ?></span></td>
        <td data-name="texto"<?= $Page->texto->cellAttributes() ?>>
<span id="el_view_seguimiento_texto">
<span<?= $Page->texto->viewAttributes() ?>>
<?= $Page->texto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_seguimiento_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_view_seguimiento_estatus">
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
