<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionPlantillasList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_plantillas: currentTable } });
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
<form name="fautogestion_plantillassrch" id="fautogestion_plantillassrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fautogestion_plantillassrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_plantillas: currentTable } });
var currentForm;
var fautogestion_plantillassrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fautogestion_plantillassrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["servicio_tipo", [], fields.servicio_tipo.isInvalid],
            ["script", [], fields.script.isInvalid],
            ["nivel", [], fields.nivel.isInvalid],
            ["mostrar", [], fields.mostrar.isInvalid]
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
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "nivel": <?= $Page->nivel->toClientList($Page) ?>,
            "mostrar": <?= $Page->mostrar->toClientList($Page) ?>,
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
<?php
if (!$Page->servicio_tipo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_servicio_tipo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->servicio_tipo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_servicio_tipo" class="ew-search-caption ew-label"><?= $Page->servicio_tipo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_servicio_tipo" id="z_servicio_tipo" value="=">
</div>
        </div>
        <div id="el_autogestion_plantillas_servicio_tipo" class="ew-search-field">
    <select
        id="x_servicio_tipo"
        name="x_servicio_tipo"
        class="form-select ew-select<?= $Page->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fautogestion_plantillassrch_x_servicio_tipo"
        <?php } ?>
        data-table="autogestion_plantillas"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Page->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_tipo->getPlaceHolder()) ?>"
        <?= $Page->servicio_tipo->editAttributes() ?>>
        <?= $Page->servicio_tipo->selectOptionListHtml("x_servicio_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->servicio_tipo->getErrorMessage(false) ?></div>
<?= $Page->servicio_tipo->Lookup->getParamTag($Page, "p_x_servicio_tipo") ?>
<?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_plantillassrch", function() {
    var options = { name: "x_servicio_tipo", selectId: "fautogestion_plantillassrch_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_plantillassrch.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fautogestion_plantillassrch" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fautogestion_plantillassrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_plantillas.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
<?php
if (!$Page->script->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_script" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->script->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_script" class="ew-search-caption ew-label"><?= $Page->script->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_script" id="z_script" value="LIKE">
</div>
        </div>
        <div id="el_autogestion_plantillas_script" class="ew-search-field">
<input type="<?= $Page->script->getInputTextType() ?>" name="x_script" id="x_script" data-table="autogestion_plantillas" data-field="x_script" value="<?= $Page->script->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->script->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->script->formatPattern()) ?>"<?= $Page->script->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->script->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
<?php
if (!$Page->nivel->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_nivel" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->nivel->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_nivel" class="ew-search-caption ew-label"><?= $Page->nivel->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_nivel" id="z_nivel" value="=">
</div>
        </div>
        <div id="el_autogestion_plantillas_nivel" class="ew-search-field">
    <select
        id="x_nivel"
        name="x_nivel"
        class="form-select ew-select<?= $Page->nivel->isInvalidClass() ?>"
        <?php if (!$Page->nivel->IsNativeSelect) { ?>
        data-select2-id="fautogestion_plantillassrch_x_nivel"
        <?php } ?>
        data-table="autogestion_plantillas"
        data-field="x_nivel"
        data-value-separator="<?= $Page->nivel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nivel->getPlaceHolder()) ?>"
        <?= $Page->nivel->editAttributes() ?>>
        <?= $Page->nivel->selectOptionListHtml("x_nivel") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->nivel->getErrorMessage(false) ?></div>
<?php if (!$Page->nivel->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_plantillassrch", function() {
    var options = { name: "x_nivel", selectId: "fautogestion_plantillassrch_x_nivel" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_plantillassrch.lists.nivel?.lookupOptions.length) {
        options.data = { id: "x_nivel", form: "fautogestion_plantillassrch" };
    } else {
        options.ajax = { id: "x_nivel", form: "fautogestion_plantillassrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_plantillas.fields.nivel.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->mostrar->Visible) { // mostrar ?>
<?php
if (!$Page->mostrar->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_mostrar" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->mostrar->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->mostrar->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_mostrar" id="z_mostrar" value="=">
</div>
        </div>
        <div id="el_autogestion_plantillas_mostrar" class="ew-search-field">
<template id="tp_x_mostrar">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="autogestion_plantillas" data-field="x_mostrar" name="x_mostrar" id="x_mostrar"<?= $Page->mostrar->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_mostrar" class="ew-item-list"></div>
<selection-list hidden
    id="x_mostrar"
    name="x_mostrar"
    value="<?= HtmlEncode($Page->mostrar->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_mostrar"
    data-target="dsl_x_mostrar"
    data-repeatcolumn="0"
    class="form-control<?= $Page->mostrar->isInvalidClass() ?>"
    data-table="autogestion_plantillas"
    data-field="x_mostrar"
    data-value-separator="<?= $Page->mostrar->displayValueSeparatorAttribute() ?>"
    <?= $Page->mostrar->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->mostrar->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fautogestion_plantillassrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fautogestion_plantillassrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fautogestion_plantillassrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fautogestion_plantillassrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="autogestion_plantillas">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_autogestion_plantillas" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_autogestion_plantillaslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th data-name="servicio_tipo" class="<?= $Page->servicio_tipo->headerCellClass() ?>"><div id="elh_autogestion_plantillas_servicio_tipo" class="autogestion_plantillas_servicio_tipo"><?= $Page->renderFieldHeader($Page->servicio_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
        <th data-name="script" class="<?= $Page->script->headerCellClass() ?>"><div id="elh_autogestion_plantillas_script" class="autogestion_plantillas_script"><?= $Page->renderFieldHeader($Page->script) ?></div></th>
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
        <th data-name="nivel" class="<?= $Page->nivel->headerCellClass() ?>"><div id="elh_autogestion_plantillas_nivel" class="autogestion_plantillas_nivel"><?= $Page->renderFieldHeader($Page->nivel) ?></div></th>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
        <th data-name="orden" class="<?= $Page->orden->headerCellClass() ?>"><div id="elh_autogestion_plantillas_orden" class="autogestion_plantillas_orden"><?= $Page->renderFieldHeader($Page->orden) ?></div></th>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <th data-name="codigo" class="<?= $Page->codigo->headerCellClass() ?>"><div id="elh_autogestion_plantillas_codigo" class="autogestion_plantillas_codigo"><?= $Page->renderFieldHeader($Page->codigo) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th data-name="descripcion" class="<?= $Page->descripcion->headerCellClass() ?>"><div id="elh_autogestion_plantillas_descripcion" class="autogestion_plantillas_descripcion"><?= $Page->renderFieldHeader($Page->descripcion) ?></div></th>
<?php } ?>
<?php if ($Page->mostrar->Visible) { // mostrar ?>
        <th data-name="mostrar" class="<?= $Page->mostrar->headerCellClass() ?>"><div id="elh_autogestion_plantillas_mostrar" class="autogestion_plantillas_mostrar"><?= $Page->renderFieldHeader($Page->mostrar) ?></div></th>
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
    <?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_servicio_tipo" class="el_autogestion_plantillas_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->script->Visible) { // script ?>
        <td data-name="script"<?= $Page->script->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_script" class="el_autogestion_plantillas_script">
<span<?= $Page->script->viewAttributes() ?>>
<?= $Page->script->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nivel->Visible) { // nivel ?>
        <td data-name="nivel"<?= $Page->nivel->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_nivel" class="el_autogestion_plantillas_nivel">
<span<?= $Page->nivel->viewAttributes() ?>>
<?= $Page->nivel->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->orden->Visible) { // orden ?>
        <td data-name="orden"<?= $Page->orden->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_orden" class="el_autogestion_plantillas_orden">
<span<?= $Page->orden->viewAttributes() ?>>
<?= $Page->orden->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->codigo->Visible) { // codigo ?>
        <td data-name="codigo"<?= $Page->codigo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_codigo" class="el_autogestion_plantillas_codigo">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td data-name="descripcion"<?= $Page->descripcion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_descripcion" class="el_autogestion_plantillas_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->mostrar->Visible) { // mostrar ?>
        <td data-name="mostrar"<?= $Page->mostrar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_plantillas_mostrar" class="el_autogestion_plantillas_mostrar">
<span<?= $Page->mostrar->viewAttributes() ?>>
<?= $Page->mostrar->getViewValue() ?></span>
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
    ew.addEventHandlers("autogestion_plantillas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
