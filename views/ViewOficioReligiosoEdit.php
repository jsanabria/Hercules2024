<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewOficioReligiosoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fview_oficio_religiosoedit" id="fview_oficio_religiosoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_oficio_religioso: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fview_oficio_religiosoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_oficio_religiosoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["cedula", [fields.cedula.visible && fields.cedula.required ? ew.Validators.required(fields.cedula.caption) : null], fields.cedula.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["apellido", [fields.apellido.visible && fields.apellido.required ? ew.Validators.required(fields.apellido.caption) : null], fields.apellido.isInvalid],
            ["ministro", [fields.ministro.visible && fields.ministro.required ? ew.Validators.required(fields.ministro.caption) : null], fields.ministro.isInvalid],
            ["servicio_atendido", [fields.servicio_atendido.visible && fields.servicio_atendido.required ? ew.Validators.required(fields.servicio_atendido.caption) : null], fields.servicio_atendido.isInvalid],
            ["fecha_servicio", [fields.fecha_servicio.visible && fields.fecha_servicio.required ? ew.Validators.required(fields.fecha_servicio.caption) : null], fields.fecha_servicio.isInvalid]
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
            "ministro": <?= $Page->ministro->toClientList($Page) ?>,
            "servicio_atendido": <?= $Page->servicio_atendido->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="view_oficio_religioso">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->cedula->Visible) { // cedula ?>
    <div id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <label id="elh_view_oficio_religioso_cedula" for="x_cedula" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula->caption() ?><?= $Page->cedula->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula->cellAttributes() ?>>
<span id="el_view_oficio_religioso_cedula">
<span<?= $Page->cedula->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->cedula->getDisplayValue($Page->cedula->EditValue))) ?>"></span>
<input type="hidden" data-table="view_oficio_religioso" data-field="x_cedula" data-hidden="1" name="x_cedula" id="x_cedula" value="<?= HtmlEncode($Page->cedula->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_view_oficio_religioso_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_view_oficio_religioso_nombre">
<span<?= $Page->nombre->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->nombre->getDisplayValue($Page->nombre->EditValue))) ?>"></span>
<input type="hidden" data-table="view_oficio_religioso" data-field="x_nombre" data-hidden="1" name="x_nombre" id="x_nombre" value="<?= HtmlEncode($Page->nombre->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido->Visible) { // apellido ?>
    <div id="r_apellido"<?= $Page->apellido->rowAttributes() ?>>
        <label id="elh_view_oficio_religioso_apellido" for="x_apellido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido->caption() ?><?= $Page->apellido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido->cellAttributes() ?>>
<span id="el_view_oficio_religioso_apellido">
<span<?= $Page->apellido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->apellido->getDisplayValue($Page->apellido->EditValue))) ?>"></span>
<input type="hidden" data-table="view_oficio_religioso" data-field="x_apellido" data-hidden="1" name="x_apellido" id="x_apellido" value="<?= HtmlEncode($Page->apellido->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ministro->Visible) { // ministro ?>
    <div id="r_ministro"<?= $Page->ministro->rowAttributes() ?>>
        <label id="elh_view_oficio_religioso_ministro" for="x_ministro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ministro->caption() ?><?= $Page->ministro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ministro->cellAttributes() ?>>
<span id="el_view_oficio_religioso_ministro">
    <select
        id="x_ministro"
        name="x_ministro"
        class="form-control ew-select<?= $Page->ministro->isInvalidClass() ?>"
        data-select2-id="fview_oficio_religiosoedit_x_ministro"
        data-table="view_oficio_religioso"
        data-field="x_ministro"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->ministro->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->ministro->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->ministro->getPlaceHolder()) ?>"
        <?= $Page->ministro->editAttributes() ?>>
        <?= $Page->ministro->selectOptionListHtml("x_ministro") ?>
    </select>
    <?= $Page->ministro->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->ministro->getErrorMessage() ?></div>
<?= $Page->ministro->Lookup->getParamTag($Page, "p_x_ministro") ?>
<script>
loadjs.ready("fview_oficio_religiosoedit", function() {
    var options = { name: "x_ministro", selectId: "fview_oficio_religiosoedit_x_ministro" };
    if (fview_oficio_religiosoedit.lists.ministro?.lookupOptions.length) {
        options.data = { id: "x_ministro", form: "fview_oficio_religiosoedit" };
    } else {
        options.ajax = { id: "x_ministro", form: "fview_oficio_religiosoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.view_oficio_religioso.fields.ministro.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio_atendido->Visible) { // servicio_atendido ?>
    <div id="r_servicio_atendido"<?= $Page->servicio_atendido->rowAttributes() ?>>
        <label id="elh_view_oficio_religioso_servicio_atendido" for="x_servicio_atendido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_atendido->caption() ?><?= $Page->servicio_atendido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_atendido->cellAttributes() ?>>
<span id="el_view_oficio_religioso_servicio_atendido">
    <select
        id="x_servicio_atendido"
        name="x_servicio_atendido"
        class="form-select ew-select<?= $Page->servicio_atendido->isInvalidClass() ?>"
        <?php if (!$Page->servicio_atendido->IsNativeSelect) { ?>
        data-select2-id="fview_oficio_religiosoedit_x_servicio_atendido"
        <?php } ?>
        data-table="view_oficio_religioso"
        data-field="x_servicio_atendido"
        data-value-separator="<?= $Page->servicio_atendido->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_atendido->getPlaceHolder()) ?>"
        <?= $Page->servicio_atendido->editAttributes() ?>>
        <?= $Page->servicio_atendido->selectOptionListHtml("x_servicio_atendido") ?>
    </select>
    <?= $Page->servicio_atendido->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio_atendido->getErrorMessage() ?></div>
<?php if (!$Page->servicio_atendido->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_oficio_religiosoedit", function() {
    var options = { name: "x_servicio_atendido", selectId: "fview_oficio_religiosoedit_x_servicio_atendido" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_oficio_religiosoedit.lists.servicio_atendido?.lookupOptions.length) {
        options.data = { id: "x_servicio_atendido", form: "fview_oficio_religiosoedit" };
    } else {
        options.ajax = { id: "x_servicio_atendido", form: "fview_oficio_religiosoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_oficio_religioso.fields.servicio_atendido.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <div id="r_fecha_servicio"<?= $Page->fecha_servicio->rowAttributes() ?>>
        <label id="elh_view_oficio_religioso_fecha_servicio" for="x_fecha_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_servicio->caption() ?><?= $Page->fecha_servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_servicio->cellAttributes() ?>>
<span id="el_view_oficio_religioso_fecha_servicio">
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha_servicio->getDisplayValue($Page->fecha_servicio->EditValue))) ?>"></span>
<input type="hidden" data-table="view_oficio_religioso" data-field="x_fecha_servicio" data-hidden="1" name="x_fecha_servicio" id="x_fecha_servicio" value="<?= HtmlEncode($Page->fecha_servicio->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="view_oficio_religioso" data-field="x_Norden" data-hidden="1" name="x_Norden" id="x_Norden" value="<?= HtmlEncode($Page->Norden->CurrentValue) ?>">
    <input type="hidden" data-table="view_oficio_religioso" data-field="x_Nexpediente" data-hidden="1" name="x_Nexpediente" id="x_Nexpediente" value="<?= HtmlEncode($Page->Nexpediente->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fview_oficio_religiosoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fview_oficio_religiosoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("view_oficio_religioso");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $(document).ready(function(){
    	if($("#x_ministro").val().trim() == "") {
    		$("#x_ministro").val("<?php echo CurrentUserName(); ?>");
    	}
    });
});
</script>
