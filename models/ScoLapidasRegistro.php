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
 * Table class for sco_lapidas_registro
 */
class ScoLapidasRegistro extends DbTable
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
    public $Nlapidas_registro;
    public $solicitante;
    public $parentesco;
    public $telefono1;
    public $telefono2;
    public $_email;
    public $ci_difunto;
    public $nombre_difunto;
    public $tipo;
    public $comentario;
    public $estatus;
    public $registro;
    public $registra;
    public $modificacion;
    public $modifica;
    public $seccion;
    public $modulo;
    public $sub_seccion;
    public $parcela;
    public $boveda;
    public $contrato;
    public $maqueteo;
    public $coordenadas_maqueta;
    public $reclamo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_lapidas_registro";
        $this->TableName = 'sco_lapidas_registro';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_lapidas_registro";
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

        // Nlapidas_registro
        $this->Nlapidas_registro = new DbField(
            $this, // Table
            'x_Nlapidas_registro', // Variable name
            'Nlapidas_registro', // Name
            '`Nlapidas_registro`', // Expression
            '`Nlapidas_registro`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nlapidas_registro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nlapidas_registro->InputTextType = "text";
        $this->Nlapidas_registro->Raw = true;
        $this->Nlapidas_registro->IsAutoIncrement = true; // Autoincrement field
        $this->Nlapidas_registro->IsPrimaryKey = true; // Primary key field
        $this->Nlapidas_registro->IsForeignKey = true; // Foreign key field
        $this->Nlapidas_registro->Nullable = false; // NOT NULL field
        $this->Nlapidas_registro->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nlapidas_registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nlapidas_registro'] = &$this->Nlapidas_registro;

        // solicitante
        $this->solicitante = new DbField(
            $this, // Table
            'x_solicitante', // Variable name
            'solicitante', // Name
            '`solicitante`', // Expression
            '`solicitante`', // Basic search expression
            200, // Type
            120, // Size
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

        // parentesco
        $this->parentesco = new DbField(
            $this, // Table
            'x_parentesco', // Variable name
            'parentesco', // Name
            '`parentesco`', // Expression
            '`parentesco`', // Basic search expression
            200, // Type
            4, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`parentesco`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->parentesco->addMethod("getSelectFilter", fn() => "`tabla` = 'PARENTESCOS'");
        $this->parentesco->InputTextType = "text";
        $this->parentesco->Required = true; // Required field
        $this->parentesco->setSelectMultiple(false); // Select one
        $this->parentesco->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->parentesco->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->parentesco->Lookup = new Lookup($this->parentesco, 'sco_tabla', false, 'campo_codigo', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '', '', "`campo_descripcion`");
        $this->parentesco->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['parentesco'] = &$this->parentesco;

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
            120, // Size
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

        // ci_difunto
        $this->ci_difunto = new DbField(
            $this, // Table
            'x_ci_difunto', // Variable name
            'ci_difunto', // Name
            '`ci_difunto`', // Expression
            '`ci_difunto`', // Basic search expression
            200, // Type
            20, // Size
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
        $this->ci_difunto->Required = true; // Required field
        $this->ci_difunto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_difunto'] = &$this->ci_difunto;

        // nombre_difunto
        $this->nombre_difunto = new DbField(
            $this, // Table
            'x_nombre_difunto', // Variable name
            'nombre_difunto', // Name
            '`nombre_difunto`', // Expression
            '`nombre_difunto`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_difunto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_difunto->InputTextType = "text";
        $this->nombre_difunto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_difunto'] = &$this->nombre_difunto;

        // tipo
        $this->tipo = new DbField(
            $this, // Table
            'x_tipo', // Variable name
            'tipo', // Name
            '`tipo`', // Expression
            '`tipo`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo->addMethod("getSelectFilter", fn() => "`codigo` = '042'");
        $this->tipo->InputTextType = "text";
        $this->tipo->Required = true; // Required field
        $this->tipo->setSelectMultiple(false); // Select one
        $this->tipo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo->Lookup = new Lookup($this->tipo, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->tipo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo'] = &$this->tipo;

        // comentario
        $this->comentario = new DbField(
            $this, // Table
            'x_comentario', // Variable name
            'comentario', // Name
            '`comentario`', // Expression
            '`comentario`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`comentario`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->comentario->InputTextType = "text";
        $this->comentario->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['comentario'] = &$this->comentario;

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            200, // Type
            20, // Size
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
        $this->estatus->Required = true; // Required field
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_lapidas_registro', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->estatus->OptionCount = 5;
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

        // registro
        $this->registro = new DbField(
            $this, // Table
            'x_registro', // Variable name
            'registro', // Name
            '`registro`', // Expression
            CastDateFieldForLike("`registro`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`registro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->registro->InputTextType = "text";
        $this->registro->Raw = true;
        $this->registro->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->registro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['registro'] = &$this->registro;

        // registra
        $this->registra = new DbField(
            $this, // Table
            'x_registra', // Variable name
            'registra', // Name
            '`registra`', // Expression
            '`registra`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`registra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->registra->InputTextType = "text";
        $this->registra->setSelectMultiple(false); // Select one
        $this->registra->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->registra->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->registra->Lookup = new Lookup($this->registra, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->registra->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['registra'] = &$this->registra;

        // modificacion
        $this->modificacion = new DbField(
            $this, // Table
            'x_modificacion', // Variable name
            'modificacion', // Name
            '`modificacion`', // Expression
            CastDateFieldForLike("`modificacion`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
            false, // Is upload field
            '`modificacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->modificacion->InputTextType = "text";
        $this->modificacion->Raw = true;
        $this->modificacion->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->modificacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['modificacion'] = &$this->modificacion;

        // modifica
        $this->modifica = new DbField(
            $this, // Table
            'x_modifica', // Variable name
            'modifica', // Name
            '`modifica`', // Expression
            '`modifica`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`modifica`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->modifica->InputTextType = "text";
        $this->modifica->setSelectMultiple(false); // Select one
        $this->modifica->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->modifica->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->modifica->Lookup = new Lookup($this->modifica, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->modifica->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['modifica'] = &$this->modifica;

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

        // contrato
        $this->contrato = new DbField(
            $this, // Table
            'x_contrato', // Variable name
            'contrato', // Name
            '`contrato`', // Expression
            '`contrato`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`contrato`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->contrato->addMethod("getDefault", fn() => "0");
        $this->contrato->InputTextType = "text";
        $this->contrato->Nullable = false; // NOT NULL field
        $this->contrato->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['contrato'] = &$this->contrato;

        // maqueteo
        $this->maqueteo = new DbField(
            $this, // Table
            'x_maqueteo', // Variable name
            'maqueteo', // Name
            '`maqueteo`', // Expression
            '`maqueteo`', // Basic search expression
            129, // Type
            2, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`maqueteo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->maqueteo->addMethod("getSelectFilter", fn() => "`codigo` = '043'");
        $this->maqueteo->InputTextType = "text";
        $this->maqueteo->setSelectMultiple(false); // Select one
        $this->maqueteo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->maqueteo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->maqueteo->Lookup = new Lookup($this->maqueteo, 'sco_parametro', false, 'valor1', ["valor2","","",""], '', '', [], [], [], [], [], [], false, '', '', "`valor2`");
        $this->maqueteo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['maqueteo'] = &$this->maqueteo;

        // coordenadas_maqueta
        $this->coordenadas_maqueta = new DbField(
            $this, // Table
            'x_coordenadas_maqueta', // Variable name
            'coordenadas_maqueta', // Name
            '`coordenadas_maqueta`', // Expression
            '`coordenadas_maqueta`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`coordenadas_maqueta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->coordenadas_maqueta->InputTextType = "text";
        $this->coordenadas_maqueta->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['coordenadas_maqueta'] = &$this->coordenadas_maqueta;

        // reclamo
        $this->reclamo = new DbField(
            $this, // Table
            'x_reclamo', // Variable name
            'reclamo', // Name
            '`reclamo`', // Expression
            '`reclamo`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`reclamo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->reclamo->addMethod("getDefault", fn() => 0);
        $this->reclamo->InputTextType = "text";
        $this->reclamo->Raw = true;
        $this->reclamo->Nullable = false; // NOT NULL field
        $this->reclamo->Required = true; // Required field
        $this->reclamo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->reclamo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['reclamo'] = &$this->reclamo;

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
        if ($this->getCurrentDetailTable() == "sco_lapidas_notas") {
            $detailUrl = Container("sco_lapidas_notas")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nlapidas_registro", $this->Nlapidas_registro->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_lapidas_adjunto") {
            $detailUrl = Container("sco_lapidas_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nlapidas_registro", $this->Nlapidas_registro->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoLapidasRegistroList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_lapidas_registro";
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
            $this->Nlapidas_registro->setDbValue($conn->lastInsertId());
            $rs['Nlapidas_registro'] = $this->Nlapidas_registro->DbValue;
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
        // Cascade Update detail table 'sco_lapidas_notas'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nlapidas_registro']) && $rsold['Nlapidas_registro'] != $rs['Nlapidas_registro'])) { // Update detail field 'lapida_registro'
            $cascadeUpdate = true;
            $rscascade['lapida_registro'] = $rs['Nlapidas_registro'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_lapidas_notas")->loadRs("`lapida_registro` = " . QuotedValue($rsold['Nlapidas_registro'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nlapidas_notas';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_lapidas_notas")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_lapidas_notas")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_lapidas_notas")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'sco_lapidas_adjunto'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nlapidas_registro']) && $rsold['Nlapidas_registro'] != $rs['Nlapidas_registro'])) { // Update detail field 'lapida_registro'
            $cascadeUpdate = true;
            $rscascade['lapida_registro'] = $rs['Nlapidas_registro'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_lapidas_adjunto")->loadRs("`lapida_registro` = " . QuotedValue($rsold['Nlapidas_registro'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nlapidas_adjunto';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_lapidas_adjunto")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_lapidas_adjunto")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_lapidas_adjunto")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Nlapidas_registro']) && !EmptyValue($this->Nlapidas_registro->CurrentValue)) {
                $rs['Nlapidas_registro'] = $this->Nlapidas_registro->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nlapidas_registro';
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
            if (array_key_exists('Nlapidas_registro', $rs)) {
                AddFilter($where, QuotedName('Nlapidas_registro', $this->Dbid) . '=' . QuotedValue($rs['Nlapidas_registro'], $this->Nlapidas_registro->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_lapidas_notas'
        $dtlrows = Container("sco_lapidas_notas")->loadRs("`lapida_registro` = " . QuotedValue($rs['Nlapidas_registro'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_lapidas_notas")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_lapidas_notas")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_lapidas_notas")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'sco_lapidas_adjunto'
        $dtlrows = Container("sco_lapidas_adjunto")->loadRs("`lapida_registro` = " . QuotedValue($rs['Nlapidas_registro'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_lapidas_adjunto")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_lapidas_adjunto")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_lapidas_adjunto")->rowDeleted($dtlrow);
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
        $this->Nlapidas_registro->DbValue = $row['Nlapidas_registro'];
        $this->solicitante->DbValue = $row['solicitante'];
        $this->parentesco->DbValue = $row['parentesco'];
        $this->telefono1->DbValue = $row['telefono1'];
        $this->telefono2->DbValue = $row['telefono2'];
        $this->_email->DbValue = $row['email'];
        $this->ci_difunto->DbValue = $row['ci_difunto'];
        $this->nombre_difunto->DbValue = $row['nombre_difunto'];
        $this->tipo->DbValue = $row['tipo'];
        $this->comentario->DbValue = $row['comentario'];
        $this->estatus->DbValue = $row['estatus'];
        $this->registro->DbValue = $row['registro'];
        $this->registra->DbValue = $row['registra'];
        $this->modificacion->DbValue = $row['modificacion'];
        $this->modifica->DbValue = $row['modifica'];
        $this->seccion->DbValue = $row['seccion'];
        $this->modulo->DbValue = $row['modulo'];
        $this->sub_seccion->DbValue = $row['sub_seccion'];
        $this->parcela->DbValue = $row['parcela'];
        $this->boveda->DbValue = $row['boveda'];
        $this->contrato->DbValue = $row['contrato'];
        $this->maqueteo->DbValue = $row['maqueteo'];
        $this->coordenadas_maqueta->DbValue = $row['coordenadas_maqueta'];
        $this->reclamo->DbValue = $row['reclamo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nlapidas_registro` = @Nlapidas_registro@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nlapidas_registro->CurrentValue : $this->Nlapidas_registro->OldValue;
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
                $this->Nlapidas_registro->CurrentValue = $keys[0];
            } else {
                $this->Nlapidas_registro->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nlapidas_registro', $row) ? $row['Nlapidas_registro'] : null;
        } else {
            $val = !EmptyValue($this->Nlapidas_registro->OldValue) && !$current ? $this->Nlapidas_registro->OldValue : $this->Nlapidas_registro->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nlapidas_registro@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoLapidasRegistroList");
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
            "ScoLapidasRegistroView" => $Language->phrase("View"),
            "ScoLapidasRegistroEdit" => $Language->phrase("Edit"),
            "ScoLapidasRegistroAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoLapidasRegistroList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoLapidasRegistroView",
            Config("API_ADD_ACTION") => "ScoLapidasRegistroAdd",
            Config("API_EDIT_ACTION") => "ScoLapidasRegistroEdit",
            Config("API_DELETE_ACTION") => "ScoLapidasRegistroDelete",
            Config("API_LIST_ACTION") => "ScoLapidasRegistroList",
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
        return "ScoLapidasRegistroList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoLapidasRegistroView", $parm);
        } else {
            $url = $this->keyUrl("ScoLapidasRegistroView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoLapidasRegistroAdd?" . $parm;
        } else {
            $url = "ScoLapidasRegistroAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoLapidasRegistroEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoLapidasRegistroEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoLapidasRegistroList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoLapidasRegistroAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoLapidasRegistroAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoLapidasRegistroList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoLapidasRegistroDelete", $parm);
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
        $json .= "\"Nlapidas_registro\":" . VarToJson($this->Nlapidas_registro->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nlapidas_registro->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nlapidas_registro->CurrentValue);
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
            if (($keyValue = Param("Nlapidas_registro") ?? Route("Nlapidas_registro")) !== null) {
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
                $this->Nlapidas_registro->CurrentValue = $key;
            } else {
                $this->Nlapidas_registro->OldValue = $key;
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
        $this->Nlapidas_registro->setDbValue($row['Nlapidas_registro']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->parentesco->setDbValue($row['parentesco']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->_email->setDbValue($row['email']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->nombre_difunto->setDbValue($row['nombre_difunto']);
        $this->tipo->setDbValue($row['tipo']);
        $this->comentario->setDbValue($row['comentario']);
        $this->estatus->setDbValue($row['estatus']);
        $this->registro->setDbValue($row['registro']);
        $this->registra->setDbValue($row['registra']);
        $this->modificacion->setDbValue($row['modificacion']);
        $this->modifica->setDbValue($row['modifica']);
        $this->seccion->setDbValue($row['seccion']);
        $this->modulo->setDbValue($row['modulo']);
        $this->sub_seccion->setDbValue($row['sub_seccion']);
        $this->parcela->setDbValue($row['parcela']);
        $this->boveda->setDbValue($row['boveda']);
        $this->contrato->setDbValue($row['contrato']);
        $this->maqueteo->setDbValue($row['maqueteo']);
        $this->coordenadas_maqueta->setDbValue($row['coordenadas_maqueta']);
        $this->reclamo->setDbValue($row['reclamo']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoLapidasRegistroList";
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

        // Nlapidas_registro

        // solicitante

        // parentesco

        // telefono1

        // telefono2

        // email

        // ci_difunto

        // nombre_difunto

        // tipo

        // comentario

        // estatus

        // registro

        // registra

        // modificacion

        // modifica

        // seccion

        // modulo

        // sub_seccion

        // parcela

        // boveda

        // contrato

        // maqueteo

        // coordenadas_maqueta

        // reclamo

        // Nlapidas_registro
        $this->Nlapidas_registro->ViewValue = $this->Nlapidas_registro->CurrentValue;

        // solicitante
        $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

        // parentesco
        $curVal = strval($this->parentesco->CurrentValue);
        if ($curVal != "") {
            $this->parentesco->ViewValue = $this->parentesco->lookupCacheOption($curVal);
            if ($this->parentesco->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->parentesco->Lookup->getTable()->Fields["campo_codigo"]->searchExpression(), "=", $curVal, $this->parentesco->Lookup->getTable()->Fields["campo_codigo"]->searchDataType(), "");
                $lookupFilter = $this->parentesco->getSelectFilter($this); // PHP
                $sqlWrk = $this->parentesco->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->parentesco->Lookup->renderViewRow($rswrk[0]);
                    $this->parentesco->ViewValue = $this->parentesco->displayValue($arwrk);
                } else {
                    $this->parentesco->ViewValue = $this->parentesco->CurrentValue;
                }
            }
        } else {
            $this->parentesco->ViewValue = null;
        }

        // telefono1
        $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

        // telefono2
        $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // ci_difunto
        $this->ci_difunto->ViewValue = $this->ci_difunto->CurrentValue;

        // nombre_difunto
        $this->nombre_difunto->ViewValue = $this->nombre_difunto->CurrentValue;

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

        // comentario
        $this->comentario->ViewValue = $this->comentario->CurrentValue;

        // estatus
        if (strval($this->estatus->CurrentValue) != "") {
            $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
        } else {
            $this->estatus->ViewValue = null;
        }

        // registro
        $this->registro->ViewValue = $this->registro->CurrentValue;
        $this->registro->ViewValue = FormatDateTime($this->registro->ViewValue, $this->registro->formatPattern());

        // registra
        $curVal = strval($this->registra->CurrentValue);
        if ($curVal != "") {
            $this->registra->ViewValue = $this->registra->lookupCacheOption($curVal);
            if ($this->registra->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->registra->Lookup->renderViewRow($rswrk[0]);
                    $this->registra->ViewValue = $this->registra->displayValue($arwrk);
                } else {
                    $this->registra->ViewValue = $this->registra->CurrentValue;
                }
            }
        } else {
            $this->registra->ViewValue = null;
        }

        // modificacion
        $this->modificacion->ViewValue = $this->modificacion->CurrentValue;
        $this->modificacion->ViewValue = FormatDateTime($this->modificacion->ViewValue, $this->modificacion->formatPattern());

        // modifica
        $curVal = strval($this->modifica->CurrentValue);
        if ($curVal != "") {
            $this->modifica->ViewValue = $this->modifica->lookupCacheOption($curVal);
            if ($this->modifica->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->modifica->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->modifica->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->modifica->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->modifica->Lookup->renderViewRow($rswrk[0]);
                    $this->modifica->ViewValue = $this->modifica->displayValue($arwrk);
                } else {
                    $this->modifica->ViewValue = $this->modifica->CurrentValue;
                }
            }
        } else {
            $this->modifica->ViewValue = null;
        }

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

        // contrato
        $this->contrato->ViewValue = $this->contrato->CurrentValue;

        // maqueteo
        $curVal = strval($this->maqueteo->CurrentValue);
        if ($curVal != "") {
            $this->maqueteo->ViewValue = $this->maqueteo->lookupCacheOption($curVal);
            if ($this->maqueteo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->maqueteo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->maqueteo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->maqueteo->getSelectFilter($this); // PHP
                $sqlWrk = $this->maqueteo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->maqueteo->Lookup->renderViewRow($rswrk[0]);
                    $this->maqueteo->ViewValue = $this->maqueteo->displayValue($arwrk);
                } else {
                    $this->maqueteo->ViewValue = $this->maqueteo->CurrentValue;
                }
            }
        } else {
            $this->maqueteo->ViewValue = null;
        }

        // coordenadas_maqueta
        $this->coordenadas_maqueta->ViewValue = $this->coordenadas_maqueta->CurrentValue;

        // reclamo
        $this->reclamo->ViewValue = $this->reclamo->CurrentValue;

        // Nlapidas_registro
        $this->Nlapidas_registro->HrefValue = "";
        $this->Nlapidas_registro->TooltipValue = "";

        // solicitante
        $this->solicitante->HrefValue = "";
        $this->solicitante->TooltipValue = "";

        // parentesco
        $this->parentesco->HrefValue = "";
        $this->parentesco->TooltipValue = "";

        // telefono1
        $this->telefono1->HrefValue = "";
        $this->telefono1->TooltipValue = "";

        // telefono2
        $this->telefono2->HrefValue = "";
        $this->telefono2->TooltipValue = "";

        // email
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // ci_difunto
        $this->ci_difunto->HrefValue = "";
        $this->ci_difunto->TooltipValue = "";

        // nombre_difunto
        $this->nombre_difunto->HrefValue = "";
        $this->nombre_difunto->TooltipValue = "";

        // tipo
        $this->tipo->HrefValue = "";
        $this->tipo->TooltipValue = "";

        // comentario
        $this->comentario->HrefValue = "";
        $this->comentario->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // registro
        $this->registro->HrefValue = "";
        $this->registro->TooltipValue = "";

        // registra
        $this->registra->HrefValue = "";
        $this->registra->TooltipValue = "";

        // modificacion
        $this->modificacion->HrefValue = "";
        $this->modificacion->TooltipValue = "";

        // modifica
        $this->modifica->HrefValue = "";
        $this->modifica->TooltipValue = "";

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

        // contrato
        $this->contrato->HrefValue = "";
        $this->contrato->TooltipValue = "";

        // maqueteo
        $this->maqueteo->HrefValue = "";
        $this->maqueteo->TooltipValue = "";

        // coordenadas_maqueta
        $this->coordenadas_maqueta->HrefValue = "";
        $this->coordenadas_maqueta->TooltipValue = "";

        // reclamo
        $this->reclamo->HrefValue = "";
        $this->reclamo->TooltipValue = "";

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

        // Nlapidas_registro
        $this->Nlapidas_registro->setupEditAttributes();
        $this->Nlapidas_registro->EditValue = $this->Nlapidas_registro->CurrentValue;

        // solicitante
        $this->solicitante->setupEditAttributes();
        if (!$this->solicitante->Raw) {
            $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
        }
        $this->solicitante->EditValue = $this->solicitante->CurrentValue;
        $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

        // parentesco
        $this->parentesco->setupEditAttributes();
        $this->parentesco->PlaceHolder = RemoveHtml($this->parentesco->caption());

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

        // ci_difunto
        $this->ci_difunto->setupEditAttributes();
        if (!$this->ci_difunto->Raw) {
            $this->ci_difunto->CurrentValue = HtmlDecode($this->ci_difunto->CurrentValue);
        }
        $this->ci_difunto->EditValue = $this->ci_difunto->CurrentValue;
        $this->ci_difunto->PlaceHolder = RemoveHtml($this->ci_difunto->caption());

        // nombre_difunto
        $this->nombre_difunto->setupEditAttributes();
        if (!$this->nombre_difunto->Raw) {
            $this->nombre_difunto->CurrentValue = HtmlDecode($this->nombre_difunto->CurrentValue);
        }
        $this->nombre_difunto->EditValue = $this->nombre_difunto->CurrentValue;
        $this->nombre_difunto->PlaceHolder = RemoveHtml($this->nombre_difunto->caption());

        // tipo
        $this->tipo->setupEditAttributes();
        $this->tipo->PlaceHolder = RemoveHtml($this->tipo->caption());

        // comentario
        $this->comentario->setupEditAttributes();
        $this->comentario->EditValue = $this->comentario->CurrentValue;
        $this->comentario->PlaceHolder = RemoveHtml($this->comentario->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->options(true);
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // registro
        $this->registro->setupEditAttributes();
        $this->registro->EditValue = FormatDateTime($this->registro->CurrentValue, $this->registro->formatPattern());
        $this->registro->PlaceHolder = RemoveHtml($this->registro->caption());

        // registra
        $this->registra->setupEditAttributes();
        $this->registra->PlaceHolder = RemoveHtml($this->registra->caption());

        // modificacion
        $this->modificacion->setupEditAttributes();
        $this->modificacion->EditValue = FormatDateTime($this->modificacion->CurrentValue, $this->modificacion->formatPattern());
        $this->modificacion->PlaceHolder = RemoveHtml($this->modificacion->caption());

        // modifica
        $this->modifica->setupEditAttributes();
        $this->modifica->PlaceHolder = RemoveHtml($this->modifica->caption());

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

        // contrato
        $this->contrato->setupEditAttributes();
        if (!$this->contrato->Raw) {
            $this->contrato->CurrentValue = HtmlDecode($this->contrato->CurrentValue);
        }
        $this->contrato->EditValue = $this->contrato->CurrentValue;
        $this->contrato->PlaceHolder = RemoveHtml($this->contrato->caption());

        // maqueteo
        $this->maqueteo->setupEditAttributes();
        $this->maqueteo->PlaceHolder = RemoveHtml($this->maqueteo->caption());

        // coordenadas_maqueta
        $this->coordenadas_maqueta->setupEditAttributes();
        if (!$this->coordenadas_maqueta->Raw) {
            $this->coordenadas_maqueta->CurrentValue = HtmlDecode($this->coordenadas_maqueta->CurrentValue);
        }
        $this->coordenadas_maqueta->EditValue = $this->coordenadas_maqueta->CurrentValue;
        $this->coordenadas_maqueta->PlaceHolder = RemoveHtml($this->coordenadas_maqueta->caption());

        // reclamo
        $this->reclamo->setupEditAttributes();
        $this->reclamo->EditValue = $this->reclamo->CurrentValue;
        $this->reclamo->PlaceHolder = RemoveHtml($this->reclamo->caption());
        if (strval($this->reclamo->EditValue) != "" && is_numeric($this->reclamo->EditValue)) {
            $this->reclamo->EditValue = $this->reclamo->EditValue;
        }

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
                    $doc->exportCaption($this->Nlapidas_registro);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->parentesco);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->nombre_difunto);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->comentario);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->registro);
                    $doc->exportCaption($this->registra);
                    $doc->exportCaption($this->modificacion);
                    $doc->exportCaption($this->modifica);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->sub_seccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->boveda);
                    $doc->exportCaption($this->contrato);
                    $doc->exportCaption($this->maqueteo);
                } else {
                    $doc->exportCaption($this->Nlapidas_registro);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->parentesco);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->nombre_difunto);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->comentario);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->registro);
                    $doc->exportCaption($this->registra);
                    $doc->exportCaption($this->modificacion);
                    $doc->exportCaption($this->modifica);
                    $doc->exportCaption($this->seccion);
                    $doc->exportCaption($this->modulo);
                    $doc->exportCaption($this->sub_seccion);
                    $doc->exportCaption($this->parcela);
                    $doc->exportCaption($this->boveda);
                    $doc->exportCaption($this->contrato);
                    $doc->exportCaption($this->maqueteo);
                    $doc->exportCaption($this->coordenadas_maqueta);
                    $doc->exportCaption($this->reclamo);
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
                        $doc->exportField($this->Nlapidas_registro);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->parentesco);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->nombre_difunto);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->comentario);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->registro);
                        $doc->exportField($this->registra);
                        $doc->exportField($this->modificacion);
                        $doc->exportField($this->modifica);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->sub_seccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->boveda);
                        $doc->exportField($this->contrato);
                        $doc->exportField($this->maqueteo);
                    } else {
                        $doc->exportField($this->Nlapidas_registro);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->parentesco);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->nombre_difunto);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->comentario);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->registro);
                        $doc->exportField($this->registra);
                        $doc->exportField($this->modificacion);
                        $doc->exportField($this->modifica);
                        $doc->exportField($this->seccion);
                        $doc->exportField($this->modulo);
                        $doc->exportField($this->sub_seccion);
                        $doc->exportField($this->parcela);
                        $doc->exportField($this->boveda);
                        $doc->exportField($this->contrato);
                        $doc->exportField($this->maqueteo);
                        $doc->exportField($this->coordenadas_maqueta);
                        $doc->exportField($this->reclamo);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_lapidas_registro');
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
        $key .= $rs['Nlapidas_registro'];

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
                WriteAuditLog($usr, "A", 'sco_lapidas_registro', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nlapidas_registro'];

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
                    WriteAuditLog($usr, "U", 'sco_lapidas_registro', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nlapidas_registro'];

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
                WriteAuditLog($usr, "D", 'sco_lapidas_registro', $fldname, $key, $oldvalue);
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
        // 1. Forzar valores iniciales por seguridad
        $rsnew["estatus"] = "RECIBIDO";

        // 2. Usar CurrentDateTime() para mayor precisión (incluye hora si el campo lo permite)
        // O mantener CurrentDate() si el campo es estrictamente DATE
        $rsnew["registro"] = CurrentDateTime(); 

        // 3. Registrar el usuario actual de forma segura
        $rsnew["registra"] = CurrentUserName();

        // 4. Limpieza de datos (Opcional pero recomendado)
        // Aseguramos que campos de texto no tengan espacios accidentales al inicio/final
        if (isset($rsnew["solicitante"])) {
            $rsnew["solicitante"] = trim($rsnew["solicitante"]);
        }
        return TRUE;
    }

    public function rowInserted($rsold, $rsnew) {
        // 1. Validación de email para evitar errores de envío
        $to = $rsnew["email"] ?? "";
        if (empty($to)) return;

        // 2. Preparación de variables
        $ticket   = $rsnew["Nlapidas_registro"] ?? "N/A";
        $nombre   = $rsnew["solicitante"] ?? "Cliente";
        $servicio = $rsnew["tipo"] ?? "Servicio de Memorialización";
        $estatus  = $rsnew["estatus"] ?? "RECIBIDO";

        // Formateo de fecha seguro para PHP 8.1+
        $fechaRaw = $rsnew["registro"] ?? date("Y-m-d");
        $fecha    = date("d/m/Y", strtotime($fechaRaw));

        // 3. Asunto del correo
        $subject = "Cementerio Del Este - (MEMORIALIZACION) Ticket de Atención #$ticket";

        // 4. Construcción del Cuerpo del Mensaje (HTML)
        $cuerpo = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px;'>
            <h2 style='color: #2c3e50;'>Confirmación de Solicitud</h2>
            <p>Estimado(a) <b>$nombre</b>,</p>
            <p>Le informamos que hemos recibido formalmente su solicitud de <b>$servicio</b>.</p>
            <div style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #28a745; margin: 20px 0;'>
                <b>Detalles de su ticket:</b><br>
                • Número: <b>$ticket</b><br>
                • Fecha: <b>$fecha</b><br>
                • Estatus: <span style='color: #28a745; font-weight: bold;'>$estatus</span>
            </div>
            <p>Nuestro equipo de Memorialización comenzará a procesar su requerimiento a la brevedad posible.</p>
            <br>
            <hr style='border: 0; border-top: 1px solid #eee;'>
            <img src='http://cementeriodeleste.com.ve/images/samples/logo.png' alt='Cementerio del Este' width='220'>
            <br><br>
            <a href='http://cementeriodeleste.com.ve/' style='color: #0056b3; text-decoration: none;'>www.cementeriodeleste.com.ve</a>
        </div>";

        // 5. Envío mediante el arreglo requerido por tu función global
        try {
            EnviarCorreo([
                'to'      => $to,
                'subject' => $subject,
                'body'    => $cuerpo
            ]);
        } catch (Exception $e) {
            // En Server Events es mejor no interrumpir el flujo si falla el correo
            // Podrías usar Log($e->getMessage()); si tienes habilitado el logging
        }
    }

    public function rowUpdating($rsold, &$rsnew) {
        // 1. Auditoría: Fecha y Usuario de modificación
        // Usamos CurrentDateTime() para mayor precisión y compatibilidad de zona horaria
        $rsnew["modificacion"] = CurrentDateTime();
        $rsnew["modifica"] = CurrentUserName();

        // 2. Detección de cambio de estatus
        // Verificamos que el estatus exista en rsnew (solo existe si se modificó en el formulario)
        if (isset($rsnew["estatus"]) && $rsold["estatus"] !== $rsnew["estatus"]) {
            $idRegistro = $rsold["Nlapidas_registro"];
            $estatusViejo = $rsold["estatus"] ?? "SIN ESTATUS";
            $estatusNuevo = $rsnew["estatus"];
            $usuario = CurrentUserName();

            // Construimos el mensaje de la nota
            $mensaje = "Cambio de estatus de '" . $estatusViejo . "' a '" . $estatusNuevo . "'";

            // Escapamos los valores para el SQL (estándar Doctrine en PHPMaker 2024)
            $sql = "INSERT INTO sco_lapidas_notas 
                        (lapida_registro, nota, usuario, fecha)
                    VALUES (
                        " . Conn()->quote($idRegistro) . ", 
                        " . Conn()->quote($mensaje) . ", 
                        " . Conn()->quote($usuario) . ", 
                        NOW()
                    )";
            Execute($sql);
        }
        return TRUE;
    }
    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
        // 1. Actualización de la tabla maestra (sco_reclamo) según el nuevo estatus
        // Solo actuamos si el estatus viene en el rsnew (es decir, cambió)
        if (isset($rsnew["estatus"])) {
            $nReclamo = $rsold["reclamo"];
            $nuevoEstatusMaestro = "";
            if ($rsnew["estatus"] == "INSTALADA") {
                $nuevoEstatusMaestro = "RESUELTO";
            } elseif ($rsnew["estatus"] == "ANULADO") {
                $nuevoEstatusMaestro = "RECHAZADO";
            }
            if ($nuevoEstatusMaestro != "") {
                $sql = "UPDATE sco_reclamo SET estatus = " . Conn()->quote($nuevoEstatusMaestro) . " WHERE Nreclamo = " . Conn()->quote($nReclamo);
                Execute($sql);
            }
        }

        // 2. Notificación por Correo Electrónico
        // Se envía si el estatus cambió y el nuevo estatus NO es "ANULADO"
        if (isset($rsnew["estatus"]) && $rsold["estatus"] != $rsnew["estatus"]) {
            if (trim($rsnew["estatus"]) != "ANULADO") {
                $to = $rsnew["email"] ?? $rsold["email"]; // Intentar obtener el correo actualizado o el anterior
                if (empty($to)) return;
                $ticket   = $rsold["Nlapidas_registro"];
                $nombre   = $rsnew["solicitante"] ?? $rsold["solicitante"];
                $servicio = $rsnew["tipo"] ?? $rsold["tipo"];
                $estatus  = $rsnew["estatus"];

                // Formateo de fecha de modificación
                $fechaMod = !empty($rsnew["modificacion"]) ? date("d/m/Y", strtotime($rsnew["modificacion"])) : date("d/m/Y");
                $subject = "Cementerio Del Este - (MEMORIALIZACION) Cambio de Estatus ($estatus) Ticket: #$ticket";

                // Cuerpo del mensaje estilizado
                $cuerpo = "
                <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px;'>
                    <p>Estimado(a) <b>$nombre</b>,</p>
                    <p>Le informamos que con fecha <b>$fechaMod</b>, su caso de <b>$servicio</b> ha sido actualizado.</p>
                    <div style='background-color: #f1f3f5; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;'>
                        <b>Nuevo Estatus:</b> <span style='color: #007bff; font-weight: bold;'>$estatus</span><br>
                        <b>Número de Ticket:</b> #$ticket
                    </div>
                    <p>Puede hacer seguimiento a su solicitud a través de nuestros canales de atención.</p>
                    <br>
                    <hr style='border: 0; border-top: 1px solid #eee;'>
                    <img src='http://cementeriodeleste.com.ve/images/samples/logo.png' alt='Logo' width='220'>
                    <br><br>
                    <a href='http://cementeriodeleste.com.ve/' style='color: #0056b3; text-decoration: none;'>www.cementeriodeleste.com.ve</a>
                </div>";

                // 3. Llamada a la función global mediante el arreglo
                try {
                    EnviarCorreo([
                        'to'      => $to,
                        'subject' => $subject,
                        'body'    => $cuerpo
                    ]);
                } catch (Exception $e) {
                    // Error silencioso para no interrumpir la interfaz
                }
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

    // Row Rendering event
    public function rowRendering() {
        // 1. Inicializamos la variable para evitar los Warnings
        $style = ""; 
        if ($this->PageID == "list" || $this->PageID == "view") {
            // 2. Convertimos a mayúsculas para asegurar que el switch coincida siempre
            $statusValue = strtoupper(trim($this->estatus->CurrentValue ?? ""));
            switch($statusValue) {
                case "RECIBIDO":
                    $style = "background-color: #dc3545; color: white;"; // Rojo Bootstrap    
                    break;
                case "PROCESANDO BOCETO":
                    $style = "background-color: #ffc107; color: black;"; // Amarillo Bootstrap    
                    break;
                case "IMPRESO":
                    $style = "background-color: #007bff; color: white;"; // Azul Bootstrap  
                    break;
                case "INSTALADA":
                    $style = "background-color: #28a745; color: white;"; // Verde Bootstrap  
                    break;
                case "ANULADO":
                    $style = "background-color: #6c757d; color: white;"; // Gris Bootstrap  
                    break;
                default:
                    $style = ""; // Estilo por defecto si no coincide nada
                    break;
            }

            // 3. Solo aplicamos si el estilo no está vacío
            if ($style !== "") {
                $this->estatus->CellAttrs["style"] = $style;
                $this->parentesco->CellAttrs["style"] = $style;
                $this->nombre_difunto->CellAttrs["style"] = $style;
                $this->contrato->CellAttrs["style"] = $style;
                $this->modificacion->CellAttrs["style"] = $style;
                $this->modifica->CellAttrs["style"] = $style;
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
