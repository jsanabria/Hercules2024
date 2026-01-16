<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaIncidenciaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia: currentTable } });
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
<form name="fsco_flota_incidenciasrch" id="fsco_flota_incidenciasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_flota_incidenciasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia: currentTable } });
var currentForm;
var fsco_flota_incidenciasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_flota_incidenciasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["fecha_registro", [ew.Validators.datetime(fields.fecha_registro.clientFormatPattern)], fields.fecha_registro.isInvalid],
            ["y_fecha_registro", [ew.Validators.between], false],
            ["flota", [ew.Validators.integer], fields.flota.isInvalid],
            ["tipo", [], fields.tipo.isInvalid],
            ["proveedor", [], fields.proveedor.isInvalid]
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
            "flota": <?= $Page->flota->toClientList($Page) ?>,
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "proveedor": <?= $Page->proveedor->toClientList($Page) ?>,
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
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
<?php
if (!$Page->fecha_registro->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_registro" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_registro->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_registro" class="ew-search-caption ew-label"><?= $Page->fecha_registro->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_registro" id="z_fecha_registro" value="BETWEEN">
</div>
        </div>
        <div id="el_sco_flota_incidencia_fecha_registro" class="ew-search-field">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="x_fecha_registro" id="x_fecha_registro" data-table="sco_flota_incidencia" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_flota_incidenciasrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_flota_incidenciasrch", "x_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_sco_flota_incidencia_fecha_registro" class="ew-search-field2">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="y_fecha_registro" id="y_fecha_registro" data-table="sco_flota_incidencia" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_flota_incidenciasrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_flota_incidenciasrch", "y_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->flota->Visible) { // flota ?>
<?php
if (!$Page->flota->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_flota" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->flota->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->flota->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_flota" id="z_flota" value="=">
</div>
        </div>
        <div id="el_sco_flota_incidencia_flota" class="ew-search-field">
    <select
        id="x_flota"
        name="x_flota"
        class="form-control ew-select<?= $Page->flota->isInvalidClass() ?>"
        data-select2-id="fsco_flota_incidenciasrch_x_flota"
        data-table="sco_flota_incidencia"
        data-field="x_flota"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->flota->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->flota->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->flota->getPlaceHolder()) ?>"
        <?= $Page->flota->editAttributes() ?>>
        <?= $Page->flota->selectOptionListHtml("x_flota") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->flota->getErrorMessage(false) ?></div>
<?= $Page->flota->Lookup->getParamTag($Page, "p_x_flota") ?>
<script>
loadjs.ready("fsco_flota_incidenciasrch", function() {
    var options = { name: "x_flota", selectId: "fsco_flota_incidenciasrch_x_flota" };
    if (fsco_flota_incidenciasrch.lists.flota?.lookupOptions.length) {
        options.data = { id: "x_flota", form: "fsco_flota_incidenciasrch" };
    } else {
        options.ajax = { id: "x_flota", form: "fsco_flota_incidenciasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_flota_incidencia.fields.flota.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_sco_flota_incidencia_tipo" class="ew-search-field">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciasrch_x_tipo"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage(false) ?></div>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciasrch", function() {
    var options = { name: "x_tipo", selectId: "fsco_flota_incidenciasrch_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciasrch.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_flota_incidenciasrch" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_flota_incidenciasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
<?php
if (!$Page->proveedor->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_proveedor" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->proveedor->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_proveedor" class="ew-search-caption ew-label"><?= $Page->proveedor->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_proveedor" id="z_proveedor" value="=">
</div>
        </div>
        <div id="el_sco_flota_incidencia_proveedor" class="ew-search-field">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-select ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        <?php if (!$Page->proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciasrch_x_proveedor"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_proveedor"
        data-value-separator="<?= $Page->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->proveedor->getPlaceHolder()) ?>"
        <?= $Page->proveedor->editAttributes() ?>>
        <?= $Page->proveedor->selectOptionListHtml("x_proveedor") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->proveedor->getErrorMessage(false) ?></div>
<?= $Page->proveedor->Lookup->getParamTag($Page, "p_x_proveedor") ?>
<?php if (!$Page->proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciasrch", function() {
    var options = { name: "x_proveedor", selectId: "fsco_flota_incidenciasrch_x_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciasrch.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fsco_flota_incidenciasrch" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fsco_flota_incidenciasrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.proveedor.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_flota_incidenciasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_flota_incidenciasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_flota_incidenciasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_flota_incidenciasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_flota_incidencia">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_flota_incidencia" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_flota_incidencialist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nflota_incidencia->Visible) { // Nflota_incidencia ?>
        <th data-name="Nflota_incidencia" class="<?= $Page->Nflota_incidencia->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_Nflota_incidencia" class="sco_flota_incidencia_Nflota_incidencia"><?= $Page->renderFieldHeader($Page->Nflota_incidencia) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_fecha_registro" class="sco_flota_incidencia_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
<?php } ?>
<?php if ($Page->flota->Visible) { // flota ?>
        <th data-name="flota" class="<?= $Page->flota->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_flota" class="sco_flota_incidencia_flota"><?= $Page->renderFieldHeader($Page->flota) ?></div></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Page->tipo->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_tipo" class="sco_flota_incidencia_tipo"><?= $Page->renderFieldHeader($Page->tipo) ?></div></th>
<?php } ?>
<?php if ($Page->falla->Visible) { // falla ?>
        <th data-name="falla" class="<?= $Page->falla->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_falla" class="sco_flota_incidencia_falla"><?= $Page->renderFieldHeader($Page->falla) ?></div></th>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <th data-name="proveedor" class="<?= $Page->proveedor->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_proveedor" class="sco_flota_incidencia_proveedor"><?= $Page->renderFieldHeader($Page->proveedor) ?></div></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th data-name="_username" class="<?= $Page->_username->headerCellClass() ?>"><div id="elh_sco_flota_incidencia__username" class="sco_flota_incidencia__username"><?= $Page->renderFieldHeader($Page->_username) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_reparacion->Visible) { // fecha_reparacion ?>
        <th data-name="fecha_reparacion" class="<?= $Page->fecha_reparacion->headerCellClass() ?>"><div id="elh_sco_flota_incidencia_fecha_reparacion" class="sco_flota_incidencia_fecha_reparacion"><?= $Page->renderFieldHeader($Page->fecha_reparacion) ?></div></th>
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
    <?php if ($Page->Nflota_incidencia->Visible) { // Nflota_incidencia ?>
        <td data-name="Nflota_incidencia"<?= $Page->Nflota_incidencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_Nflota_incidencia" class="el_sco_flota_incidencia_Nflota_incidencia">
<span<?= $Page->Nflota_incidencia->viewAttributes() ?>>
<?= $Page->Nflota_incidencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_fecha_registro" class="el_sco_flota_incidencia_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->flota->Visible) { // flota ?>
        <td data-name="flota"<?= $Page->flota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_flota" class="el_sco_flota_incidencia_flota">
<span<?= $Page->flota->viewAttributes() ?>>
<?= $Page->flota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_tipo" class="el_sco_flota_incidencia_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->falla->Visible) { // falla ?>
        <td data-name="falla"<?= $Page->falla->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_falla" class="el_sco_flota_incidencia_falla">
<span<?= $Page->falla->viewAttributes() ?>>
<?= $Page->falla->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proveedor->Visible) { // proveedor ?>
        <td data-name="proveedor"<?= $Page->proveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_proveedor" class="el_sco_flota_incidencia_proveedor">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_username->Visible) { // username ?>
        <td data-name="_username"<?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia__username" class="el_sco_flota_incidencia__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_reparacion->Visible) { // fecha_reparacion ?>
        <td data-name="fecha_reparacion"<?= $Page->fecha_reparacion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_flota_incidencia_fecha_reparacion" class="el_sco_flota_incidencia_fecha_reparacion">
<span<?= $Page->fecha_reparacion->viewAttributes() ?>>
<?= $Page->fecha_reparacion->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_flota_incidencia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
