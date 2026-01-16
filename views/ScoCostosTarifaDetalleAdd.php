<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaDetalleAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_costos_tarifa_detalleadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifa_detalleadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["cap", [fields.cap.visible && fields.cap.required ? ew.Validators.required(fields.cap.caption) : null], fields.cap.isInvalid],
            ["ata", [fields.ata.visible && fields.ata.required ? ew.Validators.required(fields.ata.caption) : null], fields.ata.isInvalid],
            ["obi", [fields.obi.visible && fields.obi.required ? ew.Validators.required(fields.obi.caption) : null], fields.obi.isInvalid],
            ["fot", [fields.fot.visible && fields.fot.required ? ew.Validators.required(fields.fot.caption) : null], fields.fot.isInvalid],
            ["man", [fields.man.visible && fields.man.required ? ew.Validators.required(fields.man.caption) : null], fields.man.isInvalid],
            ["gas", [fields.gas.visible && fields.gas.required ? ew.Validators.required(fields.gas.caption) : null], fields.gas.isInvalid],
            ["com", [fields.com.visible && fields.com.required ? ew.Validators.required(fields.com.caption) : null], fields.com.isInvalid]
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
            "cap": <?= $Page->cap->toClientList($Page) ?>,
            "ata": <?= $Page->ata->toClientList($Page) ?>,
            "obi": <?= $Page->obi->toClientList($Page) ?>,
            "fot": <?= $Page->fot->toClientList($Page) ?>,
            "man": <?= $Page->man->toClientList($Page) ?>,
            "gas": <?= $Page->gas->toClientList($Page) ?>,
            "com": <?= $Page->com->toClientList($Page) ?>,
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
<form name="fsco_costos_tarifa_detalleadd" id="fsco_costos_tarifa_detalleadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos_tarifa_detalle">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_costos_tarifa") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_costos_tarifa">
<input type="hidden" name="fk_Ncostos_tarifa" value="<?= HtmlEncode($Page->costos_tarifa->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cap->Visible) { // cap ?>
    <div id="r_cap"<?= $Page->cap->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_cap" for="x_cap" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cap->caption() ?><?= $Page->cap->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cap->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_cap">
    <select
        id="x_cap"
        name="x_cap"
        class="form-select ew-select<?= $Page->cap->isInvalidClass() ?>"
        <?php if (!$Page->cap->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_cap"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_cap"
        data-value-separator="<?= $Page->cap->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cap->getPlaceHolder()) ?>"
        <?= $Page->cap->editAttributes() ?>>
        <?= $Page->cap->selectOptionListHtml("x_cap") ?>
    </select>
    <?= $Page->cap->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cap->getErrorMessage() ?></div>
<?= $Page->cap->Lookup->getParamTag($Page, "p_x_cap") ?>
<?php if (!$Page->cap->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_cap", selectId: "fsco_costos_tarifa_detalleadd_x_cap" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.cap?.lookupOptions.length) {
        options.data = { id: "x_cap", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_cap", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.cap.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
    <div id="r_ata"<?= $Page->ata->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_ata" for="x_ata" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ata->caption() ?><?= $Page->ata->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ata->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_ata">
    <select
        id="x_ata"
        name="x_ata"
        class="form-select ew-select<?= $Page->ata->isInvalidClass() ?>"
        <?php if (!$Page->ata->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_ata"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_ata"
        data-value-separator="<?= $Page->ata->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ata->getPlaceHolder()) ?>"
        <?= $Page->ata->editAttributes() ?>>
        <?= $Page->ata->selectOptionListHtml("x_ata") ?>
    </select>
    <?= $Page->ata->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ata->getErrorMessage() ?></div>
<?= $Page->ata->Lookup->getParamTag($Page, "p_x_ata") ?>
<?php if (!$Page->ata->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_ata", selectId: "fsco_costos_tarifa_detalleadd_x_ata" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.ata?.lookupOptions.length) {
        options.data = { id: "x_ata", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_ata", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.ata.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
    <div id="r_obi"<?= $Page->obi->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_obi" for="x_obi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->obi->caption() ?><?= $Page->obi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->obi->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_obi">
    <select
        id="x_obi"
        name="x_obi"
        class="form-select ew-select<?= $Page->obi->isInvalidClass() ?>"
        <?php if (!$Page->obi->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_obi"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_obi"
        data-value-separator="<?= $Page->obi->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->obi->getPlaceHolder()) ?>"
        <?= $Page->obi->editAttributes() ?>>
        <?= $Page->obi->selectOptionListHtml("x_obi") ?>
    </select>
    <?= $Page->obi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->obi->getErrorMessage() ?></div>
<?= $Page->obi->Lookup->getParamTag($Page, "p_x_obi") ?>
<?php if (!$Page->obi->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_obi", selectId: "fsco_costos_tarifa_detalleadd_x_obi" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.obi?.lookupOptions.length) {
        options.data = { id: "x_obi", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_obi", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.obi.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
    <div id="r_fot"<?= $Page->fot->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_fot" for="x_fot" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fot->caption() ?><?= $Page->fot->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fot->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_fot">
    <select
        id="x_fot"
        name="x_fot"
        class="form-select ew-select<?= $Page->fot->isInvalidClass() ?>"
        <?php if (!$Page->fot->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_fot"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_fot"
        data-value-separator="<?= $Page->fot->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->fot->getPlaceHolder()) ?>"
        <?= $Page->fot->editAttributes() ?>>
        <?= $Page->fot->selectOptionListHtml("x_fot") ?>
    </select>
    <?= $Page->fot->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->fot->getErrorMessage() ?></div>
<?= $Page->fot->Lookup->getParamTag($Page, "p_x_fot") ?>
<?php if (!$Page->fot->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_fot", selectId: "fsco_costos_tarifa_detalleadd_x_fot" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.fot?.lookupOptions.length) {
        options.data = { id: "x_fot", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_fot", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.fot.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
    <div id="r_man"<?= $Page->man->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_man" for="x_man" class="<?= $Page->LeftColumnClass ?>"><?= $Page->man->caption() ?><?= $Page->man->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->man->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_man">
    <select
        id="x_man"
        name="x_man"
        class="form-select ew-select<?= $Page->man->isInvalidClass() ?>"
        <?php if (!$Page->man->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_man"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_man"
        data-value-separator="<?= $Page->man->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->man->getPlaceHolder()) ?>"
        <?= $Page->man->editAttributes() ?>>
        <?= $Page->man->selectOptionListHtml("x_man") ?>
    </select>
    <?= $Page->man->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->man->getErrorMessage() ?></div>
<?= $Page->man->Lookup->getParamTag($Page, "p_x_man") ?>
<?php if (!$Page->man->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_man", selectId: "fsco_costos_tarifa_detalleadd_x_man" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.man?.lookupOptions.length) {
        options.data = { id: "x_man", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_man", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.man.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
    <div id="r_gas"<?= $Page->gas->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_gas" for="x_gas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gas->caption() ?><?= $Page->gas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->gas->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_gas">
    <select
        id="x_gas"
        name="x_gas"
        class="form-select ew-select<?= $Page->gas->isInvalidClass() ?>"
        <?php if (!$Page->gas->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_gas"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_gas"
        data-value-separator="<?= $Page->gas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->gas->getPlaceHolder()) ?>"
        <?= $Page->gas->editAttributes() ?>>
        <?= $Page->gas->selectOptionListHtml("x_gas") ?>
    </select>
    <?= $Page->gas->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->gas->getErrorMessage() ?></div>
<?= $Page->gas->Lookup->getParamTag($Page, "p_x_gas") ?>
<?php if (!$Page->gas->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_gas", selectId: "fsco_costos_tarifa_detalleadd_x_gas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.gas?.lookupOptions.length) {
        options.data = { id: "x_gas", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_gas", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.gas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
    <div id="r_com"<?= $Page->com->rowAttributes() ?>>
        <label id="elh_sco_costos_tarifa_detalle_com" for="x_com" class="<?= $Page->LeftColumnClass ?>"><?= $Page->com->caption() ?><?= $Page->com->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->com->cellAttributes() ?>>
<span id="el_sco_costos_tarifa_detalle_com">
    <select
        id="x_com"
        name="x_com"
        class="form-select ew-select<?= $Page->com->isInvalidClass() ?>"
        <?php if (!$Page->com->IsNativeSelect) { ?>
        data-select2-id="fsco_costos_tarifa_detalleadd_x_com"
        <?php } ?>
        data-table="sco_costos_tarifa_detalle"
        data-field="x_com"
        data-value-separator="<?= $Page->com->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->com->getPlaceHolder()) ?>"
        <?= $Page->com->editAttributes() ?>>
        <?= $Page->com->selectOptionListHtml("x_com") ?>
    </select>
    <?= $Page->com->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->com->getErrorMessage() ?></div>
<?= $Page->com->Lookup->getParamTag($Page, "p_x_com") ?>
<?php if (!$Page->com->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_costos_tarifa_detalleadd", function() {
    var options = { name: "x_com", selectId: "fsco_costos_tarifa_detalleadd_x_com" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_costos_tarifa_detalleadd.lists.com?.lookupOptions.length) {
        options.data = { id: "x_com", form: "fsco_costos_tarifa_detalleadd" };
    } else {
        options.ajax = { id: "x_com", form: "fsco_costos_tarifa_detalleadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_costos_tarifa_detalle.fields.com.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <?php if (strval($Page->costos_tarifa->getSessionValue()) != "") { ?>
    <input type="hidden" name="x_costos_tarifa" id="x_costos_tarifa" value="<?= HtmlEncode(strval($Page->costos_tarifa->getSessionValue())) ?>">
    <?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_costos_tarifa_detalleadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_costos_tarifa_detalleadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_costos_tarifa_detalle");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
