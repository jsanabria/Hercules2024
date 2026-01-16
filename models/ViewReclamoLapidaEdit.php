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
class ViewReclamoLapidaEdit extends ViewReclamoLapida
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewReclamoLapidaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ViewReclamoLapidaEdit";

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
        $this->Nreclamo->setVisibility();
        $this->solicitante->setVisibility();
        $this->parentesco->setVisibility();
        $this->ci_difunto->setVisibility();
        $this->nombre_difunto->setVisibility();
        $this->tipo->setVisibility();
        $this->registro->setVisibility();
        $this->registra->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'view_reclamo_lapida';
        $this->TableName = 'view_reclamo_lapida';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (view_reclamo_lapida)
        if (!isset($GLOBALS["view_reclamo_lapida"]) || $GLOBALS["view_reclamo_lapida"]::class == PROJECT_NAMESPACE . "view_reclamo_lapida") {
            $GLOBALS["view_reclamo_lapida"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_reclamo_lapida');
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
                        $result["view"] = SameString($pageName, "ViewReclamoLapidaView"); // If View page, no primary button
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
            $key .= @$ar['Nreclamo'];
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
            $this->Nreclamo->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->setupLookupOptions($this->registra);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("Nreclamo") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nreclamo->setQueryStringValue($keyValue);
                $this->Nreclamo->setOldValue($this->Nreclamo->QueryStringValue);
            } elseif (Post("Nreclamo") !== null) {
                $this->Nreclamo->setFormValue(Post("Nreclamo"));
                $this->Nreclamo->setOldValue($this->Nreclamo->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("Nreclamo") ?? Route("Nreclamo")) !== null) {
                    $this->Nreclamo->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nreclamo->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
                    $loadByPosition = true;
                }
            }

            // Load result set
            if ($this->isShow()) {
                if (!$this->IsModal) { // Normal edit page
                    $this->StartRecord = 1; // Initialize start position
                    $this->Recordset = $this->loadRecordset(); // Load records
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("ViewReclamoLapidaList"); // Return to list page
                        return;
                    } elseif ($loadByPosition) { // Load record by position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $this->fetch($this->StartRecord);
                            // Redirect to correct record
                            $this->loadRowValues($this->CurrentRow);
                            $url = $this->getCurrentUrl();
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        if ($this->Nreclamo->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nreclamo->CurrentValue, $this->CurrentRow['Nreclamo'])) {
                                    $this->setStartRecordNumber($this->StartRecord); // Save record position
                                    $loaded = true;
                                    break;
                                } else {
                                    $this->StartRecord++;
                                }
                            }
                        }
                    }

                    // Load current row values
                    if ($loaded) {
                        $this->loadRowValues($this->CurrentRow);
                    }
                } else {
                    // Load current record
                    $loaded = $this->loadRow();
                } // End modal checking
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal) { // Normal edit page
                    if (!$loaded) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("ViewReclamoLapidaList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ViewReclamoLapidaList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ViewReclamoLapidaList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ViewReclamoLapidaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ViewReclamoLapidaList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = RowType::EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_PAGE_NUMBER");
            $this->Pager->PagePhraseId = "Record"; // Show as record
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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Nreclamo' first before field var 'x_Nreclamo'
        $val = $CurrentForm->hasValue("Nreclamo") ? $CurrentForm->getValue("Nreclamo") : $CurrentForm->getValue("x_Nreclamo");
        if (!$this->Nreclamo->IsDetailKey) {
            $this->Nreclamo->setFormValue($val);
        }

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

        // Check field name 'registro' first before field var 'x_registro'
        $val = $CurrentForm->hasValue("registro") ? $CurrentForm->getValue("registro") : $CurrentForm->getValue("x_registro");
        if (!$this->registro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->registro->Visible = false; // Disable update for API request
            } else {
                $this->registro->setFormValue($val);
            }
            $this->registro->CurrentValue = UnFormatDateTime($this->registro->CurrentValue, $this->registro->formatPattern());
        }

        // Check field name 'registra' first before field var 'x_registra'
        $val = $CurrentForm->hasValue("registra") ? $CurrentForm->getValue("registra") : $CurrentForm->getValue("x_registra");
        if (!$this->registra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->registra->Visible = false; // Disable update for API request
            } else {
                $this->registra->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nreclamo->CurrentValue = $this->Nreclamo->FormValue;
        $this->solicitante->CurrentValue = $this->solicitante->FormValue;
        $this->parentesco->CurrentValue = $this->parentesco->FormValue;
        $this->ci_difunto->CurrentValue = $this->ci_difunto->FormValue;
        $this->nombre_difunto->CurrentValue = $this->nombre_difunto->FormValue;
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->registro->CurrentValue = $this->registro->FormValue;
        $this->registro->CurrentValue = UnFormatDateTime($this->registro->CurrentValue, $this->registro->formatPattern());
        $this->registra->CurrentValue = $this->registra->FormValue;
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
        $this->Nreclamo->setDbValue($row['Nreclamo']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->parentesco->setDbValue($row['parentesco']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->nombre_difunto->setDbValue($row['nombre_difunto']);
        $this->tipo->setDbValue($row['tipo']);
        $this->registro->setDbValue($row['registro']);
        $this->registra->setDbValue($row['registra']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nreclamo'] = $this->Nreclamo->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['parentesco'] = $this->parentesco->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['nombre_difunto'] = $this->nombre_difunto->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['registro'] = $this->registro->DefaultValue;
        $row['registra'] = $this->registra->DefaultValue;
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

        // Nreclamo
        $this->Nreclamo->RowCssClass = "row";

        // solicitante
        $this->solicitante->RowCssClass = "row";

        // parentesco
        $this->parentesco->RowCssClass = "row";

        // ci_difunto
        $this->ci_difunto->RowCssClass = "row";

        // nombre_difunto
        $this->nombre_difunto->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // registro
        $this->registro->RowCssClass = "row";

        // registra
        $this->registra->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nreclamo
            $this->Nreclamo->ViewValue = $this->Nreclamo->CurrentValue;

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

            // Nreclamo
            $this->Nreclamo->HrefValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";
            $this->solicitante->TooltipValue = "";

            // parentesco
            $this->parentesco->HrefValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";
            $this->ci_difunto->TooltipValue = "";

            // nombre_difunto
            $this->nombre_difunto->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // registro
            $this->registro->HrefValue = "";
            $this->registro->TooltipValue = "";

            // registra
            $this->registra->HrefValue = "";
            $this->registra->TooltipValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nreclamo
            $this->Nreclamo->setupEditAttributes();
            $this->Nreclamo->EditValue = $this->Nreclamo->CurrentValue;

            // solicitante
            $this->solicitante->setupEditAttributes();
            $this->solicitante->EditValue = $this->solicitante->CurrentValue;

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

            // ci_difunto
            $this->ci_difunto->setupEditAttributes();
            $this->ci_difunto->EditValue = $this->ci_difunto->CurrentValue;

            // nombre_difunto
            $this->nombre_difunto->setupEditAttributes();
            if (!$this->nombre_difunto->Raw) {
                $this->nombre_difunto->CurrentValue = HtmlDecode($this->nombre_difunto->CurrentValue);
            }
            $this->nombre_difunto->EditValue = HtmlEncode($this->nombre_difunto->CurrentValue);
            $this->nombre_difunto->PlaceHolder = RemoveHtml($this->nombre_difunto->caption());

            // tipo
            $curVal = trim(strval($this->tipo->CurrentValue));
            if ($curVal != "") {
                $this->tipo->ViewValue = $this->tipo->lookupCacheOption($curVal);
            } else {
                $this->tipo->ViewValue = $this->tipo->Lookup !== null && is_array($this->tipo->lookupOptions()) && count($this->tipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo->ViewValue !== null) { // Load from cache
                $this->tipo->EditValue = array_values($this->tipo->lookupOptions());
                if ($this->tipo->ViewValue == "") {
                    $this->tipo->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo->ViewValue = $this->tipo->displayValue($arwrk);
                } else {
                    $this->tipo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->tipo->EditValue = $arwrk;
            }
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // registro
            $this->registro->setupEditAttributes();
            $this->registro->EditValue = $this->registro->CurrentValue;
            $this->registro->EditValue = FormatDateTime($this->registro->EditValue, $this->registro->formatPattern());

            // registra
            $this->registra->setupEditAttributes();
            $curVal = strval($this->registra->CurrentValue);
            if ($curVal != "") {
                $this->registra->EditValue = $this->registra->lookupCacheOption($curVal);
                if ($this->registra->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->registra->Lookup->renderViewRow($rswrk[0]);
                        $this->registra->EditValue = $this->registra->displayValue($arwrk);
                    } else {
                        $this->registra->EditValue = $this->registra->CurrentValue;
                    }
                }
            } else {
                $this->registra->EditValue = null;
            }

            // Edit refer script

            // Nreclamo
            $this->Nreclamo->HrefValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";
            $this->solicitante->TooltipValue = "";

            // parentesco
            $this->parentesco->HrefValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";
            $this->ci_difunto->TooltipValue = "";

            // nombre_difunto
            $this->nombre_difunto->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // registro
            $this->registro->HrefValue = "";
            $this->registro->TooltipValue = "";

            // registra
            $this->registra->HrefValue = "";
            $this->registra->TooltipValue = "";
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
            if ($this->Nreclamo->Visible && $this->Nreclamo->Required) {
                if (!$this->Nreclamo->IsDetailKey && EmptyValue($this->Nreclamo->FormValue)) {
                    $this->Nreclamo->addErrorMessage(str_replace("%s", $this->Nreclamo->caption(), $this->Nreclamo->RequiredErrorMessage));
                }
            }
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
            if ($this->registro->Visible && $this->registro->Required) {
                if (!$this->registro->IsDetailKey && EmptyValue($this->registro->FormValue)) {
                    $this->registro->addErrorMessage(str_replace("%s", $this->registro->caption(), $this->registro->RequiredErrorMessage));
                }
            }
            if ($this->registra->Visible && $this->registra->Required) {
                if (!$this->registra->IsDetailKey && EmptyValue($this->registra->FormValue)) {
                    $this->registra->addErrorMessage(str_replace("%s", $this->registra->caption(), $this->registra->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Load old values
            $this->loadDbValues($rsold);
        }

        // Get new row
        $rsnew = $this->getEditRow($rsold);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    /**
     * Get edit row
     *
     * @return array
     */
    protected function getEditRow($rsold)
    {
        global $Security;
        $rsnew = [];

        // parentesco
        $this->parentesco->setDbValueDef($rsnew, $this->parentesco->CurrentValue, $this->parentesco->ReadOnly);

        // nombre_difunto
        $this->nombre_difunto->setDbValueDef($rsnew, $this->nombre_difunto->CurrentValue, $this->nombre_difunto->ReadOnly);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, $this->tipo->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['parentesco'])) { // parentesco
            $this->parentesco->CurrentValue = $row['parentesco'];
        }
        if (isset($row['nombre_difunto'])) { // nombre_difunto
            $this->nombre_difunto->CurrentValue = $row['nombre_difunto'];
        }
        if (isset($row['tipo'])) { // tipo
            $this->tipo->CurrentValue = $row['tipo'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ViewReclamoLapidaList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_registra":
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
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
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
        $Nreclamo = $this->Nreclamo->CurrentValue;
        if (!empty($Nreclamo)) {
            // Consulta extendida con los nuevos campos
            $sql = "SELECT telefono1, telefono2, email FROM sco_reclamo WHERE Nreclamo = " . QuotedValue($Nreclamo, DataType::NUMBER);
            $row = ExecuteRow($sql);
            if ($row) {
                $email = trim($row["email"] ?? "no@gmail.com");
                $tel1 = trim($row["telefono1"] ?? "");
                $tel2 = trim($row["telefono2"] ?? "");

                // Construcción de la interfaz amigable
                $header = '<div class="card shadow-sm mb-4 border-info">';
                $header .= '  <div class="card-body py-2 px-3">';
                $header .= '    <div class="row align-items-center">';

                // Sección de Email
                $header .= '      <div class="col-md-4 border-end">';
                $header .= '        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Correo Electrónico</small>';
                $header .= '        <i class="fas fa-envelope text-info me-1"></i>';
                $header .= '        <a href="mailto:' . $email . '" class="text-decoration-none">' . ($email ?: "No registrado") . '</a>';
                $header .= '      </div>';

                // Sección de Teléfono 1
                $header .= '      <div class="col-md-4 border-end">';
                $header .= '        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Teléfono Principal</small>';
                $header .= '        <i class="fas fa-phone text-success me-1"></i>';
                $header .= '        <span>' . ($tel1 ?: "N/A") . '</span>';
                $header .= '      </div>';

                // Sección de Teléfono 2
                $header .= '      <div class="col-md-4">';
                $header .= '        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Teléfono Secundario</small>';
                $header .= '        <i class="fas fa-mobile-alt text-primary me-1"></i>';
                $header .= '        <span>' . ($tel2 ?: "N/A") . '</span>';
                $header .= '      </div>';
                $header .= '    </div>'; // Cierre row
                $header .= '  </div>'; // Cierre card-body
                $header .= '</div>'; // Cierre card
            }
        }
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
