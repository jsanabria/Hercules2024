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
 * Table class for sco_parcela_ventas
 */
class ScoParcelaVentas extends DbTable
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
    public $Nparcela_ventas;
    public $fecha_compra;
    public $usuario_compra;
    public $terraza;
    public $seccion;
    public $modulo;
    public $subseccion;
    public $parcela;
    public $ci_vendedor;
    public $vendedor;
    public $valor_compra;
    public $moneda_compra;
    public $tasa_compra;
    public $fecha_venta;
    public $usuario_vende;
    public $ci_comprador;
    public $comprador;
    public $valor_venta;
    public $moneda_venta;
    public $tasa_venta;
    public $id_parcela;
    public $nota;
    public $estatus;
    public $fecha_registro;
    public $numero_factura;
    public $orden_pago;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_parcela_ventas";
        $this->TableName = 'sco_parcela_ventas';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_parcela_ventas";
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

        // Nparcela_ventas
        $this->Nparcela_ventas = new DbField(
            $this, // Table
            'x_Nparcela_ventas', // Variable name
            'Nparcela_ventas', // Name
            '`Nparcela_ventas`', // Expression
            '`Nparcela_ventas`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nparcela_ventas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nparcela_ventas->InputTextType = "text";
        $this->Nparcela_ventas->Raw = true;
        $this->Nparcela_ventas->IsAutoIncrement = true; // Autoincrement field
        $this->Nparcela_ventas->IsPrimaryKey = true; // Primary key field
        $this->Nparcela_ventas->IsForeignKey = true; // Foreign key field
        $this->Nparcela_ventas->Nullable = false; // NOT NULL field
        $this->Nparcela_ventas->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nparcela_ventas->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nparcela_ventas'] = &$this->Nparcela_ventas;

        // fecha_compra
        $this->fecha_compra = new DbField(
            $this, // Table
            'x_fecha_compra', // Variable name
            'fecha_compra', // Name
            '`fecha_compra`', // Expression
            CastDateFieldForLike("`fecha_compra`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_compra->InputTextType = "text";
        $this->fecha_compra->Raw = true;
        $this->fecha_compra->Required = true; // Required field
        $this->fecha_compra->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_compra->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_compra'] = &$this->fecha_compra;

        // usuario_compra
        $this->usuario_compra = new DbField(
            $this, // Table
            'x_usuario_compra', // Variable name
            'usuario_compra', // Name
            '`usuario_compra`', // Expression
            '`usuario_compra`', // Basic search expression
            200, // Type
            25, // Size
            0, // Date/Time format
            false, // Is upload field
            '`usuario_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->usuario_compra->InputTextType = "text";
        $this->usuario_compra->Lookup = new Lookup($this->usuario_compra, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nombre`");
        $this->usuario_compra->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->usuario_compra->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario_compra'] = &$this->usuario_compra;

        // terraza
        $this->terraza = new DbField(
            $this, // Table
            'x_terraza', // Variable name
            'terraza', // Name
            '`terraza`', // Expression
            '`terraza`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`terraza`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->terraza->InputTextType = "text";
        $this->terraza->Required = true; // Required field
        $this->terraza->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['terraza'] = &$this->terraza;

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

        // subseccion
        $this->subseccion = new DbField(
            $this, // Table
            'x_subseccion', // Variable name
            'subseccion', // Name
            '`subseccion`', // Expression
            '`subseccion`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`subseccion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->subseccion->InputTextType = "text";
        $this->subseccion->Required = true; // Required field
        $this->subseccion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['subseccion'] = &$this->subseccion;

        // parcela
        $this->parcela = new DbField(
            $this, // Table
            'x_parcela', // Variable name
            'parcela', // Name
            '`parcela`', // Expression
            '`parcela`', // Basic search expression
            200, // Type
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

        // ci_vendedor
        $this->ci_vendedor = new DbField(
            $this, // Table
            'x_ci_vendedor', // Variable name
            'ci_vendedor', // Name
            '`ci_vendedor`', // Expression
            '`ci_vendedor`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ci_vendedor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ci_vendedor->InputTextType = "text";
        $this->ci_vendedor->Required = true; // Required field
        $this->ci_vendedor->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_vendedor'] = &$this->ci_vendedor;

        // vendedor
        $this->vendedor = new DbField(
            $this, // Table
            'x_vendedor', // Variable name
            'vendedor', // Name
            '`vendedor`', // Expression
            '`vendedor`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`vendedor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->vendedor->InputTextType = "text";
        $this->vendedor->Required = true; // Required field
        $this->vendedor->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['vendedor'] = &$this->vendedor;

        // valor_compra
        $this->valor_compra = new DbField(
            $this, // Table
            'x_valor_compra', // Variable name
            'valor_compra', // Name
            '`valor_compra`', // Expression
            '`valor_compra`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`valor_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->valor_compra->InputTextType = "text";
        $this->valor_compra->Raw = true;
        $this->valor_compra->Required = true; // Required field
        $this->valor_compra->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->valor_compra->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['valor_compra'] = &$this->valor_compra;

        // moneda_compra
        $this->moneda_compra = new DbField(
            $this, // Table
            'x_moneda_compra', // Variable name
            'moneda_compra', // Name
            '`moneda_compra`', // Expression
            '`moneda_compra`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`moneda_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->moneda_compra->addMethod("getSelectFilter", fn() => "`codigo` = '045'");
        $this->moneda_compra->InputTextType = "text";
        $this->moneda_compra->Required = true; // Required field
        $this->moneda_compra->Lookup = new Lookup($this->moneda_compra, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '', '', "`valor1`");
        $this->moneda_compra->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['moneda_compra'] = &$this->moneda_compra;

        // tasa_compra
        $this->tasa_compra = new DbField(
            $this, // Table
            'x_tasa_compra', // Variable name
            'tasa_compra', // Name
            '`tasa_compra`', // Expression
            '`tasa_compra`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tasa_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tasa_compra->InputTextType = "text";
        $this->tasa_compra->Raw = true;
        $this->tasa_compra->Required = true; // Required field
        $this->tasa_compra->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->tasa_compra->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tasa_compra'] = &$this->tasa_compra;

        // fecha_venta
        $this->fecha_venta = new DbField(
            $this, // Table
            'x_fecha_venta', // Variable name
            'fecha_venta', // Name
            '`fecha_venta`', // Expression
            CastDateFieldForLike("`fecha_venta`", 7, "DB"), // Basic search expression
            133, // Type
            10, // Size
            7, // Date/Time format
            false, // Is upload field
            '`fecha_venta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_venta->InputTextType = "text";
        $this->fecha_venta->Raw = true;
        $this->fecha_venta->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_venta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_venta'] = &$this->fecha_venta;

        // usuario_vende
        $this->usuario_vende = new DbField(
            $this, // Table
            'x_usuario_vende', // Variable name
            'usuario_vende', // Name
            '`usuario_vende`', // Expression
            '`usuario_vende`', // Basic search expression
            200, // Type
            25, // Size
            0, // Date/Time format
            false, // Is upload field
            '`usuario_vende`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->usuario_vende->InputTextType = "text";
        $this->usuario_vende->setSelectMultiple(false); // Select one
        $this->usuario_vende->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->usuario_vende->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->usuario_vende->Lookup = new Lookup($this->usuario_vende, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nombre`");
        $this->usuario_vende->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->usuario_vende->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['usuario_vende'] = &$this->usuario_vende;

        // ci_comprador
        $this->ci_comprador = new DbField(
            $this, // Table
            'x_ci_comprador', // Variable name
            'ci_comprador', // Name
            '`ci_comprador`', // Expression
            '`ci_comprador`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ci_comprador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ci_comprador->InputTextType = "text";
        $this->ci_comprador->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_comprador'] = &$this->ci_comprador;

        // comprador
        $this->comprador = new DbField(
            $this, // Table
            'x_comprador', // Variable name
            'comprador', // Name
            '`comprador`', // Expression
            '`comprador`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`comprador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->comprador->InputTextType = "text";
        $this->comprador->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['comprador'] = &$this->comprador;

        // valor_venta
        $this->valor_venta = new DbField(
            $this, // Table
            'x_valor_venta', // Variable name
            'valor_venta', // Name
            '`valor_venta`', // Expression
            '`valor_venta`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`valor_venta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->valor_venta->InputTextType = "text";
        $this->valor_venta->Raw = true;
        $this->valor_venta->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->valor_venta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['valor_venta'] = &$this->valor_venta;

        // moneda_venta
        $this->moneda_venta = new DbField(
            $this, // Table
            'x_moneda_venta', // Variable name
            'moneda_venta', // Name
            '`moneda_venta`', // Expression
            '`moneda_venta`', // Basic search expression
            200, // Type
            3, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`moneda_venta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->moneda_venta->addMethod("getSelectFilter", fn() => "`codigo` = '045'");
        $this->moneda_venta->InputTextType = "text";
        $this->moneda_venta->Lookup = new Lookup($this->moneda_venta, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '', '', "`valor1`");
        $this->moneda_venta->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['moneda_venta'] = &$this->moneda_venta;

        // tasa_venta
        $this->tasa_venta = new DbField(
            $this, // Table
            'x_tasa_venta', // Variable name
            'tasa_venta', // Name
            '`tasa_venta`', // Expression
            '`tasa_venta`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tasa_venta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tasa_venta->InputTextType = "text";
        $this->tasa_venta->Raw = true;
        $this->tasa_venta->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->tasa_venta->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tasa_venta'] = &$this->tasa_venta;

        // id_parcela
        $this->id_parcela = new DbField(
            $this, // Table
            'x_id_parcela', // Variable name
            'id_parcela', // Name
            '`id_parcela`', // Expression
            '`id_parcela`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`id_parcela`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->id_parcela->InputTextType = "text";
        $this->id_parcela->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['id_parcela'] = &$this->id_parcela;

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
            'TEXTAREA' // Edit Tag
        );
        $this->nota->InputTextType = "text";
        $this->nota->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nota'] = &$this->nota;

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            200, // Type
            10, // Size
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
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_parcela_ventas', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->estatus->OptionCount = 3;
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

        // numero_factura
        $this->numero_factura = new DbField(
            $this, // Table
            'x_numero_factura', // Variable name
            'numero_factura', // Name
            '`numero_factura`', // Expression
            '`numero_factura`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`numero_factura`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->numero_factura->InputTextType = "text";
        $this->numero_factura->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['numero_factura'] = &$this->numero_factura;

        // orden_pago
        $this->orden_pago = new DbField(
            $this, // Table
            'x_orden_pago', // Variable name
            'orden_pago', // Name
            '`orden_pago`', // Expression
            '`orden_pago`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`orden_pago`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->orden_pago->InputTextType = "text";
        $this->orden_pago->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['orden_pago'] = &$this->orden_pago;

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
        if ($this->getCurrentDetailTable() == "sco_parcela_ventas_nota") {
            $detailUrl = Container("sco_parcela_ventas_nota")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nparcela_ventas", $this->Nparcela_ventas->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoParcelaVentasList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_parcela_ventas";
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
            $this->Nparcela_ventas->setDbValue($conn->lastInsertId());
            $rs['Nparcela_ventas'] = $this->Nparcela_ventas->DbValue;
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
            if (!isset($rs['Nparcela_ventas']) && !EmptyValue($this->Nparcela_ventas->CurrentValue)) {
                $rs['Nparcela_ventas'] = $this->Nparcela_ventas->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nparcela_ventas';
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
            if (array_key_exists('Nparcela_ventas', $rs)) {
                AddFilter($where, QuotedName('Nparcela_ventas', $this->Dbid) . '=' . QuotedValue($rs['Nparcela_ventas'], $this->Nparcela_ventas->DataType, $this->Dbid));
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
        $this->Nparcela_ventas->DbValue = $row['Nparcela_ventas'];
        $this->fecha_compra->DbValue = $row['fecha_compra'];
        $this->usuario_compra->DbValue = $row['usuario_compra'];
        $this->terraza->DbValue = $row['terraza'];
        $this->seccion->DbValue = $row['seccion'];
        $this->modulo->DbValue = $row['modulo'];
        $this->subseccion->DbValue = $row['subseccion'];
        $this->parcela->DbValue = $row['parcela'];
        $this->ci_vendedor->DbValue = $row['ci_vendedor'];
        $this->vendedor->DbValue = $row['vendedor'];
        $this->valor_compra->DbValue = $row['valor_compra'];
        $this->moneda_compra->DbValue = $row['moneda_compra'];
        $this->tasa_compra->DbValue = $row['tasa_compra'];
        $this->fecha_venta->DbValue = $row['fecha_venta'];
        $this->usuario_vende->DbValue = $row['usuario_vende'];
        $this->ci_comprador->DbValue = $row['ci_comprador'];
        $this->comprador->DbValue = $row['comprador'];
        $this->valor_venta->DbValue = $row['valor_venta'];
        $this->moneda_venta->DbValue = $row['moneda_venta'];
        $this->tasa_venta->DbValue = $row['tasa_venta'];
        $this->id_parcela->DbValue = $row['id_parcela'];
        $this->nota->DbValue = $row['nota'];
        $this->estatus->DbValue = $row['estatus'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->numero_factura->DbValue = $row['numero_factura'];
        $this->orden_pago->DbValue = $row['orden_pago'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nparcela_ventas` = @Nparcela_ventas@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nparcela_ventas->CurrentValue : $this->Nparcela_ventas->OldValue;
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
                $this->Nparcela_ventas->CurrentValue = $keys[0];
            } else {
                $this->Nparcela_ventas->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nparcela_ventas', $row) ? $row['Nparcela_ventas'] : null;
        } else {
            $val = !EmptyValue($this->Nparcela_ventas->OldValue) && !$current ? $this->Nparcela_ventas->OldValue : $this->Nparcela_ventas->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nparcela_ventas@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoParcelaVentasList");
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
            "ScoParcelaVentasView" => $Language->phrase("View"),
            "ScoParcelaVentasEdit" => $Language->phrase("Edit"),
            "ScoParcelaVentasAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoParcelaVentasList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoParcelaVentasView",
            Config("API_ADD_ACTION") => "ScoParcelaVentasAdd",
            Config("API_EDIT_ACTION") => "ScoParcelaVentasEdit",
            Config("API_DELETE_ACTION") => "ScoParcelaVentasDelete",
            Config("API_LIST_ACTION") => "ScoParcelaVentasList",
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
        return "ScoParcelaVentasList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoParcelaVentasView", $parm);
        } else {
            $url = $this->keyUrl("ScoParcelaVentasView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoParcelaVentasAdd?" . $parm;
        } else {
            $url = "ScoParcelaVentasAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoParcelaVentasEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoParcelaVentasEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoParcelaVentasList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoParcelaVentasAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoParcelaVentasAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoParcelaVentasList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoParcelaVentasDelete", $parm);
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
        $json .= "\"Nparcela_ventas\":" . VarToJson($this->Nparcela_ventas->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nparcela_ventas->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nparcela_ventas->CurrentValue);
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
            if (($keyValue = Param("Nparcela_ventas") ?? Route("Nparcela_ventas")) !== null) {
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
                $this->Nparcela_ventas->CurrentValue = $key;
            } else {
                $this->Nparcela_ventas->OldValue = $key;
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
        $this->Nparcela_ventas->setDbValue($row['Nparcela_ventas']);
        $this->fecha_compra->setDbValue($row['fecha_compra']);
        $this->usuario_compra->setDbValue($row['usuario_compra']);
        $this->terraza->setDbValue($row['terraza']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->subseccion->setDbValue($row['subseccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->ci_vendedor->setDbValue($row['ci_vendedor']);
        $this->vendedor->setDbValue($row['vendedor']);
        $this->valor_compra->setDbValue($row['valor_compra']);
        $this->moneda_compra->setDbValue($row['moneda_compra']);
        $this->tasa_compra->setDbValue($row['tasa_compra']);
        $this->fecha_venta->setDbValue($row['fecha_venta']);
        $this->usuario_vende->setDbValue($row['usuario_vende']);
        $this->ci_comprador->setDbValue($row['ci_comprador']);
        $this->comprador->setDbValue($row['comprador']);
        $this->valor_venta->setDbValue($row['valor_venta']);
        $this->moneda_venta->setDbValue($row['moneda_venta']);
        $this->tasa_venta->setDbValue($row['tasa_venta']);
        $this->id_parcela->setDbValue($row['id_parcela']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->numero_factura->setDbValue($row['numero_factura']);
        $this->orden_pago->setDbValue($row['orden_pago']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoParcelaVentasList";
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

        // Nparcela_ventas

        // fecha_compra

        // usuario_compra

        // terraza

        // seccion

        // modulo

        // subseccion

        // parcela

        // ci_vendedor

        // vendedor

        // valor_compra

        // moneda_compra

        // tasa_compra

        // fecha_venta

        // usuario_vende

        // ci_comprador

        // comprador

        // valor_venta

        // moneda_venta

        // tasa_venta

        // id_parcela

        // nota

        // estatus

        // fecha_registro

        // numero_factura

        // orden_pago

        // Nparcela_ventas
        $this->Nparcela_ventas->ViewValue = $this->Nparcela_ventas->CurrentValue;

        // fecha_compra
        $this->fecha_compra->ViewValue = $this->fecha_compra->CurrentValue;
        $this->fecha_compra->ViewValue = FormatDateTime($this->fecha_compra->ViewValue, $this->fecha_compra->formatPattern());

        // usuario_compra
        $this->usuario_compra->ViewValue = $this->usuario_compra->CurrentValue;
        $curVal = strval($this->usuario_compra->CurrentValue);
        if ($curVal != "") {
            $this->usuario_compra->ViewValue = $this->usuario_compra->lookupCacheOption($curVal);
            if ($this->usuario_compra->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->usuario_compra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->usuario_compra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->usuario_compra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_compra->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_compra->ViewValue = $this->usuario_compra->displayValue($arwrk);
                } else {
                    $this->usuario_compra->ViewValue = $this->usuario_compra->CurrentValue;
                }
            }
        } else {
            $this->usuario_compra->ViewValue = null;
        }

        // terraza
        $this->terraza->ViewValue = $this->terraza->CurrentValue;

        // seccion
        $this->seccion->ViewValue = $this->seccion->CurrentValue;

        // modulo
        $this->modulo->ViewValue = $this->modulo->CurrentValue;

        // subseccion
        $this->subseccion->ViewValue = $this->subseccion->CurrentValue;

        // parcela
        $this->parcela->ViewValue = $this->parcela->CurrentValue;

        // ci_vendedor
        $this->ci_vendedor->ViewValue = $this->ci_vendedor->CurrentValue;

        // vendedor
        $this->vendedor->ViewValue = $this->vendedor->CurrentValue;

        // valor_compra
        $this->valor_compra->ViewValue = $this->valor_compra->CurrentValue;
        $this->valor_compra->ViewValue = FormatNumber($this->valor_compra->ViewValue, $this->valor_compra->formatPattern());

        // moneda_compra
        $curVal = strval($this->moneda_compra->CurrentValue);
        if ($curVal != "") {
            $this->moneda_compra->ViewValue = $this->moneda_compra->lookupCacheOption($curVal);
            if ($this->moneda_compra->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->moneda_compra->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->moneda_compra->getSelectFilter($this); // PHP
                $sqlWrk = $this->moneda_compra->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->moneda_compra->Lookup->renderViewRow($rswrk[0]);
                    $this->moneda_compra->ViewValue = $this->moneda_compra->displayValue($arwrk);
                } else {
                    $this->moneda_compra->ViewValue = $this->moneda_compra->CurrentValue;
                }
            }
        } else {
            $this->moneda_compra->ViewValue = null;
        }

        // tasa_compra
        $this->tasa_compra->ViewValue = $this->tasa_compra->CurrentValue;
        $this->tasa_compra->ViewValue = FormatNumber($this->tasa_compra->ViewValue, $this->tasa_compra->formatPattern());

        // fecha_venta
        $this->fecha_venta->ViewValue = $this->fecha_venta->CurrentValue;
        $this->fecha_venta->ViewValue = FormatDateTime($this->fecha_venta->ViewValue, $this->fecha_venta->formatPattern());

        // usuario_vende
        $curVal = strval($this->usuario_vende->CurrentValue);
        if ($curVal != "") {
            $this->usuario_vende->ViewValue = $this->usuario_vende->lookupCacheOption($curVal);
            if ($this->usuario_vende->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->usuario_vende->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->usuario_vende->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->usuario_vende->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->usuario_vende->Lookup->renderViewRow($rswrk[0]);
                    $this->usuario_vende->ViewValue = $this->usuario_vende->displayValue($arwrk);
                } else {
                    $this->usuario_vende->ViewValue = $this->usuario_vende->CurrentValue;
                }
            }
        } else {
            $this->usuario_vende->ViewValue = null;
        }

        // ci_comprador
        $this->ci_comprador->ViewValue = $this->ci_comprador->CurrentValue;

        // comprador
        $this->comprador->ViewValue = $this->comprador->CurrentValue;

        // valor_venta
        $this->valor_venta->ViewValue = $this->valor_venta->CurrentValue;
        $this->valor_venta->ViewValue = FormatNumber($this->valor_venta->ViewValue, $this->valor_venta->formatPattern());

        // moneda_venta
        $curVal = strval($this->moneda_venta->CurrentValue);
        if ($curVal != "") {
            $this->moneda_venta->ViewValue = $this->moneda_venta->lookupCacheOption($curVal);
            if ($this->moneda_venta->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->moneda_venta->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->moneda_venta->getSelectFilter($this); // PHP
                $sqlWrk = $this->moneda_venta->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->moneda_venta->Lookup->renderViewRow($rswrk[0]);
                    $this->moneda_venta->ViewValue = $this->moneda_venta->displayValue($arwrk);
                } else {
                    $this->moneda_venta->ViewValue = $this->moneda_venta->CurrentValue;
                }
            }
        } else {
            $this->moneda_venta->ViewValue = null;
        }

        // tasa_venta
        $this->tasa_venta->ViewValue = $this->tasa_venta->CurrentValue;
        $this->tasa_venta->ViewValue = FormatNumber($this->tasa_venta->ViewValue, $this->tasa_venta->formatPattern());

        // id_parcela
        $this->id_parcela->ViewValue = $this->id_parcela->CurrentValue;

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // estatus
        if (strval($this->estatus->CurrentValue) != "") {
            $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
        } else {
            $this->estatus->ViewValue = null;
        }

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

        // numero_factura
        $this->numero_factura->ViewValue = $this->numero_factura->CurrentValue;

        // orden_pago
        $this->orden_pago->ViewValue = $this->orden_pago->CurrentValue;

        // Nparcela_ventas
        $this->Nparcela_ventas->HrefValue = "";
        $this->Nparcela_ventas->TooltipValue = "";

        // fecha_compra
        $this->fecha_compra->HrefValue = "";
        $this->fecha_compra->TooltipValue = "";

        // usuario_compra
        $this->usuario_compra->HrefValue = "";
        $this->usuario_compra->TooltipValue = "";

        // terraza
        $this->terraza->HrefValue = "";
        $this->terraza->TooltipValue = "";

        // seccion
        $this->seccion->HrefValue = "";
        $this->seccion->TooltipValue = "";

        // modulo
        $this->modulo->HrefValue = "";
        $this->modulo->TooltipValue = "";

        // subseccion
        $this->subseccion->HrefValue = "";
        $this->subseccion->TooltipValue = "";

        // parcela
        $this->parcela->HrefValue = "";
        $this->parcela->TooltipValue = "";

        // ci_vendedor
        $this->ci_vendedor->HrefValue = "";
        $this->ci_vendedor->TooltipValue = "";

        // vendedor
        $this->vendedor->HrefValue = "";
        $this->vendedor->TooltipValue = "";

        // valor_compra
        $this->valor_compra->HrefValue = "";
        $this->valor_compra->TooltipValue = "";

        // moneda_compra
        $this->moneda_compra->HrefValue = "";
        $this->moneda_compra->TooltipValue = "";

        // tasa_compra
        $this->tasa_compra->HrefValue = "";
        $this->tasa_compra->TooltipValue = "";

        // fecha_venta
        $this->fecha_venta->HrefValue = "";
        $this->fecha_venta->TooltipValue = "";

        // usuario_vende
        $this->usuario_vende->HrefValue = "";
        $this->usuario_vende->TooltipValue = "";

        // ci_comprador
        $this->ci_comprador->HrefValue = "";
        $this->ci_comprador->TooltipValue = "";

        // comprador
        $this->comprador->HrefValue = "";
        $this->comprador->TooltipValue = "";

        // valor_venta
        $this->valor_venta->HrefValue = "";
        $this->valor_venta->TooltipValue = "";

        // moneda_venta
        $this->moneda_venta->HrefValue = "";
        $this->moneda_venta->TooltipValue = "";

        // tasa_venta
        $this->tasa_venta->HrefValue = "";
        $this->tasa_venta->TooltipValue = "";

        // id_parcela
        $this->id_parcela->HrefValue = "";
        $this->id_parcela->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // numero_factura
        $this->numero_factura->HrefValue = "";
        $this->numero_factura->TooltipValue = "";

        // orden_pago
        $this->orden_pago->HrefValue = "";
        $this->orden_pago->TooltipValue = "";

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

        // Nparcela_ventas
        $this->Nparcela_ventas->setupEditAttributes();
        $this->Nparcela_ventas->EditValue = $this->Nparcela_ventas->CurrentValue;

        // fecha_compra
        $this->fecha_compra->setupEditAttributes();
        $this->fecha_compra->EditValue = FormatDateTime($this->fecha_compra->CurrentValue, $this->fecha_compra->formatPattern());
        $this->fecha_compra->PlaceHolder = RemoveHtml($this->fecha_compra->caption());

        // usuario_compra
        $this->usuario_compra->setupEditAttributes();
        if (!$this->usuario_compra->Raw) {
            $this->usuario_compra->CurrentValue = HtmlDecode($this->usuario_compra->CurrentValue);
        }
        $this->usuario_compra->EditValue = $this->usuario_compra->CurrentValue;
        $this->usuario_compra->PlaceHolder = RemoveHtml($this->usuario_compra->caption());

        // terraza
        $this->terraza->setupEditAttributes();
        $this->terraza->EditValue = $this->terraza->CurrentValue;

        // seccion
        $this->seccion->setupEditAttributes();
        $this->seccion->EditValue = $this->seccion->CurrentValue;

        // modulo
        $this->modulo->setupEditAttributes();
        $this->modulo->EditValue = $this->modulo->CurrentValue;

        // subseccion
        $this->subseccion->setupEditAttributes();
        $this->subseccion->EditValue = $this->subseccion->CurrentValue;

        // parcela
        $this->parcela->setupEditAttributes();
        $this->parcela->EditValue = $this->parcela->CurrentValue;

        // ci_vendedor
        $this->ci_vendedor->setupEditAttributes();
        if (!$this->ci_vendedor->Raw) {
            $this->ci_vendedor->CurrentValue = HtmlDecode($this->ci_vendedor->CurrentValue);
        }
        $this->ci_vendedor->EditValue = $this->ci_vendedor->CurrentValue;
        $this->ci_vendedor->PlaceHolder = RemoveHtml($this->ci_vendedor->caption());

        // vendedor
        $this->vendedor->setupEditAttributes();
        if (!$this->vendedor->Raw) {
            $this->vendedor->CurrentValue = HtmlDecode($this->vendedor->CurrentValue);
        }
        $this->vendedor->EditValue = $this->vendedor->CurrentValue;
        $this->vendedor->PlaceHolder = RemoveHtml($this->vendedor->caption());

        // valor_compra
        $this->valor_compra->setupEditAttributes();
        $this->valor_compra->EditValue = $this->valor_compra->CurrentValue;
        $this->valor_compra->PlaceHolder = RemoveHtml($this->valor_compra->caption());
        if (strval($this->valor_compra->EditValue) != "" && is_numeric($this->valor_compra->EditValue)) {
            $this->valor_compra->EditValue = FormatNumber($this->valor_compra->EditValue, null);
        }

        // moneda_compra
        $this->moneda_compra->PlaceHolder = RemoveHtml($this->moneda_compra->caption());

        // tasa_compra
        $this->tasa_compra->setupEditAttributes();
        $this->tasa_compra->EditValue = $this->tasa_compra->CurrentValue;
        $this->tasa_compra->PlaceHolder = RemoveHtml($this->tasa_compra->caption());
        if (strval($this->tasa_compra->EditValue) != "" && is_numeric($this->tasa_compra->EditValue)) {
            $this->tasa_compra->EditValue = FormatNumber($this->tasa_compra->EditValue, null);
        }

        // fecha_venta
        $this->fecha_venta->setupEditAttributes();
        $this->fecha_venta->EditValue = FormatDateTime($this->fecha_venta->CurrentValue, $this->fecha_venta->formatPattern());
        $this->fecha_venta->PlaceHolder = RemoveHtml($this->fecha_venta->caption());

        // usuario_vende
        $this->usuario_vende->setupEditAttributes();
        $this->usuario_vende->PlaceHolder = RemoveHtml($this->usuario_vende->caption());

        // ci_comprador
        $this->ci_comprador->setupEditAttributes();
        if (!$this->ci_comprador->Raw) {
            $this->ci_comprador->CurrentValue = HtmlDecode($this->ci_comprador->CurrentValue);
        }
        $this->ci_comprador->EditValue = $this->ci_comprador->CurrentValue;
        $this->ci_comprador->PlaceHolder = RemoveHtml($this->ci_comprador->caption());

        // comprador
        $this->comprador->setupEditAttributes();
        if (!$this->comprador->Raw) {
            $this->comprador->CurrentValue = HtmlDecode($this->comprador->CurrentValue);
        }
        $this->comprador->EditValue = $this->comprador->CurrentValue;
        $this->comprador->PlaceHolder = RemoveHtml($this->comprador->caption());

        // valor_venta
        $this->valor_venta->setupEditAttributes();
        $this->valor_venta->EditValue = $this->valor_venta->CurrentValue;
        $this->valor_venta->PlaceHolder = RemoveHtml($this->valor_venta->caption());
        if (strval($this->valor_venta->EditValue) != "" && is_numeric($this->valor_venta->EditValue)) {
            $this->valor_venta->EditValue = FormatNumber($this->valor_venta->EditValue, null);
        }

        // moneda_venta
        $this->moneda_venta->PlaceHolder = RemoveHtml($this->moneda_venta->caption());

        // tasa_venta
        $this->tasa_venta->setupEditAttributes();
        $this->tasa_venta->EditValue = $this->tasa_venta->CurrentValue;
        $this->tasa_venta->PlaceHolder = RemoveHtml($this->tasa_venta->caption());
        if (strval($this->tasa_venta->EditValue) != "" && is_numeric($this->tasa_venta->EditValue)) {
            $this->tasa_venta->EditValue = FormatNumber($this->tasa_venta->EditValue, null);
        }

        // id_parcela
        $this->id_parcela->setupEditAttributes();
        if (!$this->id_parcela->Raw) {
            $this->id_parcela->CurrentValue = HtmlDecode($this->id_parcela->CurrentValue);
        }
        $this->id_parcela->EditValue = $this->id_parcela->CurrentValue;
        $this->id_parcela->PlaceHolder = RemoveHtml($this->id_parcela->caption());

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->options(true);
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

        // numero_factura
        $this->numero_factura->setupEditAttributes();
        if (!$this->numero_factura->Raw) {
            $this->numero_factura->CurrentValue = HtmlDecode($this->numero_factura->CurrentValue);
        }
        $this->numero_factura->EditValue = $this->numero_factura->CurrentValue;
        $this->numero_factura->PlaceHolder = RemoveHtml($this->numero_factura->caption());

        // orden_pago
        $this->orden_pago->setupEditAttributes();
        if (!$this->orden_pago->Raw) {
            $this->orden_pago->CurrentValue = HtmlDecode($this->orden_pago->CurrentValue);
        }
        $this->orden_pago->EditValue = $this->orden_pago->CurrentValue;
        $this->orden_pago->PlaceHolder = RemoveHtml($this->orden_pago->caption());

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
                    $doc->exportCaption($this->Nparcela_ventas);
                    $doc->exportCaption($this->fecha_compra);
                    $doc->exportCaption($this->usuario_compra);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->subseccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->ci_vendedor);
                    $doc->exportCaption($this->vendedor);
                    $doc->exportCaption($this->valor_compra);
                    $doc->exportCaption($this->moneda_compra);
                    $doc->exportCaption($this->tasa_compra);
                    $doc->exportCaption($this->fecha_venta);
                    $doc->exportCaption($this->usuario_vende);
                    $doc->exportCaption($this->ci_comprador);
                    $doc->exportCaption($this->comprador);
                    $doc->exportCaption($this->valor_venta);
                    $doc->exportCaption($this->moneda_venta);
                    $doc->exportCaption($this->tasa_venta);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->numero_factura);
                    $doc->exportCaption($this->orden_pago);
                } else {
                    $doc->exportCaption($this->Nparcela_ventas);
                    $doc->exportCaption($this->fecha_compra);
                    $doc->exportCaption($this->usuario_compra);
                    $doc->exportCaption($this->terraza);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->subseccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->ci_vendedor);
                    $doc->exportCaption($this->vendedor);
                    $doc->exportCaption($this->valor_compra);
                    $doc->exportCaption($this->moneda_compra);
                    $doc->exportCaption($this->tasa_compra);
                    $doc->exportCaption($this->fecha_venta);
                    $doc->exportCaption($this->usuario_vende);
                    $doc->exportCaption($this->ci_comprador);
                    $doc->exportCaption($this->comprador);
                    $doc->exportCaption($this->valor_venta);
                    $doc->exportCaption($this->moneda_venta);
                    $doc->exportCaption($this->tasa_venta);
                    $doc->exportCaption($this->id_parcela);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->numero_factura);
                    $doc->exportCaption($this->orden_pago);
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
                        $doc->exportField($this->Nparcela_ventas);
                        $doc->exportField($this->fecha_compra);
                        $doc->exportField($this->usuario_compra);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->subseccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->ci_vendedor);
                        $doc->exportField($this->vendedor);
                        $doc->exportField($this->valor_compra);
                        $doc->exportField($this->moneda_compra);
                        $doc->exportField($this->tasa_compra);
                        $doc->exportField($this->fecha_venta);
                        $doc->exportField($this->usuario_vende);
                        $doc->exportField($this->ci_comprador);
                        $doc->exportField($this->comprador);
                        $doc->exportField($this->valor_venta);
                        $doc->exportField($this->moneda_venta);
                        $doc->exportField($this->tasa_venta);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->numero_factura);
                        $doc->exportField($this->orden_pago);
                    } else {
                        $doc->exportField($this->Nparcela_ventas);
                        $doc->exportField($this->fecha_compra);
                        $doc->exportField($this->usuario_compra);
                        $doc->exportField($this->terraza);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->subseccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->ci_vendedor);
                        $doc->exportField($this->vendedor);
                        $doc->exportField($this->valor_compra);
                        $doc->exportField($this->moneda_compra);
                        $doc->exportField($this->tasa_compra);
                        $doc->exportField($this->fecha_venta);
                        $doc->exportField($this->usuario_vende);
                        $doc->exportField($this->ci_comprador);
                        $doc->exportField($this->comprador);
                        $doc->exportField($this->valor_venta);
                        $doc->exportField($this->moneda_venta);
                        $doc->exportField($this->tasa_venta);
                        $doc->exportField($this->id_parcela);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->numero_factura);
                        $doc->exportField($this->orden_pago);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_parcela_ventas');
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
        $key .= $rs['Nparcela_ventas'];

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
                WriteAuditLog($usr, "A", 'sco_parcela_ventas', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nparcela_ventas'];

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
                    WriteAuditLog($usr, "U", 'sco_parcela_ventas', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nparcela_ventas'];

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
                WriteAuditLog($usr, "D", 'sco_parcela_ventas', $fldname, $key, $oldvalue);
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
        if(!isset($_GET["x_estatus"])) {
            AddFilter($filter, "estatus IN ('COMPRA', 'VENTA')");
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

    public function rowInserting($rsold, &$rsnew) {
        // 1. Normalización de datos y limpieza
        $seccion = strtoupper(trim($rsnew["seccion"] ?? ""));
        $modulo = strtoupper(trim($rsnew["modulo"] ?? ""));
        $subseccion = strtoupper(trim($rsnew["subseccion"] ?? ""));
        $parcela = strtoupper(trim($rsnew["parcela"] ?? ""));

        // Actualizamos $rsnew con los valores limpios
        $rsnew["seccion"] = $seccion;
        $rsnew["modulo"] = $modulo;
        $rsnew["subseccion"] = $subseccion;
        $rsnew["parcela"] = $parcela;

        // 2. Validación: Existencia de la Parcela física
        // Usamos AdjustSql para proteger las variables contra inyecciones SQL
        $sqlCheckExist = "SELECT titular FROM sco_parcela WHERE 
                          LTRIM(seccion) = '" . AdjustSql($seccion) . "' AND 
                          LTRIM(modulo) = '" . AdjustSql($modulo) . "' AND 
                          LTRIM(sub_seccion) = '" . AdjustSql($subseccion) . "' AND 
                          LTRIM(parcela) = '" . AdjustSql($parcela) . "'";
        if (!ExecuteRow($sqlCheckExist)) {
            $this->setFailureMessage("La parcela no existe en el inventario; !!! verifique !!!.");
            return FALSE;
        }

        // 3. Validación: Disponibilidad (Que no esté en proceso de COMPRA activo)
        $sqlCheckVenta = "SELECT Nparcela_ventas FROM sco_parcela_ventas WHERE 
                          RTRIM(seccion) = '" . AdjustSql($seccion) . "' AND 
                          RTRIM(modulo) = '" . AdjustSql($modulo) . "' AND 
                          RTRIM(subseccion) = '" . AdjustSql($subseccion) . "' AND 
                          RTRIM(parcela) = '" . AdjustSql($parcela) . "' AND 
                          estatus = 'COMPRA'";
        if (ExecuteRow($sqlCheckVenta)) {
            $this->setFailureMessage("La parcela ya posee un registro activo bajo estatus 'COMPRA'; !!! verifique !!!.");
            return FALSE;
        }

        // 4. Asignación de campos técnicos y auditoría
        // Creamos el ID compuesto de forma limpia
        $rsnew["id_parcela"] = implode("-", [$seccion, $modulo, $subseccion, $parcela]);

        // Usamos las funciones nativas de PHPMaker para fecha y hora
        $rsnew["fecha_compra"] = CurrentDate(); 
        $rsnew["fecha_registro"] = CurrentDateTime();
        $rsnew["usuario_compra"] = CurrentUserName();
        $rsnew["estatus"] = "COMPRA";
        return TRUE;
    }
    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
        $sql = "INSERT INTO sco_parcela_ventas_nota
    	            (Nparcela_ventas_nota, parcela_ventas, nota, username, fecha_hora)
    	        VALUES 
                    (NULL, " . $rsnew["Nparcela_ventas"] . ", 'AGREGO NUEVA PARCELA EXISTENTE PARA LA VENTA', '" . CurrentUserName() . "', '" . CurrentDateTime() . "')";
        Execute($sql);
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
        $nota = "Campos modificados: \n";
        $cambioDetectado = false;

        // Recorremos solo los campos que vienen en $rsnew (los que cambiaron)
        foreach ($rsnew as $campo => $valorNuevo) {
            $valorAnterior = $rsold[$campo];

            // Solo registramos si los valores son realmente distintos
            if ($valorAnterior != $valorNuevo) {
                // Formateamos valores nulos para que sean legibles en la nota
                $txtViejo = is_null($valorAnterior) ? "NULL" : $valorAnterior;
                $txtNuevo = is_null($valorNuevo) ? "NULL" : $valorNuevo;
                $nota .= "- $campo: de '$txtViejo' a '$txtNuevo'\n";
                $cambioDetectado = true;
            }
        }

        // Si no hubo cambios reales, no insertamos nada
        if (!$cambioDetectado) return;

        // Escapamos la nota para evitar errores con comillas simples en el SQL
        $notaEscapada = str_replace("'", "''", $nota);
        $idVenta = $rsold["Nparcela_ventas"];
        $usuario = CurrentUserName();
        $fecha = CurrentDateTime();
        $sql = "INSERT INTO sco_parcela_ventas_nota
                    (Nparcela_ventas_nota, parcela_ventas, nota, username, fecha_hora)
                VALUES 
                    (NULL, $idVenta, '$notaEscapada', '$usuario', '$fecha')";
        Execute($sql);
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

    public function rowDeleting(&$rs) {
        $userLevel = CurrentUserLevel();
        $userName = CurrentUserName();

        // 1. Permitir siempre el usuario puede eliminar registros
        $canAnular = ExecuteScalar("SELECT b.codigo FROM sco_grupo_funciones AS a 
                                    JOIN sco_funciones AS b ON b.Nfuncion = a.funcion 
                                    WHERE a.grupo = '$userLevel' AND b.codigo = '300'");
        if ($canAnular == "300") {
            $nota = "[LOG]: Usuario $userName ELIMINO la venta el " . CurrentDateTime() . ".";
            return TRUE;
        } else {
            $this->setFailureMessage("No tiene nivel de seguridad (Cód: 300) para ELIMINAR.");
            return FALSE;
        }

        // 2. Bloquear eliminación si no es estatus COMPRA
        if (trim($rs["estatus"]) != "COMPRA") {
            $this->CancelMessage = "La parcela está vendida o anulada y no se puede eliminar. Verifique el estatus.";
            return FALSE;
        }

        // 3. Preparar el registro de auditoría (Log de eliminación)
        $nota = "\n REGISTRO ELIMINADO. Datos contenidos: \n";
        foreach ($rs as $campo => $valor) {
            // Formatear el valor para la nota
            $txtValor = is_null($valor) || $valor === "" ? "[VACÍO]" : $valor;

            // Intentar obtener el título del campo para que sea más legible
            $caption = isset($this->fields[$campo]) ? $this->fields[$campo]->caption() : $campo;
            $nota .= "- $caption: $txtValor \n";
        }

        // Escapar comillas para el SQL
        $notaEscapada = str_replace("'", "''", $nota);
        $idVenta = $rs["Nparcela_ventas"];
        $usuario = CurrentUserName();
        $fecha = CurrentDateTime();

        // 4. Insertar la nota antes de borrar el registro principal
        $sql = "INSERT INTO sco_parcela_ventas_nota
                    (Nparcela_ventas_nota, parcela_ventas, nota, username, fecha_hora)
                VALUES 
                    (NULL, $idVenta, '$notaEscapada', '$usuario', '$fecha')";
        Execute($sql);
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

    public function rowRendering() {
        // 1. Ejecutar solo en páginas de Listado o Vista
        if ($this->PageID == "list" || $this->PageID == "view") {
            $estatus = trim($this->estatus->CurrentValue ?? "");
            $bgColor = "";
            $textColor = "#000000"; // Negro por defecto

            // 2. Definición de paleta de colores profesionales (Pasteles)
            switch($estatus) {
                case "COMPRA":
                    $bgColor = "#d4edda"; // Verde claro
                    $textColor = "#155724"; // Texto verde oscuro
                    break;
                case "VENTA":
                    $bgColor = "#f8d7da"; // Rojo claro
                    $textColor = "#721c24"; // Texto rojo oscuro
                    break;
                case "ANULADO":
                    $bgColor = "#e2e3e5"; // Gris claro
                    $textColor = "#383d41"; // Texto gris oscuro
                    break;
            }

            // 3. Aplicación del estilo
            if ($bgColor !== "") {
                // Definimos el estilo con !important para asegurar que PHPMaker lo aplique
                $style = "background-color: $bgColor !important; color: $textColor !important; font-weight: 500;";

                // Opción A: Aplicar a campos específicos (Array optimizado)
                $camposAfectados = ["seccion", "modulo", "subseccion", "parcela", "estatus"];
                foreach ($camposAfectados as $fld) {
                    $this->$fld->CellAttrs["style"] = $style;
                }

                // Opción B (Opcional): Si prefieres pintar TODA la fila, descomenta la siguiente línea:
                // $this->RowAttrs["style"] = $style;
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
