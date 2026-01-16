<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoAdjuntoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_mttotecnico_adjuntoedit" id="fsco_mttotecnico_adjuntoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico_adjunto: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_mttotecnico_adjuntoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnico_adjuntoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nmttotecnico_adjunto", [fields.Nmttotecnico_adjunto.visible && fields.Nmttotecnico_adjunto.required ? ew.Validators.required(fields.Nmttotecnico_adjunto.caption) : null], fields.Nmttotecnico_adjunto.isInvalid],
            ["mttotecnico", [fields.mttotecnico.visible && fields.mttotecnico.required ? ew.Validators.required(fields.mttotecnico.caption) : null, ew.Validators.integer], fields.mttotecnico.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.required(fields.archivo.caption) : null], fields.archivo.isInvalid],
            ["usuario", [fields.usuario.visible && fields.usuario.required ? ew.Validators.required(fields.usuario.caption) : null], fields.usuario.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid]
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
<input type="hidden" name="t" value="sco_mttotecnico_adjunto">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_mttotecnico") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_mttotecnico">
<input type="hidden" name="fk_Nmttotecnico" value="<?= HtmlEncode($Page->mttotecnico->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nmttotecnico_adjunto->Visible) { // Nmttotecnico_adjunto ?>
    <div id="r_Nmttotecnico_adjunto"<?= $Page->Nmttotecnico_adjunto->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_adjunto_Nmttotecnico_adjunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nmttotecnico_adjunto->caption() ?><?= $Page->Nmttotecnico_adjunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nmttotecnico_adjunto->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_Nmttotecnico_adjunto">
<span<?= $Page->Nmttotecnico_adjunto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nmttotecnico_adjunto->getDisplayValue($Page->Nmttotecnico_adjunto->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_mttotecnico_adjunto" data-field="x_Nmttotecnico_adjunto" data-hidden="1" name="x_Nmttotecnico_adjunto" id="x_Nmttotecnico_adjunto" value="<?= HtmlEncode($Page->Nmttotecnico_adjunto->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mttotecnico->Visible) { // mttotecnico ?>
    <div id="r_mttotecnico"<?= $Page->mttotecnico->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_adjunto_mttotecnico" for="x_mttotecnico" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mttotecnico->caption() ?><?= $Page->mttotecnico->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mttotecnico->cellAttributes() ?>>
<?php if ($Page->mttotecnico->getSessionValue() != "") { ?>
<span id="el_sco_mttotecnico_adjunto_mttotecnico">
<span<?= $Page->mttotecnico->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->mttotecnico->getDisplayValue($Page->mttotecnico->ViewValue))) ?>"></span>
<input type="hidden" id="x_mttotecnico" name="x_mttotecnico" value="<?= HtmlEncode($Page->mttotecnico->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_sco_mttotecnico_adjunto_mttotecnico">
<input type="<?= $Page->mttotecnico->getInputTextType() ?>" name="x_mttotecnico" id="x_mttotecnico" data-table="sco_mttotecnico_adjunto" data-field="x_mttotecnico" value="<?= $Page->mttotecnico->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->mttotecnico->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->mttotecnico->formatPattern()) ?>"<?= $Page->mttotecnico->editAttributes() ?> aria-describedby="x_mttotecnico_help">
<?= $Page->mttotecnico->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mttotecnico->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_adjunto_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_nota">
<input type="<?= $Page->nota->getInputTextType() ?>" name="x_nota" id="x_nota" data-table="sco_mttotecnico_adjunto" data-field="x_nota" value="<?= $Page->nota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nota->formatPattern()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help">
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo"<?= $Page->archivo->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_adjunto_archivo" for="x_archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->archivo->caption() ?><?= $Page->archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->archivo->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_archivo">
<input type="<?= $Page->archivo->getInputTextType() ?>" name="x_archivo" id="x_archivo" data-table="sco_mttotecnico_adjunto" data-field="x_archivo" value="<?= $Page->archivo->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->archivo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->archivo->formatPattern()) ?>"<?= $Page->archivo->editAttributes() ?> aria-describedby="x_archivo_help">
<?= $Page->archivo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->archivo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <div id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_adjunto_usuario" for="x_usuario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario->caption() ?><?= $Page->usuario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_usuario">
<input type="<?= $Page->usuario->getInputTextType() ?>" name="x_usuario" id="x_usuario" data-table="sco_mttotecnico_adjunto" data-field="x_usuario" value="<?= $Page->usuario->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->usuario->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->usuario->formatPattern()) ?>"<?= $Page->usuario->editAttributes() ?> aria-describedby="x_usuario_help">
<?= $Page->usuario->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->usuario->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_mttotecnico_adjunto_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_mttotecnico_adjunto" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_mttotecnico_adjuntoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_mttotecnico_adjuntoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_mttotecnico_adjunto");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
