<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMascotaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mascota: currentTable } });
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
<?php if (!$Page->IsModal) { ?>
<form name="fsco_mascotasrch" id="fsco_mascotasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_mascotasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mascota: currentTable } });
var currentForm;
var fsco_mascotasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_mascotasrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
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
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_mascotasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_mascotasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_mascotasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_mascotasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_mascota">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_mascota" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_mascotalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Nmascota->Visible) { // Nmascota ?>
        <th data-name="Nmascota" class="<?= $Page->Nmascota->headerCellClass() ?>"><div id="elh_sco_mascota_Nmascota" class="sco_mascota_Nmascota"><?= $Page->renderFieldHeader($Page->Nmascota) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_contratante->Visible) { // nombre_contratante ?>
        <th data-name="nombre_contratante" class="<?= $Page->nombre_contratante->headerCellClass() ?>"><div id="elh_sco_mascota_nombre_contratante" class="sco_mascota_nombre_contratante"><?= $Page->renderFieldHeader($Page->nombre_contratante) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_contratante->Visible) { // cedula_contratante ?>
        <th data-name="cedula_contratante" class="<?= $Page->cedula_contratante->headerCellClass() ?>"><div id="elh_sco_mascota_cedula_contratante" class="sco_mascota_cedula_contratante"><?= $Page->renderFieldHeader($Page->cedula_contratante) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_mascota->Visible) { // nombre_mascota ?>
        <th data-name="nombre_mascota" class="<?= $Page->nombre_mascota->headerCellClass() ?>"><div id="elh_sco_mascota_nombre_mascota" class="sco_mascota_nombre_mascota"><?= $Page->renderFieldHeader($Page->nombre_mascota) ?></div></th>
<?php } ?>
<?php if ($Page->raza->Visible) { // raza ?>
        <th data-name="raza" class="<?= $Page->raza->headerCellClass() ?>"><div id="elh_sco_mascota_raza" class="sco_mascota_raza"><?= $Page->renderFieldHeader($Page->raza) ?></div></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th data-name="tipo" class="<?= $Page->tipo->headerCellClass() ?>"><div id="elh_sco_mascota_tipo" class="sco_mascota_tipo"><?= $Page->renderFieldHeader($Page->tipo) ?></div></th>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
        <th data-name="color" class="<?= $Page->color->headerCellClass() ?>"><div id="elh_sco_mascota_color" class="sco_mascota_color"><?= $Page->renderFieldHeader($Page->color) ?></div></th>
<?php } ?>
<?php if ($Page->procedencia->Visible) { // procedencia ?>
        <th data-name="procedencia" class="<?= $Page->procedencia->headerCellClass() ?>"><div id="elh_sco_mascota_procedencia" class="sco_mascota_procedencia"><?= $Page->renderFieldHeader($Page->procedencia) ?></div></th>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <th data-name="factura" class="<?= $Page->factura->headerCellClass() ?>"><div id="elh_sco_mascota_factura" class="sco_mascota_factura"><?= $Page->renderFieldHeader($Page->factura) ?></div></th>
<?php } ?>
<?php if ($Page->username_registra->Visible) { // username_registra ?>
        <th data-name="username_registra" class="<?= $Page->username_registra->headerCellClass() ?>"><div id="elh_sco_mascota_username_registra" class="sco_mascota_username_registra"><?= $Page->renderFieldHeader($Page->username_registra) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_sco_mascota_fecha_registro" class="sco_mascota_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
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
    <?php if ($Page->Nmascota->Visible) { // Nmascota ?>
        <td data-name="Nmascota"<?= $Page->Nmascota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_Nmascota" class="el_sco_mascota_Nmascota">
<span<?= $Page->Nmascota->viewAttributes() ?>>
<?= $Page->Nmascota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_contratante->Visible) { // nombre_contratante ?>
        <td data-name="nombre_contratante"<?= $Page->nombre_contratante->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_nombre_contratante" class="el_sco_mascota_nombre_contratante">
<span<?= $Page->nombre_contratante->viewAttributes() ?>>
<?= $Page->nombre_contratante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_contratante->Visible) { // cedula_contratante ?>
        <td data-name="cedula_contratante"<?= $Page->cedula_contratante->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_cedula_contratante" class="el_sco_mascota_cedula_contratante">
<span<?= $Page->cedula_contratante->viewAttributes() ?>>
<?= $Page->cedula_contratante->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_mascota->Visible) { // nombre_mascota ?>
        <td data-name="nombre_mascota"<?= $Page->nombre_mascota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_nombre_mascota" class="el_sco_mascota_nombre_mascota">
<span<?= $Page->nombre_mascota->viewAttributes() ?>>
<?= $Page->nombre_mascota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->raza->Visible) { // raza ?>
        <td data-name="raza"<?= $Page->raza->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_raza" class="el_sco_mascota_raza">
<span<?= $Page->raza->viewAttributes() ?>>
<?= $Page->raza->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo->Visible) { // tipo ?>
        <td data-name="tipo"<?= $Page->tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_tipo" class="el_sco_mascota_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->color->Visible) { // color ?>
        <td data-name="color"<?= $Page->color->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_color" class="el_sco_mascota_color">
<span<?= $Page->color->viewAttributes() ?>>
<?= $Page->color->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->procedencia->Visible) { // procedencia ?>
        <td data-name="procedencia"<?= $Page->procedencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_procedencia" class="el_sco_mascota_procedencia">
<span<?= $Page->procedencia->viewAttributes() ?>>
<?= $Page->procedencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->factura->Visible) { // factura ?>
        <td data-name="factura"<?= $Page->factura->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_factura" class="el_sco_mascota_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->username_registra->Visible) { // username_registra ?>
        <td data-name="username_registra"<?= $Page->username_registra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_username_registra" class="el_sco_mascota_username_registra">
<span<?= $Page->username_registra->viewAttributes() ?>>
<?= $Page->username_registra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_mascota_fecha_registro" class="el_sco_mascota_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_mascota");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
