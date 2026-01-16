<?php

namespace PHPMaker2024\hercules;

// Table
$sco_user = Container("sco_user");
$sco_user->TableClass = "table table-bordered table-hover table-sm ew-table ew-master-table";
?>
<?php if ($sco_user->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_sco_usermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($sco_user->Nuser->Visible) { // Nuser ?>
        <tr id="r_Nuser"<?= $sco_user->Nuser->rowAttributes() ?>>
            <td class="<?= $sco_user->TableLeftColumnClass ?>"><?= $sco_user->Nuser->caption() ?></td>
            <td<?= $sco_user->Nuser->cellAttributes() ?>>
<span id="el_sco_user_Nuser">
<span<?= $sco_user->Nuser->viewAttributes() ?>>
<?= $sco_user->Nuser->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_user->cedula->Visible) { // cedula ?>
        <tr id="r_cedula"<?= $sco_user->cedula->rowAttributes() ?>>
            <td class="<?= $sco_user->TableLeftColumnClass ?>"><?= $sco_user->cedula->caption() ?></td>
            <td<?= $sco_user->cedula->cellAttributes() ?>>
<span id="el_sco_user_cedula">
<span<?= $sco_user->cedula->viewAttributes() ?>>
<?= $sco_user->cedula->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_user->nombre->Visible) { // nombre ?>
        <tr id="r_nombre"<?= $sco_user->nombre->rowAttributes() ?>>
            <td class="<?= $sco_user->TableLeftColumnClass ?>"><?= $sco_user->nombre->caption() ?></td>
            <td<?= $sco_user->nombre->cellAttributes() ?>>
<span id="el_sco_user_nombre">
<span<?= $sco_user->nombre->viewAttributes() ?>>
<?= $sco_user->nombre->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_user->_username->Visible) { // username ?>
        <tr id="r__username"<?= $sco_user->_username->rowAttributes() ?>>
            <td class="<?= $sco_user->TableLeftColumnClass ?>"><?= $sco_user->_username->caption() ?></td>
            <td<?= $sco_user->_username->cellAttributes() ?>>
<span id="el_sco_user__username">
<span<?= $sco_user->_username->viewAttributes() ?>>
<?= $sco_user->_username->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_user->level->Visible) { // level ?>
        <tr id="r_level"<?= $sco_user->level->rowAttributes() ?>>
            <td class="<?= $sco_user->TableLeftColumnClass ?>"><?= $sco_user->level->caption() ?></td>
            <td<?= $sco_user->level->cellAttributes() ?>>
<span id="el_sco_user_level">
<span<?= $sco_user->level->viewAttributes() ?>>
<?= $sco_user->level->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($sco_user->foto->Visible) { // foto ?>
        <tr id="r_foto"<?= $sco_user->foto->rowAttributes() ?>>
            <td class="<?= $sco_user->TableLeftColumnClass ?>"><?= $sco_user->foto->caption() ?></td>
            <td<?= $sco_user->foto->cellAttributes() ?>>
<span id="el_sco_user_foto">
<span>
<?= GetFileViewTag($sco_user->foto, $sco_user->foto->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
