<?php
//Include Common Files @1-FB207B43
define("RelativePath", "..");
define("PathToCurrentPage", "/panel/");
define("FileName", "pn_recordNoticias.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @37-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @38-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @39-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordnoticias { //noticias Class @2-FF4191B6

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

//Class_Initialize Event @2-91164711
    function clsRecordnoticias($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record noticias/Error";
        $this->DataSource = new clsnoticiasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "noticias";
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
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->noti_cat_id = new clsControl(ccsListBox, "noti_cat_id", "Noti Cat Id", ccsInteger, "", CCGetRequestParam("noti_cat_id", $Method, NULL), $this);
            $this->noti_cat_id->DSType = dsTable;
            $this->noti_cat_id->DataSource = new clsDBtdf_nuevo();
            $this->noti_cat_id->ds = & $this->noti_cat_id->DataSource;
            $this->noti_cat_id->DataSource->SQL = "SELECT * \n" .
"FROM noticias_categoria {SQL_Where} {SQL_OrderBy}";
            list($this->noti_cat_id->BoundColumn, $this->noti_cat_id->TextColumn, $this->noti_cat_id->DBFormat) = array("noti_cat_id", "noti_cat_descr", "");
            $this->noti_cat_id->Required = true;
            $this->noticias_asunto = new clsControl(ccsTextBox, "noticias_asunto", "Asunto", ccsText, "", CCGetRequestParam("noticias_asunto", $Method, NULL), $this);
            $this->noticias_asunto->Required = true;
            $this->noticias_texto = new clsControl(ccsTextArea, "noticias_texto", "noticias_texto", ccsText, "", CCGetRequestParam("noticias_texto", $Method, NULL), $this);
            $this->noticias_texto->Required = true;
            $this->user_id = new clsControl(ccsHidden, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method, NULL), $this);
            $this->noticias_fecha = new clsControl(ccsHidden, "noticias_fecha", "noticias_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn", ":", "ss"), CCGetRequestParam("noticias_fecha", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->user_id->Value) && !strlen($this->user_id->Value) && $this->user_id->Value !== false)
                    $this->user_id->SetText(CCGetUserID());
                if(!is_array($this->noticias_fecha->Value) && !strlen($this->noticias_fecha->Value) && $this->noticias_fecha->Value !== false)
                    $this->noticias_fecha->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-E66E93E8
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlnoticias_id"] = CCGetFromGet("noticias_id", NULL);
    }
//End Initialize Method

//Validate Method @2-26F631F5
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->noti_cat_id->Validate() && $Validation);
        $Validation = ($this->noticias_asunto->Validate() && $Validation);
        $Validation = ($this->noticias_texto->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $Validation = ($this->noticias_fecha->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->noti_cat_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->noticias_asunto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->noticias_texto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->noticias_fecha->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-260319A5
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->noti_cat_id->Errors->Count());
        $errors = ($errors || $this->noticias_asunto->Errors->Count());
        $errors = ($errors || $this->noticias_texto->Errors->Count());
        $errors = ($errors || $this->user_id->Errors->Count());
        $errors = ($errors || $this->noticias_fecha->Errors->Count());
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

//Operation Method @2-F8DB60B1
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "pn_inicio.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "noticia_id"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
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

//InsertRow Method @2-9DC3EBF6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->noti_cat_id->SetValue($this->noti_cat_id->GetValue(true));
        $this->DataSource->noticias_asunto->SetValue($this->noticias_asunto->GetValue(true));
        $this->DataSource->noticias_texto->SetValue($this->noticias_texto->GetValue(true));
        $this->DataSource->user_id->SetValue($this->user_id->GetValue(true));
        $this->DataSource->noticias_fecha->SetValue($this->noticias_fecha->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-6A5971D7
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->noti_cat_id->SetValue($this->noti_cat_id->GetValue(true));
        $this->DataSource->noticias_asunto->SetValue($this->noticias_asunto->GetValue(true));
        $this->DataSource->noticias_texto->SetValue($this->noticias_texto->GetValue(true));
        $this->DataSource->user_id->SetValue($this->user_id->GetValue(true));
        $this->DataSource->noticias_fecha->SetValue($this->noticias_fecha->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-890180A5
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

        $this->noti_cat_id->Prepare();

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
                    $this->noti_cat_id->SetValue($this->DataSource->noti_cat_id->GetValue());
                    $this->noticias_asunto->SetValue($this->DataSource->noticias_asunto->GetValue());
                    $this->noticias_texto->SetValue($this->DataSource->noticias_texto->GetValue());
                    $this->user_id->SetValue($this->DataSource->user_id->GetValue());
                    $this->noticias_fecha->SetValue($this->DataSource->noticias_fecha->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->noti_cat_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->noticias_asunto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->noticias_texto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->noticias_fecha->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->noti_cat_id->Show();
        $this->noticias_asunto->Show();
        $this->noticias_texto->Show();
        $this->user_id->Show();
        $this->noticias_fecha->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End noticias Class @2-FCB6E20C

class clsnoticiasDataSource extends clsDBtdf_nuevo {  //noticiasDataSource Class @2-77710873

//DataSource Variables @2-05132B30
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $noti_cat_id;
    public $noticias_asunto;
    public $noticias_texto;
    public $user_id;
    public $noticias_fecha;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-D0CC8593
    function clsnoticiasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record noticias/Error";
        $this->Initialize();
        $this->noti_cat_id = new clsField("noti_cat_id", ccsInteger, "");
        
        $this->noticias_asunto = new clsField("noticias_asunto", ccsText, "");
        
        $this->noticias_texto = new clsField("noticias_texto", ccsText, "");
        
        $this->user_id = new clsField("user_id", ccsInteger, "");
        
        $this->noticias_fecha = new clsField("noticias_fecha", ccsDate, $this->DateFormat);
        

        $this->InsertFields["noti_cat_id"] = array("Name" => "noti_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["noticias_asunto"] = array("Name" => "noticias_asunto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["noticias_texto"] = array("Name" => "noticias_texto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["noticias_fecha"] = array("Name" => "noticias_fecha", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["noti_cat_id"] = array("Name" => "noti_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["noticias_asunto"] = array("Name" => "noticias_asunto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["noticias_texto"] = array("Name" => "noticias_texto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["noticias_fecha"] = array("Name" => "noticias_fecha", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-4A0BD3D4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlnoticias_id", ccsInteger, "", "", $this->Parameters["urlnoticias_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "noticias_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-0170A859
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM noticias {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-DD4DDBBF
    function SetValues()
    {
        $this->noti_cat_id->SetDBValue(trim($this->f("noti_cat_id")));
        $this->noticias_asunto->SetDBValue($this->f("noticias_asunto"));
        $this->noticias_texto->SetDBValue($this->f("noticias_texto"));
        $this->user_id->SetDBValue(trim($this->f("usuario_id")));
        $this->noticias_fecha->SetDBValue(trim($this->f("noticias_fecha")));
    }
//End SetValues Method

//Insert Method @2-118B25EE
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["noti_cat_id"]["Value"] = $this->noti_cat_id->GetDBValue(true);
        $this->InsertFields["noticias_asunto"]["Value"] = $this->noticias_asunto->GetDBValue(true);
        $this->InsertFields["noticias_texto"]["Value"] = $this->noticias_texto->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->user_id->GetDBValue(true);
        $this->InsertFields["noticias_fecha"]["Value"] = $this->noticias_fecha->GetDBValue(true);
        $this->SQL = CCBuildInsert("noticias", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-BDC1C0EC
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["noti_cat_id"]["Value"] = $this->noti_cat_id->GetDBValue(true);
        $this->UpdateFields["noticias_asunto"]["Value"] = $this->noticias_asunto->GetDBValue(true);
        $this->UpdateFields["noticias_texto"]["Value"] = $this->noticias_texto->GetDBValue(true);
        $this->UpdateFields["usuario_id"]["Value"] = $this->user_id->GetDBValue(true);
        $this->UpdateFields["noticias_fecha"]["Value"] = $this->noticias_fecha->GetDBValue(true);
        $this->SQL = CCBuildUpdate("noticias", $this->UpdateFields, $this);
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

} //End noticiasDataSource Class @2-FCB6E20C

//Initialize Page @1-577C6D9D
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
$TemplateFileName = "pn_recordNoticias.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
//End Initialize Page

//Authenticate User @1-CBFD1E0E
CCSecurityRedirect("1;2", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-7D758545
include_once("./pn_recordNoticias_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-91820432
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_folder = new clstdf_footer("../", "tdf_folder", $MainPage);
$tdf_folder->Initialize();
$noticias = new clsRecordnoticias("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_folder = & $tdf_folder;
$MainPage->noticias = & $noticias;
$noticias->Initialize();

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

//Execute Components @1-80A3A9D9
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_folder->Operations();
$noticias->Operation();
//End Execute Components

//Go to destination page @1-6A610544
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_folder->Class_Terminate();
    unset($tdf_folder);
    unset($noticias);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-CD48E151
$tdf_header->Show();
$tdf_menu->Show();
$tdf_folder->Show();
$noticias->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$TLDL3A10C2H5D5P = "<center><font face=\"Arial\"><small>Gen&#101;ra&#116;&#101;&#100; <!-- SCC -->w&#105;th <!-- CCS -->Cod&#101;&#67;ha&#114;ge <!-- CCS -->S&#116;&#117;d&#105;o.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $TLDL3A10C2H5D5P . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $TLDL3A10C2H5D5P . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $TLDL3A10C2H5D5P;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C3936764
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_folder->Class_Terminate();
unset($tdf_folder);
unset($noticias);
unset($Tpl);
//End Unload Page


?>
