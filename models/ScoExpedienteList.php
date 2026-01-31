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
class ScoExpedienteList extends ScoExpediente
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsco_expedientelist";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteList";

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
        $this->Nexpediente->setVisibility();
        $this->contrato_parcela->Visible = false;
        $this->tipo_contratacion->Visible = false;
        $this->seguro->Visible = false;
        $this->nacionalidad_contacto->Visible = false;
        $this->cedula_contacto->Visible = false;
        $this->nombre_contacto->setVisibility();
        $this->apellidos_contacto->Visible = false;
        $this->parentesco_contacto->Visible = false;
        $this->telefono_contacto1->Visible = false;
        $this->telefono_contacto2->Visible = false;
        $this->_email->Visible = false;
        $this->nacionalidad_fallecido->Visible = false;
        $this->cedula_fallecido->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->sexo->Visible = false;
        $this->fecha_nacimiento->Visible = false;
        $this->edad_fallecido->Visible = false;
        $this->estado_civil->Visible = false;
        $this->lugar_nacimiento_fallecido->Visible = false;
        $this->lugar_ocurrencia->Visible = false;
        $this->direccion_ocurrencia->Visible = false;
        $this->fecha_ocurrencia->Visible = false;
        $this->hora_ocurrencia->Visible = false;
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->Visible = false;
        $this->descripcion_ocurrencia->Visible = false;
        $this->religion->Visible = false;
        $this->permiso->Visible = false;
        $this->costos->Visible = false;
        $this->venta->setVisibility();
        $this->user_registra->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->user_cierra->Visible = false;
        $this->fecha_cierre->Visible = false;
        $this->calidad->Visible = false;
        $this->factura->Visible = false;
        $this->unir_con_expediente->Visible = false;
        $this->estatus->setVisibility();
        $this->nota->Visible = false;
        $this->funeraria->Visible = false;
        $this->servicio_tipo->Visible = false;
        $this->servicio->Visible = false;
        $this->marca_pasos->Visible = false;
        $this->peso->Visible = false;
        $this->autoriza_cremar->Visible = false;
        $this->certificado_defuncion->Visible = false;
        $this->parcela->Visible = false;
        $this->username_autoriza->Visible = false;
        $this->fecha_autoriza->Visible = false;
        $this->email_calidad->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'sco_expediente';
        $this->TableName = 'sco_expediente';

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

        // Table object (sco_expediente)
        if (!isset($GLOBALS["sco_expediente"]) || $GLOBALS["sco_expediente"]::class == PROJECT_NAMESPACE . "sco_expediente") {
            $GLOBALS["sco_expediente"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "ScoExpedienteAdd?" . Config("TABLE_SHOW_DETAIL") . "=";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiEditUrl = $pageUrl . "action=multiedit";
        $this->MultiDeleteUrl = "ScoExpedienteDelete";
        $this->MultiUpdateUrl = "ScoExpedienteUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente');
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
                    $result["view"] = SameString($pageName, "ScoExpedienteView"); // If View page, no primary button
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->Nexpediente->Visible = false;
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
        $this->setupLookupOptions($this->tipo_contratacion);
        $this->setupLookupOptions($this->seguro);
        $this->setupLookupOptions($this->nacionalidad_contacto);
        $this->setupLookupOptions($this->parentesco_contacto);
        $this->setupLookupOptions($this->nacionalidad_fallecido);
        $this->setupLookupOptions($this->sexo);
        $this->setupLookupOptions($this->estado_civil);
        $this->setupLookupOptions($this->lugar_ocurrencia);
        $this->setupLookupOptions($this->causa_ocurrencia);
        $this->setupLookupOptions($this->religion);
        $this->setupLookupOptions($this->user_registra);
        $this->setupLookupOptions($this->calidad);
        $this->setupLookupOptions($this->unir_con_expediente);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->funeraria);
        $this->setupLookupOptions($this->servicio_tipo);
        $this->setupLookupOptions($this->servicio);
        $this->setupLookupOptions($this->marca_pasos);
        $this->setupLookupOptions($this->peso);
        $this->setupLookupOptions($this->autoriza_cremar);
        $this->setupLookupOptions($this->username_autoriza);
        $this->setupLookupOptions($this->email_calidad);

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fsco_expedientegrid";
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
        $filterList = Concat($filterList, $this->Nexpediente->AdvancedSearch->toJson(), ","); // Field Nexpediente
        $filterList = Concat($filterList, $this->contrato_parcela->AdvancedSearch->toJson(), ","); // Field contrato_parcela
        $filterList = Concat($filterList, $this->tipo_contratacion->AdvancedSearch->toJson(), ","); // Field tipo_contratacion
        $filterList = Concat($filterList, $this->seguro->AdvancedSearch->toJson(), ","); // Field seguro
        $filterList = Concat($filterList, $this->nacionalidad_contacto->AdvancedSearch->toJson(), ","); // Field nacionalidad_contacto
        $filterList = Concat($filterList, $this->cedula_contacto->AdvancedSearch->toJson(), ","); // Field cedula_contacto
        $filterList = Concat($filterList, $this->nombre_contacto->AdvancedSearch->toJson(), ","); // Field nombre_contacto
        $filterList = Concat($filterList, $this->apellidos_contacto->AdvancedSearch->toJson(), ","); // Field apellidos_contacto
        $filterList = Concat($filterList, $this->parentesco_contacto->AdvancedSearch->toJson(), ","); // Field parentesco_contacto
        $filterList = Concat($filterList, $this->telefono_contacto1->AdvancedSearch->toJson(), ","); // Field telefono_contacto1
        $filterList = Concat($filterList, $this->telefono_contacto2->AdvancedSearch->toJson(), ","); // Field telefono_contacto2
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->nacionalidad_fallecido->AdvancedSearch->toJson(), ","); // Field nacionalidad_fallecido
        $filterList = Concat($filterList, $this->cedula_fallecido->AdvancedSearch->toJson(), ","); // Field cedula_fallecido
        $filterList = Concat($filterList, $this->nombre_fallecido->AdvancedSearch->toJson(), ","); // Field nombre_fallecido
        $filterList = Concat($filterList, $this->apellidos_fallecido->AdvancedSearch->toJson(), ","); // Field apellidos_fallecido
        $filterList = Concat($filterList, $this->sexo->AdvancedSearch->toJson(), ","); // Field sexo
        $filterList = Concat($filterList, $this->fecha_nacimiento->AdvancedSearch->toJson(), ","); // Field fecha_nacimiento
        $filterList = Concat($filterList, $this->edad_fallecido->AdvancedSearch->toJson(), ","); // Field edad_fallecido
        $filterList = Concat($filterList, $this->estado_civil->AdvancedSearch->toJson(), ","); // Field estado_civil
        $filterList = Concat($filterList, $this->lugar_nacimiento_fallecido->AdvancedSearch->toJson(), ","); // Field lugar_nacimiento_fallecido
        $filterList = Concat($filterList, $this->lugar_ocurrencia->AdvancedSearch->toJson(), ","); // Field lugar_ocurrencia
        $filterList = Concat($filterList, $this->direccion_ocurrencia->AdvancedSearch->toJson(), ","); // Field direccion_ocurrencia
        $filterList = Concat($filterList, $this->fecha_ocurrencia->AdvancedSearch->toJson(), ","); // Field fecha_ocurrencia
        $filterList = Concat($filterList, $this->hora_ocurrencia->AdvancedSearch->toJson(), ","); // Field hora_ocurrencia
        $filterList = Concat($filterList, $this->causa_ocurrencia->AdvancedSearch->toJson(), ","); // Field causa_ocurrencia
        $filterList = Concat($filterList, $this->causa_otro->AdvancedSearch->toJson(), ","); // Field causa_otro
        $filterList = Concat($filterList, $this->descripcion_ocurrencia->AdvancedSearch->toJson(), ","); // Field descripcion_ocurrencia
        $filterList = Concat($filterList, $this->religion->AdvancedSearch->toJson(), ","); // Field religion
        $filterList = Concat($filterList, $this->permiso->AdvancedSearch->toJson(), ","); // Field permiso
        $filterList = Concat($filterList, $this->costos->AdvancedSearch->toJson(), ","); // Field costos
        $filterList = Concat($filterList, $this->venta->AdvancedSearch->toJson(), ","); // Field venta
        $filterList = Concat($filterList, $this->user_registra->AdvancedSearch->toJson(), ","); // Field user_registra
        $filterList = Concat($filterList, $this->fecha_registro->AdvancedSearch->toJson(), ","); // Field fecha_registro
        $filterList = Concat($filterList, $this->user_cierra->AdvancedSearch->toJson(), ","); // Field user_cierra
        $filterList = Concat($filterList, $this->fecha_cierre->AdvancedSearch->toJson(), ","); // Field fecha_cierre
        $filterList = Concat($filterList, $this->calidad->AdvancedSearch->toJson(), ","); // Field calidad
        $filterList = Concat($filterList, $this->factura->AdvancedSearch->toJson(), ","); // Field factura
        $filterList = Concat($filterList, $this->unir_con_expediente->AdvancedSearch->toJson(), ","); // Field unir_con_expediente
        $filterList = Concat($filterList, $this->estatus->AdvancedSearch->toJson(), ","); // Field estatus
        $filterList = Concat($filterList, $this->nota->AdvancedSearch->toJson(), ","); // Field nota
        $filterList = Concat($filterList, $this->funeraria->AdvancedSearch->toJson(), ","); // Field funeraria
        $filterList = Concat($filterList, $this->servicio_tipo->AdvancedSearch->toJson(), ","); // Field servicio_tipo
        $filterList = Concat($filterList, $this->servicio->AdvancedSearch->toJson(), ","); // Field servicio
        $filterList = Concat($filterList, $this->marca_pasos->AdvancedSearch->toJson(), ","); // Field marca_pasos
        $filterList = Concat($filterList, $this->peso->AdvancedSearch->toJson(), ","); // Field peso
        $filterList = Concat($filterList, $this->autoriza_cremar->AdvancedSearch->toJson(), ","); // Field autoriza_cremar
        $filterList = Concat($filterList, $this->certificado_defuncion->AdvancedSearch->toJson(), ","); // Field certificado_defuncion
        $filterList = Concat($filterList, $this->parcela->AdvancedSearch->toJson(), ","); // Field parcela
        $filterList = Concat($filterList, $this->username_autoriza->AdvancedSearch->toJson(), ","); // Field username_autoriza
        $filterList = Concat($filterList, $this->fecha_autoriza->AdvancedSearch->toJson(), ","); // Field fecha_autoriza
        $filterList = Concat($filterList, $this->email_calidad->AdvancedSearch->toJson(), ","); // Field email_calidad
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
            Profile()->setSearchFilters("fsco_expedientesrch", $filters);
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

        // Field contrato_parcela
        $this->contrato_parcela->AdvancedSearch->SearchValue = @$filter["x_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchOperator = @$filter["z_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchCondition = @$filter["v_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchValue2 = @$filter["y_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->SearchOperator2 = @$filter["w_contrato_parcela"];
        $this->contrato_parcela->AdvancedSearch->save();

        // Field tipo_contratacion
        $this->tipo_contratacion->AdvancedSearch->SearchValue = @$filter["x_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchOperator = @$filter["z_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchCondition = @$filter["v_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchValue2 = @$filter["y_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->SearchOperator2 = @$filter["w_tipo_contratacion"];
        $this->tipo_contratacion->AdvancedSearch->save();

        // Field seguro
        $this->seguro->AdvancedSearch->SearchValue = @$filter["x_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator = @$filter["z_seguro"];
        $this->seguro->AdvancedSearch->SearchCondition = @$filter["v_seguro"];
        $this->seguro->AdvancedSearch->SearchValue2 = @$filter["y_seguro"];
        $this->seguro->AdvancedSearch->SearchOperator2 = @$filter["w_seguro"];
        $this->seguro->AdvancedSearch->save();

        // Field nacionalidad_contacto
        $this->nacionalidad_contacto->AdvancedSearch->SearchValue = @$filter["x_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchOperator = @$filter["z_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchCondition = @$filter["v_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchValue2 = @$filter["y_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_nacionalidad_contacto"];
        $this->nacionalidad_contacto->AdvancedSearch->save();

        // Field cedula_contacto
        $this->cedula_contacto->AdvancedSearch->SearchValue = @$filter["x_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchOperator = @$filter["z_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchCondition = @$filter["v_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchValue2 = @$filter["y_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_cedula_contacto"];
        $this->cedula_contacto->AdvancedSearch->save();

        // Field nombre_contacto
        $this->nombre_contacto->AdvancedSearch->SearchValue = @$filter["x_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchOperator = @$filter["z_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchCondition = @$filter["v_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchValue2 = @$filter["y_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_nombre_contacto"];
        $this->nombre_contacto->AdvancedSearch->save();

        // Field apellidos_contacto
        $this->apellidos_contacto->AdvancedSearch->SearchValue = @$filter["x_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchOperator = @$filter["z_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchCondition = @$filter["v_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchValue2 = @$filter["y_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_apellidos_contacto"];
        $this->apellidos_contacto->AdvancedSearch->save();

        // Field parentesco_contacto
        $this->parentesco_contacto->AdvancedSearch->SearchValue = @$filter["x_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchOperator = @$filter["z_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchCondition = @$filter["v_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchValue2 = @$filter["y_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->SearchOperator2 = @$filter["w_parentesco_contacto"];
        $this->parentesco_contacto->AdvancedSearch->save();

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

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field nacionalidad_fallecido
        $this->nacionalidad_fallecido->AdvancedSearch->SearchValue = @$filter["x_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchOperator = @$filter["z_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchCondition = @$filter["v_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_nacionalidad_fallecido"];
        $this->nacionalidad_fallecido->AdvancedSearch->save();

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

        // Field sexo
        $this->sexo->AdvancedSearch->SearchValue = @$filter["x_sexo"];
        $this->sexo->AdvancedSearch->SearchOperator = @$filter["z_sexo"];
        $this->sexo->AdvancedSearch->SearchCondition = @$filter["v_sexo"];
        $this->sexo->AdvancedSearch->SearchValue2 = @$filter["y_sexo"];
        $this->sexo->AdvancedSearch->SearchOperator2 = @$filter["w_sexo"];
        $this->sexo->AdvancedSearch->save();

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

        // Field estado_civil
        $this->estado_civil->AdvancedSearch->SearchValue = @$filter["x_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchOperator = @$filter["z_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchCondition = @$filter["v_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchValue2 = @$filter["y_estado_civil"];
        $this->estado_civil->AdvancedSearch->SearchOperator2 = @$filter["w_estado_civil"];
        $this->estado_civil->AdvancedSearch->save();

        // Field lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchValue = @$filter["x_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchOperator = @$filter["z_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchCondition = @$filter["v_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchValue2 = @$filter["y_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchOperator2 = @$filter["w_lugar_nacimiento_fallecido"];
        $this->lugar_nacimiento_fallecido->AdvancedSearch->save();

        // Field lugar_ocurrencia
        $this->lugar_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_lugar_ocurrencia"];
        $this->lugar_ocurrencia->AdvancedSearch->save();

        // Field direccion_ocurrencia
        $this->direccion_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_direccion_ocurrencia"];
        $this->direccion_ocurrencia->AdvancedSearch->save();

        // Field fecha_ocurrencia
        $this->fecha_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_ocurrencia"];
        $this->fecha_ocurrencia->AdvancedSearch->save();

        // Field hora_ocurrencia
        $this->hora_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_hora_ocurrencia"];
        $this->hora_ocurrencia->AdvancedSearch->save();

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

        // Field descripcion_ocurrencia
        $this->descripcion_ocurrencia->AdvancedSearch->SearchValue = @$filter["x_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchOperator = @$filter["z_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchCondition = @$filter["v_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchValue2 = @$filter["y_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->SearchOperator2 = @$filter["w_descripcion_ocurrencia"];
        $this->descripcion_ocurrencia->AdvancedSearch->save();

        // Field religion
        $this->religion->AdvancedSearch->SearchValue = @$filter["x_religion"];
        $this->religion->AdvancedSearch->SearchOperator = @$filter["z_religion"];
        $this->religion->AdvancedSearch->SearchCondition = @$filter["v_religion"];
        $this->religion->AdvancedSearch->SearchValue2 = @$filter["y_religion"];
        $this->religion->AdvancedSearch->SearchOperator2 = @$filter["w_religion"];
        $this->religion->AdvancedSearch->save();

        // Field permiso
        $this->permiso->AdvancedSearch->SearchValue = @$filter["x_permiso"];
        $this->permiso->AdvancedSearch->SearchOperator = @$filter["z_permiso"];
        $this->permiso->AdvancedSearch->SearchCondition = @$filter["v_permiso"];
        $this->permiso->AdvancedSearch->SearchValue2 = @$filter["y_permiso"];
        $this->permiso->AdvancedSearch->SearchOperator2 = @$filter["w_permiso"];
        $this->permiso->AdvancedSearch->save();

        // Field costos
        $this->costos->AdvancedSearch->SearchValue = @$filter["x_costos"];
        $this->costos->AdvancedSearch->SearchOperator = @$filter["z_costos"];
        $this->costos->AdvancedSearch->SearchCondition = @$filter["v_costos"];
        $this->costos->AdvancedSearch->SearchValue2 = @$filter["y_costos"];
        $this->costos->AdvancedSearch->SearchOperator2 = @$filter["w_costos"];
        $this->costos->AdvancedSearch->save();

        // Field venta
        $this->venta->AdvancedSearch->SearchValue = @$filter["x_venta"];
        $this->venta->AdvancedSearch->SearchOperator = @$filter["z_venta"];
        $this->venta->AdvancedSearch->SearchCondition = @$filter["v_venta"];
        $this->venta->AdvancedSearch->SearchValue2 = @$filter["y_venta"];
        $this->venta->AdvancedSearch->SearchOperator2 = @$filter["w_venta"];
        $this->venta->AdvancedSearch->save();

        // Field user_registra
        $this->user_registra->AdvancedSearch->SearchValue = @$filter["x_user_registra"];
        $this->user_registra->AdvancedSearch->SearchOperator = @$filter["z_user_registra"];
        $this->user_registra->AdvancedSearch->SearchCondition = @$filter["v_user_registra"];
        $this->user_registra->AdvancedSearch->SearchValue2 = @$filter["y_user_registra"];
        $this->user_registra->AdvancedSearch->SearchOperator2 = @$filter["w_user_registra"];
        $this->user_registra->AdvancedSearch->save();

        // Field fecha_registro
        $this->fecha_registro->AdvancedSearch->SearchValue = @$filter["x_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchOperator = @$filter["z_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchCondition = @$filter["v_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchValue2 = @$filter["y_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_registro"];
        $this->fecha_registro->AdvancedSearch->save();

        // Field user_cierra
        $this->user_cierra->AdvancedSearch->SearchValue = @$filter["x_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchOperator = @$filter["z_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchCondition = @$filter["v_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchValue2 = @$filter["y_user_cierra"];
        $this->user_cierra->AdvancedSearch->SearchOperator2 = @$filter["w_user_cierra"];
        $this->user_cierra->AdvancedSearch->save();

        // Field fecha_cierre
        $this->fecha_cierre->AdvancedSearch->SearchValue = @$filter["x_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchOperator = @$filter["z_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchCondition = @$filter["v_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchValue2 = @$filter["y_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_cierre"];
        $this->fecha_cierre->AdvancedSearch->save();

        // Field calidad
        $this->calidad->AdvancedSearch->SearchValue = @$filter["x_calidad"];
        $this->calidad->AdvancedSearch->SearchOperator = @$filter["z_calidad"];
        $this->calidad->AdvancedSearch->SearchCondition = @$filter["v_calidad"];
        $this->calidad->AdvancedSearch->SearchValue2 = @$filter["y_calidad"];
        $this->calidad->AdvancedSearch->SearchOperator2 = @$filter["w_calidad"];
        $this->calidad->AdvancedSearch->save();

        // Field factura
        $this->factura->AdvancedSearch->SearchValue = @$filter["x_factura"];
        $this->factura->AdvancedSearch->SearchOperator = @$filter["z_factura"];
        $this->factura->AdvancedSearch->SearchCondition = @$filter["v_factura"];
        $this->factura->AdvancedSearch->SearchValue2 = @$filter["y_factura"];
        $this->factura->AdvancedSearch->SearchOperator2 = @$filter["w_factura"];
        $this->factura->AdvancedSearch->save();

        // Field unir_con_expediente
        $this->unir_con_expediente->AdvancedSearch->SearchValue = @$filter["x_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchOperator = @$filter["z_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchCondition = @$filter["v_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchValue2 = @$filter["y_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->SearchOperator2 = @$filter["w_unir_con_expediente"];
        $this->unir_con_expediente->AdvancedSearch->save();

        // Field estatus
        $this->estatus->AdvancedSearch->SearchValue = @$filter["x_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator = @$filter["z_estatus"];
        $this->estatus->AdvancedSearch->SearchCondition = @$filter["v_estatus"];
        $this->estatus->AdvancedSearch->SearchValue2 = @$filter["y_estatus"];
        $this->estatus->AdvancedSearch->SearchOperator2 = @$filter["w_estatus"];
        $this->estatus->AdvancedSearch->save();

        // Field nota
        $this->nota->AdvancedSearch->SearchValue = @$filter["x_nota"];
        $this->nota->AdvancedSearch->SearchOperator = @$filter["z_nota"];
        $this->nota->AdvancedSearch->SearchCondition = @$filter["v_nota"];
        $this->nota->AdvancedSearch->SearchValue2 = @$filter["y_nota"];
        $this->nota->AdvancedSearch->SearchOperator2 = @$filter["w_nota"];
        $this->nota->AdvancedSearch->save();

        // Field funeraria
        $this->funeraria->AdvancedSearch->SearchValue = @$filter["x_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator = @$filter["z_funeraria"];
        $this->funeraria->AdvancedSearch->SearchCondition = @$filter["v_funeraria"];
        $this->funeraria->AdvancedSearch->SearchValue2 = @$filter["y_funeraria"];
        $this->funeraria->AdvancedSearch->SearchOperator2 = @$filter["w_funeraria"];
        $this->funeraria->AdvancedSearch->save();

        // Field servicio_tipo
        $this->servicio_tipo->AdvancedSearch->SearchValue = @$filter["x_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchOperator = @$filter["z_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchCondition = @$filter["v_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchValue2 = @$filter["y_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->SearchOperator2 = @$filter["w_servicio_tipo"];
        $this->servicio_tipo->AdvancedSearch->save();

        // Field servicio
        $this->servicio->AdvancedSearch->SearchValue = @$filter["x_servicio"];
        $this->servicio->AdvancedSearch->SearchOperator = @$filter["z_servicio"];
        $this->servicio->AdvancedSearch->SearchCondition = @$filter["v_servicio"];
        $this->servicio->AdvancedSearch->SearchValue2 = @$filter["y_servicio"];
        $this->servicio->AdvancedSearch->SearchOperator2 = @$filter["w_servicio"];
        $this->servicio->AdvancedSearch->save();

        // Field marca_pasos
        $this->marca_pasos->AdvancedSearch->SearchValue = @$filter["x_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchOperator = @$filter["z_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchCondition = @$filter["v_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchValue2 = @$filter["y_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->SearchOperator2 = @$filter["w_marca_pasos"];
        $this->marca_pasos->AdvancedSearch->save();

        // Field peso
        $this->peso->AdvancedSearch->SearchValue = @$filter["x_peso"];
        $this->peso->AdvancedSearch->SearchOperator = @$filter["z_peso"];
        $this->peso->AdvancedSearch->SearchCondition = @$filter["v_peso"];
        $this->peso->AdvancedSearch->SearchValue2 = @$filter["y_peso"];
        $this->peso->AdvancedSearch->SearchOperator2 = @$filter["w_peso"];
        $this->peso->AdvancedSearch->save();

        // Field autoriza_cremar
        $this->autoriza_cremar->AdvancedSearch->SearchValue = @$filter["x_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchOperator = @$filter["z_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchCondition = @$filter["v_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchValue2 = @$filter["y_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->SearchOperator2 = @$filter["w_autoriza_cremar"];
        $this->autoriza_cremar->AdvancedSearch->save();

        // Field certificado_defuncion
        $this->certificado_defuncion->AdvancedSearch->SearchValue = @$filter["x_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchOperator = @$filter["z_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchCondition = @$filter["v_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchValue2 = @$filter["y_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->SearchOperator2 = @$filter["w_certificado_defuncion"];
        $this->certificado_defuncion->AdvancedSearch->save();

        // Field parcela
        $this->parcela->AdvancedSearch->SearchValue = @$filter["x_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator = @$filter["z_parcela"];
        $this->parcela->AdvancedSearch->SearchCondition = @$filter["v_parcela"];
        $this->parcela->AdvancedSearch->SearchValue2 = @$filter["y_parcela"];
        $this->parcela->AdvancedSearch->SearchOperator2 = @$filter["w_parcela"];
        $this->parcela->AdvancedSearch->save();

        // Field username_autoriza
        $this->username_autoriza->AdvancedSearch->SearchValue = @$filter["x_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchOperator = @$filter["z_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchCondition = @$filter["v_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchValue2 = @$filter["y_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->SearchOperator2 = @$filter["w_username_autoriza"];
        $this->username_autoriza->AdvancedSearch->save();

        // Field fecha_autoriza
        $this->fecha_autoriza->AdvancedSearch->SearchValue = @$filter["x_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchOperator = @$filter["z_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchCondition = @$filter["v_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchValue2 = @$filter["y_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->SearchOperator2 = @$filter["w_fecha_autoriza"];
        $this->fecha_autoriza->AdvancedSearch->save();

        // Field email_calidad
        $this->email_calidad->AdvancedSearch->SearchValue = @$filter["x_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchOperator = @$filter["z_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchCondition = @$filter["v_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchValue2 = @$filter["y_email_calidad"];
        $this->email_calidad->AdvancedSearch->SearchOperator2 = @$filter["w_email_calidad"];
        $this->email_calidad->AdvancedSearch->save();
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
        $this->buildSearchSql($where, $this->contrato_parcela, $default, false); // contrato_parcela
        $this->buildSearchSql($where, $this->tipo_contratacion, $default, false); // tipo_contratacion
        $this->buildSearchSql($where, $this->seguro, $default, false); // seguro
        $this->buildSearchSql($where, $this->nacionalidad_contacto, $default, false); // nacionalidad_contacto
        $this->buildSearchSql($where, $this->cedula_contacto, $default, false); // cedula_contacto
        $this->buildSearchSql($where, $this->nombre_contacto, $default, false); // nombre_contacto
        $this->buildSearchSql($where, $this->apellidos_contacto, $default, false); // apellidos_contacto
        $this->buildSearchSql($where, $this->parentesco_contacto, $default, false); // parentesco_contacto
        $this->buildSearchSql($where, $this->telefono_contacto1, $default, false); // telefono_contacto1
        $this->buildSearchSql($where, $this->telefono_contacto2, $default, false); // telefono_contacto2
        $this->buildSearchSql($where, $this->_email, $default, false); // email
        $this->buildSearchSql($where, $this->nacionalidad_fallecido, $default, false); // nacionalidad_fallecido
        $this->buildSearchSql($where, $this->cedula_fallecido, $default, false); // cedula_fallecido
        $this->buildSearchSql($where, $this->nombre_fallecido, $default, false); // nombre_fallecido
        $this->buildSearchSql($where, $this->apellidos_fallecido, $default, false); // apellidos_fallecido
        $this->buildSearchSql($where, $this->sexo, $default, false); // sexo
        $this->buildSearchSql($where, $this->fecha_nacimiento, $default, false); // fecha_nacimiento
        $this->buildSearchSql($where, $this->edad_fallecido, $default, false); // edad_fallecido
        $this->buildSearchSql($where, $this->estado_civil, $default, false); // estado_civil
        $this->buildSearchSql($where, $this->lugar_nacimiento_fallecido, $default, false); // lugar_nacimiento_fallecido
        $this->buildSearchSql($where, $this->lugar_ocurrencia, $default, false); // lugar_ocurrencia
        $this->buildSearchSql($where, $this->direccion_ocurrencia, $default, false); // direccion_ocurrencia
        $this->buildSearchSql($where, $this->fecha_ocurrencia, $default, false); // fecha_ocurrencia
        $this->buildSearchSql($where, $this->hora_ocurrencia, $default, false); // hora_ocurrencia
        $this->buildSearchSql($where, $this->causa_ocurrencia, $default, false); // causa_ocurrencia
        $this->buildSearchSql($where, $this->causa_otro, $default, false); // causa_otro
        $this->buildSearchSql($where, $this->descripcion_ocurrencia, $default, false); // descripcion_ocurrencia
        $this->buildSearchSql($where, $this->religion, $default, false); // religion
        $this->buildSearchSql($where, $this->permiso, $default, false); // permiso
        $this->buildSearchSql($where, $this->costos, $default, false); // costos
        $this->buildSearchSql($where, $this->venta, $default, false); // venta
        $this->buildSearchSql($where, $this->user_registra, $default, false); // user_registra
        $this->buildSearchSql($where, $this->fecha_registro, $default, false); // fecha_registro
        $this->buildSearchSql($where, $this->user_cierra, $default, false); // user_cierra
        $this->buildSearchSql($where, $this->fecha_cierre, $default, false); // fecha_cierre
        $this->buildSearchSql($where, $this->calidad, $default, false); // calidad
        $this->buildSearchSql($where, $this->factura, $default, false); // factura
        $this->buildSearchSql($where, $this->unir_con_expediente, $default, false); // unir_con_expediente
        $this->buildSearchSql($where, $this->estatus, $default, false); // estatus
        $this->buildSearchSql($where, $this->nota, $default, false); // nota
        $this->buildSearchSql($where, $this->funeraria, $default, false); // funeraria
        $this->buildSearchSql($where, $this->servicio_tipo, $default, false); // servicio_tipo
        $this->buildSearchSql($where, $this->servicio, $default, false); // servicio
        $this->buildSearchSql($where, $this->marca_pasos, $default, false); // marca_pasos
        $this->buildSearchSql($where, $this->peso, $default, false); // peso
        $this->buildSearchSql($where, $this->autoriza_cremar, $default, false); // autoriza_cremar
        $this->buildSearchSql($where, $this->certificado_defuncion, $default, false); // certificado_defuncion
        $this->buildSearchSql($where, $this->parcela, $default, false); // parcela
        $this->buildSearchSql($where, $this->username_autoriza, $default, false); // username_autoriza
        $this->buildSearchSql($where, $this->fecha_autoriza, $default, false); // fecha_autoriza
        $this->buildSearchSql($where, $this->email_calidad, $default, false); // email_calidad

        // Set up search command
        if (!$default && $where != "" && in_array($this->Command, ["", "reset", "resetall"])) {
            $this->Command = "search";
        }
        if (!$default && $this->Command == "search") {
            $this->Nexpediente->AdvancedSearch->save(); // Nexpediente
            $this->contrato_parcela->AdvancedSearch->save(); // contrato_parcela
            $this->tipo_contratacion->AdvancedSearch->save(); // tipo_contratacion
            $this->seguro->AdvancedSearch->save(); // seguro
            $this->nacionalidad_contacto->AdvancedSearch->save(); // nacionalidad_contacto
            $this->cedula_contacto->AdvancedSearch->save(); // cedula_contacto
            $this->nombre_contacto->AdvancedSearch->save(); // nombre_contacto
            $this->apellidos_contacto->AdvancedSearch->save(); // apellidos_contacto
            $this->parentesco_contacto->AdvancedSearch->save(); // parentesco_contacto
            $this->telefono_contacto1->AdvancedSearch->save(); // telefono_contacto1
            $this->telefono_contacto2->AdvancedSearch->save(); // telefono_contacto2
            $this->_email->AdvancedSearch->save(); // email
            $this->nacionalidad_fallecido->AdvancedSearch->save(); // nacionalidad_fallecido
            $this->cedula_fallecido->AdvancedSearch->save(); // cedula_fallecido
            $this->nombre_fallecido->AdvancedSearch->save(); // nombre_fallecido
            $this->apellidos_fallecido->AdvancedSearch->save(); // apellidos_fallecido
            $this->sexo->AdvancedSearch->save(); // sexo
            $this->fecha_nacimiento->AdvancedSearch->save(); // fecha_nacimiento
            $this->edad_fallecido->AdvancedSearch->save(); // edad_fallecido
            $this->estado_civil->AdvancedSearch->save(); // estado_civil
            $this->lugar_nacimiento_fallecido->AdvancedSearch->save(); // lugar_nacimiento_fallecido
            $this->lugar_ocurrencia->AdvancedSearch->save(); // lugar_ocurrencia
            $this->direccion_ocurrencia->AdvancedSearch->save(); // direccion_ocurrencia
            $this->fecha_ocurrencia->AdvancedSearch->save(); // fecha_ocurrencia
            $this->hora_ocurrencia->AdvancedSearch->save(); // hora_ocurrencia
            $this->causa_ocurrencia->AdvancedSearch->save(); // causa_ocurrencia
            $this->causa_otro->AdvancedSearch->save(); // causa_otro
            $this->descripcion_ocurrencia->AdvancedSearch->save(); // descripcion_ocurrencia
            $this->religion->AdvancedSearch->save(); // religion
            $this->permiso->AdvancedSearch->save(); // permiso
            $this->costos->AdvancedSearch->save(); // costos
            $this->venta->AdvancedSearch->save(); // venta
            $this->user_registra->AdvancedSearch->save(); // user_registra
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->user_cierra->AdvancedSearch->save(); // user_cierra
            $this->fecha_cierre->AdvancedSearch->save(); // fecha_cierre
            $this->calidad->AdvancedSearch->save(); // calidad
            $this->factura->AdvancedSearch->save(); // factura
            $this->unir_con_expediente->AdvancedSearch->save(); // unir_con_expediente
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->nota->AdvancedSearch->save(); // nota
            $this->funeraria->AdvancedSearch->save(); // funeraria
            $this->servicio_tipo->AdvancedSearch->save(); // servicio_tipo
            $this->servicio->AdvancedSearch->save(); // servicio
            $this->marca_pasos->AdvancedSearch->save(); // marca_pasos
            $this->peso->AdvancedSearch->save(); // peso
            $this->autoriza_cremar->AdvancedSearch->save(); // autoriza_cremar
            $this->certificado_defuncion->AdvancedSearch->save(); // certificado_defuncion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->username_autoriza->AdvancedSearch->save(); // username_autoriza
            $this->fecha_autoriza->AdvancedSearch->save(); // fecha_autoriza
            $this->email_calidad->AdvancedSearch->save(); // email_calidad

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
            $this->contrato_parcela->AdvancedSearch->save(); // contrato_parcela
            $this->tipo_contratacion->AdvancedSearch->save(); // tipo_contratacion
            $this->seguro->AdvancedSearch->save(); // seguro
            $this->nacionalidad_contacto->AdvancedSearch->save(); // nacionalidad_contacto
            $this->cedula_contacto->AdvancedSearch->save(); // cedula_contacto
            $this->nombre_contacto->AdvancedSearch->save(); // nombre_contacto
            $this->apellidos_contacto->AdvancedSearch->save(); // apellidos_contacto
            $this->parentesco_contacto->AdvancedSearch->save(); // parentesco_contacto
            $this->telefono_contacto1->AdvancedSearch->save(); // telefono_contacto1
            $this->telefono_contacto2->AdvancedSearch->save(); // telefono_contacto2
            $this->_email->AdvancedSearch->save(); // email
            $this->nacionalidad_fallecido->AdvancedSearch->save(); // nacionalidad_fallecido
            $this->cedula_fallecido->AdvancedSearch->save(); // cedula_fallecido
            $this->nombre_fallecido->AdvancedSearch->save(); // nombre_fallecido
            $this->apellidos_fallecido->AdvancedSearch->save(); // apellidos_fallecido
            $this->sexo->AdvancedSearch->save(); // sexo
            $this->fecha_nacimiento->AdvancedSearch->save(); // fecha_nacimiento
            $this->edad_fallecido->AdvancedSearch->save(); // edad_fallecido
            $this->estado_civil->AdvancedSearch->save(); // estado_civil
            $this->lugar_nacimiento_fallecido->AdvancedSearch->save(); // lugar_nacimiento_fallecido
            $this->lugar_ocurrencia->AdvancedSearch->save(); // lugar_ocurrencia
            $this->direccion_ocurrencia->AdvancedSearch->save(); // direccion_ocurrencia
            $this->fecha_ocurrencia->AdvancedSearch->save(); // fecha_ocurrencia
            $this->hora_ocurrencia->AdvancedSearch->save(); // hora_ocurrencia
            $this->causa_ocurrencia->AdvancedSearch->save(); // causa_ocurrencia
            $this->causa_otro->AdvancedSearch->save(); // causa_otro
            $this->descripcion_ocurrencia->AdvancedSearch->save(); // descripcion_ocurrencia
            $this->religion->AdvancedSearch->save(); // religion
            $this->permiso->AdvancedSearch->save(); // permiso
            $this->costos->AdvancedSearch->save(); // costos
            $this->venta->AdvancedSearch->save(); // venta
            $this->user_registra->AdvancedSearch->save(); // user_registra
            $this->fecha_registro->AdvancedSearch->save(); // fecha_registro
            $this->user_cierra->AdvancedSearch->save(); // user_cierra
            $this->fecha_cierre->AdvancedSearch->save(); // fecha_cierre
            $this->calidad->AdvancedSearch->save(); // calidad
            $this->factura->AdvancedSearch->save(); // factura
            $this->unir_con_expediente->AdvancedSearch->save(); // unir_con_expediente
            $this->estatus->AdvancedSearch->save(); // estatus
            $this->nota->AdvancedSearch->save(); // nota
            $this->funeraria->AdvancedSearch->save(); // funeraria
            $this->servicio_tipo->AdvancedSearch->save(); // servicio_tipo
            $this->servicio->AdvancedSearch->save(); // servicio
            $this->marca_pasos->AdvancedSearch->save(); // marca_pasos
            $this->peso->AdvancedSearch->save(); // peso
            $this->autoriza_cremar->AdvancedSearch->save(); // autoriza_cremar
            $this->certificado_defuncion->AdvancedSearch->save(); // certificado_defuncion
            $this->parcela->AdvancedSearch->save(); // parcela
            $this->username_autoriza->AdvancedSearch->save(); // username_autoriza
            $this->fecha_autoriza->AdvancedSearch->save(); // fecha_autoriza
            $this->email_calidad->AdvancedSearch->save(); // email_calidad
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

        // Field nombre_contacto
        $filter = $this->queryBuilderWhere("nombre_contacto");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->nombre_contacto, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->nombre_contacto->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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

        // Field causa_ocurrencia
        $filter = $this->queryBuilderWhere("causa_ocurrencia");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->causa_ocurrencia, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->causa_ocurrencia->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field venta
        $filter = $this->queryBuilderWhere("venta");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->venta, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->venta->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field user_registra
        $filter = $this->queryBuilderWhere("user_registra");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->user_registra, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->user_registra->caption() . "</span>" . $captionSuffix . $filter . "</div>";
        }

        // Field fecha_registro
        $filter = $this->queryBuilderWhere("fecha_registro");
        if (!$filter) {
            $this->buildSearchSql($filter, $this->fecha_registro, false, false);
        }
        if ($filter != "") {
            $filterList .= "<div><span class=\"" . $captionClass . "\">" . $this->fecha_registro->caption() . "</span>" . $captionSuffix . $filter . "</div>";
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
        $searchFlds[] = &$this->contrato_parcela;
        $searchFlds[] = &$this->cedula_contacto;
        $searchFlds[] = &$this->nombre_contacto;
        $searchFlds[] = &$this->apellidos_contacto;
        $searchFlds[] = &$this->cedula_fallecido;
        $searchFlds[] = &$this->nombre_fallecido;
        $searchFlds[] = &$this->apellidos_fallecido;
        $searchFlds[] = &$this->sexo;
        $searchFlds[] = &$this->causa_otro;
        $searchFlds[] = &$this->religion;
        $searchFlds[] = &$this->permiso;
        $searchFlds[] = &$this->factura;
        $searchFlds[] = &$this->nota;
        $searchFlds[] = &$this->servicio_tipo;
        $searchFlds[] = &$this->servicio;
        $searchFlds[] = &$this->certificado_defuncion;
        $searchFlds[] = &$this->parcela;
        $searchFlds[] = &$this->username_autoriza;
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
        if ($this->contrato_parcela->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->tipo_contratacion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->seguro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nacionalidad_contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->cedula_contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nombre_contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->apellidos_contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->parentesco_contacto->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono_contacto1->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->telefono_contacto2->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->_email->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nacionalidad_fallecido->AdvancedSearch->issetSession()) {
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
        if ($this->sexo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_nacimiento->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->edad_fallecido->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estado_civil->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lugar_nacimiento_fallecido->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->lugar_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->direccion_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->hora_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->causa_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->causa_otro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->descripcion_ocurrencia->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->religion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->permiso->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->costos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->venta->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->user_registra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_registro->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->user_cierra->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_cierre->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->calidad->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->factura->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->unir_con_expediente->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->estatus->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->nota->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->funeraria->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->servicio_tipo->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->servicio->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->marca_pasos->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->peso->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->autoriza_cremar->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->certificado_defuncion->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->parcela->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->username_autoriza->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->fecha_autoriza->AdvancedSearch->issetSession()) {
            return true;
        }
        if ($this->email_calidad->AdvancedSearch->issetSession()) {
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
        $this->contrato_parcela->AdvancedSearch->unsetSession();
        $this->tipo_contratacion->AdvancedSearch->unsetSession();
        $this->seguro->AdvancedSearch->unsetSession();
        $this->nacionalidad_contacto->AdvancedSearch->unsetSession();
        $this->cedula_contacto->AdvancedSearch->unsetSession();
        $this->nombre_contacto->AdvancedSearch->unsetSession();
        $this->apellidos_contacto->AdvancedSearch->unsetSession();
        $this->parentesco_contacto->AdvancedSearch->unsetSession();
        $this->telefono_contacto1->AdvancedSearch->unsetSession();
        $this->telefono_contacto2->AdvancedSearch->unsetSession();
        $this->_email->AdvancedSearch->unsetSession();
        $this->nacionalidad_fallecido->AdvancedSearch->unsetSession();
        $this->cedula_fallecido->AdvancedSearch->unsetSession();
        $this->nombre_fallecido->AdvancedSearch->unsetSession();
        $this->apellidos_fallecido->AdvancedSearch->unsetSession();
        $this->sexo->AdvancedSearch->unsetSession();
        $this->fecha_nacimiento->AdvancedSearch->unsetSession();
        $this->edad_fallecido->AdvancedSearch->unsetSession();
        $this->estado_civil->AdvancedSearch->unsetSession();
        $this->lugar_nacimiento_fallecido->AdvancedSearch->unsetSession();
        $this->lugar_ocurrencia->AdvancedSearch->unsetSession();
        $this->direccion_ocurrencia->AdvancedSearch->unsetSession();
        $this->fecha_ocurrencia->AdvancedSearch->unsetSession();
        $this->hora_ocurrencia->AdvancedSearch->unsetSession();
        $this->causa_ocurrencia->AdvancedSearch->unsetSession();
        $this->causa_otro->AdvancedSearch->unsetSession();
        $this->descripcion_ocurrencia->AdvancedSearch->unsetSession();
        $this->religion->AdvancedSearch->unsetSession();
        $this->permiso->AdvancedSearch->unsetSession();
        $this->costos->AdvancedSearch->unsetSession();
        $this->venta->AdvancedSearch->unsetSession();
        $this->user_registra->AdvancedSearch->unsetSession();
        $this->fecha_registro->AdvancedSearch->unsetSession();
        $this->user_cierra->AdvancedSearch->unsetSession();
        $this->fecha_cierre->AdvancedSearch->unsetSession();
        $this->calidad->AdvancedSearch->unsetSession();
        $this->factura->AdvancedSearch->unsetSession();
        $this->unir_con_expediente->AdvancedSearch->unsetSession();
        $this->estatus->AdvancedSearch->unsetSession();
        $this->nota->AdvancedSearch->unsetSession();
        $this->funeraria->AdvancedSearch->unsetSession();
        $this->servicio_tipo->AdvancedSearch->unsetSession();
        $this->servicio->AdvancedSearch->unsetSession();
        $this->marca_pasos->AdvancedSearch->unsetSession();
        $this->peso->AdvancedSearch->unsetSession();
        $this->autoriza_cremar->AdvancedSearch->unsetSession();
        $this->certificado_defuncion->AdvancedSearch->unsetSession();
        $this->parcela->AdvancedSearch->unsetSession();
        $this->username_autoriza->AdvancedSearch->unsetSession();
        $this->fecha_autoriza->AdvancedSearch->unsetSession();
        $this->email_calidad->AdvancedSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();

        // Restore advanced search values
        $this->Nexpediente->AdvancedSearch->load();
        $this->contrato_parcela->AdvancedSearch->load();
        $this->tipo_contratacion->AdvancedSearch->load();
        $this->seguro->AdvancedSearch->load();
        $this->nacionalidad_contacto->AdvancedSearch->load();
        $this->cedula_contacto->AdvancedSearch->load();
        $this->nombre_contacto->AdvancedSearch->load();
        $this->apellidos_contacto->AdvancedSearch->load();
        $this->parentesco_contacto->AdvancedSearch->load();
        $this->telefono_contacto1->AdvancedSearch->load();
        $this->telefono_contacto2->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->nacionalidad_fallecido->AdvancedSearch->load();
        $this->cedula_fallecido->AdvancedSearch->load();
        $this->nombre_fallecido->AdvancedSearch->load();
        $this->apellidos_fallecido->AdvancedSearch->load();
        $this->sexo->AdvancedSearch->load();
        $this->fecha_nacimiento->AdvancedSearch->load();
        $this->edad_fallecido->AdvancedSearch->load();
        $this->estado_civil->AdvancedSearch->load();
        $this->lugar_nacimiento_fallecido->AdvancedSearch->load();
        $this->lugar_ocurrencia->AdvancedSearch->load();
        $this->direccion_ocurrencia->AdvancedSearch->load();
        $this->fecha_ocurrencia->AdvancedSearch->load();
        $this->hora_ocurrencia->AdvancedSearch->load();
        $this->causa_ocurrencia->AdvancedSearch->load();
        $this->causa_otro->AdvancedSearch->load();
        $this->descripcion_ocurrencia->AdvancedSearch->load();
        $this->religion->AdvancedSearch->load();
        $this->permiso->AdvancedSearch->load();
        $this->costos->AdvancedSearch->load();
        $this->venta->AdvancedSearch->load();
        $this->user_registra->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->user_cierra->AdvancedSearch->load();
        $this->fecha_cierre->AdvancedSearch->load();
        $this->calidad->AdvancedSearch->load();
        $this->factura->AdvancedSearch->load();
        $this->unir_con_expediente->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->nota->AdvancedSearch->load();
        $this->funeraria->AdvancedSearch->load();
        $this->servicio_tipo->AdvancedSearch->load();
        $this->servicio->AdvancedSearch->load();
        $this->marca_pasos->AdvancedSearch->load();
        $this->peso->AdvancedSearch->load();
        $this->autoriza_cremar->AdvancedSearch->load();
        $this->certificado_defuncion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->username_autoriza->AdvancedSearch->load();
        $this->fecha_autoriza->AdvancedSearch->load();
        $this->email_calidad->AdvancedSearch->load();
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
            $this->updateSort($this->nombre_contacto); // nombre_contacto
            $this->updateSort($this->cedula_fallecido); // cedula_fallecido
            $this->updateSort($this->nombre_fallecido); // nombre_fallecido
            $this->updateSort($this->apellidos_fallecido); // apellidos_fallecido
            $this->updateSort($this->causa_ocurrencia); // causa_ocurrencia
            $this->updateSort($this->venta); // venta
            $this->updateSort($this->user_registra); // user_registra
            $this->updateSort($this->fecha_registro); // fecha_registro
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
                $this->Nexpediente->setSort("");
                $this->contrato_parcela->setSort("");
                $this->tipo_contratacion->setSort("");
                $this->seguro->setSort("");
                $this->nacionalidad_contacto->setSort("");
                $this->cedula_contacto->setSort("");
                $this->nombre_contacto->setSort("");
                $this->apellidos_contacto->setSort("");
                $this->parentesco_contacto->setSort("");
                $this->telefono_contacto1->setSort("");
                $this->telefono_contacto2->setSort("");
                $this->_email->setSort("");
                $this->nacionalidad_fallecido->setSort("");
                $this->cedula_fallecido->setSort("");
                $this->nombre_fallecido->setSort("");
                $this->apellidos_fallecido->setSort("");
                $this->sexo->setSort("");
                $this->fecha_nacimiento->setSort("");
                $this->edad_fallecido->setSort("");
                $this->estado_civil->setSort("");
                $this->lugar_nacimiento_fallecido->setSort("");
                $this->lugar_ocurrencia->setSort("");
                $this->direccion_ocurrencia->setSort("");
                $this->fecha_ocurrencia->setSort("");
                $this->hora_ocurrencia->setSort("");
                $this->causa_ocurrencia->setSort("");
                $this->causa_otro->setSort("");
                $this->descripcion_ocurrencia->setSort("");
                $this->religion->setSort("");
                $this->permiso->setSort("");
                $this->costos->setSort("");
                $this->venta->setSort("");
                $this->user_registra->setSort("");
                $this->fecha_registro->setSort("");
                $this->user_cierra->setSort("");
                $this->fecha_cierre->setSort("");
                $this->calidad->setSort("");
                $this->factura->setSort("");
                $this->unir_con_expediente->setSort("");
                $this->estatus->setSort("");
                $this->nota->setSort("");
                $this->funeraria->setSort("");
                $this->servicio_tipo->setSort("");
                $this->servicio->setSort("");
                $this->marca_pasos->setSort("");
                $this->peso->setSort("");
                $this->autoriza_cremar->setSort("");
                $this->certificado_defuncion->setSort("");
                $this->parcela->setSort("");
                $this->username_autoriza->setSort("");
                $this->fecha_autoriza->setSort("");
                $this->email_calidad->setSort("");
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

        // "detail_sco_orden"
        $item = &$this->ListOptions->add("detail_sco_orden");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_orden');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_seguimiento"
        $item = &$this->ListOptions->add("detail_sco_seguimiento");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_seguimiento');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_expediente_estatus"
        $item = &$this->ListOptions->add("detail_sco_expediente_estatus");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_expediente_estatus');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_adjunto"
        $item = &$this->ListOptions->add("detail_sco_adjunto");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_adjunto');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_cremacion_estatus"
        $item = &$this->ListOptions->add("detail_sco_cremacion_estatus");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_cremacion_estatus');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_parcela"
        $item = &$this->ListOptions->add("detail_sco_parcela");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_parcela');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_expediente_encuesta_calidad"
        $item = &$this->ListOptions->add("detail_sco_expediente_encuesta_calidad");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_expediente_encuesta_calidad');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_expediente_cia"
        $item = &$this->ListOptions->add("detail_sco_expediente_cia");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_expediente_cia');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_embalaje"
        $item = &$this->ListOptions->add("detail_sco_embalaje");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_embalaje');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_reembolso"
        $item = &$this->ListOptions->add("detail_sco_reembolso");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_reembolso');
        $item->OnLeft = true;
        $item->ShowInButtonGroup = false;

        // "detail_sco_nota"
        $item = &$this->ListOptions->add("detail_sco_nota");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->allowList(CurrentProjectID() . 'sco_nota');
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
        $pages->add("sco_orden");
        $pages->add("sco_seguimiento");
        $pages->add("sco_expediente_estatus");
        $pages->add("sco_adjunto");
        $pages->add("sco_cremacion_estatus");
        $pages->add("sco_parcela");
        $pages->add("sco_expediente_encuesta_calidad");
        $pages->add("sco_expediente_cia");
        $pages->add("sco_embalaje");
        $pages->add("sco_reembolso");
        $pages->add("sco_nota");
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
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"sco_expediente\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
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
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"sco_expediente\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
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
                            : "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_expedientelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button></li>";
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = $disabled
                            ? "<div class=\"alert alert-light\">" . $icon . " " . $caption . "</div>"
                            : "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . $title . "\" data-caption=\"" . $title . "\" data-ew-action=\"submit\" form=\"fsco_expedientelist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listAction->toDataAttributes() . ">" . $icon . " " . $caption . "</button>";
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

        // "detail_sco_orden"
        $opt = $this->ListOptions["detail_sco_orden"];
        if ($Security->allowList(CurrentProjectID() . 'sco_orden')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_orden", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoOrdenList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoOrdenGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_orden");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_orden";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_orden");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_orden";
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

        // "detail_sco_seguimiento"
        $opt = $this->ListOptions["detail_sco_seguimiento"];
        if ($Security->allowList(CurrentProjectID() . 'sco_seguimiento')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_seguimiento", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoSeguimientoList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoSeguimientoGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_seguimiento");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_seguimiento";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_seguimiento");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_seguimiento";
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

        // "detail_sco_expediente_estatus"
        $opt = $this->ListOptions["detail_sco_expediente_estatus"];
        if ($Security->allowList(CurrentProjectID() . 'sco_expediente_estatus')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_expediente_estatus", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoExpedienteEstatusList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoExpedienteEstatusGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_estatus");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_expediente_estatus";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_estatus");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_expediente_estatus";
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

        // "detail_sco_adjunto"
        $opt = $this->ListOptions["detail_sco_adjunto"];
        if ($Security->allowList(CurrentProjectID() . 'sco_adjunto')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_adjunto", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoAdjuntoList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoAdjuntoGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_adjunto");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_adjunto";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_adjunto");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_adjunto";
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

        // "detail_sco_cremacion_estatus"
        $opt = $this->ListOptions["detail_sco_cremacion_estatus"];
        if ($Security->allowList(CurrentProjectID() . 'sco_cremacion_estatus')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_cremacion_estatus", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoCremacionEstatusList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoCremacionEstatusGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_cremacion_estatus");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_cremacion_estatus";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_cremacion_estatus");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_cremacion_estatus";
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

        // "detail_sco_parcela"
        $opt = $this->ListOptions["detail_sco_parcela"];
        if ($Security->allowList(CurrentProjectID() . 'sco_parcela')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_parcela", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoParcelaList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_contrato_parcela", $this->contrato_parcela->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoParcelaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_parcela";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_parcela";
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

        // "detail_sco_expediente_encuesta_calidad"
        $opt = $this->ListOptions["detail_sco_expediente_encuesta_calidad"];
        if ($Security->allowList(CurrentProjectID() . 'sco_expediente_encuesta_calidad')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_expediente_encuesta_calidad", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoExpedienteEncuestaCalidadList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoExpedienteEncuestaCalidadGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_encuesta_calidad");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_expediente_encuesta_calidad";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_encuesta_calidad");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_expediente_encuesta_calidad";
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

        // "detail_sco_expediente_cia"
        $opt = $this->ListOptions["detail_sco_expediente_cia"];
        if ($Security->allowList(CurrentProjectID() . 'sco_expediente_cia')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_expediente_cia", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoExpedienteCiaList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoExpedienteCiaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_cia");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_expediente_cia";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_cia");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_expediente_cia";
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

        // "detail_sco_embalaje"
        $opt = $this->ListOptions["detail_sco_embalaje"];
        if ($Security->allowList(CurrentProjectID() . 'sco_embalaje')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_embalaje", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoEmbalajeList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoEmbalajeGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_embalaje");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_embalaje";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_embalaje");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_embalaje";
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

        // "detail_sco_reembolso"
        $opt = $this->ListOptions["detail_sco_reembolso"];
        if ($Security->allowList(CurrentProjectID() . 'sco_reembolso')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_reembolso", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoReembolsoList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoReembolsoGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_reembolso");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_reembolso";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_reembolso");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_reembolso";
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

        // "detail_sco_nota"
        $opt = $this->ListOptions["detail_sco_nota"];
        if ($Security->allowList(CurrentProjectID() . 'sco_nota')) {
            $body = $Language->phrase("DetailLink") . $Language->tablePhrase("sco_nota", "TblCaption");
            $body = "<a class=\"btn btn-default ew-row-link ew-detail" . ($this->ListOptions->UseDropDownButton ? " dropdown-toggle" : "") . "\" data-action=\"list\" href=\"" . HtmlEncode("ScoNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue) . "") . "\">" . $body . "</a>";
            $links = "";
            $detailPage = Container("ScoNotaGrid");
            if ($detailPage->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink", null);
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailViewTblVar != "") {
                    $detailViewTblVar .= ",";
                }
                $detailViewTblVar .= "sco_nota";
            }
            if ($detailPage->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink", null);
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_nota");
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode($url) . "\">" . $caption . "</a></li>";
                if ($detailEditTblVar != "") {
                    $detailEditTblVar .= ",";
                }
                $detailEditTblVar .= "sco_nota";
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

        // Preview extension
        $links = "";
        $detailFilters = [];
        $masterKeys = []; // Reset
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_orden"
        if ($this->DetailPages?->getItem("sco_orden")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_orden')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_orden"];
            $detailTbl = Container("sco_orden");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoOrdenPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_orden\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_orden", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_orden\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoOrdenList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_orden", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoOrdenGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_orden"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_orden"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_seguimiento"
        if ($this->DetailPages?->getItem("sco_seguimiento")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_seguimiento')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_seguimiento"];
            $detailTbl = Container("sco_seguimiento");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoSeguimientoPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_seguimiento\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_seguimiento", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_seguimiento\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoSeguimientoList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_seguimiento", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoSeguimientoGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_seguimiento"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_seguimiento"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_expediente_estatus"
        if ($this->DetailPages?->getItem("sco_expediente_estatus")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_expediente_estatus')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_expediente_estatus"];
            $detailTbl = Container("sco_expediente_estatus");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoExpedienteEstatusPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_expediente_estatus\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_expediente_estatus", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_expediente_estatus\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoExpedienteEstatusList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_expediente_estatus", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoExpedienteEstatusGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_estatus"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_estatus"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_adjunto"
        if ($this->DetailPages?->getItem("sco_adjunto")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_adjunto')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_adjunto"];
            $detailTbl = Container("sco_adjunto");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoAdjuntoPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_adjunto\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_adjunto", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_adjunto\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoAdjuntoList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_adjunto", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoAdjuntoGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_adjunto"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_adjunto"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_cremacion_estatus"
        if ($this->DetailPages?->getItem("sco_cremacion_estatus")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_cremacion_estatus')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_cremacion_estatus"];
            $detailTbl = Container("sco_cremacion_estatus");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoCremacionEstatusPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_cremacion_estatus\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_cremacion_estatus", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_cremacion_estatus\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoCremacionEstatusList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_cremacion_estatus", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoCremacionEstatusGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_cremacion_estatus"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_cremacion_estatus"));
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
        $masterKeys["contrato_parcela"] = strval($this->contrato_parcela->DbValue);

        // Column "detail_sco_parcela"
        if ($this->DetailPages?->getItem("sco_parcela")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_parcela')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_parcela"];
            $detailTbl = Container("sco_parcela");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoParcelaPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_parcela\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_parcela", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_parcela\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoParcelaList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_parcela", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoParcelaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_expediente_encuesta_calidad"
        if ($this->DetailPages?->getItem("sco_expediente_encuesta_calidad")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_expediente_encuesta_calidad')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_expediente_encuesta_calidad"];
            $detailTbl = Container("sco_expediente_encuesta_calidad");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoExpedienteEncuestaCalidadPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_expediente_encuesta_calidad\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_expediente_encuesta_calidad", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_expediente_encuesta_calidad\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoExpedienteEncuestaCalidadList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_expediente_encuesta_calidad", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoExpedienteEncuestaCalidadGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_encuesta_calidad"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_encuesta_calidad"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_expediente_cia"
        if ($this->DetailPages?->getItem("sco_expediente_cia")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_expediente_cia')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_expediente_cia"];
            $detailTbl = Container("sco_expediente_cia");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoExpedienteCiaPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_expediente_cia\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_expediente_cia", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_expediente_cia\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoExpedienteCiaList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_expediente_cia", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoExpedienteCiaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_cia"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_cia"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_embalaje"
        if ($this->DetailPages?->getItem("sco_embalaje")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_embalaje')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_embalaje"];
            $detailTbl = Container("sco_embalaje");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoEmbalajePreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_embalaje\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_embalaje", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_embalaje\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoEmbalajeList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_embalaje", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoEmbalajeGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_embalaje"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_embalaje"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_reembolso"
        if ($this->DetailPages?->getItem("sco_reembolso")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_reembolso')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_reembolso"];
            $detailTbl = Container("sco_reembolso");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoReembolsoPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_reembolso\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_reembolso", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_reembolso\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoReembolsoList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_reembolso", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoReembolsoGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_reembolso"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_reembolso"));
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
        $masterKeys["Nexpediente"] = strval($this->Nexpediente->DbValue);

        // Column "detail_sco_nota"
        if ($this->DetailPages?->getItem("sco_nota")?->Visible && $Security->allowList(CurrentProjectID() . 'sco_nota')) {
            $link = "";
            $option = $this->ListOptions["detail_sco_nota"];
            $detailTbl = Container("sco_nota");
            $detailFilter = $detailTbl->getDetailFilter($this);
            $detailTbl->setCurrentMasterTable($this->TableVar);
            $detailFilter = $detailTbl->applyUserIDFilters($detailFilter);
            $url = "ScoNotaPreview?t=sco_expediente&f=" . Encrypt($detailFilter . "|" . implode("|", array_values($masterKeys)));
            $btngrp = "<div data-table=\"sco_nota\" data-url=\"" . $url . "\" class=\"ew-detail-btn-group d-none\">";
            if ($Security->allowList(CurrentProjectID() . 'sco_expediente')) {
                $label = $Language->tablePhrase("sco_nota", "TblCaption");
                $link = "<button class=\"nav-link\" data-bs-toggle=\"tab\" data-table=\"sco_nota\" data-url=\"" . $url . "\" type=\"button\" role=\"tab\" aria-selected=\"false\">" . $label . "</button>";
                $detaillnk = GetUrl("ScoNotaList?" . Config("TABLE_SHOW_MASTER") . "=sco_expediente");
                foreach ($masterKeys as $key => $value) {
                    $detaillnk .= "&" . GetForeignKeyUrl("fk_$key", $value);
                }
                $title = $Language->tablePhrase("sco_nota", "TblCaption");
                $caption = $Language->phrase("MasterDetailListLink");
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . $title . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($detaillnk) . "\">" . $caption . "</a>";
            }
            $detailPageObj = Container("ScoNotaGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $viewurl = GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=sco_nota"));
                $btngrp .= "<a href=\"#\" class=\"me-2\" title=\"" . HtmlTitle($caption) . "\" data-ew-action=\"redirect\" data-url=\"" . HtmlEncode($viewurl) . "\">" . $caption . "</a>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'sco_expediente')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $editurl = GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=sco_nota"));
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"sco_expediente\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["detail"];
        $detailTableLink = "";
        $item = &$option->add("detailadd_sco_orden");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_orden");
        $detailPage = Container("ScoOrdenGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_orden";
        }
        $item = &$option->add("detailadd_sco_seguimiento");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_seguimiento");
        $detailPage = Container("ScoSeguimientoGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_seguimiento";
        }
        $item = &$option->add("detailadd_sco_expediente_estatus");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_estatus");
        $detailPage = Container("ScoExpedienteEstatusGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_expediente_estatus";
        }
        $item = &$option->add("detailadd_sco_adjunto");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_adjunto");
        $detailPage = Container("ScoAdjuntoGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_adjunto";
        }
        $item = &$option->add("detailadd_sco_cremacion_estatus");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_cremacion_estatus");
        $detailPage = Container("ScoCremacionEstatusGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_cremacion_estatus";
        }
        $item = &$option->add("detailadd_sco_parcela");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_parcela");
        $detailPage = Container("ScoParcelaGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_parcela";
        }
        $item = &$option->add("detailadd_sco_expediente_encuesta_calidad");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_encuesta_calidad");
        $detailPage = Container("ScoExpedienteEncuestaCalidadGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_expediente_encuesta_calidad";
        }
        $item = &$option->add("detailadd_sco_expediente_cia");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_expediente_cia");
        $detailPage = Container("ScoExpedienteCiaGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_expediente_cia";
        }
        $item = &$option->add("detailadd_sco_embalaje");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_embalaje");
        $detailPage = Container("ScoEmbalajeGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_embalaje";
        }
        $item = &$option->add("detailadd_sco_reembolso");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_reembolso");
        $detailPage = Container("ScoReembolsoGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_reembolso";
        }
        $item = &$option->add("detailadd_sco_nota");
        $url = $this->getAddUrl(Config("TABLE_SHOW_DETAIL") . "=sco_nota");
        $detailPage = Container("ScoNotaGrid");
        $caption = $Language->phrase("Add") . "&nbsp;" . $this->tableCaption() . "/" . $detailPage->tableCaption();
        $item->Body = "<a class=\"ew-detail-add-group ew-detail-add\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"" . HtmlEncode(GetUrl($url)) . "\">" . $caption . "</a>";
        $item->Visible = ($detailPage->DetailAdd && $Security->allowAdd(CurrentProjectID() . 'sco_expediente') && $Security->canAdd());
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "sco_nota";
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
            $this->createColumnOption($option, "Nexpediente");
            $this->createColumnOption($option, "nombre_contacto");
            $this->createColumnOption($option, "cedula_fallecido");
            $this->createColumnOption($option, "nombre_fallecido");
            $this->createColumnOption($option, "apellidos_fallecido");
            $this->createColumnOption($option, "causa_ocurrencia");
            $this->createColumnOption($option, "venta");
            $this->createColumnOption($option, "user_registra");
            $this->createColumnOption($option, "fecha_registro");
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
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsco_expedientesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsco_expedientesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
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
                $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsco_expedientelist"' . $listAction->toDataAttributes() . '>' . $icon . '</button>';
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
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_sco_expediente", "data-rowtype" => RowType::ADD]);
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
            "id" => "r" . $this->RowCount . "_sco_expediente",
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

        // contrato_parcela
        if ($this->contrato_parcela->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->contrato_parcela->AdvancedSearch->SearchValue != "" || $this->contrato_parcela->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // tipo_contratacion
        if ($this->tipo_contratacion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->tipo_contratacion->AdvancedSearch->SearchValue != "" || $this->tipo_contratacion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // nacionalidad_contacto
        if ($this->nacionalidad_contacto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nacionalidad_contacto->AdvancedSearch->SearchValue != "" || $this->nacionalidad_contacto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // cedula_contacto
        if ($this->cedula_contacto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->cedula_contacto->AdvancedSearch->SearchValue != "" || $this->cedula_contacto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // apellidos_contacto
        if ($this->apellidos_contacto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->apellidos_contacto->AdvancedSearch->SearchValue != "" || $this->apellidos_contacto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // parentesco_contacto
        if ($this->parentesco_contacto->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->parentesco_contacto->AdvancedSearch->SearchValue != "" || $this->parentesco_contacto->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // email
        if ($this->_email->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->_email->AdvancedSearch->SearchValue != "" || $this->_email->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // nacionalidad_fallecido
        if ($this->nacionalidad_fallecido->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nacionalidad_fallecido->AdvancedSearch->SearchValue != "" || $this->nacionalidad_fallecido->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // sexo
        if ($this->sexo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->sexo->AdvancedSearch->SearchValue != "" || $this->sexo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // estado_civil
        if ($this->estado_civil->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->estado_civil->AdvancedSearch->SearchValue != "" || $this->estado_civil->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // lugar_nacimiento_fallecido
        if ($this->lugar_nacimiento_fallecido->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lugar_nacimiento_fallecido->AdvancedSearch->SearchValue != "" || $this->lugar_nacimiento_fallecido->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // lugar_ocurrencia
        if ($this->lugar_ocurrencia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->lugar_ocurrencia->AdvancedSearch->SearchValue != "" || $this->lugar_ocurrencia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // direccion_ocurrencia
        if ($this->direccion_ocurrencia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->direccion_ocurrencia->AdvancedSearch->SearchValue != "" || $this->direccion_ocurrencia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // hora_ocurrencia
        if ($this->hora_ocurrencia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->hora_ocurrencia->AdvancedSearch->SearchValue != "" || $this->hora_ocurrencia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // descripcion_ocurrencia
        if ($this->descripcion_ocurrencia->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->descripcion_ocurrencia->AdvancedSearch->SearchValue != "" || $this->descripcion_ocurrencia->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // religion
        if ($this->religion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->religion->AdvancedSearch->SearchValue != "" || $this->religion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // costos
        if ($this->costos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->costos->AdvancedSearch->SearchValue != "" || $this->costos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // user_registra
        if ($this->user_registra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->user_registra->AdvancedSearch->SearchValue != "" || $this->user_registra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // user_cierra
        if ($this->user_cierra->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->user_cierra->AdvancedSearch->SearchValue != "" || $this->user_cierra->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_cierre
        if ($this->fecha_cierre->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_cierre->AdvancedSearch->SearchValue != "" || $this->fecha_cierre->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // calidad
        if ($this->calidad->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->calidad->AdvancedSearch->SearchValue != "" || $this->calidad->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // unir_con_expediente
        if ($this->unir_con_expediente->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->unir_con_expediente->AdvancedSearch->SearchValue != "" || $this->unir_con_expediente->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // nota
        if ($this->nota->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->nota->AdvancedSearch->SearchValue != "" || $this->nota->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // servicio_tipo
        if ($this->servicio_tipo->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->servicio_tipo->AdvancedSearch->SearchValue != "" || $this->servicio_tipo->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // marca_pasos
        if ($this->marca_pasos->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->marca_pasos->AdvancedSearch->SearchValue != "" || $this->marca_pasos->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // peso
        if ($this->peso->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->peso->AdvancedSearch->SearchValue != "" || $this->peso->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // autoriza_cremar
        if ($this->autoriza_cremar->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->autoriza_cremar->AdvancedSearch->SearchValue != "" || $this->autoriza_cremar->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // certificado_defuncion
        if ($this->certificado_defuncion->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->certificado_defuncion->AdvancedSearch->SearchValue != "" || $this->certificado_defuncion->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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

        // username_autoriza
        if ($this->username_autoriza->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->username_autoriza->AdvancedSearch->SearchValue != "" || $this->username_autoriza->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // fecha_autoriza
        if ($this->fecha_autoriza->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->fecha_autoriza->AdvancedSearch->SearchValue != "" || $this->fecha_autoriza->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
                $this->Command = "search";
            }
        }

        // email_calidad
        if ($this->email_calidad->AdvancedSearch->get()) {
            $hasValue = true;
            if (($this->email_calidad->AdvancedSearch->SearchValue != "" || $this->email_calidad->AdvancedSearch->SearchValue2 != "") && $this->Command == "") {
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
        $this->contrato_parcela->setDbValue($row['contrato_parcela']);
        $this->tipo_contratacion->setDbValue($row['tipo_contratacion']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nacionalidad_contacto->setDbValue($row['nacionalidad_contacto']);
        $this->cedula_contacto->setDbValue($row['cedula_contacto']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->apellidos_contacto->setDbValue($row['apellidos_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->_email->setDbValue($row['email']);
        $this->nacionalidad_fallecido->setDbValue($row['nacionalidad_fallecido']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->edad_fallecido->setDbValue($row['edad_fallecido']);
        $this->estado_civil->setDbValue($row['estado_civil']);
        $this->lugar_nacimiento_fallecido->setDbValue($row['lugar_nacimiento_fallecido']);
        $this->lugar_ocurrencia->setDbValue($row['lugar_ocurrencia']);
        $this->direccion_ocurrencia->setDbValue($row['direccion_ocurrencia']);
        $this->fecha_ocurrencia->setDbValue($row['fecha_ocurrencia']);
        $this->hora_ocurrencia->setDbValue($row['hora_ocurrencia']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->causa_otro->setDbValue($row['causa_otro']);
        $this->descripcion_ocurrencia->setDbValue($row['descripcion_ocurrencia']);
        $this->religion->setDbValue($row['religion']);
        $this->permiso->setDbValue($row['permiso']);
        $this->costos->setDbValue($row['costos']);
        $this->venta->setDbValue($row['venta']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_cierra->setDbValue($row['user_cierra']);
        $this->fecha_cierre->setDbValue($row['fecha_cierre']);
        $this->calidad->setDbValue($row['calidad']);
        $this->factura->setDbValue($row['factura']);
        $this->unir_con_expediente->setDbValue($row['unir_con_expediente']);
        $this->estatus->setDbValue($row['estatus']);
        $this->nota->setDbValue($row['nota']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->marca_pasos->setDbValue($row['marca_pasos']);
        $this->peso->setDbValue($row['peso']);
        $this->autoriza_cremar->setDbValue($row['autoriza_cremar']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->username_autoriza->setDbValue($row['username_autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->email_calidad->setDbValue($row['email_calidad']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente'] = $this->Nexpediente->DefaultValue;
        $row['contrato_parcela'] = $this->contrato_parcela->DefaultValue;
        $row['tipo_contratacion'] = $this->tipo_contratacion->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nacionalidad_contacto'] = $this->nacionalidad_contacto->DefaultValue;
        $row['cedula_contacto'] = $this->cedula_contacto->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['apellidos_contacto'] = $this->apellidos_contacto->DefaultValue;
        $row['parentesco_contacto'] = $this->parentesco_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['nacionalidad_fallecido'] = $this->nacionalidad_fallecido->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
        $row['sexo'] = $this->sexo->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['edad_fallecido'] = $this->edad_fallecido->DefaultValue;
        $row['estado_civil'] = $this->estado_civil->DefaultValue;
        $row['lugar_nacimiento_fallecido'] = $this->lugar_nacimiento_fallecido->DefaultValue;
        $row['lugar_ocurrencia'] = $this->lugar_ocurrencia->DefaultValue;
        $row['direccion_ocurrencia'] = $this->direccion_ocurrencia->DefaultValue;
        $row['fecha_ocurrencia'] = $this->fecha_ocurrencia->DefaultValue;
        $row['hora_ocurrencia'] = $this->hora_ocurrencia->DefaultValue;
        $row['causa_ocurrencia'] = $this->causa_ocurrencia->DefaultValue;
        $row['causa_otro'] = $this->causa_otro->DefaultValue;
        $row['descripcion_ocurrencia'] = $this->descripcion_ocurrencia->DefaultValue;
        $row['religion'] = $this->religion->DefaultValue;
        $row['permiso'] = $this->permiso->DefaultValue;
        $row['costos'] = $this->costos->DefaultValue;
        $row['venta'] = $this->venta->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['user_cierra'] = $this->user_cierra->DefaultValue;
        $row['fecha_cierre'] = $this->fecha_cierre->DefaultValue;
        $row['calidad'] = $this->calidad->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['unir_con_expediente'] = $this->unir_con_expediente->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['marca_pasos'] = $this->marca_pasos->DefaultValue;
        $row['peso'] = $this->peso->DefaultValue;
        $row['autoriza_cremar'] = $this->autoriza_cremar->DefaultValue;
        $row['certificado_defuncion'] = $this->certificado_defuncion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['username_autoriza'] = $this->username_autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
        $row['email_calidad'] = $this->email_calidad->DefaultValue;
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

        // contrato_parcela

        // tipo_contratacion

        // seguro

        // nacionalidad_contacto

        // cedula_contacto

        // nombre_contacto

        // apellidos_contacto

        // parentesco_contacto

        // telefono_contacto1

        // telefono_contacto2

        // email

        // nacionalidad_fallecido

        // cedula_fallecido

        // nombre_fallecido

        // apellidos_fallecido

        // sexo

        // fecha_nacimiento

        // edad_fallecido

        // estado_civil

        // lugar_nacimiento_fallecido

        // lugar_ocurrencia

        // direccion_ocurrencia

        // fecha_ocurrencia

        // hora_ocurrencia

        // causa_ocurrencia

        // causa_otro

        // descripcion_ocurrencia

        // religion

        // permiso

        // costos

        // venta

        // user_registra

        // fecha_registro

        // user_cierra

        // fecha_cierre

        // calidad

        // factura

        // unir_con_expediente

        // estatus

        // nota

        // funeraria

        // servicio_tipo

        // servicio

        // marca_pasos

        // peso

        // autoriza_cremar

        // certificado_defuncion

        // parcela

        // username_autoriza

        // fecha_autoriza

        // email_calidad

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente
            $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

            // contrato_parcela
            $this->contrato_parcela->ViewValue = $this->contrato_parcela->CurrentValue;
            $this->contrato_parcela->ImageAlt = $this->contrato_parcela->alt();
                $this->contrato_parcela->ImageCssClass = "ew-image";

            // tipo_contratacion
            $curVal = strval($this->tipo_contratacion->CurrentValue);
            if ($curVal != "") {
                $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->lookupCacheOption($curVal);
                if ($this->tipo_contratacion->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_contratacion->Lookup->getTable()->Fields["tipo_contratacion"]->searchExpression(), "=", $curVal, $this->tipo_contratacion->Lookup->getTable()->Fields["tipo_contratacion"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_contratacion->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_contratacion->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->displayValue($arwrk);
                    } else {
                        $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->CurrentValue;
                    }
                }
            } else {
                $this->tipo_contratacion->ViewValue = null;
            }

            // seguro
            $curVal = strval($this->seguro->CurrentValue);
            if ($curVal != "") {
                $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
                if ($this->seguro->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                    $lookupFilter = $this->seguro->getSelectFilter($this); // PHP
                    $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // nacionalidad_contacto
            if (strval($this->nacionalidad_contacto->CurrentValue) != "") {
                $this->nacionalidad_contacto->ViewValue = $this->nacionalidad_contacto->optionCaption($this->nacionalidad_contacto->CurrentValue);
            } else {
                $this->nacionalidad_contacto->ViewValue = null;
            }

            // cedula_contacto
            $this->cedula_contacto->ViewValue = $this->cedula_contacto->CurrentValue;

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // apellidos_contacto
            $this->apellidos_contacto->ViewValue = $this->apellidos_contacto->CurrentValue;

            // parentesco_contacto
            $curVal = strval($this->parentesco_contacto->CurrentValue);
            if ($curVal != "") {
                $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->lookupCacheOption($curVal);
                if ($this->parentesco_contacto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->parentesco_contacto->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->parentesco_contacto->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->parentesco_contacto->getSelectFilter($this); // PHP
                    $sqlWrk = $this->parentesco_contacto->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parentesco_contacto->Lookup->renderViewRow($rswrk[0]);
                        $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->displayValue($arwrk);
                    } else {
                        $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->CurrentValue;
                    }
                }
            } else {
                $this->parentesco_contacto->ViewValue = null;
            }

            // telefono_contacto1
            $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

            // telefono_contacto2
            $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // nacionalidad_fallecido
            if (strval($this->nacionalidad_fallecido->CurrentValue) != "") {
                $this->nacionalidad_fallecido->ViewValue = $this->nacionalidad_fallecido->optionCaption($this->nacionalidad_fallecido->CurrentValue);
            } else {
                $this->nacionalidad_fallecido->ViewValue = null;
            }
            $this->nacionalidad_fallecido->CssClass = "fw-bold";

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;
            $this->cedula_fallecido->CssClass = "fw-bold";

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;
            $this->nombre_fallecido->CssClass = "fw-bold";

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;
            $this->apellidos_fallecido->CssClass = "fw-bold";

            // sexo
            $curVal = strval($this->sexo->CurrentValue);
            if ($curVal != "") {
                $this->sexo->ViewValue = $this->sexo->lookupCacheOption($curVal);
                if ($this->sexo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->sexo->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->sexo->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->sexo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->sexo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->sexo->Lookup->renderViewRow($rswrk[0]);
                        $this->sexo->ViewValue = $this->sexo->displayValue($arwrk);
                    } else {
                        $this->sexo->ViewValue = $this->sexo->CurrentValue;
                    }
                }
            } else {
                $this->sexo->ViewValue = null;
            }

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
            $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

            // edad_fallecido
            $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;

            // estado_civil
            $curVal = strval($this->estado_civil->CurrentValue);
            if ($curVal != "") {
                $this->estado_civil->ViewValue = $this->estado_civil->lookupCacheOption($curVal);
                if ($this->estado_civil->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estado_civil->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->estado_civil->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $sqlWrk = $this->estado_civil->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->estado_civil->Lookup->renderViewRow($rswrk[0]);
                        $this->estado_civil->ViewValue = $this->estado_civil->displayValue($arwrk);
                    } else {
                        $this->estado_civil->ViewValue = $this->estado_civil->CurrentValue;
                    }
                }
            } else {
                $this->estado_civil->ViewValue = null;
            }
            $this->estado_civil->CssClass = "fw-bold";

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;
            $this->lugar_nacimiento_fallecido->CssClass = "fw-bold";

            // lugar_ocurrencia
            $curVal = strval($this->lugar_ocurrencia->CurrentValue);
            if ($curVal != "") {
                $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->lookupCacheOption($curVal);
                if ($this->lugar_ocurrencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->lugar_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->lugar_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                    $lookupFilter = $this->lugar_ocurrencia->getSelectFilter($this); // PHP
                    $sqlWrk = $this->lugar_ocurrencia->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->lugar_ocurrencia->Lookup->renderViewRow($rswrk[0]);
                        $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->displayValue($arwrk);
                    } else {
                        $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->CurrentValue;
                    }
                }
            } else {
                $this->lugar_ocurrencia->ViewValue = null;
            }

            // direccion_ocurrencia
            $this->direccion_ocurrencia->ViewValue = $this->direccion_ocurrencia->CurrentValue;

            // fecha_ocurrencia
            $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
            $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

            // hora_ocurrencia
            $this->hora_ocurrencia->ViewValue = $this->hora_ocurrencia->CurrentValue;
            $this->hora_ocurrencia->ViewValue = FormatDateTime($this->hora_ocurrencia->ViewValue, $this->hora_ocurrencia->formatPattern());
            $this->hora_ocurrencia->CssClass = "fw-bold";

            // causa_ocurrencia
            $curVal = strval($this->causa_ocurrencia->CurrentValue);
            if ($curVal != "") {
                $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->lookupCacheOption($curVal);
                if ($this->causa_ocurrencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                    $lookupFilter = $this->causa_ocurrencia->getSelectFilter($this); // PHP
                    $sqlWrk = $this->causa_ocurrencia->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->causa_ocurrencia->Lookup->renderViewRow($rswrk[0]);
                        $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->displayValue($arwrk);
                    } else {
                        $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;
                    }
                }
            } else {
                $this->causa_ocurrencia->ViewValue = null;
            }

            // causa_otro
            $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

            // religion
            $curVal = strval($this->religion->CurrentValue);
            if ($curVal != "") {
                $this->religion->ViewValue = $this->religion->lookupCacheOption($curVal);
                if ($this->religion->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->religion->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->religion->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->religion->getSelectFilter($this); // PHP
                    $sqlWrk = $this->religion->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->religion->Lookup->renderViewRow($rswrk[0]);
                        $this->religion->ViewValue = $this->religion->displayValue($arwrk);
                    } else {
                        $this->religion->ViewValue = $this->religion->CurrentValue;
                    }
                }
            } else {
                $this->religion->ViewValue = null;
            }

            // permiso
            $this->permiso->ViewValue = $this->permiso->CurrentValue;

            // costos
            $this->costos->ViewValue = $this->costos->CurrentValue;
            $this->costos->ViewValue = FormatCurrency($this->costos->ViewValue, $this->costos->formatPattern());

            // venta
            $this->venta->ViewValue = $this->venta->CurrentValue;
            $this->venta->ViewValue = FormatNumber($this->venta->ViewValue, $this->venta->formatPattern());

            // user_registra
            $this->user_registra->ViewValue = $this->user_registra->CurrentValue;
            $curVal = strval($this->user_registra->CurrentValue);
            if ($curVal != "") {
                $this->user_registra->ViewValue = $this->user_registra->lookupCacheOption($curVal);
                if ($this->user_registra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->user_registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->user_registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->user_registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->user_registra->Lookup->renderViewRow($rswrk[0]);
                        $this->user_registra->ViewValue = $this->user_registra->displayValue($arwrk);
                    } else {
                        $this->user_registra->ViewValue = $this->user_registra->CurrentValue;
                    }
                }
            } else {
                $this->user_registra->ViewValue = null;
            }

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // user_cierra
            $this->user_cierra->ViewValue = $this->user_cierra->CurrentValue;

            // fecha_cierre
            $this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
            $this->fecha_cierre->ViewValue = FormatDateTime($this->fecha_cierre->ViewValue, $this->fecha_cierre->formatPattern());

            // calidad
            $curVal = strval($this->calidad->CurrentValue);
            if ($curVal != "") {
                $this->calidad->ViewValue = $this->calidad->lookupCacheOption($curVal);
                if ($this->calidad->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->calidad->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->calidad->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->calidad->getSelectFilter($this); // PHP
                    $sqlWrk = $this->calidad->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->calidad->Lookup->renderViewRow($rswrk[0]);
                        $this->calidad->ViewValue = $this->calidad->displayValue($arwrk);
                    } else {
                        $this->calidad->ViewValue = $this->calidad->CurrentValue;
                    }
                }
            } else {
                $this->calidad->ViewValue = null;
            }

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // unir_con_expediente
            $curVal = strval($this->unir_con_expediente->CurrentValue);
            if ($curVal != "") {
                $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->lookupCacheOption($curVal);
                if ($this->unir_con_expediente->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unir_con_expediente->Lookup->getTable()->Fields["Nexpediente"]->searchExpression(), "=", $curVal, $this->unir_con_expediente->Lookup->getTable()->Fields["Nexpediente"]->searchDataType(), "");
                    $lookupFilter = $this->unir_con_expediente->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unir_con_expediente->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unir_con_expediente->Lookup->renderViewRow($rswrk[0]);
                        $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->displayValue($arwrk);
                    } else {
                        $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->CurrentValue;
                    }
                }
            } else {
                $this->unir_con_expediente->ViewValue = null;
            }

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
            $this->estatus->CssClass = "fw-bold";

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // funeraria
            if (strval($this->funeraria->CurrentValue) != "") {
                $this->funeraria->ViewValue = $this->funeraria->optionCaption($this->funeraria->CurrentValue);
            } else {
                $this->funeraria->ViewValue = null;
            }

            // servicio_tipo
            $curVal = strval($this->servicio_tipo->CurrentValue);
            if ($curVal != "") {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
                if ($this->servicio_tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $curVal, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                    $lookupFilter = $this->servicio_tipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->servicio_tipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->servicio_tipo->Lookup->renderViewRow($rswrk[0]);
                        $this->servicio_tipo->ViewValue = $this->servicio_tipo->displayValue($arwrk);
                    } else {
                        $this->servicio_tipo->ViewValue = $this->servicio_tipo->CurrentValue;
                    }
                }
            } else {
                $this->servicio_tipo->ViewValue = null;
            }

            // servicio
            $curVal = strval($this->servicio->CurrentValue);
            if ($curVal != "") {
                $this->servicio->ViewValue = $this->servicio->lookupCacheOption($curVal);
                if ($this->servicio->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchExpression(), "=", $curVal, $this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchDataType(), "");
                    $lookupFilter = $this->servicio->getSelectFilter($this); // PHP
                    $sqlWrk = $this->servicio->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->servicio->Lookup->renderViewRow($rswrk[0]);
                        $this->servicio->ViewValue = $this->servicio->displayValue($arwrk);
                    } else {
                        $this->servicio->ViewValue = $this->servicio->CurrentValue;
                    }
                }
            } else {
                $this->servicio->ViewValue = null;
            }

            // marca_pasos
            if (strval($this->marca_pasos->CurrentValue) != "") {
                $this->marca_pasos->ViewValue = $this->marca_pasos->optionCaption($this->marca_pasos->CurrentValue);
            } else {
                $this->marca_pasos->ViewValue = null;
            }

            // peso
            $curVal = strval($this->peso->CurrentValue);
            if ($curVal != "") {
                $this->peso->ViewValue = $this->peso->lookupCacheOption($curVal);
                if ($this->peso->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->peso->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->peso->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->peso->getSelectFilter($this); // PHP
                    $sqlWrk = $this->peso->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->peso->Lookup->renderViewRow($rswrk[0]);
                        $this->peso->ViewValue = $this->peso->displayValue($arwrk);
                    } else {
                        $this->peso->ViewValue = $this->peso->CurrentValue;
                    }
                }
            } else {
                $this->peso->ViewValue = null;
            }

            // autoriza_cremar
            if (strval($this->autoriza_cremar->CurrentValue) != "") {
                $this->autoriza_cremar->ViewValue = $this->autoriza_cremar->optionCaption($this->autoriza_cremar->CurrentValue);
            } else {
                $this->autoriza_cremar->ViewValue = null;
            }

            // certificado_defuncion
            $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // username_autoriza
            $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;
            $curVal = strval($this->username_autoriza->CurrentValue);
            if ($curVal != "") {
                $this->username_autoriza->ViewValue = $this->username_autoriza->lookupCacheOption($curVal);
                if ($this->username_autoriza->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->username_autoriza->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->username_autoriza->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->username_autoriza->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->username_autoriza->Lookup->renderViewRow($rswrk[0]);
                        $this->username_autoriza->ViewValue = $this->username_autoriza->displayValue($arwrk);
                    } else {
                        $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;
                    }
                }
            } else {
                $this->username_autoriza->ViewValue = null;
            }

            // fecha_autoriza
            $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
            $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

            // email_calidad
            if (strval($this->email_calidad->CurrentValue) != "") {
                $this->email_calidad->ViewValue = $this->email_calidad->optionCaption($this->email_calidad->CurrentValue);
            } else {
                $this->email_calidad->ViewValue = null;
            }

            // Nexpediente
            $this->Nexpediente->HrefValue = "";
            $this->Nexpediente->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";
            $this->nombre_contacto->TooltipValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";
            $this->cedula_fallecido->TooltipValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";
            $this->nombre_fallecido->TooltipValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";
            $this->apellidos_fallecido->TooltipValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";
            $this->causa_ocurrencia->TooltipValue = "";

            // venta
            $this->venta->HrefValue = "";
            $this->venta->TooltipValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";
            $this->user_registra->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";
        } elseif ($this->RowType == RowType::SEARCH) {
            // Nexpediente
            $this->Nexpediente->setupEditAttributes();
            $this->Nexpediente->EditValue = $this->Nexpediente->AdvancedSearch->SearchValue;
            $this->Nexpediente->PlaceHolder = RemoveHtml($this->Nexpediente->caption());

            // nombre_contacto
            $this->nombre_contacto->setupEditAttributes();
            if (!$this->nombre_contacto->Raw) {
                $this->nombre_contacto->AdvancedSearch->SearchValue = HtmlDecode($this->nombre_contacto->AdvancedSearch->SearchValue);
            }
            $this->nombre_contacto->EditValue = HtmlEncode($this->nombre_contacto->AdvancedSearch->SearchValue);
            $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

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

            // causa_ocurrencia
            $curVal = trim(strval($this->causa_ocurrencia->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->causa_ocurrencia->AdvancedSearch->ViewValue = $this->causa_ocurrencia->lookupCacheOption($curVal);
            } else {
                $this->causa_ocurrencia->AdvancedSearch->ViewValue = $this->causa_ocurrencia->Lookup !== null && is_array($this->causa_ocurrencia->lookupOptions()) && count($this->causa_ocurrencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->causa_ocurrencia->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->causa_ocurrencia->EditValue = array_values($this->causa_ocurrencia->lookupOptions());
                if ($this->causa_ocurrencia->AdvancedSearch->ViewValue == "") {
                    $this->causa_ocurrencia->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $this->causa_ocurrencia->AdvancedSearch->SearchValue, $this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                }
                $lookupFilter = $this->causa_ocurrencia->getSelectFilter($this); // PHP
                $sqlWrk = $this->causa_ocurrencia->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->causa_ocurrencia->Lookup->renderViewRow($rswrk[0]);
                    $this->causa_ocurrencia->AdvancedSearch->ViewValue = $this->causa_ocurrencia->displayValue($arwrk);
                } else {
                    $this->causa_ocurrencia->AdvancedSearch->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->causa_ocurrencia->EditValue = $arwrk;
            }
            $this->causa_ocurrencia->PlaceHolder = RemoveHtml($this->causa_ocurrencia->caption());

            // venta
            $this->venta->setupEditAttributes();
            $this->venta->EditValue = $this->venta->AdvancedSearch->SearchValue;
            $this->venta->PlaceHolder = RemoveHtml($this->venta->caption());

            // user_registra
            $this->user_registra->setupEditAttributes();
            if (!$this->user_registra->Raw) {
                $this->user_registra->AdvancedSearch->SearchValue = HtmlDecode($this->user_registra->AdvancedSearch->SearchValue);
            }
            $this->user_registra->EditValue = HtmlEncode($this->user_registra->AdvancedSearch->SearchValue);
            $this->user_registra->PlaceHolder = RemoveHtml($this->user_registra->caption());

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_registro->AdvancedSearch->SearchValue, $this->fecha_registro->formatPattern()), $this->fecha_registro->formatPattern()));
            $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue2 = HtmlEncode(FormatDateTime(UnFormatDateTime($this->fecha_registro->AdvancedSearch->SearchValue2, $this->fecha_registro->formatPattern()), $this->fecha_registro->formatPattern()));
            $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

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
        $this->contrato_parcela->AdvancedSearch->load();
        $this->tipo_contratacion->AdvancedSearch->load();
        $this->seguro->AdvancedSearch->load();
        $this->nacionalidad_contacto->AdvancedSearch->load();
        $this->cedula_contacto->AdvancedSearch->load();
        $this->nombre_contacto->AdvancedSearch->load();
        $this->apellidos_contacto->AdvancedSearch->load();
        $this->parentesco_contacto->AdvancedSearch->load();
        $this->telefono_contacto1->AdvancedSearch->load();
        $this->telefono_contacto2->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->nacionalidad_fallecido->AdvancedSearch->load();
        $this->cedula_fallecido->AdvancedSearch->load();
        $this->nombre_fallecido->AdvancedSearch->load();
        $this->apellidos_fallecido->AdvancedSearch->load();
        $this->sexo->AdvancedSearch->load();
        $this->fecha_nacimiento->AdvancedSearch->load();
        $this->edad_fallecido->AdvancedSearch->load();
        $this->estado_civil->AdvancedSearch->load();
        $this->lugar_nacimiento_fallecido->AdvancedSearch->load();
        $this->lugar_ocurrencia->AdvancedSearch->load();
        $this->direccion_ocurrencia->AdvancedSearch->load();
        $this->fecha_ocurrencia->AdvancedSearch->load();
        $this->hora_ocurrencia->AdvancedSearch->load();
        $this->causa_ocurrencia->AdvancedSearch->load();
        $this->causa_otro->AdvancedSearch->load();
        $this->descripcion_ocurrencia->AdvancedSearch->load();
        $this->religion->AdvancedSearch->load();
        $this->permiso->AdvancedSearch->load();
        $this->costos->AdvancedSearch->load();
        $this->venta->AdvancedSearch->load();
        $this->user_registra->AdvancedSearch->load();
        $this->fecha_registro->AdvancedSearch->load();
        $this->user_cierra->AdvancedSearch->load();
        $this->fecha_cierre->AdvancedSearch->load();
        $this->calidad->AdvancedSearch->load();
        $this->factura->AdvancedSearch->load();
        $this->unir_con_expediente->AdvancedSearch->load();
        $this->estatus->AdvancedSearch->load();
        $this->nota->AdvancedSearch->load();
        $this->funeraria->AdvancedSearch->load();
        $this->servicio_tipo->AdvancedSearch->load();
        $this->servicio->AdvancedSearch->load();
        $this->marca_pasos->AdvancedSearch->load();
        $this->peso->AdvancedSearch->load();
        $this->autoriza_cremar->AdvancedSearch->load();
        $this->certificado_defuncion->AdvancedSearch->load();
        $this->parcela->AdvancedSearch->load();
        $this->username_autoriza->AdvancedSearch->load();
        $this->fecha_autoriza->AdvancedSearch->load();
        $this->email_calidad->AdvancedSearch->load();
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
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fsco_expedientelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fsco_expedientelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fsco_expedientelist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
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
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fsco_expedientelist" data-ew-action="email" data-custom="false" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
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
        $item->Visible = true;

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
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsco_expedientesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
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
                case "x_tipo_contratacion":
                    break;
                case "x_seguro":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_nacionalidad_contacto":
                    break;
                case "x_parentesco_contacto":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_nacionalidad_fallecido":
                    break;
                case "x_sexo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estado_civil":
                    break;
                case "x_lugar_ocurrencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_causa_ocurrencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_religion":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_user_registra":
                    break;
                case "x_calidad":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_unir_con_expediente":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_funeraria":
                    break;
                case "x_servicio_tipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_servicio":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_marca_pasos":
                    break;
                case "x_peso":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_autoriza_cremar":
                    break;
                case "x_username_autoriza":
                    break;
                case "x_email_calidad":
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
    	echo legenda();
    	$this->estatus->Visible = false;
        $this->fecha_registro->Visible = false;
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer) {
    	// Example:
    	//$footer = "your footer";
    	echo legenda();
    	$footer = '
            <table width="800" border="0" style="font-family: sans-serif; font-size: 13px; color: #444; border-collapse: separate; border-spacing: 0 8px;">
                <tr>
                    <td width="30" style="background-color: #fe4848; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);">&nbsp;</td>
                    <td style="padding-left: 15px;">
                        <strong>Exp. #</strong> : Indica que <strong>no se ha asignado</strong> ningún servicio.
                    </td>
                </tr>
                <tr>
                    <td width="30" style="background-color: #CC99CC; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);">&nbsp;</td>
                    <td style="padding-left: 15px;">
                        <strong>Exp. #</strong> : El servicio de capilla está <strong>asociado a otro expediente</strong>.
                    </td>
                </tr>
                <tr>
                    <td width="30" style="background-color: #ffff00; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);">&nbsp;</td>
                    <td style="padding-left: 15px;">
                        <strong>Exp. #</strong> : Indica velación en <strong>2 o más capillas</strong>.
                    </td>
                </tr>
                <tr>
                    <td width="30" style="background-color: #009900; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);">&nbsp;</td>
                    <td style="padding-left: 15px;">
                        <strong>Columna Costo</strong> : Indica que el servicio ya está <strong>facturado</strong>.
                    </td>
                </tr>
            </table>';
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
    		$opt = &$this->ListOptions->Add("fec_resg");
    		$opt->Header = "Registro";
    		$opt->OnLeft = FALSE; // Link on left
    		$opt->MoveTo(0); // Move to first column
            /*
    		$opt = &$this->ListOptions->Add("print");
    		$opt->Header = "";
    		$opt->OnLeft = TRUE; // Link on left
    		$opt->MoveTo(6); // Move to first column
            */
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
        if($this->fecha_registro->CurrentValue != "") {
            $this->ListOptions->Items["fec_resg"]->Body = date("d/m/Y h:i:sA", strtotime($this->fecha_registro->CurrentValue));
            // $this->ListOptions->Items["print"]->Body = '<a target="_blank" href="fpdf_report/rptPautaServicios.php?Nexpediente=' . $this->Nexpediente->CurrentValue . '"><span class="glyphicon glyphicon-print"></span></a>';
            if($this->causa_ocurrencia->CurrentValue == "OTRO") {
                $this->causa_ocurrencia->ViewValue = $this->causa_otro->CurrentValue;
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
