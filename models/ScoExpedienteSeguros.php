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
 * Table class for sco_expediente_seguros
 */
class ScoExpedienteSeguros extends DbTable
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
    public $Nexpediente_seguros;
    public $seguro;
    public $nombre_contacto;
    public $parentesco_contacto;
    public $telefono_contacto1;
    public $telefono_contacto2;
    public $_email;
    public $cedula_fallecido;
    public $nombre_fallecido;
    public $apellidos_fallecido;
    public $sexo;
    public $fecha_nacimiento;
    public $edad_fallecido;
    public $estado_civil;
    public $lugar_nacimiento_fallecido;
    public $lugar_ocurrencia;
    public $direccion_ocurrencia;
    public $fecha_ocurrencia;
    public $hora_ocurrencia;
    public $causa_ocurrencia;
    public $causa_otro;
    public $descripcion_ocurrencia;
    public $nota;
    public $user_registra;
    public $fecha_registro;
    public $expediente;
    public $religion;
    public $servicio_tipo;
    public $servicio;
    public $estatus;
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
        $this->TableVar = "sco_expediente_seguros";
        $this->TableName = 'sco_expediente_seguros';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_expediente_seguros";
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

        // Nexpediente_seguros
        $this->Nexpediente_seguros = new DbField(
            $this, // Table
            'x_Nexpediente_seguros', // Variable name
            'Nexpediente_seguros', // Name
            '`Nexpediente_seguros`', // Expression
            '`Nexpediente_seguros`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nexpediente_seguros`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nexpediente_seguros->InputTextType = "text";
        $this->Nexpediente_seguros->Raw = true;
        $this->Nexpediente_seguros->IsAutoIncrement = true; // Autoincrement field
        $this->Nexpediente_seguros->IsPrimaryKey = true; // Primary key field
        $this->Nexpediente_seguros->IsForeignKey = true; // Foreign key field
        $this->Nexpediente_seguros->Nullable = false; // NOT NULL field
        $this->Nexpediente_seguros->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nexpediente_seguros->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nexpediente_seguros'] = &$this->Nexpediente_seguros;

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
        $this->seguro->Nullable = false; // NOT NULL field
        $this->seguro->Required = true; // Required field
        $this->seguro->setSelectMultiple(false); // Select one
        $this->seguro->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->seguro->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->seguro->Lookup = new Lookup($this->seguro, 'sco_seguro', false, 'Nseguro', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->seguro->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->seguro->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['seguro'] = &$this->seguro;

        // nombre_contacto
        $this->nombre_contacto = new DbField(
            $this, // Table
            'x_nombre_contacto', // Variable name
            'nombre_contacto', // Name
            '`nombre_contacto`', // Expression
            '`nombre_contacto`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_contacto->InputTextType = "text";
        $this->nombre_contacto->Nullable = false; // NOT NULL field
        $this->nombre_contacto->Required = true; // Required field
        $this->nombre_contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['nombre_contacto'] = &$this->nombre_contacto;

        // parentesco_contacto
        $this->parentesco_contacto = new DbField(
            $this, // Table
            'x_parentesco_contacto', // Variable name
            'parentesco_contacto', // Name
            '`parentesco_contacto`', // Expression
            '`parentesco_contacto`', // Basic search expression
            200, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`parentesco_contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->parentesco_contacto->addMethod("getSelectFilter", fn() => "`tabla` = 'PARENTESCOS'");
        $this->parentesco_contacto->InputTextType = "text";
        $this->parentesco_contacto->Nullable = false; // NOT NULL field
        $this->parentesco_contacto->Required = true; // Required field
        $this->parentesco_contacto->setSelectMultiple(false); // Select one
        $this->parentesco_contacto->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->parentesco_contacto->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->parentesco_contacto->Lookup = new Lookup($this->parentesco_contacto, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
        $this->parentesco_contacto->SearchOperators = ["=", "<>"];
        $this->Fields['parentesco_contacto'] = &$this->parentesco_contacto;

        // telefono_contacto1
        $this->telefono_contacto1 = new DbField(
            $this, // Table
            'x_telefono_contacto1', // Variable name
            'telefono_contacto1', // Name
            '`telefono_contacto1`', // Expression
            '`telefono_contacto1`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono_contacto1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono_contacto1->InputTextType = "text";
        $this->telefono_contacto1->Nullable = false; // NOT NULL field
        $this->telefono_contacto1->Required = true; // Required field
        $this->telefono_contacto1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['telefono_contacto1'] = &$this->telefono_contacto1;

        // telefono_contacto2
        $this->telefono_contacto2 = new DbField(
            $this, // Table
            'x_telefono_contacto2', // Variable name
            'telefono_contacto2', // Name
            '`telefono_contacto2`', // Expression
            '`telefono_contacto2`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono_contacto2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono_contacto2->InputTextType = "text";
        $this->telefono_contacto2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono_contacto2'] = &$this->telefono_contacto2;

        // email
        $this->_email = new DbField(
            $this, // Table
            'x__email', // Variable name
            'email', // Name
            '`email`', // Expression
            '`email`', // Basic search expression
            200, // Type
            100, // Size
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

        // cedula_fallecido
        $this->cedula_fallecido = new DbField(
            $this, // Table
            'x_cedula_fallecido', // Variable name
            'cedula_fallecido', // Name
            '`cedula_fallecido`', // Expression
            '`cedula_fallecido`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula_fallecido->InputTextType = "text";
        $this->cedula_fallecido->Required = true; // Required field
        $this->cedula_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula_fallecido'] = &$this->cedula_fallecido;

        // nombre_fallecido
        $this->nombre_fallecido = new DbField(
            $this, // Table
            'x_nombre_fallecido', // Variable name
            'nombre_fallecido', // Name
            '`nombre_fallecido`', // Expression
            '`nombre_fallecido`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_fallecido->InputTextType = "text";
        $this->nombre_fallecido->Required = true; // Required field
        $this->nombre_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_fallecido'] = &$this->nombre_fallecido;

        // apellidos_fallecido
        $this->apellidos_fallecido = new DbField(
            $this, // Table
            'x_apellidos_fallecido', // Variable name
            'apellidos_fallecido', // Name
            '`apellidos_fallecido`', // Expression
            '`apellidos_fallecido`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`apellidos_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->apellidos_fallecido->InputTextType = "text";
        $this->apellidos_fallecido->Required = true; // Required field
        $this->apellidos_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['apellidos_fallecido'] = &$this->apellidos_fallecido;

        // sexo
        $this->sexo = new DbField(
            $this, // Table
            'x_sexo', // Variable name
            'sexo', // Name
            '`sexo`', // Expression
            '`sexo`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sexo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->sexo->addMethod("getSelectFilter", fn() => "`tabla` = 'SEXO'");
        $this->sexo->InputTextType = "text";
        $this->sexo->Required = true; // Required field
        $this->sexo->setSelectMultiple(false); // Select one
        $this->sexo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->sexo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->sexo->Lookup = new Lookup($this->sexo, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
        $this->sexo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['sexo'] = &$this->sexo;

        // fecha_nacimiento
        $this->fecha_nacimiento = new DbField(
            $this, // Table
            'x_fecha_nacimiento', // Variable name
            'fecha_nacimiento', // Name
            '`fecha_nacimiento`', // Expression
            CastDateFieldForLike("`fecha_nacimiento`", 0, "DB"), // Basic search expression
            133, // Type
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
        $this->fecha_nacimiento->Raw = true;
        $this->fecha_nacimiento->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_nacimiento->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_nacimiento'] = &$this->fecha_nacimiento;

        // edad_fallecido
        $this->edad_fallecido = new DbField(
            $this, // Table
            'x_edad_fallecido', // Variable name
            'edad_fallecido', // Name
            '`edad_fallecido`', // Expression
            '`edad_fallecido`', // Basic search expression
            18, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`edad_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->edad_fallecido->InputTextType = "text";
        $this->edad_fallecido->Raw = true;
        $this->edad_fallecido->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->edad_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['edad_fallecido'] = &$this->edad_fallecido;

        // estado_civil
        $this->estado_civil = new DbField(
            $this, // Table
            'x_estado_civil', // Variable name
            'estado_civil', // Name
            '`estado_civil`', // Expression
            '`estado_civil`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estado_civil`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->estado_civil->addMethod("getSelectFilter", fn() => "`tabla` = 'ESTADO CIVIL'");
        $this->estado_civil->InputTextType = "text";
        $this->estado_civil->setSelectMultiple(false); // Select one
        $this->estado_civil->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estado_civil->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estado_civil->Lookup = new Lookup($this->estado_civil, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
        $this->estado_civil->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estado_civil'] = &$this->estado_civil;

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido = new DbField(
            $this, // Table
            'x_lugar_nacimiento_fallecido', // Variable name
            'lugar_nacimiento_fallecido', // Name
            '`lugar_nacimiento_fallecido`', // Expression
            '`lugar_nacimiento_fallecido`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`lugar_nacimiento_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->lugar_nacimiento_fallecido->InputTextType = "text";
        $this->lugar_nacimiento_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['lugar_nacimiento_fallecido'] = &$this->lugar_nacimiento_fallecido;

        // lugar_ocurrencia
        $this->lugar_ocurrencia = new DbField(
            $this, // Table
            'x_lugar_ocurrencia', // Variable name
            'lugar_ocurrencia', // Name
            '`lugar_ocurrencia`', // Expression
            '`lugar_ocurrencia`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`lugar_ocurrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->lugar_ocurrencia->addMethod("getSelectFilter", fn() => "`tabla` in ('UBICACION','DESTINO','LUGARES')");
        $this->lugar_ocurrencia->InputTextType = "text";
        $this->lugar_ocurrencia->Required = true; // Required field
        $this->lugar_ocurrencia->setSelectMultiple(false); // Select one
        $this->lugar_ocurrencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->lugar_ocurrencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->lugar_ocurrencia->Lookup = new Lookup($this->lugar_ocurrencia, 'sco_tabla', true, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
        $this->lugar_ocurrencia->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['lugar_ocurrencia'] = &$this->lugar_ocurrencia;

        // direccion_ocurrencia
        $this->direccion_ocurrencia = new DbField(
            $this, // Table
            'x_direccion_ocurrencia', // Variable name
            'direccion_ocurrencia', // Name
            '`direccion_ocurrencia`', // Expression
            '`direccion_ocurrencia`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`direccion_ocurrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->direccion_ocurrencia->InputTextType = "text";
        $this->direccion_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direccion_ocurrencia'] = &$this->direccion_ocurrencia;

        // fecha_ocurrencia
        $this->fecha_ocurrencia = new DbField(
            $this, // Table
            'x_fecha_ocurrencia', // Variable name
            'fecha_ocurrencia', // Name
            '`fecha_ocurrencia`', // Expression
            CastDateFieldForLike("`fecha_ocurrencia`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_ocurrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_ocurrencia->InputTextType = "text";
        $this->fecha_ocurrencia->Raw = true;
        $this->fecha_ocurrencia->Required = true; // Required field
        $this->fecha_ocurrencia->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_ocurrencia'] = &$this->fecha_ocurrencia;

        // hora_ocurrencia
        $this->hora_ocurrencia = new DbField(
            $this, // Table
            'x_hora_ocurrencia', // Variable name
            'hora_ocurrencia', // Name
            '`hora_ocurrencia`', // Expression
            CastDateFieldForLike("`hora_ocurrencia`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_ocurrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_ocurrencia->InputTextType = "text";
        $this->hora_ocurrencia->Raw = true;
        $this->hora_ocurrencia->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_ocurrencia'] = &$this->hora_ocurrencia;

        // causa_ocurrencia
        $this->causa_ocurrencia = new DbField(
            $this, // Table
            'x_causa_ocurrencia', // Variable name
            'causa_ocurrencia', // Name
            '`causa_ocurrencia`', // Expression
            '`causa_ocurrencia`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`causa_ocurrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->causa_ocurrencia->addMethod("getSelectFilter", fn() => "`tabla` in ('CAUSAS')");
        $this->causa_ocurrencia->InputTextType = "text";
        $this->causa_ocurrencia->Required = true; // Required field
        $this->causa_ocurrencia->setSelectMultiple(false); // Select one
        $this->causa_ocurrencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->causa_ocurrencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->causa_ocurrencia->Lookup = new Lookup($this->causa_ocurrencia, 'sco_tabla', true, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
        $this->causa_ocurrencia->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['causa_ocurrencia'] = &$this->causa_ocurrencia;

        // causa_otro
        $this->causa_otro = new DbField(
            $this, // Table
            'x_causa_otro', // Variable name
            'causa_otro', // Name
            '`causa_otro`', // Expression
            '`causa_otro`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`causa_otro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->causa_otro->InputTextType = "text";
        $this->causa_otro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['causa_otro'] = &$this->causa_otro;

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia = new DbField(
            $this, // Table
            'x_descripcion_ocurrencia', // Variable name
            'descripcion_ocurrencia', // Name
            '`descripcion_ocurrencia`', // Expression
            '`descripcion_ocurrencia`', // Basic search expression
            200, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`descripcion_ocurrencia`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->descripcion_ocurrencia->InputTextType = "text";
        $this->descripcion_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['descripcion_ocurrencia'] = &$this->descripcion_ocurrencia;

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

        // user_registra
        $this->user_registra = new DbField(
            $this, // Table
            'x_user_registra', // Variable name
            'user_registra', // Name
            '`user_registra`', // Expression
            '`user_registra`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`user_registra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->user_registra->addMethod("getAutoUpdateValue", fn() => CurrentUserName());
        $this->user_registra->InputTextType = "text";
        $this->user_registra->setSelectMultiple(false); // Select one
        $this->user_registra->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->user_registra->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->user_registra->Lookup = new Lookup($this->user_registra, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->user_registra->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_registra'] = &$this->user_registra;

        // fecha_registro
        $this->fecha_registro = new DbField(
            $this, // Table
            'x_fecha_registro', // Variable name
            'fecha_registro', // Name
            '`fecha_registro`', // Expression
            CastDateFieldForLike("`fecha_registro`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`fecha_registro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_registro->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->fecha_registro->InputTextType = "text";
        $this->fecha_registro->Raw = true;
        $this->fecha_registro->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->fecha_registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_registro'] = &$this->fecha_registro;

        // expediente
        $this->expediente = new DbField(
            $this, // Table
            'x_expediente', // Variable name
            'expediente', // Name
            '`expediente`', // Expression
            '`expediente`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`expediente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->expediente->addMethod("getDefault", fn() => 0);
        $this->expediente->InputTextType = "text";
        $this->expediente->Raw = true;
        $this->expediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->expediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['expediente'] = &$this->expediente;

        // religion
        $this->religion = new DbField(
            $this, // Table
            'x_religion', // Variable name
            'religion', // Name
            '`religion`', // Expression
            '`religion`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`religion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->religion->addMethod("getSelectFilter", fn() => "`codigo` = '012'");
        $this->religion->addMethod("getDefault", fn() => "0");
        $this->religion->InputTextType = "text";
        $this->religion->setSelectMultiple(false); // Select one
        $this->religion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->religion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->religion->Lookup = new Lookup($this->religion, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->religion->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['religion'] = &$this->religion;

        // servicio_tipo
        $this->servicio_tipo = new DbField(
            $this, // Table
            'x_servicio_tipo', // Variable name
            'servicio_tipo', // Name
            '`servicio_tipo`', // Expression
            '`servicio_tipo`', // Basic search expression
            129, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicio_tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->servicio_tipo->addMethod("getSelectFilter", fn() => "`Nservicio_tipo` IN ('CREM','SEPE')");
        $this->servicio_tipo->InputTextType = "text";
        $this->servicio_tipo->Required = true; // Required field
        $this->servicio_tipo->setSelectMultiple(false); // Select one
        $this->servicio_tipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio_tipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio_tipo->Lookup = new Lookup($this->servicio_tipo, 'sco_servicio_tipo', false, 'Nservicio_tipo', ["nombre","","",""], '', '', [], ["x_servicio"], [], [], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->servicio_tipo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio_tipo'] = &$this->servicio_tipo;

        // servicio
        $this->servicio = new DbField(
            $this, // Table
            'x_servicio', // Variable name
            'servicio', // Name
            '`servicio`', // Expression
            '`servicio`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->servicio->addMethod("getSelectFilter", fn() => "`activo` = 'S'");
        $this->servicio->InputTextType = "text";
        $this->servicio->Required = true; // Required field
        $this->servicio->setSelectMultiple(false); // Select one
        $this->servicio->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio->Lookup = new Lookup($this->servicio, 'sco_servicio', false, 'Nservicio', ["nombre","","",""], '', '', ["x_servicio_tipo"], [], ["tipo"], ["x_tipo"], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->servicio->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio'] = &$this->servicio;

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            16, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estatus`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->estatus->InputTextType = "text";
        $this->estatus->Raw = true;
        $this->estatus->Required = true; // Required field
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_expediente_seguros', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->estatus->OptionCount = 2;
        $this->estatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estatus->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

        // funeraria
        $this->funeraria = new DbField(
            $this, // Table
            'x_funeraria', // Variable name
            'funeraria', // Name
            '`funeraria`', // Expression
            '`funeraria`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`funeraria`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->funeraria->InputTextType = "text";
        $this->funeraria->Raw = true;
        $this->funeraria->setSelectMultiple(false); // Select one
        $this->funeraria->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->funeraria->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->funeraria->Lookup = new Lookup($this->funeraria, 'sco_expediente_seguros', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->funeraria->OptionCount = 3;
        $this->funeraria->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->funeraria->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
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
        if ($this->getCurrentDetailTable() == "sco_expediente_seguros_adjunto") {
            $detailUrl = Container("sco_expediente_seguros_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente_seguros", $this->Nexpediente_seguros->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoExpedienteSegurosList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_expediente_seguros";
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
            $this->Nexpediente_seguros->setDbValue($conn->lastInsertId());
            $rs['Nexpediente_seguros'] = $this->Nexpediente_seguros->DbValue;
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
        // Cascade Update detail table 'sco_expediente_seguros_adjunto'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nexpediente_seguros']) && $rsold['Nexpediente_seguros'] != $rs['Nexpediente_seguros'])) { // Update detail field 'expediente_seguros'
            $cascadeUpdate = true;
            $rscascade['expediente_seguros'] = $rs['Nexpediente_seguros'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_expediente_seguros_adjunto")->loadRs("`expediente_seguros` = " . QuotedValue($rsold['Nexpediente_seguros'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nexpediente_seguros_adjunto';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_expediente_seguros_adjunto")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_expediente_seguros_adjunto")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_expediente_seguros_adjunto")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Nexpediente_seguros']) && !EmptyValue($this->Nexpediente_seguros->CurrentValue)) {
                $rs['Nexpediente_seguros'] = $this->Nexpediente_seguros->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nexpediente_seguros';
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
            if (array_key_exists('Nexpediente_seguros', $rs)) {
                AddFilter($where, QuotedName('Nexpediente_seguros', $this->Dbid) . '=' . QuotedValue($rs['Nexpediente_seguros'], $this->Nexpediente_seguros->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_expediente_seguros_adjunto'
        $dtlrows = Container("sco_expediente_seguros_adjunto")->loadRs("`expediente_seguros` = " . QuotedValue($rs['Nexpediente_seguros'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_expediente_seguros_adjunto")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_expediente_seguros_adjunto")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_expediente_seguros_adjunto")->rowDeleted($dtlrow);
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
        $this->Nexpediente_seguros->DbValue = $row['Nexpediente_seguros'];
        $this->seguro->DbValue = $row['seguro'];
        $this->nombre_contacto->DbValue = $row['nombre_contacto'];
        $this->parentesco_contacto->DbValue = $row['parentesco_contacto'];
        $this->telefono_contacto1->DbValue = $row['telefono_contacto1'];
        $this->telefono_contacto2->DbValue = $row['telefono_contacto2'];
        $this->_email->DbValue = $row['email'];
        $this->cedula_fallecido->DbValue = $row['cedula_fallecido'];
        $this->nombre_fallecido->DbValue = $row['nombre_fallecido'];
        $this->apellidos_fallecido->DbValue = $row['apellidos_fallecido'];
        $this->sexo->DbValue = $row['sexo'];
        $this->fecha_nacimiento->DbValue = $row['fecha_nacimiento'];
        $this->edad_fallecido->DbValue = $row['edad_fallecido'];
        $this->estado_civil->DbValue = $row['estado_civil'];
        $this->lugar_nacimiento_fallecido->DbValue = $row['lugar_nacimiento_fallecido'];
        $this->lugar_ocurrencia->DbValue = $row['lugar_ocurrencia'];
        $this->direccion_ocurrencia->DbValue = $row['direccion_ocurrencia'];
        $this->fecha_ocurrencia->DbValue = $row['fecha_ocurrencia'];
        $this->hora_ocurrencia->DbValue = $row['hora_ocurrencia'];
        $this->causa_ocurrencia->DbValue = $row['causa_ocurrencia'];
        $this->causa_otro->DbValue = $row['causa_otro'];
        $this->descripcion_ocurrencia->DbValue = $row['descripcion_ocurrencia'];
        $this->nota->DbValue = $row['nota'];
        $this->user_registra->DbValue = $row['user_registra'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->expediente->DbValue = $row['expediente'];
        $this->religion->DbValue = $row['religion'];
        $this->servicio_tipo->DbValue = $row['servicio_tipo'];
        $this->servicio->DbValue = $row['servicio'];
        $this->estatus->DbValue = $row['estatus'];
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
        return "`Nexpediente_seguros` = @Nexpediente_seguros@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nexpediente_seguros->CurrentValue : $this->Nexpediente_seguros->OldValue;
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
                $this->Nexpediente_seguros->CurrentValue = $keys[0];
            } else {
                $this->Nexpediente_seguros->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nexpediente_seguros', $row) ? $row['Nexpediente_seguros'] : null;
        } else {
            $val = !EmptyValue($this->Nexpediente_seguros->OldValue) && !$current ? $this->Nexpediente_seguros->OldValue : $this->Nexpediente_seguros->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nexpediente_seguros@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoExpedienteSegurosList");
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
            "ScoExpedienteSegurosView" => $Language->phrase("View"),
            "ScoExpedienteSegurosEdit" => $Language->phrase("Edit"),
            "ScoExpedienteSegurosAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoExpedienteSegurosList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoExpedienteSegurosView",
            Config("API_ADD_ACTION") => "ScoExpedienteSegurosAdd",
            Config("API_EDIT_ACTION") => "ScoExpedienteSegurosEdit",
            Config("API_DELETE_ACTION") => "ScoExpedienteSegurosDelete",
            Config("API_LIST_ACTION") => "ScoExpedienteSegurosList",
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
        return "ScoExpedienteSegurosList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteSegurosView", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteSegurosView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoExpedienteSegurosAdd?" . $parm;
        } else {
            $url = "ScoExpedienteSegurosAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteSegurosEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteSegurosEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoExpedienteSegurosList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteSegurosAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteSegurosAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoExpedienteSegurosList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoExpedienteSegurosDelete", $parm);
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
        $json .= "\"Nexpediente_seguros\":" . VarToJson($this->Nexpediente_seguros->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nexpediente_seguros->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nexpediente_seguros->CurrentValue);
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
            if (($keyValue = Param("Nexpediente_seguros") ?? Route("Nexpediente_seguros")) !== null) {
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
                $this->Nexpediente_seguros->CurrentValue = $key;
            } else {
                $this->Nexpediente_seguros->OldValue = $key;
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
        $this->Nexpediente_seguros->setDbValue($row['Nexpediente_seguros']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->_email->setDbValue($row['email']);
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
        $this->nota->setDbValue($row['nota']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->expediente->setDbValue($row['expediente']);
        $this->religion->setDbValue($row['religion']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->estatus->setDbValue($row['estatus']);
        $this->funeraria->setDbValue($row['funeraria']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoExpedienteSegurosList";
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

        // Nexpediente_seguros

        // seguro

        // nombre_contacto

        // parentesco_contacto

        // telefono_contacto1

        // telefono_contacto2

        // email

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

        // nota

        // user_registra

        // fecha_registro

        // expediente

        // religion

        // servicio_tipo

        // servicio

        // estatus

        // funeraria

        // Nexpediente_seguros
        $this->Nexpediente_seguros->ViewValue = $this->Nexpediente_seguros->CurrentValue;

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

        // nombre_contacto
        $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

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

        // cedula_fallecido
        $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

        // nombre_fallecido
        $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

        // apellidos_fallecido
        $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

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
                $lookupFilter = $this->estado_civil->getSelectFilter($this); // PHP
                $sqlWrk = $this->estado_civil->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;

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

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->ViewValue = $this->descripcion_ocurrencia->CurrentValue;

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // user_registra
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

        // expediente
        $this->expediente->ViewValue = $this->expediente->CurrentValue;

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

        // estatus
        if (strval($this->estatus->CurrentValue) != "") {
            $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
        } else {
            $this->estatus->ViewValue = null;
        }

        // funeraria
        if (strval($this->funeraria->CurrentValue) != "") {
            $this->funeraria->ViewValue = $this->funeraria->optionCaption($this->funeraria->CurrentValue);
        } else {
            $this->funeraria->ViewValue = null;
        }

        // Nexpediente_seguros
        $this->Nexpediente_seguros->HrefValue = "";
        $this->Nexpediente_seguros->TooltipValue = "";

        // seguro
        $this->seguro->HrefValue = "";
        $this->seguro->TooltipValue = "";

        // nombre_contacto
        $this->nombre_contacto->HrefValue = "";
        $this->nombre_contacto->TooltipValue = "";

        // parentesco_contacto
        $this->parentesco_contacto->HrefValue = "";
        $this->parentesco_contacto->TooltipValue = "";

        // telefono_contacto1
        $this->telefono_contacto1->HrefValue = "";
        $this->telefono_contacto1->TooltipValue = "";

        // telefono_contacto2
        $this->telefono_contacto2->HrefValue = "";
        $this->telefono_contacto2->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // cedula_fallecido
        $this->cedula_fallecido->HrefValue = "";
        $this->cedula_fallecido->TooltipValue = "";

        // nombre_fallecido
        $this->nombre_fallecido->HrefValue = "";
        $this->nombre_fallecido->TooltipValue = "";

        // apellidos_fallecido
        $this->apellidos_fallecido->HrefValue = "";
        $this->apellidos_fallecido->TooltipValue = "";

        // sexo
        $this->sexo->HrefValue = "";
        $this->sexo->TooltipValue = "";

        // fecha_nacimiento
        $this->fecha_nacimiento->HrefValue = "";
        $this->fecha_nacimiento->TooltipValue = "";

        // edad_fallecido
        $this->edad_fallecido->HrefValue = "";
        $this->edad_fallecido->TooltipValue = "";

        // estado_civil
        $this->estado_civil->HrefValue = "";
        $this->estado_civil->TooltipValue = "";

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->HrefValue = "";
        $this->lugar_nacimiento_fallecido->TooltipValue = "";

        // lugar_ocurrencia
        $this->lugar_ocurrencia->HrefValue = "";
        $this->lugar_ocurrencia->TooltipValue = "";

        // direccion_ocurrencia
        $this->direccion_ocurrencia->HrefValue = "";
        $this->direccion_ocurrencia->TooltipValue = "";

        // fecha_ocurrencia
        $this->fecha_ocurrencia->HrefValue = "";
        $this->fecha_ocurrencia->TooltipValue = "";

        // hora_ocurrencia
        $this->hora_ocurrencia->HrefValue = "";
        $this->hora_ocurrencia->TooltipValue = "";

        // causa_ocurrencia
        $this->causa_ocurrencia->HrefValue = "";
        $this->causa_ocurrencia->TooltipValue = "";

        // causa_otro
        $this->causa_otro->HrefValue = "";
        $this->causa_otro->TooltipValue = "";

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->HrefValue = "";
        $this->descripcion_ocurrencia->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // user_registra
        $this->user_registra->HrefValue = "";
        $this->user_registra->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // expediente
        $this->expediente->HrefValue = "";
        $this->expediente->TooltipValue = "";

        // religion
        $this->religion->HrefValue = "";
        $this->religion->TooltipValue = "";

        // servicio_tipo
        $this->servicio_tipo->HrefValue = "";
        $this->servicio_tipo->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

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

        // Nexpediente_seguros
        $this->Nexpediente_seguros->setupEditAttributes();
        $this->Nexpediente_seguros->EditValue = $this->Nexpediente_seguros->CurrentValue;

        // seguro
        $this->seguro->setupEditAttributes();
        $curVal = strval($this->seguro->CurrentValue);
        if ($curVal != "") {
            $this->seguro->EditValue = $this->seguro->lookupCacheOption($curVal);
            if ($this->seguro->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchExpression(), "=", $curVal, $this->seguro->Lookup->getTable()->Fields["Nseguro"]->searchDataType(), "");
                $sqlWrk = $this->seguro->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->seguro->Lookup->renderViewRow($rswrk[0]);
                    $this->seguro->EditValue = $this->seguro->displayValue($arwrk);
                } else {
                    $this->seguro->EditValue = $this->seguro->CurrentValue;
                }
            }
        } else {
            $this->seguro->EditValue = null;
        }

        // nombre_contacto
        $this->nombre_contacto->setupEditAttributes();
        if (!$this->nombre_contacto->Raw) {
            $this->nombre_contacto->CurrentValue = HtmlDecode($this->nombre_contacto->CurrentValue);
        }
        $this->nombre_contacto->EditValue = $this->nombre_contacto->CurrentValue;
        $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

        // parentesco_contacto
        $this->parentesco_contacto->setupEditAttributes();
        $this->parentesco_contacto->PlaceHolder = RemoveHtml($this->parentesco_contacto->caption());

        // telefono_contacto1
        $this->telefono_contacto1->setupEditAttributes();
        if (!$this->telefono_contacto1->Raw) {
            $this->telefono_contacto1->CurrentValue = HtmlDecode($this->telefono_contacto1->CurrentValue);
        }
        $this->telefono_contacto1->EditValue = $this->telefono_contacto1->CurrentValue;
        $this->telefono_contacto1->PlaceHolder = RemoveHtml($this->telefono_contacto1->caption());

        // telefono_contacto2
        $this->telefono_contacto2->setupEditAttributes();
        if (!$this->telefono_contacto2->Raw) {
            $this->telefono_contacto2->CurrentValue = HtmlDecode($this->telefono_contacto2->CurrentValue);
        }
        $this->telefono_contacto2->EditValue = $this->telefono_contacto2->CurrentValue;
        $this->telefono_contacto2->PlaceHolder = RemoveHtml($this->telefono_contacto2->caption());

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // cedula_fallecido
        $this->cedula_fallecido->setupEditAttributes();
        if (!$this->cedula_fallecido->Raw) {
            $this->cedula_fallecido->CurrentValue = HtmlDecode($this->cedula_fallecido->CurrentValue);
        }
        $this->cedula_fallecido->EditValue = $this->cedula_fallecido->CurrentValue;
        $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

        // nombre_fallecido
        $this->nombre_fallecido->setupEditAttributes();
        if (!$this->nombre_fallecido->Raw) {
            $this->nombre_fallecido->CurrentValue = HtmlDecode($this->nombre_fallecido->CurrentValue);
        }
        $this->nombre_fallecido->EditValue = $this->nombre_fallecido->CurrentValue;
        $this->nombre_fallecido->PlaceHolder = RemoveHtml($this->nombre_fallecido->caption());

        // apellidos_fallecido
        $this->apellidos_fallecido->setupEditAttributes();
        if (!$this->apellidos_fallecido->Raw) {
            $this->apellidos_fallecido->CurrentValue = HtmlDecode($this->apellidos_fallecido->CurrentValue);
        }
        $this->apellidos_fallecido->EditValue = $this->apellidos_fallecido->CurrentValue;
        $this->apellidos_fallecido->PlaceHolder = RemoveHtml($this->apellidos_fallecido->caption());

        // sexo
        $this->sexo->setupEditAttributes();
        $this->sexo->PlaceHolder = RemoveHtml($this->sexo->caption());

        // fecha_nacimiento
        $this->fecha_nacimiento->setupEditAttributes();
        $this->fecha_nacimiento->EditValue = FormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern());
        $this->fecha_nacimiento->PlaceHolder = RemoveHtml($this->fecha_nacimiento->caption());

        // edad_fallecido
        $this->edad_fallecido->setupEditAttributes();
        $this->edad_fallecido->EditValue = $this->edad_fallecido->CurrentValue;
        $this->edad_fallecido->PlaceHolder = RemoveHtml($this->edad_fallecido->caption());
        if (strval($this->edad_fallecido->EditValue) != "" && is_numeric($this->edad_fallecido->EditValue)) {
            $this->edad_fallecido->EditValue = $this->edad_fallecido->EditValue;
        }

        // estado_civil
        $this->estado_civil->setupEditAttributes();
        $this->estado_civil->PlaceHolder = RemoveHtml($this->estado_civil->caption());

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->setupEditAttributes();
        if (!$this->lugar_nacimiento_fallecido->Raw) {
            $this->lugar_nacimiento_fallecido->CurrentValue = HtmlDecode($this->lugar_nacimiento_fallecido->CurrentValue);
        }
        $this->lugar_nacimiento_fallecido->EditValue = $this->lugar_nacimiento_fallecido->CurrentValue;
        $this->lugar_nacimiento_fallecido->PlaceHolder = RemoveHtml($this->lugar_nacimiento_fallecido->caption());

        // lugar_ocurrencia
        $this->lugar_ocurrencia->setupEditAttributes();
        $this->lugar_ocurrencia->PlaceHolder = RemoveHtml($this->lugar_ocurrencia->caption());

        // direccion_ocurrencia
        $this->direccion_ocurrencia->setupEditAttributes();
        $this->direccion_ocurrencia->EditValue = $this->direccion_ocurrencia->CurrentValue;
        $this->direccion_ocurrencia->PlaceHolder = RemoveHtml($this->direccion_ocurrencia->caption());

        // fecha_ocurrencia
        $this->fecha_ocurrencia->setupEditAttributes();
        $this->fecha_ocurrencia->EditValue = FormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern());
        $this->fecha_ocurrencia->PlaceHolder = RemoveHtml($this->fecha_ocurrencia->caption());

        // hora_ocurrencia
        $this->hora_ocurrencia->setupEditAttributes();
        $this->hora_ocurrencia->EditValue = $this->hora_ocurrencia->CurrentValue;
        $this->hora_ocurrencia->PlaceHolder = RemoveHtml($this->hora_ocurrencia->caption());

        // causa_ocurrencia
        $this->causa_ocurrencia->setupEditAttributes();
        $this->causa_ocurrencia->PlaceHolder = RemoveHtml($this->causa_ocurrencia->caption());

        // causa_otro
        $this->causa_otro->setupEditAttributes();
        if (!$this->causa_otro->Raw) {
            $this->causa_otro->CurrentValue = HtmlDecode($this->causa_otro->CurrentValue);
        }
        $this->causa_otro->EditValue = $this->causa_otro->CurrentValue;
        $this->causa_otro->PlaceHolder = RemoveHtml($this->causa_otro->caption());

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->setupEditAttributes();
        $this->descripcion_ocurrencia->EditValue = $this->descripcion_ocurrencia->CurrentValue;
        $this->descripcion_ocurrencia->PlaceHolder = RemoveHtml($this->descripcion_ocurrencia->caption());

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // user_registra

        // fecha_registro

        // expediente
        $this->expediente->setupEditAttributes();
        $this->expediente->EditValue = $this->expediente->CurrentValue;
        $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());
        if (strval($this->expediente->EditValue) != "" && is_numeric($this->expediente->EditValue)) {
            $this->expediente->EditValue = $this->expediente->EditValue;
        }

        // religion
        $this->religion->setupEditAttributes();
        $this->religion->PlaceHolder = RemoveHtml($this->religion->caption());

        // servicio_tipo
        $this->servicio_tipo->setupEditAttributes();
        $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

        // servicio
        $this->servicio->setupEditAttributes();
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->options(true);
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // funeraria
        $this->funeraria->setupEditAttributes();
        $this->funeraria->EditValue = $this->funeraria->options(true);
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
                    $doc->exportCaption($this->Nexpediente_seguros);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->parentesco_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
                    $doc->exportCaption($this->sexo);
                    $doc->exportCaption($this->fecha_nacimiento);
                    $doc->exportCaption($this->edad_fallecido);
                    $doc->exportCaption($this->lugar_ocurrencia);
                    $doc->exportCaption($this->direccion_ocurrencia);
                    $doc->exportCaption($this->fecha_ocurrencia);
                    $doc->exportCaption($this->causa_ocurrencia);
                    $doc->exportCaption($this->causa_otro);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->religion);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->funeraria);
                } else {
                    $doc->exportCaption($this->Nexpediente_seguros);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->parentesco_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
                    $doc->exportCaption($this->sexo);
                    $doc->exportCaption($this->fecha_nacimiento);
                    $doc->exportCaption($this->edad_fallecido);
                    $doc->exportCaption($this->estado_civil);
                    $doc->exportCaption($this->lugar_nacimiento_fallecido);
                    $doc->exportCaption($this->lugar_ocurrencia);
                    $doc->exportCaption($this->direccion_ocurrencia);
                    $doc->exportCaption($this->fecha_ocurrencia);
                    $doc->exportCaption($this->hora_ocurrencia);
                    $doc->exportCaption($this->causa_ocurrencia);
                    $doc->exportCaption($this->causa_otro);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->user_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->religion);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->estatus);
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
                        $doc->exportField($this->Nexpediente_seguros);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->parentesco_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
                        $doc->exportField($this->sexo);
                        $doc->exportField($this->fecha_nacimiento);
                        $doc->exportField($this->edad_fallecido);
                        $doc->exportField($this->lugar_ocurrencia);
                        $doc->exportField($this->direccion_ocurrencia);
                        $doc->exportField($this->fecha_ocurrencia);
                        $doc->exportField($this->causa_ocurrencia);
                        $doc->exportField($this->causa_otro);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->religion);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->funeraria);
                    } else {
                        $doc->exportField($this->Nexpediente_seguros);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->parentesco_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
                        $doc->exportField($this->sexo);
                        $doc->exportField($this->fecha_nacimiento);
                        $doc->exportField($this->edad_fallecido);
                        $doc->exportField($this->estado_civil);
                        $doc->exportField($this->lugar_nacimiento_fallecido);
                        $doc->exportField($this->lugar_ocurrencia);
                        $doc->exportField($this->direccion_ocurrencia);
                        $doc->exportField($this->fecha_ocurrencia);
                        $doc->exportField($this->hora_ocurrencia);
                        $doc->exportField($this->causa_ocurrencia);
                        $doc->exportField($this->causa_otro);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->user_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->religion);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->estatus);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_expediente_seguros');
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
        $key .= $rs['Nexpediente_seguros'];

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
                WriteAuditLog($usr, "A", 'sco_expediente_seguros', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nexpediente_seguros'];

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
                    WriteAuditLog($usr, "U", 'sco_expediente_seguros', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nexpediente_seguros'];

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
                WriteAuditLog($usr, "D", 'sco_expediente_seguros', $fldname, $key, $oldvalue);
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
    	$sql = "SELECT IFNULL(seguro,0) AS seguro FROM sco_user WHERE username = '" . CurrentUserName() . "';";
    	$seguro = ExecuteScalar($sql);
    	if($seguro > 0) AddFilter($filter, "seguro = '$seguro'");
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
    	$rsnew["nombre_contacto"] = strtoupper($rsnew["nombre_contacto"]);
    	$rsnew["apellidos_contacto"] = strtoupper($rsnew["apellidos_contacto"]);
    	$rsnew["nombre_fallecido"] = strtoupper($rsnew["nombre_fallecido"]);
    	$rsnew["apellidos_fallecido"] = strtoupper($rsnew["apellidos_fallecido"]);
    	$rsnew["user_registra"] = CurrentUserName();
    	$rsnew["fecha_registro"] = CurrentDateTime();
    	if(strtotime($rsnew["fecha_nacimiento"]) > strtotime(date("Y-m-d"))) {
    		$this->CancelMessage = "La Fecha de Nacimiento no puede ser mayor a la fecha actual";
    		return FALSE;
    	}
    	$rsnew["edad_fallecido"] = calc_edad($rsnew["fecha_nacimiento"]);
    	$rsnew["estatus"] = "0";
    	if($row = ExecuteRow("SELECT a.cedula_fallecido FROM sco_expediente a WHERE a.cedula_fallecido = '" . $rsnew["cedula_fallecido"] . "';"))
    	{
    		$this->CancelMessage = "C&eacute;dula de Fallecido Ya Existe; Verifique!";
    		return FALSE;
    	}
    	if(strtotime($rsnew["fecha_ocurrencia"]) > strtotime(date("Y-m-d"))) {
    		$this->CancelMessage = "La Fecha de Ocurrencia no puede ser mayor a la fecha actual";
    		return FALSE;
    	}
    	if(strtotime($rsnew["fecha_nacimiento"]) > strtotime($rsnew["fecha_ocurrencia"])) {
    		$this->CancelMessage = "La Fecha de Nacimiento no puede ser mayor a la Fecha de Ocurrencia";
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
    	if($rsold["expediente"] > 0) {
    		$this->CancelMessage = "Este registro fu&eacute; procesado; no se puede modificar.";
    		return FALSE;
    	}
    	if(strtotime($rsnew["fecha_nacimiento"]) > strtotime(date("Y-m-d"))) {
    		$this->CancelMessage = "La Fecha de Nacimiento no puede ser mayor a la fecha actual";
    		return FALSE;
    	}
    	if($rsold["fecha_nacimiento"] <> $rsnew["fecha_nacimiento"])
    		$rsnew["edad_fallecido"] = calc_edad($rsnew["fecha_nacimiento"]);
    	if(strtotime($rsnew["fecha_ocurrencia"]) > strtotime(date("Y-m-d"))) {
    		$this->CancelMessage = "La Fecha de Ocurrencia no puede ser mayor a la fecha actual";
    		return FALSE;
    	}
    	if(strtotime($rsnew["fecha_nacimiento"]) > strtotime($rsnew["fecha_ocurrencia"])) {
    		$this->CancelMessage = "La Fecha de Nacimiento no puede ser mayor a la Fecha de Ocurrencia";
    		return FALSE;
    	}
    	return TRUE;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
    	//echo "Row Updated";
    	if($rsnew["estatus"] == 1 and $rsold["expediente"] == 0) {
    		$sql = "INSERT INTO sco_expediente (
    					Nexpediente, 
    					seguro, 
    					nombre_contacto, 
    					parentesco_contacto, 
    					telefono_contacto1, 
    					telefono_contacto2, 
    					email, 
    					cedula_fallecido, 
    					sexo, 
    					nombre_fallecido, 
    					apellidos_fallecido, 
    					fecha_nacimiento, 
    					edad_fallecido, 
    					estado_civil, 
    					lugar_ocurrencia, 
    					direccion_ocurrencia, 
    					fecha_ocurrencia, 
    					causa_ocurrencia, 
    					causa_otro, 
    					user_registra, 
    					fecha_registro, 
    					estatus, 
    					nota,
    					religion, 
    					funeraria, 
    					servicio_tipo, 
    					servicio
    				)
    				SELECT 
    					NULL, 
    					seguro, 
    					nombre_contacto, 
    					parentesco_contacto, 
    					telefono_contacto1, 
    					telefono_contacto2, 
    					email, 
    					cedula_fallecido, 
    					sexo, 
    					nombre_fallecido, 
    					apellidos_fallecido, 
    					fecha_nacimiento, 
    					edad_fallecido, 
    					estado_civil, 
    					lugar_ocurrencia, 
    					direccion_ocurrencia, 
    					fecha_ocurrencia, 
    					causa_ocurrencia, 
    					causa_otro, 
    					'" . CurrentUserName() . "', 
    					now(), 
    					'1' AS estatus, 
    					CONCAT('Exp. Cargado por la Aseguradora', ' - ', nota) AS nota, 
    					religion, 
    					'1', 
    					servicio_tipo, 
    					servicio
    				FROM sco_expediente_seguros 
    				WHERE Nexpediente_seguros = '" . $rsold["Nexpediente_seguros"] . "';";
    		Execute($sql);
    		$sql = "SELECT LAST_INSERT_ID()";
    		$exp = ExecuteScalar($sql);
    		$sql = "UPDATE sco_expediente_seguros SET expediente = '$exp' WHERE Nexpediente_seguros = '" . $rsold["Nexpediente_seguros"] . "'";
    		Execute($sql);
    		cambiar_estatus($exp, 1);
    		$sql = "INSERT INTO sco_entrada_salida
    					(Nentrada_salida, tipo_doc, proveedor, clasificacion, documento, fecha, nota, username, monto, registro)
    				VALUES (NULL, 'EXOU', -1, 'EXPE', '$exp', NOW(), 'SALIDA AUTOMATICA POR CREACION DE Exp.: $exp', '" . CurrentUserName() . "', 0, now())";
    		Execute($sql);
    		$sql = "SELECT LAST_INSERT_ID()";
    		$idSali = ExecuteScalar($sql);
    		$sql = "INSERT INTO sco_entrada_salida_detalle
    					(Nentrada_salida_detalle, entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
    				VALUES (NULL, $idSali, 'EXOU', -1, 'FUNE000001', -1, 0, 0)";
    		Execute($sql);
    		$sql = "INSERT INTO sco_adjunto
    					(Nadjunto, expediente, tipo, archivo, nota, activo)
    				SELECT NULL, '$exp', 'IMG', archivo, nota, 'S'
    					FROM sco_expediente_seguros_adjunto
    				WHERE expediente_seguros = '" . $rsold["Nexpediente_seguros"] . "';";
    		Execute($sql);
    		$sql = "INSERT INTO sco_nota
    					(Nnota, expediente, nota, usuario, fecha)
    				VALUES (NULL, '$exp', 'Se procesa desde el modulo de Autogestion Seguros # " . $rsold["Nexpediente_seguros"] . "', '" . CurrentUserName() . "', NOW())";
    		Execute($sql);
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
    public function rowDeleting(&$rs) {
    	// Enter your code here
    	// To cancel, set return value to False
    	if($rs["expediente"] > 0) {
    		$this->CancelMessage = "Este registro fu&eacute; procesado; no se puede eliminar.";
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
    		$sql = "select
    					color
    				from
    					sco_estatus
    				where
    					Nstatus = '".$this->estatus->CurrentValue."';";
    		$color = $this->estatus->CurrentValue=="0"?"#fe4848":"#92d050";
    		$style = "background-color: $color"; 	
    		$this->estatus->CellAttrs["style"] = $style;
    		 $this->cedula_fallecido->CellAttrs["style"] = $style;
    		 $this->sexo->CellAttrs["style"] = $style;
    		 $this->nombre_fallecido->CellAttrs["style"] = $style;
    		 $this->apellidos_fallecido->CellAttrs["style"] = $style;
    		 $this->edad_fallecido->CellAttrs["style"] = $style;
    		 $this->lugar_nacimiento_fallecido->CellAttrs["style"] = $style;
    		 $this->lugar_ocurrencia->CellAttrs["style"] = $style;
    		 $this->estado_civil->CellAttrs["style"] = $style;
    		 $this->fecha_nacimiento->CellAttrs["style"] = $style;
    		 $this->direccion_ocurrencia->CellAttrs["style"] = $style;
    		 $this->fecha_ocurrencia->CellAttrs["style"] = $style;
    		 $this->causa_ocurrencia->CellAttrs["style"] = $style;
    		 $this->causa_otro->CellAttrs["style"] = $style;
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
