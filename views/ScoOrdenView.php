<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenView = &$Page;
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
<form name="fsco_ordenview" id="fsco_ordenview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_ordenview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_ordenview")
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
<input type="hidden" name="t" value="sco_orden">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->expediente->Visible) { // expediente ?>
    <tr id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_expediente"><?= $Page->expediente->caption() ?></span></td>
        <td data-name="expediente"<?= $Page->expediente->cellAttributes() ?>>
<span id="el_sco_orden_expediente">
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <tr id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></td>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_orden_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <tr id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_servicio"><?= $Page->servicio->caption() ?></span></td>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_orden_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <tr id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_proveedor"><?= $Page->proveedor->caption() ?></span></td>
        <td data-name="proveedor"<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_orden_proveedor">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->responsable_servicio->Visible) { // responsable_servicio ?>
    <tr id="r_responsable_servicio"<?= $Page->responsable_servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_responsable_servicio"><?= $Page->responsable_servicio->caption() ?></span></td>
        <td data-name="responsable_servicio"<?= $Page->responsable_servicio->cellAttributes() ?>>
<span id="el_sco_orden_responsable_servicio">
<span<?= $Page->responsable_servicio->viewAttributes() ?>>
<?= $Page->responsable_servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_orden_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <tr id="r_cantidad"<?= $Page->cantidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_cantidad"><?= $Page->cantidad->caption() ?></span></td>
        <td data-name="cantidad"<?= $Page->cantidad->cellAttributes() ?>>
<span id="el_sco_orden_cantidad">
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <tr id="r_costo"<?= $Page->costo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_costo"><?= $Page->costo->caption() ?></span></td>
        <td data-name="costo"<?= $Page->costo->cellAttributes() ?>>
<span id="el_sco_orden_costo">
<span<?= $Page->costo->viewAttributes() ?>>
<?= $Page->costo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <tr id="r_total"<?= $Page->total->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_total"><?= $Page->total->caption() ?></span></td>
        <td data-name="total"<?= $Page->total->cellAttributes() ?>>
<span id="el_sco_orden_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->referencia_ubicacion->Visible) { // referencia_ubicacion ?>
    <tr id="r_referencia_ubicacion"<?= $Page->referencia_ubicacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_referencia_ubicacion"><?= $Page->referencia_ubicacion->caption() ?></span></td>
        <td data-name="referencia_ubicacion"<?= $Page->referencia_ubicacion->cellAttributes() ?>>
<span id="el_sco_orden_referencia_ubicacion">
<span<?= $Page->referencia_ubicacion->viewAttributes() ?>>
<?= $Page->referencia_ubicacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <tr id="r_user_registra"<?= $Page->user_registra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_user_registra"><?= $Page->user_registra->caption() ?></span></td>
        <td data-name="user_registra"<?= $Page->user_registra->cellAttributes() ?>>
<span id="el_sco_orden_user_registra">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_orden_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->espera_cenizas->Visible) { // espera_cenizas ?>
    <tr id="r_espera_cenizas"<?= $Page->espera_cenizas->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_espera_cenizas"><?= $Page->espera_cenizas->caption() ?></span></td>
        <td data-name="espera_cenizas"<?= $Page->espera_cenizas->cellAttributes() ?>>
<span id="el_sco_orden_espera_cenizas">
<span<?= $Page->espera_cenizas->viewAttributes() ?>>
<?= $Page->espera_cenizas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
    <tr id="r_adjunto"<?= $Page->adjunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_adjunto"><?= $Page->adjunto->caption() ?></span></td>
        <td data-name="adjunto"<?= $Page->adjunto->cellAttributes() ?>>
<span id="el_sco_orden_adjunto">
<span<?= $Page->adjunto->viewAttributes() ?>>
<?= $Page->adjunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->llevar_a->Visible) { // llevar_a ?>
    <tr id="r_llevar_a"<?= $Page->llevar_a->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_llevar_a"><?= $Page->llevar_a->caption() ?></span></td>
        <td data-name="llevar_a"<?= $Page->llevar_a->cellAttributes() ?>>
<span id="el_sco_orden_llevar_a">
<span<?= $Page->llevar_a->viewAttributes() ?>>
<?= $Page->llevar_a->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
    <tr id="r_servicio_atendido"<?= $Page->servicio_atendido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_servicio_atendido"><?= $Page->servicio_atendido->caption() ?></span></td>
        <td data-name="servicio_atendido"<?= $Page->servicio_atendido->cellAttributes() ?>>
<span id="el_sco_orden_servicio_atendido">
<span<?= $Page->servicio_atendido->viewAttributes() ?>>
<?= $Page->servicio_atendido->getViewValue() ?></span>
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
