<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteSegurosAdjuntoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_expediente_seguros_adjuntoedit" id="fsco_expediente_seguros_adjuntoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_seguros_adjunto: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_expediente_seguros_adjuntoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_seguros_adjuntoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nexpediente_seguros_adjunto", [fields.Nexpediente_seguros_adjunto.visible && fields.Nexpediente_seguros_adjunto.required ? ew.Validators.required(fields.Nexpediente_seguros_adjunto.caption) : null], fields.Nexpediente_seguros_adjunto.isInvalid],
            ["expediente_seguros", [fields.expediente_seguros.visible && fields.expediente_seguros.required ? ew.Validators.required(fields.expediente_seguros.caption) : null, ew.Validators.integer], fields.expediente_seguros.isInvalid],
            ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente_seguros_adjunto">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_expediente_seguros") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_expediente_seguros">
<input type="hidden" name="fk_Nexpediente_seguros" value="<?= HtmlEncode($Page->expediente_seguros->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nexpediente_seguros_adjunto->Visible) { // Nexpediente_seguros_adjunto ?>
    <div id="r_Nexpediente_seguros_adjunto"<?= $Page->Nexpediente_seguros_adjunto->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_adjunto_Nexpediente_seguros_adjunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nexpediente_seguros_adjunto->caption() ?><?= $Page->Nexpediente_seguros_adjunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nexpediente_seguros_adjunto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_Nexpediente_seguros_adjunto">
<span<?= $Page->Nexpediente_seguros_adjunto->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nexpediente_seguros_adjunto->getDisplayValue($Page->Nexpediente_seguros_adjunto->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente_seguros_adjunto" data-field="x_Nexpediente_seguros_adjunto" data-hidden="1" name="x_Nexpediente_seguros_adjunto" id="x_Nexpediente_seguros_adjunto" value="<?= HtmlEncode($Page->Nexpediente_seguros_adjunto->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expediente_seguros->Visible) { // expediente_seguros ?>
    <div id="r_expediente_seguros"<?= $Page->expediente_seguros->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_adjunto_expediente_seguros" for="x_expediente_seguros" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expediente_seguros->caption() ?><?= $Page->expediente_seguros->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expediente_seguros->cellAttributes() ?>>
<?php if ($Page->expediente_seguros->getSessionValue() != "") { ?>
<span id="el_sco_expediente_seguros_adjunto_expediente_seguros">
<span<?= $Page->expediente_seguros->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->expediente_seguros->getDisplayValue($Page->expediente_seguros->ViewValue))) ?>"></span>
<input type="hidden" id="x_expediente_seguros" name="x_expediente_seguros" value="<?= HtmlEncode($Page->expediente_seguros->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_sco_expediente_seguros_adjunto_expediente_seguros">
<input type="<?= $Page->expediente_seguros->getInputTextType() ?>" name="x_expediente_seguros" id="x_expediente_seguros" data-table="sco_expediente_seguros_adjunto" data-field="x_expediente_seguros" value="<?= $Page->expediente_seguros->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->expediente_seguros->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->expediente_seguros->formatPattern()) ?>"<?= $Page->expediente_seguros->editAttributes() ?> aria-describedby="x_expediente_seguros_help">
<?= $Page->expediente_seguros->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expediente_seguros->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo"<?= $Page->archivo->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_adjunto_archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->archivo->caption() ?><?= $Page->archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->archivo->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_archivo">
<div id="fd_x_archivo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_archivo"
        name="x_archivo"
        class="form-control ew-file-input"
        title="<?= $Page->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_expediente_seguros_adjunto"
        data-field="x_archivo"
        data-size="255"
        data-accept-file-types="<?= $Page->archivo->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->archivo->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->archivo->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_archivo_help"
        <?= ($Page->archivo->ReadOnly || $Page->archivo->Disabled) ? " disabled" : "" ?>
        <?= $Page->archivo->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->archivo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->archivo->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_archivo" id= "fn_x_archivo" value="<?= $Page->archivo->Upload->FileName ?>">
<input type="hidden" name="fa_x_archivo" id= "fa_x_archivo" value="<?= (Post("fa_x_archivo") == "0") ? "0" : "1" ?>">
<table id="ft_x_archivo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_adjunto_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_adjunto_nota">
<input type="<?= $Page->nota->getInputTextType() ?>" name="x_nota" id="x_nota" data-table="sco_expediente_seguros_adjunto" data-field="x_nota" value="<?= $Page->nota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nota->formatPattern()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help">
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expediente_seguros_adjuntoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expediente_seguros_adjuntoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_expediente_seguros_adjunto");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
