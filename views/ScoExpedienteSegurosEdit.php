<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteSegurosEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_expediente_segurosedit" id="fsco_expediente_segurosedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_seguros: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_expediente_segurosedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_segurosedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nexpediente_seguros", [fields.Nexpediente_seguros.visible && fields.Nexpediente_seguros.required ? ew.Validators.required(fields.Nexpediente_seguros.caption) : null], fields.Nexpediente_seguros.isInvalid],
            ["seguro", [fields.seguro.visible && fields.seguro.required ? ew.Validators.required(fields.seguro.caption) : null], fields.seguro.isInvalid],
            ["nombre_contacto", [fields.nombre_contacto.visible && fields.nombre_contacto.required ? ew.Validators.required(fields.nombre_contacto.caption) : null], fields.nombre_contacto.isInvalid],
            ["parentesco_contacto", [fields.parentesco_contacto.visible && fields.parentesco_contacto.required ? ew.Validators.required(fields.parentesco_contacto.caption) : null], fields.parentesco_contacto.isInvalid],
            ["telefono_contacto1", [fields.telefono_contacto1.visible && fields.telefono_contacto1.required ? ew.Validators.required(fields.telefono_contacto1.caption) : null], fields.telefono_contacto1.isInvalid],
            ["telefono_contacto2", [fields.telefono_contacto2.visible && fields.telefono_contacto2.required ? ew.Validators.required(fields.telefono_contacto2.caption) : null], fields.telefono_contacto2.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["cedula_fallecido", [fields.cedula_fallecido.visible && fields.cedula_fallecido.required ? ew.Validators.required(fields.cedula_fallecido.caption) : null], fields.cedula_fallecido.isInvalid],
            ["nombre_fallecido", [fields.nombre_fallecido.visible && fields.nombre_fallecido.required ? ew.Validators.required(fields.nombre_fallecido.caption) : null], fields.nombre_fallecido.isInvalid],
            ["apellidos_fallecido", [fields.apellidos_fallecido.visible && fields.apellidos_fallecido.required ? ew.Validators.required(fields.apellidos_fallecido.caption) : null], fields.apellidos_fallecido.isInvalid],
            ["sexo", [fields.sexo.visible && fields.sexo.required ? ew.Validators.required(fields.sexo.caption) : null], fields.sexo.isInvalid],
            ["fecha_nacimiento", [fields.fecha_nacimiento.visible && fields.fecha_nacimiento.required ? ew.Validators.required(fields.fecha_nacimiento.caption) : null, ew.Validators.datetime(fields.fecha_nacimiento.clientFormatPattern)], fields.fecha_nacimiento.isInvalid],
            ["lugar_ocurrencia", [fields.lugar_ocurrencia.visible && fields.lugar_ocurrencia.required ? ew.Validators.required(fields.lugar_ocurrencia.caption) : null], fields.lugar_ocurrencia.isInvalid],
            ["direccion_ocurrencia", [fields.direccion_ocurrencia.visible && fields.direccion_ocurrencia.required ? ew.Validators.required(fields.direccion_ocurrencia.caption) : null], fields.direccion_ocurrencia.isInvalid],
            ["fecha_ocurrencia", [fields.fecha_ocurrencia.visible && fields.fecha_ocurrencia.required ? ew.Validators.required(fields.fecha_ocurrencia.caption) : null, ew.Validators.datetime(fields.fecha_ocurrencia.clientFormatPattern)], fields.fecha_ocurrencia.isInvalid],
            ["causa_ocurrencia", [fields.causa_ocurrencia.visible && fields.causa_ocurrencia.required ? ew.Validators.required(fields.causa_ocurrencia.caption) : null], fields.causa_ocurrencia.isInvalid],
            ["causa_otro", [fields.causa_otro.visible && fields.causa_otro.required ? ew.Validators.required(fields.causa_otro.caption) : null], fields.causa_otro.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["religion", [fields.religion.visible && fields.religion.required ? ew.Validators.required(fields.religion.caption) : null], fields.religion.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null], fields.funeraria.isInvalid]
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
            "parentesco_contacto": <?= $Page->parentesco_contacto->toClientList($Page) ?>,
            "sexo": <?= $Page->sexo->toClientList($Page) ?>,
            "lugar_ocurrencia": <?= $Page->lugar_ocurrencia->toClientList($Page) ?>,
            "causa_ocurrencia": <?= $Page->causa_ocurrencia->toClientList($Page) ?>,
            "religion": <?= $Page->religion->toClientList($Page) ?>,
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
            "funeraria": <?= $Page->funeraria->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_expediente_seguros">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nexpediente_seguros->Visible) { // Nexpediente_seguros ?>
    <div id="r_Nexpediente_seguros"<?= $Page->Nexpediente_seguros->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_Nexpediente_seguros" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nexpediente_seguros->caption() ?><?= $Page->Nexpediente_seguros->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nexpediente_seguros->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_Nexpediente_seguros">
<span<?= $Page->Nexpediente_seguros->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nexpediente_seguros->getDisplayValue($Page->Nexpediente_seguros->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente_seguros" data-field="x_Nexpediente_seguros" data-hidden="1" name="x_Nexpediente_seguros" id="x_Nexpediente_seguros" value="<?= HtmlEncode($Page->Nexpediente_seguros->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <div id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_seguro" for="x_seguro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seguro->caption() ?><?= $Page->seguro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->seguro->getDisplayValue($Page->seguro->EditValue) ?></span></span>
<input type="hidden" data-table="sco_expediente_seguros" data-field="x_seguro" data-hidden="1" name="x_seguro" id="x_seguro" value="<?= HtmlEncode($Page->seguro->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
    <div id="r_nombre_contacto"<?= $Page->nombre_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_nombre_contacto" for="x_nombre_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_contacto->caption() ?><?= $Page->nombre_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nombre_contacto">
<input type="<?= $Page->nombre_contacto->getInputTextType() ?>" name="x_nombre_contacto" id="x_nombre_contacto" data-table="sco_expediente_seguros" data-field="x_nombre_contacto" value="<?= $Page->nombre_contacto->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_contacto->formatPattern()) ?>"<?= $Page->nombre_contacto->editAttributes() ?> aria-describedby="x_nombre_contacto_help">
<?= $Page->nombre_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
    <div id="r_parentesco_contacto"<?= $Page->parentesco_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_parentesco_contacto" for="x_parentesco_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parentesco_contacto->caption() ?><?= $Page->parentesco_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_parentesco_contacto">
    <select
        id="x_parentesco_contacto"
        name="x_parentesco_contacto"
        class="form-select ew-select<?= $Page->parentesco_contacto->isInvalidClass() ?>"
        <?php if (!$Page->parentesco_contacto->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_parentesco_contacto"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_parentesco_contacto"
        data-value-separator="<?= $Page->parentesco_contacto->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->parentesco_contacto->getPlaceHolder()) ?>"
        <?= $Page->parentesco_contacto->editAttributes() ?>>
        <?= $Page->parentesco_contacto->selectOptionListHtml("x_parentesco_contacto") ?>
    </select>
    <?= $Page->parentesco_contacto->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->parentesco_contacto->getErrorMessage() ?></div>
<?= $Page->parentesco_contacto->Lookup->getParamTag($Page, "p_x_parentesco_contacto") ?>
<?php if (!$Page->parentesco_contacto->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_parentesco_contacto", selectId: "fsco_expediente_segurosedit_x_parentesco_contacto" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.parentesco_contacto?.lookupOptions.length) {
        options.data = { id: "x_parentesco_contacto", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_parentesco_contacto", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.parentesco_contacto.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
    <div id="r_telefono_contacto1"<?= $Page->telefono_contacto1->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_telefono_contacto1" for="x_telefono_contacto1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_contacto1->caption() ?><?= $Page->telefono_contacto1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_telefono_contacto1">
<input type="<?= $Page->telefono_contacto1->getInputTextType() ?>" name="x_telefono_contacto1" id="x_telefono_contacto1" data-table="sco_expediente_seguros" data-field="x_telefono_contacto1" value="<?= $Page->telefono_contacto1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_contacto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_contacto1->formatPattern()) ?>"<?= $Page->telefono_contacto1->editAttributes() ?> aria-describedby="x_telefono_contacto1_help">
<?= $Page->telefono_contacto1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_contacto1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
    <div id="r_telefono_contacto2"<?= $Page->telefono_contacto2->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_telefono_contacto2" for="x_telefono_contacto2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_contacto2->caption() ?><?= $Page->telefono_contacto2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_telefono_contacto2">
<input type="<?= $Page->telefono_contacto2->getInputTextType() ?>" name="x_telefono_contacto2" id="x_telefono_contacto2" data-table="sco_expediente_seguros" data-field="x_telefono_contacto2" value="<?= $Page->telefono_contacto2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_contacto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_contacto2->formatPattern()) ?>"<?= $Page->telefono_contacto2->editAttributes() ?> aria-describedby="x_telefono_contacto2_help">
<?= $Page->telefono_contacto2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_contacto2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_expediente_seguros__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_expediente_seguros" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <div id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_cedula_fallecido" for="x_cedula_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_fallecido->caption() ?><?= $Page->cedula_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_cedula_fallecido">
<input type="<?= $Page->cedula_fallecido->getInputTextType() ?>" name="x_cedula_fallecido" id="x_cedula_fallecido" data-table="sco_expediente_seguros" data-field="x_cedula_fallecido" value="<?= $Page->cedula_fallecido->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_fallecido->formatPattern()) ?>"<?= $Page->cedula_fallecido->editAttributes() ?> aria-describedby="x_cedula_fallecido_help">
<?= $Page->cedula_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <div id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_nombre_fallecido" for="x_nombre_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_fallecido->caption() ?><?= $Page->nombre_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nombre_fallecido">
<input type="<?= $Page->nombre_fallecido->getInputTextType() ?>" name="x_nombre_fallecido" id="x_nombre_fallecido" data-table="sco_expediente_seguros" data-field="x_nombre_fallecido" value="<?= $Page->nombre_fallecido->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_fallecido->formatPattern()) ?>"<?= $Page->nombre_fallecido->editAttributes() ?> aria-describedby="x_nombre_fallecido_help">
<?= $Page->nombre_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <div id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_apellidos_fallecido" for="x_apellidos_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos_fallecido->caption() ?><?= $Page->apellidos_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_apellidos_fallecido">
<input type="<?= $Page->apellidos_fallecido->getInputTextType() ?>" name="x_apellidos_fallecido" id="x_apellidos_fallecido" data-table="sco_expediente_seguros" data-field="x_apellidos_fallecido" value="<?= $Page->apellidos_fallecido->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->apellidos_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellidos_fallecido->formatPattern()) ?>"<?= $Page->apellidos_fallecido->editAttributes() ?> aria-describedby="x_apellidos_fallecido_help">
<?= $Page->apellidos_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
    <div id="r_sexo"<?= $Page->sexo->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_sexo" for="x_sexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sexo->caption() ?><?= $Page->sexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sexo->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_sexo">
    <select
        id="x_sexo"
        name="x_sexo"
        class="form-select ew-select<?= $Page->sexo->isInvalidClass() ?>"
        <?php if (!$Page->sexo->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_sexo"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_sexo"
        data-value-separator="<?= $Page->sexo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->sexo->getPlaceHolder()) ?>"
        <?= $Page->sexo->editAttributes() ?>>
        <?= $Page->sexo->selectOptionListHtml("x_sexo") ?>
    </select>
    <?= $Page->sexo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->sexo->getErrorMessage() ?></div>
<?= $Page->sexo->Lookup->getParamTag($Page, "p_x_sexo") ?>
<?php if (!$Page->sexo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_sexo", selectId: "fsco_expediente_segurosedit_x_sexo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.sexo?.lookupOptions.length) {
        options.data = { id: "x_sexo", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_sexo", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.sexo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <div id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_fecha_nacimiento" for="x_fecha_nacimiento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_nacimiento->caption() ?><?= $Page->fecha_nacimiento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_fecha_nacimiento">
<input type="<?= $Page->fecha_nacimiento->getInputTextType() ?>" name="x_fecha_nacimiento" id="x_fecha_nacimiento" data-table="sco_expediente_seguros" data-field="x_fecha_nacimiento" value="<?= $Page->fecha_nacimiento->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_nacimiento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_nacimiento->formatPattern()) ?>"<?= $Page->fecha_nacimiento->editAttributes() ?> aria-describedby="x_fecha_nacimiento_help">
<?= $Page->fecha_nacimiento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_nacimiento->getErrorMessage() ?></div>
<?php if (!$Page->fecha_nacimiento->ReadOnly && !$Page->fecha_nacimiento->Disabled && !isset($Page->fecha_nacimiento->EditAttrs["readonly"]) && !isset($Page->fecha_nacimiento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_segurosedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fsco_expediente_segurosedit", "x_fecha_nacimiento", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
    <div id="r_lugar_ocurrencia"<?= $Page->lugar_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_lugar_ocurrencia" for="x_lugar_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lugar_ocurrencia->caption() ?><?= $Page->lugar_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_lugar_ocurrencia">
    <select
        id="x_lugar_ocurrencia"
        name="x_lugar_ocurrencia"
        class="form-select ew-select<?= $Page->lugar_ocurrencia->isInvalidClass() ?>"
        <?php if (!$Page->lugar_ocurrencia->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_lugar_ocurrencia"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_lugar_ocurrencia"
        data-value-separator="<?= $Page->lugar_ocurrencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->lugar_ocurrencia->getPlaceHolder()) ?>"
        <?= $Page->lugar_ocurrencia->editAttributes() ?>>
        <?= $Page->lugar_ocurrencia->selectOptionListHtml("x_lugar_ocurrencia") ?>
    </select>
    <?= $Page->lugar_ocurrencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->lugar_ocurrencia->getErrorMessage() ?></div>
<?= $Page->lugar_ocurrencia->Lookup->getParamTag($Page, "p_x_lugar_ocurrencia") ?>
<?php if (!$Page->lugar_ocurrencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_lugar_ocurrencia", selectId: "fsco_expediente_segurosedit_x_lugar_ocurrencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.lugar_ocurrencia?.lookupOptions.length) {
        options.data = { id: "x_lugar_ocurrencia", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_lugar_ocurrencia", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.lugar_ocurrencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
    <div id="r_direccion_ocurrencia"<?= $Page->direccion_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_direccion_ocurrencia" for="x_direccion_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion_ocurrencia->caption() ?><?= $Page->direccion_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_direccion_ocurrencia">
<textarea data-table="sco_expediente_seguros" data-field="x_direccion_ocurrencia" name="x_direccion_ocurrencia" id="x_direccion_ocurrencia" cols="30" rows="4" placeholder="<?= HtmlEncode($Page->direccion_ocurrencia->getPlaceHolder()) ?>"<?= $Page->direccion_ocurrencia->editAttributes() ?> aria-describedby="x_direccion_ocurrencia_help"><?= $Page->direccion_ocurrencia->EditValue ?></textarea>
<?= $Page->direccion_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion_ocurrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
    <div id="r_fecha_ocurrencia"<?= $Page->fecha_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_fecha_ocurrencia" for="x_fecha_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_ocurrencia->caption() ?><?= $Page->fecha_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_fecha_ocurrencia">
<input type="<?= $Page->fecha_ocurrencia->getInputTextType() ?>" name="x_fecha_ocurrencia" id="x_fecha_ocurrencia" data-table="sco_expediente_seguros" data-field="x_fecha_ocurrencia" value="<?= $Page->fecha_ocurrencia->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_ocurrencia->formatPattern()) ?>"<?= $Page->fecha_ocurrencia->editAttributes() ?> aria-describedby="x_fecha_ocurrencia_help">
<?= $Page->fecha_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_ocurrencia->getErrorMessage() ?></div>
<?php if (!$Page->fecha_ocurrencia->ReadOnly && !$Page->fecha_ocurrencia->Disabled && !isset($Page->fecha_ocurrencia->EditAttrs["readonly"]) && !isset($Page->fecha_ocurrencia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_segurosedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fsco_expediente_segurosedit", "x_fecha_ocurrencia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <div id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_causa_ocurrencia" for="x_causa_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_ocurrencia->caption() ?><?= $Page->causa_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_causa_ocurrencia">
    <select
        id="x_causa_ocurrencia"
        name="x_causa_ocurrencia"
        class="form-select ew-select<?= $Page->causa_ocurrencia->isInvalidClass() ?>"
        <?php if (!$Page->causa_ocurrencia->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_causa_ocurrencia"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_causa_ocurrencia"
        data-value-separator="<?= $Page->causa_ocurrencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->causa_ocurrencia->getPlaceHolder()) ?>"
        <?= $Page->causa_ocurrencia->editAttributes() ?>>
        <?= $Page->causa_ocurrencia->selectOptionListHtml("x_causa_ocurrencia") ?>
    </select>
    <?= $Page->causa_ocurrencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->causa_ocurrencia->getErrorMessage() ?></div>
<?= $Page->causa_ocurrencia->Lookup->getParamTag($Page, "p_x_causa_ocurrencia") ?>
<?php if (!$Page->causa_ocurrencia->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_causa_ocurrencia", selectId: "fsco_expediente_segurosedit_x_causa_ocurrencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.causa_ocurrencia?.lookupOptions.length) {
        options.data = { id: "x_causa_ocurrencia", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_causa_ocurrencia", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.causa_ocurrencia.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
    <div id="r_causa_otro"<?= $Page->causa_otro->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_causa_otro" for="x_causa_otro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_otro->caption() ?><?= $Page->causa_otro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_causa_otro">
<input type="<?= $Page->causa_otro->getInputTextType() ?>" name="x_causa_otro" id="x_causa_otro" data-table="sco_expediente_seguros" data-field="x_causa_otro" value="<?= $Page->causa_otro->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->causa_otro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->causa_otro->formatPattern()) ?>"<?= $Page->causa_otro->editAttributes() ?> aria-describedby="x_causa_otro_help">
<?= $Page->causa_otro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->causa_otro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nota">
<textarea data-table="sco_expediente_seguros" data-field="x_nota" name="x_nota" id="x_nota" cols="30" rows="4" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
    <div id="r_religion"<?= $Page->religion->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_religion" for="x_religion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->religion->caption() ?><?= $Page->religion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->religion->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_religion">
    <select
        id="x_religion"
        name="x_religion"
        class="form-select ew-select<?= $Page->religion->isInvalidClass() ?>"
        <?php if (!$Page->religion->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_religion"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_religion"
        data-value-separator="<?= $Page->religion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->religion->getPlaceHolder()) ?>"
        <?= $Page->religion->editAttributes() ?>>
        <?= $Page->religion->selectOptionListHtml("x_religion") ?>
    </select>
    <?= $Page->religion->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->religion->getErrorMessage() ?></div>
<?= $Page->religion->Lookup->getParamTag($Page, "p_x_religion") ?>
<?php if (!$Page->religion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_religion", selectId: "fsco_expediente_segurosedit_x_religion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.religion?.lookupOptions.length) {
        options.data = { id: "x_religion", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_religion", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.religion.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <div id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_servicio_tipo">
    <select
        id="x_servicio_tipo"
        name="x_servicio_tipo"
        class="form-select ew-select<?= $Page->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_servicio_tipo"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_servicio_tipo"
        data-value-separator="<?= $Page->servicio_tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio_tipo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->servicio_tipo->editAttributes() ?>>
        <?= $Page->servicio_tipo->selectOptionListHtml("x_servicio_tipo") ?>
    </select>
    <?= $Page->servicio_tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio_tipo->getErrorMessage() ?></div>
<?= $Page->servicio_tipo->Lookup->getParamTag($Page, "p_x_servicio_tipo") ?>
<?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_servicio_tipo", selectId: "fsco_expediente_segurosedit_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.servicio_tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <div id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_servicio">
    <select
        id="x_servicio"
        name="x_servicio"
        class="form-select ew-select<?= $Page->servicio->isInvalidClass() ?>"
        <?php if (!$Page->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_servicio"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_servicio"
        data-value-separator="<?= $Page->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>"
        <?= $Page->servicio->editAttributes() ?>>
        <?= $Page->servicio->selectOptionListHtml("x_servicio") ?>
    </select>
    <?= $Page->servicio->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->servicio->getErrorMessage() ?></div>
<?= $Page->servicio->Lookup->getParamTag($Page, "p_x_servicio") ?>
<?php if (!$Page->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_servicio", selectId: "fsco_expediente_segurosedit_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_servicio", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_estatus"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_expediente_segurosedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <div id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguros_funeraria" for="x_funeraria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funeraria->caption() ?><?= $Page->funeraria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_funeraria">
    <select
        id="x_funeraria"
        name="x_funeraria"
        class="form-select ew-select<?= $Page->funeraria->isInvalidClass() ?>"
        <?php if (!$Page->funeraria->IsNativeSelect) { ?>
        data-select2-id="fsco_expediente_segurosedit_x_funeraria"
        <?php } ?>
        data-table="sco_expediente_seguros"
        data-field="x_funeraria"
        data-value-separator="<?= $Page->funeraria->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->funeraria->getPlaceHolder()) ?>"
        <?= $Page->funeraria->editAttributes() ?>>
        <?= $Page->funeraria->selectOptionListHtml("x_funeraria") ?>
    </select>
    <?= $Page->funeraria->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->funeraria->getErrorMessage() ?></div>
<?php if (!$Page->funeraria->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expediente_segurosedit", function() {
    var options = { name: "x_funeraria", selectId: "fsco_expediente_segurosedit_x_funeraria" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expediente_segurosedit.lists.funeraria?.lookupOptions.length) {
        options.data = { id: "x_funeraria", form: "fsco_expediente_segurosedit" };
    } else {
        options.ajax = { id: "x_funeraria", form: "fsco_expediente_segurosedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente_seguros.fields.funeraria.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_expediente_seguros_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_seguros_adjunto->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_seguros_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteSegurosAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expediente_segurosedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expediente_segurosedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_expediente_seguros");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_telefono_contacto1").mask("(9999) 999-99-99");
    $("#x_telefono_contacto2").mask("(9999) 999-99-99");
    if($("#x_causa_ocurrencia").val() == "OTRO")
    	$("#x_causa_otro").show();
    else
    	$("#x_causa_otro").hide();
    $(document).ready(function(){
    	$("#x_causa_ocurrencia").bind("change", function() {
    		if($("#x_causa_ocurrencia").val() == "OTRO")
    			$("#x_causa_otro").show();
    		else {
    			$("#x_causa_otro").hide();
    			document.getElementById("x_causa_otro").value = "";
    		}
    	})
    })

    // Valiacaión CI 
    $("#x_cedula_fallecido").change(function(){
    	var xBad = true;
    	$("#x_cedula_fallecido").val($("#x_cedula_fallecido").val().replace(" ",""));
    	$("#x_cedula_fallecido").val($("#x_cedula_fallecido").val().replace(".",""));
    	$("#x_cedula_fallecido").val($("#x_cedula_fallecido").val().replace(",",""));
    	if($("#x_cedula_fallecido").val().substring(1,2)!="-")
    		$("#x_cedula_fallecido").val($("#x_cedula_fallecido").val().substring(0,1) + "-" + $("#x_cedula_fallecido").val().substring(1,$("#x_cedula_fallecido").val().length).trim());
    	$("#x_cedula_fallecido").val($("#x_cedula_fallecido").val().toUpperCase());
    	if($("#x_cedula_fallecido").val()==""){
    		alert("Este campo no puede estar vacio");
    		xBad = false;
    	}else if($("#x_cedula_fallecido").val().length < 7) {
    		alert("Este campo debe ser mayor a 6 caracteres");
    		xBad = false;
    	}else if($("#x_cedula_fallecido").val().length > 12) {
    		alert("Este campo debe ser menor a 12 caracteres");
    		xBad = false;
    	}else if($("#x_cedula_fallecido").val().substring(0,2) != "V-" && $("#x_cedula_fallecido").val().substring(0,2) != "E-" && $("#x_cedula_fallecido").val().substring(0,2) != "M-") {
    		alert("La CI debe comenzar con (V-) Venezolano o con (E-) Extranjero o con (M-) Menor de edad sin poseer CI.");
    		xBad = false;
    	}else if(isNaN($("#x_cedula_fallecido").val().substring(2,$("#x_cedula_fallecido").val().length))) {
    		alert("La CI debe ser un valor entero");
    		xBad = false;
    	}
    	if(xBad == false) {
    		$("#x_cedula_fallecido").val("");
    		return false;
    	}
    });
});
</script>
