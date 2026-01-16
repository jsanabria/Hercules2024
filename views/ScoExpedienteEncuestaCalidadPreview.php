<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteEncuestaCalidadPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_expediente_encuesta_calidad: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid <?= $Page->TableGridClass ?>"><!-- .card -->
<div class="card-header ew-grid-upper-panel ew-preview-upper-panel"><!-- .card-header -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-header -->
<div class="card-body ew-preview-middle-panel ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>"><!-- .card-body -->
<table class="<?= $Page->TableClass ?>"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->pregunta->Visible) { // pregunta ?>
    <?php if (!$Page->pregunta->Sortable || !$Page->sortUrl($Page->pregunta)) { ?>
        <th class="<?= $Page->pregunta->headerCellClass() ?>"><?= $Page->pregunta->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pregunta->headerCellClass() ?>"><div role="button" data-table="sco_expediente_encuesta_calidad" data-sort="<?= HtmlEncode($Page->pregunta->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->pregunta->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->pregunta->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->pregunta->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->respuesta->Visible) { // respuesta ?>
    <?php if (!$Page->respuesta->Sortable || !$Page->sortUrl($Page->respuesta)) { ?>
        <th class="<?= $Page->respuesta->headerCellClass() ?>"><?= $Page->respuesta->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->respuesta->headerCellClass() ?>"><div role="button" data-table="sco_expediente_encuesta_calidad" data-sort="<?= HtmlEncode($Page->respuesta->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->respuesta->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->respuesta->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->respuesta->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
    <?php if (!$Page->fecha_hora->Sortable || !$Page->sortUrl($Page->fecha_hora)) { ?>
        <th class="<?= $Page->fecha_hora->headerCellClass() ?>"><?= $Page->fecha_hora->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha_hora->headerCellClass() ?>"><div role="button" data-table="sco_expediente_encuesta_calidad" data-sort="<?= HtmlEncode($Page->fecha_hora->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha_hora->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha_hora->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha_hora->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecordCount = 0;
$Page->RowCount = 0;
while ($Page->fetch()) {
    // Init row class and style
    $Page->RecordCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->CurrentRow);

    // Render row
    $Page->RowType = RowType::PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Set up row attributes
    $Page->RowAttrs->merge([
        "data-rowindex" => $Page->RowCount,
        "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",

        // Add row attributes for expandable row
        "data-widget" => "expandable-table",
        "aria-expanded" => "false",
    ]);

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->pregunta->Visible) { // pregunta ?>
        <!-- pregunta -->
        <td<?= $Page->pregunta->cellAttributes() ?>>
<span<?= $Page->pregunta->viewAttributes() ?>>
<?= $Page->pregunta->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->respuesta->Visible) { // respuesta ?>
        <!-- respuesta -->
        <td<?= $Page->respuesta->cellAttributes() ?>>
<span<?= $Page->respuesta->viewAttributes() ?>>
<?= $Page->respuesta->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
        <!-- fecha_hora -->
        <td<?= $Page->fecha_hora->cellAttributes() ?>>
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.card-body -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card-footer -->
</div><!-- /.card -->
<?php } else { // No record ?>
<div class="card border-0"><!-- .card -->
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php if ($Page->OtherOptions->visible()) { ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option) {
        $option->render("body");
    }
?>
</div>
<?php } ?>
</div><!-- /.card -->
<?php } ?>
<?php
foreach ($Page->DetailCounts as $detailTblVar => $detailCount) {
?>
<div class="ew-detail-count d-none" data-table="<?= $detailTblVar ?>" data-count="<?= $detailCount ?>"><?= FormatInteger($detailCount) ?></div>
<?php
}
?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
$Page->Recordset?->free();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
