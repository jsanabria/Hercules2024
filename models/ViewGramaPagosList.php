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
class ViewGramaPagosList extends ViewGramaPagos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewGramaPagosList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_grama_pagoslist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ViewGramaPagosList";

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
        $this->expediente->setVisibility();
        $this->registro_solicitud->setVisibility();
        $this->solicitante->setVisibility();
        $this->difunto->setVisibility();
        $this->ubicacion->setVisibility();
        $this->ctto_usd->setVisibility();
        $this->tipo_pago->setVisibility();
        $this->banco->setVisibility();
        $this->ref->setVisibility();
        $this->fecha_cobro->setVisibility();
        $this->resgitro_pago->setVisibility();
        $this->cta_destino->setVisibility();
        $this->monto_bs->setVisibility();
        $this->monto_usd->setVisibility();
        $this->monto_ue->setVisibility();
        $this->subtipo->setVisibility();
        $this->estatus->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'view_grama_pagos';
        $this->TableName = 'view_grama_pagos';

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

        // Table object (view_grama_pagos)
        if (!isset($GLOBALS["view_grama_pagos"]) || $GLOBALS["view_grama_pagos"]::class == PROJECT_NAMESPACE . "view_grama_pagos") {
            $GLOBALS["view_grama_pagos"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ViewGramaPagosAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ViewGramaPagosDelete";
        $this->MultiUpdateUrl = "ViewGramaPagosUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_grama_pagos');
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
                    $result["view"] = SameString($pageName, "ViewGramaPagosView"); // If View page, no primary button
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

        // Setup export options
        $this->setupExportOptions();
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
        $this->setupLookupOptions($this->tipo_pago);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fview_grama_pagosgrid";
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
        AddFilter($this->DefaultSearchWhere, $this->advancedSearchWhere(true));

        // Get basic search values
        $this->loadBasicSearchValues();

        // Get and validate search values for advanced search
        if (EmptyValue($this->UserAction)) { // Skip if user action
            $this->loadSearchValues();
        }

        // Process filter list
        if ($this->processFilterList()) {
            $this->terminate();
            return;
        }
        if (!$this->validateSearch()) {
            // Nothing to do
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

        // Get advanced search criteria
        if (!$this->hasInvalidFields()) {
            $srchAdvanced = $this->advancedSearchWhere();
        }

        // Get query builder criteria
        $query = $DashboardReport ? "" : $this->queryBuilderWhere();

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

            // Load advanced search from default
            if ($this->loadAdvancedSearchDefault()) {
                $srchAdvanced = $this->advancedSearchWhere(); // Save to session
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
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
        $filterList = Concat($filterList, $this->expediente->AdvancedSearch->toJson(), ","); // Field expediente
        $filterList = Concat($filterList, $this->registro_solicitud->AdvancedSearch->toJson(), ","); // Field registro_solicitud
        $filterList = Concat($filterList, $this->solicitante->AdvancedSearch->toJson(), ","); // Field solicitante
        $filterList = Concat($filterList, $this->difunto->AdvancedSearch->toJson(), ","); // Field difunto
        $filterList = Concat($filterList, $this->ubicacion->AdvancedSearch->toJson(), ","); // Field ubicacion
        $filterList = Concat($filterList, $this->ctto_usd->AdvancedSearch->toJson(), ","); // Field ctto_usd
        $filterList = Concat($filterList, $this->tipo_pago->AdvancedSearch->toJson(), ","); // Field tipo_pago
        $filterList = Concat($filterList, $this->banco->AdvancedSearch->toJson(), ","); // Field banco
        $filterList = Concat($filterList, $this->ref->AdvancedSearch->toJson(), ","); // Field ref
        $filterList = Concat($filterList, $this->fecha_cobro->AdvancedSearch->toJson(), ","); // Field fecha_cobro
        $filterList = Concat($filterList, $this->resgitro_pago->AdvancedSearch->toJson(), ","); // Field resgitro_pago
        $filterList = Concat($filterList, $this->cta_destino->AdvancedSearch->toJson(), ","); // Field cta_destino
        $filterList = Concat($filterList, $this->monto_bs->AdvancedSearch->toJson(), ","); // Field monto_bs
        $filterList = Concat($filterList, $this->monto_usd->AdvancedSearch->toJson(), ","); // Field monto_usd
        $filterList = Concat($filterList, $this->monto_ue->AdvancedSearch->toJson(), ","); // Field monto_ue
        $filterList = Concat($filterList, $this->subtipo->AdvancedSearch->toJson(), ","); // Field subtipo
        $filterList = Concat($filterList, $this->estatus->AdvancedSearch->toJson(), ","); // Field estatus
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
            Profile()->setSearchFilters("fview_grama_pagossrch", $filters);
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

        // Field expediente
        $this->expediente->AdvancedSearch->SearchValue = @$filter["x_expediente"];
        $this->expediente->AdvancedSearch->SearchOperator = @$filter["z_expediente"];
        $this->expediente->AdvancedSearch->SearchCondition = @$filter["v_expediente"];
        $this->expediente->AdvancedSearch->SearchValue2 = @$filter["y_expediente"];
        $this->expediente->AdvancedSearch->SearchOperator2 = @$filter["w_expediente"];
        $this->expediente->AdvancedSearch->save();

        // Field registro_solicitud
        $this->registro_solicitud->AdvancedSearch->SearchValue = @$filter["x_registro_solicitud"];
        $this->registro_solicitud->AdvancedSearch->SearchOperator = @$filter["z_registro_solicitud"];
        $this->registro_solicitud->AdvancedSearch->SearchCondition = @$filter["v_registro_solicitud"];
        $this->registro_solicitud->AdvancedSearch->SearchValue2 = @$filter["y_registro_solicitud"];
        $this->registro_solicitud->AdvancedSearch->SearchOperator2 = @$filter["w_registro_solicitud"];
        $this->registro_solicitud->AdvancedSearch->save();

        // Field solicitante
        $this->solicitante->AdvancedSearch->SearchValue = @$filter["x_solicitante"];
        $this->solicitante->AdvancedSearch->SearchOperator = @$filter["z_solicitante"];
        $this->solicitante->AdvancedSearch->SearchCondition = @$filter["v_solicitante"];
        $this->solicitante->AdvancedSearch->SearchValue2 = @$filter["y_solicitante"];
        $this->solicitante->AdvancedSearch->SearchOperator2 = @$filter["w_solicitante"];
        $this->solicitante->AdvancedSearch->save();

        // Field difunto
        $this->difunto->AdvancedSearch->SearchValue = @$filter["x_difunto"];
        $this->difunto->AdvancedSearch->SearchOperator = @$filter["z_difunto"];
        $this->difunto->AdvancedSearch->SearchCondition = @$filter["v_difunto"];
        $this->difunto->AdvancedSearch->SearchValue2 = @$filter["y_difunto"];
        $this->difunto->AdvancedSearch->SearchOperator2 = @$filter["w_difunto"];
        $this->difunto->AdvancedSearch->save();

        // Field ubicacion
        $this->ubicacion->AdvancedSearch->SearchValue = @$filter["x_ubicacion"];
        $this->ubicacion->AdvancedSearch->SearchOperator = @$filter["z_ubicacion"];
        $this->ubicacion->AdvancedSearch->SearchCondition = @$filter["v_ubicacion"];
        $this->ubicacion->AdvancedSearch->SearchValue2 = @$filter["y_ubicacion"];
        $this->ubicacion->AdvancedSearch->SearchOperator2 = @$filter["w_ubicacion"];
        $this->ubicacion->AdvancedSearch->save();

        // Field ctto_usd
        $this->ctto_usd->AdvancedSearch->SearchValue = @$filter["x_ctto_usd"];
        $this->ctto_usd->AdvancedSearch->SearchOperator = @$filter["z_ctto_usd"];
        $this->ctto_usd->AdvancedSearch->SearchCondition = @$filter["v_ctto_usd"];
        $this->ctto_usd->AdvancedSearch->SearchValue2 = @$filter["y_ctto_usd"];
        $this->ctto_usd->AdvancedSearch->SearchOperator2 = @$filter["w_ctto_usd"];
        $this->ctto_usd->AdvancedSearch->save();

        // Field tipo_pago
        $this->tipo_pago->AdvancedSearch->SearchValue = @$filter["x_tipo_pago"];
        $this->tipo_pago->AdvancedSearch->SearchOperator = @$filter["z_tipo_pago"];
        $this->tipo_pago->AdvancedSearch->SearchCondition = @$filter["v_tipo_pago"];
        $this->tipo_pago->AdvancedSearch->SearchValue2 = @$filter["y_tipo_pago"];
        $this->tipo_pago->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_pago"];
        $this->tipo_pago->AdvancedSearch->save();

        // Field banco
        $this->banco->AdvancedSearch->SearchValue = @$filter["x_banco"];
        $this->banco->AdvancedSearch->SearchOperator = @$filter["z_banco"];
        $this->banco->AdvancedSearch->SearchCondition = @$filter["v_banco"];
        $this->banco->AdvancedSearch->SearchValue2 = @$filter["y_banco"];
        $this->banco->AdvancedSearch->SearchOperator2 = @$filter["w_banco"];
        $this->banco->AdvancedSearch->save();

        // Field ref
        $this->ref->AdvancedSearch->SearchValue = @$filter["x_ref"];
        $this->ref->AdvancedSearch->SearchOperator = @$filter["z_ref"];
        $this->ref->AdvancedSearch->SearchCondition = @$filter["v_ref"];
        $this->ref->AdvancedSearch->SearchValue2 = @$filter["y_ref"];
        $this->ref->AdvancedSearch->SearchOperator2 = @$filter["w_ref"];
        $this->ref->AdvancedSearch->save();

        // Field fecha_cobro
        $this->fecha_cobro->AdvancedSearch->SearchValue = @$filter["x_fecha_cobro"];
        $this->fecha_cobro->AdvancedSearch->SearchOperator = @$filter["z_fecha_cobro"];
        $this->fecha_cobro->AdvancedSearch->SearchCondition = @$filter["v_fecha_cobro"];
        $this->fecha_cobro->AdvancedSearch->SearchValue2 = @$filter["y_fecha_cobro"];
        $this->fecha_cobro->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_cobro"];
        $this->fecha_cobro->AdvancedSearch->save();

        // Field resgitro_pago
        $this->resgitro_pago->AdvancedSearch->SearchValue = @$filter["x_resgitro_pago"];
        $this->resgitro_pago->AdvancedSearch->SearchOperator = @$filter["z_resgitro_pago"];
        $this->resgitro_pago->AdvancedSearch->SearchCondition = @$filter["v_resgitro_pago"];
        $this->resgitro_pago->AdvancedSearch->SearchValue2 = @$filter["y_resgitro_pago"];
        $this->resgitro_pago->AdvancedSearch->SearchOperator2 = @$filter["w_resgitro_pago"];
        $this->resgitro_pago->AdvancedSearch->save();

        // Field cta_destino
        $this->cta_destino->AdvancedSearch->SearchValue = @$filter["x_cta_destino"];
        $this->cta_destino->AdvancedSearch->SearchOperator = @$filter["z_cta_destino"];
        $this->cta_destino->AdvancedSearch->SearchCondition = @$filter["v_cta_destino"];
        $this->cta_destino->AdvancedSearch->SearchValue2 = @$filter["y_cta_destino"];
        $this->cta_destino->AdvancedSearch->SearchOperator2 = @$filter["w_cta_destino"];
        $this->cta_destino->AdvancedSearch->save();

        // Field monto_bs
        $this->monto_bs->AdvancedSearch->SearchValue = @$filter["x_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchOperator = @$filter["z_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchCondition = @$filter["v_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchValue2 = @$filter["y_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchOperator2 = @$filter["w_monto_bs"];
        $this->monto_bs->AdvancedSearch->save();

        // Field monto_usd
        $this->monto_usd->AdvancedSearch->SearchValue = @$filter["x_monto_usd"];
        $this->monto_usd->AdvancedSearch->SearchOperator = @$filter["z_monto_usd"];
        $this->monto_usd->AdvancedSearch->SearchCondition = @$filter["v_monto_usd"];
        $this->monto_usd->AdvancedSearch->SearchValue2 = @$filter["y_monto_usd"];
        $this->monto_usd->AdvancedSearch->SearchOperator2 = @$filter["w_monto_usd"];
        $this->monto_usd->AdvancedSearch->save();

        // Field monto_ue
        $this->monto_ue->AdvancedSearch->SearchValue = @$filter["x_monto_ue"];
        $this->monto_ue->AdvancedSearch->SearchOperator = @$filter["z_monto_ue"];
        $this->monto_ue->AdvancedSearch->SearchCondition = @$filter["v_monto_ue"];
        $this->monto_ue->AdvancedSearch->SearchValue2 = @$filter["y_monto_ue"];
        $this->monto_ue->AdvancedSearch->SearchOperator2 = @$filter["w_monto_ue"];
        $this->monto_ue->AdvancedSearch->save();

        // Field subtipo
        $this->subtipo->AdvancedSearch->SearchValue = @$filter["x_subtipo"];
        $this->subtipo->AdvancedSearch->SearchOperator = @$filter["z_subtipo"];
        $this->subtipo->AdvancedSearch->SearchCondition = @$filter["v_subtipo"];
        $this->subtipo->AdvancedSearch->SearchValue2 = @$filter["y_subtipo"];
        $this->subtipo->AdvancedSearch->SearchOperator2 = @$filter["w_subtipo"];
        $this->subtipo->AdvancedSearch->save();

        // Field estatus
        $this->estatus->AdvancedSearch->SearchValue = @$filter["x_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator = @$filter["z_estatus"];
        $this->estatus->AdvancedSearch->SearchCondition = @$filter["v_estatus"];
        $this->estatus->AdvancedSearch->SearchValue2 = @$filter["y_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator2 = @$filter["w_estatus"];
        $this->estatus->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Advanced search WHERE clause based on QueryString
    public function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->expediente, $default, false); // expediente
        $this->buildSearchSql($where, $this->registro_solicitud, $default, false); // registro_solicitud
        $this->buildSearchSql($where, $this->solicitante, $default, false); // solicitante
        $this->buildSearchSql($where, $this->difunto, $default, false); // difunto
        $this->buildSearchSql($where, $this->ubicacion, $default, false); // ubicacion
        $this->buildSearchSql($where, $this->ctto_usd, $default, false); // ctto_usd
        $this->buildSearchSql($where, $this->tipo_pago, $default, false); // tipo_pago
        $this->buildSearchSql($where, $this->banco, $default, false); // banco
        $this->buildSearchSql($where, $this->ref, $default, false); // ref
        $this->buildSearchSql($where, $this->fecha_cobro, $default, false); // fecha_cobro
        $this->buildSearchSql($where, $this->resgitro_pago, $default, false); // resgitro_pago
        $this->buildSearchSql($where, $this->cta_destino, $default, false); // cta_destino
        $this->buildSearchSql($where, $this->monto_bs, $default, false); // monto_bs
        $this->buildSearchSql($where, $this->monto_usd, $default, false); // monto_usd
        $this->buildSearchSql($where, $this->monto_ue, $default, false); // monto_ue
        $this->buildSearchSql($where, $this->subtipo, $default, false); // subtipo
        $this->buildSearchSql($where, $this->estatus, $default, false); // estatus

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->expediente->AdvancedSearch->save(); // expediente
            $this->registro_solicitud->AdvancedSearch->save(); // registro_solicitud
            $this->solicitante->AdvancedSearch->save(); // solicitante
            $this->difunto->AdvancedSearch->save(); // difunto
            $this->ubicacion->AdvancedSearch->save(); // ubicacion
            $this->ctto_usd->AdvancedSearch->save(); // ctto_usd
            $this->tipo_pago->AdvancedSearch->save(); // tipo_pago
            $this->banco->AdvancedSearch->save(); // banco
            $this->ref->AdvancedSearch->save(); // ref
            $this->fecha_cobro->AdvancedSearch->save(); // fecha_cobro
            $this->resgitro_pago->AdvancedSearch->save(); // resgitro_pago
            $this->cta_destino->AdvancedSearch->save(); // cta_destino
            $this->monto_bs->AdvancedSearch->save(); // monto_bs
            $this->monto_usd->AdvancedSearch->save(); // monto_usd
            $this->monto_ue->AdvancedSearch->save(); // monto_ue
            $this->subtipo->AdvancedSearch->save(); // subtipo
            $this->estatus->AdvancedSearch->save(); // estatus

            // Clear rules for QueryBuilder
            $this->setSessionRules("");
        }
        return $where;
    }

    // Query builder rules
    public function queryBuilderRules()
    {
        return Post("rules") ?? $this->getSessionRules();
    }

    // Quey builder WHERE clause
    public function queryBuilderWhere($fieldName = "")
    {
        global $Security;
        if (!$Security->canSearch()) {
            return "";
        }

        // Get rules by query builder
        $rules = $this->queryBuilderRules();

        // Decode and parse rules
        $where = $rules ? $this->parseRules(json_decode($rules, true), $fieldName) : "";

        // Clear other search and save rules to session
        if ($where && $fieldName == "") { // Skip if get query for specific field
            $this->resetSearchParms();
            $this->expediente->AdvancedSearch->save(); // expediente
            $this->registro_solicitud->AdvancedSearch->save(); // registro_solicitud
            $this->solicitante->AdvancedSearch->save(); // solicitante
            $this->difunto->AdvancedSearch->save(); // difunto
            $this->ubicacion->AdvancedSearch->save(); // ubicacion
            $this->ctto_usd->AdvancedSearch->save(); // ctto_usd
            $this->tipo_pago->AdvancedSearch->save(); // tipo_pago
            $this->banco->AdvancedSearch->save(); // banco
            $this->ref->AdvancedSearch->save(); // ref
            $this->fecha_cobro->AdvancedSearch->save(); // fecha_cobro
            $this->resgitro_pago->AdvancedSearch->save(); // resgitro_pago
            $this->cta_destino->AdvancedSearch->save(); // cta_destino
            $this->monto_bs->AdvancedSearch->save(); // monto_bs
            $this->monto_usd->AdvancedSearch->save(); // monto_usd
            $this->monto_ue->AdvancedSearch->save(); // monto_ue
            $this->subtipo->AdvancedSearch->save(); // subtipo
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->setSessionRules($rules);
        }

        // Return query
        return $where;
    }

    // Build search SQL
    protected function buildSearchSql(&$where, $fld, $default, $multiValue)
    {
        $fldParm = $fld->Param;
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldCond = $default ? $fld->AdvancedSearch->SearchConditionDefault : $fld->AdvancedSearch->SearchCondition;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        $fldOpr2 = $default ? $fld->AdvancedSearch->SearchOperator2Default : $fld->AdvancedSearch->SearchOperator2;
        $fldVal = ConvertSearchValue($fldVal, $fldOpr, $fld);
        $fldVal2 = ConvertSearchValue($fldVal2, $fldOpr2, $fld);
        $fldOpr = ConvertSearchOperator($fldOpr, $fld, $fldVal);
        $fldOpr2 = ConvertSearchOperator($fldOpr2, $fld, $fldVal2);
        $wrk = "";
        $sep = $fld->UseFilter ? Config("FILTER_OPTION_SEPARATOR") : Config("MULTIPLE_OPTION_SEPARATOR");
        if (is_array($fldVal)) {
            $fldVal = implode($sep, $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode($sep, $fldVal2);
        }
        if (Config("SEARCH_MULTI_VALUE_OPTION") == 1 && !$fld->UseFilter || !IsMultiSearchOperator($fldOpr)) {
            $multiValue = false;
        }
        if ($multiValue) {
            $wrk = $fldVal != "" ? GetMultiSearchSql($fld, $fldOpr, $fldVal, $this->Dbid) : ""; // Field value 1
            $wrk2 = $fldVal2 != "" ? GetMultiSearchSql($fld, $fldOpr2, $fldVal2, $this->Dbid) : ""; // Field value 2
            AddFilter($wrk, $wrk2, $fldCond);
        } else {
            $wrk = GetSearchSql($fld, $fldVal, $fldOpr, $fldCond, $fldVal2, $fldOpr2, $this->Dbid);
        }
        if ($this->SearchOption == "AUTO" && in_array($this->BasicSearch->getType(), ["AND", "OR"])) {
            $cond = $this->BasicSearch->getType();
        } else {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
        }
        AddFilter($where, $wrk, $cond);
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Field expediente
        $filter = $this->queryBuilderWhere("expediente");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->expediente, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->expediente->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field registro_solicitud
        $filter = $this->queryBuilderWhere("registro_solicitud");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->registro_solicitud, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->registro_solicitud->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field solicitante
        $filter = $this->queryBuilderWhere("solicitante");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->solicitante, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->solicitante->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field difunto
        $filter = $this->queryBuilderWhere("difunto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->difunto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->difunto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ubicacion
        $filter = $this->queryBuilderWhere("ubicacion");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ubicacion, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ubicacion->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ctto_usd
        $filter = $this->queryBuilderWhere("ctto_usd");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ctto_usd, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ctto_usd->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipo_pago
        $filter = $this->queryBuilderWhere("tipo_pago");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipo_pago, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo_pago->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field banco
        $filter = $this->queryBuilderWhere("banco");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->banco, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->banco->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ref
        $filter = $this->queryBuilderWhere("ref");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ref, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ref->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecha_cobro
        $filter = $this->queryBuilderWhere("fecha_cobro");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecha_cobro, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecha_cobro->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field resgitro_pago
        $filter = $this->queryBuilderWhere("resgitro_pago");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->resgitro_pago, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->resgitro_pago->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cta_destino
        $filter = $this->queryBuilderWhere("cta_destino");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cta_destino, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cta_destino->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field monto_bs
        $filter = $this->queryBuilderWhere("monto_bs");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->monto_bs, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->monto_bs->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field monto_usd
        $filter = $this->queryBuilderWhere("monto_usd");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->monto_usd, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->monto_usd->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field monto_ue
        $filter = $this->queryBuilderWhere("monto_ue");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->monto_ue, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->monto_ue->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field subtipo
        $filter = $this->queryBuilderWhere("subtipo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->subtipo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->subtipo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field estatus
        $filter = $this->queryBuilderWhere("estatus");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->estatus, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->estatus->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }
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
        $searchFlds[] = &$this->solicitante;
        $searchFlds[] = &$this->difunto;
        $searchFlds[] = &$this->ubicacion;
        $searchFlds[] = &$this->tipo_pago;
        $searchFlds[] = &$this->banco;
        $searchFlds[] = &$this->ref;
        $searchFlds[] = &$this->cta_destino;
        $searchFlds[] = &$this->subtipo;
        $searchFlds[] = &$this->estatus;
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
        if ($this->expediente->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->registro_solicitud->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->solicitante->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->difunto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ubicacion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ctto_usd->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo_pago->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->banco->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ref->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_cobro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->resgitro_pago->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cta_destino->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monto_bs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monto_usd->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monto_ue->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->subtipo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estatus->AdvancedSearch->issetSession()) {
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

        // Clear advanced search parameters
        $this->resetAdvancedSearchParms();

        // Clear queryBuilder
        $this->setSessionRules("");
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

    // Clear all advanced search parameters
    protected function resetAdvancedSearchParms()
    {
        $this->expediente->AdvancedSearch->unsetSession();
        $this->registro_solicitud->AdvancedSearch->unsetSession();
        $this->solicitante->AdvancedSearch->unsetSession();
        $this->difunto->AdvancedSearch->unsetSession();
        $this->ubicacion->AdvancedSearch->unsetSession();
        $this->ctto_usd->AdvancedSearch->unsetSession();
        $this->tipo_pago->AdvancedSearch->unsetSession();
        $this->banco->AdvancedSearch->unsetSession();
        $this->ref->AdvancedSearch->unsetSession();
        $this->fecha_cobro->AdvancedSearch->unsetSession();
        $this->resgitro_pago->AdvancedSearch->unsetSession();
        $this->cta_destino->AdvancedSearch->unsetSession();
        $this->monto_bs->AdvancedSearch->unsetSession();
        $this->monto_usd->AdvancedSearch->unsetSession();
        $this->monto_ue->AdvancedSearch->unsetSession();
        $this->subtipo->AdvancedSearch->unsetSession();
        $this->estatus->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->expediente->AdvancedSearch->load();
        $this->registro_solicitud->AdvancedSearch->load();
        $this->solicitante->AdvancedSearch->load();
        $this->difunto->AdvancedSearch->load();
        $this->ubicacion->AdvancedSearch->load();
        $this->ctto_usd->AdvancedSearch->load();
        $this->tipo_pago->AdvancedSearch->load();
        $this->banco->AdvancedSearch->load();
        $this->ref->AdvancedSearch->load();
        $this->fecha_cobro->AdvancedSearch->load();
        $this->resgitro_pago->AdvancedSearch->load();
        $this->cta_destino->AdvancedSearch->load();
        $this->monto_bs->AdvancedSearch->load();
        $this->monto_usd->AdvancedSearch->load();
        $this->monto_ue->AdvancedSearch->load();
        $this->subtipo->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->expediente->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->expediente); // expediente
            $this->updateSort($this->registro_solicitud); // registro_solicitud
            $this->updateSort($this->solicitante); // solicitante
            $this->updateSort($this->difunto); // difunto
            $this->updateSort($this->ubicacion); // ubicacion
            $this->updateSort($this->ctto_usd); // ctto_usd
            $this->updateSort($this->tipo_pago); // tipo_pago
            $this->updateSort($this->banco); // banco
            $this->updateSort($this->ref); // ref
            $this->updateSort($this->fecha_cobro); // fecha_cobro
            $this->updateSort($this->resgitro_pago); // resgitro_pago
            $this->updateSort($this->cta_destino); // cta_destino
            $this->updateSort($this->monto_bs); // monto_bs
            $this->updateSort($this->monto_usd); // monto_usd
            $this->updateSort($this->monto_ue); // monto_ue
            $this->updateSort($this->subtipo); // subtipo
            $this->updateSort($this->estatus); // estatus
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
                $this->expediente->setSort("");
                $this->registro_solicitud->setSort("");
                $this->solicitante->setSort("");
                $this->difunto->setSort("");
                $this->ubicacion->setSort("");
                $this->ctto_usd->setSort("");
                $this->tipo_pago->setSort("");
                $this->banco->setSort("");
                $this->ref->setSort("");
                $this->fecha_cobro->setSort("");
                $this->resgitro_pago->setSort("");
                $this->cta_destino->setSort("");
                $this->monto_bs->setSort("");
                $this->monto_usd->setSort("");
                $this->monto_ue->setSort("");
                $this->subtipo->setSort("");
                $this->estatus->setSort("");
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
        if ($this->CurrentMode == "view") { // Check view mode
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_grama_pagoslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_grama_pagoslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "expediente");
            $this->createColumnOption($option, "registro_solicitud");
            $this->createColumnOption($option, "solicitante");
            $this->createColumnOption($option, "difunto");
            $this->createColumnOption($option, "ubicacion");
            $this->createColumnOption($option, "ctto_usd");
            $this->createColumnOption($option, "tipo_pago");
            $this->createColumnOption($option, "banco");
            $this->createColumnOption($option, "ref");
            $this->createColumnOption($option, "fecha_cobro");
            $this->createColumnOption($option, "resgitro_pago");
            $this->createColumnOption($option, "cta_destino");
            $this->createColumnOption($option, "monto_bs");
            $this->createColumnOption($option, "monto_usd");
            $this->createColumnOption($option, "monto_ue");
            $this->createColumnOption($option, "subtipo");
            $this->createColumnOption($option, "estatus");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_grama_pagossrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_grama_pagossrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fview_grama_pagoslist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_view_grama_pagos", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_view_grama_pagos",
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

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // Load query builder rules
        $rules = Post("rules");
        if ($rules && $this->Command == "") {
            $this->QueryRules = $rules;
            $this->Command = "search";
        }

        // expediente
        if ($this->expediente->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->expediente->AdvancedSearch->SearchValue != "" || $this->expediente->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // registro_solicitud
        if ($this->registro_solicitud->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->registro_solicitud->AdvancedSearch->SearchValue != "" || $this->registro_solicitud->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // solicitante
        if ($this->solicitante->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->solicitante->AdvancedSearch->SearchValue != "" || $this->solicitante->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // difunto
        if ($this->difunto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->difunto->AdvancedSearch->SearchValue != "" || $this->difunto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ubicacion
        if ($this->ubicacion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ubicacion->AdvancedSearch->SearchValue != "" || $this->ubicacion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ctto_usd
        if ($this->ctto_usd->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ctto_usd->AdvancedSearch->SearchValue != "" || $this->ctto_usd->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipo_pago
        if ($this->tipo_pago->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipo_pago->AdvancedSearch->SearchValue != "" || $this->tipo_pago->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // banco
        if ($this->banco->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->banco->AdvancedSearch->SearchValue != "" || $this->banco->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ref
        if ($this->ref->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ref->AdvancedSearch->SearchValue != "" || $this->ref->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_cobro
        if ($this->fecha_cobro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_cobro->AdvancedSearch->SearchValue != "" || $this->fecha_cobro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // resgitro_pago
        if ($this->resgitro_pago->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->resgitro_pago->AdvancedSearch->SearchValue != "" || $this->resgitro_pago->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cta_destino
        if ($this->cta_destino->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cta_destino->AdvancedSearch->SearchValue != "" || $this->cta_destino->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monto_bs
        if ($this->monto_bs->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monto_bs->AdvancedSearch->SearchValue != "" || $this->monto_bs->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monto_usd
        if ($this->monto_usd->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monto_usd->AdvancedSearch->SearchValue != "" || $this->monto_usd->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monto_ue
        if ($this->monto_ue->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monto_ue->AdvancedSearch->SearchValue != "" || $this->monto_ue->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // subtipo
        if ($this->subtipo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->subtipo->AdvancedSearch->SearchValue != "" || $this->subtipo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // estatus
        if ($this->estatus->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->estatus->AdvancedSearch->SearchValue != "" || $this->estatus->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
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
        $this->expediente->setDbValue($row['expediente']);
        $this->registro_solicitud->setDbValue($row['registro_solicitud']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->difunto->setDbValue($row['difunto']);
        $this->ubicacion->setDbValue($row['ubicacion']);
        $this->ctto_usd->setDbValue($row['ctto_usd']);
        $this->tipo_pago->setDbValue($row['tipo_pago']);
        $this->banco->setDbValue($row['banco']);
        $this->ref->setDbValue($row['ref']);
        $this->fecha_cobro->setDbValue($row['fecha_cobro']);
        $this->resgitro_pago->setDbValue($row['resgitro_pago']);
        $this->cta_destino->setDbValue($row['cta_destino']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->monto_usd->setDbValue($row['monto_usd']);
        $this->monto_ue->setDbValue($row['monto_ue']);
        $this->subtipo->setDbValue($row['subtipo']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['registro_solicitud'] = $this->registro_solicitud->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['difunto'] = $this->difunto->DefaultValue;
        $row['ubicacion'] = $this->ubicacion->DefaultValue;
        $row['ctto_usd'] = $this->ctto_usd->DefaultValue;
        $row['tipo_pago'] = $this->tipo_pago->DefaultValue;
        $row['banco'] = $this->banco->DefaultValue;
        $row['ref'] = $this->ref->DefaultValue;
        $row['fecha_cobro'] = $this->fecha_cobro->DefaultValue;
        $row['resgitro_pago'] = $this->resgitro_pago->DefaultValue;
        $row['cta_destino'] = $this->cta_destino->DefaultValue;
        $row['monto_bs'] = $this->monto_bs->DefaultValue;
        $row['monto_usd'] = $this->monto_usd->DefaultValue;
        $row['monto_ue'] = $this->monto_ue->DefaultValue;
        $row['subtipo'] = $this->subtipo->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
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

        // expediente

        // registro_solicitud

        // solicitante

        // difunto

        // ubicacion

        // ctto_usd

        // tipo_pago

        // banco

        // ref

        // fecha_cobro

        // resgitro_pago

        // cta_destino

        // monto_bs

        // monto_usd

        // monto_ue

        // subtipo

        // estatus

        // View row
        if ($this->RowType == RowType::VIEW) {
            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // registro_solicitud
            $this->registro_solicitud->ViewValue = $this->registro_solicitud->CurrentValue;
            $this->registro_solicitud->ViewValue = FormatDateTime($this->registro_solicitud->ViewValue, $this->registro_solicitud->formatPattern());

            // solicitante
            $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

            // difunto
            $this->difunto->ViewValue = $this->difunto->CurrentValue;

            // ubicacion
            $this->ubicacion->ViewValue = $this->ubicacion->CurrentValue;

            // ctto_usd
            $this->ctto_usd->ViewValue = $this->ctto_usd->CurrentValue;
            $this->ctto_usd->ViewValue = FormatNumber($this->ctto_usd->ViewValue, $this->ctto_usd->formatPattern());

            // tipo_pago
            $curVal = strval($this->tipo_pago->CurrentValue);
            if ($curVal != "") {
                $this->tipo_pago->ViewValue = $this->tipo_pago->lookupCacheOption($curVal);
                if ($this->tipo_pago->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_pago->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_pago->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo_pago->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo_pago->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_pago->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_pago->ViewValue = $this->tipo_pago->displayValue($arwrk);
                    } else {
                        $this->tipo_pago->ViewValue = $this->tipo_pago->CurrentValue;
                    }
                }
            } else {
                $this->tipo_pago->ViewValue = null;
            }

            // banco
            $this->banco->ViewValue = $this->banco->CurrentValue;

            // ref
            $this->ref->ViewValue = $this->ref->CurrentValue;

            // fecha_cobro
            $this->fecha_cobro->ViewValue = $this->fecha_cobro->CurrentValue;
            $this->fecha_cobro->ViewValue = FormatDateTime($this->fecha_cobro->ViewValue, $this->fecha_cobro->formatPattern());

            // resgitro_pago
            $this->resgitro_pago->ViewValue = $this->resgitro_pago->CurrentValue;
            $this->resgitro_pago->ViewValue = FormatDateTime($this->resgitro_pago->ViewValue, $this->resgitro_pago->formatPattern());

            // cta_destino
            $this->cta_destino->ViewValue = $this->cta_destino->CurrentValue;

            // monto_bs
            $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
            $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

            // monto_usd
            $this->monto_usd->ViewValue = $this->monto_usd->CurrentValue;
            $this->monto_usd->ViewValue = FormatNumber($this->monto_usd->ViewValue, $this->monto_usd->formatPattern());

            // monto_ue
            $this->monto_ue->ViewValue = $this->monto_ue->CurrentValue;
            $this->monto_ue->ViewValue = FormatNumber($this->monto_ue->ViewValue, $this->monto_ue->formatPattern());

            // subtipo
            $this->subtipo->ViewValue = $this->subtipo->CurrentValue;

            // estatus
            $this->estatus->ViewValue = $this->estatus->CurrentValue;

            // expediente
            $this->expediente->HrefValue = "";
            $this->expediente->TooltipValue = "";

            // registro_solicitud
            $this->registro_solicitud->HrefValue = "";
            $this->registro_solicitud->TooltipValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";
            $this->solicitante->TooltipValue = "";

            // difunto
            $this->difunto->HrefValue = "";
            $this->difunto->TooltipValue = "";

            // ubicacion
            $this->ubicacion->HrefValue = "";
            $this->ubicacion->TooltipValue = "";

            // ctto_usd
            $this->ctto_usd->HrefValue = "";
            $this->ctto_usd->TooltipValue = "";

            // tipo_pago
            $this->tipo_pago->HrefValue = "";
            $this->tipo_pago->TooltipValue = "";

            // banco
            $this->banco->HrefValue = "";
            $this->banco->TooltipValue = "";

            // ref
            $this->ref->HrefValue = "";
            $this->ref->TooltipValue = "";

            // fecha_cobro
            $this->fecha_cobro->HrefValue = "";
            $this->fecha_cobro->TooltipValue = "";

            // resgitro_pago
            $this->resgitro_pago->HrefValue = "";
            $this->resgitro_pago->TooltipValue = "";

            // cta_destino
            $this->cta_destino->HrefValue = "";
            $this->cta_destino->TooltipValue = "";

            // monto_bs
            $this->monto_bs->HrefValue = "";
            $this->monto_bs->TooltipValue = "";

            // monto_usd
            $this->monto_usd->HrefValue = "";
            $this->monto_usd->TooltipValue = "";

            // monto_ue
            $this->monto_ue->HrefValue = "";
            $this->monto_ue->TooltipValue = "";

            // subtipo
            $this->subtipo->HrefValue = "";
            $this->subtipo->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // expediente
            $this->expediente->setupEditAttributes();
            $this->expediente->EditValue = $this->expediente->AdvancedSearch->SearchValue;
            $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());

            // registro_solicitud
            $this->registro_solicitud->setupEditAttributes();
            $this->registro_solicitud->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->registro_solicitud->AdvancedSearch->SearchValue, $this->registro_solicitud->formatPattern()), $this->registro_solicitud->formatPattern()));
            $this->registro_solicitud->PlaceHolder = RemoveHtml($this->registro_solicitud->caption());
            $this->registro_solicitud->setupEditAttributes();
            $this->registro_solicitud->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->registro_solicitud->AdvancedSearch->SearchValue2, $this->registro_solicitud->formatPattern()), $this->registro_solicitud->formatPattern()));
            $this->registro_solicitud->PlaceHolder = RemoveHtml($this->registro_solicitud->caption());

            // solicitante
            $this->solicitante->setupEditAttributes();
            if (!$this->solicitante->Raw) {
                $this->solicitante->AdvancedSearch->SearchValue = HtmlDecode($this->solicitante->AdvancedSearch->SearchValue);
            }
            $this->solicitante->EditValue = HtmlEncode($this->solicitante->AdvancedSearch->SearchValue);
            $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

            // difunto
            $this->difunto->setupEditAttributes();
            if (!$this->difunto->Raw) {
                $this->difunto->AdvancedSearch->SearchValue = HtmlDecode($this->difunto->AdvancedSearch->SearchValue);
            }
            $this->difunto->EditValue = HtmlEncode($this->difunto->AdvancedSearch->SearchValue);
            $this->difunto->PlaceHolder = RemoveHtml($this->difunto->caption());

            // ubicacion
            $this->ubicacion->setupEditAttributes();
            if (!$this->ubicacion->Raw) {
                $this->ubicacion->AdvancedSearch->SearchValue = HtmlDecode($this->ubicacion->AdvancedSearch->SearchValue);
            }
            $this->ubicacion->EditValue = HtmlEncode($this->ubicacion->AdvancedSearch->SearchValue);
            $this->ubicacion->PlaceHolder = RemoveHtml($this->ubicacion->caption());

            // ctto_usd
            $this->ctto_usd->setupEditAttributes();
            $this->ctto_usd->EditValue = $this->ctto_usd->AdvancedSearch->SearchValue;
            $this->ctto_usd->PlaceHolder = RemoveHtml($this->ctto_usd->caption());

            // tipo_pago
            $this->tipo_pago->setupEditAttributes();
            $curVal = trim(strval($this->tipo_pago->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->tipo_pago->AdvancedSearch->ViewValue = $this->tipo_pago->lookupCacheOption($curVal);
            } else {
                $this->tipo_pago->AdvancedSearch->ViewValue = $this->tipo_pago->Lookup !== null && is_array($this->tipo_pago->lookupOptions()) && count($this->tipo_pago->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_pago->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->tipo_pago->EditValue = array_values($this->tipo_pago->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_pago->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->tipo_pago->AdvancedSearch->SearchValue, $this->tipo_pago->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->tipo_pago->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_pago->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_pago->EditValue = $arwrk;
            }
            $this->tipo_pago->PlaceHolder = RemoveHtml($this->tipo_pago->caption());

            // banco
            $this->banco->setupEditAttributes();
            if (!$this->banco->Raw) {
                $this->banco->AdvancedSearch->SearchValue = HtmlDecode($this->banco->AdvancedSearch->SearchValue);
            }
            $this->banco->EditValue = HtmlEncode($this->banco->AdvancedSearch->SearchValue);
            $this->banco->PlaceHolder = RemoveHtml($this->banco->caption());

            // ref
            $this->ref->setupEditAttributes();
            if (!$this->ref->Raw) {
                $this->ref->AdvancedSearch->SearchValue = HtmlDecode($this->ref->AdvancedSearch->SearchValue);
            }
            $this->ref->EditValue = HtmlEncode($this->ref->AdvancedSearch->SearchValue);
            $this->ref->PlaceHolder = RemoveHtml($this->ref->caption());

            // fecha_cobro
            $this->fecha_cobro->setupEditAttributes();
            $this->fecha_cobro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_cobro->AdvancedSearch->SearchValue, $this->fecha_cobro->formatPattern()), $this->fecha_cobro->formatPattern()));
            $this->fecha_cobro->PlaceHolder = RemoveHtml($this->fecha_cobro->caption());
            $this->fecha_cobro->setupEditAttributes();
            $this->fecha_cobro->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_cobro->AdvancedSearch->SearchValue2, $this->fecha_cobro->formatPattern()), $this->fecha_cobro->formatPattern()));
            $this->fecha_cobro->PlaceHolder = RemoveHtml($this->fecha_cobro->caption());

            // resgitro_pago
            $this->resgitro_pago->setupEditAttributes();
            $this->resgitro_pago->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->resgitro_pago->AdvancedSearch->SearchValue, $this->resgitro_pago->formatPattern()), $this->resgitro_pago->formatPattern()));
            $this->resgitro_pago->PlaceHolder = RemoveHtml($this->resgitro_pago->caption());
            $this->resgitro_pago->setupEditAttributes();
            $this->resgitro_pago->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->resgitro_pago->AdvancedSearch->SearchValue2, $this->resgitro_pago->formatPattern()), $this->resgitro_pago->formatPattern()));
            $this->resgitro_pago->PlaceHolder = RemoveHtml($this->resgitro_pago->caption());

            // cta_destino
            $this->cta_destino->setupEditAttributes();
            if (!$this->cta_destino->Raw) {
                $this->cta_destino->AdvancedSearch->SearchValue = HtmlDecode($this->cta_destino->AdvancedSearch->SearchValue);
            }
            $this->cta_destino->EditValue = HtmlEncode($this->cta_destino->AdvancedSearch->SearchValue);
            $this->cta_destino->PlaceHolder = RemoveHtml($this->cta_destino->caption());

            // monto_bs
            $this->monto_bs->setupEditAttributes();
            $this->monto_bs->EditValue = $this->monto_bs->AdvancedSearch->SearchValue;
            $this->monto_bs->PlaceHolder = RemoveHtml($this->monto_bs->caption());

            // monto_usd
            $this->monto_usd->setupEditAttributes();
            $this->monto_usd->EditValue = $this->monto_usd->AdvancedSearch->SearchValue;
            $this->monto_usd->PlaceHolder = RemoveHtml($this->monto_usd->caption());

            // monto_ue
            $this->monto_ue->setupEditAttributes();
            $this->monto_ue->EditValue = $this->monto_ue->AdvancedSearch->SearchValue;
            $this->monto_ue->PlaceHolder = RemoveHtml($this->monto_ue->caption());

            // subtipo
            $this->subtipo->setupEditAttributes();
            if (!$this->subtipo->Raw) {
                $this->subtipo->AdvancedSearch->SearchValue = HtmlDecode($this->subtipo->AdvancedSearch->SearchValue);
            }
            $this->subtipo->EditValue = HtmlEncode($this->subtipo->AdvancedSearch->SearchValue);
            $this->subtipo->PlaceHolder = RemoveHtml($this->subtipo->caption());

            // estatus
            $this->estatus->setupEditAttributes();
            if (!$this->estatus->Raw) {
                $this->estatus->AdvancedSearch->SearchValue = HtmlDecode($this->estatus->AdvancedSearch->SearchValue);
            }
            $this->estatus->EditValue = HtmlEncode($this->estatus->AdvancedSearch->SearchValue);
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckDate($this->registro_solicitud->AdvancedSearch->SearchValue, $this->registro_solicitud->formatPattern())) {
            $this->registro_solicitud->addErrorMessage($this->registro_solicitud->getErrorMessage(false));
        }
        if (!CheckDate($this->registro_solicitud->AdvancedSearch->SearchValue2, $this->registro_solicitud->formatPattern())) {
            $this->registro_solicitud->addErrorMessage($this->registro_solicitud->getErrorMessage(false));
        }
        if (!CheckDate($this->fecha_cobro->AdvancedSearch->SearchValue, $this->fecha_cobro->formatPattern())) {
            $this->fecha_cobro->addErrorMessage($this->fecha_cobro->getErrorMessage(false));
        }
        if (!CheckDate($this->fecha_cobro->AdvancedSearch->SearchValue2, $this->fecha_cobro->formatPattern())) {
            $this->fecha_cobro->addErrorMessage($this->fecha_cobro->getErrorMessage(false));
        }
        if (!CheckDate($this->resgitro_pago->AdvancedSearch->SearchValue, $this->resgitro_pago->formatPattern())) {
            $this->resgitro_pago->addErrorMessage($this->resgitro_pago->getErrorMessage(false));
        }
        if (!CheckDate($this->resgitro_pago->AdvancedSearch->SearchValue2, $this->resgitro_pago->formatPattern())) {
            $this->resgitro_pago->addErrorMessage($this->resgitro_pago->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->expediente->AdvancedSearch->load();
        $this->registro_solicitud->AdvancedSearch->load();
        $this->solicitante->AdvancedSearch->load();
        $this->difunto->AdvancedSearch->load();
        $this->ubicacion->AdvancedSearch->load();
        $this->ctto_usd->AdvancedSearch->load();
        $this->tipo_pago->AdvancedSearch->load();
        $this->banco->AdvancedSearch->load();
        $this->ref->AdvancedSearch->load();
        $this->fecha_cobro->AdvancedSearch->load();
        $this->resgitro_pago->AdvancedSearch->load();
        $this->cta_destino->AdvancedSearch->load();
        $this->monto_bs->AdvancedSearch->load();
        $this->monto_usd->AdvancedSearch->load();
        $this->monto_ue->AdvancedSearch->load();
        $this->subtipo->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        if ($type == "print" || $custom) { // Printer friendly / custom export
            $pageUrl = $this->pageUrl(false);
            $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        } else { // Export API URL
            $exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        }
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fview_grama_pagoslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fview_grama_pagoslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fview_grama_pagoslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fview_grama_pagoslist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = false;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fview_grama_pagossrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($doc)
    {
        global $Language;
        $rs = null;
        $this->TotalRecords = $this->listRecordCount();

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $doc->ExportCustom = !$this->pageExporting($doc);

        // Page header
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $rs->free();

        // Page footer
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Call Page Exported server event
        $this->pageExported($doc);
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
                case "x_tipo_pago":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
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
