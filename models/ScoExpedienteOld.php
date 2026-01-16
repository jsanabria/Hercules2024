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
 * Table class for sco_expediente_old
 */
class ScoExpedienteOld extends DbTable
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
    public $tipo_contratacion;
    public $seguro;
    public $nacionalidad_contacto;
    public $cedula_contacto;
    public $nombre_contacto;
    public $apellidos_contacto;
    public $parentesco_contacto;
    public $telefono_contacto1;
    public $telefono_contacto2;
    public $nacionalidad_fallecido;
    public $cedula_fallecido;
    public $sexo;
    public $nombre_fallecido;
    public $apellidos_fallecido;
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
    public $calidad;
    public $costos;
    public $venta;
    public $user_registra;
    public $fecha_registro;
    public $user_cierra;
    public $fecha_cierre;
    public $estatus;
    public $factura;
    public $permiso;
    public $unir_con_expediente;
    public $nota;
    public $_email;
    public $religion;
    public $servicio_tipo;
    public $servicio;
    public $funeraria;
    public $marca_pasos;
    public $autoriza_cremar;
    public $username_autoriza;
    public $fecha_autoriza;
    public $peso;
    public $contrato_parcela;
    public $email_calidad;
    public $certificado_defuncion;
    public $parcela;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_expediente_old";
        $this->TableName = 'sco_expediente_old';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_expediente_old";
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
        $this->Nexpediente->Nullable = false; // NOT NULL field
        $this->Nexpediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nexpediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nexpediente'] = &$this->Nexpediente;

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
            'TEXT' // Edit Tag
        );
        $this->tipo_contratacion->InputTextType = "text";
        $this->tipo_contratacion->Nullable = false; // NOT NULL field
        $this->tipo_contratacion->Required = true; // Required field
        $this->tipo_contratacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
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
            'TEXT' // Edit Tag
        );
        $this->seguro->InputTextType = "text";
        $this->seguro->Raw = true;
        $this->seguro->Nullable = false; // NOT NULL field
        $this->seguro->Required = true; // Required field
        $this->seguro->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->seguro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
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
            'TEXT' // Edit Tag
        );
        $this->nacionalidad_contacto->InputTextType = "text";
        $this->nacionalidad_contacto->Nullable = false; // NOT NULL field
        $this->nacionalidad_contacto->Required = true; // Required field
        $this->nacionalidad_contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
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
            'TEXT' // Edit Tag
        );
        $this->parentesco_contacto->InputTextType = "text";
        $this->parentesco_contacto->Nullable = false; // NOT NULL field
        $this->parentesco_contacto->Required = true; // Required field
        $this->parentesco_contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
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
            'TEXT' // Edit Tag
        );
        $this->nacionalidad_fallecido->InputTextType = "text";
        $this->nacionalidad_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
        $this->cedula_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula_fallecido'] = &$this->cedula_fallecido;

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
            'TEXT' // Edit Tag
        );
        $this->sexo->InputTextType = "text";
        $this->sexo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['sexo'] = &$this->sexo;

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
        $this->apellidos_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['apellidos_fallecido'] = &$this->apellidos_fallecido;

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
            'TEXT' // Edit Tag
        );
        $this->estado_civil->InputTextType = "text";
        $this->estado_civil->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->lugar_ocurrencia->InputTextType = "text";
        $this->lugar_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
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
        $this->fecha_ocurrencia->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_ocurrencia'] = &$this->fecha_ocurrencia;

        // hora_ocurrencia
        $this->hora_ocurrencia = new DbField(
            $this, // Table
            'x_hora_ocurrencia', // Variable name
            'hora_ocurrencia', // Name
            '`hora_ocurrencia`', // Expression
            CastDateFieldForLike("`hora_ocurrencia`", 4, "DB"), // Basic search expression
            134, // Type
            10, // Size
            4, // Date/Time format
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
        $this->hora_ocurrencia->DefaultErrorMessage = str_replace("%s", DateFormat(4), $Language->phrase("IncorrectTime"));
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
            'TEXT' // Edit Tag
        );
        $this->causa_ocurrencia->InputTextType = "text";
        $this->causa_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->descripcion_ocurrencia->InputTextType = "text";
        $this->descripcion_ocurrencia->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['descripcion_ocurrencia'] = &$this->descripcion_ocurrencia;

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
            'TEXT' // Edit Tag
        );
        $this->calidad->InputTextType = "text";
        $this->calidad->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['calidad'] = &$this->calidad;

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
        $this->user_registra->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_registra'] = &$this->user_registra;

        // fecha_registro
        $this->fecha_registro = new DbField(
            $this, // Table
            'x_fecha_registro', // Variable name
            'fecha_registro', // Name
            '`fecha_registro`', // Expression
            CastDateFieldForLike("`fecha_registro`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
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
        $this->fecha_registro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
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
        $this->user_cierra->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_cierra'] = &$this->user_cierra;

        // fecha_cierre
        $this->fecha_cierre = new DbField(
            $this, // Table
            'x_fecha_cierre', // Variable name
            'fecha_cierre', // Name
            '`fecha_cierre`', // Expression
            CastDateFieldForLike("`fecha_cierre`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
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
        $this->fecha_cierre->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_cierre->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_cierre'] = &$this->fecha_cierre;

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
            'TEXT' // Edit Tag
        );
        $this->estatus->InputTextType = "text";
        $this->estatus->Raw = true;
        $this->estatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estatus->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

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
            'TEXT' // Edit Tag
        );
        $this->unir_con_expediente->InputTextType = "text";
        $this->unir_con_expediente->Raw = true;
        $this->unir_con_expediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->unir_con_expediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['unir_con_expediente'] = &$this->unir_con_expediente;

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
            'TEXT' // Edit Tag
        );
        $this->nota->InputTextType = "text";
        $this->nota->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nota'] = &$this->nota;

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
        $this->_email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['email'] = &$this->_email;

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
            'TEXT' // Edit Tag
        );
        $this->religion->InputTextType = "text";
        $this->religion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->servicio_tipo->InputTextType = "text";
        $this->servicio_tipo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
            'TEXT' // Edit Tag
        );
        $this->servicio->InputTextType = "text";
        $this->servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio'] = &$this->servicio;

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
            'TEXT' // Edit Tag
        );
        $this->funeraria->InputTextType = "text";
        $this->funeraria->Raw = true;
        $this->funeraria->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->funeraria->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['funeraria'] = &$this->funeraria;

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
            'RADIO' // Edit Tag
        );
        $this->marca_pasos->addMethod("getDefault", fn() => "N");
        $this->marca_pasos->InputTextType = "text";
        $this->marca_pasos->Raw = true;
        $this->marca_pasos->Lookup = new Lookup($this->marca_pasos, 'sco_expediente_old', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->marca_pasos->OptionCount = 2;
        $this->marca_pasos->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['marca_pasos'] = &$this->marca_pasos;

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
            'RADIO' // Edit Tag
        );
        $this->autoriza_cremar->addMethod("getDefault", fn() => "N");
        $this->autoriza_cremar->InputTextType = "text";
        $this->autoriza_cremar->Raw = true;
        $this->autoriza_cremar->Lookup = new Lookup($this->autoriza_cremar, 'sco_expediente_old', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->autoriza_cremar->OptionCount = 2;
        $this->autoriza_cremar->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['autoriza_cremar'] = &$this->autoriza_cremar;

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
            'TEXT' // Edit Tag
        );
        $this->peso->InputTextType = "text";
        $this->peso->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['peso'] = &$this->peso;

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
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contrato_parcela->InputTextType = "text";
        $this->contrato_parcela->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contrato_parcela'] = &$this->contrato_parcela;

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
        $this->email_calidad->Lookup = new Lookup($this->email_calidad, 'sco_expediente_old', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->email_calidad->OptionCount = 2;
        $this->email_calidad->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['email_calidad'] = &$this->email_calidad;

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

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_expediente_old";
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
        return $success;
    }

    // Load DbValue from result set or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->Nexpediente->DbValue = $row['Nexpediente'];
        $this->tipo_contratacion->DbValue = $row['tipo_contratacion'];
        $this->seguro->DbValue = $row['seguro'];
        $this->nacionalidad_contacto->DbValue = $row['nacionalidad_contacto'];
        $this->cedula_contacto->DbValue = $row['cedula_contacto'];
        $this->nombre_contacto->DbValue = $row['nombre_contacto'];
        $this->apellidos_contacto->DbValue = $row['apellidos_contacto'];
        $this->parentesco_contacto->DbValue = $row['parentesco_contacto'];
        $this->telefono_contacto1->DbValue = $row['telefono_contacto1'];
        $this->telefono_contacto2->DbValue = $row['telefono_contacto2'];
        $this->nacionalidad_fallecido->DbValue = $row['nacionalidad_fallecido'];
        $this->cedula_fallecido->DbValue = $row['cedula_fallecido'];
        $this->sexo->DbValue = $row['sexo'];
        $this->nombre_fallecido->DbValue = $row['nombre_fallecido'];
        $this->apellidos_fallecido->DbValue = $row['apellidos_fallecido'];
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
        $this->calidad->DbValue = $row['calidad'];
        $this->costos->DbValue = $row['costos'];
        $this->venta->DbValue = $row['venta'];
        $this->user_registra->DbValue = $row['user_registra'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->user_cierra->DbValue = $row['user_cierra'];
        $this->fecha_cierre->DbValue = $row['fecha_cierre'];
        $this->estatus->DbValue = $row['estatus'];
        $this->factura->DbValue = $row['factura'];
        $this->permiso->DbValue = $row['permiso'];
        $this->unir_con_expediente->DbValue = $row['unir_con_expediente'];
        $this->nota->DbValue = $row['nota'];
        $this->_email->DbValue = $row['email'];
        $this->religion->DbValue = $row['religion'];
        $this->servicio_tipo->DbValue = $row['servicio_tipo'];
        $this->servicio->DbValue = $row['servicio'];
        $this->funeraria->DbValue = $row['funeraria'];
        $this->marca_pasos->DbValue = $row['marca_pasos'];
        $this->autoriza_cremar->DbValue = $row['autoriza_cremar'];
        $this->username_autoriza->DbValue = $row['username_autoriza'];
        $this->fecha_autoriza->DbValue = $row['fecha_autoriza'];
        $this->peso->DbValue = $row['peso'];
        $this->contrato_parcela->DbValue = $row['contrato_parcela'];
        $this->email_calidad->DbValue = $row['email_calidad'];
        $this->certificado_defuncion->DbValue = $row['certificado_defuncion'];
        $this->parcela->DbValue = $row['parcela'];
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
        return $_SESSION[$name] ?? GetUrl("ScoExpedienteOldList");
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
            "ScoExpedienteOldView" => $Language->phrase("View"),
            "ScoExpedienteOldEdit" => $Language->phrase("Edit"),
            "ScoExpedienteOldAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoExpedienteOldList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoExpedienteOldView",
            Config("API_ADD_ACTION") => "ScoExpedienteOldAdd",
            Config("API_EDIT_ACTION") => "ScoExpedienteOldEdit",
            Config("API_DELETE_ACTION") => "ScoExpedienteOldDelete",
            Config("API_LIST_ACTION") => "ScoExpedienteOldList",
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
        return "ScoExpedienteOldList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoExpedienteOldView", $parm);
        } else {
            $url = $this->keyUrl("ScoExpedienteOldView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoExpedienteOldAdd?" . $parm;
        } else {
            $url = "ScoExpedienteOldAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoExpedienteOldEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoExpedienteOldList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoExpedienteOldAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoExpedienteOldList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoExpedienteOldDelete", $parm);
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
        $this->tipo_contratacion->setDbValue($row['tipo_contratacion']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nacionalidad_contacto->setDbValue($row['nacionalidad_contacto']);
        $this->cedula_contacto->setDbValue($row['cedula_contacto']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->apellidos_contacto->setDbValue($row['apellidos_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->nacionalidad_fallecido->setDbValue($row['nacionalidad_fallecido']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
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
        $this->calidad->setDbValue($row['calidad']);
        $this->costos->setDbValue($row['costos']);
        $this->venta->setDbValue($row['venta']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_cierra->setDbValue($row['user_cierra']);
        $this->fecha_cierre->setDbValue($row['fecha_cierre']);
        $this->estatus->setDbValue($row['estatus']);
        $this->factura->setDbValue($row['factura']);
        $this->permiso->setDbValue($row['permiso']);
        $this->unir_con_expediente->setDbValue($row['unir_con_expediente']);
        $this->nota->setDbValue($row['nota']);
        $this->_email->setDbValue($row['email']);
        $this->religion->setDbValue($row['religion']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->marca_pasos->setDbValue($row['marca_pasos']);
        $this->autoriza_cremar->setDbValue($row['autoriza_cremar']);
        $this->username_autoriza->setDbValue($row['username_autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->peso->setDbValue($row['peso']);
        $this->contrato_parcela->setDbValue($row['contrato_parcela']);
        $this->email_calidad->setDbValue($row['email_calidad']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->parcela->setDbValue($row['parcela']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoExpedienteOldList";
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

        // tipo_contratacion

        // seguro

        // nacionalidad_contacto

        // cedula_contacto

        // nombre_contacto

        // apellidos_contacto

        // parentesco_contacto

        // telefono_contacto1

        // telefono_contacto2

        // nacionalidad_fallecido

        // cedula_fallecido

        // sexo

        // nombre_fallecido

        // apellidos_fallecido

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

        // calidad

        // costos

        // venta

        // user_registra

        // fecha_registro

        // user_cierra

        // fecha_cierre

        // estatus

        // factura

        // permiso

        // unir_con_expediente

        // nota

        // email

        // religion

        // servicio_tipo

        // servicio

        // funeraria

        // marca_pasos

        // autoriza_cremar

        // username_autoriza

        // fecha_autoriza

        // peso

        // contrato_parcela

        // email_calidad

        // certificado_defuncion

        // parcela

        // Nexpediente
        $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

        // tipo_contratacion
        $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->CurrentValue;

        // seguro
        $this->seguro->ViewValue = $this->seguro->CurrentValue;
        $this->seguro->ViewValue = FormatNumber($this->seguro->ViewValue, $this->seguro->formatPattern());

        // nacionalidad_contacto
        $this->nacionalidad_contacto->ViewValue = $this->nacionalidad_contacto->CurrentValue;

        // cedula_contacto
        $this->cedula_contacto->ViewValue = $this->cedula_contacto->CurrentValue;

        // nombre_contacto
        $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

        // apellidos_contacto
        $this->apellidos_contacto->ViewValue = $this->apellidos_contacto->CurrentValue;

        // parentesco_contacto
        $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->CurrentValue;

        // telefono_contacto1
        $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

        // telefono_contacto2
        $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->ViewValue = $this->nacionalidad_fallecido->CurrentValue;

        // cedula_fallecido
        $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

        // sexo
        $this->sexo->ViewValue = $this->sexo->CurrentValue;

        // nombre_fallecido
        $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

        // apellidos_fallecido
        $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

        // fecha_nacimiento
        $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
        $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

        // edad_fallecido
        $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;
        $this->edad_fallecido->ViewValue = FormatNumber($this->edad_fallecido->ViewValue, $this->edad_fallecido->formatPattern());

        // estado_civil
        $this->estado_civil->ViewValue = $this->estado_civil->CurrentValue;

        // lugar_nacimiento_fallecido
        $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;

        // lugar_ocurrencia
        $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->CurrentValue;

        // direccion_ocurrencia
        $this->direccion_ocurrencia->ViewValue = $this->direccion_ocurrencia->CurrentValue;

        // fecha_ocurrencia
        $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
        $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

        // hora_ocurrencia
        $this->hora_ocurrencia->ViewValue = $this->hora_ocurrencia->CurrentValue;
        $this->hora_ocurrencia->ViewValue = FormatDateTime($this->hora_ocurrencia->ViewValue, $this->hora_ocurrencia->formatPattern());

        // causa_ocurrencia
        $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

        // causa_otro
        $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

        // descripcion_ocurrencia
        $this->descripcion_ocurrencia->ViewValue = $this->descripcion_ocurrencia->CurrentValue;

        // calidad
        $this->calidad->ViewValue = $this->calidad->CurrentValue;

        // costos
        $this->costos->ViewValue = $this->costos->CurrentValue;
        $this->costos->ViewValue = FormatNumber($this->costos->ViewValue, $this->costos->formatPattern());

        // venta
        $this->venta->ViewValue = $this->venta->CurrentValue;
        $this->venta->ViewValue = FormatNumber($this->venta->ViewValue, $this->venta->formatPattern());

        // user_registra
        $this->user_registra->ViewValue = $this->user_registra->CurrentValue;

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

        // user_cierra
        $this->user_cierra->ViewValue = $this->user_cierra->CurrentValue;

        // fecha_cierre
        $this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
        $this->fecha_cierre->ViewValue = FormatDateTime($this->fecha_cierre->ViewValue, $this->fecha_cierre->formatPattern());

        // estatus
        $this->estatus->ViewValue = $this->estatus->CurrentValue;
        $this->estatus->ViewValue = FormatNumber($this->estatus->ViewValue, $this->estatus->formatPattern());

        // factura
        $this->factura->ViewValue = $this->factura->CurrentValue;

        // permiso
        $this->permiso->ViewValue = $this->permiso->CurrentValue;

        // unir_con_expediente
        $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->CurrentValue;
        $this->unir_con_expediente->ViewValue = FormatNumber($this->unir_con_expediente->ViewValue, $this->unir_con_expediente->formatPattern());

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // religion
        $this->religion->ViewValue = $this->religion->CurrentValue;

        // servicio_tipo
        $this->servicio_tipo->ViewValue = $this->servicio_tipo->CurrentValue;

        // servicio
        $this->servicio->ViewValue = $this->servicio->CurrentValue;

        // funeraria
        $this->funeraria->ViewValue = $this->funeraria->CurrentValue;
        $this->funeraria->ViewValue = FormatNumber($this->funeraria->ViewValue, $this->funeraria->formatPattern());

        // marca_pasos
        if (strval($this->marca_pasos->CurrentValue) != "") {
            $this->marca_pasos->ViewValue = $this->marca_pasos->optionCaption($this->marca_pasos->CurrentValue);
        } else {
            $this->marca_pasos->ViewValue = null;
        }

        // autoriza_cremar
        if (strval($this->autoriza_cremar->CurrentValue) != "") {
            $this->autoriza_cremar->ViewValue = $this->autoriza_cremar->optionCaption($this->autoriza_cremar->CurrentValue);
        } else {
            $this->autoriza_cremar->ViewValue = null;
        }

        // username_autoriza
        $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;

        // fecha_autoriza
        $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
        $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

        // peso
        $this->peso->ViewValue = $this->peso->CurrentValue;

        // contrato_parcela
        $this->contrato_parcela->ViewValue = $this->contrato_parcela->CurrentValue;

        // email_calidad
        if (strval($this->email_calidad->CurrentValue) != "") {
            $this->email_calidad->ViewValue = $this->email_calidad->optionCaption($this->email_calidad->CurrentValue);
        } else {
            $this->email_calidad->ViewValue = null;
        }

        // certificado_defuncion
        $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

        // parcela
        $this->parcela->ViewValue = $this->parcela->CurrentValue;

        // Nexpediente
        $this->Nexpediente->HrefValue = "";
        $this->Nexpediente->TooltipValue = "";

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

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->HrefValue = "";
        $this->nacionalidad_fallecido->TooltipValue = "";

        // cedula_fallecido
        $this->cedula_fallecido->HrefValue = "";
        $this->cedula_fallecido->TooltipValue = "";

        // sexo
        $this->sexo->HrefValue = "";
        $this->sexo->TooltipValue = "";

        // nombre_fallecido
        $this->nombre_fallecido->HrefValue = "";
        $this->nombre_fallecido->TooltipValue = "";

        // apellidos_fallecido
        $this->apellidos_fallecido->HrefValue = "";
        $this->apellidos_fallecido->TooltipValue = "";

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

        // calidad
        $this->calidad->HrefValue = "";
        $this->calidad->TooltipValue = "";

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

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // factura
        $this->factura->HrefValue = "";
        $this->factura->TooltipValue = "";

        // permiso
        $this->permiso->HrefValue = "";
        $this->permiso->TooltipValue = "";

        // unir_con_expediente
        $this->unir_con_expediente->HrefValue = "";
        $this->unir_con_expediente->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // religion
        $this->religion->HrefValue = "";
        $this->religion->TooltipValue = "";

        // servicio_tipo
        $this->servicio_tipo->HrefValue = "";
        $this->servicio_tipo->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // funeraria
        $this->funeraria->HrefValue = "";
        $this->funeraria->TooltipValue = "";

        // marca_pasos
        $this->marca_pasos->HrefValue = "";
        $this->marca_pasos->TooltipValue = "";

        // autoriza_cremar
        $this->autoriza_cremar->HrefValue = "";
        $this->autoriza_cremar->TooltipValue = "";

        // username_autoriza
        $this->username_autoriza->HrefValue = "";
        $this->username_autoriza->TooltipValue = "";

        // fecha_autoriza
        $this->fecha_autoriza->HrefValue = "";
        $this->fecha_autoriza->TooltipValue = "";

        // peso
        $this->peso->HrefValue = "";
        $this->peso->TooltipValue = "";

        // contrato_parcela
        $this->contrato_parcela->HrefValue = "";
        $this->contrato_parcela->TooltipValue = "";

        // email_calidad
        $this->email_calidad->HrefValue = "";
        $this->email_calidad->TooltipValue = "";

        // certificado_defuncion
        $this->certificado_defuncion->HrefValue = "";
        $this->certificado_defuncion->TooltipValue = "";

        // parcela
        $this->parcela->HrefValue = "";
        $this->parcela->TooltipValue = "";

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

        // tipo_contratacion
        $this->tipo_contratacion->setupEditAttributes();
        if (!$this->tipo_contratacion->Raw) {
            $this->tipo_contratacion->CurrentValue = HtmlDecode($this->tipo_contratacion->CurrentValue);
        }
        $this->tipo_contratacion->EditValue = $this->tipo_contratacion->CurrentValue;
        $this->tipo_contratacion->PlaceHolder = RemoveHtml($this->tipo_contratacion->caption());

        // seguro
        $this->seguro->setupEditAttributes();
        $this->seguro->EditValue = $this->seguro->CurrentValue;
        $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());
        if (strval($this->seguro->EditValue) != "" && is_numeric($this->seguro->EditValue)) {
            $this->seguro->EditValue = FormatNumber($this->seguro->EditValue, null);
        }

        // nacionalidad_contacto
        $this->nacionalidad_contacto->setupEditAttributes();
        if (!$this->nacionalidad_contacto->Raw) {
            $this->nacionalidad_contacto->CurrentValue = HtmlDecode($this->nacionalidad_contacto->CurrentValue);
        }
        $this->nacionalidad_contacto->EditValue = $this->nacionalidad_contacto->CurrentValue;
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
        if (!$this->parentesco_contacto->Raw) {
            $this->parentesco_contacto->CurrentValue = HtmlDecode($this->parentesco_contacto->CurrentValue);
        }
        $this->parentesco_contacto->EditValue = $this->parentesco_contacto->CurrentValue;
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

        // nacionalidad_fallecido
        $this->nacionalidad_fallecido->setupEditAttributes();
        if (!$this->nacionalidad_fallecido->Raw) {
            $this->nacionalidad_fallecido->CurrentValue = HtmlDecode($this->nacionalidad_fallecido->CurrentValue);
        }
        $this->nacionalidad_fallecido->EditValue = $this->nacionalidad_fallecido->CurrentValue;
        $this->nacionalidad_fallecido->PlaceHolder = RemoveHtml($this->nacionalidad_fallecido->caption());

        // cedula_fallecido
        $this->cedula_fallecido->setupEditAttributes();
        if (!$this->cedula_fallecido->Raw) {
            $this->cedula_fallecido->CurrentValue = HtmlDecode($this->cedula_fallecido->CurrentValue);
        }
        $this->cedula_fallecido->EditValue = $this->cedula_fallecido->CurrentValue;
        $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

        // sexo
        $this->sexo->setupEditAttributes();
        if (!$this->sexo->Raw) {
            $this->sexo->CurrentValue = HtmlDecode($this->sexo->CurrentValue);
        }
        $this->sexo->EditValue = $this->sexo->CurrentValue;
        $this->sexo->PlaceHolder = RemoveHtml($this->sexo->caption());

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

        // fecha_nacimiento
        $this->fecha_nacimiento->setupEditAttributes();
        $this->fecha_nacimiento->EditValue = FormatDateTime($this->fecha_nacimiento->CurrentValue, $this->fecha_nacimiento->formatPattern());
        $this->fecha_nacimiento->PlaceHolder = RemoveHtml($this->fecha_nacimiento->caption());

        // edad_fallecido
        $this->edad_fallecido->setupEditAttributes();
        $this->edad_fallecido->EditValue = $this->edad_fallecido->CurrentValue;
        $this->edad_fallecido->PlaceHolder = RemoveHtml($this->edad_fallecido->caption());
        if (strval($this->edad_fallecido->EditValue) != "" && is_numeric($this->edad_fallecido->EditValue)) {
            $this->edad_fallecido->EditValue = FormatNumber($this->edad_fallecido->EditValue, null);
        }

        // estado_civil
        $this->estado_civil->setupEditAttributes();
        if (!$this->estado_civil->Raw) {
            $this->estado_civil->CurrentValue = HtmlDecode($this->estado_civil->CurrentValue);
        }
        $this->estado_civil->EditValue = $this->estado_civil->CurrentValue;
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
        if (!$this->lugar_ocurrencia->Raw) {
            $this->lugar_ocurrencia->CurrentValue = HtmlDecode($this->lugar_ocurrencia->CurrentValue);
        }
        $this->lugar_ocurrencia->EditValue = $this->lugar_ocurrencia->CurrentValue;
        $this->lugar_ocurrencia->PlaceHolder = RemoveHtml($this->lugar_ocurrencia->caption());

        // direccion_ocurrencia
        $this->direccion_ocurrencia->setupEditAttributes();
        if (!$this->direccion_ocurrencia->Raw) {
            $this->direccion_ocurrencia->CurrentValue = HtmlDecode($this->direccion_ocurrencia->CurrentValue);
        }
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
        if (!$this->causa_ocurrencia->Raw) {
            $this->causa_ocurrencia->CurrentValue = HtmlDecode($this->causa_ocurrencia->CurrentValue);
        }
        $this->causa_ocurrencia->EditValue = $this->causa_ocurrencia->CurrentValue;
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
        if (!$this->descripcion_ocurrencia->Raw) {
            $this->descripcion_ocurrencia->CurrentValue = HtmlDecode($this->descripcion_ocurrencia->CurrentValue);
        }
        $this->descripcion_ocurrencia->EditValue = $this->descripcion_ocurrencia->CurrentValue;
        $this->descripcion_ocurrencia->PlaceHolder = RemoveHtml($this->descripcion_ocurrencia->caption());

        // calidad
        $this->calidad->setupEditAttributes();
        if (!$this->calidad->Raw) {
            $this->calidad->CurrentValue = HtmlDecode($this->calidad->CurrentValue);
        }
        $this->calidad->EditValue = $this->calidad->CurrentValue;
        $this->calidad->PlaceHolder = RemoveHtml($this->calidad->caption());

        // costos
        $this->costos->setupEditAttributes();
        $this->costos->EditValue = $this->costos->CurrentValue;
        $this->costos->PlaceHolder = RemoveHtml($this->costos->caption());
        if (strval($this->costos->EditValue) != "" && is_numeric($this->costos->EditValue)) {
            $this->costos->EditValue = FormatNumber($this->costos->EditValue, null);
        }

        // venta
        $this->venta->setupEditAttributes();
        $this->venta->EditValue = $this->venta->CurrentValue;
        $this->venta->PlaceHolder = RemoveHtml($this->venta->caption());
        if (strval($this->venta->EditValue) != "" && is_numeric($this->venta->EditValue)) {
            $this->venta->EditValue = FormatNumber($this->venta->EditValue, null);
        }

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

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->CurrentValue;
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());
        if (strval($this->estatus->EditValue) != "" && is_numeric($this->estatus->EditValue)) {
            $this->estatus->EditValue = FormatNumber($this->estatus->EditValue, null);
        }

        // factura
        $this->factura->setupEditAttributes();
        if (!$this->factura->Raw) {
            $this->factura->CurrentValue = HtmlDecode($this->factura->CurrentValue);
        }
        $this->factura->EditValue = $this->factura->CurrentValue;
        $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

        // permiso
        $this->permiso->setupEditAttributes();
        if (!$this->permiso->Raw) {
            $this->permiso->CurrentValue = HtmlDecode($this->permiso->CurrentValue);
        }
        $this->permiso->EditValue = $this->permiso->CurrentValue;
        $this->permiso->PlaceHolder = RemoveHtml($this->permiso->caption());

        // unir_con_expediente
        $this->unir_con_expediente->setupEditAttributes();
        $this->unir_con_expediente->EditValue = $this->unir_con_expediente->CurrentValue;
        $this->unir_con_expediente->PlaceHolder = RemoveHtml($this->unir_con_expediente->caption());
        if (strval($this->unir_con_expediente->EditValue) != "" && is_numeric($this->unir_con_expediente->EditValue)) {
            $this->unir_con_expediente->EditValue = FormatNumber($this->unir_con_expediente->EditValue, null);
        }

        // nota
        $this->nota->setupEditAttributes();
        if (!$this->nota->Raw) {
            $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
        }
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // religion
        $this->religion->setupEditAttributes();
        if (!$this->religion->Raw) {
            $this->religion->CurrentValue = HtmlDecode($this->religion->CurrentValue);
        }
        $this->religion->EditValue = $this->religion->CurrentValue;
        $this->religion->PlaceHolder = RemoveHtml($this->religion->caption());

        // servicio_tipo
        $this->servicio_tipo->setupEditAttributes();
        if (!$this->servicio_tipo->Raw) {
            $this->servicio_tipo->CurrentValue = HtmlDecode($this->servicio_tipo->CurrentValue);
        }
        $this->servicio_tipo->EditValue = $this->servicio_tipo->CurrentValue;
        $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

        // servicio
        $this->servicio->setupEditAttributes();
        if (!$this->servicio->Raw) {
            $this->servicio->CurrentValue = HtmlDecode($this->servicio->CurrentValue);
        }
        $this->servicio->EditValue = $this->servicio->CurrentValue;
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // funeraria
        $this->funeraria->setupEditAttributes();
        $this->funeraria->EditValue = $this->funeraria->CurrentValue;
        $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());
        if (strval($this->funeraria->EditValue) != "" && is_numeric($this->funeraria->EditValue)) {
            $this->funeraria->EditValue = FormatNumber($this->funeraria->EditValue, null);
        }

        // marca_pasos
        $this->marca_pasos->EditValue = $this->marca_pasos->options(false);
        $this->marca_pasos->PlaceHolder = RemoveHtml($this->marca_pasos->caption());

        // autoriza_cremar
        $this->autoriza_cremar->EditValue = $this->autoriza_cremar->options(false);
        $this->autoriza_cremar->PlaceHolder = RemoveHtml($this->autoriza_cremar->caption());

        // username_autoriza
        $this->username_autoriza->setupEditAttributes();
        if (!$this->username_autoriza->Raw) {
            $this->username_autoriza->CurrentValue = HtmlDecode($this->username_autoriza->CurrentValue);
        }
        $this->username_autoriza->EditValue = $this->username_autoriza->CurrentValue;
        $this->username_autoriza->PlaceHolder = RemoveHtml($this->username_autoriza->caption());

        // fecha_autoriza
        $this->fecha_autoriza->setupEditAttributes();
        $this->fecha_autoriza->EditValue = FormatDateTime($this->fecha_autoriza->CurrentValue, $this->fecha_autoriza->formatPattern());
        $this->fecha_autoriza->PlaceHolder = RemoveHtml($this->fecha_autoriza->caption());

        // peso
        $this->peso->setupEditAttributes();
        if (!$this->peso->Raw) {
            $this->peso->CurrentValue = HtmlDecode($this->peso->CurrentValue);
        }
        $this->peso->EditValue = $this->peso->CurrentValue;
        $this->peso->PlaceHolder = RemoveHtml($this->peso->caption());

        // contrato_parcela
        $this->contrato_parcela->setupEditAttributes();
        if (!$this->contrato_parcela->Raw) {
            $this->contrato_parcela->CurrentValue = HtmlDecode($this->contrato_parcela->CurrentValue);
        }
        $this->contrato_parcela->EditValue = $this->contrato_parcela->CurrentValue;
        $this->contrato_parcela->PlaceHolder = RemoveHtml($this->contrato_parcela->caption());

        // email_calidad
        $this->email_calidad->EditValue = $this->email_calidad->options(false);
        $this->email_calidad->PlaceHolder = RemoveHtml($this->email_calidad->caption());

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
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->tipo_contratacion);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nacionalidad_contacto);
                    $doc->exportCaption($this->cedula_contacto);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->apellidos_contacto);
                    $doc->exportCaption($this->parentesco_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->nacionalidad_fallecido);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->sexo);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
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
                    $doc->exportCaption($this->descripcion_ocurrencia);
                    $doc->exportCaption($this->calidad);
                    $doc->exportCaption($this->costos);
                    $doc->exportCaption($this->venta);
                    $doc->exportCaption($this->user_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->user_cierra);
                    $doc->exportCaption($this->fecha_cierre);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->unir_con_expediente);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->religion);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->funeraria);
                    $doc->exportCaption($this->marca_pasos);
                    $doc->exportCaption($this->autoriza_cremar);
                    $doc->exportCaption($this->username_autoriza);
                    $doc->exportCaption($this->fecha_autoriza);
                    $doc->exportCaption($this->peso);
                    $doc->exportCaption($this->contrato_parcela);
                    $doc->exportCaption($this->email_calidad);
                    $doc->exportCaption($this->certificado_defuncion);
                    $doc->exportCaption($this->parcela);
                } else {
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->tipo_contratacion);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nacionalidad_contacto);
                    $doc->exportCaption($this->cedula_contacto);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->apellidos_contacto);
                    $doc->exportCaption($this->parentesco_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->nacionalidad_fallecido);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->sexo);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
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
                    $doc->exportCaption($this->descripcion_ocurrencia);
                    $doc->exportCaption($this->calidad);
                    $doc->exportCaption($this->costos);
                    $doc->exportCaption($this->venta);
                    $doc->exportCaption($this->user_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->user_cierra);
                    $doc->exportCaption($this->fecha_cierre);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->unir_con_expediente);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->religion);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->funeraria);
                    $doc->exportCaption($this->marca_pasos);
                    $doc->exportCaption($this->autoriza_cremar);
                    $doc->exportCaption($this->username_autoriza);
                    $doc->exportCaption($this->fecha_autoriza);
                    $doc->exportCaption($this->peso);
                    $doc->exportCaption($this->contrato_parcela);
                    $doc->exportCaption($this->email_calidad);
                    $doc->exportCaption($this->certificado_defuncion);
                    $doc->exportCaption($this->parcela);
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
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->tipo_contratacion);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nacionalidad_contacto);
                        $doc->exportField($this->cedula_contacto);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->apellidos_contacto);
                        $doc->exportField($this->parentesco_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->nacionalidad_fallecido);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->sexo);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
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
                        $doc->exportField($this->descripcion_ocurrencia);
                        $doc->exportField($this->calidad);
                        $doc->exportField($this->costos);
                        $doc->exportField($this->venta);
                        $doc->exportField($this->user_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->user_cierra);
                        $doc->exportField($this->fecha_cierre);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->unir_con_expediente);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->religion);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->funeraria);
                        $doc->exportField($this->marca_pasos);
                        $doc->exportField($this->autoriza_cremar);
                        $doc->exportField($this->username_autoriza);
                        $doc->exportField($this->fecha_autoriza);
                        $doc->exportField($this->peso);
                        $doc->exportField($this->contrato_parcela);
                        $doc->exportField($this->email_calidad);
                        $doc->exportField($this->certificado_defuncion);
                        $doc->exportField($this->parcela);
                    } else {
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->tipo_contratacion);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nacionalidad_contacto);
                        $doc->exportField($this->cedula_contacto);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->apellidos_contacto);
                        $doc->exportField($this->parentesco_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->nacionalidad_fallecido);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->sexo);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
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
                        $doc->exportField($this->descripcion_ocurrencia);
                        $doc->exportField($this->calidad);
                        $doc->exportField($this->costos);
                        $doc->exportField($this->venta);
                        $doc->exportField($this->user_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->user_cierra);
                        $doc->exportField($this->fecha_cierre);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->unir_con_expediente);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->religion);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->funeraria);
                        $doc->exportField($this->marca_pasos);
                        $doc->exportField($this->autoriza_cremar);
                        $doc->exportField($this->username_autoriza);
                        $doc->exportField($this->fecha_autoriza);
                        $doc->exportField($this->peso);
                        $doc->exportField($this->contrato_parcela);
                        $doc->exportField($this->email_calidad);
                        $doc->exportField($this->certificado_defuncion);
                        $doc->exportField($this->parcela);
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
    public function rowRendering()
    {
        // Enter your code here
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
