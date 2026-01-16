<?php

namespace PHPMaker2024\hercules;

// Page object
$ScoUserAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { sco_user: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fsco_useradd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fsco_useradd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["cedula", [fields.cedula.visible && fields.cedula.required ? ew.Validators.required(fields.cedula.caption) : null], fields.cedula.isInvalid],
            ["nombre", [fields.nombre.visible && fields.nombre.required ? ew.Validators.required(fields.nombre.caption) : null], fields.nombre.isInvalid],
            ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null], fields._username.isInvalid],
            ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
            ["correo", [fields.correo.visible && fields.correo.required ? ew.Validators.required(fields.correo.caption) : null, ew.Validators.email], fields.correo.isInvalid],
            ["direccion", [fields.direccion.visible && fields.direccion.required ? ew.Validators.required(fields.direccion.caption) : null], fields.direccion.isInvalid],
            ["level", [fields.level.visible && fields.level.required ? ew.Validators.required(fields.level.caption) : null], fields.level.isInvalid],
            ["activo", [fields.activo.visible && fields.activo.required ? ew.Validators.required(fields.activo.caption) : null], fields.activo.isInvalid],
            ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
            ["fecha_ingreso_cia", [fields.fecha_ingreso_cia.visible && fields.fecha_ingreso_cia.required ? ew.Validators.required(fields.fecha_ingreso_cia.caption) : null, ew.Validators.datetime(fields.fecha_ingreso_cia.clientFormatPattern)], fields.fecha_ingreso_cia.isInvalid],
            ["fecha_egreso_cia", [fields.fecha_egreso_cia.visible && fields.fecha_egreso_cia.required ? ew.Validators.required(fields.fecha_egreso_cia.caption) : null, ew.Validators.datetime(fields.fecha_egreso_cia.clientFormatPattern)], fields.fecha_egreso_cia.isInvalid],
            ["motivo_egreso", [fields.motivo_egreso.visible && fields.motivo_egreso.required ? ew.Validators.required(fields.motivo_egreso.caption) : null], fields.motivo_egreso.isInvalid],
            ["departamento", [fields.departamento.visible && fields.departamento.required ? ew.Validators.required(fields.departamento.caption) : null], fields.departamento.isInvalid],
            ["cargo", [fields.cargo.visible && fields.cargo.required ? ew.Validators.required(fields.cargo.caption) : null], fields.cargo.isInvalid],
            ["celular_1", [fields.celular_1.visible && fields.celular_1.required ? ew.Validators.required(fields.celular_1.caption) : null], fields.celular_1.isInvalid],
            ["celular_2", [fields.celular_2.visible && fields.celular_2.required ? ew.Validators.required(fields.celular_2.caption) : null], fields.celular_2.isInvalid],
            ["telefono_1", [fields.telefono_1.visible && fields.telefono_1.required ? ew.Validators.required(fields.telefono_1.caption) : null], fields.telefono_1.isInvalid],
            ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
            ["hora_entrada", [fields.hora_entrada.visible && fields.hora_entrada.required ? ew.Validators.required(fields.hora_entrada.caption) : null, ew.Validators.time(fields.hora_entrada.clientFormatPattern)], fields.hora_entrada.isInvalid],
            ["hora_salida", [fields.hora_salida.visible && fields.hora_salida.required ? ew.Validators.required(fields.hora_salida.caption) : null, ew.Validators.time(fields.hora_salida.clientFormatPattern)], fields.hora_salida.isInvalid],
            ["proveedor", [fields.proveedor.visible && fields.proveedor.required ? ew.Validators.required(fields.proveedor.caption) : null], fields.proveedor.isInvalid],
            ["seguro", [fields.seguro.visible && fields.seguro.required ? ew.Validators.required(fields.seguro.caption) : null], fields.seguro.isInvalid],
            ["evaluacion", [fields.evaluacion.visible && fields.evaluacion.required ? ew.Validators.required(fields.evaluacion.caption) : null], fields.evaluacion.isInvalid]
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
            "level": <?= $Page->level->toClientList($Page) ?>,
            "activo": <?= $Page->activo->toClientList($Page) ?>,
            "motivo_egreso": <?= $Page->motivo_egreso->toClientList($Page) ?>,
            "departamento": <?= $Page->departamento->toClientList($Page) ?>,
            "cargo": <?= $Page->cargo->toClientList($Page) ?>,
            "proveedor": <?= $Page->proveedor->toClientList($Page) ?>,
            "seguro": <?= $Page->seguro->toClientList($Page) ?>,
            "evaluacion": <?= $Page->evaluacion->toClientList($Page) ?>,
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
<form name="fsco_useradd" id="fsco_useradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="sco_user">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->cedula->Visible) { // cedula ?>
    <div id="r_cedula"<?= $Page->cedula->rowAttributes() ?>>
        <label id="elh_sco_user_cedula" for="x_cedula" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cedula->caption() ?><?= $Page->cedula->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cedula->cellAttributes() ?>>
<span id="el_sco_user_cedula">
<input type="<?= $Page->cedula->getInputTextType() ?>" name="x_cedula" id="x_cedula" data-table="sco_user" data-field="x_cedula" value="<?= $Page->cedula->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->cedula->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->cedula->formatPattern()) ?>"<?= $Page->cedula->editAttributes() ?> aria-describedby="x_cedula_help">
<?= $Page->cedula->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->cedula->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nombre->Visible) { // nombre ?>
    <div id="r_nombre"<?= $Page->nombre->rowAttributes() ?>>
        <label id="elh_sco_user_nombre" for="x_nombre" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nombre->caption() ?><?= $Page->nombre->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->nombre->cellAttributes() ?>>
<span id="el_sco_user_nombre">
<input type="<?= $Page->nombre->getInputTextType() ?>" name="x_nombre" id="x_nombre" data-table="sco_user" data-field="x_nombre" value="<?= $Page->nombre->EditValue ?>" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nombre->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->nombre->formatPattern()) ?>"<?= $Page->nombre->editAttributes() ?> aria-describedby="x_nombre_help">
<?= $Page->nombre->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nombre->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username"<?= $Page->_username->rowAttributes() ?>>
        <label id="elh_sco_user__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_username->cellAttributes() ?>>
<span id="el_sco_user__username">
<input type="<?= $Page->_username->getInputTextType() ?>" name="x__username" id="x__username" data-table="sco_user" data-field="x__username" value="<?= $Page->_username->EditValue ?>" size="30" maxlength="25" placeholder="<?= HtmlEncode($Page->_username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_username->formatPattern()) ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <div id="r__password"<?= $Page->_password->rowAttributes() ?>>
        <label id="elh_sco_user__password" for="x__password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_password->caption() ?><?= $Page->_password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_password->cellAttributes() ?>>
<span id="el_sco_user__password">
<div class="input-group">
    <input type="password" name="x__password" id="x__password" autocomplete="new-password" data-table="sco_user" data-field="x__password" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->_password->getPlaceHolder()) ?>"<?= $Page->_password->editAttributes() ?> aria-describedby="x__password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->_password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_password->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->correo->Visible) { // correo ?>
    <div id="r_correo"<?= $Page->correo->rowAttributes() ?>>
        <label id="elh_sco_user_correo" for="x_correo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->correo->caption() ?><?= $Page->correo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->correo->cellAttributes() ?>>
<span id="el_sco_user_correo">
<input type="<?= $Page->correo->getInputTextType() ?>" name="x_correo" id="x_correo" data-table="sco_user" data-field="x_correo" value="<?= $Page->correo->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->correo->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->correo->formatPattern()) ?>"<?= $Page->correo->editAttributes() ?> aria-describedby="x_correo_help">
<?= $Page->correo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->correo->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->direccion->Visible) { // direccion ?>
    <div id="r_direccion"<?= $Page->direccion->rowAttributes() ?>>
        <label id="elh_sco_user_direccion" for="x_direccion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->direccion->caption() ?><?= $Page->direccion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->direccion->cellAttributes() ?>>
<span id="el_sco_user_direccion">
<textarea data-table="sco_user" data-field="x_direccion" name="x_direccion" id="x_direccion" cols="30" rows="3" placeholder="<?= HtmlEncode($Page->direccion->getPlaceHolder()) ?>"<?= $Page->direccion->editAttributes() ?> aria-describedby="x_direccion_help"><?= $Page->direccion->EditValue ?></textarea>
<?= $Page->direccion->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->direccion->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
    <div id="r_level"<?= $Page->level->rowAttributes() ?>>
        <label id="elh_sco_user_level" for="x_level" class="<?= $Page->LeftColumnClass ?>"><?= $Page->level->caption() ?><?= $Page->level->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->level->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el_sco_user_level">
<span class="form-control-plaintext"><?= $Page->level->getDisplayValue($Page->level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el_sco_user_level">
    <select
        id="x_level"
        name="x_level"
        class="form-control ew-select<?= $Page->level->isInvalidClass() ?>"
        data-select2-id="fsco_useradd_x_level"
        data-table="sco_user"
        data-field="x_level"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->level->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->level->getPlaceHolder()) ?>"
        <?= $Page->level->editAttributes() ?>>
        <?= $Page->level->selectOptionListHtml("x_level") ?>
    </select>
    <?= $Page->level->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->level->getErrorMessage() ?></div>
<?= $Page->level->Lookup->getParamTag($Page, "p_x_level") ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_level", selectId: "fsco_useradd_x_level" };
    if (fsco_useradd.lists.level?.lookupOptions.length) {
        options.data = { id: "x_level", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_level", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_user.fields.level.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->activo->Visible) { // activo ?>
    <div id="r_activo"<?= $Page->activo->rowAttributes() ?>>
        <label id="elh_sco_user_activo" for="x_activo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->activo->caption() ?><?= $Page->activo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->activo->cellAttributes() ?>>
<span id="el_sco_user_activo">
    <select
        id="x_activo"
        name="x_activo"
        class="form-select ew-select<?= $Page->activo->isInvalidClass() ?>"
        <?php if (!$Page->activo->IsNativeSelect) { ?>
        data-select2-id="fsco_useradd_x_activo"
        <?php } ?>
        data-table="sco_user"
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
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_activo", selectId: "fsco_useradd_x_activo" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_useradd.lists.activo?.lookupOptions.length) {
        options.data = { id: "x_activo", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_activo", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_user.fields.activo.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto"<?= $Page->foto->rowAttributes() ?>>
        <label id="elh_sco_user_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->foto->cellAttributes() ?>>
<span id="el_sco_user_foto">
<div id="fd_x_foto" class="fileinput-button ew-file-drop-zone">
    <input
        type="file"
        id="x_foto"
        name="x_foto"
        class="form-control ew-file-input"
        title="<?= $Page->foto->title() ?>"
        lang="<?= CurrentLanguageID() ?>"
        data-table="sco_user"
        data-field="x_foto"
        data-size="255"
        data-accept-file-types="<?= $Page->foto->acceptFileTypes() ?>"
        data-max-file-size="<?= $Page->foto->UploadMaxFileSize ?>"
        data-max-number-of-files="null"
        data-disable-image-crop="<?= $Page->foto->ImageCropper ? 0 : 1 ?>"
        aria-describedby="x_foto_help"
        <?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?>
        <?= $Page->foto->editAttributes() ?>
    >
    <div class="text-body-secondary ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
    <?= $Page->foto->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
</div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="0">
<table id="ft_x_foto" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_ingreso_cia->Visible) { // fecha_ingreso_cia ?>
    <div id="r_fecha_ingreso_cia"<?= $Page->fecha_ingreso_cia->rowAttributes() ?>>
        <label id="elh_sco_user_fecha_ingreso_cia" for="x_fecha_ingreso_cia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_ingreso_cia->caption() ?><?= $Page->fecha_ingreso_cia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_ingreso_cia->cellAttributes() ?>>
<span id="el_sco_user_fecha_ingreso_cia">
<input type="<?= $Page->fecha_ingreso_cia->getInputTextType() ?>" name="x_fecha_ingreso_cia" id="x_fecha_ingreso_cia" data-table="sco_user" data-field="x_fecha_ingreso_cia" value="<?= $Page->fecha_ingreso_cia->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fecha_ingreso_cia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_ingreso_cia->formatPattern()) ?>"<?= $Page->fecha_ingreso_cia->editAttributes() ?> aria-describedby="x_fecha_ingreso_cia_help">
<?= $Page->fecha_ingreso_cia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_ingreso_cia->getErrorMessage() ?></div>
<?php if (!$Page->fecha_ingreso_cia->ReadOnly && !$Page->fecha_ingreso_cia->Disabled && !isset($Page->fecha_ingreso_cia->EditAttrs["readonly"]) && !isset($Page->fecha_ingreso_cia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_useradd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_useradd", "x_fecha_ingreso_cia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fecha_egreso_cia->Visible) { // fecha_egreso_cia ?>
    <div id="r_fecha_egreso_cia"<?= $Page->fecha_egreso_cia->rowAttributes() ?>>
        <label id="elh_sco_user_fecha_egreso_cia" for="x_fecha_egreso_cia" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fecha_egreso_cia->caption() ?><?= $Page->fecha_egreso_cia->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->fecha_egreso_cia->cellAttributes() ?>>
<span id="el_sco_user_fecha_egreso_cia">
<input type="<?= $Page->fecha_egreso_cia->getInputTextType() ?>" name="x_fecha_egreso_cia" id="x_fecha_egreso_cia" data-table="sco_user" data-field="x_fecha_egreso_cia" value="<?= $Page->fecha_egreso_cia->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->fecha_egreso_cia->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_egreso_cia->formatPattern()) ?>"<?= $Page->fecha_egreso_cia->editAttributes() ?> aria-describedby="x_fecha_egreso_cia_help">
<?= $Page->fecha_egreso_cia->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fecha_egreso_cia->getErrorMessage() ?></div>
<?php if (!$Page->fecha_egreso_cia->ReadOnly && !$Page->fecha_egreso_cia->Disabled && !isset($Page->fecha_egreso_cia->EditAttrs["readonly"]) && !isset($Page->fecha_egreso_cia->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_useradd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fsco_useradd", "x_fecha_egreso_cia", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->motivo_egreso->Visible) { // motivo_egreso ?>
    <div id="r_motivo_egreso"<?= $Page->motivo_egreso->rowAttributes() ?>>
        <label id="elh_sco_user_motivo_egreso" for="x_motivo_egreso" class="<?= $Page->LeftColumnClass ?>"><?= $Page->motivo_egreso->caption() ?><?= $Page->motivo_egreso->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->motivo_egreso->cellAttributes() ?>>
<span id="el_sco_user_motivo_egreso">
    <select
        id="x_motivo_egreso"
        name="x_motivo_egreso"
        class="form-select ew-select<?= $Page->motivo_egreso->isInvalidClass() ?>"
        <?php if (!$Page->motivo_egreso->IsNativeSelect) { ?>
        data-select2-id="fsco_useradd_x_motivo_egreso"
        <?php } ?>
        data-table="sco_user"
        data-field="x_motivo_egreso"
        data-value-separator="<?= $Page->motivo_egreso->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->motivo_egreso->getPlaceHolder()) ?>"
        <?= $Page->motivo_egreso->editAttributes() ?>>
        <?= $Page->motivo_egreso->selectOptionListHtml("x_motivo_egreso") ?>
    </select>
    <?= $Page->motivo_egreso->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->motivo_egreso->getErrorMessage() ?></div>
<?= $Page->motivo_egreso->Lookup->getParamTag($Page, "p_x_motivo_egreso") ?>
<?php if (!$Page->motivo_egreso->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_motivo_egreso", selectId: "fsco_useradd_x_motivo_egreso" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_useradd.lists.motivo_egreso?.lookupOptions.length) {
        options.data = { id: "x_motivo_egreso", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_motivo_egreso", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_user.fields.motivo_egreso.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->departamento->Visible) { // departamento ?>
    <div id="r_departamento"<?= $Page->departamento->rowAttributes() ?>>
        <label id="elh_sco_user_departamento" for="x_departamento" class="<?= $Page->LeftColumnClass ?>"><?= $Page->departamento->caption() ?><?= $Page->departamento->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->departamento->cellAttributes() ?>>
<span id="el_sco_user_departamento">
    <select
        id="x_departamento"
        name="x_departamento"
        class="form-control ew-select<?= $Page->departamento->isInvalidClass() ?>"
        data-select2-id="fsco_useradd_x_departamento"
        data-table="sco_user"
        data-field="x_departamento"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->departamento->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->departamento->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamento->getPlaceHolder()) ?>"
        <?= $Page->departamento->editAttributes() ?>>
        <?= $Page->departamento->selectOptionListHtml("x_departamento") ?>
    </select>
    <?= $Page->departamento->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->departamento->getErrorMessage() ?></div>
<?= $Page->departamento->Lookup->getParamTag($Page, "p_x_departamento") ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_departamento", selectId: "fsco_useradd_x_departamento" };
    if (fsco_useradd.lists.departamento?.lookupOptions.length) {
        options.data = { id: "x_departamento", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_departamento", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_user.fields.departamento.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->cargo->Visible) { // cargo ?>
    <div id="r_cargo"<?= $Page->cargo->rowAttributes() ?>>
        <label id="elh_sco_user_cargo" for="x_cargo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->cargo->caption() ?><?= $Page->cargo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->cargo->cellAttributes() ?>>
<span id="el_sco_user_cargo">
    <select
        id="x_cargo"
        name="x_cargo"
        class="form-control ew-select<?= $Page->cargo->isInvalidClass() ?>"
        data-select2-id="fsco_useradd_x_cargo"
        data-table="sco_user"
        data-field="x_cargo"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->cargo->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->cargo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->cargo->getPlaceHolder()) ?>"
        <?= $Page->cargo->editAttributes() ?>>
        <?= $Page->cargo->selectOptionListHtml("x_cargo") ?>
    </select>
    <?= $Page->cargo->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->cargo->getErrorMessage() ?></div>
<?= $Page->cargo->Lookup->getParamTag($Page, "p_x_cargo") ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_cargo", selectId: "fsco_useradd_x_cargo" };
    if (fsco_useradd.lists.cargo?.lookupOptions.length) {
        options.data = { id: "x_cargo", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_cargo", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_user.fields.cargo.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->celular_1->Visible) { // celular_1 ?>
    <div id="r_celular_1"<?= $Page->celular_1->rowAttributes() ?>>
        <label id="elh_sco_user_celular_1" for="x_celular_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->celular_1->caption() ?><?= $Page->celular_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->celular_1->cellAttributes() ?>>
<span id="el_sco_user_celular_1">
<input type="<?= $Page->celular_1->getInputTextType() ?>" name="x_celular_1" id="x_celular_1" data-table="sco_user" data-field="x_celular_1" value="<?= $Page->celular_1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->celular_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->celular_1->formatPattern()) ?>"<?= $Page->celular_1->editAttributes() ?> aria-describedby="x_celular_1_help">
<?= $Page->celular_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->celular_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->celular_2->Visible) { // celular_2 ?>
    <div id="r_celular_2"<?= $Page->celular_2->rowAttributes() ?>>
        <label id="elh_sco_user_celular_2" for="x_celular_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->celular_2->caption() ?><?= $Page->celular_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->celular_2->cellAttributes() ?>>
<span id="el_sco_user_celular_2">
<input type="<?= $Page->celular_2->getInputTextType() ?>" name="x_celular_2" id="x_celular_2" data-table="sco_user" data-field="x_celular_2" value="<?= $Page->celular_2->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->celular_2->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->celular_2->formatPattern()) ?>"<?= $Page->celular_2->editAttributes() ?> aria-describedby="x_celular_2_help">
<?= $Page->celular_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->celular_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telefono_1->Visible) { // telefono_1 ?>
    <div id="r_telefono_1"<?= $Page->telefono_1->rowAttributes() ?>>
        <label id="elh_sco_user_telefono_1" for="x_telefono_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telefono_1->caption() ?><?= $Page->telefono_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->telefono_1->cellAttributes() ?>>
<span id="el_sco_user_telefono_1">
<input type="<?= $Page->telefono_1->getInputTextType() ?>" name="x_telefono_1" id="x_telefono_1" data-table="sco_user" data-field="x_telefono_1" value="<?= $Page->telefono_1->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->telefono_1->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->telefono_1->formatPattern()) ?>"<?= $Page->telefono_1->editAttributes() ?> aria-describedby="x_telefono_1_help">
<?= $Page->telefono_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telefono_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email"<?= $Page->_email->rowAttributes() ?>>
        <label id="elh_sco_user__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_email->cellAttributes() ?>>
<span id="el_sco_user__email">
<input type="<?= $Page->_email->getInputTextType() ?>" name="x__email" id="x__email" data-table="sco_user" data-field="x__email" value="<?= $Page->_email->EditValue ?>" size="30" maxlength="150" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_email->formatPattern()) ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_entrada->Visible) { // hora_entrada ?>
    <div id="r_hora_entrada"<?= $Page->hora_entrada->rowAttributes() ?>>
        <label id="elh_sco_user_hora_entrada" for="x_hora_entrada" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_entrada->caption() ?><?= $Page->hora_entrada->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_entrada->cellAttributes() ?>>
<span id="el_sco_user_hora_entrada">
<input type="<?= $Page->hora_entrada->getInputTextType() ?>" name="x_hora_entrada" id="x_hora_entrada" data-table="sco_user" data-field="x_hora_entrada" value="<?= $Page->hora_entrada->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->hora_entrada->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora_entrada->formatPattern()) ?>"<?= $Page->hora_entrada->editAttributes() ?> aria-describedby="x_hora_entrada_help">
<?= $Page->hora_entrada->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora_entrada->getErrorMessage() ?></div>
<?php if (!$Page->hora_entrada->ReadOnly && !$Page->hora_entrada->Disabled && !isset($Page->hora_entrada->EditAttrs["readonly"]) && !isset($Page->hora_entrada->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_useradd", "timepicker"], () => ew.createTimePicker("fsco_useradd", "x_hora_entrada", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(3) ?>" })));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hora_salida->Visible) { // hora_salida ?>
    <div id="r_hora_salida"<?= $Page->hora_salida->rowAttributes() ?>>
        <label id="elh_sco_user_hora_salida" for="x_hora_salida" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hora_salida->caption() ?><?= $Page->hora_salida->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->hora_salida->cellAttributes() ?>>
<span id="el_sco_user_hora_salida">
<input type="<?= $Page->hora_salida->getInputTextType() ?>" name="x_hora_salida" id="x_hora_salida" data-table="sco_user" data-field="x_hora_salida" value="<?= $Page->hora_salida->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->hora_salida->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->hora_salida->formatPattern()) ?>"<?= $Page->hora_salida->editAttributes() ?> aria-describedby="x_hora_salida_help">
<?= $Page->hora_salida->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hora_salida->getErrorMessage() ?></div>
<?php if (!$Page->hora_salida->ReadOnly && !$Page->hora_salida->Disabled && !isset($Page->hora_salida->EditAttrs["readonly"]) && !isset($Page->hora_salida->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fsco_useradd", "timepicker"], () => ew.createTimePicker("fsco_useradd", "x_hora_salida", Object.assign({"step":15}, { timeFormat: "<?= DateFormat(3) ?>" })));
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->proveedor->Visible) { // proveedor ?>
    <div id="r_proveedor"<?= $Page->proveedor->rowAttributes() ?>>
        <label id="elh_sco_user_proveedor" for="x_proveedor" class="<?= $Page->LeftColumnClass ?>"><?= $Page->proveedor->caption() ?><?= $Page->proveedor->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->proveedor->cellAttributes() ?>>
<span id="el_sco_user_proveedor">
    <select
        id="x_proveedor"
        name="x_proveedor"
        class="form-control ew-select<?= $Page->proveedor->isInvalidClass() ?>"
        data-select2-id="fsco_useradd_x_proveedor"
        data-table="sco_user"
        data-field="x_proveedor"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->proveedor->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->proveedor->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->proveedor->getPlaceHolder()) ?>"
        <?= $Page->proveedor->editAttributes() ?>>
        <?= $Page->proveedor->selectOptionListHtml("x_proveedor") ?>
    </select>
    <?= $Page->proveedor->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->proveedor->getErrorMessage() ?></div>
<?= $Page->proveedor->Lookup->getParamTag($Page, "p_x_proveedor") ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_proveedor", selectId: "fsco_useradd_x_proveedor" };
    if (fsco_useradd.lists.proveedor?.lookupOptions.length) {
        options.data = { id: "x_proveedor", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_proveedor", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_user.fields.proveedor.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->seguro->Visible) { // seguro ?>
    <div id="r_seguro"<?= $Page->seguro->rowAttributes() ?>>
        <label id="elh_sco_user_seguro" for="x_seguro" class="<?= $Page->LeftColumnClass ?>"><?= $Page->seguro->caption() ?><?= $Page->seguro->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->seguro->cellAttributes() ?>>
<span id="el_sco_user_seguro">
    <select
        id="x_seguro"
        name="x_seguro"
        class="form-control ew-select<?= $Page->seguro->isInvalidClass() ?>"
        data-select2-id="fsco_useradd_x_seguro"
        data-table="sco_user"
        data-field="x_seguro"
        data-caption="<?= HtmlEncode(RemoveHtml($Page->seguro->caption())) ?>"
        data-modal-lookup="true"
        data-value-separator="<?= $Page->seguro->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->seguro->getPlaceHolder()) ?>"
        <?= $Page->seguro->editAttributes() ?>>
        <?= $Page->seguro->selectOptionListHtml("x_seguro") ?>
    </select>
    <?= $Page->seguro->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->seguro->getErrorMessage() ?></div>
<?= $Page->seguro->Lookup->getParamTag($Page, "p_x_seguro") ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_seguro", selectId: "fsco_useradd_x_seguro" };
    if (fsco_useradd.lists.seguro?.lookupOptions.length) {
        options.data = { id: "x_seguro", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_seguro", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options = Object.assign({}, ew.modalLookupOptions, options, ew.vars.tables.sco_user.fields.seguro.modalLookupOptions);
    ew.createModalLookup(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->evaluacion->Visible) { // evaluacion ?>
    <div id="r_evaluacion"<?= $Page->evaluacion->rowAttributes() ?>>
        <label id="elh_sco_user_evaluacion" for="x_evaluacion" class="<?= $Page->LeftColumnClass ?>"><?= $Page->evaluacion->caption() ?><?= $Page->evaluacion->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->evaluacion->cellAttributes() ?>>
<span id="el_sco_user_evaluacion">
    <select
        id="x_evaluacion"
        name="x_evaluacion"
        class="form-select ew-select<?= $Page->evaluacion->isInvalidClass() ?>"
        <?php if (!$Page->evaluacion->IsNativeSelect) { ?>
        data-select2-id="fsco_useradd_x_evaluacion"
        <?php } ?>
        data-table="sco_user"
        data-field="x_evaluacion"
        data-value-separator="<?= $Page->evaluacion->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->evaluacion->getPlaceHolder()) ?>"
        <?= $Page->evaluacion->editAttributes() ?>>
        <?= $Page->evaluacion->selectOptionListHtml("x_evaluacion") ?>
    </select>
    <?= $Page->evaluacion->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->evaluacion->getErrorMessage() ?></div>
<?php if (!$Page->evaluacion->IsNativeSelect) { ?>
<script>
loadjs.ready("fsco_useradd", function() {
    var options = { name: "x_evaluacion", selectId: "fsco_useradd_x_evaluacion" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fsco_useradd.lists.evaluacion?.lookupOptions.length) {
        options.data = { id: "x_evaluacion", form: "fsco_useradd" };
    } else {
        options.ajax = { id: "x_evaluacion", form: "fsco_useradd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.sco_user.fields.evaluacion.selectOptions);
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
    if (in_array("sco_user_nota", explode(",", $Page->getCurrentDetailTable())) && $sco_user_nota->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_user_nota", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoUserNotaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("sco_user_adjunto", explode(",", $Page->getCurrentDetailTable())) && $sco_user_adjunto->DetailAdd) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("sco_user_adjunto", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ScoUserAdjuntoGrid.php" ?>
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fsco_useradd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fsco_useradd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("sco_user");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $("#x_cedula").change(function(){
    	var xBad = true;
    	$("#x_cedula").val($("#x_cedula").val().replace(" ",""));
    	$("#x_cedula").val($("#x_cedula").val().replace(".",""));
    	$("#x_cedula").val($("#x_cedula").val().replace(",",""));
    	if($("#x_cedula").val().substring(1,2)!="-")
    		$("#x_cedula").val($("#x_cedula").val().substring(0,1) + "-" + $("#x_cedula").val().substring(1,$("#x_cedula").val().length).trim());
    	$("#x_cedula").val($("#x_cedula").val().toUpperCase());
    	if($("#x_cedula").val()==""){
    		alert("Este campo no puede estar vacio");
    		xBad = false;
    	}else if($("#x_cedula").val().length < 7) {
    		alert("Este campo debe ser mayor a 6 caracteres");
    		xBad = false;
    	}else if($("#x_cedula").val().length > 12) {
    		alert("Este campo debe ser menor a 12 caracteres");
    		xBad = false;
    	}else if($("#x_cedula").val().substring(0,2) != "V-" && $("#x_cedula").val().substring(0,2) != "E-" && $("#x_cedula").val().substring(0,2) != "M-") {
    		alert("La CI debe comenzar con (V-) Venezolano o con (E-) Extranjero o con (M-) Menor de edad sin poseer CI.");
    		xBad = false;
    	}else if(isNaN($("#x_cedula").val().substring(2,$("#x_cedula").val().length))) {
    		alert("La CI debe ser un valor entero");
    		xBad = false;
    	}
    	if(xBad == false) {
    		$("#x_cedula").val("");
    		return false;
    	}
    });
});
</script>
