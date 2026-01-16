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
class ScoOrdenCompraDetalleAdd extends ScoOrdenCompraDetalle
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoOrdenCompraDetalleAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoOrdenCompraDetalleAdd";

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
        $this->Norden_compra_detalle->Visible = false;
        $this->orden_compra->Visible = false;
        $this->tipo_insumo->setVisibility();
        $this->articulo->setVisibility();
        $this->unidad_medida->setVisibility();
        $this->cantidad->setVisibility();
        $this->descripcion->setVisibility();
        $this->imagen->setVisibility();
        $this->disponible->setVisibility();
        $this->unidad_medida_recibida->setVisibility();
        $this->cantidad_recibida->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_orden_compra_detalle';
        $this->TableName = 'sco_orden_compra_detalle';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_orden_compra_detalle)
        if (!isset($GLOBALS["sco_orden_compra_detalle"]) || $GLOBALS["sco_orden_compra_detalle"]::class == PROJECT_NAMESPACE . "sco_orden_compra_detalle") {
            $GLOBALS["sco_orden_compra_detalle"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_orden_compra_detalle');
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
                        $result["view"] = SameString($pageName, "ScoOrdenCompraDetalleView"); // If View page, no primary button
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
            $key .= @$ar['Norden_compra_detalle'];
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
            $this->Norden_compra_detalle->Visible = false;
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
        $this->setupLookupOptions($this->tipo_insumo);
        $this->setupLookupOptions($this->articulo);
        $this->setupLookupOptions($this->unidad_medida);
        $this->setupLookupOptions($this->disponible);
        $this->setupLookupOptions($this->unidad_medida_recibida);

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
            if (($keyValue = Get("Norden_compra_detalle") ?? Route("Norden_compra_detalle")) !== null) {
                $this->Norden_compra_detalle->setQueryStringValue($keyValue);
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

        // Set up master/detail parameters
        // NOTE: Must be after loadOldRecord to prevent master key values being overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

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
                    $this->terminate("ScoOrdenCompraDetalleList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "ScoOrdenCompraDetalleList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoOrdenCompraDetalleView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions && !$this->getCurrentMasterTable()) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoOrdenCompraDetalleList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoOrdenCompraDetalleList"; // Return list page content
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
        $this->imagen->Upload->Index = $CurrentForm->Index;
        $this->imagen->Upload->uploadFile();
        $this->imagen->CurrentValue = $this->imagen->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->disponible->DefaultValue = $this->disponible->getDefault(); // PHP
        $this->disponible->OldValue = $this->disponible->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'tipo_insumo' first before field var 'x_tipo_insumo'
        $val = $CurrentForm->hasValue("tipo_insumo") ? $CurrentForm->getValue("tipo_insumo") : $CurrentForm->getValue("x_tipo_insumo");
        if (!$this->tipo_insumo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_insumo->Visible = false; // Disable update for API request
            } else {
                $this->tipo_insumo->setFormValue($val);
            }
        }

        // Check field name 'articulo' first before field var 'x_articulo'
        $val = $CurrentForm->hasValue("articulo") ? $CurrentForm->getValue("articulo") : $CurrentForm->getValue("x_articulo");
        if (!$this->articulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->articulo->Visible = false; // Disable update for API request
            } else {
                $this->articulo->setFormValue($val);
            }
        }

        // Check field name 'unidad_medida' first before field var 'x_unidad_medida'
        $val = $CurrentForm->hasValue("unidad_medida") ? $CurrentForm->getValue("unidad_medida") : $CurrentForm->getValue("x_unidad_medida");
        if (!$this->unidad_medida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unidad_medida->Visible = false; // Disable update for API request
            } else {
                $this->unidad_medida->setFormValue($val);
            }
        }

        // Check field name 'cantidad' first before field var 'x_cantidad'
        $val = $CurrentForm->hasValue("cantidad") ? $CurrentForm->getValue("cantidad") : $CurrentForm->getValue("x_cantidad");
        if (!$this->cantidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cantidad->Visible = false; // Disable update for API request
            } else {
                $this->cantidad->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'descripcion' first before field var 'x_descripcion'
        $val = $CurrentForm->hasValue("descripcion") ? $CurrentForm->getValue("descripcion") : $CurrentForm->getValue("x_descripcion");
        if (!$this->descripcion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion->Visible = false; // Disable update for API request
            } else {
                $this->descripcion->setFormValue($val);
            }
        }

        // Check field name 'disponible' first before field var 'x_disponible'
        $val = $CurrentForm->hasValue("disponible") ? $CurrentForm->getValue("disponible") : $CurrentForm->getValue("x_disponible");
        if (!$this->disponible->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->disponible->Visible = false; // Disable update for API request
            } else {
                $this->disponible->setFormValue($val);
            }
        }

        // Check field name 'unidad_medida_recibida' first before field var 'x_unidad_medida_recibida'
        $val = $CurrentForm->hasValue("unidad_medida_recibida") ? $CurrentForm->getValue("unidad_medida_recibida") : $CurrentForm->getValue("x_unidad_medida_recibida");
        if (!$this->unidad_medida_recibida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unidad_medida_recibida->Visible = false; // Disable update for API request
            } else {
                $this->unidad_medida_recibida->setFormValue($val);
            }
        }

        // Check field name 'cantidad_recibida' first before field var 'x_cantidad_recibida'
        $val = $CurrentForm->hasValue("cantidad_recibida") ? $CurrentForm->getValue("cantidad_recibida") : $CurrentForm->getValue("x_cantidad_recibida");
        if (!$this->cantidad_recibida->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cantidad_recibida->Visible = false; // Disable update for API request
            } else {
                $this->cantidad_recibida->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Norden_compra_detalle' first before field var 'x_Norden_compra_detalle'
        $val = $CurrentForm->hasValue("Norden_compra_detalle") ? $CurrentForm->getValue("Norden_compra_detalle") : $CurrentForm->getValue("x_Norden_compra_detalle");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tipo_insumo->CurrentValue = $this->tipo_insumo->FormValue;
        $this->articulo->CurrentValue = $this->articulo->FormValue;
        $this->unidad_medida->CurrentValue = $this->unidad_medida->FormValue;
        $this->cantidad->CurrentValue = $this->cantidad->FormValue;
        $this->descripcion->CurrentValue = $this->descripcion->FormValue;
        $this->disponible->CurrentValue = $this->disponible->FormValue;
        $this->unidad_medida_recibida->CurrentValue = $this->unidad_medida_recibida->FormValue;
        $this->cantidad_recibida->CurrentValue = $this->cantidad_recibida->FormValue;
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
        $this->Norden_compra_detalle->setDbValue($row['Norden_compra_detalle']);
        $this->orden_compra->setDbValue($row['orden_compra']);
        $this->tipo_insumo->setDbValue($row['tipo_insumo']);
        $this->articulo->setDbValue($row['articulo']);
        $this->unidad_medida->setDbValue($row['unidad_medida']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->descripcion->setDbValue($row['descripcion']);
        $this->imagen->Upload->DbValue = $row['imagen'];
        $this->imagen->setDbValue($this->imagen->Upload->DbValue);
        $this->disponible->setDbValue($row['disponible']);
        $this->unidad_medida_recibida->setDbValue($row['unidad_medida_recibida']);
        $this->cantidad_recibida->setDbValue($row['cantidad_recibida']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Norden_compra_detalle'] = $this->Norden_compra_detalle->DefaultValue;
        $row['orden_compra'] = $this->orden_compra->DefaultValue;
        $row['tipo_insumo'] = $this->tipo_insumo->DefaultValue;
        $row['articulo'] = $this->articulo->DefaultValue;
        $row['unidad_medida'] = $this->unidad_medida->DefaultValue;
        $row['cantidad'] = $this->cantidad->DefaultValue;
        $row['descripcion'] = $this->descripcion->DefaultValue;
        $row['imagen'] = $this->imagen->DefaultValue;
        $row['disponible'] = $this->disponible->DefaultValue;
        $row['unidad_medida_recibida'] = $this->unidad_medida_recibida->DefaultValue;
        $row['cantidad_recibida'] = $this->cantidad_recibida->DefaultValue;
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

        // Norden_compra_detalle
        $this->Norden_compra_detalle->RowCssClass = "row";

        // orden_compra
        $this->orden_compra->RowCssClass = "row";

        // tipo_insumo
        $this->tipo_insumo->RowCssClass = "row";

        // articulo
        $this->articulo->RowCssClass = "row";

        // unidad_medida
        $this->unidad_medida->RowCssClass = "row";

        // cantidad
        $this->cantidad->RowCssClass = "row";

        // descripcion
        $this->descripcion->RowCssClass = "row";

        // imagen
        $this->imagen->RowCssClass = "row";

        // disponible
        $this->disponible->RowCssClass = "row";

        // unidad_medida_recibida
        $this->unidad_medida_recibida->RowCssClass = "row";

        // cantidad_recibida
        $this->cantidad_recibida->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Norden_compra_detalle
            $this->Norden_compra_detalle->ViewValue = $this->Norden_compra_detalle->CurrentValue;

            // orden_compra
            $this->orden_compra->ViewValue = $this->orden_compra->CurrentValue;

            // tipo_insumo
            $curVal = strval($this->tipo_insumo->CurrentValue);
            if ($curVal != "") {
                $this->tipo_insumo->ViewValue = $this->tipo_insumo->lookupCacheOption($curVal);
                if ($this->tipo_insumo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                    $sqlWrk = $this->tipo_insumo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_insumo->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_insumo->ViewValue = $this->tipo_insumo->displayValue($arwrk);
                    } else {
                        $this->tipo_insumo->ViewValue = $this->tipo_insumo->CurrentValue;
                    }
                }
            } else {
                $this->tipo_insumo->ViewValue = null;
            }

            // articulo
            $curVal = strval($this->articulo->CurrentValue);
            if ($curVal != "") {
                $this->articulo->ViewValue = $this->articulo->lookupCacheOption($curVal);
                if ($this->articulo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $curVal, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                    $sqlWrk = $this->articulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                        $this->articulo->ViewValue = $this->articulo->displayValue($arwrk);
                    } else {
                        $this->articulo->ViewValue = $this->articulo->CurrentValue;
                    }
                }
            } else {
                $this->articulo->ViewValue = null;
            }

            // unidad_medida
            $curVal = strval($this->unidad_medida->CurrentValue);
            if ($curVal != "") {
                $this->unidad_medida->ViewValue = $this->unidad_medida->lookupCacheOption($curVal);
                if ($this->unidad_medida->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unidad_medida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unidad_medida->Lookup->renderViewRow($rswrk[0]);
                        $this->unidad_medida->ViewValue = $this->unidad_medida->displayValue($arwrk);
                    } else {
                        $this->unidad_medida->ViewValue = $this->unidad_medida->CurrentValue;
                    }
                }
            } else {
                $this->unidad_medida->ViewValue = null;
            }

            // cantidad
            $this->cantidad->ViewValue = $this->cantidad->CurrentValue;
            $this->cantidad->ViewValue = FormatNumber($this->cantidad->ViewValue, $this->cantidad->formatPattern());

            // descripcion
            $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->ImageWidth = 120;
                $this->imagen->ImageHeight = 120;
                $this->imagen->ImageAlt = $this->imagen->alt();
                $this->imagen->ImageCssClass = "ew-image";
                $this->imagen->ViewValue = $this->imagen->Upload->DbValue;
            } else {
                $this->imagen->ViewValue = "";
            }

            // disponible
            if (strval($this->disponible->CurrentValue) != "") {
                $this->disponible->ViewValue = $this->disponible->optionCaption($this->disponible->CurrentValue);
            } else {
                $this->disponible->ViewValue = null;
            }

            // unidad_medida_recibida
            $curVal = strval($this->unidad_medida_recibida->CurrentValue);
            if ($curVal != "") {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->lookupCacheOption($curVal);
                if ($this->unidad_medida_recibida->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->unidad_medida_recibida->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unidad_medida_recibida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unidad_medida_recibida->Lookup->renderViewRow($rswrk[0]);
                        $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->displayValue($arwrk);
                    } else {
                        $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->CurrentValue;
                    }
                }
            } else {
                $this->unidad_medida_recibida->ViewValue = null;
            }

            // cantidad_recibida
            $this->cantidad_recibida->ViewValue = $this->cantidad_recibida->CurrentValue;
            $this->cantidad_recibida->ViewValue = FormatNumber($this->cantidad_recibida->ViewValue, $this->cantidad_recibida->formatPattern());

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";
            $this->tipo_insumo->TooltipValue = "";

            // articulo
            $this->articulo->HrefValue = "";
            $this->articulo->TooltipValue = "";

            // unidad_medida
            $this->unidad_medida->HrefValue = "";
            $this->unidad_medida->TooltipValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";
            $this->cantidad->TooltipValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";
            $this->descripcion->TooltipValue = "";

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->HrefValue = GetFileUploadUrl($this->imagen, $this->imagen->htmlDecode($this->imagen->Upload->DbValue)); // Add prefix/suffix
                $this->imagen->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->imagen->HrefValue = FullUrl($this->imagen->HrefValue, "href");
                }
            } else {
                $this->imagen->HrefValue = "";
            }
            $this->imagen->ExportHrefValue = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
            $this->imagen->TooltipValue = "";
            if ($this->imagen->UseColorbox) {
                if (EmptyValue($this->imagen->TooltipValue)) {
                    $this->imagen->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->imagen->LinkAttrs["data-rel"] = "sco_orden_compra_detalle_x_imagen";
                $this->imagen->LinkAttrs->appendClass("ew-lightbox");
            }

            // disponible
            $this->disponible->HrefValue = "";

            // unidad_medida_recibida
            $this->unidad_medida_recibida->HrefValue = "";

            // cantidad_recibida
            $this->cantidad_recibida->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // tipo_insumo
            $this->tipo_insumo->setupEditAttributes();
            $curVal = trim(strval($this->tipo_insumo->CurrentValue));
            if ($curVal != "") {
                $this->tipo_insumo->ViewValue = $this->tipo_insumo->lookupCacheOption($curVal);
            } else {
                $this->tipo_insumo->ViewValue = $this->tipo_insumo->Lookup !== null && is_array($this->tipo_insumo->lookupOptions()) && count($this->tipo_insumo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->tipo_insumo->ViewValue !== null) { // Load from cache
                $this->tipo_insumo->EditValue = array_values($this->tipo_insumo->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->tipo_insumo->CurrentValue, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_insumo->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_insumo->EditValue = $arwrk;
            }
            $this->tipo_insumo->PlaceHolder = RemoveHtml($this->tipo_insumo->caption());

            // articulo
            $curVal = trim(strval($this->articulo->CurrentValue));
            if ($curVal != "") {
                $this->articulo->ViewValue = $this->articulo->lookupCacheOption($curVal);
            } else {
                $this->articulo->ViewValue = $this->articulo->Lookup !== null && is_array($this->articulo->lookupOptions()) && count($this->articulo->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->articulo->ViewValue !== null) { // Load from cache
                $this->articulo->EditValue = array_values($this->articulo->lookupOptions());
                if ($this->articulo->ViewValue == "") {
                    $this->articulo->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $this->articulo->CurrentValue, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                }
                $sqlWrk = $this->articulo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                    $this->articulo->ViewValue = $this->articulo->displayValue($arwrk);
                } else {
                    $this->articulo->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->articulo->EditValue = $arwrk;
            }
            $this->articulo->PlaceHolder = RemoveHtml($this->articulo->caption());

            // unidad_medida
            $this->unidad_medida->setupEditAttributes();
            $curVal = trim(strval($this->unidad_medida->CurrentValue));
            if ($curVal != "") {
                $this->unidad_medida->ViewValue = $this->unidad_medida->lookupCacheOption($curVal);
            } else {
                $this->unidad_medida->ViewValue = $this->unidad_medida->Lookup !== null && is_array($this->unidad_medida->lookupOptions()) && count($this->unidad_medida->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->unidad_medida->ViewValue !== null) { // Load from cache
                $this->unidad_medida->EditValue = array_values($this->unidad_medida->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->unidad_medida->CurrentValue, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unidad_medida->EditValue = $arwrk;
            }
            $this->unidad_medida->PlaceHolder = RemoveHtml($this->unidad_medida->caption());

            // cantidad
            $this->cantidad->setupEditAttributes();
            $this->cantidad->EditValue = $this->cantidad->CurrentValue;
            $this->cantidad->PlaceHolder = RemoveHtml($this->cantidad->caption());
            if (strval($this->cantidad->EditValue) != "" && is_numeric($this->cantidad->EditValue)) {
                $this->cantidad->EditValue = FormatNumber($this->cantidad->EditValue, null);
            }

            // descripcion
            $this->descripcion->setupEditAttributes();
            if (!$this->descripcion->Raw) {
                $this->descripcion->CurrentValue = HtmlDecode($this->descripcion->CurrentValue);
            }
            $this->descripcion->EditValue = HtmlEncode($this->descripcion->CurrentValue);
            $this->descripcion->PlaceHolder = RemoveHtml($this->descripcion->caption());

            // imagen
            $this->imagen->setupEditAttributes();
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->ImageWidth = 120;
                $this->imagen->ImageHeight = 120;
                $this->imagen->ImageAlt = $this->imagen->alt();
                $this->imagen->ImageCssClass = "ew-image";
                $this->imagen->EditValue = $this->imagen->Upload->DbValue;
            } else {
                $this->imagen->EditValue = "";
            }
            if (!EmptyValue($this->imagen->CurrentValue)) {
                $this->imagen->Upload->FileName = $this->imagen->CurrentValue;
            }
            if (!Config("CREATE_UPLOAD_FILE_ON_COPY")) {
                $this->imagen->Upload->DbValue = null;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->imagen);
            }

            // disponible
            $this->disponible->setupEditAttributes();
            $this->disponible->EditValue = $this->disponible->options(true);
            $this->disponible->PlaceHolder = RemoveHtml($this->disponible->caption());

            // unidad_medida_recibida
            $this->unidad_medida_recibida->setupEditAttributes();
            $curVal = trim(strval($this->unidad_medida_recibida->CurrentValue));
            if ($curVal != "") {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->lookupCacheOption($curVal);
            } else {
                $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->Lookup !== null && is_array($this->unidad_medida_recibida->lookupOptions()) && count($this->unidad_medida_recibida->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->unidad_medida_recibida->ViewValue !== null) { // Load from cache
                $this->unidad_medida_recibida->EditValue = array_values($this->unidad_medida_recibida->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->unidad_medida_recibida->CurrentValue, $this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->unidad_medida_recibida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida_recibida->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->unidad_medida_recibida->EditValue = $arwrk;
            }
            $this->unidad_medida_recibida->PlaceHolder = RemoveHtml($this->unidad_medida_recibida->caption());

            // cantidad_recibida
            $this->cantidad_recibida->setupEditAttributes();
            $this->cantidad_recibida->EditValue = $this->cantidad_recibida->CurrentValue;
            $this->cantidad_recibida->PlaceHolder = RemoveHtml($this->cantidad_recibida->caption());
            if (strval($this->cantidad_recibida->EditValue) != "" && is_numeric($this->cantidad_recibida->EditValue)) {
                $this->cantidad_recibida->EditValue = FormatNumber($this->cantidad_recibida->EditValue, null);
            }

            // Add refer script

            // tipo_insumo
            $this->tipo_insumo->HrefValue = "";

            // articulo
            $this->articulo->HrefValue = "";

            // unidad_medida
            $this->unidad_medida->HrefValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";

            // descripcion
            $this->descripcion->HrefValue = "";

            // imagen
            if (!EmptyValue($this->imagen->Upload->DbValue)) {
                $this->imagen->HrefValue = GetFileUploadUrl($this->imagen, $this->imagen->htmlDecode($this->imagen->Upload->DbValue)); // Add prefix/suffix
                $this->imagen->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->imagen->HrefValue = FullUrl($this->imagen->HrefValue, "href");
                }
            } else {
                $this->imagen->HrefValue = "";
            }
            $this->imagen->ExportHrefValue = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;

            // disponible
            $this->disponible->HrefValue = "";

            // unidad_medida_recibida
            $this->unidad_medida_recibida->HrefValue = "";

            // cantidad_recibida
            $this->cantidad_recibida->HrefValue = "";
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
            if ($this->tipo_insumo->Visible && $this->tipo_insumo->Required) {
                if (!$this->tipo_insumo->IsDetailKey && EmptyValue($this->tipo_insumo->FormValue)) {
                    $this->tipo_insumo->addErrorMessage(str_replace("%s", $this->tipo_insumo->caption(), $this->tipo_insumo->RequiredErrorMessage));
                }
            }
            if ($this->articulo->Visible && $this->articulo->Required) {
                if (!$this->articulo->IsDetailKey && EmptyValue($this->articulo->FormValue)) {
                    $this->articulo->addErrorMessage(str_replace("%s", $this->articulo->caption(), $this->articulo->RequiredErrorMessage));
                }
            }
            if ($this->unidad_medida->Visible && $this->unidad_medida->Required) {
                if (!$this->unidad_medida->IsDetailKey && EmptyValue($this->unidad_medida->FormValue)) {
                    $this->unidad_medida->addErrorMessage(str_replace("%s", $this->unidad_medida->caption(), $this->unidad_medida->RequiredErrorMessage));
                }
            }
            if ($this->cantidad->Visible && $this->cantidad->Required) {
                if (!$this->cantidad->IsDetailKey && EmptyValue($this->cantidad->FormValue)) {
                    $this->cantidad->addErrorMessage(str_replace("%s", $this->cantidad->caption(), $this->cantidad->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->cantidad->FormValue)) {
                $this->cantidad->addErrorMessage($this->cantidad->getErrorMessage(false));
            }
            if ($this->descripcion->Visible && $this->descripcion->Required) {
                if (!$this->descripcion->IsDetailKey && EmptyValue($this->descripcion->FormValue)) {
                    $this->descripcion->addErrorMessage(str_replace("%s", $this->descripcion->caption(), $this->descripcion->RequiredErrorMessage));
                }
            }
            if ($this->imagen->Visible && $this->imagen->Required) {
                if ($this->imagen->Upload->FileName == "" && !$this->imagen->Upload->KeepFile) {
                    $this->imagen->addErrorMessage(str_replace("%s", $this->imagen->caption(), $this->imagen->RequiredErrorMessage));
                }
            }
            if ($this->disponible->Visible && $this->disponible->Required) {
                if (!$this->disponible->IsDetailKey && EmptyValue($this->disponible->FormValue)) {
                    $this->disponible->addErrorMessage(str_replace("%s", $this->disponible->caption(), $this->disponible->RequiredErrorMessage));
                }
            }
            if ($this->unidad_medida_recibida->Visible && $this->unidad_medida_recibida->Required) {
                if (!$this->unidad_medida_recibida->IsDetailKey && EmptyValue($this->unidad_medida_recibida->FormValue)) {
                    $this->unidad_medida_recibida->addErrorMessage(str_replace("%s", $this->unidad_medida_recibida->caption(), $this->unidad_medida_recibida->RequiredErrorMessage));
                }
            }
            if ($this->cantidad_recibida->Visible && $this->cantidad_recibida->Required) {
                if (!$this->cantidad_recibida->IsDetailKey && EmptyValue($this->cantidad_recibida->FormValue)) {
                    $this->cantidad_recibida->addErrorMessage(str_replace("%s", $this->cantidad_recibida->caption(), $this->cantidad_recibida->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->cantidad_recibida->FormValue)) {
                $this->cantidad_recibida->addErrorMessage($this->cantidad_recibida->getErrorMessage(false));
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
        if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
            if (!EmptyValue($this->imagen->Upload->FileName)) {
                $this->imagen->Upload->DbValue = null;
                FixUploadFileNames($this->imagen);
                $this->imagen->setDbValueDef($rsnew, $this->imagen->Upload->FileName, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check referential integrity for master table 'sco_orden_compra_detalle'
        $validMasterRecord = true;
        $detailKeys = [];
        $detailKeys["orden_compra"] = $this->orden_compra->getSessionValue();
        $masterTable = Container("sco_orden_compra");
        $masterFilter = $this->getMasterFilter($masterTable, $detailKeys);
        if (!EmptyValue($masterFilter)) {
            $rsmaster = $masterTable->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        } else { // Allow null value if not required field
            $validMasterRecord = $masterFilter === null;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "sco_orden_compra", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
                    $this->imagen->Upload->DbValue = null;
                    if (!SaveUploadFiles($this->imagen, $rsnew['imagen'], false)) {
                        $this->setFailureMessage($Language->phrase("UploadError7"));
                        return false;
                    }
                }
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

        // tipo_insumo
        $this->tipo_insumo->setDbValueDef($rsnew, $this->tipo_insumo->CurrentValue, false);

        // articulo
        $this->articulo->setDbValueDef($rsnew, $this->articulo->CurrentValue, false);

        // unidad_medida
        $this->unidad_medida->setDbValueDef($rsnew, $this->unidad_medida->CurrentValue, false);

        // cantidad
        $this->cantidad->setDbValueDef($rsnew, $this->cantidad->CurrentValue, false);

        // descripcion
        $this->descripcion->setDbValueDef($rsnew, $this->descripcion->CurrentValue, false);

        // imagen
        if ($this->imagen->Visible && !$this->imagen->Upload->KeepFile) {
            if ($this->imagen->Upload->FileName == "") {
                $rsnew['imagen'] = null;
            } else {
                FixUploadTempFileNames($this->imagen);
                $rsnew['imagen'] = $this->imagen->Upload->FileName;
            }
        }

        // disponible
        $this->disponible->setDbValueDef($rsnew, $this->disponible->CurrentValue, strval($this->disponible->CurrentValue) == "");

        // unidad_medida_recibida
        $this->unidad_medida_recibida->setDbValueDef($rsnew, $this->unidad_medida_recibida->CurrentValue, false);

        // cantidad_recibida
        $this->cantidad_recibida->setDbValueDef($rsnew, $this->cantidad_recibida->CurrentValue, false);

        // orden_compra
        if ($this->orden_compra->getSessionValue() != "") {
            $rsnew['orden_compra'] = $this->orden_compra->getSessionValue();
        }
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['tipo_insumo'])) { // tipo_insumo
            $this->tipo_insumo->setFormValue($row['tipo_insumo']);
        }
        if (isset($row['articulo'])) { // articulo
            $this->articulo->setFormValue($row['articulo']);
        }
        if (isset($row['unidad_medida'])) { // unidad_medida
            $this->unidad_medida->setFormValue($row['unidad_medida']);
        }
        if (isset($row['cantidad'])) { // cantidad
            $this->cantidad->setFormValue($row['cantidad']);
        }
        if (isset($row['descripcion'])) { // descripcion
            $this->descripcion->setFormValue($row['descripcion']);
        }
        if (isset($row['imagen'])) { // imagen
            $this->imagen->setFormValue($row['imagen']);
        }
        if (isset($row['disponible'])) { // disponible
            $this->disponible->setFormValue($row['disponible']);
        }
        if (isset($row['unidad_medida_recibida'])) { // unidad_medida_recibida
            $this->unidad_medida_recibida->setFormValue($row['unidad_medida_recibida']);
        }
        if (isset($row['cantidad_recibida'])) { // cantidad_recibida
            $this->cantidad_recibida->setFormValue($row['cantidad_recibida']);
        }
        if (isset($row['orden_compra'])) { // orden_compra
            $this->orden_compra->setFormValue($row['orden_compra']);
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
            if ($masterTblVar == "sco_orden_compra") {
                $validMaster = true;
                $masterTbl = Container("sco_orden_compra");
                if (($parm = Get("fk_Norden_compra", Get("orden_compra"))) !== null) {
                    $masterTbl->Norden_compra->setQueryStringValue($parm);
                    $this->orden_compra->QueryStringValue = $masterTbl->Norden_compra->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->orden_compra->setSessionValue($this->orden_compra->QueryStringValue);
                    $foreignKeys["orden_compra"] = $this->orden_compra->QueryStringValue;
                    if (!is_numeric($masterTbl->Norden_compra->QueryStringValue)) {
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
            if ($masterTblVar == "sco_orden_compra") {
                $validMaster = true;
                $masterTbl = Container("sco_orden_compra");
                if (($parm = Post("fk_Norden_compra", Post("orden_compra"))) !== null) {
                    $masterTbl->Norden_compra->setFormValue($parm);
                    $this->orden_compra->FormValue = $masterTbl->Norden_compra->FormValue;
                    $this->orden_compra->setSessionValue($this->orden_compra->FormValue);
                    $foreignKeys["orden_compra"] = $this->orden_compra->FormValue;
                    if (!is_numeric($masterTbl->Norden_compra->FormValue)) {
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

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "sco_orden_compra") {
                if (!array_key_exists("orden_compra", $foreignKeys)) { // Not current foreign key
                    $this->orden_compra->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoOrdenCompraDetalleList"), "", $this->TableVar, true);
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
                case "x_tipo_insumo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_articulo":
                    break;
                case "x_unidad_medida":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_disponible":
                    break;
                case "x_unidad_medida_recibida":
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
