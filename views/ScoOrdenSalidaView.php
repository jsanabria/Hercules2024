<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenSalidaView = &$Page;
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
<form name="fsco_orden_salidaview" id="fsco_orden_salidaview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_salida: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_orden_salidaview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_salidaview")
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
<input type="hidden" name="t" value="sco_orden_salida">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Norden_salida->Visible) { // Norden_salida ?>
    <tr id="r_Norden_salida"<?= $Page->Norden_salida->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_Norden_salida"><?= $Page->Norden_salida->caption() ?></span></td>
        <td data-name="Norden_salida"<?= $Page->Norden_salida->cellAttributes() ?>>
<span id="el_sco_orden_salida_Norden_salida">
<span<?= $Page->Norden_salida->viewAttributes() ?>>
<?= $Page->Norden_salida->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
    <tr id="r_fecha_hora"<?= $Page->fecha_hora->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_fecha_hora"><?= $Page->fecha_hora->caption() ?></span></td>
        <td data-name="fecha_hora"<?= $Page->fecha_hora->cellAttributes() ?>>
<span id="el_sco_orden_salida_fecha_hora">
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_orden_salida__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
    <tr id="r_grupo"<?= $Page->grupo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_grupo"><?= $Page->grupo->caption() ?></span></td>
        <td data-name="grupo"<?= $Page->grupo->cellAttributes() ?>>
<span id="el_sco_orden_salida_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->conductor->Visible) { // conductor ?>
    <tr id="r_conductor"<?= $Page->conductor->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_conductor"><?= $Page->conductor->caption() ?></span></td>
        <td data-name="conductor"<?= $Page->conductor->cellAttributes() ?>>
<span id="el_sco_orden_salida_conductor">
<span<?= $Page->conductor->viewAttributes() ?>>
<?= $Page->conductor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->acompanantes->Visible) { // acompanantes ?>
    <tr id="r_acompanantes"<?= $Page->acompanantes->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_acompanantes"><?= $Page->acompanantes->caption() ?></span></td>
        <td data-name="acompanantes"<?= $Page->acompanantes->cellAttributes() ?>>
<span id="el_sco_orden_salida_acompanantes">
<span<?= $Page->acompanantes->viewAttributes() ?>>
<?= $Page->acompanantes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
    <tr id="r_placa"<?= $Page->placa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_placa"><?= $Page->placa->caption() ?></span></td>
        <td data-name="placa"<?= $Page->placa->cellAttributes() ?>>
<span id="el_sco_orden_salida_placa">
<span<?= $Page->placa->viewAttributes() ?>>
<?= $Page->placa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <tr id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_motivo"><?= $Page->motivo->caption() ?></span></td>
        <td data-name="motivo"<?= $Page->motivo->cellAttributes() ?>>
<span id="el_sco_orden_salida_motivo">
<span<?= $Page->motivo->viewAttributes() ?>>
<?= $Page->motivo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->observaciones->Visible) { // observaciones ?>
    <tr id="r_observaciones"<?= $Page->observaciones->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_observaciones"><?= $Page->observaciones->caption() ?></span></td>
        <td data-name="observaciones"<?= $Page->observaciones->cellAttributes() ?>>
<span id="el_sco_orden_salida_observaciones">
<span<?= $Page->observaciones->viewAttributes() ?>>
<?= $Page->observaciones->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->autoriza->Visible) { // autoriza ?>
    <tr id="r_autoriza"<?= $Page->autoriza->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_autoriza"><?= $Page->autoriza->caption() ?></span></td>
        <td data-name="autoriza"<?= $Page->autoriza->cellAttributes() ?>>
<span id="el_sco_orden_salida_autoriza">
<span<?= $Page->autoriza->viewAttributes() ?>>
<?= $Page->autoriza->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
    <tr id="r_fecha_autoriza"<?= $Page->fecha_autoriza->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_fecha_autoriza"><?= $Page->fecha_autoriza->caption() ?></span></td>
        <td data-name="fecha_autoriza"<?= $Page->fecha_autoriza->cellAttributes() ?>>
<span id="el_sco_orden_salida_fecha_autoriza">
<span<?= $Page->fecha_autoriza->viewAttributes() ?>>
<?= $Page->fecha_autoriza->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_orden_salida_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_orden_salida_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $('#autorizado').click(function () {
    	if(confirm("Seguro de autorizar esta salida?")) {
    		var dato = this.value.split("|");
    		$.ajax({
    			url: "../dashboard/orden_salida_autorizar.php?username=" + dato[0] + "&orden=" + dato[1],
    			success: function (res) {
    				$("#xAut").html(res);
    			}
    		});
    	}
    	else $('#autorizado').prop('checked', false);
    });
    $('#no_autorizado').click(function () {
    	if(confirm("Seguro de no autorizar esta salida?")) {
    		var dato = this.value.split("|");
    		$.ajax({
    			url: "../dashboard/orden_salida_no_autorizar.php?username=" + dato[0] + "&orden=" + dato[1],
    			success: function (res) {
    				$("#xAut").html(res);
    			}
    		});
    	}
    	else $('#no_autorizado').prop('checked', false);
    });
});
</script>
<?php } ?>
