<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParametroDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parametro: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fsco_parametrodelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parametrodelete")
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
<form name="fsco_parametrodelete" id="fsco_parametrodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_parametro">
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
<?php if ($Page->Nparametro->Visible) { // Nparametro ?>
        <th class="<?= $Page->Nparametro->headerCellClass() ?>"><span id="elh_sco_parametro_Nparametro" class="sco_parametro_Nparametro"><?= $Page->Nparametro->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <th class="<?= $Page->codigo->headerCellClass() ?>"><span id="elh_sco_parametro_codigo" class="sco_parametro_codigo"><?= $Page->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_sco_parametro_descripcion" class="sco_parametro_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor1->Visible) { // valor1 ?>
        <th class="<?= $Page->valor1->headerCellClass() ?>"><span id="elh_sco_parametro_valor1" class="sco_parametro_valor1"><?= $Page->valor1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor2->Visible) { // valor2 ?>
        <th class="<?= $Page->valor2->headerCellClass() ?>"><span id="elh_sco_parametro_valor2" class="sco_parametro_valor2"><?= $Page->valor2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor3->Visible) { // valor3 ?>
        <th class="<?= $Page->valor3->headerCellClass() ?>"><span id="elh_sco_parametro_valor3" class="sco_parametro_valor3"><?= $Page->valor3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->valor4->Visible) { // valor4 ?>
        <th class="<?= $Page->valor4->headerCellClass() ?>"><span id="elh_sco_parametro_valor4" class="sco_parametro_valor4"><?= $Page->valor4->caption() ?></span></th>
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
<?php if ($Page->Nparametro->Visible) { // Nparametro ?>
        <td<?= $Page->Nparametro->cellAttributes() ?>>
<span id="">
<span<?= $Page->Nparametro->viewAttributes() ?>>
<?= $Page->Nparametro->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <td<?= $Page->codigo->cellAttributes() ?>>
<span id="">
<span<?= $Page->codigo->viewAttributes() ?>>
<?= $Page->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <td<?= $Page->descripcion->cellAttributes() ?>>
<span id="">
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valor1->Visible) { // valor1 ?>
        <td<?= $Page->valor1->cellAttributes() ?>>
<span id="">
<span<?= $Page->valor1->viewAttributes() ?>>
<?= $Page->valor1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valor2->Visible) { // valor2 ?>
        <td<?= $Page->valor2->cellAttributes() ?>>
<span id="">
<span<?= $Page->valor2->viewAttributes() ?>>
<?= $Page->valor2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valor3->Visible) { // valor3 ?>
        <td<?= $Page->valor3->cellAttributes() ?>>
<span id="">
<span<?= $Page->valor3->viewAttributes() ?>>
<?= $Page->valor3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->valor4->Visible) { // valor4 ?>
        <td<?= $Page->valor4->cellAttributes() ?>>
<span id="">
<span<?= $Page->valor4->viewAttributes() ?>>
<?= $Page->valor4->getViewValue() ?></span>
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
