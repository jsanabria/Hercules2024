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
class ScoExpedienteSegurosEdit extends ScoExpedienteSeguros
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteSegurosEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteSegurosEdit";

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
        $this->Nexpediente_seguros->setVisibility();
        $this->seguro->setVisibility();
        $this->nombre_contacto->setVisibility();
        $this->parentesco_contacto->setVisibility();
        $this->telefono_contacto1->setVisibility();
        $this->telefono_contacto2->setVisibility();
        $this->_email->setVisibility();
        $this->cedula_fallecido->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->sexo->setVisibility();
        $this->fecha_nacimiento->setVisibility();
        $this->edad_fallecido->Visible = false;
        $this->estado_civil->Visible = false;
        $this->lugar_nacimiento_fallecido->Visible = false;
        $this->lugar_ocurrencia->setVisibility();
        $this->direccion_ocurrencia->setVisibility();
        $this->fecha_ocurrencia->setVisibility();
        $this->hora_ocurrencia->Visible = false;
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->setVisibility();
        $this->descripcion_ocurrencia->Visible = false;
        $this->nota->setVisibility();
        $this->user_registra->Visible = false;
        $this->fecha_registro->Visible = false;
        $this->expediente->Visible = false;
        $this->religion->setVisibility();
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->estatus->setVisibility();
        $this->funeraria->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_expediente_seguros';
        $this->TableName = 'sco_expediente_seguros';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_expediente_seguros)
        if (!isset($GLOBALS["sco_expediente_seguros"]) || $GLOBALS["sco_expediente_seguros"]::class == PROJECT_NAMESPACE . "sco_expediente_seguros") {
            $GLOBALS["sco_expediente_seguros"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente_seguros');
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
                        $result["view"] = SameString($pageName, "ScoExpedienteSegurosView"); // If View page, no primary button
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
            $key .= @$ar['Nexpediente_seguros'];
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
            $this->Nexpediente_seguros->Visible = false;
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
        $this->seguro->Required = false;

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
        $this->setupLookupOptions($this->seguro);
        $this->setupLookupOptions($this->parentesco_contacto);
        $this->setupLookupOptions($this->sexo);
        $this->setupLookupOptions($this->estado_civil);
        $this->setupLookupOptions($this->lugar_ocurrencia);
        $this->setupLookupOptions($this->causa_ocurrencia);
        $this->setupLookupOptions($this->user_registra);
        $this->setupLookupOptions($this->religion);
        $this->setupLookupOptions($this->servicio_tipo);
        $this->setupLookupOptions($this->servicio);
        $this->setupLookupOptions($this->estatus);
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
            if (($keyValue = Get("Nexpediente_seguros") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nexpediente_seguros->setQueryStringValue($keyValue);
                $this->Nexpediente_seguros->setOldValue($this->Nexpediente_seguros->QueryStringValue);
            } elseif (Post("Nexpediente_seguros") !== null) {
                $this->Nexpediente_seguros->setFormValue(Post("Nexpediente_seguros"));
                $this->Nexpediente_seguros->setOldValue($this->Nexpediente_seguros->FormValue);
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
                if (($keyValue = Get("Nexpediente_seguros") ?? Route("Nexpediente_seguros")) !== null) {
                    $this->Nexpediente_seguros->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nexpediente_seguros->CurrentValue = null;
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
                        $this->terminate("ScoExpedienteSegurosList"); // Return to list page
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
                        if ($this->Nexpediente_seguros->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nexpediente_seguros->CurrentValue, $this->CurrentRow['Nexpediente_seguros'])) {
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
                        $this->terminate("ScoExpedienteSegurosList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoExpedienteSegurosList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "ScoExpedienteSegurosList") {
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
                        if (GetPageName($returnUrl) != "ScoExpedienteSegurosList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoExpedienteSegurosList"; // Return list page content
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

        // Check field name 'Nexpediente_seguros' first before field var 'x_Nexpediente_seguros'
        $val = $CurrentForm->hasValue("Nexpediente_seguros") ? $CurrentForm->getValue("Nexpediente_seguros") : $CurrentForm->getValue("x_Nexpediente_seguros");
        if (!$this->Nexpediente_seguros->IsDetailKey) {
            $this->Nexpediente_seguros->setFormValue($val);
        }

        // Check field name 'seguro' first before field var 'x_seguro'
        $val = $CurrentForm->hasValue("seguro") ? $CurrentForm->getValue("seguro") : $CurrentForm->getValue("x_seguro");
        if (!$this->seguro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->seguro->Visible = false; // Disable update for API request
            } else {
                $this->seguro->setFormValue($val);
            }
        }

        // Check field name 'nombre_contacto' first before field var 'x_nombre_contacto'
        $val = $CurrentForm->hasValue("nombre_contacto") ? $CurrentForm->getValue("nombre_contacto") : $CurrentForm->getValue("x_nombre_contacto");
        if (!$this->nombre_contacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_contacto->Visible = false; // Disable update for API request
            } else {
                $this->nombre_contacto->setFormValue($val);
            }
        }

        // Check field name 'parentesco_contacto' first before field var 'x_parentesco_contacto'
        $val = $CurrentForm->hasValue("parentesco_contacto") ? $CurrentForm->getValue("parentesco_contacto") : $CurrentForm->getValue("x_parentesco_contacto");
        if (!$this->parentesco_contacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->parentesco_contacto->Visible = false; // Disable update for API request
            } else {
                $this->parentesco_contacto->setFormValue($val);
            }
        }

        // Check field name 'telefono_contacto1' first before field var 'x_telefono_contacto1'
        $val = $CurrentForm->hasValue("telefono_contacto1") ? $CurrentForm->getValue("telefono_contacto1") : $CurrentForm->getValue("x_telefono_contacto1");
        if (!$this->telefono_contacto1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono_contacto1->Visible = false; // Disable update for API request
            } else {
                $this->telefono_contacto1->setFormValue($val);
            }
        }

        // Check field name 'telefono_contacto2' first before field var 'x_telefono_contacto2'
        $val = $CurrentForm->hasValue("telefono_contacto2") ? $CurrentForm->getValue("telefono_contacto2") : $CurrentForm->getValue("x_telefono_contacto2");
        if (!$this->telefono_contacto2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono_contacto2->Visible = false; // Disable update for API request
            } else {
                $this->telefono_contacto2->setFormValue($val);
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

        // Check field name 'sexo' first before field var 'x_sexo'
        $val = $CurrentForm->hasValue("sexo") ? $CurrentForm->getValue("sexo") : $CurrentForm->getValue("x_sexo");
        if (!$this->sexo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sexo->Visible = false; // Disable update for API request
            } else {
                $this->sexo->setFormValue($val);
            }
        }

        // Check field name 'fecha_nacimiento' first before field var 'x_fecha_nacimiento'
        $val = $CurrentForm->hasValue("fecha_nacimiento") ? $CurrentForm->getValue("fecha_nacimiento") : $CurrentForm->getValue("x_fecha_nacimiento");
        if (!$this->fecha_nacimiento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_nacimiento->Visible = false; // Disable update for API request
            } else {
                $this->fecha_nacimiento->setFormValue($val, true, $validate);
            }
            $this->fecha_nacimiento->CurrentValue = UnFormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern());
        }

        // Check field name 'lugar_ocurrencia' first before field var 'x_lugar_ocurrencia'
        $val = $CurrentForm->hasValue("lugar_ocurrencia") ? $CurrentForm->getValue("lugar_ocurrencia") : $CurrentForm->getValue("x_lugar_ocurrencia");
        if (!$this->lugar_ocurrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lugar_ocurrencia->Visible = false; // Disable update for API request
            } else {
                $this->lugar_ocurrencia->setFormValue($val);
            }
        }

        // Check field name 'direccion_ocurrencia' first before field var 'x_direccion_ocurrencia'
        $val = $CurrentForm->hasValue("direccion_ocurrencia") ? $CurrentForm->getValue("direccion_ocurrencia") : $CurrentForm->getValue("x_direccion_ocurrencia");
        if (!$this->direccion_ocurrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->direccion_ocurrencia->Visible = false; // Disable update for API request
            } else {
                $this->direccion_ocurrencia->setFormValue($val);
            }
        }

        // Check field name 'fecha_ocurrencia' first before field var 'x_fecha_ocurrencia'
        $val = $CurrentForm->hasValue("fecha_ocurrencia") ? $CurrentForm->getValue("fecha_ocurrencia") : $CurrentForm->getValue("x_fecha_ocurrencia");
        if (!$this->fecha_ocurrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_ocurrencia->Visible = false; // Disable update for API request
            } else {
                $this->fecha_ocurrencia->setFormValue($val, true, $validate);
            }
            $this->fecha_ocurrencia->CurrentValue = UnFormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern());
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

        // Check field name 'causa_otro' first before field var 'x_causa_otro'
        $val = $CurrentForm->hasValue("causa_otro") ? $CurrentForm->getValue("causa_otro") : $CurrentForm->getValue("x_causa_otro");
        if (!$this->causa_otro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->causa_otro->Visible = false; // Disable update for API request
            } else {
                $this->causa_otro->setFormValue($val);
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

        // Check field name 'religion' first before field var 'x_religion'
        $val = $CurrentForm->hasValue("religion") ? $CurrentForm->getValue("religion") : $CurrentForm->getValue("x_religion");
        if (!$this->religion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->religion->Visible = false; // Disable update for API request
            } else {
                $this->religion->setFormValue($val);
            }
        }

        // Check field name 'servicio_tipo' first before field var 'x_servicio_tipo'
        $val = $CurrentForm->hasValue("servicio_tipo") ? $CurrentForm->getValue("servicio_tipo") : $CurrentForm->getValue("x_servicio_tipo");
        if (!$this->servicio_tipo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->servicio_tipo->Visible = false; // Disable update for API request
            } else {
                $this->servicio_tipo->setFormValue($val);
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

        // Check field name 'estatus' first before field var 'x_estatus'
        $val = $CurrentForm->hasValue("estatus") ? $CurrentForm->getValue("estatus") : $CurrentForm->getValue("x_estatus");
        if (!$this->estatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estatus->Visible = false; // Disable update for API request
            } else {
                $this->estatus->setFormValue($val);
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
        $this->Nexpediente_seguros->CurrentValue = $this->Nexpediente_seguros->FormValue;
        $this->seguro->CurrentValue = $this->seguro->FormValue;
        $this->nombre_contacto->CurrentValue = $this->nombre_contacto->FormValue;
        $this->parentesco_contacto->CurrentValue = $this->parentesco_contacto->FormValue;
        $this->telefono_contacto1->CurrentValue = $this->telefono_contacto1->FormValue;
        $this->telefono_contacto2->CurrentValue = $this->telefono_contacto2->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->cedula_fallecido->CurrentValue = $this->cedula_fallecido->FormValue;
        $this->nombre_fallecido->CurrentValue = $this->nombre_fallecido->FormValue;
        $this->apellidos_fallecido->CurrentValue = $this->apellidos_fallecido->FormValue;
        $this->sexo->CurrentValue = $this->sexo->FormValue;
        $this->fecha_nacimiento->CurrentValue = $this->fecha_nacimiento->FormValue;
        $this->fecha_nacimiento->CurrentValue = UnFormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern());
        $this->lugar_ocurrencia->CurrentValue = $this->lugar_ocurrencia->FormValue;
        $this->direccion_ocurrencia->CurrentValue = $this->direccion_ocurrencia->FormValue;
        $this->fecha_ocurrencia->CurrentValue = $this->fecha_ocurrencia->FormValue;
        $this->fecha_ocurrencia->CurrentValue = UnFormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern());
        $this->causa_ocurrencia->CurrentValue = $this->causa_ocurrencia->FormValue;
        $this->causa_otro->CurrentValue = $this->causa_otro->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->religion->CurrentValue = $this->religion->FormValue;
        $this->servicio_tipo->CurrentValue = $this->servicio_tipo->FormValue;
        $this->servicio->CurrentValue = $this->servicio->FormValue;
        $this->estatus->CurrentValue = $this->estatus->FormValue;
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
        $this->Nexpediente_seguros->setDbValue($row['Nexpediente_seguros']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->_email->setDbValue($row['email']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->edad_fallecido->setDbValue($row['edad_fallecido']);
        $this->estado_civil->setDbValue($row['estado_civil']);
        $this->lugar_nacimiento_fallecido->setDbValue($row['lugar_nacimiento_fallecido']);
        $this->lugar_ocurrencia->setDbValue($row['lugar_ocurrencia']);
        $this->direccion_ocurrencia->setDbValue($row['direccion_ocurrencia']);
        $this->fecha_ocurrencia->setDbValue($row['fecha_ocurrencia']);
        $this->hora_ocurrencia->setDbValue($row['hora_ocurrencia']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->causa_otro->setDbValue($row['causa_otro']);
        $this->descripcion_ocurrencia->setDbValue($row['descripcion_ocurrencia']);
        $this->nota->setDbValue($row['nota']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->expediente->setDbValue($row['expediente']);
        $this->religion->setDbValue($row['religion']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->estatus->setDbValue($row['estatus']);
        $this->funeraria->setDbValue($row['funeraria']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente_seguros'] = $this->Nexpediente_seguros->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['parentesco_contacto'] = $this->parentesco_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
        $row['sexo'] = $this->sexo->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['edad_fallecido'] = $this->edad_fallecido->DefaultValue;
        $row['estado_civil'] = $this->estado_civil->DefaultValue;
        $row['lugar_nacimiento_fallecido'] = $this->lugar_nacimiento_fallecido->DefaultValue;
        $row['lugar_ocurrencia'] = $this->lugar_ocurrencia->DefaultValue;
        $row['direccion_ocurrencia'] = $this->direccion_ocurrencia->DefaultValue;
        $row['fecha_ocurrencia'] = $this->fecha_ocurrencia->DefaultValue;
        $row['hora_ocurrencia'] = $this->hora_ocurrencia->DefaultValue;
        $row['causa_ocurrencia'] = $this->causa_ocurrencia->DefaultValue;
        $row['causa_otro'] = $this->causa_otro->DefaultValue;
        $row['descripcion_ocurrencia'] = $this->descripcion_ocurrencia->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['religion'] = $this->religion->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
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

        // Nexpediente_seguros
        $this->Nexpediente_seguros->RowCssClass = "row";

        // seguro
        $this->seguro->RowCssClass = "row";

        // nombre_contacto
        $this->nombre_contacto->RowCssClass = "row";

        // parentesco_contacto
        $this->parentesco_contacto->RowCssClass = "row";

        // telefono_contacto1
        $this->telefono_contacto1->RowCssClass = "row";

        // telefono_contacto2
        $this->telefono_contacto2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // cedula_fallecido
        $this->cedula_fallecido->RowCssClass = "row";

        // nombre_fallecido
        $this->nombre_fallecido->RowCssClass = "row";

        // apellidos_fallecido
        $this->apellidos_fallecido->RowCssClass = "row";

        // sexo
        $this->sexo->RowCssClass = "row";

        // fecha_nacimiento
        $this->fecha_nacimiento->RowCssClass = "row";

        // edad_fallecido
        $this->edad_fallecido->RowCssClass = "row";

        // estado_civil
        $this->estado_civil->RowCssClass = "row";

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->RowCssClass = "row";

        // lugar_ocurrencia
        $this->lugar_ocurrencia->RowCssClass = "row";

        // direccion_ocurrencia
        $this->direccion_ocurrencia->RowCssClass = "row";

        // fecha_ocurrencia
        $this->fecha_ocurrencia->RowCssClass = "row";

        // hora_ocurrencia
        $this->hora_ocurrencia->RowCssClass = "row";

        // causa_ocurrencia
        $this->causa_ocurrencia->RowCssClass = "row";

        // causa_otro
        $this->causa_otro->RowCssClass = "row";

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // user_registra
        $this->user_registra->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // expediente
        $this->expediente->RowCssClass = "row";

        // religion
        $this->religion->RowCssClass = "row";

        // servicio_tipo
        $this->servicio_tipo->RowCssClass = "row";

        // servicio
        $this->servicio->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // funeraria
        $this->funeraria->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente_seguros
            $this->Nexpediente_seguros->ViewValue = $this->Nexpediente_seguros->CurrentValue;

            // seguro
            $curVal = strval($this->seguro->CurrentValue);
            if ($curVal != "") {
                $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
                if ($this->seguro->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                    $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->seguro->Lookup->renderViewRow($rswrk[0]);
                        $this->seguro->ViewValue = $this->seguro->displayValue($arwrk);
                    } else {
                        $this->seguro->ViewValue = $this->seguro->CurrentValue;
                    }
                }
            } else {
                $this->seguro->ViewValue = null;
            }

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // parentesco_contacto
            $curVal = strval($this->parentesco_contacto->CurrentValue);
            if ($curVal != "") {
                $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->lookupCacheOption($curVal);
                if ($this->parentesco_contacto->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->parentesco_contacto->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->parentesco_contacto->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->parentesco_contacto->getSelectFilter($this); // PHP
                    $sqlWrk = $this->parentesco_contacto->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->parentesco_contacto->Lookup->renderViewRow($rswrk[0]);
                        $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->displayValue($arwrk);
                    } else {
                        $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->CurrentValue;
                    }
                }
            } else {
                $this->parentesco_contacto->ViewValue = null;
            }

            // telefono_contacto1
            $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

            // telefono_contacto2
            $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

            // sexo
            $curVal = strval($this->sexo->CurrentValue);
            if ($curVal != "") {
                $this->sexo->ViewValue = $this->sexo->lookupCacheOption($curVal);
                if ($this->sexo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->sexo->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->sexo->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->sexo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->sexo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->sexo->Lookup->renderViewRow($rswrk[0]);
                        $this->sexo->ViewValue = $this->sexo->displayValue($arwrk);
                    } else {
                        $this->sexo->ViewValue = $this->sexo->CurrentValue;
                    }
                }
            } else {
                $this->sexo->ViewValue = null;
            }

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
            $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

            // edad_fallecido
            $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;

            // estado_civil
            $curVal = strval($this->estado_civil->CurrentValue);
            if ($curVal != "") {
                $this->estado_civil->ViewValue = $this->estado_civil->lookupCacheOption($curVal);
                if ($this->estado_civil->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estado_civil->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->estado_civil->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->estado_civil->getSelectFilter($this); // PHP
                    $sqlWrk = $this->estado_civil->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->estado_civil->Lookup->renderViewRow($rswrk[0]);
                        $this->estado_civil->ViewValue = $this->estado_civil->displayValue($arwrk);
                    } else {
                        $this->estado_civil->ViewValue = $this->estado_civil->CurrentValue;
                    }
                }
            } else {
                $this->estado_civil->ViewValue = null;
            }

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;

            // lugar_ocurrencia
            $curVal = strval($this->lugar_ocurrencia->CurrentValue);
            if ($curVal != "") {
                $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->lookupCacheOption($curVal);
                if ($this->lugar_ocurrencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->lugar_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->lugar_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                    $lookupFilter = $this->lugar_ocurrencia->getSelectFilter($this); // PHP
                    $sqlWrk = $this->lugar_ocurrencia->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->lugar_ocurrencia->Lookup->renderViewRow($rswrk[0]);
                        $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->displayValue($arwrk);
                    } else {
                        $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->CurrentValue;
                    }
                }
            } else {
                $this->lugar_ocurrencia->ViewValue = null;
            }

            // direccion_ocurrencia
            $this->direccion_ocurrencia->ViewValue = $this->direccion_ocurrencia->CurrentValue;

            // fecha_ocurrencia
            $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
            $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

            // hora_ocurrencia
            $this->hora_ocurrencia->ViewValue = $this->hora_ocurrencia->CurrentValue;

            // causa_ocurrencia
            $curVal = strval($this->causa_ocurrencia->CurrentValue);
            if ($curVal != "") {
                $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->lookupCacheOption($curVal);
                if ($this->causa_ocurrencia->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                    $lookupFilter = $this->causa_ocurrencia->getSelectFilter($this); // PHP
                    $sqlWrk = $this->causa_ocurrencia->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->causa_ocurrencia->Lookup->renderViewRow($rswrk[0]);
                        $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->displayValue($arwrk);
                    } else {
                        $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;
                    }
                }
            } else {
                $this->causa_ocurrencia->ViewValue = null;
            }

            // causa_otro
            $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // user_registra
            $curVal = strval($this->user_registra->CurrentValue);
            if ($curVal != "") {
                $this->user_registra->ViewValue = $this->user_registra->lookupCacheOption($curVal);
                if ($this->user_registra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->user_registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->user_registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->user_registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->user_registra->Lookup->renderViewRow($rswrk[0]);
                        $this->user_registra->ViewValue = $this->user_registra->displayValue($arwrk);
                    } else {
                        $this->user_registra->ViewValue = $this->user_registra->CurrentValue;
                    }
                }
            } else {
                $this->user_registra->ViewValue = null;
            }

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // religion
            $curVal = strval($this->religion->CurrentValue);
            if ($curVal != "") {
                $this->religion->ViewValue = $this->religion->lookupCacheOption($curVal);
                if ($this->religion->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->religion->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->religion->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->religion->getSelectFilter($this); // PHP
                    $sqlWrk = $this->religion->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->religion->Lookup->renderViewRow($rswrk[0]);
                        $this->religion->ViewValue = $this->religion->displayValue($arwrk);
                    } else {
                        $this->religion->ViewValue = $this->religion->CurrentValue;
                    }
                }
            } else {
                $this->religion->ViewValue = null;
            }

            // servicio_tipo
            $curVal = strval($this->servicio_tipo->CurrentValue);
            if ($curVal != "") {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
                if ($this->servicio_tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $curVal, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                    $lookupFilter = $this->servicio_tipo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->servicio_tipo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // servicio
            $curVal = strval($this->servicio->CurrentValue);
            if ($curVal != "") {
                $this->servicio->ViewValue = $this->servicio->lookupCacheOption($curVal);
                if ($this->servicio->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchExpression(), "=", $curVal, $this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchDataType(), "");
                    $lookupFilter = $this->servicio->getSelectFilter($this); // PHP
                    $sqlWrk = $this->servicio->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->servicio->Lookup->renderViewRow($rswrk[0]);
                        $this->servicio->ViewValue = $this->servicio->displayValue($arwrk);
                    } else {
                        $this->servicio->ViewValue = $this->servicio->CurrentValue;
                    }
                }
            } else {
                $this->servicio->ViewValue = null;
            }

            // estatus
            if (strval($this->estatus->CurrentValue) != "") {
                $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
            } else {
                $this->estatus->ViewValue = null;
            }

            // funeraria
            if (strval($this->funeraria->CurrentValue) != "") {
                $this->funeraria->ViewValue = $this->funeraria->optionCaption($this->funeraria->CurrentValue);
            } else {
                $this->funeraria->ViewValue = null;
            }

            // Nexpediente_seguros
            $this->Nexpediente_seguros->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";
            $this->seguro->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";

            // parentesco_contacto
            $this->parentesco_contacto->HrefValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";

            // sexo
            $this->sexo->HrefValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";

            // lugar_ocurrencia
            $this->lugar_ocurrencia->HrefValue = "";

            // direccion_ocurrencia
            $this->direccion_ocurrencia->HrefValue = "";

            // fecha_ocurrencia
            $this->fecha_ocurrencia->HrefValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";

            // causa_otro
            $this->causa_otro->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // religion
            $this->religion->HrefValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nexpediente_seguros
            $this->Nexpediente_seguros->setupEditAttributes();
            $this->Nexpediente_seguros->EditValue = $this->Nexpediente_seguros->CurrentValue;

            // seguro
            $this->seguro->setupEditAttributes();
            $curVal = strval($this->seguro->CurrentValue);
            if ($curVal != "") {
                $this->seguro->EditValue = $this->seguro->lookupCacheOption($curVal);
                if ($this->seguro->EditValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                    $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->seguro->Lookup->renderViewRow($rswrk[0]);
                        $this->seguro->EditValue = $this->seguro->displayValue($arwrk);
                    } else {
                        $this->seguro->EditValue = $this->seguro->CurrentValue;
                    }
                }
            } else {
                $this->seguro->EditValue = null;
            }

            // nombre_contacto
            $this->nombre_contacto->setupEditAttributes();
            if (!$this->nombre_contacto->Raw) {
                $this->nombre_contacto->CurrentValue = HtmlDecode($this->nombre_contacto->CurrentValue);
            }
            $this->nombre_contacto->EditValue = HtmlEncode($this->nombre_contacto->CurrentValue);
            $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

            // parentesco_contacto
            $this->parentesco_contacto->setupEditAttributes();
            $curVal = trim(strval($this->parentesco_contacto->CurrentValue));
            if ($curVal != "") {
                $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->lookupCacheOption($curVal);
            } else {
                $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->Lookup !== null && is_array($this->parentesco_contacto->lookupOptions()) && count($this->parentesco_contacto->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->parentesco_contacto->ViewValue !== null) { // Load from cache
                $this->parentesco_contacto->EditValue = array_values($this->parentesco_contacto->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->parentesco_contacto->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $this->parentesco_contacto->CurrentValue, $this->parentesco_contacto->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                }
                $lookupFilter = $this->parentesco_contacto->getSelectFilter($this); // PHP
                $sqlWrk = $this->parentesco_contacto->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->parentesco_contacto->EditValue = $arwrk;
            }
            $this->parentesco_contacto->PlaceHolder = RemoveHtml($this->parentesco_contacto->caption());

            // telefono_contacto1
            $this->telefono_contacto1->setupEditAttributes();
            if (!$this->telefono_contacto1->Raw) {
                $this->telefono_contacto1->CurrentValue = HtmlDecode($this->telefono_contacto1->CurrentValue);
            }
            $this->telefono_contacto1->EditValue = HtmlEncode($this->telefono_contacto1->CurrentValue);
            $this->telefono_contacto1->PlaceHolder = RemoveHtml($this->telefono_contacto1->caption());

            // telefono_contacto2
            $this->telefono_contacto2->setupEditAttributes();
            if (!$this->telefono_contacto2->Raw) {
                $this->telefono_contacto2->CurrentValue = HtmlDecode($this->telefono_contacto2->CurrentValue);
            }
            $this->telefono_contacto2->EditValue = HtmlEncode($this->telefono_contacto2->CurrentValue);
            $this->telefono_contacto2->PlaceHolder = RemoveHtml($this->telefono_contacto2->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // cedula_fallecido
            $this->cedula_fallecido->setupEditAttributes();
            if (!$this->cedula_fallecido->Raw) {
                $this->cedula_fallecido->CurrentValue = HtmlDecode($this->cedula_fallecido->CurrentValue);
            }
            $this->cedula_fallecido->EditValue = HtmlEncode($this->cedula_fallecido->CurrentValue);
            $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

            // nombre_fallecido
            $this->nombre_fallecido->setupEditAttributes();
            if (!$this->nombre_fallecido->Raw) {
                $this->nombre_fallecido->CurrentValue = HtmlDecode($this->nombre_fallecido->CurrentValue);
            }
            $this->nombre_fallecido->EditValue = HtmlEncode($this->nombre_fallecido->CurrentValue);
            $this->nombre_fallecido->PlaceHolder = RemoveHtml($this->nombre_fallecido->caption());

            // apellidos_fallecido
            $this->apellidos_fallecido->setupEditAttributes();
            if (!$this->apellidos_fallecido->Raw) {
                $this->apellidos_fallecido->CurrentValue = HtmlDecode($this->apellidos_fallecido->CurrentValue);
            }
            $this->apellidos_fallecido->EditValue = HtmlEncode($this->apellidos_fallecido->CurrentValue);
            $this->apellidos_fallecido->PlaceHolder = RemoveHtml($this->apellidos_fallecido->caption());

            // sexo
            $this->sexo->setupEditAttributes();
            $curVal = trim(strval($this->sexo->CurrentValue));
            if ($curVal != "") {
                $this->sexo->ViewValue = $this->sexo->lookupCacheOption($curVal);
            } else {
                $this->sexo->ViewValue = $this->sexo->Lookup !== null && is_array($this->sexo->lookupOptions()) && count($this->sexo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->sexo->ViewValue !== null) { // Load from cache
                $this->sexo->EditValue = array_values($this->sexo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->sexo->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $this->sexo->CurrentValue, $this->sexo->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                }
                $lookupFilter = $this->sexo->getSelectFilter($this); // PHP
                $sqlWrk = $this->sexo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->sexo->EditValue = $arwrk;
            }
            $this->sexo->PlaceHolder = RemoveHtml($this->sexo->caption());

            // fecha_nacimiento
            $this->fecha_nacimiento->setupEditAttributes();
            $this->fecha_nacimiento->EditValue = HtmlEncode(FormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern()));
            $this->fecha_nacimiento->PlaceHolder = RemoveHtml($this->fecha_nacimiento->caption());

            // lugar_ocurrencia
            $this->lugar_ocurrencia->setupEditAttributes();
            $curVal = trim(strval($this->lugar_ocurrencia->CurrentValue));
            if ($curVal != "") {
                $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->lookupCacheOption($curVal);
            } else {
                $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->Lookup !== null && is_array($this->lugar_ocurrencia->lookupOptions()) && count($this->lugar_ocurrencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->lugar_ocurrencia->ViewValue !== null) { // Load from cache
                $this->lugar_ocurrencia->EditValue = array_values($this->lugar_ocurrencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->lugar_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $this->lugar_ocurrencia->CurrentValue, $this->lugar_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                }
                $lookupFilter = $this->lugar_ocurrencia->getSelectFilter($this); // PHP
                $sqlWrk = $this->lugar_ocurrencia->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->lugar_ocurrencia->EditValue = $arwrk;
            }
            $this->lugar_ocurrencia->PlaceHolder = RemoveHtml($this->lugar_ocurrencia->caption());

            // direccion_ocurrencia
            $this->direccion_ocurrencia->setupEditAttributes();
            $this->direccion_ocurrencia->EditValue = HtmlEncode($this->direccion_ocurrencia->CurrentValue);
            $this->direccion_ocurrencia->PlaceHolder = RemoveHtml($this->direccion_ocurrencia->caption());

            // fecha_ocurrencia
            $this->fecha_ocurrencia->setupEditAttributes();
            $this->fecha_ocurrencia->EditValue = HtmlEncode(FormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern()));
            $this->fecha_ocurrencia->PlaceHolder = RemoveHtml($this->fecha_ocurrencia->caption());

            // causa_ocurrencia
            $this->causa_ocurrencia->setupEditAttributes();
            $curVal = trim(strval($this->causa_ocurrencia->CurrentValue));
            if ($curVal != "") {
                $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->lookupCacheOption($curVal);
            } else {
                $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->Lookup !== null && is_array($this->causa_ocurrencia->lookupOptions()) && count($this->causa_ocurrencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->causa_ocurrencia->ViewValue !== null) { // Load from cache
                $this->causa_ocurrencia->EditValue = array_values($this->causa_ocurrencia->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $this->causa_ocurrencia->CurrentValue, $this->causa_ocurrencia->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                }
                $lookupFilter = $this->causa_ocurrencia->getSelectFilter($this); // PHP
                $sqlWrk = $this->causa_ocurrencia->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->causa_ocurrencia->EditValue = $arwrk;
            }
            $this->causa_ocurrencia->PlaceHolder = RemoveHtml($this->causa_ocurrencia->caption());

            // causa_otro
            $this->causa_otro->setupEditAttributes();
            if (!$this->causa_otro->Raw) {
                $this->causa_otro->CurrentValue = HtmlDecode($this->causa_otro->CurrentValue);
            }
            $this->causa_otro->EditValue = HtmlEncode($this->causa_otro->CurrentValue);
            $this->causa_otro->PlaceHolder = RemoveHtml($this->causa_otro->caption());

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // religion
            $this->religion->setupEditAttributes();
            $curVal = trim(strval($this->religion->CurrentValue));
            if ($curVal != "") {
                $this->religion->ViewValue = $this->religion->lookupCacheOption($curVal);
            } else {
                $this->religion->ViewValue = $this->religion->Lookup !== null && is_array($this->religion->lookupOptions()) && count($this->religion->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->religion->ViewValue !== null) { // Load from cache
                $this->religion->EditValue = array_values($this->religion->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->religion->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->religion->CurrentValue, $this->religion->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->religion->getSelectFilter($this); // PHP
                $sqlWrk = $this->religion->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->religion->EditValue = $arwrk;
            }
            $this->religion->PlaceHolder = RemoveHtml($this->religion->caption());

            // servicio_tipo
            $this->servicio_tipo->setupEditAttributes();
            $curVal = trim(strval($this->servicio_tipo->CurrentValue));
            if ($curVal != "") {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
            } else {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->Lookup !== null && is_array($this->servicio_tipo->lookupOptions()) && count($this->servicio_tipo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->servicio_tipo->ViewValue !== null) { // Load from cache
                $this->servicio_tipo->EditValue = array_values($this->servicio_tipo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $this->servicio_tipo->CurrentValue, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                }
                $lookupFilter = $this->servicio_tipo->getSelectFilter($this); // PHP
                $sqlWrk = $this->servicio_tipo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->servicio_tipo->EditValue = $arwrk;
            }
            $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

            // servicio
            $this->servicio->setupEditAttributes();
            $curVal = trim(strval($this->servicio->CurrentValue));
            if ($curVal != "") {
                $this->servicio->ViewValue = $this->servicio->lookupCacheOption($curVal);
            } else {
                $this->servicio->ViewValue = $this->servicio->Lookup !== null && is_array($this->servicio->lookupOptions()) && count($this->servicio->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->servicio->ViewValue !== null) { // Load from cache
                $this->servicio->EditValue = array_values($this->servicio->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchExpression(), "=", $this->servicio->CurrentValue, $this->servicio->Lookup->getTable()->Fields["Nservicio"]->searchDataType(), "");
                }
                $lookupFilter = $this->servicio->getSelectFilter($this); // PHP
                $sqlWrk = $this->servicio->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->servicio->EditValue = $arwrk;
            }
            $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

            // estatus
            $this->estatus->setupEditAttributes();
            $this->estatus->EditValue = $this->estatus->options(true);
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            $this->funeraria->EditValue = $this->funeraria->options(true);
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

            // Edit refer script

            // Nexpediente_seguros
            $this->Nexpediente_seguros->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";
            $this->seguro->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";

            // parentesco_contacto
            $this->parentesco_contacto->HrefValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";

            // sexo
            $this->sexo->HrefValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";

            // lugar_ocurrencia
            $this->lugar_ocurrencia->HrefValue = "";

            // direccion_ocurrencia
            $this->direccion_ocurrencia->HrefValue = "";

            // fecha_ocurrencia
            $this->fecha_ocurrencia->HrefValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";

            // causa_otro
            $this->causa_otro->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // religion
            $this->religion->HrefValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";

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
            if ($this->Nexpediente_seguros->Visible && $this->Nexpediente_seguros->Required) {
                if (!$this->Nexpediente_seguros->IsDetailKey && EmptyValue($this->Nexpediente_seguros->FormValue)) {
                    $this->Nexpediente_seguros->addErrorMessage(str_replace("%s", $this->Nexpediente_seguros->caption(), $this->Nexpediente_seguros->RequiredErrorMessage));
                }
            }
            if ($this->seguro->Visible && $this->seguro->Required) {
                if (!$this->seguro->IsDetailKey && EmptyValue($this->seguro->FormValue)) {
                    $this->seguro->addErrorMessage(str_replace("%s", $this->seguro->caption(), $this->seguro->RequiredErrorMessage));
                }
            }
            if ($this->nombre_contacto->Visible && $this->nombre_contacto->Required) {
                if (!$this->nombre_contacto->IsDetailKey && EmptyValue($this->nombre_contacto->FormValue)) {
                    $this->nombre_contacto->addErrorMessage(str_replace("%s", $this->nombre_contacto->caption(), $this->nombre_contacto->RequiredErrorMessage));
                }
            }
            if ($this->parentesco_contacto->Visible && $this->parentesco_contacto->Required) {
                if (!$this->parentesco_contacto->IsDetailKey && EmptyValue($this->parentesco_contacto->FormValue)) {
                    $this->parentesco_contacto->addErrorMessage(str_replace("%s", $this->parentesco_contacto->caption(), $this->parentesco_contacto->RequiredErrorMessage));
                }
            }
            if ($this->telefono_contacto1->Visible && $this->telefono_contacto1->Required) {
                if (!$this->telefono_contacto1->IsDetailKey && EmptyValue($this->telefono_contacto1->FormValue)) {
                    $this->telefono_contacto1->addErrorMessage(str_replace("%s", $this->telefono_contacto1->caption(), $this->telefono_contacto1->RequiredErrorMessage));
                }
            }
            if ($this->telefono_contacto2->Visible && $this->telefono_contacto2->Required) {
                if (!$this->telefono_contacto2->IsDetailKey && EmptyValue($this->telefono_contacto2->FormValue)) {
                    $this->telefono_contacto2->addErrorMessage(str_replace("%s", $this->telefono_contacto2->caption(), $this->telefono_contacto2->RequiredErrorMessage));
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
            if ($this->sexo->Visible && $this->sexo->Required) {
                if (!$this->sexo->IsDetailKey && EmptyValue($this->sexo->FormValue)) {
                    $this->sexo->addErrorMessage(str_replace("%s", $this->sexo->caption(), $this->sexo->RequiredErrorMessage));
                }
            }
            if ($this->fecha_nacimiento->Visible && $this->fecha_nacimiento->Required) {
                if (!$this->fecha_nacimiento->IsDetailKey && EmptyValue($this->fecha_nacimiento->FormValue)) {
                    $this->fecha_nacimiento->addErrorMessage(str_replace("%s", $this->fecha_nacimiento->caption(), $this->fecha_nacimiento->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_nacimiento->FormValue, $this->fecha_nacimiento->formatPattern())) {
                $this->fecha_nacimiento->addErrorMessage($this->fecha_nacimiento->getErrorMessage(false));
            }
            if ($this->lugar_ocurrencia->Visible && $this->lugar_ocurrencia->Required) {
                if (!$this->lugar_ocurrencia->IsDetailKey && EmptyValue($this->lugar_ocurrencia->FormValue)) {
                    $this->lugar_ocurrencia->addErrorMessage(str_replace("%s", $this->lugar_ocurrencia->caption(), $this->lugar_ocurrencia->RequiredErrorMessage));
                }
            }
            if ($this->direccion_ocurrencia->Visible && $this->direccion_ocurrencia->Required) {
                if (!$this->direccion_ocurrencia->IsDetailKey && EmptyValue($this->direccion_ocurrencia->FormValue)) {
                    $this->direccion_ocurrencia->addErrorMessage(str_replace("%s", $this->direccion_ocurrencia->caption(), $this->direccion_ocurrencia->RequiredErrorMessage));
                }
            }
            if ($this->fecha_ocurrencia->Visible && $this->fecha_ocurrencia->Required) {
                if (!$this->fecha_ocurrencia->IsDetailKey && EmptyValue($this->fecha_ocurrencia->FormValue)) {
                    $this->fecha_ocurrencia->addErrorMessage(str_replace("%s", $this->fecha_ocurrencia->caption(), $this->fecha_ocurrencia->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_ocurrencia->FormValue, $this->fecha_ocurrencia->formatPattern())) {
                $this->fecha_ocurrencia->addErrorMessage($this->fecha_ocurrencia->getErrorMessage(false));
            }
            if ($this->causa_ocurrencia->Visible && $this->causa_ocurrencia->Required) {
                if (!$this->causa_ocurrencia->IsDetailKey && EmptyValue($this->causa_ocurrencia->FormValue)) {
                    $this->causa_ocurrencia->addErrorMessage(str_replace("%s", $this->causa_ocurrencia->caption(), $this->causa_ocurrencia->RequiredErrorMessage));
                }
            }
            if ($this->causa_otro->Visible && $this->causa_otro->Required) {
                if (!$this->causa_otro->IsDetailKey && EmptyValue($this->causa_otro->FormValue)) {
                    $this->causa_otro->addErrorMessage(str_replace("%s", $this->causa_otro->caption(), $this->causa_otro->RequiredErrorMessage));
                }
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->religion->Visible && $this->religion->Required) {
                if (!$this->religion->IsDetailKey && EmptyValue($this->religion->FormValue)) {
                    $this->religion->addErrorMessage(str_replace("%s", $this->religion->caption(), $this->religion->RequiredErrorMessage));
                }
            }
            if ($this->servicio_tipo->Visible && $this->servicio_tipo->Required) {
                if (!$this->servicio_tipo->IsDetailKey && EmptyValue($this->servicio_tipo->FormValue)) {
                    $this->servicio_tipo->addErrorMessage(str_replace("%s", $this->servicio_tipo->caption(), $this->servicio_tipo->RequiredErrorMessage));
                }
            }
            if ($this->servicio->Visible && $this->servicio->Required) {
                if (!$this->servicio->IsDetailKey && EmptyValue($this->servicio->FormValue)) {
                    $this->servicio->addErrorMessage(str_replace("%s", $this->servicio->caption(), $this->servicio->RequiredErrorMessage));
                }
            }
            if ($this->estatus->Visible && $this->estatus->Required) {
                if (!$this->estatus->IsDetailKey && EmptyValue($this->estatus->FormValue)) {
                    $this->estatus->addErrorMessage(str_replace("%s", $this->estatus->caption(), $this->estatus->RequiredErrorMessage));
                }
            }
            if ($this->funeraria->Visible && $this->funeraria->Required) {
                if (!$this->funeraria->IsDetailKey && EmptyValue($this->funeraria->FormValue)) {
                    $this->funeraria->addErrorMessage(str_replace("%s", $this->funeraria->caption(), $this->funeraria->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoExpedienteSegurosAdjuntoGrid");
        if (in_array("sco_expediente_seguros_adjunto", $detailTblVar) && $detailPage->DetailEdit) {
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

        // Check field with unique index (cedula_fallecido)
        if ($this->cedula_fallecido->CurrentValue != "") {
            $filterChk = "(`cedula_fallecido` = '" . AdjustSql($this->cedula_fallecido->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->cedula_fallecido->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->cedula_fallecido->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }

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
            $detailPage = Container("ScoExpedienteSegurosAdjuntoGrid");
            if (in_array("sco_expediente_seguros_adjunto", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_expediente_seguros_adjunto"); // Load user level of detail table
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

        // nombre_contacto
        $this->nombre_contacto->setDbValueDef($rsnew, $this->nombre_contacto->CurrentValue, $this->nombre_contacto->ReadOnly);

        // parentesco_contacto
        $this->parentesco_contacto->setDbValueDef($rsnew, $this->parentesco_contacto->CurrentValue, $this->parentesco_contacto->ReadOnly);

        // telefono_contacto1
        $this->telefono_contacto1->setDbValueDef($rsnew, $this->telefono_contacto1->CurrentValue, $this->telefono_contacto1->ReadOnly);

        // telefono_contacto2
        $this->telefono_contacto2->setDbValueDef($rsnew, $this->telefono_contacto2->CurrentValue, $this->telefono_contacto2->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // cedula_fallecido
        $this->cedula_fallecido->setDbValueDef($rsnew, $this->cedula_fallecido->CurrentValue, $this->cedula_fallecido->ReadOnly);

        // nombre_fallecido
        $this->nombre_fallecido->setDbValueDef($rsnew, $this->nombre_fallecido->CurrentValue, $this->nombre_fallecido->ReadOnly);

        // apellidos_fallecido
        $this->apellidos_fallecido->setDbValueDef($rsnew, $this->apellidos_fallecido->CurrentValue, $this->apellidos_fallecido->ReadOnly);

        // sexo
        $this->sexo->setDbValueDef($rsnew, $this->sexo->CurrentValue, $this->sexo->ReadOnly);

        // fecha_nacimiento
        $this->fecha_nacimiento->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern()), $this->fecha_nacimiento->ReadOnly);

        // lugar_ocurrencia
        $this->lugar_ocurrencia->setDbValueDef($rsnew, $this->lugar_ocurrencia->CurrentValue, $this->lugar_ocurrencia->ReadOnly);

        // direccion_ocurrencia
        $this->direccion_ocurrencia->setDbValueDef($rsnew, $this->direccion_ocurrencia->CurrentValue, $this->direccion_ocurrencia->ReadOnly);

        // fecha_ocurrencia
        $this->fecha_ocurrencia->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern()), $this->fecha_ocurrencia->ReadOnly);

        // causa_ocurrencia
        $this->causa_ocurrencia->setDbValueDef($rsnew, $this->causa_ocurrencia->CurrentValue, $this->causa_ocurrencia->ReadOnly);

        // causa_otro
        $this->causa_otro->setDbValueDef($rsnew, $this->causa_otro->CurrentValue, $this->causa_otro->ReadOnly);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, $this->nota->ReadOnly);

        // religion
        $this->religion->setDbValueDef($rsnew, $this->religion->CurrentValue, $this->religion->ReadOnly);

        // servicio_tipo
        $this->servicio_tipo->setDbValueDef($rsnew, $this->servicio_tipo->CurrentValue, $this->servicio_tipo->ReadOnly);

        // servicio
        $this->servicio->setDbValueDef($rsnew, $this->servicio->CurrentValue, $this->servicio->ReadOnly);

        // estatus
        $this->estatus->setDbValueDef($rsnew, $this->estatus->CurrentValue, $this->estatus->ReadOnly);

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
        if (isset($row['nombre_contacto'])) { // nombre_contacto
            $this->nombre_contacto->CurrentValue = $row['nombre_contacto'];
        }
        if (isset($row['parentesco_contacto'])) { // parentesco_contacto
            $this->parentesco_contacto->CurrentValue = $row['parentesco_contacto'];
        }
        if (isset($row['telefono_contacto1'])) { // telefono_contacto1
            $this->telefono_contacto1->CurrentValue = $row['telefono_contacto1'];
        }
        if (isset($row['telefono_contacto2'])) { // telefono_contacto2
            $this->telefono_contacto2->CurrentValue = $row['telefono_contacto2'];
        }
        if (isset($row['email'])) { // email
            $this->_email->CurrentValue = $row['email'];
        }
        if (isset($row['cedula_fallecido'])) { // cedula_fallecido
            $this->cedula_fallecido->CurrentValue = $row['cedula_fallecido'];
        }
        if (isset($row['nombre_fallecido'])) { // nombre_fallecido
            $this->nombre_fallecido->CurrentValue = $row['nombre_fallecido'];
        }
        if (isset($row['apellidos_fallecido'])) { // apellidos_fallecido
            $this->apellidos_fallecido->CurrentValue = $row['apellidos_fallecido'];
        }
        if (isset($row['sexo'])) { // sexo
            $this->sexo->CurrentValue = $row['sexo'];
        }
        if (isset($row['fecha_nacimiento'])) { // fecha_nacimiento
            $this->fecha_nacimiento->CurrentValue = $row['fecha_nacimiento'];
        }
        if (isset($row['lugar_ocurrencia'])) { // lugar_ocurrencia
            $this->lugar_ocurrencia->CurrentValue = $row['lugar_ocurrencia'];
        }
        if (isset($row['direccion_ocurrencia'])) { // direccion_ocurrencia
            $this->direccion_ocurrencia->CurrentValue = $row['direccion_ocurrencia'];
        }
        if (isset($row['fecha_ocurrencia'])) { // fecha_ocurrencia
            $this->fecha_ocurrencia->CurrentValue = $row['fecha_ocurrencia'];
        }
        if (isset($row['causa_ocurrencia'])) { // causa_ocurrencia
            $this->causa_ocurrencia->CurrentValue = $row['causa_ocurrencia'];
        }
        if (isset($row['causa_otro'])) { // causa_otro
            $this->causa_otro->CurrentValue = $row['causa_otro'];
        }
        if (isset($row['nota'])) { // nota
            $this->nota->CurrentValue = $row['nota'];
        }
        if (isset($row['religion'])) { // religion
            $this->religion->CurrentValue = $row['religion'];
        }
        if (isset($row['servicio_tipo'])) { // servicio_tipo
            $this->servicio_tipo->CurrentValue = $row['servicio_tipo'];
        }
        if (isset($row['servicio'])) { // servicio
            $this->servicio->CurrentValue = $row['servicio'];
        }
        if (isset($row['estatus'])) { // estatus
            $this->estatus->CurrentValue = $row['estatus'];
        }
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->CurrentValue = $row['funeraria'];
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
            if (in_array("sco_expediente_seguros_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoExpedienteSegurosAdjuntoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->expediente_seguros->IsDetailKey = true;
                    $detailPageObj->expediente_seguros->CurrentValue = $this->Nexpediente_seguros->CurrentValue;
                    $detailPageObj->expediente_seguros->setSessionValue($detailPageObj->expediente_seguros->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoExpedienteSegurosList"), "", $this->TableVar, true);
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
                case "x_seguro":
                    break;
                case "x_parentesco_contacto":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_sexo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estado_civil":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_lugar_ocurrencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_causa_ocurrencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_user_registra":
                    break;
                case "x_religion":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_servicio_tipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_servicio":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    break;
                case "x_funeraria":
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
