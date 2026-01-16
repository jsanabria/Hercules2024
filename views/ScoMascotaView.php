<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMascotaView = &$Page;
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
<form name="fsco_mascotaview" id="fsco_mascotaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mascota: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_mascotaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mascotaview")
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
<input type="hidden" name="t" value="sco_mascota">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nmascota->Visible) { // Nmascota ?>
    <tr id="r_Nmascota"<?= $Page->Nmascota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_Nmascota"><?= $Page->Nmascota->caption() ?></span></td>
        <td data-name="Nmascota"<?= $Page->Nmascota->cellAttributes() ?>>
<span id="el_sco_mascota_Nmascota">
<span<?= $Page->Nmascota->viewAttributes() ?>>
<?= $Page->Nmascota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_contratante->Visible) { // nombre_contratante ?>
    <tr id="r_nombre_contratante"<?= $Page->nombre_contratante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_nombre_contratante"><?= $Page->nombre_contratante->caption() ?></span></td>
        <td data-name="nombre_contratante"<?= $Page->nombre_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_nombre_contratante">
<span<?= $Page->nombre_contratante->viewAttributes() ?>>
<?= $Page->nombre_contratante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_contratante->Visible) { // cedula_contratante ?>
    <tr id="r_cedula_contratante"<?= $Page->cedula_contratante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_cedula_contratante"><?= $Page->cedula_contratante->caption() ?></span></td>
        <td data-name="cedula_contratante"<?= $Page->cedula_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_cedula_contratante">
<span<?= $Page->cedula_contratante->viewAttributes() ?>>
<?= $Page->cedula_contratante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion_contratante->Visible) { // direccion_contratante ?>
    <tr id="r_direccion_contratante"<?= $Page->direccion_contratante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_direccion_contratante"><?= $Page->direccion_contratante->caption() ?></span></td>
        <td data-name="direccion_contratante"<?= $Page->direccion_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_direccion_contratante">
<span<?= $Page->direccion_contratante->viewAttributes() ?>>
<?= $Page->direccion_contratante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <tr id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_telefono1"><?= $Page->telefono1->caption() ?></span></td>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_mascota_telefono1">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <tr id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_telefono2"><?= $Page->telefono2->caption() ?></span></td>
        <td data-name="telefono2"<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_mascota_telefono2">
<span<?= $Page->telefono2->viewAttributes() ?>>
<?= $Page->telefono2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_mascota__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_mascota->Visible) { // nombre_mascota ?>
    <tr id="r_nombre_mascota"<?= $Page->nombre_mascota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_nombre_mascota"><?= $Page->nombre_mascota->caption() ?></span></td>
        <td data-name="nombre_mascota"<?= $Page->nombre_mascota->cellAttributes() ?>>
<span id="el_sco_mascota_nombre_mascota">
<span<?= $Page->nombre_mascota->viewAttributes() ?>>
<?= $Page->nombre_mascota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
    <tr id="r_peso"<?= $Page->peso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_peso"><?= $Page->peso->caption() ?></span></td>
        <td data-name="peso"<?= $Page->peso->cellAttributes() ?>>
<span id="el_sco_mascota_peso">
<span<?= $Page->peso->viewAttributes() ?>>
<?= $Page->peso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->raza->Visible) { // raza ?>
    <tr id="r_raza"<?= $Page->raza->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_raza"><?= $Page->raza->caption() ?></span></td>
        <td data-name="raza"<?= $Page->raza->cellAttributes() ?>>
<span id="el_sco_mascota_raza">
<span<?= $Page->raza->viewAttributes() ?>>
<?= $Page->raza->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_mascota_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_otro->Visible) { // tipo_otro ?>
    <tr id="r_tipo_otro"<?= $Page->tipo_otro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_tipo_otro"><?= $Page->tipo_otro->caption() ?></span></td>
        <td data-name="tipo_otro"<?= $Page->tipo_otro->cellAttributes() ?>>
<span id="el_sco_mascota_tipo_otro">
<span<?= $Page->tipo_otro->viewAttributes() ?>>
<?= $Page->tipo_otro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <tr id="r_color"<?= $Page->color->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_color"><?= $Page->color->caption() ?></span></td>
        <td data-name="color"<?= $Page->color->cellAttributes() ?>>
<span id="el_sco_mascota_color">
<span<?= $Page->color->viewAttributes() ?>>
<?= $Page->color->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->procedencia->Visible) { // procedencia ?>
    <tr id="r_procedencia"<?= $Page->procedencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_procedencia"><?= $Page->procedencia->caption() ?></span></td>
        <td data-name="procedencia"<?= $Page->procedencia->cellAttributes() ?>>
<span id="el_sco_mascota_procedencia">
<span<?= $Page->procedencia->viewAttributes() ?>>
<?= $Page->procedencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tarifa->Visible) { // tarifa ?>
    <tr id="r_tarifa"<?= $Page->tarifa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_tarifa"><?= $Page->tarifa->caption() ?></span></td>
        <td data-name="tarifa"<?= $Page->tarifa->cellAttributes() ?>>
<span id="el_sco_mascota_tarifa">
<span<?= $Page->tarifa->viewAttributes() ?>>
<?= $Page->tarifa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <tr id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_factura"><?= $Page->factura->caption() ?></span></td>
        <td data-name="factura"<?= $Page->factura->cellAttributes() ?>>
<span id="el_sco_mascota_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <tr id="r_costo"<?= $Page->costo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_costo"><?= $Page->costo->caption() ?></span></td>
        <td data-name="costo"<?= $Page->costo->cellAttributes() ?>>
<span id="el_sco_mascota_costo">
<span<?= $Page->costo->viewAttributes() ?>>
<?= $Page->costo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <tr id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_tasa"><?= $Page->tasa->caption() ?></span></td>
        <td data-name="tasa"<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_mascota_tasa">
<span<?= $Page->tasa->viewAttributes() ?>>
<?= $Page->tasa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_mascota_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_cremacion->Visible) { // fecha_cremacion ?>
    <tr id="r_fecha_cremacion"<?= $Page->fecha_cremacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_fecha_cremacion"><?= $Page->fecha_cremacion->caption() ?></span></td>
        <td data-name="fecha_cremacion"<?= $Page->fecha_cremacion->cellAttributes() ?>>
<span id="el_sco_mascota_fecha_cremacion">
<span<?= $Page->fecha_cremacion->viewAttributes() ?>>
<?= $Page->fecha_cremacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hora_cremacion->Visible) { // hora_cremacion ?>
    <tr id="r_hora_cremacion"<?= $Page->hora_cremacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_hora_cremacion"><?= $Page->hora_cremacion->caption() ?></span></td>
        <td data-name="hora_cremacion"<?= $Page->hora_cremacion->cellAttributes() ?>>
<span id="el_sco_mascota_hora_cremacion">
<span<?= $Page->hora_cremacion->viewAttributes() ?>>
<?= $Page->hora_cremacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->username_registra->Visible) { // username_registra ?>
    <tr id="r_username_registra"<?= $Page->username_registra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_username_registra"><?= $Page->username_registra->caption() ?></span></td>
        <td data-name="username_registra"<?= $Page->username_registra->cellAttributes() ?>>
<span id="el_sco_mascota_username_registra">
<span<?= $Page->username_registra->viewAttributes() ?>>
<?= $Page->username_registra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_mascota_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mascota_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_mascota_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_nota_mascota", explode(",", $Page->getCurrentDetailTable())) && $sco_nota_mascota->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota_mascota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaMascotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_mascota_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_mascota_estatus->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mascota_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMascotaEstatusGrid.php" ?>
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
