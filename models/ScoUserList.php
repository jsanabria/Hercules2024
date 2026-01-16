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
class ScoUserList extends ScoUser
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoUserList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_userlist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoUserList";

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
        $this->Nuser->setVisibility();
        $this->cedula->setVisibility();
        $this->nombre->setVisibility();
        $this->_username->setVisibility();
        $this->_password->Visible = false;
        $this->correo->Visible = false;
        $this->direccion->Visible = false;
        $this->level->setVisibility();
        $this->activo->Visible = false;
        $this->foto->setVisibility();
        $this->fecha_ingreso_cia->Visible = false;
        $this->fecha_egreso_cia->Visible = false;
        $this->motivo_egreso->Visible = false;
        $this->departamento->Visible = false;
        $this->cargo->Visible = false;
        $this->celular_1->Visible = false;
        $this->celular_2->Visible = false;
        $this->telefono_1->Visible = false;
        $this->_email->Visible = false;
        $this->hora_entrada->Visible = false;
        $this->hora_salida->Visible = false;
        $this->proveedor->Visible = false;
        $this->seguro->Visible = false;
        $this->level_cemantick->Visible = false;
        $this->evaluacion->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_user';
        $this->TableName = 'sco_user';

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

        // Table object (sco_user)
        if (!isset($GLOBALS["sco_user"]) || $GLOBALS["sco_user"]::class == PROJECT_NAMESPACE . "sco_user") {
            $GLOBALS["sco_user"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoUserAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoUserDelete";
        $this->MultiUpdateUrl = "ScoUserUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_user');
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
                    $result["view"] = SameString($pageName, "ScoUserView"); // If View page, no primary button
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
            $key .= @$ar['Nuser'];
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
            $this->Nuser->Visible = false;
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
        $this->setupLookupOptions($this->level);
        $this->setupLookupOptions($this->activo);
        $this->setupLookupOptions($this->motivo_egreso);
        $this->setupLookupOptions($this->departamento);
        $this->setupLookupOptions($this->cargo);
        $this->setupLookupOptions($this->proveedor);
        $this->setupLookupOptions($this->seguro);
        $this->setupLookupOptions($this->evaluacion);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_usergrid";
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
        $filterList = Concat($filterList, $this->Nuser->AdvancedSearch->toJson(), ","); // Field Nuser
        $filterList = Concat($filterList, $this->cedula->AdvancedSearch->toJson(), ","); // Field cedula
        $filterList = Concat($filterList, $this->nombre->AdvancedSearch->toJson(), ","); // Field nombre
        $filterList = Concat($filterList, $this->_username->AdvancedSearch->toJson(), ","); // Field username
        $filterList = Concat($filterList, $this->_password->AdvancedSearch->toJson(), ","); // Field password
        $filterList = Concat($filterList, $this->correo->AdvancedSearch->toJson(), ","); // Field correo
        $filterList = Concat($filterList, $this->direccion->AdvancedSearch->toJson(), ","); // Field direccion
        $filterList = Concat($filterList, $this->level->AdvancedSearch->toJson(), ","); // Field level
        $filterList = Concat($filterList, $this->activo->AdvancedSearch->toJson(), ","); // Field activo
        $filterList = Concat($filterList, $this->foto->AdvancedSearch->toJson(), ","); // Field foto
        $filterList = Concat($filterList, $this->fecha_ingreso_cia->AdvancedSearch->toJson(), ","); // Field fecha_ingreso_cia
        $filterList = Concat($filterList, $this->fecha_egreso_cia->AdvancedSearch->toJson(), ","); // Field fecha_egreso_cia
        $filterList = Concat($filterList, $this->motivo_egreso->AdvancedSearch->toJson(), ","); // Field motivo_egreso
        $filterList = Concat($filterList, $this->departamento->AdvancedSearch->toJson(), ","); // Field departamento
        $filterList = Concat($filterList, $this->cargo->AdvancedSearch->toJson(), ","); // Field cargo
        $filterList = Concat($filterList, $this->celular_1->AdvancedSearch->toJson(), ","); // Field celular_1
        $filterList = Concat($filterList, $this->celular_2->AdvancedSearch->toJson(), ","); // Field celular_2
        $filterList = Concat($filterList, $this->telefono_1->AdvancedSearch->toJson(), ","); // Field telefono_1
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->hora_entrada->AdvancedSearch->toJson(), ","); // Field hora_entrada
        $filterList = Concat($filterList, $this->hora_salida->AdvancedSearch->toJson(), ","); // Field hora_salida
        $filterList = Concat($filterList, $this->proveedor->AdvancedSearch->toJson(), ","); // Field proveedor
        $filterList = Concat($filterList, $this->seguro->AdvancedSearch->toJson(), ","); // Field seguro
        $filterList = Concat($filterList, $this->level_cemantick->AdvancedSearch->toJson(), ","); // Field level_cemantick
        $filterList = Concat($filterList, $this->evaluacion->AdvancedSearch->toJson(), ","); // Field evaluacion
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
            Profile()->setSearchFilters("fsco_usersrch", $filters);
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

        // Field Nuser
        $this->Nuser->AdvancedSearch->SearchValue = @$filter["x_Nuser"];
        $this->Nuser->AdvancedSearch->SearchOperator = @$filter["z_Nuser"];
        $this->Nuser->AdvancedSearch->SearchCondition = @$filter["v_Nuser"];
        $this->Nuser->AdvancedSearch->SearchValue2 = @$filter["y_Nuser"];
        $this->Nuser->AdvancedSearch->SearchOperator2 = @$filter["w_Nuser"];
        $this->Nuser->AdvancedSearch->save();

        // Field cedula
        $this->cedula->AdvancedSearch->SearchValue = @$filter["x_cedula"];
        $this->cedula->AdvancedSearch->SearchOperator = @$filter["z_cedula"];
        $this->cedula->AdvancedSearch->SearchCondition = @$filter["v_cedula"];
        $this->cedula->AdvancedSearch->SearchValue2 = @$filter["y_cedula"];
        $this->cedula->AdvancedSearch->SearchOperator2 = @$filter["w_cedula"];
        $this->cedula->AdvancedSearch->save();

        // Field nombre
        $this->nombre->AdvancedSearch->SearchValue = @$filter["x_nombre"];
        $this->nombre->AdvancedSearch->SearchOperator = @$filter["z_nombre"];
        $this->nombre->AdvancedSearch->SearchCondition = @$filter["v_nombre"];
        $this->nombre->AdvancedSearch->SearchValue2 = @$filter["y_nombre"];
        $this->nombre->AdvancedSearch->SearchOperator2 = @$filter["w_nombre"];
        $this->nombre->AdvancedSearch->save();

        // Field username
        $this->_username->AdvancedSearch->SearchValue = @$filter["x__username"];
        $this->_username->AdvancedSearch->SearchOperator = @$filter["z__username"];
        $this->_username->AdvancedSearch->SearchCondition = @$filter["v__username"];
        $this->_username->AdvancedSearch->SearchValue2 = @$filter["y__username"];
        $this->_username->AdvancedSearch->SearchOperator2 = @$filter["w__username"];
        $this->_username->AdvancedSearch->save();

        // Field password
        $this->_password->AdvancedSearch->SearchValue = @$filter["x__password"];
        $this->_password->AdvancedSearch->SearchOperator = @$filter["z__password"];
        $this->_password->AdvancedSearch->SearchCondition = @$filter["v__password"];
        $this->_password->AdvancedSearch->SearchValue2 = @$filter["y__password"];
        $this->_password->AdvancedSearch->SearchOperator2 = @$filter["w__password"];
        $this->_password->AdvancedSearch->save();

        // Field correo
        $this->correo->AdvancedSearch->SearchValue = @$filter["x_correo"];
        $this->correo->AdvancedSearch->SearchOperator = @$filter["z_correo"];
        $this->correo->AdvancedSearch->SearchCondition = @$filter["v_correo"];
        $this->correo->AdvancedSearch->SearchValue2 = @$filter["y_correo"];
        $this->correo->AdvancedSearch->SearchOperator2 = @$filter["w_correo"];
        $this->correo->AdvancedSearch->save();

        // Field direccion
        $this->direccion->AdvancedSearch->SearchValue = @$filter["x_direccion"];
        $this->direccion->AdvancedSearch->SearchOperator = @$filter["z_direccion"];
        $this->direccion->AdvancedSearch->SearchCondition = @$filter["v_direccion"];
        $this->direccion->AdvancedSearch->SearchValue2 = @$filter["y_direccion"];
        $this->direccion->AdvancedSearch->SearchOperator2 = @$filter["w_direccion"];
        $this->direccion->AdvancedSearch->save();

        // Field level
        $this->level->AdvancedSearch->SearchValue = @$filter["x_level"];
        $this->level->AdvancedSearch->SearchOperator = @$filter["z_level"];
        $this->level->AdvancedSearch->SearchCondition = @$filter["v_level"];
        $this->level->AdvancedSearch->SearchValue2 = @$filter["y_level"];
        $this->level->AdvancedSearch->SearchOperator2 = @$filter["w_level"];
        $this->level->AdvancedSearch->save();

        // Field activo
        $this->activo->AdvancedSearch->SearchValue = @$filter["x_activo"];
        $this->activo->AdvancedSearch->SearchOperator = @$filter["z_activo"];
        $this->activo->AdvancedSearch->SearchCondition = @$filter["v_activo"];
        $this->activo->AdvancedSearch->SearchValue2 = @$filter["y_activo"];
        $this->activo->AdvancedSearch->SearchOperator2 = @$filter["w_activo"];
        $this->activo->AdvancedSearch->save();

        // Field foto
        $this->foto->AdvancedSearch->SearchValue = @$filter["x_foto"];
        $this->foto->AdvancedSearch->SearchOperator = @$filter["z_foto"];
        $this->foto->AdvancedSearch->SearchCondition = @$filter["v_foto"];
        $this->foto->AdvancedSearch->SearchValue2 = @$filter["y_foto"];
        $this->foto->AdvancedSearch->SearchOperator2 = @$filter["w_foto"];
        $this->foto->AdvancedSearch->save();

        // Field fecha_ingreso_cia
        $this->fecha_ingreso_cia->AdvancedSearch->SearchValue = @$filter["x_fecha_ingreso_cia"];
        $this->fecha_ingreso_cia->AdvancedSearch->SearchOperator = @$filter["z_fecha_ingreso_cia"];
        $this->fecha_ingreso_cia->AdvancedSearch->SearchCondition = @$filter["v_fecha_ingreso_cia"];
        $this->fecha_ingreso_cia->AdvancedSearch->SearchValue2 = @$filter["y_fecha_ingreso_cia"];
        $this->fecha_ingreso_cia->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_ingreso_cia"];
        $this->fecha_ingreso_cia->AdvancedSearch->save();

        // Field fecha_egreso_cia
        $this->fecha_egreso_cia->AdvancedSearch->SearchValue = @$filter["x_fecha_egreso_cia"];
        $this->fecha_egreso_cia->AdvancedSearch->SearchOperator = @$filter["z_fecha_egreso_cia"];
        $this->fecha_egreso_cia->AdvancedSearch->SearchCondition = @$filter["v_fecha_egreso_cia"];
        $this->fecha_egreso_cia->AdvancedSearch->SearchValue2 = @$filter["y_fecha_egreso_cia"];
        $this->fecha_egreso_cia->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_egreso_cia"];
        $this->fecha_egreso_cia->AdvancedSearch->save();

        // Field motivo_egreso
        $this->motivo_egreso->AdvancedSearch->SearchValue = @$filter["x_motivo_egreso"];
        $this->motivo_egreso->AdvancedSearch->SearchOperator = @$filter["z_motivo_egreso"];
        $this->motivo_egreso->AdvancedSearch->SearchCondition = @$filter["v_motivo_egreso"];
        $this->motivo_egreso->AdvancedSearch->SearchValue2 = @$filter["y_motivo_egreso"];
        $this->motivo_egreso->AdvancedSearch->SearchOperator2 = @$filter["w_motivo_egreso"];
        $this->motivo_egreso->AdvancedSearch->save();

        // Field departamento
        $this->departamento->AdvancedSearch->SearchValue = @$filter["x_departamento"];
        $this->departamento->AdvancedSearch->SearchOperator = @$filter["z_departamento"];
        $this->departamento->AdvancedSearch->SearchCondition = @$filter["v_departamento"];
        $this->departamento->AdvancedSearch->SearchValue2 = @$filter["y_departamento"];
        $this->departamento->AdvancedSearch->SearchOperator2 = @$filter["w_departamento"];
        $this->departamento->AdvancedSearch->save();

        // Field cargo
        $this->cargo->AdvancedSearch->SearchValue = @$filter["x_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator = @$filter["z_cargo"];
        $this->cargo->AdvancedSearch->SearchCondition = @$filter["v_cargo"];
        $this->cargo->AdvancedSearch->SearchValue2 = @$filter["y_cargo"];
        $this->cargo->AdvancedSearch->SearchOperator2 = @$filter["w_cargo"];
        $this->cargo->AdvancedSearch->save();

        // Field celular_1
        $this->celular_1->AdvancedSearch->SearchValue = @$filter["x_celular_1"];
        $this->celular_1->AdvancedSearch->SearchOperator = @$filter["z_celular_1"];
        $this->celular_1->AdvancedSearch->SearchCondition = @$filter["v_celular_1"];
        $this->celular_1->AdvancedSearch->SearchValue2 = @$filter["y_celular_1"];
        $this->celular_1->AdvancedSearch->SearchOperator2 = @$filter["w_celular_1"];
        $this->celular_1->AdvancedSearch->save();

        // Field celular_2
        $this->celular_2->AdvancedSearch->SearchValue = @$filter["x_celular_2"];
        $this->celular_2->AdvancedSearch->SearchOperator = @$filter["z_celular_2"];
        $this->celular_2->AdvancedSearch->SearchCondition = @$filter["v_celular_2"];
        $this->celular_2->AdvancedSearch->SearchValue2 = @$filter["y_celular_2"];
        $this->celular_2->AdvancedSearch->SearchOperator2 = @$filter["w_celular_2"];
        $this->celular_2->AdvancedSearch->save();

        // Field telefono_1
        $this->telefono_1->AdvancedSearch->SearchValue = @$filter["x_telefono_1"];
        $this->telefono_1->AdvancedSearch->SearchOperator = @$filter["z_telefono_1"];
        $this->telefono_1->AdvancedSearch->SearchCondition = @$filter["v_telefono_1"];
        $this->telefono_1->AdvancedSearch->SearchValue2 = @$filter["y_telefono_1"];
        $this->telefono_1->AdvancedSearch->SearchOperator2 = @$filter["w_telefono_1"];
        $this->telefono_1->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field hora_entrada
        $this->hora_entrada->AdvancedSearch->SearchValue = @$filter["x_hora_entrada"];
        $this->hora_entrada->AdvancedSearch->SearchOperator = @$filter["z_hora_entrada"];
        $this->hora_entrada->AdvancedSearch->SearchCondition = @$filter["v_hora_entrada"];
        $this->hora_entrada->AdvancedSearch->SearchValue2 = @$filter["y_hora_entrada"];
        $this->hora_entrada->AdvancedSearch->SearchOperator2 = @$filter["w_hora_entrada"];
        $this->hora_entrada->AdvancedSearch->save();

        // Field hora_salida
        $this->hora_salida->AdvancedSearch->SearchValue = @$filter["x_hora_salida"];
        $this->hora_salida->AdvancedSearch->SearchOperator = @$filter["z_hora_salida"];
        $this->hora_salida->AdvancedSearch->SearchCondition = @$filter["v_hora_salida"];
        $this->hora_salida->AdvancedSearch->SearchValue2 = @$filter["y_hora_salida"];
        $this->hora_salida->AdvancedSearch->SearchOperator2 = @$filter["w_hora_salida"];
        $this->hora_salida->AdvancedSearch->save();

        // Field proveedor
        $this->proveedor->AdvancedSearch->SearchValue = @$filter["x_proveedor"];
        $this->proveedor->AdvancedSearch->SearchOperator = @$filter["z_proveedor"];
        $this->proveedor->AdvancedSearch->SearchCondition = @$filter["v_proveedor"];
        $this->proveedor->AdvancedSearch->SearchValue2 = @$filter["y_proveedor"];
        $this->proveedor->AdvancedSearch->SearchOperator2 = @$filter["w_proveedor"];
        $this->proveedor->AdvancedSearch->save();

        // Field seguro
        $this->seguro->AdvancedSearch->SearchValue = @$filter["x_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator = @$filter["z_seguro"];
        $this->seguro->AdvancedSearch->SearchCondition = @$filter["v_seguro"];
        $this->seguro->AdvancedSearch->SearchValue2 = @$filter["y_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator2 = @$filter["w_seguro"];
        $this->seguro->AdvancedSearch->save();

        // Field level_cemantick
        $this->level_cemantick->AdvancedSearch->SearchValue = @$filter["x_level_cemantick"];
        $this->level_cemantick->AdvancedSearch->SearchOperator = @$filter["z_level_cemantick"];
        $this->level_cemantick->AdvancedSearch->SearchCondition = @$filter["v_level_cemantick"];
        $this->level_cemantick->AdvancedSearch->SearchValue2 = @$filter["y_level_cemantick"];
        $this->level_cemantick->AdvancedSearch->SearchOperator2 = @$filter["w_level_cemantick"];
        $this->level_cemantick->AdvancedSearch->save();

        // Field evaluacion
        $this->evaluacion->AdvancedSearch->SearchValue = @$filter["x_evaluacion"];
        $this->evaluacion->AdvancedSearch->SearchOperator = @$filter["z_evaluacion"];
        $this->evaluacion->AdvancedSearch->SearchCondition = @$filter["v_evaluacion"];
        $this->evaluacion->AdvancedSearch->SearchValue2 = @$filter["y_evaluacion"];
        $this->evaluacion->AdvancedSearch->SearchOperator2 = @$filter["w_evaluacion"];
        $this->evaluacion->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->Nuser, $default, false); // Nuser
        $this->buildSearchSql($where, $this->cedula, $default, false); // cedula
        $this->buildSearchSql($where, $this->nombre, $default, false); // nombre
        $this->buildSearchSql($where, $this->_username, $default, false); // username
        $this->buildSearchSql($where, $this->_password, $default, false); // password
        $this->buildSearchSql($where, $this->correo, $default, false); // correo
        $this->buildSearchSql($where, $this->direccion, $default, false); // direccion
        $this->buildSearchSql($where, $this->level, $default, false); // level
        $this->buildSearchSql($where, $this->activo, $default, false); // activo
        $this->buildSearchSql($where, $this->foto, $default, false); // foto
        $this->buildSearchSql($where, $this->fecha_ingreso_cia, $default, false); // fecha_ingreso_cia
        $this->buildSearchSql($where, $this->fecha_egreso_cia, $default, false); // fecha_egreso_cia
        $this->buildSearchSql($where, $this->motivo_egreso, $default, false); // motivo_egreso
        $this->buildSearchSql($where, $this->departamento, $default, false); // departamento
        $this->buildSearchSql($where, $this->cargo, $default, false); // cargo
        $this->buildSearchSql($where, $this->celular_1, $default, false); // celular_1
        $this->buildSearchSql($where, $this->celular_2, $default, false); // celular_2
        $this->buildSearchSql($where, $this->telefono_1, $default, false); // telefono_1
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->hora_entrada, $default, false); // hora_entrada
        $this->buildSearchSql($where, $this->hora_salida, $default, false); // hora_salida
        $this->buildSearchSql($where, $this->proveedor, $default, false); // proveedor
        $this->buildSearchSql($where, $this->seguro, $default, false); // seguro
        $this->buildSearchSql($where, $this->level_cemantick, $default, false); // level_cemantick
        $this->buildSearchSql($where, $this->evaluacion, $default, false); // evaluacion

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Nuser->AdvancedSearch->save(); // Nuser
            $this->cedula->AdvancedSearch->save(); // cedula
            $this->nombre->AdvancedSearch->save(); // nombre
            $this->_username->AdvancedSearch->save(); // username
            $this->_password->AdvancedSearch->save(); // password
            $this->correo->AdvancedSearch->save(); // correo
            $this->direccion->AdvancedSearch->save(); // direccion
            $this->level->AdvancedSearch->save(); // level
            $this->activo->AdvancedSearch->save(); // activo
            $this->foto->AdvancedSearch->save(); // foto
            $this->fecha_ingreso_cia->AdvancedSearch->save(); // fecha_ingreso_cia
            $this->fecha_egreso_cia->AdvancedSearch->save(); // fecha_egreso_cia
            $this->motivo_egreso->AdvancedSearch->save(); // motivo_egreso
            $this->departamento->AdvancedSearch->save(); // departamento
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->celular_1->AdvancedSearch->save(); // celular_1
            $this->celular_2->AdvancedSearch->save(); // celular_2
            $this->telefono_1->AdvancedSearch->save(); // telefono_1
            $this->_email->AdvancedSearch->save(); // email
            $this->hora_entrada->AdvancedSearch->save(); // hora_entrada
            $this->hora_salida->AdvancedSearch->save(); // hora_salida
            $this->proveedor->AdvancedSearch->save(); // proveedor
            $this->seguro->AdvancedSearch->save(); // seguro
            $this->level_cemantick->AdvancedSearch->save(); // level_cemantick
            $this->evaluacion->AdvancedSearch->save(); // evaluacion

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
            $this->Nuser->AdvancedSearch->save(); // Nuser
            $this->cedula->AdvancedSearch->save(); // cedula
            $this->nombre->AdvancedSearch->save(); // nombre
            $this->_username->AdvancedSearch->save(); // username
            $this->_password->AdvancedSearch->save(); // password
            $this->correo->AdvancedSearch->save(); // correo
            $this->direccion->AdvancedSearch->save(); // direccion
            $this->level->AdvancedSearch->save(); // level
            $this->activo->AdvancedSearch->save(); // activo
            $this->foto->AdvancedSearch->save(); // foto
            $this->fecha_ingreso_cia->AdvancedSearch->save(); // fecha_ingreso_cia
            $this->fecha_egreso_cia->AdvancedSearch->save(); // fecha_egreso_cia
            $this->motivo_egreso->AdvancedSearch->save(); // motivo_egreso
            $this->departamento->AdvancedSearch->save(); // departamento
            $this->cargo->AdvancedSearch->save(); // cargo
            $this->celular_1->AdvancedSearch->save(); // celular_1
            $this->celular_2->AdvancedSearch->save(); // celular_2
            $this->telefono_1->AdvancedSearch->save(); // telefono_1
            $this->_email->AdvancedSearch->save(); // email
            $this->hora_entrada->AdvancedSearch->save(); // hora_entrada
            $this->hora_salida->AdvancedSearch->save(); // hora_salida
            $this->proveedor->AdvancedSearch->save(); // proveedor
            $this->seguro->AdvancedSearch->save(); // seguro
            $this->level_cemantick->AdvancedSearch->save(); // level_cemantick
            $this->evaluacion->AdvancedSearch->save(); // evaluacion
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

        // Field Nuser
        $filter = $this->queryBuilderWhere("Nuser");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->Nuser, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->Nuser->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cedula
        $filter = $this->queryBuilderWhere("cedula");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cedula, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cedula->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nombre
        $filter = $this->queryBuilderWhere("nombre");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nombre, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nombre->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field username
        $filter = $this->queryBuilderWhere("username");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->_username, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->_username->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field level
        $filter = $this->queryBuilderWhere("level");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->level, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->level->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field foto
        $filter = $this->queryBuilderWhere("foto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->foto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->foto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->cedula;
        $searchFlds[] = &$this->nombre;
        $searchFlds[] = &$this->_username;
        $searchFlds[] = &$this->_password;
        $searchFlds[] = &$this->correo;
        $searchFlds[] = &$this->direccion;
        $searchFlds[] = &$this->foto;
        $searchFlds[] = &$this->fecha_ingreso_cia;
        $searchFlds[] = &$this->motivo_egreso;
        $searchFlds[] = &$this->departamento;
        $searchFlds[] = &$this->cargo;
        $searchFlds[] = &$this->celular_1;
        $searchFlds[] = &$this->celular_2;
        $searchFlds[] = &$this->telefono_1;
        $searchFlds[] = &$this->_email;
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
        if ($this->Nuser->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cedula->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_username->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_password->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->correo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->direccion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->level->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->activo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->foto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_ingreso_cia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_egreso_cia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->motivo_egreso->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->departamento->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cargo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->celular_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->celular_2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono_1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_entrada->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_salida->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->proveedor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->seguro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->level_cemantick->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->evaluacion->AdvancedSearch->issetSession()) {
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
        $this->Nuser->AdvancedSearch->unsetSession();
        $this->cedula->AdvancedSearch->unsetSession();
        $this->nombre->AdvancedSearch->unsetSession();
        $this->_username->AdvancedSearch->unsetSession();
        $this->_password->AdvancedSearch->unsetSession();
        $this->correo->AdvancedSearch->unsetSession();
        $this->direccion->AdvancedSearch->unsetSession();
        $this->level->AdvancedSearch->unsetSession();
        $this->activo->AdvancedSearch->unsetSession();
        $this->foto->AdvancedSearch->unsetSession();
        $this->fecha_ingreso_cia->AdvancedSearch->unsetSession();
        $this->fecha_egreso_cia->AdvancedSearch->unsetSession();
        $this->motivo_egreso->AdvancedSearch->unsetSession();
        $this->departamento->AdvancedSearch->unsetSession();
        $this->cargo->AdvancedSearch->unsetSession();
        $this->celular_1->AdvancedSearch->unsetSession();
        $this->celular_2->AdvancedSearch->unsetSession();
        $this->telefono_1->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->hora_entrada->AdvancedSearch->unsetSession();
        $this->hora_salida->AdvancedSearch->unsetSession();
        $this->proveedor->AdvancedSearch->unsetSession();
        $this->seguro->AdvancedSearch->unsetSession();
        $this->level_cemantick->AdvancedSearch->unsetSession();
        $this->evaluacion->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Nuser->AdvancedSearch->load();
        $this->cedula->AdvancedSearch->load();
        $this->nombre->AdvancedSearch->load();
        $this->_username->AdvancedSearch->load();
        $this->_password->AdvancedSearch->load();
        $this->correo->AdvancedSearch->load();
        $this->direccion->AdvancedSearch->load();
        $this->level->AdvancedSearch->load();
        $this->activo->AdvancedSearch->load();
        $this->foto->AdvancedSearch->load();
        $this->fecha_ingreso_cia->AdvancedSearch->load();
        $this->fecha_egreso_cia->AdvancedSearch->load();
        $this->motivo_egreso->AdvancedSearch->load();
        $this->departamento->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->celular_1->AdvancedSearch->load();
        $this->celular_2->AdvancedSearch->load();
        $this->telefono_1->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->hora_entrada->AdvancedSearch->load();
        $this->hora_salida->AdvancedSearch->load();
        $this->proveedor->AdvancedSearch->load();
        $this->seguro->AdvancedSearch->load();
        $this->level_cemantick->AdvancedSearch->load();
        $this->evaluacion->AdvancedSearch->load();
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
            $this->updateSort($this->Nuser); // Nuser
            $this->updateSort($this->cedula); // cedula
            $this->updateSort($this->nombre); // nombre
            $this->updateSort($this->_username); // username
            $this->updateSort($this->level); // level
            $this->updateSort($this->foto); // foto
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
                $this->Nuser->setSort("");
                $this->cedula->setSort("");
                $this->nombre->setSort("");
                $this->_username->setSort("");
                $this->_password->setSort("");
                $this->correo->setSort("");
                $this->direccion->setSort("");
                $this->level->setSort("");
                $this->activo->setSort("");
                $this->foto->setSort("");
                $this->fecha_ingreso_cia->setSort("");
                $this->fecha_egreso_cia->setSort("");
                $this->motivo_egreso->setSort("");
                $this->departamento->setSort("");
                $this->cargo->setSort("");
                $this->celular_1->setSort("");
                $this->celular_2->setSort("");
                $this->telefono_1->setSort("");
                $this->_email->setSort("");
                $this->hora_entrada->setSort("");
                $this->hora_salida->setSort("");
                $this->proveedor->setSort("");
                $this->seguro->setSort("");
                $this->level_cemantick->setSort("");
                $this->evaluacion->setSort("");
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

        // "detail_sco_user_nota"
        $item = &$this->ListOptions->add("detail_sco_user_nota");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_user_nota');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_user_adjunto"
        $item = &$this->ListOptions->add("detail_sco_user_adjunto");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_user_adjunto');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$this->ListOptions->add("details");
            $item->CssClass = "text-nowrap";
            $item->Visible = $this->ShowMultipleDetails && $this->ListOptions->detailVisible();
            $item->OnLeft = true;
            $item->ShowInButtonGroup = false;
            $this->ListOptions->hideDetailItems();
        }

        // Set up detail pages
        $pages = new SubPages();
        $pages->add("sco_user_nota");
        $pages->add("sco_user_adjunto");
        $this->DetailPages = $pages;

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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_user\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_user\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_userlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_userlist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_sco_user_nota"
        $opt = $this->ListOptions["detail_sco_user_nota"];
        if ($Security->allowList(CurrentProjectID() . 'sco_user_nota')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_user_nota", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoUserNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_user&" . GetForeignKeyUrl("fk_Nuser", $this->Nuser->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoUserNotaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_user_nota";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_user_nota";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            } else {
                $body = preg_replace('/\b\s+dropdown-toggle\b/', "", $body);
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }

        // "detail_sco_user_adjunto"
        $opt = $this->ListOptions["detail_sco_user_adjunto"];
        if ($Security->allowList(CurrentProjectID() . 'sco_user_adjunto')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_user_adjunto", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoUserAdjuntoList?" . Config("TABLE_SHOW_MASTER") . "=sco_user&" . GetForeignKeyUrl("fk_Nuser", $this->Nuser->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoUserAdjuntoGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_adjunto");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_user_adjunto";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_adjunto");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_user_adjunto";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
                $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
            } else {
                $body = preg_replace('/\b\s+dropdown-toggle\b/', "", $body);
            }
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
            $opt->Body = $body;
            if ($this->ShowMultipleDetails) {
                $opt->Visible = false;
            }
        }
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar)) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar)) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar)) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-dropdown-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $opt = $this->ListOptions["details"];
            $opt->Body = $body;
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Nuser->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;

        // Preview extension
        $links = "";
        $detailFilters = [];
        $masterKeys = []; // Reset
        $masterKeys["Nuser"] = strval($this->Nuser->DbValue);

        // Column "detail_sco_user_nota"
        if ($this->DetailPages?->getItem("sco_user_nota")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_user_nota')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_user_nota"];
            $detailTbl = Container("sco_user_nota");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoUserNotaPreview?t=sco_user&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_user_nota\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_user')) {
                $label = $Language->tablePhrase("sco_user_nota", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_user_nota\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoUserNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_user");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_user_nota", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoUserNotaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_nota"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_nota"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($editurl) . "\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $link = "<li class=\"nav-item\">" . $btngrp . $link . "</li>";  // Note: Place $btngrp before $link
                $links .= $link;
                $option->Body .= "<div class=\"ew-preview d-none\">" . $link . "</div>";
            }
        }
        $masterKeys = []; // Reset
        $masterKeys["Nuser"] = strval($this->Nuser->DbValue);

        // Column "detail_sco_user_adjunto"
        if ($this->DetailPages?->getItem("sco_user_adjunto")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_user_adjunto')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_user_adjunto"];
            $detailTbl = Container("sco_user_adjunto");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoUserAdjuntoPreview?t=sco_user&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_user_adjunto\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_user')) {
                $label = $Language->tablePhrase("sco_user_adjunto", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_user_adjunto\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoUserAdjuntoList?" . Config("TABLE_SHOW_MASTER") . "=sco_user");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_user_adjunto", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoUserAdjuntoGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_adjunto"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_user')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_adjunto"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($editurl) . "\">" . $caption . "</a>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $link = "<li class=\"nav-item\">" . $btngrp . $link . "</li>";  // Note: Place $btngrp before $link
                $links .= $link;
                $option->Body .= "<div class=\"ew-preview d-none\">" . $link . "</div>";
            }
        }

        // Add row attributes for expandable row
        if ($this->RowType == RowType::VIEW) {
            $this->RowAttrs["data-widget"] = "expandable-table";
            $this->RowAttrs["aria-expanded"] = "false";
        }

        // Column "preview"
        $option = $this->ListOptions["preview"];
        if (!$option) { // Add preview column
            $option = &$this->ListOptions->add("preview");
            $option->OnLeft = true;
            $checkboxPos = $this->ListOptions->itemPos("checkbox");
            $pos = $checkboxPos === false
                ? ($option->OnLeft ? 0 : -1)
                : ($option->OnLeft ? $checkboxPos + 1 : $checkboxPos);
            $option->moveTo($pos);
            $option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit());
            $option->ShowInDropDown = false;
            $option->ShowInButtonGroup = false;
        }
        if ($option) {
            $icon = "fa-solid fa-caret-right fa-fw"; // Right
            if (property_exists($this, "MultiColumnLayout") && $this->MultiColumnLayout == "table") {
                $option->CssStyle = "width: 1%;";
                if (!$option->OnLeft) {
                    $icon = preg_replace('/\\bright\\b/', "left", $icon);
                }
            }
            if (IsRTL()) { // Reverse
                if (preg_match('/\\bleft\\b/', $icon)) {
                    $icon = preg_replace('/\\bleft\\b/', "right", $icon);
                } elseif (preg_match('/\\bright\\b/', $icon)) {
                    $icon = preg_replace('/\\bright\\b/', "left", $icon);
                }
            }
            $option->Body = "<i role=\"button\" class=\"ew-preview-btn expandable-table-caret ew-icon " . $icon . "\"></i>" .
                "<div class=\"ew-preview d-none\">" . $links . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }

        // Column "details" (Multiple details)
        $option = $this->ListOptions["details"];
        if ($option) {
            $option->Body .= "<div class=\"ew-preview d-none\">" . $links . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_user\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
        $item = &$option->add("detailadd_sco_user_nota");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_nota");
        $detailPage = Container("ScoUserNotaGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_user') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_user_nota";
        }
        $item = &$option->add("detailadd_sco_user_adjunto");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_user_adjunto");
        $detailPage = Container("ScoUserAdjuntoGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_user') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_user_adjunto";
        }

        // Add multiple details
        if ($this->ShowMultipleDetails) {
            $item = &$option->add("detailsadd");
            $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailTableLink);
            $caption = $Language->phrase("AddMasterDetailLink");
            $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
            $item->Visible = $detailTableLink != "" && $Security->canAdd();
            // Hide single master/detail items
            $ar = explode(",", $detailTableLink);
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                if ($item = $option["detailadd_" . $ar[$i]]) {
                    $item->Visible = false;
                }
            }
        }
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "Nuser");
            $this->createColumnOption($option, "cedula");
            $this->createColumnOption($option, "nombre");
            $this->createColumnOption($option, "username");
            $this->createColumnOption($option, "level");
            $this->createColumnOption($option, "foto");
        }
        if (UserProfile::$FORCE_LOGOUT_USER) {
            $this->ListActions["forcelogoutuser"] = new ForceLogoutUserAction();
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_usersrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_usersrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
        if (UserProfile::$FORCE_LOGOUT_USER) {
            if (IsAdmin()) {
                $activeUserCount = $this->getConnection()->fetchOne("SELECT COUNT(*) FROM " . $this->getSqlFrom() . " WHERE " . $this->activeUserFilter());
                $showActiveUser = Param("activeuser", "");
                if ($showActiveUser != "") {
                    $_SESSION[SESSION_ACTIVE_USERS] = $showActiveUser;
                } elseif (Session(SESSION_ACTIVE_USERS) != "") {
                    $showActiveUser = Session(SESSION_ACTIVE_USERS);
                }
                if ($showActiveUser == "1" && $activeUserCount > 0) {
                    AddFilter($this->Filter, $this->activeUserFilter());
                }
                $message = str_replace("%n", $activeUserCount, $Language->phrase("ShowActiveUsers"));
                $item = &$this->HeaderOptions->add("activeuser");
                $checked = $showActiveUser == "1" ? " checked" : "";
                $item->Body = "<div class=\"form-check\"><input type=\"checkbox\" name=\"activeuser\" id=\"activeuser\" class=\"form-check-input\" data-ew-action=\"active-user\"{$checked}>" . $message . "</div>";
                $item->Visible = $activeUserCount > 0;
                $item->ShowInDropDown = false;
                $item->ShowInButtonGroup = false;
            }
        }
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_userlist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                        $userlist = implode(",", array_column($rows, Config("LOGIN_USERNAME_FIELD_NAME")));
                        $this->setSuccessMessage(str_replace("%u", $userlist, $listAction->SuccessMessage));
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
                        $user = $row[Config("LOGIN_USERNAME_FIELD_NAME")];
                        $this->setFailureMessage(str_replace("%u", $user, $listAction->FailureMessage));
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_user", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_sco_user",
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

        // Nuser
        if ($this->Nuser->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Nuser->AdvancedSearch->SearchValue != "" || $this->Nuser->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // nombre
        if ($this->nombre->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre->AdvancedSearch->SearchValue != "" || $this->nombre->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // username
        if ($this->_username->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_username->AdvancedSearch->SearchValue != "" || $this->_username->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // password
        if ($this->_password->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_password->AdvancedSearch->SearchValue != "" || $this->_password->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // correo
        if ($this->correo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->correo->AdvancedSearch->SearchValue != "" || $this->correo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // direccion
        if ($this->direccion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->direccion->AdvancedSearch->SearchValue != "" || $this->direccion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // level
        if ($this->level->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->level->AdvancedSearch->SearchValue != "" || $this->level->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // activo
        if ($this->activo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->activo->AdvancedSearch->SearchValue != "" || $this->activo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // foto
        if ($this->foto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->foto->AdvancedSearch->SearchValue != "" || $this->foto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_ingreso_cia
        if ($this->fecha_ingreso_cia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_ingreso_cia->AdvancedSearch->SearchValue != "" || $this->fecha_ingreso_cia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_egreso_cia
        if ($this->fecha_egreso_cia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_egreso_cia->AdvancedSearch->SearchValue != "" || $this->fecha_egreso_cia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // motivo_egreso
        if ($this->motivo_egreso->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->motivo_egreso->AdvancedSearch->SearchValue != "" || $this->motivo_egreso->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // departamento
        if ($this->departamento->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->departamento->AdvancedSearch->SearchValue != "" || $this->departamento->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cargo
        if ($this->cargo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cargo->AdvancedSearch->SearchValue != "" || $this->cargo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // celular_1
        if ($this->celular_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->celular_1->AdvancedSearch->SearchValue != "" || $this->celular_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // celular_2
        if ($this->celular_2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->celular_2->AdvancedSearch->SearchValue != "" || $this->celular_2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telefono_1
        if ($this->telefono_1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telefono_1->AdvancedSearch->SearchValue != "" || $this->telefono_1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // hora_entrada
        if ($this->hora_entrada->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_entrada->AdvancedSearch->SearchValue != "" || $this->hora_entrada->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // hora_salida
        if ($this->hora_salida->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_salida->AdvancedSearch->SearchValue != "" || $this->hora_salida->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // proveedor
        if ($this->proveedor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->proveedor->AdvancedSearch->SearchValue != "" || $this->proveedor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // seguro
        if ($this->seguro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->seguro->AdvancedSearch->SearchValue != "" || $this->seguro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // level_cemantick
        if ($this->level_cemantick->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->level_cemantick->AdvancedSearch->SearchValue != "" || $this->level_cemantick->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // evaluacion
        if ($this->evaluacion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->evaluacion->AdvancedSearch->SearchValue != "" || $this->evaluacion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->Nuser->setDbValue($row['Nuser']);
        $this->cedula->setDbValue($row['cedula']);
        $this->nombre->setDbValue($row['nombre']);
        $this->_username->setDbValue($row['username']);
        $this->_password->setDbValue($row['password']);
        $this->correo->setDbValue($row['correo']);
        $this->direccion->setDbValue($row['direccion']);
        $this->level->setDbValue($row['level']);
        $this->activo->setDbValue($row['activo']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->fecha_ingreso_cia->setDbValue($row['fecha_ingreso_cia']);
        $this->fecha_egreso_cia->setDbValue($row['fecha_egreso_cia']);
        $this->motivo_egreso->setDbValue($row['motivo_egreso']);
        $this->departamento->setDbValue($row['departamento']);
        $this->cargo->setDbValue($row['cargo']);
        $this->celular_1->setDbValue($row['celular_1']);
        $this->celular_2->setDbValue($row['celular_2']);
        $this->telefono_1->setDbValue($row['telefono_1']);
        $this->_email->setDbValue($row['email']);
        $this->hora_entrada->setDbValue($row['hora_entrada']);
        $this->hora_salida->setDbValue($row['hora_salida']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->seguro->setDbValue($row['seguro']);
        $this->level_cemantick->setDbValue($row['level_cemantick']);
        $this->evaluacion->setDbValue($row['evaluacion']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nuser'] = $this->Nuser->DefaultValue;
        $row['cedula'] = $this->cedula->DefaultValue;
        $row['nombre'] = $this->nombre->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['password'] = $this->_password->DefaultValue;
        $row['correo'] = $this->correo->DefaultValue;
        $row['direccion'] = $this->direccion->DefaultValue;
        $row['level'] = $this->level->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
        $row['foto'] = $this->foto->DefaultValue;
        $row['fecha_ingreso_cia'] = $this->fecha_ingreso_cia->DefaultValue;
        $row['fecha_egreso_cia'] = $this->fecha_egreso_cia->DefaultValue;
        $row['motivo_egreso'] = $this->motivo_egreso->DefaultValue;
        $row['departamento'] = $this->departamento->DefaultValue;
        $row['cargo'] = $this->cargo->DefaultValue;
        $row['celular_1'] = $this->celular_1->DefaultValue;
        $row['celular_2'] = $this->celular_2->DefaultValue;
        $row['telefono_1'] = $this->telefono_1->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['hora_entrada'] = $this->hora_entrada->DefaultValue;
        $row['hora_salida'] = $this->hora_salida->DefaultValue;
        $row['proveedor'] = $this->proveedor->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['level_cemantick'] = $this->level_cemantick->DefaultValue;
        $row['evaluacion'] = $this->evaluacion->DefaultValue;
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

        // Nuser

        // cedula

        // nombre

        // username

        // password

        // correo

        // direccion

        // level

        // activo

        // foto

        // fecha_ingreso_cia

        // fecha_egreso_cia

        // motivo_egreso

        // departamento

        // cargo

        // celular_1

        // celular_2

        // telefono_1

        // email

        // hora_entrada

        // hora_salida

        // proveedor

        // seguro

        // level_cemantick

        // evaluacion

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nuser
            $this->Nuser->ViewValue = $this->Nuser->CurrentValue;

            // cedula
            $this->cedula->ViewValue = $this->cedula->CurrentValue;

            // nombre
            $this->nombre->ViewValue = $this->nombre->CurrentValue;

            // username
            $this->_username->ViewValue = $this->_username->CurrentValue;

            // correo
            $this->correo->ViewValue = $this->correo->CurrentValue;

            // direccion
            $this->direccion->ViewValue = $this->direccion->CurrentValue;

            // level
            if ($Security->canAdmin()) { // System admin
                $curVal = strval($this->level->CurrentValue);
                if ($curVal != "") {
                    $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                    if ($this->level->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->level->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $curVal, $this->level->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                        $sqlWrk = $this->level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                            $this->level->ViewValue = $this->level->displayValue($arwrk);
                        } else {
                            $this->level->ViewValue = $this->level->CurrentValue;
                        }
                    }
                } else {
                    $this->level->ViewValue = null;
                }
            } else {
                $this->level->ViewValue = $Language->phrase("PasswordMask");
            }

            // activo
            if (strval($this->activo->CurrentValue) != "") {
                $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
            } else {
                $this->activo->ViewValue = null;
            }

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageWidth = 120;
                $this->foto->ImageHeight = 120;
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->ImageCssClass = "ew-image";
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }

            // fecha_ingreso_cia
            $this->fecha_ingreso_cia->ViewValue = $this->fecha_ingreso_cia->CurrentValue;
            $this->fecha_ingreso_cia->ViewValue = FormatDateTime($this->fecha_ingreso_cia->ViewValue, $this->fecha_ingreso_cia->formatPattern());

            // fecha_egreso_cia
            $this->fecha_egreso_cia->ViewValue = $this->fecha_egreso_cia->CurrentValue;
            $this->fecha_egreso_cia->ViewValue = FormatDateTime($this->fecha_egreso_cia->ViewValue, $this->fecha_egreso_cia->formatPattern());

            // motivo_egreso
            $curVal = strval($this->motivo_egreso->CurrentValue);
            if ($curVal != "") {
                $this->motivo_egreso->ViewValue = $this->motivo_egreso->lookupCacheOption($curVal);
                if ($this->motivo_egreso->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->motivo_egreso->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->motivo_egreso->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->motivo_egreso->getSelectFilter($this); // PHP
                    $sqlWrk = $this->motivo_egreso->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->motivo_egreso->Lookup->renderViewRow($rswrk[0]);
                        $this->motivo_egreso->ViewValue = $this->motivo_egreso->displayValue($arwrk);
                    } else {
                        $this->motivo_egreso->ViewValue = $this->motivo_egreso->CurrentValue;
                    }
                }
            } else {
                $this->motivo_egreso->ViewValue = null;
            }

            // departamento
            $curVal = strval($this->departamento->CurrentValue);
            if ($curVal != "") {
                $this->departamento->ViewValue = $this->departamento->lookupCacheOption($curVal);
                if ($this->departamento->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->departamento->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->departamento->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->departamento->getSelectFilter($this); // PHP
                    $sqlWrk = $this->departamento->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->departamento->Lookup->renderViewRow($rswrk[0]);
                        $this->departamento->ViewValue = $this->departamento->displayValue($arwrk);
                    } else {
                        $this->departamento->ViewValue = $this->departamento->CurrentValue;
                    }
                }
            } else {
                $this->departamento->ViewValue = null;
            }

            // cargo
            $curVal = strval($this->cargo->CurrentValue);
            if ($curVal != "") {
                $this->cargo->ViewValue = $this->cargo->lookupCacheOption($curVal);
                if ($this->cargo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cargo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->cargo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->cargo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->cargo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cargo->Lookup->renderViewRow($rswrk[0]);
                        $this->cargo->ViewValue = $this->cargo->displayValue($arwrk);
                    } else {
                        $this->cargo->ViewValue = $this->cargo->CurrentValue;
                    }
                }
            } else {
                $this->cargo->ViewValue = null;
            }

            // celular_1
            $this->celular_1->ViewValue = $this->celular_1->CurrentValue;

            // celular_2
            $this->celular_2->ViewValue = $this->celular_2->CurrentValue;

            // telefono_1
            $this->telefono_1->ViewValue = $this->telefono_1->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // hora_entrada
            $this->hora_entrada->ViewValue = $this->hora_entrada->CurrentValue;

            // hora_salida
            $this->hora_salida->ViewValue = $this->hora_salida->CurrentValue;

            // proveedor
            $curVal = strval($this->proveedor->CurrentValue);
            if ($curVal != "") {
                $this->proveedor->ViewValue = $this->proveedor->lookupCacheOption($curVal);
                if ($this->proveedor->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $curVal, $this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                    $sqlWrk = $this->proveedor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->proveedor->Lookup->renderViewRow($rswrk[0]);
                        $this->proveedor->ViewValue = $this->proveedor->displayValue($arwrk);
                    } else {
                        $this->proveedor->ViewValue = $this->proveedor->CurrentValue;
                    }
                }
            } else {
                $this->proveedor->ViewValue = null;
            }

            // seguro
            $curVal = strval($this->seguro->CurrentValue);
            if ($curVal != "") {
                $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
                if ($this->seguro->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                    $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->seguro->Lookup->renderViewRow($rswrk[0]);
                        $this->seguro->ViewValue = $this->seguro->displayValue($arwrk);
                    } else {
                        $this->seguro->ViewValue = $this->seguro->CurrentValue;
                    }
                }
            } else {
                $this->seguro->ViewValue = null;
            }

            // level_cemantick
            $this->level_cemantick->ViewValue = $this->level_cemantick->CurrentValue;

            // evaluacion
            if (strval($this->evaluacion->CurrentValue) != "") {
                $this->evaluacion->ViewValue = $this->evaluacion->optionCaption($this->evaluacion->CurrentValue);
            } else {
                $this->evaluacion->ViewValue = null;
            }

            // Nuser
            $this->Nuser->HrefValue = "";
            $this->Nuser->TooltipValue = "";

            // cedula
            $this->cedula->HrefValue = "";
            $this->cedula->TooltipValue = "";

            // nombre
            $this->nombre->HrefValue = "";
            $this->nombre->TooltipValue = "";

            // username
            $this->_username->HrefValue = "";
            $this->_username->TooltipValue = "";

            // level
            $this->level->HrefValue = "";
            $this->level->TooltipValue = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = GetFileUploadUrl($this->foto, $this->foto->htmlDecode($this->foto->Upload->DbValue)); // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";
            if ($this->foto->UseColorbox) {
                if (EmptyValue($this->foto->TooltipValue)) {
                    $this->foto->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->foto->LinkAttrs["data-rel"] = "sco_user_x" . $this->RowCount . "_foto";
                $this->foto->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == RowType::SEARCH) {
            // Nuser
            $this->Nuser->setupEditAttributes();
            $this->Nuser->EditValue = $this->Nuser->AdvancedSearch->SearchValue;
            $this->Nuser->PlaceHolder = RemoveHtml($this->Nuser->caption());

            // cedula
            $this->cedula->setupEditAttributes();
            if (!$this->cedula->Raw) {
                $this->cedula->AdvancedSearch->SearchValue = HtmlDecode($this->cedula->AdvancedSearch->SearchValue);
            }
            $this->cedula->EditValue = HtmlEncode($this->cedula->AdvancedSearch->SearchValue);
            $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

            // nombre
            $this->nombre->setupEditAttributes();
            if (!$this->nombre->Raw) {
                $this->nombre->AdvancedSearch->SearchValue = HtmlDecode($this->nombre->AdvancedSearch->SearchValue);
            }
            $this->nombre->EditValue = HtmlEncode($this->nombre->AdvancedSearch->SearchValue);
            $this->nombre->PlaceHolder = RemoveHtml($this->nombre->caption());

            // username
            $this->_username->setupEditAttributes();
            if (!$this->_username->Raw) {
                $this->_username->AdvancedSearch->SearchValue = HtmlDecode($this->_username->AdvancedSearch->SearchValue);
            }
            $this->_username->EditValue = HtmlEncode($this->_username->AdvancedSearch->SearchValue);
            $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

            // level
            if (!$Security->canAdmin()) { // System admin
                $this->level->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->level->AdvancedSearch->SearchValue));
                if ($curVal != "") {
                    $this->level->AdvancedSearch->ViewValue = $this->level->lookupCacheOption($curVal);
                } else {
                    $this->level->AdvancedSearch->ViewValue = $this->level->Lookup !== null && is_array($this->level->lookupOptions()) && count($this->level->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->level->AdvancedSearch->ViewValue !== null) { // Load from cache
                    $this->level->EditValue = array_values($this->level->lookupOptions());
                    if ($this->level->AdvancedSearch->ViewValue == "") {
                        $this->level->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                    }
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->level->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $this->level->AdvancedSearch->SearchValue, $this->level->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->level->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                        $this->level->AdvancedSearch->ViewValue = $this->level->displayValue($arwrk);
                    } else {
                        $this->level->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                    }
                    $arwrk = $rswrk;
                    $this->level->EditValue = $arwrk;
                }
                $this->level->PlaceHolder = RemoveHtml($this->level->caption());
            }

            // foto
            $this->foto->setupEditAttributes();
            if (!$this->foto->Raw) {
                $this->foto->AdvancedSearch->SearchValue = HtmlDecode($this->foto->AdvancedSearch->SearchValue);
            }
            $this->foto->EditValue = HtmlEncode($this->foto->AdvancedSearch->SearchValue);
            $this->foto->PlaceHolder = RemoveHtml($this->foto->caption());
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
        $this->Nuser->AdvancedSearch->load();
        $this->cedula->AdvancedSearch->load();
        $this->nombre->AdvancedSearch->load();
        $this->_username->AdvancedSearch->load();
        $this->_password->AdvancedSearch->load();
        $this->correo->AdvancedSearch->load();
        $this->direccion->AdvancedSearch->load();
        $this->level->AdvancedSearch->load();
        $this->activo->AdvancedSearch->load();
        $this->foto->AdvancedSearch->load();
        $this->fecha_ingreso_cia->AdvancedSearch->load();
        $this->fecha_egreso_cia->AdvancedSearch->load();
        $this->motivo_egreso->AdvancedSearch->load();
        $this->departamento->AdvancedSearch->load();
        $this->cargo->AdvancedSearch->load();
        $this->celular_1->AdvancedSearch->load();
        $this->celular_2->AdvancedSearch->load();
        $this->telefono_1->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->hora_entrada->AdvancedSearch->load();
        $this->hora_salida->AdvancedSearch->load();
        $this->proveedor->AdvancedSearch->load();
        $this->seguro->AdvancedSearch->load();
        $this->level_cemantick->AdvancedSearch->load();
        $this->evaluacion->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_usersrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_level":
                    break;
                case "x_activo":
                    break;
                case "x_motivo_egreso":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_departamento":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_cargo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_proveedor":
                    break;
                case "x_seguro":
                    break;
                case "x_evaluacion":
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
