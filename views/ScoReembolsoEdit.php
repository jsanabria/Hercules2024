<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoReembolsoEdit = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<form name="fsco_reembolsoedit" id="fsco_reembolsoedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_reembolso: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fsco_reembolsoedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_reembolsoedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null, ew.Validators.datetime(fields.fecha.clientFormatPattern)], fields.fecha.isInvalid],
            ["monto_usd", [fields.monto_usd.visible && fields.monto_usd.required ? ew.Validators.required(fields.monto_usd.caption) : null, ew.Validators.float], fields.monto_usd.isInvalid],
            ["fecha_tasa", [fields.fecha_tasa.visible && fields.fecha_tasa.required ? ew.Validators.required(fields.fecha_tasa.caption) : null, ew.Validators.datetime(fields.fecha_tasa.clientFormatPattern)], fields.fecha_tasa.isInvalid],
            ["tasa", [fields.tasa.visible && fields.tasa.required ? ew.Validators.required(fields.tasa.caption) : null, ew.Validators.float], fields.tasa.isInvalid],
            ["banco", [fields.banco.visible && fields.banco.required ? ew.Validators.required(fields.banco.caption) : null], fields.banco.isInvalid],
            ["nro_cta", [fields.nro_cta.visible && fields.nro_cta.required ? ew.Validators.required(fields.nro_cta.caption) : null], fields.nro_cta.isInvalid],
            ["titular", [fields.titular.visible && fields.titular.required ? ew.Validators.required(fields.titular.caption) : null], fields.titular.isInvalid],
            ["ci_rif", [fields.ci_rif.visible && fields.ci_rif.required ? ew.Validators.required(fields.ci_rif.caption) : null], fields.ci_rif.isInvalid],
            ["correo", [fields.correo.visible && fields.correo.required ? ew.Validators.required(fields.correo.caption) : null, ew.Validators.email], fields.correo.isInvalid],
            ["nro_ref", [fields.nro_ref.visible && fields.nro_ref.required ? ew.Validators.required(fields.nro_ref.caption) : null], fields.nro_ref.isInvalid],
            ["motivo", [fields.motivo.visible && fields.motivo.required ? ew.Validators.required(fields.motivo.caption) : null], fields.motivo.isInvalid],
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
            "motivo": <?= $Page->motivo->toClientList($Page) ?>,
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
<input type="hidden" name="t" value="sco_reembolso">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "sco_expediente") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="sco_expediente">
<input type="hidden" name="fk_Nexpediente" value="<?= HtmlEncode($Page->expediente->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->fecha->Visible) { // fecha ?>
    <div id="r_fecha"<?= $Page->fecha->rowAttributes() ?>>
        <label id="elh_sco_reembolso_fecha" for="x_fecha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha->caption() ?><?= $Page->fecha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha->cellAttributes() ?>>
<span id="el_sco_reembolso_fecha">
<input type="<?= $Page->fecha->getInputTextType() ?>" name="x_fecha" id="x_fecha" data-table="sco_reembolso" data-field="x_fecha" value="<?= $Page->fecha->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha->formatPattern()) ?>"<?= $Page->fecha->editAttributes() ?> aria-describedby="x_fecha_help">
<?= $Page->fecha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha->getErrorMessage() ?></div>
<?php if (!$Page->fecha->ReadOnly && !$Page->fecha->Disabled && !isset($Page->fecha->EditAttrs["readonly"]) && !isset($Page->fecha->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_reembolsoedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fsco_reembolsoedit", "x_fecha", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->monto_usd->Visible) { // monto_usd ?>
    <div id="r_monto_usd"<?= $Page->monto_usd->rowAttributes() ?>>
        <label id="elh_sco_reembolso_monto_usd" for="x_monto_usd" class="<?= $Page->LeftColumnClass ?>"><?= $Page->monto_usd->caption() ?><?= $Page->monto_usd->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->monto_usd->cellAttributes() ?>>
<span id="el_sco_reembolso_monto_usd">
<input type="<?= $Page->monto_usd->getInputTextType() ?>" name="x_monto_usd" id="x_monto_usd" data-table="sco_reembolso" data-field="x_monto_usd" value="<?= $Page->monto_usd->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->monto_usd->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->monto_usd->formatPattern()) ?>"<?= $Page->monto_usd->editAttributes() ?> aria-describedby="x_monto_usd_help">
<?= $Page->monto_usd->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->monto_usd->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_tasa->Visible) { // fecha_tasa ?>
    <div id="r_fecha_tasa"<?= $Page->fecha_tasa->rowAttributes() ?>>
        <label id="elh_sco_reembolso_fecha_tasa" for="x_fecha_tasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_tasa->caption() ?><?= $Page->fecha_tasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_tasa->cellAttributes() ?>>
<span id="el_sco_reembolso_fecha_tasa">
<input type="<?= $Page->fecha_tasa->getInputTextType() ?>" name="x_fecha_tasa" id="x_fecha_tasa" data-table="sco_reembolso" data-field="x_fecha_tasa" value="<?= $Page->fecha_tasa->EditValue ?>" placeholder="<?= HtmlEncode($Page->fecha_tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_tasa->formatPattern()) ?>"<?= $Page->fecha_tasa->editAttributes() ?> aria-describedby="x_fecha_tasa_help">
<?= $Page->fecha_tasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_tasa->getErrorMessage() ?></div>
<?php if (!$Page->fecha_tasa->ReadOnly && !$Page->fecha_tasa->Disabled && !isset($Page->fecha_tasa->EditAttrs["readonly"]) && !isset($Page->fecha_tasa->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_reembolsoedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
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
    ew.createDateTimePicker("fsco_reembolsoedit", "x_fecha_tasa", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tasa->Visible) { // tasa ?>
    <div id="r_tasa"<?= $Page->tasa->rowAttributes() ?>>
        <label id="elh_sco_reembolso_tasa" for="x_tasa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tasa->caption() ?><?= $Page->tasa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->tasa->cellAttributes() ?>>
<span id="el_sco_reembolso_tasa">
<input type="<?= $Page->tasa->getInputTextType() ?>" name="x_tasa" id="x_tasa" data-table="sco_reembolso" data-field="x_tasa" value="<?= $Page->tasa->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->tasa->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->tasa->formatPattern()) ?>"<?= $Page->tasa->editAttributes() ?> aria-describedby="x_tasa_help">
<?= $Page->tasa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tasa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->banco->Visible) { // banco ?>
    <div id="r_banco"<?= $Page->banco->rowAttributes() ?>>
        <label id="elh_sco_reembolso_banco" for="x_banco" class="<?= $Page->LeftColumnClass ?>"><?= $Page->banco->caption() ?><?= $Page->banco->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->banco->cellAttributes() ?>>
<span id="el_sco_reembolso_banco">
<input type="<?= $Page->banco->getInputTextType() ?>" name="x_banco" id="x_banco" data-table="sco_reembolso" data-field="x_banco" value="<?= $Page->banco->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->banco->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->banco->formatPattern()) ?>"<?= $Page->banco->editAttributes() ?> aria-describedby="x_banco_help">
<?= $Page->banco->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->banco->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nro_cta->Visible) { // nro_cta ?>
    <div id="r_nro_cta"<?= $Page->nro_cta->rowAttributes() ?>>
        <label id="elh_sco_reembolso_nro_cta" for="x_nro_cta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nro_cta->caption() ?><?= $Page->nro_cta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nro_cta->cellAttributes() ?>>
<span id="el_sco_reembolso_nro_cta">
<input type="<?= $Page->nro_cta->getInputTextType() ?>" name="x_nro_cta" id="x_nro_cta" data-table="sco_reembolso" data-field="x_nro_cta" value="<?= $Page->nro_cta->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->nro_cta->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nro_cta->formatPattern()) ?>"<?= $Page->nro_cta->editAttributes() ?> aria-describedby="x_nro_cta_help">
<?= $Page->nro_cta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nro_cta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->titular->Visible) { // titular ?>
    <div id="r_titular"<?= $Page->titular->rowAttributes() ?>>
        <label id="elh_sco_reembolso_titular" for="x_titular" class="<?= $Page->LeftColumnClass ?>"><?= $Page->titular->caption() ?><?= $Page->titular->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->titular->cellAttributes() ?>>
<span id="el_sco_reembolso_titular">
<input type="<?= $Page->titular->getInputTextType() ?>" name="x_titular" id="x_titular" data-table="sco_reembolso" data-field="x_titular" value="<?= $Page->titular->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->titular->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->titular->formatPattern()) ?>"<?= $Page->titular->editAttributes() ?> aria-describedby="x_titular_help">
<?= $Page->titular->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->titular->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ci_rif->Visible) { // ci_rif ?>
    <div id="r_ci_rif"<?= $Page->ci_rif->rowAttributes() ?>>
        <label id="elh_sco_reembolso_ci_rif" for="x_ci_rif" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ci_rif->caption() ?><?= $Page->ci_rif->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ci_rif->cellAttributes() ?>>
<span id="el_sco_reembolso_ci_rif">
<input type="<?= $Page->ci_rif->getInputTextType() ?>" name="x_ci_rif" id="x_ci_rif" data-table="sco_reembolso" data-field="x_ci_rif" value="<?= $Page->ci_rif->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->ci_rif->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->ci_rif->formatPattern()) ?>"<?= $Page->ci_rif->editAttributes() ?> aria-describedby="x_ci_rif_help">
<?= $Page->ci_rif->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ci_rif->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <div id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <label id="elh_sco_reembolso_correo" for="x_correo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->correo->caption() ?><?= $Page->correo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_reembolso_correo">
<input type="<?= $Page->correo->getInputTextType() ?>" name="x_correo" id="x_correo" data-table="sco_reembolso" data-field="x_correo" value="<?= $Page->correo->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->correo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->correo->formatPattern()) ?>"<?= $Page->correo->editAttributes() ?> aria-describedby="x_correo_help">
<?= $Page->correo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->correo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nro_ref->Visible) { // nro_ref ?>
    <div id="r_nro_ref"<?= $Page->nro_ref->rowAttributes() ?>>
        <label id="elh_sco_reembolso_nro_ref" for="x_nro_ref" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nro_ref->caption() ?><?= $Page->nro_ref->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nro_ref->cellAttributes() ?>>
<span id="el_sco_reembolso_nro_ref">
<input type="<?= $Page->nro_ref->getInputTextType() ?>" name="x_nro_ref" id="x_nro_ref" data-table="sco_reembolso" data-field="x_nro_ref" value="<?= $Page->nro_ref->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->nro_ref->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nro_ref->formatPattern()) ?>"<?= $Page->nro_ref->editAttributes() ?> aria-describedby="x_nro_ref_help">
<?= $Page->nro_ref->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nro_ref->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motivo->Visible) { // motivo ?>
    <div id="r_motivo"<?= $Page->motivo->rowAttributes() ?>>
        <label id="elh_sco_reembolso_motivo" for="x_motivo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motivo->caption() ?><?= $Page->motivo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motivo->cellAttributes() ?>>
<span id="el_sco_reembolso_motivo">
    <select
        id="x_motivo"
        name="x_motivo"
        class="form-select ew-select<?= $Page->motivo->isInvalidClass() ?>"
        <?php if (!$Page->motivo->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsoedit_x_motivo"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_motivo"
        data-value-separator="<?= $Page->motivo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->motivo->getPlaceHolder()) ?>"
        <?= $Page->motivo->editAttributes() ?>>
        <?= $Page->motivo->selectOptionListHtml("x_motivo") ?>
    </select>
    <?= $Page->motivo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->motivo->getErrorMessage() ?></div>
<?= $Page->motivo->Lookup->getParamTag($Page, "p_x_motivo") ?>
<?php if (!$Page->motivo->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsoedit", function() {
    var options = { name: "x_motivo", selectId: "fsco_reembolsoedit_x_motivo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsoedit.lists.motivo?.lookupOptions.length) {
        options.data = { id: "x_motivo", form: "fsco_reembolsoedit" };
    } else {
        options.ajax = { id: "x_motivo", form: "fsco_reembolsoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.motivo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nota->Visible) { // nota ?>
    <div id="r_nota"<?= $Page->nota->rowAttributes() ?>>
        <label id="elh_sco_reembolso_nota" for="x_nota" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nota->caption() ?><?= $Page->nota->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nota->cellAttributes() ?>>
<span id="el_sco_reembolso_nota">
<textarea data-table="sco_reembolso" data-field="x_nota" name="x_nota" id="x_nota" cols="35" rows="3" placeholder="<?= HtmlEncode($Page->nota->getPlaceHolder()) ?>"<?= $Page->nota->editAttributes() ?> aria-describedby="x_nota_help"><?= $Page->nota->EditValue ?></textarea>
<?= $Page->nota->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nota->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->estatus->Visible) { // estatus ?>
    <div id="r_estatus"<?= $Page->estatus->rowAttributes() ?>>
        <label id="elh_sco_reembolso_estatus" for="x_estatus" class="<?= $Page->LeftColumnClass ?>"><?= $Page->estatus->caption() ?><?= $Page->estatus->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->estatus->cellAttributes() ?>>
<span id="el_sco_reembolso_estatus">
    <select
        id="x_estatus"
        name="x_estatus"
        class="form-select ew-select<?= $Page->estatus->isInvalidClass() ?>"
        <?php if (!$Page->estatus->IsNativeSelect) { ?>
        data-select2-id="fsco_reembolsoedit_x_estatus"
        <?php } ?>
        data-table="sco_reembolso"
        data-field="x_estatus"
        data-value-separator="<?= $Page->estatus->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estatus->getPlaceHolder()) ?>"
        <?= $Page->estatus->editAttributes() ?>>
        <?= $Page->estatus->selectOptionListHtml("x_estatus") ?>
    </select>
    <?= $Page->estatus->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->estatus->getErrorMessage() ?></div>
<?php if (!$Page->estatus->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_reembolsoedit", function() {
    var options = { name: "x_estatus", selectId: "fsco_reembolsoedit_x_estatus" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_reembolsoedit.lists.estatus?.lookupOptions.length) {
        options.data = { id: "x_estatus", form: "fsco_reembolsoedit" };
    } else {
        options.ajax = { id: "x_estatus", form: "fsco_reembolsoedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_reembolso.fields.estatus.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="sco_reembolso" data-field="x_Nreembolso" data-hidden="1" name="x_Nreembolso" id="x_Nreembolso" value="<?= HtmlEncode($Page->Nreembolso->CurrentValue) ?>">
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_reembolsoedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_reembolsoedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_reembolso");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
