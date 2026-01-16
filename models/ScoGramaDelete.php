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
class ScoGramaDelete extends ScoGrama
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoGramaDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoGramaDelete";

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
        $this->telefono1->Visible = false;
        $this->telefono2->Visible = false;
        $this->_email->Visible = false;
        $this->tipo->setVisibility();
        $this->subtipo->Visible = false;
        $this->monto->setVisibility();
        $this->tasa->Visible = false;
        $this->monto_bs->Visible = false;
        $this->nota->Visible = false;
        $this->contrato->setVisibility();
        $this->seccion->setVisibility();
        $this->modulo->setVisibility();
        $this->sub_seccion->setVisibility();
        $this->parcela->setVisibility();
        $this->boveda->Visible = false;
        $this->ci_difunto->Visible = false;
        $this->apellido1->Visible = false;
        $this->apellido2->Visible = false;
        $this->nombre1->Visible = false;
        $this->nombre2->Visible = false;
        $this->fecha_solucion->Visible = false;
        $this->fecha_desde->Visible = false;
        $this->fecha_hasta->Visible = false;
        $this->estatus->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->usuario_registro->Visible = false;
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
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

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
        $this->setupLookupOptions($this->tipo);
        $this->setupLookupOptions($this->subtipo);
        $this->setupLookupOptions($this->estatus);
        $this->setupLookupOptions($this->email_renovacion);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("ScoGramaList"); // Prevent SQL injection, return to list
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
                $this->terminate("ScoGramaList"); // Return to list
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Ngrama

        // ci_solicitante

        // solicitante

        // telefono1

        // telefono2

        // email

        // tipo

        // subtipo

        // monto

        // tasa

        // monto_bs

        // nota

        // contrato

        // seccion

        // modulo

        // sub_seccion

        // parcela

        // boveda

        // ci_difunto

        // apellido1

        // apellido2

        // nombre1

        // nombre2

        // fecha_solucion

        // fecha_desde

        // fecha_hasta

        // estatus

        // fecha_registro

        // usuario_registro

        // email_renovacion

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
            $this->Ngrama->TooltipValue = "";

            // ci_solicitante
            $this->ci_solicitante->HrefValue = "";
            $this->ci_solicitante->TooltipValue = "";

            // solicitante
            $this->solicitante->HrefValue = "";
            $this->solicitante->TooltipValue = "";

            // tipo
            $this->tipo->HrefValue = "";
            $this->tipo->TooltipValue = "";

            // monto
            $this->monto->HrefValue = "";
            $this->monto->TooltipValue = "";

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

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";
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
            $thisKey .= $row['Ngrama'];

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoGramaList"), "", $this->TableVar, true);
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
