<?php
//Include Common Files @1-94ADA480
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_dtr_agregar.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordtipos_documentacion_tasas { //tipos_documentacion_tasas Class @2-3DA19D62

//Variables @2-9E315808

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

//Class_Initialize Event @2-507D9F7A
    function clsRecordtipos_documentacion_tasas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_documentacion_tasas/Error";
        $this->DataSource = new clstipos_documentacion_tasasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_documentacion_tasas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->tipo_doc_t_r_descrip = new clsControl(ccsTextBox, "tipo_doc_t_r_descrip", "Tipo Doc T R Descrip", ccsText, "", CCGetRequestParam("tipo_doc_t_r_descrip", $Method, NULL), $this);
            $this->ListBox1 = new clsControl(ccsListBox, "ListBox1", "ListBox1", ccsText, "", CCGetRequestParam("ListBox1", $Method, NULL), $this);
            $this->ListBox1->DSType = dsTable;
            $this->ListBox1->DataSource = new clsDBcatastro();
            $this->ListBox1->ds = & $this->ListBox1->DataSource;
            $this->ListBox1->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->ListBox1->BoundColumn, $this->ListBox1->TextColumn, $this->ListBox1->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->Link1->Page = "pa_dtr_grilla.php";
            $this->Button_Cancelar = new clsButton("Button_Cancelar", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-BFF24BB7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urltipo_doc_t_r_id"] = CCGetFromGet("tipo_doc_t_r_id", NULL);
    }
//End Initialize Method

//Validate Method @2-0F416AE3
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_doc_t_r_descrip->Validate() && $Validation);
        $Validation = ($this->ListBox1->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_doc_t_r_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox1->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-70A37801
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_doc_t_r_descrip->Errors->Count());
        $errors = ($errors || $this->ListBox1->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
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

//Operation Method @2-F84720B5
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
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Cancelar->Pressed) {
                $this->PressedButton = "Button_Cancelar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Cancelar") {
                if(!CCGetEvent($this->Button_Cancelar->CCSEvents, "OnClick", $this->Button_Cancelar)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @2-781F19C6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_doc_t_r_descrip->SetValue($this->tipo_doc_t_r_descrip->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//Show Method @2-0D799EA1
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

        $this->ListBox1->Prepare();

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
                if(!$this->FormSubmitted){
                    $this->tipo_doc_t_r_descrip->SetValue($this->DataSource->tipo_doc_t_r_descrip->GetValue());
                    $this->ListBox1->SetValue($this->DataSource->ListBox1->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_doc_t_r_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
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
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->tipo_doc_t_r_descrip->Show();
        $this->ListBox1->Show();
        $this->Link1->Show();
        $this->Button_Cancelar->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tipos_documentacion_tasas Class @2-FCB6E20C

class clstipos_documentacion_tasasDataSource extends clsDBcatastro {  //tipos_documentacion_tasasDataSource Class @2-6854E55C

//DataSource Variables @2-9FEB73D0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();

    // Datasource fields
    public $tipo_doc_t_r_descrip;
    public $ListBox1;
    public $Link1;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-5A633346
    function clstipos_documentacion_tasasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tipos_documentacion_tasas/Error";
        $this->Initialize();
        $this->tipo_doc_t_r_descrip = new clsField("tipo_doc_t_r_descrip", ccsText, "");
        
        $this->ListBox1 = new clsField("ListBox1", ccsText, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        

        $this->InsertFields["tipo_doc_t_r_descrip"] = array("Name" => "tipo_doc_t_r_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-6320BD5D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltipo_doc_t_r_id", ccsInteger, "", "", $this->Parameters["urltipo_doc_t_r_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tipo_doc_t_r_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-CD42BC97
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_documentacion_tasas_retributivas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-87786B4D
    function SetValues()
    {
        $this->tipo_doc_t_r_descrip->SetDBValue($this->f("tipo_doc_t_r_descrip"));
        $this->ListBox1->SetDBValue($this->f("tipo_estado_id"));
    }
//End SetValues Method

//Insert Method @2-19E4CDDD
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_doc_t_r_descrip"]["Value"] = $this->tipo_doc_t_r_descrip->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->ListBox1->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_documentacion_tasas_retributivas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

} //End tipos_documentacion_tasasDataSource Class @2-FCB6E20C

//Include Page implementation @9-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @10-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @11-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-F852A6F6
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
$TemplateFileName = "pa_dtr_agregar.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-7E8062C5
include_once("./pa_dtr_agregar_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C2C5168A
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tipos_documentacion_tasas = new clsRecordtipos_documentacion_tasas("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->tipos_documentacion_tasas = & $tipos_documentacion_tasas;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$tipos_documentacion_tasas->Initialize();

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

//Execute Components @1-349E6A9D
$tipos_documentacion_tasas->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-68EEC9B8
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($tipos_documentacion_tasas);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-9E5BDA47
$tipos_documentacion_tasas->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>Gen&#101;ra&" . "#116;e&#100; <!-- CCS -->&#119;&#105;t&#104;" . " <!-- SCC -->&#67;&#111;&#100;eCha&#114;&#103;e " . "<!-- CCS -->St&#117;&#100;i&#111;.</small><" . "/font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>Gen&#101;ra&" . "#116;e&#100; <!-- CCS -->&#119;&#105;t&#104;" . " <!-- SCC -->&#67;&#111;&#100;eCha&#114;&#103;e " . "<!-- CCS -->St&#117;&#100;i&#111;.</small><" . "/font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>Gen&#101;ra&" . "#116;e&#100; <!-- CCS -->&#119;&#105;t&#104;" . " <!-- SCC -->&#67;&#111;&#100;eCha&#114;&#103;e " . "<!-- CCS -->St&#117;&#100;i&#111;.</small><" . "/font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0CB03E08
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcatastro->close();
unset($tipos_documentacion_tasas);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
