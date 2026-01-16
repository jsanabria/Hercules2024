<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGramaPagosAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_grama_pagos: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_grama_pagosadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_grama_pagosadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["banco", [fields.banco.visible && fields.banco.required ? ew.Validators.required(fields.banco.caption) : null], fields.banco.isInvalid],
            ["ref", [fields.ref.visible && fields.ref.required ? ew.Validators.required(fields.ref.caption) : null], fields.ref.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["monto", [fields.monto.visible && fields.monto.required ? ew.Validators.required(fields.monto.caption) : null, ew.Validators.float], fields.monto.isInvalid],
            ["moneda", [fields.moneda.visible && fields.moneda.required ? ew.Validators.required(fields.moneda.caption) : null], fields.moneda.isInvalid],
            ["tasa", [fields.tasa.visible && fields.tasa.required ? ew.Validators.required(fields.tasa.caption) : null, ew.Validators.float], fields.tasa.isInvalid],
            ["cta_destino", [fields.cta_destino.visible && fields.cta_destino.required ? ew.Validators.required(fields.cta_destino.caption) : null], fields.cta_destino.isInvalid]
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
            "moneda": <?= $Page->moneda->toClientList($Page) ?>,
            "cta_destino": <?= $Page->cta_destino->toClientList($Page) ?>,
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
<form name="fsco_grama_pagosadd" id="fsco_grama_pagosadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_grama_pagos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_grama") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_grama">
<input type="hidden" name="fk_Ngrama" value="<?= HtmlEncode($Page->grama->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_grama_pagos_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosadd_x_tipo"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosadd", function() {
    var options = { name: "x_tipo", selectId: "fsco_grama_pagosadd_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosadd.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_grama_pagosadd" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_grama_pagosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->banco->Visible) { // banco ?>
    <div id="r_banco"<?= $Page->banco->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_banco" for="x_banco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->banco->caption() ?><?= $Page->banco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->banco->cellAttributes() ?>>
<span id="el_sco_grama_pagos_banco">
<input type="<?= $Page->banco->getInputTextType() ?>" name="x_banco" id="x_banco" data-table="sco_grama_pagos" data-field="x_banco" value="<?= $Page->banco->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->banco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->banco->formatPattern()) ?>"<?= $Page->banco->editAttributes() ?> aria-describedby="x_banco_help">
<?= $Page->banco->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->banco->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ref->Visible) { // ref ?>
    <div id="r_ref"<?= $Page->ref->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_ref" for="x_ref" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ref->caption() ?><?= $Page->ref->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ref->cellAttributes() ?>>
<span id="el_sco_grama_pagos_ref">
<input type="<?= $Page->ref->getInputTextType() ?>" name="x_ref" id="x_ref" data-table="sco_grama_pagos" data-field="x_ref" value="<?= $Page->ref->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->ref->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ref->formatPattern()) ?>"<?= $Page->ref->editAttributes() ?> aria-describedby="x_ref_help">
<?= $Page->ref->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ref->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_grama_pagos_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_grama_pagos" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_grama_pagosadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_grama_pagosadd", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <div id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_monto" for="x_monto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto->caption() ?><?= $Page->monto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto->cellAttributes() ?>>
<span id="el_sco_grama_pagos_monto">
<input type="<?= $Page->monto->getInputTextType() ?>" name="x_monto" id="x_monto" data-table="sco_grama_pagos" data-field="x_monto" value="<?= $Page->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto->formatPattern()) ?>"<?= $Page->monto->editAttributes() ?> aria-describedby="x_monto_help">
<?= $Page->monto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <div id="r_moneda"<?= $Page->moneda->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_moneda" for="x_moneda" class="<?= $Page->LeftColumnClass ?>"><?= $Page->moneda->caption() ?><?= $Page->moneda->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->moneda->cellAttributes() ?>>
<span id="el_sco_grama_pagos_moneda">
    <select
        id="x_moneda"
        name="x_moneda"
        class="form-select ew-select<?= $Page->moneda->isInvalidClass() ?>"
        <?php if (!$Page->moneda->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosadd_x_moneda"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_moneda"
        data-value-separator="<?= $Page->moneda->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->moneda->getPlaceHolder()) ?>"
        <?= $Page->moneda->editAttributes() ?>>
        <?= $Page->moneda->selectOptionListHtml("x_moneda") ?>
    </select>
    <?= $Page->moneda->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->moneda->getErrorMessage() ?></div>
<?= $Page->moneda->Lookup->getParamTag($Page, "p_x_moneda") ?>
<?php if (!$Page->moneda->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosadd", function() {
    var options = { name: "x_moneda", selectId: "fsco_grama_pagosadd_x_moneda" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosadd.lists.moneda?.lookupOptions.length) {
        options.data = { id: "x_moneda", form: "fsco_grama_pagosadd" };
    } else {
        options.ajax = { id: "x_moneda", form: "fsco_grama_pagosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.moneda.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <div id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_tasa" for="x_tasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa->caption() ?><?= $Page->tasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_grama_pagos_tasa">
<input type="<?= $Page->tasa->getInputTextType() ?>" name="x_tasa" id="x_tasa" data-table="sco_grama_pagos" data-field="x_tasa" value="<?= $Page->tasa->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tasa->formatPattern()) ?>"<?= $Page->tasa->editAttributes() ?> aria-describedby="x_tasa_help">
<?= $Page->tasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tasa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cta_destino->Visible) { // cta_destino ?>
    <div id="r_cta_destino"<?= $Page->cta_destino->rowAttributes() ?>>
        <label id="elh_sco_grama_pagos_cta_destino" for="x_cta_destino" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cta_destino->caption() ?><?= $Page->cta_destino->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cta_destino->cellAttributes() ?>>
<span id="el_sco_grama_pagos_cta_destino">
    <select
        id="x_cta_destino"
        name="x_cta_destino"
        class="form-select ew-select<?= $Page->cta_destino->isInvalidClass() ?>"
        <?php if (!$Page->cta_destino->IsNativeSelect) { ?>
        data-select2-id="fsco_grama_pagosadd_x_cta_destino"
        <?php } ?>
        data-table="sco_grama_pagos"
        data-field="x_cta_destino"
        data-value-separator="<?= $Page->cta_destino->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cta_destino->getPlaceHolder()) ?>"
        <?= $Page->cta_destino->editAttributes() ?>>
        <?= $Page->cta_destino->selectOptionListHtml("x_cta_destino") ?>
    </select>
    <?= $Page->cta_destino->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cta_destino->getErrorMessage() ?></div>
<?= $Page->cta_destino->Lookup->getParamTag($Page, "p_x_cta_destino") ?>
<?php if (!$Page->cta_destino->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_grama_pagosadd", function() {
    var options = { name: "x_cta_destino", selectId: "fsco_grama_pagosadd_x_cta_destino" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_grama_pagosadd.lists.cta_destino?.lookupOptions.length) {
        options.data = { id: "x_cta_destino", form: "fsco_grama_pagosadd" };
    } else {
        options.ajax = { id: "x_cta_destino", form: "fsco_grama_pagosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama_pagos.fields.cta_destino.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->grama->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_grama" id="x_grama" value="<?= HtmlEncode(strval($Page->grama->getSessionValue())) ?>">
    <?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_grama_pagosadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_grama_pagosadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_grama_pagos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $('#x_moneda').on('change', function() {
        var $moneda = $(this);
        var $tasaInput = $('#x_tasa');
        var valorMoneda = $moneda.val();
        if (!valorMoneda) return;

        // Bloqueamos el input temporalmente para dar feedback visual
        $tasaInput.addClass('text-muted').prop('readonly', true);
        $.ajax({
            method: "POST",
            url: "dashboard/buscar_tasa.php",
            data: { moneda: valorMoneda },
            dataType: "json" // Importante: indicamos que esperamos un JSON
        })
        .done(function(response) {
            if (response.status === "success" || response.status === "not_found") {
                // Asignamos la tasa. El punto decimal se mantiene para cálculos.
                $tasaInput.val(response.tasa);

                // Si quieres que el usuario vea la tasa con formato local (coma):
                // $tasaInput.val(response.tasa.toString().replace('.', ','));
            } else {
                console.error("Error del servidor:", response.message);
                $tasaInput.val("1.00");
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
            $tasaInput.val("1.00");
        })
        .always(function() {
            // Desbloqueamos el input
            $tasaInput.removeClass('text-muted').prop('readonly', false);
        });
    });
});
</script>
