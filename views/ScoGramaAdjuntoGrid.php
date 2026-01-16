<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoGramaAdjuntoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_grama_adjuntogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_grama_adjunto: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_grama_adjuntogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["archivo",false],["nota",false],["fecha",false],["activo",false]];
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
<div id="fsco_grama_adjuntogrid" class="ew-form ew-list-form">
<div id="gmp_sco_grama_adjunto" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_grama_adjuntogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->archivo->Visible) { // archivo ?>
        <th data-name="archivo" class="<?= $Grid->archivo->headerCellClass() ?>"><div id="elh_sco_grama_adjunto_archivo" class="sco_grama_adjunto_archivo"><?= $Grid->renderFieldHeader($Grid->archivo) ?></div></th>
<?php } ?>
<?php if ($Grid->nota->Visible) { // nota ?>
        <th data-name="nota" class="<?= $Grid->nota->headerCellClass() ?>"><div id="elh_sco_grama_adjunto_nota" class="sco_grama_adjunto_nota"><?= $Grid->renderFieldHeader($Grid->nota) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_sco_grama_adjunto_fecha" class="sco_grama_adjunto_fecha"><?= $Grid->renderFieldHeader($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->activo->Visible) { // activo ?>
        <th data-name="activo" class="<?= $Grid->activo->headerCellClass() ?>"><div id="elh_sco_grama_adjunto_activo" class="sco_grama_adjunto_activo"><?= $Grid->renderFieldHeader($Grid->activo) ?></div></th>
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
    <?php if ($Grid->archivo->Visible) { // archivo ?>
        <td data-name="archivo"<?= $Grid->archivo->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex ?>_sco_grama_adjunto_archivo" class="el_sco_grama_adjunto_archivo">
<div id="fd_x<?= $Grid->RowIndex ?>_archivo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_archivo"
        name="x<?= $Grid->RowIndex ?>_archivo"
        class="form-control ew-file-input"
        title="<?= $Grid->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_grama_adjunto"
        data-field="x_archivo"
        data-size="255"
        data-accept-file-types="<?= $Grid->archivo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->archivo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->archivo->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->archivo->ReadOnly || $Grid->archivo->Disabled) ? " disabled" : "" ?>
        <?= $Grid->archivo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->archivo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_archivo" id= "fn_x<?= $Grid->RowIndex ?>_archivo" value="<?= $Grid->archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_archivo" id= "fa_x<?= $Grid->RowIndex ?>_archivo" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_archivo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex ?>_sco_grama_adjunto_archivo" class="el_sco_grama_adjunto_archivo">
<div id="fd_x<?= $Grid->RowIndex ?>_archivo">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_archivo"
        name="x<?= $Grid->RowIndex ?>_archivo"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_grama_adjunto"
        data-field="x_archivo"
        data-size="255"
        data-accept-file-types="<?= $Grid->archivo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->archivo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->archivo->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->archivo->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->archivo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_archivo" id= "fn_x<?= $Grid->RowIndex ?>_archivo" value="<?= $Grid->archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_archivo" id= "fa_x<?= $Grid->RowIndex ?>_archivo" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_archivo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_archivo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_archivo" id="o<?= $Grid->RowIndex ?>_archivo" value="<?= HtmlEncode($Grid->archivo->OldValue) ?>">
<?php } elseif ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_archivo" class="el_sco_grama_adjunto_archivo">
<span>
<?= GetFileViewTag($Grid->archivo, $Grid->archivo->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_archivo" class="el_sco_grama_adjunto_archivo">
<span>
<?= GetFileViewTag($Grid->archivo, $Grid->archivo->EditValue, false) ?>
</span>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_archivo" data-hidden="1" data-old name="x<?= $Grid->RowIndex ?>_archivo" id="x<?= $Grid->RowIndex ?>_archivo" value="<?= HtmlEncode($Grid->archivo->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_archivo" class="el_sco_grama_adjunto_archivo">
<span>
<?= GetFileViewTag($Grid->archivo, $Grid->archivo->EditValue, false) ?>
</span>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_archivo" data-hidden="1" data-old name="x<?= $Grid->RowIndex ?>_archivo" id="x<?= $Grid->RowIndex ?>_archivo" value="<?= HtmlEncode($Grid->archivo->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nota->Visible) { // nota ?>
        <td data-name="nota"<?= $Grid->nota->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_nota" class="el_sco_grama_adjunto_nota">
<textarea data-table="sco_grama_adjunto" data-field="x_nota" name="x<?= $Grid->RowIndex ?>_nota" id="x<?= $Grid->RowIndex ?>_nota" cols="35" rows="3" placeholder="<?= HtmlEncode($Grid->nota->getPlaceHolder()) ?>"<?= $Grid->nota->editAttributes() ?>><?= $Grid->nota->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->nota->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_nota" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nota" id="o<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_nota" class="el_sco_grama_adjunto_nota">
<textarea data-table="sco_grama_adjunto" data-field="x_nota" name="x<?= $Grid->RowIndex ?>_nota" id="x<?= $Grid->RowIndex ?>_nota" cols="35" rows="3" placeholder="<?= HtmlEncode($Grid->nota->getPlaceHolder()) ?>"<?= $Grid->nota->editAttributes() ?>><?= $Grid->nota->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->nota->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_nota" class="el_sco_grama_adjunto_nota">
<span<?= $Grid->nota->viewAttributes() ?>>
<?= $Grid->nota->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_nota" data-hidden="1" name="fsco_grama_adjuntogrid$x<?= $Grid->RowIndex ?>_nota" id="fsco_grama_adjuntogrid$x<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->FormValue) ?>">
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_nota" data-hidden="1" data-old name="fsco_grama_adjuntogrid$o<?= $Grid->RowIndex ?>_nota" id="fsco_grama_adjuntogrid$o<?= $Grid->RowIndex ?>_nota" value="<?= HtmlEncode($Grid->nota->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_fecha" class="el_sco_grama_adjunto_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_grama_adjunto" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_fecha" class="el_sco_grama_adjunto_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_grama_adjunto" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_fecha" class="el_sco_grama_adjunto_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_fecha" data-hidden="1" name="fsco_grama_adjuntogrid$x<?= $Grid->RowIndex ?>_fecha" id="fsco_grama_adjuntogrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_fecha" data-hidden="1" data-old name="fsco_grama_adjuntogrid$o<?= $Grid->RowIndex ?>_fecha" id="fsco_grama_adjuntogrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->activo->Visible) { // activo ?>
        <td data-name="activo"<?= $Grid->activo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_activo" class="el_sco_grama_adjunto_activo">
    <select
        id="x<?= $Grid->RowIndex ?>_activo"
        name="x<?= $Grid->RowIndex ?>_activo"
        class="form-select ew-select<?= $Grid->activo->isInvalidClass() ?>"
        <?php if (!$Grid->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_adjuntogrid_x<?= $Grid->RowIndex ?>_activo"
        <?php } ?>
        data-table="sco_grama_adjunto"
        data-field="x_activo"
        data-value-separator="<?= $Grid->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->activo->getPlaceHolder()) ?>"
        <?= $Grid->activo->editAttributes() ?>>
        <?= $Grid->activo->selectOptionListHtml("x{$Grid->RowIndex}_activo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->activo->getErrorMessage() ?></div>
<?php if (!$Grid->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_adjuntogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_activo", selectId: "fsco_grama_adjuntogrid_x<?= $Grid->RowIndex ?>_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_adjuntogrid.lists.activo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_grama_adjuntogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_grama_adjuntogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_adjunto.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_activo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_activo" id="o<?= $Grid->RowIndex ?>_activo" value="<?= HtmlEncode($Grid->activo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_activo" class="el_sco_grama_adjunto_activo">
    <select
        id="x<?= $Grid->RowIndex ?>_activo"
        name="x<?= $Grid->RowIndex ?>_activo"
        class="form-select ew-select<?= $Grid->activo->isInvalidClass() ?>"
        <?php if (!$Grid->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_adjuntogrid_x<?= $Grid->RowIndex ?>_activo"
        <?php } ?>
        data-table="sco_grama_adjunto"
        data-field="x_activo"
        data-value-separator="<?= $Grid->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->activo->getPlaceHolder()) ?>"
        <?= $Grid->activo->editAttributes() ?>>
        <?= $Grid->activo->selectOptionListHtml("x{$Grid->RowIndex}_activo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->activo->getErrorMessage() ?></div>
<?php if (!$Grid->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_adjuntogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_activo", selectId: "fsco_grama_adjuntogrid_x<?= $Grid->RowIndex ?>_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_adjuntogrid.lists.activo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_grama_adjuntogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_activo", form: "fsco_grama_adjuntogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_adjunto.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_grama_adjunto_activo" class="el_sco_grama_adjunto_activo">
<span<?= $Grid->activo->viewAttributes() ?>>
<?= $Grid->activo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_activo" data-hidden="1" name="fsco_grama_adjuntogrid$x<?= $Grid->RowIndex ?>_activo" id="fsco_grama_adjuntogrid$x<?= $Grid->RowIndex ?>_activo" value="<?= HtmlEncode($Grid->activo->FormValue) ?>">
<input type="hidden" data-table="sco_grama_adjunto" data-field="x_activo" data-hidden="1" data-old name="fsco_grama_adjuntogrid$o<?= $Grid->RowIndex ?>_activo" id="fsco_grama_adjuntogrid$o<?= $Grid->RowIndex ?>_activo" value="<?= HtmlEncode($Grid->activo->OldValue) ?>">
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
loadjs.ready(["fsco_grama_adjuntogrid","load"], () => fsco_grama_adjuntogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_grama_adjuntogrid">
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
    ew.addEventHandlers("sco_grama_adjunto");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
