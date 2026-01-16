<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoEmbalajePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_embalaje: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->fecha->Visible) { // fecha ?>
    <?php if (!$Page->fecha->Sortable || !$Page->sortUrl($Page->fecha)) { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><?= $Page->fecha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><div role="button" data-table="sco_embalaje" data-sort="<?= HtmlEncode($Page->fecha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->precinto1->Visible) { // precinto1 ?>
    <?php if (!$Page->precinto1->Sortable || !$Page->sortUrl($Page->precinto1)) { ?>
        <th class="<?= $Page->precinto1->headerCellClass() ?>"><?= $Page->precinto1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->precinto1->headerCellClass() ?>"><div role="button" data-table="sco_embalaje" data-sort="<?= HtmlEncode($Page->precinto1->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->precinto1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->precinto1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->precinto1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->precinto2->Visible) { // precinto2 ?>
    <?php if (!$Page->precinto2->Sortable || !$Page->sortUrl($Page->precinto2)) { ?>
        <th class="<?= $Page->precinto2->headerCellClass() ?>"><?= $Page->precinto2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->precinto2->headerCellClass() ?>"><div role="button" data-table="sco_embalaje" data-sort="<?= HtmlEncode($Page->precinto2->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->precinto2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->precinto2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->precinto2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
    <?php if (!$Page->fecha_servicio->Sortable || !$Page->sortUrl($Page->fecha_servicio)) { ?>
        <th class="<?= $Page->fecha_servicio->headerCellClass() ?>"><?= $Page->fecha_servicio->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha_servicio->headerCellClass() ?>"><div role="button" data-table="sco_embalaje" data-sort="<?= HtmlEncode($Page->fecha_servicio->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha_servicio->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha_servicio->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha_servicio->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <?php if (!$Page->_username->Sortable || !$Page->sortUrl($Page->_username)) { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><?= $Page->_username->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><div role="button" data-table="sco_embalaje" data-sort="<?= HtmlEncode($Page->_username->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_username->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_username->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_username->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->anulado->Visible) { // anulado ?>
    <?php if (!$Page->anulado->Sortable || !$Page->sortUrl($Page->anulado)) { ?>
        <th class="<?= $Page->anulado->headerCellClass() ?>"><?= $Page->anulado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->anulado->headerCellClass() ?>"><div role="button" data-table="sco_embalaje" data-sort="<?= HtmlEncode($Page->anulado->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->anulado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->anulado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->anulado->getSortIcon() ?></span>
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
<?php if ($Page->fecha->Visible) { // fecha ?>
        <!-- fecha -->
        <td<?= $Page->fecha->cellAttributes() ?>>
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->precinto1->Visible) { // precinto1 ?>
        <!-- precinto1 -->
        <td<?= $Page->precinto1->cellAttributes() ?>>
<span<?= $Page->precinto1->viewAttributes() ?>>
<?= $Page->precinto1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->precinto2->Visible) { // precinto2 ?>
        <!-- precinto2 -->
        <td<?= $Page->precinto2->cellAttributes() ?>>
<span<?= $Page->precinto2->viewAttributes() ?>>
<?= $Page->precinto2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha_servicio->Visible) { // fecha_servicio ?>
        <!-- fecha_servicio -->
        <td<?= $Page->fecha_servicio->cellAttributes() ?>>
<span<?= $Page->fecha_servicio->viewAttributes() ?>>
<?= $Page->fecha_servicio->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <!-- username -->
        <td<?= $Page->_username->cellAttributes() ?>>
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->anulado->Visible) { // anulado ?>
        <!-- anulado -->
        <td<?= $Page->anulado->cellAttributes() ?>>
<span<?= $Page->anulado->viewAttributes() ?>>
<?= $Page->anulado->getViewValue() ?></span>
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
