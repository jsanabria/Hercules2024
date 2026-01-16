<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewParcelaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_parcela: currentTable } });
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
<form name="fview_parcelasrch" id="fview_parcelasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_parcelasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_parcela: currentTable } });
var currentForm;
var fview_parcelasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_parcelasrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_parcelasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_parcelasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_parcelasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_parcelasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="view_parcela">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_parcela" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_parcelalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->nac_difunto->Visible) { // nac_difunto ?>
        <th data-name="nac_difunto" class="<?= $Page->nac_difunto->headerCellClass() ?>"><div id="elh_view_parcela_nac_difunto" class="view_parcela_nac_difunto"><?= $Page->renderFieldHeader($Page->nac_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <th data-name="ci_difunto" class="<?= $Page->ci_difunto->headerCellClass() ?>"><div id="elh_view_parcela_ci_difunto" class="view_parcela_ci_difunto"><?= $Page->renderFieldHeader($Page->ci_difunto) ?></div></th>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <th data-name="apellido1" class="<?= $Page->apellido1->headerCellClass() ?>"><div id="elh_view_parcela_apellido1" class="view_parcela_apellido1"><?= $Page->renderFieldHeader($Page->apellido1) ?></div></th>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <th data-name="apellido2" class="<?= $Page->apellido2->headerCellClass() ?>"><div id="elh_view_parcela_apellido2" class="view_parcela_apellido2"><?= $Page->renderFieldHeader($Page->apellido2) ?></div></th>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <th data-name="nombre1" class="<?= $Page->nombre1->headerCellClass() ?>"><div id="elh_view_parcela_nombre1" class="view_parcela_nombre1"><?= $Page->renderFieldHeader($Page->nombre1) ?></div></th>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <th data-name="nombre2" class="<?= $Page->nombre2->headerCellClass() ?>"><div id="elh_view_parcela_nombre2" class="view_parcela_nombre2"><?= $Page->renderFieldHeader($Page->nombre2) ?></div></th>
<?php } ?>
<?php if ($Page->edad->Visible) { // edad ?>
        <th data-name="edad" class="<?= $Page->edad->headerCellClass() ?>"><div id="elh_view_parcela_edad" class="view_parcela_edad"><?= $Page->renderFieldHeader($Page->edad) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_defuncion->Visible) { // fecha_defuncion ?>
        <th data-name="fecha_defuncion" class="<?= $Page->fecha_defuncion->headerCellClass() ?>"><div id="elh_view_parcela_fecha_defuncion" class="view_parcela_fecha_defuncion"><?= $Page->renderFieldHeader($Page->fecha_defuncion) ?></div></th>
<?php } ?>
<?php if ($Page->causa->Visible) { // causa ?>
        <th data-name="causa" class="<?= $Page->causa->headerCellClass() ?>"><div id="elh_view_parcela_causa" class="view_parcela_causa"><?= $Page->renderFieldHeader($Page->causa) ?></div></th>
<?php } ?>
<?php if ($Page->certificado->Visible) { // certificado ?>
        <th data-name="certificado" class="<?= $Page->certificado->headerCellClass() ?>"><div id="elh_view_parcela_certificado" class="view_parcela_certificado"><?= $Page->renderFieldHeader($Page->certificado) ?></div></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th data-name="funeraria" class="<?= $Page->funeraria->headerCellClass() ?>"><div id="elh_view_parcela_funeraria" class="view_parcela_funeraria"><?= $Page->renderFieldHeader($Page->funeraria) ?></div></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th data-name="seccion" class="<?= $Page->seccion->headerCellClass() ?>"><div id="elh_view_parcela_seccion" class="view_parcela_seccion"><?= $Page->renderFieldHeader($Page->seccion) ?></div></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th data-name="modulo" class="<?= $Page->modulo->headerCellClass() ?>"><div id="elh_view_parcela_modulo" class="view_parcela_modulo"><?= $Page->renderFieldHeader($Page->modulo) ?></div></th>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <th data-name="sub_seccion" class="<?= $Page->sub_seccion->headerCellClass() ?>"><div id="elh_view_parcela_sub_seccion" class="view_parcela_sub_seccion"><?= $Page->renderFieldHeader($Page->sub_seccion) ?></div></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Page->parcela->headerCellClass() ?>"><div id="elh_view_parcela_parcela" class="view_parcela_parcela"><?= $Page->renderFieldHeader($Page->parcela) ?></div></th>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
        <th data-name="boveda" class="<?= $Page->boveda->headerCellClass() ?>"><div id="elh_view_parcela_boveda" class="view_parcela_boveda"><?= $Page->renderFieldHeader($Page->boveda) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <th data-name="fecha_inhumacion" class="<?= $Page->fecha_inhumacion->headerCellClass() ?>"><div id="elh_view_parcela_fecha_inhumacion" class="view_parcela_fecha_inhumacion"><?= $Page->renderFieldHeader($Page->fecha_inhumacion) ?></div></th>
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
    <?php if ($Page->nac_difunto->Visible) { // nac_difunto ?>
        <td data-name="nac_difunto"<?= $Page->nac_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_nac_difunto" class="el_view_parcela_nac_difunto">
<span<?= $Page->nac_difunto->viewAttributes() ?>>
<?= $Page->nac_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
        <td data-name="ci_difunto"<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_ci_difunto" class="el_view_parcela_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<?= $Page->ci_difunto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <td data-name="apellido1"<?= $Page->apellido1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_apellido1" class="el_view_parcela_apellido1">
<span<?= $Page->apellido1->viewAttributes() ?>>
<?= $Page->apellido1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <td data-name="apellido2"<?= $Page->apellido2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_apellido2" class="el_view_parcela_apellido2">
<span<?= $Page->apellido2->viewAttributes() ?>>
<?= $Page->apellido2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <td data-name="nombre1"<?= $Page->nombre1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_nombre1" class="el_view_parcela_nombre1">
<span<?= $Page->nombre1->viewAttributes() ?>>
<?= $Page->nombre1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <td data-name="nombre2"<?= $Page->nombre2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_nombre2" class="el_view_parcela_nombre2">
<span<?= $Page->nombre2->viewAttributes() ?>>
<?= $Page->nombre2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->edad->Visible) { // edad ?>
        <td data-name="edad"<?= $Page->edad->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_edad" class="el_view_parcela_edad">
<span<?= $Page->edad->viewAttributes() ?>>
<?= $Page->edad->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_defuncion->Visible) { // fecha_defuncion ?>
        <td data-name="fecha_defuncion"<?= $Page->fecha_defuncion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_fecha_defuncion" class="el_view_parcela_fecha_defuncion">
<span<?= $Page->fecha_defuncion->viewAttributes() ?>>
<?= $Page->fecha_defuncion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->causa->Visible) { // causa ?>
        <td data-name="causa"<?= $Page->causa->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_causa" class="el_view_parcela_causa">
<span<?= $Page->causa->viewAttributes() ?>>
<?= $Page->causa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->certificado->Visible) { // certificado ?>
        <td data-name="certificado"<?= $Page->certificado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_certificado" class="el_view_parcela_certificado">
<span<?= $Page->certificado->viewAttributes() ?>>
<?= $Page->certificado->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->funeraria->Visible) { // funeraria ?>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_funeraria" class="el_view_parcela_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seccion->Visible) { // seccion ?>
        <td data-name="seccion"<?= $Page->seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_seccion" class="el_view_parcela_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->modulo->Visible) { // modulo ?>
        <td data-name="modulo"<?= $Page->modulo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_modulo" class="el_view_parcela_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <td data-name="sub_seccion"<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_sub_seccion" class="el_view_parcela_sub_seccion">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_parcela" class="el_view_parcela_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->boveda->Visible) { // boveda ?>
        <td data-name="boveda"<?= $Page->boveda->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_boveda" class="el_view_parcela_boveda">
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <td data-name="fecha_inhumacion"<?= $Page->fecha_inhumacion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_parcela_fecha_inhumacion" class="el_view_parcela_fecha_inhumacion">
<span<?= $Page->fecha_inhumacion->viewAttributes() ?>>
<?= $Page->fecha_inhumacion->getViewValue() ?></span>
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
    ew.addEventHandlers("view_parcela");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
