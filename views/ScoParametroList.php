<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParametroList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parametro: currentTable } });
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
<form name="fsco_parametrosrch" id="fsco_parametrosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_parametrosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parametro: currentTable } });
var currentForm;
var fsco_parametrosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_parametrosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["codigo", [], fields.codigo.isInvalid],
            ["descripcion", [], fields.descripcion.isInvalid]
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
            "codigo": <?= $Page->codigo->toClientList($Page) ?>,
            "descripcion": <?= $Page->descripcion->toClientList($Page) ?>,
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
<?php if ($Page->codigo->Visible) { // codigo ?>
<?php
if (!$Page->codigo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_codigo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->codigo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_codigo" class="ew-search-caption ew-label"><?= $Page->codigo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_codigo" id="z_codigo" value="=">
</div>
        </div>
        <div id="el_sco_parametro_codigo" class="ew-search-field">
    <select
        id="x_codigo"
        name="x_codigo"
        class="form-select ew-select<?= $Page->codigo->isInvalidClass() ?>"
        <?php if (!$Page->codigo->IsNativeSelect) { ?>
        data-select2-id="fsco_parametrosrch_x_codigo"
        <?php } ?>
        data-table="sco_parametro"
        data-field="x_codigo"
        data-value-separator="<?= $Page->codigo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codigo->getPlaceHolder()) ?>"
        <?= $Page->codigo->editAttributes() ?>>
        <?= $Page->codigo->selectOptionListHtml("x_codigo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->codigo->getErrorMessage(false) ?></div>
<?= $Page->codigo->Lookup->getParamTag($Page, "p_x_codigo") ?>
<?php if (!$Page->codigo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_parametrosrch", function() {
    var options = { name: "x_codigo", selectId: "fsco_parametrosrch_x_codigo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_parametrosrch.lists.codigo?.lookupOptions.length) {
        options.data = { id: "x_codigo", form: "fsco_parametrosrch" };
    } else {
        options.ajax = { id: "x_codigo", form: "fsco_parametrosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_parametro.fields.codigo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
<?php
if (!$Page->descripcion->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_descripcion" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->descripcion->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_descripcion" class="ew-search-caption ew-label"><?= $Page->descripcion->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_descripcion" id="z_descripcion" value="=">
</div>
        </div>
        <div id="el_sco_parametro_descripcion" class="ew-search-field">
    <select
        id="x_descripcion"
        name="x_descripcion"
        class="form-select ew-select<?= $Page->descripcion->isInvalidClass() ?>"
        <?php if (!$Page->descripcion->IsNativeSelect) { ?>
        data-select2-id="fsco_parametrosrch_x_descripcion"
        <?php } ?>
        data-table="sco_parametro"
        data-field="x_descripcion"
        data-value-separator="<?= $Page->descripcion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>"
        <?= $Page->descripcion->editAttributes() ?>>
        <?= $Page->descripcion->selectOptionListHtml("x_descripcion") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage(false) ?></div>
<?= $Page->descripcion->Lookup->getParamTag($Page, "p_x_descripcion") ?>
<?php if (!$Page->descripcion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_parametrosrch", function() {
    var options = { name: "x_descripcion", selectId: "fsco_parametrosrch_x_descripcion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_parametrosrch.lists.descripcion?.lookupOptions.length) {
        options.data = { id: "x_descripcion", form: "fsco_parametrosrch" };
    } else {
        options.ajax = { id: "x_descripcion", form: "fsco_parametrosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_parametro.fields.descripcion.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_parametrosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_parametrosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_parametrosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_parametrosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_parametro">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_parametro" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_parametrolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nparametro->Visible) { // Nparametro ?>
        <th data-name="Nparametro" class="<?= $Page->Nparametro->headerCellClass() ?>"><div id="elh_sco_parametro_Nparametro" class="sco_parametro_Nparametro"><?= $Page->renderFieldHeader($Page->Nparametro) ?></div></th>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <th data-name="codigo" class="<?= $Page->codigo->headerCellClass() ?>"><div id="elh_sco_parametro_codigo" class="sco_parametro_codigo"><?= $Page->renderFieldHeader($Page->codigo) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th data-name="descripcion" class="<?= $Page->descripcion->headerCellClass() ?>"><div id="elh_sco_parametro_descripcion" class="sco_parametro_descripcion"><?= $Page->renderFieldHeader($Page->descripcion) ?></div></th>
<?php } ?>
<?php if ($Page->valor1->Visible) { // valor1 ?>
        <th data-name="valor1" class="<?= $Page->valor1->headerCellClass() ?>"><div id="elh_sco_parametro_valor1" class="sco_parametro_valor1"><?= $Page->renderFieldHeader($Page->valor1) ?></div></th>
<?php } ?>
<?php if ($Page->valor2->Visible) { // valor2 ?>
        <th data-name="valor2" class="<?= $Page->valor2->headerCellClass() ?>"><div id="elh_sco_parametro_valor2" class="sco_parametro_valor2"><?= $Page->renderFieldHeader($Page->valor2) ?></div></th>
<?php } ?>
<?php if ($Page->valor3->Visible) { // valor3 ?>
        <th data-name="valor3" class="<?= $Page->valor3->headerCellClass() ?>"><div id="elh_sco_parametro_valor3" class="sco_parametro_valor3"><?= $Page->renderFieldHeader($Page->valor3) ?></div></th>
<?php } ?>
<?php if ($Page->valor4->Visible) { // valor4 ?>
        <th data-name="valor4" class="<?= $Page->valor4->headerCellClass() ?>"><div id="elh_sco_parametro_valor4" class="sco_parametro_valor4"><?= $Page->renderFieldHeader($Page->valor4) ?></div></th>
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
    <?php if ($Page->Nparametro->Visible) { // Nparametro ?>
        <td data-name="Nparametro"<?= $Page->Nparametro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_Nparametro" class="el_sco_parametro_Nparametro">
<span<?= $Page->Nparametro->viewAttributes() ?>>
<?= $Page->Nparametro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codigo->Visible) { // codigo ?>
        <td data-name="codigo"<?= $Page->codigo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_codigo" class="el_sco_parametro_codigo">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_descripcion" class="el_sco_parametro_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor1->Visible) { // valor1 ?>
        <td data-name="valor1"<?= $Page->valor1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_valor1" class="el_sco_parametro_valor1">
<span<?= $Page->valor1->viewAttributes() ?>>
<?= $Page->valor1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor2->Visible) { // valor2 ?>
        <td data-name="valor2"<?= $Page->valor2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_valor2" class="el_sco_parametro_valor2">
<span<?= $Page->valor2->viewAttributes() ?>>
<?= $Page->valor2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor3->Visible) { // valor3 ?>
        <td data-name="valor3"<?= $Page->valor3->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_valor3" class="el_sco_parametro_valor3">
<span<?= $Page->valor3->viewAttributes() ?>>
<?= $Page->valor3->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->valor4->Visible) { // valor4 ?>
        <td data-name="valor4"<?= $Page->valor4->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parametro_valor4" class="el_sco_parametro_valor4">
<span<?= $Page->valor4->viewAttributes() ?>>
<?= $Page->valor4->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_parametro");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
