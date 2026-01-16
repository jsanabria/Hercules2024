<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoGramaPagosGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_grama_pagosgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_grama_pagos: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_grama_pagosgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["banco", [fields.banco.visible && fields.banco.required ? ew.Validators.required(fields.banco.caption) : null], fields.banco.isInvalid],
            ["ref", [fields.ref.visible && fields.ref.required ? ew.Validators.required(fields.ref.caption) : null], fields.ref.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["monto", [fields.monto.visible && fields.monto.required ? ew.Validators.required(fields.monto.caption) : null, ew.Validators.float], fields.monto.isInvalid],
            ["moneda", [fields.moneda.visible && fields.moneda.required ? ew.Validators.required(fields.moneda.caption) : null], fields.moneda.isInvalid],
            ["tasa", [fields.tasa.visible && fields.tasa.required ? ew.Validators.required(fields.tasa.caption) : null, ew.Validators.float], fields.tasa.isInvalid],
            ["monto_bs", [fields.monto_bs.visible && fields.monto_bs.required ? ew.Validators.required(fields.monto_bs.caption) : null, ew.Validators.float], fields.monto_bs.isInvalid],
            ["cta_destino", [fields.cta_destino.visible && fields.cta_destino.required ? ew.Validators.required(fields.cta_destino.caption) : null], fields.cta_destino.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo",false],["banco",false],["ref",false],["fecha",false],["monto",false],["moneda",false],["tasa",false],["monto_bs",false],["cta_destino",false]];
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
            "moneda": <?= $Grid->moneda->toClientList($Grid) ?>,
            "cta_destino": <?= $Grid->cta_destino->toClientList($Grid) ?>,
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
<div id="fsco_grama_pagosgrid" class="ew-form ew-list-form">
<div id="gmp_sco_grama_pagos" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_grama_pagosgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="tipo" class="<?= $Grid->tipo->headerCellClass() ?>"><div id="elh_sco_grama_pagos_tipo" class="sco_grama_pagos_tipo"><?= $Grid->renderFieldHeader($Grid->tipo) ?></div></th>
<?php } ?>
<?php if ($Grid->banco->Visible) { // banco ?>
        <th data-name="banco" class="<?= $Grid->banco->headerCellClass() ?>"><div id="elh_sco_grama_pagos_banco" class="sco_grama_pagos_banco"><?= $Grid->renderFieldHeader($Grid->banco) ?></div></th>
<?php } ?>
<?php if ($Grid->ref->Visible) { // ref ?>
        <th data-name="ref" class="<?= $Grid->ref->headerCellClass() ?>"><div id="elh_sco_grama_pagos_ref" class="sco_grama_pagos_ref"><?= $Grid->renderFieldHeader($Grid->ref) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_sco_grama_pagos_fecha" class="sco_grama_pagos_fecha"><?= $Grid->renderFieldHeader($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->monto->Visible) { // monto ?>
        <th data-name="monto" class="<?= $Grid->monto->headerCellClass() ?>"><div id="elh_sco_grama_pagos_monto" class="sco_grama_pagos_monto"><?= $Grid->renderFieldHeader($Grid->monto) ?></div></th>
<?php } ?>
<?php if ($Grid->moneda->Visible) { // moneda ?>
        <th data-name="moneda" class="<?= $Grid->moneda->headerCellClass() ?>"><div id="elh_sco_grama_pagos_moneda" class="sco_grama_pagos_moneda"><?= $Grid->renderFieldHeader($Grid->moneda) ?></div></th>
<?php } ?>
<?php if ($Grid->tasa->Visible) { // tasa ?>
        <th data-name="tasa" class="<?= $Grid->tasa->headerCellClass() ?>"><div id="elh_sco_grama_pagos_tasa" class="sco_grama_pagos_tasa"><?= $Grid->renderFieldHeader($Grid->tasa) ?></div></th>
<?php } ?>
<?php if ($Grid->monto_bs->Visible) { // monto_bs ?>
        <th data-name="monto_bs" class="<?= $Grid->monto_bs->headerCellClass() ?>"><div id="elh_sco_grama_pagos_monto_bs" class="sco_grama_pagos_monto_bs"><?= $Grid->renderFieldHeader($Grid->monto_bs) ?></div></th>
<?php } ?>
<?php if ($Grid->cta_destino->Visible) { // cta_destino ?>
        <th data-name="cta_destino" class="<?= $Grid->cta_destino->headerCellClass() ?>"><div id="elh_sco_grama_pagos_cta_destino" class="sco_grama_pagos_cta_destino"><?= $Grid->renderFieldHeader($Grid->cta_destino) ?></div></th>
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
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_tipo" class="el_sco_grama_pagos_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_tipo"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?= $Grid->tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo") ?>
<?php if (!$Grid->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosgrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_grama_pagosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_grama_pagosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_tipo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo" id="o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_tipo" class="el_sco_grama_pagos_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_tipo"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?= $Grid->tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo") ?>
<?php if (!$Grid->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosgrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_grama_pagosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_grama_pagosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_tipo" class="el_sco_grama_pagos_tipo">
<span<?= $Grid->tipo->viewAttributes() ?>>
<?= $Grid->tipo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_tipo" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_tipo" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_tipo" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_tipo" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->banco->Visible) { // banco ?>
        <td data-name="banco"<?= $Grid->banco->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_banco" class="el_sco_grama_pagos_banco">
<input type="<?= $Grid->banco->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_banco" id="x<?= $Grid->RowIndex ?>_banco" data-table="sco_grama_pagos" data-field="x_banco" value="<?= $Grid->banco->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->banco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->banco->formatPattern()) ?>"<?= $Grid->banco->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->banco->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_banco" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_banco" id="o<?= $Grid->RowIndex ?>_banco" value="<?= HtmlEncode($Grid->banco->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_banco" class="el_sco_grama_pagos_banco">
<input type="<?= $Grid->banco->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_banco" id="x<?= $Grid->RowIndex ?>_banco" data-table="sco_grama_pagos" data-field="x_banco" value="<?= $Grid->banco->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->banco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->banco->formatPattern()) ?>"<?= $Grid->banco->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->banco->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_banco" class="el_sco_grama_pagos_banco">
<span<?= $Grid->banco->viewAttributes() ?>>
<?= $Grid->banco->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_banco" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_banco" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_banco" value="<?= HtmlEncode($Grid->banco->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_banco" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_banco" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_banco" value="<?= HtmlEncode($Grid->banco->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ref->Visible) { // ref ?>
        <td data-name="ref"<?= $Grid->ref->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_ref" class="el_sco_grama_pagos_ref">
<input type="<?= $Grid->ref->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ref" id="x<?= $Grid->RowIndex ?>_ref" data-table="sco_grama_pagos" data-field="x_ref" value="<?= $Grid->ref->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->ref->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ref->formatPattern()) ?>"<?= $Grid->ref->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ref->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_ref" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ref" id="o<?= $Grid->RowIndex ?>_ref" value="<?= HtmlEncode($Grid->ref->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_ref" class="el_sco_grama_pagos_ref">
<input type="<?= $Grid->ref->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ref" id="x<?= $Grid->RowIndex ?>_ref" data-table="sco_grama_pagos" data-field="x_ref" value="<?= $Grid->ref->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->ref->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->ref->formatPattern()) ?>"<?= $Grid->ref->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ref->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_ref" class="el_sco_grama_pagos_ref">
<span<?= $Grid->ref->viewAttributes() ?>>
<?= $Grid->ref->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_ref" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_ref" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_ref" value="<?= HtmlEncode($Grid->ref->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_ref" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_ref" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_ref" value="<?= HtmlEncode($Grid->ref->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_fecha" class="el_sco_grama_pagos_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_grama_pagos" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
<?php if (!$Grid->fecha->ReadOnly && !$Grid->fecha->Disabled && !isset($Grid->fecha->EditAttrs["readonly"]) && !isset($Grid->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_grama_pagosgrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fsco_grama_pagosgrid", "x<?= $Grid->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_fecha" class="el_sco_grama_pagos_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_grama_pagos" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
<?php if (!$Grid->fecha->ReadOnly && !$Grid->fecha->Disabled && !isset($Grid->fecha->EditAttrs["readonly"]) && !isset($Grid->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_grama_pagosgrid", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fsco_grama_pagosgrid", "x<?= $Grid->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_fecha" class="el_sco_grama_pagos_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_fecha" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_fecha" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_fecha" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_fecha" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->monto->Visible) { // monto ?>
        <td data-name="monto"<?= $Grid->monto->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_monto" class="el_sco_grama_pagos_monto">
<input type="<?= $Grid->monto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto" id="x<?= $Grid->RowIndex ?>_monto" data-table="sco_grama_pagos" data-field="x_monto" value="<?= $Grid->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto->formatPattern()) ?>"<?= $Grid->monto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_monto" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_monto" id="o<?= $Grid->RowIndex ?>_monto" value="<?= HtmlEncode($Grid->monto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_monto" class="el_sco_grama_pagos_monto">
<input type="<?= $Grid->monto->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto" id="x<?= $Grid->RowIndex ?>_monto" data-table="sco_grama_pagos" data-field="x_monto" value="<?= $Grid->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto->formatPattern()) ?>"<?= $Grid->monto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_monto" class="el_sco_grama_pagos_monto">
<span<?= $Grid->monto->viewAttributes() ?>>
<?= $Grid->monto->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_monto" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_monto" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_monto" value="<?= HtmlEncode($Grid->monto->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_monto" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_monto" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_monto" value="<?= HtmlEncode($Grid->monto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->moneda->Visible) { // moneda ?>
        <td data-name="moneda"<?= $Grid->moneda->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_moneda" class="el_sco_grama_pagos_moneda">
    <select
        id="x<?= $Grid->RowIndex ?>_moneda"
        name="x<?= $Grid->RowIndex ?>_moneda"
        class="form-select ew-select<?= $Grid->moneda->isInvalidClass() ?>"
        <?php if (!$Grid->moneda->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_moneda"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_moneda"
        data-value-separator="<?= $Grid->moneda->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->moneda->getPlaceHolder()) ?>"
        <?= $Grid->moneda->editAttributes() ?>>
        <?= $Grid->moneda->selectOptionListHtml("x{$Grid->RowIndex}_moneda") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->moneda->getErrorMessage() ?></div>
<?= $Grid->moneda->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_moneda") ?>
<?php if (!$Grid->moneda->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_moneda", selectId: "fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_moneda" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosgrid.lists.moneda?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_moneda", form: "fsco_grama_pagosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_moneda", form: "fsco_grama_pagosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.moneda.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_moneda" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_moneda" id="o<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_moneda" class="el_sco_grama_pagos_moneda">
    <select
        id="x<?= $Grid->RowIndex ?>_moneda"
        name="x<?= $Grid->RowIndex ?>_moneda"
        class="form-select ew-select<?= $Grid->moneda->isInvalidClass() ?>"
        <?php if (!$Grid->moneda->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_moneda"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_moneda"
        data-value-separator="<?= $Grid->moneda->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->moneda->getPlaceHolder()) ?>"
        <?= $Grid->moneda->editAttributes() ?>>
        <?= $Grid->moneda->selectOptionListHtml("x{$Grid->RowIndex}_moneda") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->moneda->getErrorMessage() ?></div>
<?= $Grid->moneda->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_moneda") ?>
<?php if (!$Grid->moneda->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_moneda", selectId: "fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_moneda" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosgrid.lists.moneda?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_moneda", form: "fsco_grama_pagosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_moneda", form: "fsco_grama_pagosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.moneda.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_moneda" class="el_sco_grama_pagos_moneda">
<span<?= $Grid->moneda->viewAttributes() ?>>
<?= $Grid->moneda->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_moneda" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_moneda" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_moneda" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_moneda" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_moneda" value="<?= HtmlEncode($Grid->moneda->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tasa->Visible) { // tasa ?>
        <td data-name="tasa"<?= $Grid->tasa->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_tasa" class="el_sco_grama_pagos_tasa">
<input type="<?= $Grid->tasa->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tasa" id="x<?= $Grid->RowIndex ?>_tasa" data-table="sco_grama_pagos" data-field="x_tasa" value="<?= $Grid->tasa->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tasa->formatPattern()) ?>"<?= $Grid->tasa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tasa->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_tasa" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tasa" id="o<?= $Grid->RowIndex ?>_tasa" value="<?= HtmlEncode($Grid->tasa->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_tasa" class="el_sco_grama_pagos_tasa">
<input type="<?= $Grid->tasa->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_tasa" id="x<?= $Grid->RowIndex ?>_tasa" data-table="sco_grama_pagos" data-field="x_tasa" value="<?= $Grid->tasa->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->tasa->formatPattern()) ?>"<?= $Grid->tasa->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tasa->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_tasa" class="el_sco_grama_pagos_tasa">
<span<?= $Grid->tasa->viewAttributes() ?>>
<?= $Grid->tasa->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_tasa" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_tasa" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_tasa" value="<?= HtmlEncode($Grid->tasa->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_tasa" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_tasa" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_tasa" value="<?= HtmlEncode($Grid->tasa->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->monto_bs->Visible) { // monto_bs ?>
        <td data-name="monto_bs"<?= $Grid->monto_bs->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_monto_bs" class="el_sco_grama_pagos_monto_bs">
<input type="<?= $Grid->monto_bs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto_bs" id="x<?= $Grid->RowIndex ?>_monto_bs" data-table="sco_grama_pagos" data-field="x_monto_bs" value="<?= $Grid->monto_bs->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto_bs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto_bs->formatPattern()) ?>"<?= $Grid->monto_bs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto_bs->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_monto_bs" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_monto_bs" id="o<?= $Grid->RowIndex ?>_monto_bs" value="<?= HtmlEncode($Grid->monto_bs->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_monto_bs" class="el_sco_grama_pagos_monto_bs">
<input type="<?= $Grid->monto_bs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto_bs" id="x<?= $Grid->RowIndex ?>_monto_bs" data-table="sco_grama_pagos" data-field="x_monto_bs" value="<?= $Grid->monto_bs->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto_bs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto_bs->formatPattern()) ?>"<?= $Grid->monto_bs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto_bs->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_monto_bs" class="el_sco_grama_pagos_monto_bs">
<span<?= $Grid->monto_bs->viewAttributes() ?>>
<?= $Grid->monto_bs->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_monto_bs" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_monto_bs" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_monto_bs" value="<?= HtmlEncode($Grid->monto_bs->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_monto_bs" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_monto_bs" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_monto_bs" value="<?= HtmlEncode($Grid->monto_bs->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cta_destino->Visible) { // cta_destino ?>
        <td data-name="cta_destino"<?= $Grid->cta_destino->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_cta_destino" class="el_sco_grama_pagos_cta_destino">
    <select
        id="x<?= $Grid->RowIndex ?>_cta_destino"
        name="x<?= $Grid->RowIndex ?>_cta_destino"
        class="form-select ew-select<?= $Grid->cta_destino->isInvalidClass() ?>"
        <?php if (!$Grid->cta_destino->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_cta_destino"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_cta_destino"
        data-value-separator="<?= $Grid->cta_destino->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cta_destino->getPlaceHolder()) ?>"
        <?= $Grid->cta_destino->editAttributes() ?>>
        <?= $Grid->cta_destino->selectOptionListHtml("x{$Grid->RowIndex}_cta_destino") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cta_destino->getErrorMessage() ?></div>
<?= $Grid->cta_destino->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cta_destino") ?>
<?php if (!$Grid->cta_destino->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cta_destino", selectId: "fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_cta_destino" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosgrid.lists.cta_destino?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cta_destino", form: "fsco_grama_pagosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cta_destino", form: "fsco_grama_pagosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.cta_destino.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_cta_destino" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cta_destino" id="o<?= $Grid->RowIndex ?>_cta_destino" value="<?= HtmlEncode($Grid->cta_destino->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_cta_destino" class="el_sco_grama_pagos_cta_destino">
    <select
        id="x<?= $Grid->RowIndex ?>_cta_destino"
        name="x<?= $Grid->RowIndex ?>_cta_destino"
        class="form-select ew-select<?= $Grid->cta_destino->isInvalidClass() ?>"
        <?php if (!$Grid->cta_destino->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_cta_destino"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_cta_destino"
        data-value-separator="<?= $Grid->cta_destino->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cta_destino->getPlaceHolder()) ?>"
        <?= $Grid->cta_destino->editAttributes() ?>>
        <?= $Grid->cta_destino->selectOptionListHtml("x{$Grid->RowIndex}_cta_destino") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cta_destino->getErrorMessage() ?></div>
<?= $Grid->cta_destino->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cta_destino") ?>
<?php if (!$Grid->cta_destino->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cta_destino", selectId: "fsco_grama_pagosgrid_x<?= $Grid->RowIndex ?>_cta_destino" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosgrid.lists.cta_destino?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cta_destino", form: "fsco_grama_pagosgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cta_destino", form: "fsco_grama_pagosgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.cta_destino.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_pagos_cta_destino" class="el_sco_grama_pagos_cta_destino">
<span<?= $Grid->cta_destino->viewAttributes() ?>>
<?= $Grid->cta_destino->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_pagos" data-field="x_cta_destino" data-hidden="1" name="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_cta_destino" id="fsco_grama_pagosgrid$x<?= $Grid->RowIndex ?>_cta_destino" value="<?= HtmlEncode($Grid->cta_destino->FormValue) ?>">
<input type="hidden" data-table="sco_grama_pagos" data-field="x_cta_destino" data-hidden="1" data-old name="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_cta_destino" id="fsco_grama_pagosgrid$o<?= $Grid->RowIndex ?>_cta_destino" value="<?= HtmlEncode($Grid->cta_destino->OldValue) ?>">
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
loadjs.ready(["fsco_grama_pagosgrid","load"], () => fsco_grama_pagosgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_grama_pagosgrid">
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
    ew.addEventHandlers("sco_grama_pagos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
