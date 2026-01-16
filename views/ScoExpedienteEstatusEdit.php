<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteEstatusEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_expediente_estatusedit" id="fsco_expediente_estatusedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_estatus: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_expediente_estatusedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_estatusedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["expediente", [fields.expediente.visible && fields.expediente.required ? ew.Validators.required(fields.expediente.caption) : null], fields.expediente.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["halcon", [fields.halcon.visible && fields.halcon.required ? ew.Validators.required(fields.halcon.caption) : null], fields.halcon.isInvalid]
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
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
            "halcon": <?= $Page->halcon->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_expediente_estatus">
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
<?php if ($Page->expediente->Visible) { // expediente ?>
    <div id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <label id="elh_sco_expediente_estatus_expediente" for="x_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expediente->caption() ?><?= $Page->expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expediente->cellAttributes() ?>>
<span id="el_sco_expediente_estatus_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?php if (!EmptyString($Page->expediente->EditValue) && $Page->expediente->linkAttributes() != "") { ?>
<a<?= $Page->expediente->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expediente->getDisplayValue($Page->expediente->EditValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expediente->getDisplayValue($Page->expediente->EditValue))) ?>">
<?php } ?>
</span>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x_expediente" data-hidden="1" name="x_expediente" id="x_expediente" value="<?= HtmlEncode($Page->expediente->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_expediente_estatus_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_estatus_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_estatusedit_x_estatus"
        <?php } ?>
        data-table="sco_expediente_estatus"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?= $Page->estatus->Lookup->getParamTag($Page, "p_x_estatus") ?>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_estatusedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_expediente_estatusedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_estatusedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_expediente_estatusedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_expediente_estatusedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_estatus.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x_estatus" data-hidden="1" data-old name="o_estatus" id="o_estatus" value="<?= HtmlEncode($Page->estatus->OldValue ?? $Page->estatus->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->halcon->Visible) { // halcon ?>
    <div id="r_halcon"<?= $Page->halcon->rowAttributes() ?>>
        <label id="elh_sco_expediente_estatus_halcon" for="x_halcon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->halcon->caption() ?><?= $Page->halcon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->halcon->cellAttributes() ?>>
<span id="el_sco_expediente_estatus_halcon">
    <select
        id="x_halcon"
        name="x_halcon"
        class="form-select ew-select<?= $Page->halcon->isInvalidClass() ?>"
        <?php if (!$Page->halcon->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_estatusedit_x_halcon"
        <?php } ?>
        data-table="sco_expediente_estatus"
        data-field="x_halcon"
        data-value-separator="<?= $Page->halcon->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->halcon->getPlaceHolder()) ?>"
        <?= $Page->halcon->editAttributes() ?>>
        <?= $Page->halcon->selectOptionListHtml("x_halcon") ?>
    </select>
    <?= $Page->halcon->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->halcon->getErrorMessage() ?></div>
<?= $Page->halcon->Lookup->getParamTag($Page, "p_x_halcon") ?>
<?php if (!$Page->halcon->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_estatusedit", function() {
    var options = { name: "x_halcon", selectId: "fsco_expediente_estatusedit_x_halcon" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_estatusedit.lists.halcon?.lookupOptions.length) {
        options.data = { id: "x_halcon", form: "fsco_expediente_estatusedit" };
    } else {
        options.ajax = { id: "x_halcon", form: "fsco_expediente_estatusedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_estatus.fields.halcon.selectOptions);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expediente_estatusedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expediente_estatusedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_expediente_estatus");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
