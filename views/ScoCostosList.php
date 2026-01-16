<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos: currentTable } });
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

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["costos_articulos", [fields.costos_articulos.visible && fields.costos_articulos.required ? ew.Validators.required(fields.costos_articulos.caption) : null], fields.costos_articulos.isInvalid],
            ["precio_actual", [fields.precio_actual.visible && fields.precio_actual.required ? ew.Validators.required(fields.precio_actual.caption) : null], fields.precio_actual.isInvalid],
            ["porcentaje_aplicado", [fields.porcentaje_aplicado.visible && fields.porcentaje_aplicado.required ? ew.Validators.required(fields.porcentaje_aplicado.caption) : null, ew.Validators.float], fields.porcentaje_aplicado.isInvalid],
            ["precio_nuevo", [fields.precio_nuevo.visible && fields.precio_nuevo.required ? ew.Validators.required(fields.precio_nuevo.caption) : null, ew.Validators.float], fields.precio_nuevo.isInvalid],
            ["alicuota_iva", [fields.alicuota_iva.visible && fields.alicuota_iva.required ? ew.Validators.required(fields.alicuota_iva.caption) : null], fields.alicuota_iva.isInvalid],
            ["monto_iva", [fields.monto_iva.visible && fields.monto_iva.required ? ew.Validators.required(fields.monto_iva.caption) : null], fields.monto_iva.isInvalid],
            ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null], fields.total.isInvalid],
            ["cerrado", [fields.cerrado.visible && fields.cerrado.required ? ew.Validators.required(fields.cerrado.caption) : null], fields.cerrado.isInvalid]
        ])

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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "costos_articulos": <?= $Page->costos_articulos->toClientList($Page) ?>,
            "cerrado": <?= $Page->cerrado->toClientList($Page) ?>,
        })
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
    // Client script
    // Write your client script here, no need to add script tags.
    function cerrar_ec(xid) {
    	if(confirm("Esta seguro de cerrar esta estructura de costos?")) {
    		window.location.href = "dashboard/costos_estructura_close.php?id=" + xid + "";
    	}
    }

    function aplicar_porc(xid) {
    	var porc = $("#xporc").val();
    	if(porc=="" || porc=="0") return false;
    	if(confirm("Esta seguro de aplicar el porcentaje a toda la estructura de costos?")) {
    		window.location.href = "dashboard/costos_estructura_apli_porc.php?id=" + xid + "&porc=" + porc + "";
    	}
    }
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
<form name="fsco_costossrch" id="fsco_costossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_costossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos: currentTable } });
var currentForm;
var fsco_costossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_costossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["tipo", [], fields.tipo.isInvalid]
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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
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
        <div id="el_sco_costos_tipo" class="ew-search-field">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_costossrch_x_tipo"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage(false) ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costossrch", function() {
    var options = { name: "x_tipo", selectId: "fsco_costossrch_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costossrch.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_costossrch" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_costossrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.tipo.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_costossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_costossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_costossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_costossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_costos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_costos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_costoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_sco_costos_id" class="sco_costos_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Page->fecha->headerCellClass() ?>"><div id="elh_sco_costos_fecha" class="sco_costos_fecha"><?= $Page->renderFieldHeader($Page->fecha) ?></div></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Page->tipo->headerCellClass() ?>"><div id="elh_sco_costos_tipo" class="sco_costos_tipo"><?= $Page->renderFieldHeader($Page->tipo) ?></div></th>
<?php } ?>
<?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
        <th data-name="costos_articulos" class="<?= $Page->costos_articulos->headerCellClass() ?>"><div id="elh_sco_costos_costos_articulos" class="sco_costos_costos_articulos"><?= $Page->renderFieldHeader($Page->costos_articulos) ?></div></th>
<?php } ?>
<?php if ($Page->precio_actual->Visible) { // precio_actual ?>
        <th data-name="precio_actual" class="<?= $Page->precio_actual->headerCellClass() ?>"><div id="elh_sco_costos_precio_actual" class="sco_costos_precio_actual"><?= $Page->renderFieldHeader($Page->precio_actual) ?></div></th>
<?php } ?>
<?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
        <th data-name="porcentaje_aplicado" class="<?= $Page->porcentaje_aplicado->headerCellClass() ?>"><div id="elh_sco_costos_porcentaje_aplicado" class="sco_costos_porcentaje_aplicado"><?= $Page->renderFieldHeader($Page->porcentaje_aplicado) ?></div></th>
<?php } ?>
<?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
        <th data-name="precio_nuevo" class="<?= $Page->precio_nuevo->headerCellClass() ?>"><div id="elh_sco_costos_precio_nuevo" class="sco_costos_precio_nuevo"><?= $Page->renderFieldHeader($Page->precio_nuevo) ?></div></th>
<?php } ?>
<?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
        <th data-name="alicuota_iva" class="<?= $Page->alicuota_iva->headerCellClass() ?>"><div id="elh_sco_costos_alicuota_iva" class="sco_costos_alicuota_iva"><?= $Page->renderFieldHeader($Page->alicuota_iva) ?></div></th>
<?php } ?>
<?php if ($Page->monto_iva->Visible) { // monto_iva ?>
        <th data-name="monto_iva" class="<?= $Page->monto_iva->headerCellClass() ?>"><div id="elh_sco_costos_monto_iva" class="sco_costos_monto_iva"><?= $Page->renderFieldHeader($Page->monto_iva) ?></div></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th data-name="total" class="<?= $Page->total->headerCellClass() ?>"><div id="elh_sco_costos_total" class="sco_costos_total"><?= $Page->renderFieldHeader($Page->total) ?></div></th>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
        <th data-name="cerrado" class="<?= $Page->cerrado->headerCellClass() ?>"><div id="elh_sco_costos_cerrado" class="sco_costos_cerrado"><?= $Page->renderFieldHeader($Page->cerrado) ?></div></th>
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

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_id" class="el_sco_costos_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" data-table="sco_costos" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_id" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_id" class="el_sco_costos_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_id" class="el_sco_costos_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_fecha" class="el_sco_costos_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_fecha" id="x<?= $Page->RowIndex ?>_fecha" data-table="sco_costos" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["<?= $Page->FormName ?>", "datetimepicker"], function () {
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
    ew.createDateTimePicker("<?= $Page->FormName ?>", "x<?= $Page->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_fecha" id="o<?= $Page->RowIndex ?>_fecha" value="<?= HtmlEncode($Page->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_fecha" class="el_sco_costos_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha->getDisplayValue($Page->fecha->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_fecha" data-hidden="1" name="x<?= $Page->RowIndex ?>_fecha" id="x<?= $Page->RowIndex ?>_fecha" value="<?= HtmlEncode($Page->fecha->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_fecha" class="el_sco_costos_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tipo" class="el_sco_costos_tipo">
    <select
        id="x<?= $Page->RowIndex ?>_tipo"
        name="x<?= $Page->RowIndex ?>_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x{$Page->RowIndex}_tipo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_tipo", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_tipo", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_tipo", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_tipo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_tipo" id="o<?= $Page->RowIndex ?>_tipo" value="<?= HtmlEncode($Page->tipo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tipo" class="el_sco_costos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo->getDisplayValue($Page->tipo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos" data-field="x_tipo" data-hidden="1" name="x<?= $Page->RowIndex ?>_tipo" id="x<?= $Page->RowIndex ?>_tipo" value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tipo" class="el_sco_costos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
        <td data-name="costos_articulos"<?= $Page->costos_articulos->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_costos_articulos" class="el_sco_costos_costos_articulos">
    <select
        id="x<?= $Page->RowIndex ?>_costos_articulos"
        name="x<?= $Page->RowIndex ?>_costos_articulos"
        class="form-select ew-select<?= $Page->costos_articulos->isInvalidClass() ?>"
        <?php if (!$Page->costos_articulos->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_costos_articulos"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_costos_articulos"
        data-value-separator="<?= $Page->costos_articulos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->costos_articulos->getPlaceHolder()) ?>"
        <?= $Page->costos_articulos->editAttributes() ?>>
        <?= $Page->costos_articulos->selectOptionListHtml("x{$Page->RowIndex}_costos_articulos") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->costos_articulos->getErrorMessage() ?></div>
<?= $Page->costos_articulos->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_costos_articulos") ?>
<?php if (!$Page->costos_articulos->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_costos_articulos", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_costos_articulos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.costos_articulos?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_costos_articulos", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_costos_articulos", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.costos_articulos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_costos_articulos" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_costos_articulos" id="o<?= $Page->RowIndex ?>_costos_articulos" value="<?= HtmlEncode($Page->costos_articulos->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_costos_articulos" class="el_sco_costos_costos_articulos">
<span<?= $Page->costos_articulos->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->costos_articulos->getDisplayValue($Page->costos_articulos->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos" data-field="x_costos_articulos" data-hidden="1" name="x<?= $Page->RowIndex ?>_costos_articulos" id="x<?= $Page->RowIndex ?>_costos_articulos" value="<?= HtmlEncode($Page->costos_articulos->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_costos_articulos" class="el_sco_costos_costos_articulos">
<span<?= $Page->costos_articulos->viewAttributes() ?>>
<?= $Page->costos_articulos->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->precio_actual->Visible) { // precio_actual ?>
        <td data-name="precio_actual"<?= $Page->precio_actual->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_precio_actual" class="el_sco_costos_precio_actual">
<input type="<?= $Page->precio_actual->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_precio_actual" id="x<?= $Page->RowIndex ?>_precio_actual" data-table="sco_costos" data-field="x_precio_actual" value="<?= $Page->precio_actual->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->precio_actual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio_actual->formatPattern()) ?>"<?= $Page->precio_actual->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->precio_actual->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_precio_actual" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_precio_actual" id="o<?= $Page->RowIndex ?>_precio_actual" value="<?= HtmlEncode($Page->precio_actual->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_precio_actual" class="el_sco_costos_precio_actual">
<span<?= $Page->precio_actual->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->precio_actual->getDisplayValue($Page->precio_actual->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_precio_actual" data-hidden="1" name="x<?= $Page->RowIndex ?>_precio_actual" id="x<?= $Page->RowIndex ?>_precio_actual" value="<?= HtmlEncode($Page->precio_actual->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_precio_actual" class="el_sco_costos_precio_actual">
<span<?= $Page->precio_actual->viewAttributes() ?>>
<?= $Page->precio_actual->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
        <td data-name="porcentaje_aplicado"<?= $Page->porcentaje_aplicado->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_porcentaje_aplicado" class="el_sco_costos_porcentaje_aplicado">
<input type="<?= $Page->porcentaje_aplicado->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_porcentaje_aplicado" id="x<?= $Page->RowIndex ?>_porcentaje_aplicado" data-table="sco_costos" data-field="x_porcentaje_aplicado" value="<?= $Page->porcentaje_aplicado->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->porcentaje_aplicado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentaje_aplicado->formatPattern()) ?>"<?= $Page->porcentaje_aplicado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->porcentaje_aplicado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_porcentaje_aplicado" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_porcentaje_aplicado" id="o<?= $Page->RowIndex ?>_porcentaje_aplicado" value="<?= HtmlEncode($Page->porcentaje_aplicado->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_porcentaje_aplicado" class="el_sco_costos_porcentaje_aplicado">
<input type="<?= $Page->porcentaje_aplicado->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_porcentaje_aplicado" id="x<?= $Page->RowIndex ?>_porcentaje_aplicado" data-table="sco_costos" data-field="x_porcentaje_aplicado" value="<?= $Page->porcentaje_aplicado->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->porcentaje_aplicado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentaje_aplicado->formatPattern()) ?>"<?= $Page->porcentaje_aplicado->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->porcentaje_aplicado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_porcentaje_aplicado" class="el_sco_costos_porcentaje_aplicado">
<span<?= $Page->porcentaje_aplicado->viewAttributes() ?>>
<?= $Page->porcentaje_aplicado->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
        <td data-name="precio_nuevo"<?= $Page->precio_nuevo->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_precio_nuevo" class="el_sco_costos_precio_nuevo">
<input type="<?= $Page->precio_nuevo->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_precio_nuevo" id="x<?= $Page->RowIndex ?>_precio_nuevo" data-table="sco_costos" data-field="x_precio_nuevo" value="<?= $Page->precio_nuevo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->precio_nuevo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio_nuevo->formatPattern()) ?>"<?= $Page->precio_nuevo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->precio_nuevo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_precio_nuevo" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_precio_nuevo" id="o<?= $Page->RowIndex ?>_precio_nuevo" value="<?= HtmlEncode($Page->precio_nuevo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_precio_nuevo" class="el_sco_costos_precio_nuevo">
<input type="<?= $Page->precio_nuevo->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_precio_nuevo" id="x<?= $Page->RowIndex ?>_precio_nuevo" data-table="sco_costos" data-field="x_precio_nuevo" value="<?= $Page->precio_nuevo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->precio_nuevo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio_nuevo->formatPattern()) ?>"<?= $Page->precio_nuevo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->precio_nuevo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_precio_nuevo" class="el_sco_costos_precio_nuevo">
<span<?= $Page->precio_nuevo->viewAttributes() ?>>
<?= $Page->precio_nuevo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
        <td data-name="alicuota_iva"<?= $Page->alicuota_iva->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_alicuota_iva" class="el_sco_costos_alicuota_iva">
<input type="<?= $Page->alicuota_iva->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_alicuota_iva" id="x<?= $Page->RowIndex ?>_alicuota_iva" data-table="sco_costos" data-field="x_alicuota_iva" value="<?= $Page->alicuota_iva->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->alicuota_iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->alicuota_iva->formatPattern()) ?>"<?= $Page->alicuota_iva->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->alicuota_iva->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_alicuota_iva" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_alicuota_iva" id="o<?= $Page->RowIndex ?>_alicuota_iva" value="<?= HtmlEncode($Page->alicuota_iva->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_alicuota_iva" class="el_sco_costos_alicuota_iva">
<span<?= $Page->alicuota_iva->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->alicuota_iva->getDisplayValue($Page->alicuota_iva->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_alicuota_iva" data-hidden="1" name="x<?= $Page->RowIndex ?>_alicuota_iva" id="x<?= $Page->RowIndex ?>_alicuota_iva" value="<?= HtmlEncode($Page->alicuota_iva->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_alicuota_iva" class="el_sco_costos_alicuota_iva">
<span<?= $Page->alicuota_iva->viewAttributes() ?>>
<?= $Page->alicuota_iva->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->monto_iva->Visible) { // monto_iva ?>
        <td data-name="monto_iva"<?= $Page->monto_iva->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_monto_iva" class="el_sco_costos_monto_iva">
<input type="<?= $Page->monto_iva->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_monto_iva" id="x<?= $Page->RowIndex ?>_monto_iva" data-table="sco_costos" data-field="x_monto_iva" value="<?= $Page->monto_iva->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->monto_iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_iva->formatPattern()) ?>"<?= $Page->monto_iva->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->monto_iva->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_monto_iva" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_monto_iva" id="o<?= $Page->RowIndex ?>_monto_iva" value="<?= HtmlEncode($Page->monto_iva->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_monto_iva" class="el_sco_costos_monto_iva">
<span<?= $Page->monto_iva->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->monto_iva->getDisplayValue($Page->monto_iva->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_monto_iva" data-hidden="1" name="x<?= $Page->RowIndex ?>_monto_iva" id="x<?= $Page->RowIndex ?>_monto_iva" value="<?= HtmlEncode($Page->monto_iva->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_monto_iva" class="el_sco_costos_monto_iva">
<span<?= $Page->monto_iva->viewAttributes() ?>>
<?= $Page->monto_iva->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->total->Visible) { // total ?>
        <td data-name="total"<?= $Page->total->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_total" class="el_sco_costos_total">
<input type="<?= $Page->total->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_total" id="x<?= $Page->RowIndex ?>_total" data-table="sco_costos" data-field="x_total" value="<?= $Page->total->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->total->formatPattern()) ?>"<?= $Page->total->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_total" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_total" id="o<?= $Page->RowIndex ?>_total" value="<?= HtmlEncode($Page->total->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_total" class="el_sco_costos_total">
<span<?= $Page->total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->total->getDisplayValue($Page->total->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_total" data-hidden="1" name="x<?= $Page->RowIndex ?>_total" id="x<?= $Page->RowIndex ?>_total" value="<?= HtmlEncode($Page->total->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_total" class="el_sco_costos_total">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->cerrado->Visible) { // cerrado ?>
        <td data-name="cerrado"<?= $Page->cerrado->cellAttributes() ?>>
<?php if ($Page->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_cerrado" class="el_sco_costos_cerrado">
    <select
        id="x<?= $Page->RowIndex ?>_cerrado"
        name="x<?= $Page->RowIndex ?>_cerrado"
        class="form-select ew-select<?= $Page->cerrado->isInvalidClass() ?>"
        <?php if (!$Page->cerrado->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_cerrado"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_cerrado"
        data-value-separator="<?= $Page->cerrado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cerrado->getPlaceHolder()) ?>"
        <?= $Page->cerrado->editAttributes() ?>>
        <?= $Page->cerrado->selectOptionListHtml("x{$Page->RowIndex}_cerrado") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->cerrado->getErrorMessage() ?></div>
<?php if (!$Page->cerrado->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_cerrado", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_cerrado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.cerrado?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_cerrado", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_cerrado", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.cerrado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos" data-field="x_cerrado" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_cerrado" id="o<?= $Page->RowIndex ?>_cerrado" value="<?= HtmlEncode($Page->cerrado->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_cerrado" class="el_sco_costos_cerrado">
<span<?= $Page->cerrado->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cerrado->getDisplayValue($Page->cerrado->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos" data-field="x_cerrado" data-hidden="1" name="x<?= $Page->RowIndex ?>_cerrado" id="x<?= $Page->RowIndex ?>_cerrado" value="<?= HtmlEncode($Page->cerrado->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_cerrado" class="el_sco_costos_cerrado">
<span<?= $Page->cerrado->viewAttributes() ?>>
<?= $Page->cerrado->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == RowType::ADD || $Page->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

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
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
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
    ew.addEventHandlers("sco_costos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
