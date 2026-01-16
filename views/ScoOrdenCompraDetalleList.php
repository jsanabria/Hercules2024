<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDetalleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo_insumo", [fields.tipo_insumo.visible && fields.tipo_insumo.required ? ew.Validators.required(fields.tipo_insumo.caption) : null], fields.tipo_insumo.isInvalid],
            ["articulo", [fields.articulo.visible && fields.articulo.required ? ew.Validators.required(fields.articulo.caption) : null], fields.articulo.isInvalid],
            ["unidad_medida", [fields.unidad_medida.visible && fields.unidad_medida.required ? ew.Validators.required(fields.unidad_medida.caption) : null], fields.unidad_medida.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null], fields.cantidad.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["imagen", [fields.imagen.visible && fields.imagen.required ? ew.Validators.fileRequired(fields.imagen.caption) : null], fields.imagen.isInvalid],
            ["disponible", [fields.disponible.visible && fields.disponible.required ? ew.Validators.required(fields.disponible.caption) : null], fields.disponible.isInvalid],
            ["unidad_medida_recibida", [fields.unidad_medida_recibida.visible && fields.unidad_medida_recibida.required ? ew.Validators.required(fields.unidad_medida_recibida.caption) : null], fields.unidad_medida_recibida.isInvalid],
            ["cantidad_recibida", [fields.cantidad_recibida.visible && fields.cantidad_recibida.required ? ew.Validators.required(fields.cantidad_recibida.caption) : null, ew.Validators.float], fields.cantidad_recibida.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo_insumo",false],["articulo",false],["unidad_medida",false],["cantidad",false],["descripcion",false],["imagen",false],["disponible",false],["unidad_medida_recibida",false],["cantidad_recibida",false]];
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
            "tipo_insumo": <?= $Page->tipo_insumo->toClientList($Page) ?>,
            "articulo": <?= $Page->articulo->toClientList($Page) ?>,
            "unidad_medida": <?= $Page->unidad_medida->toClientList($Page) ?>,
            "disponible": <?= $Page->disponible->toClientList($Page) ?>,
            "unidad_medida_recibida": <?= $Page->unidad_medida_recibida->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.js?v=24.16.0", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "sco_orden_compra") {
    if ($Page->MasterRecordExists) {
        include_once "views/ScoOrdenCompraMaster.php";
    }
}
?>
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fsco_orden_compra_detallesrch" id="fsco_orden_compra_detallesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_orden_compra_detallesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
var currentForm;
var fsco_orden_compra_detallesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compra_detallesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["disponible", [], fields.disponible.isInvalid]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
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
            "disponible": <?= $Page->disponible->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)

        // Init search panel as collapsed
        .setInitSearchPanel(true)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->disponible->Visible) { // disponible ?>
<?php
if (!$Page->disponible->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_disponible" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->disponible->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_disponible" class="ew-search-caption ew-label"><?= $Page->disponible->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_disponible" id="z_disponible" value="=">
</div>
        </div>
        <div id="el_sco_orden_compra_detalle_disponible" class="ew-search-field">
    <select
        id="x_disponible"
        name="x_disponible"
        class="form-select ew-select<?= $Page->disponible->isInvalidClass() ?>"
        <?php if (!$Page->disponible->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallesrch_x_disponible"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_disponible"
        data-value-separator="<?= $Page->disponible->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->disponible->getPlaceHolder()) ?>"
        <?= $Page->disponible->editAttributes() ?>>
        <?= $Page->disponible->selectOptionListHtml("x_disponible") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->disponible->getErrorMessage(false) ?></div>
<?php if (!$Page->disponible->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallesrch", function() {
    var options = { name: "x_disponible", selectId: "fsco_orden_compra_detallesrch_x_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallesrch.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x_disponible", form: "fsco_orden_compra_detallesrch" };
    } else {
        options.ajax = { id: "x_disponible", form: "fsco_orden_compra_detallesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.disponible.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_orden_compra_detallesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_orden_compra_detallesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_orden_compra_detallesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_orden_compra_detallesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden_compra_detalle">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sco_orden_compra" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_orden_compra">
<input type="hidden" name="fk_Norden_compra" value="<?= HtmlEncode($Page->orden_compra->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_sco_orden_compra_detalle" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_orden_compra_detallelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <th data-name="tipo_insumo" class="<?= $Page->tipo_insumo->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_tipo_insumo" class="sco_orden_compra_detalle_tipo_insumo"><?= $Page->renderFieldHeader($Page->tipo_insumo) ?></div></th>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
        <th data-name="articulo" class="<?= $Page->articulo->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_articulo" class="sco_orden_compra_detalle_articulo"><?= $Page->renderFieldHeader($Page->articulo) ?></div></th>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
        <th data-name="unidad_medida" class="<?= $Page->unidad_medida->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_unidad_medida" class="sco_orden_compra_detalle_unidad_medida"><?= $Page->renderFieldHeader($Page->unidad_medida) ?></div></th>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
        <th data-name="cantidad" class="<?= $Page->cantidad->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_cantidad" class="sco_orden_compra_detalle_cantidad"><?= $Page->renderFieldHeader($Page->cantidad) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th data-name="descripcion" class="<?= $Page->descripcion->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_descripcion" class="sco_orden_compra_detalle_descripcion"><?= $Page->renderFieldHeader($Page->descripcion) ?></div></th>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
        <th data-name="imagen" class="<?= $Page->imagen->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_imagen" class="sco_orden_compra_detalle_imagen"><?= $Page->renderFieldHeader($Page->imagen) ?></div></th>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
        <th data-name="disponible" class="<?= $Page->disponible->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_disponible" class="sco_orden_compra_detalle_disponible"><?= $Page->renderFieldHeader($Page->disponible) ?></div></th>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <th data-name="unidad_medida_recibida" class="<?= $Page->unidad_medida_recibida->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_unidad_medida_recibida" class="sco_orden_compra_detalle_unidad_medida_recibida"><?= $Page->renderFieldHeader($Page->unidad_medida_recibida) ?></div></th>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <th data-name="cantidad_recibida" class="<?= $Page->cantidad_recibida->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_cantidad_recibida" class="sco_orden_compra_detalle_cantidad_recibida"><?= $Page->renderFieldHeader($Page->cantidad_recibida) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
$isInlineAddOrCopy = ($Page->isCopy() || $Page->isAdd());
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Page->RowIndex == 0) {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Page->RowIndex == 0)
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <td data-name="tipo_insumo"<?= $Page->tipo_insumo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_tipo_insumo" class="el_sco_orden_compra_detalle_tipo_insumo">
    <select
        id="x<?= $Page->RowIndex ?>_tipo_insumo"
        name="x<?= $Page->RowIndex ?>_tipo_insumo"
        class="form-select ew-select<?= $Page->tipo_insumo->isInvalidClass() ?>"
        <?php if (!$Page->tipo_insumo->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo_insumo"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_tipo_insumo"
        data-value-separator="<?= $Page->tipo_insumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_insumo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo_insumo->editAttributes() ?>>
        <?= $Page->tipo_insumo->selectOptionListHtml("x{$Page->RowIndex}_tipo_insumo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo_insumo->getErrorMessage() ?></div>
<?= $Page->tipo_insumo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_tipo_insumo") ?>
<?php if (!$Page->tipo_insumo->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_tipo_insumo", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo_insumo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.tipo_insumo?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_tipo_insumo", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_tipo_insumo", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.tipo_insumo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_tipo_insumo" id="o<?= $Page->RowIndex ?>_tipo_insumo" value="<?= HtmlEncode($Page->tipo_insumo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_tipo_insumo" class="el_sco_orden_compra_detalle_tipo_insumo">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo_insumo->getDisplayValue($Page->tipo_insumo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" name="x<?= $Page->RowIndex ?>_tipo_insumo" id="x<?= $Page->RowIndex ?>_tipo_insumo" value="<?= HtmlEncode($Page->tipo_insumo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_tipo_insumo" class="el_sco_orden_compra_detalle_tipo_insumo">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->articulo->Visible) { // articulo ?>
        <td data-name="articulo"<?= $Page->articulo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_articulo" class="el_sco_orden_compra_detalle_articulo">
    <select
        id="x<?= $Page->RowIndex ?>_articulo"
        name="x<?= $Page->RowIndex ?>_articulo"
        class="form-control ew-select<?= $Page->articulo->isInvalidClass() ?>"
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_articulo"
        data-table="sco_orden_compra_detalle"
        data-field="x_articulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->articulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->articulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo->getPlaceHolder()) ?>"
        <?= $Page->articulo->editAttributes() ?>>
        <?= $Page->articulo->selectOptionListHtml("x{$Page->RowIndex}_articulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->articulo->getErrorMessage() ?></div>
<?= $Page->articulo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_articulo") ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_articulo", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_articulo" };
    if (<?= $Page->FormName ?>.lists.articulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_articulo", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_articulo", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.articulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_articulo" id="o<?= $Page->RowIndex ?>_articulo" value="<?= HtmlEncode($Page->articulo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_articulo" class="el_sco_orden_compra_detalle_articulo">
<span<?= $Page->articulo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->articulo->getDisplayValue($Page->articulo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" name="x<?= $Page->RowIndex ?>_articulo" id="x<?= $Page->RowIndex ?>_articulo" value="<?= HtmlEncode($Page->articulo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_articulo" class="el_sco_orden_compra_detalle_articulo">
<span<?= $Page->articulo->viewAttributes() ?>>
<?= $Page->articulo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
        <td data-name="unidad_medida"<?= $Page->unidad_medida->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_unidad_medida" class="el_sco_orden_compra_detalle_unidad_medida">
    <select
        id="x<?= $Page->RowIndex ?>_unidad_medida"
        name="x<?= $Page->RowIndex ?>_unidad_medida"
        class="form-select ew-select<?= $Page->unidad_medida->isInvalidClass() ?>"
        <?php if (!$Page->unidad_medida->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_unidad_medida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida"
        data-value-separator="<?= $Page->unidad_medida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_medida->getPlaceHolder()) ?>"
        <?= $Page->unidad_medida->editAttributes() ?>>
        <?= $Page->unidad_medida->selectOptionListHtml("x{$Page->RowIndex}_unidad_medida") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->unidad_medida->getErrorMessage() ?></div>
<?= $Page->unidad_medida->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_unidad_medida") ?>
<?php if (!$Page->unidad_medida->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_unidad_medida", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_unidad_medida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.unidad_medida?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_unidad_medida", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_unidad_medida", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_unidad_medida" id="o<?= $Page->RowIndex ?>_unidad_medida" value="<?= HtmlEncode($Page->unidad_medida->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_unidad_medida" class="el_sco_orden_compra_detalle_unidad_medida">
<span<?= $Page->unidad_medida->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->unidad_medida->getDisplayValue($Page->unidad_medida->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" name="x<?= $Page->RowIndex ?>_unidad_medida" id="x<?= $Page->RowIndex ?>_unidad_medida" value="<?= HtmlEncode($Page->unidad_medida->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_unidad_medida" class="el_sco_orden_compra_detalle_unidad_medida">
<span<?= $Page->unidad_medida->viewAttributes() ?>>
<?= $Page->unidad_medida->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->cantidad->Visible) { // cantidad ?>
        <td data-name="cantidad"<?= $Page->cantidad->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_cantidad" class="el_sco_orden_compra_detalle_cantidad">
<input type="<?= $Page->cantidad->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cantidad" id="x<?= $Page->RowIndex ?>_cantidad" data-table="sco_orden_compra_detalle" data-field="x_cantidad" value="<?= $Page->cantidad->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad->formatPattern()) ?>"<?= $Page->cantidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cantidad->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_cantidad" id="o<?= $Page->RowIndex ?>_cantidad" value="<?= HtmlEncode($Page->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_cantidad" class="el_sco_orden_compra_detalle_cantidad">
<span<?= $Page->cantidad->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cantidad->getDisplayValue($Page->cantidad->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" name="x<?= $Page->RowIndex ?>_cantidad" id="x<?= $Page->RowIndex ?>_cantidad" value="<?= HtmlEncode($Page->cantidad->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_cantidad" class="el_sco_orden_compra_detalle_cantidad">
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_descripcion" class="el_sco_orden_compra_detalle_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_descripcion" id="x<?= $Page->RowIndex ?>_descripcion" data-table="sco_orden_compra_detalle" data-field="x_descripcion" value="<?= $Page->descripcion->EditValue ?>" size="15" maxlength="60" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion->formatPattern()) ?>"<?= $Page->descripcion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_descripcion" id="o<?= $Page->RowIndex ?>_descripcion" value="<?= HtmlEncode($Page->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_descripcion" class="el_sco_orden_compra_detalle_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->descripcion->getDisplayValue($Page->descripcion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" name="x<?= $Page->RowIndex ?>_descripcion" id="x<?= $Page->RowIndex ?>_descripcion" value="<?= HtmlEncode($Page->descripcion->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_descripcion" class="el_sco_orden_compra_detalle_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->imagen->Visible) { // imagen ?>
        <td data-name="imagen"<?= $Page->imagen->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<div id="fd_x<?= $Page->RowIndex ?>_imagen" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Page->RowIndex ?>_imagen"
        name="x<?= $Page->RowIndex ?>_imagen"
        class="form-control ew-file-input"
        title="<?= $Page->imagen->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_orden_compra_detalle"
        data-field="x_imagen"
        data-size="255"
        data-accept-file-types="<?= $Page->imagen->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->imagen->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->imagen->ImageCropper ? 0 : 1 ?>"
        <?= ($Page->imagen->ReadOnly || $Page->imagen->Disabled) ? " disabled" : "" ?>
        <?= $Page->imagen->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Page->imagen->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_imagen" id= "fn_x<?= $Page->RowIndex ?>_imagen" value="<?= $Page->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_imagen" id= "fa_x<?= $Page->RowIndex ?>_imagen" value="0">
<table id="ft_x<?= $Page->RowIndex ?>_imagen" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_imagen" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_imagen" id="o<?= $Page->RowIndex ?>_imagen" value="<?= HtmlEncode($Page->imagen->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->EditValue, false) ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_imagen" data-hidden="1" name="x<?= $Page->RowIndex ?>_imagen" id="x<?= $Page->RowIndex ?>_imagen" value="<?= HtmlEncode($Page->imagen->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->disponible->Visible) { // disponible ?>
        <td data-name="disponible"<?= $Page->disponible->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_disponible" class="el_sco_orden_compra_detalle_disponible">
    <select
        id="x<?= $Page->RowIndex ?>_disponible"
        name="x<?= $Page->RowIndex ?>_disponible"
        class="form-select ew-select<?= $Page->disponible->isInvalidClass() ?>"
        <?php if (!$Page->disponible->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_disponible"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_disponible"
        data-value-separator="<?= $Page->disponible->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->disponible->getPlaceHolder()) ?>"
        <?= $Page->disponible->editAttributes() ?>>
        <?= $Page->disponible->selectOptionListHtml("x{$Page->RowIndex}_disponible") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->disponible->getErrorMessage() ?></div>
<?php if (!$Page->disponible->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_disponible", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_disponible", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_disponible", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.disponible.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_disponible" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_disponible" id="o<?= $Page->RowIndex ?>_disponible" value="<?= HtmlEncode($Page->disponible->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_disponible" class="el_sco_orden_compra_detalle_disponible">
    <select
        id="x<?= $Page->RowIndex ?>_disponible"
        name="x<?= $Page->RowIndex ?>_disponible"
        class="form-select ew-select<?= $Page->disponible->isInvalidClass() ?>"
        <?php if (!$Page->disponible->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_disponible"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_disponible"
        data-value-separator="<?= $Page->disponible->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->disponible->getPlaceHolder()) ?>"
        <?= $Page->disponible->editAttributes() ?>>
        <?= $Page->disponible->selectOptionListHtml("x{$Page->RowIndex}_disponible") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->disponible->getErrorMessage() ?></div>
<?php if (!$Page->disponible->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_disponible", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_disponible", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_disponible", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.disponible.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_disponible" class="el_sco_orden_compra_detalle_disponible">
<span<?= $Page->disponible->viewAttributes() ?>>
<?= $Page->disponible->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <td data-name="unidad_medida_recibida"<?= $Page->unidad_medida_recibida->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_unidad_medida_recibida" class="el_sco_orden_compra_detalle_unidad_medida_recibida">
    <select
        id="x<?= $Page->RowIndex ?>_unidad_medida_recibida"
        name="x<?= $Page->RowIndex ?>_unidad_medida_recibida"
        class="form-select ew-select<?= $Page->unidad_medida_recibida->isInvalidClass() ?>"
        <?php if (!$Page->unidad_medida_recibida->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_unidad_medida_recibida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida_recibida"
        data-value-separator="<?= $Page->unidad_medida_recibida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_medida_recibida->getPlaceHolder()) ?>"
        <?= $Page->unidad_medida_recibida->editAttributes() ?>>
        <?= $Page->unidad_medida_recibida->selectOptionListHtml("x{$Page->RowIndex}_unidad_medida_recibida") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->unidad_medida_recibida->getErrorMessage() ?></div>
<?= $Page->unidad_medida_recibida->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_unidad_medida_recibida") ?>
<?php if (!$Page->unidad_medida_recibida->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_unidad_medida_recibida", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_unidad_medida_recibida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.unidad_medida_recibida?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_unidad_medida_recibida", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_unidad_medida_recibida", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida_recibida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida_recibida" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_unidad_medida_recibida" id="o<?= $Page->RowIndex ?>_unidad_medida_recibida" value="<?= HtmlEncode($Page->unidad_medida_recibida->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_unidad_medida_recibida" class="el_sco_orden_compra_detalle_unidad_medida_recibida">
    <select
        id="x<?= $Page->RowIndex ?>_unidad_medida_recibida"
        name="x<?= $Page->RowIndex ?>_unidad_medida_recibida"
        class="form-select ew-select<?= $Page->unidad_medida_recibida->isInvalidClass() ?>"
        <?php if (!$Page->unidad_medida_recibida->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_unidad_medida_recibida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida_recibida"
        data-value-separator="<?= $Page->unidad_medida_recibida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_medida_recibida->getPlaceHolder()) ?>"
        <?= $Page->unidad_medida_recibida->editAttributes() ?>>
        <?= $Page->unidad_medida_recibida->selectOptionListHtml("x{$Page->RowIndex}_unidad_medida_recibida") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->unidad_medida_recibida->getErrorMessage() ?></div>
<?= $Page->unidad_medida_recibida->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_unidad_medida_recibida") ?>
<?php if (!$Page->unidad_medida_recibida->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_unidad_medida_recibida", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_unidad_medida_recibida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.unidad_medida_recibida?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_unidad_medida_recibida", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_unidad_medida_recibida", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida_recibida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_unidad_medida_recibida" class="el_sco_orden_compra_detalle_unidad_medida_recibida">
<span<?= $Page->unidad_medida_recibida->viewAttributes() ?>>
<?= $Page->unidad_medida_recibida->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <td data-name="cantidad_recibida"<?= $Page->cantidad_recibida->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_cantidad_recibida" class="el_sco_orden_compra_detalle_cantidad_recibida">
<input type="<?= $Page->cantidad_recibida->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cantidad_recibida" id="x<?= $Page->RowIndex ?>_cantidad_recibida" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" value="<?= $Page->cantidad_recibida->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->cantidad_recibida->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad_recibida->formatPattern()) ?>"<?= $Page->cantidad_recibida->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cantidad_recibida->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_cantidad_recibida" id="o<?= $Page->RowIndex ?>_cantidad_recibida" value="<?= HtmlEncode($Page->cantidad_recibida->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_cantidad_recibida" class="el_sco_orden_compra_detalle_cantidad_recibida">
<input type="<?= $Page->cantidad_recibida->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_cantidad_recibida" id="x<?= $Page->RowIndex ?>_cantidad_recibida" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" value="<?= $Page->cantidad_recibida->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->cantidad_recibida->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad_recibida->formatPattern()) ?>"<?= $Page->cantidad_recibida->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cantidad_recibida->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_orden_compra_detalle_cantidad_recibida" class="el_sco_orden_compra_detalle_cantidad_recibida">
<span<?= $Page->cantidad_recibida->viewAttributes() ?>>
<?= $Page->cantidad_recibida->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_orden_compra_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
