<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaVentasList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela_ventas: currentTable } });
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
<form name="fsco_parcela_ventassrch" id="fsco_parcela_ventassrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_parcela_ventassrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela_ventas: currentTable } });
var currentForm;
var fsco_parcela_ventassrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_parcela_ventassrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["Nparcela_ventas", [ew.Validators.integer], fields.Nparcela_ventas.isInvalid],
            ["seccion", [], fields.seccion.isInvalid],
            ["modulo", [], fields.modulo.isInvalid],
            ["subseccion", [], fields.subseccion.isInvalid],
            ["parcela", [], fields.parcela.isInvalid],
            ["estatus", [], fields.estatus.isInvalid]
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
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
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
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
<?php
if (!$Page->Nparcela_ventas->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Nparcela_ventas" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Nparcela_ventas->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_Nparcela_ventas" class="ew-search-caption ew-label"><?= $Page->Nparcela_ventas->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Nparcela_ventas" id="z_Nparcela_ventas" value="=">
</div>
        </div>
        <div id="el_sco_parcela_ventas_Nparcela_ventas" class="ew-search-field">
<input type="<?= $Page->Nparcela_ventas->getInputTextType() ?>" name="x_Nparcela_ventas" id="x_Nparcela_ventas" data-table="sco_parcela_ventas" data-field="x_Nparcela_ventas" value="<?= $Page->Nparcela_ventas->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Nparcela_ventas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nparcela_ventas->formatPattern()) ?>"<?= $Page->Nparcela_ventas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nparcela_ventas->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
<?php
if (!$Page->seccion->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_seccion" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->seccion->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_seccion" class="ew-search-caption ew-label"><?= $Page->seccion->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_seccion" id="z_seccion" value="LIKE">
</div>
        </div>
        <div id="el_sco_parcela_ventas_seccion" class="ew-search-field">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="sco_parcela_ventas" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->seccion->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
<?php
if (!$Page->modulo->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_modulo" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->modulo->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_modulo" class="ew-search-caption ew-label"><?= $Page->modulo->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_modulo" id="z_modulo" value="LIKE">
</div>
        </div>
        <div id="el_sco_parcela_ventas_modulo" class="ew-search-field">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="sco_parcela_ventas" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
<?php
if (!$Page->subseccion->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_subseccion" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->subseccion->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_subseccion" class="ew-search-caption ew-label"><?= $Page->subseccion->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_subseccion" id="z_subseccion" value="LIKE">
</div>
        </div>
        <div id="el_sco_parcela_ventas_subseccion" class="ew-search-field">
<input type="<?= $Page->subseccion->getInputTextType() ?>" name="x_subseccion" id="x_subseccion" data-table="sco_parcela_ventas" data-field="x_subseccion" value="<?= $Page->subseccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->subseccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->subseccion->formatPattern()) ?>"<?= $Page->subseccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->subseccion->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
<?php
if (!$Page->parcela->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_parcela" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->parcela->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_parcela" class="ew-search-caption ew-label"><?= $Page->parcela->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_parcela" id="z_parcela" value="LIKE">
</div>
        </div>
        <div id="el_sco_parcela_ventas_parcela" class="ew-search-field">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_parcela_ventas" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
<?php
if (!$Page->estatus->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_estatus" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->estatus->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_estatus" class="ew-search-caption ew-label"><?= $Page->estatus->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_estatus" id="z_estatus" value="LIKE">
</div>
        </div>
        <div id="el_sco_parcela_ventas_estatus" class="ew-search-field">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_parcela_ventassrch_x_estatus"
        <?php } ?>
        data-table="sco_parcela_ventas"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage(false) ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_parcela_ventassrch", function() {
    var options = { name: "x_estatus", selectId: "fsco_parcela_ventassrch_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_parcela_ventassrch.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_parcela_ventassrch" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_parcela_ventassrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_parcela_ventas.fields.estatus.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_parcela_ventassrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_parcela_ventassrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_parcela_ventassrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_parcela_ventassrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_parcela_ventas">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_parcela_ventas" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_parcela_ventaslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
        <th data-name="Nparcela_ventas" class="<?= $Page->Nparcela_ventas->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_Nparcela_ventas" class="sco_parcela_ventas_Nparcela_ventas"><?= $Page->renderFieldHeader($Page->Nparcela_ventas) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_compra->Visible) { // fecha_compra ?>
        <th data-name="fecha_compra" class="<?= $Page->fecha_compra->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_fecha_compra" class="sco_parcela_ventas_fecha_compra"><?= $Page->renderFieldHeader($Page->fecha_compra) ?></div></th>
<?php } ?>
<?php if ($Page->usuario_compra->Visible) { // usuario_compra ?>
        <th data-name="usuario_compra" class="<?= $Page->usuario_compra->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_usuario_compra" class="sco_parcela_ventas_usuario_compra"><?= $Page->renderFieldHeader($Page->usuario_compra) ?></div></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th data-name="seccion" class="<?= $Page->seccion->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_seccion" class="sco_parcela_ventas_seccion"><?= $Page->renderFieldHeader($Page->seccion) ?></div></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_modulo" class="sco_parcela_ventas_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
        <th data-name="subseccion" class="<?= $Page->subseccion->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_subseccion" class="sco_parcela_ventas_subseccion"><?= $Page->renderFieldHeader($Page->subseccion) ?></div></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Page->parcela->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_parcela" class="sco_parcela_ventas_parcela"><?= $Page->renderFieldHeader($Page->parcela) ?></div></th>
<?php } ?>
<?php if ($Page->vendedor->Visible) { // vendedor ?>
        <th data-name="vendedor" class="<?= $Page->vendedor->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_vendedor" class="sco_parcela_ventas_vendedor"><?= $Page->renderFieldHeader($Page->vendedor) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_estatus" class="sco_parcela_ventas_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_sco_parcela_ventas_fecha_registro" class="sco_parcela_ventas_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
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
    <?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
        <td data-name="Nparcela_ventas"<?= $Page->Nparcela_ventas->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_Nparcela_ventas" class="el_sco_parcela_ventas_Nparcela_ventas">
<span<?= $Page->Nparcela_ventas->viewAttributes() ?>>
<?= $Page->Nparcela_ventas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_compra->Visible) { // fecha_compra ?>
        <td data-name="fecha_compra"<?= $Page->fecha_compra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_fecha_compra" class="el_sco_parcela_ventas_fecha_compra">
<span<?= $Page->fecha_compra->viewAttributes() ?>>
<?= $Page->fecha_compra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->usuario_compra->Visible) { // usuario_compra ?>
        <td data-name="usuario_compra"<?= $Page->usuario_compra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_usuario_compra" class="el_sco_parcela_ventas_usuario_compra">
<span<?= $Page->usuario_compra->viewAttributes() ?>>
<?= $Page->usuario_compra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seccion->Visible) { // seccion ?>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_seccion" class="el_sco_parcela_ventas_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo->Visible) { // modulo ?>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_modulo" class="el_sco_parcela_ventas_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subseccion->Visible) { // subseccion ?>
        <td data-name="subseccion"<?= $Page->subseccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_subseccion" class="el_sco_parcela_ventas_subseccion">
<span<?= $Page->subseccion->viewAttributes() ?>>
<?= $Page->subseccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_parcela" class="el_sco_parcela_ventas_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->vendedor->Visible) { // vendedor ?>
        <td data-name="vendedor"<?= $Page->vendedor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_vendedor" class="el_sco_parcela_ventas_vendedor">
<span<?= $Page->vendedor->viewAttributes() ?>>
<?= $Page->vendedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_estatus" class="el_sco_parcela_ventas_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_parcela_ventas_fecha_registro" class="el_sco_parcela_ventas_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_parcela_ventas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
