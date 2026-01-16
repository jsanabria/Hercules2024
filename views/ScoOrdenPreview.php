<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoOrdenPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { sco_orden: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    // Write your table-specific client script here, no need to add script tags.
    window.offAllServ = function (id, username) { 
        if(confirm("Está seguro de apagar todos los servicios?")) { 
            window.location.href = "EliminarServicios?expediente=" + id + "&user=" + username;
        }
        /*
        alert(username);
    	$.ajax({
    	  url : "EliminarServicios",
    	  type: "GET",
    	  data : {expediente: id, user: username},
    	  beforeSend: function(){
    	  }
    	})
    	.done(function(data) {
    		alert( "Se apagaron todos los servicios " + data );
    		// $("#xFoto").html(data);
    	})
    	.fail(function(data) {
    		alert( "error" + data );
    	})
    	.always(function(data) {
    	});
        */
    };
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
    <?php if (!$Page->servicio_tipo->Sortable || !$Page->sortUrl($Page->servicio_tipo)) { ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><?= $Page->servicio_tipo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->servicio_tipo->headerCellClass() ?>"><div role="button" data-table="sco_orden" data-sort="<?= HtmlEncode($Page->servicio_tipo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->servicio_tipo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->servicio_tipo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->servicio_tipo->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
    <?php if (!$Page->servicio->Sortable || !$Page->sortUrl($Page->servicio)) { ?>
        <th class="<?= $Page->servicio->headerCellClass() ?>"><?= $Page->servicio->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->servicio->headerCellClass() ?>"><div role="button" data-table="sco_orden" data-sort="<?= HtmlEncode($Page->servicio->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->servicio->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->servicio->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->servicio->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
    <?php if (!$Page->cantidad->Sortable || !$Page->sortUrl($Page->cantidad)) { ?>
        <th class="<?= $Page->cantidad->headerCellClass() ?>"><?= $Page->cantidad->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cantidad->headerCellClass() ?>"><div role="button" data-table="sco_orden" data-sort="<?= HtmlEncode($Page->cantidad->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cantidad->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cantidad->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cantidad->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
    <?php if (!$Page->user_registra->Sortable || !$Page->sortUrl($Page->user_registra)) { ?>
        <th class="<?= $Page->user_registra->headerCellClass() ?>"><?= $Page->user_registra->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->user_registra->headerCellClass() ?>"><div role="button" data-table="sco_orden" data-sort="<?= HtmlEncode($Page->user_registra->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->user_registra->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->user_registra->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->user_registra->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ministro->Visible) { // ministro ?>
    <?php if (!$Page->ministro->Sortable || !$Page->sortUrl($Page->ministro)) { ?>
        <th class="<?= $Page->ministro->headerCellClass() ?>"><?= $Page->ministro->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ministro->headerCellClass() ?>"><div role="button" data-table="sco_orden" data-sort="<?= HtmlEncode($Page->ministro->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ministro->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ministro->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ministro->getSortIcon() ?></span>
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
<?php if ($Page->servicio_tipo->Visible) { // servicio_tipo ?>
        <!-- servicio_tipo -->
        <td<?= $Page->servicio_tipo->cellAttributes() ?>>
<span<?= $Page->servicio_tipo->viewAttributes() ?>>
<?= $Page->servicio_tipo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <!-- servicio -->
        <td<?= $Page->servicio->cellAttributes() ?>>
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cantidad->Visible) { // cantidad ?>
        <!-- cantidad -->
        <td<?= $Page->cantidad->cellAttributes() ?>>
<span<?= $Page->cantidad->viewAttributes() ?>>
<?= $Page->cantidad->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->user_registra->Visible) { // user_registra ?>
        <!-- user_registra -->
        <td<?= $Page->user_registra->cellAttributes() ?>>
<span<?= $Page->user_registra->viewAttributes() ?>>
<?= $Page->user_registra->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ministro->Visible) { // ministro ?>
        <!-- ministro -->
        <td<?= $Page->ministro->cellAttributes() ?>>
<span<?= $Page->ministro->viewAttributes() ?>>
<?= $Page->ministro->getViewValue() ?></span>
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
