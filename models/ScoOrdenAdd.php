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
class ScoOrdenAdd extends ScoOrden
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoOrdenAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoOrdenAdd";

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
        $this->expediente->setVisibility();
        $this->Norden->Visible = false;
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->proveedor->setVisibility();
        $this->responsable_servicio->setVisibility();
        $this->paso->Visible = false;
        $this->nota->setVisibility();
        $this->fecha_inicio->setVisibility();
        $this->hora_inicio->setVisibility();
        $this->horas->setVisibility();
        $this->fecha_fin->setVisibility();
        $this->hora_fin->setVisibility();
        $this->capilla->setVisibility();
        $this->cantidad->setVisibility();
        $this->costo->setVisibility();
        $this->total->setVisibility();
        $this->referencia_ubicacion->setVisibility();
        $this->anulada->setVisibility();
        $this->user_registra->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->media_hora->setVisibility();
        $this->espera_cenizas->setVisibility();
        $this->adjunto->setVisibility();
        $this->llevar_a->setVisibility();
        $this->servicio_atendido->setVisibility();
        $this->ministro->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_orden';
        $this->TableName = 'sco_orden';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_orden)
        if (!isset($GLOBALS["sco_orden"]) || $GLOBALS["sco_orden"]::class == PROJECT_NAMESPACE . "sco_orden") {
            $GLOBALS["sco_orden"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_orden');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                if (
                    SameString($pageName, GetPageName($this->getListUrl())) ||
                    SameString($pageName, GetPageName($this->getViewUrl())) ||
                    SameString($pageName, GetPageName(CurrentMasterTable()?->getViewUrl() ?? ""))
                ) { // List / View / Master View page
                    if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                        $result["caption"] = $this->getModalCaption($pageName);
                        $result["view"] = SameString($pageName, "ScoOrdenView"); // If View page, no primary button
                    } else { // List page
                        $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                        $this->clearFailureMessage();
                    }
                } else { // Other pages (add messages and then clear messages)
                    $result = array_merge($this->getMessages(), ["modal" => "1"]);
                    $this->clearMessages();
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
            $key .= @$ar['Norden'];
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
            $this->Norden->Visible = false;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

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
        $this->CurrentAction = Param("action"); // Set up current action
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

        // Set up lookup cache
        $this->setupLookupOptions($this->servicio_tipo);
        $this->setupLookupOptions($this->servicio);
        $this->setupLookupOptions($this->proveedor);
        $this->setupLookupOptions($this->anulada);
        $this->setupLookupOptions($this->user_registra);
        $this->setupLookupOptions($this->espera_cenizas);
        $this->setupLookupOptions($this->ministro);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("Norden") ?? Route("Norden")) !== null) {
                $this->Norden->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: Must be after loadOldRecord to prevent master key values being overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("ScoOrdenList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "ScoOrdenList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoOrdenView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoOrdenList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoOrdenList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson(["success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->proveedor->DefaultValue = $this->proveedor->getDefault(); // PHP
        $this->proveedor->OldValue = $this->proveedor->DefaultValue;
        $this->paso->DefaultValue = $this->paso->getDefault(); // PHP
        $this->paso->OldValue = $this->paso->DefaultValue;
        $this->cantidad->DefaultValue = $this->cantidad->getDefault(); // PHP
        $this->cantidad->OldValue = $this->cantidad->DefaultValue;
        $this->costo->DefaultValue = $this->costo->getDefault(); // PHP
        $this->costo->OldValue = $this->costo->DefaultValue;
        $this->total->DefaultValue = $this->total->getDefault(); // PHP
        $this->total->OldValue = $this->total->DefaultValue;
        $this->media_hora->DefaultValue = $this->media_hora->getDefault(); // PHP
        $this->media_hora->OldValue = $this->media_hora->DefaultValue;
        $this->espera_cenizas->DefaultValue = $this->espera_cenizas->getDefault(); // PHP
        $this->espera_cenizas->OldValue = $this->espera_cenizas->DefaultValue;
        $this->servicio_atendido->DefaultValue = $this->servicio_atendido->getDefault(); // PHP
        $this->servicio_atendido->OldValue = $this->servicio_atendido->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'expediente' first before field var 'x_expediente'
        $val = $CurrentForm->hasValue("expediente") ? $CurrentForm->getValue("expediente") : $CurrentForm->getValue("x_expediente");
        if (!$this->expediente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expediente->Visible = false; // Disable update for API request
            } else {
                $this->expediente->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'servicio_tipo' first before field var 'x_servicio_tipo'
        $val = $CurrentForm->hasValue("servicio_tipo") ? $CurrentForm->getValue("servicio_tipo") : $CurrentForm->getValue("x_servicio_tipo");
        if (!$this->servicio_tipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->servicio_tipo->Visible = false; // Disable update for API request
            } else {
                $this->servicio_tipo->setFormValue($val);
            }
        }

        // Check field name 'servicio' first before field var 'x_servicio'
        $val = $CurrentForm->hasValue("servicio") ? $CurrentForm->getValue("servicio") : $CurrentForm->getValue("x_servicio");
        if (!$this->servicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->servicio->Visible = false; // Disable update for API request
            } else {
                $this->servicio->setFormValue($val);
            }
        }

        // Check field name 'proveedor' first before field var 'x_proveedor'
        $val = $CurrentForm->hasValue("proveedor") ? $CurrentForm->getValue("proveedor") : $CurrentForm->getValue("x_proveedor");
        if (!$this->proveedor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->proveedor->Visible = false; // Disable update for API request
            } else {
                $this->proveedor->setFormValue($val);
            }
        }

        // Check field name 'responsable_servicio' first before field var 'x_responsable_servicio'
        $val = $CurrentForm->hasValue("responsable_servicio") ? $CurrentForm->getValue("responsable_servicio") : $CurrentForm->getValue("x_responsable_servicio");
        if (!$this->responsable_servicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->responsable_servicio->Visible = false; // Disable update for API request
            } else {
                $this->responsable_servicio->setFormValue($val);
            }
        }

        // Check field name 'nota' first before field var 'x_nota'
        $val = $CurrentForm->hasValue("nota") ? $CurrentForm->getValue("nota") : $CurrentForm->getValue("x_nota");
        if (!$this->nota->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nota->Visible = false; // Disable update for API request
            } else {
                $this->nota->setFormValue($val);
            }
        }

        // Check field name 'fecha_inicio' first before field var 'x_fecha_inicio'
        $val = $CurrentForm->hasValue("fecha_inicio") ? $CurrentForm->getValue("fecha_inicio") : $CurrentForm->getValue("x_fecha_inicio");
        if (!$this->fecha_inicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_inicio->Visible = false; // Disable update for API request
            } else {
                $this->fecha_inicio->setFormValue($val, true, $validate);
            }
            $this->fecha_inicio->CurrentValue = UnFormatDateTime($this->fecha_inicio->CurrentValue, $this->fecha_inicio->formatPattern());
        }

        // Check field name 'hora_inicio' first before field var 'x_hora_inicio'
        $val = $CurrentForm->hasValue("hora_inicio") ? $CurrentForm->getValue("hora_inicio") : $CurrentForm->getValue("x_hora_inicio");
        if (!$this->hora_inicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_inicio->Visible = false; // Disable update for API request
            } else {
                $this->hora_inicio->setFormValue($val, true, $validate);
            }
            $this->hora_inicio->CurrentValue = UnFormatDateTime($this->hora_inicio->CurrentValue, $this->hora_inicio->formatPattern());
        }

        // Check field name 'horas' first before field var 'x_horas'
        $val = $CurrentForm->hasValue("horas") ? $CurrentForm->getValue("horas") : $CurrentForm->getValue("x_horas");
        if (!$this->horas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->horas->Visible = false; // Disable update for API request
            } else {
                $this->horas->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'fecha_fin' first before field var 'x_fecha_fin'
        $val = $CurrentForm->hasValue("fecha_fin") ? $CurrentForm->getValue("fecha_fin") : $CurrentForm->getValue("x_fecha_fin");
        if (!$this->fecha_fin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_fin->Visible = false; // Disable update for API request
            } else {
                $this->fecha_fin->setFormValue($val, true, $validate);
            }
            $this->fecha_fin->CurrentValue = UnFormatDateTime($this->fecha_fin->CurrentValue, $this->fecha_fin->formatPattern());
        }

        // Check field name 'hora_fin' first before field var 'x_hora_fin'
        $val = $CurrentForm->hasValue("hora_fin") ? $CurrentForm->getValue("hora_fin") : $CurrentForm->getValue("x_hora_fin");
        if (!$this->hora_fin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_fin->Visible = false; // Disable update for API request
            } else {
                $this->hora_fin->setFormValue($val, true, $validate);
            }
            $this->hora_fin->CurrentValue = UnFormatDateTime($this->hora_fin->CurrentValue, $this->hora_fin->formatPattern());
        }

        // Check field name 'capilla' first before field var 'x_capilla'
        $val = $CurrentForm->hasValue("capilla") ? $CurrentForm->getValue("capilla") : $CurrentForm->getValue("x_capilla");
        if (!$this->capilla->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->capilla->Visible = false; // Disable update for API request
            } else {
                $this->capilla->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'cantidad' first before field var 'x_cantidad'
        $val = $CurrentForm->hasValue("cantidad") ? $CurrentForm->getValue("cantidad") : $CurrentForm->getValue("x_cantidad");
        if (!$this->cantidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cantidad->Visible = false; // Disable update for API request
            } else {
                $this->cantidad->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'costo' first before field var 'x_costo'
        $val = $CurrentForm->hasValue("costo") ? $CurrentForm->getValue("costo") : $CurrentForm->getValue("x_costo");
        if (!$this->costo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->costo->Visible = false; // Disable update for API request
            } else {
                $this->costo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'total' first before field var 'x_total'
        $val = $CurrentForm->hasValue("total") ? $CurrentForm->getValue("total") : $CurrentForm->getValue("x_total");
        if (!$this->total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total->Visible = false; // Disable update for API request
            } else {
                $this->total->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'referencia_ubicacion' first before field var 'x_referencia_ubicacion'
        $val = $CurrentForm->hasValue("referencia_ubicacion") ? $CurrentForm->getValue("referencia_ubicacion") : $CurrentForm->getValue("x_referencia_ubicacion");
        if (!$this->referencia_ubicacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->referencia_ubicacion->Visible = false; // Disable update for API request
            } else {
                $this->referencia_ubicacion->setFormValue($val);
            }
        }

        // Check field name 'anulada' first before field var 'x_anulada'
        $val = $CurrentForm->hasValue("anulada") ? $CurrentForm->getValue("anulada") : $CurrentForm->getValue("x_anulada");
        if (!$this->anulada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->anulada->Visible = false; // Disable update for API request
            } else {
                $this->anulada->setFormValue($val);
            }
        }

        // Check field name 'user_registra' first before field var 'x_user_registra'
        $val = $CurrentForm->hasValue("user_registra") ? $CurrentForm->getValue("user_registra") : $CurrentForm->getValue("x_user_registra");
        if (!$this->user_registra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_registra->Visible = false; // Disable update for API request
            } else {
                $this->user_registra->setFormValue($val);
            }
        }

        // Check field name 'fecha_registro' first before field var 'x_fecha_registro'
        $val = $CurrentForm->hasValue("fecha_registro") ? $CurrentForm->getValue("fecha_registro") : $CurrentForm->getValue("x_fecha_registro");
        if (!$this->fecha_registro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_registro->Visible = false; // Disable update for API request
            } else {
                $this->fecha_registro->setFormValue($val, true, $validate);
            }
            $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        }

        // Check field name 'media_hora' first before field var 'x_media_hora'
        $val = $CurrentForm->hasValue("media_hora") ? $CurrentForm->getValue("media_hora") : $CurrentForm->getValue("x_media_hora");
        if (!$this->media_hora->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->media_hora->Visible = false; // Disable update for API request
            } else {
                $this->media_hora->setFormValue($val);
            }
        }

        // Check field name 'espera_cenizas' first before field var 'x_espera_cenizas'
        $val = $CurrentForm->hasValue("espera_cenizas") ? $CurrentForm->getValue("espera_cenizas") : $CurrentForm->getValue("x_espera_cenizas");
        if (!$this->espera_cenizas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->espera_cenizas->Visible = false; // Disable update for API request
            } else {
                $this->espera_cenizas->setFormValue($val);
            }
        }

        // Check field name 'adjunto' first before field var 'x_adjunto'
        $val = $CurrentForm->hasValue("adjunto") ? $CurrentForm->getValue("adjunto") : $CurrentForm->getValue("x_adjunto");
        if (!$this->adjunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->adjunto->Visible = false; // Disable update for API request
            } else {
                $this->adjunto->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'llevar_a' first before field var 'x_llevar_a'
        $val = $CurrentForm->hasValue("llevar_a") ? $CurrentForm->getValue("llevar_a") : $CurrentForm->getValue("x_llevar_a");
        if (!$this->llevar_a->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->llevar_a->Visible = false; // Disable update for API request
            } else {
                $this->llevar_a->setFormValue($val);
            }
        }

        // Check field name 'servicio_atendido' first before field var 'x_servicio_atendido'
        $val = $CurrentForm->hasValue("servicio_atendido") ? $CurrentForm->getValue("servicio_atendido") : $CurrentForm->getValue("x_servicio_atendido");
        if (!$this->servicio_atendido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->servicio_atendido->Visible = false; // Disable update for API request
            } else {
                $this->servicio_atendido->setFormValue($val);
            }
        }

        // Check field name 'Norden' first before field var 'x_Norden'
        $val = $CurrentForm->hasValue("Norden") ? $CurrentForm->getValue("Norden") : $CurrentForm->getValue("x_Norden");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->expediente->CurrentValue = $this->expediente->FormValue;
        $this->servicio_tipo->CurrentValue = $this->servicio_tipo->FormValue;
        $this->servicio->CurrentValue = $this->servicio->FormValue;
        $this->proveedor->CurrentValue = $this->proveedor->FormValue;
        $this->responsable_servicio->CurrentValue = $this->responsable_servicio->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->fecha_inicio->CurrentValue = $this->fecha_inicio->FormValue;
        $this->fecha_inicio->CurrentValue = UnFormatDateTime($this->fecha_inicio->CurrentValue, $this->fecha_inicio->formatPattern());
        $this->hora_inicio->CurrentValue = $this->hora_inicio->FormValue;
        $this->hora_inicio->CurrentValue = UnFormatDateTime($this->hora_inicio->CurrentValue, $this->hora_inicio->formatPattern());
        $this->horas->CurrentValue = $this->horas->FormValue;
        $this->fecha_fin->CurrentValue = $this->fecha_fin->FormValue;
        $this->fecha_fin->CurrentValue = UnFormatDateTime($this->fecha_fin->CurrentValue, $this->fecha_fin->formatPattern());
        $this->hora_fin->CurrentValue = $this->hora_fin->FormValue;
        $this->hora_fin->CurrentValue = UnFormatDateTime($this->hora_fin->CurrentValue, $this->hora_fin->formatPattern());
        $this->capilla->CurrentValue = $this->capilla->FormValue;
        $this->cantidad->CurrentValue = $this->cantidad->FormValue;
        $this->costo->CurrentValue = $this->costo->FormValue;
        $this->total->CurrentValue = $this->total->FormValue;
        $this->referencia_ubicacion->CurrentValue = $this->referencia_ubicacion->FormValue;
        $this->anulada->CurrentValue = $this->anulada->FormValue;
        $this->user_registra->CurrentValue = $this->user_registra->FormValue;
        $this->fecha_registro->CurrentValue = $this->fecha_registro->FormValue;
        $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->media_hora->CurrentValue = $this->media_hora->FormValue;
        $this->espera_cenizas->CurrentValue = $this->espera_cenizas->FormValue;
        $this->adjunto->CurrentValue = $this->adjunto->FormValue;
        $this->llevar_a->CurrentValue = $this->llevar_a->FormValue;
        $this->servicio_atendido->CurrentValue = $this->servicio_atendido->FormValue;
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
        $this->expediente->setDbValue($row['expediente']);
        $this->Norden->setDbValue($row['Norden']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->responsable_servicio->setDbValue($row['responsable_servicio']);
        $this->paso->setDbValue($row['paso']);
        $this->nota->setDbValue($row['nota']);
        $this->fecha_inicio->setDbValue($row['fecha_inicio']);
        $this->hora_inicio->setDbValue($row['hora_inicio']);
        $this->horas->setDbValue($row['horas']);
        $this->fecha_fin->setDbValue($row['fecha_fin']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->capilla->setDbValue($row['capilla']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->costo->setDbValue($row['costo']);
        $this->total->setDbValue($row['total']);
        $this->referencia_ubicacion->setDbValue($row['referencia_ubicacion']);
        $this->anulada->setDbValue($row['anulada']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->media_hora->setDbValue($row['media_hora']);
        $this->espera_cenizas->setDbValue($row['espera_cenizas']);
        $this->adjunto->setDbValue($row['adjunto']);
        $this->llevar_a->setDbValue($row['llevar_a']);
        $this->servicio_atendido->setDbValue($row['servicio_atendido']);
        $this->ministro->setDbValue($row['ministro']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['Norden'] = $this->Norden->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['proveedor'] = $this->proveedor->DefaultValue;
        $row['responsable_servicio'] = $this->responsable_servicio->DefaultValue;
        $row['paso'] = $this->paso->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['fecha_inicio'] = $this->fecha_inicio->DefaultValue;
        $row['hora_inicio'] = $this->hora_inicio->DefaultValue;
        $row['horas'] = $this->horas->DefaultValue;
        $row['fecha_fin'] = $this->fecha_fin->DefaultValue;
        $row['hora_fin'] = $this->hora_fin->DefaultValue;
        $row['capilla'] = $this->capilla->DefaultValue;
        $row['cantidad'] = $this->cantidad->DefaultValue;
        $row['costo'] = $this->costo->DefaultValue;
        $row['total'] = $this->total->DefaultValue;
        $row['referencia_ubicacion'] = $this->referencia_ubicacion->DefaultValue;
        $row['anulada'] = $this->anulada->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['media_hora'] = $this->media_hora->DefaultValue;
        $row['espera_cenizas'] = $this->espera_cenizas->DefaultValue;
        $row['adjunto'] = $this->adjunto->DefaultValue;
        $row['llevar_a'] = $this->llevar_a->DefaultValue;
        $row['servicio_atendido'] = $this->servicio_atendido->DefaultValue;
        $row['ministro'] = $this->ministro->DefaultValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // expediente
        $this->expediente->RowCssClass = "row";

        // Norden
        $this->Norden->RowCssClass = "row";

        // servicio_tipo
        $this->servicio_tipo->RowCssClass = "row";

        // servicio
        $this->servicio->RowCssClass = "row";

        // proveedor
        $this->proveedor->RowCssClass = "row";

        // responsable_servicio
        $this->responsable_servicio->RowCssClass = "row";

        // paso
        $this->paso->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // fecha_inicio
        $this->fecha_inicio->RowCssClass = "row";

        // hora_inicio
        $this->hora_inicio->RowCssClass = "row";

        // horas
        $this->horas->RowCssClass = "row";

        // fecha_fin
        $this->fecha_fin->RowCssClass = "row";

        // hora_fin
        $this->hora_fin->RowCssClass = "row";

        // capilla
        $this->capilla->RowCssClass = "row";

        // cantidad
        $this->cantidad->RowCssClass = "row";

        // costo
        $this->costo->RowCssClass = "row";

        // total
        $this->total->RowCssClass = "row";

        // referencia_ubicacion
        $this->referencia_ubicacion->RowCssClass = "row";

        // anulada
        $this->anulada->RowCssClass = "row";

        // user_registra
        $this->user_registra->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // media_hora
        $this->media_hora->RowCssClass = "row";

        // espera_cenizas
        $this->espera_cenizas->RowCssClass = "row";

        // adjunto
        $this->adjunto->RowCssClass = "row";

        // llevar_a
        $this->llevar_a->RowCssClass = "row";

        // servicio_atendido
        $this->servicio_atendido->RowCssClass = "row";

        // ministro
        $this->ministro->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // Norden
            $this->Norden->ViewValue = $this->Norden->CurrentValue;

            // servicio_tipo
            $curVal = strval($this->servicio_tipo->CurrentValue);
            if ($curVal != "") {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
                if ($this->servicio_tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $curVal, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                    $sqlWrk = $this->servicio_tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
                    $sqlWrk = $this->servicio->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // responsable_servicio
            $this->responsable_servicio->ViewValue = $this->responsable_servicio->CurrentValue;

            // paso
            $this->paso->ViewValue = $this->paso->CurrentValue;

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // fecha_inicio
            $this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;
            $this->fecha_inicio->ViewValue = FormatDateTime($this->fecha_inicio->ViewValue, $this->fecha_inicio->formatPattern());

            // hora_inicio
            $this->hora_inicio->ViewValue = $this->hora_inicio->CurrentValue;
            $this->hora_inicio->ViewValue = FormatDateTime($this->hora_inicio->ViewValue, $this->hora_inicio->formatPattern());

            // horas
            $this->horas->ViewValue = $this->horas->CurrentValue;

            // fecha_fin
            $this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;
            $this->fecha_fin->ViewValue = FormatDateTime($this->fecha_fin->ViewValue, $this->fecha_fin->formatPattern());

            // hora_fin
            $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;

            // capilla
            $this->capilla->ViewValue = $this->capilla->CurrentValue;

            // cantidad
            $this->cantidad->ViewValue = $this->cantidad->CurrentValue;

            // costo
            $this->costo->ViewValue = $this->costo->CurrentValue;
            $this->costo->ViewValue = FormatCurrency($this->costo->ViewValue, $this->costo->formatPattern());

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatCurrency($this->total->ViewValue, $this->total->formatPattern());

            // referencia_ubicacion
            $this->referencia_ubicacion->ViewValue = $this->referencia_ubicacion->CurrentValue;

            // anulada
            if (strval($this->anulada->CurrentValue) != "") {
                $this->anulada->ViewValue = $this->anulada->optionCaption($this->anulada->CurrentValue);
            } else {
                $this->anulada->ViewValue = null;
            }

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

            // media_hora
            $this->media_hora->ViewValue = $this->media_hora->CurrentValue;

            // espera_cenizas
            if (strval($this->espera_cenizas->CurrentValue) != "") {
                $this->espera_cenizas->ViewValue = $this->espera_cenizas->optionCaption($this->espera_cenizas->CurrentValue);
            } else {
                $this->espera_cenizas->ViewValue = null;
            }

            // adjunto
            $this->adjunto->ViewValue = $this->adjunto->CurrentValue;

            // llevar_a
            $this->llevar_a->ViewValue = $this->llevar_a->CurrentValue;

            // servicio_atendido
            $this->servicio_atendido->ViewValue = $this->servicio_atendido->CurrentValue;

            // ministro
            $this->ministro->ViewValue = $this->ministro->CurrentValue;
            $curVal = strval($this->ministro->CurrentValue);
            if ($curVal != "") {
                $this->ministro->ViewValue = $this->ministro->lookupCacheOption($curVal);
                if ($this->ministro->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->ministro->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->ministro->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->ministro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ministro->Lookup->renderViewRow($rswrk[0]);
                        $this->ministro->ViewValue = $this->ministro->displayValue($arwrk);
                    } else {
                        $this->ministro->ViewValue = $this->ministro->CurrentValue;
                    }
                }
            } else {
                $this->ministro->ViewValue = null;
            }

            // expediente
            if (!EmptyValue($this->expediente->CurrentValue)) {
                $this->expediente->HrefValue = $this->expediente->getLinkPrefix() . $this->expediente->CurrentValue; // Add prefix/suffix
                $this->expediente->LinkAttrs["target"] = "_self"; // Add target
                if ($this->isExport()) {
                    $this->expediente->HrefValue = FullUrl($this->expediente->HrefValue, "href");
                }
            } else {
                $this->expediente->HrefValue = "";
            }
            $this->expediente->TooltipValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // proveedor
            $this->proveedor->HrefValue = "";

            // responsable_servicio
            $this->responsable_servicio->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // fecha_inicio
            $this->fecha_inicio->HrefValue = "";

            // hora_inicio
            $this->hora_inicio->HrefValue = "";

            // horas
            $this->horas->HrefValue = "";

            // fecha_fin
            $this->fecha_fin->HrefValue = "";

            // hora_fin
            $this->hora_fin->HrefValue = "";

            // capilla
            $this->capilla->HrefValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";

            // costo
            $this->costo->HrefValue = "";

            // total
            $this->total->HrefValue = "";

            // referencia_ubicacion
            $this->referencia_ubicacion->HrefValue = "";

            // anulada
            $this->anulada->HrefValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";

            // media_hora
            $this->media_hora->HrefValue = "";

            // espera_cenizas
            $this->espera_cenizas->HrefValue = "";

            // adjunto
            $this->adjunto->HrefValue = "";

            // llevar_a
            $this->llevar_a->HrefValue = "";

            // servicio_atendido
            $this->servicio_atendido->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // expediente
            $this->expediente->setupEditAttributes();
            if ($this->expediente->getSessionValue() != "") {
                $this->expediente->CurrentValue = GetForeignKeyValue($this->expediente->getSessionValue());
                $this->expediente->ViewValue = $this->expediente->CurrentValue;
            } else {
                $this->expediente->EditValue = $this->expediente->CurrentValue;
                $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());
                if (strval($this->expediente->EditValue) != "" && is_numeric($this->expediente->EditValue)) {
                    $this->expediente->EditValue = $this->expediente->EditValue;
                }
            }

            // servicio_tipo
            $this->servicio_tipo->setupEditAttributes();
            $curVal = trim(strval($this->servicio_tipo->CurrentValue));
            if ($curVal != "") {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
            } else {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->Lookup !== null && is_array($this->servicio_tipo->lookupOptions()) && count($this->servicio_tipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->servicio_tipo->ViewValue !== null) { // Load from cache
                $this->servicio_tipo->EditValue = array_values($this->servicio_tipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $this->servicio_tipo->CurrentValue, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                }
                $sqlWrk = $this->servicio_tipo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->servicio_tipo->EditValue = $arwrk;
            }
            $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

            // servicio
            $this->servicio->setupEditAttributes();
            $curVal = trim(strval($this->servicio->CurrentValue));
            if ($curVal != "") {
                $this->servicio->ViewValue = $this->servicio->lookupCacheOption($curVal);
            } else {
                $this->servicio->ViewValue = $this->servicio->Lookup !== null && is_array($this->servicio->lookupOptions()) && count($this->servicio->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->servicio->ViewValue !== null) { // Load from cache
                $this->servicio->EditValue = array_values($this->servicio->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchExpression(), "=", $this->servicio->CurrentValue, $this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchDataType(), "");
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

            // proveedor
            $this->proveedor->setupEditAttributes();
            $curVal = trim(strval($this->proveedor->CurrentValue));
            if ($curVal != "") {
                $this->proveedor->ViewValue = $this->proveedor->lookupCacheOption($curVal);
            } else {
                $this->proveedor->ViewValue = $this->proveedor->Lookup !== null && is_array($this->proveedor->lookupOptions()) && count($this->proveedor->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->proveedor->ViewValue !== null) { // Load from cache
                $this->proveedor->EditValue = array_values($this->proveedor->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $this->proveedor->CurrentValue, $this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                }
                $sqlWrk = $this->proveedor->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->proveedor->EditValue = $arwrk;
            }
            $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());

            // responsable_servicio
            $this->responsable_servicio->setupEditAttributes();
            if (!$this->responsable_servicio->Raw) {
                $this->responsable_servicio->CurrentValue = HtmlDecode($this->responsable_servicio->CurrentValue);
            }
            $this->responsable_servicio->EditValue = HtmlEncode($this->responsable_servicio->CurrentValue);
            $this->responsable_servicio->PlaceHolder = RemoveHtml($this->responsable_servicio->caption());

            // nota
            $this->nota->setupEditAttributes();
            if (!$this->nota->Raw) {
                $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
            }
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // fecha_inicio
            $this->fecha_inicio->setupEditAttributes();
            $this->fecha_inicio->EditValue = HtmlEncode(FormatDateTime($this->fecha_inicio->CurrentValue, $this->fecha_inicio->formatPattern()));
            $this->fecha_inicio->PlaceHolder = RemoveHtml($this->fecha_inicio->caption());

            // hora_inicio
            $this->hora_inicio->setupEditAttributes();
            $this->hora_inicio->EditValue = HtmlEncode(FormatDateTime($this->hora_inicio->CurrentValue, $this->hora_inicio->formatPattern()));
            $this->hora_inicio->PlaceHolder = RemoveHtml($this->hora_inicio->caption());

            // horas
            $this->horas->setupEditAttributes();
            $this->horas->EditValue = $this->horas->CurrentValue;
            $this->horas->PlaceHolder = RemoveHtml($this->horas->caption());
            if (strval($this->horas->EditValue) != "" && is_numeric($this->horas->EditValue)) {
                $this->horas->EditValue = $this->horas->EditValue;
            }

            // fecha_fin
            $this->fecha_fin->setupEditAttributes();
            $this->fecha_fin->EditValue = HtmlEncode(FormatDateTime($this->fecha_fin->CurrentValue, $this->fecha_fin->formatPattern()));
            $this->fecha_fin->PlaceHolder = RemoveHtml($this->fecha_fin->caption());

            // hora_fin
            $this->hora_fin->setupEditAttributes();
            $this->hora_fin->EditValue = HtmlEncode($this->hora_fin->CurrentValue);
            $this->hora_fin->PlaceHolder = RemoveHtml($this->hora_fin->caption());

            // capilla
            $this->capilla->setupEditAttributes();
            $this->capilla->EditValue = $this->capilla->CurrentValue;
            $this->capilla->PlaceHolder = RemoveHtml($this->capilla->caption());
            if (strval($this->capilla->EditValue) != "" && is_numeric($this->capilla->EditValue)) {
                $this->capilla->EditValue = $this->capilla->EditValue;
            }

            // cantidad
            $this->cantidad->setupEditAttributes();
            $this->cantidad->EditValue = $this->cantidad->CurrentValue;
            $this->cantidad->PlaceHolder = RemoveHtml($this->cantidad->caption());
            if (strval($this->cantidad->EditValue) != "" && is_numeric($this->cantidad->EditValue)) {
                $this->cantidad->EditValue = $this->cantidad->EditValue;
            }

            // costo
            $this->costo->setupEditAttributes();
            $this->costo->EditValue = $this->costo->CurrentValue;
            $this->costo->PlaceHolder = RemoveHtml($this->costo->caption());
            if (strval($this->costo->EditValue) != "" && is_numeric($this->costo->EditValue)) {
                $this->costo->EditValue = FormatNumber($this->costo->EditValue, null);
            }

            // total
            $this->total->setupEditAttributes();
            $this->total->EditValue = $this->total->CurrentValue;
            $this->total->PlaceHolder = RemoveHtml($this->total->caption());
            if (strval($this->total->EditValue) != "" && is_numeric($this->total->EditValue)) {
                $this->total->EditValue = FormatNumber($this->total->EditValue, null);
            }

            // referencia_ubicacion
            $this->referencia_ubicacion->setupEditAttributes();
            if (!$this->referencia_ubicacion->Raw) {
                $this->referencia_ubicacion->CurrentValue = HtmlDecode($this->referencia_ubicacion->CurrentValue);
            }
            $this->referencia_ubicacion->EditValue = HtmlEncode($this->referencia_ubicacion->CurrentValue);
            $this->referencia_ubicacion->PlaceHolder = RemoveHtml($this->referencia_ubicacion->caption());

            // anulada
            $this->anulada->setupEditAttributes();
            $this->anulada->EditValue = $this->anulada->options(true);
            $this->anulada->PlaceHolder = RemoveHtml($this->anulada->caption());

            // user_registra
            $this->user_registra->setupEditAttributes();
            if (!$this->user_registra->Raw) {
                $this->user_registra->CurrentValue = HtmlDecode($this->user_registra->CurrentValue);
            }
            $this->user_registra->EditValue = HtmlEncode($this->user_registra->CurrentValue);
            $curVal = strval($this->user_registra->CurrentValue);
            if ($curVal != "") {
                $this->user_registra->EditValue = $this->user_registra->lookupCacheOption($curVal);
                if ($this->user_registra->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->user_registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->user_registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->user_registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->user_registra->Lookup->renderViewRow($rswrk[0]);
                        $this->user_registra->EditValue = $this->user_registra->displayValue($arwrk);
                    } else {
                        $this->user_registra->EditValue = HtmlEncode($this->user_registra->CurrentValue);
                    }
                }
            } else {
                $this->user_registra->EditValue = null;
            }
            $this->user_registra->PlaceHolder = RemoveHtml($this->user_registra->caption());

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = HtmlEncode(FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern()));
            $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

            // media_hora
            $this->media_hora->setupEditAttributes();
            if (!$this->media_hora->Raw) {
                $this->media_hora->CurrentValue = HtmlDecode($this->media_hora->CurrentValue);
            }
            $this->media_hora->EditValue = HtmlEncode($this->media_hora->CurrentValue);
            $this->media_hora->PlaceHolder = RemoveHtml($this->media_hora->caption());

            // espera_cenizas
            $this->espera_cenizas->setupEditAttributes();
            $this->espera_cenizas->EditValue = $this->espera_cenizas->options(true);
            $this->espera_cenizas->PlaceHolder = RemoveHtml($this->espera_cenizas->caption());

            // adjunto
            $this->adjunto->setupEditAttributes();
            $this->adjunto->EditValue = $this->adjunto->CurrentValue;
            $this->adjunto->PlaceHolder = RemoveHtml($this->adjunto->caption());
            if (strval($this->adjunto->EditValue) != "" && is_numeric($this->adjunto->EditValue)) {
                $this->adjunto->EditValue = $this->adjunto->EditValue;
            }

            // llevar_a
            $this->llevar_a->setupEditAttributes();
            if (!$this->llevar_a->Raw) {
                $this->llevar_a->CurrentValue = HtmlDecode($this->llevar_a->CurrentValue);
            }
            $this->llevar_a->EditValue = HtmlEncode($this->llevar_a->CurrentValue);
            $this->llevar_a->PlaceHolder = RemoveHtml($this->llevar_a->caption());

            // servicio_atendido
            $this->servicio_atendido->setupEditAttributes();
            if (!$this->servicio_atendido->Raw) {
                $this->servicio_atendido->CurrentValue = HtmlDecode($this->servicio_atendido->CurrentValue);
            }
            $this->servicio_atendido->EditValue = HtmlEncode($this->servicio_atendido->CurrentValue);
            $this->servicio_atendido->PlaceHolder = RemoveHtml($this->servicio_atendido->caption());

            // Add refer script

            // expediente
            if (!EmptyValue($this->expediente->CurrentValue)) {
                $this->expediente->HrefValue = $this->expediente->getLinkPrefix() . $this->expediente->CurrentValue; // Add prefix/suffix
                $this->expediente->LinkAttrs["target"] = "_self"; // Add target
                if ($this->isExport()) {
                    $this->expediente->HrefValue = FullUrl($this->expediente->HrefValue, "href");
                }
            } else {
                $this->expediente->HrefValue = "";
            }

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // proveedor
            $this->proveedor->HrefValue = "";

            // responsable_servicio
            $this->responsable_servicio->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // fecha_inicio
            $this->fecha_inicio->HrefValue = "";

            // hora_inicio
            $this->hora_inicio->HrefValue = "";

            // horas
            $this->horas->HrefValue = "";

            // fecha_fin
            $this->fecha_fin->HrefValue = "";

            // hora_fin
            $this->hora_fin->HrefValue = "";

            // capilla
            $this->capilla->HrefValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";

            // costo
            $this->costo->HrefValue = "";

            // total
            $this->total->HrefValue = "";

            // referencia_ubicacion
            $this->referencia_ubicacion->HrefValue = "";

            // anulada
            $this->anulada->HrefValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";

            // media_hora
            $this->media_hora->HrefValue = "";

            // espera_cenizas
            $this->espera_cenizas->HrefValue = "";

            // adjunto
            $this->adjunto->HrefValue = "";

            // llevar_a
            $this->llevar_a->HrefValue = "";

            // servicio_atendido
            $this->servicio_atendido->HrefValue = "";
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
            if ($this->expediente->Visible && $this->expediente->Required) {
                if (!$this->expediente->IsDetailKey && EmptyValue($this->expediente->FormValue)) {
                    $this->expediente->addErrorMessage(str_replace("%s", $this->expediente->caption(), $this->expediente->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->expediente->FormValue)) {
                $this->expediente->addErrorMessage($this->expediente->getErrorMessage(false));
            }
            if ($this->servicio_tipo->Visible && $this->servicio_tipo->Required) {
                if (!$this->servicio_tipo->IsDetailKey && EmptyValue($this->servicio_tipo->FormValue)) {
                    $this->servicio_tipo->addErrorMessage(str_replace("%s", $this->servicio_tipo->caption(), $this->servicio_tipo->RequiredErrorMessage));
                }
            }
            if ($this->servicio->Visible && $this->servicio->Required) {
                if (!$this->servicio->IsDetailKey && EmptyValue($this->servicio->FormValue)) {
                    $this->servicio->addErrorMessage(str_replace("%s", $this->servicio->caption(), $this->servicio->RequiredErrorMessage));
                }
            }
            if ($this->proveedor->Visible && $this->proveedor->Required) {
                if (!$this->proveedor->IsDetailKey && EmptyValue($this->proveedor->FormValue)) {
                    $this->proveedor->addErrorMessage(str_replace("%s", $this->proveedor->caption(), $this->proveedor->RequiredErrorMessage));
                }
            }
            if ($this->responsable_servicio->Visible && $this->responsable_servicio->Required) {
                if (!$this->responsable_servicio->IsDetailKey && EmptyValue($this->responsable_servicio->FormValue)) {
                    $this->responsable_servicio->addErrorMessage(str_replace("%s", $this->responsable_servicio->caption(), $this->responsable_servicio->RequiredErrorMessage));
                }
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->fecha_inicio->Visible && $this->fecha_inicio->Required) {
                if (!$this->fecha_inicio->IsDetailKey && EmptyValue($this->fecha_inicio->FormValue)) {
                    $this->fecha_inicio->addErrorMessage(str_replace("%s", $this->fecha_inicio->caption(), $this->fecha_inicio->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_inicio->FormValue, $this->fecha_inicio->formatPattern())) {
                $this->fecha_inicio->addErrorMessage($this->fecha_inicio->getErrorMessage(false));
            }
            if ($this->hora_inicio->Visible && $this->hora_inicio->Required) {
                if (!$this->hora_inicio->IsDetailKey && EmptyValue($this->hora_inicio->FormValue)) {
                    $this->hora_inicio->addErrorMessage(str_replace("%s", $this->hora_inicio->caption(), $this->hora_inicio->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->hora_inicio->FormValue, $this->hora_inicio->formatPattern())) {
                $this->hora_inicio->addErrorMessage($this->hora_inicio->getErrorMessage(false));
            }
            if ($this->horas->Visible && $this->horas->Required) {
                if (!$this->horas->IsDetailKey && EmptyValue($this->horas->FormValue)) {
                    $this->horas->addErrorMessage(str_replace("%s", $this->horas->caption(), $this->horas->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->horas->FormValue)) {
                $this->horas->addErrorMessage($this->horas->getErrorMessage(false));
            }
            if ($this->fecha_fin->Visible && $this->fecha_fin->Required) {
                if (!$this->fecha_fin->IsDetailKey && EmptyValue($this->fecha_fin->FormValue)) {
                    $this->fecha_fin->addErrorMessage(str_replace("%s", $this->fecha_fin->caption(), $this->fecha_fin->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_fin->FormValue, $this->fecha_fin->formatPattern())) {
                $this->fecha_fin->addErrorMessage($this->fecha_fin->getErrorMessage(false));
            }
            if ($this->hora_fin->Visible && $this->hora_fin->Required) {
                if (!$this->hora_fin->IsDetailKey && EmptyValue($this->hora_fin->FormValue)) {
                    $this->hora_fin->addErrorMessage(str_replace("%s", $this->hora_fin->caption(), $this->hora_fin->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->hora_fin->FormValue, $this->hora_fin->formatPattern())) {
                $this->hora_fin->addErrorMessage($this->hora_fin->getErrorMessage(false));
            }
            if ($this->capilla->Visible && $this->capilla->Required) {
                if (!$this->capilla->IsDetailKey && EmptyValue($this->capilla->FormValue)) {
                    $this->capilla->addErrorMessage(str_replace("%s", $this->capilla->caption(), $this->capilla->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->capilla->FormValue)) {
                $this->capilla->addErrorMessage($this->capilla->getErrorMessage(false));
            }
            if ($this->cantidad->Visible && $this->cantidad->Required) {
                if (!$this->cantidad->IsDetailKey && EmptyValue($this->cantidad->FormValue)) {
                    $this->cantidad->addErrorMessage(str_replace("%s", $this->cantidad->caption(), $this->cantidad->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->cantidad->FormValue)) {
                $this->cantidad->addErrorMessage($this->cantidad->getErrorMessage(false));
            }
            if ($this->costo->Visible && $this->costo->Required) {
                if (!$this->costo->IsDetailKey && EmptyValue($this->costo->FormValue)) {
                    $this->costo->addErrorMessage(str_replace("%s", $this->costo->caption(), $this->costo->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->costo->FormValue)) {
                $this->costo->addErrorMessage($this->costo->getErrorMessage(false));
            }
            if ($this->total->Visible && $this->total->Required) {
                if (!$this->total->IsDetailKey && EmptyValue($this->total->FormValue)) {
                    $this->total->addErrorMessage(str_replace("%s", $this->total->caption(), $this->total->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->total->FormValue)) {
                $this->total->addErrorMessage($this->total->getErrorMessage(false));
            }
            if ($this->referencia_ubicacion->Visible && $this->referencia_ubicacion->Required) {
                if (!$this->referencia_ubicacion->IsDetailKey && EmptyValue($this->referencia_ubicacion->FormValue)) {
                    $this->referencia_ubicacion->addErrorMessage(str_replace("%s", $this->referencia_ubicacion->caption(), $this->referencia_ubicacion->RequiredErrorMessage));
                }
            }
            if ($this->anulada->Visible && $this->anulada->Required) {
                if (!$this->anulada->IsDetailKey && EmptyValue($this->anulada->FormValue)) {
                    $this->anulada->addErrorMessage(str_replace("%s", $this->anulada->caption(), $this->anulada->RequiredErrorMessage));
                }
            }
            if ($this->user_registra->Visible && $this->user_registra->Required) {
                if (!$this->user_registra->IsDetailKey && EmptyValue($this->user_registra->FormValue)) {
                    $this->user_registra->addErrorMessage(str_replace("%s", $this->user_registra->caption(), $this->user_registra->RequiredErrorMessage));
                }
            }
            if ($this->fecha_registro->Visible && $this->fecha_registro->Required) {
                if (!$this->fecha_registro->IsDetailKey && EmptyValue($this->fecha_registro->FormValue)) {
                    $this->fecha_registro->addErrorMessage(str_replace("%s", $this->fecha_registro->caption(), $this->fecha_registro->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_registro->FormValue, $this->fecha_registro->formatPattern())) {
                $this->fecha_registro->addErrorMessage($this->fecha_registro->getErrorMessage(false));
            }
            if ($this->media_hora->Visible && $this->media_hora->Required) {
                if (!$this->media_hora->IsDetailKey && EmptyValue($this->media_hora->FormValue)) {
                    $this->media_hora->addErrorMessage(str_replace("%s", $this->media_hora->caption(), $this->media_hora->RequiredErrorMessage));
                }
            }
            if ($this->espera_cenizas->Visible && $this->espera_cenizas->Required) {
                if (!$this->espera_cenizas->IsDetailKey && EmptyValue($this->espera_cenizas->FormValue)) {
                    $this->espera_cenizas->addErrorMessage(str_replace("%s", $this->espera_cenizas->caption(), $this->espera_cenizas->RequiredErrorMessage));
                }
            }
            if ($this->adjunto->Visible && $this->adjunto->Required) {
                if (!$this->adjunto->IsDetailKey && EmptyValue($this->adjunto->FormValue)) {
                    $this->adjunto->addErrorMessage(str_replace("%s", $this->adjunto->caption(), $this->adjunto->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->adjunto->FormValue)) {
                $this->adjunto->addErrorMessage($this->adjunto->getErrorMessage(false));
            }
            if ($this->llevar_a->Visible && $this->llevar_a->Required) {
                if (!$this->llevar_a->IsDetailKey && EmptyValue($this->llevar_a->FormValue)) {
                    $this->llevar_a->addErrorMessage(str_replace("%s", $this->llevar_a->caption(), $this->llevar_a->RequiredErrorMessage));
                }
            }
            if ($this->servicio_atendido->Visible && $this->servicio_atendido->Required) {
                if (!$this->servicio_atendido->IsDetailKey && EmptyValue($this->servicio_atendido->FormValue)) {
                    $this->servicio_atendido->addErrorMessage(str_replace("%s", $this->servicio_atendido->caption(), $this->servicio_atendido->RequiredErrorMessage));
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

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
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

        // expediente
        $this->expediente->setDbValueDef($rsnew, $this->expediente->CurrentValue, false);

        // servicio_tipo
        $this->servicio_tipo->setDbValueDef($rsnew, $this->servicio_tipo->CurrentValue, false);

        // servicio
        $this->servicio->setDbValueDef($rsnew, $this->servicio->CurrentValue, false);

        // proveedor
        $this->proveedor->setDbValueDef($rsnew, $this->proveedor->CurrentValue, strval($this->proveedor->CurrentValue) == "");

        // responsable_servicio
        $this->responsable_servicio->setDbValueDef($rsnew, $this->responsable_servicio->CurrentValue, false);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, false);

        // fecha_inicio
        $this->fecha_inicio->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_inicio->CurrentValue, $this->fecha_inicio->formatPattern()), false);

        // hora_inicio
        $this->hora_inicio->setDbValueDef($rsnew, UnFormatDateTime($this->hora_inicio->CurrentValue, $this->hora_inicio->formatPattern()), false);

        // horas
        $this->horas->setDbValueDef($rsnew, $this->horas->CurrentValue, false);

        // fecha_fin
        $this->fecha_fin->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_fin->CurrentValue, $this->fecha_fin->formatPattern()), false);

        // hora_fin
        $this->hora_fin->setDbValueDef($rsnew, $this->hora_fin->CurrentValue, false);

        // capilla
        $this->capilla->setDbValueDef($rsnew, $this->capilla->CurrentValue, false);

        // cantidad
        $this->cantidad->setDbValueDef($rsnew, $this->cantidad->CurrentValue, strval($this->cantidad->CurrentValue) == "");

        // costo
        $this->costo->setDbValueDef($rsnew, $this->costo->CurrentValue, strval($this->costo->CurrentValue) == "");

        // total
        $this->total->setDbValueDef($rsnew, $this->total->CurrentValue, strval($this->total->CurrentValue) == "");

        // referencia_ubicacion
        $this->referencia_ubicacion->setDbValueDef($rsnew, $this->referencia_ubicacion->CurrentValue, false);

        // anulada
        $this->anulada->setDbValueDef($rsnew, $this->anulada->CurrentValue, false);

        // user_registra
        $this->user_registra->setDbValueDef($rsnew, $this->user_registra->CurrentValue, false);

        // fecha_registro
        $this->fecha_registro->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern()), false);

        // media_hora
        $this->media_hora->setDbValueDef($rsnew, $this->media_hora->CurrentValue, strval($this->media_hora->CurrentValue) == "");

        // espera_cenizas
        $this->espera_cenizas->setDbValueDef($rsnew, $this->espera_cenizas->CurrentValue, strval($this->espera_cenizas->CurrentValue) == "");

        // adjunto
        $this->adjunto->setDbValueDef($rsnew, $this->adjunto->CurrentValue, false);

        // llevar_a
        $this->llevar_a->setDbValueDef($rsnew, $this->llevar_a->CurrentValue, false);

        // servicio_atendido
        $this->servicio_atendido->setDbValueDef($rsnew, $this->servicio_atendido->CurrentValue, strval($this->servicio_atendido->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['expediente'])) { // expediente
            $this->expediente->setFormValue($row['expediente']);
        }
        if (isset($row['servicio_tipo'])) { // servicio_tipo
            $this->servicio_tipo->setFormValue($row['servicio_tipo']);
        }
        if (isset($row['servicio'])) { // servicio
            $this->servicio->setFormValue($row['servicio']);
        }
        if (isset($row['proveedor'])) { // proveedor
            $this->proveedor->setFormValue($row['proveedor']);
        }
        if (isset($row['responsable_servicio'])) { // responsable_servicio
            $this->responsable_servicio->setFormValue($row['responsable_servicio']);
        }
        if (isset($row['nota'])) { // nota
            $this->nota->setFormValue($row['nota']);
        }
        if (isset($row['fecha_inicio'])) { // fecha_inicio
            $this->fecha_inicio->setFormValue($row['fecha_inicio']);
        }
        if (isset($row['hora_inicio'])) { // hora_inicio
            $this->hora_inicio->setFormValue($row['hora_inicio']);
        }
        if (isset($row['horas'])) { // horas
            $this->horas->setFormValue($row['horas']);
        }
        if (isset($row['fecha_fin'])) { // fecha_fin
            $this->fecha_fin->setFormValue($row['fecha_fin']);
        }
        if (isset($row['hora_fin'])) { // hora_fin
            $this->hora_fin->setFormValue($row['hora_fin']);
        }
        if (isset($row['capilla'])) { // capilla
            $this->capilla->setFormValue($row['capilla']);
        }
        if (isset($row['cantidad'])) { // cantidad
            $this->cantidad->setFormValue($row['cantidad']);
        }
        if (isset($row['costo'])) { // costo
            $this->costo->setFormValue($row['costo']);
        }
        if (isset($row['total'])) { // total
            $this->total->setFormValue($row['total']);
        }
        if (isset($row['referencia_ubicacion'])) { // referencia_ubicacion
            $this->referencia_ubicacion->setFormValue($row['referencia_ubicacion']);
        }
        if (isset($row['anulada'])) { // anulada
            $this->anulada->setFormValue($row['anulada']);
        }
        if (isset($row['user_registra'])) { // user_registra
            $this->user_registra->setFormValue($row['user_registra']);
        }
        if (isset($row['fecha_registro'])) { // fecha_registro
            $this->fecha_registro->setFormValue($row['fecha_registro']);
        }
        if (isset($row['media_hora'])) { // media_hora
            $this->media_hora->setFormValue($row['media_hora']);
        }
        if (isset($row['espera_cenizas'])) { // espera_cenizas
            $this->espera_cenizas->setFormValue($row['espera_cenizas']);
        }
        if (isset($row['adjunto'])) { // adjunto
            $this->adjunto->setFormValue($row['adjunto']);
        }
        if (isset($row['llevar_a'])) { // llevar_a
            $this->llevar_a->setFormValue($row['llevar_a']);
        }
        if (isset($row['servicio_atendido'])) { // servicio_atendido
            $this->servicio_atendido->setFormValue($row['servicio_atendido']);
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
                if (($parm = Get("fk_Nexpediente", Get("expediente"))) !== null) {
                    $masterTbl->Nexpediente->setQueryStringValue($parm);
                    $this->expediente->QueryStringValue = $masterTbl->Nexpediente->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->expediente->setSessionValue($this->expediente->QueryStringValue);
                    $foreignKeys["expediente"] = $this->expediente->QueryStringValue;
                    if (!is_numeric($masterTbl->Nexpediente->QueryStringValue)) {
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
            if ($masterTblVar == "sco_expediente") {
                $validMaster = true;
                $masterTbl = Container("sco_expediente");
                if (($parm = Post("fk_Nexpediente", Post("expediente"))) !== null) {
                    $masterTbl->Nexpediente->setFormValue($parm);
                    $this->expediente->FormValue = $masterTbl->Nexpediente->FormValue;
                    $this->expediente->setSessionValue($this->expediente->FormValue);
                    $foreignKeys["expediente"] = $this->expediente->FormValue;
                    if (!is_numeric($masterTbl->Nexpediente->FormValue)) {
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

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "sco_expediente") {
                if (!array_key_exists("expediente", $foreignKeys)) { // Not current foreign key
                    $this->expediente->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoOrdenList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_servicio_tipo":
                    break;
                case "x_servicio":
                    break;
                case "x_proveedor":
                    break;
                case "x_anulada":
                    break;
                case "x_user_registra":
                    break;
                case "x_espera_cenizas":
                    break;
                case "x_ministro":
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
        $Nexpediente = $this->expediente->CurrentValue;
        $url = "Contenedor?Nexpediente=$Nexpediente";
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
}
