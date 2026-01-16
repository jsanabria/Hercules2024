<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaVentasDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela_ventas: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_parcela_ventasdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcela_ventasdelete")
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
<form name="fsco_parcela_ventasdelete" id="fsco_parcela_ventasdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_parcela_ventas">
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
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
        <th class="<?= $Page->Nparcela_ventas->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_Nparcela_ventas" class="sco_parcela_ventas_Nparcela_ventas"><?= $Page->Nparcela_ventas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_compra->Visible) { // fecha_compra ?>
        <th class="<?= $Page->fecha_compra->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_fecha_compra" class="sco_parcela_ventas_fecha_compra"><?= $Page->fecha_compra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->usuario_compra->Visible) { // usuario_compra ?>
        <th class="<?= $Page->usuario_compra->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_usuario_compra" class="sco_parcela_ventas_usuario_compra"><?= $Page->usuario_compra->caption() ?></span></th>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <th class="<?= $Page->seccion->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_seccion" class="sco_parcela_ventas_seccion"><?= $Page->seccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <th class="<?= $Page->modulo->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_modulo" class="sco_parcela_ventas_modulo"><?= $Page->modulo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
        <th class="<?= $Page->subseccion->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_subseccion" class="sco_parcela_ventas_subseccion"><?= $Page->subseccion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <th class="<?= $Page->parcela->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_parcela" class="sco_parcela_ventas_parcela"><?= $Page->parcela->caption() ?></span></th>
<?php } ?>
<?php if ($Page->vendedor->Visible) { // vendedor ?>
        <th class="<?= $Page->vendedor->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_vendedor" class="sco_parcela_ventas_vendedor"><?= $Page->vendedor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_estatus" class="sco_parcela_ventas_estatus"><?= $Page->estatus->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
        <th class="<?= $Page->fecha_registro->headerCellClass() ?>"><span id="elh_sco_parcela_ventas_fecha_registro" class="sco_parcela_ventas_fecha_registro"><?= $Page->fecha_registro->caption() ?></span></th>
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
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
        <td<?= $Page->Nparcela_ventas->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nparcela_ventas->viewAttributes() ?>>
<?= $Page->Nparcela_ventas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fecha_compra->Visible) { // fecha_compra ?>
        <td<?= $Page->fecha_compra->cellAttributes() ?>>
<span id="">
<span<?= $Page->fecha_compra->viewAttributes() ?>>
<?= $Page->fecha_compra->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->usuario_compra->Visible) { // usuario_compra ?>
        <td<?= $Page->usuario_compra->cellAttributes() ?>>
<span id="">
<span<?= $Page->usuario_compra->viewAttributes() ?>>
<?= $Page->usuario_compra->getViewValue() ?></span>
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
<?php if ($Page->subseccion->Visible) { // subseccion ?>
        <td<?= $Page->subseccion->cellAttributes() ?>>
<span id="">
<span<?= $Page->subseccion->viewAttributes() ?>>
<?= $Page->subseccion->getViewValue() ?></span>
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
<?php if ($Page->vendedor->Visible) { // vendedor ?>
        <td<?= $Page->vendedor->cellAttributes() ?>>
<span id="">
<span<?= $Page->vendedor->viewAttributes() ?>>
<?= $Page->vendedor->getViewValue() ?></span>
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
