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
class ScoOrdenSalidaEdit extends ScoOrdenSalida
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoOrdenSalidaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoOrdenSalidaEdit";

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
        $this->Norden_salida->setVisibility();
        $this->fecha_hora->Visible = false;
        $this->_username->Visible = false;
        $this->grupo->setVisibility();
        $this->conductor->setVisibility();
        $this->acompanantes->setVisibility();
        $this->placa->setVisibility();
        $this->motivo->setVisibility();
        $this->observaciones->setVisibility();
        $this->autoriza->Visible = false;
        $this->fecha_autoriza->Visible = false;
        $this->estatus->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_orden_salida';
        $this->TableName = 'sco_orden_salida';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_orden_salida)
        if (!isset($GLOBALS["sco_orden_salida"]) || $GLOBALS["sco_orden_salida"]::class == PROJECT_NAMESPACE . "sco_orden_salida") {
            $GLOBALS["sco_orden_salida"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_orden_salida');
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
                        $result["view"] = SameString($pageName, "ScoOrdenSalidaView"); // If View page, no primary button
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
            $key .= @$ar['Norden_salida'];
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
            $this->Norden_salida->Visible = false;
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
        $this->setupLookupOptions($this->_username);
        $this->setupLookupOptions($this->grupo);
        $this->setupLookupOptions($this->conductor);
        $this->setupLookupOptions($this->placa);
        $this->setupLookupOptions($this->motivo);
        $this->setupLookupOptions($this->autoriza);
        $this->setupLookupOptions($this->estatus);

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
            if (($keyValue = Get("Norden_salida") ?? Key(0) ?? Route(2)) !== null) {
                $this->Norden_salida->setQueryStringValue($keyValue);
                $this->Norden_salida->setOldValue($this->Norden_salida->QueryStringValue);
            } elseif (Post("Norden_salida") !== null) {
                $this->Norden_salida->setFormValue(Post("Norden_salida"));
                $this->Norden_salida->setOldValue($this->Norden_salida->FormValue);
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
                if (($keyValue = Get("Norden_salida") ?? Route("Norden_salida")) !== null) {
                    $this->Norden_salida->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Norden_salida->CurrentValue = null;
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
                        $this->terminate("ScoOrdenSalidaList"); // Return to list page
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
                        if ($this->Norden_salida->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Norden_salida->CurrentValue, $this->CurrentRow['Norden_salida'])) {
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
                        $this->terminate("ScoOrdenSalidaList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoOrdenSalidaList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ScoOrdenSalidaList") {
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
                        if (GetPageName($returnUrl) != "ScoOrdenSalidaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoOrdenSalidaList"; // Return list page content
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

        // Check field name 'Norden_salida' first before field var 'x_Norden_salida'
        $val = $CurrentForm->hasValue("Norden_salida") ? $CurrentForm->getValue("Norden_salida") : $CurrentForm->getValue("x_Norden_salida");
        if (!$this->Norden_salida->IsDetailKey) {
            $this->Norden_salida->setFormValue($val);
        }

        // Check field name 'grupo' first before field var 'x_grupo'
        $val = $CurrentForm->hasValue("grupo") ? $CurrentForm->getValue("grupo") : $CurrentForm->getValue("x_grupo");
        if (!$this->grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->grupo->Visible = false; // Disable update for API request
            } else {
                $this->grupo->setFormValue($val);
            }
        }

        // Check field name 'conductor' first before field var 'x_conductor'
        $val = $CurrentForm->hasValue("conductor") ? $CurrentForm->getValue("conductor") : $CurrentForm->getValue("x_conductor");
        if (!$this->conductor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->conductor->Visible = false; // Disable update for API request
            } else {
                $this->conductor->setFormValue($val);
            }
        }

        // Check field name 'acompanantes' first before field var 'x_acompanantes'
        $val = $CurrentForm->hasValue("acompanantes") ? $CurrentForm->getValue("acompanantes") : $CurrentForm->getValue("x_acompanantes");
        if (!$this->acompanantes->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->acompanantes->Visible = false; // Disable update for API request
            } else {
                $this->acompanantes->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'placa' first before field var 'x_placa'
        $val = $CurrentForm->hasValue("placa") ? $CurrentForm->getValue("placa") : $CurrentForm->getValue("x_placa");
        if (!$this->placa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->placa->Visible = false; // Disable update for API request
            } else {
                $this->placa->setFormValue($val);
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

        // Check field name 'observaciones' first before field var 'x_observaciones'
        $val = $CurrentForm->hasValue("observaciones") ? $CurrentForm->getValue("observaciones") : $CurrentForm->getValue("x_observaciones");
        if (!$this->observaciones->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->observaciones->Visible = false; // Disable update for API request
            } else {
                $this->observaciones->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Norden_salida->CurrentValue = $this->Norden_salida->FormValue;
        $this->grupo->CurrentValue = $this->grupo->FormValue;
        $this->conductor->CurrentValue = $this->conductor->FormValue;
        $this->acompanantes->CurrentValue = $this->acompanantes->FormValue;
        $this->placa->CurrentValue = $this->placa->FormValue;
        $this->motivo->CurrentValue = $this->motivo->FormValue;
        $this->observaciones->CurrentValue = $this->observaciones->FormValue;
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
        $this->Norden_salida->setDbValue($row['Norden_salida']);
        $this->fecha_hora->setDbValue($row['fecha_hora']);
        $this->_username->setDbValue($row['username']);
        $this->grupo->setDbValue($row['grupo']);
        $this->conductor->setDbValue($row['conductor']);
        $this->acompanantes->setDbValue($row['acompanantes']);
        $this->placa->setDbValue($row['placa']);
        $this->motivo->setDbValue($row['motivo']);
        $this->observaciones->setDbValue($row['observaciones']);
        $this->autoriza->setDbValue($row['autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Norden_salida'] = $this->Norden_salida->DefaultValue;
        $row['fecha_hora'] = $this->fecha_hora->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['grupo'] = $this->grupo->DefaultValue;
        $row['conductor'] = $this->conductor->DefaultValue;
        $row['acompanantes'] = $this->acompanantes->DefaultValue;
        $row['placa'] = $this->placa->DefaultValue;
        $row['motivo'] = $this->motivo->DefaultValue;
        $row['observaciones'] = $this->observaciones->DefaultValue;
        $row['autoriza'] = $this->autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
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

        // Norden_salida
        $this->Norden_salida->RowCssClass = "row";

        // fecha_hora
        $this->fecha_hora->RowCssClass = "row";

        // username
        $this->_username->RowCssClass = "row";

        // grupo
        $this->grupo->RowCssClass = "row";

        // conductor
        $this->conductor->RowCssClass = "row";

        // acompanantes
        $this->acompanantes->RowCssClass = "row";

        // placa
        $this->placa->RowCssClass = "row";

        // motivo
        $this->motivo->RowCssClass = "row";

        // observaciones
        $this->observaciones->RowCssClass = "row";

        // autoriza
        $this->autoriza->RowCssClass = "row";

        // fecha_autoriza
        $this->fecha_autoriza->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Norden_salida
            $this->Norden_salida->ViewValue = $this->Norden_salida->CurrentValue;

            // fecha_hora
            $this->fecha_hora->ViewValue = $this->fecha_hora->CurrentValue;
            $this->fecha_hora->ViewValue = FormatDateTime($this->fecha_hora->ViewValue, $this->fecha_hora->formatPattern());

            // username
            $curVal = strval($this->_username->CurrentValue);
            if ($curVal != "") {
                $this->_username->ViewValue = $this->_username->lookupCacheOption($curVal);
                if ($this->_username->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->_username->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->_username->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $lookupFilter = $this->_username->getSelectFilter($this); // PHP
                    $sqlWrk = $this->_username->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // grupo
            $curVal = strval($this->grupo->CurrentValue);
            if ($curVal != "") {
                $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
                if ($this->grupo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->grupo->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $curVal, $this->grupo->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                    $sqlWrk = $this->grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                        $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                    } else {
                        $this->grupo->ViewValue = $this->grupo->CurrentValue;
                    }
                }
            } else {
                $this->grupo->ViewValue = null;
            }

            // conductor
            $curVal = strval($this->conductor->CurrentValue);
            if ($curVal != "") {
                $this->conductor->ViewValue = $this->conductor->lookupCacheOption($curVal);
                if ($this->conductor->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->conductor->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->conductor->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $lookupFilter = $this->conductor->getSelectFilter($this); // PHP
                    $sqlWrk = $this->conductor->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->conductor->Lookup->renderViewRow($rswrk[0]);
                        $this->conductor->ViewValue = $this->conductor->displayValue($arwrk);
                    } else {
                        $this->conductor->ViewValue = $this->conductor->CurrentValue;
                    }
                }
            } else {
                $this->conductor->ViewValue = null;
            }

            // acompanantes
            $this->acompanantes->ViewValue = $this->acompanantes->CurrentValue;

            // placa
            $this->placa->ViewValue = $this->placa->CurrentValue;
            $curVal = strval($this->placa->CurrentValue);
            if ($curVal != "") {
                $this->placa->ViewValue = $this->placa->lookupCacheOption($curVal);
                if ($this->placa->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->placa->Lookup->getTable()->Fields["placa"]->searchExpression(), "=", $curVal, $this->placa->Lookup->getTable()->Fields["placa"]->searchDataType(), "");
                    $lookupFilter = $this->placa->getSelectFilter($this); // PHP
                    $sqlWrk = $this->placa->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->placa->Lookup->renderViewRow($rswrk[0]);
                        $this->placa->ViewValue = $this->placa->displayValue($arwrk);
                    } else {
                        $this->placa->ViewValue = $this->placa->CurrentValue;
                    }
                }
            } else {
                $this->placa->ViewValue = null;
            }

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

            // observaciones
            $this->observaciones->ViewValue = $this->observaciones->CurrentValue;

            // autoriza
            $curVal = strval($this->autoriza->CurrentValue);
            if ($curVal != "") {
                $this->autoriza->ViewValue = $this->autoriza->lookupCacheOption($curVal);
                if ($this->autoriza->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->autoriza->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->autoriza->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->autoriza->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->autoriza->Lookup->renderViewRow($rswrk[0]);
                        $this->autoriza->ViewValue = $this->autoriza->displayValue($arwrk);
                    } else {
                        $this->autoriza->ViewValue = $this->autoriza->CurrentValue;
                    }
                }
            } else {
                $this->autoriza->ViewValue = null;
            }

            // fecha_autoriza
            $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
            $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

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

            // Norden_salida
            $this->Norden_salida->HrefValue = "";

            // grupo
            $this->grupo->HrefValue = "";

            // conductor
            $this->conductor->HrefValue = "";

            // acompanantes
            $this->acompanantes->HrefValue = "";

            // placa
            $this->placa->HrefValue = "";

            // motivo
            $this->motivo->HrefValue = "";

            // observaciones
            $this->observaciones->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Norden_salida
            $this->Norden_salida->setupEditAttributes();
            $this->Norden_salida->EditValue = $this->Norden_salida->CurrentValue;

            // grupo
            $curVal = trim(strval($this->grupo->CurrentValue));
            if ($curVal != "") {
                $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
            } else {
                $this->grupo->ViewValue = $this->grupo->Lookup !== null && is_array($this->grupo->lookupOptions()) && count($this->grupo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->grupo->ViewValue !== null) { // Load from cache
                $this->grupo->EditValue = array_values($this->grupo->lookupOptions());
                if ($this->grupo->ViewValue == "") {
                    $this->grupo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->grupo->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $this->grupo->CurrentValue, $this->grupo->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                }
                $sqlWrk = $this->grupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                    $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                } else {
                    $this->grupo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->grupo->EditValue = $arwrk;
            }
            $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());

            // conductor
            $curVal = trim(strval($this->conductor->CurrentValue));
            if ($curVal != "") {
                $this->conductor->ViewValue = $this->conductor->lookupCacheOption($curVal);
            } else {
                $this->conductor->ViewValue = $this->conductor->Lookup !== null && is_array($this->conductor->lookupOptions()) && count($this->conductor->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->conductor->ViewValue !== null) { // Load from cache
                $this->conductor->EditValue = array_values($this->conductor->lookupOptions());
                if ($this->conductor->ViewValue == "") {
                    $this->conductor->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->conductor->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $this->conductor->CurrentValue, $this->conductor->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                }
                $lookupFilter = $this->conductor->getSelectFilter($this); // PHP
                $sqlWrk = $this->conductor->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->conductor->Lookup->renderViewRow($rswrk[0]);
                    $this->conductor->ViewValue = $this->conductor->displayValue($arwrk);
                } else {
                    $this->conductor->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->conductor->EditValue = $arwrk;
            }
            $this->conductor->PlaceHolder = RemoveHtml($this->conductor->caption());

            // acompanantes
            $this->acompanantes->setupEditAttributes();
            $this->acompanantes->EditValue = $this->acompanantes->CurrentValue;
            $this->acompanantes->PlaceHolder = RemoveHtml($this->acompanantes->caption());
            if (strval($this->acompanantes->EditValue) != "" && is_numeric($this->acompanantes->EditValue)) {
                $this->acompanantes->EditValue = $this->acompanantes->EditValue;
            }

            // placa
            $this->placa->setupEditAttributes();
            if (!$this->placa->Raw) {
                $this->placa->CurrentValue = HtmlDecode($this->placa->CurrentValue);
            }
            $this->placa->EditValue = HtmlEncode($this->placa->CurrentValue);
            $curVal = strval($this->placa->CurrentValue);
            if ($curVal != "") {
                $this->placa->EditValue = $this->placa->lookupCacheOption($curVal);
                if ($this->placa->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->placa->Lookup->getTable()->Fields["placa"]->searchExpression(), "=", $curVal, $this->placa->Lookup->getTable()->Fields["placa"]->searchDataType(), "");
                    $lookupFilter = $this->placa->getSelectFilter($this); // PHP
                    $sqlWrk = $this->placa->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->placa->Lookup->renderViewRow($rswrk[0]);
                        $this->placa->EditValue = $this->placa->displayValue($arwrk);
                    } else {
                        $this->placa->EditValue = HtmlEncode($this->placa->CurrentValue);
                    }
                }
            } else {
                $this->placa->EditValue = null;
            }
            $this->placa->PlaceHolder = RemoveHtml($this->placa->caption());

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

            // observaciones
            $this->observaciones->setupEditAttributes();
            $this->observaciones->EditValue = HtmlEncode($this->observaciones->CurrentValue);
            $this->observaciones->PlaceHolder = RemoveHtml($this->observaciones->caption());

            // Edit refer script

            // Norden_salida
            $this->Norden_salida->HrefValue = "";

            // grupo
            $this->grupo->HrefValue = "";

            // conductor
            $this->conductor->HrefValue = "";

            // acompanantes
            $this->acompanantes->HrefValue = "";

            // placa
            $this->placa->HrefValue = "";

            // motivo
            $this->motivo->HrefValue = "";

            // observaciones
            $this->observaciones->HrefValue = "";
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
            if ($this->Norden_salida->Visible && $this->Norden_salida->Required) {
                if (!$this->Norden_salida->IsDetailKey && EmptyValue($this->Norden_salida->FormValue)) {
                    $this->Norden_salida->addErrorMessage(str_replace("%s", $this->Norden_salida->caption(), $this->Norden_salida->RequiredErrorMessage));
                }
            }
            if ($this->grupo->Visible && $this->grupo->Required) {
                if (!$this->grupo->IsDetailKey && EmptyValue($this->grupo->FormValue)) {
                    $this->grupo->addErrorMessage(str_replace("%s", $this->grupo->caption(), $this->grupo->RequiredErrorMessage));
                }
            }
            if ($this->conductor->Visible && $this->conductor->Required) {
                if (!$this->conductor->IsDetailKey && EmptyValue($this->conductor->FormValue)) {
                    $this->conductor->addErrorMessage(str_replace("%s", $this->conductor->caption(), $this->conductor->RequiredErrorMessage));
                }
            }
            if ($this->acompanantes->Visible && $this->acompanantes->Required) {
                if (!$this->acompanantes->IsDetailKey && EmptyValue($this->acompanantes->FormValue)) {
                    $this->acompanantes->addErrorMessage(str_replace("%s", $this->acompanantes->caption(), $this->acompanantes->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->acompanantes->FormValue)) {
                $this->acompanantes->addErrorMessage($this->acompanantes->getErrorMessage(false));
            }
            if ($this->placa->Visible && $this->placa->Required) {
                if (!$this->placa->IsDetailKey && EmptyValue($this->placa->FormValue)) {
                    $this->placa->addErrorMessage(str_replace("%s", $this->placa->caption(), $this->placa->RequiredErrorMessage));
                }
            }
            if ($this->motivo->Visible && $this->motivo->Required) {
                if (!$this->motivo->IsDetailKey && EmptyValue($this->motivo->FormValue)) {
                    $this->motivo->addErrorMessage(str_replace("%s", $this->motivo->caption(), $this->motivo->RequiredErrorMessage));
                }
            }
            if ($this->observaciones->Visible && $this->observaciones->Required) {
                if (!$this->observaciones->IsDetailKey && EmptyValue($this->observaciones->FormValue)) {
                    $this->observaciones->addErrorMessage(str_replace("%s", $this->observaciones->caption(), $this->observaciones->RequiredErrorMessage));
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

        // grupo
        $this->grupo->setDbValueDef($rsnew, $this->grupo->CurrentValue, $this->grupo->ReadOnly);

        // conductor
        $this->conductor->setDbValueDef($rsnew, $this->conductor->CurrentValue, $this->conductor->ReadOnly);

        // acompanantes
        $this->acompanantes->setDbValueDef($rsnew, $this->acompanantes->CurrentValue, $this->acompanantes->ReadOnly);

        // placa
        $this->placa->setDbValueDef($rsnew, $this->placa->CurrentValue, $this->placa->ReadOnly);

        // motivo
        $this->motivo->setDbValueDef($rsnew, $this->motivo->CurrentValue, $this->motivo->ReadOnly);

        // observaciones
        $this->observaciones->setDbValueDef($rsnew, $this->observaciones->CurrentValue, $this->observaciones->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['grupo'])) { // grupo
            $this->grupo->CurrentValue = $row['grupo'];
        }
        if (isset($row['conductor'])) { // conductor
            $this->conductor->CurrentValue = $row['conductor'];
        }
        if (isset($row['acompanantes'])) { // acompanantes
            $this->acompanantes->CurrentValue = $row['acompanantes'];
        }
        if (isset($row['placa'])) { // placa
            $this->placa->CurrentValue = $row['placa'];
        }
        if (isset($row['motivo'])) { // motivo
            $this->motivo->CurrentValue = $row['motivo'];
        }
        if (isset($row['observaciones'])) { // observaciones
            $this->observaciones->CurrentValue = $row['observaciones'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoOrdenSalidaList"), "", $this->TableVar, true);
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
                case "x__username":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_grupo":
                    break;
                case "x_conductor":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_placa":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_motivo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_autoriza":
                    break;
                case "x_estatus":
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
    public function pageDataRendered(&$footer) {
        $username_conductor = $this->conductor->CurrentValue;
        $placa_flota = $this->placa->CurrentValue;

        // 1. --- SEGURIDAD: Sanitizar las variables críticas ---
        $username_seguro = AdjustSql($username_conductor);
        $placa_segura = AdjustSql($placa_flota);

        // Si la placa es esencial y está vacía, podríamos salir temprano.
        if (empty($placa_flota)) {
            return; 
        }

        // 2. --- Consulta 1: Datos del Conductor (Foto) ---
        $sql_conductor = "SELECT nombre, CONCAT('carpetacarga/', foto) AS foto 
                          FROM sco_user 
                          WHERE username = '" . $username_seguro . "'";
        $row_conductor = ExecuteRow($sql_conductor);

        // Inicializar el contenedor principal
        $output = '<div class="row">';

        // Mostrar thumbnail del conductor (si existe la foto)
        if ($row_conductor) {
            $foto_url = htmlspecialchars($row_conductor["foto"]);
            $nombre_conductor = htmlspecialchars($row_conductor["nombre"]);
            $output .= '
                <div class="col-md-2">
                    <div class="thumbnail">
                        <a href="../' . $foto_url . '" target="_blank">
                            <img src="../' . $foto_url . '" alt="Conductor" style="width:100%">
                            <div class="caption">
                                <p>' . $nombre_conductor . '</p>
                            </div>
                        </a>
                    </div>
                </div>';
        }

        // 3. --- Consulta 2: Obtener TODOS los archivos adjuntos de la flota (Eficiencia) ---

        // Se combina la lógica de COUNT y el SELECT en una sola consulta.
        // Usamos LIKE para el filtro de extensiones.
        $sql_adjuntos = "SELECT 
                            CONCAT('../carpetacarga/', a.archivo) AS archivo,
                            CONCAT('Marca: ', c.nombre) AS marca,
                            CONCAT('Modelo: ', d.nombre) AS modelo
                        FROM 
                            sco_adjunto a 
                            JOIN sco_flota b ON b.Nflota = a.flota 
                            LEFT OUTER JOIN sco_marca c ON c.Nmarca = b.marca 
                            LEFT OUTER JOIN sco_modelo d ON d.Nmodelo = b.modelo 
                        WHERE 
                            b.placa = '" . $placa_segura . "'
                            AND (a.archivo LIKE '%.jpg' OR a.archivo LIKE '%.png' OR a.archivo LIKE '%.bmp')
                        ORDER BY a.archivo ASC"; // Se agrega ORDER BY para consistencia
        $rows_adjuntos = ExecuteRows($sql_adjuntos);

        // 4. --- Procesar y Mostrar Adjuntos ---
        if ($rows_adjuntos) {
            foreach ($rows_adjuntos as $row_adjunto) {
                $archivo_url = htmlspecialchars($row_adjunto["archivo"]);
                $marca_texto = htmlspecialchars($row_adjunto["marca"]);
                $modelo_texto = htmlspecialchars($row_adjunto["modelo"]);

                // Nota: Se elimina el <div class="row"> dentro del bucle, ya que 
                // causaría una ruptura incorrecta del layout de Bootstrap.
                $output .= '
                    <div class="col-md-2">
                        <div class="thumbnail">
                            <a href="' . $archivo_url . '" target="_blank">
                                <img src="' . $archivo_url . '" alt="Flota" style="width:100%">
                                <div class="caption">
                                    <p>' . $marca_texto . '</p>
                                    <p>' . $modelo_texto . '</p>
                                </div>
                            </a>
                        </div>
                    </div>';
            }
        }

        // 5. --- Finalizar el Contenedor y Asignar ---
        $output .= '</div>';
        $footer = $output;
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
