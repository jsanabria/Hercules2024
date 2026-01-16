<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCiaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_ciaedit" id="fsco_ciaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_cia: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_ciaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_ciaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["rif", [fields.rif.visible && fields.rif.required ? ew.Validators.required(fields.rif.caption) : null], fields.rif.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid],
            ["contacto", [fields.contacto.visible && fields.contacto.required ? ew.Validators.required(fields.contacto.caption) : null], fields.contacto.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid]
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
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_cia">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->servicio->Visible) { // servicio ?>
    <div id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <label id="elh_sco_cia_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_cia_servicio">
    <select
        id="x_servicio"
        name="x_servicio"
        class="form-select ew-select<?= $Page->servicio->isInvalidClass() ?>"
        <?php if (!$Page->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_ciaedit_x_servicio"
        <?php } ?>
        data-table="sco_cia"
        data-field="x_servicio"
        data-value-separator="<?= $Page->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>"
        <?= $Page->servicio->editAttributes() ?>>
        <?= $Page->servicio->selectOptionListHtml("x_servicio") ?>
    </select>
    <?= $Page->servicio->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio->getErrorMessage() ?></div>
<?= $Page->servicio->Lookup->getParamTag($Page, "p_x_servicio") ?>
<?php if (!$Page->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ciaedit", function() {
    var options = { name: "x_servicio", selectId: "fsco_ciaedit_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ciaedit.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fsco_ciaedit" };
    } else {
        options.ajax = { id: "x_servicio", form: "fsco_ciaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_cia.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_sco_cia_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_cia_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="sco_cia" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rif->Visible) { // rif ?>
    <div id="r_rif"<?= $Page->rif->rowAttributes() ?>>
        <label id="elh_sco_cia_rif" for="x_rif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rif->caption() ?><?= $Page->rif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rif->cellAttributes() ?>>
<span id="el_sco_cia_rif">
<input type="<?= $Page->rif->getInputTextType() ?>" name="x_rif" id="x_rif" data-table="sco_cia" data-field="x_rif" value="<?= $Page->rif->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->rif->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rif->formatPattern()) ?>"<?= $Page->rif->editAttributes() ?> aria-describedby="x_rif_help">
<?= $Page->rif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_sco_cia_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_cia_direccion">
<input type="<?= $Page->direccion->getInputTextType() ?>" name="x_direccion" id="x_direccion" data-table="sco_cia" data-field="x_direccion" value="<?= $Page->direccion->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direccion->formatPattern()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help">
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
    <div id="r_telefono"<?= $Page->telefono->rowAttributes() ?>>
        <label id="elh_sco_cia_telefono" for="x_telefono" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono->caption() ?><?= $Page->telefono->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono->cellAttributes() ?>>
<span id="el_sco_cia_telefono">
<input type="<?= $Page->telefono->getInputTextType() ?>" name="x_telefono" id="x_telefono" data-table="sco_cia" data-field="x_telefono" value="<?= $Page->telefono->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono->formatPattern()) ?>"<?= $Page->telefono->editAttributes() ?> aria-describedby="x_telefono_help">
<?= $Page->telefono->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contacto->Visible) { // contacto ?>
    <div id="r_contacto"<?= $Page->contacto->rowAttributes() ?>>
        <label id="elh_sco_cia_contacto" for="x_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contacto->caption() ?><?= $Page->contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contacto->cellAttributes() ?>>
<span id="el_sco_cia_contacto">
<input type="<?= $Page->contacto->getInputTextType() ?>" name="x_contacto" id="x_contacto" data-table="sco_cia" data-field="x_contacto" value="<?= $Page->contacto->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contacto->formatPattern()) ?>"<?= $Page->contacto->editAttributes() ?> aria-describedby="x_contacto_help">
<?= $Page->contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_cia__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_cia__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_cia" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_cia" data-field="x_Ncia" data-hidden="1" name="x_Ncia" id="x_Ncia" value="<?= HtmlEncode($Page->Ncia->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_ciaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_ciaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_cia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
