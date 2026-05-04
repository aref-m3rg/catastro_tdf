<?php
//Include Common Files @1-177A251A
define("RelativePath", "..");
define("PathToCurrentPage", "/permisos/");
define("FileName", "adm_recordPerfil.php");
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

class clsRecordperfiles { //perfiles Class @8-E262D33D

//Variables @8-9E315808

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

//Class_Initialize Event @8-76806518
    function clsRecordperfiles($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record perfiles/Error";
        $this->DataSource = new clsperfilesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "perfiles";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->perfil_nombre = new clsControl(ccsTextBox, "perfil_nombre", "Nombre", ccsText, "", CCGetRequestParam("perfil_nombre", $Method, NULL), $this);
            $this->perfil_nombre->Required = true;
            $this->perfil_abrev = new clsControl(ccsTextBox, "perfil_abrev", "Abreviatura", ccsText, "", CCGetRequestParam("perfil_abrev", $Method, NULL), $this);
            $this->perfil_abrev->Required = true;
            $this->perfil_descr = new clsControl(ccsTextBox, "perfil_descr", "Descripción", ccsText, "", CCGetRequestParam("perfil_descr", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "Estado", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->tipo_estado_id->DSType = dsTable;
            $this->tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
            $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->tipo_estado_id->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @8-DA166178
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlperfil_id"] = CCGetFromGet("perfil_id", NULL);
    }
//End Initialize Method

//Validate Method @8-A11CDCF6
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->perfil_nombre->Validate() && $Validation);
        $Validation = ($this->perfil_abrev->Validate() && $Validation);
        $Validation = ($this->perfil_descr->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->perfil_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->perfil_abrev->Errors->Count() == 0);
        $Validation =  $Validation && ($this->perfil_descr->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @8-5DFD4DD0
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->perfil_nombre->Errors->Count());
        $errors = ($errors || $this->perfil_abrev->Errors->Count());
        $errors = ($errors || $this->perfil_descr->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @8-ED598703
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

//Operation Method @8-708DB9FB
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "adm_recordPerfil.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "../usuarios/adm_perfil.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "perfil_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
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

//InsertRow Method @8-7E862659
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->perfil_nombre->SetValue($this->perfil_nombre->GetValue(true));
        $this->DataSource->perfil_abrev->SetValue($this->perfil_abrev->GetValue(true));
        $this->DataSource->perfil_descr->SetValue($this->perfil_descr->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @8-549830F4
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->perfil_nombre->SetValue($this->perfil_nombre->GetValue(true));
        $this->DataSource->perfil_abrev->SetValue($this->perfil_abrev->GetValue(true));
        $this->DataSource->perfil_descr->SetValue($this->perfil_descr->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @8-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @8-D5722A47
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

        $this->tipo_estado_id->Prepare();

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
                    $this->perfil_nombre->SetValue($this->DataSource->perfil_nombre->GetValue());
                    $this->perfil_abrev->SetValue($this->DataSource->perfil_abrev->GetValue());
                    $this->perfil_descr->SetValue($this->DataSource->perfil_descr->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->perfil_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->perfil_abrev->Errors->ToString());
            $Error = ComposeStrings($Error, $this->perfil_descr->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
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
        $this->Button_Cancel->Show();
        $this->perfil_nombre->Show();
        $this->perfil_abrev->Show();
        $this->perfil_descr->Show();
        $this->tipo_estado_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End perfiles Class @8-FCB6E20C

class clsperfilesDataSource extends clsDBtdf_nuevo {  //perfilesDataSource Class @8-0F2C7123

//DataSource Variables @8-1E7493A3
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $perfil_nombre;
    public $perfil_abrev;
    public $perfil_descr;
    public $tipo_estado_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @8-52A03C55
    function clsperfilesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record perfiles/Error";
        $this->Initialize();
        $this->perfil_nombre = new clsField("perfil_nombre", ccsText, "");
        
        $this->perfil_abrev = new clsField("perfil_abrev", ccsText, "");
        
        $this->perfil_descr = new clsField("perfil_descr", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        

        $this->InsertFields["perfil_nombre"] = array("Name" => "perfil_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["perfil_abrev"] = array("Name" => "perfil_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["perfil_descr"] = array("Name" => "perfil_descr", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["perfil_nombre"] = array("Name" => "perfil_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["perfil_abrev"] = array("Name" => "perfil_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["perfil_descr"] = array("Name" => "perfil_descr", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @8-ABECF074
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlperfil_id", ccsInteger, "", "", $this->Parameters["urlperfil_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "perfil_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @8-0C4BF2A0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM _perfiles {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @8-78FC612A
    function SetValues()
    {
        $this->perfil_nombre->SetDBValue($this->f("perfil_nombre"));
        $this->perfil_abrev->SetDBValue($this->f("perfil_abrev"));
        $this->perfil_descr->SetDBValue($this->f("perfil_descr"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Insert Method @8-007BC11A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["perfil_nombre"]["Value"] = $this->perfil_nombre->GetDBValue(true);
        $this->InsertFields["perfil_abrev"]["Value"] = $this->perfil_abrev->GetDBValue(true);
        $this->InsertFields["perfil_descr"]["Value"] = $this->perfil_descr->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("_perfiles", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @8-6DC18FA4
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["perfil_nombre"]["Value"] = $this->perfil_nombre->GetDBValue(true);
        $this->UpdateFields["perfil_abrev"]["Value"] = $this->perfil_abrev->GetDBValue(true);
        $this->UpdateFields["perfil_descr"]["Value"] = $this->perfil_descr->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("_perfiles", $this->UpdateFields, $this);
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

//Delete Method @8-D0EA96A9
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM _perfiles";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End perfilesDataSource Class @8-FCB6E20C

//Initialize Page @1-24664A5B
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
$TemplateFileName = "adm_recordPerfil.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-B9AF5D34
include_once("./adm_recordPerfil_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-FB01B45F
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$permissions_html = new clsControl(ccsLabel, "permissions_html", "permissions_html", ccsText, "", CCGetRequestParam("permissions_html", ccsGet, NULL), $MainPage);
$permissions_html->HTML = true;
$perfiles = new clsRecordperfiles("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->permissions_html = & $permissions_html;
$MainPage->perfiles = & $perfiles;
$perfiles->Initialize();

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

//Execute Components @1-82EFD306
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$perfiles->Operation();
//End Execute Components

//Go to destination page @1-2B6A86C9
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($perfiles);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-A4F18E2E
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$perfiles->Show();
$permissions_html->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"><small>&", "#71;&#101;n&#101;ra&#116;ed <!-- CC", "S -->&#119;i&#116;&#104; <!-- SCC -->C&", "#111;de&#67;&#104;&#97;&#114;&#103;&#10", "1; <!-- SCC -->&#83;&#116;u&#100;io.", "</small></font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"><small>&", "#71;&#101;n&#101;ra&#116;ed <!-- CC", "S -->&#119;i&#116;&#104; <!-- SCC -->C&", "#111;de&#67;&#104;&#97;&#114;&#103;&#10", "1; <!-- SCC -->&#83;&#116;u&#100;io.", "</small></font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\"><small>&", "#71;&#101;n&#101;ra&#116;ed <!-- CC", "S -->&#119;i&#116;&#104; <!-- SCC -->C&", "#111;de&#67;&#104;&#97;&#114;&#103;&#10", "1; <!-- SCC -->&#83;&#116;u&#100;io.", "</small></font></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E4AA564F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($perfiles);
unset($Tpl);
//End Unload Page


?>
