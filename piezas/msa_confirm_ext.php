<?php
//Include Common Files @1-2B9A8B6C
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_confirm_ext.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordconfirmacion_ext { //confirmacion_ext Class @4-CCD601A5

//Variables @4-9E315808

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

//Class_Initialize Event @4-23DE8010
    function clsRecordconfirmacion_ext($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record confirmacion_ext/Error";
        $this->DataSource = new clsconfirmacion_extDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "confirmacion_ext";
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
            $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", $Method, NULL), $this);
            $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", CCGetRequestParam("unidad_p_nombre", $Method, NULL), $this);
            $this->pase_f_pase = new clsControl(ccsLabel, "pase_f_pase", "pase_f_pase", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("pase_f_pase", $Method, NULL), $this);
            $this->close_window = new clsControl(ccsHidden, "close_window", "close_window", ccsText, "", CCGetRequestParam("close_window", $Method, NULL), $this);
            $this->pase_receptor = new clsControl(ccsTextBox, "pase_receptor", "Nombre", ccsText, "", CCGetRequestParam("pase_receptor", $Method, NULL), $this);
            $this->pase_receptor->Required = true;
            $this->Button1 = new clsButton("Button1", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->pase_receptor->Value) && !strlen($this->pase_receptor->Value) && $this->pase_receptor->Value !== false)
                    $this->pase_receptor->SetText(CCGetUserLogin());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @4-93737303
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
        $this->DataSource->Parameters["expr18"] = 1;
        $this->DataSource->Parameters["expr19"] = 1;
    }
//End Initialize Method

//Validate Method @4-6F574B74
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->close_window->Validate() && $Validation);
        $Validation = ($this->pase_receptor->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->close_window->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pase_receptor->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @4-2D113D03
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->pieza->Errors->Count());
        $errors = ($errors || $this->unidad_p_nombre->Errors->Count());
        $errors = ($errors || $this->pase_f_pase->Errors->Count());
        $errors = ($errors || $this->close_window->Errors->Count());
        $errors = ($errors || $this->pase_receptor->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @4-ED598703
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

//Operation Method @4-67E0B47A
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button1";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button1") {
                if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
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

//UpdateRow Method @4-95CA8853
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->pase_receptor->SetValue($this->pase_receptor->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @4-6ED9A5C5
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
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->pieza->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidad_p_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pase_f_pase->Errors->ToString());
            $Error = ComposeStrings($Error, $this->close_window->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pase_receptor->Errors->ToString());
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
        $this->pieza->Show();
        $this->unidad_p_nombre->Show();
        $this->pase_f_pase->Show();
        $this->close_window->Show();
        $this->pase_receptor->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End confirmacion_ext Class @4-FCB6E20C

class clsconfirmacion_extDataSource extends clsDBmesa {  //confirmacion_extDataSource Class @4-1CBDBDC1

//DataSource Variables @4-2753F3FC
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $pieza;
    public $unidad_p_nombre;
    public $pase_f_pase;
    public $close_window;
    public $pase_receptor;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-EC0F340B
    function clsconfirmacion_extDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record confirmacion_ext/Error";
        $this->Initialize();
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->pase_f_pase = new clsField("pase_f_pase", ccsDate, $this->DateFormat);
        
        $this->close_window = new clsField("close_window", ccsText, "");
        
        $this->pase_receptor = new clsField("pase_receptor", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @4-0AED3771
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->AddParameter("2", "expr18", ccsInteger, "", "", $this->Parameters["expr18"], "", false);
        $this->wp->AddParameter("3", "expr19", ccsInteger, "", "", $this->Parameters["expr19"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @4-237F7757
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, unidades_param.unidad_p_nombre AS unidades_param_unidad_p_nombre,\n\n" .
        "pase_comentario, pieza_tipo_abrev, pase_f_pase, unidades_param1.unidad_p_nombre AS unidades_param1_unidad_p_nombre \n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN unidades_param ON\n\n" .
        "pases.ori_unidad_id = unidades_param.unidad_id) INNER JOIN unidades_param unidades_param1 ON\n\n" .
        "pases.des_unidad_id = unidades_param1.unidad_p_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-E865F474
    function SetValues()
    {
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidades_param1_unidad_p_nombre"));
        $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
    }
//End SetValues Method

//Update Method @4-3D857EDB
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["pieza_id"] = new clsSQLParameter("urlpieza_id", ccsInteger, "", "", CCGetFromGet("pieza_id", NULL), 0, false, $this->ErrorBlock);
        $this->cp["pase_receptor"] = new clsSQLParameter("ctrlpase_receptor", ccsText, "", "", $this->pase_receptor->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["UID"] = new clsSQLParameter("sesUID", ccsInteger, "", "", CCGetSession("UID", NULL), 0, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["pieza_id"]->GetValue()) and !strlen($this->cp["pieza_id"]->GetText()) and !is_bool($this->cp["pieza_id"]->GetValue())) 
            $this->cp["pieza_id"]->SetText(CCGetFromGet("pieza_id", NULL));
        if (!strlen($this->cp["pieza_id"]->GetText()) and !is_bool($this->cp["pieza_id"]->GetValue(true))) 
            $this->cp["pieza_id"]->SetText(0);
        if (!is_null($this->cp["pase_receptor"]->GetValue()) and !strlen($this->cp["pase_receptor"]->GetText()) and !is_bool($this->cp["pase_receptor"]->GetValue())) 
            $this->cp["pase_receptor"]->SetValue($this->pase_receptor->GetValue(true));
        if (!is_null($this->cp["UID"]->GetValue()) and !strlen($this->cp["UID"]->GetText()) and !is_bool($this->cp["UID"]->GetValue())) 
            $this->cp["UID"]->SetValue(CCGetSession("UID", NULL));
        if (!strlen($this->cp["UID"]->GetText()) and !is_bool($this->cp["UID"]->GetValue(true))) 
            $this->cp["UID"]->SetText(0);
        $this->SQL = "select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End confirmacion_extDataSource Class @4-FCB6E20C

//Initialize Page @1-74EA910E
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
$TemplateFileName = "msa_confirm_ext.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-B8FFB654
include_once("./msa_confirm_ext_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-9423B4ED
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$confirmacion_ext = new clsRecordconfirmacion_ext("", $MainPage);
$MainPage->confirmacion_ext = & $confirmacion_ext;
$confirmacion_ext->Initialize();

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

//Execute Components @1-906FAE02
$confirmacion_ext->Operation();
//End Execute Components

//Go to destination page @1-F27AADDB
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($confirmacion_ext);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-CCF06E2E
$confirmacion_ext->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"><sma", "ll>&#71;e&#110;e&#114;&#97;&", "#116;&#101;d <!-- SCC -->wit", "&#104; <!-- SCC -->&#67;od&#", "101;C&#104;&#97;&#114;&#103", ";e <!-- CCS -->&#83;t&#117;&", "#100;&#105;o.</small></font", "></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"><sma", "ll>&#71;e&#110;e&#114;&#97;&", "#116;&#101;d <!-- SCC -->wit", "&#104; <!-- SCC -->&#67;od&#", "101;C&#104;&#97;&#114;&#103", ";e <!-- CCS -->&#83;t&#117;&", "#100;&#105;o.</small></font", "></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\"><sma", "ll>&#71;e&#110;e&#114;&#97;&", "#116;&#101;d <!-- SCC -->wit", "&#104; <!-- SCC -->&#67;od&#", "101;C&#104;&#97;&#114;&#103", ";e <!-- CCS -->&#83;t&#117;&", "#100;&#105;o.</small></font", "></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0C7EC266
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($confirmacion_ext);
unset($Tpl);
//End Unload Page


?>
