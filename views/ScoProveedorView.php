<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoProveedorView = &$Page;
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
<form name="fsco_proveedorview" id="fsco_proveedorview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_proveedor: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_proveedorview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_proveedorview")
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
<input type="hidden" name="t" value="sco_proveedor">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nproveedor->Visible) { // Nproveedor ?>
    <tr id="r_Nproveedor"<?= $Page->Nproveedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_Nproveedor"><?= $Page->Nproveedor->caption() ?></span></td>
        <td data-name="Nproveedor"<?= $Page->Nproveedor->cellAttributes() ?>>
<span id="el_sco_proveedor_Nproveedor">
<span<?= $Page->Nproveedor->viewAttributes() ?>>
<?= $Page->Nproveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rif->Visible) { // rif ?>
    <tr id="r_rif"<?= $Page->rif->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_rif"><?= $Page->rif->caption() ?></span></td>
        <td data-name="rif"<?= $Page->rif->cellAttributes() ?>>
<span id="el_sco_proveedor_rif">
<span<?= $Page->rif->viewAttributes() ?>>
<?= $Page->rif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <tr id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_nombre"><?= $Page->nombre->caption() ?></span></td>
        <td data-name="nombre"<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_proveedor_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sucursal->Visible) { // sucursal ?>
    <tr id="r_sucursal"<?= $Page->sucursal->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_sucursal"><?= $Page->sucursal->caption() ?></span></td>
        <td data-name="sucursal"<?= $Page->sucursal->cellAttributes() ?>>
<span id="el_sco_proveedor_sucursal">
<span<?= $Page->sucursal->viewAttributes() ?>>
<?= $Page->sucursal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->responsable->Visible) { // responsable ?>
    <tr id="r_responsable"<?= $Page->responsable->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_responsable"><?= $Page->responsable->caption() ?></span></td>
        <td data-name="responsable"<?= $Page->responsable->cellAttributes() ?>>
<span id="el_sco_proveedor_responsable">
<span<?= $Page->responsable->viewAttributes() ?>>
<?= $Page->responsable->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <tr id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_telefono1"><?= $Page->telefono1->caption() ?></span></td>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono1">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <tr id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_telefono2"><?= $Page->telefono2->caption() ?></span></td>
        <td data-name="telefono2"<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono2">
<span<?= $Page->telefono2->viewAttributes() ?>>
<?= $Page->telefono2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono3->Visible) { // telefono3 ?>
    <tr id="r_telefono3"<?= $Page->telefono3->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_telefono3"><?= $Page->telefono3->caption() ?></span></td>
        <td data-name="telefono3"<?= $Page->telefono3->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono3">
<span<?= $Page->telefono3->viewAttributes() ?>>
<?= $Page->telefono3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono4->Visible) { // telefono4 ?>
    <tr id="r_telefono4"<?= $Page->telefono4->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_telefono4"><?= $Page->telefono4->caption() ?></span></td>
        <td data-name="telefono4"<?= $Page->telefono4->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono4">
<span<?= $Page->telefono4->viewAttributes() ?>>
<?= $Page->telefono4->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
    <tr id="r_fax"<?= $Page->fax->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_fax"><?= $Page->fax->caption() ?></span></td>
        <td data-name="fax"<?= $Page->fax->cellAttributes() ?>>
<span id="el_sco_proveedor_fax">
<span<?= $Page->fax->viewAttributes() ?>>
<?= $Page->fax->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <tr id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_correo"><?= $Page->correo->caption() ?></span></td>
        <td data-name="correo"<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_proveedor_correo">
<span<?= $Page->correo->viewAttributes() ?>>
<?= $Page->correo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->correo_adicional->Visible) { // correo_adicional ?>
    <tr id="r_correo_adicional"<?= $Page->correo_adicional->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_correo_adicional"><?= $Page->correo_adicional->caption() ?></span></td>
        <td data-name="correo_adicional"<?= $Page->correo_adicional->cellAttributes() ?>>
<span id="el_sco_proveedor_correo_adicional">
<span<?= $Page->correo_adicional->viewAttributes() ?>>
<?= $Page->correo_adicional->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <tr id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_estado"><?= $Page->estado->caption() ?></span></td>
        <td data-name="estado"<?= $Page->estado->cellAttributes() ?>>
<span id="el_sco_proveedor_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->localidad->Visible) { // localidad ?>
    <tr id="r_localidad"<?= $Page->localidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_localidad"><?= $Page->localidad->caption() ?></span></td>
        <td data-name="localidad"<?= $Page->localidad->cellAttributes() ?>>
<span id="el_sco_proveedor_localidad">
<span<?= $Page->localidad->viewAttributes() ?>>
<?= $Page->localidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <tr id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_direccion"><?= $Page->direccion->caption() ?></span></td>
        <td data-name="direccion"<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_proveedor_direccion">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->observacion->Visible) { // observacion ?>
    <tr id="r_observacion"<?= $Page->observacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_observacion"><?= $Page->observacion->caption() ?></span></td>
        <td data-name="observacion"<?= $Page->observacion->cellAttributes() ?>>
<span id="el_sco_proveedor_observacion">
<span<?= $Page->observacion->viewAttributes() ?>>
<?= $Page->observacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
    <tr id="r_tipo_proveedor"<?= $Page->tipo_proveedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_proveedor_tipo_proveedor"><?= $Page->tipo_proveedor->caption() ?></span></td>
        <td data-name="tipo_proveedor"<?= $Page->tipo_proveedor->cellAttributes() ?>>
<span id="el_sco_proveedor_tipo_proveedor">
<span<?= $Page->tipo_proveedor->viewAttributes() ?>>
<?= $Page->tipo_proveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_ofrece_servicio", explode(",", $Page->getCurrentDetailTable())) && $sco_ofrece_servicio->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_ofrece_servicio", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOfreceServicioGrid.php" ?>
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
