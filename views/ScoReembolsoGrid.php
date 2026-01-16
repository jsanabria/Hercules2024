<?php

namespace PHPMaker2024\hercules;

// Set up and run Grid object
$Grid = Container("ScoReembolsoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fsco_reembolsogrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { sco_reembolso: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reembolsogrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["monto_usd", [fields.monto_usd.visible && fields.monto_usd.required ? ew.Validators.required(fields.monto_usd.caption) : null, ew.Validators.float], fields.monto_usd.isInvalid],
            ["monto_bs", [fields.monto_bs.visible && fields.monto_bs.required ? ew.Validators.required(fields.monto_bs.caption) : null, ew.Validators.float], fields.monto_bs.isInvalid],
            ["titular", [fields.titular.visible && fields.titular.required ? ew.Validators.required(fields.titular.caption) : null], fields.titular.isInvalid],
            ["nro_ref", [fields.nro_ref.visible && fields.nro_ref.required ? ew.Validators.required(fields.nro_ref.caption) : null], fields.nro_ref.isInvalid],
            ["motivo", [fields.motivo.visible && fields.motivo.required ? ew.Validators.required(fields.motivo.caption) : null], fields.motivo.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["coordinador", [fields.coordinador.visible && fields.coordinador.required ? ew.Validators.required(fields.coordinador.caption) : null], fields.coordinador.isInvalid],
            ["fecha_pago", [fields.fecha_pago.visible && fields.fecha_pago.required ? ew.Validators.required(fields.fecha_pago.caption) : null, ew.Validators.datetime(fields.fecha_pago.clientFormatPattern)], fields.fecha_pago.isInvalid],
            ["email_enviado", [fields.email_enviado.visible && fields.email_enviado.required ? ew.Validators.required(fields.email_enviado.caption) : null], fields.email_enviado.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["fecha",false],["monto_usd",false],["monto_bs",false],["titular",false],["nro_ref",false],["motivo",false],["estatus",false],["coordinador",false],["fecha_pago",false],["email_enviado",false]];
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
            "motivo": <?= $Grid->motivo->toClientList($Grid) ?>,
            "estatus": <?= $Grid->estatus->toClientList($Grid) ?>,
            "coordinador": <?= $Grid->coordinador->toClientList($Grid) ?>,
            "email_enviado": <?= $Grid->email_enviado->toClientList($Grid) ?>,
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
<div id="fsco_reembolsogrid" class="ew-form ew-list-form">
<div id="gmp_sco_reembolso" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_sco_reembolsogrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Grid->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Grid->fecha->headerCellClass() ?>"><div id="elh_sco_reembolso_fecha" class="sco_reembolso_fecha"><?= $Grid->renderFieldHeader($Grid->fecha) ?></div></th>
<?php } ?>
<?php if ($Grid->monto_usd->Visible) { // monto_usd ?>
        <th data-name="monto_usd" class="<?= $Grid->monto_usd->headerCellClass() ?>"><div id="elh_sco_reembolso_monto_usd" class="sco_reembolso_monto_usd"><?= $Grid->renderFieldHeader($Grid->monto_usd) ?></div></th>
<?php } ?>
<?php if ($Grid->monto_bs->Visible) { // monto_bs ?>
        <th data-name="monto_bs" class="<?= $Grid->monto_bs->headerCellClass() ?>"><div id="elh_sco_reembolso_monto_bs" class="sco_reembolso_monto_bs"><?= $Grid->renderFieldHeader($Grid->monto_bs) ?></div></th>
<?php } ?>
<?php if ($Grid->titular->Visible) { // titular ?>
        <th data-name="titular" class="<?= $Grid->titular->headerCellClass() ?>"><div id="elh_sco_reembolso_titular" class="sco_reembolso_titular"><?= $Grid->renderFieldHeader($Grid->titular) ?></div></th>
<?php } ?>
<?php if ($Grid->nro_ref->Visible) { // nro_ref ?>
        <th data-name="nro_ref" class="<?= $Grid->nro_ref->headerCellClass() ?>"><div id="elh_sco_reembolso_nro_ref" class="sco_reembolso_nro_ref"><?= $Grid->renderFieldHeader($Grid->nro_ref) ?></div></th>
<?php } ?>
<?php if ($Grid->motivo->Visible) { // motivo ?>
        <th data-name="motivo" class="<?= $Grid->motivo->headerCellClass() ?>"><div id="elh_sco_reembolso_motivo" class="sco_reembolso_motivo"><?= $Grid->renderFieldHeader($Grid->motivo) ?></div></th>
<?php } ?>
<?php if ($Grid->estatus->Visible) { // estatus ?>
        <th data-name="estatus" class="<?= $Grid->estatus->headerCellClass() ?>"><div id="elh_sco_reembolso_estatus" class="sco_reembolso_estatus"><?= $Grid->renderFieldHeader($Grid->estatus) ?></div></th>
<?php } ?>
<?php if ($Grid->coordinador->Visible) { // coordinador ?>
        <th data-name="coordinador" class="<?= $Grid->coordinador->headerCellClass() ?>"><div id="elh_sco_reembolso_coordinador" class="sco_reembolso_coordinador"><?= $Grid->renderFieldHeader($Grid->coordinador) ?></div></th>
<?php } ?>
<?php if ($Grid->fecha_pago->Visible) { // fecha_pago ?>
        <th data-name="fecha_pago" class="<?= $Grid->fecha_pago->headerCellClass() ?>"><div id="elh_sco_reembolso_fecha_pago" class="sco_reembolso_fecha_pago"><?= $Grid->renderFieldHeader($Grid->fecha_pago) ?></div></th>
<?php } ?>
<?php if ($Grid->email_enviado->Visible) { // email_enviado ?>
        <th data-name="email_enviado" class="<?= $Grid->email_enviado->headerCellClass() ?>"><div id="elh_sco_reembolso_email_enviado" class="sco_reembolso_email_enviado"><?= $Grid->renderFieldHeader($Grid->email_enviado) ?></div></th>
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
    <?php if ($Grid->fecha->Visible) { // fecha ?>
        <td data-name="fecha"<?= $Grid->fecha->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_fecha" class="el_sco_reembolso_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_reembolso" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
<?php if (!$Grid->fecha->ReadOnly && !$Grid->fecha->Disabled && !isset($Grid->fecha->EditAttrs["readonly"]) && !isset($Grid->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_reembolsogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_reembolsogrid", "x<?= $Grid->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_fecha" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha" id="o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_fecha" class="el_sco_reembolso_fecha">
<input type="<?= $Grid->fecha->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha" id="x<?= $Grid->RowIndex ?>_fecha" data-table="sco_reembolso" data-field="x_fecha" value="<?= $Grid->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha->formatPattern()) ?>"<?= $Grid->fecha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha->getErrorMessage() ?></div>
<?php if (!$Grid->fecha->ReadOnly && !$Grid->fecha->Disabled && !isset($Grid->fecha->EditAttrs["readonly"]) && !isset($Grid->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_reembolsogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_reembolsogrid", "x<?= $Grid->RowIndex ?>_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_fecha" class="el_sco_reembolso_fecha">
<span<?= $Grid->fecha->viewAttributes() ?>>
<?= $Grid->fecha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_fecha" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_fecha" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_fecha" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_fecha" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_fecha" value="<?= HtmlEncode($Grid->fecha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->monto_usd->Visible) { // monto_usd ?>
        <td data-name="monto_usd"<?= $Grid->monto_usd->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_monto_usd" class="el_sco_reembolso_monto_usd">
<input type="<?= $Grid->monto_usd->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto_usd" id="x<?= $Grid->RowIndex ?>_monto_usd" data-table="sco_reembolso" data-field="x_monto_usd" value="<?= $Grid->monto_usd->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto_usd->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto_usd->formatPattern()) ?>"<?= $Grid->monto_usd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto_usd->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_monto_usd" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_monto_usd" id="o<?= $Grid->RowIndex ?>_monto_usd" value="<?= HtmlEncode($Grid->monto_usd->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_monto_usd" class="el_sco_reembolso_monto_usd">
<input type="<?= $Grid->monto_usd->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto_usd" id="x<?= $Grid->RowIndex ?>_monto_usd" data-table="sco_reembolso" data-field="x_monto_usd" value="<?= $Grid->monto_usd->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto_usd->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto_usd->formatPattern()) ?>"<?= $Grid->monto_usd->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto_usd->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_monto_usd" class="el_sco_reembolso_monto_usd">
<span<?= $Grid->monto_usd->viewAttributes() ?>>
<?= $Grid->monto_usd->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_monto_usd" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_monto_usd" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_monto_usd" value="<?= HtmlEncode($Grid->monto_usd->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_monto_usd" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_monto_usd" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_monto_usd" value="<?= HtmlEncode($Grid->monto_usd->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->monto_bs->Visible) { // monto_bs ?>
        <td data-name="monto_bs"<?= $Grid->monto_bs->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_monto_bs" class="el_sco_reembolso_monto_bs">
<input type="<?= $Grid->monto_bs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto_bs" id="x<?= $Grid->RowIndex ?>_monto_bs" data-table="sco_reembolso" data-field="x_monto_bs" value="<?= $Grid->monto_bs->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto_bs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto_bs->formatPattern()) ?>"<?= $Grid->monto_bs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto_bs->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_monto_bs" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_monto_bs" id="o<?= $Grid->RowIndex ?>_monto_bs" value="<?= HtmlEncode($Grid->monto_bs->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_monto_bs" class="el_sco_reembolso_monto_bs">
<input type="<?= $Grid->monto_bs->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_monto_bs" id="x<?= $Grid->RowIndex ?>_monto_bs" data-table="sco_reembolso" data-field="x_monto_bs" value="<?= $Grid->monto_bs->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->monto_bs->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->monto_bs->formatPattern()) ?>"<?= $Grid->monto_bs->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->monto_bs->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_monto_bs" class="el_sco_reembolso_monto_bs">
<span<?= $Grid->monto_bs->viewAttributes() ?>>
<?= $Grid->monto_bs->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_monto_bs" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_monto_bs" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_monto_bs" value="<?= HtmlEncode($Grid->monto_bs->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_monto_bs" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_monto_bs" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_monto_bs" value="<?= HtmlEncode($Grid->monto_bs->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->titular->Visible) { // titular ?>
        <td data-name="titular"<?= $Grid->titular->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_titular" class="el_sco_reembolso_titular">
<input type="<?= $Grid->titular->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_titular" id="x<?= $Grid->RowIndex ?>_titular" data-table="sco_reembolso" data-field="x_titular" value="<?= $Grid->titular->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->titular->formatPattern()) ?>"<?= $Grid->titular->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titular->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_titular" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_titular" id="o<?= $Grid->RowIndex ?>_titular" value="<?= HtmlEncode($Grid->titular->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_titular" class="el_sco_reembolso_titular">
<input type="<?= $Grid->titular->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_titular" id="x<?= $Grid->RowIndex ?>_titular" data-table="sco_reembolso" data-field="x_titular" value="<?= $Grid->titular->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Grid->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->titular->formatPattern()) ?>"<?= $Grid->titular->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->titular->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_titular" class="el_sco_reembolso_titular">
<span<?= $Grid->titular->viewAttributes() ?>>
<?= $Grid->titular->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_titular" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_titular" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_titular" value="<?= HtmlEncode($Grid->titular->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_titular" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_titular" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_titular" value="<?= HtmlEncode($Grid->titular->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nro_ref->Visible) { // nro_ref ?>
        <td data-name="nro_ref"<?= $Grid->nro_ref->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_nro_ref" class="el_sco_reembolso_nro_ref">
<input type="<?= $Grid->nro_ref->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nro_ref" id="x<?= $Grid->RowIndex ?>_nro_ref" data-table="sco_reembolso" data-field="x_nro_ref" value="<?= $Grid->nro_ref->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->nro_ref->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nro_ref->formatPattern()) ?>"<?= $Grid->nro_ref->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nro_ref->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_nro_ref" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_nro_ref" id="o<?= $Grid->RowIndex ?>_nro_ref" value="<?= HtmlEncode($Grid->nro_ref->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_nro_ref" class="el_sco_reembolso_nro_ref">
<input type="<?= $Grid->nro_ref->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_nro_ref" id="x<?= $Grid->RowIndex ?>_nro_ref" data-table="sco_reembolso" data-field="x_nro_ref" value="<?= $Grid->nro_ref->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Grid->nro_ref->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->nro_ref->formatPattern()) ?>"<?= $Grid->nro_ref->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nro_ref->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_nro_ref" class="el_sco_reembolso_nro_ref">
<span<?= $Grid->nro_ref->viewAttributes() ?>>
<?= $Grid->nro_ref->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_nro_ref" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_nro_ref" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_nro_ref" value="<?= HtmlEncode($Grid->nro_ref->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_nro_ref" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_nro_ref" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_nro_ref" value="<?= HtmlEncode($Grid->nro_ref->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->motivo->Visible) { // motivo ?>
        <td data-name="motivo"<?= $Grid->motivo->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_motivo" class="el_sco_reembolso_motivo">
    <select
        id="x<?= $Grid->RowIndex ?>_motivo"
        name="x<?= $Grid->RowIndex ?>_motivo"
        class="form-select ew-select<?= $Grid->motivo->isInvalidClass() ?>"
        <?php if (!$Grid->motivo->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_motivo"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_motivo"
        data-value-separator="<?= $Grid->motivo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->motivo->getPlaceHolder()) ?>"
        <?= $Grid->motivo->editAttributes() ?>>
        <?= $Grid->motivo->selectOptionListHtml("x{$Grid->RowIndex}_motivo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->motivo->getErrorMessage() ?></div>
<?= $Grid->motivo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_motivo") ?>
<?php if (!$Grid->motivo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_motivo", selectId: "fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_motivo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsogrid.lists.motivo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_motivo", form: "fsco_reembolsogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_motivo", form: "fsco_reembolsogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.motivo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_motivo" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_motivo" id="o<?= $Grid->RowIndex ?>_motivo" value="<?= HtmlEncode($Grid->motivo->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_motivo" class="el_sco_reembolso_motivo">
    <select
        id="x<?= $Grid->RowIndex ?>_motivo"
        name="x<?= $Grid->RowIndex ?>_motivo"
        class="form-select ew-select<?= $Grid->motivo->isInvalidClass() ?>"
        <?php if (!$Grid->motivo->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_motivo"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_motivo"
        data-value-separator="<?= $Grid->motivo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->motivo->getPlaceHolder()) ?>"
        <?= $Grid->motivo->editAttributes() ?>>
        <?= $Grid->motivo->selectOptionListHtml("x{$Grid->RowIndex}_motivo") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->motivo->getErrorMessage() ?></div>
<?= $Grid->motivo->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_motivo") ?>
<?php if (!$Grid->motivo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_motivo", selectId: "fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_motivo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsogrid.lists.motivo?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_motivo", form: "fsco_reembolsogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_motivo", form: "fsco_reembolsogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.motivo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_motivo" class="el_sco_reembolso_motivo">
<span<?= $Grid->motivo->viewAttributes() ?>>
<?= $Grid->motivo->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_motivo" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_motivo" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_motivo" value="<?= HtmlEncode($Grid->motivo->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_motivo" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_motivo" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_motivo" value="<?= HtmlEncode($Grid->motivo->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->estatus->Visible) { // estatus ?>
        <td data-name="estatus"<?= $Grid->estatus->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_estatus" class="el_sco_reembolso_estatus">
    <select
        id="x<?= $Grid->RowIndex ?>_estatus"
        name="x<?= $Grid->RowIndex ?>_estatus"
        class="form-select ew-select<?= $Grid->estatus->isInvalidClass() ?>"
        <?php if (!$Grid->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_estatus"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_estatus"
        data-value-separator="<?= $Grid->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>"
        <?= $Grid->estatus->editAttributes() ?>>
        <?= $Grid->estatus->selectOptionListHtml("x{$Grid->RowIndex}_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<?php if (!$Grid->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_estatus", selectId: "fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsogrid.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_reembolsogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_reembolsogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_estatus" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_estatus" id="o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_estatus" class="el_sco_reembolso_estatus">
    <select
        id="x<?= $Grid->RowIndex ?>_estatus"
        name="x<?= $Grid->RowIndex ?>_estatus"
        class="form-select ew-select<?= $Grid->estatus->isInvalidClass() ?>"
        <?php if (!$Grid->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_estatus"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_estatus"
        data-value-separator="<?= $Grid->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->estatus->getPlaceHolder()) ?>"
        <?= $Grid->estatus->editAttributes() ?>>
        <?= $Grid->estatus->selectOptionListHtml("x{$Grid->RowIndex}_estatus") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->estatus->getErrorMessage() ?></div>
<?php if (!$Grid->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsogrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_estatus", selectId: "fsco_reembolsogrid_x<?= $Grid->RowIndex ?>_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsogrid.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_reembolsogrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_estatus", form: "fsco_reembolsogrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_estatus" class="el_sco_reembolso_estatus">
<span<?= $Grid->estatus->viewAttributes() ?>>
<?= $Grid->estatus->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_estatus" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_estatus" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_estatus" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_estatus" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_estatus" value="<?= HtmlEncode($Grid->estatus->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->coordinador->Visible) { // coordinador ?>
        <td data-name="coordinador"<?= $Grid->coordinador->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_coordinador" class="el_sco_reembolso_coordinador">
<?php
if (IsRTL()) {
    $Grid->coordinador->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_coordinador" class="ew-auto-suggest">
    <input type="<?= $Grid->coordinador->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_coordinador" id="sv_x<?= $Grid->RowIndex ?>_coordinador" value="<?= RemoveHtml($Grid->coordinador->EditValue) ?>" autocomplete="off" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->coordinador->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->coordinador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->coordinador->formatPattern()) ?>"<?= $Grid->coordinador->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_reembolso" data-field="x_coordinador" data-input="sv_x<?= $Grid->RowIndex ?>_coordinador" data-value-separator="<?= $Grid->coordinador->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_coordinador" id="x<?= $Grid->RowIndex ?>_coordinador" value="<?= HtmlEncode($Grid->coordinador->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->coordinador->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_reembolsogrid", function() {
    fsco_reembolsogrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_coordinador","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->coordinador->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_reembolso.fields.coordinador.autoSuggestOptions));
});
</script>
<?= $Grid->coordinador->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_coordinador") ?>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_coordinador" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_coordinador" id="o<?= $Grid->RowIndex ?>_coordinador" value="<?= HtmlEncode($Grid->coordinador->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_coordinador" class="el_sco_reembolso_coordinador">
<?php
if (IsRTL()) {
    $Grid->coordinador->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_coordinador" class="ew-auto-suggest">
    <input type="<?= $Grid->coordinador->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_coordinador" id="sv_x<?= $Grid->RowIndex ?>_coordinador" value="<?= RemoveHtml($Grid->coordinador->EditValue) ?>" autocomplete="off" size="30" maxlength="10" placeholder="<?= HtmlEncode($Grid->coordinador->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->coordinador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->coordinador->formatPattern()) ?>"<?= $Grid->coordinador->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="sco_reembolso" data-field="x_coordinador" data-input="sv_x<?= $Grid->RowIndex ?>_coordinador" data-value-separator="<?= $Grid->coordinador->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_coordinador" id="x<?= $Grid->RowIndex ?>_coordinador" value="<?= HtmlEncode($Grid->coordinador->CurrentValue) ?>"></selection-list>
<div class="invalid-feedback"><?= $Grid->coordinador->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_reembolsogrid", function() {
    fsco_reembolsogrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_coordinador","forceSelect":false}, { lookupAllDisplayFields: <?= $Grid->coordinador->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_reembolso.fields.coordinador.autoSuggestOptions));
});
</script>
<?= $Grid->coordinador->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_coordinador") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_coordinador" class="el_sco_reembolso_coordinador">
<span<?= $Grid->coordinador->viewAttributes() ?>>
<?= $Grid->coordinador->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_coordinador" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_coordinador" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_coordinador" value="<?= HtmlEncode($Grid->coordinador->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_coordinador" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_coordinador" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_coordinador" value="<?= HtmlEncode($Grid->coordinador->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fecha_pago->Visible) { // fecha_pago ?>
        <td data-name="fecha_pago"<?= $Grid->fecha_pago->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_fecha_pago" class="el_sco_reembolso_fecha_pago">
<input type="<?= $Grid->fecha_pago->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_pago" id="x<?= $Grid->RowIndex ?>_fecha_pago" data-table="sco_reembolso" data-field="x_fecha_pago" value="<?= $Grid->fecha_pago->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_pago->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_pago->formatPattern()) ?>"<?= $Grid->fecha_pago->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_pago->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_fecha_pago" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_fecha_pago" id="o<?= $Grid->RowIndex ?>_fecha_pago" value="<?= HtmlEncode($Grid->fecha_pago->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_fecha_pago" class="el_sco_reembolso_fecha_pago">
<input type="<?= $Grid->fecha_pago->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_fecha_pago" id="x<?= $Grid->RowIndex ?>_fecha_pago" data-table="sco_reembolso" data-field="x_fecha_pago" value="<?= $Grid->fecha_pago->EditValue ?>" placeholder="<?= HtmlEncode($Grid->fecha_pago->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->fecha_pago->formatPattern()) ?>"<?= $Grid->fecha_pago->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->fecha_pago->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_fecha_pago" class="el_sco_reembolso_fecha_pago">
<span<?= $Grid->fecha_pago->viewAttributes() ?>>
<?= $Grid->fecha_pago->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_fecha_pago" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_fecha_pago" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_fecha_pago" value="<?= HtmlEncode($Grid->fecha_pago->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_fecha_pago" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_fecha_pago" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_fecha_pago" value="<?= HtmlEncode($Grid->fecha_pago->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->email_enviado->Visible) { // email_enviado ?>
        <td data-name="email_enviado"<?= $Grid->email_enviado->cellAttributes() ?>>
<?php if ($Grid->RowType == RowType::ADD) { // Add record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_email_enviado" class="el_sco_reembolso_email_enviado">
<template id="tp_x<?= $Grid->RowIndex ?>_email_enviado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_reembolso" data-field="x_email_enviado" name="x<?= $Grid->RowIndex ?>_email_enviado" id="x<?= $Grid->RowIndex ?>_email_enviado"<?= $Grid->email_enviado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_email_enviado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_email_enviado"
    name="x<?= $Grid->RowIndex ?>_email_enviado"
    value="<?= HtmlEncode($Grid->email_enviado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_email_enviado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_email_enviado"
    data-repeatcolumn="0"
    class="form-control<?= $Grid->email_enviado->isInvalidClass() ?>"
    data-table="sco_reembolso"
    data-field="x_email_enviado"
    data-value-separator="<?= $Grid->email_enviado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->email_enviado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->email_enviado->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="sco_reembolso" data-field="x_email_enviado" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_email_enviado" id="o<?= $Grid->RowIndex ?>_email_enviado" value="<?= HtmlEncode($Grid->email_enviado->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == RowType::EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_email_enviado" class="el_sco_reembolso_email_enviado">
<template id="tp_x<?= $Grid->RowIndex ?>_email_enviado">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_reembolso" data-field="x_email_enviado" name="x<?= $Grid->RowIndex ?>_email_enviado" id="x<?= $Grid->RowIndex ?>_email_enviado"<?= $Grid->email_enviado->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_email_enviado" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_email_enviado"
    name="x<?= $Grid->RowIndex ?>_email_enviado"
    value="<?= HtmlEncode($Grid->email_enviado->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_email_enviado"
    data-target="dsl_x<?= $Grid->RowIndex ?>_email_enviado"
    data-repeatcolumn="0"
    class="form-control<?= $Grid->email_enviado->isInvalidClass() ?>"
    data-table="sco_reembolso"
    data-field="x_email_enviado"
    data-value-separator="<?= $Grid->email_enviado->displayValueSeparatorAttribute() ?>"
    <?= $Grid->email_enviado->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->email_enviado->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == RowType::VIEW) { // View record ?>
<span id="el<?= $Grid->RowIndex == '$rowindex$' ? '$rowindex$' : $Grid->RowCount ?>_sco_reembolso_email_enviado" class="el_sco_reembolso_email_enviado">
<span<?= $Grid->email_enviado->viewAttributes() ?>>
<?= $Grid->email_enviado->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="sco_reembolso" data-field="x_email_enviado" data-hidden="1" name="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_email_enviado" id="fsco_reembolsogrid$x<?= $Grid->RowIndex ?>_email_enviado" value="<?= HtmlEncode($Grid->email_enviado->FormValue) ?>">
<input type="hidden" data-table="sco_reembolso" data-field="x_email_enviado" data-hidden="1" data-old name="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_email_enviado" id="fsco_reembolsogrid$o<?= $Grid->RowIndex ?>_email_enviado" value="<?= HtmlEncode($Grid->email_enviado->OldValue) ?>">
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
loadjs.ready(["fsco_reembolsogrid","load"], () => fsco_reembolsogrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
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
<input type="hidden" name="detailpage" value="fsco_reembolsogrid">
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
    ew.addEventHandlers("sco_reembolso");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
