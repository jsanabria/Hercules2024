<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_costosadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costosadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["costos_articulos", [fields.costos_articulos.visible && fields.costos_articulos.required ? ew.Validators.required(fields.costos_articulos.caption) : null], fields.costos_articulos.isInvalid],
            ["precio_actual", [fields.precio_actual.visible && fields.precio_actual.required ? ew.Validators.required(fields.precio_actual.caption) : null, ew.Validators.float], fields.precio_actual.isInvalid],
            ["porcentaje_aplicado", [fields.porcentaje_aplicado.visible && fields.porcentaje_aplicado.required ? ew.Validators.required(fields.porcentaje_aplicado.caption) : null, ew.Validators.float], fields.porcentaje_aplicado.isInvalid],
            ["precio_nuevo", [fields.precio_nuevo.visible && fields.precio_nuevo.required ? ew.Validators.required(fields.precio_nuevo.caption) : null, ew.Validators.float], fields.precio_nuevo.isInvalid],
            ["alicuota_iva", [fields.alicuota_iva.visible && fields.alicuota_iva.required ? ew.Validators.required(fields.alicuota_iva.caption) : null, ew.Validators.float], fields.alicuota_iva.isInvalid],
            ["monto_iva", [fields.monto_iva.visible && fields.monto_iva.required ? ew.Validators.required(fields.monto_iva.caption) : null, ew.Validators.float], fields.monto_iva.isInvalid],
            ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null, ew.Validators.float], fields.total.isInvalid],
            ["cerrado", [fields.cerrado.visible && fields.cerrado.required ? ew.Validators.required(fields.cerrado.caption) : null], fields.cerrado.isInvalid]
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
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "costos_articulos": <?= $Page->costos_articulos->toClientList($Page) ?>,
            "cerrado": <?= $Page->cerrado->toClientList($Page) ?>,
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
<form name="fsco_costosadd" id="fsco_costosadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_sco_costos_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_sco_costos_id">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="sco_costos" data-field="x_id" value="<?= $Page->id->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id->formatPattern()) ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_costos_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_costos_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_costos" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_costosadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_costosadd", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_costos_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_costos_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_costosadd_x_tipo"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costosadd", function() {
    var options = { name: "x_tipo", selectId: "fsco_costosadd_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costosadd.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_costosadd" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_costosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
    <div id="r_costos_articulos"<?= $Page->costos_articulos->rowAttributes() ?>>
        <label id="elh_sco_costos_costos_articulos" for="x_costos_articulos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costos_articulos->caption() ?><?= $Page->costos_articulos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costos_articulos->cellAttributes() ?>>
<span id="el_sco_costos_costos_articulos">
    <select
        id="x_costos_articulos"
        name="x_costos_articulos"
        class="form-select ew-select<?= $Page->costos_articulos->isInvalidClass() ?>"
        <?php if (!$Page->costos_articulos->IsNativeSelect) { ?>
        data-select2-id="fsco_costosadd_x_costos_articulos"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_costos_articulos"
        data-value-separator="<?= $Page->costos_articulos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->costos_articulos->getPlaceHolder()) ?>"
        <?= $Page->costos_articulos->editAttributes() ?>>
        <?= $Page->costos_articulos->selectOptionListHtml("x_costos_articulos") ?>
    </select>
    <?= $Page->costos_articulos->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->costos_articulos->getErrorMessage() ?></div>
<?= $Page->costos_articulos->Lookup->getParamTag($Page, "p_x_costos_articulos") ?>
<?php if (!$Page->costos_articulos->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costosadd", function() {
    var options = { name: "x_costos_articulos", selectId: "fsco_costosadd_x_costos_articulos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costosadd.lists.costos_articulos?.lookupOptions.length) {
        options.data = { id: "x_costos_articulos", form: "fsco_costosadd" };
    } else {
        options.ajax = { id: "x_costos_articulos", form: "fsco_costosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.costos_articulos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precio_actual->Visible) { // precio_actual ?>
    <div id="r_precio_actual"<?= $Page->precio_actual->rowAttributes() ?>>
        <label id="elh_sco_costos_precio_actual" for="x_precio_actual" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precio_actual->caption() ?><?= $Page->precio_actual->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precio_actual->cellAttributes() ?>>
<span id="el_sco_costos_precio_actual">
<input type="<?= $Page->precio_actual->getInputTextType() ?>" name="x_precio_actual" id="x_precio_actual" data-table="sco_costos" data-field="x_precio_actual" value="<?= $Page->precio_actual->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->precio_actual->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio_actual->formatPattern()) ?>"<?= $Page->precio_actual->editAttributes() ?> aria-describedby="x_precio_actual_help">
<?= $Page->precio_actual->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precio_actual->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
    <div id="r_porcentaje_aplicado"<?= $Page->porcentaje_aplicado->rowAttributes() ?>>
        <label id="elh_sco_costos_porcentaje_aplicado" for="x_porcentaje_aplicado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porcentaje_aplicado->caption() ?><?= $Page->porcentaje_aplicado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porcentaje_aplicado->cellAttributes() ?>>
<span id="el_sco_costos_porcentaje_aplicado">
<input type="<?= $Page->porcentaje_aplicado->getInputTextType() ?>" name="x_porcentaje_aplicado" id="x_porcentaje_aplicado" data-table="sco_costos" data-field="x_porcentaje_aplicado" value="<?= $Page->porcentaje_aplicado->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->porcentaje_aplicado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentaje_aplicado->formatPattern()) ?>"<?= $Page->porcentaje_aplicado->editAttributes() ?> aria-describedby="x_porcentaje_aplicado_help">
<?= $Page->porcentaje_aplicado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porcentaje_aplicado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
    <div id="r_precio_nuevo"<?= $Page->precio_nuevo->rowAttributes() ?>>
        <label id="elh_sco_costos_precio_nuevo" for="x_precio_nuevo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precio_nuevo->caption() ?><?= $Page->precio_nuevo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precio_nuevo->cellAttributes() ?>>
<span id="el_sco_costos_precio_nuevo">
<input type="<?= $Page->precio_nuevo->getInputTextType() ?>" name="x_precio_nuevo" id="x_precio_nuevo" data-table="sco_costos" data-field="x_precio_nuevo" value="<?= $Page->precio_nuevo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->precio_nuevo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio_nuevo->formatPattern()) ?>"<?= $Page->precio_nuevo->editAttributes() ?> aria-describedby="x_precio_nuevo_help">
<?= $Page->precio_nuevo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precio_nuevo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
    <div id="r_alicuota_iva"<?= $Page->alicuota_iva->rowAttributes() ?>>
        <label id="elh_sco_costos_alicuota_iva" for="x_alicuota_iva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alicuota_iva->caption() ?><?= $Page->alicuota_iva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->alicuota_iva->cellAttributes() ?>>
<span id="el_sco_costos_alicuota_iva">
<input type="<?= $Page->alicuota_iva->getInputTextType() ?>" name="x_alicuota_iva" id="x_alicuota_iva" data-table="sco_costos" data-field="x_alicuota_iva" value="<?= $Page->alicuota_iva->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->alicuota_iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->alicuota_iva->formatPattern()) ?>"<?= $Page->alicuota_iva->editAttributes() ?> aria-describedby="x_alicuota_iva_help">
<?= $Page->alicuota_iva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alicuota_iva->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto_iva->Visible) { // monto_iva ?>
    <div id="r_monto_iva"<?= $Page->monto_iva->rowAttributes() ?>>
        <label id="elh_sco_costos_monto_iva" for="x_monto_iva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_iva->caption() ?><?= $Page->monto_iva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_iva->cellAttributes() ?>>
<span id="el_sco_costos_monto_iva">
<input type="<?= $Page->monto_iva->getInputTextType() ?>" name="x_monto_iva" id="x_monto_iva" data-table="sco_costos" data-field="x_monto_iva" value="<?= $Page->monto_iva->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->monto_iva->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_iva->formatPattern()) ?>"<?= $Page->monto_iva->editAttributes() ?> aria-describedby="x_monto_iva_help">
<?= $Page->monto_iva->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto_iva->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total"<?= $Page->total->rowAttributes() ?>>
        <label id="elh_sco_costos_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total->cellAttributes() ?>>
<span id="el_sco_costos_total">
<input type="<?= $Page->total->getInputTextType() ?>" name="x_total" id="x_total" data-table="sco_costos" data-field="x_total" value="<?= $Page->total->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->total->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->total->formatPattern()) ?>"<?= $Page->total->editAttributes() ?> aria-describedby="x_total_help">
<?= $Page->total->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->total->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
    <div id="r_cerrado"<?= $Page->cerrado->rowAttributes() ?>>
        <label id="elh_sco_costos_cerrado" for="x_cerrado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cerrado->caption() ?><?= $Page->cerrado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cerrado->cellAttributes() ?>>
<span id="el_sco_costos_cerrado">
    <select
        id="x_cerrado"
        name="x_cerrado"
        class="form-select ew-select<?= $Page->cerrado->isInvalidClass() ?>"
        <?php if (!$Page->cerrado->IsNativeSelect) { ?>
        data-select2-id="fsco_costosadd_x_cerrado"
        <?php } ?>
        data-table="sco_costos"
        data-field="x_cerrado"
        data-value-separator="<?= $Page->cerrado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cerrado->getPlaceHolder()) ?>"
        <?= $Page->cerrado->editAttributes() ?>>
        <?= $Page->cerrado->selectOptionListHtml("x_cerrado") ?>
    </select>
    <?= $Page->cerrado->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cerrado->getErrorMessage() ?></div>
<?php if (!$Page->cerrado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costosadd", function() {
    var options = { name: "x_cerrado", selectId: "fsco_costosadd_x_cerrado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costosadd.lists.cerrado?.lookupOptions.length) {
        options.data = { id: "x_cerrado", form: "fsco_costosadd" };
    } else {
        options.ajax = { id: "x_cerrado", form: "fsco_costosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos.fields.cerrado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_costosadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_costosadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_costos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
