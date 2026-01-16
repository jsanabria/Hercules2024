<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoLapidasRegistroView = &$Page;
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
<form name="fsco_lapidas_registroview" id="fsco_lapidas_registroview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_lapidas_registro: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_lapidas_registroview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_lapidas_registroview")
        .setPageId("view")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    /**
     * Genera el esquema visual de la lápida
     */

    /**
     * Envía el correo del boceto de forma asíncrona
     */
    function enviar_mail(id, ida) {
        const loadingToast = ew.showOverlay(); 
        $.getJSON('enviar_email_boceto_lapidas.php', { xid: id, xida: ida }, function(data) {
            if (data.status === "success") {
                ew.alert({
                    title: "¡Éxito!",
                    phrase: data.message,
                    icon: "success"
                });
            } else {
                ew.alert({
                    title: "Error",
                    phrase: data.message,
                    icon: "error"
                });
            }
        })
        .fail(function() {
            ew.alert("Error de red al intentar enviar el correo.");
        })
        .always(function() {
            if (loadingToast) ew.hideOverlay();
        });
    }
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_lapidas_registro">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nlapidas_registro->Visible) { // Nlapidas_registro ?>
    <tr id="r_Nlapidas_registro"<?= $Page->Nlapidas_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_Nlapidas_registro"><?= $Page->Nlapidas_registro->caption() ?></span></td>
        <td data-name="Nlapidas_registro"<?= $Page->Nlapidas_registro->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_Nlapidas_registro">
<span<?= $Page->Nlapidas_registro->viewAttributes() ?>>
<?= $Page->Nlapidas_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <tr id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_solicitante"><?= $Page->solicitante->caption() ?></span></td>
        <td data-name="solicitante"<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_solicitante">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parentesco->Visible) { // parentesco ?>
    <tr id="r_parentesco"<?= $Page->parentesco->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_parentesco"><?= $Page->parentesco->caption() ?></span></td>
        <td data-name="parentesco"<?= $Page->parentesco->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_parentesco">
<span<?= $Page->parentesco->viewAttributes() ?>>
<?= $Page->parentesco->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <tr id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_telefono1"><?= $Page->telefono1->caption() ?></span></td>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_telefono1">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <tr id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_telefono2"><?= $Page->telefono2->caption() ?></span></td>
        <td data-name="telefono2"<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_telefono2">
<span<?= $Page->telefono2->viewAttributes() ?>>
<?= $Page->telefono2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_lapidas_registro__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <tr id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_ci_difunto"><?= $Page->ci_difunto->caption() ?></span></td>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
    <tr id="r_nombre_difunto"<?= $Page->nombre_difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_nombre_difunto"><?= $Page->nombre_difunto->caption() ?></span></td>
        <td data-name="nombre_difunto"<?= $Page->nombre_difunto->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_nombre_difunto">
<span<?= $Page->nombre_difunto->viewAttributes() ?>>
<?= $Page->nombre_difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <tr id="r_comentario"<?= $Page->comentario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_comentario"><?= $Page->comentario->caption() ?></span></td>
        <td data-name="comentario"<?= $Page->comentario->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_comentario">
<span<?= $Page->comentario->viewAttributes() ?>>
<?= $Page->comentario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
    <tr id="r_registro"<?= $Page->registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_registro"><?= $Page->registro->caption() ?></span></td>
        <td data-name="registro"<?= $Page->registro->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_registro">
<span<?= $Page->registro->viewAttributes() ?>>
<?= $Page->registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->registra->Visible) { // registra ?>
    <tr id="r_registra"<?= $Page->registra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_registra"><?= $Page->registra->caption() ?></span></td>
        <td data-name="registra"<?= $Page->registra->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_registra">
<span<?= $Page->registra->viewAttributes() ?>>
<?= $Page->registra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modificacion->Visible) { // modificacion ?>
    <tr id="r_modificacion"<?= $Page->modificacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_modificacion"><?= $Page->modificacion->caption() ?></span></td>
        <td data-name="modificacion"<?= $Page->modificacion->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_modificacion">
<span<?= $Page->modificacion->viewAttributes() ?>>
<?= $Page->modificacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modifica->Visible) { // modifica ?>
    <tr id="r_modifica"<?= $Page->modifica->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_modifica"><?= $Page->modifica->caption() ?></span></td>
        <td data-name="modifica"<?= $Page->modifica->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_modifica">
<span<?= $Page->modifica->viewAttributes() ?>>
<?= $Page->modifica->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <tr id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_seccion"><?= $Page->seccion->caption() ?></span></td>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <tr id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_modulo"><?= $Page->modulo->caption() ?></span></td>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <tr id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_sub_seccion"><?= $Page->sub_seccion->caption() ?></span></td>
        <td data-name="sub_seccion"<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_sub_seccion">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <tr id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_parcela"><?= $Page->parcela->caption() ?></span></td>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <tr id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_boveda"><?= $Page->boveda->caption() ?></span></td>
        <td data-name="boveda"<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_boveda">
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
    <tr id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_contrato"><?= $Page->contrato->caption() ?></span></td>
        <td data-name="contrato"<?= $Page->contrato->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->maqueteo->Visible) { // maqueteo ?>
    <tr id="r_maqueteo"<?= $Page->maqueteo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_lapidas_registro_maqueteo"><?= $Page->maqueteo->caption() ?></span></td>
        <td data-name="maqueteo"<?= $Page->maqueteo->cellAttributes() ?>>
<span id="el_sco_lapidas_registro_maqueteo">
<span<?= $Page->maqueteo->viewAttributes() ?>>
<?= $Page->maqueteo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_lapidas_notas", explode(",", $Page->getCurrentDetailTable())) && $sco_lapidas_notas->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_lapidas_notas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoLapidasNotasGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_lapidas_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_lapidas_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_lapidas_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoLapidasAdjuntoGrid.php" ?>
<?php } ?>
</form>
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
