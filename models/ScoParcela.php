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
 * Table class for sco_parcela
 */
class ScoParcela extends DbTable
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
    public $Nparcela;
    public $nacionalidad;
    public $cedula;
    public $titular;
    public $contrato;
    public $seccion;
    public $modulo;
    public $sub_seccion;
    public $parcela;
    public $boveda;
    public $apellido1;
    public $apellido2;
    public $nombre1;
    public $nombre2;
    public $fecha_inhumacion;
    public $telefono1;
    public $telefono2;
    public $telefono3;
    public $direc1;
    public $direc2;
    public $_email;
    public $nac_ci_asociado;
    public $ci_asociado;
    public $nombre_asociado;
    public $nac_difunto;
    public $ci_difunto;
    public $edad;
    public $edo_civil;
    public $fecha_nacimiento;
    public $lugar;
    public $fecha_defuncion;
    public $causa;
    public $certificado;
    public $funeraria;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_parcela";
        $this->TableName = 'sco_parcela';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_parcela";
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

        // Nparcela
        $this->Nparcela = new DbField(
            $this, // Table
            'x_Nparcela', // Variable name
            'Nparcela', // Name
            '`Nparcela`', // Expression
            '`Nparcela`', // Basic search expression
            21, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nparcela`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nparcela->InputTextType = "text";
        $this->Nparcela->Raw = true;
        $this->Nparcela->IsPrimaryKey = true; // Primary key field
        $this->Nparcela->Nullable = false; // NOT NULL field
        $this->Nparcela->Required = true; // Required field
        $this->Nparcela->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nparcela->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nparcela'] = &$this->Nparcela;

        // nacionalidad
        $this->nacionalidad = new DbField(
            $this, // Table
            'x_nacionalidad', // Variable name
            'nacionalidad', // Name
            '`nacionalidad`', // Expression
            '`nacionalidad`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nacionalidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nacionalidad->InputTextType = "text";
        $this->nacionalidad->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nacionalidad'] = &$this->nacionalidad;

        // cedula
        $this->cedula = new DbField(
            $this, // Table
            'x_cedula', // Variable name
            'cedula', // Name
            '`cedula`', // Expression
            '`cedula`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula->InputTextType = "text";
        $this->cedula->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula'] = &$this->cedula;

        // titular
        $this->titular = new DbField(
            $this, // Table
            'x_titular', // Variable name
            'titular', // Name
            '`titular`', // Expression
            '`titular`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`titular`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->titular->InputTextType = "text";
        $this->titular->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['titular'] = &$this->titular;

        // contrato
        $this->contrato = new DbField(
            $this, // Table
            'x_contrato', // Variable name
            'contrato', // Name
            '`contrato`', // Expression
            '`contrato`', // Basic search expression
            200, // Type
            8, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contrato`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contrato->InputTextType = "text";
        $this->contrato->IsForeignKey = true; // Foreign key field
        $this->contrato->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contrato'] = &$this->contrato;

        // seccion
        $this->seccion = new DbField(
            $this, // Table
            'x_seccion', // Variable name
            'seccion', // Name
            '`seccion`', // Expression
            '`seccion`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`seccion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->seccion->InputTextType = "text";
        $this->seccion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['seccion'] = &$this->seccion;

        // modulo
        $this->modulo = new DbField(
            $this, // Table
            'x_modulo', // Variable name
            'modulo', // Name
            '`modulo`', // Expression
            '`modulo`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`modulo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->modulo->InputTextType = "text";
        $this->modulo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['modulo'] = &$this->modulo;

        // sub_seccion
        $this->sub_seccion = new DbField(
            $this, // Table
            'x_sub_seccion', // Variable name
            'sub_seccion', // Name
            '`sub_seccion`', // Expression
            '`sub_seccion`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sub_seccion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->sub_seccion->InputTextType = "text";
        $this->sub_seccion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['sub_seccion'] = &$this->sub_seccion;

        // parcela
        $this->parcela = new DbField(
            $this, // Table
            'x_parcela', // Variable name
            'parcela', // Name
            '`parcela`', // Expression
            '`parcela`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`parcela`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->parcela->InputTextType = "text";
        $this->parcela->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['parcela'] = &$this->parcela;

        // boveda
        $this->boveda = new DbField(
            $this, // Table
            'x_boveda', // Variable name
            'boveda', // Name
            '`boveda`', // Expression
            '`boveda`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`boveda`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->boveda->InputTextType = "text";
        $this->boveda->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['boveda'] = &$this->boveda;

        // apellido1
        $this->apellido1 = new DbField(
            $this, // Table
            'x_apellido1', // Variable name
            'apellido1', // Name
            '`apellido1`', // Expression
            '`apellido1`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`apellido1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->apellido1->InputTextType = "text";
        $this->apellido1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['apellido1'] = &$this->apellido1;

        // apellido2
        $this->apellido2 = new DbField(
            $this, // Table
            'x_apellido2', // Variable name
            'apellido2', // Name
            '`apellido2`', // Expression
            '`apellido2`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`apellido2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->apellido2->InputTextType = "text";
        $this->apellido2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['apellido2'] = &$this->apellido2;

        // nombre1
        $this->nombre1 = new DbField(
            $this, // Table
            'x_nombre1', // Variable name
            'nombre1', // Name
            '`nombre1`', // Expression
            '`nombre1`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre1->InputTextType = "text";
        $this->nombre1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre1'] = &$this->nombre1;

        // nombre2
        $this->nombre2 = new DbField(
            $this, // Table
            'x_nombre2', // Variable name
            'nombre2', // Name
            '`nombre2`', // Expression
            '`nombre2`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre2->InputTextType = "text";
        $this->nombre2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre2'] = &$this->nombre2;

        // fecha_inhumacion
        $this->fecha_inhumacion = new DbField(
            $this, // Table
            'x_fecha_inhumacion', // Variable name
            'fecha_inhumacion', // Name
            '`fecha_inhumacion`', // Expression
            '`fecha_inhumacion`', // Basic search expression
            200, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_inhumacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_inhumacion->InputTextType = "text";
        $this->fecha_inhumacion->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_inhumacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_inhumacion'] = &$this->fecha_inhumacion;

        // telefono1
        $this->telefono1 = new DbField(
            $this, // Table
            'x_telefono1', // Variable name
            'telefono1', // Name
            '`telefono1`', // Expression
            '`telefono1`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono1->InputTextType = "text";
        $this->telefono1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono1'] = &$this->telefono1;

        // telefono2
        $this->telefono2 = new DbField(
            $this, // Table
            'x_telefono2', // Variable name
            'telefono2', // Name
            '`telefono2`', // Expression
            '`telefono2`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono2->InputTextType = "text";
        $this->telefono2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono2'] = &$this->telefono2;

        // telefono3
        $this->telefono3 = new DbField(
            $this, // Table
            'x_telefono3', // Variable name
            'telefono3', // Name
            '`telefono3`', // Expression
            '`telefono3`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono3`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono3->InputTextType = "text";
        $this->telefono3->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono3'] = &$this->telefono3;

        // direc1
        $this->direc1 = new DbField(
            $this, // Table
            'x_direc1', // Variable name
            'direc1', // Name
            '`direc1`', // Expression
            '`direc1`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direc1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->direc1->InputTextType = "text";
        $this->direc1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direc1'] = &$this->direc1;

        // direc2
        $this->direc2 = new DbField(
            $this, // Table
            'x_direc2', // Variable name
            'direc2', // Name
            '`direc2`', // Expression
            '`direc2`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direc2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->direc2->InputTextType = "text";
        $this->direc2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direc2'] = &$this->direc2;

        // email
        $this->_email = new DbField(
            $this, // Table
            'x__email', // Variable name
            'email', // Name
            '`email`', // Expression
            '`email`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_email->InputTextType = "text";
        $this->_email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['email'] = &$this->_email;

        // nac_ci_asociado
        $this->nac_ci_asociado = new DbField(
            $this, // Table
            'x_nac_ci_asociado', // Variable name
            'nac_ci_asociado', // Name
            '`nac_ci_asociado`', // Expression
            '`nac_ci_asociado`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nac_ci_asociado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nac_ci_asociado->InputTextType = "text";
        $this->nac_ci_asociado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nac_ci_asociado'] = &$this->nac_ci_asociado;

        // ci_asociado
        $this->ci_asociado = new DbField(
            $this, // Table
            'x_ci_asociado', // Variable name
            'ci_asociado', // Name
            '`ci_asociado`', // Expression
            '`ci_asociado`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ci_asociado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ci_asociado->InputTextType = "text";
        $this->ci_asociado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_asociado'] = &$this->ci_asociado;

        // nombre_asociado
        $this->nombre_asociado = new DbField(
            $this, // Table
            'x_nombre_asociado', // Variable name
            'nombre_asociado', // Name
            '`nombre_asociado`', // Expression
            '`nombre_asociado`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_asociado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_asociado->InputTextType = "text";
        $this->nombre_asociado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_asociado'] = &$this->nombre_asociado;

        // nac_difunto
        $this->nac_difunto = new DbField(
            $this, // Table
            'x_nac_difunto', // Variable name
            'nac_difunto', // Name
            '`nac_difunto`', // Expression
            '`nac_difunto`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nac_difunto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nac_difunto->InputTextType = "text";
        $this->nac_difunto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nac_difunto'] = &$this->nac_difunto;

        // ci_difunto
        $this->ci_difunto = new DbField(
            $this, // Table
            'x_ci_difunto', // Variable name
            'ci_difunto', // Name
            '`ci_difunto`', // Expression
            '`ci_difunto`', // Basic search expression
            129, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ci_difunto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ci_difunto->InputTextType = "text";
        $this->ci_difunto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_difunto'] = &$this->ci_difunto;

        // edad
        $this->edad = new DbField(
            $this, // Table
            'x_edad', // Variable name
            'edad', // Name
            '`edad`', // Expression
            '`edad`', // Basic search expression
            16, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`edad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->edad->InputTextType = "text";
        $this->edad->Raw = true;
        $this->edad->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->edad->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['edad'] = &$this->edad;

        // edo_civil
        $this->edo_civil = new DbField(
            $this, // Table
            'x_edo_civil', // Variable name
            'edo_civil', // Name
            '`edo_civil`', // Expression
            '`edo_civil`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`edo_civil`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->edo_civil->InputTextType = "text";
        $this->edo_civil->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['edo_civil'] = &$this->edo_civil;

        // fecha_nacimiento
        $this->fecha_nacimiento = new DbField(
            $this, // Table
            'x_fecha_nacimiento', // Variable name
            'fecha_nacimiento', // Name
            '`fecha_nacimiento`', // Expression
            '`fecha_nacimiento`', // Basic search expression
            200, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_nacimiento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_nacimiento->InputTextType = "text";
        $this->fecha_nacimiento->Required = true; // Required field
        $this->fecha_nacimiento->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_nacimiento'] = &$this->fecha_nacimiento;

        // lugar
        $this->lugar = new DbField(
            $this, // Table
            'x_lugar', // Variable name
            'lugar', // Name
            '`lugar`', // Expression
            '`lugar`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`lugar`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->lugar->InputTextType = "text";
        $this->lugar->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['lugar'] = &$this->lugar;

        // fecha_defuncion
        $this->fecha_defuncion = new DbField(
            $this, // Table
            'x_fecha_defuncion', // Variable name
            'fecha_defuncion', // Name
            '`fecha_defuncion`', // Expression
            '`fecha_defuncion`', // Basic search expression
            200, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_defuncion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_defuncion->InputTextType = "text";
        $this->fecha_defuncion->Required = true; // Required field
        $this->fecha_defuncion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_defuncion'] = &$this->fecha_defuncion;

        // causa
        $this->causa = new DbField(
            $this, // Table
            'x_causa', // Variable name
            'causa', // Name
            '`causa`', // Expression
            '`causa`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`causa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->causa->InputTextType = "text";
        $this->causa->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['causa'] = &$this->causa;

        // certificado
        $this->certificado = new DbField(
            $this, // Table
            'x_certificado', // Variable name
            'certificado', // Name
            '`certificado`', // Expression
            '`certificado`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`certificado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->certificado->InputTextType = "text";
        $this->certificado->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['certificado'] = &$this->certificado;

        // funeraria
        $this->funeraria = new DbField(
            $this, // Table
            'x_funeraria', // Variable name
            'funeraria', // Name
            '`funeraria`', // Expression
            '`funeraria`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`funeraria`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->funeraria->InputTextType = "text";
        $this->funeraria->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['funeraria'] = &$this->funeraria;

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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "sco_expediente") {
            $masterTable = Container("sco_expediente");
            if ($this->contrato->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->contrato_parcela, $this->contrato->getSessionValue(), $masterTable->contrato_parcela->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "sco_expediente") {
            $masterTable = Container("sco_expediente");
            if ($this->contrato->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->contrato, $this->contrato->getSessionValue(), $masterTable->contrato_parcela->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "sco_expediente":
                $key = $keys["contrato"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->contrato_parcela->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->contrato_parcela, $keys["contrato"], $this->contrato->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "sco_expediente":
                return GetKeyFilter($this->contrato, $masterTable->contrato_parcela->DbValue, $masterTable->contrato_parcela->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_parcela";
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
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->executeStatement();
            $success = $success > 0 ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nparcela';
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
            if (array_key_exists('Nparcela', $rs)) {
                AddFilter($where, QuotedName('Nparcela', $this->Dbid) . '=' . QuotedValue($rs['Nparcela'], $this->Nparcela->DataType, $this->Dbid));
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
        $this->Nparcela->DbValue = $row['Nparcela'];
        $this->nacionalidad->DbValue = $row['nacionalidad'];
        $this->cedula->DbValue = $row['cedula'];
        $this->titular->DbValue = $row['titular'];
        $this->contrato->DbValue = $row['contrato'];
        $this->seccion->DbValue = $row['seccion'];
        $this->modulo->DbValue = $row['modulo'];
        $this->sub_seccion->DbValue = $row['sub_seccion'];
        $this->parcela->DbValue = $row['parcela'];
        $this->boveda->DbValue = $row['boveda'];
        $this->apellido1->DbValue = $row['apellido1'];
        $this->apellido2->DbValue = $row['apellido2'];
        $this->nombre1->DbValue = $row['nombre1'];
        $this->nombre2->DbValue = $row['nombre2'];
        $this->fecha_inhumacion->DbValue = $row['fecha_inhumacion'];
        $this->telefono1->DbValue = $row['telefono1'];
        $this->telefono2->DbValue = $row['telefono2'];
        $this->telefono3->DbValue = $row['telefono3'];
        $this->direc1->DbValue = $row['direc1'];
        $this->direc2->DbValue = $row['direc2'];
        $this->_email->DbValue = $row['email'];
        $this->nac_ci_asociado->DbValue = $row['nac_ci_asociado'];
        $this->ci_asociado->DbValue = $row['ci_asociado'];
        $this->nombre_asociado->DbValue = $row['nombre_asociado'];
        $this->nac_difunto->DbValue = $row['nac_difunto'];
        $this->ci_difunto->DbValue = $row['ci_difunto'];
        $this->edad->DbValue = $row['edad'];
        $this->edo_civil->DbValue = $row['edo_civil'];
        $this->fecha_nacimiento->DbValue = $row['fecha_nacimiento'];
        $this->lugar->DbValue = $row['lugar'];
        $this->fecha_defuncion->DbValue = $row['fecha_defuncion'];
        $this->causa->DbValue = $row['causa'];
        $this->certificado->DbValue = $row['certificado'];
        $this->funeraria->DbValue = $row['funeraria'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nparcela` = @Nparcela@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nparcela->CurrentValue : $this->Nparcela->OldValue;
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
                $this->Nparcela->CurrentValue = $keys[0];
            } else {
                $this->Nparcela->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nparcela', $row) ? $row['Nparcela'] : null;
        } else {
            $val = !EmptyValue($this->Nparcela->OldValue) && !$current ? $this->Nparcela->OldValue : $this->Nparcela->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nparcela@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoParcelaList");
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
            "ScoParcelaView" => $Language->phrase("View"),
            "ScoParcelaEdit" => $Language->phrase("Edit"),
            "ScoParcelaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoParcelaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoParcelaView",
            Config("API_ADD_ACTION") => "ScoParcelaAdd",
            Config("API_EDIT_ACTION") => "ScoParcelaEdit",
            Config("API_DELETE_ACTION") => "ScoParcelaDelete",
            Config("API_LIST_ACTION") => "ScoParcelaList",
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
        return "ScoParcelaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoParcelaView", $parm);
        } else {
            $url = $this->keyUrl("ScoParcelaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoParcelaAdd?" . $parm;
        } else {
            $url = "ScoParcelaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoParcelaEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoParcelaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoParcelaAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoParcelaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoParcelaDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "sco_expediente" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_contrato_parcela", $this->contrato->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Nparcela\":" . VarToJson($this->Nparcela->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nparcela->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nparcela->CurrentValue);
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
            if (($keyValue = Param("Nparcela") ?? Route("Nparcela")) !== null) {
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
                $this->Nparcela->CurrentValue = $key;
            } else {
                $this->Nparcela->OldValue = $key;
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
        $this->Nparcela->setDbValue($row['Nparcela']);
        $this->nacionalidad->setDbValue($row['nacionalidad']);
        $this->cedula->setDbValue($row['cedula']);
        $this->titular->setDbValue($row['titular']);
        $this->contrato->setDbValue($row['contrato']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->apellido1->setDbValue($row['apellido1']);
        $this->apellido2->setDbValue($row['apellido2']);
        $this->nombre1->setDbValue($row['nombre1']);
        $this->nombre2->setDbValue($row['nombre2']);
        $this->fecha_inhumacion->setDbValue($row['fecha_inhumacion']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->telefono3->setDbValue($row['telefono3']);
        $this->direc1->setDbValue($row['direc1']);
        $this->direc2->setDbValue($row['direc2']);
        $this->_email->setDbValue($row['email']);
        $this->nac_ci_asociado->setDbValue($row['nac_ci_asociado']);
        $this->ci_asociado->setDbValue($row['ci_asociado']);
        $this->nombre_asociado->setDbValue($row['nombre_asociado']);
        $this->nac_difunto->setDbValue($row['nac_difunto']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->edad->setDbValue($row['edad']);
        $this->edo_civil->setDbValue($row['edo_civil']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->lugar->setDbValue($row['lugar']);
        $this->fecha_defuncion->setDbValue($row['fecha_defuncion']);
        $this->causa->setDbValue($row['causa']);
        $this->certificado->setDbValue($row['certificado']);
        $this->funeraria->setDbValue($row['funeraria']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoParcelaList";
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

        // Nparcela

        // nacionalidad

        // cedula

        // titular

        // contrato

        // seccion

        // modulo

        // sub_seccion

        // parcela

        // boveda

        // apellido1

        // apellido2

        // nombre1

        // nombre2

        // fecha_inhumacion

        // telefono1

        // telefono2

        // telefono3

        // direc1

        // direc2

        // email

        // nac_ci_asociado

        // ci_asociado

        // nombre_asociado

        // nac_difunto

        // ci_difunto

        // edad

        // edo_civil

        // fecha_nacimiento

        // lugar

        // fecha_defuncion

        // causa

        // certificado

        // funeraria

        // Nparcela
        $this->Nparcela->ViewValue = $this->Nparcela->CurrentValue;

        // nacionalidad
        $this->nacionalidad->ViewValue = $this->nacionalidad->CurrentValue;

        // cedula
        $this->cedula->ViewValue = $this->cedula->CurrentValue;

        // titular
        $this->titular->ViewValue = $this->titular->CurrentValue;

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

        // apellido1
        $this->apellido1->ViewValue = $this->apellido1->CurrentValue;

        // apellido2
        $this->apellido2->ViewValue = $this->apellido2->CurrentValue;

        // nombre1
        $this->nombre1->ViewValue = $this->nombre1->CurrentValue;

        // nombre2
        $this->nombre2->ViewValue = $this->nombre2->CurrentValue;

        // fecha_inhumacion
        $this->fecha_inhumacion->ViewValue = $this->fecha_inhumacion->CurrentValue;

        // telefono1
        $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

        // telefono2
        $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

        // telefono3
        $this->telefono3->ViewValue = $this->telefono3->CurrentValue;

        // direc1
        $this->direc1->ViewValue = $this->direc1->CurrentValue;

        // direc2
        $this->direc2->ViewValue = $this->direc2->CurrentValue;

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // nac_ci_asociado
        $this->nac_ci_asociado->ViewValue = $this->nac_ci_asociado->CurrentValue;

        // ci_asociado
        $this->ci_asociado->ViewValue = $this->ci_asociado->CurrentValue;

        // nombre_asociado
        $this->nombre_asociado->ViewValue = $this->nombre_asociado->CurrentValue;

        // nac_difunto
        $this->nac_difunto->ViewValue = $this->nac_difunto->CurrentValue;

        // ci_difunto
        $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

        // edad
        $this->edad->ViewValue = $this->edad->CurrentValue;

        // edo_civil
        $this->edo_civil->ViewValue = $this->edo_civil->CurrentValue;

        // fecha_nacimiento
        $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;

        // lugar
        $this->lugar->ViewValue = $this->lugar->CurrentValue;

        // fecha_defuncion
        $this->fecha_defuncion->ViewValue = $this->fecha_defuncion->CurrentValue;

        // causa
        $this->causa->ViewValue = $this->causa->CurrentValue;

        // certificado
        $this->certificado->ViewValue = $this->certificado->CurrentValue;

        // funeraria
        $this->funeraria->ViewValue = $this->funeraria->CurrentValue;

        // Nparcela
        $this->Nparcela->HrefValue = "";
        $this->Nparcela->TooltipValue = "";

        // nacionalidad
        $this->nacionalidad->HrefValue = "";
        $this->nacionalidad->TooltipValue = "";

        // cedula
        $this->cedula->HrefValue = "";
        $this->cedula->TooltipValue = "";

        // titular
        $this->titular->HrefValue = "";
        $this->titular->TooltipValue = "";

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

        // boveda
        $this->boveda->HrefValue = "";
        $this->boveda->TooltipValue = "";

        // apellido1
        $this->apellido1->HrefValue = "";
        $this->apellido1->TooltipValue = "";

        // apellido2
        $this->apellido2->HrefValue = "";
        $this->apellido2->TooltipValue = "";

        // nombre1
        $this->nombre1->HrefValue = "";
        $this->nombre1->TooltipValue = "";

        // nombre2
        $this->nombre2->HrefValue = "";
        $this->nombre2->TooltipValue = "";

        // fecha_inhumacion
        $this->fecha_inhumacion->HrefValue = "";
        $this->fecha_inhumacion->TooltipValue = "";

        // telefono1
        $this->telefono1->HrefValue = "";
        $this->telefono1->TooltipValue = "";

        // telefono2
        $this->telefono2->HrefValue = "";
        $this->telefono2->TooltipValue = "";

        // telefono3
        $this->telefono3->HrefValue = "";
        $this->telefono3->TooltipValue = "";

        // direc1
        $this->direc1->HrefValue = "";
        $this->direc1->TooltipValue = "";

        // direc2
        $this->direc2->HrefValue = "";
        $this->direc2->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // nac_ci_asociado
        $this->nac_ci_asociado->HrefValue = "";
        $this->nac_ci_asociado->TooltipValue = "";

        // ci_asociado
        $this->ci_asociado->HrefValue = "";
        $this->ci_asociado->TooltipValue = "";

        // nombre_asociado
        $this->nombre_asociado->HrefValue = "";
        $this->nombre_asociado->TooltipValue = "";

        // nac_difunto
        $this->nac_difunto->HrefValue = "";
        $this->nac_difunto->TooltipValue = "";

        // ci_difunto
        $this->ci_difunto->HrefValue = "";
        $this->ci_difunto->TooltipValue = "";

        // edad
        $this->edad->HrefValue = "";
        $this->edad->TooltipValue = "";

        // edo_civil
        $this->edo_civil->HrefValue = "";
        $this->edo_civil->TooltipValue = "";

        // fecha_nacimiento
        $this->fecha_nacimiento->HrefValue = "";
        $this->fecha_nacimiento->TooltipValue = "";

        // lugar
        $this->lugar->HrefValue = "";
        $this->lugar->TooltipValue = "";

        // fecha_defuncion
        $this->fecha_defuncion->HrefValue = "";
        $this->fecha_defuncion->TooltipValue = "";

        // causa
        $this->causa->HrefValue = "";
        $this->causa->TooltipValue = "";

        // certificado
        $this->certificado->HrefValue = "";
        $this->certificado->TooltipValue = "";

        // funeraria
        $this->funeraria->HrefValue = "";
        $this->funeraria->TooltipValue = "";

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

        // Nparcela
        $this->Nparcela->setupEditAttributes();
        $this->Nparcela->EditValue = $this->Nparcela->CurrentValue;
        $this->Nparcela->PlaceHolder = RemoveHtml($this->Nparcela->caption());

        // nacionalidad
        $this->nacionalidad->setupEditAttributes();
        if (!$this->nacionalidad->Raw) {
            $this->nacionalidad->CurrentValue = HtmlDecode($this->nacionalidad->CurrentValue);
        }
        $this->nacionalidad->EditValue = $this->nacionalidad->CurrentValue;
        $this->nacionalidad->PlaceHolder = RemoveHtml($this->nacionalidad->caption());

        // cedula
        $this->cedula->setupEditAttributes();
        if (!$this->cedula->Raw) {
            $this->cedula->CurrentValue = HtmlDecode($this->cedula->CurrentValue);
        }
        $this->cedula->EditValue = $this->cedula->CurrentValue;
        $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

        // titular
        $this->titular->setupEditAttributes();
        if (!$this->titular->Raw) {
            $this->titular->CurrentValue = HtmlDecode($this->titular->CurrentValue);
        }
        $this->titular->EditValue = $this->titular->CurrentValue;
        $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

        // contrato
        $this->contrato->setupEditAttributes();
        if ($this->contrato->getSessionValue() != "") {
            $this->contrato->CurrentValue = GetForeignKeyValue($this->contrato->getSessionValue());
            $this->contrato->ViewValue = $this->contrato->CurrentValue;
        } else {
            if (!$this->contrato->Raw) {
                $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
            }
            $this->contrato->EditValue = $this->contrato->CurrentValue;
            $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());
        }

        // seccion
        $this->seccion->setupEditAttributes();
        if (!$this->seccion->Raw) {
            $this->seccion->CurrentValue = HtmlDecode($this->seccion->CurrentValue);
        }
        $this->seccion->EditValue = $this->seccion->CurrentValue;
        $this->seccion->PlaceHolder = RemoveHtml($this->seccion->caption());

        // modulo
        $this->modulo->setupEditAttributes();
        if (!$this->modulo->Raw) {
            $this->modulo->CurrentValue = HtmlDecode($this->modulo->CurrentValue);
        }
        $this->modulo->EditValue = $this->modulo->CurrentValue;
        $this->modulo->PlaceHolder = RemoveHtml($this->modulo->caption());

        // sub_seccion
        $this->sub_seccion->setupEditAttributes();
        if (!$this->sub_seccion->Raw) {
            $this->sub_seccion->CurrentValue = HtmlDecode($this->sub_seccion->CurrentValue);
        }
        $this->sub_seccion->EditValue = $this->sub_seccion->CurrentValue;
        $this->sub_seccion->PlaceHolder = RemoveHtml($this->sub_seccion->caption());

        // parcela
        $this->parcela->setupEditAttributes();
        if (!$this->parcela->Raw) {
            $this->parcela->CurrentValue = HtmlDecode($this->parcela->CurrentValue);
        }
        $this->parcela->EditValue = $this->parcela->CurrentValue;
        $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

        // boveda
        $this->boveda->setupEditAttributes();
        if (!$this->boveda->Raw) {
            $this->boveda->CurrentValue = HtmlDecode($this->boveda->CurrentValue);
        }
        $this->boveda->EditValue = $this->boveda->CurrentValue;
        $this->boveda->PlaceHolder = RemoveHtml($this->boveda->caption());

        // apellido1
        $this->apellido1->setupEditAttributes();
        if (!$this->apellido1->Raw) {
            $this->apellido1->CurrentValue = HtmlDecode($this->apellido1->CurrentValue);
        }
        $this->apellido1->EditValue = $this->apellido1->CurrentValue;
        $this->apellido1->PlaceHolder = RemoveHtml($this->apellido1->caption());

        // apellido2
        $this->apellido2->setupEditAttributes();
        if (!$this->apellido2->Raw) {
            $this->apellido2->CurrentValue = HtmlDecode($this->apellido2->CurrentValue);
        }
        $this->apellido2->EditValue = $this->apellido2->CurrentValue;
        $this->apellido2->PlaceHolder = RemoveHtml($this->apellido2->caption());

        // nombre1
        $this->nombre1->setupEditAttributes();
        if (!$this->nombre1->Raw) {
            $this->nombre1->CurrentValue = HtmlDecode($this->nombre1->CurrentValue);
        }
        $this->nombre1->EditValue = $this->nombre1->CurrentValue;
        $this->nombre1->PlaceHolder = RemoveHtml($this->nombre1->caption());

        // nombre2
        $this->nombre2->setupEditAttributes();
        if (!$this->nombre2->Raw) {
            $this->nombre2->CurrentValue = HtmlDecode($this->nombre2->CurrentValue);
        }
        $this->nombre2->EditValue = $this->nombre2->CurrentValue;
        $this->nombre2->PlaceHolder = RemoveHtml($this->nombre2->caption());

        // fecha_inhumacion
        $this->fecha_inhumacion->setupEditAttributes();
        if (!$this->fecha_inhumacion->Raw) {
            $this->fecha_inhumacion->CurrentValue = HtmlDecode($this->fecha_inhumacion->CurrentValue);
        }
        $this->fecha_inhumacion->EditValue = $this->fecha_inhumacion->CurrentValue;
        $this->fecha_inhumacion->PlaceHolder = RemoveHtml($this->fecha_inhumacion->caption());

        // telefono1
        $this->telefono1->setupEditAttributes();
        if (!$this->telefono1->Raw) {
            $this->telefono1->CurrentValue = HtmlDecode($this->telefono1->CurrentValue);
        }
        $this->telefono1->EditValue = $this->telefono1->CurrentValue;
        $this->telefono1->PlaceHolder = RemoveHtml($this->telefono1->caption());

        // telefono2
        $this->telefono2->setupEditAttributes();
        if (!$this->telefono2->Raw) {
            $this->telefono2->CurrentValue = HtmlDecode($this->telefono2->CurrentValue);
        }
        $this->telefono2->EditValue = $this->telefono2->CurrentValue;
        $this->telefono2->PlaceHolder = RemoveHtml($this->telefono2->caption());

        // telefono3
        $this->telefono3->setupEditAttributes();
        if (!$this->telefono3->Raw) {
            $this->telefono3->CurrentValue = HtmlDecode($this->telefono3->CurrentValue);
        }
        $this->telefono3->EditValue = $this->telefono3->CurrentValue;
        $this->telefono3->PlaceHolder = RemoveHtml($this->telefono3->caption());

        // direc1
        $this->direc1->setupEditAttributes();
        if (!$this->direc1->Raw) {
            $this->direc1->CurrentValue = HtmlDecode($this->direc1->CurrentValue);
        }
        $this->direc1->EditValue = $this->direc1->CurrentValue;
        $this->direc1->PlaceHolder = RemoveHtml($this->direc1->caption());

        // direc2
        $this->direc2->setupEditAttributes();
        if (!$this->direc2->Raw) {
            $this->direc2->CurrentValue = HtmlDecode($this->direc2->CurrentValue);
        }
        $this->direc2->EditValue = $this->direc2->CurrentValue;
        $this->direc2->PlaceHolder = RemoveHtml($this->direc2->caption());

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // nac_ci_asociado
        $this->nac_ci_asociado->setupEditAttributes();
        if (!$this->nac_ci_asociado->Raw) {
            $this->nac_ci_asociado->CurrentValue = HtmlDecode($this->nac_ci_asociado->CurrentValue);
        }
        $this->nac_ci_asociado->EditValue = $this->nac_ci_asociado->CurrentValue;
        $this->nac_ci_asociado->PlaceHolder = RemoveHtml($this->nac_ci_asociado->caption());

        // ci_asociado
        $this->ci_asociado->setupEditAttributes();
        if (!$this->ci_asociado->Raw) {
            $this->ci_asociado->CurrentValue = HtmlDecode($this->ci_asociado->CurrentValue);
        }
        $this->ci_asociado->EditValue = $this->ci_asociado->CurrentValue;
        $this->ci_asociado->PlaceHolder = RemoveHtml($this->ci_asociado->caption());

        // nombre_asociado
        $this->nombre_asociado->setupEditAttributes();
        if (!$this->nombre_asociado->Raw) {
            $this->nombre_asociado->CurrentValue = HtmlDecode($this->nombre_asociado->CurrentValue);
        }
        $this->nombre_asociado->EditValue = $this->nombre_asociado->CurrentValue;
        $this->nombre_asociado->PlaceHolder = RemoveHtml($this->nombre_asociado->caption());

        // nac_difunto
        $this->nac_difunto->setupEditAttributes();
        if (!$this->nac_difunto->Raw) {
            $this->nac_difunto->CurrentValue = HtmlDecode($this->nac_difunto->CurrentValue);
        }
        $this->nac_difunto->EditValue = $this->nac_difunto->CurrentValue;
        $this->nac_difunto->PlaceHolder = RemoveHtml($this->nac_difunto->caption());

        // ci_difunto
        $this->ci_difunto->setupEditAttributes();
        if (!$this->ci_difunto->Raw) {
            $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
        }
        $this->ci_difunto->EditValue = $this->ci_difunto->CurrentValue;
        $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

        // edad
        $this->edad->setupEditAttributes();
        $this->edad->EditValue = $this->edad->CurrentValue;
        $this->edad->PlaceHolder = RemoveHtml($this->edad->caption());
        if (strval($this->edad->EditValue) != "" && is_numeric($this->edad->EditValue)) {
            $this->edad->EditValue = $this->edad->EditValue;
        }

        // edo_civil
        $this->edo_civil->setupEditAttributes();
        if (!$this->edo_civil->Raw) {
            $this->edo_civil->CurrentValue = HtmlDecode($this->edo_civil->CurrentValue);
        }
        $this->edo_civil->EditValue = $this->edo_civil->CurrentValue;
        $this->edo_civil->PlaceHolder = RemoveHtml($this->edo_civil->caption());

        // fecha_nacimiento
        $this->fecha_nacimiento->setupEditAttributes();
        if (!$this->fecha_nacimiento->Raw) {
            $this->fecha_nacimiento->CurrentValue = HtmlDecode($this->fecha_nacimiento->CurrentValue);
        }
        $this->fecha_nacimiento->EditValue = $this->fecha_nacimiento->CurrentValue;
        $this->fecha_nacimiento->PlaceHolder = RemoveHtml($this->fecha_nacimiento->caption());

        // lugar
        $this->lugar->setupEditAttributes();
        if (!$this->lugar->Raw) {
            $this->lugar->CurrentValue = HtmlDecode($this->lugar->CurrentValue);
        }
        $this->lugar->EditValue = $this->lugar->CurrentValue;
        $this->lugar->PlaceHolder = RemoveHtml($this->lugar->caption());

        // fecha_defuncion
        $this->fecha_defuncion->setupEditAttributes();
        if (!$this->fecha_defuncion->Raw) {
            $this->fecha_defuncion->CurrentValue = HtmlDecode($this->fecha_defuncion->CurrentValue);
        }
        $this->fecha_defuncion->EditValue = $this->fecha_defuncion->CurrentValue;
        $this->fecha_defuncion->PlaceHolder = RemoveHtml($this->fecha_defuncion->caption());

        // causa
        $this->causa->setupEditAttributes();
        if (!$this->causa->Raw) {
            $this->causa->CurrentValue = HtmlDecode($this->causa->CurrentValue);
        }
        $this->causa->EditValue = $this->causa->CurrentValue;
        $this->causa->PlaceHolder = RemoveHtml($this->causa->caption());

        // certificado
        $this->certificado->setupEditAttributes();
        if (!$this->certificado->Raw) {
            $this->certificado->CurrentValue = HtmlDecode($this->certificado->CurrentValue);
        }
        $this->certificado->EditValue = $this->certificado->CurrentValue;
        $this->certificado->PlaceHolder = RemoveHtml($this->certificado->caption());

        // funeraria
        $this->funeraria->setupEditAttributes();
        if (!$this->funeraria->Raw) {
            $this->funeraria->CurrentValue = HtmlDecode($this->funeraria->CurrentValue);
        }
        $this->funeraria->EditValue = $this->funeraria->CurrentValue;
        $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

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
                    $doc->exportCaption($this->Nparcela);
                    $doc->exportCaption($this->nacionalidad);
                    $doc->exportCaption($this->cedula);
                    $doc->exportCaption($this->titular);
                    $doc->exportCaption($this->contrato);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->sub_seccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->boveda);
                    $doc->exportCaption($this->apellido1);
                    $doc->exportCaption($this->apellido2);
                    $doc->exportCaption($this->nombre1);
                    $doc->exportCaption($this->nombre2);
                    $doc->exportCaption($this->fecha_inhumacion);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->telefono3);
                    $doc->exportCaption($this->direc1);
                    $doc->exportCaption($this->direc2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nac_ci_asociado);
                    $doc->exportCaption($this->ci_asociado);
                    $doc->exportCaption($this->nombre_asociado);
                    $doc->exportCaption($this->nac_difunto);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->edad);
                    $doc->exportCaption($this->edo_civil);
                    $doc->exportCaption($this->fecha_nacimiento);
                    $doc->exportCaption($this->lugar);
                    $doc->exportCaption($this->fecha_defuncion);
                    $doc->exportCaption($this->causa);
                    $doc->exportCaption($this->certificado);
                    $doc->exportCaption($this->funeraria);
                } else {
                    $doc->exportCaption($this->Nparcela);
                    $doc->exportCaption($this->nacionalidad);
                    $doc->exportCaption($this->cedula);
                    $doc->exportCaption($this->titular);
                    $doc->exportCaption($this->contrato);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->sub_seccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->boveda);
                    $doc->exportCaption($this->apellido1);
                    $doc->exportCaption($this->apellido2);
                    $doc->exportCaption($this->nombre1);
                    $doc->exportCaption($this->nombre2);
                    $doc->exportCaption($this->fecha_inhumacion);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->telefono3);
                    $doc->exportCaption($this->direc1);
                    $doc->exportCaption($this->direc2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nac_ci_asociado);
                    $doc->exportCaption($this->ci_asociado);
                    $doc->exportCaption($this->nombre_asociado);
                    $doc->exportCaption($this->nac_difunto);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->edad);
                    $doc->exportCaption($this->edo_civil);
                    $doc->exportCaption($this->fecha_nacimiento);
                    $doc->exportCaption($this->lugar);
                    $doc->exportCaption($this->fecha_defuncion);
                    $doc->exportCaption($this->causa);
                    $doc->exportCaption($this->certificado);
                    $doc->exportCaption($this->funeraria);
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
                        $doc->exportField($this->Nparcela);
                        $doc->exportField($this->nacionalidad);
                        $doc->exportField($this->cedula);
                        $doc->exportField($this->titular);
                        $doc->exportField($this->contrato);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->sub_seccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->boveda);
                        $doc->exportField($this->apellido1);
                        $doc->exportField($this->apellido2);
                        $doc->exportField($this->nombre1);
                        $doc->exportField($this->nombre2);
                        $doc->exportField($this->fecha_inhumacion);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->telefono3);
                        $doc->exportField($this->direc1);
                        $doc->exportField($this->direc2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nac_ci_asociado);
                        $doc->exportField($this->ci_asociado);
                        $doc->exportField($this->nombre_asociado);
                        $doc->exportField($this->nac_difunto);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->edad);
                        $doc->exportField($this->edo_civil);
                        $doc->exportField($this->fecha_nacimiento);
                        $doc->exportField($this->lugar);
                        $doc->exportField($this->fecha_defuncion);
                        $doc->exportField($this->causa);
                        $doc->exportField($this->certificado);
                        $doc->exportField($this->funeraria);
                    } else {
                        $doc->exportField($this->Nparcela);
                        $doc->exportField($this->nacionalidad);
                        $doc->exportField($this->cedula);
                        $doc->exportField($this->titular);
                        $doc->exportField($this->contrato);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->sub_seccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->boveda);
                        $doc->exportField($this->apellido1);
                        $doc->exportField($this->apellido2);
                        $doc->exportField($this->nombre1);
                        $doc->exportField($this->nombre2);
                        $doc->exportField($this->fecha_inhumacion);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->telefono3);
                        $doc->exportField($this->direc1);
                        $doc->exportField($this->direc2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nac_ci_asociado);
                        $doc->exportField($this->ci_asociado);
                        $doc->exportField($this->nombre_asociado);
                        $doc->exportField($this->nac_difunto);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->edad);
                        $doc->exportField($this->edo_civil);
                        $doc->exportField($this->fecha_nacimiento);
                        $doc->exportField($this->lugar);
                        $doc->exportField($this->fecha_defuncion);
                        $doc->exportField($this->causa);
                        $doc->exportField($this->certificado);
                        $doc->exportField($this->funeraria);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_parcela');
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
        $key .= $rs['Nparcela'];

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
                WriteAuditLog($usr, "A", 'sco_parcela', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nparcela'];

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
                    WriteAuditLog($usr, "U", 'sco_parcela', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nparcela'];

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
                WriteAuditLog($usr, "D", 'sco_parcela', $fldname, $key, $oldvalue);
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
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew)
    {
        //Log("Row Updated");
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
        // Aplicar solo en Listado y Vista
        if ($this->PageID == "list" || $this->PageID == "view") {
            // Limpiamos el valor para evitar espacios en blanco falsos
            $valorBoveda = trim(strval($this->boveda->CurrentValue));
            if ($valorBoveda == "") {
                // 1. Resaltamos toda la fila con un fondo sutil
                $this->RowAttrs["style"] = "background-color: #fff5f5 !important; border-left: 5px solid #dc3545 !important;";

                // 2. Estilo para los campos de datos (Contrato, nombres, etc.)
                $estiloAlertaCelda = "background-color: #f8d7da !important; color: #721c24 !important; font-weight: bold; border-bottom: 1px solid #f5c6cb !important;";
                $campos = ["contrato", "apellido1", "nombre1", "nombre2", "titular"];
                foreach ($campos as $fld) {
                    $this->$fld->CellAttrs["style"] = $estiloAlertaCelda;
                }

                // 3. Estilo específico para la celda BÓVEDA (Simulando la píldora)
                // Aplicamos el estilo directamente a la celda para que se vea como un botón de alerta
                $this->boveda->CellAttrs["style"] = "
                    background-color: #dc3545 !important; 
                    color: #ffffff !important; 
                    font-weight: 800 !important; 
                    text-align: center !important; 
                    border-radius: 50px !important; 
                    padding: 4px 10px !important;
                    display: table-cell;
                    border: 2px solid #bd2130 !important;
                    font-size: 10px;
                ";
                $this->boveda->ViewValue = "<i class='fas fa-exclamation-triangle'></i> SIN BÓVEDA";
            } else {
                // Estilo de píldora informativa (Azul/Cian) aplicada a la celda
                $this->boveda->CellAttrs["style"] = "
                    background-color: #17a2b8 !important; 
                    color: #ffffff !important; 
                    font-weight: bold !important; 
                    text-align: center !important; 
                    border-radius: 50px !important; 
                    padding: 4px 12px !important;
                    box-shadow: 1px 1px 3px rgba(0,0,0,0.1);
                ";
                // Mantenemos el valor original pero podemos agregar un icono
                $this->boveda->ViewValue = "<i class='fas fa-box'></i> " . $this->boveda->CurrentValue;
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
