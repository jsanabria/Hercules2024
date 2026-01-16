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
 * Table class for sco_expediente
 */
class ScoExpediente extends DbTable
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
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $Nexpediente;
    public $contrato_parcela;
    public $tipo_contratacion;
    public $seguro;
    public $nacionalidad_contacto;
    public $cedula_contacto;
    public $nombre_contacto;
    public $apellidos_contacto;
    public $parentesco_contacto;
    public $telefono_contacto1;
    public $telefono_contacto2;
    public $_email;
    public $nacionalidad_fallecido;
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
    public $religion;
    public $permiso;
    public $costos;
    public $venta;
    public $user_registra;
    public $fecha_registro;
    public $user_cierra;
    public $fecha_cierre;
    public $calidad;
    public $factura;
    public $unir_con_expediente;
    public $estatus;
    public $nota;
    public $funeraria;
    public $servicio_tipo;
    public $servicio;
    public $marca_pasos;
    public $peso;
    public $autoriza_cremar;
    public $certificado_defuncion;
    public $parcela;
    public $username_autoriza;
    public $fecha_autoriza;
    public $email_calidad;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_expediente";
        $this->TableName = 'sco_expediente';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_expediente";
        $this->Dbid = 'DB';
        $this->ExportAll = false;
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
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // Nexpediente
        $this->Nexpediente = new DbField(
            $this, // Table
            'x_Nexpediente', // Variable name
            'Nexpediente', // Name
            '`Nexpediente`', // Expression
            '`Nexpediente`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nexpediente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nexpediente->InputTextType = "text";
        $this->Nexpediente->Raw = true;
        $this->Nexpediente->IsAutoIncrement = true; // Autoincrement field
        $this->Nexpediente->IsPrimaryKey = true; // Primary key field
        $this->Nexpediente->IsForeignKey = true; // Foreign key field
        $this->Nexpediente->Nullable = false; // NOT NULL field
        $this->Nexpediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nexpediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nexpediente'] = &$this->Nexpediente;

        // contrato_parcela
        $this->contrato_parcela = new DbField(
            $this, // Table
            'x_contrato_parcela', // Variable name
            'contrato_parcela', // Name
            '`contrato_parcela`', // Expression
            '`contrato_parcela`', // Basic search expression
            200, // Type
            8, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contrato_parcela`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'IMAGE', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contrato_parcela->InputTextType = "text";
        $this->contrato_parcela->IsForeignKey = true; // Foreign key field
        $this->contrato_parcela->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contrato_parcela'] = &$this->contrato_parcela;

        // tipo_contratacion
        $this->tipo_contratacion = new DbField(
            $this, // Table
            'x_tipo_contratacion', // Variable name
            'tipo_contratacion', // Name
            '`tipo_contratacion`', // Expression
            '`tipo_contratacion`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_contratacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo_contratacion->InputTextType = "text";
        $this->tipo_contratacion->Nullable = false; // NOT NULL field
        $this->tipo_contratacion->Required = true; // Required field
        $this->tipo_contratacion->setSelectMultiple(false); // Select one
        $this->tipo_contratacion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_contratacion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo_contratacion->Lookup = new Lookup($this->tipo_contratacion, 'sco_seguro', true, 'tipo_contratacion', ["tipo_contratacion","","",""], '', '', [], [], [], [], [], [], false, '`tipo_contratacion`', '', "`tipo_contratacion`");
        $this->tipo_contratacion->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_contratacion->SearchOperators = ["=", "<>"];
        $this->Fields['tipo_contratacion'] = &$this->tipo_contratacion;

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
        $this->seguro->addMethod("getSelectFilter", fn() => "`activo` = 'S'");
        $this->seguro->InputTextType = "text";
        $this->seguro->Raw = true;
        $this->seguro->Nullable = false; // NOT NULL field
        $this->seguro->Required = true; // Required field
        $this->seguro->setSelectMultiple(false); // Select one
        $this->seguro->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->seguro->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->seguro->Lookup = new Lookup($this->seguro, 'sco_seguro', false, 'Nseguro', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->seguro->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->seguro->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['seguro'] = &$this->seguro;

        // nacionalidad_contacto
        $this->nacionalidad_contacto = new DbField(
            $this, // Table
            'x_nacionalidad_contacto', // Variable name
            'nacionalidad_contacto', // Name
            '`nacionalidad_contacto`', // Expression
            '`nacionalidad_contacto`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nacionalidad_contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->nacionalidad_contacto->InputTextType = "text";
        $this->nacionalidad_contacto->Nullable = false; // NOT NULL field
        $this->nacionalidad_contacto->Required = true; // Required field
        $this->nacionalidad_contacto->setSelectMultiple(false); // Select one
        $this->nacionalidad_contacto->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->nacionalidad_contacto->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->nacionalidad_contacto->Lookup = new Lookup($this->nacionalidad_contacto, 'sco_expediente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->nacionalidad_contacto->OptionCount = 2;
        $this->nacionalidad_contacto->SearchOperators = ["=", "<>"];
        $this->Fields['nacionalidad_contacto'] = &$this->nacionalidad_contacto;

        // cedula_contacto
        $this->cedula_contacto = new DbField(
            $this, // Table
            'x_cedula_contacto', // Variable name
            'cedula_contacto', // Name
            '`cedula_contacto`', // Expression
            '`cedula_contacto`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula_contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula_contacto->InputTextType = "text";
        $this->cedula_contacto->Nullable = false; // NOT NULL field
        $this->cedula_contacto->Required = true; // Required field
        $this->cedula_contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['cedula_contacto'] = &$this->cedula_contacto;

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

        // apellidos_contacto
        $this->apellidos_contacto = new DbField(
            $this, // Table
            'x_apellidos_contacto', // Variable name
            'apellidos_contacto', // Name
            '`apellidos_contacto`', // Expression
            '`apellidos_contacto`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`apellidos_contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->apellidos_contacto->InputTextType = "text";
        $this->apellidos_contacto->Nullable = false; // NOT NULL field
        $this->apellidos_contacto->Required = true; // Required field
        $this->apellidos_contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['apellidos_contacto'] = &$this->apellidos_contacto;

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
        $this->parentesco_contacto->Lookup = new Lookup($this->parentesco_contacto, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`campo_descripcion`");
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

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido = new DbField(
            $this, // Table
            'x_nacionalidad_fallecido', // Variable name
            'nacionalidad_fallecido', // Name
            '`nacionalidad_fallecido`', // Expression
            '`nacionalidad_fallecido`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nacionalidad_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->nacionalidad_fallecido->InputTextType = "text";
        $this->nacionalidad_fallecido->Required = true; // Required field
        $this->nacionalidad_fallecido->setSelectMultiple(false); // Select one
        $this->nacionalidad_fallecido->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->nacionalidad_fallecido->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->nacionalidad_fallecido->Lookup = new Lookup($this->nacionalidad_fallecido, 'sco_expediente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->nacionalidad_fallecido->OptionCount = 2;
        $this->nacionalidad_fallecido->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['nacionalidad_fallecido'] = &$this->nacionalidad_fallecido;

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
        $this->sexo->Lookup = new Lookup($this->sexo, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`campo_descripcion`");
        $this->sexo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['sexo'] = &$this->sexo;

        // fecha_nacimiento
        $this->fecha_nacimiento = new DbField(
            $this, // Table
            'x_fecha_nacimiento', // Variable name
            'fecha_nacimiento', // Name
            '`fecha_nacimiento`', // Expression
            CastDateFieldForLike("`fecha_nacimiento`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
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
        $this->fecha_nacimiento->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
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
        $this->edad_fallecido->Required = true; // Required field
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
        $this->estado_civil->InputTextType = "text";
        $this->estado_civil->Required = true; // Required field
        $this->estado_civil->setSelectMultiple(false); // Select one
        $this->estado_civil->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estado_civil->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estado_civil->Lookup = new Lookup($this->estado_civil, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->estado_civil->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
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
        $this->lugar_ocurrencia->Lookup = new Lookup($this->lugar_ocurrencia, 'sco_tabla', true, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->lugar_ocurrencia->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
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
        $this->direccion_ocurrencia->Required = true; // Required field
        $this->direccion_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direccion_ocurrencia'] = &$this->direccion_ocurrencia;

        // fecha_ocurrencia
        $this->fecha_ocurrencia = new DbField(
            $this, // Table
            'x_fecha_ocurrencia', // Variable name
            'fecha_ocurrencia', // Name
            '`fecha_ocurrencia`', // Expression
            CastDateFieldForLike("`fecha_ocurrencia`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
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
        $this->fecha_ocurrencia->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
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
            0, // Date/Time format
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
        $this->causa_ocurrencia->setSelectMultiple(false); // Select one
        $this->causa_ocurrencia->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->causa_ocurrencia->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->causa_ocurrencia->Lookup = new Lookup($this->causa_ocurrencia, 'sco_tabla', false, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
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
        $this->descripcion_ocurrencia->Required = true; // Required field
        $this->descripcion_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['descripcion_ocurrencia'] = &$this->descripcion_ocurrencia;

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
        $this->religion->InputTextType = "text";
        $this->religion->setSelectMultiple(false); // Select one
        $this->religion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->religion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->religion->Lookup = new Lookup($this->religion, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->religion->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['religion'] = &$this->religion;

        // permiso
        $this->permiso = new DbField(
            $this, // Table
            'x_permiso', // Variable name
            'permiso', // Name
            '`permiso`', // Expression
            '`permiso`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`permiso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->permiso->InputTextType = "text";
        $this->permiso->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['permiso'] = &$this->permiso;

        // costos
        $this->costos = new DbField(
            $this, // Table
            'x_costos', // Variable name
            'costos', // Name
            '`costos`', // Expression
            '`costos`', // Basic search expression
            131, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`costos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->costos->InputTextType = "text";
        $this->costos->Raw = true;
        $this->costos->Required = true; // Required field
        $this->costos->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->costos->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['costos'] = &$this->costos;

        // venta
        $this->venta = new DbField(
            $this, // Table
            'x_venta', // Variable name
            'venta', // Name
            '`venta`', // Expression
            '`venta`', // Basic search expression
            131, // Type
            18, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`venta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->venta->addMethod("getDefault", fn() => 0.00);
        $this->venta->InputTextType = "text";
        $this->venta->Raw = true;
        $this->venta->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->venta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['venta'] = &$this->venta;

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
            'TEXT' // Edit Tag
        );
        $this->user_registra->InputTextType = "text";
        $this->user_registra->Required = true; // Required field
        $this->user_registra->Lookup = new Lookup($this->user_registra, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nombre`");
        $this->user_registra->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_registra'] = &$this->user_registra;

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
        $this->fecha_registro->Required = true; // Required field
        $this->fecha_registro->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_registro'] = &$this->fecha_registro;

        // user_cierra
        $this->user_cierra = new DbField(
            $this, // Table
            'x_user_cierra', // Variable name
            'user_cierra', // Name
            '`user_cierra`', // Expression
            '`user_cierra`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`user_cierra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->user_cierra->InputTextType = "text";
        $this->user_cierra->Required = true; // Required field
        $this->user_cierra->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_cierra'] = &$this->user_cierra;

        // fecha_cierre
        $this->fecha_cierre = new DbField(
            $this, // Table
            'x_fecha_cierre', // Variable name
            'fecha_cierre', // Name
            '`fecha_cierre`', // Expression
            CastDateFieldForLike("`fecha_cierre`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`fecha_cierre`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_cierre->InputTextType = "text";
        $this->fecha_cierre->Raw = true;
        $this->fecha_cierre->Required = true; // Required field
        $this->fecha_cierre->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->fecha_cierre->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_cierre'] = &$this->fecha_cierre;

        // calidad
        $this->calidad = new DbField(
            $this, // Table
            'x_calidad', // Variable name
            'calidad', // Name
            '`calidad`', // Expression
            '`calidad`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`calidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->calidad->addMethod("getSelectFilter", fn() => "`tabla` in ('CALIDAD')");
        $this->calidad->InputTextType = "text";
        $this->calidad->setSelectMultiple(false); // Select one
        $this->calidad->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->calidad->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->calidad->Lookup = new Lookup($this->calidad, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_codigo`', '', "`campo_descripcion`");
        $this->calidad->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->calidad->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['calidad'] = &$this->calidad;

        // factura
        $this->factura = new DbField(
            $this, // Table
            'x_factura', // Variable name
            'factura', // Name
            '`factura`', // Expression
            '`factura`', // Basic search expression
            200, // Type
            20, // Size
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

        // unir_con_expediente
        $this->unir_con_expediente = new DbField(
            $this, // Table
            'x_unir_con_expediente', // Variable name
            'unir_con_expediente', // Name
            '`unir_con_expediente`', // Expression
            '`unir_con_expediente`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`unir_con_expediente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->unir_con_expediente->addMethod("getSelectFilter", fn() => "`estatus` BETWEEN 1 AND 5 AND Nexpediente <> '" . CurrentTable()->Nexpediente->CurrentValue . "'");
        $this->unir_con_expediente->InputTextType = "text";
        $this->unir_con_expediente->Raw = true;
        $this->unir_con_expediente->setSelectMultiple(false); // Select one
        $this->unir_con_expediente->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->unir_con_expediente->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->unir_con_expediente->Lookup = new Lookup($this->unir_con_expediente, 'sco_expediente', false, 'Nexpediente', ["Nexpediente","nombre_fallecido","apellidos_fallecido",""], '', '', [], [], [], [], [], [], false, '`Nexpediente` DESC', '', "CONCAT(COALESCE(`Nexpediente`, ''),'" . ValueSeparator(1, $this->unir_con_expediente) . "',COALESCE(`nombre_fallecido`,''),'" . ValueSeparator(2, $this->unir_con_expediente) . "',COALESCE(`apellidos_fallecido`,''))");
        $this->unir_con_expediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->unir_con_expediente->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['unir_con_expediente'] = &$this->unir_con_expediente;

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
        $this->estatus->addMethod("getSelectFilter", fn() => "`activo` = 'S'");
        $this->estatus->addMethod("getDefault", fn() => 1);
        $this->estatus->InputTextType = "text";
        $this->estatus->Raw = true;
        $this->estatus->Required = true; // Required field
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_estatus', false, 'Nstatus', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`Nstatus`', '', "`nombre`");
        $this->estatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estatus->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

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
        $this->funeraria->Required = true; // Required field
        $this->funeraria->setSelectMultiple(false); // Select one
        $this->funeraria->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->funeraria->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->funeraria->Lookup = new Lookup($this->funeraria, 'sco_expediente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->funeraria->OptionCount = 2;
        $this->funeraria->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->funeraria->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['funeraria'] = &$this->funeraria;

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
        $this->servicio_tipo->addMethod("getSelectFilter", fn() => "`Nservicio_tipo` IN ('CREM','SEPE','EXHU')");
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

        // marca_pasos
        $this->marca_pasos = new DbField(
            $this, // Table
            'x_marca_pasos', // Variable name
            'marca_pasos', // Name
            '`marca_pasos`', // Expression
            '`marca_pasos`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`marca_pasos`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->marca_pasos->InputTextType = "text";
        $this->marca_pasos->Raw = true;
        $this->marca_pasos->setSelectMultiple(false); // Select one
        $this->marca_pasos->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->marca_pasos->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->marca_pasos->Lookup = new Lookup($this->marca_pasos, 'sco_expediente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->marca_pasos->OptionCount = 2;
        $this->marca_pasos->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['marca_pasos'] = &$this->marca_pasos;

        // peso
        $this->peso = new DbField(
            $this, // Table
            'x_peso', // Variable name
            'peso', // Name
            '`peso`', // Expression
            '`peso`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`peso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->peso->addMethod("getSelectFilter", fn() => "`codigo` = '034'");
        $this->peso->InputTextType = "text";
        $this->peso->setSelectMultiple(false); // Select one
        $this->peso->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->peso->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->peso->Lookup = new Lookup($this->peso, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor2` ASC', '', "`valor1`");
        $this->peso->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['peso'] = &$this->peso;

        // autoriza_cremar
        $this->autoriza_cremar = new DbField(
            $this, // Table
            'x_autoriza_cremar', // Variable name
            'autoriza_cremar', // Name
            '`autoriza_cremar`', // Expression
            '`autoriza_cremar`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`autoriza_cremar`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->autoriza_cremar->addMethod("getDefault", fn() => "N");
        $this->autoriza_cremar->InputTextType = "text";
        $this->autoriza_cremar->Raw = true;
        $this->autoriza_cremar->setSelectMultiple(false); // Select one
        $this->autoriza_cremar->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->autoriza_cremar->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->autoriza_cremar->Lookup = new Lookup($this->autoriza_cremar, 'sco_expediente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->autoriza_cremar->OptionCount = 2;
        $this->autoriza_cremar->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['autoriza_cremar'] = &$this->autoriza_cremar;

        // certificado_defuncion
        $this->certificado_defuncion = new DbField(
            $this, // Table
            'x_certificado_defuncion', // Variable name
            'certificado_defuncion', // Name
            '`certificado_defuncion`', // Expression
            '`certificado_defuncion`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`certificado_defuncion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->certificado_defuncion->InputTextType = "text";
        $this->certificado_defuncion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['certificado_defuncion'] = &$this->certificado_defuncion;

        // parcela
        $this->parcela = new DbField(
            $this, // Table
            'x_parcela', // Variable name
            'parcela', // Name
            '`parcela`', // Expression
            '`parcela`', // Basic search expression
            200, // Type
            50, // Size
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

        // username_autoriza
        $this->username_autoriza = new DbField(
            $this, // Table
            'x_username_autoriza', // Variable name
            'username_autoriza', // Name
            '`username_autoriza`', // Expression
            '`username_autoriza`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`username_autoriza`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->username_autoriza->InputTextType = "text";
        $this->username_autoriza->Lookup = new Lookup($this->username_autoriza, 'sco_user', false, 'username', ["username","nombre","",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`username`, ''),'" . ValueSeparator(1, $this->username_autoriza) . "',COALESCE(`nombre`,''))");
        $this->username_autoriza->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['username_autoriza'] = &$this->username_autoriza;

        // fecha_autoriza
        $this->fecha_autoriza = new DbField(
            $this, // Table
            'x_fecha_autoriza', // Variable name
            'fecha_autoriza', // Name
            '`fecha_autoriza`', // Expression
            CastDateFieldForLike("`fecha_autoriza`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_autoriza`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_autoriza->InputTextType = "text";
        $this->fecha_autoriza->Raw = true;
        $this->fecha_autoriza->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_autoriza->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_autoriza'] = &$this->fecha_autoriza;

        // email_calidad
        $this->email_calidad = new DbField(
            $this, // Table
            'x_email_calidad', // Variable name
            'email_calidad', // Name
            '`email_calidad`', // Expression
            '`email_calidad`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email_calidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->email_calidad->addMethod("getDefault", fn() => "N");
        $this->email_calidad->InputTextType = "text";
        $this->email_calidad->Raw = true;
        $this->email_calidad->Lookup = new Lookup($this->email_calidad, 'sco_expediente', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->email_calidad->OptionCount = 2;
        $this->email_calidad->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['email_calidad'] = &$this->email_calidad;

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
        if ($this->getCurrentDetailTable() == "sco_orden") {
            $detailUrl = Container("sco_orden")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_seguimiento") {
            $detailUrl = Container("sco_seguimiento")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_expediente_estatus") {
            $detailUrl = Container("sco_expediente_estatus")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_adjunto") {
            $detailUrl = Container("sco_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_cremacion_estatus") {
            $detailUrl = Container("sco_cremacion_estatus")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_parcela") {
            $detailUrl = Container("sco_parcela")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_contrato_parcela", $this->contrato_parcela->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_expediente_encuesta_calidad") {
            $detailUrl = Container("sco_expediente_encuesta_calidad")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_expediente_cia") {
            $detailUrl = Container("sco_expediente_cia")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_embalaje") {
            $detailUrl = Container("sco_embalaje")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_reembolso") {
            $detailUrl = Container("sco_reembolso")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_nota") {
            $detailUrl = Container("sco_nota")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->Nexpediente->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoExpedienteList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_expediente";
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
            $this->Nexpediente->setDbValue($conn->lastInsertId());
            $rs['Nexpediente'] = $this->Nexpediente->DbValue;
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
            if (!isset($rs['Nexpediente']) && !EmptyValue($this->Nexpediente->CurrentValue)) {
                $rs['Nexpediente'] = $this->Nexpediente->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nexpediente';
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
            if (array_key_exists('Nexpediente', $rs)) {
                AddFilter($where, QuotedName('Nexpediente', $this->Dbid) . '=' . QuotedValue($rs['Nexpediente'], $this->Nexpediente->DataType, $this->Dbid));
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
        $this->Nexpediente->DbValue = $row['Nexpediente'];
        $this->contrato_parcela->DbValue = $row['contrato_parcela'];
        $this->tipo_contratacion->DbValue = $row['tipo_contratacion'];
        $this->seguro->DbValue = $row['seguro'];
        $this->nacionalidad_contacto->DbValue = $row['nacionalidad_contacto'];
        $this->cedula_contacto->DbValue = $row['cedula_contacto'];
        $this->nombre_contacto->DbValue = $row['nombre_contacto'];
        $this->apellidos_contacto->DbValue = $row['apellidos_contacto'];
        $this->parentesco_contacto->DbValue = $row['parentesco_contacto'];
        $this->telefono_contacto1->DbValue = $row['telefono_contacto1'];
        $this->telefono_contacto2->DbValue = $row['telefono_contacto2'];
        $this->_email->DbValue = $row['email'];
        $this->nacionalidad_fallecido->DbValue = $row['nacionalidad_fallecido'];
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
        $this->religion->DbValue = $row['religion'];
        $this->permiso->DbValue = $row['permiso'];
        $this->costos->DbValue = $row['costos'];
        $this->venta->DbValue = $row['venta'];
        $this->user_registra->DbValue = $row['user_registra'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->user_cierra->DbValue = $row['user_cierra'];
        $this->fecha_cierre->DbValue = $row['fecha_cierre'];
        $this->calidad->DbValue = $row['calidad'];
        $this->factura->DbValue = $row['factura'];
        $this->unir_con_expediente->DbValue = $row['unir_con_expediente'];
        $this->estatus->DbValue = $row['estatus'];
        $this->nota->DbValue = $row['nota'];
        $this->funeraria->DbValue = $row['funeraria'];
        $this->servicio_tipo->DbValue = $row['servicio_tipo'];
        $this->servicio->DbValue = $row['servicio'];
        $this->marca_pasos->DbValue = $row['marca_pasos'];
        $this->peso->DbValue = $row['peso'];
        $this->autoriza_cremar->DbValue = $row['autoriza_cremar'];
        $this->certificado_defuncion->DbValue = $row['certificado_defuncion'];
        $this->parcela->DbValue = $row['parcela'];
        $this->username_autoriza->DbValue = $row['username_autoriza'];
        $this->fecha_autoriza->DbValue = $row['fecha_autoriza'];
        $this->email_calidad->DbValue = $row['email_calidad'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nexpediente` = @Nexpediente@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nexpediente->CurrentValue : $this->Nexpediente->OldValue;
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
                $this->Nexpediente->CurrentValue = $keys[0];
            } else {
                $this->Nexpediente->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nexpediente', $row) ? $row['Nexpediente'] : null;
        } else {
            $val = !EmptyValue($this->Nexpediente->OldValue) && !$current ? $this->Nexpediente->OldValue : $this->Nexpediente->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nexpediente@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoExpedienteList");
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
            "ScoExpedienteView" => $Language->phrase("View"),
            "ScoExpedienteEdit" => $Language->phrase("Edit"),
            "ScoExpedienteAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoExpedienteList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoExpedienteView",
            Config("API_ADD_ACTION") => "ScoExpedienteAdd",
            Config("API_EDIT_ACTION") => "ScoExpedienteEdit",
            Config("API_DELETE_ACTION") => "ScoExpedienteDelete",
            Config("API_LIST_ACTION") => "ScoExpedienteList",
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
        return "ScoExpedienteList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteView", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoExpedienteAdd?" . $parm;
        } else {
            $url = "ScoExpedienteAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoExpedienteList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoExpedienteList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoExpedienteDelete", $parm);
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
        $json .= "\"Nexpediente\":" . VarToJson($this->Nexpediente->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nexpediente->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nexpediente->CurrentValue);
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
            if (($keyValue = Param("Nexpediente") ?? Route("Nexpediente")) !== null) {
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
                $this->Nexpediente->CurrentValue = $key;
            } else {
                $this->Nexpediente->OldValue = $key;
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

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoExpedienteList";
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

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->ViewValue = $this->descripcion_ocurrencia->CurrentValue;
        $this->descripcion_ocurrencia->CssClass = "fw-bold";

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

        // contrato_parcela
        $this->contrato_parcela->HrefValue = "";
        $this->contrato_parcela->TooltipValue = "";

        // tipo_contratacion
        $this->tipo_contratacion->HrefValue = "";
        $this->tipo_contratacion->TooltipValue = "";

        // seguro
        $this->seguro->HrefValue = "";
        $this->seguro->TooltipValue = "";

        // nacionalidad_contacto
        $this->nacionalidad_contacto->HrefValue = "";
        $this->nacionalidad_contacto->TooltipValue = "";

        // cedula_contacto
        $this->cedula_contacto->HrefValue = "";
        $this->cedula_contacto->TooltipValue = "";

        // nombre_contacto
        $this->nombre_contacto->HrefValue = "";
        $this->nombre_contacto->TooltipValue = "";

        // apellidos_contacto
        $this->apellidos_contacto->HrefValue = "";
        $this->apellidos_contacto->TooltipValue = "";

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

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->HrefValue = "";
        $this->nacionalidad_fallecido->TooltipValue = "";

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

        // religion
        $this->religion->HrefValue = "";
        $this->religion->TooltipValue = "";

        // permiso
        $this->permiso->HrefValue = "";
        $this->permiso->TooltipValue = "";

        // costos
        $this->costos->HrefValue = "";
        $this->costos->TooltipValue = "";

        // venta
        $this->venta->HrefValue = "";
        $this->venta->TooltipValue = "";

        // user_registra
        $this->user_registra->HrefValue = "";
        $this->user_registra->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // user_cierra
        $this->user_cierra->HrefValue = "";
        $this->user_cierra->TooltipValue = "";

        // fecha_cierre
        $this->fecha_cierre->HrefValue = "";
        $this->fecha_cierre->TooltipValue = "";

        // calidad
        $this->calidad->HrefValue = "";
        $this->calidad->TooltipValue = "";

        // factura
        $this->factura->HrefValue = "";
        $this->factura->TooltipValue = "";

        // unir_con_expediente
        $this->unir_con_expediente->HrefValue = "";
        $this->unir_con_expediente->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // funeraria
        $this->funeraria->HrefValue = "";
        $this->funeraria->TooltipValue = "";

        // servicio_tipo
        $this->servicio_tipo->HrefValue = "";
        $this->servicio_tipo->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // marca_pasos
        $this->marca_pasos->HrefValue = "";
        $this->marca_pasos->TooltipValue = "";

        // peso
        $this->peso->HrefValue = "";
        $this->peso->TooltipValue = "";

        // autoriza_cremar
        $this->autoriza_cremar->HrefValue = "";
        $this->autoriza_cremar->TooltipValue = "";

        // certificado_defuncion
        $this->certificado_defuncion->HrefValue = "";
        $this->certificado_defuncion->TooltipValue = "";

        // parcela
        $this->parcela->HrefValue = "";
        $this->parcela->TooltipValue = "";

        // username_autoriza
        $this->username_autoriza->HrefValue = "";
        $this->username_autoriza->TooltipValue = "";

        // fecha_autoriza
        $this->fecha_autoriza->HrefValue = "";
        $this->fecha_autoriza->TooltipValue = "";

        // email_calidad
        $this->email_calidad->HrefValue = "";
        $this->email_calidad->TooltipValue = "";

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

        // Nexpediente
        $this->Nexpediente->setupEditAttributes();
        $this->Nexpediente->EditValue = $this->Nexpediente->CurrentValue;

        // contrato_parcela
        $this->contrato_parcela->setupEditAttributes();
        if (!$this->contrato_parcela->Raw) {
            $this->contrato_parcela->CurrentValue = HtmlDecode($this->contrato_parcela->CurrentValue);
        }
        $this->contrato_parcela->EditValue = $this->contrato_parcela->CurrentValue;
        $this->contrato_parcela->PlaceHolder = RemoveHtml($this->contrato_parcela->caption());

        // tipo_contratacion
        $this->tipo_contratacion->setupEditAttributes();
        $this->tipo_contratacion->PlaceHolder = RemoveHtml($this->tipo_contratacion->caption());

        // seguro
        $this->seguro->setupEditAttributes();
        $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());

        // nacionalidad_contacto
        $this->nacionalidad_contacto->setupEditAttributes();
        $this->nacionalidad_contacto->EditValue = $this->nacionalidad_contacto->options(true);
        $this->nacionalidad_contacto->PlaceHolder = RemoveHtml($this->nacionalidad_contacto->caption());

        // cedula_contacto
        $this->cedula_contacto->setupEditAttributes();
        if (!$this->cedula_contacto->Raw) {
            $this->cedula_contacto->CurrentValue = HtmlDecode($this->cedula_contacto->CurrentValue);
        }
        $this->cedula_contacto->EditValue = $this->cedula_contacto->CurrentValue;
        $this->cedula_contacto->PlaceHolder = RemoveHtml($this->cedula_contacto->caption());

        // nombre_contacto
        $this->nombre_contacto->setupEditAttributes();
        if (!$this->nombre_contacto->Raw) {
            $this->nombre_contacto->CurrentValue = HtmlDecode($this->nombre_contacto->CurrentValue);
        }
        $this->nombre_contacto->EditValue = $this->nombre_contacto->CurrentValue;
        $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

        // apellidos_contacto
        $this->apellidos_contacto->setupEditAttributes();
        if (!$this->apellidos_contacto->Raw) {
            $this->apellidos_contacto->CurrentValue = HtmlDecode($this->apellidos_contacto->CurrentValue);
        }
        $this->apellidos_contacto->EditValue = $this->apellidos_contacto->CurrentValue;
        $this->apellidos_contacto->PlaceHolder = RemoveHtml($this->apellidos_contacto->caption());

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

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->setupEditAttributes();
        $this->nacionalidad_fallecido->EditValue = $this->nacionalidad_fallecido->options(true);
        $this->nacionalidad_fallecido->PlaceHolder = RemoveHtml($this->nacionalidad_fallecido->caption());

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
        $this->hora_ocurrencia->EditValue = FormatDateTime($this->hora_ocurrencia->CurrentValue, $this->hora_ocurrencia->formatPattern());
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

        // religion
        $this->religion->setupEditAttributes();
        $this->religion->PlaceHolder = RemoveHtml($this->religion->caption());

        // permiso
        $this->permiso->setupEditAttributes();
        if (!$this->permiso->Raw) {
            $this->permiso->CurrentValue = HtmlDecode($this->permiso->CurrentValue);
        }
        $this->permiso->EditValue = $this->permiso->CurrentValue;
        $this->permiso->PlaceHolder = RemoveHtml($this->permiso->caption());

        // costos
        $this->costos->setupEditAttributes();
        $this->costos->EditValue = $this->costos->CurrentValue;
        $this->costos->EditValue = FormatCurrency($this->costos->EditValue, $this->costos->formatPattern());

        // venta
        $this->venta->setupEditAttributes();
        $this->venta->EditValue = $this->venta->CurrentValue;
        $this->venta->EditValue = FormatNumber($this->venta->EditValue, $this->venta->formatPattern());

        // user_registra
        $this->user_registra->setupEditAttributes();
        if (!$this->user_registra->Raw) {
            $this->user_registra->CurrentValue = HtmlDecode($this->user_registra->CurrentValue);
        }
        $this->user_registra->EditValue = $this->user_registra->CurrentValue;
        $this->user_registra->PlaceHolder = RemoveHtml($this->user_registra->caption());

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

        // user_cierra
        $this->user_cierra->setupEditAttributes();
        if (!$this->user_cierra->Raw) {
            $this->user_cierra->CurrentValue = HtmlDecode($this->user_cierra->CurrentValue);
        }
        $this->user_cierra->EditValue = $this->user_cierra->CurrentValue;
        $this->user_cierra->PlaceHolder = RemoveHtml($this->user_cierra->caption());

        // fecha_cierre
        $this->fecha_cierre->setupEditAttributes();
        $this->fecha_cierre->EditValue = FormatDateTime($this->fecha_cierre->CurrentValue, $this->fecha_cierre->formatPattern());
        $this->fecha_cierre->PlaceHolder = RemoveHtml($this->fecha_cierre->caption());

        // calidad
        $this->calidad->setupEditAttributes();
        $this->calidad->PlaceHolder = RemoveHtml($this->calidad->caption());

        // factura
        $this->factura->setupEditAttributes();
        $this->factura->EditValue = $this->factura->CurrentValue;

        // unir_con_expediente
        $this->unir_con_expediente->setupEditAttributes();
        $this->unir_con_expediente->PlaceHolder = RemoveHtml($this->unir_con_expediente->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // funeraria
        $this->funeraria->setupEditAttributes();
        $this->funeraria->EditValue = $this->funeraria->options(true);
        $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());

        // servicio_tipo
        $this->servicio_tipo->setupEditAttributes();
        $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

        // servicio
        $this->servicio->setupEditAttributes();
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // marca_pasos
        $this->marca_pasos->setupEditAttributes();
        $this->marca_pasos->EditValue = $this->marca_pasos->options(true);
        $this->marca_pasos->PlaceHolder = RemoveHtml($this->marca_pasos->caption());

        // peso
        $this->peso->setupEditAttributes();
        $this->peso->PlaceHolder = RemoveHtml($this->peso->caption());

        // autoriza_cremar
        $this->autoriza_cremar->setupEditAttributes();
        $this->autoriza_cremar->EditValue = $this->autoriza_cremar->options(true);
        $this->autoriza_cremar->PlaceHolder = RemoveHtml($this->autoriza_cremar->caption());

        // certificado_defuncion
        $this->certificado_defuncion->setupEditAttributes();
        if (!$this->certificado_defuncion->Raw) {
            $this->certificado_defuncion->CurrentValue = HtmlDecode($this->certificado_defuncion->CurrentValue);
        }
        $this->certificado_defuncion->EditValue = $this->certificado_defuncion->CurrentValue;
        $this->certificado_defuncion->PlaceHolder = RemoveHtml($this->certificado_defuncion->caption());

        // parcela
        $this->parcela->setupEditAttributes();
        if (!$this->parcela->Raw) {
            $this->parcela->CurrentValue = HtmlDecode($this->parcela->CurrentValue);
        }
        $this->parcela->EditValue = $this->parcela->CurrentValue;
        $this->parcela->PlaceHolder = RemoveHtml($this->parcela->caption());

        // username_autoriza
        $this->username_autoriza->setupEditAttributes();
        $this->username_autoriza->EditValue = $this->username_autoriza->CurrentValue;
        $curVal = strval($this->username_autoriza->CurrentValue);
        if ($curVal != "") {
            $this->username_autoriza->EditValue = $this->username_autoriza->lookupCacheOption($curVal);
            if ($this->username_autoriza->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->username_autoriza->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->username_autoriza->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->username_autoriza->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->username_autoriza->Lookup->renderViewRow($rswrk[0]);
                    $this->username_autoriza->EditValue = $this->username_autoriza->displayValue($arwrk);
                } else {
                    $this->username_autoriza->EditValue = $this->username_autoriza->CurrentValue;
                }
            }
        } else {
            $this->username_autoriza->EditValue = null;
        }

        // fecha_autoriza
        $this->fecha_autoriza->setupEditAttributes();
        $this->fecha_autoriza->EditValue = $this->fecha_autoriza->CurrentValue;
        $this->fecha_autoriza->EditValue = FormatDateTime($this->fecha_autoriza->EditValue, $this->fecha_autoriza->formatPattern());

        // email_calidad
        $this->email_calidad->EditValue = $this->email_calidad->options(false);
        $this->email_calidad->PlaceHolder = RemoveHtml($this->email_calidad->caption());

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
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->parentesco_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
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
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->user_registra);
                    $doc->exportCaption($this->fecha_registro);
                } else {
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->contrato_parcela);
                    $doc->exportCaption($this->tipo_contratacion);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nacionalidad_contacto);
                    $doc->exportCaption($this->cedula_contacto);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->apellidos_contacto);
                    $doc->exportCaption($this->parentesco_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nacionalidad_fallecido);
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
                    $doc->exportCaption($this->religion);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->costos);
                    $doc->exportCaption($this->venta);
                    $doc->exportCaption($this->user_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->user_cierra);
                    $doc->exportCaption($this->fecha_cierre);
                    $doc->exportCaption($this->calidad);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->unir_con_expediente);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->funeraria);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->marca_pasos);
                    $doc->exportCaption($this->peso);
                    $doc->exportCaption($this->autoriza_cremar);
                    $doc->exportCaption($this->certificado_defuncion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->username_autoriza);
                    $doc->exportCaption($this->fecha_autoriza);
                    $doc->exportCaption($this->email_calidad);
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
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->parentesco_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
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
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->user_registra);
                        $doc->exportField($this->fecha_registro);
                    } else {
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->contrato_parcela);
                        $doc->exportField($this->tipo_contratacion);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nacionalidad_contacto);
                        $doc->exportField($this->cedula_contacto);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->apellidos_contacto);
                        $doc->exportField($this->parentesco_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nacionalidad_fallecido);
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
                        $doc->exportField($this->religion);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->costos);
                        $doc->exportField($this->venta);
                        $doc->exportField($this->user_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->user_cierra);
                        $doc->exportField($this->fecha_cierre);
                        $doc->exportField($this->calidad);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->unir_con_expediente);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->funeraria);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->marca_pasos);
                        $doc->exportField($this->peso);
                        $doc->exportField($this->autoriza_cremar);
                        $doc->exportField($this->certificado_defuncion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->username_autoriza);
                        $doc->exportField($this->fecha_autoriza);
                        $doc->exportField($this->email_calidad);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_expediente');
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
        $key .= $rs['Nexpediente'];

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
                WriteAuditLog($usr, "A", 'sco_expediente', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nexpediente'];

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
                    WriteAuditLog($usr, "U", 'sco_expediente', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nexpediente'];

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
                WriteAuditLog($usr, "D", 'sco_expediente', $fldname, $key, $oldvalue);
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
    	if(isset($_GET["id_exp"])) {
    		if(strlen(trim($_GET["id_exp"])) > 0) 
    			AddFilter($filter, "Nexpediente = '" . trim($_GET["id_exp"]) . "'");
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
    	$rsnew["parcela"] = trim(strtoupper($rsnew["parcela"]));
    	$rsnew["nombre_contacto"] = strtoupper($rsnew["nombre_contacto"]);
    	$rsnew["nombre_fallecido"] = strtoupper($rsnew["nombre_fallecido"]);
    	$rsnew["apellidos_fallecido"] = strtoupper($rsnew["apellidos_fallecido"]);
    	if(strtotime($rsnew["fecha_nacimiento"]) > strtotime(date("Y-m-d"))) {
    		$this->CancelMessage = "La Fecha de Nacimiento no puede ser mayor a la fecha actual";
    		return FALSE;
    	}
    	$rsnew["edad_fallecido"] = calc_edad($rsnew["fecha_nacimiento"]);
    	$rsnew["estatus"] = "1";
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
    	if($rsnew["servicio_tipo"] == "CREM" and $rsnew["marca_pasos"] == "") {
    		$this->CancelMessage = "Debe indicar si el difunto tiene marca paso o no para proceder con el proceso de cremaci&oacute;n.";
    		return FALSE;
    	}
        $rsnew["tipo_contratacion"] = "";
        $rsnew["nacionalidad_contacto"] = "";
        $rsnew["cedula_contacto"] = "";
        $rsnew["apellidos_contacto"] = "";
        $rsnew["user_registra"] = CurrentUserName();
        $rsnew["fecha_registro"] = date("Y-m-d H:i:s");
    	return TRUE;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew) {
    	//echo "Row Inserted"
    	cambiar_estatus($rsnew["Nexpediente"], $rsnew["estatus"]);
    	if($rsnew["funeraria"] == 1) {
    		$sql = "INSERT INTO sco_entrada_salida
    					(Nentrada_salida, tipo_doc, proveedor, clasificacion, documento, fecha, nota, username, monto, registro)
    				VALUES (NULL, 'EXOU', -1, 'EXPE', '" . $rsnew["Nexpediente"] . "', NOW(), 'SALIDA AUTOMATICA POR CREACION DE Exp.: " . $rsnew["Nexpediente"] . "', '" . CurrentUserName() . "', 0, now());";
    		Execute($sql);
    		$sql = "SELECT LAST_INSERT_ID()";
    		$idSali = ExecuteScalar($sql);
    		$sql = "INSERT INTO sco_entrada_salida_detalle
    					(Nentrada_salida_detalle, entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
    				VALUES (NULL, $idSali, 'EXOU', -1, 'FUNE000001', -1, 0, 0);";
    		Execute($sql);
    	}
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew) {
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	$rsnew["parcela"] = trim(strtoupper($rsnew["parcela"]));
    	if(($rsold["estatus"] == 6 or $rsold["estatus"] == 7) and CurrentUserLevel() > 0) {
    		$this->CancelMessage = "Este registro est&aacute; cerrado; no se puede modificar.";
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
    	if($rsnew["servicio_tipo"] == "CREM" and $rsnew["marca_pasos"] == "") {
    		$this->CancelMessage = "Debe indicar si el difunto tiene marca paso o no para proceder con el proceso de cremaci&oacute;n.";
    		return FALSE;
    	}
    	if($rsnew["autoriza_cremar"] == "N" and $rsold["autoriza_cremar"] == "S") {
    		$value = ExecuteScalar("SELECT valor2 FROM sco_parametro WHERE codigo = '033';");
    		$arr = explode(",", $value);
    		for($i=0; $i<count($arr); $i++) {
    			if($arr[$i] == CurrentUserLevel()) return TRUE;
    		}
    		$this->CancelMessage = "Debe tener permiso para activar la impresi&oacute;n de Autorizaci&oacute;n de Cremaci&oacute;n. Vaya a la tabla par&aacute;metros.";
    		return FALSE;
    	}
    	return TRUE;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
    	//echo "Row Updated";
    	if($rsold["estatus"] != $rsnew["estatus"])
    		cambiar_estatus($rsold["Nexpediente"], $rsnew["estatus"]);
    	if($rsnew["estatus"] == 7) {
    		$sql = "INSERT INTO sco_entrada_salida
    					(Nentrada_salida, tipo_doc, proveedor, clasificacion, documento, fecha, nota, username, monto, registro)
    				VALUES (NULL, 'EXIN', -1, 'EXPE', '" . $rsold["Nexpediente"] . "', NOW(), 'ENTRADA AUTOMATICA POR ANULACION DE Exp.: " . $rsold["Nexpediente"] . "', '" . CurrentUserName() . "', 0, now())";
    		Execute($sql);
    		$sql = "SELECT LAST_INSERT_ID()";
    		$idSali = ExecuteScalar($sql);
    		$sql = "INSERT INTO sco_entrada_salida_detalle
    					(Nentrada_salida_detalle, entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
    				VALUES (NULL, $idSali, 'EXIN', -1, 'FUNE000001', 1, 0, 0)";
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
    	if($rs["estatus"] == 6 OR $rs["estatus"] == 7) {
    		$this->CancelMessage = "Este registro est&aacute; cerrado; no se puede modificar.";
    		return FALSE;
    	}
    	$sql = "select count(*) as total from sco_orden where expediente = '".$rs["Nexpediente"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay ordenes asociadas a este expediente, no se puede eliminar.";
    		return FALSE;
    	}
    	$sql = "select count(*) as total from sco_nota where expediente = '".$rs["Nexpediente"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay notas asociadas a este expediente, no se puede eliminar.";
    		return FALSE;
    	}
    	$sql = "select count(*) as total from sco_seguimiento where expediente = '".$rs["Nexpediente"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay seguimientos asociados a este expediente, no se puede eliminar.";
    		return FALSE;
    	}
    	$sql = "select count(*) as total from sco_expediente_estatus where expediente = '".$rs["Nexpediente"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay estatus de monitoreo asociados a este expediente, no se puede eliminar.";
    		return FALSE;
    	}
    	$sql = "select count(*) as total from sco_adjunto where expediente = '".$rs["Nexpediente"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay adjuntos asociados a este expediente, no se puede eliminar.";
    		return FALSE;
    	}
    	return TRUE;
    }

    // Row Deleted event
    public function rowDeleted($rs) {
    	//echo "Row Deleted";
    	$sql = "INSERT INTO sco_entrada_salida
    					(Nentrada_salida, tipo_doc, proveedor, clasificacion, documento, fecha, nota, username, monto, registro)
    				VALUES (NULL, 'EXIN', -1, 'EXPE', '" . $rsnew["Nexpediente"] . "', NOW(), 'ENTRADA AUTOMATICA POR ELIMINACION DE Exp.: " . $rs["Nexpediente"] . "', '" . CurrentUserName() . "', 0, now())";
    	Execute($sql);
    	$sql = "SELECT LAST_INSERT_ID()";
    	$idSali = ExecuteScalar($sql);
    	$sql = "INSERT INTO sco_entrada_salida_detalle
    					(Nentrada_salida_detalle, entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
    				VALUES (NULL, $idSali, 'EXIN', -1, 'FUNE000001', 1, 0, 0)";
    	Execute($sql);
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
    	if($this->estatus->CurrentValue != 7) { 
    		$sql = "SELECT count(paso) as pasos FROM sco_orden WHERE expediente = '" . $this->Nexpediente->CurrentValue . "' AND paso IN (1,2);";
    		$valor = ExecuteScalar($sql); 
    		if($valor == 0) 
    		$this->Nexpediente->CellAttrs["style"] = "background-color: #fe4848";

    		// Valido que el servicio de velación este asociado a 2 o más capillas
    		$sql = "SELECT count(paso) as pasos FROM sco_orden WHERE expediente = '" . $this->Nexpediente->CurrentValue . "' AND paso = 1;";
    		$valor = ExecuteScalar($sql); 
    		if($valor >= 2) {
    			$this->Nexpediente->CellAttrs["style"] = "background-color: #ffff00";
    		}
    	}

    	// Valido que el servicio de velación esté asociado con otro expediente
    	if($this->unir_con_expediente->CurrentValue != "" and $this->unir_con_expediente->CurrentValue != "0") 
    		$this->Nexpediente->CellAttrs["style"] = "background-color: #CC99CC";

    	// Valido que esté facturado
    	if($this->factura->CurrentValue != "") 
    		$this->venta->CellAttrs["style"] = "color: white; background-color: #009900";

    	// Change the table cell color
    	if ($this->PageID == "list" || $this->PageID == "view") { // List/View page only
    		$sql = "select
    					color
    				from
    					sco_estatus
    				where
    					Nstatus = '".$this->estatus->CurrentValue."';";
    		$color = ExecuteScalar($sql);
    		$style = "background-color: $color"; 	
    		$this->estatus->CellAttrs["style"] = $style;
    		 $this->nacionalidad_fallecido->CellAttrs["style"] = $style;
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
    		 $this->hora_ocurrencia->CellAttrs["style"] = $style;
    		 $this->causa_ocurrencia->CellAttrs["style"] = $style;
    		 $this->descripcion_ocurrencia->CellAttrs["style"] = $style;
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
