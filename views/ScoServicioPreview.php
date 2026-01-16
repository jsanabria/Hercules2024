<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoServicioPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_servicio: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->tipo->Visible) { // tipo ?>
    <?php if (!$Page->tipo->Sortable || !$Page->sortUrl($Page->tipo)) { ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><?= $Page->tipo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tipo->headerCellClass() ?>"><div role="button" data-table="sco_servicio" data-sort="<?= HtmlEncode($Page->tipo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tipo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->Nservicio->Visible) { // Nservicio ?>
    <?php if (!$Page->Nservicio->Sortable || !$Page->sortUrl($Page->Nservicio)) { ?>
        <th class="<?= $Page->Nservicio->headerCellClass() ?>"><?= $Page->Nservicio->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nservicio->headerCellClass() ?>"><div role="button" data-table="sco_servicio" data-sort="<?= HtmlEncode($Page->Nservicio->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nservicio->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nservicio->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nservicio->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <?php if (!$Page->nombre->Sortable || !$Page->sortUrl($Page->nombre)) { ?>
        <th class="<?= $Page->nombre->headerCellClass() ?>"><?= $Page->nombre->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nombre->headerCellClass() ?>"><div role="button" data-table="sco_servicio" data-sort="<?= HtmlEncode($Page->nombre->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nombre->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nombre->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nombre->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <?php if (!$Page->activo->Sortable || !$Page->sortUrl($Page->activo)) { ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><?= $Page->activo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->activo->headerCellClass() ?>"><div role="button" data-table="sco_servicio" data-sort="<?= HtmlEncode($Page->activo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->activo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->activo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->activo->getSortIcon() ?></span>
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
<?php if ($Page->tipo->Visible) { // tipo ?>
        <!-- tipo -->
        <td<?= $Page->tipo->cellAttributes() ?>>
<span<?= $Page->tipo->viewAttributes() ?>>
<?= $Page->tipo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->Nservicio->Visible) { // Nservicio ?>
        <!-- Nservicio -->
        <td<?= $Page->Nservicio->cellAttributes() ?>>
<span<?= $Page->Nservicio->viewAttributes() ?>>
<?= $Page->Nservicio->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
        <!-- nombre -->
        <td<?= $Page->nombre->cellAttributes() ?>>
<span<?= $Page->nombre->viewAttributes() ?>>
<?= $Page->nombre->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
        <!-- activo -->
        <td<?= $Page->activo->cellAttributes() ?>>
<span<?= $Page->activo->viewAttributes() ?>>
<?= $Page->activo->getViewValue() ?></span>
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
