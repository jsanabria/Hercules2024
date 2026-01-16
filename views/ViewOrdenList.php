<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewOrdenList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_orden: currentTable } });
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
<form name="fview_ordensrch" id="fview_ordensrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_ordensrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_orden: currentTable } });
var currentForm;
var fview_ordensrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_ordensrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["paso", [], fields.paso.isInvalid],
            ["proveedor", [], fields.proveedor.isInvalid],
            ["fecha_inicio", [ew.Validators.datetime(fields.fecha_inicio.clientFormatPattern)], fields.fecha_inicio.isInvalid],
            ["y_fecha_inicio", [ew.Validators.between], false],
            ["fecha_fin", [ew.Validators.datetime(fields.fecha_fin.clientFormatPattern)], fields.fecha_fin.isInvalid],
            ["y_fecha_fin", [ew.Validators.between], false]
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
            "paso": <?= $Page->paso->toClientList($Page) ?>,
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
<?php if ($Page->paso->Visible) { // paso ?>
<?php
if (!$Page->paso->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_paso" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->paso->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_paso" class="ew-search-caption ew-label"><?= $Page->paso->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_paso" id="z_paso" value="=">
</div>
        </div>
        <div id="el_view_orden_paso" class="ew-search-field">
    <select
        id="x_paso"
        name="x_paso"
        class="form-select ew-select<?= $Page->paso->isInvalidClass() ?>"
        <?php if (!$Page->paso->IsNativeSelect) { ?>
        data-select2-id="fview_ordensrch_x_paso"
        <?php } ?>
        data-table="view_orden"
        data-field="x_paso"
        data-value-separator="<?= $Page->paso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->paso->getPlaceHolder()) ?>"
        <?= $Page->paso->editAttributes() ?>>
        <?= $Page->paso->selectOptionListHtml("x_paso") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->paso->getErrorMessage(false) ?></div>
<?php if (!$Page->paso->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_ordensrch", function() {
    var options = { name: "x_paso", selectId: "fview_ordensrch_x_paso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_ordensrch.lists.paso?.lookupOptions.length) {
        options.data = { id: "x_paso", form: "fview_ordensrch" };
    } else {
        options.ajax = { id: "x_paso", form: "fview_ordensrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_orden.fields.paso.selectOptions);
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
        <div id="el_view_orden_proveedor" class="ew-search-field">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-select ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        <?php if (!$Page->proveedor->IsNativeSelect) { ?>
        data-select2-id="fview_ordensrch_x_proveedor"
        <?php } ?>
        data-table="view_orden"
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
loadjs.ready("fview_ordensrch", function() {
    var options = { name: "x_proveedor", selectId: "fview_ordensrch_x_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_ordensrch.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fview_ordensrch" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fview_ordensrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_orden.fields.proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
<?php
if (!$Page->fecha_inicio->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_inicio" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_inicio->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_inicio" class="ew-search-caption ew-label"><?= $Page->fecha_inicio->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_inicio" id="z_fecha_inicio" value="BETWEEN">
</div>
        </div>
        <div id="el_view_orden_fecha_inicio" class="ew-search-field">
<input type="<?= $Page->fecha_inicio->getInputTextType() ?>" name="x_fecha_inicio" id="x_fecha_inicio" data-table="view_orden" data-field="x_fecha_inicio" value="<?= $Page->fecha_inicio->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_inicio->formatPattern()) ?>"<?= $Page->fecha_inicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_inicio->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_inicio->ReadOnly && !$Page->fecha_inicio->Disabled && !isset($Page->fecha_inicio->EditAttrs["readonly"]) && !isset($Page->fecha_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_ordensrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fview_ordensrch", "x_fecha_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_orden_fecha_inicio" class="ew-search-field2">
<input type="<?= $Page->fecha_inicio->getInputTextType() ?>" name="y_fecha_inicio" id="y_fecha_inicio" data-table="view_orden" data-field="x_fecha_inicio" value="<?= $Page->fecha_inicio->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_inicio->formatPattern()) ?>"<?= $Page->fecha_inicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_inicio->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_inicio->ReadOnly && !$Page->fecha_inicio->Disabled && !isset($Page->fecha_inicio->EditAttrs["readonly"]) && !isset($Page->fecha_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_ordensrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fview_ordensrch", "y_fecha_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
<?php
if (!$Page->fecha_fin->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_fin" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_fin->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_fin" class="ew-search-caption ew-label"><?= $Page->fecha_fin->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_fin" id="z_fecha_fin" value="BETWEEN">
</div>
        </div>
        <div id="el_view_orden_fecha_fin" class="ew-search-field">
<input type="<?= $Page->fecha_fin->getInputTextType() ?>" name="x_fecha_fin" id="x_fecha_fin" data-table="view_orden" data-field="x_fecha_fin" value="<?= $Page->fecha_fin->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_fin->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_fin->formatPattern()) ?>"<?= $Page->fecha_fin->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_fin->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_fin->ReadOnly && !$Page->fecha_fin->Disabled && !isset($Page->fecha_fin->EditAttrs["readonly"]) && !isset($Page->fecha_fin->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_ordensrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fview_ordensrch", "x_fecha_fin", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_orden_fecha_fin" class="ew-search-field2">
<input type="<?= $Page->fecha_fin->getInputTextType() ?>" name="y_fecha_fin" id="y_fecha_fin" data-table="view_orden" data-field="x_fecha_fin" value="<?= $Page->fecha_fin->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_fin->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_fin->formatPattern()) ?>"<?= $Page->fecha_fin->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_fin->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_fin->ReadOnly && !$Page->fecha_fin->Disabled && !isset($Page->fecha_fin->EditAttrs["readonly"]) && !isset($Page->fecha_fin->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_ordensrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fview_ordensrch", "y_fecha_fin", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_ordensrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_ordensrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_ordensrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_ordensrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_orden">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_orden" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_ordenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="expediente" class="<?= $Page->expediente->headerCellClass() ?>"><div id="elh_view_orden_expediente" class="view_orden_expediente"><?= $Page->renderFieldHeader($Page->expediente) ?></div></th>
<?php } ?>
<?php if ($Page->difunto->Visible) { // difunto ?>
        <th data-name="difunto" class="<?= $Page->difunto->headerCellClass() ?>"><div id="elh_view_orden_difunto" class="view_orden_difunto"><?= $Page->renderFieldHeader($Page->difunto) ?></div></th>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th data-name="servicio_tipo" class="<?= $Page->servicio_tipo->headerCellClass() ?>"><div id="elh_view_orden_servicio_tipo" class="view_orden_servicio_tipo"><?= $Page->renderFieldHeader($Page->servicio_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Page->servicio->headerCellClass() ?>"><div id="elh_view_orden_servicio" class="view_orden_servicio"><?= $Page->renderFieldHeader($Page->servicio) ?></div></th>
<?php } ?>
<?php if ($Page->paso->Visible) { // paso ?>
        <th data-name="paso" class="<?= $Page->paso->headerCellClass() ?>"><div id="elh_view_orden_paso" class="view_orden_paso"><?= $Page->renderFieldHeader($Page->paso) ?></div></th>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <th data-name="proveedor" class="<?= $Page->proveedor->headerCellClass() ?>"><div id="elh_view_orden_proveedor" class="view_orden_proveedor"><?= $Page->renderFieldHeader($Page->proveedor) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
        <th data-name="fecha_inicio" class="<?= $Page->fecha_inicio->headerCellClass() ?>"><div id="elh_view_orden_fecha_inicio" class="view_orden_fecha_inicio"><?= $Page->renderFieldHeader($Page->fecha_inicio) ?></div></th>
<?php } ?>
<?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
        <th data-name="hora_inicio" class="<?= $Page->hora_inicio->headerCellClass() ?>"><div id="elh_view_orden_hora_inicio" class="view_orden_hora_inicio"><?= $Page->renderFieldHeader($Page->hora_inicio) ?></div></th>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
        <th data-name="horas" class="<?= $Page->horas->headerCellClass() ?>"><div id="elh_view_orden_horas" class="view_orden_horas"><?= $Page->renderFieldHeader($Page->horas) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
        <th data-name="fecha_fin" class="<?= $Page->fecha_fin->headerCellClass() ?>"><div id="elh_view_orden_fecha_fin" class="view_orden_fecha_fin"><?= $Page->renderFieldHeader($Page->fecha_fin) ?></div></th>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <th data-name="hora_fin" class="<?= $Page->hora_fin->headerCellClass() ?>"><div id="elh_view_orden_hora_fin" class="view_orden_hora_fin"><?= $Page->renderFieldHeader($Page->hora_fin) ?></div></th>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
        <th data-name="cantidad" class="<?= $Page->cantidad->headerCellClass() ?>"><div id="elh_view_orden_cantidad" class="view_orden_cantidad"><?= $Page->renderFieldHeader($Page->cantidad) ?></div></th>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
        <th data-name="adjunto" class="<?= $Page->adjunto->headerCellClass() ?>"><div id="elh_view_orden_adjunto" class="view_orden_adjunto"><?= $Page->renderFieldHeader($Page->adjunto) ?></div></th>
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
        <th data-name="servicio_atendido" class="<?= $Page->servicio_atendido->headerCellClass() ?>"><div id="elh_view_orden_servicio_atendido" class="view_orden_servicio_atendido"><?= $Page->renderFieldHeader($Page->servicio_atendido) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_expediente" class="el_view_orden_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->difunto->Visible) { // difunto ?>
        <td data-name="difunto"<?= $Page->difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_difunto" class="el_view_orden_difunto">
<span<?= $Page->difunto->viewAttributes() ?>>
<?= $Page->difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_servicio_tipo" class="el_view_orden_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_servicio" class="el_view_orden_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paso->Visible) { // paso ?>
        <td data-name="paso"<?= $Page->paso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_paso" class="el_view_orden_paso">
<span<?= $Page->paso->viewAttributes() ?>>
<?= $Page->paso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->proveedor->Visible) { // proveedor ?>
        <td data-name="proveedor"<?= $Page->proveedor->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_proveedor" class="el_view_orden_proveedor">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
        <td data-name="fecha_inicio"<?= $Page->fecha_inicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_fecha_inicio" class="el_view_orden_fecha_inicio">
<span<?= $Page->fecha_inicio->viewAttributes() ?>>
<?= $Page->fecha_inicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
        <td data-name="hora_inicio"<?= $Page->hora_inicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_hora_inicio" class="el_view_orden_hora_inicio">
<span<?= $Page->hora_inicio->viewAttributes() ?>>
<?= $Page->hora_inicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->horas->Visible) { // horas ?>
        <td data-name="horas"<?= $Page->horas->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_horas" class="el_view_orden_horas">
<span<?= $Page->horas->viewAttributes() ?>>
<?= $Page->horas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
        <td data-name="fecha_fin"<?= $Page->fecha_fin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_fecha_fin" class="el_view_orden_fecha_fin">
<span<?= $Page->fecha_fin->viewAttributes() ?>>
<?= $Page->fecha_fin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <td data-name="hora_fin"<?= $Page->hora_fin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_hora_fin" class="el_view_orden_hora_fin">
<span<?= $Page->hora_fin->viewAttributes() ?>>
<?= $Page->hora_fin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cantidad->Visible) { // cantidad ?>
        <td data-name="cantidad"<?= $Page->cantidad->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_cantidad" class="el_view_orden_cantidad">
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->adjunto->Visible) { // adjunto ?>
        <td data-name="adjunto"<?= $Page->adjunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_adjunto" class="el_view_orden_adjunto">
<span<?= $Page->adjunto->viewAttributes() ?>>
<?= $Page->adjunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
        <td data-name="servicio_atendido"<?= $Page->servicio_atendido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_orden_servicio_atendido" class="el_view_orden_servicio_atendido">
<span<?= $Page->servicio_atendido->viewAttributes() ?>>
<?= $Page->servicio_atendido->getViewValue() ?></span>
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
    ew.addEventHandlers("view_orden");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
