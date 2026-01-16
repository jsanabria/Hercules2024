<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoAlertasView = &$Page;
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
<form name="fsco_alertasview" id="fsco_alertasview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_alertas: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_alertasview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_alertasview")
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
<input type="hidden" name="t" value="sco_alertas">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_alertas_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_alertas_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_end->Visible) { // fecha_end ?>
    <tr id="r_fecha_end"<?= $Page->fecha_end->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_alertas_fecha_end"><?= $Page->fecha_end->caption() ?></span></td>
        <td data-name="fecha_end"<?= $Page->fecha_end->cellAttributes() ?>>
<span id="el_sco_alertas_fecha_end">
<span<?= $Page->fecha_end->viewAttributes() ?>>
<?= $Page->fecha_end->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_corta->Visible) { // descripcion_corta ?>
    <tr id="r_descripcion_corta"<?= $Page->descripcion_corta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_alertas_descripcion_corta"><?= $Page->descripcion_corta->caption() ?></span></td>
        <td data-name="descripcion_corta"<?= $Page->descripcion_corta->cellAttributes() ?>>
<span id="el_sco_alertas_descripcion_corta">
<span<?= $Page->descripcion_corta->viewAttributes() ?>>
<?= $Page->descripcion_corta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_larga->Visible) { // descripcion_larga ?>
    <tr id="r_descripcion_larga"<?= $Page->descripcion_larga->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_alertas_descripcion_larga"><?= $Page->descripcion_larga->caption() ?></span></td>
        <td data-name="descripcion_larga"<?= $Page->descripcion_larga->cellAttributes() ?>>
<span id="el_sco_alertas_descripcion_larga">
<span<?= $Page->descripcion_larga->viewAttributes() ?>>
<?= $Page->descripcion_larga->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
    <tr id="r_orden"<?= $Page->orden->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_alertas_orden"><?= $Page->orden->caption() ?></span></td>
        <td data-name="orden"<?= $Page->orden->cellAttributes() ?>>
<span id="el_sco_alertas_orden">
<span<?= $Page->orden->viewAttributes() ?>>
<?= $Page->orden->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <tr id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_alertas_activo"><?= $Page->activo->caption() ?></span></td>
        <td data-name="activo"<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_alertas_activo">
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
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
