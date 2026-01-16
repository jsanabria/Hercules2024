<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteCiaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_expediente_ciaedit" id="fsco_expediente_ciaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_cia: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_expediente_ciaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_ciaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["cia", [fields.cia.visible && fields.cia.required ? ew.Validators.required(fields.cia.caption) : null], fields.cia.isInvalid],
            ["expediente", [fields.expediente.visible && fields.expediente.required ? ew.Validators.required(fields.expediente.caption) : null], fields.expediente.isInvalid],
            ["factura", [fields.factura.visible && fields.factura.required ? ew.Validators.required(fields.factura.caption) : null], fields.factura.isInvalid],
            ["monto", [fields.monto.visible && fields.monto.required ? ew.Validators.required(fields.monto.caption) : null, ew.Validators.float], fields.monto.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid]
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
            "cia": <?= $Page->cia->toClientList($Page) ?>,
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_expediente_cia">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_expediente") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_expediente">
<input type="hidden" name="fk_Nexpediente" value="<?= HtmlEncode($Page->expediente->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->cia->Visible) { // cia ?>
    <div id="r_cia"<?= $Page->cia->rowAttributes() ?>>
        <label id="elh_sco_expediente_cia_cia" for="x_cia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cia->caption() ?><?= $Page->cia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cia->cellAttributes() ?>>
<span id="el_sco_expediente_cia_cia">
    <select
        id="x_cia"
        name="x_cia"
        class="form-select ew-select<?= $Page->cia->isInvalidClass() ?>"
        <?php if (!$Page->cia->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciaedit_x_cia"
        <?php } ?>
        data-table="sco_expediente_cia"
        data-field="x_cia"
        data-value-separator="<?= $Page->cia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cia->getPlaceHolder()) ?>"
        <?= $Page->cia->editAttributes() ?>>
        <?= $Page->cia->selectOptionListHtml("x_cia") ?>
    </select>
    <?= $Page->cia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cia->getErrorMessage() ?></div>
<?= $Page->cia->Lookup->getParamTag($Page, "p_x_cia") ?>
<?php if (!$Page->cia->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_ciaedit", function() {
    var options = { name: "x_cia", selectId: "fsco_expediente_ciaedit_x_cia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciaedit.lists.cia?.lookupOptions.length) {
        options.data = { id: "x_cia", form: "fsco_expediente_ciaedit" };
    } else {
        options.ajax = { id: "x_cia", form: "fsco_expediente_ciaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.cia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
    <div id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <label id="elh_sco_expediente_cia_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expediente->caption() ?><?= $Page->expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expediente->cellAttributes() ?>>
<span id="el_sco_expediente_cia_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expediente->getDisplayValue($Page->expediente->EditValue) ?></span></span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_expediente" data-hidden="1" name="x_expediente" id="x_expediente" value="<?= HtmlEncode($Page->expediente->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <div id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <label id="elh_sco_expediente_cia_factura" for="x_factura" class="<?= $Page->LeftColumnClass ?>"><?= $Page->factura->caption() ?><?= $Page->factura->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->factura->cellAttributes() ?>>
<span id="el_sco_expediente_cia_factura">
<input type="<?= $Page->factura->getInputTextType() ?>" name="x_factura" id="x_factura" data-table="sco_expediente_cia" data-field="x_factura" value="<?= $Page->factura->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->factura->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->factura->formatPattern()) ?>"<?= $Page->factura->editAttributes() ?> aria-describedby="x_factura_help">
<?= $Page->factura->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->factura->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <div id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <label id="elh_sco_expediente_cia_monto" for="x_monto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto->caption() ?><?= $Page->monto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto->cellAttributes() ?>>
<span id="el_sco_expediente_cia_monto">
<input type="<?= $Page->monto->getInputTextType() ?>" name="x_monto" id="x_monto" data-table="sco_expediente_cia" data-field="x_monto" value="<?= $Page->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto->formatPattern()) ?>"<?= $Page->monto->editAttributes() ?> aria-describedby="x_monto_help">
<?= $Page->monto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_expediente_cia_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_cia_nota">
<input type="<?= $Page->nota->getInputTextType() ?>" name="x_nota" id="x_nota" data-table="sco_expediente_cia" data-field="x_nota" value="<?= $Page->nota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nota->formatPattern()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help">
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_expediente_cia_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_cia_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciaedit_x_estatus"
        <?php } ?>
        data-table="sco_expediente_cia"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_ciaedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_expediente_ciaedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciaedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_expediente_ciaedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_expediente_ciaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_expediente_cia" data-field="x_Nexpediente_cia" data-hidden="1" name="x_Nexpediente_cia" id="x_Nexpediente_cia" value="<?= HtmlEncode($Page->Nexpediente_cia->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expediente_ciaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expediente_ciaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_expediente_cia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
