<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosTarifaDetallePreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_costos_tarifa_detalle: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->cap->Visible) { // cap ?>
    <?php if (!$Page->cap->Sortable || !$Page->sortUrl($Page->cap)) { ?>
        <th class="<?= $Page->cap->headerCellClass() ?>"><?= $Page->cap->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cap->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->cap->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cap->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cap->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cap->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
    <?php if (!$Page->ata->Sortable || !$Page->sortUrl($Page->ata)) { ?>
        <th class="<?= $Page->ata->headerCellClass() ?>"><?= $Page->ata->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ata->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->ata->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ata->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ata->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ata->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
    <?php if (!$Page->obi->Sortable || !$Page->sortUrl($Page->obi)) { ?>
        <th class="<?= $Page->obi->headerCellClass() ?>"><?= $Page->obi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->obi->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->obi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->obi->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->obi->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->obi->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
    <?php if (!$Page->fot->Sortable || !$Page->sortUrl($Page->fot)) { ?>
        <th class="<?= $Page->fot->headerCellClass() ?>"><?= $Page->fot->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fot->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->fot->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fot->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fot->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fot->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
    <?php if (!$Page->man->Sortable || !$Page->sortUrl($Page->man)) { ?>
        <th class="<?= $Page->man->headerCellClass() ?>"><?= $Page->man->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->man->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->man->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->man->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->man->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->man->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
    <?php if (!$Page->gas->Sortable || !$Page->sortUrl($Page->gas)) { ?>
        <th class="<?= $Page->gas->headerCellClass() ?>"><?= $Page->gas->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->gas->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->gas->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->gas->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->gas->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->gas->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
    <?php if (!$Page->com->Sortable || !$Page->sortUrl($Page->com)) { ?>
        <th class="<?= $Page->com->headerCellClass() ?>"><?= $Page->com->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->com->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->com->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->com->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->com->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->com->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->base->Visible) { // base ?>
    <?php if (!$Page->base->Sortable || !$Page->sortUrl($Page->base)) { ?>
        <th class="<?= $Page->base->headerCellClass() ?>"><?= $Page->base->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->base->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->base->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->base->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->base->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->base->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->base_anterior->Visible) { // base_anterior ?>
    <?php if (!$Page->base_anterior->Sortable || !$Page->sortUrl($Page->base_anterior)) { ?>
        <th class="<?= $Page->base_anterior->headerCellClass() ?>"><?= $Page->base_anterior->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->base_anterior->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->base_anterior->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->base_anterior->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->base_anterior->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->base_anterior->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
    <?php if (!$Page->variacion->Sortable || !$Page->sortUrl($Page->variacion)) { ?>
        <th class="<?= $Page->variacion->headerCellClass() ?>"><?= $Page->variacion->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->variacion->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->variacion->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->variacion->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->variacion->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->variacion->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
    <?php if (!$Page->porcentaje->Sortable || !$Page->sortUrl($Page->porcentaje)) { ?>
        <th class="<?= $Page->porcentaje->headerCellClass() ?>"><?= $Page->porcentaje->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->porcentaje->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->porcentaje->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->porcentaje->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->porcentaje->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->porcentaje->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <?php if (!$Page->fecha->Sortable || !$Page->sortUrl($Page->fecha)) { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><?= $Page->fecha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->fecha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
    <?php if (!$Page->cerrado->Sortable || !$Page->sortUrl($Page->cerrado)) { ?>
        <th class="<?= $Page->cerrado->headerCellClass() ?>"><?= $Page->cerrado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cerrado->headerCellClass() ?>"><div role="button" data-table="sco_costos_tarifa_detalle" data-sort="<?= HtmlEncode($Page->cerrado->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cerrado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cerrado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cerrado->getSortIcon() ?></span>
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
<?php if ($Page->cap->Visible) { // cap ?>
        <!-- cap -->
        <td<?= $Page->cap->cellAttributes() ?>>
<span<?= $Page->cap->viewAttributes() ?>>
<?= $Page->cap->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ata->Visible) { // ata ?>
        <!-- ata -->
        <td<?= $Page->ata->cellAttributes() ?>>
<span<?= $Page->ata->viewAttributes() ?>>
<?= $Page->ata->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->obi->Visible) { // obi ?>
        <!-- obi -->
        <td<?= $Page->obi->cellAttributes() ?>>
<span<?= $Page->obi->viewAttributes() ?>>
<?= $Page->obi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fot->Visible) { // fot ?>
        <!-- fot -->
        <td<?= $Page->fot->cellAttributes() ?>>
<span<?= $Page->fot->viewAttributes() ?>>
<?= $Page->fot->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->man->Visible) { // man ?>
        <!-- man -->
        <td<?= $Page->man->cellAttributes() ?>>
<span<?= $Page->man->viewAttributes() ?>>
<?= $Page->man->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->gas->Visible) { // gas ?>
        <!-- gas -->
        <td<?= $Page->gas->cellAttributes() ?>>
<span<?= $Page->gas->viewAttributes() ?>>
<?= $Page->gas->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->com->Visible) { // com ?>
        <!-- com -->
        <td<?= $Page->com->cellAttributes() ?>>
<span<?= $Page->com->viewAttributes() ?>>
<?= $Page->com->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->base->Visible) { // base ?>
        <!-- base -->
        <td<?= $Page->base->cellAttributes() ?>>
<span<?= $Page->base->viewAttributes() ?>>
<?= $Page->base->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->base_anterior->Visible) { // base_anterior ?>
        <!-- base_anterior -->
        <td<?= $Page->base_anterior->cellAttributes() ?>>
<span<?= $Page->base_anterior->viewAttributes() ?>>
<?= $Page->base_anterior->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->variacion->Visible) { // variacion ?>
        <!-- variacion -->
        <td<?= $Page->variacion->cellAttributes() ?>>
<span<?= $Page->variacion->viewAttributes() ?>>
<?= $Page->variacion->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->porcentaje->Visible) { // porcentaje ?>
        <!-- porcentaje -->
        <td<?= $Page->porcentaje->cellAttributes() ?>>
<span<?= $Page->porcentaje->viewAttributes() ?>>
<?= $Page->porcentaje->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <!-- fecha -->
        <td<?= $Page->fecha->cellAttributes() ?>>
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
        <!-- cerrado -->
        <td<?= $Page->cerrado->cellAttributes() ?>>
<span<?= $Page->cerrado->viewAttributes() ?>>
<?= $Page->cerrado->getViewValue() ?></span>
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
