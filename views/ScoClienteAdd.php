<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoClienteAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_cliente: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_clienteadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_clienteadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["rif_ci", [fields.rif_ci.visible && fields.rif_ci.required ? ew.Validators.required(fields.rif_ci.caption) : null], fields.rif_ci.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["fax", [fields.fax.visible && fields.fax.required ? ew.Validators.required(fields.fax.caption) : null], fields.fax.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["web", [fields.web.visible && fields.web.required ? ew.Validators.required(fields.web.caption) : null], fields.web.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
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
            "activo": <?= $Page->activo->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_clienteadd" id="fsco_clienteadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_cliente">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->rif_ci->Visible) { // rif_ci ?>
    <div id="r_rif_ci"<?= $Page->rif_ci->rowAttributes() ?>>
        <label id="elh_sco_cliente_rif_ci" for="x_rif_ci" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rif_ci->caption() ?><?= $Page->rif_ci->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rif_ci->cellAttributes() ?>>
<span id="el_sco_cliente_rif_ci">
<input type="<?= $Page->rif_ci->getInputTextType() ?>" name="x_rif_ci" id="x_rif_ci" data-table="sco_cliente" data-field="x_rif_ci" value="<?= $Page->rif_ci->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->rif_ci->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rif_ci->formatPattern()) ?>"<?= $Page->rif_ci->editAttributes() ?> aria-describedby="x_rif_ci_help">
<?= $Page->rif_ci->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rif_ci->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_sco_cliente_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_cliente_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="sco_cliente" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_sco_cliente_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_cliente_direccion">
<textarea data-table="sco_cliente" data-field="x_direccion" name="x_direccion" id="x_direccion" cols="30" rows="4" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help"><?= $Page->direccion->EditValue ?></textarea>
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <div id="r_telefono"<?= $Page->telefono->rowAttributes() ?>>
        <label id="elh_sco_cliente_telefono" for="x_telefono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono->caption() ?><?= $Page->telefono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono->cellAttributes() ?>>
<span id="el_sco_cliente_telefono">
<input type="<?= $Page->telefono->getInputTextType() ?>" name="x_telefono" id="x_telefono" data-table="sco_cliente" data-field="x_telefono" value="<?= $Page->telefono->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono->formatPattern()) ?>"<?= $Page->telefono->editAttributes() ?> aria-describedby="x_telefono_help">
<?= $Page->telefono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_cliente_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_cliente_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_cliente" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
    <div id="r_fax"<?= $Page->fax->rowAttributes() ?>>
        <label id="elh_sco_cliente_fax" for="x_fax" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fax->caption() ?><?= $Page->fax->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fax->cellAttributes() ?>>
<span id="el_sco_cliente_fax">
<input type="<?= $Page->fax->getInputTextType() ?>" name="x_fax" id="x_fax" data-table="sco_cliente" data-field="x_fax" value="<?= $Page->fax->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->fax->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fax->formatPattern()) ?>"<?= $Page->fax->editAttributes() ?> aria-describedby="x_fax_help">
<?= $Page->fax->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fax->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_cliente__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_cliente__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_cliente" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->web->Visible) { // web ?>
    <div id="r_web"<?= $Page->web->rowAttributes() ?>>
        <label id="elh_sco_cliente_web" for="x_web" class="<?= $Page->LeftColumnClass ?>"><?= $Page->web->caption() ?><?= $Page->web->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->web->cellAttributes() ?>>
<span id="el_sco_cliente_web">
<input type="<?= $Page->web->getInputTextType() ?>" name="x_web" id="x_web" data-table="sco_cliente" data-field="x_web" value="<?= $Page->web->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->web->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->web->formatPattern()) ?>"<?= $Page->web->editAttributes() ?> aria-describedby="x_web_help">
<?= $Page->web->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->web->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_cliente_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_cliente_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_clienteadd_x_activo"
        <?php } ?>
        data-table="sco_cliente"
        data-field="x_activo"
        data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->activo->getPlaceHolder()) ?>"
        <?= $Page->activo->editAttributes() ?>>
        <?= $Page->activo->selectOptionListHtml("x_activo") ?>
    </select>
    <?= $Page->activo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
<?php if (!$Page->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_clienteadd", function() {
    var options = { name: "x_activo", selectId: "fsco_clienteadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_clienteadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_clienteadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_clienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_cliente.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_clienteadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_clienteadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_cliente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_rif_ci").mask("a999999999");
    $("#x_telefono").mask("(9999) 999-99-99");
    $("#x_telefono2").mask("(9999) 999-99-99");
    $("#x_fax").mask("(9999) 999-99-99");
});
</script>
