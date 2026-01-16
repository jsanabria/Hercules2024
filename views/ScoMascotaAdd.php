<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMascotaAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mascota: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_mascotaadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mascotaadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["nombre_contratante", [fields.nombre_contratante.visible && fields.nombre_contratante.required ? ew.Validators.required(fields.nombre_contratante.caption) : null], fields.nombre_contratante.isInvalid],
            ["cedula_contratante", [fields.cedula_contratante.visible && fields.cedula_contratante.required ? ew.Validators.required(fields.cedula_contratante.caption) : null], fields.cedula_contratante.isInvalid],
            ["direccion_contratante", [fields.direccion_contratante.visible && fields.direccion_contratante.required ? ew.Validators.required(fields.direccion_contratante.caption) : null], fields.direccion_contratante.isInvalid],
            ["telefono1", [fields.telefono1.visible && fields.telefono1.required ? ew.Validators.required(fields.telefono1.caption) : null], fields.telefono1.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["nombre_mascota", [fields.nombre_mascota.visible && fields.nombre_mascota.required ? ew.Validators.required(fields.nombre_mascota.caption) : null], fields.nombre_mascota.isInvalid],
            ["peso", [fields.peso.visible && fields.peso.required ? ew.Validators.required(fields.peso.caption) : null], fields.peso.isInvalid],
            ["raza", [fields.raza.visible && fields.raza.required ? ew.Validators.required(fields.raza.caption) : null], fields.raza.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["tipo_otro", [fields.tipo_otro.visible && fields.tipo_otro.required ? ew.Validators.required(fields.tipo_otro.caption) : null], fields.tipo_otro.isInvalid],
            ["color", [fields.color.visible && fields.color.required ? ew.Validators.required(fields.color.caption) : null], fields.color.isInvalid],
            ["procedencia", [fields.procedencia.visible && fields.procedencia.required ? ew.Validators.required(fields.procedencia.caption) : null], fields.procedencia.isInvalid],
            ["tarifa", [fields.tarifa.visible && fields.tarifa.required ? ew.Validators.required(fields.tarifa.caption) : null], fields.tarifa.isInvalid],
            ["factura", [fields.factura.visible && fields.factura.required ? ew.Validators.required(fields.factura.caption) : null], fields.factura.isInvalid],
            ["costo", [fields.costo.visible && fields.costo.required ? ew.Validators.required(fields.costo.caption) : null, ew.Validators.float], fields.costo.isInvalid],
            ["tasa", [fields.tasa.visible && fields.tasa.required ? ew.Validators.required(fields.tasa.caption) : null, ew.Validators.float], fields.tasa.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["fecha_cremacion", [fields.fecha_cremacion.visible && fields.fecha_cremacion.required ? ew.Validators.required(fields.fecha_cremacion.caption) : null, ew.Validators.datetime(fields.fecha_cremacion.clientFormatPattern)], fields.fecha_cremacion.isInvalid],
            ["hora_cremacion", [fields.hora_cremacion.visible && fields.hora_cremacion.required ? ew.Validators.required(fields.hora_cremacion.caption) : null, ew.Validators.time(fields.hora_cremacion.clientFormatPattern)], fields.hora_cremacion.isInvalid]
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
            "procedencia": <?= $Page->procedencia->toClientList($Page) ?>,
            "tarifa": <?= $Page->tarifa->toClientList($Page) ?>,
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
<form name="fsco_mascotaadd" id="fsco_mascotaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_mascota">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nombre_contratante->Visible) { // nombre_contratante ?>
    <div id="r_nombre_contratante"<?= $Page->nombre_contratante->rowAttributes() ?>>
        <label id="elh_sco_mascota_nombre_contratante" for="x_nombre_contratante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_contratante->caption() ?><?= $Page->nombre_contratante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_nombre_contratante">
<input type="<?= $Page->nombre_contratante->getInputTextType() ?>" name="x_nombre_contratante" id="x_nombre_contratante" data-table="sco_mascota" data-field="x_nombre_contratante" value="<?= $Page->nombre_contratante->EditValue ?>" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombre_contratante->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_contratante->formatPattern()) ?>"<?= $Page->nombre_contratante->editAttributes() ?> aria-describedby="x_nombre_contratante_help">
<?= $Page->nombre_contratante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_contratante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_contratante->Visible) { // cedula_contratante ?>
    <div id="r_cedula_contratante"<?= $Page->cedula_contratante->rowAttributes() ?>>
        <label id="elh_sco_mascota_cedula_contratante" for="x_cedula_contratante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_contratante->caption() ?><?= $Page->cedula_contratante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_cedula_contratante">
<input type="<?= $Page->cedula_contratante->getInputTextType() ?>" name="x_cedula_contratante" id="x_cedula_contratante" data-table="sco_mascota" data-field="x_cedula_contratante" value="<?= $Page->cedula_contratante->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula_contratante->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_contratante->formatPattern()) ?>"<?= $Page->cedula_contratante->editAttributes() ?> aria-describedby="x_cedula_contratante_help">
<?= $Page->cedula_contratante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula_contratante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion_contratante->Visible) { // direccion_contratante ?>
    <div id="r_direccion_contratante"<?= $Page->direccion_contratante->rowAttributes() ?>>
        <label id="elh_sco_mascota_direccion_contratante" for="x_direccion_contratante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion_contratante->caption() ?><?= $Page->direccion_contratante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion_contratante->cellAttributes() ?>>
<span id="el_sco_mascota_direccion_contratante">
<textarea data-table="sco_mascota" data-field="x_direccion_contratante" name="x_direccion_contratante" id="x_direccion_contratante" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->direccion_contratante->getPlaceHolder()) ?>"<?= $Page->direccion_contratante->editAttributes() ?> aria-describedby="x_direccion_contratante_help"><?= $Page->direccion_contratante->EditValue ?></textarea>
<?= $Page->direccion_contratante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion_contratante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <div id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <label id="elh_sco_mascota_telefono1" for="x_telefono1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono1->caption() ?><?= $Page->telefono1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_mascota_telefono1">
<input type="<?= $Page->telefono1->getInputTextType() ?>" name="x_telefono1" id="x_telefono1" data-table="sco_mascota" data-field="x_telefono1" value="<?= $Page->telefono1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono1->formatPattern()) ?>"<?= $Page->telefono1->editAttributes() ?> aria-describedby="x_telefono1_help">
<?= $Page->telefono1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_mascota_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_mascota_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_mascota" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_mascota__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_mascota__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_mascota" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_mascota->Visible) { // nombre_mascota ?>
    <div id="r_nombre_mascota"<?= $Page->nombre_mascota->rowAttributes() ?>>
        <label id="elh_sco_mascota_nombre_mascota" for="x_nombre_mascota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_mascota->caption() ?><?= $Page->nombre_mascota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_mascota->cellAttributes() ?>>
<span id="el_sco_mascota_nombre_mascota">
<input type="<?= $Page->nombre_mascota->getInputTextType() ?>" name="x_nombre_mascota" id="x_nombre_mascota" data-table="sco_mascota" data-field="x_nombre_mascota" value="<?= $Page->nombre_mascota->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_mascota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_mascota->formatPattern()) ?>"<?= $Page->nombre_mascota->editAttributes() ?> aria-describedby="x_nombre_mascota_help">
<?= $Page->nombre_mascota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_mascota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
    <div id="r_peso"<?= $Page->peso->rowAttributes() ?>>
        <label id="elh_sco_mascota_peso" for="x_peso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->peso->caption() ?><?= $Page->peso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->peso->cellAttributes() ?>>
<span id="el_sco_mascota_peso">
<input type="<?= $Page->peso->getInputTextType() ?>" name="x_peso" id="x_peso" data-table="sco_mascota" data-field="x_peso" value="<?= $Page->peso->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->peso->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->peso->formatPattern()) ?>"<?= $Page->peso->editAttributes() ?> aria-describedby="x_peso_help">
<?= $Page->peso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->peso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->raza->Visible) { // raza ?>
    <div id="r_raza"<?= $Page->raza->rowAttributes() ?>>
        <label id="elh_sco_mascota_raza" for="x_raza" class="<?= $Page->LeftColumnClass ?>"><?= $Page->raza->caption() ?><?= $Page->raza->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->raza->cellAttributes() ?>>
<span id="el_sco_mascota_raza">
<input type="<?= $Page->raza->getInputTextType() ?>" name="x_raza" id="x_raza" data-table="sco_mascota" data-field="x_raza" value="<?= $Page->raza->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->raza->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->raza->formatPattern()) ?>"<?= $Page->raza->editAttributes() ?> aria-describedby="x_raza_help">
<?= $Page->raza->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->raza->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_mascota_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_mascota_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_mascotaadd_x_tipo"
        <?php } ?>
        data-table="sco_mascota"
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
loadjs.ready("fsco_mascotaadd", function() {
    var options = { name: "x_tipo", selectId: "fsco_mascotaadd_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mascotaadd.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_mascotaadd" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_mascotaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mascota.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_otro->Visible) { // tipo_otro ?>
    <div id="r_tipo_otro"<?= $Page->tipo_otro->rowAttributes() ?>>
        <label id="elh_sco_mascota_tipo_otro" for="x_tipo_otro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_otro->caption() ?><?= $Page->tipo_otro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_otro->cellAttributes() ?>>
<span id="el_sco_mascota_tipo_otro">
<input type="<?= $Page->tipo_otro->getInputTextType() ?>" name="x_tipo_otro" id="x_tipo_otro" data-table="sco_mascota" data-field="x_tipo_otro" value="<?= $Page->tipo_otro->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->tipo_otro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_otro->formatPattern()) ?>"<?= $Page->tipo_otro->editAttributes() ?> aria-describedby="x_tipo_otro_help">
<?= $Page->tipo_otro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_otro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
    <div id="r_color"<?= $Page->color->rowAttributes() ?>>
        <label id="elh_sco_mascota_color" for="x_color" class="<?= $Page->LeftColumnClass ?>"><?= $Page->color->caption() ?><?= $Page->color->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->color->cellAttributes() ?>>
<span id="el_sco_mascota_color">
<input type="<?= $Page->color->getInputTextType() ?>" name="x_color" id="x_color" data-table="sco_mascota" data-field="x_color" value="<?= $Page->color->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->color->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->color->formatPattern()) ?>"<?= $Page->color->editAttributes() ?> aria-describedby="x_color_help">
<?= $Page->color->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->color->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->procedencia->Visible) { // procedencia ?>
    <div id="r_procedencia"<?= $Page->procedencia->rowAttributes() ?>>
        <label id="elh_sco_mascota_procedencia" for="x_procedencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->procedencia->caption() ?><?= $Page->procedencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->procedencia->cellAttributes() ?>>
<span id="el_sco_mascota_procedencia">
    <select
        id="x_procedencia"
        name="x_procedencia"
        class="form-select ew-select<?= $Page->procedencia->isInvalidClass() ?>"
        <?php if (!$Page->procedencia->IsNativeSelect) { ?>
        data-select2-id="fsco_mascotaadd_x_procedencia"
        <?php } ?>
        data-table="sco_mascota"
        data-field="x_procedencia"
        data-value-separator="<?= $Page->procedencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->procedencia->getPlaceHolder()) ?>"
        <?= $Page->procedencia->editAttributes() ?>>
        <?= $Page->procedencia->selectOptionListHtml("x_procedencia") ?>
    </select>
    <?= $Page->procedencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->procedencia->getErrorMessage() ?></div>
<?= $Page->procedencia->Lookup->getParamTag($Page, "p_x_procedencia") ?>
<?php if (!$Page->procedencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mascotaadd", function() {
    var options = { name: "x_procedencia", selectId: "fsco_mascotaadd_x_procedencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mascotaadd.lists.procedencia?.lookupOptions.length) {
        options.data = { id: "x_procedencia", form: "fsco_mascotaadd" };
    } else {
        options.ajax = { id: "x_procedencia", form: "fsco_mascotaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mascota.fields.procedencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tarifa->Visible) { // tarifa ?>
    <div id="r_tarifa"<?= $Page->tarifa->rowAttributes() ?>>
        <label id="elh_sco_mascota_tarifa" for="x_tarifa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tarifa->caption() ?><?= $Page->tarifa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tarifa->cellAttributes() ?>>
<span id="el_sco_mascota_tarifa">
    <select
        id="x_tarifa"
        name="x_tarifa"
        class="form-select ew-select<?= $Page->tarifa->isInvalidClass() ?>"
        <?php if (!$Page->tarifa->IsNativeSelect) { ?>
        data-select2-id="fsco_mascotaadd_x_tarifa"
        <?php } ?>
        data-table="sco_mascota"
        data-field="x_tarifa"
        data-value-separator="<?= $Page->tarifa->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tarifa->getPlaceHolder()) ?>"
        <?= $Page->tarifa->editAttributes() ?>>
        <?= $Page->tarifa->selectOptionListHtml("x_tarifa") ?>
    </select>
    <?= $Page->tarifa->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tarifa->getErrorMessage() ?></div>
<?= $Page->tarifa->Lookup->getParamTag($Page, "p_x_tarifa") ?>
<?php if (!$Page->tarifa->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_mascotaadd", function() {
    var options = { name: "x_tarifa", selectId: "fsco_mascotaadd_x_tarifa" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_mascotaadd.lists.tarifa?.lookupOptions.length) {
        options.data = { id: "x_tarifa", form: "fsco_mascotaadd" };
    } else {
        options.ajax = { id: "x_tarifa", form: "fsco_mascotaadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_mascota.fields.tarifa.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <div id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <label id="elh_sco_mascota_factura" for="x_factura" class="<?= $Page->LeftColumnClass ?>"><?= $Page->factura->caption() ?><?= $Page->factura->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->factura->cellAttributes() ?>>
<span id="el_sco_mascota_factura">
<input type="<?= $Page->factura->getInputTextType() ?>" name="x_factura" id="x_factura" data-table="sco_mascota" data-field="x_factura" value="<?= $Page->factura->EditValue ?>" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->factura->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->factura->formatPattern()) ?>"<?= $Page->factura->editAttributes() ?> aria-describedby="x_factura_help">
<?= $Page->factura->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->factura->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <div id="r_costo"<?= $Page->costo->rowAttributes() ?>>
        <label id="elh_sco_mascota_costo" for="x_costo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costo->caption() ?><?= $Page->costo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costo->cellAttributes() ?>>
<span id="el_sco_mascota_costo">
<input type="<?= $Page->costo->getInputTextType() ?>" name="x_costo" id="x_costo" data-table="sco_mascota" data-field="x_costo" value="<?= $Page->costo->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->costo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->costo->formatPattern()) ?>"<?= $Page->costo->editAttributes() ?> aria-describedby="x_costo_help">
<?= $Page->costo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->costo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <div id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <label id="elh_sco_mascota_tasa" for="x_tasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa->caption() ?><?= $Page->tasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_mascota_tasa">
<input type="<?= $Page->tasa->getInputTextType() ?>" name="x_tasa" id="x_tasa" data-table="sco_mascota" data-field="x_tasa" value="<?= $Page->tasa->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tasa->formatPattern()) ?>"<?= $Page->tasa->editAttributes() ?> aria-describedby="x_tasa_help">
<?= $Page->tasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tasa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_mascota_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_mascota_nota">
<textarea data-table="sco_mascota" data-field="x_nota" name="x_nota" id="x_nota" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_cremacion->Visible) { // fecha_cremacion ?>
    <div id="r_fecha_cremacion"<?= $Page->fecha_cremacion->rowAttributes() ?>>
        <label id="elh_sco_mascota_fecha_cremacion" for="x_fecha_cremacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_cremacion->caption() ?><?= $Page->fecha_cremacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_cremacion->cellAttributes() ?>>
<span id="el_sco_mascota_fecha_cremacion">
<input type="<?= $Page->fecha_cremacion->getInputTextType() ?>" name="x_fecha_cremacion" id="x_fecha_cremacion" data-table="sco_mascota" data-field="x_fecha_cremacion" value="<?= $Page->fecha_cremacion->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_cremacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_cremacion->formatPattern()) ?>"<?= $Page->fecha_cremacion->editAttributes() ?> aria-describedby="x_fecha_cremacion_help">
<?= $Page->fecha_cremacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_cremacion->getErrorMessage() ?></div>
<?php if (!$Page->fecha_cremacion->ReadOnly && !$Page->fecha_cremacion->Disabled && !isset($Page->fecha_cremacion->EditAttrs["readonly"]) && !isset($Page->fecha_cremacion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_mascotaadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_mascotaadd", "x_fecha_cremacion", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_cremacion->Visible) { // hora_cremacion ?>
    <div id="r_hora_cremacion"<?= $Page->hora_cremacion->rowAttributes() ?>>
        <label id="elh_sco_mascota_hora_cremacion" for="x_hora_cremacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_cremacion->caption() ?><?= $Page->hora_cremacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_cremacion->cellAttributes() ?>>
<span id="el_sco_mascota_hora_cremacion">
<input type="<?= $Page->hora_cremacion->getInputTextType() ?>" name="x_hora_cremacion" id="x_hora_cremacion" data-table="sco_mascota" data-field="x_hora_cremacion" value="<?= $Page->hora_cremacion->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->hora_cremacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora_cremacion->formatPattern()) ?>"<?= $Page->hora_cremacion->editAttributes() ?> aria-describedby="x_hora_cremacion_help">
<?= $Page->hora_cremacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora_cremacion->getErrorMessage() ?></div>
<?php if (!$Page->hora_cremacion->ReadOnly && !$Page->hora_cremacion->Disabled && !isset($Page->hora_cremacion->EditAttrs["readonly"]) && !isset($Page->hora_cremacion->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_mascotaadd", "timepicker"], () => ew.createTimePicker("fsco_mascotaadd", "x_hora_cremacion", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(4) ?>" })));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_nota_mascota", explode(",", $Page->getCurrentDetailTable())) && $sco_nota_mascota->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota_mascota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaMascotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_mascota_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_mascota_estatus->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_mascota_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoMascotaEstatusGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_mascotaadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_mascotaadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_mascota");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    	$(document).ready(function(){
    		$('#r_tipo_otro').hide();
    	});
    	$("#x_tipo").change(function(){
    		if(this.value == "Otro") $('#r_tipo_otro').show();
    		else $('#r_tipo_otro').hide();
    	});	
});
</script>
