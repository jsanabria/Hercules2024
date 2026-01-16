<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoTablaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_tabla: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_tablaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_tablaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tabla", [fields.tabla.visible && fields.tabla.required ? ew.Validators.required(fields.tabla.caption) : null], fields.tabla.isInvalid],
            ["campo_descripcion", [fields.campo_descripcion.visible && fields.campo_descripcion.required ? ew.Validators.required(fields.campo_descripcion.caption) : null], fields.campo_descripcion.isInvalid]
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
            "tabla": <?= $Page->tabla->toClientList($Page) ?>,
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
<form name="fsco_tablaadd" id="fsco_tablaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_tabla">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tabla->Visible) { // tabla ?>
    <div id="r_tabla"<?= $Page->tabla->rowAttributes() ?>>
        <label id="elh_sco_tabla_tabla" for="x_tabla" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tabla->caption() ?><?= $Page->tabla->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tabla->cellAttributes() ?>>
<span id="el_sco_tabla_tabla">
    <select
        id="x_tabla"
        name="x_tabla"
        class="form-select ew-select<?= $Page->tabla->isInvalidClass() ?>"
        <?php if (!$Page->tabla->IsNativeSelect) { ?>
        data-select2-id="fsco_tablaadd_x_tabla"
        <?php } ?>
        data-table="sco_tabla"
        data-field="x_tabla"
        data-value-separator="<?= $Page->tabla->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tabla->getPlaceHolder()) ?>"
        <?= $Page->tabla->editAttributes() ?>>
        <?= $Page->tabla->selectOptionListHtml("x_tabla") ?>
    </select>
    <?= $Page->tabla->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tabla->getErrorMessage() ?></div>
<?= $Page->tabla->Lookup->getParamTag($Page, "p_x_tabla") ?>
<?php if (!$Page->tabla->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_tablaadd", function() {
    var options = { name: "x_tabla", selectId: "fsco_tablaadd_x_tabla" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_tablaadd.lists.tabla?.lookupOptions.length) {
        options.data = { id: "x_tabla", form: "fsco_tablaadd" };
    } else {
        options.ajax = { id: "x_tabla", form: "fsco_tablaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_tabla.fields.tabla.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->campo_descripcion->Visible) { // campo_descripcion ?>
    <div id="r_campo_descripcion"<?= $Page->campo_descripcion->rowAttributes() ?>>
        <label id="elh_sco_tabla_campo_descripcion" for="x_campo_descripcion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->campo_descripcion->caption() ?><?= $Page->campo_descripcion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->campo_descripcion->cellAttributes() ?>>
<span id="el_sco_tabla_campo_descripcion">
<input type="<?= $Page->campo_descripcion->getInputTextType() ?>" name="x_campo_descripcion" id="x_campo_descripcion" data-table="sco_tabla" data-field="x_campo_descripcion" value="<?= $Page->campo_descripcion->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->campo_descripcion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->campo_descripcion->formatPattern()) ?>"<?= $Page->campo_descripcion->editAttributes() ?> aria-describedby="x_campo_descripcion_help">
<?= $Page->campo_descripcion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->campo_descripcion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_tablaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_tablaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_tabla");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
