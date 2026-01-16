<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewFallecidosList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_fallecidos: currentTable } });
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
    // Client script
    // Write your client script here, no need to add script tags.
    window.CrearGrama = function (xParcela, xNombre) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `Se creará un nuevo registro para el fallecido: ${xNombre}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, crear registro',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Usamos URLSearchParams para construir la URL de forma segura
                const params = new URLSearchParams({ id: xParcela });
                window.location.href = `CrearGrama?${params.toString()}`;
            }
        });
    };
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
<form name="fview_fallecidossrch" id="fview_fallecidossrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_fallecidossrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_fallecidos: currentTable } });
var currentForm;
var fview_fallecidossrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_fallecidossrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["seccion", [], fields.seccion.isInvalid],
            ["modulo", [], fields.modulo.isInvalid],
            ["sub_seccion", [], fields.sub_seccion.isInvalid],
            ["parcela", [], fields.parcela.isInvalid],
            ["ci_difunto", [], fields.ci_difunto.isInvalid],
            ["apellido1", [], fields.apellido1.isInvalid],
            ["apellido2", [], fields.apellido2.isInvalid],
            ["nombre1", [], fields.nombre1.isInvalid]
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
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_seccion" id="z_seccion" value="LIKE">
</div>
        </div>
        <div id="el_view_fallecidos_seccion" class="ew-search-field">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="view_fallecidos" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?>>
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
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_modulo" id="z_modulo" value="LIKE">
</div>
        </div>
        <div id="el_view_fallecidos_modulo" class="ew-search-field">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="view_fallecidos" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?>>
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
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_sub_seccion" id="z_sub_seccion" value="LIKE">
</div>
        </div>
        <div id="el_view_fallecidos_sub_seccion" class="ew-search-field">
<input type="<?= $Page->sub_seccion->getInputTextType() ?>" name="x_sub_seccion" id="x_sub_seccion" data-table="view_fallecidos" data-field="x_sub_seccion" value="<?= $Page->sub_seccion->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sub_seccion->formatPattern()) ?>"<?= $Page->sub_seccion->editAttributes() ?>>
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
        <div id="el_view_fallecidos_parcela" class="ew-search-field">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="view_fallecidos" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage(false) ?></div>
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
        <div id="el_view_fallecidos_ci_difunto" class="ew-search-field">
<input type="<?= $Page->ci_difunto->getInputTextType() ?>" name="x_ci_difunto" id="x_ci_difunto" data-table="view_fallecidos" data-field="x_ci_difunto" value="<?= $Page->ci_difunto->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_difunto->formatPattern()) ?>"<?= $Page->ci_difunto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ci_difunto->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
<?php
if (!$Page->apellido1->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_apellido1" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->apellido1->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_apellido1" class="ew-search-caption ew-label"><?= $Page->apellido1->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_apellido1" id="z_apellido1" value="LIKE">
</div>
        </div>
        <div id="el_view_fallecidos_apellido1" class="ew-search-field">
<input type="<?= $Page->apellido1->getInputTextType() ?>" name="x_apellido1" id="x_apellido1" data-table="view_fallecidos" data-field="x_apellido1" value="<?= $Page->apellido1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido1->formatPattern()) ?>"<?= $Page->apellido1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->apellido1->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
<?php
if (!$Page->apellido2->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_apellido2" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->apellido2->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_apellido2" class="ew-search-caption ew-label"><?= $Page->apellido2->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_apellido2" id="z_apellido2" value="LIKE">
</div>
        </div>
        <div id="el_view_fallecidos_apellido2" class="ew-search-field">
<input type="<?= $Page->apellido2->getInputTextType() ?>" name="x_apellido2" id="x_apellido2" data-table="view_fallecidos" data-field="x_apellido2" value="<?= $Page->apellido2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido2->formatPattern()) ?>"<?= $Page->apellido2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->apellido2->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
<?php
if (!$Page->nombre1->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_nombre1" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->nombre1->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_nombre1" class="ew-search-caption ew-label"><?= $Page->nombre1->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_nombre1" id="z_nombre1" value="LIKE">
</div>
        </div>
        <div id="el_view_fallecidos_nombre1" class="ew-search-field">
<input type="<?= $Page->nombre1->getInputTextType() ?>" name="x_nombre1" id="x_nombre1" data-table="view_fallecidos" data-field="x_nombre1" value="<?= $Page->nombre1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre1->formatPattern()) ?>"<?= $Page->nombre1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombre1->getErrorMessage(false) ?></div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_fallecidossrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_fallecidossrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_fallecidossrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_fallecidossrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_fallecidos">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_fallecidos" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_fallecidoslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->cedula->Visible) { // cedula ?>
        <th data-name="cedula" class="<?= $Page->cedula->headerCellClass() ?>"><div id="elh_view_fallecidos_cedula" class="view_fallecidos_cedula"><?= $Page->renderFieldHeader($Page->cedula) ?></div></th>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
        <th data-name="titular" class="<?= $Page->titular->headerCellClass() ?>"><div id="elh_view_fallecidos_titular" class="view_fallecidos_titular"><?= $Page->renderFieldHeader($Page->titular) ?></div></th>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <th data-name="contrato" class="<?= $Page->contrato->headerCellClass() ?>"><div id="elh_view_fallecidos_contrato" class="view_fallecidos_contrato"><?= $Page->renderFieldHeader($Page->contrato) ?></div></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th data-name="seccion" class="<?= $Page->seccion->headerCellClass() ?>"><div id="elh_view_fallecidos_seccion" class="view_fallecidos_seccion"><?= $Page->renderFieldHeader($Page->seccion) ?></div></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div id="elh_view_fallecidos_modulo" class="view_fallecidos_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <th data-name="sub_seccion" class="<?= $Page->sub_seccion->headerCellClass() ?>"><div id="elh_view_fallecidos_sub_seccion" class="view_fallecidos_sub_seccion"><?= $Page->renderFieldHeader($Page->sub_seccion) ?></div></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Page->parcela->headerCellClass() ?>"><div id="elh_view_fallecidos_parcela" class="view_fallecidos_parcela"><?= $Page->renderFieldHeader($Page->parcela) ?></div></th>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
        <th data-name="boveda" class="<?= $Page->boveda->headerCellClass() ?>"><div id="elh_view_fallecidos_boveda" class="view_fallecidos_boveda"><?= $Page->renderFieldHeader($Page->boveda) ?></div></th>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <th data-name="ci_difunto" class="<?= $Page->ci_difunto->headerCellClass() ?>"><div id="elh_view_fallecidos_ci_difunto" class="view_fallecidos_ci_difunto"><?= $Page->renderFieldHeader($Page->ci_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <th data-name="apellido1" class="<?= $Page->apellido1->headerCellClass() ?>"><div id="elh_view_fallecidos_apellido1" class="view_fallecidos_apellido1"><?= $Page->renderFieldHeader($Page->apellido1) ?></div></th>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <th data-name="apellido2" class="<?= $Page->apellido2->headerCellClass() ?>"><div id="elh_view_fallecidos_apellido2" class="view_fallecidos_apellido2"><?= $Page->renderFieldHeader($Page->apellido2) ?></div></th>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <th data-name="nombre1" class="<?= $Page->nombre1->headerCellClass() ?>"><div id="elh_view_fallecidos_nombre1" class="view_fallecidos_nombre1"><?= $Page->renderFieldHeader($Page->nombre1) ?></div></th>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <th data-name="nombre2" class="<?= $Page->nombre2->headerCellClass() ?>"><div id="elh_view_fallecidos_nombre2" class="view_fallecidos_nombre2"><?= $Page->renderFieldHeader($Page->nombre2) ?></div></th>
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
    <?php if ($Page->cedula->Visible) { // cedula ?>
        <td data-name="cedula"<?= $Page->cedula->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_cedula" class="el_view_fallecidos_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->titular->Visible) { // titular ?>
        <td data-name="titular"<?= $Page->titular->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_titular" class="el_view_fallecidos_titular">
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contrato->Visible) { // contrato ?>
        <td data-name="contrato"<?= $Page->contrato->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_contrato" class="el_view_fallecidos_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seccion->Visible) { // seccion ?>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_seccion" class="el_view_fallecidos_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo->Visible) { // modulo ?>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_modulo" class="el_view_fallecidos_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <td data-name="sub_seccion"<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_sub_seccion" class="el_view_fallecidos_sub_seccion">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_parcela" class="el_view_fallecidos_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->boveda->Visible) { // boveda ?>
        <td data-name="boveda"<?= $Page->boveda->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_boveda" class="el_view_fallecidos_boveda">
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_ci_difunto" class="el_view_fallecidos_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <td data-name="apellido1"<?= $Page->apellido1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_apellido1" class="el_view_fallecidos_apellido1">
<span<?= $Page->apellido1->viewAttributes() ?>>
<?= $Page->apellido1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <td data-name="apellido2"<?= $Page->apellido2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_apellido2" class="el_view_fallecidos_apellido2">
<span<?= $Page->apellido2->viewAttributes() ?>>
<?= $Page->apellido2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <td data-name="nombre1"<?= $Page->nombre1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_nombre1" class="el_view_fallecidos_nombre1">
<span<?= $Page->nombre1->viewAttributes() ?>>
<?= $Page->nombre1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <td data-name="nombre2"<?= $Page->nombre2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_fallecidos_nombre2" class="el_view_fallecidos_nombre2">
<span<?= $Page->nombre2->viewAttributes() ?>>
<?= $Page->nombre2->getViewValue() ?></span>
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
    ew.addEventHandlers("view_fallecidos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $(document).ready(function() {
        // 1. Auto-seleccionar todo al entrar (Focus)
        $("input:text").on("focus", function() {
            $(this).select();
        });

        // 2. x_seccion: Longitud TOTAL de 3 (rellena a la derecha)
        // Ejemplo: "27" -> "27 "
        $("#x_seccion").on("blur", function() {
            let valor = $(this).val().trim();
            if (valor !== "") {
                $(this).val(valor.padEnd(3, ' ')); 
            }
        });

        // 3. x_modulo y x_sub_seccion: Longitud TOTAL de 3 (rellena a la izquierda)
        // Ejemplo: "A" -> "  A"
        $("#x_modulo, #x_sub_seccion").on("blur", function() {
            let valor = $(this).val().trim();
            if (valor !== "") {
                $(this).val(valor.padStart(3, ' '));
            }
        });

        // 4. x_contrato: Longitud TOTAL de 8 (rellena a la izquierda)
        // Ejemplo: "123" -> "     123"
        $("#x_contrato").on("blur", function() {
            let valor = $(this).val().trim();
            if (valor !== "") {
                $(this).val(valor.padStart(8, ' '));
            }
        });
    });
});
</script>
<?php } ?>
