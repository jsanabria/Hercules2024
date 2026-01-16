<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaVentasEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_parcela_ventasedit" id="fsco_parcela_ventasedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela_ventas: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_parcela_ventasedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcela_ventasedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nparcela_ventas", [fields.Nparcela_ventas.visible && fields.Nparcela_ventas.required ? ew.Validators.required(fields.Nparcela_ventas.caption) : null, ew.Validators.integer], fields.Nparcela_ventas.isInvalid],
            ["fecha_compra", [fields.fecha_compra.visible && fields.fecha_compra.required ? ew.Validators.required(fields.fecha_compra.caption) : null, ew.Validators.datetime(fields.fecha_compra.clientFormatPattern)], fields.fecha_compra.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["subseccion", [fields.subseccion.visible && fields.subseccion.required ? ew.Validators.required(fields.subseccion.caption) : null], fields.subseccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["ci_vendedor", [fields.ci_vendedor.visible && fields.ci_vendedor.required ? ew.Validators.required(fields.ci_vendedor.caption) : null], fields.ci_vendedor.isInvalid],
            ["vendedor", [fields.vendedor.visible && fields.vendedor.required ? ew.Validators.required(fields.vendedor.caption) : null], fields.vendedor.isInvalid],
            ["valor_compra", [fields.valor_compra.visible && fields.valor_compra.required ? ew.Validators.required(fields.valor_compra.caption) : null, ew.Validators.float], fields.valor_compra.isInvalid],
            ["moneda_compra", [fields.moneda_compra.visible && fields.moneda_compra.required ? ew.Validators.required(fields.moneda_compra.caption) : null], fields.moneda_compra.isInvalid],
            ["tasa_compra", [fields.tasa_compra.visible && fields.tasa_compra.required ? ew.Validators.required(fields.tasa_compra.caption) : null, ew.Validators.float], fields.tasa_compra.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["numero_factura", [fields.numero_factura.visible && fields.numero_factura.required ? ew.Validators.required(fields.numero_factura.caption) : null], fields.numero_factura.isInvalid],
            ["orden_pago", [fields.orden_pago.visible && fields.orden_pago.required ? ew.Validators.required(fields.orden_pago.caption) : null], fields.orden_pago.isInvalid]
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
            "moneda_compra": <?= $Page->moneda_compra->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_parcela_ventas">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
    <div id="r_Nparcela_ventas"<?= $Page->Nparcela_ventas->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_Nparcela_ventas" for="x_Nparcela_ventas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nparcela_ventas->caption() ?><?= $Page->Nparcela_ventas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nparcela_ventas->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_Nparcela_ventas">
<span<?= $Page->Nparcela_ventas->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nparcela_ventas->getDisplayValue($Page->Nparcela_ventas->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_parcela_ventas" data-field="x_Nparcela_ventas" data-hidden="1" name="x_Nparcela_ventas" id="x_Nparcela_ventas" value="<?= HtmlEncode($Page->Nparcela_ventas->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_compra->Visible) { // fecha_compra ?>
    <div id="r_fecha_compra"<?= $Page->fecha_compra->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_fecha_compra" for="x_fecha_compra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_compra->caption() ?><?= $Page->fecha_compra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_compra->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_fecha_compra">
<input type="<?= $Page->fecha_compra->getInputTextType() ?>" name="x_fecha_compra" id="x_fecha_compra" data-table="sco_parcela_ventas" data-field="x_fecha_compra" value="<?= $Page->fecha_compra->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_compra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_compra->formatPattern()) ?>"<?= $Page->fecha_compra->editAttributes() ?> aria-describedby="x_fecha_compra_help">
<?= $Page->fecha_compra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_compra->getErrorMessage() ?></div>
<?php if (!$Page->fecha_compra->ReadOnly && !$Page->fecha_compra->Disabled && !isset($Page->fecha_compra->EditAttrs["readonly"]) && !isset($Page->fecha_compra->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_parcela_ventasedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(7) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    clock: !!format.match(/h/i) || !!format.match(/m/) || !!format.match(/s/i),
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.getPreferredTheme()
            }
        };
    ew.createDateTimePicker("fsco_parcela_ventasedit", "x_fecha_compra", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->seccion->getDisplayValue($Page->seccion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_parcela_ventas" data-field="x_seccion" data-hidden="1" name="x_seccion" id="x_seccion" value="<?= HtmlEncode($Page->seccion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->modulo->getDisplayValue($Page->modulo->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_parcela_ventas" data-field="x_modulo" data-hidden="1" name="x_modulo" id="x_modulo" value="<?= HtmlEncode($Page->modulo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
    <div id="r_subseccion"<?= $Page->subseccion->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_subseccion" for="x_subseccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subseccion->caption() ?><?= $Page->subseccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subseccion->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_subseccion">
<span<?= $Page->subseccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subseccion->getDisplayValue($Page->subseccion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_parcela_ventas" data-field="x_subseccion" data-hidden="1" name="x_subseccion" id="x_subseccion" value="<?= HtmlEncode($Page->subseccion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->parcela->getDisplayValue($Page->parcela->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_parcela_ventas" data-field="x_parcela" data-hidden="1" name="x_parcela" id="x_parcela" value="<?= HtmlEncode($Page->parcela->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_vendedor->Visible) { // ci_vendedor ?>
    <div id="r_ci_vendedor"<?= $Page->ci_vendedor->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_ci_vendedor" for="x_ci_vendedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_vendedor->caption() ?><?= $Page->ci_vendedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_vendedor->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_ci_vendedor">
<input type="<?= $Page->ci_vendedor->getInputTextType() ?>" name="x_ci_vendedor" id="x_ci_vendedor" data-table="sco_parcela_ventas" data-field="x_ci_vendedor" value="<?= $Page->ci_vendedor->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_vendedor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_vendedor->formatPattern()) ?>"<?= $Page->ci_vendedor->editAttributes() ?> aria-describedby="x_ci_vendedor_help">
<?= $Page->ci_vendedor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_vendedor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vendedor->Visible) { // vendedor ?>
    <div id="r_vendedor"<?= $Page->vendedor->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_vendedor" for="x_vendedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vendedor->caption() ?><?= $Page->vendedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vendedor->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_vendedor">
<input type="<?= $Page->vendedor->getInputTextType() ?>" name="x_vendedor" id="x_vendedor" data-table="sco_parcela_ventas" data-field="x_vendedor" value="<?= $Page->vendedor->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->vendedor->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->vendedor->formatPattern()) ?>"<?= $Page->vendedor->editAttributes() ?> aria-describedby="x_vendedor_help">
<?= $Page->vendedor->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->vendedor->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor_compra->Visible) { // valor_compra ?>
    <div id="r_valor_compra"<?= $Page->valor_compra->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_valor_compra" for="x_valor_compra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor_compra->caption() ?><?= $Page->valor_compra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor_compra->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_valor_compra">
<input type="<?= $Page->valor_compra->getInputTextType() ?>" name="x_valor_compra" id="x_valor_compra" data-table="sco_parcela_ventas" data-field="x_valor_compra" value="<?= $Page->valor_compra->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->valor_compra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor_compra->formatPattern()) ?>"<?= $Page->valor_compra->editAttributes() ?> aria-describedby="x_valor_compra_help">
<?= $Page->valor_compra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor_compra->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->moneda_compra->Visible) { // moneda_compra ?>
    <div id="r_moneda_compra"<?= $Page->moneda_compra->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_moneda_compra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->moneda_compra->caption() ?><?= $Page->moneda_compra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->moneda_compra->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_moneda_compra">
<template id="tp_x_moneda_compra">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="sco_parcela_ventas" data-field="x_moneda_compra" name="x_moneda_compra" id="x_moneda_compra"<?= $Page->moneda_compra->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_moneda_compra" class="ew-item-list"></div>
<selection-list hidden
    id="x_moneda_compra"
    name="x_moneda_compra"
    value="<?= HtmlEncode($Page->moneda_compra->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_moneda_compra"
    data-target="dsl_x_moneda_compra"
    data-repeatcolumn="0"
    class="form-control<?= $Page->moneda_compra->isInvalidClass() ?>"
    data-table="sco_parcela_ventas"
    data-field="x_moneda_compra"
    data-value-separator="<?= $Page->moneda_compra->displayValueSeparatorAttribute() ?>"
    <?= $Page->moneda_compra->editAttributes() ?>></selection-list>
<?= $Page->moneda_compra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->moneda_compra->getErrorMessage() ?></div>
<?= $Page->moneda_compra->Lookup->getParamTag($Page, "p_x_moneda_compra") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa_compra->Visible) { // tasa_compra ?>
    <div id="r_tasa_compra"<?= $Page->tasa_compra->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_tasa_compra" for="x_tasa_compra" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa_compra->caption() ?><?= $Page->tasa_compra->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa_compra->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_tasa_compra">
<input type="<?= $Page->tasa_compra->getInputTextType() ?>" name="x_tasa_compra" id="x_tasa_compra" data-table="sco_parcela_ventas" data-field="x_tasa_compra" value="<?= $Page->tasa_compra->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tasa_compra->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tasa_compra->formatPattern()) ?>"<?= $Page->tasa_compra->editAttributes() ?> aria-describedby="x_tasa_compra_help">
<?= $Page->tasa_compra->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tasa_compra->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_nota">
<textarea data-table="sco_parcela_ventas" data-field="x_nota" name="x_nota" id="x_nota" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->numero_factura->Visible) { // numero_factura ?>
    <div id="r_numero_factura"<?= $Page->numero_factura->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_numero_factura" for="x_numero_factura" class="<?= $Page->LeftColumnClass ?>"><?= $Page->numero_factura->caption() ?><?= $Page->numero_factura->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->numero_factura->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_numero_factura">
<input type="<?= $Page->numero_factura->getInputTextType() ?>" name="x_numero_factura" id="x_numero_factura" data-table="sco_parcela_ventas" data-field="x_numero_factura" value="<?= $Page->numero_factura->EditValue ?>" size="6" maxlength="10" placeholder="<?= HtmlEncode($Page->numero_factura->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->numero_factura->formatPattern()) ?>"<?= $Page->numero_factura->editAttributes() ?> aria-describedby="x_numero_factura_help">
<?= $Page->numero_factura->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->numero_factura->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->orden_pago->Visible) { // orden_pago ?>
    <div id="r_orden_pago"<?= $Page->orden_pago->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_orden_pago" for="x_orden_pago" class="<?= $Page->LeftColumnClass ?>"><?= $Page->orden_pago->caption() ?><?= $Page->orden_pago->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->orden_pago->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_orden_pago">
<input type="<?= $Page->orden_pago->getInputTextType() ?>" name="x_orden_pago" id="x_orden_pago" data-table="sco_parcela_ventas" data-field="x_orden_pago" value="<?= $Page->orden_pago->EditValue ?>" size="6" maxlength="10" placeholder="<?= HtmlEncode($Page->orden_pago->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->orden_pago->formatPattern()) ?>"<?= $Page->orden_pago->editAttributes() ?> aria-describedby="x_orden_pago_help">
<?= $Page->orden_pago->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->orden_pago->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php
    if (in_array("sco_parcela_ventas_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_parcela_ventas_nota->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_parcela_ventas_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoParcelaVentasNotaGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_parcela_ventasedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_parcela_ventasedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_parcela_ventas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");

    // Valiacaión CI 
    $("#x_ci_vendedor").change(function(){
    	var xBad = true;
    	$("#x_ci_vendedor").val($("#x_ci_vendedor").val().replace(" ",""));
    	$("#x_ci_vendedor").val($("#x_ci_vendedor").val().replace(".",""));
    	$("#x_ci_vendedor").val($("#x_ci_vendedor").val().replace(",",""));
    	if($("#x_ci_vendedor").val().substring(1,2)!="-")
    		$("#x_ci_vendedor").val($("#x_ci_vendedor").val().substring(0,1) + "-" + $("#x_ci_vendedor").val().substring(1,$("#x_ci_vendedor").val().length).trim());
    	$("#x_ci_vendedor").val($("#x_ci_vendedor").val().toUpperCase());
    	if($("#x_ci_vendedor").val()==""){
    		alert("Este campo no puede estar vacio");
    		xBad = false;
    	}else if($("#x_ci_vendedor").val().length < 7) {
    		alert("Este campo debe ser mayor a 6 caracteres");
    		xBad = false;
    	}else if($("#x_ci_vendedor").val().length > 12) {
    		alert("Este campo debe ser menor a 12 caracteres");
    		xBad = false;
    	}else if($("#x_ci_vendedor").val().substring(0,2) != "V-" && $("#x_ci_vendedor").val().substring(0,2) != "E-" && $("#x_ci_vendedor").val().substring(0,2) != "M-") {
    		alert("La CI debe comenzar con (V-) Venezolano o con (E-) Extranjero.");
    		xBad = false;
    	}else if(isNaN($("#x_ci_vendedor").val().substring(2,$("#x_ci_vendedor").val().length))) {
    		alert("La CI debe ser un valor entero");
    		xBad = false;
    	}
    	if(xBad == false) {
    		$("#x_ci_vendedor").val("");
    		return false;
    	}
    });
});
</script>
