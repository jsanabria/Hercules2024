<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReclamoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_reclamoedit" id="fsco_reclamoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_reclamo: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_reclamoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reclamoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nreclamo", [fields.Nreclamo.visible && fields.Nreclamo.required ? ew.Validators.required(fields.Nreclamo.caption) : null], fields.Nreclamo.isInvalid],
            ["solicitante", [fields.solicitante.visible && fields.solicitante.required ? ew.Validators.required(fields.solicitante.caption) : null], fields.solicitante.isInvalid],
            ["telefono1", [fields.telefono1.visible && fields.telefono1.required ? ew.Validators.required(fields.telefono1.caption) : null], fields.telefono1.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["ci_difunto", [fields.ci_difunto.visible && fields.ci_difunto.required ? ew.Validators.required(fields.ci_difunto.caption) : null], fields.ci_difunto.isInvalid],
            ["nombre_difunto", [fields.nombre_difunto.visible && fields.nombre_difunto.required ? ew.Validators.required(fields.nombre_difunto.caption) : null], fields.nombre_difunto.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["comentario", [fields.comentario.visible && fields.comentario.required ? ew.Validators.required(fields.comentario.caption) : null], fields.comentario.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["sub_seccion", [fields.sub_seccion.visible && fields.sub_seccion.required ? ew.Validators.required(fields.sub_seccion.caption) : null], fields.sub_seccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["boveda", [fields.boveda.visible && fields.boveda.required ? ew.Validators.required(fields.boveda.caption) : null], fields.boveda.isInvalid],
            ["parentesco", [fields.parentesco.visible && fields.parentesco.required ? ew.Validators.required(fields.parentesco.caption) : null], fields.parentesco.isInvalid]
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
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
            "parentesco": <?= $Page->parentesco->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_reclamo">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nreclamo->Visible) { // Nreclamo ?>
    <div id="r_Nreclamo"<?= $Page->Nreclamo->rowAttributes() ?>>
        <label id="elh_sco_reclamo_Nreclamo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nreclamo->caption() ?><?= $Page->Nreclamo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nreclamo->cellAttributes() ?>>
<span id="el_sco_reclamo_Nreclamo">
<span<?= $Page->Nreclamo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nreclamo->getDisplayValue($Page->Nreclamo->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_reclamo" data-field="x_Nreclamo" data-hidden="1" name="x_Nreclamo" id="x_Nreclamo" value="<?= HtmlEncode($Page->Nreclamo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <div id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <label id="elh_sco_reclamo_solicitante" for="x_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->solicitante->caption() ?><?= $Page->solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_sco_reclamo_solicitante">
<input type="<?= $Page->solicitante->getInputTextType() ?>" name="x_solicitante" id="x_solicitante" data-table="sco_reclamo" data-field="x_solicitante" value="<?= $Page->solicitante->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->solicitante->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->solicitante->formatPattern()) ?>"<?= $Page->solicitante->editAttributes() ?> aria-describedby="x_solicitante_help">
<?= $Page->solicitante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->solicitante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <div id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <label id="elh_sco_reclamo_telefono1" for="x_telefono1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono1->caption() ?><?= $Page->telefono1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_reclamo_telefono1">
<input type="<?= $Page->telefono1->getInputTextType() ?>" name="x_telefono1" id="x_telefono1" data-table="sco_reclamo" data-field="x_telefono1" value="<?= $Page->telefono1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono1->formatPattern()) ?>"<?= $Page->telefono1->editAttributes() ?> aria-describedby="x_telefono1_help">
<?= $Page->telefono1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_reclamo_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_reclamo_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_reclamo" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_reclamo__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_reclamo__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_reclamo" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="120" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <div id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <label id="elh_sco_reclamo_ci_difunto" for="x_ci_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_difunto->caption() ?><?= $Page->ci_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_reclamo_ci_difunto">
<input type="<?= $Page->ci_difunto->getInputTextType() ?>" name="x_ci_difunto" id="x_ci_difunto" data-table="sco_reclamo" data-field="x_ci_difunto" value="<?= $Page->ci_difunto->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->ci_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_difunto->formatPattern()) ?>"<?= $Page->ci_difunto->editAttributes() ?> aria-describedby="x_ci_difunto_help">
<?= $Page->ci_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_difunto->Visible) { // nombre_difunto ?>
    <div id="r_nombre_difunto"<?= $Page->nombre_difunto->rowAttributes() ?>>
        <label id="elh_sco_reclamo_nombre_difunto" for="x_nombre_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_difunto->caption() ?><?= $Page->nombre_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_difunto->cellAttributes() ?>>
<span id="el_sco_reclamo_nombre_difunto">
<input type="<?= $Page->nombre_difunto->getInputTextType() ?>" name="x_nombre_difunto" id="x_nombre_difunto" data-table="sco_reclamo" data-field="x_nombre_difunto" value="<?= $Page->nombre_difunto->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nombre_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_difunto->formatPattern()) ?>"<?= $Page->nombre_difunto->editAttributes() ?> aria-describedby="x_nombre_difunto_help">
<?= $Page->nombre_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_reclamo_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_reclamo_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-control ew-select<?= $Page->tipo->isInvalidClass() ?>"
        data-select2-id="fsco_reclamoedit_x_tipo"
        data-table="sco_reclamo"
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
loadjs.ready("fsco_reclamoedit", function() {
    var options = { name: "x_tipo", selectId: "fsco_reclamoedit_x_tipo" };
    if (fsco_reclamoedit.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_reclamoedit" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_reclamoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_reclamo.fields.tipo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comentario->Visible) { // comentario ?>
    <div id="r_comentario"<?= $Page->comentario->rowAttributes() ?>>
        <label id="elh_sco_reclamo_comentario" for="x_comentario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comentario->caption() ?><?= $Page->comentario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->comentario->cellAttributes() ?>>
<span id="el_sco_reclamo_comentario">
<textarea data-table="sco_reclamo" data-field="x_comentario" name="x_comentario" id="x_comentario" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->comentario->getPlaceHolder()) ?>"<?= $Page->comentario->editAttributes() ?> aria-describedby="x_comentario_help"><?= $Page->comentario->EditValue ?></textarea>
<?= $Page->comentario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comentario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_reclamo_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_reclamo_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_reclamoedit_x_estatus"
        <?php } ?>
        data-table="sco_reclamo"
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
loadjs.ready("fsco_reclamoedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_reclamoedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reclamoedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_reclamoedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_reclamoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reclamo.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_sco_reclamo_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_reclamo_seccion">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="sco_reclamo" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?> aria-describedby="x_seccion_help">
<?= $Page->seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_sco_reclamo_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_reclamo_modulo">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="sco_reclamo" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?> aria-describedby="x_modulo_help">
<?= $Page->modulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <div id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <label id="elh_sco_reclamo_sub_seccion" for="x_sub_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sub_seccion->caption() ?><?= $Page->sub_seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_reclamo_sub_seccion">
<input type="<?= $Page->sub_seccion->getInputTextType() ?>" name="x_sub_seccion" id="x_sub_seccion" data-table="sco_reclamo" data-field="x_sub_seccion" value="<?= $Page->sub_seccion->EditValue ?>" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sub_seccion->formatPattern()) ?>"<?= $Page->sub_seccion->editAttributes() ?> aria-describedby="x_sub_seccion_help">
<?= $Page->sub_seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sub_seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_reclamo_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_reclamo_parcela">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_reclamo" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?> aria-describedby="x_parcela_help">
<?= $Page->parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <div id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <label id="elh_sco_reclamo_boveda" for="x_boveda" class="<?= $Page->LeftColumnClass ?>"><?= $Page->boveda->caption() ?><?= $Page->boveda->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_reclamo_boveda">
<input type="<?= $Page->boveda->getInputTextType() ?>" name="x_boveda" id="x_boveda" data-table="sco_reclamo" data-field="x_boveda" value="<?= $Page->boveda->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->boveda->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->boveda->formatPattern()) ?>"<?= $Page->boveda->editAttributes() ?> aria-describedby="x_boveda_help">
<?= $Page->boveda->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->boveda->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parentesco->Visible) { // parentesco ?>
    <div id="r_parentesco"<?= $Page->parentesco->rowAttributes() ?>>
        <label id="elh_sco_reclamo_parentesco" for="x_parentesco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parentesco->caption() ?><?= $Page->parentesco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parentesco->cellAttributes() ?>>
<span id="el_sco_reclamo_parentesco">
    <select
        id="x_parentesco"
        name="x_parentesco"
        class="form-select ew-select<?= $Page->parentesco->isInvalidClass() ?>"
        <?php if (!$Page->parentesco->IsNativeSelect) { ?>
        data-select2-id="fsco_reclamoedit_x_parentesco"
        <?php } ?>
        data-table="sco_reclamo"
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
loadjs.ready("fsco_reclamoedit", function() {
    var options = { name: "x_parentesco", selectId: "fsco_reclamoedit_x_parentesco" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reclamoedit.lists.parentesco?.lookupOptions.length) {
        options.data = { id: "x_parentesco", form: "fsco_reclamoedit" };
    } else {
        options.ajax = { id: "x_parentesco", form: "fsco_reclamoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reclamo.fields.parentesco.selectOptions);
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
    if (in_array("sco_reclamo_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_reclamo_nota->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_reclamo_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoReclamoNotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_reclamo_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_reclamo_adjunto->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_reclamo_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoReclamoAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_reclamoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_reclamoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_reclamo");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    $("#x_ci_difunto").change(function() {
        var $input = $(this);
        var valor = $input.val().trim().toUpperCase();
        if (!valor) return;

        // 1. Limpieza inicial: Quitar espacios, puntos, comas y guiones previos
        valor = valor.replace(/[\s\.,-]/g, "");

        // 2. Validar que comience con una letra válida (V, E, J, G, M)
        var primeraLetra = valor.charAt(0);
        var prefijosValidos = ['V', 'E', 'J', 'G', 'M'];
        if (!prefijosValidos.includes(primeraLetra)) {
            ew.alert("La Cédula/RIF debe comenzar con V, E, M, J o G");
            $input.val("").focus();
            return;
        }

        // 3. Formatear: Letra + Guión + Resto de números
        var numeros = valor.substring(1);
        if (numeros === "" || isNaN(numeros)) {
            ew.alert("Después del prefijo debe ingresar solo números");
            $input.val("").focus();
            return;
        }
        var ciFormateada = primeraLetra + "-" + numeros;
        $input.val(ciFormateada); // Actualizamos el campo visualmente

        // 4. Iniciar AJAX con la CI ya formateada
        if ($("#loader-ci").length === 0) {
            $input.after('<span id="loader-ci" class="ms-2 d-none"><i class="fas fa-spinner fa-spin text-primary"></i> Buscando...</span>');
        }
        $.ajax({
            url: "../dashboard/buscar_parcela_ubicacion.php",
            type: "POST",
            data: { ci_difunto: ciFormateada },
            dataType: "json",
            beforeSend: function() {
                $("#loader-ci").removeClass("d-none");
                $input.prop("disabled", true);
            },
            success: function(data) {
                if (data) {
                    $("#x_ci_difunto").val(data.cedula || "");
                    $("#x_nombre_difunto").val(data.nombre || "");
                    $("#x_seccion").val(data.seccion || "");
                    $("#x_modulo").val(data.modulo || "");
                    $("#x_sub_seccion").val(data.sub_seccion || "");
                    $("#x_parcela").val(data.parcela || "");
                    $("#x_boveda").val(data.boveda || "");
                } else {
                    ew.alert("La CI " + ciFormateada + " no se encuentra registrada!");
                    $("#x_nombre_difunto, #x_seccion, #x_modulo, #x_sub_seccion, #x_parcela, #x_boveda").val("");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la búsqueda: " + error);
            },
            complete: function() {
                $("#loader-ci").addClass("d-none");
                $input.prop("disabled", false);
                // No hacemos focus aquí para evitar bucles si el usuario quiere cambiar de campo
            }
        });
    });
});
</script>
