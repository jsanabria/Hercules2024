<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_mttotecnicoedit" id="fsco_mttotecnicoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_mttotecnicoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnicoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nmttotecnico", [fields.Nmttotecnico.visible && fields.Nmttotecnico.required ? ew.Validators.required(fields.Nmttotecnico.caption) : null], fields.Nmttotecnico.isInvalid],
            ["tipo_solicitud", [fields.tipo_solicitud.visible && fields.tipo_solicitud.required ? ew.Validators.required(fields.tipo_solicitud.caption) : null], fields.tipo_solicitud.isInvalid],
            ["unidad_solicitante", [fields.unidad_solicitante.visible && fields.unidad_solicitante.required ? ew.Validators.required(fields.unidad_solicitante.caption) : null], fields.unidad_solicitante.isInvalid],
            ["area_falla", [fields.area_falla.visible && fields.area_falla.required ? ew.Validators.required(fields.area_falla.caption) : null], fields.area_falla.isInvalid],
            ["comentario", [fields.comentario.visible && fields.comentario.required ? ew.Validators.required(fields.comentario.caption) : null], fields.comentario.isInvalid],
            ["prioridad", [fields.prioridad.visible && fields.prioridad.required ? ew.Validators.required(fields.prioridad.caption) : null], fields.prioridad.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["falla_atendida_por", [fields.falla_atendida_por.visible && fields.falla_atendida_por.required ? ew.Validators.required(fields.falla_atendida_por.caption) : null], fields.falla_atendida_por.isInvalid],
            ["diagnostico", [fields.diagnostico.visible && fields.diagnostico.required ? ew.Validators.required(fields.diagnostico.caption) : null], fields.diagnostico.isInvalid],
            ["solucion", [fields.solucion.visible && fields.solucion.required ? ew.Validators.required(fields.solucion.caption) : null], fields.solucion.isInvalid],
            ["requiere_materiales", [fields.requiere_materiales.visible && fields.requiere_materiales.required ? ew.Validators.required(fields.requiere_materiales.caption) : null], fields.requiere_materiales.isInvalid],
            ["fecha_solucion", [fields.fecha_solucion.visible && fields.fecha_solucion.required ? ew.Validators.required(fields.fecha_solucion.caption) : null, ew.Validators.datetime(fields.fecha_solucion.clientFormatPattern)], fields.fecha_solucion.isInvalid]
        ])

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
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
            "falla_atendida_por": <?= $Page->falla_atendida_por->toClientList($Page) ?>,
            "requiere_materiales": <?= $Page->requiere_materiales->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_mttotecnico">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nmttotecnico->Visible) { // Nmttotecnico ?>
    <div id="r_Nmttotecnico"<?= $Page->Nmttotecnico->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_Nmttotecnico" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nmttotecnico->caption() ?><?= $Page->Nmttotecnico->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nmttotecnico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_Nmttotecnico">
<span<?= $Page->Nmttotecnico->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nmttotecnico->getDisplayValue($Page->Nmttotecnico->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_mttotecnico" data-field="x_Nmttotecnico" data-hidden="1" name="x_Nmttotecnico" id="x_Nmttotecnico" value="<?= HtmlEncode($Page->Nmttotecnico->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
    <div id="r_tipo_solicitud"<?= $Page->tipo_solicitud->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_tipo_solicitud" for="x_tipo_solicitud" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_solicitud->caption() ?><?= $Page->tipo_solicitud->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_solicitud->cellAttributes() ?>>
<span id="el_sco_mttotecnico_tipo_solicitud">
<span<?= $Page->tipo_solicitud->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo_solicitud->getDisplayValue($Page->tipo_solicitud->EditValue) ?></span></span>
<input type="hidden" data-table="sco_mttotecnico" data-field="x_tipo_solicitud" data-hidden="1" name="x_tipo_solicitud" id="x_tipo_solicitud" value="<?= HtmlEncode($Page->tipo_solicitud->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
    <div id="r_unidad_solicitante"<?= $Page->unidad_solicitante->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_unidad_solicitante" for="x_unidad_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidad_solicitante->caption() ?><?= $Page->unidad_solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_mttotecnico_unidad_solicitante">
<span<?= $Page->unidad_solicitante->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->unidad_solicitante->getDisplayValue($Page->unidad_solicitante->EditValue) ?></span></span>
<input type="hidden" data-table="sco_mttotecnico" data-field="x_unidad_solicitante" data-hidden="1" name="x_unidad_solicitante" id="x_unidad_solicitante" value="<?= HtmlEncode($Page->unidad_solicitante->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->area_falla->Visible) { // area_falla ?>
    <div id="r_area_falla"<?= $Page->area_falla->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_area_falla" for="x_area_falla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->area_falla->caption() ?><?= $Page->area_falla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->area_falla->cellAttributes() ?>>
<span id="el_sco_mttotecnico_area_falla">
<span<?= $Page->area_falla->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->area_falla->getDisplayValue($Page->area_falla->EditValue) ?></span></span>
<input type="hidden" data-table="sco_mttotecnico" data-field="x_area_falla" data-hidden="1" name="x_area_falla" id="x_area_falla" value="<?= HtmlEncode($Page->area_falla->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <div id="r_comentario"<?= $Page->comentario->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_comentario" for="x_comentario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comentario->caption() ?><?= $Page->comentario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->comentario->cellAttributes() ?>>
<span id="el_sco_mttotecnico_comentario">
<span<?= $Page->comentario->viewAttributes() ?>>
<?= $Page->comentario->EditValue ?></span>
<input type="hidden" data-table="sco_mttotecnico" data-field="x_comentario" data-hidden="1" name="x_comentario" id="x_comentario" value="<?= HtmlEncode($Page->comentario->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->prioridad->Visible) { // prioridad ?>
    <div id="r_prioridad"<?= $Page->prioridad->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_prioridad" for="x_prioridad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->prioridad->caption() ?><?= $Page->prioridad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->prioridad->cellAttributes() ?>>
<span id="el_sco_mttotecnico_prioridad">
<span<?= $Page->prioridad->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->prioridad->getDisplayValue($Page->prioridad->EditValue) ?></span></span>
<input type="hidden" data-table="sco_mttotecnico" data-field="x_prioridad" data-hidden="1" name="x_prioridad" id="x_prioridad" value="<?= HtmlEncode($Page->prioridad->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_mttotecnico_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoedit_x_estatus"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_mttotecnicoedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_mttotecnicoedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_mttotecnicoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->falla_atendida_por->Visible) { // falla_atendida_por ?>
    <div id="r_falla_atendida_por"<?= $Page->falla_atendida_por->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_falla_atendida_por" for="x_falla_atendida_por" class="<?= $Page->LeftColumnClass ?>"><?= $Page->falla_atendida_por->caption() ?><?= $Page->falla_atendida_por->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->falla_atendida_por->cellAttributes() ?>>
<span id="el_sco_mttotecnico_falla_atendida_por">
    <select
        id="x_falla_atendida_por"
        name="x_falla_atendida_por"
        class="form-select ew-select<?= $Page->falla_atendida_por->isInvalidClass() ?>"
        <?php if (!$Page->falla_atendida_por->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoedit_x_falla_atendida_por"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_falla_atendida_por"
        data-value-separator="<?= $Page->falla_atendida_por->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->falla_atendida_por->getPlaceHolder()) ?>"
        <?= $Page->falla_atendida_por->editAttributes() ?>>
        <?= $Page->falla_atendida_por->selectOptionListHtml("x_falla_atendida_por") ?>
    </select>
    <?= $Page->falla_atendida_por->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->falla_atendida_por->getErrorMessage() ?></div>
<?= $Page->falla_atendida_por->Lookup->getParamTag($Page, "p_x_falla_atendida_por") ?>
<?php if (!$Page->falla_atendida_por->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoedit", function() {
    var options = { name: "x_falla_atendida_por", selectId: "fsco_mttotecnicoedit_x_falla_atendida_por" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoedit.lists.falla_atendida_por?.lookupOptions.length) {
        options.data = { id: "x_falla_atendida_por", form: "fsco_mttotecnicoedit" };
    } else {
        options.ajax = { id: "x_falla_atendida_por", form: "fsco_mttotecnicoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.falla_atendida_por.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
    <div id="r_diagnostico"<?= $Page->diagnostico->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_diagnostico" for="x_diagnostico" class="<?= $Page->LeftColumnClass ?>"><?= $Page->diagnostico->caption() ?><?= $Page->diagnostico->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->diagnostico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_diagnostico">
<textarea data-table="sco_mttotecnico" data-field="x_diagnostico" name="x_diagnostico" id="x_diagnostico" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->diagnostico->getPlaceHolder()) ?>"<?= $Page->diagnostico->editAttributes() ?> aria-describedby="x_diagnostico_help"><?= $Page->diagnostico->EditValue ?></textarea>
<?= $Page->diagnostico->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->diagnostico->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->solucion->Visible) { // solucion ?>
    <div id="r_solucion"<?= $Page->solucion->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_solucion" for="x_solucion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->solucion->caption() ?><?= $Page->solucion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->solucion->cellAttributes() ?>>
<span id="el_sco_mttotecnico_solucion">
<textarea data-table="sco_mttotecnico" data-field="x_solucion" name="x_solucion" id="x_solucion" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->solucion->getPlaceHolder()) ?>"<?= $Page->solucion->editAttributes() ?> aria-describedby="x_solucion_help"><?= $Page->solucion->EditValue ?></textarea>
<?= $Page->solucion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->solucion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->requiere_materiales->Visible) { // requiere_materiales ?>
    <div id="r_requiere_materiales"<?= $Page->requiere_materiales->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_requiere_materiales" for="x_requiere_materiales" class="<?= $Page->LeftColumnClass ?>"><?= $Page->requiere_materiales->caption() ?><?= $Page->requiere_materiales->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->requiere_materiales->cellAttributes() ?>>
<span id="el_sco_mttotecnico_requiere_materiales">
    <select
        id="x_requiere_materiales"
        name="x_requiere_materiales"
        class="form-select ew-select<?= $Page->requiere_materiales->isInvalidClass() ?>"
        <?php if (!$Page->requiere_materiales->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoedit_x_requiere_materiales"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_requiere_materiales"
        data-value-separator="<?= $Page->requiere_materiales->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->requiere_materiales->getPlaceHolder()) ?>"
        <?= $Page->requiere_materiales->editAttributes() ?>>
        <?= $Page->requiere_materiales->selectOptionListHtml("x_requiere_materiales") ?>
    </select>
    <?= $Page->requiere_materiales->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->requiere_materiales->getErrorMessage() ?></div>
<?php if (!$Page->requiere_materiales->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoedit", function() {
    var options = { name: "x_requiere_materiales", selectId: "fsco_mttotecnicoedit_x_requiere_materiales" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoedit.lists.requiere_materiales?.lookupOptions.length) {
        options.data = { id: "x_requiere_materiales", form: "fsco_mttotecnicoedit" };
    } else {
        options.ajax = { id: "x_requiere_materiales", form: "fsco_mttotecnicoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.requiere_materiales.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_solucion->Visible) { // fecha_solucion ?>
    <div id="r_fecha_solucion"<?= $Page->fecha_solucion->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_fecha_solucion" for="x_fecha_solucion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_solucion->caption() ?><?= $Page->fecha_solucion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_solucion->cellAttributes() ?>>
<span id="el_sco_mttotecnico_fecha_solucion">
<input type="<?= $Page->fecha_solucion->getInputTextType() ?>" name="x_fecha_solucion" id="x_fecha_solucion" data-table="sco_mttotecnico" data-field="x_fecha_solucion" value="<?= $Page->fecha_solucion->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_solucion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_solucion->formatPattern()) ?>"<?= $Page->fecha_solucion->editAttributes() ?> aria-describedby="x_fecha_solucion_help">
<?= $Page->fecha_solucion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_solucion->getErrorMessage() ?></div>
<?php if (!$Page->fecha_solucion->ReadOnly && !$Page->fecha_solucion->Disabled && !isset($Page->fecha_solucion->EditAttrs["readonly"]) && !isset($Page->fecha_solucion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_mttotecnicoedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
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
    ew.createDateTimePicker("fsco_mttotecnicoedit", "x_fecha_solucion", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_mttotecnico_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_mttotecnico_adjunto->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mttotecnico_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMttotecnicoAdjuntoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_mttotecnico_notas", explode(",", $Page->getCurrentDetailTable())) && $sco_mttotecnico_notas->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mttotecnico_notas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMttotecnicoNotasGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_mttotecnicoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_mttotecnicoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_mttotecnico");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
