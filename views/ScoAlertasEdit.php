<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoAlertasEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_alertasedit" id="fsco_alertasedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_alertas: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_alertasedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_alertasedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["fecha_end", [fields.fecha_end.visible && fields.fecha_end.required ? ew.Validators.required(fields.fecha_end.caption) : null, ew.Validators.datetime(fields.fecha_end.clientFormatPattern)], fields.fecha_end.isInvalid],
            ["descripcion_corta", [fields.descripcion_corta.visible && fields.descripcion_corta.required ? ew.Validators.required(fields.descripcion_corta.caption) : null], fields.descripcion_corta.isInvalid],
            ["descripcion_larga", [fields.descripcion_larga.visible && fields.descripcion_larga.required ? ew.Validators.required(fields.descripcion_larga.caption) : null], fields.descripcion_larga.isInvalid],
            ["orden", [fields.orden.visible && fields.orden.required ? ew.Validators.required(fields.orden.caption) : null, ew.Validators.integer], fields.orden.isInvalid],
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
<input type="hidden" name="t" value="sco_alertas">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_alertas_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_alertas_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_alertas" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_end->Visible) { // fecha_end ?>
    <div id="r_fecha_end"<?= $Page->fecha_end->rowAttributes() ?>>
        <label id="elh_sco_alertas_fecha_end" for="x_fecha_end" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_end->caption() ?><?= $Page->fecha_end->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_end->cellAttributes() ?>>
<span id="el_sco_alertas_fecha_end">
<input type="<?= $Page->fecha_end->getInputTextType() ?>" name="x_fecha_end" id="x_fecha_end" data-table="sco_alertas" data-field="x_fecha_end" value="<?= $Page->fecha_end->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_end->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_end->formatPattern()) ?>"<?= $Page->fecha_end->editAttributes() ?> aria-describedby="x_fecha_end_help">
<?= $Page->fecha_end->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_end->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_corta->Visible) { // descripcion_corta ?>
    <div id="r_descripcion_corta"<?= $Page->descripcion_corta->rowAttributes() ?>>
        <label id="elh_sco_alertas_descripcion_corta" for="x_descripcion_corta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_corta->caption() ?><?= $Page->descripcion_corta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion_corta->cellAttributes() ?>>
<span id="el_sco_alertas_descripcion_corta">
<input type="<?= $Page->descripcion_corta->getInputTextType() ?>" name="x_descripcion_corta" id="x_descripcion_corta" data-table="sco_alertas" data-field="x_descripcion_corta" value="<?= $Page->descripcion_corta->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->descripcion_corta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion_corta->formatPattern()) ?>"<?= $Page->descripcion_corta->editAttributes() ?> aria-describedby="x_descripcion_corta_help">
<?= $Page->descripcion_corta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_corta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_larga->Visible) { // descripcion_larga ?>
    <div id="r_descripcion_larga"<?= $Page->descripcion_larga->rowAttributes() ?>>
        <label id="elh_sco_alertas_descripcion_larga" for="x_descripcion_larga" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_larga->caption() ?><?= $Page->descripcion_larga->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion_larga->cellAttributes() ?>>
<span id="el_sco_alertas_descripcion_larga">
<input type="<?= $Page->descripcion_larga->getInputTextType() ?>" name="x_descripcion_larga" id="x_descripcion_larga" data-table="sco_alertas" data-field="x_descripcion_larga" value="<?= $Page->descripcion_larga->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->descripcion_larga->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion_larga->formatPattern()) ?>"<?= $Page->descripcion_larga->editAttributes() ?> aria-describedby="x_descripcion_larga_help">
<?= $Page->descripcion_larga->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_larga->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
    <div id="r_orden"<?= $Page->orden->rowAttributes() ?>>
        <label id="elh_sco_alertas_orden" for="x_orden" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orden->caption() ?><?= $Page->orden->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->orden->cellAttributes() ?>>
<span id="el_sco_alertas_orden">
<input type="<?= $Page->orden->getInputTextType() ?>" name="x_orden" id="x_orden" data-table="sco_alertas" data-field="x_orden" value="<?= $Page->orden->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->orden->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->orden->formatPattern()) ?>"<?= $Page->orden->editAttributes() ?> aria-describedby="x_orden_help">
<?= $Page->orden->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orden->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_alertas_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_alertas_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_alertasedit_x_activo"
        <?php } ?>
        data-table="sco_alertas"
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
loadjs.ready("fsco_alertasedit", function() {
    var options = { name: "x_activo", selectId: "fsco_alertasedit_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_alertasedit.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_alertasedit" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_alertasedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_alertas.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_alertas" data-field="x_Nalerta" data-hidden="1" name="x_Nalerta" id="x_Nalerta" value="<?= HtmlEncode($Page->Nalerta->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_alertasedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_alertasedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_alertas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
