<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenCompraDetallePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_orden_compra_detalle: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
    <?php if (!$Page->tipo_insumo->Sortable || !$Page->sortUrl($Page->tipo_insumo)) { ?>
        <th class="<?= $Page->tipo_insumo->headerCellClass() ?>"><?= $Page->tipo_insumo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tipo_insumo->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->tipo_insumo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tipo_insumo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo_insumo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo_insumo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
    <?php if (!$Page->articulo->Sortable || !$Page->sortUrl($Page->articulo)) { ?>
        <th class="<?= $Page->articulo->headerCellClass() ?>"><?= $Page->articulo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->articulo->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->articulo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->articulo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->articulo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->articulo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
    <?php if (!$Page->unidad_medida->Sortable || !$Page->sortUrl($Page->unidad_medida)) { ?>
        <th class="<?= $Page->unidad_medida->headerCellClass() ?>"><?= $Page->unidad_medida->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->unidad_medida->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->unidad_medida->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->unidad_medida->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->unidad_medida->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->unidad_medida->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <?php if (!$Page->cantidad->Sortable || !$Page->sortUrl($Page->cantidad)) { ?>
        <th class="<?= $Page->cantidad->headerCellClass() ?>"><?= $Page->cantidad->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cantidad->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->cantidad->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cantidad->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cantidad->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cantidad->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
    <?php if (!$Page->descripcion->Sortable || !$Page->sortUrl($Page->descripcion)) { ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><?= $Page->descripcion->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->descripcion->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->descripcion->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->descripcion->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->descripcion->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->descripcion->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
    <?php if (!$Page->imagen->Sortable || !$Page->sortUrl($Page->imagen)) { ?>
        <th class="<?= $Page->imagen->headerCellClass() ?>"><?= $Page->imagen->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->imagen->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->imagen->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->imagen->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->imagen->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->imagen->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
    <?php if (!$Page->disponible->Sortable || !$Page->sortUrl($Page->disponible)) { ?>
        <th class="<?= $Page->disponible->headerCellClass() ?>"><?= $Page->disponible->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->disponible->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->disponible->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->disponible->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->disponible->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->disponible->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
    <?php if (!$Page->unidad_medida_recibida->Sortable || !$Page->sortUrl($Page->unidad_medida_recibida)) { ?>
        <th class="<?= $Page->unidad_medida_recibida->headerCellClass() ?>"><?= $Page->unidad_medida_recibida->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->unidad_medida_recibida->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->unidad_medida_recibida->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->unidad_medida_recibida->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->unidad_medida_recibida->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->unidad_medida_recibida->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
    <?php if (!$Page->cantidad_recibida->Sortable || !$Page->sortUrl($Page->cantidad_recibida)) { ?>
        <th class="<?= $Page->cantidad_recibida->headerCellClass() ?>"><?= $Page->cantidad_recibida->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cantidad_recibida->headerCellClass() ?>"><div role="button" data-table="sco_orden_compra_detalle" data-sort="<?= HtmlEncode($Page->cantidad_recibida->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cantidad_recibida->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cantidad_recibida->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cantidad_recibida->getSortIcon() ?></span>
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
<?php if ($Page->tipo_insumo->Visible) { // tipo_insumo ?>
        <!-- tipo_insumo -->
        <td<?= $Page->tipo_insumo->cellAttributes() ?>>
<span<?= $Page->tipo_insumo->viewAttributes() ?>>
<?= $Page->tipo_insumo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->articulo->Visible) { // articulo ?>
        <!-- articulo -->
        <td<?= $Page->articulo->cellAttributes() ?>>
<span<?= $Page->articulo->viewAttributes() ?>>
<?= $Page->articulo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->unidad_medida->Visible) { // unidad_medida ?>
        <!-- unidad_medida -->
        <td<?= $Page->unidad_medida->cellAttributes() ?>>
<span<?= $Page->unidad_medida->viewAttributes() ?>>
<?= $Page->unidad_medida->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
        <!-- cantidad -->
        <td<?= $Page->cantidad->cellAttributes() ?>>
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->descripcion->Visible) { // descripcion ?>
        <!-- descripcion -->
        <td<?= $Page->descripcion->cellAttributes() ?>>
<span<?= $Page->descripcion->viewAttributes() ?>>
<?= $Page->descripcion->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->imagen->Visible) { // imagen ?>
        <!-- imagen -->
        <td<?= $Page->imagen->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->imagen, $Page->imagen->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->disponible->Visible) { // disponible ?>
        <!-- disponible -->
        <td<?= $Page->disponible->cellAttributes() ?>>
<span<?= $Page->disponible->viewAttributes() ?>>
<?= $Page->disponible->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->unidad_medida_recibida->Visible) { // unidad_medida_recibida ?>
        <!-- unidad_medida_recibida -->
        <td<?= $Page->unidad_medida_recibida->cellAttributes() ?>>
<span<?= $Page->unidad_medida_recibida->viewAttributes() ?>>
<?= $Page->unidad_medida_recibida->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cantidad_recibida->Visible) { // cantidad_recibida ?>
        <!-- cantidad_recibida -->
        <td<?= $Page->cantidad_recibida->cellAttributes() ?>>
<span<?= $Page->cantidad_recibida->viewAttributes() ?>>
<?= $Page->cantidad_recibida->getViewValue() ?></span>
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
