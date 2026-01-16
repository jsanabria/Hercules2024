<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoExpedienteCiaPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_expediente_cia: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->cia->Visible) { // cia ?>
    <?php if (!$Page->cia->Sortable || !$Page->sortUrl($Page->cia)) { ?>
        <th class="<?= $Page->cia->headerCellClass() ?>"><?= $Page->cia->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cia->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->cia->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cia->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cia->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cia->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
    <?php if (!$Page->expediente->Sortable || !$Page->sortUrl($Page->expediente)) { ?>
        <th class="<?= $Page->expediente->headerCellClass() ?>"><?= $Page->expediente->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->expediente->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->expediente->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->expediente->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->expediente->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->expediente->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <?php if (!$Page->servicio_tipo->Sortable || !$Page->sortUrl($Page->servicio_tipo)) { ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><?= $Page->servicio_tipo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->servicio_tipo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->servicio_tipo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->servicio_tipo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->servicio_tipo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
    <?php if (!$Page->factura->Sortable || !$Page->sortUrl($Page->factura)) { ?>
        <th class="<?= $Page->factura->headerCellClass() ?>"><?= $Page->factura->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->factura->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->factura->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->factura->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->factura->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->factura->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <?php if (!$Page->fecha->Sortable || !$Page->sortUrl($Page->fecha)) { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><?= $Page->fecha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->fecha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha->getNextSort() ?>">
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
        <th class="<?= $Page->monto->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->monto->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->monto->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->monto->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->monto->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <?php if (!$Page->nota->Sortable || !$Page->sortUrl($Page->nota)) { ?>
        <th class="<?= $Page->nota->headerCellClass() ?>"><?= $Page->nota->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nota->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->nota->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nota->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nota->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nota->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <?php if (!$Page->_username->Sortable || !$Page->sortUrl($Page->_username)) { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><?= $Page->_username->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->_username->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_username->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_username->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_username->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <?php if (!$Page->estatus->Sortable || !$Page->sortUrl($Page->estatus)) { ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><?= $Page->estatus->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->estatus->headerCellClass() ?>"><div role="button" data-table="sco_expediente_cia" data-sort="<?= HtmlEncode($Page->estatus->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->estatus->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->estatus->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->estatus->getSortIcon() ?></span>
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
<?php if ($Page->cia->Visible) { // cia ?>
        <!-- cia -->
        <td<?= $Page->cia->cellAttributes() ?>>
<span<?= $Page->cia->viewAttributes() ?>>
<?= $Page->cia->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->expediente->Visible) { // expediente ?>
        <!-- expediente -->
        <td<?= $Page->expediente->cellAttributes() ?>>
<span<?= $Page->expediente->viewAttributes() ?>>
<?= $Page->expediente->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <!-- servicio_tipo -->
        <td<?= $Page->servicio_tipo->cellAttributes() ?>>
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->factura->Visible) { // factura ?>
        <!-- factura -->
        <td<?= $Page->factura->cellAttributes() ?>>
<span<?= $Page->factura->viewAttributes() ?>>
<?= $Page->factura->getViewValue() ?></span>
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
<?php if ($Page->nota->Visible) { // nota ?>
        <!-- nota -->
        <td<?= $Page->nota->cellAttributes() ?>>
<span<?= $Page->nota->viewAttributes() ?>>
<?= $Page->nota->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <!-- username -->
        <td<?= $Page->_username->cellAttributes() ?>>
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
        <!-- estatus -->
        <td<?= $Page->estatus->cellAttributes() ?>>
<span<?= $Page->estatus->viewAttributes() ?>>
<?= $Page->estatus->getViewValue() ?></span>
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
