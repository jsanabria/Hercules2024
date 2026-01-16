<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_orden_compraadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compraadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["unidad_solicitante", [fields.unidad_solicitante.visible && fields.unidad_solicitante.required ? ew.Validators.required(fields.unidad_solicitante.caption) : null], fields.unidad_solicitante.isInvalid],
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
            "unidad_solicitante": <?= $Page->unidad_solicitante->toClientList($Page) ?>,
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
<form name="fsco_orden_compraadd" id="fsco_orden_compraadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden_compra">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
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
        data-select2-id="fsco_orden_compraadd_x_unidad_solicitante"
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
loadjs.ready("fsco_orden_compraadd", function() {
    var options = { name: "x_unidad_solicitante", selectId: "fsco_orden_compraadd_x_unidad_solicitante" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compraadd.lists.unidad_solicitante?.lookupOptions.length) {
        options.data = { id: "x_unidad_solicitante", form: "fsco_orden_compraadd" };
    } else {
        options.ajax = { id: "x_unidad_solicitante", form: "fsco_orden_compraadd", limit: ew.LOOKUP_PAGE_SIZE };
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
</div><!-- /page* -->
<?php
    if (in_array("sco_orden_compra_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_orden_compra_detalle->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_orden_compra_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOrdenCompraDetalleGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_nota_orden_compra", explode(",", $Page->getCurrentDetailTable())) && $sco_nota_orden_compra->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota_orden_compra", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaOrdenCompraGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_orden_compraadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_orden_compraadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_orden_compra");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
