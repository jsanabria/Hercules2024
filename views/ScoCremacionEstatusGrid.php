<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoCremacionEstatusGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_cremacion_estatusgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_cremacion_estatus: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_cremacion_estatusgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["fecha_hora", [fields.fecha_hora.visible && fields.fecha_hora.required ? ew.Validators.required(fields.fecha_hora.caption) : null, ew.Validators.datetime(fields.fecha_hora.clientFormatPattern)], fields.fecha_hora.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["estatus",false],["fecha_hora",false],["_username",false]];
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
<div id="fsco_cremacion_estatusgrid" class="ew-form ew-list-form">
<div id="gmp_sco_cremacion_estatus" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_cremacion_estatusgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Grid->estatus->headerCellClass() ?>"><div id="elh_sco_cremacion_estatus_estatus" class="sco_cremacion_estatus_estatus"><?= $Grid->renderFieldHeader($Grid->estatus) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha_hora->Visible) { // fecha_hora ?>
        <th data-name="fecha_hora" class="<?= $Grid->fecha_hora->headerCellClass() ?>"><div id="elh_sco_cremacion_estatus_fecha_hora" class="sco_cremacion_estatus_fecha_hora"><?= $Grid->renderFieldHeader($Grid->fecha_hora) ?></div></th>
<?php } ?>
<?php if ($Grid->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Grid->_username->headerCellClass() ?>"><div id="elh_sco_cremacion_estatus__username" class="sco_cremacion_estatus__username"><?= $Grid->renderFieldHeader($Grid->_username) ?></div></th>
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
    <?php if ($Grid->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Grid->estatus->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus_estatus" class="el_sco_cremacion_estatus_estatus">
<input type="<?= $Grid->estatus->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_estatus" id="x<?= $Grid->RowIndex ?>_estatus" data-table="sco_cremacion_estatus" data-field="x_estatus" value="<?= $Grid->estatus->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->estatus->formatPattern()) ?>"<?= $Grid->estatus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_estatus" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_estatus" id="o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus_estatus" class="el_sco_cremacion_estatus_estatus">
<input type="<?= $Grid->estatus->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_estatus" id="x<?= $Grid->RowIndex ?>_estatus" data-table="sco_cremacion_estatus" data-field="x_estatus" value="<?= $Grid->estatus->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->estatus->formatPattern()) ?>"<?= $Grid->estatus->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_estatus" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_estatus" id="o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue ?? $Grid->estatus->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus_estatus" class="el_sco_cremacion_estatus_estatus">
<span<?= $Grid->estatus->viewAttributes() ?>>
<?= $Grid->estatus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_estatus" data-hidden="1" name="fsco_cremacion_estatusgrid$x<?= $Grid->RowIndex ?>_estatus" id="fsco_cremacion_estatusgrid$x<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->FormValue) ?>">
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_estatus" data-hidden="1" data-old name="fsco_cremacion_estatusgrid$o<?= $Grid->RowIndex ?>_estatus" id="fsco_cremacion_estatusgrid$o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sco_cremacion_estatus" data-field="x_estatus" data-hidden="1" name="x<?= $Grid->RowIndex ?>_estatus" id="x<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->fecha_hora->Visible) { // fecha_hora ?>
        <td data-name="fecha_hora"<?= $Grid->fecha_hora->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus_fecha_hora" class="el_sco_cremacion_estatus_fecha_hora">
<input type="<?= $Grid->fecha_hora->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_hora" id="x<?= $Grid->RowIndex ?>_fecha_hora" data-table="sco_cremacion_estatus" data-field="x_fecha_hora" value="<?= $Grid->fecha_hora->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_hora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_hora->formatPattern()) ?>"<?= $Grid->fecha_hora->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_hora->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_fecha_hora" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha_hora" id="o<?= $Grid->RowIndex ?>_fecha_hora" value="<?= HtmlEncode($Grid->fecha_hora->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus_fecha_hora" class="el_sco_cremacion_estatus_fecha_hora">
<input type="<?= $Grid->fecha_hora->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_hora" id="x<?= $Grid->RowIndex ?>_fecha_hora" data-table="sco_cremacion_estatus" data-field="x_fecha_hora" value="<?= $Grid->fecha_hora->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_hora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_hora->formatPattern()) ?>"<?= $Grid->fecha_hora->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_hora->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus_fecha_hora" class="el_sco_cremacion_estatus_fecha_hora">
<span<?= $Grid->fecha_hora->viewAttributes() ?>>
<?= $Grid->fecha_hora->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_fecha_hora" data-hidden="1" name="fsco_cremacion_estatusgrid$x<?= $Grid->RowIndex ?>_fecha_hora" id="fsco_cremacion_estatusgrid$x<?= $Grid->RowIndex ?>_fecha_hora" value="<?= HtmlEncode($Grid->fecha_hora->FormValue) ?>">
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x_fecha_hora" data-hidden="1" data-old name="fsco_cremacion_estatusgrid$o<?= $Grid->RowIndex ?>_fecha_hora" id="fsco_cremacion_estatusgrid$o<?= $Grid->RowIndex ?>_fecha_hora" value="<?= HtmlEncode($Grid->fecha_hora->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_username->Visible) { // username ?>
        <td data-name="_username"<?= $Grid->_username->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus__username" class="el_sco_cremacion_estatus__username">
<input type="<?= $Grid->_username->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" data-table="sco_cremacion_estatus" data-field="x__username" value="<?= $Grid->_username->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x__username" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__username" id="o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus__username" class="el_sco_cremacion_estatus__username">
<input type="<?= $Grid->_username->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__username" id="x<?= $Grid->RowIndex ?>__username" data-table="sco_cremacion_estatus" data-field="x__username" value="<?= $Grid->_username->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Grid->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->_username->formatPattern()) ?>"<?= $Grid->_username->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_username->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_cremacion_estatus__username" class="el_sco_cremacion_estatus__username">
<span<?= $Grid->_username->viewAttributes() ?>>
<?= $Grid->_username->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x__username" data-hidden="1" name="fsco_cremacion_estatusgrid$x<?= $Grid->RowIndex ?>__username" id="fsco_cremacion_estatusgrid$x<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->FormValue) ?>">
<input type="hidden" data-table="sco_cremacion_estatus" data-field="x__username" data-hidden="1" data-old name="fsco_cremacion_estatusgrid$o<?= $Grid->RowIndex ?>__username" id="fsco_cremacion_estatusgrid$o<?= $Grid->RowIndex ?>__username" value="<?= HtmlEncode($Grid->_username->OldValue) ?>">
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
loadjs.ready(["fsco_cremacion_estatusgrid","load"], () => fsco_cremacion_estatusgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_cremacion_estatusgrid">
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
    ew.addEventHandlers("sco_cremacion_estatus");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
