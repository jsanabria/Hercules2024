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
 * Table class for sco_orden_salida
 */
class ScoOrdenSalida extends DbTable
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
    public $Norden_salida;
    public $fecha_hora;
    public $_username;
    public $grupo;
    public $conductor;
    public $acompanantes;
    public $placa;
    public $motivo;
    public $observaciones;
    public $autoriza;
    public $fecha_autoriza;
    public $estatus;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_orden_salida";
        $this->TableName = 'sco_orden_salida';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_orden_salida";
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

        // Norden_salida
        $this->Norden_salida = new DbField(
            $this, // Table
            'x_Norden_salida', // Variable name
            'Norden_salida', // Name
            '`Norden_salida`', // Expression
            '`Norden_salida`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Norden_salida`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Norden_salida->InputTextType = "text";
        $this->Norden_salida->Raw = true;
        $this->Norden_salida->IsAutoIncrement = true; // Autoincrement field
        $this->Norden_salida->IsPrimaryKey = true; // Primary key field
        $this->Norden_salida->Nullable = false; // NOT NULL field
        $this->Norden_salida->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Norden_salida->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Norden_salida'] = &$this->Norden_salida;

        // fecha_hora
        $this->fecha_hora = new DbField(
            $this, // Table
            'x_fecha_hora', // Variable name
            'fecha_hora', // Name
            '`fecha_hora`', // Expression
            CastDateFieldForLike("`fecha_hora`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`fecha_hora`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_hora->InputTextType = "text";
        $this->fecha_hora->Raw = true;
        $this->fecha_hora->Required = true; // Required field
        $this->fecha_hora->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->fecha_hora->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_hora'] = &$this->fecha_hora;

        // username
        $this->_username = new DbField(
            $this, // Table
            'x__username', // Variable name
            'username', // Name
            '`username`', // Expression
            '`username`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`username`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->_username->addMethod("getSelectFilter", fn() => "activo = 1");
        $this->_username->InputTextType = "text";
        $this->_username->Required = true; // Required field
        $this->_username->setSelectMultiple(false); // Select one
        $this->_username->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->_username->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->_username->Lookup = new Lookup($this->_username, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->_username->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['username'] = &$this->_username;

        // grupo
        $this->grupo = new DbField(
            $this, // Table
            'x_grupo', // Variable name
            'grupo', // Name
            '`grupo`', // Expression
            '`grupo`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`grupo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->grupo->InputTextType = "text";
        $this->grupo->Raw = true;
        $this->grupo->Required = true; // Required field
        $this->grupo->setSelectMultiple(false); // Select one
        $this->grupo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->grupo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->grupo->Lookup = new Lookup($this->grupo, 'userlevels', false, 'userlevelid', ["userlevelname","","",""], '', '', [], ["x_conductor"], [], [], [], [], false, '`userlevelname` ASC', '', "`userlevelname`");
        $this->grupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->grupo->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['grupo'] = &$this->grupo;

        // conductor
        $this->conductor = new DbField(
            $this, // Table
            'x_conductor', // Variable name
            'conductor', // Name
            '`conductor`', // Expression
            '`conductor`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`conductor`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->conductor->addMethod("getSelectFilter", fn() => (CurrentPageID() == "add" ? "activo = 1" : ""));
        $this->conductor->InputTextType = "text";
        $this->conductor->Required = true; // Required field
        $this->conductor->setSelectMultiple(false); // Select one
        $this->conductor->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->conductor->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->conductor->Lookup = new Lookup($this->conductor, 'sco_user', false, 'username', ["nombre","","",""], '', '', ["x_grupo"], [], ["level"], ["x_level"], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->conductor->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['conductor'] = &$this->conductor;

        // acompanantes
        $this->acompanantes = new DbField(
            $this, // Table
            'x_acompanantes', // Variable name
            'acompanantes', // Name
            '`acompanantes`', // Expression
            '`acompanantes`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`acompanantes`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->acompanantes->addMethod("getDefault", fn() => 0);
        $this->acompanantes->InputTextType = "text";
        $this->acompanantes->Raw = true;
        $this->acompanantes->Required = true; // Required field
        $this->acompanantes->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->acompanantes->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['acompanantes'] = &$this->acompanantes;

        // placa
        $this->placa = new DbField(
            $this, // Table
            'x_placa', // Variable name
            'placa', // Name
            '`placa`', // Expression
            '`placa`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`placa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->placa->addMethod("getSelectFilter", fn() => (CurrentPageID() == "add" ? "`activo` = 'S'" : ""));
        $this->placa->InputTextType = "text";
        $this->placa->Required = true; // Required field
        $this->placa->Lookup = new Lookup($this->placa, 'sco_flota', false, 'placa', ["placa","tipo","anho","color"], '', '', [], [], [], [], [], [], false, '`placa` ASC', '', "CONCAT(COALESCE(`placa`, ''),'" . ValueSeparator(1, $this->placa) . "',COALESCE(`tipo`,''),'" . ValueSeparator(2, $this->placa) . "',COALESCE(`anho`,''),'" . ValueSeparator(3, $this->placa) . "',COALESCE(`color`,''))");
        $this->placa->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['placa'] = &$this->placa;

        // motivo
        $this->motivo = new DbField(
            $this, // Table
            'x_motivo', // Variable name
            'motivo', // Name
            '`motivo`', // Expression
            '`motivo`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`motivo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->motivo->addMethod("getSelectFilter", fn() => "`codigo` = '030'");
        $this->motivo->InputTextType = "text";
        $this->motivo->Required = true; // Required field
        $this->motivo->setSelectMultiple(false); // Select one
        $this->motivo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->motivo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->motivo->Lookup = new Lookup($this->motivo, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->motivo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['motivo'] = &$this->motivo;

        // observaciones
        $this->observaciones = new DbField(
            $this, // Table
            'x_observaciones', // Variable name
            'observaciones', // Name
            '`observaciones`', // Expression
            '`observaciones`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`observaciones`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->observaciones->InputTextType = "text";
        $this->observaciones->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['observaciones'] = &$this->observaciones;

        // autoriza
        $this->autoriza = new DbField(
            $this, // Table
            'x_autoriza', // Variable name
            'autoriza', // Name
            '`autoriza`', // Expression
            '`autoriza`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`autoriza`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->autoriza->InputTextType = "text";
        $this->autoriza->Required = true; // Required field
        $this->autoriza->setSelectMultiple(false); // Select one
        $this->autoriza->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->autoriza->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->autoriza->Lookup = new Lookup($this->autoriza, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->autoriza->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['autoriza'] = &$this->autoriza;

        // fecha_autoriza
        $this->fecha_autoriza = new DbField(
            $this, // Table
            'x_fecha_autoriza', // Variable name
            'fecha_autoriza', // Name
            '`fecha_autoriza`', // Expression
            CastDateFieldForLike("`fecha_autoriza`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
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
        $this->fecha_autoriza->Required = true; // Required field
        $this->fecha_autoriza->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->fecha_autoriza->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_autoriza'] = &$this->fecha_autoriza;

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
        $this->estatus->addMethod("getSelectFilter", fn() => "`codigo` = '031'");
        $this->estatus->InputTextType = "text";
        $this->estatus->Required = true; // Required field
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_parametro', false, 'valor1', ["valor2","","",""], '', '', [], [], [], [], [], [], false, '`valor4` ASC', '', "`valor2`");
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_orden_salida";
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
            $this->Norden_salida->setDbValue($conn->lastInsertId());
            $rs['Norden_salida'] = $this->Norden_salida->DbValue;
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
            if (!isset($rs['Norden_salida']) && !EmptyValue($this->Norden_salida->CurrentValue)) {
                $rs['Norden_salida'] = $this->Norden_salida->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Norden_salida';
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
            if (array_key_exists('Norden_salida', $rs)) {
                AddFilter($where, QuotedName('Norden_salida', $this->Dbid) . '=' . QuotedValue($rs['Norden_salida'], $this->Norden_salida->DataType, $this->Dbid));
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
        $this->Norden_salida->DbValue = $row['Norden_salida'];
        $this->fecha_hora->DbValue = $row['fecha_hora'];
        $this->_username->DbValue = $row['username'];
        $this->grupo->DbValue = $row['grupo'];
        $this->conductor->DbValue = $row['conductor'];
        $this->acompanantes->DbValue = $row['acompanantes'];
        $this->placa->DbValue = $row['placa'];
        $this->motivo->DbValue = $row['motivo'];
        $this->observaciones->DbValue = $row['observaciones'];
        $this->autoriza->DbValue = $row['autoriza'];
        $this->fecha_autoriza->DbValue = $row['fecha_autoriza'];
        $this->estatus->DbValue = $row['estatus'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Norden_salida` = @Norden_salida@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Norden_salida->CurrentValue : $this->Norden_salida->OldValue;
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
                $this->Norden_salida->CurrentValue = $keys[0];
            } else {
                $this->Norden_salida->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Norden_salida', $row) ? $row['Norden_salida'] : null;
        } else {
            $val = !EmptyValue($this->Norden_salida->OldValue) && !$current ? $this->Norden_salida->OldValue : $this->Norden_salida->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Norden_salida@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoOrdenSalidaList");
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
            "ScoOrdenSalidaView" => $Language->phrase("View"),
            "ScoOrdenSalidaEdit" => $Language->phrase("Edit"),
            "ScoOrdenSalidaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoOrdenSalidaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoOrdenSalidaView",
            Config("API_ADD_ACTION") => "ScoOrdenSalidaAdd",
            Config("API_EDIT_ACTION") => "ScoOrdenSalidaEdit",
            Config("API_DELETE_ACTION") => "ScoOrdenSalidaDelete",
            Config("API_LIST_ACTION") => "ScoOrdenSalidaList",
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
        return "ScoOrdenSalidaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoOrdenSalidaView", $parm);
        } else {
            $url = $this->keyUrl("ScoOrdenSalidaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoOrdenSalidaAdd?" . $parm;
        } else {
            $url = "ScoOrdenSalidaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoOrdenSalidaEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoOrdenSalidaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoOrdenSalidaAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoOrdenSalidaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoOrdenSalidaDelete", $parm);
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
        $json .= "\"Norden_salida\":" . VarToJson($this->Norden_salida->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Norden_salida->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Norden_salida->CurrentValue);
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
            if (($keyValue = Param("Norden_salida") ?? Route("Norden_salida")) !== null) {
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
                $this->Norden_salida->CurrentValue = $key;
            } else {
                $this->Norden_salida->OldValue = $key;
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
        $this->Norden_salida->setDbValue($row['Norden_salida']);
        $this->fecha_hora->setDbValue($row['fecha_hora']);
        $this->_username->setDbValue($row['username']);
        $this->grupo->setDbValue($row['grupo']);
        $this->conductor->setDbValue($row['conductor']);
        $this->acompanantes->setDbValue($row['acompanantes']);
        $this->placa->setDbValue($row['placa']);
        $this->motivo->setDbValue($row['motivo']);
        $this->observaciones->setDbValue($row['observaciones']);
        $this->autoriza->setDbValue($row['autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoOrdenSalidaList";
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

        // Norden_salida

        // fecha_hora

        // username

        // grupo

        // conductor

        // acompanantes

        // placa

        // motivo

        // observaciones

        // autoriza

        // fecha_autoriza

        // estatus

        // Norden_salida
        $this->Norden_salida->ViewValue = $this->Norden_salida->CurrentValue;

        // fecha_hora
        $this->fecha_hora->ViewValue = $this->fecha_hora->CurrentValue;
        $this->fecha_hora->ViewValue = FormatDateTime($this->fecha_hora->ViewValue, $this->fecha_hora->formatPattern());

        // username
        $curVal = strval($this->_username->CurrentValue);
        if ($curVal != "") {
            $this->_username->ViewValue = $this->_username->lookupCacheOption($curVal);
            if ($this->_username->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->_username->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->_username->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $lookupFilter = $this->_username->getSelectFilter($this); // PHP
                $sqlWrk = $this->_username->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
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

        // grupo
        $curVal = strval($this->grupo->CurrentValue);
        if ($curVal != "") {
            $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
            if ($this->grupo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->grupo->Lookup->getTable()->Fields["userlevelid"]->searchExpression(), "=", $curVal, $this->grupo->Lookup->getTable()->Fields["userlevelid"]->searchDataType(), "");
                $sqlWrk = $this->grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                    $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                } else {
                    $this->grupo->ViewValue = $this->grupo->CurrentValue;
                }
            }
        } else {
            $this->grupo->ViewValue = null;
        }

        // conductor
        $curVal = strval($this->conductor->CurrentValue);
        if ($curVal != "") {
            $this->conductor->ViewValue = $this->conductor->lookupCacheOption($curVal);
            if ($this->conductor->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->conductor->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->conductor->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $lookupFilter = $this->conductor->getSelectFilter($this); // PHP
                $sqlWrk = $this->conductor->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->conductor->Lookup->renderViewRow($rswrk[0]);
                    $this->conductor->ViewValue = $this->conductor->displayValue($arwrk);
                } else {
                    $this->conductor->ViewValue = $this->conductor->CurrentValue;
                }
            }
        } else {
            $this->conductor->ViewValue = null;
        }

        // acompanantes
        $this->acompanantes->ViewValue = $this->acompanantes->CurrentValue;

        // placa
        $this->placa->ViewValue = $this->placa->CurrentValue;
        $curVal = strval($this->placa->CurrentValue);
        if ($curVal != "") {
            $this->placa->ViewValue = $this->placa->lookupCacheOption($curVal);
            if ($this->placa->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->placa->Lookup->getTable()->Fields["placa"]->searchExpression(), "=", $curVal, $this->placa->Lookup->getTable()->Fields["placa"]->searchDataType(), "");
                $lookupFilter = $this->placa->getSelectFilter($this); // PHP
                $sqlWrk = $this->placa->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->placa->Lookup->renderViewRow($rswrk[0]);
                    $this->placa->ViewValue = $this->placa->displayValue($arwrk);
                } else {
                    $this->placa->ViewValue = $this->placa->CurrentValue;
                }
            }
        } else {
            $this->placa->ViewValue = null;
        }

        // motivo
        $curVal = strval($this->motivo->CurrentValue);
        if ($curVal != "") {
            $this->motivo->ViewValue = $this->motivo->lookupCacheOption($curVal);
            if ($this->motivo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->motivo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->motivo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->motivo->getSelectFilter($this); // PHP
                $sqlWrk = $this->motivo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->motivo->Lookup->renderViewRow($rswrk[0]);
                    $this->motivo->ViewValue = $this->motivo->displayValue($arwrk);
                } else {
                    $this->motivo->ViewValue = $this->motivo->CurrentValue;
                }
            }
        } else {
            $this->motivo->ViewValue = null;
        }

        // observaciones
        $this->observaciones->ViewValue = $this->observaciones->CurrentValue;

        // autoriza
        $curVal = strval($this->autoriza->CurrentValue);
        if ($curVal != "") {
            $this->autoriza->ViewValue = $this->autoriza->lookupCacheOption($curVal);
            if ($this->autoriza->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->autoriza->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->autoriza->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->autoriza->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->autoriza->Lookup->renderViewRow($rswrk[0]);
                    $this->autoriza->ViewValue = $this->autoriza->displayValue($arwrk);
                } else {
                    $this->autoriza->ViewValue = $this->autoriza->CurrentValue;
                }
            }
        } else {
            $this->autoriza->ViewValue = null;
        }

        // fecha_autoriza
        $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
        $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

        // estatus
        $curVal = strval($this->estatus->CurrentValue);
        if ($curVal != "") {
            $this->estatus->ViewValue = $this->estatus->lookupCacheOption($curVal);
            if ($this->estatus->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->estatus->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->estatus->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
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

        // Norden_salida
        $this->Norden_salida->HrefValue = "";
        $this->Norden_salida->TooltipValue = "";

        // fecha_hora
        $this->fecha_hora->HrefValue = "";
        $this->fecha_hora->TooltipValue = "";

        // username
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // grupo
        $this->grupo->HrefValue = "";
        $this->grupo->TooltipValue = "";

        // conductor
        $this->conductor->HrefValue = "";
        $this->conductor->TooltipValue = "";

        // acompanantes
        $this->acompanantes->HrefValue = "";
        $this->acompanantes->TooltipValue = "";

        // placa
        $this->placa->HrefValue = "";
        $this->placa->TooltipValue = "";

        // motivo
        $this->motivo->HrefValue = "";
        $this->motivo->TooltipValue = "";

        // observaciones
        $this->observaciones->HrefValue = "";
        $this->observaciones->TooltipValue = "";

        // autoriza
        $this->autoriza->HrefValue = "";
        $this->autoriza->TooltipValue = "";

        // fecha_autoriza
        $this->fecha_autoriza->HrefValue = "";
        $this->fecha_autoriza->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

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

        // Norden_salida
        $this->Norden_salida->setupEditAttributes();
        $this->Norden_salida->EditValue = $this->Norden_salida->CurrentValue;

        // fecha_hora
        $this->fecha_hora->setupEditAttributes();
        $this->fecha_hora->EditValue = FormatDateTime($this->fecha_hora->CurrentValue, $this->fecha_hora->formatPattern());
        $this->fecha_hora->PlaceHolder = RemoveHtml($this->fecha_hora->caption());

        // username
        $this->_username->setupEditAttributes();
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // grupo
        $this->grupo->setupEditAttributes();
        $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());

        // conductor
        $this->conductor->setupEditAttributes();
        $this->conductor->PlaceHolder = RemoveHtml($this->conductor->caption());

        // acompanantes
        $this->acompanantes->setupEditAttributes();
        $this->acompanantes->EditValue = $this->acompanantes->CurrentValue;
        $this->acompanantes->PlaceHolder = RemoveHtml($this->acompanantes->caption());
        if (strval($this->acompanantes->EditValue) != "" && is_numeric($this->acompanantes->EditValue)) {
            $this->acompanantes->EditValue = $this->acompanantes->EditValue;
        }

        // placa
        $this->placa->setupEditAttributes();
        if (!$this->placa->Raw) {
            $this->placa->CurrentValue = HtmlDecode($this->placa->CurrentValue);
        }
        $this->placa->EditValue = $this->placa->CurrentValue;
        $this->placa->PlaceHolder = RemoveHtml($this->placa->caption());

        // motivo
        $this->motivo->setupEditAttributes();
        $this->motivo->PlaceHolder = RemoveHtml($this->motivo->caption());

        // observaciones
        $this->observaciones->setupEditAttributes();
        $this->observaciones->EditValue = $this->observaciones->CurrentValue;
        $this->observaciones->PlaceHolder = RemoveHtml($this->observaciones->caption());

        // autoriza
        $this->autoriza->setupEditAttributes();
        $this->autoriza->PlaceHolder = RemoveHtml($this->autoriza->caption());

        // fecha_autoriza
        $this->fecha_autoriza->setupEditAttributes();
        $this->fecha_autoriza->EditValue = FormatDateTime($this->fecha_autoriza->CurrentValue, $this->fecha_autoriza->formatPattern());
        $this->fecha_autoriza->PlaceHolder = RemoveHtml($this->fecha_autoriza->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

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
                    $doc->exportCaption($this->Norden_salida);
                    $doc->exportCaption($this->fecha_hora);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->grupo);
                    $doc->exportCaption($this->conductor);
                    $doc->exportCaption($this->acompanantes);
                    $doc->exportCaption($this->placa);
                    $doc->exportCaption($this->motivo);
                    $doc->exportCaption($this->observaciones);
                    $doc->exportCaption($this->autoriza);
                    $doc->exportCaption($this->fecha_autoriza);
                    $doc->exportCaption($this->estatus);
                } else {
                    $doc->exportCaption($this->Norden_salida);
                    $doc->exportCaption($this->fecha_hora);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->grupo);
                    $doc->exportCaption($this->conductor);
                    $doc->exportCaption($this->acompanantes);
                    $doc->exportCaption($this->placa);
                    $doc->exportCaption($this->motivo);
                    $doc->exportCaption($this->observaciones);
                    $doc->exportCaption($this->autoriza);
                    $doc->exportCaption($this->fecha_autoriza);
                    $doc->exportCaption($this->estatus);
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
                        $doc->exportField($this->Norden_salida);
                        $doc->exportField($this->fecha_hora);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->grupo);
                        $doc->exportField($this->conductor);
                        $doc->exportField($this->acompanantes);
                        $doc->exportField($this->placa);
                        $doc->exportField($this->motivo);
                        $doc->exportField($this->observaciones);
                        $doc->exportField($this->autoriza);
                        $doc->exportField($this->fecha_autoriza);
                        $doc->exportField($this->estatus);
                    } else {
                        $doc->exportField($this->Norden_salida);
                        $doc->exportField($this->fecha_hora);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->grupo);
                        $doc->exportField($this->conductor);
                        $doc->exportField($this->acompanantes);
                        $doc->exportField($this->placa);
                        $doc->exportField($this->motivo);
                        $doc->exportField($this->observaciones);
                        $doc->exportField($this->autoriza);
                        $doc->exportField($this->fecha_autoriza);
                        $doc->exportField($this->estatus);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_orden_salida');
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
        $key .= $rs['Norden_salida'];

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
                WriteAuditLog($usr, "A", 'sco_orden_salida', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Norden_salida'];

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
                    WriteAuditLog($usr, "U", 'sco_orden_salida', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Norden_salida'];

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
                WriteAuditLog($usr, "D", 'sco_orden_salida', $fldname, $key, $oldvalue);
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
    	if (isset($_REQUEST["myst"])) {
            $myst = trim($_REQUEST["myst"]);
            if (!empty($myst)) {
                AddFilter($filter, "estatus = '" . $myst . "'");
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
    public function rowInserting($rsold, &$rsnew) {
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	//$rsnew["estatus"] = "P1";
    	$rsnew["estatus"] = "P1";
    	$rsnew["username"] = CurrentUserName();
    	$rsnew["fecha_hora"] = date("Y-m-d H:i:s");
    	return TRUE;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew) {
    	//echo "Row Inserted"
    	error_reporting(E_ALL);
    	ini_set('display_errors', '1');
    	$sql = "SELECT valor1 AS mail1, valor2 AS mail2, valor3 mail3, valor4 AS mail4 
    			FROM sco_parametro 
    			WHERE codigo = '032';";
    	$row = ExecuteRow($sql);
    	$to = $row["mail1"];
    	$to2 = $row["mail2"];
    	$to3 = $row["mail3"];
    	$to4 = $row["mail4"];
    	$orden = $rsnew["Norden_salida"];
    	$conductor = $rsnew["conductor"];
    	$acompanantes = $rsnew["acompanantes"];   
    	$placa = $rsnew["placa"];
    	$motivo = $rsnew["motivo"];
    	$observaciones = $rsnew["observaciones"]; 
    	$subject = "Atención Cementerio Del Este - Orden de Salida Número: ".$orden; // Change subject
    	$notificacion = "Notificación de orden de salida de vehículo bajo el número : <b>$orden</b><br><br>";
    	$notificacion .= "Conductor: $conductor<br>"; 
    	$notificacion .= "Acompanantes: $acompanantes<br>";
    	$notificacion .= "Placa: $placa<br>";
    	$notificacion .= "Motivo: $motivo<br>";
    	$notificacion .= "Observaciones: $observaciones<br><br>"; 
    	$notificacion .= "<img src='http://cementeriodeleste.com.ve/images/samples/logo.png' alt='Logo' width='250'><br><br>";
    	$notificacion .= "<a href='http://cementeriodeleste.com.ve/'>www.cementeriodeleste.com.ve</a><br><br>";

    	// include("variables_mail_enviar.php");
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
    	if ($this->PageID == "list" || $this->PageID == "view") { // List/View page only
    		$sql = "SELECT valor4 AS color FROM sco_parametro 
    				WHERE codigo = '031' AND valor1 = '" . $this->estatus->CurrentValue . "';";
    		$color = ExecuteScalar($sql);
    		$style = $color; 	
    		$this->Norden_salida->CellAttrs["style"] = $style;
    		$this->conductor->CellAttrs["style"] = $style;
    		$this->placa->CellAttrs["style"] = $style;
    		$this->autoriza->CellAttrs["style"] = $style;
    		$this->estatus->CellAttrs["style"] = $style;
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
