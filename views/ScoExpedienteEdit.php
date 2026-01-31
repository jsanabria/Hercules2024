<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fsco_expedienteedit" id="fsco_expedienteedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_expedienteedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expedienteedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nexpediente", [fields.Nexpediente.visible && fields.Nexpediente.required ? ew.Validators.required(fields.Nexpediente.caption) : null], fields.Nexpediente.isInvalid],
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
            ["edad_fallecido", [fields.edad_fallecido.visible && fields.edad_fallecido.required ? ew.Validators.required(fields.edad_fallecido.caption) : null], fields.edad_fallecido.isInvalid],
            ["lugar_ocurrencia", [fields.lugar_ocurrencia.visible && fields.lugar_ocurrencia.required ? ew.Validators.required(fields.lugar_ocurrencia.caption) : null], fields.lugar_ocurrencia.isInvalid],
            ["direccion_ocurrencia", [fields.direccion_ocurrencia.visible && fields.direccion_ocurrencia.required ? ew.Validators.required(fields.direccion_ocurrencia.caption) : null], fields.direccion_ocurrencia.isInvalid],
            ["fecha_ocurrencia", [fields.fecha_ocurrencia.visible && fields.fecha_ocurrencia.required ? ew.Validators.required(fields.fecha_ocurrencia.caption) : null, ew.Validators.datetime(fields.fecha_ocurrencia.clientFormatPattern)], fields.fecha_ocurrencia.isInvalid],
            ["causa_ocurrencia", [fields.causa_ocurrencia.visible && fields.causa_ocurrencia.required ? ew.Validators.required(fields.causa_ocurrencia.caption) : null], fields.causa_ocurrencia.isInvalid],
            ["causa_otro", [fields.causa_otro.visible && fields.causa_otro.required ? ew.Validators.required(fields.causa_otro.caption) : null], fields.causa_otro.isInvalid],
            ["religion", [fields.religion.visible && fields.religion.required ? ew.Validators.required(fields.religion.caption) : null], fields.religion.isInvalid],
            ["permiso", [fields.permiso.visible && fields.permiso.required ? ew.Validators.required(fields.permiso.caption) : null], fields.permiso.isInvalid],
            ["costos", [fields.costos.visible && fields.costos.required ? ew.Validators.required(fields.costos.caption) : null], fields.costos.isInvalid],
            ["venta", [fields.venta.visible && fields.venta.required ? ew.Validators.required(fields.venta.caption) : null], fields.venta.isInvalid],
            ["factura", [fields.factura.visible && fields.factura.required ? ew.Validators.required(fields.factura.caption) : null], fields.factura.isInvalid],
            ["unir_con_expediente", [fields.unir_con_expediente.visible && fields.unir_con_expediente.required ? ew.Validators.required(fields.unir_con_expediente.caption) : null], fields.unir_con_expediente.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null], fields.funeraria.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["marca_pasos", [fields.marca_pasos.visible && fields.marca_pasos.required ? ew.Validators.required(fields.marca_pasos.caption) : null], fields.marca_pasos.isInvalid],
            ["peso", [fields.peso.visible && fields.peso.required ? ew.Validators.required(fields.peso.caption) : null], fields.peso.isInvalid],
            ["autoriza_cremar", [fields.autoriza_cremar.visible && fields.autoriza_cremar.required ? ew.Validators.required(fields.autoriza_cremar.caption) : null], fields.autoriza_cremar.isInvalid],
            ["certificado_defuncion", [fields.certificado_defuncion.visible && fields.certificado_defuncion.required ? ew.Validators.required(fields.certificado_defuncion.caption) : null], fields.certificado_defuncion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["username_autoriza", [fields.username_autoriza.visible && fields.username_autoriza.required ? ew.Validators.required(fields.username_autoriza.caption) : null], fields.username_autoriza.isInvalid],
            ["fecha_autoriza", [fields.fecha_autoriza.visible && fields.fecha_autoriza.required ? ew.Validators.required(fields.fecha_autoriza.caption) : null], fields.fecha_autoriza.isInvalid]
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
            "unir_con_expediente": <?= $Page->unir_con_expediente->toClientList($Page) ?>,
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
            "funeraria": <?= $Page->funeraria->toClientList($Page) ?>,
            "servicio_tipo": <?= $Page->servicio_tipo->toClientList($Page) ?>,
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
            "marca_pasos": <?= $Page->marca_pasos->toClientList($Page) ?>,
            "peso": <?= $Page->peso->toClientList($Page) ?>,
            "autoriza_cremar": <?= $Page->autoriza_cremar->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    // Write your table-specific client script here, no need to add script tags.
    window.limpiarParcela = function() {
        // 1. Limpiar valores
        $("#x_seccion, #x_modulo, #x_subseccion, #y_parcela, #x_contrato_parcela, #x_nombre_contacto, #x_parcela").val("");

        // 2. Bloquear campos dependientes
        $("#x_modulo, #x_subseccion, #y_parcela").prop('disabled', true);

        // 3. Quitar clases de error si las hubiera y dar foco
        $("#x_seccion").prop('disabled', false).focus();
        $("#loading-parcela").hide();
        console.log("Campos de parcela reiniciados"); // Para verificar en consola
    };
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_ScoExpedienteEdit"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_sco_expediente1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_sco_expediente2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_sco_expediente3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(4) ?>" data-bs-target="#tab_sco_expediente4" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_expediente4" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(4)) ?>"><?= $Page->pageCaption(4) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_sco_expediente1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
    <div id="r_Nexpediente"<?= $Page->Nexpediente->rowAttributes() ?>>
        <label id="elh_sco_expediente_Nexpediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nexpediente->caption() ?><?= $Page->Nexpediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="el_sco_expediente_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nexpediente->getDisplayValue($Page->Nexpediente->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente" data-field="x_Nexpediente" data-hidden="1" data-page="1" name="x_Nexpediente" id="x_Nexpediente" value="<?= HtmlEncode($Page->Nexpediente->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
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
        data-select2-id="fsco_expedienteedit_x_seguro"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_seguro", selectId: "fsco_expedienteedit_x_seguro" };
    if (fsco_expedienteedit.lists.seguro?.lookupOptions.length) {
        options.data = { id: "x_seguro", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_seguro", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_expedienteedit_x_parentesco_contacto"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_parentesco_contacto", selectId: "fsco_expedienteedit_x_parentesco_contacto" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.parentesco_contacto?.lookupOptions.length) {
        options.data = { id: "x_parentesco_contacto", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_parentesco_contacto", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
<div class="ew-edit-div"><!-- page* -->
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
        data-select2-id="fsco_expedienteedit_x_sexo"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_sexo", selectId: "fsco_expedienteedit_x_sexo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.sexo?.lookupOptions.length) {
        options.data = { id: "x_sexo", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_sexo", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
loadjs.ready(["fsco_expedienteedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expedienteedit", "x_fecha_nacimiento", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
    <div id="r_edad_fallecido"<?= $Page->edad_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_edad_fallecido" for="x_edad_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->edad_fallecido->caption() ?><?= $Page->edad_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_edad_fallecido">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->edad_fallecido->getDisplayValue($Page->edad_fallecido->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente" data-field="x_edad_fallecido" data-hidden="1" data-page="2" name="x_edad_fallecido" id="x_edad_fallecido" value="<?= HtmlEncode($Page->edad_fallecido->CurrentValue) ?>">
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
        data-select2-id="fsco_expedienteedit_x_religion"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_religion", selectId: "fsco_expedienteedit_x_religion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.religion?.lookupOptions.length) {
        options.data = { id: "x_religion", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_religion", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_expedienteedit_x_peso"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_peso", selectId: "fsco_expedienteedit_x_peso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.peso?.lookupOptions.length) {
        options.data = { id: "x_peso", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_peso", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
<div class="ew-edit-div"><!-- page* -->
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
        data-select2-id="fsco_expedienteedit_x_lugar_ocurrencia"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_lugar_ocurrencia", selectId: "fsco_expedienteedit_x_lugar_ocurrencia" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.lugar_ocurrencia?.lookupOptions.length) {
        options.data = { id: "x_lugar_ocurrencia", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_lugar_ocurrencia", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
loadjs.ready(["fsco_expedienteedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expedienteedit", "x_fecha_ocurrencia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
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
        data-select2-id="fsco_expedienteedit_x_causa_ocurrencia"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_causa_ocurrencia", selectId: "fsco_expedienteedit_x_causa_ocurrencia" };
    if (fsco_expedienteedit.lists.causa_ocurrencia?.lookupOptions.length) {
        options.data = { id: "x_causa_ocurrencia", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_causa_ocurrencia", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
<div class="ew-edit-div"><!-- page* -->
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
<?php if ($Page->costos->Visible) { // costos ?>
    <div id="r_costos"<?= $Page->costos->rowAttributes() ?>>
        <label id="elh_sco_expediente_costos" for="x_costos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costos->caption() ?><?= $Page->costos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costos->cellAttributes() ?>>
<span id="el_sco_expediente_costos">
<span<?= $Page->costos->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->costos->getDisplayValue($Page->costos->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente" data-field="x_costos" data-hidden="1" data-page="4" name="x_costos" id="x_costos" value="<?= HtmlEncode($Page->costos->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
    <div id="r_venta"<?= $Page->venta->rowAttributes() ?>>
        <label id="elh_sco_expediente_venta" for="x_venta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->venta->caption() ?><?= $Page->venta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->venta->cellAttributes() ?>>
<span id="el_sco_expediente_venta">
<span<?= $Page->venta->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->venta->getDisplayValue($Page->venta->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente" data-field="x_venta" data-hidden="1" data-page="4" name="x_venta" id="x_venta" value="<?= HtmlEncode($Page->venta->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <div id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <label id="elh_sco_expediente_factura" for="x_factura" class="<?= $Page->LeftColumnClass ?>"><?= $Page->factura->caption() ?><?= $Page->factura->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->factura->cellAttributes() ?>>
<span id="el_sco_expediente_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->factura->getDisplayValue($Page->factura->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente" data-field="x_factura" data-hidden="1" data-page="4" name="x_factura" id="x_factura" value="<?= HtmlEncode($Page->factura->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
    <div id="r_unir_con_expediente"<?= $Page->unir_con_expediente->rowAttributes() ?>>
        <label id="elh_sco_expediente_unir_con_expediente" for="x_unir_con_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unir_con_expediente->caption() ?><?= $Page->unir_con_expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unir_con_expediente->cellAttributes() ?>>
<span id="el_sco_expediente_unir_con_expediente">
    <select
        id="x_unir_con_expediente"
        name="x_unir_con_expediente"
        class="form-select ew-select<?= $Page->unir_con_expediente->isInvalidClass() ?>"
        <?php if (!$Page->unir_con_expediente->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteedit_x_unir_con_expediente"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_unir_con_expediente"
        data-page="4"
        data-value-separator="<?= $Page->unir_con_expediente->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->unir_con_expediente->getPlaceHolder()) ?>"
        <?= $Page->unir_con_expediente->editAttributes() ?>>
        <?= $Page->unir_con_expediente->selectOptionListHtml("x_unir_con_expediente") ?>
    </select>
    <?= $Page->unir_con_expediente->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->unir_con_expediente->getErrorMessage() ?></div>
<?= $Page->unir_con_expediente->Lookup->getParamTag($Page, "p_x_unir_con_expediente") ?>
<?php if (!$Page->unir_con_expediente->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_unir_con_expediente", selectId: "fsco_expedienteedit_x_unir_con_expediente" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.unir_con_expediente?.lookupOptions.length) {
        options.data = { id: "x_unir_con_expediente", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_unir_con_expediente", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.unir_con_expediente.selectOptions);
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
        <label id="elh_sco_expediente_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteedit_x_estatus"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_estatus"
        data-page="4"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?= $Page->estatus->Lookup->getParamTag($Page, "p_x_estatus") ?>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_expedienteedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
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
        data-select2-id="fsco_expedienteedit_x_funeraria"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_funeraria", selectId: "fsco_expedienteedit_x_funeraria" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.funeraria?.lookupOptions.length) {
        options.data = { id: "x_funeraria", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_funeraria", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_expedienteedit_x_servicio_tipo"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_servicio_tipo", selectId: "fsco_expedienteedit_x_servicio_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.servicio_tipo?.lookupOptions.length) {
        options.data = { id: "x_servicio_tipo", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_servicio_tipo", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_expedienteedit_x_servicio"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_servicio", selectId: "fsco_expedienteedit_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_servicio", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
        data-select2-id="fsco_expedienteedit_x_marca_pasos"
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
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_marca_pasos", selectId: "fsco_expedienteedit_x_marca_pasos" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.marca_pasos?.lookupOptions.length) {
        options.data = { id: "x_marca_pasos", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_marca_pasos", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
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
<?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
    <div id="r_autoriza_cremar"<?= $Page->autoriza_cremar->rowAttributes() ?>>
        <label id="elh_sco_expediente_autoriza_cremar" for="x_autoriza_cremar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->autoriza_cremar->caption() ?><?= $Page->autoriza_cremar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->autoriza_cremar->cellAttributes() ?>>
<span id="el_sco_expediente_autoriza_cremar">
    <select
        id="x_autoriza_cremar"
        name="x_autoriza_cremar"
        class="form-select ew-select<?= $Page->autoriza_cremar->isInvalidClass() ?>"
        <?php if (!$Page->autoriza_cremar->IsNativeSelect) { ?>
        data-select2-id="fsco_expedienteedit_x_autoriza_cremar"
        <?php } ?>
        data-table="sco_expediente"
        data-field="x_autoriza_cremar"
        data-page="4"
        data-value-separator="<?= $Page->autoriza_cremar->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->autoriza_cremar->getPlaceHolder()) ?>"
        <?= $Page->autoriza_cremar->editAttributes() ?>>
        <?= $Page->autoriza_cremar->selectOptionListHtml("x_autoriza_cremar") ?>
    </select>
    <?= $Page->autoriza_cremar->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->autoriza_cremar->getErrorMessage() ?></div>
<?php if (!$Page->autoriza_cremar->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_expedienteedit", function() {
    var options = { name: "x_autoriza_cremar", selectId: "fsco_expedienteedit_x_autoriza_cremar" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_expedienteedit.lists.autoriza_cremar?.lookupOptions.length) {
        options.data = { id: "x_autoriza_cremar", form: "fsco_expedienteedit" };
    } else {
        options.ajax = { id: "x_autoriza_cremar", form: "fsco_expedienteedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_expediente.fields.autoriza_cremar.selectOptions);
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
<?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
    <div id="r_username_autoriza"<?= $Page->username_autoriza->rowAttributes() ?>>
        <label id="elh_sco_expediente_username_autoriza" class="<?= $Page->LeftColumnClass ?>"><?= $Page->username_autoriza->caption() ?><?= $Page->username_autoriza->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->username_autoriza->cellAttributes() ?>>
<span id="el_sco_expediente_username_autoriza">
<span<?= $Page->username_autoriza->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->username_autoriza->getDisplayValue($Page->username_autoriza->EditValue) ?></span></span>
<input type="hidden" data-table="sco_expediente" data-field="x_username_autoriza" data-hidden="1" data-page="4" name="x_username_autoriza" id="x_username_autoriza" value="<?= HtmlEncode($Page->username_autoriza->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
    <div id="r_fecha_autoriza"<?= $Page->fecha_autoriza->rowAttributes() ?>>
        <label id="elh_sco_expediente_fecha_autoriza" for="x_fecha_autoriza" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_autoriza->caption() ?><?= $Page->fecha_autoriza->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_autoriza->cellAttributes() ?>>
<span id="el_sco_expediente_fecha_autoriza">
<span<?= $Page->fecha_autoriza->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha_autoriza->getDisplayValue($Page->fecha_autoriza->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_expediente" data-field="x_fecha_autoriza" data-hidden="1" data-page="4" name="x_fecha_autoriza" id="x_fecha_autoriza" value="<?= HtmlEncode($Page->fecha_autoriza->CurrentValue) ?>">
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
    if (in_array("sco_orden", explode(",", $Page->getCurrentDetailTable())) && $sco_orden->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_orden", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOrdenGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_seguimiento", explode(",", $Page->getCurrentDetailTable())) && $sco_seguimiento->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_seguimiento", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoSeguimientoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_estatus->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteEstatusGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_adjunto->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoAdjuntoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_cremacion_estatus", explode(",", $Page->getCurrentDetailTable())) && $sco_cremacion_estatus->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_cremacion_estatus", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoCremacionEstatusGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_parcela", explode(",", $Page->getCurrentDetailTable())) && $sco_parcela->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_parcela", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoParcelaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_encuesta_calidad", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_encuesta_calidad->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_encuesta_calidad", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteEncuestaCalidadGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_expediente_cia", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_cia->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_cia", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteCiaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_embalaje", explode(",", $Page->getCurrentDetailTable())) && $sco_embalaje->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_embalaje", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoEmbalajeGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_reembolso", explode(",", $Page->getCurrentDetailTable())) && $sco_reembolso->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_reembolso", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoReembolsoGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_nota->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoNotaGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expedienteedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expedienteedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
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
    if($("#x_causa_ocurrencia").val() == "OTRO")
    	$("#r_causa_otro").show();
    else
    	$("#r_causa_otro").hide();
    $(document).ready(function(){
    	$("#x_causa_ocurrencia").bind("change", function() {
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
    		ew.alert("Este campo no puede estar vacio");
    		xBad = false;
    	}else if($("#x_cedula_fallecido").val().length < 7) {
    		ew.alert("Este campo debe ser mayor a 6 caracteres");
    		xBad = false;
    	}else if($("#x_cedula_fallecido").val().length > 12) {
    		ew.alert("Este campo debe ser menor a 12 caracteres");
    		xBad = false;
    	}else if($("#x_cedula_fallecido").val().substring(0,2) != "V-" && $("#x_cedula_fallecido").val().substring(0,2) != "E-" && $("#x_cedula_fallecido").val().substring(0,2) != "M-") {
    		ew.alert("La CI debe comenzar con (V-) Venezolano o con (E-) Extranjero o con (M-) Menor de edad sin poseer CI.");
    		xBad = false;
    	}else if(isNaN($("#x_cedula_fallecido").val().substring(2,$("#x_cedula_fallecido").val().length))) {
    		ew.alert("La CI debe ser un valor entero");
    		xBad = false;
    	}
    	if(xBad == false) {
    		$("#x_cedula_fallecido").val("");
    		return false;
    	}
    });

    // Se busca si el cliente tiene parcela buscando por CI o CTTO
    /*$("#x_contrato_parcela").change(function(){
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
    });*/

    // 1. Configuración Inicial
    $('#x_parcela').prop('readonly', true);

    // 2. Desglose de la parcela actual (si existe valor)
    if ($("#x_parcela").val() !== "") {
        var arr = $("#x_parcela").val().split("-");
        if (arr.length === 4) {
            $("#x_seccion").val(arr[0]);
            $("#x_modulo").val(arr[1]);
            $("#x_subseccion").val(arr[2]);
            $("#y_parcela").val(arr[3]);
        }
    }

    // 3. Función Global Limpiar (Asegúrate de tenerla una sola vez)
    window.limpiarParcela = function() {
        $("#x_seccion, #x_modulo, #x_subseccion, #y_parcela, #x_contrato_parcela, #x_nombre_contacto, #x_parcela").val("");
        $("#x_modulo, #x_subseccion, #y_parcela").prop('disabled', true);
        $("#x_seccion").prop('disabled', false).focus();
        $("#loading-parcela").hide().removeClass("text-success text-danger").addClass("text-primary");
    };

    // 4. Lógica de habilitación inicial
    $("#x_modulo").prop('disabled', $("#x_seccion").val() === "");
    $("#x_subseccion").prop('disabled', $("#x_modulo").val() === "");
    $("#y_parcela").prop('disabled', $("#x_subseccion").val() === "");

    // 5. Flujo de navegación entre campos
    $("#x_seccion").change(function() {
        if ($(this).val()) {
            $("#x_modulo").prop('disabled', false).focus();
            $("#x_modulo, #x_subseccion, #y_parcela").val("");
        }
    });
    $("#x_modulo").change(function() {
        if ($(this).val()) {
            $("#x_subseccion").prop('disabled', false).focus();
            $("#x_subseccion, #y_parcela").val("");
        }
    });
    $("#x_subseccion").change(function() {
        if ($(this).val()) {
            $("#y_parcela").prop('disabled', false).focus();
            $("#y_parcela").val("");
        }
    });

    // 6. Búsqueda AJAX con Spinner Inteligente
    $("#y_parcela").change(function() {
        var params = {
            seccion: $("#x_seccion").val(),
            modulo: $("#x_modulo").val(),
            subseccion: $("#x_subseccion").val(),
            parcela: $("#y_parcela").val(),
            buscar: "contrato"
        };
        if (params.parcela !== "") {
            $.ajax({
                url: "../BuscarParcelaVc",
                type: "GET",
                data: params,
                dataType: "json", // Cambiado de HTML a JSON
                beforeSend: function() {
                    $("#loading-parcela")
                        .removeClass("text-success text-danger")
                        .addClass("text-primary")
                        .show();
                }
            })
            .done(function(res) {
                if (res.status === "success") {
                    // ÉXITO: Spinner a Verde
                    $("#loading-parcela").removeClass("text-primary").addClass("text-success");
                    $("#x_contrato_parcela").val(res.item1).prop('disabled', false);
                    $("#x_nombre_contacto").val(res.item2);
                    var fullPath = params.seccion + "-" + params.modulo + "-" + params.subseccion + "-" + params.parcela;
                    $("#x_parcela").val(fullPath.toUpperCase());
                    setTimeout(function() {
                        $("#loading-parcela").fadeOut();
                        $("#x_seguro").focus();
                    }, 800);
                } else {
                    // ERROR: Spinner a Rojo
                    $("#loading-parcela").removeClass("text-primary").addClass("text-danger");
                    setTimeout(function() {
                        ew.alert("Parcela no encontrada, !!! Verifique !!!.");
                        limpiarParcela();
                    }, 500);
                }
            })
            .fail(function(err) {
                $("#loading-parcela").removeClass("text-primary").addClass("text-danger");
                ew.alert("Error de conexión al buscar parcela.");
            });
        }
    });
});
</script>
