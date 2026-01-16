<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaIncidenciaDetalleEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_flota_incidencia_detalleedit" id="fsco_flota_incidencia_detalleedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_flota_incidencia_detalleedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flota_incidencia_detalleedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["archivo", [fields.archivo.visible && fields.archivo.required ? ew.Validators.fileRequired(fields.archivo.caption) : null], fields.archivo.isInvalid],
            ["proveedor", [fields.proveedor.visible && fields.proveedor.required ? ew.Validators.required(fields.proveedor.caption) : null], fields.proveedor.isInvalid],
            ["costo", [fields.costo.visible && fields.costo.required ? ew.Validators.required(fields.costo.caption) : null, ew.Validators.float], fields.costo.isInvalid]
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
            "proveedor": <?= $Page->proveedor->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_flota_incidencia_detalle">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_flota_incidencia") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_flota_incidencia">
<input type="hidden" name="fk_Nflota_incidencia" value="<?= HtmlEncode($Page->flota_incidencia->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_detalle_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_detalle_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidencia_detalleedit_x_tipo"
        <?php } ?>
        data-table="sco_flota_incidencia_detalle"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidencia_detalleedit", function() {
    var options = { name: "x_tipo", selectId: "fsco_flota_incidencia_detalleedit_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidencia_detalleedit.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_flota_incidencia_detalleedit" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_flota_incidencia_detalleedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia_detalle.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <div id="r_archivo"<?= $Page->archivo->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_detalle_archivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->archivo->caption() ?><?= $Page->archivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->archivo->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_detalle_archivo">
<div id="fd_x_archivo" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_archivo"
        name="x_archivo"
        class="form-control ew-file-input"
        title="<?= $Page->archivo->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_flota_incidencia_detalle"
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
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <div id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_detalle_proveedor" for="x_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proveedor->caption() ?><?= $Page->proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_detalle_proveedor">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-select ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        <?php if (!$Page->proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_flota_incidencia_detalleedit_x_proveedor"
        <?php } ?>
        data-table="sco_flota_incidencia_detalle"
        data-field="x_proveedor"
        data-value-separator="<?= $Page->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->proveedor->getPlaceHolder()) ?>"
        <?= $Page->proveedor->editAttributes() ?>>
        <?= $Page->proveedor->selectOptionListHtml("x_proveedor") ?>
    </select>
    <?= $Page->proveedor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->proveedor->getErrorMessage() ?></div>
<?= $Page->proveedor->Lookup->getParamTag($Page, "p_x_proveedor") ?>
<?php if (!$Page->proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_flota_incidencia_detalleedit", function() {
    var options = { name: "x_proveedor", selectId: "fsco_flota_incidencia_detalleedit_x_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_flota_incidencia_detalleedit.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fsco_flota_incidencia_detalleedit" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fsco_flota_incidencia_detalleedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_flota_incidencia_detalle.fields.proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <div id="r_costo"<?= $Page->costo->rowAttributes() ?>>
        <label id="elh_sco_flota_incidencia_detalle_costo" for="x_costo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costo->caption() ?><?= $Page->costo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costo->cellAttributes() ?>>
<span id="el_sco_flota_incidencia_detalle_costo">
<input type="<?= $Page->costo->getInputTextType() ?>" name="x_costo" id="x_costo" data-table="sco_flota_incidencia_detalle" data-field="x_costo" value="<?= $Page->costo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->costo->formatPattern()) ?>"<?= $Page->costo->editAttributes() ?> aria-describedby="x_costo_help">
<?= $Page->costo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->costo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_flota_incidencia_detalle" data-field="x_Nflota_incidencia_detalle" data-hidden="1" name="x_Nflota_incidencia_detalle" id="x_Nflota_incidencia_detalle" value="<?= HtmlEncode($Page->Nflota_incidencia_detalle->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_flota_incidencia_detalleedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_flota_incidencia_detalleedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_flota_incidencia_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
