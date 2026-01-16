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
 * Table class for sco_mttotecnico
 */
class ScoMttotecnico extends DbTable
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
    public $Nmttotecnico;
    public $fecha_registro;
    public $user_solicita;
    public $tipo_solicitud;
    public $unidad_solicitante;
    public $area_falla;
    public $comentario;
    public $prioridad;
    public $estatus;
    public $falla_atendida_por;
    public $diagnostico;
    public $solucion;
    public $user_diagnostico;
    public $requiere_materiales;
    public $fecha_solucion;
    public $materiales;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_mttotecnico";
        $this->TableName = 'sco_mttotecnico';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_mttotecnico";
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

        // Nmttotecnico
        $this->Nmttotecnico = new DbField(
            $this, // Table
            'x_Nmttotecnico', // Variable name
            'Nmttotecnico', // Name
            '`Nmttotecnico`', // Expression
            '`Nmttotecnico`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nmttotecnico`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nmttotecnico->InputTextType = "text";
        $this->Nmttotecnico->Raw = true;
        $this->Nmttotecnico->IsAutoIncrement = true; // Autoincrement field
        $this->Nmttotecnico->IsPrimaryKey = true; // Primary key field
        $this->Nmttotecnico->IsForeignKey = true; // Foreign key field
        $this->Nmttotecnico->Nullable = false; // NOT NULL field
        $this->Nmttotecnico->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nmttotecnico->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nmttotecnico'] = &$this->Nmttotecnico;

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

        // user_solicita
        $this->user_solicita = new DbField(
            $this, // Table
            'x_user_solicita', // Variable name
            'user_solicita', // Name
            '`user_solicita`', // Expression
            '`user_solicita`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`user_solicita`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->user_solicita->InputTextType = "text";
        $this->user_solicita->Required = true; // Required field
        $this->user_solicita->Lookup = new Lookup($this->user_solicita, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->user_solicita->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_solicita'] = &$this->user_solicita;

        // tipo_solicitud
        $this->tipo_solicitud = new DbField(
            $this, // Table
            'x_tipo_solicitud', // Variable name
            'tipo_solicitud', // Name
            '`tipo_solicitud`', // Expression
            '`tipo_solicitud`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_solicitud`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo_solicitud->addMethod("getSelectFilter", fn() => "`tabla` = 'SOLICITUD_MTTO_TECNICO'");
        $this->tipo_solicitud->InputTextType = "text";
        $this->tipo_solicitud->Required = true; // Required field
        $this->tipo_solicitud->setSelectMultiple(false); // Select one
        $this->tipo_solicitud->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_solicitud->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo_solicitud->Lookup = new Lookup($this->tipo_solicitud, 'sco_tabla', false, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->tipo_solicitud->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo_solicitud'] = &$this->tipo_solicitud;

        // unidad_solicitante
        $this->unidad_solicitante = new DbField(
            $this, // Table
            'x_unidad_solicitante', // Variable name
            'unidad_solicitante', // Name
            '`unidad_solicitante`', // Expression
            '`unidad_solicitante`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`unidad_solicitante`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->unidad_solicitante->addMethod("getSelectFilter", fn() => "`tabla` = 'UNIDAD_SOLICITANTE'");
        $this->unidad_solicitante->InputTextType = "text";
        $this->unidad_solicitante->Required = true; // Required field
        $this->unidad_solicitante->setSelectMultiple(false); // Select one
        $this->unidad_solicitante->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->unidad_solicitante->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->unidad_solicitante->Lookup = new Lookup($this->unidad_solicitante, 'sco_tabla', false, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->unidad_solicitante->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['unidad_solicitante'] = &$this->unidad_solicitante;

        // area_falla
        $this->area_falla = new DbField(
            $this, // Table
            'x_area_falla', // Variable name
            'area_falla', // Name
            '`area_falla`', // Expression
            '`area_falla`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`area_falla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->area_falla->addMethod("getSelectFilter", fn() => "`tabla` = 'AREAS_MANTENIMIENTO'");
        $this->area_falla->InputTextType = "text";
        $this->area_falla->Required = true; // Required field
        $this->area_falla->setSelectMultiple(false); // Select one
        $this->area_falla->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->area_falla->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->area_falla->Lookup = new Lookup($this->area_falla, 'sco_tabla', false, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->area_falla->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['area_falla'] = &$this->area_falla;

        // comentario
        $this->comentario = new DbField(
            $this, // Table
            'x_comentario', // Variable name
            'comentario', // Name
            '`comentario`', // Expression
            '`comentario`', // Basic search expression
            200, // Type
            250, // Size
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

        // prioridad
        $this->prioridad = new DbField(
            $this, // Table
            'x_prioridad', // Variable name
            'prioridad', // Name
            '`prioridad`', // Expression
            '`prioridad`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`prioridad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->prioridad->InputTextType = "text";
        $this->prioridad->Required = true; // Required field
        $this->prioridad->setSelectMultiple(false); // Select one
        $this->prioridad->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->prioridad->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->prioridad->Lookup = new Lookup($this->prioridad, 'sco_mttotecnico', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->prioridad->OptionCount = 3;
        $this->prioridad->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['prioridad'] = &$this->prioridad;

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            200, // Type
            12, // Size
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
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_mttotecnico', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->estatus->OptionCount = 3;
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

        // falla_atendida_por
        $this->falla_atendida_por = new DbField(
            $this, // Table
            'x_falla_atendida_por', // Variable name
            'falla_atendida_por', // Name
            '`falla_atendida_por`', // Expression
            '`falla_atendida_por`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`falla_atendida_por`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->falla_atendida_por->addMethod("getSelectFilter", fn() => "`tabla` = 'SOLICITUD_MTTO_TECNICO'");
        $this->falla_atendida_por->InputTextType = "text";
        $this->falla_atendida_por->setSelectMultiple(false); // Select one
        $this->falla_atendida_por->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->falla_atendida_por->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->falla_atendida_por->Lookup = new Lookup($this->falla_atendida_por, 'sco_tabla', false, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion`', '', "`campo_descripcion`");
        $this->falla_atendida_por->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['falla_atendida_por'] = &$this->falla_atendida_por;

        // diagnostico
        $this->diagnostico = new DbField(
            $this, // Table
            'x_diagnostico', // Variable name
            'diagnostico', // Name
            '`diagnostico`', // Expression
            '`diagnostico`', // Basic search expression
            200, // Type
            250, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`diagnostico`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->diagnostico->InputTextType = "text";
        $this->diagnostico->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['diagnostico'] = &$this->diagnostico;

        // solucion
        $this->solucion = new DbField(
            $this, // Table
            'x_solucion', // Variable name
            'solucion', // Name
            '`solucion`', // Expression
            '`solucion`', // Basic search expression
            200, // Type
            250, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`solucion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->solucion->InputTextType = "text";
        $this->solucion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['solucion'] = &$this->solucion;

        // user_diagnostico
        $this->user_diagnostico = new DbField(
            $this, // Table
            'x_user_diagnostico', // Variable name
            'user_diagnostico', // Name
            '`user_diagnostico`', // Expression
            '`user_diagnostico`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`user_diagnostico`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->user_diagnostico->InputTextType = "text";
        $this->user_diagnostico->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user_diagnostico'] = &$this->user_diagnostico;

        // requiere_materiales
        $this->requiere_materiales = new DbField(
            $this, // Table
            'x_requiere_materiales', // Variable name
            'requiere_materiales', // Name
            '`requiere_materiales`', // Expression
            '`requiere_materiales`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`requiere_materiales`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->requiere_materiales->addMethod("getDefault", fn() => "N");
        $this->requiere_materiales->InputTextType = "text";
        $this->requiere_materiales->Raw = true;
        $this->requiere_materiales->Required = true; // Required field
        $this->requiere_materiales->setSelectMultiple(false); // Select one
        $this->requiere_materiales->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->requiere_materiales->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->requiere_materiales->Lookup = new Lookup($this->requiere_materiales, 'sco_mttotecnico', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->requiere_materiales->OptionCount = 2;
        $this->requiere_materiales->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['requiere_materiales'] = &$this->requiere_materiales;

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

        // materiales
        $this->materiales = new DbField(
            $this, // Table
            'x_materiales', // Variable name
            'materiales', // Name
            '`materiales`', // Expression
            '`materiales`', // Basic search expression
            200, // Type
            250, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`materiales`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->materiales->InputTextType = "text";
        $this->materiales->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['materiales'] = &$this->materiales;

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
        if ($this->getCurrentDetailTable() == "sco_mttotecnico_adjunto") {
            $detailUrl = Container("sco_mttotecnico_adjunto")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nmttotecnico", $this->Nmttotecnico->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_mttotecnico_notas") {
            $detailUrl = Container("sco_mttotecnico_notas")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nmttotecnico", $this->Nmttotecnico->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoMttotecnicoList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_mttotecnico";
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
            $this->Nmttotecnico->setDbValue($conn->lastInsertId());
            $rs['Nmttotecnico'] = $this->Nmttotecnico->DbValue;
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
        // Cascade Update detail table 'sco_mttotecnico_adjunto'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nmttotecnico']) && $rsold['Nmttotecnico'] != $rs['Nmttotecnico'])) { // Update detail field 'mttotecnico'
            $cascadeUpdate = true;
            $rscascade['mttotecnico'] = $rs['Nmttotecnico'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_mttotecnico_adjunto")->loadRs("`mttotecnico` = " . QuotedValue($rsold['Nmttotecnico'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nmttotecnico_adjunto';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_mttotecnico_adjunto")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_mttotecnico_adjunto")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_mttotecnico_adjunto")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'sco_mttotecnico_notas'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nmttotecnico']) && $rsold['Nmttotecnico'] != $rs['Nmttotecnico'])) { // Update detail field 'mttotecnico'
            $cascadeUpdate = true;
            $rscascade['mttotecnico'] = $rs['Nmttotecnico'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_mttotecnico_notas")->loadRs("`mttotecnico` = " . QuotedValue($rsold['Nmttotecnico'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nmttotecnico_notas';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_mttotecnico_notas")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_mttotecnico_notas")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_mttotecnico_notas")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Nmttotecnico']) && !EmptyValue($this->Nmttotecnico->CurrentValue)) {
                $rs['Nmttotecnico'] = $this->Nmttotecnico->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nmttotecnico';
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
            if (array_key_exists('Nmttotecnico', $rs)) {
                AddFilter($where, QuotedName('Nmttotecnico', $this->Dbid) . '=' . QuotedValue($rs['Nmttotecnico'], $this->Nmttotecnico->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_mttotecnico_adjunto'
        $dtlrows = Container("sco_mttotecnico_adjunto")->loadRs("`mttotecnico` = " . QuotedValue($rs['Nmttotecnico'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_mttotecnico_adjunto")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_mttotecnico_adjunto")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_mttotecnico_adjunto")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'sco_mttotecnico_notas'
        $dtlrows = Container("sco_mttotecnico_notas")->loadRs("`mttotecnico` = " . QuotedValue($rs['Nmttotecnico'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_mttotecnico_notas")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_mttotecnico_notas")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_mttotecnico_notas")->rowDeleted($dtlrow);
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
        $this->Nmttotecnico->DbValue = $row['Nmttotecnico'];
        $this->fecha_registro->DbValue = $row['fecha_registro'];
        $this->user_solicita->DbValue = $row['user_solicita'];
        $this->tipo_solicitud->DbValue = $row['tipo_solicitud'];
        $this->unidad_solicitante->DbValue = $row['unidad_solicitante'];
        $this->area_falla->DbValue = $row['area_falla'];
        $this->comentario->DbValue = $row['comentario'];
        $this->prioridad->DbValue = $row['prioridad'];
        $this->estatus->DbValue = $row['estatus'];
        $this->falla_atendida_por->DbValue = $row['falla_atendida_por'];
        $this->diagnostico->DbValue = $row['diagnostico'];
        $this->solucion->DbValue = $row['solucion'];
        $this->user_diagnostico->DbValue = $row['user_diagnostico'];
        $this->requiere_materiales->DbValue = $row['requiere_materiales'];
        $this->fecha_solucion->DbValue = $row['fecha_solucion'];
        $this->materiales->DbValue = $row['materiales'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nmttotecnico` = @Nmttotecnico@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nmttotecnico->CurrentValue : $this->Nmttotecnico->OldValue;
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
                $this->Nmttotecnico->CurrentValue = $keys[0];
            } else {
                $this->Nmttotecnico->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nmttotecnico', $row) ? $row['Nmttotecnico'] : null;
        } else {
            $val = !EmptyValue($this->Nmttotecnico->OldValue) && !$current ? $this->Nmttotecnico->OldValue : $this->Nmttotecnico->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nmttotecnico@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoMttotecnicoList");
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
            "ScoMttotecnicoView" => $Language->phrase("View"),
            "ScoMttotecnicoEdit" => $Language->phrase("Edit"),
            "ScoMttotecnicoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoMttotecnicoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoMttotecnicoView",
            Config("API_ADD_ACTION") => "ScoMttotecnicoAdd",
            Config("API_EDIT_ACTION") => "ScoMttotecnicoEdit",
            Config("API_DELETE_ACTION") => "ScoMttotecnicoDelete",
            Config("API_LIST_ACTION") => "ScoMttotecnicoList",
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
        return "ScoMttotecnicoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoMttotecnicoView", $parm);
        } else {
            $url = $this->keyUrl("ScoMttotecnicoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoMttotecnicoAdd?" . $parm;
        } else {
            $url = "ScoMttotecnicoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoMttotecnicoEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoMttotecnicoEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoMttotecnicoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoMttotecnicoAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoMttotecnicoAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoMttotecnicoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoMttotecnicoDelete", $parm);
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
        $json .= "\"Nmttotecnico\":" . VarToJson($this->Nmttotecnico->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nmttotecnico->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nmttotecnico->CurrentValue);
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
            if (($keyValue = Param("Nmttotecnico") ?? Route("Nmttotecnico")) !== null) {
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
                $this->Nmttotecnico->CurrentValue = $key;
            } else {
                $this->Nmttotecnico->OldValue = $key;
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
        $this->Nmttotecnico->setDbValue($row['Nmttotecnico']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_solicita->setDbValue($row['user_solicita']);
        $this->tipo_solicitud->setDbValue($row['tipo_solicitud']);
        $this->unidad_solicitante->setDbValue($row['unidad_solicitante']);
        $this->area_falla->setDbValue($row['area_falla']);
        $this->comentario->setDbValue($row['comentario']);
        $this->prioridad->setDbValue($row['prioridad']);
        $this->estatus->setDbValue($row['estatus']);
        $this->falla_atendida_por->setDbValue($row['falla_atendida_por']);
        $this->diagnostico->setDbValue($row['diagnostico']);
        $this->solucion->setDbValue($row['solucion']);
        $this->user_diagnostico->setDbValue($row['user_diagnostico']);
        $this->requiere_materiales->setDbValue($row['requiere_materiales']);
        $this->fecha_solucion->setDbValue($row['fecha_solucion']);
        $this->materiales->setDbValue($row['materiales']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoMttotecnicoList";
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

        // Nmttotecnico

        // fecha_registro

        // user_solicita

        // tipo_solicitud

        // unidad_solicitante

        // area_falla

        // comentario

        // prioridad

        // estatus

        // falla_atendida_por

        // diagnostico

        // solucion

        // user_diagnostico

        // requiere_materiales

        // fecha_solucion

        // materiales

        // Nmttotecnico
        $this->Nmttotecnico->ViewValue = $this->Nmttotecnico->CurrentValue;

        // fecha_registro
        $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
        $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

        // user_solicita
        $this->user_solicita->ViewValue = $this->user_solicita->CurrentValue;
        $curVal = strval($this->user_solicita->CurrentValue);
        if ($curVal != "") {
            $this->user_solicita->ViewValue = $this->user_solicita->lookupCacheOption($curVal);
            if ($this->user_solicita->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->user_solicita->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->user_solicita->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->user_solicita->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->user_solicita->Lookup->renderViewRow($rswrk[0]);
                    $this->user_solicita->ViewValue = $this->user_solicita->displayValue($arwrk);
                } else {
                    $this->user_solicita->ViewValue = $this->user_solicita->CurrentValue;
                }
            }
        } else {
            $this->user_solicita->ViewValue = null;
        }

        // tipo_solicitud
        $curVal = strval($this->tipo_solicitud->CurrentValue);
        if ($curVal != "") {
            $this->tipo_solicitud->ViewValue = $this->tipo_solicitud->lookupCacheOption($curVal);
            if ($this->tipo_solicitud->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_solicitud->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->tipo_solicitud->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->tipo_solicitud->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_solicitud->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_solicitud->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_solicitud->ViewValue = $this->tipo_solicitud->displayValue($arwrk);
                } else {
                    $this->tipo_solicitud->ViewValue = $this->tipo_solicitud->CurrentValue;
                }
            }
        } else {
            $this->tipo_solicitud->ViewValue = null;
        }

        // unidad_solicitante
        $curVal = strval($this->unidad_solicitante->CurrentValue);
        if ($curVal != "") {
            $this->unidad_solicitante->ViewValue = $this->unidad_solicitante->lookupCacheOption($curVal);
            if ($this->unidad_solicitante->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->unidad_solicitante->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->unidad_solicitante->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->unidad_solicitante->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_solicitante->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unidad_solicitante->Lookup->renderViewRow($rswrk[0]);
                    $this->unidad_solicitante->ViewValue = $this->unidad_solicitante->displayValue($arwrk);
                } else {
                    $this->unidad_solicitante->ViewValue = $this->unidad_solicitante->CurrentValue;
                }
            }
        } else {
            $this->unidad_solicitante->ViewValue = null;
        }

        // area_falla
        $curVal = strval($this->area_falla->CurrentValue);
        if ($curVal != "") {
            $this->area_falla->ViewValue = $this->area_falla->lookupCacheOption($curVal);
            if ($this->area_falla->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->area_falla->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->area_falla->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->area_falla->getSelectFilter($this); // PHP
                $sqlWrk = $this->area_falla->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->area_falla->Lookup->renderViewRow($rswrk[0]);
                    $this->area_falla->ViewValue = $this->area_falla->displayValue($arwrk);
                } else {
                    $this->area_falla->ViewValue = $this->area_falla->CurrentValue;
                }
            }
        } else {
            $this->area_falla->ViewValue = null;
        }

        // comentario
        $this->comentario->ViewValue = $this->comentario->CurrentValue;

        // prioridad
        if (strval($this->prioridad->CurrentValue) != "") {
            $this->prioridad->ViewValue = $this->prioridad->optionCaption($this->prioridad->CurrentValue);
        } else {
            $this->prioridad->ViewValue = null;
        }

        // estatus
        if (strval($this->estatus->CurrentValue) != "") {
            $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
        } else {
            $this->estatus->ViewValue = null;
        }

        // falla_atendida_por
        $curVal = strval($this->falla_atendida_por->CurrentValue);
        if ($curVal != "") {
            $this->falla_atendida_por->ViewValue = $this->falla_atendida_por->lookupCacheOption($curVal);
            if ($this->falla_atendida_por->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->falla_atendida_por->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->falla_atendida_por->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->falla_atendida_por->getSelectFilter($this); // PHP
                $sqlWrk = $this->falla_atendida_por->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->falla_atendida_por->Lookup->renderViewRow($rswrk[0]);
                    $this->falla_atendida_por->ViewValue = $this->falla_atendida_por->displayValue($arwrk);
                } else {
                    $this->falla_atendida_por->ViewValue = $this->falla_atendida_por->CurrentValue;
                }
            }
        } else {
            $this->falla_atendida_por->ViewValue = null;
        }

        // diagnostico
        $this->diagnostico->ViewValue = $this->diagnostico->CurrentValue;

        // solucion
        $this->solucion->ViewValue = $this->solucion->CurrentValue;

        // user_diagnostico
        $this->user_diagnostico->ViewValue = $this->user_diagnostico->CurrentValue;

        // requiere_materiales
        if (strval($this->requiere_materiales->CurrentValue) != "") {
            $this->requiere_materiales->ViewValue = $this->requiere_materiales->optionCaption($this->requiere_materiales->CurrentValue);
        } else {
            $this->requiere_materiales->ViewValue = null;
        }

        // fecha_solucion
        $this->fecha_solucion->ViewValue = $this->fecha_solucion->CurrentValue;
        $this->fecha_solucion->ViewValue = FormatDateTime($this->fecha_solucion->ViewValue, $this->fecha_solucion->formatPattern());

        // materiales
        $this->materiales->ViewValue = $this->materiales->CurrentValue;

        // Nmttotecnico
        $this->Nmttotecnico->HrefValue = "";
        $this->Nmttotecnico->TooltipValue = "";

        // fecha_registro
        $this->fecha_registro->HrefValue = "";
        $this->fecha_registro->TooltipValue = "";

        // user_solicita
        $this->user_solicita->HrefValue = "";
        $this->user_solicita->TooltipValue = "";

        // tipo_solicitud
        $this->tipo_solicitud->HrefValue = "";
        $this->tipo_solicitud->TooltipValue = "";

        // unidad_solicitante
        $this->unidad_solicitante->HrefValue = "";
        $this->unidad_solicitante->TooltipValue = "";

        // area_falla
        $this->area_falla->HrefValue = "";
        $this->area_falla->TooltipValue = "";

        // comentario
        $this->comentario->HrefValue = "";
        $this->comentario->TooltipValue = "";

        // prioridad
        $this->prioridad->HrefValue = "";
        $this->prioridad->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // falla_atendida_por
        $this->falla_atendida_por->HrefValue = "";
        $this->falla_atendida_por->TooltipValue = "";

        // diagnostico
        $this->diagnostico->HrefValue = "";
        $this->diagnostico->TooltipValue = "";

        // solucion
        $this->solucion->HrefValue = "";
        $this->solucion->TooltipValue = "";

        // user_diagnostico
        $this->user_diagnostico->HrefValue = "";
        $this->user_diagnostico->TooltipValue = "";

        // requiere_materiales
        $this->requiere_materiales->HrefValue = "";
        $this->requiere_materiales->TooltipValue = "";

        // fecha_solucion
        $this->fecha_solucion->HrefValue = "";
        $this->fecha_solucion->TooltipValue = "";

        // materiales
        $this->materiales->HrefValue = "";
        $this->materiales->TooltipValue = "";

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

        // Nmttotecnico
        $this->Nmttotecnico->setupEditAttributes();
        $this->Nmttotecnico->EditValue = $this->Nmttotecnico->CurrentValue;

        // fecha_registro
        $this->fecha_registro->setupEditAttributes();
        $this->fecha_registro->EditValue = FormatDateTime($this->fecha_registro->CurrentValue, $this->fecha_registro->formatPattern());
        $this->fecha_registro->PlaceHolder = RemoveHtml($this->fecha_registro->caption());

        // user_solicita
        $this->user_solicita->setupEditAttributes();
        if (!$this->user_solicita->Raw) {
            $this->user_solicita->CurrentValue = HtmlDecode($this->user_solicita->CurrentValue);
        }
        $this->user_solicita->EditValue = $this->user_solicita->CurrentValue;
        $this->user_solicita->PlaceHolder = RemoveHtml($this->user_solicita->caption());

        // tipo_solicitud
        $this->tipo_solicitud->setupEditAttributes();
        $curVal = strval($this->tipo_solicitud->CurrentValue);
        if ($curVal != "") {
            $this->tipo_solicitud->EditValue = $this->tipo_solicitud->lookupCacheOption($curVal);
            if ($this->tipo_solicitud->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_solicitud->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->tipo_solicitud->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->tipo_solicitud->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_solicitud->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_solicitud->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_solicitud->EditValue = $this->tipo_solicitud->displayValue($arwrk);
                } else {
                    $this->tipo_solicitud->EditValue = $this->tipo_solicitud->CurrentValue;
                }
            }
        } else {
            $this->tipo_solicitud->EditValue = null;
        }

        // unidad_solicitante
        $this->unidad_solicitante->setupEditAttributes();
        $curVal = strval($this->unidad_solicitante->CurrentValue);
        if ($curVal != "") {
            $this->unidad_solicitante->EditValue = $this->unidad_solicitante->lookupCacheOption($curVal);
            if ($this->unidad_solicitante->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->unidad_solicitante->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->unidad_solicitante->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->unidad_solicitante->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_solicitante->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unidad_solicitante->Lookup->renderViewRow($rswrk[0]);
                    $this->unidad_solicitante->EditValue = $this->unidad_solicitante->displayValue($arwrk);
                } else {
                    $this->unidad_solicitante->EditValue = $this->unidad_solicitante->CurrentValue;
                }
            }
        } else {
            $this->unidad_solicitante->EditValue = null;
        }

        // area_falla
        $this->area_falla->setupEditAttributes();
        $curVal = strval($this->area_falla->CurrentValue);
        if ($curVal != "") {
            $this->area_falla->EditValue = $this->area_falla->lookupCacheOption($curVal);
            if ($this->area_falla->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->area_falla->Lookup->getTable()->Fields["campo_descripcion"]->searchExpression(), "=", $curVal, $this->area_falla->Lookup->getTable()->Fields["campo_descripcion"]->searchDataType(), "");
                $lookupFilter = $this->area_falla->getSelectFilter($this); // PHP
                $sqlWrk = $this->area_falla->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->area_falla->Lookup->renderViewRow($rswrk[0]);
                    $this->area_falla->EditValue = $this->area_falla->displayValue($arwrk);
                } else {
                    $this->area_falla->EditValue = $this->area_falla->CurrentValue;
                }
            }
        } else {
            $this->area_falla->EditValue = null;
        }

        // comentario
        $this->comentario->setupEditAttributes();
        $this->comentario->EditValue = $this->comentario->CurrentValue;

        // prioridad
        $this->prioridad->setupEditAttributes();
        if (strval($this->prioridad->CurrentValue) != "") {
            $this->prioridad->EditValue = $this->prioridad->optionCaption($this->prioridad->CurrentValue);
        } else {
            $this->prioridad->EditValue = null;
        }

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->options(true);
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // falla_atendida_por
        $this->falla_atendida_por->setupEditAttributes();
        $this->falla_atendida_por->PlaceHolder = RemoveHtml($this->falla_atendida_por->caption());

        // diagnostico
        $this->diagnostico->setupEditAttributes();
        $this->diagnostico->EditValue = $this->diagnostico->CurrentValue;
        $this->diagnostico->PlaceHolder = RemoveHtml($this->diagnostico->caption());

        // solucion
        $this->solucion->setupEditAttributes();
        $this->solucion->EditValue = $this->solucion->CurrentValue;
        $this->solucion->PlaceHolder = RemoveHtml($this->solucion->caption());

        // user_diagnostico
        $this->user_diagnostico->setupEditAttributes();
        if (!$this->user_diagnostico->Raw) {
            $this->user_diagnostico->CurrentValue = HtmlDecode($this->user_diagnostico->CurrentValue);
        }
        $this->user_diagnostico->EditValue = $this->user_diagnostico->CurrentValue;
        $this->user_diagnostico->PlaceHolder = RemoveHtml($this->user_diagnostico->caption());

        // requiere_materiales
        $this->requiere_materiales->setupEditAttributes();
        $this->requiere_materiales->EditValue = $this->requiere_materiales->options(true);
        $this->requiere_materiales->PlaceHolder = RemoveHtml($this->requiere_materiales->caption());

        // fecha_solucion
        $this->fecha_solucion->setupEditAttributes();
        $this->fecha_solucion->EditValue = FormatDateTime($this->fecha_solucion->CurrentValue, $this->fecha_solucion->formatPattern());
        $this->fecha_solucion->PlaceHolder = RemoveHtml($this->fecha_solucion->caption());

        // materiales
        $this->materiales->setupEditAttributes();
        if (!$this->materiales->Raw) {
            $this->materiales->CurrentValue = HtmlDecode($this->materiales->CurrentValue);
        }
        $this->materiales->EditValue = $this->materiales->CurrentValue;
        $this->materiales->PlaceHolder = RemoveHtml($this->materiales->caption());

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
                    $doc->exportCaption($this->Nmttotecnico);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->user_solicita);
                    $doc->exportCaption($this->tipo_solicitud);
                    $doc->exportCaption($this->unidad_solicitante);
                    $doc->exportCaption($this->area_falla);
                    $doc->exportCaption($this->comentario);
                    $doc->exportCaption($this->prioridad);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->falla_atendida_por);
                    $doc->exportCaption($this->diagnostico);
                    $doc->exportCaption($this->solucion);
                    $doc->exportCaption($this->user_diagnostico);
                    $doc->exportCaption($this->requiere_materiales);
                    $doc->exportCaption($this->fecha_solucion);
                } else {
                    $doc->exportCaption($this->Nmttotecnico);
                    $doc->exportCaption($this->fecha_registro);
                    $doc->exportCaption($this->user_solicita);
                    $doc->exportCaption($this->tipo_solicitud);
                    $doc->exportCaption($this->unidad_solicitante);
                    $doc->exportCaption($this->area_falla);
                    $doc->exportCaption($this->comentario);
                    $doc->exportCaption($this->prioridad);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->falla_atendida_por);
                    $doc->exportCaption($this->diagnostico);
                    $doc->exportCaption($this->solucion);
                    $doc->exportCaption($this->user_diagnostico);
                    $doc->exportCaption($this->requiere_materiales);
                    $doc->exportCaption($this->fecha_solucion);
                    $doc->exportCaption($this->materiales);
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
                        $doc->exportField($this->Nmttotecnico);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->user_solicita);
                        $doc->exportField($this->tipo_solicitud);
                        $doc->exportField($this->unidad_solicitante);
                        $doc->exportField($this->area_falla);
                        $doc->exportField($this->comentario);
                        $doc->exportField($this->prioridad);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->falla_atendida_por);
                        $doc->exportField($this->diagnostico);
                        $doc->exportField($this->solucion);
                        $doc->exportField($this->user_diagnostico);
                        $doc->exportField($this->requiere_materiales);
                        $doc->exportField($this->fecha_solucion);
                    } else {
                        $doc->exportField($this->Nmttotecnico);
                        $doc->exportField($this->fecha_registro);
                        $doc->exportField($this->user_solicita);
                        $doc->exportField($this->tipo_solicitud);
                        $doc->exportField($this->unidad_solicitante);
                        $doc->exportField($this->area_falla);
                        $doc->exportField($this->comentario);
                        $doc->exportField($this->prioridad);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->falla_atendida_por);
                        $doc->exportField($this->diagnostico);
                        $doc->exportField($this->solucion);
                        $doc->exportField($this->user_diagnostico);
                        $doc->exportField($this->requiere_materiales);
                        $doc->exportField($this->fecha_solucion);
                        $doc->exportField($this->materiales);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_mttotecnico');
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
        $key .= $rs['Nmttotecnico'];

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
                WriteAuditLog($usr, "A", 'sco_mttotecnico', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nmttotecnico'];

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
                    WriteAuditLog($usr, "U", 'sco_mttotecnico', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nmttotecnico'];

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
                WriteAuditLog($usr, "D", 'sco_mttotecnico', $fldname, $key, $oldvalue);
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
        // Si es una FALLA, debe tener tipo de solicitud
        if ($rsnew["estatus"] == "FALLA" && empty(trim($rsnew["tipo_solicitud"]))) {
            $this->setFailureMessage("Debe indicar una falla.");
            return FALSE;
        }

        // Si es REPARACIÓN, validar solución y fecha
        if ($rsnew["estatus"] == "REPARACION") {
            if (empty(trim($rsnew["solucion"]))) {
                $this->setFailureMessage("Debe indicar una reparación o solución.");
                return FALSE;
            }
            if (empty($rsnew["fecha_solucion"])) {
                $this->setFailureMessage("Si el estatus es reparación debe indicar la fecha de la misma.");
                return FALSE;
            }
        }

        // Validación de materiales
        if ($rsnew["requiere_materiales"] == "S" && empty(trim($rsnew["materiales"]))) {
            $this->setFailureMessage("Debe indicar los materiales a utilizar.");
            return FALSE;
        }

        // 2. Lógica de flujo y auditoría
        $rsnew["user_solicita"] = CurrentUserName();
        $rsnew["fecha_registro"] = CurrentDateTime(); // Usar formato estándar

        // Si ya trae un diagnóstico al insertar, cambia el estatus automáticamente
        if (!empty(trim($rsnew["diagnostico"]))) {
            $rsnew["estatus"] = "DIAGNOSTICO";
            $rsnew["user_diagnostico"] = CurrentUserName();
            // Podrías añadir aquí: $rsnew["fecha_diagnostico"] = CurrentDateTime();
        }
        return TRUE;
    }
    // Row Inserted event
    public function rowInserted($rsold, $rsnew) {
        // 1. Obtener correos de notificación desde parámetros (Código 035)
        $sqlParam = "SELECT valor1, valor2, valor3, valor4 FROM sco_parametro WHERE codigo = '014'"; 
        // Nota: Verificamos si es 035 o 014 según tu lógica, en tu código pusiste 035
        $rowParam = ExecuteRow("SELECT valor1, valor2, valor3, valor4 FROM sco_parametro WHERE codigo = '035'");
        if (!$rowParam) return; // Si no hay correos configurados, salimos

        // 2. Obtener el nombre real del solicitante (Evitar inyección SQL con QuotedValue)
        $userParam = QuotedValue($rsnew["user_solicita"], DataType::STRING);
        $nombreSolicitante = ExecuteScalar("SELECT nombre FROM sco_user WHERE username = " . $userParam);

        // 3. Preparar variables para el cuerpo del correo
        $ID = $rsnew["Nmttotecnico"];
        $tipo = $rsnew["tipo_solicitud"];
        $unidad = $rsnew["unidad_solicitante"];
        $area = $rsnew["area_falla"];
        $obs = $rsnew["comentario"];
        $prioridad = $rsnew["prioridad"];
        $subject = "Atención Cementerio Del Este - Solicitud Servicio Técnico #: " . $ID;

        // 4. Construir cuerpo HTML elegante
        $notificacion = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
            <h2 style='color: #2c3e50;'>Notificación de Servicio Técnico #$ID</h2>
            <p>Se ha registrado una nueva solicitud en el sistema con los siguientes detalles:</p>
            <table style='width: 100%; border-collapse: collapse;'>
                <tr><td style='padding: 5px; border-bottom: 1px solid #eee;'><b>Solicitante:</b></td><td style='padding: 5px; border-bottom: 1px solid #eee;'>$nombreSolicitante</td></tr>
                <tr><td style='padding: 5px; border-bottom: 1px solid #eee;'><b>Tipo:</b></td><td style='padding: 5px; border-bottom: 1px solid #eee;'>$tipo</td></tr>
                <tr><td style='padding: 5px; border-bottom: 1px solid #eee;'><b>Unidad:</b></td><td style='padding: 5px; border-bottom: 1px solid #eee;'>$unidad</td></tr>
                <tr><td style='padding: 5px; border-bottom: 1px solid #eee;'><b>Área:</b></td><td style='padding: 5px; border-bottom: 1px solid #eee;'>$area</td></tr>
                <tr><td style='padding: 5px; border-bottom: 1px solid #eee;'><b>Prioridad:</b></td><td style='padding: 5px; border-bottom: 1px solid #eee;'><span style='color: red; font-weight: bold;'>$prioridad</span></td></tr>
            </table>
            <p><b>Observaciones:</b><br>" . nl2br(htmlspecialchars($obs)) . "</p>
            <br>
            <img src='http://cementeriodeleste.com.ve/images/samples/logo.png' alt='Logo' width='200'>
            <br>
            <a href='http://cementeriodeleste.com.ve/' style='color: #3498db; text-decoration: none;'>www.cementeriodeleste.com.ve</a>
        </div>";

        // 5. Enviar usando la función centralizada
        // Valor1 es el principal, los demás van en CC
        $cc_mails = array_filter([$rowParam["valor2"], $rowParam["valor3"], $rowParam["valor4"]]);
        EnviarCorreo([
            'to'      => $rowParam["valor1"],
            'cc'      => implode(', ', $cc_mails),
            'subject' => $subject,
            'body'    => $notificacion
        ]);
    }
    // Row Updating event
    public function rowUpdating($rsold, &$rsnew) {
        // 1. Obtener valores actuales (el nuevo si cambió, o el anterior si no se tocó)
        $estatus = $rsnew["estatus"] ?? $rsold["estatus"];
        $diagnostico = $rsnew["diagnostico"] ?? $rsold["diagnostico"];
        $solucion = $rsnew["solucion"] ?? $rsold["solucion"];
        $fecha_solucion = $rsnew["fecha_solucion"] ?? $rsold["fecha_solucion"];
        $requiere_mat = $rsnew["requiere_materiales"] ?? $rsold["requiere_materiales"];
        $materiales = $rsnew["materiales"] ?? $rsold["materiales"];

        // 2. Validaciones de integridad según el flujo técnico

        // Si el estatus es FALLA, el diagnóstico no puede estar vacío
        if ($estatus == "FALLA" && empty(trim($diagnostico))) {
            $this->setFailureMessage("Debe indicar una descripción de la falla en el diagnóstico.");
            return FALSE;
        }

        // Validaciones para el estatus REPARACION
        if ($estatus == "REPARACION") {
            if (empty(trim($solucion))) {
                $this->setFailureMessage("Debe indicar cuál fue la reparación o solución aplicada.");
                return FALSE;
            }
            if (empty($fecha_solucion)) {
                $this->setFailureMessage("Debe indicar la fecha en la que se realizó la reparación.");
                return FALSE;
            }
        }

        // Validación de materiales
        if ($requiere_mat == "S" && empty(trim($materiales))) {
            $this->setFailureMessage("Ha marcado que requiere materiales; por favor especifique cuáles.");
            return FALSE;
        }

        // 3. Lógica de transición de estados automática

        // Si se modificó el diagnóstico, actualizamos el estatus y el usuario responsable
        if (isset($rsnew["diagnostico"]) && $rsnew["diagnostico"] !== $rsold["diagnostico"]) {
            $rsnew["estatus"] = "DIAGNOSTICO";
            $rsnew["user_diagnostico"] = CurrentUserName();
            $rsnew["fecha_diagnostico"] = CurrentDateTime(); // Opcional: registrar cuándo se diagnosticó
        }

        // Si el estatus pasa a REPARACION, registramos quién la finalizó
        if (isset($rsnew["estatus"]) && $rsnew["estatus"] == "REPARACION" && $rsold["estatus"] != "REPARACION") {
            $rsnew["user_repara"] = CurrentUserName(); // Asegúrate que este campo exista en tu tabla
        }

        // Auditoría de modificación general
        $rsnew["fecha_modificacion"] = CurrentDateTime();
        $rsnew["user_modifica"] = CurrentUserName();
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
        if (in_array($this->PageID, ["list", "view", "edit"])) {
            // --- 1. FORMATEO DEL ESTATUS (Mantenemos tu lógica previa) ---
            $statusValue = $this->estatus->CurrentValue;
            $statusColor = "";
            $textColor = "#fff";
            switch($statusValue) {
                case "FALLA": $statusColor = "#dc3545"; break;
                case "DIAGNOSTICO": $statusColor = "#ffc107"; $textColor = "#000"; break;
                case "SUMINISTRO": $statusColor = "#e83e8c"; break;
                case "REPARACION": $statusColor = "#28a745"; break;
                default: $statusColor = "#6c757d"; break;
            }
            if (!empty($statusColor)) {
                $this->estatus->CellAttrs["style"] = "background-color: $statusColor; color: $textColor; font-weight: bold; text-align: center; border-radius: 4px; padding: 4px;";
            }

            // --- 2. FORMATEO DE LA PRIORIDAD (Diseño Elegante Pill) ---
            $prioridadValue = $this->prioridad->CurrentValue;

            // Definimos estilos base: Bordes muy redondeados, sombra leve y padding equilibrado
            $baseStyle = "display: inline-block; padding: 3px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; min-width: 80px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-transform: uppercase;";
            $prioColor = "";
            $prioIcon = "";
            $prioText = "#fff";
            switch($prioridadValue) {
                case "ALTA":
                    $prioColor = "#f8d7da"; // Rojo muy suave de fondo
                    $prioText = "#721c24";  // Rojo oscuro para el texto
                    $border = "1px solid #f5c6cb";
                    $prioIcon = "<i class='fas fa-exclamation-circle mr-1'></i>";
                    break;
                case "MEDIA":
                    $prioColor = "#fff3cd"; // Amarillo suave
                    $prioText = "#856404";  // Dorado oscuro
                    $border = "1px solid #ffeeba";
                    $prioIcon = "<i class='fas fa-layer-group mr-1'></i>";
                    break;
                case "BAJA":
                    $prioColor = "#d4edda"; // Verde suave
                    $prioText = "#155724";  // Verde oscuro
                    $border = "1px solid #c3e6cb";
                    $prioIcon = "<i class='fas fa-arrow-down mr-1'></i>";
                    break;
                default:
                    $prioColor = "#e2e3e5";
                    $prioText = "#383d41";
                    $border = "1px solid #d6d8db";
                    $prioIcon = "";
                    break;
            }
            if (!empty($prioColor)) {
                // Alineamos la celda para que no se pierda el diseño
                $this->prioridad->CellAttrs["style"] = "background-color: $prioColor; color: $prioText; border: $border; text-align: center; vertical-align: middle; white-space: nowrap;";
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
