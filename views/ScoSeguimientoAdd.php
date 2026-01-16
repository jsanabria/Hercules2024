<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoSeguimientoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_seguimiento: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_seguimientoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_seguimientoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["expediente", [fields.expediente.visible && fields.expediente.required ? ew.Validators.required(fields.expediente.caption) : null, ew.Validators.integer], fields.expediente.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["user_asigna", [fields.user_asigna.visible && fields.user_asigna.required ? ew.Validators.required(fields.user_asigna.caption) : null], fields.user_asigna.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["texto", [fields.texto.visible && fields.texto.required ? ew.Validators.required(fields.texto.caption) : null], fields.texto.isInvalid]
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
            "_username": <?= $Page->_username->toClientList($Page) ?>,
            "user_asigna": <?= $Page->user_asigna->toClientList($Page) ?>,
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
<form name="fsco_seguimientoadd" id="fsco_seguimientoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_seguimiento">
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
        <label id="elh_sco_seguimiento_expediente" for="x_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expediente->caption() ?><?= $Page->expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expediente->cellAttributes() ?>>
<?php if ($Page->expediente->getSessionValue() != "") { ?>
<span id="el_sco_seguimiento_expediente">
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
<span id="el_sco_seguimiento_expediente">
<input type="<?= $Page->expediente->getInputTextType() ?>" name="x_expediente" id="x_expediente" data-table="sco_seguimiento" data-field="x_expediente" value="<?= $Page->expediente->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->expediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->expediente->formatPattern()) ?>"<?= $Page->expediente->editAttributes() ?> aria-describedby="x_expediente_help">
<?= $Page->expediente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expediente->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_asigna->Visible) { // user_asigna ?>
    <div id="r_user_asigna"<?= $Page->user_asigna->rowAttributes() ?>>
        <label id="elh_sco_seguimiento_user_asigna" for="x_user_asigna" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_asigna->caption() ?><?= $Page->user_asigna->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_asigna->cellAttributes() ?>>
<span id="el_sco_seguimiento_user_asigna">
    <select
        id="x_user_asigna"
        name="x_user_asigna"
        class="form-select ew-select<?= $Page->user_asigna->isInvalidClass() ?>"
        <?php if (!$Page->user_asigna->IsNativeSelect) { ?>
        data-select2-id="fsco_seguimientoadd_x_user_asigna"
        <?php } ?>
        data-table="sco_seguimiento"
        data-field="x_user_asigna"
        data-value-separator="<?= $Page->user_asigna->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->user_asigna->getPlaceHolder()) ?>"
        <?= $Page->user_asigna->editAttributes() ?>>
        <?= $Page->user_asigna->selectOptionListHtml("x_user_asigna") ?>
    </select>
    <?= $Page->user_asigna->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->user_asigna->getErrorMessage() ?></div>
<?= $Page->user_asigna->Lookup->getParamTag($Page, "p_x_user_asigna") ?>
<?php if (!$Page->user_asigna->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_seguimientoadd", function() {
    var options = { name: "x_user_asigna", selectId: "fsco_seguimientoadd_x_user_asigna" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_seguimientoadd.lists.user_asigna?.lookupOptions.length) {
        options.data = { id: "x_user_asigna", form: "fsco_seguimientoadd" };
    } else {
        options.ajax = { id: "x_user_asigna", form: "fsco_seguimientoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_seguimiento.fields.user_asigna.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_seguimiento_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_seguimiento_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_seguimiento" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_seguimientoadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(11) ?>",
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
    ew.createDateTimePicker("fsco_seguimientoadd", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->texto->Visible) { // texto ?>
    <div id="r_texto"<?= $Page->texto->rowAttributes() ?>>
        <label id="elh_sco_seguimiento_texto" for="x_texto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->texto->caption() ?><?= $Page->texto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->texto->cellAttributes() ?>>
<span id="el_sco_seguimiento_texto">
<textarea data-table="sco_seguimiento" data-field="x_texto" name="x_texto" id="x_texto" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->texto->getPlaceHolder()) ?>"<?= $Page->texto->editAttributes() ?> aria-describedby="x_texto_help"><?= $Page->texto->EditValue ?></textarea>
<?= $Page->texto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->texto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_seguimientoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_seguimientoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_seguimiento");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
