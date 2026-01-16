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
class ScoCostosTarifaDetalleGrid extends ScoCostosTarifaDetalle
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoCostosTarifaDetalleGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_costos_tarifa_detallegrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoCostosTarifaDetalleGrid";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

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
        $this->Ncostos_tarifa_detalle->Visible = false;
        $this->costos_tarifa->Visible = false;
        $this->cap->setVisibility();
        $this->ata->setVisibility();
        $this->obi->setVisibility();
        $this->fot->setVisibility();
        $this->man->setVisibility();
        $this->gas->setVisibility();
        $this->com->setVisibility();
        $this->base->setVisibility();
        $this->base_anterior->setVisibility();
        $this->variacion->setVisibility();
        $this->porcentaje->setVisibility();
        $this->fecha->setVisibility();
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
        $this->TableVar = 'sco_costos_tarifa_detalle';
        $this->TableName = 'sco_costos_tarifa_detalle';

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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_costos_tarifa_detalle)
        if (!isset($GLOBALS["sco_costos_tarifa_detalle"]) || $GLOBALS["sco_costos_tarifa_detalle"]::class == PROJECT_NAMESPACE . "sco_costos_tarifa_detalle") {
            $GLOBALS["sco_costos_tarifa_detalle"] = &$this;
        }
        $this->AddUrl = "ScoCostosTarifaDetalleAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_costos_tarifa_detalle');
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

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions(
            TagClassName: "ew-add-edit-option",
            UseDropDownButton: false,
            DropDownButtonPhrase: $Language->phrase("ButtonAddEdit"),
            UseButtonGroup: true
        );
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
            $key .= @$ar['Ncostos_tarifa_detalle'];
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
            $this->Ncostos_tarifa_detalle->Visible = false;
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
    public $ShowOtherOptions = false;
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

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        if (Param("export") !== null) {
            $this->Export = Param("export");
        }

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
        $this->setupLookupOptions($this->costos_tarifa);
        $this->setupLookupOptions($this->cap);
        $this->setupLookupOptions($this->ata);
        $this->setupLookupOptions($this->obi);
        $this->setupLookupOptions($this->fot);
        $this->setupLookupOptions($this->man);
        $this->setupLookupOptions($this->gas);
        $this->setupLookupOptions($this->com);
        $this->setupLookupOptions($this->cerrado);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_costos_tarifa_detallegrid";
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

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

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

        // Set up sorting order
        $this->setupSortOrder();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 50; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
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
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "sco_costos_tarifa") {
            $masterTbl = Container("sco_costos_tarifa");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("ScoCostosTarifaList"); // Return to master page
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
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
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
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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
        $this->base->FormValue = ""; // Clear form value
        $this->base_anterior->FormValue = ""; // Clear form value
        $this->variacion->FormValue = ""; // Clear form value
        $this->porcentaje->FormValue = ""; // Clear form value
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
        $this->loadDefaultValues();
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
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateSuccess")); // Batch update success
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
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
        $this->loadDefaultValues();

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
                    $key .= $this->Ncostos_tarifa_detalle->CurrentValue;

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
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
            $this->clearInlineMode(); // Clear grid add mode
        } else {
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
            $CurrentForm->hasValue("x_cap") &&
            $CurrentForm->hasValue("o_cap") &&
            $this->cap->CurrentValue != $this->cap->DefaultValue &&
            !($this->cap->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cap->CurrentValue == $this->cap->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_ata") &&
            $CurrentForm->hasValue("o_ata") &&
            $this->ata->CurrentValue != $this->ata->DefaultValue &&
            !($this->ata->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->ata->CurrentValue == $this->ata->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_obi") &&
            $CurrentForm->hasValue("o_obi") &&
            $this->obi->CurrentValue != $this->obi->DefaultValue &&
            !($this->obi->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->obi->CurrentValue == $this->obi->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_fot") &&
            $CurrentForm->hasValue("o_fot") &&
            $this->fot->CurrentValue != $this->fot->DefaultValue &&
            !($this->fot->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->fot->CurrentValue == $this->fot->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_man") &&
            $CurrentForm->hasValue("o_man") &&
            $this->man->CurrentValue != $this->man->DefaultValue &&
            !($this->man->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->man->CurrentValue == $this->man->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_gas") &&
            $CurrentForm->hasValue("o_gas") &&
            $this->gas->CurrentValue != $this->gas->DefaultValue &&
            !($this->gas->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->gas->CurrentValue == $this->gas->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_com") &&
            $CurrentForm->hasValue("o_com") &&
            $this->com->CurrentValue != $this->com->DefaultValue &&
            !($this->com->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->com->CurrentValue == $this->com->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_base") &&
            $CurrentForm->hasValue("o_base") &&
            $this->base->CurrentValue != $this->base->DefaultValue &&
            !($this->base->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->base->CurrentValue == $this->base->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_base_anterior") &&
            $CurrentForm->hasValue("o_base_anterior") &&
            $this->base_anterior->CurrentValue != $this->base_anterior->DefaultValue &&
            !($this->base_anterior->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->base_anterior->CurrentValue == $this->base_anterior->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_variacion") &&
            $CurrentForm->hasValue("o_variacion") &&
            $this->variacion->CurrentValue != $this->variacion->DefaultValue &&
            !($this->variacion->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->variacion->CurrentValue == $this->variacion->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_porcentaje") &&
            $CurrentForm->hasValue("o_porcentaje") &&
            $this->porcentaje->CurrentValue != $this->porcentaje->DefaultValue &&
            !($this->porcentaje->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->porcentaje->CurrentValue == $this->porcentaje->getSessionValue())
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

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->Ncostos_tarifa_detalle->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
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
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->costos_tarifa->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
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
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_costos_tarifa_detalle\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_costos_tarifa_detalle\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            if ($this->ModalAdd && !IsMobile()) {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_costos_tarifa_detalle\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
            } else {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            }
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
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
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item?->Visible ?? false;
            }
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        $this->StartRecord = 1;
        $this->StopRecord = $this->TotalRecords; // Show all records

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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_costos_tarifa_detalle", "data-rowtype" => RowType::ADD]);
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
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->loadRowValues($this->CurrentRow); // Load row values
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
            } else {
                $this->loadRowValues(); // Load default values
                $this->OldKey = "";
            }
        } else {
            $this->loadRowValues($this->CurrentRow); // Load row values
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
        }
        $this->setKey($this->OldKey);
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
        if ($this->isConfirm()) { // Confirm row
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
            "id" => "r" . $this->RowCount . "_sco_costos_tarifa_detalle",
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->cerrado->DefaultValue = $this->cerrado->getDefault(); // PHP
        $this->cerrado->OldValue = $this->cerrado->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'cap' first before field var 'x_cap'
        $val = $CurrentForm->hasValue("cap") ? $CurrentForm->getValue("cap") : $CurrentForm->getValue("x_cap");
        if (!$this->cap->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cap->Visible = false; // Disable update for API request
            } else {
                $this->cap->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_cap")) {
            $this->cap->setOldValue($CurrentForm->getValue("o_cap"));
        }

        // Check field name 'ata' first before field var 'x_ata'
        $val = $CurrentForm->hasValue("ata") ? $CurrentForm->getValue("ata") : $CurrentForm->getValue("x_ata");
        if (!$this->ata->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ata->Visible = false; // Disable update for API request
            } else {
                $this->ata->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_ata")) {
            $this->ata->setOldValue($CurrentForm->getValue("o_ata"));
        }

        // Check field name 'obi' first before field var 'x_obi'
        $val = $CurrentForm->hasValue("obi") ? $CurrentForm->getValue("obi") : $CurrentForm->getValue("x_obi");
        if (!$this->obi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->obi->Visible = false; // Disable update for API request
            } else {
                $this->obi->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_obi")) {
            $this->obi->setOldValue($CurrentForm->getValue("o_obi"));
        }

        // Check field name 'fot' first before field var 'x_fot'
        $val = $CurrentForm->hasValue("fot") ? $CurrentForm->getValue("fot") : $CurrentForm->getValue("x_fot");
        if (!$this->fot->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fot->Visible = false; // Disable update for API request
            } else {
                $this->fot->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_fot")) {
            $this->fot->setOldValue($CurrentForm->getValue("o_fot"));
        }

        // Check field name 'man' first before field var 'x_man'
        $val = $CurrentForm->hasValue("man") ? $CurrentForm->getValue("man") : $CurrentForm->getValue("x_man");
        if (!$this->man->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->man->Visible = false; // Disable update for API request
            } else {
                $this->man->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_man")) {
            $this->man->setOldValue($CurrentForm->getValue("o_man"));
        }

        // Check field name 'gas' first before field var 'x_gas'
        $val = $CurrentForm->hasValue("gas") ? $CurrentForm->getValue("gas") : $CurrentForm->getValue("x_gas");
        if (!$this->gas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gas->Visible = false; // Disable update for API request
            } else {
                $this->gas->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_gas")) {
            $this->gas->setOldValue($CurrentForm->getValue("o_gas"));
        }

        // Check field name 'com' first before field var 'x_com'
        $val = $CurrentForm->hasValue("com") ? $CurrentForm->getValue("com") : $CurrentForm->getValue("x_com");
        if (!$this->com->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->com->Visible = false; // Disable update for API request
            } else {
                $this->com->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_com")) {
            $this->com->setOldValue($CurrentForm->getValue("o_com"));
        }

        // Check field name 'base' first before field var 'x_base'
        $val = $CurrentForm->hasValue("base") ? $CurrentForm->getValue("base") : $CurrentForm->getValue("x_base");
        if (!$this->base->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->base->Visible = false; // Disable update for API request
            } else {
                $this->base->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_base")) {
            $this->base->setOldValue($CurrentForm->getValue("o_base"));
        }

        // Check field name 'base_anterior' first before field var 'x_base_anterior'
        $val = $CurrentForm->hasValue("base_anterior") ? $CurrentForm->getValue("base_anterior") : $CurrentForm->getValue("x_base_anterior");
        if (!$this->base_anterior->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->base_anterior->Visible = false; // Disable update for API request
            } else {
                $this->base_anterior->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_base_anterior")) {
            $this->base_anterior->setOldValue($CurrentForm->getValue("o_base_anterior"));
        }

        // Check field name 'variacion' first before field var 'x_variacion'
        $val = $CurrentForm->hasValue("variacion") ? $CurrentForm->getValue("variacion") : $CurrentForm->getValue("x_variacion");
        if (!$this->variacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->variacion->Visible = false; // Disable update for API request
            } else {
                $this->variacion->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_variacion")) {
            $this->variacion->setOldValue($CurrentForm->getValue("o_variacion"));
        }

        // Check field name 'porcentaje' first before field var 'x_porcentaje'
        $val = $CurrentForm->hasValue("porcentaje") ? $CurrentForm->getValue("porcentaje") : $CurrentForm->getValue("x_porcentaje");
        if (!$this->porcentaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentaje->Visible = false; // Disable update for API request
            } else {
                $this->porcentaje->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_porcentaje")) {
            $this->porcentaje->setOldValue($CurrentForm->getValue("o_porcentaje"));
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
        if ($CurrentForm->hasValue("o_fecha")) {
            $this->fecha->setOldValue($CurrentForm->getValue("o_fecha"));
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
        if ($CurrentForm->hasValue("o_cerrado")) {
            $this->cerrado->setOldValue($CurrentForm->getValue("o_cerrado"));
        }

        // Check field name 'Ncostos_tarifa_detalle' first before field var 'x_Ncostos_tarifa_detalle'
        $val = $CurrentForm->hasValue("Ncostos_tarifa_detalle") ? $CurrentForm->getValue("Ncostos_tarifa_detalle") : $CurrentForm->getValue("x_Ncostos_tarifa_detalle");
        if (!$this->Ncostos_tarifa_detalle->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->Ncostos_tarifa_detalle->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->Ncostos_tarifa_detalle->CurrentValue = $this->Ncostos_tarifa_detalle->FormValue;
        }
        $this->cap->CurrentValue = $this->cap->FormValue;
        $this->ata->CurrentValue = $this->ata->FormValue;
        $this->obi->CurrentValue = $this->obi->FormValue;
        $this->fot->CurrentValue = $this->fot->FormValue;
        $this->man->CurrentValue = $this->man->FormValue;
        $this->gas->CurrentValue = $this->gas->FormValue;
        $this->com->CurrentValue = $this->com->FormValue;
        $this->base->CurrentValue = $this->base->FormValue;
        $this->base_anterior->CurrentValue = $this->base_anterior->FormValue;
        $this->variacion->CurrentValue = $this->variacion->FormValue;
        $this->porcentaje->CurrentValue = $this->porcentaje->FormValue;
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
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
        $this->Ncostos_tarifa_detalle->setDbValue($row['Ncostos_tarifa_detalle']);
        $this->costos_tarifa->setDbValue($row['costos_tarifa']);
        $this->cap->setDbValue($row['cap']);
        $this->ata->setDbValue($row['ata']);
        $this->obi->setDbValue($row['obi']);
        $this->fot->setDbValue($row['fot']);
        $this->man->setDbValue($row['man']);
        $this->gas->setDbValue($row['gas']);
        $this->com->setDbValue($row['com']);
        $this->base->setDbValue($row['base']);
        $this->base_anterior->setDbValue($row['base_anterior']);
        $this->variacion->setDbValue($row['variacion']);
        $this->porcentaje->setDbValue($row['porcentaje']);
        $this->fecha->setDbValue($row['fecha']);
        $this->cerrado->setDbValue($row['cerrado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ncostos_tarifa_detalle'] = $this->Ncostos_tarifa_detalle->DefaultValue;
        $row['costos_tarifa'] = $this->costos_tarifa->DefaultValue;
        $row['cap'] = $this->cap->DefaultValue;
        $row['ata'] = $this->ata->DefaultValue;
        $row['obi'] = $this->obi->DefaultValue;
        $row['fot'] = $this->fot->DefaultValue;
        $row['man'] = $this->man->DefaultValue;
        $row['gas'] = $this->gas->DefaultValue;
        $row['com'] = $this->com->DefaultValue;
        $row['base'] = $this->base->DefaultValue;
        $row['base_anterior'] = $this->base_anterior->DefaultValue;
        $row['variacion'] = $this->variacion->DefaultValue;
        $row['porcentaje'] = $this->porcentaje->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
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
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Ncostos_tarifa_detalle

        // costos_tarifa

        // cap

        // ata

        // obi

        // fot

        // man

        // gas

        // com

        // base

        // base_anterior

        // variacion

        // porcentaje

        // fecha

        // cerrado

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ncostos_tarifa_detalle
            $this->Ncostos_tarifa_detalle->ViewValue = $this->Ncostos_tarifa_detalle->CurrentValue;

            // costos_tarifa
            $curVal = strval($this->costos_tarifa->CurrentValue);
            if ($curVal != "") {
                $this->costos_tarifa->ViewValue = $this->costos_tarifa->lookupCacheOption($curVal);
                if ($this->costos_tarifa->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchExpression(), "=", $curVal, $this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchDataType(), "");
                    $sqlWrk = $this->costos_tarifa->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_tarifa->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_tarifa->ViewValue = $this->costos_tarifa->displayValue($arwrk);
                    } else {
                        $this->costos_tarifa->ViewValue = $this->costos_tarifa->CurrentValue;
                    }
                }
            } else {
                $this->costos_tarifa->ViewValue = null;
            }

            // cap
            $curVal = strval($this->cap->CurrentValue);
            if ($curVal != "") {
                $this->cap->ViewValue = $this->cap->lookupCacheOption($curVal);
                if ($this->cap->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->cap->getSelectFilter($this); // PHP
                    $sqlWrk = $this->cap->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cap->Lookup->renderViewRow($rswrk[0]);
                        $this->cap->ViewValue = $this->cap->displayValue($arwrk);
                    } else {
                        $this->cap->ViewValue = $this->cap->CurrentValue;
                    }
                }
            } else {
                $this->cap->ViewValue = null;
            }
            $this->cap->CellCssStyle .= "text-align: left;";

            // ata
            $curVal = strval($this->ata->CurrentValue);
            if ($curVal != "") {
                $this->ata->ViewValue = $this->ata->lookupCacheOption($curVal);
                if ($this->ata->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->ata->getSelectFilter($this); // PHP
                    $sqlWrk = $this->ata->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ata->Lookup->renderViewRow($rswrk[0]);
                        $this->ata->ViewValue = $this->ata->displayValue($arwrk);
                    } else {
                        $this->ata->ViewValue = $this->ata->CurrentValue;
                    }
                }
            } else {
                $this->ata->ViewValue = null;
            }
            $this->ata->CellCssStyle .= "text-align: left;";

            // obi
            $curVal = strval($this->obi->CurrentValue);
            if ($curVal != "") {
                $this->obi->ViewValue = $this->obi->lookupCacheOption($curVal);
                if ($this->obi->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->obi->getSelectFilter($this); // PHP
                    $sqlWrk = $this->obi->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->obi->Lookup->renderViewRow($rswrk[0]);
                        $this->obi->ViewValue = $this->obi->displayValue($arwrk);
                    } else {
                        $this->obi->ViewValue = $this->obi->CurrentValue;
                    }
                }
            } else {
                $this->obi->ViewValue = null;
            }
            $this->obi->CellCssStyle .= "text-align: left;";

            // fot
            $curVal = strval($this->fot->CurrentValue);
            if ($curVal != "") {
                $this->fot->ViewValue = $this->fot->lookupCacheOption($curVal);
                if ($this->fot->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->fot->getSelectFilter($this); // PHP
                    $sqlWrk = $this->fot->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->fot->Lookup->renderViewRow($rswrk[0]);
                        $this->fot->ViewValue = $this->fot->displayValue($arwrk);
                    } else {
                        $this->fot->ViewValue = $this->fot->CurrentValue;
                    }
                }
            } else {
                $this->fot->ViewValue = null;
            }
            $this->fot->CellCssStyle .= "text-align: left;";

            // man
            $curVal = strval($this->man->CurrentValue);
            if ($curVal != "") {
                $this->man->ViewValue = $this->man->lookupCacheOption($curVal);
                if ($this->man->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->man->getSelectFilter($this); // PHP
                    $sqlWrk = $this->man->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->man->Lookup->renderViewRow($rswrk[0]);
                        $this->man->ViewValue = $this->man->displayValue($arwrk);
                    } else {
                        $this->man->ViewValue = $this->man->CurrentValue;
                    }
                }
            } else {
                $this->man->ViewValue = null;
            }
            $this->man->CellCssStyle .= "text-align: left;";

            // gas
            $curVal = strval($this->gas->CurrentValue);
            if ($curVal != "") {
                $this->gas->ViewValue = $this->gas->lookupCacheOption($curVal);
                if ($this->gas->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->gas->getSelectFilter($this); // PHP
                    $sqlWrk = $this->gas->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->gas->Lookup->renderViewRow($rswrk[0]);
                        $this->gas->ViewValue = $this->gas->displayValue($arwrk);
                    } else {
                        $this->gas->ViewValue = $this->gas->CurrentValue;
                    }
                }
            } else {
                $this->gas->ViewValue = null;
            }
            $this->gas->CellCssStyle .= "text-align: left;";

            // com
            $curVal = strval($this->com->CurrentValue);
            if ($curVal != "") {
                $this->com->ViewValue = $this->com->lookupCacheOption($curVal);
                if ($this->com->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->com->getSelectFilter($this); // PHP
                    $sqlWrk = $this->com->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->com->Lookup->renderViewRow($rswrk[0]);
                        $this->com->ViewValue = $this->com->displayValue($arwrk);
                    } else {
                        $this->com->ViewValue = $this->com->CurrentValue;
                    }
                }
            } else {
                $this->com->ViewValue = null;
            }
            $this->com->CellCssStyle .= "text-align: left;";

            // base
            $this->base->ViewValue = $this->base->CurrentValue;
            $this->base->ViewValue = FormatNumber($this->base->ViewValue, $this->base->formatPattern());
            $this->base->CssClass = "fw-bold";
            $this->base->CellCssStyle .= "text-align: left;";

            // base_anterior
            $this->base_anterior->ViewValue = $this->base_anterior->CurrentValue;
            $this->base_anterior->ViewValue = FormatNumber($this->base_anterior->ViewValue, $this->base_anterior->formatPattern());
            $this->base_anterior->CellCssStyle .= "text-align: left;";

            // variacion
            $this->variacion->ViewValue = $this->variacion->CurrentValue;
            $this->variacion->ViewValue = FormatNumber($this->variacion->ViewValue, $this->variacion->formatPattern());
            $this->variacion->CellCssStyle .= "text-align: left;";

            // porcentaje
            $this->porcentaje->ViewValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->ViewValue = FormatNumber($this->porcentaje->ViewValue, $this->porcentaje->formatPattern());
            $this->porcentaje->CellCssStyle .= "text-align: left;";

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // cerrado
            if (strval($this->cerrado->CurrentValue) != "") {
                $this->cerrado->ViewValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
            } else {
                $this->cerrado->ViewValue = null;
            }

            // cap
            $this->cap->HrefValue = "";
            $this->cap->TooltipValue = "";

            // ata
            $this->ata->HrefValue = "";
            $this->ata->TooltipValue = "";

            // obi
            $this->obi->HrefValue = "";
            $this->obi->TooltipValue = "";

            // fot
            $this->fot->HrefValue = "";
            $this->fot->TooltipValue = "";

            // man
            $this->man->HrefValue = "";
            $this->man->TooltipValue = "";

            // gas
            $this->gas->HrefValue = "";
            $this->gas->TooltipValue = "";

            // com
            $this->com->HrefValue = "";
            $this->com->TooltipValue = "";

            // base
            $this->base->HrefValue = "";
            $this->base->TooltipValue = "";

            // base_anterior
            $this->base_anterior->HrefValue = "";
            $this->base_anterior->TooltipValue = "";

            // variacion
            $this->variacion->HrefValue = "";
            $this->variacion->TooltipValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";
            $this->porcentaje->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
            $this->cerrado->TooltipValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // cap
            $this->cap->setupEditAttributes();
            $curVal = trim(strval($this->cap->CurrentValue));
            if ($curVal != "") {
                $this->cap->ViewValue = $this->cap->lookupCacheOption($curVal);
            } else {
                $this->cap->ViewValue = $this->cap->Lookup !== null && is_array($this->cap->lookupOptions()) && count($this->cap->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cap->ViewValue !== null) { // Load from cache
                $this->cap->EditValue = array_values($this->cap->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->cap->CurrentValue, $this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->cap->getSelectFilter($this); // PHP
                $sqlWrk = $this->cap->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cap->Lookup->renderViewRow($row);
                }
                $this->cap->EditValue = $arwrk;
            }
            $this->cap->PlaceHolder = RemoveHtml($this->cap->caption());

            // ata
            $this->ata->setupEditAttributes();
            $curVal = trim(strval($this->ata->CurrentValue));
            if ($curVal != "") {
                $this->ata->ViewValue = $this->ata->lookupCacheOption($curVal);
            } else {
                $this->ata->ViewValue = $this->ata->Lookup !== null && is_array($this->ata->lookupOptions()) && count($this->ata->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->ata->ViewValue !== null) { // Load from cache
                $this->ata->EditValue = array_values($this->ata->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->ata->CurrentValue, $this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->ata->getSelectFilter($this); // PHP
                $sqlWrk = $this->ata->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->ata->Lookup->renderViewRow($row);
                }
                $this->ata->EditValue = $arwrk;
            }
            $this->ata->PlaceHolder = RemoveHtml($this->ata->caption());

            // obi
            $this->obi->setupEditAttributes();
            $curVal = trim(strval($this->obi->CurrentValue));
            if ($curVal != "") {
                $this->obi->ViewValue = $this->obi->lookupCacheOption($curVal);
            } else {
                $this->obi->ViewValue = $this->obi->Lookup !== null && is_array($this->obi->lookupOptions()) && count($this->obi->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->obi->ViewValue !== null) { // Load from cache
                $this->obi->EditValue = array_values($this->obi->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->obi->CurrentValue, $this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->obi->getSelectFilter($this); // PHP
                $sqlWrk = $this->obi->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->obi->Lookup->renderViewRow($row);
                }
                $this->obi->EditValue = $arwrk;
            }
            $this->obi->PlaceHolder = RemoveHtml($this->obi->caption());

            // fot
            $this->fot->setupEditAttributes();
            $curVal = trim(strval($this->fot->CurrentValue));
            if ($curVal != "") {
                $this->fot->ViewValue = $this->fot->lookupCacheOption($curVal);
            } else {
                $this->fot->ViewValue = $this->fot->Lookup !== null && is_array($this->fot->lookupOptions()) && count($this->fot->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->fot->ViewValue !== null) { // Load from cache
                $this->fot->EditValue = array_values($this->fot->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->fot->CurrentValue, $this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->fot->getSelectFilter($this); // PHP
                $sqlWrk = $this->fot->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->fot->Lookup->renderViewRow($row);
                }
                $this->fot->EditValue = $arwrk;
            }
            $this->fot->PlaceHolder = RemoveHtml($this->fot->caption());

            // man
            $this->man->setupEditAttributes();
            $curVal = trim(strval($this->man->CurrentValue));
            if ($curVal != "") {
                $this->man->ViewValue = $this->man->lookupCacheOption($curVal);
            } else {
                $this->man->ViewValue = $this->man->Lookup !== null && is_array($this->man->lookupOptions()) && count($this->man->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->man->ViewValue !== null) { // Load from cache
                $this->man->EditValue = array_values($this->man->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->man->CurrentValue, $this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->man->getSelectFilter($this); // PHP
                $sqlWrk = $this->man->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->man->Lookup->renderViewRow($row);
                }
                $this->man->EditValue = $arwrk;
            }
            $this->man->PlaceHolder = RemoveHtml($this->man->caption());

            // gas
            $this->gas->setupEditAttributes();
            $curVal = trim(strval($this->gas->CurrentValue));
            if ($curVal != "") {
                $this->gas->ViewValue = $this->gas->lookupCacheOption($curVal);
            } else {
                $this->gas->ViewValue = $this->gas->Lookup !== null && is_array($this->gas->lookupOptions()) && count($this->gas->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->gas->ViewValue !== null) { // Load from cache
                $this->gas->EditValue = array_values($this->gas->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->gas->CurrentValue, $this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->gas->getSelectFilter($this); // PHP
                $sqlWrk = $this->gas->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->gas->Lookup->renderViewRow($row);
                }
                $this->gas->EditValue = $arwrk;
            }
            $this->gas->PlaceHolder = RemoveHtml($this->gas->caption());

            // com
            $this->com->setupEditAttributes();
            $curVal = trim(strval($this->com->CurrentValue));
            if ($curVal != "") {
                $this->com->ViewValue = $this->com->lookupCacheOption($curVal);
            } else {
                $this->com->ViewValue = $this->com->Lookup !== null && is_array($this->com->lookupOptions()) && count($this->com->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->com->ViewValue !== null) { // Load from cache
                $this->com->EditValue = array_values($this->com->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->com->CurrentValue, $this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->com->getSelectFilter($this); // PHP
                $sqlWrk = $this->com->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->com->Lookup->renderViewRow($row);
                }
                $this->com->EditValue = $arwrk;
            }
            $this->com->PlaceHolder = RemoveHtml($this->com->caption());

            // base
            $this->base->setupEditAttributes();
            $this->base->EditValue = $this->base->CurrentValue;
            $this->base->PlaceHolder = RemoveHtml($this->base->caption());
            if (strval($this->base->EditValue) != "" && is_numeric($this->base->EditValue)) {
                $this->base->EditValue = FormatNumber($this->base->EditValue, null);
            }

            // base_anterior
            $this->base_anterior->setupEditAttributes();
            $this->base_anterior->EditValue = $this->base_anterior->CurrentValue;
            $this->base_anterior->PlaceHolder = RemoveHtml($this->base_anterior->caption());
            if (strval($this->base_anterior->EditValue) != "" && is_numeric($this->base_anterior->EditValue)) {
                $this->base_anterior->EditValue = FormatNumber($this->base_anterior->EditValue, null);
            }

            // variacion
            $this->variacion->setupEditAttributes();
            $this->variacion->EditValue = $this->variacion->CurrentValue;
            $this->variacion->PlaceHolder = RemoveHtml($this->variacion->caption());
            if (strval($this->variacion->EditValue) != "" && is_numeric($this->variacion->EditValue)) {
                $this->variacion->EditValue = FormatNumber($this->variacion->EditValue, null);
            }

            // porcentaje
            $this->porcentaje->setupEditAttributes();
            $this->porcentaje->EditValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->PlaceHolder = RemoveHtml($this->porcentaje->caption());
            if (strval($this->porcentaje->EditValue) != "" && is_numeric($this->porcentaje->EditValue)) {
                $this->porcentaje->EditValue = FormatNumber($this->porcentaje->EditValue, null);
            }

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = HtmlEncode(FormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern()));
            $this->fecha->PlaceHolder = RemoveHtml($this->fecha->caption());

            // cerrado
            $this->cerrado->setupEditAttributes();
            $this->cerrado->EditValue = $this->cerrado->options(true);
            $this->cerrado->PlaceHolder = RemoveHtml($this->cerrado->caption());

            // Add refer script

            // cap
            $this->cap->HrefValue = "";

            // ata
            $this->ata->HrefValue = "";

            // obi
            $this->obi->HrefValue = "";

            // fot
            $this->fot->HrefValue = "";

            // man
            $this->man->HrefValue = "";

            // gas
            $this->gas->HrefValue = "";

            // com
            $this->com->HrefValue = "";

            // base
            $this->base->HrefValue = "";

            // base_anterior
            $this->base_anterior->HrefValue = "";

            // variacion
            $this->variacion->HrefValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";

            // fecha
            $this->fecha->HrefValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // cap
            $this->cap->setupEditAttributes();
            $curVal = trim(strval($this->cap->CurrentValue));
            if ($curVal != "") {
                $this->cap->ViewValue = $this->cap->lookupCacheOption($curVal);
            } else {
                $this->cap->ViewValue = $this->cap->Lookup !== null && is_array($this->cap->lookupOptions()) && count($this->cap->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cap->ViewValue !== null) { // Load from cache
                $this->cap->EditValue = array_values($this->cap->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->cap->CurrentValue, $this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->cap->getSelectFilter($this); // PHP
                $sqlWrk = $this->cap->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cap->Lookup->renderViewRow($row);
                }
                $this->cap->EditValue = $arwrk;
            }
            $this->cap->PlaceHolder = RemoveHtml($this->cap->caption());

            // ata
            $this->ata->setupEditAttributes();
            $curVal = trim(strval($this->ata->CurrentValue));
            if ($curVal != "") {
                $this->ata->ViewValue = $this->ata->lookupCacheOption($curVal);
            } else {
                $this->ata->ViewValue = $this->ata->Lookup !== null && is_array($this->ata->lookupOptions()) && count($this->ata->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->ata->ViewValue !== null) { // Load from cache
                $this->ata->EditValue = array_values($this->ata->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->ata->CurrentValue, $this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->ata->getSelectFilter($this); // PHP
                $sqlWrk = $this->ata->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->ata->Lookup->renderViewRow($row);
                }
                $this->ata->EditValue = $arwrk;
            }
            $this->ata->PlaceHolder = RemoveHtml($this->ata->caption());

            // obi
            $this->obi->setupEditAttributes();
            $curVal = trim(strval($this->obi->CurrentValue));
            if ($curVal != "") {
                $this->obi->ViewValue = $this->obi->lookupCacheOption($curVal);
            } else {
                $this->obi->ViewValue = $this->obi->Lookup !== null && is_array($this->obi->lookupOptions()) && count($this->obi->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->obi->ViewValue !== null) { // Load from cache
                $this->obi->EditValue = array_values($this->obi->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->obi->CurrentValue, $this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->obi->getSelectFilter($this); // PHP
                $sqlWrk = $this->obi->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->obi->Lookup->renderViewRow($row);
                }
                $this->obi->EditValue = $arwrk;
            }
            $this->obi->PlaceHolder = RemoveHtml($this->obi->caption());

            // fot
            $this->fot->setupEditAttributes();
            $curVal = trim(strval($this->fot->CurrentValue));
            if ($curVal != "") {
                $this->fot->ViewValue = $this->fot->lookupCacheOption($curVal);
            } else {
                $this->fot->ViewValue = $this->fot->Lookup !== null && is_array($this->fot->lookupOptions()) && count($this->fot->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->fot->ViewValue !== null) { // Load from cache
                $this->fot->EditValue = array_values($this->fot->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->fot->CurrentValue, $this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->fot->getSelectFilter($this); // PHP
                $sqlWrk = $this->fot->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->fot->Lookup->renderViewRow($row);
                }
                $this->fot->EditValue = $arwrk;
            }
            $this->fot->PlaceHolder = RemoveHtml($this->fot->caption());

            // man
            $this->man->setupEditAttributes();
            $curVal = trim(strval($this->man->CurrentValue));
            if ($curVal != "") {
                $this->man->ViewValue = $this->man->lookupCacheOption($curVal);
            } else {
                $this->man->ViewValue = $this->man->Lookup !== null && is_array($this->man->lookupOptions()) && count($this->man->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->man->ViewValue !== null) { // Load from cache
                $this->man->EditValue = array_values($this->man->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->man->CurrentValue, $this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->man->getSelectFilter($this); // PHP
                $sqlWrk = $this->man->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->man->Lookup->renderViewRow($row);
                }
                $this->man->EditValue = $arwrk;
            }
            $this->man->PlaceHolder = RemoveHtml($this->man->caption());

            // gas
            $this->gas->setupEditAttributes();
            $curVal = trim(strval($this->gas->CurrentValue));
            if ($curVal != "") {
                $this->gas->ViewValue = $this->gas->lookupCacheOption($curVal);
            } else {
                $this->gas->ViewValue = $this->gas->Lookup !== null && is_array($this->gas->lookupOptions()) && count($this->gas->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->gas->ViewValue !== null) { // Load from cache
                $this->gas->EditValue = array_values($this->gas->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->gas->CurrentValue, $this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->gas->getSelectFilter($this); // PHP
                $sqlWrk = $this->gas->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->gas->Lookup->renderViewRow($row);
                }
                $this->gas->EditValue = $arwrk;
            }
            $this->gas->PlaceHolder = RemoveHtml($this->gas->caption());

            // com
            $this->com->setupEditAttributes();
            $curVal = trim(strval($this->com->CurrentValue));
            if ($curVal != "") {
                $this->com->ViewValue = $this->com->lookupCacheOption($curVal);
            } else {
                $this->com->ViewValue = $this->com->Lookup !== null && is_array($this->com->lookupOptions()) && count($this->com->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->com->ViewValue !== null) { // Load from cache
                $this->com->EditValue = array_values($this->com->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->com->CurrentValue, $this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->com->getSelectFilter($this); // PHP
                $sqlWrk = $this->com->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->com->Lookup->renderViewRow($row);
                }
                $this->com->EditValue = $arwrk;
            }
            $this->com->PlaceHolder = RemoveHtml($this->com->caption());

            // base
            $this->base->setupEditAttributes();
            $this->base->EditValue = $this->base->CurrentValue;
            $this->base->EditValue = FormatNumber($this->base->EditValue, $this->base->formatPattern());
            $this->base->CssClass = "fw-bold";
            $this->base->CellCssStyle .= "text-align: left;";

            // base_anterior
            $this->base_anterior->setupEditAttributes();
            $this->base_anterior->EditValue = $this->base_anterior->CurrentValue;
            $this->base_anterior->EditValue = FormatNumber($this->base_anterior->EditValue, $this->base_anterior->formatPattern());
            $this->base_anterior->CellCssStyle .= "text-align: left;";

            // variacion
            $this->variacion->setupEditAttributes();
            $this->variacion->EditValue = $this->variacion->CurrentValue;
            $this->variacion->EditValue = FormatNumber($this->variacion->EditValue, $this->variacion->formatPattern());
            $this->variacion->CellCssStyle .= "text-align: left;";

            // porcentaje
            $this->porcentaje->setupEditAttributes();
            $this->porcentaje->EditValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->EditValue = FormatNumber($this->porcentaje->EditValue, $this->porcentaje->formatPattern());
            $this->porcentaje->CellCssStyle .= "text-align: left;";

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = $this->fecha->CurrentValue;
            $this->fecha->EditValue = FormatDateTime($this->fecha->EditValue, $this->fecha->formatPattern());

            // cerrado
            $this->cerrado->setupEditAttributes();
            $this->cerrado->EditValue = $this->cerrado->options(true);
            $this->cerrado->PlaceHolder = RemoveHtml($this->cerrado->caption());

            // Edit refer script

            // cap
            $this->cap->HrefValue = "";

            // ata
            $this->ata->HrefValue = "";

            // obi
            $this->obi->HrefValue = "";

            // fot
            $this->fot->HrefValue = "";

            // man
            $this->man->HrefValue = "";

            // gas
            $this->gas->HrefValue = "";

            // com
            $this->com->HrefValue = "";

            // base
            $this->base->HrefValue = "";
            $this->base->TooltipValue = "";

            // base_anterior
            $this->base_anterior->HrefValue = "";
            $this->base_anterior->TooltipValue = "";

            // variacion
            $this->variacion->HrefValue = "";
            $this->variacion->TooltipValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";
            $this->porcentaje->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
        }
        if ($this->RowType == RowType::ADD || $this->RowType == RowType::EDIT || $this->RowType == RowType::SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
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
            if ($this->cap->Visible && $this->cap->Required) {
                if (!$this->cap->IsDetailKey && EmptyValue($this->cap->FormValue)) {
                    $this->cap->addErrorMessage(str_replace("%s", $this->cap->caption(), $this->cap->RequiredErrorMessage));
                }
            }
            if ($this->ata->Visible && $this->ata->Required) {
                if (!$this->ata->IsDetailKey && EmptyValue($this->ata->FormValue)) {
                    $this->ata->addErrorMessage(str_replace("%s", $this->ata->caption(), $this->ata->RequiredErrorMessage));
                }
            }
            if ($this->obi->Visible && $this->obi->Required) {
                if (!$this->obi->IsDetailKey && EmptyValue($this->obi->FormValue)) {
                    $this->obi->addErrorMessage(str_replace("%s", $this->obi->caption(), $this->obi->RequiredErrorMessage));
                }
            }
            if ($this->fot->Visible && $this->fot->Required) {
                if (!$this->fot->IsDetailKey && EmptyValue($this->fot->FormValue)) {
                    $this->fot->addErrorMessage(str_replace("%s", $this->fot->caption(), $this->fot->RequiredErrorMessage));
                }
            }
            if ($this->man->Visible && $this->man->Required) {
                if (!$this->man->IsDetailKey && EmptyValue($this->man->FormValue)) {
                    $this->man->addErrorMessage(str_replace("%s", $this->man->caption(), $this->man->RequiredErrorMessage));
                }
            }
            if ($this->gas->Visible && $this->gas->Required) {
                if (!$this->gas->IsDetailKey && EmptyValue($this->gas->FormValue)) {
                    $this->gas->addErrorMessage(str_replace("%s", $this->gas->caption(), $this->gas->RequiredErrorMessage));
                }
            }
            if ($this->com->Visible && $this->com->Required) {
                if (!$this->com->IsDetailKey && EmptyValue($this->com->FormValue)) {
                    $this->com->addErrorMessage(str_replace("%s", $this->com->caption(), $this->com->RequiredErrorMessage));
                }
            }
            if ($this->base->Visible && $this->base->Required) {
                if (!$this->base->IsDetailKey && EmptyValue($this->base->FormValue)) {
                    $this->base->addErrorMessage(str_replace("%s", $this->base->caption(), $this->base->RequiredErrorMessage));
                }
            }
            if ($this->base_anterior->Visible && $this->base_anterior->Required) {
                if (!$this->base_anterior->IsDetailKey && EmptyValue($this->base_anterior->FormValue)) {
                    $this->base_anterior->addErrorMessage(str_replace("%s", $this->base_anterior->caption(), $this->base_anterior->RequiredErrorMessage));
                }
            }
            if ($this->variacion->Visible && $this->variacion->Required) {
                if (!$this->variacion->IsDetailKey && EmptyValue($this->variacion->FormValue)) {
                    $this->variacion->addErrorMessage(str_replace("%s", $this->variacion->caption(), $this->variacion->RequiredErrorMessage));
                }
            }
            if ($this->porcentaje->Visible && $this->porcentaje->Required) {
                if (!$this->porcentaje->IsDetailKey && EmptyValue($this->porcentaje->FormValue)) {
                    $this->porcentaje->addErrorMessage(str_replace("%s", $this->porcentaje->caption(), $this->porcentaje->RequiredErrorMessage));
                }
            }
            if ($this->fecha->Visible && $this->fecha->Required) {
                if (!$this->fecha->IsDetailKey && EmptyValue($this->fecha->FormValue)) {
                    $this->fecha->addErrorMessage(str_replace("%s", $this->fecha->caption(), $this->fecha->RequiredErrorMessage));
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
            $thisKey .= $row['Ncostos_tarifa_detalle'];

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

        // Check referential integrity for master table 'sco_costos_tarifa'
        $detailKeys = [];
        $keyValue = $rsnew['costos_tarifa'] ?? $rsold['costos_tarifa'];
        $detailKeys['costos_tarifa'] = $keyValue;
        $masterTable = Container("sco_costos_tarifa");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "sco_costos_tarifa", $Language->phrase("RelatedRecordRequired"));
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

        // cap
        $this->cap->setDbValueDef($rsnew, $this->cap->CurrentValue, $this->cap->ReadOnly);

        // ata
        $this->ata->setDbValueDef($rsnew, $this->ata->CurrentValue, $this->ata->ReadOnly);

        // obi
        $this->obi->setDbValueDef($rsnew, $this->obi->CurrentValue, $this->obi->ReadOnly);

        // fot
        $this->fot->setDbValueDef($rsnew, $this->fot->CurrentValue, $this->fot->ReadOnly);

        // man
        $this->man->setDbValueDef($rsnew, $this->man->CurrentValue, $this->man->ReadOnly);

        // gas
        $this->gas->setDbValueDef($rsnew, $this->gas->CurrentValue, $this->gas->ReadOnly);

        // com
        $this->com->setDbValueDef($rsnew, $this->com->CurrentValue, $this->com->ReadOnly);

        // cerrado
        $this->cerrado->setDbValueDef($rsnew, $this->cerrado->CurrentValue, $this->cerrado->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['cap'])) { // cap
            $this->cap->CurrentValue = $row['cap'];
        }
        if (isset($row['ata'])) { // ata
            $this->ata->CurrentValue = $row['ata'];
        }
        if (isset($row['obi'])) { // obi
            $this->obi->CurrentValue = $row['obi'];
        }
        if (isset($row['fot'])) { // fot
            $this->fot->CurrentValue = $row['fot'];
        }
        if (isset($row['man'])) { // man
            $this->man->CurrentValue = $row['man'];
        }
        if (isset($row['gas'])) { // gas
            $this->gas->CurrentValue = $row['gas'];
        }
        if (isset($row['com'])) { // com
            $this->com->CurrentValue = $row['com'];
        }
        if (isset($row['cerrado'])) { // cerrado
            $this->cerrado->CurrentValue = $row['cerrado'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "sco_costos_tarifa") {
            $this->costos_tarifa->Visible = true; // Need to insert foreign key
            $this->costos_tarifa->CurrentValue = $this->costos_tarifa->getSessionValue();
        }

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'sco_costos_tarifa_detalle'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["costos_tarifa"] = $this->costos_tarifa->getSessionValue();
        $masterTable = Container("sco_costos_tarifa");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "sco_costos_tarifa", $Language->phrase("RelatedRecordRequired"));
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

        // cap
        $this->cap->setDbValueDef($rsnew, $this->cap->CurrentValue, false);

        // ata
        $this->ata->setDbValueDef($rsnew, $this->ata->CurrentValue, false);

        // obi
        $this->obi->setDbValueDef($rsnew, $this->obi->CurrentValue, false);

        // fot
        $this->fot->setDbValueDef($rsnew, $this->fot->CurrentValue, false);

        // man
        $this->man->setDbValueDef($rsnew, $this->man->CurrentValue, false);

        // gas
        $this->gas->setDbValueDef($rsnew, $this->gas->CurrentValue, false);

        // com
        $this->com->setDbValueDef($rsnew, $this->com->CurrentValue, false);

        // base
        $this->base->setDbValueDef($rsnew, $this->base->CurrentValue, false);

        // base_anterior
        $this->base_anterior->setDbValueDef($rsnew, $this->base_anterior->CurrentValue, false);

        // variacion
        $this->variacion->setDbValueDef($rsnew, $this->variacion->CurrentValue, false);

        // porcentaje
        $this->porcentaje->setDbValueDef($rsnew, $this->porcentaje->CurrentValue, false);

        // fecha
        $this->fecha->setDbValueDef($rsnew, UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern()), false);

        // cerrado
        $this->cerrado->setDbValueDef($rsnew, $this->cerrado->CurrentValue, strval($this->cerrado->CurrentValue) == "");

        // costos_tarifa
        if ($this->costos_tarifa->getSessionValue() != "") {
            $rsnew['costos_tarifa'] = $this->costos_tarifa->getSessionValue();
        }
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['cap'])) { // cap
            $this->cap->setFormValue($row['cap']);
        }
        if (isset($row['ata'])) { // ata
            $this->ata->setFormValue($row['ata']);
        }
        if (isset($row['obi'])) { // obi
            $this->obi->setFormValue($row['obi']);
        }
        if (isset($row['fot'])) { // fot
            $this->fot->setFormValue($row['fot']);
        }
        if (isset($row['man'])) { // man
            $this->man->setFormValue($row['man']);
        }
        if (isset($row['gas'])) { // gas
            $this->gas->setFormValue($row['gas']);
        }
        if (isset($row['com'])) { // com
            $this->com->setFormValue($row['com']);
        }
        if (isset($row['base'])) { // base
            $this->base->setFormValue($row['base']);
        }
        if (isset($row['base_anterior'])) { // base_anterior
            $this->base_anterior->setFormValue($row['base_anterior']);
        }
        if (isset($row['variacion'])) { // variacion
            $this->variacion->setFormValue($row['variacion']);
        }
        if (isset($row['porcentaje'])) { // porcentaje
            $this->porcentaje->setFormValue($row['porcentaje']);
        }
        if (isset($row['fecha'])) { // fecha
            $this->fecha->setFormValue($row['fecha']);
        }
        if (isset($row['cerrado'])) { // cerrado
            $this->cerrado->setFormValue($row['cerrado']);
        }
        if (isset($row['costos_tarifa'])) { // costos_tarifa
            $this->costos_tarifa->setFormValue($row['costos_tarifa']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "sco_costos_tarifa") {
            $masterTbl = Container("sco_costos_tarifa");
            $this->costos_tarifa->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
                case "x_costos_tarifa":
                    break;
                case "x_cap":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_ata":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_obi":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_fot":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_man":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_gas":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_com":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
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
}
