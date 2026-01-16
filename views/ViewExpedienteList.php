<?php

namespace PHPMaker2024\hercules;

// Page object
$ViewExpedienteList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR ??= ".ew-preview-btn";
ew.PREVIEW_TYPE ??= "row";
ew.PREVIEW_NAV_STYLE ??= "tabs"; // tabs/pills/underline
ew.PREVIEW_MODAL_CLASS ??= "modal modal-fullscreen-sm-down";
ew.PREVIEW_ROW ??= true;
ew.PREVIEW_SINGLE_ROW ??= false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.js?v=24.16.0", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Client script
    // Write your client script here, no need to add script tags.
    window.printprepa = function (formname, rpt) {
    	var anyBoxesChecked = false;
    	var exp = "";
    	$('#' + formname + ' input[type="checkbox"]').each(function() {
    		if ($(this).is(":checked")) {
    			//alert($(this).val());
    			exp += parseInt($(this).val()) + ",";
    		}
    	});
    	if (exp != "") {
    	  exp = exp.substring(0,exp.length-1);
      	  if(rpt==1) 
      	  	url = "fpdf_report/rptCapillaDifunto.php?exp="+exp;
      	  else
      	  	url = "fpdf_report/rptFormatoContactos.php?exp="+exp;
    	  window.open(url);	  
    	} 
    }
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fview_expedientesrch" id="fview_expedientesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="off">
<div id="fview_expedientesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_expediente: currentTable } });
var currentForm;
var fview_expedientesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fview_expedientesrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Add fields
        .addFields([
            ["Nexpediente", [ew.Validators.integer], fields.Nexpediente.isInvalid],
            ["fecha_inicio", [ew.Validators.datetime(fields.fecha_inicio.clientFormatPattern)], fields.fecha_inicio.isInvalid],
            ["y_fecha_inicio", [ew.Validators.between], false],
            ["servicio", [], fields.servicio.isInvalid],
            ["fecha_serv", [ew.Validators.datetime(fields.fecha_serv.clientFormatPattern)], fields.fecha_serv.isInvalid],
            ["y_fecha_serv", [ew.Validators.between], false]
        ])
        // Validate form
        .setValidate(
            async function () {
                if (!this.validateRequired)
                    return true; // Ignore validation
                let fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

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
            "servicio": <?= $Page->servicio->toClientList($Page) ?>,
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)

        // Init search panel as collapsed
        .setInitSearchPanel(true)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = RowType::SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
<?php
if (!$Page->Nexpediente->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_Nexpediente" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->Nexpediente->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_Nexpediente" class="ew-search-caption ew-label"><?= $Page->Nexpediente->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Nexpediente" id="z_Nexpediente" value="=">
</div>
        </div>
        <div id="el_view_expediente_Nexpediente" class="ew-search-field">
<input type="<?= $Page->Nexpediente->getInputTextType() ?>" name="x_Nexpediente" id="x_Nexpediente" data-table="view_expediente" data-field="x_Nexpediente" value="<?= $Page->Nexpediente->EditValue ?>" placeholder="<?= HtmlEncode($Page->Nexpediente->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Nexpediente->formatPattern()) ?>"<?= $Page->Nexpediente->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Nexpediente->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
<?php
if (!$Page->fecha_inicio->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_inicio" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_inicio->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_inicio" class="ew-search-caption ew-label"><?= $Page->fecha_inicio->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_inicio" id="z_fecha_inicio" value="BETWEEN">
</div>
        </div>
        <div id="el_view_expediente_fecha_inicio" class="ew-search-field">
<input type="<?= $Page->fecha_inicio->getInputTextType() ?>" name="x_fecha_inicio" id="x_fecha_inicio" data-table="view_expediente" data-field="x_fecha_inicio" value="<?= $Page->fecha_inicio->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_inicio->formatPattern()) ?>"<?= $Page->fecha_inicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_inicio->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_inicio->ReadOnly && !$Page->fecha_inicio->Disabled && !isset($Page->fecha_inicio->EditAttrs["readonly"]) && !isset($Page->fecha_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_expedientesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_expedientesrch", "x_fecha_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_expediente_fecha_inicio" class="ew-search-field2">
<input type="<?= $Page->fecha_inicio->getInputTextType() ?>" name="y_fecha_inicio" id="y_fecha_inicio" data-table="view_expediente" data-field="x_fecha_inicio" value="<?= $Page->fecha_inicio->EditValue2 ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_inicio->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_inicio->formatPattern()) ?>"<?= $Page->fecha_inicio->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_inicio->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_inicio->ReadOnly && !$Page->fecha_inicio->Disabled && !isset($Page->fecha_inicio->EditAttrs["readonly"]) && !isset($Page->fecha_inicio->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_expedientesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_expedientesrch", "y_fecha_inicio", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
<?php
if (!$Page->servicio->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_servicio" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->servicio->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_servicio" class="ew-search-caption ew-label"><?= $Page->servicio->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_servicio" id="z_servicio" value="=">
</div>
        </div>
        <div id="el_view_expediente_servicio" class="ew-search-field">
    <select
        id="x_servicio"
        name="x_servicio"
        class="form-select ew-select<?= $Page->servicio->isInvalidClass() ?>"
        <?php if (!$Page->servicio->IsNativeSelect) { ?>
        data-select2-id="fview_expedientesrch_x_servicio"
        <?php } ?>
        data-table="view_expediente"
        data-field="x_servicio"
        data-value-separator="<?= $Page->servicio->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->servicio->getPlaceHolder()) ?>"
        <?= $Page->servicio->editAttributes() ?>>
        <?= $Page->servicio->selectOptionListHtml("x_servicio") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->servicio->getErrorMessage(false) ?></div>
<?= $Page->servicio->Lookup->getParamTag($Page, "p_x_servicio") ?>
<?php if (!$Page->servicio->IsNativeSelect) { ?>
<script>
loadjs.ready("fview_expedientesrch", function() {
    var options = { name: "x_servicio", selectId: "fview_expedientesrch_x_servicio" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_expedientesrch.lists.servicio?.lookupOptions.length) {
        options.data = { id: "x_servicio", form: "fview_expedientesrch" };
    } else {
        options.ajax = { id: "x_servicio", form: "fview_expedientesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_expediente.fields.servicio.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->fecha_serv->Visible) { // fecha_serv ?>
<?php
if (!$Page->fecha_serv->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_fecha_serv" class="col-sm-auto d-sm-flex align-items-start mb-3 px-0 pe-sm-2<?= $Page->fecha_serv->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_fecha_serv" class="ew-search-caption ew-label"><?= $Page->fecha_serv->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_fecha_serv" id="z_fecha_serv" value="BETWEEN">
</div>
        </div>
        <div id="el_view_expediente_fecha_serv" class="ew-search-field">
<input type="<?= $Page->fecha_serv->getInputTextType() ?>" name="x_fecha_serv" id="x_fecha_serv" data-table="view_expediente" data-field="x_fecha_serv" value="<?= $Page->fecha_serv->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_serv->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_serv->formatPattern()) ?>"<?= $Page->fecha_serv->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_serv->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_serv->ReadOnly && !$Page->fecha_serv->Disabled && !isset($Page->fecha_serv->EditAttrs["readonly"]) && !isset($Page->fecha_serv->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_expedientesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_expedientesrch", "x_fecha_serv", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_view_expediente_fecha_serv" class="ew-search-field2">
<input type="<?= $Page->fecha_serv->getInputTextType() ?>" name="y_fecha_serv" id="y_fecha_serv" data-table="view_expediente" data-field="x_fecha_serv" value="<?= $Page->fecha_serv->EditValue2 ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->fecha_serv->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->fecha_serv->formatPattern()) ?>"<?= $Page->fecha_serv->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->fecha_serv->getErrorMessage(false) ?></div>
<?php if (!$Page->fecha_serv->ReadOnly && !$Page->fecha_serv->Disabled && !isset($Page->fecha_serv->EditAttrs["readonly"]) && !isset($Page->fecha_serv->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_expedientesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_expedientesrch", "y_fecha_serv", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_expedientesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_expedientesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_expedientesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_expedientesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<div id="ew-header-options">
<?php $Page->HeaderOptions?->render("body") ?>
</div>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="off">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_expediente">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_view_expediente" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_view_expedientelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = RowType::HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <th data-name="Nexpediente" class="<?= $Page->Nexpediente->headerCellClass() ?>"><div id="elh_view_expediente_Nexpediente" class="view_expediente_Nexpediente"><?= $Page->renderFieldHeader($Page->Nexpediente) ?></div></th>
<?php } ?>
<?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <th data-name="cedula_fallecido" class="<?= $Page->cedula_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_cedula_fallecido" class="view_expediente_cedula_fallecido"><?= $Page->renderFieldHeader($Page->cedula_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <th data-name="nombre_fallecido" class="<?= $Page->nombre_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_nombre_fallecido" class="view_expediente_nombre_fallecido"><?= $Page->renderFieldHeader($Page->nombre_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <th data-name="apellidos_fallecido" class="<?= $Page->apellidos_fallecido->headerCellClass() ?>"><div id="elh_view_expediente_apellidos_fallecido" class="view_expediente_apellidos_fallecido"><?= $Page->renderFieldHeader($Page->apellidos_fallecido) ?></div></th>
<?php } ?>
<?php if ($Page->permiso->Visible) { // permiso ?>
        <th data-name="permiso" class="<?= $Page->permiso->headerCellClass() ?>"><div id="elh_view_expediente_permiso" class="view_expediente_permiso"><?= $Page->renderFieldHeader($Page->permiso) ?></div></th>
<?php } ?>
<?php if ($Page->capilla->Visible) { // capilla ?>
        <th data-name="capilla" class="<?= $Page->capilla->headerCellClass() ?>"><div id="elh_view_expediente_capilla" class="view_expediente_capilla"><?= $Page->renderFieldHeader($Page->capilla) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
        <th data-name="fecha_inicio" class="<?= $Page->fecha_inicio->headerCellClass() ?>"><div id="elh_view_expediente_fecha_inicio" class="view_expediente_fecha_inicio"><?= $Page->renderFieldHeader($Page->fecha_inicio) ?></div></th>
<?php } ?>
<?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
        <th data-name="hora_inicio" class="<?= $Page->hora_inicio->headerCellClass() ?>"><div id="elh_view_expediente_hora_inicio" class="view_expediente_hora_inicio"><?= $Page->renderFieldHeader($Page->hora_inicio) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
        <th data-name="fecha_fin" class="<?= $Page->fecha_fin->headerCellClass() ?>"><div id="elh_view_expediente_fecha_fin" class="view_expediente_fecha_fin"><?= $Page->renderFieldHeader($Page->fecha_fin) ?></div></th>
<?php } ?>
<?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <th data-name="hora_fin" class="<?= $Page->hora_fin->headerCellClass() ?>"><div id="elh_view_expediente_hora_fin" class="view_expediente_hora_fin"><?= $Page->renderFieldHeader($Page->hora_fin) ?></div></th>
<?php } ?>
<?php if ($Page->servicio->Visible) { // servicio ?>
        <th data-name="servicio" class="<?= $Page->servicio->headerCellClass() ?>"><div id="elh_view_expediente_servicio" class="view_expediente_servicio"><?= $Page->renderFieldHeader($Page->servicio) ?></div></th>
<?php } ?>
<?php if ($Page->fecha_serv->Visible) { // fecha_serv ?>
        <th data-name="fecha_serv" class="<?= $Page->fecha_serv->headerCellClass() ?>"><div id="elh_view_expediente_fecha_serv" class="view_expediente_fecha_serv"><?= $Page->renderFieldHeader($Page->fecha_serv) ?></div></th>
<?php } ?>
<?php if ($Page->hora_serv->Visible) { // hora_serv ?>
        <th data-name="hora_serv" class="<?= $Page->hora_serv->headerCellClass() ?>"><div id="elh_view_expediente_hora_serv" class="view_expediente_hora_serv"><?= $Page->renderFieldHeader($Page->hora_serv) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
$isInlineAddOrCopy = ($Page->isCopy() || $Page->isAdd());
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$' || $isInlineAddOrCopy && $Page->RowIndex == 0) {
    if (
        $Page->CurrentRow !== false &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        !($isInlineAddOrCopy && $Page->RowIndex == 0)
    ) {
        $Page->fetch();
    }
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->Nexpediente->Visible) { // Nexpediente ?>
        <td data-name="Nexpediente"<?= $Page->Nexpediente->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_Nexpediente" class="el_view_expediente_Nexpediente">
<span<?= $Page->Nexpediente->viewAttributes() ?>>
<?= $Page->Nexpediente->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cedula_fallecido->Visible) { // cedula_fallecido ?>
        <td data-name="cedula_fallecido"<?= $Page->cedula_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_cedula_fallecido" class="el_view_expediente_cedula_fallecido">
<span<?= $Page->cedula_fallecido->viewAttributes() ?>>
<?= $Page->cedula_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nombre_fallecido->Visible) { // nombre_fallecido ?>
        <td data-name="nombre_fallecido"<?= $Page->nombre_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_nombre_fallecido" class="el_view_expediente_nombre_fallecido">
<span<?= $Page->nombre_fallecido->viewAttributes() ?>>
<?= $Page->nombre_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->apellidos_fallecido->Visible) { // apellidos_fallecido ?>
        <td data-name="apellidos_fallecido"<?= $Page->apellidos_fallecido->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_apellidos_fallecido" class="el_view_expediente_apellidos_fallecido">
<span<?= $Page->apellidos_fallecido->viewAttributes() ?>>
<?= $Page->apellidos_fallecido->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->permiso->Visible) { // permiso ?>
        <td data-name="permiso"<?= $Page->permiso->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_permiso" class="el_view_expediente_permiso">
<span<?= $Page->permiso->viewAttributes() ?>>
<?= $Page->permiso->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->capilla->Visible) { // capilla ?>
        <td data-name="capilla"<?= $Page->capilla->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_capilla" class="el_view_expediente_capilla">
<span<?= $Page->capilla->viewAttributes() ?>>
<?= $Page->capilla->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_inicio->Visible) { // fecha_inicio ?>
        <td data-name="fecha_inicio"<?= $Page->fecha_inicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_fecha_inicio" class="el_view_expediente_fecha_inicio">
<span<?= $Page->fecha_inicio->viewAttributes() ?>>
<?= $Page->fecha_inicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_inicio->Visible) { // hora_inicio ?>
        <td data-name="hora_inicio"<?= $Page->hora_inicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_hora_inicio" class="el_view_expediente_hora_inicio">
<span<?= $Page->hora_inicio->viewAttributes() ?>>
<?= $Page->hora_inicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_fin->Visible) { // fecha_fin ?>
        <td data-name="fecha_fin"<?= $Page->fecha_fin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_fecha_fin" class="el_view_expediente_fecha_fin">
<span<?= $Page->fecha_fin->viewAttributes() ?>>
<?= $Page->fecha_fin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_fin->Visible) { // hora_fin ?>
        <td data-name="hora_fin"<?= $Page->hora_fin->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_hora_fin" class="el_view_expediente_hora_fin">
<span<?= $Page->hora_fin->viewAttributes() ?>>
<?= $Page->hora_fin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->servicio->Visible) { // servicio ?>
        <td data-name="servicio"<?= $Page->servicio->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_servicio" class="el_view_expediente_servicio">
<span<?= $Page->servicio->viewAttributes() ?>>
<?= $Page->servicio->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->fecha_serv->Visible) { // fecha_serv ?>
        <td data-name="fecha_serv"<?= $Page->fecha_serv->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_fecha_serv" class="el_view_expediente_fecha_serv">
<span<?= $Page->fecha_serv->viewAttributes() ?>>
<?= $Page->fecha_serv->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->hora_serv->Visible) { // hora_serv ?>
        <td data-name="hora_serv"<?= $Page->hora_serv->cellAttributes() ?>>
<span id="el<?= $Page->RowIndex == '$rowindex$' ? '$rowindex$' : $Page->RowCount ?>_view_expediente_hora_serv" class="el_view_expediente_hora_serv">
<span<?= $Page->hora_serv->viewAttributes() ?>>
<?= $Page->hora_serv->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }

    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close result set
$Page->Recordset?->free();
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
</div>
<div id="ew-footer-options">
<?php $Page->FooterOptions?->render("body") ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("view_expediente");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here
    // document.write("page loaded");
    $('#selAll').change(function() {
    	var checkboxes = $(this).closest('form').find(':checkbox');
    	if($(this).is(':checked')) {
    		checkboxes.prop('checked', true);
    	} else {
    		checkboxes.prop('checked', false);
    	}
    });
});
</script>
<?php } ?>
