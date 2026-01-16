<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoParcelaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_parcelagrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_parcela: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcelagrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["Nparcela", [fields.Nparcela.visible && fields.Nparcela.required ? ew.Validators.required(fields.Nparcela.caption) : null, ew.Validators.integer], fields.Nparcela.isInvalid],
            ["nacionalidad", [fields.nacionalidad.visible && fields.nacionalidad.required ? ew.Validators.required(fields.nacionalidad.caption) : null], fields.nacionalidad.isInvalid],
            ["cedula", [fields.cedula.visible && fields.cedula.required ? ew.Validators.required(fields.cedula.caption) : null], fields.cedula.isInvalid],
            ["titular", [fields.titular.visible && fields.titular.required ? ew.Validators.required(fields.titular.caption) : null], fields.titular.isInvalid],
            ["contrato", [fields.contrato.visible && fields.contrato.required ? ew.Validators.required(fields.contrato.caption) : null], fields.contrato.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["sub_seccion", [fields.sub_seccion.visible && fields.sub_seccion.required ? ew.Validators.required(fields.sub_seccion.caption) : null], fields.sub_seccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["boveda", [fields.boveda.visible && fields.boveda.required ? ew.Validators.required(fields.boveda.caption) : null], fields.boveda.isInvalid],
            ["apellido1", [fields.apellido1.visible && fields.apellido1.required ? ew.Validators.required(fields.apellido1.caption) : null], fields.apellido1.isInvalid],
            ["apellido2", [fields.apellido2.visible && fields.apellido2.required ? ew.Validators.required(fields.apellido2.caption) : null], fields.apellido2.isInvalid],
            ["nombre1", [fields.nombre1.visible && fields.nombre1.required ? ew.Validators.required(fields.nombre1.caption) : null], fields.nombre1.isInvalid],
            ["nombre2", [fields.nombre2.visible && fields.nombre2.required ? ew.Validators.required(fields.nombre2.caption) : null], fields.nombre2.isInvalid],
            ["fecha_inhumacion", [fields.fecha_inhumacion.visible && fields.fecha_inhumacion.required ? ew.Validators.required(fields.fecha_inhumacion.caption) : null, ew.Validators.datetime(fields.fecha_inhumacion.clientFormatPattern)], fields.fecha_inhumacion.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null], fields.funeraria.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["Nparcela",false],["nacionalidad",false],["cedula",false],["titular",false],["contrato",false],["seccion",false],["modulo",false],["sub_seccion",false],["parcela",false],["boveda",false],["apellido1",false],["apellido2",false],["nombre1",false],["nombre2",false],["fecha_inhumacion",false],["funeraria",false]];
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
<div id="fsco_parcelagrid" class="ew-form ew-list-form">
<div id="gmp_sco_parcela" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_parcelagrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->Nparcela->Visible) { // Nparcela ?>
        <th data-name="Nparcela" class="<?= $Grid->Nparcela->headerCellClass() ?>"><div id="elh_sco_parcela_Nparcela" class="sco_parcela_Nparcela"><?= $Grid->renderFieldHeader($Grid->Nparcela) ?></div></th>
<?php } ?>
<?php if ($Grid->nacionalidad->Visible) { // nacionalidad ?>
        <th data-name="nacionalidad" class="<?= $Grid->nacionalidad->headerCellClass() ?>"><div id="elh_sco_parcela_nacionalidad" class="sco_parcela_nacionalidad"><?= $Grid->renderFieldHeader($Grid->nacionalidad) ?></div></th>
<?php } ?>
<?php if ($Grid->cedula->Visible) { // cedula ?>
        <th data-name="cedula" class="<?= $Grid->cedula->headerCellClass() ?>"><div id="elh_sco_parcela_cedula" class="sco_parcela_cedula"><?= $Grid->renderFieldHeader($Grid->cedula) ?></div></th>
<?php } ?>
<?php if ($Grid->titular->Visible) { // titular ?>
        <th data-name="titular" class="<?= $Grid->titular->headerCellClass() ?>"><div id="elh_sco_parcela_titular" class="sco_parcela_titular"><?= $Grid->renderFieldHeader($Grid->titular) ?></div></th>
<?php } ?>
<?php if ($Grid->contrato->Visible) { // contrato ?>
        <th data-name="contrato" class="<?= $Grid->contrato->headerCellClass() ?>"><div id="elh_sco_parcela_contrato" class="sco_parcela_contrato"><?= $Grid->renderFieldHeader($Grid->contrato) ?></div></th>
<?php } ?>
<?php if ($Grid->seccion->Visible) { // seccion ?>
        <th data-name="seccion" class="<?= $Grid->seccion->headerCellClass() ?>"><div id="elh_sco_parcela_seccion" class="sco_parcela_seccion"><?= $Grid->renderFieldHeader($Grid->seccion) ?></div></th>
<?php } ?>
<?php if ($Grid->modulo->Visible) { // modulo ?>
        <th data-name="modulo" class="<?= $Grid->modulo->headerCellClass() ?>"><div id="elh_sco_parcela_modulo" class="sco_parcela_modulo"><?= $Grid->renderFieldHeader($Grid->modulo) ?></div></th>
<?php } ?>
<?php if ($Grid->sub_seccion->Visible) { // sub_seccion ?>
        <th data-name="sub_seccion" class="<?= $Grid->sub_seccion->headerCellClass() ?>"><div id="elh_sco_parcela_sub_seccion" class="sco_parcela_sub_seccion"><?= $Grid->renderFieldHeader($Grid->sub_seccion) ?></div></th>
<?php } ?>
<?php if ($Grid->parcela->Visible) { // parcela ?>
        <th data-name="parcela" class="<?= $Grid->parcela->headerCellClass() ?>"><div id="elh_sco_parcela_parcela" class="sco_parcela_parcela"><?= $Grid->renderFieldHeader($Grid->parcela) ?></div></th>
<?php } ?>
<?php if ($Grid->boveda->Visible) { // boveda ?>
        <th data-name="boveda" class="<?= $Grid->boveda->headerCellClass() ?>"><div id="elh_sco_parcela_boveda" class="sco_parcela_boveda"><?= $Grid->renderFieldHeader($Grid->boveda) ?></div></th>
<?php } ?>
<?php if ($Grid->apellido1->Visible) { // apellido1 ?>
        <th data-name="apellido1" class="<?= $Grid->apellido1->headerCellClass() ?>"><div id="elh_sco_parcela_apellido1" class="sco_parcela_apellido1"><?= $Grid->renderFieldHeader($Grid->apellido1) ?></div></th>
<?php } ?>
<?php if ($Grid->apellido2->Visible) { // apellido2 ?>
        <th data-name="apellido2" class="<?= $Grid->apellido2->headerCellClass() ?>"><div id="elh_sco_parcela_apellido2" class="sco_parcela_apellido2"><?= $Grid->renderFieldHeader($Grid->apellido2) ?></div></th>
<?php } ?>
<?php if ($Grid->nombre1->Visible) { // nombre1 ?>
        <th data-name="nombre1" class="<?= $Grid->nombre1->headerCellClass() ?>"><div id="elh_sco_parcela_nombre1" class="sco_parcela_nombre1"><?= $Grid->renderFieldHeader($Grid->nombre1) ?></div></th>
<?php } ?>
<?php if ($Grid->nombre2->Visible) { // nombre2 ?>
        <th data-name="nombre2" class="<?= $Grid->nombre2->headerCellClass() ?>"><div id="elh_sco_parcela_nombre2" class="sco_parcela_nombre2"><?= $Grid->renderFieldHeader($Grid->nombre2) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <th data-name="fecha_inhumacion" class="<?= $Grid->fecha_inhumacion->headerCellClass() ?>"><div id="elh_sco_parcela_fecha_inhumacion" class="sco_parcela_fecha_inhumacion"><?= $Grid->renderFieldHeader($Grid->fecha_inhumacion) ?></div></th>
<?php } ?>
<?php if ($Grid->funeraria->Visible) { // funeraria ?>
        <th data-name="funeraria" class="<?= $Grid->funeraria->headerCellClass() ?>"><div id="elh_sco_parcela_funeraria" class="sco_parcela_funeraria"><?= $Grid->renderFieldHeader($Grid->funeraria) ?></div></th>
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
    <?php if ($Grid->Nparcela->Visible) { // Nparcela ?>
        <td data-name="Nparcela"<?= $Grid->Nparcela->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_Nparcela" class="el_sco_parcela_Nparcela">
<input type="<?= $Grid->Nparcela->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nparcela" id="x<?= $Grid->RowIndex ?>_Nparcela" data-table="sco_parcela" data-field="x_Nparcela" value="<?= $Grid->Nparcela->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->Nparcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nparcela->formatPattern()) ?>"<?= $Grid->Nparcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nparcela->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_Nparcela" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nparcela" id="o<?= $Grid->RowIndex ?>_Nparcela" value="<?= HtmlEncode($Grid->Nparcela->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_Nparcela" class="el_sco_parcela_Nparcela">
<input type="<?= $Grid->Nparcela->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Nparcela" id="x<?= $Grid->RowIndex ?>_Nparcela" data-table="sco_parcela" data-field="x_Nparcela" value="<?= $Grid->Nparcela->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->Nparcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Nparcela->formatPattern()) ?>"<?= $Grid->Nparcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Nparcela->getErrorMessage() ?></div>
<input type="hidden" data-table="sco_parcela" data-field="x_Nparcela" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Nparcela" id="o<?= $Grid->RowIndex ?>_Nparcela" value="<?= HtmlEncode($Grid->Nparcela->OldValue ?? $Grid->Nparcela->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_Nparcela" class="el_sco_parcela_Nparcela">
<span<?= $Grid->Nparcela->viewAttributes() ?>>
<?= $Grid->Nparcela->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_Nparcela" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_Nparcela" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_Nparcela" value="<?= HtmlEncode($Grid->Nparcela->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_Nparcela" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_Nparcela" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_Nparcela" value="<?= HtmlEncode($Grid->Nparcela->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="sco_parcela" data-field="x_Nparcela" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Nparcela" id="x<?= $Grid->RowIndex ?>_Nparcela" value="<?= HtmlEncode($Grid->Nparcela->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->nacionalidad->Visible) { // nacionalidad ?>
        <td data-name="nacionalidad"<?= $Grid->nacionalidad->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nacionalidad" class="el_sco_parcela_nacionalidad">
<input type="<?= $Grid->nacionalidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nacionalidad" id="x<?= $Grid->RowIndex ?>_nacionalidad" data-table="sco_parcela" data-field="x_nacionalidad" value="<?= $Grid->nacionalidad->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->nacionalidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nacionalidad->formatPattern()) ?>"<?= $Grid->nacionalidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nacionalidad->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_nacionalidad" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nacionalidad" id="o<?= $Grid->RowIndex ?>_nacionalidad" value="<?= HtmlEncode($Grid->nacionalidad->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nacionalidad" class="el_sco_parcela_nacionalidad">
<input type="<?= $Grid->nacionalidad->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nacionalidad" id="x<?= $Grid->RowIndex ?>_nacionalidad" data-table="sco_parcela" data-field="x_nacionalidad" value="<?= $Grid->nacionalidad->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Grid->nacionalidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nacionalidad->formatPattern()) ?>"<?= $Grid->nacionalidad->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nacionalidad->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nacionalidad" class="el_sco_parcela_nacionalidad">
<span<?= $Grid->nacionalidad->viewAttributes() ?>>
<?= $Grid->nacionalidad->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_nacionalidad" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_nacionalidad" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_nacionalidad" value="<?= HtmlEncode($Grid->nacionalidad->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_nacionalidad" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_nacionalidad" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_nacionalidad" value="<?= HtmlEncode($Grid->nacionalidad->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cedula->Visible) { // cedula ?>
        <td data-name="cedula"<?= $Grid->cedula->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_cedula" class="el_sco_parcela_cedula">
<input type="<?= $Grid->cedula->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cedula" id="x<?= $Grid->RowIndex ?>_cedula" data-table="sco_parcela" data-field="x_cedula" value="<?= $Grid->cedula->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->cedula->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cedula->formatPattern()) ?>"<?= $Grid->cedula->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cedula->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_cedula" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_cedula" id="o<?= $Grid->RowIndex ?>_cedula" value="<?= HtmlEncode($Grid->cedula->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_cedula" class="el_sco_parcela_cedula">
<input type="<?= $Grid->cedula->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_cedula" id="x<?= $Grid->RowIndex ?>_cedula" data-table="sco_parcela" data-field="x_cedula" value="<?= $Grid->cedula->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->cedula->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->cedula->formatPattern()) ?>"<?= $Grid->cedula->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->cedula->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_cedula" class="el_sco_parcela_cedula">
<span<?= $Grid->cedula->viewAttributes() ?>>
<?= $Grid->cedula->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_cedula" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_cedula" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_cedula" value="<?= HtmlEncode($Grid->cedula->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_cedula" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_cedula" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_cedula" value="<?= HtmlEncode($Grid->cedula->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->titular->Visible) { // titular ?>
        <td data-name="titular"<?= $Grid->titular->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_titular" class="el_sco_parcela_titular">
<input type="<?= $Grid->titular->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_titular" id="x<?= $Grid->RowIndex ?>_titular" data-table="sco_parcela" data-field="x_titular" value="<?= $Grid->titular->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Grid->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->titular->formatPattern()) ?>"<?= $Grid->titular->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titular->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_titular" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_titular" id="o<?= $Grid->RowIndex ?>_titular" value="<?= HtmlEncode($Grid->titular->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_titular" class="el_sco_parcela_titular">
<input type="<?= $Grid->titular->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_titular" id="x<?= $Grid->RowIndex ?>_titular" data-table="sco_parcela" data-field="x_titular" value="<?= $Grid->titular->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Grid->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->titular->formatPattern()) ?>"<?= $Grid->titular->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titular->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_titular" class="el_sco_parcela_titular">
<span<?= $Grid->titular->viewAttributes() ?>>
<?= $Grid->titular->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_titular" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_titular" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_titular" value="<?= HtmlEncode($Grid->titular->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_titular" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_titular" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_titular" value="<?= HtmlEncode($Grid->titular->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->contrato->Visible) { // contrato ?>
        <td data-name="contrato"<?= $Grid->contrato->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<?php if ($Grid->contrato->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_contrato" class="el_sco_parcela_contrato">
<span<?= $Grid->contrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contrato->getDisplayValue($Grid->contrato->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_contrato" name="x<?= $Grid->RowIndex ?>_contrato" value="<?= HtmlEncode($Grid->contrato->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_contrato" class="el_sco_parcela_contrato">
<input type="<?= $Grid->contrato->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contrato" id="x<?= $Grid->RowIndex ?>_contrato" data-table="sco_parcela" data-field="x_contrato" value="<?= $Grid->contrato->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Grid->contrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->contrato->formatPattern()) ?>"<?= $Grid->contrato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contrato->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="sco_parcela" data-field="x_contrato" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_contrato" id="o<?= $Grid->RowIndex ?>_contrato" value="<?= HtmlEncode($Grid->contrato->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<?php if ($Grid->contrato->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_contrato" class="el_sco_parcela_contrato">
<span<?= $Grid->contrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->contrato->getDisplayValue($Grid->contrato->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_contrato" name="x<?= $Grid->RowIndex ?>_contrato" value="<?= HtmlEncode($Grid->contrato->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_contrato" class="el_sco_parcela_contrato">
<input type="<?= $Grid->contrato->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_contrato" id="x<?= $Grid->RowIndex ?>_contrato" data-table="sco_parcela" data-field="x_contrato" value="<?= $Grid->contrato->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Grid->contrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->contrato->formatPattern()) ?>"<?= $Grid->contrato->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->contrato->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_contrato" class="el_sco_parcela_contrato">
<span<?= $Grid->contrato->viewAttributes() ?>>
<?= $Grid->contrato->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_contrato" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_contrato" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_contrato" value="<?= HtmlEncode($Grid->contrato->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_contrato" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_contrato" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_contrato" value="<?= HtmlEncode($Grid->contrato->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->seccion->Visible) { // seccion ?>
        <td data-name="seccion"<?= $Grid->seccion->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_seccion" class="el_sco_parcela_seccion">
<input type="<?= $Grid->seccion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_seccion" id="x<?= $Grid->RowIndex ?>_seccion" data-table="sco_parcela" data-field="x_seccion" value="<?= $Grid->seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Grid->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->seccion->formatPattern()) ?>"<?= $Grid->seccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->seccion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_seccion" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_seccion" id="o<?= $Grid->RowIndex ?>_seccion" value="<?= HtmlEncode($Grid->seccion->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_seccion" class="el_sco_parcela_seccion">
<input type="<?= $Grid->seccion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_seccion" id="x<?= $Grid->RowIndex ?>_seccion" data-table="sco_parcela" data-field="x_seccion" value="<?= $Grid->seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Grid->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->seccion->formatPattern()) ?>"<?= $Grid->seccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->seccion->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_seccion" class="el_sco_parcela_seccion">
<span<?= $Grid->seccion->viewAttributes() ?>>
<?= $Grid->seccion->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_seccion" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_seccion" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_seccion" value="<?= HtmlEncode($Grid->seccion->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_seccion" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_seccion" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_seccion" value="<?= HtmlEncode($Grid->seccion->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->modulo->Visible) { // modulo ?>
        <td data-name="modulo"<?= $Grid->modulo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_modulo" class="el_sco_parcela_modulo">
<input type="<?= $Grid->modulo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_modulo" id="x<?= $Grid->RowIndex ?>_modulo" data-table="sco_parcela" data-field="x_modulo" value="<?= $Grid->modulo->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Grid->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->modulo->formatPattern()) ?>"<?= $Grid->modulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->modulo->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_modulo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_modulo" id="o<?= $Grid->RowIndex ?>_modulo" value="<?= HtmlEncode($Grid->modulo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_modulo" class="el_sco_parcela_modulo">
<input type="<?= $Grid->modulo->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_modulo" id="x<?= $Grid->RowIndex ?>_modulo" data-table="sco_parcela" data-field="x_modulo" value="<?= $Grid->modulo->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Grid->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->modulo->formatPattern()) ?>"<?= $Grid->modulo->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->modulo->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_modulo" class="el_sco_parcela_modulo">
<span<?= $Grid->modulo->viewAttributes() ?>>
<?= $Grid->modulo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_modulo" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_modulo" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_modulo" value="<?= HtmlEncode($Grid->modulo->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_modulo" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_modulo" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_modulo" value="<?= HtmlEncode($Grid->modulo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sub_seccion->Visible) { // sub_seccion ?>
        <td data-name="sub_seccion"<?= $Grid->sub_seccion->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_sub_seccion" class="el_sco_parcela_sub_seccion">
<input type="<?= $Grid->sub_seccion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_sub_seccion" id="x<?= $Grid->RowIndex ?>_sub_seccion" data-table="sco_parcela" data-field="x_sub_seccion" value="<?= $Grid->sub_seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Grid->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->sub_seccion->formatPattern()) ?>"<?= $Grid->sub_seccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sub_seccion->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_sub_seccion" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_sub_seccion" id="o<?= $Grid->RowIndex ?>_sub_seccion" value="<?= HtmlEncode($Grid->sub_seccion->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_sub_seccion" class="el_sco_parcela_sub_seccion">
<input type="<?= $Grid->sub_seccion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_sub_seccion" id="x<?= $Grid->RowIndex ?>_sub_seccion" data-table="sco_parcela" data-field="x_sub_seccion" value="<?= $Grid->sub_seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Grid->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->sub_seccion->formatPattern()) ?>"<?= $Grid->sub_seccion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->sub_seccion->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_sub_seccion" class="el_sco_parcela_sub_seccion">
<span<?= $Grid->sub_seccion->viewAttributes() ?>>
<?= $Grid->sub_seccion->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_sub_seccion" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_sub_seccion" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_sub_seccion" value="<?= HtmlEncode($Grid->sub_seccion->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_sub_seccion" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_sub_seccion" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_sub_seccion" value="<?= HtmlEncode($Grid->sub_seccion->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->parcela->Visible) { // parcela ?>
        <td data-name="parcela"<?= $Grid->parcela->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_parcela" class="el_sco_parcela_parcela">
<input type="<?= $Grid->parcela->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_parcela" id="x<?= $Grid->RowIndex ?>_parcela" data-table="sco_parcela" data-field="x_parcela" value="<?= $Grid->parcela->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Grid->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->parcela->formatPattern()) ?>"<?= $Grid->parcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->parcela->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_parcela" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_parcela" id="o<?= $Grid->RowIndex ?>_parcela" value="<?= HtmlEncode($Grid->parcela->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_parcela" class="el_sco_parcela_parcela">
<input type="<?= $Grid->parcela->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_parcela" id="x<?= $Grid->RowIndex ?>_parcela" data-table="sco_parcela" data-field="x_parcela" value="<?= $Grid->parcela->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Grid->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->parcela->formatPattern()) ?>"<?= $Grid->parcela->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->parcela->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_parcela" class="el_sco_parcela_parcela">
<span<?= $Grid->parcela->viewAttributes() ?>>
<?= $Grid->parcela->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_parcela" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_parcela" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_parcela" value="<?= HtmlEncode($Grid->parcela->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_parcela" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_parcela" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_parcela" value="<?= HtmlEncode($Grid->parcela->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->boveda->Visible) { // boveda ?>
        <td data-name="boveda"<?= $Grid->boveda->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_boveda" class="el_sco_parcela_boveda">
<input type="<?= $Grid->boveda->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_boveda" id="x<?= $Grid->RowIndex ?>_boveda" data-table="sco_parcela" data-field="x_boveda" value="<?= $Grid->boveda->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Grid->boveda->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->boveda->formatPattern()) ?>"<?= $Grid->boveda->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->boveda->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_boveda" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_boveda" id="o<?= $Grid->RowIndex ?>_boveda" value="<?= HtmlEncode($Grid->boveda->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_boveda" class="el_sco_parcela_boveda">
<input type="<?= $Grid->boveda->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_boveda" id="x<?= $Grid->RowIndex ?>_boveda" data-table="sco_parcela" data-field="x_boveda" value="<?= $Grid->boveda->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Grid->boveda->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->boveda->formatPattern()) ?>"<?= $Grid->boveda->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->boveda->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_boveda" class="el_sco_parcela_boveda">
<span<?= $Grid->boveda->viewAttributes() ?>>
<?= $Grid->boveda->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_boveda" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_boveda" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_boveda" value="<?= HtmlEncode($Grid->boveda->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_boveda" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_boveda" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_boveda" value="<?= HtmlEncode($Grid->boveda->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->apellido1->Visible) { // apellido1 ?>
        <td data-name="apellido1"<?= $Grid->apellido1->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_apellido1" class="el_sco_parcela_apellido1">
<input type="<?= $Grid->apellido1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_apellido1" id="x<?= $Grid->RowIndex ?>_apellido1" data-table="sco_parcela" data-field="x_apellido1" value="<?= $Grid->apellido1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->apellido1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->apellido1->formatPattern()) ?>"<?= $Grid->apellido1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellido1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_apellido1" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_apellido1" id="o<?= $Grid->RowIndex ?>_apellido1" value="<?= HtmlEncode($Grid->apellido1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_apellido1" class="el_sco_parcela_apellido1">
<input type="<?= $Grid->apellido1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_apellido1" id="x<?= $Grid->RowIndex ?>_apellido1" data-table="sco_parcela" data-field="x_apellido1" value="<?= $Grid->apellido1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->apellido1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->apellido1->formatPattern()) ?>"<?= $Grid->apellido1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellido1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_apellido1" class="el_sco_parcela_apellido1">
<span<?= $Grid->apellido1->viewAttributes() ?>>
<?= $Grid->apellido1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_apellido1" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_apellido1" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_apellido1" value="<?= HtmlEncode($Grid->apellido1->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_apellido1" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_apellido1" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_apellido1" value="<?= HtmlEncode($Grid->apellido1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->apellido2->Visible) { // apellido2 ?>
        <td data-name="apellido2"<?= $Grid->apellido2->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_apellido2" class="el_sco_parcela_apellido2">
<input type="<?= $Grid->apellido2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_apellido2" id="x<?= $Grid->RowIndex ?>_apellido2" data-table="sco_parcela" data-field="x_apellido2" value="<?= $Grid->apellido2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->apellido2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->apellido2->formatPattern()) ?>"<?= $Grid->apellido2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellido2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_apellido2" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_apellido2" id="o<?= $Grid->RowIndex ?>_apellido2" value="<?= HtmlEncode($Grid->apellido2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_apellido2" class="el_sco_parcela_apellido2">
<input type="<?= $Grid->apellido2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_apellido2" id="x<?= $Grid->RowIndex ?>_apellido2" data-table="sco_parcela" data-field="x_apellido2" value="<?= $Grid->apellido2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->apellido2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->apellido2->formatPattern()) ?>"<?= $Grid->apellido2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->apellido2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_apellido2" class="el_sco_parcela_apellido2">
<span<?= $Grid->apellido2->viewAttributes() ?>>
<?= $Grid->apellido2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_apellido2" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_apellido2" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_apellido2" value="<?= HtmlEncode($Grid->apellido2->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_apellido2" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_apellido2" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_apellido2" value="<?= HtmlEncode($Grid->apellido2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nombre1->Visible) { // nombre1 ?>
        <td data-name="nombre1"<?= $Grid->nombre1->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nombre1" class="el_sco_parcela_nombre1">
<input type="<?= $Grid->nombre1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nombre1" id="x<?= $Grid->RowIndex ?>_nombre1" data-table="sco_parcela" data-field="x_nombre1" value="<?= $Grid->nombre1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->nombre1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nombre1->formatPattern()) ?>"<?= $Grid->nombre1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_nombre1" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nombre1" id="o<?= $Grid->RowIndex ?>_nombre1" value="<?= HtmlEncode($Grid->nombre1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nombre1" class="el_sco_parcela_nombre1">
<input type="<?= $Grid->nombre1->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nombre1" id="x<?= $Grid->RowIndex ?>_nombre1" data-table="sco_parcela" data-field="x_nombre1" value="<?= $Grid->nombre1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->nombre1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nombre1->formatPattern()) ?>"<?= $Grid->nombre1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nombre1" class="el_sco_parcela_nombre1">
<span<?= $Grid->nombre1->viewAttributes() ?>>
<?= $Grid->nombre1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_nombre1" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_nombre1" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_nombre1" value="<?= HtmlEncode($Grid->nombre1->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_nombre1" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_nombre1" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_nombre1" value="<?= HtmlEncode($Grid->nombre1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nombre2->Visible) { // nombre2 ?>
        <td data-name="nombre2"<?= $Grid->nombre2->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nombre2" class="el_sco_parcela_nombre2">
<input type="<?= $Grid->nombre2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nombre2" id="x<?= $Grid->RowIndex ?>_nombre2" data-table="sco_parcela" data-field="x_nombre2" value="<?= $Grid->nombre2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->nombre2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nombre2->formatPattern()) ?>"<?= $Grid->nombre2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_nombre2" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nombre2" id="o<?= $Grid->RowIndex ?>_nombre2" value="<?= HtmlEncode($Grid->nombre2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nombre2" class="el_sco_parcela_nombre2">
<input type="<?= $Grid->nombre2->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nombre2" id="x<?= $Grid->RowIndex ?>_nombre2" data-table="sco_parcela" data-field="x_nombre2" value="<?= $Grid->nombre2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Grid->nombre2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nombre2->formatPattern()) ?>"<?= $Grid->nombre2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nombre2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_nombre2" class="el_sco_parcela_nombre2">
<span<?= $Grid->nombre2->viewAttributes() ?>>
<?= $Grid->nombre2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_nombre2" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_nombre2" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_nombre2" value="<?= HtmlEncode($Grid->nombre2->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_nombre2" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_nombre2" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_nombre2" value="<?= HtmlEncode($Grid->nombre2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <td data-name="fecha_inhumacion"<?= $Grid->fecha_inhumacion->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_fecha_inhumacion" class="el_sco_parcela_fecha_inhumacion">
<input type="<?= $Grid->fecha_inhumacion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_inhumacion" id="x<?= $Grid->RowIndex ?>_fecha_inhumacion" data-table="sco_parcela" data-field="x_fecha_inhumacion" value="<?= $Grid->fecha_inhumacion->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->fecha_inhumacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_inhumacion->formatPattern()) ?>"<?= $Grid->fecha_inhumacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_inhumacion->getErrorMessage() ?></div>
<?php if (!$Grid->fecha_inhumacion->ReadOnly && !$Grid->fecha_inhumacion->Disabled && !isset($Grid->fecha_inhumacion->EditAttrs["readonly"]) && !isset($Grid->fecha_inhumacion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_parcelagrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_parcelagrid", "x<?= $Grid->RowIndex ?>_fecha_inhumacion", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_fecha_inhumacion" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha_inhumacion" id="o<?= $Grid->RowIndex ?>_fecha_inhumacion" value="<?= HtmlEncode($Grid->fecha_inhumacion->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_fecha_inhumacion" class="el_sco_parcela_fecha_inhumacion">
<input type="<?= $Grid->fecha_inhumacion->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_inhumacion" id="x<?= $Grid->RowIndex ?>_fecha_inhumacion" data-table="sco_parcela" data-field="x_fecha_inhumacion" value="<?= $Grid->fecha_inhumacion->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->fecha_inhumacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_inhumacion->formatPattern()) ?>"<?= $Grid->fecha_inhumacion->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_inhumacion->getErrorMessage() ?></div>
<?php if (!$Grid->fecha_inhumacion->ReadOnly && !$Grid->fecha_inhumacion->Disabled && !isset($Grid->fecha_inhumacion->EditAttrs["readonly"]) && !isset($Grid->fecha_inhumacion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_parcelagrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_parcelagrid", "x<?= $Grid->RowIndex ?>_fecha_inhumacion", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_fecha_inhumacion" class="el_sco_parcela_fecha_inhumacion">
<span<?= $Grid->fecha_inhumacion->viewAttributes() ?>>
<?= $Grid->fecha_inhumacion->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_fecha_inhumacion" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_fecha_inhumacion" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_fecha_inhumacion" value="<?= HtmlEncode($Grid->fecha_inhumacion->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_fecha_inhumacion" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_fecha_inhumacion" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_fecha_inhumacion" value="<?= HtmlEncode($Grid->fecha_inhumacion->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->funeraria->Visible) { // funeraria ?>
        <td data-name="funeraria"<?= $Grid->funeraria->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_funeraria" class="el_sco_parcela_funeraria">
<input type="<?= $Grid->funeraria->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_funeraria" id="x<?= $Grid->RowIndex ?>_funeraria" data-table="sco_parcela" data-field="x_funeraria" value="<?= $Grid->funeraria->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->funeraria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->funeraria->formatPattern()) ?>"<?= $Grid->funeraria->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->funeraria->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_parcela" data-field="x_funeraria" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_funeraria" id="o<?= $Grid->RowIndex ?>_funeraria" value="<?= HtmlEncode($Grid->funeraria->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_funeraria" class="el_sco_parcela_funeraria">
<input type="<?= $Grid->funeraria->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_funeraria" id="x<?= $Grid->RowIndex ?>_funeraria" data-table="sco_parcela" data-field="x_funeraria" value="<?= $Grid->funeraria->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->funeraria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->funeraria->formatPattern()) ?>"<?= $Grid->funeraria->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->funeraria->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_parcela_funeraria" class="el_sco_parcela_funeraria">
<span<?= $Grid->funeraria->viewAttributes() ?>>
<?= $Grid->funeraria->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_parcela" data-field="x_funeraria" data-hidden="1" name="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_funeraria" id="fsco_parcelagrid$x<?= $Grid->RowIndex ?>_funeraria" value="<?= HtmlEncode($Grid->funeraria->FormValue) ?>">
<input type="hidden" data-table="sco_parcela" data-field="x_funeraria" data-hidden="1" data-old name="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_funeraria" id="fsco_parcelagrid$o<?= $Grid->RowIndex ?>_funeraria" value="<?= HtmlEncode($Grid->funeraria->OldValue) ?>">
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
loadjs.ready(["fsco_parcelagrid","load"], () => fsco_parcelagrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_parcelagrid">
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
    ew.addEventHandlers("sco_parcela");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
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
