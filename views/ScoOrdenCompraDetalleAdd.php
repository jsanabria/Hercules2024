<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDetalleAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_orden_compra_detalleadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_orden_compra_detalleadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo_insumo", [fields.tipo_insumo.visible && fields.tipo_insumo.required ? ew.Validators.required(fields.tipo_insumo.caption) : null], fields.tipo_insumo.isInvalid],
            ["articulo", [fields.articulo.visible && fields.articulo.required ? ew.Validators.required(fields.articulo.caption) : null], fields.articulo.isInvalid],
            ["unidad_medida", [fields.unidad_medida.visible && fields.unidad_medida.required ? ew.Validators.required(fields.unidad_medida.caption) : null], fields.unidad_medida.isInvalid],
            ["cantidad", [fields.cantidad.visible && fields.cantidad.required ? ew.Validators.required(fields.cantidad.caption) : null, ew.Validators.float], fields.cantidad.isInvalid],
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
            "tipo_insumo": <?= $Page->tipo_insumo->toClientList($Page) ?>,
            "articulo": <?= $Page->articulo->toClientList($Page) ?>,
            "unidad_medida": <?= $Page->unidad_medida->toClientList($Page) ?>,
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_orden_compra_detalleadd" id="fsco_orden_compra_detalleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_orden_compra_detalle">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_orden_compra") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_orden_compra">
<input type="hidden" name="fk_Norden_compra" value="<?= HtmlEncode($Page->orden_compra->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
    <div id="r_tipo_insumo"<?= $Page->tipo_insumo->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_tipo_insumo" for="x_tipo_insumo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_insumo->caption() ?><?= $Page->tipo_insumo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_insumo->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_tipo_insumo">
    <select
        id="x_tipo_insumo"
        name="x_tipo_insumo"
        class="form-select ew-select<?= $Page->tipo_insumo->isInvalidClass() ?>"
        <?php if (!$Page->tipo_insumo->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detalleadd_x_tipo_insumo"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_tipo_insumo"
        data-value-separator="<?= $Page->tipo_insumo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_insumo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo_insumo->editAttributes() ?>>
        <?= $Page->tipo_insumo->selectOptionListHtml("x_tipo_insumo") ?>
    </select>
    <?= $Page->tipo_insumo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_insumo->getErrorMessage() ?></div>
<?= $Page->tipo_insumo->Lookup->getParamTag($Page, "p_x_tipo_insumo") ?>
<?php if (!$Page->tipo_insumo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detalleadd", function() {
    var options = { name: "x_tipo_insumo", selectId: "fsco_orden_compra_detalleadd_x_tipo_insumo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detalleadd.lists.tipo_insumo?.lookupOptions.length) {
        options.data = { id: "x_tipo_insumo", form: "fsco_orden_compra_detalleadd" };
    } else {
        options.ajax = { id: "x_tipo_insumo", form: "fsco_orden_compra_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.tipo_insumo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
    <div id="r_articulo"<?= $Page->articulo->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_articulo" for="x_articulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->articulo->caption() ?><?= $Page->articulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->articulo->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_articulo">
    <select
        id="x_articulo"
        name="x_articulo"
        class="form-control ew-select<?= $Page->articulo->isInvalidClass() ?>"
        data-select2-id="fsco_orden_compra_detalleadd_x_articulo"
        data-table="sco_orden_compra_detalle"
        data-field="x_articulo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->articulo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->articulo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo->getPlaceHolder()) ?>"
        <?= $Page->articulo->editAttributes() ?>>
        <?= $Page->articulo->selectOptionListHtml("x_articulo") ?>
    </select>
    <?= $Page->articulo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->articulo->getErrorMessage() ?></div>
<?= $Page->articulo->Lookup->getParamTag($Page, "p_x_articulo") ?>
<script>
loadjs.ready("fsco_orden_compra_detalleadd", function() {
    var options = { name: "x_articulo", selectId: "fsco_orden_compra_detalleadd_x_articulo" };
    if (fsco_orden_compra_detalleadd.lists.articulo?.lookupOptions.length) {
        options.data = { id: "x_articulo", form: "fsco_orden_compra_detalleadd" };
    } else {
        options.ajax = { id: "x_articulo", form: "fsco_orden_compra_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.articulo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
    <div id="r_unidad_medida"<?= $Page->unidad_medida->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_unidad_medida" for="x_unidad_medida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unidad_medida->caption() ?><?= $Page->unidad_medida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unidad_medida->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_unidad_medida">
    <select
        id="x_unidad_medida"
        name="x_unidad_medida"
        class="form-select ew-select<?= $Page->unidad_medida->isInvalidClass() ?>"
        <?php if (!$Page->unidad_medida->IsNativeSelect) { ?>
        data-select2-id="fsco_orden_compra_detalleadd_x_unidad_medida"
        <?php } ?>
        data-table="sco_orden_compra_detalle"
        data-field="x_unidad_medida"
        data-value-separator="<?= $Page->unidad_medida->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unidad_medida->getPlaceHolder()) ?>"
        <?= $Page->unidad_medida->editAttributes() ?>>
        <?= $Page->unidad_medida->selectOptionListHtml("x_unidad_medida") ?>
    </select>
    <?= $Page->unidad_medida->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->unidad_medida->getErrorMessage() ?></div>
<?= $Page->unidad_medida->Lookup->getParamTag($Page, "p_x_unidad_medida") ?>
<?php if (!$Page->unidad_medida->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_orden_compra_detalleadd", function() {
    var options = { name: "x_unidad_medida", selectId: "fsco_orden_compra_detalleadd_x_unidad_medida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detalleadd.lists.unidad_medida?.lookupOptions.length) {
        options.data = { id: "x_unidad_medida", form: "fsco_orden_compra_detalleadd" };
    } else {
        options.ajax = { id: "x_unidad_medida", form: "fsco_orden_compra_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_orden_compra_detalle.fields.unidad_medida.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <div id="r_cantidad"<?= $Page->cantidad->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_cantidad" for="x_cantidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cantidad->caption() ?><?= $Page->cantidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cantidad->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_cantidad">
<input type="<?= $Page->cantidad->getInputTextType() ?>" name="x_cantidad" id="x_cantidad" data-table="sco_orden_compra_detalle" data-field="x_cantidad" value="<?= $Page->cantidad->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->cantidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cantidad->formatPattern()) ?>"<?= $Page->cantidad->editAttributes() ?> aria-describedby="x_cantidad_help">
<?= $Page->cantidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cantidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_descripcion">
<input type="<?= $Page->descripcion->getInputTextType() ?>" name="x_descripcion" id="x_descripcion" data-table="sco_orden_compra_detalle" data-field="x_descripcion" value="<?= $Page->descripcion->EditValue ?>" size="15" maxlength="60" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion->formatPattern()) ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help">
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
    <div id="r_imagen"<?= $Page->imagen->rowAttributes() ?>>
        <label id="elh_sco_orden_compra_detalle_imagen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imagen->caption() ?><?= $Page->imagen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->imagen->cellAttributes() ?>>
<span id="el_sco_orden_compra_detalle_imagen">
<div id="fd_x_imagen" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_imagen"
        name="x_imagen"
        class="form-control ew-file-input"
        title="<?= $Page->imagen->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_orden_compra_detalle"
        data-field="x_imagen"
        data-size="255"
        data-accept-file-types="<?= $Page->imagen->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->imagen->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->imagen->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_imagen_help"
        <?= ($Page->imagen->ReadOnly || $Page->imagen->Disabled) ? " disabled" : "" ?>
        <?= $Page->imagen->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->imagen->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->imagen->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_imagen" id= "fn_x_imagen" value="<?= $Page->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x_imagen" id= "fa_x_imagen" value="0">
<table id="ft_x_imagen" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
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
        data-select2-id="fsco_orden_compra_detalleadd_x_disponible"
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
loadjs.ready("fsco_orden_compra_detalleadd", function() {
    var options = { name: "x_disponible", selectId: "fsco_orden_compra_detalleadd_x_disponible" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detalleadd.lists.disponible?.lookupOptions.length) {
        options.data = { id: "x_disponible", form: "fsco_orden_compra_detalleadd" };
    } else {
        options.ajax = { id: "x_disponible", form: "fsco_orden_compra_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_orden_compra_detalleadd_x_unidad_medida_recibida"
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
loadjs.ready("fsco_orden_compra_detalleadd", function() {
    var options = { name: "x_unidad_medida_recibida", selectId: "fsco_orden_compra_detalleadd_x_unidad_medida_recibida" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_orden_compra_detalleadd.lists.unidad_medida_recibida?.lookupOptions.length) {
        options.data = { id: "x_unidad_medida_recibida", form: "fsco_orden_compra_detalleadd" };
    } else {
        options.ajax = { id: "x_unidad_medida_recibida", form: "fsco_orden_compra_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
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
    <?php if (strval($Page->orden_compra->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_orden_compra" id="x_orden_compra" value="<?= HtmlEncode(strval($Page->orden_compra->getSessionValue())) ?>">
    <?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_orden_compra_detalleadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_orden_compra_detalleadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
