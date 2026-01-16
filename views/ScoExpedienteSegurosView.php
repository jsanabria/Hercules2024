<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteSegurosView = &$Page;
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
<form name="fsco_expediente_segurosview" id="fsco_expediente_segurosview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_expediente_seguros: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_expediente_segurosview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_expediente_segurosview")
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
<input type="hidden" name="t" value="sco_expediente_seguros">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nexpediente_seguros->Visible) { // Nexpediente_seguros ?>
    <tr id="r_Nexpediente_seguros"<?= $Page->Nexpediente_seguros->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_Nexpediente_seguros"><?= $Page->Nexpediente_seguros->caption() ?></span></td>
        <td data-name="Nexpediente_seguros"<?= $Page->Nexpediente_seguros->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_Nexpediente_seguros">
<span<?= $Page->Nexpediente_seguros->viewAttributes() ?>>
<?= $Page->Nexpediente_seguros->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <tr id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_seguro"><?= $Page->seguro->caption() ?></span></td>
        <td data-name="seguro"<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_seguro">
<span<?= $Page->seguro->viewAttributes() ?>>
<?= $Page->seguro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_contacto->Visible) { // nombre_contacto ?>
    <tr id="r_nombre_contacto"<?= $Page->nombre_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_nombre_contacto"><?= $Page->nombre_contacto->caption() ?></span></td>
        <td data-name="nombre_contacto"<?= $Page->nombre_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nombre_contacto">
<span<?= $Page->nombre_contacto->viewAttributes() ?>>
<?= $Page->nombre_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->parentesco_contacto->Visible) { // parentesco_contacto ?>
    <tr id="r_parentesco_contacto"<?= $Page->parentesco_contacto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_parentesco_contacto"><?= $Page->parentesco_contacto->caption() ?></span></td>
        <td data-name="parentesco_contacto"<?= $Page->parentesco_contacto->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_parentesco_contacto">
<span<?= $Page->parentesco_contacto->viewAttributes() ?>>
<?= $Page->parentesco_contacto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_contacto1->Visible) { // telefono_contacto1 ?>
    <tr id="r_telefono_contacto1"<?= $Page->telefono_contacto1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_telefono_contacto1"><?= $Page->telefono_contacto1->caption() ?></span></td>
        <td data-name="telefono_contacto1"<?= $Page->telefono_contacto1->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_telefono_contacto1">
<span<?= $Page->telefono_contacto1->viewAttributes() ?>>
<?= $Page->telefono_contacto1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telefono_contacto2->Visible) { // telefono_contacto2 ?>
    <tr id="r_telefono_contacto2"<?= $Page->telefono_contacto2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_telefono_contacto2"><?= $Page->telefono_contacto2->caption() ?></span></td>
        <td data-name="telefono_contacto2"<?= $Page->telefono_contacto2->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_telefono_contacto2">
<span<?= $Page->telefono_contacto2->viewAttributes() ?>>
<?= $Page->telefono_contacto2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email"<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_expediente_seguros__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
    <tr id="r_cedula_fallecido"<?= $Page->cedula_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_cedula_fallecido"><?= $Page->cedula_fallecido->caption() ?></span></td>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
    <tr id="r_nombre_fallecido"<?= $Page->nombre_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_nombre_fallecido"><?= $Page->nombre_fallecido->caption() ?></span></td>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
    <tr id="r_apellidos_fallecido"<?= $Page->apellidos_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_apellidos_fallecido"><?= $Page->apellidos_fallecido->caption() ?></span></td>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sexo->Visible) { // sexo ?>
    <tr id="r_sexo"<?= $Page->sexo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_sexo"><?= $Page->sexo->caption() ?></span></td>
        <td data-name="sexo"<?= $Page->sexo->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_sexo">
<span<?= $Page->sexo->viewAttributes() ?>>
<?= $Page->sexo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
    <tr id="r_fecha_nacimiento"<?= $Page->fecha_nacimiento->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_fecha_nacimiento"><?= $Page->fecha_nacimiento->caption() ?></span></td>
        <td data-name="fecha_nacimiento"<?= $Page->fecha_nacimiento->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_fecha_nacimiento">
<span<?= $Page->fecha_nacimiento->viewAttributes() ?>>
<?= $Page->fecha_nacimiento->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->edad_fallecido->Visible) { // edad_fallecido ?>
    <tr id="r_edad_fallecido"<?= $Page->edad_fallecido->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_edad_fallecido"><?= $Page->edad_fallecido->caption() ?></span></td>
        <td data-name="edad_fallecido"<?= $Page->edad_fallecido->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_edad_fallecido">
<span<?= $Page->edad_fallecido->viewAttributes() ?>>
<?= $Page->edad_fallecido->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lugar_ocurrencia->Visible) { // lugar_ocurrencia ?>
    <tr id="r_lugar_ocurrencia"<?= $Page->lugar_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_lugar_ocurrencia"><?= $Page->lugar_ocurrencia->caption() ?></span></td>
        <td data-name="lugar_ocurrencia"<?= $Page->lugar_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_lugar_ocurrencia">
<span<?= $Page->lugar_ocurrencia->viewAttributes() ?>>
<?= $Page->lugar_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->direccion_ocurrencia->Visible) { // direccion_ocurrencia ?>
    <tr id="r_direccion_ocurrencia"<?= $Page->direccion_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_direccion_ocurrencia"><?= $Page->direccion_ocurrencia->caption() ?></span></td>
        <td data-name="direccion_ocurrencia"<?= $Page->direccion_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_direccion_ocurrencia">
<span<?= $Page->direccion_ocurrencia->viewAttributes() ?>>
<?= $Page->direccion_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha_ocurrencia->Visible) { // fecha_ocurrencia ?>
    <tr id="r_fecha_ocurrencia"<?= $Page->fecha_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_fecha_ocurrencia"><?= $Page->fecha_ocurrencia->caption() ?></span></td>
        <td data-name="fecha_ocurrencia"<?= $Page->fecha_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_fecha_ocurrencia">
<span<?= $Page->fecha_ocurrencia->viewAttributes() ?>>
<?= $Page->fecha_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_ocurrencia->Visible) { // causa_ocurrencia ?>
    <tr id="r_causa_ocurrencia"<?= $Page->causa_ocurrencia->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_causa_ocurrencia"><?= $Page->causa_ocurrencia->caption() ?></span></td>
        <td data-name="causa_ocurrencia"<?= $Page->causa_ocurrencia->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_causa_ocurrencia">
<span<?= $Page->causa_ocurrencia->viewAttributes() ?>>
<?= $Page->causa_ocurrencia->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->causa_otro->Visible) { // causa_otro ?>
    <tr id="r_causa_otro"<?= $Page->causa_otro->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_causa_otro"><?= $Page->causa_otro->caption() ?></span></td>
        <td data-name="causa_otro"<?= $Page->causa_otro->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_causa_otro">
<span<?= $Page->causa_otro->viewAttributes() ?>>
<?= $Page->causa_otro->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
    <tr id="r_expediente"<?= $Page->expediente->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_expediente"><?= $Page->expediente->caption() ?></span></td>
        <td data-name="expediente"<?= $Page->expediente->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_expediente">
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->religion->Visible) { // religion ?>
    <tr id="r_religion"<?= $Page->religion->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_religion"><?= $Page->religion->caption() ?></span></td>
        <td data-name="religion"<?= $Page->religion->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_religion">
<span<?= $Page->religion->viewAttributes() ?>>
<?= $Page->religion->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <tr id="r_servicio_tipo"<?= $Page->servicio_tipo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></td>
        <td data-name="servicio_tipo"<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_servicio_tipo">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <tr id="r_servicio"<?= $Page->servicio->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_servicio"><?= $Page->servicio->caption() ?></span></td>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <tr id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_estatus"><?= $Page->estatus->caption() ?></span></td>
        <td data-name="estatus"<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_estatus">
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <tr id="r_funeraria"<?= $Page->funeraria->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_expediente_seguros_funeraria"><?= $Page->funeraria->caption() ?></span></td>
        <td data-name="funeraria"<?= $Page->funeraria->cellAttributes() ?>>
<span id="el_sco_expediente_seguros_funeraria">
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("sco_expediente_seguros_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_expediente_seguros_adjunto->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_expediente_seguros_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoExpedienteSegurosAdjuntoGrid.php" ?>
<?php } ?>
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
