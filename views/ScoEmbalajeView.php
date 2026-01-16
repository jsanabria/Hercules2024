<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEmbalajeView = &$Page;
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
<form name="fsco_embalajeview" id="fsco_embalajeview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_embalaje: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_embalajeview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_embalajeview")
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
<input type="hidden" name="t" value="sco_embalaje">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_embalaje_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->precinto1->Visible) { // precinto1 ?>
    <tr id="r_precinto1"<?= $Page->precinto1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_precinto1"><?= $Page->precinto1->caption() ?></span></td>
        <td data-name="precinto1"<?= $Page->precinto1->cellAttributes() ?>>
<span id="el_sco_embalaje_precinto1">
<span<?= $Page->precinto1->viewAttributes() ?>>
<?= $Page->precinto1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->precinto2->Visible) { // precinto2 ?>
    <tr id="r_precinto2"<?= $Page->precinto2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_precinto2"><?= $Page->precinto2->caption() ?></span></td>
        <td data-name="precinto2"<?= $Page->precinto2->cellAttributes() ?>>
<span id="el_sco_embalaje_precinto2">
<span<?= $Page->precinto2->viewAttributes() ?>>
<?= $Page->precinto2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_familiar->Visible) { // nombre_familiar ?>
    <tr id="r_nombre_familiar"<?= $Page->nombre_familiar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_nombre_familiar"><?= $Page->nombre_familiar->caption() ?></span></td>
        <td data-name="nombre_familiar"<?= $Page->nombre_familiar->cellAttributes() ?>>
<span id="el_sco_embalaje_nombre_familiar">
<span<?= $Page->nombre_familiar->viewAttributes() ?>>
<?= $Page->nombre_familiar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_familiar->Visible) { // cedula_familiar ?>
    <tr id="r_cedula_familiar"<?= $Page->cedula_familiar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_cedula_familiar"><?= $Page->cedula_familiar->caption() ?></span></td>
        <td data-name="cedula_familiar"<?= $Page->cedula_familiar->cellAttributes() ?>>
<span id="el_sco_embalaje_cedula_familiar">
<span<?= $Page->cedula_familiar->viewAttributes() ?>>
<?= $Page->cedula_familiar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
    <tr id="r_certificado_defuncion"<?= $Page->certificado_defuncion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_certificado_defuncion"><?= $Page->certificado_defuncion->caption() ?></span></td>
        <td data-name="certificado_defuncion"<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="el_sco_embalaje_certificado_defuncion">
<span<?= $Page->certificado_defuncion->viewAttributes() ?>>
<?= $Page->certificado_defuncion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <tr id="r_fecha_servicio"<?= $Page->fecha_servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_fecha_servicio"><?= $Page->fecha_servicio->caption() ?></span></td>
        <td data-name="fecha_servicio"<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el_sco_embalaje_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<?= $Page->fecha_servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cremacion_nro->Visible) { // cremacion_nro ?>
    <tr id="r_cremacion_nro"<?= $Page->cremacion_nro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_cremacion_nro"><?= $Page->cremacion_nro->caption() ?></span></td>
        <td data-name="cremacion_nro"<?= $Page->cremacion_nro->cellAttributes() ?>>
<span id="el_sco_embalaje_cremacion_nro">
<span<?= $Page->cremacion_nro->viewAttributes() ?>>
<?= $Page->cremacion_nro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dimension_cofre->Visible) { // dimension_cofre ?>
    <tr id="r_dimension_cofre"<?= $Page->dimension_cofre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_dimension_cofre"><?= $Page->dimension_cofre->caption() ?></span></td>
        <td data-name="dimension_cofre"<?= $Page->dimension_cofre->cellAttributes() ?>>
<span id="el_sco_embalaje_dimension_cofre">
<span<?= $Page->dimension_cofre->viewAttributes() ?>>
<?= $Page->dimension_cofre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_embalaje_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_embalaje__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->anulado->Visible) { // anulado ?>
    <tr id="r_anulado"<?= $Page->anulado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_embalaje_anulado"><?= $Page->anulado->caption() ?></span></td>
        <td data-name="anulado"<?= $Page->anulado->cellAttributes() ?>>
<span id="el_sco_embalaje_anulado">
<span<?= $Page->anulado->viewAttributes() ?>>
<?= $Page->anulado->getViewValue() ?></span>
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
