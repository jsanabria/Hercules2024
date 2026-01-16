<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewReclamoLapidaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fview_reclamo_lapidaedit" id="fview_reclamo_lapidaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_reclamo_lapida: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fview_reclamo_lapidaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_reclamo_lapidaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nreclamo", [fields.Nreclamo.visible && fields.Nreclamo.required ? ew.Validators.required(fields.Nreclamo.caption) : null], fields.Nreclamo.isInvalid],
            ["solicitante", [fields.solicitante.visible && fields.solicitante.required ? ew.Validators.required(fields.solicitante.caption) : null], fields.solicitante.isInvalid],
            ["parentesco", [fields.parentesco.visible && fields.parentesco.required ? ew.Validators.required(fields.parentesco.caption) : null], fields.parentesco.isInvalid],
            ["ci_difunto", [fields.ci_difunto.visible && fields.ci_difunto.required ? ew.Validators.required(fields.ci_difunto.caption) : null], fields.ci_difunto.isInvalid],
            ["nombre_difunto", [fields.nombre_difunto.visible && fields.nombre_difunto.required ? ew.Validators.required(fields.nombre_difunto.caption) : null], fields.nombre_difunto.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["registro", [fields.registro.visible && fields.registro.required ? ew.Validators.required(fields.registro.caption) : null], fields.registro.isInvalid],
            ["registra", [fields.registra.visible && fields.registra.required ? ew.Validators.required(fields.registra.caption) : null], fields.registra.isInvalid]
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
            "parentesco": <?= $Page->parentesco->toClientList($Page) ?>,
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="view_reclamo_lapida">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nreclamo->Visible) { // Nreclamo ?>
    <div id="r_Nreclamo"<?= $Page->Nreclamo->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_Nreclamo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nreclamo->caption() ?><?= $Page->Nreclamo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nreclamo->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_Nreclamo">
<span<?= $Page->Nreclamo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nreclamo->getDisplayValue($Page->Nreclamo->EditValue))) ?>"></span>
<input type="hidden" data-table="view_reclamo_lapida" data-field="x_Nreclamo" data-hidden="1" name="x_Nreclamo" id="x_Nreclamo" value="<?= HtmlEncode($Page->Nreclamo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <div id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_solicitante" for="x_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->solicitante->caption() ?><?= $Page->solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_solicitante">
<span<?= $Page->solicitante->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->solicitante->getDisplayValue($Page->solicitante->EditValue))) ?>"></span>
<input type="hidden" data-table="view_reclamo_lapida" data-field="x_solicitante" data-hidden="1" name="x_solicitante" id="x_solicitante" value="<?= HtmlEncode($Page->solicitante->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parentesco->Visible) { // parentesco ?>
    <div id="r_parentesco"<?= $Page->parentesco->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_parentesco" for="x_parentesco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parentesco->caption() ?><?= $Page->parentesco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parentesco->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_parentesco">
    <select
        id="x_parentesco"
        name="x_parentesco"
        class="form-select ew-select<?= $Page->parentesco->isInvalidClass() ?>"
        <?php if (!$Page->parentesco->IsNativeSelect) { ?>
        data-select2-id="fview_reclamo_lapidaedit_x_parentesco"
        <?php } ?>
        data-table="view_reclamo_lapida"
        data-field="x_parentesco"
        data-value-separator="<?= $Page->parentesco->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->parentesco->getPlaceHolder()) ?>"
        <?= $Page->parentesco->editAttributes() ?>>
        <?= $Page->parentesco->selectOptionListHtml("x_parentesco") ?>
    </select>
    <?= $Page->parentesco->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->parentesco->getErrorMessage() ?></div>
<?= $Page->parentesco->Lookup->getParamTag($Page, "p_x_parentesco") ?>
<?php if (!$Page->parentesco->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_reclamo_lapidaedit", function() {
    var options = { name: "x_parentesco", selectId: "fview_reclamo_lapidaedit_x_parentesco" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_reclamo_lapidaedit.lists.parentesco?.lookupOptions.length) {
        options.data = { id: "x_parentesco", form: "fview_reclamo_lapidaedit" };
    } else {
        options.ajax = { id: "x_parentesco", form: "fview_reclamo_lapidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_reclamo_lapida.fields.parentesco.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <div id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_ci_difunto" for="x_ci_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_difunto->caption() ?><?= $Page->ci_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_ci_difunto">
<span<?= $Page->ci_difunto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ci_difunto->getDisplayValue($Page->ci_difunto->EditValue))) ?>"></span>
<input type="hidden" data-table="view_reclamo_lapida" data-field="x_ci_difunto" data-hidden="1" name="x_ci_difunto" id="x_ci_difunto" value="<?= HtmlEncode($Page->ci_difunto->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
    <div id="r_nombre_difunto"<?= $Page->nombre_difunto->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_nombre_difunto" for="x_nombre_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_difunto->caption() ?><?= $Page->nombre_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_difunto->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_nombre_difunto">
<input type="<?= $Page->nombre_difunto->getInputTextType() ?>" name="x_nombre_difunto" id="x_nombre_difunto" data-table="view_reclamo_lapida" data-field="x_nombre_difunto" value="<?= $Page->nombre_difunto->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nombre_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_difunto->formatPattern()) ?>"<?= $Page->nombre_difunto->editAttributes() ?> aria-describedby="x_nombre_difunto_help">
<?= $Page->nombre_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-control ew-select<?= $Page->tipo->isInvalidClass() ?>"
        data-select2-id="fview_reclamo_lapidaedit_x_tipo"
        data-table="view_reclamo_lapida"
        data-field="x_tipo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->tipo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<script>
loadjs.ready("fview_reclamo_lapidaedit", function() {
    var options = { name: "x_tipo", selectId: "fview_reclamo_lapidaedit_x_tipo" };
    if (fview_reclamo_lapidaedit.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fview_reclamo_lapidaedit" };
    } else {
        options.ajax = { id: "x_tipo", form: "fview_reclamo_lapidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.view_reclamo_lapida.fields.tipo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
    <div id="r_registro"<?= $Page->registro->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_registro" for="x_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->registro->caption() ?><?= $Page->registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->registro->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_registro">
<span<?= $Page->registro->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->registro->getDisplayValue($Page->registro->EditValue))) ?>"></span>
<input type="hidden" data-table="view_reclamo_lapida" data-field="x_registro" data-hidden="1" name="x_registro" id="x_registro" value="<?= HtmlEncode($Page->registro->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->registra->Visible) { // registra ?>
    <div id="r_registra"<?= $Page->registra->rowAttributes() ?>>
        <label id="elh_view_reclamo_lapida_registra" for="x_registra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->registra->caption() ?><?= $Page->registra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->registra->cellAttributes() ?>>
<span id="el_view_reclamo_lapida_registra">
<span<?= $Page->registra->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->registra->getDisplayValue($Page->registra->EditValue) ?></span></span>
<input type="hidden" data-table="view_reclamo_lapida" data-field="x_registra" data-hidden="1" name="x_registra" id="x_registra" value="<?= HtmlEncode($Page->registra->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fview_reclamo_lapidaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fview_reclamo_lapidaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("view_reclamo_lapida");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
