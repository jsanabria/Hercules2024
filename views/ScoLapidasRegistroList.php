<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoLapidasRegistroList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_lapidas_registro: currentTable } });
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
<form name="fsco_lapidas_registrosrch" id="fsco_lapidas_registrosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_lapidas_registrosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_lapidas_registro: currentTable } });
var currentForm;
var fsco_lapidas_registrosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_lapidas_registrosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["Nlapidas_registro", [ew.Validators.integer], fields.Nlapidas_registro.isInvalid],
            ["ci_difunto", [], fields.ci_difunto.isInvalid],
            ["estatus", [], fields.estatus.isInvalid],
            ["registro", [ew.Validators.datetime(fields.registro.clientFormatPattern)], fields.registro.isInvalid],
            ["y_registro", [ew.Validators.between], false],
            ["registra", [], fields.registra.isInvalid],
            ["modifica", [], fields.modifica.isInvalid],
            ["seccion", [], fields.seccion.isInvalid],
            ["modulo", [], fields.modulo.isInvalid],
            ["sub_seccion", [], fields.sub_seccion.isInvalid],
            ["parcela", [], fields.parcela.isInvalid]
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
            "registra": <?= $Page->registra->toClientList($Page) ?>,
            "modifica": <?= $Page->modifica->toClientList($Page) ?>,
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
<?php if ($Page->Nlapidas_registro->Visible) { // Nlapidas_registro ?>
<?php
if (!$Page->Nlapidas_registro->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Nlapidas_registro" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Nlapidas_registro->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_Nlapidas_registro" class="ew-search-caption ew-label"><?= $Page->Nlapidas_registro->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Nlapidas_registro" id="z_Nlapidas_registro" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_Nlapidas_registro" class="ew-search-field">
<input type="<?= $Page->Nlapidas_registro->getInputTextType() ?>" name="x_Nlapidas_registro" id="x_Nlapidas_registro" data-table="sco_lapidas_registro" data-field="x_Nlapidas_registro" value="<?= $Page->Nlapidas_registro->EditValue ?>" size="8" placeholder="<?= HtmlEncode($Page->Nlapidas_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nlapidas_registro->formatPattern()) ?>"<?= $Page->Nlapidas_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nlapidas_registro->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
<?php
if (!$Page->ci_difunto->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_ci_difunto" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->ci_difunto->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_ci_difunto" class="ew-search-caption ew-label"><?= $Page->ci_difunto->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ci_difunto" id="z_ci_difunto" value="LIKE">
</div>
        </div>
        <div id="el_sco_lapidas_registro_ci_difunto" class="ew-search-field">
<input type="<?= $Page->ci_difunto->getInputTextType() ?>" name="x_ci_difunto" id="x_ci_difunto" data-table="sco_lapidas_registro" data-field="x_ci_difunto" value="<?= $Page->ci_difunto->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->ci_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_difunto->formatPattern()) ?>"<?= $Page->ci_difunto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ci_difunto->getErrorMessage(false) ?></div>
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
        <div id="el_sco_lapidas_registro_estatus" class="ew-search-field">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_lapidas_registrosrch_x_estatus"
        <?php } ?>
        data-table="sco_lapidas_registro"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage(false) ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_lapidas_registrosrch", function() {
    var options = { name: "x_estatus", selectId: "fsco_lapidas_registrosrch_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_lapidas_registrosrch.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_lapidas_registrosrch" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_lapidas_registrosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_lapidas_registro.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
<?php
if (!$Page->registro->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_registro" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->registro->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_registro" class="ew-search-caption ew-label"><?= $Page->registro->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_registro" id="z_registro" value="BETWEEN">
</div>
        </div>
        <div id="el_sco_lapidas_registro_registro" class="ew-search-field">
<input type="<?= $Page->registro->getInputTextType() ?>" name="x_registro" id="x_registro" data-table="sco_lapidas_registro" data-field="x_registro" value="<?= $Page->registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->registro->formatPattern()) ?>"<?= $Page->registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->registro->getErrorMessage(false) ?></div>
<?php if (!$Page->registro->ReadOnly && !$Page->registro->Disabled && !isset($Page->registro->EditAttrs["readonly"]) && !isset($Page->registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_lapidas_registrosrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_lapidas_registrosrch", "x_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_sco_lapidas_registro_registro" class="ew-search-field2">
<input type="<?= $Page->registro->getInputTextType() ?>" name="y_registro" id="y_registro" data-table="sco_lapidas_registro" data-field="x_registro" value="<?= $Page->registro->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->registro->formatPattern()) ?>"<?= $Page->registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->registro->getErrorMessage(false) ?></div>
<?php if (!$Page->registro->ReadOnly && !$Page->registro->Disabled && !isset($Page->registro->EditAttrs["readonly"]) && !isset($Page->registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_lapidas_registrosrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_lapidas_registrosrch", "y_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->registra->Visible) { // registra ?>
<?php
if (!$Page->registra->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_registra" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->registra->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_registra" class="ew-search-caption ew-label"><?= $Page->registra->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_registra" id="z_registra" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_registra" class="ew-search-field">
    <select
        id="x_registra"
        name="x_registra"
        class="form-select ew-select<?= $Page->registra->isInvalidClass() ?>"
        <?php if (!$Page->registra->IsNativeSelect) { ?>
        data-select2-id="fsco_lapidas_registrosrch_x_registra"
        <?php } ?>
        data-table="sco_lapidas_registro"
        data-field="x_registra"
        data-value-separator="<?= $Page->registra->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->registra->getPlaceHolder()) ?>"
        <?= $Page->registra->editAttributes() ?>>
        <?= $Page->registra->selectOptionListHtml("x_registra") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->registra->getErrorMessage(false) ?></div>
<?= $Page->registra->Lookup->getParamTag($Page, "p_x_registra") ?>
<?php if (!$Page->registra->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_lapidas_registrosrch", function() {
    var options = { name: "x_registra", selectId: "fsco_lapidas_registrosrch_x_registra" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_lapidas_registrosrch.lists.registra?.lookupOptions.length) {
        options.data = { id: "x_registra", form: "fsco_lapidas_registrosrch" };
    } else {
        options.ajax = { id: "x_registra", form: "fsco_lapidas_registrosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_lapidas_registro.fields.registra.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->modifica->Visible) { // modifica ?>
<?php
if (!$Page->modifica->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_modifica" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->modifica->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_modifica" class="ew-search-caption ew-label"><?= $Page->modifica->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_modifica" id="z_modifica" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_modifica" class="ew-search-field">
    <select
        id="x_modifica"
        name="x_modifica"
        class="form-select ew-select<?= $Page->modifica->isInvalidClass() ?>"
        <?php if (!$Page->modifica->IsNativeSelect) { ?>
        data-select2-id="fsco_lapidas_registrosrch_x_modifica"
        <?php } ?>
        data-table="sco_lapidas_registro"
        data-field="x_modifica"
        data-value-separator="<?= $Page->modifica->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->modifica->getPlaceHolder()) ?>"
        <?= $Page->modifica->editAttributes() ?>>
        <?= $Page->modifica->selectOptionListHtml("x_modifica") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->modifica->getErrorMessage(false) ?></div>
<?= $Page->modifica->Lookup->getParamTag($Page, "p_x_modifica") ?>
<?php if (!$Page->modifica->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_lapidas_registrosrch", function() {
    var options = { name: "x_modifica", selectId: "fsco_lapidas_registrosrch_x_modifica" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_lapidas_registrosrch.lists.modifica?.lookupOptions.length) {
        options.data = { id: "x_modifica", form: "fsco_lapidas_registrosrch" };
    } else {
        options.ajax = { id: "x_modifica", form: "fsco_lapidas_registrosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_lapidas_registro.fields.modifica.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_seccion" id="z_seccion" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_seccion" class="ew-search-field">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="sco_lapidas_registro" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" size="10" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?>>
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
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_modulo" id="z_modulo" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_modulo" class="ew-search-field">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="sco_lapidas_registro" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="10" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
<?php
if (!$Page->sub_seccion->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_sub_seccion" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->sub_seccion->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_sub_seccion" class="ew-search-caption ew-label"><?= $Page->sub_seccion->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_sub_seccion" id="z_sub_seccion" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_sub_seccion" class="ew-search-field">
<input type="<?= $Page->sub_seccion->getInputTextType() ?>" name="x_sub_seccion" id="x_sub_seccion" data-table="sco_lapidas_registro" data-field="x_sub_seccion" value="<?= $Page->sub_seccion->EditValue ?>" size="10" maxlength="3" placeholder="<?= HtmlEncode($Page->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sub_seccion->formatPattern()) ?>"<?= $Page->sub_seccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->sub_seccion->getErrorMessage(false) ?></div>
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
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_parcela" id="z_parcela" value="=">
</div>
        </div>
        <div id="el_sco_lapidas_registro_parcela" class="ew-search-field">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_lapidas_registro" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="10" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_lapidas_registrosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_lapidas_registrosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_lapidas_registrosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_lapidas_registrosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_lapidas_registro">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_lapidas_registro" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_lapidas_registrolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nlapidas_registro->Visible) { // Nlapidas_registro ?>
        <th data-name="Nlapidas_registro" class="<?= $Page->Nlapidas_registro->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_Nlapidas_registro" class="sco_lapidas_registro_Nlapidas_registro"><?= $Page->renderFieldHeader($Page->Nlapidas_registro) ?></div></th>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
        <th data-name="solicitante" class="<?= $Page->solicitante->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_solicitante" class="sco_lapidas_registro_solicitante"><?= $Page->renderFieldHeader($Page->solicitante) ?></div></th>
<?php } ?>
<?php if ($Page->parentesco->Visible) { // parentesco ?>
        <th data-name="parentesco" class="<?= $Page->parentesco->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_parentesco" class="sco_lapidas_registro_parentesco"><?= $Page->renderFieldHeader($Page->parentesco) ?></div></th>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <th data-name="ci_difunto" class="<?= $Page->ci_difunto->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_ci_difunto" class="sco_lapidas_registro_ci_difunto"><?= $Page->renderFieldHeader($Page->ci_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
        <th data-name="nombre_difunto" class="<?= $Page->nombre_difunto->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_nombre_difunto" class="sco_lapidas_registro_nombre_difunto"><?= $Page->renderFieldHeader($Page->nombre_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Page->tipo->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_tipo" class="sco_lapidas_registro_tipo"><?= $Page->renderFieldHeader($Page->tipo) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_estatus" class="sco_lapidas_registro_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
        <th data-name="registro" class="<?= $Page->registro->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_registro" class="sco_lapidas_registro_registro"><?= $Page->renderFieldHeader($Page->registro) ?></div></th>
<?php } ?>
<?php if ($Page->registra->Visible) { // registra ?>
        <th data-name="registra" class="<?= $Page->registra->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_registra" class="sco_lapidas_registro_registra"><?= $Page->renderFieldHeader($Page->registra) ?></div></th>
<?php } ?>
<?php if ($Page->modifica->Visible) { // modifica ?>
        <th data-name="modifica" class="<?= $Page->modifica->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_modifica" class="sco_lapidas_registro_modifica"><?= $Page->renderFieldHeader($Page->modifica) ?></div></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th data-name="seccion" class="<?= $Page->seccion->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_seccion" class="sco_lapidas_registro_seccion"><?= $Page->renderFieldHeader($Page->seccion) ?></div></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_modulo" class="sco_lapidas_registro_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <th data-name="sub_seccion" class="<?= $Page->sub_seccion->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_sub_seccion" class="sco_lapidas_registro_sub_seccion"><?= $Page->renderFieldHeader($Page->sub_seccion) ?></div></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Page->parcela->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_parcela" class="sco_lapidas_registro_parcela"><?= $Page->renderFieldHeader($Page->parcela) ?></div></th>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <th data-name="contrato" class="<?= $Page->contrato->headerCellClass() ?>"><div id="elh_sco_lapidas_registro_contrato" class="sco_lapidas_registro_contrato"><?= $Page->renderFieldHeader($Page->contrato) ?></div></th>
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
    <?php if ($Page->Nlapidas_registro->Visible) { // Nlapidas_registro ?>
        <td data-name="Nlapidas_registro"<?= $Page->Nlapidas_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_Nlapidas_registro" class="el_sco_lapidas_registro_Nlapidas_registro">
<span<?= $Page->Nlapidas_registro->viewAttributes() ?>>
<?= $Page->Nlapidas_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->solicitante->Visible) { // solicitante ?>
        <td data-name="solicitante"<?= $Page->solicitante->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_solicitante" class="el_sco_lapidas_registro_solicitante">
<span<?= $Page->solicitante->viewAttributes() ?>>
<?= $Page->solicitante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parentesco->Visible) { // parentesco ?>
        <td data-name="parentesco"<?= $Page->parentesco->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_parentesco" class="el_sco_lapidas_registro_parentesco">
<span<?= $Page->parentesco->viewAttributes() ?>>
<?= $Page->parentesco->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_ci_difunto" class="el_sco_lapidas_registro_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
        <td data-name="nombre_difunto"<?= $Page->nombre_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_nombre_difunto" class="el_sco_lapidas_registro_nombre_difunto">
<span<?= $Page->nombre_difunto->viewAttributes() ?>>
<?= $Page->nombre_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_tipo" class="el_sco_lapidas_registro_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_estatus" class="el_sco_lapidas_registro_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->registro->Visible) { // registro ?>
        <td data-name="registro"<?= $Page->registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_registro" class="el_sco_lapidas_registro_registro">
<span<?= $Page->registro->viewAttributes() ?>>
<?= $Page->registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->registra->Visible) { // registra ?>
        <td data-name="registra"<?= $Page->registra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_registra" class="el_sco_lapidas_registro_registra">
<span<?= $Page->registra->viewAttributes() ?>>
<?= $Page->registra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modifica->Visible) { // modifica ?>
        <td data-name="modifica"<?= $Page->modifica->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_modifica" class="el_sco_lapidas_registro_modifica">
<span<?= $Page->modifica->viewAttributes() ?>>
<?= $Page->modifica->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seccion->Visible) { // seccion ?>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_seccion" class="el_sco_lapidas_registro_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo->Visible) { // modulo ?>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_modulo" class="el_sco_lapidas_registro_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <td data-name="sub_seccion"<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_sub_seccion" class="el_sco_lapidas_registro_sub_seccion">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_parcela" class="el_sco_lapidas_registro_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contrato->Visible) { // contrato ?>
        <td data-name="contrato"<?= $Page->contrato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_lapidas_registro_contrato" class="el_sco_lapidas_registro_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_lapidas_registro");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
