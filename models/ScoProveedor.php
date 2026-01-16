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
 * Table class for sco_proveedor
 */
class ScoProveedor extends DbTable
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
    public $Nproveedor;
    public $rif;
    public $nombre;
    public $sucursal;
    public $responsable;
    public $telefono1;
    public $telefono2;
    public $telefono3;
    public $telefono4;
    public $fax;
    public $correo;
    public $correo_adicional;
    public $estado;
    public $localidad;
    public $direccion;
    public $observacion;
    public $tipo_proveedor;
    public $activo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_proveedor";
        $this->TableName = 'sco_proveedor';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_proveedor";
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
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // Nproveedor
        $this->Nproveedor = new DbField(
            $this, // Table
            'x_Nproveedor', // Variable name
            'Nproveedor', // Name
            '`Nproveedor`', // Expression
            '`Nproveedor`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nproveedor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nproveedor->InputTextType = "text";
        $this->Nproveedor->Raw = true;
        $this->Nproveedor->IsAutoIncrement = true; // Autoincrement field
        $this->Nproveedor->IsPrimaryKey = true; // Primary key field
        $this->Nproveedor->IsForeignKey = true; // Foreign key field
        $this->Nproveedor->Nullable = false; // NOT NULL field
        $this->Nproveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nproveedor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nproveedor'] = &$this->Nproveedor;

        // rif
        $this->rif = new DbField(
            $this, // Table
            'x_rif', // Variable name
            'rif', // Name
            '`rif`', // Expression
            '`rif`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rif`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->rif->InputTextType = "text";
        $this->rif->Nullable = false; // NOT NULL field
        $this->rif->Required = true; // Required field
        $this->rif->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['rif'] = &$this->rif;

        // nombre
        $this->nombre = new DbField(
            $this, // Table
            'x_nombre', // Variable name
            'nombre', // Name
            '`nombre`', // Expression
            '`nombre`', // Basic search expression
            200, // Type
            100, // Size
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

        // sucursal
        $this->sucursal = new DbField(
            $this, // Table
            'x_sucursal', // Variable name
            'sucursal', // Name
            '`sucursal`', // Expression
            '`sucursal`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`sucursal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->sucursal->InputTextType = "text";
        $this->sucursal->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['sucursal'] = &$this->sucursal;

        // responsable
        $this->responsable = new DbField(
            $this, // Table
            'x_responsable', // Variable name
            'responsable', // Name
            '`responsable`', // Expression
            '`responsable`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`responsable`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->responsable->InputTextType = "text";
        $this->responsable->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['responsable'] = &$this->responsable;

        // telefono1
        $this->telefono1 = new DbField(
            $this, // Table
            'x_telefono1', // Variable name
            'telefono1', // Name
            '`telefono1`', // Expression
            '`telefono1`', // Basic search expression
            200, // Type
            100, // Size
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
            100, // Size
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

        // telefono3
        $this->telefono3 = new DbField(
            $this, // Table
            'x_telefono3', // Variable name
            'telefono3', // Name
            '`telefono3`', // Expression
            '`telefono3`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono3`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono3->InputTextType = "text";
        $this->telefono3->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono3'] = &$this->telefono3;

        // telefono4
        $this->telefono4 = new DbField(
            $this, // Table
            'x_telefono4', // Variable name
            'telefono4', // Name
            '`telefono4`', // Expression
            '`telefono4`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`telefono4`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->telefono4->InputTextType = "text";
        $this->telefono4->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['telefono4'] = &$this->telefono4;

        // fax
        $this->fax = new DbField(
            $this, // Table
            'x_fax', // Variable name
            'fax', // Name
            '`fax`', // Expression
            '`fax`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fax`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fax->InputTextType = "text";
        $this->fax->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['fax'] = &$this->fax;

        // correo
        $this->correo = new DbField(
            $this, // Table
            'x_correo', // Variable name
            'correo', // Name
            '`correo`', // Expression
            '`correo`', // Basic search expression
            200, // Type
            200, // Size
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

        // correo_adicional
        $this->correo_adicional = new DbField(
            $this, // Table
            'x_correo_adicional', // Variable name
            'correo_adicional', // Name
            '`correo_adicional`', // Expression
            '`correo_adicional`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`correo_adicional`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->correo_adicional->InputTextType = "text";
        $this->correo_adicional->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->correo_adicional->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['correo_adicional'] = &$this->correo_adicional;

        // estado
        $this->estado = new DbField(
            $this, // Table
            'x_estado', // Variable name
            'estado', // Name
            '`estado`', // Expression
            '`estado`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->estado->InputTextType = "text";
        $this->estado->Raw = true;
        $this->estado->Nullable = false; // NOT NULL field
        $this->estado->Required = true; // Required field
        $this->estado->setSelectMultiple(false); // Select one
        $this->estado->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estado->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estado->Lookup = new Lookup($this->estado, 'sco_localidad', false, 'Nlocalidad', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->estado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->estado->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['estado'] = &$this->estado;

        // localidad
        $this->localidad = new DbField(
            $this, // Table
            'x_localidad', // Variable name
            'localidad', // Name
            '`localidad`', // Expression
            '`localidad`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`localidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->localidad->InputTextType = "text";
        $this->localidad->Nullable = false; // NOT NULL field
        $this->localidad->Required = true; // Required field
        $this->localidad->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['localidad'] = &$this->localidad;

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
        $this->direccion->Required = true; // Required field
        $this->direccion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['direccion'] = &$this->direccion;

        // observacion
        $this->observacion = new DbField(
            $this, // Table
            'x_observacion', // Variable name
            'observacion', // Name
            '`observacion`', // Expression
            '`observacion`', // Basic search expression
            201, // Type
            16777215, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`observacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->observacion->InputTextType = "text";
        $this->observacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['observacion'] = &$this->observacion;

        // tipo_proveedor
        $this->tipo_proveedor = new DbField(
            $this, // Table
            'x_tipo_proveedor', // Variable name
            'tipo_proveedor', // Name
            '`tipo_proveedor`', // Expression
            '`tipo_proveedor`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_proveedor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo_proveedor->addMethod("getSelectFilter", fn() => "`codigo` = '013'");
        $this->tipo_proveedor->InputTextType = "text";
        $this->tipo_proveedor->Required = true; // Required field
        $this->tipo_proveedor->setSelectMultiple(false); // Select one
        $this->tipo_proveedor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_proveedor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo_proveedor->Lookup = new Lookup($this->tipo_proveedor, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->tipo_proveedor->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo_proveedor'] = &$this->tipo_proveedor;

        // activo
        $this->activo = new DbField(
            $this, // Table
            'x_activo', // Variable name
            'activo', // Name
            '`activo`', // Expression
            '`activo`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`activo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->activo->addMethod("getDefault", fn() => "S");
        $this->activo->InputTextType = "text";
        $this->activo->Raw = true;
        $this->activo->Nullable = false; // NOT NULL field
        $this->activo->Required = true; // Required field
        $this->activo->setSelectMultiple(false); // Select one
        $this->activo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->activo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->activo->Lookup = new Lookup($this->activo, 'sco_proveedor', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->activo->OptionCount = 2;
        $this->activo->SearchOperators = ["=", "<>"];
        $this->Fields['activo'] = &$this->activo;

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
        if ($this->getCurrentDetailTable() == "sco_ofrece_servicio") {
            $detailUrl = Container("sco_ofrece_servicio")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Nproveedor", $this->Nproveedor->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoProveedorList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_proveedor";
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
            $this->Nproveedor->setDbValue($conn->lastInsertId());
            $rs['Nproveedor'] = $this->Nproveedor->DbValue;
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
        // Cascade Update detail table 'sco_ofrece_servicio'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Nproveedor']) && $rsold['Nproveedor'] != $rs['Nproveedor'])) { // Update detail field 'proveedor'
            $cascadeUpdate = true;
            $rscascade['proveedor'] = $rs['Nproveedor'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_ofrece_servicio")->loadRs("`proveedor` = " . QuotedValue($rsold['Nproveedor'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nfrece_servicio';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_ofrece_servicio")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_ofrece_servicio")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_ofrece_servicio")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Nproveedor']) && !EmptyValue($this->Nproveedor->CurrentValue)) {
                $rs['Nproveedor'] = $this->Nproveedor->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nproveedor';
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
            if (array_key_exists('Nproveedor', $rs)) {
                AddFilter($where, QuotedName('Nproveedor', $this->Dbid) . '=' . QuotedValue($rs['Nproveedor'], $this->Nproveedor->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_ofrece_servicio'
        $dtlrows = Container("sco_ofrece_servicio")->loadRs("`proveedor` = " . QuotedValue($rs['Nproveedor'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_ofrece_servicio")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_ofrece_servicio")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_ofrece_servicio")->rowDeleted($dtlrow);
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
        $this->Nproveedor->DbValue = $row['Nproveedor'];
        $this->rif->DbValue = $row['rif'];
        $this->nombre->DbValue = $row['nombre'];
        $this->sucursal->DbValue = $row['sucursal'];
        $this->responsable->DbValue = $row['responsable'];
        $this->telefono1->DbValue = $row['telefono1'];
        $this->telefono2->DbValue = $row['telefono2'];
        $this->telefono3->DbValue = $row['telefono3'];
        $this->telefono4->DbValue = $row['telefono4'];
        $this->fax->DbValue = $row['fax'];
        $this->correo->DbValue = $row['correo'];
        $this->correo_adicional->DbValue = $row['correo_adicional'];
        $this->estado->DbValue = $row['estado'];
        $this->localidad->DbValue = $row['localidad'];
        $this->direccion->DbValue = $row['direccion'];
        $this->observacion->DbValue = $row['observacion'];
        $this->tipo_proveedor->DbValue = $row['tipo_proveedor'];
        $this->activo->DbValue = $row['activo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nproveedor` = @Nproveedor@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nproveedor->CurrentValue : $this->Nproveedor->OldValue;
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
                $this->Nproveedor->CurrentValue = $keys[0];
            } else {
                $this->Nproveedor->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nproveedor', $row) ? $row['Nproveedor'] : null;
        } else {
            $val = !EmptyValue($this->Nproveedor->OldValue) && !$current ? $this->Nproveedor->OldValue : $this->Nproveedor->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nproveedor@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoProveedorList");
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
            "ScoProveedorView" => $Language->phrase("View"),
            "ScoProveedorEdit" => $Language->phrase("Edit"),
            "ScoProveedorAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoProveedorList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoProveedorView",
            Config("API_ADD_ACTION") => "ScoProveedorAdd",
            Config("API_EDIT_ACTION") => "ScoProveedorEdit",
            Config("API_DELETE_ACTION") => "ScoProveedorDelete",
            Config("API_LIST_ACTION") => "ScoProveedorList",
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
        return "ScoProveedorList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoProveedorView", $parm);
        } else {
            $url = $this->keyUrl("ScoProveedorView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoProveedorAdd?" . $parm;
        } else {
            $url = "ScoProveedorAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoProveedorEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoProveedorEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoProveedorList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoProveedorAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoProveedorAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoProveedorList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoProveedorDelete", $parm);
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
        $json .= "\"Nproveedor\":" . VarToJson($this->Nproveedor->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nproveedor->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nproveedor->CurrentValue);
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
            if (($keyValue = Param("Nproveedor") ?? Route("Nproveedor")) !== null) {
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
                $this->Nproveedor->CurrentValue = $key;
            } else {
                $this->Nproveedor->OldValue = $key;
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
        $this->Nproveedor->setDbValue($row['Nproveedor']);
        $this->rif->setDbValue($row['rif']);
        $this->nombre->setDbValue($row['nombre']);
        $this->sucursal->setDbValue($row['sucursal']);
        $this->responsable->setDbValue($row['responsable']);
        $this->telefono1->setDbValue($row['telefono1']);
        $this->telefono2->setDbValue($row['telefono2']);
        $this->telefono3->setDbValue($row['telefono3']);
        $this->telefono4->setDbValue($row['telefono4']);
        $this->fax->setDbValue($row['fax']);
        $this->correo->setDbValue($row['correo']);
        $this->correo_adicional->setDbValue($row['correo_adicional']);
        $this->estado->setDbValue($row['estado']);
        $this->localidad->setDbValue($row['localidad']);
        $this->direccion->setDbValue($row['direccion']);
        $this->observacion->setDbValue($row['observacion']);
        $this->tipo_proveedor->setDbValue($row['tipo_proveedor']);
        $this->activo->setDbValue($row['activo']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoProveedorList";
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

        // Nproveedor

        // rif

        // nombre

        // sucursal

        // responsable

        // telefono1

        // telefono2

        // telefono3

        // telefono4

        // fax

        // correo

        // correo_adicional

        // estado

        // localidad

        // direccion

        // observacion

        // tipo_proveedor

        // activo

        // Nproveedor
        $this->Nproveedor->ViewValue = $this->Nproveedor->CurrentValue;

        // rif
        $this->rif->ViewValue = $this->rif->CurrentValue;

        // nombre
        $this->nombre->ViewValue = $this->nombre->CurrentValue;

        // sucursal
        $this->sucursal->ViewValue = $this->sucursal->CurrentValue;

        // responsable
        $this->responsable->ViewValue = $this->responsable->CurrentValue;

        // telefono1
        $this->telefono1->ViewValue = $this->telefono1->CurrentValue;

        // telefono2
        $this->telefono2->ViewValue = $this->telefono2->CurrentValue;

        // telefono3
        $this->telefono3->ViewValue = $this->telefono3->CurrentValue;

        // telefono4
        $this->telefono4->ViewValue = $this->telefono4->CurrentValue;

        // fax
        $this->fax->ViewValue = $this->fax->CurrentValue;

        // correo
        $this->correo->ViewValue = $this->correo->CurrentValue;

        // correo_adicional
        $this->correo_adicional->ViewValue = $this->correo_adicional->CurrentValue;

        // estado
        $curVal = strval($this->estado->CurrentValue);
        if ($curVal != "") {
            $this->estado->ViewValue = $this->estado->lookupCacheOption($curVal);
            if ($this->estado->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->estado->Lookup->getTable()->Fields["Nlocalidad"]->searchExpression(), "=", $curVal, $this->estado->Lookup->getTable()->Fields["Nlocalidad"]->searchDataType(), "");
                $sqlWrk = $this->estado->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->estado->Lookup->renderViewRow($rswrk[0]);
                    $this->estado->ViewValue = $this->estado->displayValue($arwrk);
                } else {
                    $this->estado->ViewValue = $this->estado->CurrentValue;
                }
            }
        } else {
            $this->estado->ViewValue = null;
        }

        // localidad
        $this->localidad->ViewValue = $this->localidad->CurrentValue;

        // direccion
        $this->direccion->ViewValue = $this->direccion->CurrentValue;

        // observacion
        $this->observacion->ViewValue = $this->observacion->CurrentValue;

        // tipo_proveedor
        $curVal = strval($this->tipo_proveedor->CurrentValue);
        if ($curVal != "") {
            $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->lookupCacheOption($curVal);
            if ($this->tipo_proveedor->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_proveedor->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_proveedor->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->tipo_proveedor->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_proveedor->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_proveedor->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->displayValue($arwrk);
                } else {
                    $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->CurrentValue;
                }
            }
        } else {
            $this->tipo_proveedor->ViewValue = null;
        }

        // activo
        if (strval($this->activo->CurrentValue) != "") {
            $this->activo->ViewValue = $this->activo->optionCaption($this->activo->CurrentValue);
        } else {
            $this->activo->ViewValue = null;
        }

        // Nproveedor
        $this->Nproveedor->HrefValue = "";
        $this->Nproveedor->TooltipValue = "";

        // rif
        $this->rif->HrefValue = "";
        $this->rif->TooltipValue = "";

        // nombre
        $this->nombre->HrefValue = "";
        $this->nombre->TooltipValue = "";

        // sucursal
        $this->sucursal->HrefValue = "";
        $this->sucursal->TooltipValue = "";

        // responsable
        $this->responsable->HrefValue = "";
        $this->responsable->TooltipValue = "";

        // telefono1
        $this->telefono1->HrefValue = "";
        $this->telefono1->TooltipValue = "";

        // telefono2
        $this->telefono2->HrefValue = "";
        $this->telefono2->TooltipValue = "";

        // telefono3
        $this->telefono3->HrefValue = "";
        $this->telefono3->TooltipValue = "";

        // telefono4
        $this->telefono4->HrefValue = "";
        $this->telefono4->TooltipValue = "";

        // fax
        $this->fax->HrefValue = "";
        $this->fax->TooltipValue = "";

        // correo
        $this->correo->HrefValue = "";
        $this->correo->TooltipValue = "";

        // correo_adicional
        $this->correo_adicional->HrefValue = "";
        $this->correo_adicional->TooltipValue = "";

        // estado
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // localidad
        $this->localidad->HrefValue = "";
        $this->localidad->TooltipValue = "";

        // direccion
        $this->direccion->HrefValue = "";
        $this->direccion->TooltipValue = "";

        // observacion
        $this->observacion->HrefValue = "";
        $this->observacion->TooltipValue = "";

        // tipo_proveedor
        $this->tipo_proveedor->HrefValue = "";
        $this->tipo_proveedor->TooltipValue = "";

        // activo
        $this->activo->HrefValue = "";
        $this->activo->TooltipValue = "";

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

        // Nproveedor
        $this->Nproveedor->setupEditAttributes();
        $this->Nproveedor->EditValue = $this->Nproveedor->CurrentValue;

        // rif
        $this->rif->setupEditAttributes();
        if (!$this->rif->Raw) {
            $this->rif->CurrentValue = HtmlDecode($this->rif->CurrentValue);
        }
        $this->rif->EditValue = $this->rif->CurrentValue;
        $this->rif->PlaceHolder = RemoveHtml($this->rif->caption());

        // nombre
        $this->nombre->setupEditAttributes();
        if (!$this->nombre->Raw) {
            $this->nombre->CurrentValue = HtmlDecode($this->nombre->CurrentValue);
        }
        $this->nombre->EditValue = $this->nombre->CurrentValue;
        $this->nombre->PlaceHolder = RemoveHtml($this->nombre->caption());

        // sucursal
        $this->sucursal->setupEditAttributes();
        if (!$this->sucursal->Raw) {
            $this->sucursal->CurrentValue = HtmlDecode($this->sucursal->CurrentValue);
        }
        $this->sucursal->EditValue = $this->sucursal->CurrentValue;
        $this->sucursal->PlaceHolder = RemoveHtml($this->sucursal->caption());

        // responsable
        $this->responsable->setupEditAttributes();
        if (!$this->responsable->Raw) {
            $this->responsable->CurrentValue = HtmlDecode($this->responsable->CurrentValue);
        }
        $this->responsable->EditValue = $this->responsable->CurrentValue;
        $this->responsable->PlaceHolder = RemoveHtml($this->responsable->caption());

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

        // telefono3
        $this->telefono3->setupEditAttributes();
        if (!$this->telefono3->Raw) {
            $this->telefono3->CurrentValue = HtmlDecode($this->telefono3->CurrentValue);
        }
        $this->telefono3->EditValue = $this->telefono3->CurrentValue;
        $this->telefono3->PlaceHolder = RemoveHtml($this->telefono3->caption());

        // telefono4
        $this->telefono4->setupEditAttributes();
        if (!$this->telefono4->Raw) {
            $this->telefono4->CurrentValue = HtmlDecode($this->telefono4->CurrentValue);
        }
        $this->telefono4->EditValue = $this->telefono4->CurrentValue;
        $this->telefono4->PlaceHolder = RemoveHtml($this->telefono4->caption());

        // fax
        $this->fax->setupEditAttributes();
        if (!$this->fax->Raw) {
            $this->fax->CurrentValue = HtmlDecode($this->fax->CurrentValue);
        }
        $this->fax->EditValue = $this->fax->CurrentValue;
        $this->fax->PlaceHolder = RemoveHtml($this->fax->caption());

        // correo
        $this->correo->setupEditAttributes();
        if (!$this->correo->Raw) {
            $this->correo->CurrentValue = HtmlDecode($this->correo->CurrentValue);
        }
        $this->correo->EditValue = $this->correo->CurrentValue;
        $this->correo->PlaceHolder = RemoveHtml($this->correo->caption());

        // correo_adicional
        $this->correo_adicional->setupEditAttributes();
        if (!$this->correo_adicional->Raw) {
            $this->correo_adicional->CurrentValue = HtmlDecode($this->correo_adicional->CurrentValue);
        }
        $this->correo_adicional->EditValue = $this->correo_adicional->CurrentValue;
        $this->correo_adicional->PlaceHolder = RemoveHtml($this->correo_adicional->caption());

        // estado
        $this->estado->setupEditAttributes();
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // localidad
        $this->localidad->setupEditAttributes();
        if (!$this->localidad->Raw) {
            $this->localidad->CurrentValue = HtmlDecode($this->localidad->CurrentValue);
        }
        $this->localidad->EditValue = $this->localidad->CurrentValue;
        $this->localidad->PlaceHolder = RemoveHtml($this->localidad->caption());

        // direccion
        $this->direccion->setupEditAttributes();
        $this->direccion->EditValue = $this->direccion->CurrentValue;
        $this->direccion->PlaceHolder = RemoveHtml($this->direccion->caption());

        // observacion
        $this->observacion->setupEditAttributes();
        $this->observacion->EditValue = $this->observacion->CurrentValue;
        $this->observacion->PlaceHolder = RemoveHtml($this->observacion->caption());

        // tipo_proveedor
        $this->tipo_proveedor->setupEditAttributes();
        $this->tipo_proveedor->PlaceHolder = RemoveHtml($this->tipo_proveedor->caption());

        // activo
        $this->activo->setupEditAttributes();
        $this->activo->EditValue = $this->activo->options(true);
        $this->activo->PlaceHolder = RemoveHtml($this->activo->caption());

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
                    $doc->exportCaption($this->Nproveedor);
                    $doc->exportCaption($this->rif);
                    $doc->exportCaption($this->nombre);
                    $doc->exportCaption($this->sucursal);
                    $doc->exportCaption($this->responsable);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->telefono3);
                    $doc->exportCaption($this->telefono4);
                    $doc->exportCaption($this->fax);
                    $doc->exportCaption($this->correo);
                    $doc->exportCaption($this->correo_adicional);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->localidad);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->observacion);
                    $doc->exportCaption($this->tipo_proveedor);
                } else {
                    $doc->exportCaption($this->Nproveedor);
                    $doc->exportCaption($this->rif);
                    $doc->exportCaption($this->nombre);
                    $doc->exportCaption($this->sucursal);
                    $doc->exportCaption($this->responsable);
                    $doc->exportCaption($this->telefono1);
                    $doc->exportCaption($this->telefono2);
                    $doc->exportCaption($this->telefono3);
                    $doc->exportCaption($this->telefono4);
                    $doc->exportCaption($this->fax);
                    $doc->exportCaption($this->correo);
                    $doc->exportCaption($this->correo_adicional);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->localidad);
                    $doc->exportCaption($this->direccion);
                    $doc->exportCaption($this->tipo_proveedor);
                    $doc->exportCaption($this->activo);
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
                        $doc->exportField($this->Nproveedor);
                        $doc->exportField($this->rif);
                        $doc->exportField($this->nombre);
                        $doc->exportField($this->sucursal);
                        $doc->exportField($this->responsable);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->telefono3);
                        $doc->exportField($this->telefono4);
                        $doc->exportField($this->fax);
                        $doc->exportField($this->correo);
                        $doc->exportField($this->correo_adicional);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->localidad);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->observacion);
                        $doc->exportField($this->tipo_proveedor);
                    } else {
                        $doc->exportField($this->Nproveedor);
                        $doc->exportField($this->rif);
                        $doc->exportField($this->nombre);
                        $doc->exportField($this->sucursal);
                        $doc->exportField($this->responsable);
                        $doc->exportField($this->telefono1);
                        $doc->exportField($this->telefono2);
                        $doc->exportField($this->telefono3);
                        $doc->exportField($this->telefono4);
                        $doc->exportField($this->fax);
                        $doc->exportField($this->correo);
                        $doc->exportField($this->correo_adicional);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->localidad);
                        $doc->exportField($this->direccion);
                        $doc->exportField($this->tipo_proveedor);
                        $doc->exportField($this->activo);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_proveedor');
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
        $key .= $rs['Nproveedor'];

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
                WriteAuditLog($usr, "A", 'sco_proveedor', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nproveedor'];

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
                    WriteAuditLog($usr, "U", 'sco_proveedor', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nproveedor'];

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
                WriteAuditLog($usr, "D", 'sco_proveedor', $fldname, $key, $oldvalue);
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
    	$sql = "select count(*) as total from sco_proveedor where rif = '".$rsnew["rif"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "El RIF: ".$rsnew["rif"]." ya se encuentra registrado, no se puede agregar el nuevo registro.";
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
    	$sql = "select count(*) as total from sco_proveedor where rif = '".$rsnew["rif"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>1)
    	{
    		$this->CancelMessage = "El RIF: ".$rsnew["rif"]." ya se encuentra registrado, no se puede actualizar el registro.";
    		return FALSE;
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
    	$sql = "select count(*) as total from sco_orden where proveedor = '".$rs["Nproveedor"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay ordenes asociadas a este proveedor, no se puede eliminar.";
    		return FALSE;
    	}
    	$sql = "select count(*) as total from sco_entrada_salida where proveedor = '".$rs["Nproveedor"]."';";
    	$total = ExecuteScalar($sql);
    	if($total>0)
    	{
    		$this->CancelMessage = "Hay Entradas y/o salidas asociadas a este proveedor, no se puede eliminar.";
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
