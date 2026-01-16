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
class ScoExpedienteDelete extends ScoExpediente
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteDelete";

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
        $this->Nexpediente->setVisibility();
        $this->contrato_parcela->Visible = false;
        $this->tipo_contratacion->Visible = false;
        $this->seguro->Visible = false;
        $this->nacionalidad_contacto->Visible = false;
        $this->cedula_contacto->Visible = false;
        $this->nombre_contacto->setVisibility();
        $this->apellidos_contacto->Visible = false;
        $this->parentesco_contacto->Visible = false;
        $this->telefono_contacto1->Visible = false;
        $this->telefono_contacto2->Visible = false;
        $this->_email->Visible = false;
        $this->nacionalidad_fallecido->Visible = false;
        $this->cedula_fallecido->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->sexo->Visible = false;
        $this->fecha_nacimiento->Visible = false;
        $this->edad_fallecido->Visible = false;
        $this->estado_civil->Visible = false;
        $this->lugar_nacimiento_fallecido->Visible = false;
        $this->lugar_ocurrencia->Visible = false;
        $this->direccion_ocurrencia->Visible = false;
        $this->fecha_ocurrencia->Visible = false;
        $this->hora_ocurrencia->Visible = false;
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->Visible = false;
        $this->descripcion_ocurrencia->Visible = false;
        $this->religion->Visible = false;
        $this->permiso->Visible = false;
        $this->costos->Visible = false;
        $this->venta->setVisibility();
        $this->user_registra->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->user_cierra->Visible = false;
        $this->fecha_cierre->Visible = false;
        $this->calidad->Visible = false;
        $this->factura->Visible = false;
        $this->unir_con_expediente->Visible = false;
        $this->estatus->setVisibility();
        $this->nota->Visible = false;
        $this->funeraria->Visible = false;
        $this->servicio_tipo->Visible = false;
        $this->servicio->Visible = false;
        $this->marca_pasos->Visible = false;
        $this->peso->Visible = false;
        $this->autoriza_cremar->Visible = false;
        $this->certificado_defuncion->Visible = false;
        $this->parcela->Visible = false;
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
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("ScoExpedienteList"); // Prevent SQL injection, return to list
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
                $this->terminate("ScoExpedienteList"); // Return to list
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Nexpediente

        // contrato_parcela

        // tipo_contratacion

        // seguro

        // nacionalidad_contacto

        // cedula_contacto

        // nombre_contacto

        // apellidos_contacto

        // parentesco_contacto

        // telefono_contacto1

        // telefono_contacto2

        // email

        // nacionalidad_fallecido

        // cedula_fallecido

        // nombre_fallecido

        // apellidos_fallecido

        // sexo

        // fecha_nacimiento

        // edad_fallecido

        // estado_civil

        // lugar_nacimiento_fallecido

        // lugar_ocurrencia

        // direccion_ocurrencia

        // fecha_ocurrencia

        // hora_ocurrencia

        // causa_ocurrencia

        // causa_otro

        // descripcion_ocurrencia

        // religion

        // permiso

        // costos

        // venta

        // user_registra

        // fecha_registro

        // user_cierra

        // fecha_cierre

        // calidad

        // factura

        // unir_con_expediente

        // estatus

        // nota

        // funeraria

        // servicio_tipo

        // servicio

        // marca_pasos

        // peso

        // autoriza_cremar

        // certificado_defuncion

        // parcela

        // username_autoriza

        // fecha_autoriza

        // email_calidad

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

            // Nexpediente
            $this->Nexpediente->HrefValue = "";
            $this->Nexpediente->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";
            $this->nombre_contacto->TooltipValue = "";

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

            // venta
            $this->venta->HrefValue = "";
            $this->venta->TooltipValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";
            $this->user_registra->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";
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
            $thisKey .= $row['Nexpediente'];

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoExpedienteList"), "", $this->TableVar, true);
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
