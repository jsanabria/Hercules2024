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
 * Table class for sco_flota_incidencia
 */
class ScoFlotaIncidencia extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Audit trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = true;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $Nflota_incidencia;
    public $fecha_registro;
    public $flota;
    public $tipo;
    public $falla;
    public $nota;
    public $solicitante;
    public $diagnostico;
    public $reparacion;
    public $cambio_aceite;
    public $kilometraje;
    public $cantidad;
    public $proveedor;
    public $monto;
    public $_username;
    public $username_diagnostica;
    public $fecha_reparacion;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_flota_incidencia";
        $this->TableName = 'sco_flota_incidencia';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_flota_incidencia";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "null"; // Page orientation (PDF only)
        $this->ExportPageSize = ""; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // Nflota_incidencia
        $this->Nflota_incidencia = new DbField(
            $this, // Table
            'x_Nflota_incidencia', // Variable name
            'Nflota_incidencia', // Name
            '`Nflota_incidencia`', // Expression
            '`Nflota_incidencia`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nflota_incidencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nflota_incidencia->InputTextType = "text";
        $this->Nflota_incidencia->Raw = true;
        $this->Nflota_incidencia->IsAutoIncrement = true; // Autoincrement field
        $this->Nflota_incidencia->IsPrimaryKey = true; // Primary key field
        $this->Nflota_incidencia->IsForeignKey = true; // Foreign key field
        $this->Nflota_incidencia->Nullable = false; // NOT NULL field
        $this->Nflota_incidencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nflota_incidencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nflota_incidencia'] = &$this->Nflota_incidencia;

        // fecha_registro
        $this->fecha_registro = new DbField(
            $this, // Table
            'x_fecha_registro', // Variable name
            'fecha_registro', // Name
            '`fecha_registro`', // Expression
            CastDateFieldForLike("`fecha_registro`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_registro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_registro->addMethod("getDefault", fn() => date('Y-m-d H:i:s'));
        $this->fecha_registro->InputTextType = "text";
        $this->fecha_registro->Raw = true;
        $this->fecha_registro->Required = true; // Required field
        $this->fecha_registro->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_registro'] = &$this->fecha_registro;

        // flota
        $this->flota = new DbField(
            $this, // Table
            'x_flota', // Variable name
            'flota', // Name
            '`flota`', // Expression
            '`flota`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`flota`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->flota->addMethod("getSelectFilter", fn() => ($this->PageID == "add" ? "`activo` = 'S'" : ""));
        $this->flota->InputTextType = "text";
        $this->flota->Raw = true;
        $this->flota->Required = true; // Required field
        $this->flota->Lookup = new Lookup($this->flota, 'sco_flota', false, 'Nflota', ["placa","tipo","anho","color"], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`placa`, ''),'" . ValueSeparator(1, $this->flota) . "',COALESCE(`tipo`,''),'" . ValueSeparator(2, $this->flota) . "',COALESCE(`anho`,''),'" . ValueSeparator(3, $this->flota) . "',COALESCE(`color`,''))");
        $this->flota->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->flota->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['flota'] = &$this->flota;

        // tipo
        $this->tipo = new DbField(
            $this, // Table
            'x_tipo', // Variable name
            'tipo', // Name
            '`tipo`', // Expression
            '`tipo`', // Basic search expression
            200, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo->InputTextType = "text";
        $this->tipo->Required = true; // Required field
        $this->tipo->setSelectMultiple(false); // Select one
        $this->tipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo->Lookup = new Lookup($this->tipo, 'sco_flota_incidencia', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->tipo->OptionCount = 3;
        $this->tipo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo'] = &$this->tipo;

        // falla
        $this->falla = new DbField(
            $this, // Table
            'x_falla', // Variable name
            'falla', // Name
            '`falla`', // Expression
            '`falla`', // Basic search expression
            200, // Type
            6, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`falla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->falla->addMethod("getSelectFilter", fn() => "`tabla` = 'FALLASVH'");
        $this->falla->InputTextType = "text";
        $this->falla->setSelectMultiple(false); // Select one
        $this->falla->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->falla->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->falla->Lookup = new Lookup($this->falla, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->falla->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['falla'] = &$this->falla;

        // nota
        $this->nota = new DbField(
            $this, // Table
            'x_nota', // Variable name
            'nota', // Name
            '`nota`', // Expression
            '`nota`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nota`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->nota->InputTextType = "text";
        $this->nota->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nota'] = &$this->nota;

        // solicitante
        $this->solicitante = new DbField(
            $this, // Table
            'x_solicitante', // Variable name
            'solicitante', // Name
            '`solicitante`', // Expression
            '`solicitante`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`solicitante`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->solicitante->InputTextType = "text";
        $this->solicitante->Required = true; // Required field
        $this->solicitante->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['solicitante'] = &$this->solicitante;

        // diagnostico
        $this->diagnostico = new DbField(
            $this, // Table
            'x_diagnostico', // Variable name
            'diagnostico', // Name
            '`diagnostico`', // Expression
            '`diagnostico`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`diagnostico`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->diagnostico->InputTextType = "text";
        $this->diagnostico->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['diagnostico'] = &$this->diagnostico;

        // reparacion
        $this->reparacion = new DbField(
            $this, // Table
            'x_reparacion', // Variable name
            'reparacion', // Name
            '`reparacion`', // Expression
            '`reparacion`', // Basic search expression
            200, // Type
            6, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`reparacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->reparacion->addMethod("getSelectFilter", fn() => "`tabla` = 'REPARARVH'");
        $this->reparacion->InputTextType = "text";
        $this->reparacion->setSelectMultiple(false); // Select one
        $this->reparacion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->reparacion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->reparacion->Lookup = new Lookup($this->reparacion, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->reparacion->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['reparacion'] = &$this->reparacion;

        // cambio_aceite
        $this->cambio_aceite = new DbField(
            $this, // Table
            'x_cambio_aceite', // Variable name
            'cambio_aceite', // Name
            '`cambio_aceite`', // Expression
            '`cambio_aceite`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cambio_aceite`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->cambio_aceite->addMethod("getDefault", fn() => "N");
        $this->cambio_aceite->InputTextType = "text";
        $this->cambio_aceite->Raw = true;
        $this->cambio_aceite->Required = true; // Required field
        $this->cambio_aceite->setSelectMultiple(false); // Select one
        $this->cambio_aceite->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cambio_aceite->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cambio_aceite->Lookup = new Lookup($this->cambio_aceite, 'sco_flota_incidencia', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->cambio_aceite->OptionCount = 2;
        $this->cambio_aceite->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['cambio_aceite'] = &$this->cambio_aceite;

        // kilometraje
        $this->kilometraje = new DbField(
            $this, // Table
            'x_kilometraje', // Variable name
            'kilometraje', // Name
            '`kilometraje`', // Expression
            '`kilometraje`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`kilometraje`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->kilometraje->InputTextType = "text";
        $this->kilometraje->Raw = true;
        $this->kilometraje->Required = true; // Required field
        $this->kilometraje->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kilometraje->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['kilometraje'] = &$this->kilometraje;

        // cantidad
        $this->cantidad = new DbField(
            $this, // Table
            'x_cantidad', // Variable name
            'cantidad', // Name
            '`cantidad`', // Expression
            '`cantidad`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cantidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cantidad->InputTextType = "text";
        $this->cantidad->Raw = true;
        $this->cantidad->Required = true; // Required field
        $this->cantidad->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cantidad->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['cantidad'] = &$this->cantidad;

        // proveedor
        $this->proveedor = new DbField(
            $this, // Table
            'x_proveedor', // Variable name
            'proveedor', // Name
            '`proveedor`', // Expression
            '`proveedor`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`proveedor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->proveedor->addMethod("getSelectFilter", fn() => "`tipo_proveedor` = 'Talleres'");
        $this->proveedor->InputTextType = "text";
        $this->proveedor->Raw = true;
        $this->proveedor->setSelectMultiple(false); // Select one
        $this->proveedor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->proveedor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->proveedor->Lookup = new Lookup($this->proveedor, 'sco_proveedor', false, 'Nproveedor', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->proveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proveedor->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['proveedor'] = &$this->proveedor;

        // monto
        $this->monto = new DbField(
            $this, // Table
            'x_monto', // Variable name
            'monto', // Name
            '`monto`', // Expression
            '`monto`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`monto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->monto->InputTextType = "text";
        $this->monto->Raw = true;
        $this->monto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['monto'] = &$this->monto;

        // username
        $this->_username = new DbField(
            $this, // Table
            'x__username', // Variable name
            'username', // Name
            '`username`', // Expression
            '`username`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`username`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_username->addMethod("getAutoUpdateValue", fn() => CurrentUserName());
        $this->_username->InputTextType = "text";
        $this->_username->Lookup = new Lookup($this->_username, 'sco_user', false, 'username', ["username","nombre","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`username`, ''),'" . ValueSeparator(1, $this->_username) . "',COALESCE(`nombre`,''))");
        $this->_username->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['username'] = &$this->_username;

        // username_diagnostica
        $this->username_diagnostica = new DbField(
            $this, // Table
            'x_username_diagnostica', // Variable name
            'username_diagnostica', // Name
            '`username_diagnostica`', // Expression
            '`username_diagnostica`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`username_diagnostica`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->username_diagnostica->InputTextType = "text";
        $this->username_diagnostica->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['username_diagnostica'] = &$this->username_diagnostica;

        // fecha_reparacion
        $this->fecha_reparacion = new DbField(
            $this, // Table
            'x_fecha_reparacion', // Variable name
            'fecha_reparacion', // Name
            '`fecha_reparacion`', // Expression
            CastDateFieldForLike("`fecha_reparacion`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_reparacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_reparacion->InputTextType = "text";
        $this->fecha_reparacion->Raw = true;
        $this->fecha_reparacion->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_reparacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_reparacion'] = &$this->fecha_reparacion;

        // Add Doctrine Cache
        $this->Cache = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")) ?? "";
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "sco_flota_incidencia_detalle") {
            $detailUrl = Container("sco_flota_incidencia_detalle")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nflota_incidencia", $this->Nflota_incidencia->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_adjunto") {
            $detailUrl = Container("sco_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nflota_incidencia", $this->Nflota_incidencia->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoFlotaIncidenciaList";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_flota_incidencia";
    }

    // Get FROM clause (for backward compatibility)
    public function sqlFrom()
    {
        return $this->getSqlFrom();
    }

    // Set FROM clause
    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    // Get SELECT clause
    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select($this->sqlSelectFields());
    }

    // Get list of fields
    private function sqlSelectFields()
    {
        $useFieldNames = false;
        $fieldNames = [];
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($this->Fields as $field) {
            $expr = $field->Expression;
            $customExpr = $field->CustomDataType?->convertToPHPValueSQL($expr, $platform) ?? $expr;
            if ($customExpr != $expr) {
                $fieldNames[] = $customExpr . " AS " . QuotedName($field->Name, $this->Dbid);
                $useFieldNames = true;
            } else {
                $fieldNames[] = $expr;
            }
        }
        return $useFieldNames ? implode(", ", $fieldNames) : "*";
    }

    // Get SELECT clause (for backward compatibility)
    public function sqlSelect()
    {
        return $this->getSqlSelect();
    }

    // Set SELECT clause
    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    // Get WHERE clause
    public function getSqlWhere()
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    // Get WHERE clause (for backward compatibility)
    public function sqlWhere()
    {
        return $this->getSqlWhere();
    }

    // Set WHERE clause
    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    // Get GROUP BY clause
    public function getSqlGroupBy()
    {
        return $this->SqlGroupBy != "" ? $this->SqlGroupBy : "";
    }

    // Get GROUP BY clause (for backward compatibility)
    public function sqlGroupBy()
    {
        return $this->getSqlGroupBy();
    }

    // set GROUP BY clause
    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    // Get HAVING clause
    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    // Get HAVING clause (for backward compatibility)
    public function sqlHaving()
    {
        return $this->getSqlHaving();
    }

    // Set HAVING clause
    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    // Get ORDER BY clause
    public function getSqlOrderBy()
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    // Get ORDER BY clause (for backward compatibility)
    public function sqlOrderBy()
    {
        return $this->getSqlOrderBy();
    }

    // set ORDER BY clause
    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return ($allow & Allow::ADD->value) == Allow::ADD->value;
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return ($allow & Allow::EDIT->value) == Allow::EDIT->value;
            case "delete":
                return ($allow & Allow::DELETE->value) == Allow::DELETE->value;
            case "view":
                return ($allow & Allow::VIEW->value) == Allow::VIEW->value;
            case "search":
                return ($allow & Allow::SEARCH->value) == Allow::SEARCH->value;
            case "lookup":
                return ($allow & Allow::LOOKUP->value) == Allow::LOOKUP->value;
            default:
                return ($allow & Allow::LIST->value) == Allow::LIST->value;
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $sqlwrk = $sql instanceof QueryBuilder // Query builder
            ? (clone $sql)->resetQueryPart("orderBy")->getSQL()
            : $sql;
        $pattern = '/^SELECT\s([\s\S]+?)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            in_array($this->TableType, ["TABLE", "VIEW", "LINKTABLE"]) &&
            preg_match($pattern, $sqlwrk) &&
            !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*SELECT\s+DISTINCT\s+/i', $sqlwrk) &&
            !preg_match('/\s+ORDER\s+BY\s+/i', $sqlwrk)
        ) {
            $sqlcnt = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlcnt = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlcnt);
        if ($cnt !== false) {
            return (int)$cnt;
        }
        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        $result = $conn->executeQuery($sqlwrk);
        $cnt = $result->rowCount();
        if ($cnt == 0) { // Unable to get record count, count directly
            while ($result->fetch()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $isCustomView = $this->TableType == "CUSTOMVIEW";
        $select = $isCustomView ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $isCustomView ? $this->getSqlGroupBy() : "";
        $having = $isCustomView ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->setValue($field->Expression, $parm);
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $queryBuilder = $this->insertSql($rs);
            $result = $queryBuilder->executeStatement();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $result = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($result) {
            $this->Nflota_incidencia->setDbValue($conn->lastInsertId());
            $rs['Nflota_incidencia'] = $this->Nflota_incidencia->DbValue;
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailOnAdd($rs);
            }
        }
        return $result;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        $platform = $this->getConnection()->getDatabasePlatform();
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $field = $this->Fields[$name];
            $parm = $queryBuilder->createPositionalParameter($value, $field->getParameterType());
            $parm = $field->CustomDataType?->convertToDatabaseValueSQL($parm, $platform) ?? $parm; // Convert database SQL
            $queryBuilder->set($field->Expression, $parm);
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // Cascade Update detail table 'sco_adjunto'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nflota_incidencia']) && $rsold['Nflota_incidencia'] != $rs['Nflota_incidencia'])) { // Update detail field 'flota_incidencia'
            $cascadeUpdate = true;
            $rscascade['flota_incidencia'] = $rs['Nflota_incidencia'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_adjunto")->loadRs("`flota_incidencia` = " . QuotedValue($rsold['Nflota_incidencia'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nadjunto';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_adjunto")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_adjunto")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_adjunto")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['Nflota_incidencia']) && !EmptyValue($this->Nflota_incidencia->CurrentValue)) {
                $rs['Nflota_incidencia'] = $this->Nflota_incidencia->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nflota_incidencia';
            if (!array_key_exists($fldname, $rsaudit)) {
                $rsaudit[$fldname] = $rsold[$fldname];
            }
            $this->writeAuditTrailOnEdit($rsold, $rsaudit);
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('Nflota_incidencia', $rs)) {
                AddFilter($where, QuotedName('Nflota_incidencia', $this->Dbid) . '=' . QuotedValue($rs['Nflota_incidencia'], $this->Nflota_incidencia->DataType, $this->Dbid));
            }
        }
        $filter = $curfilter ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;

        // Cascade delete detail table 'sco_adjunto'
        $dtlrows = Container("sco_adjunto")->loadRs("`flota_incidencia` = " . QuotedValue($rs['Nflota_incidencia'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_adjunto")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_adjunto")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_adjunto")->rowDeleted($dtlrow);
            }
        }
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->executeStatement();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        if ($success && $this->AuditTrailOnDelete) {
            $this->writeAuditTrailOnDelete($rs);
        }
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->Nflota_incidencia->DbValue = $row['Nflota_incidencia'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->flota->DbValue = $row['flota'];
        $this->tipo->DbValue = $row['tipo'];
        $this->falla->DbValue = $row['falla'];
        $this->nota->DbValue = $row['nota'];
        $this->solicitante->DbValue = $row['solicitante'];
        $this->diagnostico->DbValue = $row['diagnostico'];
        $this->reparacion->DbValue = $row['reparacion'];
        $this->cambio_aceite->DbValue = $row['cambio_aceite'];
        $this->kilometraje->DbValue = $row['kilometraje'];
        $this->cantidad->DbValue = $row['cantidad'];
        $this->proveedor->DbValue = $row['proveedor'];
        $this->monto->DbValue = $row['monto'];
        $this->_username->DbValue = $row['username'];
        $this->username_diagnostica->DbValue = $row['username_diagnostica'];
        $this->fecha_reparacion->DbValue = $row['fecha_reparacion'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nflota_incidencia` = @Nflota_incidencia@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nflota_incidencia->CurrentValue : $this->Nflota_incidencia->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->Nflota_incidencia->CurrentValue = $keys[0];
            } else {
                $this->Nflota_incidencia->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nflota_incidencia', $row) ? $row['Nflota_incidencia'] : null;
        } else {
            $val = !EmptyValue($this->Nflota_incidencia->OldValue) && !$current ? $this->Nflota_incidencia->OldValue : $this->Nflota_incidencia->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nflota_incidencia@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("ScoFlotaIncidenciaList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        return match ($pageName) {
            "ScoFlotaIncidenciaView" => $Language->phrase("View"),
            "ScoFlotaIncidenciaEdit" => $Language->phrase("Edit"),
            "ScoFlotaIncidenciaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoFlotaIncidenciaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoFlotaIncidenciaView",
            Config("API_ADD_ACTION") => "ScoFlotaIncidenciaAdd",
            Config("API_EDIT_ACTION") => "ScoFlotaIncidenciaEdit",
            Config("API_DELETE_ACTION") => "ScoFlotaIncidenciaDelete",
            Config("API_LIST_ACTION") => "ScoFlotaIncidenciaList",
            default => ""
        };
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "ScoFlotaIncidenciaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoFlotaIncidenciaView", $parm);
        } else {
            $url = $this->keyUrl("ScoFlotaIncidenciaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoFlotaIncidenciaAdd?" . $parm;
        } else {
            $url = "ScoFlotaIncidenciaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoFlotaIncidenciaEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoFlotaIncidenciaEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoFlotaIncidenciaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoFlotaIncidenciaAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoFlotaIncidenciaAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoFlotaIncidenciaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoFlotaIncidenciaDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Nflota_incidencia\":" . VarToJson($this->Nflota_incidencia->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nflota_incidencia->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nflota_incidencia->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($this->PageID != "grid" && $fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($this->PageID != "grid" && !$this->isExport() && $fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") .
                (is_array($fld->EditValue) ? str_replace("%c", count($fld->EditValue), $Language->phrase("FilterCount")) : '') .
                '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;" . Config("PAGE_DASHBOARD") . "=" . $DashboardReport;
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 0))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 0))) // Other API
                : []; // Non-API
            if (($keyValue = Param("Nflota_incidencia") ?? Route("Nflota_incidencia")) !== null) {
                $arKeys[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        return implode(" OR ", array_map(fn($row) => "(" . $this->getRecordFilter($row) . ")", $rows));
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->Nflota_incidencia->CurrentValue = $key;
            } else {
                $this->Nflota_incidencia->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load result set based on filter/sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->Nflota_incidencia->setDbValue($row['Nflota_incidencia']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->flota->setDbValue($row['flota']);
        $this->tipo->setDbValue($row['tipo']);
        $this->falla->setDbValue($row['falla']);
        $this->nota->setDbValue($row['nota']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->diagnostico->setDbValue($row['diagnostico']);
        $this->reparacion->setDbValue($row['reparacion']);
        $this->cambio_aceite->setDbValue($row['cambio_aceite']);
        $this->kilometraje->setDbValue($row['kilometraje']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->monto->setDbValue($row['monto']);
        $this->_username->setDbValue($row['username']);
        $this->username_diagnostica->setDbValue($row['username_diagnostica']);
        $this->fecha_reparacion->setDbValue($row['fecha_reparacion']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoFlotaIncidenciaList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("app.view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // Nflota_incidencia

        // fecha_registro

        // flota

        // tipo

        // falla

        // nota

        // solicitante

        // diagnostico

        // reparacion

        // cambio_aceite

        // kilometraje

        // cantidad

        // proveedor

        // monto

        // username

        // username_diagnostica

        // fecha_reparacion

        // Nflota_incidencia
        $this->Nflota_incidencia->ViewValue = $this->Nflota_incidencia->CurrentValue;

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

        // flota
        $this->flota->ViewValue = $this->flota->CurrentValue;
        $curVal = strval($this->flota->CurrentValue);
        if ($curVal != "") {
            $this->flota->ViewValue = $this->flota->lookupCacheOption($curVal);
            if ($this->flota->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->flota->Lookup->getTable()->Fields["Nflota"]->searchExpression(), "=", $curVal, $this->flota->Lookup->getTable()->Fields["Nflota"]->searchDataType(), "");
                $lookupFilter = $this->flota->getSelectFilter($this); // PHP
                $sqlWrk = $this->flota->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->flota->Lookup->renderViewRow($rswrk[0]);
                    $this->flota->ViewValue = $this->flota->displayValue($arwrk);
                } else {
                    $this->flota->ViewValue = $this->flota->CurrentValue;
                }
            }
        } else {
            $this->flota->ViewValue = null;
        }

        // tipo
        if (strval($this->tipo->CurrentValue) != "") {
            $this->tipo->ViewValue = $this->tipo->optionCaption($this->tipo->CurrentValue);
        } else {
            $this->tipo->ViewValue = null;
        }

        // falla
        $curVal = strval($this->falla->CurrentValue);
        if ($curVal != "") {
            $this->falla->ViewValue = $this->falla->lookupCacheOption($curVal);
            if ($this->falla->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->falla->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->falla->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                $lookupFilter = $this->falla->getSelectFilter($this); // PHP
                $sqlWrk = $this->falla->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->falla->Lookup->renderViewRow($rswrk[0]);
                    $this->falla->ViewValue = $this->falla->displayValue($arwrk);
                } else {
                    $this->falla->ViewValue = $this->falla->CurrentValue;
                }
            }
        } else {
            $this->falla->ViewValue = null;
        }

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // solicitante
        $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

        // diagnostico
        $this->diagnostico->ViewValue = $this->diagnostico->CurrentValue;

        // reparacion
        $curVal = strval($this->reparacion->CurrentValue);
        if ($curVal != "") {
            $this->reparacion->ViewValue = $this->reparacion->lookupCacheOption($curVal);
            if ($this->reparacion->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->reparacion->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->reparacion->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                $lookupFilter = $this->reparacion->getSelectFilter($this); // PHP
                $sqlWrk = $this->reparacion->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->reparacion->Lookup->renderViewRow($rswrk[0]);
                    $this->reparacion->ViewValue = $this->reparacion->displayValue($arwrk);
                } else {
                    $this->reparacion->ViewValue = $this->reparacion->CurrentValue;
                }
            }
        } else {
            $this->reparacion->ViewValue = null;
        }

        // cambio_aceite
        if (strval($this->cambio_aceite->CurrentValue) != "") {
            $this->cambio_aceite->ViewValue = $this->cambio_aceite->optionCaption($this->cambio_aceite->CurrentValue);
        } else {
            $this->cambio_aceite->ViewValue = null;
        }

        // kilometraje
        $this->kilometraje->ViewValue = $this->kilometraje->CurrentValue;

        // cantidad
        $this->cantidad->ViewValue = $this->cantidad->CurrentValue;

        // proveedor
        $curVal = strval($this->proveedor->CurrentValue);
        if ($curVal != "") {
            $this->proveedor->ViewValue = $this->proveedor->lookupCacheOption($curVal);
            if ($this->proveedor->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchExpression(), "=", $curVal, $this->proveedor->Lookup->getTable()->Fields["Nproveedor"]->searchDataType(), "");
                $lookupFilter = $this->proveedor->getSelectFilter($this); // PHP
                $sqlWrk = $this->proveedor->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // monto
        $this->monto->ViewValue = $this->monto->CurrentValue;
        $this->monto->ViewValue = FormatCurrency($this->monto->ViewValue, $this->monto->formatPattern());

        // username
        $this->_username->ViewValue = $this->_username->CurrentValue;
        $curVal = strval($this->_username->CurrentValue);
        if ($curVal != "") {
            $this->_username->ViewValue = $this->_username->lookupCacheOption($curVal);
            if ($this->_username->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->_username->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->_username->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->_username->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->_username->Lookup->renderViewRow($rswrk[0]);
                    $this->_username->ViewValue = $this->_username->displayValue($arwrk);
                } else {
                    $this->_username->ViewValue = $this->_username->CurrentValue;
                }
            }
        } else {
            $this->_username->ViewValue = null;
        }

        // username_diagnostica
        $this->username_diagnostica->ViewValue = $this->username_diagnostica->CurrentValue;

        // fecha_reparacion
        $this->fecha_reparacion->ViewValue = $this->fecha_reparacion->CurrentValue;
        $this->fecha_reparacion->ViewValue = FormatDateTime($this->fecha_reparacion->ViewValue, $this->fecha_reparacion->formatPattern());

        // Nflota_incidencia
        $this->Nflota_incidencia->HrefValue = "";
        $this->Nflota_incidencia->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // flota
        $this->flota->HrefValue = "";
        $this->flota->TooltipValue = "";

        // tipo
        $this->tipo->HrefValue = "";
        $this->tipo->TooltipValue = "";

        // falla
        $this->falla->HrefValue = "";
        $this->falla->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // solicitante
        $this->solicitante->HrefValue = "";
        $this->solicitante->TooltipValue = "";

        // diagnostico
        $this->diagnostico->HrefValue = "";
        $this->diagnostico->TooltipValue = "";

        // reparacion
        $this->reparacion->HrefValue = "";
        $this->reparacion->TooltipValue = "";

        // cambio_aceite
        $this->cambio_aceite->HrefValue = "";
        $this->cambio_aceite->TooltipValue = "";

        // kilometraje
        $this->kilometraje->HrefValue = "";
        $this->kilometraje->TooltipValue = "";

        // cantidad
        $this->cantidad->HrefValue = "";
        $this->cantidad->TooltipValue = "";

        // proveedor
        $this->proveedor->HrefValue = "";
        $this->proveedor->TooltipValue = "";

        // monto
        $this->monto->HrefValue = "";
        $this->monto->TooltipValue = "";

        // username
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // username_diagnostica
        $this->username_diagnostica->HrefValue = "";
        $this->username_diagnostica->TooltipValue = "";

        // fecha_reparacion
        $this->fecha_reparacion->HrefValue = "";
        $this->fecha_reparacion->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Nflota_incidencia
        $this->Nflota_incidencia->setupEditAttributes();
        $this->Nflota_incidencia->EditValue = $this->Nflota_incidencia->CurrentValue;

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->EditValue, $this->fecha_registro->formatPattern());

        // flota
        $this->flota->setupEditAttributes();
        $this->flota->EditValue = $this->flota->CurrentValue;
        $this->flota->PlaceHolder = RemoveHtml($this->flota->caption());

        // tipo
        $this->tipo->setupEditAttributes();
        $this->tipo->EditValue = $this->tipo->options(true);
        $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

        // falla
        $this->falla->setupEditAttributes();
        $this->falla->PlaceHolder = RemoveHtml($this->falla->caption());

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // solicitante
        $this->solicitante->setupEditAttributes();
        if (!$this->solicitante->Raw) {
            $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
        }
        $this->solicitante->EditValue = $this->solicitante->CurrentValue;
        $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

        // diagnostico
        $this->diagnostico->setupEditAttributes();
        $this->diagnostico->EditValue = $this->diagnostico->CurrentValue;
        $this->diagnostico->PlaceHolder = RemoveHtml($this->diagnostico->caption());

        // reparacion
        $this->reparacion->setupEditAttributes();
        $this->reparacion->PlaceHolder = RemoveHtml($this->reparacion->caption());

        // cambio_aceite
        $this->cambio_aceite->setupEditAttributes();
        $this->cambio_aceite->EditValue = $this->cambio_aceite->options(true);
        $this->cambio_aceite->PlaceHolder = RemoveHtml($this->cambio_aceite->caption());

        // kilometraje
        $this->kilometraje->setupEditAttributes();
        $this->kilometraje->EditValue = $this->kilometraje->CurrentValue;
        $this->kilometraje->PlaceHolder = RemoveHtml($this->kilometraje->caption());
        if (strval($this->kilometraje->EditValue) != "" && is_numeric($this->kilometraje->EditValue)) {
            $this->kilometraje->EditValue = $this->kilometraje->EditValue;
        }

        // cantidad
        $this->cantidad->setupEditAttributes();
        $this->cantidad->EditValue = $this->cantidad->CurrentValue;
        $this->cantidad->PlaceHolder = RemoveHtml($this->cantidad->caption());
        if (strval($this->cantidad->EditValue) != "" && is_numeric($this->cantidad->EditValue)) {
            $this->cantidad->EditValue = $this->cantidad->EditValue;
        }

        // proveedor
        $this->proveedor->setupEditAttributes();
        $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());

        // monto
        $this->monto->setupEditAttributes();
        $this->monto->EditValue = $this->monto->CurrentValue;
        $this->monto->PlaceHolder = RemoveHtml($this->monto->caption());
        if (strval($this->monto->EditValue) != "" && is_numeric($this->monto->EditValue)) {
            $this->monto->EditValue = FormatNumber($this->monto->EditValue, null);
        }

        // username

        // username_diagnostica
        $this->username_diagnostica->setupEditAttributes();
        if (!$this->username_diagnostica->Raw) {
            $this->username_diagnostica->CurrentValue = HtmlDecode($this->username_diagnostica->CurrentValue);
        }
        $this->username_diagnostica->EditValue = $this->username_diagnostica->CurrentValue;
        $this->username_diagnostica->PlaceHolder = RemoveHtml($this->username_diagnostica->caption());

        // fecha_reparacion
        $this->fecha_reparacion->setupEditAttributes();
        $this->fecha_reparacion->EditValue = FormatDateTime($this->fecha_reparacion->CurrentValue, $this->fecha_reparacion->formatPattern());
        $this->fecha_reparacion->PlaceHolder = RemoveHtml($this->fecha_reparacion->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $result, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$result || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->Nflota_incidencia);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->flota);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->falla);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->diagnostico);
                    $doc->exportCaption($this->reparacion);
                    $doc->exportCaption($this->cambio_aceite);
                    $doc->exportCaption($this->kilometraje);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->monto);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->username_diagnostica);
                    $doc->exportCaption($this->fecha_reparacion);
                } else {
                    $doc->exportCaption($this->Nflota_incidencia);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->flota);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->falla);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->diagnostico);
                    $doc->exportCaption($this->reparacion);
                    $doc->exportCaption($this->cambio_aceite);
                    $doc->exportCaption($this->kilometraje);
                    $doc->exportCaption($this->cantidad);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->monto);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->username_diagnostica);
                    $doc->exportCaption($this->fecha_reparacion);
                }
                $doc->endExportRow();
            }
        }
        $recCnt = $startRec - 1;
        $stopRec = $stopRec > 0 ? $stopRec : PHP_INT_MAX;
        while (($row = $result->fetch()) && $recCnt < $stopRec) {
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = RowType::VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->Nflota_incidencia);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->flota);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->falla);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->diagnostico);
                        $doc->exportField($this->reparacion);
                        $doc->exportField($this->cambio_aceite);
                        $doc->exportField($this->kilometraje);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->monto);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->username_diagnostica);
                        $doc->exportField($this->fecha_reparacion);
                    } else {
                        $doc->exportField($this->Nflota_incidencia);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->flota);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->falla);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->diagnostico);
                        $doc->exportField($this->reparacion);
                        $doc->exportField($this->cambio_aceite);
                        $doc->exportField($this->kilometraje);
                        $doc->exportField($this->cantidad);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->monto);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->username_diagnostica);
                        $doc->exportField($this->fecha_reparacion);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Write audit trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_flota_incidencia');
    }

    // Write audit trail (add page)
    public function writeAuditTrailOnAdd(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnAdd) {
            return;
        }

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['Nflota_incidencia'];

        // Write audit trail
        $usr = CurrentUserIdentifier();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DataType::BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                    $newvalue = $Language->phrase("PasswordMask");
                } elseif ($this->Fields[$fldname]->DataType == DataType::MEMO) { // Memo Field
                    $newvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rs[$fldname] : "[MEMO]";
                } elseif ($this->Fields[$fldname]->DataType == DataType::XML) { // XML Field
                    $newvalue = "[XML]";
                } else {
                    $newvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "A", 'sco_flota_incidencia', $fldname, $key, "", $newvalue);
            }
        }
    }

    // Write audit trail (edit page)
    public function writeAuditTrailOnEdit(&$rsold, &$rsnew)
    {
        global $Language;
        if (!$this->AuditTrailOnEdit) {
            return;
        }

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['Nflota_incidencia'];

        // Write audit trail
        $usr = CurrentUserIdentifier();
        foreach (array_keys($rsnew) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && array_key_exists($fldname, $rsold) && $this->Fields[$fldname]->DataType != DataType::BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->DataType == DataType::DATE) { // DateTime field
                    $modified = (FormatDateTime($rsold[$fldname], 0) != FormatDateTime($rsnew[$fldname], 0));
                } else {
                    $modified = !CompareValue($rsold[$fldname], $rsnew[$fldname]);
                }
                if ($modified) {
                    if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                        $oldvalue = $Language->phrase("PasswordMask");
                        $newvalue = $Language->phrase("PasswordMask");
                    } elseif ($this->Fields[$fldname]->DataType == DataType::MEMO) { // Memo field
                        $oldvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rsold[$fldname] : "[MEMO]";
                        $newvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rsnew[$fldname] : "[MEMO]";
                    } elseif ($this->Fields[$fldname]->DataType == DataType::XML) { // XML field
                        $oldvalue = "[XML]";
                        $newvalue = "[XML]";
                    } else {
                        $oldvalue = $rsold[$fldname];
                        $newvalue = $rsnew[$fldname];
                    }
                    WriteAuditLog($usr, "U", 'sco_flota_incidencia', $fldname, $key, $oldvalue, $newvalue);
                }
            }
        }
    }

    // Write audit trail (delete page)
    public function writeAuditTrailOnDelete(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnDelete) {
            return;
        }

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['Nflota_incidencia'];

        // Write audit trail
        $usr = CurrentUserIdentifier();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DataType::BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                    $oldvalue = $Language->phrase("PasswordMask");
                } elseif ($this->Fields[$fldname]->DataType == DataType::MEMO) { // Memo field
                    $oldvalue = Config("AUDIT_TRAIL_TO_DATABASE") ? $rs[$fldname] : "[MEMO]";
                } elseif ($this->Fields[$fldname]->DataType == DataType::XML) { // XML field
                    $oldvalue = "[XML]";
                } else {
                    $oldvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "D", 'sco_flota_incidencia', $fldname, $key, $oldvalue);
            }
        }
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected($rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew) {
        // 1. Validación inicial de "flota"
        if($rsnew["flota"]=="") {
            $this->CancelMessage = "Debe indicar una placa.";
            return FALSE;
        }

        // MEJORA 1 y 2: Seguridad (casting a int) y Manejo de Errores (verificar $row)
        $flota_id = (int)$rsnew["flota"]; // Sanitización simple para evitar SQL Injection
        $sql = "SELECT placa, tipo, anho, color, activo
                FROM sco_flota
                WHERE Nflota = " . $flota_id . ";";
        $row = ExecuteRow($sql);
        if (!$row) {
            $this->CancelMessage = "Error: El ID de flota (" . $flota_id . ") no se encontró.";
            return FALSE;
        }
        $placa  = $row["placa"];
        $tipo   = $row["tipo"];
        $anho   = $row["anho"];
        $color  = $row["color"];
        $activo = $row["activo"];

        // 2. Validación de unidad inactiva
        if($activo == "N") {
            $this->CancelMessage = "La unidad $placa, $tipo, $anho, $color est&aacute; inactiva; no se le puede crear una nueva incidencia.";
            return FALSE;
        }

        // 3. Validaciones específicas por tipo
        if($rsnew["tipo"]=="FALLA" and $rsnew["falla"]=="") {
            $this->CancelMessage = "Debe indicar una falla.";
            return FALSE;
        }
        if($rsnew["tipo"]=="REPARACION" and $rsnew["reparacion"]=="") {
            $this->CancelMessage = "Debe indicar una reparaci&oacute;n.";
            return FALSE;
        }
        if($rsnew["tipo"]=="REPARACION" and $rsnew["fecha_reparacion"]=="") {
            $this->CancelMessage = "Si el estatus es reparaci&oacute;n debe indicar la fecha de la reparaci&oacute;n.";
            return FALSE;
        }

        // 4. Asignación de campos de auditoría/estado
        $rsnew["username"] = CurrentUserName();
        if(trim($rsnew["diagnostico"])!="") {
            $rsnew["tipo"] = "DIAGNOSTICO"; // Sobrescribe el tipo a DIAGNOSTICO si se proporciona
            $rsnew["username_diagnostica"] = CurrentUserName();
        }
        return TRUE;
    }
    // Row Inserted event
    public function rowInserted($rsold, $rsnew) {
        // Solo si se marcó que se hizo un cambio de aceite
        if ($rsnew["cambio_aceite"] == "S") {
            // 1. Obtener el incremento de kilometraje para el próximo cambio de aceite
            $sql_parametro = "SELECT valor1 FROM sco_parametro WHERE codigo = '025';";
            $incremento_km = intval(ExecuteScalar($sql_parametro)); 
            if ($incremento_km > 0) {
                // 2. Calcular el kilometraje del próximo cambio
                $km_actual = intval($rsnew["kilometraje"]);
                $km_proximo_cambio_aceite = $km_actual + $incremento_km;

                // MEJORA DE SEGURIDAD: Sanitizar las variables antes de usarlas en el UPDATE
                $flota_id_seguro = (int)$rsnew["flota"];

                // 3. Actualizar la flota con el nuevo kilometraje de mantenimiento
                // Se eliminan las comillas simples de los valores numéricos
                $sql_update = "UPDATE sco_flota SET km_oil_next = " . $km_proximo_cambio_aceite . " WHERE Nflota = " . $flota_id_seguro . ";";
                Execute($sql_update);
            }
            // Si $incremento_km es 0 o negativo, no se hace la actualización.
        }
    }
    // Row Updating event
    public function rowUpdating($rsold, &$rsnew) {
        // 1. Validación inicial de "flota"
        if ($rsnew["flota"] == "") {
            $this->CancelMessage = "Debe indicar una placa.";
            return FALSE;
        }

        // CORRECCIÓN 1: Sanitización y Manejo de Errores al consultar la flota
        $flota_id = (int)$rsnew["flota"]; // Forzar a entero para sanitizar (asumiendo Nflota es numérico)
        $sql = "SELECT placa, tipo, anho, color, activo
                FROM sco_flota
                WHERE Nflota = " . $flota_id . ";";
        $row = ExecuteRow($sql);

        // CORRECCIÓN 2: Verificar si la flota existe antes de usar $row
        if (!$row) {
            $this->CancelMessage = "Error: El ID de flota (" . $flota_id . ") no se encontró en la base de datos.";
            return FALSE;
        }
        $placa  = $row["placa"];
        $tipo   = $row["tipo"];
        $anho   = $row["anho"];
        $color  = $row["color"];
        $activo = $row["activo"];

        // 3. Validación de unidad inactiva
        if ($activo == "N") {
            $this->CancelMessage = "La unidad $placa, $tipo, $anho, $color est&aacute; inactiva; no se puede actualizar esta incidencia.";
            return FALSE;
        }

        // 4. Validaciones específicas (FALLA requiere 'falla')
        if ($rsnew["tipo"] == "FALLA" && $rsnew["falla"] == "") {
            $this->CancelMessage = "Debe indicar una falla.";
            return FALSE;
        }

        // 5. Validaciones específicas (REPARACION requiere 'reparacion')
        if ($rsnew["tipo"] == "REPARACION" && $rsnew["reparacion"] == "") {
            $this->CancelMessage = "Debe indicar una reparaci&oacute;n.";
            return FALSE;
        }

        // 6. Lógica de estado: Si el campo 'diagnostico' ha cambiado, actualizar el estatus
        if ($rsnew["diagnostico"] != $rsold["diagnostico"]) {
            $rsnew["tipo"] = "DIAGNOSTICO";
            $rsnew["username_diagnostica"] = CurrentUserName();
        }

        // 7. Validaciones específicas (REPARACION requiere 'fecha_reparacion')
        if ($rsnew["tipo"] == "REPARACION" && $rsnew["fecha_reparacion"] == "") {
            $this->CancelMessage = "Si el estatus es reparaci&oacute;n debe indicar la fecha de la reparaci&oacute;n.";
            return FALSE;
        }
        return TRUE;
    }
    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
        // Solo si se marcó que se hizo un cambio de aceite
        if ($rsnew["cambio_aceite"] == "S") {
            // 1. Obtener el incremento de kilometraje para el próximo cambio de aceite
            $sql_parametro = "SELECT valor1 FROM sco_parametro WHERE codigo = '025';";

            // Se usa intval para asegurar que sea un número (si no existe, será 0)
            $incremento_km = intval(ExecuteScalar($sql_parametro)); 

            // Solo procedemos si el incremento es un número positivo válido
            if ($incremento_km > 0) {
                // 2. Calcular el kilometraje del próximo cambio
                $km_actual = intval($rsnew["kilometraje"]);
                $km_proximo_cambio_aceite = $km_actual + $incremento_km;

                // 3. MEJORA DE SEGURIDAD: Sanitizar las variables antes de usarlas en el UPDATE
                $flota_id_seguro = (int)$rsnew["flota"]; // Flota ID forzado a entero

                // 4. Actualizar la flota
                // Se eliminan las comillas simples de los valores numéricos para una correcta sintaxis SQL
                $sql_update = "UPDATE sco_flota 
                               SET km_oil_next = " . $km_proximo_cambio_aceite . " 
                               WHERE Nflota = " . $flota_id_seguro . ";";
                Execute($sql_update);
            }
        }
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted($rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, $args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering() {
        // Enter your code here 
        if ($this->PageID == "list" || $this->PageID == "view") { // List/View page only
            $color = ""; // Inicialización (CORREGIDO)
            switch($this->tipo->CurrentValue) {
            case "FALLA":
                $color = "RED";
                break;
            case "DIAGNOSTICO":
                $color = "YELLOW";
                break;
            case "REPARACION":
                $color = "GREEN";
                break;
            }

            // Aplicar el estilo SÓLO si se definió un color
            if ($color !== "") {
                $style = "background-color: " . $color;    
                $this->tipo->CellAttrs["style"] = $style;
            }
        }
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
