<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParametroEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_parametroedit" id="fsco_parametroedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parametro: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_parametroedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parametroedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nparametro", [fields.Nparametro.visible && fields.Nparametro.required ? ew.Validators.required(fields.Nparametro.caption) : null], fields.Nparametro.isInvalid],
            ["codigo", [fields.codigo.visible && fields.codigo.required ? ew.Validators.required(fields.codigo.caption) : null], fields.codigo.isInvalid],
            ["descripcion", [fields.descripcion.visible && fields.descripcion.required ? ew.Validators.required(fields.descripcion.caption) : null], fields.descripcion.isInvalid],
            ["valor1", [fields.valor1.visible && fields.valor1.required ? ew.Validators.required(fields.valor1.caption) : null], fields.valor1.isInvalid],
            ["valor2", [fields.valor2.visible && fields.valor2.required ? ew.Validators.required(fields.valor2.caption) : null], fields.valor2.isInvalid],
            ["valor3", [fields.valor3.visible && fields.valor3.required ? ew.Validators.required(fields.valor3.caption) : null], fields.valor3.isInvalid],
            ["valor4", [fields.valor4.visible && fields.valor4.required ? ew.Validators.required(fields.valor4.caption) : null], fields.valor4.isInvalid]
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
            "codigo": <?= $Page->codigo->toClientList($Page) ?>,
            "descripcion": <?= $Page->descripcion->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_parametro">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nparametro->Visible) { // Nparametro ?>
    <div id="r_Nparametro"<?= $Page->Nparametro->rowAttributes() ?>>
        <label id="elh_sco_parametro_Nparametro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nparametro->caption() ?><?= $Page->Nparametro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nparametro->cellAttributes() ?>>
<span id="el_sco_parametro_Nparametro">
<span<?= $Page->Nparametro->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nparametro->getDisplayValue($Page->Nparametro->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_parametro" data-field="x_Nparametro" data-hidden="1" name="x_Nparametro" id="x_Nparametro" value="<?= HtmlEncode($Page->Nparametro->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
    <div id="r_codigo"<?= $Page->codigo->rowAttributes() ?>>
        <label id="elh_sco_parametro_codigo" for="x_codigo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codigo->caption() ?><?= $Page->codigo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->codigo->cellAttributes() ?>>
<span id="el_sco_parametro_codigo">
    <select
        id="x_codigo"
        name="x_codigo"
        class="form-select ew-select<?= $Page->codigo->isInvalidClass() ?>"
        <?php if (!$Page->codigo->IsNativeSelect) { ?>
        data-select2-id="fsco_parametroedit_x_codigo"
        <?php } ?>
        data-table="sco_parametro"
        data-field="x_codigo"
        data-value-separator="<?= $Page->codigo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->codigo->getPlaceHolder()) ?>"
        <?= $Page->codigo->editAttributes() ?>>
        <?= $Page->codigo->selectOptionListHtml("x_codigo") ?>
    </select>
    <?= $Page->codigo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->codigo->getErrorMessage() ?></div>
<?= $Page->codigo->Lookup->getParamTag($Page, "p_x_codigo") ?>
<?php if (!$Page->codigo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_parametroedit", function() {
    var options = { name: "x_codigo", selectId: "fsco_parametroedit_x_codigo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_parametroedit.lists.codigo?.lookupOptions.length) {
        options.data = { id: "x_codigo", form: "fsco_parametroedit" };
    } else {
        options.ajax = { id: "x_codigo", form: "fsco_parametroedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_parametro.fields.codigo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <div id="r_descripcion"<?= $Page->descripcion->rowAttributes() ?>>
        <label id="elh_sco_parametro_descripcion" for="x_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion->caption() ?><?= $Page->descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion->cellAttributes() ?>>
<span id="el_sco_parametro_descripcion">
    <select
        id="x_descripcion"
        name="x_descripcion"
        class="form-select ew-select<?= $Page->descripcion->isInvalidClass() ?>"
        <?php if (!$Page->descripcion->IsNativeSelect) { ?>
        data-select2-id="fsco_parametroedit_x_descripcion"
        <?php } ?>
        data-table="sco_parametro"
        data-field="x_descripcion"
        data-value-separator="<?= $Page->descripcion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->descripcion->getPlaceHolder()) ?>"
        <?= $Page->descripcion->editAttributes() ?>>
        <?= $Page->descripcion->selectOptionListHtml("x_descripcion") ?>
    </select>
    <?= $Page->descripcion->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->descripcion->getErrorMessage() ?></div>
<?= $Page->descripcion->Lookup->getParamTag($Page, "p_x_descripcion") ?>
<?php if (!$Page->descripcion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_parametroedit", function() {
    var options = { name: "x_descripcion", selectId: "fsco_parametroedit_x_descripcion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_parametroedit.lists.descripcion?.lookupOptions.length) {
        options.data = { id: "x_descripcion", form: "fsco_parametroedit" };
    } else {
        options.ajax = { id: "x_descripcion", form: "fsco_parametroedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_parametro.fields.descripcion.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor1->Visible) { // valor1 ?>
    <div id="r_valor1"<?= $Page->valor1->rowAttributes() ?>>
        <label id="elh_sco_parametro_valor1" for="x_valor1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor1->caption() ?><?= $Page->valor1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor1->cellAttributes() ?>>
<span id="el_sco_parametro_valor1">
<textarea data-table="sco_parametro" data-field="x_valor1" name="x_valor1" id="x_valor1" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->valor1->getPlaceHolder()) ?>"<?= $Page->valor1->editAttributes() ?> aria-describedby="x_valor1_help"><?= $Page->valor1->EditValue ?></textarea>
<?= $Page->valor1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor2->Visible) { // valor2 ?>
    <div id="r_valor2"<?= $Page->valor2->rowAttributes() ?>>
        <label id="elh_sco_parametro_valor2" for="x_valor2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor2->caption() ?><?= $Page->valor2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor2->cellAttributes() ?>>
<span id="el_sco_parametro_valor2">
<textarea data-table="sco_parametro" data-field="x_valor2" name="x_valor2" id="x_valor2" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->valor2->getPlaceHolder()) ?>"<?= $Page->valor2->editAttributes() ?> aria-describedby="x_valor2_help"><?= $Page->valor2->EditValue ?></textarea>
<?= $Page->valor2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor3->Visible) { // valor3 ?>
    <div id="r_valor3"<?= $Page->valor3->rowAttributes() ?>>
        <label id="elh_sco_parametro_valor3" for="x_valor3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor3->caption() ?><?= $Page->valor3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor3->cellAttributes() ?>>
<span id="el_sco_parametro_valor3">
<textarea data-table="sco_parametro" data-field="x_valor3" name="x_valor3" id="x_valor3" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->valor3->getPlaceHolder()) ?>"<?= $Page->valor3->editAttributes() ?> aria-describedby="x_valor3_help"><?= $Page->valor3->EditValue ?></textarea>
<?= $Page->valor3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor4->Visible) { // valor4 ?>
    <div id="r_valor4"<?= $Page->valor4->rowAttributes() ?>>
        <label id="elh_sco_parametro_valor4" for="x_valor4" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor4->caption() ?><?= $Page->valor4->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor4->cellAttributes() ?>>
<span id="el_sco_parametro_valor4">
<textarea data-table="sco_parametro" data-field="x_valor4" name="x_valor4" id="x_valor4" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->valor4->getPlaceHolder()) ?>"<?= $Page->valor4->editAttributes() ?> aria-describedby="x_valor4_help"><?= $Page->valor4->EditValue ?></textarea>
<?= $Page->valor4->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor4->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_parametroedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_parametroedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_parametro");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
