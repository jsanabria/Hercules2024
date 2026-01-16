<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoView = &$Page;
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
<form name="fsco_mttotecnicoview" id="fsco_mttotecnicoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_mttotecnicoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnicoview")
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
<input type="hidden" name="t" value="sco_mttotecnico">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nmttotecnico->Visible) { // Nmttotecnico ?>
    <tr id="r_Nmttotecnico"<?= $Page->Nmttotecnico->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_Nmttotecnico"><?= $Page->Nmttotecnico->caption() ?></span></td>
        <td data-name="Nmttotecnico"<?= $Page->Nmttotecnico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_Nmttotecnico">
<span<?= $Page->Nmttotecnico->viewAttributes() ?>>
<?= $Page->Nmttotecnico->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_mttotecnico_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_solicita->Visible) { // user_solicita ?>
    <tr id="r_user_solicita"<?= $Page->user_solicita->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_user_solicita"><?= $Page->user_solicita->caption() ?></span></td>
        <td data-name="user_solicita"<?= $Page->user_solicita->cellAttributes() ?>>
<span id="el_sco_mttotecnico_user_solicita">
<span<?= $Page->user_solicita->viewAttributes() ?>>
<?= $Page->user_solicita->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
    <tr id="r_tipo_solicitud"<?= $Page->tipo_solicitud->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_tipo_solicitud"><?= $Page->tipo_solicitud->caption() ?></span></td>
        <td data-name="tipo_solicitud"<?= $Page->tipo_solicitud->cellAttributes() ?>>
<span id="el_sco_mttotecnico_tipo_solicitud">
<span<?= $Page->tipo_solicitud->viewAttributes() ?>>
<?= $Page->tipo_solicitud->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
    <tr id="r_unidad_solicitante"<?= $Page->unidad_solicitante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_unidad_solicitante"><?= $Page->unidad_solicitante->caption() ?></span></td>
        <td data-name="unidad_solicitante"<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_mttotecnico_unidad_solicitante">
<span<?= $Page->unidad_solicitante->viewAttributes() ?>>
<?= $Page->unidad_solicitante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->area_falla->Visible) { // area_falla ?>
    <tr id="r_area_falla"<?= $Page->area_falla->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_area_falla"><?= $Page->area_falla->caption() ?></span></td>
        <td data-name="area_falla"<?= $Page->area_falla->cellAttributes() ?>>
<span id="el_sco_mttotecnico_area_falla">
<span<?= $Page->area_falla->viewAttributes() ?>>
<?= $Page->area_falla->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <tr id="r_comentario"<?= $Page->comentario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_comentario"><?= $Page->comentario->caption() ?></span></td>
        <td data-name="comentario"<?= $Page->comentario->cellAttributes() ?>>
<span id="el_sco_mttotecnico_comentario">
<span<?= $Page->comentario->viewAttributes() ?>>
<?= $Page->comentario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->prioridad->Visible) { // prioridad ?>
    <tr id="r_prioridad"<?= $Page->prioridad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_prioridad"><?= $Page->prioridad->caption() ?></span></td>
        <td data-name="prioridad"<?= $Page->prioridad->cellAttributes() ?>>
<span id="el_sco_mttotecnico_prioridad">
<span<?= $Page->prioridad->viewAttributes() ?>>
<?= $Page->prioridad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_mttotecnico_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->falla_atendida_por->Visible) { // falla_atendida_por ?>
    <tr id="r_falla_atendida_por"<?= $Page->falla_atendida_por->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_falla_atendida_por"><?= $Page->falla_atendida_por->caption() ?></span></td>
        <td data-name="falla_atendida_por"<?= $Page->falla_atendida_por->cellAttributes() ?>>
<span id="el_sco_mttotecnico_falla_atendida_por">
<span<?= $Page->falla_atendida_por->viewAttributes() ?>>
<?= $Page->falla_atendida_por->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
    <tr id="r_diagnostico"<?= $Page->diagnostico->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_diagnostico"><?= $Page->diagnostico->caption() ?></span></td>
        <td data-name="diagnostico"<?= $Page->diagnostico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_diagnostico">
<span<?= $Page->diagnostico->viewAttributes() ?>>
<?= $Page->diagnostico->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->solucion->Visible) { // solucion ?>
    <tr id="r_solucion"<?= $Page->solucion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_solucion"><?= $Page->solucion->caption() ?></span></td>
        <td data-name="solucion"<?= $Page->solucion->cellAttributes() ?>>
<span id="el_sco_mttotecnico_solucion">
<span<?= $Page->solucion->viewAttributes() ?>>
<?= $Page->solucion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_diagnostico->Visible) { // user_diagnostico ?>
    <tr id="r_user_diagnostico"<?= $Page->user_diagnostico->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_user_diagnostico"><?= $Page->user_diagnostico->caption() ?></span></td>
        <td data-name="user_diagnostico"<?= $Page->user_diagnostico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_user_diagnostico">
<span<?= $Page->user_diagnostico->viewAttributes() ?>>
<?= $Page->user_diagnostico->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
    <tr id="r_requiere_materiales"<?= $Page->requiere_materiales->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_requiere_materiales"><?= $Page->requiere_materiales->caption() ?></span></td>
        <td data-name="requiere_materiales"<?= $Page->requiere_materiales->cellAttributes() ?>>
<span id="el_sco_mttotecnico_requiere_materiales">
<span<?= $Page->requiere_materiales->viewAttributes() ?>>
<?= $Page->requiere_materiales->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_solucion->Visible) { // fecha_solucion ?>
    <tr id="r_fecha_solucion"<?= $Page->fecha_solucion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_fecha_solucion"><?= $Page->fecha_solucion->caption() ?></span></td>
        <td data-name="fecha_solucion"<?= $Page->fecha_solucion->cellAttributes() ?>>
<span id="el_sco_mttotecnico_fecha_solucion">
<span<?= $Page->fecha_solucion->viewAttributes() ?>>
<?= $Page->fecha_solucion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_mttotecnico_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_mttotecnico_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mttotecnico_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMttotecnicoAdjuntoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_mttotecnico_notas", explode(",", $Page->getCurrentDetailTable())) && $sco_mttotecnico_notas->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mttotecnico_notas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMttotecnicoNotasGrid.php" ?>
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
