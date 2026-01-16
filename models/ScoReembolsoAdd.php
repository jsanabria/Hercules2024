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
class ScoReembolsoAdd extends ScoReembolso
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoReembolsoAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoReembolsoAdd";

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
        $this->Nreembolso->Visible = false;
        $this->expediente->Visible = false;
        $this->fecha->Visible = false;
        $this->monto_usd->setVisibility();
        $this->fecha_tasa->Visible = false;
        $this->tasa->Visible = false;
        $this->monto_bs->Visible = false;
        $this->banco->setVisibility();
        $this->nro_cta->setVisibility();
        $this->titular->setVisibility();
        $this->ci_rif->setVisibility();
        $this->correo->setVisibility();
        $this->nro_ref->Visible = false;
        $this->motivo->setVisibility();
        $this->nota->setVisibility();
        $this->estatus->Visible = false;
        $this->coordinador->Visible = false;
        $this->pagador->Visible = false;
        $this->fecha_pago->Visible = false;
        $this->email_enviado->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_reembolso';
        $this->TableName = 'sco_reembolso';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_reembolso)
        if (!isset($GLOBALS["sco_reembolso"]) || $GLOBALS["sco_reembolso"]::class == PROJECT_NAMESPACE . "sco_reembolso") {
            $GLOBALS["sco_reembolso"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_reembolso');
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
                        $result["view"] = SameString($pageName, "ScoReembolsoView"); // If View page, no primary button
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
            $key .= @$ar['Nreembolso'];
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
            $this->Nreembolso->Visible = false;
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
        $this->setupLookupOptions($this->motivo);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->coordinador);
        $this->setupLookupOptions($this->pagador);
        $this->setupLookupOptions($this->email_enviado);

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
            if (($keyValue = Get("Nreembolso") ?? Route("Nreembolso")) !== null) {
                $this->Nreembolso->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoReembolsoList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getViewUrl();
                    if (GetPageName($returnUrl) == "ScoReembolsoList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoReembolsoView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoReembolsoList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoReembolsoList"; // Return list page content
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
        $this->email_enviado->DefaultValue = $this->email_enviado->getDefault(); // PHP
        $this->email_enviado->OldValue = $this->email_enviado->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'monto_usd' first before field var 'x_monto_usd'
        $val = $CurrentForm->hasValue("monto_usd") ? $CurrentForm->getValue("monto_usd") : $CurrentForm->getValue("x_monto_usd");
        if (!$this->monto_usd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto_usd->Visible = false; // Disable update for API request
            } else {
                $this->monto_usd->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'banco' first before field var 'x_banco'
        $val = $CurrentForm->hasValue("banco") ? $CurrentForm->getValue("banco") : $CurrentForm->getValue("x_banco");
        if (!$this->banco->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->banco->Visible = false; // Disable update for API request
            } else {
                $this->banco->setFormValue($val);
            }
        }

        // Check field name 'nro_cta' first before field var 'x_nro_cta'
        $val = $CurrentForm->hasValue("nro_cta") ? $CurrentForm->getValue("nro_cta") : $CurrentForm->getValue("x_nro_cta");
        if (!$this->nro_cta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nro_cta->Visible = false; // Disable update for API request
            } else {
                $this->nro_cta->setFormValue($val);
            }
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

        // Check field name 'ci_rif' first before field var 'x_ci_rif'
        $val = $CurrentForm->hasValue("ci_rif") ? $CurrentForm->getValue("ci_rif") : $CurrentForm->getValue("x_ci_rif");
        if (!$this->ci_rif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_rif->Visible = false; // Disable update for API request
            } else {
                $this->ci_rif->setFormValue($val);
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

        // Check field name 'motivo' first before field var 'x_motivo'
        $val = $CurrentForm->hasValue("motivo") ? $CurrentForm->getValue("motivo") : $CurrentForm->getValue("x_motivo");
        if (!$this->motivo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->motivo->Visible = false; // Disable update for API request
            } else {
                $this->motivo->setFormValue($val);
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

        // Check field name 'Nreembolso' first before field var 'x_Nreembolso'
        $val = $CurrentForm->hasValue("Nreembolso") ? $CurrentForm->getValue("Nreembolso") : $CurrentForm->getValue("x_Nreembolso");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->monto_usd->CurrentValue = $this->monto_usd->FormValue;
        $this->banco->CurrentValue = $this->banco->FormValue;
        $this->nro_cta->CurrentValue = $this->nro_cta->FormValue;
        $this->titular->CurrentValue = $this->titular->FormValue;
        $this->ci_rif->CurrentValue = $this->ci_rif->FormValue;
        $this->correo->CurrentValue = $this->correo->FormValue;
        $this->motivo->CurrentValue = $this->motivo->FormValue;
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
        $this->Nreembolso->setDbValue($row['Nreembolso']);
        $this->expediente->setDbValue($row['expediente']);
        $this->fecha->setDbValue($row['fecha']);
        $this->monto_usd->setDbValue($row['monto_usd']);
        $this->fecha_tasa->setDbValue($row['fecha_tasa']);
        $this->tasa->setDbValue($row['tasa']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->banco->setDbValue($row['banco']);
        $this->nro_cta->setDbValue($row['nro_cta']);
        $this->titular->setDbValue($row['titular']);
        $this->ci_rif->setDbValue($row['ci_rif']);
        $this->correo->setDbValue($row['correo']);
        $this->nro_ref->setDbValue($row['nro_ref']);
        $this->motivo->setDbValue($row['motivo']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
        $this->coordinador->setDbValue($row['coordinador']);
        $this->pagador->setDbValue($row['pagador']);
        $this->fecha_pago->setDbValue($row['fecha_pago']);
        $this->email_enviado->setDbValue($row['email_enviado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nreembolso'] = $this->Nreembolso->DefaultValue;
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
        $row['monto_usd'] = $this->monto_usd->DefaultValue;
        $row['fecha_tasa'] = $this->fecha_tasa->DefaultValue;
        $row['tasa'] = $this->tasa->DefaultValue;
        $row['monto_bs'] = $this->monto_bs->DefaultValue;
        $row['banco'] = $this->banco->DefaultValue;
        $row['nro_cta'] = $this->nro_cta->DefaultValue;
        $row['titular'] = $this->titular->DefaultValue;
        $row['ci_rif'] = $this->ci_rif->DefaultValue;
        $row['correo'] = $this->correo->DefaultValue;
        $row['nro_ref'] = $this->nro_ref->DefaultValue;
        $row['motivo'] = $this->motivo->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['coordinador'] = $this->coordinador->DefaultValue;
        $row['pagador'] = $this->pagador->DefaultValue;
        $row['fecha_pago'] = $this->fecha_pago->DefaultValue;
        $row['email_enviado'] = $this->email_enviado->DefaultValue;
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

        // Nreembolso
        $this->Nreembolso->RowCssClass = "row";

        // expediente
        $this->expediente->RowCssClass = "row";

        // fecha
        $this->fecha->RowCssClass = "row";

        // monto_usd
        $this->monto_usd->RowCssClass = "row";

        // fecha_tasa
        $this->fecha_tasa->RowCssClass = "row";

        // tasa
        $this->tasa->RowCssClass = "row";

        // monto_bs
        $this->monto_bs->RowCssClass = "row";

        // banco
        $this->banco->RowCssClass = "row";

        // nro_cta
        $this->nro_cta->RowCssClass = "row";

        // titular
        $this->titular->RowCssClass = "row";

        // ci_rif
        $this->ci_rif->RowCssClass = "row";

        // correo
        $this->correo->RowCssClass = "row";

        // nro_ref
        $this->nro_ref->RowCssClass = "row";

        // motivo
        $this->motivo->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // coordinador
        $this->coordinador->RowCssClass = "row";

        // pagador
        $this->pagador->RowCssClass = "row";

        // fecha_pago
        $this->fecha_pago->RowCssClass = "row";

        // email_enviado
        $this->email_enviado->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nreembolso
            $this->Nreembolso->ViewValue = $this->Nreembolso->CurrentValue;

            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // monto_usd
            $this->monto_usd->ViewValue = $this->monto_usd->CurrentValue;
            $this->monto_usd->ViewValue = FormatNumber($this->monto_usd->ViewValue, $this->monto_usd->formatPattern());

            // fecha_tasa
            $this->fecha_tasa->ViewValue = $this->fecha_tasa->CurrentValue;
            $this->fecha_tasa->ViewValue = FormatDateTime($this->fecha_tasa->ViewValue, $this->fecha_tasa->formatPattern());

            // tasa
            $this->tasa->ViewValue = $this->tasa->CurrentValue;
            $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

            // monto_bs
            $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
            $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

            // banco
            $this->banco->ViewValue = $this->banco->CurrentValue;

            // nro_cta
            $this->nro_cta->ViewValue = $this->nro_cta->CurrentValue;

            // titular
            $this->titular->ViewValue = $this->titular->CurrentValue;

            // ci_rif
            $this->ci_rif->ViewValue = $this->ci_rif->CurrentValue;

            // correo
            $this->correo->ViewValue = $this->correo->CurrentValue;

            // nro_ref
            $this->nro_ref->ViewValue = $this->nro_ref->CurrentValue;

            // motivo
            $curVal = strval($this->motivo->CurrentValue);
            if ($curVal != "") {
                $this->motivo->ViewValue = $this->motivo->lookupCacheOption($curVal);
                if ($this->motivo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->motivo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->motivo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->motivo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->motivo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->motivo->Lookup->renderViewRow($rswrk[0]);
                        $this->motivo->ViewValue = $this->motivo->displayValue($arwrk);
                    } else {
                        $this->motivo->ViewValue = $this->motivo->CurrentValue;
                    }
                }
            } else {
                $this->motivo->ViewValue = null;
            }

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // estatus
            if (strval($this->estatus->CurrentValue) != "") {
                $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
            } else {
                $this->estatus->ViewValue = null;
            }

            // coordinador
            $this->coordinador->ViewValue = $this->coordinador->CurrentValue;
            $curVal = strval($this->coordinador->CurrentValue);
            if ($curVal != "") {
                $this->coordinador->ViewValue = $this->coordinador->lookupCacheOption($curVal);
                if ($this->coordinador->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->coordinador->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->coordinador->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->coordinador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->coordinador->Lookup->renderViewRow($rswrk[0]);
                        $this->coordinador->ViewValue = $this->coordinador->displayValue($arwrk);
                    } else {
                        $this->coordinador->ViewValue = $this->coordinador->CurrentValue;
                    }
                }
            } else {
                $this->coordinador->ViewValue = null;
            }

            // pagador
            $this->pagador->ViewValue = $this->pagador->CurrentValue;
            $curVal = strval($this->pagador->CurrentValue);
            if ($curVal != "") {
                $this->pagador->ViewValue = $this->pagador->lookupCacheOption($curVal);
                if ($this->pagador->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->pagador->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->pagador->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->pagador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->pagador->Lookup->renderViewRow($rswrk[0]);
                        $this->pagador->ViewValue = $this->pagador->displayValue($arwrk);
                    } else {
                        $this->pagador->ViewValue = $this->pagador->CurrentValue;
                    }
                }
            } else {
                $this->pagador->ViewValue = null;
            }

            // fecha_pago
            $this->fecha_pago->ViewValue = $this->fecha_pago->CurrentValue;
            $this->fecha_pago->ViewValue = FormatDateTime($this->fecha_pago->ViewValue, $this->fecha_pago->formatPattern());

            // email_enviado
            if (strval($this->email_enviado->CurrentValue) != "") {
                $this->email_enviado->ViewValue = $this->email_enviado->optionCaption($this->email_enviado->CurrentValue);
            } else {
                $this->email_enviado->ViewValue = null;
            }

            // monto_usd
            $this->monto_usd->HrefValue = "";

            // banco
            $this->banco->HrefValue = "";

            // nro_cta
            $this->nro_cta->HrefValue = "";

            // titular
            $this->titular->HrefValue = "";

            // ci_rif
            $this->ci_rif->HrefValue = "";

            // correo
            $this->correo->HrefValue = "";

            // motivo
            $this->motivo->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // monto_usd
            $this->monto_usd->setupEditAttributes();
            $this->monto_usd->EditValue = $this->monto_usd->CurrentValue;
            $this->monto_usd->PlaceHolder = RemoveHtml($this->monto_usd->caption());
            if (strval($this->monto_usd->EditValue) != "" && is_numeric($this->monto_usd->EditValue)) {
                $this->monto_usd->EditValue = FormatNumber($this->monto_usd->EditValue, null);
            }

            // banco
            $this->banco->setupEditAttributes();
            if (!$this->banco->Raw) {
                $this->banco->CurrentValue = HtmlDecode($this->banco->CurrentValue);
            }
            $this->banco->EditValue = HtmlEncode($this->banco->CurrentValue);
            $this->banco->PlaceHolder = RemoveHtml($this->banco->caption());

            // nro_cta
            $this->nro_cta->setupEditAttributes();
            if (!$this->nro_cta->Raw) {
                $this->nro_cta->CurrentValue = HtmlDecode($this->nro_cta->CurrentValue);
            }
            $this->nro_cta->EditValue = HtmlEncode($this->nro_cta->CurrentValue);
            $this->nro_cta->PlaceHolder = RemoveHtml($this->nro_cta->caption());

            // titular
            $this->titular->setupEditAttributes();
            if (!$this->titular->Raw) {
                $this->titular->CurrentValue = HtmlDecode($this->titular->CurrentValue);
            }
            $this->titular->EditValue = HtmlEncode($this->titular->CurrentValue);
            $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

            // ci_rif
            $this->ci_rif->setupEditAttributes();
            if (!$this->ci_rif->Raw) {
                $this->ci_rif->CurrentValue = HtmlDecode($this->ci_rif->CurrentValue);
            }
            $this->ci_rif->EditValue = HtmlEncode($this->ci_rif->CurrentValue);
            $this->ci_rif->PlaceHolder = RemoveHtml($this->ci_rif->caption());

            // correo
            $this->correo->setupEditAttributes();
            if (!$this->correo->Raw) {
                $this->correo->CurrentValue = HtmlDecode($this->correo->CurrentValue);
            }
            $this->correo->EditValue = HtmlEncode($this->correo->CurrentValue);
            $this->correo->PlaceHolder = RemoveHtml($this->correo->caption());

            // motivo
            $this->motivo->setupEditAttributes();
            $curVal = trim(strval($this->motivo->CurrentValue));
            if ($curVal != "") {
                $this->motivo->ViewValue = $this->motivo->lookupCacheOption($curVal);
            } else {
                $this->motivo->ViewValue = $this->motivo->Lookup !== null && is_array($this->motivo->lookupOptions()) && count($this->motivo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->motivo->ViewValue !== null) { // Load from cache
                $this->motivo->EditValue = array_values($this->motivo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->motivo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->motivo->CurrentValue, $this->motivo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->motivo->getSelectFilter($this); // PHP
                $sqlWrk = $this->motivo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->motivo->EditValue = $arwrk;
            }
            $this->motivo->PlaceHolder = RemoveHtml($this->motivo->caption());

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // Add refer script

            // monto_usd
            $this->monto_usd->HrefValue = "";

            // banco
            $this->banco->HrefValue = "";

            // nro_cta
            $this->nro_cta->HrefValue = "";

            // titular
            $this->titular->HrefValue = "";

            // ci_rif
            $this->ci_rif->HrefValue = "";

            // correo
            $this->correo->HrefValue = "";

            // motivo
            $this->motivo->HrefValue = "";

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
            if ($this->monto_usd->Visible && $this->monto_usd->Required) {
                if (!$this->monto_usd->IsDetailKey && EmptyValue($this->monto_usd->FormValue)) {
                    $this->monto_usd->addErrorMessage(str_replace("%s", $this->monto_usd->caption(), $this->monto_usd->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->monto_usd->FormValue)) {
                $this->monto_usd->addErrorMessage($this->monto_usd->getErrorMessage(false));
            }
            if ($this->banco->Visible && $this->banco->Required) {
                if (!$this->banco->IsDetailKey && EmptyValue($this->banco->FormValue)) {
                    $this->banco->addErrorMessage(str_replace("%s", $this->banco->caption(), $this->banco->RequiredErrorMessage));
                }
            }
            if ($this->nro_cta->Visible && $this->nro_cta->Required) {
                if (!$this->nro_cta->IsDetailKey && EmptyValue($this->nro_cta->FormValue)) {
                    $this->nro_cta->addErrorMessage(str_replace("%s", $this->nro_cta->caption(), $this->nro_cta->RequiredErrorMessage));
                }
            }
            if ($this->titular->Visible && $this->titular->Required) {
                if (!$this->titular->IsDetailKey && EmptyValue($this->titular->FormValue)) {
                    $this->titular->addErrorMessage(str_replace("%s", $this->titular->caption(), $this->titular->RequiredErrorMessage));
                }
            }
            if ($this->ci_rif->Visible && $this->ci_rif->Required) {
                if (!$this->ci_rif->IsDetailKey && EmptyValue($this->ci_rif->FormValue)) {
                    $this->ci_rif->addErrorMessage(str_replace("%s", $this->ci_rif->caption(), $this->ci_rif->RequiredErrorMessage));
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
            if ($this->motivo->Visible && $this->motivo->Required) {
                if (!$this->motivo->IsDetailKey && EmptyValue($this->motivo->FormValue)) {
                    $this->motivo->addErrorMessage(str_replace("%s", $this->motivo->caption(), $this->motivo->RequiredErrorMessage));
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

        // monto_usd
        $this->monto_usd->setDbValueDef($rsnew, $this->monto_usd->CurrentValue, false);

        // banco
        $this->banco->setDbValueDef($rsnew, $this->banco->CurrentValue, false);

        // nro_cta
        $this->nro_cta->setDbValueDef($rsnew, $this->nro_cta->CurrentValue, false);

        // titular
        $this->titular->setDbValueDef($rsnew, $this->titular->CurrentValue, false);

        // ci_rif
        $this->ci_rif->setDbValueDef($rsnew, $this->ci_rif->CurrentValue, false);

        // correo
        $this->correo->setDbValueDef($rsnew, $this->correo->CurrentValue, false);

        // motivo
        $this->motivo->setDbValueDef($rsnew, $this->motivo->CurrentValue, false);

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
        if (isset($row['monto_usd'])) { // monto_usd
            $this->monto_usd->setFormValue($row['monto_usd']);
        }
        if (isset($row['banco'])) { // banco
            $this->banco->setFormValue($row['banco']);
        }
        if (isset($row['nro_cta'])) { // nro_cta
            $this->nro_cta->setFormValue($row['nro_cta']);
        }
        if (isset($row['titular'])) { // titular
            $this->titular->setFormValue($row['titular']);
        }
        if (isset($row['ci_rif'])) { // ci_rif
            $this->ci_rif->setFormValue($row['ci_rif']);
        }
        if (isset($row['correo'])) { // correo
            $this->correo->setFormValue($row['correo']);
        }
        if (isset($row['motivo'])) { // motivo
            $this->motivo->setFormValue($row['motivo']);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoReembolsoList"), "", $this->TableVar, true);
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
                case "x_motivo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    break;
                case "x_coordinador":
                    break;
                case "x_pagador":
                    break;
                case "x_email_enviado":
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
