<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_costos_tarifaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["localidad", [fields.localidad.visible && fields.localidad.required ? ew.Validators.required(fields.localidad.caption) : null], fields.localidad.isInvalid],
            ["tipo_servicio", [fields.tipo_servicio.visible && fields.tipo_servicio.required ? ew.Validators.required(fields.tipo_servicio.caption) : null], fields.tipo_servicio.isInvalid],
            ["horas", [fields.horas.visible && fields.horas.required ? ew.Validators.required(fields.horas.caption) : null], fields.horas.isInvalid],
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
            "localidad": <?= $Page->localidad->toClientList($Page) ?>,
            "tipo_servicio": <?= $Page->tipo_servicio->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_costos_tarifaadd" id="fsco_costos_tarifaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos_tarifa">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->localidad->Visible) { // localidad ?>
    <div id="r_localidad"<?= $Page->localidad->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_localidad" for="x_localidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->localidad->caption() ?><?= $Page->localidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->localidad->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_localidad">
    <select
        id="x_localidad"
        name="x_localidad"
        class="form-select ew-select<?= $Page->localidad->isInvalidClass() ?>"
        <?php if (!$Page->localidad->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifaadd_x_localidad"
        <?php } ?>
        data-table="sco_costos_tarifa"
        data-field="x_localidad"
        data-value-separator="<?= $Page->localidad->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->localidad->getPlaceHolder()) ?>"
        <?= $Page->localidad->editAttributes() ?>>
        <?= $Page->localidad->selectOptionListHtml("x_localidad") ?>
    </select>
    <?= $Page->localidad->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->localidad->getErrorMessage() ?></div>
<?= $Page->localidad->Lookup->getParamTag($Page, "p_x_localidad") ?>
<?php if (!$Page->localidad->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifaadd", function() {
    var options = { name: "x_localidad", selectId: "fsco_costos_tarifaadd_x_localidad" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifaadd.lists.localidad?.lookupOptions.length) {
        options.data = { id: "x_localidad", form: "fsco_costos_tarifaadd" };
    } else {
        options.ajax = { id: "x_localidad", form: "fsco_costos_tarifaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa.fields.localidad.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_servicio->Visible) { // tipo_servicio ?>
    <div id="r_tipo_servicio"<?= $Page->tipo_servicio->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_tipo_servicio" for="x_tipo_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_servicio->caption() ?><?= $Page->tipo_servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_servicio->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_tipo_servicio">
    <select
        id="x_tipo_servicio"
        name="x_tipo_servicio"
        class="form-select ew-select<?= $Page->tipo_servicio->isInvalidClass() ?>"
        <?php if (!$Page->tipo_servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifaadd_x_tipo_servicio"
        <?php } ?>
        data-table="sco_costos_tarifa"
        data-field="x_tipo_servicio"
        data-value-separator="<?= $Page->tipo_servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_servicio->getPlaceHolder()) ?>"
        <?= $Page->tipo_servicio->editAttributes() ?>>
        <?= $Page->tipo_servicio->selectOptionListHtml("x_tipo_servicio") ?>
    </select>
    <?= $Page->tipo_servicio->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_servicio->getErrorMessage() ?></div>
<?= $Page->tipo_servicio->Lookup->getParamTag($Page, "p_x_tipo_servicio") ?>
<?php if (!$Page->tipo_servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifaadd", function() {
    var options = { name: "x_tipo_servicio", selectId: "fsco_costos_tarifaadd_x_tipo_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifaadd.lists.tipo_servicio?.lookupOptions.length) {
        options.data = { id: "x_tipo_servicio", form: "fsco_costos_tarifaadd" };
    } else {
        options.ajax = { id: "x_tipo_servicio", form: "fsco_costos_tarifaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa.fields.tipo_servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->horas->Visible) { // horas ?>
    <div id="r_horas"<?= $Page->horas->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_horas" for="x_horas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->horas->caption() ?><?= $Page->horas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->horas->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_horas">
    <select
        id="x_horas"
        name="x_horas"
        class="form-select ew-select<?= $Page->horas->isInvalidClass() ?>"
        <?php if (!$Page->horas->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifaadd_x_horas"
        <?php } ?>
        data-table="sco_costos_tarifa"
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
loadjs.ready("fsco_costos_tarifaadd", function() {
    var options = { name: "x_horas", selectId: "fsco_costos_tarifaadd_x_horas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifaadd.lists.horas?.lookupOptions.length) {
        options.data = { id: "x_horas", form: "fsco_costos_tarifaadd" };
    } else {
        options.ajax = { id: "x_horas", form: "fsco_costos_tarifaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa.fields.horas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifaadd_x_activo"
        <?php } ?>
        data-table="sco_costos_tarifa"
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
loadjs.ready("fsco_costos_tarifaadd", function() {
    var options = { name: "x_activo", selectId: "fsco_costos_tarifaadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifaadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_costos_tarifaadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_costos_tarifaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_costos_tarifa_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_costos_tarifa_detalle->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_costos_tarifa_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoCostosTarifaDetalleGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_costos_tarifaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_costos_tarifaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_costos_tarifa");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
