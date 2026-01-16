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
 * Table class for sco_grama
 */
class ScoGrama extends DbTable
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
    public $Ngrama;
    public $ci_solicitante;
    public $solicitante;
    public $telefono1;
    public $telefono2;
    public $_email;
    public $tipo;
    public $subtipo;
    public $monto;
    public $tasa;
    public $monto_bs;
    public $nota;
    public $contrato;
    public $seccion;
    public $modulo;
    public $sub_seccion;
    public $parcela;
    public $boveda;
    public $ci_difunto;
    public $apellido1;
    public $apellido2;
    public $nombre1;
    public $nombre2;
    public $fecha_solucion;
    public $fecha_desde;
    public $fecha_hasta;
    public $estatus;
    public $fecha_registro;
    public $usuario_registro;
    public $email_renovacion;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_grama";
        $this->TableName = 'sco_grama';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_grama";
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

        // Ngrama
        $this->Ngrama = new DbField(
            $this, // Table
            'x_Ngrama', // Variable name
            'Ngrama', // Name
            '`Ngrama`', // Expression
            '`Ngrama`', // Basic search expression
            21, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Ngrama`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Ngrama->InputTextType = "text";
        $this->Ngrama->Raw = true;
        $this->Ngrama->IsAutoIncrement = true; // Autoincrement field
        $this->Ngrama->IsPrimaryKey = true; // Primary key field
        $this->Ngrama->IsForeignKey = true; // Foreign key field
        $this->Ngrama->Nullable = false; // NOT NULL field
        $this->Ngrama->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Ngrama->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Ngrama'] = &$this->Ngrama;

        // ci_solicitante
        $this->ci_solicitante = new DbField(
            $this, // Table
            'x_ci_solicitante', // Variable name
            'ci_solicitante', // Name
            '`ci_solicitante`', // Expression
            '`ci_solicitante`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ci_solicitante`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ci_solicitante->InputTextType = "text";
        $this->ci_solicitante->Required = true; // Required field
        $this->ci_solicitante->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_solicitante'] = &$this->ci_solicitante;

        // solicitante
        $this->solicitante = new DbField(
            $this, // Table
            'x_solicitante', // Variable name
            'solicitante', // Name
            '`solicitante`', // Expression
            '`solicitante`', // Basic search expression
            200, // Type
            40, // Size
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
        $this->telefono1->Required = true; // Required field
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
        $this->_email->Required = true; // Required field
        $this->_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->_email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['email'] = &$this->_email;

        // tipo
        $this->tipo = new DbField(
            $this, // Table
            'x_tipo', // Variable name
            'tipo', // Name
            '`tipo`', // Expression
            '`tipo`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo->addMethod("getSelectFilter", fn() => "`codigo` = '058'");
        $this->tipo->InputTextType = "text";
        $this->tipo->Required = true; // Required field
        $this->tipo->setSelectMultiple(false); // Select one
        $this->tipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo->Lookup = new Lookup($this->tipo, 'sco_parametro', false, 'valor1', ["valor2","","",""], '', '', [], ["x_subtipo"], [], [], [], [], false, '`valor1`', '', "`valor2`");
        $this->tipo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo'] = &$this->tipo;

        // subtipo
        $this->subtipo = new DbField(
            $this, // Table
            'x_subtipo', // Variable name
            'subtipo', // Name
            '`subtipo`', // Expression
            '`subtipo`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`subtipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->subtipo->addMethod("getSelectFilter", fn() => "`codigo` = '059'");
        $this->subtipo->InputTextType = "text";
        $this->subtipo->Required = true; // Required field
        $this->subtipo->setSelectMultiple(false); // Select one
        $this->subtipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->subtipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->subtipo->Lookup = new Lookup($this->subtipo, 'sco_parametro', false, 'valor1', ["valor2","","",""], '', '', ["x_tipo"], [], ["valor3"], ["x_valor3"], [], [], false, '', '', "`valor2`");
        $this->subtipo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['subtipo'] = &$this->subtipo;

        // monto
        $this->monto = new DbField(
            $this, // Table
            'x_monto', // Variable name
            'monto', // Name
            '`monto`', // Expression
            '`monto`', // Basic search expression
            131, // Type
            16, // Size
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
        $this->monto->Required = true; // Required field
        $this->monto->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['monto'] = &$this->monto;

        // tasa
        $this->tasa = new DbField(
            $this, // Table
            'x_tasa', // Variable name
            'tasa', // Name
            '`tasa`', // Expression
            '`tasa`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tasa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tasa->InputTextType = "text";
        $this->tasa->Raw = true;
        $this->tasa->Nullable = false; // NOT NULL field
        $this->tasa->Required = true; // Required field
        $this->tasa->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->tasa->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['tasa'] = &$this->tasa;

        // monto_bs
        $this->monto_bs = new DbField(
            $this, // Table
            'x_monto_bs', // Variable name
            'monto_bs', // Name
            '`monto_bs`', // Expression
            '`monto_bs`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`monto_bs`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->monto_bs->InputTextType = "text";
        $this->monto_bs->Raw = true;
        $this->monto_bs->Nullable = false; // NOT NULL field
        $this->monto_bs->Required = true; // Required field
        $this->monto_bs->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto_bs->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['monto_bs'] = &$this->monto_bs;

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
        $this->seccion->Required = true; // Required field
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
        $this->modulo->Required = true; // Required field
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
        $this->sub_seccion->Required = true; // Required field
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
        $this->parcela->Required = true; // Required field
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

        // fecha_solucion
        $this->fecha_solucion = new DbField(
            $this, // Table
            'x_fecha_solucion', // Variable name
            'fecha_solucion', // Name
            '`fecha_solucion`', // Expression
            CastDateFieldForLike("`fecha_solucion`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_solucion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_solucion->InputTextType = "text";
        $this->fecha_solucion->Raw = true;
        $this->fecha_solucion->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_solucion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_solucion'] = &$this->fecha_solucion;

        // fecha_desde
        $this->fecha_desde = new DbField(
            $this, // Table
            'x_fecha_desde', // Variable name
            'fecha_desde', // Name
            '`fecha_desde`', // Expression
            CastDateFieldForLike("`fecha_desde`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_desde`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_desde->InputTextType = "text";
        $this->fecha_desde->Raw = true;
        $this->fecha_desde->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_desde->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_desde'] = &$this->fecha_desde;

        // fecha_hasta
        $this->fecha_hasta = new DbField(
            $this, // Table
            'x_fecha_hasta', // Variable name
            'fecha_hasta', // Name
            '`fecha_hasta`', // Expression
            CastDateFieldForLike("`fecha_hasta`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_hasta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_hasta->InputTextType = "text";
        $this->fecha_hasta->Raw = true;
        $this->fecha_hasta->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_hasta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_hasta'] = &$this->fecha_hasta;

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estatus`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->estatus->addMethod("getSelectFilter", fn() => (CurrentPageID() == "edit") ? "`codigo` = '057' AND valor1 IN ('E1','E2','E3')" : "`codigo` = '057'");
        $this->estatus->InputTextType = "text";
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_parametro', false, 'valor1', ["valor2","","",""], '', '', [], [], [], [], [], [], false, '`valor3` ASC', '', "`valor2`");
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

        // fecha_registro
        $this->fecha_registro = new DbField(
            $this, // Table
            'x_fecha_registro', // Variable name
            'fecha_registro', // Name
            '`fecha_registro`', // Expression
            CastDateFieldForLike("`fecha_registro`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_registro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_registro->InputTextType = "text";
        $this->fecha_registro->Raw = true;
        $this->fecha_registro->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_registro'] = &$this->fecha_registro;

        // usuario_registro
        $this->usuario_registro = new DbField(
            $this, // Table
            'x_usuario_registro', // Variable name
            'usuario_registro', // Name
            '`usuario_registro`', // Expression
            '`usuario_registro`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`usuario_registro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usuario_registro->InputTextType = "text";
        $this->usuario_registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario_registro'] = &$this->usuario_registro;

        // email_renovacion
        $this->email_renovacion = new DbField(
            $this, // Table
            'x_email_renovacion', // Variable name
            'email_renovacion', // Name
            '`email_renovacion`', // Expression
            '`email_renovacion`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email_renovacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->email_renovacion->addMethod("getDefault", fn() => "N");
        $this->email_renovacion->InputTextType = "text";
        $this->email_renovacion->Raw = true;
        $this->email_renovacion->Lookup = new Lookup($this->email_renovacion, 'sco_grama', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->email_renovacion->OptionCount = 2;
        $this->email_renovacion->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['email_renovacion'] = &$this->email_renovacion;

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
        if ($this->getCurrentDetailTable() == "sco_grama_pagos") {
            $detailUrl = Container("sco_grama_pagos")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Ngrama", $this->Ngrama->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_grama_nota") {
            $detailUrl = Container("sco_grama_nota")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Ngrama", $this->Ngrama->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_grama_adjunto") {
            $detailUrl = Container("sco_grama_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Ngrama", $this->Ngrama->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoGramaList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_grama";
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
            $this->Ngrama->setDbValue($conn->lastInsertId());
            $rs['Ngrama'] = $this->Ngrama->DbValue;
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

        // Return auto increment field
        if ($success) {
            if (!isset($rs['Ngrama']) && !EmptyValue($this->Ngrama->CurrentValue)) {
                $rs['Ngrama'] = $this->Ngrama->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Ngrama';
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
            if (array_key_exists('Ngrama', $rs)) {
                AddFilter($where, QuotedName('Ngrama', $this->Dbid) . '=' . QuotedValue($rs['Ngrama'], $this->Ngrama->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_grama_pagos'
        $dtlrows = Container("sco_grama_pagos")->loadRs("`grama` = " . QuotedValue($rs['Ngrama'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_grama_pagos")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_grama_pagos")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_grama_pagos")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'sco_grama_nota'
        $dtlrows = Container("sco_grama_nota")->loadRs("`grama` = " . QuotedValue($rs['Ngrama'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_grama_nota")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_grama_nota")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_grama_nota")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'sco_grama_adjunto'
        $dtlrows = Container("sco_grama_adjunto")->loadRs("`grama` = " . QuotedValue($rs['Ngrama'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_grama_adjunto")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_grama_adjunto")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_grama_adjunto")->rowDeleted($dtlrow);
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
        $this->Ngrama->DbValue = $row['Ngrama'];
        $this->ci_solicitante->DbValue = $row['ci_solicitante'];
        $this->solicitante->DbValue = $row['solicitante'];
        $this->telefono1->DbValue = $row['telefono1'];
        $this->telefono2->DbValue = $row['telefono2'];
        $this->_email->DbValue = $row['email'];
        $this->tipo->DbValue = $row['tipo'];
        $this->subtipo->DbValue = $row['subtipo'];
        $this->monto->DbValue = $row['monto'];
        $this->tasa->DbValue = $row['tasa'];
        $this->monto_bs->DbValue = $row['monto_bs'];
        $this->nota->DbValue = $row['nota'];
        $this->contrato->DbValue = $row['contrato'];
        $this->seccion->DbValue = $row['seccion'];
        $this->modulo->DbValue = $row['modulo'];
        $this->sub_seccion->DbValue = $row['sub_seccion'];
        $this->parcela->DbValue = $row['parcela'];
        $this->boveda->DbValue = $row['boveda'];
        $this->ci_difunto->DbValue = $row['ci_difunto'];
        $this->apellido1->DbValue = $row['apellido1'];
        $this->apellido2->DbValue = $row['apellido2'];
        $this->nombre1->DbValue = $row['nombre1'];
        $this->nombre2->DbValue = $row['nombre2'];
        $this->fecha_solucion->DbValue = $row['fecha_solucion'];
        $this->fecha_desde->DbValue = $row['fecha_desde'];
        $this->fecha_hasta->DbValue = $row['fecha_hasta'];
        $this->estatus->DbValue = $row['estatus'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->usuario_registro->DbValue = $row['usuario_registro'];
        $this->email_renovacion->DbValue = $row['email_renovacion'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Ngrama` = @Ngrama@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Ngrama->CurrentValue : $this->Ngrama->OldValue;
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
                $this->Ngrama->CurrentValue = $keys[0];
            } else {
                $this->Ngrama->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Ngrama', $row) ? $row['Ngrama'] : null;
        } else {
            $val = !EmptyValue($this->Ngrama->OldValue) && !$current ? $this->Ngrama->OldValue : $this->Ngrama->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Ngrama@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoGramaList");
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
            "ScoGramaView" => $Language->phrase("View"),
            "ScoGramaEdit" => $Language->phrase("Edit"),
            "ScoGramaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoGramaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoGramaView",
            Config("API_ADD_ACTION") => "ScoGramaAdd",
            Config("API_EDIT_ACTION") => "ScoGramaEdit",
            Config("API_DELETE_ACTION") => "ScoGramaDelete",
            Config("API_LIST_ACTION") => "ScoGramaList",
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
        return "ScoGramaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoGramaView", $parm);
        } else {
            $url = $this->keyUrl("ScoGramaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoGramaAdd?" . $parm;
        } else {
            $url = "ScoGramaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoGramaEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoGramaEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoGramaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoGramaAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoGramaAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoGramaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoGramaDelete", $parm);
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
        $json .= "\"Ngrama\":" . VarToJson($this->Ngrama->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Ngrama->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Ngrama->CurrentValue);
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
            if (($keyValue = Param("Ngrama") ?? Route("Ngrama")) !== null) {
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
                $this->Ngrama->CurrentValue = $key;
            } else {
                $this->Ngrama->OldValue = $key;
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

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoGramaList";
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

        // telefono1
        $this->telefono1->HrefValue = "";
        $this->telefono1->TooltipValue = "";

        // telefono2
        $this->telefono2->HrefValue = "";
        $this->telefono2->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // tipo
        $this->tipo->HrefValue = "";
        $this->tipo->TooltipValue = "";

        // subtipo
        $this->subtipo->HrefValue = "";
        $this->subtipo->TooltipValue = "";

        // monto
        $this->monto->HrefValue = "";
        $this->monto->TooltipValue = "";

        // tasa
        $this->tasa->HrefValue = "";
        $this->tasa->TooltipValue = "";

        // monto_bs
        $this->monto_bs->HrefValue = "";
        $this->monto_bs->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

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

        // ci_difunto
        $this->ci_difunto->HrefValue = "";
        $this->ci_difunto->TooltipValue = "";

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

        // fecha_solucion
        $this->fecha_solucion->HrefValue = "";
        $this->fecha_solucion->TooltipValue = "";

        // fecha_desde
        $this->fecha_desde->HrefValue = "";
        $this->fecha_desde->TooltipValue = "";

        // fecha_hasta
        $this->fecha_hasta->HrefValue = "";
        $this->fecha_hasta->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // usuario_registro
        $this->usuario_registro->HrefValue = "";
        $this->usuario_registro->TooltipValue = "";

        // email_renovacion
        $this->email_renovacion->HrefValue = "";
        $this->email_renovacion->TooltipValue = "";

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

        // Ngrama
        $this->Ngrama->setupEditAttributes();
        $this->Ngrama->EditValue = $this->Ngrama->CurrentValue;

        // ci_solicitante
        $this->ci_solicitante->setupEditAttributes();
        if (!$this->ci_solicitante->Raw) {
            $this->ci_solicitante->CurrentValue = HtmlDecode($this->ci_solicitante->CurrentValue);
        }
        $this->ci_solicitante->EditValue = $this->ci_solicitante->CurrentValue;
        $this->ci_solicitante->PlaceHolder = RemoveHtml($this->ci_solicitante->caption());

        // solicitante
        $this->solicitante->setupEditAttributes();
        if (!$this->solicitante->Raw) {
            $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
        }
        $this->solicitante->EditValue = $this->solicitante->CurrentValue;
        $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

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

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // tipo
        $this->tipo->setupEditAttributes();
        $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

        // subtipo
        $this->subtipo->setupEditAttributes();
        $this->subtipo->PlaceHolder = RemoveHtml($this->subtipo->caption());

        // monto
        $this->monto->setupEditAttributes();
        $this->monto->EditValue = $this->monto->CurrentValue;
        $this->monto->PlaceHolder = RemoveHtml($this->monto->caption());
        if (strval($this->monto->EditValue) != "" && is_numeric($this->monto->EditValue)) {
            $this->monto->EditValue = FormatNumber($this->monto->EditValue, null);
        }

        // tasa
        $this->tasa->setupEditAttributes();
        $this->tasa->EditValue = $this->tasa->CurrentValue;
        $this->tasa->PlaceHolder = RemoveHtml($this->tasa->caption());
        if (strval($this->tasa->EditValue) != "" && is_numeric($this->tasa->EditValue)) {
            $this->tasa->EditValue = FormatNumber($this->tasa->EditValue, null);
        }

        // monto_bs
        $this->monto_bs->setupEditAttributes();
        $this->monto_bs->EditValue = $this->monto_bs->CurrentValue;
        $this->monto_bs->PlaceHolder = RemoveHtml($this->monto_bs->caption());
        if (strval($this->monto_bs->EditValue) != "" && is_numeric($this->monto_bs->EditValue)) {
            $this->monto_bs->EditValue = FormatNumber($this->monto_bs->EditValue, null);
        }

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // contrato
        $this->contrato->setupEditAttributes();
        $this->contrato->EditValue = $this->contrato->CurrentValue;

        // seccion
        $this->seccion->setupEditAttributes();
        $this->seccion->EditValue = $this->seccion->CurrentValue;

        // modulo
        $this->modulo->setupEditAttributes();
        $this->modulo->EditValue = $this->modulo->CurrentValue;

        // sub_seccion
        $this->sub_seccion->setupEditAttributes();
        $this->sub_seccion->EditValue = $this->sub_seccion->CurrentValue;

        // parcela
        $this->parcela->setupEditAttributes();
        $this->parcela->EditValue = $this->parcela->CurrentValue;

        // boveda
        $this->boveda->setupEditAttributes();
        $this->boveda->EditValue = $this->boveda->CurrentValue;

        // ci_difunto
        $this->ci_difunto->setupEditAttributes();
        if (!$this->ci_difunto->Raw) {
            $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
        }
        $this->ci_difunto->EditValue = $this->ci_difunto->CurrentValue;
        $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

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

        // fecha_solucion
        $this->fecha_solucion->setupEditAttributes();
        $this->fecha_solucion->EditValue = $this->fecha_solucion->CurrentValue;
        $this->fecha_solucion->EditValue = FormatDateTime($this->fecha_solucion->EditValue, $this->fecha_solucion->formatPattern());

        // fecha_desde
        $this->fecha_desde->setupEditAttributes();
        $this->fecha_desde->EditValue = FormatDateTime($this->fecha_desde->CurrentValue, $this->fecha_desde->formatPattern());
        $this->fecha_desde->PlaceHolder = RemoveHtml($this->fecha_desde->caption());

        // fecha_hasta
        $this->fecha_hasta->setupEditAttributes();
        $this->fecha_hasta->EditValue = FormatDateTime($this->fecha_hasta->CurrentValue, $this->fecha_hasta->formatPattern());
        $this->fecha_hasta->PlaceHolder = RemoveHtml($this->fecha_hasta->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->EditValue, $this->fecha_registro->formatPattern());

        // usuario_registro
        $this->usuario_registro->setupEditAttributes();
        $this->usuario_registro->EditValue = $this->usuario_registro->CurrentValue;

        // email_renovacion
        $this->email_renovacion->EditValue = $this->email_renovacion->options(false);
        $this->email_renovacion->PlaceHolder = RemoveHtml($this->email_renovacion->caption());

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
                    $doc->exportCaption($this->Ngrama);
                    $doc->exportCaption($this->ci_solicitante);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->subtipo);
                    $doc->exportCaption($this->monto);
                    $doc->exportCaption($this->tasa);
                    $doc->exportCaption($this->monto_bs);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->contrato);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->sub_seccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->boveda);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->apellido1);
                    $doc->exportCaption($this->apellido2);
                    $doc->exportCaption($this->nombre1);
                    $doc->exportCaption($this->nombre2);
                    $doc->exportCaption($this->fecha_solucion);
                    $doc->exportCaption($this->fecha_desde);
                    $doc->exportCaption($this->fecha_hasta);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->usuario_registro);
                } else {
                    $doc->exportCaption($this->Ngrama);
                    $doc->exportCaption($this->ci_solicitante);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->subtipo);
                    $doc->exportCaption($this->monto);
                    $doc->exportCaption($this->tasa);
                    $doc->exportCaption($this->monto_bs);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->contrato);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->sub_seccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->boveda);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->apellido1);
                    $doc->exportCaption($this->apellido2);
                    $doc->exportCaption($this->nombre1);
                    $doc->exportCaption($this->nombre2);
                    $doc->exportCaption($this->fecha_solucion);
                    $doc->exportCaption($this->fecha_desde);
                    $doc->exportCaption($this->fecha_hasta);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->usuario_registro);
                    $doc->exportCaption($this->email_renovacion);
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
                        $doc->exportField($this->Ngrama);
                        $doc->exportField($this->ci_solicitante);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->subtipo);
                        $doc->exportField($this->monto);
                        $doc->exportField($this->tasa);
                        $doc->exportField($this->monto_bs);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->contrato);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->sub_seccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->boveda);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->apellido1);
                        $doc->exportField($this->apellido2);
                        $doc->exportField($this->nombre1);
                        $doc->exportField($this->nombre2);
                        $doc->exportField($this->fecha_solucion);
                        $doc->exportField($this->fecha_desde);
                        $doc->exportField($this->fecha_hasta);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->usuario_registro);
                    } else {
                        $doc->exportField($this->Ngrama);
                        $doc->exportField($this->ci_solicitante);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->subtipo);
                        $doc->exportField($this->monto);
                        $doc->exportField($this->tasa);
                        $doc->exportField($this->monto_bs);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->contrato);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->sub_seccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->boveda);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->apellido1);
                        $doc->exportField($this->apellido2);
                        $doc->exportField($this->nombre1);
                        $doc->exportField($this->nombre2);
                        $doc->exportField($this->fecha_solucion);
                        $doc->exportField($this->fecha_desde);
                        $doc->exportField($this->fecha_hasta);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->usuario_registro);
                        $doc->exportField($this->email_renovacion);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_grama');
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
        $key .= $rs['Ngrama'];

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
                WriteAuditLog($usr, "A", 'sco_grama', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Ngrama'];

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
                    WriteAuditLog($usr, "U", 'sco_grama', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Ngrama'];

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
                WriteAuditLog($usr, "D", 'sco_grama', $fldname, $key, $oldvalue);
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
    public function recordsetSelecting(&$filter) {
    	// Enter your code here
    	$sql = "UPDATE sco_grama 
    				SET estatus = 'E4' 
    			WHERE 
    				tipo = '6.1' 
    				AND estatus IN ('E1', 'E5') 
    				AND NOW() BETWEEN fecha_desde AND fecha_hasta";
    	Execute($sql);
    	$sql = "UPDATE sco_grama 
    				SET estatus = 'E5' 
    			WHERE 
    				tipo = '6.1' 
    				AND estatus = 'E4'
    				AND fecha_hasta <= NOW();";
    	Execute($sql);
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

    public function rowInserting($rsold, &$rsnew) {
        // 1. Obtener datos de la ubicación y prepararlos para SQL
        // Usamos QuotedValue para asegurar que la cadena esté limpia y con comillas
        $seccion = QuotedValue($rsnew["seccion"] ?? "", DataType::STRING);
        $modulo = QuotedValue($rsnew["modulo"] ?? "", DataType::STRING);
        $sub_seccion = QuotedValue($rsnew["sub_seccion"] ?? "", DataType::STRING);
        $parcela = QuotedValue($rsnew["parcela"] ?? "", DataType::STRING);

        // 2. Buscar datos del último expediente (Concatenación segura)
        $sql = "SELECT contrato, ci_solicitante, solicitante, telefono1, telefono2, email,
                       ci_difunto, apellido1, apellido2, nombre1, nombre2, boveda
                FROM sco_grama 
                WHERE seccion = $seccion 
                  AND modulo = $modulo 
                  AND sub_seccion = $sub_seccion 
                  AND parcela = $parcela 
                ORDER BY Ngrama DESC LIMIT 1";

        // ExecuteRow ahora recibe solo el string SQL
        $row = ExecuteRow($sql);

        // 3. Herencia de datos si existe registro previo
        if ($row) {
            foreach ($row as $campo => $valor) {
                // Solo asignamos si el campo está vacío en el formulario actual
                if (empty($rsnew[$campo])) {
                    $rsnew[$campo] = $valor;
                }
            }
        }

        // 4. Valores fijos y auditoría
        $rsnew["estatus"] = 'E1';
        $rsnew["fecha_registro"] = date("Y-m-d H:i:s");
        $rsnew["usuario_registro"] = CurrentUserName();

        // 5. Obtener Tasa de Cambio (Consumo de API con Timeout)
        $rsnew["tasa"] = 0;
        $ctx = stream_context_create(['http' => ['timeout' => 2]]);
        $url = "http://callcenter.interasist.com/ws/GetTasaCambio.php";
        $tasa_json = @file_get_contents($url, false, $ctx);
        if ($tasa_json) {
            $decoded = json_decode($tasa_json, true);
            $lista = $decoded["listarTasa"] ?? [];
            if (!empty($lista)) {
                $ultimaTasa = end($lista);
                $rsnew["tasa"] = floatval($ultimaTasa["tasa"] ?? 0);
            }
        }
        return TRUE;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    public function rowUpdating($rsold, &$rsnew) {
        // 1. Normalización de entradas
        if (($_REQUEST["x_subtipo"] ?? "") === "6.1.7") {
            $rsnew["tipo"] = "6.1";
        }

        // Usamos el operador ?? para evitar errores de null en PHP 8.1
        $tipo = trim($rsnew["tipo"] ?? $rsold["tipo"] ?? "");
        $estatusNuevo = $rsnew["estatus"] ?? $rsold["estatus"];
        $estatusViejo = $rsold["estatus"] ?? "";
        $fechaDesde = $rsnew["fecha_desde"] ?? $rsold["fecha_desde"] ?? "";
        $fechaHasta = $rsnew["fecha_hasta"] ?? $rsold["fecha_hasta"] ?? "";

        // 2. Bloqueo de cambio de tipo
        if (!empty(trim($rsold["tipo"] ?? "")) && $rsold["tipo"] !== ($rsnew["tipo"] ?? $rsold["tipo"])) {
            $this->setFailureMessage("No se puede cambiar el tipo de caso de este expediente.");
            return FALSE;
        }

        // 3. Reglas de Negocio por Tipo
        if ($tipo === "6.1") {
            // Validación de Fechas
            if (empty($fechaDesde) || empty($fechaHasta)) {
                $this->setFailureMessage("La fecha desde y hasta deben estar indicadas para contrataciones.");
                return FALSE;
            }
            if (strtotime($fechaDesde) > strtotime($fechaHasta)) {
                $this->setFailureMessage("La fecha desde no puede ser mayor a la fecha hasta.");
                return FALSE;
            }

            // Bloqueo de Estatus Manual
            if ($estatusViejo !== $estatusNuevo) {
                $this->setFailureMessage("Para contrataciones no se permiten cambios de estatus manuales.");
                return FALSE;
            }

            // Validación de Monto
            $monto = floatval($rsnew["monto"] ?? $rsold["monto"] ?? 0);
            if ($monto < 0) {
                $this->setFailureMessage("El monto USD debe ser mayor o igual a 0.");
                return FALSE;
            }

            // Cálculo automático de moneda local
            $tasa = floatval($rsnew["tasa"] ?? $rsold["tasa"] ?? 0);
            $rsnew["monto_bs"] = $monto * $tasa;
        } else {
            // --- LÓGICA PARA RECLAMOS ---
            if (floatval($rsnew["monto"] ?? 0) > 0) {
                $this->setFailureMessage("Para los reclamos el monto debe ser USD 0.");
                return FALSE;
            }
            if (!empty($fechaDesde) || !empty($fechaHasta)) {
                $this->setFailureMessage("Los reclamos no deben incluir fechas desde/hasta.");
                return FALSE;
            }

            // Limpieza de campos no aplicables
            $rsnew["fecha_desde"] = NULL;
            $rsnew["fecha_hasta"] = NULL;

            // Validación de Reclamo Cerrado
            if ($estatusViejo !== $estatusNuevo && $estatusViejo === "E3") {
                $this->setFailureMessage("El reclamo ya está cerrado; no se puede modificar su estatus.");
                return FALSE;
            }
        }
        return TRUE;
    }

    public function rowUpdated($rsold, $rsnew) {
        $tipo = trim($rsnew["tipo"] ?? $rsold["tipo"] ?? "");
        $estatusNuevo = $rsnew["estatus"] ?? $rsold["estatus"] ?? "";
        $estatusViejo = $rsold["estatus"] ?? "";

        // 1. Validar si hubo cambio de estatus en el tipo 6.2 (Reclamos)
        if ($tipo === "6.2" && $estatusViejo !== $estatusNuevo) {
            // 2. Obtener descripciones (Limpieza manual con QuotedValue)
            $qViejo = QuotedValue($estatusViejo, DataType::STRING);
            $qNuevo = QuotedValue($estatusNuevo, DataType::STRING);
            $sqlParam = "SELECT valor1, valor2 FROM sco_parametro 
                         WHERE codigo = '057' AND valor1 IN ($qViejo, $qNuevo)";
            $parametros = ExecuteRows($sqlParam);
            $descripciones = [];
            if ($parametros) {
                foreach ($parametros as $p) {
                    $descripciones[$p["valor1"]] = $p["valor2"];
                }
            }
            $txtViejo = $descripciones[$estatusViejo] ?? $estatusViejo;
            $txtNuevo = $descripciones[$estatusNuevo] ?? $estatusNuevo;

            // 3. Insertar la nota histórica (Concatenación Segura)
            $idGrama = QuotedValue($rsold["Ngrama"], DataType::NUMBER);
            $usuario = QuotedValue(CurrentUserName(), DataType::STRING);
            $fechaAhora = QuotedValue(date("Y-m-d H:i:s"), DataType::STRING);
            $comentario = QuotedValue("CAMBIO DE ESTATUS ($estatusNuevo): De $txtViejo a $txtNuevo", DataType::STRING);
            $sqlLog = "INSERT INTO sco_grama_nota (grama, nota, usuario, fecha) 
                       VALUES ($idGrama, $comentario, $usuario, $fechaAhora)";
            Execute($sqlLog);

            // 4. Actualizar fecha_solucion si el estatus es E3 (Cerrado)
            if ($estatusNuevo === "E3") {
                $sqlFix = "UPDATE sco_grama SET fecha_solucion = $fechaAhora WHERE Ngrama = $idGrama";
                Execute($sqlFix);
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

    public function rowRendering() {
        // 1. Ejecutar solo en páginas de lista o vista
        if (in_array($this->PageID, ["list", "view"])) {
            // 2. Obtener color del estatus (Uso de QuotedValue para seguridad manual)
            $estatus = $this->estatus->CurrentValue ?? "";
            $estatusQuoted = QuotedValue($estatus, DataType::STRING);
            $sqlColor = "SELECT valor4 FROM sco_parametro WHERE codigo = '057' AND valor1 = " . $estatusQuoted;
            $style = ExecuteScalar($sqlColor);

            // 3. Aplicar estilo a múltiples celdas
            $camposConEstilo = [
                "Ngrama", "solicitante", "tipo", "fecha_registro", "usuario_registro",
                "ci_difunto", "apellido1", "nombre1", "seccion", "modulo", "sub_seccion", "parcela"
            ];
            foreach ($camposConEstilo as $nombreCampo) {
                if (isset($this->$nombreCampo)) {
                    $this->$nombreCampo->CellAttrs["style"] = $style;
                }
            }

            // 4. Cálculo de pagos (Uso de QuotedValue para el ID)
            $idGrama = $this->Ngrama->CurrentValue ?? 0;
            $idGramaQuoted = QuotedValue($idGrama, DataType::NUMBER);
            $sqlPagos = "SELECT IFNULL(SUM(monto_bs), 0) FROM sco_grama_pagos WHERE grama = " . $idGramaQuoted;
            $totalPagadoBs = floatval(ExecuteScalar($sqlPagos));

            // Evitar división por cero y calcular monto en divisas
            $tasa = floatval($this->tasa->CurrentValue ?? 0);
            $montoEnDivisa = ($tasa > 0) ? ($totalPagadoBs / $tasa) : 0;
            $montoEsperado = floatval($this->monto->CurrentValue ?? 0);

            // 5. Lógica de colores para la celda de Monto
            if ($montoEnDivisa >= $montoEsperado && $montoEsperado > 0) {
                $estiloMonto = 'color: #ffffff; background-color: #28a745; font-weight: bold;'; // Verde
            } elseif ($montoEnDivisa <= 0) {
                $estiloMonto = 'color: #000000; background-color: #f8d7da;'; // Rosado
            } else {
                $estiloMonto = 'color: #000000; background-color: #ffc107;'; // Amarillo
            }
            $this->monto->CellAttrs["style"] = $estiloMonto;
        }

        // Ocultar campo
        $this->ci_solicitante->Visible = false;
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
