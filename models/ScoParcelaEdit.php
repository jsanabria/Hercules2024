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
class ScoParcelaEdit extends ScoParcela
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoParcelaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoParcelaEdit";

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
        $this->Nparcela->setVisibility();
        $this->nacionalidad->setVisibility();
        $this->cedula->setVisibility();
        $this->titular->setVisibility();
        $this->contrato->setVisibility();
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->setVisibility();
        $this->apellido1->setVisibility();
        $this->apellido2->setVisibility();
        $this->nombre1->setVisibility();
        $this->nombre2->setVisibility();
        $this->fecha_inhumacion->setVisibility();
        $this->telefono1->setVisibility();
        $this->telefono2->setVisibility();
        $this->telefono3->setVisibility();
        $this->direc1->setVisibility();
        $this->direc2->setVisibility();
        $this->_email->setVisibility();
        $this->nac_ci_asociado->setVisibility();
        $this->ci_asociado->setVisibility();
        $this->nombre_asociado->setVisibility();
        $this->nac_difunto->setVisibility();
        $this->ci_difunto->setVisibility();
        $this->edad->setVisibility();
        $this->edo_civil->setVisibility();
        $this->fecha_nacimiento->setVisibility();
        $this->lugar->setVisibility();
        $this->fecha_defuncion->setVisibility();
        $this->causa->setVisibility();
        $this->certificado->setVisibility();
        $this->funeraria->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_parcela';
        $this->TableName = 'sco_parcela';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_parcela)
        if (!isset($GLOBALS["sco_parcela"]) || $GLOBALS["sco_parcela"]::class == PROJECT_NAMESPACE . "sco_parcela") {
            $GLOBALS["sco_parcela"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_parcela');
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
                        $result["view"] = SameString($pageName, "ScoParcelaView"); // If View page, no primary button
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
            $key .= @$ar['Nparcela'];
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
            if (($keyValue = Get("Nparcela") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nparcela->setQueryStringValue($keyValue);
                $this->Nparcela->setOldValue($this->Nparcela->QueryStringValue);
            } elseif (Post("Nparcela") !== null) {
                $this->Nparcela->setFormValue(Post("Nparcela"));
                $this->Nparcela->setOldValue($this->Nparcela->FormValue);
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
                if (($keyValue = Get("Nparcela") ?? Route("Nparcela")) !== null) {
                    $this->Nparcela->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nparcela->CurrentValue = null;
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
                        $this->terminate("ScoParcelaList"); // Return to list page
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
                        if ($this->Nparcela->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nparcela->CurrentValue, $this->CurrentRow['Nparcela'])) {
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
                        $this->terminate("ScoParcelaList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoParcelaList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ScoParcelaList") {
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
                        if (GetPageName($returnUrl) != "ScoParcelaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoParcelaList"; // Return list page content
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

        // Check field name 'Nparcela' first before field var 'x_Nparcela'
        $val = $CurrentForm->hasValue("Nparcela") ? $CurrentForm->getValue("Nparcela") : $CurrentForm->getValue("x_Nparcela");
        if (!$this->Nparcela->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nparcela->Visible = false; // Disable update for API request
            } else {
                $this->Nparcela->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_Nparcela")) {
            $this->Nparcela->setOldValue($CurrentForm->getValue("o_Nparcela"));
        }

        // Check field name 'nacionalidad' first before field var 'x_nacionalidad'
        $val = $CurrentForm->hasValue("nacionalidad") ? $CurrentForm->getValue("nacionalidad") : $CurrentForm->getValue("x_nacionalidad");
        if (!$this->nacionalidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nacionalidad->Visible = false; // Disable update for API request
            } else {
                $this->nacionalidad->setFormValue($val);
            }
        }

        // Check field name 'cedula' first before field var 'x_cedula'
        $val = $CurrentForm->hasValue("cedula") ? $CurrentForm->getValue("cedula") : $CurrentForm->getValue("x_cedula");
        if (!$this->cedula->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula->Visible = false; // Disable update for API request
            } else {
                $this->cedula->setFormValue($val);
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

        // Check field name 'fecha_inhumacion' first before field var 'x_fecha_inhumacion'
        $val = $CurrentForm->hasValue("fecha_inhumacion") ? $CurrentForm->getValue("fecha_inhumacion") : $CurrentForm->getValue("x_fecha_inhumacion");
        if (!$this->fecha_inhumacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_inhumacion->Visible = false; // Disable update for API request
            } else {
                $this->fecha_inhumacion->setFormValue($val, true, $validate);
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

        // Check field name 'telefono3' first before field var 'x_telefono3'
        $val = $CurrentForm->hasValue("telefono3") ? $CurrentForm->getValue("telefono3") : $CurrentForm->getValue("x_telefono3");
        if (!$this->telefono3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono3->Visible = false; // Disable update for API request
            } else {
                $this->telefono3->setFormValue($val);
            }
        }

        // Check field name 'direc1' first before field var 'x_direc1'
        $val = $CurrentForm->hasValue("direc1") ? $CurrentForm->getValue("direc1") : $CurrentForm->getValue("x_direc1");
        if (!$this->direc1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direc1->Visible = false; // Disable update for API request
            } else {
                $this->direc1->setFormValue($val);
            }
        }

        // Check field name 'direc2' first before field var 'x_direc2'
        $val = $CurrentForm->hasValue("direc2") ? $CurrentForm->getValue("direc2") : $CurrentForm->getValue("x_direc2");
        if (!$this->direc2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direc2->Visible = false; // Disable update for API request
            } else {
                $this->direc2->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'nac_ci_asociado' first before field var 'x_nac_ci_asociado'
        $val = $CurrentForm->hasValue("nac_ci_asociado") ? $CurrentForm->getValue("nac_ci_asociado") : $CurrentForm->getValue("x_nac_ci_asociado");
        if (!$this->nac_ci_asociado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nac_ci_asociado->Visible = false; // Disable update for API request
            } else {
                $this->nac_ci_asociado->setFormValue($val);
            }
        }

        // Check field name 'ci_asociado' first before field var 'x_ci_asociado'
        $val = $CurrentForm->hasValue("ci_asociado") ? $CurrentForm->getValue("ci_asociado") : $CurrentForm->getValue("x_ci_asociado");
        if (!$this->ci_asociado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_asociado->Visible = false; // Disable update for API request
            } else {
                $this->ci_asociado->setFormValue($val);
            }
        }

        // Check field name 'nombre_asociado' first before field var 'x_nombre_asociado'
        $val = $CurrentForm->hasValue("nombre_asociado") ? $CurrentForm->getValue("nombre_asociado") : $CurrentForm->getValue("x_nombre_asociado");
        if (!$this->nombre_asociado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_asociado->Visible = false; // Disable update for API request
            } else {
                $this->nombre_asociado->setFormValue($val);
            }
        }

        // Check field name 'nac_difunto' first before field var 'x_nac_difunto'
        $val = $CurrentForm->hasValue("nac_difunto") ? $CurrentForm->getValue("nac_difunto") : $CurrentForm->getValue("x_nac_difunto");
        if (!$this->nac_difunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nac_difunto->Visible = false; // Disable update for API request
            } else {
                $this->nac_difunto->setFormValue($val);
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

        // Check field name 'edad' first before field var 'x_edad'
        $val = $CurrentForm->hasValue("edad") ? $CurrentForm->getValue("edad") : $CurrentForm->getValue("x_edad");
        if (!$this->edad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->edad->Visible = false; // Disable update for API request
            } else {
                $this->edad->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'edo_civil' first before field var 'x_edo_civil'
        $val = $CurrentForm->hasValue("edo_civil") ? $CurrentForm->getValue("edo_civil") : $CurrentForm->getValue("x_edo_civil");
        if (!$this->edo_civil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->edo_civil->Visible = false; // Disable update for API request
            } else {
                $this->edo_civil->setFormValue($val);
            }
        }

        // Check field name 'fecha_nacimiento' first before field var 'x_fecha_nacimiento'
        $val = $CurrentForm->hasValue("fecha_nacimiento") ? $CurrentForm->getValue("fecha_nacimiento") : $CurrentForm->getValue("x_fecha_nacimiento");
        if (!$this->fecha_nacimiento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_nacimiento->Visible = false; // Disable update for API request
            } else {
                $this->fecha_nacimiento->setFormValue($val);
            }
        }

        // Check field name 'lugar' first before field var 'x_lugar'
        $val = $CurrentForm->hasValue("lugar") ? $CurrentForm->getValue("lugar") : $CurrentForm->getValue("x_lugar");
        if (!$this->lugar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lugar->Visible = false; // Disable update for API request
            } else {
                $this->lugar->setFormValue($val);
            }
        }

        // Check field name 'fecha_defuncion' first before field var 'x_fecha_defuncion'
        $val = $CurrentForm->hasValue("fecha_defuncion") ? $CurrentForm->getValue("fecha_defuncion") : $CurrentForm->getValue("x_fecha_defuncion");
        if (!$this->fecha_defuncion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_defuncion->Visible = false; // Disable update for API request
            } else {
                $this->fecha_defuncion->setFormValue($val);
            }
        }

        // Check field name 'causa' first before field var 'x_causa'
        $val = $CurrentForm->hasValue("causa") ? $CurrentForm->getValue("causa") : $CurrentForm->getValue("x_causa");
        if (!$this->causa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->causa->Visible = false; // Disable update for API request
            } else {
                $this->causa->setFormValue($val);
            }
        }

        // Check field name 'certificado' first before field var 'x_certificado'
        $val = $CurrentForm->hasValue("certificado") ? $CurrentForm->getValue("certificado") : $CurrentForm->getValue("x_certificado");
        if (!$this->certificado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->certificado->Visible = false; // Disable update for API request
            } else {
                $this->certificado->setFormValue($val);
            }
        }

        // Check field name 'funeraria' first before field var 'x_funeraria'
        $val = $CurrentForm->hasValue("funeraria") ? $CurrentForm->getValue("funeraria") : $CurrentForm->getValue("x_funeraria");
        if (!$this->funeraria->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->funeraria->Visible = false; // Disable update for API request
            } else {
                $this->funeraria->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nparcela->CurrentValue = $this->Nparcela->FormValue;
        $this->nacionalidad->CurrentValue = $this->nacionalidad->FormValue;
        $this->cedula->CurrentValue = $this->cedula->FormValue;
        $this->titular->CurrentValue = $this->titular->FormValue;
        $this->contrato->CurrentValue = $this->contrato->FormValue;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->sub_seccion->CurrentValue = $this->sub_seccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->boveda->CurrentValue = $this->boveda->FormValue;
        $this->apellido1->CurrentValue = $this->apellido1->FormValue;
        $this->apellido2->CurrentValue = $this->apellido2->FormValue;
        $this->nombre1->CurrentValue = $this->nombre1->FormValue;
        $this->nombre2->CurrentValue = $this->nombre2->FormValue;
        $this->fecha_inhumacion->CurrentValue = $this->fecha_inhumacion->FormValue;
        $this->telefono1->CurrentValue = $this->telefono1->FormValue;
        $this->telefono2->CurrentValue = $this->telefono2->FormValue;
        $this->telefono3->CurrentValue = $this->telefono3->FormValue;
        $this->direc1->CurrentValue = $this->direc1->FormValue;
        $this->direc2->CurrentValue = $this->direc2->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->nac_ci_asociado->CurrentValue = $this->nac_ci_asociado->FormValue;
        $this->ci_asociado->CurrentValue = $this->ci_asociado->FormValue;
        $this->nombre_asociado->CurrentValue = $this->nombre_asociado->FormValue;
        $this->nac_difunto->CurrentValue = $this->nac_difunto->FormValue;
        $this->ci_difunto->CurrentValue = $this->ci_difunto->FormValue;
        $this->edad->CurrentValue = $this->edad->FormValue;
        $this->edo_civil->CurrentValue = $this->edo_civil->FormValue;
        $this->fecha_nacimiento->CurrentValue = $this->fecha_nacimiento->FormValue;
        $this->lugar->CurrentValue = $this->lugar->FormValue;
        $this->fecha_defuncion->CurrentValue = $this->fecha_defuncion->FormValue;
        $this->causa->CurrentValue = $this->causa->FormValue;
        $this->certificado->CurrentValue = $this->certificado->FormValue;
        $this->funeraria->CurrentValue = $this->funeraria->FormValue;
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
        $this->Nparcela->setDbValue($row['Nparcela']);
        $this->nacionalidad->setDbValue($row['nacionalidad']);
        $this->cedula->setDbValue($row['cedula']);
        $this->titular->setDbValue($row['titular']);
        $this->contrato->setDbValue($row['contrato']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->apellido1->setDbValue($row['apellido1']);
        $this->apellido2->setDbValue($row['apellido2']);
        $this->nombre1->setDbValue($row['nombre1']);
        $this->nombre2->setDbValue($row['nombre2']);
        $this->fecha_inhumacion->setDbValue($row['fecha_inhumacion']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->telefono3->setDbValue($row['telefono3']);
        $this->direc1->setDbValue($row['direc1']);
        $this->direc2->setDbValue($row['direc2']);
        $this->_email->setDbValue($row['email']);
        $this->nac_ci_asociado->setDbValue($row['nac_ci_asociado']);
        $this->ci_asociado->setDbValue($row['ci_asociado']);
        $this->nombre_asociado->setDbValue($row['nombre_asociado']);
        $this->nac_difunto->setDbValue($row['nac_difunto']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->edad->setDbValue($row['edad']);
        $this->edo_civil->setDbValue($row['edo_civil']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->lugar->setDbValue($row['lugar']);
        $this->fecha_defuncion->setDbValue($row['fecha_defuncion']);
        $this->causa->setDbValue($row['causa']);
        $this->certificado->setDbValue($row['certificado']);
        $this->funeraria->setDbValue($row['funeraria']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nparcela'] = $this->Nparcela->DefaultValue;
        $row['nacionalidad'] = $this->nacionalidad->DefaultValue;
        $row['cedula'] = $this->cedula->DefaultValue;
        $row['titular'] = $this->titular->DefaultValue;
        $row['contrato'] = $this->contrato->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['sub_seccion'] = $this->sub_seccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['boveda'] = $this->boveda->DefaultValue;
        $row['apellido1'] = $this->apellido1->DefaultValue;
        $row['apellido2'] = $this->apellido2->DefaultValue;
        $row['nombre1'] = $this->nombre1->DefaultValue;
        $row['nombre2'] = $this->nombre2->DefaultValue;
        $row['fecha_inhumacion'] = $this->fecha_inhumacion->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['telefono3'] = $this->telefono3->DefaultValue;
        $row['direc1'] = $this->direc1->DefaultValue;
        $row['direc2'] = $this->direc2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['nac_ci_asociado'] = $this->nac_ci_asociado->DefaultValue;
        $row['ci_asociado'] = $this->ci_asociado->DefaultValue;
        $row['nombre_asociado'] = $this->nombre_asociado->DefaultValue;
        $row['nac_difunto'] = $this->nac_difunto->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['edad'] = $this->edad->DefaultValue;
        $row['edo_civil'] = $this->edo_civil->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['lugar'] = $this->lugar->DefaultValue;
        $row['fecha_defuncion'] = $this->fecha_defuncion->DefaultValue;
        $row['causa'] = $this->causa->DefaultValue;
        $row['certificado'] = $this->certificado->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
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

        // Nparcela
        $this->Nparcela->RowCssClass = "row";

        // nacionalidad
        $this->nacionalidad->RowCssClass = "row";

        // cedula
        $this->cedula->RowCssClass = "row";

        // titular
        $this->titular->RowCssClass = "row";

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

        // apellido1
        $this->apellido1->RowCssClass = "row";

        // apellido2
        $this->apellido2->RowCssClass = "row";

        // nombre1
        $this->nombre1->RowCssClass = "row";

        // nombre2
        $this->nombre2->RowCssClass = "row";

        // fecha_inhumacion
        $this->fecha_inhumacion->RowCssClass = "row";

        // telefono1
        $this->telefono1->RowCssClass = "row";

        // telefono2
        $this->telefono2->RowCssClass = "row";

        // telefono3
        $this->telefono3->RowCssClass = "row";

        // direc1
        $this->direc1->RowCssClass = "row";

        // direc2
        $this->direc2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // nac_ci_asociado
        $this->nac_ci_asociado->RowCssClass = "row";

        // ci_asociado
        $this->ci_asociado->RowCssClass = "row";

        // nombre_asociado
        $this->nombre_asociado->RowCssClass = "row";

        // nac_difunto
        $this->nac_difunto->RowCssClass = "row";

        // ci_difunto
        $this->ci_difunto->RowCssClass = "row";

        // edad
        $this->edad->RowCssClass = "row";

        // edo_civil
        $this->edo_civil->RowCssClass = "row";

        // fecha_nacimiento
        $this->fecha_nacimiento->RowCssClass = "row";

        // lugar
        $this->lugar->RowCssClass = "row";

        // fecha_defuncion
        $this->fecha_defuncion->RowCssClass = "row";

        // causa
        $this->causa->RowCssClass = "row";

        // certificado
        $this->certificado->RowCssClass = "row";

        // funeraria
        $this->funeraria->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nparcela
            $this->Nparcela->ViewValue = $this->Nparcela->CurrentValue;

            // nacionalidad
            $this->nacionalidad->ViewValue = $this->nacionalidad->CurrentValue;

            // cedula
            $this->cedula->ViewValue = $this->cedula->CurrentValue;

            // titular
            $this->titular->ViewValue = $this->titular->CurrentValue;

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

            // apellido1
            $this->apellido1->ViewValue = $this->apellido1->CurrentValue;

            // apellido2
            $this->apellido2->ViewValue = $this->apellido2->CurrentValue;

            // nombre1
            $this->nombre1->ViewValue = $this->nombre1->CurrentValue;

            // nombre2
            $this->nombre2->ViewValue = $this->nombre2->CurrentValue;

            // fecha_inhumacion
            $this->fecha_inhumacion->ViewValue = $this->fecha_inhumacion->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // telefono3
            $this->telefono3->ViewValue = $this->telefono3->CurrentValue;

            // direc1
            $this->direc1->ViewValue = $this->direc1->CurrentValue;

            // direc2
            $this->direc2->ViewValue = $this->direc2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // nac_ci_asociado
            $this->nac_ci_asociado->ViewValue = $this->nac_ci_asociado->CurrentValue;

            // ci_asociado
            $this->ci_asociado->ViewValue = $this->ci_asociado->CurrentValue;

            // nombre_asociado
            $this->nombre_asociado->ViewValue = $this->nombre_asociado->CurrentValue;

            // nac_difunto
            $this->nac_difunto->ViewValue = $this->nac_difunto->CurrentValue;

            // ci_difunto
            $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

            // edad
            $this->edad->ViewValue = $this->edad->CurrentValue;

            // edo_civil
            $this->edo_civil->ViewValue = $this->edo_civil->CurrentValue;

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;

            // lugar
            $this->lugar->ViewValue = $this->lugar->CurrentValue;

            // fecha_defuncion
            $this->fecha_defuncion->ViewValue = $this->fecha_defuncion->CurrentValue;

            // causa
            $this->causa->ViewValue = $this->causa->CurrentValue;

            // certificado
            $this->certificado->ViewValue = $this->certificado->CurrentValue;

            // funeraria
            $this->funeraria->ViewValue = $this->funeraria->CurrentValue;

            // Nparcela
            $this->Nparcela->HrefValue = "";

            // nacionalidad
            $this->nacionalidad->HrefValue = "";

            // cedula
            $this->cedula->HrefValue = "";

            // titular
            $this->titular->HrefValue = "";

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

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";

            // fecha_inhumacion
            $this->fecha_inhumacion->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // telefono3
            $this->telefono3->HrefValue = "";

            // direc1
            $this->direc1->HrefValue = "";

            // direc2
            $this->direc2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // nac_ci_asociado
            $this->nac_ci_asociado->HrefValue = "";

            // ci_asociado
            $this->ci_asociado->HrefValue = "";

            // nombre_asociado
            $this->nombre_asociado->HrefValue = "";

            // nac_difunto
            $this->nac_difunto->HrefValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // edad
            $this->edad->HrefValue = "";

            // edo_civil
            $this->edo_civil->HrefValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";

            // lugar
            $this->lugar->HrefValue = "";

            // fecha_defuncion
            $this->fecha_defuncion->HrefValue = "";

            // causa
            $this->causa->HrefValue = "";

            // certificado
            $this->certificado->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nparcela
            $this->Nparcela->setupEditAttributes();
            $this->Nparcela->EditValue = $this->Nparcela->CurrentValue;
            $this->Nparcela->PlaceHolder = RemoveHtml($this->Nparcela->caption());

            // nacionalidad
            $this->nacionalidad->setupEditAttributes();
            if (!$this->nacionalidad->Raw) {
                $this->nacionalidad->CurrentValue = HtmlDecode($this->nacionalidad->CurrentValue);
            }
            $this->nacionalidad->EditValue = HtmlEncode($this->nacionalidad->CurrentValue);
            $this->nacionalidad->PlaceHolder = RemoveHtml($this->nacionalidad->caption());

            // cedula
            $this->cedula->setupEditAttributes();
            if (!$this->cedula->Raw) {
                $this->cedula->CurrentValue = HtmlDecode($this->cedula->CurrentValue);
            }
            $this->cedula->EditValue = HtmlEncode($this->cedula->CurrentValue);
            $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

            // titular
            $this->titular->setupEditAttributes();
            if (!$this->titular->Raw) {
                $this->titular->CurrentValue = HtmlDecode($this->titular->CurrentValue);
            }
            $this->titular->EditValue = HtmlEncode($this->titular->CurrentValue);
            $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

            // contrato
            $this->contrato->setupEditAttributes();
            if ($this->contrato->getSessionValue() != "") {
                $this->contrato->CurrentValue = GetForeignKeyValue($this->contrato->getSessionValue());
                $this->contrato->ViewValue = $this->contrato->CurrentValue;
            } else {
                if (!$this->contrato->Raw) {
                    $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
                }
                $this->contrato->EditValue = HtmlEncode($this->contrato->CurrentValue);
                $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());
            }

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

            // fecha_inhumacion
            $this->fecha_inhumacion->setupEditAttributes();
            if (!$this->fecha_inhumacion->Raw) {
                $this->fecha_inhumacion->CurrentValue = HtmlDecode($this->fecha_inhumacion->CurrentValue);
            }
            $this->fecha_inhumacion->EditValue = HtmlEncode($this->fecha_inhumacion->CurrentValue);
            $this->fecha_inhumacion->PlaceHolder = RemoveHtml($this->fecha_inhumacion->caption());

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

            // telefono3
            $this->telefono3->setupEditAttributes();
            if (!$this->telefono3->Raw) {
                $this->telefono3->CurrentValue = HtmlDecode($this->telefono3->CurrentValue);
            }
            $this->telefono3->EditValue = HtmlEncode($this->telefono3->CurrentValue);
            $this->telefono3->PlaceHolder = RemoveHtml($this->telefono3->caption());

            // direc1
            $this->direc1->setupEditAttributes();
            if (!$this->direc1->Raw) {
                $this->direc1->CurrentValue = HtmlDecode($this->direc1->CurrentValue);
            }
            $this->direc1->EditValue = HtmlEncode($this->direc1->CurrentValue);
            $this->direc1->PlaceHolder = RemoveHtml($this->direc1->caption());

            // direc2
            $this->direc2->setupEditAttributes();
            if (!$this->direc2->Raw) {
                $this->direc2->CurrentValue = HtmlDecode($this->direc2->CurrentValue);
            }
            $this->direc2->EditValue = HtmlEncode($this->direc2->CurrentValue);
            $this->direc2->PlaceHolder = RemoveHtml($this->direc2->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // nac_ci_asociado
            $this->nac_ci_asociado->setupEditAttributes();
            if (!$this->nac_ci_asociado->Raw) {
                $this->nac_ci_asociado->CurrentValue = HtmlDecode($this->nac_ci_asociado->CurrentValue);
            }
            $this->nac_ci_asociado->EditValue = HtmlEncode($this->nac_ci_asociado->CurrentValue);
            $this->nac_ci_asociado->PlaceHolder = RemoveHtml($this->nac_ci_asociado->caption());

            // ci_asociado
            $this->ci_asociado->setupEditAttributes();
            if (!$this->ci_asociado->Raw) {
                $this->ci_asociado->CurrentValue = HtmlDecode($this->ci_asociado->CurrentValue);
            }
            $this->ci_asociado->EditValue = HtmlEncode($this->ci_asociado->CurrentValue);
            $this->ci_asociado->PlaceHolder = RemoveHtml($this->ci_asociado->caption());

            // nombre_asociado
            $this->nombre_asociado->setupEditAttributes();
            if (!$this->nombre_asociado->Raw) {
                $this->nombre_asociado->CurrentValue = HtmlDecode($this->nombre_asociado->CurrentValue);
            }
            $this->nombre_asociado->EditValue = HtmlEncode($this->nombre_asociado->CurrentValue);
            $this->nombre_asociado->PlaceHolder = RemoveHtml($this->nombre_asociado->caption());

            // nac_difunto
            $this->nac_difunto->setupEditAttributes();
            if (!$this->nac_difunto->Raw) {
                $this->nac_difunto->CurrentValue = HtmlDecode($this->nac_difunto->CurrentValue);
            }
            $this->nac_difunto->EditValue = HtmlEncode($this->nac_difunto->CurrentValue);
            $this->nac_difunto->PlaceHolder = RemoveHtml($this->nac_difunto->caption());

            // ci_difunto
            $this->ci_difunto->setupEditAttributes();
            if (!$this->ci_difunto->Raw) {
                $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
            }
            $this->ci_difunto->EditValue = HtmlEncode($this->ci_difunto->CurrentValue);
            $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

            // edad
            $this->edad->setupEditAttributes();
            $this->edad->EditValue = $this->edad->CurrentValue;
            $this->edad->PlaceHolder = RemoveHtml($this->edad->caption());
            if (strval($this->edad->EditValue) != "" && is_numeric($this->edad->EditValue)) {
                $this->edad->EditValue = $this->edad->EditValue;
            }

            // edo_civil
            $this->edo_civil->setupEditAttributes();
            if (!$this->edo_civil->Raw) {
                $this->edo_civil->CurrentValue = HtmlDecode($this->edo_civil->CurrentValue);
            }
            $this->edo_civil->EditValue = HtmlEncode($this->edo_civil->CurrentValue);
            $this->edo_civil->PlaceHolder = RemoveHtml($this->edo_civil->caption());

            // fecha_nacimiento
            $this->fecha_nacimiento->setupEditAttributes();
            if (!$this->fecha_nacimiento->Raw) {
                $this->fecha_nacimiento->CurrentValue = HtmlDecode($this->fecha_nacimiento->CurrentValue);
            }
            $this->fecha_nacimiento->EditValue = HtmlEncode($this->fecha_nacimiento->CurrentValue);
            $this->fecha_nacimiento->PlaceHolder = RemoveHtml($this->fecha_nacimiento->caption());

            // lugar
            $this->lugar->setupEditAttributes();
            if (!$this->lugar->Raw) {
                $this->lugar->CurrentValue = HtmlDecode($this->lugar->CurrentValue);
            }
            $this->lugar->EditValue = HtmlEncode($this->lugar->CurrentValue);
            $this->lugar->PlaceHolder = RemoveHtml($this->lugar->caption());

            // fecha_defuncion
            $this->fecha_defuncion->setupEditAttributes();
            if (!$this->fecha_defuncion->Raw) {
                $this->fecha_defuncion->CurrentValue = HtmlDecode($this->fecha_defuncion->CurrentValue);
            }
            $this->fecha_defuncion->EditValue = HtmlEncode($this->fecha_defuncion->CurrentValue);
            $this->fecha_defuncion->PlaceHolder = RemoveHtml($this->fecha_defuncion->caption());

            // causa
            $this->causa->setupEditAttributes();
            if (!$this->causa->Raw) {
                $this->causa->CurrentValue = HtmlDecode($this->causa->CurrentValue);
            }
            $this->causa->EditValue = HtmlEncode($this->causa->CurrentValue);
            $this->causa->PlaceHolder = RemoveHtml($this->causa->caption());

            // certificado
            $this->certificado->setupEditAttributes();
            if (!$this->certificado->Raw) {
                $this->certificado->CurrentValue = HtmlDecode($this->certificado->CurrentValue);
            }
            $this->certificado->EditValue = HtmlEncode($this->certificado->CurrentValue);
            $this->certificado->PlaceHolder = RemoveHtml($this->certificado->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            if (!$this->funeraria->Raw) {
                $this->funeraria->CurrentValue = HtmlDecode($this->funeraria->CurrentValue);
            }
            $this->funeraria->EditValue = HtmlEncode($this->funeraria->CurrentValue);
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

            // Edit refer script

            // Nparcela
            $this->Nparcela->HrefValue = "";

            // nacionalidad
            $this->nacionalidad->HrefValue = "";

            // cedula
            $this->cedula->HrefValue = "";

            // titular
            $this->titular->HrefValue = "";

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

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";

            // fecha_inhumacion
            $this->fecha_inhumacion->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // telefono3
            $this->telefono3->HrefValue = "";

            // direc1
            $this->direc1->HrefValue = "";

            // direc2
            $this->direc2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // nac_ci_asociado
            $this->nac_ci_asociado->HrefValue = "";

            // ci_asociado
            $this->ci_asociado->HrefValue = "";

            // nombre_asociado
            $this->nombre_asociado->HrefValue = "";

            // nac_difunto
            $this->nac_difunto->HrefValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // edad
            $this->edad->HrefValue = "";

            // edo_civil
            $this->edo_civil->HrefValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";

            // lugar
            $this->lugar->HrefValue = "";

            // fecha_defuncion
            $this->fecha_defuncion->HrefValue = "";

            // causa
            $this->causa->HrefValue = "";

            // certificado
            $this->certificado->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
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
            if ($this->Nparcela->Visible && $this->Nparcela->Required) {
                if (!$this->Nparcela->IsDetailKey && EmptyValue($this->Nparcela->FormValue)) {
                    $this->Nparcela->addErrorMessage(str_replace("%s", $this->Nparcela->caption(), $this->Nparcela->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->Nparcela->FormValue)) {
                $this->Nparcela->addErrorMessage($this->Nparcela->getErrorMessage(false));
            }
            if ($this->nacionalidad->Visible && $this->nacionalidad->Required) {
                if (!$this->nacionalidad->IsDetailKey && EmptyValue($this->nacionalidad->FormValue)) {
                    $this->nacionalidad->addErrorMessage(str_replace("%s", $this->nacionalidad->caption(), $this->nacionalidad->RequiredErrorMessage));
                }
            }
            if ($this->cedula->Visible && $this->cedula->Required) {
                if (!$this->cedula->IsDetailKey && EmptyValue($this->cedula->FormValue)) {
                    $this->cedula->addErrorMessage(str_replace("%s", $this->cedula->caption(), $this->cedula->RequiredErrorMessage));
                }
            }
            if ($this->titular->Visible && $this->titular->Required) {
                if (!$this->titular->IsDetailKey && EmptyValue($this->titular->FormValue)) {
                    $this->titular->addErrorMessage(str_replace("%s", $this->titular->caption(), $this->titular->RequiredErrorMessage));
                }
            }
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
            if ($this->fecha_inhumacion->Visible && $this->fecha_inhumacion->Required) {
                if (!$this->fecha_inhumacion->IsDetailKey && EmptyValue($this->fecha_inhumacion->FormValue)) {
                    $this->fecha_inhumacion->addErrorMessage(str_replace("%s", $this->fecha_inhumacion->caption(), $this->fecha_inhumacion->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_inhumacion->FormValue, $this->fecha_inhumacion->formatPattern())) {
                $this->fecha_inhumacion->addErrorMessage($this->fecha_inhumacion->getErrorMessage(false));
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
            if ($this->telefono3->Visible && $this->telefono3->Required) {
                if (!$this->telefono3->IsDetailKey && EmptyValue($this->telefono3->FormValue)) {
                    $this->telefono3->addErrorMessage(str_replace("%s", $this->telefono3->caption(), $this->telefono3->RequiredErrorMessage));
                }
            }
            if ($this->direc1->Visible && $this->direc1->Required) {
                if (!$this->direc1->IsDetailKey && EmptyValue($this->direc1->FormValue)) {
                    $this->direc1->addErrorMessage(str_replace("%s", $this->direc1->caption(), $this->direc1->RequiredErrorMessage));
                }
            }
            if ($this->direc2->Visible && $this->direc2->Required) {
                if (!$this->direc2->IsDetailKey && EmptyValue($this->direc2->FormValue)) {
                    $this->direc2->addErrorMessage(str_replace("%s", $this->direc2->caption(), $this->direc2->RequiredErrorMessage));
                }
            }
            if ($this->_email->Visible && $this->_email->Required) {
                if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                    $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
                }
            }
            if ($this->nac_ci_asociado->Visible && $this->nac_ci_asociado->Required) {
                if (!$this->nac_ci_asociado->IsDetailKey && EmptyValue($this->nac_ci_asociado->FormValue)) {
                    $this->nac_ci_asociado->addErrorMessage(str_replace("%s", $this->nac_ci_asociado->caption(), $this->nac_ci_asociado->RequiredErrorMessage));
                }
            }
            if ($this->ci_asociado->Visible && $this->ci_asociado->Required) {
                if (!$this->ci_asociado->IsDetailKey && EmptyValue($this->ci_asociado->FormValue)) {
                    $this->ci_asociado->addErrorMessage(str_replace("%s", $this->ci_asociado->caption(), $this->ci_asociado->RequiredErrorMessage));
                }
            }
            if ($this->nombre_asociado->Visible && $this->nombre_asociado->Required) {
                if (!$this->nombre_asociado->IsDetailKey && EmptyValue($this->nombre_asociado->FormValue)) {
                    $this->nombre_asociado->addErrorMessage(str_replace("%s", $this->nombre_asociado->caption(), $this->nombre_asociado->RequiredErrorMessage));
                }
            }
            if ($this->nac_difunto->Visible && $this->nac_difunto->Required) {
                if (!$this->nac_difunto->IsDetailKey && EmptyValue($this->nac_difunto->FormValue)) {
                    $this->nac_difunto->addErrorMessage(str_replace("%s", $this->nac_difunto->caption(), $this->nac_difunto->RequiredErrorMessage));
                }
            }
            if ($this->ci_difunto->Visible && $this->ci_difunto->Required) {
                if (!$this->ci_difunto->IsDetailKey && EmptyValue($this->ci_difunto->FormValue)) {
                    $this->ci_difunto->addErrorMessage(str_replace("%s", $this->ci_difunto->caption(), $this->ci_difunto->RequiredErrorMessage));
                }
            }
            if ($this->edad->Visible && $this->edad->Required) {
                if (!$this->edad->IsDetailKey && EmptyValue($this->edad->FormValue)) {
                    $this->edad->addErrorMessage(str_replace("%s", $this->edad->caption(), $this->edad->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->edad->FormValue)) {
                $this->edad->addErrorMessage($this->edad->getErrorMessage(false));
            }
            if ($this->edo_civil->Visible && $this->edo_civil->Required) {
                if (!$this->edo_civil->IsDetailKey && EmptyValue($this->edo_civil->FormValue)) {
                    $this->edo_civil->addErrorMessage(str_replace("%s", $this->edo_civil->caption(), $this->edo_civil->RequiredErrorMessage));
                }
            }
            if ($this->fecha_nacimiento->Visible && $this->fecha_nacimiento->Required) {
                if (!$this->fecha_nacimiento->IsDetailKey && EmptyValue($this->fecha_nacimiento->FormValue)) {
                    $this->fecha_nacimiento->addErrorMessage(str_replace("%s", $this->fecha_nacimiento->caption(), $this->fecha_nacimiento->RequiredErrorMessage));
                }
            }
            if ($this->lugar->Visible && $this->lugar->Required) {
                if (!$this->lugar->IsDetailKey && EmptyValue($this->lugar->FormValue)) {
                    $this->lugar->addErrorMessage(str_replace("%s", $this->lugar->caption(), $this->lugar->RequiredErrorMessage));
                }
            }
            if ($this->fecha_defuncion->Visible && $this->fecha_defuncion->Required) {
                if (!$this->fecha_defuncion->IsDetailKey && EmptyValue($this->fecha_defuncion->FormValue)) {
                    $this->fecha_defuncion->addErrorMessage(str_replace("%s", $this->fecha_defuncion->caption(), $this->fecha_defuncion->RequiredErrorMessage));
                }
            }
            if ($this->causa->Visible && $this->causa->Required) {
                if (!$this->causa->IsDetailKey && EmptyValue($this->causa->FormValue)) {
                    $this->causa->addErrorMessage(str_replace("%s", $this->causa->caption(), $this->causa->RequiredErrorMessage));
                }
            }
            if ($this->certificado->Visible && $this->certificado->Required) {
                if (!$this->certificado->IsDetailKey && EmptyValue($this->certificado->FormValue)) {
                    $this->certificado->addErrorMessage(str_replace("%s", $this->certificado->caption(), $this->certificado->RequiredErrorMessage));
                }
            }
            if ($this->funeraria->Visible && $this->funeraria->Required) {
                if (!$this->funeraria->IsDetailKey && EmptyValue($this->funeraria->FormValue)) {
                    $this->funeraria->addErrorMessage(str_replace("%s", $this->funeraria->caption(), $this->funeraria->RequiredErrorMessage));
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

        // Check field with unique index (Nparcela)
        if ($this->Nparcela->CurrentValue != "") {
            $filterChk = "(`Nparcela` = " . AdjustSql($this->Nparcela->CurrentValue, $this->Dbid) . ")";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->Nparcela->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Nparcela->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);

        // Check for duplicate key when key changed
        if ($updateRow) {
            $newKeyFilter = $this->getRecordFilter($rsnew);
            if ($newKeyFilter != $oldKeyFilter) {
                $rsChk = $this->loadRs($newKeyFilter)->fetch();
                if ($rsChk !== false) {
                    $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                    $this->setFailureMessage($keyErrMsg);
                    $updateRow = false;
                }
            }
        }
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

        // Nparcela
        $this->Nparcela->setDbValueDef($rsnew, $this->Nparcela->CurrentValue, $this->Nparcela->ReadOnly);

        // nacionalidad
        $this->nacionalidad->setDbValueDef($rsnew, $this->nacionalidad->CurrentValue, $this->nacionalidad->ReadOnly);

        // cedula
        $this->cedula->setDbValueDef($rsnew, $this->cedula->CurrentValue, $this->cedula->ReadOnly);

        // titular
        $this->titular->setDbValueDef($rsnew, $this->titular->CurrentValue, $this->titular->ReadOnly);

        // contrato
        if ($this->contrato->getSessionValue() != "") {
            $this->contrato->ReadOnly = true;
        }
        $this->contrato->setDbValueDef($rsnew, $this->contrato->CurrentValue, $this->contrato->ReadOnly);

        // seccion
        $this->seccion->setDbValueDef($rsnew, $this->seccion->CurrentValue, $this->seccion->ReadOnly);

        // modulo
        $this->modulo->setDbValueDef($rsnew, $this->modulo->CurrentValue, $this->modulo->ReadOnly);

        // sub_seccion
        $this->sub_seccion->setDbValueDef($rsnew, $this->sub_seccion->CurrentValue, $this->sub_seccion->ReadOnly);

        // parcela
        $this->parcela->setDbValueDef($rsnew, $this->parcela->CurrentValue, $this->parcela->ReadOnly);

        // boveda
        $this->boveda->setDbValueDef($rsnew, $this->boveda->CurrentValue, $this->boveda->ReadOnly);

        // apellido1
        $this->apellido1->setDbValueDef($rsnew, $this->apellido1->CurrentValue, $this->apellido1->ReadOnly);

        // apellido2
        $this->apellido2->setDbValueDef($rsnew, $this->apellido2->CurrentValue, $this->apellido2->ReadOnly);

        // nombre1
        $this->nombre1->setDbValueDef($rsnew, $this->nombre1->CurrentValue, $this->nombre1->ReadOnly);

        // nombre2
        $this->nombre2->setDbValueDef($rsnew, $this->nombre2->CurrentValue, $this->nombre2->ReadOnly);

        // fecha_inhumacion
        $this->fecha_inhumacion->setDbValueDef($rsnew, $this->fecha_inhumacion->CurrentValue, $this->fecha_inhumacion->ReadOnly);

        // telefono1
        $this->telefono1->setDbValueDef($rsnew, $this->telefono1->CurrentValue, $this->telefono1->ReadOnly);

        // telefono2
        $this->telefono2->setDbValueDef($rsnew, $this->telefono2->CurrentValue, $this->telefono2->ReadOnly);

        // telefono3
        $this->telefono3->setDbValueDef($rsnew, $this->telefono3->CurrentValue, $this->telefono3->ReadOnly);

        // direc1
        $this->direc1->setDbValueDef($rsnew, $this->direc1->CurrentValue, $this->direc1->ReadOnly);

        // direc2
        $this->direc2->setDbValueDef($rsnew, $this->direc2->CurrentValue, $this->direc2->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // nac_ci_asociado
        $this->nac_ci_asociado->setDbValueDef($rsnew, $this->nac_ci_asociado->CurrentValue, $this->nac_ci_asociado->ReadOnly);

        // ci_asociado
        $this->ci_asociado->setDbValueDef($rsnew, $this->ci_asociado->CurrentValue, $this->ci_asociado->ReadOnly);

        // nombre_asociado
        $this->nombre_asociado->setDbValueDef($rsnew, $this->nombre_asociado->CurrentValue, $this->nombre_asociado->ReadOnly);

        // nac_difunto
        $this->nac_difunto->setDbValueDef($rsnew, $this->nac_difunto->CurrentValue, $this->nac_difunto->ReadOnly);

        // ci_difunto
        $this->ci_difunto->setDbValueDef($rsnew, $this->ci_difunto->CurrentValue, $this->ci_difunto->ReadOnly);

        // edad
        $this->edad->setDbValueDef($rsnew, $this->edad->CurrentValue, $this->edad->ReadOnly);

        // edo_civil
        $this->edo_civil->setDbValueDef($rsnew, $this->edo_civil->CurrentValue, $this->edo_civil->ReadOnly);

        // fecha_nacimiento
        $this->fecha_nacimiento->setDbValueDef($rsnew, $this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->ReadOnly);

        // lugar
        $this->lugar->setDbValueDef($rsnew, $this->lugar->CurrentValue, $this->lugar->ReadOnly);

        // fecha_defuncion
        $this->fecha_defuncion->setDbValueDef($rsnew, $this->fecha_defuncion->CurrentValue, $this->fecha_defuncion->ReadOnly);

        // causa
        $this->causa->setDbValueDef($rsnew, $this->causa->CurrentValue, $this->causa->ReadOnly);

        // certificado
        $this->certificado->setDbValueDef($rsnew, $this->certificado->CurrentValue, $this->certificado->ReadOnly);

        // funeraria
        $this->funeraria->setDbValueDef($rsnew, $this->funeraria->CurrentValue, $this->funeraria->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['Nparcela'])) { // Nparcela
            $this->Nparcela->CurrentValue = $row['Nparcela'];
        }
        if (isset($row['nacionalidad'])) { // nacionalidad
            $this->nacionalidad->CurrentValue = $row['nacionalidad'];
        }
        if (isset($row['cedula'])) { // cedula
            $this->cedula->CurrentValue = $row['cedula'];
        }
        if (isset($row['titular'])) { // titular
            $this->titular->CurrentValue = $row['titular'];
        }
        if (isset($row['contrato'])) { // contrato
            $this->contrato->CurrentValue = $row['contrato'];
        }
        if (isset($row['seccion'])) { // seccion
            $this->seccion->CurrentValue = $row['seccion'];
        }
        if (isset($row['modulo'])) { // modulo
            $this->modulo->CurrentValue = $row['modulo'];
        }
        if (isset($row['sub_seccion'])) { // sub_seccion
            $this->sub_seccion->CurrentValue = $row['sub_seccion'];
        }
        if (isset($row['parcela'])) { // parcela
            $this->parcela->CurrentValue = $row['parcela'];
        }
        if (isset($row['boveda'])) { // boveda
            $this->boveda->CurrentValue = $row['boveda'];
        }
        if (isset($row['apellido1'])) { // apellido1
            $this->apellido1->CurrentValue = $row['apellido1'];
        }
        if (isset($row['apellido2'])) { // apellido2
            $this->apellido2->CurrentValue = $row['apellido2'];
        }
        if (isset($row['nombre1'])) { // nombre1
            $this->nombre1->CurrentValue = $row['nombre1'];
        }
        if (isset($row['nombre2'])) { // nombre2
            $this->nombre2->CurrentValue = $row['nombre2'];
        }
        if (isset($row['fecha_inhumacion'])) { // fecha_inhumacion
            $this->fecha_inhumacion->CurrentValue = $row['fecha_inhumacion'];
        }
        if (isset($row['telefono1'])) { // telefono1
            $this->telefono1->CurrentValue = $row['telefono1'];
        }
        if (isset($row['telefono2'])) { // telefono2
            $this->telefono2->CurrentValue = $row['telefono2'];
        }
        if (isset($row['telefono3'])) { // telefono3
            $this->telefono3->CurrentValue = $row['telefono3'];
        }
        if (isset($row['direc1'])) { // direc1
            $this->direc1->CurrentValue = $row['direc1'];
        }
        if (isset($row['direc2'])) { // direc2
            $this->direc2->CurrentValue = $row['direc2'];
        }
        if (isset($row['email'])) { // email
            $this->_email->CurrentValue = $row['email'];
        }
        if (isset($row['nac_ci_asociado'])) { // nac_ci_asociado
            $this->nac_ci_asociado->CurrentValue = $row['nac_ci_asociado'];
        }
        if (isset($row['ci_asociado'])) { // ci_asociado
            $this->ci_asociado->CurrentValue = $row['ci_asociado'];
        }
        if (isset($row['nombre_asociado'])) { // nombre_asociado
            $this->nombre_asociado->CurrentValue = $row['nombre_asociado'];
        }
        if (isset($row['nac_difunto'])) { // nac_difunto
            $this->nac_difunto->CurrentValue = $row['nac_difunto'];
        }
        if (isset($row['ci_difunto'])) { // ci_difunto
            $this->ci_difunto->CurrentValue = $row['ci_difunto'];
        }
        if (isset($row['edad'])) { // edad
            $this->edad->CurrentValue = $row['edad'];
        }
        if (isset($row['edo_civil'])) { // edo_civil
            $this->edo_civil->CurrentValue = $row['edo_civil'];
        }
        if (isset($row['fecha_nacimiento'])) { // fecha_nacimiento
            $this->fecha_nacimiento->CurrentValue = $row['fecha_nacimiento'];
        }
        if (isset($row['lugar'])) { // lugar
            $this->lugar->CurrentValue = $row['lugar'];
        }
        if (isset($row['fecha_defuncion'])) { // fecha_defuncion
            $this->fecha_defuncion->CurrentValue = $row['fecha_defuncion'];
        }
        if (isset($row['causa'])) { // causa
            $this->causa->CurrentValue = $row['causa'];
        }
        if (isset($row['certificado'])) { // certificado
            $this->certificado->CurrentValue = $row['certificado'];
        }
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->CurrentValue = $row['funeraria'];
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
                if (($parm = Get("fk_contrato_parcela", Get("contrato"))) !== null) {
                    $masterTbl->contrato_parcela->setQueryStringValue($parm);
                    $this->contrato->QueryStringValue = $masterTbl->contrato_parcela->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->contrato->setSessionValue($this->contrato->QueryStringValue);
                    $foreignKeys["contrato"] = $this->contrato->QueryStringValue;
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
                if (($parm = Post("fk_contrato_parcela", Post("contrato"))) !== null) {
                    $masterTbl->contrato_parcela->setFormValue($parm);
                    $this->contrato->FormValue = $masterTbl->contrato_parcela->FormValue;
                    $this->contrato->setSessionValue($this->contrato->FormValue);
                    $foreignKeys["contrato"] = $this->contrato->FormValue;
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
            if ($masterTblVar != "sco_expediente") {
                if (!array_key_exists("contrato", $foreignKeys)) { // Not current foreign key
                    $this->contrato->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoParcelaList"), "", $this->TableVar, true);
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
