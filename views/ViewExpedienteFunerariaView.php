<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewExpedienteFunerariaView = &$Page;
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
<form name="fview_expediente_funerariaview" id="fview_expediente_funerariaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente_funeraria: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fview_expediente_funerariaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_expediente_funerariaview")
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
<input type="hidden" name="t" value="view_expediente_funeraria">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->expediente->Visible) { // expediente ?>
    <tr id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_expediente"><?= $Page->expediente->caption() ?></span></td>
        <td data-name="expediente"<?= $Page->expediente->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <tr id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_servicio"><?= $Page->servicio->caption() ?></span></td>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <tr id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></td>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <tr id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></td>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <tr id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></td>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <tr id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_causa_ocurrencia"><?= $Page->causa_ocurrencia->caption() ?></span></td>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <tr id="r_fecha_servicio"<?= $Page->fecha_servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_fecha_servicio"><?= $Page->fecha_servicio->caption() ?></span></td>
        <td data-name="fecha_servicio"<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<?= $Page->fecha_servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
    <tr id="r_hora_fin"<?= $Page->hora_fin->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_hora_fin"><?= $Page->hora_fin->caption() ?></span></td>
        <td data-name="hora_fin"<?= $Page->hora_fin->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_hora_fin">
<span<?= $Page->hora_fin->viewAttributes() ?>>
<?= $Page->hora_fin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <tr id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_funeraria"><?= $Page->funeraria->caption() ?></span></td>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <tr id="r_user_registra"<?= $Page->user_registra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_user_registra"><?= $Page->user_registra->caption() ?></span></td>
        <td data-name="user_registra"<?= $Page->user_registra->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_user_registra">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_expediente_funeraria_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
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
