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
class ScoExpedienteOldEdit extends ScoExpedienteOld
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteOldEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteOldEdit";

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
        $this->Nexpediente->setVisibility();
        $this->tipo_contratacion->setVisibility();
        $this->seguro->setVisibility();
        $this->nacionalidad_contacto->setVisibility();
        $this->cedula_contacto->setVisibility();
        $this->nombre_contacto->setVisibility();
        $this->apellidos_contacto->setVisibility();
        $this->parentesco_contacto->setVisibility();
        $this->telefono_contacto1->setVisibility();
        $this->telefono_contacto2->setVisibility();
        $this->nacionalidad_fallecido->setVisibility();
        $this->cedula_fallecido->setVisibility();
        $this->sexo->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->fecha_nacimiento->setVisibility();
        $this->edad_fallecido->setVisibility();
        $this->estado_civil->setVisibility();
        $this->lugar_nacimiento_fallecido->setVisibility();
        $this->lugar_ocurrencia->setVisibility();
        $this->direccion_ocurrencia->setVisibility();
        $this->fecha_ocurrencia->setVisibility();
        $this->hora_ocurrencia->setVisibility();
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->setVisibility();
        $this->descripcion_ocurrencia->setVisibility();
        $this->calidad->setVisibility();
        $this->costos->setVisibility();
        $this->venta->setVisibility();
        $this->user_registra->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->user_cierra->setVisibility();
        $this->fecha_cierre->setVisibility();
        $this->estatus->setVisibility();
        $this->factura->setVisibility();
        $this->permiso->setVisibility();
        $this->unir_con_expediente->setVisibility();
        $this->nota->setVisibility();
        $this->_email->setVisibility();
        $this->religion->setVisibility();
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->funeraria->setVisibility();
        $this->marca_pasos->setVisibility();
        $this->autoriza_cremar->setVisibility();
        $this->username_autoriza->setVisibility();
        $this->fecha_autoriza->setVisibility();
        $this->peso->setVisibility();
        $this->contrato_parcela->setVisibility();
        $this->email_calidad->setVisibility();
        $this->certificado_defuncion->setVisibility();
        $this->parcela->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_expediente_old';
        $this->TableName = 'sco_expediente_old';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_expediente_old)
        if (!isset($GLOBALS["sco_expediente_old"]) || $GLOBALS["sco_expediente_old"]::class == PROJECT_NAMESPACE . "sco_expediente_old") {
            $GLOBALS["sco_expediente_old"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente_old');
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
                        $result["view"] = SameString($pageName, "ScoExpedienteOldView"); // If View page, no primary button
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
        $this->setupLookupOptions($this->marca_pasos);
        $this->setupLookupOptions($this->autoriza_cremar);
        $this->setupLookupOptions($this->email_calidad);

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
            if (($keyValue = Get("Nexpediente") ?? Key(0) ?? Route(2)) !== null) {
                $this->Nexpediente->setQueryStringValue($keyValue);
                $this->Nexpediente->setOldValue($this->Nexpediente->QueryStringValue);
            } elseif (Post("Nexpediente") !== null) {
                $this->Nexpediente->setFormValue(Post("Nexpediente"));
                $this->Nexpediente->setOldValue($this->Nexpediente->FormValue);
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
                if (($keyValue = Get("Nexpediente") ?? Route("Nexpediente")) !== null) {
                    $this->Nexpediente->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Nexpediente->CurrentValue = null;
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
                        $this->terminate("ScoExpedienteOldList"); // Return to list page
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
                        if ($this->Nexpediente->CurrentValue != null) {
                            while ($this->fetch()) {
                                if (SameString($this->Nexpediente->CurrentValue, $this->CurrentRow['Nexpediente'])) {
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
                        $this->terminate("ScoExpedienteOldList"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("ScoExpedienteOldList"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "ScoExpedienteOldList") {
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
                        if (GetPageName($returnUrl) != "ScoExpedienteOldList") {
                            Container("app.flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "ScoExpedienteOldList"; // Return list page content
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

        // Check field name 'Nexpediente' first before field var 'x_Nexpediente'
        $val = $CurrentForm->hasValue("Nexpediente") ? $CurrentForm->getValue("Nexpediente") : $CurrentForm->getValue("x_Nexpediente");
        if (!$this->Nexpediente->IsDetailKey) {
            $this->Nexpediente->setFormValue($val);
        }

        // Check field name 'tipo_contratacion' first before field var 'x_tipo_contratacion'
        $val = $CurrentForm->hasValue("tipo_contratacion") ? $CurrentForm->getValue("tipo_contratacion") : $CurrentForm->getValue("x_tipo_contratacion");
        if (!$this->tipo_contratacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_contratacion->Visible = false; // Disable update for API request
            } else {
                $this->tipo_contratacion->setFormValue($val);
            }
        }

        // Check field name 'seguro' first before field var 'x_seguro'
        $val = $CurrentForm->hasValue("seguro") ? $CurrentForm->getValue("seguro") : $CurrentForm->getValue("x_seguro");
        if (!$this->seguro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->seguro->Visible = false; // Disable update for API request
            } else {
                $this->seguro->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'nacionalidad_contacto' first before field var 'x_nacionalidad_contacto'
        $val = $CurrentForm->hasValue("nacionalidad_contacto") ? $CurrentForm->getValue("nacionalidad_contacto") : $CurrentForm->getValue("x_nacionalidad_contacto");
        if (!$this->nacionalidad_contacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nacionalidad_contacto->Visible = false; // Disable update for API request
            } else {
                $this->nacionalidad_contacto->setFormValue($val);
            }
        }

        // Check field name 'cedula_contacto' first before field var 'x_cedula_contacto'
        $val = $CurrentForm->hasValue("cedula_contacto") ? $CurrentForm->getValue("cedula_contacto") : $CurrentForm->getValue("x_cedula_contacto");
        if (!$this->cedula_contacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cedula_contacto->Visible = false; // Disable update for API request
            } else {
                $this->cedula_contacto->setFormValue($val);
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

        // Check field name 'apellidos_contacto' first before field var 'x_apellidos_contacto'
        $val = $CurrentForm->hasValue("apellidos_contacto") ? $CurrentForm->getValue("apellidos_contacto") : $CurrentForm->getValue("x_apellidos_contacto");
        if (!$this->apellidos_contacto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellidos_contacto->Visible = false; // Disable update for API request
            } else {
                $this->apellidos_contacto->setFormValue($val);
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

        // Check field name 'nacionalidad_fallecido' first before field var 'x_nacionalidad_fallecido'
        $val = $CurrentForm->hasValue("nacionalidad_fallecido") ? $CurrentForm->getValue("nacionalidad_fallecido") : $CurrentForm->getValue("x_nacionalidad_fallecido");
        if (!$this->nacionalidad_fallecido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nacionalidad_fallecido->Visible = false; // Disable update for API request
            } else {
                $this->nacionalidad_fallecido->setFormValue($val);
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

        // Check field name 'sexo' first before field var 'x_sexo'
        $val = $CurrentForm->hasValue("sexo") ? $CurrentForm->getValue("sexo") : $CurrentForm->getValue("x_sexo");
        if (!$this->sexo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sexo->Visible = false; // Disable update for API request
            } else {
                $this->sexo->setFormValue($val);
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

        // Check field name 'edad_fallecido' first before field var 'x_edad_fallecido'
        $val = $CurrentForm->hasValue("edad_fallecido") ? $CurrentForm->getValue("edad_fallecido") : $CurrentForm->getValue("x_edad_fallecido");
        if (!$this->edad_fallecido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->edad_fallecido->Visible = false; // Disable update for API request
            } else {
                $this->edad_fallecido->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'estado_civil' first before field var 'x_estado_civil'
        $val = $CurrentForm->hasValue("estado_civil") ? $CurrentForm->getValue("estado_civil") : $CurrentForm->getValue("x_estado_civil");
        if (!$this->estado_civil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado_civil->Visible = false; // Disable update for API request
            } else {
                $this->estado_civil->setFormValue($val);
            }
        }

        // Check field name 'lugar_nacimiento_fallecido' first before field var 'x_lugar_nacimiento_fallecido'
        $val = $CurrentForm->hasValue("lugar_nacimiento_fallecido") ? $CurrentForm->getValue("lugar_nacimiento_fallecido") : $CurrentForm->getValue("x_lugar_nacimiento_fallecido");
        if (!$this->lugar_nacimiento_fallecido->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lugar_nacimiento_fallecido->Visible = false; // Disable update for API request
            } else {
                $this->lugar_nacimiento_fallecido->setFormValue($val);
            }
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

        // Check field name 'hora_ocurrencia' first before field var 'x_hora_ocurrencia'
        $val = $CurrentForm->hasValue("hora_ocurrencia") ? $CurrentForm->getValue("hora_ocurrencia") : $CurrentForm->getValue("x_hora_ocurrencia");
        if (!$this->hora_ocurrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hora_ocurrencia->Visible = false; // Disable update for API request
            } else {
                $this->hora_ocurrencia->setFormValue($val, true, $validate);
            }
            $this->hora_ocurrencia->CurrentValue = UnFormatDateTime($this->hora_ocurrencia->CurrentValue, $this->hora_ocurrencia->formatPattern());
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

        // Check field name 'descripcion_ocurrencia' first before field var 'x_descripcion_ocurrencia'
        $val = $CurrentForm->hasValue("descripcion_ocurrencia") ? $CurrentForm->getValue("descripcion_ocurrencia") : $CurrentForm->getValue("x_descripcion_ocurrencia");
        if (!$this->descripcion_ocurrencia->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion_ocurrencia->Visible = false; // Disable update for API request
            } else {
                $this->descripcion_ocurrencia->setFormValue($val);
            }
        }

        // Check field name 'calidad' first before field var 'x_calidad'
        $val = $CurrentForm->hasValue("calidad") ? $CurrentForm->getValue("calidad") : $CurrentForm->getValue("x_calidad");
        if (!$this->calidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->calidad->Visible = false; // Disable update for API request
            } else {
                $this->calidad->setFormValue($val);
            }
        }

        // Check field name 'costos' first before field var 'x_costos'
        $val = $CurrentForm->hasValue("costos") ? $CurrentForm->getValue("costos") : $CurrentForm->getValue("x_costos");
        if (!$this->costos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->costos->Visible = false; // Disable update for API request
            } else {
                $this->costos->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'venta' first before field var 'x_venta'
        $val = $CurrentForm->hasValue("venta") ? $CurrentForm->getValue("venta") : $CurrentForm->getValue("x_venta");
        if (!$this->venta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->venta->Visible = false; // Disable update for API request
            } else {
                $this->venta->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'user_registra' first before field var 'x_user_registra'
        $val = $CurrentForm->hasValue("user_registra") ? $CurrentForm->getValue("user_registra") : $CurrentForm->getValue("x_user_registra");
        if (!$this->user_registra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_registra->Visible = false; // Disable update for API request
            } else {
                $this->user_registra->setFormValue($val);
            }
        }

        // Check field name 'fecha_registro' first before field var 'x_fecha_registro'
        $val = $CurrentForm->hasValue("fecha_registro") ? $CurrentForm->getValue("fecha_registro") : $CurrentForm->getValue("x_fecha_registro");
        if (!$this->fecha_registro->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_registro->Visible = false; // Disable update for API request
            } else {
                $this->fecha_registro->setFormValue($val, true, $validate);
            }
            $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        }

        // Check field name 'user_cierra' first before field var 'x_user_cierra'
        $val = $CurrentForm->hasValue("user_cierra") ? $CurrentForm->getValue("user_cierra") : $CurrentForm->getValue("x_user_cierra");
        if (!$this->user_cierra->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_cierra->Visible = false; // Disable update for API request
            } else {
                $this->user_cierra->setFormValue($val);
            }
        }

        // Check field name 'fecha_cierre' first before field var 'x_fecha_cierre'
        $val = $CurrentForm->hasValue("fecha_cierre") ? $CurrentForm->getValue("fecha_cierre") : $CurrentForm->getValue("x_fecha_cierre");
        if (!$this->fecha_cierre->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_cierre->Visible = false; // Disable update for API request
            } else {
                $this->fecha_cierre->setFormValue($val, true, $validate);
            }
            $this->fecha_cierre->CurrentValue = UnFormatDateTime($this->fecha_cierre->CurrentValue, $this->fecha_cierre->formatPattern());
        }

        // Check field name 'estatus' first before field var 'x_estatus'
        $val = $CurrentForm->hasValue("estatus") ? $CurrentForm->getValue("estatus") : $CurrentForm->getValue("x_estatus");
        if (!$this->estatus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estatus->Visible = false; // Disable update for API request
            } else {
                $this->estatus->setFormValue($val, true, $validate);
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

        // Check field name 'permiso' first before field var 'x_permiso'
        $val = $CurrentForm->hasValue("permiso") ? $CurrentForm->getValue("permiso") : $CurrentForm->getValue("x_permiso");
        if (!$this->permiso->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->permiso->Visible = false; // Disable update for API request
            } else {
                $this->permiso->setFormValue($val);
            }
        }

        // Check field name 'unir_con_expediente' first before field var 'x_unir_con_expediente'
        $val = $CurrentForm->hasValue("unir_con_expediente") ? $CurrentForm->getValue("unir_con_expediente") : $CurrentForm->getValue("x_unir_con_expediente");
        if (!$this->unir_con_expediente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->unir_con_expediente->Visible = false; // Disable update for API request
            } else {
                $this->unir_con_expediente->setFormValue($val, true, $validate);
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

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
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

        // Check field name 'funeraria' first before field var 'x_funeraria'
        $val = $CurrentForm->hasValue("funeraria") ? $CurrentForm->getValue("funeraria") : $CurrentForm->getValue("x_funeraria");
        if (!$this->funeraria->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->funeraria->Visible = false; // Disable update for API request
            } else {
                $this->funeraria->setFormValue($val, true, $validate);
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

        // Check field name 'autoriza_cremar' first before field var 'x_autoriza_cremar'
        $val = $CurrentForm->hasValue("autoriza_cremar") ? $CurrentForm->getValue("autoriza_cremar") : $CurrentForm->getValue("x_autoriza_cremar");
        if (!$this->autoriza_cremar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->autoriza_cremar->Visible = false; // Disable update for API request
            } else {
                $this->autoriza_cremar->setFormValue($val);
            }
        }

        // Check field name 'username_autoriza' first before field var 'x_username_autoriza'
        $val = $CurrentForm->hasValue("username_autoriza") ? $CurrentForm->getValue("username_autoriza") : $CurrentForm->getValue("x_username_autoriza");
        if (!$this->username_autoriza->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->username_autoriza->Visible = false; // Disable update for API request
            } else {
                $this->username_autoriza->setFormValue($val);
            }
        }

        // Check field name 'fecha_autoriza' first before field var 'x_fecha_autoriza'
        $val = $CurrentForm->hasValue("fecha_autoriza") ? $CurrentForm->getValue("fecha_autoriza") : $CurrentForm->getValue("x_fecha_autoriza");
        if (!$this->fecha_autoriza->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha_autoriza->Visible = false; // Disable update for API request
            } else {
                $this->fecha_autoriza->setFormValue($val, true, $validate);
            }
            $this->fecha_autoriza->CurrentValue = UnFormatDateTime($this->fecha_autoriza->CurrentValue, $this->fecha_autoriza->formatPattern());
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

        // Check field name 'contrato_parcela' first before field var 'x_contrato_parcela'
        $val = $CurrentForm->hasValue("contrato_parcela") ? $CurrentForm->getValue("contrato_parcela") : $CurrentForm->getValue("x_contrato_parcela");
        if (!$this->contrato_parcela->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contrato_parcela->Visible = false; // Disable update for API request
            } else {
                $this->contrato_parcela->setFormValue($val);
            }
        }

        // Check field name 'email_calidad' first before field var 'x_email_calidad'
        $val = $CurrentForm->hasValue("email_calidad") ? $CurrentForm->getValue("email_calidad") : $CurrentForm->getValue("x_email_calidad");
        if (!$this->email_calidad->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->email_calidad->Visible = false; // Disable update for API request
            } else {
                $this->email_calidad->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Nexpediente->CurrentValue = $this->Nexpediente->FormValue;
        $this->tipo_contratacion->CurrentValue = $this->tipo_contratacion->FormValue;
        $this->seguro->CurrentValue = $this->seguro->FormValue;
        $this->nacionalidad_contacto->CurrentValue = $this->nacionalidad_contacto->FormValue;
        $this->cedula_contacto->CurrentValue = $this->cedula_contacto->FormValue;
        $this->nombre_contacto->CurrentValue = $this->nombre_contacto->FormValue;
        $this->apellidos_contacto->CurrentValue = $this->apellidos_contacto->FormValue;
        $this->parentesco_contacto->CurrentValue = $this->parentesco_contacto->FormValue;
        $this->telefono_contacto1->CurrentValue = $this->telefono_contacto1->FormValue;
        $this->telefono_contacto2->CurrentValue = $this->telefono_contacto2->FormValue;
        $this->nacionalidad_fallecido->CurrentValue = $this->nacionalidad_fallecido->FormValue;
        $this->cedula_fallecido->CurrentValue = $this->cedula_fallecido->FormValue;
        $this->sexo->CurrentValue = $this->sexo->FormValue;
        $this->nombre_fallecido->CurrentValue = $this->nombre_fallecido->FormValue;
        $this->apellidos_fallecido->CurrentValue = $this->apellidos_fallecido->FormValue;
        $this->fecha_nacimiento->CurrentValue = $this->fecha_nacimiento->FormValue;
        $this->fecha_nacimiento->CurrentValue = UnFormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern());
        $this->edad_fallecido->CurrentValue = $this->edad_fallecido->FormValue;
        $this->estado_civil->CurrentValue = $this->estado_civil->FormValue;
        $this->lugar_nacimiento_fallecido->CurrentValue = $this->lugar_nacimiento_fallecido->FormValue;
        $this->lugar_ocurrencia->CurrentValue = $this->lugar_ocurrencia->FormValue;
        $this->direccion_ocurrencia->CurrentValue = $this->direccion_ocurrencia->FormValue;
        $this->fecha_ocurrencia->CurrentValue = $this->fecha_ocurrencia->FormValue;
        $this->fecha_ocurrencia->CurrentValue = UnFormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern());
        $this->hora_ocurrencia->CurrentValue = $this->hora_ocurrencia->FormValue;
        $this->hora_ocurrencia->CurrentValue = UnFormatDateTime($this->hora_ocurrencia->CurrentValue, $this->hora_ocurrencia->formatPattern());
        $this->causa_ocurrencia->CurrentValue = $this->causa_ocurrencia->FormValue;
        $this->causa_otro->CurrentValue = $this->causa_otro->FormValue;
        $this->descripcion_ocurrencia->CurrentValue = $this->descripcion_ocurrencia->FormValue;
        $this->calidad->CurrentValue = $this->calidad->FormValue;
        $this->costos->CurrentValue = $this->costos->FormValue;
        $this->venta->CurrentValue = $this->venta->FormValue;
        $this->user_registra->CurrentValue = $this->user_registra->FormValue;
        $this->fecha_registro->CurrentValue = $this->fecha_registro->FormValue;
        $this->fecha_registro->CurrentValue = UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->user_cierra->CurrentValue = $this->user_cierra->FormValue;
        $this->fecha_cierre->CurrentValue = $this->fecha_cierre->FormValue;
        $this->fecha_cierre->CurrentValue = UnFormatDateTime($this->fecha_cierre->CurrentValue, $this->fecha_cierre->formatPattern());
        $this->estatus->CurrentValue = $this->estatus->FormValue;
        $this->factura->CurrentValue = $this->factura->FormValue;
        $this->permiso->CurrentValue = $this->permiso->FormValue;
        $this->unir_con_expediente->CurrentValue = $this->unir_con_expediente->FormValue;
        $this->nota->CurrentValue = $this->nota->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->religion->CurrentValue = $this->religion->FormValue;
        $this->servicio_tipo->CurrentValue = $this->servicio_tipo->FormValue;
        $this->servicio->CurrentValue = $this->servicio->FormValue;
        $this->funeraria->CurrentValue = $this->funeraria->FormValue;
        $this->marca_pasos->CurrentValue = $this->marca_pasos->FormValue;
        $this->autoriza_cremar->CurrentValue = $this->autoriza_cremar->FormValue;
        $this->username_autoriza->CurrentValue = $this->username_autoriza->FormValue;
        $this->fecha_autoriza->CurrentValue = $this->fecha_autoriza->FormValue;
        $this->fecha_autoriza->CurrentValue = UnFormatDateTime($this->fecha_autoriza->CurrentValue, $this->fecha_autoriza->formatPattern());
        $this->peso->CurrentValue = $this->peso->FormValue;
        $this->contrato_parcela->CurrentValue = $this->contrato_parcela->FormValue;
        $this->email_calidad->CurrentValue = $this->email_calidad->FormValue;
        $this->certificado_defuncion->CurrentValue = $this->certificado_defuncion->FormValue;
        $this->parcela->CurrentValue = $this->parcela->FormValue;
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
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->tipo_contratacion->setDbValue($row['tipo_contratacion']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nacionalidad_contacto->setDbValue($row['nacionalidad_contacto']);
        $this->cedula_contacto->setDbValue($row['cedula_contacto']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->apellidos_contacto->setDbValue($row['apellidos_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->nacionalidad_fallecido->setDbValue($row['nacionalidad_fallecido']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
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
        $this->calidad->setDbValue($row['calidad']);
        $this->costos->setDbValue($row['costos']);
        $this->venta->setDbValue($row['venta']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_cierra->setDbValue($row['user_cierra']);
        $this->fecha_cierre->setDbValue($row['fecha_cierre']);
        $this->estatus->setDbValue($row['estatus']);
        $this->factura->setDbValue($row['factura']);
        $this->permiso->setDbValue($row['permiso']);
        $this->unir_con_expediente->setDbValue($row['unir_con_expediente']);
        $this->nota->setDbValue($row['nota']);
        $this->_email->setDbValue($row['email']);
        $this->religion->setDbValue($row['religion']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->marca_pasos->setDbValue($row['marca_pasos']);
        $this->autoriza_cremar->setDbValue($row['autoriza_cremar']);
        $this->username_autoriza->setDbValue($row['username_autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->peso->setDbValue($row['peso']);
        $this->contrato_parcela->setDbValue($row['contrato_parcela']);
        $this->email_calidad->setDbValue($row['email_calidad']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->parcela->setDbValue($row['parcela']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente'] = $this->Nexpediente->DefaultValue;
        $row['tipo_contratacion'] = $this->tipo_contratacion->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nacionalidad_contacto'] = $this->nacionalidad_contacto->DefaultValue;
        $row['cedula_contacto'] = $this->cedula_contacto->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['apellidos_contacto'] = $this->apellidos_contacto->DefaultValue;
        $row['parentesco_contacto'] = $this->parentesco_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['nacionalidad_fallecido'] = $this->nacionalidad_fallecido->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['sexo'] = $this->sexo->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
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
        $row['calidad'] = $this->calidad->DefaultValue;
        $row['costos'] = $this->costos->DefaultValue;
        $row['venta'] = $this->venta->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['user_cierra'] = $this->user_cierra->DefaultValue;
        $row['fecha_cierre'] = $this->fecha_cierre->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['permiso'] = $this->permiso->DefaultValue;
        $row['unir_con_expediente'] = $this->unir_con_expediente->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['religion'] = $this->religion->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['marca_pasos'] = $this->marca_pasos->DefaultValue;
        $row['autoriza_cremar'] = $this->autoriza_cremar->DefaultValue;
        $row['username_autoriza'] = $this->username_autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
        $row['peso'] = $this->peso->DefaultValue;
        $row['contrato_parcela'] = $this->contrato_parcela->DefaultValue;
        $row['email_calidad'] = $this->email_calidad->DefaultValue;
        $row['certificado_defuncion'] = $this->certificado_defuncion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
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

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->RowCssClass = "row";

        // cedula_fallecido
        $this->cedula_fallecido->RowCssClass = "row";

        // sexo
        $this->sexo->RowCssClass = "row";

        // nombre_fallecido
        $this->nombre_fallecido->RowCssClass = "row";

        // apellidos_fallecido
        $this->apellidos_fallecido->RowCssClass = "row";

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

        // calidad
        $this->calidad->RowCssClass = "row";

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

        // estatus
        $this->estatus->RowCssClass = "row";

        // factura
        $this->factura->RowCssClass = "row";

        // permiso
        $this->permiso->RowCssClass = "row";

        // unir_con_expediente
        $this->unir_con_expediente->RowCssClass = "row";

        // nota
        $this->nota->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // religion
        $this->religion->RowCssClass = "row";

        // servicio_tipo
        $this->servicio_tipo->RowCssClass = "row";

        // servicio
        $this->servicio->RowCssClass = "row";

        // funeraria
        $this->funeraria->RowCssClass = "row";

        // marca_pasos
        $this->marca_pasos->RowCssClass = "row";

        // autoriza_cremar
        $this->autoriza_cremar->RowCssClass = "row";

        // username_autoriza
        $this->username_autoriza->RowCssClass = "row";

        // fecha_autoriza
        $this->fecha_autoriza->RowCssClass = "row";

        // peso
        $this->peso->RowCssClass = "row";

        // contrato_parcela
        $this->contrato_parcela->RowCssClass = "row";

        // email_calidad
        $this->email_calidad->RowCssClass = "row";

        // certificado_defuncion
        $this->certificado_defuncion->RowCssClass = "row";

        // parcela
        $this->parcela->RowCssClass = "row";

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente
            $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

            // tipo_contratacion
            $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->CurrentValue;

            // seguro
            $this->seguro->ViewValue = $this->seguro->CurrentValue;
            $this->seguro->ViewValue = FormatNumber($this->seguro->ViewValue, $this->seguro->formatPattern());

            // nacionalidad_contacto
            $this->nacionalidad_contacto->ViewValue = $this->nacionalidad_contacto->CurrentValue;

            // cedula_contacto
            $this->cedula_contacto->ViewValue = $this->cedula_contacto->CurrentValue;

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // apellidos_contacto
            $this->apellidos_contacto->ViewValue = $this->apellidos_contacto->CurrentValue;

            // parentesco_contacto
            $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->CurrentValue;

            // telefono_contacto1
            $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

            // telefono_contacto2
            $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->ViewValue = $this->nacionalidad_fallecido->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

            // sexo
            $this->sexo->ViewValue = $this->sexo->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
            $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

            // edad_fallecido
            $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;
            $this->edad_fallecido->ViewValue = FormatNumber($this->edad_fallecido->ViewValue, $this->edad_fallecido->formatPattern());

            // estado_civil
            $this->estado_civil->ViewValue = $this->estado_civil->CurrentValue;

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;

            // lugar_ocurrencia
            $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->CurrentValue;

            // direccion_ocurrencia
            $this->direccion_ocurrencia->ViewValue = $this->direccion_ocurrencia->CurrentValue;

            // fecha_ocurrencia
            $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
            $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

            // hora_ocurrencia
            $this->hora_ocurrencia->ViewValue = $this->hora_ocurrencia->CurrentValue;
            $this->hora_ocurrencia->ViewValue = FormatDateTime($this->hora_ocurrencia->ViewValue, $this->hora_ocurrencia->formatPattern());

            // causa_ocurrencia
            $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

            // causa_otro
            $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->ViewValue = $this->descripcion_ocurrencia->CurrentValue;

            // calidad
            $this->calidad->ViewValue = $this->calidad->CurrentValue;

            // costos
            $this->costos->ViewValue = $this->costos->CurrentValue;
            $this->costos->ViewValue = FormatNumber($this->costos->ViewValue, $this->costos->formatPattern());

            // venta
            $this->venta->ViewValue = $this->venta->CurrentValue;
            $this->venta->ViewValue = FormatNumber($this->venta->ViewValue, $this->venta->formatPattern());

            // user_registra
            $this->user_registra->ViewValue = $this->user_registra->CurrentValue;

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // user_cierra
            $this->user_cierra->ViewValue = $this->user_cierra->CurrentValue;

            // fecha_cierre
            $this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
            $this->fecha_cierre->ViewValue = FormatDateTime($this->fecha_cierre->ViewValue, $this->fecha_cierre->formatPattern());

            // estatus
            $this->estatus->ViewValue = $this->estatus->CurrentValue;
            $this->estatus->ViewValue = FormatNumber($this->estatus->ViewValue, $this->estatus->formatPattern());

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // permiso
            $this->permiso->ViewValue = $this->permiso->CurrentValue;

            // unir_con_expediente
            $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->CurrentValue;
            $this->unir_con_expediente->ViewValue = FormatNumber($this->unir_con_expediente->ViewValue, $this->unir_con_expediente->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // religion
            $this->religion->ViewValue = $this->religion->CurrentValue;

            // servicio_tipo
            $this->servicio_tipo->ViewValue = $this->servicio_tipo->CurrentValue;

            // servicio
            $this->servicio->ViewValue = $this->servicio->CurrentValue;

            // funeraria
            $this->funeraria->ViewValue = $this->funeraria->CurrentValue;
            $this->funeraria->ViewValue = FormatNumber($this->funeraria->ViewValue, $this->funeraria->formatPattern());

            // marca_pasos
            if (strval($this->marca_pasos->CurrentValue) != "") {
                $this->marca_pasos->ViewValue = $this->marca_pasos->optionCaption($this->marca_pasos->CurrentValue);
            } else {
                $this->marca_pasos->ViewValue = null;
            }

            // autoriza_cremar
            if (strval($this->autoriza_cremar->CurrentValue) != "") {
                $this->autoriza_cremar->ViewValue = $this->autoriza_cremar->optionCaption($this->autoriza_cremar->CurrentValue);
            } else {
                $this->autoriza_cremar->ViewValue = null;
            }

            // username_autoriza
            $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;

            // fecha_autoriza
            $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
            $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

            // peso
            $this->peso->ViewValue = $this->peso->CurrentValue;

            // contrato_parcela
            $this->contrato_parcela->ViewValue = $this->contrato_parcela->CurrentValue;

            // email_calidad
            if (strval($this->email_calidad->CurrentValue) != "") {
                $this->email_calidad->ViewValue = $this->email_calidad->optionCaption($this->email_calidad->CurrentValue);
            } else {
                $this->email_calidad->ViewValue = null;
            }

            // certificado_defuncion
            $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // Nexpediente
            $this->Nexpediente->HrefValue = "";

            // tipo_contratacion
            $this->tipo_contratacion->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";

            // nacionalidad_contacto
            $this->nacionalidad_contacto->HrefValue = "";

            // cedula_contacto
            $this->cedula_contacto->HrefValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";

            // apellidos_contacto
            $this->apellidos_contacto->HrefValue = "";

            // parentesco_contacto
            $this->parentesco_contacto->HrefValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->HrefValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";

            // sexo
            $this->sexo->HrefValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";

            // edad_fallecido
            $this->edad_fallecido->HrefValue = "";

            // estado_civil
            $this->estado_civil->HrefValue = "";

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->HrefValue = "";

            // lugar_ocurrencia
            $this->lugar_ocurrencia->HrefValue = "";

            // direccion_ocurrencia
            $this->direccion_ocurrencia->HrefValue = "";

            // fecha_ocurrencia
            $this->fecha_ocurrencia->HrefValue = "";

            // hora_ocurrencia
            $this->hora_ocurrencia->HrefValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";

            // causa_otro
            $this->causa_otro->HrefValue = "";

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->HrefValue = "";

            // calidad
            $this->calidad->HrefValue = "";

            // costos
            $this->costos->HrefValue = "";

            // venta
            $this->venta->HrefValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";

            // user_cierra
            $this->user_cierra->HrefValue = "";

            // fecha_cierre
            $this->fecha_cierre->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";

            // factura
            $this->factura->HrefValue = "";

            // permiso
            $this->permiso->HrefValue = "";

            // unir_con_expediente
            $this->unir_con_expediente->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // religion
            $this->religion->HrefValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";

            // marca_pasos
            $this->marca_pasos->HrefValue = "";

            // autoriza_cremar
            $this->autoriza_cremar->HrefValue = "";

            // username_autoriza
            $this->username_autoriza->HrefValue = "";

            // fecha_autoriza
            $this->fecha_autoriza->HrefValue = "";

            // peso
            $this->peso->HrefValue = "";

            // contrato_parcela
            $this->contrato_parcela->HrefValue = "";

            // email_calidad
            $this->email_calidad->HrefValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";

            // parcela
            $this->parcela->HrefValue = "";
        } elseif ($this->RowType == RowType::EDIT) {
            // Nexpediente
            $this->Nexpediente->setupEditAttributes();
            $this->Nexpediente->EditValue = $this->Nexpediente->CurrentValue;

            // tipo_contratacion
            $this->tipo_contratacion->setupEditAttributes();
            if (!$this->tipo_contratacion->Raw) {
                $this->tipo_contratacion->CurrentValue = HtmlDecode($this->tipo_contratacion->CurrentValue);
            }
            $this->tipo_contratacion->EditValue = HtmlEncode($this->tipo_contratacion->CurrentValue);
            $this->tipo_contratacion->PlaceHolder = RemoveHtml($this->tipo_contratacion->caption());

            // seguro
            $this->seguro->setupEditAttributes();
            $this->seguro->EditValue = $this->seguro->CurrentValue;
            $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());
            if (strval($this->seguro->EditValue) != "" && is_numeric($this->seguro->EditValue)) {
                $this->seguro->EditValue = FormatNumber($this->seguro->EditValue, null);
            }

            // nacionalidad_contacto
            $this->nacionalidad_contacto->setupEditAttributes();
            if (!$this->nacionalidad_contacto->Raw) {
                $this->nacionalidad_contacto->CurrentValue = HtmlDecode($this->nacionalidad_contacto->CurrentValue);
            }
            $this->nacionalidad_contacto->EditValue = HtmlEncode($this->nacionalidad_contacto->CurrentValue);
            $this->nacionalidad_contacto->PlaceHolder = RemoveHtml($this->nacionalidad_contacto->caption());

            // cedula_contacto
            $this->cedula_contacto->setupEditAttributes();
            if (!$this->cedula_contacto->Raw) {
                $this->cedula_contacto->CurrentValue = HtmlDecode($this->cedula_contacto->CurrentValue);
            }
            $this->cedula_contacto->EditValue = HtmlEncode($this->cedula_contacto->CurrentValue);
            $this->cedula_contacto->PlaceHolder = RemoveHtml($this->cedula_contacto->caption());

            // nombre_contacto
            $this->nombre_contacto->setupEditAttributes();
            if (!$this->nombre_contacto->Raw) {
                $this->nombre_contacto->CurrentValue = HtmlDecode($this->nombre_contacto->CurrentValue);
            }
            $this->nombre_contacto->EditValue = HtmlEncode($this->nombre_contacto->CurrentValue);
            $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

            // apellidos_contacto
            $this->apellidos_contacto->setupEditAttributes();
            if (!$this->apellidos_contacto->Raw) {
                $this->apellidos_contacto->CurrentValue = HtmlDecode($this->apellidos_contacto->CurrentValue);
            }
            $this->apellidos_contacto->EditValue = HtmlEncode($this->apellidos_contacto->CurrentValue);
            $this->apellidos_contacto->PlaceHolder = RemoveHtml($this->apellidos_contacto->caption());

            // parentesco_contacto
            $this->parentesco_contacto->setupEditAttributes();
            if (!$this->parentesco_contacto->Raw) {
                $this->parentesco_contacto->CurrentValue = HtmlDecode($this->parentesco_contacto->CurrentValue);
            }
            $this->parentesco_contacto->EditValue = HtmlEncode($this->parentesco_contacto->CurrentValue);
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

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->setupEditAttributes();
            if (!$this->nacionalidad_fallecido->Raw) {
                $this->nacionalidad_fallecido->CurrentValue = HtmlDecode($this->nacionalidad_fallecido->CurrentValue);
            }
            $this->nacionalidad_fallecido->EditValue = HtmlEncode($this->nacionalidad_fallecido->CurrentValue);
            $this->nacionalidad_fallecido->PlaceHolder = RemoveHtml($this->nacionalidad_fallecido->caption());

            // cedula_fallecido
            $this->cedula_fallecido->setupEditAttributes();
            if (!$this->cedula_fallecido->Raw) {
                $this->cedula_fallecido->CurrentValue = HtmlDecode($this->cedula_fallecido->CurrentValue);
            }
            $this->cedula_fallecido->EditValue = HtmlEncode($this->cedula_fallecido->CurrentValue);
            $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

            // sexo
            $this->sexo->setupEditAttributes();
            if (!$this->sexo->Raw) {
                $this->sexo->CurrentValue = HtmlDecode($this->sexo->CurrentValue);
            }
            $this->sexo->EditValue = HtmlEncode($this->sexo->CurrentValue);
            $this->sexo->PlaceHolder = RemoveHtml($this->sexo->caption());

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

            // fecha_nacimiento
            $this->fecha_nacimiento->setupEditAttributes();
            $this->fecha_nacimiento->EditValue = HtmlEncode(FormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern()));
            $this->fecha_nacimiento->PlaceHolder = RemoveHtml($this->fecha_nacimiento->caption());

            // edad_fallecido
            $this->edad_fallecido->setupEditAttributes();
            $this->edad_fallecido->EditValue = $this->edad_fallecido->CurrentValue;
            $this->edad_fallecido->PlaceHolder = RemoveHtml($this->edad_fallecido->caption());
            if (strval($this->edad_fallecido->EditValue) != "" && is_numeric($this->edad_fallecido->EditValue)) {
                $this->edad_fallecido->EditValue = FormatNumber($this->edad_fallecido->EditValue, null);
            }

            // estado_civil
            $this->estado_civil->setupEditAttributes();
            if (!$this->estado_civil->Raw) {
                $this->estado_civil->CurrentValue = HtmlDecode($this->estado_civil->CurrentValue);
            }
            $this->estado_civil->EditValue = HtmlEncode($this->estado_civil->CurrentValue);
            $this->estado_civil->PlaceHolder = RemoveHtml($this->estado_civil->caption());

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->setupEditAttributes();
            if (!$this->lugar_nacimiento_fallecido->Raw) {
                $this->lugar_nacimiento_fallecido->CurrentValue = HtmlDecode($this->lugar_nacimiento_fallecido->CurrentValue);
            }
            $this->lugar_nacimiento_fallecido->EditValue = HtmlEncode($this->lugar_nacimiento_fallecido->CurrentValue);
            $this->lugar_nacimiento_fallecido->PlaceHolder = RemoveHtml($this->lugar_nacimiento_fallecido->caption());

            // lugar_ocurrencia
            $this->lugar_ocurrencia->setupEditAttributes();
            if (!$this->lugar_ocurrencia->Raw) {
                $this->lugar_ocurrencia->CurrentValue = HtmlDecode($this->lugar_ocurrencia->CurrentValue);
            }
            $this->lugar_ocurrencia->EditValue = HtmlEncode($this->lugar_ocurrencia->CurrentValue);
            $this->lugar_ocurrencia->PlaceHolder = RemoveHtml($this->lugar_ocurrencia->caption());

            // direccion_ocurrencia
            $this->direccion_ocurrencia->setupEditAttributes();
            if (!$this->direccion_ocurrencia->Raw) {
                $this->direccion_ocurrencia->CurrentValue = HtmlDecode($this->direccion_ocurrencia->CurrentValue);
            }
            $this->direccion_ocurrencia->EditValue = HtmlEncode($this->direccion_ocurrencia->CurrentValue);
            $this->direccion_ocurrencia->PlaceHolder = RemoveHtml($this->direccion_ocurrencia->caption());

            // fecha_ocurrencia
            $this->fecha_ocurrencia->setupEditAttributes();
            $this->fecha_ocurrencia->EditValue = HtmlEncode(FormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern()));
            $this->fecha_ocurrencia->PlaceHolder = RemoveHtml($this->fecha_ocurrencia->caption());

            // hora_ocurrencia
            $this->hora_ocurrencia->setupEditAttributes();
            $this->hora_ocurrencia->EditValue = HtmlEncode(FormatDateTime($this->hora_ocurrencia->CurrentValue, $this->hora_ocurrencia->formatPattern()));
            $this->hora_ocurrencia->PlaceHolder = RemoveHtml($this->hora_ocurrencia->caption());

            // causa_ocurrencia
            $this->causa_ocurrencia->setupEditAttributes();
            if (!$this->causa_ocurrencia->Raw) {
                $this->causa_ocurrencia->CurrentValue = HtmlDecode($this->causa_ocurrencia->CurrentValue);
            }
            $this->causa_ocurrencia->EditValue = HtmlEncode($this->causa_ocurrencia->CurrentValue);
            $this->causa_ocurrencia->PlaceHolder = RemoveHtml($this->causa_ocurrencia->caption());

            // causa_otro
            $this->causa_otro->setupEditAttributes();
            if (!$this->causa_otro->Raw) {
                $this->causa_otro->CurrentValue = HtmlDecode($this->causa_otro->CurrentValue);
            }
            $this->causa_otro->EditValue = HtmlEncode($this->causa_otro->CurrentValue);
            $this->causa_otro->PlaceHolder = RemoveHtml($this->causa_otro->caption());

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->setupEditAttributes();
            if (!$this->descripcion_ocurrencia->Raw) {
                $this->descripcion_ocurrencia->CurrentValue = HtmlDecode($this->descripcion_ocurrencia->CurrentValue);
            }
            $this->descripcion_ocurrencia->EditValue = HtmlEncode($this->descripcion_ocurrencia->CurrentValue);
            $this->descripcion_ocurrencia->PlaceHolder = RemoveHtml($this->descripcion_ocurrencia->caption());

            // calidad
            $this->calidad->setupEditAttributes();
            if (!$this->calidad->Raw) {
                $this->calidad->CurrentValue = HtmlDecode($this->calidad->CurrentValue);
            }
            $this->calidad->EditValue = HtmlEncode($this->calidad->CurrentValue);
            $this->calidad->PlaceHolder = RemoveHtml($this->calidad->caption());

            // costos
            $this->costos->setupEditAttributes();
            $this->costos->EditValue = $this->costos->CurrentValue;
            $this->costos->PlaceHolder = RemoveHtml($this->costos->caption());
            if (strval($this->costos->EditValue) != "" && is_numeric($this->costos->EditValue)) {
                $this->costos->EditValue = FormatNumber($this->costos->EditValue, null);
            }

            // venta
            $this->venta->setupEditAttributes();
            $this->venta->EditValue = $this->venta->CurrentValue;
            $this->venta->PlaceHolder = RemoveHtml($this->venta->caption());
            if (strval($this->venta->EditValue) != "" && is_numeric($this->venta->EditValue)) {
                $this->venta->EditValue = FormatNumber($this->venta->EditValue, null);
            }

            // user_registra
            $this->user_registra->setupEditAttributes();
            if (!$this->user_registra->Raw) {
                $this->user_registra->CurrentValue = HtmlDecode($this->user_registra->CurrentValue);
            }
            $this->user_registra->EditValue = HtmlEncode($this->user_registra->CurrentValue);
            $this->user_registra->PlaceHolder = RemoveHtml($this->user_registra->caption());

            // fecha_registro
            $this->fecha_registro->setupEditAttributes();
            $this->fecha_registro->EditValue = HtmlEncode(FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern()));
            $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

            // user_cierra
            $this->user_cierra->setupEditAttributes();
            if (!$this->user_cierra->Raw) {
                $this->user_cierra->CurrentValue = HtmlDecode($this->user_cierra->CurrentValue);
            }
            $this->user_cierra->EditValue = HtmlEncode($this->user_cierra->CurrentValue);
            $this->user_cierra->PlaceHolder = RemoveHtml($this->user_cierra->caption());

            // fecha_cierre
            $this->fecha_cierre->setupEditAttributes();
            $this->fecha_cierre->EditValue = HtmlEncode(FormatDateTime($this->fecha_cierre->CurrentValue, $this->fecha_cierre->formatPattern()));
            $this->fecha_cierre->PlaceHolder = RemoveHtml($this->fecha_cierre->caption());

            // estatus
            $this->estatus->setupEditAttributes();
            $this->estatus->EditValue = $this->estatus->CurrentValue;
            $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());
            if (strval($this->estatus->EditValue) != "" && is_numeric($this->estatus->EditValue)) {
                $this->estatus->EditValue = FormatNumber($this->estatus->EditValue, null);
            }

            // factura
            $this->factura->setupEditAttributes();
            if (!$this->factura->Raw) {
                $this->factura->CurrentValue = HtmlDecode($this->factura->CurrentValue);
            }
            $this->factura->EditValue = HtmlEncode($this->factura->CurrentValue);
            $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

            // permiso
            $this->permiso->setupEditAttributes();
            if (!$this->permiso->Raw) {
                $this->permiso->CurrentValue = HtmlDecode($this->permiso->CurrentValue);
            }
            $this->permiso->EditValue = HtmlEncode($this->permiso->CurrentValue);
            $this->permiso->PlaceHolder = RemoveHtml($this->permiso->caption());

            // unir_con_expediente
            $this->unir_con_expediente->setupEditAttributes();
            $this->unir_con_expediente->EditValue = $this->unir_con_expediente->CurrentValue;
            $this->unir_con_expediente->PlaceHolder = RemoveHtml($this->unir_con_expediente->caption());
            if (strval($this->unir_con_expediente->EditValue) != "" && is_numeric($this->unir_con_expediente->EditValue)) {
                $this->unir_con_expediente->EditValue = FormatNumber($this->unir_con_expediente->EditValue, null);
            }

            // nota
            $this->nota->setupEditAttributes();
            if (!$this->nota->Raw) {
                $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
            }
            $this->nota->EditValue = HtmlEncode($this->nota->CurrentValue);
            $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // religion
            $this->religion->setupEditAttributes();
            if (!$this->religion->Raw) {
                $this->religion->CurrentValue = HtmlDecode($this->religion->CurrentValue);
            }
            $this->religion->EditValue = HtmlEncode($this->religion->CurrentValue);
            $this->religion->PlaceHolder = RemoveHtml($this->religion->caption());

            // servicio_tipo
            $this->servicio_tipo->setupEditAttributes();
            if (!$this->servicio_tipo->Raw) {
                $this->servicio_tipo->CurrentValue = HtmlDecode($this->servicio_tipo->CurrentValue);
            }
            $this->servicio_tipo->EditValue = HtmlEncode($this->servicio_tipo->CurrentValue);
            $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

            // servicio
            $this->servicio->setupEditAttributes();
            if (!$this->servicio->Raw) {
                $this->servicio->CurrentValue = HtmlDecode($this->servicio->CurrentValue);
            }
            $this->servicio->EditValue = HtmlEncode($this->servicio->CurrentValue);
            $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

            // funeraria
            $this->funeraria->setupEditAttributes();
            $this->funeraria->EditValue = $this->funeraria->CurrentValue;
            $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());
            if (strval($this->funeraria->EditValue) != "" && is_numeric($this->funeraria->EditValue)) {
                $this->funeraria->EditValue = FormatNumber($this->funeraria->EditValue, null);
            }

            // marca_pasos
            $this->marca_pasos->EditValue = $this->marca_pasos->options(false);
            $this->marca_pasos->PlaceHolder = RemoveHtml($this->marca_pasos->caption());

            // autoriza_cremar
            $this->autoriza_cremar->EditValue = $this->autoriza_cremar->options(false);
            $this->autoriza_cremar->PlaceHolder = RemoveHtml($this->autoriza_cremar->caption());

            // username_autoriza
            $this->username_autoriza->setupEditAttributes();
            if (!$this->username_autoriza->Raw) {
                $this->username_autoriza->CurrentValue = HtmlDecode($this->username_autoriza->CurrentValue);
            }
            $this->username_autoriza->EditValue = HtmlEncode($this->username_autoriza->CurrentValue);
            $this->username_autoriza->PlaceHolder = RemoveHtml($this->username_autoriza->caption());

            // fecha_autoriza
            $this->fecha_autoriza->setupEditAttributes();
            $this->fecha_autoriza->EditValue = HtmlEncode(FormatDateTime($this->fecha_autoriza->CurrentValue, $this->fecha_autoriza->formatPattern()));
            $this->fecha_autoriza->PlaceHolder = RemoveHtml($this->fecha_autoriza->caption());

            // peso
            $this->peso->setupEditAttributes();
            if (!$this->peso->Raw) {
                $this->peso->CurrentValue = HtmlDecode($this->peso->CurrentValue);
            }
            $this->peso->EditValue = HtmlEncode($this->peso->CurrentValue);
            $this->peso->PlaceHolder = RemoveHtml($this->peso->caption());

            // contrato_parcela
            $this->contrato_parcela->setupEditAttributes();
            if (!$this->contrato_parcela->Raw) {
                $this->contrato_parcela->CurrentValue = HtmlDecode($this->contrato_parcela->CurrentValue);
            }
            $this->contrato_parcela->EditValue = HtmlEncode($this->contrato_parcela->CurrentValue);
            $this->contrato_parcela->PlaceHolder = RemoveHtml($this->contrato_parcela->caption());

            // email_calidad
            $this->email_calidad->EditValue = $this->email_calidad->options(false);
            $this->email_calidad->PlaceHolder = RemoveHtml($this->email_calidad->caption());

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

            // Edit refer script

            // Nexpediente
            $this->Nexpediente->HrefValue = "";

            // tipo_contratacion
            $this->tipo_contratacion->HrefValue = "";

            // seguro
            $this->seguro->HrefValue = "";

            // nacionalidad_contacto
            $this->nacionalidad_contacto->HrefValue = "";

            // cedula_contacto
            $this->cedula_contacto->HrefValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";

            // apellidos_contacto
            $this->apellidos_contacto->HrefValue = "";

            // parentesco_contacto
            $this->parentesco_contacto->HrefValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->HrefValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";

            // sexo
            $this->sexo->HrefValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";

            // edad_fallecido
            $this->edad_fallecido->HrefValue = "";

            // estado_civil
            $this->estado_civil->HrefValue = "";

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->HrefValue = "";

            // lugar_ocurrencia
            $this->lugar_ocurrencia->HrefValue = "";

            // direccion_ocurrencia
            $this->direccion_ocurrencia->HrefValue = "";

            // fecha_ocurrencia
            $this->fecha_ocurrencia->HrefValue = "";

            // hora_ocurrencia
            $this->hora_ocurrencia->HrefValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";

            // causa_otro
            $this->causa_otro->HrefValue = "";

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->HrefValue = "";

            // calidad
            $this->calidad->HrefValue = "";

            // costos
            $this->costos->HrefValue = "";

            // venta
            $this->venta->HrefValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";

            // user_cierra
            $this->user_cierra->HrefValue = "";

            // fecha_cierre
            $this->fecha_cierre->HrefValue = "";

            // estatus
            $this->estatus->HrefValue = "";

            // factura
            $this->factura->HrefValue = "";

            // permiso
            $this->permiso->HrefValue = "";

            // unir_con_expediente
            $this->unir_con_expediente->HrefValue = "";

            // nota
            $this->nota->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // religion
            $this->religion->HrefValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";

            // servicio
            $this->servicio->HrefValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";

            // marca_pasos
            $this->marca_pasos->HrefValue = "";

            // autoriza_cremar
            $this->autoriza_cremar->HrefValue = "";

            // username_autoriza
            $this->username_autoriza->HrefValue = "";

            // fecha_autoriza
            $this->fecha_autoriza->HrefValue = "";

            // peso
            $this->peso->HrefValue = "";

            // contrato_parcela
            $this->contrato_parcela->HrefValue = "";

            // email_calidad
            $this->email_calidad->HrefValue = "";

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
            if ($this->Nexpediente->Visible && $this->Nexpediente->Required) {
                if (!$this->Nexpediente->IsDetailKey && EmptyValue($this->Nexpediente->FormValue)) {
                    $this->Nexpediente->addErrorMessage(str_replace("%s", $this->Nexpediente->caption(), $this->Nexpediente->RequiredErrorMessage));
                }
            }
            if ($this->tipo_contratacion->Visible && $this->tipo_contratacion->Required) {
                if (!$this->tipo_contratacion->IsDetailKey && EmptyValue($this->tipo_contratacion->FormValue)) {
                    $this->tipo_contratacion->addErrorMessage(str_replace("%s", $this->tipo_contratacion->caption(), $this->tipo_contratacion->RequiredErrorMessage));
                }
            }
            if ($this->seguro->Visible && $this->seguro->Required) {
                if (!$this->seguro->IsDetailKey && EmptyValue($this->seguro->FormValue)) {
                    $this->seguro->addErrorMessage(str_replace("%s", $this->seguro->caption(), $this->seguro->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->seguro->FormValue)) {
                $this->seguro->addErrorMessage($this->seguro->getErrorMessage(false));
            }
            if ($this->nacionalidad_contacto->Visible && $this->nacionalidad_contacto->Required) {
                if (!$this->nacionalidad_contacto->IsDetailKey && EmptyValue($this->nacionalidad_contacto->FormValue)) {
                    $this->nacionalidad_contacto->addErrorMessage(str_replace("%s", $this->nacionalidad_contacto->caption(), $this->nacionalidad_contacto->RequiredErrorMessage));
                }
            }
            if ($this->cedula_contacto->Visible && $this->cedula_contacto->Required) {
                if (!$this->cedula_contacto->IsDetailKey && EmptyValue($this->cedula_contacto->FormValue)) {
                    $this->cedula_contacto->addErrorMessage(str_replace("%s", $this->cedula_contacto->caption(), $this->cedula_contacto->RequiredErrorMessage));
                }
            }
            if ($this->nombre_contacto->Visible && $this->nombre_contacto->Required) {
                if (!$this->nombre_contacto->IsDetailKey && EmptyValue($this->nombre_contacto->FormValue)) {
                    $this->nombre_contacto->addErrorMessage(str_replace("%s", $this->nombre_contacto->caption(), $this->nombre_contacto->RequiredErrorMessage));
                }
            }
            if ($this->apellidos_contacto->Visible && $this->apellidos_contacto->Required) {
                if (!$this->apellidos_contacto->IsDetailKey && EmptyValue($this->apellidos_contacto->FormValue)) {
                    $this->apellidos_contacto->addErrorMessage(str_replace("%s", $this->apellidos_contacto->caption(), $this->apellidos_contacto->RequiredErrorMessage));
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
            if ($this->nacionalidad_fallecido->Visible && $this->nacionalidad_fallecido->Required) {
                if (!$this->nacionalidad_fallecido->IsDetailKey && EmptyValue($this->nacionalidad_fallecido->FormValue)) {
                    $this->nacionalidad_fallecido->addErrorMessage(str_replace("%s", $this->nacionalidad_fallecido->caption(), $this->nacionalidad_fallecido->RequiredErrorMessage));
                }
            }
            if ($this->cedula_fallecido->Visible && $this->cedula_fallecido->Required) {
                if (!$this->cedula_fallecido->IsDetailKey && EmptyValue($this->cedula_fallecido->FormValue)) {
                    $this->cedula_fallecido->addErrorMessage(str_replace("%s", $this->cedula_fallecido->caption(), $this->cedula_fallecido->RequiredErrorMessage));
                }
            }
            if ($this->sexo->Visible && $this->sexo->Required) {
                if (!$this->sexo->IsDetailKey && EmptyValue($this->sexo->FormValue)) {
                    $this->sexo->addErrorMessage(str_replace("%s", $this->sexo->caption(), $this->sexo->RequiredErrorMessage));
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
            if ($this->fecha_nacimiento->Visible && $this->fecha_nacimiento->Required) {
                if (!$this->fecha_nacimiento->IsDetailKey && EmptyValue($this->fecha_nacimiento->FormValue)) {
                    $this->fecha_nacimiento->addErrorMessage(str_replace("%s", $this->fecha_nacimiento->caption(), $this->fecha_nacimiento->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_nacimiento->FormValue, $this->fecha_nacimiento->formatPattern())) {
                $this->fecha_nacimiento->addErrorMessage($this->fecha_nacimiento->getErrorMessage(false));
            }
            if ($this->edad_fallecido->Visible && $this->edad_fallecido->Required) {
                if (!$this->edad_fallecido->IsDetailKey && EmptyValue($this->edad_fallecido->FormValue)) {
                    $this->edad_fallecido->addErrorMessage(str_replace("%s", $this->edad_fallecido->caption(), $this->edad_fallecido->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->edad_fallecido->FormValue)) {
                $this->edad_fallecido->addErrorMessage($this->edad_fallecido->getErrorMessage(false));
            }
            if ($this->estado_civil->Visible && $this->estado_civil->Required) {
                if (!$this->estado_civil->IsDetailKey && EmptyValue($this->estado_civil->FormValue)) {
                    $this->estado_civil->addErrorMessage(str_replace("%s", $this->estado_civil->caption(), $this->estado_civil->RequiredErrorMessage));
                }
            }
            if ($this->lugar_nacimiento_fallecido->Visible && $this->lugar_nacimiento_fallecido->Required) {
                if (!$this->lugar_nacimiento_fallecido->IsDetailKey && EmptyValue($this->lugar_nacimiento_fallecido->FormValue)) {
                    $this->lugar_nacimiento_fallecido->addErrorMessage(str_replace("%s", $this->lugar_nacimiento_fallecido->caption(), $this->lugar_nacimiento_fallecido->RequiredErrorMessage));
                }
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
            if ($this->hora_ocurrencia->Visible && $this->hora_ocurrencia->Required) {
                if (!$this->hora_ocurrencia->IsDetailKey && EmptyValue($this->hora_ocurrencia->FormValue)) {
                    $this->hora_ocurrencia->addErrorMessage(str_replace("%s", $this->hora_ocurrencia->caption(), $this->hora_ocurrencia->RequiredErrorMessage));
                }
            }
            if (!CheckTime($this->hora_ocurrencia->FormValue, $this->hora_ocurrencia->formatPattern())) {
                $this->hora_ocurrencia->addErrorMessage($this->hora_ocurrencia->getErrorMessage(false));
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
            if ($this->descripcion_ocurrencia->Visible && $this->descripcion_ocurrencia->Required) {
                if (!$this->descripcion_ocurrencia->IsDetailKey && EmptyValue($this->descripcion_ocurrencia->FormValue)) {
                    $this->descripcion_ocurrencia->addErrorMessage(str_replace("%s", $this->descripcion_ocurrencia->caption(), $this->descripcion_ocurrencia->RequiredErrorMessage));
                }
            }
            if ($this->calidad->Visible && $this->calidad->Required) {
                if (!$this->calidad->IsDetailKey && EmptyValue($this->calidad->FormValue)) {
                    $this->calidad->addErrorMessage(str_replace("%s", $this->calidad->caption(), $this->calidad->RequiredErrorMessage));
                }
            }
            if ($this->costos->Visible && $this->costos->Required) {
                if (!$this->costos->IsDetailKey && EmptyValue($this->costos->FormValue)) {
                    $this->costos->addErrorMessage(str_replace("%s", $this->costos->caption(), $this->costos->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->costos->FormValue)) {
                $this->costos->addErrorMessage($this->costos->getErrorMessage(false));
            }
            if ($this->venta->Visible && $this->venta->Required) {
                if (!$this->venta->IsDetailKey && EmptyValue($this->venta->FormValue)) {
                    $this->venta->addErrorMessage(str_replace("%s", $this->venta->caption(), $this->venta->RequiredErrorMessage));
                }
            }
            if (!CheckNumber($this->venta->FormValue)) {
                $this->venta->addErrorMessage($this->venta->getErrorMessage(false));
            }
            if ($this->user_registra->Visible && $this->user_registra->Required) {
                if (!$this->user_registra->IsDetailKey && EmptyValue($this->user_registra->FormValue)) {
                    $this->user_registra->addErrorMessage(str_replace("%s", $this->user_registra->caption(), $this->user_registra->RequiredErrorMessage));
                }
            }
            if ($this->fecha_registro->Visible && $this->fecha_registro->Required) {
                if (!$this->fecha_registro->IsDetailKey && EmptyValue($this->fecha_registro->FormValue)) {
                    $this->fecha_registro->addErrorMessage(str_replace("%s", $this->fecha_registro->caption(), $this->fecha_registro->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_registro->FormValue, $this->fecha_registro->formatPattern())) {
                $this->fecha_registro->addErrorMessage($this->fecha_registro->getErrorMessage(false));
            }
            if ($this->user_cierra->Visible && $this->user_cierra->Required) {
                if (!$this->user_cierra->IsDetailKey && EmptyValue($this->user_cierra->FormValue)) {
                    $this->user_cierra->addErrorMessage(str_replace("%s", $this->user_cierra->caption(), $this->user_cierra->RequiredErrorMessage));
                }
            }
            if ($this->fecha_cierre->Visible && $this->fecha_cierre->Required) {
                if (!$this->fecha_cierre->IsDetailKey && EmptyValue($this->fecha_cierre->FormValue)) {
                    $this->fecha_cierre->addErrorMessage(str_replace("%s", $this->fecha_cierre->caption(), $this->fecha_cierre->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_cierre->FormValue, $this->fecha_cierre->formatPattern())) {
                $this->fecha_cierre->addErrorMessage($this->fecha_cierre->getErrorMessage(false));
            }
            if ($this->estatus->Visible && $this->estatus->Required) {
                if (!$this->estatus->IsDetailKey && EmptyValue($this->estatus->FormValue)) {
                    $this->estatus->addErrorMessage(str_replace("%s", $this->estatus->caption(), $this->estatus->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->estatus->FormValue)) {
                $this->estatus->addErrorMessage($this->estatus->getErrorMessage(false));
            }
            if ($this->factura->Visible && $this->factura->Required) {
                if (!$this->factura->IsDetailKey && EmptyValue($this->factura->FormValue)) {
                    $this->factura->addErrorMessage(str_replace("%s", $this->factura->caption(), $this->factura->RequiredErrorMessage));
                }
            }
            if ($this->permiso->Visible && $this->permiso->Required) {
                if (!$this->permiso->IsDetailKey && EmptyValue($this->permiso->FormValue)) {
                    $this->permiso->addErrorMessage(str_replace("%s", $this->permiso->caption(), $this->permiso->RequiredErrorMessage));
                }
            }
            if ($this->unir_con_expediente->Visible && $this->unir_con_expediente->Required) {
                if (!$this->unir_con_expediente->IsDetailKey && EmptyValue($this->unir_con_expediente->FormValue)) {
                    $this->unir_con_expediente->addErrorMessage(str_replace("%s", $this->unir_con_expediente->caption(), $this->unir_con_expediente->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->unir_con_expediente->FormValue)) {
                $this->unir_con_expediente->addErrorMessage($this->unir_con_expediente->getErrorMessage(false));
            }
            if ($this->nota->Visible && $this->nota->Required) {
                if (!$this->nota->IsDetailKey && EmptyValue($this->nota->FormValue)) {
                    $this->nota->addErrorMessage(str_replace("%s", $this->nota->caption(), $this->nota->RequiredErrorMessage));
                }
            }
            if ($this->_email->Visible && $this->_email->Required) {
                if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                    $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
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
            if ($this->funeraria->Visible && $this->funeraria->Required) {
                if (!$this->funeraria->IsDetailKey && EmptyValue($this->funeraria->FormValue)) {
                    $this->funeraria->addErrorMessage(str_replace("%s", $this->funeraria->caption(), $this->funeraria->RequiredErrorMessage));
                }
            }
            if (!CheckInteger($this->funeraria->FormValue)) {
                $this->funeraria->addErrorMessage($this->funeraria->getErrorMessage(false));
            }
            if ($this->marca_pasos->Visible && $this->marca_pasos->Required) {
                if ($this->marca_pasos->FormValue == "") {
                    $this->marca_pasos->addErrorMessage(str_replace("%s", $this->marca_pasos->caption(), $this->marca_pasos->RequiredErrorMessage));
                }
            }
            if ($this->autoriza_cremar->Visible && $this->autoriza_cremar->Required) {
                if ($this->autoriza_cremar->FormValue == "") {
                    $this->autoriza_cremar->addErrorMessage(str_replace("%s", $this->autoriza_cremar->caption(), $this->autoriza_cremar->RequiredErrorMessage));
                }
            }
            if ($this->username_autoriza->Visible && $this->username_autoriza->Required) {
                if (!$this->username_autoriza->IsDetailKey && EmptyValue($this->username_autoriza->FormValue)) {
                    $this->username_autoriza->addErrorMessage(str_replace("%s", $this->username_autoriza->caption(), $this->username_autoriza->RequiredErrorMessage));
                }
            }
            if ($this->fecha_autoriza->Visible && $this->fecha_autoriza->Required) {
                if (!$this->fecha_autoriza->IsDetailKey && EmptyValue($this->fecha_autoriza->FormValue)) {
                    $this->fecha_autoriza->addErrorMessage(str_replace("%s", $this->fecha_autoriza->caption(), $this->fecha_autoriza->RequiredErrorMessage));
                }
            }
            if (!CheckDate($this->fecha_autoriza->FormValue, $this->fecha_autoriza->formatPattern())) {
                $this->fecha_autoriza->addErrorMessage($this->fecha_autoriza->getErrorMessage(false));
            }
            if ($this->peso->Visible && $this->peso->Required) {
                if (!$this->peso->IsDetailKey && EmptyValue($this->peso->FormValue)) {
                    $this->peso->addErrorMessage(str_replace("%s", $this->peso->caption(), $this->peso->RequiredErrorMessage));
                }
            }
            if ($this->contrato_parcela->Visible && $this->contrato_parcela->Required) {
                if (!$this->contrato_parcela->IsDetailKey && EmptyValue($this->contrato_parcela->FormValue)) {
                    $this->contrato_parcela->addErrorMessage(str_replace("%s", $this->contrato_parcela->caption(), $this->contrato_parcela->RequiredErrorMessage));
                }
            }
            if ($this->email_calidad->Visible && $this->email_calidad->Required) {
                if ($this->email_calidad->FormValue == "") {
                    $this->email_calidad->addErrorMessage(str_replace("%s", $this->email_calidad->caption(), $this->email_calidad->RequiredErrorMessage));
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

        // tipo_contratacion
        $this->tipo_contratacion->setDbValueDef($rsnew, $this->tipo_contratacion->CurrentValue, $this->tipo_contratacion->ReadOnly);

        // seguro
        $this->seguro->setDbValueDef($rsnew, $this->seguro->CurrentValue, $this->seguro->ReadOnly);

        // nacionalidad_contacto
        $this->nacionalidad_contacto->setDbValueDef($rsnew, $this->nacionalidad_contacto->CurrentValue, $this->nacionalidad_contacto->ReadOnly);

        // cedula_contacto
        $this->cedula_contacto->setDbValueDef($rsnew, $this->cedula_contacto->CurrentValue, $this->cedula_contacto->ReadOnly);

        // nombre_contacto
        $this->nombre_contacto->setDbValueDef($rsnew, $this->nombre_contacto->CurrentValue, $this->nombre_contacto->ReadOnly);

        // apellidos_contacto
        $this->apellidos_contacto->setDbValueDef($rsnew, $this->apellidos_contacto->CurrentValue, $this->apellidos_contacto->ReadOnly);

        // parentesco_contacto
        $this->parentesco_contacto->setDbValueDef($rsnew, $this->parentesco_contacto->CurrentValue, $this->parentesco_contacto->ReadOnly);

        // telefono_contacto1
        $this->telefono_contacto1->setDbValueDef($rsnew, $this->telefono_contacto1->CurrentValue, $this->telefono_contacto1->ReadOnly);

        // telefono_contacto2
        $this->telefono_contacto2->setDbValueDef($rsnew, $this->telefono_contacto2->CurrentValue, $this->telefono_contacto2->ReadOnly);

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->setDbValueDef($rsnew, $this->nacionalidad_fallecido->CurrentValue, $this->nacionalidad_fallecido->ReadOnly);

        // cedula_fallecido
        $this->cedula_fallecido->setDbValueDef($rsnew, $this->cedula_fallecido->CurrentValue, $this->cedula_fallecido->ReadOnly);

        // sexo
        $this->sexo->setDbValueDef($rsnew, $this->sexo->CurrentValue, $this->sexo->ReadOnly);

        // nombre_fallecido
        $this->nombre_fallecido->setDbValueDef($rsnew, $this->nombre_fallecido->CurrentValue, $this->nombre_fallecido->ReadOnly);

        // apellidos_fallecido
        $this->apellidos_fallecido->setDbValueDef($rsnew, $this->apellidos_fallecido->CurrentValue, $this->apellidos_fallecido->ReadOnly);

        // fecha_nacimiento
        $this->fecha_nacimiento->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern()), $this->fecha_nacimiento->ReadOnly);

        // edad_fallecido
        $this->edad_fallecido->setDbValueDef($rsnew, $this->edad_fallecido->CurrentValue, $this->edad_fallecido->ReadOnly);

        // estado_civil
        $this->estado_civil->setDbValueDef($rsnew, $this->estado_civil->CurrentValue, $this->estado_civil->ReadOnly);

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->setDbValueDef($rsnew, $this->lugar_nacimiento_fallecido->CurrentValue, $this->lugar_nacimiento_fallecido->ReadOnly);

        // lugar_ocurrencia
        $this->lugar_ocurrencia->setDbValueDef($rsnew, $this->lugar_ocurrencia->CurrentValue, $this->lugar_ocurrencia->ReadOnly);

        // direccion_ocurrencia
        $this->direccion_ocurrencia->setDbValueDef($rsnew, $this->direccion_ocurrencia->CurrentValue, $this->direccion_ocurrencia->ReadOnly);

        // fecha_ocurrencia
        $this->fecha_ocurrencia->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern()), $this->fecha_ocurrencia->ReadOnly);

        // hora_ocurrencia
        $this->hora_ocurrencia->setDbValueDef($rsnew, UnFormatDateTime($this->hora_ocurrencia->CurrentValue, $this->hora_ocurrencia->formatPattern()), $this->hora_ocurrencia->ReadOnly);

        // causa_ocurrencia
        $this->causa_ocurrencia->setDbValueDef($rsnew, $this->causa_ocurrencia->CurrentValue, $this->causa_ocurrencia->ReadOnly);

        // causa_otro
        $this->causa_otro->setDbValueDef($rsnew, $this->causa_otro->CurrentValue, $this->causa_otro->ReadOnly);

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->setDbValueDef($rsnew, $this->descripcion_ocurrencia->CurrentValue, $this->descripcion_ocurrencia->ReadOnly);

        // calidad
        $this->calidad->setDbValueDef($rsnew, $this->calidad->CurrentValue, $this->calidad->ReadOnly);

        // costos
        $this->costos->setDbValueDef($rsnew, $this->costos->CurrentValue, $this->costos->ReadOnly);

        // venta
        $this->venta->setDbValueDef($rsnew, $this->venta->CurrentValue, $this->venta->ReadOnly);

        // user_registra
        $this->user_registra->setDbValueDef($rsnew, $this->user_registra->CurrentValue, $this->user_registra->ReadOnly);

        // fecha_registro
        $this->fecha_registro->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern()), $this->fecha_registro->ReadOnly);

        // user_cierra
        $this->user_cierra->setDbValueDef($rsnew, $this->user_cierra->CurrentValue, $this->user_cierra->ReadOnly);

        // fecha_cierre
        $this->fecha_cierre->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_cierre->CurrentValue, $this->fecha_cierre->formatPattern()), $this->fecha_cierre->ReadOnly);

        // estatus
        $this->estatus->setDbValueDef($rsnew, $this->estatus->CurrentValue, $this->estatus->ReadOnly);

        // factura
        $this->factura->setDbValueDef($rsnew, $this->factura->CurrentValue, $this->factura->ReadOnly);

        // permiso
        $this->permiso->setDbValueDef($rsnew, $this->permiso->CurrentValue, $this->permiso->ReadOnly);

        // unir_con_expediente
        $this->unir_con_expediente->setDbValueDef($rsnew, $this->unir_con_expediente->CurrentValue, $this->unir_con_expediente->ReadOnly);

        // nota
        $this->nota->setDbValueDef($rsnew, $this->nota->CurrentValue, $this->nota->ReadOnly);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, $this->_email->ReadOnly);

        // religion
        $this->religion->setDbValueDef($rsnew, $this->religion->CurrentValue, $this->religion->ReadOnly);

        // servicio_tipo
        $this->servicio_tipo->setDbValueDef($rsnew, $this->servicio_tipo->CurrentValue, $this->servicio_tipo->ReadOnly);

        // servicio
        $this->servicio->setDbValueDef($rsnew, $this->servicio->CurrentValue, $this->servicio->ReadOnly);

        // funeraria
        $this->funeraria->setDbValueDef($rsnew, $this->funeraria->CurrentValue, $this->funeraria->ReadOnly);

        // marca_pasos
        $this->marca_pasos->setDbValueDef($rsnew, $this->marca_pasos->CurrentValue, $this->marca_pasos->ReadOnly);

        // autoriza_cremar
        $this->autoriza_cremar->setDbValueDef($rsnew, $this->autoriza_cremar->CurrentValue, $this->autoriza_cremar->ReadOnly);

        // username_autoriza
        $this->username_autoriza->setDbValueDef($rsnew, $this->username_autoriza->CurrentValue, $this->username_autoriza->ReadOnly);

        // fecha_autoriza
        $this->fecha_autoriza->setDbValueDef($rsnew, UnFormatDateTime($this->fecha_autoriza->CurrentValue, $this->fecha_autoriza->formatPattern()), $this->fecha_autoriza->ReadOnly);

        // peso
        $this->peso->setDbValueDef($rsnew, $this->peso->CurrentValue, $this->peso->ReadOnly);

        // contrato_parcela
        $this->contrato_parcela->setDbValueDef($rsnew, $this->contrato_parcela->CurrentValue, $this->contrato_parcela->ReadOnly);

        // email_calidad
        $this->email_calidad->setDbValueDef($rsnew, $this->email_calidad->CurrentValue, $this->email_calidad->ReadOnly);

        // certificado_defuncion
        $this->certificado_defuncion->setDbValueDef($rsnew, $this->certificado_defuncion->CurrentValue, $this->certificado_defuncion->ReadOnly);

        // parcela
        $this->parcela->setDbValueDef($rsnew, $this->parcela->CurrentValue, $this->parcela->ReadOnly);
        return $rsnew;
    }

    /**
     * Restore edit form from row
     * @param array $row Row
     */
    protected function restoreEditFormFromRow($row)
    {
        if (isset($row['tipo_contratacion'])) { // tipo_contratacion
            $this->tipo_contratacion->CurrentValue = $row['tipo_contratacion'];
        }
        if (isset($row['seguro'])) { // seguro
            $this->seguro->CurrentValue = $row['seguro'];
        }
        if (isset($row['nacionalidad_contacto'])) { // nacionalidad_contacto
            $this->nacionalidad_contacto->CurrentValue = $row['nacionalidad_contacto'];
        }
        if (isset($row['cedula_contacto'])) { // cedula_contacto
            $this->cedula_contacto->CurrentValue = $row['cedula_contacto'];
        }
        if (isset($row['nombre_contacto'])) { // nombre_contacto
            $this->nombre_contacto->CurrentValue = $row['nombre_contacto'];
        }
        if (isset($row['apellidos_contacto'])) { // apellidos_contacto
            $this->apellidos_contacto->CurrentValue = $row['apellidos_contacto'];
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
        if (isset($row['nacionalidad_fallecido'])) { // nacionalidad_fallecido
            $this->nacionalidad_fallecido->CurrentValue = $row['nacionalidad_fallecido'];
        }
        if (isset($row['cedula_fallecido'])) { // cedula_fallecido
            $this->cedula_fallecido->CurrentValue = $row['cedula_fallecido'];
        }
        if (isset($row['sexo'])) { // sexo
            $this->sexo->CurrentValue = $row['sexo'];
        }
        if (isset($row['nombre_fallecido'])) { // nombre_fallecido
            $this->nombre_fallecido->CurrentValue = $row['nombre_fallecido'];
        }
        if (isset($row['apellidos_fallecido'])) { // apellidos_fallecido
            $this->apellidos_fallecido->CurrentValue = $row['apellidos_fallecido'];
        }
        if (isset($row['fecha_nacimiento'])) { // fecha_nacimiento
            $this->fecha_nacimiento->CurrentValue = $row['fecha_nacimiento'];
        }
        if (isset($row['edad_fallecido'])) { // edad_fallecido
            $this->edad_fallecido->CurrentValue = $row['edad_fallecido'];
        }
        if (isset($row['estado_civil'])) { // estado_civil
            $this->estado_civil->CurrentValue = $row['estado_civil'];
        }
        if (isset($row['lugar_nacimiento_fallecido'])) { // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->CurrentValue = $row['lugar_nacimiento_fallecido'];
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
        if (isset($row['hora_ocurrencia'])) { // hora_ocurrencia
            $this->hora_ocurrencia->CurrentValue = $row['hora_ocurrencia'];
        }
        if (isset($row['causa_ocurrencia'])) { // causa_ocurrencia
            $this->causa_ocurrencia->CurrentValue = $row['causa_ocurrencia'];
        }
        if (isset($row['causa_otro'])) { // causa_otro
            $this->causa_otro->CurrentValue = $row['causa_otro'];
        }
        if (isset($row['descripcion_ocurrencia'])) { // descripcion_ocurrencia
            $this->descripcion_ocurrencia->CurrentValue = $row['descripcion_ocurrencia'];
        }
        if (isset($row['calidad'])) { // calidad
            $this->calidad->CurrentValue = $row['calidad'];
        }
        if (isset($row['costos'])) { // costos
            $this->costos->CurrentValue = $row['costos'];
        }
        if (isset($row['venta'])) { // venta
            $this->venta->CurrentValue = $row['venta'];
        }
        if (isset($row['user_registra'])) { // user_registra
            $this->user_registra->CurrentValue = $row['user_registra'];
        }
        if (isset($row['fecha_registro'])) { // fecha_registro
            $this->fecha_registro->CurrentValue = $row['fecha_registro'];
        }
        if (isset($row['user_cierra'])) { // user_cierra
            $this->user_cierra->CurrentValue = $row['user_cierra'];
        }
        if (isset($row['fecha_cierre'])) { // fecha_cierre
            $this->fecha_cierre->CurrentValue = $row['fecha_cierre'];
        }
        if (isset($row['estatus'])) { // estatus
            $this->estatus->CurrentValue = $row['estatus'];
        }
        if (isset($row['factura'])) { // factura
            $this->factura->CurrentValue = $row['factura'];
        }
        if (isset($row['permiso'])) { // permiso
            $this->permiso->CurrentValue = $row['permiso'];
        }
        if (isset($row['unir_con_expediente'])) { // unir_con_expediente
            $this->unir_con_expediente->CurrentValue = $row['unir_con_expediente'];
        }
        if (isset($row['nota'])) { // nota
            $this->nota->CurrentValue = $row['nota'];
        }
        if (isset($row['email'])) { // email
            $this->_email->CurrentValue = $row['email'];
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
        if (isset($row['funeraria'])) { // funeraria
            $this->funeraria->CurrentValue = $row['funeraria'];
        }
        if (isset($row['marca_pasos'])) { // marca_pasos
            $this->marca_pasos->CurrentValue = $row['marca_pasos'];
        }
        if (isset($row['autoriza_cremar'])) { // autoriza_cremar
            $this->autoriza_cremar->CurrentValue = $row['autoriza_cremar'];
        }
        if (isset($row['username_autoriza'])) { // username_autoriza
            $this->username_autoriza->CurrentValue = $row['username_autoriza'];
        }
        if (isset($row['fecha_autoriza'])) { // fecha_autoriza
            $this->fecha_autoriza->CurrentValue = $row['fecha_autoriza'];
        }
        if (isset($row['peso'])) { // peso
            $this->peso->CurrentValue = $row['peso'];
        }
        if (isset($row['contrato_parcela'])) { // contrato_parcela
            $this->contrato_parcela->CurrentValue = $row['contrato_parcela'];
        }
        if (isset($row['email_calidad'])) { // email_calidad
            $this->email_calidad->CurrentValue = $row['email_calidad'];
        }
        if (isset($row['certificado_defuncion'])) { // certificado_defuncion
            $this->certificado_defuncion->CurrentValue = $row['certificado_defuncion'];
        }
        if (isset($row['parcela'])) { // parcela
            $this->parcela->CurrentValue = $row['parcela'];
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoExpedienteOldList"), "", $this->TableVar, true);
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
                case "x_marca_pasos":
                    break;
                case "x_autoriza_cremar":
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
