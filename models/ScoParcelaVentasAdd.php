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
class ScoParcelaVentasAdd extends ScoParcelaVentas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoParcelaVentasAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoParcelaVentasAdd";

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
        $this->Nparcela_ventas->Visible = false;
        $this->fecha_compra->Visible = false;
        $this->usuario_compra->Visible = false;
        $this->terraza->Visible = false;
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->subseccion->setVisibility();
        $this->parcela->setVisibility();
        $this->ci_vendedor->setVisibility();
        $this->vendedor->setVisibility();
        $this->valor_compra->setVisibility();
        $this->moneda_compra->setVisibility();
        $this->tasa_compra->setVisibility();
        $this->fecha_venta->Visible = false;
        $this->usuario_vende->Visible = false;
        $this->ci_comprador->Visible = false;
        $this->comprador->Visible = false;
        $this->valor_venta->Visible = false;
        $this->moneda_venta->Visible = false;
        $this->tasa_venta->Visible = false;
        $this->id_parcela->Visible = false;
        $this->nota->setVisibility();
        $this->estatus->Visible = false;
        $this->fecha_registro->Visible = false;
        $this->numero_factura->setVisibility();
        $this->orden_pago->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_parcela_ventas';
        $this->TableName = 'sco_parcela_ventas';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_parcela_ventas)
        if (!isset($GLOBALS["sco_parcela_ventas"]) || $GLOBALS["sco_parcela_ventas"]::class == PROJECT_NAMESPACE . "sco_parcela_ventas") {
            $GLOBALS["sco_parcela_ventas"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_parcela_ventas');
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
                        $result["view"] = SameString($pageName, "ScoParcelaVentasView"); // If View page, no primary button
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

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
        $this->setupLookupOptions($this->usuario_compra);
        $this->setupLookupOptions($this->moneda_compra);
        $this->setupLookupOptions($this->usuario_vende);
        $this->setupLookupOptions($this->moneda_venta);
        $this->setupLookupOptions($this->estatus);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("Nparcela_ventas") ?? Route("Nparcela_ventas")) !== null) {
                $this->Nparcela_ventas->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("ScoParcelaVentasList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "ScoParcelaVentasList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoParcelaVentasView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoParcelaVentasList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoParcelaVentasList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
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
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = RowType::ADD; // Render add type

        // Render row
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

    // Load default values
    protected function loadDefaultValues()
    {
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

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

        // Check field name 'ci_vendedor' first before field var 'x_ci_vendedor'
        $val = $CurrentForm->hasValue("ci_vendedor") ? $CurrentForm->getValue("ci_vendedor") : $CurrentForm->getValue("x_ci_vendedor");
        if (!$this->ci_vendedor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ci_vendedor->Visible = false; // Disable update for API request
            } else {
                $this->ci_vendedor->setFormValue($val);
            }
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

        // Check field name 'valor_compra' first before field var 'x_valor_compra'
        $val = $CurrentForm->hasValue("valor_compra") ? $CurrentForm->getValue("valor_compra") : $CurrentForm->getValue("x_valor_compra");
        if (!$this->valor_compra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->valor_compra->Visible = false; // Disable update for API request
            } else {
                $this->valor_compra->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'moneda_compra' first before field var 'x_moneda_compra'
        $val = $CurrentForm->hasValue("moneda_compra") ? $CurrentForm->getValue("moneda_compra") : $CurrentForm->getValue("x_moneda_compra");
        if (!$this->moneda_compra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->moneda_compra->Visible = false; // Disable update for API request
            } else {
                $this->moneda_compra->setFormValue($val);
            }
        }

        // Check field name 'tasa_compra' first before field var 'x_tasa_compra'
        $val = $CurrentForm->hasValue("tasa_compra") ? $CurrentForm->getValue("tasa_compra") : $CurrentForm->getValue("x_tasa_compra");
        if (!$this->tasa_compra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tasa_compra->Visible = false; // Disable update for API request
            } else {
                $this->tasa_compra->setFormValue($val, true, $validate);
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

        // Check field name 'numero_factura' first before field var 'x_numero_factura'
        $val = $CurrentForm->hasValue("numero_factura") ? $CurrentForm->getValue("numero_factura") : $CurrentForm->getValue("x_numero_factura");
        if (!$this->numero_factura->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->numero_factura->Visible = false; // Disable update for API request
            } else {
                $this->numero_factura->setFormValue($val);
            }
        }

        // Check field name 'orden_pago' first before field var 'x_orden_pago'
        $val = $CurrentForm->hasValue("orden_pago") ? $CurrentForm->getValue("orden_pago") : $CurrentForm->getValue("x_orden_pago");
        if (!$this->orden_pago->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->orden_pago->Visible = false; // Disable update for API request
            } else {
                $this->orden_pago->setFormValue($val);
            }
        }

        // Check field name 'Nparcela_ventas' first before field var 'x_Nparcela_ventas'
        $val = $CurrentForm->hasValue("Nparcela_ventas") ? $CurrentForm->getValue("Nparcela_ventas") : $CurrentForm->getValue("x_Nparcela_ventas");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->seccion->CurrentValue = $this->seccion->FormValue;
        $this->modulo->CurrentValue = $this->modulo->FormValue;
        $this->subseccion->CurrentValue = $this->subseccion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
        $this->ci_vendedor->CurrentValue = $this->ci_vendedor->FormValue;
        $this->vendedor->CurrentValue = $this->vendedor->FormValue;
        $this->valor_compra->CurrentValue = $this->valor_compra->FormValue;
        $this->moneda_compra->CurrentValue = $this->moneda_compra->FormValue;
        $this->tasa_compra->CurrentValue = $this->tasa_compra->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->numero_factura->CurrentValue = $this->numero_factura->FormValue;
        $this->orden_pago->CurrentValue = $this->orden_pago->FormValue;
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
        $this->fecha_compra->setDbValue($row['fecha_compra']);
        $this->usuario_compra->setDbValue($row['usuario_compra']);
        $this->terraza->setDbValue($row['terraza']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->subseccion->setDbValue($row['subseccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->ci_vendedor->setDbValue($row['ci_vendedor']);
        $this->vendedor->setDbValue($row['vendedor']);
        $this->valor_compra->setDbValue($row['valor_compra']);
        $this->moneda_compra->setDbValue($row['moneda_compra']);
        $this->tasa_compra->setDbValue($row['tasa_compra']);
        $this->fecha_venta->setDbValue($row['fecha_venta']);
        $this->usuario_vende->setDbValue($row['usuario_vende']);
        $this->ci_comprador->setDbValue($row['ci_comprador']);
        $this->comprador->setDbValue($row['comprador']);
        $this->valor_venta->setDbValue($row['valor_venta']);
        $this->moneda_venta->setDbValue($row['moneda_venta']);
        $this->tasa_venta->setDbValue($row['tasa_venta']);
        $this->id_parcela->setDbValue($row['id_parcela']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->numero_factura->setDbValue($row['numero_factura']);
        $this->orden_pago->setDbValue($row['orden_pago']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nparcela_ventas'] = $this->Nparcela_ventas->DefaultValue;
        $row['fecha_compra'] = $this->fecha_compra->DefaultValue;
        $row['usuario_compra'] = $this->usuario_compra->DefaultValue;
        $row['terraza'] = $this->terraza->DefaultValue;
        $row['seccion'] = $this->seccion->DefaultValue;
        $row['modulo'] = $this->modulo->DefaultValue;
        $row['subseccion'] = $this->subseccion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['ci_vendedor'] = $this->ci_vendedor->DefaultValue;
        $row['vendedor'] = $this->vendedor->DefaultValue;
        $row['valor_compra'] = $this->valor_compra->DefaultValue;
        $row['moneda_compra'] = $this->moneda_compra->DefaultValue;
        $row['tasa_compra'] = $this->tasa_compra->DefaultValue;
        $row['fecha_venta'] = $this->fecha_venta->DefaultValue;
        $row['usuario_vende'] = $this->usuario_vende->DefaultValue;
        $row['ci_comprador'] = $this->ci_comprador->DefaultValue;
        $row['comprador'] = $this->comprador->DefaultValue;
        $row['valor_venta'] = $this->valor_venta->DefaultValue;
        $row['moneda_venta'] = $this->moneda_venta->DefaultValue;
        $row['tasa_venta'] = $this->tasa_venta->DefaultValue;
        $row['id_parcela'] = $this->id_parcela->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['numero_factura'] = $this->numero_factura->DefaultValue;
        $row['orden_pago'] = $this->orden_pago->DefaultValue;
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

        // fecha_compra
        $this->fecha_compra->RowCssClass = "row";

        // usuario_compra
        $this->usuario_compra->RowCssClass = "row";

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

        // ci_vendedor
        $this->ci_vendedor->RowCssClass = "row";

        // vendedor
        $this->vendedor->RowCssClass = "row";

        // valor_compra
        $this->valor_compra->RowCssClass = "row";

        // moneda_compra
        $this->moneda_compra->RowCssClass = "row";

        // tasa_compra
        $this->tasa_compra->RowCssClass = "row";

        // fecha_venta
        $this->fecha_venta->RowCssClass = "row";

        // usuario_vende
        $this->usuario_vende->RowCssClass = "row";

        // ci_comprador
        $this->ci_comprador->RowCssClass = "row";

        // comprador
        $this->comprador->RowCssClass = "row";

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

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // numero_factura
        $this->numero_factura->RowCssClass = "row";

        // orden_pago
        $this->orden_pago->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nparcela_ventas
            $this->Nparcela_ventas->ViewValue = $this->Nparcela_ventas->CurrentValue;

            // fecha_compra
            $this->fecha_compra->ViewValue = $this->fecha_compra->CurrentValue;
            $this->fecha_compra->ViewValue = FormatDateTime($this->fecha_compra->ViewValue, $this->fecha_compra->formatPattern());

            // usuario_compra
            $this->usuario_compra->ViewValue = $this->usuario_compra->CurrentValue;
            $curVal = strval($this->usuario_compra->CurrentValue);
            if ($curVal != "") {
                $this->usuario_compra->ViewValue = $this->usuario_compra->lookupCacheOption($curVal);
                if ($this->usuario_compra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_compra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->usuario_compra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_compra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_compra->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_compra->ViewValue = $this->usuario_compra->displayValue($arwrk);
                    } else {
                        $this->usuario_compra->ViewValue = $this->usuario_compra->CurrentValue;
                    }
                }
            } else {
                $this->usuario_compra->ViewValue = null;
            }

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

            // ci_vendedor
            $this->ci_vendedor->ViewValue = $this->ci_vendedor->CurrentValue;

            // vendedor
            $this->vendedor->ViewValue = $this->vendedor->CurrentValue;

            // valor_compra
            $this->valor_compra->ViewValue = $this->valor_compra->CurrentValue;
            $this->valor_compra->ViewValue = FormatNumber($this->valor_compra->ViewValue, $this->valor_compra->formatPattern());

            // moneda_compra
            $curVal = strval($this->moneda_compra->CurrentValue);
            if ($curVal != "") {
                $this->moneda_compra->ViewValue = $this->moneda_compra->lookupCacheOption($curVal);
                if ($this->moneda_compra->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->moneda_compra->getSelectFilter($this); // PHP
                    $sqlWrk = $this->moneda_compra->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->moneda_compra->Lookup->renderViewRow($rswrk[0]);
                        $this->moneda_compra->ViewValue = $this->moneda_compra->displayValue($arwrk);
                    } else {
                        $this->moneda_compra->ViewValue = $this->moneda_compra->CurrentValue;
                    }
                }
            } else {
                $this->moneda_compra->ViewValue = null;
            }

            // tasa_compra
            $this->tasa_compra->ViewValue = $this->tasa_compra->CurrentValue;
            $this->tasa_compra->ViewValue = FormatNumber($this->tasa_compra->ViewValue, $this->tasa_compra->formatPattern());

            // fecha_venta
            $this->fecha_venta->ViewValue = $this->fecha_venta->CurrentValue;
            $this->fecha_venta->ViewValue = FormatDateTime($this->fecha_venta->ViewValue, $this->fecha_venta->formatPattern());

            // usuario_vende
            $curVal = strval($this->usuario_vende->CurrentValue);
            if ($curVal != "") {
                $this->usuario_vende->ViewValue = $this->usuario_vende->lookupCacheOption($curVal);
                if ($this->usuario_vende->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->usuario_vende->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->usuario_vende->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->usuario_vende->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->usuario_vende->Lookup->renderViewRow($rswrk[0]);
                        $this->usuario_vende->ViewValue = $this->usuario_vende->displayValue($arwrk);
                    } else {
                        $this->usuario_vende->ViewValue = $this->usuario_vende->CurrentValue;
                    }
                }
            } else {
                $this->usuario_vende->ViewValue = null;
            }

            // ci_comprador
            $this->ci_comprador->ViewValue = $this->ci_comprador->CurrentValue;

            // comprador
            $this->comprador->ViewValue = $this->comprador->CurrentValue;

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
            if (strval($this->estatus->CurrentValue) != "") {
                $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
            } else {
                $this->estatus->ViewValue = null;
            }

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // numero_factura
            $this->numero_factura->ViewValue = $this->numero_factura->CurrentValue;

            // orden_pago
            $this->orden_pago->ViewValue = $this->orden_pago->CurrentValue;

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

            // ci_vendedor
            $this->ci_vendedor->HrefValue = "";

            // vendedor
            $this->vendedor->HrefValue = "";

            // valor_compra
            $this->valor_compra->HrefValue = "";

            // moneda_compra
            $this->moneda_compra->HrefValue = "";

            // tasa_compra
            $this->tasa_compra->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // numero_factura
            $this->numero_factura->HrefValue = "";

            // orden_pago
            $this->orden_pago->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
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

            // subseccion
            $this->subseccion->setupEditAttributes();
            if (!$this->subseccion->Raw) {
                $this->subseccion->CurrentValue = HtmlDecode($this->subseccion->CurrentValue);
            }
            $this->subseccion->EditValue = HtmlEncode($this->subseccion->CurrentValue);
            $this->subseccion->PlaceHolder = RemoveHtml($this->subseccion->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->CurrentValue = HtmlDecode($this->parcela->CurrentValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->CurrentValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

            // ci_vendedor
            $this->ci_vendedor->setupEditAttributes();
            if (!$this->ci_vendedor->Raw) {
                $this->ci_vendedor->CurrentValue = HtmlDecode($this->ci_vendedor->CurrentValue);
            }
            $this->ci_vendedor->EditValue = HtmlEncode($this->ci_vendedor->CurrentValue);
            $this->ci_vendedor->PlaceHolder = RemoveHtml($this->ci_vendedor->caption());

            // vendedor
            $this->vendedor->setupEditAttributes();
            if (!$this->vendedor->Raw) {
                $this->vendedor->CurrentValue = HtmlDecode($this->vendedor->CurrentValue);
            }
            $this->vendedor->EditValue = HtmlEncode($this->vendedor->CurrentValue);
            $this->vendedor->PlaceHolder = RemoveHtml($this->vendedor->caption());

            // valor_compra
            $this->valor_compra->setupEditAttributes();
            $this->valor_compra->EditValue = $this->valor_compra->CurrentValue;
            $this->valor_compra->PlaceHolder = RemoveHtml($this->valor_compra->caption());
            if (strval($this->valor_compra->EditValue) != "" && is_numeric($this->valor_compra->EditValue)) {
                $this->valor_compra->EditValue = FormatNumber($this->valor_compra->EditValue, null);
            }

            // moneda_compra
            $curVal = trim(strval($this->moneda_compra->CurrentValue));
            if ($curVal != "") {
                $this->moneda_compra->ViewValue = $this->moneda_compra->lookupCacheOption($curVal);
            } else {
                $this->moneda_compra->ViewValue = $this->moneda_compra->Lookup !== null && is_array($this->moneda_compra->lookupOptions()) && count($this->moneda_compra->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->moneda_compra->ViewValue !== null) { // Load from cache
                $this->moneda_compra->EditValue = array_values($this->moneda_compra->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->moneda_compra->CurrentValue, $this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->moneda_compra->getSelectFilter($this); // PHP
                $sqlWrk = $this->moneda_compra->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->moneda_compra->EditValue = $arwrk;
            }
            $this->moneda_compra->PlaceHolder = RemoveHtml($this->moneda_compra->caption());

            // tasa_compra
            $this->tasa_compra->setupEditAttributes();
            $this->tasa_compra->EditValue = $this->tasa_compra->CurrentValue;
            $this->tasa_compra->PlaceHolder = RemoveHtml($this->tasa_compra->caption());
            if (strval($this->tasa_compra->EditValue) != "" && is_numeric($this->tasa_compra->EditValue)) {
                $this->tasa_compra->EditValue = FormatNumber($this->tasa_compra->EditValue, null);
            }

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // numero_factura
            $this->numero_factura->setupEditAttributes();
            if (!$this->numero_factura->Raw) {
                $this->numero_factura->CurrentValue = HtmlDecode($this->numero_factura->CurrentValue);
            }
            $this->numero_factura->EditValue = HtmlEncode($this->numero_factura->CurrentValue);
            $this->numero_factura->PlaceHolder = RemoveHtml($this->numero_factura->caption());

            // orden_pago
            $this->orden_pago->setupEditAttributes();
            if (!$this->orden_pago->Raw) {
                $this->orden_pago->CurrentValue = HtmlDecode($this->orden_pago->CurrentValue);
            }
            $this->orden_pago->EditValue = HtmlEncode($this->orden_pago->CurrentValue);
            $this->orden_pago->PlaceHolder = RemoveHtml($this->orden_pago->caption());

            // Add refer script

            // seccion
            $this->seccion->HrefValue = "";

            // modulo
            $this->modulo->HrefValue = "";

            // subseccion
            $this->subseccion->HrefValue = "";

            // parcela
            $this->parcela->HrefValue = "";

            // ci_vendedor
            $this->ci_vendedor->HrefValue = "";

            // vendedor
            $this->vendedor->HrefValue = "";

            // valor_compra
            $this->valor_compra->HrefValue = "";

            // moneda_compra
            $this->moneda_compra->HrefValue = "";

            // tasa_compra
            $this->tasa_compra->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // numero_factura
            $this->numero_factura->HrefValue = "";

            // orden_pago
            $this->orden_pago->HrefValue = "";
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
            if ($this->ci_vendedor->Visible && $this->ci_vendedor->Required) {
                if (!$this->ci_vendedor->IsDetailKey && EmptyValue($this->ci_vendedor->FormValue)) {
                    $this->ci_vendedor->addErrorMessage(str_replace("%s", $this->ci_vendedor->caption(), $this->ci_vendedor->RequiredErrorMessage));
                }
            }
            if ($this->vendedor->Visible && $this->vendedor->Required) {
                if (!$this->vendedor->IsDetailKey && EmptyValue($this->vendedor->FormValue)) {
                    $this->vendedor->addErrorMessage(str_replace("%s", $this->vendedor->caption(), $this->vendedor->RequiredErrorMessage));
                }
            }
            if ($this->valor_compra->Visible && $this->valor_compra->Required) {
                if (!$this->valor_compra->IsDetailKey && EmptyValue($this->valor_compra->FormValue)) {
                    $this->valor_compra->addErrorMessage(str_replace("%s", $this->valor_compra->caption(), $this->valor_compra->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->valor_compra->FormValue)) {
                $this->valor_compra->addErrorMessage($this->valor_compra->getErrorMessage(false));
            }
            if ($this->moneda_compra->Visible && $this->moneda_compra->Required) {
                if ($this->moneda_compra->FormValue == "") {
                    $this->moneda_compra->addErrorMessage(str_replace("%s", $this->moneda_compra->caption(), $this->moneda_compra->RequiredErrorMessage));
                }
            }
            if ($this->tasa_compra->Visible && $this->tasa_compra->Required) {
                if (!$this->tasa_compra->IsDetailKey && EmptyValue($this->tasa_compra->FormValue)) {
                    $this->tasa_compra->addErrorMessage(str_replace("%s", $this->tasa_compra->caption(), $this->tasa_compra->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->tasa_compra->FormValue)) {
                $this->tasa_compra->addErrorMessage($this->tasa_compra->getErrorMessage(false));
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->numero_factura->Visible && $this->numero_factura->Required) {
                if (!$this->numero_factura->IsDetailKey && EmptyValue($this->numero_factura->FormValue)) {
                    $this->numero_factura->addErrorMessage(str_replace("%s", $this->numero_factura->caption(), $this->numero_factura->RequiredErrorMessage));
                }
            }
            if ($this->orden_pago->Visible && $this->orden_pago->Required) {
                if (!$this->orden_pago->IsDetailKey && EmptyValue($this->orden_pago->FormValue)) {
                    $this->orden_pago->addErrorMessage(str_replace("%s", $this->orden_pago->caption(), $this->orden_pago->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoParcelaVentasNotaGrid");
        if (in_array("sco_parcela_ventas_nota", $detailTblVar) && $detailPage->DetailAdd) {
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Get new row
        $rsnew = $this->getAddRow();

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("ScoParcelaVentasNotaGrid");
            if (in_array("sco_parcela_ventas_nota", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->parcela_ventas->setSessionValue($this->Nparcela_ventas->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_parcela_ventas_nota"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->parcela_ventas->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
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
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    /**
     * Get add row
     *
     * @return array
     */
    protected function getAddRow()
    {
        global $Security;
        $rsnew = [];

        // seccion
        $this->seccion->setDbValueDef($rsnew, $this->seccion->CurrentValue, false);

        // modulo
        $this->modulo->setDbValueDef($rsnew, $this->modulo->CurrentValue, false);

        // subseccion
        $this->subseccion->setDbValueDef($rsnew, $this->subseccion->CurrentValue, false);

        // parcela
        $this->parcela->setDbValueDef($rsnew, $this->parcela->CurrentValue, false);

        // ci_vendedor
        $this->ci_vendedor->setDbValueDef($rsnew, $this->ci_vendedor->CurrentValue, false);

        // vendedor
        $this->vendedor->setDbValueDef($rsnew, $this->vendedor->CurrentValue, false);

        // valor_compra
        $this->valor_compra->setDbValueDef($rsnew, $this->valor_compra->CurrentValue, false);

        // moneda_compra
        $this->moneda_compra->setDbValueDef($rsnew, $this->moneda_compra->CurrentValue, false);

        // tasa_compra
        $this->tasa_compra->setDbValueDef($rsnew, $this->tasa_compra->CurrentValue, false);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, false);

        // numero_factura
        $this->numero_factura->setDbValueDef($rsnew, $this->numero_factura->CurrentValue, false);

        // orden_pago
        $this->orden_pago->setDbValueDef($rsnew, $this->orden_pago->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['seccion'])) { // seccion
            $this->seccion->setFormValue($row['seccion']);
        }
        if (isset($row['modulo'])) { // modulo
            $this->modulo->setFormValue($row['modulo']);
        }
        if (isset($row['subseccion'])) { // subseccion
            $this->subseccion->setFormValue($row['subseccion']);
        }
        if (isset($row['parcela'])) { // parcela
            $this->parcela->setFormValue($row['parcela']);
        }
        if (isset($row['ci_vendedor'])) { // ci_vendedor
            $this->ci_vendedor->setFormValue($row['ci_vendedor']);
        }
        if (isset($row['vendedor'])) { // vendedor
            $this->vendedor->setFormValue($row['vendedor']);
        }
        if (isset($row['valor_compra'])) { // valor_compra
            $this->valor_compra->setFormValue($row['valor_compra']);
        }
        if (isset($row['moneda_compra'])) { // moneda_compra
            $this->moneda_compra->setFormValue($row['moneda_compra']);
        }
        if (isset($row['tasa_compra'])) { // tasa_compra
            $this->tasa_compra->setFormValue($row['tasa_compra']);
        }
        if (isset($row['nota'])) { // nota
            $this->nota->setFormValue($row['nota']);
        }
        if (isset($row['numero_factura'])) { // numero_factura
            $this->numero_factura->setFormValue($row['numero_factura']);
        }
        if (isset($row['orden_pago'])) { // orden_pago
            $this->orden_pago->setFormValue($row['orden_pago']);
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
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoParcelaVentasList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_usuario_compra":
                    break;
                case "x_moneda_compra":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_usuario_vende":
                    break;
                case "x_moneda_venta":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
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
