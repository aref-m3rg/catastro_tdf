<?php
//Include Common Files @1-76BEFA86
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "mejoraBaja.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordmejoras { //mejoras Class @2-4D6BE1C1

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

//Class_Initialize Event @2-48E4956B
    function clsRecordmejoras($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mejoras/Error";
        $this->DataSource = new clsmejorasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "mejoras";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->mejora_mot_baja = new clsControl(ccsTextArea, "mejora_mot_baja", "Motivo de la Baja", ccsText, "", CCGetRequestParam("mejora_mot_baja", $Method, NULL), $this);
            $this->mejora_mot_baja->Required = true;
            $this->ButtonCancelar = new clsButton("ButtonCancelar", $Method, $this);
            $this->tipo_estado_id = new clsControl(ccsHidden, "tipo_estado_id", "tipo_estado_id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->close_window = new clsControl(ccsHidden, "close_window", "close_window", ccsText, "", CCGetRequestParam("close_window", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_estado_id->Value) && !strlen($this->tipo_estado_id->Value) && $this->tipo_estado_id->Value !== false)
                    $this->tipo_estado_id->SetText(2);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-80BBA4A8
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmejora_id"] = CCGetFromGet("mejora_id", NULL);
    }
//End Initialize Method

//Validate Method @2-34F3DE84
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->mejora_mot_baja->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $Validation = ($this->close_window->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->mejora_mot_baja->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->close_window->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-11A37C91
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->mejora_mot_baja->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->close_window->Errors->Count());
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

//Operation Method @2-22833F54
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "ButtonCancelar";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->ButtonCancelar->Pressed) {
                $this->PressedButton = "ButtonCancelar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "ButtonCancelar") {
            if(!CCGetEvent($this->ButtonCancelar->CCSEvents, "OnClick", $this->ButtonCancelar)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
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

//UpdateRow Method @2-7B900EB2
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->mejora_mot_baja->SetValue($this->mejora_mot_baja->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->close_window->SetValue($this->close_window->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-00B03287
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
                    $this->mejora_mot_baja->SetValue($this->DataSource->mejora_mot_baja->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->mejora_mot_baja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->close_window->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->mejora_mot_baja->Show();
        $this->ButtonCancelar->Show();
        $this->tipo_estado_id->Show();
        $this->close_window->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mejoras Class @2-FCB6E20C

class clsmejorasDataSource extends clsDBtdf_nuevo {  //mejorasDataSource Class @2-A728D50A

//DataSource Variables @2-C24F8CAF
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $mejora_mot_baja;
    public $tipo_estado_id;
    public $close_window;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-20BBCE18
    function clsmejorasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mejoras/Error";
        $this->Initialize();
        $this->mejora_mot_baja = new clsField("mejora_mot_baja", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->close_window = new clsField("close_window", ccsText, "");
        

        $this->UpdateFields["mejora_mot_baja"] = array("Name" => "mejora_mot_baja", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-379ADC70
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmejora_id", ccsInteger, "", "", $this->Parameters["urlmejora_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejora_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-1E8F64B3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM mejoras {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-05E1720F
    function SetValues()
    {
        $this->mejora_mot_baja->SetDBValue($this->f("mejora_mot_baja"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Update Method @2-15ECF566
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["mejora_mot_baja"]["Value"] = $this->mejora_mot_baja->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("mejoras", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End mejorasDataSource Class @2-FCB6E20C

//Initialize Page @1-A7AEDC24
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
$TemplateFileName = "mejoraBaja.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-4747FA41
include_once("./mejoraBaja_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-52B40036
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$mejoras = new clsRecordmejoras("", $MainPage);
$MainPage->mejoras = & $mejoras;
$mejoras->Initialize();

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

//Execute Components @1-7E96D5E1
$mejoras->Operation();
//End Execute Components

//Go to destination page @1-7FD83357
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($mejoras);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-C769C315
$mejoras->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$RNRCJCDQ4H4C6M = explode("|", "<center><font f|ace=\"Arial\"><sma|ll>G&#101;&#110;er&#|97;t&#101;&#100; |<!-- CCS -->w&#10|5;&#116;h <!-- |CCS -->C&#111;d&|#101;&#67;&#104;a&#1|14;ge <!-- CCS -->&|#83;tu&#100;&#105;&#|111;.</small></|font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($RNRCJCDQ4H4C6M,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($RNRCJCDQ4H4C6M,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($RNRCJCDQ4H4C6M,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-60AF4D1D
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($mejoras);
unset($Tpl);
//End Unload Page


?>
