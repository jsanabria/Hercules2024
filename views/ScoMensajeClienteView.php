<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMensajeClienteView = &$Page;
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
<form name="fsco_mensaje_clienteview" id="fsco_mensaje_clienteview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mensaje_cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_mensaje_clienteview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mensaje_clienteview")
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
<input type="hidden" name="t" value="sco_mensaje_cliente">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nmensaje_cliente->Visible) { // Nmensaje_cliente ?>
    <tr id="r_Nmensaje_cliente"<?= $Page->Nmensaje_cliente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_Nmensaje_cliente"><?= $Page->Nmensaje_cliente->caption() ?></span></td>
        <td data-name="Nmensaje_cliente"<?= $Page->Nmensaje_cliente->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_Nmensaje_cliente">
<span<?= $Page->Nmensaje_cliente->viewAttributes() ?>>
<?= $Page->Nmensaje_cliente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <tr id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_cedula"><?= $Page->cedula->caption() ?></span></td>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
    <tr id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_contrato"><?= $Page->contrato->caption() ?></span></td>
        <td data-name="contrato"<?= $Page->contrato->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <tr id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_titular"><?= $Page->titular->caption() ?></span></td>
        <td data-name="titular"<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_titular">
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->difunto->Visible) { // difunto ?>
    <tr id="r_difunto"<?= $Page->difunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_difunto"><?= $Page->difunto->caption() ?></span></td>
        <td data-name="difunto"<?= $Page->difunto->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_difunto">
<span<?= $Page->difunto->viewAttributes() ?>>
<?= $Page->difunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
    <tr id="r_contacto"<?= $Page->contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_contacto"><?= $Page->contacto->caption() ?></span></td>
        <td data-name="contacto"<?= $Page->contacto->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_contacto">
<span<?= $Page->contacto->viewAttributes() ?>>
<?= $Page->contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->celular->Visible) { // celular ?>
    <tr id="r_celular"<?= $Page->celular->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_celular"><?= $Page->celular->caption() ?></span></td>
        <td data-name="celular"<?= $Page->celular->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_celular">
<span<?= $Page->celular->viewAttributes() ?>>
<?= $Page->celular->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->texto->Visible) { // texto ?>
    <tr id="r_texto"<?= $Page->texto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_texto"><?= $Page->texto->caption() ?></span></td>
        <td data-name="texto"<?= $Page->texto->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_texto">
<span<?= $Page->texto->viewAttributes() ?>>
<?= $Page->texto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mensaje_cliente_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_mensaje_cliente_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
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
