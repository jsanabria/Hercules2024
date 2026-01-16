<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionTicketList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_ticket: currentTable } });
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
<form name="fautogestion_ticketsrch" id="fautogestion_ticketsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fautogestion_ticketsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_ticket: currentTable } });
var currentForm;
var fautogestion_ticketsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fautogestion_ticketsrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["contactado", [], fields.contactado.isInvalid],
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
            "contactado": <?= $Page->contactado->toClientList($Page) ?>,
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
<?php if ($Page->contactado->Visible) { // contactado ?>
<?php
if (!$Page->contactado->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_contactado" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->contactado->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_contactado" class="ew-search-caption ew-label"><?= $Page->contactado->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_contactado" id="z_contactado" value="=">
</div>
        </div>
        <div id="el_autogestion_ticket_contactado" class="ew-search-field">
    <select
        id="x_contactado"
        name="x_contactado"
        class="form-select ew-select<?= $Page->contactado->isInvalidClass() ?>"
        <?php if (!$Page->contactado->IsNativeSelect) { ?>
        data-select2-id="fautogestion_ticketsrch_x_contactado"
        <?php } ?>
        data-table="autogestion_ticket"
        data-field="x_contactado"
        data-value-separator="<?= $Page->contactado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->contactado->getPlaceHolder()) ?>"
        <?= $Page->contactado->editAttributes() ?>>
        <?= $Page->contactado->selectOptionListHtml("x_contactado") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->contactado->getErrorMessage(false) ?></div>
<?php if (!$Page->contactado->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_ticketsrch", function() {
    var options = { name: "x_contactado", selectId: "fautogestion_ticketsrch_x_contactado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_ticketsrch.lists.contactado?.lookupOptions.length) {
        options.data = { id: "x_contactado", form: "fautogestion_ticketsrch" };
    } else {
        options.ajax = { id: "x_contactado", form: "fautogestion_ticketsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_ticket.fields.contactado.selectOptions);
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
        <div id="el_autogestion_ticket_estatus" class="ew-search-field">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fautogestion_ticketsrch_x_estatus"
        <?php } ?>
        data-table="autogestion_ticket"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage(false) ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_ticketsrch", function() {
    var options = { name: "x_estatus", selectId: "fautogestion_ticketsrch_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_ticketsrch.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fautogestion_ticketsrch" };
    } else {
        options.ajax = { id: "x_estatus", form: "fautogestion_ticketsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_ticket.fields.estatus.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fautogestion_ticketsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fautogestion_ticketsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fautogestion_ticketsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fautogestion_ticketsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="autogestion_ticket">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_autogestion_ticket" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_autogestion_ticketlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nticket->Visible) { // Nticket ?>
        <th data-name="Nticket" class="<?= $Page->Nticket->headerCellClass() ?>"><div id="elh_autogestion_ticket_Nticket" class="autogestion_ticket_Nticket"><?= $Page->renderFieldHeader($Page->Nticket) ?></div></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Page->fecha->headerCellClass() ?>"><div id="elh_autogestion_ticket_fecha" class="autogestion_ticket_fecha"><?= $Page->renderFieldHeader($Page->fecha) ?></div></th>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th data-name="servicio_tipo" class="<?= $Page->servicio_tipo->headerCellClass() ?>"><div id="elh_autogestion_ticket_servicio_tipo" class="autogestion_ticket_servicio_tipo"><?= $Page->renderFieldHeader($Page->servicio_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
        <th data-name="cedula" class="<?= $Page->cedula->headerCellClass() ?>"><div id="elh_autogestion_ticket_cedula" class="autogestion_ticket_cedula"><?= $Page->renderFieldHeader($Page->cedula) ?></div></th>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
        <th data-name="nombre" class="<?= $Page->nombre->headerCellClass() ?>"><div id="elh_autogestion_ticket_nombre" class="autogestion_ticket_nombre"><?= $Page->renderFieldHeader($Page->nombre) ?></div></th>
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
        <th data-name="apellido" class="<?= $Page->apellido->headerCellClass() ?>"><div id="elh_autogestion_ticket_apellido" class="autogestion_ticket_apellido"><?= $Page->renderFieldHeader($Page->apellido) ?></div></th>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
        <th data-name="telefono1" class="<?= $Page->telefono1->headerCellClass() ?>"><div id="elh_autogestion_ticket_telefono1" class="autogestion_ticket_telefono1"><?= $Page->renderFieldHeader($Page->telefono1) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th data-name="cedula_fallecido" class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><div id="elh_autogestion_ticket_cedula_fallecido" class="autogestion_ticket_cedula_fallecido"><?= $Page->renderFieldHeader($Page->cedula_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th data-name="nombre_fallecido" class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><div id="elh_autogestion_ticket_nombre_fallecido" class="autogestion_ticket_nombre_fallecido"><?= $Page->renderFieldHeader($Page->nombre_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->apellido_fallecido->Visible) { // apellido_fallecido ?>
        <th data-name="apellido_fallecido" class="<?= $Page->apellido_fallecido->headerCellClass() ?>"><div id="elh_autogestion_ticket_apellido_fallecido" class="autogestion_ticket_apellido_fallecido"><?= $Page->renderFieldHeader($Page->apellido_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->contactado->Visible) { // contactado ?>
        <th data-name="contactado" class="<?= $Page->contactado->headerCellClass() ?>"><div id="elh_autogestion_ticket_contactado" class="autogestion_ticket_contactado"><?= $Page->renderFieldHeader($Page->contactado) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_autogestion_ticket_estatus" class="autogestion_ticket_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
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
    <?php if ($Page->Nticket->Visible) { // Nticket ?>
        <td data-name="Nticket"<?= $Page->Nticket->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_Nticket" class="el_autogestion_ticket_Nticket">
<span<?= $Page->Nticket->viewAttributes() ?>>
<?= $Page->Nticket->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_fecha" class="el_autogestion_ticket_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_servicio_tipo" class="el_autogestion_ticket_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula->Visible) { // cedula ?>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_cedula" class="el_autogestion_ticket_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre->Visible) { // nombre ?>
        <td data-name="nombre"<?= $Page->nombre->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_nombre" class="el_autogestion_ticket_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido->Visible) { // apellido ?>
        <td data-name="apellido"<?= $Page->apellido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_apellido" class="el_autogestion_ticket_apellido">
<span<?= $Page->apellido->viewAttributes() ?>>
<?= $Page->apellido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefono1->Visible) { // telefono1 ?>
        <td data-name="telefono1"<?= $Page->telefono1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_telefono1" class="el_autogestion_ticket_telefono1">
<span<?= $Page->telefono1->viewAttributes() ?>>
<?= $Page->telefono1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_cedula_fallecido" class="el_autogestion_ticket_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_nombre_fallecido" class="el_autogestion_ticket_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido_fallecido->Visible) { // apellido_fallecido ?>
        <td data-name="apellido_fallecido"<?= $Page->apellido_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_apellido_fallecido" class="el_autogestion_ticket_apellido_fallecido">
<span<?= $Page->apellido_fallecido->viewAttributes() ?>>
<?= $Page->apellido_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contactado->Visible) { // contactado ?>
        <td data-name="contactado"<?= $Page->contactado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_contactado" class="el_autogestion_ticket_contactado">
<span<?= $Page->contactado->viewAttributes() ?>>
<?= $Page->contactado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_autogestion_ticket_estatus" class="el_autogestion_ticket_estatus">
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
    ew.addEventHandlers("autogestion_ticket");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
