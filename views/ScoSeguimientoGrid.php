<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoSeguimientoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_seguimientogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_seguimiento: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_seguimientogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["user_asigna", [fields.user_asigna.visible && fields.user_asigna.required ? ew.Validators.required(fields.user_asigna.caption) : null], fields.user_asigna.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["user_asigna",false],["estatus",false]];
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
            "user_asigna": <?= $Grid->user_asigna->toClientList($Grid) ?>,
            "estatus": <?= $Grid->estatus->toClientList($Grid) ?>,
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
<div id="fsco_seguimientogrid" class="ew-form ew-list-form">
<div id="gmp_sco_seguimiento" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_seguimientogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_sco_seguimiento__username" class="sco_seguimiento__username"><?= $Grid->renderFieldHeader($Grid->_username) ?></div></th>
<?php } ?>
<?php if ($Grid->user_asigna->Visible) { // user_asigna ?>
        <th data-name="user_asigna" class="<?= $Grid->user_asigna->headerCellClass() ?>"><div id="elh_sco_seguimiento_user_asigna" class="sco_seguimiento_user_asigna"><?= $Grid->renderFieldHeader($Grid->user_asigna) ?></div></th>
<?php } ?>
<?php if ($Grid->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Grid->estatus->headerCellClass() ?>"><div id="elh_sco_seguimiento_estatus" class="sco_seguimiento_estatus"><?= $Grid->renderFieldHeader($Grid->estatus) ?></div></th>
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
<input type="hidden" data-table="sco_seguimiento" data-field="x__username" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento__username" class="el_sco_seguimiento__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_seguimiento" data-field="x__username" data-hidden="1" name="fsco_seguimientogrid$x<?= $Grid->RowIndex ?>__username" id="fsco_seguimientogrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="sco_seguimiento" data-field="x__username" data-hidden="1" data-old name="fsco_seguimientogrid$o<?= $Grid->RowIndex ?>__username" id="fsco_seguimientogrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->user_asigna->Visible) { // user_asigna ?>
        <td data-name="user_asigna"<?= $Grid->user_asigna->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento_user_asigna" class="el_sco_seguimiento_user_asigna">
    <select
        id="x<?= $Grid->RowIndex ?>_user_asigna"
        name="x<?= $Grid->RowIndex ?>_user_asigna"
        class="form-select ew-select<?= $Grid->user_asigna->isInvalidClass() ?>"
        <?php if (!$Grid->user_asigna->IsNativeSelect) { ?>
        data-select2-id="fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_user_asigna"
        <?php } ?>
        data-table="sco_seguimiento"
        data-field="x_user_asigna"
        data-value-separator="<?= $Grid->user_asigna->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_asigna->getPlaceHolder()) ?>"
        <?= $Grid->user_asigna->editAttributes() ?>>
        <?= $Grid->user_asigna->selectOptionListHtml("x{$Grid->RowIndex}_user_asigna") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_asigna->getErrorMessage() ?></div>
<?= $Grid->user_asigna->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_user_asigna") ?>
<?php if (!$Grid->user_asigna->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_seguimientogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_user_asigna", selectId: "fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_user_asigna" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguimientogrid.lists.user_asigna?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_user_asigna", form: "fsco_seguimientogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_user_asigna", form: "fsco_seguimientogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguimiento.fields.user_asigna.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_seguimiento" data-field="x_user_asigna" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_user_asigna" id="o<?= $Grid->RowIndex ?>_user_asigna" value="<?= HtmlEncode($Grid->user_asigna->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento_user_asigna" class="el_sco_seguimiento_user_asigna">
    <select
        id="x<?= $Grid->RowIndex ?>_user_asigna"
        name="x<?= $Grid->RowIndex ?>_user_asigna"
        class="form-select ew-select<?= $Grid->user_asigna->isInvalidClass() ?>"
        <?php if (!$Grid->user_asigna->IsNativeSelect) { ?>
        data-select2-id="fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_user_asigna"
        <?php } ?>
        data-table="sco_seguimiento"
        data-field="x_user_asigna"
        data-value-separator="<?= $Grid->user_asigna->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->user_asigna->getPlaceHolder()) ?>"
        <?= $Grid->user_asigna->editAttributes() ?>>
        <?= $Grid->user_asigna->selectOptionListHtml("x{$Grid->RowIndex}_user_asigna") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->user_asigna->getErrorMessage() ?></div>
<?= $Grid->user_asigna->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_user_asigna") ?>
<?php if (!$Grid->user_asigna->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_seguimientogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_user_asigna", selectId: "fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_user_asigna" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguimientogrid.lists.user_asigna?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_user_asigna", form: "fsco_seguimientogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_user_asigna", form: "fsco_seguimientogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguimiento.fields.user_asigna.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento_user_asigna" class="el_sco_seguimiento_user_asigna">
<span<?= $Grid->user_asigna->viewAttributes() ?>>
<?= $Grid->user_asigna->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_seguimiento" data-field="x_user_asigna" data-hidden="1" name="fsco_seguimientogrid$x<?= $Grid->RowIndex ?>_user_asigna" id="fsco_seguimientogrid$x<?= $Grid->RowIndex ?>_user_asigna" value="<?= HtmlEncode($Grid->user_asigna->FormValue) ?>">
<input type="hidden" data-table="sco_seguimiento" data-field="x_user_asigna" data-hidden="1" data-old name="fsco_seguimientogrid$o<?= $Grid->RowIndex ?>_user_asigna" id="fsco_seguimientogrid$o<?= $Grid->RowIndex ?>_user_asigna" value="<?= HtmlEncode($Grid->user_asigna->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Grid->estatus->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento_estatus" class="el_sco_seguimiento_estatus">
    <select
        id="x<?= $Grid->RowIndex ?>_estatus"
        name="x<?= $Grid->RowIndex ?>_estatus"
        class="form-select ew-select<?= $Grid->estatus->isInvalidClass() ?>"
        <?php if (!$Grid->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_estatus"
        <?php } ?>
        data-table="sco_seguimiento"
        data-field="x_estatus"
        data-value-separator="<?= $Grid->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>"
        <?= $Grid->estatus->editAttributes() ?>>
        <?= $Grid->estatus->selectOptionListHtml("x{$Grid->RowIndex}_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<?php if (!$Grid->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_seguimientogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_estatus", selectId: "fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguimientogrid.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_seguimientogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_seguimientogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguimiento.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_seguimiento" data-field="x_estatus" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_estatus" id="o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento_estatus" class="el_sco_seguimiento_estatus">
    <select
        id="x<?= $Grid->RowIndex ?>_estatus"
        name="x<?= $Grid->RowIndex ?>_estatus"
        class="form-select ew-select<?= $Grid->estatus->isInvalidClass() ?>"
        <?php if (!$Grid->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_estatus"
        <?php } ?>
        data-table="sco_seguimiento"
        data-field="x_estatus"
        data-value-separator="<?= $Grid->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>"
        <?= $Grid->estatus->editAttributes() ?>>
        <?= $Grid->estatus->selectOptionListHtml("x{$Grid->RowIndex}_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<?php if (!$Grid->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_seguimientogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_estatus", selectId: "fsco_seguimientogrid_x<?= $Grid->RowIndex ?>_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguimientogrid.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_seguimientogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_seguimientogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguimiento.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_seguimiento_estatus" class="el_sco_seguimiento_estatus">
<span<?= $Grid->estatus->viewAttributes() ?>>
<?= $Grid->estatus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_seguimiento" data-field="x_estatus" data-hidden="1" name="fsco_seguimientogrid$x<?= $Grid->RowIndex ?>_estatus" id="fsco_seguimientogrid$x<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->FormValue) ?>">
<input type="hidden" data-table="sco_seguimiento" data-field="x_estatus" data-hidden="1" data-old name="fsco_seguimientogrid$o<?= $Grid->RowIndex ?>_estatus" id="fsco_seguimientogrid$o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
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
loadjs.ready(["fsco_seguimientogrid","load"], () => fsco_seguimientogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_seguimientogrid">
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
    ew.addEventHandlers("sco_seguimiento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
