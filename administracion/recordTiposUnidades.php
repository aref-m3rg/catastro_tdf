<?php
//Include Common Files @1-5EA5C80F
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "recordTiposUnidades.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @4-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

class clsRecordtramites { //tramites Class @6-60ACB3E3

//Variables @6-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @6-CF43A3E7
    function clsRecordtramites($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tramites/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tramites";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tramite_id = new clsControl(ccsListBox, "s_tramite_id", "tramite", ccsInteger, "", CCGetRequestParam("s_tramite_id", $Method, NULL), $this);
            $this->s_tramite_id->DSType = dsTable;
            $this->s_tramite_id->DataSource = new clsDBmesa();
            $this->s_tramite_id->ds = & $this->s_tramite_id->DataSource;
            $this->s_tramite_id->DataSource->SQL = "SELECT * \n" .
"FROM tramites {SQL_Where} {SQL_OrderBy}";
            list($this->s_tramite_id->BoundColumn, $this->s_tramite_id->TextColumn, $this->s_tramite_id->DBFormat) = array("tramite_id", "tramite_desc", "");
            $this->s_tramite_id->Required = true;
            $this->s_tipo_tramites_id = new clsControl(ccsListBox, "s_tipo_tramites_id", "Operacion", ccsInteger, "", CCGetRequestParam("s_tipo_tramites_id", $Method, NULL), $this);
            $this->s_tipo_tramites_id->DSType = dsTable;
            $this->s_tipo_tramites_id->DataSource = new clsDBmesa();
            $this->s_tipo_tramites_id->ds = & $this->s_tipo_tramites_id->DataSource;
            $this->s_tipo_tramites_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_tramites {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_tramites_id->BoundColumn, $this->s_tipo_tramites_id->TextColumn, $this->s_tipo_tramites_id->DBFormat) = array("tipo_tramites_id", "tipo_tramites_descript", "");
            $this->s_tipo_tramites_id->Required = true;
            $this->Button_Search = new clsButton("Button_Search", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @6-4F2A12D8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tramite_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_tramites_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tramite_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_tramites_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-216D4AD3
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_tramite_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_tramites_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @6-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @6-FEDA8206
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            } else if($this->Button_Search->Pressed) {
                $this->PressedButton = "Button_Search";
            }
        }
        $Redirect = "recordTiposUnidades.php";
        if($this->PressedButton == "Button_Search") {
            $Redirect = "recordTipos.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_Search", "Button_Search_x", "Button_Search_y", "s_tramite_id", "s_tipo_tramites_id")));
            if(!CCGetEvent($this->Button_Search->CCSEvents, "OnClick", $this->Button_Search)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "recordTiposUnidades.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_Search", "Button_Search_x", "Button_Search_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @6-DAEB2C3B
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->s_tramite_id->Prepare();
        $this->s_tipo_tramites_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_tramite_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_tramites_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_tramite_id->Show();
        $this->s_tipo_tramites_id->Show();
        $this->Button_Search->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tramites Class @6-FCB6E20C

class clsRecordtipos_tramites { //tipos_tramites Class @12-93A875EA

//Variables @12-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @12-91A26755
    function clsRecordtipos_tramites($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_tramites/Error";
        $this->DataSource = new clstipos_tramitesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_tramites";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->tipo_tramites_descript = new clsControl(ccsLabel, "tipo_tramites_descript", "Tipo Tramites Descript", ccsText, "", CCGetRequestParam("tipo_tramites_descript", $Method, NULL), $this);
            $this->unidad_id = new clsControl(ccsCheckBoxList, "unidad_id", "unidad_id", ccsInteger, "", CCGetRequestParam("unidad_id", $Method, NULL), $this);
            $this->unidad_id->Multiple = true;
            $this->unidad_id->DSType = dsTable;
            $this->unidad_id->DataSource = new clsDBmesa();
            $this->unidad_id->ds = & $this->unidad_id->DataSource;
            $this->unidad_id->DataSource->SQL = "SELECT unidades.*, entorno_desc, concat('(',entorno_desc,')\t',unidades.unidad_nombre) AS descripcion \n" .
"FROM unidades INNER JOIN entornos ON\n" .
"unidades.entorno_id = entornos.entorno_id {SQL_Where} {SQL_OrderBy}";
            $this->unidad_id->DataSource->Order = "entorno_desc desc, unidades.unidad_nombre";
            list($this->unidad_id->BoundColumn, $this->unidad_id->TextColumn, $this->unidad_id->DBFormat) = array("unidad_id", "descripcion", "");
            $this->unidad_id->DataSource->Parameters["expr24"] = 1;
            $this->unidad_id->DataSource->wp = new clsSQLParameters();
            $this->unidad_id->DataSource->wp->AddParameter("1", "expr24", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["expr24"], "", false);
            $this->unidad_id->DataSource->wp->Criterion[1] = $this->unidad_id->DataSource->wp->Operation(opEqual, "unidades.estado_id", $this->unidad_id->DataSource->wp->GetDBValue("1"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->unidad_id->DataSource->Where = 
                 $this->unidad_id->DataSource->wp->Criterion[1];
            $this->unidad_id->DataSource->Order = "entorno_desc desc, unidades.unidad_nombre";
            $this->unidad_id->HTML = true;
            $this->Button1 = new clsButton("Button1", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @12-26C5A563
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urls_tipo_tramites_id"] = CCGetFromGet("s_tipo_tramites_id", NULL);
    }
//End Initialize Method

//Validate Method @12-5BD2E131
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->unidad_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->unidad_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @12-C0B5A423
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_tramites_descript->Errors->Count());
        $errors = ($errors || $this->unidad_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @12-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @12-2A800D96
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button1";
            if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//Show Method @12-F29E5A20
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->unidad_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                $this->tipo_tramites_descript->SetValue($this->DataSource->tipo_tramites_descript->GetValue());
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_tramites_descript->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidad_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->tipo_tramites_descript->Show();
        $this->unidad_id->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tipos_tramites Class @12-FCB6E20C

class clstipos_tramitesDataSource extends clsDBmesa {  //tipos_tramitesDataSource Class @12-5AE9E904

//DataSource Variables @12-086D0D67
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $tipo_tramites_descript;
    public $unidad_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @12-9DCEEABB
    function clstipos_tramitesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tipos_tramites/Error";
        $this->Initialize();
        $this->tipo_tramites_descript = new clsField("tipo_tramites_descript", ccsText, "");
        
        $this->unidad_id = new clsField("unidad_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @12-9CC2B754
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_tramites_id", ccsInteger, "", "", $this->Parameters["urls_tipo_tramites_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tipo_tramites_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @12-38017D44
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_tramites {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @12-22A3DC09
    function SetValues()
    {
        $this->tipo_tramites_descript->SetDBValue($this->f("tipo_tramites_descript"));
    }
//End SetValues Method

} //End tipos_tramitesDataSource Class @12-FCB6E20C

//Initialize Page @1-208A764F
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "recordTiposUnidades.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-1F4A81C1
include_once("./recordTiposUnidades_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-990CA87F
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tramites = new clsRecordtramites("", $MainPage);
$tipos_tramites = new clsRecordtipos_tramites("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tramites = & $tramites;
$MainPage->tipos_tramites = & $tipos_tramites;
$tipos_tramites->Initialize();

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-52F9C312
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-39359315
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$tramites->Operation();
$tipos_tramites->Operation();
//End Execute Components

//Go to destination page @1-B382FFA0
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($tramites);
    unset($tipos_tramites);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-64BECB02
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$tramites->Show();
$tipos_tramites->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;er&#97;&#116;ed <!-- CCS -->&#119;ith <!-- SCC -->&#67;ode&#67;&#104;arge <!-- SCC -->&#83;tudio.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;er&#97;&#116;ed <!-- CCS -->&#119;ith <!-- SCC -->&#67;ode&#67;&#104;arge <!-- SCC -->&#83;tudio.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>G&#101;&#110;er&#97;&#116;ed <!-- CCS -->&#119;ith <!-- SCC -->&#67;ode&#67;&#104;arge <!-- SCC -->&#83;tudio.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-82063400
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($tramites);
unset($tipos_tramites);
unset($Tpl);
//End Unload Page


?>
