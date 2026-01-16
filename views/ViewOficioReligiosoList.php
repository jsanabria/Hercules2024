<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewOficioReligiosoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_oficio_religioso: currentTable } });
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
<form name="fview_oficio_religiososrch" id="fview_oficio_religiososrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_oficio_religiososrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_oficio_religioso: currentTable } });
var currentForm;
var fview_oficio_religiososrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_oficio_religiososrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["Nexpediente", [ew.Validators.integer], fields.Nexpediente.isInvalid],
            ["cedula", [ew.Validators.integer], fields.cedula.isInvalid],
            ["nombre", [], fields.nombre.isInvalid],
            ["apellido", [], fields.apellido.isInvalid],
            ["servicio_atendido", [], fields.servicio_atendido.isInvalid],
            ["fecha_servicio", [ew.Validators.datetime(fields.fecha_servicio.clientFormatPattern)], fields.fecha_servicio.isInvalid],
            ["y_fecha_servicio", [ew.Validators.between], false]
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
            "servicio_atendido": <?= $Page->servicio_atendido->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
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
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
<?php
if (!$Page->Nexpediente->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Nexpediente" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Nexpediente->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_Nexpediente" class="ew-search-caption ew-label"><?= $Page->Nexpediente->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Nexpediente" id="z_Nexpediente" value="=">
</div>
        </div>
        <div id="el_view_oficio_religioso_Nexpediente" class="ew-search-field">
<input type="<?= $Page->Nexpediente->getInputTextType() ?>" name="x_Nexpediente" id="x_Nexpediente" data-table="view_oficio_religioso" data-field="x_Nexpediente" value="<?= $Page->Nexpediente->EditValue ?>" placeholder="<?= HtmlEncode($Page->Nexpediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nexpediente->formatPattern()) ?>"<?= $Page->Nexpediente->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nexpediente->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
<?php
if (!$Page->cedula->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cedula" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cedula->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cedula" class="ew-search-caption ew-label"><?= $Page->cedula->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_cedula" id="z_cedula" value="=">
</div>
        </div>
        <div id="el_view_oficio_religioso_cedula" class="ew-search-field">
<input type="<?= $Page->cedula->getInputTextType() ?>" name="x_cedula" id="x_cedula" data-table="view_oficio_religioso" data-field="x_cedula" value="<?= $Page->cedula->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula->formatPattern()) ?>"<?= $Page->cedula->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->cedula->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
<?php
if (!$Page->nombre->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_nombre" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->nombre->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_nombre" class="ew-search-caption ew-label"><?= $Page->nombre->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nombre" id="z_nombre" value="LIKE">
</div>
        </div>
        <div id="el_view_oficio_religioso_nombre" class="ew-search-field">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="view_oficio_religioso" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
<?php
if (!$Page->apellido->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_apellido" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->apellido->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_apellido" class="ew-search-caption ew-label"><?= $Page->apellido->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_apellido" id="z_apellido" value="LIKE">
</div>
        </div>
        <div id="el_view_oficio_religioso_apellido" class="ew-search-field">
<input type="<?= $Page->apellido->getInputTextType() ?>" name="x_apellido" id="x_apellido" data-table="view_oficio_religioso" data-field="x_apellido" value="<?= $Page->apellido->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->apellido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido->formatPattern()) ?>"<?= $Page->apellido->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->apellido->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
<?php
if (!$Page->servicio_atendido->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_servicio_atendido" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->servicio_atendido->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_servicio_atendido" class="ew-search-caption ew-label"><?= $Page->servicio_atendido->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_servicio_atendido" id="z_servicio_atendido" value="=">
</div>
        </div>
        <div id="el_view_oficio_religioso_servicio_atendido" class="ew-search-field">
    <select
        id="x_servicio_atendido"
        name="x_servicio_atendido"
        class="form-select ew-select<?= $Page->servicio_atendido->isInvalidClass() ?>"
        <?php if (!$Page->servicio_atendido->IsNativeSelect) { ?>
        data-select2-id="fview_oficio_religiososrch_x_servicio_atendido"
        <?php } ?>
        data-table="view_oficio_religioso"
        data-field="x_servicio_atendido"
        data-value-separator="<?= $Page->servicio_atendido->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_atendido->getPlaceHolder()) ?>"
        <?= $Page->servicio_atendido->editAttributes() ?>>
        <?= $Page->servicio_atendido->selectOptionListHtml("x_servicio_atendido") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->servicio_atendido->getErrorMessage(false) ?></div>
<?php if (!$Page->servicio_atendido->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_oficio_religiososrch", function() {
    var options = { name: "x_servicio_atendido", selectId: "fview_oficio_religiososrch_x_servicio_atendido" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_oficio_religiososrch.lists.servicio_atendido?.lookupOptions.length) {
        options.data = { id: "x_servicio_atendido", form: "fview_oficio_religiososrch" };
    } else {
        options.ajax = { id: "x_servicio_atendido", form: "fview_oficio_religiososrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_oficio_religioso.fields.servicio_atendido.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
<?php
if (!$Page->fecha_servicio->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_servicio" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_servicio->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_servicio" class="ew-search-caption ew-label"><?= $Page->fecha_servicio->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_servicio" id="z_fecha_servicio" value="BETWEEN">
</div>
        </div>
        <div id="el_view_oficio_religioso_fecha_servicio" class="ew-search-field">
<input type="<?= $Page->fecha_servicio->getInputTextType() ?>" name="x_fecha_servicio" id="x_fecha_servicio" data-table="view_oficio_religioso" data-field="x_fecha_servicio" value="<?= $Page->fecha_servicio->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_servicio->formatPattern()) ?>"<?= $Page->fecha_servicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_servicio->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_servicio->ReadOnly && !$Page->fecha_servicio->Disabled && !isset($Page->fecha_servicio->EditAttrs["readonly"]) && !isset($Page->fecha_servicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_oficio_religiososrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_oficio_religiososrch", "x_fecha_servicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_oficio_religioso_fecha_servicio" class="ew-search-field2">
<input type="<?= $Page->fecha_servicio->getInputTextType() ?>" name="y_fecha_servicio" id="y_fecha_servicio" data-table="view_oficio_religioso" data-field="x_fecha_servicio" value="<?= $Page->fecha_servicio->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_servicio->formatPattern()) ?>"<?= $Page->fecha_servicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_servicio->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_servicio->ReadOnly && !$Page->fecha_servicio->Disabled && !isset($Page->fecha_servicio->EditAttrs["readonly"]) && !isset($Page->fecha_servicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_oficio_religiososrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_oficio_religiososrch", "y_fecha_servicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_oficio_religiososrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_oficio_religiososrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_oficio_religiososrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_oficio_religiososrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_oficio_religioso">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_oficio_religioso" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_oficio_religiosolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <th data-name="Nexpediente" class="<?= $Page->Nexpediente->headerCellClass() ?>"><div id="elh_view_oficio_religioso_Nexpediente" class="view_oficio_religioso_Nexpediente"><?= $Page->renderFieldHeader($Page->Nexpediente) ?></div></th>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
        <th data-name="cedula" class="<?= $Page->cedula->headerCellClass() ?>"><div id="elh_view_oficio_religioso_cedula" class="view_oficio_religioso_cedula"><?= $Page->renderFieldHeader($Page->cedula) ?></div></th>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
        <th data-name="nombre" class="<?= $Page->nombre->headerCellClass() ?>"><div id="elh_view_oficio_religioso_nombre" class="view_oficio_religioso_nombre"><?= $Page->renderFieldHeader($Page->nombre) ?></div></th>
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
        <th data-name="apellido" class="<?= $Page->apellido->headerCellClass() ?>"><div id="elh_view_oficio_religioso_apellido" class="view_oficio_religioso_apellido"><?= $Page->renderFieldHeader($Page->apellido) ?></div></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Page->servicio->headerCellClass() ?>"><div id="elh_view_oficio_religioso_servicio" class="view_oficio_religioso_servicio"><?= $Page->renderFieldHeader($Page->servicio) ?></div></th>
<?php } ?>
<?php if ($Page->servicio2->Visible) { // servicio2 ?>
        <th data-name="servicio2" class="<?= $Page->servicio2->headerCellClass() ?>"><div id="elh_view_oficio_religioso_servicio2" class="view_oficio_religioso_servicio2"><?= $Page->renderFieldHeader($Page->servicio2) ?></div></th>
<?php } ?>
<?php if ($Page->ministro->Visible) { // ministro ?>
        <th data-name="ministro" class="<?= $Page->ministro->headerCellClass() ?>"><div id="elh_view_oficio_religioso_ministro" class="view_oficio_religioso_ministro"><?= $Page->renderFieldHeader($Page->ministro) ?></div></th>
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
        <th data-name="servicio_atendido" class="<?= $Page->servicio_atendido->headerCellClass() ?>"><div id="elh_view_oficio_religioso_servicio_atendido" class="view_oficio_religioso_servicio_atendido"><?= $Page->renderFieldHeader($Page->servicio_atendido) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
        <th data-name="fecha_servicio" class="<?= $Page->fecha_servicio->headerCellClass() ?>"><div id="elh_view_oficio_religioso_fecha_servicio" class="view_oficio_religioso_fecha_servicio"><?= $Page->renderFieldHeader($Page->fecha_servicio) ?></div></th>
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
    <?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <td data-name="Nexpediente"<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_Nexpediente" class="el_view_oficio_religioso_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?php if (!EmptyString($Page->Nexpediente->getViewValue()) && $Page->Nexpediente->linkAttributes() != "") { ?>
<a<?= $Page->Nexpediente->linkAttributes() ?>><?= $Page->Nexpediente->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->Nexpediente->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula->Visible) { // cedula ?>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_cedula" class="el_view_oficio_religioso_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre->Visible) { // nombre ?>
        <td data-name="nombre"<?= $Page->nombre->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_nombre" class="el_view_oficio_religioso_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido->Visible) { // apellido ?>
        <td data-name="apellido"<?= $Page->apellido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_apellido" class="el_view_oficio_religioso_apellido">
<span<?= $Page->apellido->viewAttributes() ?>>
<?= $Page->apellido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_servicio" class="el_view_oficio_religioso_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio2->Visible) { // servicio2 ?>
        <td data-name="servicio2"<?= $Page->servicio2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_servicio2" class="el_view_oficio_religioso_servicio2">
<span<?= $Page->servicio2->viewAttributes() ?>>
<?= $Page->servicio2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ministro->Visible) { // ministro ?>
        <td data-name="ministro"<?= $Page->ministro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_ministro" class="el_view_oficio_religioso_ministro">
<span<?= $Page->ministro->viewAttributes() ?>>
<?= $Page->ministro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
        <td data-name="servicio_atendido"<?= $Page->servicio_atendido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_servicio_atendido" class="el_view_oficio_religioso_servicio_atendido">
<span<?= $Page->servicio_atendido->viewAttributes() ?>>
<?= $Page->servicio_atendido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
        <td data-name="fecha_servicio"<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_oficio_religioso_fecha_servicio" class="el_view_oficio_religioso_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<?= $Page->fecha_servicio->getViewValue() ?></span>
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
    ew.addEventHandlers("view_oficio_religioso");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
