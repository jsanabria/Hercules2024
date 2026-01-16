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
 * Table class for view_expediente
 */
class ViewExpediente extends DbTable
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
    public $Nexpediente;
    public $cedula_fallecido;
    public $nombre_fallecido;
    public $apellidos_fallecido;
    public $permiso;
    public $capilla;
    public $fecha_inicio;
    public $hora_inicio;
    public $fecha_fin;
    public $hora_fin;
    public $servicio;
    public $fecha_serv;
    public $hora_serv;
    public $espera_cenizas;
    public $hora_fin_capilla;
    public $hora_fin_servicio;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "view_expediente";
        $this->TableName = 'view_expediente';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_expediente";
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

        // Nexpediente
        $this->Nexpediente = new DbField(
            $this, // Table
            'x_Nexpediente', // Variable name
            'Nexpediente', // Name
            '`Nexpediente`', // Expression
            '`Nexpediente`', // Basic search expression
            20, // Type
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
        $this->Nexpediente->InputTextType = "text";
        $this->Nexpediente->Raw = true;
        $this->Nexpediente->IsAutoIncrement = true; // Autoincrement field
        $this->Nexpediente->IsPrimaryKey = true; // Primary key field
        $this->Nexpediente->Nullable = false; // NOT NULL field
        $this->Nexpediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nexpediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nexpediente'] = &$this->Nexpediente;

        // cedula_fallecido
        $this->cedula_fallecido = new DbField(
            $this, // Table
            'x_cedula_fallecido', // Variable name
            'cedula_fallecido', // Name
            '`cedula_fallecido`', // Expression
            '`cedula_fallecido`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cedula_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cedula_fallecido->InputTextType = "text";
        $this->cedula_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cedula_fallecido'] = &$this->cedula_fallecido;

        // nombre_fallecido
        $this->nombre_fallecido = new DbField(
            $this, // Table
            'x_nombre_fallecido', // Variable name
            'nombre_fallecido', // Name
            '`nombre_fallecido`', // Expression
            '`nombre_fallecido`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nombre_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nombre_fallecido->InputTextType = "text";
        $this->nombre_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nombre_fallecido'] = &$this->nombre_fallecido;

        // apellidos_fallecido
        $this->apellidos_fallecido = new DbField(
            $this, // Table
            'x_apellidos_fallecido', // Variable name
            'apellidos_fallecido', // Name
            '`apellidos_fallecido`', // Expression
            '`apellidos_fallecido`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`apellidos_fallecido`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->apellidos_fallecido->InputTextType = "text";
        $this->apellidos_fallecido->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['apellidos_fallecido'] = &$this->apellidos_fallecido;

        // permiso
        $this->permiso = new DbField(
            $this, // Table
            'x_permiso', // Variable name
            'permiso', // Name
            '`permiso`', // Expression
            '`permiso`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`permiso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->permiso->InputTextType = "text";
        $this->permiso->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['permiso'] = &$this->permiso;

        // capilla
        $this->capilla = new DbField(
            $this, // Table
            'x_capilla', // Variable name
            'capilla', // Name
            '`capilla`', // Expression
            '`capilla`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`capilla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->capilla->InputTextType = "text";
        $this->capilla->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['capilla'] = &$this->capilla;

        // fecha_inicio
        $this->fecha_inicio = new DbField(
            $this, // Table
            'x_fecha_inicio', // Variable name
            'fecha_inicio', // Name
            '`fecha_inicio`', // Expression
            CastDateFieldForLike("`fecha_inicio`", 0, "DB"), // Basic search expression
            135, // Type
            76, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_inicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_inicio->InputTextType = "text";
        $this->fecha_inicio->Raw = true;
        $this->fecha_inicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_inicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_inicio'] = &$this->fecha_inicio;

        // hora_inicio
        $this->hora_inicio = new DbField(
            $this, // Table
            'x_hora_inicio', // Variable name
            'hora_inicio', // Name
            '`hora_inicio`', // Expression
            '`hora_inicio`', // Basic search expression
            200, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_inicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_inicio->InputTextType = "text";
        $this->hora_inicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_inicio'] = &$this->hora_inicio;

        // fecha_fin
        $this->fecha_fin = new DbField(
            $this, // Table
            'x_fecha_fin', // Variable name
            'fecha_fin', // Name
            '`fecha_fin`', // Expression
            CastDateFieldForLike("`fecha_fin`", 0, "DB"), // Basic search expression
            135, // Type
            76, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_fin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_fin->InputTextType = "text";
        $this->fecha_fin->Raw = true;
        $this->fecha_fin->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_fin->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_fin'] = &$this->fecha_fin;

        // hora_fin
        $this->hora_fin = new DbField(
            $this, // Table
            'x_hora_fin', // Variable name
            'hora_fin', // Name
            '`hora_fin`', // Expression
            '`hora_fin`', // Basic search expression
            200, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_fin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_fin->InputTextType = "text";
        $this->hora_fin->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_fin'] = &$this->hora_fin;

        // servicio
        $this->servicio = new DbField(
            $this, // Table
            'x_servicio', // Variable name
            'servicio', // Name
            '`servicio`', // Expression
            '`servicio`', // Basic search expression
            200, // Type
            150, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->servicio->InputTextType = "text";
        $this->servicio->setSelectMultiple(false); // Select one
        $this->servicio->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->servicio->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->servicio->Lookup = new Lookup($this->servicio, 'view_expediente', true, 'servicio', ["servicio","","",""], '', '', [], [], [], [], [], [], false, '`servicio` ASC', '', "`servicio`");
        $this->servicio->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['servicio'] = &$this->servicio;

        // fecha_serv
        $this->fecha_serv = new DbField(
            $this, // Table
            'x_fecha_serv', // Variable name
            'fecha_serv', // Name
            '`fecha_serv`', // Expression
            CastDateFieldForLike("`fecha_serv`", 0, "DB"), // Basic search expression
            135, // Type
            76, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_serv`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_serv->InputTextType = "text";
        $this->fecha_serv->Raw = true;
        $this->fecha_serv->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_serv->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_serv'] = &$this->fecha_serv;

        // hora_serv
        $this->hora_serv = new DbField(
            $this, // Table
            'x_hora_serv', // Variable name
            'hora_serv', // Name
            '`hora_serv`', // Expression
            '`hora_serv`', // Basic search expression
            200, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_serv`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_serv->InputTextType = "text";
        $this->hora_serv->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_serv'] = &$this->hora_serv;

        // espera_cenizas
        $this->espera_cenizas = new DbField(
            $this, // Table
            'x_espera_cenizas', // Variable name
            'espera_cenizas', // Name
            '`espera_cenizas`', // Expression
            '`espera_cenizas`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`espera_cenizas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->espera_cenizas->addMethod("getDefault", fn() => "N");
        $this->espera_cenizas->InputTextType = "text";
        $this->espera_cenizas->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['espera_cenizas'] = &$this->espera_cenizas;

        // hora_fin_capilla
        $this->hora_fin_capilla = new DbField(
            $this, // Table
            'x_hora_fin_capilla', // Variable name
            'hora_fin_capilla', // Name
            '`hora_fin_capilla`', // Expression
            CastDateFieldForLike("`hora_fin_capilla`", 0, "DB"), // Basic search expression
            134, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_fin_capilla`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_fin_capilla->InputTextType = "text";
        $this->hora_fin_capilla->Raw = true;
        $this->hora_fin_capilla->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_fin_capilla->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_fin_capilla'] = &$this->hora_fin_capilla;

        // hora_fin_servicio
        $this->hora_fin_servicio = new DbField(
            $this, // Table
            'x_hora_fin_servicio', // Variable name
            'hora_fin_servicio', // Name
            '`hora_fin_servicio`', // Expression
            CastDateFieldForLike("`hora_fin_servicio`", 0, "DB"), // Basic search expression
            134, // Type
            40, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`hora_fin_servicio`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->hora_fin_servicio->InputTextType = "text";
        $this->hora_fin_servicio->Raw = true;
        $this->hora_fin_servicio->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_FORMAT"], $Language->phrase("IncorrectTime"));
        $this->hora_fin_servicio->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['hora_fin_servicio'] = &$this->hora_fin_servicio;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_expediente";
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
            $this->Nexpediente->setDbValue($conn->lastInsertId());
            $rs['Nexpediente'] = $this->Nexpediente->DbValue;
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
            if (!isset($rs['Nexpediente']) && !EmptyValue($this->Nexpediente->CurrentValue)) {
                $rs['Nexpediente'] = $this->Nexpediente->CurrentValue;
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
        $this->Nexpediente->DbValue = $row['Nexpediente'];
        $this->cedula_fallecido->DbValue = $row['cedula_fallecido'];
        $this->nombre_fallecido->DbValue = $row['nombre_fallecido'];
        $this->apellidos_fallecido->DbValue = $row['apellidos_fallecido'];
        $this->permiso->DbValue = $row['permiso'];
        $this->capilla->DbValue = $row['capilla'];
        $this->fecha_inicio->DbValue = $row['fecha_inicio'];
        $this->hora_inicio->DbValue = $row['hora_inicio'];
        $this->fecha_fin->DbValue = $row['fecha_fin'];
        $this->hora_fin->DbValue = $row['hora_fin'];
        $this->servicio->DbValue = $row['servicio'];
        $this->fecha_serv->DbValue = $row['fecha_serv'];
        $this->hora_serv->DbValue = $row['hora_serv'];
        $this->espera_cenizas->DbValue = $row['espera_cenizas'];
        $this->hora_fin_capilla->DbValue = $row['hora_fin_capilla'];
        $this->hora_fin_servicio->DbValue = $row['hora_fin_servicio'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nexpediente` = @Nexpediente@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
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
        if (count($keys) == 1) {
            if ($current) {
                $this->Nexpediente->CurrentValue = $keys[0];
            } else {
                $this->Nexpediente->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
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
        return $_SESSION[$name] ?? GetUrl("ViewExpedienteList");
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
            "ViewExpedienteView" => $Language->phrase("View"),
            "ViewExpedienteEdit" => $Language->phrase("Edit"),
            "ViewExpedienteAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewExpedienteList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewExpedienteView",
            Config("API_ADD_ACTION") => "ViewExpedienteAdd",
            Config("API_EDIT_ACTION") => "ViewExpedienteEdit",
            Config("API_DELETE_ACTION") => "ViewExpedienteDelete",
            Config("API_LIST_ACTION") => "ViewExpedienteList",
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
        return "ViewExpedienteList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewExpedienteView", $parm);
        } else {
            $url = $this->keyUrl("ViewExpedienteView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewExpedienteAdd?" . $parm;
        } else {
            $url = "ViewExpedienteAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewExpedienteEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewExpedienteList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewExpedienteAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewExpedienteList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewExpedienteDelete", $parm);
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
        $json .= "\"Nexpediente\":" . VarToJson($this->Nexpediente->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nexpediente->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nexpediente->CurrentValue);
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
            if (($keyValue = Param("Nexpediente") ?? Route("Nexpediente")) !== null) {
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
                $this->Nexpediente->CurrentValue = $key;
            } else {
                $this->Nexpediente->OldValue = $key;
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
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->permiso->setDbValue($row['permiso']);
        $this->capilla->setDbValue($row['capilla']);
        $this->fecha_inicio->setDbValue($row['fecha_inicio']);
        $this->hora_inicio->setDbValue($row['hora_inicio']);
        $this->fecha_fin->setDbValue($row['fecha_fin']);
        $this->hora_fin->setDbValue($row['hora_fin']);
        $this->servicio->setDbValue($row['servicio']);
        $this->fecha_serv->setDbValue($row['fecha_serv']);
        $this->hora_serv->setDbValue($row['hora_serv']);
        $this->espera_cenizas->setDbValue($row['espera_cenizas']);
        $this->hora_fin_capilla->setDbValue($row['hora_fin_capilla']);
        $this->hora_fin_servicio->setDbValue($row['hora_fin_servicio']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewExpedienteList";
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

        // Nexpediente

        // cedula_fallecido

        // nombre_fallecido

        // apellidos_fallecido

        // permiso

        // capilla

        // fecha_inicio

        // hora_inicio

        // fecha_fin

        // hora_fin

        // servicio

        // fecha_serv

        // hora_serv

        // espera_cenizas

        // hora_fin_capilla

        // hora_fin_servicio

        // Nexpediente
        $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

        // cedula_fallecido
        $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

        // nombre_fallecido
        $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

        // apellidos_fallecido
        $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

        // permiso
        $this->permiso->ViewValue = $this->permiso->CurrentValue;

        // capilla
        $this->capilla->ViewValue = $this->capilla->CurrentValue;

        // fecha_inicio
        $this->fecha_inicio->ViewValue = $this->fecha_inicio->CurrentValue;
        $this->fecha_inicio->ViewValue = FormatDateTime($this->fecha_inicio->ViewValue, $this->fecha_inicio->formatPattern());

        // hora_inicio
        $this->hora_inicio->ViewValue = $this->hora_inicio->CurrentValue;

        // fecha_fin
        $this->fecha_fin->ViewValue = $this->fecha_fin->CurrentValue;
        $this->fecha_fin->ViewValue = FormatDateTime($this->fecha_fin->ViewValue, $this->fecha_fin->formatPattern());

        // hora_fin
        $this->hora_fin->ViewValue = $this->hora_fin->CurrentValue;

        // servicio
        $this->servicio->ViewValue = $this->servicio->CurrentValue;

        // fecha_serv
        $this->fecha_serv->ViewValue = $this->fecha_serv->CurrentValue;
        $this->fecha_serv->ViewValue = FormatDateTime($this->fecha_serv->ViewValue, $this->fecha_serv->formatPattern());

        // hora_serv
        $this->hora_serv->ViewValue = $this->hora_serv->CurrentValue;

        // espera_cenizas
        $this->espera_cenizas->ViewValue = $this->espera_cenizas->CurrentValue;

        // hora_fin_capilla
        $this->hora_fin_capilla->ViewValue = $this->hora_fin_capilla->CurrentValue;

        // hora_fin_servicio
        $this->hora_fin_servicio->ViewValue = $this->hora_fin_servicio->CurrentValue;

        // Nexpediente
        $this->Nexpediente->HrefValue = "";
        $this->Nexpediente->TooltipValue = "";

        // cedula_fallecido
        $this->cedula_fallecido->HrefValue = "";
        $this->cedula_fallecido->TooltipValue = "";

        // nombre_fallecido
        $this->nombre_fallecido->HrefValue = "";
        $this->nombre_fallecido->TooltipValue = "";

        // apellidos_fallecido
        $this->apellidos_fallecido->HrefValue = "";
        $this->apellidos_fallecido->TooltipValue = "";

        // permiso
        $this->permiso->HrefValue = "";
        $this->permiso->TooltipValue = "";

        // capilla
        $this->capilla->HrefValue = "";
        $this->capilla->TooltipValue = "";

        // fecha_inicio
        $this->fecha_inicio->HrefValue = "";
        $this->fecha_inicio->TooltipValue = "";

        // hora_inicio
        $this->hora_inicio->HrefValue = "";
        $this->hora_inicio->TooltipValue = "";

        // fecha_fin
        $this->fecha_fin->HrefValue = "";
        $this->fecha_fin->TooltipValue = "";

        // hora_fin
        $this->hora_fin->HrefValue = "";
        $this->hora_fin->TooltipValue = "";

        // servicio
        $this->servicio->HrefValue = "";
        $this->servicio->TooltipValue = "";

        // fecha_serv
        $this->fecha_serv->HrefValue = "";
        $this->fecha_serv->TooltipValue = "";

        // hora_serv
        $this->hora_serv->HrefValue = "";
        $this->hora_serv->TooltipValue = "";

        // espera_cenizas
        $this->espera_cenizas->HrefValue = "";
        $this->espera_cenizas->TooltipValue = "";

        // hora_fin_capilla
        $this->hora_fin_capilla->HrefValue = "";
        $this->hora_fin_capilla->TooltipValue = "";

        // hora_fin_servicio
        $this->hora_fin_servicio->HrefValue = "";
        $this->hora_fin_servicio->TooltipValue = "";

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

        // Nexpediente
        $this->Nexpediente->setupEditAttributes();
        $this->Nexpediente->EditValue = $this->Nexpediente->CurrentValue;

        // cedula_fallecido
        $this->cedula_fallecido->setupEditAttributes();
        if (!$this->cedula_fallecido->Raw) {
            $this->cedula_fallecido->CurrentValue = HtmlDecode($this->cedula_fallecido->CurrentValue);
        }
        $this->cedula_fallecido->EditValue = $this->cedula_fallecido->CurrentValue;
        $this->cedula_fallecido->PlaceHolder = RemoveHtml($this->cedula_fallecido->caption());

        // nombre_fallecido
        $this->nombre_fallecido->setupEditAttributes();
        if (!$this->nombre_fallecido->Raw) {
            $this->nombre_fallecido->CurrentValue = HtmlDecode($this->nombre_fallecido->CurrentValue);
        }
        $this->nombre_fallecido->EditValue = $this->nombre_fallecido->CurrentValue;
        $this->nombre_fallecido->PlaceHolder = RemoveHtml($this->nombre_fallecido->caption());

        // apellidos_fallecido
        $this->apellidos_fallecido->setupEditAttributes();
        if (!$this->apellidos_fallecido->Raw) {
            $this->apellidos_fallecido->CurrentValue = HtmlDecode($this->apellidos_fallecido->CurrentValue);
        }
        $this->apellidos_fallecido->EditValue = $this->apellidos_fallecido->CurrentValue;
        $this->apellidos_fallecido->PlaceHolder = RemoveHtml($this->apellidos_fallecido->caption());

        // permiso
        $this->permiso->setupEditAttributes();
        if (!$this->permiso->Raw) {
            $this->permiso->CurrentValue = HtmlDecode($this->permiso->CurrentValue);
        }
        $this->permiso->EditValue = $this->permiso->CurrentValue;
        $this->permiso->PlaceHolder = RemoveHtml($this->permiso->caption());

        // capilla
        $this->capilla->setupEditAttributes();
        if (!$this->capilla->Raw) {
            $this->capilla->CurrentValue = HtmlDecode($this->capilla->CurrentValue);
        }
        $this->capilla->EditValue = $this->capilla->CurrentValue;
        $this->capilla->PlaceHolder = RemoveHtml($this->capilla->caption());

        // fecha_inicio
        $this->fecha_inicio->setupEditAttributes();
        $this->fecha_inicio->EditValue = FormatDateTime($this->fecha_inicio->CurrentValue, $this->fecha_inicio->formatPattern());
        $this->fecha_inicio->PlaceHolder = RemoveHtml($this->fecha_inicio->caption());

        // hora_inicio
        $this->hora_inicio->setupEditAttributes();
        if (!$this->hora_inicio->Raw) {
            $this->hora_inicio->CurrentValue = HtmlDecode($this->hora_inicio->CurrentValue);
        }
        $this->hora_inicio->EditValue = $this->hora_inicio->CurrentValue;
        $this->hora_inicio->PlaceHolder = RemoveHtml($this->hora_inicio->caption());

        // fecha_fin
        $this->fecha_fin->setupEditAttributes();
        $this->fecha_fin->EditValue = FormatDateTime($this->fecha_fin->CurrentValue, $this->fecha_fin->formatPattern());
        $this->fecha_fin->PlaceHolder = RemoveHtml($this->fecha_fin->caption());

        // hora_fin
        $this->hora_fin->setupEditAttributes();
        if (!$this->hora_fin->Raw) {
            $this->hora_fin->CurrentValue = HtmlDecode($this->hora_fin->CurrentValue);
        }
        $this->hora_fin->EditValue = $this->hora_fin->CurrentValue;
        $this->hora_fin->PlaceHolder = RemoveHtml($this->hora_fin->caption());

        // servicio
        $this->servicio->setupEditAttributes();
        $this->servicio->PlaceHolder = RemoveHtml($this->servicio->caption());

        // fecha_serv
        $this->fecha_serv->setupEditAttributes();
        $this->fecha_serv->EditValue = FormatDateTime($this->fecha_serv->CurrentValue, $this->fecha_serv->formatPattern());
        $this->fecha_serv->PlaceHolder = RemoveHtml($this->fecha_serv->caption());

        // hora_serv
        $this->hora_serv->setupEditAttributes();
        if (!$this->hora_serv->Raw) {
            $this->hora_serv->CurrentValue = HtmlDecode($this->hora_serv->CurrentValue);
        }
        $this->hora_serv->EditValue = $this->hora_serv->CurrentValue;
        $this->hora_serv->PlaceHolder = RemoveHtml($this->hora_serv->caption());

        // espera_cenizas
        $this->espera_cenizas->setupEditAttributes();
        if (!$this->espera_cenizas->Raw) {
            $this->espera_cenizas->CurrentValue = HtmlDecode($this->espera_cenizas->CurrentValue);
        }
        $this->espera_cenizas->EditValue = $this->espera_cenizas->CurrentValue;
        $this->espera_cenizas->PlaceHolder = RemoveHtml($this->espera_cenizas->caption());

        // hora_fin_capilla
        $this->hora_fin_capilla->setupEditAttributes();
        $this->hora_fin_capilla->EditValue = $this->hora_fin_capilla->CurrentValue;
        $this->hora_fin_capilla->PlaceHolder = RemoveHtml($this->hora_fin_capilla->caption());

        // hora_fin_servicio
        $this->hora_fin_servicio->setupEditAttributes();
        $this->hora_fin_servicio->EditValue = $this->hora_fin_servicio->CurrentValue;
        $this->hora_fin_servicio->PlaceHolder = RemoveHtml($this->hora_fin_servicio->caption());

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
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->capilla);
                    $doc->exportCaption($this->fecha_inicio);
                    $doc->exportCaption($this->hora_inicio);
                    $doc->exportCaption($this->fecha_fin);
                    $doc->exportCaption($this->hora_fin);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->fecha_serv);
                    $doc->exportCaption($this->hora_serv);
                } else {
                    $doc->exportCaption($this->Nexpediente);
                    $doc->exportCaption($this->cedula_fallecido);
                    $doc->exportCaption($this->nombre_fallecido);
                    $doc->exportCaption($this->apellidos_fallecido);
                    $doc->exportCaption($this->permiso);
                    $doc->exportCaption($this->capilla);
                    $doc->exportCaption($this->fecha_inicio);
                    $doc->exportCaption($this->hora_inicio);
                    $doc->exportCaption($this->fecha_fin);
                    $doc->exportCaption($this->hora_fin);
                    $doc->exportCaption($this->servicio);
                    $doc->exportCaption($this->fecha_serv);
                    $doc->exportCaption($this->hora_serv);
                    $doc->exportCaption($this->espera_cenizas);
                    $doc->exportCaption($this->hora_fin_capilla);
                    $doc->exportCaption($this->hora_fin_servicio);
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
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->capilla);
                        $doc->exportField($this->fecha_inicio);
                        $doc->exportField($this->hora_inicio);
                        $doc->exportField($this->fecha_fin);
                        $doc->exportField($this->hora_fin);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->fecha_serv);
                        $doc->exportField($this->hora_serv);
                    } else {
                        $doc->exportField($this->Nexpediente);
                        $doc->exportField($this->cedula_fallecido);
                        $doc->exportField($this->nombre_fallecido);
                        $doc->exportField($this->apellidos_fallecido);
                        $doc->exportField($this->permiso);
                        $doc->exportField($this->capilla);
                        $doc->exportField($this->fecha_inicio);
                        $doc->exportField($this->hora_inicio);
                        $doc->exportField($this->fecha_fin);
                        $doc->exportField($this->hora_fin);
                        $doc->exportField($this->servicio);
                        $doc->exportField($this->fecha_serv);
                        $doc->exportField($this->hora_serv);
                        $doc->exportField($this->espera_cenizas);
                        $doc->exportField($this->hora_fin_capilla);
                        $doc->exportField($this->hora_fin_servicio);
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
