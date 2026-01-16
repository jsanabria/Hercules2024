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
class ScoEmbalajeAdd extends ScoEmbalaje
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoEmbalajeAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoEmbalajeAdd";

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
        $this->Nembalaje->Visible = false;
        $this->expediente->Visible = false;
        $this->fecha->Visible = false;
        $this->precinto1->setVisibility();
        $this->precinto2->setVisibility();
        $this->nombre_familiar->setVisibility();
        $this->cedula_familiar->setVisibility();
        $this->certificado_defuncion->setVisibility();
        $this->fecha_servicio->setVisibility();
        $this->doctor->Visible = false;
        $this->doctor_nro->Visible = false;
        $this->cremacion_nro->setVisibility();
        $this->registro_civil->setVisibility();
        $this->dimension_cofre->setVisibility();
        $this->nota->setVisibility();
        $this->_username->Visible = false;
        $this->anulado->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_embalaje';
        $this->TableName = 'sco_embalaje';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_embalaje)
        if (!isset($GLOBALS["sco_embalaje"]) || $GLOBALS["sco_embalaje"]::class == PROJECT_NAMESPACE . "sco_embalaje") {
            $GLOBALS["sco_embalaje"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_embalaje');
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
                        $result["view"] = SameString($pageName, "ScoEmbalajeView"); // If View page, no primary button
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
            $key .= @$ar['Nembalaje'];
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
            $this->Nembalaje->Visible = false;
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
        $this->setupLookupOptions($this->_username);
        $this->setupLookupOptions($this->anulado);

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
            if (($keyValue = Get("Nembalaje") ?? Route("Nembalaje")) !== null) {
                $this->Nembalaje->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoEmbalajeList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ScoEmbalajeList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoEmbalajeView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoEmbalajeList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoEmbalajeList"; // Return list page content
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
        $this->anulado->DefaultValue = $this->anulado->getDefault(); // PHP
        $this->anulado->OldValue = $this->anulado->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'precinto1' first before field var 'x_precinto1'
        $val = $CurrentForm->hasValue("precinto1") ? $CurrentForm->getValue("precinto1") : $CurrentForm->getValue("x_precinto1");
        if (!$this->precinto1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->precinto1->Visible = false; // Disable update for API request
            } else {
                $this->precinto1->setFormValue($val);
            }
        }

        // Check field name 'precinto2' first before field var 'x_precinto2'
        $val = $CurrentForm->hasValue("precinto2") ? $CurrentForm->getValue("precinto2") : $CurrentForm->getValue("x_precinto2");
        if (!$this->precinto2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->precinto2->Visible = false; // Disable update for API request
            } else {
                $this->precinto2->setFormValue($val);
            }
        }

        // Check field name 'nombre_familiar' first before field var 'x_nombre_familiar'
        $val = $CurrentForm->hasValue("nombre_familiar") ? $CurrentForm->getValue("nombre_familiar") : $CurrentForm->getValue("x_nombre_familiar");
        if (!$this->nombre_familiar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_familiar->Visible = false; // Disable update for API request
            } else {
                $this->nombre_familiar->setFormValue($val);
            }
        }

        // Check field name 'cedula_familiar' first before field var 'x_cedula_familiar'
        $val = $CurrentForm->hasValue("cedula_familiar") ? $CurrentForm->getValue("cedula_familiar") : $CurrentForm->getValue("x_cedula_familiar");
        if (!$this->cedula_familiar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula_familiar->Visible = false; // Disable update for API request
            } else {
                $this->cedula_familiar->setFormValue($val);
            }
        }

        // Check field name 'certificado_defuncion' first before field var 'x_certificado_defuncion'
        $val = $CurrentForm->hasValue("certificado_defuncion") ? $CurrentForm->getValue("certificado_defuncion") : $CurrentForm->getValue("x_certificado_defuncion");
        if (!$this->certificado_defuncion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->certificado_defuncion->Visible = false; // Disable update for API request
            } else {
                $this->certificado_defuncion->setFormValue($val);
            }
        }

        // Check field name 'fecha_servicio' first before field var 'x_fecha_servicio'
        $val = $CurrentForm->hasValue("fecha_servicio") ? $CurrentForm->getValue("fecha_servicio") : $CurrentForm->getValue("x_fecha_servicio");
        if (!$this->fecha_servicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_servicio->Visible = false; // Disable update for API request
            } else {
                $this->fecha_servicio->setFormValue($val, true, $validate);
            }
            $this->fecha_servicio->CurrentValue = UnFormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern());
        }

        // Check field name 'cremacion_nro' first before field var 'x_cremacion_nro'
        $val = $CurrentForm->hasValue("cremacion_nro") ? $CurrentForm->getValue("cremacion_nro") : $CurrentForm->getValue("x_cremacion_nro");
        if (!$this->cremacion_nro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cremacion_nro->Visible = false; // Disable update for API request
            } else {
                $this->cremacion_nro->setFormValue($val);
            }
        }

        // Check field name 'registro_civil' first before field var 'x_registro_civil'
        $val = $CurrentForm->hasValue("registro_civil") ? $CurrentForm->getValue("registro_civil") : $CurrentForm->getValue("x_registro_civil");
        if (!$this->registro_civil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->registro_civil->Visible = false; // Disable update for API request
            } else {
                $this->registro_civil->setFormValue($val);
            }
        }

        // Check field name 'dimension_cofre' first before field var 'x_dimension_cofre'
        $val = $CurrentForm->hasValue("dimension_cofre") ? $CurrentForm->getValue("dimension_cofre") : $CurrentForm->getValue("x_dimension_cofre");
        if (!$this->dimension_cofre->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dimension_cofre->Visible = false; // Disable update for API request
            } else {
                $this->dimension_cofre->setFormValue($val);
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

        // Check field name 'Nembalaje' first before field var 'x_Nembalaje'
        $val = $CurrentForm->hasValue("Nembalaje") ? $CurrentForm->getValue("Nembalaje") : $CurrentForm->getValue("x_Nembalaje");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->precinto1->CurrentValue = $this->precinto1->FormValue;
        $this->precinto2->CurrentValue = $this->precinto2->FormValue;
        $this->nombre_familiar->CurrentValue = $this->nombre_familiar->FormValue;
        $this->cedula_familiar->CurrentValue = $this->cedula_familiar->FormValue;
        $this->certificado_defuncion->CurrentValue = $this->certificado_defuncion->FormValue;
        $this->fecha_servicio->CurrentValue = $this->fecha_servicio->FormValue;
        $this->fecha_servicio->CurrentValue = UnFormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern());
        $this->cremacion_nro->CurrentValue = $this->cremacion_nro->FormValue;
        $this->registro_civil->CurrentValue = $this->registro_civil->FormValue;
        $this->dimension_cofre->CurrentValue = $this->dimension_cofre->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
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
        $this->Nembalaje->setDbValue($row['Nembalaje']);
        $this->expediente->setDbValue($row['expediente']);
        $this->fecha->setDbValue($row['fecha']);
        $this->precinto1->setDbValue($row['precinto1']);
        $this->precinto2->setDbValue($row['precinto2']);
        $this->nombre_familiar->setDbValue($row['nombre_familiar']);
        $this->cedula_familiar->setDbValue($row['cedula_familiar']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->fecha_servicio->setDbValue($row['fecha_servicio']);
        $this->doctor->setDbValue($row['doctor']);
        $this->doctor_nro->setDbValue($row['doctor_nro']);
        $this->cremacion_nro->setDbValue($row['cremacion_nro']);
        $this->registro_civil->setDbValue($row['registro_civil']);
        $this->dimension_cofre->setDbValue($row['dimension_cofre']);
        $this->nota->setDbValue($row['nota']);
        $this->_username->setDbValue($row['username']);
        $this->anulado->setDbValue($row['anulado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nembalaje'] = $this->Nembalaje->DefaultValue;
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
        $row['precinto1'] = $this->precinto1->DefaultValue;
        $row['precinto2'] = $this->precinto2->DefaultValue;
        $row['nombre_familiar'] = $this->nombre_familiar->DefaultValue;
        $row['cedula_familiar'] = $this->cedula_familiar->DefaultValue;
        $row['certificado_defuncion'] = $this->certificado_defuncion->DefaultValue;
        $row['fecha_servicio'] = $this->fecha_servicio->DefaultValue;
        $row['doctor'] = $this->doctor->DefaultValue;
        $row['doctor_nro'] = $this->doctor_nro->DefaultValue;
        $row['cremacion_nro'] = $this->cremacion_nro->DefaultValue;
        $row['registro_civil'] = $this->registro_civil->DefaultValue;
        $row['dimension_cofre'] = $this->dimension_cofre->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['anulado'] = $this->anulado->DefaultValue;
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

        // Nembalaje
        $this->Nembalaje->RowCssClass = "row";

        // expediente
        $this->expediente->RowCssClass = "row";

        // fecha
        $this->fecha->RowCssClass = "row";

        // precinto1
        $this->precinto1->RowCssClass = "row";

        // precinto2
        $this->precinto2->RowCssClass = "row";

        // nombre_familiar
        $this->nombre_familiar->RowCssClass = "row";

        // cedula_familiar
        $this->cedula_familiar->RowCssClass = "row";

        // certificado_defuncion
        $this->certificado_defuncion->RowCssClass = "row";

        // fecha_servicio
        $this->fecha_servicio->RowCssClass = "row";

        // doctor
        $this->doctor->RowCssClass = "row";

        // doctor_nro
        $this->doctor_nro->RowCssClass = "row";

        // cremacion_nro
        $this->cremacion_nro->RowCssClass = "row";

        // registro_civil
        $this->registro_civil->RowCssClass = "row";

        // dimension_cofre
        $this->dimension_cofre->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // username
        $this->_username->RowCssClass = "row";

        // anulado
        $this->anulado->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nembalaje
            $this->Nembalaje->ViewValue = $this->Nembalaje->CurrentValue;

            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // precinto1
            $this->precinto1->ViewValue = $this->precinto1->CurrentValue;

            // precinto2
            $this->precinto2->ViewValue = $this->precinto2->CurrentValue;

            // nombre_familiar
            $this->nombre_familiar->ViewValue = $this->nombre_familiar->CurrentValue;

            // cedula_familiar
            $this->cedula_familiar->ViewValue = $this->cedula_familiar->CurrentValue;

            // certificado_defuncion
            $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

            // fecha_servicio
            $this->fecha_servicio->ViewValue = $this->fecha_servicio->CurrentValue;
            $this->fecha_servicio->ViewValue = FormatDateTime($this->fecha_servicio->ViewValue, $this->fecha_servicio->formatPattern());

            // doctor
            $this->doctor->ViewValue = $this->doctor->CurrentValue;

            // doctor_nro
            $this->doctor_nro->ViewValue = $this->doctor_nro->CurrentValue;

            // cremacion_nro
            $this->cremacion_nro->ViewValue = $this->cremacion_nro->CurrentValue;

            // registro_civil
            $this->registro_civil->ViewValue = $this->registro_civil->CurrentValue;

            // dimension_cofre
            $this->dimension_cofre->ViewValue = $this->dimension_cofre->CurrentValue;

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // username
            $this->_username->ViewValue = $this->_username->CurrentValue;
            $curVal = strval($this->_username->CurrentValue);
            if ($curVal != "") {
                $this->_username->ViewValue = $this->_username->lookupCacheOption($curVal);
                if ($this->_username->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->_username->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->_username->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->_username->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_username->Lookup->renderViewRow($rswrk[0]);
                        $this->_username->ViewValue = $this->_username->displayValue($arwrk);
                    } else {
                        $this->_username->ViewValue = $this->_username->CurrentValue;
                    }
                }
            } else {
                $this->_username->ViewValue = null;
            }

            // anulado
            if (strval($this->anulado->CurrentValue) != "") {
                $this->anulado->ViewValue = $this->anulado->optionCaption($this->anulado->CurrentValue);
            } else {
                $this->anulado->ViewValue = null;
            }

            // precinto1
            $this->precinto1->HrefValue = "";

            // precinto2
            $this->precinto2->HrefValue = "";

            // nombre_familiar
            $this->nombre_familiar->HrefValue = "";

            // cedula_familiar
            $this->cedula_familiar->HrefValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";

            // fecha_servicio
            $this->fecha_servicio->HrefValue = "";

            // cremacion_nro
            $this->cremacion_nro->HrefValue = "";

            // registro_civil
            $this->registro_civil->HrefValue = "";

            // dimension_cofre
            $this->dimension_cofre->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // precinto1
            $this->precinto1->setupEditAttributes();
            if (!$this->precinto1->Raw) {
                $this->precinto1->CurrentValue = HtmlDecode($this->precinto1->CurrentValue);
            }
            $this->precinto1->EditValue = HtmlEncode($this->precinto1->CurrentValue);
            $this->precinto1->PlaceHolder = RemoveHtml($this->precinto1->caption());

            // precinto2
            $this->precinto2->setupEditAttributes();
            if (!$this->precinto2->Raw) {
                $this->precinto2->CurrentValue = HtmlDecode($this->precinto2->CurrentValue);
            }
            $this->precinto2->EditValue = HtmlEncode($this->precinto2->CurrentValue);
            $this->precinto2->PlaceHolder = RemoveHtml($this->precinto2->caption());

            // nombre_familiar
            $this->nombre_familiar->setupEditAttributes();
            if (!$this->nombre_familiar->Raw) {
                $this->nombre_familiar->CurrentValue = HtmlDecode($this->nombre_familiar->CurrentValue);
            }
            $this->nombre_familiar->EditValue = HtmlEncode($this->nombre_familiar->CurrentValue);
            $this->nombre_familiar->PlaceHolder = RemoveHtml($this->nombre_familiar->caption());

            // cedula_familiar
            $this->cedula_familiar->setupEditAttributes();
            if (!$this->cedula_familiar->Raw) {
                $this->cedula_familiar->CurrentValue = HtmlDecode($this->cedula_familiar->CurrentValue);
            }
            $this->cedula_familiar->EditValue = HtmlEncode($this->cedula_familiar->CurrentValue);
            $this->cedula_familiar->PlaceHolder = RemoveHtml($this->cedula_familiar->caption());

            // certificado_defuncion
            $this->certificado_defuncion->setupEditAttributes();
            if (!$this->certificado_defuncion->Raw) {
                $this->certificado_defuncion->CurrentValue = HtmlDecode($this->certificado_defuncion->CurrentValue);
            }
            $this->certificado_defuncion->EditValue = HtmlEncode($this->certificado_defuncion->CurrentValue);
            $this->certificado_defuncion->PlaceHolder = RemoveHtml($this->certificado_defuncion->caption());

            // fecha_servicio
            $this->fecha_servicio->setupEditAttributes();
            $this->fecha_servicio->EditValue = HtmlEncode(FormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern()));
            $this->fecha_servicio->PlaceHolder = RemoveHtml($this->fecha_servicio->caption());

            // cremacion_nro
            $this->cremacion_nro->setupEditAttributes();
            if (!$this->cremacion_nro->Raw) {
                $this->cremacion_nro->CurrentValue = HtmlDecode($this->cremacion_nro->CurrentValue);
            }
            $this->cremacion_nro->EditValue = HtmlEncode($this->cremacion_nro->CurrentValue);
            $this->cremacion_nro->PlaceHolder = RemoveHtml($this->cremacion_nro->caption());

            // registro_civil
            $this->registro_civil->setupEditAttributes();
            if (!$this->registro_civil->Raw) {
                $this->registro_civil->CurrentValue = HtmlDecode($this->registro_civil->CurrentValue);
            }
            $this->registro_civil->EditValue = HtmlEncode($this->registro_civil->CurrentValue);
            $this->registro_civil->PlaceHolder = RemoveHtml($this->registro_civil->caption());

            // dimension_cofre
            $this->dimension_cofre->setupEditAttributes();
            if (!$this->dimension_cofre->Raw) {
                $this->dimension_cofre->CurrentValue = HtmlDecode($this->dimension_cofre->CurrentValue);
            }
            $this->dimension_cofre->EditValue = HtmlEncode($this->dimension_cofre->CurrentValue);
            $this->dimension_cofre->PlaceHolder = RemoveHtml($this->dimension_cofre->caption());

            // nota
            $this->nota->setupEditAttributes();
            if (!$this->nota->Raw) {
                $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
            }
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // Add refer script

            // precinto1
            $this->precinto1->HrefValue = "";

            // precinto2
            $this->precinto2->HrefValue = "";

            // nombre_familiar
            $this->nombre_familiar->HrefValue = "";

            // cedula_familiar
            $this->cedula_familiar->HrefValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";

            // fecha_servicio
            $this->fecha_servicio->HrefValue = "";

            // cremacion_nro
            $this->cremacion_nro->HrefValue = "";

            // registro_civil
            $this->registro_civil->HrefValue = "";

            // dimension_cofre
            $this->dimension_cofre->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";
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
            if ($this->precinto1->Visible && $this->precinto1->Required) {
                if (!$this->precinto1->IsDetailKey && EmptyValue($this->precinto1->FormValue)) {
                    $this->precinto1->addErrorMessage(str_replace("%s", $this->precinto1->caption(), $this->precinto1->RequiredErrorMessage));
                }
            }
            if ($this->precinto2->Visible && $this->precinto2->Required) {
                if (!$this->precinto2->IsDetailKey && EmptyValue($this->precinto2->FormValue)) {
                    $this->precinto2->addErrorMessage(str_replace("%s", $this->precinto2->caption(), $this->precinto2->RequiredErrorMessage));
                }
            }
            if ($this->nombre_familiar->Visible && $this->nombre_familiar->Required) {
                if (!$this->nombre_familiar->IsDetailKey && EmptyValue($this->nombre_familiar->FormValue)) {
                    $this->nombre_familiar->addErrorMessage(str_replace("%s", $this->nombre_familiar->caption(), $this->nombre_familiar->RequiredErrorMessage));
                }
            }
            if ($this->cedula_familiar->Visible && $this->cedula_familiar->Required) {
                if (!$this->cedula_familiar->IsDetailKey && EmptyValue($this->cedula_familiar->FormValue)) {
                    $this->cedula_familiar->addErrorMessage(str_replace("%s", $this->cedula_familiar->caption(), $this->cedula_familiar->RequiredErrorMessage));
                }
            }
            if ($this->certificado_defuncion->Visible && $this->certificado_defuncion->Required) {
                if (!$this->certificado_defuncion->IsDetailKey && EmptyValue($this->certificado_defuncion->FormValue)) {
                    $this->certificado_defuncion->addErrorMessage(str_replace("%s", $this->certificado_defuncion->caption(), $this->certificado_defuncion->RequiredErrorMessage));
                }
            }
            if ($this->fecha_servicio->Visible && $this->fecha_servicio->Required) {
                if (!$this->fecha_servicio->IsDetailKey && EmptyValue($this->fecha_servicio->FormValue)) {
                    $this->fecha_servicio->addErrorMessage(str_replace("%s", $this->fecha_servicio->caption(), $this->fecha_servicio->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_servicio->FormValue, $this->fecha_servicio->formatPattern())) {
                $this->fecha_servicio->addErrorMessage($this->fecha_servicio->getErrorMessage(false));
            }
            if ($this->cremacion_nro->Visible && $this->cremacion_nro->Required) {
                if (!$this->cremacion_nro->IsDetailKey && EmptyValue($this->cremacion_nro->FormValue)) {
                    $this->cremacion_nro->addErrorMessage(str_replace("%s", $this->cremacion_nro->caption(), $this->cremacion_nro->RequiredErrorMessage));
                }
            }
            if ($this->registro_civil->Visible && $this->registro_civil->Required) {
                if (!$this->registro_civil->IsDetailKey && EmptyValue($this->registro_civil->FormValue)) {
                    $this->registro_civil->addErrorMessage(str_replace("%s", $this->registro_civil->caption(), $this->registro_civil->RequiredErrorMessage));
                }
            }
            if ($this->dimension_cofre->Visible && $this->dimension_cofre->Required) {
                if (!$this->dimension_cofre->IsDetailKey && EmptyValue($this->dimension_cofre->FormValue)) {
                    $this->dimension_cofre->addErrorMessage(str_replace("%s", $this->dimension_cofre->caption(), $this->dimension_cofre->RequiredErrorMessage));
                }
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
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

        // precinto1
        $this->precinto1->setDbValueDef($rsnew, $this->precinto1->CurrentValue, false);

        // precinto2
        $this->precinto2->setDbValueDef($rsnew, $this->precinto2->CurrentValue, false);

        // nombre_familiar
        $this->nombre_familiar->setDbValueDef($rsnew, $this->nombre_familiar->CurrentValue, false);

        // cedula_familiar
        $this->cedula_familiar->setDbValueDef($rsnew, $this->cedula_familiar->CurrentValue, false);

        // certificado_defuncion
        $this->certificado_defuncion->setDbValueDef($rsnew, $this->certificado_defuncion->CurrentValue, false);

        // fecha_servicio
        $this->fecha_servicio->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern()), false);

        // cremacion_nro
        $this->cremacion_nro->setDbValueDef($rsnew, $this->cremacion_nro->CurrentValue, false);

        // registro_civil
        $this->registro_civil->setDbValueDef($rsnew, $this->registro_civil->CurrentValue, false);

        // dimension_cofre
        $this->dimension_cofre->setDbValueDef($rsnew, $this->dimension_cofre->CurrentValue, false);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, false);

        // expediente
        if ($this->expediente->getSessionValue() != "") {
            $rsnew['expediente'] = $this->expediente->getSessionValue();
        }
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['precinto1'])) { // precinto1
            $this->precinto1->setFormValue($row['precinto1']);
        }
        if (isset($row['precinto2'])) { // precinto2
            $this->precinto2->setFormValue($row['precinto2']);
        }
        if (isset($row['nombre_familiar'])) { // nombre_familiar
            $this->nombre_familiar->setFormValue($row['nombre_familiar']);
        }
        if (isset($row['cedula_familiar'])) { // cedula_familiar
            $this->cedula_familiar->setFormValue($row['cedula_familiar']);
        }
        if (isset($row['certificado_defuncion'])) { // certificado_defuncion
            $this->certificado_defuncion->setFormValue($row['certificado_defuncion']);
        }
        if (isset($row['fecha_servicio'])) { // fecha_servicio
            $this->fecha_servicio->setFormValue($row['fecha_servicio']);
        }
        if (isset($row['cremacion_nro'])) { // cremacion_nro
            $this->cremacion_nro->setFormValue($row['cremacion_nro']);
        }
        if (isset($row['registro_civil'])) { // registro_civil
            $this->registro_civil->setFormValue($row['registro_civil']);
        }
        if (isset($row['dimension_cofre'])) { // dimension_cofre
            $this->dimension_cofre->setFormValue($row['dimension_cofre']);
        }
        if (isset($row['nota'])) { // nota
            $this->nota->setFormValue($row['nota']);
        }
        if (isset($row['expediente'])) { // expediente
            $this->expediente->setFormValue($row['expediente']);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoEmbalajeList"), "", $this->TableVar, true);
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
                case "x__username":
                    break;
                case "x_anulado":
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
