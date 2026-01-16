<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteOldDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_old: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_expediente_olddelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_olddelete")
        .setPageId("delete")
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
<form name="fsco_expediente_olddelete" id="fsco_expediente_olddelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente_old">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid <?= $Page->TableGridClass ?>">
<div class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<table class="<?= $Page->TableClass ?>">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <th class="<?= $Page->Nexpediente->headerCellClass() ?>"><span id="elh_sco_expediente_old_Nexpediente" class="sco_expediente_old_Nexpediente"><?= $Page->Nexpediente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
        <th class="<?= $Page->tipo_contratacion->headerCellClass() ?>"><span id="elh_sco_expediente_old_tipo_contratacion" class="sco_expediente_old_tipo_contratacion"><?= $Page->tipo_contratacion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
        <th class="<?= $Page->seguro->headerCellClass() ?>"><span id="elh_sco_expediente_old_seguro" class="sco_expediente_old_seguro"><?= $Page->seguro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nacionalidad_contacto->Visible) { // nacionalidad_contacto ?>
        <th class="<?= $Page->nacionalidad_contacto->headerCellClass() ?>"><span id="elh_sco_expediente_old_nacionalidad_contacto" class="sco_expediente_old_nacionalidad_contacto"><?= $Page->nacionalidad_contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cedula_contacto->Visible) { // cedula_contacto ?>
        <th class="<?= $Page->cedula_contacto->headerCellClass() ?>"><span id="elh_sco_expediente_old_cedula_contacto" class="sco_expediente_old_cedula_contacto"><?= $Page->cedula_contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <th class="<?= $Page->nombre_contacto->headerCellClass() ?>"><span id="elh_sco_expediente_old_nombre_contacto" class="sco_expediente_old_nombre_contacto"><?= $Page->nombre_contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellidos_contacto->Visible) { // apellidos_contacto ?>
        <th class="<?= $Page->apellidos_contacto->headerCellClass() ?>"><span id="elh_sco_expediente_old_apellidos_contacto" class="sco_expediente_old_apellidos_contacto"><?= $Page->apellidos_contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
        <th class="<?= $Page->parentesco_contacto->headerCellClass() ?>"><span id="elh_sco_expediente_old_parentesco_contacto" class="sco_expediente_old_parentesco_contacto"><?= $Page->parentesco_contacto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
        <th class="<?= $Page->telefono_contacto1->headerCellClass() ?>"><span id="elh_sco_expediente_old_telefono_contacto1" class="sco_expediente_old_telefono_contacto1"><?= $Page->telefono_contacto1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
        <th class="<?= $Page->telefono_contacto2->headerCellClass() ?>"><span id="elh_sco_expediente_old_telefono_contacto2" class="sco_expediente_old_telefono_contacto2"><?= $Page->telefono_contacto2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nacionalidad_fallecido->Visible) { // nacionalidad_fallecido ?>
        <th class="<?= $Page->nacionalidad_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_old_nacionalidad_fallecido" class="sco_expediente_old_nacionalidad_fallecido"><?= $Page->nacionalidad_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_old_cedula_fallecido" class="sco_expediente_old_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
        <th class="<?= $Page->sexo->headerCellClass() ?>"><span id="elh_sco_expediente_old_sexo" class="sco_expediente_old_sexo"><?= $Page->sexo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_old_nombre_fallecido" class="sco_expediente_old_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_old_apellidos_fallecido" class="sco_expediente_old_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
        <th class="<?= $Page->fecha_nacimiento->headerCellClass() ?>"><span id="elh_sco_expediente_old_fecha_nacimiento" class="sco_expediente_old_fecha_nacimiento"><?= $Page->fecha_nacimiento->caption() ?></span></th>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
        <th class="<?= $Page->edad_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_old_edad_fallecido" class="sco_expediente_old_edad_fallecido"><?= $Page->edad_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estado_civil->Visible) { // estado_civil ?>
        <th class="<?= $Page->estado_civil->headerCellClass() ?>"><span id="elh_sco_expediente_old_estado_civil" class="sco_expediente_old_estado_civil"><?= $Page->estado_civil->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lugar_nacimiento_fallecido->Visible) { // lugar_nacimiento_fallecido ?>
        <th class="<?= $Page->lugar_nacimiento_fallecido->headerCellClass() ?>"><span id="elh_sco_expediente_old_lugar_nacimiento_fallecido" class="sco_expediente_old_lugar_nacimiento_fallecido"><?= $Page->lugar_nacimiento_fallecido->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
        <th class="<?= $Page->lugar_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_old_lugar_ocurrencia" class="sco_expediente_old_lugar_ocurrencia"><?= $Page->lugar_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
        <th class="<?= $Page->direccion_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_old_direccion_ocurrencia" class="sco_expediente_old_direccion_ocurrencia"><?= $Page->direccion_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
        <th class="<?= $Page->fecha_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_old_fecha_ocurrencia" class="sco_expediente_old_fecha_ocurrencia"><?= $Page->fecha_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hora_ocurrencia->Visible) { // hora_ocurrencia ?>
        <th class="<?= $Page->hora_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_old_hora_ocurrencia" class="sco_expediente_old_hora_ocurrencia"><?= $Page->hora_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <th class="<?= $Page->causa_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_old_causa_ocurrencia" class="sco_expediente_old_causa_ocurrencia"><?= $Page->causa_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
        <th class="<?= $Page->causa_otro->headerCellClass() ?>"><span id="elh_sco_expediente_old_causa_otro" class="sco_expediente_old_causa_otro"><?= $Page->causa_otro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion_ocurrencia->Visible) { // descripcion_ocurrencia ?>
        <th class="<?= $Page->descripcion_ocurrencia->headerCellClass() ?>"><span id="elh_sco_expediente_old_descripcion_ocurrencia" class="sco_expediente_old_descripcion_ocurrencia"><?= $Page->descripcion_ocurrencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->calidad->Visible) { // calidad ?>
        <th class="<?= $Page->calidad->headerCellClass() ?>"><span id="elh_sco_expediente_old_calidad" class="sco_expediente_old_calidad"><?= $Page->calidad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->costos->Visible) { // costos ?>
        <th class="<?= $Page->costos->headerCellClass() ?>"><span id="elh_sco_expediente_old_costos" class="sco_expediente_old_costos"><?= $Page->costos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
        <th class="<?= $Page->venta->headerCellClass() ?>"><span id="elh_sco_expediente_old_venta" class="sco_expediente_old_venta"><?= $Page->venta->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <th class="<?= $Page->user_registra->headerCellClass() ?>"><span id="elh_sco_expediente_old_user_registra" class="sco_expediente_old_user_registra"><?= $Page->user_registra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_expediente_old_fecha_registro" class="sco_expediente_old_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user_cierra->Visible) { // user_cierra ?>
        <th class="<?= $Page->user_cierra->headerCellClass() ?>"><span id="elh_sco_expediente_old_user_cierra" class="sco_expediente_old_user_cierra"><?= $Page->user_cierra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
        <th class="<?= $Page->fecha_cierre->headerCellClass() ?>"><span id="elh_sco_expediente_old_fecha_cierre" class="sco_expediente_old_fecha_cierre"><?= $Page->fecha_cierre->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_expediente_old_estatus" class="sco_expediente_old_estatus"><?= $Page->estatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <th class="<?= $Page->factura->headerCellClass() ?>"><span id="elh_sco_expediente_old_factura" class="sco_expediente_old_factura"><?= $Page->factura->caption() ?></span></th>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
        <th class="<?= $Page->permiso->headerCellClass() ?>"><span id="elh_sco_expediente_old_permiso" class="sco_expediente_old_permiso"><?= $Page->permiso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
        <th class="<?= $Page->unir_con_expediente->headerCellClass() ?>"><span id="elh_sco_expediente_old_unir_con_expediente" class="sco_expediente_old_unir_con_expediente"><?= $Page->unir_con_expediente->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
        <th class="<?= $Page->nota->headerCellClass() ?>"><span id="elh_sco_expediente_old_nota" class="sco_expediente_old_nota"><?= $Page->nota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_sco_expediente_old__email" class="sco_expediente_old__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
        <th class="<?= $Page->religion->headerCellClass() ?>"><span id="elh_sco_expediente_old_religion" class="sco_expediente_old_religion"><?= $Page->religion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><span id="elh_sco_expediente_old_servicio_tipo" class="sco_expediente_old_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th class="<?= $Page->servicio->headerCellClass() ?>"><span id="elh_sco_expediente_old_servicio" class="sco_expediente_old_servicio"><?= $Page->servicio->caption() ?></span></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th class="<?= $Page->funeraria->headerCellClass() ?>"><span id="elh_sco_expediente_old_funeraria" class="sco_expediente_old_funeraria"><?= $Page->funeraria->caption() ?></span></th>
<?php } ?>
<?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
        <th class="<?= $Page->marca_pasos->headerCellClass() ?>"><span id="elh_sco_expediente_old_marca_pasos" class="sco_expediente_old_marca_pasos"><?= $Page->marca_pasos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
        <th class="<?= $Page->autoriza_cremar->headerCellClass() ?>"><span id="elh_sco_expediente_old_autoriza_cremar" class="sco_expediente_old_autoriza_cremar"><?= $Page->autoriza_cremar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
        <th class="<?= $Page->username_autoriza->headerCellClass() ?>"><span id="elh_sco_expediente_old_username_autoriza" class="sco_expediente_old_username_autoriza"><?= $Page->username_autoriza->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
        <th class="<?= $Page->fecha_autoriza->headerCellClass() ?>"><span id="elh_sco_expediente_old_fecha_autoriza" class="sco_expediente_old_fecha_autoriza"><?= $Page->fecha_autoriza->caption() ?></span></th>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
        <th class="<?= $Page->peso->headerCellClass() ?>"><span id="elh_sco_expediente_old_peso" class="sco_expediente_old_peso"><?= $Page->peso->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
        <th class="<?= $Page->contrato_parcela->headerCellClass() ?>"><span id="elh_sco_expediente_old_contrato_parcela" class="sco_expediente_old_contrato_parcela"><?= $Page->contrato_parcela->caption() ?></span></th>
<?php } ?>
<?php if ($Page->email_calidad->Visible) { // email_calidad ?>
        <th class="<?= $Page->email_calidad->headerCellClass() ?>"><span id="elh_sco_expediente_old_email_calidad" class="sco_expediente_old_email_calidad"><?= $Page->email_calidad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
        <th class="<?= $Page->certificado_defuncion->headerCellClass() ?>"><span id="elh_sco_expediente_old_certificado_defuncion" class="sco_expediente_old_certificado_defuncion"><?= $Page->certificado_defuncion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th class="<?= $Page->parcela->headerCellClass() ?>"><span id="elh_sco_expediente_old_parcela" class="sco_expediente_old_parcela"><?= $Page->parcela->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while ($Page->fetch()) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = RowType::VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->CurrentRow);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <td<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?= $Page->Nexpediente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
        <td<?= $Page->tipo_contratacion->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo_contratacion->viewAttributes() ?>>
<?= $Page->tipo_contratacion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
        <td<?= $Page->seguro->cellAttributes() ?>>
<span id="">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nacionalidad_contacto->Visible) { // nacionalidad_contacto ?>
        <td<?= $Page->nacionalidad_contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->nacionalidad_contacto->viewAttributes() ?>>
<?= $Page->nacionalidad_contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cedula_contacto->Visible) { // cedula_contacto ?>
        <td<?= $Page->cedula_contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->cedula_contacto->viewAttributes() ?>>
<?= $Page->cedula_contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
        <td<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellidos_contacto->Visible) { // apellidos_contacto ?>
        <td<?= $Page->apellidos_contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->apellidos_contacto->viewAttributes() ?>>
<?= $Page->apellidos_contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
        <td<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="">
<span<?= $Page->parentesco_contacto->viewAttributes() ?>>
<?= $Page->parentesco_contacto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
        <td<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="">
<span<?= $Page->telefono_contacto1->viewAttributes() ?>>
<?= $Page->telefono_contacto1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
        <td<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="">
<span<?= $Page->telefono_contacto2->viewAttributes() ?>>
<?= $Page->telefono_contacto2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nacionalidad_fallecido->Visible) { // nacionalidad_fallecido ?>
        <td<?= $Page->nacionalidad_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->nacionalidad_fallecido->viewAttributes() ?>>
<?= $Page->nacionalidad_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
        <td<?= $Page->sexo->cellAttributes() ?>>
<span id="">
<span<?= $Page->sexo->viewAttributes() ?>>
<?= $Page->sexo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
        <td<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_nacimiento->viewAttributes() ?>>
<?= $Page->fecha_nacimiento->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
        <td<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<?= $Page->edad_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estado_civil->Visible) { // estado_civil ?>
        <td<?= $Page->estado_civil->cellAttributes() ?>>
<span id="">
<span<?= $Page->estado_civil->viewAttributes() ?>>
<?= $Page->estado_civil->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lugar_nacimiento_fallecido->Visible) { // lugar_nacimiento_fallecido ?>
        <td<?= $Page->lugar_nacimiento_fallecido->cellAttributes() ?>>
<span id="">
<span<?= $Page->lugar_nacimiento_fallecido->viewAttributes() ?>>
<?= $Page->lugar_nacimiento_fallecido->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
        <td<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->lugar_ocurrencia->viewAttributes() ?>>
<?= $Page->lugar_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
        <td<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->direccion_ocurrencia->viewAttributes() ?>>
<?= $Page->direccion_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
        <td<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_ocurrencia->viewAttributes() ?>>
<?= $Page->fecha_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hora_ocurrencia->Visible) { // hora_ocurrencia ?>
        <td<?= $Page->hora_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->hora_ocurrencia->viewAttributes() ?>>
<?= $Page->hora_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
        <td<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
        <td<?= $Page->causa_otro->cellAttributes() ?>>
<span id="">
<span<?= $Page->causa_otro->viewAttributes() ?>>
<?= $Page->causa_otro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descripcion_ocurrencia->Visible) { // descripcion_ocurrencia ?>
        <td<?= $Page->descripcion_ocurrencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion_ocurrencia->viewAttributes() ?>>
<?= $Page->descripcion_ocurrencia->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->calidad->Visible) { // calidad ?>
        <td<?= $Page->calidad->cellAttributes() ?>>
<span id="">
<span<?= $Page->calidad->viewAttributes() ?>>
<?= $Page->calidad->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->costos->Visible) { // costos ?>
        <td<?= $Page->costos->cellAttributes() ?>>
<span id="">
<span<?= $Page->costos->viewAttributes() ?>>
<?= $Page->costos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
        <td<?= $Page->venta->cellAttributes() ?>>
<span id="">
<span<?= $Page->venta->viewAttributes() ?>>
<?= $Page->venta->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <td<?= $Page->user_registra->cellAttributes() ?>>
<span id="">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <td<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user_cierra->Visible) { // user_cierra ?>
        <td<?= $Page->user_cierra->cellAttributes() ?>>
<span id="">
<span<?= $Page->user_cierra->viewAttributes() ?>>
<?= $Page->user_cierra->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
        <td<?= $Page->fecha_cierre->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_cierre->viewAttributes() ?>>
<?= $Page->fecha_cierre->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <td<?= $Page->estatus->cellAttributes() ?>>
<span id="">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <td<?= $Page->factura->cellAttributes() ?>>
<span id="">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
        <td<?= $Page->permiso->cellAttributes() ?>>
<span id="">
<span<?= $Page->permiso->viewAttributes() ?>>
<?= $Page->permiso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
        <td<?= $Page->unir_con_expediente->cellAttributes() ?>>
<span id="">
<span<?= $Page->unir_con_expediente->viewAttributes() ?>>
<?= $Page->unir_con_expediente->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
        <td<?= $Page->nota->cellAttributes() ?>>
<span id="">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td<?= $Page->_email->cellAttributes() ?>>
<span id="">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
        <td<?= $Page->religion->cellAttributes() ?>>
<span id="">
<span<?= $Page->religion->viewAttributes() ?>>
<?= $Page->religion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <td<?= $Page->servicio->cellAttributes() ?>>
<span id="">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <td<?= $Page->funeraria->cellAttributes() ?>>
<span id="">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
        <td<?= $Page->marca_pasos->cellAttributes() ?>>
<span id="">
<span<?= $Page->marca_pasos->viewAttributes() ?>>
<?= $Page->marca_pasos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
        <td<?= $Page->autoriza_cremar->cellAttributes() ?>>
<span id="">
<span<?= $Page->autoriza_cremar->viewAttributes() ?>>
<?= $Page->autoriza_cremar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
        <td<?= $Page->username_autoriza->cellAttributes() ?>>
<span id="">
<span<?= $Page->username_autoriza->viewAttributes() ?>>
<?= $Page->username_autoriza->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
        <td<?= $Page->fecha_autoriza->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_autoriza->viewAttributes() ?>>
<?= $Page->fecha_autoriza->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
        <td<?= $Page->peso->cellAttributes() ?>>
<span id="">
<span<?= $Page->peso->viewAttributes() ?>>
<?= $Page->peso->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
        <td<?= $Page->contrato_parcela->cellAttributes() ?>>
<span id="">
<span<?= $Page->contrato_parcela->viewAttributes() ?>>
<?= $Page->contrato_parcela->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->email_calidad->Visible) { // email_calidad ?>
        <td<?= $Page->email_calidad->cellAttributes() ?>>
<span id="">
<span<?= $Page->email_calidad->viewAttributes() ?>>
<?= $Page->email_calidad->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
        <td<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="">
<span<?= $Page->certificado_defuncion->viewAttributes() ?>>
<?= $Page->certificado_defuncion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <td<?= $Page->parcela->cellAttributes() ?>>
<span id="">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
}
$Page->Recordset?->free();
?>
</tbody>
</table>
</div>
</div>
<div class="ew-buttons ew-desktop-buttons">
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
