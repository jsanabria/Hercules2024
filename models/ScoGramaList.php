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
class ScoGramaList extends ScoGrama
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoGramaList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_gramalist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoGramaList";

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
        $this->Ngrama->setVisibility();
        $this->ci_solicitante->setVisibility();
        $this->solicitante->setVisibility();
        $this->telefono1->Visible = false;
        $this->telefono2->Visible = false;
        $this->_email->Visible = false;
        $this->tipo->setVisibility();
        $this->subtipo->Visible = false;
        $this->monto->setVisibility();
        $this->tasa->Visible = false;
        $this->monto_bs->Visible = false;
        $this->nota->Visible = false;
        $this->contrato->setVisibility();
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->Visible = false;
        $this->ci_difunto->Visible = false;
        $this->apellido1->Visible = false;
        $this->apellido2->Visible = false;
        $this->nombre1->Visible = false;
        $this->nombre2->Visible = false;
        $this->fecha_solucion->Visible = false;
        $this->fecha_desde->Visible = false;
        $this->fecha_hasta->Visible = false;
        $this->estatus->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->usuario_registro->Visible = false;
        $this->email_renovacion->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_grama';
        $this->TableName = 'sco_grama';

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

        // Table object (sco_grama)
        if (!isset($GLOBALS["sco_grama"]) || $GLOBALS["sco_grama"]::class == PROJECT_NAMESPACE . "sco_grama") {
            $GLOBALS["sco_grama"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoGramaAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoGramaDelete";
        $this->MultiUpdateUrl = "ScoGramaUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_grama');
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
                    $result["view"] = SameString($pageName, "ScoGramaView"); // If View page, no primary button
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
            $key .= @$ar['Ngrama'];
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
            $this->Ngrama->Visible = false;
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
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->subtipo);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->email_renovacion);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_gramagrid";
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
        $filterList = Concat($filterList, $this->Ngrama->AdvancedSearch->toJson(), ","); // Field Ngrama
        $filterList = Concat($filterList, $this->ci_solicitante->AdvancedSearch->toJson(), ","); // Field ci_solicitante
        $filterList = Concat($filterList, $this->solicitante->AdvancedSearch->toJson(), ","); // Field solicitante
        $filterList = Concat($filterList, $this->telefono1->AdvancedSearch->toJson(), ","); // Field telefono1
        $filterList = Concat($filterList, $this->telefono2->AdvancedSearch->toJson(), ","); // Field telefono2
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->tipo->AdvancedSearch->toJson(), ","); // Field tipo
        $filterList = Concat($filterList, $this->subtipo->AdvancedSearch->toJson(), ","); // Field subtipo
        $filterList = Concat($filterList, $this->monto->AdvancedSearch->toJson(), ","); // Field monto
        $filterList = Concat($filterList, $this->tasa->AdvancedSearch->toJson(), ","); // Field tasa
        $filterList = Concat($filterList, $this->monto_bs->AdvancedSearch->toJson(), ","); // Field monto_bs
        $filterList = Concat($filterList, $this->nota->AdvancedSearch->toJson(), ","); // Field nota
        $filterList = Concat($filterList, $this->contrato->AdvancedSearch->toJson(), ","); // Field contrato
        $filterList = Concat($filterList, $this->seccion->AdvancedSearch->toJson(), ","); // Field seccion
        $filterList = Concat($filterList, $this->modulo->AdvancedSearch->toJson(), ","); // Field modulo
        $filterList = Concat($filterList, $this->sub_seccion->AdvancedSearch->toJson(), ","); // Field sub_seccion
        $filterList = Concat($filterList, $this->parcela->AdvancedSearch->toJson(), ","); // Field parcela
        $filterList = Concat($filterList, $this->boveda->AdvancedSearch->toJson(), ","); // Field boveda
        $filterList = Concat($filterList, $this->ci_difunto->AdvancedSearch->toJson(), ","); // Field ci_difunto
        $filterList = Concat($filterList, $this->apellido1->AdvancedSearch->toJson(), ","); // Field apellido1
        $filterList = Concat($filterList, $this->apellido2->AdvancedSearch->toJson(), ","); // Field apellido2
        $filterList = Concat($filterList, $this->nombre1->AdvancedSearch->toJson(), ","); // Field nombre1
        $filterList = Concat($filterList, $this->nombre2->AdvancedSearch->toJson(), ","); // Field nombre2
        $filterList = Concat($filterList, $this->fecha_solucion->AdvancedSearch->toJson(), ","); // Field fecha_solucion
        $filterList = Concat($filterList, $this->fecha_desde->AdvancedSearch->toJson(), ","); // Field fecha_desde
        $filterList = Concat($filterList, $this->fecha_hasta->AdvancedSearch->toJson(), ","); // Field fecha_hasta
        $filterList = Concat($filterList, $this->estatus->AdvancedSearch->toJson(), ","); // Field estatus
        $filterList = Concat($filterList, $this->fecha_registro->AdvancedSearch->toJson(), ","); // Field fecha_registro
        $filterList = Concat($filterList, $this->usuario_registro->AdvancedSearch->toJson(), ","); // Field usuario_registro
        $filterList = Concat($filterList, $this->email_renovacion->AdvancedSearch->toJson(), ","); // Field email_renovacion
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
            Profile()->setSearchFilters("fsco_gramasrch", $filters);
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

        // Field Ngrama
        $this->Ngrama->AdvancedSearch->SearchValue = @$filter["x_Ngrama"];
        $this->Ngrama->AdvancedSearch->SearchOperator = @$filter["z_Ngrama"];
        $this->Ngrama->AdvancedSearch->SearchCondition = @$filter["v_Ngrama"];
        $this->Ngrama->AdvancedSearch->SearchValue2 = @$filter["y_Ngrama"];
        $this->Ngrama->AdvancedSearch->SearchOperator2 = @$filter["w_Ngrama"];
        $this->Ngrama->AdvancedSearch->save();

        // Field ci_solicitante
        $this->ci_solicitante->AdvancedSearch->SearchValue = @$filter["x_ci_solicitante"];
        $this->ci_solicitante->AdvancedSearch->SearchOperator = @$filter["z_ci_solicitante"];
        $this->ci_solicitante->AdvancedSearch->SearchCondition = @$filter["v_ci_solicitante"];
        $this->ci_solicitante->AdvancedSearch->SearchValue2 = @$filter["y_ci_solicitante"];
        $this->ci_solicitante->AdvancedSearch->SearchOperator2 = @$filter["w_ci_solicitante"];
        $this->ci_solicitante->AdvancedSearch->save();

        // Field solicitante
        $this->solicitante->AdvancedSearch->SearchValue = @$filter["x_solicitante"];
        $this->solicitante->AdvancedSearch->SearchOperator = @$filter["z_solicitante"];
        $this->solicitante->AdvancedSearch->SearchCondition = @$filter["v_solicitante"];
        $this->solicitante->AdvancedSearch->SearchValue2 = @$filter["y_solicitante"];
        $this->solicitante->AdvancedSearch->SearchOperator2 = @$filter["w_solicitante"];
        $this->solicitante->AdvancedSearch->save();

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

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field tipo
        $this->tipo->AdvancedSearch->SearchValue = @$filter["x_tipo"];
        $this->tipo->AdvancedSearch->SearchOperator = @$filter["z_tipo"];
        $this->tipo->AdvancedSearch->SearchCondition = @$filter["v_tipo"];
        $this->tipo->AdvancedSearch->SearchValue2 = @$filter["y_tipo"];
        $this->tipo->AdvancedSearch->SearchOperator2 = @$filter["w_tipo"];
        $this->tipo->AdvancedSearch->save();

        // Field subtipo
        $this->subtipo->AdvancedSearch->SearchValue = @$filter["x_subtipo"];
        $this->subtipo->AdvancedSearch->SearchOperator = @$filter["z_subtipo"];
        $this->subtipo->AdvancedSearch->SearchCondition = @$filter["v_subtipo"];
        $this->subtipo->AdvancedSearch->SearchValue2 = @$filter["y_subtipo"];
        $this->subtipo->AdvancedSearch->SearchOperator2 = @$filter["w_subtipo"];
        $this->subtipo->AdvancedSearch->save();

        // Field monto
        $this->monto->AdvancedSearch->SearchValue = @$filter["x_monto"];
        $this->monto->AdvancedSearch->SearchOperator = @$filter["z_monto"];
        $this->monto->AdvancedSearch->SearchCondition = @$filter["v_monto"];
        $this->monto->AdvancedSearch->SearchValue2 = @$filter["y_monto"];
        $this->monto->AdvancedSearch->SearchOperator2 = @$filter["w_monto"];
        $this->monto->AdvancedSearch->save();

        // Field tasa
        $this->tasa->AdvancedSearch->SearchValue = @$filter["x_tasa"];
        $this->tasa->AdvancedSearch->SearchOperator = @$filter["z_tasa"];
        $this->tasa->AdvancedSearch->SearchCondition = @$filter["v_tasa"];
        $this->tasa->AdvancedSearch->SearchValue2 = @$filter["y_tasa"];
        $this->tasa->AdvancedSearch->SearchOperator2 = @$filter["w_tasa"];
        $this->tasa->AdvancedSearch->save();

        // Field monto_bs
        $this->monto_bs->AdvancedSearch->SearchValue = @$filter["x_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchOperator = @$filter["z_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchCondition = @$filter["v_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchValue2 = @$filter["y_monto_bs"];
        $this->monto_bs->AdvancedSearch->SearchOperator2 = @$filter["w_monto_bs"];
        $this->monto_bs->AdvancedSearch->save();

        // Field nota
        $this->nota->AdvancedSearch->SearchValue = @$filter["x_nota"];
        $this->nota->AdvancedSearch->SearchOperator = @$filter["z_nota"];
        $this->nota->AdvancedSearch->SearchCondition = @$filter["v_nota"];
        $this->nota->AdvancedSearch->SearchValue2 = @$filter["y_nota"];
        $this->nota->AdvancedSearch->SearchOperator2 = @$filter["w_nota"];
        $this->nota->AdvancedSearch->save();

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

        // Field ci_difunto
        $this->ci_difunto->AdvancedSearch->SearchValue = @$filter["x_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchOperator = @$filter["z_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchCondition = @$filter["v_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchValue2 = @$filter["y_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->SearchOperator2 = @$filter["w_ci_difunto"];
        $this->ci_difunto->AdvancedSearch->save();

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

        // Field fecha_solucion
        $this->fecha_solucion->AdvancedSearch->SearchValue = @$filter["x_fecha_solucion"];
        $this->fecha_solucion->AdvancedSearch->SearchOperator = @$filter["z_fecha_solucion"];
        $this->fecha_solucion->AdvancedSearch->SearchCondition = @$filter["v_fecha_solucion"];
        $this->fecha_solucion->AdvancedSearch->SearchValue2 = @$filter["y_fecha_solucion"];
        $this->fecha_solucion->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_solucion"];
        $this->fecha_solucion->AdvancedSearch->save();

        // Field fecha_desde
        $this->fecha_desde->AdvancedSearch->SearchValue = @$filter["x_fecha_desde"];
        $this->fecha_desde->AdvancedSearch->SearchOperator = @$filter["z_fecha_desde"];
        $this->fecha_desde->AdvancedSearch->SearchCondition = @$filter["v_fecha_desde"];
        $this->fecha_desde->AdvancedSearch->SearchValue2 = @$filter["y_fecha_desde"];
        $this->fecha_desde->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_desde"];
        $this->fecha_desde->AdvancedSearch->save();

        // Field fecha_hasta
        $this->fecha_hasta->AdvancedSearch->SearchValue = @$filter["x_fecha_hasta"];
        $this->fecha_hasta->AdvancedSearch->SearchOperator = @$filter["z_fecha_hasta"];
        $this->fecha_hasta->AdvancedSearch->SearchCondition = @$filter["v_fecha_hasta"];
        $this->fecha_hasta->AdvancedSearch->SearchValue2 = @$filter["y_fecha_hasta"];
        $this->fecha_hasta->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_hasta"];
        $this->fecha_hasta->AdvancedSearch->save();

        // Field estatus
        $this->estatus->AdvancedSearch->SearchValue = @$filter["x_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator = @$filter["z_estatus"];
        $this->estatus->AdvancedSearch->SearchCondition = @$filter["v_estatus"];
        $this->estatus->AdvancedSearch->SearchValue2 = @$filter["y_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator2 = @$filter["w_estatus"];
        $this->estatus->AdvancedSearch->save();

        // Field fecha_registro
        $this->fecha_registro->AdvancedSearch->SearchValue = @$filter["x_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchOperator = @$filter["z_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchCondition = @$filter["v_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchValue2 = @$filter["y_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->save();

        // Field usuario_registro
        $this->usuario_registro->AdvancedSearch->SearchValue = @$filter["x_usuario_registro"];
        $this->usuario_registro->AdvancedSearch->SearchOperator = @$filter["z_usuario_registro"];
        $this->usuario_registro->AdvancedSearch->SearchCondition = @$filter["v_usuario_registro"];
        $this->usuario_registro->AdvancedSearch->SearchValue2 = @$filter["y_usuario_registro"];
        $this->usuario_registro->AdvancedSearch->SearchOperator2 = @$filter["w_usuario_registro"];
        $this->usuario_registro->AdvancedSearch->save();

        // Field email_renovacion
        $this->email_renovacion->AdvancedSearch->SearchValue = @$filter["x_email_renovacion"];
        $this->email_renovacion->AdvancedSearch->SearchOperator = @$filter["z_email_renovacion"];
        $this->email_renovacion->AdvancedSearch->SearchCondition = @$filter["v_email_renovacion"];
        $this->email_renovacion->AdvancedSearch->SearchValue2 = @$filter["y_email_renovacion"];
        $this->email_renovacion->AdvancedSearch->SearchOperator2 = @$filter["w_email_renovacion"];
        $this->email_renovacion->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->Ngrama, $default, false); // Ngrama
        $this->buildSearchSql($where, $this->ci_solicitante, $default, false); // ci_solicitante
        $this->buildSearchSql($where, $this->solicitante, $default, false); // solicitante
        $this->buildSearchSql($where, $this->telefono1, $default, false); // telefono1
        $this->buildSearchSql($where, $this->telefono2, $default, false); // telefono2
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->tipo, $default, false); // tipo
        $this->buildSearchSql($where, $this->subtipo, $default, false); // subtipo
        $this->buildSearchSql($where, $this->monto, $default, false); // monto
        $this->buildSearchSql($where, $this->tasa, $default, false); // tasa
        $this->buildSearchSql($where, $this->monto_bs, $default, false); // monto_bs
        $this->buildSearchSql($where, $this->nota, $default, false); // nota
        $this->buildSearchSql($where, $this->contrato, $default, false); // contrato
        $this->buildSearchSql($where, $this->seccion, $default, false); // seccion
        $this->buildSearchSql($where, $this->modulo, $default, false); // modulo
        $this->buildSearchSql($where, $this->sub_seccion, $default, false); // sub_seccion
        $this->buildSearchSql($where, $this->parcela, $default, false); // parcela
        $this->buildSearchSql($where, $this->boveda, $default, false); // boveda
        $this->buildSearchSql($where, $this->ci_difunto, $default, false); // ci_difunto
        $this->buildSearchSql($where, $this->apellido1, $default, false); // apellido1
        $this->buildSearchSql($where, $this->apellido2, $default, false); // apellido2
        $this->buildSearchSql($where, $this->nombre1, $default, false); // nombre1
        $this->buildSearchSql($where, $this->nombre2, $default, false); // nombre2
        $this->buildSearchSql($where, $this->fecha_solucion, $default, false); // fecha_solucion
        $this->buildSearchSql($where, $this->fecha_desde, $default, false); // fecha_desde
        $this->buildSearchSql($where, $this->fecha_hasta, $default, false); // fecha_hasta
        $this->buildSearchSql($where, $this->estatus, $default, false); // estatus
        $this->buildSearchSql($where, $this->fecha_registro, $default, false); // fecha_registro
        $this->buildSearchSql($where, $this->usuario_registro, $default, false); // usuario_registro
        $this->buildSearchSql($where, $this->email_renovacion, $default, false); // email_renovacion

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Ngrama->AdvancedSearch->save(); // Ngrama
            $this->ci_solicitante->AdvancedSearch->save(); // ci_solicitante
            $this->solicitante->AdvancedSearch->save(); // solicitante
            $this->telefono1->AdvancedSearch->save(); // telefono1
            $this->telefono2->AdvancedSearch->save(); // telefono2
            $this->_email->AdvancedSearch->save(); // email
            $this->tipo->AdvancedSearch->save(); // tipo
            $this->subtipo->AdvancedSearch->save(); // subtipo
            $this->monto->AdvancedSearch->save(); // monto
            $this->tasa->AdvancedSearch->save(); // tasa
            $this->monto_bs->AdvancedSearch->save(); // monto_bs
            $this->nota->AdvancedSearch->save(); // nota
            $this->contrato->AdvancedSearch->save(); // contrato
            $this->seccion->AdvancedSearch->save(); // seccion
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->sub_seccion->AdvancedSearch->save(); // sub_seccion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->boveda->AdvancedSearch->save(); // boveda
            $this->ci_difunto->AdvancedSearch->save(); // ci_difunto
            $this->apellido1->AdvancedSearch->save(); // apellido1
            $this->apellido2->AdvancedSearch->save(); // apellido2
            $this->nombre1->AdvancedSearch->save(); // nombre1
            $this->nombre2->AdvancedSearch->save(); // nombre2
            $this->fecha_solucion->AdvancedSearch->save(); // fecha_solucion
            $this->fecha_desde->AdvancedSearch->save(); // fecha_desde
            $this->fecha_hasta->AdvancedSearch->save(); // fecha_hasta
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->usuario_registro->AdvancedSearch->save(); // usuario_registro
            $this->email_renovacion->AdvancedSearch->save(); // email_renovacion

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
            $this->Ngrama->AdvancedSearch->save(); // Ngrama
            $this->ci_solicitante->AdvancedSearch->save(); // ci_solicitante
            $this->solicitante->AdvancedSearch->save(); // solicitante
            $this->telefono1->AdvancedSearch->save(); // telefono1
            $this->telefono2->AdvancedSearch->save(); // telefono2
            $this->_email->AdvancedSearch->save(); // email
            $this->tipo->AdvancedSearch->save(); // tipo
            $this->subtipo->AdvancedSearch->save(); // subtipo
            $this->monto->AdvancedSearch->save(); // monto
            $this->tasa->AdvancedSearch->save(); // tasa
            $this->monto_bs->AdvancedSearch->save(); // monto_bs
            $this->nota->AdvancedSearch->save(); // nota
            $this->contrato->AdvancedSearch->save(); // contrato
            $this->seccion->AdvancedSearch->save(); // seccion
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->sub_seccion->AdvancedSearch->save(); // sub_seccion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->boveda->AdvancedSearch->save(); // boveda
            $this->ci_difunto->AdvancedSearch->save(); // ci_difunto
            $this->apellido1->AdvancedSearch->save(); // apellido1
            $this->apellido2->AdvancedSearch->save(); // apellido2
            $this->nombre1->AdvancedSearch->save(); // nombre1
            $this->nombre2->AdvancedSearch->save(); // nombre2
            $this->fecha_solucion->AdvancedSearch->save(); // fecha_solucion
            $this->fecha_desde->AdvancedSearch->save(); // fecha_desde
            $this->fecha_hasta->AdvancedSearch->save(); // fecha_hasta
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->usuario_registro->AdvancedSearch->save(); // usuario_registro
            $this->email_renovacion->AdvancedSearch->save(); // email_renovacion
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

        // Field Ngrama
        $filter = $this->queryBuilderWhere("Ngrama");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->Ngrama, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->Ngrama->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ci_solicitante
        $filter = $this->queryBuilderWhere("ci_solicitante");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ci_solicitante, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ci_solicitante->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field solicitante
        $filter = $this->queryBuilderWhere("solicitante");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->solicitante, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->solicitante->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipo
        $filter = $this->queryBuilderWhere("tipo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field monto
        $filter = $this->queryBuilderWhere("monto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->monto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->monto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field estatus
        $filter = $this->queryBuilderWhere("estatus");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->estatus, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->estatus->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecha_registro
        $filter = $this->queryBuilderWhere("fecha_registro");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecha_registro, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecha_registro->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->ci_solicitante;
        $searchFlds[] = &$this->solicitante;
        $searchFlds[] = &$this->telefono1;
        $searchFlds[] = &$this->telefono2;
        $searchFlds[] = &$this->_email;
        $searchFlds[] = &$this->tipo;
        $searchFlds[] = &$this->subtipo;
        $searchFlds[] = &$this->nota;
        $searchFlds[] = &$this->contrato;
        $searchFlds[] = &$this->seccion;
        $searchFlds[] = &$this->modulo;
        $searchFlds[] = &$this->sub_seccion;
        $searchFlds[] = &$this->parcela;
        $searchFlds[] = &$this->boveda;
        $searchFlds[] = &$this->ci_difunto;
        $searchFlds[] = &$this->apellido1;
        $searchFlds[] = &$this->apellido2;
        $searchFlds[] = &$this->nombre1;
        $searchFlds[] = &$this->nombre2;
        $searchFlds[] = &$this->estatus;
        $searchFlds[] = &$this->usuario_registro;
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
        if ($this->Ngrama->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ci_solicitante->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->solicitante->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->subtipo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tasa->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monto_bs->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nota->AdvancedSearch->issetSession()) {
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
        if ($this->ci_difunto->AdvancedSearch->issetSession()) {
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
        if ($this->fecha_solucion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_desde->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_hasta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estatus->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_registro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usuario_registro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->email_renovacion->AdvancedSearch->issetSession()) {
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
        $this->Ngrama->AdvancedSearch->unsetSession();
        $this->ci_solicitante->AdvancedSearch->unsetSession();
        $this->solicitante->AdvancedSearch->unsetSession();
        $this->telefono1->AdvancedSearch->unsetSession();
        $this->telefono2->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->tipo->AdvancedSearch->unsetSession();
        $this->subtipo->AdvancedSearch->unsetSession();
        $this->monto->AdvancedSearch->unsetSession();
        $this->tasa->AdvancedSearch->unsetSession();
        $this->monto_bs->AdvancedSearch->unsetSession();
        $this->nota->AdvancedSearch->unsetSession();
        $this->contrato->AdvancedSearch->unsetSession();
        $this->seccion->AdvancedSearch->unsetSession();
        $this->modulo->AdvancedSearch->unsetSession();
        $this->sub_seccion->AdvancedSearch->unsetSession();
        $this->parcela->AdvancedSearch->unsetSession();
        $this->boveda->AdvancedSearch->unsetSession();
        $this->ci_difunto->AdvancedSearch->unsetSession();
        $this->apellido1->AdvancedSearch->unsetSession();
        $this->apellido2->AdvancedSearch->unsetSession();
        $this->nombre1->AdvancedSearch->unsetSession();
        $this->nombre2->AdvancedSearch->unsetSession();
        $this->fecha_solucion->AdvancedSearch->unsetSession();
        $this->fecha_desde->AdvancedSearch->unsetSession();
        $this->fecha_hasta->AdvancedSearch->unsetSession();
        $this->estatus->AdvancedSearch->unsetSession();
        $this->fecha_registro->AdvancedSearch->unsetSession();
        $this->usuario_registro->AdvancedSearch->unsetSession();
        $this->email_renovacion->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Ngrama->AdvancedSearch->load();
        $this->ci_solicitante->AdvancedSearch->load();
        $this->solicitante->AdvancedSearch->load();
        $this->telefono1->AdvancedSearch->load();
        $this->telefono2->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->tipo->AdvancedSearch->load();
        $this->subtipo->AdvancedSearch->load();
        $this->monto->AdvancedSearch->load();
        $this->tasa->AdvancedSearch->load();
        $this->monto_bs->AdvancedSearch->load();
        $this->nota->AdvancedSearch->load();
        $this->contrato->AdvancedSearch->load();
        $this->seccion->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->sub_seccion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->boveda->AdvancedSearch->load();
        $this->ci_difunto->AdvancedSearch->load();
        $this->apellido1->AdvancedSearch->load();
        $this->apellido2->AdvancedSearch->load();
        $this->nombre1->AdvancedSearch->load();
        $this->nombre2->AdvancedSearch->load();
        $this->fecha_solucion->AdvancedSearch->load();
        $this->fecha_desde->AdvancedSearch->load();
        $this->fecha_hasta->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->usuario_registro->AdvancedSearch->load();
        $this->email_renovacion->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->Ngrama->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->Ngrama); // Ngrama
            $this->updateSort($this->ci_solicitante); // ci_solicitante
            $this->updateSort($this->solicitante); // solicitante
            $this->updateSort($this->tipo); // tipo
            $this->updateSort($this->monto); // monto
            $this->updateSort($this->contrato); // contrato
            $this->updateSort($this->seccion); // seccion
            $this->updateSort($this->modulo); // modulo
            $this->updateSort($this->sub_seccion); // sub_seccion
            $this->updateSort($this->parcela); // parcela
            $this->updateSort($this->estatus); // estatus
            $this->updateSort($this->fecha_registro); // fecha_registro
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
                $this->Ngrama->setSort("");
                $this->ci_solicitante->setSort("");
                $this->solicitante->setSort("");
                $this->telefono1->setSort("");
                $this->telefono2->setSort("");
                $this->_email->setSort("");
                $this->tipo->setSort("");
                $this->subtipo->setSort("");
                $this->monto->setSort("");
                $this->tasa->setSort("");
                $this->monto_bs->setSort("");
                $this->nota->setSort("");
                $this->contrato->setSort("");
                $this->seccion->setSort("");
                $this->modulo->setSort("");
                $this->sub_seccion->setSort("");
                $this->parcela->setSort("");
                $this->boveda->setSort("");
                $this->ci_difunto->setSort("");
                $this->apellido1->setSort("");
                $this->apellido2->setSort("");
                $this->nombre1->setSort("");
                $this->nombre2->setSort("");
                $this->fecha_solucion->setSort("");
                $this->fecha_desde->setSort("");
                $this->fecha_hasta->setSort("");
                $this->estatus->setSort("");
                $this->fecha_registro->setSort("");
                $this->usuario_registro->setSort("");
                $this->email_renovacion->setSort("");
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

        // "detail_sco_grama_pagos"
        $item = &$this->ListOptions->add("detail_sco_grama_pagos");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_grama_pagos');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_grama_nota"
        $item = &$this->ListOptions->add("detail_sco_grama_nota");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_grama_nota');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_grama_adjunto"
        $item = &$this->ListOptions->add("detail_sco_grama_adjunto");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_grama_adjunto');
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
        $pages->add("sco_grama_pagos");
        $pages->add("sco_grama_nota");
        $pages->add("sco_grama_adjunto");
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_grama\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_grama\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_gramalist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_gramalist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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

        // "detail_sco_grama_pagos"
        $opt = $this->ListOptions["detail_sco_grama_pagos"];
        if ($Security->allowList(CurrentProjectID() . 'sco_grama_pagos')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_grama_pagos", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoGramaPagosList?" . Config("TABLE_SHOW_MASTER") . "=sco_grama&" . GetForeignKeyUrl("fk_Ngrama", $this->Ngrama->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoGramaPagosGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_pagos");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_grama_pagos";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_pagos");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_grama_pagos";
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

        // "detail_sco_grama_nota"
        $opt = $this->ListOptions["detail_sco_grama_nota"];
        if ($Security->allowList(CurrentProjectID() . 'sco_grama_nota')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_grama_nota", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoGramaNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_grama&" . GetForeignKeyUrl("fk_Ngrama", $this->Ngrama->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoGramaNotaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_grama_nota";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_grama_nota";
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

        // "detail_sco_grama_adjunto"
        $opt = $this->ListOptions["detail_sco_grama_adjunto"];
        if ($Security->allowList(CurrentProjectID() . 'sco_grama_adjunto')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_grama_adjunto", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoGramaAdjuntoList?" . Config("TABLE_SHOW_MASTER") . "=sco_grama&" . GetForeignKeyUrl("fk_Ngrama", $this->Ngrama->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoGramaAdjuntoGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_adjunto");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_grama_adjunto";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_adjunto");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_grama_adjunto";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Ngrama->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
        $masterKeys["Ngrama"] = strval($this->Ngrama->DbValue);

        // Column "detail_sco_grama_pagos"
        if ($this->DetailPages?->getItem("sco_grama_pagos")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_grama_pagos')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_grama_pagos"];
            $detailTbl = Container("sco_grama_pagos");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoGramaPagosPreview?t=sco_grama&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_grama_pagos\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_grama')) {
                $label = $Language->tablePhrase("sco_grama_pagos", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_grama_pagos\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoGramaPagosList?" . Config("TABLE_SHOW_MASTER") . "=sco_grama");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_grama_pagos", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoGramaPagosGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_pagos"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_pagos"));
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
        $masterKeys["Ngrama"] = strval($this->Ngrama->DbValue);

        // Column "detail_sco_grama_nota"
        if ($this->DetailPages?->getItem("sco_grama_nota")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_grama_nota')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_grama_nota"];
            $detailTbl = Container("sco_grama_nota");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoGramaNotaPreview?t=sco_grama&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_grama_nota\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_grama')) {
                $label = $Language->tablePhrase("sco_grama_nota", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_grama_nota\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoGramaNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_grama");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_grama_nota", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoGramaNotaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_nota"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_nota"));
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
        $masterKeys["Ngrama"] = strval($this->Ngrama->DbValue);

        // Column "detail_sco_grama_adjunto"
        if ($this->DetailPages?->getItem("sco_grama_adjunto")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_grama_adjunto')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_grama_adjunto"];
            $detailTbl = Container("sco_grama_adjunto");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoGramaAdjuntoPreview?t=sco_grama&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_grama_adjunto\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_grama')) {
                $label = $Language->tablePhrase("sco_grama_adjunto", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_grama_adjunto\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoGramaAdjuntoList?" . Config("TABLE_SHOW_MASTER") . "=sco_grama");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_grama_adjunto", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoGramaAdjuntoGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_adjunto"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_grama')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_grama_adjunto"));
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
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "Ngrama");
            $this->createColumnOption($option, "ci_solicitante");
            $this->createColumnOption($option, "solicitante");
            $this->createColumnOption($option, "tipo");
            $this->createColumnOption($option, "monto");
            $this->createColumnOption($option, "contrato");
            $this->createColumnOption($option, "seccion");
            $this->createColumnOption($option, "modulo");
            $this->createColumnOption($option, "sub_seccion");
            $this->createColumnOption($option, "parcela");
            $this->createColumnOption($option, "estatus");
            $this->createColumnOption($option, "fecha_registro");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_gramasrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_gramasrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_gramalist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_grama", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_sco_grama",
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

        // Ngrama
        if ($this->Ngrama->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Ngrama->AdvancedSearch->SearchValue != "" || $this->Ngrama->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ci_solicitante
        if ($this->ci_solicitante->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ci_solicitante->AdvancedSearch->SearchValue != "" || $this->ci_solicitante->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // email
        if ($this->_email->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_email->AdvancedSearch->SearchValue != "" || $this->_email->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipo
        if ($this->tipo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipo->AdvancedSearch->SearchValue != "" || $this->tipo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // monto
        if ($this->monto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monto->AdvancedSearch->SearchValue != "" || $this->monto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tasa
        if ($this->tasa->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tasa->AdvancedSearch->SearchValue != "" || $this->tasa->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // nota
        if ($this->nota->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nota->AdvancedSearch->SearchValue != "" || $this->nota->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // ci_difunto
        if ($this->ci_difunto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ci_difunto->AdvancedSearch->SearchValue != "" || $this->ci_difunto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // fecha_solucion
        if ($this->fecha_solucion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_solucion->AdvancedSearch->SearchValue != "" || $this->fecha_solucion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_desde
        if ($this->fecha_desde->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_desde->AdvancedSearch->SearchValue != "" || $this->fecha_desde->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_hasta
        if ($this->fecha_hasta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_hasta->AdvancedSearch->SearchValue != "" || $this->fecha_hasta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // fecha_registro
        if ($this->fecha_registro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_registro->AdvancedSearch->SearchValue != "" || $this->fecha_registro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usuario_registro
        if ($this->usuario_registro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usuario_registro->AdvancedSearch->SearchValue != "" || $this->usuario_registro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // email_renovacion
        if ($this->email_renovacion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->email_renovacion->AdvancedSearch->SearchValue != "" || $this->email_renovacion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->Ngrama->setDbValue($row['Ngrama']);
        $this->ci_solicitante->setDbValue($row['ci_solicitante']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->tipo->setDbValue($row['tipo']);
        $this->subtipo->setDbValue($row['subtipo']);
        $this->monto->setDbValue($row['monto']);
        $this->tasa->setDbValue($row['tasa']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->nota->setDbValue($row['nota']);
        $this->contrato->setDbValue($row['contrato']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->apellido1->setDbValue($row['apellido1']);
        $this->apellido2->setDbValue($row['apellido2']);
        $this->nombre1->setDbValue($row['nombre1']);
        $this->nombre2->setDbValue($row['nombre2']);
        $this->fecha_solucion->setDbValue($row['fecha_solucion']);
        $this->fecha_desde->setDbValue($row['fecha_desde']);
        $this->fecha_hasta->setDbValue($row['fecha_hasta']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->usuario_registro->setDbValue($row['usuario_registro']);
        $this->email_renovacion->setDbValue($row['email_renovacion']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ngrama'] = $this->Ngrama->DefaultValue;
        $row['ci_solicitante'] = $this->ci_solicitante->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['subtipo'] = $this->subtipo->DefaultValue;
        $row['monto'] = $this->monto->DefaultValue;
        $row['tasa'] = $this->tasa->DefaultValue;
        $row['monto_bs'] = $this->monto_bs->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['contrato'] = $this->contrato->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['sub_seccion'] = $this->sub_seccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['boveda'] = $this->boveda->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['apellido1'] = $this->apellido1->DefaultValue;
        $row['apellido2'] = $this->apellido2->DefaultValue;
        $row['nombre1'] = $this->nombre1->DefaultValue;
        $row['nombre2'] = $this->nombre2->DefaultValue;
        $row['fecha_solucion'] = $this->fecha_solucion->DefaultValue;
        $row['fecha_desde'] = $this->fecha_desde->DefaultValue;
        $row['fecha_hasta'] = $this->fecha_hasta->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['usuario_registro'] = $this->usuario_registro->DefaultValue;
        $row['email_renovacion'] = $this->email_renovacion->DefaultValue;
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

        // Ngrama

        // ci_solicitante

        // solicitante

        // telefono1

        // telefono2

        // email

        // tipo

        // subtipo

        // monto

        // tasa

        // monto_bs

        // nota

        // contrato

        // seccion

        // modulo

        // sub_seccion

        // parcela

        // boveda

        // ci_difunto

        // apellido1

        // apellido2

        // nombre1

        // nombre2

        // fecha_solucion

        // fecha_desde

        // fecha_hasta

        // estatus

        // fecha_registro

        // usuario_registro

        // email_renovacion

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ngrama
            $this->Ngrama->ViewValue = $this->Ngrama->CurrentValue;

            // ci_solicitante
            $this->ci_solicitante->ViewValue = $this->ci_solicitante->CurrentValue;

            // solicitante
            $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // tipo
            $curVal = strval($this->tipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo->ViewValue = $this->tipo->lookupCacheOption($curVal);
                if ($this->tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo->ViewValue = $this->tipo->displayValue($arwrk);
                    } else {
                        $this->tipo->ViewValue = $this->tipo->CurrentValue;
                    }
                }
            } else {
                $this->tipo->ViewValue = null;
            }

            // subtipo
            $curVal = strval($this->subtipo->CurrentValue);
            if ($curVal != "") {
                $this->subtipo->ViewValue = $this->subtipo->lookupCacheOption($curVal);
                if ($this->subtipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->subtipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->subtipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->subtipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->subtipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->subtipo->Lookup->renderViewRow($rswrk[0]);
                        $this->subtipo->ViewValue = $this->subtipo->displayValue($arwrk);
                    } else {
                        $this->subtipo->ViewValue = $this->subtipo->CurrentValue;
                    }
                }
            } else {
                $this->subtipo->ViewValue = null;
            }

            // monto
            $this->monto->ViewValue = $this->monto->CurrentValue;
            $this->monto->ViewValue = FormatNumber($this->monto->ViewValue, $this->monto->formatPattern());

            // tasa
            $this->tasa->ViewValue = $this->tasa->CurrentValue;
            $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

            // monto_bs
            $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
            $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

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

            // ci_difunto
            $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

            // apellido1
            $this->apellido1->ViewValue = $this->apellido1->CurrentValue;

            // apellido2
            $this->apellido2->ViewValue = $this->apellido2->CurrentValue;

            // nombre1
            $this->nombre1->ViewValue = $this->nombre1->CurrentValue;

            // nombre2
            $this->nombre2->ViewValue = $this->nombre2->CurrentValue;

            // fecha_solucion
            $this->fecha_solucion->ViewValue = $this->fecha_solucion->CurrentValue;
            $this->fecha_solucion->ViewValue = FormatDateTime($this->fecha_solucion->ViewValue, $this->fecha_solucion->formatPattern());

            // fecha_desde
            $this->fecha_desde->ViewValue = $this->fecha_desde->CurrentValue;
            $this->fecha_desde->ViewValue = FormatDateTime($this->fecha_desde->ViewValue, $this->fecha_desde->formatPattern());

            // fecha_hasta
            $this->fecha_hasta->ViewValue = $this->fecha_hasta->CurrentValue;
            $this->fecha_hasta->ViewValue = FormatDateTime($this->fecha_hasta->ViewValue, $this->fecha_hasta->formatPattern());

            // estatus
            $curVal = strval($this->estatus->CurrentValue);
            if ($curVal != "") {
                $this->estatus->ViewValue = $this->estatus->lookupCacheOption($curVal);
                if ($this->estatus->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->estatus->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->estatus->getSelectFilter($this); // PHP
                    $sqlWrk = $this->estatus->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->estatus->Lookup->renderViewRow($rswrk[0]);
                        $this->estatus->ViewValue = $this->estatus->displayValue($arwrk);
                    } else {
                        $this->estatus->ViewValue = $this->estatus->CurrentValue;
                    }
                }
            } else {
                $this->estatus->ViewValue = null;
            }

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // usuario_registro
            $this->usuario_registro->ViewValue = $this->usuario_registro->CurrentValue;

            // email_renovacion
            if (strval($this->email_renovacion->CurrentValue) != "") {
                $this->email_renovacion->ViewValue = $this->email_renovacion->optionCaption($this->email_renovacion->CurrentValue);
            } else {
                $this->email_renovacion->ViewValue = null;
            }

            // Ngrama
            $this->Ngrama->HrefValue = "";
            $this->Ngrama->TooltipValue = "";

            // ci_solicitante
            $this->ci_solicitante->HrefValue = "";
            $this->ci_solicitante->TooltipValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";
            $this->solicitante->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // monto
            $this->monto->HrefValue = "";
            $this->monto->TooltipValue = "";

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

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // Ngrama
            $this->Ngrama->setupEditAttributes();
            $this->Ngrama->EditValue = $this->Ngrama->AdvancedSearch->SearchValue;
            $this->Ngrama->PlaceHolder = RemoveHtml($this->Ngrama->caption());

            // ci_solicitante
            $this->ci_solicitante->setupEditAttributes();
            if (!$this->ci_solicitante->Raw) {
                $this->ci_solicitante->AdvancedSearch->SearchValue = HtmlDecode($this->ci_solicitante->AdvancedSearch->SearchValue);
            }
            $this->ci_solicitante->EditValue = HtmlEncode($this->ci_solicitante->AdvancedSearch->SearchValue);
            $this->ci_solicitante->PlaceHolder = RemoveHtml($this->ci_solicitante->caption());

            // solicitante
            $this->solicitante->setupEditAttributes();
            if (!$this->solicitante->Raw) {
                $this->solicitante->AdvancedSearch->SearchValue = HtmlDecode($this->solicitante->AdvancedSearch->SearchValue);
            }
            $this->solicitante->EditValue = HtmlEncode($this->solicitante->AdvancedSearch->SearchValue);
            $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

            // tipo
            $this->tipo->setupEditAttributes();
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // monto
            $this->monto->setupEditAttributes();
            $this->monto->EditValue = $this->monto->AdvancedSearch->SearchValue;
            $this->monto->PlaceHolder = RemoveHtml($this->monto->caption());

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

            // estatus
            $this->estatus->setupEditAttributes();
            $curVal = trim(strval($this->estatus->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->estatus->AdvancedSearch->ViewValue = $this->estatus->lookupCacheOption($curVal);
            } else {
                $this->estatus->AdvancedSearch->ViewValue = $this->estatus->Lookup !== null && is_array($this->estatus->lookupOptions()) && count($this->estatus->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->estatus->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->estatus->EditValue = array_values($this->estatus->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->estatus->AdvancedSearch->SearchValue, $this->estatus->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->estatus->getSelectFilter($this); // PHP
                $sqlWrk = $this->estatus->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->estatus->EditValue = $arwrk;
            }
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_registro->AdvancedSearch->SearchValue, $this->fecha_registro->formatPattern()), $this->fecha_registro->formatPattern()));
            $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_registro->AdvancedSearch->SearchValue2, $this->fecha_registro->formatPattern()), $this->fecha_registro->formatPattern()));
            $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());
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
        if (!CheckInteger($this->Ngrama->AdvancedSearch->SearchValue)) {
            $this->Ngrama->addErrorMessage($this->Ngrama->getErrorMessage(false));
        }
        if (!CheckDate($this->fecha_registro->AdvancedSearch->SearchValue, $this->fecha_registro->formatPattern())) {
            $this->fecha_registro->addErrorMessage($this->fecha_registro->getErrorMessage(false));
        }
        if (!CheckDate($this->fecha_registro->AdvancedSearch->SearchValue2, $this->fecha_registro->formatPattern())) {
            $this->fecha_registro->addErrorMessage($this->fecha_registro->getErrorMessage(false));
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
        $this->Ngrama->AdvancedSearch->load();
        $this->ci_solicitante->AdvancedSearch->load();
        $this->solicitante->AdvancedSearch->load();
        $this->telefono1->AdvancedSearch->load();
        $this->telefono2->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->tipo->AdvancedSearch->load();
        $this->subtipo->AdvancedSearch->load();
        $this->monto->AdvancedSearch->load();
        $this->tasa->AdvancedSearch->load();
        $this->monto_bs->AdvancedSearch->load();
        $this->nota->AdvancedSearch->load();
        $this->contrato->AdvancedSearch->load();
        $this->seccion->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->sub_seccion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->boveda->AdvancedSearch->load();
        $this->ci_difunto->AdvancedSearch->load();
        $this->apellido1->AdvancedSearch->load();
        $this->apellido2->AdvancedSearch->load();
        $this->nombre1->AdvancedSearch->load();
        $this->nombre2->AdvancedSearch->load();
        $this->fecha_solucion->AdvancedSearch->load();
        $this->fecha_desde->AdvancedSearch->load();
        $this->fecha_hasta->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->usuario_registro->AdvancedSearch->load();
        $this->email_renovacion->AdvancedSearch->load();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fsco_gramalist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fsco_gramalist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fsco_gramalist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fsco_gramalist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_gramasrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_tipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_subtipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_email_renovacion":
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
    public function pageRender() {
    	//echo "Page Render";
    	$this->estatus->Visible = FALSE;
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header) {
        // 1. Obtener todos los parámetros de estatus en una sola consulta
        $sql = "SELECT valor2 AS estatus, valor4 AS color FROM sco_parametro 
                WHERE codigo = '057' ORDER BY valor3 ASC";
        $rows = ExecuteRows($sql);

        // 2. Iniciar la construcción del HTML con Flexbox
        // Añadimos 'align-items-center' para que el botón y los cuadros queden nivelados
        $html = '<div class="d-flex flex-wrap align-items-center mb-4 gap-2">';

        // 3. Agregar el botón de Nueva Solicitud al inicio
        $html .= '<a href="ViewFallecidosList" class="btn btn-success shadow-sm d-flex align-items-center" style="height: 42px; padding: 0 15px;">
                    <i class="fas fa-plus-circle me-2"></i> 
                    <span class="fw-bold">NUEVA SOLICITUD</span>
                  </a>';

        // 4. Construir la leyenda de estatus
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $estatus = htmlspecialchars($row["estatus"]);
                $estiloColor = $row["color"]; // El valor4 ya trae el formato "background:..."
                $html .= sprintf(
                    '<div class="text-center p-2 rounded shadow-sm" style="%s; min-width: 110px; height: 42px; font-size: 0.85rem; display: flex; align-items: center; justify-content: center;">
                        <span class="fw-bold text-uppercase">%s</span>
                    </div>',
                    $estiloColor,
                    $estatus
                );
            }
        }
        $html .= '</div>';

        // 5. Asignar al header
        $header = $html;
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
    public function listOptionsLoad() {
    	// Example:
    	$opt = &$this->ListOptions->Add("print");
    	$opt->Header = "";
    	$opt->OnLeft = TRUE; // Link on left
    	$opt->MoveTo(6); // Move to first column
    	$opt = &$this->ListOptions->Add("email");
    	$opt->Header = "";
    	$opt->OnLeft = TRUE; // Link on left
    	$opt->MoveTo(6); // Move to first column
    	$opt = &$this->ListOptions->Add("monto_pagado");
    	$opt->Header = "Pagado";
    	$opt->OnLeft = FALSE; // Link on left
    	$opt->MoveTo(0); // Move to last column
    	$opt = &$this->ListOptions->Add("tiempo");
    	$opt->Header = "Tiempo";
    	$opt->OnLeft = FALSE; // Link on left
    	$opt->MoveTo(0); // Move to last column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    public function listOptionsRendered() {
        // 1. Limpieza de ID para SQL manual (Seguridad)
        $idGrama = $this->Ngrama->CurrentValue ?? 0;
        $idGramaQuoted = QuotedValue($idGrama, DataType::NUMBER); // Limpia el valor

        // Cálculo de monto pagado
        $sql = "SELECT IFNULL(SUM(monto_bs), 0) FROM sco_grama_pagos WHERE grama = " . $idGramaQuoted;
        $montoBs = floatval(ExecuteScalar($sql));
        $tasa = floatval($this->tasa->CurrentValue ?? 0);
        $montoUSD = ($tasa > 0) ? ($montoBs / $tasa) : 0;
        if (isset($this->ListOptions->Items["monto_pagado"])) {
            $this->ListOptions->Items["monto_pagado"]->Body = number_format($montoUSD, 2, ",", ".");
        }

        // 2. Gestión de iconos de acción
        $tipo = $this->tipo->CurrentValue ?? "";
        $estatus = $this->estatus->CurrentValue ?? "";
        if ($tipo === "6.1" && $estatus !== "ANULADO") {
            // Icono de Impresión
            if (isset($this->ListOptions->Items["print"])) {
                $this->ListOptions->Items["print"]->Body = sprintf(
                    '<a class="btn btn-sm btn-outline-secondary" target="_blank" href="fpdf_report/rptReciboGrama.php?Ngrama=%s" title="Imprimir Recibo"><i class="fas fa-print"></i></a>',
                    rawurlencode($idGrama)
                );
            }

            // Icono de Email con cambio de color si ya fue enviado
            if (isset($this->ListOptions->Items["email"])) {
                // Verificamos si existe un registro de envío (Ajusta 'sco_grama_nota' por tu tabla de logs real)
                $sqlCheckEmail = "SELECT COUNT(*) FROM sco_grama_nota WHERE grama = " . $idGramaQuoted . " AND nota LIKE '%EMAIL%'";
                $fueEnviado = intval(ExecuteScalar($sqlCheckEmail)) > 0;

                // Si fue enviado usamos color sólido (info), si no, solo el contorno (outline-info)
                $btnClass = $fueEnviado ? "btn-info text-white" : "btn-outline-info";
                $msgTooltip = $fueEnviado ? "Re-enviar por Email (Ya enviado)" : "Enviar por Email";
                $this->ListOptions->Items["email"]->Body = sprintf(
                    '<a class="btn btn-sm %s" target="_blank" href="fpdf_report/rptReciboGrama_email.php?Ngrama=%s" title="%s"><i class="fas fa-envelope"></i></a>',
                    $btnClass,
                    rawurlencode($idGrama),
                    $msgTooltip
                );
            }
        } elseif ($estatus === "ANULADO") {
            if (isset($this->ListOptions->Items["print"])) $this->ListOptions->Items["print"]->Body = "";
            if (isset($this->ListOptions->Items["email"])) $this->ListOptions->Items["email"]->Body = "";
        }

        // 3. Tiempo transcurrido (Reclamos 6.2)
        if ($tipo === "6.2") {
            $fechaReg = $this->fecha_registro->CurrentValue;
            $fechaSol = (!empty($this->fecha_solucion->CurrentValue)) ? $this->fecha_solucion->CurrentValue : date("Y-m-d H:i:s");
            $tiempoTxt = tiempoTranscurridoFechas($fechaReg, $fechaSol);
            $this->ListOptions->Items["tiempo"]->Body = "<small class='text-muted'>" . $tiempoTxt . "</small>";
        } else {
            if (isset($this->ListOptions->Items["tiempo"])) $this->ListOptions->Items["tiempo"]->Body = "";
        }
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
