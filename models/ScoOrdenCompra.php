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
 * Table class for sco_orden_compra
 */
class ScoOrdenCompra extends DbTable
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
    public $Norden_compra;
    public $fecha;
    public $tipo_proveedor;
    public $proveedor;
    public $_username;
    public $unidad_solicitante;
    public $nota;
    public $estatus;
    public $username_estatus;
    public $fecha_aprobacion;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_orden_compra";
        $this->TableName = 'sco_orden_compra';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_orden_compra";
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

        // Norden_compra
        $this->Norden_compra = new DbField(
            $this, // Table
            'x_Norden_compra', // Variable name
            'Norden_compra', // Name
            '`Norden_compra`', // Expression
            '`Norden_compra`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Norden_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Norden_compra->InputTextType = "text";
        $this->Norden_compra->Raw = true;
        $this->Norden_compra->IsAutoIncrement = true; // Autoincrement field
        $this->Norden_compra->IsPrimaryKey = true; // Primary key field
        $this->Norden_compra->IsForeignKey = true; // Foreign key field
        $this->Norden_compra->Nullable = false; // NOT NULL field
        $this->Norden_compra->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Norden_compra->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Norden_compra'] = &$this->Norden_compra;

        // fecha
        $this->fecha = new DbField(
            $this, // Table
            'x_fecha', // Variable name
            'fecha', // Name
            '`fecha`', // Expression
            CastDateFieldForLike("`fecha`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
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
        $this->fecha->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha'] = &$this->fecha;

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
            'TEXT' // Edit Tag
        );
        $this->tipo_proveedor->InputTextType = "text";
        $this->tipo_proveedor->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo_proveedor'] = &$this->tipo_proveedor;

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
            'TEXT' // Edit Tag
        );
        $this->proveedor->InputTextType = "text";
        $this->proveedor->Raw = true;
        $this->proveedor->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->proveedor->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['proveedor'] = &$this->proveedor;

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
        $this->_username->InputTextType = "text";
        $this->_username->setSelectMultiple(false); // Select one
        $this->_username->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->_username->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->_username->Lookup = new Lookup($this->_username, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre` DESC', '', "`nombre`");
        $this->_username->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['username'] = &$this->_username;

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
        $this->unidad_solicitante->addMethod("getSelectFilter", fn() => "`tabla` = 'AREAS_MANTENIMIENTO'");
        $this->unidad_solicitante->InputTextType = "text";
        $this->unidad_solicitante->Required = true; // Required field
        $this->unidad_solicitante->setSelectMultiple(false); // Select one
        $this->unidad_solicitante->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->unidad_solicitante->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->unidad_solicitante->Lookup = new Lookup($this->unidad_solicitante, 'sco_tabla', false, 'campo_descripcion', ["campo_descripcion","","",""], '', '', [], [], [], [], [], [], false, '`campo_descripcion` ASC', '', "`campo_descripcion`");
        $this->unidad_solicitante->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['unidad_solicitante'] = &$this->unidad_solicitante;

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
        $this->nota->Required = true; // Required field
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
        $this->estatus->Required = true; // Required field
        $this->estatus->setSelectMultiple(false); // Select one
        $this->estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_orden_compra', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->estatus->OptionCount = 4;
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

        // username_estatus
        $this->username_estatus = new DbField(
            $this, // Table
            'x_username_estatus', // Variable name
            'username_estatus', // Name
            '`username_estatus`', // Expression
            '`username_estatus`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`username_estatus`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->username_estatus->InputTextType = "text";
        $this->username_estatus->setSelectMultiple(false); // Select one
        $this->username_estatus->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->username_estatus->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->username_estatus->Lookup = new Lookup($this->username_estatus, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre` ASC', '', "`nombre`");
        $this->username_estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['username_estatus'] = &$this->username_estatus;

        // fecha_aprobacion
        $this->fecha_aprobacion = new DbField(
            $this, // Table
            'x_fecha_aprobacion', // Variable name
            'fecha_aprobacion', // Name
            '`fecha_aprobacion`', // Expression
            CastDateFieldForLike("`fecha_aprobacion`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_aprobacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_aprobacion->InputTextType = "text";
        $this->fecha_aprobacion->Raw = true;
        $this->fecha_aprobacion->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_aprobacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_aprobacion'] = &$this->fecha_aprobacion;

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
        if ($this->getCurrentDetailTable() == "sco_orden_compra_detalle") {
            $detailUrl = Container("sco_orden_compra_detalle")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Norden_compra", $this->Norden_compra->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "sco_nota_orden_compra") {
            $detailUrl = Container("sco_nota_orden_compra")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_Norden_compra", $this->Norden_compra->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "ScoOrdenCompraList";
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_orden_compra";
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
            $this->Norden_compra->setDbValue($conn->lastInsertId());
            $rs['Norden_compra'] = $this->Norden_compra->DbValue;
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
        // Cascade Update detail table 'sco_orden_compra_detalle'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Norden_compra']) && $rsold['Norden_compra'] != $rs['Norden_compra'])) { // Update detail field 'orden_compra'
            $cascadeUpdate = true;
            $rscascade['orden_compra'] = $rs['Norden_compra'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_orden_compra_detalle")->loadRs("`orden_compra` = " . QuotedValue($rsold['Norden_compra'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Norden_compra_detalle';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_orden_compra_detalle")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_orden_compra_detalle")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_orden_compra_detalle")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'sco_nota_orden_compra'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['Norden_compra']) && $rsold['Norden_compra'] != $rs['Norden_compra'])) { // Update detail field 'orden_compra'
            $cascadeUpdate = true;
            $rscascade['orden_compra'] = $rs['Norden_compra'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("sco_nota_orden_compra")->loadRs("`orden_compra` = " . QuotedValue($rsold['Norden_compra'], DataType::NUMBER, 'DB'))->fetchAllAssociative();
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'Nnota_orden_compra';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("sco_nota_orden_compra")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("sco_nota_orden_compra")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("sco_nota_orden_compra")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (!isset($rs['Norden_compra']) && !EmptyValue($this->Norden_compra->CurrentValue)) {
                $rs['Norden_compra'] = $this->Norden_compra->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Norden_compra';
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
            if (array_key_exists('Norden_compra', $rs)) {
                AddFilter($where, QuotedName('Norden_compra', $this->Dbid) . '=' . QuotedValue($rs['Norden_compra'], $this->Norden_compra->DataType, $this->Dbid));
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

        // Cascade delete detail table 'sco_orden_compra_detalle'
        $dtlrows = Container("sco_orden_compra_detalle")->loadRs("`orden_compra` = " . QuotedValue($rs['Norden_compra'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_orden_compra_detalle")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_orden_compra_detalle")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_orden_compra_detalle")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'sco_nota_orden_compra'
        $dtlrows = Container("sco_nota_orden_compra")->loadRs("`orden_compra` = " . QuotedValue($rs['Norden_compra'], DataType::NUMBER, "DB"))->fetchAllAssociative();
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("sco_nota_orden_compra")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("sco_nota_orden_compra")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("sco_nota_orden_compra")->rowDeleted($dtlrow);
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
        $this->Norden_compra->DbValue = $row['Norden_compra'];
        $this->fecha->DbValue = $row['fecha'];
        $this->tipo_proveedor->DbValue = $row['tipo_proveedor'];
        $this->proveedor->DbValue = $row['proveedor'];
        $this->_username->DbValue = $row['username'];
        $this->unidad_solicitante->DbValue = $row['unidad_solicitante'];
        $this->nota->DbValue = $row['nota'];
        $this->estatus->DbValue = $row['estatus'];
        $this->username_estatus->DbValue = $row['username_estatus'];
        $this->fecha_aprobacion->DbValue = $row['fecha_aprobacion'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Norden_compra` = @Norden_compra@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Norden_compra->CurrentValue : $this->Norden_compra->OldValue;
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
                $this->Norden_compra->CurrentValue = $keys[0];
            } else {
                $this->Norden_compra->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Norden_compra', $row) ? $row['Norden_compra'] : null;
        } else {
            $val = !EmptyValue($this->Norden_compra->OldValue) && !$current ? $this->Norden_compra->OldValue : $this->Norden_compra->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Norden_compra@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoOrdenCompraList");
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
            "ScoOrdenCompraView" => $Language->phrase("View"),
            "ScoOrdenCompraEdit" => $Language->phrase("Edit"),
            "ScoOrdenCompraAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoOrdenCompraList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoOrdenCompraView",
            Config("API_ADD_ACTION") => "ScoOrdenCompraAdd",
            Config("API_EDIT_ACTION") => "ScoOrdenCompraEdit",
            Config("API_DELETE_ACTION") => "ScoOrdenCompraDelete",
            Config("API_LIST_ACTION") => "ScoOrdenCompraList",
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
        return "ScoOrdenCompraList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoOrdenCompraView", $parm);
        } else {
            $url = $this->keyUrl("ScoOrdenCompraView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoOrdenCompraAdd?" . $parm;
        } else {
            $url = "ScoOrdenCompraAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoOrdenCompraEdit", $parm);
        } else {
            $url = $this->keyUrl("ScoOrdenCompraEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoOrdenCompraList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoOrdenCompraAdd", $parm);
        } else {
            $url = $this->keyUrl("ScoOrdenCompraAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoOrdenCompraList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoOrdenCompraDelete", $parm);
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
        $json .= "\"Norden_compra\":" . VarToJson($this->Norden_compra->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Norden_compra->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Norden_compra->CurrentValue);
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
            if (($keyValue = Param("Norden_compra") ?? Route("Norden_compra")) !== null) {
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
                $this->Norden_compra->CurrentValue = $key;
            } else {
                $this->Norden_compra->OldValue = $key;
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
        $this->Norden_compra->setDbValue($row['Norden_compra']);
        $this->fecha->setDbValue($row['fecha']);
        $this->tipo_proveedor->setDbValue($row['tipo_proveedor']);
        $this->proveedor->setDbValue($row['proveedor']);
        $this->_username->setDbValue($row['username']);
        $this->unidad_solicitante->setDbValue($row['unidad_solicitante']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
        $this->username_estatus->setDbValue($row['username_estatus']);
        $this->fecha_aprobacion->setDbValue($row['fecha_aprobacion']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoOrdenCompraList";
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

        // Norden_compra

        // fecha

        // tipo_proveedor

        // proveedor

        // username

        // unidad_solicitante

        // nota

        // estatus

        // username_estatus

        // fecha_aprobacion

        // Norden_compra
        $this->Norden_compra->ViewValue = $this->Norden_compra->CurrentValue;

        // fecha
        $this->fecha->ViewValue = $this->fecha->CurrentValue;
        $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

        // tipo_proveedor
        $this->tipo_proveedor->ViewValue = $this->tipo_proveedor->CurrentValue;

        // proveedor
        $this->proveedor->ViewValue = $this->proveedor->CurrentValue;

        // username
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

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // estatus
        if (strval($this->estatus->CurrentValue) != "") {
            $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
        } else {
            $this->estatus->ViewValue = null;
        }

        // username_estatus
        $curVal = strval($this->username_estatus->CurrentValue);
        if ($curVal != "") {
            $this->username_estatus->ViewValue = $this->username_estatus->lookupCacheOption($curVal);
            if ($this->username_estatus->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->username_estatus->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->username_estatus->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->username_estatus->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->username_estatus->Lookup->renderViewRow($rswrk[0]);
                    $this->username_estatus->ViewValue = $this->username_estatus->displayValue($arwrk);
                } else {
                    $this->username_estatus->ViewValue = $this->username_estatus->CurrentValue;
                }
            }
        } else {
            $this->username_estatus->ViewValue = null;
        }

        // fecha_aprobacion
        $this->fecha_aprobacion->ViewValue = $this->fecha_aprobacion->CurrentValue;
        $this->fecha_aprobacion->ViewValue = FormatDateTime($this->fecha_aprobacion->ViewValue, $this->fecha_aprobacion->formatPattern());

        // Norden_compra
        $this->Norden_compra->HrefValue = "";
        $this->Norden_compra->TooltipValue = "";

        // fecha
        $this->fecha->HrefValue = "";
        $this->fecha->TooltipValue = "";

        // tipo_proveedor
        $this->tipo_proveedor->HrefValue = "";
        $this->tipo_proveedor->TooltipValue = "";

        // proveedor
        $this->proveedor->HrefValue = "";
        $this->proveedor->TooltipValue = "";

        // username
        $this->_username->HrefValue = "";
        $this->_username->TooltipValue = "";

        // unidad_solicitante
        $this->unidad_solicitante->HrefValue = "";
        $this->unidad_solicitante->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // username_estatus
        $this->username_estatus->HrefValue = "";
        $this->username_estatus->TooltipValue = "";

        // fecha_aprobacion
        $this->fecha_aprobacion->HrefValue = "";
        $this->fecha_aprobacion->TooltipValue = "";

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

        // Norden_compra
        $this->Norden_compra->setupEditAttributes();
        $this->Norden_compra->EditValue = $this->Norden_compra->CurrentValue;

        // fecha
        $this->fecha->setupEditAttributes();
        $this->fecha->EditValue = FormatDateTime($this->fecha->CurrentValue, $this->fecha->formatPattern());
        $this->fecha->PlaceHolder = RemoveHtml($this->fecha->caption());

        // tipo_proveedor
        $this->tipo_proveedor->setupEditAttributes();
        if (!$this->tipo_proveedor->Raw) {
            $this->tipo_proveedor->CurrentValue = HtmlDecode($this->tipo_proveedor->CurrentValue);
        }
        $this->tipo_proveedor->EditValue = $this->tipo_proveedor->CurrentValue;
        $this->tipo_proveedor->PlaceHolder = RemoveHtml($this->tipo_proveedor->caption());

        // proveedor
        $this->proveedor->setupEditAttributes();
        $this->proveedor->EditValue = $this->proveedor->CurrentValue;
        $this->proveedor->PlaceHolder = RemoveHtml($this->proveedor->caption());
        if (strval($this->proveedor->EditValue) != "" && is_numeric($this->proveedor->EditValue)) {
            $this->proveedor->EditValue = $this->proveedor->EditValue;
        }

        // username
        $this->_username->setupEditAttributes();
        $this->_username->PlaceHolder = RemoveHtml($this->_username->caption());

        // unidad_solicitante
        $this->unidad_solicitante->setupEditAttributes();
        $this->unidad_solicitante->PlaceHolder = RemoveHtml($this->unidad_solicitante->caption());

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->options(true);
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // username_estatus
        $this->username_estatus->setupEditAttributes();
        $this->username_estatus->PlaceHolder = RemoveHtml($this->username_estatus->caption());

        // fecha_aprobacion
        $this->fecha_aprobacion->setupEditAttributes();
        $this->fecha_aprobacion->EditValue = FormatDateTime($this->fecha_aprobacion->CurrentValue, $this->fecha_aprobacion->formatPattern());
        $this->fecha_aprobacion->PlaceHolder = RemoveHtml($this->fecha_aprobacion->caption());

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
                    $doc->exportCaption($this->Norden_compra);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->unidad_solicitante);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->username_estatus);
                    $doc->exportCaption($this->fecha_aprobacion);
                } else {
                    $doc->exportCaption($this->Norden_compra);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->tipo_proveedor);
                    $doc->exportCaption($this->proveedor);
                    $doc->exportCaption($this->_username);
                    $doc->exportCaption($this->unidad_solicitante);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->username_estatus);
                    $doc->exportCaption($this->fecha_aprobacion);
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
                        $doc->exportField($this->Norden_compra);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->unidad_solicitante);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->username_estatus);
                        $doc->exportField($this->fecha_aprobacion);
                    } else {
                        $doc->exportField($this->Norden_compra);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->tipo_proveedor);
                        $doc->exportField($this->proveedor);
                        $doc->exportField($this->_username);
                        $doc->exportField($this->unidad_solicitante);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->username_estatus);
                        $doc->exportField($this->fecha_aprobacion);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_orden_compra');
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
        $key .= $rs['Norden_compra'];

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
                WriteAuditLog($usr, "A", 'sco_orden_compra', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Norden_compra'];

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
                    WriteAuditLog($usr, "U", 'sco_orden_compra', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Norden_compra'];

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
                WriteAuditLog($usr, "D", 'sco_orden_compra', $fldname, $key, $oldvalue);
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
    	/*$sql = "SELECT departamento FROM sco_user WHERE username = '" . CurrentUserName() . "';";
    	$rsnew["unidad_solicitante"] = ExecuteScalar($sql);*/
    	$rsnew["fecha"] = date("Y-m-d");
    	$rsnew["username"] = CurrentUserName();
    	$rsnew["estatus"] = "NUEVO";
    	return TRUE;
    }

    // Row Inserted event
    public function rowInserted($rsold, $rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew) {
        // --- 0. Sanitización de la Entrada (CRÍTICO: aunque es numérico, es buena práctica) ---
        $norden_compra = intval($rsold["Norden_compra"] ?? 0);

        // --- 1. Regla de Bloqueo General: No se puede modificar si ya está CERRADO o ANULADO ---
        if ($rsold["estatus"] == "CERRADO" || $rsold["estatus"] == "ANULADO") {
            // Excepción: Permitir la modificación al nivel de administrador (nivel -1 en PHPMaker)
            $levelid = CurrentUserLevel();
            if ($levelid == -1) {
                // Permitir al Admin actualizar los campos de estatus y fecha
                $rsnew["username_estatus"] = CurrentUserName();
                $rsnew["fecha_aprobacion"] = date("Y-m-d");
                return TRUE;
            } else {
                // Bloquear a usuarios normales
                $this->CancelMessage = "La Orden de Compra está cerrada o anulada; solo un administrador puede modificarla.";
                return FALSE;
            }
        }

        // --- 2. Regla de Cierre: Si el estatus cambia a CERRADO, validar recepción de artículos ---
        if (($rsold["estatus"] != $rsnew["estatus"]) && ($rsnew["estatus"] == "CERRADO")) {
            // Validar que el ID de la orden de compra sea válido antes de consultar
            if ($norden_compra <= 0) {
                $this->CancelMessage = "ID de Orden de Compra inválido.";
                return FALSE;
            }

            // Consulta para verificar artículos pendientes (sin cantidad_recibida)
            $sql_pendiente = "
                SELECT
                    COUNT(Norden_compra_detalle) AS cantidad
                FROM
                    sco_orden_compra_detalle
                WHERE
                    orden_compra = " . $norden_compra . " 
                    AND cantidad_recibida IS NULL;
            ";
            $cantidad = ExecuteScalar($sql_pendiente);
            if (intval($cantidad) > 0) {
                $this->CancelMessage = "Hay $cantidad artículos pendientes por recibir en esta orden de compra; no se puede cerrar. Verifique.";
                return FALSE;
            }
        }

        // --- 3. Validación de Flujo de Estatus (Solo si el estatus está cambiando) ---
        if ($rsold["estatus"] != $rsnew["estatus"]) {
            $flujo_valido = TRUE;
            $mensaje_error = "";
            switch ($rsnew["estatus"]) {
                case "PROCESO":
                    // Solo se puede pasar a PROCESO desde NUEVO
                    if ($rsold["estatus"] != "NUEVO") {
                        $flujo_valido = FALSE;
                    }
                    break;
                case "CERRADO":
                    // Solo se puede pasar a CERRADO desde PROCESO
                    if ($rsold["estatus"] != "PROCESO") {
                        $flujo_valido = FALSE;
                    }
                    break;
                case "NUEVO":
                    // No se puede volver al estatus NUEVO (A menos que sea por un flujo específico, que aquí se prohíbe)
                    $flujo_valido = FALSE; 
                    break;
                // Otros estatus (e.g., ANULADO) deberían ser manejados aquí si tienen reglas específicas.
                // Si el estatus es ANULADO, asumimos que no hay restricciones de estado previo.
            }
            if (!$flujo_valido) {
                $this->CancelMessage = "El cambio de estatus de **" . $rsold["estatus"] . "** a **" . $rsnew["estatus"] . "** no está permitido en el flujo de trabajo.";
                return FALSE;
            }
        }

        // --- 4. Asignación Final de Auditoría ---

        // Siempre se actualiza el usuario que intenta modificar
        $rsnew["username_estatus"] = CurrentUserName(); 

        // Si el estatus es CERRADO o ANULADO, se registra la fecha de aprobación/cierre/anulación
        if ($rsnew["estatus"] == "CERRADO" || $rsnew["estatus"] == "ANULADO") {
            $rsnew["fecha_aprobacion"] = date("Y-m-d");
        }
        return TRUE;
    }
    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
        // Solo si el estatus realmente cambió
        if ($rsold["estatus"] != $rsnew["estatus"]) {
            // ID de la Orden de Compra (se asume que es numérico)
            $norden_compra = intval($rsold["Norden_compra"] ?? 0); 

            // Estatus anterior y nuevo (se sanitizan para el mensaje)
            $estatus_old_safe = adjustSql($rsold["estatus"] ?? 'N/A');
            $estatus_new_safe = adjustSql($rsnew["estatus"] ?? 'N/A');

            // Nombre del usuario actual
            $usuario_safe = adjustSql(CurrentUserName());

            // Construir la nota
            $nota = "SE HIZO CAMBIO DE ESTATUS: " . $estatus_old_safe . " => " . $estatus_new_safe;
            $nota_safe = adjustSql($nota); // Sanitizar la nota final por si contiene comillas

            // 2. Insertar la bitácora usando valores sanitizados
            $sql = "
                INSERT INTO sco_nota_orden_compra
                    (Nnota_orden_compra, orden_compra, nota, usuario, fecha)
                VALUES 
                    (NULL, $norden_compra, 
                    '$nota_safe',
                    '$usuario_safe', NOW())
            ";

            // Ejecutar la inserción solo si el ID de la orden es válido
            if ($norden_compra > 0) {
                Execute($sql);
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
    public function rowDeleting(&$rs) {
    	// Enter your code here
    	// To cancel, set return value to False
    	if($rs["estatus"]=="CERRADO" or $rs["estatus"]=="ANULADO") {
    		$this->CancelMessage = "La Orden de Compra est&aacute; cerrada o anulada; no se puede eliminar.";
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
    public function rowRendering() {
    	// Enter your code here	
    	$color = "";
    	if ($this->PageID == "list" || $this->PageID == "view" || $this->PageID == "edit") { // List/View page only
    		switch($this->estatus->CurrentValue) {
    		case "NUEVO":
    			$color = "RED";
    			break;
    		case "PROCESO":
    			$color = "YELLOW";
    			break;
    		case "CERRADO":
    			$color = "GREEN";
    			break;
    		case "ANULADO":
    			$color = "BLACK";
    			break;
    		}
    		$style = "background-color: $color"; 	
    		$this->estatus->CellAttrs["style"] = $style;
    		$this->Norden_compra->CellAttrs["style"] = $style;
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
