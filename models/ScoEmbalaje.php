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
 * Table class for sco_embalaje
 */
class ScoEmbalaje extends DbTable
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
    public $Nembalaje;
    public $expediente;
    public $fecha;
    public $precinto1;
    public $precinto2;
    public $nombre_familiar;
    public $cedula_familiar;
    public $certificado_defuncion;
    public $fecha_servicio;
    public $doctor;
    public $doctor_nro;
    public $cremacion_nro;
    public $registro_civil;
    public $dimension_cofre;
    public $nota;
    public $_username;
    public $anulado;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_embalaje";
        $this->TableName = 'sco_embalaje';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_embalaje";
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

        // Nembalaje
        $this->Nembalaje = new DbField(
            $this, // Table
            'x_Nembalaje', // Variable name
            'Nembalaje', // Name
            '`Nembalaje`', // Expression
            '`Nembalaje`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nembalaje`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nembalaje->InputTextType = "text";
        $this->Nembalaje->Raw = true;
        $this->Nembalaje->IsAutoIncrement = true; // Autoincrement field
        $this->Nembalaje->IsPrimaryKey = true; // Primary key field
        $this->Nembalaje->Nullable = false; // NOT NULL field
        $this->Nembalaje->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nembalaje->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nembalaje'] = &$this->Nembalaje;

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
        $this->expediente->InputTextType = "text";
        $this->expediente->Raw = true;
        $this->expediente->IsForeignKey = true; // Foreign key field
        $this->expediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->expediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['expediente'] = &$this->expediente;

        // fecha
        $this->fecha = new DbField(
            $this, // Table
            'x_fecha', // Variable name
            'fecha', // Name
            '`fecha`', // Expression
            CastDateFieldForLike("`fecha`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha->InputTextType = "text";
        $this->fecha->Raw = true;
        $this->fecha->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha'] = &$this->fecha;

        // precinto1
        $this->precinto1 = new DbField(
            $this, // Table
            'x_precinto1', // Variable name
            'precinto1', // Name
            '`precinto1`', // Expression
            '`precinto1`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`precinto1`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->precinto1->InputTextType = "text";
        $this->precinto1->Required = true; // Required field
        $this->precinto1->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['precinto1'] = &$this->precinto1;

        // precinto2
        $this->precinto2 = new DbField(
            $this, // Table
            'x_precinto2', // Variable name
            'precinto2', // Name
            '`precinto2`', // Expression
            '`precinto2`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`precinto2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->precinto2->InputTextType = "text";
        $this->precinto2->Required = true; // Required field
        $this->precinto2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['precinto2'] = &$this->precinto2;

        // nombre_familiar
        $this->nombre_familiar = new DbField(
            $this, // Table
            'x_nombre_familiar', // Variable name
            'nombre_familiar', // Name
            '`nombre_familiar`', // Expression
            '`nombre_familiar`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_familiar`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_familiar->InputTextType = "text";
        $this->nombre_familiar->Required = true; // Required field
        $this->nombre_familiar->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_familiar'] = &$this->nombre_familiar;

        // cedula_familiar
        $this->cedula_familiar = new DbField(
            $this, // Table
            'x_cedula_familiar', // Variable name
            'cedula_familiar', // Name
            '`cedula_familiar`', // Expression
            '`cedula_familiar`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula_familiar`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula_familiar->InputTextType = "text";
        $this->cedula_familiar->Required = true; // Required field
        $this->cedula_familiar->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula_familiar'] = &$this->cedula_familiar;

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
        $this->certificado_defuncion->Required = true; // Required field
        $this->certificado_defuncion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['certificado_defuncion'] = &$this->certificado_defuncion;

        // fecha_servicio
        $this->fecha_servicio = new DbField(
            $this, // Table
            'x_fecha_servicio', // Variable name
            'fecha_servicio', // Name
            '`fecha_servicio`', // Expression
            CastDateFieldForLike("`fecha_servicio`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_servicio->InputTextType = "text";
        $this->fecha_servicio->Raw = true;
        $this->fecha_servicio->Required = true; // Required field
        $this->fecha_servicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_servicio'] = &$this->fecha_servicio;

        // doctor
        $this->doctor = new DbField(
            $this, // Table
            'x_doctor', // Variable name
            'doctor', // Name
            '`doctor`', // Expression
            '`doctor`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`doctor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->doctor->InputTextType = "text";
        $this->doctor->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['doctor'] = &$this->doctor;

        // doctor_nro
        $this->doctor_nro = new DbField(
            $this, // Table
            'x_doctor_nro', // Variable name
            'doctor_nro', // Name
            '`doctor_nro`', // Expression
            '`doctor_nro`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`doctor_nro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->doctor_nro->InputTextType = "text";
        $this->doctor_nro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['doctor_nro'] = &$this->doctor_nro;

        // cremacion_nro
        $this->cremacion_nro = new DbField(
            $this, // Table
            'x_cremacion_nro', // Variable name
            'cremacion_nro', // Name
            '`cremacion_nro`', // Expression
            '`cremacion_nro`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cremacion_nro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cremacion_nro->InputTextType = "text";
        $this->cremacion_nro->Required = true; // Required field
        $this->cremacion_nro->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cremacion_nro'] = &$this->cremacion_nro;

        // registro_civil
        $this->registro_civil = new DbField(
            $this, // Table
            'x_registro_civil', // Variable name
            'registro_civil', // Name
            '`registro_civil`', // Expression
            '`registro_civil`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`registro_civil`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->registro_civil->InputTextType = "text";
        $this->registro_civil->Required = true; // Required field
        $this->registro_civil->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['registro_civil'] = &$this->registro_civil;

        // dimension_cofre
        $this->dimension_cofre = new DbField(
            $this, // Table
            'x_dimension_cofre', // Variable name
            'dimension_cofre', // Name
            '`dimension_cofre`', // Expression
            '`dimension_cofre`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`dimension_cofre`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->dimension_cofre->InputTextType = "text";
        $this->dimension_cofre->Required = true; // Required field
        $this->dimension_cofre->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['dimension_cofre'] = &$this->dimension_cofre;

        // nota
        $this->nota = new DbField(
            $this, // Table
            'x_nota', // Variable name
            'nota', // Name
            '`nota`', // Expression
            '`nota`', // Basic search expression
            200, // Type
            50, // Size
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

        // username
        $this->_username = new DbField(
            $this, // Table
            'x__username', // Variable name
            'username', // Name
            '`username`', // Expression
            '`username`', // Basic search expression
            200, // Type
            30, // Size
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
        $this->_username->Lookup = new Lookup($this->_username, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nombre`");
        $this->_username->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['username'] = &$this->_username;

        // anulado
        $this->anulado = new DbField(
            $this, // Table
            'x_anulado', // Variable name
            'anulado', // Name
            '`anulado`', // Expression
            '`anulado`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`anulado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->anulado->addMethod("getDefault", fn() => "N");
        $this->anulado->InputTextType = "text";
        $this->anulado->Raw = true;
        $this->anulado->Required = true; // Required field
        $this->anulado->setSelectMultiple(false); // Select one
        $this->anulado->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->anulado->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->anulado->Lookup = new Lookup($this->anulado, 'sco_embalaje', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->anulado->OptionCount = 2;
        $this->anulado->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['anulado'] = &$this->anulado;

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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "sco_expediente") {
            $masterTable = Container("sco_expediente");
            if ($this->expediente->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->Nexpediente, $this->expediente->getSessionValue(), $masterTable->Nexpediente->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "sco_expediente") {
            $masterTable = Container("sco_expediente");
            if ($this->expediente->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->expediente, $this->expediente->getSessionValue(), $masterTable->Nexpediente->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "sco_expediente":
                $key = $keys["expediente"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->Nexpediente->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->Nexpediente, $keys["expediente"], $this->expediente->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "sco_expediente":
                return GetKeyFilter($this->expediente, $masterTable->Nexpediente->DbValue, $masterTable->Nexpediente->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Get FROM clause
    public function getSqlFrom()
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_embalaje";
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
            $this->Nembalaje->setDbValue($conn->lastInsertId());
            $rs['Nembalaje'] = $this->Nembalaje->DbValue;
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
            if (!isset($rs['Nembalaje']) && !EmptyValue($this->Nembalaje->CurrentValue)) {
                $rs['Nembalaje'] = $this->Nembalaje->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nembalaje';
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
            if (array_key_exists('Nembalaje', $rs)) {
                AddFilter($where, QuotedName('Nembalaje', $this->Dbid) . '=' . QuotedValue($rs['Nembalaje'], $this->Nembalaje->DataType, $this->Dbid));
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
        $this->Nembalaje->DbValue = $row['Nembalaje'];
        $this->expediente->DbValue = $row['expediente'];
        $this->fecha->DbValue = $row['fecha'];
        $this->precinto1->DbValue = $row['precinto1'];
        $this->precinto2->DbValue = $row['precinto2'];
        $this->nombre_familiar->DbValue = $row['nombre_familiar'];
        $this->cedula_familiar->DbValue = $row['cedula_familiar'];
        $this->certificado_defuncion->DbValue = $row['certificado_defuncion'];
        $this->fecha_servicio->DbValue = $row['fecha_servicio'];
        $this->doctor->DbValue = $row['doctor'];
        $this->doctor_nro->DbValue = $row['doctor_nro'];
        $this->cremacion_nro->DbValue = $row['cremacion_nro'];
        $this->registro_civil->DbValue = $row['registro_civil'];
        $this->dimension_cofre->DbValue = $row['dimension_cofre'];
        $this->nota->DbValue = $row['nota'];
        $this->_username->DbValue = $row['username'];
        $this->anulado->DbValue = $row['anulado'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nembalaje` = @Nembalaje@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nembalaje->CurrentValue : $this->Nembalaje->OldValue;
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
                $this->Nembalaje->CurrentValue = $keys[0];
            } else {
                $this->Nembalaje->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nembalaje', $row) ? $row['Nembalaje'] : null;
        } else {
            $val = !EmptyValue($this->Nembalaje->OldValue) && !$current ? $this->Nembalaje->OldValue : $this->Nembalaje->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nembalaje@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoEmbalajeList");
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
            "ScoEmbalajeView" => $Language->phrase("View"),
            "ScoEmbalajeEdit" => $Language->phrase("Edit"),
            "ScoEmbalajeAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoEmbalajeList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoEmbalajeView",
            Config("API_ADD_ACTION") => "ScoEmbalajeAdd",
            Config("API_EDIT_ACTION") => "ScoEmbalajeEdit",
            Config("API_DELETE_ACTION") => "ScoEmbalajeDelete",
            Config("API_LIST_ACTION") => "ScoEmbalajeList",
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
        return "ScoEmbalajeList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoEmbalajeView", $parm);
        } else {
            $url = $this->keyUrl("ScoEmbalajeView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoEmbalajeAdd?" . $parm;
        } else {
            $url = "ScoEmbalajeAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoEmbalajeEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoEmbalajeList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoEmbalajeAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoEmbalajeList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoEmbalajeDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "sco_expediente" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_Nexpediente", $this->expediente->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Nembalaje\":" . VarToJson($this->Nembalaje->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nembalaje->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nembalaje->CurrentValue);
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
            if (($keyValue = Param("Nembalaje") ?? Route("Nembalaje")) !== null) {
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
                $this->Nembalaje->CurrentValue = $key;
            } else {
                $this->Nembalaje->OldValue = $key;
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
        $this->Nembalaje->setDbValue($row['Nembalaje']);
        $this->expediente->setDbValue($row['expediente']);
        $this->fecha->setDbValue($row['fecha']);
        $this->precinto1->setDbValue($row['precinto1']);
        $this->precinto2->setDbValue($row['precinto2']);
        $this->nombre_familiar->setDbValue($row['nombre_familiar']);
        $this->cedula_familiar->setDbValue($row['cedula_familiar']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->fecha_servicio->setDbValue($row['fecha_servicio']);
        $this->doctor->setDbValue($row['doctor']);
        $this->doctor_nro->setDbValue($row['doctor_nro']);
        $this->cremacion_nro->setDbValue($row['cremacion_nro']);
        $this->registro_civil->setDbValue($row['registro_civil']);
        $this->dimension_cofre->setDbValue($row['dimension_cofre']);
        $this->nota->setDbValue($row['nota']);
        $this->_username->setDbValue($row['username']);
        $this->anulado->setDbValue($row['anulado']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoEmbalajeList";
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

        // Nembalaje

        // expediente

        // fecha

        // precinto1

        // precinto2

        // nombre_familiar

        // cedula_familiar

        // certificado_defuncion

        // fecha_servicio

        // doctor

        // doctor_nro

        // cremacion_nro

        // registro_civil

        // dimension_cofre

        // nota

        // username

        // anulado

        // Nembalaje
        $this->Nembalaje->ViewValue = $this->Nembalaje->CurrentValue;

        // expediente
        $this->expediente->ViewValue = $this->expediente->CurrentValue;

        // fecha
        $this->fecha->ViewValue = $this->fecha->CurrentValue;
        $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

        // precinto1
        $this->precinto1->ViewValue = $this->precinto1->CurrentValue;

        // precinto2
        $this->precinto2->ViewValue = $this->precinto2->CurrentValue;

        // nombre_familiar
        $this->nombre_familiar->ViewValue = $this->nombre_familiar->CurrentValue;

        // cedula_familiar
        $this->cedula_familiar->ViewValue = $this->cedula_familiar->CurrentValue;

        // certificado_defuncion
        $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

        // fecha_servicio
        $this->fecha_servicio->ViewValue = $this->fecha_servicio->CurrentValue;
        $this->fecha_servicio->ViewValue = FormatDateTime($this->fecha_servicio->ViewValue, $this->fecha_servicio->formatPattern());

        // doctor
        $this->doctor->ViewValue = $this->doctor->CurrentValue;

        // doctor_nro
        $this->doctor_nro->ViewValue = $this->doctor_nro->CurrentValue;

        // cremacion_nro
        $this->cremacion_nro->ViewValue = $this->cremacion_nro->CurrentValue;

        // registro_civil
        $this->registro_civil->ViewValue = $this->registro_civil->CurrentValue;

        // dimension_cofre
        $this->dimension_cofre->ViewValue = $this->dimension_cofre->CurrentValue;

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // username
        $this->_username->ViewValue = $this->_username->CurrentValue;
        $curVal = strval($this->_username->CurrentValue);
        if ($curVal != "") {
            $this->_username->ViewValue = $this->_username->lookupCacheOption($curVal);
            if ($this->_username->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->_username->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->_username->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->_username->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->_username->Lookup->renderViewRow($rswrk[0]);
                    $this->_username->ViewValue = $this->_username->displayValue($arwrk);
                } else {
                    $this->_username->ViewValue = $this->_username->CurrentValue;
                }
            }
        } else {
            $this->_username->ViewValue = null;
        }

        // anulado
        if (strval($this->anulado->CurrentValue) != "") {
            $this->anulado->ViewValue = $this->anulado->optionCaption($this->anulado->CurrentValue);
        } else {
            $this->anulado->ViewValue = null;
        }

        // Nembalaje
        $this->Nembalaje->HrefValue = "";
        $this->Nembalaje->TooltipValue = "";

        // expediente
        $this->expediente->HrefValue = "";
        $this->expediente->TooltipValue = "";

        // fecha
        $this->fecha->HrefValue = "";
        $this->fecha->TooltipValue = "";

        // precinto1
        $this->precinto1->HrefValue = "";
        $this->precinto1->TooltipValue = "";

        // precinto2
        $this->precinto2->HrefValue = "";
        $this->precinto2->TooltipValue = "";

        // nombre_familiar
        $this->nombre_familiar->HrefValue = "";
        $this->nombre_familiar->TooltipValue = "";

        // cedula_familiar
        $this->cedula_familiar->HrefValue = "";
        $this->cedula_familiar->TooltipValue = "";

        // certificado_defuncion
        $this->certificado_defuncion->HrefValue = "";
        $this->certificado_defuncion->TooltipValue = "";

        // fecha_servicio
        $this->fecha_servicio->HrefValue = "";
        $this->fecha_servicio->TooltipValue = "";

        // doctor
        $this->doctor->HrefValue = "";
        $this->doctor->TooltipValue = "";

        // doctor_nro
        $this->doctor_nro->HrefValue = "";
        $this->doctor_nro->TooltipValue = "";

        // cremacion_nro
        $this->cremacion_nro->HrefValue = "";
        $this->cremacion_nro->TooltipValue = "";

        // registro_civil
        $this->registro_civil->HrefValue = "";
        $this->registro_civil->TooltipValue = "";

        // dimension_cofre
        $this->dimension_cofre->HrefValue = "";
        $this->dimension_cofre->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // username
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // anulado
        $this->anulado->HrefValue = "";
        $this->anulado->TooltipValue = "";

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

        // Nembalaje
        $this->Nembalaje->setupEditAttributes();
        $this->Nembalaje->EditValue = $this->Nembalaje->CurrentValue;

        // expediente
        $this->expediente->setupEditAttributes();
        if ($this->expediente->getSessionValue() != "") {
            $this->expediente->CurrentValue = GetForeignKeyValue($this->expediente->getSessionValue());
            $this->expediente->ViewValue = $this->expediente->CurrentValue;
        } else {
            $this->expediente->EditValue = $this->expediente->CurrentValue;
            $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());
            if (strval($this->expediente->EditValue) != "" && is_numeric($this->expediente->EditValue)) {
                $this->expediente->EditValue = $this->expediente->EditValue;
            }
        }

        // fecha
        $this->fecha->setupEditAttributes();
        $this->fecha->EditValue = FormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
        $this->fecha->PlaceHolder = RemoveHtml($this->fecha->caption());

        // precinto1
        $this->precinto1->setupEditAttributes();
        if (!$this->precinto1->Raw) {
            $this->precinto1->CurrentValue = HtmlDecode($this->precinto1->CurrentValue);
        }
        $this->precinto1->EditValue = $this->precinto1->CurrentValue;
        $this->precinto1->PlaceHolder = RemoveHtml($this->precinto1->caption());

        // precinto2
        $this->precinto2->setupEditAttributes();
        if (!$this->precinto2->Raw) {
            $this->precinto2->CurrentValue = HtmlDecode($this->precinto2->CurrentValue);
        }
        $this->precinto2->EditValue = $this->precinto2->CurrentValue;
        $this->precinto2->PlaceHolder = RemoveHtml($this->precinto2->caption());

        // nombre_familiar
        $this->nombre_familiar->setupEditAttributes();
        if (!$this->nombre_familiar->Raw) {
            $this->nombre_familiar->CurrentValue = HtmlDecode($this->nombre_familiar->CurrentValue);
        }
        $this->nombre_familiar->EditValue = $this->nombre_familiar->CurrentValue;
        $this->nombre_familiar->PlaceHolder = RemoveHtml($this->nombre_familiar->caption());

        // cedula_familiar
        $this->cedula_familiar->setupEditAttributes();
        if (!$this->cedula_familiar->Raw) {
            $this->cedula_familiar->CurrentValue = HtmlDecode($this->cedula_familiar->CurrentValue);
        }
        $this->cedula_familiar->EditValue = $this->cedula_familiar->CurrentValue;
        $this->cedula_familiar->PlaceHolder = RemoveHtml($this->cedula_familiar->caption());

        // certificado_defuncion
        $this->certificado_defuncion->setupEditAttributes();
        if (!$this->certificado_defuncion->Raw) {
            $this->certificado_defuncion->CurrentValue = HtmlDecode($this->certificado_defuncion->CurrentValue);
        }
        $this->certificado_defuncion->EditValue = $this->certificado_defuncion->CurrentValue;
        $this->certificado_defuncion->PlaceHolder = RemoveHtml($this->certificado_defuncion->caption());

        // fecha_servicio
        $this->fecha_servicio->setupEditAttributes();
        $this->fecha_servicio->EditValue = FormatDateTime($this->fecha_servicio->CurrentValue, $this->fecha_servicio->formatPattern());
        $this->fecha_servicio->PlaceHolder = RemoveHtml($this->fecha_servicio->caption());

        // doctor
        $this->doctor->setupEditAttributes();
        if (!$this->doctor->Raw) {
            $this->doctor->CurrentValue = HtmlDecode($this->doctor->CurrentValue);
        }
        $this->doctor->EditValue = $this->doctor->CurrentValue;
        $this->doctor->PlaceHolder = RemoveHtml($this->doctor->caption());

        // doctor_nro
        $this->doctor_nro->setupEditAttributes();
        if (!$this->doctor_nro->Raw) {
            $this->doctor_nro->CurrentValue = HtmlDecode($this->doctor_nro->CurrentValue);
        }
        $this->doctor_nro->EditValue = $this->doctor_nro->CurrentValue;
        $this->doctor_nro->PlaceHolder = RemoveHtml($this->doctor_nro->caption());

        // cremacion_nro
        $this->cremacion_nro->setupEditAttributes();
        if (!$this->cremacion_nro->Raw) {
            $this->cremacion_nro->CurrentValue = HtmlDecode($this->cremacion_nro->CurrentValue);
        }
        $this->cremacion_nro->EditValue = $this->cremacion_nro->CurrentValue;
        $this->cremacion_nro->PlaceHolder = RemoveHtml($this->cremacion_nro->caption());

        // registro_civil
        $this->registro_civil->setupEditAttributes();
        if (!$this->registro_civil->Raw) {
            $this->registro_civil->CurrentValue = HtmlDecode($this->registro_civil->CurrentValue);
        }
        $this->registro_civil->EditValue = $this->registro_civil->CurrentValue;
        $this->registro_civil->PlaceHolder = RemoveHtml($this->registro_civil->caption());

        // dimension_cofre
        $this->dimension_cofre->setupEditAttributes();
        if (!$this->dimension_cofre->Raw) {
            $this->dimension_cofre->CurrentValue = HtmlDecode($this->dimension_cofre->CurrentValue);
        }
        $this->dimension_cofre->EditValue = $this->dimension_cofre->CurrentValue;
        $this->dimension_cofre->PlaceHolder = RemoveHtml($this->dimension_cofre->caption());

        // nota
        $this->nota->setupEditAttributes();
        if (!$this->nota->Raw) {
            $this->nota->CurrentValue = HtmlDecode($this->nota->CurrentValue);
        }
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // username
        $this->_username->setupEditAttributes();
        if (!$this->_username->Raw) {
            $this->_username->CurrentValue = HtmlDecode($this->_username->CurrentValue);
        }
        $this->_username->EditValue = $this->_username->CurrentValue;
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // anulado
        $this->anulado->setupEditAttributes();
        $this->anulado->EditValue = $this->anulado->options(true);
        $this->anulado->PlaceHolder = RemoveHtml($this->anulado->caption());

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
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->precinto1);
                    $doc->exportCaption($this->precinto2);
                    $doc->exportCaption($this->nombre_familiar);
                    $doc->exportCaption($this->cedula_familiar);
                    $doc->exportCaption($this->certificado_defuncion);
                    $doc->exportCaption($this->fecha_servicio);
                    $doc->exportCaption($this->cremacion_nro);
                    $doc->exportCaption($this->dimension_cofre);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->anulado);
                } else {
                    $doc->exportCaption($this->Nembalaje);
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->precinto1);
                    $doc->exportCaption($this->precinto2);
                    $doc->exportCaption($this->nombre_familiar);
                    $doc->exportCaption($this->cedula_familiar);
                    $doc->exportCaption($this->certificado_defuncion);
                    $doc->exportCaption($this->fecha_servicio);
                    $doc->exportCaption($this->doctor);
                    $doc->exportCaption($this->doctor_nro);
                    $doc->exportCaption($this->cremacion_nro);
                    $doc->exportCaption($this->registro_civil);
                    $doc->exportCaption($this->dimension_cofre);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->anulado);
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
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->precinto1);
                        $doc->exportField($this->precinto2);
                        $doc->exportField($this->nombre_familiar);
                        $doc->exportField($this->cedula_familiar);
                        $doc->exportField($this->certificado_defuncion);
                        $doc->exportField($this->fecha_servicio);
                        $doc->exportField($this->cremacion_nro);
                        $doc->exportField($this->dimension_cofre);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->anulado);
                    } else {
                        $doc->exportField($this->Nembalaje);
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->precinto1);
                        $doc->exportField($this->precinto2);
                        $doc->exportField($this->nombre_familiar);
                        $doc->exportField($this->cedula_familiar);
                        $doc->exportField($this->certificado_defuncion);
                        $doc->exportField($this->fecha_servicio);
                        $doc->exportField($this->doctor);
                        $doc->exportField($this->doctor_nro);
                        $doc->exportField($this->cremacion_nro);
                        $doc->exportField($this->registro_civil);
                        $doc->exportField($this->dimension_cofre);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->anulado);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_embalaje');
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
        $key .= $rs['Nembalaje'];

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
                WriteAuditLog($usr, "A", 'sco_embalaje', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nembalaje'];

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
                    WriteAuditLog($usr, "U", 'sco_embalaje', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nembalaje'];

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
                WriteAuditLog($usr, "D", 'sco_embalaje', $fldname, $key, $oldvalue);
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
    	$rsnew["username"] = CurrentUserName();
    	$rsnew["fecha"] = date("Y-m-d");
    	$rsnew["anulado"] = "N";
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
    	if($rsold["anulado"] == "S") {
    		$this->CancelMessage = "El registro est&aacute; anulado no se puede modificar.";
    		return false;
    	}
    	if($rsold["anulado"] != $rsnew["anulado"]) {
    		if($rsnew["anulado"] == "S") {
    			$sql = "INSERT INTO sco_nota
    						(Nnota, expediente, nota, usuario, fecha)
    					VALUES (NULL, " . $rsold["expediente"] . ", 'EL USUARIO ANULO EMBALAJE DE CENIZAS.', '" . CurrentUserName() . "', NOW())";
    			Execute($sql);
    		}
    	}
    	else {
    		$sql = "INSERT INTO sco_nota
    				(Nnota, expediente, nota, usuario, fecha)
    			VALUES (NULL, " . $rsold["expediente"] . ", 'EL USUARIO MODIFICO INFORMACION DE EMBALAJE DE CENIZAS.', '" . CurrentUserName() . "', NOW())";
    		Execute($sql);
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
