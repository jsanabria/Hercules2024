<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionTicketEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fautogestion_ticketedit" id="fautogestion_ticketedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_ticket: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fautogestion_ticketedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fautogestion_ticketedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nticket", [fields.Nticket.visible && fields.Nticket.required ? ew.Validators.required(fields.Nticket.caption) : null], fields.Nticket.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["apellido", [fields.apellido.visible && fields.apellido.required ? ew.Validators.required(fields.apellido.caption) : null], fields.apellido.isInvalid],
            ["cedula_fallecido", [fields.cedula_fallecido.visible && fields.cedula_fallecido.required ? ew.Validators.required(fields.cedula_fallecido.caption) : null], fields.cedula_fallecido.isInvalid],
            ["nombre_fallecido", [fields.nombre_fallecido.visible && fields.nombre_fallecido.required ? ew.Validators.required(fields.nombre_fallecido.caption) : null], fields.nombre_fallecido.isInvalid],
            ["apellido_fallecido", [fields.apellido_fallecido.visible && fields.apellido_fallecido.required ? ew.Validators.required(fields.apellido_fallecido.caption) : null], fields.apellido_fallecido.isInvalid],
            ["contactado", [fields.contactado.visible && fields.contactado.required ? ew.Validators.required(fields.contactado.caption) : null], fields.contactado.isInvalid],
            ["fecha_contactado", [fields.fecha_contactado.visible && fields.fecha_contactado.required ? ew.Validators.required(fields.fecha_contactado.caption) : null], fields.fecha_contactado.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid]
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
            "contactado": <?= $Page->contactado->toClientList($Page) ?>,
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="autogestion_ticket">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nticket->Visible) { // Nticket ?>
    <div id="r_Nticket"<?= $Page->Nticket->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_Nticket" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nticket->caption() ?><?= $Page->Nticket->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nticket->cellAttributes() ?>>
<span id="el_autogestion_ticket_Nticket">
<span<?= $Page->Nticket->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nticket->getDisplayValue($Page->Nticket->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_Nticket" data-hidden="1" name="x_Nticket" id="x_Nticket" value="<?= HtmlEncode($Page->Nticket->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_autogestion_ticket_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha->getDisplayValue($Page->fecha->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_fecha" data-hidden="1" name="x_fecha" id="x_fecha" value="<?= HtmlEncode($Page->fecha->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <div id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_autogestion_ticket_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->servicio_tipo->getDisplayValue($Page->servicio_tipo->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_servicio_tipo" data-hidden="1" name="x_servicio_tipo" id="x_servicio_tipo" value="<?= HtmlEncode($Page->servicio_tipo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_autogestion_ticket_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nombre->getDisplayValue($Page->nombre->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_nombre" data-hidden="1" name="x_nombre" id="x_nombre" value="<?= HtmlEncode($Page->nombre->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
    <div id="r_apellido"<?= $Page->apellido->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_apellido" for="x_apellido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido->caption() ?><?= $Page->apellido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido->cellAttributes() ?>>
<span id="el_autogestion_ticket_apellido">
<span<?= $Page->apellido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->apellido->getDisplayValue($Page->apellido->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_apellido" data-hidden="1" name="x_apellido" id="x_apellido" value="<?= HtmlEncode($Page->apellido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <div id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_cedula_fallecido" for="x_cedula_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_fallecido->caption() ?><?= $Page->cedula_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_autogestion_ticket_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cedula_fallecido->getDisplayValue($Page->cedula_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_cedula_fallecido" data-hidden="1" name="x_cedula_fallecido" id="x_cedula_fallecido" value="<?= HtmlEncode($Page->cedula_fallecido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <div id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_nombre_fallecido" for="x_nombre_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_fallecido->caption() ?><?= $Page->nombre_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_autogestion_ticket_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nombre_fallecido->getDisplayValue($Page->nombre_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_nombre_fallecido" data-hidden="1" name="x_nombre_fallecido" id="x_nombre_fallecido" value="<?= HtmlEncode($Page->nombre_fallecido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido_fallecido->Visible) { // apellido_fallecido ?>
    <div id="r_apellido_fallecido"<?= $Page->apellido_fallecido->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_apellido_fallecido" for="x_apellido_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido_fallecido->caption() ?><?= $Page->apellido_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido_fallecido->cellAttributes() ?>>
<span id="el_autogestion_ticket_apellido_fallecido">
<span<?= $Page->apellido_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->apellido_fallecido->getDisplayValue($Page->apellido_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_apellido_fallecido" data-hidden="1" name="x_apellido_fallecido" id="x_apellido_fallecido" value="<?= HtmlEncode($Page->apellido_fallecido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contactado->Visible) { // contactado ?>
    <div id="r_contactado"<?= $Page->contactado->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_contactado" for="x_contactado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contactado->caption() ?><?= $Page->contactado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contactado->cellAttributes() ?>>
<span id="el_autogestion_ticket_contactado">
    <select
        id="x_contactado"
        name="x_contactado"
        class="form-select ew-select<?= $Page->contactado->isInvalidClass() ?>"
        <?php if (!$Page->contactado->IsNativeSelect) { ?>
        data-select2-id="fautogestion_ticketedit_x_contactado"
        <?php } ?>
        data-table="autogestion_ticket"
        data-field="x_contactado"
        data-value-separator="<?= $Page->contactado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->contactado->getPlaceHolder()) ?>"
        <?= $Page->contactado->editAttributes() ?>>
        <?= $Page->contactado->selectOptionListHtml("x_contactado") ?>
    </select>
    <?= $Page->contactado->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->contactado->getErrorMessage() ?></div>
<?php if (!$Page->contactado->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_ticketedit", function() {
    var options = { name: "x_contactado", selectId: "fautogestion_ticketedit_x_contactado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_ticketedit.lists.contactado?.lookupOptions.length) {
        options.data = { id: "x_contactado", form: "fautogestion_ticketedit" };
    } else {
        options.ajax = { id: "x_contactado", form: "fautogestion_ticketedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_ticket.fields.contactado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_contactado->Visible) { // fecha_contactado ?>
    <div id="r_fecha_contactado"<?= $Page->fecha_contactado->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_fecha_contactado" for="x_fecha_contactado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_contactado->caption() ?><?= $Page->fecha_contactado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_contactado->cellAttributes() ?>>
<span id="el_autogestion_ticket_fecha_contactado">
<span<?= $Page->fecha_contactado->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha_contactado->getDisplayValue($Page->fecha_contactado->EditValue))) ?>"></span>
<input type="hidden" data-table="autogestion_ticket" data-field="x_fecha_contactado" data-hidden="1" name="x_fecha_contactado" id="x_fecha_contactado" value="<?= HtmlEncode($Page->fecha_contactado->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_autogestion_ticket_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_autogestion_ticket_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fautogestion_ticketedit_x_estatus"
        <?php } ?>
        data-table="autogestion_ticket"
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
loadjs.ready("fautogestion_ticketedit", function() {
    var options = { name: "x_estatus", selectId: "fautogestion_ticketedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_ticketedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fautogestion_ticketedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fautogestion_ticketedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_ticket.fields.estatus.selectOptions);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fautogestion_ticketedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fautogestion_ticketedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("autogestion_ticket");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
