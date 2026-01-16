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
class ScoExpedienteCiaAdd extends ScoExpedienteCia
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteCiaAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteCiaAdd";

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
        $this->Nexpediente_cia->Visible = false;
        $this->cia->setVisibility();
        $this->expediente->setVisibility();
        $this->servicio_tipo->Visible = false;
        $this->factura->setVisibility();
        $this->fecha->Visible = false;
        $this->monto->setVisibility();
        $this->nota->setVisibility();
        $this->_username->Visible = false;
        $this->estatus->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_expediente_cia';
        $this->TableName = 'sco_expediente_cia';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_expediente_cia)
        if (!isset($GLOBALS["sco_expediente_cia"]) || $GLOBALS["sco_expediente_cia"]::class == PROJECT_NAMESPACE . "sco_expediente_cia") {
            $GLOBALS["sco_expediente_cia"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente_cia');
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
                        $result["view"] = SameString($pageName, "ScoExpedienteCiaView"); // If View page, no primary button
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
            $key .= @$ar['Nexpediente_cia'];
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
            $this->Nexpediente_cia->Visible = false;
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
        $this->setupLookupOptions($this->cia);
        $this->setupLookupOptions($this->expediente);
        $this->setupLookupOptions($this->servicio_tipo);
        $this->setupLookupOptions($this->_username);
        $this->setupLookupOptions($this->estatus);

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
            if (($keyValue = Get("Nexpediente_cia") ?? Route("Nexpediente_cia")) !== null) {
                $this->Nexpediente_cia->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoExpedienteCiaList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ScoExpedienteCiaList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoExpedienteCiaView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoExpedienteCiaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoExpedienteCiaList"; // Return list page content
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
        $this->estatus->DefaultValue = $this->estatus->getDefault(); // PHP
        $this->estatus->OldValue = $this->estatus->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'cia' first before field var 'x_cia'
        $val = $CurrentForm->hasValue("cia") ? $CurrentForm->getValue("cia") : $CurrentForm->getValue("x_cia");
        if (!$this->cia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cia->Visible = false; // Disable update for API request
            } else {
                $this->cia->setFormValue($val);
            }
        }

        // Check field name 'expediente' first before field var 'x_expediente'
        $val = $CurrentForm->hasValue("expediente") ? $CurrentForm->getValue("expediente") : $CurrentForm->getValue("x_expediente");
        if (!$this->expediente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expediente->Visible = false; // Disable update for API request
            } else {
                $this->expediente->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'factura' first before field var 'x_factura'
        $val = $CurrentForm->hasValue("factura") ? $CurrentForm->getValue("factura") : $CurrentForm->getValue("x_factura");
        if (!$this->factura->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->factura->Visible = false; // Disable update for API request
            } else {
                $this->factura->setFormValue($val);
            }
        }

        // Check field name 'monto' first before field var 'x_monto'
        $val = $CurrentForm->hasValue("monto") ? $CurrentForm->getValue("monto") : $CurrentForm->getValue("x_monto");
        if (!$this->monto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto->Visible = false; // Disable update for API request
            } else {
                $this->monto->setFormValue($val, true, $validate);
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

        // Check field name 'Nexpediente_cia' first before field var 'x_Nexpediente_cia'
        $val = $CurrentForm->hasValue("Nexpediente_cia") ? $CurrentForm->getValue("Nexpediente_cia") : $CurrentForm->getValue("x_Nexpediente_cia");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->cia->CurrentValue = $this->cia->FormValue;
        $this->expediente->CurrentValue = $this->expediente->FormValue;
        $this->factura->CurrentValue = $this->factura->FormValue;
        $this->monto->CurrentValue = $this->monto->FormValue;
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
        $this->Nexpediente_cia->setDbValue($row['Nexpediente_cia']);
        $this->cia->setDbValue($row['cia']);
        $this->expediente->setDbValue($row['expediente']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->factura->setDbValue($row['factura']);
        $this->fecha->setDbValue($row['fecha']);
        $this->monto->setDbValue($row['monto']);
        $this->nota->setDbValue($row['nota']);
        $this->_username->setDbValue($row['username']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente_cia'] = $this->Nexpediente_cia->DefaultValue;
        $row['cia'] = $this->cia->DefaultValue;
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
        $row['monto'] = $this->monto->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
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

        // Nexpediente_cia
        $this->Nexpediente_cia->RowCssClass = "row";

        // cia
        $this->cia->RowCssClass = "row";

        // expediente
        $this->expediente->RowCssClass = "row";

        // servicio_tipo
        $this->servicio_tipo->RowCssClass = "row";

        // factura
        $this->factura->RowCssClass = "row";

        // fecha
        $this->fecha->RowCssClass = "row";

        // monto
        $this->monto->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // username
        $this->_username->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente_cia
            $this->Nexpediente_cia->ViewValue = $this->Nexpediente_cia->CurrentValue;

            // cia
            $curVal = strval($this->cia->CurrentValue);
            if ($curVal != "") {
                $this->cia->ViewValue = $this->cia->lookupCacheOption($curVal);
                if ($this->cia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cia->Lookup->getTable()->Fields["Ncia"]->searchExpression(), "=", $curVal, $this->cia->Lookup->getTable()->Fields["Ncia"]->searchDataType(), "");
                    $sqlWrk = $this->cia->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cia->Lookup->renderViewRow($rswrk[0]);
                        $this->cia->ViewValue = $this->cia->displayValue($arwrk);
                    } else {
                        $this->cia->ViewValue = $this->cia->CurrentValue;
                    }
                }
            } else {
                $this->cia->ViewValue = null;
            }

            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;
            $curVal = strval($this->expediente->CurrentValue);
            if ($curVal != "") {
                $this->expediente->ViewValue = $this->expediente->lookupCacheOption($curVal);
                if ($this->expediente->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->expediente->Lookup->getTable()->Fields["Nexpediente"]->searchExpression(), "=", $curVal, $this->expediente->Lookup->getTable()->Fields["Nexpediente"]->searchDataType(), "");
                    $sqlWrk = $this->expediente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->expediente->Lookup->renderViewRow($rswrk[0]);
                        $this->expediente->ViewValue = $this->expediente->displayValue($arwrk);
                    } else {
                        $this->expediente->ViewValue = $this->expediente->CurrentValue;
                    }
                }
            } else {
                $this->expediente->ViewValue = null;
            }

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

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // monto
            $this->monto->ViewValue = $this->monto->CurrentValue;
            $this->monto->ViewValue = FormatNumber($this->monto->ViewValue, $this->monto->formatPattern());

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

            // estatus
            if (strval($this->estatus->CurrentValue) != "") {
                $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
            } else {
                $this->estatus->ViewValue = null;
            }

            // cia
            $this->cia->HrefValue = "";

            // expediente
            $this->expediente->HrefValue = "";
            $this->expediente->TooltipValue = "";

            // factura
            $this->factura->HrefValue = "";

            // monto
            $this->monto->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // cia
            $this->cia->setupEditAttributes();
            $curVal = trim(strval($this->cia->CurrentValue));
            if ($curVal != "") {
                $this->cia->ViewValue = $this->cia->lookupCacheOption($curVal);
            } else {
                $this->cia->ViewValue = $this->cia->Lookup !== null && is_array($this->cia->lookupOptions()) && count($this->cia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cia->ViewValue !== null) { // Load from cache
                $this->cia->EditValue = array_values($this->cia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cia->Lookup->getTable()->Fields["Ncia"]->searchExpression(), "=", $this->cia->CurrentValue, $this->cia->Lookup->getTable()->Fields["Ncia"]->searchDataType(), "");
                }
                $sqlWrk = $this->cia->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->cia->EditValue = $arwrk;
            }
            $this->cia->PlaceHolder = RemoveHtml($this->cia->caption());

            // expediente
            $this->expediente->setupEditAttributes();
            if ($this->expediente->getSessionValue() != "") {
                $this->expediente->CurrentValue = GetForeignKeyValue($this->expediente->getSessionValue());
                $this->expediente->ViewValue = $this->expediente->CurrentValue;
                $curVal = strval($this->expediente->CurrentValue);
                if ($curVal != "") {
                    $this->expediente->ViewValue = $this->expediente->lookupCacheOption($curVal);
                    if ($this->expediente->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->expediente->Lookup->getTable()->Fields["Nexpediente"]->searchExpression(), "=", $curVal, $this->expediente->Lookup->getTable()->Fields["Nexpediente"]->searchDataType(), "");
                        $sqlWrk = $this->expediente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->expediente->Lookup->renderViewRow($rswrk[0]);
                            $this->expediente->ViewValue = $this->expediente->displayValue($arwrk);
                        } else {
                            $this->expediente->ViewValue = $this->expediente->CurrentValue;
                        }
                    }
                } else {
                    $this->expediente->ViewValue = null;
                }
            } else {
                $this->expediente->EditValue = $this->expediente->CurrentValue;
                $curVal = strval($this->expediente->CurrentValue);
                if ($curVal != "") {
                    $this->expediente->EditValue = $this->expediente->lookupCacheOption($curVal);
                    if ($this->expediente->EditValue === null) { // Lookup from database
                        $filterWrk = SearchFilter($this->expediente->Lookup->getTable()->Fields["Nexpediente"]->searchExpression(), "=", $curVal, $this->expediente->Lookup->getTable()->Fields["Nexpediente"]->searchDataType(), "");
                        $sqlWrk = $this->expediente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCache($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->expediente->Lookup->renderViewRow($rswrk[0]);
                            $this->expediente->EditValue = $this->expediente->displayValue($arwrk);
                        } else {
                            $this->expediente->EditValue = HtmlEncode($this->expediente->CurrentValue);
                        }
                    }
                } else {
                    $this->expediente->EditValue = null;
                }
                $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());
            }

            // factura
            $this->factura->setupEditAttributes();
            if (!$this->factura->Raw) {
                $this->factura->CurrentValue = HtmlDecode($this->factura->CurrentValue);
            }
            $this->factura->EditValue = HtmlEncode($this->factura->CurrentValue);
            $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

            // monto
            $this->monto->setupEditAttributes();
            $this->monto->EditValue = $this->monto->CurrentValue;
            $this->monto->PlaceHolder = RemoveHtml($this->monto->caption());
            if (strval($this->monto->EditValue) != "" && is_numeric($this->monto->EditValue)) {
                $this->monto->EditValue = FormatNumber($this->monto->EditValue, null);
            }

            // nota
            $this->nota->setupEditAttributes();
            if (!$this->nota->Raw) {
                $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
            }
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // Add refer script

            // cia
            $this->cia->HrefValue = "";

            // expediente
            $this->expediente->HrefValue = "";

            // factura
            $this->factura->HrefValue = "";

            // monto
            $this->monto->HrefValue = "";

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
            if ($this->cia->Visible && $this->cia->Required) {
                if (!$this->cia->IsDetailKey && EmptyValue($this->cia->FormValue)) {
                    $this->cia->addErrorMessage(str_replace("%s", $this->cia->caption(), $this->cia->RequiredErrorMessage));
                }
            }
            if ($this->expediente->Visible && $this->expediente->Required) {
                if (!$this->expediente->IsDetailKey && EmptyValue($this->expediente->FormValue)) {
                    $this->expediente->addErrorMessage(str_replace("%s", $this->expediente->caption(), $this->expediente->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->expediente->FormValue)) {
                $this->expediente->addErrorMessage($this->expediente->getErrorMessage(false));
            }
            if ($this->factura->Visible && $this->factura->Required) {
                if (!$this->factura->IsDetailKey && EmptyValue($this->factura->FormValue)) {
                    $this->factura->addErrorMessage(str_replace("%s", $this->factura->caption(), $this->factura->RequiredErrorMessage));
                }
            }
            if ($this->monto->Visible && $this->monto->Required) {
                if (!$this->monto->IsDetailKey && EmptyValue($this->monto->FormValue)) {
                    $this->monto->addErrorMessage(str_replace("%s", $this->monto->caption(), $this->monto->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->monto->FormValue)) {
                $this->monto->addErrorMessage($this->monto->getErrorMessage(false));
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

        // cia
        $this->cia->setDbValueDef($rsnew, $this->cia->CurrentValue, false);

        // expediente
        $this->expediente->setDbValueDef($rsnew, $this->expediente->CurrentValue, false);

        // factura
        $this->factura->setDbValueDef($rsnew, $this->factura->CurrentValue, false);

        // monto
        $this->monto->setDbValueDef($rsnew, $this->monto->CurrentValue, false);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['cia'])) { // cia
            $this->cia->setFormValue($row['cia']);
        }
        if (isset($row['expediente'])) { // expediente
            $this->expediente->setFormValue($row['expediente']);
        }
        if (isset($row['factura'])) { // factura
            $this->factura->setFormValue($row['factura']);
        }
        if (isset($row['monto'])) { // monto
            $this->monto->setFormValue($row['monto']);
        }
        if (isset($row['nota'])) { // nota
            $this->nota->setFormValue($row['nota']);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoExpedienteCiaList"), "", $this->TableVar, true);
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
                case "x_cia":
                    break;
                case "x_expediente":
                    break;
                case "x_servicio_tipo":
                    break;
                case "x__username":
                    break;
                case "x_estatus":
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
