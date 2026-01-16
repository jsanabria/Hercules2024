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
 * Table class for view_reclamo_lapida
 */
class ViewReclamoLapida extends DbTable
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
    public $Nreclamo;
    public $solicitante;
    public $parentesco;
    public $ci_difunto;
    public $nombre_difunto;
    public $tipo;
    public $registro;
    public $registra;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_reclamo_lapida";
        $this->TableName = 'view_reclamo_lapida';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_reclamo_lapida";
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

        // Nreclamo
        $this->Nreclamo = new DbField(
            $this, // Table
            'x_Nreclamo', // Variable name
            'Nreclamo', // Name
            '`Nreclamo`', // Expression
            '`Nreclamo`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nreclamo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nreclamo->InputTextType = "text";
        $this->Nreclamo->Raw = true;
        $this->Nreclamo->IsAutoIncrement = true; // Autoincrement field
        $this->Nreclamo->IsPrimaryKey = true; // Primary key field
        $this->Nreclamo->Nullable = false; // NOT NULL field
        $this->Nreclamo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nreclamo->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nreclamo'] = &$this->Nreclamo;

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

        // registro
        $this->registro = new DbField(
            $this, // Table
            'x_registro', // Variable name
            'registro', // Name
            '`registro`', // Expression
            CastDateFieldForLike("`registro`", 7, "DB"), // Basic search expression
            135, // Type
            76, // Size
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_reclamo_lapida";
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
            $this->Nreclamo->setDbValue($conn->lastInsertId());
            $rs['Nreclamo'] = $this->Nreclamo->DbValue;
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
            if (!isset($rs['Nreclamo']) && !EmptyValue($this->Nreclamo->CurrentValue)) {
                $rs['Nreclamo'] = $this->Nreclamo->CurrentValue;
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
            if (array_key_exists('Nreclamo', $rs)) {
                AddFilter($where, QuotedName('Nreclamo', $this->Dbid) . '=' . QuotedValue($rs['Nreclamo'], $this->Nreclamo->DataType, $this->Dbid));
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
        $this->Nreclamo->DbValue = $row['Nreclamo'];
        $this->solicitante->DbValue = $row['solicitante'];
        $this->parentesco->DbValue = $row['parentesco'];
        $this->ci_difunto->DbValue = $row['ci_difunto'];
        $this->nombre_difunto->DbValue = $row['nombre_difunto'];
        $this->tipo->DbValue = $row['tipo'];
        $this->registro->DbValue = $row['registro'];
        $this->registra->DbValue = $row['registra'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nreclamo` = @Nreclamo@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nreclamo->CurrentValue : $this->Nreclamo->OldValue;
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
                $this->Nreclamo->CurrentValue = $keys[0];
            } else {
                $this->Nreclamo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nreclamo', $row) ? $row['Nreclamo'] : null;
        } else {
            $val = !EmptyValue($this->Nreclamo->OldValue) && !$current ? $this->Nreclamo->OldValue : $this->Nreclamo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nreclamo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ViewReclamoLapidaList");
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
            "ViewReclamoLapidaView" => $Language->phrase("View"),
            "ViewReclamoLapidaEdit" => $Language->phrase("Edit"),
            "ViewReclamoLapidaAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewReclamoLapidaList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewReclamoLapidaView",
            Config("API_ADD_ACTION") => "ViewReclamoLapidaAdd",
            Config("API_EDIT_ACTION") => "ViewReclamoLapidaEdit",
            Config("API_DELETE_ACTION") => "ViewReclamoLapidaDelete",
            Config("API_LIST_ACTION") => "ViewReclamoLapidaList",
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
        return "ViewReclamoLapidaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewReclamoLapidaView", $parm);
        } else {
            $url = $this->keyUrl("ViewReclamoLapidaView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewReclamoLapidaAdd?" . $parm;
        } else {
            $url = "ViewReclamoLapidaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewReclamoLapidaEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewReclamoLapidaList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewReclamoLapidaAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewReclamoLapidaList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewReclamoLapidaDelete", $parm);
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
        $json .= "\"Nreclamo\":" . VarToJson($this->Nreclamo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nreclamo->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nreclamo->CurrentValue);
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
            if (($keyValue = Param("Nreclamo") ?? Route("Nreclamo")) !== null) {
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
                $this->Nreclamo->CurrentValue = $key;
            } else {
                $this->Nreclamo->OldValue = $key;
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
        $this->Nreclamo->setDbValue($row['Nreclamo']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->parentesco->setDbValue($row['parentesco']);
        $this->ci_difunto->setDbValue($row['ci_difunto']);
        $this->nombre_difunto->setDbValue($row['nombre_difunto']);
        $this->tipo->setDbValue($row['tipo']);
        $this->registro->setDbValue($row['registro']);
        $this->registra->setDbValue($row['registra']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewReclamoLapidaList";
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

        // Nreclamo

        // solicitante

        // parentesco

        // ci_difunto

        // nombre_difunto

        // tipo

        // registro

        // registra

        // Nreclamo
        $this->Nreclamo->ViewValue = $this->Nreclamo->CurrentValue;

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

        // Nreclamo
        $this->Nreclamo->HrefValue = "";
        $this->Nreclamo->TooltipValue = "";

        // solicitante
        $this->solicitante->HrefValue = "";
        $this->solicitante->TooltipValue = "";

        // parentesco
        $this->parentesco->HrefValue = "";
        $this->parentesco->TooltipValue = "";

        // ci_difunto
        $this->ci_difunto->HrefValue = "";
        $this->ci_difunto->TooltipValue = "";

        // nombre_difunto
        $this->nombre_difunto->HrefValue = "";
        $this->nombre_difunto->TooltipValue = "";

        // tipo
        $this->tipo->HrefValue = "";
        $this->tipo->TooltipValue = "";

        // registro
        $this->registro->HrefValue = "";
        $this->registro->TooltipValue = "";

        // registra
        $this->registra->HrefValue = "";
        $this->registra->TooltipValue = "";

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

        // Nreclamo
        $this->Nreclamo->setupEditAttributes();
        $this->Nreclamo->EditValue = $this->Nreclamo->CurrentValue;

        // solicitante
        $this->solicitante->setupEditAttributes();
        $this->solicitante->EditValue = $this->solicitante->CurrentValue;

        // parentesco
        $this->parentesco->setupEditAttributes();
        $this->parentesco->PlaceHolder = RemoveHtml($this->parentesco->caption());

        // ci_difunto
        $this->ci_difunto->setupEditAttributes();
        $this->ci_difunto->EditValue = $this->ci_difunto->CurrentValue;

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

        // registro
        $this->registro->setupEditAttributes();
        $this->registro->EditValue = $this->registro->CurrentValue;
        $this->registro->EditValue = FormatDateTime($this->registro->EditValue, $this->registro->formatPattern());

        // registra
        $this->registra->setupEditAttributes();
        $curVal = strval($this->registra->CurrentValue);
        if ($curVal != "") {
            $this->registra->EditValue = $this->registra->lookupCacheOption($curVal);
            if ($this->registra->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->registra->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->registra->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->registra->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->registra->Lookup->renderViewRow($rswrk[0]);
                    $this->registra->EditValue = $this->registra->displayValue($arwrk);
                } else {
                    $this->registra->EditValue = $this->registra->CurrentValue;
                }
            }
        } else {
            $this->registra->EditValue = null;
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
                    $doc->exportCaption($this->Nreclamo);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->parentesco);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->nombre_difunto);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->registro);
                    $doc->exportCaption($this->registra);
                } else {
                    $doc->exportCaption($this->Nreclamo);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->ci_difunto);
                    $doc->exportCaption($this->nombre_difunto);
                    $doc->exportCaption($this->tipo);
                    $doc->exportCaption($this->registro);
                    $doc->exportCaption($this->registra);
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
                        $doc->exportField($this->Nreclamo);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->parentesco);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->nombre_difunto);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->registro);
                        $doc->exportField($this->registra);
                    } else {
                        $doc->exportField($this->Nreclamo);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->ci_difunto);
                        $doc->exportField($this->nombre_difunto);
                        $doc->exportField($this->tipo);
                        $doc->exportField($this->registro);
                        $doc->exportField($this->registra);
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

    public function rowUpdating($rsold, &$rsnew) {
        // 1. Definición de variables clave
        $nReclamo = $rsold["Nreclamo"];
        $usuarioActual = CurrentUserName();
        $fechaHoy = CurrentDateTime();

        // 2. Insertar en Registro de Lápidas usando los valores de $rsnew si cambiaron
        // Nota: Usamos los nombres de columnas de sco_reclamo en el SELECT
        $sqlInsert = "INSERT INTO sco_lapidas_registro
            (solicitante, parentesco, telefono1, telefono2, email, ci_difunto, nombre_difunto, tipo, comentario, estatus, registro, registra, seccion, modulo, sub_seccion, parcela, boveda, reclamo)
            SELECT 
                solicitante, 
                '" . str_replace("'", "''", $rsnew["parentesco"] ?? $rsold["parentesco"]) . "', 
                telefono1, telefono2, email, ci_difunto, nombre_difunto, 
                '" . str_replace("'", "''", $rsnew["tipo"] ?? $rsold["tipo"]) . "', 
                comentario, 'RECIBIDO', NOW(), '$usuarioActual', seccion, modulo, sub_seccion, parcela, boveda, Nreclamo
            FROM sco_reclamo WHERE Nreclamo = $nReclamo";
        Execute($sqlInsert);

        // 3. Obtener el ID recién creado de forma segura (evita MAX que falla en multiusuario)
        // En PHPMaker/MySQL lo ideal es usar Conn()->insert_id o una función de identidad
        $Nlapidas_registro = ExecuteScalar("SELECT LAST_INSERT_ID()");
        if (!$Nlapidas_registro) return FALSE; // Seguridad

        // 4. Migración de Notas y Adjuntos (Unificado)
        $sqlNotas = "INSERT INTO sco_lapidas_notas (lapida_registro, nota, usuario, fecha)
                     SELECT $Nlapidas_registro, nota, usuario, fecha 
                     FROM sco_reclamo_nota WHERE reclamo = $nReclamo";
        Execute($sqlNotas);
        $sqlAdjuntos = "INSERT INTO sco_lapidas_adjunto (lapida_registro, nota, archivo, usuario, fecha)
                        SELECT $Nlapidas_registro, nota, archivo, usuario, fecha 
                        FROM sco_reclamo_adjunto WHERE reclamo = $nReclamo";
        Execute($sqlAdjuntos);

        // 5. Nota de sistema
        $sqlLog = "INSERT INTO sco_lapidas_notas (lapida_registro, nota, usuario, fecha)
                   VALUES ($Nlapidas_registro, 'Reclamo WEB importado al módulo de lápidas', '$usuarioActual', '$fechaHoy')";
        Execute($sqlLog);

        // 6. Actualizar estatus del reclamo original
        Execute("UPDATE sco_reclamo SET estatus = 'PROCESANDO' WHERE Nreclamo = $nReclamo");

        // 7. Búsqueda y actualización de Contrato (Optimizado con Join)
        $sqlContrato = "UPDATE sco_lapidas_registro L
                    SET L.contrato = COALESCE((
                        SELECT P.contrato 
                        FROM sco_parcela P 
                        WHERE RTRIM(LTRIM(P.ci_difunto)) = RTRIM(LTRIM(REPLACE(REPLACE(REPLACE(REPLACE(L.ci_difunto, 'V-', ''), 'E-', ''), 'J-', ''), 'G-', '')))
                        LIMIT 1
                    ), '') 
                    WHERE L.Nlapidas_registro = $Nlapidas_registro";
        Execute($sqlContrato);
        return TRUE;
    }

    public function rowUpdated($rsold, $rsnew) {
        // 1. Obtener los datos del ticket recién creado en lápidas
        $nReclamo = $rsold["Nreclamo"];

        // Buscamos los datos necesarios cruzando con el reclamo
        $sql = "SELECT Nlapidas_registro, email, solicitante, tipo 
                FROM sco_lapidas_registro 
                WHERE reclamo = " . QuotedValue($nReclamo, \PHPMaker2024\hercules\DataType::NUMBER) . " 
                ORDER BY Nlapidas_registro DESC LIMIT 1";
        $row = ExecuteRow($sql);

        // 2. Validar que tengamos datos y un correo válido
        if ($row && !empty($row["email"])) {
            $to       = $row["email"];      
            $ticket   = $row["Nlapidas_registro"];
            $nombre   = $row["solicitante"];   
            $servicio = $row["tipo"];
            $fecha    = date("d/m/Y");

            // 3. Construcción del cuerpo del mensaje (HTML Inline)
            $cuerpo = "
            <div style='font-family: Calibri, sans-serif; font-size: 14px; color: #333;'>
                <p>Estimado(a) <b>$nombre</b>,</p>
                <p>Le informamos que su solicitud ha sido escalada con éxito al departamento de <b>MEMORIALIZACIÓN</b>.</p>
                <p><b>Detalles del Caso:</b></p>
                <ul>
                    <li><b>Número de Ticket:</b> #$ticket</li>
                    <li><b>Servicio:</b> $servicio</li>
                    <li><b>Fecha de Registro:</b> $fecha</li>
                    <li><b>Estatus:</b> <span style='color: #28a745;'>RECIBIDO</span></li>
                </ul>
                <p>Nuestro equipo procesará su requerimiento a la brevedad posible.</p>
                <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                <img src='http://cementeriodeleste.com.ve/images/samples/logo.png' alt='Cementerio del Este' width='200'>
                <br>
                <p><a href='http://cementeriodeleste.com.ve/' style='color: #0056b3; text-decoration: none;'>www.cementeriodeleste.com.ve</a></p>
            </div>";

            // 4. Preparar el arreglo para la función EnviarCorreo
            $configEmail = [
                'to'      => $to,
                'subject' => "Ticket de Atención #$ticket - Cementerio Del Este",
                'body'    => $cuerpo,
                // 'cc'   => "archivo@cementeriodeleste.com.ve" // Descomenta si necesitas copia
            ];

            // 5. Llamada a la función global
            try {
                EnviarCorreo($configEmail);
            } catch (Exception $e) {
                // Manejo de errores silencioso para no interrumpir el flujo de la web
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
