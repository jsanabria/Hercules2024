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
class ScoOrdenCompraDetalleList extends ScoOrdenCompraDetalle
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoOrdenCompraDetalleList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_orden_compra_detallelist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoOrdenCompraDetalleList";

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
        $this->Norden_compra_detalle->Visible = false;
        $this->orden_compra->Visible = false;
        $this->tipo_insumo->setVisibility();
        $this->articulo->setVisibility();
        $this->unidad_medida->setVisibility();
        $this->cantidad->setVisibility();
        $this->descripcion->setVisibility();
        $this->imagen->setVisibility();
        $this->disponible->setVisibility();
        $this->unidad_medida_recibida->setVisibility();
        $this->cantidad_recibida->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_orden_compra_detalle';
        $this->TableName = 'sco_orden_compra_detalle';

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

        // Table object (sco_orden_compra_detalle)
        if (!isset($GLOBALS["sco_orden_compra_detalle"]) || $GLOBALS["sco_orden_compra_detalle"]::class == PROJECT_NAMESPACE . "sco_orden_compra_detalle") {
            $GLOBALS["sco_orden_compra_detalle"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoOrdenCompraDetalleAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoOrdenCompraDetalleDelete";
        $this->MultiUpdateUrl = "ScoOrdenCompraDetalleUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_orden_compra_detalle');
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
                    $result["view"] = SameString($pageName, "ScoOrdenCompraDetalleView"); // If View page, no primary button
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
            $key .= @$ar['Norden_compra_detalle'];
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
            $this->Norden_compra_detalle->Visible = false;
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

        // Set up lookup cache
        $this->setupLookupOptions($this->tipo_insumo);
        $this->setupLookupOptions($this->articulo);
        $this->setupLookupOptions($this->unidad_medida);
        $this->setupLookupOptions($this->disponible);
        $this->setupLookupOptions($this->unidad_medida_recibida);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_orden_compra_detallegrid";
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
                    $this->terminate("ScoOrdenCompraDetalleList");
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

        // Switch to grid add mode
        if ($this->isGridAdd()) {
            $this->gridAddMode();
            // Grid Insert
        } elseif (IsPost() && $this->isGridInsert() && Session(SESSION_INLINE_MODE) == "gridadd") {
            if ($this->validateGridForm()) {
                $gridInsert = $this->gridInsert();
            } else {
                $gridInsert = false;
            }
            if ($gridInsert) {
                // Handle modal grid add, redirect to list page directly
                if ($this->IsModal && !$this->UseAjaxActions) {
                    $this->terminate("ScoOrdenCompraDetalleList");
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
                $this->gridAddMode(); // Stay in grid add mode
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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "sco_orden_compra") {
            $masterTbl = Container("sco_orden_compra");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("ScoOrdenCompraList"); // Return to master page
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

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->cantidad->FormValue = ""; // Clear form value
        $this->cantidad_recibida->FormValue = ""; // Clear form value
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to grid add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to grid edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
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

    // Perform grid add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        if ($this->AuditTrailOnAdd) {
            $this->writeAuditTrailDummy($Language->phrase("BatchInsertBegin")); // Batch insert begin
        }
        $key = "";

        // Get row count
        $CurrentForm->resetIndex();
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            $rsold = null;
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $rsold = $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success
                $gridInsert = $this->addRow($rsold); // Insert row (already validated by validateGridForm())
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->Norden_compra_detalle->CurrentValue;

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->setFailureMessage($Language->phrase("NoAddRecord"));
            $gridInsert = false;
        }
        if ($gridInsert) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $this->FilterForModalActions = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailDummy($Language->phrase("BatchInsertSuccess")); // Batch insert success
            }
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("InsertSuccess")); // Set up insert success message
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailDummy($Language->phrase("BatchInsertRollback")); // Batch insert rollback
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if (
            $CurrentForm->hasValue("x_tipo_insumo") &&
            $CurrentForm->hasValue("o_tipo_insumo") &&
            $this->tipo_insumo->CurrentValue != $this->tipo_insumo->DefaultValue &&
            !($this->tipo_insumo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->tipo_insumo->CurrentValue == $this->tipo_insumo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_articulo") &&
            $CurrentForm->hasValue("o_articulo") &&
            $this->articulo->CurrentValue != $this->articulo->DefaultValue &&
            !($this->articulo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->articulo->CurrentValue == $this->articulo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_unidad_medida") &&
            $CurrentForm->hasValue("o_unidad_medida") &&
            $this->unidad_medida->CurrentValue != $this->unidad_medida->DefaultValue &&
            !($this->unidad_medida->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->unidad_medida->CurrentValue == $this->unidad_medida->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_cantidad") &&
            $CurrentForm->hasValue("o_cantidad") &&
            $this->cantidad->CurrentValue != $this->cantidad->DefaultValue &&
            !($this->cantidad->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cantidad->CurrentValue == $this->cantidad->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_descripcion") &&
            $CurrentForm->hasValue("o_descripcion") &&
            $this->descripcion->CurrentValue != $this->descripcion->DefaultValue &&
            !($this->descripcion->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->descripcion->CurrentValue == $this->descripcion->getSessionValue())
        ) {
            return false;
        }
        if (!EmptyValue($this->imagen->Upload->Value)) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_disponible") &&
            $CurrentForm->hasValue("o_disponible") &&
            $this->disponible->CurrentValue != $this->disponible->DefaultValue &&
            !($this->disponible->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->disponible->CurrentValue == $this->disponible->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_unidad_medida_recibida") &&
            $CurrentForm->hasValue("o_unidad_medida_recibida") &&
            $this->unidad_medida_recibida->CurrentValue != $this->unidad_medida_recibida->DefaultValue &&
            !($this->unidad_medida_recibida->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->unidad_medida_recibida->CurrentValue == $this->unidad_medida_recibida->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_cantidad_recibida") &&
            $CurrentForm->hasValue("o_cantidad_recibida") &&
            $this->cantidad_recibida->CurrentValue != $this->cantidad_recibida->DefaultValue &&
            !($this->cantidad_recibida->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cantidad_recibida->CurrentValue == $this->cantidad_recibida->getSessionValue())
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
        $filterList = Concat($filterList, $this->Norden_compra_detalle->AdvancedSearch->toJson(), ","); // Field Norden_compra_detalle
        $filterList = Concat($filterList, $this->orden_compra->AdvancedSearch->toJson(), ","); // Field orden_compra
        $filterList = Concat($filterList, $this->tipo_insumo->AdvancedSearch->toJson(), ","); // Field tipo_insumo
        $filterList = Concat($filterList, $this->articulo->AdvancedSearch->toJson(), ","); // Field articulo
        $filterList = Concat($filterList, $this->unidad_medida->AdvancedSearch->toJson(), ","); // Field unidad_medida
        $filterList = Concat($filterList, $this->cantidad->AdvancedSearch->toJson(), ","); // Field cantidad
        $filterList = Concat($filterList, $this->descripcion->AdvancedSearch->toJson(), ","); // Field descripcion
        $filterList = Concat($filterList, $this->imagen->AdvancedSearch->toJson(), ","); // Field imagen
        $filterList = Concat($filterList, $this->disponible->AdvancedSearch->toJson(), ","); // Field disponible
        $filterList = Concat($filterList, $this->unidad_medida_recibida->AdvancedSearch->toJson(), ","); // Field unidad_medida_recibida
        $filterList = Concat($filterList, $this->cantidad_recibida->AdvancedSearch->toJson(), ","); // Field cantidad_recibida
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
            Profile()->setSearchFilters("fsco_orden_compra_detallesrch", $filters);
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

        // Field Norden_compra_detalle
        $this->Norden_compra_detalle->AdvancedSearch->SearchValue = @$filter["x_Norden_compra_detalle"];
        $this->Norden_compra_detalle->AdvancedSearch->SearchOperator = @$filter["z_Norden_compra_detalle"];
        $this->Norden_compra_detalle->AdvancedSearch->SearchCondition = @$filter["v_Norden_compra_detalle"];
        $this->Norden_compra_detalle->AdvancedSearch->SearchValue2 = @$filter["y_Norden_compra_detalle"];
        $this->Norden_compra_detalle->AdvancedSearch->SearchOperator2 = @$filter["w_Norden_compra_detalle"];
        $this->Norden_compra_detalle->AdvancedSearch->save();

        // Field orden_compra
        $this->orden_compra->AdvancedSearch->SearchValue = @$filter["x_orden_compra"];
        $this->orden_compra->AdvancedSearch->SearchOperator = @$filter["z_orden_compra"];
        $this->orden_compra->AdvancedSearch->SearchCondition = @$filter["v_orden_compra"];
        $this->orden_compra->AdvancedSearch->SearchValue2 = @$filter["y_orden_compra"];
        $this->orden_compra->AdvancedSearch->SearchOperator2 = @$filter["w_orden_compra"];
        $this->orden_compra->AdvancedSearch->save();

        // Field tipo_insumo
        $this->tipo_insumo->AdvancedSearch->SearchValue = @$filter["x_tipo_insumo"];
        $this->tipo_insumo->AdvancedSearch->SearchOperator = @$filter["z_tipo_insumo"];
        $this->tipo_insumo->AdvancedSearch->SearchCondition = @$filter["v_tipo_insumo"];
        $this->tipo_insumo->AdvancedSearch->SearchValue2 = @$filter["y_tipo_insumo"];
        $this->tipo_insumo->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_insumo"];
        $this->tipo_insumo->AdvancedSearch->save();

        // Field articulo
        $this->articulo->AdvancedSearch->SearchValue = @$filter["x_articulo"];
        $this->articulo->AdvancedSearch->SearchOperator = @$filter["z_articulo"];
        $this->articulo->AdvancedSearch->SearchCondition = @$filter["v_articulo"];
        $this->articulo->AdvancedSearch->SearchValue2 = @$filter["y_articulo"];
        $this->articulo->AdvancedSearch->SearchOperator2 = @$filter["w_articulo"];
        $this->articulo->AdvancedSearch->save();

        // Field unidad_medida
        $this->unidad_medida->AdvancedSearch->SearchValue = @$filter["x_unidad_medida"];
        $this->unidad_medida->AdvancedSearch->SearchOperator = @$filter["z_unidad_medida"];
        $this->unidad_medida->AdvancedSearch->SearchCondition = @$filter["v_unidad_medida"];
        $this->unidad_medida->AdvancedSearch->SearchValue2 = @$filter["y_unidad_medida"];
        $this->unidad_medida->AdvancedSearch->SearchOperator2 = @$filter["w_unidad_medida"];
        $this->unidad_medida->AdvancedSearch->save();

        // Field cantidad
        $this->cantidad->AdvancedSearch->SearchValue = @$filter["x_cantidad"];
        $this->cantidad->AdvancedSearch->SearchOperator = @$filter["z_cantidad"];
        $this->cantidad->AdvancedSearch->SearchCondition = @$filter["v_cantidad"];
        $this->cantidad->AdvancedSearch->SearchValue2 = @$filter["y_cantidad"];
        $this->cantidad->AdvancedSearch->SearchOperator2 = @$filter["w_cantidad"];
        $this->cantidad->AdvancedSearch->save();

        // Field descripcion
        $this->descripcion->AdvancedSearch->SearchValue = @$filter["x_descripcion"];
        $this->descripcion->AdvancedSearch->SearchOperator = @$filter["z_descripcion"];
        $this->descripcion->AdvancedSearch->SearchCondition = @$filter["v_descripcion"];
        $this->descripcion->AdvancedSearch->SearchValue2 = @$filter["y_descripcion"];
        $this->descripcion->AdvancedSearch->SearchOperator2 = @$filter["w_descripcion"];
        $this->descripcion->AdvancedSearch->save();

        // Field imagen
        $this->imagen->AdvancedSearch->SearchValue = @$filter["x_imagen"];
        $this->imagen->AdvancedSearch->SearchOperator = @$filter["z_imagen"];
        $this->imagen->AdvancedSearch->SearchCondition = @$filter["v_imagen"];
        $this->imagen->AdvancedSearch->SearchValue2 = @$filter["y_imagen"];
        $this->imagen->AdvancedSearch->SearchOperator2 = @$filter["w_imagen"];
        $this->imagen->AdvancedSearch->save();

        // Field disponible
        $this->disponible->AdvancedSearch->SearchValue = @$filter["x_disponible"];
        $this->disponible->AdvancedSearch->SearchOperator = @$filter["z_disponible"];
        $this->disponible->AdvancedSearch->SearchCondition = @$filter["v_disponible"];
        $this->disponible->AdvancedSearch->SearchValue2 = @$filter["y_disponible"];
        $this->disponible->AdvancedSearch->SearchOperator2 = @$filter["w_disponible"];
        $this->disponible->AdvancedSearch->save();

        // Field unidad_medida_recibida
        $this->unidad_medida_recibida->AdvancedSearch->SearchValue = @$filter["x_unidad_medida_recibida"];
        $this->unidad_medida_recibida->AdvancedSearch->SearchOperator = @$filter["z_unidad_medida_recibida"];
        $this->unidad_medida_recibida->AdvancedSearch->SearchCondition = @$filter["v_unidad_medida_recibida"];
        $this->unidad_medida_recibida->AdvancedSearch->SearchValue2 = @$filter["y_unidad_medida_recibida"];
        $this->unidad_medida_recibida->AdvancedSearch->SearchOperator2 = @$filter["w_unidad_medida_recibida"];
        $this->unidad_medida_recibida->AdvancedSearch->save();

        // Field cantidad_recibida
        $this->cantidad_recibida->AdvancedSearch->SearchValue = @$filter["x_cantidad_recibida"];
        $this->cantidad_recibida->AdvancedSearch->SearchOperator = @$filter["z_cantidad_recibida"];
        $this->cantidad_recibida->AdvancedSearch->SearchCondition = @$filter["v_cantidad_recibida"];
        $this->cantidad_recibida->AdvancedSearch->SearchValue2 = @$filter["y_cantidad_recibida"];
        $this->cantidad_recibida->AdvancedSearch->SearchOperator2 = @$filter["w_cantidad_recibida"];
        $this->cantidad_recibida->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->Norden_compra_detalle, $default, false); // Norden_compra_detalle
        $this->buildSearchSql($where, $this->orden_compra, $default, false); // orden_compra
        $this->buildSearchSql($where, $this->tipo_insumo, $default, false); // tipo_insumo
        $this->buildSearchSql($where, $this->articulo, $default, false); // articulo
        $this->buildSearchSql($where, $this->unidad_medida, $default, false); // unidad_medida
        $this->buildSearchSql($where, $this->cantidad, $default, false); // cantidad
        $this->buildSearchSql($where, $this->descripcion, $default, false); // descripcion
        $this->buildSearchSql($where, $this->imagen, $default, false); // imagen
        $this->buildSearchSql($where, $this->disponible, $default, false); // disponible
        $this->buildSearchSql($where, $this->unidad_medida_recibida, $default, false); // unidad_medida_recibida
        $this->buildSearchSql($where, $this->cantidad_recibida, $default, false); // cantidad_recibida

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Norden_compra_detalle->AdvancedSearch->save(); // Norden_compra_detalle
            $this->orden_compra->AdvancedSearch->save(); // orden_compra
            $this->tipo_insumo->AdvancedSearch->save(); // tipo_insumo
            $this->articulo->AdvancedSearch->save(); // articulo
            $this->unidad_medida->AdvancedSearch->save(); // unidad_medida
            $this->cantidad->AdvancedSearch->save(); // cantidad
            $this->descripcion->AdvancedSearch->save(); // descripcion
            $this->imagen->AdvancedSearch->save(); // imagen
            $this->disponible->AdvancedSearch->save(); // disponible
            $this->unidad_medida_recibida->AdvancedSearch->save(); // unidad_medida_recibida
            $this->cantidad_recibida->AdvancedSearch->save(); // cantidad_recibida

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
            $this->Norden_compra_detalle->AdvancedSearch->save(); // Norden_compra_detalle
            $this->orden_compra->AdvancedSearch->save(); // orden_compra
            $this->tipo_insumo->AdvancedSearch->save(); // tipo_insumo
            $this->articulo->AdvancedSearch->save(); // articulo
            $this->unidad_medida->AdvancedSearch->save(); // unidad_medida
            $this->cantidad->AdvancedSearch->save(); // cantidad
            $this->descripcion->AdvancedSearch->save(); // descripcion
            $this->imagen->AdvancedSearch->save(); // imagen
            $this->disponible->AdvancedSearch->save(); // disponible
            $this->unidad_medida_recibida->AdvancedSearch->save(); // unidad_medida_recibida
            $this->cantidad_recibida->AdvancedSearch->save(); // cantidad_recibida
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

        // Field tipo_insumo
        $filter = $this->queryBuilderWhere("tipo_insumo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->tipo_insumo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->tipo_insumo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field articulo
        $filter = $this->queryBuilderWhere("articulo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->articulo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->articulo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field unidad_medida
        $filter = $this->queryBuilderWhere("unidad_medida");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->unidad_medida, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->unidad_medida->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cantidad
        $filter = $this->queryBuilderWhere("cantidad");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cantidad, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cantidad->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field descripcion
        $filter = $this->queryBuilderWhere("descripcion");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->descripcion, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->descripcion->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field imagen
        $filter = $this->queryBuilderWhere("imagen");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->imagen, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->imagen->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field disponible
        $filter = $this->queryBuilderWhere("disponible");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->disponible, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->disponible->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field unidad_medida_recibida
        $filter = $this->queryBuilderWhere("unidad_medida_recibida");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->unidad_medida_recibida, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->unidad_medida_recibida->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cantidad_recibida
        $filter = $this->queryBuilderWhere("cantidad_recibida");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cantidad_recibida, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cantidad_recibida->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->tipo_insumo;
        $searchFlds[] = &$this->articulo;
        $searchFlds[] = &$this->descripcion;
        $searchFlds[] = &$this->imagen;
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
        if ($this->Norden_compra_detalle->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->orden_compra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo_insumo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->articulo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->unidad_medida->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cantidad->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->descripcion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->imagen->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->disponible->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->unidad_medida_recibida->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cantidad_recibida->AdvancedSearch->issetSession()) {
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
        $this->Norden_compra_detalle->AdvancedSearch->unsetSession();
        $this->orden_compra->AdvancedSearch->unsetSession();
        $this->tipo_insumo->AdvancedSearch->unsetSession();
        $this->articulo->AdvancedSearch->unsetSession();
        $this->unidad_medida->AdvancedSearch->unsetSession();
        $this->cantidad->AdvancedSearch->unsetSession();
        $this->descripcion->AdvancedSearch->unsetSession();
        $this->imagen->AdvancedSearch->unsetSession();
        $this->disponible->AdvancedSearch->unsetSession();
        $this->unidad_medida_recibida->AdvancedSearch->unsetSession();
        $this->cantidad_recibida->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Norden_compra_detalle->AdvancedSearch->load();
        $this->orden_compra->AdvancedSearch->load();
        $this->tipo_insumo->AdvancedSearch->load();
        $this->articulo->AdvancedSearch->load();
        $this->unidad_medida->AdvancedSearch->load();
        $this->cantidad->AdvancedSearch->load();
        $this->descripcion->AdvancedSearch->load();
        $this->imagen->AdvancedSearch->load();
        $this->disponible->AdvancedSearch->load();
        $this->unidad_medida_recibida->AdvancedSearch->load();
        $this->cantidad_recibida->AdvancedSearch->load();
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
            $this->updateSort($this->tipo_insumo); // tipo_insumo
            $this->updateSort($this->articulo); // articulo
            $this->updateSort($this->unidad_medida); // unidad_medida
            $this->updateSort($this->cantidad); // cantidad
            $this->updateSort($this->descripcion); // descripcion
            $this->updateSort($this->imagen); // imagen
            $this->updateSort($this->disponible); // disponible
            $this->updateSort($this->unidad_medida_recibida); // unidad_medida_recibida
            $this->updateSort($this->cantidad_recibida); // cantidad_recibida
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
                        $this->orden_compra->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->Norden_compra_detalle->setSort("");
                $this->orden_compra->setSort("");
                $this->tipo_insumo->setSort("");
                $this->articulo->setSort("");
                $this->unidad_medida->setSort("");
                $this->cantidad->setSort("");
                $this->descripcion->setSort("");
                $this->imagen->setSort("");
                $this->disponible->setSort("");
                $this->unidad_medida_recibida->setSort("");
                $this->cantidad_recibida->setSort("");
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
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_orden_compra_detalle\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_orden_compra_detalle\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_orden_compra_detallelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_orden_compra_detallelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Norden_compra_detalle->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_orden_compra_detalle\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $item = &$option->add("gridadd");
        if ($this->ModalGridAdd && !IsMobile()) {
            $item->Body = "<button class=\"ew-add-edit ew-grid-add\" title=\"" . $Language->phrase("GridAddLink", true) . "\" data-caption=\"" . $Language->phrase("GridAddLink", true) . "\" data-ew-action=\"modal\" data-btn=\"AddBtn\" data-url=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</button>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . $Language->phrase("GridAddLink", true) . "\" data-caption=\"" . $Language->phrase("GridAddLink", true) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</a>";
        }
        $item->Visible = $this->GridAddUrl != "" && $Security->canAdd();

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

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "tipo_insumo");
            $this->createColumnOption($option, "articulo");
            $this->createColumnOption($option, "unidad_medida");
            $this->createColumnOption($option, "cantidad");
            $this->createColumnOption($option, "descripcion");
            $this->createColumnOption($option, "imagen");
            $this->createColumnOption($option, "disponible");
            $this->createColumnOption($option, "unidad_medida_recibida");
            $this->createColumnOption($option, "cantidad_recibida");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_orden_compra_detallesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_orden_compra_detallesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                    $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_orden_compra_detallelist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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

            // Grid-Add
            if ($this->isGridAdd()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<a type=\"button\" class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                        $item->Visible = $Security->canAdd();
                    }
                if (!($this->ModalGridAdd && !IsMobile())) {
                    $option = $options["action"];
                    $option->UseDropDownButton = false;
                    // Add grid insert
                    $item = &$option->add("gridinsert");
                    $item->Body = "<button class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" form=\"fsco_orden_compra_detallelist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridInsertLink") . "</button>";
                    // Add grid cancel
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a type=\"button\" class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
                }
            }

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
                        $item->Body = "<button class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" form=\"fsco_orden_compra_detallelist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridSaveLink") . "</button>";
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_orden_compra_detalle", "data-rowtype" => RowType::ADD]);
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
        if ($this->isGridAdd() && $this->EventCancelled && !$CurrentForm->hasValue($this->FormBlankRowName)) { // Insert failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
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
            "id" => "r" . $this->RowCount . "_sco_orden_compra_detalle",
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->imagen->Upload->Index = $CurrentForm->Index;
        $this->imagen->Upload->uploadFile();
        $this->imagen->CurrentValue = $this->imagen->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->disponible->DefaultValue = $this->disponible->getDefault(); // PHP
        $this->disponible->OldValue = $this->disponible->DefaultValue;
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

        // Norden_compra_detalle
        if ($this->Norden_compra_detalle->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Norden_compra_detalle->AdvancedSearch->SearchValue != "" || $this->Norden_compra_detalle->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // orden_compra
        if ($this->orden_compra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->orden_compra->AdvancedSearch->SearchValue != "" || $this->orden_compra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipo_insumo
        if ($this->tipo_insumo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipo_insumo->AdvancedSearch->SearchValue != "" || $this->tipo_insumo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // articulo
        if ($this->articulo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->articulo->AdvancedSearch->SearchValue != "" || $this->articulo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // unidad_medida
        if ($this->unidad_medida->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->unidad_medida->AdvancedSearch->SearchValue != "" || $this->unidad_medida->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cantidad
        if ($this->cantidad->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cantidad->AdvancedSearch->SearchValue != "" || $this->cantidad->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // descripcion
        if ($this->descripcion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->descripcion->AdvancedSearch->SearchValue != "" || $this->descripcion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // imagen
        if ($this->imagen->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->imagen->AdvancedSearch->SearchValue != "" || $this->imagen->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // disponible
        if ($this->disponible->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->disponible->AdvancedSearch->SearchValue != "" || $this->disponible->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // unidad_medida_recibida
        if ($this->unidad_medida_recibida->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->unidad_medida_recibida->AdvancedSearch->SearchValue != "" || $this->unidad_medida_recibida->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cantidad_recibida
        if ($this->cantidad_recibida->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cantidad_recibida->AdvancedSearch->SearchValue != "" || $this->cantidad_recibida->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // Check field name 'tipo_insumo' first before field var 'x_tipo_insumo'
        $val = $CurrentForm->hasValue("tipo_insumo") ? $CurrentForm->getValue("tipo_insumo") : $CurrentForm->getValue("x_tipo_insumo");
        if (!$this->tipo_insumo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_insumo->Visible = false; // Disable update for API request
            } else {
                $this->tipo_insumo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_tipo_insumo")) {
            $this->tipo_insumo->setOldValue($CurrentForm->getValue("o_tipo_insumo"));
        }

        // Check field name 'articulo' first before field var 'x_articulo'
        $val = $CurrentForm->hasValue("articulo") ? $CurrentForm->getValue("articulo") : $CurrentForm->getValue("x_articulo");
        if (!$this->articulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->articulo->Visible = false; // Disable update for API request
            } else {
                $this->articulo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_articulo")) {
            $this->articulo->setOldValue($CurrentForm->getValue("o_articulo"));
        }

        // Check field name 'unidad_medida' first before field var 'x_unidad_medida'
        $val = $CurrentForm->hasValue("unidad_medida") ? $CurrentForm->getValue("unidad_medida") : $CurrentForm->getValue("x_unidad_medida");
        if (!$this->unidad_medida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unidad_medida->Visible = false; // Disable update for API request
            } else {
                $this->unidad_medida->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_unidad_medida")) {
            $this->unidad_medida->setOldValue($CurrentForm->getValue("o_unidad_medida"));
        }

        // Check field name 'cantidad' first before field var 'x_cantidad'
        $val = $CurrentForm->hasValue("cantidad") ? $CurrentForm->getValue("cantidad") : $CurrentForm->getValue("x_cantidad");
        if (!$this->cantidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cantidad->Visible = false; // Disable update for API request
            } else {
                $this->cantidad->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_cantidad")) {
            $this->cantidad->setOldValue($CurrentForm->getValue("o_cantidad"));
        }

        // Check field name 'descripcion' first before field var 'x_descripcion'
        $val = $CurrentForm->hasValue("descripcion") ? $CurrentForm->getValue("descripcion") : $CurrentForm->getValue("x_descripcion");
        if (!$this->descripcion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion->Visible = false; // Disable update for API request
            } else {
                $this->descripcion->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_descripcion")) {
            $this->descripcion->setOldValue($CurrentForm->getValue("o_descripcion"));
        }

        // Check field name 'disponible' first before field var 'x_disponible'
        $val = $CurrentForm->hasValue("disponible") ? $CurrentForm->getValue("disponible") : $CurrentForm->getValue("x_disponible");
        if (!$this->disponible->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->disponible->Visible = false; // Disable update for API request
            } else {
                $this->disponible->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_disponible")) {
            $this->disponible->setOldValue($CurrentForm->getValue("o_disponible"));
        }

        // Check field name 'unidad_medida_recibida' first before field var 'x_unidad_medida_recibida'
        $val = $CurrentForm->hasValue("unidad_medida_recibida") ? $CurrentForm->getValue("unidad_medida_recibida") : $CurrentForm->getValue("x_unidad_medida_recibida");
        if (!$this->unidad_medida_recibida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unidad_medida_recibida->Visible = false; // Disable update for API request
            } else {
                $this->unidad_medida_recibida->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_unidad_medida_recibida")) {
            $this->unidad_medida_recibida->setOldValue($CurrentForm->getValue("o_unidad_medida_recibida"));
        }

        // Check field name 'cantidad_recibida' first before field var 'x_cantidad_recibida'
        $val = $CurrentForm->hasValue("cantidad_recibida") ? $CurrentForm->getValue("cantidad_recibida") : $CurrentForm->getValue("x_cantidad_recibida");
        if (!$this->cantidad_recibida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cantidad_recibida->Visible = false; // Disable update for API request
            } else {
                $this->cantidad_recibida->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_cantidad_recibida")) {
            $this->cantidad_recibida->setOldValue($CurrentForm->getValue("o_cantidad_recibida"));
        }

        // Check field name 'Norden_compra_detalle' first before field var 'x_Norden_compra_detalle'
        $val = $CurrentForm->hasValue("Norden_compra_detalle") ? $CurrentForm->getValue("Norden_compra_detalle") : $CurrentForm->getValue("x_Norden_compra_detalle");
        if (!$this->Norden_compra_detalle->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->Norden_compra_detalle->setFormValue($val);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->Norden_compra_detalle->CurrentValue = $this->Norden_compra_detalle->FormValue;
        }
        $this->tipo_insumo->CurrentValue = $this->tipo_insumo->FormValue;
        $this->articulo->CurrentValue = $this->articulo->FormValue;
        $this->unidad_medida->CurrentValue = $this->unidad_medida->FormValue;
        $this->cantidad->CurrentValue = $this->cantidad->FormValue;
        $this->descripcion->CurrentValue = $this->descripcion->FormValue;
        $this->disponible->CurrentValue = $this->disponible->FormValue;
        $this->unidad_medida_recibida->CurrentValue = $this->unidad_medida_recibida->FormValue;
        $this->cantidad_recibida->CurrentValue = $this->cantidad_recibida->FormValue;
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
        $this->Norden_compra_detalle->setDbValue($row['Norden_compra_detalle']);
        $this->orden_compra->setDbValue($row['orden_compra']);
        $this->tipo_insumo->setDbValue($row['tipo_insumo']);
        $this->articulo->setDbValue($row['articulo']);
        $this->unidad_medida->setDbValue($row['unidad_medida']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->descripcion->setDbValue($row['descripcion']);
        $this->imagen->Upload->DbValue = $row['imagen'];
        $this->imagen->setDbValue($this->imagen->Upload->DbValue);
        $this->disponible->setDbValue($row['disponible']);
        $this->unidad_medida_recibida->setDbValue($row['unidad_medida_recibida']);
        $this->cantidad_recibida->setDbValue($row['cantidad_recibida']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Norden_compra_detalle'] = $this->Norden_compra_detalle->DefaultValue;
        $row['orden_compra'] = $this->orden_compra->DefaultValue;
        $row['tipo_insumo'] = $this->tipo_insumo->DefaultValue;
        $row['articulo'] = $this->articulo->DefaultValue;
        $row['unidad_medida'] = $this->unidad_medida->DefaultValue;
        $row['cantidad'] = $this->cantidad->DefaultValue;
        $row['descripcion'] = $this->descripcion->DefaultValue;
        $row['imagen'] = $this->imagen->DefaultValue;
        $row['disponible'] = $this->disponible->DefaultValue;
        $row['unidad_medida_recibida'] = $this->unidad_medida_recibida->DefaultValue;
        $row['cantidad_recibida'] = $this->cantidad_recibida->DefaultValue;
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

        // Norden_compra_detalle

        // orden_compra

        // tipo_insumo

        // articulo

        // unidad_medida

        // cantidad

        // descripcion

        // imagen

        // disponible

        // unidad_medida_recibida

        // cantidad_recibida

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Norden_compra_detalle
            $this->Norden_compra_detalle->ViewValue = $this->Norden_compra_detalle->CurrentValue;

            // orden_compra
            $this->orden_compra->ViewValue = $this->orden_compra->CurrentValue;

            // tipo_insumo
            $curVal = strval($this->tipo_insumo->CurrentValue);
            if ($curVal != "") {
                $this->tipo_insumo->ViewValue = $this->tipo_insumo->lookupCacheOption($curVal);
                if ($this->tipo_insumo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo_insumo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_insumo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_insumo->ViewValue = $this->tipo_insumo->displayValue($arwrk);
                    } else {
                        $this->tipo_insumo->ViewValue = $this->tipo_insumo->CurrentValue;
                    }
                }
            } else {
                $this->tipo_insumo->ViewValue = null;
            }

            // articulo
            $curVal = strval($this->articulo->CurrentValue);
            if ($curVal != "") {
                $this->articulo->ViewValue = $this->articulo->lookupCacheOption($curVal);
                if ($this->articulo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $curVal, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                    $sqlWrk = $this->articulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                        $this->articulo->ViewValue = $this->articulo->displayValue($arwrk);
                    } else {
                        $this->articulo->ViewValue = $this->articulo->CurrentValue;
                    }
                }
            } else {
                $this->articulo->ViewValue = null;
            }

            // unidad_medida
            $curVal = strval($this->unidad_medida->CurrentValue);
            if ($curVal != "") {
                $this->unidad_medida->ViewValue = $this->unidad_medida->lookupCacheOption($curVal);
                if ($this->unidad_medida->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unidad_medida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unidad_medida->Lookup->renderViewRow($rswrk[0]);
                        $this->unidad_medida->ViewValue = $this->unidad_medida->displayValue($arwrk);
                    } else {
                        $this->unidad_medida->ViewValue = $this->unidad_medida->CurrentValue;
                    }
                }
            } else {
                $this->unidad_medida->ViewValue = null;
            }

            // cantidad
            $this->cantidad->ViewValue = $this->cantidad->CurrentValue;
            $this->cantidad->ViewValue = FormatNumber($this->cantidad->ViewValue, $this->cantidad->formatPattern());

            // descripcion
            $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->ImageWidth = 120;
                $this->imagen->ImageHeight = 120;
                $this->imagen->ImageAlt = $this->imagen->alt();
                $this->imagen->ImageCssClass = "ew-image";
                $this->imagen->ViewValue = $this->imagen->Upload->DbValue;
            } else {
                $this->imagen->ViewValue = "";
            }

            // disponible
            if (strval($this->disponible->CurrentValue) != "") {
                $this->disponible->ViewValue = $this->disponible->optionCaption($this->disponible->CurrentValue);
            } else {
                $this->disponible->ViewValue = null;
            }

            // unidad_medida_recibida
            $curVal = strval($this->unidad_medida_recibida->CurrentValue);
            if ($curVal != "") {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->lookupCacheOption($curVal);
                if ($this->unidad_medida_recibida->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->unidad_medida_recibida->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unidad_medida_recibida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unidad_medida_recibida->Lookup->renderViewRow($rswrk[0]);
                        $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->displayValue($arwrk);
                    } else {
                        $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->CurrentValue;
                    }
                }
            } else {
                $this->unidad_medida_recibida->ViewValue = null;
            }

            // cantidad_recibida
            $this->cantidad_recibida->ViewValue = $this->cantidad_recibida->CurrentValue;
            $this->cantidad_recibida->ViewValue = FormatNumber($this->cantidad_recibida->ViewValue, $this->cantidad_recibida->formatPattern());

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";
            $this->tipo_insumo->TooltipValue = "";

            // articulo
            $this->articulo->HrefValue = "";
            $this->articulo->TooltipValue = "";

            // unidad_medida
            $this->unidad_medida->HrefValue = "";
            $this->unidad_medida->TooltipValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";
            $this->cantidad->TooltipValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";
            $this->descripcion->TooltipValue = "";

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->HrefValue = GetFileUploadUrl($this->imagen, $this->imagen->htmlDecode($this->imagen->Upload->DbValue)); // Add prefix/suffix
                $this->imagen->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->imagen->HrefValue = FullUrl($this->imagen->HrefValue, "href");
                }
            } else {
                $this->imagen->HrefValue = "";
            }
            $this->imagen->ExportHrefValue = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
            $this->imagen->TooltipValue = "";
            if ($this->imagen->UseColorbox) {
                if (EmptyValue($this->imagen->TooltipValue)) {
                    $this->imagen->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->imagen->LinkAttrs["data-rel"] = "sco_orden_compra_detalle_x" . $this->RowCount . "_imagen";
                $this->imagen->LinkAttrs->appendClass("ew-lightbox");
            }

            // disponible
            $this->disponible->HrefValue = "";
            $this->disponible->TooltipValue = "";

            // unidad_medida_recibida
            $this->unidad_medida_recibida->HrefValue = "";
            $this->unidad_medida_recibida->TooltipValue = "";

            // cantidad_recibida
            $this->cantidad_recibida->HrefValue = "";
            $this->cantidad_recibida->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // tipo_insumo
            $this->tipo_insumo->setupEditAttributes();
            $curVal = trim(strval($this->tipo_insumo->CurrentValue));
            if ($curVal != "") {
                $this->tipo_insumo->ViewValue = $this->tipo_insumo->lookupCacheOption($curVal);
            } else {
                $this->tipo_insumo->ViewValue = $this->tipo_insumo->Lookup !== null && is_array($this->tipo_insumo->lookupOptions()) && count($this->tipo_insumo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_insumo->ViewValue !== null) { // Load from cache
                $this->tipo_insumo->EditValue = array_values($this->tipo_insumo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->tipo_insumo->CurrentValue, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_insumo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_insumo->EditValue = $arwrk;
            }
            $this->tipo_insumo->PlaceHolder = RemoveHtml($this->tipo_insumo->caption());

            // articulo
            $curVal = trim(strval($this->articulo->CurrentValue));
            if ($curVal != "") {
                $this->articulo->ViewValue = $this->articulo->lookupCacheOption($curVal);
            } else {
                $this->articulo->ViewValue = $this->articulo->Lookup !== null && is_array($this->articulo->lookupOptions()) && count($this->articulo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->articulo->ViewValue !== null) { // Load from cache
                $this->articulo->EditValue = array_values($this->articulo->lookupOptions());
                if ($this->articulo->ViewValue == "") {
                    $this->articulo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $this->articulo->CurrentValue, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                }
                $sqlWrk = $this->articulo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                    $this->articulo->ViewValue = $this->articulo->displayValue($arwrk);
                } else {
                    $this->articulo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->articulo->EditValue = $arwrk;
            }
            $this->articulo->PlaceHolder = RemoveHtml($this->articulo->caption());

            // unidad_medida
            $this->unidad_medida->setupEditAttributes();
            $curVal = trim(strval($this->unidad_medida->CurrentValue));
            if ($curVal != "") {
                $this->unidad_medida->ViewValue = $this->unidad_medida->lookupCacheOption($curVal);
            } else {
                $this->unidad_medida->ViewValue = $this->unidad_medida->Lookup !== null && is_array($this->unidad_medida->lookupOptions()) && count($this->unidad_medida->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->unidad_medida->ViewValue !== null) { // Load from cache
                $this->unidad_medida->EditValue = array_values($this->unidad_medida->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->unidad_medida->CurrentValue, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unidad_medida->EditValue = $arwrk;
            }
            $this->unidad_medida->PlaceHolder = RemoveHtml($this->unidad_medida->caption());

            // cantidad
            $this->cantidad->setupEditAttributes();
            $this->cantidad->EditValue = $this->cantidad->CurrentValue;
            $this->cantidad->PlaceHolder = RemoveHtml($this->cantidad->caption());
            if (strval($this->cantidad->EditValue) != "" && is_numeric($this->cantidad->EditValue)) {
                $this->cantidad->EditValue = FormatNumber($this->cantidad->EditValue, null);
            }

            // descripcion
            $this->descripcion->setupEditAttributes();
            if (!$this->descripcion->Raw) {
                $this->descripcion->CurrentValue = HtmlDecode($this->descripcion->CurrentValue);
            }
            $this->descripcion->EditValue = HtmlEncode($this->descripcion->CurrentValue);
            $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

            // imagen
            $this->imagen->setupEditAttributes();
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->ImageWidth = 120;
                $this->imagen->ImageHeight = 120;
                $this->imagen->ImageAlt = $this->imagen->alt();
                $this->imagen->ImageCssClass = "ew-image";
                $this->imagen->EditValue = $this->imagen->Upload->DbValue;
            } else {
                $this->imagen->EditValue = "";
            }
            if (!EmptyValue($this->imagen->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->imagen->Upload->FileName = "";
                } else {
                    $this->imagen->Upload->FileName = $this->imagen->CurrentValue;
                }
            }
            if (!Config("CREATE_UPLOAD_FILE_ON_COPY")) {
                $this->imagen->Upload->DbValue = null;
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->imagen, $this->RowIndex);
            }

            // disponible
            $this->disponible->setupEditAttributes();
            $this->disponible->EditValue = $this->disponible->options(true);
            $this->disponible->PlaceHolder = RemoveHtml($this->disponible->caption());

            // unidad_medida_recibida
            $this->unidad_medida_recibida->setupEditAttributes();
            $curVal = trim(strval($this->unidad_medida_recibida->CurrentValue));
            if ($curVal != "") {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->lookupCacheOption($curVal);
            } else {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->Lookup !== null && is_array($this->unidad_medida_recibida->lookupOptions()) && count($this->unidad_medida_recibida->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->unidad_medida_recibida->ViewValue !== null) { // Load from cache
                $this->unidad_medida_recibida->EditValue = array_values($this->unidad_medida_recibida->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->unidad_medida_recibida->CurrentValue, $this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->unidad_medida_recibida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida_recibida->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unidad_medida_recibida->EditValue = $arwrk;
            }
            $this->unidad_medida_recibida->PlaceHolder = RemoveHtml($this->unidad_medida_recibida->caption());

            // cantidad_recibida
            $this->cantidad_recibida->setupEditAttributes();
            $this->cantidad_recibida->EditValue = $this->cantidad_recibida->CurrentValue;
            $this->cantidad_recibida->PlaceHolder = RemoveHtml($this->cantidad_recibida->caption());
            if (strval($this->cantidad_recibida->EditValue) != "" && is_numeric($this->cantidad_recibida->EditValue)) {
                $this->cantidad_recibida->EditValue = FormatNumber($this->cantidad_recibida->EditValue, null);
            }

            // Add refer script

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";

            // articulo
            $this->articulo->HrefValue = "";

            // unidad_medida
            $this->unidad_medida->HrefValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->HrefValue = GetFileUploadUrl($this->imagen, $this->imagen->htmlDecode($this->imagen->Upload->DbValue)); // Add prefix/suffix
                $this->imagen->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->imagen->HrefValue = FullUrl($this->imagen->HrefValue, "href");
                }
            } else {
                $this->imagen->HrefValue = "";
            }
            $this->imagen->ExportHrefValue = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;

            // disponible
            $this->disponible->HrefValue = "";

            // unidad_medida_recibida
            $this->unidad_medida_recibida->HrefValue = "";

            // cantidad_recibida
            $this->cantidad_recibida->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // tipo_insumo
            $this->tipo_insumo->setupEditAttributes();
            $curVal = strval($this->tipo_insumo->CurrentValue);
            if ($curVal != "") {
                $this->tipo_insumo->EditValue = $this->tipo_insumo->lookupCacheOption($curVal);
                if ($this->tipo_insumo->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo_insumo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_insumo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_insumo->EditValue = $this->tipo_insumo->displayValue($arwrk);
                    } else {
                        $this->tipo_insumo->EditValue = $this->tipo_insumo->CurrentValue;
                    }
                }
            } else {
                $this->tipo_insumo->EditValue = null;
            }

            // articulo
            $this->articulo->setupEditAttributes();
            $curVal = strval($this->articulo->CurrentValue);
            if ($curVal != "") {
                $this->articulo->EditValue = $this->articulo->lookupCacheOption($curVal);
                if ($this->articulo->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $curVal, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                    $sqlWrk = $this->articulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                        $this->articulo->EditValue = $this->articulo->displayValue($arwrk);
                    } else {
                        $this->articulo->EditValue = $this->articulo->CurrentValue;
                    }
                }
            } else {
                $this->articulo->EditValue = null;
            }

            // unidad_medida
            $this->unidad_medida->setupEditAttributes();
            $curVal = strval($this->unidad_medida->CurrentValue);
            if ($curVal != "") {
                $this->unidad_medida->EditValue = $this->unidad_medida->lookupCacheOption($curVal);
                if ($this->unidad_medida->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unidad_medida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unidad_medida->Lookup->renderViewRow($rswrk[0]);
                        $this->unidad_medida->EditValue = $this->unidad_medida->displayValue($arwrk);
                    } else {
                        $this->unidad_medida->EditValue = $this->unidad_medida->CurrentValue;
                    }
                }
            } else {
                $this->unidad_medida->EditValue = null;
            }

            // cantidad
            $this->cantidad->setupEditAttributes();
            $this->cantidad->EditValue = $this->cantidad->CurrentValue;
            $this->cantidad->EditValue = FormatNumber($this->cantidad->EditValue, $this->cantidad->formatPattern());

            // descripcion
            $this->descripcion->setupEditAttributes();
            $this->descripcion->EditValue = $this->descripcion->CurrentValue;

            // imagen
            $this->imagen->setupEditAttributes();
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->ImageWidth = 120;
                $this->imagen->ImageHeight = 120;
                $this->imagen->ImageAlt = $this->imagen->alt();
                $this->imagen->ImageCssClass = "ew-image";
                $this->imagen->EditValue = $this->imagen->Upload->DbValue;
            } else {
                $this->imagen->EditValue = "";
            }

            // disponible
            $this->disponible->setupEditAttributes();
            $this->disponible->EditValue = $this->disponible->options(true);
            $this->disponible->PlaceHolder = RemoveHtml($this->disponible->caption());

            // unidad_medida_recibida
            $this->unidad_medida_recibida->setupEditAttributes();
            $curVal = trim(strval($this->unidad_medida_recibida->CurrentValue));
            if ($curVal != "") {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->lookupCacheOption($curVal);
            } else {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->Lookup !== null && is_array($this->unidad_medida_recibida->lookupOptions()) && count($this->unidad_medida_recibida->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->unidad_medida_recibida->ViewValue !== null) { // Load from cache
                $this->unidad_medida_recibida->EditValue = array_values($this->unidad_medida_recibida->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->unidad_medida_recibida->CurrentValue, $this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->unidad_medida_recibida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida_recibida->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unidad_medida_recibida->EditValue = $arwrk;
            }
            $this->unidad_medida_recibida->PlaceHolder = RemoveHtml($this->unidad_medida_recibida->caption());

            // cantidad_recibida
            $this->cantidad_recibida->setupEditAttributes();
            $this->cantidad_recibida->EditValue = $this->cantidad_recibida->CurrentValue;
            $this->cantidad_recibida->PlaceHolder = RemoveHtml($this->cantidad_recibida->caption());
            if (strval($this->cantidad_recibida->EditValue) != "" && is_numeric($this->cantidad_recibida->EditValue)) {
                $this->cantidad_recibida->EditValue = FormatNumber($this->cantidad_recibida->EditValue, null);
            }

            // Edit refer script

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";
            $this->tipo_insumo->TooltipValue = "";

            // articulo
            $this->articulo->HrefValue = "";
            $this->articulo->TooltipValue = "";

            // unidad_medida
            $this->unidad_medida->HrefValue = "";
            $this->unidad_medida->TooltipValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";
            $this->cantidad->TooltipValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";
            $this->descripcion->TooltipValue = "";

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->HrefValue = GetFileUploadUrl($this->imagen, $this->imagen->htmlDecode($this->imagen->Upload->DbValue)); // Add prefix/suffix
                $this->imagen->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->imagen->HrefValue = FullUrl($this->imagen->HrefValue, "href");
                }
            } else {
                $this->imagen->HrefValue = "";
            }
            $this->imagen->ExportHrefValue = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
            $this->imagen->TooltipValue = "";
            if ($this->imagen->UseColorbox) {
                if (EmptyValue($this->imagen->TooltipValue)) {
                    $this->imagen->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->imagen->LinkAttrs["data-rel"] = "sco_orden_compra_detalle_x" . $this->RowCount . "_imagen";
                $this->imagen->LinkAttrs->appendClass("ew-lightbox");
            }

            // disponible
            $this->disponible->HrefValue = "";

            // unidad_medida_recibida
            $this->unidad_medida_recibida->HrefValue = "";

            // cantidad_recibida
            $this->cantidad_recibida->HrefValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // tipo_insumo
            $this->tipo_insumo->setupEditAttributes();
            $this->tipo_insumo->PlaceHolder = RemoveHtml($this->tipo_insumo->caption());

            // articulo
            $this->articulo->setupEditAttributes();
            $this->articulo->PlaceHolder = RemoveHtml($this->articulo->caption());

            // unidad_medida
            $this->unidad_medida->setupEditAttributes();
            $this->unidad_medida->PlaceHolder = RemoveHtml($this->unidad_medida->caption());

            // cantidad
            $this->cantidad->setupEditAttributes();
            $this->cantidad->EditValue = $this->cantidad->AdvancedSearch->SearchValue;
            $this->cantidad->PlaceHolder = RemoveHtml($this->cantidad->caption());

            // descripcion
            $this->descripcion->setupEditAttributes();
            if (!$this->descripcion->Raw) {
                $this->descripcion->AdvancedSearch->SearchValue = HtmlDecode($this->descripcion->AdvancedSearch->SearchValue);
            }
            $this->descripcion->EditValue = HtmlEncode($this->descripcion->AdvancedSearch->SearchValue);
            $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

            // imagen
            $this->imagen->setupEditAttributes();
            if (!$this->imagen->Raw) {
                $this->imagen->AdvancedSearch->SearchValue = HtmlDecode($this->imagen->AdvancedSearch->SearchValue);
            }
            $this->imagen->EditValue = HtmlEncode($this->imagen->AdvancedSearch->SearchValue);
            $this->imagen->PlaceHolder = RemoveHtml($this->imagen->caption());

            // disponible
            $this->disponible->setupEditAttributes();
            $this->disponible->EditValue = $this->disponible->options(true);
            $this->disponible->PlaceHolder = RemoveHtml($this->disponible->caption());

            // unidad_medida_recibida
            $this->unidad_medida_recibida->setupEditAttributes();
            $this->unidad_medida_recibida->PlaceHolder = RemoveHtml($this->unidad_medida_recibida->caption());

            // cantidad_recibida
            $this->cantidad_recibida->setupEditAttributes();
            $this->cantidad_recibida->EditValue = $this->cantidad_recibida->AdvancedSearch->SearchValue;
            $this->cantidad_recibida->PlaceHolder = RemoveHtml($this->cantidad_recibida->caption());
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
            if ($this->tipo_insumo->Visible && $this->tipo_insumo->Required) {
                if (!$this->tipo_insumo->IsDetailKey && EmptyValue($this->tipo_insumo->FormValue)) {
                    $this->tipo_insumo->addErrorMessage(str_replace("%s", $this->tipo_insumo->caption(), $this->tipo_insumo->RequiredErrorMessage));
                }
            }
            if ($this->articulo->Visible && $this->articulo->Required) {
                if (!$this->articulo->IsDetailKey && EmptyValue($this->articulo->FormValue)) {
                    $this->articulo->addErrorMessage(str_replace("%s", $this->articulo->caption(), $this->articulo->RequiredErrorMessage));
                }
            }
            if ($this->unidad_medida->Visible && $this->unidad_medida->Required) {
                if (!$this->unidad_medida->IsDetailKey && EmptyValue($this->unidad_medida->FormValue)) {
                    $this->unidad_medida->addErrorMessage(str_replace("%s", $this->unidad_medida->caption(), $this->unidad_medida->RequiredErrorMessage));
                }
            }
            if ($this->cantidad->Visible && $this->cantidad->Required) {
                if (!$this->cantidad->IsDetailKey && EmptyValue($this->cantidad->FormValue)) {
                    $this->cantidad->addErrorMessage(str_replace("%s", $this->cantidad->caption(), $this->cantidad->RequiredErrorMessage));
                }
            }
            if ($this->descripcion->Visible && $this->descripcion->Required) {
                if (!$this->descripcion->IsDetailKey && EmptyValue($this->descripcion->FormValue)) {
                    $this->descripcion->addErrorMessage(str_replace("%s", $this->descripcion->caption(), $this->descripcion->RequiredErrorMessage));
                }
            }
            if ($this->imagen->Visible && $this->imagen->Required) {
                if ($this->imagen->Upload->FileName == "" && !$this->imagen->Upload->KeepFile) {
                    $this->imagen->addErrorMessage(str_replace("%s", $this->imagen->caption(), $this->imagen->RequiredErrorMessage));
                }
            }
            if ($this->disponible->Visible && $this->disponible->Required) {
                if (!$this->disponible->IsDetailKey && EmptyValue($this->disponible->FormValue)) {
                    $this->disponible->addErrorMessage(str_replace("%s", $this->disponible->caption(), $this->disponible->RequiredErrorMessage));
                }
            }
            if ($this->unidad_medida_recibida->Visible && $this->unidad_medida_recibida->Required) {
                if (!$this->unidad_medida_recibida->IsDetailKey && EmptyValue($this->unidad_medida_recibida->FormValue)) {
                    $this->unidad_medida_recibida->addErrorMessage(str_replace("%s", $this->unidad_medida_recibida->caption(), $this->unidad_medida_recibida->RequiredErrorMessage));
                }
            }
            if ($this->cantidad_recibida->Visible && $this->cantidad_recibida->Required) {
                if (!$this->cantidad_recibida->IsDetailKey && EmptyValue($this->cantidad_recibida->FormValue)) {
                    $this->cantidad_recibida->addErrorMessage(str_replace("%s", $this->cantidad_recibida->caption(), $this->cantidad_recibida->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->cantidad_recibida->FormValue)) {
                $this->cantidad_recibida->addErrorMessage($this->cantidad_recibida->getErrorMessage(false));
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
            $thisKey .= $row['Norden_compra_detalle'];

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

        // Check referential integrity for master table 'sco_orden_compra'
        $detailKeys = [];
        $keyValue = $rsnew['orden_compra'] ?? $rsold['orden_compra'];
        $detailKeys['orden_compra'] = $keyValue;
        $masterTable = Container("sco_orden_compra");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "sco_orden_compra", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }

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

        // disponible
        $this->disponible->setDbValueDef($rsnew, $this->disponible->CurrentValue, $this->disponible->ReadOnly);

        // unidad_medida_recibida
        $this->unidad_medida_recibida->setDbValueDef($rsnew, $this->unidad_medida_recibida->CurrentValue, $this->unidad_medida_recibida->ReadOnly);

        // cantidad_recibida
        $this->cantidad_recibida->setDbValueDef($rsnew, $this->cantidad_recibida->CurrentValue, $this->cantidad_recibida->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['disponible'])) { // disponible
            $this->disponible->CurrentValue = $row['disponible'];
        }
        if (isset($row['unidad_medida_recibida'])) { // unidad_medida_recibida
            $this->unidad_medida_recibida->CurrentValue = $row['unidad_medida_recibida'];
        }
        if (isset($row['cantidad_recibida'])) { // cantidad_recibida
            $this->cantidad_recibida->CurrentValue = $row['cantidad_recibida'];
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
        $hash .= GetFieldHash($row['disponible']); // disponible
        $hash .= GetFieldHash($row['unidad_medida_recibida']); // unidad_medida_recibida
        $hash .= GetFieldHash($row['cantidad_recibida']); // cantidad_recibida
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();
        if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
            if (!EmptyValue($this->imagen->Upload->FileName)) {
                $this->imagen->Upload->DbValue = null;
                FixUploadFileNames($this->imagen);
                $this->imagen->setDbValueDef($rsnew, $this->imagen->Upload->FileName, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'sco_orden_compra_detalle'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["orden_compra"] = $this->orden_compra->getSessionValue();
        $masterTable = Container("sco_orden_compra");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "sco_orden_compra", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
                    $this->imagen->Upload->DbValue = null;
                    if (!SaveUploadFiles($this->imagen, $rsnew['imagen'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
                    }
                }
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

        // tipo_insumo
        $this->tipo_insumo->setDbValueDef($rsnew, $this->tipo_insumo->CurrentValue, false);

        // articulo
        $this->articulo->setDbValueDef($rsnew, $this->articulo->CurrentValue, false);

        // unidad_medida
        $this->unidad_medida->setDbValueDef($rsnew, $this->unidad_medida->CurrentValue, false);

        // cantidad
        $this->cantidad->setDbValueDef($rsnew, $this->cantidad->CurrentValue, false);

        // descripcion
        $this->descripcion->setDbValueDef($rsnew, $this->descripcion->CurrentValue, false);

        // imagen
        if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
            if ($this->imagen->Upload->FileName == "") {
                $rsnew['imagen'] = null;
            } else {
                FixUploadTempFileNames($this->imagen);
                $rsnew['imagen'] = $this->imagen->Upload->FileName;
            }
        }

        // disponible
        $this->disponible->setDbValueDef($rsnew, $this->disponible->CurrentValue, strval($this->disponible->CurrentValue) == "");

        // unidad_medida_recibida
        $this->unidad_medida_recibida->setDbValueDef($rsnew, $this->unidad_medida_recibida->CurrentValue, false);

        // cantidad_recibida
        $this->cantidad_recibida->setDbValueDef($rsnew, $this->cantidad_recibida->CurrentValue, false);

        // orden_compra
        if ($this->orden_compra->getSessionValue() != "") {
            $rsnew['orden_compra'] = $this->orden_compra->getSessionValue();
        }
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['tipo_insumo'])) { // tipo_insumo
            $this->tipo_insumo->setFormValue($row['tipo_insumo']);
        }
        if (isset($row['articulo'])) { // articulo
            $this->articulo->setFormValue($row['articulo']);
        }
        if (isset($row['unidad_medida'])) { // unidad_medida
            $this->unidad_medida->setFormValue($row['unidad_medida']);
        }
        if (isset($row['cantidad'])) { // cantidad
            $this->cantidad->setFormValue($row['cantidad']);
        }
        if (isset($row['descripcion'])) { // descripcion
            $this->descripcion->setFormValue($row['descripcion']);
        }
        if (isset($row['imagen'])) { // imagen
            $this->imagen->setFormValue($row['imagen']);
        }
        if (isset($row['disponible'])) { // disponible
            $this->disponible->setFormValue($row['disponible']);
        }
        if (isset($row['unidad_medida_recibida'])) { // unidad_medida_recibida
            $this->unidad_medida_recibida->setFormValue($row['unidad_medida_recibida']);
        }
        if (isset($row['cantidad_recibida'])) { // cantidad_recibida
            $this->cantidad_recibida->setFormValue($row['cantidad_recibida']);
        }
        if (isset($row['orden_compra'])) { // orden_compra
            $this->orden_compra->setFormValue($row['orden_compra']);
        }
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->Norden_compra_detalle->AdvancedSearch->load();
        $this->orden_compra->AdvancedSearch->load();
        $this->tipo_insumo->AdvancedSearch->load();
        $this->articulo->AdvancedSearch->load();
        $this->unidad_medida->AdvancedSearch->load();
        $this->cantidad->AdvancedSearch->load();
        $this->descripcion->AdvancedSearch->load();
        $this->imagen->AdvancedSearch->load();
        $this->disponible->AdvancedSearch->load();
        $this->unidad_medida_recibida->AdvancedSearch->load();
        $this->cantidad_recibida->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_orden_compra_detallesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
            if ($masterTblVar == "sco_orden_compra") {
                $validMaster = true;
                $masterTbl = Container("sco_orden_compra");
                if (($parm = Get("fk_Norden_compra", Get("orden_compra"))) !== null) {
                    $masterTbl->Norden_compra->setQueryStringValue($parm);
                    $this->orden_compra->QueryStringValue = $masterTbl->Norden_compra->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->orden_compra->setSessionValue($this->orden_compra->QueryStringValue);
                    $foreignKeys["orden_compra"] = $this->orden_compra->QueryStringValue;
                    if (!is_numeric($masterTbl->Norden_compra->QueryStringValue)) {
                        $validMaster = false;
                    }
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
            if ($masterTblVar == "sco_orden_compra") {
                $validMaster = true;
                $masterTbl = Container("sco_orden_compra");
                if (($parm = Post("fk_Norden_compra", Post("orden_compra"))) !== null) {
                    $masterTbl->Norden_compra->setFormValue($parm);
                    $this->orden_compra->FormValue = $masterTbl->Norden_compra->FormValue;
                    $this->orden_compra->setSessionValue($this->orden_compra->FormValue);
                    $foreignKeys["orden_compra"] = $this->orden_compra->FormValue;
                    if (!is_numeric($masterTbl->Norden_compra->FormValue)) {
                        $validMaster = false;
                    }
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
            if ($masterTblVar != "sco_orden_compra") {
                if (!array_key_exists("orden_compra", $foreignKeys)) { // Not current foreign key
                    $this->orden_compra->setSessionValue("");
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
                case "x_tipo_insumo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_articulo":
                    break;
                case "x_unidad_medida":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_disponible":
                    break;
                case "x_unidad_medida_recibida":
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
