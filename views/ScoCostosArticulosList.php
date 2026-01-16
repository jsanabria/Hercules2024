<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosArticulosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_articulos: currentTable } });
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
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["Ncostos_articulo", [fields.Ncostos_articulo.visible && fields.Ncostos_articulo.required ? ew.Validators.required(fields.Ncostos_articulo.caption) : null], fields.Ncostos_articulo.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["precio", [fields.precio.visible && fields.precio.required ? ew.Validators.required(fields.precio.caption) : null, ew.Validators.float], fields.precio.isInvalid],
            ["variacion", [fields.variacion.visible && fields.variacion.required ? ew.Validators.required(fields.variacion.caption) : null], fields.variacion.isInvalid],
            ["tipo_hercules", [fields.tipo_hercules.visible && fields.tipo_hercules.required ? ew.Validators.required(fields.tipo_hercules.caption) : null], fields.tipo_hercules.isInvalid],
            ["articulo_hercules", [fields.articulo_hercules.visible && fields.articulo_hercules.required ? ew.Validators.required(fields.articulo_hercules.caption) : null], fields.articulo_hercules.isInvalid]
        ])

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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "tipo_hercules": <?= $Page->tipo_hercules->toClientList($Page) ?>,
            "articulo_hercules": <?= $Page->articulo_hercules->toClientList($Page) ?>,
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fsco_costos_articulossrch" id="fsco_costos_articulossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_costos_articulossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_articulos: currentTable } });
var currentForm;
var fsco_costos_articulossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_costos_articulossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["tipo", [], fields.tipo.isInvalid]
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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
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
<?php if ($Page->tipo->Visible) { // tipo ?>
<?php
if (!$Page->tipo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tipo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->tipo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_tipo" class="ew-search-caption ew-label"><?= $Page->tipo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo" id="z_tipo" value="=">
</div>
        </div>
        <div id="el_sco_costos_articulos_tipo" class="ew-search-field">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_articulossrch_x_tipo"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage(false) ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_articulossrch", function() {
    var options = { name: "x_tipo", selectId: "fsco_costos_articulossrch_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_articulossrch.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_costos_articulossrch" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_costos_articulossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.tipo.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_costos_articulossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_costos_articulossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_costos_articulossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_costos_articulossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_costos_articulos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_costos_articulos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_costos_articuloslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Page->tipo->headerCellClass() ?>"><div id="elh_sco_costos_articulos_tipo" class="sco_costos_articulos_tipo"><?= $Page->renderFieldHeader($Page->tipo) ?></div></th>
<?php } ?>
<?php if ($Page->Ncostos_articulo->Visible) { // Ncostos_articulo ?>
        <th data-name="Ncostos_articulo" class="<?= $Page->Ncostos_articulo->headerCellClass() ?>"><div id="elh_sco_costos_articulos_Ncostos_articulo" class="sco_costos_articulos_Ncostos_articulo"><?= $Page->renderFieldHeader($Page->Ncostos_articulo) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th data-name="descripcion" class="<?= $Page->descripcion->headerCellClass() ?>"><div id="elh_sco_costos_articulos_descripcion" class="sco_costos_articulos_descripcion"><?= $Page->renderFieldHeader($Page->descripcion) ?></div></th>
<?php } ?>
<?php if ($Page->precio->Visible) { // precio ?>
        <th data-name="precio" class="<?= $Page->precio->headerCellClass() ?>"><div id="elh_sco_costos_articulos_precio" class="sco_costos_articulos_precio"><?= $Page->renderFieldHeader($Page->precio) ?></div></th>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <th data-name="variacion" class="<?= $Page->variacion->headerCellClass() ?>"><div id="elh_sco_costos_articulos_variacion" class="sco_costos_articulos_variacion"><?= $Page->renderFieldHeader($Page->variacion) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_hercules->Visible) { // tipo_hercules ?>
        <th data-name="tipo_hercules" class="<?= $Page->tipo_hercules->headerCellClass() ?>"><div id="elh_sco_costos_articulos_tipo_hercules" class="sco_costos_articulos_tipo_hercules"><?= $Page->renderFieldHeader($Page->tipo_hercules) ?></div></th>
<?php } ?>
<?php if ($Page->articulo_hercules->Visible) { // articulo_hercules ?>
        <th data-name="articulo_hercules" class="<?= $Page->articulo_hercules->headerCellClass() ?>"><div id="elh_sco_costos_articulos_articulo_hercules" class="sco_costos_articulos_articulo_hercules"><?= $Page->renderFieldHeader($Page->articulo_hercules) ?></div></th>
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
    <?php if ($Page->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_tipo" class="el_sco_costos_articulos_tipo">
    <select
        id="x<?= $Page->RowIndex ?>_tipo"
        name="x<?= $Page->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x{$Page->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_tipo", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_tipo", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_tipo", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_tipo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_tipo" id="o<?= $Page->RowIndex ?>_tipo" value="<?= HtmlEncode($Page->tipo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_tipo" class="el_sco_costos_articulos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo->getDisplayValue($Page->tipo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_tipo" data-hidden="1" name="x<?= $Page->RowIndex ?>_tipo" id="x<?= $Page->RowIndex ?>_tipo" value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_tipo" class="el_sco_costos_articulos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Ncostos_articulo->Visible) { // Ncostos_articulo ?>
        <td data-name="Ncostos_articulo"<?= $Page->Ncostos_articulo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_Ncostos_articulo" class="el_sco_costos_articulos_Ncostos_articulo">
<input type="<?= $Page->Ncostos_articulo->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Ncostos_articulo" id="x<?= $Page->RowIndex ?>_Ncostos_articulo" data-table="sco_costos_articulos" data-field="x_Ncostos_articulo" value="<?= $Page->Ncostos_articulo->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Ncostos_articulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Ncostos_articulo->formatPattern()) ?>"<?= $Page->Ncostos_articulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Ncostos_articulo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_Ncostos_articulo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Ncostos_articulo" id="o<?= $Page->RowIndex ?>_Ncostos_articulo" value="<?= HtmlEncode($Page->Ncostos_articulo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_Ncostos_articulo" class="el_sco_costos_articulos_Ncostos_articulo">
<span<?= $Page->Ncostos_articulo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Ncostos_articulo->getDisplayValue($Page->Ncostos_articulo->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_Ncostos_articulo" data-hidden="1" name="x<?= $Page->RowIndex ?>_Ncostos_articulo" id="x<?= $Page->RowIndex ?>_Ncostos_articulo" value="<?= HtmlEncode($Page->Ncostos_articulo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_Ncostos_articulo" class="el_sco_costos_articulos_Ncostos_articulo">
<span<?= $Page->Ncostos_articulo->viewAttributes() ?>>
<?= $Page->Ncostos_articulo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sco_costos_articulos" data-field="x_Ncostos_articulo" data-hidden="1" name="x<?= $Page->RowIndex ?>_Ncostos_articulo" id="x<?= $Page->RowIndex ?>_Ncostos_articulo" value="<?= HtmlEncode($Page->Ncostos_articulo->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_descripcion" class="el_sco_costos_articulos_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_descripcion" id="x<?= $Page->RowIndex ?>_descripcion" data-table="sco_costos_articulos" data-field="x_descripcion" value="<?= $Page->descripcion->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion->formatPattern()) ?>"<?= $Page->descripcion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_descripcion" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_descripcion" id="o<?= $Page->RowIndex ?>_descripcion" value="<?= HtmlEncode($Page->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_descripcion" class="el_sco_costos_articulos_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->descripcion->getDisplayValue($Page->descripcion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_descripcion" data-hidden="1" name="x<?= $Page->RowIndex ?>_descripcion" id="x<?= $Page->RowIndex ?>_descripcion" value="<?= HtmlEncode($Page->descripcion->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_descripcion" class="el_sco_costos_articulos_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->precio->Visible) { // precio ?>
        <td data-name="precio"<?= $Page->precio->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_precio" class="el_sco_costos_articulos_precio">
<input type="<?= $Page->precio->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_precio" id="x<?= $Page->RowIndex ?>_precio" data-table="sco_costos_articulos" data-field="x_precio" value="<?= $Page->precio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->precio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio->formatPattern()) ?>"<?= $Page->precio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->precio->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_precio" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_precio" id="o<?= $Page->RowIndex ?>_precio" value="<?= HtmlEncode($Page->precio->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_precio" class="el_sco_costos_articulos_precio">
<input type="<?= $Page->precio->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_precio" id="x<?= $Page->RowIndex ?>_precio" data-table="sco_costos_articulos" data-field="x_precio" value="<?= $Page->precio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->precio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio->formatPattern()) ?>"<?= $Page->precio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->precio->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_precio" class="el_sco_costos_articulos_precio">
<span<?= $Page->precio->viewAttributes() ?>>
<?= $Page->precio->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->variacion->Visible) { // variacion ?>
        <td data-name="variacion"<?= $Page->variacion->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_variacion" class="el_sco_costos_articulos_variacion">
<input type="<?= $Page->variacion->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_variacion" id="x<?= $Page->RowIndex ?>_variacion" data-table="sco_costos_articulos" data-field="x_variacion" value="<?= $Page->variacion->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->variacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->variacion->formatPattern()) ?>"<?= $Page->variacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->variacion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_variacion" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_variacion" id="o<?= $Page->RowIndex ?>_variacion" value="<?= HtmlEncode($Page->variacion->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_variacion" class="el_sco_costos_articulos_variacion">
<span<?= $Page->variacion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->variacion->getDisplayValue($Page->variacion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_variacion" data-hidden="1" name="x<?= $Page->RowIndex ?>_variacion" id="x<?= $Page->RowIndex ?>_variacion" value="<?= HtmlEncode($Page->variacion->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_variacion" class="el_sco_costos_articulos_variacion">
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->tipo_hercules->Visible) { // tipo_hercules ?>
        <td data-name="tipo_hercules"<?= $Page->tipo_hercules->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_tipo_hercules" class="el_sco_costos_articulos_tipo_hercules">
    <select
        id="x<?= $Page->RowIndex ?>_tipo_hercules"
        name="x<?= $Page->RowIndex ?>_tipo_hercules"
        class="form-select ew-select<?= $Page->tipo_hercules->isInvalidClass() ?>"
        <?php if (!$Page->tipo_hercules->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo_hercules"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_tipo_hercules"
        data-value-separator="<?= $Page->tipo_hercules->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_hercules->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo_hercules->editAttributes() ?>>
        <?= $Page->tipo_hercules->selectOptionListHtml("x{$Page->RowIndex}_tipo_hercules") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo_hercules->getErrorMessage() ?></div>
<?= $Page->tipo_hercules->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_tipo_hercules") ?>
<?php if (!$Page->tipo_hercules->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_tipo_hercules", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo_hercules" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.tipo_hercules?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_tipo_hercules", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_tipo_hercules", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.tipo_hercules.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_tipo_hercules" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_tipo_hercules" id="o<?= $Page->RowIndex ?>_tipo_hercules" value="<?= HtmlEncode($Page->tipo_hercules->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_tipo_hercules" class="el_sco_costos_articulos_tipo_hercules">
    <select
        id="x<?= $Page->RowIndex ?>_tipo_hercules"
        name="x<?= $Page->RowIndex ?>_tipo_hercules"
        class="form-select ew-select<?= $Page->tipo_hercules->isInvalidClass() ?>"
        <?php if (!$Page->tipo_hercules->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo_hercules"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_tipo_hercules"
        data-value-separator="<?= $Page->tipo_hercules->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_hercules->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo_hercules->editAttributes() ?>>
        <?= $Page->tipo_hercules->selectOptionListHtml("x{$Page->RowIndex}_tipo_hercules") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo_hercules->getErrorMessage() ?></div>
<?= $Page->tipo_hercules->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_tipo_hercules") ?>
<?php if (!$Page->tipo_hercules->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_tipo_hercules", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo_hercules" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.tipo_hercules?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_tipo_hercules", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_tipo_hercules", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.tipo_hercules.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_tipo_hercules" class="el_sco_costos_articulos_tipo_hercules">
<span<?= $Page->tipo_hercules->viewAttributes() ?>>
<?= $Page->tipo_hercules->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->articulo_hercules->Visible) { // articulo_hercules ?>
        <td data-name="articulo_hercules"<?= $Page->articulo_hercules->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_articulo_hercules" class="el_sco_costos_articulos_articulo_hercules">
    <select
        id="x<?= $Page->RowIndex ?>_articulo_hercules"
        name="x<?= $Page->RowIndex ?>_articulo_hercules"
        class="form-select ew-select<?= $Page->articulo_hercules->isInvalidClass() ?>"
        <?php if (!$Page->articulo_hercules->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_articulo_hercules"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_articulo_hercules"
        data-value-separator="<?= $Page->articulo_hercules->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo_hercules->getPlaceHolder()) ?>"
        <?= $Page->articulo_hercules->editAttributes() ?>>
        <?= $Page->articulo_hercules->selectOptionListHtml("x{$Page->RowIndex}_articulo_hercules") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->articulo_hercules->getErrorMessage() ?></div>
<?= $Page->articulo_hercules->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_articulo_hercules") ?>
<?php if (!$Page->articulo_hercules->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_articulo_hercules", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_articulo_hercules" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.articulo_hercules?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_articulo_hercules", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_articulo_hercules", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.articulo_hercules.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_articulo_hercules" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_articulo_hercules" id="o<?= $Page->RowIndex ?>_articulo_hercules" value="<?= HtmlEncode($Page->articulo_hercules->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_articulo_hercules" class="el_sco_costos_articulos_articulo_hercules">
    <select
        id="x<?= $Page->RowIndex ?>_articulo_hercules"
        name="x<?= $Page->RowIndex ?>_articulo_hercules"
        class="form-select ew-select<?= $Page->articulo_hercules->isInvalidClass() ?>"
        <?php if (!$Page->articulo_hercules->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_articulo_hercules"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_articulo_hercules"
        data-value-separator="<?= $Page->articulo_hercules->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo_hercules->getPlaceHolder()) ?>"
        <?= $Page->articulo_hercules->editAttributes() ?>>
        <?= $Page->articulo_hercules->selectOptionListHtml("x{$Page->RowIndex}_articulo_hercules") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->articulo_hercules->getErrorMessage() ?></div>
<?= $Page->articulo_hercules->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_articulo_hercules") ?>
<?php if (!$Page->articulo_hercules->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_articulo_hercules", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_articulo_hercules" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.articulo_hercules?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_articulo_hercules", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_articulo_hercules", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.articulo_hercules.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_articulos_articulo_hercules" class="el_sco_costos_articulos_articulo_hercules">
<span<?= $Page->articulo_hercules->viewAttributes() ?>>
<?= $Page->articulo_hercules->getViewValue() ?></span>
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
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
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
    ew.addEventHandlers("sco_costos_articulos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
