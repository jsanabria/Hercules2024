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
 * Table class for sco_reembolso
 */
class ScoReembolso extends DbTable
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
    public $Nreembolso;
    public $expediente;
    public $fecha;
    public $monto_usd;
    public $fecha_tasa;
    public $tasa;
    public $monto_bs;
    public $banco;
    public $nro_cta;
    public $titular;
    public $ci_rif;
    public $correo;
    public $nro_ref;
    public $motivo;
    public $nota;
    public $estatus;
    public $coordinador;
    public $pagador;
    public $fecha_pago;
    public $email_enviado;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("app.language");
        $this->TableVar = "sco_reembolso";
        $this->TableName = 'sco_reembolso';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "sco_reembolso";
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

        // Nreembolso
        $this->Nreembolso = new DbField(
            $this, // Table
            'x_Nreembolso', // Variable name
            'Nreembolso', // Name
            '`Nreembolso`', // Expression
            '`Nreembolso`', // Basic search expression
            20, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nreembolso`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Nreembolso->InputTextType = "text";
        $this->Nreembolso->Raw = true;
        $this->Nreembolso->IsAutoIncrement = true; // Autoincrement field
        $this->Nreembolso->IsPrimaryKey = true; // Primary key field
        $this->Nreembolso->Nullable = false; // NOT NULL field
        $this->Nreembolso->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Nreembolso->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Nreembolso'] = &$this->Nreembolso;

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
        $this->fecha->Required = true; // Required field
        $this->fecha->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha'] = &$this->fecha;

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
        $this->monto_usd->Required = true; // Required field
        $this->monto_usd->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->monto_usd->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['monto_usd'] = &$this->monto_usd;

        // fecha_tasa
        $this->fecha_tasa = new DbField(
            $this, // Table
            'x_fecha_tasa', // Variable name
            'fecha_tasa', // Name
            '`fecha_tasa`', // Expression
            CastDateFieldForLike("`fecha_tasa`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_tasa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_tasa->InputTextType = "text";
        $this->fecha_tasa->Raw = true;
        $this->fecha_tasa->Required = true; // Required field
        $this->fecha_tasa->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_tasa->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_tasa'] = &$this->fecha_tasa;

        // tasa
        $this->tasa = new DbField(
            $this, // Table
            'x_tasa', // Variable name
            'tasa', // Name
            '`tasa`', // Expression
            '`tasa`', // Basic search expression
            131, // Type
            16, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`tasa`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->tasa->InputTextType = "text";
        $this->tasa->Raw = true;
        $this->tasa->Required = true; // Required field
        $this->tasa->DefaultErrorMessage = $Language->phrase("IncorrectFloat");
        $this->tasa->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['tasa'] = &$this->tasa;

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

        // banco
        $this->banco = new DbField(
            $this, // Table
            'x_banco', // Variable name
            'banco', // Name
            '`banco`', // Expression
            '`banco`', // Basic search expression
            200, // Type
            30, // Size
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
        $this->banco->Required = true; // Required field
        $this->banco->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['banco'] = &$this->banco;

        // nro_cta
        $this->nro_cta = new DbField(
            $this, // Table
            'x_nro_cta', // Variable name
            'nro_cta', // Name
            '`nro_cta`', // Expression
            '`nro_cta`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nro_cta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nro_cta->InputTextType = "text";
        $this->nro_cta->Required = true; // Required field
        $this->nro_cta->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nro_cta'] = &$this->nro_cta;

        // titular
        $this->titular = new DbField(
            $this, // Table
            'x_titular', // Variable name
            'titular', // Name
            '`titular`', // Expression
            '`titular`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`titular`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->titular->InputTextType = "text";
        $this->titular->Required = true; // Required field
        $this->titular->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['titular'] = &$this->titular;

        // ci_rif
        $this->ci_rif = new DbField(
            $this, // Table
            'x_ci_rif', // Variable name
            'ci_rif', // Name
            '`ci_rif`', // Expression
            '`ci_rif`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`ci_rif`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->ci_rif->InputTextType = "text";
        $this->ci_rif->Required = true; // Required field
        $this->ci_rif->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['ci_rif'] = &$this->ci_rif;

        // correo
        $this->correo = new DbField(
            $this, // Table
            'x_correo', // Variable name
            'correo', // Name
            '`correo`', // Expression
            '`correo`', // Basic search expression
            200, // Type
            150, // Size
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
        $this->correo->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->correo->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['correo'] = &$this->correo;

        // nro_ref
        $this->nro_ref = new DbField(
            $this, // Table
            'x_nro_ref', // Variable name
            'nro_ref', // Name
            '`nro_ref`', // Expression
            '`nro_ref`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`nro_ref`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->nro_ref->InputTextType = "text";
        $this->nro_ref->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['nro_ref'] = &$this->nro_ref;

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
        $this->motivo->addMethod("getSelectFilter", fn() => "`codigo` = '052'");
        $this->motivo->InputTextType = "text";
        $this->motivo->Required = true; // Required field
        $this->motivo->setSelectMultiple(false); // Select one
        $this->motivo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->motivo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->motivo->Lookup = new Lookup($this->motivo, 'sco_parametro', false, 'valor1', ["valor1","","",""], '', '', [], [], [], [], [], [], false, '`valor1` ASC', '', "`valor1`");
        $this->motivo->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['motivo'] = &$this->motivo;

        // nota
        $this->nota = new DbField(
            $this, // Table
            'x_nota', // Variable name
            'nota', // Name
            '`nota`', // Expression
            '`nota`', // Basic search expression
            200, // Type
            150, // Size
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
        $this->estatus->Lookup = new Lookup($this->estatus, 'sco_reembolso', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->estatus->OptionCount = 4;
        $this->estatus->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['estatus'] = &$this->estatus;

        // coordinador
        $this->coordinador = new DbField(
            $this, // Table
            'x_coordinador', // Variable name
            'coordinador', // Name
            '`coordinador`', // Expression
            '`coordinador`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`coordinador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->coordinador->InputTextType = "text";
        $this->coordinador->Lookup = new Lookup($this->coordinador, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nombre`");
        $this->coordinador->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['coordinador'] = &$this->coordinador;

        // pagador
        $this->pagador = new DbField(
            $this, // Table
            'x_pagador', // Variable name
            'pagador', // Name
            '`pagador`', // Expression
            '`pagador`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`pagador`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->pagador->InputTextType = "text";
        $this->pagador->Lookup = new Lookup($this->pagador, 'sco_user', false, 'username', ["nombre","","",""], '', '', [], [], [], [], [], [], false, '', '', "`nombre`");
        $this->pagador->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['pagador'] = &$this->pagador;

        // fecha_pago
        $this->fecha_pago = new DbField(
            $this, // Table
            'x_fecha_pago', // Variable name
            'fecha_pago', // Name
            '`fecha_pago`', // Expression
            CastDateFieldForLike("`fecha_pago`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`fecha_pago`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->fecha_pago->InputTextType = "text";
        $this->fecha_pago->Raw = true;
        $this->fecha_pago->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->fecha_pago->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['fecha_pago'] = &$this->fecha_pago;

        // email_enviado
        $this->email_enviado = new DbField(
            $this, // Table
            'x_email_enviado', // Variable name
            'email_enviado', // Name
            '`email_enviado`', // Expression
            '`email_enviado`', // Basic search expression
            200, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email_enviado`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->email_enviado->addMethod("getDefault", fn() => "N");
        $this->email_enviado->InputTextType = "text";
        $this->email_enviado->Raw = true;
        $this->email_enviado->Lookup = new Lookup($this->email_enviado, 'sco_reembolso', false, '', ["","","",""], '', '', [], [], [], [], [], [], false, '', '', "");
        $this->email_enviado->OptionCount = 2;
        $this->email_enviado->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['email_enviado'] = &$this->email_enviado;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "sco_reembolso";
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
            $this->Nreembolso->setDbValue($conn->lastInsertId());
            $rs['Nreembolso'] = $this->Nreembolso->DbValue;
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
            if (!isset($rs['Nreembolso']) && !EmptyValue($this->Nreembolso->CurrentValue)) {
                $rs['Nreembolso'] = $this->Nreembolso->CurrentValue;
            }
        }
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'Nreembolso';
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
            if (array_key_exists('Nreembolso', $rs)) {
                AddFilter($where, QuotedName('Nreembolso', $this->Dbid) . '=' . QuotedValue($rs['Nreembolso'], $this->Nreembolso->DataType, $this->Dbid));
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
        $this->Nreembolso->DbValue = $row['Nreembolso'];
        $this->expediente->DbValue = $row['expediente'];
        $this->fecha->DbValue = $row['fecha'];
        $this->monto_usd->DbValue = $row['monto_usd'];
        $this->fecha_tasa->DbValue = $row['fecha_tasa'];
        $this->tasa->DbValue = $row['tasa'];
        $this->monto_bs->DbValue = $row['monto_bs'];
        $this->banco->DbValue = $row['banco'];
        $this->nro_cta->DbValue = $row['nro_cta'];
        $this->titular->DbValue = $row['titular'];
        $this->ci_rif->DbValue = $row['ci_rif'];
        $this->correo->DbValue = $row['correo'];
        $this->nro_ref->DbValue = $row['nro_ref'];
        $this->motivo->DbValue = $row['motivo'];
        $this->nota->DbValue = $row['nota'];
        $this->estatus->DbValue = $row['estatus'];
        $this->coordinador->DbValue = $row['coordinador'];
        $this->pagador->DbValue = $row['pagador'];
        $this->fecha_pago->DbValue = $row['fecha_pago'];
        $this->email_enviado->DbValue = $row['email_enviado'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Nreembolso` = @Nreembolso@";
    }

    // Get Key
    public function getKey($current = false, $keySeparator = null)
    {
        $keys = [];
        $val = $current ? $this->Nreembolso->CurrentValue : $this->Nreembolso->OldValue;
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
                $this->Nreembolso->CurrentValue = $keys[0];
            } else {
                $this->Nreembolso->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Nreembolso', $row) ? $row['Nreembolso'] : null;
        } else {
            $val = !EmptyValue($this->Nreembolso->OldValue) && !$current ? $this->Nreembolso->OldValue : $this->Nreembolso->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Nreembolso@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("ScoReembolsoList");
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
            "ScoReembolsoView" => $Language->phrase("View"),
            "ScoReembolsoEdit" => $Language->phrase("Edit"),
            "ScoReembolsoAdd" => $Language->phrase("Add"),
            default => ""
        };
    }

    // Default route URL
    public function getDefaultRouteUrl()
    {
        return "ScoReembolsoList";
    }

    // API page name
    public function getApiPageName($action)
    {
        return match (strtolower($action)) {
            Config("API_VIEW_ACTION") => "ScoReembolsoView",
            Config("API_ADD_ACTION") => "ScoReembolsoAdd",
            Config("API_EDIT_ACTION") => "ScoReembolsoEdit",
            Config("API_DELETE_ACTION") => "ScoReembolsoDelete",
            Config("API_LIST_ACTION") => "ScoReembolsoList",
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
        return "ScoReembolsoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ScoReembolsoView", $parm);
        } else {
            $url = $this->keyUrl("ScoReembolsoView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ScoReembolsoAdd?" . $parm;
        } else {
            $url = "ScoReembolsoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ScoReembolsoEdit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("ScoReembolsoList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("ScoReembolsoAdd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("ScoReembolsoList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl($parm = "")
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("ScoReembolsoDelete", $parm);
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
        $json .= "\"Nreembolso\":" . VarToJson($this->Nreembolso->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Nreembolso->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Nreembolso->CurrentValue);
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
            if (($keyValue = Param("Nreembolso") ?? Route("Nreembolso")) !== null) {
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
                $this->Nreembolso->CurrentValue = $key;
            } else {
                $this->Nreembolso->OldValue = $key;
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
        $this->Nreembolso->setDbValue($row['Nreembolso']);
        $this->expediente->setDbValue($row['expediente']);
        $this->fecha->setDbValue($row['fecha']);
        $this->monto_usd->setDbValue($row['monto_usd']);
        $this->fecha_tasa->setDbValue($row['fecha_tasa']);
        $this->tasa->setDbValue($row['tasa']);
        $this->monto_bs->setDbValue($row['monto_bs']);
        $this->banco->setDbValue($row['banco']);
        $this->nro_cta->setDbValue($row['nro_cta']);
        $this->titular->setDbValue($row['titular']);
        $this->ci_rif->setDbValue($row['ci_rif']);
        $this->correo->setDbValue($row['correo']);
        $this->nro_ref->setDbValue($row['nro_ref']);
        $this->motivo->setDbValue($row['motivo']);
        $this->nota->setDbValue($row['nota']);
        $this->estatus->setDbValue($row['estatus']);
        $this->coordinador->setDbValue($row['coordinador']);
        $this->pagador->setDbValue($row['pagador']);
        $this->fecha_pago->setDbValue($row['fecha_pago']);
        $this->email_enviado->setDbValue($row['email_enviado']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ScoReembolsoList";
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

        // Nreembolso

        // expediente

        // fecha

        // monto_usd

        // fecha_tasa

        // tasa

        // monto_bs

        // banco

        // nro_cta

        // titular

        // ci_rif

        // correo

        // nro_ref

        // motivo

        // nota

        // estatus

        // coordinador

        // pagador

        // fecha_pago

        // email_enviado

        // Nreembolso
        $this->Nreembolso->ViewValue = $this->Nreembolso->CurrentValue;

        // expediente
        $this->expediente->ViewValue = $this->expediente->CurrentValue;

        // fecha
        $this->fecha->ViewValue = $this->fecha->CurrentValue;
        $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, $this->fecha->formatPattern());

        // monto_usd
        $this->monto_usd->ViewValue = $this->monto_usd->CurrentValue;
        $this->monto_usd->ViewValue = FormatNumber($this->monto_usd->ViewValue, $this->monto_usd->formatPattern());

        // fecha_tasa
        $this->fecha_tasa->ViewValue = $this->fecha_tasa->CurrentValue;
        $this->fecha_tasa->ViewValue = FormatDateTime($this->fecha_tasa->ViewValue, $this->fecha_tasa->formatPattern());

        // tasa
        $this->tasa->ViewValue = $this->tasa->CurrentValue;
        $this->tasa->ViewValue = FormatNumber($this->tasa->ViewValue, $this->tasa->formatPattern());

        // monto_bs
        $this->monto_bs->ViewValue = $this->monto_bs->CurrentValue;
        $this->monto_bs->ViewValue = FormatNumber($this->monto_bs->ViewValue, $this->monto_bs->formatPattern());

        // banco
        $this->banco->ViewValue = $this->banco->CurrentValue;

        // nro_cta
        $this->nro_cta->ViewValue = $this->nro_cta->CurrentValue;

        // titular
        $this->titular->ViewValue = $this->titular->CurrentValue;

        // ci_rif
        $this->ci_rif->ViewValue = $this->ci_rif->CurrentValue;

        // correo
        $this->correo->ViewValue = $this->correo->CurrentValue;

        // nro_ref
        $this->nro_ref->ViewValue = $this->nro_ref->CurrentValue;

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

        // nota
        $this->nota->ViewValue = $this->nota->CurrentValue;

        // estatus
        if (strval($this->estatus->CurrentValue) != "") {
            $this->estatus->ViewValue = $this->estatus->optionCaption($this->estatus->CurrentValue);
        } else {
            $this->estatus->ViewValue = null;
        }

        // coordinador
        $this->coordinador->ViewValue = $this->coordinador->CurrentValue;
        $curVal = strval($this->coordinador->CurrentValue);
        if ($curVal != "") {
            $this->coordinador->ViewValue = $this->coordinador->lookupCacheOption($curVal);
            if ($this->coordinador->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->coordinador->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->coordinador->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->coordinador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->coordinador->Lookup->renderViewRow($rswrk[0]);
                    $this->coordinador->ViewValue = $this->coordinador->displayValue($arwrk);
                } else {
                    $this->coordinador->ViewValue = $this->coordinador->CurrentValue;
                }
            }
        } else {
            $this->coordinador->ViewValue = null;
        }

        // pagador
        $this->pagador->ViewValue = $this->pagador->CurrentValue;
        $curVal = strval($this->pagador->CurrentValue);
        if ($curVal != "") {
            $this->pagador->ViewValue = $this->pagador->lookupCacheOption($curVal);
            if ($this->pagador->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter($this->pagador->Lookup->getTable()->Fields["username"]->searchExpression(), "=", $curVal, $this->pagador->Lookup->getTable()->Fields["username"]->searchDataType(), "");
                $sqlWrk = $this->pagador->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCache($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->pagador->Lookup->renderViewRow($rswrk[0]);
                    $this->pagador->ViewValue = $this->pagador->displayValue($arwrk);
                } else {
                    $this->pagador->ViewValue = $this->pagador->CurrentValue;
                }
            }
        } else {
            $this->pagador->ViewValue = null;
        }

        // fecha_pago
        $this->fecha_pago->ViewValue = $this->fecha_pago->CurrentValue;
        $this->fecha_pago->ViewValue = FormatDateTime($this->fecha_pago->ViewValue, $this->fecha_pago->formatPattern());

        // email_enviado
        if (strval($this->email_enviado->CurrentValue) != "") {
            $this->email_enviado->ViewValue = $this->email_enviado->optionCaption($this->email_enviado->CurrentValue);
        } else {
            $this->email_enviado->ViewValue = null;
        }

        // Nreembolso
        $this->Nreembolso->HrefValue = "";
        $this->Nreembolso->TooltipValue = "";

        // expediente
        $this->expediente->HrefValue = "";
        $this->expediente->TooltipValue = "";

        // fecha
        $this->fecha->HrefValue = "";
        $this->fecha->TooltipValue = "";

        // monto_usd
        $this->monto_usd->HrefValue = "";
        $this->monto_usd->TooltipValue = "";

        // fecha_tasa
        $this->fecha_tasa->HrefValue = "";
        $this->fecha_tasa->TooltipValue = "";

        // tasa
        $this->tasa->HrefValue = "";
        $this->tasa->TooltipValue = "";

        // monto_bs
        $this->monto_bs->HrefValue = "";
        $this->monto_bs->TooltipValue = "";

        // banco
        $this->banco->HrefValue = "";
        $this->banco->TooltipValue = "";

        // nro_cta
        $this->nro_cta->HrefValue = "";
        $this->nro_cta->TooltipValue = "";

        // titular
        $this->titular->HrefValue = "";
        $this->titular->TooltipValue = "";

        // ci_rif
        $this->ci_rif->HrefValue = "";
        $this->ci_rif->TooltipValue = "";

        // correo
        $this->correo->HrefValue = "";
        $this->correo->TooltipValue = "";

        // nro_ref
        $this->nro_ref->HrefValue = "";
        $this->nro_ref->TooltipValue = "";

        // motivo
        $this->motivo->HrefValue = "";
        $this->motivo->TooltipValue = "";

        // nota
        $this->nota->HrefValue = "";
        $this->nota->TooltipValue = "";

        // estatus
        $this->estatus->HrefValue = "";
        $this->estatus->TooltipValue = "";

        // coordinador
        $this->coordinador->HrefValue = "";
        $this->coordinador->TooltipValue = "";

        // pagador
        $this->pagador->HrefValue = "";
        $this->pagador->TooltipValue = "";

        // fecha_pago
        $this->fecha_pago->HrefValue = "";
        $this->fecha_pago->TooltipValue = "";

        // email_enviado
        $this->email_enviado->HrefValue = "";
        $this->email_enviado->TooltipValue = "";

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

        // Nreembolso
        $this->Nreembolso->setupEditAttributes();
        $this->Nreembolso->EditValue = $this->Nreembolso->CurrentValue;

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

        // monto_usd
        $this->monto_usd->setupEditAttributes();
        $this->monto_usd->EditValue = $this->monto_usd->CurrentValue;
        $this->monto_usd->PlaceHolder = RemoveHtml($this->monto_usd->caption());
        if (strval($this->monto_usd->EditValue) != "" && is_numeric($this->monto_usd->EditValue)) {
            $this->monto_usd->EditValue = FormatNumber($this->monto_usd->EditValue, null);
        }

        // fecha_tasa
        $this->fecha_tasa->setupEditAttributes();
        $this->fecha_tasa->EditValue = FormatDateTime($this->fecha_tasa->CurrentValue, $this->fecha_tasa->formatPattern());
        $this->fecha_tasa->PlaceHolder = RemoveHtml($this->fecha_tasa->caption());

        // tasa
        $this->tasa->setupEditAttributes();
        $this->tasa->EditValue = $this->tasa->CurrentValue;
        $this->tasa->PlaceHolder = RemoveHtml($this->tasa->caption());
        if (strval($this->tasa->EditValue) != "" && is_numeric($this->tasa->EditValue)) {
            $this->tasa->EditValue = FormatNumber($this->tasa->EditValue, null);
        }

        // monto_bs
        $this->monto_bs->setupEditAttributes();
        $this->monto_bs->EditValue = $this->monto_bs->CurrentValue;
        $this->monto_bs->PlaceHolder = RemoveHtml($this->monto_bs->caption());
        if (strval($this->monto_bs->EditValue) != "" && is_numeric($this->monto_bs->EditValue)) {
            $this->monto_bs->EditValue = FormatNumber($this->monto_bs->EditValue, null);
        }

        // banco
        $this->banco->setupEditAttributes();
        if (!$this->banco->Raw) {
            $this->banco->CurrentValue = HtmlDecode($this->banco->CurrentValue);
        }
        $this->banco->EditValue = $this->banco->CurrentValue;
        $this->banco->PlaceHolder = RemoveHtml($this->banco->caption());

        // nro_cta
        $this->nro_cta->setupEditAttributes();
        if (!$this->nro_cta->Raw) {
            $this->nro_cta->CurrentValue = HtmlDecode($this->nro_cta->CurrentValue);
        }
        $this->nro_cta->EditValue = $this->nro_cta->CurrentValue;
        $this->nro_cta->PlaceHolder = RemoveHtml($this->nro_cta->caption());

        // titular
        $this->titular->setupEditAttributes();
        if (!$this->titular->Raw) {
            $this->titular->CurrentValue = HtmlDecode($this->titular->CurrentValue);
        }
        $this->titular->EditValue = $this->titular->CurrentValue;
        $this->titular->PlaceHolder = RemoveHtml($this->titular->caption());

        // ci_rif
        $this->ci_rif->setupEditAttributes();
        if (!$this->ci_rif->Raw) {
            $this->ci_rif->CurrentValue = HtmlDecode($this->ci_rif->CurrentValue);
        }
        $this->ci_rif->EditValue = $this->ci_rif->CurrentValue;
        $this->ci_rif->PlaceHolder = RemoveHtml($this->ci_rif->caption());

        // correo
        $this->correo->setupEditAttributes();
        if (!$this->correo->Raw) {
            $this->correo->CurrentValue = HtmlDecode($this->correo->CurrentValue);
        }
        $this->correo->EditValue = $this->correo->CurrentValue;
        $this->correo->PlaceHolder = RemoveHtml($this->correo->caption());

        // nro_ref
        $this->nro_ref->setupEditAttributes();
        if (!$this->nro_ref->Raw) {
            $this->nro_ref->CurrentValue = HtmlDecode($this->nro_ref->CurrentValue);
        }
        $this->nro_ref->EditValue = $this->nro_ref->CurrentValue;
        $this->nro_ref->PlaceHolder = RemoveHtml($this->nro_ref->caption());

        // motivo
        $this->motivo->setupEditAttributes();
        $this->motivo->PlaceHolder = RemoveHtml($this->motivo->caption());

        // nota
        $this->nota->setupEditAttributes();
        $this->nota->EditValue = $this->nota->CurrentValue;
        $this->nota->PlaceHolder = RemoveHtml($this->nota->caption());

        // estatus
        $this->estatus->setupEditAttributes();
        $this->estatus->EditValue = $this->estatus->options(true);
        $this->estatus->PlaceHolder = RemoveHtml($this->estatus->caption());

        // coordinador
        $this->coordinador->setupEditAttributes();
        if (!$this->coordinador->Raw) {
            $this->coordinador->CurrentValue = HtmlDecode($this->coordinador->CurrentValue);
        }
        $this->coordinador->EditValue = $this->coordinador->CurrentValue;
        $this->coordinador->PlaceHolder = RemoveHtml($this->coordinador->caption());

        // pagador
        $this->pagador->setupEditAttributes();
        if (!$this->pagador->Raw) {
            $this->pagador->CurrentValue = HtmlDecode($this->pagador->CurrentValue);
        }
        $this->pagador->EditValue = $this->pagador->CurrentValue;
        $this->pagador->PlaceHolder = RemoveHtml($this->pagador->caption());

        // fecha_pago
        $this->fecha_pago->setupEditAttributes();
        $this->fecha_pago->EditValue = FormatDateTime($this->fecha_pago->CurrentValue, $this->fecha_pago->formatPattern());
        $this->fecha_pago->PlaceHolder = RemoveHtml($this->fecha_pago->caption());

        // email_enviado
        $this->email_enviado->EditValue = $this->email_enviado->options(false);
        $this->email_enviado->PlaceHolder = RemoveHtml($this->email_enviado->caption());

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
                    $doc->exportCaption($this->monto_usd);
                    $doc->exportCaption($this->fecha_tasa);
                    $doc->exportCaption($this->tasa);
                    $doc->exportCaption($this->monto_bs);
                    $doc->exportCaption($this->banco);
                    $doc->exportCaption($this->nro_cta);
                    $doc->exportCaption($this->titular);
                    $doc->exportCaption($this->ci_rif);
                    $doc->exportCaption($this->correo);
                    $doc->exportCaption($this->nro_ref);
                    $doc->exportCaption($this->motivo);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->coordinador);
                    $doc->exportCaption($this->pagador);
                    $doc->exportCaption($this->fecha_pago);
                    $doc->exportCaption($this->email_enviado);
                } else {
                    $doc->exportCaption($this->Nreembolso);
                    $doc->exportCaption($this->expediente);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->monto_usd);
                    $doc->exportCaption($this->fecha_tasa);
                    $doc->exportCaption($this->tasa);
                    $doc->exportCaption($this->monto_bs);
                    $doc->exportCaption($this->banco);
                    $doc->exportCaption($this->nro_cta);
                    $doc->exportCaption($this->titular);
                    $doc->exportCaption($this->ci_rif);
                    $doc->exportCaption($this->correo);
                    $doc->exportCaption($this->nro_ref);
                    $doc->exportCaption($this->motivo);
                    $doc->exportCaption($this->nota);
                    $doc->exportCaption($this->estatus);
                    $doc->exportCaption($this->coordinador);
                    $doc->exportCaption($this->pagador);
                    $doc->exportCaption($this->fecha_pago);
                    $doc->exportCaption($this->email_enviado);
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
                        $doc->exportField($this->monto_usd);
                        $doc->exportField($this->fecha_tasa);
                        $doc->exportField($this->tasa);
                        $doc->exportField($this->monto_bs);
                        $doc->exportField($this->banco);
                        $doc->exportField($this->nro_cta);
                        $doc->exportField($this->titular);
                        $doc->exportField($this->ci_rif);
                        $doc->exportField($this->correo);
                        $doc->exportField($this->nro_ref);
                        $doc->exportField($this->motivo);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->coordinador);
                        $doc->exportField($this->pagador);
                        $doc->exportField($this->fecha_pago);
                        $doc->exportField($this->email_enviado);
                    } else {
                        $doc->exportField($this->Nreembolso);
                        $doc->exportField($this->expediente);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->monto_usd);
                        $doc->exportField($this->fecha_tasa);
                        $doc->exportField($this->tasa);
                        $doc->exportField($this->monto_bs);
                        $doc->exportField($this->banco);
                        $doc->exportField($this->nro_cta);
                        $doc->exportField($this->titular);
                        $doc->exportField($this->ci_rif);
                        $doc->exportField($this->correo);
                        $doc->exportField($this->nro_ref);
                        $doc->exportField($this->motivo);
                        $doc->exportField($this->nota);
                        $doc->exportField($this->estatus);
                        $doc->exportField($this->coordinador);
                        $doc->exportField($this->pagador);
                        $doc->exportField($this->fecha_pago);
                        $doc->exportField($this->email_enviado);
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
        WriteAuditLog(CurrentUserIdentifier(), $typ, 'sco_reembolso');
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
        $key .= $rs['Nreembolso'];

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
                WriteAuditLog($usr, "A", 'sco_reembolso', $fldname, $key, "", $newvalue);
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
        $key .= $rsold['Nreembolso'];

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
                    WriteAuditLog($usr, "U", 'sco_reembolso', $fldname, $key, $oldvalue, $newvalue);
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
        $key .= $rs['Nreembolso'];

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
                WriteAuditLog($usr, "D", 'sco_reembolso', $fldname, $key, $oldvalue);
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
    	$rsnew["coordinador"] = CurrentUserName();
    	$rsnew["fecha"] = date("Y-m-d");
    	$rsnew["fecha_tasa"] = date("Y-m-d");
    	$sql = "SELECT valor1 FROM sco_parametro WHERE codigo = '050';";
    	$rsnew["tasa"] = floatval(ExecuteScalar($sql));
    	$rsnew["monto_usd"] = floatval($rsnew["monto_usd"]);
    	$rsnew["monto_bs"] = $rsnew["monto_usd"] * $rsnew["tasa"];
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
    	// Enter your code here
    	// To cancel, set return value to FALSE
    	if($rsnew["estatus"] == "ANULADO") {
    		$rsnew["nota"] = $rsold["nota"] . "\n El usuario " . CurrentUserName() . " ANULO la venta el " . date("d-m-Y") . ".";
    		return true;
    	}
    	if(CurrentUserLevel() > -1) {
    		if($rsnew["estatus"] == "COMPRA") {
    			$this->CancelMessage = "No est&aacute; autorizado para revertir esta parcela; !!! verifique !!!.";
    			return FALSE;
    		}
    		if($rsold["estatus"] != "COMPRA") {
    			$this->CancelMessage = "La parcela est&aacute; vendida o anuladano, no se puede modificar; !!! verifique !!!.";
    			return FALSE;
    		}
    		if(trim($rsold["usuario_vende"]) == "") {
    			$rsnew["fecha_venta"] = date("Y-m-d");
    			$rsnew["usuario_vende"] = CurrentUserName();
    			$rsnew["estatus"] = "VENTA";
    		}
    	}
    	else {
    		if($rsnew["estatus"] == "COMPRA") {
    			$rsnew["valor_venta"] = 0.00;
    			$rsnew["tasa_venta"] = 0.00;
    			$rsnew["ci_comprador"] = "";
    			$rsnew["comprador"] = "";
    			$rsnew["fecha_venta"] = date("Y-m-d");
    			$rsnew["usuario_vende"] = CurrentUserName();
    			$rsnew["estatus"] = "COMPRA";
    			return TRUE;
    		}
    		$rsnew["fecha_venta"] = date("Y-m-d");
    		$rsnew["usuario_vende"] = CurrentUserName();
    		$rsnew["estatus"] = "VENTA";
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
    public function rowRendering() {
    	// Enter your code here	
    	if ($this->PageID == "list" || $this->PageID == "view" || $this->PageID == "edit") { // List/View page only
    		switch($this->estatus->CurrentValue) {
    		case "NUEVO":
    			$color = "RED";
    			break;
    		case "ANALISIS":
    			$color = "YELLOW";
    			break;
    		case "PAGADO":
    			$color = "GREEN";
    			break;
    		case "ANULADO":
    			$color = "BLACK";
    			break;
    		}
    		$style = "background-color: $color"; 	
    		$this->estatus->CellAttrs["style"] = $style;
    		$this->fecha->CellAttrs["style"] = $style;
    		$this->titular->CellAttrs["style"] = $style;
    		$this->motivo->CellAttrs["style"] = $style;
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
