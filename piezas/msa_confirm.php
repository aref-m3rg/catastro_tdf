<?php
//Include Common Files @1-BAB6627D
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_confirm.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordconfirmacion { //confirmacion Class @4-8F4F42A5

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

//Class_Initialize Event @4-C4E3982A
    function clsRecordconfirmacion($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record confirmacion/Error";
        $this->DataSource = new clsconfirmacionDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "confirmacion";
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
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->close_window = new clsControl(ccsHidden, "close_window", "close_window", ccsText, "", CCGetRequestParam("close_window", $Method, NULL), $this);
            $this->pase_receptor = new clsControl(ccsTextBox, "pase_receptor", "Nombre", ccsText, "", CCGetRequestParam("pase_receptor", $Method, NULL), $this);
            $this->pase_receptor->Required = true;
            if(!$this->FormSubmitted) {
                if(!is_array($this->pase_receptor->Value) && !strlen($this->pase_receptor->Value) && $this->pase_receptor->Value !== false)
                    $this->pase_receptor->SetText(CCGetUserLogin());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @4-C01145F1
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
        $this->DataSource->Parameters["expr21"] = 1;
        $this->DataSource->Parameters["expr23"] = 1;
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

//Operation Method @4-CB166461
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
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
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

//Show Method @4-22566DCD
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
        $this->Button1->Show();
        $this->close_window->Show();
        $this->pase_receptor->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End confirmacion Class @4-FCB6E20C

class clsconfirmacionDataSource extends clsDBmesa {  //confirmacionDataSource Class @4-B2E90314

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

//DataSourceClass_Initialize Event @4-4DD6A26C
    function clsconfirmacionDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record confirmacion/Error";
        $this->Initialize();
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->pase_f_pase = new clsField("pase_f_pase", ccsDate, $this->DateFormat);
        
        $this->close_window = new clsField("close_window", ccsText, "");
        
        $this->pase_receptor = new clsField("pase_receptor", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @4-8F385726
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->AddParameter("2", "expr21", ccsInteger, "", "", $this->Parameters["expr21"], "", false);
        $this->wp->AddParameter("3", "expr23", ccsInteger, "", "", $this->Parameters["expr23"], "", false);
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

//Open Method @4-843EF6ED
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, unidad_p_nombre, pase_comentario, pieza_tipo_abrev, pase_f_pase \n\n" .
        "FROM ((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN unidades_param ON\n\n" .
        "pases.ori_unidad_id = unidades_param.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-06A9258E
    function SetValues()
    {
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
    }
//End SetValues Method

//Update Method @4-8C7BDB89
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["pieza_id"] = new clsSQLParameter("urlpieza_id", ccsInteger, "", "", CCGetFromGet("pieza_id", NULL), 0, false, $this->ErrorBlock);
        $this->cp["pase_receptor"] = new clsSQLParameter("ctrlpase_receptor", ccsText, "", "", $this->pase_receptor->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["UserID"] = new clsSQLParameter("sesUserID", ccsInteger, "", "", CCGetSession("UserID", NULL), 0, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["pieza_id"]->GetValue()) and !strlen($this->cp["pieza_id"]->GetText()) and !is_bool($this->cp["pieza_id"]->GetValue())) 
            $this->cp["pieza_id"]->SetText(CCGetFromGet("pieza_id", NULL));
        if (!strlen($this->cp["pieza_id"]->GetText()) and !is_bool($this->cp["pieza_id"]->GetValue(true))) 
            $this->cp["pieza_id"]->SetText(0);
        if (!is_null($this->cp["pase_receptor"]->GetValue()) and !strlen($this->cp["pase_receptor"]->GetText()) and !is_bool($this->cp["pase_receptor"]->GetValue())) 
            $this->cp["pase_receptor"]->SetValue($this->pase_receptor->GetValue(true));
        if (!is_null($this->cp["UserID"]->GetValue()) and !strlen($this->cp["UserID"]->GetText()) and !is_bool($this->cp["UserID"]->GetValue())) 
            $this->cp["UserID"]->SetValue(CCGetSession("UserID", NULL));
        if (!strlen($this->cp["UserID"]->GetText()) and !is_bool($this->cp["UserID"]->GetValue(true))) 
            $this->cp["UserID"]->SetText(0);
        $this->SQL = "select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End confirmacionDataSource Class @4-FCB6E20C

//Initialize Page @1-7DEE9785
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
$TemplateFileName = "msa_confirm.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-831928C3
include_once("./msa_confirm_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-DB8E06C7
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$confirmacion = new clsRecordconfirmacion("", $MainPage);
$MainPage->confirmacion = & $confirmacion;
$confirmacion->Initialize();

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

//Execute Components @1-3F274B20
$confirmacion->Operation();
//End Execute Components

//Go to destination page @1-BA80A02C
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($confirmacion);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-87BA8C8A
$confirmacion->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;r&#97;ted <!-- SCC -->&#119;it&#104; <!-- CCS -->&#67;od&#101;&#67;ha&#114;&#103;&#101; <!-- SCC -->&#83;&#116;&#117;&#100;&#105;o.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;r&#97;ted <!-- SCC -->&#119;it&#104; <!-- CCS -->&#67;od&#101;&#67;ha&#114;&#103;&#101; <!-- SCC -->&#83;&#116;&#117;&#100;&#105;o.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>G&#101;&#110;&#101;r&#97;ted <!-- SCC -->&#119;it&#104; <!-- CCS -->&#67;od&#101;&#67;ha&#114;&#103;&#101; <!-- SCC -->&#83;&#116;&#117;&#100;&#105;o.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-FFB80713
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($confirmacion);
unset($Tpl);
//End Unload Page


?>
