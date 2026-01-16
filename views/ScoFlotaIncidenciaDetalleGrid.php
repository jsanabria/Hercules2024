<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoFlotaIncidenciaDetalleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_flota_incidencia_detallegrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia_detalle: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flota_incidencia_detallegrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
            ["proveedor", [fields.proveedor.visible && fields.proveedor.required ? ew.Validators.required(fields.proveedor.caption) : null], fields.proveedor.isInvalid],
            ["costo", [fields.costo.visible && fields.costo.required ? ew.Validators.required(fields.costo.caption) : null, ew.Validators.float], fields.costo.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo",false],["archivo",false],["proveedor",false],["costo",false]];
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
            "proveedor": <?= $Grid->proveedor->toClientList($Grid) ?>,
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
<div id="fsco_flota_incidencia_detallegrid" class="ew-form ew-list-form">
<div id="gmp_sco_flota_incidencia_detalle" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_flota_incidencia_detallegrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="tipo" class="<?= $Grid->tipo->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_detalle_tipo" class="sco_flota_incidencia_detalle_tipo"><?= $Grid->renderFieldHeader($Grid->tipo) ?></div></th>
<?php } ?>
<?php if ($Grid->archivo->Visible) { // archivo ?>
        <th data-name="archivo" class="<?= $Grid->archivo->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_detalle_archivo" class="sco_flota_incidencia_detalle_archivo"><?= $Grid->renderFieldHeader($Grid->archivo) ?></div></th>
<?php } ?>
<?php if ($Grid->proveedor->Visible) { // proveedor ?>
        <th data-name="proveedor" class="<?= $Grid->proveedor->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_detalle_proveedor" class="sco_flota_incidencia_detalle_proveedor"><?= $Grid->renderFieldHeader($Grid->proveedor) ?></div></th>
<?php } ?>
<?php if ($Grid->costo->Visible) { // costo ?>
        <th data-name="costo" class="<?= $Grid->costo->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_detalle_costo" class="sco_flota_incidencia_detalle_costo"><?= $Grid->renderFieldHeader($Grid->costo) ?></div></th>
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
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_tipo" class="el_sco_flota_incidencia_detalle_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_flota_incidencia_detalle"
        data-field="x_tipo"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?php if (!$Grid->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidencia_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidencia_detallegrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_flota_incidencia_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_flota_incidencia_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia_detalle.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_tipo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo" id="o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_tipo" class="el_sco_flota_incidencia_detalle_tipo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo"
        name="x<?= $Grid->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Grid->tipo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_flota_incidencia_detalle"
        data-field="x_tipo"
        data-value-separator="<?= $Grid->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo->getPlaceHolder()) ?>"
        <?= $Grid->tipo->editAttributes() ?>>
        <?= $Grid->tipo->selectOptionListHtml("x{$Grid->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo->getErrorMessage() ?></div>
<?php if (!$Grid->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidencia_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo", selectId: "fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidencia_detallegrid.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_flota_incidencia_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo", form: "fsco_flota_incidencia_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia_detalle.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_tipo" class="el_sco_flota_incidencia_detalle_tipo">
<span<?= $Grid->tipo->viewAttributes() ?>>
<?= $Grid->tipo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_tipo" data-hidden="1" name="fsco_flota_incidencia_detallegrid$x<?= $Grid->RowIndex ?>_tipo" id="fsco_flota_incidencia_detallegrid$x<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->FormValue) ?>">
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_tipo" data-hidden="1" data-old name="fsco_flota_incidencia_detallegrid$o<?= $Grid->RowIndex ?>_tipo" id="fsco_flota_incidencia_detallegrid$o<?= $Grid->RowIndex ?>_tipo" value="<?= HtmlEncode($Grid->tipo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->archivo->Visible) { // archivo ?>
        <td data-name="archivo"<?= $Grid->archivo->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex ?>_sco_flota_incidencia_detalle_archivo" class="el_sco_flota_incidencia_detalle_archivo">
<div id="fd_x<?= $Grid->RowIndex ?>_archivo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_archivo"
        name="x<?= $Grid->RowIndex ?>_archivo"
        class="form-control ew-file-input"
        title="<?= $Grid->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_flota_incidencia_detalle"
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
<span id="el<?= $Grid->RowIndex ?>_sco_flota_incidencia_detalle_archivo" class="el_sco_flota_incidencia_detalle_archivo">
<div id="fd_x<?= $Grid->RowIndex ?>_archivo">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_archivo"
        name="x<?= $Grid->RowIndex ?>_archivo"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_flota_incidencia_detalle"
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
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_archivo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_archivo" id="o<?= $Grid->RowIndex ?>_archivo" value="<?= HtmlEncode($Grid->archivo->OldValue) ?>">
<?php } elseif ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_archivo" class="el_sco_flota_incidencia_detalle_archivo">
<span>
<?= GetFileViewTag($Grid->archivo, $Grid->archivo->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_archivo" class="el_sco_flota_incidencia_detalle_archivo">
<div id="fd_x<?= $Grid->RowIndex ?>_archivo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_archivo"
        name="x<?= $Grid->RowIndex ?>_archivo"
        class="form-control ew-file-input"
        title="<?= $Grid->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_flota_incidencia_detalle"
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
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_archivo" id= "fa_x<?= $Grid->RowIndex ?>_archivo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_archivo") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_archivo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_archivo" class="el_sco_flota_incidencia_detalle_archivo">
<div id="fd_x<?= $Grid->RowIndex ?>_archivo">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_archivo"
        name="x<?= $Grid->RowIndex ?>_archivo"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_flota_incidencia_detalle"
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
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_archivo" id= "fa_x<?= $Grid->RowIndex ?>_archivo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_archivo") == "0") ? "0" : "1" ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_archivo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->proveedor->Visible) { // proveedor ?>
        <td data-name="proveedor"<?= $Grid->proveedor->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_proveedor" class="el_sco_flota_incidencia_detalle_proveedor">
    <select
        id="x<?= $Grid->RowIndex ?>_proveedor"
        name="x<?= $Grid->RowIndex ?>_proveedor"
        class="form-select ew-select<?= $Grid->proveedor->isInvalidClass() ?>"
        <?php if (!$Grid->proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_proveedor"
        <?php } ?>
        data-table="sco_flota_incidencia_detalle"
        data-field="x_proveedor"
        data-value-separator="<?= $Grid->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->proveedor->getPlaceHolder()) ?>"
        <?= $Grid->proveedor->editAttributes() ?>>
        <?= $Grid->proveedor->selectOptionListHtml("x{$Grid->RowIndex}_proveedor") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->proveedor->getErrorMessage() ?></div>
<?= $Grid->proveedor->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_proveedor") ?>
<?php if (!$Grid->proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidencia_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_proveedor", selectId: "fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidencia_detallegrid.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_proveedor", form: "fsco_flota_incidencia_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_proveedor", form: "fsco_flota_incidencia_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia_detalle.fields.proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_proveedor" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_proveedor" id="o<?= $Grid->RowIndex ?>_proveedor" value="<?= HtmlEncode($Grid->proveedor->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_proveedor" class="el_sco_flota_incidencia_detalle_proveedor">
    <select
        id="x<?= $Grid->RowIndex ?>_proveedor"
        name="x<?= $Grid->RowIndex ?>_proveedor"
        class="form-select ew-select<?= $Grid->proveedor->isInvalidClass() ?>"
        <?php if (!$Grid->proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_proveedor"
        <?php } ?>
        data-table="sco_flota_incidencia_detalle"
        data-field="x_proveedor"
        data-value-separator="<?= $Grid->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->proveedor->getPlaceHolder()) ?>"
        <?= $Grid->proveedor->editAttributes() ?>>
        <?= $Grid->proveedor->selectOptionListHtml("x{$Grid->RowIndex}_proveedor") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->proveedor->getErrorMessage() ?></div>
<?= $Grid->proveedor->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_proveedor") ?>
<?php if (!$Grid->proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidencia_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_proveedor", selectId: "fsco_flota_incidencia_detallegrid_x<?= $Grid->RowIndex ?>_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidencia_detallegrid.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_proveedor", form: "fsco_flota_incidencia_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_proveedor", form: "fsco_flota_incidencia_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia_detalle.fields.proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_proveedor" class="el_sco_flota_incidencia_detalle_proveedor">
<span<?= $Grid->proveedor->viewAttributes() ?>>
<?= $Grid->proveedor->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_proveedor" data-hidden="1" name="fsco_flota_incidencia_detallegrid$x<?= $Grid->RowIndex ?>_proveedor" id="fsco_flota_incidencia_detallegrid$x<?= $Grid->RowIndex ?>_proveedor" value="<?= HtmlEncode($Grid->proveedor->FormValue) ?>">
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_proveedor" data-hidden="1" data-old name="fsco_flota_incidencia_detallegrid$o<?= $Grid->RowIndex ?>_proveedor" id="fsco_flota_incidencia_detallegrid$o<?= $Grid->RowIndex ?>_proveedor" value="<?= HtmlEncode($Grid->proveedor->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->costo->Visible) { // costo ?>
        <td data-name="costo"<?= $Grid->costo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_costo" class="el_sco_flota_incidencia_detalle_costo">
<input type="<?= $Grid->costo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_costo" id="x<?= $Grid->RowIndex ?>_costo" data-table="sco_flota_incidencia_detalle" data-field="x_costo" value="<?= $Grid->costo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->costo->formatPattern()) ?>"<?= $Grid->costo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->costo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_costo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_costo" id="o<?= $Grid->RowIndex ?>_costo" value="<?= HtmlEncode($Grid->costo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_costo" class="el_sco_flota_incidencia_detalle_costo">
<input type="<?= $Grid->costo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_costo" id="x<?= $Grid->RowIndex ?>_costo" data-table="sco_flota_incidencia_detalle" data-field="x_costo" value="<?= $Grid->costo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->costo->formatPattern()) ?>"<?= $Grid->costo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->costo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_flota_incidencia_detalle_costo" class="el_sco_flota_incidencia_detalle_costo">
<span<?= $Grid->costo->viewAttributes() ?>>
<?= $Grid->costo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_costo" data-hidden="1" name="fsco_flota_incidencia_detallegrid$x<?= $Grid->RowIndex ?>_costo" id="fsco_flota_incidencia_detallegrid$x<?= $Grid->RowIndex ?>_costo" value="<?= HtmlEncode($Grid->costo->FormValue) ?>">
<input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_costo" data-hidden="1" data-old name="fsco_flota_incidencia_detallegrid$o<?= $Grid->RowIndex ?>_costo" id="fsco_flota_incidencia_detallegrid$o<?= $Grid->RowIndex ?>_costo" value="<?= HtmlEncode($Grid->costo->OldValue) ?>">
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
loadjs.ready(["fsco_flota_incidencia_detallegrid","load"], () => fsco_flota_incidencia_detallegrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_flota_incidencia_detallegrid">
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
    ew.addEventHandlers("sco_flota_incidencia_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
