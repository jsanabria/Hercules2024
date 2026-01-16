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
class ScoCostosEdit extends ScoCostos
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoCostosEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoCostosEdit";

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
        $this->Ncostos->setVisibility();
        $this->id->setVisibility();
        $this->fecha->setVisibility();
        $this->tipo->setVisibility();
        $this->costos_articulos->setVisibility();
        $this->precio_actual->setVisibility();
        $this->porcentaje_aplicado->setVisibility();
        $this->precio_nuevo->setVisibility();
        $this->alicuota_iva->setVisibility();
        $this->monto_iva->setVisibility();
        $this->total->setVisibility();
        $this->cerrado->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_costos';
        $this->TableName = 'sco_costos';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_costos)
        if (!isset($GLOBALS["sco_costos"]) || $GLOBALS["sco_costos"]::class == PROJECT_NAMESPACE . "sco_costos") {
            $GLOBALS["sco_costos"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_costos');
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
                        $result["view"] = SameString($pageName, "ScoCostosView"); // If View page, no primary button
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
            $key .= @$ar['Ncostos'];
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
            $this->Ncostos->Visible = false;
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
        $this->id->Required = false;
        $this->tipo->Required = false;
        $this->costos_articulos->Required = false;
        $this->cerrado->Required = false;

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
        $this->setupLookupOptions($this->costos_articulos);
        $this->setupLookupOptions($this->cerrado);

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
            if (($keyValue = Get("Ncostos") ?? Key(0) ?? Route(2)) !== null) {
                $this->Ncostos->setQueryStringValue($keyValue);
                $this->Ncostos->setOldValue($this->Ncostos->QueryStringValue);
            } elseif (Post("Ncostos") !== null) {
                $this->Ncostos->setFormValue(Post("Ncostos"));
                $this->Ncostos->setOldValue($this->Ncostos->FormValue);
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
                if (($keyValue = Get("Ncostos") ?? Route("Ncostos")) !== null) {
                    $this->Ncostos->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Ncostos->CurrentValue = null;
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
                        $this->terminate("ScoCostosList"); // Return to list page
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
                        if ($this->Ncostos->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Ncostos->CurrentValue, $this->CurrentRow['Ncostos'])) {
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
                        $this->terminate("ScoCostosList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoCostosList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ScoCostosList") {
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
                        if (GetPageName($returnUrl) != "ScoCostosList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoCostosList"; // Return list page content
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

        // Check field name 'Ncostos' first before field var 'x_Ncostos'
        $val = $CurrentForm->hasValue("Ncostos") ? $CurrentForm->getValue("Ncostos") : $CurrentForm->getValue("x_Ncostos");
        if (!$this->Ncostos->IsDetailKey) {
            $this->Ncostos->setFormValue($val);
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id->Visible = false; // Disable update for API request
            } else {
                $this->id->setFormValue($val);
            }
        }

        // Check field name 'fecha' first before field var 'x_fecha'
        $val = $CurrentForm->hasValue("fecha") ? $CurrentForm->getValue("fecha") : $CurrentForm->getValue("x_fecha");
        if (!$this->fecha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha->Visible = false; // Disable update for API request
            } else {
                $this->fecha->setFormValue($val);
            }
            $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
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

        // Check field name 'costos_articulos' first before field var 'x_costos_articulos'
        $val = $CurrentForm->hasValue("costos_articulos") ? $CurrentForm->getValue("costos_articulos") : $CurrentForm->getValue("x_costos_articulos");
        if (!$this->costos_articulos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->costos_articulos->Visible = false; // Disable update for API request
            } else {
                $this->costos_articulos->setFormValue($val);
            }
        }

        // Check field name 'precio_actual' first before field var 'x_precio_actual'
        $val = $CurrentForm->hasValue("precio_actual") ? $CurrentForm->getValue("precio_actual") : $CurrentForm->getValue("x_precio_actual");
        if (!$this->precio_actual->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->precio_actual->Visible = false; // Disable update for API request
            } else {
                $this->precio_actual->setFormValue($val);
            }
        }

        // Check field name 'porcentaje_aplicado' first before field var 'x_porcentaje_aplicado'
        $val = $CurrentForm->hasValue("porcentaje_aplicado") ? $CurrentForm->getValue("porcentaje_aplicado") : $CurrentForm->getValue("x_porcentaje_aplicado");
        if (!$this->porcentaje_aplicado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentaje_aplicado->Visible = false; // Disable update for API request
            } else {
                $this->porcentaje_aplicado->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'precio_nuevo' first before field var 'x_precio_nuevo'
        $val = $CurrentForm->hasValue("precio_nuevo") ? $CurrentForm->getValue("precio_nuevo") : $CurrentForm->getValue("x_precio_nuevo");
        if (!$this->precio_nuevo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->precio_nuevo->Visible = false; // Disable update for API request
            } else {
                $this->precio_nuevo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'alicuota_iva' first before field var 'x_alicuota_iva'
        $val = $CurrentForm->hasValue("alicuota_iva") ? $CurrentForm->getValue("alicuota_iva") : $CurrentForm->getValue("x_alicuota_iva");
        if (!$this->alicuota_iva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alicuota_iva->Visible = false; // Disable update for API request
            } else {
                $this->alicuota_iva->setFormValue($val);
            }
        }

        // Check field name 'monto_iva' first before field var 'x_monto_iva'
        $val = $CurrentForm->hasValue("monto_iva") ? $CurrentForm->getValue("monto_iva") : $CurrentForm->getValue("x_monto_iva");
        if (!$this->monto_iva->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->monto_iva->Visible = false; // Disable update for API request
            } else {
                $this->monto_iva->setFormValue($val);
            }
        }

        // Check field name 'total' first before field var 'x_total'
        $val = $CurrentForm->hasValue("total") ? $CurrentForm->getValue("total") : $CurrentForm->getValue("x_total");
        if (!$this->total->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->total->Visible = false; // Disable update for API request
            } else {
                $this->total->setFormValue($val);
            }
        }

        // Check field name 'cerrado' first before field var 'x_cerrado'
        $val = $CurrentForm->hasValue("cerrado") ? $CurrentForm->getValue("cerrado") : $CurrentForm->getValue("x_cerrado");
        if (!$this->cerrado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cerrado->Visible = false; // Disable update for API request
            } else {
                $this->cerrado->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Ncostos->CurrentValue = $this->Ncostos->FormValue;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->costos_articulos->CurrentValue = $this->costos_articulos->FormValue;
        $this->precio_actual->CurrentValue = $this->precio_actual->FormValue;
        $this->porcentaje_aplicado->CurrentValue = $this->porcentaje_aplicado->FormValue;
        $this->precio_nuevo->CurrentValue = $this->precio_nuevo->FormValue;
        $this->alicuota_iva->CurrentValue = $this->alicuota_iva->FormValue;
        $this->monto_iva->CurrentValue = $this->monto_iva->FormValue;
        $this->total->CurrentValue = $this->total->FormValue;
        $this->cerrado->CurrentValue = $this->cerrado->FormValue;
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
        $this->Ncostos->setDbValue($row['Ncostos']);
        $this->id->setDbValue($row['id']);
        $this->fecha->setDbValue($row['fecha']);
        $this->tipo->setDbValue($row['tipo']);
        $this->costos_articulos->setDbValue($row['costos_articulos']);
        $this->precio_actual->setDbValue($row['precio_actual']);
        $this->porcentaje_aplicado->setDbValue($row['porcentaje_aplicado']);
        $this->precio_nuevo->setDbValue($row['precio_nuevo']);
        $this->alicuota_iva->setDbValue($row['alicuota_iva']);
        $this->monto_iva->setDbValue($row['monto_iva']);
        $this->total->setDbValue($row['total']);
        $this->cerrado->setDbValue($row['cerrado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ncostos'] = $this->Ncostos->DefaultValue;
        $row['id'] = $this->id->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['costos_articulos'] = $this->costos_articulos->DefaultValue;
        $row['precio_actual'] = $this->precio_actual->DefaultValue;
        $row['porcentaje_aplicado'] = $this->porcentaje_aplicado->DefaultValue;
        $row['precio_nuevo'] = $this->precio_nuevo->DefaultValue;
        $row['alicuota_iva'] = $this->alicuota_iva->DefaultValue;
        $row['monto_iva'] = $this->monto_iva->DefaultValue;
        $row['total'] = $this->total->DefaultValue;
        $row['cerrado'] = $this->cerrado->DefaultValue;
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

        // Ncostos
        $this->Ncostos->RowCssClass = "row";

        // id
        $this->id->RowCssClass = "row";

        // fecha
        $this->fecha->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // costos_articulos
        $this->costos_articulos->RowCssClass = "row";

        // precio_actual
        $this->precio_actual->RowCssClass = "row";

        // porcentaje_aplicado
        $this->porcentaje_aplicado->RowCssClass = "row";

        // precio_nuevo
        $this->precio_nuevo->RowCssClass = "row";

        // alicuota_iva
        $this->alicuota_iva->RowCssClass = "row";

        // monto_iva
        $this->monto_iva->RowCssClass = "row";

        // total
        $this->total->RowCssClass = "row";

        // cerrado
        $this->cerrado->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ncostos
            $this->Ncostos->ViewValue = $this->Ncostos->CurrentValue;

            // id
            $this->id->ViewValue = $this->id->CurrentValue;

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // tipo
            $curVal = strval($this->tipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo->ViewValue = $this->tipo->lookupCacheOption($curVal);
                if ($this->tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchExpression(), "=", $curVal, $this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchDataType(), "");
                    $sqlWrk = $this->tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // costos_articulos
            $curVal = strval($this->costos_articulos->CurrentValue);
            if ($curVal != "") {
                $this->costos_articulos->ViewValue = $this->costos_articulos->lookupCacheOption($curVal);
                if ($this->costos_articulos->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $sqlWrk = $this->costos_articulos->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_articulos->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_articulos->ViewValue = $this->costos_articulos->displayValue($arwrk);
                    } else {
                        $this->costos_articulos->ViewValue = $this->costos_articulos->CurrentValue;
                    }
                }
            } else {
                $this->costos_articulos->ViewValue = null;
            }

            // precio_actual
            $this->precio_actual->ViewValue = $this->precio_actual->CurrentValue;
            $this->precio_actual->ViewValue = FormatNumber($this->precio_actual->ViewValue, $this->precio_actual->formatPattern());
            $this->precio_actual->CellCssStyle .= "text-align: right;";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->ViewValue = $this->porcentaje_aplicado->CurrentValue;
            $this->porcentaje_aplicado->ViewValue = FormatNumber($this->porcentaje_aplicado->ViewValue, $this->porcentaje_aplicado->formatPattern());
            $this->porcentaje_aplicado->CellCssStyle .= "text-align: center;";

            // precio_nuevo
            $this->precio_nuevo->ViewValue = $this->precio_nuevo->CurrentValue;
            $this->precio_nuevo->ViewValue = FormatNumber($this->precio_nuevo->ViewValue, $this->precio_nuevo->formatPattern());
            $this->precio_nuevo->CssClass = "fw-bold";
            $this->precio_nuevo->CellCssStyle .= "text-align: right;";

            // alicuota_iva
            $this->alicuota_iva->ViewValue = $this->alicuota_iva->CurrentValue;
            $this->alicuota_iva->ViewValue = FormatNumber($this->alicuota_iva->ViewValue, $this->alicuota_iva->formatPattern());
            $this->alicuota_iva->CellCssStyle .= "text-align: center;";

            // monto_iva
            $this->monto_iva->ViewValue = $this->monto_iva->CurrentValue;
            $this->monto_iva->ViewValue = FormatNumber($this->monto_iva->ViewValue, $this->monto_iva->formatPattern());
            $this->monto_iva->CellCssStyle .= "text-align: right;";

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatNumber($this->total->ViewValue, $this->total->formatPattern());
            $this->total->CellCssStyle .= "text-align: right;";

            // cerrado
            if (strval($this->cerrado->CurrentValue) != "") {
                $this->cerrado->ViewValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
            } else {
                $this->cerrado->ViewValue = null;
            }

            // Ncostos
            $this->Ncostos->HrefValue = "";

            // id
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // costos_articulos
            $this->costos_articulos->HrefValue = "";
            $this->costos_articulos->TooltipValue = "";

            // precio_actual
            $this->precio_actual->HrefValue = "";
            $this->precio_actual->TooltipValue = "";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->HrefValue = "";

            // precio_nuevo
            $this->precio_nuevo->HrefValue = "";

            // alicuota_iva
            $this->alicuota_iva->HrefValue = "";
            $this->alicuota_iva->TooltipValue = "";

            // monto_iva
            $this->monto_iva->HrefValue = "";
            $this->monto_iva->TooltipValue = "";

            // total
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
            $this->cerrado->TooltipValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Ncostos
            $this->Ncostos->setupEditAttributes();
            $this->Ncostos->EditValue = $this->Ncostos->CurrentValue;

            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = $this->id->CurrentValue;

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = $this->fecha->CurrentValue;
            $this->fecha->EditValue = FormatDateTime($this->fecha->EditValue, $this->fecha->formatPattern());

            // tipo
            $this->tipo->setupEditAttributes();
            $curVal = strval($this->tipo->CurrentValue);
            if ($curVal != "") {
                $this->tipo->EditValue = $this->tipo->lookupCacheOption($curVal);
                if ($this->tipo->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchExpression(), "=", $curVal, $this->tipo->Lookup->getTable()->Fields["Ncostos_tipos"]->searchDataType(), "");
                    $sqlWrk = $this->tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo->EditValue = $this->tipo->displayValue($arwrk);
                    } else {
                        $this->tipo->EditValue = $this->tipo->CurrentValue;
                    }
                }
            } else {
                $this->tipo->EditValue = null;
            }

            // costos_articulos
            $this->costos_articulos->setupEditAttributes();
            $curVal = strval($this->costos_articulos->CurrentValue);
            if ($curVal != "") {
                $this->costos_articulos->EditValue = $this->costos_articulos->lookupCacheOption($curVal);
                if ($this->costos_articulos->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->costos_articulos->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $sqlWrk = $this->costos_articulos->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_articulos->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_articulos->EditValue = $this->costos_articulos->displayValue($arwrk);
                    } else {
                        $this->costos_articulos->EditValue = $this->costos_articulos->CurrentValue;
                    }
                }
            } else {
                $this->costos_articulos->EditValue = null;
            }

            // precio_actual
            $this->precio_actual->setupEditAttributes();
            $this->precio_actual->EditValue = $this->precio_actual->CurrentValue;
            $this->precio_actual->EditValue = FormatNumber($this->precio_actual->EditValue, $this->precio_actual->formatPattern());
            $this->precio_actual->CellCssStyle .= "text-align: right;";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->setupEditAttributes();
            $this->porcentaje_aplicado->EditValue = $this->porcentaje_aplicado->CurrentValue;
            $this->porcentaje_aplicado->PlaceHolder = RemoveHtml($this->porcentaje_aplicado->caption());
            if (strval($this->porcentaje_aplicado->EditValue) != "" && is_numeric($this->porcentaje_aplicado->EditValue)) {
                $this->porcentaje_aplicado->EditValue = FormatNumber($this->porcentaje_aplicado->EditValue, null);
            }

            // precio_nuevo
            $this->precio_nuevo->setupEditAttributes();
            $this->precio_nuevo->EditValue = $this->precio_nuevo->CurrentValue;
            $this->precio_nuevo->PlaceHolder = RemoveHtml($this->precio_nuevo->caption());
            if (strval($this->precio_nuevo->EditValue) != "" && is_numeric($this->precio_nuevo->EditValue)) {
                $this->precio_nuevo->EditValue = FormatNumber($this->precio_nuevo->EditValue, null);
            }

            // alicuota_iva
            $this->alicuota_iva->setupEditAttributes();
            $this->alicuota_iva->EditValue = $this->alicuota_iva->CurrentValue;
            $this->alicuota_iva->EditValue = FormatNumber($this->alicuota_iva->EditValue, $this->alicuota_iva->formatPattern());
            $this->alicuota_iva->CellCssStyle .= "text-align: center;";

            // monto_iva
            $this->monto_iva->setupEditAttributes();
            $this->monto_iva->EditValue = $this->monto_iva->CurrentValue;
            $this->monto_iva->EditValue = FormatNumber($this->monto_iva->EditValue, $this->monto_iva->formatPattern());
            $this->monto_iva->CellCssStyle .= "text-align: right;";

            // total
            $this->total->setupEditAttributes();
            $this->total->EditValue = $this->total->CurrentValue;
            $this->total->EditValue = FormatNumber($this->total->EditValue, $this->total->formatPattern());
            $this->total->CellCssStyle .= "text-align: right;";

            // cerrado
            $this->cerrado->setupEditAttributes();
            if (strval($this->cerrado->CurrentValue) != "") {
                $this->cerrado->EditValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
            } else {
                $this->cerrado->EditValue = null;
            }

            // Edit refer script

            // Ncostos
            $this->Ncostos->HrefValue = "";

            // id
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // costos_articulos
            $this->costos_articulos->HrefValue = "";
            $this->costos_articulos->TooltipValue = "";

            // precio_actual
            $this->precio_actual->HrefValue = "";
            $this->precio_actual->TooltipValue = "";

            // porcentaje_aplicado
            $this->porcentaje_aplicado->HrefValue = "";

            // precio_nuevo
            $this->precio_nuevo->HrefValue = "";

            // alicuota_iva
            $this->alicuota_iva->HrefValue = "";
            $this->alicuota_iva->TooltipValue = "";

            // monto_iva
            $this->monto_iva->HrefValue = "";
            $this->monto_iva->TooltipValue = "";

            // total
            $this->total->HrefValue = "";
            $this->total->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
            $this->cerrado->TooltipValue = "";
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
            if ($this->Ncostos->Visible && $this->Ncostos->Required) {
                if (!$this->Ncostos->IsDetailKey && EmptyValue($this->Ncostos->FormValue)) {
                    $this->Ncostos->addErrorMessage(str_replace("%s", $this->Ncostos->caption(), $this->Ncostos->RequiredErrorMessage));
                }
            }
            if ($this->id->Visible && $this->id->Required) {
                if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                    $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
                }
            }
            if ($this->fecha->Visible && $this->fecha->Required) {
                if (!$this->fecha->IsDetailKey && EmptyValue($this->fecha->FormValue)) {
                    $this->fecha->addErrorMessage(str_replace("%s", $this->fecha->caption(), $this->fecha->RequiredErrorMessage));
                }
            }
            if ($this->tipo->Visible && $this->tipo->Required) {
                if (!$this->tipo->IsDetailKey && EmptyValue($this->tipo->FormValue)) {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->costos_articulos->Visible && $this->costos_articulos->Required) {
                if (!$this->costos_articulos->IsDetailKey && EmptyValue($this->costos_articulos->FormValue)) {
                    $this->costos_articulos->addErrorMessage(str_replace("%s", $this->costos_articulos->caption(), $this->costos_articulos->RequiredErrorMessage));
                }
            }
            if ($this->precio_actual->Visible && $this->precio_actual->Required) {
                if (!$this->precio_actual->IsDetailKey && EmptyValue($this->precio_actual->FormValue)) {
                    $this->precio_actual->addErrorMessage(str_replace("%s", $this->precio_actual->caption(), $this->precio_actual->RequiredErrorMessage));
                }
            }
            if ($this->porcentaje_aplicado->Visible && $this->porcentaje_aplicado->Required) {
                if (!$this->porcentaje_aplicado->IsDetailKey && EmptyValue($this->porcentaje_aplicado->FormValue)) {
                    $this->porcentaje_aplicado->addErrorMessage(str_replace("%s", $this->porcentaje_aplicado->caption(), $this->porcentaje_aplicado->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->porcentaje_aplicado->FormValue)) {
                $this->porcentaje_aplicado->addErrorMessage($this->porcentaje_aplicado->getErrorMessage(false));
            }
            if ($this->precio_nuevo->Visible && $this->precio_nuevo->Required) {
                if (!$this->precio_nuevo->IsDetailKey && EmptyValue($this->precio_nuevo->FormValue)) {
                    $this->precio_nuevo->addErrorMessage(str_replace("%s", $this->precio_nuevo->caption(), $this->precio_nuevo->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->precio_nuevo->FormValue)) {
                $this->precio_nuevo->addErrorMessage($this->precio_nuevo->getErrorMessage(false));
            }
            if ($this->alicuota_iva->Visible && $this->alicuota_iva->Required) {
                if (!$this->alicuota_iva->IsDetailKey && EmptyValue($this->alicuota_iva->FormValue)) {
                    $this->alicuota_iva->addErrorMessage(str_replace("%s", $this->alicuota_iva->caption(), $this->alicuota_iva->RequiredErrorMessage));
                }
            }
            if ($this->monto_iva->Visible && $this->monto_iva->Required) {
                if (!$this->monto_iva->IsDetailKey && EmptyValue($this->monto_iva->FormValue)) {
                    $this->monto_iva->addErrorMessage(str_replace("%s", $this->monto_iva->caption(), $this->monto_iva->RequiredErrorMessage));
                }
            }
            if ($this->total->Visible && $this->total->Required) {
                if (!$this->total->IsDetailKey && EmptyValue($this->total->FormValue)) {
                    $this->total->addErrorMessage(str_replace("%s", $this->total->caption(), $this->total->RequiredErrorMessage));
                }
            }
            if ($this->cerrado->Visible && $this->cerrado->Required) {
                if (!$this->cerrado->IsDetailKey && EmptyValue($this->cerrado->FormValue)) {
                    $this->cerrado->addErrorMessage(str_replace("%s", $this->cerrado->caption(), $this->cerrado->RequiredErrorMessage));
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

        // porcentaje_aplicado
        $this->porcentaje_aplicado->setDbValueDef($rsnew, $this->porcentaje_aplicado->CurrentValue, $this->porcentaje_aplicado->ReadOnly);

        // precio_nuevo
        $this->precio_nuevo->setDbValueDef($rsnew, $this->precio_nuevo->CurrentValue, $this->precio_nuevo->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['porcentaje_aplicado'])) { // porcentaje_aplicado
            $this->porcentaje_aplicado->CurrentValue = $row['porcentaje_aplicado'];
        }
        if (isset($row['precio_nuevo'])) { // precio_nuevo
            $this->precio_nuevo->CurrentValue = $row['precio_nuevo'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoCostosList"), "", $this->TableVar, true);
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
                case "x_tipo":
                    break;
                case "x_costos_articulos":
                    break;
                case "x_cerrado":
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
