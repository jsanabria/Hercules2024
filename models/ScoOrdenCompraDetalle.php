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
 * Table class for sco_orden_compra_detalle
 */
class ScoOrdenCompraDetalle extends DbTable
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
    public $Norden_compra_detalle;
    public $orden_compra;
    public $tipo_insumo;
    public $articulo;
    public $unidad_medida;
    public $cantidad;
    public $descripcion;
    public $imagen;
    public $disponible;
    public $unidad_medida_recibida;
    public $cantidad_recibida;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_orden_compra_detalle";
        $this->TableName = 'sco_orden_compra_detalle';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_orden_compra_detalle";
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
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // Norden_compra_detalle
        $this->Norden_compra_detalle = new DbField(
            $this, // Table
            'x_Norden_compra_detalle', // Variable name
            'Norden_compra_detalle', // Name
            '`Norden_compra_detalle`', // Expression
            '`Norden_compra_detalle`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Norden_compra_detalle`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Norden_compra_detalle->InputTextType = "text";
        $this->Norden_compra_detalle->Raw = true;
        $this->Norden_compra_detalle->IsAutoIncrement = true; // Autoincrement field
        $this->Norden_compra_detalle->IsPrimaryKey = true; // Primary key field
        $this->Norden_compra_detalle->Nullable = false; // NOT NULL field
        $this->Norden_compra_detalle->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Norden_compra_detalle->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Norden_compra_detalle'] = &$this->Norden_compra_detalle;

        // orden_compra
        $this->orden_compra = new DbField(
            $this, // Table
            'x_orden_compra', // Variable name
            'orden_compra', // Name
            '`orden_compra`', // Expression
            '`orden_compra`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`orden_compra`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->orden_compra->InputTextType = "text";
        $this->orden_compra->Raw = true;
        $this->orden_compra->IsForeignKey = true; // Foreign key field
        $this->orden_compra->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->orden_compra->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['orden_compra'] = &$this->orden_compra;

        // tipo_insumo
        $this->tipo_insumo = new DbField(
            $this, // Table
            'x_tipo_insumo', // Variable name
            'tipo_insumo', // Name
            '`tipo_insumo`', // Expression
            '`tipo_insumo`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_insumo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo_insumo->addMethod("getSelectFilter", fn() => "`codigo` = '037'");
        $this->tipo_insumo->InputTextType = "text";
        $this->tipo_insumo->Required = true; // Required field
        $this->tipo_insumo->setSelectMultiple(false); // Select one
        $this->tipo_insumo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_insumo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo_insumo->Lookup = new Lookup($this->tipo_insumo, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], ["x_articulo"], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->tipo_insumo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo_insumo'] = &$this->tipo_insumo;

        // articulo
        $this->articulo = new DbField(
            $this, // Table
            'x_articulo', // Variable name
            'articulo', // Name
            '`articulo`', // Expression
            '`articulo`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`articulo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->articulo->InputTextType = "text";
        $this->articulo->Required = true; // Required field
        $this->articulo->setSelectMultiple(false); // Select one
        $this->articulo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->articulo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->articulo->Lookup = new Lookup($this->articulo, 'sco_articulo', false, 'descripcion', ["descripcion","","",""], '', '', ["x_tipo_insumo"], [], ["tipo_insumo"], ["x_tipo_insumo"], [], [], false, '`descripcion` ASC', '', "`descripcion`");
        $this->articulo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['articulo'] = &$this->articulo;

        // unidad_medida
        $this->unidad_medida = new DbField(
            $this, // Table
            'x_unidad_medida', // Variable name
            'unidad_medida', // Name
            '`unidad_medida`', // Expression
            '`unidad_medida`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`unidad_medida`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->unidad_medida->addMethod("getSelectFilter", fn() => "`codigo` = '038'");
        $this->unidad_medida->InputTextType = "text";
        $this->unidad_medida->Required = true; // Required field
        $this->unidad_medida->setSelectMultiple(false); // Select one
        $this->unidad_medida->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->unidad_medida->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->unidad_medida->Lookup = new Lookup($this->unidad_medida, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`valor1`");
        $this->unidad_medida->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['unidad_medida'] = &$this->unidad_medida;

        // cantidad
        $this->cantidad = new DbField(
            $this, // Table
            'x_cantidad', // Variable name
            'cantidad', // Name
            '`cantidad`', // Expression
            '`cantidad`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cantidad`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cantidad->InputTextType = "text";
        $this->cantidad->Raw = true;
        $this->cantidad->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->cantidad->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['cantidad'] = &$this->cantidad;

        // descripcion
        $this->descripcion = new DbField(
            $this, // Table
            'x_descripcion', // Variable name
            'descripcion', // Name
            '`descripcion`', // Expression
            '`descripcion`', // Basic search expression
            200, // Type
            60, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`descripcion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->descripcion->InputTextType = "text";
        $this->descripcion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['descripcion'] = &$this->descripcion;

        // imagen
        $this->imagen = new DbField(
            $this, // Table
            'x_imagen', // Variable name
            'imagen', // Name
            '`imagen`', // Expression
            '`imagen`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`imagen`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'IMAGE', // View Tag
            'FILE' // Edit Tag
        );
        $this->imagen->InputTextType = "text";
        $this->imagen->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['imagen'] = &$this->imagen;

        // disponible
        $this->disponible = new DbField(
            $this, // Table
            'x_disponible', // Variable name
            'disponible', // Name
            '`disponible`', // Expression
            '`disponible`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`disponible`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->disponible->addMethod("getDefault", fn() => "N");
        $this->disponible->InputTextType = "text";
        $this->disponible->Raw = true;
        $this->disponible->setSelectMultiple(false); // Select one
        $this->disponible->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->disponible->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->disponible->Lookup = new Lookup($this->disponible, 'sco_orden_compra_detalle', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->disponible->OptionCount = 2;
        $this->disponible->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['disponible'] = &$this->disponible;

        // unidad_medida_recibida
        $this->unidad_medida_recibida = new DbField(
            $this, // Table
            'x_unidad_medida_recibida', // Variable name
            'unidad_medida_recibida', // Name
            '`unidad_medida_recibida`', // Expression
            '`unidad_medida_recibida`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`unidad_medida_recibida`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->unidad_medida_recibida->addMethod("getSelectFilter", fn() => "`codigo` = '038'");
        $this->unidad_medida_recibida->InputTextType = "text";
        $this->unidad_medida_recibida->setSelectMultiple(false); // Select one
        $this->unidad_medida_recibida->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->unidad_medida_recibida->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->unidad_medida_recibida->Lookup = new Lookup($this->unidad_medida_recibida, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`descripcion` ASC', '', "`valor1`");
        $this->unidad_medida_recibida->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['unidad_medida_recibida'] = &$this->unidad_medida_recibida;

        // cantidad_recibida
        $this->cantidad_recibida = new DbField(
            $this, // Table
            'x_cantidad_recibida', // Variable name
            'cantidad_recibida', // Name
            '`cantidad_recibida`', // Expression
            '`cantidad_recibida`', // Basic search expression
            4, // Type
            12, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cantidad_recibida`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cantidad_recibida->InputTextType = "text";
        $this->cantidad_recibida->Raw = true;
        $this->cantidad_recibida->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->cantidad_recibida->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['cantidad_recibida'] = &$this->cantidad_recibida;

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
        if ($this->getCurrentMasterTable() == "sco_orden_compra") {
            $masterTable = Container("sco_orden_compra");
            if ($this->orden_compra->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->Norden_compra, $this->orden_compra->getSessionValue(), $masterTable->Norden_compra->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "sco_orden_compra") {
            $masterTable = Container("sco_orden_compra");
            if ($this->orden_compra->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->orden_compra, $this->orden_compra->getSessionValue(), $masterTable->Norden_compra->DataType, $this->Dbid);
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
            case "sco_orden_compra":
                $key = $keys["orden_compra"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->Norden_compra->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->Norden_compra, $keys["orden_compra"], $this->orden_compra->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "sco_orden_compra":
                return GetKeyFilter($this->orden_compra, $masterTable->Norden_compra->DbValue, $masterTable->Norden_compra->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_orden_compra_detalle";
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
            $this->Norden_compra_detalle->setDbValue($conn->lastInsertId());
            $rs['Norden_compra_detalle'] = $this->Norden_compra_detalle->DbValue;
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
            if (!isset($rs['Norden_compra_detalle']) && !EmptyValue($this->Norden_compra_detalle->CurrentValue)) {
                $rs['Norden_compra_detalle'] = $this->Norden_compra_detalle->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Norden_compra_detalle';
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
            if (array_key_exists('Norden_compra_detalle', $rs)) {
                AddFilter($where, QuotedName('Norden_compra_detalle', $this->Dbid) . '=' . QuotedValue($rs['Norden_compra_detalle'], $this->Norden_compra_detalle->DataType, $this->Dbid));
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
        $this->Norden_compra_detalle->DbValue = $row['Norden_compra_detalle'];
        $this->orden_compra->DbValue = $row['orden_compra'];
        $this->tipo_insumo->DbValue = $row['tipo_insumo'];
        $this->articulo->DbValue = $row['articulo'];
        $this->unidad_medida->DbValue = $row['unidad_medida'];
        $this->cantidad->DbValue = $row['cantidad'];
        $this->descripcion->DbValue = $row['descripcion'];
        $this->imagen->Upload->DbValue = $row['imagen'];
        $this->disponible->DbValue = $row['disponible'];
        $this->unidad_medida_recibida->DbValue = $row['unidad_medida_recibida'];
        $this->cantidad_recibida->DbValue = $row['cantidad_recibida'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['imagen']) ? [] : [$row['imagen']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->imagen->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->imagen->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Norden_compra_detalle` = @Norden_compra_detalle@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Norden_compra_detalle->CurrentValue : $this->Norden_compra_detalle->OldValue;
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
                $this->Norden_compra_detalle->CurrentValue = $keys[0];
            } else {
                $this->Norden_compra_detalle->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Norden_compra_detalle', $row) ? $row['Norden_compra_detalle'] : null;
        } else {
            $val = !EmptyValue($this->Norden_compra_detalle->OldValue) && !$current ? $this->Norden_compra_detalle->OldValue : $this->Norden_compra_detalle->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Norden_compra_detalle@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoOrdenCompraDetalleList");
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
            "ScoOrdenCompraDetalleView" => $Language->phrase("View"),
            "ScoOrdenCompraDetalleEdit" => $Language->phrase("Edit"),
            "ScoOrdenCompraDetalleAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoOrdenCompraDetalleList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoOrdenCompraDetalleView",
            Config("API_ADD_ACTION") => "ScoOrdenCompraDetalleAdd",
            Config("API_EDIT_ACTION") => "ScoOrdenCompraDetalleEdit",
            Config("API_DELETE_ACTION") => "ScoOrdenCompraDetalleDelete",
            Config("API_LIST_ACTION") => "ScoOrdenCompraDetalleList",
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
        return "ScoOrdenCompraDetalleList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoOrdenCompraDetalleView", $parm);
        } else {
            $url = $this->keyUrl("ScoOrdenCompraDetalleView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoOrdenCompraDetalleAdd?" . $parm;
        } else {
            $url = "ScoOrdenCompraDetalleAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoOrdenCompraDetalleEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoOrdenCompraDetalleList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoOrdenCompraDetalleAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoOrdenCompraDetalleList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoOrdenCompraDetalleDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "sco_orden_compra" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_Norden_compra", $this->orden_compra->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Norden_compra_detalle\":" . VarToJson($this->Norden_compra_detalle->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Norden_compra_detalle->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Norden_compra_detalle->CurrentValue);
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
            if (($keyValue = Param("Norden_compra_detalle") ?? Route("Norden_compra_detalle")) !== null) {
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
                $this->Norden_compra_detalle->CurrentValue = $key;
            } else {
                $this->Norden_compra_detalle->OldValue = $key;
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
        $this->Norden_compra_detalle->setDbValue($row['Norden_compra_detalle']);
        $this->orden_compra->setDbValue($row['orden_compra']);
        $this->tipo_insumo->setDbValue($row['tipo_insumo']);
        $this->articulo->setDbValue($row['articulo']);
        $this->unidad_medida->setDbValue($row['unidad_medida']);
        $this->cantidad->setDbValue($row['cantidad']);
        $this->descripcion->setDbValue($row['descripcion']);
        $this->imagen->Upload->DbValue = $row['imagen'];
        $this->disponible->setDbValue($row['disponible']);
        $this->unidad_medida_recibida->setDbValue($row['unidad_medida_recibida']);
        $this->cantidad_recibida->setDbValue($row['cantidad_recibida']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoOrdenCompraDetalleList";
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

        // Norden_compra_detalle

        // orden_compra

        // tipo_insumo

        // articulo

        // unidad_medida

        // cantidad

        // descripcion

        // imagen

        // disponible

        // unidad_medida_recibida

        // cantidad_recibida

        // Norden_compra_detalle
        $this->Norden_compra_detalle->ViewValue = $this->Norden_compra_detalle->CurrentValue;

        // orden_compra
        $this->orden_compra->ViewValue = $this->orden_compra->CurrentValue;

        // tipo_insumo
        $curVal = strval($this->tipo_insumo->CurrentValue);
        if ($curVal != "") {
            $this->tipo_insumo->ViewValue = $this->tipo_insumo->lookupCacheOption($curVal);
            if ($this->tipo_insumo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_insumo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_insumo->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_insumo->ViewValue = $this->tipo_insumo->displayValue($arwrk);
                } else {
                    $this->tipo_insumo->ViewValue = $this->tipo_insumo->CurrentValue;
                }
            }
        } else {
            $this->tipo_insumo->ViewValue = null;
        }

        // articulo
        $curVal = strval($this->articulo->CurrentValue);
        if ($curVal != "") {
            $this->articulo->ViewValue = $this->articulo->lookupCacheOption($curVal);
            if ($this->articulo->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $curVal, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                $sqlWrk = $this->articulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                    $this->articulo->ViewValue = $this->articulo->displayValue($arwrk);
                } else {
                    $this->articulo->ViewValue = $this->articulo->CurrentValue;
                }
            }
        } else {
            $this->articulo->ViewValue = null;
        }

        // unidad_medida
        $curVal = strval($this->unidad_medida->CurrentValue);
        if ($curVal != "") {
            $this->unidad_medida->ViewValue = $this->unidad_medida->lookupCacheOption($curVal);
            if ($this->unidad_medida->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unidad_medida->Lookup->renderViewRow($rswrk[0]);
                    $this->unidad_medida->ViewValue = $this->unidad_medida->displayValue($arwrk);
                } else {
                    $this->unidad_medida->ViewValue = $this->unidad_medida->CurrentValue;
                }
            }
        } else {
            $this->unidad_medida->ViewValue = null;
        }

        // cantidad
        $this->cantidad->ViewValue = $this->cantidad->CurrentValue;
        $this->cantidad->ViewValue = FormatNumber($this->cantidad->ViewValue, $this->cantidad->formatPattern());

        // descripcion
        $this->descripcion->ViewValue = $this->descripcion->CurrentValue;

        // imagen
        if (!EmptyValue($this->imagen->Upload->DbValue)) {
            $this->imagen->ImageWidth = 120;
            $this->imagen->ImageHeight = 120;
            $this->imagen->ImageAlt = $this->imagen->alt();
            $this->imagen->ImageCssClass = "ew-image";
            $this->imagen->ViewValue = $this->imagen->Upload->DbValue;
        } else {
            $this->imagen->ViewValue = "";
        }

        // disponible
        if (strval($this->disponible->CurrentValue) != "") {
            $this->disponible->ViewValue = $this->disponible->optionCaption($this->disponible->CurrentValue);
        } else {
            $this->disponible->ViewValue = null;
        }

        // unidad_medida_recibida
        $curVal = strval($this->unidad_medida_recibida->CurrentValue);
        if ($curVal != "") {
            $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->lookupCacheOption($curVal);
            if ($this->unidad_medida_recibida->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida_recibida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->unidad_medida_recibida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida_recibida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unidad_medida_recibida->Lookup->renderViewRow($rswrk[0]);
                    $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->displayValue($arwrk);
                } else {
                    $this->unidad_medida_recibida->ViewValue = $this->unidad_medida_recibida->CurrentValue;
                }
            }
        } else {
            $this->unidad_medida_recibida->ViewValue = null;
        }

        // cantidad_recibida
        $this->cantidad_recibida->ViewValue = $this->cantidad_recibida->CurrentValue;
        $this->cantidad_recibida->ViewValue = FormatNumber($this->cantidad_recibida->ViewValue, $this->cantidad_recibida->formatPattern());

        // Norden_compra_detalle
        $this->Norden_compra_detalle->HrefValue = "";
        $this->Norden_compra_detalle->TooltipValue = "";

        // orden_compra
        $this->orden_compra->HrefValue = "";
        $this->orden_compra->TooltipValue = "";

        // tipo_insumo
        $this->tipo_insumo->HrefValue = "";
        $this->tipo_insumo->TooltipValue = "";

        // articulo
        $this->articulo->HrefValue = "";
        $this->articulo->TooltipValue = "";

        // unidad_medida
        $this->unidad_medida->HrefValue = "";
        $this->unidad_medida->TooltipValue = "";

        // cantidad
        $this->cantidad->HrefValue = "";
        $this->cantidad->TooltipValue = "";

        // descripcion
        $this->descripcion->HrefValue = "";
        $this->descripcion->TooltipValue = "";

        // imagen
        if (!EmptyValue($this->imagen->Upload->DbValue)) {
            $this->imagen->HrefValue = GetFileUploadUrl($this->imagen, $this->imagen->htmlDecode($this->imagen->Upload->DbValue)); // Add prefix/suffix
            $this->imagen->LinkAttrs["target"] = "_blank"; // Add target
            if ($this->isExport()) {
                $this->imagen->HrefValue = FullUrl($this->imagen->HrefValue, "href");
            }
        } else {
            $this->imagen->HrefValue = "";
        }
        $this->imagen->ExportHrefValue = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
        $this->imagen->TooltipValue = "";
        if ($this->imagen->UseColorbox) {
            if (EmptyValue($this->imagen->TooltipValue)) {
                $this->imagen->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->imagen->LinkAttrs["data-rel"] = "sco_orden_compra_detalle_x_imagen";
            $this->imagen->LinkAttrs->appendClass("ew-lightbox");
        }

        // disponible
        $this->disponible->HrefValue = "";
        $this->disponible->TooltipValue = "";

        // unidad_medida_recibida
        $this->unidad_medida_recibida->HrefValue = "";
        $this->unidad_medida_recibida->TooltipValue = "";

        // cantidad_recibida
        $this->cantidad_recibida->HrefValue = "";
        $this->cantidad_recibida->TooltipValue = "";

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

        // Norden_compra_detalle
        $this->Norden_compra_detalle->setupEditAttributes();
        $this->Norden_compra_detalle->EditValue = $this->Norden_compra_detalle->CurrentValue;

        // orden_compra
        $this->orden_compra->setupEditAttributes();
        if ($this->orden_compra->getSessionValue() != "") {
            $this->orden_compra->CurrentValue = GetForeignKeyValue($this->orden_compra->getSessionValue());
            $this->orden_compra->ViewValue = $this->orden_compra->CurrentValue;
        } else {
            $this->orden_compra->EditValue = $this->orden_compra->CurrentValue;
            $this->orden_compra->PlaceHolder = RemoveHtml($this->orden_compra->caption());
            if (strval($this->orden_compra->EditValue) != "" && is_numeric($this->orden_compra->EditValue)) {
                $this->orden_compra->EditValue = $this->orden_compra->EditValue;
            }
        }

        // tipo_insumo
        $this->tipo_insumo->setupEditAttributes();
        $curVal = strval($this->tipo_insumo->CurrentValue);
        if ($curVal != "") {
            $this->tipo_insumo->EditValue = $this->tipo_insumo->lookupCacheOption($curVal);
            if ($this->tipo_insumo->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_insumo->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->tipo_insumo->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_insumo->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_insumo->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_insumo->EditValue = $this->tipo_insumo->displayValue($arwrk);
                } else {
                    $this->tipo_insumo->EditValue = $this->tipo_insumo->CurrentValue;
                }
            }
        } else {
            $this->tipo_insumo->EditValue = null;
        }

        // articulo
        $this->articulo->setupEditAttributes();
        $curVal = strval($this->articulo->CurrentValue);
        if ($curVal != "") {
            $this->articulo->EditValue = $this->articulo->lookupCacheOption($curVal);
            if ($this->articulo->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->articulo->Lookup->getTable()->Fields["descripcion"]->searchExpression(), "=", $curVal, $this->articulo->Lookup->getTable()->Fields["descripcion"]->searchDataType(), "");
                $sqlWrk = $this->articulo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->articulo->Lookup->renderViewRow($rswrk[0]);
                    $this->articulo->EditValue = $this->articulo->displayValue($arwrk);
                } else {
                    $this->articulo->EditValue = $this->articulo->CurrentValue;
                }
            }
        } else {
            $this->articulo->EditValue = null;
        }

        // unidad_medida
        $this->unidad_medida->setupEditAttributes();
        $curVal = strval($this->unidad_medida->CurrentValue);
        if ($curVal != "") {
            $this->unidad_medida->EditValue = $this->unidad_medida->lookupCacheOption($curVal);
            if ($this->unidad_medida->EditValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->unidad_medida->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->unidad_medida->getSelectFilter($this); // PHP
                $sqlWrk = $this->unidad_medida->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->unidad_medida->Lookup->renderViewRow($rswrk[0]);
                    $this->unidad_medida->EditValue = $this->unidad_medida->displayValue($arwrk);
                } else {
                    $this->unidad_medida->EditValue = $this->unidad_medida->CurrentValue;
                }
            }
        } else {
            $this->unidad_medida->EditValue = null;
        }

        // cantidad
        $this->cantidad->setupEditAttributes();
        $this->cantidad->EditValue = $this->cantidad->CurrentValue;
        $this->cantidad->EditValue = FormatNumber($this->cantidad->EditValue, $this->cantidad->formatPattern());

        // descripcion
        $this->descripcion->setupEditAttributes();
        $this->descripcion->EditValue = $this->descripcion->CurrentValue;

        // imagen
        $this->imagen->setupEditAttributes();
        if (!EmptyValue($this->imagen->Upload->DbValue)) {
            $this->imagen->ImageWidth = 120;
            $this->imagen->ImageHeight = 120;
            $this->imagen->ImageAlt = $this->imagen->alt();
            $this->imagen->ImageCssClass = "ew-image";
            $this->imagen->EditValue = $this->imagen->Upload->DbValue;
        } else {
            $this->imagen->EditValue = "";
        }

        // disponible
        $this->disponible->setupEditAttributes();
        $this->disponible->EditValue = $this->disponible->options(true);
        $this->disponible->PlaceHolder = RemoveHtml($this->disponible->caption());

        // unidad_medida_recibida
        $this->unidad_medida_recibida->setupEditAttributes();
        $this->unidad_medida_recibida->PlaceHolder = RemoveHtml($this->unidad_medida_recibida->caption());

        // cantidad_recibida
        $this->cantidad_recibida->setupEditAttributes();
        $this->cantidad_recibida->EditValue = $this->cantidad_recibida->CurrentValue;
        $this->cantidad_recibida->PlaceHolder = RemoveHtml($this->cantidad_recibida->caption());
        if (strval($this->cantidad_recibida->EditValue) != "" && is_numeric($this->cantidad_recibida->EditValue)) {
            $this->cantidad_recibida->EditValue = FormatNumber($this->cantidad_recibida->EditValue, null);
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
                    $doc->exportCaption($this->tipo_insumo);
                    $doc->exportCaption($this->articulo);
                    $doc->exportCaption($this->unidad_medida);
                    $doc->exportCaption($this->cantidad);
                    $doc->exportCaption($this->descripcion);
                    $doc->exportCaption($this->imagen);
                    $doc->exportCaption($this->disponible);
                    $doc->exportCaption($this->unidad_medida_recibida);
                    $doc->exportCaption($this->cantidad_recibida);
                } else {
                    $doc->exportCaption($this->Norden_compra_detalle);
                    $doc->exportCaption($this->orden_compra);
                    $doc->exportCaption($this->tipo_insumo);
                    $doc->exportCaption($this->articulo);
                    $doc->exportCaption($this->unidad_medida);
                    $doc->exportCaption($this->cantidad);
                    $doc->exportCaption($this->descripcion);
                    $doc->exportCaption($this->imagen);
                    $doc->exportCaption($this->disponible);
                    $doc->exportCaption($this->unidad_medida_recibida);
                    $doc->exportCaption($this->cantidad_recibida);
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
                        $doc->exportField($this->tipo_insumo);
                        $doc->exportField($this->articulo);
                        $doc->exportField($this->unidad_medida);
                        $doc->exportField($this->cantidad);
                        $doc->exportField($this->descripcion);
                        $doc->exportField($this->imagen);
                        $doc->exportField($this->disponible);
                        $doc->exportField($this->unidad_medida_recibida);
                        $doc->exportField($this->cantidad_recibida);
                    } else {
                        $doc->exportField($this->Norden_compra_detalle);
                        $doc->exportField($this->orden_compra);
                        $doc->exportField($this->tipo_insumo);
                        $doc->exportField($this->articulo);
                        $doc->exportField($this->unidad_medida);
                        $doc->exportField($this->cantidad);
                        $doc->exportField($this->descripcion);
                        $doc->exportField($this->imagen);
                        $doc->exportField($this->disponible);
                        $doc->exportField($this->unidad_medida_recibida);
                        $doc->exportField($this->cantidad_recibida);
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
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'imagen') {
            $fldName = "imagen";
            $fileNameFld = "imagen";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->Norden_compra_detalle->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DataType::BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower($pathinfo["extension"] ?? "");
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment" . ($DownloadFileName ? "; filename=\"" . $DownloadFileName . "\"" : ""));
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    if ($fld->hasMethod("getUploadPath")) { // Check field level upload path
                        $fld->UploadPath = $fld->getUploadPath();
                    }
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Write audit trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_orden_compra_detalle');
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
        $key .= $rs['Norden_compra_detalle'];

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
                WriteAuditLog($usr, "A", 'sco_orden_compra_detalle', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Norden_compra_detalle'];

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
                    WriteAuditLog($usr, "U", 'sco_orden_compra_detalle', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Norden_compra_detalle'];

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
                WriteAuditLog($usr, "D", 'sco_orden_compra_detalle', $fldname, $key, $oldvalue);
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
    	$sql = "SELECT estatus FROM sco_orden_compra WHERE Norden_compra = " . $rsold["orden_compra"] . ";";
    	if(ExecuteScalar($sql) == "CERRADO") {
    		$this->CancelMessage = "La orden est&aacute; CERRADA; Verifique.";
    		return FALSE;
    	}
    	if(intval($rsnew["cantidad_recibida"]) >= 0 and trim($rsnew["unidad_medida_recibida"]) == "")
    		$rsnew["unidad_medida_recibida"] = $rsold["unidad_medida"];
    	if(($rsold["estatus"] != $rsnew["estatus"]) and ($rsnew["estatus"] == "CERRADO")) {
    		$sql = "SELECT
    					COUNT(Norden_compra_detalle) AS cantidad
    				FROM sco_orden_compra_detalle
    				WHERE orden_compra = " . $rsold["orden_compra"] . " AND cantidad_recibida IS NULL;";
    		$cantidad = ExecuteScalar($sql);
    		if($cantidad > 0) {
    			$this->CancelMessage = "Hay art&iacute;culos pendientes por recibir en esta orden de compra; Verifique.";
    			return FALSE;
    		}
    	}
    	if($rsold["estatus"]=="CERRADO" or $rsold["estatus"]=="ANULADO") {
    		$levelid = CurrentUserLevel();
    		if($levelid == -1) {
    			$rsnew["username_estatus"] = CurrentUserName();
    			$rsnew["fecha_aprobacion"] = date("Y-m-d");
    			return TRUE;
    		}
    		else {
    			$this->CancelMessage = "La Orden de Compra est&aacute; cerrada o anulada; no se puede modificar.";
    			return FALSE;
    		}
    	}
    	if($rsold["estatus"] != $rsnew["estatus"]) {
    		switch($rsnew["estatus"]) {
    		case "PROCESO":
    			if($rsold["estatus"] != "NUEVO") {
    				$this->CancelMessage = "El nuevo estatus " . $rsnew["estatus"] . " no aplica para esta orden";
    				return FALSE;
    			}
    			break;
    		case "CERRADO":
    			if($rsold["estatus"] != "PROCESO") {
    				$this->CancelMessage = "El nuevo estatus " . $rsnew["estatus"] . " no aplica para esta orden";;
    				return FALSE;
    			}
    			break;
    		case "NUEVO":
    			$this->CancelMessage = "El nuevo estatus " . $rsnew["estatus"] . " no aplica para esta orden";;
    			return FALSE;
    			break;
    		}
    	}
    	$rsnew["username_estatus"] = CurrentUserName();
    	if($rsnew["estatus"]=="CERRADO" or $rsnew["estatus"]=="ANULADO") $rsnew["fecha_aprobacion"] = date("Y-m-d");
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
