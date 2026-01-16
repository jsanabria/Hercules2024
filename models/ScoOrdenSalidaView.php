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
 * Page class
 */
class ScoOrdenSalidaView extends ScoOrdenSalida
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoOrdenSalidaView";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoOrdenSalidaView";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Audit Trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<div id="ew-page-header">' . $header . '</div>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<div id="ew-page-footer">' . $footer . '</div>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->Norden_salida->setVisibility();
        $this->fecha_hora->setVisibility();
        $this->_username->setVisibility();
        $this->grupo->setVisibility();
        $this->conductor->setVisibility();
        $this->acompanantes->setVisibility();
        $this->placa->setVisibility();
        $this->motivo->setVisibility();
        $this->observaciones->setVisibility();
        $this->autoriza->setVisibility();
        $this->fecha_autoriza->setVisibility();
        $this->estatus->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_orden_salida';
        $this->TableName = 'sco_orden_salida';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-view-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_orden_salida)
        if (!isset($GLOBALS["sco_orden_salida"]) || $GLOBALS["sco_orden_salida"]::class == PROJECT_NAMESPACE . "sco_orden_salida") {
            $GLOBALS["sco_orden_salida"] = &$this;
        }

        // Set up record key
        if (($keyValue = Get("Norden_salida") ?? Route("Norden_salida")) !== null) {
            $this->RecKey["Norden_salida"] = $keyValue;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_orden_salida');
        }

        // Start timer
        $DebugTimer = Container("debug.timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(TagClassName: "ew-export-option");

        // Other options
        $this->OtherOptions = new ListOptionsArray();

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(TagClassName: "ew-detail-option");
        // Actions
        $this->OtherOptions["action"] = new ListOptions(TagClassName: "ew-action-option");
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return $Response?->getBody() ?? ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }
        DispatchEvent(new PageUnloadedEvent($this), PageUnloadedEvent::NAME);
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (WithJsonResponse()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $pageName = GetPageName($url);
                $result = ["url" => GetUrl($url), "modal" => "1"];  // Assume return to modal for simplicity
                if (!SameString($pageName, GetPageName($this->getListUrl()))) { // Not List page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = SameString($pageName, "ScoOrdenSalidaView"); // If View page, no primary button
                } else { // List page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from result set
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Result set
            while ($row = $rs->fetch()) {
                $this->loadRowValues($row); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($row);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DataType::BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['Norden_salida'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->Norden_salida->Visible = false;
        }
    }

    // Lookup data
    public function lookup(array $req = [], bool $response = true)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $req["field"] ?? null;
        if (!$fieldName) {
            return [];
        }
        $fld = $this->Fields[$fieldName];
        $lookup = $fld->Lookup;
        $name = $req["name"] ?? "";
        if (ContainsString($name, "query_builder_rule")) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $req["ajax"] ?? "unknown";
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $req["q"] ?? $req["sv"] ?? "";
            $pageSize = $req["n"] ?? $req["recperpage"] ?? 10;
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $req["q"] ?? "";
            $pageSize = $req["n"] ?? -1;
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $req["start"] ?? -1;
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $req["page"] ?? -1;
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($req["s"] ?? "");
        $userFilter = Decrypt($req["f"] ?? "");
        $userOrderBy = Decrypt($req["o"] ?? "");
        $keys = $req["keys"] ?? null;
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $req["v0"] ?? $req["lookupValue"] ?? "";
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $req["v" . $i] ?? "";
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, $response); // Use settings from current page
    }
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Load user profile
        if (IsLoggedIn()) {
            Profile()->setUserName(CurrentUserName())->loadFromStorage();
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        DispatchEvent(new PageLoadingEvent($this), PageLoadingEvent::NAME);

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->_username);
        $this->setupLookupOptions($this->grupo);
        $this->setupLookupOptions($this->conductor);
        $this->setupLookupOptions($this->placa);
        $this->setupLookupOptions($this->motivo);
        $this->setupLookupOptions($this->autoriza);
        $this->setupLookupOptions($this->estatus);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if (($keyValue = Get("Norden_salida") ?? Route("Norden_salida")) !== null) {
            $this->Norden_salida->setQueryStringValue($keyValue);
            $this->RecKey["Norden_salida"] = $this->Norden_salida->QueryStringValue;
        } elseif (Post("Norden_salida") !== null) {
            $this->Norden_salida->setFormValue(Post("Norden_salida"));
            $this->RecKey["Norden_salida"] = $this->Norden_salida->FormValue;
        } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
            $this->Norden_salida->setQueryStringValue($keyValue);
            $this->RecKey["Norden_salida"] = $this->Norden_salida->QueryStringValue;
        } elseif (!$loadCurrentRecord) {
            $returnUrl = "ScoOrdenSalidaList"; // Return to list
        }

        // Get action
        $this->CurrentAction = "show"; // Display
        switch ($this->CurrentAction) {
            case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $res = ($this->Recordset = ExecuteQuery($sql, $conn));
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "ScoOrdenSalidaList"; // No matching record, return to list
                    }
                break;
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = RowType::VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            if (!$this->isExport()) {
                $row = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
                $this->Recordset?->free();
                WriteJson(["success" => true, "action" => Config("API_VIEW_ACTION"), $this->TableVar => $row]);
                $this->terminate(true);
            }
            return;
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            DispatchEvent(new PageRenderingEvent($this), PageRenderingEvent::NAME);

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Disable Add/Edit/Copy/Delete for Modal and UseAjaxActions
        /*
        if ($this->IsModal && $this->UseAjaxActions) {
            $this->AddUrl = "";
            $this->EditUrl = "";
            $this->CopyUrl = "";
            $this->DeleteUrl = "";
        }
        */
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = $this->EditUrl != "" && $Security->canEdit();

        // Delete
        $item = &$option->add("delete");
        $url = GetUrl($this->DeleteUrl);
        $item->Body = "<a class=\"ew-action ew-delete\"" .
            ($this->InlineDelete || $this->IsModal ? " data-ew-action=\"inline-delete\"" : "") .
            " title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) .
            "\" href=\"" . HtmlEncode($url) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        $item->Visible = $this->DeleteUrl != "" && $Security->canDelete();

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = !IsJsonResponse() && false;
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from result set or record
     *
     * @param array $row Record
     * @return void
     */
    public function loadRowValues($row = null)
    {
        $row = is_array($row) ? $row : $this->newRow();

        // Call Row Selected event
        $this->rowSelected($row);
        if ($this->AuditTrailOnView) {
            $this->writeAuditTrailOnView($row);
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Norden_salida'] = $this->Norden_salida->DefaultValue;
        $row['fecha_hora'] = $this->fecha_hora->DefaultValue;
        $row['username'] = $this->_username->DefaultValue;
        $row['grupo'] = $this->grupo->DefaultValue;
        $row['conductor'] = $this->conductor->DefaultValue;
        $row['acompanantes'] = $this->acompanantes->DefaultValue;
        $row['placa'] = $this->placa->DefaultValue;
        $row['motivo'] = $this->motivo->DefaultValue;
        $row['observaciones'] = $this->observaciones->DefaultValue;
        $row['autoriza'] = $this->autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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

        // View row
        if ($this->RowType == RowType::VIEW) {
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
        }

        // Call Row Rendered event
        if ($this->RowType != RowType::AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("Home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoOrdenSalidaList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x__username":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_grupo":
                    break;
                case "x_conductor":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_placa":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_motivo":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                case "x_autoriza":
                    break;
                case "x_estatus":
                    $lookupFilter = $fld->getSelectFilter(); // PHP
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == "success") {
            //$msg = "your success message";
        } elseif ($type == "failure") {
            //$msg = "your failure message";
        } elseif ($type == "warning") {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header) {
        // Asumimos que 'conductor' y 'placa' son strings.
        $username_conductor = $this->conductor->CurrentValue;
        $placa_flota = $this->placa->CurrentValue;

        // Sanitización CRÍTICA: Prevenir inyección SQL.
        $username_seguro = AdjustSql($username_conductor);
        $placa_segura = AdjustSql($placa_flota);

        // Nota: La sentencia "SET NAMES 'utf8'" debe configurarse a nivel de conexión global, no aquí.
        // Se elimina el Execute("SET NAMES 'utf8'");

        // --- 1. Consulta 1: Datos del Conductor (Foto) ---
        $sql_conductor = "SELECT nombre, CONCAT('../carpetacarga/', foto) AS foto 
                          FROM sco_user 
                          WHERE username = '" . $username_seguro . "';"; // Uso de variable segura
        $row_conductor = ExecuteRow($sql_conductor);
        $output = '';

        // Mostrar thumbnail del conductor (si se encuentra la fila)
        if ($row_conductor) {
            $foto_url = htmlspecialchars($row_conductor["foto"]);
            $nombre_conductor = htmlspecialchars($row_conductor["nombre"]);
            $output .= '
                <div class="row">
                    <div class="col-md-2">
                        <div class="thumbnail">
                            <a href="' . $foto_url . '" target="_blank">
                                <img src="' . $foto_url . '" alt="Conductor" style="width:100%">
                                <div class="caption">
                                    <p>' . $nombre_conductor . '</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>'; // Se cierra la primera fila aquí.
        }

        // --- 2. Consulta 2: Obtener TODOS los archivos adjuntos de la flota (Eficiencia N+1) ---

        // Se resuelve el problema N+1 obteniendo todos los resultados en una sola consulta.
        $sql_adjuntos = "SELECT 
                            CONCAT('../carpetacarga/', a.archivo) AS archivo,
                            CONCAT('Marca: ', c.nombre) AS marca,
                            CONCAT('Modelo: ', d.nombre) AS modelo
                        FROM 
                            sco_adjunto a 
                            JOIN sco_flota b ON b.Nflota = a.flota 
                            LEFT OUTER JOIN sco_marca c ON c.Nmarca = b.marca 
                            LEFT OUTER JOIN sco_modelo d ON d.Nmodelo = b.modelo 
                        WHERE 
                            b.placa = '" . $placa_segura . "'
                            AND (a.archivo LIKE '%.jpg' OR a.archivo LIKE '%.png' OR a.archivo LIKE '%.bmp')
                        ORDER BY a.archivo ASC"; // Se añade ORDER BY para consistencia
        $rows_adjuntos = ExecuteRows($sql_adjuntos);

        // 3. --- Procesar y Mostrar Adjuntos (Máximo 4, si existen) ---
        $output .= '<div class="row">'; // Iniciar la fila para los adjuntos
        $contador = 0;
        if ($rows_adjuntos) {
            foreach ($rows_adjuntos as $row_adjunto) {
                if ($contador >= 4) break; // Limitar a 4 (0 a 3, para un layout 4-col)
                $archivo_url = htmlspecialchars($row_adjunto["archivo"]);
                $marca_texto = htmlspecialchars($row_adjunto["marca"]);
                $modelo_texto = htmlspecialchars($row_adjunto["modelo"]);

                // Nota: Se elimina utf8_decode() ya que la conexión debe manejar UTF-8 correctamente.
                // Si hay problemas de codificación, la raíz está en la configuración del servidor/BD.
                $output .= '
                    <div class="col-md-2">
                        <div class="thumbnail">
                            <a href="' . $archivo_url . '" target="_blank">
                                <img src="' . $archivo_url . '" alt="Flota" style="width:100%">
                                <div class="caption">
                                    <p>' . $marca_texto . '</p>
                                    <p>' . $modelo_texto . '</p>
                                </div>
                            </a>
                        </div>
                    </div>';
                $contador++;
            }
        }
        $output .= '</div>'; // Cerrar la fila de adjuntos

        // 4. --- Bloque de Autorización y Estatus ---
        $estatus = $this->estatus->CurrentValue;
        $orden_salida = $this->Norden_salida->CurrentValue;
        $current_user = CurrentUsername();
        if ($estatus == "P1") {
            $output .= '
                <div class="row" id="xAut">
                    <div class="col-md-3 alert alert-success">
                        <input type="checkbox" id="autorizado" name="autorizado" value="' . $current_user . "|" . $orden_salida . '"> 
                        <span class="glyphicon glyphicon-check"></span> <strong>Autorizar Salida</strong>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3 alert alert-danger">
                        <input type="checkbox" id="no_autorizado" name="no_autorizado" value="' . $current_user . "|" . $orden_salida . '"> 
                        <span class="glyphicon glyphicon-share"></span> <strong>No Autorizar Salida</strong>
                    </div>
                </div>';
        } elseif ($estatus == "NA") {
            $output .= '<div class="alert alert-danger" id="xAut"><span class="glyphicon glyphicon-remove"></span> <strong>Procesado No Autorizado</strong></div>';
        } else {
            $output .= '<div class="alert alert-success" id="xAut"><span class="glyphicon glyphicon-ok"></span> <strong>Procesado Autorizado</strong></div>';
        }
        $header = $output;
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }
}
