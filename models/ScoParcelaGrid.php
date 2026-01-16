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
class ScoParcelaGrid extends ScoParcela
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoParcelaGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_parcelagrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoParcelaGrid";

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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_parcela)
        if (!isset($GLOBALS["sco_parcela"]) || $GLOBALS["sco_parcela"]::class == PROJECT_NAMESPACE . "sco_parcela") {
            $GLOBALS["sco_parcela"] = &$this;
        }
        $this->AddUrl = "ScoParcelaAdd";

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

        // Load default values for add
        $this->loadDefaultValues();

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
                    $key .= $this->Nparcela->CurrentValue;

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
            $CurrentForm->hasValue("x_Nparcela") &&
            $CurrentForm->hasValue("o_Nparcela") &&
            $this->Nparcela->CurrentValue != $this->Nparcela->DefaultValue &&
            !($this->Nparcela->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->Nparcela->CurrentValue == $this->Nparcela->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_nacionalidad") &&
            $CurrentForm->hasValue("o_nacionalidad") &&
            $this->nacionalidad->CurrentValue != $this->nacionalidad->DefaultValue &&
            !($this->nacionalidad->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->nacionalidad->CurrentValue == $this->nacionalidad->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_cedula") &&
            $CurrentForm->hasValue("o_cedula") &&
            $this->cedula->CurrentValue != $this->cedula->DefaultValue &&
            !($this->cedula->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->cedula->CurrentValue == $this->cedula->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_titular") &&
            $CurrentForm->hasValue("o_titular") &&
            $this->titular->CurrentValue != $this->titular->DefaultValue &&
            !($this->titular->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->titular->CurrentValue == $this->titular->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_contrato") &&
            $CurrentForm->hasValue("o_contrato") &&
            $this->contrato->CurrentValue != $this->contrato->DefaultValue &&
            !($this->contrato->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->contrato->CurrentValue == $this->contrato->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_seccion") &&
            $CurrentForm->hasValue("o_seccion") &&
            $this->seccion->CurrentValue != $this->seccion->DefaultValue &&
            !($this->seccion->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->seccion->CurrentValue == $this->seccion->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_modulo") &&
            $CurrentForm->hasValue("o_modulo") &&
            $this->modulo->CurrentValue != $this->modulo->DefaultValue &&
            !($this->modulo->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->modulo->CurrentValue == $this->modulo->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_sub_seccion") &&
            $CurrentForm->hasValue("o_sub_seccion") &&
            $this->sub_seccion->CurrentValue != $this->sub_seccion->DefaultValue &&
            !($this->sub_seccion->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->sub_seccion->CurrentValue == $this->sub_seccion->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_parcela") &&
            $CurrentForm->hasValue("o_parcela") &&
            $this->parcela->CurrentValue != $this->parcela->DefaultValue &&
            !($this->parcela->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->parcela->CurrentValue == $this->parcela->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_boveda") &&
            $CurrentForm->hasValue("o_boveda") &&
            $this->boveda->CurrentValue != $this->boveda->DefaultValue &&
            !($this->boveda->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->boveda->CurrentValue == $this->boveda->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_apellido1") &&
            $CurrentForm->hasValue("o_apellido1") &&
            $this->apellido1->CurrentValue != $this->apellido1->DefaultValue &&
            !($this->apellido1->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->apellido1->CurrentValue == $this->apellido1->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_apellido2") &&
            $CurrentForm->hasValue("o_apellido2") &&
            $this->apellido2->CurrentValue != $this->apellido2->DefaultValue &&
            !($this->apellido2->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->apellido2->CurrentValue == $this->apellido2->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_nombre1") &&
            $CurrentForm->hasValue("o_nombre1") &&
            $this->nombre1->CurrentValue != $this->nombre1->DefaultValue &&
            !($this->nombre1->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->nombre1->CurrentValue == $this->nombre1->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_nombre2") &&
            $CurrentForm->hasValue("o_nombre2") &&
            $this->nombre2->CurrentValue != $this->nombre2->DefaultValue &&
            !($this->nombre2->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->nombre2->CurrentValue == $this->nombre2->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_fecha_inhumacion") &&
            $CurrentForm->hasValue("o_fecha_inhumacion") &&
            $this->fecha_inhumacion->CurrentValue != $this->fecha_inhumacion->DefaultValue &&
            !($this->fecha_inhumacion->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->fecha_inhumacion->CurrentValue == $this->fecha_inhumacion->getSessionValue())
        ) {
            return false;
        }
        if (
            $CurrentForm->hasValue("x_funeraria") &&
            $CurrentForm->hasValue("o_funeraria") &&
            $this->funeraria->CurrentValue != $this->funeraria->DefaultValue &&
            !($this->funeraria->IsForeignKey && $this->getCurrentMasterTable() != "" && $this->funeraria->CurrentValue == $this->funeraria->getSessionValue())
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
            $defaultSort = $this->Nparcela->Expression . " DESC"; // Set up default sort
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
                        $this->contrato->setSessionValue("");
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
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_parcela\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Nparcela' first before field var 'x_Nparcela'
        $val = $CurrentForm->hasValue("Nparcela") ? $CurrentForm->getValue("Nparcela") : $CurrentForm->getValue("x_Nparcela");
        if (!$this->Nparcela->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nparcela->Visible = false; // Disable update for API request
            } else {
                $this->Nparcela->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_Nparcela")) {
            $this->Nparcela->setOldValue($CurrentForm->getValue("o_Nparcela"));
        }

        // Check field name 'nacionalidad' first before field var 'x_nacionalidad'
        $val = $CurrentForm->hasValue("nacionalidad") ? $CurrentForm->getValue("nacionalidad") : $CurrentForm->getValue("x_nacionalidad");
        if (!$this->nacionalidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nacionalidad->Visible = false; // Disable update for API request
            } else {
                $this->nacionalidad->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nacionalidad")) {
            $this->nacionalidad->setOldValue($CurrentForm->getValue("o_nacionalidad"));
        }

        // Check field name 'cedula' first before field var 'x_cedula'
        $val = $CurrentForm->hasValue("cedula") ? $CurrentForm->getValue("cedula") : $CurrentForm->getValue("x_cedula");
        if (!$this->cedula->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula->Visible = false; // Disable update for API request
            } else {
                $this->cedula->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_cedula")) {
            $this->cedula->setOldValue($CurrentForm->getValue("o_cedula"));
        }

        // Check field name 'titular' first before field var 'x_titular'
        $val = $CurrentForm->hasValue("titular") ? $CurrentForm->getValue("titular") : $CurrentForm->getValue("x_titular");
        if (!$this->titular->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titular->Visible = false; // Disable update for API request
            } else {
                $this->titular->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_titular")) {
            $this->titular->setOldValue($CurrentForm->getValue("o_titular"));
        }

        // Check field name 'contrato' first before field var 'x_contrato'
        $val = $CurrentForm->hasValue("contrato") ? $CurrentForm->getValue("contrato") : $CurrentForm->getValue("x_contrato");
        if (!$this->contrato->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contrato->Visible = false; // Disable update for API request
            } else {
                $this->contrato->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_contrato")) {
            $this->contrato->setOldValue($CurrentForm->getValue("o_contrato"));
        }

        // Check field name 'seccion' first before field var 'x_seccion'
        $val = $CurrentForm->hasValue("seccion") ? $CurrentForm->getValue("seccion") : $CurrentForm->getValue("x_seccion");
        if (!$this->seccion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->seccion->Visible = false; // Disable update for API request
            } else {
                $this->seccion->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_seccion")) {
            $this->seccion->setOldValue($CurrentForm->getValue("o_seccion"));
        }

        // Check field name 'modulo' first before field var 'x_modulo'
        $val = $CurrentForm->hasValue("modulo") ? $CurrentForm->getValue("modulo") : $CurrentForm->getValue("x_modulo");
        if (!$this->modulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modulo->Visible = false; // Disable update for API request
            } else {
                $this->modulo->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_modulo")) {
            $this->modulo->setOldValue($CurrentForm->getValue("o_modulo"));
        }

        // Check field name 'sub_seccion' first before field var 'x_sub_seccion'
        $val = $CurrentForm->hasValue("sub_seccion") ? $CurrentForm->getValue("sub_seccion") : $CurrentForm->getValue("x_sub_seccion");
        if (!$this->sub_seccion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sub_seccion->Visible = false; // Disable update for API request
            } else {
                $this->sub_seccion->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_sub_seccion")) {
            $this->sub_seccion->setOldValue($CurrentForm->getValue("o_sub_seccion"));
        }

        // Check field name 'parcela' first before field var 'x_parcela'
        $val = $CurrentForm->hasValue("parcela") ? $CurrentForm->getValue("parcela") : $CurrentForm->getValue("x_parcela");
        if (!$this->parcela->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parcela->Visible = false; // Disable update for API request
            } else {
                $this->parcela->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_parcela")) {
            $this->parcela->setOldValue($CurrentForm->getValue("o_parcela"));
        }

        // Check field name 'boveda' first before field var 'x_boveda'
        $val = $CurrentForm->hasValue("boveda") ? $CurrentForm->getValue("boveda") : $CurrentForm->getValue("x_boveda");
        if (!$this->boveda->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->boveda->Visible = false; // Disable update for API request
            } else {
                $this->boveda->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_boveda")) {
            $this->boveda->setOldValue($CurrentForm->getValue("o_boveda"));
        }

        // Check field name 'apellido1' first before field var 'x_apellido1'
        $val = $CurrentForm->hasValue("apellido1") ? $CurrentForm->getValue("apellido1") : $CurrentForm->getValue("x_apellido1");
        if (!$this->apellido1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellido1->Visible = false; // Disable update for API request
            } else {
                $this->apellido1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_apellido1")) {
            $this->apellido1->setOldValue($CurrentForm->getValue("o_apellido1"));
        }

        // Check field name 'apellido2' first before field var 'x_apellido2'
        $val = $CurrentForm->hasValue("apellido2") ? $CurrentForm->getValue("apellido2") : $CurrentForm->getValue("x_apellido2");
        if (!$this->apellido2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellido2->Visible = false; // Disable update for API request
            } else {
                $this->apellido2->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_apellido2")) {
            $this->apellido2->setOldValue($CurrentForm->getValue("o_apellido2"));
        }

        // Check field name 'nombre1' first before field var 'x_nombre1'
        $val = $CurrentForm->hasValue("nombre1") ? $CurrentForm->getValue("nombre1") : $CurrentForm->getValue("x_nombre1");
        if (!$this->nombre1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre1->Visible = false; // Disable update for API request
            } else {
                $this->nombre1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nombre1")) {
            $this->nombre1->setOldValue($CurrentForm->getValue("o_nombre1"));
        }

        // Check field name 'nombre2' first before field var 'x_nombre2'
        $val = $CurrentForm->hasValue("nombre2") ? $CurrentForm->getValue("nombre2") : $CurrentForm->getValue("x_nombre2");
        if (!$this->nombre2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre2->Visible = false; // Disable update for API request
            } else {
                $this->nombre2->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_nombre2")) {
            $this->nombre2->setOldValue($CurrentForm->getValue("o_nombre2"));
        }

        // Check field name 'fecha_inhumacion' first before field var 'x_fecha_inhumacion'
        $val = $CurrentForm->hasValue("fecha_inhumacion") ? $CurrentForm->getValue("fecha_inhumacion") : $CurrentForm->getValue("x_fecha_inhumacion");
        if (!$this->fecha_inhumacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_inhumacion->Visible = false; // Disable update for API request
            } else {
                $this->fecha_inhumacion->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_fecha_inhumacion")) {
            $this->fecha_inhumacion->setOldValue($CurrentForm->getValue("o_fecha_inhumacion"));
        }

        // Check field name 'funeraria' first before field var 'x_funeraria'
        $val = $CurrentForm->hasValue("funeraria") ? $CurrentForm->getValue("funeraria") : $CurrentForm->getValue("x_funeraria");
        if (!$this->funeraria->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->funeraria->Visible = false; // Disable update for API request
            } else {
                $this->funeraria->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_funeraria")) {
            $this->funeraria->setOldValue($CurrentForm->getValue("o_funeraria"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nparcela->CurrentValue = $this->Nparcela->FormValue;
        $this->nacionalidad->CurrentValue = $this->nacionalidad->FormValue;
        $this->cedula->CurrentValue = $this->cedula->FormValue;
        $this->titular->CurrentValue = $this->titular->FormValue;
        $this->contrato->CurrentValue = $this->contrato->FormValue;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->sub_seccion->CurrentValue = $this->sub_seccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->boveda->CurrentValue = $this->boveda->FormValue;
        $this->apellido1->CurrentValue = $this->apellido1->FormValue;
        $this->apellido2->CurrentValue = $this->apellido2->FormValue;
        $this->nombre1->CurrentValue = $this->nombre1->FormValue;
        $this->nombre2->CurrentValue = $this->nombre2->FormValue;
        $this->fecha_inhumacion->CurrentValue = $this->fecha_inhumacion->FormValue;
        $this->funeraria->CurrentValue = $this->funeraria->FormValue;
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
        $this->CopyUrl = $this->getCopyUrl();
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
        } elseif ($this->RowType == RowType::ADD) {
            // Nparcela
            $this->Nparcela->setupEditAttributes();
            $this->Nparcela->EditValue = $this->Nparcela->CurrentValue;
            $this->Nparcela->PlaceHolder = RemoveHtml($this->Nparcela->caption());
            if (strval($this->Nparcela->EditValue) != "" && is_numeric($this->Nparcela->EditValue)) {
                $this->Nparcela->EditValue = $this->Nparcela->EditValue;
            }

            // nacionalidad
            $this->nacionalidad->setupEditAttributes();
            if (!$this->nacionalidad->Raw) {
                $this->nacionalidad->CurrentValue = HtmlDecode($this->nacionalidad->CurrentValue);
            }
            $this->nacionalidad->EditValue = HtmlEncode($this->nacionalidad->CurrentValue);
            $this->nacionalidad->PlaceHolder = RemoveHtml($this->nacionalidad->caption());

            // cedula
            $this->cedula->setupEditAttributes();
            if (!$this->cedula->Raw) {
                $this->cedula->CurrentValue = HtmlDecode($this->cedula->CurrentValue);
            }
            $this->cedula->EditValue = HtmlEncode($this->cedula->CurrentValue);
            $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

            // titular
            $this->titular->setupEditAttributes();
            if (!$this->titular->Raw) {
                $this->titular->CurrentValue = HtmlDecode($this->titular->CurrentValue);
            }
            $this->titular->EditValue = HtmlEncode($this->titular->CurrentValue);
            $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

            // contrato
            $this->contrato->setupEditAttributes();
            if ($this->contrato->getSessionValue() != "") {
                $this->contrato->CurrentValue = GetForeignKeyValue($this->contrato->getSessionValue());
                $this->contrato->OldValue = $this->contrato->CurrentValue;
                $this->contrato->ViewValue = $this->contrato->CurrentValue;
            } else {
                if (!$this->contrato->Raw) {
                    $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
                }
                $this->contrato->EditValue = HtmlEncode($this->contrato->CurrentValue);
                $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());
            }

            // seccion
            $this->seccion->setupEditAttributes();
            if (!$this->seccion->Raw) {
                $this->seccion->CurrentValue = HtmlDecode($this->seccion->CurrentValue);
            }
            $this->seccion->EditValue = HtmlEncode($this->seccion->CurrentValue);
            $this->seccion->PlaceHolder = RemoveHtml($this->seccion->caption());

            // modulo
            $this->modulo->setupEditAttributes();
            if (!$this->modulo->Raw) {
                $this->modulo->CurrentValue = HtmlDecode($this->modulo->CurrentValue);
            }
            $this->modulo->EditValue = HtmlEncode($this->modulo->CurrentValue);
            $this->modulo->PlaceHolder = RemoveHtml($this->modulo->caption());

            // sub_seccion
            $this->sub_seccion->setupEditAttributes();
            if (!$this->sub_seccion->Raw) {
                $this->sub_seccion->CurrentValue = HtmlDecode($this->sub_seccion->CurrentValue);
            }
            $this->sub_seccion->EditValue = HtmlEncode($this->sub_seccion->CurrentValue);
            $this->sub_seccion->PlaceHolder = RemoveHtml($this->sub_seccion->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->CurrentValue = HtmlDecode($this->parcela->CurrentValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->CurrentValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

            // boveda
            $this->boveda->setupEditAttributes();
            if (!$this->boveda->Raw) {
                $this->boveda->CurrentValue = HtmlDecode($this->boveda->CurrentValue);
            }
            $this->boveda->EditValue = HtmlEncode($this->boveda->CurrentValue);
            $this->boveda->PlaceHolder = RemoveHtml($this->boveda->caption());

            // apellido1
            $this->apellido1->setupEditAttributes();
            if (!$this->apellido1->Raw) {
                $this->apellido1->CurrentValue = HtmlDecode($this->apellido1->CurrentValue);
            }
            $this->apellido1->EditValue = HtmlEncode($this->apellido1->CurrentValue);
            $this->apellido1->PlaceHolder = RemoveHtml($this->apellido1->caption());

            // apellido2
            $this->apellido2->setupEditAttributes();
            if (!$this->apellido2->Raw) {
                $this->apellido2->CurrentValue = HtmlDecode($this->apellido2->CurrentValue);
            }
            $this->apellido2->EditValue = HtmlEncode($this->apellido2->CurrentValue);
            $this->apellido2->PlaceHolder = RemoveHtml($this->apellido2->caption());

            // nombre1
            $this->nombre1->setupEditAttributes();
            if (!$this->nombre1->Raw) {
                $this->nombre1->CurrentValue = HtmlDecode($this->nombre1->CurrentValue);
            }
            $this->nombre1->EditValue = HtmlEncode($this->nombre1->CurrentValue);
            $this->nombre1->PlaceHolder = RemoveHtml($this->nombre1->caption());

            // nombre2
            $this->nombre2->setupEditAttributes();
            if (!$this->nombre2->Raw) {
                $this->nombre2->CurrentValue = HtmlDecode($this->nombre2->CurrentValue);
            }
            $this->nombre2->EditValue = HtmlEncode($this->nombre2->CurrentValue);
            $this->nombre2->PlaceHolder = RemoveHtml($this->nombre2->caption());

            // fecha_inhumacion
            $this->fecha_inhumacion->setupEditAttributes();
            if (!$this->fecha_inhumacion->Raw) {
                $this->fecha_inhumacion->CurrentValue = HtmlDecode($this->fecha_inhumacion->CurrentValue);
            }
            $this->fecha_inhumacion->EditValue = HtmlEncode($this->fecha_inhumacion->CurrentValue);
            $this->fecha_inhumacion->PlaceHolder = RemoveHtml($this->fecha_inhumacion->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            if (!$this->funeraria->Raw) {
                $this->funeraria->CurrentValue = HtmlDecode($this->funeraria->CurrentValue);
            }
            $this->funeraria->EditValue = HtmlEncode($this->funeraria->CurrentValue);
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

            // Add refer script

            // Nparcela
            $this->Nparcela->HrefValue = "";

            // nacionalidad
            $this->nacionalidad->HrefValue = "";

            // cedula
            $this->cedula->HrefValue = "";

            // titular
            $this->titular->HrefValue = "";

            // contrato
            $this->contrato->HrefValue = "";

            // seccion
            $this->seccion->HrefValue = "";

            // modulo
            $this->modulo->HrefValue = "";

            // sub_seccion
            $this->sub_seccion->HrefValue = "";

            // parcela
            $this->parcela->HrefValue = "";

            // boveda
            $this->boveda->HrefValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";

            // fecha_inhumacion
            $this->fecha_inhumacion->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nparcela
            $this->Nparcela->setupEditAttributes();
            $this->Nparcela->EditValue = $this->Nparcela->CurrentValue;
            $this->Nparcela->PlaceHolder = RemoveHtml($this->Nparcela->caption());

            // nacionalidad
            $this->nacionalidad->setupEditAttributes();
            if (!$this->nacionalidad->Raw) {
                $this->nacionalidad->CurrentValue = HtmlDecode($this->nacionalidad->CurrentValue);
            }
            $this->nacionalidad->EditValue = HtmlEncode($this->nacionalidad->CurrentValue);
            $this->nacionalidad->PlaceHolder = RemoveHtml($this->nacionalidad->caption());

            // cedula
            $this->cedula->setupEditAttributes();
            if (!$this->cedula->Raw) {
                $this->cedula->CurrentValue = HtmlDecode($this->cedula->CurrentValue);
            }
            $this->cedula->EditValue = HtmlEncode($this->cedula->CurrentValue);
            $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

            // titular
            $this->titular->setupEditAttributes();
            if (!$this->titular->Raw) {
                $this->titular->CurrentValue = HtmlDecode($this->titular->CurrentValue);
            }
            $this->titular->EditValue = HtmlEncode($this->titular->CurrentValue);
            $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

            // contrato
            $this->contrato->setupEditAttributes();
            if ($this->contrato->getSessionValue() != "") {
                $this->contrato->CurrentValue = GetForeignKeyValue($this->contrato->getSessionValue());
                $this->contrato->OldValue = $this->contrato->CurrentValue;
                $this->contrato->ViewValue = $this->contrato->CurrentValue;
            } else {
                if (!$this->contrato->Raw) {
                    $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
                }
                $this->contrato->EditValue = HtmlEncode($this->contrato->CurrentValue);
                $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());
            }

            // seccion
            $this->seccion->setupEditAttributes();
            if (!$this->seccion->Raw) {
                $this->seccion->CurrentValue = HtmlDecode($this->seccion->CurrentValue);
            }
            $this->seccion->EditValue = HtmlEncode($this->seccion->CurrentValue);
            $this->seccion->PlaceHolder = RemoveHtml($this->seccion->caption());

            // modulo
            $this->modulo->setupEditAttributes();
            if (!$this->modulo->Raw) {
                $this->modulo->CurrentValue = HtmlDecode($this->modulo->CurrentValue);
            }
            $this->modulo->EditValue = HtmlEncode($this->modulo->CurrentValue);
            $this->modulo->PlaceHolder = RemoveHtml($this->modulo->caption());

            // sub_seccion
            $this->sub_seccion->setupEditAttributes();
            if (!$this->sub_seccion->Raw) {
                $this->sub_seccion->CurrentValue = HtmlDecode($this->sub_seccion->CurrentValue);
            }
            $this->sub_seccion->EditValue = HtmlEncode($this->sub_seccion->CurrentValue);
            $this->sub_seccion->PlaceHolder = RemoveHtml($this->sub_seccion->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->CurrentValue = HtmlDecode($this->parcela->CurrentValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->CurrentValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

            // boveda
            $this->boveda->setupEditAttributes();
            if (!$this->boveda->Raw) {
                $this->boveda->CurrentValue = HtmlDecode($this->boveda->CurrentValue);
            }
            $this->boveda->EditValue = HtmlEncode($this->boveda->CurrentValue);
            $this->boveda->PlaceHolder = RemoveHtml($this->boveda->caption());

            // apellido1
            $this->apellido1->setupEditAttributes();
            if (!$this->apellido1->Raw) {
                $this->apellido1->CurrentValue = HtmlDecode($this->apellido1->CurrentValue);
            }
            $this->apellido1->EditValue = HtmlEncode($this->apellido1->CurrentValue);
            $this->apellido1->PlaceHolder = RemoveHtml($this->apellido1->caption());

            // apellido2
            $this->apellido2->setupEditAttributes();
            if (!$this->apellido2->Raw) {
                $this->apellido2->CurrentValue = HtmlDecode($this->apellido2->CurrentValue);
            }
            $this->apellido2->EditValue = HtmlEncode($this->apellido2->CurrentValue);
            $this->apellido2->PlaceHolder = RemoveHtml($this->apellido2->caption());

            // nombre1
            $this->nombre1->setupEditAttributes();
            if (!$this->nombre1->Raw) {
                $this->nombre1->CurrentValue = HtmlDecode($this->nombre1->CurrentValue);
            }
            $this->nombre1->EditValue = HtmlEncode($this->nombre1->CurrentValue);
            $this->nombre1->PlaceHolder = RemoveHtml($this->nombre1->caption());

            // nombre2
            $this->nombre2->setupEditAttributes();
            if (!$this->nombre2->Raw) {
                $this->nombre2->CurrentValue = HtmlDecode($this->nombre2->CurrentValue);
            }
            $this->nombre2->EditValue = HtmlEncode($this->nombre2->CurrentValue);
            $this->nombre2->PlaceHolder = RemoveHtml($this->nombre2->caption());

            // fecha_inhumacion
            $this->fecha_inhumacion->setupEditAttributes();
            if (!$this->fecha_inhumacion->Raw) {
                $this->fecha_inhumacion->CurrentValue = HtmlDecode($this->fecha_inhumacion->CurrentValue);
            }
            $this->fecha_inhumacion->EditValue = HtmlEncode($this->fecha_inhumacion->CurrentValue);
            $this->fecha_inhumacion->PlaceHolder = RemoveHtml($this->fecha_inhumacion->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            if (!$this->funeraria->Raw) {
                $this->funeraria->CurrentValue = HtmlDecode($this->funeraria->CurrentValue);
            }
            $this->funeraria->EditValue = HtmlEncode($this->funeraria->CurrentValue);
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

            // Edit refer script

            // Nparcela
            $this->Nparcela->HrefValue = "";

            // nacionalidad
            $this->nacionalidad->HrefValue = "";

            // cedula
            $this->cedula->HrefValue = "";

            // titular
            $this->titular->HrefValue = "";

            // contrato
            $this->contrato->HrefValue = "";

            // seccion
            $this->seccion->HrefValue = "";

            // modulo
            $this->modulo->HrefValue = "";

            // sub_seccion
            $this->sub_seccion->HrefValue = "";

            // parcela
            $this->parcela->HrefValue = "";

            // boveda
            $this->boveda->HrefValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";

            // fecha_inhumacion
            $this->fecha_inhumacion->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
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
            if ($this->Nparcela->Visible && $this->Nparcela->Required) {
                if (!$this->Nparcela->IsDetailKey && EmptyValue($this->Nparcela->FormValue)) {
                    $this->Nparcela->addErrorMessage(str_replace("%s", $this->Nparcela->caption(), $this->Nparcela->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Nparcela->FormValue)) {
                $this->Nparcela->addErrorMessage($this->Nparcela->getErrorMessage(false));
            }
            if ($this->nacionalidad->Visible && $this->nacionalidad->Required) {
                if (!$this->nacionalidad->IsDetailKey && EmptyValue($this->nacionalidad->FormValue)) {
                    $this->nacionalidad->addErrorMessage(str_replace("%s", $this->nacionalidad->caption(), $this->nacionalidad->RequiredErrorMessage));
                }
            }
            if ($this->cedula->Visible && $this->cedula->Required) {
                if (!$this->cedula->IsDetailKey && EmptyValue($this->cedula->FormValue)) {
                    $this->cedula->addErrorMessage(str_replace("%s", $this->cedula->caption(), $this->cedula->RequiredErrorMessage));
                }
            }
            if ($this->titular->Visible && $this->titular->Required) {
                if (!$this->titular->IsDetailKey && EmptyValue($this->titular->FormValue)) {
                    $this->titular->addErrorMessage(str_replace("%s", $this->titular->caption(), $this->titular->RequiredErrorMessage));
                }
            }
            if ($this->contrato->Visible && $this->contrato->Required) {
                if (!$this->contrato->IsDetailKey && EmptyValue($this->contrato->FormValue)) {
                    $this->contrato->addErrorMessage(str_replace("%s", $this->contrato->caption(), $this->contrato->RequiredErrorMessage));
                }
            }
            if ($this->seccion->Visible && $this->seccion->Required) {
                if (!$this->seccion->IsDetailKey && EmptyValue($this->seccion->FormValue)) {
                    $this->seccion->addErrorMessage(str_replace("%s", $this->seccion->caption(), $this->seccion->RequiredErrorMessage));
                }
            }
            if ($this->modulo->Visible && $this->modulo->Required) {
                if (!$this->modulo->IsDetailKey && EmptyValue($this->modulo->FormValue)) {
                    $this->modulo->addErrorMessage(str_replace("%s", $this->modulo->caption(), $this->modulo->RequiredErrorMessage));
                }
            }
            if ($this->sub_seccion->Visible && $this->sub_seccion->Required) {
                if (!$this->sub_seccion->IsDetailKey && EmptyValue($this->sub_seccion->FormValue)) {
                    $this->sub_seccion->addErrorMessage(str_replace("%s", $this->sub_seccion->caption(), $this->sub_seccion->RequiredErrorMessage));
                }
            }
            if ($this->parcela->Visible && $this->parcela->Required) {
                if (!$this->parcela->IsDetailKey && EmptyValue($this->parcela->FormValue)) {
                    $this->parcela->addErrorMessage(str_replace("%s", $this->parcela->caption(), $this->parcela->RequiredErrorMessage));
                }
            }
            if ($this->boveda->Visible && $this->boveda->Required) {
                if (!$this->boveda->IsDetailKey && EmptyValue($this->boveda->FormValue)) {
                    $this->boveda->addErrorMessage(str_replace("%s", $this->boveda->caption(), $this->boveda->RequiredErrorMessage));
                }
            }
            if ($this->apellido1->Visible && $this->apellido1->Required) {
                if (!$this->apellido1->IsDetailKey && EmptyValue($this->apellido1->FormValue)) {
                    $this->apellido1->addErrorMessage(str_replace("%s", $this->apellido1->caption(), $this->apellido1->RequiredErrorMessage));
                }
            }
            if ($this->apellido2->Visible && $this->apellido2->Required) {
                if (!$this->apellido2->IsDetailKey && EmptyValue($this->apellido2->FormValue)) {
                    $this->apellido2->addErrorMessage(str_replace("%s", $this->apellido2->caption(), $this->apellido2->RequiredErrorMessage));
                }
            }
            if ($this->nombre1->Visible && $this->nombre1->Required) {
                if (!$this->nombre1->IsDetailKey && EmptyValue($this->nombre1->FormValue)) {
                    $this->nombre1->addErrorMessage(str_replace("%s", $this->nombre1->caption(), $this->nombre1->RequiredErrorMessage));
                }
            }
            if ($this->nombre2->Visible && $this->nombre2->Required) {
                if (!$this->nombre2->IsDetailKey && EmptyValue($this->nombre2->FormValue)) {
                    $this->nombre2->addErrorMessage(str_replace("%s", $this->nombre2->caption(), $this->nombre2->RequiredErrorMessage));
                }
            }
            if ($this->fecha_inhumacion->Visible && $this->fecha_inhumacion->Required) {
                if (!$this->fecha_inhumacion->IsDetailKey && EmptyValue($this->fecha_inhumacion->FormValue)) {
                    $this->fecha_inhumacion->addErrorMessage(str_replace("%s", $this->fecha_inhumacion->caption(), $this->fecha_inhumacion->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_inhumacion->FormValue, $this->fecha_inhumacion->formatPattern())) {
                $this->fecha_inhumacion->addErrorMessage($this->fecha_inhumacion->getErrorMessage(false));
            }
            if ($this->funeraria->Visible && $this->funeraria->Required) {
                if (!$this->funeraria->IsDetailKey && EmptyValue($this->funeraria->FormValue)) {
                    $this->funeraria->addErrorMessage(str_replace("%s", $this->funeraria->caption(), $this->funeraria->RequiredErrorMessage));
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
            $thisKey .= $row['Nparcela'];

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

        // Check field with unique index (Nparcela)
        if ($this->Nparcela->CurrentValue != "") {
            $filterChk = "(`Nparcela` = " . AdjustSql($this->Nparcela->CurrentValue, $this->Dbid) . ")";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->Nparcela->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Nparcela->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);

        // Check for duplicate key when key changed
        if ($updateRow) {
            $newKeyFilter = $this->getRecordFilter($rsnew);
            if ($newKeyFilter != $oldKeyFilter) {
                $rsChk = $this->loadRs($newKeyFilter)->fetch();
                if ($rsChk !== false) {
                    $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                    $this->setFailureMessage($keyErrMsg);
                    $updateRow = false;
                }
            }
        }
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

        // Nparcela
        $this->Nparcela->setDbValueDef($rsnew, $this->Nparcela->CurrentValue, $this->Nparcela->ReadOnly);

        // nacionalidad
        $this->nacionalidad->setDbValueDef($rsnew, $this->nacionalidad->CurrentValue, $this->nacionalidad->ReadOnly);

        // cedula
        $this->cedula->setDbValueDef($rsnew, $this->cedula->CurrentValue, $this->cedula->ReadOnly);

        // titular
        $this->titular->setDbValueDef($rsnew, $this->titular->CurrentValue, $this->titular->ReadOnly);

        // contrato
        if ($this->contrato->getSessionValue() != "") {
            $this->contrato->ReadOnly = true;
        }
        $this->contrato->setDbValueDef($rsnew, $this->contrato->CurrentValue, $this->contrato->ReadOnly);

        // seccion
        $this->seccion->setDbValueDef($rsnew, $this->seccion->CurrentValue, $this->seccion->ReadOnly);

        // modulo
        $this->modulo->setDbValueDef($rsnew, $this->modulo->CurrentValue, $this->modulo->ReadOnly);

        // sub_seccion
        $this->sub_seccion->setDbValueDef($rsnew, $this->sub_seccion->CurrentValue, $this->sub_seccion->ReadOnly);

        // parcela
        $this->parcela->setDbValueDef($rsnew, $this->parcela->CurrentValue, $this->parcela->ReadOnly);

        // boveda
        $this->boveda->setDbValueDef($rsnew, $this->boveda->CurrentValue, $this->boveda->ReadOnly);

        // apellido1
        $this->apellido1->setDbValueDef($rsnew, $this->apellido1->CurrentValue, $this->apellido1->ReadOnly);

        // apellido2
        $this->apellido2->setDbValueDef($rsnew, $this->apellido2->CurrentValue, $this->apellido2->ReadOnly);

        // nombre1
        $this->nombre1->setDbValueDef($rsnew, $this->nombre1->CurrentValue, $this->nombre1->ReadOnly);

        // nombre2
        $this->nombre2->setDbValueDef($rsnew, $this->nombre2->CurrentValue, $this->nombre2->ReadOnly);

        // fecha_inhumacion
        $this->fecha_inhumacion->setDbValueDef($rsnew, $this->fecha_inhumacion->CurrentValue, $this->fecha_inhumacion->ReadOnly);

        // funeraria
        $this->funeraria->setDbValueDef($rsnew, $this->funeraria->CurrentValue, $this->funeraria->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['Nparcela'])) { // Nparcela
            $this->Nparcela->CurrentValue = $row['Nparcela'];
        }
        if (isset($row['nacionalidad'])) { // nacionalidad
            $this->nacionalidad->CurrentValue = $row['nacionalidad'];
        }
        if (isset($row['cedula'])) { // cedula
            $this->cedula->CurrentValue = $row['cedula'];
        }
        if (isset($row['titular'])) { // titular
            $this->titular->CurrentValue = $row['titular'];
        }
        if (isset($row['contrato'])) { // contrato
            $this->contrato->CurrentValue = $row['contrato'];
        }
        if (isset($row['seccion'])) { // seccion
            $this->seccion->CurrentValue = $row['seccion'];
        }
        if (isset($row['modulo'])) { // modulo
            $this->modulo->CurrentValue = $row['modulo'];
        }
        if (isset($row['sub_seccion'])) { // sub_seccion
            $this->sub_seccion->CurrentValue = $row['sub_seccion'];
        }
        if (isset($row['parcela'])) { // parcela
            $this->parcela->CurrentValue = $row['parcela'];
        }
        if (isset($row['boveda'])) { // boveda
            $this->boveda->CurrentValue = $row['boveda'];
        }
        if (isset($row['apellido1'])) { // apellido1
            $this->apellido1->CurrentValue = $row['apellido1'];
        }
        if (isset($row['apellido2'])) { // apellido2
            $this->apellido2->CurrentValue = $row['apellido2'];
        }
        if (isset($row['nombre1'])) { // nombre1
            $this->nombre1->CurrentValue = $row['nombre1'];
        }
        if (isset($row['nombre2'])) { // nombre2
            $this->nombre2->CurrentValue = $row['nombre2'];
        }
        if (isset($row['fecha_inhumacion'])) { // fecha_inhumacion
            $this->fecha_inhumacion->CurrentValue = $row['fecha_inhumacion'];
        }
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->CurrentValue = $row['funeraria'];
        }
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "sco_expediente") {
            $this->contrato->Visible = true; // Need to insert foreign key
            $this->contrato->CurrentValue = $this->contrato->getSessionValue();
        }

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->Nparcela->CurrentValue != "") { // Check field with unique index
            $filter = "(`Nparcela` = " . AdjustSql($this->Nparcela->CurrentValue, $this->Dbid) . ")";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->Nparcela->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Nparcela->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['Nparcela']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
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

        // Nparcela
        $this->Nparcela->setDbValueDef($rsnew, $this->Nparcela->CurrentValue, false);

        // nacionalidad
        $this->nacionalidad->setDbValueDef($rsnew, $this->nacionalidad->CurrentValue, false);

        // cedula
        $this->cedula->setDbValueDef($rsnew, $this->cedula->CurrentValue, false);

        // titular
        $this->titular->setDbValueDef($rsnew, $this->titular->CurrentValue, false);

        // contrato
        $this->contrato->setDbValueDef($rsnew, $this->contrato->CurrentValue, false);

        // seccion
        $this->seccion->setDbValueDef($rsnew, $this->seccion->CurrentValue, false);

        // modulo
        $this->modulo->setDbValueDef($rsnew, $this->modulo->CurrentValue, false);

        // sub_seccion
        $this->sub_seccion->setDbValueDef($rsnew, $this->sub_seccion->CurrentValue, false);

        // parcela
        $this->parcela->setDbValueDef($rsnew, $this->parcela->CurrentValue, false);

        // boveda
        $this->boveda->setDbValueDef($rsnew, $this->boveda->CurrentValue, false);

        // apellido1
        $this->apellido1->setDbValueDef($rsnew, $this->apellido1->CurrentValue, false);

        // apellido2
        $this->apellido2->setDbValueDef($rsnew, $this->apellido2->CurrentValue, false);

        // nombre1
        $this->nombre1->setDbValueDef($rsnew, $this->nombre1->CurrentValue, false);

        // nombre2
        $this->nombre2->setDbValueDef($rsnew, $this->nombre2->CurrentValue, false);

        // fecha_inhumacion
        $this->fecha_inhumacion->setDbValueDef($rsnew, $this->fecha_inhumacion->CurrentValue, false);

        // funeraria
        $this->funeraria->setDbValueDef($rsnew, $this->funeraria->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['Nparcela'])) { // Nparcela
            $this->Nparcela->setFormValue($row['Nparcela']);
        }
        if (isset($row['nacionalidad'])) { // nacionalidad
            $this->nacionalidad->setFormValue($row['nacionalidad']);
        }
        if (isset($row['cedula'])) { // cedula
            $this->cedula->setFormValue($row['cedula']);
        }
        if (isset($row['titular'])) { // titular
            $this->titular->setFormValue($row['titular']);
        }
        if (isset($row['contrato'])) { // contrato
            $this->contrato->setFormValue($row['contrato']);
        }
        if (isset($row['seccion'])) { // seccion
            $this->seccion->setFormValue($row['seccion']);
        }
        if (isset($row['modulo'])) { // modulo
            $this->modulo->setFormValue($row['modulo']);
        }
        if (isset($row['sub_seccion'])) { // sub_seccion
            $this->sub_seccion->setFormValue($row['sub_seccion']);
        }
        if (isset($row['parcela'])) { // parcela
            $this->parcela->setFormValue($row['parcela']);
        }
        if (isset($row['boveda'])) { // boveda
            $this->boveda->setFormValue($row['boveda']);
        }
        if (isset($row['apellido1'])) { // apellido1
            $this->apellido1->setFormValue($row['apellido1']);
        }
        if (isset($row['apellido2'])) { // apellido2
            $this->apellido2->setFormValue($row['apellido2']);
        }
        if (isset($row['nombre1'])) { // nombre1
            $this->nombre1->setFormValue($row['nombre1']);
        }
        if (isset($row['nombre2'])) { // nombre2
            $this->nombre2->setFormValue($row['nombre2']);
        }
        if (isset($row['fecha_inhumacion'])) { // fecha_inhumacion
            $this->fecha_inhumacion->setFormValue($row['fecha_inhumacion']);
        }
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->setFormValue($row['funeraria']);
        }
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "sco_expediente") {
            $masterTbl = Container("sco_expediente");
            $this->contrato->Visible = false;
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
}
