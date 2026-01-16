<?php

namespace PHPMaker2024\hercules;

// Page object
$UserlevelsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
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
<form name="fuserlevelssrch" id="fuserlevelssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fuserlevelssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentForm;
var fuserlevelssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fuserlevelssrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["ver_alertas", [], fields.ver_alertas.isInvalid],
            ["financiero", [], fields.financiero.isInvalid]
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
            "ver_alertas": <?= $Page->ver_alertas->toClientList($Page) ?>,
            "financiero": <?= $Page->financiero->toClientList($Page) ?>,
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
<?php if ($Page->ver_alertas->Visible) { // ver_alertas ?>
<?php
if (!$Page->ver_alertas->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_ver_alertas" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->ver_alertas->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_ver_alertas" class="ew-search-caption ew-label"><?= $Page->ver_alertas->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ver_alertas" id="z_ver_alertas" value="=">
</div>
        </div>
        <div id="el_userlevels_ver_alertas" class="ew-search-field">
    <select
        id="x_ver_alertas"
        name="x_ver_alertas"
        class="form-select ew-select<?= $Page->ver_alertas->isInvalidClass() ?>"
        <?php if (!$Page->ver_alertas->IsNativeSelect) { ?>
        data-select2-id="fuserlevelssrch_x_ver_alertas"
        <?php } ?>
        data-table="userlevels"
        data-field="x_ver_alertas"
        data-value-separator="<?= $Page->ver_alertas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ver_alertas->getPlaceHolder()) ?>"
        <?= $Page->ver_alertas->editAttributes() ?>>
        <?= $Page->ver_alertas->selectOptionListHtml("x_ver_alertas") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->ver_alertas->getErrorMessage(false) ?></div>
<?php if (!$Page->ver_alertas->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelssrch", function() {
    var options = { name: "x_ver_alertas", selectId: "fuserlevelssrch_x_ver_alertas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelssrch.lists.ver_alertas?.lookupOptions.length) {
        options.data = { id: "x_ver_alertas", form: "fuserlevelssrch" };
    } else {
        options.ajax = { id: "x_ver_alertas", form: "fuserlevelssrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.ver_alertas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->financiero->Visible) { // financiero ?>
<?php
if (!$Page->financiero->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_financiero" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->financiero->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_financiero" class="ew-search-caption ew-label"><?= $Page->financiero->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_financiero" id="z_financiero" value="=">
</div>
        </div>
        <div id="el_userlevels_financiero" class="ew-search-field">
    <select
        id="x_financiero"
        name="x_financiero"
        class="form-select ew-select<?= $Page->financiero->isInvalidClass() ?>"
        <?php if (!$Page->financiero->IsNativeSelect) { ?>
        data-select2-id="fuserlevelssrch_x_financiero"
        <?php } ?>
        data-table="userlevels"
        data-field="x_financiero"
        data-value-separator="<?= $Page->financiero->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->financiero->getPlaceHolder()) ?>"
        <?= $Page->financiero->editAttributes() ?>>
        <?= $Page->financiero->selectOptionListHtml("x_financiero") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->financiero->getErrorMessage(false) ?></div>
<?php if (!$Page->financiero->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelssrch", function() {
    var options = { name: "x_financiero", selectId: "fuserlevelssrch_x_financiero" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelssrch.lists.financiero?.lookupOptions.length) {
        options.data = { id: "x_financiero", form: "fuserlevelssrch" };
    } else {
        options.ajax = { id: "x_financiero", form: "fuserlevelssrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.financiero.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fuserlevelssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fuserlevelssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fuserlevelssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fuserlevelssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="userlevels">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_userlevels" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_userlevelslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <th data-name="userlevelid" class="<?= $Page->userlevelid->headerCellClass() ?>"><div id="elh_userlevels_userlevelid" class="userlevels_userlevelid"><?= $Page->renderFieldHeader($Page->userlevelid) ?></div></th>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <th data-name="userlevelname" class="<?= $Page->userlevelname->headerCellClass() ?>"><div id="elh_userlevels_userlevelname" class="userlevels_userlevelname"><?= $Page->renderFieldHeader($Page->userlevelname) ?></div></th>
<?php } ?>
<?php if ($Page->indicador->Visible) { // indicador ?>
        <th data-name="indicador" class="<?= $Page->indicador->headerCellClass() ?>"><div id="elh_userlevels_indicador" class="userlevels_indicador"><?= $Page->renderFieldHeader($Page->indicador) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
        <th data-name="tipo_proveedor" class="<?= $Page->tipo_proveedor->headerCellClass() ?>"><div id="elh_userlevels_tipo_proveedor" class="userlevels_tipo_proveedor"><?= $Page->renderFieldHeader($Page->tipo_proveedor) ?></div></th>
<?php } ?>
<?php if ($Page->ver_alertas->Visible) { // ver_alertas ?>
        <th data-name="ver_alertas" class="<?= $Page->ver_alertas->headerCellClass() ?>"><div id="elh_userlevels_ver_alertas" class="userlevels_ver_alertas"><?= $Page->renderFieldHeader($Page->ver_alertas) ?></div></th>
<?php } ?>
<?php if ($Page->financiero->Visible) { // financiero ?>
        <th data-name="financiero" class="<?= $Page->financiero->headerCellClass() ?>"><div id="elh_userlevels_financiero" class="userlevels_financiero"><?= $Page->renderFieldHeader($Page->financiero) ?></div></th>
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
    <?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <td data-name="userlevelid"<?= $Page->userlevelid->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_userlevels_userlevelid" class="el_userlevels_userlevelid">
<span<?= $Page->userlevelid->viewAttributes() ?>>
<?= $Page->userlevelid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <td data-name="userlevelname"<?= $Page->userlevelname->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_userlevels_userlevelname" class="el_userlevels_userlevelname">
<span<?= $Page->userlevelname->viewAttributes() ?>>
<?= $Page->userlevelname->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->indicador->Visible) { // indicador ?>
        <td data-name="indicador"<?= $Page->indicador->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_userlevels_indicador" class="el_userlevels_indicador">
<span<?= $Page->indicador->viewAttributes() ?>>
<?= $Page->indicador->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
        <td data-name="tipo_proveedor"<?= $Page->tipo_proveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_userlevels_tipo_proveedor" class="el_userlevels_tipo_proveedor">
<span<?= $Page->tipo_proveedor->viewAttributes() ?>>
<?= $Page->tipo_proveedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ver_alertas->Visible) { // ver_alertas ?>
        <td data-name="ver_alertas"<?= $Page->ver_alertas->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_userlevels_ver_alertas" class="el_userlevels_ver_alertas">
<span<?= $Page->ver_alertas->viewAttributes() ?>>
<?= $Page->ver_alertas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->financiero->Visible) { // financiero ?>
        <td data-name="financiero"<?= $Page->financiero->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_userlevels_financiero" class="el_userlevels_financiero">
<span<?= $Page->financiero->viewAttributes() ?>>
<?= $Page->financiero->getViewValue() ?></span>
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
    ew.addEventHandlers("userlevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
