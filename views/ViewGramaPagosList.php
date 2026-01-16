<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewGramaPagosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_grama_pagos: currentTable } });
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
<form name="fview_grama_pagossrch" id="fview_grama_pagossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_grama_pagossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_grama_pagos: currentTable } });
var currentForm;
var fview_grama_pagossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_grama_pagossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["registro_solicitud", [ew.Validators.datetime(fields.registro_solicitud.clientFormatPattern)], fields.registro_solicitud.isInvalid],
            ["y_registro_solicitud", [ew.Validators.between], false],
            ["tipo_pago", [], fields.tipo_pago.isInvalid],
            ["fecha_cobro", [ew.Validators.datetime(fields.fecha_cobro.clientFormatPattern)], fields.fecha_cobro.isInvalid],
            ["y_fecha_cobro", [ew.Validators.between], false],
            ["resgitro_pago", [ew.Validators.datetime(fields.resgitro_pago.clientFormatPattern)], fields.resgitro_pago.isInvalid],
            ["y_resgitro_pago", [ew.Validators.between], false]
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
            "tipo_pago": <?= $Page->tipo_pago->toClientList($Page) ?>,
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
<?php if ($Page->registro_solicitud->Visible) { // registro_solicitud ?>
<?php
if (!$Page->registro_solicitud->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_registro_solicitud" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->registro_solicitud->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_registro_solicitud" class="ew-search-caption ew-label"><?= $Page->registro_solicitud->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_registro_solicitud" id="z_registro_solicitud" value="BETWEEN">
</div>
        </div>
        <div id="el_view_grama_pagos_registro_solicitud" class="ew-search-field">
<input type="<?= $Page->registro_solicitud->getInputTextType() ?>" name="x_registro_solicitud" id="x_registro_solicitud" data-table="view_grama_pagos" data-field="x_registro_solicitud" value="<?= $Page->registro_solicitud->EditValue ?>" placeholder="<?= HtmlEncode($Page->registro_solicitud->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->registro_solicitud->formatPattern()) ?>"<?= $Page->registro_solicitud->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->registro_solicitud->getErrorMessage(false) ?></div>
<?php if (!$Page->registro_solicitud->ReadOnly && !$Page->registro_solicitud->Disabled && !isset($Page->registro_solicitud->EditAttrs["readonly"]) && !isset($Page->registro_solicitud->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_grama_pagossrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_grama_pagossrch", "x_registro_solicitud", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_grama_pagos_registro_solicitud" class="ew-search-field2">
<input type="<?= $Page->registro_solicitud->getInputTextType() ?>" name="y_registro_solicitud" id="y_registro_solicitud" data-table="view_grama_pagos" data-field="x_registro_solicitud" value="<?= $Page->registro_solicitud->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->registro_solicitud->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->registro_solicitud->formatPattern()) ?>"<?= $Page->registro_solicitud->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->registro_solicitud->getErrorMessage(false) ?></div>
<?php if (!$Page->registro_solicitud->ReadOnly && !$Page->registro_solicitud->Disabled && !isset($Page->registro_solicitud->EditAttrs["readonly"]) && !isset($Page->registro_solicitud->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_grama_pagossrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_grama_pagossrch", "y_registro_solicitud", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->tipo_pago->Visible) { // tipo_pago ?>
<?php
if (!$Page->tipo_pago->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_tipo_pago" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->tipo_pago->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_tipo_pago" class="ew-search-caption ew-label"><?= $Page->tipo_pago->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_tipo_pago" id="z_tipo_pago" value="=">
</div>
        </div>
        <div id="el_view_grama_pagos_tipo_pago" class="ew-search-field">
    <select
        id="x_tipo_pago"
        name="x_tipo_pago"
        class="form-select ew-select<?= $Page->tipo_pago->isInvalidClass() ?>"
        <?php if (!$Page->tipo_pago->IsNativeSelect) { ?>
        data-select2-id="fview_grama_pagossrch_x_tipo_pago"
        <?php } ?>
        data-table="view_grama_pagos"
        data-field="x_tipo_pago"
        data-value-separator="<?= $Page->tipo_pago->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_pago->getPlaceHolder()) ?>"
        <?= $Page->tipo_pago->editAttributes() ?>>
        <?= $Page->tipo_pago->selectOptionListHtml("x_tipo_pago") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo_pago->getErrorMessage(false) ?></div>
<?= $Page->tipo_pago->Lookup->getParamTag($Page, "p_x_tipo_pago") ?>
<?php if (!$Page->tipo_pago->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_grama_pagossrch", function() {
    var options = { name: "x_tipo_pago", selectId: "fview_grama_pagossrch_x_tipo_pago" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_grama_pagossrch.lists.tipo_pago?.lookupOptions.length) {
        options.data = { id: "x_tipo_pago", form: "fview_grama_pagossrch" };
    } else {
        options.ajax = { id: "x_tipo_pago", form: "fview_grama_pagossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_grama_pagos.fields.tipo_pago.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->fecha_cobro->Visible) { // fecha_cobro ?>
<?php
if (!$Page->fecha_cobro->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_cobro" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_cobro->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_cobro" class="ew-search-caption ew-label"><?= $Page->fecha_cobro->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_cobro" id="z_fecha_cobro" value="BETWEEN">
</div>
        </div>
        <div id="el_view_grama_pagos_fecha_cobro" class="ew-search-field">
<input type="<?= $Page->fecha_cobro->getInputTextType() ?>" name="x_fecha_cobro" id="x_fecha_cobro" data-table="view_grama_pagos" data-field="x_fecha_cobro" value="<?= $Page->fecha_cobro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_cobro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_cobro->formatPattern()) ?>"<?= $Page->fecha_cobro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_cobro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_cobro->ReadOnly && !$Page->fecha_cobro->Disabled && !isset($Page->fecha_cobro->EditAttrs["readonly"]) && !isset($Page->fecha_cobro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_grama_pagossrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_grama_pagossrch", "x_fecha_cobro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_grama_pagos_fecha_cobro" class="ew-search-field2">
<input type="<?= $Page->fecha_cobro->getInputTextType() ?>" name="y_fecha_cobro" id="y_fecha_cobro" data-table="view_grama_pagos" data-field="x_fecha_cobro" value="<?= $Page->fecha_cobro->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_cobro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_cobro->formatPattern()) ?>"<?= $Page->fecha_cobro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_cobro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_cobro->ReadOnly && !$Page->fecha_cobro->Disabled && !isset($Page->fecha_cobro->EditAttrs["readonly"]) && !isset($Page->fecha_cobro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_grama_pagossrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_grama_pagossrch", "y_fecha_cobro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->resgitro_pago->Visible) { // resgitro_pago ?>
<?php
if (!$Page->resgitro_pago->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_resgitro_pago" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->resgitro_pago->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_resgitro_pago" class="ew-search-caption ew-label"><?= $Page->resgitro_pago->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_resgitro_pago" id="z_resgitro_pago" value="BETWEEN">
</div>
        </div>
        <div id="el_view_grama_pagos_resgitro_pago" class="ew-search-field">
<input type="<?= $Page->resgitro_pago->getInputTextType() ?>" name="x_resgitro_pago" id="x_resgitro_pago" data-table="view_grama_pagos" data-field="x_resgitro_pago" value="<?= $Page->resgitro_pago->EditValue ?>" placeholder="<?= HtmlEncode($Page->resgitro_pago->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->resgitro_pago->formatPattern()) ?>"<?= $Page->resgitro_pago->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->resgitro_pago->getErrorMessage(false) ?></div>
<?php if (!$Page->resgitro_pago->ReadOnly && !$Page->resgitro_pago->Disabled && !isset($Page->resgitro_pago->EditAttrs["readonly"]) && !isset($Page->resgitro_pago->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_grama_pagossrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_grama_pagossrch", "x_resgitro_pago", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_grama_pagos_resgitro_pago" class="ew-search-field2">
<input type="<?= $Page->resgitro_pago->getInputTextType() ?>" name="y_resgitro_pago" id="y_resgitro_pago" data-table="view_grama_pagos" data-field="x_resgitro_pago" value="<?= $Page->resgitro_pago->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->resgitro_pago->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->resgitro_pago->formatPattern()) ?>"<?= $Page->resgitro_pago->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->resgitro_pago->getErrorMessage(false) ?></div>
<?php if (!$Page->resgitro_pago->ReadOnly && !$Page->resgitro_pago->Disabled && !isset($Page->resgitro_pago->EditAttrs["readonly"]) && !isset($Page->resgitro_pago->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_grama_pagossrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_grama_pagossrch", "y_resgitro_pago", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_grama_pagossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_grama_pagossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_grama_pagossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_grama_pagossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_grama_pagos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_grama_pagos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_grama_pagoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="expediente" class="<?= $Page->expediente->headerCellClass() ?>"><div id="elh_view_grama_pagos_expediente" class="view_grama_pagos_expediente"><?= $Page->renderFieldHeader($Page->expediente) ?></div></th>
<?php } ?>
<?php if ($Page->registro_solicitud->Visible) { // registro_solicitud ?>
        <th data-name="registro_solicitud" class="<?= $Page->registro_solicitud->headerCellClass() ?>"><div id="elh_view_grama_pagos_registro_solicitud" class="view_grama_pagos_registro_solicitud"><?= $Page->renderFieldHeader($Page->registro_solicitud) ?></div></th>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
        <th data-name="solicitante" class="<?= $Page->solicitante->headerCellClass() ?>"><div id="elh_view_grama_pagos_solicitante" class="view_grama_pagos_solicitante"><?= $Page->renderFieldHeader($Page->solicitante) ?></div></th>
<?php } ?>
<?php if ($Page->difunto->Visible) { // difunto ?>
        <th data-name="difunto" class="<?= $Page->difunto->headerCellClass() ?>"><div id="elh_view_grama_pagos_difunto" class="view_grama_pagos_difunto"><?= $Page->renderFieldHeader($Page->difunto) ?></div></th>
<?php } ?>
<?php if ($Page->ubicacion->Visible) { // ubicacion ?>
        <th data-name="ubicacion" class="<?= $Page->ubicacion->headerCellClass() ?>"><div id="elh_view_grama_pagos_ubicacion" class="view_grama_pagos_ubicacion"><?= $Page->renderFieldHeader($Page->ubicacion) ?></div></th>
<?php } ?>
<?php if ($Page->ctto_usd->Visible) { // ctto_usd ?>
        <th data-name="ctto_usd" class="<?= $Page->ctto_usd->headerCellClass() ?>"><div id="elh_view_grama_pagos_ctto_usd" class="view_grama_pagos_ctto_usd"><?= $Page->renderFieldHeader($Page->ctto_usd) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_pago->Visible) { // tipo_pago ?>
        <th data-name="tipo_pago" class="<?= $Page->tipo_pago->headerCellClass() ?>"><div id="elh_view_grama_pagos_tipo_pago" class="view_grama_pagos_tipo_pago"><?= $Page->renderFieldHeader($Page->tipo_pago) ?></div></th>
<?php } ?>
<?php if ($Page->banco->Visible) { // banco ?>
        <th data-name="banco" class="<?= $Page->banco->headerCellClass() ?>"><div id="elh_view_grama_pagos_banco" class="view_grama_pagos_banco"><?= $Page->renderFieldHeader($Page->banco) ?></div></th>
<?php } ?>
<?php if ($Page->ref->Visible) { // ref ?>
        <th data-name="ref" class="<?= $Page->ref->headerCellClass() ?>"><div id="elh_view_grama_pagos_ref" class="view_grama_pagos_ref"><?= $Page->renderFieldHeader($Page->ref) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_cobro->Visible) { // fecha_cobro ?>
        <th data-name="fecha_cobro" class="<?= $Page->fecha_cobro->headerCellClass() ?>"><div id="elh_view_grama_pagos_fecha_cobro" class="view_grama_pagos_fecha_cobro"><?= $Page->renderFieldHeader($Page->fecha_cobro) ?></div></th>
<?php } ?>
<?php if ($Page->resgitro_pago->Visible) { // resgitro_pago ?>
        <th data-name="resgitro_pago" class="<?= $Page->resgitro_pago->headerCellClass() ?>"><div id="elh_view_grama_pagos_resgitro_pago" class="view_grama_pagos_resgitro_pago"><?= $Page->renderFieldHeader($Page->resgitro_pago) ?></div></th>
<?php } ?>
<?php if ($Page->cta_destino->Visible) { // cta_destino ?>
        <th data-name="cta_destino" class="<?= $Page->cta_destino->headerCellClass() ?>"><div id="elh_view_grama_pagos_cta_destino" class="view_grama_pagos_cta_destino"><?= $Page->renderFieldHeader($Page->cta_destino) ?></div></th>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
        <th data-name="monto_bs" class="<?= $Page->monto_bs->headerCellClass() ?>"><div id="elh_view_grama_pagos_monto_bs" class="view_grama_pagos_monto_bs"><?= $Page->renderFieldHeader($Page->monto_bs) ?></div></th>
<?php } ?>
<?php if ($Page->monto_usd->Visible) { // monto_usd ?>
        <th data-name="monto_usd" class="<?= $Page->monto_usd->headerCellClass() ?>"><div id="elh_view_grama_pagos_monto_usd" class="view_grama_pagos_monto_usd"><?= $Page->renderFieldHeader($Page->monto_usd) ?></div></th>
<?php } ?>
<?php if ($Page->monto_ue->Visible) { // monto_ue ?>
        <th data-name="monto_ue" class="<?= $Page->monto_ue->headerCellClass() ?>"><div id="elh_view_grama_pagos_monto_ue" class="view_grama_pagos_monto_ue"><?= $Page->renderFieldHeader($Page->monto_ue) ?></div></th>
<?php } ?>
<?php if ($Page->subtipo->Visible) { // subtipo ?>
        <th data-name="subtipo" class="<?= $Page->subtipo->headerCellClass() ?>"><div id="elh_view_grama_pagos_subtipo" class="view_grama_pagos_subtipo"><?= $Page->renderFieldHeader($Page->subtipo) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_view_grama_pagos_estatus" class="view_grama_pagos_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_expediente" class="el_view_grama_pagos_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->registro_solicitud->Visible) { // registro_solicitud ?>
        <td data-name="registro_solicitud"<?= $Page->registro_solicitud->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_registro_solicitud" class="el_view_grama_pagos_registro_solicitud">
<span<?= $Page->registro_solicitud->viewAttributes() ?>>
<?= $Page->registro_solicitud->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->solicitante->Visible) { // solicitante ?>
        <td data-name="solicitante"<?= $Page->solicitante->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_solicitante" class="el_view_grama_pagos_solicitante">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->difunto->Visible) { // difunto ?>
        <td data-name="difunto"<?= $Page->difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_difunto" class="el_view_grama_pagos_difunto">
<span<?= $Page->difunto->viewAttributes() ?>>
<?= $Page->difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ubicacion->Visible) { // ubicacion ?>
        <td data-name="ubicacion"<?= $Page->ubicacion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_ubicacion" class="el_view_grama_pagos_ubicacion">
<span<?= $Page->ubicacion->viewAttributes() ?>>
<?= $Page->ubicacion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ctto_usd->Visible) { // ctto_usd ?>
        <td data-name="ctto_usd"<?= $Page->ctto_usd->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_ctto_usd" class="el_view_grama_pagos_ctto_usd">
<span<?= $Page->ctto_usd->viewAttributes() ?>>
<?= $Page->ctto_usd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_pago->Visible) { // tipo_pago ?>
        <td data-name="tipo_pago"<?= $Page->tipo_pago->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_tipo_pago" class="el_view_grama_pagos_tipo_pago">
<span<?= $Page->tipo_pago->viewAttributes() ?>>
<?= $Page->tipo_pago->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->banco->Visible) { // banco ?>
        <td data-name="banco"<?= $Page->banco->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_banco" class="el_view_grama_pagos_banco">
<span<?= $Page->banco->viewAttributes() ?>>
<?= $Page->banco->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ref->Visible) { // ref ?>
        <td data-name="ref"<?= $Page->ref->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_ref" class="el_view_grama_pagos_ref">
<span<?= $Page->ref->viewAttributes() ?>>
<?= $Page->ref->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_cobro->Visible) { // fecha_cobro ?>
        <td data-name="fecha_cobro"<?= $Page->fecha_cobro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_fecha_cobro" class="el_view_grama_pagos_fecha_cobro">
<span<?= $Page->fecha_cobro->viewAttributes() ?>>
<?= $Page->fecha_cobro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->resgitro_pago->Visible) { // resgitro_pago ?>
        <td data-name="resgitro_pago"<?= $Page->resgitro_pago->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_resgitro_pago" class="el_view_grama_pagos_resgitro_pago">
<span<?= $Page->resgitro_pago->viewAttributes() ?>>
<?= $Page->resgitro_pago->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cta_destino->Visible) { // cta_destino ?>
        <td data-name="cta_destino"<?= $Page->cta_destino->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_cta_destino" class="el_view_grama_pagos_cta_destino">
<span<?= $Page->cta_destino->viewAttributes() ?>>
<?= $Page->cta_destino->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monto_bs->Visible) { // monto_bs ?>
        <td data-name="monto_bs"<?= $Page->monto_bs->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_monto_bs" class="el_view_grama_pagos_monto_bs">
<span<?= $Page->monto_bs->viewAttributes() ?>>
<?= $Page->monto_bs->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monto_usd->Visible) { // monto_usd ?>
        <td data-name="monto_usd"<?= $Page->monto_usd->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_monto_usd" class="el_view_grama_pagos_monto_usd">
<span<?= $Page->monto_usd->viewAttributes() ?>>
<?= $Page->monto_usd->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->monto_ue->Visible) { // monto_ue ?>
        <td data-name="monto_ue"<?= $Page->monto_ue->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_monto_ue" class="el_view_grama_pagos_monto_ue">
<span<?= $Page->monto_ue->viewAttributes() ?>>
<?= $Page->monto_ue->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->subtipo->Visible) { // subtipo ?>
        <td data-name="subtipo"<?= $Page->subtipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_subtipo" class="el_view_grama_pagos_subtipo">
<span<?= $Page->subtipo->viewAttributes() ?>>
<?= $Page->subtipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_grama_pagos_estatus" class="el_view_grama_pagos_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
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
    ew.addEventHandlers("view_grama_pagos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
