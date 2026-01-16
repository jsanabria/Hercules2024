<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteView = &$Page;
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
<form name="fsco_expedienteview" id="fsco_expedienteview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_expedienteview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expedienteview")
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
<input type="hidden" name="t" value="sco_expediente">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->seguro->Visible) { // seguro ?>
    <tr id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguro"><?= $Page->seguro->caption() ?></span></td>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
    <tr id="r_nombre_contacto"<?= $Page->nombre_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_nombre_contacto"><?= $Page->nombre_contacto->caption() ?></span></td>
        <td data-name="nombre_contacto"<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_nombre_contacto">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
    <tr id="r_parentesco_contacto"<?= $Page->parentesco_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_parentesco_contacto"><?= $Page->parentesco_contacto->caption() ?></span></td>
        <td data-name="parentesco_contacto"<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_parentesco_contacto">
<span<?= $Page->parentesco_contacto->viewAttributes() ?>>
<?= $Page->parentesco_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
    <tr id="r_telefono_contacto1"<?= $Page->telefono_contacto1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_telefono_contacto1"><?= $Page->telefono_contacto1->caption() ?></span></td>
        <td data-name="telefono_contacto1"<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el_sco_expediente_telefono_contacto1">
<span<?= $Page->telefono_contacto1->viewAttributes() ?>>
<?= $Page->telefono_contacto1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
    <tr id="r_telefono_contacto2"<?= $Page->telefono_contacto2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_telefono_contacto2"><?= $Page->telefono_contacto2->caption() ?></span></td>
        <td data-name="telefono_contacto2"<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el_sco_expediente_telefono_contacto2">
<span<?= $Page->telefono_contacto2->viewAttributes() ?>>
<?= $Page->telefono_contacto2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <tr id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></td>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <tr id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></td>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <tr id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></td>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
    <tr id="r_sexo"<?= $Page->sexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_sexo"><?= $Page->sexo->caption() ?></span></td>
        <td data-name="sexo"<?= $Page->sexo->cellAttributes() ?>>
<span id="el_sco_expediente_sexo">
<span<?= $Page->sexo->viewAttributes() ?>>
<?= $Page->sexo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <tr id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_fecha_nacimiento"><?= $Page->fecha_nacimiento->caption() ?></span></td>
        <td data-name="fecha_nacimiento"<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_nacimiento">
<span<?= $Page->fecha_nacimiento->viewAttributes() ?>>
<?= $Page->fecha_nacimiento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
    <tr id="r_edad_fallecido"<?= $Page->edad_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_edad_fallecido"><?= $Page->edad_fallecido->caption() ?></span></td>
        <td data-name="edad_fallecido"<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_edad_fallecido">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<?= $Page->edad_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
    <tr id="r_lugar_ocurrencia"<?= $Page->lugar_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_lugar_ocurrencia"><?= $Page->lugar_ocurrencia->caption() ?></span></td>
        <td data-name="lugar_ocurrencia"<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_lugar_ocurrencia">
<span<?= $Page->lugar_ocurrencia->viewAttributes() ?>>
<?= $Page->lugar_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
    <tr id="r_direccion_ocurrencia"<?= $Page->direccion_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_direccion_ocurrencia"><?= $Page->direccion_ocurrencia->caption() ?></span></td>
        <td data-name="direccion_ocurrencia"<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_direccion_ocurrencia">
<span<?= $Page->direccion_ocurrencia->viewAttributes() ?>>
<?= $Page->direccion_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
    <tr id="r_fecha_ocurrencia"<?= $Page->fecha_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_fecha_ocurrencia"><?= $Page->fecha_ocurrencia->caption() ?></span></td>
        <td data-name="fecha_ocurrencia"<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_ocurrencia">
<span<?= $Page->fecha_ocurrencia->viewAttributes() ?>>
<?= $Page->fecha_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <tr id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_causa_ocurrencia"><?= $Page->causa_ocurrencia->caption() ?></span></td>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
    <tr id="r_causa_otro"<?= $Page->causa_otro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_causa_otro"><?= $Page->causa_otro->caption() ?></span></td>
        <td data-name="causa_otro"<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el_sco_expediente_causa_otro">
<span<?= $Page->causa_otro->viewAttributes() ?>>
<?= $Page->causa_otro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
    <tr id="r_permiso"<?= $Page->permiso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_permiso"><?= $Page->permiso->caption() ?></span></td>
        <td data-name="permiso"<?= $Page->permiso->cellAttributes() ?>>
<span id="el_sco_expediente_permiso">
<span<?= $Page->permiso->viewAttributes() ?>>
<?= $Page->permiso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <tr id="r_user_registra"<?= $Page->user_registra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_user_registra"><?= $Page->user_registra->caption() ?></span></td>
        <td data-name="user_registra"<?= $Page->user_registra->cellAttributes() ?>>
<span id="el_sco_expediente_user_registra">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_orden", explode(",", $Page->getCurrentDetailTable())) && $sco_orden->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_orden", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOrdenGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_seguimiento", explode(",", $Page->getCurrentDetailTable())) && $sco_seguimiento->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_seguimiento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoSeguimientoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_estatus->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteEstatusGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_cremacion_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_cremacion_estatus->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_cremacion_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoCremacionEstatusGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_parcela", explode(",", $Page->getCurrentDetailTable())) && $sco_parcela->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_parcela", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoParcelaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_encuesta_calidad", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_encuesta_calidad->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_encuesta_calidad", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteEncuestaCalidadGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_cia", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_cia->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_cia", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteCiaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_embalaje", explode(",", $Page->getCurrentDetailTable())) && $sco_embalaje->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_embalaje", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoEmbalajeGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_reembolso", explode(",", $Page->getCurrentDetailTable())) && $sco_reembolso->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_reembolso", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoReembolsoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_nota->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaGrid.php" ?>
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
