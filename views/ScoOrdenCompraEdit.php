<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_orden_compraedit" id="fsco_orden_compraedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_orden_compraedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compraedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Norden_compra", [fields.Norden_compra.visible && fields.Norden_compra.required ? ew.Validators.required(fields.Norden_compra.caption) : null], fields.Norden_compra.isInvalid],
            ["unidad_solicitante", [fields.unidad_solicitante.visible && fields.unidad_solicitante.required ? ew.Validators.required(fields.unidad_solicitante.caption) : null], fields.unidad_solicitante.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid]
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
            "unidad_solicitante": <?= $Page->unidad_solicitante->toClientList($Page) ?>,
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_orden_compra">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Norden_compra->Visible) { // Norden_compra ?>
    <div id="r_Norden_compra"<?= $Page->Norden_compra->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_Norden_compra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Norden_compra->caption() ?><?= $Page->Norden_compra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Norden_compra->cellAttributes() ?>>
<span id="el_sco_orden_compra_Norden_compra">
<span<?= $Page->Norden_compra->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Norden_compra->getDisplayValue($Page->Norden_compra->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra" data-field="x_Norden_compra" data-hidden="1" name="x_Norden_compra" id="x_Norden_compra" value="<?= HtmlEncode($Page->Norden_compra->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidad_solicitante->Visible) { // unidad_solicitante ?>
    <div id="r_unidad_solicitante"<?= $Page->unidad_solicitante->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_unidad_solicitante" for="x_unidad_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidad_solicitante->caption() ?><?= $Page->unidad_solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidad_solicitante->cellAttributes() ?>>
<span id="el_sco_orden_compra_unidad_solicitante">
    <select
        id="x_unidad_solicitante"
        name="x_unidad_solicitante"
        class="form-select ew-select<?= $Page->unidad_solicitante->isInvalidClass() ?>"
        <?php if (!$Page->unidad_solicitante->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compraedit_x_unidad_solicitante"
        <?php } ?>
        data-table="sco_orden_compra"
        data-field="x_unidad_solicitante"
        data-value-separator="<?= $Page->unidad_solicitante->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_solicitante->getPlaceHolder()) ?>"
        <?= $Page->unidad_solicitante->editAttributes() ?>>
        <?= $Page->unidad_solicitante->selectOptionListHtml("x_unidad_solicitante") ?>
    </select>
    <?= $Page->unidad_solicitante->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->unidad_solicitante->getErrorMessage() ?></div>
<?= $Page->unidad_solicitante->Lookup->getParamTag($Page, "p_x_unidad_solicitante") ?>
<?php if (!$Page->unidad_solicitante->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compraedit", function() {
    var options = { name: "x_unidad_solicitante", selectId: "fsco_orden_compraedit_x_unidad_solicitante" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compraedit.lists.unidad_solicitante?.lookupOptions.length) {
        options.data = { id: "x_unidad_solicitante", form: "fsco_orden_compraedit" };
    } else {
        options.ajax = { id: "x_unidad_solicitante", form: "fsco_orden_compraedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra.fields.unidad_solicitante.selectOptions);
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
        <label id="elh_sco_orden_compra_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_orden_compra_nota">
<textarea data-table="sco_orden_compra" data-field="x_nota" name="x_nota" id="x_nota" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_orden_compra_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compraedit_x_estatus"
        <?php } ?>
        data-table="sco_orden_compra"
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
loadjs.ready("fsco_orden_compraedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_orden_compraedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compraedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_orden_compraedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_orden_compraedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra.fields.estatus.selectOptions);
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
    if (in_array("sco_orden_compra_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_orden_compra_detalle->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_orden_compra_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOrdenCompraDetalleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_nota_orden_compra", explode(",", $Page->getCurrentDetailTable())) && $sco_nota_orden_compra->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota_orden_compra", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaOrdenCompraGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_orden_compraedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_orden_compraedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_orden_compra");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
