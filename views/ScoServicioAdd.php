<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoServicioAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_servicio: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_servicioadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_servicioadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["articulo_inventario", [fields.articulo_inventario.visible && fields.articulo_inventario.required ? ew.Validators.required(fields.articulo_inventario.caption) : null], fields.articulo_inventario.isInvalid],
            ["sto_min", [fields.sto_min.visible && fields.sto_min.required ? ew.Validators.required(fields.sto_min.caption) : null, ew.Validators.integer], fields.sto_min.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["venta", [fields.venta.visible && fields.venta.required ? ew.Validators.required(fields.venta.caption) : null], fields.venta.isInvalid]
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
            "articulo_inventario": <?= $Page->articulo_inventario->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
            "venta": <?= $Page->venta->toClientList($Page) ?>,
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
<form name="fsco_servicioadd" id="fsco_servicioadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_servicio">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_servicio_tipo") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_servicio_tipo">
<input type="hidden" name="fk_Nservicio_tipo" value="<?= HtmlEncode($Page->tipo->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_servicio_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<?php if ($Page->tipo->getSessionValue() != "") { ?>
<span id="el_sco_servicio_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo->getDisplayValue($Page->tipo->ViewValue) ?></span></span>
<input type="hidden" id="x_tipo" name="x_tipo" value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>" data-hidden="1">
</span>
<?php } else { ?>
<span id="el_sco_servicio_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-control ew-select<?= $Page->tipo->isInvalidClass() ?>"
        data-select2-id="fsco_servicioadd_x_tipo"
        data-table="sco_servicio"
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
loadjs.ready("fsco_servicioadd", function() {
    var options = { name: "x_tipo", selectId: "fsco_servicioadd_x_tipo" };
    if (fsco_servicioadd.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_servicioadd" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_servicioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_servicio.fields.tipo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_sco_servicio_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_servicio_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="sco_servicio" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->articulo_inventario->Visible) { // articulo_inventario ?>
    <div id="r_articulo_inventario"<?= $Page->articulo_inventario->rowAttributes() ?>>
        <label id="elh_sco_servicio_articulo_inventario" for="x_articulo_inventario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->articulo_inventario->caption() ?><?= $Page->articulo_inventario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->articulo_inventario->cellAttributes() ?>>
<span id="el_sco_servicio_articulo_inventario">
    <select
        id="x_articulo_inventario"
        name="x_articulo_inventario"
        class="form-select ew-select<?= $Page->articulo_inventario->isInvalidClass() ?>"
        <?php if (!$Page->articulo_inventario->IsNativeSelect) { ?>
        data-select2-id="fsco_servicioadd_x_articulo_inventario"
        <?php } ?>
        data-table="sco_servicio"
        data-field="x_articulo_inventario"
        data-value-separator="<?= $Page->articulo_inventario->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo_inventario->getPlaceHolder()) ?>"
        <?= $Page->articulo_inventario->editAttributes() ?>>
        <?= $Page->articulo_inventario->selectOptionListHtml("x_articulo_inventario") ?>
    </select>
    <?= $Page->articulo_inventario->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->articulo_inventario->getErrorMessage() ?></div>
<?php if (!$Page->articulo_inventario->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_servicioadd", function() {
    var options = { name: "x_articulo_inventario", selectId: "fsco_servicioadd_x_articulo_inventario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_servicioadd.lists.articulo_inventario?.lookupOptions.length) {
        options.data = { id: "x_articulo_inventario", form: "fsco_servicioadd" };
    } else {
        options.ajax = { id: "x_articulo_inventario", form: "fsco_servicioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_servicio.fields.articulo_inventario.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sto_min->Visible) { // sto_min ?>
    <div id="r_sto_min"<?= $Page->sto_min->rowAttributes() ?>>
        <label id="elh_sco_servicio_sto_min" for="x_sto_min" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sto_min->caption() ?><?= $Page->sto_min->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sto_min->cellAttributes() ?>>
<span id="el_sco_servicio_sto_min">
<input type="<?= $Page->sto_min->getInputTextType() ?>" name="x_sto_min" id="x_sto_min" data-table="sco_servicio" data-field="x_sto_min" value="<?= $Page->sto_min->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->sto_min->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sto_min->formatPattern()) ?>"<?= $Page->sto_min->editAttributes() ?> aria-describedby="x_sto_min_help">
<?= $Page->sto_min->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sto_min->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_servicio_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_servicio_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_servicioadd_x_activo"
        <?php } ?>
        data-table="sco_servicio"
        data-field="x_activo"
        data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->activo->getPlaceHolder()) ?>"
        <?= $Page->activo->editAttributes() ?>>
        <?= $Page->activo->selectOptionListHtml("x_activo") ?>
    </select>
    <?= $Page->activo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
<?php if (!$Page->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_servicioadd", function() {
    var options = { name: "x_activo", selectId: "fsco_servicioadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_servicioadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_servicioadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_servicioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_servicio.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
    <div id="r_venta"<?= $Page->venta->rowAttributes() ?>>
        <label id="elh_sco_servicio_venta" for="x_venta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->venta->caption() ?><?= $Page->venta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->venta->cellAttributes() ?>>
<span id="el_sco_servicio_venta">
    <select
        id="x_venta"
        name="x_venta"
        class="form-select ew-select<?= $Page->venta->isInvalidClass() ?>"
        <?php if (!$Page->venta->IsNativeSelect) { ?>
        data-select2-id="fsco_servicioadd_x_venta"
        <?php } ?>
        data-table="sco_servicio"
        data-field="x_venta"
        data-value-separator="<?= $Page->venta->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->venta->getPlaceHolder()) ?>"
        <?= $Page->venta->editAttributes() ?>>
        <?= $Page->venta->selectOptionListHtml("x_venta") ?>
    </select>
    <?= $Page->venta->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->venta->getErrorMessage() ?></div>
<?php if (!$Page->venta->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_servicioadd", function() {
    var options = { name: "x_venta", selectId: "fsco_servicioadd_x_venta" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_servicioadd.lists.venta?.lookupOptions.length) {
        options.data = { id: "x_venta", form: "fsco_servicioadd" };
    } else {
        options.ajax = { id: "x_venta", form: "fsco_servicioadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_servicio.fields.venta.selectOptions);
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
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_servicioadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_servicioadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_servicio");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
