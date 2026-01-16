<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoServicioGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_serviciogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_servicio: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_serviciogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["Nservicio", [fields.Nservicio.visible && fields.Nservicio.required ? ew.Validators.required(fields.Nservicio.caption) : null], fields.Nservicio.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo",false],["Nservicio",false],["nombre",false],["activo",false]];
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
            "activo": <?= $Grid->activo->toClientList($Grid) ?>,
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
<div id="fsco_serviciogrid" class="ew-form ew-list-form">
<div id="gmp_sco_servicio" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_serviciogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="tipo" class="<?= $Grid->tipo->headerCellClass() ?>"><div id="elh_sco_servicio_tipo" class="sco_servicio_tipo"><?= $Grid->renderFieldHeader($Grid->tipo) ?></div></th>
<?php } ?>
<?php if ($Grid->Nservicio->Visible) { // Nservicio ?>
        <th data-name="Nservicio" class="<?= $Grid->Nservicio->headerCellClass() ?>"><div id="elh_sco_servicio_Nservicio" class="sco_servicio_Nservicio"><?= $Grid->renderFieldHeader($Grid->Nservicio) ?></div></th>
<?php } ?>
<?php if ($Grid->nombre->Visible) { // nombre ?>
        <th data-name="nombre" class="<?= $Grid->nombre->headerCellClass() ?>"><div id="elh_sco_servicio_nombre" class="sco_servicio_nombre"><?= $Grid->renderFieldHeader($Grid->nombre) ?></div></th>
<?php } ?>
<?php if ($Grid->activo->Visible) { // activo ?>
        <th data-name="activo" class="<?= $Grid->activo->headerCellClass() ?>"><div id="elh_sco_servicio_activo" class="sco_servicio_activo"><?= $Grid->renderFieldHeader($Grid->activo) ?></div></th>
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
<?php if ($Grid->tipo->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_tipo" class="el_sco_servicio_tipo">
<span<?= $Grid->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->tipo->getDisplayValue($Grid->tipo->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_tipo" name="x<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_tipo" class="el_sco_servicio_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-control ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        data-select2-id="fsco_serviciogrid_x<?= $Grid->RowIndex ?>_tipo"
        data-table="sco_servicio"
        data-field="x_tipo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->tipo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?= $Grid->tipo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo") ?>
<script>
loadjs.ready("fsco_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_serviciogrid_x<?= $Grid->RowIndex ?>_tipo" };
    if (fsco_serviciogrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_servicio.fields.tipo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="sco_servicio" data-field="x_tipo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo" id="o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_tipo" class="el_sco_servicio_tipo">
<span<?= $Grid->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->tipo->getDisplayValue($Grid->tipo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_servicio" data-field="x_tipo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tipo" id="x<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_tipo" class="el_sco_servicio_tipo">
<span<?= $Grid->tipo->viewAttributes() ?>>
<?= $Grid->tipo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_servicio" data-field="x_tipo" data-hidden="1" name="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_tipo" id="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->FormValue) ?>">
<input type="hidden" data-table="sco_servicio" data-field="x_tipo" data-hidden="1" data-old name="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_tipo" id="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Nservicio->Visible) { // Nservicio ?>
        <td data-name="Nservicio"<?= $Grid->Nservicio->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_Nservicio" class="el_sco_servicio_Nservicio">
<input type="<?= $Grid->Nservicio->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nservicio" id="x<?= $Grid->RowIndex ?>_Nservicio" data-table="sco_servicio" data-field="x_Nservicio" value="<?= $Grid->Nservicio->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->Nservicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nservicio->formatPattern()) ?>"<?= $Grid->Nservicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nservicio->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_servicio" data-field="x_Nservicio" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nservicio" id="o<?= $Grid->RowIndex ?>_Nservicio" value="<?= HtmlEncode($Grid->Nservicio->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_Nservicio" class="el_sco_servicio_Nservicio">
<span<?= $Grid->Nservicio->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Nservicio->getDisplayValue($Grid->Nservicio->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_servicio" data-field="x_Nservicio" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Nservicio" id="x<?= $Grid->RowIndex ?>_Nservicio" value="<?= HtmlEncode($Grid->Nservicio->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_Nservicio" class="el_sco_servicio_Nservicio">
<span<?= $Grid->Nservicio->viewAttributes() ?>>
<?= $Grid->Nservicio->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_servicio" data-field="x_Nservicio" data-hidden="1" name="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_Nservicio" id="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_Nservicio" value="<?= HtmlEncode($Grid->Nservicio->FormValue) ?>">
<input type="hidden" data-table="sco_servicio" data-field="x_Nservicio" data-hidden="1" data-old name="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_Nservicio" id="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_Nservicio" value="<?= HtmlEncode($Grid->Nservicio->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sco_servicio" data-field="x_Nservicio" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Nservicio" id="x<?= $Grid->RowIndex ?>_Nservicio" value="<?= HtmlEncode($Grid->Nservicio->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->nombre->Visible) { // nombre ?>
        <td data-name="nombre"<?= $Grid->nombre->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_nombre" class="el_sco_servicio_nombre">
<input type="<?= $Grid->nombre->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nombre" id="x<?= $Grid->RowIndex ?>_nombre" data-table="sco_servicio" data-field="x_nombre" value="<?= $Grid->nombre->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nombre->formatPattern()) ?>"<?= $Grid->nombre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_servicio" data-field="x_nombre" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nombre" id="o<?= $Grid->RowIndex ?>_nombre" value="<?= HtmlEncode($Grid->nombre->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_nombre" class="el_sco_servicio_nombre">
<input type="<?= $Grid->nombre->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nombre" id="x<?= $Grid->RowIndex ?>_nombre" data-table="sco_servicio" data-field="x_nombre" value="<?= $Grid->nombre->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Grid->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nombre->formatPattern()) ?>"<?= $Grid->nombre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_nombre" class="el_sco_servicio_nombre">
<span<?= $Grid->nombre->viewAttributes() ?>>
<?= $Grid->nombre->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_servicio" data-field="x_nombre" data-hidden="1" name="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_nombre" id="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_nombre" value="<?= HtmlEncode($Grid->nombre->FormValue) ?>">
<input type="hidden" data-table="sco_servicio" data-field="x_nombre" data-hidden="1" data-old name="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_nombre" id="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_nombre" value="<?= HtmlEncode($Grid->nombre->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->activo->Visible) { // activo ?>
        <td data-name="activo"<?= $Grid->activo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_activo" class="el_sco_servicio_activo">
    <select
        id="x<?= $Grid->RowIndex ?>_activo"
        name="x<?= $Grid->RowIndex ?>_activo"
        class="form-select ew-select<?= $Grid->activo->isInvalidClass() ?>"
        <?php if (!$Grid->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_serviciogrid_x<?= $Grid->RowIndex ?>_activo"
        <?php } ?>
        data-table="sco_servicio"
        data-field="x_activo"
        data-value-separator="<?= $Grid->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->activo->getPlaceHolder()) ?>"
        <?= $Grid->activo->editAttributes() ?>>
        <?= $Grid->activo->selectOptionListHtml("x{$Grid->RowIndex}_activo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->activo->getErrorMessage() ?></div>
<?php if (!$Grid->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_activo", selectId: "fsco_serviciogrid_x<?= $Grid->RowIndex ?>_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_serviciogrid.lists.activo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_servicio.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_servicio" data-field="x_activo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_activo" id="o<?= $Grid->RowIndex ?>_activo" value="<?= HtmlEncode($Grid->activo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_activo" class="el_sco_servicio_activo">
    <select
        id="x<?= $Grid->RowIndex ?>_activo"
        name="x<?= $Grid->RowIndex ?>_activo"
        class="form-select ew-select<?= $Grid->activo->isInvalidClass() ?>"
        <?php if (!$Grid->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_serviciogrid_x<?= $Grid->RowIndex ?>_activo"
        <?php } ?>
        data-table="sco_servicio"
        data-field="x_activo"
        data-value-separator="<?= $Grid->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->activo->getPlaceHolder()) ?>"
        <?= $Grid->activo->editAttributes() ?>>
        <?= $Grid->activo->selectOptionListHtml("x{$Grid->RowIndex}_activo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->activo->getErrorMessage() ?></div>
<?php if (!$Grid->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_serviciogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_activo", selectId: "fsco_serviciogrid_x<?= $Grid->RowIndex ?>_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_serviciogrid.lists.activo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_serviciogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_serviciogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_servicio.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_servicio_activo" class="el_sco_servicio_activo">
<span<?= $Grid->activo->viewAttributes() ?>>
<?= $Grid->activo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_servicio" data-field="x_activo" data-hidden="1" name="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_activo" id="fsco_serviciogrid$x<?= $Grid->RowIndex ?>_activo" value="<?= HtmlEncode($Grid->activo->FormValue) ?>">
<input type="hidden" data-table="sco_servicio" data-field="x_activo" data-hidden="1" data-old name="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_activo" id="fsco_serviciogrid$o<?= $Grid->RowIndex ?>_activo" value="<?= HtmlEncode($Grid->activo->OldValue) ?>">
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
loadjs.ready(["fsco_serviciogrid","load"], () => fsco_serviciogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_serviciogrid">
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
    ew.addEventHandlers("sco_servicio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
