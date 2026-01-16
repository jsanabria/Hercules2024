<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDetalleEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_orden_compra_detalleedit" id="fsco_orden_compra_detalleedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_orden_compra_detalleedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compra_detalleedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["tipo_insumo", [fields.tipo_insumo.visible && fields.tipo_insumo.required ? ew.Validators.required(fields.tipo_insumo.caption) : null], fields.tipo_insumo.isInvalid],
            ["articulo", [fields.articulo.visible && fields.articulo.required ? ew.Validators.required(fields.articulo.caption) : null], fields.articulo.isInvalid],
            ["unidad_medida", [fields.unidad_medida.visible && fields.unidad_medida.required ? ew.Validators.required(fields.unidad_medida.caption) : null], fields.unidad_medida.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null], fields.cantidad.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["imagen", [fields.imagen.visible && fields.imagen.required ? ew.Validators.fileRequired(fields.imagen.caption) : null], fields.imagen.isInvalid],
            ["disponible", [fields.disponible.visible && fields.disponible.required ? ew.Validators.required(fields.disponible.caption) : null], fields.disponible.isInvalid],
            ["unidad_medida_recibida", [fields.unidad_medida_recibida.visible && fields.unidad_medida_recibida.required ? ew.Validators.required(fields.unidad_medida_recibida.caption) : null], fields.unidad_medida_recibida.isInvalid],
            ["cantidad_recibida", [fields.cantidad_recibida.visible && fields.cantidad_recibida.required ? ew.Validators.required(fields.cantidad_recibida.caption) : null, ew.Validators.float], fields.cantidad_recibida.isInvalid]
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
            "disponible": <?= $Page->disponible->toClientList($Page) ?>,
            "unidad_medida_recibida": <?= $Page->unidad_medida_recibida->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_orden_compra_detalle">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_orden_compra") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_orden_compra">
<input type="hidden" name="fk_Norden_compra" value="<?= HtmlEncode($Page->orden_compra->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
    <div id="r_tipo_insumo"<?= $Page->tipo_insumo->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_tipo_insumo" for="x_tipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_insumo->caption() ?><?= $Page->tipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_tipo_insumo">
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo_insumo->getDisplayValue($Page->tipo_insumo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_tipo_insumo" data-hidden="1" name="x_tipo_insumo" id="x_tipo_insumo" value="<?= HtmlEncode($Page->tipo_insumo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
    <div id="r_articulo"<?= $Page->articulo->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_articulo" for="x_articulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->articulo->caption() ?><?= $Page->articulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->articulo->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_articulo">
<span<?= $Page->articulo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->articulo->getDisplayValue($Page->articulo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_articulo" data-hidden="1" name="x_articulo" id="x_articulo" value="<?= HtmlEncode($Page->articulo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
    <div id="r_unidad_medida"<?= $Page->unidad_medida->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_unidad_medida" for="x_unidad_medida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidad_medida->caption() ?><?= $Page->unidad_medida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidad_medida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_unidad_medida">
<span<?= $Page->unidad_medida->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->unidad_medida->getDisplayValue($Page->unidad_medida->EditValue) ?></span></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_unidad_medida" data-hidden="1" name="x_unidad_medida" id="x_unidad_medida" value="<?= HtmlEncode($Page->unidad_medida->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <div id="r_cantidad"<?= $Page->cantidad->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_cantidad" for="x_cantidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cantidad->caption() ?><?= $Page->cantidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cantidad->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_cantidad">
<span<?= $Page->cantidad->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cantidad->getDisplayValue($Page->cantidad->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_cantidad" data-hidden="1" name="x_cantidad" id="x_cantidad" value="<?= HtmlEncode($Page->cantidad->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->descripcion->getDisplayValue($Page->descripcion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_descripcion" data-hidden="1" name="x_descripcion" id="x_descripcion" value="<?= HtmlEncode($Page->descripcion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
    <div id="r_imagen"<?= $Page->imagen->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_imagen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imagen->caption() ?><?= $Page->imagen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->imagen->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_imagen">
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->EditValue, false) ?>
</span>
<input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_imagen" data-hidden="1" name="x_imagen" id="x_imagen" value="<?= HtmlEncode($Page->imagen->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
    <div id="r_disponible"<?= $Page->disponible->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_disponible" for="x_disponible" class="<?= $Page->LeftColumnClass ?>"><?= $Page->disponible->caption() ?><?= $Page->disponible->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->disponible->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_disponible">
    <select
        id="x_disponible"
        name="x_disponible"
        class="form-select ew-select<?= $Page->disponible->isInvalidClass() ?>"
        <?php if (!$Page->disponible->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detalleedit_x_disponible"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_disponible"
        data-value-separator="<?= $Page->disponible->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->disponible->getPlaceHolder()) ?>"
        <?= $Page->disponible->editAttributes() ?>>
        <?= $Page->disponible->selectOptionListHtml("x_disponible") ?>
    </select>
    <?= $Page->disponible->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->disponible->getErrorMessage() ?></div>
<?php if (!$Page->disponible->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detalleedit", function() {
    var options = { name: "x_disponible", selectId: "fsco_orden_compra_detalleedit_x_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detalleedit.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x_disponible", form: "fsco_orden_compra_detalleedit" };
    } else {
        options.ajax = { id: "x_disponible", form: "fsco_orden_compra_detalleedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.disponible.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
    <div id="r_unidad_medida_recibida"<?= $Page->unidad_medida_recibida->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_unidad_medida_recibida" for="x_unidad_medida_recibida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidad_medida_recibida->caption() ?><?= $Page->unidad_medida_recibida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidad_medida_recibida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_unidad_medida_recibida">
    <select
        id="x_unidad_medida_recibida"
        name="x_unidad_medida_recibida"
        class="form-select ew-select<?= $Page->unidad_medida_recibida->isInvalidClass() ?>"
        <?php if (!$Page->unidad_medida_recibida->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detalleedit_x_unidad_medida_recibida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida_recibida"
        data-value-separator="<?= $Page->unidad_medida_recibida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_medida_recibida->getPlaceHolder()) ?>"
        <?= $Page->unidad_medida_recibida->editAttributes() ?>>
        <?= $Page->unidad_medida_recibida->selectOptionListHtml("x_unidad_medida_recibida") ?>
    </select>
    <?= $Page->unidad_medida_recibida->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->unidad_medida_recibida->getErrorMessage() ?></div>
<?= $Page->unidad_medida_recibida->Lookup->getParamTag($Page, "p_x_unidad_medida_recibida") ?>
<?php if (!$Page->unidad_medida_recibida->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detalleedit", function() {
    var options = { name: "x_unidad_medida_recibida", selectId: "fsco_orden_compra_detalleedit_x_unidad_medida_recibida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detalleedit.lists.unidad_medida_recibida?.lookupOptions.length) {
        options.data = { id: "x_unidad_medida_recibida", form: "fsco_orden_compra_detalleedit" };
    } else {
        options.ajax = { id: "x_unidad_medida_recibida", form: "fsco_orden_compra_detalleedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida_recibida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
    <div id="r_cantidad_recibida"<?= $Page->cantidad_recibida->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_cantidad_recibida" for="x_cantidad_recibida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cantidad_recibida->caption() ?><?= $Page->cantidad_recibida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cantidad_recibida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_cantidad_recibida">
<input type="<?= $Page->cantidad_recibida->getInputTextType() ?>" name="x_cantidad_recibida" id="x_cantidad_recibida" data-table="sco_orden_compra_detalle" data-field="x_cantidad_recibida" value="<?= $Page->cantidad_recibida->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->cantidad_recibida->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad_recibida->formatPattern()) ?>"<?= $Page->cantidad_recibida->editAttributes() ?> aria-describedby="x_cantidad_recibida_help">
<?= $Page->cantidad_recibida->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cantidad_recibida->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_orden_compra_detalle" data-field="x_Norden_compra_detalle" data-hidden="1" name="x_Norden_compra_detalle" id="x_Norden_compra_detalle" value="<?= HtmlEncode($Page->Norden_compra_detalle->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_orden_compra_detalleedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_orden_compra_detalleedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_orden_compra_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $("#x_unidad_medida").closest(".col-sm-10").css("max-width", "200px");
});
</script>
