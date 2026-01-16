<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_flotaedit" id="fsco_flotaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_flotaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flotaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["tipo_flota", [fields.tipo_flota.visible && fields.tipo_flota.required ? ew.Validators.required(fields.tipo_flota.caption) : null], fields.tipo_flota.isInvalid],
            ["marca", [fields.marca.visible && fields.marca.required ? ew.Validators.required(fields.marca.caption) : null], fields.marca.isInvalid],
            ["modelo", [fields.modelo.visible && fields.modelo.required ? ew.Validators.required(fields.modelo.caption) : null], fields.modelo.isInvalid],
            ["placa", [fields.placa.visible && fields.placa.required ? ew.Validators.required(fields.placa.caption) : null], fields.placa.isInvalid],
            ["color", [fields.color.visible && fields.color.required ? ew.Validators.required(fields.color.caption) : null], fields.color.isInvalid],
            ["anho", [fields.anho.visible && fields.anho.required ? ew.Validators.required(fields.anho.caption) : null, ew.Validators.integer], fields.anho.isInvalid],
            ["serial_carroceria", [fields.serial_carroceria.visible && fields.serial_carroceria.required ? ew.Validators.required(fields.serial_carroceria.caption) : null], fields.serial_carroceria.isInvalid],
            ["serial_motor", [fields.serial_motor.visible && fields.serial_motor.required ? ew.Validators.required(fields.serial_motor.caption) : null], fields.serial_motor.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["conductor", [fields.conductor.visible && fields.conductor.required ? ew.Validators.required(fields.conductor.caption) : null], fields.conductor.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
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
            "tipo_flota": <?= $Page->tipo_flota->toClientList($Page) ?>,
            "marca": <?= $Page->marca->toClientList($Page) ?>,
            "modelo": <?= $Page->modelo->toClientList($Page) ?>,
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_flota">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tipo_flota->Visible) { // tipo_flota ?>
    <div id="r_tipo_flota"<?= $Page->tipo_flota->rowAttributes() ?>>
        <label id="elh_sco_flota_tipo_flota" for="x_tipo_flota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_flota->caption() ?><?= $Page->tipo_flota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_flota->cellAttributes() ?>>
<span id="el_sco_flota_tipo_flota">
    <select
        id="x_tipo_flota"
        name="x_tipo_flota"
        class="form-control ew-select<?= $Page->tipo_flota->isInvalidClass() ?>"
        data-select2-id="fsco_flotaedit_x_tipo_flota"
        data-table="sco_flota"
        data-field="x_tipo_flota"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->tipo_flota->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->tipo_flota->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_flota->getPlaceHolder()) ?>"
        <?= $Page->tipo_flota->editAttributes() ?>>
        <?= $Page->tipo_flota->selectOptionListHtml("x_tipo_flota") ?>
    </select>
    <?= $Page->tipo_flota->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_flota->getErrorMessage() ?></div>
<?= $Page->tipo_flota->Lookup->getParamTag($Page, "p_x_tipo_flota") ?>
<script>
loadjs.ready("fsco_flotaedit", function() {
    var options = { name: "x_tipo_flota", selectId: "fsco_flotaedit_x_tipo_flota" };
    if (fsco_flotaedit.lists.tipo_flota?.lookupOptions.length) {
        options.data = { id: "x_tipo_flota", form: "fsco_flotaedit" };
    } else {
        options.ajax = { id: "x_tipo_flota", form: "fsco_flotaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_flota.fields.tipo_flota.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marca->Visible) { // marca ?>
    <div id="r_marca"<?= $Page->marca->rowAttributes() ?>>
        <label id="elh_sco_flota_marca" for="x_marca" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marca->caption() ?><?= $Page->marca->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marca->cellAttributes() ?>>
<span id="el_sco_flota_marca">
    <select
        id="x_marca"
        name="x_marca"
        class="form-control ew-select<?= $Page->marca->isInvalidClass() ?>"
        data-select2-id="fsco_flotaedit_x_marca"
        data-table="sco_flota"
        data-field="x_marca"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->marca->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->marca->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->marca->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->marca->editAttributes() ?>>
        <?= $Page->marca->selectOptionListHtml("x_marca") ?>
    </select>
    <?= $Page->marca->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->marca->getErrorMessage() ?></div>
<?= $Page->marca->Lookup->getParamTag($Page, "p_x_marca") ?>
<script>
loadjs.ready("fsco_flotaedit", function() {
    var options = { name: "x_marca", selectId: "fsco_flotaedit_x_marca" };
    if (fsco_flotaedit.lists.marca?.lookupOptions.length) {
        options.data = { id: "x_marca", form: "fsco_flotaedit" };
    } else {
        options.ajax = { id: "x_marca", form: "fsco_flotaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_flota.fields.marca.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modelo->Visible) { // modelo ?>
    <div id="r_modelo"<?= $Page->modelo->rowAttributes() ?>>
        <label id="elh_sco_flota_modelo" for="x_modelo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modelo->caption() ?><?= $Page->modelo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modelo->cellAttributes() ?>>
<span id="el_sco_flota_modelo">
    <select
        id="x_modelo"
        name="x_modelo"
        class="form-control ew-select<?= $Page->modelo->isInvalidClass() ?>"
        data-select2-id="fsco_flotaedit_x_modelo"
        data-table="sco_flota"
        data-field="x_modelo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->modelo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->modelo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->modelo->getPlaceHolder()) ?>"
        <?= $Page->modelo->editAttributes() ?>>
        <?= $Page->modelo->selectOptionListHtml("x_modelo") ?>
    </select>
    <?= $Page->modelo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->modelo->getErrorMessage() ?></div>
<?= $Page->modelo->Lookup->getParamTag($Page, "p_x_modelo") ?>
<script>
loadjs.ready("fsco_flotaedit", function() {
    var options = { name: "x_modelo", selectId: "fsco_flotaedit_x_modelo" };
    if (fsco_flotaedit.lists.modelo?.lookupOptions.length) {
        options.data = { id: "x_modelo", form: "fsco_flotaedit" };
    } else {
        options.ajax = { id: "x_modelo", form: "fsco_flotaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_flota.fields.modelo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->placa->Visible) { // placa ?>
    <div id="r_placa"<?= $Page->placa->rowAttributes() ?>>
        <label id="elh_sco_flota_placa" for="x_placa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->placa->caption() ?><?= $Page->placa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->placa->cellAttributes() ?>>
<span id="el_sco_flota_placa">
<input type="<?= $Page->placa->getInputTextType() ?>" name="x_placa" id="x_placa" data-table="sco_flota" data-field="x_placa" value="<?= $Page->placa->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->placa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->placa->formatPattern()) ?>"<?= $Page->placa->editAttributes() ?> aria-describedby="x_placa_help">
<?= $Page->placa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->placa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <div id="r_color"<?= $Page->color->rowAttributes() ?>>
        <label id="elh_sco_flota_color" for="x_color" class="<?= $Page->LeftColumnClass ?>"><?= $Page->color->caption() ?><?= $Page->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->color->cellAttributes() ?>>
<span id="el_sco_flota_color">
<input type="<?= $Page->color->getInputTextType() ?>" name="x_color" id="x_color" data-table="sco_flota" data-field="x_color" value="<?= $Page->color->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->color->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->color->formatPattern()) ?>"<?= $Page->color->editAttributes() ?> aria-describedby="x_color_help">
<?= $Page->color->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->color->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->anho->Visible) { // anho ?>
    <div id="r_anho"<?= $Page->anho->rowAttributes() ?>>
        <label id="elh_sco_flota_anho" for="x_anho" class="<?= $Page->LeftColumnClass ?>"><?= $Page->anho->caption() ?><?= $Page->anho->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->anho->cellAttributes() ?>>
<span id="el_sco_flota_anho">
<input type="<?= $Page->anho->getInputTextType() ?>" name="x_anho" id="x_anho" data-table="sco_flota" data-field="x_anho" value="<?= $Page->anho->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->anho->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->anho->formatPattern()) ?>"<?= $Page->anho->editAttributes() ?> aria-describedby="x_anho_help">
<?= $Page->anho->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->anho->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serial_carroceria->Visible) { // serial_carroceria ?>
    <div id="r_serial_carroceria"<?= $Page->serial_carroceria->rowAttributes() ?>>
        <label id="elh_sco_flota_serial_carroceria" for="x_serial_carroceria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serial_carroceria->caption() ?><?= $Page->serial_carroceria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serial_carroceria->cellAttributes() ?>>
<span id="el_sco_flota_serial_carroceria">
<input type="<?= $Page->serial_carroceria->getInputTextType() ?>" name="x_serial_carroceria" id="x_serial_carroceria" data-table="sco_flota" data-field="x_serial_carroceria" value="<?= $Page->serial_carroceria->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->serial_carroceria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serial_carroceria->formatPattern()) ?>"<?= $Page->serial_carroceria->editAttributes() ?> aria-describedby="x_serial_carroceria_help">
<?= $Page->serial_carroceria->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serial_carroceria->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->serial_motor->Visible) { // serial_motor ?>
    <div id="r_serial_motor"<?= $Page->serial_motor->rowAttributes() ?>>
        <label id="elh_sco_flota_serial_motor" for="x_serial_motor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->serial_motor->caption() ?><?= $Page->serial_motor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->serial_motor->cellAttributes() ?>>
<span id="el_sco_flota_serial_motor">
<input type="<?= $Page->serial_motor->getInputTextType() ?>" name="x_serial_motor" id="x_serial_motor" data-table="sco_flota" data-field="x_serial_motor" value="<?= $Page->serial_motor->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->serial_motor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->serial_motor->formatPattern()) ?>"<?= $Page->serial_motor->editAttributes() ?> aria-describedby="x_serial_motor_help">
<?= $Page->serial_motor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->serial_motor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_flota_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_flota_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_flotaedit_x_tipo"
        <?php } ?>
        data-table="sco_flota"
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
loadjs.ready("fsco_flotaedit", function() {
    var options = { name: "x_tipo", selectId: "fsco_flotaedit_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flotaedit.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_flotaedit" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_flotaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->conductor->Visible) { // conductor ?>
    <div id="r_conductor"<?= $Page->conductor->rowAttributes() ?>>
        <label id="elh_sco_flota_conductor" for="x_conductor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->conductor->caption() ?><?= $Page->conductor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->conductor->cellAttributes() ?>>
<span id="el_sco_flota_conductor">
<input type="<?= $Page->conductor->getInputTextType() ?>" name="x_conductor" id="x_conductor" data-table="sco_flota" data-field="x_conductor" value="<?= $Page->conductor->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->conductor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->conductor->formatPattern()) ?>"<?= $Page->conductor->editAttributes() ?> aria-describedby="x_conductor_help">
<?= $Page->conductor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->conductor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_flota_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_flota_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_flotaedit_x_activo"
        <?php } ?>
        data-table="sco_flota"
        data-field="x_activo"
        data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->activo->getPlaceHolder()) ?>"
        <?= $Page->activo->editAttributes() ?>>
        <?= $Page->activo->selectOptionListHtml("x_activo") ?>
    </select>
    <?= $Page->activo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
<?php if (!$Page->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flotaedit", function() {
    var options = { name: "x_activo", selectId: "fsco_flotaedit_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flotaedit.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_flotaedit" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_flotaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_flota" data-field="x_Nflota" data-hidden="1" name="x_Nflota" id="x_Nflota" value="<?= HtmlEncode($Page->Nflota->CurrentValue) ?>">
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_flotaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_flotaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_flota");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
