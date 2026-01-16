<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewExpedienteFunerariaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fview_expediente_funerariaedit" id="fview_expediente_funerariaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente_funeraria: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fview_expediente_funerariaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_expediente_funerariaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["expediente", [fields.expediente.visible && fields.expediente.required ? ew.Validators.required(fields.expediente.caption) : null], fields.expediente.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["cedula_fallecido", [fields.cedula_fallecido.visible && fields.cedula_fallecido.required ? ew.Validators.required(fields.cedula_fallecido.caption) : null], fields.cedula_fallecido.isInvalid],
            ["nombre_fallecido", [fields.nombre_fallecido.visible && fields.nombre_fallecido.required ? ew.Validators.required(fields.nombre_fallecido.caption) : null], fields.nombre_fallecido.isInvalid],
            ["apellidos_fallecido", [fields.apellidos_fallecido.visible && fields.apellidos_fallecido.required ? ew.Validators.required(fields.apellidos_fallecido.caption) : null], fields.apellidos_fallecido.isInvalid],
            ["causa_ocurrencia", [fields.causa_ocurrencia.visible && fields.causa_ocurrencia.required ? ew.Validators.required(fields.causa_ocurrencia.caption) : null], fields.causa_ocurrencia.isInvalid],
            ["fecha_servicio", [fields.fecha_servicio.visible && fields.fecha_servicio.required ? ew.Validators.required(fields.fecha_servicio.caption) : null], fields.fecha_servicio.isInvalid],
            ["hora_fin", [fields.hora_fin.visible && fields.hora_fin.required ? ew.Validators.required(fields.hora_fin.caption) : null], fields.hora_fin.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null], fields.funeraria.isInvalid]
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
            "funeraria": <?= $Page->funeraria->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="view_expediente_funeraria">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->expediente->Visible) { // expediente ?>
    <div id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_expediente" for="x_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expediente->caption() ?><?= $Page->expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expediente->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expediente->getDisplayValue($Page->expediente->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_expediente" data-hidden="1" name="x_expediente" id="x_expediente" value="<?= HtmlEncode($Page->expediente->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <div id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->servicio->getDisplayValue($Page->servicio->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_servicio" data-hidden="1" name="x_servicio" id="x_servicio" value="<?= HtmlEncode($Page->servicio->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <div id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_cedula_fallecido" for="x_cedula_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_fallecido->caption() ?><?= $Page->cedula_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cedula_fallecido->getDisplayValue($Page->cedula_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_cedula_fallecido" data-hidden="1" name="x_cedula_fallecido" id="x_cedula_fallecido" value="<?= HtmlEncode($Page->cedula_fallecido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <div id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_nombre_fallecido" for="x_nombre_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_fallecido->caption() ?><?= $Page->nombre_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nombre_fallecido->getDisplayValue($Page->nombre_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_nombre_fallecido" data-hidden="1" name="x_nombre_fallecido" id="x_nombre_fallecido" value="<?= HtmlEncode($Page->nombre_fallecido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <div id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_apellidos_fallecido" for="x_apellidos_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos_fallecido->caption() ?><?= $Page->apellidos_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->apellidos_fallecido->getDisplayValue($Page->apellidos_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_apellidos_fallecido" data-hidden="1" name="x_apellidos_fallecido" id="x_apellidos_fallecido" value="<?= HtmlEncode($Page->apellidos_fallecido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <div id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_causa_ocurrencia" for="x_causa_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_ocurrencia->caption() ?><?= $Page->causa_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->causa_ocurrencia->getDisplayValue($Page->causa_ocurrencia->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_causa_ocurrencia" data-hidden="1" name="x_causa_ocurrencia" id="x_causa_ocurrencia" value="<?= HtmlEncode($Page->causa_ocurrencia->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <div id="r_fecha_servicio"<?= $Page->fecha_servicio->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_fecha_servicio" for="x_fecha_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_servicio->caption() ?><?= $Page->fecha_servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha_servicio->getDisplayValue($Page->fecha_servicio->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_fecha_servicio" data-hidden="1" name="x_fecha_servicio" id="x_fecha_servicio" value="<?= HtmlEncode($Page->fecha_servicio->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
    <div id="r_hora_fin"<?= $Page->hora_fin->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_hora_fin" for="x_hora_fin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_fin->caption() ?><?= $Page->hora_fin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_fin->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_hora_fin">
<span<?= $Page->hora_fin->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->hora_fin->getDisplayValue($Page->hora_fin->EditValue))) ?>"></span>
<input type="hidden" data-table="view_expediente_funeraria" data-field="x_hora_fin" data-hidden="1" name="x_hora_fin" id="x_hora_fin" value="<?= HtmlEncode($Page->hora_fin->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <div id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <label id="elh_view_expediente_funeraria_funeraria" for="x_funeraria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funeraria->caption() ?><?= $Page->funeraria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_view_expediente_funeraria_funeraria">
    <select
        id="x_funeraria"
        name="x_funeraria"
        class="form-control ew-select<?= $Page->funeraria->isInvalidClass() ?>"
        data-select2-id="fview_expediente_funerariaedit_x_funeraria"
        data-table="view_expediente_funeraria"
        data-field="x_funeraria"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->funeraria->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->funeraria->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->funeraria->getPlaceHolder()) ?>"
        <?= $Page->funeraria->editAttributes() ?>>
        <?= $Page->funeraria->selectOptionListHtml("x_funeraria") ?>
    </select>
    <?= $Page->funeraria->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->funeraria->getErrorMessage() ?></div>
<?= $Page->funeraria->Lookup->getParamTag($Page, "p_x_funeraria") ?>
<script>
loadjs.ready("fview_expediente_funerariaedit", function() {
    var options = { name: "x_funeraria", selectId: "fview_expediente_funerariaedit_x_funeraria" };
    if (fview_expediente_funerariaedit.lists.funeraria?.lookupOptions.length) {
        options.data = { id: "x_funeraria", form: "fview_expediente_funerariaedit" };
    } else {
        options.ajax = { id: "x_funeraria", form: "fview_expediente_funerariaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.view_expediente_funeraria.fields.funeraria.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="view_expediente_funeraria" data-field="x_Norden" data-hidden="1" name="x_Norden" id="x_Norden" value="<?= HtmlEncode($Page->Norden->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fview_expediente_funerariaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fview_expediente_funerariaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("view_expediente_funeraria");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
