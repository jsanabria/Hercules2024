<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoOrdenCompraDetalleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_orden_compra_detallegrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compra_detallegrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["tipo_insumo", [fields.tipo_insumo.visible && fields.tipo_insumo.required ? ew.Validators.required(fields.tipo_insumo.caption) : null], fields.tipo_insumo.isInvalid],
            ["articulo", [fields.articulo.visible && fields.articulo.required ? ew.Validators.required(fields.articulo.caption) : null], fields.articulo.isInvalid],
            ["unidad_medida", [fields.unidad_medida.visible && fields.unidad_medida.required ? ew.Validators.required(fields.unidad_medida.caption) : null], fields.unidad_medida.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null], fields.cantidad.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["imagen", [fields.imagen.visible && fields.imagen.required ? ew.Validators.fileRequired(fields.imagen.caption) : null], fields.imagen.isInvalid],
            ["disponible", [fields.disponible.visible && fields.disponible.required ? ew.Validators.required(fields.disponible.caption) : null], fields.disponible.isInvalid],
            ["unidad_medida_recibida", [fields.unidad_medida_recibida.visible && fields.unidad_medida_recibida.required ? ew.Validators.required(fields.unidad_medida_recibida.caption) : null], fields.unidad_medida_recibida.isInvalid],
            ["cantidad_recibida", [fields.cantidad_recibida.visible && fields.cantidad_recibida.required ? ew.Validators.required(fields.cantidad_recibida.caption) : null, ew.Validators.float], fields.cantidad_recibida.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["tipo_insumo",false],["articulo",false],["unidad_medida",false],["cantidad",false],["descripcion",false],["imagen",false],["disponible",false],["unidad_medida_recibida",false],["cantidad_recibida",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
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
            "tipo_insumo": <?= $Grid->tipo_insumo->toClientList($Grid) ?>,
            "articulo": <?= $Grid->articulo->toClientList($Grid) ?>,
            "unidad_medida": <?= $Grid->unidad_medida->toClientList($Grid) ?>,
            "disponible": <?= $Grid->disponible->toClientList($Grid) ?>,
            "unidad_medida_recibida": <?= $Grid->unidad_medida_recibida->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<main class="list">
<div id="ew-header-options">
<?php $Grid->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fsco_orden_compra_detallegrid" class="ew-form ew-list-form">
<div id="gmp_sco_orden_compra_detalle" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_orden_compra_detallegrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = RowType::HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->tipo_insumo->Visible) { // tipo_insumo ?>
        <th data-name="tipo_insumo" class="<?= $Grid->tipo_insumo->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_tipo_insumo" class="sco_orden_compra_detalle_tipo_insumo"><?= $Grid->renderFieldHeader($Grid->tipo_insumo) ?></div></th>
<?php } ?>
<?php if ($Grid->articulo->Visible) { // articulo ?>
        <th data-name="articulo" class="<?= $Grid->articulo->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_articulo" class="sco_orden_compra_detalle_articulo"><?= $Grid->renderFieldHeader($Grid->articulo) ?></div></th>
<?php } ?>
<?php if ($Grid->unidad_medida->Visible) { // unidad_medida ?>
        <th data-name="unidad_medida" class="<?= $Grid->unidad_medida->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_unidad_medida" class="sco_orden_compra_detalle_unidad_medida"><?= $Grid->renderFieldHeader($Grid->unidad_medida) ?></div></th>
<?php } ?>
<?php if ($Grid->cantidad->Visible) { // cantidad ?>
        <th data-name="cantidad" class="<?= $Grid->cantidad->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_cantidad" class="sco_orden_compra_detalle_cantidad"><?= $Grid->renderFieldHeader($Grid->cantidad) ?></div></th>
<?php } ?>
<?php if ($Grid->descripcion->Visible) { // descripcion ?>
        <th data-name="descripcion" class="<?= $Grid->descripcion->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_descripcion" class="sco_orden_compra_detalle_descripcion"><?= $Grid->renderFieldHeader($Grid->descripcion) ?></div></th>
<?php } ?>
<?php if ($Grid->imagen->Visible) { // imagen ?>
        <th data-name="imagen" class="<?= $Grid->imagen->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_imagen" class="sco_orden_compra_detalle_imagen"><?= $Grid->renderFieldHeader($Grid->imagen) ?></div></th>
<?php } ?>
<?php if ($Grid->disponible->Visible) { // disponible ?>
        <th data-name="disponible" class="<?= $Grid->disponible->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_disponible" class="sco_orden_compra_detalle_disponible"><?= $Grid->renderFieldHeader($Grid->disponible) ?></div></th>
<?php } ?>
<?php if ($Grid->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <th data-name="unidad_medida_recibida" class="<?= $Grid->unidad_medida_recibida->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_unidad_medida_recibida" class="sco_orden_compra_detalle_unidad_medida_recibida"><?= $Grid->renderFieldHeader($Grid->unidad_medida_recibida) ?></div></th>
<?php } ?>
<?php if ($Grid->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <th data-name="cantidad_recibida" class="<?= $Grid->cantidad_recibida->headerCellClass() ?>"><div id="elh_sco_orden_compra_detalle_cantidad_recibida" class="sco_orden_compra_detalle_cantidad_recibida"><?= $Grid->renderFieldHeader($Grid->cantidad_recibida) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
$isInlineAddOrCopy = ($Grid->isCopy() || $Grid->isAdd());
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Grid->RowIndex == 0) {
    if (
        $Grid->CurrentRow !== false &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Grid->RowIndex == 0)
    ) {
        $Grid->fetch();
    }
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->tipo_insumo->Visible) { // tipo_insumo ?>
        <td data-name="tipo_insumo"<?= $Grid->tipo_insumo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_tipo_insumo" class="el_sco_orden_compra_detalle_tipo_insumo">
    <select
        id="x<?= $Grid->RowIndex ?>_tipo_insumo"
        name="x<?= $Grid->RowIndex ?>_tipo_insumo"
        class="form-select ew-select<?= $Grid->tipo_insumo->isInvalidClass() ?>"
        <?php if (!$Grid->tipo_insumo->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_tipo_insumo"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_tipo_insumo"
        data-value-separator="<?= $Grid->tipo_insumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->tipo_insumo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Grid->tipo_insumo->editAttributes() ?>>
        <?= $Grid->tipo_insumo->selectOptionListHtml("x{$Grid->RowIndex}_tipo_insumo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->tipo_insumo->getErrorMessage() ?></div>
<?= $Grid->tipo_insumo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_tipo_insumo") ?>
<?php if (!$Grid->tipo_insumo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_tipo_insumo", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_tipo_insumo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallegrid.lists.tipo_insumo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_tipo_insumo", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_tipo_insumo", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.tipo_insumo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_tipo_insumo" id="o<?= $Grid->RowIndex ?>_tipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_tipo_insumo" class="el_sco_orden_compra_detalle_tipo_insumo">
<span<?= $Grid->tipo_insumo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->tipo_insumo->getDisplayValue($Grid->tipo_insumo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tipo_insumo" id="x<?= $Grid->RowIndex ?>_tipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_tipo_insumo" class="el_sco_orden_compra_detalle_tipo_insumo">
<span<?= $Grid->tipo_insumo->viewAttributes() ?>>
<?= $Grid->tipo_insumo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_tipo_insumo" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_tipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_tipo_insumo" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_tipo_insumo" value="<?= HtmlEncode($Grid->tipo_insumo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->articulo->Visible) { // articulo ?>
        <td data-name="articulo"<?= $Grid->articulo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_articulo" class="el_sco_orden_compra_detalle_articulo">
    <select
        id="x<?= $Grid->RowIndex ?>_articulo"
        name="x<?= $Grid->RowIndex ?>_articulo"
        class="form-control ew-select<?= $Grid->articulo->isInvalidClass() ?>"
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_articulo"
        data-table="sco_orden_compra_detalle"
        data-field="x_articulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Grid->articulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Grid->articulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->articulo->getPlaceHolder()) ?>"
        <?= $Grid->articulo->editAttributes() ?>>
        <?= $Grid->articulo->selectOptionListHtml("x{$Grid->RowIndex}_articulo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->articulo->getErrorMessage() ?></div>
<?= $Grid->articulo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_articulo") ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_articulo", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_articulo" };
    if (fsco_orden_compra_detallegrid.lists.articulo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_articulo", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_articulo", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.articulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_articulo" id="o<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_articulo" class="el_sco_orden_compra_detalle_articulo">
<span<?= $Grid->articulo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->articulo->getDisplayValue($Grid->articulo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" name="x<?= $Grid->RowIndex ?>_articulo" id="x<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_articulo" class="el_sco_orden_compra_detalle_articulo">
<span<?= $Grid->articulo->viewAttributes() ?>>
<?= $Grid->articulo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_articulo" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_articulo" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_articulo" value="<?= HtmlEncode($Grid->articulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->unidad_medida->Visible) { // unidad_medida ?>
        <td data-name="unidad_medida"<?= $Grid->unidad_medida->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_unidad_medida" class="el_sco_orden_compra_detalle_unidad_medida">
    <select
        id="x<?= $Grid->RowIndex ?>_unidad_medida"
        name="x<?= $Grid->RowIndex ?>_unidad_medida"
        class="form-select ew-select<?= $Grid->unidad_medida->isInvalidClass() ?>"
        <?php if (!$Grid->unidad_medida->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_unidad_medida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida"
        data-value-separator="<?= $Grid->unidad_medida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->unidad_medida->getPlaceHolder()) ?>"
        <?= $Grid->unidad_medida->editAttributes() ?>>
        <?= $Grid->unidad_medida->selectOptionListHtml("x{$Grid->RowIndex}_unidad_medida") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->unidad_medida->getErrorMessage() ?></div>
<?= $Grid->unidad_medida->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_unidad_medida") ?>
<?php if (!$Grid->unidad_medida->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_unidad_medida", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_unidad_medida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallegrid.lists.unidad_medida?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_unidad_medida", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_unidad_medida", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_unidad_medida" id="o<?= $Grid->RowIndex ?>_unidad_medida" value="<?= HtmlEncode($Grid->unidad_medida->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_unidad_medida" class="el_sco_orden_compra_detalle_unidad_medida">
<span<?= $Grid->unidad_medida->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->unidad_medida->getDisplayValue($Grid->unidad_medida->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" name="x<?= $Grid->RowIndex ?>_unidad_medida" id="x<?= $Grid->RowIndex ?>_unidad_medida" value="<?= HtmlEncode($Grid->unidad_medida->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_unidad_medida" class="el_sco_orden_compra_detalle_unidad_medida">
<span<?= $Grid->unidad_medida->viewAttributes() ?>>
<?= $Grid->unidad_medida->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_unidad_medida" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_unidad_medida" value="<?= HtmlEncode($Grid->unidad_medida->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_unidad_medida" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_unidad_medida" value="<?= HtmlEncode($Grid->unidad_medida->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cantidad->Visible) { // cantidad ?>
        <td data-name="cantidad"<?= $Grid->cantidad->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_cantidad" class="el_sco_orden_compra_detalle_cantidad">
<input type="<?= $Grid->cantidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad" id="x<?= $Grid->RowIndex ?>_cantidad" data-table="sco_orden_compra_detalle" data-field="x_cantidad" value="<?= $Grid->cantidad->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad->formatPattern()) ?>"<?= $Grid->cantidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cantidad" id="o<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_cantidad" class="el_sco_orden_compra_detalle_cantidad">
<span<?= $Grid->cantidad->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->cantidad->getDisplayValue($Grid->cantidad->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cantidad" id="x<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_cantidad" class="el_sco_orden_compra_detalle_cantidad">
<span<?= $Grid->cantidad->viewAttributes() ?>>
<?= $Grid->cantidad->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_cantidad" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_cantidad" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_cantidad" value="<?= HtmlEncode($Grid->cantidad->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->descripcion->Visible) { // descripcion ?>
        <td data-name="descripcion"<?= $Grid->descripcion->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_descripcion" class="el_sco_orden_compra_detalle_descripcion">
<input type="<?= $Grid->descripcion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_descripcion" id="x<?= $Grid->RowIndex ?>_descripcion" data-table="sco_orden_compra_detalle" data-field="x_descripcion" value="<?= $Grid->descripcion->EditValue ?>" size="15" maxlength="60" placeholder="<?= HtmlEncode($Grid->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->descripcion->formatPattern()) ?>"<?= $Grid->descripcion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->descripcion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_descripcion" id="o<?= $Grid->RowIndex ?>_descripcion" value="<?= HtmlEncode($Grid->descripcion->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_descripcion" class="el_sco_orden_compra_detalle_descripcion">
<span<?= $Grid->descripcion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->descripcion->getDisplayValue($Grid->descripcion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" name="x<?= $Grid->RowIndex ?>_descripcion" id="x<?= $Grid->RowIndex ?>_descripcion" value="<?= HtmlEncode($Grid->descripcion->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_descripcion" class="el_sco_orden_compra_detalle_descripcion">
<span<?= $Grid->descripcion->viewAttributes() ?>>
<?= $Grid->descripcion->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_descripcion" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_descripcion" value="<?= HtmlEncode($Grid->descripcion->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_descripcion" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_descripcion" value="<?= HtmlEncode($Grid->descripcion->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->imagen->Visible) { // imagen ?>
        <td data-name="imagen"<?= $Grid->imagen->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<div id="fd_x<?= $Grid->RowIndex ?>_imagen" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_imagen"
        name="x<?= $Grid->RowIndex ?>_imagen"
        class="form-control ew-file-input"
        title="<?= $Grid->imagen->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_orden_compra_detalle"
        data-field="x_imagen"
        data-size="255"
        data-accept-file-types="<?= $Grid->imagen->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->imagen->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->imagen->ImageCropper ? 0 : 1 ?>"
        <?= ($Grid->imagen->ReadOnly || $Grid->imagen->Disabled) ? " disabled" : "" ?>
        <?= $Grid->imagen->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <div class="invalid-feedback"><?= $Grid->imagen->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imagen" id= "fn_x<?= $Grid->RowIndex ?>_imagen" value="<?= $Grid->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imagen" id= "fa_x<?= $Grid->RowIndex ?>_imagen" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_imagen" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<div id="fd_x<?= $Grid->RowIndex ?>_imagen">
    <input
        type="file"
        id="x<?= $Grid->RowIndex ?>_imagen"
        name="x<?= $Grid->RowIndex ?>_imagen"
        class="form-control ew-file-input d-none"
        title="<?= $Grid->imagen->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_orden_compra_detalle"
        data-field="x_imagen"
        data-size="255"
        data-accept-file-types="<?= $Grid->imagen->acceptFileTypes() ?>"
        data-max-file-size="<?= $Grid->imagen->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Grid->imagen->ImageCropper ? 0 : 1 ?>"
        <?= $Grid->imagen->editAttributes() ?>
    >
    <div class="invalid-feedback"><?= $Grid->imagen->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_imagen" id= "fn_x<?= $Grid->RowIndex ?>_imagen" value="<?= $Grid->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_imagen" id= "fa_x<?= $Grid->RowIndex ?>_imagen" value="0">
<table id="ft_x<?= $Grid->RowIndex ?>_imagen" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_imagen" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_imagen" id="o<?= $Grid->RowIndex ?>_imagen" value="<?= HtmlEncode($Grid->imagen->OldValue) ?>">
<?php } elseif ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Grid->imagen, $Grid->imagen->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Grid->imagen, $Grid->imagen->EditValue, false) ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_imagen" data-hidden="1" data-old name="x<?= $Grid->RowIndex ?>_imagen" id="x<?= $Grid->RowIndex ?>_imagen" value="<?= HtmlEncode($Grid->imagen->CurrentValue) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_imagen" class="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Grid->imagen, $Grid->imagen->EditValue, false) ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_imagen" data-hidden="1" data-old name="x<?= $Grid->RowIndex ?>_imagen" id="x<?= $Grid->RowIndex ?>_imagen" value="<?= HtmlEncode($Grid->imagen->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->disponible->Visible) { // disponible ?>
        <td data-name="disponible"<?= $Grid->disponible->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_disponible" class="el_sco_orden_compra_detalle_disponible">
    <select
        id="x<?= $Grid->RowIndex ?>_disponible"
        name="x<?= $Grid->RowIndex ?>_disponible"
        class="form-select ew-select<?= $Grid->disponible->isInvalidClass() ?>"
        <?php if (!$Grid->disponible->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_disponible"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_disponible"
        data-value-separator="<?= $Grid->disponible->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->disponible->getPlaceHolder()) ?>"
        <?= $Grid->disponible->editAttributes() ?>>
        <?= $Grid->disponible->selectOptionListHtml("x{$Grid->RowIndex}_disponible") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->disponible->getErrorMessage() ?></div>
<?php if (!$Grid->disponible->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_disponible", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallegrid.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_disponible", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_disponible", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.disponible.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_disponible" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_disponible" id="o<?= $Grid->RowIndex ?>_disponible" value="<?= HtmlEncode($Grid->disponible->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_disponible" class="el_sco_orden_compra_detalle_disponible">
    <select
        id="x<?= $Grid->RowIndex ?>_disponible"
        name="x<?= $Grid->RowIndex ?>_disponible"
        class="form-select ew-select<?= $Grid->disponible->isInvalidClass() ?>"
        <?php if (!$Grid->disponible->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_disponible"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_disponible"
        data-value-separator="<?= $Grid->disponible->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->disponible->getPlaceHolder()) ?>"
        <?= $Grid->disponible->editAttributes() ?>>
        <?= $Grid->disponible->selectOptionListHtml("x{$Grid->RowIndex}_disponible") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->disponible->getErrorMessage() ?></div>
<?php if (!$Grid->disponible->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_disponible", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallegrid.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_disponible", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_disponible", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.disponible.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_disponible" class="el_sco_orden_compra_detalle_disponible">
<span<?= $Grid->disponible->viewAttributes() ?>>
<?= $Grid->disponible->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_disponible" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_disponible" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_disponible" value="<?= HtmlEncode($Grid->disponible->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_disponible" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_disponible" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_disponible" value="<?= HtmlEncode($Grid->disponible->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <td data-name="unidad_medida_recibida"<?= $Grid->unidad_medida_recibida->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_unidad_medida_recibida" class="el_sco_orden_compra_detalle_unidad_medida_recibida">
    <select
        id="x<?= $Grid->RowIndex ?>_unidad_medida_recibida"
        name="x<?= $Grid->RowIndex ?>_unidad_medida_recibida"
        class="form-select ew-select<?= $Grid->unidad_medida_recibida->isInvalidClass() ?>"
        <?php if (!$Grid->unidad_medida_recibida->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_unidad_medida_recibida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida_recibida"
        data-value-separator="<?= $Grid->unidad_medida_recibida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->unidad_medida_recibida->getPlaceHolder()) ?>"
        <?= $Grid->unidad_medida_recibida->editAttributes() ?>>
        <?= $Grid->unidad_medida_recibida->selectOptionListHtml("x{$Grid->RowIndex}_unidad_medida_recibida") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->unidad_medida_recibida->getErrorMessage() ?></div>
<?= $Grid->unidad_medida_recibida->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_unidad_medida_recibida") ?>
<?php if (!$Grid->unidad_medida_recibida->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_unidad_medida_recibida", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_unidad_medida_recibida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallegrid.lists.unidad_medida_recibida?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_unidad_medida_recibida", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_unidad_medida_recibida", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida_recibida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida_recibida" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_unidad_medida_recibida" id="o<?= $Grid->RowIndex ?>_unidad_medida_recibida" value="<?= HtmlEncode($Grid->unidad_medida_recibida->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_unidad_medida_recibida" class="el_sco_orden_compra_detalle_unidad_medida_recibida">
    <select
        id="x<?= $Grid->RowIndex ?>_unidad_medida_recibida"
        name="x<?= $Grid->RowIndex ?>_unidad_medida_recibida"
        class="form-select ew-select<?= $Grid->unidad_medida_recibida->isInvalidClass() ?>"
        <?php if (!$Grid->unidad_medida_recibida->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_unidad_medida_recibida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida_recibida"
        data-value-separator="<?= $Grid->unidad_medida_recibida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->unidad_medida_recibida->getPlaceHolder()) ?>"
        <?= $Grid->unidad_medida_recibida->editAttributes() ?>>
        <?= $Grid->unidad_medida_recibida->selectOptionListHtml("x{$Grid->RowIndex}_unidad_medida_recibida") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->unidad_medida_recibida->getErrorMessage() ?></div>
<?= $Grid->unidad_medida_recibida->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_unidad_medida_recibida") ?>
<?php if (!$Grid->unidad_medida_recibida->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_unidad_medida_recibida", selectId: "fsco_orden_compra_detallegrid_x<?= $Grid->RowIndex ?>_unidad_medida_recibida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detallegrid.lists.unidad_medida_recibida?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_unidad_medida_recibida", form: "fsco_orden_compra_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_unidad_medida_recibida", form: "fsco_orden_compra_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida_recibida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_unidad_medida_recibida" class="el_sco_orden_compra_detalle_unidad_medida_recibida">
<span<?= $Grid->unidad_medida_recibida->viewAttributes() ?>>
<?= $Grid->unidad_medida_recibida->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida_recibida" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_unidad_medida_recibida" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_unidad_medida_recibida" value="<?= HtmlEncode($Grid->unidad_medida_recibida->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida_recibida" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_unidad_medida_recibida" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_unidad_medida_recibida" value="<?= HtmlEncode($Grid->unidad_medida_recibida->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <td data-name="cantidad_recibida"<?= $Grid->cantidad_recibida->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_cantidad_recibida" class="el_sco_orden_compra_detalle_cantidad_recibida">
<input type="<?= $Grid->cantidad_recibida->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad_recibida" id="x<?= $Grid->RowIndex ?>_cantidad_recibida" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" value="<?= $Grid->cantidad_recibida->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->cantidad_recibida->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad_recibida->formatPattern()) ?>"<?= $Grid->cantidad_recibida->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad_recibida->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cantidad_recibida" id="o<?= $Grid->RowIndex ?>_cantidad_recibida" value="<?= HtmlEncode($Grid->cantidad_recibida->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_cantidad_recibida" class="el_sco_orden_compra_detalle_cantidad_recibida">
<input type="<?= $Grid->cantidad_recibida->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cantidad_recibida" id="x<?= $Grid->RowIndex ?>_cantidad_recibida" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" value="<?= $Grid->cantidad_recibida->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Grid->cantidad_recibida->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cantidad_recibida->formatPattern()) ?>"<?= $Grid->cantidad_recibida->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cantidad_recibida->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_orden_compra_detalle_cantidad_recibida" class="el_sco_orden_compra_detalle_cantidad_recibida">
<span<?= $Grid->cantidad_recibida->viewAttributes() ?>>
<?= $Grid->cantidad_recibida->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" data-hidden="1" name="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_cantidad_recibida" id="fsco_orden_compra_detallegrid$x<?= $Grid->RowIndex ?>_cantidad_recibida" value="<?= HtmlEncode($Grid->cantidad_recibida->FormValue) ?>">
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" data-hidden="1" data-old name="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_cantidad_recibida" id="fsco_orden_compra_detallegrid$o<?= $Grid->RowIndex ?>_cantidad_recibida" value="<?= HtmlEncode($Grid->cantidad_recibida->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == RowType::ADD || $Grid->RowType == RowType::EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fsco_orden_compra_detallegrid","load"], () => fsco_orden_compra_detallegrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking

    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsco_orden_compra_detallegrid">
</div><!-- /.ew-list-form -->
<?php
// Close result set
$Grid->Recordset?->free();
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Grid->FooterOptions?->render("body") ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_orden_compra_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
