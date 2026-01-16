<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEntradaSalidaDetalleEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_entrada_salida_detalleedit" id="fsco_entrada_salida_detalleedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_entrada_salida_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_entrada_salida_detalleedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_entrada_salida_detalleedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["articulo", [fields.articulo.visible && fields.articulo.required ? ew.Validators.required(fields.articulo.caption) : null], fields.articulo.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null, ew.Validators.integer], fields.cantidad.isInvalid],
            ["costo", [fields.costo.visible && fields.costo.required ? ew.Validators.required(fields.costo.caption) : null, ew.Validators.float], fields.costo.isInvalid],
            ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.float], fields.total.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "articulo": <?= $Page->articulo->toClientList($Page) ?>,
        })
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_entrada_salida_detalle">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_entrada_salida") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_entrada_salida">
<input type="hidden" name="fk_Nentrada_salida" value="<?= HtmlEncode($Page->entrada_salida->getSessionValue()) ?>">
<input type="hidden" name="fk_tipo_doc" value="<?= HtmlEncode($Page->tipo_doc->getSessionValue()) ?>">
<input type="hidden" name="fk_proveedor" value="<?= HtmlEncode($Page->proveedor->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->articulo->Visible) { // articulo ?>
    <div id="r_articulo"<?= $Page->articulo->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_detalle_articulo" for="x_articulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->articulo->caption() ?><?= $Page->articulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->articulo->cellAttributes() ?>>
<span id="el_sco_entrada_salida_detalle_articulo">
    <select
        id="x_articulo"
        name="x_articulo"
        class="form-control ew-select<?= $Page->articulo->isInvalidClass() ?>"
        data-select2-id="fsco_entrada_salida_detalleedit_x_articulo"
        data-table="sco_entrada_salida_detalle"
        data-field="x_articulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->articulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->articulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo->getPlaceHolder()) ?>"
        <?= $Page->articulo->editAttributes() ?>>
        <?= $Page->articulo->selectOptionListHtml("x_articulo") ?>
    </select>
    <?= $Page->articulo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->articulo->getErrorMessage() ?></div>
<?= $Page->articulo->Lookup->getParamTag($Page, "p_x_articulo") ?>
<script>
loadjs.ready("fsco_entrada_salida_detalleedit", function() {
    var options = { name: "x_articulo", selectId: "fsco_entrada_salida_detalleedit_x_articulo" };
    if (fsco_entrada_salida_detalleedit.lists.articulo?.lookupOptions.length) {
        options.data = { id: "x_articulo", form: "fsco_entrada_salida_detalleedit" };
    } else {
        options.ajax = { id: "x_articulo", form: "fsco_entrada_salida_detalleedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_entrada_salida_detalle.fields.articulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <div id="r_cantidad"<?= $Page->cantidad->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_detalle_cantidad" for="x_cantidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cantidad->caption() ?><?= $Page->cantidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cantidad->cellAttributes() ?>>
<span id="el_sco_entrada_salida_detalle_cantidad">
<input type="<?= $Page->cantidad->getInputTextType() ?>" name="x_cantidad" id="x_cantidad" data-table="sco_entrada_salida_detalle" data-field="x_cantidad" value="<?= $Page->cantidad->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad->formatPattern()) ?>"<?= $Page->cantidad->editAttributes() ?> aria-describedby="x_cantidad_help">
<?= $Page->cantidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cantidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <div id="r_costo"<?= $Page->costo->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_detalle_costo" for="x_costo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costo->caption() ?><?= $Page->costo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costo->cellAttributes() ?>>
<span id="el_sco_entrada_salida_detalle_costo">
<input type="<?= $Page->costo->getInputTextType() ?>" name="x_costo" id="x_costo" data-table="sco_entrada_salida_detalle" data-field="x_costo" value="<?= $Page->costo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->costo->formatPattern()) ?>"<?= $Page->costo->editAttributes() ?> aria-describedby="x_costo_help">
<?= $Page->costo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->costo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total"<?= $Page->total->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_detalle_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total->cellAttributes() ?>>
<span id="el_sco_entrada_salida_detalle_total">
<input type="<?= $Page->total->getInputTextType() ?>" name="x_total" id="x_total" data-table="sco_entrada_salida_detalle" data-field="x_total" value="<?= $Page->total->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->total->formatPattern()) ?>"<?= $Page->total->editAttributes() ?> aria-describedby="x_total_help">
<?= $Page->total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_Nentrada_salida_detalle" data-hidden="1" name="x_Nentrada_salida_detalle" id="x_Nentrada_salida_detalle" value="<?= HtmlEncode($Page->Nentrada_salida_detalle->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_entrada_salida_detalleedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_entrada_salida_detalleedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_entrada_salida_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    if($("#x_tipo").val() == "FALLA") {
    	$("#x_reparacion").hide();
    	$('#x_reparacion').prop('readonly', true);
    	$("#x_monto").hide();
    }
    if($("#x_tipo").val() == "REPARACION") {
    	$("#x_falla").hide();
    	$("#x_monto").show();
    }
    if($("#x_tipo").val() == "" && $("#x_tipo").val() == "") {
    	$("#x_falla").hide();
    	$("#x_reparacion").hide();
    	$("#x_monto").show();
    }
    $(document).ready(function(){
    	$("#x_tipo").bind("change", function() {
    		if($("#x_tipo").val() == "FALLA") {
    			$("#x_falla").show();
    			$("#x_reparacion").hide();
    			$("#x_reparacion").val("");
    			$("#x_monto").hide("");
    			$("#x_monto").val("");
    		}
    		else if($("#x_tipo").val() == "REPARACION") {
    			$("#x_falla").hide();
    			$("#x_falla").val("");
    			$("#x_reparacion").show();
    			$("#x_monto").show("");
    		}
    		else {
    			$("#x_falla").hide();
    			$("#x_reparacion").hide();
    			$("#x_falla").val("");
    			$("#x_reparacion").val("");
    			$("#x_monto").hide("");
    		}
    	})
    })
});
</script>
