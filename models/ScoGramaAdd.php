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
class ScoGramaAdd extends ScoGrama
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoGramaAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoGramaAdd";

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
        $this->Ngrama->Visible = false;
        $this->ci_solicitante->Visible = false;
        $this->solicitante->Visible = false;
        $this->telefono1->Visible = false;
        $this->telefono2->Visible = false;
        $this->_email->Visible = false;
        $this->tipo->Visible = false;
        $this->subtipo->Visible = false;
        $this->monto->Visible = false;
        $this->tasa->Visible = false;
        $this->monto_bs->Visible = false;
        $this->nota->Visible = false;
        $this->contrato->setVisibility();
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->setVisibility();
        $this->ci_difunto->setVisibility();
        $this->apellido1->setVisibility();
        $this->apellido2->setVisibility();
        $this->nombre1->setVisibility();
        $this->nombre2->setVisibility();
        $this->fecha_solucion->Visible = false;
        $this->fecha_desde->Visible = false;
        $this->fecha_hasta->Visible = false;
        $this->estatus->Visible = false;
        $this->fecha_registro->Visible = false;
        $this->usuario_registro->Visible = false;
        $this->email_renovacion->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_grama';
        $this->TableName = 'sco_grama';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_grama)
        if (!isset($GLOBALS["sco_grama"]) || $GLOBALS["sco_grama"]::class == PROJECT_NAMESPACE . "sco_grama") {
            $GLOBALS["sco_grama"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_grama');
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
                        $result["view"] = SameString($pageName, "ScoGramaView"); // If View page, no primary button
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
            $key .= @$ar['Ngrama'];
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
            $this->Ngrama->Visible = false;
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
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->subtipo);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->email_renovacion);

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
            if (($keyValue = Get("Ngrama") ?? Route("Ngrama")) !== null) {
                $this->Ngrama->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoGramaList"); // No matching record, return to list
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
                    $returnUrl = $this->getViewUrl();
                    if (GetPageName($returnUrl) == "ScoGramaList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoGramaView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoGramaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoGramaList"; // Return list page content
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
        $this->email_renovacion->DefaultValue = $this->email_renovacion->getDefault(); // PHP
        $this->email_renovacion->OldValue = $this->email_renovacion->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'contrato' first before field var 'x_contrato'
        $val = $CurrentForm->hasValue("contrato") ? $CurrentForm->getValue("contrato") : $CurrentForm->getValue("x_contrato");
        if (!$this->contrato->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contrato->Visible = false; // Disable update for API request
            } else {
                $this->contrato->setFormValue($val);
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

        // Check field name 'ci_difunto' first before field var 'x_ci_difunto'
        $val = $CurrentForm->hasValue("ci_difunto") ? $CurrentForm->getValue("ci_difunto") : $CurrentForm->getValue("x_ci_difunto");
        if (!$this->ci_difunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_difunto->Visible = false; // Disable update for API request
            } else {
                $this->ci_difunto->setFormValue($val);
            }
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

        // Check field name 'apellido2' first before field var 'x_apellido2'
        $val = $CurrentForm->hasValue("apellido2") ? $CurrentForm->getValue("apellido2") : $CurrentForm->getValue("x_apellido2");
        if (!$this->apellido2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellido2->Visible = false; // Disable update for API request
            } else {
                $this->apellido2->setFormValue($val);
            }
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

        // Check field name 'nombre2' first before field var 'x_nombre2'
        $val = $CurrentForm->hasValue("nombre2") ? $CurrentForm->getValue("nombre2") : $CurrentForm->getValue("x_nombre2");
        if (!$this->nombre2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre2->Visible = false; // Disable update for API request
            } else {
                $this->nombre2->setFormValue($val);
            }
        }

        // Check field name 'Ngrama' first before field var 'x_Ngrama'
        $val = $CurrentForm->hasValue("Ngrama") ? $CurrentForm->getValue("Ngrama") : $CurrentForm->getValue("x_Ngrama");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->contrato->CurrentValue = $this->contrato->FormValue;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->sub_seccion->CurrentValue = $this->sub_seccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->boveda->CurrentValue = $this->boveda->FormValue;
        $this->ci_difunto->CurrentValue = $this->ci_difunto->FormValue;
        $this->apellido1->CurrentValue = $this->apellido1->FormValue;
        $this->apellido2->CurrentValue = $this->apellido2->FormValue;
        $this->nombre1->CurrentValue = $this->nombre1->FormValue;
        $this->nombre2->CurrentValue = $this->nombre2->FormValue;
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
        $this->Ngrama->setDbValue($row['Ngrama']);
        $this->ci_solicitante->setDbValue($row['ci_solicitante']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->tipo->setDbValue($row['tipo']);
        $this->subtipo->setDbValue($row['subtipo']);
        $this->monto->setDbValue($row['monto']);
        $this->tasa->setDbValue($row['tasa']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->nota->setDbValue($row['nota']);
        $this->contrato->setDbValue($row['contrato']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->apellido1->setDbValue($row['apellido1']);
        $this->apellido2->setDbValue($row['apellido2']);
        $this->nombre1->setDbValue($row['nombre1']);
        $this->nombre2->setDbValue($row['nombre2']);
        $this->fecha_solucion->setDbValue($row['fecha_solucion']);
        $this->fecha_desde->setDbValue($row['fecha_desde']);
        $this->fecha_hasta->setDbValue($row['fecha_hasta']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->usuario_registro->setDbValue($row['usuario_registro']);
        $this->email_renovacion->setDbValue($row['email_renovacion']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ngrama'] = $this->Ngrama->DefaultValue;
        $row['ci_solicitante'] = $this->ci_solicitante->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['subtipo'] = $this->subtipo->DefaultValue;
        $row['monto'] = $this->monto->DefaultValue;
        $row['tasa'] = $this->tasa->DefaultValue;
        $row['monto_bs'] = $this->monto_bs->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['contrato'] = $this->contrato->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['sub_seccion'] = $this->sub_seccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['boveda'] = $this->boveda->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['apellido1'] = $this->apellido1->DefaultValue;
        $row['apellido2'] = $this->apellido2->DefaultValue;
        $row['nombre1'] = $this->nombre1->DefaultValue;
        $row['nombre2'] = $this->nombre2->DefaultValue;
        $row['fecha_solucion'] = $this->fecha_solucion->DefaultValue;
        $row['fecha_desde'] = $this->fecha_desde->DefaultValue;
        $row['fecha_hasta'] = $this->fecha_hasta->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['usuario_registro'] = $this->usuario_registro->DefaultValue;
        $row['email_renovacion'] = $this->email_renovacion->DefaultValue;
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

        // Ngrama
        $this->Ngrama->RowCssClass = "row";

        // ci_solicitante
        $this->ci_solicitante->RowCssClass = "row";

        // solicitante
        $this->solicitante->RowCssClass = "row";

        // telefono1
        $this->telefono1->RowCssClass = "row";

        // telefono2
        $this->telefono2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // subtipo
        $this->subtipo->RowCssClass = "row";

        // monto
        $this->monto->RowCssClass = "row";

        // tasa
        $this->tasa->RowCssClass = "row";

        // monto_bs
        $this->monto_bs->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // contrato
        $this->contrato->RowCssClass = "row";

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

        // ci_difunto
        $this->ci_difunto->RowCssClass = "row";

        // apellido1
        $this->apellido1->RowCssClass = "row";

        // apellido2
        $this->apellido2->RowCssClass = "row";

        // nombre1
        $this->nombre1->RowCssClass = "row";

        // nombre2
        $this->nombre2->RowCssClass = "row";

        // fecha_solucion
        $this->fecha_solucion->RowCssClass = "row";

        // fecha_desde
        $this->fecha_desde->RowCssClass = "row";

        // fecha_hasta
        $this->fecha_hasta->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // usuario_registro
        $this->usuario_registro->RowCssClass = "row";

        // email_renovacion
        $this->email_renovacion->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ngrama
            $this->Ngrama->ViewValue = $this->Ngrama->CurrentValue;

            // ci_solicitante
            $this->ci_solicitante->ViewValue = $this->ci_solicitante->CurrentValue;

            // solicitante
            $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

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

            // subtipo
            $curVal = strval($this->subtipo->CurrentValue);
            if ($curVal != "") {
                $this->subtipo->ViewValue = $this->subtipo->lookupCacheOption($curVal);
                if ($this->subtipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->subtipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->subtipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->subtipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->subtipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->subtipo->Lookup->renderViewRow($rswrk[0]);
                        $this->subtipo->ViewValue = $this->subtipo->displayValue($arwrk);
                    } else {
                        $this->subtipo->ViewValue = $this->subtipo->CurrentValue;
                    }
                }
            } else {
                $this->subtipo->ViewValue = null;
            }

            // monto
            $this->monto->ViewValue = $this->monto->CurrentValue;
            $this->monto->ViewValue = FormatNumber($this->monto->ViewValue, $this->monto->formatPattern());

            // tasa
            $this->tasa->ViewValue = $this->tasa->CurrentValue;
            $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

            // monto_bs
            $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
            $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

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

            // ci_difunto
            $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

            // apellido1
            $this->apellido1->ViewValue = $this->apellido1->CurrentValue;

            // apellido2
            $this->apellido2->ViewValue = $this->apellido2->CurrentValue;

            // nombre1
            $this->nombre1->ViewValue = $this->nombre1->CurrentValue;

            // nombre2
            $this->nombre2->ViewValue = $this->nombre2->CurrentValue;

            // fecha_solucion
            $this->fecha_solucion->ViewValue = $this->fecha_solucion->CurrentValue;
            $this->fecha_solucion->ViewValue = FormatDateTime($this->fecha_solucion->ViewValue, $this->fecha_solucion->formatPattern());

            // fecha_desde
            $this->fecha_desde->ViewValue = $this->fecha_desde->CurrentValue;
            $this->fecha_desde->ViewValue = FormatDateTime($this->fecha_desde->ViewValue, $this->fecha_desde->formatPattern());

            // fecha_hasta
            $this->fecha_hasta->ViewValue = $this->fecha_hasta->CurrentValue;
            $this->fecha_hasta->ViewValue = FormatDateTime($this->fecha_hasta->ViewValue, $this->fecha_hasta->formatPattern());

            // estatus
            $curVal = strval($this->estatus->CurrentValue);
            if ($curVal != "") {
                $this->estatus->ViewValue = $this->estatus->lookupCacheOption($curVal);
                if ($this->estatus->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->estatus->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
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

            // usuario_registro
            $this->usuario_registro->ViewValue = $this->usuario_registro->CurrentValue;

            // email_renovacion
            if (strval($this->email_renovacion->CurrentValue) != "") {
                $this->email_renovacion->ViewValue = $this->email_renovacion->optionCaption($this->email_renovacion->CurrentValue);
            } else {
                $this->email_renovacion->ViewValue = null;
            }

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

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // contrato
            $this->contrato->setupEditAttributes();
            if (!$this->contrato->Raw) {
                $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
            }
            $this->contrato->EditValue = HtmlEncode($this->contrato->CurrentValue);
            $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());

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

            // ci_difunto
            $this->ci_difunto->setupEditAttributes();
            if (!$this->ci_difunto->Raw) {
                $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
            }
            $this->ci_difunto->EditValue = HtmlEncode($this->ci_difunto->CurrentValue);
            $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

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

            // Add refer script

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

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";
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
            if ($this->ci_difunto->Visible && $this->ci_difunto->Required) {
                if (!$this->ci_difunto->IsDetailKey && EmptyValue($this->ci_difunto->FormValue)) {
                    $this->ci_difunto->addErrorMessage(str_replace("%s", $this->ci_difunto->caption(), $this->ci_difunto->RequiredErrorMessage));
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

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoGramaPagosGrid");
        if (in_array("sco_grama_pagos", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoGramaNotaGrid");
        if (in_array("sco_grama_nota", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoGramaAdjuntoGrid");
        if (in_array("sco_grama_adjunto", $detailTblVar) && $detailPage->DetailAdd) {
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
            $detailPage = Container("ScoGramaPagosGrid");
            if (in_array("sco_grama_pagos", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->grama->setSessionValue($this->Ngrama->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_grama_pagos"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->grama->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoGramaNotaGrid");
            if (in_array("sco_grama_nota", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->grama->setSessionValue($this->Ngrama->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_grama_nota"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->grama->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoGramaAdjuntoGrid");
            if (in_array("sco_grama_adjunto", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->grama->setSessionValue($this->Ngrama->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_grama_adjunto"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->grama->setSessionValue(""); // Clear master key if insert failed
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

        // ci_difunto
        $this->ci_difunto->setDbValueDef($rsnew, $this->ci_difunto->CurrentValue, false);

        // apellido1
        $this->apellido1->setDbValueDef($rsnew, $this->apellido1->CurrentValue, false);

        // apellido2
        $this->apellido2->setDbValueDef($rsnew, $this->apellido2->CurrentValue, false);

        // nombre1
        $this->nombre1->setDbValueDef($rsnew, $this->nombre1->CurrentValue, false);

        // nombre2
        $this->nombre2->setDbValueDef($rsnew, $this->nombre2->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
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
        if (isset($row['ci_difunto'])) { // ci_difunto
            $this->ci_difunto->setFormValue($row['ci_difunto']);
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
            if (in_array("sco_grama_pagos", $detailTblVar)) {
                $detailPageObj = Container("ScoGramaPagosGrid");
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
                    $detailPageObj->grama->IsDetailKey = true;
                    $detailPageObj->grama->CurrentValue = $this->Ngrama->CurrentValue;
                    $detailPageObj->grama->setSessionValue($detailPageObj->grama->CurrentValue);
                }
            }
            if (in_array("sco_grama_nota", $detailTblVar)) {
                $detailPageObj = Container("ScoGramaNotaGrid");
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
                    $detailPageObj->grama->IsDetailKey = true;
                    $detailPageObj->grama->CurrentValue = $this->Ngrama->CurrentValue;
                    $detailPageObj->grama->setSessionValue($detailPageObj->grama->CurrentValue);
                }
            }
            if (in_array("sco_grama_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoGramaAdjuntoGrid");
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
                    $detailPageObj->grama->IsDetailKey = true;
                    $detailPageObj->grama->CurrentValue = $this->Ngrama->CurrentValue;
                    $detailPageObj->grama->setSessionValue($detailPageObj->grama->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoGramaList"), "", $this->TableVar, true);
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
                case "x_tipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_subtipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_email_renovacion":
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
