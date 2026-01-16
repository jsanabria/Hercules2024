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
class ScoCostosTarifaDetalleEdit extends ScoCostosTarifaDetalle
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoCostosTarifaDetalleEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoCostosTarifaDetalleEdit";

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
        $this->Ncostos_tarifa_detalle->Visible = false;
        $this->costos_tarifa->Visible = false;
        $this->cap->setVisibility();
        $this->ata->setVisibility();
        $this->obi->setVisibility();
        $this->fot->setVisibility();
        $this->man->setVisibility();
        $this->gas->setVisibility();
        $this->com->setVisibility();
        $this->base->setVisibility();
        $this->base_anterior->setVisibility();
        $this->variacion->setVisibility();
        $this->porcentaje->setVisibility();
        $this->fecha->setVisibility();
        $this->cerrado->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_costos_tarifa_detalle';
        $this->TableName = 'sco_costos_tarifa_detalle';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_costos_tarifa_detalle)
        if (!isset($GLOBALS["sco_costos_tarifa_detalle"]) || $GLOBALS["sco_costos_tarifa_detalle"]::class == PROJECT_NAMESPACE . "sco_costos_tarifa_detalle") {
            $GLOBALS["sco_costos_tarifa_detalle"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_costos_tarifa_detalle');
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
                        $result["view"] = SameString($pageName, "ScoCostosTarifaDetalleView"); // If View page, no primary button
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
            $key .= @$ar['Ncostos_tarifa_detalle'];
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
            $this->Ncostos_tarifa_detalle->Visible = false;
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
        $this->setupLookupOptions($this->costos_tarifa);
        $this->setupLookupOptions($this->cap);
        $this->setupLookupOptions($this->ata);
        $this->setupLookupOptions($this->obi);
        $this->setupLookupOptions($this->fot);
        $this->setupLookupOptions($this->man);
        $this->setupLookupOptions($this->gas);
        $this->setupLookupOptions($this->com);
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
            if (($keyValue = Get("Ncostos_tarifa_detalle") ?? Key(0) ?? Route(2)) !== null) {
                $this->Ncostos_tarifa_detalle->setQueryStringValue($keyValue);
                $this->Ncostos_tarifa_detalle->setOldValue($this->Ncostos_tarifa_detalle->QueryStringValue);
            } elseif (Post("Ncostos_tarifa_detalle") !== null) {
                $this->Ncostos_tarifa_detalle->setFormValue(Post("Ncostos_tarifa_detalle"));
                $this->Ncostos_tarifa_detalle->setOldValue($this->Ncostos_tarifa_detalle->FormValue);
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
                if (($keyValue = Get("Ncostos_tarifa_detalle") ?? Route("Ncostos_tarifa_detalle")) !== null) {
                    $this->Ncostos_tarifa_detalle->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Ncostos_tarifa_detalle->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
                    $loadByPosition = true;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load result set
            if ($this->isShow()) {
                if (!$this->IsModal) { // Normal edit page
                    $this->StartRecord = 1; // Initialize start position
                    $this->Recordset = $this->loadRecordset(); // Load records
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("ScoCostosTarifaDetalleList"); // Return to list page
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
                        if ($this->Ncostos_tarifa_detalle->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Ncostos_tarifa_detalle->CurrentValue, $this->CurrentRow['Ncostos_tarifa_detalle'])) {
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
                        $this->terminate("ScoCostosTarifaDetalleList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoCostosTarifaDetalleList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ScoCostosTarifaDetalleList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoCostosTarifaDetalleList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoCostosTarifaDetalleList"; // Return list page content
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

        // Check field name 'cap' first before field var 'x_cap'
        $val = $CurrentForm->hasValue("cap") ? $CurrentForm->getValue("cap") : $CurrentForm->getValue("x_cap");
        if (!$this->cap->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cap->Visible = false; // Disable update for API request
            } else {
                $this->cap->setFormValue($val);
            }
        }

        // Check field name 'ata' first before field var 'x_ata'
        $val = $CurrentForm->hasValue("ata") ? $CurrentForm->getValue("ata") : $CurrentForm->getValue("x_ata");
        if (!$this->ata->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ata->Visible = false; // Disable update for API request
            } else {
                $this->ata->setFormValue($val);
            }
        }

        // Check field name 'obi' first before field var 'x_obi'
        $val = $CurrentForm->hasValue("obi") ? $CurrentForm->getValue("obi") : $CurrentForm->getValue("x_obi");
        if (!$this->obi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->obi->Visible = false; // Disable update for API request
            } else {
                $this->obi->setFormValue($val);
            }
        }

        // Check field name 'fot' first before field var 'x_fot'
        $val = $CurrentForm->hasValue("fot") ? $CurrentForm->getValue("fot") : $CurrentForm->getValue("x_fot");
        if (!$this->fot->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fot->Visible = false; // Disable update for API request
            } else {
                $this->fot->setFormValue($val);
            }
        }

        // Check field name 'man' first before field var 'x_man'
        $val = $CurrentForm->hasValue("man") ? $CurrentForm->getValue("man") : $CurrentForm->getValue("x_man");
        if (!$this->man->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->man->Visible = false; // Disable update for API request
            } else {
                $this->man->setFormValue($val);
            }
        }

        // Check field name 'gas' first before field var 'x_gas'
        $val = $CurrentForm->hasValue("gas") ? $CurrentForm->getValue("gas") : $CurrentForm->getValue("x_gas");
        if (!$this->gas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gas->Visible = false; // Disable update for API request
            } else {
                $this->gas->setFormValue($val);
            }
        }

        // Check field name 'com' first before field var 'x_com'
        $val = $CurrentForm->hasValue("com") ? $CurrentForm->getValue("com") : $CurrentForm->getValue("x_com");
        if (!$this->com->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->com->Visible = false; // Disable update for API request
            } else {
                $this->com->setFormValue($val);
            }
        }

        // Check field name 'base' first before field var 'x_base'
        $val = $CurrentForm->hasValue("base") ? $CurrentForm->getValue("base") : $CurrentForm->getValue("x_base");
        if (!$this->base->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->base->Visible = false; // Disable update for API request
            } else {
                $this->base->setFormValue($val);
            }
        }

        // Check field name 'base_anterior' first before field var 'x_base_anterior'
        $val = $CurrentForm->hasValue("base_anterior") ? $CurrentForm->getValue("base_anterior") : $CurrentForm->getValue("x_base_anterior");
        if (!$this->base_anterior->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->base_anterior->Visible = false; // Disable update for API request
            } else {
                $this->base_anterior->setFormValue($val);
            }
        }

        // Check field name 'variacion' first before field var 'x_variacion'
        $val = $CurrentForm->hasValue("variacion") ? $CurrentForm->getValue("variacion") : $CurrentForm->getValue("x_variacion");
        if (!$this->variacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->variacion->Visible = false; // Disable update for API request
            } else {
                $this->variacion->setFormValue($val);
            }
        }

        // Check field name 'porcentaje' first before field var 'x_porcentaje'
        $val = $CurrentForm->hasValue("porcentaje") ? $CurrentForm->getValue("porcentaje") : $CurrentForm->getValue("x_porcentaje");
        if (!$this->porcentaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->porcentaje->Visible = false; // Disable update for API request
            } else {
                $this->porcentaje->setFormValue($val);
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

        // Check field name 'cerrado' first before field var 'x_cerrado'
        $val = $CurrentForm->hasValue("cerrado") ? $CurrentForm->getValue("cerrado") : $CurrentForm->getValue("x_cerrado");
        if (!$this->cerrado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cerrado->Visible = false; // Disable update for API request
            } else {
                $this->cerrado->setFormValue($val);
            }
        }

        // Check field name 'Ncostos_tarifa_detalle' first before field var 'x_Ncostos_tarifa_detalle'
        $val = $CurrentForm->hasValue("Ncostos_tarifa_detalle") ? $CurrentForm->getValue("Ncostos_tarifa_detalle") : $CurrentForm->getValue("x_Ncostos_tarifa_detalle");
        if (!$this->Ncostos_tarifa_detalle->IsDetailKey) {
            $this->Ncostos_tarifa_detalle->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Ncostos_tarifa_detalle->CurrentValue = $this->Ncostos_tarifa_detalle->FormValue;
        $this->cap->CurrentValue = $this->cap->FormValue;
        $this->ata->CurrentValue = $this->ata->FormValue;
        $this->obi->CurrentValue = $this->obi->FormValue;
        $this->fot->CurrentValue = $this->fot->FormValue;
        $this->man->CurrentValue = $this->man->FormValue;
        $this->gas->CurrentValue = $this->gas->FormValue;
        $this->com->CurrentValue = $this->com->FormValue;
        $this->base->CurrentValue = $this->base->FormValue;
        $this->base_anterior->CurrentValue = $this->base_anterior->FormValue;
        $this->variacion->CurrentValue = $this->variacion->FormValue;
        $this->porcentaje->CurrentValue = $this->porcentaje->FormValue;
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
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
        $this->Ncostos_tarifa_detalle->setDbValue($row['Ncostos_tarifa_detalle']);
        $this->costos_tarifa->setDbValue($row['costos_tarifa']);
        $this->cap->setDbValue($row['cap']);
        $this->ata->setDbValue($row['ata']);
        $this->obi->setDbValue($row['obi']);
        $this->fot->setDbValue($row['fot']);
        $this->man->setDbValue($row['man']);
        $this->gas->setDbValue($row['gas']);
        $this->com->setDbValue($row['com']);
        $this->base->setDbValue($row['base']);
        $this->base_anterior->setDbValue($row['base_anterior']);
        $this->variacion->setDbValue($row['variacion']);
        $this->porcentaje->setDbValue($row['porcentaje']);
        $this->fecha->setDbValue($row['fecha']);
        $this->cerrado->setDbValue($row['cerrado']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ncostos_tarifa_detalle'] = $this->Ncostos_tarifa_detalle->DefaultValue;
        $row['costos_tarifa'] = $this->costos_tarifa->DefaultValue;
        $row['cap'] = $this->cap->DefaultValue;
        $row['ata'] = $this->ata->DefaultValue;
        $row['obi'] = $this->obi->DefaultValue;
        $row['fot'] = $this->fot->DefaultValue;
        $row['man'] = $this->man->DefaultValue;
        $row['gas'] = $this->gas->DefaultValue;
        $row['com'] = $this->com->DefaultValue;
        $row['base'] = $this->base->DefaultValue;
        $row['base_anterior'] = $this->base_anterior->DefaultValue;
        $row['variacion'] = $this->variacion->DefaultValue;
        $row['porcentaje'] = $this->porcentaje->DefaultValue;
        $row['fecha'] = $this->fecha->DefaultValue;
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

        // Ncostos_tarifa_detalle
        $this->Ncostos_tarifa_detalle->RowCssClass = "row";

        // costos_tarifa
        $this->costos_tarifa->RowCssClass = "row";

        // cap
        $this->cap->RowCssClass = "row";

        // ata
        $this->ata->RowCssClass = "row";

        // obi
        $this->obi->RowCssClass = "row";

        // fot
        $this->fot->RowCssClass = "row";

        // man
        $this->man->RowCssClass = "row";

        // gas
        $this->gas->RowCssClass = "row";

        // com
        $this->com->RowCssClass = "row";

        // base
        $this->base->RowCssClass = "row";

        // base_anterior
        $this->base_anterior->RowCssClass = "row";

        // variacion
        $this->variacion->RowCssClass = "row";

        // porcentaje
        $this->porcentaje->RowCssClass = "row";

        // fecha
        $this->fecha->RowCssClass = "row";

        // cerrado
        $this->cerrado->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ncostos_tarifa_detalle
            $this->Ncostos_tarifa_detalle->ViewValue = $this->Ncostos_tarifa_detalle->CurrentValue;

            // costos_tarifa
            $curVal = strval($this->costos_tarifa->CurrentValue);
            if ($curVal != "") {
                $this->costos_tarifa->ViewValue = $this->costos_tarifa->lookupCacheOption($curVal);
                if ($this->costos_tarifa->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchExpression(), "=", $curVal, $this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchDataType(), "");
                    $sqlWrk = $this->costos_tarifa->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_tarifa->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_tarifa->ViewValue = $this->costos_tarifa->displayValue($arwrk);
                    } else {
                        $this->costos_tarifa->ViewValue = $this->costos_tarifa->CurrentValue;
                    }
                }
            } else {
                $this->costos_tarifa->ViewValue = null;
            }

            // cap
            $curVal = strval($this->cap->CurrentValue);
            if ($curVal != "") {
                $this->cap->ViewValue = $this->cap->lookupCacheOption($curVal);
                if ($this->cap->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->cap->getSelectFilter($this); // PHP
                    $sqlWrk = $this->cap->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cap->Lookup->renderViewRow($rswrk[0]);
                        $this->cap->ViewValue = $this->cap->displayValue($arwrk);
                    } else {
                        $this->cap->ViewValue = $this->cap->CurrentValue;
                    }
                }
            } else {
                $this->cap->ViewValue = null;
            }
            $this->cap->CellCssStyle .= "text-align: left;";

            // ata
            $curVal = strval($this->ata->CurrentValue);
            if ($curVal != "") {
                $this->ata->ViewValue = $this->ata->lookupCacheOption($curVal);
                if ($this->ata->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->ata->getSelectFilter($this); // PHP
                    $sqlWrk = $this->ata->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ata->Lookup->renderViewRow($rswrk[0]);
                        $this->ata->ViewValue = $this->ata->displayValue($arwrk);
                    } else {
                        $this->ata->ViewValue = $this->ata->CurrentValue;
                    }
                }
            } else {
                $this->ata->ViewValue = null;
            }
            $this->ata->CellCssStyle .= "text-align: left;";

            // obi
            $curVal = strval($this->obi->CurrentValue);
            if ($curVal != "") {
                $this->obi->ViewValue = $this->obi->lookupCacheOption($curVal);
                if ($this->obi->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->obi->getSelectFilter($this); // PHP
                    $sqlWrk = $this->obi->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->obi->Lookup->renderViewRow($rswrk[0]);
                        $this->obi->ViewValue = $this->obi->displayValue($arwrk);
                    } else {
                        $this->obi->ViewValue = $this->obi->CurrentValue;
                    }
                }
            } else {
                $this->obi->ViewValue = null;
            }
            $this->obi->CellCssStyle .= "text-align: left;";

            // fot
            $curVal = strval($this->fot->CurrentValue);
            if ($curVal != "") {
                $this->fot->ViewValue = $this->fot->lookupCacheOption($curVal);
                if ($this->fot->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->fot->getSelectFilter($this); // PHP
                    $sqlWrk = $this->fot->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->fot->Lookup->renderViewRow($rswrk[0]);
                        $this->fot->ViewValue = $this->fot->displayValue($arwrk);
                    } else {
                        $this->fot->ViewValue = $this->fot->CurrentValue;
                    }
                }
            } else {
                $this->fot->ViewValue = null;
            }
            $this->fot->CellCssStyle .= "text-align: left;";

            // man
            $curVal = strval($this->man->CurrentValue);
            if ($curVal != "") {
                $this->man->ViewValue = $this->man->lookupCacheOption($curVal);
                if ($this->man->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->man->getSelectFilter($this); // PHP
                    $sqlWrk = $this->man->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->man->Lookup->renderViewRow($rswrk[0]);
                        $this->man->ViewValue = $this->man->displayValue($arwrk);
                    } else {
                        $this->man->ViewValue = $this->man->CurrentValue;
                    }
                }
            } else {
                $this->man->ViewValue = null;
            }
            $this->man->CellCssStyle .= "text-align: left;";

            // gas
            $curVal = strval($this->gas->CurrentValue);
            if ($curVal != "") {
                $this->gas->ViewValue = $this->gas->lookupCacheOption($curVal);
                if ($this->gas->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->gas->getSelectFilter($this); // PHP
                    $sqlWrk = $this->gas->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->gas->Lookup->renderViewRow($rswrk[0]);
                        $this->gas->ViewValue = $this->gas->displayValue($arwrk);
                    } else {
                        $this->gas->ViewValue = $this->gas->CurrentValue;
                    }
                }
            } else {
                $this->gas->ViewValue = null;
            }
            $this->gas->CellCssStyle .= "text-align: left;";

            // com
            $curVal = strval($this->com->CurrentValue);
            if ($curVal != "") {
                $this->com->ViewValue = $this->com->lookupCacheOption($curVal);
                if ($this->com->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                    $lookupFilter = $this->com->getSelectFilter($this); // PHP
                    $sqlWrk = $this->com->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->com->Lookup->renderViewRow($rswrk[0]);
                        $this->com->ViewValue = $this->com->displayValue($arwrk);
                    } else {
                        $this->com->ViewValue = $this->com->CurrentValue;
                    }
                }
            } else {
                $this->com->ViewValue = null;
            }
            $this->com->CellCssStyle .= "text-align: left;";

            // base
            $this->base->ViewValue = $this->base->CurrentValue;
            $this->base->ViewValue = FormatNumber($this->base->ViewValue, $this->base->formatPattern());
            $this->base->CssClass = "fw-bold";
            $this->base->CellCssStyle .= "text-align: left;";

            // base_anterior
            $this->base_anterior->ViewValue = $this->base_anterior->CurrentValue;
            $this->base_anterior->ViewValue = FormatNumber($this->base_anterior->ViewValue, $this->base_anterior->formatPattern());
            $this->base_anterior->CellCssStyle .= "text-align: left;";

            // variacion
            $this->variacion->ViewValue = $this->variacion->CurrentValue;
            $this->variacion->ViewValue = FormatNumber($this->variacion->ViewValue, $this->variacion->formatPattern());
            $this->variacion->CellCssStyle .= "text-align: left;";

            // porcentaje
            $this->porcentaje->ViewValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->ViewValue = FormatNumber($this->porcentaje->ViewValue, $this->porcentaje->formatPattern());
            $this->porcentaje->CellCssStyle .= "text-align: left;";

            // fecha
            $this->fecha->ViewValue = $this->fecha->CurrentValue;
            $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

            // cerrado
            if (strval($this->cerrado->CurrentValue) != "") {
                $this->cerrado->ViewValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
            } else {
                $this->cerrado->ViewValue = null;
            }

            // cap
            $this->cap->HrefValue = "";

            // ata
            $this->ata->HrefValue = "";

            // obi
            $this->obi->HrefValue = "";

            // fot
            $this->fot->HrefValue = "";

            // man
            $this->man->HrefValue = "";

            // gas
            $this->gas->HrefValue = "";

            // com
            $this->com->HrefValue = "";

            // base
            $this->base->HrefValue = "";
            $this->base->TooltipValue = "";

            // base_anterior
            $this->base_anterior->HrefValue = "";
            $this->base_anterior->TooltipValue = "";

            // variacion
            $this->variacion->HrefValue = "";
            $this->variacion->TooltipValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";
            $this->porcentaje->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // cap
            $this->cap->setupEditAttributes();
            $curVal = trim(strval($this->cap->CurrentValue));
            if ($curVal != "") {
                $this->cap->ViewValue = $this->cap->lookupCacheOption($curVal);
            } else {
                $this->cap->ViewValue = $this->cap->Lookup !== null && is_array($this->cap->lookupOptions()) && count($this->cap->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->cap->ViewValue !== null) { // Load from cache
                $this->cap->EditValue = array_values($this->cap->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->cap->CurrentValue, $this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->cap->getSelectFilter($this); // PHP
                $sqlWrk = $this->cap->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cap->Lookup->renderViewRow($row);
                }
                $this->cap->EditValue = $arwrk;
            }
            $this->cap->PlaceHolder = RemoveHtml($this->cap->caption());

            // ata
            $this->ata->setupEditAttributes();
            $curVal = trim(strval($this->ata->CurrentValue));
            if ($curVal != "") {
                $this->ata->ViewValue = $this->ata->lookupCacheOption($curVal);
            } else {
                $this->ata->ViewValue = $this->ata->Lookup !== null && is_array($this->ata->lookupOptions()) && count($this->ata->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->ata->ViewValue !== null) { // Load from cache
                $this->ata->EditValue = array_values($this->ata->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->ata->CurrentValue, $this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->ata->getSelectFilter($this); // PHP
                $sqlWrk = $this->ata->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->ata->Lookup->renderViewRow($row);
                }
                $this->ata->EditValue = $arwrk;
            }
            $this->ata->PlaceHolder = RemoveHtml($this->ata->caption());

            // obi
            $this->obi->setupEditAttributes();
            $curVal = trim(strval($this->obi->CurrentValue));
            if ($curVal != "") {
                $this->obi->ViewValue = $this->obi->lookupCacheOption($curVal);
            } else {
                $this->obi->ViewValue = $this->obi->Lookup !== null && is_array($this->obi->lookupOptions()) && count($this->obi->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->obi->ViewValue !== null) { // Load from cache
                $this->obi->EditValue = array_values($this->obi->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->obi->CurrentValue, $this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->obi->getSelectFilter($this); // PHP
                $sqlWrk = $this->obi->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->obi->Lookup->renderViewRow($row);
                }
                $this->obi->EditValue = $arwrk;
            }
            $this->obi->PlaceHolder = RemoveHtml($this->obi->caption());

            // fot
            $this->fot->setupEditAttributes();
            $curVal = trim(strval($this->fot->CurrentValue));
            if ($curVal != "") {
                $this->fot->ViewValue = $this->fot->lookupCacheOption($curVal);
            } else {
                $this->fot->ViewValue = $this->fot->Lookup !== null && is_array($this->fot->lookupOptions()) && count($this->fot->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->fot->ViewValue !== null) { // Load from cache
                $this->fot->EditValue = array_values($this->fot->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->fot->CurrentValue, $this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->fot->getSelectFilter($this); // PHP
                $sqlWrk = $this->fot->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->fot->Lookup->renderViewRow($row);
                }
                $this->fot->EditValue = $arwrk;
            }
            $this->fot->PlaceHolder = RemoveHtml($this->fot->caption());

            // man
            $this->man->setupEditAttributes();
            $curVal = trim(strval($this->man->CurrentValue));
            if ($curVal != "") {
                $this->man->ViewValue = $this->man->lookupCacheOption($curVal);
            } else {
                $this->man->ViewValue = $this->man->Lookup !== null && is_array($this->man->lookupOptions()) && count($this->man->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->man->ViewValue !== null) { // Load from cache
                $this->man->EditValue = array_values($this->man->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->man->CurrentValue, $this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->man->getSelectFilter($this); // PHP
                $sqlWrk = $this->man->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->man->Lookup->renderViewRow($row);
                }
                $this->man->EditValue = $arwrk;
            }
            $this->man->PlaceHolder = RemoveHtml($this->man->caption());

            // gas
            $this->gas->setupEditAttributes();
            $curVal = trim(strval($this->gas->CurrentValue));
            if ($curVal != "") {
                $this->gas->ViewValue = $this->gas->lookupCacheOption($curVal);
            } else {
                $this->gas->ViewValue = $this->gas->Lookup !== null && is_array($this->gas->lookupOptions()) && count($this->gas->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->gas->ViewValue !== null) { // Load from cache
                $this->gas->EditValue = array_values($this->gas->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->gas->CurrentValue, $this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->gas->getSelectFilter($this); // PHP
                $sqlWrk = $this->gas->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->gas->Lookup->renderViewRow($row);
                }
                $this->gas->EditValue = $arwrk;
            }
            $this->gas->PlaceHolder = RemoveHtml($this->gas->caption());

            // com
            $this->com->setupEditAttributes();
            $curVal = trim(strval($this->com->CurrentValue));
            if ($curVal != "") {
                $this->com->ViewValue = $this->com->lookupCacheOption($curVal);
            } else {
                $this->com->ViewValue = $this->com->Lookup !== null && is_array($this->com->lookupOptions()) && count($this->com->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->com->ViewValue !== null) { // Load from cache
                $this->com->EditValue = array_values($this->com->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $this->com->CurrentValue, $this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                }
                $lookupFilter = $this->com->getSelectFilter($this); // PHP
                $sqlWrk = $this->com->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->com->Lookup->renderViewRow($row);
                }
                $this->com->EditValue = $arwrk;
            }
            $this->com->PlaceHolder = RemoveHtml($this->com->caption());

            // base
            $this->base->setupEditAttributes();
            $this->base->EditValue = $this->base->CurrentValue;
            $this->base->EditValue = FormatNumber($this->base->EditValue, $this->base->formatPattern());
            $this->base->CssClass = "fw-bold";
            $this->base->CellCssStyle .= "text-align: left;";

            // base_anterior
            $this->base_anterior->setupEditAttributes();
            $this->base_anterior->EditValue = $this->base_anterior->CurrentValue;
            $this->base_anterior->EditValue = FormatNumber($this->base_anterior->EditValue, $this->base_anterior->formatPattern());
            $this->base_anterior->CellCssStyle .= "text-align: left;";

            // variacion
            $this->variacion->setupEditAttributes();
            $this->variacion->EditValue = $this->variacion->CurrentValue;
            $this->variacion->EditValue = FormatNumber($this->variacion->EditValue, $this->variacion->formatPattern());
            $this->variacion->CellCssStyle .= "text-align: left;";

            // porcentaje
            $this->porcentaje->setupEditAttributes();
            $this->porcentaje->EditValue = $this->porcentaje->CurrentValue;
            $this->porcentaje->EditValue = FormatNumber($this->porcentaje->EditValue, $this->porcentaje->formatPattern());
            $this->porcentaje->CellCssStyle .= "text-align: left;";

            // fecha
            $this->fecha->setupEditAttributes();
            $this->fecha->EditValue = $this->fecha->CurrentValue;
            $this->fecha->EditValue = FormatDateTime($this->fecha->EditValue, $this->fecha->formatPattern());

            // cerrado
            $this->cerrado->setupEditAttributes();
            $this->cerrado->EditValue = $this->cerrado->options(true);
            $this->cerrado->PlaceHolder = RemoveHtml($this->cerrado->caption());

            // Edit refer script

            // cap
            $this->cap->HrefValue = "";

            // ata
            $this->ata->HrefValue = "";

            // obi
            $this->obi->HrefValue = "";

            // fot
            $this->fot->HrefValue = "";

            // man
            $this->man->HrefValue = "";

            // gas
            $this->gas->HrefValue = "";

            // com
            $this->com->HrefValue = "";

            // base
            $this->base->HrefValue = "";
            $this->base->TooltipValue = "";

            // base_anterior
            $this->base_anterior->HrefValue = "";
            $this->base_anterior->TooltipValue = "";

            // variacion
            $this->variacion->HrefValue = "";
            $this->variacion->TooltipValue = "";

            // porcentaje
            $this->porcentaje->HrefValue = "";
            $this->porcentaje->TooltipValue = "";

            // fecha
            $this->fecha->HrefValue = "";
            $this->fecha->TooltipValue = "";

            // cerrado
            $this->cerrado->HrefValue = "";
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
            if ($this->cap->Visible && $this->cap->Required) {
                if (!$this->cap->IsDetailKey && EmptyValue($this->cap->FormValue)) {
                    $this->cap->addErrorMessage(str_replace("%s", $this->cap->caption(), $this->cap->RequiredErrorMessage));
                }
            }
            if ($this->ata->Visible && $this->ata->Required) {
                if (!$this->ata->IsDetailKey && EmptyValue($this->ata->FormValue)) {
                    $this->ata->addErrorMessage(str_replace("%s", $this->ata->caption(), $this->ata->RequiredErrorMessage));
                }
            }
            if ($this->obi->Visible && $this->obi->Required) {
                if (!$this->obi->IsDetailKey && EmptyValue($this->obi->FormValue)) {
                    $this->obi->addErrorMessage(str_replace("%s", $this->obi->caption(), $this->obi->RequiredErrorMessage));
                }
            }
            if ($this->fot->Visible && $this->fot->Required) {
                if (!$this->fot->IsDetailKey && EmptyValue($this->fot->FormValue)) {
                    $this->fot->addErrorMessage(str_replace("%s", $this->fot->caption(), $this->fot->RequiredErrorMessage));
                }
            }
            if ($this->man->Visible && $this->man->Required) {
                if (!$this->man->IsDetailKey && EmptyValue($this->man->FormValue)) {
                    $this->man->addErrorMessage(str_replace("%s", $this->man->caption(), $this->man->RequiredErrorMessage));
                }
            }
            if ($this->gas->Visible && $this->gas->Required) {
                if (!$this->gas->IsDetailKey && EmptyValue($this->gas->FormValue)) {
                    $this->gas->addErrorMessage(str_replace("%s", $this->gas->caption(), $this->gas->RequiredErrorMessage));
                }
            }
            if ($this->com->Visible && $this->com->Required) {
                if (!$this->com->IsDetailKey && EmptyValue($this->com->FormValue)) {
                    $this->com->addErrorMessage(str_replace("%s", $this->com->caption(), $this->com->RequiredErrorMessage));
                }
            }
            if ($this->base->Visible && $this->base->Required) {
                if (!$this->base->IsDetailKey && EmptyValue($this->base->FormValue)) {
                    $this->base->addErrorMessage(str_replace("%s", $this->base->caption(), $this->base->RequiredErrorMessage));
                }
            }
            if ($this->base_anterior->Visible && $this->base_anterior->Required) {
                if (!$this->base_anterior->IsDetailKey && EmptyValue($this->base_anterior->FormValue)) {
                    $this->base_anterior->addErrorMessage(str_replace("%s", $this->base_anterior->caption(), $this->base_anterior->RequiredErrorMessage));
                }
            }
            if ($this->variacion->Visible && $this->variacion->Required) {
                if (!$this->variacion->IsDetailKey && EmptyValue($this->variacion->FormValue)) {
                    $this->variacion->addErrorMessage(str_replace("%s", $this->variacion->caption(), $this->variacion->RequiredErrorMessage));
                }
            }
            if ($this->porcentaje->Visible && $this->porcentaje->Required) {
                if (!$this->porcentaje->IsDetailKey && EmptyValue($this->porcentaje->FormValue)) {
                    $this->porcentaje->addErrorMessage(str_replace("%s", $this->porcentaje->caption(), $this->porcentaje->RequiredErrorMessage));
                }
            }
            if ($this->fecha->Visible && $this->fecha->Required) {
                if (!$this->fecha->IsDetailKey && EmptyValue($this->fecha->FormValue)) {
                    $this->fecha->addErrorMessage(str_replace("%s", $this->fecha->caption(), $this->fecha->RequiredErrorMessage));
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

        // Check referential integrity for master table 'sco_costos_tarifa'
        $detailKeys = [];
        $keyValue = $rsnew['costos_tarifa'] ?? $rsold['costos_tarifa'];
        $detailKeys['costos_tarifa'] = $keyValue;
        $masterTable = Container("sco_costos_tarifa");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "sco_costos_tarifa", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
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

        // cap
        $this->cap->setDbValueDef($rsnew, $this->cap->CurrentValue, $this->cap->ReadOnly);

        // ata
        $this->ata->setDbValueDef($rsnew, $this->ata->CurrentValue, $this->ata->ReadOnly);

        // obi
        $this->obi->setDbValueDef($rsnew, $this->obi->CurrentValue, $this->obi->ReadOnly);

        // fot
        $this->fot->setDbValueDef($rsnew, $this->fot->CurrentValue, $this->fot->ReadOnly);

        // man
        $this->man->setDbValueDef($rsnew, $this->man->CurrentValue, $this->man->ReadOnly);

        // gas
        $this->gas->setDbValueDef($rsnew, $this->gas->CurrentValue, $this->gas->ReadOnly);

        // com
        $this->com->setDbValueDef($rsnew, $this->com->CurrentValue, $this->com->ReadOnly);

        // cerrado
        $this->cerrado->setDbValueDef($rsnew, $this->cerrado->CurrentValue, $this->cerrado->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['cap'])) { // cap
            $this->cap->CurrentValue = $row['cap'];
        }
        if (isset($row['ata'])) { // ata
            $this->ata->CurrentValue = $row['ata'];
        }
        if (isset($row['obi'])) { // obi
            $this->obi->CurrentValue = $row['obi'];
        }
        if (isset($row['fot'])) { // fot
            $this->fot->CurrentValue = $row['fot'];
        }
        if (isset($row['man'])) { // man
            $this->man->CurrentValue = $row['man'];
        }
        if (isset($row['gas'])) { // gas
            $this->gas->CurrentValue = $row['gas'];
        }
        if (isset($row['com'])) { // com
            $this->com->CurrentValue = $row['com'];
        }
        if (isset($row['cerrado'])) { // cerrado
            $this->cerrado->CurrentValue = $row['cerrado'];
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
            if ($masterTblVar == "sco_costos_tarifa") {
                $validMaster = true;
                $masterTbl = Container("sco_costos_tarifa");
                if (($parm = Get("fk_Ncostos_tarifa", Get("costos_tarifa"))) !== null) {
                    $masterTbl->Ncostos_tarifa->setQueryStringValue($parm);
                    $this->costos_tarifa->QueryStringValue = $masterTbl->Ncostos_tarifa->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->costos_tarifa->setSessionValue($this->costos_tarifa->QueryStringValue);
                    $foreignKeys["costos_tarifa"] = $this->costos_tarifa->QueryStringValue;
                    if (!is_numeric($masterTbl->Ncostos_tarifa->QueryStringValue)) {
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
            if ($masterTblVar == "sco_costos_tarifa") {
                $validMaster = true;
                $masterTbl = Container("sco_costos_tarifa");
                if (($parm = Post("fk_Ncostos_tarifa", Post("costos_tarifa"))) !== null) {
                    $masterTbl->Ncostos_tarifa->setFormValue($parm);
                    $this->costos_tarifa->FormValue = $masterTbl->Ncostos_tarifa->FormValue;
                    $this->costos_tarifa->setSessionValue($this->costos_tarifa->FormValue);
                    $foreignKeys["costos_tarifa"] = $this->costos_tarifa->FormValue;
                    if (!is_numeric($masterTbl->Ncostos_tarifa->FormValue)) {
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
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "sco_costos_tarifa") {
                if (!array_key_exists("costos_tarifa", $foreignKeys)) { // Not current foreign key
                    $this->costos_tarifa->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoCostosTarifaDetalleList"), "", $this->TableVar, true);
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
                case "x_costos_tarifa":
                    break;
                case "x_cap":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_ata":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_obi":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_fot":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_man":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_gas":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_com":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
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
    public function pageDataRendering(&$header) {
    	// Example:
    	$sql = "SELECT 
    				c.nombre AS capilla, 
    				s.nombre AS servicio, 
    				t.horas  
    			FROM 
    				sco_costos_tarifa t 
    				JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
    				JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
    			WHERE 
    				t.Ncostos_tarifa = '" . CurrentTable()->costos_tarifa->CurrentValue . "';";
    	$row = ExecuteRow($sql);
    	$header = '<div class="alert alert-info" role="alert">
    				  <span class="glyphicon glyphicon-hand-right"></span>
    				   <strong>Capilla:</strong> ' . $row["capilla"] . ' --
    				   <strong>Servicio:</strong> ' . $row["servicio"] . ' --
    				   <strong>Velaci&oacute;n:</strong> ' . $row["horas"] . '
    				</div>';
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
