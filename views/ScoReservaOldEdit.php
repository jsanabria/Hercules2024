<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReservaOldEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_reserva_oldedit" id="fsco_reserva_oldedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_reserva_old: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_reserva_oldedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reserva_oldedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nreserva", [fields.Nreserva.visible && fields.Nreserva.required ? ew.Validators.required(fields.Nreserva.caption) : null], fields.Nreserva.isInvalid],
            ["capilla", [fields.capilla.visible && fields.capilla.required ? ew.Validators.required(fields.capilla.caption) : null], fields.capilla.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["hora", [fields.hora.visible && fields.hora.required ? ew.Validators.required(fields.hora.caption) : null, ew.Validators.time(fields.hora.clientFormatPattern)], fields.hora.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid]
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
<input type="hidden" name="t" value="sco_reserva_old">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nreserva->Visible) { // Nreserva ?>
    <div id="r_Nreserva"<?= $Page->Nreserva->rowAttributes() ?>>
        <label id="elh_sco_reserva_old_Nreserva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nreserva->caption() ?><?= $Page->Nreserva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nreserva->cellAttributes() ?>>
<span id="el_sco_reserva_old_Nreserva">
<span<?= $Page->Nreserva->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nreserva->getDisplayValue($Page->Nreserva->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_reserva_old" data-field="x_Nreserva" data-hidden="1" name="x_Nreserva" id="x_Nreserva" value="<?= HtmlEncode($Page->Nreserva->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
    <div id="r_capilla"<?= $Page->capilla->rowAttributes() ?>>
        <label id="elh_sco_reserva_old_capilla" for="x_capilla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->capilla->caption() ?><?= $Page->capilla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->capilla->cellAttributes() ?>>
<span id="el_sco_reserva_old_capilla">
<input type="<?= $Page->capilla->getInputTextType() ?>" name="x_capilla" id="x_capilla" data-table="sco_reserva_old" data-field="x_capilla" value="<?= $Page->capilla->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->capilla->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->capilla->formatPattern()) ?>"<?= $Page->capilla->editAttributes() ?> aria-describedby="x_capilla_help">
<?= $Page->capilla->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->capilla->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_reserva_old_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_reserva_old_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_reserva_old" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_reserva_oldedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_reserva_oldedit", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora->Visible) { // hora ?>
    <div id="r_hora"<?= $Page->hora->rowAttributes() ?>>
        <label id="elh_sco_reserva_old_hora" for="x_hora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora->caption() ?><?= $Page->hora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora->cellAttributes() ?>>
<span id="el_sco_reserva_old_hora">
<input type="<?= $Page->hora->getInputTextType() ?>" name="x_hora" id="x_hora" data-table="sco_reserva_old" data-field="x_hora" value="<?= $Page->hora->EditValue ?>" placeholder="<?= HtmlEncode($Page->hora->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora->formatPattern()) ?>"<?= $Page->hora->editAttributes() ?> aria-describedby="x_hora_help">
<?= $Page->hora->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora->getErrorMessage() ?></div>
<?php if (!$Page->hora->ReadOnly && !$Page->hora->Disabled && !isset($Page->hora->EditAttrs["readonly"]) && !isset($Page->hora->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_reserva_oldedit", "timepicker"], () => ew.createTimePicker("fsco_reserva_oldedit", "x_hora", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(4) ?>" }, undefined)));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <label id="elh_sco_reserva_old__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_reserva_old__username">
<input type="<?= $Page->_username->getInputTextType() ?>" name="x__username" id="x__username" data-table="sco_reserva_old" data-field="x__username" value="<?= $Page->_username->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_username->formatPattern()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_reserva_oldedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_reserva_oldedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_reserva_old");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
