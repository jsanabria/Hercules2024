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
class ScoFlotaIncidenciaEdit extends ScoFlotaIncidencia
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoFlotaIncidenciaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoFlotaIncidenciaEdit";

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
        $this->Nflota_incidencia->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->flota->setVisibility();
        $this->tipo->setVisibility();
        $this->falla->setVisibility();
        $this->nota->setVisibility();
        $this->solicitante->setVisibility();
        $this->diagnostico->setVisibility();
        $this->reparacion->setVisibility();
        $this->cambio_aceite->setVisibility();
        $this->kilometraje->setVisibility();
        $this->cantidad->Visible = false;
        $this->proveedor->setVisibility();
        $this->monto->Visible = false;
        $this->_username->Visible = false;
        $this->username_diagnostica->Visible = false;
        $this->fecha_reparacion->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_flota_incidencia';
        $this->TableName = 'sco_flota_incidencia';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_flota_incidencia)
        if (!isset($GLOBALS["sco_flota_incidencia"]) || $GLOBALS["sco_flota_incidencia"]::class == PROJECT_NAMESPACE . "sco_flota_incidencia") {
            $GLOBALS["sco_flota_incidencia"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_flota_incidencia');
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
                        $result["view"] = SameString($pageName, "ScoFlotaIncidenciaView"); // If View page, no primary button
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
            $key .= @$ar['Nflota_incidencia'];
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
            $this->Nflota_incidencia->Visible = false;
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
        $this->fecha_registro->Required = false;

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
        $this->setupLookupOptions($this->flota);
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->falla);
        $this->setupLookupOptions($this->reparacion);
        $this->setupLookupOptions($this->cambio_aceite);
        $this->setupLookupOptions($this->proveedor);
        $this->setupLookupOptions($this->_username);

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
            if (($keyValue = Get("Nflota_incidencia") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nflota_incidencia->setQueryStringValue($keyValue);
                $this->Nflota_incidencia->setOldValue($this->Nflota_incidencia->QueryStringValue);
            } elseif (Post("Nflota_incidencia") !== null) {
                $this->Nflota_incidencia->setFormValue(Post("Nflota_incidencia"));
                $this->Nflota_incidencia->setOldValue($this->Nflota_incidencia->FormValue);
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
                if (($keyValue = Get("Nflota_incidencia") ?? Route("Nflota_incidencia")) !== null) {
                    $this->Nflota_incidencia->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nflota_incidencia->CurrentValue = null;
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
                        $this->terminate("ScoFlotaIncidenciaList"); // Return to list page
                        return;
                    } elseif ($loadByPosition) { // Load record by position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $this->fetch($this->StartRecord);
                            // Redirect to correct record
                            $this->loadRowValues($this->CurrentRow);
                            $url = $this->getCurrentUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable());
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        if ($this->Nflota_incidencia->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nflota_incidencia->CurrentValue, $this->CurrentRow['Nflota_incidencia'])) {
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

            // Set up detail parameters
            $this->setupDetailParms();
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
                        $this->terminate("ScoFlotaIncidenciaList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoFlotaIncidenciaList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "ScoFlotaIncidenciaList") {
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
                        if (GetPageName($returnUrl) != "ScoFlotaIncidenciaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoFlotaIncidenciaList"; // Return list page content
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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

        // Check field name 'Nflota_incidencia' first before field var 'x_Nflota_incidencia'
        $val = $CurrentForm->hasValue("Nflota_incidencia") ? $CurrentForm->getValue("Nflota_incidencia") : $CurrentForm->getValue("x_Nflota_incidencia");
        if (!$this->Nflota_incidencia->IsDetailKey) {
            $this->Nflota_incidencia->setFormValue($val, true, $validate);
        }

        // Check field name 'fecha_registro' first before field var 'x_fecha_registro'
        $val = $CurrentForm->hasValue("fecha_registro") ? $CurrentForm->getValue("fecha_registro") : $CurrentForm->getValue("x_fecha_registro");
        if (!$this->fecha_registro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_registro->Visible = false; // Disable update for API request
            } else {
                $this->fecha_registro->setFormValue($val);
            }
            $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        }

        // Check field name 'flota' first before field var 'x_flota'
        $val = $CurrentForm->hasValue("flota") ? $CurrentForm->getValue("flota") : $CurrentForm->getValue("x_flota");
        if (!$this->flota->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->flota->Visible = false; // Disable update for API request
            } else {
                $this->flota->setFormValue($val, true, $validate);
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

        // Check field name 'falla' first before field var 'x_falla'
        $val = $CurrentForm->hasValue("falla") ? $CurrentForm->getValue("falla") : $CurrentForm->getValue("x_falla");
        if (!$this->falla->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->falla->Visible = false; // Disable update for API request
            } else {
                $this->falla->setFormValue($val);
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

        // Check field name 'solicitante' first before field var 'x_solicitante'
        $val = $CurrentForm->hasValue("solicitante") ? $CurrentForm->getValue("solicitante") : $CurrentForm->getValue("x_solicitante");
        if (!$this->solicitante->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->solicitante->Visible = false; // Disable update for API request
            } else {
                $this->solicitante->setFormValue($val);
            }
        }

        // Check field name 'diagnostico' first before field var 'x_diagnostico'
        $val = $CurrentForm->hasValue("diagnostico") ? $CurrentForm->getValue("diagnostico") : $CurrentForm->getValue("x_diagnostico");
        if (!$this->diagnostico->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->diagnostico->Visible = false; // Disable update for API request
            } else {
                $this->diagnostico->setFormValue($val);
            }
        }

        // Check field name 'reparacion' first before field var 'x_reparacion'
        $val = $CurrentForm->hasValue("reparacion") ? $CurrentForm->getValue("reparacion") : $CurrentForm->getValue("x_reparacion");
        if (!$this->reparacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->reparacion->Visible = false; // Disable update for API request
            } else {
                $this->reparacion->setFormValue($val);
            }
        }

        // Check field name 'cambio_aceite' first before field var 'x_cambio_aceite'
        $val = $CurrentForm->hasValue("cambio_aceite") ? $CurrentForm->getValue("cambio_aceite") : $CurrentForm->getValue("x_cambio_aceite");
        if (!$this->cambio_aceite->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cambio_aceite->Visible = false; // Disable update for API request
            } else {
                $this->cambio_aceite->setFormValue($val);
            }
        }

        // Check field name 'kilometraje' first before field var 'x_kilometraje'
        $val = $CurrentForm->hasValue("kilometraje") ? $CurrentForm->getValue("kilometraje") : $CurrentForm->getValue("x_kilometraje");
        if (!$this->kilometraje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kilometraje->Visible = false; // Disable update for API request
            } else {
                $this->kilometraje->setFormValue($val, true, $validate);
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

        // Check field name 'fecha_reparacion' first before field var 'x_fecha_reparacion'
        $val = $CurrentForm->hasValue("fecha_reparacion") ? $CurrentForm->getValue("fecha_reparacion") : $CurrentForm->getValue("x_fecha_reparacion");
        if (!$this->fecha_reparacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_reparacion->Visible = false; // Disable update for API request
            } else {
                $this->fecha_reparacion->setFormValue($val, true, $validate);
            }
            $this->fecha_reparacion->CurrentValue = UnFormatDateTime($this->fecha_reparacion->CurrentValue, $this->fecha_reparacion->formatPattern());
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nflota_incidencia->CurrentValue = $this->Nflota_incidencia->FormValue;
        $this->fecha_registro->CurrentValue = $this->fecha_registro->FormValue;
        $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->flota->CurrentValue = $this->flota->FormValue;
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->falla->CurrentValue = $this->falla->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->solicitante->CurrentValue = $this->solicitante->FormValue;
        $this->diagnostico->CurrentValue = $this->diagnostico->FormValue;
        $this->reparacion->CurrentValue = $this->reparacion->FormValue;
        $this->cambio_aceite->CurrentValue = $this->cambio_aceite->FormValue;
        $this->kilometraje->CurrentValue = $this->kilometraje->FormValue;
        $this->proveedor->CurrentValue = $this->proveedor->FormValue;
        $this->fecha_reparacion->CurrentValue = $this->fecha_reparacion->FormValue;
        $this->fecha_reparacion->CurrentValue = UnFormatDateTime($this->fecha_reparacion->CurrentValue, $this->fecha_reparacion->formatPattern());
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
        $this->Nflota_incidencia->setDbValue($row['Nflota_incidencia']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->flota->setDbValue($row['flota']);
        $this->tipo->setDbValue($row['tipo']);
        $this->falla->setDbValue($row['falla']);
        $this->nota->setDbValue($row['nota']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->diagnostico->setDbValue($row['diagnostico']);
        $this->reparacion->setDbValue($row['reparacion']);
        $this->cambio_aceite->setDbValue($row['cambio_aceite']);
        $this->kilometraje->setDbValue($row['kilometraje']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->monto->setDbValue($row['monto']);
        $this->_username->setDbValue($row['username']);
        $this->username_diagnostica->setDbValue($row['username_diagnostica']);
        $this->fecha_reparacion->setDbValue($row['fecha_reparacion']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nflota_incidencia'] = $this->Nflota_incidencia->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['flota'] = $this->flota->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['falla'] = $this->falla->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['diagnostico'] = $this->diagnostico->DefaultValue;
        $row['reparacion'] = $this->reparacion->DefaultValue;
        $row['cambio_aceite'] = $this->cambio_aceite->DefaultValue;
        $row['kilometraje'] = $this->kilometraje->DefaultValue;
        $row['cantidad'] = $this->cantidad->DefaultValue;
        $row['proveedor'] = $this->proveedor->DefaultValue;
        $row['monto'] = $this->monto->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['username_diagnostica'] = $this->username_diagnostica->DefaultValue;
        $row['fecha_reparacion'] = $this->fecha_reparacion->DefaultValue;
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

        // Nflota_incidencia
        $this->Nflota_incidencia->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // flota
        $this->flota->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // falla
        $this->falla->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // solicitante
        $this->solicitante->RowCssClass = "row";

        // diagnostico
        $this->diagnostico->RowCssClass = "row";

        // reparacion
        $this->reparacion->RowCssClass = "row";

        // cambio_aceite
        $this->cambio_aceite->RowCssClass = "row";

        // kilometraje
        $this->kilometraje->RowCssClass = "row";

        // cantidad
        $this->cantidad->RowCssClass = "row";

        // proveedor
        $this->proveedor->RowCssClass = "row";

        // monto
        $this->monto->RowCssClass = "row";

        // username
        $this->_username->RowCssClass = "row";

        // username_diagnostica
        $this->username_diagnostica->RowCssClass = "row";

        // fecha_reparacion
        $this->fecha_reparacion->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nflota_incidencia
            $this->Nflota_incidencia->ViewValue = $this->Nflota_incidencia->CurrentValue;

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // flota
            $this->flota->ViewValue = $this->flota->CurrentValue;
            $curVal = strval($this->flota->CurrentValue);
            if ($curVal != "") {
                $this->flota->ViewValue = $this->flota->lookupCacheOption($curVal);
                if ($this->flota->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->flota->Lookup->getTable()->Fields["Nflota"]->searchExpression(), "=", $curVal, $this->flota->Lookup->getTable()->Fields["Nflota"]->searchDataType(), "");
                    $lookupFilter = $this->flota->getSelectFilter($this); // PHP
                    $sqlWrk = $this->flota->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->flota->Lookup->renderViewRow($rswrk[0]);
                        $this->flota->ViewValue = $this->flota->displayValue($arwrk);
                    } else {
                        $this->flota->ViewValue = $this->flota->CurrentValue;
                    }
                }
            } else {
                $this->flota->ViewValue = null;
            }

            // tipo
            if (strval($this->tipo->CurrentValue) != "") {
                $this->tipo->ViewValue = $this->tipo->optionCaption($this->tipo->CurrentValue);
            } else {
                $this->tipo->ViewValue = null;
            }

            // falla
            $curVal = strval($this->falla->CurrentValue);
            if ($curVal != "") {
                $this->falla->ViewValue = $this->falla->lookupCacheOption($curVal);
                if ($this->falla->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->falla->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->falla->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->falla->getSelectFilter($this); // PHP
                    $sqlWrk = $this->falla->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->falla->Lookup->renderViewRow($rswrk[0]);
                        $this->falla->ViewValue = $this->falla->displayValue($arwrk);
                    } else {
                        $this->falla->ViewValue = $this->falla->CurrentValue;
                    }
                }
            } else {
                $this->falla->ViewValue = null;
            }

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // solicitante
            $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

            // diagnostico
            $this->diagnostico->ViewValue = $this->diagnostico->CurrentValue;

            // reparacion
            $curVal = strval($this->reparacion->CurrentValue);
            if ($curVal != "") {
                $this->reparacion->ViewValue = $this->reparacion->lookupCacheOption($curVal);
                if ($this->reparacion->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->reparacion->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->reparacion->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->reparacion->getSelectFilter($this); // PHP
                    $sqlWrk = $this->reparacion->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->reparacion->Lookup->renderViewRow($rswrk[0]);
                        $this->reparacion->ViewValue = $this->reparacion->displayValue($arwrk);
                    } else {
                        $this->reparacion->ViewValue = $this->reparacion->CurrentValue;
                    }
                }
            } else {
                $this->reparacion->ViewValue = null;
            }

            // cambio_aceite
            if (strval($this->cambio_aceite->CurrentValue) != "") {
                $this->cambio_aceite->ViewValue = $this->cambio_aceite->optionCaption($this->cambio_aceite->CurrentValue);
            } else {
                $this->cambio_aceite->ViewValue = null;
            }

            // kilometraje
            $this->kilometraje->ViewValue = $this->kilometraje->CurrentValue;

            // cantidad
            $this->cantidad->ViewValue = $this->cantidad->CurrentValue;

            // proveedor
            $curVal = strval($this->proveedor->CurrentValue);
            if ($curVal != "") {
                $this->proveedor->ViewValue = $this->proveedor->lookupCacheOption($curVal);
                if ($this->proveedor->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $curVal, $this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                    $lookupFilter = $this->proveedor->getSelectFilter($this); // PHP
                    $sqlWrk = $this->proveedor->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // monto
            $this->monto->ViewValue = $this->monto->CurrentValue;
            $this->monto->ViewValue = FormatCurrency($this->monto->ViewValue, $this->monto->formatPattern());

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

            // username_diagnostica
            $this->username_diagnostica->ViewValue = $this->username_diagnostica->CurrentValue;

            // fecha_reparacion
            $this->fecha_reparacion->ViewValue = $this->fecha_reparacion->CurrentValue;
            $this->fecha_reparacion->ViewValue = FormatDateTime($this->fecha_reparacion->ViewValue, $this->fecha_reparacion->formatPattern());

            // Nflota_incidencia
            $this->Nflota_incidencia->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // flota
            $this->flota->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // falla
            $this->falla->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";

            // diagnostico
            $this->diagnostico->HrefValue = "";

            // reparacion
            $this->reparacion->HrefValue = "";

            // cambio_aceite
            $this->cambio_aceite->HrefValue = "";

            // kilometraje
            $this->kilometraje->HrefValue = "";

            // proveedor
            $this->proveedor->HrefValue = "";

            // fecha_reparacion
            $this->fecha_reparacion->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nflota_incidencia
            $this->Nflota_incidencia->setupEditAttributes();
            $this->Nflota_incidencia->EditValue = $this->Nflota_incidencia->CurrentValue;

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->EditValue, $this->fecha_registro->formatPattern());

            // flota
            $this->flota->setupEditAttributes();
            $this->flota->EditValue = $this->flota->CurrentValue;
            $curVal = strval($this->flota->CurrentValue);
            if ($curVal != "") {
                $this->flota->EditValue = $this->flota->lookupCacheOption($curVal);
                if ($this->flota->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->flota->Lookup->getTable()->Fields["Nflota"]->searchExpression(), "=", $curVal, $this->flota->Lookup->getTable()->Fields["Nflota"]->searchDataType(), "");
                    $lookupFilter = $this->flota->getSelectFilter($this); // PHP
                    $sqlWrk = $this->flota->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->flota->Lookup->renderViewRow($rswrk[0]);
                        $this->flota->EditValue = $this->flota->displayValue($arwrk);
                    } else {
                        $this->flota->EditValue = HtmlEncode($this->flota->CurrentValue);
                    }
                }
            } else {
                $this->flota->EditValue = null;
            }
            $this->flota->PlaceHolder = RemoveHtml($this->flota->caption());

            // tipo
            $this->tipo->setupEditAttributes();
            $this->tipo->EditValue = $this->tipo->options(true);
            $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

            // falla
            $this->falla->setupEditAttributes();
            $curVal = trim(strval($this->falla->CurrentValue));
            if ($curVal != "") {
                $this->falla->ViewValue = $this->falla->lookupCacheOption($curVal);
            } else {
                $this->falla->ViewValue = $this->falla->Lookup !== null && is_array($this->falla->lookupOptions()) && count($this->falla->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->falla->ViewValue !== null) { // Load from cache
                $this->falla->EditValue = array_values($this->falla->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->falla->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $this->falla->CurrentValue, $this->falla->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                }
                $lookupFilter = $this->falla->getSelectFilter($this); // PHP
                $sqlWrk = $this->falla->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->falla->EditValue = $arwrk;
            }
            $this->falla->PlaceHolder = RemoveHtml($this->falla->caption());

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // solicitante
            $this->solicitante->setupEditAttributes();
            if (!$this->solicitante->Raw) {
                $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
            }
            $this->solicitante->EditValue = HtmlEncode($this->solicitante->CurrentValue);
            $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

            // diagnostico
            $this->diagnostico->setupEditAttributes();
            $this->diagnostico->EditValue = HtmlEncode($this->diagnostico->CurrentValue);
            $this->diagnostico->PlaceHolder = RemoveHtml($this->diagnostico->caption());

            // reparacion
            $this->reparacion->setupEditAttributes();
            $curVal = trim(strval($this->reparacion->CurrentValue));
            if ($curVal != "") {
                $this->reparacion->ViewValue = $this->reparacion->lookupCacheOption($curVal);
            } else {
                $this->reparacion->ViewValue = $this->reparacion->Lookup !== null && is_array($this->reparacion->lookupOptions()) && count($this->reparacion->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->reparacion->ViewValue !== null) { // Load from cache
                $this->reparacion->EditValue = array_values($this->reparacion->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->reparacion->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $this->reparacion->CurrentValue, $this->reparacion->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                }
                $lookupFilter = $this->reparacion->getSelectFilter($this); // PHP
                $sqlWrk = $this->reparacion->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->reparacion->EditValue = $arwrk;
            }
            $this->reparacion->PlaceHolder = RemoveHtml($this->reparacion->caption());

            // cambio_aceite
            $this->cambio_aceite->setupEditAttributes();
            $this->cambio_aceite->EditValue = $this->cambio_aceite->options(true);
            $this->cambio_aceite->PlaceHolder = RemoveHtml($this->cambio_aceite->caption());

            // kilometraje
            $this->kilometraje->setupEditAttributes();
            $this->kilometraje->EditValue = $this->kilometraje->CurrentValue;
            $this->kilometraje->PlaceHolder = RemoveHtml($this->kilometraje->caption());
            if (strval($this->kilometraje->EditValue) != "" && is_numeric($this->kilometraje->EditValue)) {
                $this->kilometraje->EditValue = $this->kilometraje->EditValue;
            }

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
                $lookupFilter = $this->proveedor->getSelectFilter($this); // PHP
                $sqlWrk = $this->proveedor->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->proveedor->EditValue = $arwrk;
            }
            $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());

            // fecha_reparacion
            $this->fecha_reparacion->setupEditAttributes();
            $this->fecha_reparacion->EditValue = HtmlEncode(FormatDateTime($this->fecha_reparacion->CurrentValue, $this->fecha_reparacion->formatPattern()));
            $this->fecha_reparacion->PlaceHolder = RemoveHtml($this->fecha_reparacion->caption());

            // Edit refer script

            // Nflota_incidencia
            $this->Nflota_incidencia->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // flota
            $this->flota->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // falla
            $this->falla->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";

            // diagnostico
            $this->diagnostico->HrefValue = "";

            // reparacion
            $this->reparacion->HrefValue = "";

            // cambio_aceite
            $this->cambio_aceite->HrefValue = "";

            // kilometraje
            $this->kilometraje->HrefValue = "";

            // proveedor
            $this->proveedor->HrefValue = "";

            // fecha_reparacion
            $this->fecha_reparacion->HrefValue = "";
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
            if ($this->Nflota_incidencia->Visible && $this->Nflota_incidencia->Required) {
                if (!$this->Nflota_incidencia->IsDetailKey && EmptyValue($this->Nflota_incidencia->FormValue)) {
                    $this->Nflota_incidencia->addErrorMessage(str_replace("%s", $this->Nflota_incidencia->caption(), $this->Nflota_incidencia->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Nflota_incidencia->FormValue)) {
                $this->Nflota_incidencia->addErrorMessage($this->Nflota_incidencia->getErrorMessage(false));
            }
            if ($this->fecha_registro->Visible && $this->fecha_registro->Required) {
                if (!$this->fecha_registro->IsDetailKey && EmptyValue($this->fecha_registro->FormValue)) {
                    $this->fecha_registro->addErrorMessage(str_replace("%s", $this->fecha_registro->caption(), $this->fecha_registro->RequiredErrorMessage));
                }
            }
            if ($this->flota->Visible && $this->flota->Required) {
                if (!$this->flota->IsDetailKey && EmptyValue($this->flota->FormValue)) {
                    $this->flota->addErrorMessage(str_replace("%s", $this->flota->caption(), $this->flota->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->flota->FormValue)) {
                $this->flota->addErrorMessage($this->flota->getErrorMessage(false));
            }
            if ($this->tipo->Visible && $this->tipo->Required) {
                if (!$this->tipo->IsDetailKey && EmptyValue($this->tipo->FormValue)) {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->falla->Visible && $this->falla->Required) {
                if (!$this->falla->IsDetailKey && EmptyValue($this->falla->FormValue)) {
                    $this->falla->addErrorMessage(str_replace("%s", $this->falla->caption(), $this->falla->RequiredErrorMessage));
                }
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->solicitante->Visible && $this->solicitante->Required) {
                if (!$this->solicitante->IsDetailKey && EmptyValue($this->solicitante->FormValue)) {
                    $this->solicitante->addErrorMessage(str_replace("%s", $this->solicitante->caption(), $this->solicitante->RequiredErrorMessage));
                }
            }
            if ($this->diagnostico->Visible && $this->diagnostico->Required) {
                if (!$this->diagnostico->IsDetailKey && EmptyValue($this->diagnostico->FormValue)) {
                    $this->diagnostico->addErrorMessage(str_replace("%s", $this->diagnostico->caption(), $this->diagnostico->RequiredErrorMessage));
                }
            }
            if ($this->reparacion->Visible && $this->reparacion->Required) {
                if (!$this->reparacion->IsDetailKey && EmptyValue($this->reparacion->FormValue)) {
                    $this->reparacion->addErrorMessage(str_replace("%s", $this->reparacion->caption(), $this->reparacion->RequiredErrorMessage));
                }
            }
            if ($this->cambio_aceite->Visible && $this->cambio_aceite->Required) {
                if (!$this->cambio_aceite->IsDetailKey && EmptyValue($this->cambio_aceite->FormValue)) {
                    $this->cambio_aceite->addErrorMessage(str_replace("%s", $this->cambio_aceite->caption(), $this->cambio_aceite->RequiredErrorMessage));
                }
            }
            if ($this->kilometraje->Visible && $this->kilometraje->Required) {
                if (!$this->kilometraje->IsDetailKey && EmptyValue($this->kilometraje->FormValue)) {
                    $this->kilometraje->addErrorMessage(str_replace("%s", $this->kilometraje->caption(), $this->kilometraje->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->kilometraje->FormValue)) {
                $this->kilometraje->addErrorMessage($this->kilometraje->getErrorMessage(false));
            }
            if ($this->proveedor->Visible && $this->proveedor->Required) {
                if (!$this->proveedor->IsDetailKey && EmptyValue($this->proveedor->FormValue)) {
                    $this->proveedor->addErrorMessage(str_replace("%s", $this->proveedor->caption(), $this->proveedor->RequiredErrorMessage));
                }
            }
            if ($this->fecha_reparacion->Visible && $this->fecha_reparacion->Required) {
                if (!$this->fecha_reparacion->IsDetailKey && EmptyValue($this->fecha_reparacion->FormValue)) {
                    $this->fecha_reparacion->addErrorMessage(str_replace("%s", $this->fecha_reparacion->caption(), $this->fecha_reparacion->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_reparacion->FormValue, $this->fecha_reparacion->formatPattern())) {
                $this->fecha_reparacion->addErrorMessage($this->fecha_reparacion->getErrorMessage(false));
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoFlotaIncidenciaDetalleGrid");
        if (in_array("sco_flota_incidencia_detalle", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoAdjuntoGrid");
        if (in_array("sco_adjunto", $detailTblVar) && $detailPage->DetailEdit) {
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

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

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

            // Update detail records
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("ScoFlotaIncidenciaDetalleGrid");
            if (in_array("sco_flota_incidencia_detalle", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_flota_incidencia_detalle"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }
            $detailPage = Container("ScoAdjuntoGrid");
            if (in_array("sco_adjunto", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_adjunto"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }

            // Commit/Rollback transaction
            if ($this->getCurrentDetailTable() != "") {
                if ($editRow) {
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

        // flota
        $this->flota->setDbValueDef($rsnew, $this->flota->CurrentValue, $this->flota->ReadOnly);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, $this->tipo->ReadOnly);

        // falla
        $this->falla->setDbValueDef($rsnew, $this->falla->CurrentValue, $this->falla->ReadOnly);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, $this->nota->ReadOnly);

        // solicitante
        $this->solicitante->setDbValueDef($rsnew, $this->solicitante->CurrentValue, $this->solicitante->ReadOnly);

        // diagnostico
        $this->diagnostico->setDbValueDef($rsnew, $this->diagnostico->CurrentValue, $this->diagnostico->ReadOnly);

        // reparacion
        $this->reparacion->setDbValueDef($rsnew, $this->reparacion->CurrentValue, $this->reparacion->ReadOnly);

        // cambio_aceite
        $this->cambio_aceite->setDbValueDef($rsnew, $this->cambio_aceite->CurrentValue, $this->cambio_aceite->ReadOnly);

        // kilometraje
        $this->kilometraje->setDbValueDef($rsnew, $this->kilometraje->CurrentValue, $this->kilometraje->ReadOnly);

        // proveedor
        $this->proveedor->setDbValueDef($rsnew, $this->proveedor->CurrentValue, $this->proveedor->ReadOnly);

        // fecha_reparacion
        $this->fecha_reparacion->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_reparacion->CurrentValue, $this->fecha_reparacion->formatPattern()), $this->fecha_reparacion->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['flota'])) { // flota
            $this->flota->CurrentValue = $row['flota'];
        }
        if (isset($row['tipo'])) { // tipo
            $this->tipo->CurrentValue = $row['tipo'];
        }
        if (isset($row['falla'])) { // falla
            $this->falla->CurrentValue = $row['falla'];
        }
        if (isset($row['nota'])) { // nota
            $this->nota->CurrentValue = $row['nota'];
        }
        if (isset($row['solicitante'])) { // solicitante
            $this->solicitante->CurrentValue = $row['solicitante'];
        }
        if (isset($row['diagnostico'])) { // diagnostico
            $this->diagnostico->CurrentValue = $row['diagnostico'];
        }
        if (isset($row['reparacion'])) { // reparacion
            $this->reparacion->CurrentValue = $row['reparacion'];
        }
        if (isset($row['cambio_aceite'])) { // cambio_aceite
            $this->cambio_aceite->CurrentValue = $row['cambio_aceite'];
        }
        if (isset($row['kilometraje'])) { // kilometraje
            $this->kilometraje->CurrentValue = $row['kilometraje'];
        }
        if (isset($row['proveedor'])) { // proveedor
            $this->proveedor->CurrentValue = $row['proveedor'];
        }
        if (isset($row['fecha_reparacion'])) { // fecha_reparacion
            $this->fecha_reparacion->CurrentValue = $row['fecha_reparacion'];
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
            if (in_array("sco_flota_incidencia_detalle", $detailTblVar)) {
                $detailPageObj = Container("ScoFlotaIncidenciaDetalleGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->flota_incidencia->IsDetailKey = true;
                    $detailPageObj->flota_incidencia->CurrentValue = $this->Nflota_incidencia->CurrentValue;
                    $detailPageObj->flota_incidencia->setSessionValue($detailPageObj->flota_incidencia->CurrentValue);
                }
            }
            if (in_array("sco_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoAdjuntoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->flota_incidencia->IsDetailKey = true;
                    $detailPageObj->flota_incidencia->CurrentValue = $this->Nflota_incidencia->CurrentValue;
                    $detailPageObj->flota_incidencia->setSessionValue($detailPageObj->flota_incidencia->CurrentValue);
                    $detailPageObj->servicio->setSessionValue(""); // Clear session key
                    $detailPageObj->flota->setSessionValue(""); // Clear session key
                    $detailPageObj->expediente->setSessionValue(""); // Clear session key
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoFlotaIncidenciaList"), "", $this->TableVar, true);
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
                case "x_flota":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_tipo":
                    break;
                case "x_falla":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_reparacion":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_cambio_aceite":
                    break;
                case "x_proveedor":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x__username":
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
