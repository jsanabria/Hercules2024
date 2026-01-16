<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaDetalleDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_costos_tarifa_detalledelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costos_tarifa_detalledelete")
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
<form name="fsco_costos_tarifa_detalledelete" id="fsco_costos_tarifa_detalledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_costos_tarifa_detalle">
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
<?php if ($Page->cap->Visible) { // cap ?>
        <th class="<?= $Page->cap->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_cap" class="sco_costos_tarifa_detalle_cap"><?= $Page->cap->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
        <th class="<?= $Page->ata->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_ata" class="sco_costos_tarifa_detalle_ata"><?= $Page->ata->caption() ?></span></th>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
        <th class="<?= $Page->obi->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_obi" class="sco_costos_tarifa_detalle_obi"><?= $Page->obi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
        <th class="<?= $Page->fot->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_fot" class="sco_costos_tarifa_detalle_fot"><?= $Page->fot->caption() ?></span></th>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
        <th class="<?= $Page->man->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_man" class="sco_costos_tarifa_detalle_man"><?= $Page->man->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
        <th class="<?= $Page->gas->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_gas" class="sco_costos_tarifa_detalle_gas"><?= $Page->gas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
        <th class="<?= $Page->com->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_com" class="sco_costos_tarifa_detalle_com"><?= $Page->com->caption() ?></span></th>
<?php } ?>
<?php if ($Page->base->Visible) { // base ?>
        <th class="<?= $Page->base->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_base" class="sco_costos_tarifa_detalle_base"><?= $Page->base->caption() ?></span></th>
<?php } ?>
<?php if ($Page->base_anterior->Visible) { // base_anterior ?>
        <th class="<?= $Page->base_anterior->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_base_anterior" class="sco_costos_tarifa_detalle_base_anterior"><?= $Page->base_anterior->caption() ?></span></th>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <th class="<?= $Page->variacion->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_variacion" class="sco_costos_tarifa_detalle_variacion"><?= $Page->variacion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <th class="<?= $Page->porcentaje->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_porcentaje" class="sco_costos_tarifa_detalle_porcentaje"><?= $Page->porcentaje->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_fecha" class="sco_costos_tarifa_detalle_fecha"><?= $Page->fecha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
        <th class="<?= $Page->cerrado->headerCellClass() ?>"><span id="elh_sco_costos_tarifa_detalle_cerrado" class="sco_costos_tarifa_detalle_cerrado"><?= $Page->cerrado->caption() ?></span></th>
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
<?php if ($Page->cap->Visible) { // cap ?>
        <td<?= $Page->cap->cellAttributes() ?>>
<span id="">
<span<?= $Page->cap->viewAttributes() ?>>
<?= $Page->cap->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
        <td<?= $Page->ata->cellAttributes() ?>>
<span id="">
<span<?= $Page->ata->viewAttributes() ?>>
<?= $Page->ata->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
        <td<?= $Page->obi->cellAttributes() ?>>
<span id="">
<span<?= $Page->obi->viewAttributes() ?>>
<?= $Page->obi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
        <td<?= $Page->fot->cellAttributes() ?>>
<span id="">
<span<?= $Page->fot->viewAttributes() ?>>
<?= $Page->fot->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
        <td<?= $Page->man->cellAttributes() ?>>
<span id="">
<span<?= $Page->man->viewAttributes() ?>>
<?= $Page->man->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
        <td<?= $Page->gas->cellAttributes() ?>>
<span id="">
<span<?= $Page->gas->viewAttributes() ?>>
<?= $Page->gas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
        <td<?= $Page->com->cellAttributes() ?>>
<span id="">
<span<?= $Page->com->viewAttributes() ?>>
<?= $Page->com->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->base->Visible) { // base ?>
        <td<?= $Page->base->cellAttributes() ?>>
<span id="">
<span<?= $Page->base->viewAttributes() ?>>
<?= $Page->base->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->base_anterior->Visible) { // base_anterior ?>
        <td<?= $Page->base_anterior->cellAttributes() ?>>
<span id="">
<span<?= $Page->base_anterior->viewAttributes() ?>>
<?= $Page->base_anterior->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <td<?= $Page->variacion->cellAttributes() ?>>
<span id="">
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <td<?= $Page->porcentaje->cellAttributes() ?>>
<span id="">
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
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
