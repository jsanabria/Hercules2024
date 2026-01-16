<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_parceladelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parceladelete")
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
<form name="fsco_parceladelete" id="fsco_parceladelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_parcela">
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
<?php if ($Page->Nparcela->Visible) { // Nparcela ?>
        <th class="<?= $Page->Nparcela->headerCellClass() ?>"><span id="elh_sco_parcela_Nparcela" class="sco_parcela_Nparcela"><?= $Page->Nparcela->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nacionalidad->Visible) { // nacionalidad ?>
        <th class="<?= $Page->nacionalidad->headerCellClass() ?>"><span id="elh_sco_parcela_nacionalidad" class="sco_parcela_nacionalidad"><?= $Page->nacionalidad->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
        <th class="<?= $Page->cedula->headerCellClass() ?>"><span id="elh_sco_parcela_cedula" class="sco_parcela_cedula"><?= $Page->cedula->caption() ?></span></th>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
        <th class="<?= $Page->titular->headerCellClass() ?>"><span id="elh_sco_parcela_titular" class="sco_parcela_titular"><?= $Page->titular->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <th class="<?= $Page->contrato->headerCellClass() ?>"><span id="elh_sco_parcela_contrato" class="sco_parcela_contrato"><?= $Page->contrato->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th class="<?= $Page->seccion->headerCellClass() ?>"><span id="elh_sco_parcela_seccion" class="sco_parcela_seccion"><?= $Page->seccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th class="<?= $Page->modulo->headerCellClass() ?>"><span id="elh_sco_parcela_modulo" class="sco_parcela_modulo"><?= $Page->modulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <th class="<?= $Page->sub_seccion->headerCellClass() ?>"><span id="elh_sco_parcela_sub_seccion" class="sco_parcela_sub_seccion"><?= $Page->sub_seccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th class="<?= $Page->parcela->headerCellClass() ?>"><span id="elh_sco_parcela_parcela" class="sco_parcela_parcela"><?= $Page->parcela->caption() ?></span></th>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
        <th class="<?= $Page->boveda->headerCellClass() ?>"><span id="elh_sco_parcela_boveda" class="sco_parcela_boveda"><?= $Page->boveda->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <th class="<?= $Page->apellido1->headerCellClass() ?>"><span id="elh_sco_parcela_apellido1" class="sco_parcela_apellido1"><?= $Page->apellido1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <th class="<?= $Page->apellido2->headerCellClass() ?>"><span id="elh_sco_parcela_apellido2" class="sco_parcela_apellido2"><?= $Page->apellido2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <th class="<?= $Page->nombre1->headerCellClass() ?>"><span id="elh_sco_parcela_nombre1" class="sco_parcela_nombre1"><?= $Page->nombre1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <th class="<?= $Page->nombre2->headerCellClass() ?>"><span id="elh_sco_parcela_nombre2" class="sco_parcela_nombre2"><?= $Page->nombre2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <th class="<?= $Page->fecha_inhumacion->headerCellClass() ?>"><span id="elh_sco_parcela_fecha_inhumacion" class="sco_parcela_fecha_inhumacion"><?= $Page->fecha_inhumacion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <th class="<?= $Page->funeraria->headerCellClass() ?>"><span id="elh_sco_parcela_funeraria" class="sco_parcela_funeraria"><?= $Page->funeraria->caption() ?></span></th>
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
<?php if ($Page->Nparcela->Visible) { // Nparcela ?>
        <td<?= $Page->Nparcela->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nparcela->viewAttributes() ?>>
<?= $Page->Nparcela->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nacionalidad->Visible) { // nacionalidad ?>
        <td<?= $Page->nacionalidad->cellAttributes() ?>>
<span id="">
<span<?= $Page->nacionalidad->viewAttributes() ?>>
<?= $Page->nacionalidad->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
        <td<?= $Page->cedula->cellAttributes() ?>>
<span id="">
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
        <td<?= $Page->titular->cellAttributes() ?>>
<span id="">
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <td<?= $Page->contrato->cellAttributes() ?>>
<span id="">
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <td<?= $Page->seccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <td<?= $Page->modulo->cellAttributes() ?>>
<span id="">
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <td<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
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
<?php if ($Page->boveda->Visible) { // boveda ?>
        <td<?= $Page->boveda->cellAttributes() ?>>
<span id="">
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <td<?= $Page->apellido1->cellAttributes() ?>>
<span id="">
<span<?= $Page->apellido1->viewAttributes() ?>>
<?= $Page->apellido1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <td<?= $Page->apellido2->cellAttributes() ?>>
<span id="">
<span<?= $Page->apellido2->viewAttributes() ?>>
<?= $Page->apellido2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <td<?= $Page->nombre1->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre1->viewAttributes() ?>>
<?= $Page->nombre1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <td<?= $Page->nombre2->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre2->viewAttributes() ?>>
<?= $Page->nombre2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <td<?= $Page->fecha_inhumacion->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_inhumacion->viewAttributes() ?>>
<?= $Page->fecha_inhumacion->getViewValue() ?></span>
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
