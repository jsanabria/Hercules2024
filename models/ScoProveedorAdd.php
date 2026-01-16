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
class ScoProveedorAdd extends ScoProveedor
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoProveedorAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoProveedorAdd";

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
        $this->Nproveedor->Visible = false;
        $this->rif->setVisibility();
        $this->nombre->setVisibility();
        $this->sucursal->setVisibility();
        $this->responsable->setVisibility();
        $this->telefono1->setVisibility();
        $this->telefono2->setVisibility();
        $this->telefono3->setVisibility();
        $this->telefono4->setVisibility();
        $this->fax->setVisibility();
        $this->correo->setVisibility();
        $this->correo_adicional->setVisibility();
        $this->estado->setVisibility();
        $this->localidad->setVisibility();
        $this->direccion->setVisibility();
        $this->observacion->setVisibility();
        $this->tipo_proveedor->setVisibility();
        $this->activo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_proveedor';
        $this->TableName = 'sco_proveedor';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_proveedor)
        if (!isset($GLOBALS["sco_proveedor"]) || $GLOBALS["sco_proveedor"]::class == PROJECT_NAMESPACE . "sco_proveedor") {
            $GLOBALS["sco_proveedor"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_proveedor');
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
                        $result["view"] = SameString($pageName, "ScoProveedorView"); // If View page, no primary button
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
            $key .= @$ar['Nproveedor'];
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
            $this->Nproveedor->Visible = false;
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
        $this->setupLookupOptions($this->estado);
        $this->setupLookupOptions($this->tipo_proveedor);
        $this->setupLookupOptions($this->activo);

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
            if (($keyValue = Get("Nproveedor") ?? Route("Nproveedor")) !== null) {
                $this->Nproveedor->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoProveedorList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ScoProveedorList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoProveedorView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoProveedorList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoProveedorList"; // Return list page content
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->activo->DefaultValue = $this->activo->getDefault(); // PHP
        $this->activo->OldValue = $this->activo->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'rif' first before field var 'x_rif'
        $val = $CurrentForm->hasValue("rif") ? $CurrentForm->getValue("rif") : $CurrentForm->getValue("x_rif");
        if (!$this->rif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->rif->Visible = false; // Disable update for API request
            } else {
                $this->rif->setFormValue($val);
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

        // Check field name 'sucursal' first before field var 'x_sucursal'
        $val = $CurrentForm->hasValue("sucursal") ? $CurrentForm->getValue("sucursal") : $CurrentForm->getValue("x_sucursal");
        if (!$this->sucursal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sucursal->Visible = false; // Disable update for API request
            } else {
                $this->sucursal->setFormValue($val);
            }
        }

        // Check field name 'responsable' first before field var 'x_responsable'
        $val = $CurrentForm->hasValue("responsable") ? $CurrentForm->getValue("responsable") : $CurrentForm->getValue("x_responsable");
        if (!$this->responsable->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->responsable->Visible = false; // Disable update for API request
            } else {
                $this->responsable->setFormValue($val);
            }
        }

        // Check field name 'telefono1' first before field var 'x_telefono1'
        $val = $CurrentForm->hasValue("telefono1") ? $CurrentForm->getValue("telefono1") : $CurrentForm->getValue("x_telefono1");
        if (!$this->telefono1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono1->Visible = false; // Disable update for API request
            } else {
                $this->telefono1->setFormValue($val);
            }
        }

        // Check field name 'telefono2' first before field var 'x_telefono2'
        $val = $CurrentForm->hasValue("telefono2") ? $CurrentForm->getValue("telefono2") : $CurrentForm->getValue("x_telefono2");
        if (!$this->telefono2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono2->Visible = false; // Disable update for API request
            } else {
                $this->telefono2->setFormValue($val);
            }
        }

        // Check field name 'telefono3' first before field var 'x_telefono3'
        $val = $CurrentForm->hasValue("telefono3") ? $CurrentForm->getValue("telefono3") : $CurrentForm->getValue("x_telefono3");
        if (!$this->telefono3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono3->Visible = false; // Disable update for API request
            } else {
                $this->telefono3->setFormValue($val);
            }
        }

        // Check field name 'telefono4' first before field var 'x_telefono4'
        $val = $CurrentForm->hasValue("telefono4") ? $CurrentForm->getValue("telefono4") : $CurrentForm->getValue("x_telefono4");
        if (!$this->telefono4->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono4->Visible = false; // Disable update for API request
            } else {
                $this->telefono4->setFormValue($val);
            }
        }

        // Check field name 'fax' first before field var 'x_fax'
        $val = $CurrentForm->hasValue("fax") ? $CurrentForm->getValue("fax") : $CurrentForm->getValue("x_fax");
        if (!$this->fax->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fax->Visible = false; // Disable update for API request
            } else {
                $this->fax->setFormValue($val);
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

        // Check field name 'correo_adicional' first before field var 'x_correo_adicional'
        $val = $CurrentForm->hasValue("correo_adicional") ? $CurrentForm->getValue("correo_adicional") : $CurrentForm->getValue("x_correo_adicional");
        if (!$this->correo_adicional->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->correo_adicional->Visible = false; // Disable update for API request
            } else {
                $this->correo_adicional->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'estado' first before field var 'x_estado'
        $val = $CurrentForm->hasValue("estado") ? $CurrentForm->getValue("estado") : $CurrentForm->getValue("x_estado");
        if (!$this->estado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado->Visible = false; // Disable update for API request
            } else {
                $this->estado->setFormValue($val);
            }
        }

        // Check field name 'localidad' first before field var 'x_localidad'
        $val = $CurrentForm->hasValue("localidad") ? $CurrentForm->getValue("localidad") : $CurrentForm->getValue("x_localidad");
        if (!$this->localidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->localidad->Visible = false; // Disable update for API request
            } else {
                $this->localidad->setFormValue($val);
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

        // Check field name 'observacion' first before field var 'x_observacion'
        $val = $CurrentForm->hasValue("observacion") ? $CurrentForm->getValue("observacion") : $CurrentForm->getValue("x_observacion");
        if (!$this->observacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->observacion->Visible = false; // Disable update for API request
            } else {
                $this->observacion->setFormValue($val);
            }
        }

        // Check field name 'tipo_proveedor' first before field var 'x_tipo_proveedor'
        $val = $CurrentForm->hasValue("tipo_proveedor") ? $CurrentForm->getValue("tipo_proveedor") : $CurrentForm->getValue("x_tipo_proveedor");
        if (!$this->tipo_proveedor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_proveedor->Visible = false; // Disable update for API request
            } else {
                $this->tipo_proveedor->setFormValue($val);
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

        // Check field name 'Nproveedor' first before field var 'x_Nproveedor'
        $val = $CurrentForm->hasValue("Nproveedor") ? $CurrentForm->getValue("Nproveedor") : $CurrentForm->getValue("x_Nproveedor");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->rif->CurrentValue = $this->rif->FormValue;
        $this->nombre->CurrentValue = $this->nombre->FormValue;
        $this->sucursal->CurrentValue = $this->sucursal->FormValue;
        $this->responsable->CurrentValue = $this->responsable->FormValue;
        $this->telefono1->CurrentValue = $this->telefono1->FormValue;
        $this->telefono2->CurrentValue = $this->telefono2->FormValue;
        $this->telefono3->CurrentValue = $this->telefono3->FormValue;
        $this->telefono4->CurrentValue = $this->telefono4->FormValue;
        $this->fax->CurrentValue = $this->fax->FormValue;
        $this->correo->CurrentValue = $this->correo->FormValue;
        $this->correo_adicional->CurrentValue = $this->correo_adicional->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->localidad->CurrentValue = $this->localidad->FormValue;
        $this->direccion->CurrentValue = $this->direccion->FormValue;
        $this->observacion->CurrentValue = $this->observacion->FormValue;
        $this->tipo_proveedor->CurrentValue = $this->tipo_proveedor->FormValue;
        $this->activo->CurrentValue = $this->activo->FormValue;
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
        $this->Nproveedor->setDbValue($row['Nproveedor']);
        $this->rif->setDbValue($row['rif']);
        $this->nombre->setDbValue($row['nombre']);
        $this->sucursal->setDbValue($row['sucursal']);
        $this->responsable->setDbValue($row['responsable']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->telefono3->setDbValue($row['telefono3']);
        $this->telefono4->setDbValue($row['telefono4']);
        $this->fax->setDbValue($row['fax']);
        $this->correo->setDbValue($row['correo']);
        $this->correo_adicional->setDbValue($row['correo_adicional']);
        $this->estado->setDbValue($row['estado']);
        $this->localidad->setDbValue($row['localidad']);
        $this->direccion->setDbValue($row['direccion']);
        $this->observacion->setDbValue($row['observacion']);
        $this->tipo_proveedor->setDbValue($row['tipo_proveedor']);
        $this->activo->setDbValue($row['activo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nproveedor'] = $this->Nproveedor->DefaultValue;
        $row['rif'] = $this->rif->DefaultValue;
        $row['nombre'] = $this->nombre->DefaultValue;
        $row['sucursal'] = $this->sucursal->DefaultValue;
        $row['responsable'] = $this->responsable->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['telefono3'] = $this->telefono3->DefaultValue;
        $row['telefono4'] = $this->telefono4->DefaultValue;
        $row['fax'] = $this->fax->DefaultValue;
        $row['correo'] = $this->correo->DefaultValue;
        $row['correo_adicional'] = $this->correo_adicional->DefaultValue;
        $row['estado'] = $this->estado->DefaultValue;
        $row['localidad'] = $this->localidad->DefaultValue;
        $row['direccion'] = $this->direccion->DefaultValue;
        $row['observacion'] = $this->observacion->DefaultValue;
        $row['tipo_proveedor'] = $this->tipo_proveedor->DefaultValue;
        $row['activo'] = $this->activo->DefaultValue;
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

        // Nproveedor
        $this->Nproveedor->RowCssClass = "row";

        // rif
        $this->rif->RowCssClass = "row";

        // nombre
        $this->nombre->RowCssClass = "row";

        // sucursal
        $this->sucursal->RowCssClass = "row";

        // responsable
        $this->responsable->RowCssClass = "row";

        // telefono1
        $this->telefono1->RowCssClass = "row";

        // telefono2
        $this->telefono2->RowCssClass = "row";

        // telefono3
        $this->telefono3->RowCssClass = "row";

        // telefono4
        $this->telefono4->RowCssClass = "row";

        // fax
        $this->fax->RowCssClass = "row";

        // correo
        $this->correo->RowCssClass = "row";

        // correo_adicional
        $this->correo_adicional->RowCssClass = "row";

        // estado
        $this->estado->RowCssClass = "row";

        // localidad
        $this->localidad->RowCssClass = "row";

        // direccion
        $this->direccion->RowCssClass = "row";

        // observacion
        $this->observacion->RowCssClass = "row";

        // tipo_proveedor
        $this->tipo_proveedor->RowCssClass = "row";

        // activo
        $this->activo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nproveedor
            $this->Nproveedor->ViewValue = $this->Nproveedor->CurrentValue;

            // rif
            $this->rif->ViewValue = $this->rif->CurrentValue;

            // nombre
            $this->nombre->ViewValue = $this->nombre->CurrentValue;

            // sucursal
            $this->sucursal->ViewValue = $this->sucursal->CurrentValue;

            // responsable
            $this->responsable->ViewValue = $this->responsable->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // telefono3
            $this->telefono3->ViewValue = $this->telefono3->CurrentValue;

            // telefono4
            $this->telefono4->ViewValue = $this->telefono4->CurrentValue;

            // fax
            $this->fax->ViewValue = $this->fax->CurrentValue;

            // correo
            $this->correo->ViewValue = $this->correo->CurrentValue;

            // correo_adicional
            $this->correo_adicional->ViewValue = $this->correo_adicional->CurrentValue;

            // estado
            $curVal = strval($this->estado->CurrentValue);
            if ($curVal != "") {
                $this->estado->ViewValue = $this->estado->lookupCacheOption($curVal);
                if ($this->estado->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estado->Lookup->getTable()->Fields["Nlocalidad"]->searchExpression(), "=", $curVal, $this->estado->Lookup->getTable()->Fields["Nlocalidad"]->searchDataType(), "");
                    $sqlWrk = $this->estado->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->estado->Lookup->renderViewRow($rswrk[0]);
                        $this->estado->ViewValue = $this->estado->displayValue($arwrk);
                    } else {
                        $this->estado->ViewValue = $this->estado->CurrentValue;
                    }
                }
            } else {
                $this->estado->ViewValue = null;
            }

            // localidad
            $this->localidad->ViewValue = $this->localidad->CurrentValue;

            // direccion
            $this->direccion->ViewValue = $this->direccion->CurrentValue;

            // observacion
            $this->observacion->ViewValue = $this->observacion->CurrentValue;

            // tipo_proveedor
            $curVal = strval($this->tipo_proveedor->CurrentValue);
            if ($curVal != "") {
                $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->lookupCacheOption($curVal);
                if ($this->tipo_proveedor->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_proveedor->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_proveedor->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo_proveedor->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo_proveedor->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_proveedor->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->displayValue($arwrk);
                    } else {
                        $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->CurrentValue;
                    }
                }
            } else {
                $this->tipo_proveedor->ViewValue = null;
            }

            // activo
            if (strval($this->activo->CurrentValue) != "") {
                $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
            } else {
                $this->activo->ViewValue = null;
            }

            // rif
            $this->rif->HrefValue = "";

            // nombre
            $this->nombre->HrefValue = "";

            // sucursal
            $this->sucursal->HrefValue = "";

            // responsable
            $this->responsable->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // telefono3
            $this->telefono3->HrefValue = "";

            // telefono4
            $this->telefono4->HrefValue = "";

            // fax
            $this->fax->HrefValue = "";

            // correo
            $this->correo->HrefValue = "";

            // correo_adicional
            $this->correo_adicional->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // localidad
            $this->localidad->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // observacion
            $this->observacion->HrefValue = "";

            // tipo_proveedor
            $this->tipo_proveedor->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // rif
            $this->rif->setupEditAttributes();
            if (!$this->rif->Raw) {
                $this->rif->CurrentValue = HtmlDecode($this->rif->CurrentValue);
            }
            $this->rif->EditValue = HtmlEncode($this->rif->CurrentValue);
            $this->rif->PlaceHolder = RemoveHtml($this->rif->caption());

            // nombre
            $this->nombre->setupEditAttributes();
            if (!$this->nombre->Raw) {
                $this->nombre->CurrentValue = HtmlDecode($this->nombre->CurrentValue);
            }
            $this->nombre->EditValue = HtmlEncode($this->nombre->CurrentValue);
            $this->nombre->PlaceHolder = RemoveHtml($this->nombre->caption());

            // sucursal
            $this->sucursal->setupEditAttributes();
            if (!$this->sucursal->Raw) {
                $this->sucursal->CurrentValue = HtmlDecode($this->sucursal->CurrentValue);
            }
            $this->sucursal->EditValue = HtmlEncode($this->sucursal->CurrentValue);
            $this->sucursal->PlaceHolder = RemoveHtml($this->sucursal->caption());

            // responsable
            $this->responsable->setupEditAttributes();
            if (!$this->responsable->Raw) {
                $this->responsable->CurrentValue = HtmlDecode($this->responsable->CurrentValue);
            }
            $this->responsable->EditValue = HtmlEncode($this->responsable->CurrentValue);
            $this->responsable->PlaceHolder = RemoveHtml($this->responsable->caption());

            // telefono1
            $this->telefono1->setupEditAttributes();
            if (!$this->telefono1->Raw) {
                $this->telefono1->CurrentValue = HtmlDecode($this->telefono1->CurrentValue);
            }
            $this->telefono1->EditValue = HtmlEncode($this->telefono1->CurrentValue);
            $this->telefono1->PlaceHolder = RemoveHtml($this->telefono1->caption());

            // telefono2
            $this->telefono2->setupEditAttributes();
            if (!$this->telefono2->Raw) {
                $this->telefono2->CurrentValue = HtmlDecode($this->telefono2->CurrentValue);
            }
            $this->telefono2->EditValue = HtmlEncode($this->telefono2->CurrentValue);
            $this->telefono2->PlaceHolder = RemoveHtml($this->telefono2->caption());

            // telefono3
            $this->telefono3->setupEditAttributes();
            if (!$this->telefono3->Raw) {
                $this->telefono3->CurrentValue = HtmlDecode($this->telefono3->CurrentValue);
            }
            $this->telefono3->EditValue = HtmlEncode($this->telefono3->CurrentValue);
            $this->telefono3->PlaceHolder = RemoveHtml($this->telefono3->caption());

            // telefono4
            $this->telefono4->setupEditAttributes();
            if (!$this->telefono4->Raw) {
                $this->telefono4->CurrentValue = HtmlDecode($this->telefono4->CurrentValue);
            }
            $this->telefono4->EditValue = HtmlEncode($this->telefono4->CurrentValue);
            $this->telefono4->PlaceHolder = RemoveHtml($this->telefono4->caption());

            // fax
            $this->fax->setupEditAttributes();
            if (!$this->fax->Raw) {
                $this->fax->CurrentValue = HtmlDecode($this->fax->CurrentValue);
            }
            $this->fax->EditValue = HtmlEncode($this->fax->CurrentValue);
            $this->fax->PlaceHolder = RemoveHtml($this->fax->caption());

            // correo
            $this->correo->setupEditAttributes();
            if (!$this->correo->Raw) {
                $this->correo->CurrentValue = HtmlDecode($this->correo->CurrentValue);
            }
            $this->correo->EditValue = HtmlEncode($this->correo->CurrentValue);
            $this->correo->PlaceHolder = RemoveHtml($this->correo->caption());

            // correo_adicional
            $this->correo_adicional->setupEditAttributes();
            if (!$this->correo_adicional->Raw) {
                $this->correo_adicional->CurrentValue = HtmlDecode($this->correo_adicional->CurrentValue);
            }
            $this->correo_adicional->EditValue = HtmlEncode($this->correo_adicional->CurrentValue);
            $this->correo_adicional->PlaceHolder = RemoveHtml($this->correo_adicional->caption());

            // estado
            $this->estado->setupEditAttributes();
            $curVal = trim(strval($this->estado->CurrentValue));
            if ($curVal != "") {
                $this->estado->ViewValue = $this->estado->lookupCacheOption($curVal);
            } else {
                $this->estado->ViewValue = $this->estado->Lookup !== null && is_array($this->estado->lookupOptions()) && count($this->estado->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->estado->ViewValue !== null) { // Load from cache
                $this->estado->EditValue = array_values($this->estado->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->estado->Lookup->getTable()->Fields["Nlocalidad"]->searchExpression(), "=", $this->estado->CurrentValue, $this->estado->Lookup->getTable()->Fields["Nlocalidad"]->searchDataType(), "");
                }
                $sqlWrk = $this->estado->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->estado->EditValue = $arwrk;
            }
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // localidad
            $this->localidad->setupEditAttributes();
            if (!$this->localidad->Raw) {
                $this->localidad->CurrentValue = HtmlDecode($this->localidad->CurrentValue);
            }
            $this->localidad->EditValue = HtmlEncode($this->localidad->CurrentValue);
            $this->localidad->PlaceHolder = RemoveHtml($this->localidad->caption());

            // direccion
            $this->direccion->setupEditAttributes();
            $this->direccion->EditValue = HtmlEncode($this->direccion->CurrentValue);
            $this->direccion->PlaceHolder = RemoveHtml($this->direccion->caption());

            // observacion
            $this->observacion->setupEditAttributes();
            $this->observacion->EditValue = HtmlEncode($this->observacion->CurrentValue);
            $this->observacion->PlaceHolder = RemoveHtml($this->observacion->caption());

            // tipo_proveedor
            $this->tipo_proveedor->setupEditAttributes();
            $curVal = trim(strval($this->tipo_proveedor->CurrentValue));
            if ($curVal != "") {
                $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->lookupCacheOption($curVal);
            } else {
                $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->Lookup !== null && is_array($this->tipo_proveedor->lookupOptions()) && count($this->tipo_proveedor->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_proveedor->ViewValue !== null) { // Load from cache
                $this->tipo_proveedor->EditValue = array_values($this->tipo_proveedor->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_proveedor->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->tipo_proveedor->CurrentValue, $this->tipo_proveedor->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->tipo_proveedor->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_proveedor->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_proveedor->EditValue = $arwrk;
            }
            $this->tipo_proveedor->PlaceHolder = RemoveHtml($this->tipo_proveedor->caption());

            // activo
            $this->activo->setupEditAttributes();
            $this->activo->EditValue = $this->activo->options(true);
            $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

            // Add refer script

            // rif
            $this->rif->HrefValue = "";

            // nombre
            $this->nombre->HrefValue = "";

            // sucursal
            $this->sucursal->HrefValue = "";

            // responsable
            $this->responsable->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // telefono3
            $this->telefono3->HrefValue = "";

            // telefono4
            $this->telefono4->HrefValue = "";

            // fax
            $this->fax->HrefValue = "";

            // correo
            $this->correo->HrefValue = "";

            // correo_adicional
            $this->correo_adicional->HrefValue = "";

            // estado
            $this->estado->HrefValue = "";

            // localidad
            $this->localidad->HrefValue = "";

            // direccion
            $this->direccion->HrefValue = "";

            // observacion
            $this->observacion->HrefValue = "";

            // tipo_proveedor
            $this->tipo_proveedor->HrefValue = "";

            // activo
            $this->activo->HrefValue = "";
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
            if ($this->rif->Visible && $this->rif->Required) {
                if (!$this->rif->IsDetailKey && EmptyValue($this->rif->FormValue)) {
                    $this->rif->addErrorMessage(str_replace("%s", $this->rif->caption(), $this->rif->RequiredErrorMessage));
                }
            }
            if ($this->nombre->Visible && $this->nombre->Required) {
                if (!$this->nombre->IsDetailKey && EmptyValue($this->nombre->FormValue)) {
                    $this->nombre->addErrorMessage(str_replace("%s", $this->nombre->caption(), $this->nombre->RequiredErrorMessage));
                }
            }
            if ($this->sucursal->Visible && $this->sucursal->Required) {
                if (!$this->sucursal->IsDetailKey && EmptyValue($this->sucursal->FormValue)) {
                    $this->sucursal->addErrorMessage(str_replace("%s", $this->sucursal->caption(), $this->sucursal->RequiredErrorMessage));
                }
            }
            if ($this->responsable->Visible && $this->responsable->Required) {
                if (!$this->responsable->IsDetailKey && EmptyValue($this->responsable->FormValue)) {
                    $this->responsable->addErrorMessage(str_replace("%s", $this->responsable->caption(), $this->responsable->RequiredErrorMessage));
                }
            }
            if ($this->telefono1->Visible && $this->telefono1->Required) {
                if (!$this->telefono1->IsDetailKey && EmptyValue($this->telefono1->FormValue)) {
                    $this->telefono1->addErrorMessage(str_replace("%s", $this->telefono1->caption(), $this->telefono1->RequiredErrorMessage));
                }
            }
            if ($this->telefono2->Visible && $this->telefono2->Required) {
                if (!$this->telefono2->IsDetailKey && EmptyValue($this->telefono2->FormValue)) {
                    $this->telefono2->addErrorMessage(str_replace("%s", $this->telefono2->caption(), $this->telefono2->RequiredErrorMessage));
                }
            }
            if ($this->telefono3->Visible && $this->telefono3->Required) {
                if (!$this->telefono3->IsDetailKey && EmptyValue($this->telefono3->FormValue)) {
                    $this->telefono3->addErrorMessage(str_replace("%s", $this->telefono3->caption(), $this->telefono3->RequiredErrorMessage));
                }
            }
            if ($this->telefono4->Visible && $this->telefono4->Required) {
                if (!$this->telefono4->IsDetailKey && EmptyValue($this->telefono4->FormValue)) {
                    $this->telefono4->addErrorMessage(str_replace("%s", $this->telefono4->caption(), $this->telefono4->RequiredErrorMessage));
                }
            }
            if ($this->fax->Visible && $this->fax->Required) {
                if (!$this->fax->IsDetailKey && EmptyValue($this->fax->FormValue)) {
                    $this->fax->addErrorMessage(str_replace("%s", $this->fax->caption(), $this->fax->RequiredErrorMessage));
                }
            }
            if ($this->correo->Visible && $this->correo->Required) {
                if (!$this->correo->IsDetailKey && EmptyValue($this->correo->FormValue)) {
                    $this->correo->addErrorMessage(str_replace("%s", $this->correo->caption(), $this->correo->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->correo->FormValue)) {
                $this->correo->addErrorMessage($this->correo->getErrorMessage(false));
            }
            if ($this->correo_adicional->Visible && $this->correo_adicional->Required) {
                if (!$this->correo_adicional->IsDetailKey && EmptyValue($this->correo_adicional->FormValue)) {
                    $this->correo_adicional->addErrorMessage(str_replace("%s", $this->correo_adicional->caption(), $this->correo_adicional->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->correo_adicional->FormValue)) {
                $this->correo_adicional->addErrorMessage($this->correo_adicional->getErrorMessage(false));
            }
            if ($this->estado->Visible && $this->estado->Required) {
                if (!$this->estado->IsDetailKey && EmptyValue($this->estado->FormValue)) {
                    $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
                }
            }
            if ($this->localidad->Visible && $this->localidad->Required) {
                if (!$this->localidad->IsDetailKey && EmptyValue($this->localidad->FormValue)) {
                    $this->localidad->addErrorMessage(str_replace("%s", $this->localidad->caption(), $this->localidad->RequiredErrorMessage));
                }
            }
            if ($this->direccion->Visible && $this->direccion->Required) {
                if (!$this->direccion->IsDetailKey && EmptyValue($this->direccion->FormValue)) {
                    $this->direccion->addErrorMessage(str_replace("%s", $this->direccion->caption(), $this->direccion->RequiredErrorMessage));
                }
            }
            if ($this->observacion->Visible && $this->observacion->Required) {
                if (!$this->observacion->IsDetailKey && EmptyValue($this->observacion->FormValue)) {
                    $this->observacion->addErrorMessage(str_replace("%s", $this->observacion->caption(), $this->observacion->RequiredErrorMessage));
                }
            }
            if ($this->tipo_proveedor->Visible && $this->tipo_proveedor->Required) {
                if (!$this->tipo_proveedor->IsDetailKey && EmptyValue($this->tipo_proveedor->FormValue)) {
                    $this->tipo_proveedor->addErrorMessage(str_replace("%s", $this->tipo_proveedor->caption(), $this->tipo_proveedor->RequiredErrorMessage));
                }
            }
            if ($this->activo->Visible && $this->activo->Required) {
                if (!$this->activo->IsDetailKey && EmptyValue($this->activo->FormValue)) {
                    $this->activo->addErrorMessage(str_replace("%s", $this->activo->caption(), $this->activo->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoOfreceServicioGrid");
        if (in_array("sco_ofrece_servicio", $detailTblVar) && $detailPage->DetailAdd) {
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

        // Update current values
        $this->setCurrentValues($rsnew);
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
            $detailPage = Container("ScoOfreceServicioGrid");
            if (in_array("sco_ofrece_servicio", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->proveedor->setSessionValue($this->Nproveedor->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_ofrece_servicio"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->proveedor->setSessionValue(""); // Clear master key if insert failed
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

        // rif
        $this->rif->setDbValueDef($rsnew, $this->rif->CurrentValue, false);

        // nombre
        $this->nombre->setDbValueDef($rsnew, $this->nombre->CurrentValue, false);

        // sucursal
        $this->sucursal->setDbValueDef($rsnew, $this->sucursal->CurrentValue, false);

        // responsable
        $this->responsable->setDbValueDef($rsnew, $this->responsable->CurrentValue, false);

        // telefono1
        $this->telefono1->setDbValueDef($rsnew, $this->telefono1->CurrentValue, false);

        // telefono2
        $this->telefono2->setDbValueDef($rsnew, $this->telefono2->CurrentValue, false);

        // telefono3
        $this->telefono3->setDbValueDef($rsnew, $this->telefono3->CurrentValue, false);

        // telefono4
        $this->telefono4->setDbValueDef($rsnew, $this->telefono4->CurrentValue, false);

        // fax
        $this->fax->setDbValueDef($rsnew, $this->fax->CurrentValue, false);

        // correo
        $this->correo->setDbValueDef($rsnew, $this->correo->CurrentValue, false);

        // correo_adicional
        $this->correo_adicional->setDbValueDef($rsnew, $this->correo_adicional->CurrentValue, false);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, false);

        // localidad
        $this->localidad->setDbValueDef($rsnew, $this->localidad->CurrentValue, false);

        // direccion
        $this->direccion->setDbValueDef($rsnew, $this->direccion->CurrentValue, false);

        // observacion
        $this->observacion->setDbValueDef($rsnew, $this->observacion->CurrentValue, false);

        // tipo_proveedor
        $this->tipo_proveedor->setDbValueDef($rsnew, $this->tipo_proveedor->CurrentValue, false);

        // activo
        $this->activo->setDbValueDef($rsnew, $this->activo->CurrentValue, strval($this->activo->CurrentValue) == "");
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['rif'])) { // rif
            $this->rif->setFormValue($row['rif']);
        }
        if (isset($row['nombre'])) { // nombre
            $this->nombre->setFormValue($row['nombre']);
        }
        if (isset($row['sucursal'])) { // sucursal
            $this->sucursal->setFormValue($row['sucursal']);
        }
        if (isset($row['responsable'])) { // responsable
            $this->responsable->setFormValue($row['responsable']);
        }
        if (isset($row['telefono1'])) { // telefono1
            $this->telefono1->setFormValue($row['telefono1']);
        }
        if (isset($row['telefono2'])) { // telefono2
            $this->telefono2->setFormValue($row['telefono2']);
        }
        if (isset($row['telefono3'])) { // telefono3
            $this->telefono3->setFormValue($row['telefono3']);
        }
        if (isset($row['telefono4'])) { // telefono4
            $this->telefono4->setFormValue($row['telefono4']);
        }
        if (isset($row['fax'])) { // fax
            $this->fax->setFormValue($row['fax']);
        }
        if (isset($row['correo'])) { // correo
            $this->correo->setFormValue($row['correo']);
        }
        if (isset($row['correo_adicional'])) { // correo_adicional
            $this->correo_adicional->setFormValue($row['correo_adicional']);
        }
        if (isset($row['estado'])) { // estado
            $this->estado->setFormValue($row['estado']);
        }
        if (isset($row['localidad'])) { // localidad
            $this->localidad->setFormValue($row['localidad']);
        }
        if (isset($row['direccion'])) { // direccion
            $this->direccion->setFormValue($row['direccion']);
        }
        if (isset($row['observacion'])) { // observacion
            $this->observacion->setFormValue($row['observacion']);
        }
        if (isset($row['tipo_proveedor'])) { // tipo_proveedor
            $this->tipo_proveedor->setFormValue($row['tipo_proveedor']);
        }
        if (isset($row['activo'])) { // activo
            $this->activo->setFormValue($row['activo']);
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
            if (in_array("sco_ofrece_servicio", $detailTblVar)) {
                $detailPageObj = Container("ScoOfreceServicioGrid");
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
                    $detailPageObj->proveedor->IsDetailKey = true;
                    $detailPageObj->proveedor->CurrentValue = $this->Nproveedor->CurrentValue;
                    $detailPageObj->proveedor->setSessionValue($detailPageObj->proveedor->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoProveedorList"), "", $this->TableVar, true);
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
                case "x_estado":
                    break;
                case "x_tipo_proveedor":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_activo":
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
