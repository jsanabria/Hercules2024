<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoCostosEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_costosedit" id="fsco_costosedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_costos: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_costosedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_costosedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Ncostos", [fields.Ncostos.visible && fields.Ncostos.required ? ew.Validators.required(fields.Ncostos.caption) : null], fields.Ncostos.isInvalid],
            ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["costos_articulos", [fields.costos_articulos.visible && fields.costos_articulos.required ? ew.Validators.required(fields.costos_articulos.caption) : null], fields.costos_articulos.isInvalid],
            ["precio_actual", [fields.precio_actual.visible && fields.precio_actual.required ? ew.Validators.required(fields.precio_actual.caption) : null], fields.precio_actual.isInvalid],
            ["porcentaje_aplicado", [fields.porcentaje_aplicado.visible && fields.porcentaje_aplicado.required ? ew.Validators.required(fields.porcentaje_aplicado.caption) : null, ew.Validators.float], fields.porcentaje_aplicado.isInvalid],
            ["precio_nuevo", [fields.precio_nuevo.visible && fields.precio_nuevo.required ? ew.Validators.required(fields.precio_nuevo.caption) : null, ew.Validators.float], fields.precio_nuevo.isInvalid],
            ["alicuota_iva", [fields.alicuota_iva.visible && fields.alicuota_iva.required ? ew.Validators.required(fields.alicuota_iva.caption) : null], fields.alicuota_iva.isInvalid],
            ["monto_iva", [fields.monto_iva.visible && fields.monto_iva.required ? ew.Validators.required(fields.monto_iva.caption) : null], fields.monto_iva.isInvalid],
            ["total", [fields.total.visible && fields.total.required ? ew.Validators.required(fields.total.caption) : null], fields.total.isInvalid],
            ["cerrado", [fields.cerrado.visible && fields.cerrado.required ? ew.Validators.required(fields.cerrado.caption) : null], fields.cerrado.isInvalid]
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
<input type="hidden" name="t" value="sco_costos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Ncostos->Visible) { // Ncostos ?>
    <div id="r_Ncostos"<?= $Page->Ncostos->rowAttributes() ?>>
        <label id="elh_sco_costos_Ncostos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Ncostos->caption() ?><?= $Page->Ncostos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Ncostos->cellAttributes() ?>>
<span id="el_sco_costos_Ncostos">
<span<?= $Page->Ncostos->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Ncostos->getDisplayValue($Page->Ncostos->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_Ncostos" data-hidden="1" name="x_Ncostos" id="x_Ncostos" value="<?= HtmlEncode($Page->Ncostos->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_sco_costos_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span id="el_sco_costos_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_costos_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_costos_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha->getDisplayValue($Page->fecha->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_fecha" data-hidden="1" name="x_fecha" id="x_fecha" value="<?= HtmlEncode($Page->fecha->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_costos_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_costos_tipo">
<span<?= $Page->tipo->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->tipo->getDisplayValue($Page->tipo->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos" data-field="x_tipo" data-hidden="1" name="x_tipo" id="x_tipo" value="<?= HtmlEncode($Page->tipo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->costos_articulos->Visible) { // costos_articulos ?>
    <div id="r_costos_articulos"<?= $Page->costos_articulos->rowAttributes() ?>>
        <label id="elh_sco_costos_costos_articulos" for="x_costos_articulos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->costos_articulos->caption() ?><?= $Page->costos_articulos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->costos_articulos->cellAttributes() ?>>
<span id="el_sco_costos_costos_articulos">
<span<?= $Page->costos_articulos->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->costos_articulos->getDisplayValue($Page->costos_articulos->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos" data-field="x_costos_articulos" data-hidden="1" name="x_costos_articulos" id="x_costos_articulos" value="<?= HtmlEncode($Page->costos_articulos->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precio_actual->Visible) { // precio_actual ?>
    <div id="r_precio_actual"<?= $Page->precio_actual->rowAttributes() ?>>
        <label id="elh_sco_costos_precio_actual" for="x_precio_actual" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precio_actual->caption() ?><?= $Page->precio_actual->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precio_actual->cellAttributes() ?>>
<span id="el_sco_costos_precio_actual">
<span<?= $Page->precio_actual->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->precio_actual->getDisplayValue($Page->precio_actual->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_precio_actual" data-hidden="1" name="x_precio_actual" id="x_precio_actual" value="<?= HtmlEncode($Page->precio_actual->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->porcentaje_aplicado->Visible) { // porcentaje_aplicado ?>
    <div id="r_porcentaje_aplicado"<?= $Page->porcentaje_aplicado->rowAttributes() ?>>
        <label id="elh_sco_costos_porcentaje_aplicado" for="x_porcentaje_aplicado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->porcentaje_aplicado->caption() ?><?= $Page->porcentaje_aplicado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->porcentaje_aplicado->cellAttributes() ?>>
<span id="el_sco_costos_porcentaje_aplicado">
<input type="<?= $Page->porcentaje_aplicado->getInputTextType() ?>" name="x_porcentaje_aplicado" id="x_porcentaje_aplicado" data-table="sco_costos" data-field="x_porcentaje_aplicado" value="<?= $Page->porcentaje_aplicado->EditValue ?>" size="3" placeholder="<?= HtmlEncode($Page->porcentaje_aplicado->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->porcentaje_aplicado->formatPattern()) ?>"<?= $Page->porcentaje_aplicado->editAttributes() ?> aria-describedby="x_porcentaje_aplicado_help">
<?= $Page->porcentaje_aplicado->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->porcentaje_aplicado->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->precio_nuevo->Visible) { // precio_nuevo ?>
    <div id="r_precio_nuevo"<?= $Page->precio_nuevo->rowAttributes() ?>>
        <label id="elh_sco_costos_precio_nuevo" for="x_precio_nuevo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->precio_nuevo->caption() ?><?= $Page->precio_nuevo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->precio_nuevo->cellAttributes() ?>>
<span id="el_sco_costos_precio_nuevo">
<input type="<?= $Page->precio_nuevo->getInputTextType() ?>" name="x_precio_nuevo" id="x_precio_nuevo" data-table="sco_costos" data-field="x_precio_nuevo" value="<?= $Page->precio_nuevo->EditValue ?>" size="10" placeholder="<?= HtmlEncode($Page->precio_nuevo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->precio_nuevo->formatPattern()) ?>"<?= $Page->precio_nuevo->editAttributes() ?> aria-describedby="x_precio_nuevo_help">
<?= $Page->precio_nuevo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->precio_nuevo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alicuota_iva->Visible) { // alicuota_iva ?>
    <div id="r_alicuota_iva"<?= $Page->alicuota_iva->rowAttributes() ?>>
        <label id="elh_sco_costos_alicuota_iva" for="x_alicuota_iva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alicuota_iva->caption() ?><?= $Page->alicuota_iva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->alicuota_iva->cellAttributes() ?>>
<span id="el_sco_costos_alicuota_iva">
<span<?= $Page->alicuota_iva->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->alicuota_iva->getDisplayValue($Page->alicuota_iva->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_alicuota_iva" data-hidden="1" name="x_alicuota_iva" id="x_alicuota_iva" value="<?= HtmlEncode($Page->alicuota_iva->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto_iva->Visible) { // monto_iva ?>
    <div id="r_monto_iva"<?= $Page->monto_iva->rowAttributes() ?>>
        <label id="elh_sco_costos_monto_iva" for="x_monto_iva" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_iva->caption() ?><?= $Page->monto_iva->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_iva->cellAttributes() ?>>
<span id="el_sco_costos_monto_iva">
<span<?= $Page->monto_iva->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->monto_iva->getDisplayValue($Page->monto_iva->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_monto_iva" data-hidden="1" name="x_monto_iva" id="x_monto_iva" value="<?= HtmlEncode($Page->monto_iva->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->total->Visible) { // total ?>
    <div id="r_total"<?= $Page->total->rowAttributes() ?>>
        <label id="elh_sco_costos_total" for="x_total" class="<?= $Page->LeftColumnClass ?>"><?= $Page->total->caption() ?><?= $Page->total->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->total->cellAttributes() ?>>
<span id="el_sco_costos_total">
<span<?= $Page->total->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->total->getDisplayValue($Page->total->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_costos" data-field="x_total" data-hidden="1" name="x_total" id="x_total" value="<?= HtmlEncode($Page->total->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cerrado->Visible) { // cerrado ?>
    <div id="r_cerrado"<?= $Page->cerrado->rowAttributes() ?>>
        <label id="elh_sco_costos_cerrado" for="x_cerrado" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cerrado->caption() ?><?= $Page->cerrado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cerrado->cellAttributes() ?>>
<span id="el_sco_costos_cerrado">
<span<?= $Page->cerrado->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->cerrado->getDisplayValue($Page->cerrado->EditValue) ?></span></span>
<input type="hidden" data-table="sco_costos" data-field="x_cerrado" data-hidden="1" name="x_cerrado" id="x_cerrado" value="<?= HtmlEncode($Page->cerrado->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_costosedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_costosedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_costos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
