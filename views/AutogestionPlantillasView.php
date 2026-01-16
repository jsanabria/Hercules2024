<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionPlantillasView = &$Page;
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
<form name="fautogestion_plantillasview" id="fautogestion_plantillasview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_plantillas: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fautogestion_plantillasview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fautogestion_plantillasview")
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
<input type="hidden" name="t" value="autogestion_plantillas">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <tr id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></td>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_autogestion_plantillas_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
    <tr id="r_script"<?= $Page->script->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_script"><?= $Page->script->caption() ?></span></td>
        <td data-name="script"<?= $Page->script->cellAttributes() ?>>
<span id="el_autogestion_plantillas_script">
<span<?= $Page->script->viewAttributes() ?>>
<?= $Page->script->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
    <tr id="r_nivel"<?= $Page->nivel->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_nivel"><?= $Page->nivel->caption() ?></span></td>
        <td data-name="nivel"<?= $Page->nivel->cellAttributes() ?>>
<span id="el_autogestion_plantillas_nivel">
<span<?= $Page->nivel->viewAttributes() ?>>
<?= $Page->nivel->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
    <tr id="r_orden"<?= $Page->orden->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_orden"><?= $Page->orden->caption() ?></span></td>
        <td data-name="orden"<?= $Page->orden->cellAttributes() ?>>
<span id="el_autogestion_plantillas_orden">
<span<?= $Page->orden->viewAttributes() ?>>
<?= $Page->orden->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
    <tr id="r_codigo"<?= $Page->codigo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_codigo"><?= $Page->codigo->caption() ?></span></td>
        <td data-name="codigo"<?= $Page->codigo->cellAttributes() ?>>
<span id="el_autogestion_plantillas_codigo">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <tr id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_descripcion"><?= $Page->descripcion->caption() ?></span></td>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_autogestion_plantillas_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
    <tr id="r_imagen"<?= $Page->imagen->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_imagen"><?= $Page->imagen->caption() ?></span></td>
        <td data-name="imagen"<?= $Page->imagen->cellAttributes() ?>>
<span id="el_autogestion_plantillas_imagen">
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mostrar->Visible) { // mostrar ?>
    <tr id="r_mostrar"<?= $Page->mostrar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_plantillas_mostrar"><?= $Page->mostrar->caption() ?></span></td>
        <td data-name="mostrar"<?= $Page->mostrar->cellAttributes() ?>>
<span id="el_autogestion_plantillas_mostrar">
<span<?= $Page->mostrar->viewAttributes() ?>>
<?= $Page->mostrar->getViewValue() ?></span>
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
