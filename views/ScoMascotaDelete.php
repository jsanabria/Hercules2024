<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMascotaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mascota: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_mascotadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mascotadelete")
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
<form name="fsco_mascotadelete" id="fsco_mascotadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_mascota">
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
<?php if ($Page->Nmascota->Visible) { // Nmascota ?>
        <th class="<?= $Page->Nmascota->headerCellClass() ?>"><span id="elh_sco_mascota_Nmascota" class="sco_mascota_Nmascota"><?= $Page->Nmascota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_contratante->Visible) { // nombre_contratante ?>
        <th class="<?= $Page->nombre_contratante->headerCellClass() ?>"><span id="elh_sco_mascota_nombre_contratante" class="sco_mascota_nombre_contratante"><?= $Page->nombre_contratante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cedula_contratante->Visible) { // cedula_contratante ?>
        <th class="<?= $Page->cedula_contratante->headerCellClass() ?>"><span id="elh_sco_mascota_cedula_contratante" class="sco_mascota_cedula_contratante"><?= $Page->cedula_contratante->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nombre_mascota->Visible) { // nombre_mascota ?>
        <th class="<?= $Page->nombre_mascota->headerCellClass() ?>"><span id="elh_sco_mascota_nombre_mascota" class="sco_mascota_nombre_mascota"><?= $Page->nombre_mascota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->raza->Visible) { // raza ?>
        <th class="<?= $Page->raza->headerCellClass() ?>"><span id="elh_sco_mascota_raza" class="sco_mascota_raza"><?= $Page->raza->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><span id="elh_sco_mascota_tipo" class="sco_mascota_tipo"><?= $Page->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
        <th class="<?= $Page->color->headerCellClass() ?>"><span id="elh_sco_mascota_color" class="sco_mascota_color"><?= $Page->color->caption() ?></span></th>
<?php } ?>
<?php if ($Page->procedencia->Visible) { // procedencia ?>
        <th class="<?= $Page->procedencia->headerCellClass() ?>"><span id="elh_sco_mascota_procedencia" class="sco_mascota_procedencia"><?= $Page->procedencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <th class="<?= $Page->factura->headerCellClass() ?>"><span id="elh_sco_mascota_factura" class="sco_mascota_factura"><?= $Page->factura->caption() ?></span></th>
<?php } ?>
<?php if ($Page->username_registra->Visible) { // username_registra ?>
        <th class="<?= $Page->username_registra->headerCellClass() ?>"><span id="elh_sco_mascota_username_registra" class="sco_mascota_username_registra"><?= $Page->username_registra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_mascota_fecha_registro" class="sco_mascota_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
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
<?php if ($Page->Nmascota->Visible) { // Nmascota ?>
        <td<?= $Page->Nmascota->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nmascota->viewAttributes() ?>>
<?= $Page->Nmascota->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_contratante->Visible) { // nombre_contratante ?>
        <td<?= $Page->nombre_contratante->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre_contratante->viewAttributes() ?>>
<?= $Page->nombre_contratante->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cedula_contratante->Visible) { // cedula_contratante ?>
        <td<?= $Page->cedula_contratante->cellAttributes() ?>>
<span id="">
<span<?= $Page->cedula_contratante->viewAttributes() ?>>
<?= $Page->cedula_contratante->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_mascota->Visible) { // nombre_mascota ?>
        <td<?= $Page->nombre_mascota->cellAttributes() ?>>
<span id="">
<span<?= $Page->nombre_mascota->viewAttributes() ?>>
<?= $Page->nombre_mascota->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->raza->Visible) { // raza ?>
        <td<?= $Page->raza->cellAttributes() ?>>
<span id="">
<span<?= $Page->raza->viewAttributes() ?>>
<?= $Page->raza->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <td<?= $Page->tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->color->Visible) { // color ?>
        <td<?= $Page->color->cellAttributes() ?>>
<span id="">
<span<?= $Page->color->viewAttributes() ?>>
<?= $Page->color->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->procedencia->Visible) { // procedencia ?>
        <td<?= $Page->procedencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->procedencia->viewAttributes() ?>>
<?= $Page->procedencia->getViewValue() ?></span>
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
<?php if ($Page->username_registra->Visible) { // username_registra ?>
        <td<?= $Page->username_registra->cellAttributes() ?>>
<span id="">
<span<?= $Page->username_registra->viewAttributes() ?>>
<?= $Page->username_registra->getViewValue() ?></span>
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
