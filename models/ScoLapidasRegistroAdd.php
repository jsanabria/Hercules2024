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
class ScoLapidasRegistroAdd extends ScoLapidasRegistro
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoLapidasRegistroAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoLapidasRegistroAdd";

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
        $this->Nlapidas_registro->Visible = false;
        $this->solicitante->setVisibility();
        $this->parentesco->setVisibility();
        $this->telefono1->setVisibility();
        $this->telefono2->setVisibility();
        $this->_email->setVisibility();
        $this->ci_difunto->setVisibility();
        $this->nombre_difunto->setVisibility();
        $this->tipo->setVisibility();
        $this->comentario->setVisibility();
        $this->estatus->Visible = false;
        $this->registro->Visible = false;
        $this->registra->Visible = false;
        $this->modificacion->Visible = false;
        $this->modifica->Visible = false;
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->setVisibility();
        $this->contrato->setVisibility();
        $this->maqueteo->setVisibility();
        $this->coordenadas_maqueta->Visible = false;
        $this->reclamo->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_lapidas_registro';
        $this->TableName = 'sco_lapidas_registro';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_lapidas_registro)
        if (!isset($GLOBALS["sco_lapidas_registro"]) || $GLOBALS["sco_lapidas_registro"]::class == PROJECT_NAMESPACE . "sco_lapidas_registro") {
            $GLOBALS["sco_lapidas_registro"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_lapidas_registro');
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
                        $result["view"] = SameString($pageName, "ScoLapidasRegistroView"); // If View page, no primary button
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
            $key .= @$ar['Nlapidas_registro'];
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
            $this->Nlapidas_registro->Visible = false;
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
        $this->setupLookupOptions($this->parentesco);
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->registra);
        $this->setupLookupOptions($this->modifica);
        $this->setupLookupOptions($this->maqueteo);

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
            if (($keyValue = Get("Nlapidas_registro") ?? Route("Nlapidas_registro")) !== null) {
                $this->Nlapidas_registro->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoLapidasRegistroList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ScoLapidasRegistroList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoLapidasRegistroView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoLapidasRegistroList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoLapidasRegistroList"; // Return list page content
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
        $this->contrato->DefaultValue = $this->contrato->getDefault(); // PHP
        $this->contrato->OldValue = $this->contrato->DefaultValue;
        $this->reclamo->DefaultValue = $this->reclamo->getDefault(); // PHP
        $this->reclamo->OldValue = $this->reclamo->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'solicitante' first before field var 'x_solicitante'
        $val = $CurrentForm->hasValue("solicitante") ? $CurrentForm->getValue("solicitante") : $CurrentForm->getValue("x_solicitante");
        if (!$this->solicitante->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->solicitante->Visible = false; // Disable update for API request
            } else {
                $this->solicitante->setFormValue($val);
            }
        }

        // Check field name 'parentesco' first before field var 'x_parentesco'
        $val = $CurrentForm->hasValue("parentesco") ? $CurrentForm->getValue("parentesco") : $CurrentForm->getValue("x_parentesco");
        if (!$this->parentesco->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parentesco->Visible = false; // Disable update for API request
            } else {
                $this->parentesco->setFormValue($val);
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

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'ci_difunto' first before field var 'x_ci_difunto'
        $val = $CurrentForm->hasValue("ci_difunto") ? $CurrentForm->getValue("ci_difunto") : $CurrentForm->getValue("x_ci_difunto");
        if (!$this->ci_difunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_difunto->Visible = false; // Disable update for API request
            } else {
                $this->ci_difunto->setFormValue($val);
            }
        }

        // Check field name 'nombre_difunto' first before field var 'x_nombre_difunto'
        $val = $CurrentForm->hasValue("nombre_difunto") ? $CurrentForm->getValue("nombre_difunto") : $CurrentForm->getValue("x_nombre_difunto");
        if (!$this->nombre_difunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_difunto->Visible = false; // Disable update for API request
            } else {
                $this->nombre_difunto->setFormValue($val);
            }
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

        // Check field name 'comentario' first before field var 'x_comentario'
        $val = $CurrentForm->hasValue("comentario") ? $CurrentForm->getValue("comentario") : $CurrentForm->getValue("x_comentario");
        if (!$this->comentario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comentario->Visible = false; // Disable update for API request
            } else {
                $this->comentario->setFormValue($val);
            }
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

        // Check field name 'modulo' first before field var 'x_modulo'
        $val = $CurrentForm->hasValue("modulo") ? $CurrentForm->getValue("modulo") : $CurrentForm->getValue("x_modulo");
        if (!$this->modulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->modulo->Visible = false; // Disable update for API request
            } else {
                $this->modulo->setFormValue($val);
            }
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

        // Check field name 'parcela' first before field var 'x_parcela'
        $val = $CurrentForm->hasValue("parcela") ? $CurrentForm->getValue("parcela") : $CurrentForm->getValue("x_parcela");
        if (!$this->parcela->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parcela->Visible = false; // Disable update for API request
            } else {
                $this->parcela->setFormValue($val);
            }
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

        // Check field name 'contrato' first before field var 'x_contrato'
        $val = $CurrentForm->hasValue("contrato") ? $CurrentForm->getValue("contrato") : $CurrentForm->getValue("x_contrato");
        if (!$this->contrato->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contrato->Visible = false; // Disable update for API request
            } else {
                $this->contrato->setFormValue($val);
            }
        }

        // Check field name 'maqueteo' first before field var 'x_maqueteo'
        $val = $CurrentForm->hasValue("maqueteo") ? $CurrentForm->getValue("maqueteo") : $CurrentForm->getValue("x_maqueteo");
        if (!$this->maqueteo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->maqueteo->Visible = false; // Disable update for API request
            } else {
                $this->maqueteo->setFormValue($val);
            }
        }

        // Check field name 'Nlapidas_registro' first before field var 'x_Nlapidas_registro'
        $val = $CurrentForm->hasValue("Nlapidas_registro") ? $CurrentForm->getValue("Nlapidas_registro") : $CurrentForm->getValue("x_Nlapidas_registro");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->solicitante->CurrentValue = $this->solicitante->FormValue;
        $this->parentesco->CurrentValue = $this->parentesco->FormValue;
        $this->telefono1->CurrentValue = $this->telefono1->FormValue;
        $this->telefono2->CurrentValue = $this->telefono2->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->ci_difunto->CurrentValue = $this->ci_difunto->FormValue;
        $this->nombre_difunto->CurrentValue = $this->nombre_difunto->FormValue;
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->comentario->CurrentValue = $this->comentario->FormValue;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->sub_seccion->CurrentValue = $this->sub_seccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->boveda->CurrentValue = $this->boveda->FormValue;
        $this->contrato->CurrentValue = $this->contrato->FormValue;
        $this->maqueteo->CurrentValue = $this->maqueteo->FormValue;
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
        $this->Nlapidas_registro->setDbValue($row['Nlapidas_registro']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->parentesco->setDbValue($row['parentesco']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->nombre_difunto->setDbValue($row['nombre_difunto']);
        $this->tipo->setDbValue($row['tipo']);
        $this->comentario->setDbValue($row['comentario']);
        $this->estatus->setDbValue($row['estatus']);
        $this->registro->setDbValue($row['registro']);
        $this->registra->setDbValue($row['registra']);
        $this->modificacion->setDbValue($row['modificacion']);
        $this->modifica->setDbValue($row['modifica']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->contrato->setDbValue($row['contrato']);
        $this->maqueteo->setDbValue($row['maqueteo']);
        $this->coordenadas_maqueta->setDbValue($row['coordenadas_maqueta']);
        $this->reclamo->setDbValue($row['reclamo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nlapidas_registro'] = $this->Nlapidas_registro->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['parentesco'] = $this->parentesco->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['nombre_difunto'] = $this->nombre_difunto->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['comentario'] = $this->comentario->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['registro'] = $this->registro->DefaultValue;
        $row['registra'] = $this->registra->DefaultValue;
        $row['modificacion'] = $this->modificacion->DefaultValue;
        $row['modifica'] = $this->modifica->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['sub_seccion'] = $this->sub_seccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['boveda'] = $this->boveda->DefaultValue;
        $row['contrato'] = $this->contrato->DefaultValue;
        $row['maqueteo'] = $this->maqueteo->DefaultValue;
        $row['coordenadas_maqueta'] = $this->coordenadas_maqueta->DefaultValue;
        $row['reclamo'] = $this->reclamo->DefaultValue;
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

        // Nlapidas_registro
        $this->Nlapidas_registro->RowCssClass = "row";

        // solicitante
        $this->solicitante->RowCssClass = "row";

        // parentesco
        $this->parentesco->RowCssClass = "row";

        // telefono1
        $this->telefono1->RowCssClass = "row";

        // telefono2
        $this->telefono2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // ci_difunto
        $this->ci_difunto->RowCssClass = "row";

        // nombre_difunto
        $this->nombre_difunto->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // comentario
        $this->comentario->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // registro
        $this->registro->RowCssClass = "row";

        // registra
        $this->registra->RowCssClass = "row";

        // modificacion
        $this->modificacion->RowCssClass = "row";

        // modifica
        $this->modifica->RowCssClass = "row";

        // seccion
        $this->seccion->RowCssClass = "row";

        // modulo
        $this->modulo->RowCssClass = "row";

        // sub_seccion
        $this->sub_seccion->RowCssClass = "row";

        // parcela
        $this->parcela->RowCssClass = "row";

        // boveda
        $this->boveda->RowCssClass = "row";

        // contrato
        $this->contrato->RowCssClass = "row";

        // maqueteo
        $this->maqueteo->RowCssClass = "row";

        // coordenadas_maqueta
        $this->coordenadas_maqueta->RowCssClass = "row";

        // reclamo
        $this->reclamo->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nlapidas_registro
            $this->Nlapidas_registro->ViewValue = $this->Nlapidas_registro->CurrentValue;

            // solicitante
            $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

            // parentesco
            $curVal = strval($this->parentesco->CurrentValue);
            if ($curVal != "") {
                $this->parentesco->ViewValue = $this->parentesco->lookupCacheOption($curVal);
                if ($this->parentesco->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->parentesco->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->parentesco->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->parentesco->getSelectFilter($this); // PHP
                    $sqlWrk = $this->parentesco->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parentesco->Lookup->renderViewRow($rswrk[0]);
                        $this->parentesco->ViewValue = $this->parentesco->displayValue($arwrk);
                    } else {
                        $this->parentesco->ViewValue = $this->parentesco->CurrentValue;
                    }
                }
            } else {
                $this->parentesco->ViewValue = null;
            }

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // ci_difunto
            $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

            // nombre_difunto
            $this->nombre_difunto->ViewValue = $this->nombre_difunto->CurrentValue;

            // tipo
            $curVal = strval($this->tipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo->ViewValue = $this->tipo->lookupCacheOption($curVal);
                if ($this->tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // comentario
            $this->comentario->ViewValue = $this->comentario->CurrentValue;

            // estatus
            if (strval($this->estatus->CurrentValue) != "") {
                $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
            } else {
                $this->estatus->ViewValue = null;
            }

            // registro
            $this->registro->ViewValue = $this->registro->CurrentValue;
            $this->registro->ViewValue = FormatDateTime($this->registro->ViewValue, $this->registro->formatPattern());

            // registra
            $curVal = strval($this->registra->CurrentValue);
            if ($curVal != "") {
                $this->registra->ViewValue = $this->registra->lookupCacheOption($curVal);
                if ($this->registra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->registra->Lookup->renderViewRow($rswrk[0]);
                        $this->registra->ViewValue = $this->registra->displayValue($arwrk);
                    } else {
                        $this->registra->ViewValue = $this->registra->CurrentValue;
                    }
                }
            } else {
                $this->registra->ViewValue = null;
            }

            // modificacion
            $this->modificacion->ViewValue = $this->modificacion->CurrentValue;
            $this->modificacion->ViewValue = FormatDateTime($this->modificacion->ViewValue, $this->modificacion->formatPattern());

            // modifica
            $curVal = strval($this->modifica->CurrentValue);
            if ($curVal != "") {
                $this->modifica->ViewValue = $this->modifica->lookupCacheOption($curVal);
                if ($this->modifica->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->modifica->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->modifica->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->modifica->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->modifica->Lookup->renderViewRow($rswrk[0]);
                        $this->modifica->ViewValue = $this->modifica->displayValue($arwrk);
                    } else {
                        $this->modifica->ViewValue = $this->modifica->CurrentValue;
                    }
                }
            } else {
                $this->modifica->ViewValue = null;
            }

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

            // contrato
            $this->contrato->ViewValue = $this->contrato->CurrentValue;

            // maqueteo
            $curVal = strval($this->maqueteo->CurrentValue);
            if ($curVal != "") {
                $this->maqueteo->ViewValue = $this->maqueteo->lookupCacheOption($curVal);
                if ($this->maqueteo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->maqueteo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->maqueteo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->maqueteo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->maqueteo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->maqueteo->Lookup->renderViewRow($rswrk[0]);
                        $this->maqueteo->ViewValue = $this->maqueteo->displayValue($arwrk);
                    } else {
                        $this->maqueteo->ViewValue = $this->maqueteo->CurrentValue;
                    }
                }
            } else {
                $this->maqueteo->ViewValue = null;
            }

            // coordenadas_maqueta
            $this->coordenadas_maqueta->ViewValue = $this->coordenadas_maqueta->CurrentValue;

            // reclamo
            $this->reclamo->ViewValue = $this->reclamo->CurrentValue;

            // solicitante
            $this->solicitante->HrefValue = "";

            // parentesco
            $this->parentesco->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // nombre_difunto
            $this->nombre_difunto->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // comentario
            $this->comentario->HrefValue = "";

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

            // contrato
            $this->contrato->HrefValue = "";

            // maqueteo
            $this->maqueteo->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // solicitante
            $this->solicitante->setupEditAttributes();
            if (!$this->solicitante->Raw) {
                $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
            }
            $this->solicitante->EditValue = HtmlEncode($this->solicitante->CurrentValue);
            $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

            // parentesco
            $this->parentesco->setupEditAttributes();
            $curVal = trim(strval($this->parentesco->CurrentValue));
            if ($curVal != "") {
                $this->parentesco->ViewValue = $this->parentesco->lookupCacheOption($curVal);
            } else {
                $this->parentesco->ViewValue = $this->parentesco->Lookup !== null && is_array($this->parentesco->lookupOptions()) && count($this->parentesco->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->parentesco->ViewValue !== null) { // Load from cache
                $this->parentesco->EditValue = array_values($this->parentesco->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->parentesco->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $this->parentesco->CurrentValue, $this->parentesco->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                }
                $lookupFilter = $this->parentesco->getSelectFilter($this); // PHP
                $sqlWrk = $this->parentesco->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->parentesco->EditValue = $arwrk;
            }
            $this->parentesco->PlaceHolder = RemoveHtml($this->parentesco->caption());

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

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // ci_difunto
            $this->ci_difunto->setupEditAttributes();
            if (!$this->ci_difunto->Raw) {
                $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
            }
            $this->ci_difunto->EditValue = HtmlEncode($this->ci_difunto->CurrentValue);
            $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

            // nombre_difunto
            $this->nombre_difunto->setupEditAttributes();
            if (!$this->nombre_difunto->Raw) {
                $this->nombre_difunto->CurrentValue = HtmlDecode($this->nombre_difunto->CurrentValue);
            }
            $this->nombre_difunto->EditValue = HtmlEncode($this->nombre_difunto->CurrentValue);
            $this->nombre_difunto->PlaceHolder = RemoveHtml($this->nombre_difunto->caption());

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
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->tipo->CurrentValue, $this->tipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->tipo->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo->EditValue = $arwrk;
            }
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // comentario
            $this->comentario->setupEditAttributes();
            $this->comentario->EditValue = HtmlEncode($this->comentario->CurrentValue);
            $this->comentario->PlaceHolder = RemoveHtml($this->comentario->caption());

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

            // contrato
            $this->contrato->setupEditAttributes();
            if (!$this->contrato->Raw) {
                $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
            }
            $this->contrato->EditValue = HtmlEncode($this->contrato->CurrentValue);
            $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());

            // maqueteo
            $this->maqueteo->setupEditAttributes();
            $curVal = trim(strval($this->maqueteo->CurrentValue));
            if ($curVal != "") {
                $this->maqueteo->ViewValue = $this->maqueteo->lookupCacheOption($curVal);
            } else {
                $this->maqueteo->ViewValue = $this->maqueteo->Lookup !== null && is_array($this->maqueteo->lookupOptions()) && count($this->maqueteo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->maqueteo->ViewValue !== null) { // Load from cache
                $this->maqueteo->EditValue = array_values($this->maqueteo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->maqueteo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->maqueteo->CurrentValue, $this->maqueteo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->maqueteo->getSelectFilter($this); // PHP
                $sqlWrk = $this->maqueteo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->maqueteo->EditValue = $arwrk;
            }
            $this->maqueteo->PlaceHolder = RemoveHtml($this->maqueteo->caption());

            // Add refer script

            // solicitante
            $this->solicitante->HrefValue = "";

            // parentesco
            $this->parentesco->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // nombre_difunto
            $this->nombre_difunto->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // comentario
            $this->comentario->HrefValue = "";

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

            // contrato
            $this->contrato->HrefValue = "";

            // maqueteo
            $this->maqueteo->HrefValue = "";
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
            if ($this->solicitante->Visible && $this->solicitante->Required) {
                if (!$this->solicitante->IsDetailKey && EmptyValue($this->solicitante->FormValue)) {
                    $this->solicitante->addErrorMessage(str_replace("%s", $this->solicitante->caption(), $this->solicitante->RequiredErrorMessage));
                }
            }
            if ($this->parentesco->Visible && $this->parentesco->Required) {
                if (!$this->parentesco->IsDetailKey && EmptyValue($this->parentesco->FormValue)) {
                    $this->parentesco->addErrorMessage(str_replace("%s", $this->parentesco->caption(), $this->parentesco->RequiredErrorMessage));
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
            if ($this->_email->Visible && $this->_email->Required) {
                if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                    $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
                }
            }
            if (!CheckEmail($this->_email->FormValue)) {
                $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
            }
            if ($this->ci_difunto->Visible && $this->ci_difunto->Required) {
                if (!$this->ci_difunto->IsDetailKey && EmptyValue($this->ci_difunto->FormValue)) {
                    $this->ci_difunto->addErrorMessage(str_replace("%s", $this->ci_difunto->caption(), $this->ci_difunto->RequiredErrorMessage));
                }
            }
            if ($this->nombre_difunto->Visible && $this->nombre_difunto->Required) {
                if (!$this->nombre_difunto->IsDetailKey && EmptyValue($this->nombre_difunto->FormValue)) {
                    $this->nombre_difunto->addErrorMessage(str_replace("%s", $this->nombre_difunto->caption(), $this->nombre_difunto->RequiredErrorMessage));
                }
            }
            if ($this->tipo->Visible && $this->tipo->Required) {
                if (!$this->tipo->IsDetailKey && EmptyValue($this->tipo->FormValue)) {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->comentario->Visible && $this->comentario->Required) {
                if (!$this->comentario->IsDetailKey && EmptyValue($this->comentario->FormValue)) {
                    $this->comentario->addErrorMessage(str_replace("%s", $this->comentario->caption(), $this->comentario->RequiredErrorMessage));
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
            if ($this->contrato->Visible && $this->contrato->Required) {
                if (!$this->contrato->IsDetailKey && EmptyValue($this->contrato->FormValue)) {
                    $this->contrato->addErrorMessage(str_replace("%s", $this->contrato->caption(), $this->contrato->RequiredErrorMessage));
                }
            }
            if ($this->maqueteo->Visible && $this->maqueteo->Required) {
                if (!$this->maqueteo->IsDetailKey && EmptyValue($this->maqueteo->FormValue)) {
                    $this->maqueteo->addErrorMessage(str_replace("%s", $this->maqueteo->caption(), $this->maqueteo->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoLapidasNotasGrid");
        if (in_array("sco_lapidas_notas", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoLapidasAdjuntoGrid");
        if (in_array("sco_lapidas_adjunto", $detailTblVar) && $detailPage->DetailAdd) {
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
            $detailPage = Container("ScoLapidasNotasGrid");
            if (in_array("sco_lapidas_notas", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->lapida_registro->setSessionValue($this->Nlapidas_registro->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_lapidas_notas"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->lapida_registro->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoLapidasAdjuntoGrid");
            if (in_array("sco_lapidas_adjunto", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->lapida_registro->setSessionValue($this->Nlapidas_registro->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_lapidas_adjunto"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->lapida_registro->setSessionValue(""); // Clear master key if insert failed
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

        // solicitante
        $this->solicitante->setDbValueDef($rsnew, $this->solicitante->CurrentValue, false);

        // parentesco
        $this->parentesco->setDbValueDef($rsnew, $this->parentesco->CurrentValue, false);

        // telefono1
        $this->telefono1->setDbValueDef($rsnew, $this->telefono1->CurrentValue, false);

        // telefono2
        $this->telefono2->setDbValueDef($rsnew, $this->telefono2->CurrentValue, false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, false);

        // ci_difunto
        $this->ci_difunto->setDbValueDef($rsnew, $this->ci_difunto->CurrentValue, false);

        // nombre_difunto
        $this->nombre_difunto->setDbValueDef($rsnew, $this->nombre_difunto->CurrentValue, false);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, false);

        // comentario
        $this->comentario->setDbValueDef($rsnew, $this->comentario->CurrentValue, false);

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

        // contrato
        $this->contrato->setDbValueDef($rsnew, $this->contrato->CurrentValue, strval($this->contrato->CurrentValue) == "");

        // maqueteo
        $this->maqueteo->setDbValueDef($rsnew, $this->maqueteo->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['solicitante'])) { // solicitante
            $this->solicitante->setFormValue($row['solicitante']);
        }
        if (isset($row['parentesco'])) { // parentesco
            $this->parentesco->setFormValue($row['parentesco']);
        }
        if (isset($row['telefono1'])) { // telefono1
            $this->telefono1->setFormValue($row['telefono1']);
        }
        if (isset($row['telefono2'])) { // telefono2
            $this->telefono2->setFormValue($row['telefono2']);
        }
        if (isset($row['email'])) { // email
            $this->_email->setFormValue($row['email']);
        }
        if (isset($row['ci_difunto'])) { // ci_difunto
            $this->ci_difunto->setFormValue($row['ci_difunto']);
        }
        if (isset($row['nombre_difunto'])) { // nombre_difunto
            $this->nombre_difunto->setFormValue($row['nombre_difunto']);
        }
        if (isset($row['tipo'])) { // tipo
            $this->tipo->setFormValue($row['tipo']);
        }
        if (isset($row['comentario'])) { // comentario
            $this->comentario->setFormValue($row['comentario']);
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
        if (isset($row['contrato'])) { // contrato
            $this->contrato->setFormValue($row['contrato']);
        }
        if (isset($row['maqueteo'])) { // maqueteo
            $this->maqueteo->setFormValue($row['maqueteo']);
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
            if (in_array("sco_lapidas_notas", $detailTblVar)) {
                $detailPageObj = Container("ScoLapidasNotasGrid");
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
                    $detailPageObj->lapida_registro->IsDetailKey = true;
                    $detailPageObj->lapida_registro->CurrentValue = $this->Nlapidas_registro->CurrentValue;
                    $detailPageObj->lapida_registro->setSessionValue($detailPageObj->lapida_registro->CurrentValue);
                }
            }
            if (in_array("sco_lapidas_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoLapidasAdjuntoGrid");
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
                    $detailPageObj->lapida_registro->IsDetailKey = true;
                    $detailPageObj->lapida_registro->CurrentValue = $this->Nlapidas_registro->CurrentValue;
                    $detailPageObj->lapida_registro->setSessionValue($detailPageObj->lapida_registro->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoLapidasRegistroList"), "", $this->TableVar, true);
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
                case "x_parentesco":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_tipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    break;
                case "x_registra":
                    break;
                case "x_modifica":
                    break;
                case "x_maqueteo":
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
    public function pageDataRendered(&$footer) {
    	// Example:
    	//$footer = "your footer";
    	$footer = '<div id="maqueta" class="container"></div>';
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
