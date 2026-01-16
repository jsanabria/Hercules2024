<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosArticulosEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_costos_articulosedit" id="fsco_costos_articulosedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_articulos: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_costos_articulosedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_articulosedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["Ncostos_articulo", [fields.Ncostos_articulo.visible && fields.Ncostos_articulo.required ? ew.Validators.required(fields.Ncostos_articulo.caption) : null], fields.Ncostos_articulo.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["precio", [fields.precio.visible && fields.precio.required ? ew.Validators.required(fields.precio.caption) : null, ew.Validators.float], fields.precio.isInvalid],
            ["variacion", [fields.variacion.visible && fields.variacion.required ? ew.Validators.required(fields.variacion.caption) : null], fields.variacion.isInvalid],
            ["tipo_hercules", [fields.tipo_hercules.visible && fields.tipo_hercules.required ? ew.Validators.required(fields.tipo_hercules.caption) : null], fields.tipo_hercules.isInvalid],
            ["articulo_hercules", [fields.articulo_hercules.visible && fields.articulo_hercules.required ? ew.Validators.required(fields.articulo_hercules.caption) : null], fields.articulo_hercules.isInvalid]
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
            "tipo_hercules": <?= $Page->tipo_hercules->toClientList($Page) ?>,
            "articulo_hercules": <?= $Page->articulo_hercules->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_costos_articulos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_costos_articulos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo->getDisplayValue($Page->tipo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_tipo" data-hidden="1" name="x_tipo" id="x_tipo" value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Ncostos_articulo->Visible) { // Ncostos_articulo ?>
    <div id="r_Ncostos_articulo"<?= $Page->Ncostos_articulo->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_Ncostos_articulo" for="x_Ncostos_articulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Ncostos_articulo->caption() ?><?= $Page->Ncostos_articulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Ncostos_articulo->cellAttributes() ?>>
<span id="el_sco_costos_articulos_Ncostos_articulo">
<span<?= $Page->Ncostos_articulo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Ncostos_articulo->getDisplayValue($Page->Ncostos_articulo->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_Ncostos_articulo" data-hidden="1" name="x_Ncostos_articulo" id="x_Ncostos_articulo" value="<?= HtmlEncode($Page->Ncostos_articulo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_sco_costos_articulos_descripcion">
<span<?= $Page->descripcion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->descripcion->getDisplayValue($Page->descripcion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_descripcion" data-hidden="1" name="x_descripcion" id="x_descripcion" value="<?= HtmlEncode($Page->descripcion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precio->Visible) { // precio ?>
    <div id="r_precio"<?= $Page->precio->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_precio" for="x_precio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precio->caption() ?><?= $Page->precio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precio->cellAttributes() ?>>
<span id="el_sco_costos_articulos_precio">
<input type="<?= $Page->precio->getInputTextType() ?>" name="x_precio" id="x_precio" data-table="sco_costos_articulos" data-field="x_precio" value="<?= $Page->precio->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->precio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio->formatPattern()) ?>"<?= $Page->precio->editAttributes() ?> aria-describedby="x_precio_help">
<?= $Page->precio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
    <div id="r_variacion"<?= $Page->variacion->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_variacion" for="x_variacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->variacion->caption() ?><?= $Page->variacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->variacion->cellAttributes() ?>>
<span id="el_sco_costos_articulos_variacion">
<span<?= $Page->variacion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->variacion->getDisplayValue($Page->variacion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos_articulos" data-field="x_variacion" data-hidden="1" name="x_variacion" id="x_variacion" value="<?= HtmlEncode($Page->variacion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_hercules->Visible) { // tipo_hercules ?>
    <div id="r_tipo_hercules"<?= $Page->tipo_hercules->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_tipo_hercules" for="x_tipo_hercules" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_hercules->caption() ?><?= $Page->tipo_hercules->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_hercules->cellAttributes() ?>>
<span id="el_sco_costos_articulos_tipo_hercules">
    <select
        id="x_tipo_hercules"
        name="x_tipo_hercules"
        class="form-select ew-select<?= $Page->tipo_hercules->isInvalidClass() ?>"
        <?php if (!$Page->tipo_hercules->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_articulosedit_x_tipo_hercules"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_tipo_hercules"
        data-value-separator="<?= $Page->tipo_hercules->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_hercules->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo_hercules->editAttributes() ?>>
        <?= $Page->tipo_hercules->selectOptionListHtml("x_tipo_hercules") ?>
    </select>
    <?= $Page->tipo_hercules->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_hercules->getErrorMessage() ?></div>
<?= $Page->tipo_hercules->Lookup->getParamTag($Page, "p_x_tipo_hercules") ?>
<?php if (!$Page->tipo_hercules->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_articulosedit", function() {
    var options = { name: "x_tipo_hercules", selectId: "fsco_costos_articulosedit_x_tipo_hercules" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_articulosedit.lists.tipo_hercules?.lookupOptions.length) {
        options.data = { id: "x_tipo_hercules", form: "fsco_costos_articulosedit" };
    } else {
        options.ajax = { id: "x_tipo_hercules", form: "fsco_costos_articulosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.tipo_hercules.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->articulo_hercules->Visible) { // articulo_hercules ?>
    <div id="r_articulo_hercules"<?= $Page->articulo_hercules->rowAttributes() ?>>
        <label id="elh_sco_costos_articulos_articulo_hercules" for="x_articulo_hercules" class="<?= $Page->LeftColumnClass ?>"><?= $Page->articulo_hercules->caption() ?><?= $Page->articulo_hercules->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->articulo_hercules->cellAttributes() ?>>
<span id="el_sco_costos_articulos_articulo_hercules">
    <select
        id="x_articulo_hercules"
        name="x_articulo_hercules"
        class="form-select ew-select<?= $Page->articulo_hercules->isInvalidClass() ?>"
        <?php if (!$Page->articulo_hercules->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_articulosedit_x_articulo_hercules"
        <?php } ?>
        data-table="sco_costos_articulos"
        data-field="x_articulo_hercules"
        data-value-separator="<?= $Page->articulo_hercules->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->articulo_hercules->getPlaceHolder()) ?>"
        <?= $Page->articulo_hercules->editAttributes() ?>>
        <?= $Page->articulo_hercules->selectOptionListHtml("x_articulo_hercules") ?>
    </select>
    <?= $Page->articulo_hercules->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->articulo_hercules->getErrorMessage() ?></div>
<?= $Page->articulo_hercules->Lookup->getParamTag($Page, "p_x_articulo_hercules") ?>
<?php if (!$Page->articulo_hercules->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_articulosedit", function() {
    var options = { name: "x_articulo_hercules", selectId: "fsco_costos_articulosedit_x_articulo_hercules" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_articulosedit.lists.articulo_hercules?.lookupOptions.length) {
        options.data = { id: "x_articulo_hercules", form: "fsco_costos_articulosedit" };
    } else {
        options.ajax = { id: "x_articulo_hercules", form: "fsco_costos_articulosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_articulos.fields.articulo_hercules.selectOptions);
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_costos_articulosedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_costos_articulosedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_costos_articulos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
