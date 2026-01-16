<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteOldView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="view">
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
<form name="fsco_expediente_oldview" id="fsco_expediente_oldview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_old: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_expediente_oldview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_oldview")
        .setPageId("view")
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
<?php } ?>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_expediente_old">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
    <tr id="r_Nexpediente"<?= $Page->Nexpediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_Nexpediente"><?= $Page->Nexpediente->caption() ?></span></td>
        <td data-name="Nexpediente"<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="el_sco_expediente_old_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?= $Page->Nexpediente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tipo_contratacion->Visible) { // tipo_contratacion ?>
    <tr id="r_tipo_contratacion"<?= $Page->tipo_contratacion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_tipo_contratacion"><?= $Page->tipo_contratacion->caption() ?></span></td>
        <td data-name="tipo_contratacion"<?= $Page->tipo_contratacion->cellAttributes() ?>>
<span id="el_sco_expediente_old_tipo_contratacion">
<span<?= $Page->tipo_contratacion->viewAttributes() ?>>
<?= $Page->tipo_contratacion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <tr id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_seguro"><?= $Page->seguro->caption() ?></span></td>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_old_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nacionalidad_contacto->Visible) { // nacionalidad_contacto ?>
    <tr id="r_nacionalidad_contacto"<?= $Page->nacionalidad_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_nacionalidad_contacto"><?= $Page->nacionalidad_contacto->caption() ?></span></td>
        <td data-name="nacionalidad_contacto"<?= $Page->nacionalidad_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_nacionalidad_contacto">
<span<?= $Page->nacionalidad_contacto->viewAttributes() ?>>
<?= $Page->nacionalidad_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_contacto->Visible) { // cedula_contacto ?>
    <tr id="r_cedula_contacto"<?= $Page->cedula_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_cedula_contacto"><?= $Page->cedula_contacto->caption() ?></span></td>
        <td data-name="cedula_contacto"<?= $Page->cedula_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_cedula_contacto">
<span<?= $Page->cedula_contacto->viewAttributes() ?>>
<?= $Page->cedula_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
    <tr id="r_nombre_contacto"<?= $Page->nombre_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_nombre_contacto"><?= $Page->nombre_contacto->caption() ?></span></td>
        <td data-name="nombre_contacto"<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_nombre_contacto">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos_contacto->Visible) { // apellidos_contacto ?>
    <tr id="r_apellidos_contacto"<?= $Page->apellidos_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_apellidos_contacto"><?= $Page->apellidos_contacto->caption() ?></span></td>
        <td data-name="apellidos_contacto"<?= $Page->apellidos_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_apellidos_contacto">
<span<?= $Page->apellidos_contacto->viewAttributes() ?>>
<?= $Page->apellidos_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
    <tr id="r_parentesco_contacto"<?= $Page->parentesco_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_parentesco_contacto"><?= $Page->parentesco_contacto->caption() ?></span></td>
        <td data-name="parentesco_contacto"<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_old_parentesco_contacto">
<span<?= $Page->parentesco_contacto->viewAttributes() ?>>
<?= $Page->parentesco_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
    <tr id="r_telefono_contacto1"<?= $Page->telefono_contacto1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_telefono_contacto1"><?= $Page->telefono_contacto1->caption() ?></span></td>
        <td data-name="telefono_contacto1"<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el_sco_expediente_old_telefono_contacto1">
<span<?= $Page->telefono_contacto1->viewAttributes() ?>>
<?= $Page->telefono_contacto1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
    <tr id="r_telefono_contacto2"<?= $Page->telefono_contacto2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_telefono_contacto2"><?= $Page->telefono_contacto2->caption() ?></span></td>
        <td data-name="telefono_contacto2"<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el_sco_expediente_old_telefono_contacto2">
<span<?= $Page->telefono_contacto2->viewAttributes() ?>>
<?= $Page->telefono_contacto2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nacionalidad_fallecido->Visible) { // nacionalidad_fallecido ?>
    <tr id="r_nacionalidad_fallecido"<?= $Page->nacionalidad_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_nacionalidad_fallecido"><?= $Page->nacionalidad_fallecido->caption() ?></span></td>
        <td data-name="nacionalidad_fallecido"<?= $Page->nacionalidad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_nacionalidad_fallecido">
<span<?= $Page->nacionalidad_fallecido->viewAttributes() ?>>
<?= $Page->nacionalidad_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <tr id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></td>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
    <tr id="r_sexo"<?= $Page->sexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_sexo"><?= $Page->sexo->caption() ?></span></td>
        <td data-name="sexo"<?= $Page->sexo->cellAttributes() ?>>
<span id="el_sco_expediente_old_sexo">
<span<?= $Page->sexo->viewAttributes() ?>>
<?= $Page->sexo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <tr id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></td>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <tr id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></td>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <tr id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_fecha_nacimiento"><?= $Page->fecha_nacimiento->caption() ?></span></td>
        <td data-name="fecha_nacimiento"<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_nacimiento">
<span<?= $Page->fecha_nacimiento->viewAttributes() ?>>
<?= $Page->fecha_nacimiento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
    <tr id="r_edad_fallecido"<?= $Page->edad_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_edad_fallecido"><?= $Page->edad_fallecido->caption() ?></span></td>
        <td data-name="edad_fallecido"<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_edad_fallecido">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<?= $Page->edad_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estado_civil->Visible) { // estado_civil ?>
    <tr id="r_estado_civil"<?= $Page->estado_civil->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_estado_civil"><?= $Page->estado_civil->caption() ?></span></td>
        <td data-name="estado_civil"<?= $Page->estado_civil->cellAttributes() ?>>
<span id="el_sco_expediente_old_estado_civil">
<span<?= $Page->estado_civil->viewAttributes() ?>>
<?= $Page->estado_civil->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lugar_nacimiento_fallecido->Visible) { // lugar_nacimiento_fallecido ?>
    <tr id="r_lugar_nacimiento_fallecido"<?= $Page->lugar_nacimiento_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_lugar_nacimiento_fallecido"><?= $Page->lugar_nacimiento_fallecido->caption() ?></span></td>
        <td data-name="lugar_nacimiento_fallecido"<?= $Page->lugar_nacimiento_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_old_lugar_nacimiento_fallecido">
<span<?= $Page->lugar_nacimiento_fallecido->viewAttributes() ?>>
<?= $Page->lugar_nacimiento_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
    <tr id="r_lugar_ocurrencia"<?= $Page->lugar_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_lugar_ocurrencia"><?= $Page->lugar_ocurrencia->caption() ?></span></td>
        <td data-name="lugar_ocurrencia"<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_lugar_ocurrencia">
<span<?= $Page->lugar_ocurrencia->viewAttributes() ?>>
<?= $Page->lugar_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
    <tr id="r_direccion_ocurrencia"<?= $Page->direccion_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_direccion_ocurrencia"><?= $Page->direccion_ocurrencia->caption() ?></span></td>
        <td data-name="direccion_ocurrencia"<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_direccion_ocurrencia">
<span<?= $Page->direccion_ocurrencia->viewAttributes() ?>>
<?= $Page->direccion_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
    <tr id="r_fecha_ocurrencia"<?= $Page->fecha_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_fecha_ocurrencia"><?= $Page->fecha_ocurrencia->caption() ?></span></td>
        <td data-name="fecha_ocurrencia"<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_ocurrencia">
<span<?= $Page->fecha_ocurrencia->viewAttributes() ?>>
<?= $Page->fecha_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hora_ocurrencia->Visible) { // hora_ocurrencia ?>
    <tr id="r_hora_ocurrencia"<?= $Page->hora_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_hora_ocurrencia"><?= $Page->hora_ocurrencia->caption() ?></span></td>
        <td data-name="hora_ocurrencia"<?= $Page->hora_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_hora_ocurrencia">
<span<?= $Page->hora_ocurrencia->viewAttributes() ?>>
<?= $Page->hora_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <tr id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_causa_ocurrencia"><?= $Page->causa_ocurrencia->caption() ?></span></td>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
    <tr id="r_causa_otro"<?= $Page->causa_otro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_causa_otro"><?= $Page->causa_otro->caption() ?></span></td>
        <td data-name="causa_otro"<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el_sco_expediente_old_causa_otro">
<span<?= $Page->causa_otro->viewAttributes() ?>>
<?= $Page->causa_otro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->descripcion_ocurrencia->Visible) { // descripcion_ocurrencia ?>
    <tr id="r_descripcion_ocurrencia"<?= $Page->descripcion_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_descripcion_ocurrencia"><?= $Page->descripcion_ocurrencia->caption() ?></span></td>
        <td data-name="descripcion_ocurrencia"<?= $Page->descripcion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_old_descripcion_ocurrencia">
<span<?= $Page->descripcion_ocurrencia->viewAttributes() ?>>
<?= $Page->descripcion_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->calidad->Visible) { // calidad ?>
    <tr id="r_calidad"<?= $Page->calidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_calidad"><?= $Page->calidad->caption() ?></span></td>
        <td data-name="calidad"<?= $Page->calidad->cellAttributes() ?>>
<span id="el_sco_expediente_old_calidad">
<span<?= $Page->calidad->viewAttributes() ?>>
<?= $Page->calidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->costos->Visible) { // costos ?>
    <tr id="r_costos"<?= $Page->costos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_costos"><?= $Page->costos->caption() ?></span></td>
        <td data-name="costos"<?= $Page->costos->cellAttributes() ?>>
<span id="el_sco_expediente_old_costos">
<span<?= $Page->costos->viewAttributes() ?>>
<?= $Page->costos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->venta->Visible) { // venta ?>
    <tr id="r_venta"<?= $Page->venta->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_venta"><?= $Page->venta->caption() ?></span></td>
        <td data-name="venta"<?= $Page->venta->cellAttributes() ?>>
<span id="el_sco_expediente_old_venta">
<span<?= $Page->venta->viewAttributes() ?>>
<?= $Page->venta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <tr id="r_user_registra"<?= $Page->user_registra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_user_registra"><?= $Page->user_registra->caption() ?></span></td>
        <td data-name="user_registra"<?= $Page->user_registra->cellAttributes() ?>>
<span id="el_sco_expediente_old_user_registra">
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <tr id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></td>
        <td data-name="fecha_registro"<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<?= $Page->fecha_registro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user_cierra->Visible) { // user_cierra ?>
    <tr id="r_user_cierra"<?= $Page->user_cierra->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_user_cierra"><?= $Page->user_cierra->caption() ?></span></td>
        <td data-name="user_cierra"<?= $Page->user_cierra->cellAttributes() ?>>
<span id="el_sco_expediente_old_user_cierra">
<span<?= $Page->user_cierra->viewAttributes() ?>>
<?= $Page->user_cierra->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_cierre->Visible) { // fecha_cierre ?>
    <tr id="r_fecha_cierre"<?= $Page->fecha_cierre->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_fecha_cierre"><?= $Page->fecha_cierre->caption() ?></span></td>
        <td data-name="fecha_cierre"<?= $Page->fecha_cierre->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_cierre">
<span<?= $Page->fecha_cierre->viewAttributes() ?>>
<?= $Page->fecha_cierre->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_old_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <tr id="r_factura"<?= $Page->factura->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_factura"><?= $Page->factura->caption() ?></span></td>
        <td data-name="factura"<?= $Page->factura->cellAttributes() ?>>
<span id="el_sco_expediente_old_factura">
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
    <tr id="r_permiso"<?= $Page->permiso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_permiso"><?= $Page->permiso->caption() ?></span></td>
        <td data-name="permiso"<?= $Page->permiso->cellAttributes() ?>>
<span id="el_sco_expediente_old_permiso">
<span<?= $Page->permiso->viewAttributes() ?>>
<?= $Page->permiso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->unir_con_expediente->Visible) { // unir_con_expediente ?>
    <tr id="r_unir_con_expediente"<?= $Page->unir_con_expediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_unir_con_expediente"><?= $Page->unir_con_expediente->caption() ?></span></td>
        <td data-name="unir_con_expediente"<?= $Page->unir_con_expediente->cellAttributes() ?>>
<span id="el_sco_expediente_old_unir_con_expediente">
<span<?= $Page->unir_con_expediente->viewAttributes() ?>>
<?= $Page->unir_con_expediente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_old_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_expediente_old__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
    <tr id="r_religion"<?= $Page->religion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_religion"><?= $Page->religion->caption() ?></span></td>
        <td data-name="religion"<?= $Page->religion->cellAttributes() ?>>
<span id="el_sco_expediente_old_religion">
<span<?= $Page->religion->viewAttributes() ?>>
<?= $Page->religion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <tr id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></td>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_expediente_old_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <tr id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_servicio"><?= $Page->servicio->caption() ?></span></td>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_expediente_old_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <tr id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_funeraria"><?= $Page->funeraria->caption() ?></span></td>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_expediente_old_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marca_pasos->Visible) { // marca_pasos ?>
    <tr id="r_marca_pasos"<?= $Page->marca_pasos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_marca_pasos"><?= $Page->marca_pasos->caption() ?></span></td>
        <td data-name="marca_pasos"<?= $Page->marca_pasos->cellAttributes() ?>>
<span id="el_sco_expediente_old_marca_pasos">
<span<?= $Page->marca_pasos->viewAttributes() ?>>
<?= $Page->marca_pasos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->autoriza_cremar->Visible) { // autoriza_cremar ?>
    <tr id="r_autoriza_cremar"<?= $Page->autoriza_cremar->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_autoriza_cremar"><?= $Page->autoriza_cremar->caption() ?></span></td>
        <td data-name="autoriza_cremar"<?= $Page->autoriza_cremar->cellAttributes() ?>>
<span id="el_sco_expediente_old_autoriza_cremar">
<span<?= $Page->autoriza_cremar->viewAttributes() ?>>
<?= $Page->autoriza_cremar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->username_autoriza->Visible) { // username_autoriza ?>
    <tr id="r_username_autoriza"<?= $Page->username_autoriza->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_username_autoriza"><?= $Page->username_autoriza->caption() ?></span></td>
        <td data-name="username_autoriza"<?= $Page->username_autoriza->cellAttributes() ?>>
<span id="el_sco_expediente_old_username_autoriza">
<span<?= $Page->username_autoriza->viewAttributes() ?>>
<?= $Page->username_autoriza->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_autoriza->Visible) { // fecha_autoriza ?>
    <tr id="r_fecha_autoriza"<?= $Page->fecha_autoriza->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_fecha_autoriza"><?= $Page->fecha_autoriza->caption() ?></span></td>
        <td data-name="fecha_autoriza"<?= $Page->fecha_autoriza->cellAttributes() ?>>
<span id="el_sco_expediente_old_fecha_autoriza">
<span<?= $Page->fecha_autoriza->viewAttributes() ?>>
<?= $Page->fecha_autoriza->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->peso->Visible) { // peso ?>
    <tr id="r_peso"<?= $Page->peso->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_peso"><?= $Page->peso->caption() ?></span></td>
        <td data-name="peso"<?= $Page->peso->cellAttributes() ?>>
<span id="el_sco_expediente_old_peso">
<span<?= $Page->peso->viewAttributes() ?>>
<?= $Page->peso->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contrato_parcela->Visible) { // contrato_parcela ?>
    <tr id="r_contrato_parcela"<?= $Page->contrato_parcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_contrato_parcela"><?= $Page->contrato_parcela->caption() ?></span></td>
        <td data-name="contrato_parcela"<?= $Page->contrato_parcela->cellAttributes() ?>>
<span id="el_sco_expediente_old_contrato_parcela">
<span<?= $Page->contrato_parcela->viewAttributes() ?>>
<?= $Page->contrato_parcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->email_calidad->Visible) { // email_calidad ?>
    <tr id="r_email_calidad"<?= $Page->email_calidad->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_email_calidad"><?= $Page->email_calidad->caption() ?></span></td>
        <td data-name="email_calidad"<?= $Page->email_calidad->cellAttributes() ?>>
<span id="el_sco_expediente_old_email_calidad">
<span<?= $Page->email_calidad->viewAttributes() ?>>
<?= $Page->email_calidad->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->certificado_defuncion->Visible) { // certificado_defuncion ?>
    <tr id="r_certificado_defuncion"<?= $Page->certificado_defuncion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_certificado_defuncion"><?= $Page->certificado_defuncion->caption() ?></span></td>
        <td data-name="certificado_defuncion"<?= $Page->certificado_defuncion->cellAttributes() ?>>
<span id="el_sco_expediente_old_certificado_defuncion">
<span<?= $Page->certificado_defuncion->viewAttributes() ?>>
<?= $Page->certificado_defuncion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <tr id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_old_parcela"><?= $Page->parcela->caption() ?></span></td>
        <td data-name="parcela"<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_expediente_old_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
