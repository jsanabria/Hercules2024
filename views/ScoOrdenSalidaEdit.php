<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenSalidaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_orden_salidaedit" id="fsco_orden_salidaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_salida: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_orden_salidaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_salidaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Norden_salida", [fields.Norden_salida.visible && fields.Norden_salida.required ? ew.Validators.required(fields.Norden_salida.caption) : null], fields.Norden_salida.isInvalid],
            ["grupo", [fields.grupo.visible && fields.grupo.required ? ew.Validators.required(fields.grupo.caption) : null], fields.grupo.isInvalid],
            ["conductor", [fields.conductor.visible && fields.conductor.required ? ew.Validators.required(fields.conductor.caption) : null], fields.conductor.isInvalid],
            ["acompanantes", [fields.acompanantes.visible && fields.acompanantes.required ? ew.Validators.required(fields.acompanantes.caption) : null, ew.Validators.integer], fields.acompanantes.isInvalid],
            ["placa", [fields.placa.visible && fields.placa.required ? ew.Validators.required(fields.placa.caption) : null], fields.placa.isInvalid],
            ["motivo", [fields.motivo.visible && fields.motivo.required ? ew.Validators.required(fields.motivo.caption) : null], fields.motivo.isInvalid],
            ["observaciones", [fields.observaciones.visible && fields.observaciones.required ? ew.Validators.required(fields.observaciones.caption) : null], fields.observaciones.isInvalid]
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
            "grupo": <?= $Page->grupo->toClientList($Page) ?>,
            "conductor": <?= $Page->conductor->toClientList($Page) ?>,
            "placa": <?= $Page->placa->toClientList($Page) ?>,
            "motivo": <?= $Page->motivo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_orden_salida">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Norden_salida->Visible) { // Norden_salida ?>
    <div id="r_Norden_salida"<?= $Page->Norden_salida->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_Norden_salida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Norden_salida->caption() ?><?= $Page->Norden_salida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Norden_salida->cellAttributes() ?>>
<span id="el_sco_orden_salida_Norden_salida">
<span<?= $Page->Norden_salida->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Norden_salida->getDisplayValue($Page->Norden_salida->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_salida" data-field="x_Norden_salida" data-hidden="1" name="x_Norden_salida" id="x_Norden_salida" value="<?= HtmlEncode($Page->Norden_salida->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
    <div id="r_grupo"<?= $Page->grupo->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_grupo" for="x_grupo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->grupo->caption() ?><?= $Page->grupo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->grupo->cellAttributes() ?>>
<span id="el_sco_orden_salida_grupo">
    <select
        id="x_grupo"
        name="x_grupo"
        class="form-control ew-select<?= $Page->grupo->isInvalidClass() ?>"
        data-select2-id="fsco_orden_salidaedit_x_grupo"
        data-table="sco_orden_salida"
        data-field="x_grupo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->grupo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->grupo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->grupo->editAttributes() ?>>
        <?= $Page->grupo->selectOptionListHtml("x_grupo") ?>
    </select>
    <?= $Page->grupo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->grupo->getErrorMessage() ?></div>
<?= $Page->grupo->Lookup->getParamTag($Page, "p_x_grupo") ?>
<script>
loadjs.ready("fsco_orden_salidaedit", function() {
    var options = { name: "x_grupo", selectId: "fsco_orden_salidaedit_x_grupo" };
    if (fsco_orden_salidaedit.lists.grupo?.lookupOptions.length) {
        options.data = { id: "x_grupo", form: "fsco_orden_salidaedit" };
    } else {
        options.ajax = { id: "x_grupo", form: "fsco_orden_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_orden_salida.fields.grupo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->conductor->Visible) { // conductor ?>
    <div id="r_conductor"<?= $Page->conductor->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_conductor" for="x_conductor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->conductor->caption() ?><?= $Page->conductor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->conductor->cellAttributes() ?>>
<span id="el_sco_orden_salida_conductor">
    <select
        id="x_conductor"
        name="x_conductor"
        class="form-control ew-select<?= $Page->conductor->isInvalidClass() ?>"
        data-select2-id="fsco_orden_salidaedit_x_conductor"
        data-table="sco_orden_salida"
        data-field="x_conductor"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->conductor->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->conductor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->conductor->getPlaceHolder()) ?>"
        <?= $Page->conductor->editAttributes() ?>>
        <?= $Page->conductor->selectOptionListHtml("x_conductor") ?>
    </select>
    <?= $Page->conductor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->conductor->getErrorMessage() ?></div>
<?= $Page->conductor->Lookup->getParamTag($Page, "p_x_conductor") ?>
<script>
loadjs.ready("fsco_orden_salidaedit", function() {
    var options = { name: "x_conductor", selectId: "fsco_orden_salidaedit_x_conductor" };
    if (fsco_orden_salidaedit.lists.conductor?.lookupOptions.length) {
        options.data = { id: "x_conductor", form: "fsco_orden_salidaedit" };
    } else {
        options.ajax = { id: "x_conductor", form: "fsco_orden_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_orden_salida.fields.conductor.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->acompanantes->Visible) { // acompanantes ?>
    <div id="r_acompanantes"<?= $Page->acompanantes->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_acompanantes" for="x_acompanantes" class="<?= $Page->LeftColumnClass ?>"><?= $Page->acompanantes->caption() ?><?= $Page->acompanantes->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->acompanantes->cellAttributes() ?>>
<span id="el_sco_orden_salida_acompanantes">
<input type="<?= $Page->acompanantes->getInputTextType() ?>" name="x_acompanantes" id="x_acompanantes" data-table="sco_orden_salida" data-field="x_acompanantes" value="<?= $Page->acompanantes->EditValue ?>" size="6" placeholder="<?= HtmlEncode($Page->acompanantes->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->acompanantes->formatPattern()) ?>"<?= $Page->acompanantes->editAttributes() ?> aria-describedby="x_acompanantes_help">
<?= $Page->acompanantes->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->acompanantes->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
    <div id="r_placa"<?= $Page->placa->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_placa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->placa->caption() ?><?= $Page->placa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->placa->cellAttributes() ?>>
<span id="el_sco_orden_salida_placa">
    <select
        id="x_placa"
        name="x_placa"
        class="form-control ew-select<?= $Page->placa->isInvalidClass() ?>"
        data-select2-id="fsco_orden_salidaedit_x_placa"
        data-table="sco_orden_salida"
        data-field="x_placa"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->placa->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->placa->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->placa->getPlaceHolder()) ?>"
        <?= $Page->placa->editAttributes() ?>>
        <?= $Page->placa->selectOptionListHtml("x_placa") ?>
    </select>
    <?= $Page->placa->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->placa->getErrorMessage() ?></div>
<?= $Page->placa->Lookup->getParamTag($Page, "p_x_placa") ?>
<script>
loadjs.ready("fsco_orden_salidaedit", function() {
    var options = { name: "x_placa", selectId: "fsco_orden_salidaedit_x_placa" };
    if (fsco_orden_salidaedit.lists.placa?.lookupOptions.length) {
        options.data = { id: "x_placa", form: "fsco_orden_salidaedit" };
    } else {
        options.ajax = { id: "x_placa", form: "fsco_orden_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_orden_salida.fields.placa.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <div id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_motivo" for="x_motivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motivo->caption() ?><?= $Page->motivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motivo->cellAttributes() ?>>
<span id="el_sco_orden_salida_motivo">
    <select
        id="x_motivo"
        name="x_motivo"
        class="form-select ew-select<?= $Page->motivo->isInvalidClass() ?>"
        <?php if (!$Page->motivo->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_salidaedit_x_motivo"
        <?php } ?>
        data-table="sco_orden_salida"
        data-field="x_motivo"
        data-value-separator="<?= $Page->motivo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->motivo->getPlaceHolder()) ?>"
        <?= $Page->motivo->editAttributes() ?>>
        <?= $Page->motivo->selectOptionListHtml("x_motivo") ?>
    </select>
    <?= $Page->motivo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->motivo->getErrorMessage() ?></div>
<?= $Page->motivo->Lookup->getParamTag($Page, "p_x_motivo") ?>
<?php if (!$Page->motivo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_salidaedit", function() {
    var options = { name: "x_motivo", selectId: "fsco_orden_salidaedit_x_motivo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_salidaedit.lists.motivo?.lookupOptions.length) {
        options.data = { id: "x_motivo", form: "fsco_orden_salidaedit" };
    } else {
        options.ajax = { id: "x_motivo", form: "fsco_orden_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_salida.fields.motivo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->observaciones->Visible) { // observaciones ?>
    <div id="r_observaciones"<?= $Page->observaciones->rowAttributes() ?>>
        <label id="elh_sco_orden_salida_observaciones" for="x_observaciones" class="<?= $Page->LeftColumnClass ?>"><?= $Page->observaciones->caption() ?><?= $Page->observaciones->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->observaciones->cellAttributes() ?>>
<span id="el_sco_orden_salida_observaciones">
<textarea data-table="sco_orden_salida" data-field="x_observaciones" name="x_observaciones" id="x_observaciones" cols="30" rows="4" placeholder="<?= HtmlEncode($Page->observaciones->getPlaceHolder()) ?>"<?= $Page->observaciones->editAttributes() ?> aria-describedby="x_observaciones_help"><?= $Page->observaciones->EditValue ?></textarea>
<?= $Page->observaciones->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->observaciones->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_orden_salidaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_orden_salidaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_orden_salida");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
