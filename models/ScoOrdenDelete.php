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
class ScoOrdenDelete extends ScoOrden
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoOrdenDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoOrdenDelete";

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
        $this->expediente->Visible = false;
        $this->Norden->Visible = false;
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->proveedor->Visible = false;
        $this->responsable_servicio->Visible = false;
        $this->paso->Visible = false;
        $this->nota->Visible = false;
        $this->fecha_inicio->Visible = false;
        $this->hora_inicio->Visible = false;
        $this->horas->Visible = false;
        $this->fecha_fin->Visible = false;
        $this->hora_fin->Visible = false;
        $this->capilla->Visible = false;
        $this->cantidad->setVisibility();
        $this->costo->Visible = false;
        $this->total->Visible = false;
        $this->referencia_ubicacion->Visible = false;
        $this->anulada->Visible = false;
        $this->user_registra->setVisibility();
        $this->fecha_registro->Visible = false;
        $this->media_hora->Visible = false;
        $this->espera_cenizas->Visible = false;
        $this->adjunto->Visible = false;
        $this->llevar_a->Visible = false;
        $this->servicio_atendido->Visible = false;
        $this->ministro->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_orden';
        $this->TableName = 'sco_orden';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_orden)
        if (!isset($GLOBALS["sco_orden"]) || $GLOBALS["sco_orden"]::class == PROJECT_NAMESPACE . "sco_orden") {
            $GLOBALS["sco_orden"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_orden');
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->Norden->Visible = false;
        }
    }
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
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
        $this->setupLookupOptions($this->servicio_tipo);
        $this->setupLookupOptions($this->servicio);
        $this->setupLookupOptions($this->proveedor);
        $this->setupLookupOptions($this->anulada);
        $this->setupLookupOptions($this->user_registra);
        $this->setupLookupOptions($this->espera_cenizas);
        $this->setupLookupOptions($this->ministro);

        // Set up master/detail parameters
        $this->setupMasterParms();

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("ScoOrdenList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson(["success" => false, "error" => $this->getFailureMessage()]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            $this->Recordset = $this->loadRecordset();
            if ($this->TotalRecords <= 0) { // No record found, exit
                $this->Recordset?->free();
                $this->terminate("ScoOrdenList"); // Return to list
                return;
            }
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
        $this->expediente->setDbValue($row['expediente']);
        $this->Norden->setDbValue($row['Norden']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->responsable_servicio->setDbValue($row['responsable_servicio']);
        $this->paso->setDbValue($row['paso']);
        $this->nota->setDbValue($row['nota']);
        $this->fecha_inicio->setDbValue($row['fecha_inicio']);
        $this->hora_inicio->setDbValue($row['hora_inicio']);
        $this->horas->setDbValue($row['horas']);
        $this->fecha_fin->setDbValue($row['fecha_fin']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->capilla->setDbValue($row['capilla']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->costo->setDbValue($row['costo']);
        $this->total->setDbValue($row['total']);
        $this->referencia_ubicacion->setDbValue($row['referencia_ubicacion']);
        $this->anulada->setDbValue($row['anulada']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->media_hora->setDbValue($row['media_hora']);
        $this->espera_cenizas->setDbValue($row['espera_cenizas']);
        $this->adjunto->setDbValue($row['adjunto']);
        $this->llevar_a->setDbValue($row['llevar_a']);
        $this->servicio_atendido->setDbValue($row['servicio_atendido']);
        $this->ministro->setDbValue($row['ministro']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['expediente'] = $this->expediente->DefaultValue;
        $row['Norden'] = $this->Norden->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['proveedor'] = $this->proveedor->DefaultValue;
        $row['responsable_servicio'] = $this->responsable_servicio->DefaultValue;
        $row['paso'] = $this->paso->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['fecha_inicio'] = $this->fecha_inicio->DefaultValue;
        $row['hora_inicio'] = $this->hora_inicio->DefaultValue;
        $row['horas'] = $this->horas->DefaultValue;
        $row['fecha_fin'] = $this->fecha_fin->DefaultValue;
        $row['hora_fin'] = $this->hora_fin->DefaultValue;
        $row['capilla'] = $this->capilla->DefaultValue;
        $row['cantidad'] = $this->cantidad->DefaultValue;
        $row['costo'] = $this->costo->DefaultValue;
        $row['total'] = $this->total->DefaultValue;
        $row['referencia_ubicacion'] = $this->referencia_ubicacion->DefaultValue;
        $row['anulada'] = $this->anulada->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['media_hora'] = $this->media_hora->DefaultValue;
        $row['espera_cenizas'] = $this->espera_cenizas->DefaultValue;
        $row['adjunto'] = $this->adjunto->DefaultValue;
        $row['llevar_a'] = $this->llevar_a->DefaultValue;
        $row['servicio_atendido'] = $this->servicio_atendido->DefaultValue;
        $row['ministro'] = $this->ministro->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // expediente

        // Norden

        // servicio_tipo

        // servicio

        // proveedor

        // responsable_servicio

        // paso

        // nota

        // fecha_inicio

        // hora_inicio

        // horas

        // fecha_fin

        // hora_fin

        // capilla

        // cantidad

        // costo

        // total

        // referencia_ubicacion

        // anulada

        // user_registra

        // fecha_registro

        // media_hora

        // espera_cenizas

        // adjunto

        // llevar_a

        // servicio_atendido

        // ministro

        // View row
        if ($this->RowType == RowType::VIEW) {
            // expediente
            $this->expediente->ViewValue = $this->expediente->CurrentValue;

            // Norden
            $this->Norden->ViewValue = $this->Norden->CurrentValue;

            // servicio_tipo
            $curVal = strval($this->servicio_tipo->CurrentValue);
            if ($curVal != "") {
                $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
                if ($this->servicio_tipo->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $curVal, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                    $sqlWrk = $this->servicio_tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
                    $sqlWrk = $this->servicio->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

            // proveedor
            $curVal = strval($this->proveedor->CurrentValue);
            if ($curVal != "") {
                $this->proveedor->ViewValue = $this->proveedor->lookupCacheOption($curVal);
                if ($this->proveedor->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $curVal, $this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                    $sqlWrk = $this->proveedor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->proveedor->Lookup->renderViewRow($rswrk[0]);
                        $this->proveedor->ViewValue = $this->proveedor->displayValue($arwrk);
                    } else {
                        $this->proveedor->ViewValue = $this->proveedor->CurrentValue;
                    }
                }
            } else {
                $this->proveedor->ViewValue = null;
            }

            // responsable_servicio
            $this->responsable_servicio->ViewValue = $this->responsable_servicio->CurrentValue;

            // paso
            $this->paso->ViewValue = $this->paso->CurrentValue;

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // fecha_inicio
            $this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;
            $this->fecha_inicio->ViewValue = FormatDateTime($this->fecha_inicio->ViewValue, $this->fecha_inicio->formatPattern());

            // hora_inicio
            $this->hora_inicio->ViewValue = $this->hora_inicio->CurrentValue;
            $this->hora_inicio->ViewValue = FormatDateTime($this->hora_inicio->ViewValue, $this->hora_inicio->formatPattern());

            // horas
            $this->horas->ViewValue = $this->horas->CurrentValue;

            // fecha_fin
            $this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;
            $this->fecha_fin->ViewValue = FormatDateTime($this->fecha_fin->ViewValue, $this->fecha_fin->formatPattern());

            // hora_fin
            $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;

            // capilla
            $this->capilla->ViewValue = $this->capilla->CurrentValue;

            // cantidad
            $this->cantidad->ViewValue = $this->cantidad->CurrentValue;

            // costo
            $this->costo->ViewValue = $this->costo->CurrentValue;
            $this->costo->ViewValue = FormatCurrency($this->costo->ViewValue, $this->costo->formatPattern());

            // total
            $this->total->ViewValue = $this->total->CurrentValue;
            $this->total->ViewValue = FormatCurrency($this->total->ViewValue, $this->total->formatPattern());

            // referencia_ubicacion
            $this->referencia_ubicacion->ViewValue = $this->referencia_ubicacion->CurrentValue;

            // anulada
            if (strval($this->anulada->CurrentValue) != "") {
                $this->anulada->ViewValue = $this->anulada->optionCaption($this->anulada->CurrentValue);
            } else {
                $this->anulada->ViewValue = null;
            }

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

            // media_hora
            $this->media_hora->ViewValue = $this->media_hora->CurrentValue;

            // espera_cenizas
            if (strval($this->espera_cenizas->CurrentValue) != "") {
                $this->espera_cenizas->ViewValue = $this->espera_cenizas->optionCaption($this->espera_cenizas->CurrentValue);
            } else {
                $this->espera_cenizas->ViewValue = null;
            }

            // adjunto
            $this->adjunto->ViewValue = $this->adjunto->CurrentValue;

            // llevar_a
            $this->llevar_a->ViewValue = $this->llevar_a->CurrentValue;

            // servicio_atendido
            $this->servicio_atendido->ViewValue = $this->servicio_atendido->CurrentValue;

            // ministro
            $this->ministro->ViewValue = $this->ministro->CurrentValue;
            $curVal = strval($this->ministro->CurrentValue);
            if ($curVal != "") {
                $this->ministro->ViewValue = $this->ministro->lookupCacheOption($curVal);
                if ($this->ministro->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->ministro->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->ministro->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                    $sqlWrk = $this->ministro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->ministro->Lookup->renderViewRow($rswrk[0]);
                        $this->ministro->ViewValue = $this->ministro->displayValue($arwrk);
                    } else {
                        $this->ministro->ViewValue = $this->ministro->CurrentValue;
                    }
                }
            } else {
                $this->ministro->ViewValue = null;
            }

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";
            $this->servicio_tipo->TooltipValue = "";

            // servicio
            $this->servicio->HrefValue = "";
            $this->servicio->TooltipValue = "";

            // cantidad
            $this->cantidad->HrefValue = "";
            $this->cantidad->TooltipValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";
            $this->user_registra->TooltipValue = "";

            // ministro
            $this->ministro->HrefValue = "";
            $this->ministro->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }
        if ($this->AuditTrailOnDelete) {
            $this->writeAuditTrailDummy($Language->phrase("BatchDeleteBegin")); // Batch delete begin
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['Norden'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                if ($conn->isTransactionActive()) {
                    $conn->commit();
                }
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteRecordsFailed")));
            }
            if ($this->AuditTrailOnDelete) {
                $this->writeAuditTrailDummy($Language->phrase("BatchDeleteSuccess")); // Batch delete success
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                if ($conn->isTransactionActive()) {
                    $conn->rollback();
                }
            }
            if ($this->AuditTrailOnDelete) {
                $this->writeAuditTrailDummy($Language->phrase("BatchDeleteRollback")); // Batch delete rollback
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromRecordset($rsold);
            $table = $this->TableVar;
            if (Param("key_m") === null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
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
                if (($parm = Get("fk_Nexpediente", Get("expediente"))) !== null) {
                    $masterTbl->Nexpediente->setQueryStringValue($parm);
                    $this->expediente->QueryStringValue = $masterTbl->Nexpediente->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->expediente->setSessionValue($this->expediente->QueryStringValue);
                    $foreignKeys["expediente"] = $this->expediente->QueryStringValue;
                    if (!is_numeric($masterTbl->Nexpediente->QueryStringValue)) {
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
            if ($masterTblVar == "sco_expediente") {
                $validMaster = true;
                $masterTbl = Container("sco_expediente");
                if (($parm = Post("fk_Nexpediente", Post("expediente"))) !== null) {
                    $masterTbl->Nexpediente->setFormValue($parm);
                    $this->expediente->FormValue = $masterTbl->Nexpediente->FormValue;
                    $this->expediente->setSessionValue($this->expediente->FormValue);
                    $foreignKeys["expediente"] = $this->expediente->FormValue;
                    if (!is_numeric($masterTbl->Nexpediente->FormValue)) {
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
            if ($masterTblVar != "sco_expediente") {
                if (!array_key_exists("expediente", $foreignKeys)) { // Not current foreign key
                    $this->expediente->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoOrdenList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
                case "x_servicio_tipo":
                    break;
                case "x_servicio":
                    break;
                case "x_proveedor":
                    break;
                case "x_anulada":
                    break;
                case "x_user_registra":
                    break;
                case "x_espera_cenizas":
                    break;
                case "x_ministro":
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
}
