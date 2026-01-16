<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoOfreceServicioGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_ofrece_serviciogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_ofrece_servicio: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_ofrece_serviciogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo",false],["servicio",false]];
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
            "tipo": <?= $Grid->tipo->toClientList($Grid) ?>,
            "servicio": <?= $Grid->servicio->toClientList($Grid) ?>,
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
<div id="fsco_ofrece_serviciogrid" class="ew-form ew-list-form">
<div id="gmp_sco_ofrece_servicio" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_ofrece_serviciogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Grid->tipo->headerCellClass() ?>"><div id="elh_sco_ofrece_servicio_tipo" class="sco_ofrece_servicio_tipo"><?= $Grid->renderFieldHeader($Grid->tipo) ?></div></th>
<?php } ?>
<?php if ($Grid->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Grid->servicio->headerCellClass() ?>"><div id="elh_sco_ofrece_servicio_servicio" class="sco_ofrece_servicio_servicio"><?= $Grid->renderFieldHeader($Grid->servicio) ?></div></th>
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
    <?php if ($Grid->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Grid->tipo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_ofrece_servicio_tipo" class="el_sco_ofrece_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_ofrece_servicio"
        data-field="x_tipo"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?= $Grid->tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo") ?>
<?php if (!$Grid->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ofrece_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ofrece_serviciogrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_ofrece_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_ofrece_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_ofrece_servicio.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_ofrece_servicio" data-field="x_tipo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo" id="o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_ofrece_servicio_tipo" class="el_sco_ofrece_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_ofrece_servicio"
        data-field="x_tipo"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?= $Grid->tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo") ?>
<?php if (!$Grid->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ofrece_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ofrece_serviciogrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_ofrece_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_ofrece_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_ofrece_servicio.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_ofrece_servicio_tipo" class="el_sco_ofrece_servicio_tipo">
<span<?= $Grid->tipo->viewAttributes() ?>>
<?= $Grid->tipo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_ofrece_servicio" data-field="x_tipo" data-hidden="1" name="fsco_ofrece_serviciogrid$x<?= $Grid->RowIndex ?>_tipo" id="fsco_ofrece_serviciogrid$x<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->FormValue) ?>">
<input type="hidden" data-table="sco_ofrece_servicio" data-field="x_tipo" data-hidden="1" data-old name="fsco_ofrece_serviciogrid$o<?= $Grid->RowIndex ?>_tipo" id="fsco_ofrece_serviciogrid$o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Grid->servicio->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_ofrece_servicio_servicio" class="el_sco_ofrece_servicio_servicio">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio"
        name="x<?= $Grid->RowIndex ?>_servicio"
        class="form-select ew-select<?= $Grid->servicio->isInvalidClass() ?>"
        <?php if (!$Grid->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_servicio"
        <?php } ?>
        data-table="sco_ofrece_servicio"
        data-field="x_servicio"
        data-value-separator="<?= $Grid->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->servicio->getPlaceHolder()) ?>"
        <?= $Grid->servicio->editAttributes() ?>>
        <?= $Grid->servicio->selectOptionListHtml("x{$Grid->RowIndex}_servicio") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->servicio->getErrorMessage() ?></div>
<?= $Grid->servicio->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_servicio") ?>
<?php if (!$Grid->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ofrece_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio", selectId: "fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ofrece_serviciogrid.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ofrece_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ofrece_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_ofrece_servicio.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_ofrece_servicio" data-field="x_servicio" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_servicio" id="o<?= $Grid->RowIndex ?>_servicio" value="<?= HtmlEncode($Grid->servicio->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_ofrece_servicio_servicio" class="el_sco_ofrece_servicio_servicio">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio"
        name="x<?= $Grid->RowIndex ?>_servicio"
        class="form-select ew-select<?= $Grid->servicio->isInvalidClass() ?>"
        <?php if (!$Grid->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_servicio"
        <?php } ?>
        data-table="sco_ofrece_servicio"
        data-field="x_servicio"
        data-value-separator="<?= $Grid->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->servicio->getPlaceHolder()) ?>"
        <?= $Grid->servicio->editAttributes() ?>>
        <?= $Grid->servicio->selectOptionListHtml("x{$Grid->RowIndex}_servicio") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->servicio->getErrorMessage() ?></div>
<?= $Grid->servicio->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_servicio") ?>
<?php if (!$Grid->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ofrece_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio", selectId: "fsco_ofrece_serviciogrid_x<?= $Grid->RowIndex ?>_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ofrece_serviciogrid.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ofrece_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ofrece_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_ofrece_servicio.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_ofrece_servicio_servicio" class="el_sco_ofrece_servicio_servicio">
<span<?= $Grid->servicio->viewAttributes() ?>>
<?= $Grid->servicio->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_ofrece_servicio" data-field="x_servicio" data-hidden="1" name="fsco_ofrece_serviciogrid$x<?= $Grid->RowIndex ?>_servicio" id="fsco_ofrece_serviciogrid$x<?= $Grid->RowIndex ?>_servicio" value="<?= HtmlEncode($Grid->servicio->FormValue) ?>">
<input type="hidden" data-table="sco_ofrece_servicio" data-field="x_servicio" data-hidden="1" data-old name="fsco_ofrece_serviciogrid$o<?= $Grid->RowIndex ?>_servicio" id="fsco_ofrece_serviciogrid$o<?= $Grid->RowIndex ?>_servicio" value="<?= HtmlEncode($Grid->servicio->OldValue) ?>">
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
loadjs.ready(["fsco_ofrece_serviciogrid","load"], () => fsco_ofrece_serviciogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_ofrece_serviciogrid">
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
    ew.addEventHandlers("sco_ofrece_servicio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
