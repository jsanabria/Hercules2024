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
 * Table class for sco_mascota
 */
class ScoMascota extends DbTable
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
    public $Nmascota;
    public $nombre_contratante;
    public $cedula_contratante;
    public $direccion_contratante;
    public $telefono1;
    public $telefono2;
    public $_email;
    public $nombre_mascota;
    public $peso;
    public $raza;
    public $tipo;
    public $tipo_otro;
    public $color;
    public $procedencia;
    public $tarifa;
    public $factura;
    public $costo;
    public $tasa;
    public $nota;
    public $fecha_cremacion;
    public $hora_cremacion;
    public $username_registra;
    public $fecha_registro;
    public $estatus;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_mascota";
        $this->TableName = 'sco_mascota';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_mascota";
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

        // Nmascota
        $this->Nmascota = new DbField(
            $this, // Table
            'x_Nmascota', // Variable name
            'Nmascota', // Name
            '`Nmascota`', // Expression
            '`Nmascota`', // Basic search expression
            21, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nmascota`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nmascota->InputTextType = "text";
        $this->Nmascota->Raw = true;
        $this->Nmascota->IsAutoIncrement = true; // Autoincrement field
        $this->Nmascota->IsPrimaryKey = true; // Primary key field
        $this->Nmascota->IsForeignKey = true; // Foreign key field
        $this->Nmascota->Nullable = false; // NOT NULL field
        $this->Nmascota->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nmascota->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nmascota'] = &$this->Nmascota;

        // nombre_contratante
        $this->nombre_contratante = new DbField(
            $this, // Table
            'x_nombre_contratante', // Variable name
            'nombre_contratante', // Name
            '`nombre_contratante`', // Expression
            '`nombre_contratante`', // Basic search expression
            200, // Type
            80, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_contratante`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_contratante->InputTextType = "text";
        $this->nombre_contratante->Required = true; // Required field
        $this->nombre_contratante->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_contratante'] = &$this->nombre_contratante;

        // cedula_contratante
        $this->cedula_contratante = new DbField(
            $this, // Table
            'x_cedula_contratante', // Variable name
            'cedula_contratante', // Name
            '`cedula_contratante`', // Expression
            '`cedula_contratante`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula_contratante`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula_contratante->InputTextType = "text";
        $this->cedula_contratante->Required = true; // Required field
        $this->cedula_contratante->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula_contratante'] = &$this->cedula_contratante;

        // direccion_contratante
        $this->direccion_contratante = new DbField(
            $this, // Table
            'x_direccion_contratante', // Variable name
            'direccion_contratante', // Name
            '`direccion_contratante`', // Expression
            '`direccion_contratante`', // Basic search expression
            200, // Type
            250, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direccion_contratante`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->direccion_contratante->InputTextType = "text";
        $this->direccion_contratante->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direccion_contratante'] = &$this->direccion_contratante;

        // telefono1
        $this->telefono1 = new DbField(
            $this, // Table
            'x_telefono1', // Variable name
            'telefono1', // Name
            '`telefono1`', // Expression
            '`telefono1`', // Basic search expression
            200, // Type
            20, // Size
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
            20, // Size
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
            150, // Size
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
        $this->_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->_email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['email'] = &$this->_email;

        // nombre_mascota
        $this->nombre_mascota = new DbField(
            $this, // Table
            'x_nombre_mascota', // Variable name
            'nombre_mascota', // Name
            '`nombre_mascota`', // Expression
            '`nombre_mascota`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_mascota`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_mascota->InputTextType = "text";
        $this->nombre_mascota->Required = true; // Required field
        $this->nombre_mascota->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_mascota'] = &$this->nombre_mascota;

        // peso
        $this->peso = new DbField(
            $this, // Table
            'x_peso', // Variable name
            'peso', // Name
            '`peso`', // Expression
            '`peso`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`peso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->peso->InputTextType = "text";
        $this->peso->Required = true; // Required field
        $this->peso->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['peso'] = &$this->peso;

        // raza
        $this->raza = new DbField(
            $this, // Table
            'x_raza', // Variable name
            'raza', // Name
            '`raza`', // Expression
            '`raza`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`raza`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->raza->InputTextType = "text";
        $this->raza->Required = true; // Required field
        $this->raza->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['raza'] = &$this->raza;

        // tipo
        $this->tipo = new DbField(
            $this, // Table
            'x_tipo', // Variable name
            'tipo', // Name
            '`tipo`', // Expression
            '`tipo`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo->addMethod("getSelectFilter", fn() => "`codigo` = '027'");
        $this->tipo->InputTextType = "text";
        $this->tipo->Required = true; // Required field
        $this->tipo->setSelectMultiple(false); // Select one
        $this->tipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo->Lookup = new Lookup($this->tipo, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1`', '', "`valor1`");
        $this->tipo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo'] = &$this->tipo;

        // tipo_otro
        $this->tipo_otro = new DbField(
            $this, // Table
            'x_tipo_otro', // Variable name
            'tipo_otro', // Name
            '`tipo_otro`', // Expression
            '`tipo_otro`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_otro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tipo_otro->InputTextType = "text";
        $this->tipo_otro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo_otro'] = &$this->tipo_otro;

        // color
        $this->color = new DbField(
            $this, // Table
            'x_color', // Variable name
            'color', // Name
            '`color`', // Expression
            '`color`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`color`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->color->InputTextType = "text";
        $this->color->Required = true; // Required field
        $this->color->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['color'] = &$this->color;

        // procedencia
        $this->procedencia = new DbField(
            $this, // Table
            'x_procedencia', // Variable name
            'procedencia', // Name
            '`procedencia`', // Expression
            '`procedencia`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`procedencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->procedencia->addMethod("getSelectFilter", fn() => "`codigo` = '028'");
        $this->procedencia->InputTextType = "text";
        $this->procedencia->Required = true; // Required field
        $this->procedencia->setSelectMultiple(false); // Select one
        $this->procedencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->procedencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->procedencia->Lookup = new Lookup($this->procedencia, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->procedencia->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['procedencia'] = &$this->procedencia;

        // tarifa
        $this->tarifa = new DbField(
            $this, // Table
            'x_tarifa', // Variable name
            'tarifa', // Name
            '`tarifa`', // Expression
            '`tarifa`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tarifa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tarifa->addMethod("getSelectFilter", fn() => "`codigo` = '029'");
        $this->tarifa->InputTextType = "text";
        $this->tarifa->Required = true; // Required field
        $this->tarifa->setSelectMultiple(false); // Select one
        $this->tarifa->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tarifa->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tarifa->Lookup = new Lookup($this->tarifa, 'sco_parametro', false, 'valor1', ["valor1","valor2","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`valor1`, ''),'" . ValueSeparator(1, $this->tarifa) . "',COALESCE(`valor2`,''))");
        $this->tarifa->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tarifa'] = &$this->tarifa;

        // factura
        $this->factura = new DbField(
            $this, // Table
            'x_factura', // Variable name
            'factura', // Name
            '`factura`', // Expression
            '`factura`', // Basic search expression
            200, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`factura`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->factura->InputTextType = "text";
        $this->factura->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['factura'] = &$this->factura;

        // costo
        $this->costo = new DbField(
            $this, // Table
            'x_costo', // Variable name
            'costo', // Name
            '`costo`', // Expression
            '`costo`', // Basic search expression
            5, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`costo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->costo->InputTextType = "text";
        $this->costo->Raw = true;
        $this->costo->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->costo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['costo'] = &$this->costo;

        // tasa
        $this->tasa = new DbField(
            $this, // Table
            'x_tasa', // Variable name
            'tasa', // Name
            '`tasa`', // Expression
            '`tasa`', // Basic search expression
            5, // Type
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
        $this->tasa->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->tasa->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tasa'] = &$this->tasa;

        // nota
        $this->nota = new DbField(
            $this, // Table
            'x_nota', // Variable name
            'nota', // Name
            '`nota`', // Expression
            '`nota`', // Basic search expression
            200, // Type
            250, // Size
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

        // fecha_cremacion
        $this->fecha_cremacion = new DbField(
            $this, // Table
            'x_fecha_cremacion', // Variable name
            'fecha_cremacion', // Name
            '`fecha_cremacion`', // Expression
            CastDateFieldForLike("`fecha_cremacion`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_cremacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_cremacion->InputTextType = "text";
        $this->fecha_cremacion->Raw = true;
        $this->fecha_cremacion->Required = true; // Required field
        $this->fecha_cremacion->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_cremacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_cremacion'] = &$this->fecha_cremacion;

        // hora_cremacion
        $this->hora_cremacion = new DbField(
            $this, // Table
            'x_hora_cremacion', // Variable name
            'hora_cremacion', // Name
            '`hora_cremacion`', // Expression
            CastDateFieldForLike("`hora_cremacion`", 4, "DB"), // Basic search expression
            134, // Type
            10, // Size
            4, // Date/Time format
            false, // Is upload field
            '`hora_cremacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_cremacion->InputTextType = "text";
        $this->hora_cremacion->Raw = true;
        $this->hora_cremacion->DefaultErrorMessage = str_replace("%s", DateFormat(4), $Language->phrase("IncorrectTime"));
        $this->hora_cremacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_cremacion'] = &$this->hora_cremacion;

        // username_registra
        $this->username_registra = new DbField(
            $this, // Table
            'x_username_registra', // Variable name
            'username_registra', // Name
            '`username_registra`', // Expression
            '`username_registra`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`username_registra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->username_registra->InputTextType = "text";
        $this->username_registra->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['username_registra'] = &$this->username_registra;

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

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            129, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estatus`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->estatus->addMethod("getSelectFilter", fn() => "`codigo` = '026'");
        $this->estatus->InputTextType = "text";
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_parametro', false, 'valor1', ["valor2","","",""], '', '', [], [], [], [], [], [], false, '`valor3` ASC', '', "`valor2`");
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

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
        if ($this->getCurrentDetailTable() == "sco_nota_mascota") {
            $detailUrl = Container("sco_nota_mascota")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nmascota", $this->Nmascota->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_mascota_estatus") {
            $detailUrl = Container("sco_mascota_estatus")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nmascota", $this->Nmascota->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoMascotaList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_mascota";
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
            $this->Nmascota->setDbValue($conn->lastInsertId());
            $rs['Nmascota'] = $this->Nmascota->DbValue;
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
        // Cascade Update detail table 'sco_nota_mascota'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nmascota']) && $rsold['Nmascota'] != $rs['Nmascota'])) { // Update detail field 'mascota'
            $cascadeUpdate = true;
            $rscascade['mascota'] = $rs['Nmascota'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_nota_mascota")->loadRs("`mascota` = " . QuotedValue($rsold['Nmascota'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nnota_mascota';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_nota_mascota")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_nota_mascota")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_nota_mascota")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'sco_mascota_estatus'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nmascota']) && $rsold['Nmascota'] != $rs['Nmascota'])) { // Update detail field 'mascota'
            $cascadeUpdate = true;
            $rscascade['mascota'] = $rs['Nmascota'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_mascota_estatus")->loadRs("`mascota` = " . QuotedValue($rsold['Nmascota'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'mascota';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $fldname = 'estatus';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_mascota_estatus")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_mascota_estatus")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_mascota_estatus")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Nmascota']) && !EmptyValue($this->Nmascota->CurrentValue)) {
                $rs['Nmascota'] = $this->Nmascota->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nmascota';
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
            if (array_key_exists('Nmascota', $rs)) {
                AddFilter($where, QuotedName('Nmascota', $this->Dbid) . '=' . QuotedValue($rs['Nmascota'], $this->Nmascota->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_nota_mascota'
        $dtlrows = Container("sco_nota_mascota")->loadRs("`mascota` = " . QuotedValue($rs['Nmascota'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_nota_mascota")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_nota_mascota")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_nota_mascota")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'sco_mascota_estatus'
        $dtlrows = Container("sco_mascota_estatus")->loadRs("`mascota` = " . QuotedValue($rs['Nmascota'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_mascota_estatus")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_mascota_estatus")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_mascota_estatus")->rowDeleted($dtlrow);
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
        $this->Nmascota->DbValue = $row['Nmascota'];
        $this->nombre_contratante->DbValue = $row['nombre_contratante'];
        $this->cedula_contratante->DbValue = $row['cedula_contratante'];
        $this->direccion_contratante->DbValue = $row['direccion_contratante'];
        $this->telefono1->DbValue = $row['telefono1'];
        $this->telefono2->DbValue = $row['telefono2'];
        $this->_email->DbValue = $row['email'];
        $this->nombre_mascota->DbValue = $row['nombre_mascota'];
        $this->peso->DbValue = $row['peso'];
        $this->raza->DbValue = $row['raza'];
        $this->tipo->DbValue = $row['tipo'];
        $this->tipo_otro->DbValue = $row['tipo_otro'];
        $this->color->DbValue = $row['color'];
        $this->procedencia->DbValue = $row['procedencia'];
        $this->tarifa->DbValue = $row['tarifa'];
        $this->factura->DbValue = $row['factura'];
        $this->costo->DbValue = $row['costo'];
        $this->tasa->DbValue = $row['tasa'];
        $this->nota->DbValue = $row['nota'];
        $this->fecha_cremacion->DbValue = $row['fecha_cremacion'];
        $this->hora_cremacion->DbValue = $row['hora_cremacion'];
        $this->username_registra->DbValue = $row['username_registra'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->estatus->DbValue = $row['estatus'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nmascota` = @Nmascota@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nmascota->CurrentValue : $this->Nmascota->OldValue;
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
                $this->Nmascota->CurrentValue = $keys[0];
            } else {
                $this->Nmascota->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nmascota', $row) ? $row['Nmascota'] : null;
        } else {
            $val = !EmptyValue($this->Nmascota->OldValue) && !$current ? $this->Nmascota->OldValue : $this->Nmascota->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nmascota@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoMascotaList");
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
            "ScoMascotaView" => $Language->phrase("View"),
            "ScoMascotaEdit" => $Language->phrase("Edit"),
            "ScoMascotaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoMascotaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoMascotaView",
            Config("API_ADD_ACTION") => "ScoMascotaAdd",
            Config("API_EDIT_ACTION") => "ScoMascotaEdit",
            Config("API_DELETE_ACTION") => "ScoMascotaDelete",
            Config("API_LIST_ACTION") => "ScoMascotaList",
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
        return "ScoMascotaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoMascotaView", $parm);
        } else {
            $url = $this->keyUrl("ScoMascotaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoMascotaAdd?" . $parm;
        } else {
            $url = "ScoMascotaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoMascotaEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoMascotaEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoMascotaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoMascotaAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoMascotaAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoMascotaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoMascotaDelete", $parm);
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
        $json .= "\"Nmascota\":" . VarToJson($this->Nmascota->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nmascota->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nmascota->CurrentValue);
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
            if (($keyValue = Param("Nmascota") ?? Route("Nmascota")) !== null) {
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
                $this->Nmascota->CurrentValue = $key;
            } else {
                $this->Nmascota->OldValue = $key;
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
        $this->Nmascota->setDbValue($row['Nmascota']);
        $this->nombre_contratante->setDbValue($row['nombre_contratante']);
        $this->cedula_contratante->setDbValue($row['cedula_contratante']);
        $this->direccion_contratante->setDbValue($row['direccion_contratante']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->nombre_mascota->setDbValue($row['nombre_mascota']);
        $this->peso->setDbValue($row['peso']);
        $this->raza->setDbValue($row['raza']);
        $this->tipo->setDbValue($row['tipo']);
        $this->tipo_otro->setDbValue($row['tipo_otro']);
        $this->color->setDbValue($row['color']);
        $this->procedencia->setDbValue($row['procedencia']);
        $this->tarifa->setDbValue($row['tarifa']);
        $this->factura->setDbValue($row['factura']);
        $this->costo->setDbValue($row['costo']);
        $this->tasa->setDbValue($row['tasa']);
        $this->nota->setDbValue($row['nota']);
        $this->fecha_cremacion->setDbValue($row['fecha_cremacion']);
        $this->hora_cremacion->setDbValue($row['hora_cremacion']);
        $this->username_registra->setDbValue($row['username_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoMascotaList";
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

        // Nmascota

        // nombre_contratante

        // cedula_contratante

        // direccion_contratante

        // telefono1

        // telefono2

        // email

        // nombre_mascota

        // peso

        // raza

        // tipo

        // tipo_otro

        // color

        // procedencia

        // tarifa

        // factura

        // costo

        // tasa

        // nota

        // fecha_cremacion

        // hora_cremacion

        // username_registra

        // fecha_registro

        // estatus

        // Nmascota
        $this->Nmascota->ViewValue = $this->Nmascota->CurrentValue;

        // nombre_contratante
        $this->nombre_contratante->ViewValue = $this->nombre_contratante->CurrentValue;

        // cedula_contratante
        $this->cedula_contratante->ViewValue = $this->cedula_contratante->CurrentValue;

        // direccion_contratante
        $this->direccion_contratante->ViewValue = $this->direccion_contratante->CurrentValue;

        // telefono1
        $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

        // telefono2
        $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // nombre_mascota
        $this->nombre_mascota->ViewValue = $this->nombre_mascota->CurrentValue;

        // peso
        $this->peso->ViewValue = $this->peso->CurrentValue;

        // raza
        $this->raza->ViewValue = $this->raza->CurrentValue;

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

        // tipo_otro
        $this->tipo_otro->ViewValue = $this->tipo_otro->CurrentValue;

        // color
        $this->color->ViewValue = $this->color->CurrentValue;

        // procedencia
        $curVal = strval($this->procedencia->CurrentValue);
        if ($curVal != "") {
            $this->procedencia->ViewValue = $this->procedencia->lookupCacheOption($curVal);
            if ($this->procedencia->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->procedencia->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->procedencia->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->procedencia->getSelectFilter($this); // PHP
                $sqlWrk = $this->procedencia->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->procedencia->Lookup->renderViewRow($rswrk[0]);
                    $this->procedencia->ViewValue = $this->procedencia->displayValue($arwrk);
                } else {
                    $this->procedencia->ViewValue = $this->procedencia->CurrentValue;
                }
            }
        } else {
            $this->procedencia->ViewValue = null;
        }

        // tarifa
        $curVal = strval($this->tarifa->CurrentValue);
        if ($curVal != "") {
            $this->tarifa->ViewValue = $this->tarifa->lookupCacheOption($curVal);
            if ($this->tarifa->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tarifa->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tarifa->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->tarifa->getSelectFilter($this); // PHP
                $sqlWrk = $this->tarifa->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tarifa->Lookup->renderViewRow($rswrk[0]);
                    $this->tarifa->ViewValue = $this->tarifa->displayValue($arwrk);
                } else {
                    $this->tarifa->ViewValue = $this->tarifa->CurrentValue;
                }
            }
        } else {
            $this->tarifa->ViewValue = null;
        }

        // factura
        $this->factura->ViewValue = $this->factura->CurrentValue;

        // costo
        $this->costo->ViewValue = $this->costo->CurrentValue;
        $this->costo->ViewValue = FormatNumber($this->costo->ViewValue, $this->costo->formatPattern());

        // tasa
        $this->tasa->ViewValue = $this->tasa->CurrentValue;
        $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // fecha_cremacion
        $this->fecha_cremacion->ViewValue = $this->fecha_cremacion->CurrentValue;
        $this->fecha_cremacion->ViewValue = FormatDateTime($this->fecha_cremacion->ViewValue, $this->fecha_cremacion->formatPattern());

        // hora_cremacion
        $this->hora_cremacion->ViewValue = $this->hora_cremacion->CurrentValue;
        $this->hora_cremacion->ViewValue = FormatDateTime($this->hora_cremacion->ViewValue, $this->hora_cremacion->formatPattern());

        // username_registra
        $this->username_registra->ViewValue = $this->username_registra->CurrentValue;

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

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

        // Nmascota
        $this->Nmascota->HrefValue = "";
        $this->Nmascota->TooltipValue = "";

        // nombre_contratante
        $this->nombre_contratante->HrefValue = "";
        $this->nombre_contratante->TooltipValue = "";

        // cedula_contratante
        $this->cedula_contratante->HrefValue = "";
        $this->cedula_contratante->TooltipValue = "";

        // direccion_contratante
        $this->direccion_contratante->HrefValue = "";
        $this->direccion_contratante->TooltipValue = "";

        // telefono1
        $this->telefono1->HrefValue = "";
        $this->telefono1->TooltipValue = "";

        // telefono2
        $this->telefono2->HrefValue = "";
        $this->telefono2->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // nombre_mascota
        $this->nombre_mascota->HrefValue = "";
        $this->nombre_mascota->TooltipValue = "";

        // peso
        $this->peso->HrefValue = "";
        $this->peso->TooltipValue = "";

        // raza
        $this->raza->HrefValue = "";
        $this->raza->TooltipValue = "";

        // tipo
        $this->tipo->HrefValue = "";
        $this->tipo->TooltipValue = "";

        // tipo_otro
        $this->tipo_otro->HrefValue = "";
        $this->tipo_otro->TooltipValue = "";

        // color
        $this->color->HrefValue = "";
        $this->color->TooltipValue = "";

        // procedencia
        $this->procedencia->HrefValue = "";
        $this->procedencia->TooltipValue = "";

        // tarifa
        $this->tarifa->HrefValue = "";
        $this->tarifa->TooltipValue = "";

        // factura
        $this->factura->HrefValue = "";
        $this->factura->TooltipValue = "";

        // costo
        $this->costo->HrefValue = "";
        $this->costo->TooltipValue = "";

        // tasa
        $this->tasa->HrefValue = "";
        $this->tasa->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // fecha_cremacion
        $this->fecha_cremacion->HrefValue = "";
        $this->fecha_cremacion->TooltipValue = "";

        // hora_cremacion
        $this->hora_cremacion->HrefValue = "";
        $this->hora_cremacion->TooltipValue = "";

        // username_registra
        $this->username_registra->HrefValue = "";
        $this->username_registra->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

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

        // Nmascota
        $this->Nmascota->setupEditAttributes();
        $this->Nmascota->EditValue = $this->Nmascota->CurrentValue;

        // nombre_contratante
        $this->nombre_contratante->setupEditAttributes();
        if (!$this->nombre_contratante->Raw) {
            $this->nombre_contratante->CurrentValue = HtmlDecode($this->nombre_contratante->CurrentValue);
        }
        $this->nombre_contratante->EditValue = $this->nombre_contratante->CurrentValue;
        $this->nombre_contratante->PlaceHolder = RemoveHtml($this->nombre_contratante->caption());

        // cedula_contratante
        $this->cedula_contratante->setupEditAttributes();
        if (!$this->cedula_contratante->Raw) {
            $this->cedula_contratante->CurrentValue = HtmlDecode($this->cedula_contratante->CurrentValue);
        }
        $this->cedula_contratante->EditValue = $this->cedula_contratante->CurrentValue;
        $this->cedula_contratante->PlaceHolder = RemoveHtml($this->cedula_contratante->caption());

        // direccion_contratante
        $this->direccion_contratante->setupEditAttributes();
        $this->direccion_contratante->EditValue = $this->direccion_contratante->CurrentValue;
        $this->direccion_contratante->PlaceHolder = RemoveHtml($this->direccion_contratante->caption());

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

        // nombre_mascota
        $this->nombre_mascota->setupEditAttributes();
        if (!$this->nombre_mascota->Raw) {
            $this->nombre_mascota->CurrentValue = HtmlDecode($this->nombre_mascota->CurrentValue);
        }
        $this->nombre_mascota->EditValue = $this->nombre_mascota->CurrentValue;
        $this->nombre_mascota->PlaceHolder = RemoveHtml($this->nombre_mascota->caption());

        // peso
        $this->peso->setupEditAttributes();
        if (!$this->peso->Raw) {
            $this->peso->CurrentValue = HtmlDecode($this->peso->CurrentValue);
        }
        $this->peso->EditValue = $this->peso->CurrentValue;
        $this->peso->PlaceHolder = RemoveHtml($this->peso->caption());

        // raza
        $this->raza->setupEditAttributes();
        if (!$this->raza->Raw) {
            $this->raza->CurrentValue = HtmlDecode($this->raza->CurrentValue);
        }
        $this->raza->EditValue = $this->raza->CurrentValue;
        $this->raza->PlaceHolder = RemoveHtml($this->raza->caption());

        // tipo
        $this->tipo->setupEditAttributes();
        $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

        // tipo_otro
        $this->tipo_otro->setupEditAttributes();
        if (!$this->tipo_otro->Raw) {
            $this->tipo_otro->CurrentValue = HtmlDecode($this->tipo_otro->CurrentValue);
        }
        $this->tipo_otro->EditValue = $this->tipo_otro->CurrentValue;
        $this->tipo_otro->PlaceHolder = RemoveHtml($this->tipo_otro->caption());

        // color
        $this->color->setupEditAttributes();
        if (!$this->color->Raw) {
            $this->color->CurrentValue = HtmlDecode($this->color->CurrentValue);
        }
        $this->color->EditValue = $this->color->CurrentValue;
        $this->color->PlaceHolder = RemoveHtml($this->color->caption());

        // procedencia
        $this->procedencia->setupEditAttributes();
        $this->procedencia->PlaceHolder = RemoveHtml($this->procedencia->caption());

        // tarifa
        $this->tarifa->setupEditAttributes();
        $this->tarifa->PlaceHolder = RemoveHtml($this->tarifa->caption());

        // factura
        $this->factura->setupEditAttributes();
        if (!$this->factura->Raw) {
            $this->factura->CurrentValue = HtmlDecode($this->factura->CurrentValue);
        }
        $this->factura->EditValue = $this->factura->CurrentValue;
        $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

        // costo
        $this->costo->setupEditAttributes();
        $this->costo->EditValue = $this->costo->CurrentValue;
        $this->costo->PlaceHolder = RemoveHtml($this->costo->caption());
        if (strval($this->costo->EditValue) != "" && is_numeric($this->costo->EditValue)) {
            $this->costo->EditValue = FormatNumber($this->costo->EditValue, null);
        }

        // tasa
        $this->tasa->setupEditAttributes();
        $this->tasa->EditValue = $this->tasa->CurrentValue;
        $this->tasa->PlaceHolder = RemoveHtml($this->tasa->caption());
        if (strval($this->tasa->EditValue) != "" && is_numeric($this->tasa->EditValue)) {
            $this->tasa->EditValue = FormatNumber($this->tasa->EditValue, null);
        }

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // fecha_cremacion
        $this->fecha_cremacion->setupEditAttributes();
        $this->fecha_cremacion->EditValue = FormatDateTime($this->fecha_cremacion->CurrentValue, $this->fecha_cremacion->formatPattern());
        $this->fecha_cremacion->PlaceHolder = RemoveHtml($this->fecha_cremacion->caption());

        // hora_cremacion
        $this->hora_cremacion->setupEditAttributes();
        $this->hora_cremacion->EditValue = FormatDateTime($this->hora_cremacion->CurrentValue, $this->hora_cremacion->formatPattern());
        $this->hora_cremacion->PlaceHolder = RemoveHtml($this->hora_cremacion->caption());

        // username_registra
        $this->username_registra->setupEditAttributes();
        if (!$this->username_registra->Raw) {
            $this->username_registra->CurrentValue = HtmlDecode($this->username_registra->CurrentValue);
        }
        $this->username_registra->EditValue = $this->username_registra->CurrentValue;
        $this->username_registra->PlaceHolder = RemoveHtml($this->username_registra->caption());

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

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
                    $doc->exportCaption($this->Nmascota);
                    $doc->exportCaption($this->nombre_contratante);
                    $doc->exportCaption($this->cedula_contratante);
                    $doc->exportCaption($this->direccion_contratante);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nombre_mascota);
                    $doc->exportCaption($this->peso);
                    $doc->exportCaption($this->raza);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->tipo_otro);
                    $doc->exportCaption($this->color);
                    $doc->exportCaption($this->procedencia);
                    $doc->exportCaption($this->tarifa);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->costo);
                    $doc->exportCaption($this->tasa);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->fecha_cremacion);
                    $doc->exportCaption($this->hora_cremacion);
                    $doc->exportCaption($this->username_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->estatus);
                } else {
                    $doc->exportCaption($this->Nmascota);
                    $doc->exportCaption($this->nombre_contratante);
                    $doc->exportCaption($this->cedula_contratante);
                    $doc->exportCaption($this->direccion_contratante);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nombre_mascota);
                    $doc->exportCaption($this->peso);
                    $doc->exportCaption($this->raza);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->tipo_otro);
                    $doc->exportCaption($this->color);
                    $doc->exportCaption($this->procedencia);
                    $doc->exportCaption($this->tarifa);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->costo);
                    $doc->exportCaption($this->tasa);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->fecha_cremacion);
                    $doc->exportCaption($this->hora_cremacion);
                    $doc->exportCaption($this->username_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->estatus);
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
                        $doc->exportField($this->Nmascota);
                        $doc->exportField($this->nombre_contratante);
                        $doc->exportField($this->cedula_contratante);
                        $doc->exportField($this->direccion_contratante);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nombre_mascota);
                        $doc->exportField($this->peso);
                        $doc->exportField($this->raza);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->tipo_otro);
                        $doc->exportField($this->color);
                        $doc->exportField($this->procedencia);
                        $doc->exportField($this->tarifa);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->costo);
                        $doc->exportField($this->tasa);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->fecha_cremacion);
                        $doc->exportField($this->hora_cremacion);
                        $doc->exportField($this->username_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->estatus);
                    } else {
                        $doc->exportField($this->Nmascota);
                        $doc->exportField($this->nombre_contratante);
                        $doc->exportField($this->cedula_contratante);
                        $doc->exportField($this->direccion_contratante);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nombre_mascota);
                        $doc->exportField($this->peso);
                        $doc->exportField($this->raza);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->tipo_otro);
                        $doc->exportField($this->color);
                        $doc->exportField($this->procedencia);
                        $doc->exportField($this->tarifa);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->costo);
                        $doc->exportField($this->tasa);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->fecha_cremacion);
                        $doc->exportField($this->hora_cremacion);
                        $doc->exportField($this->username_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->estatus);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_mascota');
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
        $key .= $rs['Nmascota'];

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
                WriteAuditLog($usr, "A", 'sco_mascota', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nmascota'];

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
                    WriteAuditLog($usr, "U", 'sco_mascota', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nmascota'];

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
                WriteAuditLog($usr, "D", 'sco_mascota', $fldname, $key, $oldvalue);
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
    	if(isset($_REQUEST["myst"])) {
    		$myst = trim($_REQUEST["myst"]);
    		AddFilter($filter, "estatus = '$myst'"); 
    	}
    	if(isset($_GET["id_exp"])) {
    		if(strlen(trim($_GET["id_exp"])) > 0) 
    			AddFilter($filter, "Nmascota = '" . trim($_GET["id_exp"]) . "'");
    	}
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
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	if($rsnew["tipo"] == "Otro" and trim($rsnew["tipo_otro"]) == "") {
    		$this->CancelMessage = "Especifique el Otro Tipo de Mascota.";
    		return FALSE;
    	}

    	//$rsnew["estatus"] = "P1";
    	$rsnew["username_registra"] = CurrentUserName();
    	$rsnew["fecha_registro"] = date("Y-m-d");
    	if(strtotime($rsnew["fecha_cremacion"]) < strtotime($rsnew["fecha_registro"])) {
    		$this->CancelMessage = "La Fecha de Cremaci&oacute;n no puede ser menor a la Fecha de Registro del Expediente";
    		return FALSE;
    	}
    	$sql = "SELECT valor2 AS costo FROM sco_parametro WHERE codigo = '029' AND valor1 = '" . $rsnew["tarifa"] . "';";
    	if($row = ExecuteRow($sql)) {
    		//////
    		$url = "http://callcenter.interasist.com/ws/GetTasaCambio.php";
    		$tasa_json = file_get_contents($url);
    		$decoded_json = json_decode($tasa_json, true);
    		$tasa = $decoded_json["listarTasa"];
    		$moneda = "";
    		$tasamonto = 0;
    		$fecha = "";
    		foreach ($tasa as $key => $value) {
    			$moneda = $value["moneda"];
    			$tasamonto = floatval($value["tasa"]);
    			$fecha = $value["fecha"];
    		}
    		//////
    		$rsnew["tasa"] = $tasamonto;
    		$rsnew["costo"] = 0.00; // floatval($row["costo"]) * $tasamonto;
    	}
    	else $rsnew["costo"] = 0.00;
    	return TRUE;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew) {
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	if($rsold["estatus"] == "P5") {
    		$this->CancelMessage = "El expediente est&aacute; cerrado; no se puede modificar.";
    		return FALSE;
    	}
    	if($rsnew["tipo"] == "Otro" and trim($rsnew["tipo_otro"]) == "") {
    		$this->CancelMessage = "Especifique el Otro Tipo de Mascota.";
    		return FALSE;
    	}
    	if($rsnew["tipo"] != "Otro") $rsnew["tipo_otro"] = "";
    	if($rsold["tarifa"] != $rsnew["tarifa"] or $rsold["tasa"] != $rsnew["tasa"]) {
    		$sql = "SELECT valor2 AS costo FROM sco_parametro WHERE codigo = '029' AND valor1 = '" . $rsnew["tarifa"] . "';"; 
    		if($row = ExecuteRow($sql)) {
    			$tasamonto = floatval($rsnew["tasa"]);
    			$rsnew["costo"] = floatval($row["costo"]) * $tasamonto;
    		}
    		else $rsnew["costo"] = 0.00;
    	}
    	return TRUE;
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
    public function rowDeleting(&$rs) {
    	// Enter your code here
    	// To cancel, set return value to False
    	if($rs["estatus"] != "P1" and trim($rs["estatus"]) != "") {
    		$this->CancelMessage = "El expediente tiene cambio de estatus; no se puede eliminar.";
    		return FALSE;
    	}
    	return TRUE;
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
    		$sql = "SELECT valor4 AS color FROM sco_parametro 
    				WHERE codigo = '026' AND valor1 = '" . $this->estatus->CurrentValue . "';";
    		$color = ExecuteScalar($sql);
    		$style = $color; 	
    		$this->Nmascota->CellAttrs["style"] = $style;
    		$this->nombre_mascota->CellAttrs["style"] = $style;
    		$this->raza->CellAttrs["style"] = $style;
    		$this->tipo->CellAttrs["style"] = $style;
    		$this->color->CellAttrs["style"] = $style;
    		$this->estatus->CellAttrs["style"] = $style;
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
