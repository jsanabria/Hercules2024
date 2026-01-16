<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico: currentTable } });
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
<form name="fsco_mttotecnicosrch" id="fsco_mttotecnicosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_mttotecnicosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico: currentTable } });
var currentForm;
var fsco_mttotecnicosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnicosrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["fecha_registro", [ew.Validators.datetime(fields.fecha_registro.clientFormatPattern)], fields.fecha_registro.isInvalid],
            ["y_fecha_registro", [ew.Validators.between], false],
            ["requiere_materiales", [], fields.requiere_materiales.isInvalid]
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
            "requiere_materiales": <?= $Page->requiere_materiales->toClientList($Page) ?>,
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
        <div id="el_sco_mttotecnico_fecha_registro" class="ew-search-field">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="x_fecha_registro" id="x_fecha_registro" data-table="sco_mttotecnico" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_mttotecnicosrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_mttotecnicosrch", "x_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_sco_mttotecnico_fecha_registro" class="ew-search-field2">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="y_fecha_registro" id="y_fecha_registro" data-table="sco_mttotecnico" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_mttotecnicosrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_mttotecnicosrch", "y_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
<?php
if (!$Page->requiere_materiales->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_requiere_materiales" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->requiere_materiales->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_requiere_materiales" class="ew-search-caption ew-label"><?= $Page->requiere_materiales->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_requiere_materiales" id="z_requiere_materiales" value="=">
</div>
        </div>
        <div id="el_sco_mttotecnico_requiere_materiales" class="ew-search-field">
    <select
        id="x_requiere_materiales"
        name="x_requiere_materiales"
        class="form-select ew-select<?= $Page->requiere_materiales->isInvalidClass() ?>"
        <?php if (!$Page->requiere_materiales->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicosrch_x_requiere_materiales"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_requiere_materiales"
        data-value-separator="<?= $Page->requiere_materiales->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->requiere_materiales->getPlaceHolder()) ?>"
        <?= $Page->requiere_materiales->editAttributes() ?>>
        <?= $Page->requiere_materiales->selectOptionListHtml("x_requiere_materiales") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->requiere_materiales->getErrorMessage(false) ?></div>
<?php if (!$Page->requiere_materiales->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicosrch", function() {
    var options = { name: "x_requiere_materiales", selectId: "fsco_mttotecnicosrch_x_requiere_materiales" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicosrch.lists.requiere_materiales?.lookupOptions.length) {
        options.data = { id: "x_requiere_materiales", form: "fsco_mttotecnicosrch" };
    } else {
        options.ajax = { id: "x_requiere_materiales", form: "fsco_mttotecnicosrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.requiere_materiales.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_mttotecnicosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_mttotecnicosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_mttotecnicosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_mttotecnicosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_mttotecnico">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_mttotecnico" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_mttotecnicolist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nmttotecnico->Visible) { // Nmttotecnico ?>
        <th data-name="Nmttotecnico" class="<?= $Page->Nmttotecnico->headerCellClass() ?>"><div id="elh_sco_mttotecnico_Nmttotecnico" class="sco_mttotecnico_Nmttotecnico"><?= $Page->renderFieldHeader($Page->Nmttotecnico) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_sco_mttotecnico_fecha_registro" class="sco_mttotecnico_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
<?php } ?>
<?php if ($Page->user_solicita->Visible) { // user_solicita ?>
        <th data-name="user_solicita" class="<?= $Page->user_solicita->headerCellClass() ?>"><div id="elh_sco_mttotecnico_user_solicita" class="sco_mttotecnico_user_solicita"><?= $Page->renderFieldHeader($Page->user_solicita) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
        <th data-name="tipo_solicitud" class="<?= $Page->tipo_solicitud->headerCellClass() ?>"><div id="elh_sco_mttotecnico_tipo_solicitud" class="sco_mttotecnico_tipo_solicitud"><?= $Page->renderFieldHeader($Page->tipo_solicitud) ?></div></th>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <th data-name="unidad_solicitante" class="<?= $Page->unidad_solicitante->headerCellClass() ?>"><div id="elh_sco_mttotecnico_unidad_solicitante" class="sco_mttotecnico_unidad_solicitante"><?= $Page->renderFieldHeader($Page->unidad_solicitante) ?></div></th>
<?php } ?>
<?php if ($Page->area_falla->Visible) { // area_falla ?>
        <th data-name="area_falla" class="<?= $Page->area_falla->headerCellClass() ?>"><div id="elh_sco_mttotecnico_area_falla" class="sco_mttotecnico_area_falla"><?= $Page->renderFieldHeader($Page->area_falla) ?></div></th>
<?php } ?>
<?php if ($Page->prioridad->Visible) { // prioridad ?>
        <th data-name="prioridad" class="<?= $Page->prioridad->headerCellClass() ?>"><div id="elh_sco_mttotecnico_prioridad" class="sco_mttotecnico_prioridad"><?= $Page->renderFieldHeader($Page->prioridad) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_sco_mttotecnico_estatus" class="sco_mttotecnico_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
<?php } ?>
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
        <th data-name="diagnostico" class="<?= $Page->diagnostico->headerCellClass() ?>"><div id="elh_sco_mttotecnico_diagnostico" class="sco_mttotecnico_diagnostico"><?= $Page->renderFieldHeader($Page->diagnostico) ?></div></th>
<?php } ?>
<?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
        <th data-name="requiere_materiales" class="<?= $Page->requiere_materiales->headerCellClass() ?>"><div id="elh_sco_mttotecnico_requiere_materiales" class="sco_mttotecnico_requiere_materiales"><?= $Page->renderFieldHeader($Page->requiere_materiales) ?></div></th>
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
    <?php if ($Page->Nmttotecnico->Visible) { // Nmttotecnico ?>
        <td data-name="Nmttotecnico"<?= $Page->Nmttotecnico->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_Nmttotecnico" class="el_sco_mttotecnico_Nmttotecnico">
<span<?= $Page->Nmttotecnico->viewAttributes() ?>>
<?= $Page->Nmttotecnico->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_fecha_registro" class="el_sco_mttotecnico_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_solicita->Visible) { // user_solicita ?>
        <td data-name="user_solicita"<?= $Page->user_solicita->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_user_solicita" class="el_sco_mttotecnico_user_solicita">
<span<?= $Page->user_solicita->viewAttributes() ?>>
<?= $Page->user_solicita->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
        <td data-name="tipo_solicitud"<?= $Page->tipo_solicitud->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_tipo_solicitud" class="el_sco_mttotecnico_tipo_solicitud">
<span<?= $Page->tipo_solicitud->viewAttributes() ?>>
<?= $Page->tipo_solicitud->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
        <td data-name="unidad_solicitante"<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_unidad_solicitante" class="el_sco_mttotecnico_unidad_solicitante">
<span<?= $Page->unidad_solicitante->viewAttributes() ?>>
<?= $Page->unidad_solicitante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->area_falla->Visible) { // area_falla ?>
        <td data-name="area_falla"<?= $Page->area_falla->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_area_falla" class="el_sco_mttotecnico_area_falla">
<span<?= $Page->area_falla->viewAttributes() ?>>
<?= $Page->area_falla->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->prioridad->Visible) { // prioridad ?>
        <td data-name="prioridad"<?= $Page->prioridad->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_prioridad" class="el_sco_mttotecnico_prioridad">
<span<?= $Page->prioridad->viewAttributes() ?>>
<?= $Page->prioridad->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_estatus" class="el_sco_mttotecnico_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->diagnostico->Visible) { // diagnostico ?>
        <td data-name="diagnostico"<?= $Page->diagnostico->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_diagnostico" class="el_sco_mttotecnico_diagnostico">
<span<?= $Page->diagnostico->viewAttributes() ?>>
<?= $Page->diagnostico->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
        <td data-name="requiere_materiales"<?= $Page->requiere_materiales->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mttotecnico_requiere_materiales" class="el_sco_mttotecnico_requiere_materiales">
<span<?= $Page->requiere_materiales->viewAttributes() ?>>
<?= $Page->requiere_materiales->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_mttotecnico");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
