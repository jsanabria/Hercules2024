<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGramaPagosPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_grama_pagos: <?= JsonEncode($Page->toClientVar()) ?> } });
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
        <th class="<?= $Page->tipo->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->tipo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tipo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tipo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tipo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->banco->Visible) { // banco ?>
    <?php if (!$Page->banco->Sortable || !$Page->sortUrl($Page->banco)) { ?>
        <th class="<?= $Page->banco->headerCellClass() ?>"><?= $Page->banco->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->banco->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->banco->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->banco->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->banco->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->banco->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ref->Visible) { // ref ?>
    <?php if (!$Page->ref->Sortable || !$Page->sortUrl($Page->ref)) { ?>
        <th class="<?= $Page->ref->headerCellClass() ?>"><?= $Page->ref->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ref->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->ref->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ref->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ref->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ref->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <?php if (!$Page->fecha->Sortable || !$Page->sortUrl($Page->fecha)) { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><?= $Page->fecha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->fecha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <?php if (!$Page->monto->Sortable || !$Page->sortUrl($Page->monto)) { ?>
        <th class="<?= $Page->monto->headerCellClass() ?>"><?= $Page->monto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->monto->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->monto->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->monto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->monto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->monto->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
    <?php if (!$Page->moneda->Sortable || !$Page->sortUrl($Page->moneda)) { ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><?= $Page->moneda->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->moneda->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->moneda->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->moneda->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->moneda->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->moneda->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <?php if (!$Page->tasa->Sortable || !$Page->sortUrl($Page->tasa)) { ?>
        <th class="<?= $Page->tasa->headerCellClass() ?>"><?= $Page->tasa->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tasa->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->tasa->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tasa->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->tasa->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->tasa->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
    <?php if (!$Page->monto_bs->Sortable || !$Page->sortUrl($Page->monto_bs)) { ?>
        <th class="<?= $Page->monto_bs->headerCellClass() ?>"><?= $Page->monto_bs->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->monto_bs->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->monto_bs->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->monto_bs->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->monto_bs->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->monto_bs->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cta_destino->Visible) { // cta_destino ?>
    <?php if (!$Page->cta_destino->Sortable || !$Page->sortUrl($Page->cta_destino)) { ?>
        <th class="<?= $Page->cta_destino->headerCellClass() ?>"><?= $Page->cta_destino->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cta_destino->headerCellClass() ?>"><div role="button" data-table="sco_grama_pagos" data-sort="<?= HtmlEncode($Page->cta_destino->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cta_destino->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cta_destino->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cta_destino->getSortIcon() ?></span>
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
<?php if ($Page->banco->Visible) { // banco ?>
        <!-- banco -->
        <td<?= $Page->banco->cellAttributes() ?>>
<span<?= $Page->banco->viewAttributes() ?>>
<?= $Page->banco->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ref->Visible) { // ref ?>
        <!-- ref -->
        <td<?= $Page->ref->cellAttributes() ?>>
<span<?= $Page->ref->viewAttributes() ?>>
<?= $Page->ref->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <!-- fecha -->
        <td<?= $Page->fecha->cellAttributes() ?>>
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
        <!-- monto -->
        <td<?= $Page->monto->cellAttributes() ?>>
<span<?= $Page->monto->viewAttributes() ?>>
<?= $Page->monto->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->moneda->Visible) { // moneda ?>
        <!-- moneda -->
        <td<?= $Page->moneda->cellAttributes() ?>>
<span<?= $Page->moneda->viewAttributes() ?>>
<?= $Page->moneda->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
        <!-- tasa -->
        <td<?= $Page->tasa->cellAttributes() ?>>
<span<?= $Page->tasa->viewAttributes() ?>>
<?= $Page->tasa->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
        <!-- monto_bs -->
        <td<?= $Page->monto_bs->cellAttributes() ?>>
<span<?= $Page->monto_bs->viewAttributes() ?>>
<?= $Page->monto_bs->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cta_destino->Visible) { // cta_destino ?>
        <!-- cta_destino -->
        <td<?= $Page->cta_destino->cellAttributes() ?>>
<span<?= $Page->cta_destino->viewAttributes() ?>>
<?= $Page->cta_destino->getViewValue() ?></span>
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
