<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoMttotecnicoAdjuntoView = &$Page;
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
<form name="fsco_mttotecnico_adjuntoview" id="fsco_mttotecnico_adjuntoview" class="ew-form ew-view-form overlay-wrapper" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_mttotecnico_adjunto: currentTable } });
var currentPageID = ew.PAGE_ID = "view";
var currentForm;
var fsco_mttotecnico_adjuntoview;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_mttotecnico_adjuntoview")
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
<input type="hidden" name="t" value="sco_mttotecnico_adjunto">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="<?= $Page->TableClass ?>">
<?php if ($Page->Nmttotecnico_adjunto->Visible) { // Nmttotecnico_adjunto ?>
    <tr id="r_Nmttotecnico_adjunto"<?= $Page->Nmttotecnico_adjunto->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_adjunto_Nmttotecnico_adjunto"><?= $Page->Nmttotecnico_adjunto->caption() ?></span></td>
        <td data-name="Nmttotecnico_adjunto"<?= $Page->Nmttotecnico_adjunto->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_Nmttotecnico_adjunto">
<span<?= $Page->Nmttotecnico_adjunto->viewAttributes() ?>>
<?= $Page->Nmttotecnico_adjunto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mttotecnico->Visible) { // mttotecnico ?>
    <tr id="r_mttotecnico"<?= $Page->mttotecnico->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_adjunto_mttotecnico"><?= $Page->mttotecnico->caption() ?></span></td>
        <td data-name="mttotecnico"<?= $Page->mttotecnico->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_mttotecnico">
<span<?= $Page->mttotecnico->viewAttributes() ?>>
<?= $Page->mttotecnico->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <tr id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_adjunto_nota"><?= $Page->nota->caption() ?></span></td>
        <td data-name="nota"<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_nota">
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <tr id="r_archivo"<?= $Page->archivo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_adjunto_archivo"><?= $Page->archivo->caption() ?></span></td>
        <td data-name="archivo"<?= $Page->archivo->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_archivo">
<span<?= $Page->archivo->viewAttributes() ?>>
<?= $Page->archivo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->usuario->Visible) { // usuario ?>
    <tr id="r_usuario"<?= $Page->usuario->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_adjunto_usuario"><?= $Page->usuario->caption() ?></span></td>
        <td data-name="usuario"<?= $Page->usuario->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_usuario">
<span<?= $Page->usuario->viewAttributes() ?>>
<?= $Page->usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <tr id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_sco_mttotecnico_adjunto_fecha"><?= $Page->fecha->caption() ?></span></td>
        <td data-name="fecha"<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_mttotecnico_adjunto_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
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
