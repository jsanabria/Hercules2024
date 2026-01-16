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
 * Table class for view_oficio_religioso
 */
class ViewOficioReligioso extends DbTable
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
    public $Nexpediente;
    public $cedula;
    public $nombre;
    public $apellido;
    public $servicio;
    public $servicio2;
    public $ministro;
    public $servicio_atendido;
    public $fecha_servicio;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_oficio_religioso";
        $this->TableName = 'view_oficio_religioso';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_oficio_religioso";
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
        $this->Norden->addMethod("getDefault", fn() => 0);
        $this->Norden->InputTextType = "text";
        $this->Norden->Raw = true;
        $this->Norden->IsPrimaryKey = true; // Primary key field
        $this->Norden->Nullable = false; // NOT NULL field
        $this->Norden->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Norden->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Norden'] = &$this->Norden;

        // Nexpediente
        $this->Nexpediente = new DbField(
            $this, // Table
            'x_Nexpediente', // Variable name
            'Nexpediente', // Name
            '`Nexpediente`', // Expression
            '`Nexpediente`', // Basic search expression
            21, // Type
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
        $this->Nexpediente->addMethod("getLinkPrefix", fn() => "ScoExpedienteList?id_exp=");
        $this->Nexpediente->InputTextType = "text";
        $this->Nexpediente->Raw = true;
        $this->Nexpediente->IsPrimaryKey = true; // Primary key field
        $this->Nexpediente->Nullable = false; // NOT NULL field
        $this->Nexpediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nexpediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nexpediente'] = &$this->Nexpediente;

        // cedula
        $this->cedula = new DbField(
            $this, // Table
            'x_cedula', // Variable name
            'cedula', // Name
            '`cedula`', // Expression
            '`cedula`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula->InputTextType = "text";
        $this->cedula->Required = true; // Required field
        $this->cedula->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cedula->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula'] = &$this->cedula;

        // nombre
        $this->nombre = new DbField(
            $this, // Table
            'x_nombre', // Variable name
            'nombre', // Name
            '`nombre`', // Expression
            '`nombre`', // Basic search expression
            200, // Type
            50, // Size
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
        $this->nombre->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre'] = &$this->nombre;

        // apellido
        $this->apellido = new DbField(
            $this, // Table
            'x_apellido', // Variable name
            'apellido', // Name
            '`apellido`', // Expression
            '`apellido`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`apellido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->apellido->InputTextType = "text";
        $this->apellido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['apellido'] = &$this->apellido;

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

        // servicio2
        $this->servicio2 = new DbField(
            $this, // Table
            'x_servicio2', // Variable name
            'servicio2', // Name
            '`servicio2`', // Expression
            '`servicio2`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicio2`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->servicio2->InputTextType = "text";
        $this->servicio2->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio2'] = &$this->servicio2;

        // ministro
        $this->ministro = new DbField(
            $this, // Table
            'x_ministro', // Variable name
            'ministro', // Name
            '`ministro`', // Expression
            '`ministro`', // Basic search expression
            200, // Type
            25, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ministro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->ministro->addMethod("getSelectFilter", fn() => "cargo = 'MINISTRO'");
        $this->ministro->InputTextType = "text";
        $this->ministro->setSelectMultiple(false); // Select one
        $this->ministro->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ministro->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->ministro->Lookup = new Lookup($this->ministro, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '`nombre`', '', "`nombre`");
        $this->ministro->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['ministro'] = &$this->ministro;

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
            'SELECT' // Edit Tag
        );
        $this->servicio_atendido->addMethod("getDefault", fn() => "N");
        $this->servicio_atendido->InputTextType = "text";
        $this->servicio_atendido->Required = true; // Required field
        $this->servicio_atendido->setSelectMultiple(false); // Select one
        $this->servicio_atendido->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio_atendido->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio_atendido->Lookup = new Lookup($this->servicio_atendido, 'view_oficio_religioso', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->servicio_atendido->OptionCount = 2;
        $this->servicio_atendido->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio_atendido'] = &$this->servicio_atendido;

        // fecha_servicio
        $this->fecha_servicio = new DbField(
            $this, // Table
            'x_fecha_servicio', // Variable name
            'fecha_servicio', // Name
            '`fecha_servicio`', // Expression
            CastDateFieldForLike("`fecha_servicio`", 7, "DB"), // Basic search expression
            135, // Type
            19, // Size
            7, // Date/Time format
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
        $this->fecha_servicio->DefaultErrorMessage = str_replace("%s", DateFormat(7), $Language->phrase("IncorrectDate"));
        $this->fecha_servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_servicio'] = &$this->fecha_servicio;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_oficio_religioso";
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
            if (array_key_exists('Norden', $rs)) {
                AddFilter($where, QuotedName('Norden', $this->Dbid) . '=' . QuotedValue($rs['Norden'], $this->Norden->DataType, $this->Dbid));
            }
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
        $this->Norden->DbValue = $row['Norden'];
        $this->Nexpediente->DbValue = $row['Nexpediente'];
        $this->cedula->DbValue = $row['cedula'];
        $this->nombre->DbValue = $row['nombre'];
        $this->apellido->DbValue = $row['apellido'];
        $this->servicio->DbValue = $row['servicio'];
        $this->servicio2->DbValue = $row['servicio2'];
        $this->ministro->DbValue = $row['ministro'];
        $this->servicio_atendido->DbValue = $row['servicio_atendido'];
        $this->fecha_servicio->DbValue = $row['fecha_servicio'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Norden` = @Norden@ AND `Nexpediente` = @Nexpediente@";
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
        if (count($keys) == 2) {
            if ($current) {
                $this->Norden->CurrentValue = $keys[0];
            } else {
                $this->Norden->OldValue = $keys[0];
            }
            if ($current) {
                $this->Nexpediente->CurrentValue = $keys[1];
            } else {
                $this->Nexpediente->OldValue = $keys[1];
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
        return $_SESSION[$name] ?? GetUrl("ViewOficioReligiosoList");
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
            "ViewOficioReligiosoView" => $Language->phrase("View"),
            "ViewOficioReligiosoEdit" => $Language->phrase("Edit"),
            "ViewOficioReligiosoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewOficioReligiosoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewOficioReligiosoView",
            Config("API_ADD_ACTION") => "ViewOficioReligiosoAdd",
            Config("API_EDIT_ACTION") => "ViewOficioReligiosoEdit",
            Config("API_DELETE_ACTION") => "ViewOficioReligiosoDelete",
            Config("API_LIST_ACTION") => "ViewOficioReligiosoList",
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
        return "ViewOficioReligiosoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewOficioReligiosoView", $parm);
        } else {
            $url = $this->keyUrl("ViewOficioReligiosoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewOficioReligiosoAdd?" . $parm;
        } else {
            $url = "ViewOficioReligiosoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewOficioReligiosoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewOficioReligiosoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewOficioReligiosoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewOficioReligiosoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewOficioReligiosoDelete", $parm);
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
        $json .= ",\"Nexpediente\":" . VarToJson($this->Nexpediente->CurrentValue, "number");
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
        if ($this->Nexpediente->CurrentValue !== null) {
            $url .= $this->RouteCompositeKeySeparator . $this->encodeKeyValue($this->Nexpediente->CurrentValue);
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
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            $isApi = IsApi();
            $keyValues = $isApi
                ? (Route(0) == "export"
                    ? array_map(fn ($i) => Route($i + 3), range(0, 1))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, 1))) // Other API
                : []; // Non-API
            if (($keyValue = Param("Norden") ?? Route("Norden")) !== null) {
                $arKey[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(0) ?? $keyValues[0] ?? null) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("Nexpediente") ?? Route("Nexpediente")) !== null) {
                $arKey[] = $keyValue;
            } elseif ($isApi && (($keyValue = Key(1) ?? $keyValues[1] ?? null) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            $arKeys[] = $arKey;
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 2) {
                    continue; // Just skip so other keys will still work
                }
                if (!is_numeric($key[0])) { // Norden
                    continue;
                }
                if (!is_numeric($key[1])) { // Nexpediente
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
                $this->Norden->CurrentValue = $key[0];
            } else {
                $this->Norden->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->Nexpediente->CurrentValue = $key[1];
            } else {
                $this->Nexpediente->OldValue = $key[1];
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
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->cedula->setDbValue($row['cedula']);
        $this->nombre->setDbValue($row['nombre']);
        $this->apellido->setDbValue($row['apellido']);
        $this->servicio->setDbValue($row['servicio']);
        $this->servicio2->setDbValue($row['servicio2']);
        $this->ministro->setDbValue($row['ministro']);
        $this->servicio_atendido->setDbValue($row['servicio_atendido']);
        $this->fecha_servicio->setDbValue($row['fecha_servicio']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewOficioReligiosoList";
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

        // Nexpediente

        // cedula

        // nombre

        // apellido

        // servicio

        // servicio2

        // ministro

        // servicio_atendido

        // fecha_servicio

        // Norden
        $this->Norden->ViewValue = $this->Norden->CurrentValue;

        // Nexpediente
        $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

        // cedula
        $this->cedula->ViewValue = $this->cedula->CurrentValue;

        // nombre
        $this->nombre->ViewValue = $this->nombre->CurrentValue;

        // apellido
        $this->apellido->ViewValue = $this->apellido->CurrentValue;

        // servicio
        $this->servicio->ViewValue = $this->servicio->CurrentValue;

        // servicio2
        $this->servicio2->ViewValue = $this->servicio2->CurrentValue;

        // ministro
        $curVal = strval($this->ministro->CurrentValue);
        if ($curVal != "") {
            $this->ministro->ViewValue = $this->ministro->lookupCacheOption($curVal);
            if ($this->ministro->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->ministro->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->ministro->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $lookupFilter = $this->ministro->getSelectFilter($this); // PHP
                $sqlWrk = $this->ministro->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->ministro->Lookup->renderViewRow($rswrk[0]);
                    $this->ministro->ViewValue = $this->ministro->displayValue($arwrk);
                } else {
                    $this->ministro->ViewValue = $this->ministro->CurrentValue;
                }
            }
        } else {
            $this->ministro->ViewValue = null;
        }

        // servicio_atendido
        if (strval($this->servicio_atendido->CurrentValue) != "") {
            $this->servicio_atendido->ViewValue = $this->servicio_atendido->optionCaption($this->servicio_atendido->CurrentValue);
        } else {
            $this->servicio_atendido->ViewValue = null;
        }
        $this->servicio_atendido->CssClass = "fw-bold fst-italic";

        // fecha_servicio
        $this->fecha_servicio->ViewValue = $this->fecha_servicio->CurrentValue;
        $this->fecha_servicio->ViewValue = FormatDateTime($this->fecha_servicio->ViewValue, $this->fecha_servicio->formatPattern());

        // Norden
        $this->Norden->HrefValue = "";
        $this->Norden->TooltipValue = "";

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

        // cedula
        $this->cedula->HrefValue = "";
        $this->cedula->TooltipValue = "";

        // nombre
        $this->nombre->HrefValue = "";
        $this->nombre->TooltipValue = "";

        // apellido
        $this->apellido->HrefValue = "";
        $this->apellido->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // servicio2
        $this->servicio2->HrefValue = "";
        $this->servicio2->TooltipValue = "";

        // ministro
        $this->ministro->HrefValue = "";
        $this->ministro->TooltipValue = "";

        // servicio_atendido
        $this->servicio_atendido->HrefValue = "";
        $this->servicio_atendido->TooltipValue = "";

        // fecha_servicio
        $this->fecha_servicio->HrefValue = "";
        $this->fecha_servicio->TooltipValue = "";

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
        $this->Norden->PlaceHolder = RemoveHtml($this->Norden->caption());

        // Nexpediente
        $this->Nexpediente->setupEditAttributes();
        $this->Nexpediente->EditValue = $this->Nexpediente->CurrentValue;
        $this->Nexpediente->PlaceHolder = RemoveHtml($this->Nexpediente->caption());

        // cedula
        $this->cedula->setupEditAttributes();
        $this->cedula->EditValue = $this->cedula->CurrentValue;

        // nombre
        $this->nombre->setupEditAttributes();
        $this->nombre->EditValue = $this->nombre->CurrentValue;

        // apellido
        $this->apellido->setupEditAttributes();
        $this->apellido->EditValue = $this->apellido->CurrentValue;

        // servicio
        $this->servicio->setupEditAttributes();
        if (!$this->servicio->Raw) {
            $this->servicio->CurrentValue = HtmlDecode($this->servicio->CurrentValue);
        }
        $this->servicio->EditValue = $this->servicio->CurrentValue;
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // servicio2
        $this->servicio2->setupEditAttributes();
        if (!$this->servicio2->Raw) {
            $this->servicio2->CurrentValue = HtmlDecode($this->servicio2->CurrentValue);
        }
        $this->servicio2->EditValue = $this->servicio2->CurrentValue;
        $this->servicio2->PlaceHolder = RemoveHtml($this->servicio2->caption());

        // ministro
        $this->ministro->setupEditAttributes();
        $this->ministro->PlaceHolder = RemoveHtml($this->ministro->caption());

        // servicio_atendido
        $this->servicio_atendido->setupEditAttributes();
        $this->servicio_atendido->EditValue = $this->servicio_atendido->options(true);
        $this->servicio_atendido->PlaceHolder = RemoveHtml($this->servicio_atendido->caption());

        // fecha_servicio
        $this->fecha_servicio->setupEditAttributes();
        $this->fecha_servicio->EditValue = $this->fecha_servicio->CurrentValue;
        $this->fecha_servicio->EditValue = FormatDateTime($this->fecha_servicio->EditValue, $this->fecha_servicio->formatPattern());

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
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->cedula);
                    $doc->exportCaption($this->nombre);
                    $doc->exportCaption($this->apellido);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->servicio2);
                    $doc->exportCaption($this->ministro);
                    $doc->exportCaption($this->servicio_atendido);
                    $doc->exportCaption($this->fecha_servicio);
                } else {
                    $doc->exportCaption($this->Norden);
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->cedula);
                    $doc->exportCaption($this->nombre);
                    $doc->exportCaption($this->apellido);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->servicio2);
                    $doc->exportCaption($this->ministro);
                    $doc->exportCaption($this->servicio_atendido);
                    $doc->exportCaption($this->fecha_servicio);
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
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->cedula);
                        $doc->exportField($this->nombre);
                        $doc->exportField($this->apellido);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->servicio2);
                        $doc->exportField($this->ministro);
                        $doc->exportField($this->servicio_atendido);
                        $doc->exportField($this->fecha_servicio);
                    } else {
                        $doc->exportField($this->Norden);
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->cedula);
                        $doc->exportField($this->nombre);
                        $doc->exportField($this->apellido);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->servicio2);
                        $doc->exportField($this->ministro);
                        $doc->exportField($this->servicio_atendido);
                        $doc->exportField($this->fecha_servicio);
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
    public function rowUpdating($rsold, &$rsnew) {
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	if($rsold["servicio_atendido"] != $rsnew["servicio_atendido"]) {
    		$nota = "";
    		switch($rsnew["servicio_atendido"]) {
    		case "S":
    			$nota = "PADRE REALIZO OFICIO RELIGIOSO";
    			break;
    		case "N":
    			$nota = "PADRE NO REALIZO OFICIO RELIGIOSO";
    			break;
    		}
    		$sql = "INSERT INTO sco_nota
    					(Nnota, expediente, nota, usuario, fecha)
    				VALUES (NULL, "  . $rsold["Nexpediente"] . ", '$nota',
    					'" . CurrentUserName() . "', NOW())";
    		Execute($sql);
    		$sql = "UPDATE sco_orden 
    				SET
    					servicio_atendido='" . $rsnew["servicio_atendido"] . "',
    					ministro = '" . $rsnew["ministro"] . "'
    				WHERE 
    					Norden = '" . $rsold["Norden"] . "'";
    		Execute($sql);
    	}
    	if(trim($_REQUEST["nota"]) != "") {
    		$nota = trim($_REQUEST["nota"]);
    		$sql = "INSERT INTO sco_nota
    					(Nnota, expediente, nota, usuario, fecha)
    				VALUES (NULL, "  . $rsold["Nexpediente"] . ", '$nota',
    					'" . CurrentUserName() . "', NOW())";
    		Execute($sql);
    	}
    	$this->setSuccessMessage("!!! Resgistro Guardado EXITOSAMENTE !!!"); 
    	return false;
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
    	//echo "Row Updated";
    	if($rsold["servicio_atendido"] != $rsnew["servicio_atendido"]) {
    		$nota = "";
    		switch($rsnew["servicio_atendido"]) {
    		case "S":
    			$nota = "PADRE REALIZO OFICIO RELIGIOSO";
    			break;
    		case "N":
    			$nota = "PADRE NO REALIZO OFICIO RELIGIOSO";
    			break;
    		}
    		$sql = "INSERT INTO sco_nota
    					(Nnota, expediente, nota, usuario, fecha)
    				VALUES (NULL, "  . $rsold["Nexpediente"] . ", '$nota',
    					'" . CurrentUserName() . "', NOW())";
    		Execute($sql);
    	}
    	if(trim($_REQUEST["nota"]) != "") {
    		$nota = trim($_REQUEST["nota"]);
    		$sql = "INSERT INTO sco_nota
    					(Nnota, expediente, nota, usuario, fecha)
    				VALUES (NULL, "  . $rsold["Nexpediente"] . ", '$nota',
    					'" . CurrentUserName() . "', NOW())";
    		Execute($sql);
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
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered() {
    	// To view properties of field class, use:
    	//var_dump($this-><FieldName>); 
    	if ($this->servicio_atendido->CurrentValue == "S") // List page only
    		$this->RowAttrs["class"] = "success";
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
