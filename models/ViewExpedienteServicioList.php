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
class ViewExpedienteServicioList extends ViewExpedienteServicio
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewExpedienteServicioList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fview_expediente_serviciolist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ViewExpedienteServicioList";

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
        $this->seguro->setVisibility();
        $this->nombre_contacto->setVisibility();
        $this->telefono_contacto1->setVisibility();
        $this->telefono_contacto2->setVisibility();
        $this->cedula_fallecido->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->fecha_nacimiento->Visible = false;
        $this->edad_fallecido->setVisibility();
        $this->sexo->setVisibility();
        $this->fecha_ocurrencia->Visible = false;
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->Visible = false;
        $this->permiso->Visible = false;
        $this->capilla->setVisibility();
        $this->horas->setVisibility();
        $this->ataud->setVisibility();
        $this->arreglo_floral->setVisibility();
        $this->oficio_religioso->setVisibility();
        $this->ofrenda_voz->setVisibility();
        $this->fecha_inicio->Visible = false;
        $this->hora_inicio->Visible = false;
        $this->fecha_fin->Visible = false;
        $this->hora_fin->Visible = false;
        $this->servicio->setVisibility();
        $this->fecha_serv->Visible = false;
        $this->hora_serv->Visible = false;
        $this->espera_cenizas->Visible = false;
        $this->hora_fin_capilla->Visible = false;
        $this->hora_fin_servicio->Visible = false;
        $this->estatus->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->factura->setVisibility();
        $this->venta->setVisibility();
        $this->_email->Visible = false;
        $this->sede->Visible = false;
        $this->funeraria->setVisibility();
        $this->cod_servicio->setVisibility();
        $this->coordinador->setVisibility();
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
        $this->TableVar = 'view_expediente_servicio';
        $this->TableName = 'view_expediente_servicio';

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

        // Table object (view_expediente_servicio)
        if (!isset($GLOBALS["view_expediente_servicio"]) || $GLOBALS["view_expediente_servicio"]::class == PROJECT_NAMESPACE . "view_expediente_servicio") {
            $GLOBALS["view_expediente_servicio"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ViewExpedienteServicioAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ViewExpedienteServicioDelete";
        $this->MultiUpdateUrl = "ViewExpedienteServicioUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_expediente_servicio');
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
                    $result["view"] = SameString($pageName, "ViewExpedienteServicioView"); // If View page, no primary button
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
    public $PageSizes = "5,10,20,50"; // Page sizes (comma separated)
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
        $this->setupLookupOptions($this->estatus);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fview_expediente_serviciogrid";
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
        $filterList = Concat($filterList, $this->Nexpediente->AdvancedSearch->toJson(), ","); // Field Nexpediente
        $filterList = Concat($filterList, $this->seguro->AdvancedSearch->toJson(), ","); // Field seguro
        $filterList = Concat($filterList, $this->nombre_contacto->AdvancedSearch->toJson(), ","); // Field nombre_contacto
        $filterList = Concat($filterList, $this->telefono_contacto1->AdvancedSearch->toJson(), ","); // Field telefono_contacto1
        $filterList = Concat($filterList, $this->telefono_contacto2->AdvancedSearch->toJson(), ","); // Field telefono_contacto2
        $filterList = Concat($filterList, $this->cedula_fallecido->AdvancedSearch->toJson(), ","); // Field cedula_fallecido
        $filterList = Concat($filterList, $this->nombre_fallecido->AdvancedSearch->toJson(), ","); // Field nombre_fallecido
        $filterList = Concat($filterList, $this->apellidos_fallecido->AdvancedSearch->toJson(), ","); // Field apellidos_fallecido
        $filterList = Concat($filterList, $this->fecha_nacimiento->AdvancedSearch->toJson(), ","); // Field fecha_nacimiento
        $filterList = Concat($filterList, $this->edad_fallecido->AdvancedSearch->toJson(), ","); // Field edad_fallecido
        $filterList = Concat($filterList, $this->sexo->AdvancedSearch->toJson(), ","); // Field sexo
        $filterList = Concat($filterList, $this->fecha_ocurrencia->AdvancedSearch->toJson(), ","); // Field fecha_ocurrencia
        $filterList = Concat($filterList, $this->causa_ocurrencia->AdvancedSearch->toJson(), ","); // Field causa_ocurrencia
        $filterList = Concat($filterList, $this->causa_otro->AdvancedSearch->toJson(), ","); // Field causa_otro
        $filterList = Concat($filterList, $this->permiso->AdvancedSearch->toJson(), ","); // Field permiso
        $filterList = Concat($filterList, $this->capilla->AdvancedSearch->toJson(), ","); // Field capilla
        $filterList = Concat($filterList, $this->horas->AdvancedSearch->toJson(), ","); // Field horas
        $filterList = Concat($filterList, $this->ataud->AdvancedSearch->toJson(), ","); // Field ataud
        $filterList = Concat($filterList, $this->arreglo_floral->AdvancedSearch->toJson(), ","); // Field arreglo_floral
        $filterList = Concat($filterList, $this->oficio_religioso->AdvancedSearch->toJson(), ","); // Field oficio_religioso
        $filterList = Concat($filterList, $this->ofrenda_voz->AdvancedSearch->toJson(), ","); // Field ofrenda_voz
        $filterList = Concat($filterList, $this->fecha_inicio->AdvancedSearch->toJson(), ","); // Field fecha_inicio
        $filterList = Concat($filterList, $this->hora_inicio->AdvancedSearch->toJson(), ","); // Field hora_inicio
        $filterList = Concat($filterList, $this->fecha_fin->AdvancedSearch->toJson(), ","); // Field fecha_fin
        $filterList = Concat($filterList, $this->hora_fin->AdvancedSearch->toJson(), ","); // Field hora_fin
        $filterList = Concat($filterList, $this->servicio->AdvancedSearch->toJson(), ","); // Field servicio
        $filterList = Concat($filterList, $this->fecha_serv->AdvancedSearch->toJson(), ","); // Field fecha_serv
        $filterList = Concat($filterList, $this->hora_serv->AdvancedSearch->toJson(), ","); // Field hora_serv
        $filterList = Concat($filterList, $this->espera_cenizas->AdvancedSearch->toJson(), ","); // Field espera_cenizas
        $filterList = Concat($filterList, $this->hora_fin_capilla->AdvancedSearch->toJson(), ","); // Field hora_fin_capilla
        $filterList = Concat($filterList, $this->hora_fin_servicio->AdvancedSearch->toJson(), ","); // Field hora_fin_servicio
        $filterList = Concat($filterList, $this->estatus->AdvancedSearch->toJson(), ","); // Field estatus
        $filterList = Concat($filterList, $this->fecha_registro->AdvancedSearch->toJson(), ","); // Field fecha_registro
        $filterList = Concat($filterList, $this->factura->AdvancedSearch->toJson(), ","); // Field factura
        $filterList = Concat($filterList, $this->venta->AdvancedSearch->toJson(), ","); // Field venta
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->sede->AdvancedSearch->toJson(), ","); // Field sede
        $filterList = Concat($filterList, $this->funeraria->AdvancedSearch->toJson(), ","); // Field funeraria
        $filterList = Concat($filterList, $this->cod_servicio->AdvancedSearch->toJson(), ","); // Field cod_servicio
        $filterList = Concat($filterList, $this->coordinador->AdvancedSearch->toJson(), ","); // Field coordinador
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
            Profile()->setSearchFilters("fview_expediente_serviciosrch", $filters);
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

        // Field seguro
        $this->seguro->AdvancedSearch->SearchValue = @$filter["x_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator = @$filter["z_seguro"];
        $this->seguro->AdvancedSearch->SearchCondition = @$filter["v_seguro"];
        $this->seguro->AdvancedSearch->SearchValue2 = @$filter["y_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator2 = @$filter["w_seguro"];
        $this->seguro->AdvancedSearch->save();

        // Field nombre_contacto
        $this->nombre_contacto->AdvancedSearch->SearchValue = @$filter["x_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchOperator = @$filter["z_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchCondition = @$filter["v_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchValue2 = @$filter["y_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->save();

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

        // Field cedula_fallecido
        $this->cedula_fallecido->AdvancedSearch->SearchValue = @$filter["x_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchOperator = @$filter["z_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchCondition = @$filter["v_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_cedula_fallecido"];
        $this->cedula_fallecido->AdvancedSearch->save();

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

        // Field sexo
        $this->sexo->AdvancedSearch->SearchValue = @$filter["x_sexo"];
        $this->sexo->AdvancedSearch->SearchOperator = @$filter["z_sexo"];
        $this->sexo->AdvancedSearch->SearchCondition = @$filter["v_sexo"];
        $this->sexo->AdvancedSearch->SearchValue2 = @$filter["y_sexo"];
        $this->sexo->AdvancedSearch->SearchOperator2 = @$filter["w_sexo"];
        $this->sexo->AdvancedSearch->save();

        // Field fecha_ocurrencia
        $this->fecha_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->save();

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

        // Field permiso
        $this->permiso->AdvancedSearch->SearchValue = @$filter["x_permiso"];
        $this->permiso->AdvancedSearch->SearchOperator = @$filter["z_permiso"];
        $this->permiso->AdvancedSearch->SearchCondition = @$filter["v_permiso"];
        $this->permiso->AdvancedSearch->SearchValue2 = @$filter["y_permiso"];
        $this->permiso->AdvancedSearch->SearchOperator2 = @$filter["w_permiso"];
        $this->permiso->AdvancedSearch->save();

        // Field capilla
        $this->capilla->AdvancedSearch->SearchValue = @$filter["x_capilla"];
        $this->capilla->AdvancedSearch->SearchOperator = @$filter["z_capilla"];
        $this->capilla->AdvancedSearch->SearchCondition = @$filter["v_capilla"];
        $this->capilla->AdvancedSearch->SearchValue2 = @$filter["y_capilla"];
        $this->capilla->AdvancedSearch->SearchOperator2 = @$filter["w_capilla"];
        $this->capilla->AdvancedSearch->save();

        // Field horas
        $this->horas->AdvancedSearch->SearchValue = @$filter["x_horas"];
        $this->horas->AdvancedSearch->SearchOperator = @$filter["z_horas"];
        $this->horas->AdvancedSearch->SearchCondition = @$filter["v_horas"];
        $this->horas->AdvancedSearch->SearchValue2 = @$filter["y_horas"];
        $this->horas->AdvancedSearch->SearchOperator2 = @$filter["w_horas"];
        $this->horas->AdvancedSearch->save();

        // Field ataud
        $this->ataud->AdvancedSearch->SearchValue = @$filter["x_ataud"];
        $this->ataud->AdvancedSearch->SearchOperator = @$filter["z_ataud"];
        $this->ataud->AdvancedSearch->SearchCondition = @$filter["v_ataud"];
        $this->ataud->AdvancedSearch->SearchValue2 = @$filter["y_ataud"];
        $this->ataud->AdvancedSearch->SearchOperator2 = @$filter["w_ataud"];
        $this->ataud->AdvancedSearch->save();

        // Field arreglo_floral
        $this->arreglo_floral->AdvancedSearch->SearchValue = @$filter["x_arreglo_floral"];
        $this->arreglo_floral->AdvancedSearch->SearchOperator = @$filter["z_arreglo_floral"];
        $this->arreglo_floral->AdvancedSearch->SearchCondition = @$filter["v_arreglo_floral"];
        $this->arreglo_floral->AdvancedSearch->SearchValue2 = @$filter["y_arreglo_floral"];
        $this->arreglo_floral->AdvancedSearch->SearchOperator2 = @$filter["w_arreglo_floral"];
        $this->arreglo_floral->AdvancedSearch->save();

        // Field oficio_religioso
        $this->oficio_religioso->AdvancedSearch->SearchValue = @$filter["x_oficio_religioso"];
        $this->oficio_religioso->AdvancedSearch->SearchOperator = @$filter["z_oficio_religioso"];
        $this->oficio_religioso->AdvancedSearch->SearchCondition = @$filter["v_oficio_religioso"];
        $this->oficio_religioso->AdvancedSearch->SearchValue2 = @$filter["y_oficio_religioso"];
        $this->oficio_religioso->AdvancedSearch->SearchOperator2 = @$filter["w_oficio_religioso"];
        $this->oficio_religioso->AdvancedSearch->save();

        // Field ofrenda_voz
        $this->ofrenda_voz->AdvancedSearch->SearchValue = @$filter["x_ofrenda_voz"];
        $this->ofrenda_voz->AdvancedSearch->SearchOperator = @$filter["z_ofrenda_voz"];
        $this->ofrenda_voz->AdvancedSearch->SearchCondition = @$filter["v_ofrenda_voz"];
        $this->ofrenda_voz->AdvancedSearch->SearchValue2 = @$filter["y_ofrenda_voz"];
        $this->ofrenda_voz->AdvancedSearch->SearchOperator2 = @$filter["w_ofrenda_voz"];
        $this->ofrenda_voz->AdvancedSearch->save();

        // Field fecha_inicio
        $this->fecha_inicio->AdvancedSearch->SearchValue = @$filter["x_fecha_inicio"];
        $this->fecha_inicio->AdvancedSearch->SearchOperator = @$filter["z_fecha_inicio"];
        $this->fecha_inicio->AdvancedSearch->SearchCondition = @$filter["v_fecha_inicio"];
        $this->fecha_inicio->AdvancedSearch->SearchValue2 = @$filter["y_fecha_inicio"];
        $this->fecha_inicio->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_inicio"];
        $this->fecha_inicio->AdvancedSearch->save();

        // Field hora_inicio
        $this->hora_inicio->AdvancedSearch->SearchValue = @$filter["x_hora_inicio"];
        $this->hora_inicio->AdvancedSearch->SearchOperator = @$filter["z_hora_inicio"];
        $this->hora_inicio->AdvancedSearch->SearchCondition = @$filter["v_hora_inicio"];
        $this->hora_inicio->AdvancedSearch->SearchValue2 = @$filter["y_hora_inicio"];
        $this->hora_inicio->AdvancedSearch->SearchOperator2 = @$filter["w_hora_inicio"];
        $this->hora_inicio->AdvancedSearch->save();

        // Field fecha_fin
        $this->fecha_fin->AdvancedSearch->SearchValue = @$filter["x_fecha_fin"];
        $this->fecha_fin->AdvancedSearch->SearchOperator = @$filter["z_fecha_fin"];
        $this->fecha_fin->AdvancedSearch->SearchCondition = @$filter["v_fecha_fin"];
        $this->fecha_fin->AdvancedSearch->SearchValue2 = @$filter["y_fecha_fin"];
        $this->fecha_fin->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_fin"];
        $this->fecha_fin->AdvancedSearch->save();

        // Field hora_fin
        $this->hora_fin->AdvancedSearch->SearchValue = @$filter["x_hora_fin"];
        $this->hora_fin->AdvancedSearch->SearchOperator = @$filter["z_hora_fin"];
        $this->hora_fin->AdvancedSearch->SearchCondition = @$filter["v_hora_fin"];
        $this->hora_fin->AdvancedSearch->SearchValue2 = @$filter["y_hora_fin"];
        $this->hora_fin->AdvancedSearch->SearchOperator2 = @$filter["w_hora_fin"];
        $this->hora_fin->AdvancedSearch->save();

        // Field servicio
        $this->servicio->AdvancedSearch->SearchValue = @$filter["x_servicio"];
        $this->servicio->AdvancedSearch->SearchOperator = @$filter["z_servicio"];
        $this->servicio->AdvancedSearch->SearchCondition = @$filter["v_servicio"];
        $this->servicio->AdvancedSearch->SearchValue2 = @$filter["y_servicio"];
        $this->servicio->AdvancedSearch->SearchOperator2 = @$filter["w_servicio"];
        $this->servicio->AdvancedSearch->save();

        // Field fecha_serv
        $this->fecha_serv->AdvancedSearch->SearchValue = @$filter["x_fecha_serv"];
        $this->fecha_serv->AdvancedSearch->SearchOperator = @$filter["z_fecha_serv"];
        $this->fecha_serv->AdvancedSearch->SearchCondition = @$filter["v_fecha_serv"];
        $this->fecha_serv->AdvancedSearch->SearchValue2 = @$filter["y_fecha_serv"];
        $this->fecha_serv->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_serv"];
        $this->fecha_serv->AdvancedSearch->save();

        // Field hora_serv
        $this->hora_serv->AdvancedSearch->SearchValue = @$filter["x_hora_serv"];
        $this->hora_serv->AdvancedSearch->SearchOperator = @$filter["z_hora_serv"];
        $this->hora_serv->AdvancedSearch->SearchCondition = @$filter["v_hora_serv"];
        $this->hora_serv->AdvancedSearch->SearchValue2 = @$filter["y_hora_serv"];
        $this->hora_serv->AdvancedSearch->SearchOperator2 = @$filter["w_hora_serv"];
        $this->hora_serv->AdvancedSearch->save();

        // Field espera_cenizas
        $this->espera_cenizas->AdvancedSearch->SearchValue = @$filter["x_espera_cenizas"];
        $this->espera_cenizas->AdvancedSearch->SearchOperator = @$filter["z_espera_cenizas"];
        $this->espera_cenizas->AdvancedSearch->SearchCondition = @$filter["v_espera_cenizas"];
        $this->espera_cenizas->AdvancedSearch->SearchValue2 = @$filter["y_espera_cenizas"];
        $this->espera_cenizas->AdvancedSearch->SearchOperator2 = @$filter["w_espera_cenizas"];
        $this->espera_cenizas->AdvancedSearch->save();

        // Field hora_fin_capilla
        $this->hora_fin_capilla->AdvancedSearch->SearchValue = @$filter["x_hora_fin_capilla"];
        $this->hora_fin_capilla->AdvancedSearch->SearchOperator = @$filter["z_hora_fin_capilla"];
        $this->hora_fin_capilla->AdvancedSearch->SearchCondition = @$filter["v_hora_fin_capilla"];
        $this->hora_fin_capilla->AdvancedSearch->SearchValue2 = @$filter["y_hora_fin_capilla"];
        $this->hora_fin_capilla->AdvancedSearch->SearchOperator2 = @$filter["w_hora_fin_capilla"];
        $this->hora_fin_capilla->AdvancedSearch->save();

        // Field hora_fin_servicio
        $this->hora_fin_servicio->AdvancedSearch->SearchValue = @$filter["x_hora_fin_servicio"];
        $this->hora_fin_servicio->AdvancedSearch->SearchOperator = @$filter["z_hora_fin_servicio"];
        $this->hora_fin_servicio->AdvancedSearch->SearchCondition = @$filter["v_hora_fin_servicio"];
        $this->hora_fin_servicio->AdvancedSearch->SearchValue2 = @$filter["y_hora_fin_servicio"];
        $this->hora_fin_servicio->AdvancedSearch->SearchOperator2 = @$filter["w_hora_fin_servicio"];
        $this->hora_fin_servicio->AdvancedSearch->save();

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

        // Field factura
        $this->factura->AdvancedSearch->SearchValue = @$filter["x_factura"];
        $this->factura->AdvancedSearch->SearchOperator = @$filter["z_factura"];
        $this->factura->AdvancedSearch->SearchCondition = @$filter["v_factura"];
        $this->factura->AdvancedSearch->SearchValue2 = @$filter["y_factura"];
        $this->factura->AdvancedSearch->SearchOperator2 = @$filter["w_factura"];
        $this->factura->AdvancedSearch->save();

        // Field venta
        $this->venta->AdvancedSearch->SearchValue = @$filter["x_venta"];
        $this->venta->AdvancedSearch->SearchOperator = @$filter["z_venta"];
        $this->venta->AdvancedSearch->SearchCondition = @$filter["v_venta"];
        $this->venta->AdvancedSearch->SearchValue2 = @$filter["y_venta"];
        $this->venta->AdvancedSearch->SearchOperator2 = @$filter["w_venta"];
        $this->venta->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field sede
        $this->sede->AdvancedSearch->SearchValue = @$filter["x_sede"];
        $this->sede->AdvancedSearch->SearchOperator = @$filter["z_sede"];
        $this->sede->AdvancedSearch->SearchCondition = @$filter["v_sede"];
        $this->sede->AdvancedSearch->SearchValue2 = @$filter["y_sede"];
        $this->sede->AdvancedSearch->SearchOperator2 = @$filter["w_sede"];
        $this->sede->AdvancedSearch->save();

        // Field funeraria
        $this->funeraria->AdvancedSearch->SearchValue = @$filter["x_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator = @$filter["z_funeraria"];
        $this->funeraria->AdvancedSearch->SearchCondition = @$filter["v_funeraria"];
        $this->funeraria->AdvancedSearch->SearchValue2 = @$filter["y_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator2 = @$filter["w_funeraria"];
        $this->funeraria->AdvancedSearch->save();

        // Field cod_servicio
        $this->cod_servicio->AdvancedSearch->SearchValue = @$filter["x_cod_servicio"];
        $this->cod_servicio->AdvancedSearch->SearchOperator = @$filter["z_cod_servicio"];
        $this->cod_servicio->AdvancedSearch->SearchCondition = @$filter["v_cod_servicio"];
        $this->cod_servicio->AdvancedSearch->SearchValue2 = @$filter["y_cod_servicio"];
        $this->cod_servicio->AdvancedSearch->SearchOperator2 = @$filter["w_cod_servicio"];
        $this->cod_servicio->AdvancedSearch->save();

        // Field coordinador
        $this->coordinador->AdvancedSearch->SearchValue = @$filter["x_coordinador"];
        $this->coordinador->AdvancedSearch->SearchOperator = @$filter["z_coordinador"];
        $this->coordinador->AdvancedSearch->SearchCondition = @$filter["v_coordinador"];
        $this->coordinador->AdvancedSearch->SearchValue2 = @$filter["y_coordinador"];
        $this->coordinador->AdvancedSearch->SearchOperator2 = @$filter["w_coordinador"];
        $this->coordinador->AdvancedSearch->save();

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

    // Advanced search WHERE clause based on QueryString
    public function advancedSearchWhere($default = false)
    {
        global $Security;
        $where = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $this->buildSearchSql($where, $this->Nexpediente, $default, false); // Nexpediente
        $this->buildSearchSql($where, $this->seguro, $default, false); // seguro
        $this->buildSearchSql($where, $this->nombre_contacto, $default, false); // nombre_contacto
        $this->buildSearchSql($where, $this->telefono_contacto1, $default, false); // telefono_contacto1
        $this->buildSearchSql($where, $this->telefono_contacto2, $default, false); // telefono_contacto2
        $this->buildSearchSql($where, $this->cedula_fallecido, $default, false); // cedula_fallecido
        $this->buildSearchSql($where, $this->nombre_fallecido, $default, false); // nombre_fallecido
        $this->buildSearchSql($where, $this->apellidos_fallecido, $default, false); // apellidos_fallecido
        $this->buildSearchSql($where, $this->fecha_nacimiento, $default, false); // fecha_nacimiento
        $this->buildSearchSql($where, $this->edad_fallecido, $default, false); // edad_fallecido
        $this->buildSearchSql($where, $this->sexo, $default, false); // sexo
        $this->buildSearchSql($where, $this->fecha_ocurrencia, $default, false); // fecha_ocurrencia
        $this->buildSearchSql($where, $this->causa_ocurrencia, $default, false); // causa_ocurrencia
        $this->buildSearchSql($where, $this->causa_otro, $default, false); // causa_otro
        $this->buildSearchSql($where, $this->permiso, $default, false); // permiso
        $this->buildSearchSql($where, $this->capilla, $default, false); // capilla
        $this->buildSearchSql($where, $this->horas, $default, false); // horas
        $this->buildSearchSql($where, $this->ataud, $default, false); // ataud
        $this->buildSearchSql($where, $this->arreglo_floral, $default, false); // arreglo_floral
        $this->buildSearchSql($where, $this->oficio_religioso, $default, false); // oficio_religioso
        $this->buildSearchSql($where, $this->ofrenda_voz, $default, false); // ofrenda_voz
        $this->buildSearchSql($where, $this->fecha_inicio, $default, false); // fecha_inicio
        $this->buildSearchSql($where, $this->hora_inicio, $default, false); // hora_inicio
        $this->buildSearchSql($where, $this->fecha_fin, $default, false); // fecha_fin
        $this->buildSearchSql($where, $this->hora_fin, $default, false); // hora_fin
        $this->buildSearchSql($where, $this->servicio, $default, false); // servicio
        $this->buildSearchSql($where, $this->fecha_serv, $default, false); // fecha_serv
        $this->buildSearchSql($where, $this->hora_serv, $default, false); // hora_serv
        $this->buildSearchSql($where, $this->espera_cenizas, $default, false); // espera_cenizas
        $this->buildSearchSql($where, $this->hora_fin_capilla, $default, false); // hora_fin_capilla
        $this->buildSearchSql($where, $this->hora_fin_servicio, $default, false); // hora_fin_servicio
        $this->buildSearchSql($where, $this->estatus, $default, false); // estatus
        $this->buildSearchSql($where, $this->fecha_registro, $default, false); // fecha_registro
        $this->buildSearchSql($where, $this->factura, $default, false); // factura
        $this->buildSearchSql($where, $this->venta, $default, false); // venta
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->sede, $default, false); // sede
        $this->buildSearchSql($where, $this->funeraria, $default, false); // funeraria
        $this->buildSearchSql($where, $this->cod_servicio, $default, false); // cod_servicio
        $this->buildSearchSql($where, $this->coordinador, $default, false); // coordinador
        $this->buildSearchSql($where, $this->parcela, $default, false); // parcela

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Nexpediente->AdvancedSearch->save(); // Nexpediente
            $this->seguro->AdvancedSearch->save(); // seguro
            $this->nombre_contacto->AdvancedSearch->save(); // nombre_contacto
            $this->telefono_contacto1->AdvancedSearch->save(); // telefono_contacto1
            $this->telefono_contacto2->AdvancedSearch->save(); // telefono_contacto2
            $this->cedula_fallecido->AdvancedSearch->save(); // cedula_fallecido
            $this->nombre_fallecido->AdvancedSearch->save(); // nombre_fallecido
            $this->apellidos_fallecido->AdvancedSearch->save(); // apellidos_fallecido
            $this->fecha_nacimiento->AdvancedSearch->save(); // fecha_nacimiento
            $this->edad_fallecido->AdvancedSearch->save(); // edad_fallecido
            $this->sexo->AdvancedSearch->save(); // sexo
            $this->fecha_ocurrencia->AdvancedSearch->save(); // fecha_ocurrencia
            $this->causa_ocurrencia->AdvancedSearch->save(); // causa_ocurrencia
            $this->causa_otro->AdvancedSearch->save(); // causa_otro
            $this->permiso->AdvancedSearch->save(); // permiso
            $this->capilla->AdvancedSearch->save(); // capilla
            $this->horas->AdvancedSearch->save(); // horas
            $this->ataud->AdvancedSearch->save(); // ataud
            $this->arreglo_floral->AdvancedSearch->save(); // arreglo_floral
            $this->oficio_religioso->AdvancedSearch->save(); // oficio_religioso
            $this->ofrenda_voz->AdvancedSearch->save(); // ofrenda_voz
            $this->fecha_inicio->AdvancedSearch->save(); // fecha_inicio
            $this->hora_inicio->AdvancedSearch->save(); // hora_inicio
            $this->fecha_fin->AdvancedSearch->save(); // fecha_fin
            $this->hora_fin->AdvancedSearch->save(); // hora_fin
            $this->servicio->AdvancedSearch->save(); // servicio
            $this->fecha_serv->AdvancedSearch->save(); // fecha_serv
            $this->hora_serv->AdvancedSearch->save(); // hora_serv
            $this->espera_cenizas->AdvancedSearch->save(); // espera_cenizas
            $this->hora_fin_capilla->AdvancedSearch->save(); // hora_fin_capilla
            $this->hora_fin_servicio->AdvancedSearch->save(); // hora_fin_servicio
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->factura->AdvancedSearch->save(); // factura
            $this->venta->AdvancedSearch->save(); // venta
            $this->_email->AdvancedSearch->save(); // email
            $this->sede->AdvancedSearch->save(); // sede
            $this->funeraria->AdvancedSearch->save(); // funeraria
            $this->cod_servicio->AdvancedSearch->save(); // cod_servicio
            $this->coordinador->AdvancedSearch->save(); // coordinador
            $this->parcela->AdvancedSearch->save(); // parcela

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
            $this->Nexpediente->AdvancedSearch->save(); // Nexpediente
            $this->seguro->AdvancedSearch->save(); // seguro
            $this->nombre_contacto->AdvancedSearch->save(); // nombre_contacto
            $this->telefono_contacto1->AdvancedSearch->save(); // telefono_contacto1
            $this->telefono_contacto2->AdvancedSearch->save(); // telefono_contacto2
            $this->cedula_fallecido->AdvancedSearch->save(); // cedula_fallecido
            $this->nombre_fallecido->AdvancedSearch->save(); // nombre_fallecido
            $this->apellidos_fallecido->AdvancedSearch->save(); // apellidos_fallecido
            $this->fecha_nacimiento->AdvancedSearch->save(); // fecha_nacimiento
            $this->edad_fallecido->AdvancedSearch->save(); // edad_fallecido
            $this->sexo->AdvancedSearch->save(); // sexo
            $this->fecha_ocurrencia->AdvancedSearch->save(); // fecha_ocurrencia
            $this->causa_ocurrencia->AdvancedSearch->save(); // causa_ocurrencia
            $this->causa_otro->AdvancedSearch->save(); // causa_otro
            $this->permiso->AdvancedSearch->save(); // permiso
            $this->capilla->AdvancedSearch->save(); // capilla
            $this->horas->AdvancedSearch->save(); // horas
            $this->ataud->AdvancedSearch->save(); // ataud
            $this->arreglo_floral->AdvancedSearch->save(); // arreglo_floral
            $this->oficio_religioso->AdvancedSearch->save(); // oficio_religioso
            $this->ofrenda_voz->AdvancedSearch->save(); // ofrenda_voz
            $this->fecha_inicio->AdvancedSearch->save(); // fecha_inicio
            $this->hora_inicio->AdvancedSearch->save(); // hora_inicio
            $this->fecha_fin->AdvancedSearch->save(); // fecha_fin
            $this->hora_fin->AdvancedSearch->save(); // hora_fin
            $this->servicio->AdvancedSearch->save(); // servicio
            $this->fecha_serv->AdvancedSearch->save(); // fecha_serv
            $this->hora_serv->AdvancedSearch->save(); // hora_serv
            $this->espera_cenizas->AdvancedSearch->save(); // espera_cenizas
            $this->hora_fin_capilla->AdvancedSearch->save(); // hora_fin_capilla
            $this->hora_fin_servicio->AdvancedSearch->save(); // hora_fin_servicio
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->factura->AdvancedSearch->save(); // factura
            $this->venta->AdvancedSearch->save(); // venta
            $this->_email->AdvancedSearch->save(); // email
            $this->sede->AdvancedSearch->save(); // sede
            $this->funeraria->AdvancedSearch->save(); // funeraria
            $this->cod_servicio->AdvancedSearch->save(); // cod_servicio
            $this->coordinador->AdvancedSearch->save(); // coordinador
            $this->parcela->AdvancedSearch->save(); // parcela
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

        // Field Nexpediente
        $filter = $this->queryBuilderWhere("Nexpediente");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->Nexpediente, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->Nexpediente->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field seguro
        $filter = $this->queryBuilderWhere("seguro");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->seguro, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->seguro->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nombre_contacto
        $filter = $this->queryBuilderWhere("nombre_contacto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nombre_contacto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nombre_contacto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field telefono_contacto1
        $filter = $this->queryBuilderWhere("telefono_contacto1");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->telefono_contacto1, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->telefono_contacto1->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field telefono_contacto2
        $filter = $this->queryBuilderWhere("telefono_contacto2");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->telefono_contacto2, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->telefono_contacto2->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cedula_fallecido
        $filter = $this->queryBuilderWhere("cedula_fallecido");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cedula_fallecido, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cedula_fallecido->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field nombre_fallecido
        $filter = $this->queryBuilderWhere("nombre_fallecido");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nombre_fallecido, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nombre_fallecido->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field apellidos_fallecido
        $filter = $this->queryBuilderWhere("apellidos_fallecido");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->apellidos_fallecido, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->apellidos_fallecido->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field edad_fallecido
        $filter = $this->queryBuilderWhere("edad_fallecido");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->edad_fallecido, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->edad_fallecido->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field sexo
        $filter = $this->queryBuilderWhere("sexo");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->sexo, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->sexo->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field causa_ocurrencia
        $filter = $this->queryBuilderWhere("causa_ocurrencia");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->causa_ocurrencia, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->causa_ocurrencia->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field capilla
        $filter = $this->queryBuilderWhere("capilla");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->capilla, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->capilla->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field horas
        $filter = $this->queryBuilderWhere("horas");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->horas, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->horas->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ataud
        $filter = $this->queryBuilderWhere("ataud");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ataud, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ataud->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field arreglo_floral
        $filter = $this->queryBuilderWhere("arreglo_floral");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->arreglo_floral, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->arreglo_floral->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field oficio_religioso
        $filter = $this->queryBuilderWhere("oficio_religioso");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->oficio_religioso, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->oficio_religioso->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field ofrenda_voz
        $filter = $this->queryBuilderWhere("ofrenda_voz");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->ofrenda_voz, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->ofrenda_voz->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field servicio
        $filter = $this->queryBuilderWhere("servicio");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->servicio, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->servicio->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field factura
        $filter = $this->queryBuilderWhere("factura");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->factura, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->factura->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field venta
        $filter = $this->queryBuilderWhere("venta");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->venta, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->venta->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field funeraria
        $filter = $this->queryBuilderWhere("funeraria");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->funeraria, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->funeraria->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field cod_servicio
        $filter = $this->queryBuilderWhere("cod_servicio");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->cod_servicio, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->cod_servicio->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field coordinador
        $filter = $this->queryBuilderWhere("coordinador");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->coordinador, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->coordinador->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field parcela
        $filter = $this->queryBuilderWhere("parcela");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->parcela, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->parcela->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->seguro;
        $searchFlds[] = &$this->nombre_contacto;
        $searchFlds[] = &$this->telefono_contacto1;
        $searchFlds[] = &$this->telefono_contacto2;
        $searchFlds[] = &$this->cedula_fallecido;
        $searchFlds[] = &$this->nombre_fallecido;
        $searchFlds[] = &$this->apellidos_fallecido;
        $searchFlds[] = &$this->sexo;
        $searchFlds[] = &$this->causa_ocurrencia;
        $searchFlds[] = &$this->causa_otro;
        $searchFlds[] = &$this->permiso;
        $searchFlds[] = &$this->capilla;
        $searchFlds[] = &$this->ataud;
        $searchFlds[] = &$this->arreglo_floral;
        $searchFlds[] = &$this->ofrenda_voz;
        $searchFlds[] = &$this->fecha_inicio;
        $searchFlds[] = &$this->fecha_fin;
        $searchFlds[] = &$this->servicio;
        $searchFlds[] = &$this->fecha_serv;
        $searchFlds[] = &$this->espera_cenizas;
        $searchFlds[] = &$this->factura;
        $searchFlds[] = &$this->_email;
        $searchFlds[] = &$this->sede;
        $searchFlds[] = &$this->cod_servicio;
        $searchFlds[] = &$this->coordinador;
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
        if ($this->Nexpediente->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->seguro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre_contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono_contacto1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono_contacto2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cedula_fallecido->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre_fallecido->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->apellidos_fallecido->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_nacimiento->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->edad_fallecido->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sexo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->causa_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->causa_otro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->permiso->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->capilla->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->horas->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ataud->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->arreglo_floral->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->oficio_religioso->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->ofrenda_voz->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_inicio->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_inicio->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_fin->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_fin->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->servicio->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_serv->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_serv->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->espera_cenizas->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_fin_capilla->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_fin_servicio->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estatus->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_registro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->factura->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->venta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->sede->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->funeraria->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cod_servicio->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->coordinador->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->parcela->AdvancedSearch->issetSession()) {
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
        $this->Nexpediente->AdvancedSearch->unsetSession();
        $this->seguro->AdvancedSearch->unsetSession();
        $this->nombre_contacto->AdvancedSearch->unsetSession();
        $this->telefono_contacto1->AdvancedSearch->unsetSession();
        $this->telefono_contacto2->AdvancedSearch->unsetSession();
        $this->cedula_fallecido->AdvancedSearch->unsetSession();
        $this->nombre_fallecido->AdvancedSearch->unsetSession();
        $this->apellidos_fallecido->AdvancedSearch->unsetSession();
        $this->fecha_nacimiento->AdvancedSearch->unsetSession();
        $this->edad_fallecido->AdvancedSearch->unsetSession();
        $this->sexo->AdvancedSearch->unsetSession();
        $this->fecha_ocurrencia->AdvancedSearch->unsetSession();
        $this->causa_ocurrencia->AdvancedSearch->unsetSession();
        $this->causa_otro->AdvancedSearch->unsetSession();
        $this->permiso->AdvancedSearch->unsetSession();
        $this->capilla->AdvancedSearch->unsetSession();
        $this->horas->AdvancedSearch->unsetSession();
        $this->ataud->AdvancedSearch->unsetSession();
        $this->arreglo_floral->AdvancedSearch->unsetSession();
        $this->oficio_religioso->AdvancedSearch->unsetSession();
        $this->ofrenda_voz->AdvancedSearch->unsetSession();
        $this->fecha_inicio->AdvancedSearch->unsetSession();
        $this->hora_inicio->AdvancedSearch->unsetSession();
        $this->fecha_fin->AdvancedSearch->unsetSession();
        $this->hora_fin->AdvancedSearch->unsetSession();
        $this->servicio->AdvancedSearch->unsetSession();
        $this->fecha_serv->AdvancedSearch->unsetSession();
        $this->hora_serv->AdvancedSearch->unsetSession();
        $this->espera_cenizas->AdvancedSearch->unsetSession();
        $this->hora_fin_capilla->AdvancedSearch->unsetSession();
        $this->hora_fin_servicio->AdvancedSearch->unsetSession();
        $this->estatus->AdvancedSearch->unsetSession();
        $this->fecha_registro->AdvancedSearch->unsetSession();
        $this->factura->AdvancedSearch->unsetSession();
        $this->venta->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->sede->AdvancedSearch->unsetSession();
        $this->funeraria->AdvancedSearch->unsetSession();
        $this->cod_servicio->AdvancedSearch->unsetSession();
        $this->coordinador->AdvancedSearch->unsetSession();
        $this->parcela->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Nexpediente->AdvancedSearch->load();
        $this->seguro->AdvancedSearch->load();
        $this->nombre_contacto->AdvancedSearch->load();
        $this->telefono_contacto1->AdvancedSearch->load();
        $this->telefono_contacto2->AdvancedSearch->load();
        $this->cedula_fallecido->AdvancedSearch->load();
        $this->nombre_fallecido->AdvancedSearch->load();
        $this->apellidos_fallecido->AdvancedSearch->load();
        $this->fecha_nacimiento->AdvancedSearch->load();
        $this->edad_fallecido->AdvancedSearch->load();
        $this->sexo->AdvancedSearch->load();
        $this->fecha_ocurrencia->AdvancedSearch->load();
        $this->causa_ocurrencia->AdvancedSearch->load();
        $this->causa_otro->AdvancedSearch->load();
        $this->permiso->AdvancedSearch->load();
        $this->capilla->AdvancedSearch->load();
        $this->horas->AdvancedSearch->load();
        $this->ataud->AdvancedSearch->load();
        $this->arreglo_floral->AdvancedSearch->load();
        $this->oficio_religioso->AdvancedSearch->load();
        $this->ofrenda_voz->AdvancedSearch->load();
        $this->fecha_inicio->AdvancedSearch->load();
        $this->hora_inicio->AdvancedSearch->load();
        $this->fecha_fin->AdvancedSearch->load();
        $this->hora_fin->AdvancedSearch->load();
        $this->servicio->AdvancedSearch->load();
        $this->fecha_serv->AdvancedSearch->load();
        $this->hora_serv->AdvancedSearch->load();
        $this->espera_cenizas->AdvancedSearch->load();
        $this->hora_fin_capilla->AdvancedSearch->load();
        $this->hora_fin_servicio->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->factura->AdvancedSearch->load();
        $this->venta->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->sede->AdvancedSearch->load();
        $this->funeraria->AdvancedSearch->load();
        $this->cod_servicio->AdvancedSearch->load();
        $this->coordinador->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = $this->fecha_registro->Expression . " DESC"; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->Nexpediente); // Nexpediente
            $this->updateSort($this->seguro); // seguro
            $this->updateSort($this->nombre_contacto); // nombre_contacto
            $this->updateSort($this->telefono_contacto1); // telefono_contacto1
            $this->updateSort($this->telefono_contacto2); // telefono_contacto2
            $this->updateSort($this->cedula_fallecido); // cedula_fallecido
            $this->updateSort($this->nombre_fallecido); // nombre_fallecido
            $this->updateSort($this->apellidos_fallecido); // apellidos_fallecido
            $this->updateSort($this->edad_fallecido); // edad_fallecido
            $this->updateSort($this->sexo); // sexo
            $this->updateSort($this->causa_ocurrencia); // causa_ocurrencia
            $this->updateSort($this->capilla); // capilla
            $this->updateSort($this->horas); // horas
            $this->updateSort($this->ataud); // ataud
            $this->updateSort($this->arreglo_floral); // arreglo_floral
            $this->updateSort($this->oficio_religioso); // oficio_religioso
            $this->updateSort($this->ofrenda_voz); // ofrenda_voz
            $this->updateSort($this->servicio); // servicio
            $this->updateSort($this->estatus); // estatus
            $this->updateSort($this->fecha_registro); // fecha_registro
            $this->updateSort($this->factura); // factura
            $this->updateSort($this->venta); // venta
            $this->updateSort($this->funeraria); // funeraria
            $this->updateSort($this->cod_servicio); // cod_servicio
            $this->updateSort($this->coordinador); // coordinador
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
                $this->seguro->setSort("");
                $this->nombre_contacto->setSort("");
                $this->telefono_contacto1->setSort("");
                $this->telefono_contacto2->setSort("");
                $this->cedula_fallecido->setSort("");
                $this->nombre_fallecido->setSort("");
                $this->apellidos_fallecido->setSort("");
                $this->fecha_nacimiento->setSort("");
                $this->edad_fallecido->setSort("");
                $this->sexo->setSort("");
                $this->fecha_ocurrencia->setSort("");
                $this->causa_ocurrencia->setSort("");
                $this->causa_otro->setSort("");
                $this->permiso->setSort("");
                $this->capilla->setSort("");
                $this->horas->setSort("");
                $this->ataud->setSort("");
                $this->arreglo_floral->setSort("");
                $this->oficio_religioso->setSort("");
                $this->ofrenda_voz->setSort("");
                $this->fecha_inicio->setSort("");
                $this->hora_inicio->setSort("");
                $this->fecha_fin->setSort("");
                $this->hora_fin->setSort("");
                $this->servicio->setSort("");
                $this->fecha_serv->setSort("");
                $this->hora_serv->setSort("");
                $this->espera_cenizas->setSort("");
                $this->hora_fin_capilla->setSort("");
                $this->hora_fin_servicio->setSort("");
                $this->estatus->setSort("");
                $this->fecha_registro->setSort("");
                $this->factura->setSort("");
                $this->venta->setSort("");
                $this->_email->setSort("");
                $this->sede->setSort("");
                $this->funeraria->setSort("");
                $this->cod_servicio->setSort("");
                $this->coordinador->setSort("");
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
        $this->ListOptions->UseDropDownButton = true;
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_expediente_serviciolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fview_expediente_serviciolist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $this->createColumnOption($option, "Nexpediente");
            $this->createColumnOption($option, "seguro");
            $this->createColumnOption($option, "nombre_contacto");
            $this->createColumnOption($option, "telefono_contacto1");
            $this->createColumnOption($option, "telefono_contacto2");
            $this->createColumnOption($option, "cedula_fallecido");
            $this->createColumnOption($option, "nombre_fallecido");
            $this->createColumnOption($option, "apellidos_fallecido");
            $this->createColumnOption($option, "edad_fallecido");
            $this->createColumnOption($option, "sexo");
            $this->createColumnOption($option, "causa_ocurrencia");
            $this->createColumnOption($option, "capilla");
            $this->createColumnOption($option, "horas");
            $this->createColumnOption($option, "ataud");
            $this->createColumnOption($option, "arreglo_floral");
            $this->createColumnOption($option, "oficio_religioso");
            $this->createColumnOption($option, "ofrenda_voz");
            $this->createColumnOption($option, "servicio");
            $this->createColumnOption($option, "estatus");
            $this->createColumnOption($option, "fecha_registro");
            $this->createColumnOption($option, "factura");
            $this->createColumnOption($option, "venta");
            $this->createColumnOption($option, "funeraria");
            $this->createColumnOption($option, "cod_servicio");
            $this->createColumnOption($option, "coordinador");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fview_expediente_serviciosrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fview_expediente_serviciosrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fview_expediente_serviciolist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_view_expediente_servicio", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_view_expediente_servicio",
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

        // Nexpediente
        if ($this->Nexpediente->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->Nexpediente->AdvancedSearch->SearchValue != "" || $this->Nexpediente->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // nombre_contacto
        if ($this->nombre_contacto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre_contacto->AdvancedSearch->SearchValue != "" || $this->nombre_contacto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telefono_contacto1
        if ($this->telefono_contacto1->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telefono_contacto1->AdvancedSearch->SearchValue != "" || $this->telefono_contacto1->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // telefono_contacto2
        if ($this->telefono_contacto2->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->telefono_contacto2->AdvancedSearch->SearchValue != "" || $this->telefono_contacto2->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cedula_fallecido
        if ($this->cedula_fallecido->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cedula_fallecido->AdvancedSearch->SearchValue != "" || $this->cedula_fallecido->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nombre_fallecido
        if ($this->nombre_fallecido->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nombre_fallecido->AdvancedSearch->SearchValue != "" || $this->nombre_fallecido->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // apellidos_fallecido
        if ($this->apellidos_fallecido->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->apellidos_fallecido->AdvancedSearch->SearchValue != "" || $this->apellidos_fallecido->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // edad_fallecido
        if ($this->edad_fallecido->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->edad_fallecido->AdvancedSearch->SearchValue != "" || $this->edad_fallecido->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // sexo
        if ($this->sexo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sexo->AdvancedSearch->SearchValue != "" || $this->sexo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_ocurrencia
        if ($this->fecha_ocurrencia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_ocurrencia->AdvancedSearch->SearchValue != "" || $this->fecha_ocurrencia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // causa_ocurrencia
        if ($this->causa_ocurrencia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->causa_ocurrencia->AdvancedSearch->SearchValue != "" || $this->causa_ocurrencia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // causa_otro
        if ($this->causa_otro->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->causa_otro->AdvancedSearch->SearchValue != "" || $this->causa_otro->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // permiso
        if ($this->permiso->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->permiso->AdvancedSearch->SearchValue != "" || $this->permiso->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // capilla
        if ($this->capilla->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->capilla->AdvancedSearch->SearchValue != "" || $this->capilla->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // horas
        if ($this->horas->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->horas->AdvancedSearch->SearchValue != "" || $this->horas->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ataud
        if ($this->ataud->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ataud->AdvancedSearch->SearchValue != "" || $this->ataud->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // arreglo_floral
        if ($this->arreglo_floral->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->arreglo_floral->AdvancedSearch->SearchValue != "" || $this->arreglo_floral->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // oficio_religioso
        if ($this->oficio_religioso->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->oficio_religioso->AdvancedSearch->SearchValue != "" || $this->oficio_religioso->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // ofrenda_voz
        if ($this->ofrenda_voz->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->ofrenda_voz->AdvancedSearch->SearchValue != "" || $this->ofrenda_voz->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_inicio
        if ($this->fecha_inicio->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_inicio->AdvancedSearch->SearchValue != "" || $this->fecha_inicio->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // hora_inicio
        if ($this->hora_inicio->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_inicio->AdvancedSearch->SearchValue != "" || $this->hora_inicio->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_fin
        if ($this->fecha_fin->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_fin->AdvancedSearch->SearchValue != "" || $this->fecha_fin->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // hora_fin
        if ($this->hora_fin->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_fin->AdvancedSearch->SearchValue != "" || $this->hora_fin->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // servicio
        if ($this->servicio->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->servicio->AdvancedSearch->SearchValue != "" || $this->servicio->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_serv
        if ($this->fecha_serv->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_serv->AdvancedSearch->SearchValue != "" || $this->fecha_serv->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // hora_serv
        if ($this->hora_serv->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_serv->AdvancedSearch->SearchValue != "" || $this->hora_serv->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // espera_cenizas
        if ($this->espera_cenizas->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->espera_cenizas->AdvancedSearch->SearchValue != "" || $this->espera_cenizas->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // hora_fin_capilla
        if ($this->hora_fin_capilla->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_fin_capilla->AdvancedSearch->SearchValue != "" || $this->hora_fin_capilla->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // hora_fin_servicio
        if ($this->hora_fin_servicio->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_fin_servicio->AdvancedSearch->SearchValue != "" || $this->hora_fin_servicio->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // factura
        if ($this->factura->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->factura->AdvancedSearch->SearchValue != "" || $this->factura->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // venta
        if ($this->venta->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->venta->AdvancedSearch->SearchValue != "" || $this->venta->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // sede
        if ($this->sede->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sede->AdvancedSearch->SearchValue != "" || $this->sede->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // cod_servicio
        if ($this->cod_servicio->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cod_servicio->AdvancedSearch->SearchValue != "" || $this->cod_servicio->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // coordinador
        if ($this->coordinador->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->coordinador->AdvancedSearch->SearchValue != "" || $this->coordinador->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->edad_fallecido->setDbValue($row['edad_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->fecha_ocurrencia->setDbValue($row['fecha_ocurrencia']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->causa_otro->setDbValue($row['causa_otro']);
        $this->permiso->setDbValue($row['permiso']);
        $this->capilla->setDbValue($row['capilla']);
        $this->horas->setDbValue($row['horas']);
        $this->ataud->setDbValue($row['ataud']);
        $this->arreglo_floral->setDbValue($row['arreglo_floral']);
        $this->oficio_religioso->setDbValue($row['oficio_religioso']);
        $this->ofrenda_voz->setDbValue($row['ofrenda_voz']);
        $this->fecha_inicio->setDbValue($row['fecha_inicio']);
        $this->hora_inicio->setDbValue($row['hora_inicio']);
        $this->fecha_fin->setDbValue($row['fecha_fin']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->servicio->setDbValue($row['servicio']);
        $this->fecha_serv->setDbValue($row['fecha_serv']);
        $this->hora_serv->setDbValue($row['hora_serv']);
        $this->espera_cenizas->setDbValue($row['espera_cenizas']);
        $this->hora_fin_capilla->setDbValue($row['hora_fin_capilla']);
        $this->hora_fin_servicio->setDbValue($row['hora_fin_servicio']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->factura->setDbValue($row['factura']);
        $this->venta->setDbValue($row['venta']);
        $this->_email->setDbValue($row['email']);
        $this->sede->setDbValue($row['sede']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->cod_servicio->setDbValue($row['cod_servicio']);
        $this->coordinador->setDbValue($row['coordinador']);
        $this->parcela->setDbValue($row['parcela']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente'] = $this->Nexpediente->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['edad_fallecido'] = $this->edad_fallecido->DefaultValue;
        $row['sexo'] = $this->sexo->DefaultValue;
        $row['fecha_ocurrencia'] = $this->fecha_ocurrencia->DefaultValue;
        $row['causa_ocurrencia'] = $this->causa_ocurrencia->DefaultValue;
        $row['causa_otro'] = $this->causa_otro->DefaultValue;
        $row['permiso'] = $this->permiso->DefaultValue;
        $row['capilla'] = $this->capilla->DefaultValue;
        $row['horas'] = $this->horas->DefaultValue;
        $row['ataud'] = $this->ataud->DefaultValue;
        $row['arreglo_floral'] = $this->arreglo_floral->DefaultValue;
        $row['oficio_religioso'] = $this->oficio_religioso->DefaultValue;
        $row['ofrenda_voz'] = $this->ofrenda_voz->DefaultValue;
        $row['fecha_inicio'] = $this->fecha_inicio->DefaultValue;
        $row['hora_inicio'] = $this->hora_inicio->DefaultValue;
        $row['fecha_fin'] = $this->fecha_fin->DefaultValue;
        $row['hora_fin'] = $this->hora_fin->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['fecha_serv'] = $this->fecha_serv->DefaultValue;
        $row['hora_serv'] = $this->hora_serv->DefaultValue;
        $row['espera_cenizas'] = $this->espera_cenizas->DefaultValue;
        $row['hora_fin_capilla'] = $this->hora_fin_capilla->DefaultValue;
        $row['hora_fin_servicio'] = $this->hora_fin_servicio->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['venta'] = $this->venta->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['sede'] = $this->sede->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['cod_servicio'] = $this->cod_servicio->DefaultValue;
        $row['coordinador'] = $this->coordinador->DefaultValue;
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

        // seguro

        // nombre_contacto

        // telefono_contacto1

        // telefono_contacto2

        // cedula_fallecido

        // nombre_fallecido

        // apellidos_fallecido

        // fecha_nacimiento

        // edad_fallecido

        // sexo

        // fecha_ocurrencia

        // causa_ocurrencia

        // causa_otro

        // permiso

        // capilla

        // horas

        // ataud

        // arreglo_floral

        // oficio_religioso

        // ofrenda_voz

        // fecha_inicio

        // hora_inicio

        // fecha_fin

        // hora_fin

        // servicio

        // fecha_serv

        // hora_serv

        // espera_cenizas

        // hora_fin_capilla

        // hora_fin_servicio

        // estatus

        // fecha_registro

        // factura

        // venta

        // email

        // sede

        // funeraria

        // cod_servicio

        // coordinador

        // parcela

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente
            $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

            // seguro
            $this->seguro->ViewValue = $this->seguro->CurrentValue;

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // telefono_contacto1
            $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

            // telefono_contacto2
            $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
            $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

            // edad_fallecido
            $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;

            // sexo
            $this->sexo->ViewValue = $this->sexo->CurrentValue;

            // fecha_ocurrencia
            $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
            $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

            // causa_ocurrencia
            $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

            // causa_otro
            $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

            // permiso
            $this->permiso->ViewValue = $this->permiso->CurrentValue;

            // capilla
            $this->capilla->ViewValue = $this->capilla->CurrentValue;

            // horas
            $this->horas->ViewValue = $this->horas->CurrentValue;

            // ataud
            $this->ataud->ViewValue = $this->ataud->CurrentValue;

            // arreglo_floral
            $this->arreglo_floral->ViewValue = $this->arreglo_floral->CurrentValue;
            $this->arreglo_floral->ViewValue = FormatNumber($this->arreglo_floral->ViewValue, $this->arreglo_floral->formatPattern());

            // oficio_religioso
            $this->oficio_religioso->ViewValue = $this->oficio_religioso->CurrentValue;
            $this->oficio_religioso->ViewValue = FormatNumber($this->oficio_religioso->ViewValue, $this->oficio_religioso->formatPattern());

            // ofrenda_voz
            $this->ofrenda_voz->ViewValue = $this->ofrenda_voz->CurrentValue;
            $this->ofrenda_voz->ViewValue = FormatNumber($this->ofrenda_voz->ViewValue, $this->ofrenda_voz->formatPattern());

            // fecha_inicio
            $this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;

            // hora_inicio
            $this->hora_inicio->ViewValue = $this->hora_inicio->CurrentValue;

            // fecha_fin
            $this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;

            // hora_fin
            $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;

            // servicio
            $this->servicio->ViewValue = $this->servicio->CurrentValue;

            // fecha_serv
            $this->fecha_serv->ViewValue = $this->fecha_serv->CurrentValue;

            // hora_serv
            $this->hora_serv->ViewValue = $this->hora_serv->CurrentValue;

            // espera_cenizas
            $this->espera_cenizas->ViewValue = $this->espera_cenizas->CurrentValue;

            // hora_fin_capilla
            $this->hora_fin_capilla->ViewValue = $this->hora_fin_capilla->CurrentValue;

            // hora_fin_servicio
            $this->hora_fin_servicio->ViewValue = $this->hora_fin_servicio->CurrentValue;

            // estatus
            $curVal = strval($this->estatus->CurrentValue);
            if ($curVal != "") {
                $this->estatus->ViewValue = $this->estatus->lookupCacheOption($curVal);
                if ($this->estatus->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["Nstatus"]->searchExpression(), "=", $curVal, $this->estatus->Lookup->getTable()->Fields["Nstatus"]->searchDataType(), "");
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

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // venta
            $this->venta->ViewValue = $this->venta->CurrentValue;
            $this->venta->ViewValue = FormatCurrency($this->venta->ViewValue, $this->venta->formatPattern());

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // funeraria
            $this->funeraria->ViewValue = $this->funeraria->CurrentValue;

            // cod_servicio
            $this->cod_servicio->ViewValue = $this->cod_servicio->CurrentValue;

            // coordinador
            $this->coordinador->ViewValue = $this->coordinador->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // Nexpediente
            if (!EmptyValue($this->Nexpediente->CurrentValue)) {
                $this->Nexpediente->HrefValue = $this->Nexpediente->getLinkPrefix() . (!empty($this->Nexpediente->ViewValue) && !is_array($this->Nexpediente->ViewValue) ? RemoveHtml($this->Nexpediente->ViewValue) : $this->Nexpediente->CurrentValue); // Add prefix/suffix
                $this->Nexpediente->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->Nexpediente->HrefValue = FullUrl($this->Nexpediente->HrefValue, "href");
                }
            } else {
                $this->Nexpediente->HrefValue = "";
            }
            $this->Nexpediente->TooltipValue = "";

            // seguro
            $this->seguro->HrefValue = "";
            $this->seguro->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";
            $this->nombre_contacto->TooltipValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";
            $this->telefono_contacto1->TooltipValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";
            $this->telefono_contacto2->TooltipValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";
            $this->cedula_fallecido->TooltipValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";
            $this->nombre_fallecido->TooltipValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";
            $this->apellidos_fallecido->TooltipValue = "";

            // edad_fallecido
            $this->edad_fallecido->HrefValue = "";
            $this->edad_fallecido->TooltipValue = "";

            // sexo
            $this->sexo->HrefValue = "";
            $this->sexo->TooltipValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";
            $this->causa_ocurrencia->TooltipValue = "";

            // capilla
            $this->capilla->HrefValue = "";
            $this->capilla->TooltipValue = "";

            // horas
            $this->horas->HrefValue = "";
            $this->horas->TooltipValue = "";

            // ataud
            $this->ataud->HrefValue = "";
            $this->ataud->TooltipValue = "";

            // arreglo_floral
            $this->arreglo_floral->HrefValue = "";
            $this->arreglo_floral->TooltipValue = "";

            // oficio_religioso
            $this->oficio_religioso->HrefValue = "";
            $this->oficio_religioso->TooltipValue = "";

            // ofrenda_voz
            $this->ofrenda_voz->HrefValue = "";
            $this->ofrenda_voz->TooltipValue = "";

            // servicio
            $this->servicio->HrefValue = "";
            $this->servicio->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // factura
            $this->factura->HrefValue = "";
            $this->factura->TooltipValue = "";

            // venta
            $this->venta->HrefValue = "";
            $this->venta->TooltipValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
            $this->funeraria->TooltipValue = "";

            // cod_servicio
            $this->cod_servicio->HrefValue = "";
            $this->cod_servicio->TooltipValue = "";

            // coordinador
            $this->coordinador->HrefValue = "";
            $this->coordinador->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // Nexpediente
            $this->Nexpediente->setupEditAttributes();
            $this->Nexpediente->EditValue = $this->Nexpediente->AdvancedSearch->SearchValue;
            $this->Nexpediente->PlaceHolder = RemoveHtml($this->Nexpediente->caption());

            // seguro
            $this->seguro->setupEditAttributes();
            if (!$this->seguro->Raw) {
                $this->seguro->AdvancedSearch->SearchValue = HtmlDecode($this->seguro->AdvancedSearch->SearchValue);
            }
            $this->seguro->EditValue = HtmlEncode($this->seguro->AdvancedSearch->SearchValue);
            $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());

            // nombre_contacto
            $this->nombre_contacto->setupEditAttributes();
            if (!$this->nombre_contacto->Raw) {
                $this->nombre_contacto->AdvancedSearch->SearchValue = HtmlDecode($this->nombre_contacto->AdvancedSearch->SearchValue);
            }
            $this->nombre_contacto->EditValue = HtmlEncode($this->nombre_contacto->AdvancedSearch->SearchValue);
            $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

            // telefono_contacto1
            $this->telefono_contacto1->setupEditAttributes();
            if (!$this->telefono_contacto1->Raw) {
                $this->telefono_contacto1->AdvancedSearch->SearchValue = HtmlDecode($this->telefono_contacto1->AdvancedSearch->SearchValue);
            }
            $this->telefono_contacto1->EditValue = HtmlEncode($this->telefono_contacto1->AdvancedSearch->SearchValue);
            $this->telefono_contacto1->PlaceHolder = RemoveHtml($this->telefono_contacto1->caption());

            // telefono_contacto2
            $this->telefono_contacto2->setupEditAttributes();
            if (!$this->telefono_contacto2->Raw) {
                $this->telefono_contacto2->AdvancedSearch->SearchValue = HtmlDecode($this->telefono_contacto2->AdvancedSearch->SearchValue);
            }
            $this->telefono_contacto2->EditValue = HtmlEncode($this->telefono_contacto2->AdvancedSearch->SearchValue);
            $this->telefono_contacto2->PlaceHolder = RemoveHtml($this->telefono_contacto2->caption());

            // cedula_fallecido
            $this->cedula_fallecido->setupEditAttributes();
            if (!$this->cedula_fallecido->Raw) {
                $this->cedula_fallecido->AdvancedSearch->SearchValue = HtmlDecode($this->cedula_fallecido->AdvancedSearch->SearchValue);
            }
            $this->cedula_fallecido->EditValue = HtmlEncode($this->cedula_fallecido->AdvancedSearch->SearchValue);
            $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

            // nombre_fallecido
            $this->nombre_fallecido->setupEditAttributes();
            if (!$this->nombre_fallecido->Raw) {
                $this->nombre_fallecido->AdvancedSearch->SearchValue = HtmlDecode($this->nombre_fallecido->AdvancedSearch->SearchValue);
            }
            $this->nombre_fallecido->EditValue = HtmlEncode($this->nombre_fallecido->AdvancedSearch->SearchValue);
            $this->nombre_fallecido->PlaceHolder = RemoveHtml($this->nombre_fallecido->caption());

            // apellidos_fallecido
            $this->apellidos_fallecido->setupEditAttributes();
            if (!$this->apellidos_fallecido->Raw) {
                $this->apellidos_fallecido->AdvancedSearch->SearchValue = HtmlDecode($this->apellidos_fallecido->AdvancedSearch->SearchValue);
            }
            $this->apellidos_fallecido->EditValue = HtmlEncode($this->apellidos_fallecido->AdvancedSearch->SearchValue);
            $this->apellidos_fallecido->PlaceHolder = RemoveHtml($this->apellidos_fallecido->caption());

            // edad_fallecido
            $this->edad_fallecido->setupEditAttributes();
            $this->edad_fallecido->EditValue = $this->edad_fallecido->AdvancedSearch->SearchValue;
            $this->edad_fallecido->PlaceHolder = RemoveHtml($this->edad_fallecido->caption());

            // sexo
            $this->sexo->setupEditAttributes();
            if (!$this->sexo->Raw) {
                $this->sexo->AdvancedSearch->SearchValue = HtmlDecode($this->sexo->AdvancedSearch->SearchValue);
            }
            $this->sexo->EditValue = HtmlEncode($this->sexo->AdvancedSearch->SearchValue);
            $this->sexo->PlaceHolder = RemoveHtml($this->sexo->caption());

            // causa_ocurrencia
            $this->causa_ocurrencia->setupEditAttributes();
            if (!$this->causa_ocurrencia->Raw) {
                $this->causa_ocurrencia->AdvancedSearch->SearchValue = HtmlDecode($this->causa_ocurrencia->AdvancedSearch->SearchValue);
            }
            $this->causa_ocurrencia->EditValue = HtmlEncode($this->causa_ocurrencia->AdvancedSearch->SearchValue);
            $this->causa_ocurrencia->PlaceHolder = RemoveHtml($this->causa_ocurrencia->caption());

            // capilla
            $this->capilla->setupEditAttributes();
            $curVal = trim(strval($this->capilla->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->capilla->AdvancedSearch->ViewValue = $this->capilla->lookupCacheOption($curVal);
            } else {
                $this->capilla->AdvancedSearch->ViewValue = $this->capilla->Lookup !== null && is_array($this->capilla->lookupOptions()) && count($this->capilla->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->capilla->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->capilla->EditValue = array_values($this->capilla->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->capilla->Lookup->getTable()->Fields["capilla"]->searchExpression(), "=", $this->capilla->AdvancedSearch->SearchValue, $this->capilla->Lookup->getTable()->Fields["capilla"]->searchDataType(), "");
                }
                $sqlWrk = $this->capilla->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->capilla->EditValue = $arwrk;
            }
            $this->capilla->PlaceHolder = RemoveHtml($this->capilla->caption());

            // horas
            $this->horas->setupEditAttributes();
            $curVal = trim(strval($this->horas->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->horas->AdvancedSearch->ViewValue = $this->horas->lookupCacheOption($curVal);
            } else {
                $this->horas->AdvancedSearch->ViewValue = $this->horas->Lookup !== null && is_array($this->horas->lookupOptions()) && count($this->horas->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->horas->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->horas->EditValue = array_values($this->horas->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->horas->Lookup->getTable()->Fields["horas"]->searchExpression(), "=", $this->horas->AdvancedSearch->SearchValue, $this->horas->Lookup->getTable()->Fields["horas"]->searchDataType(), "");
                }
                $sqlWrk = $this->horas->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->horas->EditValue = $arwrk;
            }
            $this->horas->PlaceHolder = RemoveHtml($this->horas->caption());

            // ataud
            $this->ataud->setupEditAttributes();
            if (!$this->ataud->Raw) {
                $this->ataud->AdvancedSearch->SearchValue = HtmlDecode($this->ataud->AdvancedSearch->SearchValue);
            }
            $this->ataud->EditValue = HtmlEncode($this->ataud->AdvancedSearch->SearchValue);
            $this->ataud->PlaceHolder = RemoveHtml($this->ataud->caption());

            // arreglo_floral
            $this->arreglo_floral->setupEditAttributes();
            $this->arreglo_floral->EditValue = $this->arreglo_floral->AdvancedSearch->SearchValue;
            $this->arreglo_floral->PlaceHolder = RemoveHtml($this->arreglo_floral->caption());

            // oficio_religioso
            $this->oficio_religioso->setupEditAttributes();
            $this->oficio_religioso->EditValue = $this->oficio_religioso->AdvancedSearch->SearchValue;
            $this->oficio_religioso->PlaceHolder = RemoveHtml($this->oficio_religioso->caption());

            // ofrenda_voz
            $this->ofrenda_voz->setupEditAttributes();
            $this->ofrenda_voz->EditValue = $this->ofrenda_voz->AdvancedSearch->SearchValue;
            $this->ofrenda_voz->PlaceHolder = RemoveHtml($this->ofrenda_voz->caption());

            // servicio
            $this->servicio->setupEditAttributes();
            $curVal = trim(strval($this->servicio->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->servicio->AdvancedSearch->ViewValue = $this->servicio->lookupCacheOption($curVal);
            } else {
                $this->servicio->AdvancedSearch->ViewValue = $this->servicio->Lookup !== null && is_array($this->servicio->lookupOptions()) && count($this->servicio->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->servicio->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->servicio->EditValue = array_values($this->servicio->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->servicio->Lookup->getTable()->Fields["servicio"]->searchExpression(), "=", $this->servicio->AdvancedSearch->SearchValue, $this->servicio->Lookup->getTable()->Fields["servicio"]->searchDataType(), "");
                }
                $sqlWrk = $this->servicio->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->servicio->EditValue = $arwrk;
            }
            $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

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
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["Nstatus"]->searchExpression(), "=", $this->estatus->AdvancedSearch->SearchValue, $this->estatus->Lookup->getTable()->Fields["Nstatus"]->searchDataType(), "");
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

            // factura
            $this->factura->setupEditAttributes();
            if (!$this->factura->Raw) {
                $this->factura->AdvancedSearch->SearchValue = HtmlDecode($this->factura->AdvancedSearch->SearchValue);
            }
            $this->factura->EditValue = HtmlEncode($this->factura->AdvancedSearch->SearchValue);
            $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

            // venta
            $this->venta->setupEditAttributes();
            $this->venta->EditValue = $this->venta->AdvancedSearch->SearchValue;
            $this->venta->PlaceHolder = RemoveHtml($this->venta->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            $this->funeraria->EditValue = $this->funeraria->AdvancedSearch->SearchValue;
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

            // cod_servicio
            $this->cod_servicio->setupEditAttributes();
            if (!$this->cod_servicio->Raw) {
                $this->cod_servicio->AdvancedSearch->SearchValue = HtmlDecode($this->cod_servicio->AdvancedSearch->SearchValue);
            }
            $this->cod_servicio->EditValue = HtmlEncode($this->cod_servicio->AdvancedSearch->SearchValue);
            $this->cod_servicio->PlaceHolder = RemoveHtml($this->cod_servicio->caption());

            // coordinador
            $this->coordinador->setupEditAttributes();
            if (!$this->coordinador->Raw) {
                $this->coordinador->AdvancedSearch->SearchValue = HtmlDecode($this->coordinador->AdvancedSearch->SearchValue);
            }
            $this->coordinador->EditValue = HtmlEncode($this->coordinador->AdvancedSearch->SearchValue);
            $this->coordinador->PlaceHolder = RemoveHtml($this->coordinador->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->AdvancedSearch->SearchValue = HtmlDecode($this->parcela->AdvancedSearch->SearchValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->AdvancedSearch->SearchValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());
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
        if (!CheckInteger($this->Nexpediente->AdvancedSearch->SearchValue)) {
            $this->Nexpediente->addErrorMessage($this->Nexpediente->getErrorMessage(false));
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
        $this->Nexpediente->AdvancedSearch->load();
        $this->seguro->AdvancedSearch->load();
        $this->nombre_contacto->AdvancedSearch->load();
        $this->telefono_contacto1->AdvancedSearch->load();
        $this->telefono_contacto2->AdvancedSearch->load();
        $this->cedula_fallecido->AdvancedSearch->load();
        $this->nombre_fallecido->AdvancedSearch->load();
        $this->apellidos_fallecido->AdvancedSearch->load();
        $this->fecha_nacimiento->AdvancedSearch->load();
        $this->edad_fallecido->AdvancedSearch->load();
        $this->sexo->AdvancedSearch->load();
        $this->fecha_ocurrencia->AdvancedSearch->load();
        $this->causa_ocurrencia->AdvancedSearch->load();
        $this->causa_otro->AdvancedSearch->load();
        $this->permiso->AdvancedSearch->load();
        $this->capilla->AdvancedSearch->load();
        $this->horas->AdvancedSearch->load();
        $this->ataud->AdvancedSearch->load();
        $this->arreglo_floral->AdvancedSearch->load();
        $this->oficio_religioso->AdvancedSearch->load();
        $this->ofrenda_voz->AdvancedSearch->load();
        $this->fecha_inicio->AdvancedSearch->load();
        $this->hora_inicio->AdvancedSearch->load();
        $this->fecha_fin->AdvancedSearch->load();
        $this->hora_fin->AdvancedSearch->load();
        $this->servicio->AdvancedSearch->load();
        $this->fecha_serv->AdvancedSearch->load();
        $this->hora_serv->AdvancedSearch->load();
        $this->espera_cenizas->AdvancedSearch->load();
        $this->hora_fin_capilla->AdvancedSearch->load();
        $this->hora_fin_servicio->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->factura->AdvancedSearch->load();
        $this->venta->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->sede->AdvancedSearch->load();
        $this->funeraria->AdvancedSearch->load();
        $this->cod_servicio->AdvancedSearch->load();
        $this->coordinador->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fview_expediente_serviciosrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_capilla":
                    break;
                case "x_horas":
                    break;
                case "x_servicio":
                    break;
                case "x_estatus":
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
    public function pageDataRendering(&$header) {
    	// Example:
    	//$header = "your header";
    	$this->estatus->Visible = false;
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
