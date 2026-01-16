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
class ViewParcelaVentasEdit extends ViewParcelaVentas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ViewParcelaVentasEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ViewParcelaVentasEdit";

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
        $this->Nparcela_ventas->setVisibility();
        $this->vendedor->setVisibility();
        $this->terraza->Visible = false;
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->subseccion->setVisibility();
        $this->parcela->setVisibility();
        $this->ci_comprador->setVisibility();
        $this->comprador->setVisibility();
        $this->usuario_vende->Visible = false;
        $this->fecha_venta->Visible = false;
        $this->valor_venta->setVisibility();
        $this->moneda_venta->setVisibility();
        $this->tasa_venta->setVisibility();
        $this->id_parcela->Visible = false;
        $this->nota->setVisibility();
        $this->estatus->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'view_parcela_ventas';
        $this->TableName = 'view_parcela_ventas';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (view_parcela_ventas)
        if (!isset($GLOBALS["view_parcela_ventas"]) || $GLOBALS["view_parcela_ventas"]::class == PROJECT_NAMESPACE . "view_parcela_ventas") {
            $GLOBALS["view_parcela_ventas"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'view_parcela_ventas');
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
                        $result["view"] = SameString($pageName, "ViewParcelaVentasView"); // If View page, no primary button
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
            $key .= @$ar['Nparcela_ventas'];
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
            $this->Nparcela_ventas->Visible = false;
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
        $this->setupLookupOptions($this->moneda_venta);

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
            if (($keyValue = Get("Nparcela_ventas") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nparcela_ventas->setQueryStringValue($keyValue);
                $this->Nparcela_ventas->setOldValue($this->Nparcela_ventas->QueryStringValue);
            } elseif (Post("Nparcela_ventas") !== null) {
                $this->Nparcela_ventas->setFormValue(Post("Nparcela_ventas"));
                $this->Nparcela_ventas->setOldValue($this->Nparcela_ventas->FormValue);
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
                if (($keyValue = Get("Nparcela_ventas") ?? Route("Nparcela_ventas")) !== null) {
                    $this->Nparcela_ventas->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nparcela_ventas->CurrentValue = null;
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
                        $this->terminate("ViewParcelaVentasList"); // Return to list page
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
                        if ($this->Nparcela_ventas->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nparcela_ventas->CurrentValue, $this->CurrentRow['Nparcela_ventas'])) {
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
                        $this->terminate("ViewParcelaVentasList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ViewParcelaVentasList"); // No matching record, return to list
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
                if (GetPageName($returnUrl) == "ViewParcelaVentasList") {
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
                        if (GetPageName($returnUrl) != "ViewParcelaVentasList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ViewParcelaVentasList"; // Return list page content
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

        // Check field name 'Nparcela_ventas' first before field var 'x_Nparcela_ventas'
        $val = $CurrentForm->hasValue("Nparcela_ventas") ? $CurrentForm->getValue("Nparcela_ventas") : $CurrentForm->getValue("x_Nparcela_ventas");
        if (!$this->Nparcela_ventas->IsDetailKey) {
            $this->Nparcela_ventas->setFormValue($val);
        }

        // Check field name 'vendedor' first before field var 'x_vendedor'
        $val = $CurrentForm->hasValue("vendedor") ? $CurrentForm->getValue("vendedor") : $CurrentForm->getValue("x_vendedor");
        if (!$this->vendedor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->vendedor->Visible = false; // Disable update for API request
            } else {
                $this->vendedor->setFormValue($val);
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

        // Check field name 'subseccion' first before field var 'x_subseccion'
        $val = $CurrentForm->hasValue("subseccion") ? $CurrentForm->getValue("subseccion") : $CurrentForm->getValue("x_subseccion");
        if (!$this->subseccion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subseccion->Visible = false; // Disable update for API request
            } else {
                $this->subseccion->setFormValue($val);
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

        // Check field name 'ci_comprador' first before field var 'x_ci_comprador'
        $val = $CurrentForm->hasValue("ci_comprador") ? $CurrentForm->getValue("ci_comprador") : $CurrentForm->getValue("x_ci_comprador");
        if (!$this->ci_comprador->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_comprador->Visible = false; // Disable update for API request
            } else {
                $this->ci_comprador->setFormValue($val);
            }
        }

        // Check field name 'comprador' first before field var 'x_comprador'
        $val = $CurrentForm->hasValue("comprador") ? $CurrentForm->getValue("comprador") : $CurrentForm->getValue("x_comprador");
        if (!$this->comprador->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->comprador->Visible = false; // Disable update for API request
            } else {
                $this->comprador->setFormValue($val);
            }
        }

        // Check field name 'valor_venta' first before field var 'x_valor_venta'
        $val = $CurrentForm->hasValue("valor_venta") ? $CurrentForm->getValue("valor_venta") : $CurrentForm->getValue("x_valor_venta");
        if (!$this->valor_venta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->valor_venta->Visible = false; // Disable update for API request
            } else {
                $this->valor_venta->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'moneda_venta' first before field var 'x_moneda_venta'
        $val = $CurrentForm->hasValue("moneda_venta") ? $CurrentForm->getValue("moneda_venta") : $CurrentForm->getValue("x_moneda_venta");
        if (!$this->moneda_venta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->moneda_venta->Visible = false; // Disable update for API request
            } else {
                $this->moneda_venta->setFormValue($val);
            }
        }

        // Check field name 'tasa_venta' first before field var 'x_tasa_venta'
        $val = $CurrentForm->hasValue("tasa_venta") ? $CurrentForm->getValue("tasa_venta") : $CurrentForm->getValue("x_tasa_venta");
        if (!$this->tasa_venta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tasa_venta->Visible = false; // Disable update for API request
            } else {
                $this->tasa_venta->setFormValue($val, true, $validate);
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

        // Check field name 'estatus' first before field var 'x_estatus'
        $val = $CurrentForm->hasValue("estatus") ? $CurrentForm->getValue("estatus") : $CurrentForm->getValue("x_estatus");
        if (!$this->estatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estatus->Visible = false; // Disable update for API request
            } else {
                $this->estatus->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nparcela_ventas->CurrentValue = $this->Nparcela_ventas->FormValue;
        $this->vendedor->CurrentValue = $this->vendedor->FormValue;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->subseccion->CurrentValue = $this->subseccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->ci_comprador->CurrentValue = $this->ci_comprador->FormValue;
        $this->comprador->CurrentValue = $this->comprador->FormValue;
        $this->valor_venta->CurrentValue = $this->valor_venta->FormValue;
        $this->moneda_venta->CurrentValue = $this->moneda_venta->FormValue;
        $this->tasa_venta->CurrentValue = $this->tasa_venta->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->estatus->CurrentValue = $this->estatus->FormValue;
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
        $this->Nparcela_ventas->setDbValue($row['Nparcela_ventas']);
        $this->vendedor->setDbValue($row['vendedor']);
        $this->terraza->setDbValue($row['terraza']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->subseccion->setDbValue($row['subseccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->ci_comprador->setDbValue($row['ci_comprador']);
        $this->comprador->setDbValue($row['comprador']);
        $this->usuario_vende->setDbValue($row['usuario_vende']);
        $this->fecha_venta->setDbValue($row['fecha_venta']);
        $this->valor_venta->setDbValue($row['valor_venta']);
        $this->moneda_venta->setDbValue($row['moneda_venta']);
        $this->tasa_venta->setDbValue($row['tasa_venta']);
        $this->id_parcela->setDbValue($row['id_parcela']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nparcela_ventas'] = $this->Nparcela_ventas->DefaultValue;
        $row['vendedor'] = $this->vendedor->DefaultValue;
        $row['terraza'] = $this->terraza->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['subseccion'] = $this->subseccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['ci_comprador'] = $this->ci_comprador->DefaultValue;
        $row['comprador'] = $this->comprador->DefaultValue;
        $row['usuario_vende'] = $this->usuario_vende->DefaultValue;
        $row['fecha_venta'] = $this->fecha_venta->DefaultValue;
        $row['valor_venta'] = $this->valor_venta->DefaultValue;
        $row['moneda_venta'] = $this->moneda_venta->DefaultValue;
        $row['tasa_venta'] = $this->tasa_venta->DefaultValue;
        $row['id_parcela'] = $this->id_parcela->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
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

        // Nparcela_ventas
        $this->Nparcela_ventas->RowCssClass = "row";

        // vendedor
        $this->vendedor->RowCssClass = "row";

        // terraza
        $this->terraza->RowCssClass = "row";

        // seccion
        $this->seccion->RowCssClass = "row";

        // modulo
        $this->modulo->RowCssClass = "row";

        // subseccion
        $this->subseccion->RowCssClass = "row";

        // parcela
        $this->parcela->RowCssClass = "row";

        // ci_comprador
        $this->ci_comprador->RowCssClass = "row";

        // comprador
        $this->comprador->RowCssClass = "row";

        // usuario_vende
        $this->usuario_vende->RowCssClass = "row";

        // fecha_venta
        $this->fecha_venta->RowCssClass = "row";

        // valor_venta
        $this->valor_venta->RowCssClass = "row";

        // moneda_venta
        $this->moneda_venta->RowCssClass = "row";

        // tasa_venta
        $this->tasa_venta->RowCssClass = "row";

        // id_parcela
        $this->id_parcela->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nparcela_ventas
            $this->Nparcela_ventas->ViewValue = $this->Nparcela_ventas->CurrentValue;

            // vendedor
            $this->vendedor->ViewValue = $this->vendedor->CurrentValue;

            // terraza
            $this->terraza->ViewValue = $this->terraza->CurrentValue;

            // seccion
            $this->seccion->ViewValue = $this->seccion->CurrentValue;

            // modulo
            $this->modulo->ViewValue = $this->modulo->CurrentValue;

            // subseccion
            $this->subseccion->ViewValue = $this->subseccion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // ci_comprador
            $this->ci_comprador->ViewValue = $this->ci_comprador->CurrentValue;

            // comprador
            $this->comprador->ViewValue = $this->comprador->CurrentValue;

            // usuario_vende
            $this->usuario_vende->ViewValue = $this->usuario_vende->CurrentValue;

            // fecha_venta
            $this->fecha_venta->ViewValue = $this->fecha_venta->CurrentValue;
            $this->fecha_venta->ViewValue = FormatDateTime($this->fecha_venta->ViewValue, $this->fecha_venta->formatPattern());

            // valor_venta
            $this->valor_venta->ViewValue = $this->valor_venta->CurrentValue;
            $this->valor_venta->ViewValue = FormatNumber($this->valor_venta->ViewValue, $this->valor_venta->formatPattern());

            // moneda_venta
            $curVal = strval($this->moneda_venta->CurrentValue);
            if ($curVal != "") {
                $this->moneda_venta->ViewValue = $this->moneda_venta->lookupCacheOption($curVal);
                if ($this->moneda_venta->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->moneda_venta->getSelectFilter($this); // PHP
                    $sqlWrk = $this->moneda_venta->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->moneda_venta->Lookup->renderViewRow($rswrk[0]);
                        $this->moneda_venta->ViewValue = $this->moneda_venta->displayValue($arwrk);
                    } else {
                        $this->moneda_venta->ViewValue = $this->moneda_venta->CurrentValue;
                    }
                }
            } else {
                $this->moneda_venta->ViewValue = null;
            }

            // tasa_venta
            $this->tasa_venta->ViewValue = $this->tasa_venta->CurrentValue;
            $this->tasa_venta->ViewValue = FormatNumber($this->tasa_venta->ViewValue, $this->tasa_venta->formatPattern());

            // id_parcela
            $this->id_parcela->ViewValue = $this->id_parcela->CurrentValue;

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // estatus
            $this->estatus->ViewValue = $this->estatus->CurrentValue;

            // Nparcela_ventas
            $this->Nparcela_ventas->HrefValue = "";

            // vendedor
            $this->vendedor->HrefValue = "";
            $this->vendedor->TooltipValue = "";

            // seccion
            $this->seccion->HrefValue = "";
            $this->seccion->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // subseccion
            $this->subseccion->HrefValue = "";
            $this->subseccion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";

            // ci_comprador
            $this->ci_comprador->HrefValue = "";

            // comprador
            $this->comprador->HrefValue = "";

            // valor_venta
            $this->valor_venta->HrefValue = "";

            // moneda_venta
            $this->moneda_venta->HrefValue = "";

            // tasa_venta
            $this->tasa_venta->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nparcela_ventas
            $this->Nparcela_ventas->setupEditAttributes();
            $this->Nparcela_ventas->EditValue = $this->Nparcela_ventas->CurrentValue;

            // vendedor
            $this->vendedor->setupEditAttributes();
            $this->vendedor->EditValue = $this->vendedor->CurrentValue;

            // seccion
            $this->seccion->setupEditAttributes();
            $this->seccion->EditValue = $this->seccion->CurrentValue;

            // modulo
            $this->modulo->setupEditAttributes();
            $this->modulo->EditValue = $this->modulo->CurrentValue;

            // subseccion
            $this->subseccion->setupEditAttributes();
            $this->subseccion->EditValue = $this->subseccion->CurrentValue;

            // parcela
            $this->parcela->setupEditAttributes();
            $this->parcela->EditValue = $this->parcela->CurrentValue;

            // ci_comprador
            $this->ci_comprador->setupEditAttributes();
            if (!$this->ci_comprador->Raw) {
                $this->ci_comprador->CurrentValue = HtmlDecode($this->ci_comprador->CurrentValue);
            }
            $this->ci_comprador->EditValue = HtmlEncode($this->ci_comprador->CurrentValue);
            $this->ci_comprador->PlaceHolder = RemoveHtml($this->ci_comprador->caption());

            // comprador
            $this->comprador->setupEditAttributes();
            if (!$this->comprador->Raw) {
                $this->comprador->CurrentValue = HtmlDecode($this->comprador->CurrentValue);
            }
            $this->comprador->EditValue = HtmlEncode($this->comprador->CurrentValue);
            $this->comprador->PlaceHolder = RemoveHtml($this->comprador->caption());

            // valor_venta
            $this->valor_venta->setupEditAttributes();
            $this->valor_venta->EditValue = $this->valor_venta->CurrentValue;
            $this->valor_venta->PlaceHolder = RemoveHtml($this->valor_venta->caption());
            if (strval($this->valor_venta->EditValue) != "" && is_numeric($this->valor_venta->EditValue)) {
                $this->valor_venta->EditValue = FormatNumber($this->valor_venta->EditValue, null);
            }

            // moneda_venta
            $curVal = trim(strval($this->moneda_venta->CurrentValue));
            if ($curVal != "") {
                $this->moneda_venta->ViewValue = $this->moneda_venta->lookupCacheOption($curVal);
            } else {
                $this->moneda_venta->ViewValue = $this->moneda_venta->Lookup !== null && is_array($this->moneda_venta->lookupOptions()) && count($this->moneda_venta->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->moneda_venta->ViewValue !== null) { // Load from cache
                $this->moneda_venta->EditValue = array_values($this->moneda_venta->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->moneda_venta->CurrentValue, $this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->moneda_venta->getSelectFilter($this); // PHP
                $sqlWrk = $this->moneda_venta->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->moneda_venta->EditValue = $arwrk;
            }
            $this->moneda_venta->PlaceHolder = RemoveHtml($this->moneda_venta->caption());

            // tasa_venta
            $this->tasa_venta->setupEditAttributes();
            $this->tasa_venta->EditValue = $this->tasa_venta->CurrentValue;
            $this->tasa_venta->PlaceHolder = RemoveHtml($this->tasa_venta->caption());
            if (strval($this->tasa_venta->EditValue) != "" && is_numeric($this->tasa_venta->EditValue)) {
                $this->tasa_venta->EditValue = FormatNumber($this->tasa_venta->EditValue, null);
            }

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // estatus
            $this->estatus->setupEditAttributes();
            if (!$this->estatus->Raw) {
                $this->estatus->CurrentValue = HtmlDecode($this->estatus->CurrentValue);
            }
            $this->estatus->EditValue = HtmlEncode($this->estatus->CurrentValue);
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

            // Edit refer script

            // Nparcela_ventas
            $this->Nparcela_ventas->HrefValue = "";

            // vendedor
            $this->vendedor->HrefValue = "";
            $this->vendedor->TooltipValue = "";

            // seccion
            $this->seccion->HrefValue = "";
            $this->seccion->TooltipValue = "";

            // modulo
            $this->modulo->HrefValue = "";
            $this->modulo->TooltipValue = "";

            // subseccion
            $this->subseccion->HrefValue = "";
            $this->subseccion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";

            // ci_comprador
            $this->ci_comprador->HrefValue = "";

            // comprador
            $this->comprador->HrefValue = "";

            // valor_venta
            $this->valor_venta->HrefValue = "";

            // moneda_venta
            $this->moneda_venta->HrefValue = "";

            // tasa_venta
            $this->tasa_venta->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";
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
            if ($this->Nparcela_ventas->Visible && $this->Nparcela_ventas->Required) {
                if (!$this->Nparcela_ventas->IsDetailKey && EmptyValue($this->Nparcela_ventas->FormValue)) {
                    $this->Nparcela_ventas->addErrorMessage(str_replace("%s", $this->Nparcela_ventas->caption(), $this->Nparcela_ventas->RequiredErrorMessage));
                }
            }
            if ($this->vendedor->Visible && $this->vendedor->Required) {
                if (!$this->vendedor->IsDetailKey && EmptyValue($this->vendedor->FormValue)) {
                    $this->vendedor->addErrorMessage(str_replace("%s", $this->vendedor->caption(), $this->vendedor->RequiredErrorMessage));
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
            if ($this->subseccion->Visible && $this->subseccion->Required) {
                if (!$this->subseccion->IsDetailKey && EmptyValue($this->subseccion->FormValue)) {
                    $this->subseccion->addErrorMessage(str_replace("%s", $this->subseccion->caption(), $this->subseccion->RequiredErrorMessage));
                }
            }
            if ($this->parcela->Visible && $this->parcela->Required) {
                if (!$this->parcela->IsDetailKey && EmptyValue($this->parcela->FormValue)) {
                    $this->parcela->addErrorMessage(str_replace("%s", $this->parcela->caption(), $this->parcela->RequiredErrorMessage));
                }
            }
            if ($this->ci_comprador->Visible && $this->ci_comprador->Required) {
                if (!$this->ci_comprador->IsDetailKey && EmptyValue($this->ci_comprador->FormValue)) {
                    $this->ci_comprador->addErrorMessage(str_replace("%s", $this->ci_comprador->caption(), $this->ci_comprador->RequiredErrorMessage));
                }
            }
            if ($this->comprador->Visible && $this->comprador->Required) {
                if (!$this->comprador->IsDetailKey && EmptyValue($this->comprador->FormValue)) {
                    $this->comprador->addErrorMessage(str_replace("%s", $this->comprador->caption(), $this->comprador->RequiredErrorMessage));
                }
            }
            if ($this->valor_venta->Visible && $this->valor_venta->Required) {
                if (!$this->valor_venta->IsDetailKey && EmptyValue($this->valor_venta->FormValue)) {
                    $this->valor_venta->addErrorMessage(str_replace("%s", $this->valor_venta->caption(), $this->valor_venta->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->valor_venta->FormValue)) {
                $this->valor_venta->addErrorMessage($this->valor_venta->getErrorMessage(false));
            }
            if ($this->moneda_venta->Visible && $this->moneda_venta->Required) {
                if ($this->moneda_venta->FormValue == "") {
                    $this->moneda_venta->addErrorMessage(str_replace("%s", $this->moneda_venta->caption(), $this->moneda_venta->RequiredErrorMessage));
                }
            }
            if ($this->tasa_venta->Visible && $this->tasa_venta->Required) {
                if (!$this->tasa_venta->IsDetailKey && EmptyValue($this->tasa_venta->FormValue)) {
                    $this->tasa_venta->addErrorMessage(str_replace("%s", $this->tasa_venta->caption(), $this->tasa_venta->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->tasa_venta->FormValue)) {
                $this->tasa_venta->addErrorMessage($this->tasa_venta->getErrorMessage(false));
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->estatus->Visible && $this->estatus->Required) {
                if (!$this->estatus->IsDetailKey && EmptyValue($this->estatus->FormValue)) {
                    $this->estatus->addErrorMessage(str_replace("%s", $this->estatus->caption(), $this->estatus->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoParcelaVentasNotaGrid");
        if (in_array("sco_parcela_ventas_nota", $detailTblVar) && $detailPage->DetailEdit) {
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
            $detailPage = Container("ScoParcelaVentasNotaGrid");
            if (in_array("sco_parcela_ventas_nota", $detailTblVar) && $detailPage->DetailEdit && $editRow) {
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_parcela_ventas_nota"); // Load user level of detail table
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

        // ci_comprador
        $this->ci_comprador->setDbValueDef($rsnew, $this->ci_comprador->CurrentValue, $this->ci_comprador->ReadOnly);

        // comprador
        $this->comprador->setDbValueDef($rsnew, $this->comprador->CurrentValue, $this->comprador->ReadOnly);

        // valor_venta
        $this->valor_venta->setDbValueDef($rsnew, $this->valor_venta->CurrentValue, $this->valor_venta->ReadOnly);

        // moneda_venta
        $this->moneda_venta->setDbValueDef($rsnew, $this->moneda_venta->CurrentValue, $this->moneda_venta->ReadOnly);

        // tasa_venta
        $this->tasa_venta->setDbValueDef($rsnew, $this->tasa_venta->CurrentValue, $this->tasa_venta->ReadOnly);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, $this->nota->ReadOnly);

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
        if (isset($row['ci_comprador'])) { // ci_comprador
            $this->ci_comprador->CurrentValue = $row['ci_comprador'];
        }
        if (isset($row['comprador'])) { // comprador
            $this->comprador->CurrentValue = $row['comprador'];
        }
        if (isset($row['valor_venta'])) { // valor_venta
            $this->valor_venta->CurrentValue = $row['valor_venta'];
        }
        if (isset($row['moneda_venta'])) { // moneda_venta
            $this->moneda_venta->CurrentValue = $row['moneda_venta'];
        }
        if (isset($row['tasa_venta'])) { // tasa_venta
            $this->tasa_venta->CurrentValue = $row['tasa_venta'];
        }
        if (isset($row['nota'])) { // nota
            $this->nota->CurrentValue = $row['nota'];
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
            if (in_array("sco_parcela_ventas_nota", $detailTblVar)) {
                $detailPageObj = Container("ScoParcelaVentasNotaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->parcela_ventas->IsDetailKey = true;
                    $detailPageObj->parcela_ventas->CurrentValue = $this->Nparcela_ventas->CurrentValue;
                    $detailPageObj->parcela_ventas->setSessionValue($detailPageObj->parcela_ventas->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ViewParcelaVentasList"), "", $this->TableVar, true);
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
                case "x_moneda_venta":
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
        // Validamos que estemos en la página de edición (Edit)
        if (CurrentPageID() == "edit") {
            // Usamos .= para añadir al contenido existente del header
            $header .= '
            <div id="controles-especiales" class="card mb-3 border-warning" style="display:none; clear:both;">
                <div class="card-body d-flex justify-content-around">
                    <div class="custom-control custom-checkbox border-right pr-4">
                        <input type="checkbox" class="custom-control-input" id="chk-anular">
                        <label class="custom-control-label text-danger font-weight-bold" for="chk-anular" style="cursor:pointer;">
                            <i class="fas fa-ban"></i> ANULAR ESTA VENTA
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="chk-revertir">
                        <label class="custom-control-label text-warning font-weight-bold" for="chk-revertir" style="cursor:pointer;">
                            <i class="fas fa-undo"></i> REVERTIR A ESTATUS COMPRA
                        </label>
                    </div>
                </div>
            </div>';
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
