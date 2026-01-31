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
class ScoExpedienteAdd extends ScoExpediente
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteAdd";

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
        $this->Nexpediente->Visible = false;
        $this->contrato_parcela->setVisibility();
        $this->tipo_contratacion->Visible = false;
        $this->seguro->setVisibility();
        $this->nacionalidad_contacto->Visible = false;
        $this->cedula_contacto->Visible = false;
        $this->nombre_contacto->setVisibility();
        $this->apellidos_contacto->Visible = false;
        $this->parentesco_contacto->setVisibility();
        $this->telefono_contacto1->setVisibility();
        $this->telefono_contacto2->setVisibility();
        $this->_email->setVisibility();
        $this->nacionalidad_fallecido->Visible = false;
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
        $this->religion->setVisibility();
        $this->permiso->setVisibility();
        $this->costos->Visible = false;
        $this->venta->Visible = false;
        $this->user_registra->Visible = false;
        $this->fecha_registro->Visible = false;
        $this->user_cierra->Visible = false;
        $this->fecha_cierre->Visible = false;
        $this->calidad->Visible = false;
        $this->factura->Visible = false;
        $this->unir_con_expediente->Visible = false;
        $this->estatus->Visible = false;
        $this->nota->setVisibility();
        $this->funeraria->setVisibility();
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->marca_pasos->setVisibility();
        $this->peso->setVisibility();
        $this->autoriza_cremar->Visible = false;
        $this->certificado_defuncion->setVisibility();
        $this->parcela->setVisibility();
        $this->username_autoriza->Visible = false;
        $this->fecha_autoriza->Visible = false;
        $this->email_calidad->Visible = false;
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_expediente';
        $this->TableName = 'sco_expediente';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_expediente)
        if (!isset($GLOBALS["sco_expediente"]) || $GLOBALS["sco_expediente"]::class == PROJECT_NAMESPACE . "sco_expediente") {
            $GLOBALS["sco_expediente"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente');
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
                        $result["view"] = SameString($pageName, "ScoExpedienteView"); // If View page, no primary button
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
            $key .= @$ar['Nexpediente'];
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
            $this->Nexpediente->Visible = false;
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
        $this->setupLookupOptions($this->tipo_contratacion);
        $this->setupLookupOptions($this->seguro);
        $this->setupLookupOptions($this->nacionalidad_contacto);
        $this->setupLookupOptions($this->parentesco_contacto);
        $this->setupLookupOptions($this->nacionalidad_fallecido);
        $this->setupLookupOptions($this->sexo);
        $this->setupLookupOptions($this->estado_civil);
        $this->setupLookupOptions($this->lugar_ocurrencia);
        $this->setupLookupOptions($this->causa_ocurrencia);
        $this->setupLookupOptions($this->religion);
        $this->setupLookupOptions($this->user_registra);
        $this->setupLookupOptions($this->calidad);
        $this->setupLookupOptions($this->unir_con_expediente);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->funeraria);
        $this->setupLookupOptions($this->servicio_tipo);
        $this->setupLookupOptions($this->servicio);
        $this->setupLookupOptions($this->marca_pasos);
        $this->setupLookupOptions($this->peso);
        $this->setupLookupOptions($this->autoriza_cremar);
        $this->setupLookupOptions($this->username_autoriza);
        $this->setupLookupOptions($this->email_calidad);

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
            if (($keyValue = Get("Nexpediente") ?? Route("Nexpediente")) !== null) {
                $this->Nexpediente->setQueryStringValue($keyValue);
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
                    $this->terminate("ScoExpedienteList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ScoExpedienteList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ScoExpedienteView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "ScoExpedienteList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoExpedienteList"; // Return list page content
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
        $this->venta->DefaultValue = $this->venta->getDefault(); // PHP
        $this->venta->OldValue = $this->venta->DefaultValue;
        $this->estatus->DefaultValue = $this->estatus->getDefault(); // PHP
        $this->estatus->OldValue = $this->estatus->DefaultValue;
        $this->autoriza_cremar->DefaultValue = $this->autoriza_cremar->getDefault(); // PHP
        $this->autoriza_cremar->OldValue = $this->autoriza_cremar->DefaultValue;
        $this->email_calidad->DefaultValue = $this->email_calidad->getDefault(); // PHP
        $this->email_calidad->OldValue = $this->email_calidad->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'contrato_parcela' first before field var 'x_contrato_parcela'
        $val = $CurrentForm->hasValue("contrato_parcela") ? $CurrentForm->getValue("contrato_parcela") : $CurrentForm->getValue("x_contrato_parcela");
        if (!$this->contrato_parcela->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contrato_parcela->Visible = false; // Disable update for API request
            } else {
                $this->contrato_parcela->setFormValue($val);
            }
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

        // Check field name 'religion' first before field var 'x_religion'
        $val = $CurrentForm->hasValue("religion") ? $CurrentForm->getValue("religion") : $CurrentForm->getValue("x_religion");
        if (!$this->religion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->religion->Visible = false; // Disable update for API request
            } else {
                $this->religion->setFormValue($val);
            }
        }

        // Check field name 'permiso' first before field var 'x_permiso'
        $val = $CurrentForm->hasValue("permiso") ? $CurrentForm->getValue("permiso") : $CurrentForm->getValue("x_permiso");
        if (!$this->permiso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->permiso->Visible = false; // Disable update for API request
            } else {
                $this->permiso->setFormValue($val);
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

        // Check field name 'funeraria' first before field var 'x_funeraria'
        $val = $CurrentForm->hasValue("funeraria") ? $CurrentForm->getValue("funeraria") : $CurrentForm->getValue("x_funeraria");
        if (!$this->funeraria->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->funeraria->Visible = false; // Disable update for API request
            } else {
                $this->funeraria->setFormValue($val);
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

        // Check field name 'marca_pasos' first before field var 'x_marca_pasos'
        $val = $CurrentForm->hasValue("marca_pasos") ? $CurrentForm->getValue("marca_pasos") : $CurrentForm->getValue("x_marca_pasos");
        if (!$this->marca_pasos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->marca_pasos->Visible = false; // Disable update for API request
            } else {
                $this->marca_pasos->setFormValue($val);
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

        // Check field name 'certificado_defuncion' first before field var 'x_certificado_defuncion'
        $val = $CurrentForm->hasValue("certificado_defuncion") ? $CurrentForm->getValue("certificado_defuncion") : $CurrentForm->getValue("x_certificado_defuncion");
        if (!$this->certificado_defuncion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->certificado_defuncion->Visible = false; // Disable update for API request
            } else {
                $this->certificado_defuncion->setFormValue($val);
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

        // Check field name 'Nexpediente' first before field var 'x_Nexpediente'
        $val = $CurrentForm->hasValue("Nexpediente") ? $CurrentForm->getValue("Nexpediente") : $CurrentForm->getValue("x_Nexpediente");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->contrato_parcela->CurrentValue = $this->contrato_parcela->FormValue;
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
        $this->religion->CurrentValue = $this->religion->FormValue;
        $this->permiso->CurrentValue = $this->permiso->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->funeraria->CurrentValue = $this->funeraria->FormValue;
        $this->servicio_tipo->CurrentValue = $this->servicio_tipo->FormValue;
        $this->servicio->CurrentValue = $this->servicio->FormValue;
        $this->marca_pasos->CurrentValue = $this->marca_pasos->FormValue;
        $this->peso->CurrentValue = $this->peso->FormValue;
        $this->certificado_defuncion->CurrentValue = $this->certificado_defuncion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
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
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->contrato_parcela->setDbValue($row['contrato_parcela']);
        $this->tipo_contratacion->setDbValue($row['tipo_contratacion']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nacionalidad_contacto->setDbValue($row['nacionalidad_contacto']);
        $this->cedula_contacto->setDbValue($row['cedula_contacto']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->apellidos_contacto->setDbValue($row['apellidos_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->_email->setDbValue($row['email']);
        $this->nacionalidad_fallecido->setDbValue($row['nacionalidad_fallecido']);
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
        $this->religion->setDbValue($row['religion']);
        $this->permiso->setDbValue($row['permiso']);
        $this->costos->setDbValue($row['costos']);
        $this->venta->setDbValue($row['venta']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_cierra->setDbValue($row['user_cierra']);
        $this->fecha_cierre->setDbValue($row['fecha_cierre']);
        $this->calidad->setDbValue($row['calidad']);
        $this->factura->setDbValue($row['factura']);
        $this->unir_con_expediente->setDbValue($row['unir_con_expediente']);
        $this->estatus->setDbValue($row['estatus']);
        $this->nota->setDbValue($row['nota']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->marca_pasos->setDbValue($row['marca_pasos']);
        $this->peso->setDbValue($row['peso']);
        $this->autoriza_cremar->setDbValue($row['autoriza_cremar']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->username_autoriza->setDbValue($row['username_autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->email_calidad->setDbValue($row['email_calidad']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente'] = $this->Nexpediente->DefaultValue;
        $row['contrato_parcela'] = $this->contrato_parcela->DefaultValue;
        $row['tipo_contratacion'] = $this->tipo_contratacion->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nacionalidad_contacto'] = $this->nacionalidad_contacto->DefaultValue;
        $row['cedula_contacto'] = $this->cedula_contacto->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['apellidos_contacto'] = $this->apellidos_contacto->DefaultValue;
        $row['parentesco_contacto'] = $this->parentesco_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['nacionalidad_fallecido'] = $this->nacionalidad_fallecido->DefaultValue;
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
        $row['religion'] = $this->religion->DefaultValue;
        $row['permiso'] = $this->permiso->DefaultValue;
        $row['costos'] = $this->costos->DefaultValue;
        $row['venta'] = $this->venta->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['user_cierra'] = $this->user_cierra->DefaultValue;
        $row['fecha_cierre'] = $this->fecha_cierre->DefaultValue;
        $row['calidad'] = $this->calidad->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['unir_con_expediente'] = $this->unir_con_expediente->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['marca_pasos'] = $this->marca_pasos->DefaultValue;
        $row['peso'] = $this->peso->DefaultValue;
        $row['autoriza_cremar'] = $this->autoriza_cremar->DefaultValue;
        $row['certificado_defuncion'] = $this->certificado_defuncion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
        $row['username_autoriza'] = $this->username_autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
        $row['email_calidad'] = $this->email_calidad->DefaultValue;
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

        // Nexpediente
        $this->Nexpediente->RowCssClass = "row";

        // contrato_parcela
        $this->contrato_parcela->RowCssClass = "row";

        // tipo_contratacion
        $this->tipo_contratacion->RowCssClass = "row";

        // seguro
        $this->seguro->RowCssClass = "row";

        // nacionalidad_contacto
        $this->nacionalidad_contacto->RowCssClass = "row";

        // cedula_contacto
        $this->cedula_contacto->RowCssClass = "row";

        // nombre_contacto
        $this->nombre_contacto->RowCssClass = "row";

        // apellidos_contacto
        $this->apellidos_contacto->RowCssClass = "row";

        // parentesco_contacto
        $this->parentesco_contacto->RowCssClass = "row";

        // telefono_contacto1
        $this->telefono_contacto1->RowCssClass = "row";

        // telefono_contacto2
        $this->telefono_contacto2->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->RowCssClass = "row";

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

        // religion
        $this->religion->RowCssClass = "row";

        // permiso
        $this->permiso->RowCssClass = "row";

        // costos
        $this->costos->RowCssClass = "row";

        // venta
        $this->venta->RowCssClass = "row";

        // user_registra
        $this->user_registra->RowCssClass = "row";

        // fecha_registro
        $this->fecha_registro->RowCssClass = "row";

        // user_cierra
        $this->user_cierra->RowCssClass = "row";

        // fecha_cierre
        $this->fecha_cierre->RowCssClass = "row";

        // calidad
        $this->calidad->RowCssClass = "row";

        // factura
        $this->factura->RowCssClass = "row";

        // unir_con_expediente
        $this->unir_con_expediente->RowCssClass = "row";

        // estatus
        $this->estatus->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // funeraria
        $this->funeraria->RowCssClass = "row";

        // servicio_tipo
        $this->servicio_tipo->RowCssClass = "row";

        // servicio
        $this->servicio->RowCssClass = "row";

        // marca_pasos
        $this->marca_pasos->RowCssClass = "row";

        // peso
        $this->peso->RowCssClass = "row";

        // autoriza_cremar
        $this->autoriza_cremar->RowCssClass = "row";

        // certificado_defuncion
        $this->certificado_defuncion->RowCssClass = "row";

        // parcela
        $this->parcela->RowCssClass = "row";

        // username_autoriza
        $this->username_autoriza->RowCssClass = "row";

        // fecha_autoriza
        $this->fecha_autoriza->RowCssClass = "row";

        // email_calidad
        $this->email_calidad->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente
            $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

            // contrato_parcela
            $this->contrato_parcela->ViewValue = $this->contrato_parcela->CurrentValue;
            $this->contrato_parcela->ImageAlt = $this->contrato_parcela->alt();
                $this->contrato_parcela->ImageCssClass = "ew-image";

            // tipo_contratacion
            $curVal = strval($this->tipo_contratacion->CurrentValue);
            if ($curVal != "") {
                $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->lookupCacheOption($curVal);
                if ($this->tipo_contratacion->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->tipo_contratacion->Lookup->getTable()->Fields["tipo_contratacion"]->searchExpression(), "=", $curVal, $this->tipo_contratacion->Lookup->getTable()->Fields["tipo_contratacion"]->searchDataType(), "");
                    $sqlWrk = $this->tipo_contratacion->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->tipo_contratacion->Lookup->renderViewRow($rswrk[0]);
                        $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->displayValue($arwrk);
                    } else {
                        $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->CurrentValue;
                    }
                }
            } else {
                $this->tipo_contratacion->ViewValue = null;
            }

            // seguro
            $curVal = strval($this->seguro->CurrentValue);
            if ($curVal != "") {
                $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
                if ($this->seguro->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                    $lookupFilter = $this->seguro->getSelectFilter($this); // PHP
                    $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

            // nacionalidad_contacto
            if (strval($this->nacionalidad_contacto->CurrentValue) != "") {
                $this->nacionalidad_contacto->ViewValue = $this->nacionalidad_contacto->optionCaption($this->nacionalidad_contacto->CurrentValue);
            } else {
                $this->nacionalidad_contacto->ViewValue = null;
            }

            // cedula_contacto
            $this->cedula_contacto->ViewValue = $this->cedula_contacto->CurrentValue;

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // apellidos_contacto
            $this->apellidos_contacto->ViewValue = $this->apellidos_contacto->CurrentValue;

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

            // nacionalidad_fallecido
            if (strval($this->nacionalidad_fallecido->CurrentValue) != "") {
                $this->nacionalidad_fallecido->ViewValue = $this->nacionalidad_fallecido->optionCaption($this->nacionalidad_fallecido->CurrentValue);
            } else {
                $this->nacionalidad_fallecido->ViewValue = null;
            }
            $this->nacionalidad_fallecido->CssClass = "fw-bold";

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;
            $this->cedula_fallecido->CssClass = "fw-bold";

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;
            $this->nombre_fallecido->CssClass = "fw-bold";

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;
            $this->apellidos_fallecido->CssClass = "fw-bold";

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
                    $sqlWrk = $this->estado_civil->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
            $this->estado_civil->CssClass = "fw-bold";

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;
            $this->lugar_nacimiento_fallecido->CssClass = "fw-bold";

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
            $this->hora_ocurrencia->ViewValue = FormatDateTime($this->hora_ocurrencia->ViewValue, $this->hora_ocurrencia->formatPattern());
            $this->hora_ocurrencia->CssClass = "fw-bold";

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

            // permiso
            $this->permiso->ViewValue = $this->permiso->CurrentValue;

            // costos
            $this->costos->ViewValue = $this->costos->CurrentValue;
            $this->costos->ViewValue = FormatCurrency($this->costos->ViewValue, $this->costos->formatPattern());

            // venta
            $this->venta->ViewValue = $this->venta->CurrentValue;
            $this->venta->ViewValue = FormatNumber($this->venta->ViewValue, $this->venta->formatPattern());

            // user_registra
            $this->user_registra->ViewValue = $this->user_registra->CurrentValue;
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

            // user_cierra
            $this->user_cierra->ViewValue = $this->user_cierra->CurrentValue;

            // fecha_cierre
            $this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
            $this->fecha_cierre->ViewValue = FormatDateTime($this->fecha_cierre->ViewValue, $this->fecha_cierre->formatPattern());

            // calidad
            $curVal = strval($this->calidad->CurrentValue);
            if ($curVal != "") {
                $this->calidad->ViewValue = $this->calidad->lookupCacheOption($curVal);
                if ($this->calidad->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->calidad->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->calidad->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                    $lookupFilter = $this->calidad->getSelectFilter($this); // PHP
                    $sqlWrk = $this->calidad->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->calidad->Lookup->renderViewRow($rswrk[0]);
                        $this->calidad->ViewValue = $this->calidad->displayValue($arwrk);
                    } else {
                        $this->calidad->ViewValue = $this->calidad->CurrentValue;
                    }
                }
            } else {
                $this->calidad->ViewValue = null;
            }

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // unir_con_expediente
            $curVal = strval($this->unir_con_expediente->CurrentValue);
            if ($curVal != "") {
                $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->lookupCacheOption($curVal);
                if ($this->unir_con_expediente->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->unir_con_expediente->Lookup->getTable()->Fields["Nexpediente"]->searchExpression(), "=", $curVal, $this->unir_con_expediente->Lookup->getTable()->Fields["Nexpediente"]->searchDataType(), "");
                    $lookupFilter = $this->unir_con_expediente->getSelectFilter($this); // PHP
                    $sqlWrk = $this->unir_con_expediente->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->unir_con_expediente->Lookup->renderViewRow($rswrk[0]);
                        $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->displayValue($arwrk);
                    } else {
                        $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->CurrentValue;
                    }
                }
            } else {
                $this->unir_con_expediente->ViewValue = null;
            }

            // estatus
            $curVal = strval($this->estatus->CurrentValue);
            if ($curVal != "") {
                $this->estatus->ViewValue = $this->estatus->lookupCacheOption($curVal);
                if ($this->estatus->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["Nstatus"]->searchExpression(), "=", $curVal, $this->estatus->Lookup->getTable()->Fields["Nstatus"]->searchDataType(), "");
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
            $this->estatus->CssClass = "fw-bold";

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // funeraria
            if (strval($this->funeraria->CurrentValue) != "") {
                $this->funeraria->ViewValue = $this->funeraria->optionCaption($this->funeraria->CurrentValue);
            } else {
                $this->funeraria->ViewValue = null;
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

            // marca_pasos
            if (strval($this->marca_pasos->CurrentValue) != "") {
                $this->marca_pasos->ViewValue = $this->marca_pasos->optionCaption($this->marca_pasos->CurrentValue);
            } else {
                $this->marca_pasos->ViewValue = null;
            }

            // peso
            $curVal = strval($this->peso->CurrentValue);
            if ($curVal != "") {
                $this->peso->ViewValue = $this->peso->lookupCacheOption($curVal);
                if ($this->peso->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->peso->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->peso->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                    $lookupFilter = $this->peso->getSelectFilter($this); // PHP
                    $sqlWrk = $this->peso->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->peso->Lookup->renderViewRow($rswrk[0]);
                        $this->peso->ViewValue = $this->peso->displayValue($arwrk);
                    } else {
                        $this->peso->ViewValue = $this->peso->CurrentValue;
                    }
                }
            } else {
                $this->peso->ViewValue = null;
            }

            // autoriza_cremar
            if (strval($this->autoriza_cremar->CurrentValue) != "") {
                $this->autoriza_cremar->ViewValue = $this->autoriza_cremar->optionCaption($this->autoriza_cremar->CurrentValue);
            } else {
                $this->autoriza_cremar->ViewValue = null;
            }

            // certificado_defuncion
            $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // username_autoriza
            $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;
            $curVal = strval($this->username_autoriza->CurrentValue);
            if ($curVal != "") {
                $this->username_autoriza->ViewValue = $this->username_autoriza->lookupCacheOption($curVal);
                if ($this->username_autoriza->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->username_autoriza->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->username_autoriza->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->username_autoriza->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->username_autoriza->Lookup->renderViewRow($rswrk[0]);
                        $this->username_autoriza->ViewValue = $this->username_autoriza->displayValue($arwrk);
                    } else {
                        $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;
                    }
                }
            } else {
                $this->username_autoriza->ViewValue = null;
            }

            // fecha_autoriza
            $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
            $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

            // email_calidad
            if (strval($this->email_calidad->CurrentValue) != "") {
                $this->email_calidad->ViewValue = $this->email_calidad->optionCaption($this->email_calidad->CurrentValue);
            } else {
                $this->email_calidad->ViewValue = null;
            }

            // contrato_parcela
            $this->contrato_parcela->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";

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

            // religion
            $this->religion->HrefValue = "";

            // permiso
            $this->permiso->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // marca_pasos
            $this->marca_pasos->HrefValue = "";

            // peso
            $this->peso->HrefValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";

            // parcela
            $this->parcela->HrefValue = "";
        } elseif ($this->RowType == RowType::ADD) {
            // contrato_parcela
            $this->contrato_parcela->setupEditAttributes();
            if (!$this->contrato_parcela->Raw) {
                $this->contrato_parcela->CurrentValue = HtmlDecode($this->contrato_parcela->CurrentValue);
            }
            $this->contrato_parcela->EditValue = HtmlEncode($this->contrato_parcela->CurrentValue);
            $this->contrato_parcela->PlaceHolder = RemoveHtml($this->contrato_parcela->caption());

            // seguro
            $curVal = trim(strval($this->seguro->CurrentValue));
            if ($curVal != "") {
                $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
            } else {
                $this->seguro->ViewValue = $this->seguro->Lookup !== null && is_array($this->seguro->lookupOptions()) && count($this->seguro->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->seguro->ViewValue !== null) { // Load from cache
                $this->seguro->EditValue = array_values($this->seguro->lookupOptions());
                if ($this->seguro->ViewValue == "") {
                    $this->seguro->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $this->seguro->CurrentValue, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                }
                $lookupFilter = $this->seguro->getSelectFilter($this); // PHP
                $sqlWrk = $this->seguro->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->seguro->Lookup->renderViewRow($rswrk[0]);
                    $this->seguro->ViewValue = $this->seguro->displayValue($arwrk);
                } else {
                    $this->seguro->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->seguro->EditValue = $arwrk;
            }
            $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());

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
            $curVal = trim(strval($this->causa_ocurrencia->CurrentValue));
            if ($curVal != "") {
                $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->lookupCacheOption($curVal);
            } else {
                $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->Lookup !== null && is_array($this->causa_ocurrencia->lookupOptions()) && count($this->causa_ocurrencia->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->causa_ocurrencia->ViewValue !== null) { // Load from cache
                $this->causa_ocurrencia->EditValue = array_values($this->causa_ocurrencia->lookupOptions());
                if ($this->causa_ocurrencia->ViewValue == "") {
                    $this->causa_ocurrencia->ViewValue = $Language->phrase("PleaseSelect");
                }
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
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->causa_ocurrencia->Lookup->renderViewRow($rswrk[0]);
                    $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->displayValue($arwrk);
                } else {
                    $this->causa_ocurrencia->ViewValue = $Language->phrase("PleaseSelect");
                }
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

            // permiso
            $this->permiso->setupEditAttributes();
            if (!$this->permiso->Raw) {
                $this->permiso->CurrentValue = HtmlDecode($this->permiso->CurrentValue);
            }
            $this->permiso->EditValue = HtmlEncode($this->permiso->CurrentValue);
            $this->permiso->PlaceHolder = RemoveHtml($this->permiso->caption());

            // nota
            $this->nota->setupEditAttributes();
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            $this->funeraria->EditValue = $this->funeraria->options(true);
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

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

            // marca_pasos
            $this->marca_pasos->setupEditAttributes();
            $this->marca_pasos->EditValue = $this->marca_pasos->options(true);
            $this->marca_pasos->PlaceHolder = RemoveHtml($this->marca_pasos->caption());

            // peso
            $this->peso->setupEditAttributes();
            $curVal = trim(strval($this->peso->CurrentValue));
            if ($curVal != "") {
                $this->peso->ViewValue = $this->peso->lookupCacheOption($curVal);
            } else {
                $this->peso->ViewValue = $this->peso->Lookup !== null && is_array($this->peso->lookupOptions()) && count($this->peso->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->peso->ViewValue !== null) { // Load from cache
                $this->peso->EditValue = array_values($this->peso->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter($this->peso->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $this->peso->CurrentValue, $this->peso->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                }
                $lookupFilter = $this->peso->getSelectFilter($this); // PHP
                $sqlWrk = $this->peso->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->peso->EditValue = $arwrk;
            }
            $this->peso->PlaceHolder = RemoveHtml($this->peso->caption());

            // certificado_defuncion
            $this->certificado_defuncion->setupEditAttributes();
            if (!$this->certificado_defuncion->Raw) {
                $this->certificado_defuncion->CurrentValue = HtmlDecode($this->certificado_defuncion->CurrentValue);
            }
            $this->certificado_defuncion->EditValue = HtmlEncode($this->certificado_defuncion->CurrentValue);
            $this->certificado_defuncion->PlaceHolder = RemoveHtml($this->certificado_defuncion->caption());

            // parcela
            $this->parcela->setupEditAttributes();
            if (!$this->parcela->Raw) {
                $this->parcela->CurrentValue = HtmlDecode($this->parcela->CurrentValue);
            }
            $this->parcela->EditValue = HtmlEncode($this->parcela->CurrentValue);
            $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

            // Add refer script

            // contrato_parcela
            $this->contrato_parcela->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";

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

            // religion
            $this->religion->HrefValue = "";

            // permiso
            $this->permiso->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // marca_pasos
            $this->marca_pasos->HrefValue = "";

            // peso
            $this->peso->HrefValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";

            // parcela
            $this->parcela->HrefValue = "";
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
            if ($this->contrato_parcela->Visible && $this->contrato_parcela->Required) {
                if (!$this->contrato_parcela->IsDetailKey && EmptyValue($this->contrato_parcela->FormValue)) {
                    $this->contrato_parcela->addErrorMessage(str_replace("%s", $this->contrato_parcela->caption(), $this->contrato_parcela->RequiredErrorMessage));
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
            if ($this->religion->Visible && $this->religion->Required) {
                if (!$this->religion->IsDetailKey && EmptyValue($this->religion->FormValue)) {
                    $this->religion->addErrorMessage(str_replace("%s", $this->religion->caption(), $this->religion->RequiredErrorMessage));
                }
            }
            if ($this->permiso->Visible && $this->permiso->Required) {
                if (!$this->permiso->IsDetailKey && EmptyValue($this->permiso->FormValue)) {
                    $this->permiso->addErrorMessage(str_replace("%s", $this->permiso->caption(), $this->permiso->RequiredErrorMessage));
                }
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->funeraria->Visible && $this->funeraria->Required) {
                if (!$this->funeraria->IsDetailKey && EmptyValue($this->funeraria->FormValue)) {
                    $this->funeraria->addErrorMessage(str_replace("%s", $this->funeraria->caption(), $this->funeraria->RequiredErrorMessage));
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
            if ($this->marca_pasos->Visible && $this->marca_pasos->Required) {
                if (!$this->marca_pasos->IsDetailKey && EmptyValue($this->marca_pasos->FormValue)) {
                    $this->marca_pasos->addErrorMessage(str_replace("%s", $this->marca_pasos->caption(), $this->marca_pasos->RequiredErrorMessage));
                }
            }
            if ($this->peso->Visible && $this->peso->Required) {
                if (!$this->peso->IsDetailKey && EmptyValue($this->peso->FormValue)) {
                    $this->peso->addErrorMessage(str_replace("%s", $this->peso->caption(), $this->peso->RequiredErrorMessage));
                }
            }
            if ($this->certificado_defuncion->Visible && $this->certificado_defuncion->Required) {
                if (!$this->certificado_defuncion->IsDetailKey && EmptyValue($this->certificado_defuncion->FormValue)) {
                    $this->certificado_defuncion->addErrorMessage(str_replace("%s", $this->certificado_defuncion->caption(), $this->certificado_defuncion->RequiredErrorMessage));
                }
            }
            if ($this->parcela->Visible && $this->parcela->Required) {
                if (!$this->parcela->IsDetailKey && EmptyValue($this->parcela->FormValue)) {
                    $this->parcela->addErrorMessage(str_replace("%s", $this->parcela->caption(), $this->parcela->RequiredErrorMessage));
                }
            }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("ScoOrdenGrid");
        if (in_array("sco_orden", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoSeguimientoGrid");
        if (in_array("sco_seguimiento", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoExpedienteEstatusGrid");
        if (in_array("sco_expediente_estatus", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoAdjuntoGrid");
        if (in_array("sco_adjunto", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoCremacionEstatusGrid");
        if (in_array("sco_cremacion_estatus", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoParcelaGrid");
        if (in_array("sco_parcela", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoExpedienteEncuestaCalidadGrid");
        if (in_array("sco_expediente_encuesta_calidad", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoExpedienteCiaGrid");
        if (in_array("sco_expediente_cia", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoEmbalajeGrid");
        if (in_array("sco_embalaje", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoReembolsoGrid");
        if (in_array("sco_reembolso", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->run();
            $validateForm = $validateForm && $detailPage->validateGridForm();
        }
        $detailPage = Container("ScoNotaGrid");
        if (in_array("sco_nota", $detailTblVar) && $detailPage->DetailAdd) {
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
        if ($this->cedula_fallecido->CurrentValue != "") { // Check field with unique index
            $filter = "(`cedula_fallecido` = '" . AdjustSql($this->cedula_fallecido->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->cedula_fallecido->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->cedula_fallecido->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
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
            $detailPage = Container("ScoOrdenGrid");
            if (in_array("sco_orden", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_orden"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoSeguimientoGrid");
            if (in_array("sco_seguimiento", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_seguimiento"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoExpedienteEstatusGrid");
            if (in_array("sco_expediente_estatus", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_expediente_estatus"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoAdjuntoGrid");
            if (in_array("sco_adjunto", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_adjunto"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoCremacionEstatusGrid");
            if (in_array("sco_cremacion_estatus", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_cremacion_estatus"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoParcelaGrid");
            if (in_array("sco_parcela", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->contrato->setSessionValue($this->contrato_parcela->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_parcela"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->contrato->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoExpedienteEncuestaCalidadGrid");
            if (in_array("sco_expediente_encuesta_calidad", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_expediente_encuesta_calidad"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoExpedienteCiaGrid");
            if (in_array("sco_expediente_cia", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_expediente_cia"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoEmbalajeGrid");
            if (in_array("sco_embalaje", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_embalaje"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoReembolsoGrid");
            if (in_array("sco_reembolso", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_reembolso"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
                }
            }
            $detailPage = Container("ScoNotaGrid");
            if (in_array("sco_nota", $detailTblVar) && $detailPage->DetailAdd && $addRow) {
                $detailPage->expediente->setSessionValue($this->Nexpediente->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "sco_nota"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->expediente->setSessionValue(""); // Clear master key if insert failed
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

        // contrato_parcela
        $this->contrato_parcela->setDbValueDef($rsnew, $this->contrato_parcela->CurrentValue, false);

        // seguro
        $this->seguro->setDbValueDef($rsnew, $this->seguro->CurrentValue, false);

        // nombre_contacto
        $this->nombre_contacto->setDbValueDef($rsnew, $this->nombre_contacto->CurrentValue, false);

        // parentesco_contacto
        $this->parentesco_contacto->setDbValueDef($rsnew, $this->parentesco_contacto->CurrentValue, false);

        // telefono_contacto1
        $this->telefono_contacto1->setDbValueDef($rsnew, $this->telefono_contacto1->CurrentValue, false);

        // telefono_contacto2
        $this->telefono_contacto2->setDbValueDef($rsnew, $this->telefono_contacto2->CurrentValue, false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, false);

        // cedula_fallecido
        $this->cedula_fallecido->setDbValueDef($rsnew, $this->cedula_fallecido->CurrentValue, false);

        // nombre_fallecido
        $this->nombre_fallecido->setDbValueDef($rsnew, $this->nombre_fallecido->CurrentValue, false);

        // apellidos_fallecido
        $this->apellidos_fallecido->setDbValueDef($rsnew, $this->apellidos_fallecido->CurrentValue, false);

        // sexo
        $this->sexo->setDbValueDef($rsnew, $this->sexo->CurrentValue, false);

        // fecha_nacimiento
        $this->fecha_nacimiento->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern()), false);

        // lugar_ocurrencia
        $this->lugar_ocurrencia->setDbValueDef($rsnew, $this->lugar_ocurrencia->CurrentValue, false);

        // direccion_ocurrencia
        $this->direccion_ocurrencia->setDbValueDef($rsnew, $this->direccion_ocurrencia->CurrentValue, false);

        // fecha_ocurrencia
        $this->fecha_ocurrencia->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern()), false);

        // causa_ocurrencia
        $this->causa_ocurrencia->setDbValueDef($rsnew, $this->causa_ocurrencia->CurrentValue, false);

        // causa_otro
        $this->causa_otro->setDbValueDef($rsnew, $this->causa_otro->CurrentValue, false);

        // religion
        $this->religion->setDbValueDef($rsnew, $this->religion->CurrentValue, false);

        // permiso
        $this->permiso->setDbValueDef($rsnew, $this->permiso->CurrentValue, false);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, false);

        // funeraria
        $this->funeraria->setDbValueDef($rsnew, $this->funeraria->CurrentValue, false);

        // servicio_tipo
        $this->servicio_tipo->setDbValueDef($rsnew, $this->servicio_tipo->CurrentValue, false);

        // servicio
        $this->servicio->setDbValueDef($rsnew, $this->servicio->CurrentValue, false);

        // marca_pasos
        $this->marca_pasos->setDbValueDef($rsnew, $this->marca_pasos->CurrentValue, strval($this->marca_pasos->CurrentValue) == "");

        // peso
        $this->peso->setDbValueDef($rsnew, $this->peso->CurrentValue, false);

        // certificado_defuncion
        $this->certificado_defuncion->setDbValueDef($rsnew, $this->certificado_defuncion->CurrentValue, false);

        // parcela
        $this->parcela->setDbValueDef($rsnew, $this->parcela->CurrentValue, false);
        return $rsnew;
    }

    /**
     * Restore add form from row
     * @param array $row Row
     */
    protected function restoreAddFormFromRow($row)
    {
        if (isset($row['contrato_parcela'])) { // contrato_parcela
            $this->contrato_parcela->setFormValue($row['contrato_parcela']);
        }
        if (isset($row['seguro'])) { // seguro
            $this->seguro->setFormValue($row['seguro']);
        }
        if (isset($row['nombre_contacto'])) { // nombre_contacto
            $this->nombre_contacto->setFormValue($row['nombre_contacto']);
        }
        if (isset($row['parentesco_contacto'])) { // parentesco_contacto
            $this->parentesco_contacto->setFormValue($row['parentesco_contacto']);
        }
        if (isset($row['telefono_contacto1'])) { // telefono_contacto1
            $this->telefono_contacto1->setFormValue($row['telefono_contacto1']);
        }
        if (isset($row['telefono_contacto2'])) { // telefono_contacto2
            $this->telefono_contacto2->setFormValue($row['telefono_contacto2']);
        }
        if (isset($row['email'])) { // email
            $this->_email->setFormValue($row['email']);
        }
        if (isset($row['cedula_fallecido'])) { // cedula_fallecido
            $this->cedula_fallecido->setFormValue($row['cedula_fallecido']);
        }
        if (isset($row['nombre_fallecido'])) { // nombre_fallecido
            $this->nombre_fallecido->setFormValue($row['nombre_fallecido']);
        }
        if (isset($row['apellidos_fallecido'])) { // apellidos_fallecido
            $this->apellidos_fallecido->setFormValue($row['apellidos_fallecido']);
        }
        if (isset($row['sexo'])) { // sexo
            $this->sexo->setFormValue($row['sexo']);
        }
        if (isset($row['fecha_nacimiento'])) { // fecha_nacimiento
            $this->fecha_nacimiento->setFormValue($row['fecha_nacimiento']);
        }
        if (isset($row['lugar_ocurrencia'])) { // lugar_ocurrencia
            $this->lugar_ocurrencia->setFormValue($row['lugar_ocurrencia']);
        }
        if (isset($row['direccion_ocurrencia'])) { // direccion_ocurrencia
            $this->direccion_ocurrencia->setFormValue($row['direccion_ocurrencia']);
        }
        if (isset($row['fecha_ocurrencia'])) { // fecha_ocurrencia
            $this->fecha_ocurrencia->setFormValue($row['fecha_ocurrencia']);
        }
        if (isset($row['causa_ocurrencia'])) { // causa_ocurrencia
            $this->causa_ocurrencia->setFormValue($row['causa_ocurrencia']);
        }
        if (isset($row['causa_otro'])) { // causa_otro
            $this->causa_otro->setFormValue($row['causa_otro']);
        }
        if (isset($row['religion'])) { // religion
            $this->religion->setFormValue($row['religion']);
        }
        if (isset($row['permiso'])) { // permiso
            $this->permiso->setFormValue($row['permiso']);
        }
        if (isset($row['nota'])) { // nota
            $this->nota->setFormValue($row['nota']);
        }
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->setFormValue($row['funeraria']);
        }
        if (isset($row['servicio_tipo'])) { // servicio_tipo
            $this->servicio_tipo->setFormValue($row['servicio_tipo']);
        }
        if (isset($row['servicio'])) { // servicio
            $this->servicio->setFormValue($row['servicio']);
        }
        if (isset($row['marca_pasos'])) { // marca_pasos
            $this->marca_pasos->setFormValue($row['marca_pasos']);
        }
        if (isset($row['peso'])) { // peso
            $this->peso->setFormValue($row['peso']);
        }
        if (isset($row['certificado_defuncion'])) { // certificado_defuncion
            $this->certificado_defuncion->setFormValue($row['certificado_defuncion']);
        }
        if (isset($row['parcela'])) { // parcela
            $this->parcela->setFormValue($row['parcela']);
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
            if (in_array("sco_orden", $detailTblVar)) {
                $detailPageObj = Container("ScoOrdenGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_seguimiento", $detailTblVar)) {
                $detailPageObj = Container("ScoSeguimientoGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_expediente_estatus", $detailTblVar)) {
                $detailPageObj = Container("ScoExpedienteEstatusGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_adjunto", $detailTblVar)) {
                $detailPageObj = Container("ScoAdjuntoGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                    $detailPageObj->servicio->setSessionValue(""); // Clear session key
                    $detailPageObj->flota->setSessionValue(""); // Clear session key
                    $detailPageObj->flota_incidencia->setSessionValue(""); // Clear session key
                }
            }
            if (in_array("sco_cremacion_estatus", $detailTblVar)) {
                $detailPageObj = Container("ScoCremacionEstatusGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_parcela", $detailTblVar)) {
                $detailPageObj = Container("ScoParcelaGrid");
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
                    $detailPageObj->contrato->IsDetailKey = true;
                    $detailPageObj->contrato->CurrentValue = $this->contrato_parcela->CurrentValue;
                    $detailPageObj->contrato->setSessionValue($detailPageObj->contrato->CurrentValue);
                }
            }
            if (in_array("sco_expediente_encuesta_calidad", $detailTblVar)) {
                $detailPageObj = Container("ScoExpedienteEncuestaCalidadGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_expediente_cia", $detailTblVar)) {
                $detailPageObj = Container("ScoExpedienteCiaGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_embalaje", $detailTblVar)) {
                $detailPageObj = Container("ScoEmbalajeGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_reembolso", $detailTblVar)) {
                $detailPageObj = Container("ScoReembolsoGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
                }
            }
            if (in_array("sco_nota", $detailTblVar)) {
                $detailPageObj = Container("ScoNotaGrid");
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
                    $detailPageObj->expediente->IsDetailKey = true;
                    $detailPageObj->expediente->CurrentValue = $this->Nexpediente->CurrentValue;
                    $detailPageObj->expediente->setSessionValue($detailPageObj->expediente->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoExpedienteList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
        $pages->add(4);
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
                case "x_tipo_contratacion":
                    break;
                case "x_seguro":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_nacionalidad_contacto":
                    break;
                case "x_parentesco_contacto":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_nacionalidad_fallecido":
                    break;
                case "x_sexo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estado_civil":
                    break;
                case "x_lugar_ocurrencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_causa_ocurrencia":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_religion":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_user_registra":
                    break;
                case "x_calidad":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_unir_con_expediente":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_estatus":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_funeraria":
                    break;
                case "x_servicio_tipo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_servicio":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_marca_pasos":
                    break;
                case "x_peso":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_autoriza_cremar":
                    break;
                case "x_username_autoriza":
                    break;
                case "x_email_calidad":
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

    public function pageDataRendering(&$header) {
        $header = '<div id="parcela"></div>';
        $header .= user_show();
        $header .= '
        <div class="card shadow-sm mb-3">
            <div class="card-body bg-light">
                <div class="row mb-3">
                    <div class="col-12">
                        <h5 class="text-primary m-0">
                            <i class="fas fa-map-marker-alt mr-2"></i> Ubicación Parcela
                        </h5>
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col-md-10">
                        <div class="d-flex flex-wrap" style="gap: 20px;">
                            <div class="d-flex flex-column">
                                <label class="font-weight-bold small mb-1 text-muted">Sección:</label>
                                <input type="text" name="x_seccion" id="x_seccion" size="8" maxlength="3" placeholder="..." class="form-control">
                            </div>
                            <div class="d-flex flex-column">
                                <label class="font-weight-bold small mb-1 text-muted">Módulo:</label>
                                <input type="text" name="x_modulo" id="x_modulo" size="8" maxlength="3" placeholder="..." class="form-control">
                            </div>
                            <div class="d-flex flex-column">
                                <label class="font-weight-bold small mb-1 text-muted">Sub Sección:</label>
                                <input type="text" name="x_subseccion" id="x_subseccion" size="8" maxlength="3" placeholder="..." class="form-control">
                            </div>
                            <div class="d-flex flex-column">
                                <label class="font-weight-bold small mb-1 text-muted">Parcela:</label>
                                <div class="d-flex align-items-center">
                                    <input type="text" name="y_parcela" id="y_parcela" size="8" maxlength="1" placeholder="..." class="form-control">
                                    <i id="loading-parcela" class="fas fa-spinner fa-spin text-primary" style="display:none; margin-left: -22px; position: relative; z-index: 10;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3 mb-1" onclick="limpiarParcela()">
                            <i class="fas fa-eraser mr-1"></i> Limpiar
                        </button>
                    </div>
                </div>
            </div>
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
