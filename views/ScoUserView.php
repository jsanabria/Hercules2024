<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoUserView = &$Page;
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
<form name="fsco_userview" id="fsco_userview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_user: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_userview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_userview")
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
<input type="hidden" name="t" value="sco_user">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->cedula->Visible) { // cedula ?>
    <tr id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_cedula"><?= $Page->cedula->caption() ?></span></td>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el_sco_user_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <tr id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_nombre"><?= $Page->nombre->caption() ?></span></td>
        <td data-name="nombre"<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_user_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <tr id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_correo"><?= $Page->correo->caption() ?></span></td>
        <td data-name="correo"<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_user_correo">
<span<?= $Page->correo->viewAttributes() ?>>
<?= $Page->correo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <tr id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_direccion"><?= $Page->direccion->caption() ?></span></td>
        <td data-name="direccion"<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_user_direccion">
<span<?= $Page->direccion->viewAttributes() ?>>
<?= $Page->direccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
    <tr id="r_level"<?= $Page->level->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_level"><?= $Page->level->caption() ?></span></td>
        <td data-name="level"<?= $Page->level->cellAttributes() ?>>
<span id="el_sco_user_level">
<span<?= $Page->level->viewAttributes() ?>>
<?= $Page->level->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_user_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto"<?= $Page->foto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto"<?= $Page->foto->cellAttributes() ?>>
<span id="el_sco_user_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_ingreso_cia->Visible) { // fecha_ingreso_cia ?>
    <tr id="r_fecha_ingreso_cia"<?= $Page->fecha_ingreso_cia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_fecha_ingreso_cia"><?= $Page->fecha_ingreso_cia->caption() ?></span></td>
        <td data-name="fecha_ingreso_cia"<?= $Page->fecha_ingreso_cia->cellAttributes() ?>>
<span id="el_sco_user_fecha_ingreso_cia">
<span<?= $Page->fecha_ingreso_cia->viewAttributes() ?>>
<?= $Page->fecha_ingreso_cia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_egreso_cia->Visible) { // fecha_egreso_cia ?>
    <tr id="r_fecha_egreso_cia"<?= $Page->fecha_egreso_cia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_fecha_egreso_cia"><?= $Page->fecha_egreso_cia->caption() ?></span></td>
        <td data-name="fecha_egreso_cia"<?= $Page->fecha_egreso_cia->cellAttributes() ?>>
<span id="el_sco_user_fecha_egreso_cia">
<span<?= $Page->fecha_egreso_cia->viewAttributes() ?>>
<?= $Page->fecha_egreso_cia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motivo_egreso->Visible) { // motivo_egreso ?>
    <tr id="r_motivo_egreso"<?= $Page->motivo_egreso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_motivo_egreso"><?= $Page->motivo_egreso->caption() ?></span></td>
        <td data-name="motivo_egreso"<?= $Page->motivo_egreso->cellAttributes() ?>>
<span id="el_sco_user_motivo_egreso">
<span<?= $Page->motivo_egreso->viewAttributes() ?>>
<?= $Page->motivo_egreso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->departamento->Visible) { // departamento ?>
    <tr id="r_departamento"<?= $Page->departamento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_departamento"><?= $Page->departamento->caption() ?></span></td>
        <td data-name="departamento"<?= $Page->departamento->cellAttributes() ?>>
<span id="el_sco_user_departamento">
<span<?= $Page->departamento->viewAttributes() ?>>
<?= $Page->departamento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <tr id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_cargo"><?= $Page->cargo->caption() ?></span></td>
        <td data-name="cargo"<?= $Page->cargo->cellAttributes() ?>>
<span id="el_sco_user_cargo">
<span<?= $Page->cargo->viewAttributes() ?>>
<?= $Page->cargo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->celular_1->Visible) { // celular_1 ?>
    <tr id="r_celular_1"<?= $Page->celular_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_celular_1"><?= $Page->celular_1->caption() ?></span></td>
        <td data-name="celular_1"<?= $Page->celular_1->cellAttributes() ?>>
<span id="el_sco_user_celular_1">
<span<?= $Page->celular_1->viewAttributes() ?>>
<?= $Page->celular_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->celular_2->Visible) { // celular_2 ?>
    <tr id="r_celular_2"<?= $Page->celular_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_celular_2"><?= $Page->celular_2->caption() ?></span></td>
        <td data-name="celular_2"<?= $Page->celular_2->cellAttributes() ?>>
<span id="el_sco_user_celular_2">
<span<?= $Page->celular_2->viewAttributes() ?>>
<?= $Page->celular_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_1->Visible) { // telefono_1 ?>
    <tr id="r_telefono_1"<?= $Page->telefono_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_telefono_1"><?= $Page->telefono_1->caption() ?></span></td>
        <td data-name="telefono_1"<?= $Page->telefono_1->cellAttributes() ?>>
<span id="el_sco_user_telefono_1">
<span<?= $Page->telefono_1->viewAttributes() ?>>
<?= $Page->telefono_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_user__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hora_entrada->Visible) { // hora_entrada ?>
    <tr id="r_hora_entrada"<?= $Page->hora_entrada->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_hora_entrada"><?= $Page->hora_entrada->caption() ?></span></td>
        <td data-name="hora_entrada"<?= $Page->hora_entrada->cellAttributes() ?>>
<span id="el_sco_user_hora_entrada">
<span<?= $Page->hora_entrada->viewAttributes() ?>>
<?= $Page->hora_entrada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hora_salida->Visible) { // hora_salida ?>
    <tr id="r_hora_salida"<?= $Page->hora_salida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_hora_salida"><?= $Page->hora_salida->caption() ?></span></td>
        <td data-name="hora_salida"<?= $Page->hora_salida->cellAttributes() ?>>
<span id="el_sco_user_hora_salida">
<span<?= $Page->hora_salida->viewAttributes() ?>>
<?= $Page->hora_salida->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <tr id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_proveedor"><?= $Page->proveedor->caption() ?></span></td>
        <td data-name="proveedor"<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_user_proveedor">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <tr id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_seguro"><?= $Page->seguro->caption() ?></span></td>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_user_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->evaluacion->Visible) { // evaluacion ?>
    <tr id="r_evaluacion"<?= $Page->evaluacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_user_evaluacion"><?= $Page->evaluacion->caption() ?></span></td>
        <td data-name="evaluacion"<?= $Page->evaluacion->cellAttributes() ?>>
<span id="el_sco_user_evaluacion">
<span<?= $Page->evaluacion->viewAttributes() ?>>
<?= $Page->evaluacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_user_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_user_nota->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_user_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoUserNotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_user_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_user_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_user_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoUserAdjuntoGrid.php" ?>
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
