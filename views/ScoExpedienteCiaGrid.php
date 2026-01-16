<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoExpedienteCiaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_expediente_ciagrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_expediente_cia: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_ciagrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["cia", [fields.cia.visible && fields.cia.required ? ew.Validators.required(fields.cia.caption) : null], fields.cia.isInvalid],
            ["expediente", [fields.expediente.visible && fields.expediente.required ? ew.Validators.required(fields.expediente.caption) : null], fields.expediente.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["factura", [fields.factura.visible && fields.factura.required ? ew.Validators.required(fields.factura.caption) : null], fields.factura.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["monto", [fields.monto.visible && fields.monto.required ? ew.Validators.required(fields.monto.caption) : null, ew.Validators.float], fields.monto.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["cia",false],["expediente",false],["servicio_tipo",false],["factura",false],["fecha",false],["monto",false],["nota",false],["_username",false],["estatus",false]];
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
            "cia": <?= $Grid->cia->toClientList($Grid) ?>,
            "expediente": <?= $Grid->expediente->toClientList($Grid) ?>,
            "servicio_tipo": <?= $Grid->servicio_tipo->toClientList($Grid) ?>,
            "_username": <?= $Grid->_username->toClientList($Grid) ?>,
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
<div id="fsco_expediente_ciagrid" class="ew-form ew-list-form">
<div id="gmp_sco_expediente_cia" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_expediente_ciagrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->cia->Visible) { // cia ?>
        <th data-name="cia" class="<?= $Grid->cia->headerCellClass() ?>"><div id="elh_sco_expediente_cia_cia" class="sco_expediente_cia_cia"><?= $Grid->renderFieldHeader($Grid->cia) ?></div></th>
<?php } ?>
<?php if ($Grid->expediente->Visible) { // expediente ?>
        <th data-name="expediente" class="<?= $Grid->expediente->headerCellClass() ?>"><div id="elh_sco_expediente_cia_expediente" class="sco_expediente_cia_expediente"><?= $Grid->renderFieldHeader($Grid->expediente) ?></div></th>
<?php } ?>
<?php if ($Grid->servicio_tipo->Visible) { // servicio_tipo ?>
        <th data-name="servicio_tipo" class="<?= $Grid->servicio_tipo->headerCellClass() ?>"><div id="elh_sco_expediente_cia_servicio_tipo" class="sco_expediente_cia_servicio_tipo"><?= $Grid->renderFieldHeader($Grid->servicio_tipo) ?></div></th>
<?php } ?>
<?php if ($Grid->factura->Visible) { // factura ?>
        <th data-name="factura" class="<?= $Grid->factura->headerCellClass() ?>"><div id="elh_sco_expediente_cia_factura" class="sco_expediente_cia_factura"><?= $Grid->renderFieldHeader($Grid->factura) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_sco_expediente_cia_fecha" class="sco_expediente_cia_fecha"><?= $Grid->renderFieldHeader($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->monto->Visible) { // monto ?>
        <th data-name="monto" class="<?= $Grid->monto->headerCellClass() ?>"><div id="elh_sco_expediente_cia_monto" class="sco_expediente_cia_monto"><?= $Grid->renderFieldHeader($Grid->monto) ?></div></th>
<?php } ?>
<?php if ($Grid->nota->Visible) { // nota ?>
        <th data-name="nota" class="<?= $Grid->nota->headerCellClass() ?>"><div id="elh_sco_expediente_cia_nota" class="sco_expediente_cia_nota"><?= $Grid->renderFieldHeader($Grid->nota) ?></div></th>
<?php } ?>
<?php if ($Grid->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_sco_expediente_cia__username" class="sco_expediente_cia__username"><?= $Grid->renderFieldHeader($Grid->_username) ?></div></th>
<?php } ?>
<?php if ($Grid->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Grid->estatus->headerCellClass() ?>"><div id="elh_sco_expediente_cia_estatus" class="sco_expediente_cia_estatus"><?= $Grid->renderFieldHeader($Grid->estatus) ?></div></th>
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
    <?php if ($Grid->cia->Visible) { // cia ?>
        <td data-name="cia"<?= $Grid->cia->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_cia" class="el_sco_expediente_cia_cia">
    <select
        id="x<?= $Grid->RowIndex ?>_cia"
        name="x<?= $Grid->RowIndex ?>_cia"
        class="form-select ew-select<?= $Grid->cia->isInvalidClass() ?>"
        <?php if (!$Grid->cia->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_cia"
        <?php } ?>
        data-table="sco_expediente_cia"
        data-field="x_cia"
        data-value-separator="<?= $Grid->cia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cia->getPlaceHolder()) ?>"
        <?= $Grid->cia->editAttributes() ?>>
        <?= $Grid->cia->selectOptionListHtml("x{$Grid->RowIndex}_cia") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cia->getErrorMessage() ?></div>
<?= $Grid->cia->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cia") ?>
<?php if (!$Grid->cia->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cia", selectId: "fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_cia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciagrid.lists.cia?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cia", form: "fsco_expediente_ciagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cia", form: "fsco_expediente_ciagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.cia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_cia" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cia" id="o<?= $Grid->RowIndex ?>_cia" value="<?= HtmlEncode($Grid->cia->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_cia" class="el_sco_expediente_cia_cia">
    <select
        id="x<?= $Grid->RowIndex ?>_cia"
        name="x<?= $Grid->RowIndex ?>_cia"
        class="form-select ew-select<?= $Grid->cia->isInvalidClass() ?>"
        <?php if (!$Grid->cia->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_cia"
        <?php } ?>
        data-table="sco_expediente_cia"
        data-field="x_cia"
        data-value-separator="<?= $Grid->cia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cia->getPlaceHolder()) ?>"
        <?= $Grid->cia->editAttributes() ?>>
        <?= $Grid->cia->selectOptionListHtml("x{$Grid->RowIndex}_cia") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cia->getErrorMessage() ?></div>
<?= $Grid->cia->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cia") ?>
<?php if (!$Grid->cia->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cia", selectId: "fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_cia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciagrid.lists.cia?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cia", form: "fsco_expediente_ciagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cia", form: "fsco_expediente_ciagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.cia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_cia" class="el_sco_expediente_cia_cia">
<span<?= $Grid->cia->viewAttributes() ?>>
<?= $Grid->cia->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_cia" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_cia" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_cia" value="<?= HtmlEncode($Grid->cia->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_cia" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_cia" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_cia" value="<?= HtmlEncode($Grid->cia->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->expediente->Visible) { // expediente ?>
        <td data-name="expediente"<?= $Grid->expediente->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->expediente->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_expediente" class="el_sco_expediente_cia_expediente">
<span<?= $Grid->expediente->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->expediente->getDisplayValue($Grid->expediente->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_expediente" name="x<?= $Grid->RowIndex ?>_expediente" value="<?= HtmlEncode($Grid->expediente->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_expediente" class="el_sco_expediente_cia_expediente">
<?php
if (IsRTL()) {
    $Grid->expediente->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_expediente" class="ew-auto-suggest">
    <input type="<?= $Grid->expediente->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_expediente" id="sv_x<?= $Grid->RowIndex ?>_expediente" value="<?= RemoveHtml($Grid->expediente->EditValue) ?>" autocomplete="off" size="10" placeholder="<?= HtmlEncode($Grid->expediente->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->expediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->expediente->formatPattern()) ?>"<?= $Grid->expediente->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_expediente_cia" data-field="x_expediente" data-input="sv_x<?= $Grid->RowIndex ?>_expediente" data-value-separator="<?= $Grid->expediente->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_expediente" id="x<?= $Grid->RowIndex ?>_expediente" value="<?= HtmlEncode($Grid->expediente->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->expediente->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    fsco_expediente_ciagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_expediente","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->expediente->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_expediente_cia.fields.expediente.autoSuggestOptions));
});
</script>
<?= $Grid->expediente->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_expediente") ?>
</span>
<?php } ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_expediente" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_expediente" id="o<?= $Grid->RowIndex ?>_expediente" value="<?= HtmlEncode($Grid->expediente->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_expediente" class="el_sco_expediente_cia_expediente">
<span<?= $Grid->expediente->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->expediente->getDisplayValue($Grid->expediente->EditValue) ?></span></span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_expediente" data-hidden="1" name="x<?= $Grid->RowIndex ?>_expediente" id="x<?= $Grid->RowIndex ?>_expediente" value="<?= HtmlEncode($Grid->expediente->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_expediente" class="el_sco_expediente_cia_expediente">
<span<?= $Grid->expediente->viewAttributes() ?>>
<?= $Grid->expediente->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_expediente" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_expediente" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_expediente" value="<?= HtmlEncode($Grid->expediente->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_expediente" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_expediente" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_expediente" value="<?= HtmlEncode($Grid->expediente->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->servicio_tipo->Visible) { // servicio_tipo ?>
        <td data-name="servicio_tipo"<?= $Grid->servicio_tipo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_servicio_tipo" class="el_sco_expediente_cia_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio_tipo"
        name="x<?= $Grid->RowIndex ?>_servicio_tipo"
        class="form-select ew-select<?= $Grid->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Grid->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_servicio_tipo"
        <?php } ?>
        data-table="sco_expediente_cia"
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
loadjs.ready("fsco_expediente_ciagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio_tipo", selectId: "fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciagrid.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_expediente_ciagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_expediente_ciagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_servicio_tipo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_servicio_tipo" id="o<?= $Grid->RowIndex ?>_servicio_tipo" value="<?= HtmlEncode($Grid->servicio_tipo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_servicio_tipo" class="el_sco_expediente_cia_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_servicio_tipo"
        name="x<?= $Grid->RowIndex ?>_servicio_tipo"
        class="form-select ew-select<?= $Grid->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Grid->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_servicio_tipo"
        <?php } ?>
        data-table="sco_expediente_cia"
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
loadjs.ready("fsco_expediente_ciagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_servicio_tipo", selectId: "fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciagrid.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_expediente_ciagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_servicio_tipo", form: "fsco_expediente_ciagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_servicio_tipo" class="el_sco_expediente_cia_servicio_tipo">
<span<?= $Grid->servicio_tipo->viewAttributes() ?>>
<?= $Grid->servicio_tipo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_servicio_tipo" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_servicio_tipo" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_servicio_tipo" value="<?= HtmlEncode($Grid->servicio_tipo->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_servicio_tipo" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_servicio_tipo" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_servicio_tipo" value="<?= HtmlEncode($Grid->servicio_tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->factura->Visible) { // factura ?>
        <td data-name="factura"<?= $Grid->factura->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_factura" class="el_sco_expediente_cia_factura">
<input type="<?= $Grid->factura->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_factura" id="x<?= $Grid->RowIndex ?>_factura" data-table="sco_expediente_cia" data-field="x_factura" value="<?= $Grid->factura->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->factura->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->factura->formatPattern()) ?>"<?= $Grid->factura->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->factura->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_factura" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_factura" id="o<?= $Grid->RowIndex ?>_factura" value="<?= HtmlEncode($Grid->factura->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_factura" class="el_sco_expediente_cia_factura">
<input type="<?= $Grid->factura->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_factura" id="x<?= $Grid->RowIndex ?>_factura" data-table="sco_expediente_cia" data-field="x_factura" value="<?= $Grid->factura->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->factura->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->factura->formatPattern()) ?>"<?= $Grid->factura->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->factura->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_factura" class="el_sco_expediente_cia_factura">
<span<?= $Grid->factura->viewAttributes() ?>>
<?= $Grid->factura->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_factura" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_factura" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_factura" value="<?= HtmlEncode($Grid->factura->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_factura" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_factura" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_factura" value="<?= HtmlEncode($Grid->factura->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_fecha" class="el_sco_expediente_cia_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_expediente_cia" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
<?php if (!$Grid->fecha->ReadOnly && !$Grid->fecha->Disabled && !isset($Grid->fecha->EditAttrs["readonly"]) && !isset($Grid->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_ciagrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_expediente_ciagrid", "x<?= $Grid->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_fecha" class="el_sco_expediente_cia_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_expediente_cia" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
<?php if (!$Grid->fecha->ReadOnly && !$Grid->fecha->Disabled && !isset($Grid->fecha->EditAttrs["readonly"]) && !isset($Grid->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_ciagrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_expediente_ciagrid", "x<?= $Grid->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_fecha" class="el_sco_expediente_cia_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_fecha" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_fecha" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_fecha" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_fecha" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->monto->Visible) { // monto ?>
        <td data-name="monto"<?= $Grid->monto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_monto" class="el_sco_expediente_cia_monto">
<input type="<?= $Grid->monto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto" id="x<?= $Grid->RowIndex ?>_monto" data-table="sco_expediente_cia" data-field="x_monto" value="<?= $Grid->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto->formatPattern()) ?>"<?= $Grid->monto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_monto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_monto" id="o<?= $Grid->RowIndex ?>_monto" value="<?= HtmlEncode($Grid->monto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_monto" class="el_sco_expediente_cia_monto">
<input type="<?= $Grid->monto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto" id="x<?= $Grid->RowIndex ?>_monto" data-table="sco_expediente_cia" data-field="x_monto" value="<?= $Grid->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto->formatPattern()) ?>"<?= $Grid->monto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_monto" class="el_sco_expediente_cia_monto">
<span<?= $Grid->monto->viewAttributes() ?>>
<?= $Grid->monto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_monto" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_monto" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_monto" value="<?= HtmlEncode($Grid->monto->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_monto" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_monto" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_monto" value="<?= HtmlEncode($Grid->monto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nota->Visible) { // nota ?>
        <td data-name="nota"<?= $Grid->nota->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_nota" class="el_sco_expediente_cia_nota">
<input type="<?= $Grid->nota->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nota" id="x<?= $Grid->RowIndex ?>_nota" data-table="sco_expediente_cia" data-field="x_nota" value="<?= $Grid->nota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nota->formatPattern()) ?>"<?= $Grid->nota->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nota->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_nota" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nota" id="o<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_nota" class="el_sco_expediente_cia_nota">
<input type="<?= $Grid->nota->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nota" id="x<?= $Grid->RowIndex ?>_nota" data-table="sco_expediente_cia" data-field="x_nota" value="<?= $Grid->nota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nota->formatPattern()) ?>"<?= $Grid->nota->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nota->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_nota" class="el_sco_expediente_cia_nota">
<span<?= $Grid->nota->viewAttributes() ?>>
<?= $Grid->nota->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_nota" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_nota" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_nota" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_nota" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username"<?= $Grid->_username->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia__username" class="el_sco_expediente_cia__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_expediente_cia" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    fsco_expediente_ciagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_expediente_cia.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x__username" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia__username" class="el_sco_expediente_cia__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_expediente_cia" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    fsco_expediente_ciagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_expediente_cia.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia__username" class="el_sco_expediente_cia__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x__username" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>__username" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x__username" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>__username" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Grid->estatus->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_estatus" class="el_sco_expediente_cia_estatus">
    <select
        id="x<?= $Grid->RowIndex ?>_estatus"
        name="x<?= $Grid->RowIndex ?>_estatus"
        class="form-select ew-select<?= $Grid->estatus->isInvalidClass() ?>"
        <?php if (!$Grid->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_estatus"
        <?php } ?>
        data-table="sco_expediente_cia"
        data-field="x_estatus"
        data-value-separator="<?= $Grid->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>"
        <?= $Grid->estatus->editAttributes() ?>>
        <?= $Grid->estatus->selectOptionListHtml("x{$Grid->RowIndex}_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<?php if (!$Grid->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_estatus", selectId: "fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciagrid.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_expediente_ciagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_expediente_ciagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_estatus" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_estatus" id="o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_estatus" class="el_sco_expediente_cia_estatus">
    <select
        id="x<?= $Grid->RowIndex ?>_estatus"
        name="x<?= $Grid->RowIndex ?>_estatus"
        class="form-select ew-select<?= $Grid->estatus->isInvalidClass() ?>"
        <?php if (!$Grid->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_estatus"
        <?php } ?>
        data-table="sco_expediente_cia"
        data-field="x_estatus"
        data-value-separator="<?= $Grid->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>"
        <?= $Grid->estatus->editAttributes() ?>>
        <?= $Grid->estatus->selectOptionListHtml("x{$Grid->RowIndex}_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<?php if (!$Grid->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_ciagrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_estatus", selectId: "fsco_expediente_ciagrid_x<?= $Grid->RowIndex ?>_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_ciagrid.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_expediente_ciagrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_expediente_ciagrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_cia.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_expediente_cia_estatus" class="el_sco_expediente_cia_estatus">
<span<?= $Grid->estatus->viewAttributes() ?>>
<?= $Grid->estatus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_expediente_cia" data-field="x_estatus" data-hidden="1" name="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_estatus" id="fsco_expediente_ciagrid$x<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->FormValue) ?>">
<input type="hidden" data-table="sco_expediente_cia" data-field="x_estatus" data-hidden="1" data-old name="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_estatus" id="fsco_expediente_ciagrid$o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
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
loadjs.ready(["fsco_expediente_ciagrid","load"], () => fsco_expediente_ciagrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_expediente_ciagrid">
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
    ew.addEventHandlers("sco_expediente_cia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
