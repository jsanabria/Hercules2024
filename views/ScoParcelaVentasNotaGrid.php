<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoParcelaVentasNotaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_parcela_ventas_notagrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_parcela_ventas_nota: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcela_ventas_notagrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["fecha_hora", [fields.fecha_hora.visible && fields.fecha_hora.required ? ew.Validators.required(fields.fecha_hora.caption) : null, ew.Validators.datetime(fields.fecha_hora.clientFormatPattern)], fields.fecha_hora.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["nota",false],["_username",false],["fecha_hora",false]];
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
<div id="fsco_parcela_ventas_notagrid" class="ew-form ew-list-form">
<div id="gmp_sco_parcela_ventas_nota" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_parcela_ventas_notagrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->nota->Visible) { // nota ?>
        <th data-name="nota" class="<?= $Grid->nota->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_nota_nota" class="sco_parcela_ventas_nota_nota"><?= $Grid->renderFieldHeader($Grid->nota) ?></div></th>
<?php } ?>
<?php if ($Grid->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_nota__username" class="sco_parcela_ventas_nota__username"><?= $Grid->renderFieldHeader($Grid->_username) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha_hora->Visible) { // fecha_hora ?>
        <th data-name="fecha_hora" class="<?= $Grid->fecha_hora->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_nota_fecha_hora" class="sco_parcela_ventas_nota_fecha_hora"><?= $Grid->renderFieldHeader($Grid->fecha_hora) ?></div></th>
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
    <?php if ($Grid->nota->Visible) { // nota ?>
        <td data-name="nota"<?= $Grid->nota->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota_nota" class="el_sco_parcela_ventas_nota_nota">
<textarea data-table="sco_parcela_ventas_nota" data-field="x_nota" name="x<?= $Grid->RowIndex ?>_nota" id="x<?= $Grid->RowIndex ?>_nota" cols="35" rows="3" placeholder="<?= HtmlEncode($Grid->nota->getPlaceHolder()) ?>"<?= $Grid->nota->editAttributes() ?>><?= $Grid->nota->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->nota->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x_nota" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nota" id="o<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota_nota" class="el_sco_parcela_ventas_nota_nota">
<textarea data-table="sco_parcela_ventas_nota" data-field="x_nota" name="x<?= $Grid->RowIndex ?>_nota" id="x<?= $Grid->RowIndex ?>_nota" cols="35" rows="3" placeholder="<?= HtmlEncode($Grid->nota->getPlaceHolder()) ?>"<?= $Grid->nota->editAttributes() ?>><?= $Grid->nota->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->nota->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota_nota" class="el_sco_parcela_ventas_nota_nota">
<span<?= $Grid->nota->viewAttributes() ?>>
<?= $Grid->nota->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x_nota" data-hidden="1" name="fsco_parcela_ventas_notagrid$x<?= $Grid->RowIndex ?>_nota" id="fsco_parcela_ventas_notagrid$x<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->FormValue) ?>">
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x_nota" data-hidden="1" data-old name="fsco_parcela_ventas_notagrid$o<?= $Grid->RowIndex ?>_nota" id="fsco_parcela_ventas_notagrid$o<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username"<?= $Grid->_username->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota__username" class="el_sco_parcela_ventas_nota__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_parcela_ventas_nota" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_parcela_ventas_notagrid", function() {
    fsco_parcela_ventas_notagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_parcela_ventas_nota.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x__username" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota__username" class="el_sco_parcela_ventas_nota__username">
<?php
if (IsRTL()) {
    $Grid->_username->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>__username" class="ew-auto-suggest">
    <input type="<?= $Grid->_username->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>__username" id="sv_x<?= $Grid->RowIndex ?>__username" value="<?= RemoveHtml($Grid->_username->EditValue) ?>" autocomplete="off" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_parcela_ventas_nota" data-field="x__username" data-input="sv_x<?= $Grid->RowIndex ?>__username" data-value-separator="<?= $Grid->_username->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_parcela_ventas_notagrid", function() {
    fsco_parcela_ventas_notagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>__username","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->_username->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_parcela_ventas_nota.fields._username.autoSuggestOptions));
});
</script>
<?= $Grid->_username->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__username") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota__username" class="el_sco_parcela_ventas_nota__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x__username" data-hidden="1" name="fsco_parcela_ventas_notagrid$x<?= $Grid->RowIndex ?>__username" id="fsco_parcela_ventas_notagrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x__username" data-hidden="1" data-old name="fsco_parcela_ventas_notagrid$o<?= $Grid->RowIndex ?>__username" id="fsco_parcela_ventas_notagrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha_hora->Visible) { // fecha_hora ?>
        <td data-name="fecha_hora"<?= $Grid->fecha_hora->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota_fecha_hora" class="el_sco_parcela_ventas_nota_fecha_hora">
<input type="<?= $Grid->fecha_hora->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_hora" id="x<?= $Grid->RowIndex ?>_fecha_hora" data-table="sco_parcela_ventas_nota" data-field="x_fecha_hora" value="<?= $Grid->fecha_hora->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_hora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_hora->formatPattern()) ?>"<?= $Grid->fecha_hora->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_hora->getErrorMessage() ?></div>
<?php if (!$Grid->fecha_hora->ReadOnly && !$Grid->fecha_hora->Disabled && !isset($Grid->fecha_hora->EditAttrs["readonly"]) && !isset($Grid->fecha_hora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_parcela_ventas_notagrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_parcela_ventas_notagrid", "x<?= $Grid->RowIndex ?>_fecha_hora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x_fecha_hora" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha_hora" id="o<?= $Grid->RowIndex ?>_fecha_hora" value="<?= HtmlEncode($Grid->fecha_hora->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota_fecha_hora" class="el_sco_parcela_ventas_nota_fecha_hora">
<input type="<?= $Grid->fecha_hora->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_hora" id="x<?= $Grid->RowIndex ?>_fecha_hora" data-table="sco_parcela_ventas_nota" data-field="x_fecha_hora" value="<?= $Grid->fecha_hora->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_hora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_hora->formatPattern()) ?>"<?= $Grid->fecha_hora->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_hora->getErrorMessage() ?></div>
<?php if (!$Grid->fecha_hora->ReadOnly && !$Grid->fecha_hora->Disabled && !isset($Grid->fecha_hora->EditAttrs["readonly"]) && !isset($Grid->fecha_hora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_parcela_ventas_notagrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_parcela_ventas_notagrid", "x<?= $Grid->RowIndex ?>_fecha_hora", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_ventas_nota_fecha_hora" class="el_sco_parcela_ventas_nota_fecha_hora">
<span<?= $Grid->fecha_hora->viewAttributes() ?>>
<?= $Grid->fecha_hora->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x_fecha_hora" data-hidden="1" name="fsco_parcela_ventas_notagrid$x<?= $Grid->RowIndex ?>_fecha_hora" id="fsco_parcela_ventas_notagrid$x<?= $Grid->RowIndex ?>_fecha_hora" value="<?= HtmlEncode($Grid->fecha_hora->FormValue) ?>">
<input type="hidden" data-table="sco_parcela_ventas_nota" data-field="x_fecha_hora" data-hidden="1" data-old name="fsco_parcela_ventas_notagrid$o<?= $Grid->RowIndex ?>_fecha_hora" id="fsco_parcela_ventas_notagrid$o<?= $Grid->RowIndex ?>_fecha_hora" value="<?= HtmlEncode($Grid->fecha_hora->OldValue) ?>">
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
loadjs.ready(["fsco_parcela_ventas_notagrid","load"], () => fsco_parcela_ventas_notagrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_parcela_ventas_notagrid">
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
    ew.addEventHandlers("sco_parcela_ventas_nota");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
