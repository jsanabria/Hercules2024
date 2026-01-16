<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoTarifaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_tarifaedit" id="fsco_tarifaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_tarifa: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_tarifaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_tarifaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["horas", [fields.horas.visible && fields.horas.required ? ew.Validators.required(fields.horas.caption) : null], fields.horas.isInvalid],
            ["precio", [fields.precio.visible && fields.precio.required ? ew.Validators.required(fields.precio.caption) : null, ew.Validators.float], fields.precio.isInvalid],
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
            "horas": <?= $Page->horas->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_tarifa">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_tarifa_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_tarifa_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo->getDisplayValue($Page->tipo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_tarifa" data-field="x_tipo" data-hidden="1" name="x_tipo" id="x_tipo" value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <div id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <label id="elh_sco_tarifa_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_tarifa_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->servicio->getDisplayValue($Page->servicio->EditValue) ?></span></span>
<input type="hidden" data-table="sco_tarifa" data-field="x_servicio" data-hidden="1" name="x_servicio" id="x_servicio" value="<?= HtmlEncode($Page->servicio->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
    <div id="r_horas"<?= $Page->horas->rowAttributes() ?>>
        <label id="elh_sco_tarifa_horas" for="x_horas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->horas->caption() ?><?= $Page->horas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->horas->cellAttributes() ?>>
<span id="el_sco_tarifa_horas">
    <select
        id="x_horas"
        name="x_horas"
        class="form-select ew-select<?= $Page->horas->isInvalidClass() ?>"
        <?php if (!$Page->horas->IsNativeSelect) { ?>
        data-select2-id="fsco_tarifaedit_x_horas"
        <?php } ?>
        data-table="sco_tarifa"
        data-field="x_horas"
        data-value-separator="<?= $Page->horas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->horas->getPlaceHolder()) ?>"
        <?= $Page->horas->editAttributes() ?>>
        <?= $Page->horas->selectOptionListHtml("x_horas") ?>
    </select>
    <?= $Page->horas->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->horas->getErrorMessage() ?></div>
<?= $Page->horas->Lookup->getParamTag($Page, "p_x_horas") ?>
<?php if (!$Page->horas->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_tarifaedit", function() {
    var options = { name: "x_horas", selectId: "fsco_tarifaedit_x_horas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_tarifaedit.lists.horas?.lookupOptions.length) {
        options.data = { id: "x_horas", form: "fsco_tarifaedit" };
    } else {
        options.ajax = { id: "x_horas", form: "fsco_tarifaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_tarifa.fields.horas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precio->Visible) { // precio ?>
    <div id="r_precio"<?= $Page->precio->rowAttributes() ?>>
        <label id="elh_sco_tarifa_precio" for="x_precio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precio->caption() ?><?= $Page->precio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precio->cellAttributes() ?>>
<span id="el_sco_tarifa_precio">
<input type="<?= $Page->precio->getInputTextType() ?>" name="x_precio" id="x_precio" data-table="sco_tarifa" data-field="x_precio" value="<?= $Page->precio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->precio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio->formatPattern()) ?>"<?= $Page->precio->editAttributes() ?> aria-describedby="x_precio_help">
<?= $Page->precio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_tarifa_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_tarifa_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_tarifaedit_x_activo"
        <?php } ?>
        data-table="sco_tarifa"
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
loadjs.ready("fsco_tarifaedit", function() {
    var options = { name: "x_activo", selectId: "fsco_tarifaedit_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_tarifaedit.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_tarifaedit" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_tarifaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_tarifa.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_tarifa" data-field="x_Ntarifa" data-hidden="1" name="x_Ntarifa" id="x_Ntarifa" value="<?= HtmlEncode($Page->Ntarifa->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_tarifaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_tarifaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_tarifa");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
