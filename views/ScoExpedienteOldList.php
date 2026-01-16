<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteOldList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_old: currentTable } });
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
<form name="fsco_expediente_oldsrch" id="fsco_expediente_oldsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fsco_expediente_oldsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_old: currentTable } });
var currentForm;
var fsco_expediente_oldsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_oldsrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsco_expediente_oldsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsco_expediente_oldsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsco_expediente_oldsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsco_expediente_oldsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="sco_expediente_old">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_sco_expediente_old" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_sco_expediente_oldlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
        <th data-name="Nexpediente" class="<?= $Page->Nexpediente->headerCellClass() ?>"><div id="elh_sco_expediente_old_Nexpediente" class="sco_expediente_old_Nexpediente"><?= $Page->renderFieldHeader($Page->Nexpediente) ?></div></th>
<?php } ?>
<?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
        <th data-name="tipo_contratacion" class="<?= $Page->tipo_contratacion->headerCellClass() ?>"><div id="elh_sco_expediente_old_tipo_contratacion" class="sco_expediente_old_tipo_contratacion"><?= $Page->renderFieldHeader($Page->tipo_contratacion) ?></div></th>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
        <th data-name="seguro" class="<?= $Page->seguro->headerCellClass() ?>"><div id="elh_sco_expediente_old_seguro" class="sco_expediente_old_seguro"><?= $Page->renderFieldHeader($Page->seguro) ?></div></th>
<?php } ?>
<?php if ($Page->nacionalidad_contacto->Visible) { // nacionalidad_contacto ?>
        <th data-name="nacionalidad_contacto" class="<?= $Page->nacionalidad_contacto->headerCellClass() ?>"><div id="elh_sco_expediente_old_nacionalidad_contacto" class="sco_expediente_old_nacionalidad_contacto"><?= $Page->renderFieldHeader($Page->nacionalidad_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_contacto->Visible) { // cedula_contacto ?>
        <th data-name="cedula_contacto" class="<?= $Page->cedula_contacto->headerCellClass() ?>"><div id="elh_sco_expediente_old_cedula_contacto" class="sco_expediente_old_cedula_contacto"><?= $Page->renderFieldHeader($Page->cedula_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <th data-name="nombre_contacto" class="<?= $Page->nombre_contacto->headerCellClass() ?>"><div id="elh_sco_expediente_old_nombre_contacto" class="sco_expediente_old_nombre_contacto"><?= $Page->renderFieldHeader($Page->nombre_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos_contacto->Visible) { // apellidos_contacto ?>
        <th data-name="apellidos_contacto" class="<?= $Page->apellidos_contacto->headerCellClass() ?>"><div id="elh_sco_expediente_old_apellidos_contacto" class="sco_expediente_old_apellidos_contacto"><?= $Page->renderFieldHeader($Page->apellidos_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
        <th data-name="parentesco_contacto" class="<?= $Page->parentesco_contacto->headerCellClass() ?>"><div id="elh_sco_expediente_old_parentesco_contacto" class="sco_expediente_old_parentesco_contacto"><?= $Page->renderFieldHeader($Page->parentesco_contacto) ?></div></th>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
        <th data-name="telefono_contacto1" class="<?= $Page->telefono_contacto1->headerCellClass() ?>"><div id="elh_sco_expediente_old_telefono_contacto1" class="sco_expediente_old_telefono_contacto1"><?= $Page->renderFieldHeader($Page->telefono_contacto1) ?></div></th>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
        <th data-name="telefono_contacto2" class="<?= $Page->telefono_contacto2->headerCellClass() ?>"><div id="elh_sco_expediente_old_telefono_contacto2" class="sco_expediente_old_telefono_contacto2"><?= $Page->renderFieldHeader($Page->telefono_contacto2) ?></div></th>
<?php } ?>
<?php if ($Page->nacionalidad_fallecido->Visible) { // nacionalidad_fallecido ?>
        <th data-name="nacionalidad_fallecido" class="<?= $Page->nacionalidad_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_old_nacionalidad_fallecido" class="sco_expediente_old_nacionalidad_fallecido"><?= $Page->renderFieldHeader($Page->nacionalidad_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th data-name="cedula_fallecido" class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_old_cedula_fallecido" class="sco_expediente_old_cedula_fallecido"><?= $Page->renderFieldHeader($Page->cedula_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
        <th data-name="sexo" class="<?= $Page->sexo->headerCellClass() ?>"><div id="elh_sco_expediente_old_sexo" class="sco_expediente_old_sexo"><?= $Page->renderFieldHeader($Page->sexo) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th data-name="nombre_fallecido" class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_old_nombre_fallecido" class="sco_expediente_old_nombre_fallecido"><?= $Page->renderFieldHeader($Page->nombre_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th data-name="apellidos_fallecido" class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_old_apellidos_fallecido" class="sco_expediente_old_apellidos_fallecido"><?= $Page->renderFieldHeader($Page->apellidos_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
        <th data-name="fecha_nacimiento" class="<?= $Page->fecha_nacimiento->headerCellClass() ?>"><div id="elh_sco_expediente_old_fecha_nacimiento" class="sco_expediente_old_fecha_nacimiento"><?= $Page->renderFieldHeader($Page->fecha_nacimiento) ?></div></th>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
        <th data-name="edad_fallecido" class="<?= $Page->edad_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_old_edad_fallecido" class="sco_expediente_old_edad_fallecido"><?= $Page->renderFieldHeader($Page->edad_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->estado_civil->Visible) { // estado_civil ?>
        <th data-name="estado_civil" class="<?= $Page->estado_civil->headerCellClass() ?>"><div id="elh_sco_expediente_old_estado_civil" class="sco_expediente_old_estado_civil"><?= $Page->renderFieldHeader($Page->estado_civil) ?></div></th>
<?php } ?>
<?php if ($Page->lugar_nacimiento_fallecido->Visible) { // lugar_nacimiento_fallecido ?>
        <th data-name="lugar_nacimiento_fallecido" class="<?= $Page->lugar_nacimiento_fallecido->headerCellClass() ?>"><div id="elh_sco_expediente_old_lugar_nacimiento_fallecido" class="sco_expediente_old_lugar_nacimiento_fallecido"><?= $Page->renderFieldHeader($Page->lugar_nacimiento_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
        <th data-name="lugar_ocurrencia" class="<?= $Page->lugar_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_old_lugar_ocurrencia" class="sco_expediente_old_lugar_ocurrencia"><?= $Page->renderFieldHeader($Page->lugar_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
        <th data-name="direccion_ocurrencia" class="<?= $Page->direccion_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_old_direccion_ocurrencia" class="sco_expediente_old_direccion_ocurrencia"><?= $Page->renderFieldHeader($Page->direccion_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
        <th data-name="fecha_ocurrencia" class="<?= $Page->fecha_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_old_fecha_ocurrencia" class="sco_expediente_old_fecha_ocurrencia"><?= $Page->renderFieldHeader($Page->fecha_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->hora_ocurrencia->Visible) { // hora_ocurrencia ?>
        <th data-name="hora_ocurrencia" class="<?= $Page->hora_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_old_hora_ocurrencia" class="sco_expediente_old_hora_ocurrencia"><?= $Page->renderFieldHeader($Page->hora_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <th data-name="causa_ocurrencia" class="<?= $Page->causa_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_old_causa_ocurrencia" class="sco_expediente_old_causa_ocurrencia"><?= $Page->renderFieldHeader($Page->causa_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
        <th data-name="causa_otro" class="<?= $Page->causa_otro->headerCellClass() ?>"><div id="elh_sco_expediente_old_causa_otro" class="sco_expediente_old_causa_otro"><?= $Page->renderFieldHeader($Page->causa_otro) ?></div></th>
<?php } ?>
<?php if ($Page->descripcion_ocurrencia->Visible) { // descripcion_ocurrencia ?>
        <th data-name="descripcion_ocurrencia" class="<?= $Page->descripcion_ocurrencia->headerCellClass() ?>"><div id="elh_sco_expediente_old_descripcion_ocurrencia" class="sco_expediente_old_descripcion_ocurrencia"><?= $Page->renderFieldHeader($Page->descripcion_ocurrencia) ?></div></th>
<?php } ?>
<?php if ($Page->calidad->Visible) { // calidad ?>
        <th data-name="calidad" class="<?= $Page->calidad->headerCellClass() ?>"><div id="elh_sco_expediente_old_calidad" class="sco_expediente_old_calidad"><?= $Page->renderFieldHeader($Page->calidad) ?></div></th>
<?php } ?>
<?php if ($Page->costos->Visible) { // costos ?>
        <th data-name="costos" class="<?= $Page->costos->headerCellClass() ?>"><div id="elh_sco_expediente_old_costos" class="sco_expediente_old_costos"><?= $Page->renderFieldHeader($Page->costos) ?></div></th>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
        <th data-name="venta" class="<?= $Page->venta->headerCellClass() ?>"><div id="elh_sco_expediente_old_venta" class="sco_expediente_old_venta"><?= $Page->renderFieldHeader($Page->venta) ?></div></th>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <th data-name="user_registra" class="<?= $Page->user_registra->headerCellClass() ?>"><div id="elh_sco_expediente_old_user_registra" class="sco_expediente_old_user_registra"><?= $Page->renderFieldHeader($Page->user_registra) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th data-name="fecha_registro" class="<?= $Page->fecha_registro->headerCellClass() ?>"><div id="elh_sco_expediente_old_fecha_registro" class="sco_expediente_old_fecha_registro"><?= $Page->renderFieldHeader($Page->fecha_registro) ?></div></th>
<?php } ?>
<?php if ($Page->user_cierra->Visible) { // user_cierra ?>
        <th data-name="user_cierra" class="<?= $Page->user_cierra->headerCellClass() ?>"><div id="elh_sco_expediente_old_user_cierra" class="sco_expediente_old_user_cierra"><?= $Page->renderFieldHeader($Page->user_cierra) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
        <th data-name="fecha_cierre" class="<?= $Page->fecha_cierre->headerCellClass() ?>"><div id="elh_sco_expediente_old_fecha_cierre" class="sco_expediente_old_fecha_cierre"><?= $Page->renderFieldHeader($Page->fecha_cierre) ?></div></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Page->estatus->headerCellClass() ?>"><div id="elh_sco_expediente_old_estatus" class="sco_expediente_old_estatus"><?= $Page->renderFieldHeader($Page->estatus) ?></div></th>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <th data-name="factura" class="<?= $Page->factura->headerCellClass() ?>"><div id="elh_sco_expediente_old_factura" class="sco_expediente_old_factura"><?= $Page->renderFieldHeader($Page->factura) ?></div></th>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
        <th data-name="permiso" class="<?= $Page->permiso->headerCellClass() ?>"><div id="elh_sco_expediente_old_permiso" class="sco_expediente_old_permiso"><?= $Page->renderFieldHeader($Page->permiso) ?></div></th>
<?php } ?>
<?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
        <th data-name="unir_con_expediente" class="<?= $Page->unir_con_expediente->headerCellClass() ?>"><div id="elh_sco_expediente_old_unir_con_expediente" class="sco_expediente_old_unir_con_expediente"><?= $Page->renderFieldHeader($Page->unir_con_expediente) ?></div></th>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
        <th data-name="nota" class="<?= $Page->nota->headerCellClass() ?>"><div id="elh_sco_expediente_old_nota" class="sco_expediente_old_nota"><?= $Page->renderFieldHeader($Page->nota) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_sco_expediente_old__email" class="sco_expediente_old__email"><?= $Page->renderFieldHeader($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
        <th data-name="religion" class="<?= $Page->religion->headerCellClass() ?>"><div id="elh_sco_expediente_old_religion" class="sco_expediente_old_religion"><?= $Page->renderFieldHeader($Page->religion) ?></div></th>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th data-name="servicio_tipo" class="<?= $Page->servicio_tipo->headerCellClass() ?>"><div id="elh_sco_expediente_old_servicio_tipo" class="sco_expediente_old_servicio_tipo"><?= $Page->renderFieldHeader($Page->servicio_tipo) ?></div></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Page->servicio->headerCellClass() ?>"><div id="elh_sco_expediente_old_servicio" class="sco_expediente_old_servicio"><?= $Page->renderFieldHeader($Page->servicio) ?></div></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th data-name="funeraria" class="<?= $Page->funeraria->headerCellClass() ?>"><div id="elh_sco_expediente_old_funeraria" class="sco_expediente_old_funeraria"><?= $Page->renderFieldHeader($Page->funeraria) ?></div></th>
<?php } ?>
<?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
        <th data-name="marca_pasos" class="<?= $Page->marca_pasos->headerCellClass() ?>"><div id="elh_sco_expediente_old_marca_pasos" class="sco_expediente_old_marca_pasos"><?= $Page->renderFieldHeader($Page->marca_pasos) ?></div></th>
<?php } ?>
<?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
        <th data-name="autoriza_cremar" class="<?= $Page->autoriza_cremar->headerCellClass() ?>"><div id="elh_sco_expediente_old_autoriza_cremar" class="sco_expediente_old_autoriza_cremar"><?= $Page->renderFieldHeader($Page->autoriza_cremar) ?></div></th>
<?php } ?>
<?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
        <th data-name="username_autoriza" class="<?= $Page->username_autoriza->headerCellClass() ?>"><div id="elh_sco_expediente_old_username_autoriza" class="sco_expediente_old_username_autoriza"><?= $Page->renderFieldHeader($Page->username_autoriza) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
        <th data-name="fecha_autoriza" class="<?= $Page->fecha_autoriza->headerCellClass() ?>"><div id="elh_sco_expediente_old_fecha_autoriza" class="sco_expediente_old_fecha_autoriza"><?= $Page->renderFieldHeader($Page->fecha_autoriza) ?></div></th>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
        <th data-name="peso" class="<?= $Page->peso->headerCellClass() ?>"><div id="elh_sco_expediente_old_peso" class="sco_expediente_old_peso"><?= $Page->renderFieldHeader($Page->peso) ?></div></th>
<?php } ?>
<?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
        <th data-name="contrato_parcela" class="<?= $Page->contrato_parcela->headerCellClass() ?>"><div id="elh_sco_expediente_old_contrato_parcela" class="sco_expediente_old_contrato_parcela"><?= $Page->renderFieldHeader($Page->contrato_parcela) ?></div></th>
<?php } ?>
<?php if ($Page->email_calidad->Visible) { // email_calidad ?>
        <th data-name="email_calidad" class="<?= $Page->email_calidad->headerCellClass() ?>"><div id="elh_sco_expediente_old_email_calidad" class="sco_expediente_old_email_calidad"><?= $Page->renderFieldHeader($Page->email_calidad) ?></div></th>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
        <th data-name="certificado_defuncion" class="<?= $Page->certificado_defuncion->headerCellClass() ?>"><div id="elh_sco_expediente_old_certificado_defuncion" class="sco_expediente_old_certificado_defuncion"><?= $Page->renderFieldHeader($Page->certificado_defuncion) ?></div></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Page->parcela->headerCellClass() ?>"><div id="elh_sco_expediente_old_parcela" class="sco_expediente_old_parcela"><?= $Page->renderFieldHeader($Page->parcela) ?></div></th>
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
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_Nexpediente" class="el_sco_expediente_old_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?= $Page->Nexpediente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
        <td data-name="tipo_contratacion"<?= $Page->tipo_contratacion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_tipo_contratacion" class="el_sco_expediente_old_tipo_contratacion">
<span<?= $Page->tipo_contratacion->viewAttributes() ?>>
<?= $Page->tipo_contratacion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->seguro->Visible) { // seguro ?>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_seguro" class="el_sco_expediente_old_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nacionalidad_contacto->Visible) { // nacionalidad_contacto ?>
        <td data-name="nacionalidad_contacto"<?= $Page->nacionalidad_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_nacionalidad_contacto" class="el_sco_expediente_old_nacionalidad_contacto">
<span<?= $Page->nacionalidad_contacto->viewAttributes() ?>>
<?= $Page->nacionalidad_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_contacto->Visible) { // cedula_contacto ?>
        <td data-name="cedula_contacto"<?= $Page->cedula_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_cedula_contacto" class="el_sco_expediente_old_cedula_contacto">
<span<?= $Page->cedula_contacto->viewAttributes() ?>>
<?= $Page->cedula_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <td data-name="nombre_contacto"<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_nombre_contacto" class="el_sco_expediente_old_nombre_contacto">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos_contacto->Visible) { // apellidos_contacto ?>
        <td data-name="apellidos_contacto"<?= $Page->apellidos_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_apellidos_contacto" class="el_sco_expediente_old_apellidos_contacto">
<span<?= $Page->apellidos_contacto->viewAttributes() ?>>
<?= $Page->apellidos_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
        <td data-name="parentesco_contacto"<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_parentesco_contacto" class="el_sco_expediente_old_parentesco_contacto">
<span<?= $Page->parentesco_contacto->viewAttributes() ?>>
<?= $Page->parentesco_contacto->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
        <td data-name="telefono_contacto1"<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_telefono_contacto1" class="el_sco_expediente_old_telefono_contacto1">
<span<?= $Page->telefono_contacto1->viewAttributes() ?>>
<?= $Page->telefono_contacto1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
        <td data-name="telefono_contacto2"<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_telefono_contacto2" class="el_sco_expediente_old_telefono_contacto2">
<span<?= $Page->telefono_contacto2->viewAttributes() ?>>
<?= $Page->telefono_contacto2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nacionalidad_fallecido->Visible) { // nacionalidad_fallecido ?>
        <td data-name="nacionalidad_fallecido"<?= $Page->nacionalidad_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_nacionalidad_fallecido" class="el_sco_expediente_old_nacionalidad_fallecido">
<span<?= $Page->nacionalidad_fallecido->viewAttributes() ?>>
<?= $Page->nacionalidad_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_cedula_fallecido" class="el_sco_expediente_old_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sexo->Visible) { // sexo ?>
        <td data-name="sexo"<?= $Page->sexo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_sexo" class="el_sco_expediente_old_sexo">
<span<?= $Page->sexo->viewAttributes() ?>>
<?= $Page->sexo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_nombre_fallecido" class="el_sco_expediente_old_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_apellidos_fallecido" class="el_sco_expediente_old_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
        <td data-name="fecha_nacimiento"<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_fecha_nacimiento" class="el_sco_expediente_old_fecha_nacimiento">
<span<?= $Page->fecha_nacimiento->viewAttributes() ?>>
<?= $Page->fecha_nacimiento->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
        <td data-name="edad_fallecido"<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_edad_fallecido" class="el_sco_expediente_old_edad_fallecido">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<?= $Page->edad_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estado_civil->Visible) { // estado_civil ?>
        <td data-name="estado_civil"<?= $Page->estado_civil->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_estado_civil" class="el_sco_expediente_old_estado_civil">
<span<?= $Page->estado_civil->viewAttributes() ?>>
<?= $Page->estado_civil->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lugar_nacimiento_fallecido->Visible) { // lugar_nacimiento_fallecido ?>
        <td data-name="lugar_nacimiento_fallecido"<?= $Page->lugar_nacimiento_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_lugar_nacimiento_fallecido" class="el_sco_expediente_old_lugar_nacimiento_fallecido">
<span<?= $Page->lugar_nacimiento_fallecido->viewAttributes() ?>>
<?= $Page->lugar_nacimiento_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
        <td data-name="lugar_ocurrencia"<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_lugar_ocurrencia" class="el_sco_expediente_old_lugar_ocurrencia">
<span<?= $Page->lugar_ocurrencia->viewAttributes() ?>>
<?= $Page->lugar_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
        <td data-name="direccion_ocurrencia"<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_direccion_ocurrencia" class="el_sco_expediente_old_direccion_ocurrencia">
<span<?= $Page->direccion_ocurrencia->viewAttributes() ?>>
<?= $Page->direccion_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
        <td data-name="fecha_ocurrencia"<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_fecha_ocurrencia" class="el_sco_expediente_old_fecha_ocurrencia">
<span<?= $Page->fecha_ocurrencia->viewAttributes() ?>>
<?= $Page->fecha_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_ocurrencia->Visible) { // hora_ocurrencia ?>
        <td data-name="hora_ocurrencia"<?= $Page->hora_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_hora_ocurrencia" class="el_sco_expediente_old_hora_ocurrencia">
<span<?= $Page->hora_ocurrencia->viewAttributes() ?>>
<?= $Page->hora_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_causa_ocurrencia" class="el_sco_expediente_old_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->causa_otro->Visible) { // causa_otro ?>
        <td data-name="causa_otro"<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_causa_otro" class="el_sco_expediente_old_causa_otro">
<span<?= $Page->causa_otro->viewAttributes() ?>>
<?= $Page->causa_otro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->descripcion_ocurrencia->Visible) { // descripcion_ocurrencia ?>
        <td data-name="descripcion_ocurrencia"<?= $Page->descripcion_ocurrencia->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_descripcion_ocurrencia" class="el_sco_expediente_old_descripcion_ocurrencia">
<span<?= $Page->descripcion_ocurrencia->viewAttributes() ?>>
<?= $Page->descripcion_ocurrencia->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->calidad->Visible) { // calidad ?>
        <td data-name="calidad"<?= $Page->calidad->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_calidad" class="el_sco_expediente_old_calidad">
<span<?= $Page->calidad->viewAttributes() ?>>
<?= $Page->calidad->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->costos->Visible) { // costos ?>
        <td data-name="costos"<?= $Page->costos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_costos" class="el_sco_expediente_old_costos">
<span<?= $Page->costos->viewAttributes() ?>>
<?= $Page->costos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->venta->Visible) { // venta ?>
        <td data-name="venta"<?= $Page->venta->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_venta" class="el_sco_expediente_old_venta">
<span<?= $Page->venta->viewAttributes() ?>>
<?= $Page->venta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_registra->Visible) { // user_registra ?>
        <td data-name="user_registra"<?= $Page->user_registra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_user_registra" class="el_sco_expediente_old_user_registra">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_fecha_registro" class="el_sco_expediente_old_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->user_cierra->Visible) { // user_cierra ?>
        <td data-name="user_cierra"<?= $Page->user_cierra->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_user_cierra" class="el_sco_expediente_old_user_cierra">
<span<?= $Page->user_cierra->viewAttributes() ?>>
<?= $Page->user_cierra->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
        <td data-name="fecha_cierre"<?= $Page->fecha_cierre->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_fecha_cierre" class="el_sco_expediente_old_fecha_cierre">
<span<?= $Page->fecha_cierre->viewAttributes() ?>>
<?= $Page->fecha_cierre->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_estatus" class="el_sco_expediente_old_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->factura->Visible) { // factura ?>
        <td data-name="factura"<?= $Page->factura->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_factura" class="el_sco_expediente_old_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->permiso->Visible) { // permiso ?>
        <td data-name="permiso"<?= $Page->permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_permiso" class="el_sco_expediente_old_permiso">
<span<?= $Page->permiso->viewAttributes() ?>>
<?= $Page->permiso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
        <td data-name="unir_con_expediente"<?= $Page->unir_con_expediente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_unir_con_expediente" class="el_sco_expediente_old_unir_con_expediente">
<span<?= $Page->unir_con_expediente->viewAttributes() ?>>
<?= $Page->unir_con_expediente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nota->Visible) { // nota ?>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_nota" class="el_sco_expediente_old_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old__email" class="el_sco_expediente_old__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->religion->Visible) { // religion ?>
        <td data-name="religion"<?= $Page->religion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_religion" class="el_sco_expediente_old_religion">
<span<?= $Page->religion->viewAttributes() ?>>
<?= $Page->religion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_servicio_tipo" class="el_sco_expediente_old_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_servicio" class="el_sco_expediente_old_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->funeraria->Visible) { // funeraria ?>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_funeraria" class="el_sco_expediente_old_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
        <td data-name="marca_pasos"<?= $Page->marca_pasos->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_marca_pasos" class="el_sco_expediente_old_marca_pasos">
<span<?= $Page->marca_pasos->viewAttributes() ?>>
<?= $Page->marca_pasos->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
        <td data-name="autoriza_cremar"<?= $Page->autoriza_cremar->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_autoriza_cremar" class="el_sco_expediente_old_autoriza_cremar">
<span<?= $Page->autoriza_cremar->viewAttributes() ?>>
<?= $Page->autoriza_cremar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
        <td data-name="username_autoriza"<?= $Page->username_autoriza->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_username_autoriza" class="el_sco_expediente_old_username_autoriza">
<span<?= $Page->username_autoriza->viewAttributes() ?>>
<?= $Page->username_autoriza->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
        <td data-name="fecha_autoriza"<?= $Page->fecha_autoriza->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_fecha_autoriza" class="el_sco_expediente_old_fecha_autoriza">
<span<?= $Page->fecha_autoriza->viewAttributes() ?>>
<?= $Page->fecha_autoriza->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->peso->Visible) { // peso ?>
        <td data-name="peso"<?= $Page->peso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_peso" class="el_sco_expediente_old_peso">
<span<?= $Page->peso->viewAttributes() ?>>
<?= $Page->peso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
        <td data-name="contrato_parcela"<?= $Page->contrato_parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_contrato_parcela" class="el_sco_expediente_old_contrato_parcela">
<span<?= $Page->contrato_parcela->viewAttributes() ?>>
<?= $Page->contrato_parcela->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->email_calidad->Visible) { // email_calidad ?>
        <td data-name="email_calidad"<?= $Page->email_calidad->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_email_calidad" class="el_sco_expediente_old_email_calidad">
<span<?= $Page->email_calidad->viewAttributes() ?>>
<?= $Page->email_calidad->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
        <td data-name="certificado_defuncion"<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_certificado_defuncion" class="el_sco_expediente_old_certificado_defuncion">
<span<?= $Page->certificado_defuncion->viewAttributes() ?>>
<?= $Page->certificado_defuncion->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_sco_expediente_old_parcela" class="el_sco_expediente_old_parcela">
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
    ew.addEventHandlers("sco_expediente_old");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
