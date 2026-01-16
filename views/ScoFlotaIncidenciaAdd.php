<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaIncidenciaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_flota_incidenciaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flota_incidenciaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["fecha_registro", [fields.fecha_registro.visible && fields.fecha_registro.required ? ew.Validators.required(fields.fecha_registro.caption) : null, ew.Validators.datetime(fields.fecha_registro.clientFormatPattern)], fields.fecha_registro.isInvalid],
            ["flota", [fields.flota.visible && fields.flota.required ? ew.Validators.required(fields.flota.caption) : null, ew.Validators.integer], fields.flota.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["falla", [fields.falla.visible && fields.falla.required ? ew.Validators.required(fields.falla.caption) : null], fields.falla.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["solicitante", [fields.solicitante.visible && fields.solicitante.required ? ew.Validators.required(fields.solicitante.caption) : null], fields.solicitante.isInvalid],
            ["diagnostico", [fields.diagnostico.visible && fields.diagnostico.required ? ew.Validators.required(fields.diagnostico.caption) : null], fields.diagnostico.isInvalid],
            ["reparacion", [fields.reparacion.visible && fields.reparacion.required ? ew.Validators.required(fields.reparacion.caption) : null], fields.reparacion.isInvalid],
            ["cambio_aceite", [fields.cambio_aceite.visible && fields.cambio_aceite.required ? ew.Validators.required(fields.cambio_aceite.caption) : null], fields.cambio_aceite.isInvalid],
            ["kilometraje", [fields.kilometraje.visible && fields.kilometraje.required ? ew.Validators.required(fields.kilometraje.caption) : null, ew.Validators.integer], fields.kilometraje.isInvalid],
            ["proveedor", [fields.proveedor.visible && fields.proveedor.required ? ew.Validators.required(fields.proveedor.caption) : null], fields.proveedor.isInvalid],
            ["fecha_reparacion", [fields.fecha_reparacion.visible && fields.fecha_reparacion.required ? ew.Validators.required(fields.fecha_reparacion.caption) : null, ew.Validators.datetime(fields.fecha_reparacion.clientFormatPattern)], fields.fecha_reparacion.isInvalid]
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
            "flota": <?= $Page->flota->toClientList($Page) ?>,
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "falla": <?= $Page->falla->toClientList($Page) ?>,
            "reparacion": <?= $Page->reparacion->toClientList($Page) ?>,
            "cambio_aceite": <?= $Page->cambio_aceite->toClientList($Page) ?>,
            "proveedor": <?= $Page->proveedor->toClientList($Page) ?>,
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
<form name="fsco_flota_incidenciaadd" id="fsco_flota_incidenciaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_flota_incidencia">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <div id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_fecha_registro" for="x_fecha_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_registro->caption() ?><?= $Page->fecha_registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_fecha_registro">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="x_fecha_registro" id="x_fecha_registro" data-table="sco_flota_incidencia" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?> aria-describedby="x_fecha_registro_help">
<?= $Page->fecha_registro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage() ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_flota_incidenciaadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_flota_incidenciaadd", "x_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->flota->Visible) { // flota ?>
    <div id="r_flota"<?= $Page->flota->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_flota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->flota->caption() ?><?= $Page->flota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->flota->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_flota">
    <select
        id="x_flota"
        name="x_flota"
        class="form-control ew-select<?= $Page->flota->isInvalidClass() ?>"
        data-select2-id="fsco_flota_incidenciaadd_x_flota"
        data-table="sco_flota_incidencia"
        data-field="x_flota"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->flota->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->flota->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->flota->getPlaceHolder()) ?>"
        <?= $Page->flota->editAttributes() ?>>
        <?= $Page->flota->selectOptionListHtml("x_flota") ?>
    </select>
    <?= $Page->flota->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->flota->getErrorMessage() ?></div>
<?= $Page->flota->Lookup->getParamTag($Page, "p_x_flota") ?>
<script>
loadjs.ready("fsco_flota_incidenciaadd", function() {
    var options = { name: "x_flota", selectId: "fsco_flota_incidenciaadd_x_flota" };
    if (fsco_flota_incidenciaadd.lists.flota?.lookupOptions.length) {
        options.data = { id: "x_flota", form: "fsco_flota_incidenciaadd" };
    } else {
        options.ajax = { id: "x_flota", form: "fsco_flota_incidenciaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_flota_incidencia.fields.flota.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciaadd_x_tipo"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciaadd", function() {
    var options = { name: "x_tipo", selectId: "fsco_flota_incidenciaadd_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciaadd.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_flota_incidenciaadd" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_flota_incidenciaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->falla->Visible) { // falla ?>
    <div id="r_falla"<?= $Page->falla->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_falla" for="x_falla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->falla->caption() ?><?= $Page->falla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->falla->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_falla">
    <select
        id="x_falla"
        name="x_falla"
        class="form-select ew-select<?= $Page->falla->isInvalidClass() ?>"
        <?php if (!$Page->falla->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciaadd_x_falla"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_falla"
        data-value-separator="<?= $Page->falla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->falla->getPlaceHolder()) ?>"
        <?= $Page->falla->editAttributes() ?>>
        <?= $Page->falla->selectOptionListHtml("x_falla") ?>
    </select>
    <?= $Page->falla->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->falla->getErrorMessage() ?></div>
<?= $Page->falla->Lookup->getParamTag($Page, "p_x_falla") ?>
<?php if (!$Page->falla->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciaadd", function() {
    var options = { name: "x_falla", selectId: "fsco_flota_incidenciaadd_x_falla" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciaadd.lists.falla?.lookupOptions.length) {
        options.data = { id: "x_falla", form: "fsco_flota_incidenciaadd" };
    } else {
        options.ajax = { id: "x_falla", form: "fsco_flota_incidenciaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.falla.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_nota">
<textarea data-table="sco_flota_incidencia" data-field="x_nota" name="x_nota" id="x_nota" cols="36" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <div id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_solicitante" for="x_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->solicitante->caption() ?><?= $Page->solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_solicitante">
<input type="<?= $Page->solicitante->getInputTextType() ?>" name="x_solicitante" id="x_solicitante" data-table="sco_flota_incidencia" data-field="x_solicitante" value="<?= $Page->solicitante->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->solicitante->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->solicitante->formatPattern()) ?>"<?= $Page->solicitante->editAttributes() ?> aria-describedby="x_solicitante_help">
<?= $Page->solicitante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->solicitante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->diagnostico->Visible) { // diagnostico ?>
    <div id="r_diagnostico"<?= $Page->diagnostico->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_diagnostico" for="x_diagnostico" class="<?= $Page->LeftColumnClass ?>"><?= $Page->diagnostico->caption() ?><?= $Page->diagnostico->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->diagnostico->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_diagnostico">
<textarea data-table="sco_flota_incidencia" data-field="x_diagnostico" name="x_diagnostico" id="x_diagnostico" cols="36" rows="3" placeholder="<?= HtmlEncode($Page->diagnostico->getPlaceHolder()) ?>"<?= $Page->diagnostico->editAttributes() ?> aria-describedby="x_diagnostico_help"><?= $Page->diagnostico->EditValue ?></textarea>
<?= $Page->diagnostico->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->diagnostico->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->reparacion->Visible) { // reparacion ?>
    <div id="r_reparacion"<?= $Page->reparacion->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_reparacion" for="x_reparacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->reparacion->caption() ?><?= $Page->reparacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->reparacion->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_reparacion">
    <select
        id="x_reparacion"
        name="x_reparacion"
        class="form-select ew-select<?= $Page->reparacion->isInvalidClass() ?>"
        <?php if (!$Page->reparacion->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciaadd_x_reparacion"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_reparacion"
        data-value-separator="<?= $Page->reparacion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reparacion->getPlaceHolder()) ?>"
        <?= $Page->reparacion->editAttributes() ?>>
        <?= $Page->reparacion->selectOptionListHtml("x_reparacion") ?>
    </select>
    <?= $Page->reparacion->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->reparacion->getErrorMessage() ?></div>
<?= $Page->reparacion->Lookup->getParamTag($Page, "p_x_reparacion") ?>
<?php if (!$Page->reparacion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciaadd", function() {
    var options = { name: "x_reparacion", selectId: "fsco_flota_incidenciaadd_x_reparacion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciaadd.lists.reparacion?.lookupOptions.length) {
        options.data = { id: "x_reparacion", form: "fsco_flota_incidenciaadd" };
    } else {
        options.ajax = { id: "x_reparacion", form: "fsco_flota_incidenciaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.reparacion.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cambio_aceite->Visible) { // cambio_aceite ?>
    <div id="r_cambio_aceite"<?= $Page->cambio_aceite->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_cambio_aceite" for="x_cambio_aceite" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cambio_aceite->caption() ?><?= $Page->cambio_aceite->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cambio_aceite->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_cambio_aceite">
    <select
        id="x_cambio_aceite"
        name="x_cambio_aceite"
        class="form-select ew-select<?= $Page->cambio_aceite->isInvalidClass() ?>"
        <?php if (!$Page->cambio_aceite->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciaadd_x_cambio_aceite"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_cambio_aceite"
        data-value-separator="<?= $Page->cambio_aceite->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cambio_aceite->getPlaceHolder()) ?>"
        <?= $Page->cambio_aceite->editAttributes() ?>>
        <?= $Page->cambio_aceite->selectOptionListHtml("x_cambio_aceite") ?>
    </select>
    <?= $Page->cambio_aceite->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cambio_aceite->getErrorMessage() ?></div>
<?php if (!$Page->cambio_aceite->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciaadd", function() {
    var options = { name: "x_cambio_aceite", selectId: "fsco_flota_incidenciaadd_x_cambio_aceite" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciaadd.lists.cambio_aceite?.lookupOptions.length) {
        options.data = { id: "x_cambio_aceite", form: "fsco_flota_incidenciaadd" };
    } else {
        options.ajax = { id: "x_cambio_aceite", form: "fsco_flota_incidenciaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.cambio_aceite.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kilometraje->Visible) { // kilometraje ?>
    <div id="r_kilometraje"<?= $Page->kilometraje->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_kilometraje" for="x_kilometraje" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kilometraje->caption() ?><?= $Page->kilometraje->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->kilometraje->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_kilometraje">
<input type="<?= $Page->kilometraje->getInputTextType() ?>" name="x_kilometraje" id="x_kilometraje" data-table="sco_flota_incidencia" data-field="x_kilometraje" value="<?= $Page->kilometraje->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->kilometraje->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->kilometraje->formatPattern()) ?>"<?= $Page->kilometraje->editAttributes() ?> aria-describedby="x_kilometraje_help">
<?= $Page->kilometraje->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kilometraje->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <div id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_proveedor" for="x_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proveedor->caption() ?><?= $Page->proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_proveedor">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-select ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        <?php if (!$Page->proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidenciaadd_x_proveedor"
        <?php } ?>
        data-table="sco_flota_incidencia"
        data-field="x_proveedor"
        data-value-separator="<?= $Page->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->proveedor->getPlaceHolder()) ?>"
        <?= $Page->proveedor->editAttributes() ?>>
        <?= $Page->proveedor->selectOptionListHtml("x_proveedor") ?>
    </select>
    <?= $Page->proveedor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->proveedor->getErrorMessage() ?></div>
<?= $Page->proveedor->Lookup->getParamTag($Page, "p_x_proveedor") ?>
<?php if (!$Page->proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidenciaadd", function() {
    var options = { name: "x_proveedor", selectId: "fsco_flota_incidenciaadd_x_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidenciaadd.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fsco_flota_incidenciaadd" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fsco_flota_incidenciaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia.fields.proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_reparacion->Visible) { // fecha_reparacion ?>
    <div id="r_fecha_reparacion"<?= $Page->fecha_reparacion->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_fecha_reparacion" for="x_fecha_reparacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_reparacion->caption() ?><?= $Page->fecha_reparacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_reparacion->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_fecha_reparacion">
<input type="<?= $Page->fecha_reparacion->getInputTextType() ?>" name="x_fecha_reparacion" id="x_fecha_reparacion" data-table="sco_flota_incidencia" data-field="x_fecha_reparacion" value="<?= $Page->fecha_reparacion->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_reparacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_reparacion->formatPattern()) ?>"<?= $Page->fecha_reparacion->editAttributes() ?> aria-describedby="x_fecha_reparacion_help">
<?= $Page->fecha_reparacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_reparacion->getErrorMessage() ?></div>
<?php if (!$Page->fecha_reparacion->ReadOnly && !$Page->fecha_reparacion->Disabled && !isset($Page->fecha_reparacion->EditAttrs["readonly"]) && !isset($Page->fecha_reparacion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_flota_incidenciaadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_flota_incidenciaadd", "x_fecha_reparacion", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_flota_incidencia_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_flota_incidencia_detalle->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_flota_incidencia_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoFlotaIncidenciaDetalleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_flota_incidenciaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_flota_incidenciaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_flota_incidencia");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    //$("#x_fecha_registro").mask("99/99/9999");
    //$("#x_fecha_reparacion").mask("99/99/9999");

    /*$("#x_falla").hide();
    $("#x_reparacion").hide();
    $("#x_monto").hide();
    $("#x_fecha_reparacion").hide();
    $(document).ready(function(){
    	$("#x_tipo").bind("change", function() {
    		if($("#x_tipo").val() == "FALLA") {
    			$("#x_falla").show();
    			$("#x_reparacion").hide();
    			$("#x_reparacion").val("");
    			$("#x_monto").hide();
    			$("#x_monto").val("");
    			$("#x_fecha_reparacion").hide();
    			$("#x_fecha_reparacion").val("");
    		}
    		else if($("#x_tipo").val() == "REPARACION") {
    			$("#x_falla").hide();
    			$("#x_falla").val("");
    			$("#x_reparacion").show();
    			$("#x_monto").show();
    			$("#x_monto").val("");
    			$("#x_fecha_reparacion").show();
    			$("#x_fecha_reparacion").val(date("d/m/Y"));
    		}
    		else {
    			$("#x_falla").hide();
    			$("#x_reparacion").hide();
    			$("#x_falla").val("");
    			$("#x_reparacion").val("");
    			$("#x_monto").hide();
    			$("#x_monto").val("");
    			$("#x_fecha_reparacion").hide();
    			$("#x_fecha_reparacion").val("");
    		}
    	})
    })*/
});
</script>
