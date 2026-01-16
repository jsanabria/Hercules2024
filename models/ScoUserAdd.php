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
class ScoUserAdd extends ScoUser
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoUserAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoUserAdd";

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
        $this->Nuser->Visible = false;
        $this->cedula->setVisibility();
        $this->nombre->setVisibility();
        $this->_username->setVisibility();
        $this->_password->setVisibility();
        $this->correo->setVisibility();
        $this->direccion->setVisibility();
        $this->level->setVisibility();
        $this->activo->setVisibility();
        $this->foto->setVisibility();
        $this->fecha_ingreso_cia->setVisibility();
        $this->fecha_egreso_cia->setVisibility();
        $this->motivo_egreso->setVisibility();
        $this->departamento->setVisibility();
        $this->cargo->setVisibility();
        $this->celular_1->setVisibility();
        $this->celular_2->setVisibility();
        $this->telefono_1->setVisibility();
        $this->_email->setVisibility();
        $this->hora_entrada->setVisibility();
        $this->hora_salida->setVisibility();
        $this->proveedor->setVisibility();
        $this->seguro->setVisibility();
        $this->level_cemantick->Visible = false;
        $this->evaluacion->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_user';
        $this->TableName = 'sco_user';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_user)
        if (!isset($GLOBALS["sco_user"]) || $GLOBALS["sco_user"]::class == PROJECT_NAMESPACE . "sco_user") {
            $GLOBALS["sco_user"] = &$this;
        }

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
                        $result["view"] = SameString($pageName, "ScoUserView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->level);
        $this->setupLookupOptions($this->activo);
        $this->setupLookupOptions($this->motivo_egreso);
        $this->setupLookupOptions($this->departamento);
        $this->setupLookupOptions($this->cargo);
        $this->setupLookupOptions($this->proveedor);
        $this->setupLookupOptions($this->seguro);
        $this->setupLookupOptions($this->evaluacion);

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
            if (($keyValue = Get("Nuser") ?? Route("Nuser")) !== null) {
                $this->Nuser->setQueryStringValue($keyValue);
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

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("ScoUserList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "ScoUserList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoUserView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoUserList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoUserList"; // Return list page content
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->level->DefaultValue = $this->level->getDefault(); // PHP
        $this->level->OldValue = $this->level->DefaultValue;
        $this->activo->DefaultValue = $this->activo->getDefault(); // PHP
        $this->activo->OldValue = $this->activo->DefaultValue;
        $this->fecha_ingreso_cia->DefaultValue = $this->fecha_ingreso_cia->getDefault(); // PHP
        $this->fecha_ingreso_cia->OldValue = $this->fecha_ingreso_cia->DefaultValue;
        $this->hora_entrada->DefaultValue = $this->hora_entrada->getDefault(); // PHP
        $this->hora_entrada->OldValue = $this->hora_entrada->DefaultValue;
        $this->hora_salida->DefaultValue = $this->hora_salida->getDefault(); // PHP
        $this->hora_salida->OldValue = $this->hora_salida->DefaultValue;
        $this->level_cemantick->DefaultValue = $this->level_cemantick->getDefault(); // PHP
        $this->level_cemantick->OldValue = $this->level_cemantick->DefaultValue;
        $this->evaluacion->DefaultValue = $this->evaluacion->getDefault(); // PHP
        $this->evaluacion->OldValue = $this->evaluacion->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'cedula' first before field var 'x_cedula'
        $val = $CurrentForm->hasValue("cedula") ? $CurrentForm->getValue("cedula") : $CurrentForm->getValue("x_cedula");
        if (!$this->cedula->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula->Visible = false; // Disable update for API request
            } else {
                $this->cedula->setFormValue($val);
            }
        }

        // Check field name 'nombre' first before field var 'x_nombre'
        $val = $CurrentForm->hasValue("nombre") ? $CurrentForm->getValue("nombre") : $CurrentForm->getValue("x_nombre");
        if (!$this->nombre->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre->Visible = false; // Disable update for API request
            } else {
                $this->nombre->setFormValue($val);
            }
        }

        // Check field name 'username' first before field var 'x__username'
        $val = $CurrentForm->hasValue("username") ? $CurrentForm->getValue("username") : $CurrentForm->getValue("x__username");
        if (!$this->_username->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_username->Visible = false; // Disable update for API request
            } else {
                $this->_username->setFormValue($val);
            }
        }

        // Check field name 'password' first before field var 'x__password'
        $val = $CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password");
        if (!$this->_password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_password->Visible = false; // Disable update for API request
            } else {
                $this->_password->setFormValue($val);
            }
        }

        // Check field name 'correo' first before field var 'x_correo'
        $val = $CurrentForm->hasValue("correo") ? $CurrentForm->getValue("correo") : $CurrentForm->getValue("x_correo");
        if (!$this->correo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->correo->Visible = false; // Disable update for API request
            } else {
                $this->correo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'direccion' first before field var 'x_direccion'
        $val = $CurrentForm->hasValue("direccion") ? $CurrentForm->getValue("direccion") : $CurrentForm->getValue("x_direccion");
        if (!$this->direccion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direccion->Visible = false; // Disable update for API request
            } else {
                $this->direccion->setFormValue($val);
            }
        }

        // Check field name 'level' first before field var 'x_level'
        $val = $CurrentForm->hasValue("level") ? $CurrentForm->getValue("level") : $CurrentForm->getValue("x_level");
        if (!$this->level->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->level->Visible = false; // Disable update for API request
            } else {
                $this->level->setFormValue($val);
            }
        }

        // Check field name 'activo' first before field var 'x_activo'
        $val = $CurrentForm->hasValue("activo") ? $CurrentForm->getValue("activo") : $CurrentForm->getValue("x_activo");
        if (!$this->activo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->activo->Visible = false; // Disable update for API request
            } else {
                $this->activo->setFormValue($val);
            }
        }

        // Check field name 'fecha_ingreso_cia' first before field var 'x_fecha_ingreso_cia'
        $val = $CurrentForm->hasValue("fecha_ingreso_cia") ? $CurrentForm->getValue("fecha_ingreso_cia") : $CurrentForm->getValue("x_fecha_ingreso_cia");
        if (!$this->fecha_ingreso_cia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_ingreso_cia->Visible = false; // Disable update for API request
            } else {
                $this->fecha_ingreso_cia->setFormValue($val, true, $validate);
            }
            $this->fecha_ingreso_cia->CurrentValue = UnFormatDateTime($this->fecha_ingreso_cia->CurrentValue, $this->fecha_ingreso_cia->formatPattern());
        }

        // Check field name 'fecha_egreso_cia' first before field var 'x_fecha_egreso_cia'
        $val = $CurrentForm->hasValue("fecha_egreso_cia") ? $CurrentForm->getValue("fecha_egreso_cia") : $CurrentForm->getValue("x_fecha_egreso_cia");
        if (!$this->fecha_egreso_cia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_egreso_cia->Visible = false; // Disable update for API request
            } else {
                $this->fecha_egreso_cia->setFormValue($val, true, $validate);
            }
            $this->fecha_egreso_cia->CurrentValue = UnFormatDateTime($this->fecha_egreso_cia->CurrentValue, $this->fecha_egreso_cia->formatPattern());
        }

        // Check field name 'motivo_egreso' first before field var 'x_motivo_egreso'
        $val = $CurrentForm->hasValue("motivo_egreso") ? $CurrentForm->getValue("motivo_egreso") : $CurrentForm->getValue("x_motivo_egreso");
        if (!$this->motivo_egreso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motivo_egreso->Visible = false; // Disable update for API request
            } else {
                $this->motivo_egreso->setFormValue($val);
            }
        }

        // Check field name 'departamento' first before field var 'x_departamento'
        $val = $CurrentForm->hasValue("departamento") ? $CurrentForm->getValue("departamento") : $CurrentForm->getValue("x_departamento");
        if (!$this->departamento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->departamento->Visible = false; // Disable update for API request
            } else {
                $this->departamento->setFormValue($val);
            }
        }

        // Check field name 'cargo' first before field var 'x_cargo'
        $val = $CurrentForm->hasValue("cargo") ? $CurrentForm->getValue("cargo") : $CurrentForm->getValue("x_cargo");
        if (!$this->cargo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cargo->Visible = false; // Disable update for API request
            } else {
                $this->cargo->setFormValue($val);
            }
        }

        // Check field name 'celular_1' first before field var 'x_celular_1'
        $val = $CurrentForm->hasValue("celular_1") ? $CurrentForm->getValue("celular_1") : $CurrentForm->getValue("x_celular_1");
        if (!$this->celular_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->celular_1->Visible = false; // Disable update for API request
            } else {
                $this->celular_1->setFormValue($val);
            }
        }

        // Check field name 'celular_2' first before field var 'x_celular_2'
        $val = $CurrentForm->hasValue("celular_2") ? $CurrentForm->getValue("celular_2") : $CurrentForm->getValue("x_celular_2");
        if (!$this->celular_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->celular_2->Visible = false; // Disable update for API request
            } else {
                $this->celular_2->setFormValue($val);
            }
        }

        // Check field name 'telefono_1' first before field var 'x_telefono_1'
        $val = $CurrentForm->hasValue("telefono_1") ? $CurrentForm->getValue("telefono_1") : $CurrentForm->getValue("x_telefono_1");
        if (!$this->telefono_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono_1->Visible = false; // Disable update for API request
            } else {
                $this->telefono_1->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'hora_entrada' first before field var 'x_hora_entrada'
        $val = $CurrentForm->hasValue("hora_entrada") ? $CurrentForm->getValue("hora_entrada") : $CurrentForm->getValue("x_hora_entrada");
        if (!$this->hora_entrada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_entrada->Visible = false; // Disable update for API request
            } else {
                $this->hora_entrada->setFormValue($val, true, $validate);
            }
            $this->hora_entrada->CurrentValue = UnFormatDateTime($this->hora_entrada->CurrentValue, $this->hora_entrada->formatPattern());
        }

        // Check field name 'hora_salida' first before field var 'x_hora_salida'
        $val = $CurrentForm->hasValue("hora_salida") ? $CurrentForm->getValue("hora_salida") : $CurrentForm->getValue("x_hora_salida");
        if (!$this->hora_salida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_salida->Visible = false; // Disable update for API request
            } else {
                $this->hora_salida->setFormValue($val, true, $validate);
            }
            $this->hora_salida->CurrentValue = UnFormatDateTime($this->hora_salida->CurrentValue, $this->hora_salida->formatPattern());
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

        // Check field name 'seguro' first before field var 'x_seguro'
        $val = $CurrentForm->hasValue("seguro") ? $CurrentForm->getValue("seguro") : $CurrentForm->getValue("x_seguro");
        if (!$this->seguro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->seguro->Visible = false; // Disable update for API request
            } else {
                $this->seguro->setFormValue($val);
            }
        }

        // Check field name 'evaluacion' first before field var 'x_evaluacion'
        $val = $CurrentForm->hasValue("evaluacion") ? $CurrentForm->getValue("evaluacion") : $CurrentForm->getValue("x_evaluacion");
        if (!$this->evaluacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->evaluacion->Visible = false; // Disable update for API request
            } else {
                $this->evaluacion->setFormValue($val);
            }
        }

        // Check field name 'Nuser' first before field var 'x_Nuser'
        $val = $CurrentForm->hasValue("Nuser") ? $CurrentForm->getValue("Nuser") : $CurrentForm->getValue("x_Nuser");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->cedula->CurrentValue = $this->cedula->FormValue;
        $this->nombre->CurrentValue = $this->nombre->FormValue;
        $this->_username->CurrentValue = $this->_username->FormValue;
        $this->_password->CurrentValue = $this->_password->FormValue;
        $this->correo->CurrentValue = $this->correo->FormValue;
        $this->direccion->CurrentValue = $this->direccion->FormValue;
        $this->level->CurrentValue = $this->level->FormValue;
        $this->activo->CurrentValue = $this->activo->FormValue;
        $this->fecha_ingreso_cia->CurrentValue = $this->fecha_ingreso_cia->FormValue;
        $this->fecha_ingreso_cia->CurrentValue = UnFormatDateTime($this->fecha_ingreso_cia->CurrentValue, $this->fecha_ingreso_cia->formatPattern());
        $this->fecha_egreso_cia->CurrentValue = $this->fecha_egreso_cia->FormValue;
        $this->fecha_egreso_cia->CurrentValue = UnFormatDateTime($this->fecha_egreso_cia->CurrentValue, $this->fecha_egreso_cia->formatPattern());
        $this->motivo_egreso->CurrentValue = $this->motivo_egreso->FormValue;
        $this->departamento->CurrentValue = $this->departamento->FormValue;
        $this->cargo->CurrentValue = $this->cargo->FormValue;
        $this->celular_1->CurrentValue = $this->celular_1->FormValue;
        $this->celular_2->CurrentValue = $this->celular_2->FormValue;
        $this->telefono_1->CurrentValue = $this->telefono_1->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->hora_entrada->CurrentValue = $this->hora_entrada->FormValue;
        $this->hora_entrada->CurrentValue = UnFormatDateTime($this->hora_entrada->CurrentValue, $this->hora_entrada->formatPattern());
        $this->hora_salida->CurrentValue = $this->hora_salida->FormValue;
        $this->hora_salida->CurrentValue = UnFormatDateTime($this->hora_salida->CurrentValue, $this->hora_salida->formatPattern());
        $this->proveedor->CurrentValue = $this->proveedor->FormValue;
        $this->seguro->CurrentValue = $this->seguro->FormValue;
        $this->evaluacion->CurrentValue = $this->evaluacion->FormValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Nuser
        $this->Nuser->RowCssClass = "row";

        // cedula
        $this->cedula->RowCssClass = "row";

        // nombre
        $this->nombre->RowCssClass = "row";

        // username
        $this->_username->RowCssClass = "row";

        // password
        $this->_password->RowCssClass = "row";

        // correo
        $this->correo->RowCssClass = "row";

        // direccion
        $this->direccion->RowCssClass = "row";

        // level
        $this->level->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // foto
        $this->foto->RowCssClass = "row";

        // fecha_ingreso_cia
        $this->fecha_ingreso_cia->RowCssClass = "row";

        // fecha_egreso_cia
        $this->fecha_egreso_cia->RowCssClass = "row";

        // motivo_egreso
        $this->motivo_egreso->RowCssClass = "row";

        // departamento
        $this->departamento->RowCssClass = "row";

        // cargo
        $this->cargo->RowCssClass = "row";

        // celular_1
        $this->celular_1->RowCssClass = "row";

        // celular_2
        $this->celular_2->RowCssClass = "row";

        // telefono_1
        $this->telefono_1->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // hora_entrada
        $this->hora_entrada->RowCssClass = "row";

        // hora_salida
        $this->hora_salida->RowCssClass = "row";

        // proveedor
        $this->proveedor->RowCssClass = "row";

        // seguro
        $this->seguro->RowCssClass = "row";

        // level_cemantick
        $this->level_cemantick->RowCssClass = "row";

        // evaluacion
        $this->evaluacion->RowCssClass = "row";

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

            // password
            $this->_password->ViewValue = $Language->phrase("PasswordMask");

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

            // cedula
            $this->cedula->HrefValue = "";

            // nombre
            $this->nombre->HrefValue = "";

            // username
            $this->_username->HrefValue = "";

            // password
            $this->_password->HrefValue = "";

            // correo
            $this->correo->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // level
            $this->level->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

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

            // fecha_ingreso_cia
            $this->fecha_ingreso_cia->HrefValue = "";

            // fecha_egreso_cia
            $this->fecha_egreso_cia->HrefValue = "";

            // motivo_egreso
            $this->motivo_egreso->HrefValue = "";

            // departamento
            $this->departamento->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // celular_1
            $this->celular_1->HrefValue = "";

            // celular_2
            $this->celular_2->HrefValue = "";

            // telefono_1
            $this->telefono_1->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // hora_entrada
            $this->hora_entrada->HrefValue = "";

            // hora_salida
            $this->hora_salida->HrefValue = "";

            // proveedor
            $this->proveedor->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";

            // evaluacion
            $this->evaluacion->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // cedula
            $this->cedula->setupEditAttributes();
            if (!$this->cedula->Raw) {
                $this->cedula->CurrentValue = HtmlDecode($this->cedula->CurrentValue);
            }
            $this->cedula->EditValue = HtmlEncode($this->cedula->CurrentValue);
            $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

            // nombre
            $this->nombre->setupEditAttributes();
            if (!$this->nombre->Raw) {
                $this->nombre->CurrentValue = HtmlDecode($this->nombre->CurrentValue);
            }
            $this->nombre->EditValue = HtmlEncode($this->nombre->CurrentValue);
            $this->nombre->PlaceHolder = RemoveHtml($this->nombre->caption());

            // username
            $this->_username->setupEditAttributes();
            if (!$this->_username->Raw) {
                $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
            }
            $this->_username->EditValue = HtmlEncode($this->_username->CurrentValue);
            $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

            // password
            $this->_password->setupEditAttributes();
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // correo
            $this->correo->setupEditAttributes();
            if (!$this->correo->Raw) {
                $this->correo->CurrentValue = HtmlDecode($this->correo->CurrentValue);
            }
            $this->correo->EditValue = HtmlEncode($this->correo->CurrentValue);
            $this->correo->PlaceHolder = RemoveHtml($this->correo->caption());

            // direccion
            $this->direccion->setupEditAttributes();
            $this->direccion->EditValue = HtmlEncode($this->direccion->CurrentValue);
            $this->direccion->PlaceHolder = RemoveHtml($this->direccion->caption());

            // level
            if (!$Security->canAdmin()) { // System admin
                $this->level->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->level->CurrentValue));
                if ($curVal != "") {
                    $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                } else {
                    $this->level->ViewValue = $this->level->Lookup !== null && is_array($this->level->lookupOptions()) && count($this->level->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->level->ViewValue !== null) { // Load from cache
                    $this->level->EditValue = array_values($this->level->lookupOptions());
                    if ($this->level->ViewValue == "") {
                        $this->level->ViewValue = $Language->phrase("PleaseSelect");
                    }
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter($this->level->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $this->level->CurrentValue, $this->level->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                    }
                    $sqlWrk = $this->level->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                        $this->level->ViewValue = $this->level->displayValue($arwrk);
                    } else {
                        $this->level->ViewValue = $Language->phrase("PleaseSelect");
                    }
                    $arwrk = $rswrk;
                    $this->level->EditValue = $arwrk;
                }
                $this->level->PlaceHolder = RemoveHtml($this->level->caption());
            }

            // activo
            $this->activo->setupEditAttributes();
            $this->activo->EditValue = $this->activo->options(true);
            $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

            // foto
            $this->foto->setupEditAttributes();
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageWidth = 120;
                $this->foto->ImageHeight = 120;
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->ImageCssClass = "ew-image";
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if (!Config("CREATE_UPLOAD_FILE_ON_COPY")) {
                $this->foto->Upload->DbValue = null;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->foto);
            }

            // fecha_ingreso_cia
            $this->fecha_ingreso_cia->setupEditAttributes();
            $this->fecha_ingreso_cia->EditValue = HtmlEncode(FormatDateTime($this->fecha_ingreso_cia->CurrentValue, $this->fecha_ingreso_cia->formatPattern()));
            $this->fecha_ingreso_cia->PlaceHolder = RemoveHtml($this->fecha_ingreso_cia->caption());

            // fecha_egreso_cia
            $this->fecha_egreso_cia->setupEditAttributes();
            $this->fecha_egreso_cia->EditValue = HtmlEncode(FormatDateTime($this->fecha_egreso_cia->CurrentValue, $this->fecha_egreso_cia->formatPattern()));
            $this->fecha_egreso_cia->PlaceHolder = RemoveHtml($this->fecha_egreso_cia->caption());

            // motivo_egreso
            $this->motivo_egreso->setupEditAttributes();
            $curVal = trim(strval($this->motivo_egreso->CurrentValue));
            if ($curVal != "") {
                $this->motivo_egreso->ViewValue = $this->motivo_egreso->lookupCacheOption($curVal);
            } else {
                $this->motivo_egreso->ViewValue = $this->motivo_egreso->Lookup !== null && is_array($this->motivo_egreso->lookupOptions()) && count($this->motivo_egreso->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->motivo_egreso->ViewValue !== null) { // Load from cache
                $this->motivo_egreso->EditValue = array_values($this->motivo_egreso->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->motivo_egreso->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->motivo_egreso->CurrentValue, $this->motivo_egreso->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->motivo_egreso->getSelectFilter($this); // PHP
                $sqlWrk = $this->motivo_egreso->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->motivo_egreso->EditValue = $arwrk;
            }
            $this->motivo_egreso->PlaceHolder = RemoveHtml($this->motivo_egreso->caption());

            // departamento
            $curVal = trim(strval($this->departamento->CurrentValue));
            if ($curVal != "") {
                $this->departamento->ViewValue = $this->departamento->lookupCacheOption($curVal);
            } else {
                $this->departamento->ViewValue = $this->departamento->Lookup !== null && is_array($this->departamento->lookupOptions()) && count($this->departamento->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->departamento->ViewValue !== null) { // Load from cache
                $this->departamento->EditValue = array_values($this->departamento->lookupOptions());
                if ($this->departamento->ViewValue == "") {
                    $this->departamento->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->departamento->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->departamento->CurrentValue, $this->departamento->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->departamento->getSelectFilter($this); // PHP
                $sqlWrk = $this->departamento->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->departamento->Lookup->renderViewRow($rswrk[0]);
                    $this->departamento->ViewValue = $this->departamento->displayValue($arwrk);
                } else {
                    $this->departamento->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->departamento->EditValue = $arwrk;
            }
            $this->departamento->PlaceHolder = RemoveHtml($this->departamento->caption());

            // cargo
            $curVal = trim(strval($this->cargo->CurrentValue));
            if ($curVal != "") {
                $this->cargo->ViewValue = $this->cargo->lookupCacheOption($curVal);
            } else {
                $this->cargo->ViewValue = $this->cargo->Lookup !== null && is_array($this->cargo->lookupOptions()) && count($this->cargo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cargo->ViewValue !== null) { // Load from cache
                $this->cargo->EditValue = array_values($this->cargo->lookupOptions());
                if ($this->cargo->ViewValue == "") {
                    $this->cargo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cargo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->cargo->CurrentValue, $this->cargo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->cargo->getSelectFilter($this); // PHP
                $sqlWrk = $this->cargo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cargo->Lookup->renderViewRow($rswrk[0]);
                    $this->cargo->ViewValue = $this->cargo->displayValue($arwrk);
                } else {
                    $this->cargo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->cargo->EditValue = $arwrk;
            }
            $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

            // celular_1
            $this->celular_1->setupEditAttributes();
            if (!$this->celular_1->Raw) {
                $this->celular_1->CurrentValue = HtmlDecode($this->celular_1->CurrentValue);
            }
            $this->celular_1->EditValue = HtmlEncode($this->celular_1->CurrentValue);
            $this->celular_1->PlaceHolder = RemoveHtml($this->celular_1->caption());

            // celular_2
            $this->celular_2->setupEditAttributes();
            if (!$this->celular_2->Raw) {
                $this->celular_2->CurrentValue = HtmlDecode($this->celular_2->CurrentValue);
            }
            $this->celular_2->EditValue = HtmlEncode($this->celular_2->CurrentValue);
            $this->celular_2->PlaceHolder = RemoveHtml($this->celular_2->caption());

            // telefono_1
            $this->telefono_1->setupEditAttributes();
            if (!$this->telefono_1->Raw) {
                $this->telefono_1->CurrentValue = HtmlDecode($this->telefono_1->CurrentValue);
            }
            $this->telefono_1->EditValue = HtmlEncode($this->telefono_1->CurrentValue);
            $this->telefono_1->PlaceHolder = RemoveHtml($this->telefono_1->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // hora_entrada
            $this->hora_entrada->setupEditAttributes();
            $this->hora_entrada->EditValue = HtmlEncode($this->hora_entrada->CurrentValue);
            $this->hora_entrada->PlaceHolder = RemoveHtml($this->hora_entrada->caption());

            // hora_salida
            $this->hora_salida->setupEditAttributes();
            $this->hora_salida->EditValue = HtmlEncode($this->hora_salida->CurrentValue);
            $this->hora_salida->PlaceHolder = RemoveHtml($this->hora_salida->caption());

            // proveedor
            $curVal = trim(strval($this->proveedor->CurrentValue));
            if ($curVal != "") {
                $this->proveedor->ViewValue = $this->proveedor->lookupCacheOption($curVal);
            } else {
                $this->proveedor->ViewValue = $this->proveedor->Lookup !== null && is_array($this->proveedor->lookupOptions()) && count($this->proveedor->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->proveedor->ViewValue !== null) { // Load from cache
                $this->proveedor->EditValue = array_values($this->proveedor->lookupOptions());
                if ($this->proveedor->ViewValue == "") {
                    $this->proveedor->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->proveedor->Lookup->renderViewRow($rswrk[0]);
                    $this->proveedor->ViewValue = $this->proveedor->displayValue($arwrk);
                } else {
                    $this->proveedor->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->proveedor->EditValue = $arwrk;
            }
            $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());

            // seguro
            $curVal = trim(strval($this->seguro->CurrentValue));
            if ($curVal != "") {
                $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
            } else {
                $this->seguro->ViewValue = $this->seguro->Lookup !== null && is_array($this->seguro->lookupOptions()) && count($this->seguro->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->seguro->ViewValue !== null) { // Load from cache
                $this->seguro->EditValue = array_values($this->seguro->lookupOptions());
                if ($this->seguro->ViewValue == "") {
                    $this->seguro->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $this->seguro->CurrentValue, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                }
                $sqlWrk = $this->seguro->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->seguro->Lookup->renderViewRow($rswrk[0]);
                    $this->seguro->ViewValue = $this->seguro->displayValue($arwrk);
                } else {
                    $this->seguro->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->seguro->EditValue = $arwrk;
            }
            $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());

            // evaluacion
            $this->evaluacion->setupEditAttributes();
            $this->evaluacion->EditValue = $this->evaluacion->options(true);
            $this->evaluacion->PlaceHolder = RemoveHtml($this->evaluacion->caption());

            // Add refer script

            // cedula
            $this->cedula->HrefValue = "";

            // nombre
            $this->nombre->HrefValue = "";

            // username
            $this->_username->HrefValue = "";

            // password
            $this->_password->HrefValue = "";

            // correo
            $this->correo->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // level
            $this->level->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";

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

            // fecha_ingreso_cia
            $this->fecha_ingreso_cia->HrefValue = "";

            // fecha_egreso_cia
            $this->fecha_egreso_cia->HrefValue = "";

            // motivo_egreso
            $this->motivo_egreso->HrefValue = "";

            // departamento
            $this->departamento->HrefValue = "";

            // cargo
            $this->cargo->HrefValue = "";

            // celular_1
            $this->celular_1->HrefValue = "";

            // celular_2
            $this->celular_2->HrefValue = "";

            // telefono_1
            $this->telefono_1->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // hora_entrada
            $this->hora_entrada->HrefValue = "";

            // hora_salida
            $this->hora_salida->HrefValue = "";

            // proveedor
            $this->proveedor->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";

            // evaluacion
            $this->evaluacion->HrefValue = "";
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
            if ($this->cedula->Visible && $this->cedula->Required) {
                if (!$this->cedula->IsDetailKey && EmptyValue($this->cedula->FormValue)) {
                    $this->cedula->addErrorMessage(str_replace("%s", $this->cedula->caption(), $this->cedula->RequiredErrorMessage));
                }
            }
            if ($this->nombre->Visible && $this->nombre->Required) {
                if (!$this->nombre->IsDetailKey && EmptyValue($this->nombre->FormValue)) {
                    $this->nombre->addErrorMessage(str_replace("%s", $this->nombre->caption(), $this->nombre->RequiredErrorMessage));
                }
            }
            if ($this->_username->Visible && $this->_username->Required) {
                if (!$this->_username->IsDetailKey && EmptyValue($this->_username->FormValue)) {
                    $this->_username->addErrorMessage(str_replace("%s", $this->_username->caption(), $this->_username->RequiredErrorMessage));
                }
            }
            if (!$this->_username->Raw && Config("REMOVE_XSS") && CheckUsername($this->_username->FormValue)) {
                $this->_username->addErrorMessage($Language->phrase("InvalidUsernameChars"));
            }
            if ($this->_password->Visible && $this->_password->Required) {
                if (!$this->_password->IsDetailKey && EmptyValue($this->_password->FormValue)) {
                    $this->_password->addErrorMessage(str_replace("%s", $this->_password->caption(), $this->_password->RequiredErrorMessage));
                }
            }
            if (!$this->_password->Raw && Config("REMOVE_XSS") && CheckPassword($this->_password->FormValue)) {
                $this->_password->addErrorMessage($Language->phrase("InvalidPasswordChars"));
            }
            if ($this->correo->Visible && $this->correo->Required) {
                if (!$this->correo->IsDetailKey && EmptyValue($this->correo->FormValue)) {
                    $this->correo->addErrorMessage(str_replace("%s", $this->correo->caption(), $this->correo->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->correo->FormValue)) {
                $this->correo->addErrorMessage($this->correo->getErrorMessage(false));
            }
            if ($this->direccion->Visible && $this->direccion->Required) {
                if (!$this->direccion->IsDetailKey && EmptyValue($this->direccion->FormValue)) {
                    $this->direccion->addErrorMessage(str_replace("%s", $this->direccion->caption(), $this->direccion->RequiredErrorMessage));
                }
            }
            if ($this->level->Visible && $this->level->Required) {
                if ($Security->canAdmin() && !$this->level->IsDetailKey && EmptyValue($this->level->FormValue)) {
                    $this->level->addErrorMessage(str_replace("%s", $this->level->caption(), $this->level->RequiredErrorMessage));
                }
            }
            if ($this->activo->Visible && $this->activo->Required) {
                if (!$this->activo->IsDetailKey && EmptyValue($this->activo->FormValue)) {
                    $this->activo->addErrorMessage(str_replace("%s", $this->activo->caption(), $this->activo->RequiredErrorMessage));
                }
            }
            if ($this->foto->Visible && $this->foto->Required) {
                if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                    $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
                }
            }
            if ($this->fecha_ingreso_cia->Visible && $this->fecha_ingreso_cia->Required) {
                if (!$this->fecha_ingreso_cia->IsDetailKey && EmptyValue($this->fecha_ingreso_cia->FormValue)) {
                    $this->fecha_ingreso_cia->addErrorMessage(str_replace("%s", $this->fecha_ingreso_cia->caption(), $this->fecha_ingreso_cia->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_ingreso_cia->FormValue, $this->fecha_ingreso_cia->formatPattern())) {
                $this->fecha_ingreso_cia->addErrorMessage($this->fecha_ingreso_cia->getErrorMessage(false));
            }
            if ($this->fecha_egreso_cia->Visible && $this->fecha_egreso_cia->Required) {
                if (!$this->fecha_egreso_cia->IsDetailKey && EmptyValue($this->fecha_egreso_cia->FormValue)) {
                    $this->fecha_egreso_cia->addErrorMessage(str_replace("%s", $this->fecha_egreso_cia->caption(), $this->fecha_egreso_cia->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_egreso_cia->FormValue, $this->fecha_egreso_cia->formatPattern())) {
                $this->fecha_egreso_cia->addErrorMessage($this->fecha_egreso_cia->getErrorMessage(false));
            }
            if ($this->motivo_egreso->Visible && $this->motivo_egreso->Required) {
                if (!$this->motivo_egreso->IsDetailKey && EmptyValue($this->motivo_egreso->FormValue)) {
                    $this->motivo_egreso->addErrorMessage(str_replace("%s", $this->motivo_egreso->caption(), $this->motivo_egreso->RequiredErrorMessage));
                }
            }
            if ($this->departamento->Visible && $this->departamento->Required) {
                if (!$this->departamento->IsDetailKey && EmptyValue($this->departamento->FormValue)) {
                    $this->departamento->addErrorMessage(str_replace("%s", $this->departamento->caption(), $this->departamento->RequiredErrorMessage));
                }
            }
            if ($this->cargo->Visible && $this->cargo->Required) {
                if (!$this->cargo->IsDetailKey && EmptyValue($this->cargo->FormValue)) {
                    $this->cargo->addErrorMessage(str_replace("%s", $this->cargo->caption(), $this->cargo->RequiredErrorMessage));
                }
            }
            if ($this->celular_1->Visible && $this->celular_1->Required) {
                if (!$this->celular_1->IsDetailKey && EmptyValue($this->celular_1->FormValue)) {
                    $this->celular_1->addErrorMessage(str_replace("%s", $this->celular_1->caption(), $this->celular_1->RequiredErrorMessage));
                }
            }
            if ($this->celular_2->Visible && $this->celular_2->Required) {
                if (!$this->celular_2->IsDetailKey && EmptyValue($this->celular_2->FormValue)) {
                    $this->celular_2->addErrorMessage(str_replace("%s", $this->celular_2->caption(), $this->celular_2->RequiredErrorMessage));
                }
            }
            if ($this->telefono_1->Visible && $this->telefono_1->Required) {
                if (!$this->telefono_1->IsDetailKey && EmptyValue($this->telefono_1->FormValue)) {
                    $this->telefono_1->addErrorMessage(str_replace("%s", $this->telefono_1->caption(), $this->telefono_1->RequiredErrorMessage));
                }
            }
            if ($this->_email->Visible && $this->_email->Required) {
                if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                    $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->_email->FormValue)) {
                $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
            }
            if ($this->hora_entrada->Visible && $this->hora_entrada->Required) {
                if (!$this->hora_entrada->IsDetailKey && EmptyValue($this->hora_entrada->FormValue)) {
                    $this->hora_entrada->addErrorMessage(str_replace("%s", $this->hora_entrada->caption(), $this->hora_entrada->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->hora_entrada->FormValue, $this->hora_entrada->formatPattern())) {
                $this->hora_entrada->addErrorMessage($this->hora_entrada->getErrorMessage(false));
            }
            if ($this->hora_salida->Visible && $this->hora_salida->Required) {
                if (!$this->hora_salida->IsDetailKey && EmptyValue($this->hora_salida->FormValue)) {
                    $this->hora_salida->addErrorMessage(str_replace("%s", $this->hora_salida->caption(), $this->hora_salida->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->hora_salida->FormValue, $this->hora_salida->formatPattern())) {
                $this->hora_salida->addErrorMessage($this->hora_salida->getErrorMessage(false));
            }
            if ($this->proveedor->Visible && $this->proveedor->Required) {
                if (!$this->proveedor->IsDetailKey && EmptyValue($this->proveedor->FormValue)) {
                    $this->proveedor->addErrorMessage(str_replace("%s", $this->proveedor->caption(), $this->proveedor->RequiredErrorMessage));
                }
            }
            if ($this->seguro->Visible && $this->seguro->Required) {
                if (!$this->seguro->IsDetailKey && EmptyValue($this->seguro->FormValue)) {
                    $this->seguro->addErrorMessage(str_replace("%s", $this->seguro->caption(), $this->seguro->RequiredErrorMessage));
                }
            }
            if ($this->evaluacion->Visible && $this->evaluacion->Required) {
                if (!$this->evaluacion->IsDetailKey && EmptyValue($this->evaluacion->FormValue)) {
                    $this->evaluacion->addErrorMessage(str_replace("%s", $this->evaluacion->caption(), $this->evaluacion->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoUserNotaGrid");
        if (in_array("sco_user_nota", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoUserAdjuntoGrid");
        if (in_array("sco_user_adjunto", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
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
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            if (!EmptyValue($this->foto->Upload->FileName)) {
                $this->foto->Upload->DbValue = null;
                FixUploadFileNames($this->foto);
                $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->_username->CurrentValue != "") { // Check field with unique index
            $filter = "(`username` = '" . AdjustSql($this->_username->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->_username->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_username->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                    $this->foto->Upload->DbValue = null;
                    if (!SaveUploadFiles($this->foto, $rsnew['foto'], false)) {
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("ScoUserNotaGrid");
            if (in_array("sco_user_nota", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->user->setSessionValue($this->Nuser->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_user_nota"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->user->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoUserAdjuntoGrid");
            if (in_array("sco_user_adjunto", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->user->setSessionValue($this->Nuser->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_user_adjunto"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->user->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    if ($conn->isTransactionActive()) {
                        $conn->commit();
                    }
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    if ($conn->isTransactionActive()) {
                        $conn->rollback();
                    }
                }
            }
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

        // cedula
        $this->cedula->setDbValueDef($rsnew, $this->cedula->CurrentValue, false);

        // nombre
        $this->nombre->setDbValueDef($rsnew, $this->nombre->CurrentValue, false);

        // username
        $this->_username->setDbValueDef($rsnew, $this->_username->CurrentValue, false);

        // password
        if (!IsMaskedPassword($this->_password->CurrentValue)) {
            $this->_password->setDbValueDef($rsnew, $this->_password->CurrentValue, false);
        }

        // correo
        $this->correo->setDbValueDef($rsnew, $this->correo->CurrentValue, false);

        // direccion
        $this->direccion->setDbValueDef($rsnew, $this->direccion->CurrentValue, false);

        // level
        if ($Security->canAdmin()) { // System admin
            $this->level->setDbValueDef($rsnew, $this->level->CurrentValue, strval($this->level->CurrentValue) == "");
        }

        // activo
        $this->activo->setDbValueDef($rsnew, $this->activo->CurrentValue, strval($this->activo->CurrentValue) == "");

        // foto
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            if ($this->foto->Upload->FileName == "") {
                $rsnew['foto'] = null;
            } else {
                FixUploadTempFileNames($this->foto);
                $rsnew['foto'] = $this->foto->Upload->FileName;
            }
        }

        // fecha_ingreso_cia
        $this->fecha_ingreso_cia->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_ingreso_cia->CurrentValue, $this->fecha_ingreso_cia->formatPattern()), false);

        // fecha_egreso_cia
        $this->fecha_egreso_cia->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_egreso_cia->CurrentValue, $this->fecha_egreso_cia->formatPattern()), false);

        // motivo_egreso
        $this->motivo_egreso->setDbValueDef($rsnew, $this->motivo_egreso->CurrentValue, false);

        // departamento
        $this->departamento->setDbValueDef($rsnew, $this->departamento->CurrentValue, false);

        // cargo
        $this->cargo->setDbValueDef($rsnew, $this->cargo->CurrentValue, false);

        // celular_1
        $this->celular_1->setDbValueDef($rsnew, $this->celular_1->CurrentValue, false);

        // celular_2
        $this->celular_2->setDbValueDef($rsnew, $this->celular_2->CurrentValue, false);

        // telefono_1
        $this->telefono_1->setDbValueDef($rsnew, $this->telefono_1->CurrentValue, false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, false);

        // hora_entrada
        $this->hora_entrada->setDbValueDef($rsnew, $this->hora_entrada->CurrentValue, false);

        // hora_salida
        $this->hora_salida->setDbValueDef($rsnew, $this->hora_salida->CurrentValue, false);

        // proveedor
        $this->proveedor->setDbValueDef($rsnew, $this->proveedor->CurrentValue, false);

        // seguro
        $this->seguro->setDbValueDef($rsnew, $this->seguro->CurrentValue, false);

        // evaluacion
        $this->evaluacion->setDbValueDef($rsnew, $this->evaluacion->CurrentValue, strval($this->evaluacion->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['cedula'])) { // cedula
            $this->cedula->setFormValue($row['cedula']);
        }
        if (isset($row['nombre'])) { // nombre
            $this->nombre->setFormValue($row['nombre']);
        }
        if (isset($row['username'])) { // username
            $this->_username->setFormValue($row['username']);
        }
        if (isset($row['password'])) { // password
            $this->_password->setFormValue($row['password']);
        }
        if (isset($row['correo'])) { // correo
            $this->correo->setFormValue($row['correo']);
        }
        if (isset($row['direccion'])) { // direccion
            $this->direccion->setFormValue($row['direccion']);
        }
        if (isset($row['level'])) { // level
            $this->level->setFormValue($row['level']);
        }
        if (isset($row['activo'])) { // activo
            $this->activo->setFormValue($row['activo']);
        }
        if (isset($row['foto'])) { // foto
            $this->foto->setFormValue($row['foto']);
        }
        if (isset($row['fecha_ingreso_cia'])) { // fecha_ingreso_cia
            $this->fecha_ingreso_cia->setFormValue($row['fecha_ingreso_cia']);
        }
        if (isset($row['fecha_egreso_cia'])) { // fecha_egreso_cia
            $this->fecha_egreso_cia->setFormValue($row['fecha_egreso_cia']);
        }
        if (isset($row['motivo_egreso'])) { // motivo_egreso
            $this->motivo_egreso->setFormValue($row['motivo_egreso']);
        }
        if (isset($row['departamento'])) { // departamento
            $this->departamento->setFormValue($row['departamento']);
        }
        if (isset($row['cargo'])) { // cargo
            $this->cargo->setFormValue($row['cargo']);
        }
        if (isset($row['celular_1'])) { // celular_1
            $this->celular_1->setFormValue($row['celular_1']);
        }
        if (isset($row['celular_2'])) { // celular_2
            $this->celular_2->setFormValue($row['celular_2']);
        }
        if (isset($row['telefono_1'])) { // telefono_1
            $this->telefono_1->setFormValue($row['telefono_1']);
        }
        if (isset($row['email'])) { // email
            $this->_email->setFormValue($row['email']);
        }
        if (isset($row['hora_entrada'])) { // hora_entrada
            $this->hora_entrada->setFormValue($row['hora_entrada']);
        }
        if (isset($row['hora_salida'])) { // hora_salida
            $this->hora_salida->setFormValue($row['hora_salida']);
        }
        if (isset($row['proveedor'])) { // proveedor
            $this->proveedor->setFormValue($row['proveedor']);
        }
        if (isset($row['seguro'])) { // seguro
            $this->seguro->setFormValue($row['seguro']);
        }
        if (isset($row['evaluacion'])) { // evaluacion
            $this->evaluacion->setFormValue($row['evaluacion']);
        }
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("sco_user_nota", $detailTblVar)) {
                $detailPageObj = Container("ScoUserNotaGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->user->IsDetailKey = true;
                    $detailPageObj->user->CurrentValue = $this->Nuser->CurrentValue;
                    $detailPageObj->user->setSessionValue($detailPageObj->user->CurrentValue);
                }
            }
            if (in_array("sco_user_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoUserAdjuntoGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->user->IsDetailKey = true;
                    $detailPageObj->user->CurrentValue = $this->Nuser->CurrentValue;
                    $detailPageObj->user->setSessionValue($detailPageObj->user->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoUserList"), "", $this->TableVar, true);
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
}
