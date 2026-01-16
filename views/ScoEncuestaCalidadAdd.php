<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEncuestaCalidadAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_encuesta_calidad: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_encuesta_calidadadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_encuesta_calidadadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["pregunta", [fields.pregunta.visible && fields.pregunta.required ? ew.Validators.required(fields.pregunta.caption) : null], fields.pregunta.isInvalid],
            ["respuesta", [fields.respuesta.visible && fields.respuesta.required ? ew.Validators.required(fields.respuesta.caption) : null], fields.respuesta.isInvalid],
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_encuesta_calidadadd" id="fsco_encuesta_calidadadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_encuesta_calidad">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_encuesta_calidad_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_encuesta_calidad_tipo">
<template id="tp_x_tipo">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_encuesta_calidad" data-field="x_tipo" name="x_tipo" id="x_tipo"<?= $Page->tipo->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_tipo" class="ew-item-list"></div>
<selection-list hidden
    id="x_tipo"
    name="x_tipo"
    value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_tipo"
    data-target="dsl_x_tipo"
    data-repeatcolumn="0"
    class="form-control<?= $Page->tipo->isInvalidClass() ?>"
    data-table="sco_encuesta_calidad"
    data-field="x_tipo"
    data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
    <?= $Page->tipo->editAttributes() ?>></selection-list>
<?= $Page->tipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pregunta->Visible) { // pregunta ?>
    <div id="r_pregunta"<?= $Page->pregunta->rowAttributes() ?>>
        <label id="elh_sco_encuesta_calidad_pregunta" for="x_pregunta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pregunta->caption() ?><?= $Page->pregunta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->pregunta->cellAttributes() ?>>
<span id="el_sco_encuesta_calidad_pregunta">
<textarea data-table="sco_encuesta_calidad" data-field="x_pregunta" name="x_pregunta" id="x_pregunta" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->pregunta->getPlaceHolder()) ?>"<?= $Page->pregunta->editAttributes() ?> aria-describedby="x_pregunta_help"><?= $Page->pregunta->EditValue ?></textarea>
<?= $Page->pregunta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pregunta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->respuesta->Visible) { // respuesta ?>
    <div id="r_respuesta"<?= $Page->respuesta->rowAttributes() ?>>
        <label id="elh_sco_encuesta_calidad_respuesta" for="x_respuesta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->respuesta->caption() ?><?= $Page->respuesta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->respuesta->cellAttributes() ?>>
<span id="el_sco_encuesta_calidad_respuesta">
<input type="<?= $Page->respuesta->getInputTextType() ?>" name="x_respuesta" id="x_respuesta" data-table="sco_encuesta_calidad" data-field="x_respuesta" value="<?= $Page->respuesta->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->respuesta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->respuesta->formatPattern()) ?>"<?= $Page->respuesta->editAttributes() ?> aria-describedby="x_respuesta_help">
<?= $Page->respuesta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->respuesta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_encuesta_calidad_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_encuesta_calidad_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_encuesta_calidadadd_x_activo"
        <?php } ?>
        data-table="sco_encuesta_calidad"
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
loadjs.ready("fsco_encuesta_calidadadd", function() {
    var options = { name: "x_activo", selectId: "fsco_encuesta_calidadadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_encuesta_calidadadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_encuesta_calidadadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_encuesta_calidadadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_encuesta_calidad.fields.activo.selectOptions);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_encuesta_calidadadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_encuesta_calidadadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_encuesta_calidad");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
