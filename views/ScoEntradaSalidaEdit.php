<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEntradaSalidaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_entrada_salidaedit" id="fsco_entrada_salidaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_entrada_salida: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_entrada_salidaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_entrada_salidaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["tipo_doc", [fields.tipo_doc.visible && fields.tipo_doc.required ? ew.Validators.required(fields.tipo_doc.caption) : null], fields.tipo_doc.isInvalid],
            ["proveedor", [fields.proveedor.visible && fields.proveedor.required ? ew.Validators.required(fields.proveedor.caption) : null], fields.proveedor.isInvalid],
            ["clasificacion", [fields.clasificacion.visible && fields.clasificacion.required ? ew.Validators.required(fields.clasificacion.caption) : null], fields.clasificacion.isInvalid],
            ["documento", [fields.documento.visible && fields.documento.required ? ew.Validators.required(fields.documento.caption) : null], fields.documento.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["monto", [fields.monto.visible && fields.monto.required ? ew.Validators.required(fields.monto.caption) : null, ew.Validators.float], fields.monto.isInvalid],
            ["registro", [fields.registro.visible && fields.registro.required ? ew.Validators.required(fields.registro.caption) : null], fields.registro.isInvalid]
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
            "tipo_doc": <?= $Page->tipo_doc->toClientList($Page) ?>,
            "proveedor": <?= $Page->proveedor->toClientList($Page) ?>,
            "clasificacion": <?= $Page->clasificacion->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_entrada_salida">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->tipo_doc->Visible) { // tipo_doc ?>
    <div id="r_tipo_doc"<?= $Page->tipo_doc->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_tipo_doc" for="x_tipo_doc" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_doc->caption() ?><?= $Page->tipo_doc->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_doc->cellAttributes() ?>>
<span id="el_sco_entrada_salida_tipo_doc">
    <select
        id="x_tipo_doc"
        name="x_tipo_doc"
        class="form-select ew-select<?= $Page->tipo_doc->isInvalidClass() ?>"
        <?php if (!$Page->tipo_doc->IsNativeSelect) { ?>
        data-select2-id="fsco_entrada_salidaedit_x_tipo_doc"
        <?php } ?>
        data-table="sco_entrada_salida"
        data-field="x_tipo_doc"
        data-value-separator="<?= $Page->tipo_doc->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_doc->getPlaceHolder()) ?>"
        <?= $Page->tipo_doc->editAttributes() ?>>
        <?= $Page->tipo_doc->selectOptionListHtml("x_tipo_doc") ?>
    </select>
    <?= $Page->tipo_doc->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_doc->getErrorMessage() ?></div>
<?php if (!$Page->tipo_doc->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_entrada_salidaedit", function() {
    var options = { name: "x_tipo_doc", selectId: "fsco_entrada_salidaedit_x_tipo_doc" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_entrada_salidaedit.lists.tipo_doc?.lookupOptions.length) {
        options.data = { id: "x_tipo_doc", form: "fsco_entrada_salidaedit" };
    } else {
        options.ajax = { id: "x_tipo_doc", form: "fsco_entrada_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_entrada_salida.fields.tipo_doc.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <div id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_proveedor" for="x_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proveedor->caption() ?><?= $Page->proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_entrada_salida_proveedor">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-control ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        data-select2-id="fsco_entrada_salidaedit_x_proveedor"
        data-table="sco_entrada_salida"
        data-field="x_proveedor"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->proveedor->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->proveedor->getPlaceHolder()) ?>"
        <?= $Page->proveedor->editAttributes() ?>>
        <?= $Page->proveedor->selectOptionListHtml("x_proveedor") ?>
    </select>
    <?= $Page->proveedor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->proveedor->getErrorMessage() ?></div>
<?= $Page->proveedor->Lookup->getParamTag($Page, "p_x_proveedor") ?>
<script>
loadjs.ready("fsco_entrada_salidaedit", function() {
    var options = { name: "x_proveedor", selectId: "fsco_entrada_salidaedit_x_proveedor" };
    if (fsco_entrada_salidaedit.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fsco_entrada_salidaedit" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fsco_entrada_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_entrada_salida.fields.proveedor.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->clasificacion->Visible) { // clasificacion ?>
    <div id="r_clasificacion"<?= $Page->clasificacion->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_clasificacion" for="x_clasificacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->clasificacion->caption() ?><?= $Page->clasificacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->clasificacion->cellAttributes() ?>>
<span id="el_sco_entrada_salida_clasificacion">
    <select
        id="x_clasificacion"
        name="x_clasificacion"
        class="form-select ew-select<?= $Page->clasificacion->isInvalidClass() ?>"
        <?php if (!$Page->clasificacion->IsNativeSelect) { ?>
        data-select2-id="fsco_entrada_salidaedit_x_clasificacion"
        <?php } ?>
        data-table="sco_entrada_salida"
        data-field="x_clasificacion"
        data-value-separator="<?= $Page->clasificacion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->clasificacion->getPlaceHolder()) ?>"
        <?= $Page->clasificacion->editAttributes() ?>>
        <?= $Page->clasificacion->selectOptionListHtml("x_clasificacion") ?>
    </select>
    <?= $Page->clasificacion->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->clasificacion->getErrorMessage() ?></div>
<?php if (!$Page->clasificacion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_entrada_salidaedit", function() {
    var options = { name: "x_clasificacion", selectId: "fsco_entrada_salidaedit_x_clasificacion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_entrada_salidaedit.lists.clasificacion?.lookupOptions.length) {
        options.data = { id: "x_clasificacion", form: "fsco_entrada_salidaedit" };
    } else {
        options.ajax = { id: "x_clasificacion", form: "fsco_entrada_salidaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_entrada_salida.fields.clasificacion.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->documento->Visible) { // documento ?>
    <div id="r_documento"<?= $Page->documento->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_documento" for="x_documento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->documento->caption() ?><?= $Page->documento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->documento->cellAttributes() ?>>
<span id="el_sco_entrada_salida_documento">
<input type="<?= $Page->documento->getInputTextType() ?>" name="x_documento" id="x_documento" data-table="sco_entrada_salida" data-field="x_documento" value="<?= $Page->documento->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->documento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->documento->formatPattern()) ?>"<?= $Page->documento->editAttributes() ?> aria-describedby="x_documento_help">
<?= $Page->documento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->documento->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_entrada_salida_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_entrada_salida" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_entrada_salidaedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_entrada_salidaedit", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_entrada_salida_nota">
<textarea data-table="sco_entrada_salida" data-field="x_nota" name="x_nota" id="x_nota" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <div id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_monto" for="x_monto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto->caption() ?><?= $Page->monto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto->cellAttributes() ?>>
<span id="el_sco_entrada_salida_monto">
<input type="<?= $Page->monto->getInputTextType() ?>" name="x_monto" id="x_monto" data-table="sco_entrada_salida" data-field="x_monto" value="<?= $Page->monto->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto->formatPattern()) ?>"<?= $Page->monto->editAttributes() ?> aria-describedby="x_monto_help">
<?= $Page->monto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->registro->Visible) { // registro ?>
    <div id="r_registro"<?= $Page->registro->rowAttributes() ?>>
        <label id="elh_sco_entrada_salida_registro" for="x_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->registro->caption() ?><?= $Page->registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->registro->cellAttributes() ?>>
<span id="el_sco_entrada_salida_registro">
<span<?= $Page->registro->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->registro->getDisplayValue($Page->registro->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_entrada_salida" data-field="x_registro" data-hidden="1" name="x_registro" id="x_registro" value="<?= HtmlEncode($Page->registro->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_entrada_salida" data-field="x_Nentrada_salida" data-hidden="1" name="x_Nentrada_salida" id="x_Nentrada_salida" value="<?= HtmlEncode($Page->Nentrada_salida->CurrentValue) ?>">
<?php
    if (in_array("sco_entrada_salida_detalle", explode(",", $Page->getCurrentDetailTable())) && $sco_entrada_salida_detalle->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_entrada_salida_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoEntradaSalidaDetalleGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_entrada_salidaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_entrada_salidaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_entrada_salida");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
