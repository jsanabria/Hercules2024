<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteSegurosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_seguros: currentTable } });
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
<form name="fsco_expediente_segurossrch" id="fsco_expediente_segurossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_expediente_segurossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_seguros: currentTable } });
var currentForm;
var fsco_expediente_segurossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_segurossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["seguro", [], fields.seguro.isInvalid],
            ["user_registra", [], fields.user_registra.isInvalid]
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
            "seguro": <?= $Page->seguro->toClientList($Page) ?>,
            "user_registra": <?= $Page->user_registra->toClientList($Page) ?>,
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
<?php if ($Page->seguro->Visible) { // seguro ?>
<?php
if (!$Page->seguro->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_seguro" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->seguro->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_seguro" class="ew-search-caption ew-label"><?= $Page->seguro->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_seguro" id="z_seguro" value="=">
</div>
        </div>
        <div id="el_sco_expediente_seguros_seguro" class="ew-search-field">
    <select
        id="x_seguro"
        name="x_seguro"
        class="form-control ew-select<?= $Page->seguro->isInvalidClass() ?>"
        data-select2-id="fsco_expediente_segurossrch_x_seguro"
        data-table="sco_expediente_seguros"
        data-field="x_seguro"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->seguro->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->seguro->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->seguro->getPlaceHolder()) ?>"
        <?= $Page->seguro->editAttributes() ?>>
        <?= $Page->seguro->selectOptionListHtml("x_seguro") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->seguro->getErrorMessage(false) ?></div>
<?= $Page->seguro->Lookup->getParamTag($Page, "p_x_seguro") ?>
<script>
loadjs.ready("fsco_expediente_segurossrch", function() {
    var options = { name: "x_seguro", selectId: "fsco_expediente_segurossrch_x_seguro" };
    if (fsco_expediente_segurossrch.lists.seguro?.lookupOptions.length) {
        options.data = { id: "x_seguro", form: "fsco_expediente_segurossrch" };
    } else {
        options.ajax = { id: "x_seguro", form: "fsco_expediente_segurossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_expediente_seguros.fields.seguro.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
<?php
if (!$Page->user_registra->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_user_registra" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->user_registra->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_user_registra" class="ew-search-caption ew-label"><?= $Page->user_registra->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_user_registra" id="z_user_registra" value="=">
</div>
        </div>
        <div id="el_sco_expediente_seguros_user_registra" class="ew-search-field">
    <select
        id="x_user_registra"
        name="x_user_registra"
        class="form-control ew-select<?= $Page->user_registra->isInvalidClass() ?>"
        data-select2-id="fsco_expediente_segurossrch_x_user_registra"
        data-table="sco_expediente_seguros"
        data-field="x_user_registra"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->user_registra->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->user_registra->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_registra->getPlaceHolder()) ?>"
        <?= $Page->user_registra->editAttributes() ?>>
        <?= $Page->user_registra->selectOptionListHtml("x_user_registra") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->user_registra->getErrorMessage(false) ?></div>
<?= $Page->user_registra->Lookup->getParamTag($Page, "p_x_user_registra") ?>
<script>
loadjs.ready("fsco_expediente_segurossrch", function() {
    var options = { name: "x_user_registra", selectId: "fsco_expediente_segurossrch_x_user_registra" };
    if (fsco_expediente_segurossrch.lists.user_registra?.lookupOptions.length) {
        options.data = { id: "x_user_registra", form: "fsco_expediente_segurossrch" };
    } else {
        options.ajax = { id: "x_user_registra", form: "fsco_expediente_segurossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_expediente_seguros.fields.user_registra.modalLookupOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_expediente_segurossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_expediente_segurossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_expediente_segurossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_expediente_segurossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_expediente_seguros">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_expediente_seguros" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_expediente_seguroslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->seguro->Visible) { // seguro ?>
        <th data-name="seguro" class="<?= $Page->seguro->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_seguro" class="sco_expediente_seguros_seguro"><?= $Page->renderFieldHeader($Page->seguro) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <th data-name="nombre_contacto" class="<?= $Page->nombre_contacto->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_nombre_contacto" class="sco_expediente_seguros_nombre_contacto"><?= $Page->renderFieldHeader($Page->nombre_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th data-name="cedula_fallecido" class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_cedula_fallecido" class="sco_expediente_seguros_cedula_fallecido"><?= $Page->renderFieldHeader($Page->cedula_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th data-name="nombre_fallecido" class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_nombre_fallecido" class="sco_expediente_seguros_nombre_fallecido"><?= $Page->renderFieldHeader($Page->nombre_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th data-name="apellidos_fallecido" class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_apellidos_fallecido" class="sco_expediente_seguros_apellidos_fallecido"><?= $Page->renderFieldHeader($Page->apellidos_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <th data-name="causa_ocurrencia" class="<?= $Page->causa_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_causa_ocurrencia" class="sco_expediente_seguros_causa_ocurrencia"><?= $Page->renderFieldHeader($Page->causa_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <th data-name="user_registra" class="<?= $Page->user_registra->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_user_registra" class="sco_expediente_seguros_user_registra"><?= $Page->renderFieldHeader($Page->user_registra) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_fecha_registro" class="sco_expediente_seguros_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_estatus" class="sco_expediente_seguros_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th data-name="funeraria" class="<?= $Page->funeraria->headerCellClass() ?>"><div id="elh_sco_expediente_seguros_funeraria" class="sco_expediente_seguros_funeraria"><?= $Page->renderFieldHeader($Page->funeraria) ?></div></th>
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
    <?php if ($Page->seguro->Visible) { // seguro ?>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_seguro" class="el_sco_expediente_seguros_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <td data-name="nombre_contacto"<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_nombre_contacto" class="el_sco_expediente_seguros_nombre_contacto">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_cedula_fallecido" class="el_sco_expediente_seguros_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_nombre_fallecido" class="el_sco_expediente_seguros_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_apellidos_fallecido" class="el_sco_expediente_seguros_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_causa_ocurrencia" class="el_sco_expediente_seguros_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_registra->Visible) { // user_registra ?>
        <td data-name="user_registra"<?= $Page->user_registra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_user_registra" class="el_sco_expediente_seguros_user_registra">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_fecha_registro" class="el_sco_expediente_seguros_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_estatus" class="el_sco_expediente_seguros_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->funeraria->Visible) { // funeraria ?>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_seguros_funeraria" class="el_sco_expediente_seguros_funeraria">
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
    ew.addEventHandlers("sco_expediente_seguros");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
