<?php

namespace PHPMaker2024\hercules;

// Page object
$UserlevelsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fuserlevelsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fuserlevelsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["userlevelid", [fields.userlevelid.visible && fields.userlevelid.required ? ew.Validators.required(fields.userlevelid.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.userlevelid.isInvalid],
            ["userlevelname", [fields.userlevelname.visible && fields.userlevelname.required ? ew.Validators.required(fields.userlevelname.caption) : null, ew.Validators.userLevelName('userlevelid')], fields.userlevelname.isInvalid],
            ["reserva", [fields.reserva.visible && fields.reserva.required ? ew.Validators.required(fields.reserva.caption) : null], fields.reserva.isInvalid],
            ["indicador", [fields.indicador.visible && fields.indicador.required ? ew.Validators.required(fields.indicador.caption) : null], fields.indicador.isInvalid],
            ["tipo_proveedor", [fields.tipo_proveedor.visible && fields.tipo_proveedor.required ? ew.Validators.required(fields.tipo_proveedor.caption) : null], fields.tipo_proveedor.isInvalid],
            ["ver_alertas", [fields.ver_alertas.visible && fields.ver_alertas.required ? ew.Validators.required(fields.ver_alertas.caption) : null], fields.ver_alertas.isInvalid],
            ["financiero", [fields.financiero.visible && fields.financiero.required ? ew.Validators.required(fields.financiero.caption) : null], fields.financiero.isInvalid]
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
            "reserva": <?= $Page->reserva->toClientList($Page) ?>,
            "indicador": <?= $Page->indicador->toClientList($Page) ?>,
            "tipo_proveedor": <?= $Page->tipo_proveedor->toClientList($Page) ?>,
            "ver_alertas": <?= $Page->ver_alertas->toClientList($Page) ?>,
            "financiero": <?= $Page->financiero->toClientList($Page) ?>,
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
<form name="fuserlevelsadd" id="fuserlevelsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
    <div id="r_userlevelid"<?= $Page->userlevelid->rowAttributes() ?>>
        <label id="elh_userlevels_userlevelid" for="x_userlevelid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelid->caption() ?><?= $Page->userlevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelid->cellAttributes() ?>>
<span id="el_userlevels_userlevelid">
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x_userlevelid" id="x_userlevelid" data-table="userlevels" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->userlevelid->formatPattern()) ?>"<?= $Page->userlevelid->editAttributes() ?> aria-describedby="x_userlevelid_help">
<?= $Page->userlevelid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
    <div id="r_userlevelname"<?= $Page->userlevelname->rowAttributes() ?>>
        <label id="elh_userlevels_userlevelname" for="x_userlevelname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelname->caption() ?><?= $Page->userlevelname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelname->cellAttributes() ?>>
<span id="el_userlevels_userlevelname">
<input type="<?= $Page->userlevelname->getInputTextType() ?>" name="x_userlevelname" id="x_userlevelname" data-table="userlevels" data-field="x_userlevelname" value="<?= $Page->userlevelname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->userlevelname->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->userlevelname->formatPattern()) ?>"<?= $Page->userlevelname->editAttributes() ?> aria-describedby="x_userlevelname_help">
<?= $Page->userlevelname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->reserva->Visible) { // reserva ?>
    <div id="r_reserva"<?= $Page->reserva->rowAttributes() ?>>
        <label id="elh_userlevels_reserva" for="x_reserva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->reserva->caption() ?><?= $Page->reserva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->reserva->cellAttributes() ?>>
<span id="el_userlevels_reserva">
    <select
        id="x_reserva"
        name="x_reserva"
        class="form-select ew-select<?= $Page->reserva->isInvalidClass() ?>"
        <?php if (!$Page->reserva->IsNativeSelect) { ?>
        data-select2-id="fuserlevelsadd_x_reserva"
        <?php } ?>
        data-table="userlevels"
        data-field="x_reserva"
        data-value-separator="<?= $Page->reserva->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->reserva->getPlaceHolder()) ?>"
        <?= $Page->reserva->editAttributes() ?>>
        <?= $Page->reserva->selectOptionListHtml("x_reserva") ?>
    </select>
    <?= $Page->reserva->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->reserva->getErrorMessage() ?></div>
<?php if (!$Page->reserva->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelsadd", function() {
    var options = { name: "x_reserva", selectId: "fuserlevelsadd_x_reserva" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelsadd.lists.reserva?.lookupOptions.length) {
        options.data = { id: "x_reserva", form: "fuserlevelsadd" };
    } else {
        options.ajax = { id: "x_reserva", form: "fuserlevelsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.reserva.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->indicador->Visible) { // indicador ?>
    <div id="r_indicador"<?= $Page->indicador->rowAttributes() ?>>
        <label id="elh_userlevels_indicador" for="x_indicador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->indicador->caption() ?><?= $Page->indicador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->indicador->cellAttributes() ?>>
<span id="el_userlevels_indicador">
    <select
        id="x_indicador"
        name="x_indicador"
        class="form-select ew-select<?= $Page->indicador->isInvalidClass() ?>"
        <?php if (!$Page->indicador->IsNativeSelect) { ?>
        data-select2-id="fuserlevelsadd_x_indicador"
        <?php } ?>
        data-table="userlevels"
        data-field="x_indicador"
        data-value-separator="<?= $Page->indicador->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->indicador->getPlaceHolder()) ?>"
        <?= $Page->indicador->editAttributes() ?>>
        <?= $Page->indicador->selectOptionListHtml("x_indicador") ?>
    </select>
    <?= $Page->indicador->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->indicador->getErrorMessage() ?></div>
<?php if (!$Page->indicador->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelsadd", function() {
    var options = { name: "x_indicador", selectId: "fuserlevelsadd_x_indicador" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelsadd.lists.indicador?.lookupOptions.length) {
        options.data = { id: "x_indicador", form: "fuserlevelsadd" };
    } else {
        options.ajax = { id: "x_indicador", form: "fuserlevelsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.indicador.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
    <div id="r_tipo_proveedor"<?= $Page->tipo_proveedor->rowAttributes() ?>>
        <label id="elh_userlevels_tipo_proveedor" for="x_tipo_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_proveedor->caption() ?><?= $Page->tipo_proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_proveedor->cellAttributes() ?>>
<span id="el_userlevels_tipo_proveedor">
    <select
        id="x_tipo_proveedor"
        name="x_tipo_proveedor"
        class="form-select ew-select<?= $Page->tipo_proveedor->isInvalidClass() ?>"
        <?php if (!$Page->tipo_proveedor->IsNativeSelect) { ?>
        data-select2-id="fuserlevelsadd_x_tipo_proveedor"
        <?php } ?>
        data-table="userlevels"
        data-field="x_tipo_proveedor"
        data-value-separator="<?= $Page->tipo_proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_proveedor->getPlaceHolder()) ?>"
        <?= $Page->tipo_proveedor->editAttributes() ?>>
        <?= $Page->tipo_proveedor->selectOptionListHtml("x_tipo_proveedor") ?>
    </select>
    <?= $Page->tipo_proveedor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_proveedor->getErrorMessage() ?></div>
<?php if (!$Page->tipo_proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelsadd", function() {
    var options = { name: "x_tipo_proveedor", selectId: "fuserlevelsadd_x_tipo_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelsadd.lists.tipo_proveedor?.lookupOptions.length) {
        options.data = { id: "x_tipo_proveedor", form: "fuserlevelsadd" };
    } else {
        options.ajax = { id: "x_tipo_proveedor", form: "fuserlevelsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.tipo_proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ver_alertas->Visible) { // ver_alertas ?>
    <div id="r_ver_alertas"<?= $Page->ver_alertas->rowAttributes() ?>>
        <label id="elh_userlevels_ver_alertas" for="x_ver_alertas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ver_alertas->caption() ?><?= $Page->ver_alertas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ver_alertas->cellAttributes() ?>>
<span id="el_userlevels_ver_alertas">
    <select
        id="x_ver_alertas"
        name="x_ver_alertas"
        class="form-select ew-select<?= $Page->ver_alertas->isInvalidClass() ?>"
        <?php if (!$Page->ver_alertas->IsNativeSelect) { ?>
        data-select2-id="fuserlevelsadd_x_ver_alertas"
        <?php } ?>
        data-table="userlevels"
        data-field="x_ver_alertas"
        data-value-separator="<?= $Page->ver_alertas->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ver_alertas->getPlaceHolder()) ?>"
        <?= $Page->ver_alertas->editAttributes() ?>>
        <?= $Page->ver_alertas->selectOptionListHtml("x_ver_alertas") ?>
    </select>
    <?= $Page->ver_alertas->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ver_alertas->getErrorMessage() ?></div>
<?php if (!$Page->ver_alertas->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelsadd", function() {
    var options = { name: "x_ver_alertas", selectId: "fuserlevelsadd_x_ver_alertas" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelsadd.lists.ver_alertas?.lookupOptions.length) {
        options.data = { id: "x_ver_alertas", form: "fuserlevelsadd" };
    } else {
        options.ajax = { id: "x_ver_alertas", form: "fuserlevelsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.ver_alertas.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->financiero->Visible) { // financiero ?>
    <div id="r_financiero"<?= $Page->financiero->rowAttributes() ?>>
        <label id="elh_userlevels_financiero" for="x_financiero" class="<?= $Page->LeftColumnClass ?>"><?= $Page->financiero->caption() ?><?= $Page->financiero->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->financiero->cellAttributes() ?>>
<span id="el_userlevels_financiero">
    <select
        id="x_financiero"
        name="x_financiero"
        class="form-select ew-select<?= $Page->financiero->isInvalidClass() ?>"
        <?php if (!$Page->financiero->IsNativeSelect) { ?>
        data-select2-id="fuserlevelsadd_x_financiero"
        <?php } ?>
        data-table="userlevels"
        data-field="x_financiero"
        data-value-separator="<?= $Page->financiero->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->financiero->getPlaceHolder()) ?>"
        <?= $Page->financiero->editAttributes() ?>>
        <?= $Page->financiero->selectOptionListHtml("x_financiero") ?>
    </select>
    <?= $Page->financiero->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->financiero->getErrorMessage() ?></div>
<?php if (!$Page->financiero->IsNativeSelect) { ?>
<script>
loadjs.ready("fuserlevelsadd", function() {
    var options = { name: "x_financiero", selectId: "fuserlevelsadd_x_financiero" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserlevelsadd.lists.financiero?.lookupOptions.length) {
        options.data = { id: "x_financiero", form: "fuserlevelsadd" };
    } else {
        options.ajax = { id: "x_financiero", form: "fuserlevelsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.userlevels.fields.financiero.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
    <!-- row for permission values -->
    <div id="rp_permission" class="row">
        <label id="elh_permission" class="<?= $Page->LeftColumnClass ?>"><?= HtmlTitle($Language->phrase("Permission")) ?></label>
        <div class="<?= $Page->RightColumnClass ?>">
        <?php
            foreach (PRIVILEGES as $priv) {
                if ($priv != "admin" || IsSysAdmin()) {
                    $priv = ucfirst($priv);
        ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__Allow<?= $priv ?>" id="<?= $priv ?>" value="<?= GetPrivilege($priv) ?>" /><label class="form-check-label" for="<?= $priv ?>"><?= $Language->phrase("Permission" . $priv) ?></label>
            </div>
        <?php
                }
            }
        ?>
        </div>
    </div>
</div><!-- /page* -->
<?php
    if (in_array("sco_grupo_funciones", explode(",", $Page->getCurrentDetailTable())) && $sco_grupo_funciones->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grupo_funciones", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGrupoFuncionesGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fuserlevelsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fuserlevelsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("userlevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
