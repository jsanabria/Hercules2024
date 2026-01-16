<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReembolsoAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_reembolso: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_reembolsoadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reembolsoadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["monto_usd", [fields.monto_usd.visible && fields.monto_usd.required ? ew.Validators.required(fields.monto_usd.caption) : null, ew.Validators.float], fields.monto_usd.isInvalid],
            ["banco", [fields.banco.visible && fields.banco.required ? ew.Validators.required(fields.banco.caption) : null], fields.banco.isInvalid],
            ["nro_cta", [fields.nro_cta.visible && fields.nro_cta.required ? ew.Validators.required(fields.nro_cta.caption) : null], fields.nro_cta.isInvalid],
            ["titular", [fields.titular.visible && fields.titular.required ? ew.Validators.required(fields.titular.caption) : null], fields.titular.isInvalid],
            ["ci_rif", [fields.ci_rif.visible && fields.ci_rif.required ? ew.Validators.required(fields.ci_rif.caption) : null], fields.ci_rif.isInvalid],
            ["correo", [fields.correo.visible && fields.correo.required ? ew.Validators.required(fields.correo.caption) : null, ew.Validators.email], fields.correo.isInvalid],
            ["motivo", [fields.motivo.visible && fields.motivo.required ? ew.Validators.required(fields.motivo.caption) : null], fields.motivo.isInvalid],
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
            "motivo": <?= $Page->motivo->toClientList($Page) ?>,
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
<form name="fsco_reembolsoadd" id="fsco_reembolsoadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_reembolso">
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
<?php if ($Page->monto_usd->Visible) { // monto_usd ?>
    <div id="r_monto_usd"<?= $Page->monto_usd->rowAttributes() ?>>
        <label id="elh_sco_reembolso_monto_usd" for="x_monto_usd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_usd->caption() ?><?= $Page->monto_usd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_usd->cellAttributes() ?>>
<span id="el_sco_reembolso_monto_usd">
<input type="<?= $Page->monto_usd->getInputTextType() ?>" name="x_monto_usd" id="x_monto_usd" data-table="sco_reembolso" data-field="x_monto_usd" value="<?= $Page->monto_usd->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto_usd->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_usd->formatPattern()) ?>"<?= $Page->monto_usd->editAttributes() ?> aria-describedby="x_monto_usd_help">
<?= $Page->monto_usd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto_usd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->banco->Visible) { // banco ?>
    <div id="r_banco"<?= $Page->banco->rowAttributes() ?>>
        <label id="elh_sco_reembolso_banco" for="x_banco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->banco->caption() ?><?= $Page->banco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->banco->cellAttributes() ?>>
<span id="el_sco_reembolso_banco">
<input type="<?= $Page->banco->getInputTextType() ?>" name="x_banco" id="x_banco" data-table="sco_reembolso" data-field="x_banco" value="<?= $Page->banco->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->banco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->banco->formatPattern()) ?>"<?= $Page->banco->editAttributes() ?> aria-describedby="x_banco_help">
<?= $Page->banco->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->banco->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nro_cta->Visible) { // nro_cta ?>
    <div id="r_nro_cta"<?= $Page->nro_cta->rowAttributes() ?>>
        <label id="elh_sco_reembolso_nro_cta" for="x_nro_cta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nro_cta->caption() ?><?= $Page->nro_cta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nro_cta->cellAttributes() ?>>
<span id="el_sco_reembolso_nro_cta">
<input type="<?= $Page->nro_cta->getInputTextType() ?>" name="x_nro_cta" id="x_nro_cta" data-table="sco_reembolso" data-field="x_nro_cta" value="<?= $Page->nro_cta->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nro_cta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nro_cta->formatPattern()) ?>"<?= $Page->nro_cta->editAttributes() ?> aria-describedby="x_nro_cta_help">
<?= $Page->nro_cta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nro_cta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <div id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <label id="elh_sco_reembolso_titular" for="x_titular" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titular->caption() ?><?= $Page->titular->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_reembolso_titular">
<input type="<?= $Page->titular->getInputTextType() ?>" name="x_titular" id="x_titular" data-table="sco_reembolso" data-field="x_titular" value="<?= $Page->titular->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titular->formatPattern()) ?>"<?= $Page->titular->editAttributes() ?> aria-describedby="x_titular_help">
<?= $Page->titular->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titular->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_rif->Visible) { // ci_rif ?>
    <div id="r_ci_rif"<?= $Page->ci_rif->rowAttributes() ?>>
        <label id="elh_sco_reembolso_ci_rif" for="x_ci_rif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_rif->caption() ?><?= $Page->ci_rif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_rif->cellAttributes() ?>>
<span id="el_sco_reembolso_ci_rif">
<input type="<?= $Page->ci_rif->getInputTextType() ?>" name="x_ci_rif" id="x_ci_rif" data-table="sco_reembolso" data-field="x_ci_rif" value="<?= $Page->ci_rif->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->ci_rif->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_rif->formatPattern()) ?>"<?= $Page->ci_rif->editAttributes() ?> aria-describedby="x_ci_rif_help">
<?= $Page->ci_rif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_rif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <div id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <label id="elh_sco_reembolso_correo" for="x_correo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->correo->caption() ?><?= $Page->correo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_reembolso_correo">
<input type="<?= $Page->correo->getInputTextType() ?>" name="x_correo" id="x_correo" data-table="sco_reembolso" data-field="x_correo" value="<?= $Page->correo->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->correo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->correo->formatPattern()) ?>"<?= $Page->correo->editAttributes() ?> aria-describedby="x_correo_help">
<?= $Page->correo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->correo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <div id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <label id="elh_sco_reembolso_motivo" for="x_motivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motivo->caption() ?><?= $Page->motivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motivo->cellAttributes() ?>>
<span id="el_sco_reembolso_motivo">
    <select
        id="x_motivo"
        name="x_motivo"
        class="form-select ew-select<?= $Page->motivo->isInvalidClass() ?>"
        <?php if (!$Page->motivo->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsoadd_x_motivo"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_motivo"
        data-value-separator="<?= $Page->motivo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->motivo->getPlaceHolder()) ?>"
        <?= $Page->motivo->editAttributes() ?>>
        <?= $Page->motivo->selectOptionListHtml("x_motivo") ?>
    </select>
    <?= $Page->motivo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->motivo->getErrorMessage() ?></div>
<?= $Page->motivo->Lookup->getParamTag($Page, "p_x_motivo") ?>
<?php if (!$Page->motivo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsoadd", function() {
    var options = { name: "x_motivo", selectId: "fsco_reembolsoadd_x_motivo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsoadd.lists.motivo?.lookupOptions.length) {
        options.data = { id: "x_motivo", form: "fsco_reembolsoadd" };
    } else {
        options.ajax = { id: "x_motivo", form: "fsco_reembolsoadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.motivo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_reembolso_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_reembolso_nota">
<textarea data-table="sco_reembolso" data-field="x_nota" name="x_nota" id="x_nota" cols="35" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_reembolsoadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_reembolsoadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_reembolso");
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
    		$("#x_dimension_cofre").val(valor[2]);
    	}});
    });
});
</script>
