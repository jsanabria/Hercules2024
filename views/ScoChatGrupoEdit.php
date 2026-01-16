<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoChatGrupoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_chat_grupoedit" id="fsco_chat_grupoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_chat_grupo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_chat_grupoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_chat_grupoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["grupo", [fields.grupo.visible && fields.grupo.required ? ew.Validators.required(fields.grupo.caption) : null], fields.grupo.isInvalid],
            ["ve_todo", [fields.ve_todo.visible && fields.ve_todo.required ? ew.Validators.required(fields.ve_todo.caption) : null], fields.ve_todo.isInvalid]
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
            "grupo": <?= $Page->grupo->toClientList($Page) ?>,
            "ve_todo": <?= $Page->ve_todo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_chat_grupo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->grupo->Visible) { // grupo ?>
    <div id="r_grupo"<?= $Page->grupo->rowAttributes() ?>>
        <label id="elh_sco_chat_grupo_grupo" for="x_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grupo->caption() ?><?= $Page->grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->grupo->cellAttributes() ?>>
<span id="el_sco_chat_grupo_grupo">
    <select
        id="x_grupo"
        name="x_grupo"
        class="form-select ew-select<?= $Page->grupo->isInvalidClass() ?>"
        <?php if (!$Page->grupo->IsNativeSelect) { ?>
        data-select2-id="fsco_chat_grupoedit_x_grupo"
        <?php } ?>
        data-table="sco_chat_grupo"
        data-field="x_grupo"
        data-value-separator="<?= $Page->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->grupo->getPlaceHolder()) ?>"
        <?= $Page->grupo->editAttributes() ?>>
        <?= $Page->grupo->selectOptionListHtml("x_grupo") ?>
    </select>
    <?= $Page->grupo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->grupo->getErrorMessage() ?></div>
<?= $Page->grupo->Lookup->getParamTag($Page, "p_x_grupo") ?>
<?php if (!$Page->grupo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_chat_grupoedit", function() {
    var options = { name: "x_grupo", selectId: "fsco_chat_grupoedit_x_grupo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_chat_grupoedit.lists.grupo?.lookupOptions.length) {
        options.data = { id: "x_grupo", form: "fsco_chat_grupoedit" };
    } else {
        options.ajax = { id: "x_grupo", form: "fsco_chat_grupoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_chat_grupo.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ve_todo->Visible) { // ve_todo ?>
    <div id="r_ve_todo"<?= $Page->ve_todo->rowAttributes() ?>>
        <label id="elh_sco_chat_grupo_ve_todo" for="x_ve_todo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ve_todo->caption() ?><?= $Page->ve_todo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ve_todo->cellAttributes() ?>>
<span id="el_sco_chat_grupo_ve_todo">
    <select
        id="x_ve_todo"
        name="x_ve_todo"
        class="form-select ew-select<?= $Page->ve_todo->isInvalidClass() ?>"
        <?php if (!$Page->ve_todo->IsNativeSelect) { ?>
        data-select2-id="fsco_chat_grupoedit_x_ve_todo"
        <?php } ?>
        data-table="sco_chat_grupo"
        data-field="x_ve_todo"
        data-value-separator="<?= $Page->ve_todo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ve_todo->getPlaceHolder()) ?>"
        <?= $Page->ve_todo->editAttributes() ?>>
        <?= $Page->ve_todo->selectOptionListHtml("x_ve_todo") ?>
    </select>
    <?= $Page->ve_todo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ve_todo->getErrorMessage() ?></div>
<?php if (!$Page->ve_todo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_chat_grupoedit", function() {
    var options = { name: "x_ve_todo", selectId: "fsco_chat_grupoedit_x_ve_todo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_chat_grupoedit.lists.ve_todo?.lookupOptions.length) {
        options.data = { id: "x_ve_todo", form: "fsco_chat_grupoedit" };
    } else {
        options.ajax = { id: "x_ve_todo", form: "fsco_chat_grupoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_chat_grupo.fields.ve_todo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_chat_grupo" data-field="x_Ngrupo_chat" data-hidden="1" name="x_Ngrupo_chat" id="x_Ngrupo_chat" value="<?= HtmlEncode($Page->Ngrupo_chat->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_chat_grupoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_chat_grupoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_chat_grupo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
