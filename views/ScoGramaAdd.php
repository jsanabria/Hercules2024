<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGramaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_grama: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_gramaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_gramaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["contrato", [fields.contrato.visible && fields.contrato.required ? ew.Validators.required(fields.contrato.caption) : null], fields.contrato.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["sub_seccion", [fields.sub_seccion.visible && fields.sub_seccion.required ? ew.Validators.required(fields.sub_seccion.caption) : null], fields.sub_seccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["boveda", [fields.boveda.visible && fields.boveda.required ? ew.Validators.required(fields.boveda.caption) : null], fields.boveda.isInvalid],
            ["ci_difunto", [fields.ci_difunto.visible && fields.ci_difunto.required ? ew.Validators.required(fields.ci_difunto.caption) : null], fields.ci_difunto.isInvalid],
            ["apellido1", [fields.apellido1.visible && fields.apellido1.required ? ew.Validators.required(fields.apellido1.caption) : null], fields.apellido1.isInvalid],
            ["apellido2", [fields.apellido2.visible && fields.apellido2.required ? ew.Validators.required(fields.apellido2.caption) : null], fields.apellido2.isInvalid],
            ["nombre1", [fields.nombre1.visible && fields.nombre1.required ? ew.Validators.required(fields.nombre1.caption) : null], fields.nombre1.isInvalid],
            ["nombre2", [fields.nombre2.visible && fields.nombre2.required ? ew.Validators.required(fields.nombre2.caption) : null], fields.nombre2.isInvalid]
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
<form name="fsco_gramaadd" id="fsco_gramaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_grama">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->contrato->Visible) { // contrato ?>
    <div id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <label id="elh_sco_grama_contrato" for="x_contrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato->caption() ?><?= $Page->contrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato->cellAttributes() ?>>
<span id="el_sco_grama_contrato">
<input type="<?= $Page->contrato->getInputTextType() ?>" name="x_contrato" id="x_contrato" data-table="sco_grama" data-field="x_contrato" value="<?= $Page->contrato->EditValue ?>" data-page="1" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->contrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato->formatPattern()) ?>"<?= $Page->contrato->editAttributes() ?> aria-describedby="x_contrato_help">
<?= $Page->contrato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_sco_grama_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_grama_seccion">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="sco_grama" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" data-page="1" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?> aria-describedby="x_seccion_help">
<?= $Page->seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_sco_grama_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_grama_modulo">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="sco_grama" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" data-page="1" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?> aria-describedby="x_modulo_help">
<?= $Page->modulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <div id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <label id="elh_sco_grama_sub_seccion" for="x_sub_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sub_seccion->caption() ?><?= $Page->sub_seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_grama_sub_seccion">
<input type="<?= $Page->sub_seccion->getInputTextType() ?>" name="x_sub_seccion" id="x_sub_seccion" data-table="sco_grama" data-field="x_sub_seccion" value="<?= $Page->sub_seccion->EditValue ?>" data-page="1" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sub_seccion->formatPattern()) ?>"<?= $Page->sub_seccion->editAttributes() ?> aria-describedby="x_sub_seccion_help">
<?= $Page->sub_seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sub_seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_grama_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_grama_parcela">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_grama" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" data-page="1" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?> aria-describedby="x_parcela_help">
<?= $Page->parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <div id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <label id="elh_sco_grama_boveda" for="x_boveda" class="<?= $Page->LeftColumnClass ?>"><?= $Page->boveda->caption() ?><?= $Page->boveda->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_grama_boveda">
<input type="<?= $Page->boveda->getInputTextType() ?>" name="x_boveda" id="x_boveda" data-table="sco_grama" data-field="x_boveda" value="<?= $Page->boveda->EditValue ?>" data-page="1" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->boveda->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->boveda->formatPattern()) ?>"<?= $Page->boveda->editAttributes() ?> aria-describedby="x_boveda_help">
<?= $Page->boveda->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->boveda->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <div id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <label id="elh_sco_grama_ci_difunto" for="x_ci_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_difunto->caption() ?><?= $Page->ci_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_grama_ci_difunto">
<input type="<?= $Page->ci_difunto->getInputTextType() ?>" name="x_ci_difunto" id="x_ci_difunto" data-table="sco_grama" data-field="x_ci_difunto" value="<?= $Page->ci_difunto->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_difunto->formatPattern()) ?>"<?= $Page->ci_difunto->editAttributes() ?> aria-describedby="x_ci_difunto_help">
<?= $Page->ci_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
    <div id="r_apellido1"<?= $Page->apellido1->rowAttributes() ?>>
        <label id="elh_sco_grama_apellido1" for="x_apellido1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido1->caption() ?><?= $Page->apellido1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido1->cellAttributes() ?>>
<span id="el_sco_grama_apellido1">
<input type="<?= $Page->apellido1->getInputTextType() ?>" name="x_apellido1" id="x_apellido1" data-table="sco_grama" data-field="x_apellido1" value="<?= $Page->apellido1->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido1->formatPattern()) ?>"<?= $Page->apellido1->editAttributes() ?> aria-describedby="x_apellido1_help">
<?= $Page->apellido1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellido1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
    <div id="r_apellido2"<?= $Page->apellido2->rowAttributes() ?>>
        <label id="elh_sco_grama_apellido2" for="x_apellido2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido2->caption() ?><?= $Page->apellido2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido2->cellAttributes() ?>>
<span id="el_sco_grama_apellido2">
<input type="<?= $Page->apellido2->getInputTextType() ?>" name="x_apellido2" id="x_apellido2" data-table="sco_grama" data-field="x_apellido2" value="<?= $Page->apellido2->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido2->formatPattern()) ?>"<?= $Page->apellido2->editAttributes() ?> aria-describedby="x_apellido2_help">
<?= $Page->apellido2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellido2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
    <div id="r_nombre1"<?= $Page->nombre1->rowAttributes() ?>>
        <label id="elh_sco_grama_nombre1" for="x_nombre1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre1->caption() ?><?= $Page->nombre1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre1->cellAttributes() ?>>
<span id="el_sco_grama_nombre1">
<input type="<?= $Page->nombre1->getInputTextType() ?>" name="x_nombre1" id="x_nombre1" data-table="sco_grama" data-field="x_nombre1" value="<?= $Page->nombre1->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre1->formatPattern()) ?>"<?= $Page->nombre1->editAttributes() ?> aria-describedby="x_nombre1_help">
<?= $Page->nombre1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
    <div id="r_nombre2"<?= $Page->nombre2->rowAttributes() ?>>
        <label id="elh_sco_grama_nombre2" for="x_nombre2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre2->caption() ?><?= $Page->nombre2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre2->cellAttributes() ?>>
<span id="el_sco_grama_nombre2">
<input type="<?= $Page->nombre2->getInputTextType() ?>" name="x_nombre2" id="x_nombre2" data-table="sco_grama" data-field="x_nombre2" value="<?= $Page->nombre2->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre2->formatPattern()) ?>"<?= $Page->nombre2->editAttributes() ?> aria-describedby="x_nombre2_help">
<?= $Page->nombre2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_grama_pagos", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_pagos->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_pagos", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaPagosGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_grama_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_nota->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaNotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_grama_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_adjunto->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_gramaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_gramaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_grama");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
