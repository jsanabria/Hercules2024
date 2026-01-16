<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoFlotaIncidenciaDetallePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_flota_incidencia_detalle: <?= JsonEncode($Page->toClientVar()) ?> } });
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
        <th class="<?= $Page->tipo->headerCellClass() ?>"><div role="button" data-table="sco_flota_incidencia_detalle" data-sort="<?= HtmlEncode($Page->tipo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tipo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <?php if (!$Page->archivo->Sortable || !$Page->sortUrl($Page->archivo)) { ?>
        <th class="<?= $Page->archivo->headerCellClass() ?>"><?= $Page->archivo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->archivo->headerCellClass() ?>"><div role="button" data-table="sco_flota_incidencia_detalle" data-sort="<?= HtmlEncode($Page->archivo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->archivo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->archivo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->archivo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <?php if (!$Page->proveedor->Sortable || !$Page->sortUrl($Page->proveedor)) { ?>
        <th class="<?= $Page->proveedor->headerCellClass() ?>"><?= $Page->proveedor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->proveedor->headerCellClass() ?>"><div role="button" data-table="sco_flota_incidencia_detalle" data-sort="<?= HtmlEncode($Page->proveedor->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->proveedor->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->proveedor->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->proveedor->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
    <?php if (!$Page->costo->Sortable || !$Page->sortUrl($Page->costo)) { ?>
        <th class="<?= $Page->costo->headerCellClass() ?>"><?= $Page->costo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->costo->headerCellClass() ?>"><div role="button" data-table="sco_flota_incidencia_detalle" data-sort="<?= HtmlEncode($Page->costo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->costo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->costo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->costo->getSortIcon() ?></span>
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
<?php if ($Page->archivo->Visible) { // archivo ?>
        <!-- archivo -->
        <td<?= $Page->archivo->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->archivo, $Page->archivo->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
        <!-- proveedor -->
        <td<?= $Page->proveedor->cellAttributes() ?>>
<span<?= $Page->proveedor->viewAttributes() ?>>
<?= $Page->proveedor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->costo->Visible) { // costo ?>
        <!-- costo -->
        <td<?= $Page->costo->cellAttributes() ?>>
<span<?= $Page->costo->viewAttributes() ?>>
<?= $Page->costo->getViewValue() ?></span>
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
