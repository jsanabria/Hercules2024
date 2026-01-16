<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoEntradaSalidaDetalleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_entrada_salida_detallegrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_entrada_salida_detalle: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_entrada_salida_detallegrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["articulo", [fields.articulo.visible && fields.articulo.required ? ew.Validators.required(fields.articulo.caption) : null], fields.articulo.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null, ew.Validators.integer], fields.cantidad.isInvalid],
            ["costo", [fields.costo.visible && fields.costo.required ? ew.Validators.required(fields.costo.caption) : null, ew.Validators.float], fields.costo.isInvalid],
            ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.float], fields.total.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["articulo",false],["cantidad",false],["costo",false],["total",false]];
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
            "articulo": <?= $Grid->articulo->toClientList($Grid) ?>,
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
<div id="fsco_entrada_salida_detallegrid" class="ew-form ew-list-form">
<div id="gmp_sco_entrada_salida_detalle" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_entrada_salida_detallegrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->articulo->Visible) { // articulo ?>
        <th data-name="articulo" class="<?= $Grid->articulo->headerCellClass() ?>"><div id="elh_sco_entrada_salida_detalle_articulo" class="sco_entrada_salida_detalle_articulo"><?= $Grid->renderFieldHeader($Grid->articulo) ?></div></th>
<?php } ?>
<?php if ($Grid->cantidad->Visible) { // cantidad ?>
        <th data-name="cantidad" class="<?= $Grid->cantidad->headerCellClass() ?>"><div id="elh_sco_entrada_salida_detalle_cantidad" class="sco_entrada_salida_detalle_cantidad"><?= $Grid->renderFieldHeader($Grid->cantidad) ?></div></th>
<?php } ?>
<?php if ($Grid->costo->Visible) { // costo ?>
        <th data-name="costo" class="<?= $Grid->costo->headerCellClass() ?>"><div id="elh_sco_entrada_salida_detalle_costo" class="sco_entrada_salida_detalle_costo"><?= $Grid->renderFieldHeader($Grid->costo) ?></div></th>
<?php } ?>
<?php if ($Grid->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Grid->total->headerCellClass() ?>"><div id="elh_sco_entrada_salida_detalle_total" class="sco_entrada_salida_detalle_total"><?= $Grid->renderFieldHeader($Grid->total) ?></div></th>
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
    <?php if ($Grid->articulo->Visible) { // articulo ?>
        <td data-name="articulo"<?= $Grid->articulo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_articulo" class="el_sco_entrada_salida_detalle_articulo">
    <select
        id="x<?= $Grid->RowIndex ?>_articulo"
        name="x<?= $Grid->RowIndex ?>_articulo"
        class="form-control ew-select<?= $Grid->articulo->isInvalidClass() ?>"
        data-select2-id="fsco_entrada_salida_detallegrid_x<?= $Grid->RowIndex ?>_articulo"
        data-table="sco_entrada_salida_detalle"
        data-field="x_articulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->articulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->articulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->articulo->getPlaceHolder()) ?>"
        <?= $Grid->articulo->editAttributes() ?>>
        <?= $Grid->articulo->selectOptionListHtml("x{$Grid->RowIndex}_articulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->articulo->getErrorMessage() ?></div>
<?= $Grid->articulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_articulo") ?>
<script>
loadjs.ready("fsco_entrada_salida_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_articulo", selectId: "fsco_entrada_salida_detallegrid_x<?= $Grid->RowIndex ?>_articulo" };
    if (fsco_entrada_salida_detallegrid.lists.articulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_articulo", form: "fsco_entrada_salida_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_articulo", form: "fsco_entrada_salida_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_entrada_salida_detalle.fields.articulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_articulo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_articulo" id="o<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_articulo" class="el_sco_entrada_salida_detalle_articulo">
    <select
        id="x<?= $Grid->RowIndex ?>_articulo"
        name="x<?= $Grid->RowIndex ?>_articulo"
        class="form-control ew-select<?= $Grid->articulo->isInvalidClass() ?>"
        data-select2-id="fsco_entrada_salida_detallegrid_x<?= $Grid->RowIndex ?>_articulo"
        data-table="sco_entrada_salida_detalle"
        data-field="x_articulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->articulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->articulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->articulo->getPlaceHolder()) ?>"
        <?= $Grid->articulo->editAttributes() ?>>
        <?= $Grid->articulo->selectOptionListHtml("x{$Grid->RowIndex}_articulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->articulo->getErrorMessage() ?></div>
<?= $Grid->articulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_articulo") ?>
<script>
loadjs.ready("fsco_entrada_salida_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_articulo", selectId: "fsco_entrada_salida_detallegrid_x<?= $Grid->RowIndex ?>_articulo" };
    if (fsco_entrada_salida_detallegrid.lists.articulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_articulo", form: "fsco_entrada_salida_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_articulo", form: "fsco_entrada_salida_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_entrada_salida_detalle.fields.articulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_articulo" class="el_sco_entrada_salida_detalle_articulo">
<span<?= $Grid->articulo->viewAttributes() ?>>
<?= $Grid->articulo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_articulo" data-hidden="1" name="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_articulo" id="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->FormValue) ?>">
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_articulo" data-hidden="1" data-old name="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_articulo" id="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cantidad->Visible) { // cantidad ?>
        <td data-name="cantidad"<?= $Grid->cantidad->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_cantidad" class="el_sco_entrada_salida_detalle_cantidad">
<input type="<?= $Grid->cantidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad" id="x<?= $Grid->RowIndex ?>_cantidad" data-table="sco_entrada_salida_detalle" data-field="x_cantidad" value="<?= $Grid->cantidad->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad->formatPattern()) ?>"<?= $Grid->cantidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_cantidad" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cantidad" id="o<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_cantidad" class="el_sco_entrada_salida_detalle_cantidad">
<input type="<?= $Grid->cantidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad" id="x<?= $Grid->RowIndex ?>_cantidad" data-table="sco_entrada_salida_detalle" data-field="x_cantidad" value="<?= $Grid->cantidad->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad->formatPattern()) ?>"<?= $Grid->cantidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_cantidad" class="el_sco_entrada_salida_detalle_cantidad">
<span<?= $Grid->cantidad->viewAttributes() ?>>
<?= $Grid->cantidad->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_cantidad" data-hidden="1" name="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_cantidad" id="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->FormValue) ?>">
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_cantidad" data-hidden="1" data-old name="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_cantidad" id="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->costo->Visible) { // costo ?>
        <td data-name="costo"<?= $Grid->costo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_costo" class="el_sco_entrada_salida_detalle_costo">
<input type="<?= $Grid->costo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_costo" id="x<?= $Grid->RowIndex ?>_costo" data-table="sco_entrada_salida_detalle" data-field="x_costo" value="<?= $Grid->costo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->costo->formatPattern()) ?>"<?= $Grid->costo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->costo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_costo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_costo" id="o<?= $Grid->RowIndex ?>_costo" value="<?= HtmlEncode($Grid->costo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_costo" class="el_sco_entrada_salida_detalle_costo">
<input type="<?= $Grid->costo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_costo" id="x<?= $Grid->RowIndex ?>_costo" data-table="sco_entrada_salida_detalle" data-field="x_costo" value="<?= $Grid->costo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->costo->formatPattern()) ?>"<?= $Grid->costo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->costo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_costo" class="el_sco_entrada_salida_detalle_costo">
<span<?= $Grid->costo->viewAttributes() ?>>
<?= $Grid->costo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_costo" data-hidden="1" name="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_costo" id="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_costo" value="<?= HtmlEncode($Grid->costo->FormValue) ?>">
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_costo" data-hidden="1" data-old name="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_costo" id="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_costo" value="<?= HtmlEncode($Grid->costo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->total->Visible) { // total ?>
        <td data-name="total"<?= $Grid->total->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_total" class="el_sco_entrada_salida_detalle_total">
<input type="<?= $Grid->total->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" data-table="sco_entrada_salida_detalle" data-field="x_total" value="<?= $Grid->total->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->total->formatPattern()) ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_total" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_total" id="o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_total" class="el_sco_entrada_salida_detalle_total">
<input type="<?= $Grid->total->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_total" id="x<?= $Grid->RowIndex ?>_total" data-table="sco_entrada_salida_detalle" data-field="x_total" value="<?= $Grid->total->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Grid->total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->total->formatPattern()) ?>"<?= $Grid->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->total->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_entrada_salida_detalle_total" class="el_sco_entrada_salida_detalle_total">
<span<?= $Grid->total->viewAttributes() ?>>
<?= $Grid->total->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_total" data-hidden="1" name="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_total" id="fsco_entrada_salida_detallegrid$x<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->FormValue) ?>">
<input type="hidden" data-table="sco_entrada_salida_detalle" data-field="x_total" data-hidden="1" data-old name="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_total" id="fsco_entrada_salida_detallegrid$o<?= $Grid->RowIndex ?>_total" value="<?= HtmlEncode($Grid->total->OldValue) ?>">
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
loadjs.ready(["fsco_entrada_salida_detallegrid","load"], () => fsco_entrada_salida_detallegrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_entrada_salida_detallegrid">
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
    ew.addEventHandlers("sco_entrada_salida_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
