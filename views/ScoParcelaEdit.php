<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_parcelaedit" id="fsco_parcelaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_parcelaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcelaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nparcela", [fields.Nparcela.visible && fields.Nparcela.required ? ew.Validators.required(fields.Nparcela.caption) : null, ew.Validators.integer], fields.Nparcela.isInvalid],
            ["nacionalidad", [fields.nacionalidad.visible && fields.nacionalidad.required ? ew.Validators.required(fields.nacionalidad.caption) : null], fields.nacionalidad.isInvalid],
            ["cedula", [fields.cedula.visible && fields.cedula.required ? ew.Validators.required(fields.cedula.caption) : null], fields.cedula.isInvalid],
            ["titular", [fields.titular.visible && fields.titular.required ? ew.Validators.required(fields.titular.caption) : null], fields.titular.isInvalid],
            ["contrato", [fields.contrato.visible && fields.contrato.required ? ew.Validators.required(fields.contrato.caption) : null], fields.contrato.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["sub_seccion", [fields.sub_seccion.visible && fields.sub_seccion.required ? ew.Validators.required(fields.sub_seccion.caption) : null], fields.sub_seccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["boveda", [fields.boveda.visible && fields.boveda.required ? ew.Validators.required(fields.boveda.caption) : null], fields.boveda.isInvalid],
            ["apellido1", [fields.apellido1.visible && fields.apellido1.required ? ew.Validators.required(fields.apellido1.caption) : null], fields.apellido1.isInvalid],
            ["apellido2", [fields.apellido2.visible && fields.apellido2.required ? ew.Validators.required(fields.apellido2.caption) : null], fields.apellido2.isInvalid],
            ["nombre1", [fields.nombre1.visible && fields.nombre1.required ? ew.Validators.required(fields.nombre1.caption) : null], fields.nombre1.isInvalid],
            ["nombre2", [fields.nombre2.visible && fields.nombre2.required ? ew.Validators.required(fields.nombre2.caption) : null], fields.nombre2.isInvalid],
            ["fecha_inhumacion", [fields.fecha_inhumacion.visible && fields.fecha_inhumacion.required ? ew.Validators.required(fields.fecha_inhumacion.caption) : null, ew.Validators.datetime(fields.fecha_inhumacion.clientFormatPattern)], fields.fecha_inhumacion.isInvalid],
            ["telefono1", [fields.telefono1.visible && fields.telefono1.required ? ew.Validators.required(fields.telefono1.caption) : null], fields.telefono1.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["telefono3", [fields.telefono3.visible && fields.telefono3.required ? ew.Validators.required(fields.telefono3.caption) : null], fields.telefono3.isInvalid],
            ["direc1", [fields.direc1.visible && fields.direc1.required ? ew.Validators.required(fields.direc1.caption) : null], fields.direc1.isInvalid],
            ["direc2", [fields.direc2.visible && fields.direc2.required ? ew.Validators.required(fields.direc2.caption) : null], fields.direc2.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["nac_ci_asociado", [fields.nac_ci_asociado.visible && fields.nac_ci_asociado.required ? ew.Validators.required(fields.nac_ci_asociado.caption) : null], fields.nac_ci_asociado.isInvalid],
            ["ci_asociado", [fields.ci_asociado.visible && fields.ci_asociado.required ? ew.Validators.required(fields.ci_asociado.caption) : null], fields.ci_asociado.isInvalid],
            ["nombre_asociado", [fields.nombre_asociado.visible && fields.nombre_asociado.required ? ew.Validators.required(fields.nombre_asociado.caption) : null], fields.nombre_asociado.isInvalid],
            ["nac_difunto", [fields.nac_difunto.visible && fields.nac_difunto.required ? ew.Validators.required(fields.nac_difunto.caption) : null], fields.nac_difunto.isInvalid],
            ["ci_difunto", [fields.ci_difunto.visible && fields.ci_difunto.required ? ew.Validators.required(fields.ci_difunto.caption) : null], fields.ci_difunto.isInvalid],
            ["edad", [fields.edad.visible && fields.edad.required ? ew.Validators.required(fields.edad.caption) : null, ew.Validators.integer], fields.edad.isInvalid],
            ["edo_civil", [fields.edo_civil.visible && fields.edo_civil.required ? ew.Validators.required(fields.edo_civil.caption) : null], fields.edo_civil.isInvalid],
            ["fecha_nacimiento", [fields.fecha_nacimiento.visible && fields.fecha_nacimiento.required ? ew.Validators.required(fields.fecha_nacimiento.caption) : null], fields.fecha_nacimiento.isInvalid],
            ["lugar", [fields.lugar.visible && fields.lugar.required ? ew.Validators.required(fields.lugar.caption) : null], fields.lugar.isInvalid],
            ["fecha_defuncion", [fields.fecha_defuncion.visible && fields.fecha_defuncion.required ? ew.Validators.required(fields.fecha_defuncion.caption) : null], fields.fecha_defuncion.isInvalid],
            ["causa", [fields.causa.visible && fields.causa.required ? ew.Validators.required(fields.causa.caption) : null], fields.causa.isInvalid],
            ["certificado", [fields.certificado.visible && fields.certificado.required ? ew.Validators.required(fields.certificado.caption) : null], fields.certificado.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null], fields.funeraria.isInvalid]
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_parcela">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_expediente") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_expediente">
<input type="hidden" name="fk_contrato_parcela" value="<?= HtmlEncode($Page->contrato->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nparcela->Visible) { // Nparcela ?>
    <div id="r_Nparcela"<?= $Page->Nparcela->rowAttributes() ?>>
        <label id="elh_sco_parcela_Nparcela" for="x_Nparcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nparcela->caption() ?><?= $Page->Nparcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nparcela->cellAttributes() ?>>
<span id="el_sco_parcela_Nparcela">
<input type="<?= $Page->Nparcela->getInputTextType() ?>" name="x_Nparcela" id="x_Nparcela" data-table="sco_parcela" data-field="x_Nparcela" value="<?= $Page->Nparcela->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Nparcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nparcela->formatPattern()) ?>"<?= $Page->Nparcela->editAttributes() ?> aria-describedby="x_Nparcela_help">
<?= $Page->Nparcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Nparcela->getErrorMessage() ?></div>
<input type="hidden" data-table="sco_parcela" data-field="x_Nparcela" data-hidden="1" data-old name="o_Nparcela" id="o_Nparcela" value="<?= HtmlEncode($Page->Nparcela->OldValue ?? $Page->Nparcela->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nacionalidad->Visible) { // nacionalidad ?>
    <div id="r_nacionalidad"<?= $Page->nacionalidad->rowAttributes() ?>>
        <label id="elh_sco_parcela_nacionalidad" for="x_nacionalidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nacionalidad->caption() ?><?= $Page->nacionalidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nacionalidad->cellAttributes() ?>>
<span id="el_sco_parcela_nacionalidad">
<input type="<?= $Page->nacionalidad->getInputTextType() ?>" name="x_nacionalidad" id="x_nacionalidad" data-table="sco_parcela" data-field="x_nacionalidad" value="<?= $Page->nacionalidad->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->nacionalidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nacionalidad->formatPattern()) ?>"<?= $Page->nacionalidad->editAttributes() ?> aria-describedby="x_nacionalidad_help">
<?= $Page->nacionalidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nacionalidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <div id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <label id="elh_sco_parcela_cedula" for="x_cedula" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula->caption() ?><?= $Page->cedula->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula->cellAttributes() ?>>
<span id="el_sco_parcela_cedula">
<input type="<?= $Page->cedula->getInputTextType() ?>" name="x_cedula" id="x_cedula" data-table="sco_parcela" data-field="x_cedula" value="<?= $Page->cedula->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->cedula->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula->formatPattern()) ?>"<?= $Page->cedula->editAttributes() ?> aria-describedby="x_cedula_help">
<?= $Page->cedula->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <div id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <label id="elh_sco_parcela_titular" for="x_titular" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titular->caption() ?><?= $Page->titular->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_parcela_titular">
<input type="<?= $Page->titular->getInputTextType() ?>" name="x_titular" id="x_titular" data-table="sco_parcela" data-field="x_titular" value="<?= $Page->titular->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titular->formatPattern()) ?>"<?= $Page->titular->editAttributes() ?> aria-describedby="x_titular_help">
<?= $Page->titular->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titular->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
    <div id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <label id="elh_sco_parcela_contrato" for="x_contrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato->caption() ?><?= $Page->contrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato->cellAttributes() ?>>
<?php if ($Page->contrato->getSessionValue() != "") { ?>
<span id="el_sco_parcela_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->contrato->getDisplayValue($Page->contrato->ViewValue))) ?>"></span>
<input type="hidden" id="x_contrato" name="x_contrato" value="<?= HtmlEncode($Page->contrato->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_sco_parcela_contrato">
<input type="<?= $Page->contrato->getInputTextType() ?>" name="x_contrato" id="x_contrato" data-table="sco_parcela" data-field="x_contrato" value="<?= $Page->contrato->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->contrato->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato->formatPattern()) ?>"<?= $Page->contrato->editAttributes() ?> aria-describedby="x_contrato_help">
<?= $Page->contrato->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_sco_parcela_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_parcela_seccion">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="sco_parcela" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?> aria-describedby="x_seccion_help">
<?= $Page->seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_sco_parcela_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_parcela_modulo">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="sco_parcela" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?> aria-describedby="x_modulo_help">
<?= $Page->modulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <div id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <label id="elh_sco_parcela_sub_seccion" for="x_sub_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sub_seccion->caption() ?><?= $Page->sub_seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_parcela_sub_seccion">
<input type="<?= $Page->sub_seccion->getInputTextType() ?>" name="x_sub_seccion" id="x_sub_seccion" data-table="sco_parcela" data-field="x_sub_seccion" value="<?= $Page->sub_seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->sub_seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sub_seccion->formatPattern()) ?>"<?= $Page->sub_seccion->editAttributes() ?> aria-describedby="x_sub_seccion_help">
<?= $Page->sub_seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sub_seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_parcela_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_parcela_parcela">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_parcela" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?> aria-describedby="x_parcela_help">
<?= $Page->parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <div id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <label id="elh_sco_parcela_boveda" for="x_boveda" class="<?= $Page->LeftColumnClass ?>"><?= $Page->boveda->caption() ?><?= $Page->boveda->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_parcela_boveda">
<input type="<?= $Page->boveda->getInputTextType() ?>" name="x_boveda" id="x_boveda" data-table="sco_parcela" data-field="x_boveda" value="<?= $Page->boveda->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Page->boveda->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->boveda->formatPattern()) ?>"<?= $Page->boveda->editAttributes() ?> aria-describedby="x_boveda_help">
<?= $Page->boveda->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->boveda->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
    <div id="r_apellido1"<?= $Page->apellido1->rowAttributes() ?>>
        <label id="elh_sco_parcela_apellido1" for="x_apellido1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido1->caption() ?><?= $Page->apellido1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido1->cellAttributes() ?>>
<span id="el_sco_parcela_apellido1">
<input type="<?= $Page->apellido1->getInputTextType() ?>" name="x_apellido1" id="x_apellido1" data-table="sco_parcela" data-field="x_apellido1" value="<?= $Page->apellido1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido1->formatPattern()) ?>"<?= $Page->apellido1->editAttributes() ?> aria-describedby="x_apellido1_help">
<?= $Page->apellido1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellido1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
    <div id="r_apellido2"<?= $Page->apellido2->rowAttributes() ?>>
        <label id="elh_sco_parcela_apellido2" for="x_apellido2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido2->caption() ?><?= $Page->apellido2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido2->cellAttributes() ?>>
<span id="el_sco_parcela_apellido2">
<input type="<?= $Page->apellido2->getInputTextType() ?>" name="x_apellido2" id="x_apellido2" data-table="sco_parcela" data-field="x_apellido2" value="<?= $Page->apellido2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido2->formatPattern()) ?>"<?= $Page->apellido2->editAttributes() ?> aria-describedby="x_apellido2_help">
<?= $Page->apellido2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellido2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
    <div id="r_nombre1"<?= $Page->nombre1->rowAttributes() ?>>
        <label id="elh_sco_parcela_nombre1" for="x_nombre1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre1->caption() ?><?= $Page->nombre1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre1->cellAttributes() ?>>
<span id="el_sco_parcela_nombre1">
<input type="<?= $Page->nombre1->getInputTextType() ?>" name="x_nombre1" id="x_nombre1" data-table="sco_parcela" data-field="x_nombre1" value="<?= $Page->nombre1->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre1->formatPattern()) ?>"<?= $Page->nombre1->editAttributes() ?> aria-describedby="x_nombre1_help">
<?= $Page->nombre1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
    <div id="r_nombre2"<?= $Page->nombre2->rowAttributes() ?>>
        <label id="elh_sco_parcela_nombre2" for="x_nombre2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre2->caption() ?><?= $Page->nombre2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre2->cellAttributes() ?>>
<span id="el_sco_parcela_nombre2">
<input type="<?= $Page->nombre2->getInputTextType() ?>" name="x_nombre2" id="x_nombre2" data-table="sco_parcela" data-field="x_nombre2" value="<?= $Page->nombre2->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre2->formatPattern()) ?>"<?= $Page->nombre2->editAttributes() ?> aria-describedby="x_nombre2_help">
<?= $Page->nombre2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
    <div id="r_fecha_inhumacion"<?= $Page->fecha_inhumacion->rowAttributes() ?>>
        <label id="elh_sco_parcela_fecha_inhumacion" for="x_fecha_inhumacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_inhumacion->caption() ?><?= $Page->fecha_inhumacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_inhumacion->cellAttributes() ?>>
<span id="el_sco_parcela_fecha_inhumacion">
<input type="<?= $Page->fecha_inhumacion->getInputTextType() ?>" name="x_fecha_inhumacion" id="x_fecha_inhumacion" data-table="sco_parcela" data-field="x_fecha_inhumacion" value="<?= $Page->fecha_inhumacion->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_inhumacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_inhumacion->formatPattern()) ?>"<?= $Page->fecha_inhumacion->editAttributes() ?> aria-describedby="x_fecha_inhumacion_help">
<?= $Page->fecha_inhumacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_inhumacion->getErrorMessage() ?></div>
<?php if (!$Page->fecha_inhumacion->ReadOnly && !$Page->fecha_inhumacion->Disabled && !isset($Page->fecha_inhumacion->EditAttrs["readonly"]) && !isset($Page->fecha_inhumacion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_parcelaedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_parcelaedit", "x_fecha_inhumacion", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <div id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <label id="elh_sco_parcela_telefono1" for="x_telefono1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono1->caption() ?><?= $Page->telefono1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_parcela_telefono1">
<input type="<?= $Page->telefono1->getInputTextType() ?>" name="x_telefono1" id="x_telefono1" data-table="sco_parcela" data-field="x_telefono1" value="<?= $Page->telefono1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->telefono1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono1->formatPattern()) ?>"<?= $Page->telefono1->editAttributes() ?> aria-describedby="x_telefono1_help">
<?= $Page->telefono1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_parcela_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_parcela_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_parcela" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono3->Visible) { // telefono3 ?>
    <div id="r_telefono3"<?= $Page->telefono3->rowAttributes() ?>>
        <label id="elh_sco_parcela_telefono3" for="x_telefono3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono3->caption() ?><?= $Page->telefono3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono3->cellAttributes() ?>>
<span id="el_sco_parcela_telefono3">
<input type="<?= $Page->telefono3->getInputTextType() ?>" name="x_telefono3" id="x_telefono3" data-table="sco_parcela" data-field="x_telefono3" value="<?= $Page->telefono3->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->telefono3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono3->formatPattern()) ?>"<?= $Page->telefono3->editAttributes() ?> aria-describedby="x_telefono3_help">
<?= $Page->telefono3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direc1->Visible) { // direc1 ?>
    <div id="r_direc1"<?= $Page->direc1->rowAttributes() ?>>
        <label id="elh_sco_parcela_direc1" for="x_direc1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direc1->caption() ?><?= $Page->direc1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direc1->cellAttributes() ?>>
<span id="el_sco_parcela_direc1">
<input type="<?= $Page->direc1->getInputTextType() ?>" name="x_direc1" id="x_direc1" data-table="sco_parcela" data-field="x_direc1" value="<?= $Page->direc1->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->direc1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direc1->formatPattern()) ?>"<?= $Page->direc1->editAttributes() ?> aria-describedby="x_direc1_help">
<?= $Page->direc1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direc1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direc2->Visible) { // direc2 ?>
    <div id="r_direc2"<?= $Page->direc2->rowAttributes() ?>>
        <label id="elh_sco_parcela_direc2" for="x_direc2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direc2->caption() ?><?= $Page->direc2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direc2->cellAttributes() ?>>
<span id="el_sco_parcela_direc2">
<input type="<?= $Page->direc2->getInputTextType() ?>" name="x_direc2" id="x_direc2" data-table="sco_parcela" data-field="x_direc2" value="<?= $Page->direc2->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->direc2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direc2->formatPattern()) ?>"<?= $Page->direc2->editAttributes() ?> aria-describedby="x_direc2_help">
<?= $Page->direc2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direc2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_parcela__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_parcela__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_parcela" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nac_ci_asociado->Visible) { // nac_ci_asociado ?>
    <div id="r_nac_ci_asociado"<?= $Page->nac_ci_asociado->rowAttributes() ?>>
        <label id="elh_sco_parcela_nac_ci_asociado" for="x_nac_ci_asociado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nac_ci_asociado->caption() ?><?= $Page->nac_ci_asociado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nac_ci_asociado->cellAttributes() ?>>
<span id="el_sco_parcela_nac_ci_asociado">
<input type="<?= $Page->nac_ci_asociado->getInputTextType() ?>" name="x_nac_ci_asociado" id="x_nac_ci_asociado" data-table="sco_parcela" data-field="x_nac_ci_asociado" value="<?= $Page->nac_ci_asociado->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->nac_ci_asociado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nac_ci_asociado->formatPattern()) ?>"<?= $Page->nac_ci_asociado->editAttributes() ?> aria-describedby="x_nac_ci_asociado_help">
<?= $Page->nac_ci_asociado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nac_ci_asociado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_asociado->Visible) { // ci_asociado ?>
    <div id="r_ci_asociado"<?= $Page->ci_asociado->rowAttributes() ?>>
        <label id="elh_sco_parcela_ci_asociado" for="x_ci_asociado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_asociado->caption() ?><?= $Page->ci_asociado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_asociado->cellAttributes() ?>>
<span id="el_sco_parcela_ci_asociado">
<input type="<?= $Page->ci_asociado->getInputTextType() ?>" name="x_ci_asociado" id="x_ci_asociado" data-table="sco_parcela" data-field="x_ci_asociado" value="<?= $Page->ci_asociado->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_asociado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_asociado->formatPattern()) ?>"<?= $Page->ci_asociado->editAttributes() ?> aria-describedby="x_ci_asociado_help">
<?= $Page->ci_asociado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_asociado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_asociado->Visible) { // nombre_asociado ?>
    <div id="r_nombre_asociado"<?= $Page->nombre_asociado->rowAttributes() ?>>
        <label id="elh_sco_parcela_nombre_asociado" for="x_nombre_asociado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_asociado->caption() ?><?= $Page->nombre_asociado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_asociado->cellAttributes() ?>>
<span id="el_sco_parcela_nombre_asociado">
<input type="<?= $Page->nombre_asociado->getInputTextType() ?>" name="x_nombre_asociado" id="x_nombre_asociado" data-table="sco_parcela" data-field="x_nombre_asociado" value="<?= $Page->nombre_asociado->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->nombre_asociado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_asociado->formatPattern()) ?>"<?= $Page->nombre_asociado->editAttributes() ?> aria-describedby="x_nombre_asociado_help">
<?= $Page->nombre_asociado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_asociado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nac_difunto->Visible) { // nac_difunto ?>
    <div id="r_nac_difunto"<?= $Page->nac_difunto->rowAttributes() ?>>
        <label id="elh_sco_parcela_nac_difunto" for="x_nac_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nac_difunto->caption() ?><?= $Page->nac_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nac_difunto->cellAttributes() ?>>
<span id="el_sco_parcela_nac_difunto">
<input type="<?= $Page->nac_difunto->getInputTextType() ?>" name="x_nac_difunto" id="x_nac_difunto" data-table="sco_parcela" data-field="x_nac_difunto" value="<?= $Page->nac_difunto->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nac_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nac_difunto->formatPattern()) ?>"<?= $Page->nac_difunto->editAttributes() ?> aria-describedby="x_nac_difunto_help">
<?= $Page->nac_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nac_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <div id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <label id="elh_sco_parcela_ci_difunto" for="x_ci_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_difunto->caption() ?><?= $Page->ci_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_parcela_ci_difunto">
<input type="<?= $Page->ci_difunto->getInputTextType() ?>" name="x_ci_difunto" id="x_ci_difunto" data-table="sco_parcela" data-field="x_ci_difunto" value="<?= $Page->ci_difunto->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_difunto->formatPattern()) ?>"<?= $Page->ci_difunto->editAttributes() ?> aria-describedby="x_ci_difunto_help">
<?= $Page->ci_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->edad->Visible) { // edad ?>
    <div id="r_edad"<?= $Page->edad->rowAttributes() ?>>
        <label id="elh_sco_parcela_edad" for="x_edad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->edad->caption() ?><?= $Page->edad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->edad->cellAttributes() ?>>
<span id="el_sco_parcela_edad">
<input type="<?= $Page->edad->getInputTextType() ?>" name="x_edad" id="x_edad" data-table="sco_parcela" data-field="x_edad" value="<?= $Page->edad->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->edad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->edad->formatPattern()) ?>"<?= $Page->edad->editAttributes() ?> aria-describedby="x_edad_help">
<?= $Page->edad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->edad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->edo_civil->Visible) { // edo_civil ?>
    <div id="r_edo_civil"<?= $Page->edo_civil->rowAttributes() ?>>
        <label id="elh_sco_parcela_edo_civil" for="x_edo_civil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->edo_civil->caption() ?><?= $Page->edo_civil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->edo_civil->cellAttributes() ?>>
<span id="el_sco_parcela_edo_civil">
<input type="<?= $Page->edo_civil->getInputTextType() ?>" name="x_edo_civil" id="x_edo_civil" data-table="sco_parcela" data-field="x_edo_civil" value="<?= $Page->edo_civil->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->edo_civil->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->edo_civil->formatPattern()) ?>"<?= $Page->edo_civil->editAttributes() ?> aria-describedby="x_edo_civil_help">
<?= $Page->edo_civil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->edo_civil->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <div id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <label id="elh_sco_parcela_fecha_nacimiento" for="x_fecha_nacimiento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_nacimiento->caption() ?><?= $Page->fecha_nacimiento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_parcela_fecha_nacimiento">
<input type="<?= $Page->fecha_nacimiento->getInputTextType() ?>" name="x_fecha_nacimiento" id="x_fecha_nacimiento" data-table="sco_parcela" data-field="x_fecha_nacimiento" value="<?= $Page->fecha_nacimiento->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_nacimiento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_nacimiento->formatPattern()) ?>"<?= $Page->fecha_nacimiento->editAttributes() ?> aria-describedby="x_fecha_nacimiento_help">
<?= $Page->fecha_nacimiento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_nacimiento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lugar->Visible) { // lugar ?>
    <div id="r_lugar"<?= $Page->lugar->rowAttributes() ?>>
        <label id="elh_sco_parcela_lugar" for="x_lugar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lugar->caption() ?><?= $Page->lugar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lugar->cellAttributes() ?>>
<span id="el_sco_parcela_lugar">
<input type="<?= $Page->lugar->getInputTextType() ?>" name="x_lugar" id="x_lugar" data-table="sco_parcela" data-field="x_lugar" value="<?= $Page->lugar->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->lugar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->lugar->formatPattern()) ?>"<?= $Page->lugar->editAttributes() ?> aria-describedby="x_lugar_help">
<?= $Page->lugar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lugar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_defuncion->Visible) { // fecha_defuncion ?>
    <div id="r_fecha_defuncion"<?= $Page->fecha_defuncion->rowAttributes() ?>>
        <label id="elh_sco_parcela_fecha_defuncion" for="x_fecha_defuncion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_defuncion->caption() ?><?= $Page->fecha_defuncion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_defuncion->cellAttributes() ?>>
<span id="el_sco_parcela_fecha_defuncion">
<input type="<?= $Page->fecha_defuncion->getInputTextType() ?>" name="x_fecha_defuncion" id="x_fecha_defuncion" data-table="sco_parcela" data-field="x_fecha_defuncion" value="<?= $Page->fecha_defuncion->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_defuncion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_defuncion->formatPattern()) ?>"<?= $Page->fecha_defuncion->editAttributes() ?> aria-describedby="x_fecha_defuncion_help">
<?= $Page->fecha_defuncion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_defuncion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa->Visible) { // causa ?>
    <div id="r_causa"<?= $Page->causa->rowAttributes() ?>>
        <label id="elh_sco_parcela_causa" for="x_causa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa->caption() ?><?= $Page->causa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa->cellAttributes() ?>>
<span id="el_sco_parcela_causa">
<input type="<?= $Page->causa->getInputTextType() ?>" name="x_causa" id="x_causa" data-table="sco_parcela" data-field="x_causa" value="<?= $Page->causa->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->causa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->causa->formatPattern()) ?>"<?= $Page->causa->editAttributes() ?> aria-describedby="x_causa_help">
<?= $Page->causa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->causa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->certificado->Visible) { // certificado ?>
    <div id="r_certificado"<?= $Page->certificado->rowAttributes() ?>>
        <label id="elh_sco_parcela_certificado" for="x_certificado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->certificado->caption() ?><?= $Page->certificado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->certificado->cellAttributes() ?>>
<span id="el_sco_parcela_certificado">
<input type="<?= $Page->certificado->getInputTextType() ?>" name="x_certificado" id="x_certificado" data-table="sco_parcela" data-field="x_certificado" value="<?= $Page->certificado->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->certificado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->certificado->formatPattern()) ?>"<?= $Page->certificado->editAttributes() ?> aria-describedby="x_certificado_help">
<?= $Page->certificado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->certificado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <div id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <label id="elh_sco_parcela_funeraria" for="x_funeraria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funeraria->caption() ?><?= $Page->funeraria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_parcela_funeraria">
<input type="<?= $Page->funeraria->getInputTextType() ?>" name="x_funeraria" id="x_funeraria" data-table="sco_parcela" data-field="x_funeraria" value="<?= $Page->funeraria->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->funeraria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->funeraria->formatPattern()) ?>"<?= $Page->funeraria->editAttributes() ?> aria-describedby="x_funeraria_help">
<?= $Page->funeraria->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->funeraria->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_parcelaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_parcelaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_parcela");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
