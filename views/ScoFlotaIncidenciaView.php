<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaIncidenciaView = &$Page;
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
<form name="fsco_flota_incidenciaview" id="fsco_flota_incidenciaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_flota_incidenciaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flota_incidenciaview")
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
    // Write your client script here, no need to add script tags.
    function enviar_mail(incidencia, correo) {
    	if(confirm("Seguro que quiere enviar este correo electronico a: " + correo +"?"))
    		window.location.href = "dashboard/autogestion/email_taller.php?incidencia=" + incidencia;
    }
});
</script>
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_flota_incidencia">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nflota_incidencia->Visible) { // Nflota_incidencia ?>
    <tr id="r_Nflota_incidencia"<?= $Page->Nflota_incidencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_Nflota_incidencia"><?= $Page->Nflota_incidencia->caption() ?></span></td>
        <td data-name="Nflota_incidencia"<?= $Page->Nflota_incidencia->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_Nflota_incidencia">
<span<?= $Page->Nflota_incidencia->viewAttributes() ?>>
<?= $Page->Nflota_incidencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->flota->Visible) { // flota ?>
    <tr id="r_flota"<?= $Page->flota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_flota"><?= $Page->flota->caption() ?></span></td>
        <td data-name="flota"<?= $Page->flota->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_flota">
<span<?= $Page->flota->viewAttributes() ?>>
<?= $Page->flota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <tr id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_tipo"><?= $Page->tipo->caption() ?></span></td>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->falla->Visible) { // falla ?>
    <tr id="r_falla"<?= $Page->falla->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_falla"><?= $Page->falla->caption() ?></span></td>
        <td data-name="falla"<?= $Page->falla->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_falla">
<span<?= $Page->falla->viewAttributes() ?>>
<?= $Page->falla->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <tr id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_solicitante"><?= $Page->solicitante->caption() ?></span></td>
        <td data-name="solicitante"<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_solicitante">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
    <tr id="r_diagnostico"<?= $Page->diagnostico->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_diagnostico"><?= $Page->diagnostico->caption() ?></span></td>
        <td data-name="diagnostico"<?= $Page->diagnostico->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_diagnostico">
<span<?= $Page->diagnostico->viewAttributes() ?>>
<?= $Page->diagnostico->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reparacion->Visible) { // reparacion ?>
    <tr id="r_reparacion"<?= $Page->reparacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_reparacion"><?= $Page->reparacion->caption() ?></span></td>
        <td data-name="reparacion"<?= $Page->reparacion->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_reparacion">
<span<?= $Page->reparacion->viewAttributes() ?>>
<?= $Page->reparacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cambio_aceite->Visible) { // cambio_aceite ?>
    <tr id="r_cambio_aceite"<?= $Page->cambio_aceite->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_cambio_aceite"><?= $Page->cambio_aceite->caption() ?></span></td>
        <td data-name="cambio_aceite"<?= $Page->cambio_aceite->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_cambio_aceite">
<span<?= $Page->cambio_aceite->viewAttributes() ?>>
<?= $Page->cambio_aceite->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kilometraje->Visible) { // kilometraje ?>
    <tr id="r_kilometraje"<?= $Page->kilometraje->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_kilometraje"><?= $Page->kilometraje->caption() ?></span></td>
        <td data-name="kilometraje"<?= $Page->kilometraje->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_kilometraje">
<span<?= $Page->kilometraje->viewAttributes() ?>>
<?= $Page->kilometraje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <tr id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_proveedor"><?= $Page->proveedor->caption() ?></span></td>
        <td data-name="proveedor"<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_proveedor">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <tr id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_monto"><?= $Page->monto->caption() ?></span></td>
        <td data-name="monto"<?= $Page->monto->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_monto">
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_flota_incidencia__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->username_diagnostica->Visible) { // username_diagnostica ?>
    <tr id="r_username_diagnostica"<?= $Page->username_diagnostica->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_username_diagnostica"><?= $Page->username_diagnostica->caption() ?></span></td>
        <td data-name="username_diagnostica"<?= $Page->username_diagnostica->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_username_diagnostica">
<span<?= $Page->username_diagnostica->viewAttributes() ?>>
<?= $Page->username_diagnostica->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_reparacion->Visible) { // fecha_reparacion ?>
    <tr id="r_fecha_reparacion"<?= $Page->fecha_reparacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_flota_incidencia_fecha_reparacion"><?= $Page->fecha_reparacion->caption() ?></span></td>
        <td data-name="fecha_reparacion"<?= $Page->fecha_reparacion->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_fecha_reparacion">
<span<?= $Page->fecha_reparacion->viewAttributes() ?>>
<?= $Page->fecha_reparacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_flota_incidencia_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_flota_incidencia_detalle->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_flota_incidencia_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoFlotaIncidenciaDetalleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
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
