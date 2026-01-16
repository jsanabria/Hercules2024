<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_mttotecnicoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnicoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo_solicitud", [fields.tipo_solicitud.visible && fields.tipo_solicitud.required ? ew.Validators.required(fields.tipo_solicitud.caption) : null], fields.tipo_solicitud.isInvalid],
            ["unidad_solicitante", [fields.unidad_solicitante.visible && fields.unidad_solicitante.required ? ew.Validators.required(fields.unidad_solicitante.caption) : null], fields.unidad_solicitante.isInvalid],
            ["area_falla", [fields.area_falla.visible && fields.area_falla.required ? ew.Validators.required(fields.area_falla.caption) : null], fields.area_falla.isInvalid],
            ["comentario", [fields.comentario.visible && fields.comentario.required ? ew.Validators.required(fields.comentario.caption) : null], fields.comentario.isInvalid],
            ["prioridad", [fields.prioridad.visible && fields.prioridad.required ? ew.Validators.required(fields.prioridad.caption) : null], fields.prioridad.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["falla_atendida_por", [fields.falla_atendida_por.visible && fields.falla_atendida_por.required ? ew.Validators.required(fields.falla_atendida_por.caption) : null], fields.falla_atendida_por.isInvalid],
            ["diagnostico", [fields.diagnostico.visible && fields.diagnostico.required ? ew.Validators.required(fields.diagnostico.caption) : null], fields.diagnostico.isInvalid],
            ["solucion", [fields.solucion.visible && fields.solucion.required ? ew.Validators.required(fields.solucion.caption) : null], fields.solucion.isInvalid],
            ["requiere_materiales", [fields.requiere_materiales.visible && fields.requiere_materiales.required ? ew.Validators.required(fields.requiere_materiales.caption) : null], fields.requiere_materiales.isInvalid]
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
            "tipo_solicitud": <?= $Page->tipo_solicitud->toClientList($Page) ?>,
            "unidad_solicitante": <?= $Page->unidad_solicitante->toClientList($Page) ?>,
            "area_falla": <?= $Page->area_falla->toClientList($Page) ?>,
            "prioridad": <?= $Page->prioridad->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_mttotecnicoadd" id="fsco_mttotecnicoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_mttotecnico">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo_solicitud->Visible) { // tipo_solicitud ?>
    <div id="r_tipo_solicitud"<?= $Page->tipo_solicitud->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_tipo_solicitud" for="x_tipo_solicitud" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_solicitud->caption() ?><?= $Page->tipo_solicitud->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_solicitud->cellAttributes() ?>>
<span id="el_sco_mttotecnico_tipo_solicitud">
    <select
        id="x_tipo_solicitud"
        name="x_tipo_solicitud"
        class="form-select ew-select<?= $Page->tipo_solicitud->isInvalidClass() ?>"
        <?php if (!$Page->tipo_solicitud->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoadd_x_tipo_solicitud"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_tipo_solicitud"
        data-value-separator="<?= $Page->tipo_solicitud->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_solicitud->getPlaceHolder()) ?>"
        <?= $Page->tipo_solicitud->editAttributes() ?>>
        <?= $Page->tipo_solicitud->selectOptionListHtml("x_tipo_solicitud") ?>
    </select>
    <?= $Page->tipo_solicitud->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_solicitud->getErrorMessage() ?></div>
<?= $Page->tipo_solicitud->Lookup->getParamTag($Page, "p_x_tipo_solicitud") ?>
<?php if (!$Page->tipo_solicitud->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_tipo_solicitud", selectId: "fsco_mttotecnicoadd_x_tipo_solicitud" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.tipo_solicitud?.lookupOptions.length) {
        options.data = { id: "x_tipo_solicitud", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_tipo_solicitud", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.tipo_solicitud.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
    <div id="r_unidad_solicitante"<?= $Page->unidad_solicitante->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_unidad_solicitante" for="x_unidad_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidad_solicitante->caption() ?><?= $Page->unidad_solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_mttotecnico_unidad_solicitante">
    <select
        id="x_unidad_solicitante"
        name="x_unidad_solicitante"
        class="form-select ew-select<?= $Page->unidad_solicitante->isInvalidClass() ?>"
        <?php if (!$Page->unidad_solicitante->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoadd_x_unidad_solicitante"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_unidad_solicitante"
        data-value-separator="<?= $Page->unidad_solicitante->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_solicitante->getPlaceHolder()) ?>"
        <?= $Page->unidad_solicitante->editAttributes() ?>>
        <?= $Page->unidad_solicitante->selectOptionListHtml("x_unidad_solicitante") ?>
    </select>
    <?= $Page->unidad_solicitante->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->unidad_solicitante->getErrorMessage() ?></div>
<?= $Page->unidad_solicitante->Lookup->getParamTag($Page, "p_x_unidad_solicitante") ?>
<?php if (!$Page->unidad_solicitante->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_unidad_solicitante", selectId: "fsco_mttotecnicoadd_x_unidad_solicitante" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.unidad_solicitante?.lookupOptions.length) {
        options.data = { id: "x_unidad_solicitante", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_unidad_solicitante", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.unidad_solicitante.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->area_falla->Visible) { // area_falla ?>
    <div id="r_area_falla"<?= $Page->area_falla->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_area_falla" for="x_area_falla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->area_falla->caption() ?><?= $Page->area_falla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->area_falla->cellAttributes() ?>>
<span id="el_sco_mttotecnico_area_falla">
    <select
        id="x_area_falla"
        name="x_area_falla"
        class="form-select ew-select<?= $Page->area_falla->isInvalidClass() ?>"
        <?php if (!$Page->area_falla->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoadd_x_area_falla"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_area_falla"
        data-value-separator="<?= $Page->area_falla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->area_falla->getPlaceHolder()) ?>"
        <?= $Page->area_falla->editAttributes() ?>>
        <?= $Page->area_falla->selectOptionListHtml("x_area_falla") ?>
    </select>
    <?= $Page->area_falla->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->area_falla->getErrorMessage() ?></div>
<?= $Page->area_falla->Lookup->getParamTag($Page, "p_x_area_falla") ?>
<?php if (!$Page->area_falla->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_area_falla", selectId: "fsco_mttotecnicoadd_x_area_falla" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.area_falla?.lookupOptions.length) {
        options.data = { id: "x_area_falla", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_area_falla", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.area_falla.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <div id="r_comentario"<?= $Page->comentario->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_comentario" for="x_comentario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comentario->caption() ?><?= $Page->comentario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->comentario->cellAttributes() ?>>
<span id="el_sco_mttotecnico_comentario">
<textarea data-table="sco_mttotecnico" data-field="x_comentario" name="x_comentario" id="x_comentario" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->comentario->getPlaceHolder()) ?>"<?= $Page->comentario->editAttributes() ?> aria-describedby="x_comentario_help"><?= $Page->comentario->EditValue ?></textarea>
<?= $Page->comentario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comentario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->prioridad->Visible) { // prioridad ?>
    <div id="r_prioridad"<?= $Page->prioridad->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_prioridad" for="x_prioridad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->prioridad->caption() ?><?= $Page->prioridad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->prioridad->cellAttributes() ?>>
<span id="el_sco_mttotecnico_prioridad">
    <select
        id="x_prioridad"
        name="x_prioridad"
        class="form-select ew-select<?= $Page->prioridad->isInvalidClass() ?>"
        <?php if (!$Page->prioridad->IsNativeSelect) { ?>
        data-select2-id="fsco_mttotecnicoadd_x_prioridad"
        <?php } ?>
        data-table="sco_mttotecnico"
        data-field="x_prioridad"
        data-value-separator="<?= $Page->prioridad->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->prioridad->getPlaceHolder()) ?>"
        <?= $Page->prioridad->editAttributes() ?>>
        <?= $Page->prioridad->selectOptionListHtml("x_prioridad") ?>
    </select>
    <?= $Page->prioridad->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->prioridad->getErrorMessage() ?></div>
<?php if (!$Page->prioridad->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_prioridad", selectId: "fsco_mttotecnicoadd_x_prioridad" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.prioridad?.lookupOptions.length) {
        options.data = { id: "x_prioridad", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_prioridad", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mttotecnico.fields.prioridad.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
        data-select2-id="fsco_mttotecnicoadd_x_estatus"
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
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_estatus", selectId: "fsco_mttotecnicoadd_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_mttotecnicoadd_x_falla_atendida_por"
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
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_falla_atendida_por", selectId: "fsco_mttotecnicoadd_x_falla_atendida_por" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.falla_atendida_por?.lookupOptions.length) {
        options.data = { id: "x_falla_atendida_por", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_falla_atendida_por", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_mttotecnicoadd_x_requiere_materiales"
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
loadjs.ready("fsco_mttotecnicoadd", function() {
    var options = { name: "x_requiere_materiales", selectId: "fsco_mttotecnicoadd_x_requiere_materiales" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mttotecnicoadd.lists.requiere_materiales?.lookupOptions.length) {
        options.data = { id: "x_requiere_materiales", form: "fsco_mttotecnicoadd" };
    } else {
        options.ajax = { id: "x_requiere_materiales", form: "fsco_mttotecnicoadd", limit: ew.LOOKUP_PAGE_SIZE };
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
</div><!-- /page* -->
<?php
    if (in_array("sco_mttotecnico_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_mttotecnico_adjunto->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mttotecnico_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMttotecnicoAdjuntoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_mttotecnico_notas", explode(",", $Page->getCurrentDetailTable())) && $sco_mttotecnico_notas->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mttotecnico_notas", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMttotecnicoNotasGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_mttotecnicoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_mttotecnicoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
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
