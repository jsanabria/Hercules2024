<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionPlantillasAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_plantillas: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fautogestion_plantillasadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fautogestion_plantillasadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["script", [fields.script.visible && fields.script.required ? ew.Validators.required(fields.script.caption) : null], fields.script.isInvalid],
            ["nivel", [fields.nivel.visible && fields.nivel.required ? ew.Validators.required(fields.nivel.caption) : null], fields.nivel.isInvalid],
            ["orden", [fields.orden.visible && fields.orden.required ? ew.Validators.required(fields.orden.caption) : null, ew.Validators.integer], fields.orden.isInvalid],
            ["codigo", [fields.codigo.visible && fields.codigo.required ? ew.Validators.required(fields.codigo.caption) : null], fields.codigo.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["imagen", [fields.imagen.visible && fields.imagen.required ? ew.Validators.fileRequired(fields.imagen.caption) : null], fields.imagen.isInvalid],
            ["mostrar", [fields.mostrar.visible && fields.mostrar.required ? ew.Validators.required(fields.mostrar.caption) : null], fields.mostrar.isInvalid]
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
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "nivel": <?= $Page->nivel->toClientList($Page) ?>,
            "mostrar": <?= $Page->mostrar->toClientList($Page) ?>,
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
<form name="fautogestion_plantillasadd" id="fautogestion_plantillasadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="autogestion_plantillas">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <div id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_autogestion_plantillas_servicio_tipo">
    <select
        id="x_servicio_tipo"
        name="x_servicio_tipo"
        class="form-select ew-select<?= $Page->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fautogestion_plantillasadd_x_servicio_tipo"
        <?php } ?>
        data-table="autogestion_plantillas"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Page->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_tipo->getPlaceHolder()) ?>"
        <?= $Page->servicio_tipo->editAttributes() ?>>
        <?= $Page->servicio_tipo->selectOptionListHtml("x_servicio_tipo") ?>
    </select>
    <?= $Page->servicio_tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio_tipo->getErrorMessage() ?></div>
<?= $Page->servicio_tipo->Lookup->getParamTag($Page, "p_x_servicio_tipo") ?>
<?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_plantillasadd", function() {
    var options = { name: "x_servicio_tipo", selectId: "fautogestion_plantillasadd_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_plantillasadd.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fautogestion_plantillasadd" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fautogestion_plantillasadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_plantillas.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
    <div id="r_script"<?= $Page->script->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_script" for="x_script" class="<?= $Page->LeftColumnClass ?>"><?= $Page->script->caption() ?><?= $Page->script->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->script->cellAttributes() ?>>
<span id="el_autogestion_plantillas_script">
<input type="<?= $Page->script->getInputTextType() ?>" name="x_script" id="x_script" data-table="autogestion_plantillas" data-field="x_script" value="<?= $Page->script->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->script->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->script->formatPattern()) ?>"<?= $Page->script->editAttributes() ?> aria-describedby="x_script_help">
<?= $Page->script->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->script->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
    <div id="r_nivel"<?= $Page->nivel->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_nivel" for="x_nivel" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nivel->caption() ?><?= $Page->nivel->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nivel->cellAttributes() ?>>
<span id="el_autogestion_plantillas_nivel">
    <select
        id="x_nivel"
        name="x_nivel"
        class="form-select ew-select<?= $Page->nivel->isInvalidClass() ?>"
        <?php if (!$Page->nivel->IsNativeSelect) { ?>
        data-select2-id="fautogestion_plantillasadd_x_nivel"
        <?php } ?>
        data-table="autogestion_plantillas"
        data-field="x_nivel"
        data-value-separator="<?= $Page->nivel->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nivel->getPlaceHolder()) ?>"
        <?= $Page->nivel->editAttributes() ?>>
        <?= $Page->nivel->selectOptionListHtml("x_nivel") ?>
    </select>
    <?= $Page->nivel->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->nivel->getErrorMessage() ?></div>
<?php if (!$Page->nivel->IsNativeSelect) { ?>
<script>
loadjs.ready("fautogestion_plantillasadd", function() {
    var options = { name: "x_nivel", selectId: "fautogestion_plantillasadd_x_nivel" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fautogestion_plantillasadd.lists.nivel?.lookupOptions.length) {
        options.data = { id: "x_nivel", form: "fautogestion_plantillasadd" };
    } else {
        options.ajax = { id: "x_nivel", form: "fautogestion_plantillasadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.autogestion_plantillas.fields.nivel.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
    <div id="r_orden"<?= $Page->orden->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_orden" for="x_orden" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orden->caption() ?><?= $Page->orden->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->orden->cellAttributes() ?>>
<span id="el_autogestion_plantillas_orden">
<input type="<?= $Page->orden->getInputTextType() ?>" name="x_orden" id="x_orden" data-table="autogestion_plantillas" data-field="x_orden" value="<?= $Page->orden->EditValue ?>" size="6" placeholder="<?= HtmlEncode($Page->orden->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->orden->formatPattern()) ?>"<?= $Page->orden->editAttributes() ?> aria-describedby="x_orden_help">
<?= $Page->orden->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orden->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
    <div id="r_codigo"<?= $Page->codigo->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_codigo" for="x_codigo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codigo->caption() ?><?= $Page->codigo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codigo->cellAttributes() ?>>
<span id="el_autogestion_plantillas_codigo">
<input type="<?= $Page->codigo->getInputTextType() ?>" name="x_codigo" id="x_codigo" data-table="autogestion_plantillas" data-field="x_codigo" value="<?= $Page->codigo->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->codigo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->codigo->formatPattern()) ?>"<?= $Page->codigo->editAttributes() ?> aria-describedby="x_codigo_help">
<?= $Page->codigo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codigo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_autogestion_plantillas_descripcion">
<?php $Page->descripcion->EditAttrs->appendClass("editor"); ?>
<textarea data-table="autogestion_plantillas" data-field="x_descripcion" name="x_descripcion" id="x_descripcion" cols="35" rows="6" placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>"<?= $Page->descripcion->editAttributes() ?> aria-describedby="x_descripcion_help"><?= $Page->descripcion->EditValue ?></textarea>
<?= $Page->descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
<script>
loadjs.ready(["fautogestion_plantillasadd", "editor"], function() {
    ew.createEditor("fautogestion_plantillasadd", "x_descripcion", 35, 6, <?= $Page->descripcion->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
    <div id="r_imagen"<?= $Page->imagen->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_imagen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->imagen->caption() ?><?= $Page->imagen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->imagen->cellAttributes() ?>>
<span id="el_autogestion_plantillas_imagen">
<div id="fd_x_imagen" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_imagen"
        name="x_imagen"
        class="form-control ew-file-input"
        title="<?= $Page->imagen->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="autogestion_plantillas"
        data-field="x_imagen"
        data-size="200"
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
<?php if ($Page->mostrar->Visible) { // mostrar ?>
    <div id="r_mostrar"<?= $Page->mostrar->rowAttributes() ?>>
        <label id="elh_autogestion_plantillas_mostrar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mostrar->caption() ?><?= $Page->mostrar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->mostrar->cellAttributes() ?>>
<span id="el_autogestion_plantillas_mostrar">
<template id="tp_x_mostrar">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="autogestion_plantillas" data-field="x_mostrar" name="x_mostrar" id="x_mostrar"<?= $Page->mostrar->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_mostrar" class="ew-item-list"></div>
<selection-list hidden
    id="x_mostrar"
    name="x_mostrar"
    value="<?= HtmlEncode($Page->mostrar->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_mostrar"
    data-target="dsl_x_mostrar"
    data-repeatcolumn="0"
    class="form-control<?= $Page->mostrar->isInvalidClass() ?>"
    data-table="autogestion_plantillas"
    data-field="x_mostrar"
    data-value-separator="<?= $Page->mostrar->displayValueSeparatorAttribute() ?>"
    <?= $Page->mostrar->editAttributes() ?>></selection-list>
<?= $Page->mostrar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mostrar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fautogestion_plantillasadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fautogestion_plantillasadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("autogestion_plantillas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
