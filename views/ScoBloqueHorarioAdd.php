<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoBloqueHorarioAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_bloque_horario: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_bloque_horarioadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_bloque_horarioadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["hora", [fields.hora.visible && fields.hora.required ? ew.Validators.required(fields.hora.caption) : null], fields.hora.isInvalid],
            ["bloque", [fields.bloque.visible && fields.bloque.required ? ew.Validators.required(fields.bloque.caption) : null], fields.bloque.isInvalid]
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
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "hora": <?= $Page->hora->toClientList($Page) ?>,
            "bloque": <?= $Page->bloque->toClientList($Page) ?>,
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
<form name="fsco_bloque_horarioadd" id="fsco_bloque_horarioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_bloque_horario">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <div id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <label id="elh_sco_bloque_horario_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_bloque_horario_servicio_tipo">
    <select
        id="x_servicio_tipo"
        name="x_servicio_tipo"
        class="form-select ew-select<?= $Page->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_bloque_horarioadd_x_servicio_tipo"
        <?php } ?>
        data-table="sco_bloque_horario"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Page->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_tipo->getPlaceHolder()) ?>"
        <?= $Page->servicio_tipo->editAttributes() ?>>
        <?= $Page->servicio_tipo->selectOptionListHtml("x_servicio_tipo") ?>
    </select>
    <?= $Page->servicio_tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio_tipo->getErrorMessage() ?></div>
<?= $Page->servicio_tipo->Lookup->getParamTag($Page, "p_x_servicio_tipo") ?>
<?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_bloque_horarioadd", function() {
    var options = { name: "x_servicio_tipo", selectId: "fsco_bloque_horarioadd_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_bloque_horarioadd.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fsco_bloque_horarioadd" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fsco_bloque_horarioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_bloque_horario.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora->Visible) { // hora ?>
    <div id="r_hora"<?= $Page->hora->rowAttributes() ?>>
        <label id="elh_sco_bloque_horario_hora" for="x_hora" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora->caption() ?><?= $Page->hora->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora->cellAttributes() ?>>
<span id="el_sco_bloque_horario_hora">
    <select
        id="x_hora"
        name="x_hora"
        class="form-select ew-select<?= $Page->hora->isInvalidClass() ?>"
        <?php if (!$Page->hora->IsNativeSelect) { ?>
        data-select2-id="fsco_bloque_horarioadd_x_hora"
        <?php } ?>
        data-table="sco_bloque_horario"
        data-field="x_hora"
        data-value-separator="<?= $Page->hora->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->hora->getPlaceHolder()) ?>"
        <?= $Page->hora->editAttributes() ?>>
        <?= $Page->hora->selectOptionListHtml("x_hora") ?>
    </select>
    <?= $Page->hora->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->hora->getErrorMessage() ?></div>
<?php if (!$Page->hora->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_bloque_horarioadd", function() {
    var options = { name: "x_hora", selectId: "fsco_bloque_horarioadd_x_hora" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_bloque_horarioadd.lists.hora?.lookupOptions.length) {
        options.data = { id: "x_hora", form: "fsco_bloque_horarioadd" };
    } else {
        options.ajax = { id: "x_hora", form: "fsco_bloque_horarioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_bloque_horario.fields.hora.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bloque->Visible) { // bloque ?>
    <div id="r_bloque"<?= $Page->bloque->rowAttributes() ?>>
        <label id="elh_sco_bloque_horario_bloque" for="x_bloque" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bloque->caption() ?><?= $Page->bloque->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->bloque->cellAttributes() ?>>
<span id="el_sco_bloque_horario_bloque">
    <select
        id="x_bloque"
        name="x_bloque"
        class="form-select ew-select<?= $Page->bloque->isInvalidClass() ?>"
        <?php if (!$Page->bloque->IsNativeSelect) { ?>
        data-select2-id="fsco_bloque_horarioadd_x_bloque"
        <?php } ?>
        data-table="sco_bloque_horario"
        data-field="x_bloque"
        data-value-separator="<?= $Page->bloque->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->bloque->getPlaceHolder()) ?>"
        <?= $Page->bloque->editAttributes() ?>>
        <?= $Page->bloque->selectOptionListHtml("x_bloque") ?>
    </select>
    <?= $Page->bloque->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->bloque->getErrorMessage() ?></div>
<?php if (!$Page->bloque->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_bloque_horarioadd", function() {
    var options = { name: "x_bloque", selectId: "fsco_bloque_horarioadd_x_bloque" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_bloque_horarioadd.lists.bloque?.lookupOptions.length) {
        options.data = { id: "x_bloque", form: "fsco_bloque_horarioadd" };
    } else {
        options.ajax = { id: "x_bloque", form: "fsco_bloque_horarioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_bloque_horario.fields.bloque.selectOptions);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_bloque_horarioadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_bloque_horarioadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_bloque_horario");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
