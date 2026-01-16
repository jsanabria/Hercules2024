<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteOldAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_old: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_expediente_oldadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_oldadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["tipo_contratacion", [fields.tipo_contratacion.visible && fields.tipo_contratacion.required ? ew.Validators.required(fields.tipo_contratacion.caption) : null], fields.tipo_contratacion.isInvalid],
            ["seguro", [fields.seguro.visible && fields.seguro.required ? ew.Validators.required(fields.seguro.caption) : null, ew.Validators.integer], fields.seguro.isInvalid],
            ["nacionalidad_contacto", [fields.nacionalidad_contacto.visible && fields.nacionalidad_contacto.required ? ew.Validators.required(fields.nacionalidad_contacto.caption) : null], fields.nacionalidad_contacto.isInvalid],
            ["cedula_contacto", [fields.cedula_contacto.visible && fields.cedula_contacto.required ? ew.Validators.required(fields.cedula_contacto.caption) : null], fields.cedula_contacto.isInvalid],
            ["nombre_contacto", [fields.nombre_contacto.visible && fields.nombre_contacto.required ? ew.Validators.required(fields.nombre_contacto.caption) : null], fields.nombre_contacto.isInvalid],
            ["apellidos_contacto", [fields.apellidos_contacto.visible && fields.apellidos_contacto.required ? ew.Validators.required(fields.apellidos_contacto.caption) : null], fields.apellidos_contacto.isInvalid],
            ["parentesco_contacto", [fields.parentesco_contacto.visible && fields.parentesco_contacto.required ? ew.Validators.required(fields.parentesco_contacto.caption) : null], fields.parentesco_contacto.isInvalid],
            ["telefono_contacto1", [fields.telefono_contacto1.visible && fields.telefono_contacto1.required ? ew.Validators.required(fields.telefono_contacto1.caption) : null], fields.telefono_contacto1.isInvalid],
            ["telefono_contacto2", [fields.telefono_contacto2.visible && fields.telefono_contacto2.required ? ew.Validators.required(fields.telefono_contacto2.caption) : null], fields.telefono_contacto2.isInvalid],
            ["nacionalidad_fallecido", [fields.nacionalidad_fallecido.visible && fields.nacionalidad_fallecido.required ? ew.Validators.required(fields.nacionalidad_fallecido.caption) : null], fields.nacionalidad_fallecido.isInvalid],
            ["cedula_fallecido", [fields.cedula_fallecido.visible && fields.cedula_fallecido.required ? ew.Validators.required(fields.cedula_fallecido.caption) : null], fields.cedula_fallecido.isInvalid],
            ["sexo", [fields.sexo.visible && fields.sexo.required ? ew.Validators.required(fields.sexo.caption) : null], fields.sexo.isInvalid],
            ["nombre_fallecido", [fields.nombre_fallecido.visible && fields.nombre_fallecido.required ? ew.Validators.required(fields.nombre_fallecido.caption) : null], fields.nombre_fallecido.isInvalid],
            ["apellidos_fallecido", [fields.apellidos_fallecido.visible && fields.apellidos_fallecido.required ? ew.Validators.required(fields.apellidos_fallecido.caption) : null], fields.apellidos_fallecido.isInvalid],
            ["fecha_nacimiento", [fields.fecha_nacimiento.visible && fields.fecha_nacimiento.required ? ew.Validators.required(fields.fecha_nacimiento.caption) : null, ew.Validators.datetime(fields.fecha_nacimiento.clientFormatPattern)], fields.fecha_nacimiento.isInvalid],
            ["edad_fallecido", [fields.edad_fallecido.visible && fields.edad_fallecido.required ? ew.Validators.required(fields.edad_fallecido.caption) : null, ew.Validators.integer], fields.edad_fallecido.isInvalid],
            ["estado_civil", [fields.estado_civil.visible && fields.estado_civil.required ? ew.Validators.required(fields.estado_civil.caption) : null], fields.estado_civil.isInvalid],
            ["lugar_nacimiento_fallecido", [fields.lugar_nacimiento_fallecido.visible && fields.lugar_nacimiento_fallecido.required ? ew.Validators.required(fields.lugar_nacimiento_fallecido.caption) : null], fields.lugar_nacimiento_fallecido.isInvalid],
            ["lugar_ocurrencia", [fields.lugar_ocurrencia.visible && fields.lugar_ocurrencia.required ? ew.Validators.required(fields.lugar_ocurrencia.caption) : null], fields.lugar_ocurrencia.isInvalid],
            ["direccion_ocurrencia", [fields.direccion_ocurrencia.visible && fields.direccion_ocurrencia.required ? ew.Validators.required(fields.direccion_ocurrencia.caption) : null], fields.direccion_ocurrencia.isInvalid],
            ["fecha_ocurrencia", [fields.fecha_ocurrencia.visible && fields.fecha_ocurrencia.required ? ew.Validators.required(fields.fecha_ocurrencia.caption) : null, ew.Validators.datetime(fields.fecha_ocurrencia.clientFormatPattern)], fields.fecha_ocurrencia.isInvalid],
            ["hora_ocurrencia", [fields.hora_ocurrencia.visible && fields.hora_ocurrencia.required ? ew.Validators.required(fields.hora_ocurrencia.caption) : null, ew.Validators.time(fields.hora_ocurrencia.clientFormatPattern)], fields.hora_ocurrencia.isInvalid],
            ["causa_ocurrencia", [fields.causa_ocurrencia.visible && fields.causa_ocurrencia.required ? ew.Validators.required(fields.causa_ocurrencia.caption) : null], fields.causa_ocurrencia.isInvalid],
            ["causa_otro", [fields.causa_otro.visible && fields.causa_otro.required ? ew.Validators.required(fields.causa_otro.caption) : null], fields.causa_otro.isInvalid],
            ["descripcion_ocurrencia", [fields.descripcion_ocurrencia.visible && fields.descripcion_ocurrencia.required ? ew.Validators.required(fields.descripcion_ocurrencia.caption) : null], fields.descripcion_ocurrencia.isInvalid],
            ["calidad", [fields.calidad.visible && fields.calidad.required ? ew.Validators.required(fields.calidad.caption) : null], fields.calidad.isInvalid],
            ["costos", [fields.costos.visible && fields.costos.required ? ew.Validators.required(fields.costos.caption) : null, ew.Validators.float], fields.costos.isInvalid],
            ["venta", [fields.venta.visible && fields.venta.required ? ew.Validators.required(fields.venta.caption) : null, ew.Validators.float], fields.venta.isInvalid],
            ["user_registra", [fields.user_registra.visible && fields.user_registra.required ? ew.Validators.required(fields.user_registra.caption) : null], fields.user_registra.isInvalid],
            ["fecha_registro", [fields.fecha_registro.visible && fields.fecha_registro.required ? ew.Validators.required(fields.fecha_registro.caption) : null, ew.Validators.datetime(fields.fecha_registro.clientFormatPattern)], fields.fecha_registro.isInvalid],
            ["user_cierra", [fields.user_cierra.visible && fields.user_cierra.required ? ew.Validators.required(fields.user_cierra.caption) : null], fields.user_cierra.isInvalid],
            ["fecha_cierre", [fields.fecha_cierre.visible && fields.fecha_cierre.required ? ew.Validators.required(fields.fecha_cierre.caption) : null, ew.Validators.datetime(fields.fecha_cierre.clientFormatPattern)], fields.fecha_cierre.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null, ew.Validators.integer], fields.estatus.isInvalid],
            ["factura", [fields.factura.visible && fields.factura.required ? ew.Validators.required(fields.factura.caption) : null], fields.factura.isInvalid],
            ["permiso", [fields.permiso.visible && fields.permiso.required ? ew.Validators.required(fields.permiso.caption) : null], fields.permiso.isInvalid],
            ["unir_con_expediente", [fields.unir_con_expediente.visible && fields.unir_con_expediente.required ? ew.Validators.required(fields.unir_con_expediente.caption) : null, ew.Validators.integer], fields.unir_con_expediente.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
            ["religion", [fields.religion.visible && fields.religion.required ? ew.Validators.required(fields.religion.caption) : null], fields.religion.isInvalid],
            ["servicio_tipo", [fields.servicio_tipo.visible && fields.servicio_tipo.required ? ew.Validators.required(fields.servicio_tipo.caption) : null], fields.servicio_tipo.isInvalid],
            ["servicio", [fields.servicio.visible && fields.servicio.required ? ew.Validators.required(fields.servicio.caption) : null], fields.servicio.isInvalid],
            ["funeraria", [fields.funeraria.visible && fields.funeraria.required ? ew.Validators.required(fields.funeraria.caption) : null, ew.Validators.integer], fields.funeraria.isInvalid],
            ["marca_pasos", [fields.marca_pasos.visible && fields.marca_pasos.required ? ew.Validators.required(fields.marca_pasos.caption) : null], fields.marca_pasos.isInvalid],
            ["autoriza_cremar", [fields.autoriza_cremar.visible && fields.autoriza_cremar.required ? ew.Validators.required(fields.autoriza_cremar.caption) : null], fields.autoriza_cremar.isInvalid],
            ["username_autoriza", [fields.username_autoriza.visible && fields.username_autoriza.required ? ew.Validators.required(fields.username_autoriza.caption) : null], fields.username_autoriza.isInvalid],
            ["fecha_autoriza", [fields.fecha_autoriza.visible && fields.fecha_autoriza.required ? ew.Validators.required(fields.fecha_autoriza.caption) : null, ew.Validators.datetime(fields.fecha_autoriza.clientFormatPattern)], fields.fecha_autoriza.isInvalid],
            ["peso", [fields.peso.visible && fields.peso.required ? ew.Validators.required(fields.peso.caption) : null], fields.peso.isInvalid],
            ["contrato_parcela", [fields.contrato_parcela.visible && fields.contrato_parcela.required ? ew.Validators.required(fields.contrato_parcela.caption) : null], fields.contrato_parcela.isInvalid],
            ["email_calidad", [fields.email_calidad.visible && fields.email_calidad.required ? ew.Validators.required(fields.email_calidad.caption) : null], fields.email_calidad.isInvalid],
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

        // Dynamic selection lists
        .setLists({
            "marca_pasos": <?= $Page->marca_pasos->toClientList($Page) ?>,
            "autoriza_cremar": <?= $Page->autoriza_cremar->toClientList($Page) ?>,
            "email_calidad": <?= $Page->email_calidad->toClientList($Page) ?>,
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
<form name="fsco_expediente_oldadd" id="fsco_expediente_oldadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente_old">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
    <div id="r_tipo_contratacion"<?= $Page->tipo_contratacion->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_tipo_contratacion" for="x_tipo_contratacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_contratacion->caption() ?><?= $Page->tipo_contratacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_contratacion->cellAttributes() ?>>
<span id="el_sco_expediente_old_tipo_contratacion">
<input type="<?= $Page->tipo_contratacion->getInputTextType() ?>" name="x_tipo_contratacion" id="x_tipo_contratacion" data-table="sco_expediente_old" data-field="x_tipo_contratacion" value="<?= $Page->tipo_contratacion->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->tipo_contratacion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tipo_contratacion->formatPattern()) ?>"<?= $Page->tipo_contratacion->editAttributes() ?> aria-describedby="x_tipo_contratacion_help">
<?= $Page->tipo_contratacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tipo_contratacion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <div id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_seguro" for="x_seguro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seguro->caption() ?><?= $Page->seguro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_old_seguro">
<input type="<?= $Page->seguro->getInputTextType() ?>" name="x_seguro" id="x_seguro" data-table="sco_expediente_old" data-field="x_seguro" value="<?= $Page->seguro->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->seguro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seguro->formatPattern()) ?>"<?= $Page->seguro->editAttributes() ?> aria-describedby="x_seguro_help">
<?= $Page->seguro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seguro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nacionalidad_contacto->Visible) { // nacionalidad_contacto ?>
    <div id="r_nacionalidad_contacto"<?= $Page->nacionalidad_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_nacionalidad_contacto" for="x_nacionalidad_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nacionalidad_contacto->caption() ?><?= $Page->nacionalidad_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nacionalidad_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_nacionalidad_contacto">
<input type="<?= $Page->nacionalidad_contacto->getInputTextType() ?>" name="x_nacionalidad_contacto" id="x_nacionalidad_contacto" data-table="sco_expediente_old" data-field="x_nacionalidad_contacto" value="<?= $Page->nacionalidad_contacto->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->nacionalidad_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nacionalidad_contacto->formatPattern()) ?>"<?= $Page->nacionalidad_contacto->editAttributes() ?> aria-describedby="x_nacionalidad_contacto_help">
<?= $Page->nacionalidad_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nacionalidad_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_contacto->Visible) { // cedula_contacto ?>
    <div id="r_cedula_contacto"<?= $Page->cedula_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_cedula_contacto" for="x_cedula_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_contacto->caption() ?><?= $Page->cedula_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_cedula_contacto">
<input type="<?= $Page->cedula_contacto->getInputTextType() ?>" name="x_cedula_contacto" id="x_cedula_contacto" data-table="sco_expediente_old" data-field="x_cedula_contacto" value="<?= $Page->cedula_contacto->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_contacto->formatPattern()) ?>"<?= $Page->cedula_contacto->editAttributes() ?> aria-describedby="x_cedula_contacto_help">
<?= $Page->cedula_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
    <div id="r_nombre_contacto"<?= $Page->nombre_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_nombre_contacto" for="x_nombre_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_contacto->caption() ?><?= $Page->nombre_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_nombre_contacto">
<input type="<?= $Page->nombre_contacto->getInputTextType() ?>" name="x_nombre_contacto" id="x_nombre_contacto" data-table="sco_expediente_old" data-field="x_nombre_contacto" value="<?= $Page->nombre_contacto->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_contacto->formatPattern()) ?>"<?= $Page->nombre_contacto->editAttributes() ?> aria-describedby="x_nombre_contacto_help">
<?= $Page->nombre_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos_contacto->Visible) { // apellidos_contacto ?>
    <div id="r_apellidos_contacto"<?= $Page->apellidos_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_apellidos_contacto" for="x_apellidos_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos_contacto->caption() ?><?= $Page->apellidos_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellidos_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_apellidos_contacto">
<input type="<?= $Page->apellidos_contacto->getInputTextType() ?>" name="x_apellidos_contacto" id="x_apellidos_contacto" data-table="sco_expediente_old" data-field="x_apellidos_contacto" value="<?= $Page->apellidos_contacto->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->apellidos_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellidos_contacto->formatPattern()) ?>"<?= $Page->apellidos_contacto->editAttributes() ?> aria-describedby="x_apellidos_contacto_help">
<?= $Page->apellidos_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
    <div id="r_parentesco_contacto"<?= $Page->parentesco_contacto->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_parentesco_contacto" for="x_parentesco_contacto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parentesco_contacto->caption() ?><?= $Page->parentesco_contacto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_parentesco_contacto">
<input type="<?= $Page->parentesco_contacto->getInputTextType() ?>" name="x_parentesco_contacto" id="x_parentesco_contacto" data-table="sco_expediente_old" data-field="x_parentesco_contacto" value="<?= $Page->parentesco_contacto->EditValue ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->parentesco_contacto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parentesco_contacto->formatPattern()) ?>"<?= $Page->parentesco_contacto->editAttributes() ?> aria-describedby="x_parentesco_contacto_help">
<?= $Page->parentesco_contacto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parentesco_contacto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
    <div id="r_telefono_contacto1"<?= $Page->telefono_contacto1->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_telefono_contacto1" for="x_telefono_contacto1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_contacto1->caption() ?><?= $Page->telefono_contacto1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el_sco_expediente_old_telefono_contacto1">
<input type="<?= $Page->telefono_contacto1->getInputTextType() ?>" name="x_telefono_contacto1" id="x_telefono_contacto1" data-table="sco_expediente_old" data-field="x_telefono_contacto1" value="<?= $Page->telefono_contacto1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_contacto1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_contacto1->formatPattern()) ?>"<?= $Page->telefono_contacto1->editAttributes() ?> aria-describedby="x_telefono_contacto1_help">
<?= $Page->telefono_contacto1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_contacto1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
    <div id="r_telefono_contacto2"<?= $Page->telefono_contacto2->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_telefono_contacto2" for="x_telefono_contacto2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_contacto2->caption() ?><?= $Page->telefono_contacto2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el_sco_expediente_old_telefono_contacto2">
<input type="<?= $Page->telefono_contacto2->getInputTextType() ?>" name="x_telefono_contacto2" id="x_telefono_contacto2" data-table="sco_expediente_old" data-field="x_telefono_contacto2" value="<?= $Page->telefono_contacto2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_contacto2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_contacto2->formatPattern()) ?>"<?= $Page->telefono_contacto2->editAttributes() ?> aria-describedby="x_telefono_contacto2_help">
<?= $Page->telefono_contacto2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_contacto2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nacionalidad_fallecido->Visible) { // nacionalidad_fallecido ?>
    <div id="r_nacionalidad_fallecido"<?= $Page->nacionalidad_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_nacionalidad_fallecido" for="x_nacionalidad_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nacionalidad_fallecido->caption() ?><?= $Page->nacionalidad_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nacionalidad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_nacionalidad_fallecido">
<input type="<?= $Page->nacionalidad_fallecido->getInputTextType() ?>" name="x_nacionalidad_fallecido" id="x_nacionalidad_fallecido" data-table="sco_expediente_old" data-field="x_nacionalidad_fallecido" value="<?= $Page->nacionalidad_fallecido->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->nacionalidad_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nacionalidad_fallecido->formatPattern()) ?>"<?= $Page->nacionalidad_fallecido->editAttributes() ?> aria-describedby="x_nacionalidad_fallecido_help">
<?= $Page->nacionalidad_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nacionalidad_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <div id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_cedula_fallecido" for="x_cedula_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula_fallecido->caption() ?><?= $Page->cedula_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_cedula_fallecido">
<input type="<?= $Page->cedula_fallecido->getInputTextType() ?>" name="x_cedula_fallecido" id="x_cedula_fallecido" data-table="sco_expediente_old" data-field="x_cedula_fallecido" value="<?= $Page->cedula_fallecido->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula_fallecido->formatPattern()) ?>"<?= $Page->cedula_fallecido->editAttributes() ?> aria-describedby="x_cedula_fallecido_help">
<?= $Page->cedula_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
    <div id="r_sexo"<?= $Page->sexo->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_sexo" for="x_sexo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sexo->caption() ?><?= $Page->sexo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sexo->cellAttributes() ?>>
<span id="el_sco_expediente_old_sexo">
<input type="<?= $Page->sexo->getInputTextType() ?>" name="x_sexo" id="x_sexo" data-table="sco_expediente_old" data-field="x_sexo" value="<?= $Page->sexo->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->sexo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sexo->formatPattern()) ?>"<?= $Page->sexo->editAttributes() ?> aria-describedby="x_sexo_help">
<?= $Page->sexo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sexo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <div id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_nombre_fallecido" for="x_nombre_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre_fallecido->caption() ?><?= $Page->nombre_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_nombre_fallecido">
<input type="<?= $Page->nombre_fallecido->getInputTextType() ?>" name="x_nombre_fallecido" id="x_nombre_fallecido" data-table="sco_expediente_old" data-field="x_nombre_fallecido" value="<?= $Page->nombre_fallecido->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->nombre_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre_fallecido->formatPattern()) ?>"<?= $Page->nombre_fallecido->editAttributes() ?> aria-describedby="x_nombre_fallecido_help">
<?= $Page->nombre_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <div id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_apellidos_fallecido" for="x_apellidos_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellidos_fallecido->caption() ?><?= $Page->apellidos_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_apellidos_fallecido">
<input type="<?= $Page->apellidos_fallecido->getInputTextType() ?>" name="x_apellidos_fallecido" id="x_apellidos_fallecido" data-table="sco_expediente_old" data-field="x_apellidos_fallecido" value="<?= $Page->apellidos_fallecido->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->apellidos_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellidos_fallecido->formatPattern()) ?>"<?= $Page->apellidos_fallecido->editAttributes() ?> aria-describedby="x_apellidos_fallecido_help">
<?= $Page->apellidos_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellidos_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <div id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_fecha_nacimiento" for="x_fecha_nacimiento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_nacimiento->caption() ?><?= $Page->fecha_nacimiento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_nacimiento">
<input type="<?= $Page->fecha_nacimiento->getInputTextType() ?>" name="x_fecha_nacimiento" id="x_fecha_nacimiento" data-table="sco_expediente_old" data-field="x_fecha_nacimiento" value="<?= $Page->fecha_nacimiento->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_nacimiento->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_nacimiento->formatPattern()) ?>"<?= $Page->fecha_nacimiento->editAttributes() ?> aria-describedby="x_fecha_nacimiento_help">
<?= $Page->fecha_nacimiento->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_nacimiento->getErrorMessage() ?></div>
<?php if (!$Page->fecha_nacimiento->ReadOnly && !$Page->fecha_nacimiento->Disabled && !isset($Page->fecha_nacimiento->EditAttrs["readonly"]) && !isset($Page->fecha_nacimiento->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_oldadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expediente_oldadd", "x_fecha_nacimiento", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
    <div id="r_edad_fallecido"<?= $Page->edad_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_edad_fallecido" for="x_edad_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->edad_fallecido->caption() ?><?= $Page->edad_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_edad_fallecido">
<input type="<?= $Page->edad_fallecido->getInputTextType() ?>" name="x_edad_fallecido" id="x_edad_fallecido" data-table="sco_expediente_old" data-field="x_edad_fallecido" value="<?= $Page->edad_fallecido->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->edad_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->edad_fallecido->formatPattern()) ?>"<?= $Page->edad_fallecido->editAttributes() ?> aria-describedby="x_edad_fallecido_help">
<?= $Page->edad_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->edad_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado_civil->Visible) { // estado_civil ?>
    <div id="r_estado_civil"<?= $Page->estado_civil->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_estado_civil" for="x_estado_civil" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado_civil->caption() ?><?= $Page->estado_civil->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado_civil->cellAttributes() ?>>
<span id="el_sco_expediente_old_estado_civil">
<input type="<?= $Page->estado_civil->getInputTextType() ?>" name="x_estado_civil" id="x_estado_civil" data-table="sco_expediente_old" data-field="x_estado_civil" value="<?= $Page->estado_civil->EditValue ?>" size="30" maxlength="1" placeholder="<?= HtmlEncode($Page->estado_civil->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->estado_civil->formatPattern()) ?>"<?= $Page->estado_civil->editAttributes() ?> aria-describedby="x_estado_civil_help">
<?= $Page->estado_civil->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estado_civil->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lugar_nacimiento_fallecido->Visible) { // lugar_nacimiento_fallecido ?>
    <div id="r_lugar_nacimiento_fallecido"<?= $Page->lugar_nacimiento_fallecido->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_lugar_nacimiento_fallecido" for="x_lugar_nacimiento_fallecido" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lugar_nacimiento_fallecido->caption() ?><?= $Page->lugar_nacimiento_fallecido->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lugar_nacimiento_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_lugar_nacimiento_fallecido">
<input type="<?= $Page->lugar_nacimiento_fallecido->getInputTextType() ?>" name="x_lugar_nacimiento_fallecido" id="x_lugar_nacimiento_fallecido" data-table="sco_expediente_old" data-field="x_lugar_nacimiento_fallecido" value="<?= $Page->lugar_nacimiento_fallecido->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->lugar_nacimiento_fallecido->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->lugar_nacimiento_fallecido->formatPattern()) ?>"<?= $Page->lugar_nacimiento_fallecido->editAttributes() ?> aria-describedby="x_lugar_nacimiento_fallecido_help">
<?= $Page->lugar_nacimiento_fallecido->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lugar_nacimiento_fallecido->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
    <div id="r_lugar_ocurrencia"<?= $Page->lugar_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_lugar_ocurrencia" for="x_lugar_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lugar_ocurrencia->caption() ?><?= $Page->lugar_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_lugar_ocurrencia">
<input type="<?= $Page->lugar_ocurrencia->getInputTextType() ?>" name="x_lugar_ocurrencia" id="x_lugar_ocurrencia" data-table="sco_expediente_old" data-field="x_lugar_ocurrencia" value="<?= $Page->lugar_ocurrencia->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->lugar_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->lugar_ocurrencia->formatPattern()) ?>"<?= $Page->lugar_ocurrencia->editAttributes() ?> aria-describedby="x_lugar_ocurrencia_help">
<?= $Page->lugar_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lugar_ocurrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
    <div id="r_direccion_ocurrencia"<?= $Page->direccion_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_direccion_ocurrencia" for="x_direccion_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion_ocurrencia->caption() ?><?= $Page->direccion_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_direccion_ocurrencia">
<input type="<?= $Page->direccion_ocurrencia->getInputTextType() ?>" name="x_direccion_ocurrencia" id="x_direccion_ocurrencia" data-table="sco_expediente_old" data-field="x_direccion_ocurrencia" value="<?= $Page->direccion_ocurrencia->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->direccion_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->direccion_ocurrencia->formatPattern()) ?>"<?= $Page->direccion_ocurrencia->editAttributes() ?> aria-describedby="x_direccion_ocurrencia_help">
<?= $Page->direccion_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion_ocurrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
    <div id="r_fecha_ocurrencia"<?= $Page->fecha_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_fecha_ocurrencia" for="x_fecha_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_ocurrencia->caption() ?><?= $Page->fecha_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_ocurrencia">
<input type="<?= $Page->fecha_ocurrencia->getInputTextType() ?>" name="x_fecha_ocurrencia" id="x_fecha_ocurrencia" data-table="sco_expediente_old" data-field="x_fecha_ocurrencia" value="<?= $Page->fecha_ocurrencia->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_ocurrencia->formatPattern()) ?>"<?= $Page->fecha_ocurrencia->editAttributes() ?> aria-describedby="x_fecha_ocurrencia_help">
<?= $Page->fecha_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_ocurrencia->getErrorMessage() ?></div>
<?php if (!$Page->fecha_ocurrencia->ReadOnly && !$Page->fecha_ocurrencia->Disabled && !isset($Page->fecha_ocurrencia->EditAttrs["readonly"]) && !isset($Page->fecha_ocurrencia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_oldadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expediente_oldadd", "x_fecha_ocurrencia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_ocurrencia->Visible) { // hora_ocurrencia ?>
    <div id="r_hora_ocurrencia"<?= $Page->hora_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_hora_ocurrencia" for="x_hora_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_ocurrencia->caption() ?><?= $Page->hora_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_hora_ocurrencia">
<input type="<?= $Page->hora_ocurrencia->getInputTextType() ?>" name="x_hora_ocurrencia" id="x_hora_ocurrencia" data-table="sco_expediente_old" data-field="x_hora_ocurrencia" value="<?= $Page->hora_ocurrencia->EditValue ?>" placeholder="<?= HtmlEncode($Page->hora_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora_ocurrencia->formatPattern()) ?>"<?= $Page->hora_ocurrencia->editAttributes() ?> aria-describedby="x_hora_ocurrencia_help">
<?= $Page->hora_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora_ocurrencia->getErrorMessage() ?></div>
<?php if (!$Page->hora_ocurrencia->ReadOnly && !$Page->hora_ocurrencia->Disabled && !isset($Page->hora_ocurrencia->EditAttrs["readonly"]) && !isset($Page->hora_ocurrencia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_oldadd", "timepicker"], () => ew.createTimePicker("fsco_expediente_oldadd", "x_hora_ocurrencia", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(4) ?>" }, undefined)));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <div id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_causa_ocurrencia" for="x_causa_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_ocurrencia->caption() ?><?= $Page->causa_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_causa_ocurrencia">
<input type="<?= $Page->causa_ocurrencia->getInputTextType() ?>" name="x_causa_ocurrencia" id="x_causa_ocurrencia" data-table="sco_expediente_old" data-field="x_causa_ocurrencia" value="<?= $Page->causa_ocurrencia->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->causa_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->causa_ocurrencia->formatPattern()) ?>"<?= $Page->causa_ocurrencia->editAttributes() ?> aria-describedby="x_causa_ocurrencia_help">
<?= $Page->causa_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->causa_ocurrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
    <div id="r_causa_otro"<?= $Page->causa_otro->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_causa_otro" for="x_causa_otro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->causa_otro->caption() ?><?= $Page->causa_otro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el_sco_expediente_old_causa_otro">
<input type="<?= $Page->causa_otro->getInputTextType() ?>" name="x_causa_otro" id="x_causa_otro" data-table="sco_expediente_old" data-field="x_causa_otro" value="<?= $Page->causa_otro->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->causa_otro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->causa_otro->formatPattern()) ?>"<?= $Page->causa_otro->editAttributes() ?> aria-describedby="x_causa_otro_help">
<?= $Page->causa_otro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->causa_otro->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->descripcion_ocurrencia->Visible) { // descripcion_ocurrencia ?>
    <div id="r_descripcion_ocurrencia"<?= $Page->descripcion_ocurrencia->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_descripcion_ocurrencia" for="x_descripcion_ocurrencia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->descripcion_ocurrencia->caption() ?><?= $Page->descripcion_ocurrencia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->descripcion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_descripcion_ocurrencia">
<input type="<?= $Page->descripcion_ocurrencia->getInputTextType() ?>" name="x_descripcion_ocurrencia" id="x_descripcion_ocurrencia" data-table="sco_expediente_old" data-field="x_descripcion_ocurrencia" value="<?= $Page->descripcion_ocurrencia->EditValue ?>" size="30" maxlength="65535" placeholder="<?= HtmlEncode($Page->descripcion_ocurrencia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->descripcion_ocurrencia->formatPattern()) ?>"<?= $Page->descripcion_ocurrencia->editAttributes() ?> aria-describedby="x_descripcion_ocurrencia_help">
<?= $Page->descripcion_ocurrencia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->descripcion_ocurrencia->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->calidad->Visible) { // calidad ?>
    <div id="r_calidad"<?= $Page->calidad->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_calidad" for="x_calidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->calidad->caption() ?><?= $Page->calidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->calidad->cellAttributes() ?>>
<span id="el_sco_expediente_old_calidad">
<input type="<?= $Page->calidad->getInputTextType() ?>" name="x_calidad" id="x_calidad" data-table="sco_expediente_old" data-field="x_calidad" value="<?= $Page->calidad->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->calidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->calidad->formatPattern()) ?>"<?= $Page->calidad->editAttributes() ?> aria-describedby="x_calidad_help">
<?= $Page->calidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->calidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costos->Visible) { // costos ?>
    <div id="r_costos"<?= $Page->costos->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_costos" for="x_costos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costos->caption() ?><?= $Page->costos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costos->cellAttributes() ?>>
<span id="el_sco_expediente_old_costos">
<input type="<?= $Page->costos->getInputTextType() ?>" name="x_costos" id="x_costos" data-table="sco_expediente_old" data-field="x_costos" value="<?= $Page->costos->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->costos->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->costos->formatPattern()) ?>"<?= $Page->costos->editAttributes() ?> aria-describedby="x_costos_help">
<?= $Page->costos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->costos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
    <div id="r_venta"<?= $Page->venta->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_venta" for="x_venta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->venta->caption() ?><?= $Page->venta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->venta->cellAttributes() ?>>
<span id="el_sco_expediente_old_venta">
<input type="<?= $Page->venta->getInputTextType() ?>" name="x_venta" id="x_venta" data-table="sco_expediente_old" data-field="x_venta" value="<?= $Page->venta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->venta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->venta->formatPattern()) ?>"<?= $Page->venta->editAttributes() ?> aria-describedby="x_venta_help">
<?= $Page->venta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->venta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <div id="r_user_registra"<?= $Page->user_registra->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_user_registra" for="x_user_registra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_registra->caption() ?><?= $Page->user_registra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_registra->cellAttributes() ?>>
<span id="el_sco_expediente_old_user_registra">
<input type="<?= $Page->user_registra->getInputTextType() ?>" name="x_user_registra" id="x_user_registra" data-table="sco_expediente_old" data-field="x_user_registra" value="<?= $Page->user_registra->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_registra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->user_registra->formatPattern()) ?>"<?= $Page->user_registra->editAttributes() ?> aria-describedby="x_user_registra_help">
<?= $Page->user_registra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_registra->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <div id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_fecha_registro" for="x_fecha_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_registro->caption() ?><?= $Page->fecha_registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_registro">
<input type="<?= $Page->fecha_registro->getInputTextType() ?>" name="x_fecha_registro" id="x_fecha_registro" data-table="sco_expediente_old" data-field="x_fecha_registro" value="<?= $Page->fecha_registro->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_registro->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_registro->formatPattern()) ?>"<?= $Page->fecha_registro->editAttributes() ?> aria-describedby="x_fecha_registro_help">
<?= $Page->fecha_registro->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_registro->getErrorMessage() ?></div>
<?php if (!$Page->fecha_registro->ReadOnly && !$Page->fecha_registro->Disabled && !isset($Page->fecha_registro->EditAttrs["readonly"]) && !isset($Page->fecha_registro->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_oldadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expediente_oldadd", "x_fecha_registro", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->user_cierra->Visible) { // user_cierra ?>
    <div id="r_user_cierra"<?= $Page->user_cierra->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_user_cierra" for="x_user_cierra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->user_cierra->caption() ?><?= $Page->user_cierra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->user_cierra->cellAttributes() ?>>
<span id="el_sco_expediente_old_user_cierra">
<input type="<?= $Page->user_cierra->getInputTextType() ?>" name="x_user_cierra" id="x_user_cierra" data-table="sco_expediente_old" data-field="x_user_cierra" value="<?= $Page->user_cierra->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->user_cierra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->user_cierra->formatPattern()) ?>"<?= $Page->user_cierra->editAttributes() ?> aria-describedby="x_user_cierra_help">
<?= $Page->user_cierra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->user_cierra->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
    <div id="r_fecha_cierre"<?= $Page->fecha_cierre->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_fecha_cierre" for="x_fecha_cierre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_cierre->caption() ?><?= $Page->fecha_cierre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_cierre->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_cierre">
<input type="<?= $Page->fecha_cierre->getInputTextType() ?>" name="x_fecha_cierre" id="x_fecha_cierre" data-table="sco_expediente_old" data-field="x_fecha_cierre" value="<?= $Page->fecha_cierre->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_cierre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_cierre->formatPattern()) ?>"<?= $Page->fecha_cierre->editAttributes() ?> aria-describedby="x_fecha_cierre_help">
<?= $Page->fecha_cierre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_cierre->getErrorMessage() ?></div>
<?php if (!$Page->fecha_cierre->ReadOnly && !$Page->fecha_cierre->Disabled && !isset($Page->fecha_cierre->EditAttrs["readonly"]) && !isset($Page->fecha_cierre->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_oldadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expediente_oldadd", "x_fecha_cierre", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_old_estatus">
<input type="<?= $Page->estatus->getInputTextType() ?>" name="x_estatus" id="x_estatus" data-table="sco_expediente_old" data-field="x_estatus" value="<?= $Page->estatus->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->estatus->formatPattern()) ?>"<?= $Page->estatus->editAttributes() ?> aria-describedby="x_estatus_help">
<?= $Page->estatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <div id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_factura" for="x_factura" class="<?= $Page->LeftColumnClass ?>"><?= $Page->factura->caption() ?><?= $Page->factura->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->factura->cellAttributes() ?>>
<span id="el_sco_expediente_old_factura">
<input type="<?= $Page->factura->getInputTextType() ?>" name="x_factura" id="x_factura" data-table="sco_expediente_old" data-field="x_factura" value="<?= $Page->factura->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->factura->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->factura->formatPattern()) ?>"<?= $Page->factura->editAttributes() ?> aria-describedby="x_factura_help">
<?= $Page->factura->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->factura->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
    <div id="r_permiso"<?= $Page->permiso->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_permiso" for="x_permiso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->permiso->caption() ?><?= $Page->permiso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->permiso->cellAttributes() ?>>
<span id="el_sco_expediente_old_permiso">
<input type="<?= $Page->permiso->getInputTextType() ?>" name="x_permiso" id="x_permiso" data-table="sco_expediente_old" data-field="x_permiso" value="<?= $Page->permiso->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->permiso->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->permiso->formatPattern()) ?>"<?= $Page->permiso->editAttributes() ?> aria-describedby="x_permiso_help">
<?= $Page->permiso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->permiso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
    <div id="r_unir_con_expediente"<?= $Page->unir_con_expediente->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_unir_con_expediente" for="x_unir_con_expediente" class="<?= $Page->LeftColumnClass ?>"><?= $Page->unir_con_expediente->caption() ?><?= $Page->unir_con_expediente->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->unir_con_expediente->cellAttributes() ?>>
<span id="el_sco_expediente_old_unir_con_expediente">
<input type="<?= $Page->unir_con_expediente->getInputTextType() ?>" name="x_unir_con_expediente" id="x_unir_con_expediente" data-table="sco_expediente_old" data-field="x_unir_con_expediente" value="<?= $Page->unir_con_expediente->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->unir_con_expediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->unir_con_expediente->formatPattern()) ?>"<?= $Page->unir_con_expediente->editAttributes() ?> aria-describedby="x_unir_con_expediente_help">
<?= $Page->unir_con_expediente->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->unir_con_expediente->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_old_nota">
<input type="<?= $Page->nota->getInputTextType() ?>" name="x_nota" id="x_nota" data-table="sco_expediente_old" data-field="x_nota" value="<?= $Page->nota->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nota->formatPattern()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help">
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_expediente_old__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_expediente_old__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_expediente_old" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
    <div id="r_religion"<?= $Page->religion->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_religion" for="x_religion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->religion->caption() ?><?= $Page->religion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->religion->cellAttributes() ?>>
<span id="el_sco_expediente_old_religion">
<input type="<?= $Page->religion->getInputTextType() ?>" name="x_religion" id="x_religion" data-table="sco_expediente_old" data-field="x_religion" value="<?= $Page->religion->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->religion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->religion->formatPattern()) ?>"<?= $Page->religion->editAttributes() ?> aria-describedby="x_religion_help">
<?= $Page->religion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->religion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <div id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_servicio_tipo" for="x_servicio_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio_tipo->caption() ?><?= $Page->servicio_tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_expediente_old_servicio_tipo">
<input type="<?= $Page->servicio_tipo->getInputTextType() ?>" name="x_servicio_tipo" id="x_servicio_tipo" data-table="sco_expediente_old" data-field="x_servicio_tipo" value="<?= $Page->servicio_tipo->EditValue ?>" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->servicio_tipo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->servicio_tipo->formatPattern()) ?>"<?= $Page->servicio_tipo->editAttributes() ?> aria-describedby="x_servicio_tipo_help">
<?= $Page->servicio_tipo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->servicio_tipo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <div id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_servicio" for="x_servicio" class="<?= $Page->LeftColumnClass ?>"><?= $Page->servicio->caption() ?><?= $Page->servicio->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_expediente_old_servicio">
<input type="<?= $Page->servicio->getInputTextType() ?>" name="x_servicio" id="x_servicio" data-table="sco_expediente_old" data-field="x_servicio" value="<?= $Page->servicio->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->servicio->formatPattern()) ?>"<?= $Page->servicio->editAttributes() ?> aria-describedby="x_servicio_help">
<?= $Page->servicio->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->servicio->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <div id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_funeraria" for="x_funeraria" class="<?= $Page->LeftColumnClass ?>"><?= $Page->funeraria->caption() ?><?= $Page->funeraria->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_expediente_old_funeraria">
<input type="<?= $Page->funeraria->getInputTextType() ?>" name="x_funeraria" id="x_funeraria" data-table="sco_expediente_old" data-field="x_funeraria" value="<?= $Page->funeraria->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->funeraria->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->funeraria->formatPattern()) ?>"<?= $Page->funeraria->editAttributes() ?> aria-describedby="x_funeraria_help">
<?= $Page->funeraria->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->funeraria->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
    <div id="r_marca_pasos"<?= $Page->marca_pasos->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_marca_pasos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->marca_pasos->caption() ?><?= $Page->marca_pasos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->marca_pasos->cellAttributes() ?>>
<span id="el_sco_expediente_old_marca_pasos">
<template id="tp_x_marca_pasos">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_expediente_old" data-field="x_marca_pasos" name="x_marca_pasos" id="x_marca_pasos"<?= $Page->marca_pasos->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_marca_pasos" class="ew-item-list"></div>
<selection-list hidden
    id="x_marca_pasos"
    name="x_marca_pasos"
    value="<?= HtmlEncode($Page->marca_pasos->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_marca_pasos"
    data-target="dsl_x_marca_pasos"
    data-repeatcolumn="5"
    class="form-control<?= $Page->marca_pasos->isInvalidClass() ?>"
    data-table="sco_expediente_old"
    data-field="x_marca_pasos"
    data-value-separator="<?= $Page->marca_pasos->displayValueSeparatorAttribute() ?>"
    <?= $Page->marca_pasos->editAttributes() ?>></selection-list>
<?= $Page->marca_pasos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->marca_pasos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
    <div id="r_autoriza_cremar"<?= $Page->autoriza_cremar->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_autoriza_cremar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->autoriza_cremar->caption() ?><?= $Page->autoriza_cremar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->autoriza_cremar->cellAttributes() ?>>
<span id="el_sco_expediente_old_autoriza_cremar">
<template id="tp_x_autoriza_cremar">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_expediente_old" data-field="x_autoriza_cremar" name="x_autoriza_cremar" id="x_autoriza_cremar"<?= $Page->autoriza_cremar->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_autoriza_cremar" class="ew-item-list"></div>
<selection-list hidden
    id="x_autoriza_cremar"
    name="x_autoriza_cremar"
    value="<?= HtmlEncode($Page->autoriza_cremar->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_autoriza_cremar"
    data-target="dsl_x_autoriza_cremar"
    data-repeatcolumn="5"
    class="form-control<?= $Page->autoriza_cremar->isInvalidClass() ?>"
    data-table="sco_expediente_old"
    data-field="x_autoriza_cremar"
    data-value-separator="<?= $Page->autoriza_cremar->displayValueSeparatorAttribute() ?>"
    <?= $Page->autoriza_cremar->editAttributes() ?>></selection-list>
<?= $Page->autoriza_cremar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->autoriza_cremar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
    <div id="r_username_autoriza"<?= $Page->username_autoriza->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_username_autoriza" for="x_username_autoriza" class="<?= $Page->LeftColumnClass ?>"><?= $Page->username_autoriza->caption() ?><?= $Page->username_autoriza->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->username_autoriza->cellAttributes() ?>>
<span id="el_sco_expediente_old_username_autoriza">
<input type="<?= $Page->username_autoriza->getInputTextType() ?>" name="x_username_autoriza" id="x_username_autoriza" data-table="sco_expediente_old" data-field="x_username_autoriza" value="<?= $Page->username_autoriza->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->username_autoriza->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->username_autoriza->formatPattern()) ?>"<?= $Page->username_autoriza->editAttributes() ?> aria-describedby="x_username_autoriza_help">
<?= $Page->username_autoriza->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->username_autoriza->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
    <div id="r_fecha_autoriza"<?= $Page->fecha_autoriza->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_fecha_autoriza" for="x_fecha_autoriza" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_autoriza->caption() ?><?= $Page->fecha_autoriza->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_autoriza->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_autoriza">
<input type="<?= $Page->fecha_autoriza->getInputTextType() ?>" name="x_fecha_autoriza" id="x_fecha_autoriza" data-table="sco_expediente_old" data-field="x_fecha_autoriza" value="<?= $Page->fecha_autoriza->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_autoriza->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_autoriza->formatPattern()) ?>"<?= $Page->fecha_autoriza->editAttributes() ?> aria-describedby="x_fecha_autoriza_help">
<?= $Page->fecha_autoriza->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_autoriza->getErrorMessage() ?></div>
<?php if (!$Page->fecha_autoriza->ReadOnly && !$Page->fecha_autoriza->Disabled && !isset($Page->fecha_autoriza->EditAttrs["readonly"]) && !isset($Page->fecha_autoriza->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_expediente_oldadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_expediente_oldadd", "x_fecha_autoriza", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
    <div id="r_peso"<?= $Page->peso->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_peso" for="x_peso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->peso->caption() ?><?= $Page->peso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->peso->cellAttributes() ?>>
<span id="el_sco_expediente_old_peso">
<input type="<?= $Page->peso->getInputTextType() ?>" name="x_peso" id="x_peso" data-table="sco_expediente_old" data-field="x_peso" value="<?= $Page->peso->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->peso->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->peso->formatPattern()) ?>"<?= $Page->peso->editAttributes() ?> aria-describedby="x_peso_help">
<?= $Page->peso->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->peso->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
    <div id="r_contrato_parcela"<?= $Page->contrato_parcela->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_contrato_parcela" for="x_contrato_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato_parcela->caption() ?><?= $Page->contrato_parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato_parcela->cellAttributes() ?>>
<span id="el_sco_expediente_old_contrato_parcela">
<input type="<?= $Page->contrato_parcela->getInputTextType() ?>" name="x_contrato_parcela" id="x_contrato_parcela" data-table="sco_expediente_old" data-field="x_contrato_parcela" value="<?= $Page->contrato_parcela->EditValue ?>" size="30" maxlength="8" placeholder="<?= HtmlEncode($Page->contrato_parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->contrato_parcela->formatPattern()) ?>"<?= $Page->contrato_parcela->editAttributes() ?> aria-describedby="x_contrato_parcela_help">
<?= $Page->contrato_parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contrato_parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->email_calidad->Visible) { // email_calidad ?>
    <div id="r_email_calidad"<?= $Page->email_calidad->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_email_calidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->email_calidad->caption() ?><?= $Page->email_calidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->email_calidad->cellAttributes() ?>>
<span id="el_sco_expediente_old_email_calidad">
<template id="tp_x_email_calidad">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_expediente_old" data-field="x_email_calidad" name="x_email_calidad" id="x_email_calidad"<?= $Page->email_calidad->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_email_calidad" class="ew-item-list"></div>
<selection-list hidden
    id="x_email_calidad"
    name="x_email_calidad"
    value="<?= HtmlEncode($Page->email_calidad->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_email_calidad"
    data-target="dsl_x_email_calidad"
    data-repeatcolumn="5"
    class="form-control<?= $Page->email_calidad->isInvalidClass() ?>"
    data-table="sco_expediente_old"
    data-field="x_email_calidad"
    data-value-separator="<?= $Page->email_calidad->displayValueSeparatorAttribute() ?>"
    <?= $Page->email_calidad->editAttributes() ?>></selection-list>
<?= $Page->email_calidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->email_calidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
    <div id="r_certificado_defuncion"<?= $Page->certificado_defuncion->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_certificado_defuncion" for="x_certificado_defuncion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->certificado_defuncion->caption() ?><?= $Page->certificado_defuncion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="el_sco_expediente_old_certificado_defuncion">
<input type="<?= $Page->certificado_defuncion->getInputTextType() ?>" name="x_certificado_defuncion" id="x_certificado_defuncion" data-table="sco_expediente_old" data-field="x_certificado_defuncion" value="<?= $Page->certificado_defuncion->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->certificado_defuncion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->certificado_defuncion->formatPattern()) ?>"<?= $Page->certificado_defuncion->editAttributes() ?> aria-describedby="x_certificado_defuncion_help">
<?= $Page->certificado_defuncion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->certificado_defuncion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_expediente_old_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_expediente_old_parcela">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_expediente_old" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?> aria-describedby="x_parcela_help">
<?= $Page->parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_expediente_oldadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_expediente_oldadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_expediente_old");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
