<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCremacionEstatusPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_cremacion_estatus: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->estatus->Visible) { // estatus ?>
    <?php if (!$Page->estatus->Sortable || !$Page->sortUrl($Page->estatus)) { ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><?= $Page->estatus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><div role="button" data-table="sco_cremacion_estatus" data-sort="<?= HtmlEncode($Page->estatus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->estatus->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->estatus->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->estatus->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
    <?php if (!$Page->fecha_hora->Sortable || !$Page->sortUrl($Page->fecha_hora)) { ?>
        <th class="<?= $Page->fecha_hora->headerCellClass() ?>"><?= $Page->fecha_hora->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha_hora->headerCellClass() ?>"><div role="button" data-table="sco_cremacion_estatus" data-sort="<?= HtmlEncode($Page->fecha_hora->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha_hora->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha_hora->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha_hora->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <?php if (!$Page->_username->Sortable || !$Page->sortUrl($Page->_username)) { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><?= $Page->_username->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><div role="button" data-table="sco_cremacion_estatus" data-sort="<?= HtmlEncode($Page->_username->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_username->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_username->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_username->getSortIcon() ?></span>
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
<?php if ($Page->estatus->Visible) { // estatus ?>
        <!-- estatus -->
        <td<?= $Page->estatus->cellAttributes() ?>>
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha_hora->Visible) { // fecha_hora ?>
        <!-- fecha_hora -->
        <td<?= $Page->fecha_hora->cellAttributes() ?>>
<span<?= $Page->fecha_hora->viewAttributes() ?>>
<?= $Page->fecha_hora->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <!-- username -->
        <td<?= $Page->_username->cellAttributes() ?>>
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
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
