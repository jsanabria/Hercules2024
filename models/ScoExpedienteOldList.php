<?php

namespace PHPMaker2024\hercules;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

/**
 * Page class
 */
class ScoExpedienteOldList extends ScoExpedienteOld
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteOldList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_expediente_oldlist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteOldList";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->Nexpediente->setVisibility();
        $this->tipo_contratacion->setVisibility();
        $this->seguro->setVisibility();
        $this->nacionalidad_contacto->setVisibility();
        $this->cedula_contacto->setVisibility();
        $this->nombre_contacto->setVisibility();
        $this->apellidos_contacto->setVisibility();
        $this->parentesco_contacto->setVisibility();
        $this->telefono_contacto1->setVisibility();
        $this->telefono_contacto2->setVisibility();
        $this->nacionalidad_fallecido->setVisibility();
        $this->cedula_fallecido->setVisibility();
        $this->sexo->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->fecha_nacimiento->setVisibility();
        $this->edad_fallecido->setVisibility();
        $this->estado_civil->setVisibility();
        $this->lugar_nacimiento_fallecido->setVisibility();
        $this->lugar_ocurrencia->setVisibility();
        $this->direccion_ocurrencia->setVisibility();
        $this->fecha_ocurrencia->setVisibility();
        $this->hora_ocurrencia->setVisibility();
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->setVisibility();
        $this->descripcion_ocurrencia->setVisibility();
        $this->calidad->setVisibility();
        $this->costos->setVisibility();
        $this->venta->setVisibility();
        $this->user_registra->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->user_cierra->setVisibility();
        $this->fecha_cierre->setVisibility();
        $this->estatus->setVisibility();
        $this->factura->setVisibility();
        $this->permiso->setVisibility();
        $this->unir_con_expediente->setVisibility();
        $this->nota->setVisibility();
        $this->_email->setVisibility();
        $this->religion->setVisibility();
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->funeraria->setVisibility();
        $this->marca_pasos->setVisibility();
        $this->autoriza_cremar->setVisibility();
        $this->username_autoriza->setVisibility();
        $this->fecha_autoriza->setVisibility();
        $this->peso->setVisibility();
        $this->contrato_parcela->setVisibility();
        $this->email_calidad->setVisibility();
        $this->certificado_defuncion->setVisibility();
        $this->parcela->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_expediente_old';
        $this->TableName = 'sco_expediente_old';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->TableGridClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_expediente_old)
        if (!isset($GLOBALS["sco_expediente_old"]) || $GLOBALS["sco_expediente_old"]::class == PROJECT_NAMESPACE . "sco_expediente_old") {
            $GLOBALS["sco_expediente_old"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoExpedienteOldAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoExpedienteOldDelete";
        $this->MultiUpdateUrl = "ScoExpedienteOldUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente_old');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions(Tag: "td", TableVar: $this->TableVar);

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Import options
        $this->ImportOptions = new ListOptions(TagClassName: "ew-import-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions(
            TableVar: $this->TableVar,
            TagClassName: "ew-column-option",
            ButtonGroupClass: "ew-column-dropdown",
            UseDropDownButton: true,
            DropDownButtonPhrase: $Language->phrase("Columns"),
            DropDownAutoClose: "outside",
            UseButtonGroup: false
        );

        // Filter options
        $this->FilterOptions = new ListOptions(TagClassName: "ew-filter-option");

        // List actions
        $this->ListActions = new ListActions();
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "ScoExpedienteOldView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        if ($fld->DataType == DataType::MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['Nexpediente'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->Nexpediente->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $HeaderOptions; // Header options
    public $FooterOptions; // Footer options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 50;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "5,10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $InlineRowCount = 0;
    public $StartRowCount = 1;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $TopContentClass = "ew-top";
    public $MiddleContentClass = "ew-middle";
    public $BottomContentClass = "ew-bottom";
    public $PageAction;
    public $RecKeys = [];
    public $IsModal = false;
    protected $FilterForModalActions = "";
    private $UseInfiniteScroll = false;

    /**
     * Load result set from filter
     *
     * @return void
     */
    public function loadRecordsetFromFilter($filter)
    {
        // Set up list options
        $this->setupListOptions();

        // Search options
        $this->setupSearchOptions();

        // Other options
        $this->setupOtherOptions();

        // Set visibility
        $this->setVisibility();

        // Load result set
        $this->TotalRecords = $this->loadRecordCount($filter);
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords;
        $this->CurrentFilter = $filter;
        $this->Recordset = $this->loadRecordset();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
    }

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $DashboardReport;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");
        $DashboardReport ??= Param(Config("PAGE_DASHBOARD"));

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->marca_pasos);
        $this->setupLookupOptions($this->autoriza_cremar);
        $this->setupLookupOptions($this->email_calidad);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_expediente_oldgrid";
        }

        // Set up page action
        $this->PageAction = CurrentPageUrl(false);

        // Set up infinite scroll
        $this->UseInfiniteScroll = ConvertToBool(Param("infinitescroll"));

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $query = ""; // Query builder

        // Set up Dashboard Filter
        if ($DashboardReport) {
            AddFilter($this->Filter, $this->getDashboardFilter($DashboardReport, $this->TableVar));
        }

        // Get command
        $this->Command = strtolower(Get("cmd", ""));

        // Process list action first
        if ($this->processListAction()) { // Ajax request
            $this->terminate();
            return;
        }

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Hide list options
        if ($this->isExport()) {
            $this->ListOptions->hideAllOptions(["sequence"]);
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        } elseif ($this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit() || $this->isConfirm()) {
            $this->ListOptions->hideAllOptions();
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        }

        // Hide options
        if ($this->isExport() || !(EmptyValue($this->CurrentAction) || $this->isSearch())) {
            $this->ExportOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
            $this->ImportOptions->hideAllOptions();
        }

        // Hide other options
        if ($this->isExport()) {
            $this->OtherOptions->hideAllOptions();
        }

        // Get default search criteria
        AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

        // Get basic search values
        $this->loadBasicSearchValues();

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }

        // Restore search parms from Session if not searching / reset / export
        if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
            $this->restoreSearchParms();
        }

        // Call Recordset SearchValidated event
        $this->recordsetSearchValidated();

        // Set up sorting order
        $this->setupSortOrder();

        // Get basic search criteria
        if (!$this->hasInvalidFields()) {
            $srchBasic = $this->basicSearchWhere();
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 50; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms() && !$query) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere(); // Save to session
            }
        }

        // Build search criteria
        if ($query) {
            AddFilter($this->SearchWhere, $query);
        } else {
            AddFilter($this->SearchWhere, $srchAdvanced);
            AddFilter($this->SearchWhere, $srchBasic);
        }

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json" && !$query) {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        if (!$Security->canList()) {
            $this->Filter = "(0=1)"; // Filter all records
        }
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $this->Filter;
        } else {
            $this->setSessionWhere($this->Filter);
            $this->CurrentFilter = "";
        }
        $this->Filter = $this->applyUserIDFilters($this->Filter);
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } elseif (($this->isEdit() || $this->isCopy() || $this->isInlineInserted() || $this->isInlineUpdated()) && $this->UseInfiniteScroll) { // Get current record only
            $this->CurrentFilter = $this->isInlineUpdated() ? $this->getRecordFilter() : $this->getFilterFromRecordKeys();
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } elseif (
            $this->UseInfiniteScroll && $this->isGridInserted() ||
            $this->UseInfiniteScroll && ($this->isGridEdit() || $this->isGridUpdated()) ||
            $this->isMultiEdit() ||
            $this->UseInfiniteScroll && $this->isMultiUpdated()
        ) { // Get current records only
            $this->CurrentFilter = $this->FilterForModalActions; // Restore filter
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if ((EmptyValue($this->CurrentAction) || $this->isSearch()) && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Set up list action columns
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Allowed) {
                if ($listAction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listAction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            if ($query) { // Hide search panel if using QueryBuilder
                RemoveClass($this->SearchPanelClass, "show");
            } else {
                AppendClass($this->SearchPanelClass, "show");
            }
        }

        // API list action
        if (IsApi()) {
            if (Route(0) == Config("API_LIST_ACTION")) {
                if (!$this->isExport()) {
                    $rows = $this->getRecordsFromRecordset($this->Recordset);
                    $this->Recordset?->free();
                    WriteJson([
                        "success" => true,
                        "action" => Config("API_LIST_ACTION"),
                        $this->TableVar => $rows,
                        "totalRecordCount" => $this->TotalRecords
                    ]);
                    $this->terminate(true);
                }
                return;
            } elseif ($this->getFailureMessage() != "") {
                WriteJson(["error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate(true);
                return;
            }
        }

        // Render other options
        $this->renderOtherOptions();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set ReturnUrl in header if necessary
        if ($returnUrl = Container("app.flash")->getFirstMessage("Return-Url")) {
            AddHeader("Return-Url", GetUrl($returnUrl));
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get page number
    public function getPageNumber()
    {
        return ($this->DisplayRecords > 0 && $this->StartRecord > 0) ? ceil($this->StartRecord / $this->DisplayRecords) : 1;
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 50; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->Nexpediente->AdvancedSearch->toJson(), ","); // Field Nexpediente
        $filterList = Concat($filterList, $this->tipo_contratacion->AdvancedSearch->toJson(), ","); // Field tipo_contratacion
        $filterList = Concat($filterList, $this->seguro->AdvancedSearch->toJson(), ","); // Field seguro
        $filterList = Concat($filterList, $this->nacionalidad_contacto->AdvancedSearch->toJson(), ","); // Field nacionalidad_contacto
        $filterList = Concat($filterList, $this->cedula_contacto->AdvancedSearch->toJson(), ","); // Field cedula_contacto
        $filterList = Concat($filterList, $this->nombre_contacto->AdvancedSearch->toJson(), ","); // Field nombre_contacto
        $filterList = Concat($filterList, $this->apellidos_contacto->AdvancedSearch->toJson(), ","); // Field apellidos_contacto
        $filterList = Concat($filterList, $this->parentesco_contacto->AdvancedSearch->toJson(), ","); // Field parentesco_contacto
        $filterList = Concat($filterList, $this->telefono_contacto1->AdvancedSearch->toJson(), ","); // Field telefono_contacto1
        $filterList = Concat($filterList, $this->telefono_contacto2->AdvancedSearch->toJson(), ","); // Field telefono_contacto2
        $filterList = Concat($filterList, $this->nacionalidad_fallecido->AdvancedSearch->toJson(), ","); // Field nacionalidad_fallecido
        $filterList = Concat($filterList, $this->cedula_fallecido->AdvancedSearch->toJson(), ","); // Field cedula_fallecido
        $filterList = Concat($filterList, $this->sexo->AdvancedSearch->toJson(), ","); // Field sexo
        $filterList = Concat($filterList, $this->nombre_fallecido->AdvancedSearch->toJson(), ","); // Field nombre_fallecido
        $filterList = Concat($filterList, $this->apellidos_fallecido->AdvancedSearch->toJson(), ","); // Field apellidos_fallecido
        $filterList = Concat($filterList, $this->fecha_nacimiento->AdvancedSearch->toJson(), ","); // Field fecha_nacimiento
        $filterList = Concat($filterList, $this->edad_fallecido->AdvancedSearch->toJson(), ","); // Field edad_fallecido
        $filterList = Concat($filterList, $this->estado_civil->AdvancedSearch->toJson(), ","); // Field estado_civil
        $filterList = Concat($filterList, $this->lugar_nacimiento_fallecido->AdvancedSearch->toJson(), ","); // Field lugar_nacimiento_fallecido
        $filterList = Concat($filterList, $this->lugar_ocurrencia->AdvancedSearch->toJson(), ","); // Field lugar_ocurrencia
        $filterList = Concat($filterList, $this->direccion_ocurrencia->AdvancedSearch->toJson(), ","); // Field direccion_ocurrencia
        $filterList = Concat($filterList, $this->fecha_ocurrencia->AdvancedSearch->toJson(), ","); // Field fecha_ocurrencia
        $filterList = Concat($filterList, $this->hora_ocurrencia->AdvancedSearch->toJson(), ","); // Field hora_ocurrencia
        $filterList = Concat($filterList, $this->causa_ocurrencia->AdvancedSearch->toJson(), ","); // Field causa_ocurrencia
        $filterList = Concat($filterList, $this->causa_otro->AdvancedSearch->toJson(), ","); // Field causa_otro
        $filterList = Concat($filterList, $this->descripcion_ocurrencia->AdvancedSearch->toJson(), ","); // Field descripcion_ocurrencia
        $filterList = Concat($filterList, $this->calidad->AdvancedSearch->toJson(), ","); // Field calidad
        $filterList = Concat($filterList, $this->costos->AdvancedSearch->toJson(), ","); // Field costos
        $filterList = Concat($filterList, $this->venta->AdvancedSearch->toJson(), ","); // Field venta
        $filterList = Concat($filterList, $this->user_registra->AdvancedSearch->toJson(), ","); // Field user_registra
        $filterList = Concat($filterList, $this->fecha_registro->AdvancedSearch->toJson(), ","); // Field fecha_registro
        $filterList = Concat($filterList, $this->user_cierra->AdvancedSearch->toJson(), ","); // Field user_cierra
        $filterList = Concat($filterList, $this->fecha_cierre->AdvancedSearch->toJson(), ","); // Field fecha_cierre
        $filterList = Concat($filterList, $this->estatus->AdvancedSearch->toJson(), ","); // Field estatus
        $filterList = Concat($filterList, $this->factura->AdvancedSearch->toJson(), ","); // Field factura
        $filterList = Concat($filterList, $this->permiso->AdvancedSearch->toJson(), ","); // Field permiso
        $filterList = Concat($filterList, $this->unir_con_expediente->AdvancedSearch->toJson(), ","); // Field unir_con_expediente
        $filterList = Concat($filterList, $this->nota->AdvancedSearch->toJson(), ","); // Field nota
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->religion->AdvancedSearch->toJson(), ","); // Field religion
        $filterList = Concat($filterList, $this->servicio_tipo->AdvancedSearch->toJson(), ","); // Field servicio_tipo
        $filterList = Concat($filterList, $this->servicio->AdvancedSearch->toJson(), ","); // Field servicio
        $filterList = Concat($filterList, $this->funeraria->AdvancedSearch->toJson(), ","); // Field funeraria
        $filterList = Concat($filterList, $this->marca_pasos->AdvancedSearch->toJson(), ","); // Field marca_pasos
        $filterList = Concat($filterList, $this->autoriza_cremar->AdvancedSearch->toJson(), ","); // Field autoriza_cremar
        $filterList = Concat($filterList, $this->username_autoriza->AdvancedSearch->toJson(), ","); // Field username_autoriza
        $filterList = Concat($filterList, $this->fecha_autoriza->AdvancedSearch->toJson(), ","); // Field fecha_autoriza
        $filterList = Concat($filterList, $this->peso->AdvancedSearch->toJson(), ","); // Field peso
        $filterList = Concat($filterList, $this->contrato_parcela->AdvancedSearch->toJson(), ","); // Field contrato_parcela
        $filterList = Concat($filterList, $this->email_calidad->AdvancedSearch->toJson(), ","); // Field email_calidad
        $filterList = Concat($filterList, $this->certificado_defuncion->AdvancedSearch->toJson(), ","); // Field certificado_defuncion
        $filterList = Concat($filterList, $this->parcela->AdvancedSearch->toJson(), ","); // Field parcela
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            Profile()->setSearchFilters("fsco_expediente_oldsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field Nexpediente
        $this->Nexpediente->AdvancedSearch->SearchValue = @$filter["x_Nexpediente"];
        $this->Nexpediente->AdvancedSearch->SearchOperator = @$filter["z_Nexpediente"];
        $this->Nexpediente->AdvancedSearch->SearchCondition = @$filter["v_Nexpediente"];
        $this->Nexpediente->AdvancedSearch->SearchValue2 = @$filter["y_Nexpediente"];
        $this->Nexpediente->AdvancedSearch->SearchOperator2 = @$filter["w_Nexpediente"];
        $this->Nexpediente->AdvancedSearch->save();

        // Field tipo_contratacion
        $this->tipo_contratacion->AdvancedSearch->SearchValue = @$filter["x_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchOperator = @$filter["z_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchCondition = @$filter["v_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchValue2 = @$filter["y_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->save();

        // Field seguro
        $this->seguro->AdvancedSearch->SearchValue = @$filter["x_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator = @$filter["z_seguro"];
        $this->seguro->AdvancedSearch->SearchCondition = @$filter["v_seguro"];
        $this->seguro->AdvancedSearch->SearchValue2 = @$filter["y_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator2 = @$filter["w_seguro"];
        $this->seguro->AdvancedSearch->save();

        // Field nacionalidad_contacto
        $this->nacionalidad_contacto->AdvancedSearch->SearchValue = @$filter["x_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchOperator = @$filter["z_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchCondition = @$filter["v_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchValue2 = @$filter["y_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->save();

        // Field cedula_contacto
        $this->cedula_contacto->AdvancedSearch->SearchValue = @$filter["x_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchOperator = @$filter["z_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchCondition = @$filter["v_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchValue2 = @$filter["y_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->save();

        // Field nombre_contacto
        $this->nombre_contacto->AdvancedSearch->SearchValue = @$filter["x_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchOperator = @$filter["z_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchCondition = @$filter["v_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchValue2 = @$filter["y_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->save();

        // Field apellidos_contacto
        $this->apellidos_contacto->AdvancedSearch->SearchValue = @$filter["x_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchOperator = @$filter["z_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchCondition = @$filter["v_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchValue2 = @$filter["y_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->save();

        // Field parentesco_contacto
        $this->parentesco_contacto->AdvancedSearch->SearchValue = @$filter["x_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchOperator = @$filter["z_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchCondition = @$filter["v_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchValue2 = @$filter["y_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->save();

        // Field telefono_contacto1
        $this->telefono_contacto1->AdvancedSearch->SearchValue = @$filter["x_telefono_contacto1"];
        $this->telefono_contacto1->AdvancedSearch->SearchOperator = @$filter["z_telefono_contacto1"];
        $this->telefono_contacto1->AdvancedSearch->SearchCondition = @$filter["v_telefono_contacto1"];
        $this->telefono_contacto1->AdvancedSearch->SearchValue2 = @$filter["y_telefono_contacto1"];
        $this->telefono_contacto1->AdvancedSearch->SearchOperator2 = @$filter["w_telefono_contacto1"];
        $this->telefono_contacto1->AdvancedSearch->save();

        // Field telefono_contacto2
        $this->telefono_contacto2->AdvancedSearch->SearchValue = @$filter["x_telefono_contacto2"];
        $this->telefono_contacto2->AdvancedSearch->SearchOperator = @$filter["z_telefono_contacto2"];
        $this->telefono_contacto2->AdvancedSearch->SearchCondition = @$filter["v_telefono_contacto2"];
        $this->telefono_contacto2->AdvancedSearch->SearchValue2 = @$filter["y_telefono_contacto2"];
        $this->telefono_contacto2->AdvancedSearch->SearchOperator2 = @$filter["w_telefono_contacto2"];
        $this->telefono_contacto2->AdvancedSearch->save();

        // Field nacionalidad_fallecido
        $this->nacionalidad_fallecido->AdvancedSearch->SearchValue = @$filter["x_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchOperator = @$filter["z_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchCondition = @$filter["v_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->save();

        // Field cedula_fallecido
        $this->cedula_fallecido->AdvancedSearch->SearchValue = @$filter["x_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchOperator = @$filter["z_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchCondition = @$filter["v_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->save();

        // Field sexo
        $this->sexo->AdvancedSearch->SearchValue = @$filter["x_sexo"];
        $this->sexo->AdvancedSearch->SearchOperator = @$filter["z_sexo"];
        $this->sexo->AdvancedSearch->SearchCondition = @$filter["v_sexo"];
        $this->sexo->AdvancedSearch->SearchValue2 = @$filter["y_sexo"];
        $this->sexo->AdvancedSearch->SearchOperator2 = @$filter["w_sexo"];
        $this->sexo->AdvancedSearch->save();

        // Field nombre_fallecido
        $this->nombre_fallecido->AdvancedSearch->SearchValue = @$filter["x_nombre_fallecido"];
        $this->nombre_fallecido->AdvancedSearch->SearchOperator = @$filter["z_nombre_fallecido"];
        $this->nombre_fallecido->AdvancedSearch->SearchCondition = @$filter["v_nombre_fallecido"];
        $this->nombre_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_nombre_fallecido"];
        $this->nombre_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_fallecido"];
        $this->nombre_fallecido->AdvancedSearch->save();

        // Field apellidos_fallecido
        $this->apellidos_fallecido->AdvancedSearch->SearchValue = @$filter["x_apellidos_fallecido"];
        $this->apellidos_fallecido->AdvancedSearch->SearchOperator = @$filter["z_apellidos_fallecido"];
        $this->apellidos_fallecido->AdvancedSearch->SearchCondition = @$filter["v_apellidos_fallecido"];
        $this->apellidos_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_apellidos_fallecido"];
        $this->apellidos_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_apellidos_fallecido"];
        $this->apellidos_fallecido->AdvancedSearch->save();

        // Field fecha_nacimiento
        $this->fecha_nacimiento->AdvancedSearch->SearchValue = @$filter["x_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchOperator = @$filter["z_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchCondition = @$filter["v_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchValue2 = @$filter["y_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->save();

        // Field edad_fallecido
        $this->edad_fallecido->AdvancedSearch->SearchValue = @$filter["x_edad_fallecido"];
        $this->edad_fallecido->AdvancedSearch->SearchOperator = @$filter["z_edad_fallecido"];
        $this->edad_fallecido->AdvancedSearch->SearchCondition = @$filter["v_edad_fallecido"];
        $this->edad_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_edad_fallecido"];
        $this->edad_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_edad_fallecido"];
        $this->edad_fallecido->AdvancedSearch->save();

        // Field estado_civil
        $this->estado_civil->AdvancedSearch->SearchValue = @$filter["x_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchOperator = @$filter["z_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchCondition = @$filter["v_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchValue2 = @$filter["y_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchOperator2 = @$filter["w_estado_civil"];
        $this->estado_civil->AdvancedSearch->save();

        // Field lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchValue = @$filter["x_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchOperator = @$filter["z_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchCondition = @$filter["v_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->save();

        // Field lugar_ocurrencia
        $this->lugar_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->save();

        // Field direccion_ocurrencia
        $this->direccion_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->save();

        // Field fecha_ocurrencia
        $this->fecha_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->save();

        // Field hora_ocurrencia
        $this->hora_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->save();

        // Field causa_ocurrencia
        $this->causa_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_causa_ocurrencia"];
        $this->causa_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_causa_ocurrencia"];
        $this->causa_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_causa_ocurrencia"];
        $this->causa_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_causa_ocurrencia"];
        $this->causa_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_causa_ocurrencia"];
        $this->causa_ocurrencia->AdvancedSearch->save();

        // Field causa_otro
        $this->causa_otro->AdvancedSearch->SearchValue = @$filter["x_causa_otro"];
        $this->causa_otro->AdvancedSearch->SearchOperator = @$filter["z_causa_otro"];
        $this->causa_otro->AdvancedSearch->SearchCondition = @$filter["v_causa_otro"];
        $this->causa_otro->AdvancedSearch->SearchValue2 = @$filter["y_causa_otro"];
        $this->causa_otro->AdvancedSearch->SearchOperator2 = @$filter["w_causa_otro"];
        $this->causa_otro->AdvancedSearch->save();

        // Field descripcion_ocurrencia
        $this->descripcion_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->save();

        // Field calidad
        $this->calidad->AdvancedSearch->SearchValue = @$filter["x_calidad"];
        $this->calidad->AdvancedSearch->SearchOperator = @$filter["z_calidad"];
        $this->calidad->AdvancedSearch->SearchCondition = @$filter["v_calidad"];
        $this->calidad->AdvancedSearch->SearchValue2 = @$filter["y_calidad"];
        $this->calidad->AdvancedSearch->SearchOperator2 = @$filter["w_calidad"];
        $this->calidad->AdvancedSearch->save();

        // Field costos
        $this->costos->AdvancedSearch->SearchValue = @$filter["x_costos"];
        $this->costos->AdvancedSearch->SearchOperator = @$filter["z_costos"];
        $this->costos->AdvancedSearch->SearchCondition = @$filter["v_costos"];
        $this->costos->AdvancedSearch->SearchValue2 = @$filter["y_costos"];
        $this->costos->AdvancedSearch->SearchOperator2 = @$filter["w_costos"];
        $this->costos->AdvancedSearch->save();

        // Field venta
        $this->venta->AdvancedSearch->SearchValue = @$filter["x_venta"];
        $this->venta->AdvancedSearch->SearchOperator = @$filter["z_venta"];
        $this->venta->AdvancedSearch->SearchCondition = @$filter["v_venta"];
        $this->venta->AdvancedSearch->SearchValue2 = @$filter["y_venta"];
        $this->venta->AdvancedSearch->SearchOperator2 = @$filter["w_venta"];
        $this->venta->AdvancedSearch->save();

        // Field user_registra
        $this->user_registra->AdvancedSearch->SearchValue = @$filter["x_user_registra"];
        $this->user_registra->AdvancedSearch->SearchOperator = @$filter["z_user_registra"];
        $this->user_registra->AdvancedSearch->SearchCondition = @$filter["v_user_registra"];
        $this->user_registra->AdvancedSearch->SearchValue2 = @$filter["y_user_registra"];
        $this->user_registra->AdvancedSearch->SearchOperator2 = @$filter["w_user_registra"];
        $this->user_registra->AdvancedSearch->save();

        // Field fecha_registro
        $this->fecha_registro->AdvancedSearch->SearchValue = @$filter["x_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchOperator = @$filter["z_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchCondition = @$filter["v_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchValue2 = @$filter["y_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->save();

        // Field user_cierra
        $this->user_cierra->AdvancedSearch->SearchValue = @$filter["x_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchOperator = @$filter["z_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchCondition = @$filter["v_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchValue2 = @$filter["y_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchOperator2 = @$filter["w_user_cierra"];
        $this->user_cierra->AdvancedSearch->save();

        // Field fecha_cierre
        $this->fecha_cierre->AdvancedSearch->SearchValue = @$filter["x_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchOperator = @$filter["z_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchCondition = @$filter["v_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchValue2 = @$filter["y_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->save();

        // Field estatus
        $this->estatus->AdvancedSearch->SearchValue = @$filter["x_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator = @$filter["z_estatus"];
        $this->estatus->AdvancedSearch->SearchCondition = @$filter["v_estatus"];
        $this->estatus->AdvancedSearch->SearchValue2 = @$filter["y_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator2 = @$filter["w_estatus"];
        $this->estatus->AdvancedSearch->save();

        // Field factura
        $this->factura->AdvancedSearch->SearchValue = @$filter["x_factura"];
        $this->factura->AdvancedSearch->SearchOperator = @$filter["z_factura"];
        $this->factura->AdvancedSearch->SearchCondition = @$filter["v_factura"];
        $this->factura->AdvancedSearch->SearchValue2 = @$filter["y_factura"];
        $this->factura->AdvancedSearch->SearchOperator2 = @$filter["w_factura"];
        $this->factura->AdvancedSearch->save();

        // Field permiso
        $this->permiso->AdvancedSearch->SearchValue = @$filter["x_permiso"];
        $this->permiso->AdvancedSearch->SearchOperator = @$filter["z_permiso"];
        $this->permiso->AdvancedSearch->SearchCondition = @$filter["v_permiso"];
        $this->permiso->AdvancedSearch->SearchValue2 = @$filter["y_permiso"];
        $this->permiso->AdvancedSearch->SearchOperator2 = @$filter["w_permiso"];
        $this->permiso->AdvancedSearch->save();

        // Field unir_con_expediente
        $this->unir_con_expediente->AdvancedSearch->SearchValue = @$filter["x_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchOperator = @$filter["z_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchCondition = @$filter["v_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchValue2 = @$filter["y_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchOperator2 = @$filter["w_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->save();

        // Field nota
        $this->nota->AdvancedSearch->SearchValue = @$filter["x_nota"];
        $this->nota->AdvancedSearch->SearchOperator = @$filter["z_nota"];
        $this->nota->AdvancedSearch->SearchCondition = @$filter["v_nota"];
        $this->nota->AdvancedSearch->SearchValue2 = @$filter["y_nota"];
        $this->nota->AdvancedSearch->SearchOperator2 = @$filter["w_nota"];
        $this->nota->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field religion
        $this->religion->AdvancedSearch->SearchValue = @$filter["x_religion"];
        $this->religion->AdvancedSearch->SearchOperator = @$filter["z_religion"];
        $this->religion->AdvancedSearch->SearchCondition = @$filter["v_religion"];
        $this->religion->AdvancedSearch->SearchValue2 = @$filter["y_religion"];
        $this->religion->AdvancedSearch->SearchOperator2 = @$filter["w_religion"];
        $this->religion->AdvancedSearch->save();

        // Field servicio_tipo
        $this->servicio_tipo->AdvancedSearch->SearchValue = @$filter["x_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchOperator = @$filter["z_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchCondition = @$filter["v_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchValue2 = @$filter["y_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchOperator2 = @$filter["w_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->save();

        // Field servicio
        $this->servicio->AdvancedSearch->SearchValue = @$filter["x_servicio"];
        $this->servicio->AdvancedSearch->SearchOperator = @$filter["z_servicio"];
        $this->servicio->AdvancedSearch->SearchCondition = @$filter["v_servicio"];
        $this->servicio->AdvancedSearch->SearchValue2 = @$filter["y_servicio"];
        $this->servicio->AdvancedSearch->SearchOperator2 = @$filter["w_servicio"];
        $this->servicio->AdvancedSearch->save();

        // Field funeraria
        $this->funeraria->AdvancedSearch->SearchValue = @$filter["x_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator = @$filter["z_funeraria"];
        $this->funeraria->AdvancedSearch->SearchCondition = @$filter["v_funeraria"];
        $this->funeraria->AdvancedSearch->SearchValue2 = @$filter["y_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator2 = @$filter["w_funeraria"];
        $this->funeraria->AdvancedSearch->save();

        // Field marca_pasos
        $this->marca_pasos->AdvancedSearch->SearchValue = @$filter["x_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchOperator = @$filter["z_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchCondition = @$filter["v_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchValue2 = @$filter["y_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchOperator2 = @$filter["w_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->save();

        // Field autoriza_cremar
        $this->autoriza_cremar->AdvancedSearch->SearchValue = @$filter["x_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchOperator = @$filter["z_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchCondition = @$filter["v_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchValue2 = @$filter["y_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchOperator2 = @$filter["w_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->save();

        // Field username_autoriza
        $this->username_autoriza->AdvancedSearch->SearchValue = @$filter["x_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchOperator = @$filter["z_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchCondition = @$filter["v_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchValue2 = @$filter["y_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchOperator2 = @$filter["w_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->save();

        // Field fecha_autoriza
        $this->fecha_autoriza->AdvancedSearch->SearchValue = @$filter["x_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchOperator = @$filter["z_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchCondition = @$filter["v_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchValue2 = @$filter["y_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->save();

        // Field peso
        $this->peso->AdvancedSearch->SearchValue = @$filter["x_peso"];
        $this->peso->AdvancedSearch->SearchOperator = @$filter["z_peso"];
        $this->peso->AdvancedSearch->SearchCondition = @$filter["v_peso"];
        $this->peso->AdvancedSearch->SearchValue2 = @$filter["y_peso"];
        $this->peso->AdvancedSearch->SearchOperator2 = @$filter["w_peso"];
        $this->peso->AdvancedSearch->save();

        // Field contrato_parcela
        $this->contrato_parcela->AdvancedSearch->SearchValue = @$filter["x_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchOperator = @$filter["z_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchCondition = @$filter["v_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchValue2 = @$filter["y_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchOperator2 = @$filter["w_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->save();

        // Field email_calidad
        $this->email_calidad->AdvancedSearch->SearchValue = @$filter["x_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchOperator = @$filter["z_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchCondition = @$filter["v_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchValue2 = @$filter["y_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchOperator2 = @$filter["w_email_calidad"];
        $this->email_calidad->AdvancedSearch->save();

        // Field certificado_defuncion
        $this->certificado_defuncion->AdvancedSearch->SearchValue = @$filter["x_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchOperator = @$filter["z_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchCondition = @$filter["v_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchValue2 = @$filter["y_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchOperator2 = @$filter["w_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->save();

        // Field parcela
        $this->parcela->AdvancedSearch->SearchValue = @$filter["x_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator = @$filter["z_parcela"];
        $this->parcela->AdvancedSearch->SearchCondition = @$filter["v_parcela"];
        $this->parcela->AdvancedSearch->SearchValue2 = @$filter["y_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator2 = @$filter["w_parcela"];
        $this->parcela->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";
        if ($this->BasicSearch->Keyword != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $Language->phrase("BasicSearchKeyword") . "</span>" . $captionSuffix . $this->BasicSearch->Keyword . "</div>";
        }

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"callout callout-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        } else { // Output empty tag
            Write("<div id=\"ew-filter-list\"></div>");
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    public function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->tipo_contratacion;
        $searchFlds[] = &$this->nacionalidad_contacto;
        $searchFlds[] = &$this->cedula_contacto;
        $searchFlds[] = &$this->nombre_contacto;
        $searchFlds[] = &$this->apellidos_contacto;
        $searchFlds[] = &$this->parentesco_contacto;
        $searchFlds[] = &$this->telefono_contacto1;
        $searchFlds[] = &$this->telefono_contacto2;
        $searchFlds[] = &$this->nacionalidad_fallecido;
        $searchFlds[] = &$this->cedula_fallecido;
        $searchFlds[] = &$this->sexo;
        $searchFlds[] = &$this->nombre_fallecido;
        $searchFlds[] = &$this->apellidos_fallecido;
        $searchFlds[] = &$this->estado_civil;
        $searchFlds[] = &$this->lugar_nacimiento_fallecido;
        $searchFlds[] = &$this->lugar_ocurrencia;
        $searchFlds[] = &$this->direccion_ocurrencia;
        $searchFlds[] = &$this->causa_ocurrencia;
        $searchFlds[] = &$this->causa_otro;
        $searchFlds[] = &$this->descripcion_ocurrencia;
        $searchFlds[] = &$this->calidad;
        $searchFlds[] = &$this->user_registra;
        $searchFlds[] = &$this->user_cierra;
        $searchFlds[] = &$this->factura;
        $searchFlds[] = &$this->permiso;
        $searchFlds[] = &$this->nota;
        $searchFlds[] = &$this->_email;
        $searchFlds[] = &$this->religion;
        $searchFlds[] = &$this->servicio_tipo;
        $searchFlds[] = &$this->servicio;
        $searchFlds[] = &$this->username_autoriza;
        $searchFlds[] = &$this->peso;
        $searchFlds[] = &$this->contrato_parcela;
        $searchFlds[] = &$this->certificado_defuncion;
        $searchFlds[] = &$this->parcela;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = ""; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->Nexpediente); // Nexpediente
            $this->updateSort($this->tipo_contratacion); // tipo_contratacion
            $this->updateSort($this->seguro); // seguro
            $this->updateSort($this->nacionalidad_contacto); // nacionalidad_contacto
            $this->updateSort($this->cedula_contacto); // cedula_contacto
            $this->updateSort($this->nombre_contacto); // nombre_contacto
            $this->updateSort($this->apellidos_contacto); // apellidos_contacto
            $this->updateSort($this->parentesco_contacto); // parentesco_contacto
            $this->updateSort($this->telefono_contacto1); // telefono_contacto1
            $this->updateSort($this->telefono_contacto2); // telefono_contacto2
            $this->updateSort($this->nacionalidad_fallecido); // nacionalidad_fallecido
            $this->updateSort($this->cedula_fallecido); // cedula_fallecido
            $this->updateSort($this->sexo); // sexo
            $this->updateSort($this->nombre_fallecido); // nombre_fallecido
            $this->updateSort($this->apellidos_fallecido); // apellidos_fallecido
            $this->updateSort($this->fecha_nacimiento); // fecha_nacimiento
            $this->updateSort($this->edad_fallecido); // edad_fallecido
            $this->updateSort($this->estado_civil); // estado_civil
            $this->updateSort($this->lugar_nacimiento_fallecido); // lugar_nacimiento_fallecido
            $this->updateSort($this->lugar_ocurrencia); // lugar_ocurrencia
            $this->updateSort($this->direccion_ocurrencia); // direccion_ocurrencia
            $this->updateSort($this->fecha_ocurrencia); // fecha_ocurrencia
            $this->updateSort($this->hora_ocurrencia); // hora_ocurrencia
            $this->updateSort($this->causa_ocurrencia); // causa_ocurrencia
            $this->updateSort($this->causa_otro); // causa_otro
            $this->updateSort($this->descripcion_ocurrencia); // descripcion_ocurrencia
            $this->updateSort($this->calidad); // calidad
            $this->updateSort($this->costos); // costos
            $this->updateSort($this->venta); // venta
            $this->updateSort($this->user_registra); // user_registra
            $this->updateSort($this->fecha_registro); // fecha_registro
            $this->updateSort($this->user_cierra); // user_cierra
            $this->updateSort($this->fecha_cierre); // fecha_cierre
            $this->updateSort($this->estatus); // estatus
            $this->updateSort($this->factura); // factura
            $this->updateSort($this->permiso); // permiso
            $this->updateSort($this->unir_con_expediente); // unir_con_expediente
            $this->updateSort($this->nota); // nota
            $this->updateSort($this->_email); // email
            $this->updateSort($this->religion); // religion
            $this->updateSort($this->servicio_tipo); // servicio_tipo
            $this->updateSort($this->servicio); // servicio
            $this->updateSort($this->funeraria); // funeraria
            $this->updateSort($this->marca_pasos); // marca_pasos
            $this->updateSort($this->autoriza_cremar); // autoriza_cremar
            $this->updateSort($this->username_autoriza); // username_autoriza
            $this->updateSort($this->fecha_autoriza); // fecha_autoriza
            $this->updateSort($this->peso); // peso
            $this->updateSort($this->contrato_parcela); // contrato_parcela
            $this->updateSort($this->email_calidad); // email_calidad
            $this->updateSort($this->certificado_defuncion); // certificado_defuncion
            $this->updateSort($this->parcela); // parcela
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->Nexpediente->setSort("");
                $this->tipo_contratacion->setSort("");
                $this->seguro->setSort("");
                $this->nacionalidad_contacto->setSort("");
                $this->cedula_contacto->setSort("");
                $this->nombre_contacto->setSort("");
                $this->apellidos_contacto->setSort("");
                $this->parentesco_contacto->setSort("");
                $this->telefono_contacto1->setSort("");
                $this->telefono_contacto2->setSort("");
                $this->nacionalidad_fallecido->setSort("");
                $this->cedula_fallecido->setSort("");
                $this->sexo->setSort("");
                $this->nombre_fallecido->setSort("");
                $this->apellidos_fallecido->setSort("");
                $this->fecha_nacimiento->setSort("");
                $this->edad_fallecido->setSort("");
                $this->estado_civil->setSort("");
                $this->lugar_nacimiento_fallecido->setSort("");
                $this->lugar_ocurrencia->setSort("");
                $this->direccion_ocurrencia->setSort("");
                $this->fecha_ocurrencia->setSort("");
                $this->hora_ocurrencia->setSort("");
                $this->causa_ocurrencia->setSort("");
                $this->causa_otro->setSort("");
                $this->descripcion_ocurrencia->setSort("");
                $this->calidad->setSort("");
                $this->costos->setSort("");
                $this->venta->setSort("");
                $this->user_registra->setSort("");
                $this->fecha_registro->setSort("");
                $this->user_cierra->setSort("");
                $this->fecha_cierre->setSort("");
                $this->estatus->setSort("");
                $this->factura->setSort("");
                $this->permiso->setSort("");
                $this->unir_con_expediente->setSort("");
                $this->nota->setSort("");
                $this->_email->setSort("");
                $this->religion->setSort("");
                $this->servicio_tipo->setSort("");
                $this->servicio->setSort("");
                $this->funeraria->setSort("");
                $this->marca_pasos->setSort("");
                $this->autoriza_cremar->setSort("");
                $this->username_autoriza->setSort("");
                $this->fecha_autoriza->setSort("");
                $this->peso->setSort("");
                $this->contrato_parcela->setSort("");
                $this->email_calidad->setSort("");
                $this->certificado_defuncion->setSort("");
                $this->parcela->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
        // Preview extension
        $this->ListOptions->hideDetailItemsForDropDown(); // Hide detail items for dropdown if necessary
    }

    // Add "hash" parameter to URL
    public function urlAddHash($url, $hash)
    {
        return $this->UseAjaxActions ? $url : UrlAddQuery($url, "hash=" . $hash);
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_expediente_old\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_expediente_old\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                if ($this->ModalAdd && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"sco_expediente_old\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $deleteCaption = $Language->phrase("DeleteLink");
                $deleteTitle = HtmlTitle($deleteCaption);
                if ($this->UseAjaxActions) {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"inline\" data-action=\"delete\" title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" data-key= \"" . HtmlEncode($this->getKey(true)) . "\" data-url=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-delete\"" .
                        ($this->InlineDelete ? " data-ew-action=\"inline-delete\"" : "") .
                        " title=\"" . $deleteTitle . "\" data-caption=\"" . $deleteTitle . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $deleteCaption . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions as $listAction) {
                $action = $listAction->Action;
                $allowed = $listAction->Allowed;
                $disabled = false;
                if ($listAction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listAction->Caption;
                    $title = HtmlTitle($caption);
                    if ($action != "") {
                        $icon = ($listAction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listAction->Icon)) . "\" data-caption=\"" . $title . "\"></i> " : "";
                        $link = $disabled
                            ? "<li><div class=\"alert alert-light\">" . $icon . " " . $caption . "</div></li>"
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_expediente_oldlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_expediente_oldlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = implode(array_map(fn($link) => "<li>" . $link . "</li>", $links));
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Nexpediente->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        if ($this->ModalAdd && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_expediente_old\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "Nexpediente");
            $this->createColumnOption($option, "tipo_contratacion");
            $this->createColumnOption($option, "seguro");
            $this->createColumnOption($option, "nacionalidad_contacto");
            $this->createColumnOption($option, "cedula_contacto");
            $this->createColumnOption($option, "nombre_contacto");
            $this->createColumnOption($option, "apellidos_contacto");
            $this->createColumnOption($option, "parentesco_contacto");
            $this->createColumnOption($option, "telefono_contacto1");
            $this->createColumnOption($option, "telefono_contacto2");
            $this->createColumnOption($option, "nacionalidad_fallecido");
            $this->createColumnOption($option, "cedula_fallecido");
            $this->createColumnOption($option, "sexo");
            $this->createColumnOption($option, "nombre_fallecido");
            $this->createColumnOption($option, "apellidos_fallecido");
            $this->createColumnOption($option, "fecha_nacimiento");
            $this->createColumnOption($option, "edad_fallecido");
            $this->createColumnOption($option, "estado_civil");
            $this->createColumnOption($option, "lugar_nacimiento_fallecido");
            $this->createColumnOption($option, "lugar_ocurrencia");
            $this->createColumnOption($option, "direccion_ocurrencia");
            $this->createColumnOption($option, "fecha_ocurrencia");
            $this->createColumnOption($option, "hora_ocurrencia");
            $this->createColumnOption($option, "causa_ocurrencia");
            $this->createColumnOption($option, "causa_otro");
            $this->createColumnOption($option, "descripcion_ocurrencia");
            $this->createColumnOption($option, "calidad");
            $this->createColumnOption($option, "costos");
            $this->createColumnOption($option, "venta");
            $this->createColumnOption($option, "user_registra");
            $this->createColumnOption($option, "fecha_registro");
            $this->createColumnOption($option, "user_cierra");
            $this->createColumnOption($option, "fecha_cierre");
            $this->createColumnOption($option, "estatus");
            $this->createColumnOption($option, "factura");
            $this->createColumnOption($option, "permiso");
            $this->createColumnOption($option, "unir_con_expediente");
            $this->createColumnOption($option, "nota");
            $this->createColumnOption($option, "email");
            $this->createColumnOption($option, "religion");
            $this->createColumnOption($option, "servicio_tipo");
            $this->createColumnOption($option, "servicio");
            $this->createColumnOption($option, "funeraria");
            $this->createColumnOption($option, "marca_pasos");
            $this->createColumnOption($option, "autoriza_cremar");
            $this->createColumnOption($option, "username_autoriza");
            $this->createColumnOption($option, "fecha_autoriza");
            $this->createColumnOption($option, "peso");
            $this->createColumnOption($option, "contrato_parcela");
            $this->createColumnOption($option, "email_calidad");
            $this->createColumnOption($option, "certificado_defuncion");
            $this->createColumnOption($option, "parcela");
        }

        // Set up custom actions
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions[$name] = $action;
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_expediente_oldsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_expediente_oldsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Page header/footer options
        $this->HeaderOptions = new ListOptions(TagClassName: "ew-header-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->HeaderOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        $this->FooterOptions = new ListOptions(TagClassName: "ew-footer-option", UseDropDownButton: false, UseButtonGroup: false);
        $item = &$this->FooterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Show active user count from SQL
    }

    // Active user filter
    // - Get active users by SQL (SELECT COUNT(*) FROM UserTable WHERE ProfileField LIKE '%"SessionID":%')
    protected function activeUserFilter()
    {
        if (UserProfile::$FORCE_LOGOUT_USER) {
            $userProfileField = $this->Fields[Config("USER_PROFILE_FIELD_NAME")];
            return $userProfileField->Expression . " LIKE '%\"" . UserProfile::$SESSION_ID . "\":%'";
        }
        return "0=1"; // No active users
    }

    // Create new column option
    protected function createColumnOption($option, $name)
    {
        $field = $this->Fields[$name] ?? null;
        if ($field?->Visible) {
            $item = $option->add($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions as $listAction) {
            if ($listAction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listAction->Action);
                $caption = $listAction->Caption;
                $icon = ($listAction->Icon != "") ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_expediente_oldlist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
                $item->Visible = $listAction->Allowed;
            }
        }

        // Hide multi edit, grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $users = [];
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("action", "");
        if ($filter != "" && $userAction != "") {
            $conn = $this->getConnection();
            // Clear current action
            $this->CurrentAction = "";
            // Check permission first
            $actionCaption = $userAction;
            $listAction = $this->ListActions[$userAction] ?? null;
            if ($listAction) {
                $this->UserAction = $userAction;
                $actionCaption = $listAction->Caption ?: $listAction->Action;
                if (!$listAction->Allowed) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            } else {
                // Skip checking, handle by Row_CustomAction
            }
            $rows = $this->loadRs($filter)->fetchAllAssociative();
            $this->SelectedCount = count($rows);
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($this->SelectedCount > 0) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedIndex = 0;
                foreach ($rows as $row) {
                    $this->SelectedIndex++;
                    if ($listAction) {
                        $processed = $listAction->handle($row, $this);
                        if (!$processed) {
                            break;
                        }
                    }
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        if ($conn->isTransactionActive()) {
                            $conn->commit();
                        }
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($listAction->SuccessMessage);
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage(str_replace("%s", $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        if ($conn->isTransactionActive()) {
                            $conn->rollback();
                        }
                    }
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($listAction->FailureMessage);
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if (Post("ajax") == $userAction) { // Ajax
                if (WithJsonResponse()) { // List action returns JSON
                    $this->clearSuccessMessage(); // Clear success message
                    $this->clearFailureMessage(); // Clear failure message
                } else {
                    if ($this->getSuccessMessage() != "") {
                        echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                        $this->clearSuccessMessage(); // Clear success message
                    }
                    if ($this->getFailureMessage() != "") {
                        echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                        $this->clearFailureMessage(); // Clear failure message
                    }
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        if ($this->ExportAll && $this->isExport()) {
            $this->StopRecord = $this->TotalRecords;
        } else {
            // Set the last record to display
            if ($this->TotalRecords > $this->StartRecord + $this->DisplayRecords - 1) {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            } else {
                $this->StopRecord = $this->TotalRecords;
            }
        }
        $this->RecordCount = $this->StartRecord - 1;
        if ($this->CurrentRow !== false) {
            // Nothing to do
        } elseif ($this->isGridAdd() && !$this->AllowAddDeleteRow && $this->StopRecord == 0) { // Grid-Add with no records
            $this->StopRecord = $this->GridAddRowCount;
        } elseif ($this->isAdd() && $this->TotalRecords == 0) { // Inline-Add with no records
            $this->StopRecord = 1;
        }

        // Initialize aggregate
        $this->RowType = RowType::AGGREGATEINIT;
        $this->resetAttributes();
        $this->renderRow();
        if (($this->isGridAdd() || $this->isGridEdit())) { // Render template row first
            $this->RowIndex = '$rowindex$';
        }
    }

    // Set up Row
    public function setupRow()
    {
        global $CurrentForm;
        if ($this->isGridAdd() || $this->isGridEdit()) {
            if ($this->RowIndex === '$rowindex$') { // Render template row first
                $this->loadRowValues();

                // Set row properties
                $this->resetAttributes();
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_expediente_old", "data-rowtype" => RowType::ADD]);
                $this->RowAttrs->appendClass("ew-template");
                // Render row
                $this->RowType = RowType::ADD;
                $this->renderRow();

                // Render list options
                $this->renderListOptions();

                // Reset record count for template row
                $this->RecordCount--;
                return;
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isCopy() && $this->InlineRowCount == 0 && !$this->loadRow()) { // Inline copy
            $this->CurrentAction = "add";
        }
        if ($this->isAdd() && $this->InlineRowCount == 0 || $this->isGridAdd()) {
            $this->loadRowValues(); // Load default values
            $this->OldKey = "";
            $this->setKey($this->OldKey);
        } elseif ($this->isInlineInserted() && $this->UseInfiniteScroll) {
            // Nothing to do, just use current values
        } elseif (!($this->isCopy() && $this->InlineRowCount == 0)) {
            $this->loadRowValues($this->CurrentRow); // Load row values
            if ($this->isGridEdit() || $this->isMultiEdit()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey);
            }
        }
        $this->RowType = RowType::VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = RowType::ADD; // Render add
        }

        // Inline Add/Copy row (row 0)
        if ($this->RowType == RowType::ADD && ($this->isAdd() || $this->isCopy())) {
            $this->InlineRowCount++;
            $this->RecordCount--; // Reset record count for inline add/copy row
            if ($this->TotalRecords == 0) { // Reset stop record if no records
                $this->StopRecord = 0;
            }
        } else {
            // Inline Edit row
            if ($this->RowType == RowType::EDIT && $this->isEdit()) {
                $this->InlineRowCount++;
            }
            $this->RowCount++; // Increment row count
        }

        // Set up row attributes
        $this->RowAttrs->merge([
            "data-rowindex" => $this->RowCount,
            "data-key" => $this->getKey(true),
            "id" => "r" . $this->RowCount . "_sco_expediente_old",
            "data-rowtype" => $this->RowType,
            "data-inline" => ($this->isAdd() || $this->isCopy() || $this->isEdit()) ? "true" : "false", // Inline-Add/Copy/Edit
            "class" => ($this->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($this->isAdd() && $this->RowType == RowType::ADD || $this->isEdit() && $this->RowType == RowType::EDIT) { // Inline-Add/Edit row
            $this->RowAttrs->appendClass("table-active");
        }

        // Render row
        $this->renderRow();

        // Render list options
        $this->renderListOptions();
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    /**
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->tipo_contratacion->setDbValue($row['tipo_contratacion']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nacionalidad_contacto->setDbValue($row['nacionalidad_contacto']);
        $this->cedula_contacto->setDbValue($row['cedula_contacto']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->apellidos_contacto->setDbValue($row['apellidos_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->nacionalidad_fallecido->setDbValue($row['nacionalidad_fallecido']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->edad_fallecido->setDbValue($row['edad_fallecido']);
        $this->estado_civil->setDbValue($row['estado_civil']);
        $this->lugar_nacimiento_fallecido->setDbValue($row['lugar_nacimiento_fallecido']);
        $this->lugar_ocurrencia->setDbValue($row['lugar_ocurrencia']);
        $this->direccion_ocurrencia->setDbValue($row['direccion_ocurrencia']);
        $this->fecha_ocurrencia->setDbValue($row['fecha_ocurrencia']);
        $this->hora_ocurrencia->setDbValue($row['hora_ocurrencia']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->causa_otro->setDbValue($row['causa_otro']);
        $this->descripcion_ocurrencia->setDbValue($row['descripcion_ocurrencia']);
        $this->calidad->setDbValue($row['calidad']);
        $this->costos->setDbValue($row['costos']);
        $this->venta->setDbValue($row['venta']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_cierra->setDbValue($row['user_cierra']);
        $this->fecha_cierre->setDbValue($row['fecha_cierre']);
        $this->estatus->setDbValue($row['estatus']);
        $this->factura->setDbValue($row['factura']);
        $this->permiso->setDbValue($row['permiso']);
        $this->unir_con_expediente->setDbValue($row['unir_con_expediente']);
        $this->nota->setDbValue($row['nota']);
        $this->_email->setDbValue($row['email']);
        $this->religion->setDbValue($row['religion']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->marca_pasos->setDbValue($row['marca_pasos']);
        $this->autoriza_cremar->setDbValue($row['autoriza_cremar']);
        $this->username_autoriza->setDbValue($row['username_autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->peso->setDbValue($row['peso']);
        $this->contrato_parcela->setDbValue($row['contrato_parcela']);
        $this->email_calidad->setDbValue($row['email_calidad']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->parcela->setDbValue($row['parcela']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente'] = $this->Nexpediente->DefaultValue;
        $row['tipo_contratacion'] = $this->tipo_contratacion->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nacionalidad_contacto'] = $this->nacionalidad_contacto->DefaultValue;
        $row['cedula_contacto'] = $this->cedula_contacto->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['apellidos_contacto'] = $this->apellidos_contacto->DefaultValue;
        $row['parentesco_contacto'] = $this->parentesco_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['nacionalidad_fallecido'] = $this->nacionalidad_fallecido->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['sexo'] = $this->sexo->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['edad_fallecido'] = $this->edad_fallecido->DefaultValue;
        $row['estado_civil'] = $this->estado_civil->DefaultValue;
        $row['lugar_nacimiento_fallecido'] = $this->lugar_nacimiento_fallecido->DefaultValue;
        $row['lugar_ocurrencia'] = $this->lugar_ocurrencia->DefaultValue;
        $row['direccion_ocurrencia'] = $this->direccion_ocurrencia->DefaultValue;
        $row['fecha_ocurrencia'] = $this->fecha_ocurrencia->DefaultValue;
        $row['hora_ocurrencia'] = $this->hora_ocurrencia->DefaultValue;
        $row['causa_ocurrencia'] = $this->causa_ocurrencia->DefaultValue;
        $row['causa_otro'] = $this->causa_otro->DefaultValue;
        $row['descripcion_ocurrencia'] = $this->descripcion_ocurrencia->DefaultValue;
        $row['calidad'] = $this->calidad->DefaultValue;
        $row['costos'] = $this->costos->DefaultValue;
        $row['venta'] = $this->venta->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['user_cierra'] = $this->user_cierra->DefaultValue;
        $row['fecha_cierre'] = $this->fecha_cierre->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['permiso'] = $this->permiso->DefaultValue;
        $row['unir_con_expediente'] = $this->unir_con_expediente->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['religion'] = $this->religion->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['marca_pasos'] = $this->marca_pasos->DefaultValue;
        $row['autoriza_cremar'] = $this->autoriza_cremar->DefaultValue;
        $row['username_autoriza'] = $this->username_autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
        $row['peso'] = $this->peso->DefaultValue;
        $row['contrato_parcela'] = $this->contrato_parcela->DefaultValue;
        $row['email_calidad'] = $this->email_calidad->DefaultValue;
        $row['certificado_defuncion'] = $this->certificado_defuncion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = ExecuteQuery($sql, $conn);
            if ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Nexpediente

        // tipo_contratacion

        // seguro

        // nacionalidad_contacto

        // cedula_contacto

        // nombre_contacto

        // apellidos_contacto

        // parentesco_contacto

        // telefono_contacto1

        // telefono_contacto2

        // nacionalidad_fallecido

        // cedula_fallecido

        // sexo

        // nombre_fallecido

        // apellidos_fallecido

        // fecha_nacimiento

        // edad_fallecido

        // estado_civil

        // lugar_nacimiento_fallecido

        // lugar_ocurrencia

        // direccion_ocurrencia

        // fecha_ocurrencia

        // hora_ocurrencia

        // causa_ocurrencia

        // causa_otro

        // descripcion_ocurrencia

        // calidad

        // costos

        // venta

        // user_registra

        // fecha_registro

        // user_cierra

        // fecha_cierre

        // estatus

        // factura

        // permiso

        // unir_con_expediente

        // nota

        // email

        // religion

        // servicio_tipo

        // servicio

        // funeraria

        // marca_pasos

        // autoriza_cremar

        // username_autoriza

        // fecha_autoriza

        // peso

        // contrato_parcela

        // email_calidad

        // certificado_defuncion

        // parcela

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente
            $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

            // tipo_contratacion
            $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->CurrentValue;

            // seguro
            $this->seguro->ViewValue = $this->seguro->CurrentValue;
            $this->seguro->ViewValue = FormatNumber($this->seguro->ViewValue, $this->seguro->formatPattern());

            // nacionalidad_contacto
            $this->nacionalidad_contacto->ViewValue = $this->nacionalidad_contacto->CurrentValue;

            // cedula_contacto
            $this->cedula_contacto->ViewValue = $this->cedula_contacto->CurrentValue;

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // apellidos_contacto
            $this->apellidos_contacto->ViewValue = $this->apellidos_contacto->CurrentValue;

            // parentesco_contacto
            $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->CurrentValue;

            // telefono_contacto1
            $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

            // telefono_contacto2
            $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->ViewValue = $this->nacionalidad_fallecido->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

            // sexo
            $this->sexo->ViewValue = $this->sexo->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
            $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

            // edad_fallecido
            $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;
            $this->edad_fallecido->ViewValue = FormatNumber($this->edad_fallecido->ViewValue, $this->edad_fallecido->formatPattern());

            // estado_civil
            $this->estado_civil->ViewValue = $this->estado_civil->CurrentValue;

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;

            // lugar_ocurrencia
            $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->CurrentValue;

            // direccion_ocurrencia
            $this->direccion_ocurrencia->ViewValue = $this->direccion_ocurrencia->CurrentValue;

            // fecha_ocurrencia
            $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
            $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

            // hora_ocurrencia
            $this->hora_ocurrencia->ViewValue = $this->hora_ocurrencia->CurrentValue;
            $this->hora_ocurrencia->ViewValue = FormatDateTime($this->hora_ocurrencia->ViewValue, $this->hora_ocurrencia->formatPattern());

            // causa_ocurrencia
            $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

            // causa_otro
            $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->ViewValue = $this->descripcion_ocurrencia->CurrentValue;

            // calidad
            $this->calidad->ViewValue = $this->calidad->CurrentValue;

            // costos
            $this->costos->ViewValue = $this->costos->CurrentValue;
            $this->costos->ViewValue = FormatNumber($this->costos->ViewValue, $this->costos->formatPattern());

            // venta
            $this->venta->ViewValue = $this->venta->CurrentValue;
            $this->venta->ViewValue = FormatNumber($this->venta->ViewValue, $this->venta->formatPattern());

            // user_registra
            $this->user_registra->ViewValue = $this->user_registra->CurrentValue;

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // user_cierra
            $this->user_cierra->ViewValue = $this->user_cierra->CurrentValue;

            // fecha_cierre
            $this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
            $this->fecha_cierre->ViewValue = FormatDateTime($this->fecha_cierre->ViewValue, $this->fecha_cierre->formatPattern());

            // estatus
            $this->estatus->ViewValue = $this->estatus->CurrentValue;
            $this->estatus->ViewValue = FormatNumber($this->estatus->ViewValue, $this->estatus->formatPattern());

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // permiso
            $this->permiso->ViewValue = $this->permiso->CurrentValue;

            // unir_con_expediente
            $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->CurrentValue;
            $this->unir_con_expediente->ViewValue = FormatNumber($this->unir_con_expediente->ViewValue, $this->unir_con_expediente->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // religion
            $this->religion->ViewValue = $this->religion->CurrentValue;

            // servicio_tipo
            $this->servicio_tipo->ViewValue = $this->servicio_tipo->CurrentValue;

            // servicio
            $this->servicio->ViewValue = $this->servicio->CurrentValue;

            // funeraria
            $this->funeraria->ViewValue = $this->funeraria->CurrentValue;
            $this->funeraria->ViewValue = FormatNumber($this->funeraria->ViewValue, $this->funeraria->formatPattern());

            // marca_pasos
            if (strval($this->marca_pasos->CurrentValue) != "") {
                $this->marca_pasos->ViewValue = $this->marca_pasos->optionCaption($this->marca_pasos->CurrentValue);
            } else {
                $this->marca_pasos->ViewValue = null;
            }

            // autoriza_cremar
            if (strval($this->autoriza_cremar->CurrentValue) != "") {
                $this->autoriza_cremar->ViewValue = $this->autoriza_cremar->optionCaption($this->autoriza_cremar->CurrentValue);
            } else {
                $this->autoriza_cremar->ViewValue = null;
            }

            // username_autoriza
            $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;

            // fecha_autoriza
            $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
            $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

            // peso
            $this->peso->ViewValue = $this->peso->CurrentValue;

            // contrato_parcela
            $this->contrato_parcela->ViewValue = $this->contrato_parcela->CurrentValue;

            // email_calidad
            if (strval($this->email_calidad->CurrentValue) != "") {
                $this->email_calidad->ViewValue = $this->email_calidad->optionCaption($this->email_calidad->CurrentValue);
            } else {
                $this->email_calidad->ViewValue = null;
            }

            // certificado_defuncion
            $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // Nexpediente
            $this->Nexpediente->HrefValue = "";
            $this->Nexpediente->TooltipValue = "";

            // tipo_contratacion
            $this->tipo_contratacion->HrefValue = "";
            $this->tipo_contratacion->TooltipValue = "";

            // seguro
            $this->seguro->HrefValue = "";
            $this->seguro->TooltipValue = "";

            // nacionalidad_contacto
            $this->nacionalidad_contacto->HrefValue = "";
            $this->nacionalidad_contacto->TooltipValue = "";

            // cedula_contacto
            $this->cedula_contacto->HrefValue = "";
            $this->cedula_contacto->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";
            $this->nombre_contacto->TooltipValue = "";

            // apellidos_contacto
            $this->apellidos_contacto->HrefValue = "";
            $this->apellidos_contacto->TooltipValue = "";

            // parentesco_contacto
            $this->parentesco_contacto->HrefValue = "";
            $this->parentesco_contacto->TooltipValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";
            $this->telefono_contacto1->TooltipValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";
            $this->telefono_contacto2->TooltipValue = "";

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->HrefValue = "";
            $this->nacionalidad_fallecido->TooltipValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";
            $this->cedula_fallecido->TooltipValue = "";

            // sexo
            $this->sexo->HrefValue = "";
            $this->sexo->TooltipValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";
            $this->nombre_fallecido->TooltipValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";
            $this->apellidos_fallecido->TooltipValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";
            $this->fecha_nacimiento->TooltipValue = "";

            // edad_fallecido
            $this->edad_fallecido->HrefValue = "";
            $this->edad_fallecido->TooltipValue = "";

            // estado_civil
            $this->estado_civil->HrefValue = "";
            $this->estado_civil->TooltipValue = "";

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->HrefValue = "";
            $this->lugar_nacimiento_fallecido->TooltipValue = "";

            // lugar_ocurrencia
            $this->lugar_ocurrencia->HrefValue = "";
            $this->lugar_ocurrencia->TooltipValue = "";

            // direccion_ocurrencia
            $this->direccion_ocurrencia->HrefValue = "";
            $this->direccion_ocurrencia->TooltipValue = "";

            // fecha_ocurrencia
            $this->fecha_ocurrencia->HrefValue = "";
            $this->fecha_ocurrencia->TooltipValue = "";

            // hora_ocurrencia
            $this->hora_ocurrencia->HrefValue = "";
            $this->hora_ocurrencia->TooltipValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";
            $this->causa_ocurrencia->TooltipValue = "";

            // causa_otro
            $this->causa_otro->HrefValue = "";
            $this->causa_otro->TooltipValue = "";

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->HrefValue = "";
            $this->descripcion_ocurrencia->TooltipValue = "";

            // calidad
            $this->calidad->HrefValue = "";
            $this->calidad->TooltipValue = "";

            // costos
            $this->costos->HrefValue = "";
            $this->costos->TooltipValue = "";

            // venta
            $this->venta->HrefValue = "";
            $this->venta->TooltipValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";
            $this->user_registra->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // user_cierra
            $this->user_cierra->HrefValue = "";
            $this->user_cierra->TooltipValue = "";

            // fecha_cierre
            $this->fecha_cierre->HrefValue = "";
            $this->fecha_cierre->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";

            // factura
            $this->factura->HrefValue = "";
            $this->factura->TooltipValue = "";

            // permiso
            $this->permiso->HrefValue = "";
            $this->permiso->TooltipValue = "";

            // unir_con_expediente
            $this->unir_con_expediente->HrefValue = "";
            $this->unir_con_expediente->TooltipValue = "";

            // nota
            $this->nota->HrefValue = "";
            $this->nota->TooltipValue = "";

            // email
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // religion
            $this->religion->HrefValue = "";
            $this->religion->TooltipValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";
            $this->servicio_tipo->TooltipValue = "";

            // servicio
            $this->servicio->HrefValue = "";
            $this->servicio->TooltipValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
            $this->funeraria->TooltipValue = "";

            // marca_pasos
            $this->marca_pasos->HrefValue = "";
            $this->marca_pasos->TooltipValue = "";

            // autoriza_cremar
            $this->autoriza_cremar->HrefValue = "";
            $this->autoriza_cremar->TooltipValue = "";

            // username_autoriza
            $this->username_autoriza->HrefValue = "";
            $this->username_autoriza->TooltipValue = "";

            // fecha_autoriza
            $this->fecha_autoriza->HrefValue = "";
            $this->fecha_autoriza->TooltipValue = "";

            // peso
            $this->peso->HrefValue = "";
            $this->peso->TooltipValue = "";

            // contrato_parcela
            $this->contrato_parcela->HrefValue = "";
            $this->contrato_parcela->TooltipValue = "";

            // email_calidad
            $this->email_calidad->HrefValue = "";
            $this->email_calidad->TooltipValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";
            $this->certificado_defuncion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl(false);
        $this->SearchOptions = new ListOptions(TagClassName: "ew-search-option");

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : "";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_expediente_oldsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        if ($this->UseCustomTemplate || !$this->UseAjaxActions) {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        } else {
            $item->Body = "<a class=\"btn btn-default ew-show-all\" role=\"button\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" data-ew-action=\"refresh\" data-url=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        }
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction && $this->CurrentAction != "search") {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return true;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset(all)
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_marca_pasos":
                    break;
                case "x_autoriza_cremar":
                    break;
                case "x_email_calidad":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = ConvertToBool(Param("infinitescroll"));
        if ($pageNo !== null) { // Check for "pageno" parameter first
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                if ($this->StartRecord <= 0) {
                    $this->StartRecord = 1;
                } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                    $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                }
            }
        } elseif ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
            $this->StartRecord = $startRec;
        } elseif (!$infiniteScroll) {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
    }

    // Parse query builder rule
    protected function parseRules($group, $fieldName = "", $itemName = "") {
        $group["condition"] ??= "AND";
        if (!in_array($group["condition"], ["AND", "OR"])) {
            throw new \Exception("Unable to build SQL query with condition '" . $group["condition"] . "'");
        }
        if (!is_array($group["rules"] ?? null)) {
            return "";
        }
        $parts = [];
        foreach ($group["rules"] as $rule) {
            if (is_array($rule["rules"] ?? null) && count($rule["rules"]) > 0) {
                $part = $this->parseRules($rule, $fieldName, $itemName);
                if ($part) {
                    $parts[] = "(" . " " . $part . " " . ")" . " ";
                }
            } else {
                $field = $rule["field"];
                $fld = $this->fieldByParam($field);
                $dbid = $this->Dbid;
                if ($fld instanceof ReportField && is_array($fld->DashboardSearchSourceFields)) {
                    $item = $fld->DashboardSearchSourceFields[$itemName] ?? null;
                    if ($item) {
                        $tbl = Container($item["table"]);
                        $dbid = $tbl->Dbid;
                        $fld = $tbl->Fields[$item["field"]];
                    } else {
                        $fld = null;
                    }
                }
                if ($fld && ($fieldName == "" || $fld->Name == $fieldName)) { // Field name not specified or matched field name
                    $fldOpr = array_search($rule["operator"], Config("CLIENT_SEARCH_OPERATORS"));
                    $ope = Config("QUERY_BUILDER_OPERATORS")[$rule["operator"]] ?? null;
                    if (!$ope || !$fldOpr) {
                        throw new \Exception("Unknown SQL operation for operator '" . $rule["operator"] . "'");
                    }
                    if ($ope["nb_inputs"] > 0 && isset($rule["value"]) && !EmptyValue($rule["value"]) || IsNullOrEmptyOperator($fldOpr)) {
                        $fldVal = $rule["value"];
                        if (is_array($fldVal)) {
                            $fldVal = $fld->isMultiSelect() ? implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal) : $fldVal[0];
                        }
                        $useFilter = $fld->UseFilter; // Query builder does not use filter
                        try {
                            if ($fld instanceof ReportField) { // Search report fields
                                if ($fld->SearchType == "dropdown") {
                                    if (is_array($fldVal)) {
                                        $sql = "";
                                        foreach ($fldVal as $val) {
                                            AddFilter($sql, DropDownFilter($fld, $val, $fldOpr, $dbid), "OR");
                                        }
                                        $parts[] = $sql;
                                    } else {
                                        $parts[] = DropDownFilter($fld, $fldVal, $fldOpr, $dbid);
                                    }
                                } else {
                                    $fld->AdvancedSearch->SearchOperator = $fldOpr;
                                    $fld->AdvancedSearch->SearchValue = $fldVal;
                                    $parts[] = GetReportFilter($fld, false, $dbid);
                                }
                            } else { // Search normal fields
                                if ($fld->isMultiSelect()) {
                                    $parts[] = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, ConvertSearchValue($fldVal, $fldOpr, $fld), $this->Dbid) : "";
                                } else {
                                    $fldVal2 = ContainsString($fldOpr, "BETWEEN") ? $rule["value"][1] : ""; // BETWEEN
                                    if (is_array($fldVal2)) {
                                        $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
                                    }
                                    $fld->AdvancedSearch->SearchValue = ConvertSearchValue($fldVal, $fldOpr, $fld);
                                    $fld->AdvancedSearch->SearchValue2 = ConvertSearchValue($fldVal2, $fldOpr, $fld);
                                    $parts[] = GetSearchSql(
                                        $fld,
                                        $fld->AdvancedSearch->SearchValue, // SearchValue
                                        $fldOpr,
                                        "", // $fldCond not used
                                        $fld->AdvancedSearch->SearchValue2, // SearchValue2
                                        "", // $fldOpr2 not used
                                        $this->Dbid
                                    );
                                }
                            }
                        } finally {
                            $fld->UseFilter = $useFilter;
                        }
                    }
                }
            }
        }
        $where = "";
        foreach ($parts as $part) {
            AddFilter($where, $part, $group["condition"]);
        }
        if ($where && ($group["not"] ?? false)) {
            $where = "NOT (" . $where . ")";
        }
        return $where;
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->moveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }

    // Page Importing event
    public function pageImporting(&$builder, &$options)
    {
        //var_dump($options); // Show all options for importing
        //$builder = fn($workflow) => $workflow->addStep($myStep);
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($obj, $results)
    {
        //var_dump($obj); // Workflow result object
        //var_dump($results); // Import results
    }
}
