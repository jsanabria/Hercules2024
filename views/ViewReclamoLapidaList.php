<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewReclamoLapidaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_reclamo_lapida: currentTable } });
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
<form name="fview_reclamo_lapidasrch" id="fview_reclamo_lapidasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_reclamo_lapidasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_reclamo_lapida: currentTable } });
var currentForm;
var fview_reclamo_lapidasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_reclamo_lapidasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["registra", [], fields.registra.isInvalid]
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
            "registra": <?= $Page->registra->toClientList($Page) ?>,
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
<?php if ($Page->registra->Visible) { // registra ?>
<?php
if (!$Page->registra->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_registra" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->registra->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_registra" class="ew-search-caption ew-label"><?= $Page->registra->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_registra" id="z_registra" value="=">
</div>
        </div>
        <div id="el_view_reclamo_lapida_registra" class="ew-search-field">
    <select
        id="x_registra"
        name="x_registra"
        class="form-select ew-select<?= $Page->registra->isInvalidClass() ?>"
        <?php if (!$Page->registra->IsNativeSelect) { ?>
        data-select2-id="fview_reclamo_lapidasrch_x_registra"
        <?php } ?>
        data-table="view_reclamo_lapida"
        data-field="x_registra"
        data-value-separator="<?= $Page->registra->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->registra->getPlaceHolder()) ?>"
        <?= $Page->registra->editAttributes() ?>>
        <?= $Page->registra->selectOptionListHtml("x_registra") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->registra->getErrorMessage(false) ?></div>
<?= $Page->registra->Lookup->getParamTag($Page, "p_x_registra") ?>
<?php if (!$Page->registra->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_reclamo_lapidasrch", function() {
    var options = { name: "x_registra", selectId: "fview_reclamo_lapidasrch_x_registra" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_reclamo_lapidasrch.lists.registra?.lookupOptions.length) {
        options.data = { id: "x_registra", form: "fview_reclamo_lapidasrch" };
    } else {
        options.ajax = { id: "x_registra", form: "fview_reclamo_lapidasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_reclamo_lapida.fields.registra.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_reclamo_lapidasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_reclamo_lapidasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_reclamo_lapidasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_reclamo_lapidasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_reclamo_lapida">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_reclamo_lapida" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_reclamo_lapidalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nreclamo->Visible) { // Nreclamo ?>
        <th data-name="Nreclamo" class="<?= $Page->Nreclamo->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_Nreclamo" class="view_reclamo_lapida_Nreclamo"><?= $Page->renderFieldHeader($Page->Nreclamo) ?></div></th>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
        <th data-name="solicitante" class="<?= $Page->solicitante->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_solicitante" class="view_reclamo_lapida_solicitante"><?= $Page->renderFieldHeader($Page->solicitante) ?></div></th>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <th data-name="ci_difunto" class="<?= $Page->ci_difunto->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_ci_difunto" class="view_reclamo_lapida_ci_difunto"><?= $Page->renderFieldHeader($Page->ci_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
        <th data-name="nombre_difunto" class="<?= $Page->nombre_difunto->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_nombre_difunto" class="view_reclamo_lapida_nombre_difunto"><?= $Page->renderFieldHeader($Page->nombre_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Page->tipo->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_tipo" class="view_reclamo_lapida_tipo"><?= $Page->renderFieldHeader($Page->tipo) ?></div></th>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
        <th data-name="registro" class="<?= $Page->registro->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_registro" class="view_reclamo_lapida_registro"><?= $Page->renderFieldHeader($Page->registro) ?></div></th>
<?php } ?>
<?php if ($Page->registra->Visible) { // registra ?>
        <th data-name="registra" class="<?= $Page->registra->headerCellClass() ?>"><div id="elh_view_reclamo_lapida_registra" class="view_reclamo_lapida_registra"><?= $Page->renderFieldHeader($Page->registra) ?></div></th>
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
    <?php if ($Page->Nreclamo->Visible) { // Nreclamo ?>
        <td data-name="Nreclamo"<?= $Page->Nreclamo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_Nreclamo" class="el_view_reclamo_lapida_Nreclamo">
<span<?= $Page->Nreclamo->viewAttributes() ?>>
<?= $Page->Nreclamo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->solicitante->Visible) { // solicitante ?>
        <td data-name="solicitante"<?= $Page->solicitante->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_solicitante" class="el_view_reclamo_lapida_solicitante">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_ci_difunto" class="el_view_reclamo_lapida_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
        <td data-name="nombre_difunto"<?= $Page->nombre_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_nombre_difunto" class="el_view_reclamo_lapida_nombre_difunto">
<span<?= $Page->nombre_difunto->viewAttributes() ?>>
<?= $Page->nombre_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_tipo" class="el_view_reclamo_lapida_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->registro->Visible) { // registro ?>
        <td data-name="registro"<?= $Page->registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_registro" class="el_view_reclamo_lapida_registro">
<span<?= $Page->registro->viewAttributes() ?>>
<?= $Page->registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->registra->Visible) { // registra ?>
        <td data-name="registra"<?= $Page->registra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_reclamo_lapida_registra" class="el_view_reclamo_lapida_registra">
<span<?= $Page->registra->viewAttributes() ?>>
<?= $Page->registra->getViewValue() ?></span>
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
    ew.addEventHandlers("view_reclamo_lapida");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
