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
class ScoParcelaVentasList extends ScoParcelaVentas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoParcelaVentasList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_parcela_ventaslist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoParcelaVentasList";

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
        $this->Nparcela_ventas->setVisibility();
        $this->fecha_compra->setVisibility();
        $this->usuario_compra->setVisibility();
        $this->terraza->Visible = false;
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->subseccion->setVisibility();
        $this->parcela->setVisibility();
        $this->ci_vendedor->Visible = false;
        $this->vendedor->setVisibility();
        $this->valor_compra->Visible = false;
        $this->moneda_compra->Visible = false;
        $this->tasa_compra->Visible = false;
        $this->fecha_venta->Visible = false;
        $this->usuario_vende->Visible = false;
        $this->ci_comprador->Visible = false;
        $this->comprador->Visible = false;
        $this->valor_venta->Visible = false;
        $this->moneda_venta->Visible = false;
        $this->tasa_venta->Visible = false;
        $this->id_parcela->Visible = false;
        $this->nota->Visible = false;
        $this->estatus->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->numero_factura->Visible = false;
        $this->orden_pago->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_parcela_ventas';
        $this->TableName = 'sco_parcela_ventas';

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

        // Table object (sco_parcela_ventas)
        if (!isset($GLOBALS["sco_parcela_ventas"]) || $GLOBALS["sco_parcela_ventas"]::class == PROJECT_NAMESPACE . "sco_parcela_ventas") {
            $GLOBALS["sco_parcela_ventas"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoParcelaVentasAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoParcelaVentasDelete";
        $this->MultiUpdateUrl = "ScoParcelaVentasUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_parcela_ventas');
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
                    $result["view"] = SameString($pageName, "ScoParcelaVentasView"); // If View page, no primary button
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
            $key .= @$ar['Nparcela_ventas'];
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
            $this->Nparcela_ventas->Visible = false;
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
        $this->setupLookupOptions($this->usuario_compra);
        $this->setupLookupOptions($this->moneda_compra);
        $this->setupLookupOptions($this->usuario_vende);
        $this->setupLookupOptions($this->moneda_venta);
        $this->setupLookupOptions($this->estatus);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_parcela_ventasgrid";
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
        $filterList = Concat($filterList, $this->Nparcela_ventas->AdvancedSearch->toJson(), ","); // Field Nparcela_ventas
        $filterList = Concat($filterList, $this->fecha_compra->AdvancedSearch->toJson(), ","); // Field fecha_compra
        $filterList = Concat($filterList, $this->usuario_compra->AdvancedSearch->toJson(), ","); // Field usuario_compra
        $filterList = Concat($filterList, $this->terraza->AdvancedSearch->toJson(), ","); // Field terraza
        $filterList = Concat($filterList, $this->seccion->AdvancedSearch->toJson(), ","); // Field seccion
        $filterList = Concat($filterList, $this->modulo->AdvancedSearch->toJson(), ","); // Field modulo
        $filterList = Concat($filterList, $this->subseccion->AdvancedSearch->toJson(), ","); // Field subseccion
        $filterList = Concat($filterList, $this->parcela->AdvancedSearch->toJson(), ","); // Field parcela
        $filterList = Concat($filterList, $this->ci_vendedor->AdvancedSearch->toJson(), ","); // Field ci_vendedor
        $filterList = Concat($filterList, $this->vendedor->AdvancedSearch->toJson(), ","); // Field vendedor
        $filterList = Concat($filterList, $this->valor_compra->AdvancedSearch->toJson(), ","); // Field valor_compra
        $filterList = Concat($filterList, $this->moneda_compra->AdvancedSearch->toJson(), ","); // Field moneda_compra
        $filterList = Concat($filterList, $this->tasa_compra->AdvancedSearch->toJson(), ","); // Field tasa_compra
        $filterList = Concat($filterList, $this->fecha_venta->AdvancedSearch->toJson(), ","); // Field fecha_venta
        $filterList = Concat($filterList, $this->usuario_vende->AdvancedSearch->toJson(), ","); // Field usuario_vende
        $filterList = Concat($filterList, $this->ci_comprador->AdvancedSearch->toJson(), ","); // Field ci_comprador
        $filterList = Concat($filterList, $this->comprador->AdvancedSearch->toJson(), ","); // Field comprador
        $filterList = Concat($filterList, $this->valor_venta->AdvancedSearch->toJson(), ","); // Field valor_venta
        $filterList = Concat($filterList, $this->moneda_venta->AdvancedSearch->toJson(), ","); // Field moneda_venta
        $filterList = Concat($filterList, $this->tasa_venta->AdvancedSearch->toJson(), ","); // Field tasa_venta
        $filterList = Concat($filterList, $this->id_parcela->AdvancedSearch->toJson(), ","); // Field id_parcela
        $filterList = Concat($filterList, $this->nota->AdvancedSearch->toJson(), ","); // Field nota
        $filterList = Concat($filterList, $this->estatus->AdvancedSearch->toJson(), ","); // Field estatus
        $filterList = Concat($filterList, $this->fecha_registro->AdvancedSearch->toJson(), ","); // Field fecha_registro
        $filterList = Concat($filterList, $this->numero_factura->AdvancedSearch->toJson(), ","); // Field numero_factura
        $filterList = Concat($filterList, $this->orden_pago->AdvancedSearch->toJson(), ","); // Field orden_pago
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
            Profile()->setSearchFilters("fsco_parcela_ventassrch", $filters);
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

        // Field Nparcela_ventas
        $this->Nparcela_ventas->AdvancedSearch->SearchValue = @$filter["x_Nparcela_ventas"];
        $this->Nparcela_ventas->AdvancedSearch->SearchOperator = @$filter["z_Nparcela_ventas"];
        $this->Nparcela_ventas->AdvancedSearch->SearchCondition = @$filter["v_Nparcela_ventas"];
        $this->Nparcela_ventas->AdvancedSearch->SearchValue2 = @$filter["y_Nparcela_ventas"];
        $this->Nparcela_ventas->AdvancedSearch->SearchOperator2 = @$filter["w_Nparcela_ventas"];
        $this->Nparcela_ventas->AdvancedSearch->save();

        // Field fecha_compra
        $this->fecha_compra->AdvancedSearch->SearchValue = @$filter["x_fecha_compra"];
        $this->fecha_compra->AdvancedSearch->SearchOperator = @$filter["z_fecha_compra"];
        $this->fecha_compra->AdvancedSearch->SearchCondition = @$filter["v_fecha_compra"];
        $this->fecha_compra->AdvancedSearch->SearchValue2 = @$filter["y_fecha_compra"];
        $this->fecha_compra->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_compra"];
        $this->fecha_compra->AdvancedSearch->save();

        // Field usuario_compra
        $this->usuario_compra->AdvancedSearch->SearchValue = @$filter["x_usuario_compra"];
        $this->usuario_compra->AdvancedSearch->SearchOperator = @$filter["z_usuario_compra"];
        $this->usuario_compra->AdvancedSearch->SearchCondition = @$filter["v_usuario_compra"];
        $this->usuario_compra->AdvancedSearch->SearchValue2 = @$filter["y_usuario_compra"];
        $this->usuario_compra->AdvancedSearch->SearchOperator2 = @$filter["w_usuario_compra"];
        $this->usuario_compra->AdvancedSearch->save();

        // Field terraza
        $this->terraza->AdvancedSearch->SearchValue = @$filter["x_terraza"];
        $this->terraza->AdvancedSearch->SearchOperator = @$filter["z_terraza"];
        $this->terraza->AdvancedSearch->SearchCondition = @$filter["v_terraza"];
        $this->terraza->AdvancedSearch->SearchValue2 = @$filter["y_terraza"];
        $this->terraza->AdvancedSearch->SearchOperator2 = @$filter["w_terraza"];
        $this->terraza->AdvancedSearch->save();

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

        // Field subseccion
        $this->subseccion->AdvancedSearch->SearchValue = @$filter["x_subseccion"];
        $this->subseccion->AdvancedSearch->SearchOperator = @$filter["z_subseccion"];
        $this->subseccion->AdvancedSearch->SearchCondition = @$filter["v_subseccion"];
        $this->subseccion->AdvancedSearch->SearchValue2 = @$filter["y_subseccion"];
        $this->subseccion->AdvancedSearch->SearchOperator2 = @$filter["w_subseccion"];
        $this->subseccion->AdvancedSearch->save();

        // Field parcela
        $this->parcela->AdvancedSearch->SearchValue = @$filter["x_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator = @$filter["z_parcela"];
        $this->parcela->AdvancedSearch->SearchCondition = @$filter["v_parcela"];
        $this->parcela->AdvancedSearch->SearchValue2 = @$filter["y_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator2 = @$filter["w_parcela"];
        $this->parcela->AdvancedSearch->save();

        // Field ci_vendedor
        $this->ci_vendedor->AdvancedSearch->SearchValue = @$filter["x_ci_vendedor"];
        $this->ci_vendedor->AdvancedSearch->SearchOperator = @$filter["z_ci_vendedor"];
        $this->ci_vendedor->AdvancedSearch->SearchCondition = @$filter["v_ci_vendedor"];
        $this->ci_vendedor->AdvancedSearch->SearchValue2 = @$filter["y_ci_vendedor"];
        $this->ci_vendedor->AdvancedSearch->SearchOperator2 = @$filter["w_ci_vendedor"];
        $this->ci_vendedor->AdvancedSearch->save();

        // Field vendedor
        $this->vendedor->AdvancedSearch->SearchValue = @$filter["x_vendedor"];
        $this->vendedor->AdvancedSearch->SearchOperator = @$filter["z_vendedor"];
        $this->vendedor->AdvancedSearch->SearchCondition = @$filter["v_vendedor"];
        $this->vendedor->AdvancedSearch->SearchValue2 = @$filter["y_vendedor"];
        $this->vendedor->AdvancedSearch->SearchOperator2 = @$filter["w_vendedor"];
        $this->vendedor->AdvancedSearch->save();

        // Field valor_compra
        $this->valor_compra->AdvancedSearch->SearchValue = @$filter["x_valor_compra"];
        $this->valor_compra->AdvancedSearch->SearchOperator = @$filter["z_valor_compra"];
        $this->valor_compra->AdvancedSearch->SearchCondition = @$filter["v_valor_compra"];
        $this->valor_compra->AdvancedSearch->SearchValue2 = @$filter["y_valor_compra"];
        $this->valor_compra->AdvancedSearch->SearchOperator2 = @$filter["w_valor_compra"];
        $this->valor_compra->AdvancedSearch->save();

        // Field moneda_compra
        $this->moneda_compra->AdvancedSearch->SearchValue = @$filter["x_moneda_compra"];
        $this->moneda_compra->AdvancedSearch->SearchOperator = @$filter["z_moneda_compra"];
        $this->moneda_compra->AdvancedSearch->SearchCondition = @$filter["v_moneda_compra"];
        $this->moneda_compra->AdvancedSearch->SearchValue2 = @$filter["y_moneda_compra"];
        $this->moneda_compra->AdvancedSearch->SearchOperator2 = @$filter["w_moneda_compra"];
        $this->moneda_compra->AdvancedSearch->save();

        // Field tasa_compra
        $this->tasa_compra->AdvancedSearch->SearchValue = @$filter["x_tasa_compra"];
        $this->tasa_compra->AdvancedSearch->SearchOperator = @$filter["z_tasa_compra"];
        $this->tasa_compra->AdvancedSearch->SearchCondition = @$filter["v_tasa_compra"];
        $this->tasa_compra->AdvancedSearch->SearchValue2 = @$filter["y_tasa_compra"];
        $this->tasa_compra->AdvancedSearch->SearchOperator2 = @$filter["w_tasa_compra"];
        $this->tasa_compra->AdvancedSearch->save();

        // Field fecha_venta
        $this->fecha_venta->AdvancedSearch->SearchValue = @$filter["x_fecha_venta"];
        $this->fecha_venta->AdvancedSearch->SearchOperator = @$filter["z_fecha_venta"];
        $this->fecha_venta->AdvancedSearch->SearchCondition = @$filter["v_fecha_venta"];
        $this->fecha_venta->AdvancedSearch->SearchValue2 = @$filter["y_fecha_venta"];
        $this->fecha_venta->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_venta"];
        $this->fecha_venta->AdvancedSearch->save();

        // Field usuario_vende
        $this->usuario_vende->AdvancedSearch->SearchValue = @$filter["x_usuario_vende"];
        $this->usuario_vende->AdvancedSearch->SearchOperator = @$filter["z_usuario_vende"];
        $this->usuario_vende->AdvancedSearch->SearchCondition = @$filter["v_usuario_vende"];
        $this->usuario_vende->AdvancedSearch->SearchValue2 = @$filter["y_usuario_vende"];
        $this->usuario_vende->AdvancedSearch->SearchOperator2 = @$filter["w_usuario_vende"];
        $this->usuario_vende->AdvancedSearch->save();

        // Field ci_comprador
        $this->ci_comprador->AdvancedSearch->SearchValue = @$filter["x_ci_comprador"];
        $this->ci_comprador->AdvancedSearch->SearchOperator = @$filter["z_ci_comprador"];
        $this->ci_comprador->AdvancedSearch->SearchCondition = @$filter["v_ci_comprador"];
        $this->ci_comprador->AdvancedSearch->SearchValue2 = @$filter["y_ci_comprador"];
        $this->ci_comprador->AdvancedSearch->SearchOperator2 = @$filter["w_ci_comprador"];
        $this->ci_comprador->AdvancedSearch->save();

        // Field comprador
        $this->comprador->AdvancedSearch->SearchValue = @$filter["x_comprador"];
        $this->comprador->AdvancedSearch->SearchOperator = @$filter["z_comprador"];
        $this->comprador->AdvancedSearch->SearchCondition = @$filter["v_comprador"];
        $this->comprador->AdvancedSearch->SearchValue2 = @$filter["y_comprador"];
        $this->comprador->AdvancedSearch->SearchOperator2 = @$filter["w_comprador"];
        $this->comprador->AdvancedSearch->save();

        // Field valor_venta
        $this->valor_venta->AdvancedSearch->SearchValue = @$filter["x_valor_venta"];
        $this->valor_venta->AdvancedSearch->SearchOperator = @$filter["z_valor_venta"];
        $this->valor_venta->AdvancedSearch->SearchCondition = @$filter["v_valor_venta"];
        $this->valor_venta->AdvancedSearch->SearchValue2 = @$filter["y_valor_venta"];
        $this->valor_venta->AdvancedSearch->SearchOperator2 = @$filter["w_valor_venta"];
        $this->valor_venta->AdvancedSearch->save();

        // Field moneda_venta
        $this->moneda_venta->AdvancedSearch->SearchValue = @$filter["x_moneda_venta"];
        $this->moneda_venta->AdvancedSearch->SearchOperator = @$filter["z_moneda_venta"];
        $this->moneda_venta->AdvancedSearch->SearchCondition = @$filter["v_moneda_venta"];
        $this->moneda_venta->AdvancedSearch->SearchValue2 = @$filter["y_moneda_venta"];
        $this->moneda_venta->AdvancedSearch->SearchOperator2 = @$filter["w_moneda_venta"];
        $this->moneda_venta->AdvancedSearch->save();

        // Field tasa_venta
        $this->tasa_venta->AdvancedSearch->SearchValue = @$filter["x_tasa_venta"];
        $this->tasa_venta->AdvancedSearch->SearchOperator = @$filter["z_tasa_venta"];
        $this->tasa_venta->AdvancedSearch->SearchCondition = @$filter["v_tasa_venta"];
        $this->tasa_venta->AdvancedSearch->SearchValue2 = @$filter["y_tasa_venta"];
        $this->tasa_venta->AdvancedSearch->SearchOperator2 = @$filter["w_tasa_venta"];
        $this->tasa_venta->AdvancedSearch->save();

        // Field id_parcela
        $this->id_parcela->AdvancedSearch->SearchValue = @$filter["x_id_parcela"];
        $this->id_parcela->AdvancedSearch->SearchOperator = @$filter["z_id_parcela"];
        $this->id_parcela->AdvancedSearch->SearchCondition = @$filter["v_id_parcela"];
        $this->id_parcela->AdvancedSearch->SearchValue2 = @$filter["y_id_parcela"];
        $this->id_parcela->AdvancedSearch->SearchOperator2 = @$filter["w_id_parcela"];
        $this->id_parcela->AdvancedSearch->save();

        // Field nota
        $this->nota->AdvancedSearch->SearchValue = @$filter["x_nota"];
        $this->nota->AdvancedSearch->SearchOperator = @$filter["z_nota"];
        $this->nota->AdvancedSearch->SearchCondition = @$filter["v_nota"];
        $this->nota->AdvancedSearch->SearchValue2 = @$filter["y_nota"];
        $this->nota->AdvancedSearch->SearchOperator2 = @$filter["w_nota"];
        $this->nota->AdvancedSearch->save();

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

        // Field numero_factura
        $this->numero_factura->AdvancedSearch->SearchValue = @$filter["x_numero_factura"];
        $this->numero_factura->AdvancedSearch->SearchOperator = @$filter["z_numero_factura"];
        $this->numero_factura->AdvancedSearch->SearchCondition = @$filter["v_numero_factura"];
        $this->numero_factura->AdvancedSearch->SearchValue2 = @$filter["y_numero_factura"];
        $this->numero_factura->AdvancedSearch->SearchOperator2 = @$filter["w_numero_factura"];
        $this->numero_factura->AdvancedSearch->save();

        // Field orden_pago
        $this->orden_pago->AdvancedSearch->SearchValue = @$filter["x_orden_pago"];
        $this->orden_pago->AdvancedSearch->SearchOperator = @$filter["z_orden_pago"];
        $this->orden_pago->AdvancedSearch->SearchCondition = @$filter["v_orden_pago"];
        $this->orden_pago->AdvancedSearch->SearchValue2 = @$filter["y_orden_pago"];
        $this->orden_pago->AdvancedSearch->SearchOperator2 = @$filter["w_orden_pago"];
        $this->orden_pago->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->Nparcela_ventas, $default, false); // Nparcela_ventas
        $this->buildSearchSql($where, $this->fecha_compra, $default, false); // fecha_compra
        $this->buildSearchSql($where, $this->usuario_compra, $default, false); // usuario_compra
        $this->buildSearchSql($where, $this->terraza, $default, false); // terraza
        $this->buildSearchSql($where, $this->seccion, $default, false); // seccion
        $this->buildSearchSql($where, $this->modulo, $default, false); // modulo
        $this->buildSearchSql($where, $this->subseccion, $default, false); // subseccion
        $this->buildSearchSql($where, $this->parcela, $default, false); // parcela
        $this->buildSearchSql($where, $this->ci_vendedor, $default, false); // ci_vendedor
        $this->buildSearchSql($where, $this->vendedor, $default, false); // vendedor
        $this->buildSearchSql($where, $this->valor_compra, $default, false); // valor_compra
        $this->buildSearchSql($where, $this->moneda_compra, $default, false); // moneda_compra
        $this->buildSearchSql($where, $this->tasa_compra, $default, false); // tasa_compra
        $this->buildSearchSql($where, $this->fecha_venta, $default, false); // fecha_venta
        $this->buildSearchSql($where, $this->usuario_vende, $default, false); // usuario_vende
        $this->buildSearchSql($where, $this->ci_comprador, $default, false); // ci_comprador
        $this->buildSearchSql($where, $this->comprador, $default, false); // comprador
        $this->buildSearchSql($where, $this->valor_venta, $default, false); // valor_venta
        $this->buildSearchSql($where, $this->moneda_venta, $default, false); // moneda_venta
        $this->buildSearchSql($where, $this->tasa_venta, $default, false); // tasa_venta
        $this->buildSearchSql($where, $this->id_parcela, $default, false); // id_parcela
        $this->buildSearchSql($where, $this->nota, $default, false); // nota
        $this->buildSearchSql($where, $this->estatus, $default, false); // estatus
        $this->buildSearchSql($where, $this->fecha_registro, $default, false); // fecha_registro
        $this->buildSearchSql($where, $this->numero_factura, $default, false); // numero_factura
        $this->buildSearchSql($where, $this->orden_pago, $default, false); // orden_pago

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Nparcela_ventas->AdvancedSearch->save(); // Nparcela_ventas
            $this->fecha_compra->AdvancedSearch->save(); // fecha_compra
            $this->usuario_compra->AdvancedSearch->save(); // usuario_compra
            $this->terraza->AdvancedSearch->save(); // terraza
            $this->seccion->AdvancedSearch->save(); // seccion
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->subseccion->AdvancedSearch->save(); // subseccion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->ci_vendedor->AdvancedSearch->save(); // ci_vendedor
            $this->vendedor->AdvancedSearch->save(); // vendedor
            $this->valor_compra->AdvancedSearch->save(); // valor_compra
            $this->moneda_compra->AdvancedSearch->save(); // moneda_compra
            $this->tasa_compra->AdvancedSearch->save(); // tasa_compra
            $this->fecha_venta->AdvancedSearch->save(); // fecha_venta
            $this->usuario_vende->AdvancedSearch->save(); // usuario_vende
            $this->ci_comprador->AdvancedSearch->save(); // ci_comprador
            $this->comprador->AdvancedSearch->save(); // comprador
            $this->valor_venta->AdvancedSearch->save(); // valor_venta
            $this->moneda_venta->AdvancedSearch->save(); // moneda_venta
            $this->tasa_venta->AdvancedSearch->save(); // tasa_venta
            $this->id_parcela->AdvancedSearch->save(); // id_parcela
            $this->nota->AdvancedSearch->save(); // nota
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->numero_factura->AdvancedSearch->save(); // numero_factura
            $this->orden_pago->AdvancedSearch->save(); // orden_pago

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
            $this->Nparcela_ventas->AdvancedSearch->save(); // Nparcela_ventas
            $this->fecha_compra->AdvancedSearch->save(); // fecha_compra
            $this->usuario_compra->AdvancedSearch->save(); // usuario_compra
            $this->terraza->AdvancedSearch->save(); // terraza
            $this->seccion->AdvancedSearch->save(); // seccion
            $this->modulo->AdvancedSearch->save(); // modulo
            $this->subseccion->AdvancedSearch->save(); // subseccion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->ci_vendedor->AdvancedSearch->save(); // ci_vendedor
            $this->vendedor->AdvancedSearch->save(); // vendedor
            $this->valor_compra->AdvancedSearch->save(); // valor_compra
            $this->moneda_compra->AdvancedSearch->save(); // moneda_compra
            $this->tasa_compra->AdvancedSearch->save(); // tasa_compra
            $this->fecha_venta->AdvancedSearch->save(); // fecha_venta
            $this->usuario_vende->AdvancedSearch->save(); // usuario_vende
            $this->ci_comprador->AdvancedSearch->save(); // ci_comprador
            $this->comprador->AdvancedSearch->save(); // comprador
            $this->valor_venta->AdvancedSearch->save(); // valor_venta
            $this->moneda_venta->AdvancedSearch->save(); // moneda_venta
            $this->tasa_venta->AdvancedSearch->save(); // tasa_venta
            $this->id_parcela->AdvancedSearch->save(); // id_parcela
            $this->nota->AdvancedSearch->save(); // nota
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->numero_factura->AdvancedSearch->save(); // numero_factura
            $this->orden_pago->AdvancedSearch->save(); // orden_pago
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

        // Field Nparcela_ventas
        $filter = $this->queryBuilderWhere("Nparcela_ventas");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->Nparcela_ventas, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->Nparcela_ventas->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecha_compra
        $filter = $this->queryBuilderWhere("fecha_compra");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecha_compra, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecha_compra->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field usuario_compra
        $filter = $this->queryBuilderWhere("usuario_compra");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->usuario_compra, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->usuario_compra->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field subseccion
        $filter = $this->queryBuilderWhere("subseccion");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->subseccion, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->subseccion->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field parcela
        $filter = $this->queryBuilderWhere("parcela");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->parcela, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->parcela->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field vendedor
        $filter = $this->queryBuilderWhere("vendedor");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->vendedor, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->vendedor->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->terraza;
        $searchFlds[] = &$this->seccion;
        $searchFlds[] = &$this->modulo;
        $searchFlds[] = &$this->subseccion;
        $searchFlds[] = &$this->parcela;
        $searchFlds[] = &$this->ci_vendedor;
        $searchFlds[] = &$this->vendedor;
        $searchFlds[] = &$this->moneda_compra;
        $searchFlds[] = &$this->ci_comprador;
        $searchFlds[] = &$this->comprador;
        $searchFlds[] = &$this->moneda_venta;
        $searchFlds[] = &$this->id_parcela;
        $searchFlds[] = &$this->nota;
        $searchFlds[] = &$this->estatus;
        $searchFlds[] = &$this->numero_factura;
        $searchFlds[] = &$this->orden_pago;
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
        if ($this->Nparcela_ventas->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_compra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usuario_compra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->terraza->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->seccion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->modulo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->subseccion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->parcela->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ci_vendedor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->vendedor->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->valor_compra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->moneda_compra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tasa_compra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_venta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->usuario_vende->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ci_comprador->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->comprador->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->valor_venta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->moneda_venta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tasa_venta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->id_parcela->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nota->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estatus->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_registro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->numero_factura->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->orden_pago->AdvancedSearch->issetSession()) {
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
        $this->Nparcela_ventas->AdvancedSearch->unsetSession();
        $this->fecha_compra->AdvancedSearch->unsetSession();
        $this->usuario_compra->AdvancedSearch->unsetSession();
        $this->terraza->AdvancedSearch->unsetSession();
        $this->seccion->AdvancedSearch->unsetSession();
        $this->modulo->AdvancedSearch->unsetSession();
        $this->subseccion->AdvancedSearch->unsetSession();
        $this->parcela->AdvancedSearch->unsetSession();
        $this->ci_vendedor->AdvancedSearch->unsetSession();
        $this->vendedor->AdvancedSearch->unsetSession();
        $this->valor_compra->AdvancedSearch->unsetSession();
        $this->moneda_compra->AdvancedSearch->unsetSession();
        $this->tasa_compra->AdvancedSearch->unsetSession();
        $this->fecha_venta->AdvancedSearch->unsetSession();
        $this->usuario_vende->AdvancedSearch->unsetSession();
        $this->ci_comprador->AdvancedSearch->unsetSession();
        $this->comprador->AdvancedSearch->unsetSession();
        $this->valor_venta->AdvancedSearch->unsetSession();
        $this->moneda_venta->AdvancedSearch->unsetSession();
        $this->tasa_venta->AdvancedSearch->unsetSession();
        $this->id_parcela->AdvancedSearch->unsetSession();
        $this->nota->AdvancedSearch->unsetSession();
        $this->estatus->AdvancedSearch->unsetSession();
        $this->fecha_registro->AdvancedSearch->unsetSession();
        $this->numero_factura->AdvancedSearch->unsetSession();
        $this->orden_pago->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Nparcela_ventas->AdvancedSearch->load();
        $this->fecha_compra->AdvancedSearch->load();
        $this->usuario_compra->AdvancedSearch->load();
        $this->terraza->AdvancedSearch->load();
        $this->seccion->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->subseccion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->ci_vendedor->AdvancedSearch->load();
        $this->vendedor->AdvancedSearch->load();
        $this->valor_compra->AdvancedSearch->load();
        $this->moneda_compra->AdvancedSearch->load();
        $this->tasa_compra->AdvancedSearch->load();
        $this->fecha_venta->AdvancedSearch->load();
        $this->usuario_vende->AdvancedSearch->load();
        $this->ci_comprador->AdvancedSearch->load();
        $this->comprador->AdvancedSearch->load();
        $this->valor_venta->AdvancedSearch->load();
        $this->moneda_venta->AdvancedSearch->load();
        $this->tasa_venta->AdvancedSearch->load();
        $this->id_parcela->AdvancedSearch->load();
        $this->nota->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->numero_factura->AdvancedSearch->load();
        $this->orden_pago->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->estatus->Expression . " ASC" . ", " . $this->fecha_venta->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->Nparcela_ventas); // Nparcela_ventas
            $this->updateSort($this->fecha_compra); // fecha_compra
            $this->updateSort($this->usuario_compra); // usuario_compra
            $this->updateSort($this->seccion); // seccion
            $this->updateSort($this->modulo); // modulo
            $this->updateSort($this->subseccion); // subseccion
            $this->updateSort($this->parcela); // parcela
            $this->updateSort($this->vendedor); // vendedor
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
                $this->Nparcela_ventas->setSort("");
                $this->fecha_compra->setSort("");
                $this->usuario_compra->setSort("");
                $this->terraza->setSort("");
                $this->seccion->setSort("");
                $this->modulo->setSort("");
                $this->subseccion->setSort("");
                $this->parcela->setSort("");
                $this->ci_vendedor->setSort("");
                $this->vendedor->setSort("");
                $this->valor_compra->setSort("");
                $this->moneda_compra->setSort("");
                $this->tasa_compra->setSort("");
                $this->fecha_venta->setSort("");
                $this->usuario_vende->setSort("");
                $this->ci_comprador->setSort("");
                $this->comprador->setSort("");
                $this->valor_venta->setSort("");
                $this->moneda_venta->setSort("");
                $this->tasa_venta->setSort("");
                $this->id_parcela->setSort("");
                $this->nota->setSort("");
                $this->estatus->setSort("");
                $this->fecha_registro->setSort("");
                $this->numero_factura->setSort("");
                $this->orden_pago->setSort("");
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

        // "detail_sco_parcela_ventas_nota"
        $item = &$this->ListOptions->add("detail_sco_parcela_ventas_nota");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_parcela_ventas_nota');
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
        $pages->add("sco_parcela_ventas_nota");
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_parcela_ventas\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_parcela_ventas\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_parcela_ventaslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_parcela_ventaslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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

        // "detail_sco_parcela_ventas_nota"
        $opt = $this->ListOptions["detail_sco_parcela_ventas_nota"];
        if ($Security->allowList(CurrentProjectID() . 'sco_parcela_ventas_nota')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_parcela_ventas_nota", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoParcelaVentasNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_parcela_ventas&" . GetForeignKeyUrl("fk_Nparcela_ventas", $this->Nparcela_ventas->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoParcelaVentasNotaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_parcela_ventas')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela_ventas_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_parcela_ventas_nota";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_parcela_ventas')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela_ventas_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_parcela_ventas_nota";
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
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->Nparcela_ventas->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
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
        $masterKeys["Nparcela_ventas"] = strval($this->Nparcela_ventas->DbValue);

        // Column "detail_sco_parcela_ventas_nota"
        if ($this->DetailPages?->getItem("sco_parcela_ventas_nota")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_parcela_ventas_nota')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_parcela_ventas_nota"];
            $detailTbl = Container("sco_parcela_ventas_nota");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoParcelaVentasNotaPreview?t=sco_parcela_ventas&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_parcela_ventas_nota\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_parcela_ventas')) {
                $label = $Language->tablePhrase("sco_parcela_ventas_nota", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_parcela_ventas_nota\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoParcelaVentasNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_parcela_ventas");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_parcela_ventas_nota", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoParcelaVentasNotaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_parcela_ventas')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela_ventas_nota"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_parcela_ventas')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela_ventas_nota"));
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_parcela_ventas\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
        $item = &$option->add("detailadd_sco_parcela_ventas_nota");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela_ventas_nota");
        $detailPage = Container("ScoParcelaVentasNotaGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_parcela_ventas') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_parcela_ventas_nota";
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
            $this->createColumnOption($option, "Nparcela_ventas");
            $this->createColumnOption($option, "fecha_compra");
            $this->createColumnOption($option, "usuario_compra");
            $this->createColumnOption($option, "seccion");
            $this->createColumnOption($option, "modulo");
            $this->createColumnOption($option, "subseccion");
            $this->createColumnOption($option, "parcela");
            $this->createColumnOption($option, "vendedor");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_parcela_ventassrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_parcela_ventassrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_parcela_ventaslist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_parcela_ventas", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_sco_parcela_ventas",
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

        // Nparcela_ventas
        if ($this->Nparcela_ventas->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Nparcela_ventas->AdvancedSearch->SearchValue != "" || $this->Nparcela_ventas->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_compra
        if ($this->fecha_compra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_compra->AdvancedSearch->SearchValue != "" || $this->fecha_compra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usuario_compra
        if ($this->usuario_compra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usuario_compra->AdvancedSearch->SearchValue != "" || $this->usuario_compra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // terraza
        if ($this->terraza->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->terraza->AdvancedSearch->SearchValue != "" || $this->terraza->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // subseccion
        if ($this->subseccion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->subseccion->AdvancedSearch->SearchValue != "" || $this->subseccion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // ci_vendedor
        if ($this->ci_vendedor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ci_vendedor->AdvancedSearch->SearchValue != "" || $this->ci_vendedor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // vendedor
        if ($this->vendedor->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->vendedor->AdvancedSearch->SearchValue != "" || $this->vendedor->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // valor_compra
        if ($this->valor_compra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->valor_compra->AdvancedSearch->SearchValue != "" || $this->valor_compra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // moneda_compra
        if ($this->moneda_compra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->moneda_compra->AdvancedSearch->SearchValue != "" || $this->moneda_compra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tasa_compra
        if ($this->tasa_compra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tasa_compra->AdvancedSearch->SearchValue != "" || $this->tasa_compra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_venta
        if ($this->fecha_venta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_venta->AdvancedSearch->SearchValue != "" || $this->fecha_venta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // usuario_vende
        if ($this->usuario_vende->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->usuario_vende->AdvancedSearch->SearchValue != "" || $this->usuario_vende->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ci_comprador
        if ($this->ci_comprador->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ci_comprador->AdvancedSearch->SearchValue != "" || $this->ci_comprador->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // comprador
        if ($this->comprador->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->comprador->AdvancedSearch->SearchValue != "" || $this->comprador->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // valor_venta
        if ($this->valor_venta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->valor_venta->AdvancedSearch->SearchValue != "" || $this->valor_venta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // moneda_venta
        if ($this->moneda_venta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->moneda_venta->AdvancedSearch->SearchValue != "" || $this->moneda_venta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tasa_venta
        if ($this->tasa_venta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tasa_venta->AdvancedSearch->SearchValue != "" || $this->tasa_venta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // id_parcela
        if ($this->id_parcela->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->id_parcela->AdvancedSearch->SearchValue != "" || $this->id_parcela->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // numero_factura
        if ($this->numero_factura->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->numero_factura->AdvancedSearch->SearchValue != "" || $this->numero_factura->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // orden_pago
        if ($this->orden_pago->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->orden_pago->AdvancedSearch->SearchValue != "" || $this->orden_pago->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->Nparcela_ventas->setDbValue($row['Nparcela_ventas']);
        $this->fecha_compra->setDbValue($row['fecha_compra']);
        $this->usuario_compra->setDbValue($row['usuario_compra']);
        $this->terraza->setDbValue($row['terraza']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->subseccion->setDbValue($row['subseccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->ci_vendedor->setDbValue($row['ci_vendedor']);
        $this->vendedor->setDbValue($row['vendedor']);
        $this->valor_compra->setDbValue($row['valor_compra']);
        $this->moneda_compra->setDbValue($row['moneda_compra']);
        $this->tasa_compra->setDbValue($row['tasa_compra']);
        $this->fecha_venta->setDbValue($row['fecha_venta']);
        $this->usuario_vende->setDbValue($row['usuario_vende']);
        $this->ci_comprador->setDbValue($row['ci_comprador']);
        $this->comprador->setDbValue($row['comprador']);
        $this->valor_venta->setDbValue($row['valor_venta']);
        $this->moneda_venta->setDbValue($row['moneda_venta']);
        $this->tasa_venta->setDbValue($row['tasa_venta']);
        $this->id_parcela->setDbValue($row['id_parcela']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->numero_factura->setDbValue($row['numero_factura']);
        $this->orden_pago->setDbValue($row['orden_pago']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nparcela_ventas'] = $this->Nparcela_ventas->DefaultValue;
        $row['fecha_compra'] = $this->fecha_compra->DefaultValue;
        $row['usuario_compra'] = $this->usuario_compra->DefaultValue;
        $row['terraza'] = $this->terraza->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['subseccion'] = $this->subseccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['ci_vendedor'] = $this->ci_vendedor->DefaultValue;
        $row['vendedor'] = $this->vendedor->DefaultValue;
        $row['valor_compra'] = $this->valor_compra->DefaultValue;
        $row['moneda_compra'] = $this->moneda_compra->DefaultValue;
        $row['tasa_compra'] = $this->tasa_compra->DefaultValue;
        $row['fecha_venta'] = $this->fecha_venta->DefaultValue;
        $row['usuario_vende'] = $this->usuario_vende->DefaultValue;
        $row['ci_comprador'] = $this->ci_comprador->DefaultValue;
        $row['comprador'] = $this->comprador->DefaultValue;
        $row['valor_venta'] = $this->valor_venta->DefaultValue;
        $row['moneda_venta'] = $this->moneda_venta->DefaultValue;
        $row['tasa_venta'] = $this->tasa_venta->DefaultValue;
        $row['id_parcela'] = $this->id_parcela->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['numero_factura'] = $this->numero_factura->DefaultValue;
        $row['orden_pago'] = $this->orden_pago->DefaultValue;
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

        // Nparcela_ventas

        // fecha_compra

        // usuario_compra

        // terraza

        // seccion

        // modulo

        // subseccion

        // parcela

        // ci_vendedor

        // vendedor

        // valor_compra

        // moneda_compra

        // tasa_compra

        // fecha_venta

        // usuario_vende

        // ci_comprador

        // comprador

        // valor_venta

        // moneda_venta

        // tasa_venta

        // id_parcela

        // nota

        // estatus

        // fecha_registro

        // numero_factura

        // orden_pago

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nparcela_ventas
            $this->Nparcela_ventas->ViewValue = $this->Nparcela_ventas->CurrentValue;

            // fecha_compra
            $this->fecha_compra->ViewValue = $this->fecha_compra->CurrentValue;
            $this->fecha_compra->ViewValue = FormatDateTime($this->fecha_compra->ViewValue, $this->fecha_compra->formatPattern());

            // usuario_compra
            $this->usuario_compra->ViewValue = $this->usuario_compra->CurrentValue;
            $curVal = strval($this->usuario_compra->CurrentValue);
            if ($curVal != "") {
                $this->usuario_compra->ViewValue = $this->usuario_compra->lookupCacheOption($curVal);
                if ($this->usuario_compra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_compra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->usuario_compra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_compra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_compra->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_compra->ViewValue = $this->usuario_compra->displayValue($arwrk);
                    } else {
                        $this->usuario_compra->ViewValue = $this->usuario_compra->CurrentValue;
                    }
                }
            } else {
                $this->usuario_compra->ViewValue = null;
            }

            // terraza
            $this->terraza->ViewValue = $this->terraza->CurrentValue;

            // seccion
            $this->seccion->ViewValue = $this->seccion->CurrentValue;

            // modulo
            $this->modulo->ViewValue = $this->modulo->CurrentValue;

            // subseccion
            $this->subseccion->ViewValue = $this->subseccion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // ci_vendedor
            $this->ci_vendedor->ViewValue = $this->ci_vendedor->CurrentValue;

            // vendedor
            $this->vendedor->ViewValue = $this->vendedor->CurrentValue;

            // valor_compra
            $this->valor_compra->ViewValue = $this->valor_compra->CurrentValue;
            $this->valor_compra->ViewValue = FormatNumber($this->valor_compra->ViewValue, $this->valor_compra->formatPattern());

            // moneda_compra
            $curVal = strval($this->moneda_compra->CurrentValue);
            if ($curVal != "") {
                $this->moneda_compra->ViewValue = $this->moneda_compra->lookupCacheOption($curVal);
                if ($this->moneda_compra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->moneda_compra->getSelectFilter($this); // PHP
                    $sqlWrk = $this->moneda_compra->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->moneda_compra->Lookup->renderViewRow($rswrk[0]);
                        $this->moneda_compra->ViewValue = $this->moneda_compra->displayValue($arwrk);
                    } else {
                        $this->moneda_compra->ViewValue = $this->moneda_compra->CurrentValue;
                    }
                }
            } else {
                $this->moneda_compra->ViewValue = null;
            }

            // tasa_compra
            $this->tasa_compra->ViewValue = $this->tasa_compra->CurrentValue;
            $this->tasa_compra->ViewValue = FormatNumber($this->tasa_compra->ViewValue, $this->tasa_compra->formatPattern());

            // fecha_venta
            $this->fecha_venta->ViewValue = $this->fecha_venta->CurrentValue;
            $this->fecha_venta->ViewValue = FormatDateTime($this->fecha_venta->ViewValue, $this->fecha_venta->formatPattern());

            // usuario_vende
            $curVal = strval($this->usuario_vende->CurrentValue);
            if ($curVal != "") {
                $this->usuario_vende->ViewValue = $this->usuario_vende->lookupCacheOption($curVal);
                if ($this->usuario_vende->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_vende->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->usuario_vende->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_vende->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_vende->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_vende->ViewValue = $this->usuario_vende->displayValue($arwrk);
                    } else {
                        $this->usuario_vende->ViewValue = $this->usuario_vende->CurrentValue;
                    }
                }
            } else {
                $this->usuario_vende->ViewValue = null;
            }

            // ci_comprador
            $this->ci_comprador->ViewValue = $this->ci_comprador->CurrentValue;

            // comprador
            $this->comprador->ViewValue = $this->comprador->CurrentValue;

            // valor_venta
            $this->valor_venta->ViewValue = $this->valor_venta->CurrentValue;
            $this->valor_venta->ViewValue = FormatNumber($this->valor_venta->ViewValue, $this->valor_venta->formatPattern());

            // moneda_venta
            $curVal = strval($this->moneda_venta->CurrentValue);
            if ($curVal != "") {
                $this->moneda_venta->ViewValue = $this->moneda_venta->lookupCacheOption($curVal);
                if ($this->moneda_venta->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->moneda_venta->getSelectFilter($this); // PHP
                    $sqlWrk = $this->moneda_venta->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->moneda_venta->Lookup->renderViewRow($rswrk[0]);
                        $this->moneda_venta->ViewValue = $this->moneda_venta->displayValue($arwrk);
                    } else {
                        $this->moneda_venta->ViewValue = $this->moneda_venta->CurrentValue;
                    }
                }
            } else {
                $this->moneda_venta->ViewValue = null;
            }

            // tasa_venta
            $this->tasa_venta->ViewValue = $this->tasa_venta->CurrentValue;
            $this->tasa_venta->ViewValue = FormatNumber($this->tasa_venta->ViewValue, $this->tasa_venta->formatPattern());

            // id_parcela
            $this->id_parcela->ViewValue = $this->id_parcela->CurrentValue;

            // estatus
            if (strval($this->estatus->CurrentValue) != "") {
                $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
            } else {
                $this->estatus->ViewValue = null;
            }

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // numero_factura
            $this->numero_factura->ViewValue = $this->numero_factura->CurrentValue;

            // orden_pago
            $this->orden_pago->ViewValue = $this->orden_pago->CurrentValue;

            // Nparcela_ventas
            $this->Nparcela_ventas->HrefValue = "";
            $this->Nparcela_ventas->TooltipValue = "";

            // fecha_compra
            $this->fecha_compra->HrefValue = "";
            $this->fecha_compra->TooltipValue = "";

            // usuario_compra
            $this->usuario_compra->HrefValue = "";
            $this->usuario_compra->TooltipValue = "";

            // seccion
            $this->seccion->HrefValue = "";
            $this->seccion->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // subseccion
            $this->subseccion->HrefValue = "";
            $this->subseccion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";

            // vendedor
            $this->vendedor->HrefValue = "";
            $this->vendedor->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // Nparcela_ventas
            $this->Nparcela_ventas->setupEditAttributes();
            $this->Nparcela_ventas->EditValue = $this->Nparcela_ventas->AdvancedSearch->SearchValue;
            $this->Nparcela_ventas->PlaceHolder = RemoveHtml($this->Nparcela_ventas->caption());

            // fecha_compra
            $this->fecha_compra->setupEditAttributes();
            $this->fecha_compra->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_compra->AdvancedSearch->SearchValue, $this->fecha_compra->formatPattern()), $this->fecha_compra->formatPattern()));
            $this->fecha_compra->PlaceHolder = RemoveHtml($this->fecha_compra->caption());

            // usuario_compra
            $this->usuario_compra->setupEditAttributes();
            if (!$this->usuario_compra->Raw) {
                $this->usuario_compra->AdvancedSearch->SearchValue = HtmlDecode($this->usuario_compra->AdvancedSearch->SearchValue);
            }
            $this->usuario_compra->EditValue = HtmlEncode($this->usuario_compra->AdvancedSearch->SearchValue);
            $this->usuario_compra->PlaceHolder = RemoveHtml($this->usuario_compra->caption());

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

            // subseccion
            $this->subseccion->setupEditAttributes();
            if (!$this->subseccion->Raw) {
                $this->subseccion->AdvancedSearch->SearchValue = HtmlDecode($this->subseccion->AdvancedSearch->SearchValue);
            }
            $this->subseccion->EditValue = HtmlEncode($this->subseccion->AdvancedSearch->SearchValue);
            $this->subseccion->PlaceHolder = RemoveHtml($this->subseccion->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->AdvancedSearch->SearchValue = HtmlDecode($this->parcela->AdvancedSearch->SearchValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->AdvancedSearch->SearchValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

            // vendedor
            $this->vendedor->setupEditAttributes();
            if (!$this->vendedor->Raw) {
                $this->vendedor->AdvancedSearch->SearchValue = HtmlDecode($this->vendedor->AdvancedSearch->SearchValue);
            }
            $this->vendedor->EditValue = HtmlEncode($this->vendedor->AdvancedSearch->SearchValue);
            $this->vendedor->PlaceHolder = RemoveHtml($this->vendedor->caption());

            // estatus
            $this->estatus->setupEditAttributes();
            $this->estatus->EditValue = $this->estatus->options(true);
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_registro->AdvancedSearch->SearchValue, $this->fecha_registro->formatPattern()), $this->fecha_registro->formatPattern()));
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
        if (!CheckInteger($this->Nparcela_ventas->AdvancedSearch->SearchValue)) {
            $this->Nparcela_ventas->addErrorMessage($this->Nparcela_ventas->getErrorMessage(false));
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
        $this->Nparcela_ventas->AdvancedSearch->load();
        $this->fecha_compra->AdvancedSearch->load();
        $this->usuario_compra->AdvancedSearch->load();
        $this->terraza->AdvancedSearch->load();
        $this->seccion->AdvancedSearch->load();
        $this->modulo->AdvancedSearch->load();
        $this->subseccion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->ci_vendedor->AdvancedSearch->load();
        $this->vendedor->AdvancedSearch->load();
        $this->valor_compra->AdvancedSearch->load();
        $this->moneda_compra->AdvancedSearch->load();
        $this->tasa_compra->AdvancedSearch->load();
        $this->fecha_venta->AdvancedSearch->load();
        $this->usuario_vende->AdvancedSearch->load();
        $this->ci_comprador->AdvancedSearch->load();
        $this->comprador->AdvancedSearch->load();
        $this->valor_venta->AdvancedSearch->load();
        $this->moneda_venta->AdvancedSearch->load();
        $this->tasa_venta->AdvancedSearch->load();
        $this->id_parcela->AdvancedSearch->load();
        $this->nota->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->numero_factura->AdvancedSearch->load();
        $this->orden_pago->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_parcela_ventassrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_usuario_compra":
                    break;
                case "x_moneda_compra":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_usuario_vende":
                    break;
                case "x_moneda_venta":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
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
        $html = '<div class="container-fluid mb-4 px-0">';

        // --- FILA DE ACCIONES Y LEYENDA ---
        $html .= '
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
            <div class="btn-group shadow-sm">
                <a href="dashboard/ListadoMaster?id=parcelas" class="btn btn-white btn-sm border" style="font-weight: 600; background: #fff;">
                    <i class="fas fa-file-excel text-success mr-1"></i> Exportar a Excel
                </a>
                <a href="dashboard/mapa_parcelas.php" target="_blank" class="btn btn-white btn-sm border" style="font-weight: 600; background: #fff;">
                    <i class="fas fa-map-marked-alt text-primary mr-1"></i> Ver Mapa de Parcelas
                </a>
            </div>
            <div class="d-flex align-items-center bg-white p-2 rounded shadow-sm border" style="gap: 15px; border-radius: 8px !important;">
                <small class="font-weight-bold text-muted mr-2" style="letter-spacing: 0.5px;">LEYENDA:</small>
                <div class="d-flex align-items-center">
                    <span style="width: 10px; height: 10px; background: #28a745; border-radius: 50%; display: inline-block; margin-right: 6px; box-shadow: 0 0 4px rgba(40,167,69,0.5);"></span>
                    <small class="font-weight-bold" style="color: #444;">COMPRA</small>
                </div>
                <div class="d-flex align-items-center">
                    <span style="width: 10px; height: 10px; background: #dc3545; border-radius: 50%; display: inline-block; margin-right: 6px; box-shadow: 0 0 4px rgba(220,53,69,0.5);"></span>
                    <small class="font-weight-bold" style="color: #444;">VENDIDA</small>
                </div>
                <div class="d-flex align-items-center">
                    <span style="width: 10px; height: 10px; background: #6c757d; border-radius: 50%; display: inline-block; margin-right: 6px; box-shadow: 0 0 4px rgba(108,117,125,0.5);"></span>
                    <small class="font-weight-bold" style="color: #444;">ANULADO</small>
                </div>
            </div>
        </div>';
        $html .= '</div>';
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
    	$opt = &$this->ListOptions->Add("new");
    	$opt->Header = "Tiempo";
    	$opt->OnLeft = FALSE; // Link on left
    	$opt->MoveTo(0); // Move to last column
    	$opt = &$this->ListOptions->Add("vender");
    	$opt->Header = "";
    	$opt->OnLeft = TRUE; // Link on left
    	$opt->MoveTo(7); // Move to last column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    public function listOptionsRendered() {
        // 1. Preparación de datos (Limpieza y valores por defecto)
        $estatus = trim($this->estatus->CurrentValue ?? "");
        $fecha_compra = $this->fecha_compra->CurrentValue;
        $fecha_venta = $this->fecha_venta->CurrentValue;

        // Determinamos la fecha 'Hasta': Hoy si es COMPRA, sino la fecha de venta
        $fh = ($estatus == "COMPRA") ? date("Y-m-d") : ($fecha_venta ?? date("Y-m-d"));

        // 2. Cálculo de tiempo transcurrido
        if (!empty($fecha_compra)) {
            // Pasamos strings limpios a la función
            $this->ListOptions->Items["new"]->Body = tiempoTranscurridoFechas($fecha_compra, $fh);
        } else {
            $this->ListOptions->Items["new"]->Body = '<span class="text-muted small">N/A</span>';
        }

        // 3. Control de botones (EDITAR y VENDER)
        if ($estatus == "COMPRA") {
            // Botón VENDER: Visible
            $idVenta = $this->Nparcela_ventas->CurrentValue;
            $this->ListOptions->Items["vender"]->Body = '<a class="btn btn-sm btn-outline-success border-0" 
                title="Vender Parcela" 
                href="ViewParcelaVentasEdit?Nparcela_ventas=' . $idVenta . '">
                <i class="fas fa-dollar-sign"></i>
            </a>';
        } else {
            // Si NO es COMPRA: Ocultar EDITAR y VENDER
            if (isset($this->ListOptions->Items["edit"])) {
                $this->ListOptions->Items["edit"]->Body = "";
            }
            if (isset($this->ListOptions->Items["vender"])) {
                $this->ListOptions->Items["vender"]->Body = "";
            }
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
