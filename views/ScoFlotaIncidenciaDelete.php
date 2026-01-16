<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaIncidenciaDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_flota_incidenciadelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_flota_incidenciadelete")
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
<form name="fsco_flota_incidenciadelete" id="fsco_flota_incidenciadelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_flota_incidencia">
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
<?php if ($Page->Nflota_incidencia->Visible) { // Nflota_incidencia ?>
        <th class="<?= $Page->Nflota_incidencia->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_Nflota_incidencia" class="sco_flota_incidencia_Nflota_incidencia"><?= $Page->Nflota_incidencia->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_fecha_registro" class="sco_flota_incidencia_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->flota->Visible) { // flota ?>
        <th class="<?= $Page->flota->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_flota" class="sco_flota_incidencia_flota"><?= $Page->flota->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_tipo" class="sco_flota_incidencia_tipo"><?= $Page->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->falla->Visible) { // falla ?>
        <th class="<?= $Page->falla->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_falla" class="sco_flota_incidencia_falla"><?= $Page->falla->caption() ?></span></th>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <th class="<?= $Page->proveedor->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_proveedor" class="sco_flota_incidencia_proveedor"><?= $Page->proveedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_sco_flota_incidencia__username" class="sco_flota_incidencia__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_reparacion->Visible) { // fecha_reparacion ?>
        <th class="<?= $Page->fecha_reparacion->headerCellClass() ?>"><span id="elh_sco_flota_incidencia_fecha_reparacion" class="sco_flota_incidencia_fecha_reparacion"><?= $Page->fecha_reparacion->caption() ?></span></th>
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
<?php if ($Page->Nflota_incidencia->Visible) { // Nflota_incidencia ?>
        <td<?= $Page->Nflota_incidencia->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nflota_incidencia->viewAttributes() ?>>
<?= $Page->Nflota_incidencia->getViewValue() ?></span>
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
<?php if ($Page->flota->Visible) { // flota ?>
        <td<?= $Page->flota->cellAttributes() ?>>
<span id="">
<span<?= $Page->flota->viewAttributes() ?>>
<?= $Page->flota->getViewValue() ?></span>
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
<?php if ($Page->falla->Visible) { // falla ?>
        <td<?= $Page->falla->cellAttributes() ?>>
<span id="">
<span<?= $Page->falla->viewAttributes() ?>>
<?= $Page->falla->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <td<?= $Page->proveedor->cellAttributes() ?>>
<span id="">
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td<?= $Page->_username->cellAttributes() ?>>
<span id="">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_reparacion->Visible) { // fecha_reparacion ?>
        <td<?= $Page->fecha_reparacion->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_reparacion->viewAttributes() ?>>
<?= $Page->fecha_reparacion->getViewValue() ?></span>
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
