<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaView = &$Page;
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
<form name="fsco_parcelaview" id="fsco_parcelaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_parcelaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcelaview")
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
<input type="hidden" name="t" value="sco_parcela">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nparcela->Visible) { // Nparcela ?>
    <tr id="r_Nparcela"<?= $Page->Nparcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_Nparcela"><?= $Page->Nparcela->caption() ?></span></td>
        <td data-name="Nparcela"<?= $Page->Nparcela->cellAttributes() ?>>
<span id="el_sco_parcela_Nparcela">
<span<?= $Page->Nparcela->viewAttributes() ?>>
<?= $Page->Nparcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nacionalidad->Visible) { // nacionalidad ?>
    <tr id="r_nacionalidad"<?= $Page->nacionalidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_nacionalidad"><?= $Page->nacionalidad->caption() ?></span></td>
        <td data-name="nacionalidad"<?= $Page->nacionalidad->cellAttributes() ?>>
<span id="el_sco_parcela_nacionalidad">
<span<?= $Page->nacionalidad->viewAttributes() ?>>
<?= $Page->nacionalidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <tr id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_cedula"><?= $Page->cedula->caption() ?></span></td>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el_sco_parcela_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <tr id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_titular"><?= $Page->titular->caption() ?></span></td>
        <td data-name="titular"<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_parcela_titular">
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
    <tr id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_contrato"><?= $Page->contrato->caption() ?></span></td>
        <td data-name="contrato"<?= $Page->contrato->cellAttributes() ?>>
<span id="el_sco_parcela_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <tr id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_seccion"><?= $Page->seccion->caption() ?></span></td>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_parcela_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <tr id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_modulo"><?= $Page->modulo->caption() ?></span></td>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_parcela_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <tr id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_sub_seccion"><?= $Page->sub_seccion->caption() ?></span></td>
        <td data-name="sub_seccion"<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_parcela_sub_seccion">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <tr id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_parcela"><?= $Page->parcela->caption() ?></span></td>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_parcela_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <tr id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_boveda"><?= $Page->boveda->caption() ?></span></td>
        <td data-name="boveda"<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_parcela_boveda">
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
    <tr id="r_apellido1"<?= $Page->apellido1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_apellido1"><?= $Page->apellido1->caption() ?></span></td>
        <td data-name="apellido1"<?= $Page->apellido1->cellAttributes() ?>>
<span id="el_sco_parcela_apellido1">
<span<?= $Page->apellido1->viewAttributes() ?>>
<?= $Page->apellido1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
    <tr id="r_apellido2"<?= $Page->apellido2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_apellido2"><?= $Page->apellido2->caption() ?></span></td>
        <td data-name="apellido2"<?= $Page->apellido2->cellAttributes() ?>>
<span id="el_sco_parcela_apellido2">
<span<?= $Page->apellido2->viewAttributes() ?>>
<?= $Page->apellido2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
    <tr id="r_nombre1"<?= $Page->nombre1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_nombre1"><?= $Page->nombre1->caption() ?></span></td>
        <td data-name="nombre1"<?= $Page->nombre1->cellAttributes() ?>>
<span id="el_sco_parcela_nombre1">
<span<?= $Page->nombre1->viewAttributes() ?>>
<?= $Page->nombre1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
    <tr id="r_nombre2"<?= $Page->nombre2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_nombre2"><?= $Page->nombre2->caption() ?></span></td>
        <td data-name="nombre2"<?= $Page->nombre2->cellAttributes() ?>>
<span id="el_sco_parcela_nombre2">
<span<?= $Page->nombre2->viewAttributes() ?>>
<?= $Page->nombre2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
    <tr id="r_fecha_inhumacion"<?= $Page->fecha_inhumacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_fecha_inhumacion"><?= $Page->fecha_inhumacion->caption() ?></span></td>
        <td data-name="fecha_inhumacion"<?= $Page->fecha_inhumacion->cellAttributes() ?>>
<span id="el_sco_parcela_fecha_inhumacion">
<span<?= $Page->fecha_inhumacion->viewAttributes() ?>>
<?= $Page->fecha_inhumacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <tr id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_telefono1"><?= $Page->telefono1->caption() ?></span></td>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_parcela_telefono1">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <tr id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_telefono2"><?= $Page->telefono2->caption() ?></span></td>
        <td data-name="telefono2"<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_parcela_telefono2">
<span<?= $Page->telefono2->viewAttributes() ?>>
<?= $Page->telefono2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono3->Visible) { // telefono3 ?>
    <tr id="r_telefono3"<?= $Page->telefono3->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_telefono3"><?= $Page->telefono3->caption() ?></span></td>
        <td data-name="telefono3"<?= $Page->telefono3->cellAttributes() ?>>
<span id="el_sco_parcela_telefono3">
<span<?= $Page->telefono3->viewAttributes() ?>>
<?= $Page->telefono3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direc1->Visible) { // direc1 ?>
    <tr id="r_direc1"<?= $Page->direc1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_direc1"><?= $Page->direc1->caption() ?></span></td>
        <td data-name="direc1"<?= $Page->direc1->cellAttributes() ?>>
<span id="el_sco_parcela_direc1">
<span<?= $Page->direc1->viewAttributes() ?>>
<?= $Page->direc1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direc2->Visible) { // direc2 ?>
    <tr id="r_direc2"<?= $Page->direc2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_direc2"><?= $Page->direc2->caption() ?></span></td>
        <td data-name="direc2"<?= $Page->direc2->cellAttributes() ?>>
<span id="el_sco_parcela_direc2">
<span<?= $Page->direc2->viewAttributes() ?>>
<?= $Page->direc2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_parcela__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nac_ci_asociado->Visible) { // nac_ci_asociado ?>
    <tr id="r_nac_ci_asociado"<?= $Page->nac_ci_asociado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_nac_ci_asociado"><?= $Page->nac_ci_asociado->caption() ?></span></td>
        <td data-name="nac_ci_asociado"<?= $Page->nac_ci_asociado->cellAttributes() ?>>
<span id="el_sco_parcela_nac_ci_asociado">
<span<?= $Page->nac_ci_asociado->viewAttributes() ?>>
<?= $Page->nac_ci_asociado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ci_asociado->Visible) { // ci_asociado ?>
    <tr id="r_ci_asociado"<?= $Page->ci_asociado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_ci_asociado"><?= $Page->ci_asociado->caption() ?></span></td>
        <td data-name="ci_asociado"<?= $Page->ci_asociado->cellAttributes() ?>>
<span id="el_sco_parcela_ci_asociado">
<span<?= $Page->ci_asociado->viewAttributes() ?>>
<?= $Page->ci_asociado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_asociado->Visible) { // nombre_asociado ?>
    <tr id="r_nombre_asociado"<?= $Page->nombre_asociado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_nombre_asociado"><?= $Page->nombre_asociado->caption() ?></span></td>
        <td data-name="nombre_asociado"<?= $Page->nombre_asociado->cellAttributes() ?>>
<span id="el_sco_parcela_nombre_asociado">
<span<?= $Page->nombre_asociado->viewAttributes() ?>>
<?= $Page->nombre_asociado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nac_difunto->Visible) { // nac_difunto ?>
    <tr id="r_nac_difunto"<?= $Page->nac_difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_nac_difunto"><?= $Page->nac_difunto->caption() ?></span></td>
        <td data-name="nac_difunto"<?= $Page->nac_difunto->cellAttributes() ?>>
<span id="el_sco_parcela_nac_difunto">
<span<?= $Page->nac_difunto->viewAttributes() ?>>
<?= $Page->nac_difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <tr id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_ci_difunto"><?= $Page->ci_difunto->caption() ?></span></td>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_parcela_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->edad->Visible) { // edad ?>
    <tr id="r_edad"<?= $Page->edad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_edad"><?= $Page->edad->caption() ?></span></td>
        <td data-name="edad"<?= $Page->edad->cellAttributes() ?>>
<span id="el_sco_parcela_edad">
<span<?= $Page->edad->viewAttributes() ?>>
<?= $Page->edad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->edo_civil->Visible) { // edo_civil ?>
    <tr id="r_edo_civil"<?= $Page->edo_civil->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_edo_civil"><?= $Page->edo_civil->caption() ?></span></td>
        <td data-name="edo_civil"<?= $Page->edo_civil->cellAttributes() ?>>
<span id="el_sco_parcela_edo_civil">
<span<?= $Page->edo_civil->viewAttributes() ?>>
<?= $Page->edo_civil->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <tr id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_fecha_nacimiento"><?= $Page->fecha_nacimiento->caption() ?></span></td>
        <td data-name="fecha_nacimiento"<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_parcela_fecha_nacimiento">
<span<?= $Page->fecha_nacimiento->viewAttributes() ?>>
<?= $Page->fecha_nacimiento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lugar->Visible) { // lugar ?>
    <tr id="r_lugar"<?= $Page->lugar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_lugar"><?= $Page->lugar->caption() ?></span></td>
        <td data-name="lugar"<?= $Page->lugar->cellAttributes() ?>>
<span id="el_sco_parcela_lugar">
<span<?= $Page->lugar->viewAttributes() ?>>
<?= $Page->lugar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_defuncion->Visible) { // fecha_defuncion ?>
    <tr id="r_fecha_defuncion"<?= $Page->fecha_defuncion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_fecha_defuncion"><?= $Page->fecha_defuncion->caption() ?></span></td>
        <td data-name="fecha_defuncion"<?= $Page->fecha_defuncion->cellAttributes() ?>>
<span id="el_sco_parcela_fecha_defuncion">
<span<?= $Page->fecha_defuncion->viewAttributes() ?>>
<?= $Page->fecha_defuncion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa->Visible) { // causa ?>
    <tr id="r_causa"<?= $Page->causa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_causa"><?= $Page->causa->caption() ?></span></td>
        <td data-name="causa"<?= $Page->causa->cellAttributes() ?>>
<span id="el_sco_parcela_causa">
<span<?= $Page->causa->viewAttributes() ?>>
<?= $Page->causa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->certificado->Visible) { // certificado ?>
    <tr id="r_certificado"<?= $Page->certificado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_certificado"><?= $Page->certificado->caption() ?></span></td>
        <td data-name="certificado"<?= $Page->certificado->cellAttributes() ?>>
<span id="el_sco_parcela_certificado">
<span<?= $Page->certificado->viewAttributes() ?>>
<?= $Page->certificado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <tr id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_parcela_funeraria"><?= $Page->funeraria->caption() ?></span></td>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_parcela_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
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
