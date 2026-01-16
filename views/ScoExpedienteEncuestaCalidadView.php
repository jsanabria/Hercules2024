<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteEncuestaCalidadView = &$Page;
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
<form name="fsco_expediente_encuesta_calidadview" id="fsco_expediente_encuesta_calidadview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_encuesta_calidad: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_expediente_encuesta_calidadview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_encuesta_calidadview")
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
<input type="hidden" name="t" value="sco_expediente_encuesta_calidad">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->pregunta->Visible) { // pregunta ?>
    <tr id="r_pregunta"<?= $Page->pregunta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_encuesta_calidad_pregunta"><?= $Page->pregunta->caption() ?></span></td>
        <td data-name="pregunta"<?= $Page->pregunta->cellAttributes() ?>>
<span id="el_sco_expediente_encuesta_calidad_pregunta">
<span<?= $Page->pregunta->viewAttributes() ?>>
<?= $Page->pregunta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->respuesta->Visible) { // respuesta ?>
    <tr id="r_respuesta"<?= $Page->respuesta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_encuesta_calidad_respuesta"><?= $Page->respuesta->caption() ?></span></td>
        <td data-name="respuesta"<?= $Page->respuesta->cellAttributes() ?>>
<span id="el_sco_expediente_encuesta_calidad_respuesta">
<span<?= $Page->respuesta->viewAttributes() ?>>
<?= $Page->respuesta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
    <tr id="r_fecha_hora"<?= $Page->fecha_hora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_encuesta_calidad_fecha_hora"><?= $Page->fecha_hora->caption() ?></span></td>
        <td data-name="fecha_hora"<?= $Page->fecha_hora->cellAttributes() ?>>
<span id="el_sco_expediente_encuesta_calidad_fecha_hora">
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
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
