<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReembolsoView = &$Page;
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
<form name="fsco_reembolsoview" id="fsco_reembolsoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_reembolso: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_reembolsoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reembolsoview")
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
<input type="hidden" name="t" value="sco_reembolso">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_reembolso_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_usd->Visible) { // monto_usd ?>
    <tr id="r_monto_usd"<?= $Page->monto_usd->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_monto_usd"><?= $Page->monto_usd->caption() ?></span></td>
        <td data-name="monto_usd"<?= $Page->monto_usd->cellAttributes() ?>>
<span id="el_sco_reembolso_monto_usd">
<span<?= $Page->monto_usd->viewAttributes() ?>>
<?= $Page->monto_usd->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_tasa->Visible) { // fecha_tasa ?>
    <tr id="r_fecha_tasa"<?= $Page->fecha_tasa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_fecha_tasa"><?= $Page->fecha_tasa->caption() ?></span></td>
        <td data-name="fecha_tasa"<?= $Page->fecha_tasa->cellAttributes() ?>>
<span id="el_sco_reembolso_fecha_tasa">
<span<?= $Page->fecha_tasa->viewAttributes() ?>>
<?= $Page->fecha_tasa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <tr id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_tasa"><?= $Page->tasa->caption() ?></span></td>
        <td data-name="tasa"<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_reembolso_tasa">
<span<?= $Page->tasa->viewAttributes() ?>>
<?= $Page->tasa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
    <tr id="r_monto_bs"<?= $Page->monto_bs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_monto_bs"><?= $Page->monto_bs->caption() ?></span></td>
        <td data-name="monto_bs"<?= $Page->monto_bs->cellAttributes() ?>>
<span id="el_sco_reembolso_monto_bs">
<span<?= $Page->monto_bs->viewAttributes() ?>>
<?= $Page->monto_bs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->banco->Visible) { // banco ?>
    <tr id="r_banco"<?= $Page->banco->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_banco"><?= $Page->banco->caption() ?></span></td>
        <td data-name="banco"<?= $Page->banco->cellAttributes() ?>>
<span id="el_sco_reembolso_banco">
<span<?= $Page->banco->viewAttributes() ?>>
<?= $Page->banco->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nro_cta->Visible) { // nro_cta ?>
    <tr id="r_nro_cta"<?= $Page->nro_cta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_nro_cta"><?= $Page->nro_cta->caption() ?></span></td>
        <td data-name="nro_cta"<?= $Page->nro_cta->cellAttributes() ?>>
<span id="el_sco_reembolso_nro_cta">
<span<?= $Page->nro_cta->viewAttributes() ?>>
<?= $Page->nro_cta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <tr id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_titular"><?= $Page->titular->caption() ?></span></td>
        <td data-name="titular"<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_reembolso_titular">
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ci_rif->Visible) { // ci_rif ?>
    <tr id="r_ci_rif"<?= $Page->ci_rif->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_ci_rif"><?= $Page->ci_rif->caption() ?></span></td>
        <td data-name="ci_rif"<?= $Page->ci_rif->cellAttributes() ?>>
<span id="el_sco_reembolso_ci_rif">
<span<?= $Page->ci_rif->viewAttributes() ?>>
<?= $Page->ci_rif->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <tr id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_correo"><?= $Page->correo->caption() ?></span></td>
        <td data-name="correo"<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_reembolso_correo">
<span<?= $Page->correo->viewAttributes() ?>>
<?= $Page->correo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nro_ref->Visible) { // nro_ref ?>
    <tr id="r_nro_ref"<?= $Page->nro_ref->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_nro_ref"><?= $Page->nro_ref->caption() ?></span></td>
        <td data-name="nro_ref"<?= $Page->nro_ref->cellAttributes() ?>>
<span id="el_sco_reembolso_nro_ref">
<span<?= $Page->nro_ref->viewAttributes() ?>>
<?= $Page->nro_ref->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <tr id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_motivo"><?= $Page->motivo->caption() ?></span></td>
        <td data-name="motivo"<?= $Page->motivo->cellAttributes() ?>>
<span id="el_sco_reembolso_motivo">
<span<?= $Page->motivo->viewAttributes() ?>>
<?= $Page->motivo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_reembolso_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_reembolso_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->coordinador->Visible) { // coordinador ?>
    <tr id="r_coordinador"<?= $Page->coordinador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_coordinador"><?= $Page->coordinador->caption() ?></span></td>
        <td data-name="coordinador"<?= $Page->coordinador->cellAttributes() ?>>
<span id="el_sco_reembolso_coordinador">
<span<?= $Page->coordinador->viewAttributes() ?>>
<?= $Page->coordinador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pagador->Visible) { // pagador ?>
    <tr id="r_pagador"<?= $Page->pagador->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_pagador"><?= $Page->pagador->caption() ?></span></td>
        <td data-name="pagador"<?= $Page->pagador->cellAttributes() ?>>
<span id="el_sco_reembolso_pagador">
<span<?= $Page->pagador->viewAttributes() ?>>
<?= $Page->pagador->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_pago->Visible) { // fecha_pago ?>
    <tr id="r_fecha_pago"<?= $Page->fecha_pago->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_fecha_pago"><?= $Page->fecha_pago->caption() ?></span></td>
        <td data-name="fecha_pago"<?= $Page->fecha_pago->cellAttributes() ?>>
<span id="el_sco_reembolso_fecha_pago">
<span<?= $Page->fecha_pago->viewAttributes() ?>>
<?= $Page->fecha_pago->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_enviado->Visible) { // email_enviado ?>
    <tr id="r_email_enviado"<?= $Page->email_enviado->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_reembolso_email_enviado"><?= $Page->email_enviado->caption() ?></span></td>
        <td data-name="email_enviado"<?= $Page->email_enviado->cellAttributes() ?>>
<span id="el_sco_reembolso_email_enviado">
<span<?= $Page->email_enviado->viewAttributes() ?>>
<?= $Page->email_enviado->getViewValue() ?></span>
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
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#enviar").click(function(){
    	if(confirm("Seguro de enviar la notificación?")) {
    		$.ajax({
    			type        : 'POST',   // Define the type of HTTP verb we want to use
    			url         : 'dashboard/email_pago_reembolso.php',   // The URL where we want to POST
    			data        : { id: <?php echo $_REQUEST["Nreembolso"]; ?>, username : '<?php echo CurrentUserName(); ?>' } , // Our data object
    			beforeSend : function() {
    				// This will run before sending an Ajax request.
    				// Do whatever activity you want, like show loaded.
    			},
    			success:function(response){
    				alert(response);
    				location.reload();
    			},
    			complete : function() {
    				// This will run after sending an Ajax complete
    			},
    			error:function (xhr, ajaxOptions, thrownError){
    				alert('Ocurrió un error ' + ajaxOptions + ', ' + thrownError);
    				// If any error occurs in request
    			}
    		});
    	}
    });
    $(document).ready(function() {
    	$("#enviar").trigger("click");
    });
});
</script>
<?php } ?>
