<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_costosdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costosdelete")
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
<form name="fsco_costosdelete" id="fsco_costosdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_sco_costos_id" class="sco_costos_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_costos_fecha" class="sco_costos_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><span id="elh_sco_costos_tipo" class="sco_costos_tipo"><?= $Page->tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
        <th class="<?= $Page->costos_articulos->headerCellClass() ?>"><span id="elh_sco_costos_costos_articulos" class="sco_costos_costos_articulos"><?= $Page->costos_articulos->caption() ?></span></th>
<?php } ?>
<?php if ($Page->precio_actual->Visible) { // precio_actual ?>
        <th class="<?= $Page->precio_actual->headerCellClass() ?>"><span id="elh_sco_costos_precio_actual" class="sco_costos_precio_actual"><?= $Page->precio_actual->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
        <th class="<?= $Page->porcentaje_aplicado->headerCellClass() ?>"><span id="elh_sco_costos_porcentaje_aplicado" class="sco_costos_porcentaje_aplicado"><?= $Page->porcentaje_aplicado->caption() ?></span></th>
<?php } ?>
<?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
        <th class="<?= $Page->precio_nuevo->headerCellClass() ?>"><span id="elh_sco_costos_precio_nuevo" class="sco_costos_precio_nuevo"><?= $Page->precio_nuevo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
        <th class="<?= $Page->alicuota_iva->headerCellClass() ?>"><span id="elh_sco_costos_alicuota_iva" class="sco_costos_alicuota_iva"><?= $Page->alicuota_iva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->monto_iva->Visible) { // monto_iva ?>
        <th class="<?= $Page->monto_iva->headerCellClass() ?>"><span id="elh_sco_costos_monto_iva" class="sco_costos_monto_iva"><?= $Page->monto_iva->caption() ?></span></th>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <th class="<?= $Page->total->headerCellClass() ?>"><span id="elh_sco_costos_total" class="sco_costos_total"><?= $Page->total->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
        <th class="<?= $Page->cerrado->headerCellClass() ?>"><span id="elh_sco_costos_cerrado" class="sco_costos_cerrado"><?= $Page->cerrado->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <td<?= $Page->fecha->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
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
<?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
        <td<?= $Page->costos_articulos->cellAttributes() ?>>
<span id="">
<span<?= $Page->costos_articulos->viewAttributes() ?>>
<?= $Page->costos_articulos->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->precio_actual->Visible) { // precio_actual ?>
        <td<?= $Page->precio_actual->cellAttributes() ?>>
<span id="">
<span<?= $Page->precio_actual->viewAttributes() ?>>
<?= $Page->precio_actual->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
        <td<?= $Page->porcentaje_aplicado->cellAttributes() ?>>
<span id="">
<span<?= $Page->porcentaje_aplicado->viewAttributes() ?>>
<?= $Page->porcentaje_aplicado->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
        <td<?= $Page->precio_nuevo->cellAttributes() ?>>
<span id="">
<span<?= $Page->precio_nuevo->viewAttributes() ?>>
<?= $Page->precio_nuevo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
        <td<?= $Page->alicuota_iva->cellAttributes() ?>>
<span id="">
<span<?= $Page->alicuota_iva->viewAttributes() ?>>
<?= $Page->alicuota_iva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->monto_iva->Visible) { // monto_iva ?>
        <td<?= $Page->monto_iva->cellAttributes() ?>>
<span id="">
<span<?= $Page->monto_iva->viewAttributes() ?>>
<?= $Page->monto_iva->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
        <td<?= $Page->total->cellAttributes() ?>>
<span id="">
<span<?= $Page->total->viewAttributes() ?>>
<?= $Page->total->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
        <td<?= $Page->cerrado->cellAttributes() ?>>
<span id="">
<span<?= $Page->cerrado->viewAttributes() ?>>
<?= $Page->cerrado->getViewValue() ?></span>
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
