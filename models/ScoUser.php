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
 * Table class for sco_user
 */
class ScoUser extends DbTable
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
    public $Nuser;
    public $cedula;
    public $nombre;
    public $_username;
    public $_password;
    public $correo;
    public $direccion;
    public $level;
    public $activo;
    public $foto;
    public $fecha_ingreso_cia;
    public $fecha_egreso_cia;
    public $motivo_egreso;
    public $departamento;
    public $cargo;
    public $celular_1;
    public $celular_2;
    public $telefono_1;
    public $_email;
    public $hora_entrada;
    public $hora_salida;
    public $proveedor;
    public $seguro;
    public $level_cemantick;
    public $evaluacion;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_user";
        $this->TableName = 'sco_user';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_user";
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

        // Nuser
        $this->Nuser = new DbField(
            $this, // Table
            'x_Nuser', // Variable name
            'Nuser', // Name
            '`Nuser`', // Expression
            '`Nuser`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nuser`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nuser->InputTextType = "text";
        $this->Nuser->Raw = true;
        $this->Nuser->IsAutoIncrement = true; // Autoincrement field
        $this->Nuser->IsPrimaryKey = true; // Primary key field
        $this->Nuser->IsForeignKey = true; // Foreign key field
        $this->Nuser->Nullable = false; // NOT NULL field
        $this->Nuser->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nuser->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nuser'] = &$this->Nuser;

        // cedula
        $this->cedula = new DbField(
            $this, // Table
            'x_cedula', // Variable name
            'cedula', // Name
            '`cedula`', // Expression
            '`cedula`', // Basic search expression
            200, // Type
            20, // Size
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
        $this->cedula->Required = true; // Required field
        $this->cedula->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula'] = &$this->cedula;

        // nombre
        $this->nombre = new DbField(
            $this, // Table
            'x_nombre', // Variable name
            'nombre', // Name
            '`nombre`', // Expression
            '`nombre`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre->InputTextType = "text";
        $this->nombre->Nullable = false; // NOT NULL field
        $this->nombre->Required = true; // Required field
        $this->nombre->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['nombre'] = &$this->nombre;

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
        $this->_username->InputTextType = "text";
        $this->_username->Raw = true;
        $this->_username->Nullable = false; // NOT NULL field
        $this->_username->Required = true; // Required field
        $this->_username->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['username'] = &$this->_username;

        // password
        $this->_password = new DbField(
            $this, // Table
            'x__password', // Variable name
            'password', // Name
            '`password`', // Expression
            '`password`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`password`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'PASSWORD' // Edit Tag
        );
        $this->_password->InputTextType = "text";
        $this->_password->Nullable = false; // NOT NULL field
        $this->_password->Required = true; // Required field
        $this->_password->SearchOperators = ["=", "<>"];
        $this->Fields['password'] = &$this->_password;

        // correo
        $this->correo = new DbField(
            $this, // Table
            'x_correo', // Variable name
            'correo', // Name
            '`correo`', // Expression
            '`correo`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`correo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->correo->InputTextType = "text";
        $this->correo->Nullable = false; // NOT NULL field
        $this->correo->Required = true; // Required field
        $this->correo->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->correo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['correo'] = &$this->correo;

        // direccion
        $this->direccion = new DbField(
            $this, // Table
            'x_direccion', // Variable name
            'direccion', // Name
            '`direccion`', // Expression
            '`direccion`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direccion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->direccion->InputTextType = "text";
        $this->direccion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direccion'] = &$this->direccion;

        // level
        $this->level = new DbField(
            $this, // Table
            'x_level', // Variable name
            'level', // Name
            '`level`', // Expression
            '`level`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`level`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->level->addMethod("getDefault", fn() => 0);
        $this->level->InputTextType = "text";
        $this->level->Raw = true;
        $this->level->Nullable = false; // NOT NULL field
        $this->level->Required = true; // Required field
        $this->level->setSelectMultiple(false); // Select one
        $this->level->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->level->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->level->Lookup = new Lookup($this->level, 'userlevels', false, 'userlevelid', ["userlevelname","","",""], '', '', [], [], [], [], [], [], false, '`userlevelid`', '', "`userlevelname`");
        $this->level->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->level->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['level'] = &$this->level;

        // activo
        $this->activo = new DbField(
            $this, // Table
            'x_activo', // Variable name
            'activo', // Name
            '`activo`', // Expression
            '`activo`', // Basic search expression
            16, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`activo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->activo->addMethod("getDefault", fn() => 1);
        $this->activo->InputTextType = "text";
        $this->activo->Raw = true;
        $this->activo->Nullable = false; // NOT NULL field
        $this->activo->Required = true; // Required field
        $this->activo->setSelectMultiple(false); // Select one
        $this->activo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->activo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->activo->Lookup = new Lookup($this->activo, 'sco_user', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->activo->OptionCount = 2;
        $this->activo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->activo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['activo'] = &$this->activo;

        // foto
        $this->foto = new DbField(
            $this, // Table
            'x_foto', // Variable name
            'foto', // Name
            '`foto`', // Expression
            '`foto`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`foto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'IMAGE', // View Tag
            'FILE' // Edit Tag
        );
        $this->foto->InputTextType = "text";
        $this->foto->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['foto'] = &$this->foto;

        // fecha_ingreso_cia
        $this->fecha_ingreso_cia = new DbField(
            $this, // Table
            'x_fecha_ingreso_cia', // Variable name
            'fecha_ingreso_cia', // Name
            '`fecha_ingreso_cia`', // Expression
            CastDateFieldForLike("`fecha_ingreso_cia`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_ingreso_cia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_ingreso_cia->addMethod("getDefault", fn() => date('d/m/Y'));
        $this->fecha_ingreso_cia->InputTextType = "text";
        $this->fecha_ingreso_cia->Raw = true;
        $this->fecha_ingreso_cia->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_ingreso_cia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_ingreso_cia'] = &$this->fecha_ingreso_cia;

        // fecha_egreso_cia
        $this->fecha_egreso_cia = new DbField(
            $this, // Table
            'x_fecha_egreso_cia', // Variable name
            'fecha_egreso_cia', // Name
            '`fecha_egreso_cia`', // Expression
            CastDateFieldForLike("`fecha_egreso_cia`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_egreso_cia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_egreso_cia->InputTextType = "text";
        $this->fecha_egreso_cia->Raw = true;
        $this->fecha_egreso_cia->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_egreso_cia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_egreso_cia'] = &$this->fecha_egreso_cia;

        // motivo_egreso
        $this->motivo_egreso = new DbField(
            $this, // Table
            'x_motivo_egreso', // Variable name
            'motivo_egreso', // Name
            '`motivo_egreso`', // Expression
            '`motivo_egreso`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`motivo_egreso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->motivo_egreso->addMethod("getSelectFilter", fn() => "`codigo` = '055'");
        $this->motivo_egreso->InputTextType = "text";
        $this->motivo_egreso->setSelectMultiple(false); // Select one
        $this->motivo_egreso->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->motivo_egreso->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->motivo_egreso->Lookup = new Lookup($this->motivo_egreso, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->motivo_egreso->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['motivo_egreso'] = &$this->motivo_egreso;

        // departamento
        $this->departamento = new DbField(
            $this, // Table
            'x_departamento', // Variable name
            'departamento', // Name
            '`departamento`', // Expression
            '`departamento`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`departamento`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->departamento->addMethod("getSelectFilter", fn() => "`codigo` = '065'");
        $this->departamento->InputTextType = "text";
        $this->departamento->setSelectMultiple(false); // Select one
        $this->departamento->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->departamento->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->departamento->Lookup = new Lookup($this->departamento, 'sco_parametro', true, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1`', '', "`valor1`");
        $this->departamento->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['departamento'] = &$this->departamento;

        // cargo
        $this->cargo = new DbField(
            $this, // Table
            'x_cargo', // Variable name
            'cargo', // Name
            '`cargo`', // Expression
            '`cargo`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cargo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->cargo->addMethod("getSelectFilter", fn() => "`codigo` = '066'");
        $this->cargo->InputTextType = "text";
        $this->cargo->setSelectMultiple(false); // Select one
        $this->cargo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cargo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cargo->Lookup = new Lookup($this->cargo, 'sco_parametro', true, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1`', '', "`valor1`");
        $this->cargo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['cargo'] = &$this->cargo;

        // celular_1
        $this->celular_1 = new DbField(
            $this, // Table
            'x_celular_1', // Variable name
            'celular_1', // Name
            '`celular_1`', // Expression
            '`celular_1`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`celular_1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->celular_1->InputTextType = "text";
        $this->celular_1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['celular_1'] = &$this->celular_1;

        // celular_2
        $this->celular_2 = new DbField(
            $this, // Table
            'x_celular_2', // Variable name
            'celular_2', // Name
            '`celular_2`', // Expression
            '`celular_2`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`celular_2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->celular_2->InputTextType = "text";
        $this->celular_2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['celular_2'] = &$this->celular_2;

        // telefono_1
        $this->telefono_1 = new DbField(
            $this, // Table
            'x_telefono_1', // Variable name
            'telefono_1', // Name
            '`telefono_1`', // Expression
            '`telefono_1`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono_1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono_1->InputTextType = "text";
        $this->telefono_1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono_1'] = &$this->telefono_1;

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

        // hora_entrada
        $this->hora_entrada = new DbField(
            $this, // Table
            'x_hora_entrada', // Variable name
            'hora_entrada', // Name
            '`hora_entrada`', // Expression
            CastDateFieldForLike("`hora_entrada`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_entrada`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_entrada->addMethod("getDefault", fn() => '08:00:00');
        $this->hora_entrada->InputTextType = "text";
        $this->hora_entrada->Raw = true;
        $this->hora_entrada->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_entrada->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_entrada'] = &$this->hora_entrada;

        // hora_salida
        $this->hora_salida = new DbField(
            $this, // Table
            'x_hora_salida', // Variable name
            'hora_salida', // Name
            '`hora_salida`', // Expression
            CastDateFieldForLike("`hora_salida`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_salida`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_salida->addMethod("getDefault", fn() => '17:00:00');
        $this->hora_salida->InputTextType = "text";
        $this->hora_salida->Raw = true;
        $this->hora_salida->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_salida->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_salida'] = &$this->hora_salida;

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
        $this->proveedor->InputTextType = "text";
        $this->proveedor->Raw = true;
        $this->proveedor->setSelectMultiple(false); // Select one
        $this->proveedor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->proveedor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->proveedor->Lookup = new Lookup($this->proveedor, 'sco_proveedor', false, 'Nproveedor', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->proveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proveedor->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['proveedor'] = &$this->proveedor;

        // seguro
        $this->seguro = new DbField(
            $this, // Table
            'x_seguro', // Variable name
            'seguro', // Name
            '`seguro`', // Expression
            '`seguro`', // Basic search expression
            16, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`seguro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->seguro->InputTextType = "text";
        $this->seguro->Raw = true;
        $this->seguro->setSelectMultiple(false); // Select one
        $this->seguro->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->seguro->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->seguro->Lookup = new Lookup($this->seguro, 'sco_seguro', false, 'Nseguro', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->seguro->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->seguro->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['seguro'] = &$this->seguro;

        // level_cemantick
        $this->level_cemantick = new DbField(
            $this, // Table
            'x_level_cemantick', // Variable name
            'level_cemantick', // Name
            '`level_cemantick`', // Expression
            '`level_cemantick`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`level_cemantick`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->level_cemantick->addMethod("getDefault", fn() => 0);
        $this->level_cemantick->InputTextType = "text";
        $this->level_cemantick->Raw = true;
        $this->level_cemantick->Nullable = false; // NOT NULL field
        $this->level_cemantick->Required = true; // Required field
        $this->level_cemantick->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->level_cemantick->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['level_cemantick'] = &$this->level_cemantick;

        // evaluacion
        $this->evaluacion = new DbField(
            $this, // Table
            'x_evaluacion', // Variable name
            'evaluacion', // Name
            '`evaluacion`', // Expression
            '`evaluacion`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`evaluacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->evaluacion->addMethod("getDefault", fn() => "N");
        $this->evaluacion->InputTextType = "text";
        $this->evaluacion->Raw = true;
        $this->evaluacion->Nullable = false; // NOT NULL field
        $this->evaluacion->Required = true; // Required field
        $this->evaluacion->setSelectMultiple(false); // Select one
        $this->evaluacion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->evaluacion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->evaluacion->Lookup = new Lookup($this->evaluacion, 'sco_user', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->evaluacion->OptionCount = 2;
        $this->evaluacion->SearchOperators = ["=", "<>"];
        $this->Fields['evaluacion'] = &$this->evaluacion;

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
        if ($this->getCurrentDetailTable() == "sco_user_nota") {
            $detailUrl = Container("sco_user_nota")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nuser", $this->Nuser->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_user_adjunto") {
            $detailUrl = Container("sco_user_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nuser", $this->Nuser->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoUserList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_user";
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                $value = EncryptPassword(Config("CASE_SENSITIVE_PASSWORD") ? $value : strtolower($value));
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
            $this->Nuser->setDbValue($conn->lastInsertId());
            $rs['Nuser'] = $this->Nuser->DbValue;
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                if ($value == $this->Fields[$name]->OldValue) { // No need to update hashed password if not changed
                    continue;
                }
                $value = EncryptPassword(Config("CASE_SENSITIVE_PASSWORD") ? $value : strtolower($value));
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
        // Cascade Update detail table 'sco_user_nota'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nuser']) && $rsold['Nuser'] != $rs['Nuser'])) { // Update detail field 'user'
            $cascadeUpdate = true;
            $rscascade['user'] = $rs['Nuser'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_user_nota")->loadRs("`user` = " . QuotedValue($rsold['Nuser'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nuser_nota';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_user_nota")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_user_nota")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_user_nota")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Nuser']) && !EmptyValue($this->Nuser->CurrentValue)) {
                $rs['Nuser'] = $this->Nuser->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nuser';
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
            if (array_key_exists('Nuser', $rs)) {
                AddFilter($where, QuotedName('Nuser', $this->Dbid) . '=' . QuotedValue($rs['Nuser'], $this->Nuser->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_user_nota'
        $dtlrows = Container("sco_user_nota")->loadRs("`user` = " . QuotedValue($rs['Nuser'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_user_nota")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_user_nota")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_user_nota")->rowDeleted($dtlrow);
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
        $this->Nuser->DbValue = $row['Nuser'];
        $this->cedula->DbValue = $row['cedula'];
        $this->nombre->DbValue = $row['nombre'];
        $this->_username->DbValue = $row['username'];
        $this->_password->DbValue = $row['password'];
        $this->correo->DbValue = $row['correo'];
        $this->direccion->DbValue = $row['direccion'];
        $this->level->DbValue = $row['level'];
        $this->activo->DbValue = $row['activo'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->fecha_ingreso_cia->DbValue = $row['fecha_ingreso_cia'];
        $this->fecha_egreso_cia->DbValue = $row['fecha_egreso_cia'];
        $this->motivo_egreso->DbValue = $row['motivo_egreso'];
        $this->departamento->DbValue = $row['departamento'];
        $this->cargo->DbValue = $row['cargo'];
        $this->celular_1->DbValue = $row['celular_1'];
        $this->celular_2->DbValue = $row['celular_2'];
        $this->telefono_1->DbValue = $row['telefono_1'];
        $this->_email->DbValue = $row['email'];
        $this->hora_entrada->DbValue = $row['hora_entrada'];
        $this->hora_salida->DbValue = $row['hora_salida'];
        $this->proveedor->DbValue = $row['proveedor'];
        $this->seguro->DbValue = $row['seguro'];
        $this->level_cemantick->DbValue = $row['level_cemantick'];
        $this->evaluacion->DbValue = $row['evaluacion'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['foto']) ? [] : [$row['foto']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nuser` = @Nuser@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nuser->CurrentValue : $this->Nuser->OldValue;
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
                $this->Nuser->CurrentValue = $keys[0];
            } else {
                $this->Nuser->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nuser', $row) ? $row['Nuser'] : null;
        } else {
            $val = !EmptyValue($this->Nuser->OldValue) && !$current ? $this->Nuser->OldValue : $this->Nuser->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nuser@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoUserList");
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
            "ScoUserView" => $Language->phrase("View"),
            "ScoUserEdit" => $Language->phrase("Edit"),
            "ScoUserAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoUserList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoUserView",
            Config("API_ADD_ACTION") => "ScoUserAdd",
            Config("API_EDIT_ACTION") => "ScoUserEdit",
            Config("API_DELETE_ACTION") => "ScoUserDelete",
            Config("API_LIST_ACTION") => "ScoUserList",
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
        return "ScoUserList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoUserView", $parm);
        } else {
            $url = $this->keyUrl("ScoUserView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoUserAdd?" . $parm;
        } else {
            $url = "ScoUserAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoUserEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoUserEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoUserList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoUserAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoUserAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoUserList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoUserDelete", $parm);
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
        $json .= "\"Nuser\":" . VarToJson($this->Nuser->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nuser->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nuser->CurrentValue);
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
            if (($keyValue = Param("Nuser") ?? Route("Nuser")) !== null) {
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
                $this->Nuser->CurrentValue = $key;
            } else {
                $this->Nuser->OldValue = $key;
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
        $this->Nuser->setDbValue($row['Nuser']);
        $this->cedula->setDbValue($row['cedula']);
        $this->nombre->setDbValue($row['nombre']);
        $this->_username->setDbValue($row['username']);
        $this->_password->setDbValue($row['password']);
        $this->correo->setDbValue($row['correo']);
        $this->direccion->setDbValue($row['direccion']);
        $this->level->setDbValue($row['level']);
        $this->activo->setDbValue($row['activo']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->fecha_ingreso_cia->setDbValue($row['fecha_ingreso_cia']);
        $this->fecha_egreso_cia->setDbValue($row['fecha_egreso_cia']);
        $this->motivo_egreso->setDbValue($row['motivo_egreso']);
        $this->departamento->setDbValue($row['departamento']);
        $this->cargo->setDbValue($row['cargo']);
        $this->celular_1->setDbValue($row['celular_1']);
        $this->celular_2->setDbValue($row['celular_2']);
        $this->telefono_1->setDbValue($row['telefono_1']);
        $this->_email->setDbValue($row['email']);
        $this->hora_entrada->setDbValue($row['hora_entrada']);
        $this->hora_salida->setDbValue($row['hora_salida']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->seguro->setDbValue($row['seguro']);
        $this->level_cemantick->setDbValue($row['level_cemantick']);
        $this->evaluacion->setDbValue($row['evaluacion']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoUserList";
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

        // Nuser

        // cedula

        // nombre

        // username

        // password

        // correo

        // direccion

        // level

        // activo

        // foto

        // fecha_ingreso_cia

        // fecha_egreso_cia

        // motivo_egreso

        // departamento

        // cargo

        // celular_1

        // celular_2

        // telefono_1

        // email

        // hora_entrada

        // hora_salida

        // proveedor

        // seguro

        // level_cemantick

        // evaluacion

        // Nuser
        $this->Nuser->ViewValue = $this->Nuser->CurrentValue;

        // cedula
        $this->cedula->ViewValue = $this->cedula->CurrentValue;

        // nombre
        $this->nombre->ViewValue = $this->nombre->CurrentValue;

        // username
        $this->_username->ViewValue = $this->_username->CurrentValue;

        // password
        $this->_password->ViewValue = $Language->phrase("PasswordMask");

        // correo
        $this->correo->ViewValue = $this->correo->CurrentValue;

        // direccion
        $this->direccion->ViewValue = $this->direccion->CurrentValue;

        // level
        if ($Security->canAdmin()) { // System admin
            $curVal = strval($this->level->CurrentValue);
            if ($curVal != "") {
                $this->level->ViewValue = $this->level->lookupCacheOption($curVal);
                if ($this->level->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->level->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $curVal, $this->level->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                    $sqlWrk = $this->level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->level->Lookup->renderViewRow($rswrk[0]);
                        $this->level->ViewValue = $this->level->displayValue($arwrk);
                    } else {
                        $this->level->ViewValue = $this->level->CurrentValue;
                    }
                }
            } else {
                $this->level->ViewValue = null;
            }
        } else {
            $this->level->ViewValue = $Language->phrase("PasswordMask");
        }

        // activo
        if (strval($this->activo->CurrentValue) != "") {
            $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
        } else {
            $this->activo->ViewValue = null;
        }

        // foto
        if (!EmptyValue($this->foto->Upload->DbValue)) {
            $this->foto->ImageWidth = 120;
            $this->foto->ImageHeight = 120;
            $this->foto->ImageAlt = $this->foto->alt();
            $this->foto->ImageCssClass = "ew-image";
            $this->foto->ViewValue = $this->foto->Upload->DbValue;
        } else {
            $this->foto->ViewValue = "";
        }

        // fecha_ingreso_cia
        $this->fecha_ingreso_cia->ViewValue = $this->fecha_ingreso_cia->CurrentValue;
        $this->fecha_ingreso_cia->ViewValue = FormatDateTime($this->fecha_ingreso_cia->ViewValue, $this->fecha_ingreso_cia->formatPattern());

        // fecha_egreso_cia
        $this->fecha_egreso_cia->ViewValue = $this->fecha_egreso_cia->CurrentValue;
        $this->fecha_egreso_cia->ViewValue = FormatDateTime($this->fecha_egreso_cia->ViewValue, $this->fecha_egreso_cia->formatPattern());

        // motivo_egreso
        $curVal = strval($this->motivo_egreso->CurrentValue);
        if ($curVal != "") {
            $this->motivo_egreso->ViewValue = $this->motivo_egreso->lookupCacheOption($curVal);
            if ($this->motivo_egreso->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->motivo_egreso->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->motivo_egreso->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->motivo_egreso->getSelectFilter($this); // PHP
                $sqlWrk = $this->motivo_egreso->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->motivo_egreso->Lookup->renderViewRow($rswrk[0]);
                    $this->motivo_egreso->ViewValue = $this->motivo_egreso->displayValue($arwrk);
                } else {
                    $this->motivo_egreso->ViewValue = $this->motivo_egreso->CurrentValue;
                }
            }
        } else {
            $this->motivo_egreso->ViewValue = null;
        }

        // departamento
        $curVal = strval($this->departamento->CurrentValue);
        if ($curVal != "") {
            $this->departamento->ViewValue = $this->departamento->lookupCacheOption($curVal);
            if ($this->departamento->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->departamento->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->departamento->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->departamento->getSelectFilter($this); // PHP
                $sqlWrk = $this->departamento->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->departamento->Lookup->renderViewRow($rswrk[0]);
                    $this->departamento->ViewValue = $this->departamento->displayValue($arwrk);
                } else {
                    $this->departamento->ViewValue = $this->departamento->CurrentValue;
                }
            }
        } else {
            $this->departamento->ViewValue = null;
        }

        // cargo
        $curVal = strval($this->cargo->CurrentValue);
        if ($curVal != "") {
            $this->cargo->ViewValue = $this->cargo->lookupCacheOption($curVal);
            if ($this->cargo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->cargo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->cargo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->cargo->getSelectFilter($this); // PHP
                $sqlWrk = $this->cargo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cargo->Lookup->renderViewRow($rswrk[0]);
                    $this->cargo->ViewValue = $this->cargo->displayValue($arwrk);
                } else {
                    $this->cargo->ViewValue = $this->cargo->CurrentValue;
                }
            }
        } else {
            $this->cargo->ViewValue = null;
        }

        // celular_1
        $this->celular_1->ViewValue = $this->celular_1->CurrentValue;

        // celular_2
        $this->celular_2->ViewValue = $this->celular_2->CurrentValue;

        // telefono_1
        $this->telefono_1->ViewValue = $this->telefono_1->CurrentValue;

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // hora_entrada
        $this->hora_entrada->ViewValue = $this->hora_entrada->CurrentValue;

        // hora_salida
        $this->hora_salida->ViewValue = $this->hora_salida->CurrentValue;

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

        // seguro
        $curVal = strval($this->seguro->CurrentValue);
        if ($curVal != "") {
            $this->seguro->ViewValue = $this->seguro->lookupCacheOption($curVal);
            if ($this->seguro->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

        // level_cemantick
        $this->level_cemantick->ViewValue = $this->level_cemantick->CurrentValue;

        // evaluacion
        if (strval($this->evaluacion->CurrentValue) != "") {
            $this->evaluacion->ViewValue = $this->evaluacion->optionCaption($this->evaluacion->CurrentValue);
        } else {
            $this->evaluacion->ViewValue = null;
        }

        // Nuser
        $this->Nuser->HrefValue = "";
        $this->Nuser->TooltipValue = "";

        // cedula
        $this->cedula->HrefValue = "";
        $this->cedula->TooltipValue = "";

        // nombre
        $this->nombre->HrefValue = "";
        $this->nombre->TooltipValue = "";

        // username
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // password
        $this->_password->HrefValue = "";
        $this->_password->TooltipValue = "";

        // correo
        $this->correo->HrefValue = "";
        $this->correo->TooltipValue = "";

        // direccion
        $this->direccion->HrefValue = "";
        $this->direccion->TooltipValue = "";

        // level
        $this->level->HrefValue = "";
        $this->level->TooltipValue = "";

        // activo
        $this->activo->HrefValue = "";
        $this->activo->TooltipValue = "";

        // foto
        if (!EmptyValue($this->foto->Upload->DbValue)) {
            $this->foto->HrefValue = GetFileUploadUrl($this->foto, $this->foto->htmlDecode($this->foto->Upload->DbValue)); // Add prefix/suffix
            $this->foto->LinkAttrs["target"] = "_blank"; // Add target
            if ($this->isExport()) {
                $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
            }
        } else {
            $this->foto->HrefValue = "";
        }
        $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
        $this->foto->TooltipValue = "";
        if ($this->foto->UseColorbox) {
            if (EmptyValue($this->foto->TooltipValue)) {
                $this->foto->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->foto->LinkAttrs["data-rel"] = "sco_user_x_foto";
            $this->foto->LinkAttrs->appendClass("ew-lightbox");
        }

        // fecha_ingreso_cia
        $this->fecha_ingreso_cia->HrefValue = "";
        $this->fecha_ingreso_cia->TooltipValue = "";

        // fecha_egreso_cia
        $this->fecha_egreso_cia->HrefValue = "";
        $this->fecha_egreso_cia->TooltipValue = "";

        // motivo_egreso
        $this->motivo_egreso->HrefValue = "";
        $this->motivo_egreso->TooltipValue = "";

        // departamento
        $this->departamento->HrefValue = "";
        $this->departamento->TooltipValue = "";

        // cargo
        $this->cargo->HrefValue = "";
        $this->cargo->TooltipValue = "";

        // celular_1
        $this->celular_1->HrefValue = "";
        $this->celular_1->TooltipValue = "";

        // celular_2
        $this->celular_2->HrefValue = "";
        $this->celular_2->TooltipValue = "";

        // telefono_1
        $this->telefono_1->HrefValue = "";
        $this->telefono_1->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // hora_entrada
        $this->hora_entrada->HrefValue = "";
        $this->hora_entrada->TooltipValue = "";

        // hora_salida
        $this->hora_salida->HrefValue = "";
        $this->hora_salida->TooltipValue = "";

        // proveedor
        $this->proveedor->HrefValue = "";
        $this->proveedor->TooltipValue = "";

        // seguro
        $this->seguro->HrefValue = "";
        $this->seguro->TooltipValue = "";

        // level_cemantick
        $this->level_cemantick->HrefValue = "";
        $this->level_cemantick->TooltipValue = "";

        // evaluacion
        $this->evaluacion->HrefValue = "";
        $this->evaluacion->TooltipValue = "";

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

        // Nuser
        $this->Nuser->setupEditAttributes();
        $this->Nuser->EditValue = $this->Nuser->CurrentValue;

        // cedula
        $this->cedula->setupEditAttributes();
        if (!$this->cedula->Raw) {
            $this->cedula->CurrentValue = HtmlDecode($this->cedula->CurrentValue);
        }
        $this->cedula->EditValue = $this->cedula->CurrentValue;
        $this->cedula->PlaceHolder = RemoveHtml($this->cedula->caption());

        // nombre
        $this->nombre->setupEditAttributes();
        if (!$this->nombre->Raw) {
            $this->nombre->CurrentValue = HtmlDecode($this->nombre->CurrentValue);
        }
        $this->nombre->EditValue = $this->nombre->CurrentValue;
        $this->nombre->PlaceHolder = RemoveHtml($this->nombre->caption());

        // username
        $this->_username->setupEditAttributes();
        if (!$this->_username->Raw) {
            $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
        }
        $this->_username->EditValue = $this->_username->CurrentValue;
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // password
        $this->_password->setupEditAttributes();
        $this->_password->EditValue = $this->_password->CurrentValue;
        $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

        // correo
        $this->correo->setupEditAttributes();
        if (!$this->correo->Raw) {
            $this->correo->CurrentValue = HtmlDecode($this->correo->CurrentValue);
        }
        $this->correo->EditValue = $this->correo->CurrentValue;
        $this->correo->PlaceHolder = RemoveHtml($this->correo->caption());

        // direccion
        $this->direccion->setupEditAttributes();
        $this->direccion->EditValue = $this->direccion->CurrentValue;
        $this->direccion->PlaceHolder = RemoveHtml($this->direccion->caption());

        // level
        $this->level->setupEditAttributes();
        if (!$Security->canAdmin()) { // System admin
            $this->level->EditValue = $Language->phrase("PasswordMask");
        } else {
            $this->level->PlaceHolder = RemoveHtml($this->level->caption());
        }

        // activo
        $this->activo->setupEditAttributes();
        $this->activo->EditValue = $this->activo->options(true);
        $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

        // foto
        $this->foto->setupEditAttributes();
        if (!EmptyValue($this->foto->Upload->DbValue)) {
            $this->foto->ImageWidth = 120;
            $this->foto->ImageHeight = 120;
            $this->foto->ImageAlt = $this->foto->alt();
            $this->foto->ImageCssClass = "ew-image";
            $this->foto->EditValue = $this->foto->Upload->DbValue;
        } else {
            $this->foto->EditValue = "";
        }
        if (!EmptyValue($this->foto->CurrentValue)) {
            $this->foto->Upload->FileName = $this->foto->CurrentValue;
        }

        // fecha_ingreso_cia
        $this->fecha_ingreso_cia->setupEditAttributes();
        $this->fecha_ingreso_cia->EditValue = FormatDateTime($this->fecha_ingreso_cia->CurrentValue, $this->fecha_ingreso_cia->formatPattern());
        $this->fecha_ingreso_cia->PlaceHolder = RemoveHtml($this->fecha_ingreso_cia->caption());

        // fecha_egreso_cia
        $this->fecha_egreso_cia->setupEditAttributes();
        $this->fecha_egreso_cia->EditValue = FormatDateTime($this->fecha_egreso_cia->CurrentValue, $this->fecha_egreso_cia->formatPattern());
        $this->fecha_egreso_cia->PlaceHolder = RemoveHtml($this->fecha_egreso_cia->caption());

        // motivo_egreso
        $this->motivo_egreso->setupEditAttributes();
        $this->motivo_egreso->PlaceHolder = RemoveHtml($this->motivo_egreso->caption());

        // departamento
        $this->departamento->setupEditAttributes();
        $this->departamento->PlaceHolder = RemoveHtml($this->departamento->caption());

        // cargo
        $this->cargo->setupEditAttributes();
        $this->cargo->PlaceHolder = RemoveHtml($this->cargo->caption());

        // celular_1
        $this->celular_1->setupEditAttributes();
        if (!$this->celular_1->Raw) {
            $this->celular_1->CurrentValue = HtmlDecode($this->celular_1->CurrentValue);
        }
        $this->celular_1->EditValue = $this->celular_1->CurrentValue;
        $this->celular_1->PlaceHolder = RemoveHtml($this->celular_1->caption());

        // celular_2
        $this->celular_2->setupEditAttributes();
        if (!$this->celular_2->Raw) {
            $this->celular_2->CurrentValue = HtmlDecode($this->celular_2->CurrentValue);
        }
        $this->celular_2->EditValue = $this->celular_2->CurrentValue;
        $this->celular_2->PlaceHolder = RemoveHtml($this->celular_2->caption());

        // telefono_1
        $this->telefono_1->setupEditAttributes();
        if (!$this->telefono_1->Raw) {
            $this->telefono_1->CurrentValue = HtmlDecode($this->telefono_1->CurrentValue);
        }
        $this->telefono_1->EditValue = $this->telefono_1->CurrentValue;
        $this->telefono_1->PlaceHolder = RemoveHtml($this->telefono_1->caption());

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // hora_entrada
        $this->hora_entrada->setupEditAttributes();
        $this->hora_entrada->EditValue = $this->hora_entrada->CurrentValue;
        $this->hora_entrada->PlaceHolder = RemoveHtml($this->hora_entrada->caption());

        // hora_salida
        $this->hora_salida->setupEditAttributes();
        $this->hora_salida->EditValue = $this->hora_salida->CurrentValue;
        $this->hora_salida->PlaceHolder = RemoveHtml($this->hora_salida->caption());

        // proveedor
        $this->proveedor->setupEditAttributes();
        $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());

        // seguro
        $this->seguro->setupEditAttributes();
        $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());

        // level_cemantick
        $this->level_cemantick->setupEditAttributes();
        $this->level_cemantick->EditValue = $this->level_cemantick->CurrentValue;
        $this->level_cemantick->PlaceHolder = RemoveHtml($this->level_cemantick->caption());
        if (strval($this->level_cemantick->EditValue) != "" && is_numeric($this->level_cemantick->EditValue)) {
            $this->level_cemantick->EditValue = $this->level_cemantick->EditValue;
        }

        // evaluacion
        $this->evaluacion->setupEditAttributes();
        $this->evaluacion->EditValue = $this->evaluacion->options(true);
        $this->evaluacion->PlaceHolder = RemoveHtml($this->evaluacion->caption());

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
                    $doc->exportCaption($this->cedula);
                    $doc->exportCaption($this->nombre);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->correo);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->level);
                    $doc->exportCaption($this->activo);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->fecha_ingreso_cia);
                    $doc->exportCaption($this->fecha_egreso_cia);
                    $doc->exportCaption($this->motivo_egreso);
                    $doc->exportCaption($this->departamento);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->celular_1);
                    $doc->exportCaption($this->celular_2);
                    $doc->exportCaption($this->telefono_1);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->hora_entrada);
                    $doc->exportCaption($this->hora_salida);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->evaluacion);
                } else {
                    $doc->exportCaption($this->Nuser);
                    $doc->exportCaption($this->cedula);
                    $doc->exportCaption($this->nombre);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->correo);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->level);
                    $doc->exportCaption($this->activo);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->fecha_ingreso_cia);
                    $doc->exportCaption($this->fecha_egreso_cia);
                    $doc->exportCaption($this->motivo_egreso);
                    $doc->exportCaption($this->departamento);
                    $doc->exportCaption($this->cargo);
                    $doc->exportCaption($this->celular_1);
                    $doc->exportCaption($this->celular_2);
                    $doc->exportCaption($this->telefono_1);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->hora_entrada);
                    $doc->exportCaption($this->hora_salida);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->level_cemantick);
                    $doc->exportCaption($this->evaluacion);
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
                        $doc->exportField($this->cedula);
                        $doc->exportField($this->nombre);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->correo);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->level);
                        $doc->exportField($this->activo);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->fecha_ingreso_cia);
                        $doc->exportField($this->fecha_egreso_cia);
                        $doc->exportField($this->motivo_egreso);
                        $doc->exportField($this->departamento);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->celular_1);
                        $doc->exportField($this->celular_2);
                        $doc->exportField($this->telefono_1);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->hora_entrada);
                        $doc->exportField($this->hora_salida);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->evaluacion);
                    } else {
                        $doc->exportField($this->Nuser);
                        $doc->exportField($this->cedula);
                        $doc->exportField($this->nombre);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->correo);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->level);
                        $doc->exportField($this->activo);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->fecha_ingreso_cia);
                        $doc->exportField($this->fecha_egreso_cia);
                        $doc->exportField($this->motivo_egreso);
                        $doc->exportField($this->departamento);
                        $doc->exportField($this->cargo);
                        $doc->exportField($this->celular_1);
                        $doc->exportField($this->celular_2);
                        $doc->exportField($this->telefono_1);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->hora_entrada);
                        $doc->exportField($this->hora_salida);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->level_cemantick);
                        $doc->exportField($this->evaluacion);
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

    // Send register email
    public function sendRegisterEmail($row)
    {
        $userName = $row[Config("LOGIN_USERNAME_FIELD_NAME")];
        $user = FindUserByUserName($userName);
        $email = $this->prepareRegisterEmail($user);
        $args = ["rs" => $row];
        $emailSent = false;
        if ($this->emailSending($email, $args)) { // Use Email_Sending server event of user table
            $emailSent = $email->send();
        }
        return $emailSent;
    }

    // Get activate link
    public function getActivateLink($username, $email)
    {
        return FullUrl("register", "activate") . "?action=confirm&user=" . urlencode($username) .
            "&token=" . CreateJwt(["username" => $username], Config("ACTIVATE_LINK_EXPIRY_TIME"));
    }

    // Prepare register email
    public function prepareRegisterEmail($user, $langId = "")
    {
        global $CurrentForm;
        $username = $user->get(Config("LOGIN_USERNAME_FIELD_NAME"));
        $emailAddress = $user->get(Config("USER_EMAIL_FIELD_NAME")) ?: Config("RECIPIENT_EMAIL"); // Send to recipient directly if no email address
        $fields = [
            'nombre' => (object)[ "caption" => $this->nombre->caption(), "value" => $user->get('nombre') ],
            'username' => (object)[ "caption" => $this->_username->caption(), "value" => $user->get('username') ],
            'correo' => (object)[ "caption" => $this->correo->caption(), "value" => $user->get('correo') ],
        ];
        $email = new Email();
        $data = [
            'From' => Config("SENDER_EMAIL"), // Replace Sender
            'To' => $emailAddress, // Replace Recipient
            'Fields' => $fields,
            'nombre' => $fields['nombre'],
            'username' => $fields['username'],
            'correo' => $fields['correo'],
        ];
        if (Config("REGISTER_ACTIVATE") && !EmptyValue(Config("REGISTER_ACTIVATE_FIELD_NAME"))) {
            $data['ActivateLink'] = $this->getActivateLink($username, $emailAddress);
        }
        $email->load(Config("EMAIL_REGISTER_TEMPLATE"), $langId, $data);

        // Add Bcc
        if (!SameText($emailAddress, Config("RECIPIENT_EMAIL"))) {
            $email->addBcc(Config("RECIPIENT_EMAIL"));
        }
        return $email;
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'foto') {
            $fldName = "foto";
            $fileNameFld = "foto";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->Nuser->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DataType::BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower($pathinfo["extension"] ?? "");
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment" . ($DownloadFileName ? "; filename=\"" . $DownloadFileName . "\"" : ""));
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    if ($fld->hasMethod("getUploadPath")) { // Check field level upload path
                        $fld->UploadPath = $fld->getUploadPath();
                    }
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Write audit trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_user');
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
        $key .= $rs['Nuser'];

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
                if ($fldname == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                    $newvalue = $Language->phrase("PasswordMask");
                }
                WriteAuditLog($usr, "A", 'sco_user', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nuser'];

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
                    if ($fldname == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                        $oldvalue = $Language->phrase("PasswordMask");
                        $newvalue = $Language->phrase("PasswordMask");
                    }
                    WriteAuditLog($usr, "U", 'sco_user', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nuser'];

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
                if ($fldname == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                    $oldvalue = $Language->phrase("PasswordMask");
                }
                WriteAuditLog($usr, "D", 'sco_user', $fldname, $key, $oldvalue);
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
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	$sql = "SELECT cedula FROM sco_user WHERE cedula = '" . trim($rsnew["cedula"]) . "';";
    	$cedula = trim(ExecuteScalar($sql));
    	if($cedula !=  "") {
    		$this->CancelMessage = "C&eacute;dula de Identidad ya est&aacute; registrada.";
    		return FALSE;
    	}
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
    	if($rsold["cedula"] != $rsnew["cedula"]) {
    		$sql = "SELECT cedula FROM sco_user WHERE cedula = '" . trim($rsnew["cedula"]) . "';";
    		$cedula = trim(ExecuteScalar($sql));
    		if($cedula !=  "") {
    			$this->CancelMessage = "C&eacute;dula de Identidad ya est&aacute; registrada.";
    			return FALSE;
    		}
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
    	if ($this->activo->CurrentValue == 0)
    		$this->RowAttrs["class"] = "danger";
    	else
    		$this->RowAttrs["class"] = "";
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
