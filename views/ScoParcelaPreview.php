<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_parcela: <?= JsonEncode($Page->toClientVar()) ?> } });
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
<?php if ($Page->Nparcela->Visible) { // Nparcela ?>
    <?php if (!$Page->Nparcela->Sortable || !$Page->sortUrl($Page->Nparcela)) { ?>
        <th class="<?= $Page->Nparcela->headerCellClass() ?>"><?= $Page->Nparcela->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->Nparcela->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->Nparcela->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->Nparcela->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->Nparcela->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->Nparcela->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nacionalidad->Visible) { // nacionalidad ?>
    <?php if (!$Page->nacionalidad->Sortable || !$Page->sortUrl($Page->nacionalidad)) { ?>
        <th class="<?= $Page->nacionalidad->headerCellClass() ?>"><?= $Page->nacionalidad->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nacionalidad->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->nacionalidad->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nacionalidad->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nacionalidad->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nacionalidad->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
    <?php if (!$Page->cedula->Sortable || !$Page->sortUrl($Page->cedula)) { ?>
        <th class="<?= $Page->cedula->headerCellClass() ?>"><?= $Page->cedula->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cedula->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->cedula->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cedula->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cedula->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cedula->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <?php if (!$Page->titular->Sortable || !$Page->sortUrl($Page->titular)) { ?>
        <th class="<?= $Page->titular->headerCellClass() ?>"><?= $Page->titular->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->titular->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->titular->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->titular->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->titular->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->titular->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
    <?php if (!$Page->contrato->Sortable || !$Page->sortUrl($Page->contrato)) { ?>
        <th class="<?= $Page->contrato->headerCellClass() ?>"><?= $Page->contrato->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->contrato->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->contrato->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->contrato->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->contrato->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->contrato->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <?php if (!$Page->seccion->Sortable || !$Page->sortUrl($Page->seccion)) { ?>
        <th class="<?= $Page->seccion->headerCellClass() ?>"><?= $Page->seccion->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->seccion->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->seccion->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->seccion->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->seccion->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->seccion->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <?php if (!$Page->modulo->Sortable || !$Page->sortUrl($Page->modulo)) { ?>
        <th class="<?= $Page->modulo->headerCellClass() ?>"><?= $Page->modulo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->modulo->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->modulo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->modulo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->modulo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->modulo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <?php if (!$Page->sub_seccion->Sortable || !$Page->sortUrl($Page->sub_seccion)) { ?>
        <th class="<?= $Page->sub_seccion->headerCellClass() ?>"><?= $Page->sub_seccion->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sub_seccion->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->sub_seccion->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sub_seccion->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->sub_seccion->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->sub_seccion->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <?php if (!$Page->parcela->Sortable || !$Page->sortUrl($Page->parcela)) { ?>
        <th class="<?= $Page->parcela->headerCellClass() ?>"><?= $Page->parcela->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->parcela->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->parcela->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->parcela->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->parcela->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->parcela->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <?php if (!$Page->boveda->Sortable || !$Page->sortUrl($Page->boveda)) { ?>
        <th class="<?= $Page->boveda->headerCellClass() ?>"><?= $Page->boveda->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->boveda->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->boveda->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->boveda->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->boveda->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->boveda->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
    <?php if (!$Page->apellido1->Sortable || !$Page->sortUrl($Page->apellido1)) { ?>
        <th class="<?= $Page->apellido1->headerCellClass() ?>"><?= $Page->apellido1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->apellido1->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->apellido1->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->apellido1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->apellido1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->apellido1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
    <?php if (!$Page->apellido2->Sortable || !$Page->sortUrl($Page->apellido2)) { ?>
        <th class="<?= $Page->apellido2->headerCellClass() ?>"><?= $Page->apellido2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->apellido2->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->apellido2->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->apellido2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->apellido2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->apellido2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
    <?php if (!$Page->nombre1->Sortable || !$Page->sortUrl($Page->nombre1)) { ?>
        <th class="<?= $Page->nombre1->headerCellClass() ?>"><?= $Page->nombre1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nombre1->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->nombre1->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nombre1->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nombre1->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nombre1->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
    <?php if (!$Page->nombre2->Sortable || !$Page->sortUrl($Page->nombre2)) { ?>
        <th class="<?= $Page->nombre2->headerCellClass() ?>"><?= $Page->nombre2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nombre2->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->nombre2->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nombre2->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nombre2->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nombre2->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
    <?php if (!$Page->fecha_inhumacion->Sortable || !$Page->sortUrl($Page->fecha_inhumacion)) { ?>
        <th class="<?= $Page->fecha_inhumacion->headerCellClass() ?>"><?= $Page->fecha_inhumacion->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha_inhumacion->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->fecha_inhumacion->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fecha_inhumacion->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->fecha_inhumacion->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->fecha_inhumacion->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
    <?php if (!$Page->funeraria->Sortable || !$Page->sortUrl($Page->funeraria)) { ?>
        <th class="<?= $Page->funeraria->headerCellClass() ?>"><?= $Page->funeraria->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->funeraria->headerCellClass() ?>"><div role="button" data-table="sco_parcela" data-sort="<?= HtmlEncode($Page->funeraria->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->funeraria->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->funeraria->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->funeraria->getSortIcon() ?></span>
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
<?php if ($Page->Nparcela->Visible) { // Nparcela ?>
        <!-- Nparcela -->
        <td<?= $Page->Nparcela->cellAttributes() ?>>
<span<?= $Page->Nparcela->viewAttributes() ?>>
<?= $Page->Nparcela->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nacionalidad->Visible) { // nacionalidad ?>
        <!-- nacionalidad -->
        <td<?= $Page->nacionalidad->cellAttributes() ?>>
<span<?= $Page->nacionalidad->viewAttributes() ?>>
<?= $Page->nacionalidad->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cedula->Visible) { // cedula ?>
        <!-- cedula -->
        <td<?= $Page->cedula->cellAttributes() ?>>
<span<?= $Page->cedula->viewAttributes() ?>>
<?= $Page->cedula->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
        <!-- titular -->
        <td<?= $Page->titular->cellAttributes() ?>>
<span<?= $Page->titular->viewAttributes() ?>>
<?= $Page->titular->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->contrato->Visible) { // contrato ?>
        <!-- contrato -->
        <td<?= $Page->contrato->cellAttributes() ?>>
<span<?= $Page->contrato->viewAttributes() ?>>
<?= $Page->contrato->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
        <!-- seccion -->
        <td<?= $Page->seccion->cellAttributes() ?>>
<span<?= $Page->seccion->viewAttributes() ?>>
<?= $Page->seccion->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
        <!-- modulo -->
        <td<?= $Page->modulo->cellAttributes() ?>>
<span<?= $Page->modulo->viewAttributes() ?>>
<?= $Page->modulo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
        <!-- sub_seccion -->
        <td<?= $Page->sub_seccion->cellAttributes() ?>>
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<?= $Page->sub_seccion->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
        <!-- parcela -->
        <td<?= $Page->parcela->cellAttributes() ?>>
<span<?= $Page->parcela->viewAttributes() ?>>
<?= $Page->parcela->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
        <!-- boveda -->
        <td<?= $Page->boveda->cellAttributes() ?>>
<span<?= $Page->boveda->viewAttributes() ?>>
<?= $Page->boveda->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
        <!-- apellido1 -->
        <td<?= $Page->apellido1->cellAttributes() ?>>
<span<?= $Page->apellido1->viewAttributes() ?>>
<?= $Page->apellido1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
        <!-- apellido2 -->
        <td<?= $Page->apellido2->cellAttributes() ?>>
<span<?= $Page->apellido2->viewAttributes() ?>>
<?= $Page->apellido2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
        <!-- nombre1 -->
        <td<?= $Page->nombre1->cellAttributes() ?>>
<span<?= $Page->nombre1->viewAttributes() ?>>
<?= $Page->nombre1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
        <!-- nombre2 -->
        <td<?= $Page->nombre2->cellAttributes() ?>>
<span<?= $Page->nombre2->viewAttributes() ?>>
<?= $Page->nombre2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha_inhumacion->Visible) { // fecha_inhumacion ?>
        <!-- fecha_inhumacion -->
        <td<?= $Page->fecha_inhumacion->cellAttributes() ?>>
<span<?= $Page->fecha_inhumacion->viewAttributes() ?>>
<?= $Page->fecha_inhumacion->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->funeraria->Visible) { // funeraria ?>
        <!-- funeraria -->
        <td<?= $Page->funeraria->cellAttributes() ?>>
<span<?= $Page->funeraria->viewAttributes() ?>>
<?= $Page->funeraria->getViewValue() ?></span>
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
