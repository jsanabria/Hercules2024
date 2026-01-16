<?php

namespace PHPMaker2024\hercules;

// Table
$userlevels = Container("userlevels");
$userlevels->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($userlevels->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_userlevelsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($userlevels->userlevelid->Visible) { // userlevelid ?>
        <tr id="r_userlevelid"<?= $userlevels->userlevelid->rowAttributes() ?>>
            <td class="<?= $userlevels->TableLeftColumnClass ?>"><?= $userlevels->userlevelid->caption() ?></td>
            <td<?= $userlevels->userlevelid->cellAttributes() ?>>
<span id="el_userlevels_userlevelid">
<span<?= $userlevels->userlevelid->viewAttributes() ?>>
<?= $userlevels->userlevelid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($userlevels->userlevelname->Visible) { // userlevelname ?>
        <tr id="r_userlevelname"<?= $userlevels->userlevelname->rowAttributes() ?>>
            <td class="<?= $userlevels->TableLeftColumnClass ?>"><?= $userlevels->userlevelname->caption() ?></td>
            <td<?= $userlevels->userlevelname->cellAttributes() ?>>
<span id="el_userlevels_userlevelname">
<span<?= $userlevels->userlevelname->viewAttributes() ?>>
<?= $userlevels->userlevelname->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($userlevels->indicador->Visible) { // indicador ?>
        <tr id="r_indicador"<?= $userlevels->indicador->rowAttributes() ?>>
            <td class="<?= $userlevels->TableLeftColumnClass ?>"><?= $userlevels->indicador->caption() ?></td>
            <td<?= $userlevels->indicador->cellAttributes() ?>>
<span id="el_userlevels_indicador">
<span<?= $userlevels->indicador->viewAttributes() ?>>
<?= $userlevels->indicador->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($userlevels->tipo_proveedor->Visible) { // tipo_proveedor ?>
        <tr id="r_tipo_proveedor"<?= $userlevels->tipo_proveedor->rowAttributes() ?>>
            <td class="<?= $userlevels->TableLeftColumnClass ?>"><?= $userlevels->tipo_proveedor->caption() ?></td>
            <td<?= $userlevels->tipo_proveedor->cellAttributes() ?>>
<span id="el_userlevels_tipo_proveedor">
<span<?= $userlevels->tipo_proveedor->viewAttributes() ?>>
<?= $userlevels->tipo_proveedor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($userlevels->ver_alertas->Visible) { // ver_alertas ?>
        <tr id="r_ver_alertas"<?= $userlevels->ver_alertas->rowAttributes() ?>>
            <td class="<?= $userlevels->TableLeftColumnClass ?>"><?= $userlevels->ver_alertas->caption() ?></td>
            <td<?= $userlevels->ver_alertas->cellAttributes() ?>>
<span id="el_userlevels_ver_alertas">
<span<?= $userlevels->ver_alertas->viewAttributes() ?>>
<?= $userlevels->ver_alertas->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($userlevels->financiero->Visible) { // financiero ?>
        <tr id="r_financiero"<?= $userlevels->financiero->rowAttributes() ?>>
            <td class="<?= $userlevels->TableLeftColumnClass ?>"><?= $userlevels->financiero->caption() ?></td>
            <td<?= $userlevels->financiero->cellAttributes() ?>>
<span id="el_userlevels_financiero">
<span<?= $userlevels->financiero->viewAttributes() ?>>
<?= $userlevels->financiero->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
