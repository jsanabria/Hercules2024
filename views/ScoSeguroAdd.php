<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoSeguroAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_seguro: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_seguroadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_seguroadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo_contratacion", [fields.tipo_contratacion.visible && fields.tipo_contratacion.required ? ew.Validators.required(fields.tipo_contratacion.caption) : null], fields.tipo_contratacion.isInvalid],
            ["ci_rif", [fields.ci_rif.visible && fields.ci_rif.required ? ew.Validators.required(fields.ci_rif.caption) : null], fields.ci_rif.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["contacto", [fields.contacto.visible && fields.contacto.required ? ew.Validators.required(fields.contacto.caption) : null], fields.contacto.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["telefono1", [fields.telefono1.visible && fields.telefono1.required ? ew.Validators.required(fields.telefono1.caption) : null], fields.telefono1.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["telefono3", [fields.telefono3.visible && fields.telefono3.required ? ew.Validators.required(fields.telefono3.caption) : null], fields.telefono3.isInvalid],
            ["fax", [fields.fax.visible && fields.fax.required ? ew.Validators.required(fields.fax.caption) : null], fields.fax.isInvalid],
            ["email1", [fields.email1.visible && fields.email1.required ? ew.Validators.required(fields.email1.caption) : null, ew.Validators.email], fields.email1.isInvalid],
            ["email2", [fields.email2.visible && fields.email2.required ? ew.Validators.required(fields.email2.caption) : null, ew.Validators.email], fields.email2.isInvalid],
            ["email3", [fields.email3.visible && fields.email3.required ? ew.Validators.required(fields.email3.caption) : null, ew.Validators.email], fields.email3.isInvalid],
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
            "tipo_contratacion": <?= $Page->tipo_contratacion->toClientList($Page) ?>,
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
<form name="fsco_seguroadd" id="fsco_seguroadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_seguro">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
    <div id="r_tipo_contratacion"<?= $Page->tipo_contratacion->rowAttributes() ?>>
        <label id="elh_sco_seguro_tipo_contratacion" for="x_tipo_contratacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_contratacion->caption() ?><?= $Page->tipo_contratacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_contratacion->cellAttributes() ?>>
<span id="el_sco_seguro_tipo_contratacion">
    <select
        id="x_tipo_contratacion"
        name="x_tipo_contratacion"
        class="form-select ew-select<?= $Page->tipo_contratacion->isInvalidClass() ?>"
        <?php if (!$Page->tipo_contratacion->IsNativeSelect) { ?>
        data-select2-id="fsco_seguroadd_x_tipo_contratacion"
        <?php } ?>
        data-table="sco_seguro"
        data-field="x_tipo_contratacion"
        data-value-separator="<?= $Page->tipo_contratacion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_contratacion->getPlaceHolder()) ?>"
        <?= $Page->tipo_contratacion->editAttributes() ?>>
        <?= $Page->tipo_contratacion->selectOptionListHtml("x_tipo_contratacion") ?>
    </select>
    <?= $Page->tipo_contratacion->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_contratacion->getErrorMessage() ?></div>
<?php if (!$Page->tipo_contratacion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_seguroadd", function() {
    var options = { name: "x_tipo_contratacion", selectId: "fsco_seguroadd_x_tipo_contratacion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguroadd.lists.tipo_contratacion?.lookupOptions.length) {
        options.data = { id: "x_tipo_contratacion", form: "fsco_seguroadd" };
    } else {
        options.ajax = { id: "x_tipo_contratacion", form: "fsco_seguroadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguro.fields.tipo_contratacion.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_rif->Visible) { // ci_rif ?>
    <div id="r_ci_rif"<?= $Page->ci_rif->rowAttributes() ?>>
        <label id="elh_sco_seguro_ci_rif" for="x_ci_rif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_rif->caption() ?><?= $Page->ci_rif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_rif->cellAttributes() ?>>
<span id="el_sco_seguro_ci_rif">
<input type="<?= $Page->ci_rif->getInputTextType() ?>" name="x_ci_rif" id="x_ci_rif" data-table="sco_seguro" data-field="x_ci_rif" value="<?= $Page->ci_rif->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->ci_rif->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_rif->formatPattern()) ?>"<?= $Page->ci_rif->editAttributes() ?> aria-describedby="x_ci_rif_help">
<?= $Page->ci_rif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_rif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_sco_seguro_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_seguro_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="sco_seguro" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
    <div id="r_contacto"<?= $Page->contacto->rowAttributes() ?>>
        <label id="elh_sco_seguro_contacto" for="x_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contacto->caption() ?><?= $Page->contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contacto->cellAttributes() ?>>
<span id="el_sco_seguro_contacto">
<input type="<?= $Page->contacto->getInputTextType() ?>" name="x_contacto" id="x_contacto" data-table="sco_seguro" data-field="x_contacto" value="<?= $Page->contacto->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contacto->formatPattern()) ?>"<?= $Page->contacto->editAttributes() ?> aria-describedby="x_contacto_help">
<?= $Page->contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_sco_seguro_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_seguro_direccion">
<textarea data-table="sco_seguro" data-field="x_direccion" name="x_direccion" id="x_direccion" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help"><?= $Page->direccion->EditValue ?></textarea>
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <div id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <label id="elh_sco_seguro_telefono1" for="x_telefono1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono1->caption() ?><?= $Page->telefono1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_seguro_telefono1">
<input type="<?= $Page->telefono1->getInputTextType() ?>" name="x_telefono1" id="x_telefono1" data-table="sco_seguro" data-field="x_telefono1" value="<?= $Page->telefono1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono1->formatPattern()) ?>"<?= $Page->telefono1->editAttributes() ?> aria-describedby="x_telefono1_help">
<?= $Page->telefono1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_seguro_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_seguro_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_seguro" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono3->Visible) { // telefono3 ?>
    <div id="r_telefono3"<?= $Page->telefono3->rowAttributes() ?>>
        <label id="elh_sco_seguro_telefono3" for="x_telefono3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono3->caption() ?><?= $Page->telefono3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono3->cellAttributes() ?>>
<span id="el_sco_seguro_telefono3">
<input type="<?= $Page->telefono3->getInputTextType() ?>" name="x_telefono3" id="x_telefono3" data-table="sco_seguro" data-field="x_telefono3" value="<?= $Page->telefono3->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono3->formatPattern()) ?>"<?= $Page->telefono3->editAttributes() ?> aria-describedby="x_telefono3_help">
<?= $Page->telefono3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
    <div id="r_fax"<?= $Page->fax->rowAttributes() ?>>
        <label id="elh_sco_seguro_fax" for="x_fax" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fax->caption() ?><?= $Page->fax->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fax->cellAttributes() ?>>
<span id="el_sco_seguro_fax">
<input type="<?= $Page->fax->getInputTextType() ?>" name="x_fax" id="x_fax" data-table="sco_seguro" data-field="x_fax" value="<?= $Page->fax->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->fax->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fax->formatPattern()) ?>"<?= $Page->fax->editAttributes() ?> aria-describedby="x_fax_help">
<?= $Page->fax->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fax->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email1->Visible) { // email1 ?>
    <div id="r_email1"<?= $Page->email1->rowAttributes() ?>>
        <label id="elh_sco_seguro_email1" for="x_email1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email1->caption() ?><?= $Page->email1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email1->cellAttributes() ?>>
<span id="el_sco_seguro_email1">
<input type="<?= $Page->email1->getInputTextType() ?>" name="x_email1" id="x_email1" data-table="sco_seguro" data-field="x_email1" value="<?= $Page->email1->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->email1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->email1->formatPattern()) ?>"<?= $Page->email1->editAttributes() ?> aria-describedby="x_email1_help">
<?= $Page->email1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email2->Visible) { // email2 ?>
    <div id="r_email2"<?= $Page->email2->rowAttributes() ?>>
        <label id="elh_sco_seguro_email2" for="x_email2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email2->caption() ?><?= $Page->email2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email2->cellAttributes() ?>>
<span id="el_sco_seguro_email2">
<input type="<?= $Page->email2->getInputTextType() ?>" name="x_email2" id="x_email2" data-table="sco_seguro" data-field="x_email2" value="<?= $Page->email2->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->email2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->email2->formatPattern()) ?>"<?= $Page->email2->editAttributes() ?> aria-describedby="x_email2_help">
<?= $Page->email2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email3->Visible) { // email3 ?>
    <div id="r_email3"<?= $Page->email3->rowAttributes() ?>>
        <label id="elh_sco_seguro_email3" for="x_email3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email3->caption() ?><?= $Page->email3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email3->cellAttributes() ?>>
<span id="el_sco_seguro_email3">
<input type="<?= $Page->email3->getInputTextType() ?>" name="x_email3" id="x_email3" data-table="sco_seguro" data-field="x_email3" value="<?= $Page->email3->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->email3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->email3->formatPattern()) ?>"<?= $Page->email3->editAttributes() ?> aria-describedby="x_email3_help">
<?= $Page->email3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->web->Visible) { // web ?>
    <div id="r_web"<?= $Page->web->rowAttributes() ?>>
        <label id="elh_sco_seguro_web" for="x_web" class="<?= $Page->LeftColumnClass ?>"><?= $Page->web->caption() ?><?= $Page->web->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->web->cellAttributes() ?>>
<span id="el_sco_seguro_web">
<input type="<?= $Page->web->getInputTextType() ?>" name="x_web" id="x_web" data-table="sco_seguro" data-field="x_web" value="<?= $Page->web->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->web->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->web->formatPattern()) ?>"<?= $Page->web->editAttributes() ?> aria-describedby="x_web_help">
<?= $Page->web->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->web->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_seguro_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_seguro_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_seguroadd_x_activo"
        <?php } ?>
        data-table="sco_seguro"
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
loadjs.ready("fsco_seguroadd", function() {
    var options = { name: "x_activo", selectId: "fsco_seguroadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguroadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_seguroadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_seguroadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguro.fields.activo.selectOptions);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_seguroadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_seguroadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_seguro");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_ci_rif").mask("a999999999");
    $("#x_telefono1").mask("(9999) 999-99-99");
    $("#x_telefono2").mask("(9999) 999-99-99");
    $("#x_telefono3").mask("(9999) 999-99-99");
    $("#x_fax").mask("(9999) 999-99-99");
});
</script>
