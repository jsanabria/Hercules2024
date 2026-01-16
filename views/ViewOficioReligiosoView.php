<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewOficioReligiosoView = &$Page;
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
<form name="fview_oficio_religiosoview" id="fview_oficio_religiosoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_oficio_religioso: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fview_oficio_religiosoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_oficio_religiosoview")
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
<input type="hidden" name="t" value="view_oficio_religioso">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Norden->Visible) { // Norden ?>
    <tr id="r_Norden"<?= $Page->Norden->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_Norden"><?= $Page->Norden->caption() ?></span></td>
        <td data-name="Norden"<?= $Page->Norden->cellAttributes() ?>>
<span id="el_view_oficio_religioso_Norden">
<span<?= $Page->Norden->viewAttributes() ?>>
<?= $Page->Norden->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
    <tr id="r_Nexpediente"<?= $Page->Nexpediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_Nexpediente"><?= $Page->Nexpediente->caption() ?></span></td>
        <td data-name="Nexpediente"<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="el_view_oficio_religioso_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?php if (!EmptyString($Page->Nexpediente->getViewValue()) && $Page->Nexpediente->linkAttributes() != "") { ?>
<a<?= $Page->Nexpediente->linkAttributes() ?>><?= $Page->Nexpediente->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->Nexpediente->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <tr id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_cedula"><?= $Page->cedula->caption() ?></span></td>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el_view_oficio_religioso_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <tr id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_nombre"><?= $Page->nombre->caption() ?></span></td>
        <td data-name="nombre"<?= $Page->nombre->cellAttributes() ?>>
<span id="el_view_oficio_religioso_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
    <tr id="r_apellido"<?= $Page->apellido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_apellido"><?= $Page->apellido->caption() ?></span></td>
        <td data-name="apellido"<?= $Page->apellido->cellAttributes() ?>>
<span id="el_view_oficio_religioso_apellido">
<span<?= $Page->apellido->viewAttributes() ?>>
<?= $Page->apellido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <tr id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_servicio"><?= $Page->servicio->caption() ?></span></td>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el_view_oficio_religioso_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio2->Visible) { // servicio2 ?>
    <tr id="r_servicio2"<?= $Page->servicio2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_servicio2"><?= $Page->servicio2->caption() ?></span></td>
        <td data-name="servicio2"<?= $Page->servicio2->cellAttributes() ?>>
<span id="el_view_oficio_religioso_servicio2">
<span<?= $Page->servicio2->viewAttributes() ?>>
<?= $Page->servicio2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ministro->Visible) { // ministro ?>
    <tr id="r_ministro"<?= $Page->ministro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_ministro"><?= $Page->ministro->caption() ?></span></td>
        <td data-name="ministro"<?= $Page->ministro->cellAttributes() ?>>
<span id="el_view_oficio_religioso_ministro">
<span<?= $Page->ministro->viewAttributes() ?>>
<?= $Page->ministro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
    <tr id="r_servicio_atendido"<?= $Page->servicio_atendido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_servicio_atendido"><?= $Page->servicio_atendido->caption() ?></span></td>
        <td data-name="servicio_atendido"<?= $Page->servicio_atendido->cellAttributes() ?>>
<span id="el_view_oficio_religioso_servicio_atendido">
<span<?= $Page->servicio_atendido->viewAttributes() ?>>
<?= $Page->servicio_atendido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <tr id="r_fecha_servicio"<?= $Page->fecha_servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_view_oficio_religioso_fecha_servicio"><?= $Page->fecha_servicio->caption() ?></span></td>
        <td data-name="fecha_servicio"<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el_view_oficio_religioso_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<?= $Page->fecha_servicio->getViewValue() ?></span>
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
