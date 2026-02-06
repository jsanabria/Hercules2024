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
 * Table class for view_expediente_servicio
 */
class ViewExpedienteServicio extends DbTable
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
    public $InlineDelete = true;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $Nexpediente;
    public $seguro;
    public $nombre_contacto;
    public $telefono_contacto1;
    public $telefono_contacto2;
    public $cedula_fallecido;
    public $nombre_fallecido;
    public $apellidos_fallecido;
    public $fecha_nacimiento;
    public $edad_fallecido;
    public $sexo;
    public $fecha_ocurrencia;
    public $causa_ocurrencia;
    public $causa_otro;
    public $permiso;
    public $capilla;
    public $horas;
    public $ataud;
    public $arreglo_floral;
    public $oficio_religioso;
    public $ofrenda_voz;
    public $fecha_inicio;
    public $hora_inicio;
    public $fecha_fin;
    public $hora_fin;
    public $servicio;
    public $fecha_serv;
    public $hora_serv;
    public $espera_cenizas;
    public $hora_fin_capilla;
    public $hora_fin_servicio;
    public $estatus;
    public $fecha_registro;
    public $factura;
    public $venta;
    public $_email;
    public $sede;
    public $funeraria;
    public $cod_servicio;
    public $coordinador;
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
        $this->TableVar = "view_expediente_servicio";
        $this->TableName = 'view_expediente_servicio';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_expediente_servicio";
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
            'TEXT' // Edit Tag
        );
        $this->Nexpediente->addMethod("getDefault", fn() => 0);
        $this->Nexpediente->addMethod("getLinkPrefix", fn() => "sco_expedienteview.php?showdetail=&Nexpediente=");
        $this->Nexpediente->InputTextType = "text";
        $this->Nexpediente->Raw = true;
        $this->Nexpediente->IsPrimaryKey = true; // Primary key field
        $this->Nexpediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nexpediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nexpediente'] = &$this->Nexpediente;

        // seguro
        $this->seguro = new DbField(
            $this, // Table
            'x_seguro', // Variable name
            'seguro', // Name
            '`seguro`', // Expression
            '`seguro`', // Basic search expression
            200, // Type
            60, // Size
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
        $this->seguro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
        $this->nombre_contacto->Required = true; // Required field
        $this->nombre_contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_contacto'] = &$this->nombre_contacto;

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
        $this->telefono_contacto1->Required = true; // Required field
        $this->telefono_contacto1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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

        // capilla
        $this->capilla = new DbField(
            $this, // Table
            'x_capilla', // Variable name
            'capilla', // Name
            '`capilla`', // Expression
            '`capilla`', // Basic search expression
            200, // Type
            3072, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`capilla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->capilla->InputTextType = "text";
        $this->capilla->setSelectMultiple(false); // Select one
        $this->capilla->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->capilla->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->capilla->Lookup = new Lookup($this->capilla, 'view_expediente_servicio', true, 'capilla', ["capilla","","",""], '', '', [], [], [], [], [], [], false, '`capilla` ASC', '', "`capilla`");
        $this->capilla->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['capilla'] = &$this->capilla;

        // horas
        $this->horas = new DbField(
            $this, // Table
            'x_horas', // Variable name
            'horas', // Name
            '`horas`', // Expression
            '`horas`', // Basic search expression
            200, // Type
            1024, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`horas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->horas->InputTextType = "text";
        $this->horas->setSelectMultiple(false); // Select one
        $this->horas->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->horas->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->horas->Lookup = new Lookup($this->horas, 'view_expediente_servicio', true, 'horas', ["horas","","",""], '', '', [], [], [], [], [], [], false, '`horas` ASC', '', "`horas`");
        $this->horas->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->horas->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['horas'] = &$this->horas;

        // ataud
        $this->ataud = new DbField(
            $this, // Table
            'x_ataud', // Variable name
            'ataud', // Name
            '`ataud`', // Expression
            '`ataud`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ataud`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ataud->InputTextType = "text";
        $this->ataud->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ataud'] = &$this->ataud;

        // arreglo_floral
        $this->arreglo_floral = new DbField(
            $this, // Table
            'x_arreglo_floral', // Variable name
            'arreglo_floral', // Name
            '`arreglo_floral`', // Expression
            '`arreglo_floral`', // Basic search expression
            131, // Type
            26, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`arreglo_floral`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->arreglo_floral->InputTextType = "text";
        $this->arreglo_floral->Raw = true;
        $this->arreglo_floral->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['arreglo_floral'] = &$this->arreglo_floral;

        // oficio_religioso
        $this->oficio_religioso = new DbField(
            $this, // Table
            'x_oficio_religioso', // Variable name
            'oficio_religioso', // Name
            '`oficio_religioso`', // Expression
            '`oficio_religioso`', // Basic search expression
            131, // Type
            26, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`oficio_religioso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->oficio_religioso->InputTextType = "text";
        $this->oficio_religioso->Raw = true;
        $this->oficio_religioso->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->oficio_religioso->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['oficio_religioso'] = &$this->oficio_religioso;

        // ofrenda_voz
        $this->ofrenda_voz = new DbField(
            $this, // Table
            'x_ofrenda_voz', // Variable name
            'ofrenda_voz', // Name
            '`ofrenda_voz`', // Expression
            '`ofrenda_voz`', // Basic search expression
            131, // Type
            26, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ofrenda_voz`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ofrenda_voz->InputTextType = "text";
        $this->ofrenda_voz->Raw = true;
        $this->ofrenda_voz->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['ofrenda_voz'] = &$this->ofrenda_voz;

        // fecha_inicio
        $this->fecha_inicio = new DbField(
            $this, // Table
            'x_fecha_inicio', // Variable name
            'fecha_inicio', // Name
            '`fecha_inicio`', // Expression
            '`fecha_inicio`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fecha_inicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_inicio->InputTextType = "text";
        $this->fecha_inicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_inicio'] = &$this->fecha_inicio;

        // hora_inicio
        $this->hora_inicio = new DbField(
            $this, // Table
            'x_hora_inicio', // Variable name
            'hora_inicio', // Name
            '`hora_inicio`', // Expression
            CastDateFieldForLike("`hora_inicio`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_inicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_inicio->InputTextType = "text";
        $this->hora_inicio->Raw = true;
        $this->hora_inicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_inicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_inicio'] = &$this->hora_inicio;

        // fecha_fin
        $this->fecha_fin = new DbField(
            $this, // Table
            'x_fecha_fin', // Variable name
            'fecha_fin', // Name
            '`fecha_fin`', // Expression
            '`fecha_fin`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fecha_fin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_fin->InputTextType = "text";
        $this->fecha_fin->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_fin'] = &$this->fecha_fin;

        // hora_fin
        $this->hora_fin = new DbField(
            $this, // Table
            'x_hora_fin', // Variable name
            'hora_fin', // Name
            '`hora_fin`', // Expression
            CastDateFieldForLike("`hora_fin`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_fin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_fin->InputTextType = "text";
        $this->hora_fin->Raw = true;
        $this->hora_fin->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_fin->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_fin'] = &$this->hora_fin;

        // servicio
        $this->servicio = new DbField(
            $this, // Table
            'x_servicio', // Variable name
            'servicio', // Name
            '`servicio`', // Expression
            '`servicio`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->servicio->InputTextType = "text";
        $this->servicio->setSelectMultiple(false); // Select one
        $this->servicio->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio->Lookup = new Lookup($this->servicio, 'view_expediente_servicio', true, 'servicio', ["servicio","","",""], '', '', [], [], [], [], [], [], false, '`servicio` ASC', '', "`servicio`");
        $this->servicio->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio'] = &$this->servicio;

        // fecha_serv
        $this->fecha_serv = new DbField(
            $this, // Table
            'x_fecha_serv', // Variable name
            'fecha_serv', // Name
            '`fecha_serv`', // Expression
            '`fecha_serv`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fecha_serv`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_serv->InputTextType = "text";
        $this->fecha_serv->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_serv'] = &$this->fecha_serv;

        // hora_serv
        $this->hora_serv = new DbField(
            $this, // Table
            'x_hora_serv', // Variable name
            'hora_serv', // Name
            '`hora_serv`', // Expression
            CastDateFieldForLike("`hora_serv`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_serv`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_serv->InputTextType = "text";
        $this->hora_serv->Raw = true;
        $this->hora_serv->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_serv->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_serv'] = &$this->hora_serv;

        // espera_cenizas
        $this->espera_cenizas = new DbField(
            $this, // Table
            'x_espera_cenizas', // Variable name
            'espera_cenizas', // Name
            '`espera_cenizas`', // Expression
            '`espera_cenizas`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`espera_cenizas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->espera_cenizas->addMethod("getDefault", fn() => "N");
        $this->espera_cenizas->InputTextType = "text";
        $this->espera_cenizas->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['espera_cenizas'] = &$this->espera_cenizas;

        // hora_fin_capilla
        $this->hora_fin_capilla = new DbField(
            $this, // Table
            'x_hora_fin_capilla', // Variable name
            'hora_fin_capilla', // Name
            '`hora_fin_capilla`', // Expression
            CastDateFieldForLike("`hora_fin_capilla`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_fin_capilla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_fin_capilla->InputTextType = "text";
        $this->hora_fin_capilla->Raw = true;
        $this->hora_fin_capilla->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_fin_capilla->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_fin_capilla'] = &$this->hora_fin_capilla;

        // hora_fin_servicio
        $this->hora_fin_servicio = new DbField(
            $this, // Table
            'x_hora_fin_servicio', // Variable name
            'hora_fin_servicio', // Name
            '`hora_fin_servicio`', // Expression
            CastDateFieldForLike("`hora_fin_servicio`", 0, "DB"), // Basic search expression
            134, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_fin_servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_fin_servicio->InputTextType = "text";
        $this->hora_fin_servicio->Raw = true;
        $this->hora_fin_servicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_fin_servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_fin_servicio'] = &$this->hora_fin_servicio;

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
        $this->estatus->InputTextType = "text";
        $this->estatus->Raw = true;
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_estatus', false, 'Nstatus', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`Nstatus`', '', "`nombre`");
        $this->estatus->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estatus->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

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

        // sede
        $this->sede = new DbField(
            $this, // Table
            'x_sede', // Variable name
            'sede', // Name
            '`sede`', // Expression
            '`sede`', // Basic search expression
            200, // Type
            3072, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sede`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->sede->InputTextType = "text";
        $this->sede->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['sede'] = &$this->sede;

        // funeraria
        $this->funeraria = new DbField(
            $this, // Table
            'x_funeraria', // Variable name
            'funeraria', // Name
            '`funeraria`', // Expression
            '`funeraria`', // Basic search expression
            20, // Type
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
        $this->funeraria->addMethod("getDefault", fn() => 0);
        $this->funeraria->InputTextType = "text";
        $this->funeraria->Raw = true;
        $this->funeraria->Nullable = false; // NOT NULL field
        $this->funeraria->Required = true; // Required field
        $this->funeraria->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->funeraria->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['funeraria'] = &$this->funeraria;

        // cod_servicio
        $this->cod_servicio = new DbField(
            $this, // Table
            'x_cod_servicio', // Variable name
            'cod_servicio', // Name
            '`cod_servicio`', // Expression
            '`cod_servicio`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cod_servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cod_servicio->InputTextType = "text";
        $this->cod_servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cod_servicio'] = &$this->cod_servicio;

        // coordinador
        $this->coordinador = new DbField(
            $this, // Table
            'x_coordinador', // Variable name
            'coordinador', // Name
            '`coordinador`', // Expression
            '`coordinador`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`coordinador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->coordinador->InputTextType = "text";
        $this->coordinador->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['coordinador'] = &$this->coordinador;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_expediente_servicio";
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
        $this->seguro->DbValue = $row['seguro'];
        $this->nombre_contacto->DbValue = $row['nombre_contacto'];
        $this->telefono_contacto1->DbValue = $row['telefono_contacto1'];
        $this->telefono_contacto2->DbValue = $row['telefono_contacto2'];
        $this->cedula_fallecido->DbValue = $row['cedula_fallecido'];
        $this->nombre_fallecido->DbValue = $row['nombre_fallecido'];
        $this->apellidos_fallecido->DbValue = $row['apellidos_fallecido'];
        $this->fecha_nacimiento->DbValue = $row['fecha_nacimiento'];
        $this->edad_fallecido->DbValue = $row['edad_fallecido'];
        $this->sexo->DbValue = $row['sexo'];
        $this->fecha_ocurrencia->DbValue = $row['fecha_ocurrencia'];
        $this->causa_ocurrencia->DbValue = $row['causa_ocurrencia'];
        $this->causa_otro->DbValue = $row['causa_otro'];
        $this->permiso->DbValue = $row['permiso'];
        $this->capilla->DbValue = $row['capilla'];
        $this->horas->DbValue = $row['horas'];
        $this->ataud->DbValue = $row['ataud'];
        $this->arreglo_floral->DbValue = $row['arreglo_floral'];
        $this->oficio_religioso->DbValue = $row['oficio_religioso'];
        $this->ofrenda_voz->DbValue = $row['ofrenda_voz'];
        $this->fecha_inicio->DbValue = $row['fecha_inicio'];
        $this->hora_inicio->DbValue = $row['hora_inicio'];
        $this->fecha_fin->DbValue = $row['fecha_fin'];
        $this->hora_fin->DbValue = $row['hora_fin'];
        $this->servicio->DbValue = $row['servicio'];
        $this->fecha_serv->DbValue = $row['fecha_serv'];
        $this->hora_serv->DbValue = $row['hora_serv'];
        $this->espera_cenizas->DbValue = $row['espera_cenizas'];
        $this->hora_fin_capilla->DbValue = $row['hora_fin_capilla'];
        $this->hora_fin_servicio->DbValue = $row['hora_fin_servicio'];
        $this->estatus->DbValue = $row['estatus'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->factura->DbValue = $row['factura'];
        $this->venta->DbValue = $row['venta'];
        $this->_email->DbValue = $row['email'];
        $this->sede->DbValue = $row['sede'];
        $this->funeraria->DbValue = $row['funeraria'];
        $this->cod_servicio->DbValue = $row['cod_servicio'];
        $this->coordinador->DbValue = $row['coordinador'];
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
        return $_SESSION[$name] ?? GetUrl("ViewExpedienteServicioList");
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
            "ViewExpedienteServicioView" => $Language->phrase("View"),
            "ViewExpedienteServicioEdit" => $Language->phrase("Edit"),
            "ViewExpedienteServicioAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewExpedienteServicioList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewExpedienteServicioView",
            Config("API_ADD_ACTION") => "ViewExpedienteServicioAdd",
            Config("API_EDIT_ACTION") => "ViewExpedienteServicioEdit",
            Config("API_DELETE_ACTION") => "ViewExpedienteServicioDelete",
            Config("API_LIST_ACTION") => "ViewExpedienteServicioList",
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
        return "ViewExpedienteServicioList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewExpedienteServicioView", $parm);
        } else {
            $url = $this->keyUrl("ViewExpedienteServicioView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewExpedienteServicioAdd?" . $parm;
        } else {
            $url = "ViewExpedienteServicioAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewExpedienteServicioEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewExpedienteServicioList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewExpedienteServicioAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewExpedienteServicioList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewExpedienteServicioDelete", $parm);
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
        $this->seguro->setDbValue($row['seguro']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->edad_fallecido->setDbValue($row['edad_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->fecha_ocurrencia->setDbValue($row['fecha_ocurrencia']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->causa_otro->setDbValue($row['causa_otro']);
        $this->permiso->setDbValue($row['permiso']);
        $this->capilla->setDbValue($row['capilla']);
        $this->horas->setDbValue($row['horas']);
        $this->ataud->setDbValue($row['ataud']);
        $this->arreglo_floral->setDbValue($row['arreglo_floral']);
        $this->oficio_religioso->setDbValue($row['oficio_religioso']);
        $this->ofrenda_voz->setDbValue($row['ofrenda_voz']);
        $this->fecha_inicio->setDbValue($row['fecha_inicio']);
        $this->hora_inicio->setDbValue($row['hora_inicio']);
        $this->fecha_fin->setDbValue($row['fecha_fin']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->servicio->setDbValue($row['servicio']);
        $this->fecha_serv->setDbValue($row['fecha_serv']);
        $this->hora_serv->setDbValue($row['hora_serv']);
        $this->espera_cenizas->setDbValue($row['espera_cenizas']);
        $this->hora_fin_capilla->setDbValue($row['hora_fin_capilla']);
        $this->hora_fin_servicio->setDbValue($row['hora_fin_servicio']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->factura->setDbValue($row['factura']);
        $this->venta->setDbValue($row['venta']);
        $this->_email->setDbValue($row['email']);
        $this->sede->setDbValue($row['sede']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->cod_servicio->setDbValue($row['cod_servicio']);
        $this->coordinador->setDbValue($row['coordinador']);
        $this->parcela->setDbValue($row['parcela']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewExpedienteServicioList";
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

        // seguro

        // nombre_contacto

        // telefono_contacto1

        // telefono_contacto2

        // cedula_fallecido

        // nombre_fallecido

        // apellidos_fallecido

        // fecha_nacimiento

        // edad_fallecido

        // sexo

        // fecha_ocurrencia

        // causa_ocurrencia

        // causa_otro

        // permiso

        // capilla

        // horas

        // ataud

        // arreglo_floral

        // oficio_religioso

        // ofrenda_voz

        // fecha_inicio

        // hora_inicio

        // fecha_fin

        // hora_fin

        // servicio

        // fecha_serv

        // hora_serv

        // espera_cenizas

        // hora_fin_capilla

        // hora_fin_servicio

        // estatus

        // fecha_registro

        // factura

        // venta

        // email

        // sede

        // funeraria

        // cod_servicio

        // coordinador

        // parcela

        // Nexpediente
        $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

        // seguro
        $this->seguro->ViewValue = $this->seguro->CurrentValue;

        // nombre_contacto
        $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

        // telefono_contacto1
        $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

        // telefono_contacto2
        $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

        // cedula_fallecido
        $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

        // nombre_fallecido
        $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

        // apellidos_fallecido
        $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

        // fecha_nacimiento
        $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
        $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

        // edad_fallecido
        $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;

        // sexo
        $this->sexo->ViewValue = $this->sexo->CurrentValue;

        // fecha_ocurrencia
        $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
        $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

        // causa_ocurrencia
        $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

        // causa_otro
        $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

        // permiso
        $this->permiso->ViewValue = $this->permiso->CurrentValue;

        // capilla
        $this->capilla->ViewValue = $this->capilla->CurrentValue;

        // horas
        $this->horas->ViewValue = $this->horas->CurrentValue;

        // ataud
        $this->ataud->ViewValue = $this->ataud->CurrentValue;

        // arreglo_floral
        $this->arreglo_floral->ViewValue = $this->arreglo_floral->CurrentValue;
        $this->arreglo_floral->ViewValue = FormatNumber($this->arreglo_floral->ViewValue, $this->arreglo_floral->formatPattern());

        // oficio_religioso
        $this->oficio_religioso->ViewValue = $this->oficio_religioso->CurrentValue;
        $this->oficio_religioso->ViewValue = FormatNumber($this->oficio_religioso->ViewValue, $this->oficio_religioso->formatPattern());

        // ofrenda_voz
        $this->ofrenda_voz->ViewValue = $this->ofrenda_voz->CurrentValue;
        $this->ofrenda_voz->ViewValue = FormatNumber($this->ofrenda_voz->ViewValue, $this->ofrenda_voz->formatPattern());

        // fecha_inicio
        $this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;

        // hora_inicio
        $this->hora_inicio->ViewValue = $this->hora_inicio->CurrentValue;

        // fecha_fin
        $this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;

        // hora_fin
        $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;

        // servicio
        $this->servicio->ViewValue = $this->servicio->CurrentValue;

        // fecha_serv
        $this->fecha_serv->ViewValue = $this->fecha_serv->CurrentValue;

        // hora_serv
        $this->hora_serv->ViewValue = $this->hora_serv->CurrentValue;

        // espera_cenizas
        $this->espera_cenizas->ViewValue = $this->espera_cenizas->CurrentValue;

        // hora_fin_capilla
        $this->hora_fin_capilla->ViewValue = $this->hora_fin_capilla->CurrentValue;

        // hora_fin_servicio
        $this->hora_fin_servicio->ViewValue = $this->hora_fin_servicio->CurrentValue;

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

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

        // factura
        $this->factura->ViewValue = $this->factura->CurrentValue;

        // venta
        $this->venta->ViewValue = $this->venta->CurrentValue;
        $this->venta->ViewValue = FormatCurrency($this->venta->ViewValue, $this->venta->formatPattern());

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // sede
        $this->sede->ViewValue = $this->sede->CurrentValue;

        // funeraria
        $this->funeraria->ViewValue = $this->funeraria->CurrentValue;

        // cod_servicio
        $this->cod_servicio->ViewValue = $this->cod_servicio->CurrentValue;

        // coordinador
        $this->coordinador->ViewValue = $this->coordinador->CurrentValue;

        // parcela
        $this->parcela->ViewValue = $this->parcela->CurrentValue;

        // Nexpediente
        if (!EmptyValue($this->Nexpediente->CurrentValue)) {
            $this->Nexpediente->HrefValue = $this->Nexpediente->getLinkPrefix() . (!empty($this->Nexpediente->ViewValue) && !is_array($this->Nexpediente->ViewValue) ? RemoveHtml($this->Nexpediente->ViewValue) : $this->Nexpediente->CurrentValue); // Add prefix/suffix
            $this->Nexpediente->LinkAttrs["target"] = "_blank"; // Add target
            if ($this->isExport()) {
                $this->Nexpediente->HrefValue = FullUrl($this->Nexpediente->HrefValue, "href");
            }
        } else {
            $this->Nexpediente->HrefValue = "";
        }
        $this->Nexpediente->TooltipValue = "";

        // seguro
        $this->seguro->HrefValue = "";
        $this->seguro->TooltipValue = "";

        // nombre_contacto
        $this->nombre_contacto->HrefValue = "";
        $this->nombre_contacto->TooltipValue = "";

        // telefono_contacto1
        $this->telefono_contacto1->HrefValue = "";
        $this->telefono_contacto1->TooltipValue = "";

        // telefono_contacto2
        $this->telefono_contacto2->HrefValue = "";
        $this->telefono_contacto2->TooltipValue = "";

        // cedula_fallecido
        $this->cedula_fallecido->HrefValue = "";
        $this->cedula_fallecido->TooltipValue = "";

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

        // sexo
        $this->sexo->HrefValue = "";
        $this->sexo->TooltipValue = "";

        // fecha_ocurrencia
        $this->fecha_ocurrencia->HrefValue = "";
        $this->fecha_ocurrencia->TooltipValue = "";

        // causa_ocurrencia
        $this->causa_ocurrencia->HrefValue = "";
        $this->causa_ocurrencia->TooltipValue = "";

        // causa_otro
        $this->causa_otro->HrefValue = "";
        $this->causa_otro->TooltipValue = "";

        // permiso
        $this->permiso->HrefValue = "";
        $this->permiso->TooltipValue = "";

        // capilla
        $this->capilla->HrefValue = "";
        $this->capilla->TooltipValue = "";

        // horas
        $this->horas->HrefValue = "";
        $this->horas->TooltipValue = "";

        // ataud
        $this->ataud->HrefValue = "";
        $this->ataud->TooltipValue = "";

        // arreglo_floral
        $this->arreglo_floral->HrefValue = "";
        $this->arreglo_floral->TooltipValue = "";

        // oficio_religioso
        $this->oficio_religioso->HrefValue = "";
        $this->oficio_religioso->TooltipValue = "";

        // ofrenda_voz
        $this->ofrenda_voz->HrefValue = "";
        $this->ofrenda_voz->TooltipValue = "";

        // fecha_inicio
        $this->fecha_inicio->HrefValue = "";
        $this->fecha_inicio->TooltipValue = "";

        // hora_inicio
        $this->hora_inicio->HrefValue = "";
        $this->hora_inicio->TooltipValue = "";

        // fecha_fin
        $this->fecha_fin->HrefValue = "";
        $this->fecha_fin->TooltipValue = "";

        // hora_fin
        $this->hora_fin->HrefValue = "";
        $this->hora_fin->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // fecha_serv
        $this->fecha_serv->HrefValue = "";
        $this->fecha_serv->TooltipValue = "";

        // hora_serv
        $this->hora_serv->HrefValue = "";
        $this->hora_serv->TooltipValue = "";

        // espera_cenizas
        $this->espera_cenizas->HrefValue = "";
        $this->espera_cenizas->TooltipValue = "";

        // hora_fin_capilla
        $this->hora_fin_capilla->HrefValue = "";
        $this->hora_fin_capilla->TooltipValue = "";

        // hora_fin_servicio
        $this->hora_fin_servicio->HrefValue = "";
        $this->hora_fin_servicio->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // factura
        $this->factura->HrefValue = "";
        $this->factura->TooltipValue = "";

        // venta
        $this->venta->HrefValue = "";
        $this->venta->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // sede
        $this->sede->HrefValue = "";
        $this->sede->TooltipValue = "";

        // funeraria
        $this->funeraria->HrefValue = "";
        $this->funeraria->TooltipValue = "";

        // cod_servicio
        $this->cod_servicio->HrefValue = "";
        $this->cod_servicio->TooltipValue = "";

        // coordinador
        $this->coordinador->HrefValue = "";
        $this->coordinador->TooltipValue = "";

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
        $this->Nexpediente->PlaceHolder = RemoveHtml($this->Nexpediente->caption());

        // seguro
        $this->seguro->setupEditAttributes();
        if (!$this->seguro->Raw) {
            $this->seguro->CurrentValue = HtmlDecode($this->seguro->CurrentValue);
        }
        $this->seguro->EditValue = $this->seguro->CurrentValue;
        $this->seguro->PlaceHolder = RemoveHtml($this->seguro->caption());

        // nombre_contacto
        $this->nombre_contacto->setupEditAttributes();
        if (!$this->nombre_contacto->Raw) {
            $this->nombre_contacto->CurrentValue = HtmlDecode($this->nombre_contacto->CurrentValue);
        }
        $this->nombre_contacto->EditValue = $this->nombre_contacto->CurrentValue;
        $this->nombre_contacto->PlaceHolder = RemoveHtml($this->nombre_contacto->caption());

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

        // sexo
        $this->sexo->setupEditAttributes();
        if (!$this->sexo->Raw) {
            $this->sexo->CurrentValue = HtmlDecode($this->sexo->CurrentValue);
        }
        $this->sexo->EditValue = $this->sexo->CurrentValue;
        $this->sexo->PlaceHolder = RemoveHtml($this->sexo->caption());

        // fecha_ocurrencia
        $this->fecha_ocurrencia->setupEditAttributes();
        $this->fecha_ocurrencia->EditValue = FormatDateTime($this->fecha_ocurrencia->CurrentValue, $this->fecha_ocurrencia->formatPattern());
        $this->fecha_ocurrencia->PlaceHolder = RemoveHtml($this->fecha_ocurrencia->caption());

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

        // permiso
        $this->permiso->setupEditAttributes();
        if (!$this->permiso->Raw) {
            $this->permiso->CurrentValue = HtmlDecode($this->permiso->CurrentValue);
        }
        $this->permiso->EditValue = $this->permiso->CurrentValue;
        $this->permiso->PlaceHolder = RemoveHtml($this->permiso->caption());

        // capilla
        $this->capilla->setupEditAttributes();
        $this->capilla->PlaceHolder = RemoveHtml($this->capilla->caption());

        // horas
        $this->horas->setupEditAttributes();
        $this->horas->PlaceHolder = RemoveHtml($this->horas->caption());

        // ataud
        $this->ataud->setupEditAttributes();
        if (!$this->ataud->Raw) {
            $this->ataud->CurrentValue = HtmlDecode($this->ataud->CurrentValue);
        }
        $this->ataud->EditValue = $this->ataud->CurrentValue;
        $this->ataud->PlaceHolder = RemoveHtml($this->ataud->caption());

        // arreglo_floral
        $this->arreglo_floral->setupEditAttributes();
        $this->arreglo_floral->EditValue = $this->arreglo_floral->CurrentValue;
        $this->arreglo_floral->PlaceHolder = RemoveHtml($this->arreglo_floral->caption());
        if (strval($this->arreglo_floral->EditValue) != "" && is_numeric($this->arreglo_floral->EditValue)) {
            $this->arreglo_floral->EditValue = FormatNumber($this->arreglo_floral->EditValue, null);
        }

        // oficio_religioso
        $this->oficio_religioso->setupEditAttributes();
        $this->oficio_religioso->EditValue = $this->oficio_religioso->CurrentValue;
        $this->oficio_religioso->PlaceHolder = RemoveHtml($this->oficio_religioso->caption());
        if (strval($this->oficio_religioso->EditValue) != "" && is_numeric($this->oficio_religioso->EditValue)) {
            $this->oficio_religioso->EditValue = FormatNumber($this->oficio_religioso->EditValue, null);
        }

        // ofrenda_voz
        $this->ofrenda_voz->setupEditAttributes();
        $this->ofrenda_voz->EditValue = $this->ofrenda_voz->CurrentValue;
        $this->ofrenda_voz->PlaceHolder = RemoveHtml($this->ofrenda_voz->caption());
        if (strval($this->ofrenda_voz->EditValue) != "" && is_numeric($this->ofrenda_voz->EditValue)) {
            $this->ofrenda_voz->EditValue = FormatNumber($this->ofrenda_voz->EditValue, null);
        }

        // fecha_inicio
        $this->fecha_inicio->setupEditAttributes();
        if (!$this->fecha_inicio->Raw) {
            $this->fecha_inicio->CurrentValue = HtmlDecode($this->fecha_inicio->CurrentValue);
        }
        $this->fecha_inicio->EditValue = $this->fecha_inicio->CurrentValue;
        $this->fecha_inicio->PlaceHolder = RemoveHtml($this->fecha_inicio->caption());

        // hora_inicio
        $this->hora_inicio->setupEditAttributes();
        $this->hora_inicio->EditValue = $this->hora_inicio->CurrentValue;
        $this->hora_inicio->PlaceHolder = RemoveHtml($this->hora_inicio->caption());

        // fecha_fin
        $this->fecha_fin->setupEditAttributes();
        if (!$this->fecha_fin->Raw) {
            $this->fecha_fin->CurrentValue = HtmlDecode($this->fecha_fin->CurrentValue);
        }
        $this->fecha_fin->EditValue = $this->fecha_fin->CurrentValue;
        $this->fecha_fin->PlaceHolder = RemoveHtml($this->fecha_fin->caption());

        // hora_fin
        $this->hora_fin->setupEditAttributes();
        $this->hora_fin->EditValue = $this->hora_fin->CurrentValue;
        $this->hora_fin->PlaceHolder = RemoveHtml($this->hora_fin->caption());

        // servicio
        $this->servicio->setupEditAttributes();
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // fecha_serv
        $this->fecha_serv->setupEditAttributes();
        if (!$this->fecha_serv->Raw) {
            $this->fecha_serv->CurrentValue = HtmlDecode($this->fecha_serv->CurrentValue);
        }
        $this->fecha_serv->EditValue = $this->fecha_serv->CurrentValue;
        $this->fecha_serv->PlaceHolder = RemoveHtml($this->fecha_serv->caption());

        // hora_serv
        $this->hora_serv->setupEditAttributes();
        $this->hora_serv->EditValue = $this->hora_serv->CurrentValue;
        $this->hora_serv->PlaceHolder = RemoveHtml($this->hora_serv->caption());

        // espera_cenizas
        $this->espera_cenizas->setupEditAttributes();
        if (!$this->espera_cenizas->Raw) {
            $this->espera_cenizas->CurrentValue = HtmlDecode($this->espera_cenizas->CurrentValue);
        }
        $this->espera_cenizas->EditValue = $this->espera_cenizas->CurrentValue;
        $this->espera_cenizas->PlaceHolder = RemoveHtml($this->espera_cenizas->caption());

        // hora_fin_capilla
        $this->hora_fin_capilla->setupEditAttributes();
        $this->hora_fin_capilla->EditValue = $this->hora_fin_capilla->CurrentValue;
        $this->hora_fin_capilla->PlaceHolder = RemoveHtml($this->hora_fin_capilla->caption());

        // hora_fin_servicio
        $this->hora_fin_servicio->setupEditAttributes();
        $this->hora_fin_servicio->EditValue = $this->hora_fin_servicio->CurrentValue;
        $this->hora_fin_servicio->PlaceHolder = RemoveHtml($this->hora_fin_servicio->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

        // factura
        $this->factura->setupEditAttributes();
        if (!$this->factura->Raw) {
            $this->factura->CurrentValue = HtmlDecode($this->factura->CurrentValue);
        }
        $this->factura->EditValue = $this->factura->CurrentValue;
        $this->factura->PlaceHolder = RemoveHtml($this->factura->caption());

        // venta
        $this->venta->setupEditAttributes();
        $this->venta->EditValue = $this->venta->CurrentValue;
        $this->venta->PlaceHolder = RemoveHtml($this->venta->caption());
        if (strval($this->venta->EditValue) != "" && is_numeric($this->venta->EditValue)) {
            $this->venta->EditValue = FormatNumber($this->venta->EditValue, null);
        }

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // sede
        $this->sede->setupEditAttributes();
        $this->sede->EditValue = $this->sede->CurrentValue;
        $this->sede->PlaceHolder = RemoveHtml($this->sede->caption());

        // funeraria
        $this->funeraria->setupEditAttributes();
        $this->funeraria->EditValue = $this->funeraria->CurrentValue;
        $this->funeraria->PlaceHolder = RemoveHtml($this->funeraria->caption());
        if (strval($this->funeraria->EditValue) != "" && is_numeric($this->funeraria->EditValue)) {
            $this->funeraria->EditValue = $this->funeraria->EditValue;
        }

        // cod_servicio
        $this->cod_servicio->setupEditAttributes();
        if (!$this->cod_servicio->Raw) {
            $this->cod_servicio->CurrentValue = HtmlDecode($this->cod_servicio->CurrentValue);
        }
        $this->cod_servicio->EditValue = $this->cod_servicio->CurrentValue;
        $this->cod_servicio->PlaceHolder = RemoveHtml($this->cod_servicio->caption());

        // coordinador
        $this->coordinador->setupEditAttributes();
        if (!$this->coordinador->Raw) {
            $this->coordinador->CurrentValue = HtmlDecode($this->coordinador->CurrentValue);
        }
        $this->coordinador->EditValue = $this->coordinador->CurrentValue;
        $this->coordinador->PlaceHolder = RemoveHtml($this->coordinador->caption());

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
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
                    $doc->exportCaption($this->fecha_nacimiento);
                    $doc->exportCaption($this->edad_fallecido);
                    $doc->exportCaption($this->sexo);
                    $doc->exportCaption($this->fecha_ocurrencia);
                    $doc->exportCaption($this->causa_ocurrencia);
                    $doc->exportCaption($this->causa_otro);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->capilla);
                    $doc->exportCaption($this->horas);
                    $doc->exportCaption($this->ataud);
                    $doc->exportCaption($this->arreglo_floral);
                    $doc->exportCaption($this->oficio_religioso);
                    $doc->exportCaption($this->ofrenda_voz);
                    $doc->exportCaption($this->fecha_inicio);
                    $doc->exportCaption($this->hora_inicio);
                    $doc->exportCaption($this->fecha_fin);
                    $doc->exportCaption($this->hora_fin);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->fecha_serv);
                    $doc->exportCaption($this->hora_serv);
                    $doc->exportCaption($this->espera_cenizas);
                    $doc->exportCaption($this->hora_fin_capilla);
                    $doc->exportCaption($this->hora_fin_servicio);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->venta);
                    $doc->exportCaption($this->sede);
                    $doc->exportCaption($this->funeraria);
                    $doc->exportCaption($this->cod_servicio);
                    $doc->exportCaption($this->coordinador);
                    $doc->exportCaption($this->parcela);
                } else {
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->seguro);
                    $doc->exportCaption($this->nombre_contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
                    $doc->exportCaption($this->fecha_nacimiento);
                    $doc->exportCaption($this->edad_fallecido);
                    $doc->exportCaption($this->sexo);
                    $doc->exportCaption($this->fecha_ocurrencia);
                    $doc->exportCaption($this->causa_ocurrencia);
                    $doc->exportCaption($this->causa_otro);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->capilla);
                    $doc->exportCaption($this->horas);
                    $doc->exportCaption($this->ataud);
                    $doc->exportCaption($this->arreglo_floral);
                    $doc->exportCaption($this->oficio_religioso);
                    $doc->exportCaption($this->ofrenda_voz);
                    $doc->exportCaption($this->fecha_inicio);
                    $doc->exportCaption($this->hora_inicio);
                    $doc->exportCaption($this->fecha_fin);
                    $doc->exportCaption($this->hora_fin);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->fecha_serv);
                    $doc->exportCaption($this->hora_serv);
                    $doc->exportCaption($this->espera_cenizas);
                    $doc->exportCaption($this->hora_fin_capilla);
                    $doc->exportCaption($this->hora_fin_servicio);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->factura);
                    $doc->exportCaption($this->venta);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->funeraria);
                    $doc->exportCaption($this->cod_servicio);
                    $doc->exportCaption($this->coordinador);
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
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
                        $doc->exportField($this->fecha_nacimiento);
                        $doc->exportField($this->edad_fallecido);
                        $doc->exportField($this->sexo);
                        $doc->exportField($this->fecha_ocurrencia);
                        $doc->exportField($this->causa_ocurrencia);
                        $doc->exportField($this->causa_otro);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->capilla);
                        $doc->exportField($this->horas);
                        $doc->exportField($this->ataud);
                        $doc->exportField($this->arreglo_floral);
                        $doc->exportField($this->oficio_religioso);
                        $doc->exportField($this->ofrenda_voz);
                        $doc->exportField($this->fecha_inicio);
                        $doc->exportField($this->hora_inicio);
                        $doc->exportField($this->fecha_fin);
                        $doc->exportField($this->hora_fin);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->fecha_serv);
                        $doc->exportField($this->hora_serv);
                        $doc->exportField($this->espera_cenizas);
                        $doc->exportField($this->hora_fin_capilla);
                        $doc->exportField($this->hora_fin_servicio);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->venta);
                        $doc->exportField($this->sede);
                        $doc->exportField($this->funeraria);
                        $doc->exportField($this->cod_servicio);
                        $doc->exportField($this->coordinador);
                        $doc->exportField($this->parcela);
                    } else {
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->seguro);
                        $doc->exportField($this->nombre_contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
                        $doc->exportField($this->fecha_nacimiento);
                        $doc->exportField($this->edad_fallecido);
                        $doc->exportField($this->sexo);
                        $doc->exportField($this->fecha_ocurrencia);
                        $doc->exportField($this->causa_ocurrencia);
                        $doc->exportField($this->causa_otro);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->capilla);
                        $doc->exportField($this->horas);
                        $doc->exportField($this->ataud);
                        $doc->exportField($this->arreglo_floral);
                        $doc->exportField($this->oficio_religioso);
                        $doc->exportField($this->ofrenda_voz);
                        $doc->exportField($this->fecha_inicio);
                        $doc->exportField($this->hora_inicio);
                        $doc->exportField($this->fecha_fin);
                        $doc->exportField($this->hora_fin);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->fecha_serv);
                        $doc->exportField($this->hora_serv);
                        $doc->exportField($this->espera_cenizas);
                        $doc->exportField($this->hora_fin_capilla);
                        $doc->exportField($this->hora_fin_servicio);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->factura);
                        $doc->exportField($this->venta);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->funeraria);
                        $doc->exportField($this->cod_servicio);
                        $doc->exportField($this->coordinador);
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
    public function recordsetSelecting(&$filter) {
    	// Enter your code here	
    	if(isset($_GET["estatusname"])) {
    		switch($_GET["estatusname"]) {
    		case "RECEPCION":
    			AddFilter($filter, "estatus = '1'");
    			break;
    		case "ENVIO":
    			AddFilter($filter, "estatus = '2'");
    			break;
    		case "LOCALIZACION":
    			AddFilter($filter, "estatus = '3'");
    			break;
    		case "RESGUARDO":
    			AddFilter($filter, "estatus = '4'");
    			break;
    		case "VELACION":
    			AddFilter($filter, "estatus = '5'");
    			break;
    		case "SEPELIO/CREMAC":
    			AddFilter($filter, "estatus = '6'");
    			break;
    		case "ANULADO":
    			AddFilter($filter, "estatus = '7'");
    			break;
    		}
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
    	// Enter your code here	
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
            $this->cedula_fallecido->CellAttrs["style"] = $style;
            $this->sexo->CellAttrs["style"] = $style;
            $this->nombre_fallecido->CellAttrs["style"] = $style;
            $this->apellidos_fallecido->CellAttrs["style"] = $style;
            $this->edad_fallecido->CellAttrs["style"] = $style;
            $this->fecha_nacimiento->CellAttrs["style"] = $style;
            $this->fecha_ocurrencia->CellAttrs["style"] = $style;
            $this->causa_ocurrencia->CellAttrs["style"] = $style;
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
