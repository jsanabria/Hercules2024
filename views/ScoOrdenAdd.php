<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_ordenadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_ordenadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["expediente", [fields.expediente.visible && fields.expediente.required ? ew.Validators.required(fields.expediente.caption) : null, ew.Validators.integer], fields.expediente.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["proveedor", [fields.proveedor.visible && fields.proveedor.required ? ew.Validators.required(fields.proveedor.caption) : null], fields.proveedor.isInvalid],
            ["responsable_servicio", [fields.responsable_servicio.visible && fields.responsable_servicio.required ? ew.Validators.required(fields.responsable_servicio.caption) : null], fields.responsable_servicio.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["fecha_inicio", [fields.fecha_inicio.visible && fields.fecha_inicio.required ? ew.Validators.required(fields.fecha_inicio.caption) : null, ew.Validators.datetime(fields.fecha_inicio.clientFormatPattern)], fields.fecha_inicio.isInvalid],
            ["hora_inicio", [fields.hora_inicio.visible && fields.hora_inicio.required ? ew.Validators.required(fields.hora_inicio.caption) : null, ew.Validators.time(fields.hora_inicio.clientFormatPattern)], fields.hora_inicio.isInvalid],
            ["horas", [fields.horas.visible && fields.horas.required ? ew.Validators.required(fields.horas.caption) : null, ew.Validators.float], fields.horas.isInvalid],
            ["fecha_fin", [fields.fecha_fin.visible && fields.fecha_fin.required ? ew.Validators.required(fields.fecha_fin.caption) : null, ew.Validators.datetime(fields.fecha_fin.clientFormatPattern)], fields.fecha_fin.isInvalid],
            ["hora_fin", [fields.hora_fin.visible && fields.hora_fin.required ? ew.Validators.required(fields.hora_fin.caption) : null, ew.Validators.time(fields.hora_fin.clientFormatPattern)], fields.hora_fin.isInvalid],
            ["capilla", [fields.capilla.visible && fields.capilla.required ? ew.Validators.required(fields.capilla.caption) : null, ew.Validators.integer], fields.capilla.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null, ew.Validators.integer], fields.cantidad.isInvalid],
            ["costo", [fields.costo.visible && fields.costo.required ? ew.Validators.required(fields.costo.caption) : null, ew.Validators.float], fields.costo.isInvalid],
            ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.float], fields.total.isInvalid],
            ["referencia_ubicacion", [fields.referencia_ubicacion.visible && fields.referencia_ubicacion.required ? ew.Validators.required(fields.referencia_ubicacion.caption) : null], fields.referencia_ubicacion.isInvalid],
            ["anulada", [fields.anulada.visible && fields.anulada.required ? ew.Validators.required(fields.anulada.caption) : null], fields.anulada.isInvalid],
            ["user_registra", [fields.user_registra.visible && fields.user_registra.required ? ew.Validators.required(fields.user_registra.caption) : null], fields.user_registra.isInvalid],
            ["fecha_registro", [fields.fecha_registro.visible && fields.fecha_registro.required ? ew.Validators.required(fields.fecha_registro.caption) : null, ew.Validators.datetime(fields.fecha_registro.clientFormatPattern)], fields.fecha_registro.isInvalid],
            ["media_hora", [fields.media_hora.visible && fields.media_hora.required ? ew.Validators.required(fields.media_hora.caption) : null], fields.media_hora.isInvalid],
            ["espera_cenizas", [fields.espera_cenizas.visible && fields.espera_cenizas.required ? ew.Validators.required(fields.espera_cenizas.caption) : null], fields.espera_cenizas.isInvalid],
            ["adjunto", [fields.adjunto.visible && fields.adjunto.required ? ew.Validators.required(fields.adjunto.caption) : null, ew.Validators.integer], fields.adjunto.isInvalid],
            ["llevar_a", [fields.llevar_a.visible && fields.llevar_a.required ? ew.Validators.required(fields.llevar_a.caption) : null], fields.llevar_a.isInvalid],
            ["servicio_atendido", [fields.servicio_atendido.visible && fields.servicio_atendido.required ? ew.Validators.required(fields.servicio_atendido.caption) : null], fields.servicio_atendido.isInvalid]
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
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
            "proveedor": <?= $Page->proveedor->toClientList($Page) ?>,
            "anulada": <?= $Page->anulada->toClientList($Page) ?>,
            "user_registra": <?= $Page->user_registra->toClientList($Page) ?>,
            "espera_cenizas": <?= $Page->espera_cenizas->toClientList($Page) ?>,
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
<form name="fsco_ordenadd" id="fsco_ordenadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_expediente") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_expediente">
<input type="hidden" name="fk_Nexpediente" value="<?= HtmlEncode($Page->expediente->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->expediente->Visible) { // expediente ?>
    <div id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <label id="elh_sco_orden_expediente" for="x_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expediente->caption() ?><?= $Page->expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expediente->cellAttributes() ?>>
<?php if ($Page->expediente->getSessionValue() != "") { ?>
<span id="el_sco_orden_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?php if (!EmptyString($Page->expediente->ViewValue) && $Page->expediente->linkAttributes() != "") { ?>
<a<?= $Page->expediente->linkAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expediente->getDisplayValue($Page->expediente->ViewValue))) ?>"></a>
<?php } else { ?>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expediente->getDisplayValue($Page->expediente->ViewValue))) ?>">
<?php } ?>
</span>
<input type="hidden" id="x_expediente" name="x_expediente" value="<?= HtmlEncode($Page->expediente->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_sco_orden_expediente">
<input type="<?= $Page->expediente->getInputTextType() ?>" name="x_expediente" id="x_expediente" data-table="sco_orden" data-field="x_expediente" value="<?= $Page->expediente->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->expediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->expediente->formatPattern()) ?>"<?= $Page->expediente->editAttributes() ?> aria-describedby="x_expediente_help">
<?= $Page->expediente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expediente->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <div id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <label id="elh_sco_orden_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_orden_servicio_tipo">
    <select
        id="x_servicio_tipo"
        name="x_servicio_tipo"
        class="form-select ew-select<?= $Page->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_ordenadd_x_servicio_tipo"
        <?php } ?>
        data-table="sco_orden"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Page->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_tipo->getPlaceHolder()) ?>"
        <?= $Page->servicio_tipo->editAttributes() ?>>
        <?= $Page->servicio_tipo->selectOptionListHtml("x_servicio_tipo") ?>
    </select>
    <?= $Page->servicio_tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio_tipo->getErrorMessage() ?></div>
<?= $Page->servicio_tipo->Lookup->getParamTag($Page, "p_x_servicio_tipo") ?>
<?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ordenadd", function() {
    var options = { name: "x_servicio_tipo", selectId: "fsco_ordenadd_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordenadd.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fsco_ordenadd" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fsco_ordenadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <div id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <label id="elh_sco_orden_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_orden_servicio">
    <select
        id="x_servicio"
        name="x_servicio"
        class="form-select ew-select<?= $Page->servicio->isInvalidClass() ?>"
        <?php if (!$Page->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_ordenadd_x_servicio"
        <?php } ?>
        data-table="sco_orden"
        data-field="x_servicio"
        data-value-separator="<?= $Page->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->servicio->editAttributes() ?>>
        <?= $Page->servicio->selectOptionListHtml("x_servicio") ?>
    </select>
    <?= $Page->servicio->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio->getErrorMessage() ?></div>
<?= $Page->servicio->Lookup->getParamTag($Page, "p_x_servicio") ?>
<?php if (!$Page->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ordenadd", function() {
    var options = { name: "x_servicio", selectId: "fsco_ordenadd_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordenadd.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fsco_ordenadd" };
    } else {
        options.ajax = { id: "x_servicio", form: "fsco_ordenadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <div id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <label id="elh_sco_orden_proveedor" for="x_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proveedor->caption() ?><?= $Page->proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_orden_proveedor">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-select ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        <?php if (!$Page->proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_ordenadd_x_proveedor"
        <?php } ?>
        data-table="sco_orden"
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
loadjs.ready("fsco_ordenadd", function() {
    var options = { name: "x_proveedor", selectId: "fsco_ordenadd_x_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordenadd.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fsco_ordenadd" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fsco_ordenadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->responsable_servicio->Visible) { // responsable_servicio ?>
    <div id="r_responsable_servicio"<?= $Page->responsable_servicio->rowAttributes() ?>>
        <label id="elh_sco_orden_responsable_servicio" for="x_responsable_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->responsable_servicio->caption() ?><?= $Page->responsable_servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->responsable_servicio->cellAttributes() ?>>
<span id="el_sco_orden_responsable_servicio">
<input type="<?= $Page->responsable_servicio->getInputTextType() ?>" name="x_responsable_servicio" id="x_responsable_servicio" data-table="sco_orden" data-field="x_responsable_servicio" value="<?= $Page->responsable_servicio->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->responsable_servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->responsable_servicio->formatPattern()) ?>"<?= $Page->responsable_servicio->editAttributes() ?> aria-describedby="x_responsable_servicio_help">
<?= $Page->responsable_servicio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->responsable_servicio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_orden_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_orden_nota">
<input type="<?= $Page->nota->getInputTextType() ?>" name="x_nota" id="x_nota" data-table="sco_orden" data-field="x_nota" value="<?= $Page->nota->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nota->formatPattern()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help">
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
    <div id="r_fecha_inicio"<?= $Page->fecha_inicio->rowAttributes() ?>>
        <label id="elh_sco_orden_fecha_inicio" for="x_fecha_inicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_inicio->caption() ?><?= $Page->fecha_inicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_inicio->cellAttributes() ?>>
<span id="el_sco_orden_fecha_inicio">
<input type="<?= $Page->fecha_inicio->getInputTextType() ?>" name="x_fecha_inicio" id="x_fecha_inicio" data-table="sco_orden" data-field="x_fecha_inicio" value="<?= $Page->fecha_inicio->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_inicio->formatPattern()) ?>"<?= $Page->fecha_inicio->editAttributes() ?> aria-describedby="x_fecha_inicio_help">
<?= $Page->fecha_inicio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_inicio->getErrorMessage() ?></div>
<?php if (!$Page->fecha_inicio->ReadOnly && !$Page->fecha_inicio->Disabled && !isset($Page->fecha_inicio->EditAttrs["readonly"]) && !isset($Page->fecha_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_ordenadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_ordenadd", "x_fecha_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
    <div id="r_hora_inicio"<?= $Page->hora_inicio->rowAttributes() ?>>
        <label id="elh_sco_orden_hora_inicio" for="x_hora_inicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_inicio->caption() ?><?= $Page->hora_inicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_inicio->cellAttributes() ?>>
<span id="el_sco_orden_hora_inicio">
<input type="<?= $Page->hora_inicio->getInputTextType() ?>" name="x_hora_inicio" id="x_hora_inicio" data-table="sco_orden" data-field="x_hora_inicio" value="<?= $Page->hora_inicio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->hora_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora_inicio->formatPattern()) ?>"<?= $Page->hora_inicio->editAttributes() ?> aria-describedby="x_hora_inicio_help">
<?= $Page->hora_inicio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora_inicio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
    <div id="r_horas"<?= $Page->horas->rowAttributes() ?>>
        <label id="elh_sco_orden_horas" for="x_horas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->horas->caption() ?><?= $Page->horas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->horas->cellAttributes() ?>>
<span id="el_sco_orden_horas">
<input type="<?= $Page->horas->getInputTextType() ?>" name="x_horas" id="x_horas" data-table="sco_orden" data-field="x_horas" value="<?= $Page->horas->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->horas->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->horas->formatPattern()) ?>"<?= $Page->horas->editAttributes() ?> aria-describedby="x_horas_help">
<?= $Page->horas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->horas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
    <div id="r_fecha_fin"<?= $Page->fecha_fin->rowAttributes() ?>>
        <label id="elh_sco_orden_fecha_fin" for="x_fecha_fin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_fin->caption() ?><?= $Page->fecha_fin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_fin->cellAttributes() ?>>
<span id="el_sco_orden_fecha_fin">
<input type="<?= $Page->fecha_fin->getInputTextType() ?>" name="x_fecha_fin" id="x_fecha_fin" data-table="sco_orden" data-field="x_fecha_fin" value="<?= $Page->fecha_fin->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_fin->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_fin->formatPattern()) ?>"<?= $Page->fecha_fin->editAttributes() ?> aria-describedby="x_fecha_fin_help">
<?= $Page->fecha_fin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_fin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
    <div id="r_hora_fin"<?= $Page->hora_fin->rowAttributes() ?>>
        <label id="elh_sco_orden_hora_fin" for="x_hora_fin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_fin->caption() ?><?= $Page->hora_fin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_fin->cellAttributes() ?>>
<span id="el_sco_orden_hora_fin">
<input type="<?= $Page->hora_fin->getInputTextType() ?>" name="x_hora_fin" id="x_hora_fin" data-table="sco_orden" data-field="x_hora_fin" value="<?= $Page->hora_fin->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->hora_fin->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora_fin->formatPattern()) ?>"<?= $Page->hora_fin->editAttributes() ?> aria-describedby="x_hora_fin_help">
<?= $Page->hora_fin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora_fin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
    <div id="r_capilla"<?= $Page->capilla->rowAttributes() ?>>
        <label id="elh_sco_orden_capilla" for="x_capilla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->capilla->caption() ?><?= $Page->capilla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->capilla->cellAttributes() ?>>
<span id="el_sco_orden_capilla">
<input type="<?= $Page->capilla->getInputTextType() ?>" name="x_capilla" id="x_capilla" data-table="sco_orden" data-field="x_capilla" value="<?= $Page->capilla->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->capilla->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->capilla->formatPattern()) ?>"<?= $Page->capilla->editAttributes() ?> aria-describedby="x_capilla_help">
<?= $Page->capilla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->capilla->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <div id="r_cantidad"<?= $Page->cantidad->rowAttributes() ?>>
        <label id="elh_sco_orden_cantidad" for="x_cantidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cantidad->caption() ?><?= $Page->cantidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cantidad->cellAttributes() ?>>
<span id="el_sco_orden_cantidad">
<input type="<?= $Page->cantidad->getInputTextType() ?>" name="x_cantidad" id="x_cantidad" data-table="sco_orden" data-field="x_cantidad" value="<?= $Page->cantidad->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad->formatPattern()) ?>"<?= $Page->cantidad->editAttributes() ?> aria-describedby="x_cantidad_help">
<?= $Page->cantidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cantidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <div id="r_costo"<?= $Page->costo->rowAttributes() ?>>
        <label id="elh_sco_orden_costo" for="x_costo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costo->caption() ?><?= $Page->costo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costo->cellAttributes() ?>>
<span id="el_sco_orden_costo">
<input type="<?= $Page->costo->getInputTextType() ?>" name="x_costo" id="x_costo" data-table="sco_orden" data-field="x_costo" value="<?= $Page->costo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->costo->formatPattern()) ?>"<?= $Page->costo->editAttributes() ?> aria-describedby="x_costo_help">
<?= $Page->costo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->costo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total"<?= $Page->total->rowAttributes() ?>>
        <label id="elh_sco_orden_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total->cellAttributes() ?>>
<span id="el_sco_orden_total">
<input type="<?= $Page->total->getInputTextType() ?>" name="x_total" id="x_total" data-table="sco_orden" data-field="x_total" value="<?= $Page->total->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->total->formatPattern()) ?>"<?= $Page->total->editAttributes() ?> aria-describedby="x_total_help">
<?= $Page->total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->referencia_ubicacion->Visible) { // referencia_ubicacion ?>
    <div id="r_referencia_ubicacion"<?= $Page->referencia_ubicacion->rowAttributes() ?>>
        <label id="elh_sco_orden_referencia_ubicacion" for="x_referencia_ubicacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->referencia_ubicacion->caption() ?><?= $Page->referencia_ubicacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->referencia_ubicacion->cellAttributes() ?>>
<span id="el_sco_orden_referencia_ubicacion">
<input type="<?= $Page->referencia_ubicacion->getInputTextType() ?>" name="x_referencia_ubicacion" id="x_referencia_ubicacion" data-table="sco_orden" data-field="x_referencia_ubicacion" value="<?= $Page->referencia_ubicacion->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->referencia_ubicacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->referencia_ubicacion->formatPattern()) ?>"<?= $Page->referencia_ubicacion->editAttributes() ?> aria-describedby="x_referencia_ubicacion_help">
<?= $Page->referencia_ubicacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->referencia_ubicacion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->anulada->Visible) { // anulada ?>
    <div id="r_anulada"<?= $Page->anulada->rowAttributes() ?>>
        <label id="elh_sco_orden_anulada" for="x_anulada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anulada->caption() ?><?= $Page->anulada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anulada->cellAttributes() ?>>
<span id="el_sco_orden_anulada">
    <select
        id="x_anulada"
        name="x_anulada"
        class="form-select ew-select<?= $Page->anulada->isInvalidClass() ?>"
        <?php if (!$Page->anulada->IsNativeSelect) { ?>
        data-select2-id="fsco_ordenadd_x_anulada"
        <?php } ?>
        data-table="sco_orden"
        data-field="x_anulada"
        data-value-separator="<?= $Page->anulada->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->anulada->getPlaceHolder()) ?>"
        <?= $Page->anulada->editAttributes() ?>>
        <?= $Page->anulada->selectOptionListHtml("x_anulada") ?>
    </select>
    <?= $Page->anulada->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->anulada->getErrorMessage() ?></div>
<?php if (!$Page->anulada->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ordenadd", function() {
    var options = { name: "x_anulada", selectId: "fsco_ordenadd_x_anulada" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordenadd.lists.anulada?.lookupOptions.length) {
        options.data = { id: "x_anulada", form: "fsco_ordenadd" };
    } else {
        options.ajax = { id: "x_anulada", form: "fsco_ordenadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.anulada.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <div id="r_user_registra"<?= $Page->user_registra->rowAttributes() ?>>
        <label id="elh_sco_orden_user_registra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_registra->caption() ?><?= $Page->user_registra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_registra->cellAttributes() ?>>
<span id="el_sco_orden_user_registra">
<?php
if (IsRTL()) {
    $Page->user_registra->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_user_registra" class="ew-auto-suggest">
    <input type="<?= $Page->user_registra->getInputTextType() ?>" class="form-control" name="sv_x_user_registra" id="sv_x_user_registra" value="<?= RemoveHtml($Page->user_registra->EditValue) ?>" autocomplete="off" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_registra->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->user_registra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->user_registra->formatPattern()) ?>"<?= $Page->user_registra->editAttributes() ?> aria-describedby="x_user_registra_help">
</span>
<selection-list hidden class="form-control" data-table="sco_orden" data-field="x_user_registra" data-input="sv_x_user_registra" data-value-separator="<?= $Page->user_registra->displayValueSeparatorAttribute() ?>" name="x_user_registra" id="x_user_registra" value="<?= HtmlEncode($Page->user_registra->CurrentValue) ?>"></selection-list>
<?= $Page->user_registra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_registra->getErrorMessage() ?></div>
<script>
loadjs.ready("fsco_ordenadd", function() {
    fsco_ordenadd.createAutoSuggest(Object.assign({"id":"x_user_registra","forceSelect":false}, { lookupAllDisplayFields: <?= $Page->user_registra->Lookup->LookupAllDisplayFields ? "true" : "false" ?> }, ew.vars.tables.sco_orden.fields.user_registra.autoSuggestOptions));
});
</script>
<?= $Page->user_registra->Lookup->getParamTag($Page, "p_x_user_registra") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <div id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <label id="elh_sco_orden_fecha_registro" for="x_fecha_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_registro->caption() ?><?= $Page->fecha_registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_orden_fecha_registro">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="x_fecha_registro" id="x_fecha_registro" data-table="sco_orden" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?> aria-describedby="x_fecha_registro_help">
<?= $Page->fecha_registro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->media_hora->Visible) { // media_hora ?>
    <div id="r_media_hora"<?= $Page->media_hora->rowAttributes() ?>>
        <label id="elh_sco_orden_media_hora" for="x_media_hora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->media_hora->caption() ?><?= $Page->media_hora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->media_hora->cellAttributes() ?>>
<span id="el_sco_orden_media_hora">
<input type="<?= $Page->media_hora->getInputTextType() ?>" name="x_media_hora" id="x_media_hora" data-table="sco_orden" data-field="x_media_hora" value="<?= $Page->media_hora->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->media_hora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->media_hora->formatPattern()) ?>"<?= $Page->media_hora->editAttributes() ?> aria-describedby="x_media_hora_help">
<?= $Page->media_hora->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->media_hora->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->espera_cenizas->Visible) { // espera_cenizas ?>
    <div id="r_espera_cenizas"<?= $Page->espera_cenizas->rowAttributes() ?>>
        <label id="elh_sco_orden_espera_cenizas" for="x_espera_cenizas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->espera_cenizas->caption() ?><?= $Page->espera_cenizas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->espera_cenizas->cellAttributes() ?>>
<span id="el_sco_orden_espera_cenizas">
    <select
        id="x_espera_cenizas"
        name="x_espera_cenizas"
        class="form-select ew-select<?= $Page->espera_cenizas->isInvalidClass() ?>"
        <?php if (!$Page->espera_cenizas->IsNativeSelect) { ?>
        data-select2-id="fsco_ordenadd_x_espera_cenizas"
        <?php } ?>
        data-table="sco_orden"
        data-field="x_espera_cenizas"
        data-value-separator="<?= $Page->espera_cenizas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->espera_cenizas->getPlaceHolder()) ?>"
        <?= $Page->espera_cenizas->editAttributes() ?>>
        <?= $Page->espera_cenizas->selectOptionListHtml("x_espera_cenizas") ?>
    </select>
    <?= $Page->espera_cenizas->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->espera_cenizas->getErrorMessage() ?></div>
<?php if (!$Page->espera_cenizas->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_ordenadd", function() {
    var options = { name: "x_espera_cenizas", selectId: "fsco_ordenadd_x_espera_cenizas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_ordenadd.lists.espera_cenizas?.lookupOptions.length) {
        options.data = { id: "x_espera_cenizas", form: "fsco_ordenadd" };
    } else {
        options.ajax = { id: "x_espera_cenizas", form: "fsco_ordenadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden.fields.espera_cenizas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
    <div id="r_adjunto"<?= $Page->adjunto->rowAttributes() ?>>
        <label id="elh_sco_orden_adjunto" for="x_adjunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->adjunto->caption() ?><?= $Page->adjunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->adjunto->cellAttributes() ?>>
<span id="el_sco_orden_adjunto">
<input type="<?= $Page->adjunto->getInputTextType() ?>" name="x_adjunto" id="x_adjunto" data-table="sco_orden" data-field="x_adjunto" value="<?= $Page->adjunto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->adjunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->adjunto->formatPattern()) ?>"<?= $Page->adjunto->editAttributes() ?> aria-describedby="x_adjunto_help">
<?= $Page->adjunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->adjunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->llevar_a->Visible) { // llevar_a ?>
    <div id="r_llevar_a"<?= $Page->llevar_a->rowAttributes() ?>>
        <label id="elh_sco_orden_llevar_a" for="x_llevar_a" class="<?= $Page->LeftColumnClass ?>"><?= $Page->llevar_a->caption() ?><?= $Page->llevar_a->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->llevar_a->cellAttributes() ?>>
<span id="el_sco_orden_llevar_a">
<input type="<?= $Page->llevar_a->getInputTextType() ?>" name="x_llevar_a" id="x_llevar_a" data-table="sco_orden" data-field="x_llevar_a" value="<?= $Page->llevar_a->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->llevar_a->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->llevar_a->formatPattern()) ?>"<?= $Page->llevar_a->editAttributes() ?> aria-describedby="x_llevar_a_help">
<?= $Page->llevar_a->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->llevar_a->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
    <div id="r_servicio_atendido"<?= $Page->servicio_atendido->rowAttributes() ?>>
        <label id="elh_sco_orden_servicio_atendido" for="x_servicio_atendido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_atendido->caption() ?><?= $Page->servicio_atendido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_atendido->cellAttributes() ?>>
<span id="el_sco_orden_servicio_atendido">
<input type="<?= $Page->servicio_atendido->getInputTextType() ?>" name="x_servicio_atendido" id="x_servicio_atendido" data-table="sco_orden" data-field="x_servicio_atendido" value="<?= $Page->servicio_atendido->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->servicio_atendido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->servicio_atendido->formatPattern()) ?>"<?= $Page->servicio_atendido->editAttributes() ?> aria-describedby="x_servicio_atendido_help">
<?= $Page->servicio_atendido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->servicio_atendido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_ordenadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_ordenadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_orden");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
