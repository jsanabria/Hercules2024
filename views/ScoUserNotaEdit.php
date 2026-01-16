<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoUserNotaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_user_notaedit" id="fsco_user_notaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_user_nota: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_user_notaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_user_notaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["user", [fields.user.visible && fields.user.required ? ew.Validators.required(fields.user.caption) : null, ew.Validators.integer], fields.user.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid]
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
            "user": <?= $Page->user->toClientList($Page) ?>,
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_user_nota">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_user") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_user">
<input type="hidden" name="fk_Nuser" value="<?= HtmlEncode($Page->user->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->user->Visible) { // user ?>
    <div id="r_user"<?= $Page->user->rowAttributes() ?>>
        <label id="elh_sco_user_nota_user" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user->caption() ?><?= $Page->user->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user->cellAttributes() ?>>
<?php if ($Page->user->getSessionValue() != "") { ?>
<span id="el_sco_user_nota_user">
<span<?= $Page->user->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->user->getDisplayValue($Page->user->ViewValue) ?></span></span>
<input type="hidden" id="x_user" name="x_user" value="<?= HtmlEncode($Page->user->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_sco_user_nota_user">
<?php
if (IsRTL()) {
    $Page->user->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_user" class="ew-auto-suggest">
    <input type="<?= $Page->user->getInputTextType() ?>" class="form-control" name="sv_x_user" id="sv_x_user" value="<?= RemoveHtml($Page->user->EditValue) ?>" autocomplete="off" size="30" placeholder="<?= HtmlEncode($Page->user->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->user->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->user->formatPattern()) ?>"<?= $Page->user->editAttributes() ?> aria-describedby="x_user_help">
</span>
<selection-list hidden class="form-control" data-table="sco_user_nota" data-field="x_user" data-input="sv_x_user" data-value-separator="<?= $Page->user->displayValueSeparatorAttribute() ?>" name="x_user" id="x_user" value="<?= HtmlEncode($Page->user->CurrentValue) ?>"></selection-list>
<?= $Page->user->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_user_notaedit", function() {
    fsco_user_notaedit.createAutoSuggest(Object.assign({"id":"x_user","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->user->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_user_nota.fields.user.autoSuggestOptions));
});
</script>
<?= $Page->user->Lookup->getParamTag($Page, "p_x_user") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_user_nota_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_user_nota_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_user_notaedit_x_tipo"
        <?php } ?>
        data-table="sco_user_nota"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_user_notaedit", function() {
    var options = { name: "x_tipo", selectId: "fsco_user_notaedit_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_user_notaedit.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_user_notaedit" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_user_notaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_user_nota.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_user_nota_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_user_nota_nota">
<textarea data-table="sco_user_nota" data-field="x_nota" name="x_nota" id="x_nota" cols="35" rows="6" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_user_nota" data-field="x_Nuser_nota" data-hidden="1" name="x_Nuser_nota" id="x_Nuser_nota" value="<?= HtmlEncode($Page->Nuser_nota->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_user_notaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_user_notaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_user_nota");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
