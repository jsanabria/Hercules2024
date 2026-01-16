<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoParcelaVentasAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_parcela_ventas: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_parcela_ventasadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_parcela_ventasadd")
        .setPageId("add")

        // Add fields
        .setFields([
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
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsco_parcela_ventasadd" id="fsco_parcela_ventasadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_parcela_ventas">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_seccion">
<input type="<?= $Page->seccion->getInputTextType() ?>" name="x_seccion" id="x_seccion" data-table="sco_parcela_ventas" data-field="x_seccion" value="<?= $Page->seccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->seccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->seccion->formatPattern()) ?>"<?= $Page->seccion->editAttributes() ?> aria-describedby="x_seccion_help">
<?= $Page->seccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->seccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_modulo">
<input type="<?= $Page->modulo->getInputTextType() ?>" name="x_modulo" id="x_modulo" data-table="sco_parcela_ventas" data-field="x_modulo" value="<?= $Page->modulo->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->modulo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->modulo->formatPattern()) ?>"<?= $Page->modulo->editAttributes() ?> aria-describedby="x_modulo_help">
<?= $Page->modulo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->modulo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
    <div id="r_subseccion"<?= $Page->subseccion->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_subseccion" for="x_subseccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subseccion->caption() ?><?= $Page->subseccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subseccion->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_subseccion">
<input type="<?= $Page->subseccion->getInputTextType() ?>" name="x_subseccion" id="x_subseccion" data-table="sco_parcela_ventas" data-field="x_subseccion" value="<?= $Page->subseccion->EditValue ?>" size="6" maxlength="3" placeholder="<?= HtmlEncode($Page->subseccion->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->subseccion->formatPattern()) ?>"<?= $Page->subseccion->editAttributes() ?> aria-describedby="x_subseccion_help">
<?= $Page->subseccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->subseccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_parcela_ventas_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_parcela_ventas_parcela">
<input type="<?= $Page->parcela->getInputTextType() ?>" name="x_parcela" id="x_parcela" data-table="sco_parcela_ventas" data-field="x_parcela" value="<?= $Page->parcela->EditValue ?>" size="6" maxlength="1" placeholder="<?= HtmlEncode($Page->parcela->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->parcela->formatPattern()) ?>"<?= $Page->parcela->editAttributes() ?> aria-describedby="x_parcela_help">
<?= $Page->parcela->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->parcela->getErrorMessage() ?></div>
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
    if (in_array("sco_parcela_ventas_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_parcela_ventas_nota->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_parcela_ventas_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoParcelaVentasNotaGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_parcela_ventasadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_parcela_ventasadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
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
    $(document).ready(function() {
        // 1. AUTO-SELECCIÓN AL ENTRAR (FOCUS)
        $("input:text").on("focus", function() {
            $(this).select();
        });

        // 2. INYECCIÓN DE SPINNERS
        if ($("#loading-parcela").length === 0) {
            $('<i id="loading-parcela" class="fas fa-spinner fa-spin text-primary" style="display:none; margin-left: -25px; position: relative; z-index: 10;"></i>').insertAfter("#x_parcela");
        }

        // 3. FUNCIÓN DE LIMPIEZA EN CASCADA
        // nivel 1: limpia todo desde modulo abajo
        // nivel 2: limpia desde subseccion abajo... etc.
        function limpiarDesde(nivel) {
            if (nivel <= 1) $("#x_modulo").val("").prop('disabled', true);
            if (nivel <= 2) $("#x_subseccion").val("").prop('disabled', true);
            if (nivel <= 3) {
                $("#x_parcela").val("").removeClass("is-valid is-invalid");
                $("#x_ci_vendedor").val("").prop('disabled', true);
                $("#x_vendedor").val("").prop('disabled', true);
            }
        }

        // 4. LÓGICA DE SALTOS, MAYÚSCULAS Y PADEO (BLUR / CHANGE)

        // SECCIÓN
        $("#x_seccion").on("blur", function() {
            let val = $(this).val().trim().toUpperCase();
            $(this).val(val.padEnd(3, ' ')); // Padeo 3 derecha
        }).on("change", function() {
            if($(this).val().trim() !== "") {
                limpiarDesde(1); // Blanquea todo lo de abajo
                $("#x_modulo").prop('disabled', false).focus();
            }
        });

        // MODULO
        $("#x_modulo").on("blur", function() {
            let val = $(this).val().trim().toUpperCase();
            $(this).val(val.padStart(3, ' ')); // Padeo 3 izquierda
        }).on("change", function() {
            if($(this).val().trim() !== "") {
                limpiarDesde(2); // Blanquea desde subseccion
                $("#x_subseccion").prop('disabled', false).focus();
            }
        });

        // SUBSECCIÓN
        $("#x_subseccion").on("blur", function() {
            let val = $(this).val().trim().toUpperCase();
            $(this).val(val.padStart(3, ' ')); // Padeo 3 izquierda
        }).on("change", function() {
            if($(this).val().trim() !== "") {
                limpiarDesde(3); // Blanquea parcela y vendedor
                $("#x_parcela").prop('disabled', false).focus();
            }
        });

        // CONTRATO (Longitud 8)
        $("#x_contrato").on("blur", function() {
            let val = $(this).val().trim().toUpperCase();
            if (val !== "") $(this).val(val.padStart(8, ' '));
        });

        // 5. AJAX PRINCIPAL (PARCELA)
        $("#x_parcela").change(function() {
            $(this).val($(this).val().toUpperCase());
            const valParcela = $(this).val();
            if (valParcela === "") return;

            // UI: Mostrar cargando
            $("#loading-parcela").show();
            $(this).removeClass("is-valid").addClass("is-invalid");
            const formData = {
                seccion: $("#x_seccion").val(),
                modulo: $("#x_modulo").val(),
                subseccion: $("#x_subseccion").val(),
                parcela: valParcela,
                buscar: "cedula"
            };
            $.getJSON("BuscarParcelaVc", formData)
                .done(function(data) {
                    if (data.status === "success") {
                        $("#x_parcela").removeClass("is-invalid").addClass("is-valid");
                        $("#x_ci_vendedor").val(data.item1).prop('disabled', false);
                        $("#x_vendedor").val(data.item2).prop('disabled', false);
                        $("#x_ci_vendedor").focus();
                    } else {
                        ew.alert("Parcela no encontrada. Verifique los datos.");
                        limpiarDesde(3); 
                    }
                })
                .fail(function() { ew.alert("Error de conexión."); })
                .always(function() { $("#loading-parcela").hide(); });
        });

        // 6. LÓGICA DE TASA (MONEDA)
        $('#x_tasa_compra').prop('readonly', true).addClass('bg-light');
        $('#x_moneda_compra').on('change', function() {
            var moneda = $(this).val();
            var $campoTasa = $('#x_tasa_compra');
            if ($("#loading-tasa").length === 0) {
                $('<i id="loading-tasa" class="fas fa-spinner fa-spin text-primary" style="display:none; margin-left: -25px; position: relative; z-index: 10;"></i>').insertAfter($campoTasa);
            }
            if (moneda !== "") {
                $("#loading-tasa").show();
                $campoTasa.prop('disabled', true);
                $.ajax({
                    method: "POST",
                    url: "dashboard/buscar_tasa.php",
                    data: { moneda: moneda },
                    dataType: "json"
                })
                .done(function(data) {
                    if (data.status === "success" || data.status === "not_found") {
                        $campoTasa.val(data.tasa);
                    }
                })
                .always(function() {
                    $("#loading-tasa").hide();
                    $campoTasa.prop('disabled', false);
                });
            }
        });
    });
});
</script>
