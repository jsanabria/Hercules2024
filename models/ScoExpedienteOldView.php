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
class ScoExpedienteOldView extends ScoExpedienteOld
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ScoExpedienteOldView";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "ScoExpedienteOldView";

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
        $this->Nexpediente->setVisibility();
        $this->tipo_contratacion->setVisibility();
        $this->seguro->setVisibility();
        $this->nacionalidad_contacto->setVisibility();
        $this->cedula_contacto->setVisibility();
        $this->nombre_contacto->setVisibility();
        $this->apellidos_contacto->setVisibility();
        $this->parentesco_contacto->setVisibility();
        $this->telefono_contacto1->setVisibility();
        $this->telefono_contacto2->setVisibility();
        $this->nacionalidad_fallecido->setVisibility();
        $this->cedula_fallecido->setVisibility();
        $this->sexo->setVisibility();
        $this->nombre_fallecido->setVisibility();
        $this->apellidos_fallecido->setVisibility();
        $this->fecha_nacimiento->setVisibility();
        $this->edad_fallecido->setVisibility();
        $this->estado_civil->setVisibility();
        $this->lugar_nacimiento_fallecido->setVisibility();
        $this->lugar_ocurrencia->setVisibility();
        $this->direccion_ocurrencia->setVisibility();
        $this->fecha_ocurrencia->setVisibility();
        $this->hora_ocurrencia->setVisibility();
        $this->causa_ocurrencia->setVisibility();
        $this->causa_otro->setVisibility();
        $this->descripcion_ocurrencia->setVisibility();
        $this->calidad->setVisibility();
        $this->costos->setVisibility();
        $this->venta->setVisibility();
        $this->user_registra->setVisibility();
        $this->fecha_registro->setVisibility();
        $this->user_cierra->setVisibility();
        $this->fecha_cierre->setVisibility();
        $this->estatus->setVisibility();
        $this->factura->setVisibility();
        $this->permiso->setVisibility();
        $this->unir_con_expediente->setVisibility();
        $this->nota->setVisibility();
        $this->_email->setVisibility();
        $this->religion->setVisibility();
        $this->servicio_tipo->setVisibility();
        $this->servicio->setVisibility();
        $this->funeraria->setVisibility();
        $this->marca_pasos->setVisibility();
        $this->autoriza_cremar->setVisibility();
        $this->username_autoriza->setVisibility();
        $this->fecha_autoriza->setVisibility();
        $this->peso->setVisibility();
        $this->contrato_parcela->setVisibility();
        $this->email_calidad->setVisibility();
        $this->certificado_defuncion->setVisibility();
        $this->parcela->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'sco_expediente_old';
        $this->TableName = 'sco_expediente_old';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-view-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("app.language");

        // Table object (sco_expediente_old)
        if (!isset($GLOBALS["sco_expediente_old"]) || $GLOBALS["sco_expediente_old"]::class == PROJECT_NAMESPACE . "sco_expediente_old") {
            $GLOBALS["sco_expediente_old"] = &$this;
        }

        // Set up record key
        if (($keyValue = Get("Nexpediente") ?? Route("Nexpediente")) !== null) {
            $this->RecKey["Nexpediente"] = $keyValue;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'sco_expediente_old');
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
                    $result["view"] = SameString($pageName, "ScoExpedienteOldView"); // If View page, no primary button
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
            $key .= @$ar['Nexpediente'];
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
            $this->Nexpediente->Visible = false;
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
        $this->setupLookupOptions($this->marca_pasos);
        $this->setupLookupOptions($this->autoriza_cremar);
        $this->setupLookupOptions($this->email_calidad);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
            $loadCurrentRecord = true;
        }
        if (($keyValue = Get("Nexpediente") ?? Route("Nexpediente")) !== null) {
            $this->Nexpediente->setQueryStringValue($keyValue);
            $this->RecKey["Nexpediente"] = $this->Nexpediente->QueryStringValue;
        } elseif (Post("Nexpediente") !== null) {
            $this->Nexpediente->setFormValue(Post("Nexpediente"));
            $this->RecKey["Nexpediente"] = $this->Nexpediente->FormValue;
        } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
            $this->Nexpediente->setQueryStringValue($keyValue);
            $this->RecKey["Nexpediente"] = $this->Nexpediente->QueryStringValue;
        } elseif (!$loadCurrentRecord) {
            $returnUrl = "ScoExpedienteOldList"; // Return to list
        }

        // Get action
        $this->CurrentAction = "show"; // Display
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal && !IsApi()) { // Normal view page
                    $this->StartRecord = 1; // Initialize start position
                    $this->Recordset = $this->loadRecordset(); // Load records
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("ScoExpedienteOldList"); // Return to list page
                        return;
                    } elseif ($loadCurrentRecord) { // Load current record position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $matchRecord = true;
                            $this->fetch($this->StartRecord);
                            // Redirect to correct record
                            $this->loadRowValues($this->CurrentRow);
                            $url = $this->getCurrentUrl();
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        while ($this->fetch()) {
                            if (SameString($this->Nexpediente->CurrentValue, $this->CurrentRow['Nexpediente'])) {
                                $this->setStartRecordNumber($this->StartRecord); // Save record position
                                $matchRecord = true;
                                break;
                            } else {
                                $this->StartRecord++;
                            }
                        }
                    }
                    if (!$matchRecord) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "ScoExpedienteOldList"; // No matching record, return to list
                    } else {
                        $this->loadRowValues($this->CurrentRow); // Load row values
                    }
                } else {
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
                        $returnUrl = "ScoExpedienteOldList"; // No matching record, return to list
                    }
                } // End modal checking
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

        // Set up pager
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_PAGE_NUMBER");
            $this->Pager->PagePhraseId = "Record"; // Show as record
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

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = $this->CopyUrl != "" && $Security->canAdd();

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
     * Load result set
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return Doctrine\DBAL\Result Result
     */
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        if (property_exists($this, "TotalRecords") && $rowcnt < 0) {
            $this->TotalRecords = $result->rowCount();
            if ($this->TotalRecords <= 0) { // Handle database drivers that does not return rowCount()
                $this->TotalRecords = $this->getRecordCount($this->getListSql());
            }
        }

        // Call Recordset Selected event
        $this->recordsetSelected($result);
        return $result;
    }

    /**
     * Load records as associative array
     *
     * @param int $offset Offset
     * @param int $rowcnt Maximum number of rows
     * @return void
     */
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load result set
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->executeQuery();
        return $result->fetchAllAssociative();
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
        $this->Nexpediente->setDbValue($row['Nexpediente']);
        $this->tipo_contratacion->setDbValue($row['tipo_contratacion']);
        $this->seguro->setDbValue($row['seguro']);
        $this->nacionalidad_contacto->setDbValue($row['nacionalidad_contacto']);
        $this->cedula_contacto->setDbValue($row['cedula_contacto']);
        $this->nombre_contacto->setDbValue($row['nombre_contacto']);
        $this->apellidos_contacto->setDbValue($row['apellidos_contacto']);
        $this->parentesco_contacto->setDbValue($row['parentesco_contacto']);
        $this->telefono_contacto1->setDbValue($row['telefono_contacto1']);
        $this->telefono_contacto2->setDbValue($row['telefono_contacto2']);
        $this->nacionalidad_fallecido->setDbValue($row['nacionalidad_fallecido']);
        $this->cedula_fallecido->setDbValue($row['cedula_fallecido']);
        $this->sexo->setDbValue($row['sexo']);
        $this->nombre_fallecido->setDbValue($row['nombre_fallecido']);
        $this->apellidos_fallecido->setDbValue($row['apellidos_fallecido']);
        $this->fecha_nacimiento->setDbValue($row['fecha_nacimiento']);
        $this->edad_fallecido->setDbValue($row['edad_fallecido']);
        $this->estado_civil->setDbValue($row['estado_civil']);
        $this->lugar_nacimiento_fallecido->setDbValue($row['lugar_nacimiento_fallecido']);
        $this->lugar_ocurrencia->setDbValue($row['lugar_ocurrencia']);
        $this->direccion_ocurrencia->setDbValue($row['direccion_ocurrencia']);
        $this->fecha_ocurrencia->setDbValue($row['fecha_ocurrencia']);
        $this->hora_ocurrencia->setDbValue($row['hora_ocurrencia']);
        $this->causa_ocurrencia->setDbValue($row['causa_ocurrencia']);
        $this->causa_otro->setDbValue($row['causa_otro']);
        $this->descripcion_ocurrencia->setDbValue($row['descripcion_ocurrencia']);
        $this->calidad->setDbValue($row['calidad']);
        $this->costos->setDbValue($row['costos']);
        $this->venta->setDbValue($row['venta']);
        $this->user_registra->setDbValue($row['user_registra']);
        $this->fecha_registro->setDbValue($row['fecha_registro']);
        $this->user_cierra->setDbValue($row['user_cierra']);
        $this->fecha_cierre->setDbValue($row['fecha_cierre']);
        $this->estatus->setDbValue($row['estatus']);
        $this->factura->setDbValue($row['factura']);
        $this->permiso->setDbValue($row['permiso']);
        $this->unir_con_expediente->setDbValue($row['unir_con_expediente']);
        $this->nota->setDbValue($row['nota']);
        $this->_email->setDbValue($row['email']);
        $this->religion->setDbValue($row['religion']);
        $this->servicio_tipo->setDbValue($row['servicio_tipo']);
        $this->servicio->setDbValue($row['servicio']);
        $this->funeraria->setDbValue($row['funeraria']);
        $this->marca_pasos->setDbValue($row['marca_pasos']);
        $this->autoriza_cremar->setDbValue($row['autoriza_cremar']);
        $this->username_autoriza->setDbValue($row['username_autoriza']);
        $this->fecha_autoriza->setDbValue($row['fecha_autoriza']);
        $this->peso->setDbValue($row['peso']);
        $this->contrato_parcela->setDbValue($row['contrato_parcela']);
        $this->email_calidad->setDbValue($row['email_calidad']);
        $this->certificado_defuncion->setDbValue($row['certificado_defuncion']);
        $this->parcela->setDbValue($row['parcela']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Nexpediente'] = $this->Nexpediente->DefaultValue;
        $row['tipo_contratacion'] = $this->tipo_contratacion->DefaultValue;
        $row['seguro'] = $this->seguro->DefaultValue;
        $row['nacionalidad_contacto'] = $this->nacionalidad_contacto->DefaultValue;
        $row['cedula_contacto'] = $this->cedula_contacto->DefaultValue;
        $row['nombre_contacto'] = $this->nombre_contacto->DefaultValue;
        $row['apellidos_contacto'] = $this->apellidos_contacto->DefaultValue;
        $row['parentesco_contacto'] = $this->parentesco_contacto->DefaultValue;
        $row['telefono_contacto1'] = $this->telefono_contacto1->DefaultValue;
        $row['telefono_contacto2'] = $this->telefono_contacto2->DefaultValue;
        $row['nacionalidad_fallecido'] = $this->nacionalidad_fallecido->DefaultValue;
        $row['cedula_fallecido'] = $this->cedula_fallecido->DefaultValue;
        $row['sexo'] = $this->sexo->DefaultValue;
        $row['nombre_fallecido'] = $this->nombre_fallecido->DefaultValue;
        $row['apellidos_fallecido'] = $this->apellidos_fallecido->DefaultValue;
        $row['fecha_nacimiento'] = $this->fecha_nacimiento->DefaultValue;
        $row['edad_fallecido'] = $this->edad_fallecido->DefaultValue;
        $row['estado_civil'] = $this->estado_civil->DefaultValue;
        $row['lugar_nacimiento_fallecido'] = $this->lugar_nacimiento_fallecido->DefaultValue;
        $row['lugar_ocurrencia'] = $this->lugar_ocurrencia->DefaultValue;
        $row['direccion_ocurrencia'] = $this->direccion_ocurrencia->DefaultValue;
        $row['fecha_ocurrencia'] = $this->fecha_ocurrencia->DefaultValue;
        $row['hora_ocurrencia'] = $this->hora_ocurrencia->DefaultValue;
        $row['causa_ocurrencia'] = $this->causa_ocurrencia->DefaultValue;
        $row['causa_otro'] = $this->causa_otro->DefaultValue;
        $row['descripcion_ocurrencia'] = $this->descripcion_ocurrencia->DefaultValue;
        $row['calidad'] = $this->calidad->DefaultValue;
        $row['costos'] = $this->costos->DefaultValue;
        $row['venta'] = $this->venta->DefaultValue;
        $row['user_registra'] = $this->user_registra->DefaultValue;
        $row['fecha_registro'] = $this->fecha_registro->DefaultValue;
        $row['user_cierra'] = $this->user_cierra->DefaultValue;
        $row['fecha_cierre'] = $this->fecha_cierre->DefaultValue;
        $row['estatus'] = $this->estatus->DefaultValue;
        $row['factura'] = $this->factura->DefaultValue;
        $row['permiso'] = $this->permiso->DefaultValue;
        $row['unir_con_expediente'] = $this->unir_con_expediente->DefaultValue;
        $row['nota'] = $this->nota->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['religion'] = $this->religion->DefaultValue;
        $row['servicio_tipo'] = $this->servicio_tipo->DefaultValue;
        $row['servicio'] = $this->servicio->DefaultValue;
        $row['funeraria'] = $this->funeraria->DefaultValue;
        $row['marca_pasos'] = $this->marca_pasos->DefaultValue;
        $row['autoriza_cremar'] = $this->autoriza_cremar->DefaultValue;
        $row['username_autoriza'] = $this->username_autoriza->DefaultValue;
        $row['fecha_autoriza'] = $this->fecha_autoriza->DefaultValue;
        $row['peso'] = $this->peso->DefaultValue;
        $row['contrato_parcela'] = $this->contrato_parcela->DefaultValue;
        $row['email_calidad'] = $this->email_calidad->DefaultValue;
        $row['certificado_defuncion'] = $this->certificado_defuncion->DefaultValue;
        $row['parcela'] = $this->parcela->DefaultValue;
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

        // Nexpediente

        // tipo_contratacion

        // seguro

        // nacionalidad_contacto

        // cedula_contacto

        // nombre_contacto

        // apellidos_contacto

        // parentesco_contacto

        // telefono_contacto1

        // telefono_contacto2

        // nacionalidad_fallecido

        // cedula_fallecido

        // sexo

        // nombre_fallecido

        // apellidos_fallecido

        // fecha_nacimiento

        // edad_fallecido

        // estado_civil

        // lugar_nacimiento_fallecido

        // lugar_ocurrencia

        // direccion_ocurrencia

        // fecha_ocurrencia

        // hora_ocurrencia

        // causa_ocurrencia

        // causa_otro

        // descripcion_ocurrencia

        // calidad

        // costos

        // venta

        // user_registra

        // fecha_registro

        // user_cierra

        // fecha_cierre

        // estatus

        // factura

        // permiso

        // unir_con_expediente

        // nota

        // email

        // religion

        // servicio_tipo

        // servicio

        // funeraria

        // marca_pasos

        // autoriza_cremar

        // username_autoriza

        // fecha_autoriza

        // peso

        // contrato_parcela

        // email_calidad

        // certificado_defuncion

        // parcela

        // View row
        if ($this->RowType == RowType::VIEW) {
            // Nexpediente
            $this->Nexpediente->ViewValue = $this->Nexpediente->CurrentValue;

            // tipo_contratacion
            $this->tipo_contratacion->ViewValue = $this->tipo_contratacion->CurrentValue;

            // seguro
            $this->seguro->ViewValue = $this->seguro->CurrentValue;
            $this->seguro->ViewValue = FormatNumber($this->seguro->ViewValue, $this->seguro->formatPattern());

            // nacionalidad_contacto
            $this->nacionalidad_contacto->ViewValue = $this->nacionalidad_contacto->CurrentValue;

            // cedula_contacto
            $this->cedula_contacto->ViewValue = $this->cedula_contacto->CurrentValue;

            // nombre_contacto
            $this->nombre_contacto->ViewValue = $this->nombre_contacto->CurrentValue;

            // apellidos_contacto
            $this->apellidos_contacto->ViewValue = $this->apellidos_contacto->CurrentValue;

            // parentesco_contacto
            $this->parentesco_contacto->ViewValue = $this->parentesco_contacto->CurrentValue;

            // telefono_contacto1
            $this->telefono_contacto1->ViewValue = $this->telefono_contacto1->CurrentValue;

            // telefono_contacto2
            $this->telefono_contacto2->ViewValue = $this->telefono_contacto2->CurrentValue;

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->ViewValue = $this->nacionalidad_fallecido->CurrentValue;

            // cedula_fallecido
            $this->cedula_fallecido->ViewValue = $this->cedula_fallecido->CurrentValue;

            // sexo
            $this->sexo->ViewValue = $this->sexo->CurrentValue;

            // nombre_fallecido
            $this->nombre_fallecido->ViewValue = $this->nombre_fallecido->CurrentValue;

            // apellidos_fallecido
            $this->apellidos_fallecido->ViewValue = $this->apellidos_fallecido->CurrentValue;

            // fecha_nacimiento
            $this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
            $this->fecha_nacimiento->ViewValue = FormatDateTime($this->fecha_nacimiento->ViewValue, $this->fecha_nacimiento->formatPattern());

            // edad_fallecido
            $this->edad_fallecido->ViewValue = $this->edad_fallecido->CurrentValue;
            $this->edad_fallecido->ViewValue = FormatNumber($this->edad_fallecido->ViewValue, $this->edad_fallecido->formatPattern());

            // estado_civil
            $this->estado_civil->ViewValue = $this->estado_civil->CurrentValue;

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->ViewValue = $this->lugar_nacimiento_fallecido->CurrentValue;

            // lugar_ocurrencia
            $this->lugar_ocurrencia->ViewValue = $this->lugar_ocurrencia->CurrentValue;

            // direccion_ocurrencia
            $this->direccion_ocurrencia->ViewValue = $this->direccion_ocurrencia->CurrentValue;

            // fecha_ocurrencia
            $this->fecha_ocurrencia->ViewValue = $this->fecha_ocurrencia->CurrentValue;
            $this->fecha_ocurrencia->ViewValue = FormatDateTime($this->fecha_ocurrencia->ViewValue, $this->fecha_ocurrencia->formatPattern());

            // hora_ocurrencia
            $this->hora_ocurrencia->ViewValue = $this->hora_ocurrencia->CurrentValue;
            $this->hora_ocurrencia->ViewValue = FormatDateTime($this->hora_ocurrencia->ViewValue, $this->hora_ocurrencia->formatPattern());

            // causa_ocurrencia
            $this->causa_ocurrencia->ViewValue = $this->causa_ocurrencia->CurrentValue;

            // causa_otro
            $this->causa_otro->ViewValue = $this->causa_otro->CurrentValue;

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->ViewValue = $this->descripcion_ocurrencia->CurrentValue;

            // calidad
            $this->calidad->ViewValue = $this->calidad->CurrentValue;

            // costos
            $this->costos->ViewValue = $this->costos->CurrentValue;
            $this->costos->ViewValue = FormatNumber($this->costos->ViewValue, $this->costos->formatPattern());

            // venta
            $this->venta->ViewValue = $this->venta->CurrentValue;
            $this->venta->ViewValue = FormatNumber($this->venta->ViewValue, $this->venta->formatPattern());

            // user_registra
            $this->user_registra->ViewValue = $this->user_registra->CurrentValue;

            // fecha_registro
            $this->fecha_registro->ViewValue = $this->fecha_registro->CurrentValue;
            $this->fecha_registro->ViewValue = FormatDateTime($this->fecha_registro->ViewValue, $this->fecha_registro->formatPattern());

            // user_cierra
            $this->user_cierra->ViewValue = $this->user_cierra->CurrentValue;

            // fecha_cierre
            $this->fecha_cierre->ViewValue = $this->fecha_cierre->CurrentValue;
            $this->fecha_cierre->ViewValue = FormatDateTime($this->fecha_cierre->ViewValue, $this->fecha_cierre->formatPattern());

            // estatus
            $this->estatus->ViewValue = $this->estatus->CurrentValue;
            $this->estatus->ViewValue = FormatNumber($this->estatus->ViewValue, $this->estatus->formatPattern());

            // factura
            $this->factura->ViewValue = $this->factura->CurrentValue;

            // permiso
            $this->permiso->ViewValue = $this->permiso->CurrentValue;

            // unir_con_expediente
            $this->unir_con_expediente->ViewValue = $this->unir_con_expediente->CurrentValue;
            $this->unir_con_expediente->ViewValue = FormatNumber($this->unir_con_expediente->ViewValue, $this->unir_con_expediente->formatPattern());

            // nota
            $this->nota->ViewValue = $this->nota->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // religion
            $this->religion->ViewValue = $this->religion->CurrentValue;

            // servicio_tipo
            $this->servicio_tipo->ViewValue = $this->servicio_tipo->CurrentValue;

            // servicio
            $this->servicio->ViewValue = $this->servicio->CurrentValue;

            // funeraria
            $this->funeraria->ViewValue = $this->funeraria->CurrentValue;
            $this->funeraria->ViewValue = FormatNumber($this->funeraria->ViewValue, $this->funeraria->formatPattern());

            // marca_pasos
            if (strval($this->marca_pasos->CurrentValue) != "") {
                $this->marca_pasos->ViewValue = $this->marca_pasos->optionCaption($this->marca_pasos->CurrentValue);
            } else {
                $this->marca_pasos->ViewValue = null;
            }

            // autoriza_cremar
            if (strval($this->autoriza_cremar->CurrentValue) != "") {
                $this->autoriza_cremar->ViewValue = $this->autoriza_cremar->optionCaption($this->autoriza_cremar->CurrentValue);
            } else {
                $this->autoriza_cremar->ViewValue = null;
            }

            // username_autoriza
            $this->username_autoriza->ViewValue = $this->username_autoriza->CurrentValue;

            // fecha_autoriza
            $this->fecha_autoriza->ViewValue = $this->fecha_autoriza->CurrentValue;
            $this->fecha_autoriza->ViewValue = FormatDateTime($this->fecha_autoriza->ViewValue, $this->fecha_autoriza->formatPattern());

            // peso
            $this->peso->ViewValue = $this->peso->CurrentValue;

            // contrato_parcela
            $this->contrato_parcela->ViewValue = $this->contrato_parcela->CurrentValue;

            // email_calidad
            if (strval($this->email_calidad->CurrentValue) != "") {
                $this->email_calidad->ViewValue = $this->email_calidad->optionCaption($this->email_calidad->CurrentValue);
            } else {
                $this->email_calidad->ViewValue = null;
            }

            // certificado_defuncion
            $this->certificado_defuncion->ViewValue = $this->certificado_defuncion->CurrentValue;

            // parcela
            $this->parcela->ViewValue = $this->parcela->CurrentValue;

            // Nexpediente
            $this->Nexpediente->HrefValue = "";
            $this->Nexpediente->TooltipValue = "";

            // tipo_contratacion
            $this->tipo_contratacion->HrefValue = "";
            $this->tipo_contratacion->TooltipValue = "";

            // seguro
            $this->seguro->HrefValue = "";
            $this->seguro->TooltipValue = "";

            // nacionalidad_contacto
            $this->nacionalidad_contacto->HrefValue = "";
            $this->nacionalidad_contacto->TooltipValue = "";

            // cedula_contacto
            $this->cedula_contacto->HrefValue = "";
            $this->cedula_contacto->TooltipValue = "";

            // nombre_contacto
            $this->nombre_contacto->HrefValue = "";
            $this->nombre_contacto->TooltipValue = "";

            // apellidos_contacto
            $this->apellidos_contacto->HrefValue = "";
            $this->apellidos_contacto->TooltipValue = "";

            // parentesco_contacto
            $this->parentesco_contacto->HrefValue = "";
            $this->parentesco_contacto->TooltipValue = "";

            // telefono_contacto1
            $this->telefono_contacto1->HrefValue = "";
            $this->telefono_contacto1->TooltipValue = "";

            // telefono_contacto2
            $this->telefono_contacto2->HrefValue = "";
            $this->telefono_contacto2->TooltipValue = "";

            // nacionalidad_fallecido
            $this->nacionalidad_fallecido->HrefValue = "";
            $this->nacionalidad_fallecido->TooltipValue = "";

            // cedula_fallecido
            $this->cedula_fallecido->HrefValue = "";
            $this->cedula_fallecido->TooltipValue = "";

            // sexo
            $this->sexo->HrefValue = "";
            $this->sexo->TooltipValue = "";

            // nombre_fallecido
            $this->nombre_fallecido->HrefValue = "";
            $this->nombre_fallecido->TooltipValue = "";

            // apellidos_fallecido
            $this->apellidos_fallecido->HrefValue = "";
            $this->apellidos_fallecido->TooltipValue = "";

            // fecha_nacimiento
            $this->fecha_nacimiento->HrefValue = "";
            $this->fecha_nacimiento->TooltipValue = "";

            // edad_fallecido
            $this->edad_fallecido->HrefValue = "";
            $this->edad_fallecido->TooltipValue = "";

            // estado_civil
            $this->estado_civil->HrefValue = "";
            $this->estado_civil->TooltipValue = "";

            // lugar_nacimiento_fallecido
            $this->lugar_nacimiento_fallecido->HrefValue = "";
            $this->lugar_nacimiento_fallecido->TooltipValue = "";

            // lugar_ocurrencia
            $this->lugar_ocurrencia->HrefValue = "";
            $this->lugar_ocurrencia->TooltipValue = "";

            // direccion_ocurrencia
            $this->direccion_ocurrencia->HrefValue = "";
            $this->direccion_ocurrencia->TooltipValue = "";

            // fecha_ocurrencia
            $this->fecha_ocurrencia->HrefValue = "";
            $this->fecha_ocurrencia->TooltipValue = "";

            // hora_ocurrencia
            $this->hora_ocurrencia->HrefValue = "";
            $this->hora_ocurrencia->TooltipValue = "";

            // causa_ocurrencia
            $this->causa_ocurrencia->HrefValue = "";
            $this->causa_ocurrencia->TooltipValue = "";

            // causa_otro
            $this->causa_otro->HrefValue = "";
            $this->causa_otro->TooltipValue = "";

            // descripcion_ocurrencia
            $this->descripcion_ocurrencia->HrefValue = "";
            $this->descripcion_ocurrencia->TooltipValue = "";

            // calidad
            $this->calidad->HrefValue = "";
            $this->calidad->TooltipValue = "";

            // costos
            $this->costos->HrefValue = "";
            $this->costos->TooltipValue = "";

            // venta
            $this->venta->HrefValue = "";
            $this->venta->TooltipValue = "";

            // user_registra
            $this->user_registra->HrefValue = "";
            $this->user_registra->TooltipValue = "";

            // fecha_registro
            $this->fecha_registro->HrefValue = "";
            $this->fecha_registro->TooltipValue = "";

            // user_cierra
            $this->user_cierra->HrefValue = "";
            $this->user_cierra->TooltipValue = "";

            // fecha_cierre
            $this->fecha_cierre->HrefValue = "";
            $this->fecha_cierre->TooltipValue = "";

            // estatus
            $this->estatus->HrefValue = "";
            $this->estatus->TooltipValue = "";

            // factura
            $this->factura->HrefValue = "";
            $this->factura->TooltipValue = "";

            // permiso
            $this->permiso->HrefValue = "";
            $this->permiso->TooltipValue = "";

            // unir_con_expediente
            $this->unir_con_expediente->HrefValue = "";
            $this->unir_con_expediente->TooltipValue = "";

            // nota
            $this->nota->HrefValue = "";
            $this->nota->TooltipValue = "";

            // email
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // religion
            $this->religion->HrefValue = "";
            $this->religion->TooltipValue = "";

            // servicio_tipo
            $this->servicio_tipo->HrefValue = "";
            $this->servicio_tipo->TooltipValue = "";

            // servicio
            $this->servicio->HrefValue = "";
            $this->servicio->TooltipValue = "";

            // funeraria
            $this->funeraria->HrefValue = "";
            $this->funeraria->TooltipValue = "";

            // marca_pasos
            $this->marca_pasos->HrefValue = "";
            $this->marca_pasos->TooltipValue = "";

            // autoriza_cremar
            $this->autoriza_cremar->HrefValue = "";
            $this->autoriza_cremar->TooltipValue = "";

            // username_autoriza
            $this->username_autoriza->HrefValue = "";
            $this->username_autoriza->TooltipValue = "";

            // fecha_autoriza
            $this->fecha_autoriza->HrefValue = "";
            $this->fecha_autoriza->TooltipValue = "";

            // peso
            $this->peso->HrefValue = "";
            $this->peso->TooltipValue = "";

            // contrato_parcela
            $this->contrato_parcela->HrefValue = "";
            $this->contrato_parcela->TooltipValue = "";

            // email_calidad
            $this->email_calidad->HrefValue = "";
            $this->email_calidad->TooltipValue = "";

            // certificado_defuncion
            $this->certificado_defuncion->HrefValue = "";
            $this->certificado_defuncion->TooltipValue = "";

            // parcela
            $this->parcela->HrefValue = "";
            $this->parcela->TooltipValue = "";
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ScoExpedienteOldList"), "", $this->TableVar, true);
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
                case "x_marca_pasos":
                    break;
                case "x_autoriza_cremar":
                    break;
                case "x_email_calidad":
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
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
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
