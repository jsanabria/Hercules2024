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
 * Table class for sco_costos_tarifa_detalle
 */
class ScoCostosTarifaDetalle extends DbTable
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
    public $Ncostos_tarifa_detalle;
    public $costos_tarifa;
    public $cap;
    public $ata;
    public $obi;
    public $fot;
    public $man;
    public $gas;
    public $com;
    public $base;
    public $base_anterior;
    public $variacion;
    public $porcentaje;
    public $fecha;
    public $cerrado;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_costos_tarifa_detalle";
        $this->TableName = 'sco_costos_tarifa_detalle';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_costos_tarifa_detalle";
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

        // Ncostos_tarifa_detalle
        $this->Ncostos_tarifa_detalle = new DbField(
            $this, // Table
            'x_Ncostos_tarifa_detalle', // Variable name
            'Ncostos_tarifa_detalle', // Name
            '`Ncostos_tarifa_detalle`', // Expression
            '`Ncostos_tarifa_detalle`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Ncostos_tarifa_detalle`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Ncostos_tarifa_detalle->InputTextType = "text";
        $this->Ncostos_tarifa_detalle->Raw = true;
        $this->Ncostos_tarifa_detalle->IsAutoIncrement = true; // Autoincrement field
        $this->Ncostos_tarifa_detalle->IsPrimaryKey = true; // Primary key field
        $this->Ncostos_tarifa_detalle->Nullable = false; // NOT NULL field
        $this->Ncostos_tarifa_detalle->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Ncostos_tarifa_detalle->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Ncostos_tarifa_detalle'] = &$this->Ncostos_tarifa_detalle;

        // costos_tarifa
        $this->costos_tarifa = new DbField(
            $this, // Table
            'x_costos_tarifa', // Variable name
            'costos_tarifa', // Name
            '`costos_tarifa`', // Expression
            '`costos_tarifa`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`costos_tarifa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->costos_tarifa->InputTextType = "text";
        $this->costos_tarifa->Raw = true;
        $this->costos_tarifa->IsForeignKey = true; // Foreign key field
        $this->costos_tarifa->Required = true; // Required field
        $this->costos_tarifa->setSelectMultiple(false); // Select one
        $this->costos_tarifa->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->costos_tarifa->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->costos_tarifa->Lookup = new Lookup($this->costos_tarifa, 'sco_costos_tarifa', false, 'Ncostos_tarifa', ["localidad","tipo_servicio","horas",""], '', '', [], [], [], [], [], [], false, '', '', "CONCAT(COALESCE(`localidad`, ''),'" . ValueSeparator(1, $this->costos_tarifa) . "',COALESCE(`tipo_servicio`,''),'" . ValueSeparator(2, $this->costos_tarifa) . "',COALESCE(`horas`,''))");
        $this->costos_tarifa->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->costos_tarifa->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['costos_tarifa'] = &$this->costos_tarifa;

        // cap
        $this->cap = new DbField(
            $this, // Table
            'x_cap', // Variable name
            'cap', // Name
            '`cap`', // Expression
            '`cap`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cap`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->cap->addMethod("getSelectFilter", fn() => "`tipo` = 'CAP'");
        $this->cap->InputTextType = "text";
        $this->cap->setSelectMultiple(false); // Select one
        $this->cap->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cap->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cap->Lookup = new Lookup($this->cap, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->cap) . "',COALESCE(`precio`,''))");
        $this->cap->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->cap->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['cap'] = &$this->cap;

        // ata
        $this->ata = new DbField(
            $this, // Table
            'x_ata', // Variable name
            'ata', // Name
            '`ata`', // Expression
            '`ata`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ata`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->ata->addMethod("getSelectFilter", fn() => "`tipo` = 'ATA'");
        $this->ata->InputTextType = "text";
        $this->ata->setSelectMultiple(false); // Select one
        $this->ata->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->ata->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->ata->Lookup = new Lookup($this->ata, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->ata) . "',COALESCE(`precio`,''))");
        $this->ata->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->ata->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['ata'] = &$this->ata;

        // obi
        $this->obi = new DbField(
            $this, // Table
            'x_obi', // Variable name
            'obi', // Name
            '`obi`', // Expression
            '`obi`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`obi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->obi->addMethod("getSelectFilter", fn() => "`tipo` = 'OBI'");
        $this->obi->InputTextType = "text";
        $this->obi->setSelectMultiple(false); // Select one
        $this->obi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->obi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->obi->Lookup = new Lookup($this->obi, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->obi) . "',COALESCE(`precio`,''))");
        $this->obi->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->obi->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['obi'] = &$this->obi;

        // fot
        $this->fot = new DbField(
            $this, // Table
            'x_fot', // Variable name
            'fot', // Name
            '`fot`', // Expression
            '`fot`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`fot`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->fot->addMethod("getSelectFilter", fn() => "`tipo` = 'SER'");
        $this->fot->InputTextType = "text";
        $this->fot->setSelectMultiple(false); // Select one
        $this->fot->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->fot->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->fot->Lookup = new Lookup($this->fot, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->fot) . "',COALESCE(`precio`,''))");
        $this->fot->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->fot->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['fot'] = &$this->fot;

        // man
        $this->man = new DbField(
            $this, // Table
            'x_man', // Variable name
            'man', // Name
            '`man`', // Expression
            '`man`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`man`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->man->addMethod("getSelectFilter", fn() => "`tipo` = 'SER'");
        $this->man->InputTextType = "text";
        $this->man->setSelectMultiple(false); // Select one
        $this->man->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->man->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->man->Lookup = new Lookup($this->man, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->man) . "',COALESCE(`precio`,''))");
        $this->man->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->man->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['man'] = &$this->man;

        // gas
        $this->gas = new DbField(
            $this, // Table
            'x_gas', // Variable name
            'gas', // Name
            '`gas`', // Expression
            '`gas`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`gas`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->gas->addMethod("getSelectFilter", fn() => "`tipo` = 'SER'");
        $this->gas->InputTextType = "text";
        $this->gas->setSelectMultiple(false); // Select one
        $this->gas->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->gas->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->gas->Lookup = new Lookup($this->gas, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->gas) . "',COALESCE(`precio`,''))");
        $this->gas->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->gas->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['gas'] = &$this->gas;

        // com
        $this->com = new DbField(
            $this, // Table
            'x_com', // Variable name
            'com', // Name
            '`com`', // Expression
            '`com`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`com`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->com->addMethod("getSelectFilter", fn() => "`tipo` = 'SER'");
        $this->com->InputTextType = "text";
        $this->com->setSelectMultiple(false); // Select one
        $this->com->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->com->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->com->Lookup = new Lookup($this->com, 'sco_costos_articulos', false, 'Ncostos_articulo', ["descripcion","precio","",""], '', '', [], [], [], [], [], [], false, '`descripcion`', '', "CONCAT(COALESCE(`descripcion`, ''),'" . ValueSeparator(1, $this->com) . "',COALESCE(`precio`,''))");
        $this->com->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->com->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['com'] = &$this->com;

        // base
        $this->base = new DbField(
            $this, // Table
            'x_base', // Variable name
            'base', // Name
            '`base`', // Expression
            '`base`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`base`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->base->InputTextType = "text";
        $this->base->Raw = true;
        $this->base->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->base->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['base'] = &$this->base;

        // base_anterior
        $this->base_anterior = new DbField(
            $this, // Table
            'x_base_anterior', // Variable name
            'base_anterior', // Name
            '`base_anterior`', // Expression
            '`base_anterior`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`base_anterior`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->base_anterior->InputTextType = "text";
        $this->base_anterior->Raw = true;
        $this->base_anterior->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->base_anterior->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['base_anterior'] = &$this->base_anterior;

        // variacion
        $this->variacion = new DbField(
            $this, // Table
            'x_variacion', // Variable name
            'variacion', // Name
            '`variacion`', // Expression
            '`variacion`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`variacion`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->variacion->InputTextType = "text";
        $this->variacion->Raw = true;
        $this->variacion->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->variacion->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['variacion'] = &$this->variacion;

        // porcentaje
        $this->porcentaje = new DbField(
            $this, // Table
            'x_porcentaje', // Variable name
            'porcentaje', // Name
            '`porcentaje`', // Expression
            '`porcentaje`', // Basic search expression
            5, // Type
            22, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`porcentaje`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->porcentaje->InputTextType = "text";
        $this->porcentaje->Raw = true;
        $this->porcentaje->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->porcentaje->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['porcentaje'] = &$this->porcentaje;

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

        // cerrado
        $this->cerrado = new DbField(
            $this, // Table
            'x_cerrado', // Variable name
            'cerrado', // Name
            '`cerrado`', // Expression
            '`cerrado`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`cerrado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->cerrado->addMethod("getDefault", fn() => "N");
        $this->cerrado->InputTextType = "text";
        $this->cerrado->Raw = true;
        $this->cerrado->setSelectMultiple(false); // Select one
        $this->cerrado->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cerrado->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->cerrado->Lookup = new Lookup($this->cerrado, 'sco_costos_tarifa_detalle', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->cerrado->OptionCount = 2;
        $this->cerrado->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['cerrado'] = &$this->cerrado;

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
        if ($this->getCurrentMasterTable() == "sco_costos_tarifa") {
            $masterTable = Container("sco_costos_tarifa");
            if ($this->costos_tarifa->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->Ncostos_tarifa, $this->costos_tarifa->getSessionValue(), $masterTable->Ncostos_tarifa->DataType, $masterTable->Dbid);
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
        if ($this->getCurrentMasterTable() == "sco_costos_tarifa") {
            $masterTable = Container("sco_costos_tarifa");
            if ($this->costos_tarifa->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->costos_tarifa, $this->costos_tarifa->getSessionValue(), $masterTable->Ncostos_tarifa->DataType, $this->Dbid);
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
            case "sco_costos_tarifa":
                $key = $keys["costos_tarifa"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->Ncostos_tarifa->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->Ncostos_tarifa, $keys["costos_tarifa"], $this->costos_tarifa->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "sco_costos_tarifa":
                return GetKeyFilter($this->costos_tarifa, $masterTable->Ncostos_tarifa->DbValue, $masterTable->Ncostos_tarifa->DataType, $masterTable->Dbid);
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_costos_tarifa_detalle";
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
            $this->Ncostos_tarifa_detalle->setDbValue($conn->lastInsertId());
            $rs['Ncostos_tarifa_detalle'] = $this->Ncostos_tarifa_detalle->DbValue;
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
            if (!isset($rs['Ncostos_tarifa_detalle']) && !EmptyValue($this->Ncostos_tarifa_detalle->CurrentValue)) {
                $rs['Ncostos_tarifa_detalle'] = $this->Ncostos_tarifa_detalle->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Ncostos_tarifa_detalle';
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
            if (array_key_exists('Ncostos_tarifa_detalle', $rs)) {
                AddFilter($where, QuotedName('Ncostos_tarifa_detalle', $this->Dbid) . '=' . QuotedValue($rs['Ncostos_tarifa_detalle'], $this->Ncostos_tarifa_detalle->DataType, $this->Dbid));
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
        $this->Ncostos_tarifa_detalle->DbValue = $row['Ncostos_tarifa_detalle'];
        $this->costos_tarifa->DbValue = $row['costos_tarifa'];
        $this->cap->DbValue = $row['cap'];
        $this->ata->DbValue = $row['ata'];
        $this->obi->DbValue = $row['obi'];
        $this->fot->DbValue = $row['fot'];
        $this->man->DbValue = $row['man'];
        $this->gas->DbValue = $row['gas'];
        $this->com->DbValue = $row['com'];
        $this->base->DbValue = $row['base'];
        $this->base_anterior->DbValue = $row['base_anterior'];
        $this->variacion->DbValue = $row['variacion'];
        $this->porcentaje->DbValue = $row['porcentaje'];
        $this->fecha->DbValue = $row['fecha'];
        $this->cerrado->DbValue = $row['cerrado'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Ncostos_tarifa_detalle` = @Ncostos_tarifa_detalle@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Ncostos_tarifa_detalle->CurrentValue : $this->Ncostos_tarifa_detalle->OldValue;
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
                $this->Ncostos_tarifa_detalle->CurrentValue = $keys[0];
            } else {
                $this->Ncostos_tarifa_detalle->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Ncostos_tarifa_detalle', $row) ? $row['Ncostos_tarifa_detalle'] : null;
        } else {
            $val = !EmptyValue($this->Ncostos_tarifa_detalle->OldValue) && !$current ? $this->Ncostos_tarifa_detalle->OldValue : $this->Ncostos_tarifa_detalle->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Ncostos_tarifa_detalle@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoCostosTarifaDetalleList");
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
            "ScoCostosTarifaDetalleView" => $Language->phrase("View"),
            "ScoCostosTarifaDetalleEdit" => $Language->phrase("Edit"),
            "ScoCostosTarifaDetalleAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoCostosTarifaDetalleList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoCostosTarifaDetalleView",
            Config("API_ADD_ACTION") => "ScoCostosTarifaDetalleAdd",
            Config("API_EDIT_ACTION") => "ScoCostosTarifaDetalleEdit",
            Config("API_DELETE_ACTION") => "ScoCostosTarifaDetalleDelete",
            Config("API_LIST_ACTION") => "ScoCostosTarifaDetalleList",
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
        return "ScoCostosTarifaDetalleList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoCostosTarifaDetalleView", $parm);
        } else {
            $url = $this->keyUrl("ScoCostosTarifaDetalleView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoCostosTarifaDetalleAdd?" . $parm;
        } else {
            $url = "ScoCostosTarifaDetalleAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoCostosTarifaDetalleEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoCostosTarifaDetalleList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoCostosTarifaDetalleAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoCostosTarifaDetalleList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoCostosTarifaDetalleDelete", $parm);
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "sco_costos_tarifa" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_Ncostos_tarifa", $this->costos_tarifa->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Ncostos_tarifa_detalle\":" . VarToJson($this->Ncostos_tarifa_detalle->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Ncostos_tarifa_detalle->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Ncostos_tarifa_detalle->CurrentValue);
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
            if (($keyValue = Param("Ncostos_tarifa_detalle") ?? Route("Ncostos_tarifa_detalle")) !== null) {
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
                $this->Ncostos_tarifa_detalle->CurrentValue = $key;
            } else {
                $this->Ncostos_tarifa_detalle->OldValue = $key;
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
        $this->Ncostos_tarifa_detalle->setDbValue($row['Ncostos_tarifa_detalle']);
        $this->costos_tarifa->setDbValue($row['costos_tarifa']);
        $this->cap->setDbValue($row['cap']);
        $this->ata->setDbValue($row['ata']);
        $this->obi->setDbValue($row['obi']);
        $this->fot->setDbValue($row['fot']);
        $this->man->setDbValue($row['man']);
        $this->gas->setDbValue($row['gas']);
        $this->com->setDbValue($row['com']);
        $this->base->setDbValue($row['base']);
        $this->base_anterior->setDbValue($row['base_anterior']);
        $this->variacion->setDbValue($row['variacion']);
        $this->porcentaje->setDbValue($row['porcentaje']);
        $this->fecha->setDbValue($row['fecha']);
        $this->cerrado->setDbValue($row['cerrado']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoCostosTarifaDetalleList";
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

        // Ncostos_tarifa_detalle

        // costos_tarifa

        // cap

        // ata

        // obi

        // fot

        // man

        // gas

        // com

        // base

        // base_anterior

        // variacion

        // porcentaje

        // fecha

        // cerrado

        // Ncostos_tarifa_detalle
        $this->Ncostos_tarifa_detalle->ViewValue = $this->Ncostos_tarifa_detalle->CurrentValue;

        // costos_tarifa
        $curVal = strval($this->costos_tarifa->CurrentValue);
        if ($curVal != "") {
            $this->costos_tarifa->ViewValue = $this->costos_tarifa->lookupCacheOption($curVal);
            if ($this->costos_tarifa->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchExpression(), "=", $curVal, $this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchDataType(), "");
                $sqlWrk = $this->costos_tarifa->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->costos_tarifa->Lookup->renderViewRow($rswrk[0]);
                    $this->costos_tarifa->ViewValue = $this->costos_tarifa->displayValue($arwrk);
                } else {
                    $this->costos_tarifa->ViewValue = $this->costos_tarifa->CurrentValue;
                }
            }
        } else {
            $this->costos_tarifa->ViewValue = null;
        }

        // cap
        $curVal = strval($this->cap->CurrentValue);
        if ($curVal != "") {
            $this->cap->ViewValue = $this->cap->lookupCacheOption($curVal);
            if ($this->cap->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->cap->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->cap->getSelectFilter($this); // PHP
                $sqlWrk = $this->cap->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->cap->Lookup->renderViewRow($rswrk[0]);
                    $this->cap->ViewValue = $this->cap->displayValue($arwrk);
                } else {
                    $this->cap->ViewValue = $this->cap->CurrentValue;
                }
            }
        } else {
            $this->cap->ViewValue = null;
        }
        $this->cap->CellCssStyle .= "text-align: left;";

        // ata
        $curVal = strval($this->ata->CurrentValue);
        if ($curVal != "") {
            $this->ata->ViewValue = $this->ata->lookupCacheOption($curVal);
            if ($this->ata->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->ata->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->ata->getSelectFilter($this); // PHP
                $sqlWrk = $this->ata->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->ata->Lookup->renderViewRow($rswrk[0]);
                    $this->ata->ViewValue = $this->ata->displayValue($arwrk);
                } else {
                    $this->ata->ViewValue = $this->ata->CurrentValue;
                }
            }
        } else {
            $this->ata->ViewValue = null;
        }
        $this->ata->CellCssStyle .= "text-align: left;";

        // obi
        $curVal = strval($this->obi->CurrentValue);
        if ($curVal != "") {
            $this->obi->ViewValue = $this->obi->lookupCacheOption($curVal);
            if ($this->obi->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->obi->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->obi->getSelectFilter($this); // PHP
                $sqlWrk = $this->obi->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->obi->Lookup->renderViewRow($rswrk[0]);
                    $this->obi->ViewValue = $this->obi->displayValue($arwrk);
                } else {
                    $this->obi->ViewValue = $this->obi->CurrentValue;
                }
            }
        } else {
            $this->obi->ViewValue = null;
        }
        $this->obi->CellCssStyle .= "text-align: left;";

        // fot
        $curVal = strval($this->fot->CurrentValue);
        if ($curVal != "") {
            $this->fot->ViewValue = $this->fot->lookupCacheOption($curVal);
            if ($this->fot->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->fot->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->fot->getSelectFilter($this); // PHP
                $sqlWrk = $this->fot->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->fot->Lookup->renderViewRow($rswrk[0]);
                    $this->fot->ViewValue = $this->fot->displayValue($arwrk);
                } else {
                    $this->fot->ViewValue = $this->fot->CurrentValue;
                }
            }
        } else {
            $this->fot->ViewValue = null;
        }
        $this->fot->CellCssStyle .= "text-align: left;";

        // man
        $curVal = strval($this->man->CurrentValue);
        if ($curVal != "") {
            $this->man->ViewValue = $this->man->lookupCacheOption($curVal);
            if ($this->man->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->man->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->man->getSelectFilter($this); // PHP
                $sqlWrk = $this->man->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->man->Lookup->renderViewRow($rswrk[0]);
                    $this->man->ViewValue = $this->man->displayValue($arwrk);
                } else {
                    $this->man->ViewValue = $this->man->CurrentValue;
                }
            }
        } else {
            $this->man->ViewValue = null;
        }
        $this->man->CellCssStyle .= "text-align: left;";

        // gas
        $curVal = strval($this->gas->CurrentValue);
        if ($curVal != "") {
            $this->gas->ViewValue = $this->gas->lookupCacheOption($curVal);
            if ($this->gas->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->gas->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->gas->getSelectFilter($this); // PHP
                $sqlWrk = $this->gas->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->gas->Lookup->renderViewRow($rswrk[0]);
                    $this->gas->ViewValue = $this->gas->displayValue($arwrk);
                } else {
                    $this->gas->ViewValue = $this->gas->CurrentValue;
                }
            }
        } else {
            $this->gas->ViewValue = null;
        }
        $this->gas->CellCssStyle .= "text-align: left;";

        // com
        $curVal = strval($this->com->CurrentValue);
        if ($curVal != "") {
            $this->com->ViewValue = $this->com->lookupCacheOption($curVal);
            if ($this->com->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchExpression(), "=", $curVal, $this->com->Lookup->getTable()->Fields["Ncostos_articulo"]->searchDataType(), "");
                $lookupFilter = $this->com->getSelectFilter($this); // PHP
                $sqlWrk = $this->com->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->com->Lookup->renderViewRow($rswrk[0]);
                    $this->com->ViewValue = $this->com->displayValue($arwrk);
                } else {
                    $this->com->ViewValue = $this->com->CurrentValue;
                }
            }
        } else {
            $this->com->ViewValue = null;
        }
        $this->com->CellCssStyle .= "text-align: left;";

        // base
        $this->base->ViewValue = $this->base->CurrentValue;
        $this->base->ViewValue = FormatNumber($this->base->ViewValue, $this->base->formatPattern());
        $this->base->CssClass = "fw-bold";
        $this->base->CellCssStyle .= "text-align: left;";

        // base_anterior
        $this->base_anterior->ViewValue = $this->base_anterior->CurrentValue;
        $this->base_anterior->ViewValue = FormatNumber($this->base_anterior->ViewValue, $this->base_anterior->formatPattern());
        $this->base_anterior->CellCssStyle .= "text-align: left;";

        // variacion
        $this->variacion->ViewValue = $this->variacion->CurrentValue;
        $this->variacion->ViewValue = FormatNumber($this->variacion->ViewValue, $this->variacion->formatPattern());
        $this->variacion->CellCssStyle .= "text-align: left;";

        // porcentaje
        $this->porcentaje->ViewValue = $this->porcentaje->CurrentValue;
        $this->porcentaje->ViewValue = FormatNumber($this->porcentaje->ViewValue, $this->porcentaje->formatPattern());
        $this->porcentaje->CellCssStyle .= "text-align: left;";

        // fecha
        $this->fecha->ViewValue = $this->fecha->CurrentValue;
        $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

        // cerrado
        if (strval($this->cerrado->CurrentValue) != "") {
            $this->cerrado->ViewValue = $this->cerrado->optionCaption($this->cerrado->CurrentValue);
        } else {
            $this->cerrado->ViewValue = null;
        }

        // Ncostos_tarifa_detalle
        $this->Ncostos_tarifa_detalle->HrefValue = "";
        $this->Ncostos_tarifa_detalle->TooltipValue = "";

        // costos_tarifa
        $this->costos_tarifa->HrefValue = "";
        $this->costos_tarifa->TooltipValue = "";

        // cap
        $this->cap->HrefValue = "";
        $this->cap->TooltipValue = "";

        // ata
        $this->ata->HrefValue = "";
        $this->ata->TooltipValue = "";

        // obi
        $this->obi->HrefValue = "";
        $this->obi->TooltipValue = "";

        // fot
        $this->fot->HrefValue = "";
        $this->fot->TooltipValue = "";

        // man
        $this->man->HrefValue = "";
        $this->man->TooltipValue = "";

        // gas
        $this->gas->HrefValue = "";
        $this->gas->TooltipValue = "";

        // com
        $this->com->HrefValue = "";
        $this->com->TooltipValue = "";

        // base
        $this->base->HrefValue = "";
        $this->base->TooltipValue = "";

        // base_anterior
        $this->base_anterior->HrefValue = "";
        $this->base_anterior->TooltipValue = "";

        // variacion
        $this->variacion->HrefValue = "";
        $this->variacion->TooltipValue = "";

        // porcentaje
        $this->porcentaje->HrefValue = "";
        $this->porcentaje->TooltipValue = "";

        // fecha
        $this->fecha->HrefValue = "";
        $this->fecha->TooltipValue = "";

        // cerrado
        $this->cerrado->HrefValue = "";
        $this->cerrado->TooltipValue = "";

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

        // Ncostos_tarifa_detalle
        $this->Ncostos_tarifa_detalle->setupEditAttributes();
        $this->Ncostos_tarifa_detalle->EditValue = $this->Ncostos_tarifa_detalle->CurrentValue;

        // costos_tarifa
        $this->costos_tarifa->setupEditAttributes();
        if ($this->costos_tarifa->getSessionValue() != "") {
            $this->costos_tarifa->CurrentValue = GetForeignKeyValue($this->costos_tarifa->getSessionValue());
            $curVal = strval($this->costos_tarifa->CurrentValue);
            if ($curVal != "") {
                $this->costos_tarifa->ViewValue = $this->costos_tarifa->lookupCacheOption($curVal);
                if ($this->costos_tarifa->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter($this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchExpression(), "=", $curVal, $this->costos_tarifa->Lookup->getTable()->Fields["Ncostos_tarifa"]->searchDataType(), "");
                    $sqlWrk = $this->costos_tarifa->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCache($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->costos_tarifa->Lookup->renderViewRow($rswrk[0]);
                        $this->costos_tarifa->ViewValue = $this->costos_tarifa->displayValue($arwrk);
                    } else {
                        $this->costos_tarifa->ViewValue = $this->costos_tarifa->CurrentValue;
                    }
                }
            } else {
                $this->costos_tarifa->ViewValue = null;
            }
        } else {
            $this->costos_tarifa->PlaceHolder = RemoveHtml($this->costos_tarifa->caption());
        }

        // cap
        $this->cap->setupEditAttributes();
        $this->cap->PlaceHolder = RemoveHtml($this->cap->caption());

        // ata
        $this->ata->setupEditAttributes();
        $this->ata->PlaceHolder = RemoveHtml($this->ata->caption());

        // obi
        $this->obi->setupEditAttributes();
        $this->obi->PlaceHolder = RemoveHtml($this->obi->caption());

        // fot
        $this->fot->setupEditAttributes();
        $this->fot->PlaceHolder = RemoveHtml($this->fot->caption());

        // man
        $this->man->setupEditAttributes();
        $this->man->PlaceHolder = RemoveHtml($this->man->caption());

        // gas
        $this->gas->setupEditAttributes();
        $this->gas->PlaceHolder = RemoveHtml($this->gas->caption());

        // com
        $this->com->setupEditAttributes();
        $this->com->PlaceHolder = RemoveHtml($this->com->caption());

        // base
        $this->base->setupEditAttributes();
        $this->base->EditValue = $this->base->CurrentValue;
        $this->base->EditValue = FormatNumber($this->base->EditValue, $this->base->formatPattern());
        $this->base->CssClass = "fw-bold";
        $this->base->CellCssStyle .= "text-align: left;";

        // base_anterior
        $this->base_anterior->setupEditAttributes();
        $this->base_anterior->EditValue = $this->base_anterior->CurrentValue;
        $this->base_anterior->EditValue = FormatNumber($this->base_anterior->EditValue, $this->base_anterior->formatPattern());
        $this->base_anterior->CellCssStyle .= "text-align: left;";

        // variacion
        $this->variacion->setupEditAttributes();
        $this->variacion->EditValue = $this->variacion->CurrentValue;
        $this->variacion->EditValue = FormatNumber($this->variacion->EditValue, $this->variacion->formatPattern());
        $this->variacion->CellCssStyle .= "text-align: left;";

        // porcentaje
        $this->porcentaje->setupEditAttributes();
        $this->porcentaje->EditValue = $this->porcentaje->CurrentValue;
        $this->porcentaje->EditValue = FormatNumber($this->porcentaje->EditValue, $this->porcentaje->formatPattern());
        $this->porcentaje->CellCssStyle .= "text-align: left;";

        // fecha
        $this->fecha->setupEditAttributes();
        $this->fecha->EditValue = $this->fecha->CurrentValue;
        $this->fecha->EditValue = FormatDateTime($this->fecha->EditValue, $this->fecha->formatPattern());

        // cerrado
        $this->cerrado->setupEditAttributes();
        $this->cerrado->EditValue = $this->cerrado->options(true);
        $this->cerrado->PlaceHolder = RemoveHtml($this->cerrado->caption());

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
                    $doc->exportCaption($this->cap);
                    $doc->exportCaption($this->ata);
                    $doc->exportCaption($this->obi);
                    $doc->exportCaption($this->fot);
                    $doc->exportCaption($this->man);
                    $doc->exportCaption($this->gas);
                    $doc->exportCaption($this->com);
                    $doc->exportCaption($this->base);
                    $doc->exportCaption($this->base_anterior);
                    $doc->exportCaption($this->variacion);
                    $doc->exportCaption($this->porcentaje);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->cerrado);
                } else {
                    $doc->exportCaption($this->Ncostos_tarifa_detalle);
                    $doc->exportCaption($this->costos_tarifa);
                    $doc->exportCaption($this->cap);
                    $doc->exportCaption($this->ata);
                    $doc->exportCaption($this->obi);
                    $doc->exportCaption($this->fot);
                    $doc->exportCaption($this->man);
                    $doc->exportCaption($this->gas);
                    $doc->exportCaption($this->com);
                    $doc->exportCaption($this->base);
                    $doc->exportCaption($this->base_anterior);
                    $doc->exportCaption($this->variacion);
                    $doc->exportCaption($this->porcentaje);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->cerrado);
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
                        $doc->exportField($this->cap);
                        $doc->exportField($this->ata);
                        $doc->exportField($this->obi);
                        $doc->exportField($this->fot);
                        $doc->exportField($this->man);
                        $doc->exportField($this->gas);
                        $doc->exportField($this->com);
                        $doc->exportField($this->base);
                        $doc->exportField($this->base_anterior);
                        $doc->exportField($this->variacion);
                        $doc->exportField($this->porcentaje);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->cerrado);
                    } else {
                        $doc->exportField($this->Ncostos_tarifa_detalle);
                        $doc->exportField($this->costos_tarifa);
                        $doc->exportField($this->cap);
                        $doc->exportField($this->ata);
                        $doc->exportField($this->obi);
                        $doc->exportField($this->fot);
                        $doc->exportField($this->man);
                        $doc->exportField($this->gas);
                        $doc->exportField($this->com);
                        $doc->exportField($this->base);
                        $doc->exportField($this->base_anterior);
                        $doc->exportField($this->variacion);
                        $doc->exportField($this->porcentaje);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->cerrado);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_costos_tarifa_detalle');
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
        $key .= $rs['Ncostos_tarifa_detalle'];

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
                WriteAuditLog($usr, "A", 'sco_costos_tarifa_detalle', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Ncostos_tarifa_detalle'];

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
                    WriteAuditLog($usr, "U", 'sco_costos_tarifa_detalle', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Ncostos_tarifa_detalle'];

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
                WriteAuditLog($usr, "D", 'sco_costos_tarifa_detalle', $fldname, $key, $oldvalue);
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
    	/*if($_SESSION["viene_tarifario"]=="S") 
    		AddFilter($filter, "cerrado = 'N'");*/
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
    	/*$sql = "UPDATE sco_costos_tarifa_detalle SET cerrado = 'S' WHERE costos_tarifa = '" . $rsnew["costos_tarifa"] . "' AND cerrado = 'N';";
    	Execute($sql);*/
    	$sql = "SELECT costos_tarifa FROM sco_costos_tarifa_detalle WHERE costos_tarifa = '" . $rsnew["costos_tarifa"] . "' AND cerrado = 'N';";
    	$valor = ExecuteScalar($sql);
    	if(trim($valor) != "") {
    		$this->CancelMessage = "Debe cerrar la tarifa actual!; no se puede agregar.";
    		return FALSE;
    	}
    	$sql = "SELECT base FROM sco_costos_tarifa_detalle WHERE costos_tarifa = '" . $rsnew["costos_tarifa"] . "' AND cerrado = 'S' ORDER BY Ncostos_tarifa_detalle DESC LIMIT 0, 1;";
    	$valor = ExecuteScalar($sql);
    	$valor = $valor==""?0:$valor;
    	$rsnew["base_anterior"] = $valor;
    	$rsnew["fecha"] = date("Y-m-d");
    	$rsnew["cerrado"] = "N";
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["cap"] . "';";
    	$cap = ExecuteScalar($sql);
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["ata"] . "';";
    	$ata = ExecuteScalar($sql);
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["obi"] . "';";
    	$obi = ExecuteScalar($sql);
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["fot"] . "';";
    	$fot = ExecuteScalar($sql);
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["man"] . "';";
    	$man = ExecuteScalar($sql);
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["gas"] . "';";
    	$gas = ExecuteScalar($sql);
    	$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["com"] . "';";
    	$com = ExecuteScalar($sql);
    	$rsnew["base"] = $cap + $ata + $obi + $fot + $man + $gas + $com;
    	$rsnew["variacion"] = $rsnew["base"] - $rsnew["base_anterior"];
    	if($rsnew["base_anterior"] == 0)
    		$rsnew["porcentaje"] = 0;
    	else
    		$rsnew["porcentaje"] = ($rsnew["variacion"] / $rsnew["base_anterior"]) * 100;
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
    	if($rsold["cerrado"]=="S") {
    		$this->CancelMessage = "Esta tarifa est&aacute; cerrada; no se puede modificar.";
    		return FALSE;
    	}
    	else {
    		if($rsnew["cerrado"]=="S") {
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["cap"] . "';";
    			$cap = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["ata"] . "';";
    			$ata = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["obi"] . "';";
    			$obi = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["fot"] . "';";
    			$fot = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["man"] . "';";
    			$man = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["gas"] . "';";
    			$gas = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsold["com"] . "';";
    			$com = ExecuteScalar($sql);
    			$base = $cap + $ata + $obi + $fot + $man + $gas + $com;
    			$variacion = $base - $rsold["base"];
    			if($rsold["base"] == 0)
    				$porcentaje = 0;
    			else
    				$porcentaje = ($variacion / $rsold["base"]) * 100;
    			$sql = "INSERT INTO sco_costos_tarifa_detalle
    							(Ncostos_tarifa_detalle, costos_tarifa, cap, ata, obi, fot, man, gas, com, base, base_anterior, variacion, porcentaje, fecha, cerrado)
    						SELECT 
    							NULL, costos_tarifa, '" . $rsold["cap"] . "', '" . $rsold["ata"] . "', '" . $rsold["obi"] . "', '" . $rsold["fot"] . "', '" . $rsold["man"] . "', '" . $rsold["gas"] . "', '" . $rsold["com"] . "', $base, base, $variacion, $porcentaje, curdate(), 'N'
    						FROM
    							sco_costos_tarifa_detalle
    						WHERE Ncostos_tarifa_detalle = '" . $rsold["Ncostos_tarifa_detalle"] . "';";
    			Execute($sql);
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["cap"] . "' order by id desc limit 0,1;";
    			$rsnew["cap"] = number_format(ExecuteScalar($sql),2,",",".");
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["ata"] . "' order by id desc limit 0,1;";
    			$rsnew["ata"] = number_format(ExecuteScalar($sql),2,",",".");
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["obi"] . "' order by id desc limit 0,1;";
    			$rsnew["obi"] = number_format(ExecuteScalar($sql),2,",",".");
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["fot"] . "' order by id desc limit 0,1;";
    			$rsnew["fot"] = number_format(ExecuteScalar($sql),2,",",".");
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["man"] . "' order by id desc limit 0,1;";
    			$rsnew["man"] = number_format(ExecuteScalar($sql),2,",",".");
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["gas"] . "' order by id desc limit 0,1;";
    			$rsnew["gas"] = number_format(ExecuteScalar($sql),2,",",".");
    			$sql = "select precio_actual from sco_costos where costos_articulos = '" . $rsold["com"] . "' order by id desc limit 0,1;";
    			$rsnew["com"] = number_format(ExecuteScalar($sql),2,",",".");
    		}
    		else {
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["cap"] . "';";
    			$cap = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["ata"] . "';";
    			$ata = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["obi"] . "';";
    			$obi = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["fot"] . "';";
    			$fot = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["man"] . "';";
    			$man = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["gas"] . "';";
    			$gas = ExecuteScalar($sql);
    			$sql = "select precio from sco_costos_articulos where Ncostos_articulo = '" . $rsnew["com"] . "';";
    			$com = ExecuteScalar($sql);
    			$rsnew["base"] = $cap + $ata + $obi + $fot + $man + $gas + $com;
    			$rsnew["variacion"] = $rsnew["base"] - $rsold["base_anterior"];
    			if($rsold["base_anterior"] == 0)
    				$rsnew["porcentaje"] = 0;
    			else
    				$rsnew["porcentaje"] = ($rsnew["variacion"] / $rsold["base_anterior"]) * 100;
    		}
    		return TRUE;
    	}
    }

    // Row Updated event
    public function rowUpdated($rsold, $rsnew) {
    	//echo "Row Updated";
    	/*if($rsnew["cerrado"]=="S") {
    		$sql = "INSERT INTO sco_costos_tarifa_detalle
    							(Ncostos_tarifa_detalle, costos_tarifa, cap, ata, obi, fot, man, gas, com, base, base_anterior, variacion, porcentaje, fecha, cerrado)
    						SELECT 
    							NULL, costos_tarifa, cap, ata, obi, fot, man, gas, com, base, base, variacion, porcentaje, curdate(), 'N'
    						FROM
    							sco_costos_tarifa_detalle
    						WHERE Ncostos_tarifa_detalle = '" . $rsold["Ncostos_tarifa_detalle"] . "';";
    		Execute($sql);
    	}*/
    	$_SESSION["viene_tarifario"] = "N";
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
    	if($this->cerrado->CurrentValue == "N") {
    		$sql = "select 
    					((select precio from sco_costos_articulos where Ncostos_articulo = p.cap) + 
    					(select precio from sco_costos_articulos where Ncostos_articulo = p.ata) + 
    					(select precio from sco_costos_articulos where Ncostos_articulo = p.obi) + 
    					(select precio from sco_costos_articulos where Ncostos_articulo = p.fot) + 
    					(select precio from sco_costos_articulos where Ncostos_articulo = p.man) + 
    					(select precio from sco_costos_articulos where Ncostos_articulo = p.gas) + 
    					(select precio from sco_costos_articulos where Ncostos_articulo = p.com)) as precio, 
    					p.base  
    				from sco_costos_tarifa_detalle as p where p.Ncostos_tarifa_detalle = '" . $this->Ncostos_tarifa_detalle->CurrentValue . "';";
    		$row = ExecuteRow($sql);	
    		$precio = number_format($row["precio"], 2, ",", ".");
    		$base = number_format($row["base"], 2, ",", ".");
    		if($base != $precio) $this->RowAttrs["class"] = "danger";
    		else  $this->RowAttrs["class"] = "success";
    	}
    	else $this->RowAttrs["class"] = "info";
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
