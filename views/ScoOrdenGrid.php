<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoOrdenGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_ordengrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_orden: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_ordengrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null, ew.Validators.integer], fields.cantidad.isInvalid],
            ["user_registra", [fields.user_registra.visible && fields.user_registra.required ? ew.Validators.required(fields.user_registra.caption) : null], fields.user_registra.isInvalid],
            ["ministro", [fields.ministro.visible && fields.ministro.required ? ew.Validators.required(fields.ministro.caption) : null], fields.ministro.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["servicio_tipo",false],["servicio",false],["cantidad",false],["user_registra",false],["ministro",false]];
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
            "servicio_tipo": <?= $Grid->servicio_tipo->toClientList($Grid) ?>,
            "servicio": <?= $Grid->servicio->toClientList($Grid) ?>,
            "user_registra": <?= $Grid->user_registra->toClientList($Grid) ?>,
            "ministro": <?= $Grid->ministro->toClientList($Grid) ?>,
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
<div id="fsco_ordengrid" class="ew-form ew-list-form">
<div id="gmp_sco_orden" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_ordengrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->servicio_tipo->Visible) { // servicio_tipo ?>
        <th data-name="servicio_tipo" class="<?= $Grid->servicio_tipo->headerCellClass() ?>"><div id="elh_sco_orden_servicio_tipo" class="sco_orden_servicio_tipo"><?= $Grid->renderFieldHeader($Grid->servicio_tipo) ?></div></th>
<?php } ?>
<?php if ($Grid->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Grid->servicio->headerCellClass() ?>"><div id="elh_sco_orden_servicio" class="sco_orden_servicio"><?= $Grid->renderFieldHeader($Grid->servicio) ?></div></th>
<?php } ?>
<?php if ($Grid->cantidad->Visible) { // cantidad ?>
        <th data-name="cantidad" class="<?= $Grid->cantidad->headerCellClass() ?>"><div id="elh_sco_orden_cantidad" class="sco_orden_cantidad"><?= $Grid->renderFieldHeader($Grid->cantidad) ?></div></th>
<?php } ?>
<?php if ($Grid->user_registra->Visible) { // user_registra ?>
        <th data-name="user_registra" class="<?= $Grid->user_registra->headerCellClass() ?>"><div id="elh_sco_orden_user_registra" class="sco_orden_user_registra"><?= $Grid->renderFieldHeader($Grid->user_registra) ?></div></th>
<?php } ?>
<?php if ($Grid->ministro->Visible) { // ministro ?>
        <th data-name="ministro" class="<?= $Grid->ministro->headerCellClass() ?>"><div id="elh_sco_orden_ministro" class="sco_orden_ministro"><?= $Grid->renderFieldHeader($Grid->ministro) ?></div></th>
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
    <?php if ($Grid->servicio_tipo->Visible) { // servicio_tipo ?>
        <td data-name="servicio_tipo"<?= $Grid->servicio_tipo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_servicio_tipo" class="el_sco_orden_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio_tipo"
        name="x<?= $Grid->RowIndex ?>_servicio_tipo"
        class="form-select ew-select<?= $Grid->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Grid->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio_tipo"
        <?php } ?>
        data-table="sco_orden"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Grid->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->servicio_tipo->getPlaceHolder()) ?>"
        <?= $Grid->servicio_tipo->editAttributes() ?>>
        <?= $Grid->servicio_tipo->selectOptionListHtml("x{$Grid->RowIndex}_servicio_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->servicio_tipo->getErrorMessage() ?></div>
<?= $Grid->servicio_tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_servicio_tipo") ?>
<?php if (!$Grid->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ordengrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio_tipo", selectId: "fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordengrid.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_ordengrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_ordengrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden" data-field="x_servicio_tipo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_servicio_tipo" id="o<?= $Grid->RowIndex ?>_servicio_tipo" value="<?= HtmlEncode($Grid->servicio_tipo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_servicio_tipo" class="el_sco_orden_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio_tipo"
        name="x<?= $Grid->RowIndex ?>_servicio_tipo"
        class="form-select ew-select<?= $Grid->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Grid->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio_tipo"
        <?php } ?>
        data-table="sco_orden"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Grid->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->servicio_tipo->getPlaceHolder()) ?>"
        <?= $Grid->servicio_tipo->editAttributes() ?>>
        <?= $Grid->servicio_tipo->selectOptionListHtml("x{$Grid->RowIndex}_servicio_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->servicio_tipo->getErrorMessage() ?></div>
<?= $Grid->servicio_tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_servicio_tipo") ?>
<?php if (!$Grid->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ordengrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio_tipo", selectId: "fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordengrid.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_ordengrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_ordengrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_servicio_tipo" class="el_sco_orden_servicio_tipo">
<span<?= $Grid->servicio_tipo->viewAttributes() ?>>
<?= $Grid->servicio_tipo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden" data-field="x_servicio_tipo" data-hidden="1" name="fsco_ordengrid$x<?= $Grid->RowIndex ?>_servicio_tipo" id="fsco_ordengrid$x<?= $Grid->RowIndex ?>_servicio_tipo" value="<?= HtmlEncode($Grid->servicio_tipo->FormValue) ?>">
<input type="hidden" data-table="sco_orden" data-field="x_servicio_tipo" data-hidden="1" data-old name="fsco_ordengrid$o<?= $Grid->RowIndex ?>_servicio_tipo" id="fsco_ordengrid$o<?= $Grid->RowIndex ?>_servicio_tipo" value="<?= HtmlEncode($Grid->servicio_tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Grid->servicio->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_servicio" class="el_sco_orden_servicio">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio"
        name="x<?= $Grid->RowIndex ?>_servicio"
        class="form-select ew-select<?= $Grid->servicio->isInvalidClass() ?>"
        <?php if (!$Grid->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio"
        <?php } ?>
        data-table="sco_orden"
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
loadjs.ready("fsco_ordengrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio", selectId: "fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordengrid.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ordengrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ordengrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden" data-field="x_servicio" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_servicio" id="o<?= $Grid->RowIndex ?>_servicio" value="<?= HtmlEncode($Grid->servicio->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_servicio" class="el_sco_orden_servicio">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio"
        name="x<?= $Grid->RowIndex ?>_servicio"
        class="form-select ew-select<?= $Grid->servicio->isInvalidClass() ?>"
        <?php if (!$Grid->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio"
        <?php } ?>
        data-table="sco_orden"
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
loadjs.ready("fsco_ordengrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio", selectId: "fsco_ordengrid_x<?= $Grid->RowIndex ?>_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordengrid.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ordengrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio", form: "fsco_ordengrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_servicio" class="el_sco_orden_servicio">
<span<?= $Grid->servicio->viewAttributes() ?>>
<?= $Grid->servicio->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden" data-field="x_servicio" data-hidden="1" name="fsco_ordengrid$x<?= $Grid->RowIndex ?>_servicio" id="fsco_ordengrid$x<?= $Grid->RowIndex ?>_servicio" value="<?= HtmlEncode($Grid->servicio->FormValue) ?>">
<input type="hidden" data-table="sco_orden" data-field="x_servicio" data-hidden="1" data-old name="fsco_ordengrid$o<?= $Grid->RowIndex ?>_servicio" id="fsco_ordengrid$o<?= $Grid->RowIndex ?>_servicio" value="<?= HtmlEncode($Grid->servicio->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cantidad->Visible) { // cantidad ?>
        <td data-name="cantidad"<?= $Grid->cantidad->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_cantidad" class="el_sco_orden_cantidad">
<input type="<?= $Grid->cantidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad" id="x<?= $Grid->RowIndex ?>_cantidad" data-table="sco_orden" data-field="x_cantidad" value="<?= $Grid->cantidad->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad->formatPattern()) ?>"<?= $Grid->cantidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden" data-field="x_cantidad" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cantidad" id="o<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_cantidad" class="el_sco_orden_cantidad">
<input type="<?= $Grid->cantidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad" id="x<?= $Grid->RowIndex ?>_cantidad" data-table="sco_orden" data-field="x_cantidad" value="<?= $Grid->cantidad->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad->formatPattern()) ?>"<?= $Grid->cantidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_cantidad" class="el_sco_orden_cantidad">
<span<?= $Grid->cantidad->viewAttributes() ?>>
<?= $Grid->cantidad->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden" data-field="x_cantidad" data-hidden="1" name="fsco_ordengrid$x<?= $Grid->RowIndex ?>_cantidad" id="fsco_ordengrid$x<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->FormValue) ?>">
<input type="hidden" data-table="sco_orden" data-field="x_cantidad" data-hidden="1" data-old name="fsco_ordengrid$o<?= $Grid->RowIndex ?>_cantidad" id="fsco_ordengrid$o<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->user_registra->Visible) { // user_registra ?>
        <td data-name="user_registra"<?= $Grid->user_registra->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_user_registra" class="el_sco_orden_user_registra">
<?php
if (IsRTL()) {
    $Grid->user_registra->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_user_registra" class="ew-auto-suggest">
    <input type="<?= $Grid->user_registra->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_user_registra" id="sv_x<?= $Grid->RowIndex ?>_user_registra" value="<?= RemoveHtml($Grid->user_registra->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->user_registra->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->user_registra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->user_registra->formatPattern()) ?>"<?= $Grid->user_registra->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_orden" data-field="x_user_registra" data-input="sv_x<?= $Grid->RowIndex ?>_user_registra" data-value-separator="<?= $Grid->user_registra->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_user_registra" id="x<?= $Grid->RowIndex ?>_user_registra" value="<?= HtmlEncode($Grid->user_registra->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->user_registra->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_ordengrid", function() {
    fsco_ordengrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_user_registra","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->user_registra->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_orden.fields.user_registra.autoSuggestOptions));
});
</script>
<?= $Grid->user_registra->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_user_registra") ?>
</span>
<input type="hidden" data-table="sco_orden" data-field="x_user_registra" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_user_registra" id="o<?= $Grid->RowIndex ?>_user_registra" value="<?= HtmlEncode($Grid->user_registra->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_user_registra" class="el_sco_orden_user_registra">
<?php
if (IsRTL()) {
    $Grid->user_registra->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_user_registra" class="ew-auto-suggest">
    <input type="<?= $Grid->user_registra->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_user_registra" id="sv_x<?= $Grid->RowIndex ?>_user_registra" value="<?= RemoveHtml($Grid->user_registra->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->user_registra->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->user_registra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->user_registra->formatPattern()) ?>"<?= $Grid->user_registra->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_orden" data-field="x_user_registra" data-input="sv_x<?= $Grid->RowIndex ?>_user_registra" data-value-separator="<?= $Grid->user_registra->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_user_registra" id="x<?= $Grid->RowIndex ?>_user_registra" value="<?= HtmlEncode($Grid->user_registra->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->user_registra->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_ordengrid", function() {
    fsco_ordengrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_user_registra","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->user_registra->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_orden.fields.user_registra.autoSuggestOptions));
});
</script>
<?= $Grid->user_registra->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_user_registra") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_user_registra" class="el_sco_orden_user_registra">
<span<?= $Grid->user_registra->viewAttributes() ?>>
<?= $Grid->user_registra->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden" data-field="x_user_registra" data-hidden="1" name="fsco_ordengrid$x<?= $Grid->RowIndex ?>_user_registra" id="fsco_ordengrid$x<?= $Grid->RowIndex ?>_user_registra" value="<?= HtmlEncode($Grid->user_registra->FormValue) ?>">
<input type="hidden" data-table="sco_orden" data-field="x_user_registra" data-hidden="1" data-old name="fsco_ordengrid$o<?= $Grid->RowIndex ?>_user_registra" id="fsco_ordengrid$o<?= $Grid->RowIndex ?>_user_registra" value="<?= HtmlEncode($Grid->user_registra->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ministro->Visible) { // ministro ?>
        <td data-name="ministro"<?= $Grid->ministro->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_ministro" class="el_sco_orden_ministro">
<?php
if (IsRTL()) {
    $Grid->ministro->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_ministro" class="ew-auto-suggest">
    <input type="<?= $Grid->ministro->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_ministro" id="sv_x<?= $Grid->RowIndex ?>_ministro" value="<?= RemoveHtml($Grid->ministro->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->ministro->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->ministro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ministro->formatPattern()) ?>"<?= $Grid->ministro->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_orden" data-field="x_ministro" data-input="sv_x<?= $Grid->RowIndex ?>_ministro" data-value-separator="<?= $Grid->ministro->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_ministro" id="x<?= $Grid->RowIndex ?>_ministro" value="<?= HtmlEncode($Grid->ministro->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->ministro->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_ordengrid", function() {
    fsco_ordengrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_ministro","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->ministro->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_orden.fields.ministro.autoSuggestOptions));
});
</script>
<?= $Grid->ministro->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ministro") ?>
</span>
<input type="hidden" data-table="sco_orden" data-field="x_ministro" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ministro" id="o<?= $Grid->RowIndex ?>_ministro" value="<?= HtmlEncode($Grid->ministro->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_ministro" class="el_sco_orden_ministro">
<?php
if (IsRTL()) {
    $Grid->ministro->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_ministro" class="ew-auto-suggest">
    <input type="<?= $Grid->ministro->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_ministro" id="sv_x<?= $Grid->RowIndex ?>_ministro" value="<?= RemoveHtml($Grid->ministro->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->ministro->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->ministro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ministro->formatPattern()) ?>"<?= $Grid->ministro->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_orden" data-field="x_ministro" data-input="sv_x<?= $Grid->RowIndex ?>_ministro" data-value-separator="<?= $Grid->ministro->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_ministro" id="x<?= $Grid->RowIndex ?>_ministro" value="<?= HtmlEncode($Grid->ministro->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->ministro->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_ordengrid", function() {
    fsco_ordengrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_ministro","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->ministro->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_orden.fields.ministro.autoSuggestOptions));
});
</script>
<?= $Grid->ministro->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ministro") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_ministro" class="el_sco_orden_ministro">
<span<?= $Grid->ministro->viewAttributes() ?>>
<?= $Grid->ministro->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden" data-field="x_ministro" data-hidden="1" name="fsco_ordengrid$x<?= $Grid->RowIndex ?>_ministro" id="fsco_ordengrid$x<?= $Grid->RowIndex ?>_ministro" value="<?= HtmlEncode($Grid->ministro->FormValue) ?>">
<input type="hidden" data-table="sco_orden" data-field="x_ministro" data-hidden="1" data-old name="fsco_ordengrid$o<?= $Grid->RowIndex ?>_ministro" id="fsco_ordengrid$o<?= $Grid->RowIndex ?>_ministro" value="<?= HtmlEncode($Grid->ministro->OldValue) ?>">
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
loadjs.ready(["fsco_ordengrid","load"], () => fsco_ordengrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_ordengrid">
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
    ew.addEventHandlers("sco_orden");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
