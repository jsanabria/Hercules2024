<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionTicketView = &$Page;
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
<form name="fautogestion_ticketview" id="fautogestion_ticketview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_ticket: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fautogestion_ticketview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fautogestion_ticketview")
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
<input type="hidden" name="t" value="autogestion_ticket">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nticket->Visible) { // Nticket ?>
    <tr id="r_Nticket"<?= $Page->Nticket->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_Nticket"><?= $Page->Nticket->caption() ?></span></td>
        <td data-name="Nticket"<?= $Page->Nticket->cellAttributes() ?>>
<span id="el_autogestion_ticket_Nticket">
<span<?= $Page->Nticket->viewAttributes() ?>>
<?= $Page->Nticket->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_autogestion_ticket_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <tr id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></td>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_autogestion_ticket_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <tr id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_cedula"><?= $Page->cedula->caption() ?></span></td>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el_autogestion_ticket_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <tr id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_nombre"><?= $Page->nombre->caption() ?></span></td>
        <td data-name="nombre"<?= $Page->nombre->cellAttributes() ?>>
<span id="el_autogestion_ticket_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
    <tr id="r_apellido"<?= $Page->apellido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_apellido"><?= $Page->apellido->caption() ?></span></td>
        <td data-name="apellido"<?= $Page->apellido->cellAttributes() ?>>
<span id="el_autogestion_ticket_apellido">
<span<?= $Page->apellido->viewAttributes() ?>>
<?= $Page->apellido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <tr id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_telefono1"><?= $Page->telefono1->caption() ?></span></td>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_autogestion_ticket_telefono1">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <tr id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_telefono2"><?= $Page->telefono2->caption() ?></span></td>
        <td data-name="telefono2"<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_autogestion_ticket_telefono2">
<span<?= $Page->telefono2->viewAttributes() ?>>
<?= $Page->telefono2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <tr id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></td>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_autogestion_ticket_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <tr id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></td>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_autogestion_ticket_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellido_fallecido->Visible) { // apellido_fallecido ?>
    <tr id="r_apellido_fallecido"<?= $Page->apellido_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_apellido_fallecido"><?= $Page->apellido_fallecido->caption() ?></span></td>
        <td data-name="apellido_fallecido"<?= $Page->apellido_fallecido->cellAttributes() ?>>
<span id="el_autogestion_ticket_apellido_fallecido">
<span<?= $Page->apellido_fallecido->viewAttributes() ?>>
<?= $Page->apellido_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ubicacion->Visible) { // ubicacion ?>
    <tr id="r_ubicacion"<?= $Page->ubicacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_ubicacion"><?= $Page->ubicacion->caption() ?></span></td>
        <td data-name="ubicacion"<?= $Page->ubicacion->cellAttributes() ?>>
<span id="el_autogestion_ticket_ubicacion">
<span<?= $Page->ubicacion->viewAttributes() ?>>
<?= $Page->ubicacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_autogestion_ticket__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->recaudos->Visible) { // recaudos ?>
    <tr id="r_recaudos"<?= $Page->recaudos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_recaudos"><?= $Page->recaudos->caption() ?></span></td>
        <td data-name="recaudos"<?= $Page->recaudos->cellAttributes() ?>>
<span id="el_autogestion_ticket_recaudos">
<span<?= $Page->recaudos->viewAttributes() ?>>
<?= $Page->recaudos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->recaudos2->Visible) { // recaudos2 ?>
    <tr id="r_recaudos2"<?= $Page->recaudos2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_recaudos2"><?= $Page->recaudos2->caption() ?></span></td>
        <td data-name="recaudos2"<?= $Page->recaudos2->cellAttributes() ?>>
<span id="el_autogestion_ticket_recaudos2">
<span<?= $Page->recaudos2->viewAttributes() ?>>
<?= $Page->recaudos2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hora_conctactar->Visible) { // hora_conctactar ?>
    <tr id="r_hora_conctactar"<?= $Page->hora_conctactar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_hora_conctactar"><?= $Page->hora_conctactar->caption() ?></span></td>
        <td data-name="hora_conctactar"<?= $Page->hora_conctactar->cellAttributes() ?>>
<span id="el_autogestion_ticket_hora_conctactar">
<span<?= $Page->hora_conctactar->viewAttributes() ?>>
<?= $Page->hora_conctactar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contactado->Visible) { // contactado ?>
    <tr id="r_contactado"<?= $Page->contactado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_contactado"><?= $Page->contactado->caption() ?></span></td>
        <td data-name="contactado"<?= $Page->contactado->cellAttributes() ?>>
<span id="el_autogestion_ticket_contactado">
<span<?= $Page->contactado->viewAttributes() ?>>
<?= $Page->contactado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_contactado->Visible) { // fecha_contactado ?>
    <tr id="r_fecha_contactado"<?= $Page->fecha_contactado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_fecha_contactado"><?= $Page->fecha_contactado->caption() ?></span></td>
        <td data-name="fecha_contactado"<?= $Page->fecha_contactado->cellAttributes() ?>>
<span id="el_autogestion_ticket_fecha_contactado">
<span<?= $Page->fecha_contactado->viewAttributes() ?>>
<?= $Page->fecha_contactado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_autogestion_ticket_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_autogestion_ticket_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
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
