<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewExpedienteServicioList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente_servicio: currentTable } });
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
<form name="fview_expediente_serviciosrch" id="fview_expediente_serviciosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_expediente_serviciosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente_servicio: currentTable } });
var currentForm;
var fview_expediente_serviciosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_expediente_serviciosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["Nexpediente", [ew.Validators.integer], fields.Nexpediente.isInvalid],
            ["capilla", [], fields.capilla.isInvalid],
            ["horas", [], fields.horas.isInvalid],
            ["servicio", [], fields.servicio.isInvalid],
            ["estatus", [], fields.estatus.isInvalid],
            ["fecha_registro", [ew.Validators.datetime(fields.fecha_registro.clientFormatPattern)], fields.fecha_registro.isInvalid],
            ["y_fecha_registro", [ew.Validators.between], false]
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
            "capilla": <?= $Page->capilla->toClientList($Page) ?>,
            "horas": <?= $Page->horas->toClientList($Page) ?>,
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
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
        <div id="el_view_expediente_servicio_Nexpediente" class="ew-search-field">
<input type="<?= $Page->Nexpediente->getInputTextType() ?>" name="x_Nexpediente" id="x_Nexpediente" data-table="view_expediente_servicio" data-field="x_Nexpediente" value="<?= $Page->Nexpediente->EditValue ?>" placeholder="<?= HtmlEncode($Page->Nexpediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nexpediente->formatPattern()) ?>"<?= $Page->Nexpediente->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nexpediente->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
<?php
if (!$Page->capilla->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_capilla" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->capilla->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_capilla" class="ew-search-caption ew-label"><?= $Page->capilla->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_capilla" id="z_capilla" value="=">
</div>
        </div>
        <div id="el_view_expediente_servicio_capilla" class="ew-search-field">
    <select
        id="x_capilla"
        name="x_capilla"
        class="form-select ew-select<?= $Page->capilla->isInvalidClass() ?>"
        <?php if (!$Page->capilla->IsNativeSelect) { ?>
        data-select2-id="fview_expediente_serviciosrch_x_capilla"
        <?php } ?>
        data-table="view_expediente_servicio"
        data-field="x_capilla"
        data-value-separator="<?= $Page->capilla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->capilla->getPlaceHolder()) ?>"
        <?= $Page->capilla->editAttributes() ?>>
        <?= $Page->capilla->selectOptionListHtml("x_capilla") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->capilla->getErrorMessage(false) ?></div>
<?= $Page->capilla->Lookup->getParamTag($Page, "p_x_capilla") ?>
<?php if (!$Page->capilla->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_expediente_serviciosrch", function() {
    var options = { name: "x_capilla", selectId: "fview_expediente_serviciosrch_x_capilla" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_expediente_serviciosrch.lists.capilla?.lookupOptions.length) {
        options.data = { id: "x_capilla", form: "fview_expediente_serviciosrch" };
    } else {
        options.ajax = { id: "x_capilla", form: "fview_expediente_serviciosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_expediente_servicio.fields.capilla.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
<?php
if (!$Page->horas->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_horas" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->horas->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_horas" class="ew-search-caption ew-label"><?= $Page->horas->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_horas" id="z_horas" value="=">
</div>
        </div>
        <div id="el_view_expediente_servicio_horas" class="ew-search-field">
    <select
        id="x_horas"
        name="x_horas"
        class="form-select ew-select<?= $Page->horas->isInvalidClass() ?>"
        <?php if (!$Page->horas->IsNativeSelect) { ?>
        data-select2-id="fview_expediente_serviciosrch_x_horas"
        <?php } ?>
        data-table="view_expediente_servicio"
        data-field="x_horas"
        data-value-separator="<?= $Page->horas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->horas->getPlaceHolder()) ?>"
        <?= $Page->horas->editAttributes() ?>>
        <?= $Page->horas->selectOptionListHtml("x_horas") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->horas->getErrorMessage(false) ?></div>
<?= $Page->horas->Lookup->getParamTag($Page, "p_x_horas") ?>
<?php if (!$Page->horas->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_expediente_serviciosrch", function() {
    var options = { name: "x_horas", selectId: "fview_expediente_serviciosrch_x_horas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_expediente_serviciosrch.lists.horas?.lookupOptions.length) {
        options.data = { id: "x_horas", form: "fview_expediente_serviciosrch" };
    } else {
        options.ajax = { id: "x_horas", form: "fview_expediente_serviciosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_expediente_servicio.fields.horas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_servicio" id="z_servicio" value="=">
</div>
        </div>
        <div id="el_view_expediente_servicio_servicio" class="ew-search-field">
    <select
        id="x_servicio"
        name="x_servicio"
        class="form-select ew-select<?= $Page->servicio->isInvalidClass() ?>"
        <?php if (!$Page->servicio->IsNativeSelect) { ?>
        data-select2-id="fview_expediente_serviciosrch_x_servicio"
        <?php } ?>
        data-table="view_expediente_servicio"
        data-field="x_servicio"
        data-value-separator="<?= $Page->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>"
        <?= $Page->servicio->editAttributes() ?>>
        <?= $Page->servicio->selectOptionListHtml("x_servicio") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->servicio->getErrorMessage(false) ?></div>
<?= $Page->servicio->Lookup->getParamTag($Page, "p_x_servicio") ?>
<?php if (!$Page->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_expediente_serviciosrch", function() {
    var options = { name: "x_servicio", selectId: "fview_expediente_serviciosrch_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_expediente_serviciosrch.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fview_expediente_serviciosrch" };
    } else {
        options.ajax = { id: "x_servicio", form: "fview_expediente_serviciosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_expediente_servicio.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_estatus" id="z_estatus" value="=">
</div>
        </div>
        <div id="el_view_expediente_servicio_estatus" class="ew-search-field">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fview_expediente_serviciosrch_x_estatus"
        <?php } ?>
        data-table="view_expediente_servicio"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage(false) ?></div>
<?= $Page->estatus->Lookup->getParamTag($Page, "p_x_estatus") ?>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_expediente_serviciosrch", function() {
    var options = { name: "x_estatus", selectId: "fview_expediente_serviciosrch_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_expediente_serviciosrch.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fview_expediente_serviciosrch" };
    } else {
        options.ajax = { id: "x_estatus", form: "fview_expediente_serviciosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_expediente_servicio.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
        <div id="el_view_expediente_servicio_fecha_registro" class="ew-search-field">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="x_fecha_registro" id="x_fecha_registro" data-table="view_expediente_servicio" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_expediente_serviciosrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_expediente_serviciosrch", "x_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_expediente_servicio_fecha_registro" class="ew-search-field2">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="y_fecha_registro" id="y_fecha_registro" data-table="view_expediente_servicio" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_expediente_serviciosrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_expediente_serviciosrch", "y_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_expediente_serviciosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_expediente_serviciosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_expediente_serviciosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_expediente_serviciosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_expediente_servicio">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_expediente_servicio" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_expediente_serviciolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="Nexpediente" class="<?= $Page->Nexpediente->headerCellClass() ?>"><div id="elh_view_expediente_servicio_Nexpediente" class="view_expediente_servicio_Nexpediente"><?= $Page->renderFieldHeader($Page->Nexpediente) ?></div></th>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
        <th data-name="seguro" class="<?= $Page->seguro->headerCellClass() ?>"><div id="elh_view_expediente_servicio_seguro" class="view_expediente_servicio_seguro"><?= $Page->renderFieldHeader($Page->seguro) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <th data-name="nombre_contacto" class="<?= $Page->nombre_contacto->headerCellClass() ?>"><div id="elh_view_expediente_servicio_nombre_contacto" class="view_expediente_servicio_nombre_contacto"><?= $Page->renderFieldHeader($Page->nombre_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
        <th data-name="telefono_contacto1" class="<?= $Page->telefono_contacto1->headerCellClass() ?>"><div id="elh_view_expediente_servicio_telefono_contacto1" class="view_expediente_servicio_telefono_contacto1"><?= $Page->renderFieldHeader($Page->telefono_contacto1) ?></div></th>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
        <th data-name="telefono_contacto2" class="<?= $Page->telefono_contacto2->headerCellClass() ?>"><div id="elh_view_expediente_servicio_telefono_contacto2" class="view_expediente_servicio_telefono_contacto2"><?= $Page->renderFieldHeader($Page->telefono_contacto2) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th data-name="cedula_fallecido" class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_servicio_cedula_fallecido" class="view_expediente_servicio_cedula_fallecido"><?= $Page->renderFieldHeader($Page->cedula_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th data-name="nombre_fallecido" class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_servicio_nombre_fallecido" class="view_expediente_servicio_nombre_fallecido"><?= $Page->renderFieldHeader($Page->nombre_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th data-name="apellidos_fallecido" class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_servicio_apellidos_fallecido" class="view_expediente_servicio_apellidos_fallecido"><?= $Page->renderFieldHeader($Page->apellidos_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
        <th data-name="edad_fallecido" class="<?= $Page->edad_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_servicio_edad_fallecido" class="view_expediente_servicio_edad_fallecido"><?= $Page->renderFieldHeader($Page->edad_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
        <th data-name="sexo" class="<?= $Page->sexo->headerCellClass() ?>"><div id="elh_view_expediente_servicio_sexo" class="view_expediente_servicio_sexo"><?= $Page->renderFieldHeader($Page->sexo) ?></div></th>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <th data-name="causa_ocurrencia" class="<?= $Page->causa_ocurrencia->headerCellClass() ?>"><div id="elh_view_expediente_servicio_causa_ocurrencia" class="view_expediente_servicio_causa_ocurrencia"><?= $Page->renderFieldHeader($Page->causa_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
        <th data-name="capilla" class="<?= $Page->capilla->headerCellClass() ?>"><div id="elh_view_expediente_servicio_capilla" class="view_expediente_servicio_capilla"><?= $Page->renderFieldHeader($Page->capilla) ?></div></th>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
        <th data-name="horas" class="<?= $Page->horas->headerCellClass() ?>"><div id="elh_view_expediente_servicio_horas" class="view_expediente_servicio_horas"><?= $Page->renderFieldHeader($Page->horas) ?></div></th>
<?php } ?>
<?php if ($Page->ataud->Visible) { // ataud ?>
        <th data-name="ataud" class="<?= $Page->ataud->headerCellClass() ?>"><div id="elh_view_expediente_servicio_ataud" class="view_expediente_servicio_ataud"><?= $Page->renderFieldHeader($Page->ataud) ?></div></th>
<?php } ?>
<?php if ($Page->arreglo_floral->Visible) { // arreglo_floral ?>
        <th data-name="arreglo_floral" class="<?= $Page->arreglo_floral->headerCellClass() ?>"><div id="elh_view_expediente_servicio_arreglo_floral" class="view_expediente_servicio_arreglo_floral"><?= $Page->renderFieldHeader($Page->arreglo_floral) ?></div></th>
<?php } ?>
<?php if ($Page->oficio_religioso->Visible) { // oficio_religioso ?>
        <th data-name="oficio_religioso" class="<?= $Page->oficio_religioso->headerCellClass() ?>"><div id="elh_view_expediente_servicio_oficio_religioso" class="view_expediente_servicio_oficio_religioso"><?= $Page->renderFieldHeader($Page->oficio_religioso) ?></div></th>
<?php } ?>
<?php if ($Page->ofrenda_voz->Visible) { // ofrenda_voz ?>
        <th data-name="ofrenda_voz" class="<?= $Page->ofrenda_voz->headerCellClass() ?>"><div id="elh_view_expediente_servicio_ofrenda_voz" class="view_expediente_servicio_ofrenda_voz"><?= $Page->renderFieldHeader($Page->ofrenda_voz) ?></div></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Page->servicio->headerCellClass() ?>"><div id="elh_view_expediente_servicio_servicio" class="view_expediente_servicio_servicio"><?= $Page->renderFieldHeader($Page->servicio) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_view_expediente_servicio_estatus" class="view_expediente_servicio_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_view_expediente_servicio_fecha_registro" class="view_expediente_servicio_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <th data-name="factura" class="<?= $Page->factura->headerCellClass() ?>"><div id="elh_view_expediente_servicio_factura" class="view_expediente_servicio_factura"><?= $Page->renderFieldHeader($Page->factura) ?></div></th>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
        <th data-name="venta" class="<?= $Page->venta->headerCellClass() ?>"><div id="elh_view_expediente_servicio_venta" class="view_expediente_servicio_venta"><?= $Page->renderFieldHeader($Page->venta) ?></div></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th data-name="funeraria" class="<?= $Page->funeraria->headerCellClass() ?>"><div id="elh_view_expediente_servicio_funeraria" class="view_expediente_servicio_funeraria"><?= $Page->renderFieldHeader($Page->funeraria) ?></div></th>
<?php } ?>
<?php if ($Page->cod_servicio->Visible) { // cod_servicio ?>
        <th data-name="cod_servicio" class="<?= $Page->cod_servicio->headerCellClass() ?>"><div id="elh_view_expediente_servicio_cod_servicio" class="view_expediente_servicio_cod_servicio"><?= $Page->renderFieldHeader($Page->cod_servicio) ?></div></th>
<?php } ?>
<?php if ($Page->coordinador->Visible) { // coordinador ?>
        <th data-name="coordinador" class="<?= $Page->coordinador->headerCellClass() ?>"><div id="elh_view_expediente_servicio_coordinador" class="view_expediente_servicio_coordinador"><?= $Page->renderFieldHeader($Page->coordinador) ?></div></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Page->parcela->headerCellClass() ?>"><div id="elh_view_expediente_servicio_parcela" class="view_expediente_servicio_parcela"><?= $Page->renderFieldHeader($Page->parcela) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_Nexpediente" class="el_view_expediente_servicio_Nexpediente">
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
    <?php if ($Page->seguro->Visible) { // seguro ?>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_seguro" class="el_view_expediente_servicio_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <td data-name="nombre_contacto"<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_nombre_contacto" class="el_view_expediente_servicio_nombre_contacto">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
        <td data-name="telefono_contacto1"<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_telefono_contacto1" class="el_view_expediente_servicio_telefono_contacto1">
<span<?= $Page->telefono_contacto1->viewAttributes() ?>>
<?= $Page->telefono_contacto1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
        <td data-name="telefono_contacto2"<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_telefono_contacto2" class="el_view_expediente_servicio_telefono_contacto2">
<span<?= $Page->telefono_contacto2->viewAttributes() ?>>
<?= $Page->telefono_contacto2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_cedula_fallecido" class="el_view_expediente_servicio_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_nombre_fallecido" class="el_view_expediente_servicio_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_apellidos_fallecido" class="el_view_expediente_servicio_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
        <td data-name="edad_fallecido"<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_edad_fallecido" class="el_view_expediente_servicio_edad_fallecido">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<?= $Page->edad_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sexo->Visible) { // sexo ?>
        <td data-name="sexo"<?= $Page->sexo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_sexo" class="el_view_expediente_servicio_sexo">
<span<?= $Page->sexo->viewAttributes() ?>>
<?= $Page->sexo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_causa_ocurrencia" class="el_view_expediente_servicio_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->capilla->Visible) { // capilla ?>
        <td data-name="capilla"<?= $Page->capilla->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_capilla" class="el_view_expediente_servicio_capilla">
<span<?= $Page->capilla->viewAttributes() ?>>
<?= $Page->capilla->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->horas->Visible) { // horas ?>
        <td data-name="horas"<?= $Page->horas->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_horas" class="el_view_expediente_servicio_horas">
<span<?= $Page->horas->viewAttributes() ?>>
<?= $Page->horas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ataud->Visible) { // ataud ?>
        <td data-name="ataud"<?= $Page->ataud->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_ataud" class="el_view_expediente_servicio_ataud">
<span<?= $Page->ataud->viewAttributes() ?>>
<?= $Page->ataud->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->arreglo_floral->Visible) { // arreglo_floral ?>
        <td data-name="arreglo_floral"<?= $Page->arreglo_floral->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_arreglo_floral" class="el_view_expediente_servicio_arreglo_floral">
<span<?= $Page->arreglo_floral->viewAttributes() ?>>
<?= $Page->arreglo_floral->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->oficio_religioso->Visible) { // oficio_religioso ?>
        <td data-name="oficio_religioso"<?= $Page->oficio_religioso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_oficio_religioso" class="el_view_expediente_servicio_oficio_religioso">
<span<?= $Page->oficio_religioso->viewAttributes() ?>>
<?= $Page->oficio_religioso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ofrenda_voz->Visible) { // ofrenda_voz ?>
        <td data-name="ofrenda_voz"<?= $Page->ofrenda_voz->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_ofrenda_voz" class="el_view_expediente_servicio_ofrenda_voz">
<span<?= $Page->ofrenda_voz->viewAttributes() ?>>
<?= $Page->ofrenda_voz->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_servicio" class="el_view_expediente_servicio_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_estatus" class="el_view_expediente_servicio_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_fecha_registro" class="el_view_expediente_servicio_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->factura->Visible) { // factura ?>
        <td data-name="factura"<?= $Page->factura->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_factura" class="el_view_expediente_servicio_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->venta->Visible) { // venta ?>
        <td data-name="venta"<?= $Page->venta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_venta" class="el_view_expediente_servicio_venta">
<span<?= $Page->venta->viewAttributes() ?>>
<?= $Page->venta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->funeraria->Visible) { // funeraria ?>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_funeraria" class="el_view_expediente_servicio_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cod_servicio->Visible) { // cod_servicio ?>
        <td data-name="cod_servicio"<?= $Page->cod_servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_cod_servicio" class="el_view_expediente_servicio_cod_servicio">
<span<?= $Page->cod_servicio->viewAttributes() ?>>
<?= $Page->cod_servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->coordinador->Visible) { // coordinador ?>
        <td data-name="coordinador"<?= $Page->coordinador->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_coordinador" class="el_view_expediente_servicio_coordinador">
<span<?= $Page->coordinador->viewAttributes() ?>>
<?= $Page->coordinador->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio_parcela" class="el_view_expediente_servicio_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
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
    ew.addEventHandlers("view_expediente_servicio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
