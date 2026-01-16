<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaDetalleList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: currentTable } });
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "sco_costos_tarifa") {
    if ($Page->MasterRecordExists) {
        include_once "views/ScoCostosTarifaMaster.php";
    }
}
?>
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fsco_costos_tarifa_detallesrch" id="fsco_costos_tarifa_detallesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_costos_tarifa_detallesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: currentTable } });
var currentForm;
var fsco_costos_tarifa_detallesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifa_detallesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["cerrado", [], fields.cerrado.isInvalid]
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
            "cerrado": <?= $Page->cerrado->toClientList($Page) ?>,
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
<?php if ($Page->cerrado->Visible) { // cerrado ?>
<?php
if (!$Page->cerrado->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_cerrado" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->cerrado->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_cerrado" class="ew-search-caption ew-label"><?= $Page->cerrado->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_cerrado" id="z_cerrado" value="=">
</div>
        </div>
        <div id="el_sco_costos_tarifa_detalle_cerrado" class="ew-search-field">
    <select
        id="x_cerrado"
        name="x_cerrado"
        class="form-select ew-select<?= $Page->cerrado->isInvalidClass() ?>"
        <?php if (!$Page->cerrado->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallesrch_x_cerrado"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_cerrado"
        data-value-separator="<?= $Page->cerrado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cerrado->getPlaceHolder()) ?>"
        <?= $Page->cerrado->editAttributes() ?>>
        <?= $Page->cerrado->selectOptionListHtml("x_cerrado") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->cerrado->getErrorMessage(false) ?></div>
<?php if (!$Page->cerrado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallesrch", function() {
    var options = { name: "x_cerrado", selectId: "fsco_costos_tarifa_detallesrch_x_cerrado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallesrch.lists.cerrado?.lookupOptions.length) {
        options.data = { id: "x_cerrado", form: "fsco_costos_tarifa_detallesrch" };
    } else {
        options.ajax = { id: "x_cerrado", form: "fsco_costos_tarifa_detallesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.cerrado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
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
<input type="hidden" name="t" value="sco_costos_tarifa_detalle">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "sco_costos_tarifa" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_costos_tarifa">
<input type="hidden" name="fk_Ncostos_tarifa" value="<?= HtmlEncode($Page->costos_tarifa->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_sco_costos_tarifa_detalle" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_costos_tarifa_detallelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->cap->Visible) { // cap ?>
        <th data-name="cap" class="<?= $Page->cap->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_cap" class="sco_costos_tarifa_detalle_cap"><?= $Page->renderFieldHeader($Page->cap) ?></div></th>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
        <th data-name="ata" class="<?= $Page->ata->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_ata" class="sco_costos_tarifa_detalle_ata"><?= $Page->renderFieldHeader($Page->ata) ?></div></th>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
        <th data-name="obi" class="<?= $Page->obi->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_obi" class="sco_costos_tarifa_detalle_obi"><?= $Page->renderFieldHeader($Page->obi) ?></div></th>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
        <th data-name="fot" class="<?= $Page->fot->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_fot" class="sco_costos_tarifa_detalle_fot"><?= $Page->renderFieldHeader($Page->fot) ?></div></th>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
        <th data-name="man" class="<?= $Page->man->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_man" class="sco_costos_tarifa_detalle_man"><?= $Page->renderFieldHeader($Page->man) ?></div></th>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
        <th data-name="gas" class="<?= $Page->gas->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_gas" class="sco_costos_tarifa_detalle_gas"><?= $Page->renderFieldHeader($Page->gas) ?></div></th>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
        <th data-name="com" class="<?= $Page->com->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_com" class="sco_costos_tarifa_detalle_com"><?= $Page->renderFieldHeader($Page->com) ?></div></th>
<?php } ?>
<?php if ($Page->base->Visible) { // base ?>
        <th data-name="base" class="<?= $Page->base->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_base" class="sco_costos_tarifa_detalle_base"><?= $Page->renderFieldHeader($Page->base) ?></div></th>
<?php } ?>
<?php if ($Page->base_anterior->Visible) { // base_anterior ?>
        <th data-name="base_anterior" class="<?= $Page->base_anterior->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_base_anterior" class="sco_costos_tarifa_detalle_base_anterior"><?= $Page->renderFieldHeader($Page->base_anterior) ?></div></th>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <th data-name="variacion" class="<?= $Page->variacion->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_variacion" class="sco_costos_tarifa_detalle_variacion"><?= $Page->renderFieldHeader($Page->variacion) ?></div></th>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <th data-name="porcentaje" class="<?= $Page->porcentaje->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_porcentaje" class="sco_costos_tarifa_detalle_porcentaje"><?= $Page->renderFieldHeader($Page->porcentaje) ?></div></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Page->fecha->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_fecha" class="sco_costos_tarifa_detalle_fecha"><?= $Page->renderFieldHeader($Page->fecha) ?></div></th>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
        <th data-name="cerrado" class="<?= $Page->cerrado->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_cerrado" class="sco_costos_tarifa_detalle_cerrado"><?= $Page->renderFieldHeader($Page->cerrado) ?></div></th>
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
    <?php if ($Page->cap->Visible) { // cap ?>
        <td data-name="cap"<?= $Page->cap->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_cap" class="el_sco_costos_tarifa_detalle_cap">
<span<?= $Page->cap->viewAttributes() ?>>
<?= $Page->cap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ata->Visible) { // ata ?>
        <td data-name="ata"<?= $Page->ata->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_ata" class="el_sco_costos_tarifa_detalle_ata">
<span<?= $Page->ata->viewAttributes() ?>>
<?= $Page->ata->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->obi->Visible) { // obi ?>
        <td data-name="obi"<?= $Page->obi->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_obi" class="el_sco_costos_tarifa_detalle_obi">
<span<?= $Page->obi->viewAttributes() ?>>
<?= $Page->obi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fot->Visible) { // fot ?>
        <td data-name="fot"<?= $Page->fot->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_fot" class="el_sco_costos_tarifa_detalle_fot">
<span<?= $Page->fot->viewAttributes() ?>>
<?= $Page->fot->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->man->Visible) { // man ?>
        <td data-name="man"<?= $Page->man->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_man" class="el_sco_costos_tarifa_detalle_man">
<span<?= $Page->man->viewAttributes() ?>>
<?= $Page->man->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gas->Visible) { // gas ?>
        <td data-name="gas"<?= $Page->gas->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_gas" class="el_sco_costos_tarifa_detalle_gas">
<span<?= $Page->gas->viewAttributes() ?>>
<?= $Page->gas->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->com->Visible) { // com ?>
        <td data-name="com"<?= $Page->com->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_com" class="el_sco_costos_tarifa_detalle_com">
<span<?= $Page->com->viewAttributes() ?>>
<?= $Page->com->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->base->Visible) { // base ?>
        <td data-name="base"<?= $Page->base->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_base" class="el_sco_costos_tarifa_detalle_base">
<span<?= $Page->base->viewAttributes() ?>>
<?= $Page->base->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->base_anterior->Visible) { // base_anterior ?>
        <td data-name="base_anterior"<?= $Page->base_anterior->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_base_anterior" class="el_sco_costos_tarifa_detalle_base_anterior">
<span<?= $Page->base_anterior->viewAttributes() ?>>
<?= $Page->base_anterior->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->variacion->Visible) { // variacion ?>
        <td data-name="variacion"<?= $Page->variacion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_variacion" class="el_sco_costos_tarifa_detalle_variacion">
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <td data-name="porcentaje"<?= $Page->porcentaje->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_porcentaje" class="el_sco_costos_tarifa_detalle_porcentaje">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_fecha" class="el_sco_costos_tarifa_detalle_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cerrado->Visible) { // cerrado ?>
        <td data-name="cerrado"<?= $Page->cerrado->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_costos_tarifa_detalle_cerrado" class="el_sco_costos_tarifa_detalle_cerrado">
<span<?= $Page->cerrado->viewAttributes() ?>>
<?= $Page->cerrado->getViewValue() ?></span>
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
    ew.addEventHandlers("sco_costos_tarifa_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
