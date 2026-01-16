<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_expedienteadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expedienteadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["contrato_parcela", [fields.contrato_parcela.visible && fields.contrato_parcela.required ? ew.Validators.required(fields.contrato_parcela.caption) : null], fields.contrato_parcela.isInvalid],
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
            ["religion", [fields.religion.visible && fields.religion.required ? ew.Validators.required(fields.religion.caption) : null], fields.religion.isInvalid],
            ["permiso", [fields.permiso.visible && fields.permiso.required ? ew.Validators.required(fields.permiso.caption) : null], fields.permiso.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null], fields.funeraria.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["marca_pasos", [fields.marca_pasos.visible && fields.marca_pasos.required ? ew.Validators.required(fields.marca_pasos.caption) : null], fields.marca_pasos.isInvalid],
            ["peso", [fields.peso.visible && fields.peso.required ? ew.Validators.required(fields.peso.caption) : null], fields.peso.isInvalid],
            ["certificado_defuncion", [fields.certificado_defuncion.visible && fields.certificado_defuncion.required ? ew.Validators.required(fields.certificado_defuncion.caption) : null], fields.certificado_defuncion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid]
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

        // Multi-Page
        .setMultiPage(true)

        // Dynamic selection lists
        .setLists({
            "seguro": <?= $Page->seguro->toClientList($Page) ?>,
            "parentesco_contacto": <?= $Page->parentesco_contacto->toClientList($Page) ?>,
            "sexo": <?= $Page->sexo->toClientList($Page) ?>,
            "lugar_ocurrencia": <?= $Page->lugar_ocurrencia->toClientList($Page) ?>,
            "causa_ocurrencia": <?= $Page->causa_ocurrencia->toClientList($Page) ?>,
            "religion": <?= $Page->religion->toClientList($Page) ?>,
            "funeraria": <?= $Page->funeraria->toClientList($Page) ?>,
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
            "marca_pasos": <?= $Page->marca_pasos->toClientList($Page) ?>,
            "peso": <?= $Page->peso->toClientList($Page) ?>,
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
<form name="fsco_expedienteadd" id="fsco_expedienteadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_ScoExpedienteAdd"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_sco_expediente1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_sco_expediente2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_sco_expediente3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_sco_expediente4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_sco_expediente1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
    <div id="r_contrato_parcela"<?= $Page->contrato_parcela->rowAttributes() ?>>
        <label id="elh_sco_expediente_contrato_parcela" for="x_contrato_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato_parcela->caption() ?><?= $Page->contrato_parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato_parcela->cellAttributes() ?>>
<span id="el_sco_expediente_contrato_parcela">
<input type="<?= $Page->contrato_parcela->getInputTextType() ?>" name="x_contrato_parcela" id="x_contrato_parcela" data-table="sco_expediente" data-field="x_contrato_parcela" value="<?= $Page->contrato_parcela->EditValue ?>" data-page="1" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->contrato_parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato_parcela->formatPattern()) ?>"<?= $Page->contrato_parcela->editAttributes() ?> aria-describedby="x_contrato_parcela_help">
<?= $Page->contrato_parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato_parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <div id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <label id="elh_sco_expediente_seguro" for="x_seguro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seguro->caption() ?><?= $Page->seguro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_seguro">
    <select
        id="x_seguro"
        name="x_seguro"
        class="form-control ew-select<?= $Page->seguro->isInvalidClass() ?>"
        data-select2-id="fsco_expedienteadd_x_seguro"
        data-table="sco_expediente"
        data-field="x_seguro"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->seguro->caption())) ?>"
        data-modal-lookup="true"
        data-page="1"
        data-value-separator="<?= $Page->seguro->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->seguro->getPlaceHolder()) ?>"
        <?= $Page->seguro->editAttributes() ?>>
        <?= $Page->seguro->selectOptionListHtml("x_seguro") ?>
    </select>
    <?= $Page->seguro->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->seguro->getErrorMessage() ?></div>
<?= $Page->seguro->Lookup->getParamTag($Page, "p_x_seguro") ?>
<script>
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_seguro", selectId: "fsco_expedienteadd_x_seguro" };
    if (fsco_expedienteadd.lists.seguro?.lookupOptions.length) {
        options.data = { id: "x_seguro", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_seguro", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_expediente.fields.seguro.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
    <div id="r_nombre_contacto"<?= $Page->nombre_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_nombre_contacto" for="x_nombre_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_contacto->caption() ?><?= $Page->nombre_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_nombre_contacto">
<input type="<?= $Page->nombre_contacto->getInputTextType() ?>" name="x_nombre_contacto" id="x_nombre_contacto" data-table="sco_expediente" data-field="x_nombre_contacto" value="<?= $Page->nombre_contacto->EditValue ?>" data-page="1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_contacto->formatPattern()) ?>"<?= $Page->nombre_contacto->editAttributes() ?> aria-describedby="x_nombre_contacto_help">
<?= $Page->nombre_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
    <div id="r_parentesco_contacto"<?= $Page->parentesco_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_parentesco_contacto" for="x_parentesco_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parentesco_contacto->caption() ?><?= $Page->parentesco_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_parentesco_contacto">
    <select
        id="x_parentesco_contacto"
        name="x_parentesco_contacto"
        class="form-select ew-select<?= $Page->parentesco_contacto->isInvalidClass() ?>"
        <?php if (!$Page->parentesco_contacto->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_parentesco_contacto"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_parentesco_contacto"
        data-page="1"
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
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_parentesco_contacto", selectId: "fsco_expedienteadd_x_parentesco_contacto" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.parentesco_contacto?.lookupOptions.length) {
        options.data = { id: "x_parentesco_contacto", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_parentesco_contacto", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.parentesco_contacto.selectOptions);
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
        <label id="elh_sco_expediente_telefono_contacto1" for="x_telefono_contacto1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_contacto1->caption() ?><?= $Page->telefono_contacto1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el_sco_expediente_telefono_contacto1">
<input type="<?= $Page->telefono_contacto1->getInputTextType() ?>" name="x_telefono_contacto1" id="x_telefono_contacto1" data-table="sco_expediente" data-field="x_telefono_contacto1" value="<?= $Page->telefono_contacto1->EditValue ?>" data-page="1" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_contacto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_contacto1->formatPattern()) ?>"<?= $Page->telefono_contacto1->editAttributes() ?> aria-describedby="x_telefono_contacto1_help">
<?= $Page->telefono_contacto1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_contacto1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
    <div id="r_telefono_contacto2"<?= $Page->telefono_contacto2->rowAttributes() ?>>
        <label id="elh_sco_expediente_telefono_contacto2" for="x_telefono_contacto2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_contacto2->caption() ?><?= $Page->telefono_contacto2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el_sco_expediente_telefono_contacto2">
<input type="<?= $Page->telefono_contacto2->getInputTextType() ?>" name="x_telefono_contacto2" id="x_telefono_contacto2" data-table="sco_expediente" data-field="x_telefono_contacto2" value="<?= $Page->telefono_contacto2->EditValue ?>" data-page="1" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_contacto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_contacto2->formatPattern()) ?>"<?= $Page->telefono_contacto2->editAttributes() ?> aria-describedby="x_telefono_contacto2_help">
<?= $Page->telefono_contacto2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_contacto2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_expediente__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_expediente__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_expediente" data-field="x__email" value="<?= $Page->_email->EditValue ?>" data-page="1" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_expediente_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_expediente_parcela">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_expediente" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" data-page="1" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?> aria-describedby="x_parcela_help">
<?= $Page->parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_sco_expediente2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <div id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_cedula_fallecido" for="x_cedula_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_fallecido->caption() ?><?= $Page->cedula_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_cedula_fallecido">
<input type="<?= $Page->cedula_fallecido->getInputTextType() ?>" name="x_cedula_fallecido" id="x_cedula_fallecido" data-table="sco_expediente" data-field="x_cedula_fallecido" value="<?= $Page->cedula_fallecido->EditValue ?>" data-page="2" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_fallecido->formatPattern()) ?>"<?= $Page->cedula_fallecido->editAttributes() ?> aria-describedby="x_cedula_fallecido_help">
<?= $Page->cedula_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <div id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_nombre_fallecido" for="x_nombre_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_fallecido->caption() ?><?= $Page->nombre_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_nombre_fallecido">
<input type="<?= $Page->nombre_fallecido->getInputTextType() ?>" name="x_nombre_fallecido" id="x_nombre_fallecido" data-table="sco_expediente" data-field="x_nombre_fallecido" value="<?= $Page->nombre_fallecido->EditValue ?>" data-page="2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_fallecido->formatPattern()) ?>"<?= $Page->nombre_fallecido->editAttributes() ?> aria-describedby="x_nombre_fallecido_help">
<?= $Page->nombre_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <div id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_apellidos_fallecido" for="x_apellidos_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos_fallecido->caption() ?><?= $Page->apellidos_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_apellidos_fallecido">
<input type="<?= $Page->apellidos_fallecido->getInputTextType() ?>" name="x_apellidos_fallecido" id="x_apellidos_fallecido" data-table="sco_expediente" data-field="x_apellidos_fallecido" value="<?= $Page->apellidos_fallecido->EditValue ?>" data-page="2" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->apellidos_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellidos_fallecido->formatPattern()) ?>"<?= $Page->apellidos_fallecido->editAttributes() ?> aria-describedby="x_apellidos_fallecido_help">
<?= $Page->apellidos_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
    <div id="r_sexo"<?= $Page->sexo->rowAttributes() ?>>
        <label id="elh_sco_expediente_sexo" for="x_sexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sexo->caption() ?><?= $Page->sexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sexo->cellAttributes() ?>>
<span id="el_sco_expediente_sexo">
    <select
        id="x_sexo"
        name="x_sexo"
        class="form-select ew-select<?= $Page->sexo->isInvalidClass() ?>"
        <?php if (!$Page->sexo->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_sexo"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_sexo"
        data-page="2"
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
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_sexo", selectId: "fsco_expedienteadd_x_sexo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.sexo?.lookupOptions.length) {
        options.data = { id: "x_sexo", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_sexo", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.sexo.selectOptions);
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
        <label id="elh_sco_expediente_fecha_nacimiento" for="x_fecha_nacimiento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_nacimiento->caption() ?><?= $Page->fecha_nacimiento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_nacimiento">
<input type="<?= $Page->fecha_nacimiento->getInputTextType() ?>" name="x_fecha_nacimiento" id="x_fecha_nacimiento" data-table="sco_expediente" data-field="x_fecha_nacimiento" value="<?= $Page->fecha_nacimiento->EditValue ?>" data-page="2" placeholder="<?= HtmlEncode($Page->fecha_nacimiento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_nacimiento->formatPattern()) ?>"<?= $Page->fecha_nacimiento->editAttributes() ?> aria-describedby="x_fecha_nacimiento_help">
<?= $Page->fecha_nacimiento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_nacimiento->getErrorMessage() ?></div>
<?php if (!$Page->fecha_nacimiento->ReadOnly && !$Page->fecha_nacimiento->Disabled && !isset($Page->fecha_nacimiento->EditAttrs["readonly"]) && !isset($Page->fecha_nacimiento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expedienteadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expedienteadd", "x_fecha_nacimiento", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
    <div id="r_religion"<?= $Page->religion->rowAttributes() ?>>
        <label id="elh_sco_expediente_religion" for="x_religion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->religion->caption() ?><?= $Page->religion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->religion->cellAttributes() ?>>
<span id="el_sco_expediente_religion">
    <select
        id="x_religion"
        name="x_religion"
        class="form-select ew-select<?= $Page->religion->isInvalidClass() ?>"
        <?php if (!$Page->religion->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_religion"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_religion"
        data-page="2"
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
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_religion", selectId: "fsco_expedienteadd_x_religion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.religion?.lookupOptions.length) {
        options.data = { id: "x_religion", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_religion", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.religion.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
    <div id="r_peso"<?= $Page->peso->rowAttributes() ?>>
        <label id="elh_sco_expediente_peso" for="x_peso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->peso->caption() ?><?= $Page->peso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->peso->cellAttributes() ?>>
<span id="el_sco_expediente_peso">
    <select
        id="x_peso"
        name="x_peso"
        class="form-select ew-select<?= $Page->peso->isInvalidClass() ?>"
        <?php if (!$Page->peso->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_peso"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_peso"
        data-page="2"
        data-value-separator="<?= $Page->peso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->peso->getPlaceHolder()) ?>"
        <?= $Page->peso->editAttributes() ?>>
        <?= $Page->peso->selectOptionListHtml("x_peso") ?>
    </select>
    <?= $Page->peso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->peso->getErrorMessage() ?></div>
<?= $Page->peso->Lookup->getParamTag($Page, "p_x_peso") ?>
<?php if (!$Page->peso->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_peso", selectId: "fsco_expedienteadd_x_peso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.peso?.lookupOptions.length) {
        options.data = { id: "x_peso", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_peso", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.peso.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_sco_expediente3" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
    <div id="r_lugar_ocurrencia"<?= $Page->lugar_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_lugar_ocurrencia" for="x_lugar_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lugar_ocurrencia->caption() ?><?= $Page->lugar_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_lugar_ocurrencia">
    <select
        id="x_lugar_ocurrencia"
        name="x_lugar_ocurrencia"
        class="form-select ew-select<?= $Page->lugar_ocurrencia->isInvalidClass() ?>"
        <?php if (!$Page->lugar_ocurrencia->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_lugar_ocurrencia"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_lugar_ocurrencia"
        data-page="3"
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
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_lugar_ocurrencia", selectId: "fsco_expedienteadd_x_lugar_ocurrencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.lugar_ocurrencia?.lookupOptions.length) {
        options.data = { id: "x_lugar_ocurrencia", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_lugar_ocurrencia", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.lugar_ocurrencia.selectOptions);
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
        <label id="elh_sco_expediente_direccion_ocurrencia" for="x_direccion_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion_ocurrencia->caption() ?><?= $Page->direccion_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_direccion_ocurrencia">
<textarea data-table="sco_expediente" data-field="x_direccion_ocurrencia" data-page="3" name="x_direccion_ocurrencia" id="x_direccion_ocurrencia" cols="30" rows="4" placeholder="<?= HtmlEncode($Page->direccion_ocurrencia->getPlaceHolder()) ?>"<?= $Page->direccion_ocurrencia->editAttributes() ?> aria-describedby="x_direccion_ocurrencia_help"><?= $Page->direccion_ocurrencia->EditValue ?></textarea>
<?= $Page->direccion_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion_ocurrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
    <div id="r_fecha_ocurrencia"<?= $Page->fecha_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_fecha_ocurrencia" for="x_fecha_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_ocurrencia->caption() ?><?= $Page->fecha_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_ocurrencia">
<input type="<?= $Page->fecha_ocurrencia->getInputTextType() ?>" name="x_fecha_ocurrencia" id="x_fecha_ocurrencia" data-table="sco_expediente" data-field="x_fecha_ocurrencia" value="<?= $Page->fecha_ocurrencia->EditValue ?>" data-page="3" placeholder="<?= HtmlEncode($Page->fecha_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_ocurrencia->formatPattern()) ?>"<?= $Page->fecha_ocurrencia->editAttributes() ?> aria-describedby="x_fecha_ocurrencia_help">
<?= $Page->fecha_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_ocurrencia->getErrorMessage() ?></div>
<?php if (!$Page->fecha_ocurrencia->ReadOnly && !$Page->fecha_ocurrencia->Disabled && !isset($Page->fecha_ocurrencia->EditAttrs["readonly"]) && !isset($Page->fecha_ocurrencia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expedienteadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expedienteadd", "x_fecha_ocurrencia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <div id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_causa_ocurrencia" for="x_causa_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_ocurrencia->caption() ?><?= $Page->causa_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_causa_ocurrencia">
    <select
        id="x_causa_ocurrencia"
        name="x_causa_ocurrencia"
        class="form-control ew-select<?= $Page->causa_ocurrencia->isInvalidClass() ?>"
        data-select2-id="fsco_expedienteadd_x_causa_ocurrencia"
        data-table="sco_expediente"
        data-field="x_causa_ocurrencia"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->causa_ocurrencia->caption())) ?>"
        data-modal-lookup="true"
        data-page="3"
        data-value-separator="<?= $Page->causa_ocurrencia->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->causa_ocurrencia->getPlaceHolder()) ?>"
        <?= $Page->causa_ocurrencia->editAttributes() ?>>
        <?= $Page->causa_ocurrencia->selectOptionListHtml("x_causa_ocurrencia") ?>
    </select>
    <?= $Page->causa_ocurrencia->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->causa_ocurrencia->getErrorMessage() ?></div>
<?= $Page->causa_ocurrencia->Lookup->getParamTag($Page, "p_x_causa_ocurrencia") ?>
<script>
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_causa_ocurrencia", selectId: "fsco_expedienteadd_x_causa_ocurrencia" };
    if (fsco_expedienteadd.lists.causa_ocurrencia?.lookupOptions.length) {
        options.data = { id: "x_causa_ocurrencia", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_causa_ocurrencia", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_expediente.fields.causa_ocurrencia.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
    <div id="r_causa_otro"<?= $Page->causa_otro->rowAttributes() ?>>
        <label id="elh_sco_expediente_causa_otro" for="x_causa_otro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_otro->caption() ?><?= $Page->causa_otro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el_sco_expediente_causa_otro">
<input type="<?= $Page->causa_otro->getInputTextType() ?>" name="x_causa_otro" id="x_causa_otro" data-table="sco_expediente" data-field="x_causa_otro" value="<?= $Page->causa_otro->EditValue ?>" data-page="3" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->causa_otro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->causa_otro->formatPattern()) ?>"<?= $Page->causa_otro->editAttributes() ?> aria-describedby="x_causa_otro_help">
<?= $Page->causa_otro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->causa_otro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(4) ?>" id="tab_sco_expediente4" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->permiso->Visible) { // permiso ?>
    <div id="r_permiso"<?= $Page->permiso->rowAttributes() ?>>
        <label id="elh_sco_expediente_permiso" for="x_permiso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->permiso->caption() ?><?= $Page->permiso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->permiso->cellAttributes() ?>>
<span id="el_sco_expediente_permiso">
<input type="<?= $Page->permiso->getInputTextType() ?>" name="x_permiso" id="x_permiso" data-table="sco_expediente" data-field="x_permiso" value="<?= $Page->permiso->EditValue ?>" data-page="4" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->permiso->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->permiso->formatPattern()) ?>"<?= $Page->permiso->editAttributes() ?> aria-describedby="x_permiso_help">
<?= $Page->permiso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->permiso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_expediente_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_nota">
<textarea data-table="sco_expediente" data-field="x_nota" data-page="4" name="x_nota" id="x_nota" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <div id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <label id="elh_sco_expediente_funeraria" for="x_funeraria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funeraria->caption() ?><?= $Page->funeraria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_expediente_funeraria">
    <select
        id="x_funeraria"
        name="x_funeraria"
        class="form-select ew-select<?= $Page->funeraria->isInvalidClass() ?>"
        <?php if (!$Page->funeraria->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_funeraria"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_funeraria"
        data-page="4"
        data-value-separator="<?= $Page->funeraria->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->funeraria->getPlaceHolder()) ?>"
        <?= $Page->funeraria->editAttributes() ?>>
        <?= $Page->funeraria->selectOptionListHtml("x_funeraria") ?>
    </select>
    <?= $Page->funeraria->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->funeraria->getErrorMessage() ?></div>
<?php if (!$Page->funeraria->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_funeraria", selectId: "fsco_expedienteadd_x_funeraria" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.funeraria?.lookupOptions.length) {
        options.data = { id: "x_funeraria", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_funeraria", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.funeraria.selectOptions);
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
        <label id="elh_sco_expediente_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_expediente_servicio_tipo">
    <select
        id="x_servicio_tipo"
        name="x_servicio_tipo"
        class="form-select ew-select<?= $Page->servicio_tipo->isInvalidClass() ?>"
        <?php if (!$Page->servicio_tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_servicio_tipo"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_servicio_tipo"
        data-page="4"
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
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_servicio_tipo", selectId: "fsco_expedienteadd_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.servicio_tipo.selectOptions);
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
        <label id="elh_sco_expediente_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_expediente_servicio">
    <select
        id="x_servicio"
        name="x_servicio"
        class="form-select ew-select<?= $Page->servicio->isInvalidClass() ?>"
        <?php if (!$Page->servicio->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_servicio"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_servicio"
        data-page="4"
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
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_servicio", selectId: "fsco_expedienteadd_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_servicio", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
    <div id="r_marca_pasos"<?= $Page->marca_pasos->rowAttributes() ?>>
        <label id="elh_sco_expediente_marca_pasos" for="x_marca_pasos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marca_pasos->caption() ?><?= $Page->marca_pasos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marca_pasos->cellAttributes() ?>>
<span id="el_sco_expediente_marca_pasos">
    <select
        id="x_marca_pasos"
        name="x_marca_pasos"
        class="form-select ew-select<?= $Page->marca_pasos->isInvalidClass() ?>"
        <?php if (!$Page->marca_pasos->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteadd_x_marca_pasos"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_marca_pasos"
        data-page="4"
        data-value-separator="<?= $Page->marca_pasos->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->marca_pasos->getPlaceHolder()) ?>"
        <?= $Page->marca_pasos->editAttributes() ?>>
        <?= $Page->marca_pasos->selectOptionListHtml("x_marca_pasos") ?>
    </select>
    <?= $Page->marca_pasos->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->marca_pasos->getErrorMessage() ?></div>
<?php if (!$Page->marca_pasos->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expedienteadd", function() {
    var options = { name: "x_marca_pasos", selectId: "fsco_expedienteadd_x_marca_pasos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteadd.lists.marca_pasos?.lookupOptions.length) {
        options.data = { id: "x_marca_pasos", form: "fsco_expedienteadd" };
    } else {
        options.ajax = { id: "x_marca_pasos", form: "fsco_expedienteadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.marca_pasos.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
    <div id="r_certificado_defuncion"<?= $Page->certificado_defuncion->rowAttributes() ?>>
        <label id="elh_sco_expediente_certificado_defuncion" for="x_certificado_defuncion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->certificado_defuncion->caption() ?><?= $Page->certificado_defuncion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="el_sco_expediente_certificado_defuncion">
<input type="<?= $Page->certificado_defuncion->getInputTextType() ?>" name="x_certificado_defuncion" id="x_certificado_defuncion" data-table="sco_expediente" data-field="x_certificado_defuncion" value="<?= $Page->certificado_defuncion->EditValue ?>" data-page="4" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->certificado_defuncion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->certificado_defuncion->formatPattern()) ?>"<?= $Page->certificado_defuncion->editAttributes() ?> aria-describedby="x_certificado_defuncion_help">
<?= $Page->certificado_defuncion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->certificado_defuncion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?php
    if (in_array("sco_orden", explode(",", $Page->getCurrentDetailTable())) && $sco_orden->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_orden", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOrdenGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_seguimiento", explode(",", $Page->getCurrentDetailTable())) && $sco_seguimiento->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_seguimiento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoSeguimientoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_estatus->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteEstatusGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_cremacion_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_cremacion_estatus->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_cremacion_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoCremacionEstatusGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_parcela", explode(",", $Page->getCurrentDetailTable())) && $sco_parcela->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_parcela", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoParcelaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_encuesta_calidad", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_encuesta_calidad->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_encuesta_calidad", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteEncuestaCalidadGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_cia", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_cia->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_cia", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteCiaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_embalaje", explode(",", $Page->getCurrentDetailTable())) && $sco_embalaje->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_embalaje", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoEmbalajeGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_reembolso", explode(",", $Page->getCurrentDetailTable())) && $sco_reembolso->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_reembolso", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoReembolsoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_nota->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expedienteadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expedienteadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_expediente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#r_causa_otro").hide();
    $(document).ready(function(){
    	$("#r_causa_ocurrencia").bind("change", function() {
    		if($("#x_causa_ocurrencia").val() == "OTRO")
    			$("#r_causa_otro").show();
    		else {
    			$("#r_causa_otro").hide();
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

    /* Comento esta rutina para poder utilizar la Nueva rutina para la búsqueda de parcelas 
    // Se busca si el cliente tiene parcela buscando por CI o CTTO
    $("#x_contrato_parcela").change(function(){
    	$.ajax({
    		url: "dashboard/buscar_parcela.php",
    		dataType:"html",
    		type: "post",
    		data: {'ci': this.value},
    		success: function(data){
    		   // dt = data.split("|");
    		   dt = data;
    		   $('#parcela').html(dt);
    		}
    	});
    });
    */

    // Nueva rutina para la búsqueda de parcelas
    //$("#r_parcela").hide();
    $('#x_parcela').prop('readonly', true);
    $("#x_modulo").prop('disabled', true);
    $("#x_subseccion").prop('disabled', true);
    $("#y_parcela").prop('disabled', true);
    $("#y_contrato_parcela").prop('disabled', true);
    $("#y_parcela").prop('disabled', true);
    if($("#x_modulo").val() != "") $("#x_modulo").prop('disabled', false);
    if($("#x_subseccion").val() != "") $("#x_subseccion").prop('disabled', false);
    if($("#y_parcela").val() != "") $("#y_parcela").prop('disabled', false);
    if($("#x_contrato_parcela").val() != "") $("#x_contrato_parcela").prop('disabled', false);
    $("#x_seccion").change(function(){
    	if($("#x_seccion").val() != "") $("#x_modulo").prop('disabled', false);
    	document.getElementById("x_modulo").focus();
    	$("#x_modulo").val("");
    	$("#x_subseccion").val("");
    	$("#y_parcela").val("");
    })
    $("#x_modulo").change(function(){
    	if($("#x_modulo").val() != "") $("#x_subseccion").prop('disabled', false);
    	document.getElementById("x_subseccion").focus();
    	$("#x_subseccion").val("");
    	$("#y_parcela").val("");
    })
    $("#x_subseccion").change(function(){
    	if($("#x_subseccion").val() != "") $("#y_parcela").prop('disabled', false);
    	document.getElementById("y_parcela").focus();
    	$("#y_parcela").val("");
    })
    $("#y_parcela").change(function(){
    	if($("#y_parcela").val() != "") {
            var seccion = $("#x_seccion").val();
            var modulo = $("#x_modulo").val();
            var subseccion = $("#x_subseccion").val();
            var parcela = $("#y_parcela").val();
            var buscar = "contrato";
            $.ajax({
            url : "BuscarParcelaVc",
            type: "GET",
            data : {seccion: seccion, modulo: modulo, subseccion: subseccion, parcela: parcela, buscar: buscar},
            beforeSend: function(){
                //$("#result").html("Espere. . . ");
            }
            })
            .done(function(data) {
                var content = $(data).find('#outtext').text();
                // alert(content);

    			//console.log(content);
    			var rsl = content.split("|");
    			if(rsl[0]!="itemnotfound") {
    				//alert("Data: " + rsl[0] + " - " + rsl[1] + "\nStatus: " + status);
    				$("#x_contrato_parcela").val(rsl[0]);
    				$("#x_nombre_contacto").val(rsl[1]);
    				$("#x_parcela").val($("#x_seccion").val().trim() + "-" + $("#x_modulo").val().trim() + "-" + $("#x_subseccion").val().trim() + "-" + $("#y_parcela").val().trim());
    				document.getElementById("x_seguro").focus();
    				$("#x_contrato_parcela").prop('disabled', false);
    				$("#y_parcela").prop('disabled', false);
    			}
    			else {
    				alert("Parcela no encontrada, !!! Verifique !!!.");
    				$("#x_seccion").val("");
    				$("#x_modulo").val("");
    				$("#x_subseccion").val("");
    				$("#y_parcela").val("");
    				$("#x_modulo").prop('disabled', true);
    				$("#x_subseccion").prop('disabled', true);
    				$("#y_parcela").prop('disabled', true);
    				$("#x_contrato_parcela").val("");
    				$("#x_parcela").val("");
    				$("#x_nombre_contacto").val("");
    				$("#x_contrato_parcela").prop('disabled', true);
    				$("#y_parcela").prop('disabled', true);
    				document.getElementById("x_seccion").focus();
    			}
            })
            .fail(function(data) {
                alert( "error" + data );
            })
            .always(function(data) {
                //alert( "complete" );
                //$("#result").html("Espere. . . ");
            }); 
        }
    })
});
</script>
