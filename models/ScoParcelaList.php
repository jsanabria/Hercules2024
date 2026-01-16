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
class ScoParcelaList extends ScoParcela
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoParcelaList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_parcelalist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoParcelaList";

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

    // Audit Trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

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
        $this->Nparcela->setVisibility();
        $this->nacionalidad->setVisibility();
        $this->cedula->setVisibility();
        $this->titular->setVisibility();
        $this->contrato->setVisibility();
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->setVisibility();
        $this->apellido1->setVisibility();
        $this->apellido2->setVisibility();
        $this->nombre1->setVisibility();
        $this->nombre2->setVisibility();
        $this->fecha_inhumacion->setVisibility();
        $this->telefono1->Visible = false;
        $this->telefono2->Visible = false;
        $this->telefono3->Visible = false;
        $this->direc1->Visible = false;
        $this->direc2->Visible = false;
        $this->_email->Visible = false;
        $this->nac_ci_asociado->Visible = false;
        $this->ci_asociado->Visible = false;
        $this->nombre_asociado->Visible = false;
        $this->nac_difunto->Visible = false;
        $this->ci_difunto->Visible = false;
        $this->edad->Visible = false;
        $this->edo_civil->Visible = false;
        $this->fecha_nacimiento->Visible = false;
        $this->lugar->Visible = false;
        $this->fecha_defuncion->Visible = false;
        $this->causa->Visible = false;
        $this->certificado->Visible = false;
        $this->funeraria->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_parcela';
        $this->TableName = 'sco_parcela';

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

        // Table object (sco_parcela)
        if (!isset($GLOBALS["sco_parcela"]) || $GLOBALS["sco_parcela"]::class == PROJECT_NAMESPACE . "sco_parcela") {
            $GLOBALS["sco_parcela"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoParcelaAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoParcelaDelete";
        $this->MultiUpdateUrl = "ScoParcelaUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_parcela');
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
                    $result["view"] = SameString($pageName, "ScoParcelaView"); // If View page, no primary button
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
            $key .= @$ar['Nparcela'];
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_parcelagrid";
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

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($this->Filter, $this->DbDetailFilter);
        AddFilter($this->Filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "sco_expediente") {
            $masterTbl = Container("sco_expediente");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("ScoExpedienteList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = RowType::MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

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

            // Audit trail on search
            if ($this->AuditTrailOnSearch && $this->Command == "search" && !$this->RestoreSearch) {
                $searchParm = ServerVar("QUERY_STRING");
                $searchSql = $this->getSessionWhere();
                $this->writeAuditTrailOnSearch($searchParm, $searchSql);
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
        $filterList = Concat($filterList, $this->Nparcela->AdvancedSearch->toJson(), ","); // Field Nparcela
        $filterList = Concat($filterList, $this->nacionalidad->AdvancedSearch->toJson(), ","); // Field nacionalidad
        $filterList = Concat($filterList, $this->cedula->AdvancedSearch->toJson(), ","); // Field cedula
        $filterList = Concat($filterList, $this->titular->AdvancedSearch->toJson(), ","); // Field titular
        $filterList = Concat($filterList, $this->contrato->AdvancedSearch->toJson(), ","); // Field contrato
        $filterList = Concat($filterList, $this->seccion->AdvancedSearch->toJson(), ","); // Field seccion
        $filterList = Concat($filterList, $this->modulo->AdvancedSearch->toJson(), ","); // Field modulo
        $filterList = Concat($filterList, $this->sub_seccion->AdvancedSearch->toJson(), ","); // Field sub_seccion
        $filterList = Concat($filterList, $this->parcela->AdvancedSearch->toJson(), ","); // Field parcela
        $filterList = Concat($filterList, $this->boveda->AdvancedSearch->toJson(), ","); // Field boveda
        $filterList = Concat($filterList, $this->apellido1->AdvancedSearch->toJson(), ","); // Field apellido1
        $filterList = Concat($filterList, $this->apellido2->AdvancedSearch->toJson(), ","); // Field apellido2
        $filterList = Concat($filterList, $this->nombre1->AdvancedSearch->toJson(), ","); // Field nombre1
        $filterList = Concat($filterList, $this->nombre2->AdvancedSearch->toJson(), ","); // Field nombre2
        $filterList = Concat($filterList, $this->fecha_inhumacion->AdvancedSearch->toJson(), ","); // Field fecha_inhumacion
        $filterList = Concat($filterList, $this->telefono1->AdvancedSearch->toJson(), ","); // Field telefono1
        $filterList = Concat($filterList, $this->telefono2->AdvancedSearch->toJson(), ","); // Field telefono2
        $filterList = Concat($filterList, $this->telefono3->AdvancedSearch->toJson(), ","); // Field telefono3
        $filterList = Concat($filterList, $this->direc1->AdvancedSearch->toJson(), ","); // Field direc1
        $filterList = Concat($filterList, $this->direc2->AdvancedSearch->toJson(), ","); // Field direc2
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->nac_ci_asociado->AdvancedSearch->toJson(), ","); // Field nac_ci_asociado
        $filterList = Concat($filterList, $this->ci_asociado->AdvancedSearch->toJson(), ","); // Field ci_asociado
        $filterList = Concat($filterList, $this->nombre_asociado->AdvancedSearch->toJson(), ","); // Field nombre_asociado
        $filterList = Concat($filterList, $this->nac_difunto->AdvancedSearch->toJson(), ","); // Field nac_difunto
        $filterList = Concat($filterList, $this->ci_difunto->AdvancedSearch->toJson(), ","); // Field ci_difunto
        $filterList = Concat($filterList, $this->edad->AdvancedSearch->toJson(), ","); // Field edad
        $filterList = Concat($filterList, $this->edo_civil->AdvancedSearch->toJson(), ","); // Field edo_civil
        $filterList = Concat($filterList, $this->fecha_nacimiento->AdvancedSearch->toJson(), ","); // Field fecha_nacimiento
        $filterList = Concat($filterList, $this->lugar->AdvancedSearch->toJson(), ","); // Field lugar
        $filterList = Concat($filterList, $this->fecha_defuncion->AdvancedSearch->toJson(), ","); // Field fecha_defuncion
        $filterList = Concat($filterList, $this->causa->AdvancedSearch->toJson(), ","); // Field causa
        $filterList = Concat($filterList, $this->certificado->AdvancedSearch->toJson(), ","); // Field certificado
        $filterList = Concat($filterList, $this->funeraria->AdvancedSearch->toJson(), ","); // Field funeraria
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
            Profile()->setSearchFilters("fsco_parcelasrch", $filters);
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

        // Field Nparcela
        $this->Nparcela->AdvancedSearch->SearchValue = @$filter["x_Nparcela"];
        $this->Nparcela->AdvancedSearch->SearchOperator = @$filter["z_Nparcela"];
        $this->Nparcela->AdvancedSearch->SearchCondition = @$filter["v_Nparcela"];
        $this->Nparcela->AdvancedSearch->SearchValue2 = @$filter["y_Nparcela"];
        $this->Nparcela->AdvancedSearch->SearchOperator2 = @$filter["w_Nparcela"];
        $this->Nparcela->AdvancedSearch->save();

        // Field nacionalidad
        $this->nacionalidad->AdvancedSearch->SearchValue = @$filter["x_nacionalidad"];
        $this->nacionalidad->AdvancedSearch->SearchOperator = @$filter["z_nacionalidad"];
        $this->nacionalidad->AdvancedSearch->SearchCondition = @$filter["v_nacionalidad"];
        $this->nacionalidad->AdvancedSearch->SearchValue2 = @$filter["y_nacionalidad"];
        $this->nacionalidad->AdvancedSearch->SearchOperator2 = @$filter["w_nacionalidad"];
        $this->nacionalidad->AdvancedSearch->save();

        // Field cedula
        $this->cedula->AdvancedSearch->SearchValue = @$filter["x_cedula"];
        $this->cedula->AdvancedSearch->SearchOperator = @$filter["z_cedula"];
        $this->cedula->AdvancedSearch->SearchCondition = @$filter["v_cedula"];
        $this->cedula->AdvancedSearch->SearchValue2 = @$filter["y_cedula"];
        $this->cedula->AdvancedSearch->SearchOperator2 = @$filter["w_cedula"];
        $this->cedula->AdvancedSearch->save();

        // Field titular
        $this->titular->AdvancedSearch->SearchValue = @$filter["x_titular"];
        $this->titular->AdvancedSearch->SearchOperator = @$filter["z_titular"];
        $this->titular->AdvancedSearch->SearchCondition = @$filter["v_titular"];
        $this->titular->AdvancedSearch->SearchValue2 = @$filter["y_titular"];
        $this->titular->AdvancedSearch->SearchOperator2 = @$filter["w_titular"];
        $this->titular->AdvancedSearch->save();

        // Field contrato
        $this->contrato->AdvancedSearch->SearchValue = @$filter["x_contrato"];
        $this->contrato->AdvancedSearch->SearchOperator = @$filter["z_contrato"];
        $this->contrato->AdvancedSearch->SearchCondition = @$filter["v_contrato"];
        $this->contrato->AdvancedSearch->SearchValue2 = @$filter["y_contrato"];
        $this->contrato->AdvancedSearch->SearchOperator2 = @$filter["w_contrato"];
        $this->contrato->AdvancedSearch->save();

        // Field seccion
        $this->seccion->AdvancedSearch->SearchValue = @$filter["x_seccion"];
        $this->seccion->AdvancedSearch->SearchOperator = @$filter["z_seccion"];
        $this->seccion->AdvancedSearch->SearchCondition = @$filter["v_seccion"];
        $this->seccion->AdvancedSearch->SearchValue2 = @$filter["y_seccion"];
        $this->seccion->AdvancedSearch->SearchOperator2 = @$filter["w_seccion"];
        $this->seccion->AdvancedSearch->save();

        // Field modulo
        $this->modulo->AdvancedSearch->SearchValue = @$filter["x_modulo"];
        $this->modulo->AdvancedSearch->SearchOperator = @$filter["z_modulo"];
        $this->modulo->AdvancedSearch->SearchCondition = @$filter["v_modulo"];
        $this->modulo->AdvancedSearch->SearchValue2 = @$filter["y_modulo"];
        $this->modulo->AdvancedSearch->SearchOperator2 = @$filter["w_modulo"];
        $this->modulo->AdvancedSearch->save();

        // Field sub_seccion
        $this->sub_seccion->AdvancedSearch->SearchValue = @$filter["x_sub_seccion"];
        $this->sub_seccion->AdvancedSearch->SearchOperator = @$filter["z_sub_seccion"];
        $this->sub_seccion->AdvancedSearch->SearchCondition = @$filter["v_sub_seccion"];
        $this->sub_seccion->AdvancedSearch->SearchValue2 = @$filter["y_sub_seccion"];
        $this->sub_seccion->AdvancedSearch->SearchOperator2 = @$filter["w_sub_seccion"];
        $this->sub_seccion->AdvancedSearch->save();

        // Field parcela
        $this->parcela->AdvancedSearch->SearchValue = @$filter["x_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator = @$filter["z_parcela"];
        $this->parcela->AdvancedSearch->SearchCondition = @$filter["v_parcela"];
        $this->parcela->AdvancedSearch->SearchValue2 = @$filter["y_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator2 = @$filter["w_parcela"];
        $this->parcela->AdvancedSearch->save();

        // Field boveda
        $this->boveda->AdvancedSearch->SearchValue = @$filter["x_boveda"];
        $this->boveda->AdvancedSearch->SearchOperator = @$filter["z_boveda"];
        $this->boveda->AdvancedSearch->SearchCondition = @$filter["v_boveda"];
        $this->boveda->AdvancedSearch->SearchValue2 = @$filter["y_boveda"];
        $this->boveda->AdvancedSearch->SearchOperator2 = @$filter["w_boveda"];
        $this->boveda->AdvancedSearch->save();

        // Field apellido1
        $this->apellido1->AdvancedSearch->SearchValue = @$filter["x_apellido1"];
        $this->apellido1->AdvancedSearch->SearchOperator = @$filter["z_apellido1"];
        $this->apellido1->AdvancedSearch->SearchCondition = @$filter["v_apellido1"];
        $this->apellido1->AdvancedSearch->SearchValue2 = @$filter["y_apellido1"];
        $this->apellido1->AdvancedSearch->SearchOperator2 = @$filter["w_apellido1"];
        $this->apellido1->AdvancedSearch->save();

        // Field apellido2
        $this->apellido2->AdvancedSearch->SearchValue = @$filter["x_apellido2"];
        $this->apellido2->AdvancedSearch->SearchOperator = @$filter["z_apellido2"];
        $this->apellido2->AdvancedSearch->SearchCondition = @$filter["v_apellido2"];
        $this->apellido2->AdvancedSearch->SearchValue2 = @$filter["y_apellido2"];
        $this->apellido2->AdvancedSearch->SearchOperator2 = @$filter["w_apellido2"];
        $this->apellido2->AdvancedSearch->save();

        // Field nombre1
        $this->nombre1->AdvancedSearch->SearchValue = @$filter["x_nombre1"];
        $this->nombre1->AdvancedSearch->SearchOperator = @$filter["z_nombre1"];
        $this->nombre1->AdvancedSearch->SearchCondition = @$filter["v_nombre1"];
        $this->nombre1->AdvancedSearch->SearchValue2 = @$filter["y_nombre1"];
        $this->nombre1->AdvancedSearch->SearchOperator2 = @$filter["w_nombre1"];
        $this->nombre1->AdvancedSearch->save();

        // Field nombre2
        $this->nombre2->AdvancedSearch->SearchValue = @$filter["x_nombre2"];
        $this->nombre2->AdvancedSearch->SearchOperator = @$filter["z_nombre2"];
        $this->nombre2->AdvancedSearch->SearchCondition = @$filter["v_nombre2"];
        $this->nombre2->AdvancedSearch->SearchValue2 = @$filter["y_nombre2"];
        $this->nombre2->AdvancedSearch->SearchOperator2 = @$filter["w_nombre2"];
        $this->nombre2->AdvancedSearch->save();

        // Field fecha_inhumacion
        $this->fecha_inhumacion->AdvancedSearch->SearchValue = @$filter["x_fecha_inhumacion"];
        $this->fecha_inhumacion->AdvancedSearch->SearchOperator = @$filter["z_fecha_inhumacion"];
        $this->fecha_inhumacion->AdvancedSearch->SearchCondition = @$filter["v_fecha_inhumacion"];
        $this->fecha_inhumacion->AdvancedSearch->SearchValue2 = @$filter["y_fecha_inhumacion"];
        $this->fecha_inhumacion->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_inhumacion"];
        $this->fecha_inhumacion->AdvancedSearch->save();

        // Field telefono1
        $this->telefono1->AdvancedSearch->SearchValue = @$filter["x_telefono1"];
        $this->telefono1->AdvancedSearch->SearchOperator = @$filter["z_telefono1"];
        $this->telefono1->AdvancedSearch->SearchCondition = @$filter["v_telefono1"];
        $this->telefono1->AdvancedSearch->SearchValue2 = @$filter["y_telefono1"];
        $this->telefono1->AdvancedSearch->SearchOperator2 = @$filter["w_telefono1"];
        $this->telefono1->AdvancedSearch->save();

        // Field telefono2
        $this->telefono2->AdvancedSearch->SearchValue = @$filter["x_telefono2"];
        $this->telefono2->AdvancedSearch->SearchOperator = @$filter["z_telefono2"];
        $this->telefono2->AdvancedSearch->SearchCondition = @$filter["v_telefono2"];
        $this->telefono2->AdvancedSearch->SearchValue2 = @$filter["y_telefono2"];
        $this->telefono2->AdvancedSearch->SearchOperator2 = @$filter["w_telefono2"];
        $this->telefono2->AdvancedSearch->save();

        // Field telefono3
        $this->telefono3->AdvancedSearch->SearchValue = @$filter["x_telefono3"];
        $this->telefono3->AdvancedSearch->SearchOperator = @$filter["z_telefono3"];
        $this->telefono3->AdvancedSearch->SearchCondition = @$filter["v_telefono3"];
        $this->telefono3->AdvancedSearch->SearchValue2 = @$filter["y_telefono3"];
        $this->telefono3->AdvancedSearch->SearchOperator2 = @$filter["w_telefono3"];
        $this->telefono3->AdvancedSearch->save();

        // Field direc1
        $this->direc1->AdvancedSearch->SearchValue = @$filter["x_direc1"];
        $this->direc1->AdvancedSearch->SearchOperator = @$filter["z_direc1"];
        $this->direc1->AdvancedSearch->SearchCondition = @$filter["v_direc1"];
        $this->direc1->AdvancedSearch->SearchValue2 = @$filter["y_direc1"];
        $this->direc1->AdvancedSearch->SearchOperator2 = @$filter["w_direc1"];
        $this->direc1->AdvancedSearch->save();

        // Field direc2
        $this->direc2->AdvancedSearch->SearchValue = @$filter["x_direc2"];
        $this->direc2->AdvancedSearch->SearchOperator = @$filter["z_direc2"];
        $this->direc2->AdvancedSearch->SearchCondition = @$filter["v_direc2"];
        $this->direc2->AdvancedSearch->SearchValue2 = @$filter["y_direc2"];
        $this->direc2->AdvancedSearch->SearchOperator2 = @$filter["w_direc2"];
        $this->direc2->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field nac_ci_asociado
        $this->nac_ci_asociado->AdvancedSearch->SearchValue = @$filter["x_nac_ci_asociado"];
        $this->nac_ci_asociado->AdvancedSearch->SearchOperator = @$filter["z_nac_ci_asociado"];
        $this->nac_ci_asociado->AdvancedSearch->SearchCondition = @$filter["v_nac_ci_asociado"];
        $this->nac_ci_asociado->AdvancedSearch->SearchValue2 = @$filter["y_nac_ci_asociado"];
        $this->nac_ci_asociado->AdvancedSearch->SearchOperator2 = @$filter["w_nac_ci_asociado"];
        $this->nac_ci_asociado->AdvancedSearch->save();

        // Field ci_asociado
        $this->ci_asociado->AdvancedSearch->SearchValue = @$filter["x_ci_asociado"];
        $this->ci_asociado->AdvancedSearch->SearchOperator = @$filter["z_ci_asociado"];
        $this->ci_asociado->AdvancedSearch->SearchCondition = @$filter["v_ci_asociado"];
        $this->ci_asociado->AdvancedSearch->SearchValue2 = @$filter["y_ci_asociado"];
        $this->ci_asociado->AdvancedSearch->SearchOperator2 = @$filter["w_ci_asociado"];
        $this->ci_asociado->AdvancedSearch->save();

        // Field nombre_asociado
        $this->nombre_asociado->AdvancedSearch->SearchValue = @$filter["x_nombre_asociado"];
        $this->nombre_asociado->AdvancedSearch->SearchOperator = @$filter["z_nombre_asociado"];
        $this->nombre_asociado->AdvancedSearch->SearchCondition = @$filter["v_nombre_asociado"];
        $this->nombre_asociado->AdvancedSearch->SearchValue2 = @$filter["y_nombre_asociado"];
        $this->nombre_asociado->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_asociado"];
        $this->nombre_asociado->AdvancedSearch->save();

        // Field nac_difunto
        $this->nac_difunto->AdvancedSearch->SearchValue = @$filter["x_nac_difunto"];
        $this->nac_difunto->AdvancedSearch->SearchOperator = @$filter["z_nac_difunto"];
        $this->nac_difunto->AdvancedSearch->SearchCondition = @$filter["v_nac_difunto"];
        $this->nac_difunto->AdvancedSearch->SearchValue2 = @$filter["y_nac_difunto"];
        $this->nac_difunto->AdvancedSearch->SearchOperator2 = @$filter["w_nac_difunto"];
        $this->nac_difunto->AdvancedSearch->save();

        // Field ci_difunto
        $this->ci_difunto->AdvancedSearch->SearchValue = @$filter["x_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchOperator = @$filter["z_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchCondition = @$filter["v_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchValue2 = @$filter["y_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchOperator2 = @$filter["w_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->save();

        // Field edad
        $this->edad->AdvancedSearch->SearchValue = @$filter["x_edad"];
        $this->edad->AdvancedSearch->SearchOperator = @$filter["z_edad"];
        $this->edad->AdvancedSearch->SearchCondition = @$filter["v_edad"];
        $this->edad->AdvancedSearch->SearchValue2 = @$filter["y_edad"];
        $this->edad->AdvancedSearch->SearchOperator2 = @$filter["w_edad"];
        $this->edad->AdvancedSearch->save();

        // Field edo_civil
        $this->edo_civil->AdvancedSearch->SearchValue = @$filter["x_edo_civil"];
        $this->edo_civil->AdvancedSearch->SearchOperator = @$filter["z_edo_civil"];
        $this->edo_civil->AdvancedSearch->SearchCondition = @$filter["v_edo_civil"];
        $this->edo_civil->AdvancedSearch->SearchValue2 = @$filter["y_edo_civil"];
        $this->edo_civil->AdvancedSearch->SearchOperator2 = @$filter["w_edo_civil"];
        $this->edo_civil->AdvancedSearch->save();

        // Field fecha_nacimiento
        $this->fecha_nacimiento->AdvancedSearch->SearchValue = @$filter["x_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchOperator = @$filter["z_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchCondition = @$filter["v_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchValue2 = @$filter["y_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_nacimiento"];
        $this->fecha_nacimiento->AdvancedSearch->save();

        // Field lugar
        $this->lugar->AdvancedSearch->SearchValue = @$filter["x_lugar"];
        $this->lugar->AdvancedSearch->SearchOperator = @$filter["z_lugar"];
        $this->lugar->AdvancedSearch->SearchCondition = @$filter["v_lugar"];
        $this->lugar->AdvancedSearch->SearchValue2 = @$filter["y_lugar"];
        $this->lugar->AdvancedSearch->SearchOperator2 = @$filter["w_lugar"];
        $this->lugar->AdvancedSearch->save();

        // Field fecha_defuncion
        $this->fecha_defuncion->AdvancedSearch->SearchValue = @$filter["x_fecha_defuncion"];
        $this->fecha_defuncion->AdvancedSearch->SearchOperator = @$filter["z_fecha_defuncion"];
        $this->fecha_defuncion->AdvancedSearch->SearchCondition = @$filter["v_fecha_defuncion"];
        $this->fecha_defuncion->AdvancedSearch->SearchValue2 = @$filter["y_fecha_defuncion"];
        $this->fecha_defuncion->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_defuncion"];
        $this->fecha_defuncion->AdvancedSearch->save();

        // Field causa
        $this->causa->AdvancedSearch->SearchValue = @$filter["x_causa"];
        $this->causa->AdvancedSearch->SearchOperator = @$filter["z_causa"];
        $this->causa->AdvancedSearch->SearchCondition = @$filter["v_causa"];
        $this->causa->AdvancedSearch->SearchValue2 = @$filter["y_causa"];
        $this->causa->AdvancedSearch->SearchOperator2 = @$filter["w_causa"];
        $this->causa->AdvancedSearch->save();

        // Field certificado
        $this->certificado->AdvancedSearch->SearchValue = @$filter["x_certificado"];
        $this->certificado->AdvancedSearch->SearchOperator = @$filter["z_certificado"];
        $this->certificado->AdvancedSearch->SearchCondition = @$filter["v_certificado"];
        $this->certificado->AdvancedSearch->SearchValue2 = @$filter["y_certificado"];
        $this->certificado->AdvancedSearch->SearchOperator2 = @$filter["w_certificado"];
        $this->certificado->AdvancedSearch->save();

        // Field funeraria
        $this->funeraria->AdvancedSearch->SearchValue = @$filter["x_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator = @$filter["z_funeraria"];
        $this->funeraria->AdvancedSearch->SearchCondition = @$filter["v_funeraria"];
        $this->funeraria->AdvancedSearch->SearchValue2 = @$filter["y_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator2 = @$filter["w_funeraria"];
        $this->funeraria->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->Nparcela, $default, false); // Nparcela
        $this->buildSearchSql($where, $this->nacionalidad, $default, false); // nacionalidad
        $this->buildSearchSql($where, $this->cedula, $default, false); // cedula
        $this->buildSearchSql($where, $this->titular, $default, false); // titular
        $this->buildSearchSql($where, $this->contrato, $default, false); // contrato
        $this->buildSearchSql($where, $this->seccion, $default, false); // seccion
        $this->buildSearchSql($where, $this->modulo, $default, false); // modulo
        $this->buildSearchSql($where, $this->sub_seccion, $default, false); // sub_seccion
        $this->buildSearchSql($where, $this->parcela, $default, false); // parcela
        $this->buildSearchSql($where, $this->boveda, $default, false); // boveda
        $this->buildSearchSql($where, $this->apellido1, $default, false); // apellido1
        $this->buildSearchSql($where, $this->apellido2, $default, false); // apellido2
        $this->buildSearchSql($where, $this->nombre1, $default, false); // nombre1
        $this->buildSearchSql($where, $this->nombre2, $default, false); // nombre2
        $this->buildSearchSql($where, $this->fecha_inhumacion, $default, false); // fecha_inhumacion
        $this->buildSearchSql($where, $this->telefono1, $default, false); // telefono1
        $this->buildSearchSql($where, $this->telefono2, $default, false); // telefono2
        $this->buildSearchSql($where, $this->telefono3, $default, false); // telefono3
        $this->buildSearchSql($where, $this->direc1, $default, false); // direc1
        $this->buildSearchSql($where, $this->direc2, $default, false); // direc2
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->nac_ci_asociado, $default, false); // nac_ci_asociado
        $this->buildSearchSql($where, $this->ci_asociado, $default, false); // ci_asociado
        $this->buildSearchSql($where, $this->nombre_asociado, $default, false); // nombre_asociado
        $this->buildSearchSql($where, $this->nac_difunto, $default, false); // nac_difunto
        $this->buildSearchSql($where, $this->ci_difunto, $default, false); // ci_difunto
        $this->buildSearchSql($where, $this->edad, $default, false); // edad
        $this->buildSearchSql($where, $this->edo_civil, $default, false); // edo_civil
        $this->buildSearchSql($where, $this->fecha_nacimiento, $default, false); // fecha_nacimiento
        $this->buildSearchSql($where, $this->lugar, $default, false); // lugar
        $this->buildSearchSql($where, $this->fecha_defuncion, $default, false); // fecha_defuncion
        $this->buildSearchSql($where, $this->causa, $default, false); // causa
        $this->buildSearchSql($where, $this->certificado, $default, false); // certificado
        $this->buildSearchSql($where, $this->funeraria, $default, false); // funeraria

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Nparcela->AdvancedSearch->save(); // Nparcela
            $this->nacionalidad->AdvancedSearch->save(); // nacionalidad
            $this->cedula->AdvancedSearch->save(); // cedula
            $this->titular->AdvancedSearch->save(); // titular
            $this->contrato->AdvancedSearch->save(); // contrato
            $this->seccion->AdvancedSearch->save(); // seccion
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->sub_seccion->AdvancedSearch->save(); // sub_seccion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->boveda->AdvancedSearch->save(); // boveda
            $this->apellido1->AdvancedSearch->save(); // apellido1
            $this->apellido2->AdvancedSearch->save(); // apellido2
            $this->nombre1->AdvancedSearch->save(); // nombre1
            $this->nombre2->AdvancedSearch->save(); // nombre2
            $this->fecha_inhumacion->AdvancedSearch->save(); // fecha_inhumacion
            $this->telefono1->AdvancedSearch->save(); // telefono1
            $this->telefono2->AdvancedSearch->save(); // telefono2
            $this->telefono3->AdvancedSearch->save(); // telefono3
            $this->direc1->AdvancedSearch->save(); // direc1
            $this->direc2->AdvancedSearch->save(); // direc2
            $this->_email->AdvancedSearch->save(); // email
            $this->nac_ci_asociado->AdvancedSearch->save(); // nac_ci_asociado
            $this->ci_asociado->AdvancedSearch->save(); // ci_asociado
            $this->nombre_asociado->AdvancedSearch->save(); // nombre_asociado
            $this->nac_difunto->AdvancedSearch->save(); // nac_difunto
            $this->ci_difunto->AdvancedSearch->save(); // ci_difunto
            $this->edad->AdvancedSearch->save(); // edad
            $this->edo_civil->AdvancedSearch->save(); // edo_civil
            $this->fecha_nacimiento->AdvancedSearch->save(); // fecha_nacimiento
            $this->lugar->AdvancedSearch->save(); // lugar
            $this->fecha_defuncion->AdvancedSearch->save(); // fecha_defuncion
            $this->causa->AdvancedSearch->save(); // causa
            $this->certificado->AdvancedSearch->save(); // certificado
            $this->funeraria->AdvancedSearch->save(); // funeraria

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
            $this->Nparcela->AdvancedSearch->save(); // Nparcela
            $this->nacionalidad->AdvancedSearch->save(); // nacionalidad
            $this->cedula->AdvancedSearch->save(); // cedula
            $this->titular->AdvancedSearch->save(); // titular
            $this->contrato->AdvancedSearch->save(); // contrato
            $this->seccion->AdvancedSearch->save(); // seccion
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->sub_seccion->AdvancedSearch->save(); // sub_seccion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->boveda->AdvancedSearch->save(); // boveda
            $this->apellido1->AdvancedSearch->save(); // apellido1
            $this->apellido2->AdvancedSearch->save(); // apellido2
            $this->nombre1->AdvancedSearch->save(); // nombre1
            $this->nombre2->AdvancedSearch->save(); // nombre2
            $this->fecha_inhumacion->AdvancedSearch->save(); // fecha_inhumacion
            $this->telefono1->AdvancedSearch->save(); // telefono1
            $this->telefono2->AdvancedSearch->save(); // telefono2
            $this->telefono3->AdvancedSearch->save(); // telefono3
            $this->direc1->AdvancedSearch->save(); // direc1
            $this->direc2->AdvancedSearch->save(); // direc2
            $this->_email->AdvancedSearch->save(); // email
            $this->nac_ci_asociado->AdvancedSearch->save(); // nac_ci_asociado
            $this->ci_asociado->AdvancedSearch->save(); // ci_asociado
            $this->nombre_asociado->AdvancedSearch->save(); // nombre_asociado
            $this->nac_difunto->AdvancedSearch->save(); // nac_difunto
            $this->ci_difunto->AdvancedSearch->save(); // ci_difunto
            $this->edad->AdvancedSearch->save(); // edad
            $this->edo_civil->AdvancedSearch->save(); // edo_civil
            $this->fecha_nacimiento->AdvancedSearch->save(); // fecha_nacimiento
            $this->lugar->AdvancedSearch->save(); // lugar
            $this->fecha_defuncion->AdvancedSearch->save(); // fecha_defuncion
            $this->causa->AdvancedSearch->save(); // causa
            $this->certificado->AdvancedSearch->save(); // certificado
            $this->funeraria->AdvancedSearch->save(); // funeraria
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

        // Field Nparcela
        $filter = $this->queryBuilderWhere("Nparcela");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->Nparcela, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->Nparcela->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nacionalidad
        $filter = $this->queryBuilderWhere("nacionalidad");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nacionalidad, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nacionalidad->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cedula
        $filter = $this->queryBuilderWhere("cedula");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cedula, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cedula->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field titular
        $filter = $this->queryBuilderWhere("titular");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->titular, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->titular->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field contrato
        $filter = $this->queryBuilderWhere("contrato");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->contrato, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->contrato->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field seccion
        $filter = $this->queryBuilderWhere("seccion");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->seccion, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->seccion->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field modulo
        $filter = $this->queryBuilderWhere("modulo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->modulo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->modulo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field sub_seccion
        $filter = $this->queryBuilderWhere("sub_seccion");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->sub_seccion, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->sub_seccion->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field parcela
        $filter = $this->queryBuilderWhere("parcela");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->parcela, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->parcela->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field boveda
        $filter = $this->queryBuilderWhere("boveda");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->boveda, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->boveda->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field apellido1
        $filter = $this->queryBuilderWhere("apellido1");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->apellido1, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->apellido1->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field apellido2
        $filter = $this->queryBuilderWhere("apellido2");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->apellido2, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->apellido2->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nombre1
        $filter = $this->queryBuilderWhere("nombre1");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nombre1, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nombre1->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nombre2
        $filter = $this->queryBuilderWhere("nombre2");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nombre2, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nombre2->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecha_inhumacion
        $filter = $this->queryBuilderWhere("fecha_inhumacion");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecha_inhumacion, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecha_inhumacion->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field funeraria
        $filter = $this->queryBuilderWhere("funeraria");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->funeraria, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->funeraria->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->nacionalidad;
        $searchFlds[] = &$this->cedula;
        $searchFlds[] = &$this->titular;
        $searchFlds[] = &$this->contrato;
        $searchFlds[] = &$this->seccion;
        $searchFlds[] = &$this->modulo;
        $searchFlds[] = &$this->sub_seccion;
        $searchFlds[] = &$this->parcela;
        $searchFlds[] = &$this->boveda;
        $searchFlds[] = &$this->apellido1;
        $searchFlds[] = &$this->apellido2;
        $searchFlds[] = &$this->nombre1;
        $searchFlds[] = &$this->nombre2;
        $searchFlds[] = &$this->fecha_inhumacion;
        $searchFlds[] = &$this->telefono1;
        $searchFlds[] = &$this->telefono2;
        $searchFlds[] = &$this->telefono3;
        $searchFlds[] = &$this->direc1;
        $searchFlds[] = &$this->direc2;
        $searchFlds[] = &$this->_email;
        $searchFlds[] = &$this->nac_ci_asociado;
        $searchFlds[] = &$this->ci_asociado;
        $searchFlds[] = &$this->nombre_asociado;
        $searchFlds[] = &$this->nac_difunto;
        $searchFlds[] = &$this->ci_difunto;
        $searchFlds[] = &$this->edo_civil;
        $searchFlds[] = &$this->fecha_nacimiento;
        $searchFlds[] = &$this->lugar;
        $searchFlds[] = &$this->fecha_defuncion;
        $searchFlds[] = &$this->causa;
        $searchFlds[] = &$this->certificado;
        $searchFlds[] = &$this->funeraria;
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
        if ($this->Nparcela->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nacionalidad->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cedula->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->titular->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->contrato->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->seccion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->modulo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sub_seccion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->parcela->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->boveda->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->apellido1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->apellido2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_inhumacion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono3->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->direc1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->direc2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nac_ci_asociado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ci_asociado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre_asociado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nac_difunto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ci_difunto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->edad->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->edo_civil->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_nacimiento->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lugar->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_defuncion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->causa->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->certificado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->funeraria->AdvancedSearch->issetSession()) {
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
        $this->Nparcela->AdvancedSearch->unsetSession();
        $this->nacionalidad->AdvancedSearch->unsetSession();
        $this->cedula->AdvancedSearch->unsetSession();
        $this->titular->AdvancedSearch->unsetSession();
        $this->contrato->AdvancedSearch->unsetSession();
        $this->seccion->AdvancedSearch->unsetSession();
        $this->modulo->AdvancedSearch->unsetSession();
        $this->sub_seccion->AdvancedSearch->unsetSession();
        $this->parcela->AdvancedSearch->unsetSession();
        $this->boveda->AdvancedSearch->unsetSession();
        $this->apellido1->AdvancedSearch->unsetSession();
        $this->apellido2->AdvancedSearch->unsetSession();
        $this->nombre1->AdvancedSearch->unsetSession();
        $this->nombre2->AdvancedSearch->unsetSession();
        $this->fecha_inhumacion->AdvancedSearch->unsetSession();
        $this->telefono1->AdvancedSearch->unsetSession();
        $this->telefono2->AdvancedSearch->unsetSession();
        $this->telefono3->AdvancedSearch->unsetSession();
        $this->direc1->AdvancedSearch->unsetSession();
        $this->direc2->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->nac_ci_asociado->AdvancedSearch->unsetSession();
        $this->ci_asociado->AdvancedSearch->unsetSession();
        $this->nombre_asociado->AdvancedSearch->unsetSession();
        $this->nac_difunto->AdvancedSearch->unsetSession();
        $this->ci_difunto->AdvancedSearch->unsetSession();
        $this->edad->AdvancedSearch->unsetSession();
        $this->edo_civil->AdvancedSearch->unsetSession();
        $this->fecha_nacimiento->AdvancedSearch->unsetSession();
        $this->lugar->AdvancedSearch->unsetSession();
        $this->fecha_defuncion->AdvancedSearch->unsetSession();
        $this->causa->AdvancedSearch->unsetSession();
        $this->certificado->AdvancedSearch->unsetSession();
        $this->funeraria->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Nparcela->AdvancedSearch->load();
        $this->nacionalidad->AdvancedSearch->load();
        $this->cedula->AdvancedSearch->load();
        $this->titular->AdvancedSearch->load();
        $this->contrato->AdvancedSearch->load();
        $this->seccion->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->sub_seccion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->boveda->AdvancedSearch->load();
        $this->apellido1->AdvancedSearch->load();
        $this->apellido2->AdvancedSearch->load();
        $this->nombre1->AdvancedSearch->load();
        $this->nombre2->AdvancedSearch->load();
        $this->fecha_inhumacion->AdvancedSearch->load();
        $this->telefono1->AdvancedSearch->load();
        $this->telefono2->AdvancedSearch->load();
        $this->telefono3->AdvancedSearch->load();
        $this->direc1->AdvancedSearch->load();
        $this->direc2->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->nac_ci_asociado->AdvancedSearch->load();
        $this->ci_asociado->AdvancedSearch->load();
        $this->nombre_asociado->AdvancedSearch->load();
        $this->nac_difunto->AdvancedSearch->load();
        $this->ci_difunto->AdvancedSearch->load();
        $this->edad->AdvancedSearch->load();
        $this->edo_civil->AdvancedSearch->load();
        $this->fecha_nacimiento->AdvancedSearch->load();
        $this->lugar->AdvancedSearch->load();
        $this->fecha_defuncion->AdvancedSearch->load();
        $this->causa->AdvancedSearch->load();
        $this->certificado->AdvancedSearch->load();
        $this->funeraria->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->Nparcela->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->Nparcela); // Nparcela
            $this->updateSort($this->nacionalidad); // nacionalidad
            $this->updateSort($this->cedula); // cedula
            $this->updateSort($this->titular); // titular
            $this->updateSort($this->contrato); // contrato
            $this->updateSort($this->seccion); // seccion
            $this->updateSort($this->modulo); // modulo
            $this->updateSort($this->sub_seccion); // sub_seccion
            $this->updateSort($this->parcela); // parcela
            $this->updateSort($this->boveda); // boveda
            $this->updateSort($this->apellido1); // apellido1
            $this->updateSort($this->apellido2); // apellido2
            $this->updateSort($this->nombre1); // nombre1
            $this->updateSort($this->nombre2); // nombre2
            $this->updateSort($this->fecha_inhumacion); // fecha_inhumacion
            $this->updateSort($this->funeraria); // funeraria
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

            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->contrato->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->Nparcela->setSort("");
                $this->nacionalidad->setSort("");
                $this->cedula->setSort("");
                $this->titular->setSort("");
                $this->contrato->setSort("");
                $this->seccion->setSort("");
                $this->modulo->setSort("");
                $this->sub_seccion->setSort("");
                $this->parcela->setSort("");
                $this->boveda->setSort("");
                $this->apellido1->setSort("");
                $this->apellido2->setSort("");
                $this->nombre1->setSort("");
                $this->nombre2->setSort("");
                $this->fecha_inhumacion->setSort("");
                $this->telefono1->setSort("");
                $this->telefono2->setSort("");
                $this->telefono3->setSort("");
                $this->direc1->setSort("");
                $this->direc2->setSort("");
                $this->_email->setSort("");
                $this->nac_ci_asociado->setSort("");
                $this->ci_asociado->setSort("");
                $this->nombre_asociado->setSort("");
                $this->nac_difunto->setSort("");
                $this->ci_difunto->setSort("");
                $this->edad->setSort("");
                $this->edo_civil->setSort("");
                $this->fecha_nacimiento->setSort("");
                $this->lugar->setSort("");
                $this->fecha_defuncion->setSort("");
                $this->causa->setSort("");
                $this->certificado->setSort("");
                $this->funeraria->setSort("");
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_parcela\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_parcela\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_parcelalist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_parcelalist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Nparcela->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_parcela\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
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
            $this->createColumnOption($option, "Nparcela");
            $this->createColumnOption($option, "nacionalidad");
            $this->createColumnOption($option, "cedula");
            $this->createColumnOption($option, "titular");
            $this->createColumnOption($option, "contrato");
            $this->createColumnOption($option, "seccion");
            $this->createColumnOption($option, "modulo");
            $this->createColumnOption($option, "sub_seccion");
            $this->createColumnOption($option, "parcela");
            $this->createColumnOption($option, "boveda");
            $this->createColumnOption($option, "apellido1");
            $this->createColumnOption($option, "apellido2");
            $this->createColumnOption($option, "nombre1");
            $this->createColumnOption($option, "nombre2");
            $this->createColumnOption($option, "fecha_inhumacion");
            $this->createColumnOption($option, "funeraria");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_parcelasrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_parcelasrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_parcelalist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_parcela", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_sco_parcela",
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

        // Nparcela
        if ($this->Nparcela->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Nparcela->AdvancedSearch->SearchValue != "" || $this->Nparcela->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nacionalidad
        if ($this->nacionalidad->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nacionalidad->AdvancedSearch->SearchValue != "" || $this->nacionalidad->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cedula
        if ($this->cedula->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cedula->AdvancedSearch->SearchValue != "" || $this->cedula->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // titular
        if ($this->titular->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->titular->AdvancedSearch->SearchValue != "" || $this->titular->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // contrato
        if ($this->contrato->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->contrato->AdvancedSearch->SearchValue != "" || $this->contrato->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // seccion
        if ($this->seccion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->seccion->AdvancedSearch->SearchValue != "" || $this->seccion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // modulo
        if ($this->modulo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->modulo->AdvancedSearch->SearchValue != "" || $this->modulo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // sub_seccion
        if ($this->sub_seccion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sub_seccion->AdvancedSearch->SearchValue != "" || $this->sub_seccion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // parcela
        if ($this->parcela->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->parcela->AdvancedSearch->SearchValue != "" || $this->parcela->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // boveda
        if ($this->boveda->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->boveda->AdvancedSearch->SearchValue != "" || $this->boveda->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // apellido1
        if ($this->apellido1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->apellido1->AdvancedSearch->SearchValue != "" || $this->apellido1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // apellido2
        if ($this->apellido2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->apellido2->AdvancedSearch->SearchValue != "" || $this->apellido2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nombre1
        if ($this->nombre1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre1->AdvancedSearch->SearchValue != "" || $this->nombre1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nombre2
        if ($this->nombre2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre2->AdvancedSearch->SearchValue != "" || $this->nombre2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_inhumacion
        if ($this->fecha_inhumacion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_inhumacion->AdvancedSearch->SearchValue != "" || $this->fecha_inhumacion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telefono1
        if ($this->telefono1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telefono1->AdvancedSearch->SearchValue != "" || $this->telefono1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telefono2
        if ($this->telefono2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telefono2->AdvancedSearch->SearchValue != "" || $this->telefono2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telefono3
        if ($this->telefono3->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telefono3->AdvancedSearch->SearchValue != "" || $this->telefono3->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // direc1
        if ($this->direc1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->direc1->AdvancedSearch->SearchValue != "" || $this->direc1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // direc2
        if ($this->direc2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->direc2->AdvancedSearch->SearchValue != "" || $this->direc2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // email
        if ($this->_email->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_email->AdvancedSearch->SearchValue != "" || $this->_email->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nac_ci_asociado
        if ($this->nac_ci_asociado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nac_ci_asociado->AdvancedSearch->SearchValue != "" || $this->nac_ci_asociado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ci_asociado
        if ($this->ci_asociado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ci_asociado->AdvancedSearch->SearchValue != "" || $this->ci_asociado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nombre_asociado
        if ($this->nombre_asociado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre_asociado->AdvancedSearch->SearchValue != "" || $this->nombre_asociado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nac_difunto
        if ($this->nac_difunto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nac_difunto->AdvancedSearch->SearchValue != "" || $this->nac_difunto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ci_difunto
        if ($this->ci_difunto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ci_difunto->AdvancedSearch->SearchValue != "" || $this->ci_difunto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // edad
        if ($this->edad->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->edad->AdvancedSearch->SearchValue != "" || $this->edad->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // edo_civil
        if ($this->edo_civil->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->edo_civil->AdvancedSearch->SearchValue != "" || $this->edo_civil->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_nacimiento
        if ($this->fecha_nacimiento->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_nacimiento->AdvancedSearch->SearchValue != "" || $this->fecha_nacimiento->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // lugar
        if ($this->lugar->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lugar->AdvancedSearch->SearchValue != "" || $this->lugar->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_defuncion
        if ($this->fecha_defuncion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_defuncion->AdvancedSearch->SearchValue != "" || $this->fecha_defuncion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // causa
        if ($this->causa->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->causa->AdvancedSearch->SearchValue != "" || $this->causa->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // certificado
        if ($this->certificado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->certificado->AdvancedSearch->SearchValue != "" || $this->certificado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // funeraria
        if ($this->funeraria->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->funeraria->AdvancedSearch->SearchValue != "" || $this->funeraria->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->Nparcela->setDbValue($row['Nparcela']);
        $this->nacionalidad->setDbValue($row['nacionalidad']);
        $this->cedula->setDbValue($row['cedula']);
        $this->titular->setDbValue($row['titular']);
        $this->contrato->setDbValue($row['contrato']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->apellido1->setDbValue($row['apellido1']);
        $this->apellido2->setDbValue($row['apellido2']);
        $this->nombre1->setDbValue($row['nombre1']);
        $this->nombre2->setDbValue($row['nombre2']);
        $this->fecha_inhumacion->setDbValue($row['fecha_inhumacion']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->telefono3->setDbValue($row['telefono3']);
        $this->direc1->setDbValue($row['direc1']);
        $this->direc2->setDbValue($row['direc2']);
        $this->_email->setDbValue($row['email']);
        $this->nac_ci_asociado->setDbValue($row['nac_ci_asociado']);
        $this->ci_asociado->setDbValue($row['ci_asociado']);
        $this->nombre_asociado->setDbValue($row['nombre_asociado']);
        $this->nac_difunto->setDbValue($row['nac_difunto']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->edad->setDbValue($row['edad']);
        $this->edo_civil->setDbValue($row['edo_civil']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->lugar->setDbValue($row['lugar']);
        $this->fecha_defuncion->setDbValue($row['fecha_defuncion']);
        $this->causa->setDbValue($row['causa']);
        $this->certificado->setDbValue($row['certificado']);
        $this->funeraria->setDbValue($row['funeraria']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nparcela'] = $this->Nparcela->DefaultValue;
        $row['nacionalidad'] = $this->nacionalidad->DefaultValue;
        $row['cedula'] = $this->cedula->DefaultValue;
        $row['titular'] = $this->titular->DefaultValue;
        $row['contrato'] = $this->contrato->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['sub_seccion'] = $this->sub_seccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['boveda'] = $this->boveda->DefaultValue;
        $row['apellido1'] = $this->apellido1->DefaultValue;
        $row['apellido2'] = $this->apellido2->DefaultValue;
        $row['nombre1'] = $this->nombre1->DefaultValue;
        $row['nombre2'] = $this->nombre2->DefaultValue;
        $row['fecha_inhumacion'] = $this->fecha_inhumacion->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['telefono3'] = $this->telefono3->DefaultValue;
        $row['direc1'] = $this->direc1->DefaultValue;
        $row['direc2'] = $this->direc2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['nac_ci_asociado'] = $this->nac_ci_asociado->DefaultValue;
        $row['ci_asociado'] = $this->ci_asociado->DefaultValue;
        $row['nombre_asociado'] = $this->nombre_asociado->DefaultValue;
        $row['nac_difunto'] = $this->nac_difunto->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['edad'] = $this->edad->DefaultValue;
        $row['edo_civil'] = $this->edo_civil->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['lugar'] = $this->lugar->DefaultValue;
        $row['fecha_defuncion'] = $this->fecha_defuncion->DefaultValue;
        $row['causa'] = $this->causa->DefaultValue;
        $row['certificado'] = $this->certificado->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
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

        // Nparcela

        // nacionalidad

        // cedula

        // titular

        // contrato

        // seccion

        // modulo

        // sub_seccion

        // parcela

        // boveda

        // apellido1

        // apellido2

        // nombre1

        // nombre2

        // fecha_inhumacion

        // telefono1

        // telefono2

        // telefono3

        // direc1

        // direc2

        // email

        // nac_ci_asociado

        // ci_asociado

        // nombre_asociado

        // nac_difunto

        // ci_difunto

        // edad

        // edo_civil

        // fecha_nacimiento

        // lugar

        // fecha_defuncion

        // causa

        // certificado

        // funeraria

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nparcela
            $this->Nparcela->ViewValue = $this->Nparcela->CurrentValue;

            // nacionalidad
            $this->nacionalidad->ViewValue = $this->nacionalidad->CurrentValue;

            // cedula
            $this->cedula->ViewValue = $this->cedula->CurrentValue;

            // titular
            $this->titular->ViewValue = $this->titular->CurrentValue;

            // contrato
            $this->contrato->ViewValue = $this->contrato->CurrentValue;

            // seccion
            $this->seccion->ViewValue = $this->seccion->CurrentValue;

            // modulo
            $this->modulo->ViewValue = $this->modulo->CurrentValue;

            // sub_seccion
            $this->sub_seccion->ViewValue = $this->sub_seccion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // boveda
            $this->boveda->ViewValue = $this->boveda->CurrentValue;

            // apellido1
            $this->apellido1->ViewValue = $this->apellido1->CurrentValue;

            // apellido2
            $this->apellido2->ViewValue = $this->apellido2->CurrentValue;

            // nombre1
            $this->nombre1->ViewValue = $this->nombre1->CurrentValue;

            // nombre2
            $this->nombre2->ViewValue = $this->nombre2->CurrentValue;

            // fecha_inhumacion
            $this->fecha_inhumacion->ViewValue = $this->fecha_inhumacion->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // telefono3
            $this->telefono3->ViewValue = $this->telefono3->CurrentValue;

            // direc1
            $this->direc1->ViewValue = $this->direc1->CurrentValue;

            // direc2
            $this->direc2->ViewValue = $this->direc2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // nac_ci_asociado
            $this->nac_ci_asociado->ViewValue = $this->nac_ci_asociado->CurrentValue;

            // ci_asociado
            $this->ci_asociado->ViewValue = $this->ci_asociado->CurrentValue;

            // nombre_asociado
            $this->nombre_asociado->ViewValue = $this->nombre_asociado->CurrentValue;

            // nac_difunto
            $this->nac_difunto->ViewValue = $this->nac_difunto->CurrentValue;

            // ci_difunto
            $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

            // edad
            $this->edad->ViewValue = $this->edad->CurrentValue;

            // edo_civil
            $this->edo_civil->ViewValue = $this->edo_civil->CurrentValue;

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;

            // lugar
            $this->lugar->ViewValue = $this->lugar->CurrentValue;

            // fecha_defuncion
            $this->fecha_defuncion->ViewValue = $this->fecha_defuncion->CurrentValue;

            // causa
            $this->causa->ViewValue = $this->causa->CurrentValue;

            // certificado
            $this->certificado->ViewValue = $this->certificado->CurrentValue;

            // funeraria
            $this->funeraria->ViewValue = $this->funeraria->CurrentValue;

            // Nparcela
            $this->Nparcela->HrefValue = "";
            $this->Nparcela->TooltipValue = "";

            // nacionalidad
            $this->nacionalidad->HrefValue = "";
            $this->nacionalidad->TooltipValue = "";

            // cedula
            $this->cedula->HrefValue = "";
            $this->cedula->TooltipValue = "";

            // titular
            $this->titular->HrefValue = "";
            $this->titular->TooltipValue = "";

            // contrato
            $this->contrato->HrefValue = "";
            $this->contrato->TooltipValue = "";

            // seccion
            $this->seccion->HrefValue = "";
            $this->seccion->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // sub_seccion
            $this->sub_seccion->HrefValue = "";
            $this->sub_seccion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";

            // boveda
            $this->boveda->HrefValue = "";
            $this->boveda->TooltipValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";
            $this->apellido1->TooltipValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";
            $this->apellido2->TooltipValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";
            $this->nombre1->TooltipValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";
            $this->nombre2->TooltipValue = "";

            // fecha_inhumacion
            $this->fecha_inhumacion->HrefValue = "";
            $this->fecha_inhumacion->TooltipValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
            $this->funeraria->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // Nparcela
            $this->Nparcela->setupEditAttributes();
            $this->Nparcela->EditValue = $this->Nparcela->AdvancedSearch->SearchValue;
            $this->Nparcela->PlaceHolder = RemoveHtml($this->Nparcela->caption());

            // nacionalidad
            $this->nacionalidad->setupEditAttributes();
            if (!$this->nacionalidad->Raw) {
                $this->nacionalidad->AdvancedSearch->SearchValue = HtmlDecode($this->nacionalidad->AdvancedSearch->SearchValue);
            }
            $this->nacionalidad->EditValue = HtmlEncode($this->nacionalidad->AdvancedSearch->SearchValue);
            $this->nacionalidad->PlaceHolder = RemoveHtml($this->nacionalidad->caption());

            // cedula
            $this->cedula->setupEditAttributes();
            if (!$this->cedula->Raw) {
                $this->cedula->AdvancedSearch->SearchValue = HtmlDecode($this->cedula->AdvancedSearch->SearchValue);
            }
            $this->cedula->EditValue = HtmlEncode($this->cedula->AdvancedSearch->SearchValue);
            $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

            // titular
            $this->titular->setupEditAttributes();
            if (!$this->titular->Raw) {
                $this->titular->AdvancedSearch->SearchValue = HtmlDecode($this->titular->AdvancedSearch->SearchValue);
            }
            $this->titular->EditValue = HtmlEncode($this->titular->AdvancedSearch->SearchValue);
            $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

            // contrato
            $this->contrato->setupEditAttributes();
            if (!$this->contrato->Raw) {
                $this->contrato->AdvancedSearch->SearchValue = HtmlDecode($this->contrato->AdvancedSearch->SearchValue);
            }
            $this->contrato->EditValue = HtmlEncode($this->contrato->AdvancedSearch->SearchValue);
            $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());

            // seccion
            $this->seccion->setupEditAttributes();
            if (!$this->seccion->Raw) {
                $this->seccion->AdvancedSearch->SearchValue = HtmlDecode($this->seccion->AdvancedSearch->SearchValue);
            }
            $this->seccion->EditValue = HtmlEncode($this->seccion->AdvancedSearch->SearchValue);
            $this->seccion->PlaceHolder = RemoveHtml($this->seccion->caption());

            // modulo
            $this->modulo->setupEditAttributes();
            if (!$this->modulo->Raw) {
                $this->modulo->AdvancedSearch->SearchValue = HtmlDecode($this->modulo->AdvancedSearch->SearchValue);
            }
            $this->modulo->EditValue = HtmlEncode($this->modulo->AdvancedSearch->SearchValue);
            $this->modulo->PlaceHolder = RemoveHtml($this->modulo->caption());

            // sub_seccion
            $this->sub_seccion->setupEditAttributes();
            if (!$this->sub_seccion->Raw) {
                $this->sub_seccion->AdvancedSearch->SearchValue = HtmlDecode($this->sub_seccion->AdvancedSearch->SearchValue);
            }
            $this->sub_seccion->EditValue = HtmlEncode($this->sub_seccion->AdvancedSearch->SearchValue);
            $this->sub_seccion->PlaceHolder = RemoveHtml($this->sub_seccion->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->AdvancedSearch->SearchValue = HtmlDecode($this->parcela->AdvancedSearch->SearchValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->AdvancedSearch->SearchValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

            // boveda
            $this->boveda->setupEditAttributes();
            if (!$this->boveda->Raw) {
                $this->boveda->AdvancedSearch->SearchValue = HtmlDecode($this->boveda->AdvancedSearch->SearchValue);
            }
            $this->boveda->EditValue = HtmlEncode($this->boveda->AdvancedSearch->SearchValue);
            $this->boveda->PlaceHolder = RemoveHtml($this->boveda->caption());

            // apellido1
            $this->apellido1->setupEditAttributes();
            if (!$this->apellido1->Raw) {
                $this->apellido1->AdvancedSearch->SearchValue = HtmlDecode($this->apellido1->AdvancedSearch->SearchValue);
            }
            $this->apellido1->EditValue = HtmlEncode($this->apellido1->AdvancedSearch->SearchValue);
            $this->apellido1->PlaceHolder = RemoveHtml($this->apellido1->caption());

            // apellido2
            $this->apellido2->setupEditAttributes();
            if (!$this->apellido2->Raw) {
                $this->apellido2->AdvancedSearch->SearchValue = HtmlDecode($this->apellido2->AdvancedSearch->SearchValue);
            }
            $this->apellido2->EditValue = HtmlEncode($this->apellido2->AdvancedSearch->SearchValue);
            $this->apellido2->PlaceHolder = RemoveHtml($this->apellido2->caption());

            // nombre1
            $this->nombre1->setupEditAttributes();
            if (!$this->nombre1->Raw) {
                $this->nombre1->AdvancedSearch->SearchValue = HtmlDecode($this->nombre1->AdvancedSearch->SearchValue);
            }
            $this->nombre1->EditValue = HtmlEncode($this->nombre1->AdvancedSearch->SearchValue);
            $this->nombre1->PlaceHolder = RemoveHtml($this->nombre1->caption());

            // nombre2
            $this->nombre2->setupEditAttributes();
            if (!$this->nombre2->Raw) {
                $this->nombre2->AdvancedSearch->SearchValue = HtmlDecode($this->nombre2->AdvancedSearch->SearchValue);
            }
            $this->nombre2->EditValue = HtmlEncode($this->nombre2->AdvancedSearch->SearchValue);
            $this->nombre2->PlaceHolder = RemoveHtml($this->nombre2->caption());

            // fecha_inhumacion
            $this->fecha_inhumacion->setupEditAttributes();
            if (!$this->fecha_inhumacion->Raw) {
                $this->fecha_inhumacion->AdvancedSearch->SearchValue = HtmlDecode($this->fecha_inhumacion->AdvancedSearch->SearchValue);
            }
            $this->fecha_inhumacion->EditValue = HtmlEncode($this->fecha_inhumacion->AdvancedSearch->SearchValue);
            $this->fecha_inhumacion->PlaceHolder = RemoveHtml($this->fecha_inhumacion->caption());
            $this->fecha_inhumacion->setupEditAttributes();
            if (!$this->fecha_inhumacion->Raw) {
                $this->fecha_inhumacion->AdvancedSearch->SearchValue2 = HtmlDecode($this->fecha_inhumacion->AdvancedSearch->SearchValue2);
            }
            $this->fecha_inhumacion->EditValue2 = HtmlEncode($this->fecha_inhumacion->AdvancedSearch->SearchValue2);
            $this->fecha_inhumacion->PlaceHolder = RemoveHtml($this->fecha_inhumacion->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            if (!$this->funeraria->Raw) {
                $this->funeraria->AdvancedSearch->SearchValue = HtmlDecode($this->funeraria->AdvancedSearch->SearchValue);
            }
            $this->funeraria->EditValue = HtmlEncode($this->funeraria->AdvancedSearch->SearchValue);
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());
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
        $this->Nparcela->AdvancedSearch->load();
        $this->nacionalidad->AdvancedSearch->load();
        $this->cedula->AdvancedSearch->load();
        $this->titular->AdvancedSearch->load();
        $this->contrato->AdvancedSearch->load();
        $this->seccion->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->sub_seccion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->boveda->AdvancedSearch->load();
        $this->apellido1->AdvancedSearch->load();
        $this->apellido2->AdvancedSearch->load();
        $this->nombre1->AdvancedSearch->load();
        $this->nombre2->AdvancedSearch->load();
        $this->fecha_inhumacion->AdvancedSearch->load();
        $this->telefono1->AdvancedSearch->load();
        $this->telefono2->AdvancedSearch->load();
        $this->telefono3->AdvancedSearch->load();
        $this->direc1->AdvancedSearch->load();
        $this->direc2->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->nac_ci_asociado->AdvancedSearch->load();
        $this->ci_asociado->AdvancedSearch->load();
        $this->nombre_asociado->AdvancedSearch->load();
        $this->nac_difunto->AdvancedSearch->load();
        $this->ci_difunto->AdvancedSearch->load();
        $this->edad->AdvancedSearch->load();
        $this->edo_civil->AdvancedSearch->load();
        $this->fecha_nacimiento->AdvancedSearch->load();
        $this->lugar->AdvancedSearch->load();
        $this->fecha_defuncion->AdvancedSearch->load();
        $this->causa->AdvancedSearch->load();
        $this->certificado->AdvancedSearch->load();
        $this->funeraria->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_parcelasrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        $foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "sco_expediente") {
                $validMaster = true;
                $masterTbl = Container("sco_expediente");
                if (($parm = Get("fk_contrato_parcela", Get("contrato"))) !== null) {
                    $masterTbl->contrato_parcela->setQueryStringValue($parm);
                    $this->contrato->QueryStringValue = $masterTbl->contrato_parcela->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->contrato->setSessionValue($this->contrato->QueryStringValue);
                    $foreignKeys["contrato"] = $this->contrato->QueryStringValue;
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "sco_expediente") {
                $validMaster = true;
                $masterTbl = Container("sco_expediente");
                if (($parm = Post("fk_contrato_parcela", Post("contrato"))) !== null) {
                    $masterTbl->contrato_parcela->setFormValue($parm);
                    $this->contrato->FormValue = $masterTbl->contrato_parcela->FormValue;
                    $this->contrato->setSessionValue($this->contrato->FormValue);
                    $foreignKeys["contrato"] = $this->contrato->FormValue;
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Update URL
            $this->AddUrl = $this->addMasterUrl($this->AddUrl);
            $this->InlineAddUrl = $this->addMasterUrl($this->InlineAddUrl);
            $this->GridAddUrl = $this->addMasterUrl($this->GridAddUrl);
            $this->GridEditUrl = $this->addMasterUrl($this->GridEditUrl);
            $this->MultiEditUrl = $this->addMasterUrl($this->MultiEditUrl);

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb(); // Set up breadcrumb again for the master table
            }

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "sco_expediente") {
                if (!array_key_exists("contrato", $foreignKeys)) { // Not current foreign key
                    $this->contrato->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
    public function pageDataRendering(&$header) {
        // 1. Obtenemos los datos del parámetro 046 (Descripción y Fecha)
        $sqlParam = "SELECT descripcion, valor1 FROM sco_parametro WHERE codigo = '046';";
        $rowParam = ExecuteRow($sqlParam);

        // 2. Obtenemos el conteo de pendientes (Sin Bóveda)
        $pendientes = ExecuteScalar("SELECT COUNT(*) FROM sco_parcela WHERE boveda IS NULL OR boveda = ''");
        $pendientes = 0;
        if ($rowParam) {
            $desc = $rowParam["descripcion"];
            $fecha = $rowParam["valor1"];

            // Estilos para el banner: Gradiente suave, bordes redondeados y sombra
            $header = '
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(to right, #ffffff, #f8f9fa);">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box bg-primary text-white d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,123,255,0.3);">
                                        <i class="fas fa-server fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-0 font-weight-bold" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">Estado de Importación</h6>
                                        <h4 class="mb-0" style="color: #2c3e50; font-weight: 700;">' . $desc . ' <span class="badge badge-soft-primary" style="background: #e7f1ff; color: #007bff; font-size: 0.9rem; margin-left: 8px;">' . $fecha . '</span></h4>
                                    </div>
                                </div>
                                ' . ($pendientes > 0 ? '
                                <div class="alert m-0 p-2 d-flex align-items-center shadow-sm" style="background: #fff5f5; border: 1px solid #feb2b2; border-radius: 10px;">
                                    <div class="text-right mr-3">
                                        <div style="font-size: 0.7rem; color: #c53030; font-weight: 800; text-transform: uppercase;">Por Regularizar</div>
                                        <div style="font-size: 1.2rem; color: #e53e3e; font-weight: 900; line-height: 1;">' . $pendientes . ' <small style="font-size: 0.6rem;">REGISTROS</small></div>
                                    </div>
                                    <div class="animate__animated animate__pulse animate__infinite">
                                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                                    </div>
                                </div>
                                ' : '
                                <div class="text-success d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x mr-2"></i>
                                    <span class="font-weight-bold">Todo al día</span>
                                </div>
                                ') . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    // Page DataRendered event
    public function pageDataRendered(&$footer) {
        // Solo mostrar en el listado de parcelas
        /*
        if ($this->PageID == "list") {
            // Contamos registros donde la boveda esté vacía o sea nula
            $pendientes = ExecuteScalar("SELECT COUNT(*) FROM sco_parcela WHERE boveda IS NULL OR boveda = ''");
            if ($pendientes > 0) {
                $mensaje = "<div class='alert alert-warning shadow-sm border-left-strong' style='border-left: 5px solid #ffc107; border-radius: 10px;'>
                                <div class='d-flex align-items-center'>
                                    <i class='fas fa-exclamation-circle fa-2x mr-3 text-warning'></i>
                                    <div>
                                        <h5 class='mb-0 font-weight-bold'>Atención: Registros Pendientes</h5>
                                        <span>Se han detectado <strong>$pendientes</strong> parcelas sin bóveda asignada provenientes del AS400.</span>
                                    </div>
                                </div>
                            </div>";
                // Inyectamos el mensaje antes del contenido de la página
                $footer = $mensaje;
            }
        }
        */
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
