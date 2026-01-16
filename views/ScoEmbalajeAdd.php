<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEmbalajeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_embalaje: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_embalajeadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_embalajeadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["precinto1", [fields.precinto1.visible && fields.precinto1.required ? ew.Validators.required(fields.precinto1.caption) : null], fields.precinto1.isInvalid],
            ["precinto2", [fields.precinto2.visible && fields.precinto2.required ? ew.Validators.required(fields.precinto2.caption) : null], fields.precinto2.isInvalid],
            ["nombre_familiar", [fields.nombre_familiar.visible && fields.nombre_familiar.required ? ew.Validators.required(fields.nombre_familiar.caption) : null], fields.nombre_familiar.isInvalid],
            ["cedula_familiar", [fields.cedula_familiar.visible && fields.cedula_familiar.required ? ew.Validators.required(fields.cedula_familiar.caption) : null], fields.cedula_familiar.isInvalid],
            ["certificado_defuncion", [fields.certificado_defuncion.visible && fields.certificado_defuncion.required ? ew.Validators.required(fields.certificado_defuncion.caption) : null], fields.certificado_defuncion.isInvalid],
            ["fecha_servicio", [fields.fecha_servicio.visible && fields.fecha_servicio.required ? ew.Validators.required(fields.fecha_servicio.caption) : null, ew.Validators.datetime(fields.fecha_servicio.clientFormatPattern)], fields.fecha_servicio.isInvalid],
            ["cremacion_nro", [fields.cremacion_nro.visible && fields.cremacion_nro.required ? ew.Validators.required(fields.cremacion_nro.caption) : null], fields.cremacion_nro.isInvalid],
            ["registro_civil", [fields.registro_civil.visible && fields.registro_civil.required ? ew.Validators.required(fields.registro_civil.caption) : null], fields.registro_civil.isInvalid],
            ["dimension_cofre", [fields.dimension_cofre.visible && fields.dimension_cofre.required ? ew.Validators.required(fields.dimension_cofre.caption) : null], fields.dimension_cofre.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid]
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
<form name="fsco_embalajeadd" id="fsco_embalajeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_embalaje">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_expediente") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_expediente">
<input type="hidden" name="fk_Nexpediente" value="<?= HtmlEncode($Page->expediente->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->precinto1->Visible) { // precinto1 ?>
    <div id="r_precinto1"<?= $Page->precinto1->rowAttributes() ?>>
        <label id="elh_sco_embalaje_precinto1" for="x_precinto1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precinto1->caption() ?><?= $Page->precinto1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precinto1->cellAttributes() ?>>
<span id="el_sco_embalaje_precinto1">
<input type="<?= $Page->precinto1->getInputTextType() ?>" name="x_precinto1" id="x_precinto1" data-table="sco_embalaje" data-field="x_precinto1" value="<?= $Page->precinto1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->precinto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precinto1->formatPattern()) ?>"<?= $Page->precinto1->editAttributes() ?> aria-describedby="x_precinto1_help">
<?= $Page->precinto1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precinto1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precinto2->Visible) { // precinto2 ?>
    <div id="r_precinto2"<?= $Page->precinto2->rowAttributes() ?>>
        <label id="elh_sco_embalaje_precinto2" for="x_precinto2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precinto2->caption() ?><?= $Page->precinto2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precinto2->cellAttributes() ?>>
<span id="el_sco_embalaje_precinto2">
<input type="<?= $Page->precinto2->getInputTextType() ?>" name="x_precinto2" id="x_precinto2" data-table="sco_embalaje" data-field="x_precinto2" value="<?= $Page->precinto2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->precinto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precinto2->formatPattern()) ?>"<?= $Page->precinto2->editAttributes() ?> aria-describedby="x_precinto2_help">
<?= $Page->precinto2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precinto2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_familiar->Visible) { // nombre_familiar ?>
    <div id="r_nombre_familiar"<?= $Page->nombre_familiar->rowAttributes() ?>>
        <label id="elh_sco_embalaje_nombre_familiar" for="x_nombre_familiar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_familiar->caption() ?><?= $Page->nombre_familiar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_familiar->cellAttributes() ?>>
<span id="el_sco_embalaje_nombre_familiar">
<input type="<?= $Page->nombre_familiar->getInputTextType() ?>" name="x_nombre_familiar" id="x_nombre_familiar" data-table="sco_embalaje" data-field="x_nombre_familiar" value="<?= $Page->nombre_familiar->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_familiar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_familiar->formatPattern()) ?>"<?= $Page->nombre_familiar->editAttributes() ?> aria-describedby="x_nombre_familiar_help">
<?= $Page->nombre_familiar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_familiar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_familiar->Visible) { // cedula_familiar ?>
    <div id="r_cedula_familiar"<?= $Page->cedula_familiar->rowAttributes() ?>>
        <label id="elh_sco_embalaje_cedula_familiar" for="x_cedula_familiar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_familiar->caption() ?><?= $Page->cedula_familiar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_familiar->cellAttributes() ?>>
<span id="el_sco_embalaje_cedula_familiar">
<input type="<?= $Page->cedula_familiar->getInputTextType() ?>" name="x_cedula_familiar" id="x_cedula_familiar" data-table="sco_embalaje" data-field="x_cedula_familiar" value="<?= $Page->cedula_familiar->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->cedula_familiar->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_familiar->formatPattern()) ?>"<?= $Page->cedula_familiar->editAttributes() ?> aria-describedby="x_cedula_familiar_help">
<?= $Page->cedula_familiar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula_familiar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
    <div id="r_certificado_defuncion"<?= $Page->certificado_defuncion->rowAttributes() ?>>
        <label id="elh_sco_embalaje_certificado_defuncion" for="x_certificado_defuncion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->certificado_defuncion->caption() ?><?= $Page->certificado_defuncion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="el_sco_embalaje_certificado_defuncion">
<input type="<?= $Page->certificado_defuncion->getInputTextType() ?>" name="x_certificado_defuncion" id="x_certificado_defuncion" data-table="sco_embalaje" data-field="x_certificado_defuncion" value="<?= $Page->certificado_defuncion->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->certificado_defuncion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->certificado_defuncion->formatPattern()) ?>"<?= $Page->certificado_defuncion->editAttributes() ?> aria-describedby="x_certificado_defuncion_help">
<?= $Page->certificado_defuncion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->certificado_defuncion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <div id="r_fecha_servicio"<?= $Page->fecha_servicio->rowAttributes() ?>>
        <label id="elh_sco_embalaje_fecha_servicio" for="x_fecha_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_servicio->caption() ?><?= $Page->fecha_servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el_sco_embalaje_fecha_servicio">
<input type="<?= $Page->fecha_servicio->getInputTextType() ?>" name="x_fecha_servicio" id="x_fecha_servicio" data-table="sco_embalaje" data-field="x_fecha_servicio" value="<?= $Page->fecha_servicio->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_servicio->formatPattern()) ?>"<?= $Page->fecha_servicio->editAttributes() ?> aria-describedby="x_fecha_servicio_help">
<?= $Page->fecha_servicio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_servicio->getErrorMessage() ?></div>
<?php if (!$Page->fecha_servicio->ReadOnly && !$Page->fecha_servicio->Disabled && !isset($Page->fecha_servicio->EditAttrs["readonly"]) && !isset($Page->fecha_servicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_embalajeadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_embalajeadd", "x_fecha_servicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cremacion_nro->Visible) { // cremacion_nro ?>
    <div id="r_cremacion_nro"<?= $Page->cremacion_nro->rowAttributes() ?>>
        <label id="elh_sco_embalaje_cremacion_nro" for="x_cremacion_nro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cremacion_nro->caption() ?><?= $Page->cremacion_nro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cremacion_nro->cellAttributes() ?>>
<span id="el_sco_embalaje_cremacion_nro">
<input type="<?= $Page->cremacion_nro->getInputTextType() ?>" name="x_cremacion_nro" id="x_cremacion_nro" data-table="sco_embalaje" data-field="x_cremacion_nro" value="<?= $Page->cremacion_nro->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cremacion_nro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cremacion_nro->formatPattern()) ?>"<?= $Page->cremacion_nro->editAttributes() ?> aria-describedby="x_cremacion_nro_help">
<?= $Page->cremacion_nro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cremacion_nro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->registro_civil->Visible) { // registro_civil ?>
    <div id="r_registro_civil"<?= $Page->registro_civil->rowAttributes() ?>>
        <label id="elh_sco_embalaje_registro_civil" for="x_registro_civil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->registro_civil->caption() ?><?= $Page->registro_civil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->registro_civil->cellAttributes() ?>>
<span id="el_sco_embalaje_registro_civil">
<input type="<?= $Page->registro_civil->getInputTextType() ?>" name="x_registro_civil" id="x_registro_civil" data-table="sco_embalaje" data-field="x_registro_civil" value="<?= $Page->registro_civil->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->registro_civil->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->registro_civil->formatPattern()) ?>"<?= $Page->registro_civil->editAttributes() ?> aria-describedby="x_registro_civil_help">
<?= $Page->registro_civil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->registro_civil->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dimension_cofre->Visible) { // dimension_cofre ?>
    <div id="r_dimension_cofre"<?= $Page->dimension_cofre->rowAttributes() ?>>
        <label id="elh_sco_embalaje_dimension_cofre" for="x_dimension_cofre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dimension_cofre->caption() ?><?= $Page->dimension_cofre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dimension_cofre->cellAttributes() ?>>
<span id="el_sco_embalaje_dimension_cofre">
<input type="<?= $Page->dimension_cofre->getInputTextType() ?>" name="x_dimension_cofre" id="x_dimension_cofre" data-table="sco_embalaje" data-field="x_dimension_cofre" value="<?= $Page->dimension_cofre->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->dimension_cofre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->dimension_cofre->formatPattern()) ?>"<?= $Page->dimension_cofre->editAttributes() ?> aria-describedby="x_dimension_cofre_help">
<?= $Page->dimension_cofre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dimension_cofre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_embalaje_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_embalaje_nota">
<input type="<?= $Page->nota->getInputTextType() ?>" name="x_nota" id="x_nota" data-table="sco_embalaje" data-field="x_nota" value="<?= $Page->nota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nota->formatPattern()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help">
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->expediente->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_expediente" id="x_expediente" value="<?= HtmlEncode(strval($Page->expediente->getSessionValue())) ?>">
    <?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_embalajeadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_embalajeadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_embalaje");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $(document).ready(function() { 
    	var exp = <?php echo $_REQUEST["fk_Nexpediente"]; ?>;
    	$.ajax({url: "dashboard/buscar_certificado.php", data: {exp: exp}, success: function(result){
    		var valor = result.split("|");
    		$("#x_certificado_defuncion").val(valor[0]);
    		$("#x_dimension_cofre").val(valor[1]);
    		$("#x_fecha_servicio").val(valor[2]);
    	}});
    });
});
</script>
