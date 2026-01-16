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
class ViewExpedienteFunerariaEdit extends ViewExpedienteFuneraria
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewExpedienteFunerariaEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ViewExpedienteFunerariaEdit";

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
        $this->Norden->Visible = false;
        $this->expediente->setVisibility();
        $this->servicio->setVisibility();
        $this->cedula_fallecido->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->causa_ocurrencia->setVisibility();
        $this->fecha_servicio->setVisibility();
        $this->hora_fin->setVisibility();
        $this->funeraria->setVisibility();
        $this->user_registra->Visible = false;
        $this->fecha_registro->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'view_expediente_funeraria';
        $this->TableName = 'view_expediente_funeraria';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (view_expediente_funeraria)
        if (!isset($GLOBALS["view_expediente_funeraria"]) || $GLOBALS["view_expediente_funeraria"]::class == PROJECT_NAMESPACE . "view_expediente_funeraria") {
            $GLOBALS["view_expediente_funeraria"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_expediente_funeraria');
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
                        $result["view"] = SameString($pageName, "ViewExpedienteFunerariaView"); // If View page, no primary button
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
            $key .= @$ar['Norden'];
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
        $this->expediente->Required = false;
        $this->fecha_servicio->Required = false;

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
        $this->setupLookupOptions($this->funeraria);

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
            if (($keyValue = Get("Norden") ?? Key(0) ?? Route(2)) !== null) {
                $this->Norden->setQueryStringValue($keyValue);
                $this->Norden->setOldValue($this->Norden->QueryStringValue);
            } elseif (Post("Norden") !== null) {
                $this->Norden->setFormValue(Post("Norden"));
                $this->Norden->setOldValue($this->Norden->FormValue);
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
                if (($keyValue = Get("Norden") ?? Route("Norden")) !== null) {
                    $this->Norden->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Norden->CurrentValue = null;
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
                        $this->terminate("ViewExpedienteFunerariaList"); // Return to list page
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
                        if ($this->Norden->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Norden->CurrentValue, $this->CurrentRow['Norden'])) {
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
                        $this->terminate("ViewExpedienteFunerariaList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ViewExpedienteFunerariaList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ViewExpedienteFunerariaList") {
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
                        if (GetPageName($returnUrl) != "ViewExpedienteFunerariaList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ViewExpedienteFunerariaList"; // Return list page content
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

        // Check field name 'expediente' first before field var 'x_expediente'
        $val = $CurrentForm->hasValue("expediente") ? $CurrentForm->getValue("expediente") : $CurrentForm->getValue("x_expediente");
        if (!$this->expediente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expediente->Visible = false; // Disable update for API request
            } else {
                $this->expediente->setFormValue($val);
            }
        }

        // Check field name 'servicio' first before field var 'x_servicio'
        $val = $CurrentForm->hasValue("servicio") ? $CurrentForm->getValue("servicio") : $CurrentForm->getValue("x_servicio");
        if (!$this->servicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->servicio->Visible = false; // Disable update for API request
            } else {
                $this->servicio->setFormValue($val);
            }
        }

        // Check field name 'cedula_fallecido' first before field var 'x_cedula_fallecido'
        $val = $CurrentForm->hasValue("cedula_fallecido") ? $CurrentForm->getValue("cedula_fallecido") : $CurrentForm->getValue("x_cedula_fallecido");
        if (!$this->cedula_fallecido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula_fallecido->Visible = false; // Disable update for API request
            } else {
                $this->cedula_fallecido->setFormValue($val);
            }
        }

        // Check field name 'nombre_fallecido' first before field var 'x_nombre_fallecido'
        $val = $CurrentForm->hasValue("nombre_fallecido") ? $CurrentForm->getValue("nombre_fallecido") : $CurrentForm->getValue("x_nombre_fallecido");
        if (!$this->nombre_fallecido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_fallecido->Visible = false; // Disable update for API request
            } else {
                $this->nombre_fallecido->setFormValue($val);
            }
        }

        // Check field name 'apellidos_fallecido' first before field var 'x_apellidos_fallecido'
        $val = $CurrentForm->hasValue("apellidos_fallecido") ? $CurrentForm->getValue("apellidos_fallecido") : $CurrentForm->getValue("x_apellidos_fallecido");
        if (!$this->apellidos_fallecido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellidos_fallecido->Visible = false; // Disable update for API request
            } else {
                $this->apellidos_fallecido->setFormValue($val);
            }
        }

        // Check field name 'causa_ocurrencia' first before field var 'x_causa_ocurrencia'
        $val = $CurrentForm->hasValue("causa_ocurrencia") ? $CurrentForm->getValue("causa_ocurrencia") : $CurrentForm->getValue("x_causa_ocurrencia");
        if (!$this->causa_ocurrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->causa_ocurrencia->Visible = false; // Disable update for API request
            } else {
                $this->causa_ocurrencia->setFormValue($val);
            }
        }

        // Check field name 'fecha_servicio' first before field var 'x_fecha_servicio'
        $val = $CurrentForm->hasValue("fecha_servicio") ? $CurrentForm->getValue("fecha_servicio") : $CurrentForm->getValue("x_fecha_servicio");
        if (!$this->fecha_servicio->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_servicio->Visible = false; // Disable update for API request
            } else {
                $this->fecha_servicio->setFormValue($val);
            }
            $this->fecha_servicio->CurrentValue = UnFormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern());
        }

        // Check field name 'hora_fin' first before field var 'x_hora_fin'
        $val = $CurrentForm->hasValue("hora_fin") ? $CurrentForm->getValue("hora_fin") : $CurrentForm->getValue("x_hora_fin");
        if (!$this->hora_fin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_fin->Visible = false; // Disable update for API request
            } else {
                $this->hora_fin->setFormValue($val);
            }
            $this->hora_fin->CurrentValue = UnFormatDateTime($this->hora_fin->CurrentValue, $this->hora_fin->formatPattern());
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

        // Check field name 'Norden' first before field var 'x_Norden'
        $val = $CurrentForm->hasValue("Norden") ? $CurrentForm->getValue("Norden") : $CurrentForm->getValue("x_Norden");
        if (!$this->Norden->IsDetailKey) {
            $this->Norden->setFormValue($val);
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
                        $this->Norden->CurrentValue = $this->Norden->FormValue;
        $this->expediente->CurrentValue = $this->expediente->FormValue;
        $this->servicio->CurrentValue = $this->servicio->FormValue;
        $this->cedula_fallecido->CurrentValue = $this->cedula_fallecido->FormValue;
        $this->nombre_fallecido->CurrentValue = $this->nombre_fallecido->FormValue;
        $this->apellidos_fallecido->CurrentValue = $this->apellidos_fallecido->FormValue;
        $this->causa_ocurrencia->CurrentValue = $this->causa_ocurrencia->FormValue;
        $this->fecha_servicio->CurrentValue = $this->fecha_servicio->FormValue;
        $this->fecha_servicio->CurrentValue = UnFormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern());
        $this->hora_fin->CurrentValue = $this->hora_fin->FormValue;
        $this->hora_fin->CurrentValue = UnFormatDateTime($this->hora_fin->CurrentValue, $this->hora_fin->formatPattern());
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
        $this->Norden->setDbValue($row['Norden']);
        $this->expediente->setDbValue($row['expediente']);
        $this->servicio->setDbValue($row['servicio']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->fecha_servicio->setDbValue($row['fecha_servicio']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Norden'] = $this->Norden->DefaultValue;
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
        $row['causa_ocurrencia'] = $this->causa_ocurrencia->DefaultValue;
        $row['fecha_servicio'] = $this->fecha_servicio->DefaultValue;
        $row['hora_fin'] = $this->hora_fin->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
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

        // Norden
        $this->Norden->RowCssClass = "row";

        // expediente
        $this->expediente->RowCssClass = "row";

        // servicio
        $this->servicio->RowCssClass = "row";

        // cedula_fallecido
        $this->cedula_fallecido->RowCssClass = "row";

        // nombre_fallecido
        $this->nombre_fallecido->RowCssClass = "row";

        // apellidos_fallecido
        $this->apellidos_fallecido->RowCssClass = "row";

        // causa_ocurrencia
        $this->causa_ocurrencia->RowCssClass = "row";

        // fecha_servicio
        $this->fecha_servicio->RowCssClass = "row";

        // hora_fin
        $this->hora_fin->RowCssClass = "row";

        // funeraria
        $this->funeraria->RowCssClass = "row";

        // user_registra
        $this->user_registra->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Norden
            $this->Norden->ViewValue = $this->Norden->CurrentValue;

            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // servicio
            $this->servicio->ViewValue = $this->servicio->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

            // causa_ocurrencia
            $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

            // fecha_servicio
            $this->fecha_servicio->ViewValue = $this->fecha_servicio->CurrentValue;
            $this->fecha_servicio->ViewValue = FormatDateTime($this->fecha_servicio->ViewValue, $this->fecha_servicio->formatPattern());

            // hora_fin
            $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;
            $this->hora_fin->ViewValue = FormatDateTime($this->hora_fin->ViewValue, $this->hora_fin->formatPattern());

            // funeraria
            $curVal = strval($this->funeraria->CurrentValue);
            if ($curVal != "") {
                $this->funeraria->ViewValue = $this->funeraria->lookupCacheOption($curVal);
                if ($this->funeraria->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->funeraria->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $curVal, $this->funeraria->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                    $lookupFilter = $this->funeraria->getSelectFilter($this); // PHP
                    $sqlWrk = $this->funeraria->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->funeraria->Lookup->renderViewRow($rswrk[0]);
                        $this->funeraria->ViewValue = $this->funeraria->displayValue($arwrk);
                    } else {
                        $this->funeraria->ViewValue = $this->funeraria->CurrentValue;
                    }
                }
            } else {
                $this->funeraria->ViewValue = null;
            }

            // user_registra
            $this->user_registra->ViewValue = $this->user_registra->CurrentValue;

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // expediente
            $this->expediente->HrefValue = "";
            $this->expediente->TooltipValue = "";

            // servicio
            $this->servicio->HrefValue = "";
            $this->servicio->TooltipValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";
            $this->cedula_fallecido->TooltipValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";
            $this->nombre_fallecido->TooltipValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";
            $this->apellidos_fallecido->TooltipValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";
            $this->causa_ocurrencia->TooltipValue = "";

            // fecha_servicio
            $this->fecha_servicio->HrefValue = "";
            $this->fecha_servicio->TooltipValue = "";

            // hora_fin
            $this->hora_fin->HrefValue = "";
            $this->hora_fin->TooltipValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // expediente
            $this->expediente->setupEditAttributes();
            $this->expediente->EditValue = $this->expediente->CurrentValue;

            // servicio
            $this->servicio->setupEditAttributes();
            $this->servicio->EditValue = $this->servicio->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->setupEditAttributes();
            $this->cedula_fallecido->EditValue = $this->cedula_fallecido->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->setupEditAttributes();
            $this->nombre_fallecido->EditValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->setupEditAttributes();
            $this->apellidos_fallecido->EditValue = $this->apellidos_fallecido->CurrentValue;

            // causa_ocurrencia
            $this->causa_ocurrencia->setupEditAttributes();
            $this->causa_ocurrencia->EditValue = $this->causa_ocurrencia->CurrentValue;

            // fecha_servicio
            $this->fecha_servicio->setupEditAttributes();
            $this->fecha_servicio->EditValue = $this->fecha_servicio->CurrentValue;
            $this->fecha_servicio->EditValue = FormatDateTime($this->fecha_servicio->EditValue, $this->fecha_servicio->formatPattern());

            // hora_fin
            $this->hora_fin->setupEditAttributes();
            $this->hora_fin->EditValue = $this->hora_fin->CurrentValue;
            $this->hora_fin->EditValue = FormatDateTime($this->hora_fin->EditValue, $this->hora_fin->formatPattern());

            // funeraria
            $curVal = trim(strval($this->funeraria->CurrentValue));
            if ($curVal != "") {
                $this->funeraria->ViewValue = $this->funeraria->lookupCacheOption($curVal);
            } else {
                $this->funeraria->ViewValue = $this->funeraria->Lookup !== null && is_array($this->funeraria->lookupOptions()) && count($this->funeraria->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->funeraria->ViewValue !== null) { // Load from cache
                $this->funeraria->EditValue = array_values($this->funeraria->lookupOptions());
                if ($this->funeraria->ViewValue == "") {
                    $this->funeraria->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->funeraria->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $this->funeraria->CurrentValue, $this->funeraria->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                }
                $lookupFilter = $this->funeraria->getSelectFilter($this); // PHP
                $sqlWrk = $this->funeraria->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->funeraria->Lookup->renderViewRow($rswrk[0]);
                    $this->funeraria->ViewValue = $this->funeraria->displayValue($arwrk);
                } else {
                    $this->funeraria->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->funeraria->EditValue = $arwrk;
            }
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

            // Edit refer script

            // expediente
            $this->expediente->HrefValue = "";
            $this->expediente->TooltipValue = "";

            // servicio
            $this->servicio->HrefValue = "";
            $this->servicio->TooltipValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";
            $this->cedula_fallecido->TooltipValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";
            $this->nombre_fallecido->TooltipValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";
            $this->apellidos_fallecido->TooltipValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";
            $this->causa_ocurrencia->TooltipValue = "";

            // fecha_servicio
            $this->fecha_servicio->HrefValue = "";
            $this->fecha_servicio->TooltipValue = "";

            // hora_fin
            $this->hora_fin->HrefValue = "";
            $this->hora_fin->TooltipValue = "";

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
            if ($this->expediente->Visible && $this->expediente->Required) {
                if (!$this->expediente->IsDetailKey && EmptyValue($this->expediente->FormValue)) {
                    $this->expediente->addErrorMessage(str_replace("%s", $this->expediente->caption(), $this->expediente->RequiredErrorMessage));
                }
            }
            if ($this->servicio->Visible && $this->servicio->Required) {
                if (!$this->servicio->IsDetailKey && EmptyValue($this->servicio->FormValue)) {
                    $this->servicio->addErrorMessage(str_replace("%s", $this->servicio->caption(), $this->servicio->RequiredErrorMessage));
                }
            }
            if ($this->cedula_fallecido->Visible && $this->cedula_fallecido->Required) {
                if (!$this->cedula_fallecido->IsDetailKey && EmptyValue($this->cedula_fallecido->FormValue)) {
                    $this->cedula_fallecido->addErrorMessage(str_replace("%s", $this->cedula_fallecido->caption(), $this->cedula_fallecido->RequiredErrorMessage));
                }
            }
            if ($this->nombre_fallecido->Visible && $this->nombre_fallecido->Required) {
                if (!$this->nombre_fallecido->IsDetailKey && EmptyValue($this->nombre_fallecido->FormValue)) {
                    $this->nombre_fallecido->addErrorMessage(str_replace("%s", $this->nombre_fallecido->caption(), $this->nombre_fallecido->RequiredErrorMessage));
                }
            }
            if ($this->apellidos_fallecido->Visible && $this->apellidos_fallecido->Required) {
                if (!$this->apellidos_fallecido->IsDetailKey && EmptyValue($this->apellidos_fallecido->FormValue)) {
                    $this->apellidos_fallecido->addErrorMessage(str_replace("%s", $this->apellidos_fallecido->caption(), $this->apellidos_fallecido->RequiredErrorMessage));
                }
            }
            if ($this->causa_ocurrencia->Visible && $this->causa_ocurrencia->Required) {
                if (!$this->causa_ocurrencia->IsDetailKey && EmptyValue($this->causa_ocurrencia->FormValue)) {
                    $this->causa_ocurrencia->addErrorMessage(str_replace("%s", $this->causa_ocurrencia->caption(), $this->causa_ocurrencia->RequiredErrorMessage));
                }
            }
            if ($this->fecha_servicio->Visible && $this->fecha_servicio->Required) {
                if (!$this->fecha_servicio->IsDetailKey && EmptyValue($this->fecha_servicio->FormValue)) {
                    $this->fecha_servicio->addErrorMessage(str_replace("%s", $this->fecha_servicio->caption(), $this->fecha_servicio->RequiredErrorMessage));
                }
            }
            if ($this->hora_fin->Visible && $this->hora_fin->Required) {
                if (!$this->hora_fin->IsDetailKey && EmptyValue($this->hora_fin->FormValue)) {
                    $this->hora_fin->addErrorMessage(str_replace("%s", $this->hora_fin->caption(), $this->hora_fin->RequiredErrorMessage));
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
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->CurrentValue = $row['funeraria'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ViewExpedienteFunerariaList"), "", $this->TableVar, true);
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
                case "x_funeraria":
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
