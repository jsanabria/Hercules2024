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
class ScoMascotaEdit extends ScoMascota
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoMascotaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoMascotaEdit";

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
        $this->Nmascota->setVisibility();
        $this->nombre_contratante->setVisibility();
        $this->cedula_contratante->setVisibility();
        $this->direccion_contratante->setVisibility();
        $this->telefono1->setVisibility();
        $this->telefono2->setVisibility();
        $this->_email->setVisibility();
        $this->nombre_mascota->setVisibility();
        $this->peso->setVisibility();
        $this->raza->setVisibility();
        $this->tipo->setVisibility();
        $this->tipo_otro->setVisibility();
        $this->color->setVisibility();
        $this->procedencia->setVisibility();
        $this->tarifa->setVisibility();
        $this->factura->setVisibility();
        $this->costo->setVisibility();
        $this->tasa->setVisibility();
        $this->nota->setVisibility();
        $this->fecha_cremacion->setVisibility();
        $this->hora_cremacion->setVisibility();
        $this->username_registra->Visible = false;
        $this->fecha_registro->Visible = false;
        $this->estatus->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_mascota';
        $this->TableName = 'sco_mascota';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_mascota)
        if (!isset($GLOBALS["sco_mascota"]) || $GLOBALS["sco_mascota"]::class == PROJECT_NAMESPACE . "sco_mascota") {
            $GLOBALS["sco_mascota"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_mascota');
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
                        $result["view"] = SameString($pageName, "ScoMascotaView"); // If View page, no primary button
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
            $key .= @$ar['Nmascota'];
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
            $this->Nmascota->Visible = false;
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
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->procedencia);
        $this->setupLookupOptions($this->tarifa);
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
            if (($keyValue = Get("Nmascota") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nmascota->setQueryStringValue($keyValue);
                $this->Nmascota->setOldValue($this->Nmascota->QueryStringValue);
            } elseif (Post("Nmascota") !== null) {
                $this->Nmascota->setFormValue(Post("Nmascota"));
                $this->Nmascota->setOldValue($this->Nmascota->FormValue);
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
                if (($keyValue = Get("Nmascota") ?? Route("Nmascota")) !== null) {
                    $this->Nmascota->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nmascota->CurrentValue = null;
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
                        $this->terminate("ScoMascotaList"); // Return to list page
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
                        if ($this->Nmascota->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nmascota->CurrentValue, $this->CurrentRow['Nmascota'])) {
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
                        $this->terminate("ScoMascotaList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoMascotaList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "ScoMascotaList") {
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
                        if (GetPageName($returnUrl) != "ScoMascotaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoMascotaList"; // Return list page content
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

        // Check field name 'Nmascota' first before field var 'x_Nmascota'
        $val = $CurrentForm->hasValue("Nmascota") ? $CurrentForm->getValue("Nmascota") : $CurrentForm->getValue("x_Nmascota");
        if (!$this->Nmascota->IsDetailKey) {
            $this->Nmascota->setFormValue($val);
        }

        // Check field name 'nombre_contratante' first before field var 'x_nombre_contratante'
        $val = $CurrentForm->hasValue("nombre_contratante") ? $CurrentForm->getValue("nombre_contratante") : $CurrentForm->getValue("x_nombre_contratante");
        if (!$this->nombre_contratante->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_contratante->Visible = false; // Disable update for API request
            } else {
                $this->nombre_contratante->setFormValue($val);
            }
        }

        // Check field name 'cedula_contratante' first before field var 'x_cedula_contratante'
        $val = $CurrentForm->hasValue("cedula_contratante") ? $CurrentForm->getValue("cedula_contratante") : $CurrentForm->getValue("x_cedula_contratante");
        if (!$this->cedula_contratante->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula_contratante->Visible = false; // Disable update for API request
            } else {
                $this->cedula_contratante->setFormValue($val);
            }
        }

        // Check field name 'direccion_contratante' first before field var 'x_direccion_contratante'
        $val = $CurrentForm->hasValue("direccion_contratante") ? $CurrentForm->getValue("direccion_contratante") : $CurrentForm->getValue("x_direccion_contratante");
        if (!$this->direccion_contratante->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direccion_contratante->Visible = false; // Disable update for API request
            } else {
                $this->direccion_contratante->setFormValue($val);
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

        // Check field name 'nombre_mascota' first before field var 'x_nombre_mascota'
        $val = $CurrentForm->hasValue("nombre_mascota") ? $CurrentForm->getValue("nombre_mascota") : $CurrentForm->getValue("x_nombre_mascota");
        if (!$this->nombre_mascota->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_mascota->Visible = false; // Disable update for API request
            } else {
                $this->nombre_mascota->setFormValue($val);
            }
        }

        // Check field name 'peso' first before field var 'x_peso'
        $val = $CurrentForm->hasValue("peso") ? $CurrentForm->getValue("peso") : $CurrentForm->getValue("x_peso");
        if (!$this->peso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->peso->Visible = false; // Disable update for API request
            } else {
                $this->peso->setFormValue($val);
            }
        }

        // Check field name 'raza' first before field var 'x_raza'
        $val = $CurrentForm->hasValue("raza") ? $CurrentForm->getValue("raza") : $CurrentForm->getValue("x_raza");
        if (!$this->raza->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->raza->Visible = false; // Disable update for API request
            } else {
                $this->raza->setFormValue($val);
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

        // Check field name 'tipo_otro' first before field var 'x_tipo_otro'
        $val = $CurrentForm->hasValue("tipo_otro") ? $CurrentForm->getValue("tipo_otro") : $CurrentForm->getValue("x_tipo_otro");
        if (!$this->tipo_otro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_otro->Visible = false; // Disable update for API request
            } else {
                $this->tipo_otro->setFormValue($val);
            }
        }

        // Check field name 'color' first before field var 'x_color'
        $val = $CurrentForm->hasValue("color") ? $CurrentForm->getValue("color") : $CurrentForm->getValue("x_color");
        if (!$this->color->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->color->Visible = false; // Disable update for API request
            } else {
                $this->color->setFormValue($val);
            }
        }

        // Check field name 'procedencia' first before field var 'x_procedencia'
        $val = $CurrentForm->hasValue("procedencia") ? $CurrentForm->getValue("procedencia") : $CurrentForm->getValue("x_procedencia");
        if (!$this->procedencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->procedencia->Visible = false; // Disable update for API request
            } else {
                $this->procedencia->setFormValue($val);
            }
        }

        // Check field name 'tarifa' first before field var 'x_tarifa'
        $val = $CurrentForm->hasValue("tarifa") ? $CurrentForm->getValue("tarifa") : $CurrentForm->getValue("x_tarifa");
        if (!$this->tarifa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tarifa->Visible = false; // Disable update for API request
            } else {
                $this->tarifa->setFormValue($val);
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

        // Check field name 'costo' first before field var 'x_costo'
        $val = $CurrentForm->hasValue("costo") ? $CurrentForm->getValue("costo") : $CurrentForm->getValue("x_costo");
        if (!$this->costo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->costo->Visible = false; // Disable update for API request
            } else {
                $this->costo->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'tasa' first before field var 'x_tasa'
        $val = $CurrentForm->hasValue("tasa") ? $CurrentForm->getValue("tasa") : $CurrentForm->getValue("x_tasa");
        if (!$this->tasa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tasa->Visible = false; // Disable update for API request
            } else {
                $this->tasa->setFormValue($val, true, $validate);
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

        // Check field name 'fecha_cremacion' first before field var 'x_fecha_cremacion'
        $val = $CurrentForm->hasValue("fecha_cremacion") ? $CurrentForm->getValue("fecha_cremacion") : $CurrentForm->getValue("x_fecha_cremacion");
        if (!$this->fecha_cremacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_cremacion->Visible = false; // Disable update for API request
            } else {
                $this->fecha_cremacion->setFormValue($val, true, $validate);
            }
            $this->fecha_cremacion->CurrentValue = UnFormatDateTime($this->fecha_cremacion->CurrentValue, $this->fecha_cremacion->formatPattern());
        }

        // Check field name 'hora_cremacion' first before field var 'x_hora_cremacion'
        $val = $CurrentForm->hasValue("hora_cremacion") ? $CurrentForm->getValue("hora_cremacion") : $CurrentForm->getValue("x_hora_cremacion");
        if (!$this->hora_cremacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_cremacion->Visible = false; // Disable update for API request
            } else {
                $this->hora_cremacion->setFormValue($val, true, $validate);
            }
            $this->hora_cremacion->CurrentValue = UnFormatDateTime($this->hora_cremacion->CurrentValue, $this->hora_cremacion->formatPattern());
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nmascota->CurrentValue = $this->Nmascota->FormValue;
        $this->nombre_contratante->CurrentValue = $this->nombre_contratante->FormValue;
        $this->cedula_contratante->CurrentValue = $this->cedula_contratante->FormValue;
        $this->direccion_contratante->CurrentValue = $this->direccion_contratante->FormValue;
        $this->telefono1->CurrentValue = $this->telefono1->FormValue;
        $this->telefono2->CurrentValue = $this->telefono2->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->nombre_mascota->CurrentValue = $this->nombre_mascota->FormValue;
        $this->peso->CurrentValue = $this->peso->FormValue;
        $this->raza->CurrentValue = $this->raza->FormValue;
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->tipo_otro->CurrentValue = $this->tipo_otro->FormValue;
        $this->color->CurrentValue = $this->color->FormValue;
        $this->procedencia->CurrentValue = $this->procedencia->FormValue;
        $this->tarifa->CurrentValue = $this->tarifa->FormValue;
        $this->factura->CurrentValue = $this->factura->FormValue;
        $this->costo->CurrentValue = $this->costo->FormValue;
        $this->tasa->CurrentValue = $this->tasa->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->fecha_cremacion->CurrentValue = $this->fecha_cremacion->FormValue;
        $this->fecha_cremacion->CurrentValue = UnFormatDateTime($this->fecha_cremacion->CurrentValue, $this->fecha_cremacion->formatPattern());
        $this->hora_cremacion->CurrentValue = $this->hora_cremacion->FormValue;
        $this->hora_cremacion->CurrentValue = UnFormatDateTime($this->hora_cremacion->CurrentValue, $this->hora_cremacion->formatPattern());
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
        $this->Nmascota->setDbValue($row['Nmascota']);
        $this->nombre_contratante->setDbValue($row['nombre_contratante']);
        $this->cedula_contratante->setDbValue($row['cedula_contratante']);
        $this->direccion_contratante->setDbValue($row['direccion_contratante']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->nombre_mascota->setDbValue($row['nombre_mascota']);
        $this->peso->setDbValue($row['peso']);
        $this->raza->setDbValue($row['raza']);
        $this->tipo->setDbValue($row['tipo']);
        $this->tipo_otro->setDbValue($row['tipo_otro']);
        $this->color->setDbValue($row['color']);
        $this->procedencia->setDbValue($row['procedencia']);
        $this->tarifa->setDbValue($row['tarifa']);
        $this->factura->setDbValue($row['factura']);
        $this->costo->setDbValue($row['costo']);
        $this->tasa->setDbValue($row['tasa']);
        $this->nota->setDbValue($row['nota']);
        $this->fecha_cremacion->setDbValue($row['fecha_cremacion']);
        $this->hora_cremacion->setDbValue($row['hora_cremacion']);
        $this->username_registra->setDbValue($row['username_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nmascota'] = $this->Nmascota->DefaultValue;
        $row['nombre_contratante'] = $this->nombre_contratante->DefaultValue;
        $row['cedula_contratante'] = $this->cedula_contratante->DefaultValue;
        $row['direccion_contratante'] = $this->direccion_contratante->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['nombre_mascota'] = $this->nombre_mascota->DefaultValue;
        $row['peso'] = $this->peso->DefaultValue;
        $row['raza'] = $this->raza->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['tipo_otro'] = $this->tipo_otro->DefaultValue;
        $row['color'] = $this->color->DefaultValue;
        $row['procedencia'] = $this->procedencia->DefaultValue;
        $row['tarifa'] = $this->tarifa->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['costo'] = $this->costo->DefaultValue;
        $row['tasa'] = $this->tasa->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['fecha_cremacion'] = $this->fecha_cremacion->DefaultValue;
        $row['hora_cremacion'] = $this->hora_cremacion->DefaultValue;
        $row['username_registra'] = $this->username_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
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

        // Nmascota
        $this->Nmascota->RowCssClass = "row";

        // nombre_contratante
        $this->nombre_contratante->RowCssClass = "row";

        // cedula_contratante
        $this->cedula_contratante->RowCssClass = "row";

        // direccion_contratante
        $this->direccion_contratante->RowCssClass = "row";

        // telefono1
        $this->telefono1->RowCssClass = "row";

        // telefono2
        $this->telefono2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // nombre_mascota
        $this->nombre_mascota->RowCssClass = "row";

        // peso
        $this->peso->RowCssClass = "row";

        // raza
        $this->raza->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // tipo_otro
        $this->tipo_otro->RowCssClass = "row";

        // color
        $this->color->RowCssClass = "row";

        // procedencia
        $this->procedencia->RowCssClass = "row";

        // tarifa
        $this->tarifa->RowCssClass = "row";

        // factura
        $this->factura->RowCssClass = "row";

        // costo
        $this->costo->RowCssClass = "row";

        // tasa
        $this->tasa->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // fecha_cremacion
        $this->fecha_cremacion->RowCssClass = "row";

        // hora_cremacion
        $this->hora_cremacion->RowCssClass = "row";

        // username_registra
        $this->username_registra->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nmascota
            $this->Nmascota->ViewValue = $this->Nmascota->CurrentValue;

            // nombre_contratante
            $this->nombre_contratante->ViewValue = $this->nombre_contratante->CurrentValue;

            // cedula_contratante
            $this->cedula_contratante->ViewValue = $this->cedula_contratante->CurrentValue;

            // direccion_contratante
            $this->direccion_contratante->ViewValue = $this->direccion_contratante->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // nombre_mascota
            $this->nombre_mascota->ViewValue = $this->nombre_mascota->CurrentValue;

            // peso
            $this->peso->ViewValue = $this->peso->CurrentValue;

            // raza
            $this->raza->ViewValue = $this->raza->CurrentValue;

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

            // tipo_otro
            $this->tipo_otro->ViewValue = $this->tipo_otro->CurrentValue;

            // color
            $this->color->ViewValue = $this->color->CurrentValue;

            // procedencia
            $curVal = strval($this->procedencia->CurrentValue);
            if ($curVal != "") {
                $this->procedencia->ViewValue = $this->procedencia->lookupCacheOption($curVal);
                if ($this->procedencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->procedencia->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->procedencia->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->procedencia->getSelectFilter($this); // PHP
                    $sqlWrk = $this->procedencia->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->procedencia->Lookup->renderViewRow($rswrk[0]);
                        $this->procedencia->ViewValue = $this->procedencia->displayValue($arwrk);
                    } else {
                        $this->procedencia->ViewValue = $this->procedencia->CurrentValue;
                    }
                }
            } else {
                $this->procedencia->ViewValue = null;
            }

            // tarifa
            $curVal = strval($this->tarifa->CurrentValue);
            if ($curVal != "") {
                $this->tarifa->ViewValue = $this->tarifa->lookupCacheOption($curVal);
                if ($this->tarifa->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tarifa->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tarifa->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tarifa->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tarifa->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tarifa->Lookup->renderViewRow($rswrk[0]);
                        $this->tarifa->ViewValue = $this->tarifa->displayValue($arwrk);
                    } else {
                        $this->tarifa->ViewValue = $this->tarifa->CurrentValue;
                    }
                }
            } else {
                $this->tarifa->ViewValue = null;
            }

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // costo
            $this->costo->ViewValue = $this->costo->CurrentValue;
            $this->costo->ViewValue = FormatNumber($this->costo->ViewValue, $this->costo->formatPattern());

            // tasa
            $this->tasa->ViewValue = $this->tasa->CurrentValue;
            $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // fecha_cremacion
            $this->fecha_cremacion->ViewValue = $this->fecha_cremacion->CurrentValue;
            $this->fecha_cremacion->ViewValue = FormatDateTime($this->fecha_cremacion->ViewValue, $this->fecha_cremacion->formatPattern());

            // hora_cremacion
            $this->hora_cremacion->ViewValue = $this->hora_cremacion->CurrentValue;
            $this->hora_cremacion->ViewValue = FormatDateTime($this->hora_cremacion->ViewValue, $this->hora_cremacion->formatPattern());

            // username_registra
            $this->username_registra->ViewValue = $this->username_registra->CurrentValue;

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

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

            // Nmascota
            $this->Nmascota->HrefValue = "";

            // nombre_contratante
            $this->nombre_contratante->HrefValue = "";

            // cedula_contratante
            $this->cedula_contratante->HrefValue = "";

            // direccion_contratante
            $this->direccion_contratante->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // nombre_mascota
            $this->nombre_mascota->HrefValue = "";

            // peso
            $this->peso->HrefValue = "";

            // raza
            $this->raza->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // tipo_otro
            $this->tipo_otro->HrefValue = "";

            // color
            $this->color->HrefValue = "";

            // procedencia
            $this->procedencia->HrefValue = "";

            // tarifa
            $this->tarifa->HrefValue = "";

            // factura
            $this->factura->HrefValue = "";

            // costo
            $this->costo->HrefValue = "";

            // tasa
            $this->tasa->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // fecha_cremacion
            $this->fecha_cremacion->HrefValue = "";

            // hora_cremacion
            $this->hora_cremacion->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nmascota
            $this->Nmascota->setupEditAttributes();
            $this->Nmascota->EditValue = $this->Nmascota->CurrentValue;

            // nombre_contratante
            $this->nombre_contratante->setupEditAttributes();
            if (!$this->nombre_contratante->Raw) {
                $this->nombre_contratante->CurrentValue = HtmlDecode($this->nombre_contratante->CurrentValue);
            }
            $this->nombre_contratante->EditValue = HtmlEncode($this->nombre_contratante->CurrentValue);
            $this->nombre_contratante->PlaceHolder = RemoveHtml($this->nombre_contratante->caption());

            // cedula_contratante
            $this->cedula_contratante->setupEditAttributes();
            if (!$this->cedula_contratante->Raw) {
                $this->cedula_contratante->CurrentValue = HtmlDecode($this->cedula_contratante->CurrentValue);
            }
            $this->cedula_contratante->EditValue = HtmlEncode($this->cedula_contratante->CurrentValue);
            $this->cedula_contratante->PlaceHolder = RemoveHtml($this->cedula_contratante->caption());

            // direccion_contratante
            $this->direccion_contratante->setupEditAttributes();
            $this->direccion_contratante->EditValue = HtmlEncode($this->direccion_contratante->CurrentValue);
            $this->direccion_contratante->PlaceHolder = RemoveHtml($this->direccion_contratante->caption());

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

            // nombre_mascota
            $this->nombre_mascota->setupEditAttributes();
            if (!$this->nombre_mascota->Raw) {
                $this->nombre_mascota->CurrentValue = HtmlDecode($this->nombre_mascota->CurrentValue);
            }
            $this->nombre_mascota->EditValue = HtmlEncode($this->nombre_mascota->CurrentValue);
            $this->nombre_mascota->PlaceHolder = RemoveHtml($this->nombre_mascota->caption());

            // peso
            $this->peso->setupEditAttributes();
            if (!$this->peso->Raw) {
                $this->peso->CurrentValue = HtmlDecode($this->peso->CurrentValue);
            }
            $this->peso->EditValue = HtmlEncode($this->peso->CurrentValue);
            $this->peso->PlaceHolder = RemoveHtml($this->peso->caption());

            // raza
            $this->raza->setupEditAttributes();
            if (!$this->raza->Raw) {
                $this->raza->CurrentValue = HtmlDecode($this->raza->CurrentValue);
            }
            $this->raza->EditValue = HtmlEncode($this->raza->CurrentValue);
            $this->raza->PlaceHolder = RemoveHtml($this->raza->caption());

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

            // tipo_otro
            $this->tipo_otro->setupEditAttributes();
            if (!$this->tipo_otro->Raw) {
                $this->tipo_otro->CurrentValue = HtmlDecode($this->tipo_otro->CurrentValue);
            }
            $this->tipo_otro->EditValue = HtmlEncode($this->tipo_otro->CurrentValue);
            $this->tipo_otro->PlaceHolder = RemoveHtml($this->tipo_otro->caption());

            // color
            $this->color->setupEditAttributes();
            if (!$this->color->Raw) {
                $this->color->CurrentValue = HtmlDecode($this->color->CurrentValue);
            }
            $this->color->EditValue = HtmlEncode($this->color->CurrentValue);
            $this->color->PlaceHolder = RemoveHtml($this->color->caption());

            // procedencia
            $this->procedencia->setupEditAttributes();
            $curVal = trim(strval($this->procedencia->CurrentValue));
            if ($curVal != "") {
                $this->procedencia->ViewValue = $this->procedencia->lookupCacheOption($curVal);
            } else {
                $this->procedencia->ViewValue = $this->procedencia->Lookup !== null && is_array($this->procedencia->lookupOptions()) && count($this->procedencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->procedencia->ViewValue !== null) { // Load from cache
                $this->procedencia->EditValue = array_values($this->procedencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->procedencia->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->procedencia->CurrentValue, $this->procedencia->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->procedencia->getSelectFilter($this); // PHP
                $sqlWrk = $this->procedencia->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->procedencia->EditValue = $arwrk;
            }
            $this->procedencia->PlaceHolder = RemoveHtml($this->procedencia->caption());

            // tarifa
            $this->tarifa->setupEditAttributes();
            $curVal = trim(strval($this->tarifa->CurrentValue));
            if ($curVal != "") {
                $this->tarifa->ViewValue = $this->tarifa->lookupCacheOption($curVal);
            } else {
                $this->tarifa->ViewValue = $this->tarifa->Lookup !== null && is_array($this->tarifa->lookupOptions()) && count($this->tarifa->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tarifa->ViewValue !== null) { // Load from cache
                $this->tarifa->EditValue = array_values($this->tarifa->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tarifa->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->tarifa->CurrentValue, $this->tarifa->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->tarifa->getSelectFilter($this); // PHP
                $sqlWrk = $this->tarifa->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tarifa->EditValue = $arwrk;
            }
            $this->tarifa->PlaceHolder = RemoveHtml($this->tarifa->caption());

            // factura
            $this->factura->setupEditAttributes();
            if (!$this->factura->Raw) {
                $this->factura->CurrentValue = HtmlDecode($this->factura->CurrentValue);
            }
            $this->factura->EditValue = HtmlEncode($this->factura->CurrentValue);
            $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

            // costo
            $this->costo->setupEditAttributes();
            $this->costo->EditValue = $this->costo->CurrentValue;
            $this->costo->PlaceHolder = RemoveHtml($this->costo->caption());
            if (strval($this->costo->EditValue) != "" && is_numeric($this->costo->EditValue)) {
                $this->costo->EditValue = FormatNumber($this->costo->EditValue, null);
            }

            // tasa
            $this->tasa->setupEditAttributes();
            $this->tasa->EditValue = $this->tasa->CurrentValue;
            $this->tasa->PlaceHolder = RemoveHtml($this->tasa->caption());
            if (strval($this->tasa->EditValue) != "" && is_numeric($this->tasa->EditValue)) {
                $this->tasa->EditValue = FormatNumber($this->tasa->EditValue, null);
            }

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // fecha_cremacion
            $this->fecha_cremacion->setupEditAttributes();
            $this->fecha_cremacion->EditValue = HtmlEncode(FormatDateTime($this->fecha_cremacion->CurrentValue, $this->fecha_cremacion->formatPattern()));
            $this->fecha_cremacion->PlaceHolder = RemoveHtml($this->fecha_cremacion->caption());

            // hora_cremacion
            $this->hora_cremacion->setupEditAttributes();
            $this->hora_cremacion->EditValue = HtmlEncode(FormatDateTime($this->hora_cremacion->CurrentValue, $this->hora_cremacion->formatPattern()));
            $this->hora_cremacion->PlaceHolder = RemoveHtml($this->hora_cremacion->caption());

            // Edit refer script

            // Nmascota
            $this->Nmascota->HrefValue = "";

            // nombre_contratante
            $this->nombre_contratante->HrefValue = "";

            // cedula_contratante
            $this->cedula_contratante->HrefValue = "";

            // direccion_contratante
            $this->direccion_contratante->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // nombre_mascota
            $this->nombre_mascota->HrefValue = "";

            // peso
            $this->peso->HrefValue = "";

            // raza
            $this->raza->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // tipo_otro
            $this->tipo_otro->HrefValue = "";

            // color
            $this->color->HrefValue = "";

            // procedencia
            $this->procedencia->HrefValue = "";

            // tarifa
            $this->tarifa->HrefValue = "";

            // factura
            $this->factura->HrefValue = "";

            // costo
            $this->costo->HrefValue = "";

            // tasa
            $this->tasa->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // fecha_cremacion
            $this->fecha_cremacion->HrefValue = "";

            // hora_cremacion
            $this->hora_cremacion->HrefValue = "";
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
            if ($this->Nmascota->Visible && $this->Nmascota->Required) {
                if (!$this->Nmascota->IsDetailKey && EmptyValue($this->Nmascota->FormValue)) {
                    $this->Nmascota->addErrorMessage(str_replace("%s", $this->Nmascota->caption(), $this->Nmascota->RequiredErrorMessage));
                }
            }
            if ($this->nombre_contratante->Visible && $this->nombre_contratante->Required) {
                if (!$this->nombre_contratante->IsDetailKey && EmptyValue($this->nombre_contratante->FormValue)) {
                    $this->nombre_contratante->addErrorMessage(str_replace("%s", $this->nombre_contratante->caption(), $this->nombre_contratante->RequiredErrorMessage));
                }
            }
            if ($this->cedula_contratante->Visible && $this->cedula_contratante->Required) {
                if (!$this->cedula_contratante->IsDetailKey && EmptyValue($this->cedula_contratante->FormValue)) {
                    $this->cedula_contratante->addErrorMessage(str_replace("%s", $this->cedula_contratante->caption(), $this->cedula_contratante->RequiredErrorMessage));
                }
            }
            if ($this->direccion_contratante->Visible && $this->direccion_contratante->Required) {
                if (!$this->direccion_contratante->IsDetailKey && EmptyValue($this->direccion_contratante->FormValue)) {
                    $this->direccion_contratante->addErrorMessage(str_replace("%s", $this->direccion_contratante->caption(), $this->direccion_contratante->RequiredErrorMessage));
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
            if ($this->nombre_mascota->Visible && $this->nombre_mascota->Required) {
                if (!$this->nombre_mascota->IsDetailKey && EmptyValue($this->nombre_mascota->FormValue)) {
                    $this->nombre_mascota->addErrorMessage(str_replace("%s", $this->nombre_mascota->caption(), $this->nombre_mascota->RequiredErrorMessage));
                }
            }
            if ($this->peso->Visible && $this->peso->Required) {
                if (!$this->peso->IsDetailKey && EmptyValue($this->peso->FormValue)) {
                    $this->peso->addErrorMessage(str_replace("%s", $this->peso->caption(), $this->peso->RequiredErrorMessage));
                }
            }
            if ($this->raza->Visible && $this->raza->Required) {
                if (!$this->raza->IsDetailKey && EmptyValue($this->raza->FormValue)) {
                    $this->raza->addErrorMessage(str_replace("%s", $this->raza->caption(), $this->raza->RequiredErrorMessage));
                }
            }
            if ($this->tipo->Visible && $this->tipo->Required) {
                if (!$this->tipo->IsDetailKey && EmptyValue($this->tipo->FormValue)) {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->tipo_otro->Visible && $this->tipo_otro->Required) {
                if (!$this->tipo_otro->IsDetailKey && EmptyValue($this->tipo_otro->FormValue)) {
                    $this->tipo_otro->addErrorMessage(str_replace("%s", $this->tipo_otro->caption(), $this->tipo_otro->RequiredErrorMessage));
                }
            }
            if ($this->color->Visible && $this->color->Required) {
                if (!$this->color->IsDetailKey && EmptyValue($this->color->FormValue)) {
                    $this->color->addErrorMessage(str_replace("%s", $this->color->caption(), $this->color->RequiredErrorMessage));
                }
            }
            if ($this->procedencia->Visible && $this->procedencia->Required) {
                if (!$this->procedencia->IsDetailKey && EmptyValue($this->procedencia->FormValue)) {
                    $this->procedencia->addErrorMessage(str_replace("%s", $this->procedencia->caption(), $this->procedencia->RequiredErrorMessage));
                }
            }
            if ($this->tarifa->Visible && $this->tarifa->Required) {
                if (!$this->tarifa->IsDetailKey && EmptyValue($this->tarifa->FormValue)) {
                    $this->tarifa->addErrorMessage(str_replace("%s", $this->tarifa->caption(), $this->tarifa->RequiredErrorMessage));
                }
            }
            if ($this->factura->Visible && $this->factura->Required) {
                if (!$this->factura->IsDetailKey && EmptyValue($this->factura->FormValue)) {
                    $this->factura->addErrorMessage(str_replace("%s", $this->factura->caption(), $this->factura->RequiredErrorMessage));
                }
            }
            if ($this->costo->Visible && $this->costo->Required) {
                if (!$this->costo->IsDetailKey && EmptyValue($this->costo->FormValue)) {
                    $this->costo->addErrorMessage(str_replace("%s", $this->costo->caption(), $this->costo->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->costo->FormValue)) {
                $this->costo->addErrorMessage($this->costo->getErrorMessage(false));
            }
            if ($this->tasa->Visible && $this->tasa->Required) {
                if (!$this->tasa->IsDetailKey && EmptyValue($this->tasa->FormValue)) {
                    $this->tasa->addErrorMessage(str_replace("%s", $this->tasa->caption(), $this->tasa->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->tasa->FormValue)) {
                $this->tasa->addErrorMessage($this->tasa->getErrorMessage(false));
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->fecha_cremacion->Visible && $this->fecha_cremacion->Required) {
                if (!$this->fecha_cremacion->IsDetailKey && EmptyValue($this->fecha_cremacion->FormValue)) {
                    $this->fecha_cremacion->addErrorMessage(str_replace("%s", $this->fecha_cremacion->caption(), $this->fecha_cremacion->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_cremacion->FormValue, $this->fecha_cremacion->formatPattern())) {
                $this->fecha_cremacion->addErrorMessage($this->fecha_cremacion->getErrorMessage(false));
            }
            if ($this->hora_cremacion->Visible && $this->hora_cremacion->Required) {
                if (!$this->hora_cremacion->IsDetailKey && EmptyValue($this->hora_cremacion->FormValue)) {
                    $this->hora_cremacion->addErrorMessage(str_replace("%s", $this->hora_cremacion->caption(), $this->hora_cremacion->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->hora_cremacion->FormValue, $this->hora_cremacion->formatPattern())) {
                $this->hora_cremacion->addErrorMessage($this->hora_cremacion->getErrorMessage(false));
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoNotaMascotaGrid");
        if (in_array("sco_nota_mascota", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoMascotaEstatusGrid");
        if (in_array("sco_mascota_estatus", $detailTblVar) && $detailPage->DetailEdit) {
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
            $detailPage = Container("ScoNotaMascotaGrid");
            if (in_array("sco_nota_mascota", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_nota_mascota"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }
            $detailPage = Container("ScoMascotaEstatusGrid");
            if (in_array("sco_mascota_estatus", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_mascota_estatus"); // Load user level of detail table
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

        // nombre_contratante
        $this->nombre_contratante->setDbValueDef($rsnew, $this->nombre_contratante->CurrentValue, $this->nombre_contratante->ReadOnly);

        // cedula_contratante
        $this->cedula_contratante->setDbValueDef($rsnew, $this->cedula_contratante->CurrentValue, $this->cedula_contratante->ReadOnly);

        // direccion_contratante
        $this->direccion_contratante->setDbValueDef($rsnew, $this->direccion_contratante->CurrentValue, $this->direccion_contratante->ReadOnly);

        // telefono1
        $this->telefono1->setDbValueDef($rsnew, $this->telefono1->CurrentValue, $this->telefono1->ReadOnly);

        // telefono2
        $this->telefono2->setDbValueDef($rsnew, $this->telefono2->CurrentValue, $this->telefono2->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // nombre_mascota
        $this->nombre_mascota->setDbValueDef($rsnew, $this->nombre_mascota->CurrentValue, $this->nombre_mascota->ReadOnly);

        // peso
        $this->peso->setDbValueDef($rsnew, $this->peso->CurrentValue, $this->peso->ReadOnly);

        // raza
        $this->raza->setDbValueDef($rsnew, $this->raza->CurrentValue, $this->raza->ReadOnly);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, $this->tipo->ReadOnly);

        // tipo_otro
        $this->tipo_otro->setDbValueDef($rsnew, $this->tipo_otro->CurrentValue, $this->tipo_otro->ReadOnly);

        // color
        $this->color->setDbValueDef($rsnew, $this->color->CurrentValue, $this->color->ReadOnly);

        // procedencia
        $this->procedencia->setDbValueDef($rsnew, $this->procedencia->CurrentValue, $this->procedencia->ReadOnly);

        // tarifa
        $this->tarifa->setDbValueDef($rsnew, $this->tarifa->CurrentValue, $this->tarifa->ReadOnly);

        // factura
        $this->factura->setDbValueDef($rsnew, $this->factura->CurrentValue, $this->factura->ReadOnly);

        // costo
        $this->costo->setDbValueDef($rsnew, $this->costo->CurrentValue, $this->costo->ReadOnly);

        // tasa
        $this->tasa->setDbValueDef($rsnew, $this->tasa->CurrentValue, $this->tasa->ReadOnly);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, $this->nota->ReadOnly);

        // fecha_cremacion
        $this->fecha_cremacion->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_cremacion->CurrentValue, $this->fecha_cremacion->formatPattern()), $this->fecha_cremacion->ReadOnly);

        // hora_cremacion
        $this->hora_cremacion->setDbValueDef($rsnew, UnFormatDateTime($this->hora_cremacion->CurrentValue, $this->hora_cremacion->formatPattern()), $this->hora_cremacion->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['nombre_contratante'])) { // nombre_contratante
            $this->nombre_contratante->CurrentValue = $row['nombre_contratante'];
        }
        if (isset($row['cedula_contratante'])) { // cedula_contratante
            $this->cedula_contratante->CurrentValue = $row['cedula_contratante'];
        }
        if (isset($row['direccion_contratante'])) { // direccion_contratante
            $this->direccion_contratante->CurrentValue = $row['direccion_contratante'];
        }
        if (isset($row['telefono1'])) { // telefono1
            $this->telefono1->CurrentValue = $row['telefono1'];
        }
        if (isset($row['telefono2'])) { // telefono2
            $this->telefono2->CurrentValue = $row['telefono2'];
        }
        if (isset($row['email'])) { // email
            $this->_email->CurrentValue = $row['email'];
        }
        if (isset($row['nombre_mascota'])) { // nombre_mascota
            $this->nombre_mascota->CurrentValue = $row['nombre_mascota'];
        }
        if (isset($row['peso'])) { // peso
            $this->peso->CurrentValue = $row['peso'];
        }
        if (isset($row['raza'])) { // raza
            $this->raza->CurrentValue = $row['raza'];
        }
        if (isset($row['tipo'])) { // tipo
            $this->tipo->CurrentValue = $row['tipo'];
        }
        if (isset($row['tipo_otro'])) { // tipo_otro
            $this->tipo_otro->CurrentValue = $row['tipo_otro'];
        }
        if (isset($row['color'])) { // color
            $this->color->CurrentValue = $row['color'];
        }
        if (isset($row['procedencia'])) { // procedencia
            $this->procedencia->CurrentValue = $row['procedencia'];
        }
        if (isset($row['tarifa'])) { // tarifa
            $this->tarifa->CurrentValue = $row['tarifa'];
        }
        if (isset($row['factura'])) { // factura
            $this->factura->CurrentValue = $row['factura'];
        }
        if (isset($row['costo'])) { // costo
            $this->costo->CurrentValue = $row['costo'];
        }
        if (isset($row['tasa'])) { // tasa
            $this->tasa->CurrentValue = $row['tasa'];
        }
        if (isset($row['nota'])) { // nota
            $this->nota->CurrentValue = $row['nota'];
        }
        if (isset($row['fecha_cremacion'])) { // fecha_cremacion
            $this->fecha_cremacion->CurrentValue = $row['fecha_cremacion'];
        }
        if (isset($row['hora_cremacion'])) { // hora_cremacion
            $this->hora_cremacion->CurrentValue = $row['hora_cremacion'];
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
            if (in_array("sco_nota_mascota", $detailTblVar)) {
                $detailPageObj = Container("ScoNotaMascotaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->mascota->IsDetailKey = true;
                    $detailPageObj->mascota->CurrentValue = $this->Nmascota->CurrentValue;
                    $detailPageObj->mascota->setSessionValue($detailPageObj->mascota->CurrentValue);
                }
            }
            if (in_array("sco_mascota_estatus", $detailTblVar)) {
                $detailPageObj = Container("ScoMascotaEstatusGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->mascota->IsDetailKey = true;
                    $detailPageObj->mascota->CurrentValue = $this->Nmascota->CurrentValue;
                    $detailPageObj->mascota->setSessionValue($detailPageObj->mascota->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoMascotaList"), "", $this->TableVar, true);
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
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_procedencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_tarifa":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
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
