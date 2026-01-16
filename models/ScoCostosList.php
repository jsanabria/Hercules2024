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
class ScoCostosList extends ScoCostos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoCostosList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_costoslist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoCostosList";

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
        $this->Ncostos->Visible = false;
        $this->id->setVisibility();
        $this->fecha->setVisibility();
        $this->tipo->setVisibility();
        $this->costos_articulos->setVisibility();
        $this->precio_actual->setVisibility();
        $this->porcentaje_aplicado->setVisibility();
        $this->precio_nuevo->setVisibility();
        $this->alicuota_iva->setVisibility();
        $this->monto_iva->setVisibility();
        $this->total->setVisibility();
        $this->cerrado->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_costos';
        $this->TableName = 'sco_costos';

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

        // Table object (sco_costos)
        if (!isset($GLOBALS["sco_costos"]) || $GLOBALS["sco_costos"]::class == PROJECT_NAMESPACE . "sco_costos") {
            $GLOBALS["sco_costos"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoCostosAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoCostosDelete";
        $this->MultiUpdateUrl = "ScoCostosUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_costos');
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
                    $result["view"] = SameString($pageName, "ScoCostosView"); // If View page, no primary button
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
            $key .= @$ar['Ncostos'];
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
            $this->Ncostos->Visible = false;
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
    public $DisplayRecords = 300;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "5,10,20,50,300,-1"; // Page sizes (comma separated)
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

        // Create form object
        $CurrentForm = new HttpForm();

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
        $this->setupLookupOptions($this->costos_articulos);
        $this->setupLookupOptions($this->cerrado);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_costosgrid";
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

        // Check QueryString parameters
        if (Get("action") !== null) {
            $this->CurrentAction = Get("action");
        } else {
            if (Post("action") !== null && Post("action") !== $this->UserAction) {
                $this->CurrentAction = Post("action"); // Get action
            } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) { // Stay in grid edit mode if paging
                    $this->gridEditMode();
                } else { // Reset grid edit
                    $this->clearInlineMode();
                }
            }
        }

        // Clear inline mode
        if ($this->isCancel()) {
            $this->clearInlineMode();
        }

        // Switch to grid edit mode
        if ($this->isGridEdit()) {
            $this->gridEditMode();
        }

        // Grid Update
        if (IsPost() && ($this->isGridUpdate() || $this->isMultiUpdate() || $this->isGridOverwrite()) && (Session(SESSION_INLINE_MODE) == "gridedit" || Session(SESSION_INLINE_MODE) == "multiedit")) {
            if ($this->validateGridForm()) {
                $gridUpdate = $this->gridUpdate();
            } else {
                $gridUpdate = false;
            }
            if ($gridUpdate) {
                // Handle modal grid edit and multi edit, redirect to list page directly
                if ($this->IsModal && !$this->UseAjaxActions) {
                    $this->terminate("ScoCostosList");
                    return;
                }
            } else {
                $this->EventCancelled = true;
                if ($this->UseAjaxActions) {
                    WriteJson([
                        "success" => false,
                        "validation" => $this->ValidationErrors,
                        "error" => $this->getFailureMessage()
                    ]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->isMultiUpdate()) { // Stay in Multi-Edit mode
                    $this->FilterForModalActions = $this->getFilterFromRecords($this->getGridFormValues());
                    $this->multiEditMode();
                } else { // Stay in grid edit mode
                    $this->gridEditMode();
                }
            }
        }

        // Switch to inline edit mode
        if ($this->isEdit()) {
            $this->inlineEditMode();
        // Inline Update
        } elseif (IsPost() && ($this->isUpdate() || $this->isOverwrite()) && Session(SESSION_INLINE_MODE) == "edit") {
            $this->setKey(Post($this->OldKeyName));
            // Return JSON error message if UseAjaxActions
            if (!$this->inlineUpdate() && $this->UseAjaxActions) {
                WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate();
                return;
            }
        }

        // Switch to inline add mode
        if ($this->isAdd() || $this->isCopy()) {
            $this->inlineAddMode();
        // Insert Inline
        } elseif (IsPost() && $this->isInsert() && Session(SESSION_INLINE_MODE) == "add") {
            $this->setKey(Post($this->OldKeyName));
            // Return JSON error message if UseAjaxActions
            if (!$this->inlineInsert() && $this->UseAjaxActions) {
                WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate();
                return;
            }
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

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = $Security->allowDelete(CurrentProjectID() . $this->TableName);
                }
            }
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
            $this->DisplayRecords = 300; // Load default
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
                    $this->DisplayRecords = 300; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->precio_actual->FormValue = ""; // Clear form value
        $this->porcentaje_aplicado->FormValue = ""; // Clear form value
        $this->precio_nuevo->FormValue = ""; // Clear form value
        $this->alicuota_iva->FormValue = ""; // Clear form value
        $this->monto_iva->FormValue = ""; // Clear form value
        $this->total->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to grid edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Inline Edit mode
    protected function inlineEditMode()
    {
        global $Security, $Language;
        if (!$Security->canEdit()) {
            return false; // Edit not allowed
        }
        $inlineEdit = true;
        if (($keyValue = Get("Ncostos") ?? Route("Ncostos")) !== null) {
            $this->Ncostos->setQueryStringValue($keyValue);
        } elseif (IsApi() && ($keyValue = Route(2)) !== null) {
            $this->Ncostos->setQueryStringValue($keyValue);
        } else {
            $inlineEdit = false;
        }
        if ($inlineEdit) {
            if ($this->loadRow()) {
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
                $this->setKey($this->OldKey); // Set to OldValue
                $_SESSION[SESSION_INLINE_MODE] = "edit"; // Enable inline edit
            }
        }
        return true;
    }

    // Perform update to Inline Edit record
    protected function inlineUpdate()
    {
        global $Language, $CurrentForm;
        $CurrentForm->Index = 1;
        $this->loadFormValues(); // Get form values

        // Validate form
        $inlineUpdate = true;
        if (!$this->validateForm()) {
            $inlineUpdate = false; // Form error, reset action
        } else {
            $inlineUpdate = false;
            $this->SendEmail = true; // Send email on update success
            $inlineUpdate = $this->editRow(); // Update record
        }
        if ($inlineUpdate) { // Update success
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
            $this->EventCancelled = true; // Cancel event
            $this->CurrentAction = "edit"; // Stay in edit mode
        }
        return $inlineUpdate;
    }

    // Check Inline Edit key
    public function checkInlineEditKey()
    {
        if (!SameString($this->Ncostos->OldValue, $this->Ncostos->CurrentValue)) {
            return false;
        }
        return true;
    }

    // Switch to Inline Add mode
    protected function inlineAddMode()
    {
        global $Security, $Language;
        if (!$Security->canAdd()) {
            return false; // Add not allowed
        }
        $this->CurrentAction = "add";
        $_SESSION[SESSION_INLINE_MODE] = "add"; // Enable inline add
        return true;
    }

    // Perform update to Inline Add/Copy record
    protected function inlineInsert()
    {
        global $Language, $CurrentForm;
        $rsold = $this->loadOldRecord(); // Load old record
        $CurrentForm->Index = 0;
        $this->loadFormValues(); // Get form values

        // Validate form
        if (!$this->validateForm()) {
            $this->EventCancelled = true; // Set event cancelled
            $this->CurrentAction = "add"; // Stay in add mode
            return false;
        }
        $this->SendEmail = true; // Send email on add success
        if ($this->addRow($rsold)) { // Add record
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up add success message
            }
            $this->clearInlineMode(); // Clear inline add mode
            return true;
        } else { // Add failed
            $this->EventCancelled = true; // Set event cancelled
            $this->CurrentAction = "add"; // Stay in add mode
            return false;
        }
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old result set
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }
        if ($this->AuditTrailOnEdit) {
            $this->writeAuditTrailDummy($Language->phrase("BatchUpdateBegin")); // Batch update begin
        }
        $wrkfilter = "";
        $key = "";

        // Update row index and get row key
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete" && $rowaction != "hide") { // Skip insert then deleted rows / hidden rows for grid edit
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                        if ($gridUpdate) { // Get inserted or updated filter
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($gridUpdate) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateSuccess")); // Batch update success
            }
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateRollback")); // Batch update rollback
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
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

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_id") &&
            $CurrentForm->hasValue("o_id") &&
            $this->id->CurrentValue != $this->id->DefaultValue &&
            !($this->id->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->id->CurrentValue == $this->id->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_fecha") &&
            $CurrentForm->hasValue("o_fecha") &&
            $this->fecha->CurrentValue != $this->fecha->DefaultValue &&
            !($this->fecha->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->fecha->CurrentValue == $this->fecha->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_tipo") &&
            $CurrentForm->hasValue("o_tipo") &&
            $this->tipo->CurrentValue != $this->tipo->DefaultValue &&
            !($this->tipo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->tipo->CurrentValue == $this->tipo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_costos_articulos") &&
            $CurrentForm->hasValue("o_costos_articulos") &&
            $this->costos_articulos->CurrentValue != $this->costos_articulos->DefaultValue &&
            !($this->costos_articulos->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->costos_articulos->CurrentValue == $this->costos_articulos->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_precio_actual") &&
            $CurrentForm->hasValue("o_precio_actual") &&
            $this->precio_actual->CurrentValue != $this->precio_actual->DefaultValue &&
            !($this->precio_actual->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->precio_actual->CurrentValue == $this->precio_actual->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_porcentaje_aplicado") &&
            $CurrentForm->hasValue("o_porcentaje_aplicado") &&
            $this->porcentaje_aplicado->CurrentValue != $this->porcentaje_aplicado->DefaultValue &&
            !($this->porcentaje_aplicado->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->porcentaje_aplicado->CurrentValue == $this->porcentaje_aplicado->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_precio_nuevo") &&
            $CurrentForm->hasValue("o_precio_nuevo") &&
            $this->precio_nuevo->CurrentValue != $this->precio_nuevo->DefaultValue &&
            !($this->precio_nuevo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->precio_nuevo->CurrentValue == $this->precio_nuevo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_alicuota_iva") &&
            $CurrentForm->hasValue("o_alicuota_iva") &&
            $this->alicuota_iva->CurrentValue != $this->alicuota_iva->DefaultValue &&
            !($this->alicuota_iva->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->alicuota_iva->CurrentValue == $this->alicuota_iva->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_monto_iva") &&
            $CurrentForm->hasValue("o_monto_iva") &&
            $this->monto_iva->CurrentValue != $this->monto_iva->DefaultValue &&
            !($this->monto_iva->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->monto_iva->CurrentValue == $this->monto_iva->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_total") &&
            $CurrentForm->hasValue("o_total") &&
            $this->total->CurrentValue != $this->total->DefaultValue &&
            !($this->total->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->total->CurrentValue == $this->total->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_cerrado") &&
            $CurrentForm->hasValue("o_cerrado") &&
            $this->cerrado->CurrentValue != $this->cerrado->DefaultValue &&
            !($this->cerrado->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cerrado->CurrentValue == $this->cerrado->getSessionValue())
        ) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete" && $rowaction != "hide") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->ValidationErrors[$rowindex] = $this->getValidationErrors();
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        foreach ($this->Fields as $field) {
            $field->clearErrorMessage();
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->Ncostos->AdvancedSearch->toJson(), ","); // Field Ncostos
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->fecha->AdvancedSearch->toJson(), ","); // Field fecha
        $filterList = Concat($filterList, $this->tipo->AdvancedSearch->toJson(), ","); // Field tipo
        $filterList = Concat($filterList, $this->costos_articulos->AdvancedSearch->toJson(), ","); // Field costos_articulos
        $filterList = Concat($filterList, $this->precio_actual->AdvancedSearch->toJson(), ","); // Field precio_actual
        $filterList = Concat($filterList, $this->porcentaje_aplicado->AdvancedSearch->toJson(), ","); // Field porcentaje_aplicado
        $filterList = Concat($filterList, $this->precio_nuevo->AdvancedSearch->toJson(), ","); // Field precio_nuevo
        $filterList = Concat($filterList, $this->alicuota_iva->AdvancedSearch->toJson(), ","); // Field alicuota_iva
        $filterList = Concat($filterList, $this->monto_iva->AdvancedSearch->toJson(), ","); // Field monto_iva
        $filterList = Concat($filterList, $this->total->AdvancedSearch->toJson(), ","); // Field total
        $filterList = Concat($filterList, $this->cerrado->AdvancedSearch->toJson(), ","); // Field cerrado
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
            Profile()->setSearchFilters("fsco_costossrch", $filters);
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

        // Field Ncostos
        $this->Ncostos->AdvancedSearch->SearchValue = @$filter["x_Ncostos"];
        $this->Ncostos->AdvancedSearch->SearchOperator = @$filter["z_Ncostos"];
        $this->Ncostos->AdvancedSearch->SearchCondition = @$filter["v_Ncostos"];
        $this->Ncostos->AdvancedSearch->SearchValue2 = @$filter["y_Ncostos"];
        $this->Ncostos->AdvancedSearch->SearchOperator2 = @$filter["w_Ncostos"];
        $this->Ncostos->AdvancedSearch->save();

        // Field id
        $this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
        $this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
        $this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
        $this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
        $this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
        $this->id->AdvancedSearch->save();

        // Field fecha
        $this->fecha->AdvancedSearch->SearchValue = @$filter["x_fecha"];
        $this->fecha->AdvancedSearch->SearchOperator = @$filter["z_fecha"];
        $this->fecha->AdvancedSearch->SearchCondition = @$filter["v_fecha"];
        $this->fecha->AdvancedSearch->SearchValue2 = @$filter["y_fecha"];
        $this->fecha->AdvancedSearch->SearchOperator2 = @$filter["w_fecha"];
        $this->fecha->AdvancedSearch->save();

        // Field tipo
        $this->tipo->AdvancedSearch->SearchValue = @$filter["x_tipo"];
        $this->tipo->AdvancedSearch->SearchOperator = @$filter["z_tipo"];
        $this->tipo->AdvancedSearch->SearchCondition = @$filter["v_tipo"];
        $this->tipo->AdvancedSearch->SearchValue2 = @$filter["y_tipo"];
        $this->tipo->AdvancedSearch->SearchOperator2 = @$filter["w_tipo"];
        $this->tipo->AdvancedSearch->save();

        // Field costos_articulos
        $this->costos_articulos->AdvancedSearch->SearchValue = @$filter["x_costos_articulos"];
        $this->costos_articulos->AdvancedSearch->SearchOperator = @$filter["z_costos_articulos"];
        $this->costos_articulos->AdvancedSearch->SearchCondition = @$filter["v_costos_articulos"];
        $this->costos_articulos->AdvancedSearch->SearchValue2 = @$filter["y_costos_articulos"];
        $this->costos_articulos->AdvancedSearch->SearchOperator2 = @$filter["w_costos_articulos"];
        $this->costos_articulos->AdvancedSearch->save();

        // Field precio_actual
        $this->precio_actual->AdvancedSearch->SearchValue = @$filter["x_precio_actual"];
        $this->precio_actual->AdvancedSearch->SearchOperator = @$filter["z_precio_actual"];
        $this->precio_actual->AdvancedSearch->SearchCondition = @$filter["v_precio_actual"];
        $this->precio_actual->AdvancedSearch->SearchValue2 = @$filter["y_precio_actual"];
        $this->precio_actual->AdvancedSearch->SearchOperator2 = @$filter["w_precio_actual"];
        $this->precio_actual->AdvancedSearch->save();

        // Field porcentaje_aplicado
        $this->porcentaje_aplicado->AdvancedSearch->SearchValue = @$filter["x_porcentaje_aplicado"];
        $this->porcentaje_aplicado->AdvancedSearch->SearchOperator = @$filter["z_porcentaje_aplicado"];
        $this->porcentaje_aplicado->AdvancedSearch->SearchCondition = @$filter["v_porcentaje_aplicado"];
        $this->porcentaje_aplicado->AdvancedSearch->SearchValue2 = @$filter["y_porcentaje_aplicado"];
        $this->porcentaje_aplicado->AdvancedSearch->SearchOperator2 = @$filter["w_porcentaje_aplicado"];
        $this->porcentaje_aplicado->AdvancedSearch->save();

        // Field precio_nuevo
        $this->precio_nuevo->AdvancedSearch->SearchValue = @$filter["x_precio_nuevo"];
        $this->precio_nuevo->AdvancedSearch->SearchOperator = @$filter["z_precio_nuevo"];
        $this->precio_nuevo->AdvancedSearch->SearchCondition = @$filter["v_precio_nuevo"];
        $this->precio_nuevo->AdvancedSearch->SearchValue2 = @$filter["y_precio_nuevo"];
        $this->precio_nuevo->AdvancedSearch->SearchOperator2 = @$filter["w_precio_nuevo"];
        $this->precio_nuevo->AdvancedSearch->save();

        // Field alicuota_iva
        $this->alicuota_iva->AdvancedSearch->SearchValue = @$filter["x_alicuota_iva"];
        $this->alicuota_iva->AdvancedSearch->SearchOperator = @$filter["z_alicuota_iva"];
        $this->alicuota_iva->AdvancedSearch->SearchCondition = @$filter["v_alicuota_iva"];
        $this->alicuota_iva->AdvancedSearch->SearchValue2 = @$filter["y_alicuota_iva"];
        $this->alicuota_iva->AdvancedSearch->SearchOperator2 = @$filter["w_alicuota_iva"];
        $this->alicuota_iva->AdvancedSearch->save();

        // Field monto_iva
        $this->monto_iva->AdvancedSearch->SearchValue = @$filter["x_monto_iva"];
        $this->monto_iva->AdvancedSearch->SearchOperator = @$filter["z_monto_iva"];
        $this->monto_iva->AdvancedSearch->SearchCondition = @$filter["v_monto_iva"];
        $this->monto_iva->AdvancedSearch->SearchValue2 = @$filter["y_monto_iva"];
        $this->monto_iva->AdvancedSearch->SearchOperator2 = @$filter["w_monto_iva"];
        $this->monto_iva->AdvancedSearch->save();

        // Field total
        $this->total->AdvancedSearch->SearchValue = @$filter["x_total"];
        $this->total->AdvancedSearch->SearchOperator = @$filter["z_total"];
        $this->total->AdvancedSearch->SearchCondition = @$filter["v_total"];
        $this->total->AdvancedSearch->SearchValue2 = @$filter["y_total"];
        $this->total->AdvancedSearch->SearchOperator2 = @$filter["w_total"];
        $this->total->AdvancedSearch->save();

        // Field cerrado
        $this->cerrado->AdvancedSearch->SearchValue = @$filter["x_cerrado"];
        $this->cerrado->AdvancedSearch->SearchOperator = @$filter["z_cerrado"];
        $this->cerrado->AdvancedSearch->SearchCondition = @$filter["v_cerrado"];
        $this->cerrado->AdvancedSearch->SearchValue2 = @$filter["y_cerrado"];
        $this->cerrado->AdvancedSearch->SearchOperator2 = @$filter["w_cerrado"];
        $this->cerrado->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->Ncostos, $default, false); // Ncostos
        $this->buildSearchSql($where, $this->id, $default, false); // id
        $this->buildSearchSql($where, $this->fecha, $default, false); // fecha
        $this->buildSearchSql($where, $this->tipo, $default, false); // tipo
        $this->buildSearchSql($where, $this->costos_articulos, $default, false); // costos_articulos
        $this->buildSearchSql($where, $this->precio_actual, $default, false); // precio_actual
        $this->buildSearchSql($where, $this->porcentaje_aplicado, $default, false); // porcentaje_aplicado
        $this->buildSearchSql($where, $this->precio_nuevo, $default, false); // precio_nuevo
        $this->buildSearchSql($where, $this->alicuota_iva, $default, false); // alicuota_iva
        $this->buildSearchSql($where, $this->monto_iva, $default, false); // monto_iva
        $this->buildSearchSql($where, $this->total, $default, false); // total
        $this->buildSearchSql($where, $this->cerrado, $default, false); // cerrado

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Ncostos->AdvancedSearch->save(); // Ncostos
            $this->id->AdvancedSearch->save(); // id
            $this->fecha->AdvancedSearch->save(); // fecha
            $this->tipo->AdvancedSearch->save(); // tipo
            $this->costos_articulos->AdvancedSearch->save(); // costos_articulos
            $this->precio_actual->AdvancedSearch->save(); // precio_actual
            $this->porcentaje_aplicado->AdvancedSearch->save(); // porcentaje_aplicado
            $this->precio_nuevo->AdvancedSearch->save(); // precio_nuevo
            $this->alicuota_iva->AdvancedSearch->save(); // alicuota_iva
            $this->monto_iva->AdvancedSearch->save(); // monto_iva
            $this->total->AdvancedSearch->save(); // total
            $this->cerrado->AdvancedSearch->save(); // cerrado

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
            $this->Ncostos->AdvancedSearch->save(); // Ncostos
            $this->id->AdvancedSearch->save(); // id
            $this->fecha->AdvancedSearch->save(); // fecha
            $this->tipo->AdvancedSearch->save(); // tipo
            $this->costos_articulos->AdvancedSearch->save(); // costos_articulos
            $this->precio_actual->AdvancedSearch->save(); // precio_actual
            $this->porcentaje_aplicado->AdvancedSearch->save(); // porcentaje_aplicado
            $this->precio_nuevo->AdvancedSearch->save(); // precio_nuevo
            $this->alicuota_iva->AdvancedSearch->save(); // alicuota_iva
            $this->monto_iva->AdvancedSearch->save(); // monto_iva
            $this->total->AdvancedSearch->save(); // total
            $this->cerrado->AdvancedSearch->save(); // cerrado
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

        // Field id
        $filter = $this->queryBuilderWhere("id");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->id, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->id->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecha
        $filter = $this->queryBuilderWhere("fecha");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecha, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecha->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field tipo
        $filter = $this->queryBuilderWhere("tipo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field costos_articulos
        $filter = $this->queryBuilderWhere("costos_articulos");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->costos_articulos, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->costos_articulos->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field precio_actual
        $filter = $this->queryBuilderWhere("precio_actual");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->precio_actual, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->precio_actual->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field porcentaje_aplicado
        $filter = $this->queryBuilderWhere("porcentaje_aplicado");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->porcentaje_aplicado, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->porcentaje_aplicado->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field precio_nuevo
        $filter = $this->queryBuilderWhere("precio_nuevo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->precio_nuevo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->precio_nuevo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field alicuota_iva
        $filter = $this->queryBuilderWhere("alicuota_iva");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->alicuota_iva, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->alicuota_iva->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field monto_iva
        $filter = $this->queryBuilderWhere("monto_iva");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->monto_iva, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->monto_iva->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field total
        $filter = $this->queryBuilderWhere("total");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->total, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->total->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cerrado
        $filter = $this->queryBuilderWhere("cerrado");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cerrado, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cerrado->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->tipo;
        $searchFlds[] = &$this->costos_articulos;
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
        if ($this->Ncostos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->id->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->costos_articulos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->precio_actual->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->porcentaje_aplicado->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->precio_nuevo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->alicuota_iva->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->monto_iva->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->total->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cerrado->AdvancedSearch->issetSession()) {
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
        $this->Ncostos->AdvancedSearch->unsetSession();
        $this->id->AdvancedSearch->unsetSession();
        $this->fecha->AdvancedSearch->unsetSession();
        $this->tipo->AdvancedSearch->unsetSession();
        $this->costos_articulos->AdvancedSearch->unsetSession();
        $this->precio_actual->AdvancedSearch->unsetSession();
        $this->porcentaje_aplicado->AdvancedSearch->unsetSession();
        $this->precio_nuevo->AdvancedSearch->unsetSession();
        $this->alicuota_iva->AdvancedSearch->unsetSession();
        $this->monto_iva->AdvancedSearch->unsetSession();
        $this->total->AdvancedSearch->unsetSession();
        $this->cerrado->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Ncostos->AdvancedSearch->load();
        $this->id->AdvancedSearch->load();
        $this->fecha->AdvancedSearch->load();
        $this->tipo->AdvancedSearch->load();
        $this->costos_articulos->AdvancedSearch->load();
        $this->precio_actual->AdvancedSearch->load();
        $this->porcentaje_aplicado->AdvancedSearch->load();
        $this->precio_nuevo->AdvancedSearch->load();
        $this->alicuota_iva->AdvancedSearch->load();
        $this->monto_iva->AdvancedSearch->load();
        $this->total->AdvancedSearch->load();
        $this->cerrado->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->Ncostos->Expression . " ASC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id); // id
            $this->updateSort($this->fecha); // fecha
            $this->updateSort($this->tipo); // tipo
            $this->updateSort($this->costos_articulos); // costos_articulos
            $this->updateSort($this->precio_actual); // precio_actual
            $this->updateSort($this->porcentaje_aplicado); // porcentaje_aplicado
            $this->updateSort($this->precio_nuevo); // precio_nuevo
            $this->updateSort($this->alicuota_iva); // alicuota_iva
            $this->updateSort($this->monto_iva); // monto_iva
            $this->updateSort($this->total); // total
            $this->updateSort($this->cerrado); // cerrado
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
                $this->Ncostos->setSort("");
                $this->id->setSort("");
                $this->fecha->setSort("");
                $this->tipo->setSort("");
                $this->costos_articulos->setSort("");
                $this->precio_actual->setSort("");
                $this->porcentaje_aplicado->setSort("");
                $this->precio_nuevo->setSort("");
                $this->alicuota_iva->setSort("");
                $this->monto_iva->setSort("");
                $this->total->setSort("");
                $this->cerrado->setSort("");
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

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

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
        $item->Visible = $Security->canAdd() && $this->isAdd();
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
        $item->Visible = $Security->canDelete();
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

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->allowDelete(CurrentProjectID() . $this->TableName) && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl(false);

        // "copy"
        $opt = $this->ListOptions["copy"];
        if ($this->isInlineAddRow() || $this->isInlineCopyRow()) { // Inline Add/Copy
            $this->ListOptions->CustomItem = "copy"; // Show copy column only
            $divClass = $opt->OnLeft ? " class=\"text-end\"" : "";
            $insertCaption = $Language->phrase("InsertLink");
            $insertTitle = HtmlTitle($insertCaption);
            $cancelCaption = $Language->phrase("CancelLink");
            $cancelTitle = HtmlTitle($cancelCaption);
            $inlineInsertUrl = GetUrl($this->pageName());
            if ($this->UseAjaxActions) {
                $opt->Body = <<<INLINEADDAJAX
                    <div{$divClass}>
                        <button type="button" class="ew-grid-link ew-inline-insert" title="{$insertTitle}" data-caption="{$insertTitle}" data-ew-action="inline" data-action="insert" data-key="" data-url="{$inlineInsertUrl}">{$insertCaption}</button>
                        <button type="button" class="ew-grid-link ew-inline-cancel" title="{$cancelTitle}" data-caption="{$cancelTitle}" data-ew-action="inline" data-action="cancel">{$cancelCaption}</button>
                    </div>
                    INLINEADDAJAX;
            } else {
                $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $opt->Body = <<<INLINEADD
                    <div{$divClass}>
                        <button class="ew-grid-link ew-inline-insert" title="{$insertTitle}" data-caption="{$insertTitle}" form="fsco_costoslist" formaction="{$inlineInsertUrl}">{$insertCaption}</button>
                        <a class="ew-grid-link ew-inline-cancel" title="{$cancelTitle}" data-caption="{$insertTitle}" href="{$cancelurl}">{$cancelCaption}</a>
                        <input type="hidden" name="action" id="action" value="insert">
                    </div>
                    INLINEADD;
            }
            return;
        }

        // "edit"
        $opt = $this->ListOptions["edit"];
        if ($this->isInlineEditRow()) { // Inline-Edit
            $this->ListOptions->CustomItem = "edit"; // Show edit column only
            $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $divClass = $opt->OnLeft ? " class=\"text-end\"" : "";
                $updateCaption = $Language->phrase("UpdateLink");
                $updateTitle = HtmlTitle($updateCaption);
                $cancelCaption = $Language->phrase("CancelLink");
                $cancelTitle = HtmlTitle($cancelCaption);
                $oldKey = HtmlEncode($this->getKey(true));
                $inlineUpdateUrl = HtmlEncode(GetUrl($this->urlAddHash($this->pageName(), "r" . $this->RowCount . "_" . $this->TableVar)));
                if ($this->UseAjaxActions) {
                    $inlineCancelUrl = preg_replace('/\baction=edit\b/', "action=cancel", $this->InlineEditUrl);
                    $opt->Body = <<<INLINEEDITAJAX
                    <div{$divClass}>
                        <button type="button" class="ew-grid-link ew-inline-update" title="{$updateTitle}" data-caption="{$updateTitle}" data-ew-action="inline" data-action="update" data-key="{$oldKey}" data-url="{$inlineUpdateUrl}">{$updateCaption}</button>
                        <button type="button" class="ew-grid-link ew-inline-cancel" title="{$cancelTitle}" data-caption="{$cancelTitle}" data-ew-action="inline" data-action="cancel" data-key="{$oldKey}" data-url="{$inlineCancelUrl}">{$cancelCaption}</button>
                    </div>
                    INLINEEDITAJAX;
                } else {
                    $opt->Body = <<<INLINEEDIT
                    <div{$divClass}>
                        <button class="ew-grid-link ew-inline-update" title="{$updateTitle}" data-caption="{$updateTitle}" form="fsco_costoslist" formaction="{$inlineUpdateUrl}">{$updateCaption}</button>
                        <a class="ew-grid-link ew-inline-cancel" title="{$cancelTitle}" data-caption="{$updateTitle}" href="{$cancelurl}">{$cancelCaption}</a>
                        <input type="hidden" name="action" id="action" value="update">
                    </div>
                    INLINEEDIT;
                }
            $opt->Body .= "<input type=\"hidden\" name=\"" . $this->OldKeyName . "\" id=\"" . $this->OldKeyName . "\" value=\"" . HtmlEncode($this->Ncostos->CurrentValue) . "\">";
            return;
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_costos\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_costos\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                }
                $inlineEditCaption = $Language->phrase("InlineEditLink");
                $inlineEditTitle = HtmlTitle($inlineEditCaption);
                if ($this->UseAjaxActions) {
                    $opt->Body .= "<a class=\"ew-row-link ew-inline-edit\" title=\"" . $inlineEditTitle . "\" data-caption=\"" . $inlineEditTitle . "\" data-ew-action=\"inline\" data-action=\"edit\" data-key=\"" . HtmlEncode($this->getKey(true)) . "\" data-url=\"" . HtmlEncode($this->InlineEditUrl) . "\">" . $inlineEditCaption . "</a>";
                } else {
                    $opt->Body .= "<a class=\"ew-row-link ew-inline-edit\" title=\"" . $inlineEditTitle . "\" data-caption=\"" . $inlineEditTitle . "\" href=\"" . HtmlEncode($this->urlAddHash(GetUrl($this->InlineEditUrl), "r" . $this->RowCount . "_" . $this->TableVar)) . "\">" . $inlineEditCaption . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_costoslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_costoslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Ncostos->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_costos\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Inline Add
        $item = &$option->add("inlineadd");
        if ($this->UseAjaxActions) {
            $item->Body = "<button class=\"ew-add-edit ew-inline-add\" title=\"" . $Language->phrase("InlineAddLink", true) . "\" data-caption=\"" . $Language->phrase("InlineAddLink", true) . "\" data-ew-action=\"inline\" data-action=\"add\" data-position=\"top\" data-url=\"" . HtmlEncode(GetUrl($this->InlineAddUrl)) . "\">" . $Language->phrase("InlineAddLink") . "</button>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-inline-add\" title=\"" . HtmlTitle($Language->phrase("InlineAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("InlineAddLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->InlineAddUrl)) . "\">" . $Language->phrase("InlineAddLink") . "</a>";
        }
        $item->Visible = $this->InlineAddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        if ($this->ModalGridEdit && !IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . $Language->phrase("GridEditLink", true) . "\" data-caption=\"" . $Language->phrase("GridEditLink", true) . "\" data-ew-action=\"modal\" data-btn=\"GridSaveLink\" data-url=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . $Language->phrase("GridEditLink", true) . "\" data-caption=\"" . $Language->phrase("GridEditLink", true) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        }
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Add multi delete
        $item = &$option->add("multidelete");
        $item->Body = "<button type=\"button\" class=\"ew-action ew-multi-delete\" title=\"" .
            HtmlTitle($Language->phrase("DeleteSelectedLink")) . "\" data-caption=\"" .
            HtmlTitle($Language->phrase("DeleteSelectedLink")) . "\" form=\"fsco_costoslist\"" .
            " data-ew-action=\"" . ($this->UseAjaxActions ? "inline" : "submit") . "\"" .
            ($this->UseAjaxActions ? " data-action=\"delete\"" : "") .
            " data-url=\"" . GetUrl($this->MultiDeleteUrl) . "\"" .
            ($this->InlineDelete ? " data-msg=\"" . HtmlEncode($Language->phrase("DeleteConfirm")) . "\" data-data='{\"action\":\"delete\"}'" : " data-data='{\"action\":\"show\"}'") .
            ">" . $Language->phrase("DeleteSelectedLink") . "</button>";
        $item->Visible = $Security->canDelete();

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "id");
            $this->createColumnOption($option, "fecha");
            $this->createColumnOption($option, "tipo");
            $this->createColumnOption($option, "costos_articulos");
            $this->createColumnOption($option, "precio_actual");
            $this->createColumnOption($option, "porcentaje_aplicado");
            $this->createColumnOption($option, "precio_nuevo");
            $this->createColumnOption($option, "alicuota_iva");
            $this->createColumnOption($option, "monto_iva");
            $this->createColumnOption($option, "total");
            $this->createColumnOption($option, "cerrado");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_costossrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_costossrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
        if (!$this->isGridAdd() && !$this->isGridEdit() && !$this->isMultiEdit()) { // Not grid add/grid edit/multi edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions as $listAction) {
                if ($listAction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listAction->Action);
                    $caption = $listAction->Caption;
                    $icon = ($listAction->Icon != "") ? '<i class="' . HtmlEncode($listAction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_costoslist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
        } else { // Grid add/grid edit/multi edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl(false);

            // Grid-Edit
            if ($this->isGridEdit()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<button class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</button>";
                        $item->Visible = $Security->canAdd();
                    }
                if (!($this->ModalGridEdit && !IsMobile())) {
                    $option = $options["action"];
                    $option->UseDropDownButton = false;
                        $item = &$option->add("gridsave");
                        $item->Body = "<button class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" form=\"fsco_costoslist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridSaveLink") . "</button>";
                        $item = &$option->add("gridcancel");
                        $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                        $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
                }
            }
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

        // Restore number of post back records
        if ($CurrentForm && ($this->isConfirm() || $this->EventCancelled)) {
            $CurrentForm->resetIndex();
            if ($CurrentForm->hasValue($this->FormKeyCountName) && ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm())) {
                $this->KeyCount = $CurrentForm->getValue($this->FormKeyCountName);
                $this->StopRecord = $this->StartRecord + $this->KeyCount - 1;
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
        if ($this->isAdd() || $this->isCopy() || $this->isInlineInserted()) {
            $this->RowIndex = 0;
            if ($this->UseInfiniteScroll) {
                $this->StopRecord = $this->StartRecord; // Show this record only
            }
        }
        if ($this->isEdit()) {
            $this->RowIndex = 1;
        }
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_costos", "data-rowtype" => RowType::ADD]);
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
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm() || $this->isMultiEdit()) {
            $this->RowIndex++;
            $CurrentForm->Index = $this->RowIndex;
            if ($CurrentForm->hasValue($this->FormActionName) && ($this->isConfirm() || $this->EventCancelled)) {
                $this->RowAction = strval($CurrentForm->getValue($this->FormActionName));
            } elseif ($this->isGridAdd()) {
                $this->RowAction = "insert";
            } else {
                $this->RowAction = "";
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
        if ($this->isEdit() || $this->isInlineUpdated() || $this->isInlineEditCancelled()) { // Inline edit/updated/cancelled
            if ($this->checkInlineEditKey() && $this->InlineRowCount == 0) {
                if ($this->isEdit()) { // Inline edit
                    $this->RowAction = "edit";
                    $this->RowType = RowType::EDIT; // Render edit
                } else { // Inline updated
                    $this->RowAction = "";
                    $this->RowType = RowType::VIEW; // Render view
                    $this->RowAttrs["data-oldkey"] = $this->getKey(); // Set up old key
                }
            } elseif ($this->UseInfiniteScroll) {
                $this->RowAction = "hide";
            }
        }
        if ($this->isGridEdit()) { // Grid edit
            if ($this->EventCancelled) {
                $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
            }
            if ($this->RowAction == "insert") {
                $this->RowType = RowType::ADD; // Render add
            } else {
                $this->RowType = RowType::EDIT; // Render edit
            }
        }
        if ($this->isEdit() && $this->RowType == RowType::EDIT && $this->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $this->restoreFormValues(); // Restore form values
        }
        if ($this->isGridEdit() && ($this->RowType == RowType::EDIT || $this->RowType == RowType::ADD) && $this->EventCancelled) { // Update failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
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
            "id" => "r" . $this->RowCount . "_sco_costos",
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

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->DefaultValue = $this->id->getDefault(); // PHP
        $this->id->OldValue = $this->id->DefaultValue;
        $this->precio_actual->DefaultValue = $this->precio_actual->getDefault(); // PHP
        $this->precio_actual->OldValue = $this->precio_actual->DefaultValue;
        $this->porcentaje_aplicado->DefaultValue = $this->porcentaje_aplicado->getDefault(); // PHP
        $this->porcentaje_aplicado->OldValue = $this->porcentaje_aplicado->DefaultValue;
        $this->precio_nuevo->DefaultValue = $this->precio_nuevo->getDefault(); // PHP
        $this->precio_nuevo->OldValue = $this->precio_nuevo->DefaultValue;
        $this->alicuota_iva->DefaultValue = $this->alicuota_iva->getDefault(); // PHP
        $this->alicuota_iva->OldValue = $this->alicuota_iva->DefaultValue;
        $this->monto_iva->DefaultValue = $this->monto_iva->getDefault(); // PHP
        $this->monto_iva->OldValue = $this->monto_iva->DefaultValue;
        $this->total->DefaultValue = $this->total->getDefault(); // PHP
        $this->total->OldValue = $this->total->DefaultValue;
        $this->cerrado->DefaultValue = $this->cerrado->getDefault(); // PHP
        $this->cerrado->OldValue = $this->cerrado->DefaultValue;
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

        // Ncostos
        if ($this->Ncostos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Ncostos->AdvancedSearch->SearchValue != "" || $this->Ncostos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // id
        if ($this->id->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->id->AdvancedSearch->SearchValue != "" || $this->id->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha
        if ($this->fecha->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha->AdvancedSearch->SearchValue != "" || $this->fecha->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // costos_articulos
        if ($this->costos_articulos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->costos_articulos->AdvancedSearch->SearchValue != "" || $this->costos_articulos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // precio_actual
        if ($this->precio_actual->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->precio_actual->AdvancedSearch->SearchValue != "" || $this->precio_actual->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // porcentaje_aplicado
        if ($this->porcentaje_aplicado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->porcentaje_aplicado->AdvancedSearch->SearchValue != "" || $this->porcentaje_aplicado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // precio_nuevo
        if ($this->precio_nuevo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->precio_nuevo->AdvancedSearch->SearchValue != "" || $this->precio_nuevo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // alicuota_iva
        if ($this->alicuota_iva->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->alicuota_iva->AdvancedSearch->SearchValue != "" || $this->alicuota_iva->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // monto_iva
        if ($this->monto_iva->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->monto_iva->AdvancedSearch->SearchValue != "" || $this->monto_iva->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // total
        if ($this->total->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->total->AdvancedSearch->SearchValue != "" || $this->total->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cerrado
        if ($this->cerrado->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cerrado->AdvancedSearch->SearchValue != "" || $this->cerrado->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }
        return $hasValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id->Visible = false; // Disable update for API request
            } else {
                $this->id->setFormValue($val);
            }
        }

        // Check field name 'fecha' first before field var 'x_fecha'
        $val = $CurrentForm->hasValue("fecha") ? $CurrentForm->getValue("fecha") : $CurrentForm->getValue("x_fecha");
        if (!$this->fecha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha->Visible = false; // Disable update for API request
            } else {
                $this->fecha->setFormValue($val);
            }
            $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
        }

        // Check field name 'tipo' first before field var 'x_tipo'
        $val = $CurrentForm->hasValue("tipo") ? $CurrentForm->getValue("tipo") : $CurrentForm->getValue("x_tipo");
        if (!$this->tipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo->Visible = false; // Disable update for API request
            } else {
                $this->tipo->setFormValue($val);
            }
        }

        // Check field name 'costos_articulos' first before field var 'x_costos_articulos'
        $val = $CurrentForm->hasValue("costos_articulos") ? $CurrentForm->getValue("costos_articulos") : $CurrentForm->getValue("x_costos_articulos");
        if (!$this->costos_articulos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->costos_articulos->Visible = false; // Disable update for API request
            } else {
                $this->costos_articulos->setFormValue($val);
            }
        }

        // Check field name 'precio_actual' first before field var 'x_precio_actual'
        $val = $CurrentForm->hasValue("precio_actual") ? $CurrentForm->getValue("precio_actual") : $CurrentForm->getValue("x_precio_actual");
        if (!$this->precio_actual->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->precio_actual->Visible = false; // Disable update for API request
            } else {
                $this->precio_actual->setFormValue($val);
            }
        }

        // Check field name 'porcentaje_aplicado' first before field var 'x_porcentaje_aplicado'
        $val = $CurrentForm->hasValue("porcentaje_aplicado") ? $CurrentForm->getValue("porcentaje_aplicado") : $CurrentForm->getValue("x_porcentaje_aplicado");
        if (!$this->porcentaje_aplicado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentaje_aplicado->Visible = false; // Disable update for API request
            } else {
                $this->porcentaje_aplicado->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'precio_nuevo' first before field var 'x_precio_nuevo'
        $val = $CurrentForm->hasValue("precio_nuevo") ? $CurrentForm->getValue("precio_nuevo") : $CurrentForm->getValue("x_precio_nuevo");
        if (!$this->precio_nuevo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->precio_nuevo->Visible = false; // Disable update for API request
            } else {
                $this->precio_nuevo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'alicuota_iva' first before field var 'x_alicuota_iva'
        $val = $CurrentForm->hasValue("alicuota_iva") ? $CurrentForm->getValue("alicuota_iva") : $CurrentForm->getValue("x_alicuota_iva");
        if (!$this->alicuota_iva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alicuota_iva->Visible = false; // Disable update for API request
            } else {
                $this->alicuota_iva->setFormValue($val);
            }
        }

        // Check field name 'monto_iva' first before field var 'x_monto_iva'
        $val = $CurrentForm->hasValue("monto_iva") ? $CurrentForm->getValue("monto_iva") : $CurrentForm->getValue("x_monto_iva");
        if (!$this->monto_iva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto_iva->Visible = false; // Disable update for API request
            } else {
                $this->monto_iva->setFormValue($val);
            }
        }

        // Check field name 'total' first before field var 'x_total'
        $val = $CurrentForm->hasValue("total") ? $CurrentForm->getValue("total") : $CurrentForm->getValue("x_total");
        if (!$this->total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total->Visible = false; // Disable update for API request
            } else {
                $this->total->setFormValue($val);
            }
        }

        // Check field name 'cerrado' first before field var 'x_cerrado'
        $val = $CurrentForm->hasValue("cerrado") ? $CurrentForm->getValue("cerrado") : $CurrentForm->getValue("x_cerrado");
        if (!$this->cerrado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cerrado->Visible = false; // Disable update for API request
            } else {
                $this->cerrado->setFormValue($val);
            }
        }

        // Check field name 'Ncostos' first before field var 'x_Ncostos'
        $val = $CurrentForm->hasValue("Ncostos") ? $CurrentForm->getValue("Ncostos") : $CurrentForm->getValue("x_Ncostos");
        if (!$this->Ncostos->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->Ncostos->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->Ncostos->CurrentValue = $this->Ncostos->FormValue;
        }
        $this->id->CurrentValue = $this->id->FormValue;
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->costos_articulos->CurrentValue = $this->costos_articulos->FormValue;
        $this->precio_actual->CurrentValue = $this->precio_actual->FormValue;
        $this->porcentaje_aplicado->CurrentValue = $this->porcentaje_aplicado->FormValue;
        $this->precio_nuevo->CurrentValue = $this->precio_nuevo->FormValue;
        $this->alicuota_iva->CurrentValue = $this->alicuota_iva->FormValue;
        $this->monto_iva->CurrentValue = $this->monto_iva->FormValue;
        $this->total->CurrentValue = $this->total->FormValue;
        $this->cerrado->CurrentValue = $this->cerrado->FormValue;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
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
        $this->Ncostos->setDbValue($row['Ncostos']);
        $this->id->setDbValue($row['id']);
        $this->fecha->setDbValue($row['fecha']);
        $this->tipo->setDbValue($row['tipo']);
        $this->costos_articulos->setDbValue($row['costos_articulos']);
        $this->precio_actual->setDbValue($row['precio_actual']);
        $this->porcentaje_aplicado->setDbValue($row['porcentaje_aplicado']);
        $this->precio_nuevo->setDbValue($row['precio_nuevo']);
        $this->alicuota_iva->setDbValue($row['alicuota_iva']);
        $this->monto_iva->setDbValue($row['monto_iva']);
        $this->total->setDbValue($row['total']);
        $this->cerrado->setDbValue($row['cerrado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ncostos'] = $this->Ncostos->DefaultValue;
        $row['id'] = $this->id->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['costos_articulos'] = $this->costos_articulos->DefaultValue;
        $row['precio_actual'] = $this->precio_actual->DefaultValue;
        $row['porcentaje_aplicado'] = $this->porcentaje_aplicado->DefaultValue;
        $row['precio_nuevo'] = $this->precio_nuevo->DefaultValue;
        $row['alicuota_iva'] = $this->alicuota_iva->DefaultValue;
        $row['monto_iva'] = $this->monto_iva->DefaultValue;
        $row['total'] = $this->total->DefaultValue;
        $row['cerrado'] = $this->cerrado->DefaultValue;
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

        // Ncostos

        // id

        // fecha

        // tipo

        // costos_articulos

        // precio_actual

        // porcentaje_aplicado

        // precio_nuevo

        // alicuota_iva

        // monto_iva

        // total

        // cerrado

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ncostos
            $this->Ncostos->ViewValue = $this->Ncostos->CurrentValue;

            // id
            $this->id->ViewValue = $this->id->CurrentValue;

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // tipo
            $curVal = strval($this->tipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo->ViewValue = $this->tipo->lookupCacheOption($curVal);
                if ($this->tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchExpression(), "=", $curVal, $this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchDataType(), "");
                    $sqlWrk = $this->tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // costos_articulos
            $curVal = strval($this->costos_articulos->CurrentValue);
            if ($curVal != "") {
                $this->costos_articulos->ViewValue = $this->costos_articulos->lookupCacheOption($curVal);
                if ($this->costos_articulos->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $sqlWrk = $this->costos_articulos->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_articulos->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_articulos->ViewValue = $this->costos_articulos->displayValue($arwrk);
                    } else {
                        $this->costos_articulos->ViewValue = $this->costos_articulos->CurrentValue;
                    }
                }
            } else {
                $this->costos_articulos->ViewValue = null;
            }

            // precio_actual
            $this->precio_actual->ViewValue = $this->precio_actual->CurrentValue;
            $this->precio_actual->ViewValue = FormatNumber($this->precio_actual->ViewValue, $this->precio_actual->formatPattern());
            $this->precio_actual->CellCssStyle .= "text-align: right;";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->ViewValue = $this->porcentaje_aplicado->CurrentValue;
            $this->porcentaje_aplicado->ViewValue = FormatNumber($this->porcentaje_aplicado->ViewValue, $this->porcentaje_aplicado->formatPattern());
            $this->porcentaje_aplicado->CellCssStyle .= "text-align: center;";

            // precio_nuevo
            $this->precio_nuevo->ViewValue = $this->precio_nuevo->CurrentValue;
            $this->precio_nuevo->ViewValue = FormatNumber($this->precio_nuevo->ViewValue, $this->precio_nuevo->formatPattern());
            $this->precio_nuevo->CssClass = "fw-bold";
            $this->precio_nuevo->CellCssStyle .= "text-align: right;";

            // alicuota_iva
            $this->alicuota_iva->ViewValue = $this->alicuota_iva->CurrentValue;
            $this->alicuota_iva->ViewValue = FormatNumber($this->alicuota_iva->ViewValue, $this->alicuota_iva->formatPattern());
            $this->alicuota_iva->CellCssStyle .= "text-align: center;";

            // monto_iva
            $this->monto_iva->ViewValue = $this->monto_iva->CurrentValue;
            $this->monto_iva->ViewValue = FormatNumber($this->monto_iva->ViewValue, $this->monto_iva->formatPattern());
            $this->monto_iva->CellCssStyle .= "text-align: right;";

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, $this->total->formatPattern());
            $this->total->CellCssStyle .= "text-align: right;";

            // cerrado
            if (strval($this->cerrado->CurrentValue) != "") {
                $this->cerrado->ViewValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
            } else {
                $this->cerrado->ViewValue = null;
            }

            // id
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // costos_articulos
            $this->costos_articulos->HrefValue = "";
            $this->costos_articulos->TooltipValue = "";

            // precio_actual
            $this->precio_actual->HrefValue = "";
            $this->precio_actual->TooltipValue = "";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->HrefValue = "";
            $this->porcentaje_aplicado->TooltipValue = "";

            // precio_nuevo
            $this->precio_nuevo->HrefValue = "";
            $this->precio_nuevo->TooltipValue = "";

            // alicuota_iva
            $this->alicuota_iva->HrefValue = "";
            $this->alicuota_iva->TooltipValue = "";

            // monto_iva
            $this->monto_iva->HrefValue = "";
            $this->monto_iva->TooltipValue = "";

            // total
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
            $this->cerrado->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());
            if (strval($this->id->EditValue) != "" && is_numeric($this->id->EditValue)) {
                $this->id->EditValue = $this->id->EditValue;
            }

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = HtmlEncode(FormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern()));
            $this->fecha->PlaceHolder = RemoveHtml($this->fecha->caption());

            // tipo
            $this->tipo->setupEditAttributes();
            $curVal = trim(strval($this->tipo->CurrentValue));
            if ($curVal != "") {
                $this->tipo->ViewValue = $this->tipo->lookupCacheOption($curVal);
            } else {
                $this->tipo->ViewValue = $this->tipo->Lookup !== null && is_array($this->tipo->lookupOptions()) && count($this->tipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo->ViewValue !== null) { // Load from cache
                $this->tipo->EditValue = array_values($this->tipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchExpression(), "=", $this->tipo->CurrentValue, $this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo->EditValue = $arwrk;
            }
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // costos_articulos
            $this->costos_articulos->setupEditAttributes();
            $curVal = trim(strval($this->costos_articulos->CurrentValue));
            if ($curVal != "") {
                $this->costos_articulos->ViewValue = $this->costos_articulos->lookupCacheOption($curVal);
            } else {
                $this->costos_articulos->ViewValue = $this->costos_articulos->Lookup !== null && is_array($this->costos_articulos->lookupOptions()) && count($this->costos_articulos->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->costos_articulos->ViewValue !== null) { // Load from cache
                $this->costos_articulos->EditValue = array_values($this->costos_articulos->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->costos_articulos->CurrentValue, $this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $sqlWrk = $this->costos_articulos->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->costos_articulos->EditValue = $arwrk;
            }
            $this->costos_articulos->PlaceHolder = RemoveHtml($this->costos_articulos->caption());

            // precio_actual
            $this->precio_actual->setupEditAttributes();
            $this->precio_actual->EditValue = $this->precio_actual->CurrentValue;
            $this->precio_actual->PlaceHolder = RemoveHtml($this->precio_actual->caption());
            if (strval($this->precio_actual->EditValue) != "" && is_numeric($this->precio_actual->EditValue)) {
                $this->precio_actual->EditValue = FormatNumber($this->precio_actual->EditValue, null);
            }

            // porcentaje_aplicado
            $this->porcentaje_aplicado->setupEditAttributes();
            $this->porcentaje_aplicado->EditValue = $this->porcentaje_aplicado->CurrentValue;
            $this->porcentaje_aplicado->PlaceHolder = RemoveHtml($this->porcentaje_aplicado->caption());
            if (strval($this->porcentaje_aplicado->EditValue) != "" && is_numeric($this->porcentaje_aplicado->EditValue)) {
                $this->porcentaje_aplicado->EditValue = FormatNumber($this->porcentaje_aplicado->EditValue, null);
            }

            // precio_nuevo
            $this->precio_nuevo->setupEditAttributes();
            $this->precio_nuevo->EditValue = $this->precio_nuevo->CurrentValue;
            $this->precio_nuevo->PlaceHolder = RemoveHtml($this->precio_nuevo->caption());
            if (strval($this->precio_nuevo->EditValue) != "" && is_numeric($this->precio_nuevo->EditValue)) {
                $this->precio_nuevo->EditValue = FormatNumber($this->precio_nuevo->EditValue, null);
            }

            // alicuota_iva
            $this->alicuota_iva->setupEditAttributes();
            $this->alicuota_iva->EditValue = $this->alicuota_iva->CurrentValue;
            $this->alicuota_iva->PlaceHolder = RemoveHtml($this->alicuota_iva->caption());
            if (strval($this->alicuota_iva->EditValue) != "" && is_numeric($this->alicuota_iva->EditValue)) {
                $this->alicuota_iva->EditValue = FormatNumber($this->alicuota_iva->EditValue, null);
            }

            // monto_iva
            $this->monto_iva->setupEditAttributes();
            $this->monto_iva->EditValue = $this->monto_iva->CurrentValue;
            $this->monto_iva->PlaceHolder = RemoveHtml($this->monto_iva->caption());
            if (strval($this->monto_iva->EditValue) != "" && is_numeric($this->monto_iva->EditValue)) {
                $this->monto_iva->EditValue = FormatNumber($this->monto_iva->EditValue, null);
            }

            // total
            $this->total->setupEditAttributes();
            $this->total->EditValue = $this->total->CurrentValue;
            $this->total->PlaceHolder = RemoveHtml($this->total->caption());
            if (strval($this->total->EditValue) != "" && is_numeric($this->total->EditValue)) {
                $this->total->EditValue = FormatNumber($this->total->EditValue, null);
            }

            // cerrado
            $this->cerrado->setupEditAttributes();
            $this->cerrado->EditValue = $this->cerrado->options(true);
            $this->cerrado->PlaceHolder = RemoveHtml($this->cerrado->caption());

            // Add refer script

            // id
            $this->id->HrefValue = "";

            // fecha
            $this->fecha->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // costos_articulos
            $this->costos_articulos->HrefValue = "";

            // precio_actual
            $this->precio_actual->HrefValue = "";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->HrefValue = "";

            // precio_nuevo
            $this->precio_nuevo->HrefValue = "";

            // alicuota_iva
            $this->alicuota_iva->HrefValue = "";

            // monto_iva
            $this->monto_iva->HrefValue = "";

            // total
            $this->total->HrefValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = $this->id->CurrentValue;

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = $this->fecha->CurrentValue;
            $this->fecha->EditValue = FormatDateTime($this->fecha->EditValue, $this->fecha->formatPattern());

            // tipo
            $this->tipo->setupEditAttributes();
            $curVal = strval($this->tipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo->EditValue = $this->tipo->lookupCacheOption($curVal);
                if ($this->tipo->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchExpression(), "=", $curVal, $this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchDataType(), "");
                    $sqlWrk = $this->tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo->EditValue = $this->tipo->displayValue($arwrk);
                    } else {
                        $this->tipo->EditValue = $this->tipo->CurrentValue;
                    }
                }
            } else {
                $this->tipo->EditValue = null;
            }

            // costos_articulos
            $this->costos_articulos->setupEditAttributes();
            $curVal = strval($this->costos_articulos->CurrentValue);
            if ($curVal != "") {
                $this->costos_articulos->EditValue = $this->costos_articulos->lookupCacheOption($curVal);
                if ($this->costos_articulos->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $sqlWrk = $this->costos_articulos->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_articulos->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_articulos->EditValue = $this->costos_articulos->displayValue($arwrk);
                    } else {
                        $this->costos_articulos->EditValue = $this->costos_articulos->CurrentValue;
                    }
                }
            } else {
                $this->costos_articulos->EditValue = null;
            }

            // precio_actual
            $this->precio_actual->setupEditAttributes();
            $this->precio_actual->EditValue = $this->precio_actual->CurrentValue;
            $this->precio_actual->EditValue = FormatNumber($this->precio_actual->EditValue, $this->precio_actual->formatPattern());
            $this->precio_actual->CellCssStyle .= "text-align: right;";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->setupEditAttributes();
            $this->porcentaje_aplicado->EditValue = $this->porcentaje_aplicado->CurrentValue;
            $this->porcentaje_aplicado->PlaceHolder = RemoveHtml($this->porcentaje_aplicado->caption());
            if (strval($this->porcentaje_aplicado->EditValue) != "" && is_numeric($this->porcentaje_aplicado->EditValue)) {
                $this->porcentaje_aplicado->EditValue = FormatNumber($this->porcentaje_aplicado->EditValue, null);
            }

            // precio_nuevo
            $this->precio_nuevo->setupEditAttributes();
            $this->precio_nuevo->EditValue = $this->precio_nuevo->CurrentValue;
            $this->precio_nuevo->PlaceHolder = RemoveHtml($this->precio_nuevo->caption());
            if (strval($this->precio_nuevo->EditValue) != "" && is_numeric($this->precio_nuevo->EditValue)) {
                $this->precio_nuevo->EditValue = FormatNumber($this->precio_nuevo->EditValue, null);
            }

            // alicuota_iva
            $this->alicuota_iva->setupEditAttributes();
            $this->alicuota_iva->EditValue = $this->alicuota_iva->CurrentValue;
            $this->alicuota_iva->EditValue = FormatNumber($this->alicuota_iva->EditValue, $this->alicuota_iva->formatPattern());
            $this->alicuota_iva->CellCssStyle .= "text-align: center;";

            // monto_iva
            $this->monto_iva->setupEditAttributes();
            $this->monto_iva->EditValue = $this->monto_iva->CurrentValue;
            $this->monto_iva->EditValue = FormatNumber($this->monto_iva->EditValue, $this->monto_iva->formatPattern());
            $this->monto_iva->CellCssStyle .= "text-align: right;";

            // total
            $this->total->setupEditAttributes();
            $this->total->EditValue = $this->total->CurrentValue;
            $this->total->EditValue = FormatNumber($this->total->EditValue, $this->total->formatPattern());
            $this->total->CellCssStyle .= "text-align: right;";

            // cerrado
            $this->cerrado->setupEditAttributes();
            if (strval($this->cerrado->CurrentValue) != "") {
                $this->cerrado->EditValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
            } else {
                $this->cerrado->EditValue = null;
            }

            // Edit refer script

            // id
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // costos_articulos
            $this->costos_articulos->HrefValue = "";
            $this->costos_articulos->TooltipValue = "";

            // precio_actual
            $this->precio_actual->HrefValue = "";
            $this->precio_actual->TooltipValue = "";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->HrefValue = "";

            // precio_nuevo
            $this->precio_nuevo->HrefValue = "";

            // alicuota_iva
            $this->alicuota_iva->HrefValue = "";
            $this->alicuota_iva->TooltipValue = "";

            // monto_iva
            $this->monto_iva->HrefValue = "";
            $this->monto_iva->TooltipValue = "";

            // total
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
            $this->cerrado->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = $this->id->AdvancedSearch->SearchValue;
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha->AdvancedSearch->SearchValue, $this->fecha->formatPattern()), $this->fecha->formatPattern()));
            $this->fecha->PlaceHolder = RemoveHtml($this->fecha->caption());

            // tipo
            $this->tipo->setupEditAttributes();
            $curVal = trim(strval($this->tipo->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->tipo->AdvancedSearch->ViewValue = $this->tipo->lookupCacheOption($curVal);
            } else {
                $this->tipo->AdvancedSearch->ViewValue = $this->tipo->Lookup !== null && is_array($this->tipo->lookupOptions()) && count($this->tipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->tipo->EditValue = array_values($this->tipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchExpression(), "=", $this->tipo->AdvancedSearch->SearchValue, $this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchDataType(), "");
                }
                $sqlWrk = $this->tipo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo->EditValue = $arwrk;
            }
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // costos_articulos
            $this->costos_articulos->setupEditAttributes();
            $this->costos_articulos->PlaceHolder = RemoveHtml($this->costos_articulos->caption());

            // precio_actual
            $this->precio_actual->setupEditAttributes();
            $this->precio_actual->EditValue = $this->precio_actual->AdvancedSearch->SearchValue;
            $this->precio_actual->PlaceHolder = RemoveHtml($this->precio_actual->caption());

            // porcentaje_aplicado
            $this->porcentaje_aplicado->setupEditAttributes();
            $this->porcentaje_aplicado->EditValue = $this->porcentaje_aplicado->AdvancedSearch->SearchValue;
            $this->porcentaje_aplicado->PlaceHolder = RemoveHtml($this->porcentaje_aplicado->caption());

            // precio_nuevo
            $this->precio_nuevo->setupEditAttributes();
            $this->precio_nuevo->EditValue = $this->precio_nuevo->AdvancedSearch->SearchValue;
            $this->precio_nuevo->PlaceHolder = RemoveHtml($this->precio_nuevo->caption());

            // alicuota_iva
            $this->alicuota_iva->setupEditAttributes();
            $this->alicuota_iva->EditValue = $this->alicuota_iva->AdvancedSearch->SearchValue;
            $this->alicuota_iva->PlaceHolder = RemoveHtml($this->alicuota_iva->caption());

            // monto_iva
            $this->monto_iva->setupEditAttributes();
            $this->monto_iva->EditValue = $this->monto_iva->AdvancedSearch->SearchValue;
            $this->monto_iva->PlaceHolder = RemoveHtml($this->monto_iva->caption());

            // total
            $this->total->setupEditAttributes();
            $this->total->EditValue = $this->total->AdvancedSearch->SearchValue;
            $this->total->PlaceHolder = RemoveHtml($this->total->caption());

            // cerrado
            $this->cerrado->setupEditAttributes();
            $this->cerrado->EditValue = $this->cerrado->options(true);
            $this->cerrado->PlaceHolder = RemoveHtml($this->cerrado->caption());
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

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
            if ($this->id->Visible && $this->id->Required) {
                if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                    $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
                }
            }
            if ($this->fecha->Visible && $this->fecha->Required) {
                if (!$this->fecha->IsDetailKey && EmptyValue($this->fecha->FormValue)) {
                    $this->fecha->addErrorMessage(str_replace("%s", $this->fecha->caption(), $this->fecha->RequiredErrorMessage));
                }
            }
            if ($this->tipo->Visible && $this->tipo->Required) {
                if (!$this->tipo->IsDetailKey && EmptyValue($this->tipo->FormValue)) {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->costos_articulos->Visible && $this->costos_articulos->Required) {
                if (!$this->costos_articulos->IsDetailKey && EmptyValue($this->costos_articulos->FormValue)) {
                    $this->costos_articulos->addErrorMessage(str_replace("%s", $this->costos_articulos->caption(), $this->costos_articulos->RequiredErrorMessage));
                }
            }
            if ($this->precio_actual->Visible && $this->precio_actual->Required) {
                if (!$this->precio_actual->IsDetailKey && EmptyValue($this->precio_actual->FormValue)) {
                    $this->precio_actual->addErrorMessage(str_replace("%s", $this->precio_actual->caption(), $this->precio_actual->RequiredErrorMessage));
                }
            }
            if ($this->porcentaje_aplicado->Visible && $this->porcentaje_aplicado->Required) {
                if (!$this->porcentaje_aplicado->IsDetailKey && EmptyValue($this->porcentaje_aplicado->FormValue)) {
                    $this->porcentaje_aplicado->addErrorMessage(str_replace("%s", $this->porcentaje_aplicado->caption(), $this->porcentaje_aplicado->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porcentaje_aplicado->FormValue)) {
                $this->porcentaje_aplicado->addErrorMessage($this->porcentaje_aplicado->getErrorMessage(false));
            }
            if ($this->precio_nuevo->Visible && $this->precio_nuevo->Required) {
                if (!$this->precio_nuevo->IsDetailKey && EmptyValue($this->precio_nuevo->FormValue)) {
                    $this->precio_nuevo->addErrorMessage(str_replace("%s", $this->precio_nuevo->caption(), $this->precio_nuevo->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->precio_nuevo->FormValue)) {
                $this->precio_nuevo->addErrorMessage($this->precio_nuevo->getErrorMessage(false));
            }
            if ($this->alicuota_iva->Visible && $this->alicuota_iva->Required) {
                if (!$this->alicuota_iva->IsDetailKey && EmptyValue($this->alicuota_iva->FormValue)) {
                    $this->alicuota_iva->addErrorMessage(str_replace("%s", $this->alicuota_iva->caption(), $this->alicuota_iva->RequiredErrorMessage));
                }
            }
            if ($this->monto_iva->Visible && $this->monto_iva->Required) {
                if (!$this->monto_iva->IsDetailKey && EmptyValue($this->monto_iva->FormValue)) {
                    $this->monto_iva->addErrorMessage(str_replace("%s", $this->monto_iva->caption(), $this->monto_iva->RequiredErrorMessage));
                }
            }
            if ($this->total->Visible && $this->total->Required) {
                if (!$this->total->IsDetailKey && EmptyValue($this->total->FormValue)) {
                    $this->total->addErrorMessage(str_replace("%s", $this->total->caption(), $this->total->RequiredErrorMessage));
                }
            }
            if ($this->cerrado->Visible && $this->cerrado->Required) {
                if (!$this->cerrado->IsDetailKey && EmptyValue($this->cerrado->FormValue)) {
                    $this->cerrado->addErrorMessage(str_replace("%s", $this->cerrado->caption(), $this->cerrado->RequiredErrorMessage));
                }
            }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->AuditTrailOnDelete) {
            $this->writeAuditTrailDummy($Language->phrase("BatchDeleteBegin")); // Batch delete begin
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['Ncostos'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // porcentaje_aplicado
        $this->porcentaje_aplicado->setDbValueDef($rsnew, $this->porcentaje_aplicado->CurrentValue, $this->porcentaje_aplicado->ReadOnly);

        // precio_nuevo
        $this->precio_nuevo->setDbValueDef($rsnew, $this->precio_nuevo->CurrentValue, $this->precio_nuevo->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['porcentaje_aplicado'])) { // porcentaje_aplicado
            $this->porcentaje_aplicado->CurrentValue = $row['porcentaje_aplicado'];
        }
        if (isset($row['precio_nuevo'])) { // precio_nuevo
            $this->precio_nuevo->CurrentValue = $row['precio_nuevo'];
        }
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash($row)
    {
        if (!$row) {
            return "";
        }
        $hash = "";
        $hash .= GetFieldHash($row['porcentaje_aplicado']); // porcentaje_aplicado
        $hash .= GetFieldHash($row['precio_nuevo']); // precio_nuevo
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // id
        $this->id->setDbValueDef($rsnew, $this->id->CurrentValue, strval($this->id->CurrentValue) == "");

        // fecha
        $this->fecha->setDbValueDef($rsnew, UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern()), false);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, false);

        // costos_articulos
        $this->costos_articulos->setDbValueDef($rsnew, $this->costos_articulos->CurrentValue, false);

        // precio_actual
        $this->precio_actual->setDbValueDef($rsnew, $this->precio_actual->CurrentValue, strval($this->precio_actual->CurrentValue) == "");

        // porcentaje_aplicado
        $this->porcentaje_aplicado->setDbValueDef($rsnew, $this->porcentaje_aplicado->CurrentValue, strval($this->porcentaje_aplicado->CurrentValue) == "");

        // precio_nuevo
        $this->precio_nuevo->setDbValueDef($rsnew, $this->precio_nuevo->CurrentValue, strval($this->precio_nuevo->CurrentValue) == "");

        // alicuota_iva
        $this->alicuota_iva->setDbValueDef($rsnew, $this->alicuota_iva->CurrentValue, strval($this->alicuota_iva->CurrentValue) == "");

        // monto_iva
        $this->monto_iva->setDbValueDef($rsnew, $this->monto_iva->CurrentValue, strval($this->monto_iva->CurrentValue) == "");

        // total
        $this->total->setDbValueDef($rsnew, $this->total->CurrentValue, strval($this->total->CurrentValue) == "");

        // cerrado
        $this->cerrado->setDbValueDef($rsnew, $this->cerrado->CurrentValue, strval($this->cerrado->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['id'])) { // id
            $this->id->setFormValue($row['id']);
        }
        if (isset($row['fecha'])) { // fecha
            $this->fecha->setFormValue($row['fecha']);
        }
        if (isset($row['tipo'])) { // tipo
            $this->tipo->setFormValue($row['tipo']);
        }
        if (isset($row['costos_articulos'])) { // costos_articulos
            $this->costos_articulos->setFormValue($row['costos_articulos']);
        }
        if (isset($row['precio_actual'])) { // precio_actual
            $this->precio_actual->setFormValue($row['precio_actual']);
        }
        if (isset($row['porcentaje_aplicado'])) { // porcentaje_aplicado
            $this->porcentaje_aplicado->setFormValue($row['porcentaje_aplicado']);
        }
        if (isset($row['precio_nuevo'])) { // precio_nuevo
            $this->precio_nuevo->setFormValue($row['precio_nuevo']);
        }
        if (isset($row['alicuota_iva'])) { // alicuota_iva
            $this->alicuota_iva->setFormValue($row['alicuota_iva']);
        }
        if (isset($row['monto_iva'])) { // monto_iva
            $this->monto_iva->setFormValue($row['monto_iva']);
        }
        if (isset($row['total'])) { // total
            $this->total->setFormValue($row['total']);
        }
        if (isset($row['cerrado'])) { // cerrado
            $this->cerrado->setFormValue($row['cerrado']);
        }
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->Ncostos->AdvancedSearch->load();
        $this->id->AdvancedSearch->load();
        $this->fecha->AdvancedSearch->load();
        $this->tipo->AdvancedSearch->load();
        $this->costos_articulos->AdvancedSearch->load();
        $this->precio_actual->AdvancedSearch->load();
        $this->porcentaje_aplicado->AdvancedSearch->load();
        $this->precio_nuevo->AdvancedSearch->load();
        $this->alicuota_iva->AdvancedSearch->load();
        $this->monto_iva->AdvancedSearch->load();
        $this->total->AdvancedSearch->load();
        $this->cerrado->AdvancedSearch->load();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fsco_costoslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fsco_costoslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fsco_costoslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fsco_costoslist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Visible = false;

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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_costossrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_tipo":
                    break;
                case "x_costos_articulos":
                    break;
                case "x_cerrado":
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
    public function pageDataRendering(&$header) {
    	// Example:
    	//$header = "your header";
    	$id = $_SESSION["id_costo"];
    	$sql = "SELECT DISTINCT a.id, a.cerrado FROM sco_costos a WHERE a.id = '$id'";
    	$row = ExecuteRow($sql);
    	$id = $row["id"];
    	$st = $row["cerrado"];
    	if($st == "N") 
    		$header = '<button type="button" class="btn btn-danger btn-sm" onClick="js:cerrar_ec(' . $id . ');">Cerrar</button>&nbsp;&nbsp;';
    	$header .= '<button type="button" class="btn btn-primary btn-sm" onClick="js:window.location.href = \'dashboard/costos_estructura_list.php\';">Regresar a Estructuras de Costo</button>&nbsp;&nbsp;';
    	if($st == "N")
    		$header .= '<div class="input-group"><input type="number" id="xporc" name="xporc" class="form-control" placeholder="Porcentaje a aplicar %">
    					<span class="input-group-btn">
    						<button class="btn btn-default" type="button" onClick="js:aplicar_porc(' . $id . ');">Calcular!</button>
    					</span></div>';
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
    	$opt = &$this->ListOptions->Add("new");
    	$opt->Header = "";
    	$opt->OnLeft = FALSE; // Link on left
    	$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered() {
    	// Example:
    	$articulo = CurrentTable()->costos_articulos->CurrentValue;
    	$sql = "select articulo_hercules, descripcion from sco_costos_articulos where Ncostos_articulo = '$articulo';";
    	$row = ExecuteRow($sql);
    	$articulo = $row["articulo_hercules"];
    	$descripcion = $row["descripcion"];
    	if(trim($articulo)=="") {
    		$this->ListOptions->Items["new"]->Body = '<div class="alert alert-warning" role="alert"><a onClick="js:alert(\'Alerta!!! ' . CurrentTable()->descripcion->CurrentValue . ' articulo de AS400 no esta asociado a codigo de articulo Hercules!.\');" class="alert-link"><span class="glyphicon glyphicon-bell"></span></a></div>';
    	}
    	else {
    		$sql = "select max(costo) as costo from sco_entrada_salida_detalle where tipo_doc = 'ENTR' and articulo = '$articulo';";
    		$mayos_costo_compra = ExecuteScalar($sql);
    		$sql = "select precio from sco_costos_articulos where articulo_hercules = '$articulo';";
    		$precio_venta = ExecuteScalar($sql);
    		if(CurrentTable()->cerrado->CurrentValue == "N") $nota = " Precio luego de cerrar esta estructura sera: Bs." . number_format(CurrentTable()->precio_nuevo->CurrentValue,2,",",".") . "";
    		else $nota = "";
    		if($mayos_costo_compra >= $precio_venta)
    			$this->ListOptions->Items["new"]->Body = '<div class="alert alert-danger" role="alert"><a onClick="js:alert(\'Alerta!!! ' . $descripcion . ': Ultimo costo de compra por: Bs.' . number_format($mayos_costo_compra,2,",",".") . ' es superior al precio de venta actual por: Bs.' . number_format($precio_venta,2,",",".") .  '; ajuste la estructura de costo actual o genere una nueva.' . $nota . '. !En este caso es posible que el articulo de AS400 no tenga asociado el codigo de articulo de Hercules correspondiente!.\');" class="alert-link"><span class="glyphicon glyphicon-bell"></span></a></div>';
    		else
    			$this->ListOptions->Items["new"]->Body = '<div class="alert alert-success" role="alert"><a onClick="js:alert(\'' . $descripcion . ': Ultimo costo de compra por: Bs.' . number_format($mayos_costo_compra,2,",",".") . ' es adecuado a la estructura de costo actual para un precio de venta por: Bs.' . number_format($precio_venta,2,",",".") . '.' . $nota . '.\');" class="alert-link"><span class="glyphicon glyphicon-ok"></span></a></div>';
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
