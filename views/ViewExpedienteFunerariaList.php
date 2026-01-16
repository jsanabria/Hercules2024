<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewExpedienteFunerariaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente_funeraria: currentTable } });
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
<form name="fview_expediente_funerariasrch" id="fview_expediente_funerariasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_expediente_funerariasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente_funeraria: currentTable } });
var currentForm;
var fview_expediente_funerariasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_expediente_funerariasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["expediente", [ew.Validators.integer], fields.expediente.isInvalid],
            ["servicio", [], fields.servicio.isInvalid],
            ["cedula_fallecido", [], fields.cedula_fallecido.isInvalid],
            ["funeraria", [], fields.funeraria.isInvalid]
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
            "funeraria": <?= $Page->funeraria->toClientList($Page) ?>,
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
<?php if ($Page->expediente->Visible) { // expediente ?>
<?php
if (!$Page->expediente->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expediente" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->expediente->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_expediente" class="ew-search-caption ew-label"><?= $Page->expediente->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_expediente" id="z_expediente" value="=">
</div>
        </div>
        <div id="el_view_expediente_funeraria_expediente" class="ew-search-field">
<input type="<?= $Page->expediente->getInputTextType() ?>" name="x_expediente" id="x_expediente" data-table="view_expediente_funeraria" data-field="x_expediente" value="<?= $Page->expediente->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->expediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->expediente->formatPattern()) ?>"<?= $Page->expediente->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->expediente->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
<?php
if (!$Page->servicio->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_servicio" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->servicio->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_servicio" class="ew-search-caption ew-label"><?= $Page->servicio->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_servicio" id="z_servicio" value="LIKE">
</div>
        </div>
        <div id="el_view_expediente_funeraria_servicio" class="ew-search-field">
<input type="<?= $Page->servicio->getInputTextType() ?>" name="x_servicio" id="x_servicio" data-table="view_expediente_funeraria" data-field="x_servicio" value="<?= $Page->servicio->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->servicio->formatPattern()) ?>"<?= $Page->servicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->servicio->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
<?php
if (!$Page->cedula_fallecido->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cedula_fallecido" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cedula_fallecido->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cedula_fallecido" class="ew-search-caption ew-label"><?= $Page->cedula_fallecido->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_cedula_fallecido" id="z_cedula_fallecido" value="LIKE">
</div>
        </div>
        <div id="el_view_expediente_funeraria_cedula_fallecido" class="ew-search-field">
<input type="<?= $Page->cedula_fallecido->getInputTextType() ?>" name="x_cedula_fallecido" id="x_cedula_fallecido" data-table="view_expediente_funeraria" data-field="x_cedula_fallecido" value="<?= $Page->cedula_fallecido->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_fallecido->formatPattern()) ?>"<?= $Page->cedula_fallecido->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cedula_fallecido->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
<?php
if (!$Page->funeraria->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_funeraria" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->funeraria->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_funeraria" class="ew-search-caption ew-label"><?= $Page->funeraria->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_funeraria" id="z_funeraria" value="=">
</div>
        </div>
        <div id="el_view_expediente_funeraria_funeraria" class="ew-search-field">
    <select
        id="x_funeraria"
        name="x_funeraria"
        class="form-control ew-select<?= $Page->funeraria->isInvalidClass() ?>"
        data-select2-id="fview_expediente_funerariasrch_x_funeraria"
        data-table="view_expediente_funeraria"
        data-field="x_funeraria"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->funeraria->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->funeraria->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->funeraria->getPlaceHolder()) ?>"
        <?= $Page->funeraria->editAttributes() ?>>
        <?= $Page->funeraria->selectOptionListHtml("x_funeraria") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->funeraria->getErrorMessage(false) ?></div>
<?= $Page->funeraria->Lookup->getParamTag($Page, "p_x_funeraria") ?>
<script>
loadjs.ready("fview_expediente_funerariasrch", function() {
    var options = { name: "x_funeraria", selectId: "fview_expediente_funerariasrch_x_funeraria" };
    if (fview_expediente_funerariasrch.lists.funeraria?.lookupOptions.length) {
        options.data = { id: "x_funeraria", form: "fview_expediente_funerariasrch" };
    } else {
        options.ajax = { id: "x_funeraria", form: "fview_expediente_funerariasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.view_expediente_funeraria.fields.funeraria.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_expediente_funerariasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_expediente_funerariasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_expediente_funerariasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_expediente_funerariasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_expediente_funeraria">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_expediente_funeraria" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_expediente_funerarialist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->expediente->Visible) { // expediente ?>
        <th data-name="expediente" class="<?= $Page->expediente->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_expediente" class="view_expediente_funeraria_expediente"><?= $Page->renderFieldHeader($Page->expediente) ?></div></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Page->servicio->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_servicio" class="view_expediente_funeraria_servicio"><?= $Page->renderFieldHeader($Page->servicio) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th data-name="cedula_fallecido" class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_cedula_fallecido" class="view_expediente_funeraria_cedula_fallecido"><?= $Page->renderFieldHeader($Page->cedula_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th data-name="nombre_fallecido" class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_nombre_fallecido" class="view_expediente_funeraria_nombre_fallecido"><?= $Page->renderFieldHeader($Page->nombre_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th data-name="apellidos_fallecido" class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_apellidos_fallecido" class="view_expediente_funeraria_apellidos_fallecido"><?= $Page->renderFieldHeader($Page->apellidos_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <th data-name="causa_ocurrencia" class="<?= $Page->causa_ocurrencia->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_causa_ocurrencia" class="view_expediente_funeraria_causa_ocurrencia"><?= $Page->renderFieldHeader($Page->causa_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
        <th data-name="fecha_servicio" class="<?= $Page->fecha_servicio->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_fecha_servicio" class="view_expediente_funeraria_fecha_servicio"><?= $Page->renderFieldHeader($Page->fecha_servicio) ?></div></th>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <th data-name="hora_fin" class="<?= $Page->hora_fin->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_hora_fin" class="view_expediente_funeraria_hora_fin"><?= $Page->renderFieldHeader($Page->hora_fin) ?></div></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th data-name="funeraria" class="<?= $Page->funeraria->headerCellClass() ?>"><div id="elh_view_expediente_funeraria_funeraria" class="view_expediente_funeraria_funeraria"><?= $Page->renderFieldHeader($Page->funeraria) ?></div></th>
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
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->expediente->Visible) { // expediente ?>
        <td data-name="expediente"<?= $Page->expediente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_expediente" class="el_view_expediente_funeraria_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_servicio" class="el_view_expediente_funeraria_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_cedula_fallecido" class="el_view_expediente_funeraria_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_nombre_fallecido" class="el_view_expediente_funeraria_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_apellidos_fallecido" class="el_view_expediente_funeraria_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_causa_ocurrencia" class="el_view_expediente_funeraria_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
        <td data-name="fecha_servicio"<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_fecha_servicio" class="el_view_expediente_funeraria_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<?= $Page->fecha_servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <td data-name="hora_fin"<?= $Page->hora_fin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_hora_fin" class="el_view_expediente_funeraria_hora_fin">
<span<?= $Page->hora_fin->viewAttributes() ?>>
<?= $Page->hora_fin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->funeraria->Visible) { // funeraria ?>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_funeraria_funeraria" class="el_view_expediente_funeraria_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

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
    ew.addEventHandlers("view_expediente_funeraria");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
