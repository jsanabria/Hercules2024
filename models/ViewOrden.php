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
 * Table class for view_orden
 */
class ViewOrden extends DbTable
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
    public $Norden;
    public $expediente;
    public $difunto;
    public $servicio_tipo;
    public $servicio;
    public $paso;
    public $proveedor;
    public $responsable_servicio;
    public $fecha_inicio;
    public $hora_inicio;
    public $horas;
    public $fecha_fin;
    public $hora_fin;
    public $capilla;
    public $cantidad;
    public $costo;
    public $total;
    public $nota;
    public $referencia_ubicacion;
    public $anulada;
    public $user_registra;
    public $fecha_registro;
    public $media_hora;
    public $espera_cenizas;
    public $adjunto;
    public $cedula_fallecido;
    public $contacto;
    public $telefono_contacto1;
    public $telefono_contacto2;
    public $llevar_a;
    public $servicio_atendido;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_orden";
        $this->TableName = 'view_orden';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_orden";
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

        // Norden
        $this->Norden = new DbField(
            $this, // Table
            'x_Norden', // Variable name
            'Norden', // Name
            '`Norden`', // Expression
            '`Norden`', // Basic search expression
            21, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Norden`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Norden->InputTextType = "text";
        $this->Norden->Raw = true;
        $this->Norden->IsAutoIncrement = true; // Autoincrement field
        $this->Norden->IsPrimaryKey = true; // Primary key field
        $this->Norden->Nullable = false; // NOT NULL field
        $this->Norden->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Norden->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Norden'] = &$this->Norden;

        // expediente
        $this->expediente = new DbField(
            $this, // Table
            'x_expediente', // Variable name
            'expediente', // Name
            '`expediente`', // Expression
            '`expediente`', // Basic search expression
            21, // Type
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
        $this->expediente->InputTextType = "text";
        $this->expediente->Raw = true;
        $this->expediente->Nullable = false; // NOT NULL field
        $this->expediente->Required = true; // Required field
        $this->expediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->expediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['expediente'] = &$this->expediente;

        // difunto
        $this->difunto = new DbField(
            $this, // Table
            'x_difunto', // Variable name
            'difunto', // Name
            '`difunto`', // Expression
            '`difunto`', // Basic search expression
            200, // Type
            101, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`difunto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->difunto->InputTextType = "text";
        $this->difunto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['difunto'] = &$this->difunto;

        // servicio_tipo
        $this->servicio_tipo = new DbField(
            $this, // Table
            'x_servicio_tipo', // Variable name
            'servicio_tipo', // Name
            '`servicio_tipo`', // Expression
            '`servicio_tipo`', // Basic search expression
            200, // Type
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
        $this->servicio_tipo->InputTextType = "text";
        $this->servicio_tipo->Nullable = false; // NOT NULL field
        $this->servicio_tipo->Required = true; // Required field
        $this->servicio_tipo->setSelectMultiple(false); // Select one
        $this->servicio_tipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio_tipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio_tipo->Lookup = new Lookup($this->servicio_tipo, 'sco_servicio_tipo', false, 'Nservicio_tipo', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->servicio_tipo->SearchOperators = ["=", "<>"];
        $this->Fields['servicio_tipo'] = &$this->servicio_tipo;

        // servicio
        $this->servicio = new DbField(
            $this, // Table
            'x_servicio', // Variable name
            'servicio', // Name
            '`servicio`', // Expression
            '`servicio`', // Basic search expression
            200, // Type
            10, // Size
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
        $this->servicio->Nullable = false; // NOT NULL field
        $this->servicio->Required = true; // Required field
        $this->servicio->setSelectMultiple(false); // Select one
        $this->servicio->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio->Lookup = new Lookup($this->servicio, 'sco_servicio', false, 'Nservicio', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->servicio->SearchOperators = ["=", "<>"];
        $this->Fields['servicio'] = &$this->servicio;

        // paso
        $this->paso = new DbField(
            $this, // Table
            'x_paso', // Variable name
            'paso', // Name
            '`paso`', // Expression
            '`paso`', // Basic search expression
            16, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`paso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->paso->addMethod("getDefault", fn() => 0);
        $this->paso->InputTextType = "text";
        $this->paso->Raw = true;
        $this->paso->Nullable = false; // NOT NULL field
        $this->paso->Required = true; // Required field
        $this->paso->setSelectMultiple(false); // Select one
        $this->paso->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->paso->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->paso->Lookup = new Lookup($this->paso, 'view_orden', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->paso->OptionCount = 7;
        $this->paso->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->paso->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['paso'] = &$this->paso;

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
        $this->proveedor->addMethod("getDefault", fn() => 0);
        $this->proveedor->InputTextType = "text";
        $this->proveedor->Raw = true;
        $this->proveedor->Nullable = false; // NOT NULL field
        $this->proveedor->Required = true; // Required field
        $this->proveedor->setSelectMultiple(false); // Select one
        $this->proveedor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->proveedor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->proveedor->Lookup = new Lookup($this->proveedor, 'sco_proveedor', false, 'Nproveedor', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->proveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proveedor->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['proveedor'] = &$this->proveedor;

        // responsable_servicio
        $this->responsable_servicio = new DbField(
            $this, // Table
            'x_responsable_servicio', // Variable name
            'responsable_servicio', // Name
            '`responsable_servicio`', // Expression
            '`responsable_servicio`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`responsable_servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->responsable_servicio->InputTextType = "text";
        $this->responsable_servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['responsable_servicio'] = &$this->responsable_servicio;

        // fecha_inicio
        $this->fecha_inicio = new DbField(
            $this, // Table
            'x_fecha_inicio', // Variable name
            'fecha_inicio', // Name
            '`fecha_inicio`', // Expression
            CastDateFieldForLike("`fecha_inicio`", 0, "DB"), // Basic search expression
            135, // Type
            76, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_inicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_inicio->InputTextType = "text";
        $this->fecha_inicio->Raw = true;
        $this->fecha_inicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_inicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_inicio'] = &$this->fecha_inicio;

        // hora_inicio
        $this->hora_inicio = new DbField(
            $this, // Table
            'x_hora_inicio', // Variable name
            'hora_inicio', // Name
            '`hora_inicio`', // Expression
            CastDateFieldForLike("`hora_inicio`", 0, "DB"), // Basic search expression
            134, // Type
            40, // Size
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

        // horas
        $this->horas = new DbField(
            $this, // Table
            'x_horas', // Variable name
            'horas', // Name
            '`horas`', // Expression
            '`horas`', // Basic search expression
            20, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`horas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->horas->addMethod("getDefault", fn() => 0);
        $this->horas->InputTextType = "text";
        $this->horas->Raw = true;
        $this->horas->Nullable = false; // NOT NULL field
        $this->horas->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->horas->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['horas'] = &$this->horas;

        // fecha_fin
        $this->fecha_fin = new DbField(
            $this, // Table
            'x_fecha_fin', // Variable name
            'fecha_fin', // Name
            '`fecha_fin`', // Expression
            CastDateFieldForLike("`fecha_fin`", 0, "DB"), // Basic search expression
            135, // Type
            76, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_fin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_fin->InputTextType = "text";
        $this->fecha_fin->Raw = true;
        $this->fecha_fin->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_fin->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_fin'] = &$this->fecha_fin;

        // hora_fin
        $this->hora_fin = new DbField(
            $this, // Table
            'x_hora_fin', // Variable name
            'hora_fin', // Name
            '`hora_fin`', // Expression
            CastDateFieldForLike("`hora_fin`", 0, "DB"), // Basic search expression
            134, // Type
            40, // Size
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

        // capilla
        $this->capilla = new DbField(
            $this, // Table
            'x_capilla', // Variable name
            'capilla', // Name
            '`capilla`', // Expression
            '`capilla`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`capilla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->capilla->InputTextType = "text";
        $this->capilla->Raw = true;
        $this->capilla->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->capilla->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['capilla'] = &$this->capilla;

        // cantidad
        $this->cantidad = new DbField(
            $this, // Table
            'x_cantidad', // Variable name
            'cantidad', // Name
            '`cantidad`', // Expression
            '`cantidad`', // Basic search expression
            16, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cantidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cantidad->addMethod("getDefault", fn() => 1);
        $this->cantidad->InputTextType = "text";
        $this->cantidad->Raw = true;
        $this->cantidad->Nullable = false; // NOT NULL field
        $this->cantidad->Required = true; // Required field
        $this->cantidad->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cantidad->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['cantidad'] = &$this->cantidad;

        // costo
        $this->costo = new DbField(
            $this, // Table
            'x_costo', // Variable name
            'costo', // Name
            '`costo`', // Expression
            '`costo`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`costo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->costo->addMethod("getDefault", fn() => 0);
        $this->costo->InputTextType = "text";
        $this->costo->Raw = true;
        $this->costo->Nullable = false; // NOT NULL field
        $this->costo->Required = true; // Required field
        $this->costo->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->costo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['costo'] = &$this->costo;

        // total
        $this->total = new DbField(
            $this, // Table
            'x_total', // Variable name
            'total', // Name
            '`total`', // Expression
            '`total`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`total`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->total->addMethod("getDefault", fn() => 0);
        $this->total->InputTextType = "text";
        $this->total->Raw = true;
        $this->total->Nullable = false; // NOT NULL field
        $this->total->Required = true; // Required field
        $this->total->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->total->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['total'] = &$this->total;

        // nota
        $this->nota = new DbField(
            $this, // Table
            'x_nota', // Variable name
            'nota', // Name
            '`nota`', // Expression
            '`nota`', // Basic search expression
            200, // Type
            65535, // Size
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

        // referencia_ubicacion
        $this->referencia_ubicacion = new DbField(
            $this, // Table
            'x_referencia_ubicacion', // Variable name
            'referencia_ubicacion', // Name
            '`referencia_ubicacion`', // Expression
            '`referencia_ubicacion`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`referencia_ubicacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->referencia_ubicacion->InputTextType = "text";
        $this->referencia_ubicacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['referencia_ubicacion'] = &$this->referencia_ubicacion;

        // anulada
        $this->anulada = new DbField(
            $this, // Table
            'x_anulada', // Variable name
            'anulada', // Name
            '`anulada`', // Expression
            '`anulada`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`anulada`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->anulada->InputTextType = "text";
        $this->anulada->Raw = true;
        $this->anulada->Lookup = new Lookup($this->anulada, 'view_orden', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->anulada->OptionCount = 2;
        $this->anulada->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['anulada'] = &$this->anulada;

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
            76, // Size
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

        // media_hora
        $this->media_hora = new DbField(
            $this, // Table
            'x_media_hora', // Variable name
            'media_hora', // Name
            '`media_hora`', // Expression
            '`media_hora`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`media_hora`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->media_hora->addMethod("getDefault", fn() => "N");
        $this->media_hora->InputTextType = "text";
        $this->media_hora->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['media_hora'] = &$this->media_hora;

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

        // adjunto
        $this->adjunto = new DbField(
            $this, // Table
            'x_adjunto', // Variable name
            'adjunto', // Name
            '`adjunto`', // Expression
            '`adjunto`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`adjunto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->adjunto->InputTextType = "text";
        $this->adjunto->Raw = true;
        $this->adjunto->setSelectMultiple(false); // Select one
        $this->adjunto->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->adjunto->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->adjunto->Lookup = new Lookup($this->adjunto, 'sco_adjunto', false, 'Nadjunto', ["nota","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nota`");
        $this->adjunto->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->adjunto->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['adjunto'] = &$this->adjunto;

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

        // contacto
        $this->contacto = new DbField(
            $this, // Table
            'x_contacto', // Variable name
            'contacto', // Name
            '`contacto`', // Expression
            '`contacto`', // Basic search expression
            200, // Type
            101, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contacto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contacto->InputTextType = "text";
        $this->contacto->Required = true; // Required field
        $this->contacto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['contacto'] = &$this->contacto;

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

        // llevar_a
        $this->llevar_a = new DbField(
            $this, // Table
            'x_llevar_a', // Variable name
            'llevar_a', // Name
            '`llevar_a`', // Expression
            '`llevar_a`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`llevar_a`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->llevar_a->InputTextType = "text";
        $this->llevar_a->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['llevar_a'] = &$this->llevar_a;

        // servicio_atendido
        $this->servicio_atendido = new DbField(
            $this, // Table
            'x_servicio_atendido', // Variable name
            'servicio_atendido', // Name
            '`servicio_atendido`', // Expression
            '`servicio_atendido`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicio_atendido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->servicio_atendido->addMethod("getDefault", fn() => "N");
        $this->servicio_atendido->InputTextType = "text";
        $this->servicio_atendido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio_atendido'] = &$this->servicio_atendido;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_orden";
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
            $this->Norden->setDbValue($conn->lastInsertId());
            $rs['Norden'] = $this->Norden->DbValue;
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
            if (!isset($rs['Norden']) && !EmptyValue($this->Norden->CurrentValue)) {
                $rs['Norden'] = $this->Norden->CurrentValue;
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
            if (array_key_exists('Norden', $rs)) {
                AddFilter($where, QuotedName('Norden', $this->Dbid) . '=' . QuotedValue($rs['Norden'], $this->Norden->DataType, $this->Dbid));
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
        $this->Norden->DbValue = $row['Norden'];
        $this->expediente->DbValue = $row['expediente'];
        $this->difunto->DbValue = $row['difunto'];
        $this->servicio_tipo->DbValue = $row['servicio_tipo'];
        $this->servicio->DbValue = $row['servicio'];
        $this->paso->DbValue = $row['paso'];
        $this->proveedor->DbValue = $row['proveedor'];
        $this->responsable_servicio->DbValue = $row['responsable_servicio'];
        $this->fecha_inicio->DbValue = $row['fecha_inicio'];
        $this->hora_inicio->DbValue = $row['hora_inicio'];
        $this->horas->DbValue = $row['horas'];
        $this->fecha_fin->DbValue = $row['fecha_fin'];
        $this->hora_fin->DbValue = $row['hora_fin'];
        $this->capilla->DbValue = $row['capilla'];
        $this->cantidad->DbValue = $row['cantidad'];
        $this->costo->DbValue = $row['costo'];
        $this->total->DbValue = $row['total'];
        $this->nota->DbValue = $row['nota'];
        $this->referencia_ubicacion->DbValue = $row['referencia_ubicacion'];
        $this->anulada->DbValue = $row['anulada'];
        $this->user_registra->DbValue = $row['user_registra'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->media_hora->DbValue = $row['media_hora'];
        $this->espera_cenizas->DbValue = $row['espera_cenizas'];
        $this->adjunto->DbValue = $row['adjunto'];
        $this->cedula_fallecido->DbValue = $row['cedula_fallecido'];
        $this->contacto->DbValue = $row['contacto'];
        $this->telefono_contacto1->DbValue = $row['telefono_contacto1'];
        $this->telefono_contacto2->DbValue = $row['telefono_contacto2'];
        $this->llevar_a->DbValue = $row['llevar_a'];
        $this->servicio_atendido->DbValue = $row['servicio_atendido'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Norden` = @Norden@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Norden->CurrentValue : $this->Norden->OldValue;
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
                $this->Norden->CurrentValue = $keys[0];
            } else {
                $this->Norden->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Norden', $row) ? $row['Norden'] : null;
        } else {
            $val = !EmptyValue($this->Norden->OldValue) && !$current ? $this->Norden->OldValue : $this->Norden->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Norden@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ViewOrdenList");
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
            "ViewOrdenView" => $Language->phrase("View"),
            "ViewOrdenEdit" => $Language->phrase("Edit"),
            "ViewOrdenAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewOrdenList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewOrdenView",
            Config("API_ADD_ACTION") => "ViewOrdenAdd",
            Config("API_EDIT_ACTION") => "ViewOrdenEdit",
            Config("API_DELETE_ACTION") => "ViewOrdenDelete",
            Config("API_LIST_ACTION") => "ViewOrdenList",
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
        return "ViewOrdenList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewOrdenView", $parm);
        } else {
            $url = $this->keyUrl("ViewOrdenView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewOrdenAdd?" . $parm;
        } else {
            $url = "ViewOrdenAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewOrdenEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewOrdenList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewOrdenAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewOrdenList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewOrdenDelete", $parm);
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
        $json .= "\"Norden\":" . VarToJson($this->Norden->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Norden->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Norden->CurrentValue);
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
            if (($keyValue = Param("Norden") ?? Route("Norden")) !== null) {
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
                $this->Norden->CurrentValue = $key;
            } else {
                $this->Norden->OldValue = $key;
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
        $this->Norden->setDbValue($row['Norden']);
        $this->expediente->setDbValue($row['expediente']);
        $this->difunto->setDbValue($row['difunto']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->paso->setDbValue($row['paso']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->responsable_servicio->setDbValue($row['responsable_servicio']);
        $this->fecha_inicio->setDbValue($row['fecha_inicio']);
        $this->hora_inicio->setDbValue($row['hora_inicio']);
        $this->horas->setDbValue($row['horas']);
        $this->fecha_fin->setDbValue($row['fecha_fin']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->capilla->setDbValue($row['capilla']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->costo->setDbValue($row['costo']);
        $this->total->setDbValue($row['total']);
        $this->nota->setDbValue($row['nota']);
        $this->referencia_ubicacion->setDbValue($row['referencia_ubicacion']);
        $this->anulada->setDbValue($row['anulada']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->media_hora->setDbValue($row['media_hora']);
        $this->espera_cenizas->setDbValue($row['espera_cenizas']);
        $this->adjunto->setDbValue($row['adjunto']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->contacto->setDbValue($row['contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->llevar_a->setDbValue($row['llevar_a']);
        $this->servicio_atendido->setDbValue($row['servicio_atendido']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewOrdenList";
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

        // Norden

        // expediente

        // difunto

        // servicio_tipo

        // servicio

        // paso

        // proveedor

        // responsable_servicio

        // fecha_inicio

        // hora_inicio

        // horas

        // fecha_fin

        // hora_fin

        // capilla

        // cantidad

        // costo

        // total

        // nota

        // referencia_ubicacion

        // anulada

        // user_registra

        // fecha_registro

        // media_hora

        // espera_cenizas

        // adjunto

        // cedula_fallecido

        // contacto

        // telefono_contacto1

        // telefono_contacto2

        // llevar_a

        // servicio_atendido

        // Norden
        $this->Norden->ViewValue = $this->Norden->CurrentValue;

        // expediente
        $this->expediente->ViewValue = $this->expediente->CurrentValue;

        // difunto
        $this->difunto->ViewValue = $this->difunto->CurrentValue;

        // servicio_tipo
        $curVal = strval($this->servicio_tipo->CurrentValue);
        if ($curVal != "") {
            $this->servicio_tipo->ViewValue = $this->servicio_tipo->lookupCacheOption($curVal);
            if ($this->servicio_tipo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchExpression(), "=", $curVal, $this->servicio_tipo->Lookup->getTable()->Fields["Nservicio_tipo"]->searchDataType(), "");
                $sqlWrk = $this->servicio_tipo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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
                $sqlWrk = $this->servicio->Lookup->getSql(false, $filterWrk, '', $this, true, true);
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

        // paso
        if (strval($this->paso->CurrentValue) != "") {
            $this->paso->ViewValue = $this->paso->optionCaption($this->paso->CurrentValue);
        } else {
            $this->paso->ViewValue = null;
        }

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

        // responsable_servicio
        $this->responsable_servicio->ViewValue = $this->responsable_servicio->CurrentValue;

        // fecha_inicio
        $this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;
        $this->fecha_inicio->ViewValue = FormatDateTime($this->fecha_inicio->ViewValue, $this->fecha_inicio->formatPattern());

        // hora_inicio
        $this->hora_inicio->ViewValue = $this->hora_inicio->CurrentValue;

        // horas
        $this->horas->ViewValue = $this->horas->CurrentValue;

        // fecha_fin
        $this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;
        $this->fecha_fin->ViewValue = FormatDateTime($this->fecha_fin->ViewValue, $this->fecha_fin->formatPattern());

        // hora_fin
        $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;

        // capilla
        $this->capilla->ViewValue = $this->capilla->CurrentValue;

        // cantidad
        $this->cantidad->ViewValue = $this->cantidad->CurrentValue;

        // costo
        $this->costo->ViewValue = $this->costo->CurrentValue;
        $this->costo->ViewValue = FormatNumber($this->costo->ViewValue, $this->costo->formatPattern());

        // total
        $this->total->ViewValue = $this->total->CurrentValue;
        $this->total->ViewValue = FormatNumber($this->total->ViewValue, $this->total->formatPattern());

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // referencia_ubicacion
        $this->referencia_ubicacion->ViewValue = $this->referencia_ubicacion->CurrentValue;

        // anulada
        if (strval($this->anulada->CurrentValue) != "") {
            $this->anulada->ViewValue = $this->anulada->optionCaption($this->anulada->CurrentValue);
        } else {
            $this->anulada->ViewValue = null;
        }

        // user_registra
        $this->user_registra->ViewValue = $this->user_registra->CurrentValue;

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

        // media_hora
        $this->media_hora->ViewValue = $this->media_hora->CurrentValue;

        // espera_cenizas
        $this->espera_cenizas->ViewValue = $this->espera_cenizas->CurrentValue;

        // adjunto
        $curVal = strval($this->adjunto->CurrentValue);
        if ($curVal != "") {
            $this->adjunto->ViewValue = $this->adjunto->lookupCacheOption($curVal);
            if ($this->adjunto->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->adjunto->Lookup->getTable()->Fields["Nadjunto"]->searchExpression(), "=", $curVal, $this->adjunto->Lookup->getTable()->Fields["Nadjunto"]->searchDataType(), "");
                $sqlWrk = $this->adjunto->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->adjunto->Lookup->renderViewRow($rswrk[0]);
                    $this->adjunto->ViewValue = $this->adjunto->displayValue($arwrk);
                } else {
                    $this->adjunto->ViewValue = $this->adjunto->CurrentValue;
                }
            }
        } else {
            $this->adjunto->ViewValue = null;
        }

        // cedula_fallecido
        $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

        // contacto
        $this->contacto->ViewValue = $this->contacto->CurrentValue;

        // telefono_contacto1
        $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

        // telefono_contacto2
        $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

        // llevar_a
        $this->llevar_a->ViewValue = $this->llevar_a->CurrentValue;

        // servicio_atendido
        $this->servicio_atendido->ViewValue = $this->servicio_atendido->CurrentValue;

        // Norden
        $this->Norden->HrefValue = "";
        $this->Norden->TooltipValue = "";

        // expediente
        $this->expediente->HrefValue = "";
        $this->expediente->TooltipValue = "";

        // difunto
        $this->difunto->HrefValue = "";
        $this->difunto->TooltipValue = "";

        // servicio_tipo
        $this->servicio_tipo->HrefValue = "";
        $this->servicio_tipo->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // paso
        $this->paso->HrefValue = "";
        $this->paso->TooltipValue = "";

        // proveedor
        $this->proveedor->HrefValue = "";
        $this->proveedor->TooltipValue = "";

        // responsable_servicio
        $this->responsable_servicio->HrefValue = "";
        $this->responsable_servicio->TooltipValue = "";

        // fecha_inicio
        $this->fecha_inicio->HrefValue = "";
        $this->fecha_inicio->TooltipValue = "";

        // hora_inicio
        $this->hora_inicio->HrefValue = "";
        $this->hora_inicio->TooltipValue = "";

        // horas
        $this->horas->HrefValue = "";
        $this->horas->TooltipValue = "";

        // fecha_fin
        $this->fecha_fin->HrefValue = "";
        $this->fecha_fin->TooltipValue = "";

        // hora_fin
        $this->hora_fin->HrefValue = "";
        $this->hora_fin->TooltipValue = "";

        // capilla
        $this->capilla->HrefValue = "";
        $this->capilla->TooltipValue = "";

        // cantidad
        $this->cantidad->HrefValue = "";
        $this->cantidad->TooltipValue = "";

        // costo
        $this->costo->HrefValue = "";
        $this->costo->TooltipValue = "";

        // total
        $this->total->HrefValue = "";
        $this->total->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // referencia_ubicacion
        $this->referencia_ubicacion->HrefValue = "";
        $this->referencia_ubicacion->TooltipValue = "";

        // anulada
        $this->anulada->HrefValue = "";
        $this->anulada->TooltipValue = "";

        // user_registra
        $this->user_registra->HrefValue = "";
        $this->user_registra->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // media_hora
        $this->media_hora->HrefValue = "";
        $this->media_hora->TooltipValue = "";

        // espera_cenizas
        $this->espera_cenizas->HrefValue = "";
        $this->espera_cenizas->TooltipValue = "";

        // adjunto
        $this->adjunto->HrefValue = "";
        $this->adjunto->TooltipValue = "";

        // cedula_fallecido
        $this->cedula_fallecido->HrefValue = "";
        $this->cedula_fallecido->TooltipValue = "";

        // contacto
        $this->contacto->HrefValue = "";
        $this->contacto->TooltipValue = "";

        // telefono_contacto1
        $this->telefono_contacto1->HrefValue = "";
        $this->telefono_contacto1->TooltipValue = "";

        // telefono_contacto2
        $this->telefono_contacto2->HrefValue = "";
        $this->telefono_contacto2->TooltipValue = "";

        // llevar_a
        $this->llevar_a->HrefValue = "";
        $this->llevar_a->TooltipValue = "";

        // servicio_atendido
        $this->servicio_atendido->HrefValue = "";
        $this->servicio_atendido->TooltipValue = "";

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

        // Norden
        $this->Norden->setupEditAttributes();
        $this->Norden->EditValue = $this->Norden->CurrentValue;

        // expediente
        $this->expediente->setupEditAttributes();
        $this->expediente->EditValue = $this->expediente->CurrentValue;
        $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());
        if (strval($this->expediente->EditValue) != "" && is_numeric($this->expediente->EditValue)) {
            $this->expediente->EditValue = $this->expediente->EditValue;
        }

        // difunto
        $this->difunto->setupEditAttributes();
        if (!$this->difunto->Raw) {
            $this->difunto->CurrentValue = HtmlDecode($this->difunto->CurrentValue);
        }
        $this->difunto->EditValue = $this->difunto->CurrentValue;
        $this->difunto->PlaceHolder = RemoveHtml($this->difunto->caption());

        // servicio_tipo
        $this->servicio_tipo->setupEditAttributes();
        $this->servicio_tipo->PlaceHolder = RemoveHtml($this->servicio_tipo->caption());

        // servicio
        $this->servicio->setupEditAttributes();
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // paso
        $this->paso->setupEditAttributes();
        $this->paso->EditValue = $this->paso->options(true);
        $this->paso->PlaceHolder = RemoveHtml($this->paso->caption());

        // proveedor
        $this->proveedor->setupEditAttributes();
        $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());

        // responsable_servicio
        $this->responsable_servicio->setupEditAttributes();
        if (!$this->responsable_servicio->Raw) {
            $this->responsable_servicio->CurrentValue = HtmlDecode($this->responsable_servicio->CurrentValue);
        }
        $this->responsable_servicio->EditValue = $this->responsable_servicio->CurrentValue;
        $this->responsable_servicio->PlaceHolder = RemoveHtml($this->responsable_servicio->caption());

        // fecha_inicio
        $this->fecha_inicio->setupEditAttributes();
        $this->fecha_inicio->EditValue = FormatDateTime($this->fecha_inicio->CurrentValue, $this->fecha_inicio->formatPattern());
        $this->fecha_inicio->PlaceHolder = RemoveHtml($this->fecha_inicio->caption());

        // hora_inicio
        $this->hora_inicio->setupEditAttributes();
        $this->hora_inicio->EditValue = $this->hora_inicio->CurrentValue;
        $this->hora_inicio->PlaceHolder = RemoveHtml($this->hora_inicio->caption());

        // horas
        $this->horas->setupEditAttributes();
        $this->horas->EditValue = $this->horas->CurrentValue;
        $this->horas->PlaceHolder = RemoveHtml($this->horas->caption());
        if (strval($this->horas->EditValue) != "" && is_numeric($this->horas->EditValue)) {
            $this->horas->EditValue = $this->horas->EditValue;
        }

        // fecha_fin
        $this->fecha_fin->setupEditAttributes();
        $this->fecha_fin->EditValue = FormatDateTime($this->fecha_fin->CurrentValue, $this->fecha_fin->formatPattern());
        $this->fecha_fin->PlaceHolder = RemoveHtml($this->fecha_fin->caption());

        // hora_fin
        $this->hora_fin->setupEditAttributes();
        $this->hora_fin->EditValue = $this->hora_fin->CurrentValue;
        $this->hora_fin->PlaceHolder = RemoveHtml($this->hora_fin->caption());

        // capilla
        $this->capilla->setupEditAttributes();
        $this->capilla->EditValue = $this->capilla->CurrentValue;
        $this->capilla->PlaceHolder = RemoveHtml($this->capilla->caption());
        if (strval($this->capilla->EditValue) != "" && is_numeric($this->capilla->EditValue)) {
            $this->capilla->EditValue = $this->capilla->EditValue;
        }

        // cantidad
        $this->cantidad->setupEditAttributes();
        $this->cantidad->EditValue = $this->cantidad->CurrentValue;
        $this->cantidad->PlaceHolder = RemoveHtml($this->cantidad->caption());
        if (strval($this->cantidad->EditValue) != "" && is_numeric($this->cantidad->EditValue)) {
            $this->cantidad->EditValue = $this->cantidad->EditValue;
        }

        // costo
        $this->costo->setupEditAttributes();
        $this->costo->EditValue = $this->costo->CurrentValue;
        $this->costo->PlaceHolder = RemoveHtml($this->costo->caption());
        if (strval($this->costo->EditValue) != "" && is_numeric($this->costo->EditValue)) {
            $this->costo->EditValue = FormatNumber($this->costo->EditValue, null);
        }

        // total
        $this->total->setupEditAttributes();
        $this->total->EditValue = $this->total->CurrentValue;
        $this->total->PlaceHolder = RemoveHtml($this->total->caption());
        if (strval($this->total->EditValue) != "" && is_numeric($this->total->EditValue)) {
            $this->total->EditValue = FormatNumber($this->total->EditValue, null);
        }

        // nota
        $this->nota->setupEditAttributes();
        if (!$this->nota->Raw) {
            $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
        }
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // referencia_ubicacion
        $this->referencia_ubicacion->setupEditAttributes();
        if (!$this->referencia_ubicacion->Raw) {
            $this->referencia_ubicacion->CurrentValue = HtmlDecode($this->referencia_ubicacion->CurrentValue);
        }
        $this->referencia_ubicacion->EditValue = $this->referencia_ubicacion->CurrentValue;
        $this->referencia_ubicacion->PlaceHolder = RemoveHtml($this->referencia_ubicacion->caption());

        // anulada
        $this->anulada->EditValue = $this->anulada->options(false);
        $this->anulada->PlaceHolder = RemoveHtml($this->anulada->caption());

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

        // media_hora
        $this->media_hora->setupEditAttributes();
        if (!$this->media_hora->Raw) {
            $this->media_hora->CurrentValue = HtmlDecode($this->media_hora->CurrentValue);
        }
        $this->media_hora->EditValue = $this->media_hora->CurrentValue;
        $this->media_hora->PlaceHolder = RemoveHtml($this->media_hora->caption());

        // espera_cenizas
        $this->espera_cenizas->setupEditAttributes();
        if (!$this->espera_cenizas->Raw) {
            $this->espera_cenizas->CurrentValue = HtmlDecode($this->espera_cenizas->CurrentValue);
        }
        $this->espera_cenizas->EditValue = $this->espera_cenizas->CurrentValue;
        $this->espera_cenizas->PlaceHolder = RemoveHtml($this->espera_cenizas->caption());

        // adjunto
        $this->adjunto->setupEditAttributes();
        $this->adjunto->PlaceHolder = RemoveHtml($this->adjunto->caption());

        // cedula_fallecido
        $this->cedula_fallecido->setupEditAttributes();
        if (!$this->cedula_fallecido->Raw) {
            $this->cedula_fallecido->CurrentValue = HtmlDecode($this->cedula_fallecido->CurrentValue);
        }
        $this->cedula_fallecido->EditValue = $this->cedula_fallecido->CurrentValue;
        $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

        // contacto
        $this->contacto->setupEditAttributes();
        if (!$this->contacto->Raw) {
            $this->contacto->CurrentValue = HtmlDecode($this->contacto->CurrentValue);
        }
        $this->contacto->EditValue = $this->contacto->CurrentValue;
        $this->contacto->PlaceHolder = RemoveHtml($this->contacto->caption());

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

        // llevar_a
        $this->llevar_a->setupEditAttributes();
        if (!$this->llevar_a->Raw) {
            $this->llevar_a->CurrentValue = HtmlDecode($this->llevar_a->CurrentValue);
        }
        $this->llevar_a->EditValue = $this->llevar_a->CurrentValue;
        $this->llevar_a->PlaceHolder = RemoveHtml($this->llevar_a->caption());

        // servicio_atendido
        $this->servicio_atendido->setupEditAttributes();
        if (!$this->servicio_atendido->Raw) {
            $this->servicio_atendido->CurrentValue = HtmlDecode($this->servicio_atendido->CurrentValue);
        }
        $this->servicio_atendido->EditValue = $this->servicio_atendido->CurrentValue;
        $this->servicio_atendido->PlaceHolder = RemoveHtml($this->servicio_atendido->caption());

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
                    $doc->exportCaption($this->Norden);
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->difunto);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->paso);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->fecha_inicio);
                    $doc->exportCaption($this->hora_inicio);
                    $doc->exportCaption($this->horas);
                    $doc->exportCaption($this->fecha_fin);
                    $doc->exportCaption($this->hora_fin);
                    $doc->exportCaption($this->cantidad);
                    $doc->exportCaption($this->adjunto);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->llevar_a);
                    $doc->exportCaption($this->servicio_atendido);
                } else {
                    $doc->exportCaption($this->Norden);
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->difunto);
                    $doc->exportCaption($this->servicio_tipo);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->paso);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->responsable_servicio);
                    $doc->exportCaption($this->fecha_inicio);
                    $doc->exportCaption($this->hora_inicio);
                    $doc->exportCaption($this->horas);
                    $doc->exportCaption($this->fecha_fin);
                    $doc->exportCaption($this->hora_fin);
                    $doc->exportCaption($this->capilla);
                    $doc->exportCaption($this->cantidad);
                    $doc->exportCaption($this->costo);
                    $doc->exportCaption($this->total);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->referencia_ubicacion);
                    $doc->exportCaption($this->anulada);
                    $doc->exportCaption($this->user_registra);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->media_hora);
                    $doc->exportCaption($this->espera_cenizas);
                    $doc->exportCaption($this->adjunto);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->contacto);
                    $doc->exportCaption($this->telefono_contacto1);
                    $doc->exportCaption($this->telefono_contacto2);
                    $doc->exportCaption($this->llevar_a);
                    $doc->exportCaption($this->servicio_atendido);
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
                        $doc->exportField($this->Norden);
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->difunto);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->paso);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->fecha_inicio);
                        $doc->exportField($this->hora_inicio);
                        $doc->exportField($this->horas);
                        $doc->exportField($this->fecha_fin);
                        $doc->exportField($this->hora_fin);
                        $doc->exportField($this->cantidad);
                        $doc->exportField($this->adjunto);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->llevar_a);
                        $doc->exportField($this->servicio_atendido);
                    } else {
                        $doc->exportField($this->Norden);
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->difunto);
                        $doc->exportField($this->servicio_tipo);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->paso);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->responsable_servicio);
                        $doc->exportField($this->fecha_inicio);
                        $doc->exportField($this->hora_inicio);
                        $doc->exportField($this->horas);
                        $doc->exportField($this->fecha_fin);
                        $doc->exportField($this->hora_fin);
                        $doc->exportField($this->capilla);
                        $doc->exportField($this->cantidad);
                        $doc->exportField($this->costo);
                        $doc->exportField($this->total);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->referencia_ubicacion);
                        $doc->exportField($this->anulada);
                        $doc->exportField($this->user_registra);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->media_hora);
                        $doc->exportField($this->espera_cenizas);
                        $doc->exportField($this->adjunto);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->contacto);
                        $doc->exportField($this->telefono_contacto1);
                        $doc->exportField($this->telefono_contacto2);
                        $doc->exportField($this->llevar_a);
                        $doc->exportField($this->servicio_atendido);
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
    	if(CurrentUserLevel() > -1) {
    		$sql = "SELECT tipo_proveedor as paso FROM userlevels WHERE userlevelid = '" . CurrentUserLevel() . "';";
    		$paso = ExecuteScalar($sql);
    		AddFilter($filter, "paso = '$paso'");
    		$sql = "SELECT proveedor FROM sco_user WHERE username = '" . CurrentUserName() . "';";
    		$proveedor = ExecuteScalar($sql);
    		AddFilter($filter, "proveedor = '$proveedor'");
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
