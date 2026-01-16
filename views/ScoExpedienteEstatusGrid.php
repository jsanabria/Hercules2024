<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoExpedienteEstatusGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_expediente_estatusgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_expediente_estatus: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_estatusgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["halcon", [fields.halcon.visible && fields.halcon.required ? ew.Validators.required(fields.halcon.caption) : null], fields.halcon.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["_username",false],["halcon",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
                return true;
            }
        )

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
            "_username": <?= $Grid->_username->toClientList($Grid) ?>,
            "halcon": <?= $Grid->halcon->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<main class="list">
<div id="ew-header-options">
<?php $Grid->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fsco_expediente_estatusgrid" class="ew-form ew-list-form">
<div id="gmp_sco_expediente_estatus" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_expediente_estatusgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_sco_expediente_estatus__username" class="sco_expediente_estatus__username"><?= $Grid->renderFieldHeader($Grid->_username) ?></div></th>
<?php } ?>
<?php if ($Grid->halcon->Visible) { // halcon ?>
        <th data-name="halcon" class="<?= $Grid->halcon->headerCellClass() ?>"><div id="elh_sco_expediente_estatus_halcon" class="sco_expediente_estatus_halcon"><?= $Grid->renderFieldHeader($Grid->halcon) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
$isInlineAddOrCopy = ($Grid->isCopy() || $Grid->isAdd());
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Grid->RowIndex == 0) {
    if (
        $Grid->CurrentRow !== false &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Grid->RowIndex == 0)
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username"<?= $Grid->_username->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_estatus__username" class="el_sco_expediente_estatus__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_expediente_estatus" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_expediente_estatusgrid", function() {
    fsco_expediente_estatusgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_expediente_estatus.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x__username" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_estatus__username" class="el_sco_expediente_estatus__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->_username->getDisplayValue($Grid->_username->EditValue) ?></span></span>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x__username" data-hidden="1" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_estatus__username" class="el_sco_expediente_estatus__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x__username" data-hidden="1" name="fsco_expediente_estatusgrid$x<?= $Grid->RowIndex ?>__username" id="fsco_expediente_estatusgrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_estatus" data-field="x__username" data-hidden="1" data-old name="fsco_expediente_estatusgrid$o<?= $Grid->RowIndex ?>__username" id="fsco_expediente_estatusgrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->halcon->Visible) { // halcon ?>
        <td data-name="halcon"<?= $Grid->halcon->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_estatus_halcon" class="el_sco_expediente_estatus_halcon">
    <select
        id="x<?= $Grid->RowIndex ?>_halcon"
        name="x<?= $Grid->RowIndex ?>_halcon"
        class="form-select ew-select<?= $Grid->halcon->isInvalidClass() ?>"
        <?php if (!$Grid->halcon->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_estatusgrid_x<?= $Grid->RowIndex ?>_halcon"
        <?php } ?>
        data-table="sco_expediente_estatus"
        data-field="x_halcon"
        data-value-separator="<?= $Grid->halcon->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->halcon->getPlaceHolder()) ?>"
        <?= $Grid->halcon->editAttributes() ?>>
        <?= $Grid->halcon->selectOptionListHtml("x{$Grid->RowIndex}_halcon") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->halcon->getErrorMessage() ?></div>
<?= $Grid->halcon->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_halcon") ?>
<?php if (!$Grid->halcon->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_estatusgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_halcon", selectId: "fsco_expediente_estatusgrid_x<?= $Grid->RowIndex ?>_halcon" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_estatusgrid.lists.halcon?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_halcon", form: "fsco_expediente_estatusgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_halcon", form: "fsco_expediente_estatusgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_estatus.fields.halcon.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x_halcon" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_halcon" id="o<?= $Grid->RowIndex ?>_halcon" value="<?= HtmlEncode($Grid->halcon->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_estatus_halcon" class="el_sco_expediente_estatus_halcon">
    <select
        id="x<?= $Grid->RowIndex ?>_halcon"
        name="x<?= $Grid->RowIndex ?>_halcon"
        class="form-select ew-select<?= $Grid->halcon->isInvalidClass() ?>"
        <?php if (!$Grid->halcon->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_estatusgrid_x<?= $Grid->RowIndex ?>_halcon"
        <?php } ?>
        data-table="sco_expediente_estatus"
        data-field="x_halcon"
        data-value-separator="<?= $Grid->halcon->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->halcon->getPlaceHolder()) ?>"
        <?= $Grid->halcon->editAttributes() ?>>
        <?= $Grid->halcon->selectOptionListHtml("x{$Grid->RowIndex}_halcon") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->halcon->getErrorMessage() ?></div>
<?= $Grid->halcon->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_halcon") ?>
<?php if (!$Grid->halcon->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_estatusgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_halcon", selectId: "fsco_expediente_estatusgrid_x<?= $Grid->RowIndex ?>_halcon" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_estatusgrid.lists.halcon?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_halcon", form: "fsco_expediente_estatusgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_halcon", form: "fsco_expediente_estatusgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_estatus.fields.halcon.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_estatus_halcon" class="el_sco_expediente_estatus_halcon">
<span<?= $Grid->halcon->viewAttributes() ?>>
<?= $Grid->halcon->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_estatus" data-field="x_halcon" data-hidden="1" name="fsco_expediente_estatusgrid$x<?= $Grid->RowIndex ?>_halcon" id="fsco_expediente_estatusgrid$x<?= $Grid->RowIndex ?>_halcon" value="<?= HtmlEncode($Grid->halcon->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_estatus" data-field="x_halcon" data-hidden="1" data-old name="fsco_expediente_estatusgrid$o<?= $Grid->RowIndex ?>_halcon" id="fsco_expediente_estatusgrid$o<?= $Grid->RowIndex ?>_halcon" value="<?= HtmlEncode($Grid->halcon->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fsco_expediente_estatusgrid","load"], () => fsco_expediente_estatusgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsco_expediente_estatusgrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Recordset?->free();
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Grid->FooterOptions?->render("body") ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
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
<?php } ?>
