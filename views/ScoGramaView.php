<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGramaView = &$Page;
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
<form name="fsco_gramaview" id="fsco_gramaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_grama: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_gramaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_gramaview")
        .setPageId("view")

        // Multi-Page
        .setMultiPage(true)
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
<input type="hidden" name="t" value="sco_grama">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if ($Page->MultiPages->Items[0]->Visible) { ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Ngrama->Visible) { // Ngrama ?>
    <tr id="r_Ngrama"<?= $Page->Ngrama->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_Ngrama"><?= $Page->Ngrama->caption() ?></span></td>
        <td data-name="Ngrama"<?= $Page->Ngrama->cellAttributes() ?>>
<span id="el_sco_grama_Ngrama" data-page="0">
<span<?= $Page->Ngrama->viewAttributes() ?>>
<?= $Page->Ngrama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_grama_tipo" data-page="0">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subtipo->Visible) { // subtipo ?>
    <tr id="r_subtipo"<?= $Page->subtipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_subtipo"><?= $Page->subtipo->caption() ?></span></td>
        <td data-name="subtipo"<?= $Page->subtipo->cellAttributes() ?>>
<span id="el_sco_grama_subtipo" data-page="0">
<span<?= $Page->subtipo->viewAttributes() ?>>
<?= $Page->subtipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_ScoGramaView"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_sco_grama1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_grama1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_sco_grama2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_grama2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_sco_grama3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_grama3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>">
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_sco_grama1" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->contrato->Visible) { // contrato ?>
    <tr id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_contrato"><?= $Page->contrato->caption() ?></span></td>
        <td data-name="contrato"<?= $Page->contrato->cellAttributes() ?>>
<span id="el_sco_grama_contrato" data-page="1">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <tr id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_seccion"><?= $Page->seccion->caption() ?></span></td>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_grama_seccion" data-page="1">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <tr id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_modulo"><?= $Page->modulo->caption() ?></span></td>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_grama_modulo" data-page="1">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <tr id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_sub_seccion"><?= $Page->sub_seccion->caption() ?></span></td>
        <td data-name="sub_seccion"<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_grama_sub_seccion" data-page="1">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <tr id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_parcela"><?= $Page->parcela->caption() ?></span></td>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_grama_parcela" data-page="1">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <tr id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_boveda"><?= $Page->boveda->caption() ?></span></td>
        <td data-name="boveda"<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_grama_boveda" data-page="1">
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <tr id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_ci_difunto"><?= $Page->ci_difunto->caption() ?></span></td>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_grama_ci_difunto" data-page="1">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
    <tr id="r_apellido1"<?= $Page->apellido1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_apellido1"><?= $Page->apellido1->caption() ?></span></td>
        <td data-name="apellido1"<?= $Page->apellido1->cellAttributes() ?>>
<span id="el_sco_grama_apellido1" data-page="1">
<span<?= $Page->apellido1->viewAttributes() ?>>
<?= $Page->apellido1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
    <tr id="r_apellido2"<?= $Page->apellido2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_apellido2"><?= $Page->apellido2->caption() ?></span></td>
        <td data-name="apellido2"<?= $Page->apellido2->cellAttributes() ?>>
<span id="el_sco_grama_apellido2" data-page="1">
<span<?= $Page->apellido2->viewAttributes() ?>>
<?= $Page->apellido2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
    <tr id="r_nombre1"<?= $Page->nombre1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_nombre1"><?= $Page->nombre1->caption() ?></span></td>
        <td data-name="nombre1"<?= $Page->nombre1->cellAttributes() ?>>
<span id="el_sco_grama_nombre1" data-page="1">
<span<?= $Page->nombre1->viewAttributes() ?>>
<?= $Page->nombre1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
    <tr id="r_nombre2"<?= $Page->nombre2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_nombre2"><?= $Page->nombre2->caption() ?></span></td>
        <td data-name="nombre2"<?= $Page->nombre2->cellAttributes() ?>>
<span id="el_sco_grama_nombre2" data-page="1">
<span<?= $Page->nombre2->viewAttributes() ?>>
<?= $Page->nombre2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_sco_grama2" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->ci_solicitante->Visible) { // ci_solicitante ?>
    <tr id="r_ci_solicitante"<?= $Page->ci_solicitante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_ci_solicitante"><?= $Page->ci_solicitante->caption() ?></span></td>
        <td data-name="ci_solicitante"<?= $Page->ci_solicitante->cellAttributes() ?>>
<span id="el_sco_grama_ci_solicitante" data-page="2">
<span<?= $Page->ci_solicitante->viewAttributes() ?>>
<?= $Page->ci_solicitante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <tr id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_solicitante"><?= $Page->solicitante->caption() ?></span></td>
        <td data-name="solicitante"<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_sco_grama_solicitante" data-page="2">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <tr id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_telefono1"><?= $Page->telefono1->caption() ?></span></td>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_grama_telefono1" data-page="2">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <tr id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_telefono2"><?= $Page->telefono2->caption() ?></span></td>
        <td data-name="telefono2"<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_grama_telefono2" data-page="2">
<span<?= $Page->telefono2->viewAttributes() ?>>
<?= $Page->telefono2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_grama__email" data-page="2">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <tr id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_monto"><?= $Page->monto->caption() ?></span></td>
        <td data-name="monto"<?= $Page->monto->cellAttributes() ?>>
<span id="el_sco_grama_monto" data-page="2">
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <tr id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_tasa"><?= $Page->tasa->caption() ?></span></td>
        <td data-name="tasa"<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_grama_tasa" data-page="2">
<span<?= $Page->tasa->viewAttributes() ?>>
<?= $Page->tasa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
    <tr id="r_monto_bs"<?= $Page->monto_bs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_monto_bs"><?= $Page->monto_bs->caption() ?></span></td>
        <td data-name="monto_bs"<?= $Page->monto_bs->cellAttributes() ?>>
<span id="el_sco_grama_monto_bs" data-page="2">
<span<?= $Page->monto_bs->viewAttributes() ?>>
<?= $Page->monto_bs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_grama_nota" data-page="2">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_sco_grama3" role="tabpanel"><!-- multi-page .tab-pane -->
<?php } ?>
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->fecha_solucion->Visible) { // fecha_solucion ?>
    <tr id="r_fecha_solucion"<?= $Page->fecha_solucion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_fecha_solucion"><?= $Page->fecha_solucion->caption() ?></span></td>
        <td data-name="fecha_solucion"<?= $Page->fecha_solucion->cellAttributes() ?>>
<span id="el_sco_grama_fecha_solucion" data-page="3">
<span<?= $Page->fecha_solucion->viewAttributes() ?>>
<?= $Page->fecha_solucion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_desde->Visible) { // fecha_desde ?>
    <tr id="r_fecha_desde"<?= $Page->fecha_desde->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_fecha_desde"><?= $Page->fecha_desde->caption() ?></span></td>
        <td data-name="fecha_desde"<?= $Page->fecha_desde->cellAttributes() ?>>
<span id="el_sco_grama_fecha_desde" data-page="3">
<span<?= $Page->fecha_desde->viewAttributes() ?>>
<?= $Page->fecha_desde->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_hasta->Visible) { // fecha_hasta ?>
    <tr id="r_fecha_hasta"<?= $Page->fecha_hasta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_fecha_hasta"><?= $Page->fecha_hasta->caption() ?></span></td>
        <td data-name="fecha_hasta"<?= $Page->fecha_hasta->cellAttributes() ?>>
<span id="el_sco_grama_fecha_hasta" data-page="3">
<span<?= $Page->fecha_hasta->viewAttributes() ?>>
<?= $Page->fecha_hasta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_grama_estatus" data-page="3">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_grama_fecha_registro" data-page="3">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario_registro->Visible) { // usuario_registro ?>
    <tr id="r_usuario_registro"<?= $Page->usuario_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_grama_usuario_registro"><?= $Page->usuario_registro->caption() ?></span></td>
        <td data-name="usuario_registro"<?= $Page->usuario_registro->cellAttributes() ?>>
<span id="el_sco_grama_usuario_registro" data-page="3">
<span<?= $Page->usuario_registro->viewAttributes() ?>>
<?= $Page->usuario_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->isExport()) { ?>
        </div><!-- /multi-page .tab-pane -->
<?php } ?>
<?php if (!$Page->isExport()) { ?>
    </div>
</div>
</div>
<?php } ?>
<?php
    if (in_array("sco_grama_pagos", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_pagos->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_pagos", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaPagosGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_grama_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_nota->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaNotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_grama_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaAdjuntoGrid.php" ?>
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
