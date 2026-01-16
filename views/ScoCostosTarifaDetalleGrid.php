<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoCostosTarifaDetalleGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_costos_tarifa_detallegrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifa_detallegrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["cap", [fields.cap.visible && fields.cap.required ? ew.Validators.required(fields.cap.caption) : null], fields.cap.isInvalid],
            ["ata", [fields.ata.visible && fields.ata.required ? ew.Validators.required(fields.ata.caption) : null], fields.ata.isInvalid],
            ["obi", [fields.obi.visible && fields.obi.required ? ew.Validators.required(fields.obi.caption) : null], fields.obi.isInvalid],
            ["fot", [fields.fot.visible && fields.fot.required ? ew.Validators.required(fields.fot.caption) : null], fields.fot.isInvalid],
            ["man", [fields.man.visible && fields.man.required ? ew.Validators.required(fields.man.caption) : null], fields.man.isInvalid],
            ["gas", [fields.gas.visible && fields.gas.required ? ew.Validators.required(fields.gas.caption) : null], fields.gas.isInvalid],
            ["com", [fields.com.visible && fields.com.required ? ew.Validators.required(fields.com.caption) : null], fields.com.isInvalid],
            ["base", [fields.base.visible && fields.base.required ? ew.Validators.required(fields.base.caption) : null], fields.base.isInvalid],
            ["base_anterior", [fields.base_anterior.visible && fields.base_anterior.required ? ew.Validators.required(fields.base_anterior.caption) : null], fields.base_anterior.isInvalid],
            ["variacion", [fields.variacion.visible && fields.variacion.required ? ew.Validators.required(fields.variacion.caption) : null], fields.variacion.isInvalid],
            ["porcentaje", [fields.porcentaje.visible && fields.porcentaje.required ? ew.Validators.required(fields.porcentaje.caption) : null], fields.porcentaje.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
            ["cerrado", [fields.cerrado.visible && fields.cerrado.required ? ew.Validators.required(fields.cerrado.caption) : null], fields.cerrado.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["cap",false],["ata",false],["obi",false],["fot",false],["man",false],["gas",false],["com",false],["base",false],["base_anterior",false],["variacion",false],["porcentaje",false],["fecha",false],["cerrado",false]];
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
            "cap": <?= $Grid->cap->toClientList($Grid) ?>,
            "ata": <?= $Grid->ata->toClientList($Grid) ?>,
            "obi": <?= $Grid->obi->toClientList($Grid) ?>,
            "fot": <?= $Grid->fot->toClientList($Grid) ?>,
            "man": <?= $Grid->man->toClientList($Grid) ?>,
            "gas": <?= $Grid->gas->toClientList($Grid) ?>,
            "com": <?= $Grid->com->toClientList($Grid) ?>,
            "cerrado": <?= $Grid->cerrado->toClientList($Grid) ?>,
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
<div id="fsco_costos_tarifa_detallegrid" class="ew-form ew-list-form">
<div id="gmp_sco_costos_tarifa_detalle" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_costos_tarifa_detallegrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->cap->Visible) { // cap ?>
        <th data-name="cap" class="<?= $Grid->cap->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_cap" class="sco_costos_tarifa_detalle_cap"><?= $Grid->renderFieldHeader($Grid->cap) ?></div></th>
<?php } ?>
<?php if ($Grid->ata->Visible) { // ata ?>
        <th data-name="ata" class="<?= $Grid->ata->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_ata" class="sco_costos_tarifa_detalle_ata"><?= $Grid->renderFieldHeader($Grid->ata) ?></div></th>
<?php } ?>
<?php if ($Grid->obi->Visible) { // obi ?>
        <th data-name="obi" class="<?= $Grid->obi->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_obi" class="sco_costos_tarifa_detalle_obi"><?= $Grid->renderFieldHeader($Grid->obi) ?></div></th>
<?php } ?>
<?php if ($Grid->fot->Visible) { // fot ?>
        <th data-name="fot" class="<?= $Grid->fot->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_fot" class="sco_costos_tarifa_detalle_fot"><?= $Grid->renderFieldHeader($Grid->fot) ?></div></th>
<?php } ?>
<?php if ($Grid->man->Visible) { // man ?>
        <th data-name="man" class="<?= $Grid->man->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_man" class="sco_costos_tarifa_detalle_man"><?= $Grid->renderFieldHeader($Grid->man) ?></div></th>
<?php } ?>
<?php if ($Grid->gas->Visible) { // gas ?>
        <th data-name="gas" class="<?= $Grid->gas->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_gas" class="sco_costos_tarifa_detalle_gas"><?= $Grid->renderFieldHeader($Grid->gas) ?></div></th>
<?php } ?>
<?php if ($Grid->com->Visible) { // com ?>
        <th data-name="com" class="<?= $Grid->com->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_com" class="sco_costos_tarifa_detalle_com"><?= $Grid->renderFieldHeader($Grid->com) ?></div></th>
<?php } ?>
<?php if ($Grid->base->Visible) { // base ?>
        <th data-name="base" class="<?= $Grid->base->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_base" class="sco_costos_tarifa_detalle_base"><?= $Grid->renderFieldHeader($Grid->base) ?></div></th>
<?php } ?>
<?php if ($Grid->base_anterior->Visible) { // base_anterior ?>
        <th data-name="base_anterior" class="<?= $Grid->base_anterior->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_base_anterior" class="sco_costos_tarifa_detalle_base_anterior"><?= $Grid->renderFieldHeader($Grid->base_anterior) ?></div></th>
<?php } ?>
<?php if ($Grid->variacion->Visible) { // variacion ?>
        <th data-name="variacion" class="<?= $Grid->variacion->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_variacion" class="sco_costos_tarifa_detalle_variacion"><?= $Grid->renderFieldHeader($Grid->variacion) ?></div></th>
<?php } ?>
<?php if ($Grid->porcentaje->Visible) { // porcentaje ?>
        <th data-name="porcentaje" class="<?= $Grid->porcentaje->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_porcentaje" class="sco_costos_tarifa_detalle_porcentaje"><?= $Grid->renderFieldHeader($Grid->porcentaje) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_fecha" class="sco_costos_tarifa_detalle_fecha"><?= $Grid->renderFieldHeader($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->cerrado->Visible) { // cerrado ?>
        <th data-name="cerrado" class="<?= $Grid->cerrado->headerCellClass() ?>"><div id="elh_sco_costos_tarifa_detalle_cerrado" class="sco_costos_tarifa_detalle_cerrado"><?= $Grid->renderFieldHeader($Grid->cerrado) ?></div></th>
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
    <?php if ($Grid->cap->Visible) { // cap ?>
        <td data-name="cap"<?= $Grid->cap->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_cap" class="el_sco_costos_tarifa_detalle_cap">
    <select
        id="x<?= $Grid->RowIndex ?>_cap"
        name="x<?= $Grid->RowIndex ?>_cap"
        class="form-select ew-select<?= $Grid->cap->isInvalidClass() ?>"
        <?php if (!$Grid->cap->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cap"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_cap"
        data-value-separator="<?= $Grid->cap->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cap->getPlaceHolder()) ?>"
        <?= $Grid->cap->editAttributes() ?>>
        <?= $Grid->cap->selectOptionListHtml("x{$Grid->RowIndex}_cap") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cap->getErrorMessage() ?></div>
<?= $Grid->cap->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cap") ?>
<?php if (!$Grid->cap->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cap", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cap" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.cap?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cap", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cap", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.cap.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_cap" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cap" id="o<?= $Grid->RowIndex ?>_cap" value="<?= HtmlEncode($Grid->cap->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_cap" class="el_sco_costos_tarifa_detalle_cap">
    <select
        id="x<?= $Grid->RowIndex ?>_cap"
        name="x<?= $Grid->RowIndex ?>_cap"
        class="form-select ew-select<?= $Grid->cap->isInvalidClass() ?>"
        <?php if (!$Grid->cap->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cap"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_cap"
        data-value-separator="<?= $Grid->cap->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cap->getPlaceHolder()) ?>"
        <?= $Grid->cap->editAttributes() ?>>
        <?= $Grid->cap->selectOptionListHtml("x{$Grid->RowIndex}_cap") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cap->getErrorMessage() ?></div>
<?= $Grid->cap->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cap") ?>
<?php if (!$Grid->cap->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cap", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cap" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.cap?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cap", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cap", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.cap.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_cap" class="el_sco_costos_tarifa_detalle_cap">
<span<?= $Grid->cap->viewAttributes() ?>>
<?= $Grid->cap->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_cap" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_cap" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_cap" value="<?= HtmlEncode($Grid->cap->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_cap" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_cap" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_cap" value="<?= HtmlEncode($Grid->cap->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ata->Visible) { // ata ?>
        <td data-name="ata"<?= $Grid->ata->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_ata" class="el_sco_costos_tarifa_detalle_ata">
    <select
        id="x<?= $Grid->RowIndex ?>_ata"
        name="x<?= $Grid->RowIndex ?>_ata"
        class="form-select ew-select<?= $Grid->ata->isInvalidClass() ?>"
        <?php if (!$Grid->ata->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_ata"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_ata"
        data-value-separator="<?= $Grid->ata->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->ata->getPlaceHolder()) ?>"
        <?= $Grid->ata->editAttributes() ?>>
        <?= $Grid->ata->selectOptionListHtml("x{$Grid->RowIndex}_ata") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->ata->getErrorMessage() ?></div>
<?= $Grid->ata->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ata") ?>
<?php if (!$Grid->ata->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_ata", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_ata" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.ata?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_ata", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_ata", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.ata.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_ata" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_ata" id="o<?= $Grid->RowIndex ?>_ata" value="<?= HtmlEncode($Grid->ata->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_ata" class="el_sco_costos_tarifa_detalle_ata">
    <select
        id="x<?= $Grid->RowIndex ?>_ata"
        name="x<?= $Grid->RowIndex ?>_ata"
        class="form-select ew-select<?= $Grid->ata->isInvalidClass() ?>"
        <?php if (!$Grid->ata->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_ata"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_ata"
        data-value-separator="<?= $Grid->ata->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->ata->getPlaceHolder()) ?>"
        <?= $Grid->ata->editAttributes() ?>>
        <?= $Grid->ata->selectOptionListHtml("x{$Grid->RowIndex}_ata") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->ata->getErrorMessage() ?></div>
<?= $Grid->ata->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_ata") ?>
<?php if (!$Grid->ata->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_ata", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_ata" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.ata?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_ata", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_ata", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.ata.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_ata" class="el_sco_costos_tarifa_detalle_ata">
<span<?= $Grid->ata->viewAttributes() ?>>
<?= $Grid->ata->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_ata" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_ata" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_ata" value="<?= HtmlEncode($Grid->ata->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_ata" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_ata" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_ata" value="<?= HtmlEncode($Grid->ata->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->obi->Visible) { // obi ?>
        <td data-name="obi"<?= $Grid->obi->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_obi" class="el_sco_costos_tarifa_detalle_obi">
    <select
        id="x<?= $Grid->RowIndex ?>_obi"
        name="x<?= $Grid->RowIndex ?>_obi"
        class="form-select ew-select<?= $Grid->obi->isInvalidClass() ?>"
        <?php if (!$Grid->obi->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_obi"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_obi"
        data-value-separator="<?= $Grid->obi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->obi->getPlaceHolder()) ?>"
        <?= $Grid->obi->editAttributes() ?>>
        <?= $Grid->obi->selectOptionListHtml("x{$Grid->RowIndex}_obi") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->obi->getErrorMessage() ?></div>
<?= $Grid->obi->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_obi") ?>
<?php if (!$Grid->obi->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_obi", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_obi" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.obi?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_obi", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_obi", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.obi.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_obi" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_obi" id="o<?= $Grid->RowIndex ?>_obi" value="<?= HtmlEncode($Grid->obi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_obi" class="el_sco_costos_tarifa_detalle_obi">
    <select
        id="x<?= $Grid->RowIndex ?>_obi"
        name="x<?= $Grid->RowIndex ?>_obi"
        class="form-select ew-select<?= $Grid->obi->isInvalidClass() ?>"
        <?php if (!$Grid->obi->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_obi"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_obi"
        data-value-separator="<?= $Grid->obi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->obi->getPlaceHolder()) ?>"
        <?= $Grid->obi->editAttributes() ?>>
        <?= $Grid->obi->selectOptionListHtml("x{$Grid->RowIndex}_obi") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->obi->getErrorMessage() ?></div>
<?= $Grid->obi->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_obi") ?>
<?php if (!$Grid->obi->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_obi", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_obi" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.obi?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_obi", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_obi", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.obi.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_obi" class="el_sco_costos_tarifa_detalle_obi">
<span<?= $Grid->obi->viewAttributes() ?>>
<?= $Grid->obi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_obi" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_obi" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_obi" value="<?= HtmlEncode($Grid->obi->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_obi" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_obi" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_obi" value="<?= HtmlEncode($Grid->obi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fot->Visible) { // fot ?>
        <td data-name="fot"<?= $Grid->fot->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_fot" class="el_sco_costos_tarifa_detalle_fot">
    <select
        id="x<?= $Grid->RowIndex ?>_fot"
        name="x<?= $Grid->RowIndex ?>_fot"
        class="form-select ew-select<?= $Grid->fot->isInvalidClass() ?>"
        <?php if (!$Grid->fot->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_fot"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_fot"
        data-value-separator="<?= $Grid->fot->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->fot->getPlaceHolder()) ?>"
        <?= $Grid->fot->editAttributes() ?>>
        <?= $Grid->fot->selectOptionListHtml("x{$Grid->RowIndex}_fot") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->fot->getErrorMessage() ?></div>
<?= $Grid->fot->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_fot") ?>
<?php if (!$Grid->fot->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_fot", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_fot" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.fot?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_fot", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_fot", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.fot.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fot" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fot" id="o<?= $Grid->RowIndex ?>_fot" value="<?= HtmlEncode($Grid->fot->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_fot" class="el_sco_costos_tarifa_detalle_fot">
    <select
        id="x<?= $Grid->RowIndex ?>_fot"
        name="x<?= $Grid->RowIndex ?>_fot"
        class="form-select ew-select<?= $Grid->fot->isInvalidClass() ?>"
        <?php if (!$Grid->fot->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_fot"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_fot"
        data-value-separator="<?= $Grid->fot->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->fot->getPlaceHolder()) ?>"
        <?= $Grid->fot->editAttributes() ?>>
        <?= $Grid->fot->selectOptionListHtml("x{$Grid->RowIndex}_fot") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->fot->getErrorMessage() ?></div>
<?= $Grid->fot->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_fot") ?>
<?php if (!$Grid->fot->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_fot", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_fot" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.fot?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_fot", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_fot", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.fot.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_fot" class="el_sco_costos_tarifa_detalle_fot">
<span<?= $Grid->fot->viewAttributes() ?>>
<?= $Grid->fot->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fot" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_fot" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_fot" value="<?= HtmlEncode($Grid->fot->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fot" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_fot" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_fot" value="<?= HtmlEncode($Grid->fot->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->man->Visible) { // man ?>
        <td data-name="man"<?= $Grid->man->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_man" class="el_sco_costos_tarifa_detalle_man">
    <select
        id="x<?= $Grid->RowIndex ?>_man"
        name="x<?= $Grid->RowIndex ?>_man"
        class="form-select ew-select<?= $Grid->man->isInvalidClass() ?>"
        <?php if (!$Grid->man->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_man"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_man"
        data-value-separator="<?= $Grid->man->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->man->getPlaceHolder()) ?>"
        <?= $Grid->man->editAttributes() ?>>
        <?= $Grid->man->selectOptionListHtml("x{$Grid->RowIndex}_man") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->man->getErrorMessage() ?></div>
<?= $Grid->man->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_man") ?>
<?php if (!$Grid->man->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_man", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_man" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.man?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_man", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_man", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.man.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_man" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_man" id="o<?= $Grid->RowIndex ?>_man" value="<?= HtmlEncode($Grid->man->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_man" class="el_sco_costos_tarifa_detalle_man">
    <select
        id="x<?= $Grid->RowIndex ?>_man"
        name="x<?= $Grid->RowIndex ?>_man"
        class="form-select ew-select<?= $Grid->man->isInvalidClass() ?>"
        <?php if (!$Grid->man->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_man"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_man"
        data-value-separator="<?= $Grid->man->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->man->getPlaceHolder()) ?>"
        <?= $Grid->man->editAttributes() ?>>
        <?= $Grid->man->selectOptionListHtml("x{$Grid->RowIndex}_man") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->man->getErrorMessage() ?></div>
<?= $Grid->man->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_man") ?>
<?php if (!$Grid->man->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_man", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_man" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.man?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_man", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_man", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.man.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_man" class="el_sco_costos_tarifa_detalle_man">
<span<?= $Grid->man->viewAttributes() ?>>
<?= $Grid->man->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_man" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_man" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_man" value="<?= HtmlEncode($Grid->man->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_man" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_man" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_man" value="<?= HtmlEncode($Grid->man->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->gas->Visible) { // gas ?>
        <td data-name="gas"<?= $Grid->gas->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_gas" class="el_sco_costos_tarifa_detalle_gas">
    <select
        id="x<?= $Grid->RowIndex ?>_gas"
        name="x<?= $Grid->RowIndex ?>_gas"
        class="form-select ew-select<?= $Grid->gas->isInvalidClass() ?>"
        <?php if (!$Grid->gas->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_gas"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_gas"
        data-value-separator="<?= $Grid->gas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->gas->getPlaceHolder()) ?>"
        <?= $Grid->gas->editAttributes() ?>>
        <?= $Grid->gas->selectOptionListHtml("x{$Grid->RowIndex}_gas") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->gas->getErrorMessage() ?></div>
<?= $Grid->gas->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_gas") ?>
<?php if (!$Grid->gas->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_gas", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_gas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.gas?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_gas", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_gas", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.gas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_gas" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_gas" id="o<?= $Grid->RowIndex ?>_gas" value="<?= HtmlEncode($Grid->gas->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_gas" class="el_sco_costos_tarifa_detalle_gas">
    <select
        id="x<?= $Grid->RowIndex ?>_gas"
        name="x<?= $Grid->RowIndex ?>_gas"
        class="form-select ew-select<?= $Grid->gas->isInvalidClass() ?>"
        <?php if (!$Grid->gas->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_gas"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_gas"
        data-value-separator="<?= $Grid->gas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->gas->getPlaceHolder()) ?>"
        <?= $Grid->gas->editAttributes() ?>>
        <?= $Grid->gas->selectOptionListHtml("x{$Grid->RowIndex}_gas") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->gas->getErrorMessage() ?></div>
<?= $Grid->gas->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_gas") ?>
<?php if (!$Grid->gas->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_gas", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_gas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.gas?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_gas", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_gas", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.gas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_gas" class="el_sco_costos_tarifa_detalle_gas">
<span<?= $Grid->gas->viewAttributes() ?>>
<?= $Grid->gas->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_gas" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_gas" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_gas" value="<?= HtmlEncode($Grid->gas->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_gas" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_gas" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_gas" value="<?= HtmlEncode($Grid->gas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->com->Visible) { // com ?>
        <td data-name="com"<?= $Grid->com->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_com" class="el_sco_costos_tarifa_detalle_com">
    <select
        id="x<?= $Grid->RowIndex ?>_com"
        name="x<?= $Grid->RowIndex ?>_com"
        class="form-select ew-select<?= $Grid->com->isInvalidClass() ?>"
        <?php if (!$Grid->com->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_com"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_com"
        data-value-separator="<?= $Grid->com->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->com->getPlaceHolder()) ?>"
        <?= $Grid->com->editAttributes() ?>>
        <?= $Grid->com->selectOptionListHtml("x{$Grid->RowIndex}_com") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->com->getErrorMessage() ?></div>
<?= $Grid->com->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_com") ?>
<?php if (!$Grid->com->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_com", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_com" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.com?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_com", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_com", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.com.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_com" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_com" id="o<?= $Grid->RowIndex ?>_com" value="<?= HtmlEncode($Grid->com->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_com" class="el_sco_costos_tarifa_detalle_com">
    <select
        id="x<?= $Grid->RowIndex ?>_com"
        name="x<?= $Grid->RowIndex ?>_com"
        class="form-select ew-select<?= $Grid->com->isInvalidClass() ?>"
        <?php if (!$Grid->com->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_com"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_com"
        data-value-separator="<?= $Grid->com->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->com->getPlaceHolder()) ?>"
        <?= $Grid->com->editAttributes() ?>>
        <?= $Grid->com->selectOptionListHtml("x{$Grid->RowIndex}_com") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->com->getErrorMessage() ?></div>
<?= $Grid->com->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_com") ?>
<?php if (!$Grid->com->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_com", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_com" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.com?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_com", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_com", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.com.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_com" class="el_sco_costos_tarifa_detalle_com">
<span<?= $Grid->com->viewAttributes() ?>>
<?= $Grid->com->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_com" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_com" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_com" value="<?= HtmlEncode($Grid->com->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_com" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_com" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_com" value="<?= HtmlEncode($Grid->com->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->base->Visible) { // base ?>
        <td data-name="base"<?= $Grid->base->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_base" class="el_sco_costos_tarifa_detalle_base">
<input type="<?= $Grid->base->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_base" id="x<?= $Grid->RowIndex ?>_base" data-table="sco_costos_tarifa_detalle" data-field="x_base" value="<?= $Grid->base->EditValue ?>" size="6" placeholder="<?= HtmlEncode($Grid->base->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->base->formatPattern()) ?>"<?= $Grid->base->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->base->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_base" id="o<?= $Grid->RowIndex ?>_base" value="<?= HtmlEncode($Grid->base->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_base" class="el_sco_costos_tarifa_detalle_base">
<span<?= $Grid->base->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->base->getDisplayValue($Grid->base->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base" data-hidden="1" name="x<?= $Grid->RowIndex ?>_base" id="x<?= $Grid->RowIndex ?>_base" value="<?= HtmlEncode($Grid->base->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_base" class="el_sco_costos_tarifa_detalle_base">
<span<?= $Grid->base->viewAttributes() ?>>
<?= $Grid->base->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_base" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_base" value="<?= HtmlEncode($Grid->base->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_base" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_base" value="<?= HtmlEncode($Grid->base->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->base_anterior->Visible) { // base_anterior ?>
        <td data-name="base_anterior"<?= $Grid->base_anterior->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_base_anterior" class="el_sco_costos_tarifa_detalle_base_anterior">
<input type="<?= $Grid->base_anterior->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_base_anterior" id="x<?= $Grid->RowIndex ?>_base_anterior" data-table="sco_costos_tarifa_detalle" data-field="x_base_anterior" value="<?= $Grid->base_anterior->EditValue ?>" size="6" placeholder="<?= HtmlEncode($Grid->base_anterior->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->base_anterior->formatPattern()) ?>"<?= $Grid->base_anterior->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->base_anterior->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base_anterior" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_base_anterior" id="o<?= $Grid->RowIndex ?>_base_anterior" value="<?= HtmlEncode($Grid->base_anterior->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_base_anterior" class="el_sco_costos_tarifa_detalle_base_anterior">
<span<?= $Grid->base_anterior->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->base_anterior->getDisplayValue($Grid->base_anterior->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base_anterior" data-hidden="1" name="x<?= $Grid->RowIndex ?>_base_anterior" id="x<?= $Grid->RowIndex ?>_base_anterior" value="<?= HtmlEncode($Grid->base_anterior->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_base_anterior" class="el_sco_costos_tarifa_detalle_base_anterior">
<span<?= $Grid->base_anterior->viewAttributes() ?>>
<?= $Grid->base_anterior->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base_anterior" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_base_anterior" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_base_anterior" value="<?= HtmlEncode($Grid->base_anterior->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_base_anterior" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_base_anterior" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_base_anterior" value="<?= HtmlEncode($Grid->base_anterior->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->variacion->Visible) { // variacion ?>
        <td data-name="variacion"<?= $Grid->variacion->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_variacion" class="el_sco_costos_tarifa_detalle_variacion">
<input type="<?= $Grid->variacion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_variacion" id="x<?= $Grid->RowIndex ?>_variacion" data-table="sco_costos_tarifa_detalle" data-field="x_variacion" value="<?= $Grid->variacion->EditValue ?>" size="6" placeholder="<?= HtmlEncode($Grid->variacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->variacion->formatPattern()) ?>"<?= $Grid->variacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->variacion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_variacion" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_variacion" id="o<?= $Grid->RowIndex ?>_variacion" value="<?= HtmlEncode($Grid->variacion->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_variacion" class="el_sco_costos_tarifa_detalle_variacion">
<span<?= $Grid->variacion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->variacion->getDisplayValue($Grid->variacion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_variacion" data-hidden="1" name="x<?= $Grid->RowIndex ?>_variacion" id="x<?= $Grid->RowIndex ?>_variacion" value="<?= HtmlEncode($Grid->variacion->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_variacion" class="el_sco_costos_tarifa_detalle_variacion">
<span<?= $Grid->variacion->viewAttributes() ?>>
<?= $Grid->variacion->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_variacion" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_variacion" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_variacion" value="<?= HtmlEncode($Grid->variacion->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_variacion" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_variacion" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_variacion" value="<?= HtmlEncode($Grid->variacion->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->porcentaje->Visible) { // porcentaje ?>
        <td data-name="porcentaje"<?= $Grid->porcentaje->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_porcentaje" class="el_sco_costos_tarifa_detalle_porcentaje">
<input type="<?= $Grid->porcentaje->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_porcentaje" id="x<?= $Grid->RowIndex ?>_porcentaje" data-table="sco_costos_tarifa_detalle" data-field="x_porcentaje" value="<?= $Grid->porcentaje->EditValue ?>" size="6" placeholder="<?= HtmlEncode($Grid->porcentaje->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->porcentaje->formatPattern()) ?>"<?= $Grid->porcentaje->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->porcentaje->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_porcentaje" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_porcentaje" id="o<?= $Grid->RowIndex ?>_porcentaje" value="<?= HtmlEncode($Grid->porcentaje->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_porcentaje" class="el_sco_costos_tarifa_detalle_porcentaje">
<span<?= $Grid->porcentaje->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->porcentaje->getDisplayValue($Grid->porcentaje->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_porcentaje" data-hidden="1" name="x<?= $Grid->RowIndex ?>_porcentaje" id="x<?= $Grid->RowIndex ?>_porcentaje" value="<?= HtmlEncode($Grid->porcentaje->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_porcentaje" class="el_sco_costos_tarifa_detalle_porcentaje">
<span<?= $Grid->porcentaje->viewAttributes() ?>>
<?= $Grid->porcentaje->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_porcentaje" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_porcentaje" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_porcentaje" value="<?= HtmlEncode($Grid->porcentaje->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_porcentaje" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_porcentaje" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_porcentaje" value="<?= HtmlEncode($Grid->porcentaje->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_fecha" class="el_sco_costos_tarifa_detalle_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_costos_tarifa_detalle" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_fecha" class="el_sco_costos_tarifa_detalle_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->fecha->getDisplayValue($Grid->fecha->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fecha" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_fecha" class="el_sco_costos_tarifa_detalle_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fecha" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_fecha" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_fecha" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_fecha" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cerrado->Visible) { // cerrado ?>
        <td data-name="cerrado"<?= $Grid->cerrado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_cerrado" class="el_sco_costos_tarifa_detalle_cerrado">
    <select
        id="x<?= $Grid->RowIndex ?>_cerrado"
        name="x<?= $Grid->RowIndex ?>_cerrado"
        class="form-select ew-select<?= $Grid->cerrado->isInvalidClass() ?>"
        <?php if (!$Grid->cerrado->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cerrado"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_cerrado"
        data-value-separator="<?= $Grid->cerrado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cerrado->getPlaceHolder()) ?>"
        <?= $Grid->cerrado->editAttributes() ?>>
        <?= $Grid->cerrado->selectOptionListHtml("x{$Grid->RowIndex}_cerrado") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cerrado->getErrorMessage() ?></div>
<?php if (!$Grid->cerrado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cerrado", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cerrado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.cerrado?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cerrado", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cerrado", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.cerrado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_cerrado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cerrado" id="o<?= $Grid->RowIndex ?>_cerrado" value="<?= HtmlEncode($Grid->cerrado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_cerrado" class="el_sco_costos_tarifa_detalle_cerrado">
    <select
        id="x<?= $Grid->RowIndex ?>_cerrado"
        name="x<?= $Grid->RowIndex ?>_cerrado"
        class="form-select ew-select<?= $Grid->cerrado->isInvalidClass() ?>"
        <?php if (!$Grid->cerrado->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cerrado"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_cerrado"
        data-value-separator="<?= $Grid->cerrado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cerrado->getPlaceHolder()) ?>"
        <?= $Grid->cerrado->editAttributes() ?>>
        <?= $Grid->cerrado->selectOptionListHtml("x{$Grid->RowIndex}_cerrado") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->cerrado->getErrorMessage() ?></div>
<?php if (!$Grid->cerrado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detallegrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cerrado", selectId: "fsco_costos_tarifa_detallegrid_x<?= $Grid->RowIndex ?>_cerrado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detallegrid.lists.cerrado?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cerrado", form: "fsco_costos_tarifa_detallegrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cerrado", form: "fsco_costos_tarifa_detallegrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.cerrado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_costos_tarifa_detalle_cerrado" class="el_sco_costos_tarifa_detalle_cerrado">
<span<?= $Grid->cerrado->viewAttributes() ?>>
<?= $Grid->cerrado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_cerrado" data-hidden="1" name="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_cerrado" id="fsco_costos_tarifa_detallegrid$x<?= $Grid->RowIndex ?>_cerrado" value="<?= HtmlEncode($Grid->cerrado->FormValue) ?>">
<input type="hidden" data-table="sco_costos_tarifa_detalle" data-field="x_cerrado" data-hidden="1" data-old name="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_cerrado" id="fsco_costos_tarifa_detallegrid$o<?= $Grid->RowIndex ?>_cerrado" value="<?= HtmlEncode($Grid->cerrado->OldValue) ?>">
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
loadjs.ready(["fsco_costos_tarifa_detallegrid","load"], () => fsco_costos_tarifa_detallegrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_costos_tarifa_detallegrid">
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
    ew.addEventHandlers("sco_costos_tarifa_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
