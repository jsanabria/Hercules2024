<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReembolsoPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_reembolso: <?= JsonEncode($Page->toClientVar()) ?> } });
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
        <th class="<?= $Page->fecha->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->fecha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->monto_usd->Visible) { // monto_usd ?>
    <?php if (!$Page->monto_usd->Sortable || !$Page->sortUrl($Page->monto_usd)) { ?>
        <th class="<?= $Page->monto_usd->headerCellClass() ?>"><?= $Page->monto_usd->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->monto_usd->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->monto_usd->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->monto_usd->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->monto_usd->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->monto_usd->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
    <?php if (!$Page->monto_bs->Sortable || !$Page->sortUrl($Page->monto_bs)) { ?>
        <th class="<?= $Page->monto_bs->headerCellClass() ?>"><?= $Page->monto_bs->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->monto_bs->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->monto_bs->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->monto_bs->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->monto_bs->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->monto_bs->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <?php if (!$Page->titular->Sortable || !$Page->sortUrl($Page->titular)) { ?>
        <th class="<?= $Page->titular->headerCellClass() ?>"><?= $Page->titular->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->titular->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->titular->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->titular->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->titular->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->titular->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nro_ref->Visible) { // nro_ref ?>
    <?php if (!$Page->nro_ref->Sortable || !$Page->sortUrl($Page->nro_ref)) { ?>
        <th class="<?= $Page->nro_ref->headerCellClass() ?>"><?= $Page->nro_ref->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nro_ref->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->nro_ref->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nro_ref->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nro_ref->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nro_ref->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <?php if (!$Page->motivo->Sortable || !$Page->sortUrl($Page->motivo)) { ?>
        <th class="<?= $Page->motivo->headerCellClass() ?>"><?= $Page->motivo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->motivo->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->motivo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->motivo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->motivo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->motivo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <?php if (!$Page->estatus->Sortable || !$Page->sortUrl($Page->estatus)) { ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><?= $Page->estatus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->estatus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->estatus->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->estatus->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->estatus->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->coordinador->Visible) { // coordinador ?>
    <?php if (!$Page->coordinador->Sortable || !$Page->sortUrl($Page->coordinador)) { ?>
        <th class="<?= $Page->coordinador->headerCellClass() ?>"><?= $Page->coordinador->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->coordinador->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->coordinador->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->coordinador->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->coordinador->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->coordinador->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha_pago->Visible) { // fecha_pago ?>
    <?php if (!$Page->fecha_pago->Sortable || !$Page->sortUrl($Page->fecha_pago)) { ?>
        <th class="<?= $Page->fecha_pago->headerCellClass() ?>"><?= $Page->fecha_pago->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha_pago->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->fecha_pago->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha_pago->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha_pago->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha_pago->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->email_enviado->Visible) { // email_enviado ?>
    <?php if (!$Page->email_enviado->Sortable || !$Page->sortUrl($Page->email_enviado)) { ?>
        <th class="<?= $Page->email_enviado->headerCellClass() ?>"><?= $Page->email_enviado->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->email_enviado->headerCellClass() ?>"><div role="button" data-table="sco_reembolso" data-sort="<?= HtmlEncode($Page->email_enviado->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->email_enviado->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->email_enviado->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->email_enviado->getSortIcon() ?></span>
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
<?php if ($Page->monto_usd->Visible) { // monto_usd ?>
        <!-- monto_usd -->
        <td<?= $Page->monto_usd->cellAttributes() ?>>
<span<?= $Page->monto_usd->viewAttributes() ?>>
<?= $Page->monto_usd->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->monto_bs->Visible) { // monto_bs ?>
        <!-- monto_bs -->
        <td<?= $Page->monto_bs->cellAttributes() ?>>
<span<?= $Page->monto_bs->viewAttributes() ?>>
<?= $Page->monto_bs->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
        <!-- titular -->
        <td<?= $Page->titular->cellAttributes() ?>>
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nro_ref->Visible) { // nro_ref ?>
        <!-- nro_ref -->
        <td<?= $Page->nro_ref->cellAttributes() ?>>
<span<?= $Page->nro_ref->viewAttributes() ?>>
<?= $Page->nro_ref->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
        <!-- motivo -->
        <td<?= $Page->motivo->cellAttributes() ?>>
<span<?= $Page->motivo->viewAttributes() ?>>
<?= $Page->motivo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <!-- estatus -->
        <td<?= $Page->estatus->cellAttributes() ?>>
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->coordinador->Visible) { // coordinador ?>
        <!-- coordinador -->
        <td<?= $Page->coordinador->cellAttributes() ?>>
<span<?= $Page->coordinador->viewAttributes() ?>>
<?= $Page->coordinador->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha_pago->Visible) { // fecha_pago ?>
        <!-- fecha_pago -->
        <td<?= $Page->fecha_pago->cellAttributes() ?>>
<span<?= $Page->fecha_pago->viewAttributes() ?>>
<?= $Page->fecha_pago->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->email_enviado->Visible) { // email_enviado ?>
        <!-- email_enviado -->
        <td<?= $Page->email_enviado->cellAttributes() ?>>
<span<?= $Page->email_enviado->viewAttributes() ?>>
<?= $Page->email_enviado->getViewValue() ?></span>
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
