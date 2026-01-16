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
 * Table class for view_grama_pagos
 */
class ViewGramaPagos extends DbTable
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
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $expediente;
    public $registro_solicitud;
    public $solicitante;
    public $difunto;
    public $ubicacion;
    public $ctto_usd;
    public $tipo_pago;
    public $banco;
    public $ref;
    public $fecha_cobro;
    public $resgitro_pago;
    public $cta_destino;
    public $monto_bs;
    public $monto_usd;
    public $monto_ue;
    public $subtipo;
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
        $this->TableVar = "view_grama_pagos";
        $this->TableName = 'view_grama_pagos';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "view_grama_pagos";
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

        // expediente
        $this->expediente = new DbField(
            $this, // Table
            'x_expediente', // Variable name
            'expediente', // Name
            '`expediente`', // Expression
            '`expediente`', // Basic search expression
            21, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`expediente`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->expediente->addMethod("getDefault", fn() => 0);
        $this->expediente->InputTextType = "text";
        $this->expediente->Raw = true;
        $this->expediente->Nullable = false; // NOT NULL field
        $this->expediente->Required = true; // Required field
        $this->expediente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->expediente->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['expediente'] = &$this->expediente;

        // registro_solicitud
        $this->registro_solicitud = new DbField(
            $this, // Table
            'x_registro_solicitud', // Variable name
            'registro_solicitud', // Name
            '`registro_solicitud`', // Expression
            CastDateFieldForLike("`registro_solicitud`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`registro_solicitud`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->registro_solicitud->InputTextType = "text";
        $this->registro_solicitud->Raw = true;
        $this->registro_solicitud->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->registro_solicitud->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['registro_solicitud'] = &$this->registro_solicitud;

        // solicitante
        $this->solicitante = new DbField(
            $this, // Table
            'x_solicitante', // Variable name
            'solicitante', // Name
            '`solicitante`', // Expression
            '`solicitante`', // Basic search expression
            200, // Type
            40, // Size
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

        // difunto
        $this->difunto = new DbField(
            $this, // Table
            'x_difunto', // Variable name
            'difunto', // Name
            '`difunto`', // Expression
            '`difunto`', // Basic search expression
            200, // Type
            63, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`difunto`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->difunto->InputTextType = "text";
        $this->difunto->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['difunto'] = &$this->difunto;

        // ubicacion
        $this->ubicacion = new DbField(
            $this, // Table
            'x_ubicacion', // Variable name
            'ubicacion', // Name
            '`ubicacion`', // Expression
            '`ubicacion`', // Basic search expression
            200, // Type
            13, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ubicacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ubicacion->InputTextType = "text";
        $this->ubicacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ubicacion'] = &$this->ubicacion;

        // ctto_usd
        $this->ctto_usd = new DbField(
            $this, // Table
            'x_ctto_usd', // Variable name
            'ctto_usd', // Name
            '`ctto_usd`', // Expression
            '`ctto_usd`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ctto_usd`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ctto_usd->InputTextType = "text";
        $this->ctto_usd->Raw = true;
        $this->ctto_usd->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ctto_usd->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['ctto_usd'] = &$this->ctto_usd;

        // tipo_pago
        $this->tipo_pago = new DbField(
            $this, // Table
            'x_tipo_pago', // Variable name
            'tipo_pago', // Name
            '`tipo_pago`', // Expression
            '`tipo_pago`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tipo_pago`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->tipo_pago->addMethod("getSelectFilter", fn() => "`codigo` = '060'");
        $this->tipo_pago->InputTextType = "text";
        $this->tipo_pago->setSelectMultiple(false); // Select one
        $this->tipo_pago->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->tipo_pago->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->tipo_pago->Lookup = new Lookup($this->tipo_pago, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1`', '', "`valor1`");
        $this->tipo_pago->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['tipo_pago'] = &$this->tipo_pago;

        // banco
        $this->banco = new DbField(
            $this, // Table
            'x_banco', // Variable name
            'banco', // Name
            '`banco`', // Expression
            '`banco`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`banco`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->banco->InputTextType = "text";
        $this->banco->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['banco'] = &$this->banco;

        // ref
        $this->ref = new DbField(
            $this, // Table
            'x_ref', // Variable name
            'ref', // Name
            '`ref`', // Expression
            '`ref`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ref`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ref->InputTextType = "text";
        $this->ref->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ref'] = &$this->ref;

        // fecha_cobro
        $this->fecha_cobro = new DbField(
            $this, // Table
            'x_fecha_cobro', // Variable name
            'fecha_cobro', // Name
            '`fecha_cobro`', // Expression
            CastDateFieldForLike("`fecha_cobro`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_cobro`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_cobro->InputTextType = "text";
        $this->fecha_cobro->Raw = true;
        $this->fecha_cobro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_cobro->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_cobro'] = &$this->fecha_cobro;

        // resgitro_pago
        $this->resgitro_pago = new DbField(
            $this, // Table
            'x_resgitro_pago', // Variable name
            'resgitro_pago', // Name
            '`resgitro_pago`', // Expression
            CastDateFieldForLike("`resgitro_pago`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`resgitro_pago`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->resgitro_pago->InputTextType = "text";
        $this->resgitro_pago->Raw = true;
        $this->resgitro_pago->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->resgitro_pago->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['resgitro_pago'] = &$this->resgitro_pago;

        // cta_destino
        $this->cta_destino = new DbField(
            $this, // Table
            'x_cta_destino', // Variable name
            'cta_destino', // Name
            '`cta_destino`', // Expression
            '`cta_destino`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cta_destino`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->cta_destino->InputTextType = "text";
        $this->cta_destino->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['cta_destino'] = &$this->cta_destino;

        // monto_bs
        $this->monto_bs = new DbField(
            $this, // Table
            'x_monto_bs', // Variable name
            'monto_bs', // Name
            '`monto_bs`', // Expression
            '`monto_bs`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`monto_bs`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->monto_bs->InputTextType = "text";
        $this->monto_bs->Raw = true;
        $this->monto_bs->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto_bs->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['monto_bs'] = &$this->monto_bs;

        // monto_usd
        $this->monto_usd = new DbField(
            $this, // Table
            'x_monto_usd', // Variable name
            'monto_usd', // Name
            '`monto_usd`', // Expression
            '`monto_usd`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`monto_usd`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->monto_usd->InputTextType = "text";
        $this->monto_usd->Raw = true;
        $this->monto_usd->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto_usd->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['monto_usd'] = &$this->monto_usd;

        // monto_ue
        $this->monto_ue = new DbField(
            $this, // Table
            'x_monto_ue', // Variable name
            'monto_ue', // Name
            '`monto_ue`', // Expression
            '`monto_ue`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`monto_ue`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->monto_ue->InputTextType = "text";
        $this->monto_ue->Raw = true;
        $this->monto_ue->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto_ue->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['monto_ue'] = &$this->monto_ue;

        // subtipo
        $this->subtipo = new DbField(
            $this, // Table
            'x_subtipo', // Variable name
            'subtipo', // Name
            '`subtipo`', // Expression
            '`subtipo`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`subtipo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->subtipo->InputTextType = "text";
        $this->subtipo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['subtipo'] = &$this->subtipo;

        // estatus
        $this->estatus = new DbField(
            $this, // Table
            'x_estatus', // Variable name
            'estatus', // Name
            '`estatus`', // Expression
            '`estatus`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`estatus`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->estatus->InputTextType = "text";
        $this->estatus->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "view_grama_pagos";
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
        $this->expediente->DbValue = $row['expediente'];
        $this->registro_solicitud->DbValue = $row['registro_solicitud'];
        $this->solicitante->DbValue = $row['solicitante'];
        $this->difunto->DbValue = $row['difunto'];
        $this->ubicacion->DbValue = $row['ubicacion'];
        $this->ctto_usd->DbValue = $row['ctto_usd'];
        $this->tipo_pago->DbValue = $row['tipo_pago'];
        $this->banco->DbValue = $row['banco'];
        $this->ref->DbValue = $row['ref'];
        $this->fecha_cobro->DbValue = $row['fecha_cobro'];
        $this->resgitro_pago->DbValue = $row['resgitro_pago'];
        $this->cta_destino->DbValue = $row['cta_destino'];
        $this->monto_bs->DbValue = $row['monto_bs'];
        $this->monto_usd->DbValue = $row['monto_usd'];
        $this->monto_ue->DbValue = $row['monto_ue'];
        $this->subtipo->DbValue = $row['subtipo'];
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
        return "";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        return implode($keySeparator, $keys);
    }

    // Set Key
    public function setKey($key, $current = false, $keySeparator = null)
    {
        $keySeparator ??= Config("COMPOSITE_KEY_SEPARATOR");
        $this->OldKey = strval($key);
        $keys = explode($keySeparator, $this->OldKey);
        if (count($keys) == 0) {
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
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
        return $_SESSION[$name] ?? GetUrl("ViewGramaPagosList");
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
            "ViewGramaPagosView" => $Language->phrase("View"),
            "ViewGramaPagosEdit" => $Language->phrase("Edit"),
            "ViewGramaPagosAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ViewGramaPagosList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ViewGramaPagosView",
            Config("API_ADD_ACTION") => "ViewGramaPagosAdd",
            Config("API_EDIT_ACTION") => "ViewGramaPagosEdit",
            Config("API_DELETE_ACTION") => "ViewGramaPagosDelete",
            Config("API_LIST_ACTION") => "ViewGramaPagosList",
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
        return "ViewGramaPagosList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ViewGramaPagosView", $parm);
        } else {
            $url = $this->keyUrl("ViewGramaPagosView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ViewGramaPagosAdd?" . $parm;
        } else {
            $url = "ViewGramaPagosAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ViewGramaPagosEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ViewGramaPagosList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ViewGramaPagosAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ViewGramaPagosList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ViewGramaPagosDelete", $parm);
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
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
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
                    ? array_map(fn ($i) => Route($i + 3), range(0, -1))  // Export API
                    : array_map(fn ($i) => Route($i + 2), range(0, -1))) // Other API
                : []; // Non-API
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
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
        $this->expediente->setDbValue($row['expediente']);
        $this->registro_solicitud->setDbValue($row['registro_solicitud']);
        $this->solicitante->setDbValue($row['solicitante']);
        $this->difunto->setDbValue($row['difunto']);
        $this->ubicacion->setDbValue($row['ubicacion']);
        $this->ctto_usd->setDbValue($row['ctto_usd']);
        $this->tipo_pago->setDbValue($row['tipo_pago']);
        $this->banco->setDbValue($row['banco']);
        $this->ref->setDbValue($row['ref']);
        $this->fecha_cobro->setDbValue($row['fecha_cobro']);
        $this->resgitro_pago->setDbValue($row['resgitro_pago']);
        $this->cta_destino->setDbValue($row['cta_destino']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->monto_usd->setDbValue($row['monto_usd']);
        $this->monto_ue->setDbValue($row['monto_ue']);
        $this->subtipo->setDbValue($row['subtipo']);
        $this->estatus->setDbValue($row['estatus']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ViewGramaPagosList";
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

        // expediente

        // registro_solicitud

        // solicitante

        // difunto

        // ubicacion

        // ctto_usd

        // tipo_pago

        // banco

        // ref

        // fecha_cobro

        // resgitro_pago

        // cta_destino

        // monto_bs

        // monto_usd

        // monto_ue

        // subtipo

        // estatus

        // expediente
        $this->expediente->ViewValue = $this->expediente->CurrentValue;

        // registro_solicitud
        $this->registro_solicitud->ViewValue = $this->registro_solicitud->CurrentValue;
        $this->registro_solicitud->ViewValue = FormatDateTime($this->registro_solicitud->ViewValue, $this->registro_solicitud->formatPattern());

        // solicitante
        $this->solicitante->ViewValue = $this->solicitante->CurrentValue;

        // difunto
        $this->difunto->ViewValue = $this->difunto->CurrentValue;

        // ubicacion
        $this->ubicacion->ViewValue = $this->ubicacion->CurrentValue;

        // ctto_usd
        $this->ctto_usd->ViewValue = $this->ctto_usd->CurrentValue;
        $this->ctto_usd->ViewValue = FormatNumber($this->ctto_usd->ViewValue, $this->ctto_usd->formatPattern());

        // tipo_pago
        $curVal = strval($this->tipo_pago->CurrentValue);
        if ($curVal != "") {
            $this->tipo_pago->ViewValue = $this->tipo_pago->lookupCacheOption($curVal);
            if ($this->tipo_pago->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->tipo_pago->Lookup->getTable()->Fields["valor1"]->searchExpression(), "=", $curVal, $this->tipo_pago->Lookup->getTable()->Fields["valor1"]->searchDataType(), "");
                $lookupFilter = $this->tipo_pago->getSelectFilter($this); // PHP
                $sqlWrk = $this->tipo_pago->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_pago->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_pago->ViewValue = $this->tipo_pago->displayValue($arwrk);
                } else {
                    $this->tipo_pago->ViewValue = $this->tipo_pago->CurrentValue;
                }
            }
        } else {
            $this->tipo_pago->ViewValue = null;
        }

        // banco
        $this->banco->ViewValue = $this->banco->CurrentValue;

        // ref
        $this->ref->ViewValue = $this->ref->CurrentValue;

        // fecha_cobro
        $this->fecha_cobro->ViewValue = $this->fecha_cobro->CurrentValue;
        $this->fecha_cobro->ViewValue = FormatDateTime($this->fecha_cobro->ViewValue, $this->fecha_cobro->formatPattern());

        // resgitro_pago
        $this->resgitro_pago->ViewValue = $this->resgitro_pago->CurrentValue;
        $this->resgitro_pago->ViewValue = FormatDateTime($this->resgitro_pago->ViewValue, $this->resgitro_pago->formatPattern());

        // cta_destino
        $this->cta_destino->ViewValue = $this->cta_destino->CurrentValue;

        // monto_bs
        $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
        $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

        // monto_usd
        $this->monto_usd->ViewValue = $this->monto_usd->CurrentValue;
        $this->monto_usd->ViewValue = FormatNumber($this->monto_usd->ViewValue, $this->monto_usd->formatPattern());

        // monto_ue
        $this->monto_ue->ViewValue = $this->monto_ue->CurrentValue;
        $this->monto_ue->ViewValue = FormatNumber($this->monto_ue->ViewValue, $this->monto_ue->formatPattern());

        // subtipo
        $this->subtipo->ViewValue = $this->subtipo->CurrentValue;

        // estatus
        $this->estatus->ViewValue = $this->estatus->CurrentValue;

        // expediente
        $this->expediente->HrefValue = "";
        $this->expediente->TooltipValue = "";

        // registro_solicitud
        $this->registro_solicitud->HrefValue = "";
        $this->registro_solicitud->TooltipValue = "";

        // solicitante
        $this->solicitante->HrefValue = "";
        $this->solicitante->TooltipValue = "";

        // difunto
        $this->difunto->HrefValue = "";
        $this->difunto->TooltipValue = "";

        // ubicacion
        $this->ubicacion->HrefValue = "";
        $this->ubicacion->TooltipValue = "";

        // ctto_usd
        $this->ctto_usd->HrefValue = "";
        $this->ctto_usd->TooltipValue = "";

        // tipo_pago
        $this->tipo_pago->HrefValue = "";
        $this->tipo_pago->TooltipValue = "";

        // banco
        $this->banco->HrefValue = "";
        $this->banco->TooltipValue = "";

        // ref
        $this->ref->HrefValue = "";
        $this->ref->TooltipValue = "";

        // fecha_cobro
        $this->fecha_cobro->HrefValue = "";
        $this->fecha_cobro->TooltipValue = "";

        // resgitro_pago
        $this->resgitro_pago->HrefValue = "";
        $this->resgitro_pago->TooltipValue = "";

        // cta_destino
        $this->cta_destino->HrefValue = "";
        $this->cta_destino->TooltipValue = "";

        // monto_bs
        $this->monto_bs->HrefValue = "";
        $this->monto_bs->TooltipValue = "";

        // monto_usd
        $this->monto_usd->HrefValue = "";
        $this->monto_usd->TooltipValue = "";

        // monto_ue
        $this->monto_ue->HrefValue = "";
        $this->monto_ue->TooltipValue = "";

        // subtipo
        $this->subtipo->HrefValue = "";
        $this->subtipo->TooltipValue = "";

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

        // expediente
        $this->expediente->setupEditAttributes();
        $this->expediente->EditValue = $this->expediente->CurrentValue;
        $this->expediente->PlaceHolder = RemoveHtml($this->expediente->caption());
        if (strval($this->expediente->EditValue) != "" && is_numeric($this->expediente->EditValue)) {
            $this->expediente->EditValue = $this->expediente->EditValue;
        }

        // registro_solicitud
        $this->registro_solicitud->setupEditAttributes();
        $this->registro_solicitud->EditValue = FormatDateTime($this->registro_solicitud->CurrentValue, $this->registro_solicitud->formatPattern());
        $this->registro_solicitud->PlaceHolder = RemoveHtml($this->registro_solicitud->caption());

        // solicitante
        $this->solicitante->setupEditAttributes();
        if (!$this->solicitante->Raw) {
            $this->solicitante->CurrentValue = HtmlDecode($this->solicitante->CurrentValue);
        }
        $this->solicitante->EditValue = $this->solicitante->CurrentValue;
        $this->solicitante->PlaceHolder = RemoveHtml($this->solicitante->caption());

        // difunto
        $this->difunto->setupEditAttributes();
        if (!$this->difunto->Raw) {
            $this->difunto->CurrentValue = HtmlDecode($this->difunto->CurrentValue);
        }
        $this->difunto->EditValue = $this->difunto->CurrentValue;
        $this->difunto->PlaceHolder = RemoveHtml($this->difunto->caption());

        // ubicacion
        $this->ubicacion->setupEditAttributes();
        if (!$this->ubicacion->Raw) {
            $this->ubicacion->CurrentValue = HtmlDecode($this->ubicacion->CurrentValue);
        }
        $this->ubicacion->EditValue = $this->ubicacion->CurrentValue;
        $this->ubicacion->PlaceHolder = RemoveHtml($this->ubicacion->caption());

        // ctto_usd
        $this->ctto_usd->setupEditAttributes();
        $this->ctto_usd->EditValue = $this->ctto_usd->CurrentValue;
        $this->ctto_usd->PlaceHolder = RemoveHtml($this->ctto_usd->caption());
        if (strval($this->ctto_usd->EditValue) != "" && is_numeric($this->ctto_usd->EditValue)) {
            $this->ctto_usd->EditValue = FormatNumber($this->ctto_usd->EditValue, null);
        }

        // tipo_pago
        $this->tipo_pago->setupEditAttributes();
        $this->tipo_pago->PlaceHolder = RemoveHtml($this->tipo_pago->caption());

        // banco
        $this->banco->setupEditAttributes();
        if (!$this->banco->Raw) {
            $this->banco->CurrentValue = HtmlDecode($this->banco->CurrentValue);
        }
        $this->banco->EditValue = $this->banco->CurrentValue;
        $this->banco->PlaceHolder = RemoveHtml($this->banco->caption());

        // ref
        $this->ref->setupEditAttributes();
        if (!$this->ref->Raw) {
            $this->ref->CurrentValue = HtmlDecode($this->ref->CurrentValue);
        }
        $this->ref->EditValue = $this->ref->CurrentValue;
        $this->ref->PlaceHolder = RemoveHtml($this->ref->caption());

        // fecha_cobro
        $this->fecha_cobro->setupEditAttributes();
        $this->fecha_cobro->EditValue = FormatDateTime($this->fecha_cobro->CurrentValue, $this->fecha_cobro->formatPattern());
        $this->fecha_cobro->PlaceHolder = RemoveHtml($this->fecha_cobro->caption());

        // resgitro_pago
        $this->resgitro_pago->setupEditAttributes();
        $this->resgitro_pago->EditValue = FormatDateTime($this->resgitro_pago->CurrentValue, $this->resgitro_pago->formatPattern());
        $this->resgitro_pago->PlaceHolder = RemoveHtml($this->resgitro_pago->caption());

        // cta_destino
        $this->cta_destino->setupEditAttributes();
        if (!$this->cta_destino->Raw) {
            $this->cta_destino->CurrentValue = HtmlDecode($this->cta_destino->CurrentValue);
        }
        $this->cta_destino->EditValue = $this->cta_destino->CurrentValue;
        $this->cta_destino->PlaceHolder = RemoveHtml($this->cta_destino->caption());

        // monto_bs
        $this->monto_bs->setupEditAttributes();
        $this->monto_bs->EditValue = $this->monto_bs->CurrentValue;
        $this->monto_bs->PlaceHolder = RemoveHtml($this->monto_bs->caption());
        if (strval($this->monto_bs->EditValue) != "" && is_numeric($this->monto_bs->EditValue)) {
            $this->monto_bs->EditValue = FormatNumber($this->monto_bs->EditValue, null);
        }

        // monto_usd
        $this->monto_usd->setupEditAttributes();
        $this->monto_usd->EditValue = $this->monto_usd->CurrentValue;
        $this->monto_usd->PlaceHolder = RemoveHtml($this->monto_usd->caption());
        if (strval($this->monto_usd->EditValue) != "" && is_numeric($this->monto_usd->EditValue)) {
            $this->monto_usd->EditValue = FormatNumber($this->monto_usd->EditValue, null);
        }

        // monto_ue
        $this->monto_ue->setupEditAttributes();
        $this->monto_ue->EditValue = $this->monto_ue->CurrentValue;
        $this->monto_ue->PlaceHolder = RemoveHtml($this->monto_ue->caption());
        if (strval($this->monto_ue->EditValue) != "" && is_numeric($this->monto_ue->EditValue)) {
            $this->monto_ue->EditValue = FormatNumber($this->monto_ue->EditValue, null);
        }

        // subtipo
        $this->subtipo->setupEditAttributes();
        if (!$this->subtipo->Raw) {
            $this->subtipo->CurrentValue = HtmlDecode($this->subtipo->CurrentValue);
        }
        $this->subtipo->EditValue = $this->subtipo->CurrentValue;
        $this->subtipo->PlaceHolder = RemoveHtml($this->subtipo->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        if (!$this->estatus->Raw) {
            $this->estatus->CurrentValue = HtmlDecode($this->estatus->CurrentValue);
        }
        $this->estatus->EditValue = $this->estatus->CurrentValue;
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
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->registro_solicitud);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->difunto);
                    $doc->exportCaption($this->ubicacion);
                    $doc->exportCaption($this->ctto_usd);
                    $doc->exportCaption($this->tipo_pago);
                    $doc->exportCaption($this->banco);
                    $doc->exportCaption($this->ref);
                    $doc->exportCaption($this->fecha_cobro);
                    $doc->exportCaption($this->resgitro_pago);
                    $doc->exportCaption($this->cta_destino);
                    $doc->exportCaption($this->monto_bs);
                    $doc->exportCaption($this->monto_usd);
                    $doc->exportCaption($this->monto_ue);
                    $doc->exportCaption($this->subtipo);
                    $doc->exportCaption($this->estatus);
                } else {
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->registro_solicitud);
                    $doc->exportCaption($this->solicitante);
                    $doc->exportCaption($this->difunto);
                    $doc->exportCaption($this->ubicacion);
                    $doc->exportCaption($this->ctto_usd);
                    $doc->exportCaption($this->tipo_pago);
                    $doc->exportCaption($this->banco);
                    $doc->exportCaption($this->ref);
                    $doc->exportCaption($this->fecha_cobro);
                    $doc->exportCaption($this->resgitro_pago);
                    $doc->exportCaption($this->cta_destino);
                    $doc->exportCaption($this->monto_bs);
                    $doc->exportCaption($this->monto_usd);
                    $doc->exportCaption($this->monto_ue);
                    $doc->exportCaption($this->subtipo);
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
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->registro_solicitud);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->difunto);
                        $doc->exportField($this->ubicacion);
                        $doc->exportField($this->ctto_usd);
                        $doc->exportField($this->tipo_pago);
                        $doc->exportField($this->banco);
                        $doc->exportField($this->ref);
                        $doc->exportField($this->fecha_cobro);
                        $doc->exportField($this->resgitro_pago);
                        $doc->exportField($this->cta_destino);
                        $doc->exportField($this->monto_bs);
                        $doc->exportField($this->monto_usd);
                        $doc->exportField($this->monto_ue);
                        $doc->exportField($this->subtipo);
                        $doc->exportField($this->estatus);
                    } else {
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->registro_solicitud);
                        $doc->exportField($this->solicitante);
                        $doc->exportField($this->difunto);
                        $doc->exportField($this->ubicacion);
                        $doc->exportField($this->ctto_usd);
                        $doc->exportField($this->tipo_pago);
                        $doc->exportField($this->banco);
                        $doc->exportField($this->ref);
                        $doc->exportField($this->fecha_cobro);
                        $doc->exportField($this->resgitro_pago);
                        $doc->exportField($this->cta_destino);
                        $doc->exportField($this->monto_bs);
                        $doc->exportField($this->monto_usd);
                        $doc->exportField($this->monto_ue);
                        $doc->exportField($this->subtipo);
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
