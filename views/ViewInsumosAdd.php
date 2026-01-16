<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewInsumosAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_insumos: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fview_insumosadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_insumosadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["articulo_inventario", [fields.articulo_inventario.visible && fields.articulo_inventario.required ? ew.Validators.required(fields.articulo_inventario.caption) : null], fields.articulo_inventario.isInvalid],
            ["sto_min", [fields.sto_min.visible && fields.sto_min.required ? ew.Validators.required(fields.sto_min.caption) : null, ew.Validators.integer], fields.sto_min.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
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
<form name="fview_insumosadd" id="fview_insumosadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_insumos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_view_insumos_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_view_insumos_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fview_insumosadd_x_tipo"
        <?php } ?>
        data-table="view_insumos"
        data-field="x_tipo"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_insumosadd", function() {
    var options = { name: "x_tipo", selectId: "fview_insumosadd_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_insumosadd.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fview_insumosadd" };
    } else {
        options.ajax = { id: "x_tipo", form: "fview_insumosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_insumos.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_view_insumos_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_view_insumos_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="view_insumos" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->articulo_inventario->Visible) { // articulo_inventario ?>
    <div id="r_articulo_inventario"<?= $Page->articulo_inventario->rowAttributes() ?>>
        <label id="elh_view_insumos_articulo_inventario" for="x_articulo_inventario" class="<?= $Page->LeftColumnClass ?>"><?= $Page->articulo_inventario->caption() ?><?= $Page->articulo_inventario->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->articulo_inventario->cellAttributes() ?>>
<span id="el_view_insumos_articulo_inventario">
    <select
        id="x_articulo_inventario"
        name="x_articulo_inventario"
        class="form-select ew-select<?= $Page->articulo_inventario->isInvalidClass() ?>"
        <?php if (!$Page->articulo_inventario->IsNativeSelect) { ?>
        data-select2-id="fview_insumosadd_x_articulo_inventario"
        <?php } ?>
        data-table="view_insumos"
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
loadjs.ready("fview_insumosadd", function() {
    var options = { name: "x_articulo_inventario", selectId: "fview_insumosadd_x_articulo_inventario" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_insumosadd.lists.articulo_inventario?.lookupOptions.length) {
        options.data = { id: "x_articulo_inventario", form: "fview_insumosadd" };
    } else {
        options.ajax = { id: "x_articulo_inventario", form: "fview_insumosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_insumos.fields.articulo_inventario.selectOptions);
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
        <label id="elh_view_insumos_sto_min" for="x_sto_min" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sto_min->caption() ?><?= $Page->sto_min->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sto_min->cellAttributes() ?>>
<span id="el_view_insumos_sto_min">
<input type="<?= $Page->sto_min->getInputTextType() ?>" name="x_sto_min" id="x_sto_min" data-table="view_insumos" data-field="x_sto_min" value="<?= $Page->sto_min->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->sto_min->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sto_min->formatPattern()) ?>"<?= $Page->sto_min->editAttributes() ?> aria-describedby="x_sto_min_help">
<?= $Page->sto_min->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sto_min->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_view_insumos_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_view_insumos_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fview_insumosadd_x_activo"
        <?php } ?>
        data-table="view_insumos"
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
loadjs.ready("fview_insumosadd", function() {
    var options = { name: "x_activo", selectId: "fview_insumosadd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_insumosadd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fview_insumosadd" };
    } else {
        options.ajax = { id: "x_activo", form: "fview_insumosadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_insumos.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fview_insumosadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fview_insumosadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("view_insumos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
