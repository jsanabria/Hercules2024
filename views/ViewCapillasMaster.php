<?php

namespace PHPMaker2024\hercules;

// Table
$view_capillas = Container("view_capillas");
$view_capillas->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($view_capillas->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_view_capillasmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($view_capillas->tipo->Visible) { // tipo ?>
        <tr id="r_tipo"<?= $view_capillas->tipo->rowAttributes() ?>>
            <td class="<?= $view_capillas->TableLeftColumnClass ?>"><?= $view_capillas->tipo->caption() ?></td>
            <td<?= $view_capillas->tipo->cellAttributes() ?>>
<span id="el_view_capillas_tipo">
<span<?= $view_capillas->tipo->viewAttributes() ?>>
<?= $view_capillas->tipo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_capillas->Nservicio->Visible) { // Nservicio ?>
        <tr id="r_Nservicio"<?= $view_capillas->Nservicio->rowAttributes() ?>>
            <td class="<?= $view_capillas->TableLeftColumnClass ?>"><?= $view_capillas->Nservicio->caption() ?></td>
            <td<?= $view_capillas->Nservicio->cellAttributes() ?>>
<span id="el_view_capillas_Nservicio">
<span<?= $view_capillas->Nservicio->viewAttributes() ?>>
<?= $view_capillas->Nservicio->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_capillas->nombre->Visible) { // nombre ?>
        <tr id="r_nombre"<?= $view_capillas->nombre->rowAttributes() ?>>
            <td class="<?= $view_capillas->TableLeftColumnClass ?>"><?= $view_capillas->nombre->caption() ?></td>
            <td<?= $view_capillas->nombre->cellAttributes() ?>>
<span id="el_view_capillas_nombre">
<span<?= $view_capillas->nombre->viewAttributes() ?>>
<?= $view_capillas->nombre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_capillas->secuencia->Visible) { // secuencia ?>
        <tr id="r_secuencia"<?= $view_capillas->secuencia->rowAttributes() ?>>
            <td class="<?= $view_capillas->TableLeftColumnClass ?>"><?= $view_capillas->secuencia->caption() ?></td>
            <td<?= $view_capillas->secuencia->cellAttributes() ?>>
<span id="el_view_capillas_secuencia">
<span<?= $view_capillas->secuencia->viewAttributes() ?>>
<?= $view_capillas->secuencia->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($view_capillas->activo->Visible) { // activo ?>
        <tr id="r_activo"<?= $view_capillas->activo->rowAttributes() ?>>
            <td class="<?= $view_capillas->TableLeftColumnClass ?>"><?= $view_capillas->activo->caption() ?></td>
            <td<?= $view_capillas->activo->cellAttributes() ?>>
<span id="el_view_capillas_activo">
<span<?= $view_capillas->activo->viewAttributes() ?>>
<?= $view_capillas->activo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
