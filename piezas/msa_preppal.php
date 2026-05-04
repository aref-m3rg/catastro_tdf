<?php
//Include Common Files @1-0D893BF1
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_preppal.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @21-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @22-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @23-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordpre { //pre Class @2-22CC23EF

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

//Class_Initialize Event @2-2EBB59A5
    function clsRecordpre($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record pre/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "pre";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->unidad_id = new clsControl(ccsListBox, "unidad_id", "Seleccione el area", ccsInteger, "", CCGetRequestParam("unidad_id", $Method, NULL), $this);
            $this->unidad_id->DSType = dsTable;
            $this->unidad_id->DataSource = new clsDBmesa();
            $this->unidad_id->ds = & $this->unidad_id->DataSource;
            $this->unidad_id->DataSource->SQL = "SELECT unidades.unidad_id AS unidad_id, unidad_p_nombre \n" .
"FROM (unidades INNER JOIN usuarios_unidades ON\n" .
"usuarios_unidades.unidad_id = unidades.unidad_id) INNER JOIN unidades_param ON\n" .
"unidades_param.unidad_id = unidades.unidad_id {SQL_Where}\n" .
"GROUP BY unidades.unidad_id {SQL_OrderBy}";
            $this->unidad_id->DataSource->Order = "unidad_p_nombre";
            list($this->unidad_id->BoundColumn, $this->unidad_id->TextColumn, $this->unidad_id->DBFormat) = array("unidad_id", "unidad_p_nombre", "");
            $this->unidad_id->DataSource->Parameters["expr12"] = 1;
            $this->unidad_id->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);
            $this->unidad_id->DataSource->Parameters["expr14"] = 1;
            $this->unidad_id->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
            $this->unidad_id->DataSource->wp = new clsSQLParameters();
            $this->unidad_id->DataSource->wp->AddParameter("1", "expr12", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["expr12"], "", false);
            $this->unidad_id->DataSource->wp->AddParameter("2", "sesUID", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["sesUID"], "", false);
            $this->unidad_id->DataSource->wp->AddParameter("3", "expr14", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["expr14"], "", false);
            $this->unidad_id->DataSource->wp->AddParameter("4", "sesunidad_id", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["sesunidad_id"], "", false);
            $this->unidad_id->DataSource->wp->Criterion[1] = $this->unidad_id->DataSource->wp->Operation(opEqual, "unidades.estado_id", $this->unidad_id->DataSource->wp->GetDBValue("1"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->unidad_id->DataSource->wp->Criterion[2] = $this->unidad_id->DataSource->wp->Operation(opEqual, "usuarios_unidades.usuario_id", $this->unidad_id->DataSource->wp->GetDBValue("2"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("2"), ccsInteger),false);
            $this->unidad_id->DataSource->wp->Criterion[3] = $this->unidad_id->DataSource->wp->Operation(opEqual, "usuarios_unidades.estado_id", $this->unidad_id->DataSource->wp->GetDBValue("3"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("3"), ccsInteger),false);
            $this->unidad_id->DataSource->wp->Criterion[4] = $this->unidad_id->DataSource->wp->Operation(opNotEqual, "unidades.unidad_id", $this->unidad_id->DataSource->wp->GetDBValue("4"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("4"), ccsInteger),false);
            $this->unidad_id->DataSource->Where = $this->unidad_id->DataSource->wp->opAND(
                 false, $this->unidad_id->DataSource->wp->opAND(
                 false, $this->unidad_id->DataSource->wp->opAND(
                 false, 
                 $this->unidad_id->DataSource->wp->Criterion[1], 
                 $this->unidad_id->DataSource->wp->Criterion[2]), 
                 $this->unidad_id->DataSource->wp->Criterion[3]), 
                 $this->unidad_id->DataSource->wp->Criterion[4]);
            $this->unidad_id->DataSource->Order = "unidad_p_nombre";
            $this->unidad_id->Required = true;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->area_activa = new clsControl(ccsLabel, "area_activa", "area_activa", ccsText, "", CCGetRequestParam("area_activa", $Method, NULL), $this);
            if(!is_array($this->area_activa->Value) && !strlen($this->area_activa->Value) && $this->area_activa->Value !== false)
                $this->area_activa->SetText(CCGetSession('unidad_nombre'));
        }
    }
//End Class_Initialize Event

//Validate Method @2-5BD2E131
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

//CheckErrors Method @2-631D92D3
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->unidad_id->Errors->Count());
        $errors = ($errors || $this->area_activa->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
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

//Operation Method @2-8B8B9393
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "msa_principal.php";
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "msa_principal.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y", "unidad_id")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @2-11179370
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
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->unidad_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->area_activa->Errors->ToString());
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

        $this->unidad_id->Show();
        $this->Button_DoSearch->Show();
        $this->Button1->Show();
        $this->area_activa->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End pre Class @2-FCB6E20C

//Initialize Page @1-EA0279E4
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
$TemplateFileName = "msa_preppal.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-6FAF22D1
include_once("./msa_preppal_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7694FC8F
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$pre = new clsRecordpre("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->pre = & $pre;

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

//Execute Components @1-EA2EE150
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$pre->Operation();
//End Execute Components

//Go to destination page @1-E226AC8F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($pre);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1C87D2F6
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$pre->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small" . ">G&#101;n&#101;ra&#116;&#101;d <!-- " . "SCC -->&#119;&#105;th <!-- SCC -->&#6" . "7;&#111;d&#101;Cha&#114;g&#101; <!-" . "- CCS -->&#83;&#116;&#117;&#100;&#1" . "05;o.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small" . ">G&#101;n&#101;ra&#116;&#101;d <!-- " . "SCC -->&#119;&#105;th <!-- SCC -->&#6" . "7;&#111;d&#101;Cha&#114;g&#101; <!-" . "- CCS -->&#83;&#116;&#117;&#100;&#1" . "05;o.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small" . ">G&#101;n&#101;ra&#116;&#101;d <!-- " . "SCC -->&#119;&#105;th <!-- SCC -->&#6" . "7;&#111;d&#101;Cha&#114;g&#101; <!-" . "- CCS -->&#83;&#116;&#117;&#100;&#1" . "05;o.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9E5A4CAC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($pre);
unset($Tpl);
//End Unload Page


?>
