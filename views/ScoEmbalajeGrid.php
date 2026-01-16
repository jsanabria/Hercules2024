<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoEmbalajeGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_embalajegrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_embalaje: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_embalajegrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["precinto1", [fields.precinto1.visible && fields.precinto1.required ? ew.Validators.required(fields.precinto1.caption) : null], fields.precinto1.isInvalid],
            ["precinto2", [fields.precinto2.visible && fields.precinto2.required ? ew.Validators.required(fields.precinto2.caption) : null], fields.precinto2.isInvalid],
            ["fecha_servicio", [fields.fecha_servicio.visible && fields.fecha_servicio.required ? ew.Validators.required(fields.fecha_servicio.caption) : null, ew.Validators.datetime(fields.fecha_servicio.clientFormatPattern)], fields.fecha_servicio.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["anulado", [fields.anulado.visible && fields.anulado.required ? ew.Validators.required(fields.anulado.caption) : null], fields.anulado.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["fecha",false],["precinto1",false],["precinto2",false],["fecha_servicio",false],["_username",false],["anulado",false]];
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
            "anulado": <?= $Grid->anulado->toClientList($Grid) ?>,
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
<div id="fsco_embalajegrid" class="ew-form ew-list-form">
<div id="gmp_sco_embalaje" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_embalajegrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_sco_embalaje_fecha" class="sco_embalaje_fecha"><?= $Grid->renderFieldHeader($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->precinto1->Visible) { // precinto1 ?>
        <th data-name="precinto1" class="<?= $Grid->precinto1->headerCellClass() ?>"><div id="elh_sco_embalaje_precinto1" class="sco_embalaje_precinto1"><?= $Grid->renderFieldHeader($Grid->precinto1) ?></div></th>
<?php } ?>
<?php if ($Grid->precinto2->Visible) { // precinto2 ?>
        <th data-name="precinto2" class="<?= $Grid->precinto2->headerCellClass() ?>"><div id="elh_sco_embalaje_precinto2" class="sco_embalaje_precinto2"><?= $Grid->renderFieldHeader($Grid->precinto2) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha_servicio->Visible) { // fecha_servicio ?>
        <th data-name="fecha_servicio" class="<?= $Grid->fecha_servicio->headerCellClass() ?>"><div id="elh_sco_embalaje_fecha_servicio" class="sco_embalaje_fecha_servicio"><?= $Grid->renderFieldHeader($Grid->fecha_servicio) ?></div></th>
<?php } ?>
<?php if ($Grid->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_sco_embalaje__username" class="sco_embalaje__username"><?= $Grid->renderFieldHeader($Grid->_username) ?></div></th>
<?php } ?>
<?php if ($Grid->anulado->Visible) { // anulado ?>
        <th data-name="anulado" class="<?= $Grid->anulado->headerCellClass() ?>"><div id="elh_sco_embalaje_anulado" class="sco_embalaje_anulado"><?= $Grid->renderFieldHeader($Grid->anulado) ?></div></th>
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
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_fecha" class="el_sco_embalaje_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_embalaje" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_embalaje" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_fecha" class="el_sco_embalaje_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_embalaje" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_fecha" class="el_sco_embalaje_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_embalaje" data-field="x_fecha" data-hidden="1" name="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_fecha" id="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="sco_embalaje" data-field="x_fecha" data-hidden="1" data-old name="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_fecha" id="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->precinto1->Visible) { // precinto1 ?>
        <td data-name="precinto1"<?= $Grid->precinto1->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_precinto1" class="el_sco_embalaje_precinto1">
<input type="<?= $Grid->precinto1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_precinto1" id="x<?= $Grid->RowIndex ?>_precinto1" data-table="sco_embalaje" data-field="x_precinto1" value="<?= $Grid->precinto1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->precinto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->precinto1->formatPattern()) ?>"<?= $Grid->precinto1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->precinto1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_embalaje" data-field="x_precinto1" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_precinto1" id="o<?= $Grid->RowIndex ?>_precinto1" value="<?= HtmlEncode($Grid->precinto1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_precinto1" class="el_sco_embalaje_precinto1">
<input type="<?= $Grid->precinto1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_precinto1" id="x<?= $Grid->RowIndex ?>_precinto1" data-table="sco_embalaje" data-field="x_precinto1" value="<?= $Grid->precinto1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->precinto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->precinto1->formatPattern()) ?>"<?= $Grid->precinto1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->precinto1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_precinto1" class="el_sco_embalaje_precinto1">
<span<?= $Grid->precinto1->viewAttributes() ?>>
<?= $Grid->precinto1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_embalaje" data-field="x_precinto1" data-hidden="1" name="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_precinto1" id="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_precinto1" value="<?= HtmlEncode($Grid->precinto1->FormValue) ?>">
<input type="hidden" data-table="sco_embalaje" data-field="x_precinto1" data-hidden="1" data-old name="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_precinto1" id="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_precinto1" value="<?= HtmlEncode($Grid->precinto1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->precinto2->Visible) { // precinto2 ?>
        <td data-name="precinto2"<?= $Grid->precinto2->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_precinto2" class="el_sco_embalaje_precinto2">
<input type="<?= $Grid->precinto2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_precinto2" id="x<?= $Grid->RowIndex ?>_precinto2" data-table="sco_embalaje" data-field="x_precinto2" value="<?= $Grid->precinto2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->precinto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->precinto2->formatPattern()) ?>"<?= $Grid->precinto2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->precinto2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_embalaje" data-field="x_precinto2" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_precinto2" id="o<?= $Grid->RowIndex ?>_precinto2" value="<?= HtmlEncode($Grid->precinto2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_precinto2" class="el_sco_embalaje_precinto2">
<input type="<?= $Grid->precinto2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_precinto2" id="x<?= $Grid->RowIndex ?>_precinto2" data-table="sco_embalaje" data-field="x_precinto2" value="<?= $Grid->precinto2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->precinto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->precinto2->formatPattern()) ?>"<?= $Grid->precinto2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->precinto2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_precinto2" class="el_sco_embalaje_precinto2">
<span<?= $Grid->precinto2->viewAttributes() ?>>
<?= $Grid->precinto2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_embalaje" data-field="x_precinto2" data-hidden="1" name="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_precinto2" id="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_precinto2" value="<?= HtmlEncode($Grid->precinto2->FormValue) ?>">
<input type="hidden" data-table="sco_embalaje" data-field="x_precinto2" data-hidden="1" data-old name="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_precinto2" id="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_precinto2" value="<?= HtmlEncode($Grid->precinto2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha_servicio->Visible) { // fecha_servicio ?>
        <td data-name="fecha_servicio"<?= $Grid->fecha_servicio->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_fecha_servicio" class="el_sco_embalaje_fecha_servicio">
<input type="<?= $Grid->fecha_servicio->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_servicio" id="x<?= $Grid->RowIndex ?>_fecha_servicio" data-table="sco_embalaje" data-field="x_fecha_servicio" value="<?= $Grid->fecha_servicio->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_servicio->formatPattern()) ?>"<?= $Grid->fecha_servicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_servicio->getErrorMessage() ?></div>
<?php if (!$Grid->fecha_servicio->ReadOnly && !$Grid->fecha_servicio->Disabled && !isset($Grid->fecha_servicio->EditAttrs["readonly"]) && !isset($Grid->fecha_servicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_embalajegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_embalajegrid", "x<?= $Grid->RowIndex ?>_fecha_servicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_embalaje" data-field="x_fecha_servicio" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha_servicio" id="o<?= $Grid->RowIndex ?>_fecha_servicio" value="<?= HtmlEncode($Grid->fecha_servicio->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_fecha_servicio" class="el_sco_embalaje_fecha_servicio">
<input type="<?= $Grid->fecha_servicio->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_servicio" id="x<?= $Grid->RowIndex ?>_fecha_servicio" data-table="sco_embalaje" data-field="x_fecha_servicio" value="<?= $Grid->fecha_servicio->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_servicio->formatPattern()) ?>"<?= $Grid->fecha_servicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_servicio->getErrorMessage() ?></div>
<?php if (!$Grid->fecha_servicio->ReadOnly && !$Grid->fecha_servicio->Disabled && !isset($Grid->fecha_servicio->EditAttrs["readonly"]) && !isset($Grid->fecha_servicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_embalajegrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_embalajegrid", "x<?= $Grid->RowIndex ?>_fecha_servicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_fecha_servicio" class="el_sco_embalaje_fecha_servicio">
<span<?= $Grid->fecha_servicio->viewAttributes() ?>>
<?= $Grid->fecha_servicio->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_embalaje" data-field="x_fecha_servicio" data-hidden="1" name="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_fecha_servicio" id="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_fecha_servicio" value="<?= HtmlEncode($Grid->fecha_servicio->FormValue) ?>">
<input type="hidden" data-table="sco_embalaje" data-field="x_fecha_servicio" data-hidden="1" data-old name="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_fecha_servicio" id="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_fecha_servicio" value="<?= HtmlEncode($Grid->fecha_servicio->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username"<?= $Grid->_username->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje__username" class="el_sco_embalaje__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_embalaje" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_embalajegrid", function() {
    fsco_embalajegrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_embalaje.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<input type="hidden" data-table="sco_embalaje" data-field="x__username" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje__username" class="el_sco_embalaje__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_embalaje" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_embalajegrid", function() {
    fsco_embalajegrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_embalaje.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje__username" class="el_sco_embalaje__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_embalaje" data-field="x__username" data-hidden="1" name="fsco_embalajegrid$x<?= $Grid->RowIndex ?>__username" id="fsco_embalajegrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="sco_embalaje" data-field="x__username" data-hidden="1" data-old name="fsco_embalajegrid$o<?= $Grid->RowIndex ?>__username" id="fsco_embalajegrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->anulado->Visible) { // anulado ?>
        <td data-name="anulado"<?= $Grid->anulado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_anulado" class="el_sco_embalaje_anulado">
    <select
        id="x<?= $Grid->RowIndex ?>_anulado"
        name="x<?= $Grid->RowIndex ?>_anulado"
        class="form-select ew-select<?= $Grid->anulado->isInvalidClass() ?>"
        <?php if (!$Grid->anulado->IsNativeSelect) { ?>
        data-select2-id="fsco_embalajegrid_x<?= $Grid->RowIndex ?>_anulado"
        <?php } ?>
        data-table="sco_embalaje"
        data-field="x_anulado"
        data-value-separator="<?= $Grid->anulado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->anulado->getPlaceHolder()) ?>"
        <?= $Grid->anulado->editAttributes() ?>>
        <?= $Grid->anulado->selectOptionListHtml("x{$Grid->RowIndex}_anulado") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->anulado->getErrorMessage() ?></div>
<?php if (!$Grid->anulado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_embalajegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_anulado", selectId: "fsco_embalajegrid_x<?= $Grid->RowIndex ?>_anulado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_embalajegrid.lists.anulado?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_anulado", form: "fsco_embalajegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_anulado", form: "fsco_embalajegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_embalaje.fields.anulado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_embalaje" data-field="x_anulado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_anulado" id="o<?= $Grid->RowIndex ?>_anulado" value="<?= HtmlEncode($Grid->anulado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_anulado" class="el_sco_embalaje_anulado">
    <select
        id="x<?= $Grid->RowIndex ?>_anulado"
        name="x<?= $Grid->RowIndex ?>_anulado"
        class="form-select ew-select<?= $Grid->anulado->isInvalidClass() ?>"
        <?php if (!$Grid->anulado->IsNativeSelect) { ?>
        data-select2-id="fsco_embalajegrid_x<?= $Grid->RowIndex ?>_anulado"
        <?php } ?>
        data-table="sco_embalaje"
        data-field="x_anulado"
        data-value-separator="<?= $Grid->anulado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->anulado->getPlaceHolder()) ?>"
        <?= $Grid->anulado->editAttributes() ?>>
        <?= $Grid->anulado->selectOptionListHtml("x{$Grid->RowIndex}_anulado") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->anulado->getErrorMessage() ?></div>
<?php if (!$Grid->anulado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_embalajegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_anulado", selectId: "fsco_embalajegrid_x<?= $Grid->RowIndex ?>_anulado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_embalajegrid.lists.anulado?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_anulado", form: "fsco_embalajegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_anulado", form: "fsco_embalajegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_embalaje.fields.anulado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_embalaje_anulado" class="el_sco_embalaje_anulado">
<span<?= $Grid->anulado->viewAttributes() ?>>
<?= $Grid->anulado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_embalaje" data-field="x_anulado" data-hidden="1" name="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_anulado" id="fsco_embalajegrid$x<?= $Grid->RowIndex ?>_anulado" value="<?= HtmlEncode($Grid->anulado->FormValue) ?>">
<input type="hidden" data-table="sco_embalaje" data-field="x_anulado" data-hidden="1" data-old name="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_anulado" id="fsco_embalajegrid$o<?= $Grid->RowIndex ?>_anulado" value="<?= HtmlEncode($Grid->anulado->OldValue) ?>">
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
loadjs.ready(["fsco_embalajegrid","load"], () => fsco_embalajegrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_embalajegrid">
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
    ew.addEventHandlers("sco_embalaje");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
