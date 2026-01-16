<?php

namespace PHPMaker2024\hercules;

// Page object
$AutogestionPlantillasDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { autogestion_plantillas: currentTable } });
var currentPageID = ew.PAGE_ID = "delete";
var currentForm;
var fautogestion_plantillasdelete;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fautogestion_plantillasdelete")
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
<form name="fautogestion_plantillasdelete" id="fautogestion_plantillasdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="autogestion_plantillas">
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><span id="elh_autogestion_plantillas_servicio_tipo" class="autogestion_plantillas_servicio_tipo"><?= $Page->servicio_tipo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
        <th class="<?= $Page->script->headerCellClass() ?>"><span id="elh_autogestion_plantillas_script" class="autogestion_plantillas_script"><?= $Page->script->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
        <th class="<?= $Page->nivel->headerCellClass() ?>"><span id="elh_autogestion_plantillas_nivel" class="autogestion_plantillas_nivel"><?= $Page->nivel->caption() ?></span></th>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
        <th class="<?= $Page->orden->headerCellClass() ?>"><span id="elh_autogestion_plantillas_orden" class="autogestion_plantillas_orden"><?= $Page->orden->caption() ?></span></th>
<?php } ?>
<?php if ($Page->codigo->Visible) { // codigo ?>
        <th class="<?= $Page->codigo->headerCellClass() ?>"><span id="elh_autogestion_plantillas_codigo" class="autogestion_plantillas_codigo"><?= $Page->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><span id="elh_autogestion_plantillas_descripcion" class="autogestion_plantillas_descripcion"><?= $Page->descripcion->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mostrar->Visible) { // mostrar ?>
        <th class="<?= $Page->mostrar->headerCellClass() ?>"><span id="elh_autogestion_plantillas_mostrar" class="autogestion_plantillas_mostrar"><?= $Page->mostrar->caption() ?></span></th>
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <td<?= $Page->servicio_tipo->cellAttributes() ?>>
<span id="">
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
        <td<?= $Page->script->cellAttributes() ?>>
<span id="">
<span<?= $Page->script->viewAttributes() ?>>
<?= $Page->script->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nivel->Visible) { // nivel ?>
        <td<?= $Page->nivel->cellAttributes() ?>>
<span id="">
<span<?= $Page->nivel->viewAttributes() ?>>
<?= $Page->nivel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->orden->Visible) { // orden ?>
        <td<?= $Page->orden->cellAttributes() ?>>
<span id="">
<span<?= $Page->orden->viewAttributes() ?>>
<?= $Page->orden->getViewValue() ?></span>
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
<?php if ($Page->mostrar->Visible) { // mostrar ?>
        <td<?= $Page->mostrar->cellAttributes() ?>>
<span id="">
<span<?= $Page->mostrar->viewAttributes() ?>>
<?= $Page->mostrar->getViewValue() ?></span>
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
