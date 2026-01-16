<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoProveedorEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_proveedoredit" id="fsco_proveedoredit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_proveedor: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_proveedoredit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_proveedoredit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nproveedor", [fields.Nproveedor.visible && fields.Nproveedor.required ? ew.Validators.required(fields.Nproveedor.caption) : null], fields.Nproveedor.isInvalid],
            ["rif", [fields.rif.visible && fields.rif.required ? ew.Validators.required(fields.rif.caption) : null], fields.rif.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["sucursal", [fields.sucursal.visible && fields.sucursal.required ? ew.Validators.required(fields.sucursal.caption) : null], fields.sucursal.isInvalid],
            ["responsable", [fields.responsable.visible && fields.responsable.required ? ew.Validators.required(fields.responsable.caption) : null], fields.responsable.isInvalid],
            ["telefono1", [fields.telefono1.visible && fields.telefono1.required ? ew.Validators.required(fields.telefono1.caption) : null], fields.telefono1.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["telefono3", [fields.telefono3.visible && fields.telefono3.required ? ew.Validators.required(fields.telefono3.caption) : null], fields.telefono3.isInvalid],
            ["telefono4", [fields.telefono4.visible && fields.telefono4.required ? ew.Validators.required(fields.telefono4.caption) : null], fields.telefono4.isInvalid],
            ["fax", [fields.fax.visible && fields.fax.required ? ew.Validators.required(fields.fax.caption) : null], fields.fax.isInvalid],
            ["correo", [fields.correo.visible && fields.correo.required ? ew.Validators.required(fields.correo.caption) : null, ew.Validators.email], fields.correo.isInvalid],
            ["correo_adicional", [fields.correo_adicional.visible && fields.correo_adicional.required ? ew.Validators.required(fields.correo_adicional.caption) : null, ew.Validators.email], fields.correo_adicional.isInvalid],
            ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
            ["localidad", [fields.localidad.visible && fields.localidad.required ? ew.Validators.required(fields.localidad.caption) : null], fields.localidad.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["observacion", [fields.observacion.visible && fields.observacion.required ? ew.Validators.required(fields.observacion.caption) : null], fields.observacion.isInvalid],
            ["tipo_proveedor", [fields.tipo_proveedor.visible && fields.tipo_proveedor.required ? ew.Validators.required(fields.tipo_proveedor.caption) : null], fields.tipo_proveedor.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code in JAVASCRIPT here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "estado": <?= $Page->estado->toClientList($Page) ?>,
            "tipo_proveedor": <?= $Page->tipo_proveedor->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_proveedor">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nproveedor->Visible) { // Nproveedor ?>
    <div id="r_Nproveedor"<?= $Page->Nproveedor->rowAttributes() ?>>
        <label id="elh_sco_proveedor_Nproveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nproveedor->caption() ?><?= $Page->Nproveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nproveedor->cellAttributes() ?>>
<span id="el_sco_proveedor_Nproveedor">
<span<?= $Page->Nproveedor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nproveedor->getDisplayValue($Page->Nproveedor->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_proveedor" data-field="x_Nproveedor" data-hidden="1" name="x_Nproveedor" id="x_Nproveedor" value="<?= HtmlEncode($Page->Nproveedor->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->rif->Visible) { // rif ?>
    <div id="r_rif"<?= $Page->rif->rowAttributes() ?>>
        <label id="elh_sco_proveedor_rif" for="x_rif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->rif->caption() ?><?= $Page->rif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->rif->cellAttributes() ?>>
<span id="el_sco_proveedor_rif">
<input type="<?= $Page->rif->getInputTextType() ?>" name="x_rif" id="x_rif" data-table="sco_proveedor" data-field="x_rif" value="<?= $Page->rif->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->rif->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->rif->formatPattern()) ?>"<?= $Page->rif->editAttributes() ?> aria-describedby="x_rif_help">
<?= $Page->rif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->rif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_sco_proveedor_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_proveedor_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="sco_proveedor" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sucursal->Visible) { // sucursal ?>
    <div id="r_sucursal"<?= $Page->sucursal->rowAttributes() ?>>
        <label id="elh_sco_proveedor_sucursal" for="x_sucursal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sucursal->caption() ?><?= $Page->sucursal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sucursal->cellAttributes() ?>>
<span id="el_sco_proveedor_sucursal">
<input type="<?= $Page->sucursal->getInputTextType() ?>" name="x_sucursal" id="x_sucursal" data-table="sco_proveedor" data-field="x_sucursal" value="<?= $Page->sucursal->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->sucursal->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->sucursal->formatPattern()) ?>"<?= $Page->sucursal->editAttributes() ?> aria-describedby="x_sucursal_help">
<?= $Page->sucursal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sucursal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->responsable->Visible) { // responsable ?>
    <div id="r_responsable"<?= $Page->responsable->rowAttributes() ?>>
        <label id="elh_sco_proveedor_responsable" for="x_responsable" class="<?= $Page->LeftColumnClass ?>"><?= $Page->responsable->caption() ?><?= $Page->responsable->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->responsable->cellAttributes() ?>>
<span id="el_sco_proveedor_responsable">
<input type="<?= $Page->responsable->getInputTextType() ?>" name="x_responsable" id="x_responsable" data-table="sco_proveedor" data-field="x_responsable" value="<?= $Page->responsable->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->responsable->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->responsable->formatPattern()) ?>"<?= $Page->responsable->editAttributes() ?> aria-describedby="x_responsable_help">
<?= $Page->responsable->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->responsable->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <div id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <label id="elh_sco_proveedor_telefono1" for="x_telefono1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono1->caption() ?><?= $Page->telefono1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono1">
<input type="<?= $Page->telefono1->getInputTextType() ?>" name="x_telefono1" id="x_telefono1" data-table="sco_proveedor" data-field="x_telefono1" value="<?= $Page->telefono1->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->telefono1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono1->formatPattern()) ?>"<?= $Page->telefono1->editAttributes() ?> aria-describedby="x_telefono1_help">
<?= $Page->telefono1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_proveedor_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_proveedor" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono3->Visible) { // telefono3 ?>
    <div id="r_telefono3"<?= $Page->telefono3->rowAttributes() ?>>
        <label id="elh_sco_proveedor_telefono3" for="x_telefono3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono3->caption() ?><?= $Page->telefono3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono3->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono3">
<input type="<?= $Page->telefono3->getInputTextType() ?>" name="x_telefono3" id="x_telefono3" data-table="sco_proveedor" data-field="x_telefono3" value="<?= $Page->telefono3->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->telefono3->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono3->formatPattern()) ?>"<?= $Page->telefono3->editAttributes() ?> aria-describedby="x_telefono3_help">
<?= $Page->telefono3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono4->Visible) { // telefono4 ?>
    <div id="r_telefono4"<?= $Page->telefono4->rowAttributes() ?>>
        <label id="elh_sco_proveedor_telefono4" for="x_telefono4" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono4->caption() ?><?= $Page->telefono4->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono4->cellAttributes() ?>>
<span id="el_sco_proveedor_telefono4">
<input type="<?= $Page->telefono4->getInputTextType() ?>" name="x_telefono4" id="x_telefono4" data-table="sco_proveedor" data-field="x_telefono4" value="<?= $Page->telefono4->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->telefono4->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono4->formatPattern()) ?>"<?= $Page->telefono4->editAttributes() ?> aria-describedby="x_telefono4_help">
<?= $Page->telefono4->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono4->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fax->Visible) { // fax ?>
    <div id="r_fax"<?= $Page->fax->rowAttributes() ?>>
        <label id="elh_sco_proveedor_fax" for="x_fax" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fax->caption() ?><?= $Page->fax->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fax->cellAttributes() ?>>
<span id="el_sco_proveedor_fax">
<input type="<?= $Page->fax->getInputTextType() ?>" name="x_fax" id="x_fax" data-table="sco_proveedor" data-field="x_fax" value="<?= $Page->fax->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->fax->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fax->formatPattern()) ?>"<?= $Page->fax->editAttributes() ?> aria-describedby="x_fax_help">
<?= $Page->fax->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fax->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <div id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <label id="elh_sco_proveedor_correo" for="x_correo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->correo->caption() ?><?= $Page->correo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_proveedor_correo">
<input type="<?= $Page->correo->getInputTextType() ?>" name="x_correo" id="x_correo" data-table="sco_proveedor" data-field="x_correo" value="<?= $Page->correo->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->correo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->correo->formatPattern()) ?>"<?= $Page->correo->editAttributes() ?> aria-describedby="x_correo_help">
<?= $Page->correo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->correo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->correo_adicional->Visible) { // correo_adicional ?>
    <div id="r_correo_adicional"<?= $Page->correo_adicional->rowAttributes() ?>>
        <label id="elh_sco_proveedor_correo_adicional" for="x_correo_adicional" class="<?= $Page->LeftColumnClass ?>"><?= $Page->correo_adicional->caption() ?><?= $Page->correo_adicional->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->correo_adicional->cellAttributes() ?>>
<span id="el_sco_proveedor_correo_adicional">
<input type="<?= $Page->correo_adicional->getInputTextType() ?>" name="x_correo_adicional" id="x_correo_adicional" data-table="sco_proveedor" data-field="x_correo_adicional" value="<?= $Page->correo_adicional->EditValue ?>" size="30" maxlength="200" placeholder="<?= HtmlEncode($Page->correo_adicional->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->correo_adicional->formatPattern()) ?>"<?= $Page->correo_adicional->editAttributes() ?> aria-describedby="x_correo_adicional_help">
<?= $Page->correo_adicional->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->correo_adicional->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
    <div id="r_estado"<?= $Page->estado->rowAttributes() ?>>
        <label id="elh_sco_proveedor_estado" for="x_estado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estado->caption() ?><?= $Page->estado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estado->cellAttributes() ?>>
<span id="el_sco_proveedor_estado">
    <select
        id="x_estado"
        name="x_estado"
        class="form-select ew-select<?= $Page->estado->isInvalidClass() ?>"
        <?php if (!$Page->estado->IsNativeSelect) { ?>
        data-select2-id="fsco_proveedoredit_x_estado"
        <?php } ?>
        data-table="sco_proveedor"
        data-field="x_estado"
        data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>"
        <?= $Page->estado->editAttributes() ?>>
        <?= $Page->estado->selectOptionListHtml("x_estado") ?>
    </select>
    <?= $Page->estado->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
<?= $Page->estado->Lookup->getParamTag($Page, "p_x_estado") ?>
<?php if (!$Page->estado->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_proveedoredit", function() {
    var options = { name: "x_estado", selectId: "fsco_proveedoredit_x_estado" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_proveedoredit.lists.estado?.lookupOptions.length) {
        options.data = { id: "x_estado", form: "fsco_proveedoredit" };
    } else {
        options.ajax = { id: "x_estado", form: "fsco_proveedoredit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_proveedor.fields.estado.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->localidad->Visible) { // localidad ?>
    <div id="r_localidad"<?= $Page->localidad->rowAttributes() ?>>
        <label id="elh_sco_proveedor_localidad" for="x_localidad" class="<?= $Page->LeftColumnClass ?>"><?= $Page->localidad->caption() ?><?= $Page->localidad->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->localidad->cellAttributes() ?>>
<span id="el_sco_proveedor_localidad">
<input type="<?= $Page->localidad->getInputTextType() ?>" name="x_localidad" id="x_localidad" data-table="sco_proveedor" data-field="x_localidad" value="<?= $Page->localidad->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->localidad->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->localidad->formatPattern()) ?>"<?= $Page->localidad->editAttributes() ?> aria-describedby="x_localidad_help">
<?= $Page->localidad->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->localidad->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_sco_proveedor_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_proveedor_direccion">
<textarea data-table="sco_proveedor" data-field="x_direccion" name="x_direccion" id="x_direccion" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help"><?= $Page->direccion->EditValue ?></textarea>
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->observacion->Visible) { // observacion ?>
    <div id="r_observacion"<?= $Page->observacion->rowAttributes() ?>>
        <label id="elh_sco_proveedor_observacion" for="x_observacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->observacion->caption() ?><?= $Page->observacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->observacion->cellAttributes() ?>>
<span id="el_sco_proveedor_observacion">
<textarea data-table="sco_proveedor" data-field="x_observacion" name="x_observacion" id="x_observacion" cols="60" rows="4" placeholder="<?= HtmlEncode($Page->observacion->getPlaceHolder()) ?>"<?= $Page->observacion->editAttributes() ?> aria-describedby="x_observacion_help"><?= $Page->observacion->EditValue ?></textarea>
<?= $Page->observacion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->observacion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo_proveedor->Visible) { // tipo_proveedor ?>
    <div id="r_tipo_proveedor"<?= $Page->tipo_proveedor->rowAttributes() ?>>
        <label id="elh_sco_proveedor_tipo_proveedor" for="x_tipo_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo_proveedor->caption() ?><?= $Page->tipo_proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo_proveedor->cellAttributes() ?>>
<span id="el_sco_proveedor_tipo_proveedor">
    <select
        id="x_tipo_proveedor"
        name="x_tipo_proveedor"
        class="form-select ew-select<?= $Page->tipo_proveedor->isInvalidClass() ?>"
        <?php if (!$Page->tipo_proveedor->IsNativeSelect) { ?>
        data-select2-id="fsco_proveedoredit_x_tipo_proveedor"
        <?php } ?>
        data-table="sco_proveedor"
        data-field="x_tipo_proveedor"
        data-value-separator="<?= $Page->tipo_proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo_proveedor->getPlaceHolder()) ?>"
        <?= $Page->tipo_proveedor->editAttributes() ?>>
        <?= $Page->tipo_proveedor->selectOptionListHtml("x_tipo_proveedor") ?>
    </select>
    <?= $Page->tipo_proveedor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo_proveedor->getErrorMessage() ?></div>
<?= $Page->tipo_proveedor->Lookup->getParamTag($Page, "p_x_tipo_proveedor") ?>
<?php if (!$Page->tipo_proveedor->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_proveedoredit", function() {
    var options = { name: "x_tipo_proveedor", selectId: "fsco_proveedoredit_x_tipo_proveedor" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_proveedoredit.lists.tipo_proveedor?.lookupOptions.length) {
        options.data = { id: "x_tipo_proveedor", form: "fsco_proveedoredit" };
    } else {
        options.ajax = { id: "x_tipo_proveedor", form: "fsco_proveedoredit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_proveedor.fields.tipo_proveedor.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_proveedor_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_proveedor_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_proveedoredit_x_activo"
        <?php } ?>
        data-table="sco_proveedor"
        data-field="x_activo"
        data-value-separator="<?= $Page->activo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->activo->getPlaceHolder()) ?>"
        <?= $Page->activo->editAttributes() ?>>
        <?= $Page->activo->selectOptionListHtml("x_activo") ?>
    </select>
    <?= $Page->activo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->activo->getErrorMessage() ?></div>
<?php if (!$Page->activo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_proveedoredit", function() {
    var options = { name: "x_activo", selectId: "fsco_proveedoredit_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_proveedoredit.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_proveedoredit" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_proveedoredit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_proveedor.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_ofrece_servicio", explode(",", $Page->getCurrentDetailTable())) && $sco_ofrece_servicio->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_ofrece_servicio", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoOfreceServicioGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_proveedoredit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_proveedoredit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_proveedor");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_rif").mask("a999999999");
    $("#x_telefono1").mask("(9999) 999-99-99");
    $("#x_telefono2").mask("(9999) 999-99-99");
    $("#x_telefono3").mask("(9999) 999-99-99");
    $("#x_telefono4").mask("(9999) 999-99-99");
    $("#x_fax").mask("(9999) 999-99-99");
});
</script>
