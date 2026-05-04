<?php
//Include Common Files @1-A2699D51
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "restricciones.php");
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

//Include Page implementation @6-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

class clsRecordrestricciones { //restricciones Class @7-370C04DA

//Variables @7-9E315808

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

//Class_Initialize Event @7-37EBC8E7
    function clsRecordrestricciones($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record restricciones/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "restricciones";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->restriccion = new clsControl(ccsCheckBoxList, "restriccion", "restriccion", ccsText, "", CCGetRequestParam("restriccion", $Method, NULL), $this);
            $this->restriccion->Multiple = true;
            $this->restriccion->DSType = dsTable;
            $this->restriccion->DataSource = new clsDBtdf_nuevo();
            $this->restriccion->ds = & $this->restriccion->DataSource;
            $this->restriccion->DataSource->SQL = "SELECT * \n" .
"FROM tipos_restricc_parcela {SQL_Where} {SQL_OrderBy}";
            $this->restriccion->DataSource->Order = "tipo_restricc_parcela_desc";
            list($this->restriccion->BoundColumn, $this->restriccion->TextColumn, $this->restriccion->DBFormat) = array("tipo_restricc_parcela_id", "tipo_restricc_parcela_desc", "");
            $this->restriccion->DataSource->Order = "tipo_restricc_parcela_desc";
            $this->restriccion->HTML = true;
        }
    }
//End Class_Initialize Event

//Validate Method @7-07962788
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->restriccion->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->restriccion->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @7-BEE9431A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->restriccion->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @7-ED598703
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

//Operation Method @7-45344225
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
            $this->PressedButton = "Button_Update";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Update") {
            if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            $Redirect = "recordParcela.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @7-CDFA26CA
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

        $this->restriccion->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->restriccion->Errors->ToString());
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

        $this->Button_Update->Show();
        $this->Button1->Show();
        $this->restriccion->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End restricciones Class @7-FCB6E20C

//Initialize Page @1-19114FFC
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
$TemplateFileName = "restricciones.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-AD7011FE
include_once("./restricciones_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-32F0431D
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$restricciones = new clsRecordrestricciones("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->footerParcela = & $footerParcela;
$MainPage->restricciones = & $restricciones;

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

//Execute Components @1-36AA3A24
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$footerParcela->Operations();
$restricciones->Operation();
//End Execute Components

//Go to destination page @1-76347DA9
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
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    unset($restricciones);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-183DCEC1
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$footerParcela->Show();
$restricciones->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$LADQDED1Q9C6N5C10E = ">retnec/<>tnof/<>llams/<.oi;001#&u;611#&;38#&>-- SCC --!< ;101#&;301#&;411#&;79#&;401#&Ce;001#&o;76#&>-- SCC --!< ;401#&;611#&;501#&w>-- SCC --!< d;101#&t;79#&r;101#&;011#&eG>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($LADQDED1Q9C6N5C10E) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($LADQDED1Q9C6N5C10E) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($LADQDED1Q9C6N5C10E);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8CB537F3
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$footerParcela->Class_Terminate();
unset($footerParcela);
unset($restricciones);
unset($Tpl);
//End Unload Page


?>
