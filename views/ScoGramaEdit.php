<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoGramaEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<form name="fsco_gramaedit" id="fsco_gramaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_grama: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_gramaedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_gramaedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["Ngrama", [fields.Ngrama.visible && fields.Ngrama.required ? ew.Validators.required(fields.Ngrama.caption) : null], fields.Ngrama.isInvalid],
            ["ci_solicitante", [fields.ci_solicitante.visible && fields.ci_solicitante.required ? ew.Validators.required(fields.ci_solicitante.caption) : null], fields.ci_solicitante.isInvalid],
            ["solicitante", [fields.solicitante.visible && fields.solicitante.required ? ew.Validators.required(fields.solicitante.caption) : null], fields.solicitante.isInvalid],
            ["telefono1", [fields.telefono1.visible && fields.telefono1.required ? ew.Validators.required(fields.telefono1.caption) : null], fields.telefono1.isInvalid],
            ["telefono2", [fields.telefono2.visible && fields.telefono2.required ? ew.Validators.required(fields.telefono2.caption) : null], fields.telefono2.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["tipo", [fields.tipo.visible && fields.tipo.required ? ew.Validators.required(fields.tipo.caption) : null], fields.tipo.isInvalid],
            ["subtipo", [fields.subtipo.visible && fields.subtipo.required ? ew.Validators.required(fields.subtipo.caption) : null], fields.subtipo.isInvalid],
            ["monto", [fields.monto.visible && fields.monto.required ? ew.Validators.required(fields.monto.caption) : null, ew.Validators.float], fields.monto.isInvalid],
            ["tasa", [fields.tasa.visible && fields.tasa.required ? ew.Validators.required(fields.tasa.caption) : null, ew.Validators.float], fields.tasa.isInvalid],
            ["nota", [fields.nota.visible && fields.nota.required ? ew.Validators.required(fields.nota.caption) : null], fields.nota.isInvalid],
            ["contrato", [fields.contrato.visible && fields.contrato.required ? ew.Validators.required(fields.contrato.caption) : null], fields.contrato.isInvalid],
            ["seccion", [fields.seccion.visible && fields.seccion.required ? ew.Validators.required(fields.seccion.caption) : null], fields.seccion.isInvalid],
            ["modulo", [fields.modulo.visible && fields.modulo.required ? ew.Validators.required(fields.modulo.caption) : null], fields.modulo.isInvalid],
            ["sub_seccion", [fields.sub_seccion.visible && fields.sub_seccion.required ? ew.Validators.required(fields.sub_seccion.caption) : null], fields.sub_seccion.isInvalid],
            ["parcela", [fields.parcela.visible && fields.parcela.required ? ew.Validators.required(fields.parcela.caption) : null], fields.parcela.isInvalid],
            ["boveda", [fields.boveda.visible && fields.boveda.required ? ew.Validators.required(fields.boveda.caption) : null], fields.boveda.isInvalid],
            ["ci_difunto", [fields.ci_difunto.visible && fields.ci_difunto.required ? ew.Validators.required(fields.ci_difunto.caption) : null], fields.ci_difunto.isInvalid],
            ["apellido1", [fields.apellido1.visible && fields.apellido1.required ? ew.Validators.required(fields.apellido1.caption) : null], fields.apellido1.isInvalid],
            ["apellido2", [fields.apellido2.visible && fields.apellido2.required ? ew.Validators.required(fields.apellido2.caption) : null], fields.apellido2.isInvalid],
            ["nombre1", [fields.nombre1.visible && fields.nombre1.required ? ew.Validators.required(fields.nombre1.caption) : null], fields.nombre1.isInvalid],
            ["nombre2", [fields.nombre2.visible && fields.nombre2.required ? ew.Validators.required(fields.nombre2.caption) : null], fields.nombre2.isInvalid],
            ["fecha_solucion", [fields.fecha_solucion.visible && fields.fecha_solucion.required ? ew.Validators.required(fields.fecha_solucion.caption) : null], fields.fecha_solucion.isInvalid],
            ["fecha_desde", [fields.fecha_desde.visible && fields.fecha_desde.required ? ew.Validators.required(fields.fecha_desde.caption) : null, ew.Validators.datetime(fields.fecha_desde.clientFormatPattern)], fields.fecha_desde.isInvalid],
            ["fecha_hasta", [fields.fecha_hasta.visible && fields.fecha_hasta.required ? ew.Validators.required(fields.fecha_hasta.caption) : null, ew.Validators.datetime(fields.fecha_hasta.clientFormatPattern)], fields.fecha_hasta.isInvalid],
            ["estatus", [fields.estatus.visible && fields.estatus.required ? ew.Validators.required(fields.estatus.caption) : null], fields.estatus.isInvalid],
            ["fecha_registro", [fields.fecha_registro.visible && fields.fecha_registro.required ? ew.Validators.required(fields.fecha_registro.caption) : null], fields.fecha_registro.isInvalid],
            ["usuario_registro", [fields.usuario_registro.visible && fields.usuario_registro.required ? ew.Validators.required(fields.usuario_registro.caption) : null], fields.usuario_registro.isInvalid]
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

        // Multi-Page
        .setMultiPage(true)

        // Dynamic selection lists
        .setLists({
            "tipo": <?= $Page->tipo->toClientList($Page) ?>,
            "subtipo": <?= $Page->subtipo->toClientList($Page) ?>,
            "estatus": <?= $Page->estatus->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_grama">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->MultiPages->Items[0]->Visible) { ?>
<div class="ew-edit-div"><!-- page0 -->
<?php if ($Page->Ngrama->Visible) { // Ngrama ?>
    <div id="r_Ngrama"<?= $Page->Ngrama->rowAttributes() ?>>
        <label id="elh_sco_grama_Ngrama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Ngrama->caption() ?><?= $Page->Ngrama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Ngrama->cellAttributes() ?>>
<span id="el_sco_grama_Ngrama">
<span<?= $Page->Ngrama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Ngrama->getDisplayValue($Page->Ngrama->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_Ngrama" data-hidden="1" data-page="0" name="x_Ngrama" id="x_Ngrama" value="<?= HtmlEncode($Page->Ngrama->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tipo->Visible) { // tipo ?>
    <div id="r_tipo"<?= $Page->tipo->rowAttributes() ?>>
        <label id="elh_sco_grama_tipo" for="x_tipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tipo->caption() ?><?= $Page->tipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tipo->cellAttributes() ?>>
<span id="el_sco_grama_tipo">
    <select
        id="x_tipo"
        name="x_tipo"
        class="form-select ew-select<?= $Page->tipo->isInvalidClass() ?>"
        <?php if (!$Page->tipo->IsNativeSelect) { ?>
        data-select2-id="fsco_gramaedit_x_tipo"
        <?php } ?>
        data-table="sco_grama"
        data-field="x_tipo"
        data-page="0"
        data-value-separator="<?= $Page->tipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->tipo->getPlaceHolder()) ?>"
        data-ew-action="update-options"
        <?= $Page->tipo->editAttributes() ?>>
        <?= $Page->tipo->selectOptionListHtml("x_tipo") ?>
    </select>
    <?= $Page->tipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->tipo->getErrorMessage() ?></div>
<?= $Page->tipo->Lookup->getParamTag($Page, "p_x_tipo") ?>
<?php if (!$Page->tipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_gramaedit", function() {
    var options = { name: "x_tipo", selectId: "fsco_gramaedit_x_tipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_gramaedit.lists.tipo?.lookupOptions.length) {
        options.data = { id: "x_tipo", form: "fsco_gramaedit" };
    } else {
        options.ajax = { id: "x_tipo", form: "fsco_gramaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama.fields.tipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->subtipo->Visible) { // subtipo ?>
    <div id="r_subtipo"<?= $Page->subtipo->rowAttributes() ?>>
        <label id="elh_sco_grama_subtipo" for="x_subtipo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->subtipo->caption() ?><?= $Page->subtipo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subtipo->cellAttributes() ?>>
<span id="el_sco_grama_subtipo">
    <select
        id="x_subtipo"
        name="x_subtipo"
        class="form-select ew-select<?= $Page->subtipo->isInvalidClass() ?>"
        <?php if (!$Page->subtipo->IsNativeSelect) { ?>
        data-select2-id="fsco_gramaedit_x_subtipo"
        <?php } ?>
        data-table="sco_grama"
        data-field="x_subtipo"
        data-page="0"
        data-value-separator="<?= $Page->subtipo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subtipo->getPlaceHolder()) ?>"
        <?= $Page->subtipo->editAttributes() ?>>
        <?= $Page->subtipo->selectOptionListHtml("x_subtipo") ?>
    </select>
    <?= $Page->subtipo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->subtipo->getErrorMessage() ?></div>
<?= $Page->subtipo->Lookup->getParamTag($Page, "p_x_subtipo") ?>
<?php if (!$Page->subtipo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_gramaedit", function() {
    var options = { name: "x_subtipo", selectId: "fsco_gramaedit_x_subtipo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_gramaedit.lists.subtipo?.lookupOptions.length) {
        options.data = { id: "x_subtipo", form: "fsco_gramaedit" };
    } else {
        options.ajax = { id: "x_subtipo", form: "fsco_gramaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama.fields.subtipo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page0 -->
<?php } ?>
<div class="ew-multi-page"><!-- multi-page -->
<div class="ew-nav<?= $Page->MultiPages->containerClasses() ?>" id="pages_ScoGramaEdit"><!-- multi-page tabs -->
    <ul class="<?= $Page->MultiPages->navClasses() ?>" role="tablist">
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(1) ?>" data-bs-target="#tab_sco_grama1" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_grama1" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(1)) ?>"><?= $Page->pageCaption(1) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(2) ?>" data-bs-target="#tab_sco_grama2" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_grama2" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(2)) ?>"><?= $Page->pageCaption(2) ?></button></li>
        <li class="nav-item"><button class="<?= $Page->MultiPages->navLinkClasses(3) ?>" data-bs-target="#tab_sco_grama3" data-bs-toggle="tab" type="button" role="tab" aria-controls="tab_sco_grama3" aria-selected="<?= JsonEncode($Page->MultiPages->isActive(3)) ?>"><?= $Page->pageCaption(3) ?></button></li>
    </ul>
    <div class="<?= $Page->MultiPages->tabContentClasses() ?>"><!-- multi-page tabs .tab-content -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(1) ?>" id="tab_sco_grama1" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->contrato->Visible) { // contrato ?>
    <div id="r_contrato"<?= $Page->contrato->rowAttributes() ?>>
        <label id="elh_sco_grama_contrato" for="x_contrato" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contrato->caption() ?><?= $Page->contrato->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contrato->cellAttributes() ?>>
<span id="el_sco_grama_contrato">
<span<?= $Page->contrato->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->contrato->getDisplayValue($Page->contrato->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_contrato" data-hidden="1" data-page="1" name="x_contrato" id="x_contrato" value="<?= HtmlEncode($Page->contrato->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seccion->Visible) { // seccion ?>
    <div id="r_seccion"<?= $Page->seccion->rowAttributes() ?>>
        <label id="elh_sco_grama_seccion" for="x_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seccion->caption() ?><?= $Page->seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seccion->cellAttributes() ?>>
<span id="el_sco_grama_seccion">
<span<?= $Page->seccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->seccion->getDisplayValue($Page->seccion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_seccion" data-hidden="1" data-page="1" name="x_seccion" id="x_seccion" value="<?= HtmlEncode($Page->seccion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->modulo->Visible) { // modulo ?>
    <div id="r_modulo"<?= $Page->modulo->rowAttributes() ?>>
        <label id="elh_sco_grama_modulo" for="x_modulo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->modulo->caption() ?><?= $Page->modulo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->modulo->cellAttributes() ?>>
<span id="el_sco_grama_modulo">
<span<?= $Page->modulo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->modulo->getDisplayValue($Page->modulo->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_modulo" data-hidden="1" data-page="1" name="x_modulo" id="x_modulo" value="<?= HtmlEncode($Page->modulo->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sub_seccion->Visible) { // sub_seccion ?>
    <div id="r_sub_seccion"<?= $Page->sub_seccion->rowAttributes() ?>>
        <label id="elh_sco_grama_sub_seccion" for="x_sub_seccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sub_seccion->caption() ?><?= $Page->sub_seccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->sub_seccion->cellAttributes() ?>>
<span id="el_sco_grama_sub_seccion">
<span<?= $Page->sub_seccion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->sub_seccion->getDisplayValue($Page->sub_seccion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_sub_seccion" data-hidden="1" data-page="1" name="x_sub_seccion" id="x_sub_seccion" value="<?= HtmlEncode($Page->sub_seccion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->parcela->Visible) { // parcela ?>
    <div id="r_parcela"<?= $Page->parcela->rowAttributes() ?>>
        <label id="elh_sco_grama_parcela" for="x_parcela" class="<?= $Page->LeftColumnClass ?>"><?= $Page->parcela->caption() ?><?= $Page->parcela->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->parcela->cellAttributes() ?>>
<span id="el_sco_grama_parcela">
<span<?= $Page->parcela->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->parcela->getDisplayValue($Page->parcela->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_parcela" data-hidden="1" data-page="1" name="x_parcela" id="x_parcela" value="<?= HtmlEncode($Page->parcela->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->boveda->Visible) { // boveda ?>
    <div id="r_boveda"<?= $Page->boveda->rowAttributes() ?>>
        <label id="elh_sco_grama_boveda" for="x_boveda" class="<?= $Page->LeftColumnClass ?>"><?= $Page->boveda->caption() ?><?= $Page->boveda->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->boveda->cellAttributes() ?>>
<span id="el_sco_grama_boveda">
<span<?= $Page->boveda->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->boveda->getDisplayValue($Page->boveda->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_boveda" data-hidden="1" data-page="1" name="x_boveda" id="x_boveda" value="<?= HtmlEncode($Page->boveda->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_difunto->Visible) { // ci_difunto ?>
    <div id="r_ci_difunto"<?= $Page->ci_difunto->rowAttributes() ?>>
        <label id="elh_sco_grama_ci_difunto" for="x_ci_difunto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_difunto->caption() ?><?= $Page->ci_difunto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_difunto->cellAttributes() ?>>
<span id="el_sco_grama_ci_difunto">
<input type="<?= $Page->ci_difunto->getInputTextType() ?>" name="x_ci_difunto" id="x_ci_difunto" data-table="sco_grama" data-field="x_ci_difunto" value="<?= $Page->ci_difunto->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_difunto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_difunto->formatPattern()) ?>"<?= $Page->ci_difunto->editAttributes() ?> aria-describedby="x_ci_difunto_help">
<?= $Page->ci_difunto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_difunto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido1->Visible) { // apellido1 ?>
    <div id="r_apellido1"<?= $Page->apellido1->rowAttributes() ?>>
        <label id="elh_sco_grama_apellido1" for="x_apellido1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido1->caption() ?><?= $Page->apellido1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido1->cellAttributes() ?>>
<span id="el_sco_grama_apellido1">
<input type="<?= $Page->apellido1->getInputTextType() ?>" name="x_apellido1" id="x_apellido1" data-table="sco_grama" data-field="x_apellido1" value="<?= $Page->apellido1->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido1->formatPattern()) ?>"<?= $Page->apellido1->editAttributes() ?> aria-describedby="x_apellido1_help">
<?= $Page->apellido1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellido1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->apellido2->Visible) { // apellido2 ?>
    <div id="r_apellido2"<?= $Page->apellido2->rowAttributes() ?>>
        <label id="elh_sco_grama_apellido2" for="x_apellido2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->apellido2->caption() ?><?= $Page->apellido2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->apellido2->cellAttributes() ?>>
<span id="el_sco_grama_apellido2">
<input type="<?= $Page->apellido2->getInputTextType() ?>" name="x_apellido2" id="x_apellido2" data-table="sco_grama" data-field="x_apellido2" value="<?= $Page->apellido2->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->apellido2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->apellido2->formatPattern()) ?>"<?= $Page->apellido2->editAttributes() ?> aria-describedby="x_apellido2_help">
<?= $Page->apellido2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->apellido2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre1->Visible) { // nombre1 ?>
    <div id="r_nombre1"<?= $Page->nombre1->rowAttributes() ?>>
        <label id="elh_sco_grama_nombre1" for="x_nombre1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre1->caption() ?><?= $Page->nombre1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre1->cellAttributes() ?>>
<span id="el_sco_grama_nombre1">
<input type="<?= $Page->nombre1->getInputTextType() ?>" name="x_nombre1" id="x_nombre1" data-table="sco_grama" data-field="x_nombre1" value="<?= $Page->nombre1->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre1->formatPattern()) ?>"<?= $Page->nombre1->editAttributes() ?> aria-describedby="x_nombre1_help">
<?= $Page->nombre1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre2->Visible) { // nombre2 ?>
    <div id="r_nombre2"<?= $Page->nombre2->rowAttributes() ?>>
        <label id="elh_sco_grama_nombre2" for="x_nombre2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre2->caption() ?><?= $Page->nombre2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre2->cellAttributes() ?>>
<span id="el_sco_grama_nombre2">
<input type="<?= $Page->nombre2->getInputTextType() ?>" name="x_nombre2" id="x_nombre2" data-table="sco_grama" data-field="x_nombre2" value="<?= $Page->nombre2->EditValue ?>" data-page="1" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->nombre2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre2->formatPattern()) ?>"<?= $Page->nombre2->editAttributes() ?> aria-describedby="x_nombre2_help">
<?= $Page->nombre2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(2) ?>" id="tab_sco_grama2" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ci_solicitante->Visible) { // ci_solicitante ?>
    <div id="r_ci_solicitante"<?= $Page->ci_solicitante->rowAttributes() ?>>
        <label id="elh_sco_grama_ci_solicitante" for="x_ci_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_solicitante->caption() ?><?= $Page->ci_solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_solicitante->cellAttributes() ?>>
<span id="el_sco_grama_ci_solicitante">
<input type="<?= $Page->ci_solicitante->getInputTextType() ?>" name="x_ci_solicitante" id="x_ci_solicitante" data-table="sco_grama" data-field="x_ci_solicitante" value="<?= $Page->ci_solicitante->EditValue ?>" data-page="2" size="30" maxlength="15" placeholder="<?= HtmlEncode($Page->ci_solicitante->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_solicitante->formatPattern()) ?>"<?= $Page->ci_solicitante->editAttributes() ?> aria-describedby="x_ci_solicitante_help">
<?= $Page->ci_solicitante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_solicitante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->solicitante->Visible) { // solicitante ?>
    <div id="r_solicitante"<?= $Page->solicitante->rowAttributes() ?>>
        <label id="elh_sco_grama_solicitante" for="x_solicitante" class="<?= $Page->LeftColumnClass ?>"><?= $Page->solicitante->caption() ?><?= $Page->solicitante->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->solicitante->cellAttributes() ?>>
<span id="el_sco_grama_solicitante">
<input type="<?= $Page->solicitante->getInputTextType() ?>" name="x_solicitante" id="x_solicitante" data-table="sco_grama" data-field="x_solicitante" value="<?= $Page->solicitante->EditValue ?>" data-page="2" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->solicitante->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->solicitante->formatPattern()) ?>"<?= $Page->solicitante->editAttributes() ?> aria-describedby="x_solicitante_help">
<?= $Page->solicitante->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->solicitante->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono1->Visible) { // telefono1 ?>
    <div id="r_telefono1"<?= $Page->telefono1->rowAttributes() ?>>
        <label id="elh_sco_grama_telefono1" for="x_telefono1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono1->caption() ?><?= $Page->telefono1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono1->cellAttributes() ?>>
<span id="el_sco_grama_telefono1">
<input type="<?= $Page->telefono1->getInputTextType() ?>" name="x_telefono1" id="x_telefono1" data-table="sco_grama" data-field="x_telefono1" value="<?= $Page->telefono1->EditValue ?>" data-page="2" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->telefono1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono1->formatPattern()) ?>"<?= $Page->telefono1->editAttributes() ?> aria-describedby="x_telefono1_help">
<?= $Page->telefono1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono2->Visible) { // telefono2 ?>
    <div id="r_telefono2"<?= $Page->telefono2->rowAttributes() ?>>
        <label id="elh_sco_grama_telefono2" for="x_telefono2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono2->caption() ?><?= $Page->telefono2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono2->cellAttributes() ?>>
<span id="el_sco_grama_telefono2">
<input type="<?= $Page->telefono2->getInputTextType() ?>" name="x_telefono2" id="x_telefono2" data-table="sco_grama" data-field="x_telefono2" value="<?= $Page->telefono2->EditValue ?>" data-page="2" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->telefono2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono2->formatPattern()) ?>"<?= $Page->telefono2->editAttributes() ?> aria-describedby="x_telefono2_help">
<?= $Page->telefono2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_grama__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_grama__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_grama" data-field="x__email" value="<?= $Page->_email->EditValue ?>" data-page="2" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto->Visible) { // monto ?>
    <div id="r_monto"<?= $Page->monto->rowAttributes() ?>>
        <label id="elh_sco_grama_monto" for="x_monto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto->caption() ?><?= $Page->monto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto->cellAttributes() ?>>
<span id="el_sco_grama_monto">
<input type="<?= $Page->monto->getInputTextType() ?>" name="x_monto" id="x_monto" data-table="sco_grama" data-field="x_monto" value="<?= $Page->monto->EditValue ?>" data-page="2" size="30" placeholder="<?= HtmlEncode($Page->monto->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto->formatPattern()) ?>"<?= $Page->monto->editAttributes() ?> aria-describedby="x_monto_help">
<?= $Page->monto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <div id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <label id="elh_sco_grama_tasa" for="x_tasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa->caption() ?><?= $Page->tasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_grama_tasa">
<input type="<?= $Page->tasa->getInputTextType() ?>" name="x_tasa" id="x_tasa" data-table="sco_grama" data-field="x_tasa" value="<?= $Page->tasa->EditValue ?>" data-page="2" size="30" placeholder="<?= HtmlEncode($Page->tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tasa->formatPattern()) ?>"<?= $Page->tasa->editAttributes() ?> aria-describedby="x_tasa_help">
<?= $Page->tasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tasa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_grama_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_grama_nota">
<textarea data-table="sco_grama" data-field="x_nota" data-page="2" name="x_nota" id="x_nota" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
        <div class="<?= $Page->MultiPages->tabPaneClasses(3) ?>" id="tab_sco_grama3" role="tabpanel"><!-- multi-page .tab-pane -->
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->fecha_solucion->Visible) { // fecha_solucion ?>
    <div id="r_fecha_solucion"<?= $Page->fecha_solucion->rowAttributes() ?>>
        <label id="elh_sco_grama_fecha_solucion" for="x_fecha_solucion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_solucion->caption() ?><?= $Page->fecha_solucion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_solucion->cellAttributes() ?>>
<span id="el_sco_grama_fecha_solucion">
<span<?= $Page->fecha_solucion->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha_solucion->getDisplayValue($Page->fecha_solucion->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_fecha_solucion" data-hidden="1" data-page="3" name="x_fecha_solucion" id="x_fecha_solucion" value="<?= HtmlEncode($Page->fecha_solucion->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_desde->Visible) { // fecha_desde ?>
    <div id="r_fecha_desde"<?= $Page->fecha_desde->rowAttributes() ?>>
        <label id="elh_sco_grama_fecha_desde" for="x_fecha_desde" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_desde->caption() ?><?= $Page->fecha_desde->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_desde->cellAttributes() ?>>
<span id="el_sco_grama_fecha_desde">
<input type="<?= $Page->fecha_desde->getInputTextType() ?>" name="x_fecha_desde" id="x_fecha_desde" data-table="sco_grama" data-field="x_fecha_desde" value="<?= $Page->fecha_desde->EditValue ?>" data-page="3" placeholder="<?= HtmlEncode($Page->fecha_desde->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_desde->formatPattern()) ?>"<?= $Page->fecha_desde->editAttributes() ?> aria-describedby="x_fecha_desde_help">
<?= $Page->fecha_desde->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_desde->getErrorMessage() ?></div>
<?php if (!$Page->fecha_desde->ReadOnly && !$Page->fecha_desde->Disabled && !isset($Page->fecha_desde->EditAttrs["readonly"]) && !isset($Page->fecha_desde->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_gramaedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_gramaedit", "x_fecha_desde", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_hasta->Visible) { // fecha_hasta ?>
    <div id="r_fecha_hasta"<?= $Page->fecha_hasta->rowAttributes() ?>>
        <label id="elh_sco_grama_fecha_hasta" for="x_fecha_hasta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_hasta->caption() ?><?= $Page->fecha_hasta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_hasta->cellAttributes() ?>>
<span id="el_sco_grama_fecha_hasta">
<input type="<?= $Page->fecha_hasta->getInputTextType() ?>" name="x_fecha_hasta" id="x_fecha_hasta" data-table="sco_grama" data-field="x_fecha_hasta" value="<?= $Page->fecha_hasta->EditValue ?>" data-page="3" placeholder="<?= HtmlEncode($Page->fecha_hasta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_hasta->formatPattern()) ?>"<?= $Page->fecha_hasta->editAttributes() ?> aria-describedby="x_fecha_hasta_help">
<?= $Page->fecha_hasta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_hasta->getErrorMessage() ?></div>
<?php if (!$Page->fecha_hasta->ReadOnly && !$Page->fecha_hasta->Disabled && !isset($Page->fecha_hasta->EditAttrs["readonly"]) && !isset($Page->fecha_hasta->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_gramaedit", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_gramaedit", "x_fecha_hasta", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_grama_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_grama_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_gramaedit_x_estatus"
        <?php } ?>
        data-table="sco_grama"
        data-field="x_estatus"
        data-page="3"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?= $Page->estatus->Lookup->getParamTag($Page, "p_x_estatus") ?>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_gramaedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_gramaedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_gramaedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_gramaedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_gramaedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_grama.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_registro->Visible) { // fecha_registro ?>
    <div id="r_fecha_registro"<?= $Page->fecha_registro->rowAttributes() ?>>
        <label id="elh_sco_grama_fecha_registro" for="x_fecha_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_registro->caption() ?><?= $Page->fecha_registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_registro->cellAttributes() ?>>
<span id="el_sco_grama_fecha_registro">
<span<?= $Page->fecha_registro->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->fecha_registro->getDisplayValue($Page->fecha_registro->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_fecha_registro" data-hidden="1" data-page="3" name="x_fecha_registro" id="x_fecha_registro" value="<?= HtmlEncode($Page->fecha_registro->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->usuario_registro->Visible) { // usuario_registro ?>
    <div id="r_usuario_registro"<?= $Page->usuario_registro->rowAttributes() ?>>
        <label id="elh_sco_grama_usuario_registro" for="x_usuario_registro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->usuario_registro->caption() ?><?= $Page->usuario_registro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->usuario_registro->cellAttributes() ?>>
<span id="el_sco_grama_usuario_registro">
<span<?= $Page->usuario_registro->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->usuario_registro->getDisplayValue($Page->usuario_registro->EditValue))) ?>"></span>
<input type="hidden" data-table="sco_grama" data-field="x_usuario_registro" data-hidden="1" data-page="3" name="x_usuario_registro" id="x_usuario_registro" value="<?= HtmlEncode($Page->usuario_registro->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
        </div><!-- /multi-page .tab-pane -->
    </div><!-- /multi-page tabs .tab-content -->
</div><!-- /multi-page tabs -->
</div><!-- /multi-page -->
<?php
    if (in_array("sco_grama_pagos", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_pagos->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_pagos", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaPagosGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_grama_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_nota->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaNotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_grama_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_grama_adjunto->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_grama_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoGramaAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_gramaedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_gramaedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("sco_grama");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_tipo").change(function(){
    	var tipo = $("#x_tipo").val();
    	<?php
    	$Ngrama = CurrentTable()->Ngrama->CurrentValue; // $_REQUEST["Ngrama"];
    	// $sql = "SELECT modulo FROM sco_grama WHERE Ngrama = '$Ngrama';";
    	$sql = "SELECT seccion FROM sco_grama WHERE Ngrama = '$Ngrama';";
    	$modulo = trim(ExecuteScalar($sql));
    	echo 'var ngrama = "' . $modulo . '";';
    	?>
    	// alert("The text has been changed. " + ngrama + " - " + tipo);
    	if(ngrama == "44A" || ngrama == "41A" || ngrama == "41" || ngrama == "41B" || ngrama == "03") {
    		if(tipo == "6.1") {
    			var xHtml = '<label id="elh_sco_grama_subtipo" for="x_subtipo" class="col-sm-2 control-label ewLabel">Sub Tipo<span class="ewRequired">&nbsp;*</span></label><div class="col-sm-10"><div><span id="el_sco_grama_subtipo"><select data-field="x_subtipo" id="x_subtipo" name="x_subtipo" class="form-control"> <option value="6.1.7">GRAMA POR INHUMACION</option> </select></span></div></div></div>';
    			$("#r_subtipo").html( xHtml);
    			$('#x_tipo').attr("disabled", true);
    		}
    	}
    });
});
</script>
