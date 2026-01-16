<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewParcelaVentasEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fview_parcela_ventasedit" id="fview_parcela_ventasedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_parcela_ventas: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fview_parcela_ventasedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fview_parcela_ventasedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Nparcela_ventas", [fields.Nparcela_ventas.visible && fields.Nparcela_ventas.required ? ew.Validators.required(fields.Nparcela_ventas.caption) : null], fields.Nparcela_ventas.isInvalid],
            ["vendedor", [fields.vendedor.visible && fields.vendedor.required ? ew.Validators.required(fields.vendedor.caption) : null], fields.vendedor.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["subseccion", [fields.subseccion.visible && fields.subseccion.required ? ew.Validators.required(fields.subseccion.caption) : null], fields.subseccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["ci_comprador", [fields.ci_comprador.visible && fields.ci_comprador.required ? ew.Validators.required(fields.ci_comprador.caption) : null], fields.ci_comprador.isInvalid],
            ["comprador", [fields.comprador.visible && fields.comprador.required ? ew.Validators.required(fields.comprador.caption) : null], fields.comprador.isInvalid],
            ["valor_venta", [fields.valor_venta.visible && fields.valor_venta.required ? ew.Validators.required(fields.valor_venta.caption) : null, ew.Validators.float], fields.valor_venta.isInvalid],
            ["moneda_venta", [fields.moneda_venta.visible && fields.moneda_venta.required ? ew.Validators.required(fields.moneda_venta.caption) : null], fields.moneda_venta.isInvalid],
            ["tasa_venta", [fields.tasa_venta.visible && fields.tasa_venta.required ? ew.Validators.required(fields.tasa_venta.caption) : null, ew.Validators.float], fields.tasa_venta.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid]
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
            "moneda_venta": <?= $Page->moneda_venta->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="view_parcela_ventas">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->Nparcela_ventas->Visible) { // Nparcela_ventas ?>
    <div id="r_Nparcela_ventas"<?= $Page->Nparcela_ventas->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_Nparcela_ventas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Nparcela_ventas->caption() ?><?= $Page->Nparcela_ventas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Nparcela_ventas->cellAttributes() ?>>
<span id="el_view_parcela_ventas_Nparcela_ventas">
<span<?= $Page->Nparcela_ventas->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Nparcela_ventas->getDisplayValue($Page->Nparcela_ventas->EditValue))) ?>"></span>
<input type="hidden" data-table="view_parcela_ventas" data-field="x_Nparcela_ventas" data-hidden="1" name="x_Nparcela_ventas" id="x_Nparcela_ventas" value="<?= HtmlEncode($Page->Nparcela_ventas->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->vendedor->Visible) { // vendedor ?>
    <div id="r_vendedor"<?= $Page->vendedor->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_vendedor" for="x_vendedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->vendedor->caption() ?><?= $Page->vendedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->vendedor->cellAttributes() ?>>
<span id="el_view_parcela_ventas_vendedor">
<span<?= $Page->vendedor->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->vendedor->getDisplayValue($Page->vendedor->EditValue))) ?>"></span>
<input type="hidden" data-table="view_parcela_ventas" data-field="x_vendedor" data-hidden="1" name="x_vendedor" id="x_vendedor" value="<?= HtmlEncode($Page->vendedor->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_view_parcela_ventas_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->seccion->getDisplayValue($Page->seccion->EditValue))) ?>"></span>
<input type="hidden" data-table="view_parcela_ventas" data-field="x_seccion" data-hidden="1" name="x_seccion" id="x_seccion" value="<?= HtmlEncode($Page->seccion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_view_parcela_ventas_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->modulo->getDisplayValue($Page->modulo->EditValue))) ?>"></span>
<input type="hidden" data-table="view_parcela_ventas" data-field="x_modulo" data-hidden="1" name="x_modulo" id="x_modulo" value="<?= HtmlEncode($Page->modulo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subseccion->Visible) { // subseccion ?>
    <div id="r_subseccion"<?= $Page->subseccion->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_subseccion" for="x_subseccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subseccion->caption() ?><?= $Page->subseccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subseccion->cellAttributes() ?>>
<span id="el_view_parcela_ventas_subseccion">
<span<?= $Page->subseccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->subseccion->getDisplayValue($Page->subseccion->EditValue))) ?>"></span>
<input type="hidden" data-table="view_parcela_ventas" data-field="x_subseccion" data-hidden="1" name="x_subseccion" id="x_subseccion" value="<?= HtmlEncode($Page->subseccion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_view_parcela_ventas_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->parcela->getDisplayValue($Page->parcela->EditValue))) ?>"></span>
<input type="hidden" data-table="view_parcela_ventas" data-field="x_parcela" data-hidden="1" name="x_parcela" id="x_parcela" value="<?= HtmlEncode($Page->parcela->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_comprador->Visible) { // ci_comprador ?>
    <div id="r_ci_comprador"<?= $Page->ci_comprador->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_ci_comprador" for="x_ci_comprador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_comprador->caption() ?><?= $Page->ci_comprador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_comprador->cellAttributes() ?>>
<span id="el_view_parcela_ventas_ci_comprador">
<input type="<?= $Page->ci_comprador->getInputTextType() ?>" name="x_ci_comprador" id="x_ci_comprador" data-table="view_parcela_ventas" data-field="x_ci_comprador" value="<?= $Page->ci_comprador->EditValue ?>" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_comprador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_comprador->formatPattern()) ?>"<?= $Page->ci_comprador->editAttributes() ?> aria-describedby="x_ci_comprador_help">
<?= $Page->ci_comprador->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_comprador->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->comprador->Visible) { // comprador ?>
    <div id="r_comprador"<?= $Page->comprador->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_comprador" for="x_comprador" class="<?= $Page->LeftColumnClass ?>"><?= $Page->comprador->caption() ?><?= $Page->comprador->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->comprador->cellAttributes() ?>>
<span id="el_view_parcela_ventas_comprador">
<input type="<?= $Page->comprador->getInputTextType() ?>" name="x_comprador" id="x_comprador" data-table="view_parcela_ventas" data-field="x_comprador" value="<?= $Page->comprador->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->comprador->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->comprador->formatPattern()) ?>"<?= $Page->comprador->editAttributes() ?> aria-describedby="x_comprador_help">
<?= $Page->comprador->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->comprador->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->valor_venta->Visible) { // valor_venta ?>
    <div id="r_valor_venta"<?= $Page->valor_venta->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_valor_venta" for="x_valor_venta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->valor_venta->caption() ?><?= $Page->valor_venta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->valor_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_valor_venta">
<input type="<?= $Page->valor_venta->getInputTextType() ?>" name="x_valor_venta" id="x_valor_venta" data-table="view_parcela_ventas" data-field="x_valor_venta" value="<?= $Page->valor_venta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->valor_venta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->valor_venta->formatPattern()) ?>"<?= $Page->valor_venta->editAttributes() ?> aria-describedby="x_valor_venta_help">
<?= $Page->valor_venta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->valor_venta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->moneda_venta->Visible) { // moneda_venta ?>
    <div id="r_moneda_venta"<?= $Page->moneda_venta->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_moneda_venta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->moneda_venta->caption() ?><?= $Page->moneda_venta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->moneda_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_moneda_venta">
<template id="tp_x_moneda_venta">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="view_parcela_ventas" data-field="x_moneda_venta" name="x_moneda_venta" id="x_moneda_venta"<?= $Page->moneda_venta->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_moneda_venta" class="ew-item-list"></div>
<selection-list hidden
    id="x_moneda_venta"
    name="x_moneda_venta"
    value="<?= HtmlEncode($Page->moneda_venta->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_moneda_venta"
    data-target="dsl_x_moneda_venta"
    data-repeatcolumn="0"
    class="form-control<?= $Page->moneda_venta->isInvalidClass() ?>"
    data-table="view_parcela_ventas"
    data-field="x_moneda_venta"
    data-value-separator="<?= $Page->moneda_venta->displayValueSeparatorAttribute() ?>"
    <?= $Page->moneda_venta->editAttributes() ?>></selection-list>
<?= $Page->moneda_venta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->moneda_venta->getErrorMessage() ?></div>
<?= $Page->moneda_venta->Lookup->getParamTag($Page, "p_x_moneda_venta") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa_venta->Visible) { // tasa_venta ?>
    <div id="r_tasa_venta"<?= $Page->tasa_venta->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_tasa_venta" for="x_tasa_venta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa_venta->caption() ?><?= $Page->tasa_venta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa_venta->cellAttributes() ?>>
<span id="el_view_parcela_ventas_tasa_venta">
<input type="<?= $Page->tasa_venta->getInputTextType() ?>" name="x_tasa_venta" id="x_tasa_venta" data-table="view_parcela_ventas" data-field="x_tasa_venta" value="<?= $Page->tasa_venta->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tasa_venta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tasa_venta->formatPattern()) ?>"<?= $Page->tasa_venta->editAttributes() ?> aria-describedby="x_tasa_venta_help">
<?= $Page->tasa_venta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tasa_venta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_view_parcela_ventas_nota">
<textarea data-table="view_parcela_ventas" data-field="x_nota" name="x_nota" id="x_nota" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_view_parcela_ventas_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_view_parcela_ventas_estatus">
<input type="<?= $Page->estatus->getInputTextType() ?>" name="x_estatus" id="x_estatus" data-table="view_parcela_ventas" data-field="x_estatus" value="<?= $Page->estatus->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->estatus->formatPattern()) ?>"<?= $Page->estatus->editAttributes() ?> aria-describedby="x_estatus_help">
<?= $Page->estatus->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fview_parcela_ventasedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fview_parcela_ventasedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("view_parcela_ventas");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_ci_comprador").change(function() {
        let $input = $(this);
        let valor = $input.val().trim().toUpperCase();

        // 1. Limpieza total: quitar puntos, comas y espacios en blanco
        valor = valor.replace(/[\.\,\s]/g, "");
        if (valor === "") return; // Si borraron el contenido, no hacer nada

        // 2. Normalización del guion (V123456 -> V-123456)
        // Buscamos si el segundo carácter ya es un guion, si no, lo insertamos
        if (valor.length > 1 && valor.charAt(1) !== "-") {
            valor = valor.substring(0, 1) + "-" + valor.substring(1);
        }
        $input.val(valor); // Actualizamos el campo con el formato limpio

        // 3. Validaciones
        let error = "";
        if (valor.length < 8) { // Mínimo V-123456 (8 caracteres)
            error = "La cédula debe tener al menos 6 números después del guion.";
        } else if (valor.length > 12) {
            error = "La cédula no puede exceder los 12 caracteres.";
        } else if (!valor.startsWith("V-") && !valor.startsWith("E-")) {
            error = "La CI debe comenzar con 'V-' (Venezolano) o 'E-' (Extranjero).";
        } else {
            // Validar que después del guion solo haya números
            let numeros = valor.substring(2);
            if (!/^\d+$/.test(numeros)) {
                error = "La parte numérica de la CI debe contener solo números enteros.";
            }
        }

        // 4. Manejo del Error
        if (error !== "") {
            ew.alert(error); // Alerta nativa de PHPMaker
            $input.val("").focus(); // Limpiar y regresar el foco
            return false;
        }
    });
    $(document).ready(function() {
        // Solo actuar si es la página de edición
        if (ew.PAGE_ID !== "edit") return;

        // Obtenemos el valor del estatus actual
        // Nota: PHPMaker usa prefijos como x_ para los campos
        var estatusActual = $("#x_estatus").val(); 

        // Si el estatus NO es COMPRA (está vendido o anulado), mostramos los botones
        if (estatusActual === "VENTA") {
            $("#controles-especiales").show(); // Esto quita el display:none
        }
        $('#x_estatus').prop('readonly', true).addClass('bg-light');
    });
    $("#chk-anular").on("change", function() {
        if ($(this).is(":checked")) {
            var $chk = $(this);

            // 1. Capturar el ID de la venta (ajusta 'Nparcela_ventas' al nombre de tu llave primaria)
            var idVenta = $("#x_Nparcela_ventas").val(); 

            // 2. Llamada AJAX enviando ID y Nivel
            $.post("../dashboard/anular_parcela.php", { 
                level: <?= CurrentUserLevel() ?>, // ew.USER_LEVEL_ID, 
                id: idVenta, // Ahora pasamos el ID
                accion: "validar_anulacion" 
            }, function(data) {
                if (data.status === "success") {
                    if(confirm("¿Está seguro de ANULAR esta venta?")) {
                        $("#x_estatus").val("ANULADO");
                        $("#btn-action").submit(); 
                    } else {
                        $chk.prop("checked", false);
                    }
                } else {
                    ew.alert(data.message);
                    $chk.prop("checked", false);
                }
            }, "json");
        }
    });
    $("#chk-revertir").on("change", function() {
        if ($(this).is(":checked")) {
            var $chk = $(this);
            var idVenta = $("#x_Nparcela_ventas").val(); 
            var miNivel = <?php echo CurrentUserLevel(); ?>;
            $.post("../dashboard/anular_parcela.php", { 
                level: miNivel, 
                id: idVenta, 
                accion: "validar_reverso" 
            }, function(data) {
                if (data.status === "success") {
                    // Uso de ew.showConfirm (estándar PHPMaker moderno)
                    if(confirm("¿Desea REVERTIR la parcela a estatus COMPRA? Se borrarán los datos de la venta actual.")) {
                        $("#x_estatus").val("COMPRA"); // Cambiamos el estatus a COMPRA
                        $("#btn-action").submit(); 
                    } else {
                        $chk.prop("checked", false); // Desmarcar si cancela
                    }
                } else {
                    ew.alert(data.message);
                    $chk.prop("checked", false);
                }
            }, "json");
        }
    });
    $(document).ready(function() {
        if($("#x_estatus").val() != "COMPRA") {
            $('#x_ci_comprador').prop('readonly', true).addClass('bg-light');
            $('#x_comprador').prop('readonly', true).addClass('bg-light');
            $('#x_moneda_venta').prop('readonly', true).addClass('bg-light');
            $('#x_valor_venta').prop('readonly', true).addClass('bg-light');
            $('#x_tasa_venta').prop('readonly', true).addClass('bg-light');
            $('#x_nota').prop('readonly', true).addClass('bg-light');
        }
        if($("#x_estatus").val() == "COMPRA") $("#x_estatus").val("VENTA");
        $('#x_tasa_venta').prop('readonly', true).addClass('bg-light');
        $('#x_moneda_venta').on('change', function() {
            var moneda = $(this).val();
            var $campoTasa = $('#x_tasa_venta');
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
