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
class ScoGramaEdit extends ScoGrama
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoGramaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoGramaEdit";

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
        $this->Ngrama->setVisibility();
        $this->ci_solicitante->setVisibility();
        $this->solicitante->setVisibility();
        $this->telefono1->setVisibility();
        $this->telefono2->setVisibility();
        $this->_email->setVisibility();
        $this->tipo->setVisibility();
        $this->subtipo->setVisibility();
        $this->monto->setVisibility();
        $this->tasa->setVisibility();
        $this->monto_bs->Visible = false;
        $this->nota->setVisibility();
        $this->contrato->setVisibility();
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->setVisibility();
        $this->ci_difunto->setVisibility();
        $this->apellido1->setVisibility();
        $this->apellido2->setVisibility();
        $this->nombre1->setVisibility();
        $this->nombre2->setVisibility();
        $this->fecha_solucion->setVisibility();
        $this->fecha_desde->setVisibility();
        $this->fecha_hasta->setVisibility();
        $this->estatus->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->usuario_registro->setVisibility();
        $this->email_renovacion->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_grama';
        $this->TableName = 'sco_grama';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_grama)
        if (!isset($GLOBALS["sco_grama"]) || $GLOBALS["sco_grama"]::class == PROJECT_NAMESPACE . "sco_grama") {
            $GLOBALS["sco_grama"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_grama');
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
                        $result["view"] = SameString($pageName, "ScoGramaView"); // If View page, no primary button
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
            $key .= @$ar['Ngrama'];
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
            $this->Ngrama->Visible = false;
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
    public $MultiPages; // Multi pages object

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
        $this->seccion->Required = false;
        $this->modulo->Required = false;
        $this->sub_seccion->Required = false;
        $this->parcela->Required = false;

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Set up multi page object
        $this->setupMultiPages();

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
        $this->setupLookupOptions($this->subtipo);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->email_renovacion);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("Ngrama") ?? Key(0) ?? Route(2)) !== null) {
                $this->Ngrama->setQueryStringValue($keyValue);
                $this->Ngrama->setOldValue($this->Ngrama->QueryStringValue);
            } elseif (Post("Ngrama") !== null) {
                $this->Ngrama->setFormValue(Post("Ngrama"));
                $this->Ngrama->setOldValue($this->Ngrama->FormValue);
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
                if (($keyValue = Get("Ngrama") ?? Route("Ngrama")) !== null) {
                    $this->Ngrama->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Ngrama->CurrentValue = null;
                }
            }

            // Load result set
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
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
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoGramaList"); // No matching record, return to list
                        return;
                    }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                $returnUrl = $this->getViewUrl();
                if (GetPageName($returnUrl) == "ScoGramaList") {
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
                        if (GetPageName($returnUrl) != "ScoGramaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoGramaList"; // Return list page content
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

        // Check field name 'Ngrama' first before field var 'x_Ngrama'
        $val = $CurrentForm->hasValue("Ngrama") ? $CurrentForm->getValue("Ngrama") : $CurrentForm->getValue("x_Ngrama");
        if (!$this->Ngrama->IsDetailKey) {
            $this->Ngrama->setFormValue($val);
        }

        // Check field name 'ci_solicitante' first before field var 'x_ci_solicitante'
        $val = $CurrentForm->hasValue("ci_solicitante") ? $CurrentForm->getValue("ci_solicitante") : $CurrentForm->getValue("x_ci_solicitante");
        if (!$this->ci_solicitante->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_solicitante->Visible = false; // Disable update for API request
            } else {
                $this->ci_solicitante->setFormValue($val);
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

        // Check field name 'tipo' first before field var 'x_tipo'
        $val = $CurrentForm->hasValue("tipo") ? $CurrentForm->getValue("tipo") : $CurrentForm->getValue("x_tipo");
        if (!$this->tipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo->Visible = false; // Disable update for API request
            } else {
                $this->tipo->setFormValue($val);
            }
        }

        // Check field name 'subtipo' first before field var 'x_subtipo'
        $val = $CurrentForm->hasValue("subtipo") ? $CurrentForm->getValue("subtipo") : $CurrentForm->getValue("x_subtipo");
        if (!$this->subtipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subtipo->Visible = false; // Disable update for API request
            } else {
                $this->subtipo->setFormValue($val);
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

        // Check field name 'ci_difunto' first before field var 'x_ci_difunto'
        $val = $CurrentForm->hasValue("ci_difunto") ? $CurrentForm->getValue("ci_difunto") : $CurrentForm->getValue("x_ci_difunto");
        if (!$this->ci_difunto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_difunto->Visible = false; // Disable update for API request
            } else {
                $this->ci_difunto->setFormValue($val);
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

        // Check field name 'fecha_solucion' first before field var 'x_fecha_solucion'
        $val = $CurrentForm->hasValue("fecha_solucion") ? $CurrentForm->getValue("fecha_solucion") : $CurrentForm->getValue("x_fecha_solucion");
        if (!$this->fecha_solucion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_solucion->Visible = false; // Disable update for API request
            } else {
                $this->fecha_solucion->setFormValue($val);
            }
            $this->fecha_solucion->CurrentValue = UnFormatDateTime($this->fecha_solucion->CurrentValue, $this->fecha_solucion->formatPattern());
        }

        // Check field name 'fecha_desde' first before field var 'x_fecha_desde'
        $val = $CurrentForm->hasValue("fecha_desde") ? $CurrentForm->getValue("fecha_desde") : $CurrentForm->getValue("x_fecha_desde");
        if (!$this->fecha_desde->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_desde->Visible = false; // Disable update for API request
            } else {
                $this->fecha_desde->setFormValue($val, true, $validate);
            }
            $this->fecha_desde->CurrentValue = UnFormatDateTime($this->fecha_desde->CurrentValue, $this->fecha_desde->formatPattern());
        }

        // Check field name 'fecha_hasta' first before field var 'x_fecha_hasta'
        $val = $CurrentForm->hasValue("fecha_hasta") ? $CurrentForm->getValue("fecha_hasta") : $CurrentForm->getValue("x_fecha_hasta");
        if (!$this->fecha_hasta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_hasta->Visible = false; // Disable update for API request
            } else {
                $this->fecha_hasta->setFormValue($val, true, $validate);
            }
            $this->fecha_hasta->CurrentValue = UnFormatDateTime($this->fecha_hasta->CurrentValue, $this->fecha_hasta->formatPattern());
        }

        // Check field name 'estatus' first before field var 'x_estatus'
        $val = $CurrentForm->hasValue("estatus") ? $CurrentForm->getValue("estatus") : $CurrentForm->getValue("x_estatus");
        if (!$this->estatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estatus->Visible = false; // Disable update for API request
            } else {
                $this->estatus->setFormValue($val);
            }
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

        // Check field name 'usuario_registro' first before field var 'x_usuario_registro'
        $val = $CurrentForm->hasValue("usuario_registro") ? $CurrentForm->getValue("usuario_registro") : $CurrentForm->getValue("x_usuario_registro");
        if (!$this->usuario_registro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->usuario_registro->Visible = false; // Disable update for API request
            } else {
                $this->usuario_registro->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Ngrama->CurrentValue = $this->Ngrama->FormValue;
        $this->ci_solicitante->CurrentValue = $this->ci_solicitante->FormValue;
        $this->solicitante->CurrentValue = $this->solicitante->FormValue;
        $this->telefono1->CurrentValue = $this->telefono1->FormValue;
        $this->telefono2->CurrentValue = $this->telefono2->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->tipo->CurrentValue = $this->tipo->FormValue;
        $this->subtipo->CurrentValue = $this->subtipo->FormValue;
        $this->monto->CurrentValue = $this->monto->FormValue;
        $this->tasa->CurrentValue = $this->tasa->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->contrato->CurrentValue = $this->contrato->FormValue;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->sub_seccion->CurrentValue = $this->sub_seccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->boveda->CurrentValue = $this->boveda->FormValue;
        $this->ci_difunto->CurrentValue = $this->ci_difunto->FormValue;
        $this->apellido1->CurrentValue = $this->apellido1->FormValue;
        $this->apellido2->CurrentValue = $this->apellido2->FormValue;
        $this->nombre1->CurrentValue = $this->nombre1->FormValue;
        $this->nombre2->CurrentValue = $this->nombre2->FormValue;
        $this->fecha_solucion->CurrentValue = $this->fecha_solucion->FormValue;
        $this->fecha_solucion->CurrentValue = UnFormatDateTime($this->fecha_solucion->CurrentValue, $this->fecha_solucion->formatPattern());
        $this->fecha_desde->CurrentValue = $this->fecha_desde->FormValue;
        $this->fecha_desde->CurrentValue = UnFormatDateTime($this->fecha_desde->CurrentValue, $this->fecha_desde->formatPattern());
        $this->fecha_hasta->CurrentValue = $this->fecha_hasta->FormValue;
        $this->fecha_hasta->CurrentValue = UnFormatDateTime($this->fecha_hasta->CurrentValue, $this->fecha_hasta->formatPattern());
        $this->estatus->CurrentValue = $this->estatus->FormValue;
        $this->fecha_registro->CurrentValue = $this->fecha_registro->FormValue;
        $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->usuario_registro->CurrentValue = $this->usuario_registro->FormValue;
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
        $this->Ngrama->setDbValue($row['Ngrama']);
        $this->ci_solicitante->setDbValue($row['ci_solicitante']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->tipo->setDbValue($row['tipo']);
        $this->subtipo->setDbValue($row['subtipo']);
        $this->monto->setDbValue($row['monto']);
        $this->tasa->setDbValue($row['tasa']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->nota->setDbValue($row['nota']);
        $this->contrato->setDbValue($row['contrato']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->apellido1->setDbValue($row['apellido1']);
        $this->apellido2->setDbValue($row['apellido2']);
        $this->nombre1->setDbValue($row['nombre1']);
        $this->nombre2->setDbValue($row['nombre2']);
        $this->fecha_solucion->setDbValue($row['fecha_solucion']);
        $this->fecha_desde->setDbValue($row['fecha_desde']);
        $this->fecha_hasta->setDbValue($row['fecha_hasta']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->usuario_registro->setDbValue($row['usuario_registro']);
        $this->email_renovacion->setDbValue($row['email_renovacion']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Ngrama'] = $this->Ngrama->DefaultValue;
        $row['ci_solicitante'] = $this->ci_solicitante->DefaultValue;
        $row['solicitante'] = $this->solicitante->DefaultValue;
        $row['telefono1'] = $this->telefono1->DefaultValue;
        $row['telefono2'] = $this->telefono2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['tipo'] = $this->tipo->DefaultValue;
        $row['subtipo'] = $this->subtipo->DefaultValue;
        $row['monto'] = $this->monto->DefaultValue;
        $row['tasa'] = $this->tasa->DefaultValue;
        $row['monto_bs'] = $this->monto_bs->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['contrato'] = $this->contrato->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['sub_seccion'] = $this->sub_seccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['boveda'] = $this->boveda->DefaultValue;
        $row['ci_difunto'] = $this->ci_difunto->DefaultValue;
        $row['apellido1'] = $this->apellido1->DefaultValue;
        $row['apellido2'] = $this->apellido2->DefaultValue;
        $row['nombre1'] = $this->nombre1->DefaultValue;
        $row['nombre2'] = $this->nombre2->DefaultValue;
        $row['fecha_solucion'] = $this->fecha_solucion->DefaultValue;
        $row['fecha_desde'] = $this->fecha_desde->DefaultValue;
        $row['fecha_hasta'] = $this->fecha_hasta->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['usuario_registro'] = $this->usuario_registro->DefaultValue;
        $row['email_renovacion'] = $this->email_renovacion->DefaultValue;
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

        // Ngrama
        $this->Ngrama->RowCssClass = "row";

        // ci_solicitante
        $this->ci_solicitante->RowCssClass = "row";

        // solicitante
        $this->solicitante->RowCssClass = "row";

        // telefono1
        $this->telefono1->RowCssClass = "row";

        // telefono2
        $this->telefono2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // tipo
        $this->tipo->RowCssClass = "row";

        // subtipo
        $this->subtipo->RowCssClass = "row";

        // monto
        $this->monto->RowCssClass = "row";

        // tasa
        $this->tasa->RowCssClass = "row";

        // monto_bs
        $this->monto_bs->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

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

        // ci_difunto
        $this->ci_difunto->RowCssClass = "row";

        // apellido1
        $this->apellido1->RowCssClass = "row";

        // apellido2
        $this->apellido2->RowCssClass = "row";

        // nombre1
        $this->nombre1->RowCssClass = "row";

        // nombre2
        $this->nombre2->RowCssClass = "row";

        // fecha_solucion
        $this->fecha_solucion->RowCssClass = "row";

        // fecha_desde
        $this->fecha_desde->RowCssClass = "row";

        // fecha_hasta
        $this->fecha_hasta->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // usuario_registro
        $this->usuario_registro->RowCssClass = "row";

        // email_renovacion
        $this->email_renovacion->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Ngrama
            $this->Ngrama->ViewValue = $this->Ngrama->CurrentValue;

            // ci_solicitante
            $this->ci_solicitante->ViewValue = $this->ci_solicitante->CurrentValue;

            // solicitante
            $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

            // telefono1
            $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

            // telefono2
            $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

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

            // subtipo
            $curVal = strval($this->subtipo->CurrentValue);
            if ($curVal != "") {
                $this->subtipo->ViewValue = $this->subtipo->lookupCacheOption($curVal);
                if ($this->subtipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->subtipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->subtipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->subtipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->subtipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->subtipo->Lookup->renderViewRow($rswrk[0]);
                        $this->subtipo->ViewValue = $this->subtipo->displayValue($arwrk);
                    } else {
                        $this->subtipo->ViewValue = $this->subtipo->CurrentValue;
                    }
                }
            } else {
                $this->subtipo->ViewValue = null;
            }

            // monto
            $this->monto->ViewValue = $this->monto->CurrentValue;
            $this->monto->ViewValue = FormatNumber($this->monto->ViewValue, $this->monto->formatPattern());

            // tasa
            $this->tasa->ViewValue = $this->tasa->CurrentValue;
            $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

            // monto_bs
            $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
            $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

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

            // ci_difunto
            $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

            // apellido1
            $this->apellido1->ViewValue = $this->apellido1->CurrentValue;

            // apellido2
            $this->apellido2->ViewValue = $this->apellido2->CurrentValue;

            // nombre1
            $this->nombre1->ViewValue = $this->nombre1->CurrentValue;

            // nombre2
            $this->nombre2->ViewValue = $this->nombre2->CurrentValue;

            // fecha_solucion
            $this->fecha_solucion->ViewValue = $this->fecha_solucion->CurrentValue;
            $this->fecha_solucion->ViewValue = FormatDateTime($this->fecha_solucion->ViewValue, $this->fecha_solucion->formatPattern());

            // fecha_desde
            $this->fecha_desde->ViewValue = $this->fecha_desde->CurrentValue;
            $this->fecha_desde->ViewValue = FormatDateTime($this->fecha_desde->ViewValue, $this->fecha_desde->formatPattern());

            // fecha_hasta
            $this->fecha_hasta->ViewValue = $this->fecha_hasta->CurrentValue;
            $this->fecha_hasta->ViewValue = FormatDateTime($this->fecha_hasta->ViewValue, $this->fecha_hasta->formatPattern());

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

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // usuario_registro
            $this->usuario_registro->ViewValue = $this->usuario_registro->CurrentValue;

            // email_renovacion
            if (strval($this->email_renovacion->CurrentValue) != "") {
                $this->email_renovacion->ViewValue = $this->email_renovacion->optionCaption($this->email_renovacion->CurrentValue);
            } else {
                $this->email_renovacion->ViewValue = null;
            }

            // Ngrama
            $this->Ngrama->HrefValue = "";

            // ci_solicitante
            $this->ci_solicitante->HrefValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // subtipo
            $this->subtipo->HrefValue = "";

            // monto
            $this->monto->HrefValue = "";

            // tasa
            $this->tasa->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // contrato
            $this->contrato->HrefValue = "";
            $this->contrato->TooltipValue = "";

            // seccion
            $this->seccion->HrefValue = "";
            $this->seccion->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // sub_seccion
            $this->sub_seccion->HrefValue = "";
            $this->sub_seccion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";

            // boveda
            $this->boveda->HrefValue = "";
            $this->boveda->TooltipValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";

            // fecha_solucion
            $this->fecha_solucion->HrefValue = "";
            $this->fecha_solucion->TooltipValue = "";

            // fecha_desde
            $this->fecha_desde->HrefValue = "";

            // fecha_hasta
            $this->fecha_hasta->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // usuario_registro
            $this->usuario_registro->HrefValue = "";
            $this->usuario_registro->TooltipValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Ngrama
            $this->Ngrama->setupEditAttributes();
            $this->Ngrama->EditValue = $this->Ngrama->CurrentValue;

            // ci_solicitante
            $this->ci_solicitante->setupEditAttributes();
            if (!$this->ci_solicitante->Raw) {
                $this->ci_solicitante->CurrentValue = HtmlDecode($this->ci_solicitante->CurrentValue);
            }
            $this->ci_solicitante->EditValue = HtmlEncode($this->ci_solicitante->CurrentValue);
            $this->ci_solicitante->PlaceHolder = RemoveHtml($this->ci_solicitante->caption());

            // solicitante
            $this->solicitante->setupEditAttributes();
            if (!$this->solicitante->Raw) {
                $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
            }
            $this->solicitante->EditValue = HtmlEncode($this->solicitante->CurrentValue);
            $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

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

            // subtipo
            $this->subtipo->setupEditAttributes();
            $curVal = trim(strval($this->subtipo->CurrentValue));
            if ($curVal != "") {
                $this->subtipo->ViewValue = $this->subtipo->lookupCacheOption($curVal);
            } else {
                $this->subtipo->ViewValue = $this->subtipo->Lookup !== null && is_array($this->subtipo->lookupOptions()) && count($this->subtipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->subtipo->ViewValue !== null) { // Load from cache
                $this->subtipo->EditValue = array_values($this->subtipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->subtipo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->subtipo->CurrentValue, $this->subtipo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->subtipo->getSelectFilter($this); // PHP
                $sqlWrk = $this->subtipo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->subtipo->EditValue = $arwrk;
            }
            $this->subtipo->PlaceHolder = RemoveHtml($this->subtipo->caption());

            // monto
            $this->monto->setupEditAttributes();
            $this->monto->EditValue = $this->monto->CurrentValue;
            $this->monto->PlaceHolder = RemoveHtml($this->monto->caption());
            if (strval($this->monto->EditValue) != "" && is_numeric($this->monto->EditValue)) {
                $this->monto->EditValue = FormatNumber($this->monto->EditValue, null);
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

            // contrato
            $this->contrato->setupEditAttributes();
            $this->contrato->EditValue = $this->contrato->CurrentValue;

            // seccion
            $this->seccion->setupEditAttributes();
            $this->seccion->EditValue = $this->seccion->CurrentValue;

            // modulo
            $this->modulo->setupEditAttributes();
            $this->modulo->EditValue = $this->modulo->CurrentValue;

            // sub_seccion
            $this->sub_seccion->setupEditAttributes();
            $this->sub_seccion->EditValue = $this->sub_seccion->CurrentValue;

            // parcela
            $this->parcela->setupEditAttributes();
            $this->parcela->EditValue = $this->parcela->CurrentValue;

            // boveda
            $this->boveda->setupEditAttributes();
            $this->boveda->EditValue = $this->boveda->CurrentValue;

            // ci_difunto
            $this->ci_difunto->setupEditAttributes();
            if (!$this->ci_difunto->Raw) {
                $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
            }
            $this->ci_difunto->EditValue = HtmlEncode($this->ci_difunto->CurrentValue);
            $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

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

            // fecha_solucion
            $this->fecha_solucion->setupEditAttributes();
            $this->fecha_solucion->EditValue = $this->fecha_solucion->CurrentValue;
            $this->fecha_solucion->EditValue = FormatDateTime($this->fecha_solucion->EditValue, $this->fecha_solucion->formatPattern());

            // fecha_desde
            $this->fecha_desde->setupEditAttributes();
            $this->fecha_desde->EditValue = HtmlEncode(FormatDateTime($this->fecha_desde->CurrentValue, $this->fecha_desde->formatPattern()));
            $this->fecha_desde->PlaceHolder = RemoveHtml($this->fecha_desde->caption());

            // fecha_hasta
            $this->fecha_hasta->setupEditAttributes();
            $this->fecha_hasta->EditValue = HtmlEncode(FormatDateTime($this->fecha_hasta->CurrentValue, $this->fecha_hasta->formatPattern()));
            $this->fecha_hasta->PlaceHolder = RemoveHtml($this->fecha_hasta->caption());

            // estatus
            $this->estatus->setupEditAttributes();
            $curVal = trim(strval($this->estatus->CurrentValue));
            if ($curVal != "") {
                $this->estatus->ViewValue = $this->estatus->lookupCacheOption($curVal);
            } else {
                $this->estatus->ViewValue = $this->estatus->Lookup !== null && is_array($this->estatus->lookupOptions()) && count($this->estatus->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->estatus->ViewValue !== null) { // Load from cache
                $this->estatus->EditValue = array_values($this->estatus->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->estatus->CurrentValue, $this->estatus->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->estatus->getSelectFilter($this); // PHP
                $sqlWrk = $this->estatus->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->estatus->EditValue = $arwrk;
            }
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->EditValue, $this->fecha_registro->formatPattern());

            // usuario_registro
            $this->usuario_registro->setupEditAttributes();
            $this->usuario_registro->EditValue = $this->usuario_registro->CurrentValue;

            // Edit refer script

            // Ngrama
            $this->Ngrama->HrefValue = "";

            // ci_solicitante
            $this->ci_solicitante->HrefValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";

            // telefono1
            $this->telefono1->HrefValue = "";

            // telefono2
            $this->telefono2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // tipo
            $this->tipo->HrefValue = "";

            // subtipo
            $this->subtipo->HrefValue = "";

            // monto
            $this->monto->HrefValue = "";

            // tasa
            $this->tasa->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // contrato
            $this->contrato->HrefValue = "";
            $this->contrato->TooltipValue = "";

            // seccion
            $this->seccion->HrefValue = "";
            $this->seccion->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // sub_seccion
            $this->sub_seccion->HrefValue = "";
            $this->sub_seccion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";

            // boveda
            $this->boveda->HrefValue = "";
            $this->boveda->TooltipValue = "";

            // ci_difunto
            $this->ci_difunto->HrefValue = "";

            // apellido1
            $this->apellido1->HrefValue = "";

            // apellido2
            $this->apellido2->HrefValue = "";

            // nombre1
            $this->nombre1->HrefValue = "";

            // nombre2
            $this->nombre2->HrefValue = "";

            // fecha_solucion
            $this->fecha_solucion->HrefValue = "";
            $this->fecha_solucion->TooltipValue = "";

            // fecha_desde
            $this->fecha_desde->HrefValue = "";

            // fecha_hasta
            $this->fecha_hasta->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // usuario_registro
            $this->usuario_registro->HrefValue = "";
            $this->usuario_registro->TooltipValue = "";
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
            if ($this->Ngrama->Visible && $this->Ngrama->Required) {
                if (!$this->Ngrama->IsDetailKey && EmptyValue($this->Ngrama->FormValue)) {
                    $this->Ngrama->addErrorMessage(str_replace("%s", $this->Ngrama->caption(), $this->Ngrama->RequiredErrorMessage));
                }
            }
            if ($this->ci_solicitante->Visible && $this->ci_solicitante->Required) {
                if (!$this->ci_solicitante->IsDetailKey && EmptyValue($this->ci_solicitante->FormValue)) {
                    $this->ci_solicitante->addErrorMessage(str_replace("%s", $this->ci_solicitante->caption(), $this->ci_solicitante->RequiredErrorMessage));
                }
            }
            if ($this->solicitante->Visible && $this->solicitante->Required) {
                if (!$this->solicitante->IsDetailKey && EmptyValue($this->solicitante->FormValue)) {
                    $this->solicitante->addErrorMessage(str_replace("%s", $this->solicitante->caption(), $this->solicitante->RequiredErrorMessage));
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
            if ($this->tipo->Visible && $this->tipo->Required) {
                if (!$this->tipo->IsDetailKey && EmptyValue($this->tipo->FormValue)) {
                    $this->tipo->addErrorMessage(str_replace("%s", $this->tipo->caption(), $this->tipo->RequiredErrorMessage));
                }
            }
            if ($this->subtipo->Visible && $this->subtipo->Required) {
                if (!$this->subtipo->IsDetailKey && EmptyValue($this->subtipo->FormValue)) {
                    $this->subtipo->addErrorMessage(str_replace("%s", $this->subtipo->caption(), $this->subtipo->RequiredErrorMessage));
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
            if ($this->ci_difunto->Visible && $this->ci_difunto->Required) {
                if (!$this->ci_difunto->IsDetailKey && EmptyValue($this->ci_difunto->FormValue)) {
                    $this->ci_difunto->addErrorMessage(str_replace("%s", $this->ci_difunto->caption(), $this->ci_difunto->RequiredErrorMessage));
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
            if ($this->fecha_solucion->Visible && $this->fecha_solucion->Required) {
                if (!$this->fecha_solucion->IsDetailKey && EmptyValue($this->fecha_solucion->FormValue)) {
                    $this->fecha_solucion->addErrorMessage(str_replace("%s", $this->fecha_solucion->caption(), $this->fecha_solucion->RequiredErrorMessage));
                }
            }
            if ($this->fecha_desde->Visible && $this->fecha_desde->Required) {
                if (!$this->fecha_desde->IsDetailKey && EmptyValue($this->fecha_desde->FormValue)) {
                    $this->fecha_desde->addErrorMessage(str_replace("%s", $this->fecha_desde->caption(), $this->fecha_desde->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_desde->FormValue, $this->fecha_desde->formatPattern())) {
                $this->fecha_desde->addErrorMessage($this->fecha_desde->getErrorMessage(false));
            }
            if ($this->fecha_hasta->Visible && $this->fecha_hasta->Required) {
                if (!$this->fecha_hasta->IsDetailKey && EmptyValue($this->fecha_hasta->FormValue)) {
                    $this->fecha_hasta->addErrorMessage(str_replace("%s", $this->fecha_hasta->caption(), $this->fecha_hasta->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_hasta->FormValue, $this->fecha_hasta->formatPattern())) {
                $this->fecha_hasta->addErrorMessage($this->fecha_hasta->getErrorMessage(false));
            }
            if ($this->estatus->Visible && $this->estatus->Required) {
                if (!$this->estatus->IsDetailKey && EmptyValue($this->estatus->FormValue)) {
                    $this->estatus->addErrorMessage(str_replace("%s", $this->estatus->caption(), $this->estatus->RequiredErrorMessage));
                }
            }
            if ($this->fecha_registro->Visible && $this->fecha_registro->Required) {
                if (!$this->fecha_registro->IsDetailKey && EmptyValue($this->fecha_registro->FormValue)) {
                    $this->fecha_registro->addErrorMessage(str_replace("%s", $this->fecha_registro->caption(), $this->fecha_registro->RequiredErrorMessage));
                }
            }
            if ($this->usuario_registro->Visible && $this->usuario_registro->Required) {
                if (!$this->usuario_registro->IsDetailKey && EmptyValue($this->usuario_registro->FormValue)) {
                    $this->usuario_registro->addErrorMessage(str_replace("%s", $this->usuario_registro->caption(), $this->usuario_registro->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoGramaPagosGrid");
        if (in_array("sco_grama_pagos", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoGramaNotaGrid");
        if (in_array("sco_grama_nota", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoGramaAdjuntoGrid");
        if (in_array("sco_grama_adjunto", $detailTblVar) && $detailPage->DetailEdit) {
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
            $detailPage = Container("ScoGramaPagosGrid");
            if (in_array("sco_grama_pagos", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_grama_pagos"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }
            $detailPage = Container("ScoGramaNotaGrid");
            if (in_array("sco_grama_nota", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_grama_nota"); // Load user level of detail table
                $editRow = $detailPage->gridUpdate();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
            }
            $detailPage = Container("ScoGramaAdjuntoGrid");
            if (in_array("sco_grama_adjunto", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_grama_adjunto"); // Load user level of detail table
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

        // ci_solicitante
        $this->ci_solicitante->setDbValueDef($rsnew, $this->ci_solicitante->CurrentValue, $this->ci_solicitante->ReadOnly);

        // solicitante
        $this->solicitante->setDbValueDef($rsnew, $this->solicitante->CurrentValue, $this->solicitante->ReadOnly);

        // telefono1
        $this->telefono1->setDbValueDef($rsnew, $this->telefono1->CurrentValue, $this->telefono1->ReadOnly);

        // telefono2
        $this->telefono2->setDbValueDef($rsnew, $this->telefono2->CurrentValue, $this->telefono2->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // tipo
        $this->tipo->setDbValueDef($rsnew, $this->tipo->CurrentValue, $this->tipo->ReadOnly);

        // subtipo
        $this->subtipo->setDbValueDef($rsnew, $this->subtipo->CurrentValue, $this->subtipo->ReadOnly);

        // monto
        $this->monto->setDbValueDef($rsnew, $this->monto->CurrentValue, $this->monto->ReadOnly);

        // tasa
        $this->tasa->setDbValueDef($rsnew, $this->tasa->CurrentValue, $this->tasa->ReadOnly);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, $this->nota->ReadOnly);

        // ci_difunto
        $this->ci_difunto->setDbValueDef($rsnew, $this->ci_difunto->CurrentValue, $this->ci_difunto->ReadOnly);

        // apellido1
        $this->apellido1->setDbValueDef($rsnew, $this->apellido1->CurrentValue, $this->apellido1->ReadOnly);

        // apellido2
        $this->apellido2->setDbValueDef($rsnew, $this->apellido2->CurrentValue, $this->apellido2->ReadOnly);

        // nombre1
        $this->nombre1->setDbValueDef($rsnew, $this->nombre1->CurrentValue, $this->nombre1->ReadOnly);

        // nombre2
        $this->nombre2->setDbValueDef($rsnew, $this->nombre2->CurrentValue, $this->nombre2->ReadOnly);

        // fecha_desde
        $this->fecha_desde->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_desde->CurrentValue, $this->fecha_desde->formatPattern()), $this->fecha_desde->ReadOnly);

        // fecha_hasta
        $this->fecha_hasta->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_hasta->CurrentValue, $this->fecha_hasta->formatPattern()), $this->fecha_hasta->ReadOnly);

        // estatus
        $this->estatus->setDbValueDef($rsnew, $this->estatus->CurrentValue, $this->estatus->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['ci_solicitante'])) { // ci_solicitante
            $this->ci_solicitante->CurrentValue = $row['ci_solicitante'];
        }
        if (isset($row['solicitante'])) { // solicitante
            $this->solicitante->CurrentValue = $row['solicitante'];
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
        if (isset($row['tipo'])) { // tipo
            $this->tipo->CurrentValue = $row['tipo'];
        }
        if (isset($row['subtipo'])) { // subtipo
            $this->subtipo->CurrentValue = $row['subtipo'];
        }
        if (isset($row['monto'])) { // monto
            $this->monto->CurrentValue = $row['monto'];
        }
        if (isset($row['tasa'])) { // tasa
            $this->tasa->CurrentValue = $row['tasa'];
        }
        if (isset($row['nota'])) { // nota
            $this->nota->CurrentValue = $row['nota'];
        }
        if (isset($row['ci_difunto'])) { // ci_difunto
            $this->ci_difunto->CurrentValue = $row['ci_difunto'];
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
        if (isset($row['fecha_desde'])) { // fecha_desde
            $this->fecha_desde->CurrentValue = $row['fecha_desde'];
        }
        if (isset($row['fecha_hasta'])) { // fecha_hasta
            $this->fecha_hasta->CurrentValue = $row['fecha_hasta'];
        }
        if (isset($row['estatus'])) { // estatus
            $this->estatus->CurrentValue = $row['estatus'];
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
            if (in_array("sco_grama_pagos", $detailTblVar)) {
                $detailPageObj = Container("ScoGramaPagosGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->grama->IsDetailKey = true;
                    $detailPageObj->grama->CurrentValue = $this->Ngrama->CurrentValue;
                    $detailPageObj->grama->setSessionValue($detailPageObj->grama->CurrentValue);
                }
            }
            if (in_array("sco_grama_nota", $detailTblVar)) {
                $detailPageObj = Container("ScoGramaNotaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->grama->IsDetailKey = true;
                    $detailPageObj->grama->CurrentValue = $this->Ngrama->CurrentValue;
                    $detailPageObj->grama->setSessionValue($detailPageObj->grama->CurrentValue);
                }
            }
            if (in_array("sco_grama_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoGramaAdjuntoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->grama->IsDetailKey = true;
                    $detailPageObj->grama->CurrentValue = $this->Ngrama->CurrentValue;
                    $detailPageObj->grama->setSessionValue($detailPageObj->grama->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoGramaList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Set up multi pages
    protected function setupMultiPages()
    {
        $pages = new SubPages();
        $pages->Style = "tabs";
        if ($pages->isAccordion()) {
            $pages->Parent = "#accordion_" . $this->PageObjName;
        }
        $pages->add(0);
        $pages->add(1);
        $pages->add(2);
        $pages->add(3);
        $this->MultiPages = $pages;
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
                case "x_subtipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_email_renovacion":
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
        // Sanitizamos los valores
        $seccion = trim($this->seccion->CurrentValue ?? "");
        $modulo = trim($this->modulo->CurrentValue ?? "");
        $sub = trim($this->sub_seccion->CurrentValue ?? "");
        $parcela = trim($this->parcela->CurrentValue ?? "");
        $header = "
        <div class='card mb-3 shadow-sm border-0 bg-light'>
            <div class='card-body py-2'>
                <div class='d-flex align-items-center'>
                    <div class='me-3'>
                        <span class='badge bg-primary p-2' style='font-size: 1.2rem;'>
                            <i class='fas fa-map-marker-alt me-1'></i> Ubicación
                        </span>
                    </div>
                    <div style='font-size: 1.5rem; font-weight: 300; color: #444;'>
                        <span class='fw-bold text-dark'>$seccion</span> <small class='text-muted'>•</small> 
                        <span class='fw-bold text-dark'>$modulo</span> <small class='text-muted'>•</small> 
                        <span class='fw-bold text-dark'>$sub</span> <small class='text-muted'>•</small> 
                        <span class='fw-bold text-dark'>$parcela</span>
                    </div>
                </div>
            </div>
        </div>";
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
