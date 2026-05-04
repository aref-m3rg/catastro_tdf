<?php
//Include Common Files @1-2BECEA02
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "gridUnidades.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @29-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @30-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @31-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordentornos_unidades_unidade { //entornos_unidades_unidade Class @15-EC24B445

//Variables @15-9E315808

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

//Class_Initialize Event @15-2E519044
    function clsRecordentornos_unidades_unidade($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record entornos_unidades_unidade/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "entornos_unidades_unidade";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_unidad_p_nombre = new clsControl(ccsTextBox, "s_unidad_p_nombre", "s_unidad_p_nombre", ccsText, "", CCGetRequestParam("s_unidad_p_nombre", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @15-CECD6C33
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_unidad_p_nombre->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_unidad_p_nombre->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @15-3FCB93D9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_unidad_p_nombre->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @15-ED598703
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

//Operation Method @15-AF1217CF
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
            }
        }
        $Redirect = "gridUnidades.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "gridUnidades.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @15-8D0592E1
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
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_unidad_p_nombre->Errors->ToString());
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
        $this->s_unidad_p_nombre->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End entornos_unidades_unidade Class @15-FCB6E20C

class clsGridentornos_unidades_unidade1 { //entornos_unidades_unidade1 class @2-94F8C9F9

//Variables @2-BB556BBF

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
    public $Sorter_entorno_desc;
    public $Sorter_unidad_p_nombre;
    public $Sorter_unidad_p_responsable;
//End Variables

//Class_Initialize Event @2-1EAB90CF
    function clsGridentornos_unidades_unidade1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "entornos_unidades_unidade1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid entornos_unidades_unidade1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsentornos_unidades_unidade1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("entornos_unidades_unidade1Order", "");
        $this->SorterDirection = CCGetParam("entornos_unidades_unidade1Dir", "");

        $this->entorno_desc = new clsControl(ccsLabel, "entorno_desc", "entorno_desc", ccsText, "", CCGetRequestParam("entorno_desc", ccsGet, NULL), $this);
        $this->unidad_nombre = new clsControl(ccsLabel, "unidad_nombre", "unidad_nombre", ccsText, "", CCGetRequestParam("unidad_nombre", ccsGet, NULL), $this);
        $this->unidad_p_responsable = new clsControl(ccsLabel, "unidad_p_responsable", "unidad_p_responsable", ccsText, "", CCGetRequestParam("unidad_p_responsable", ccsGet, NULL), $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "recordUnidades.php";
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Page = "gridAreasUsrs.php";
        $this->entornos_unidades_unidade1_TotalRecords = new clsControl(ccsLabel, "entornos_unidades_unidade1_TotalRecords", "entornos_unidades_unidade1_TotalRecords", ccsText, "", CCGetRequestParam("entornos_unidades_unidade1_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_entorno_desc = new clsSorter($this->ComponentName, "Sorter_entorno_desc", $FileName, $this);
        $this->Sorter_unidad_p_nombre = new clsSorter($this->ComponentName, "Sorter_unidad_p_nombre", $FileName, $this);
        $this->Sorter_unidad_p_responsable = new clsSorter($this->ComponentName, "Sorter_unidad_p_responsable", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->ImageLink3 = new clsControl(ccsImageLink, "ImageLink3", "ImageLink3", ccsText, "", CCGetRequestParam("ImageLink3", ccsGet, NULL), $this);
        $this->ImageLink3->Parameters = CCGetQueryString("QueryString", array("unidad_id", "ccsForm"));
        $this->ImageLink3->Page = "recordUnidades.php";
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-979AF424
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["expr14"] = 1;
        $this->DataSource->Parameters["urls_unidad_p_nombre"] = CCGetFromGet("s_unidad_p_nombre", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["entorno_desc"] = $this->entorno_desc->Visible;
            $this->ControlsVisible["unidad_nombre"] = $this->unidad_nombre->Visible;
            $this->ControlsVisible["unidad_p_responsable"] = $this->unidad_p_responsable->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->entorno_desc->SetValue($this->DataSource->entorno_desc->GetValue());
                $this->unidad_nombre->SetValue($this->DataSource->unidad_nombre->GetValue());
                $this->unidad_p_responsable->SetValue($this->DataSource->unidad_p_responsable->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "unidad_id", $this->DataSource->f("unidad_id"));
                $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "unidad_id", $this->DataSource->f("unidad_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->entorno_desc->Show();
                $this->unidad_nombre->Show();
                $this->unidad_p_responsable->Show();
                $this->ImageLink1->Show();
                $this->ImageLink2->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->entornos_unidades_unidade1_TotalRecords->Show();
        $this->Sorter_entorno_desc->Show();
        $this->Sorter_unidad_p_nombre->Show();
        $this->Sorter_unidad_p_responsable->Show();
        $this->Navigator->Show();
        $this->ImageLink3->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-6CAFACE8
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->entorno_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_responsable->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End entornos_unidades_unidade1 Class @2-FCB6E20C

class clsentornos_unidades_unidade1DataSource extends clsDBunidades {  //entornos_unidades_unidade1DataSource Class @2-DE8A6239

//DataSource Variables @2-16EA92AD
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $entorno_desc;
    public $unidad_nombre;
    public $unidad_p_responsable;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-6ACDA94D
    function clsentornos_unidades_unidade1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid entornos_unidades_unidade1";
        $this->Initialize();
        $this->entorno_desc = new clsField("entorno_desc", ccsText, "");
        
        $this->unidad_nombre = new clsField("unidad_nombre", ccsText, "");
        
        $this->unidad_p_responsable = new clsField("unidad_p_responsable", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-81C71512
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_entorno_desc" => array("entorno_desc", ""), 
            "Sorter_unidad_p_nombre" => array("unidad_nombre", ""), 
            "Sorter_unidad_p_responsable" => array("unidad_p_responsable", "")));
    }
//End SetOrder Method

//Prepare Method @2-C74C0555
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr14", ccsInteger, "", "", $this->Parameters["expr14"], "", false);
        $this->wp->AddParameter("3", "urls_unidad_p_nombre", ccsText, "", "", $this->Parameters["urls_unidad_p_nombre"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = "( unidad_p_id IS NULL )";
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "unidades_param.unidad_p_nombre", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opOR(
             true, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @2-790B8ED8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (unidades INNER JOIN entornos ON\n\n" .
        "unidades.entorno_id = entornos.entorno_id) LEFT JOIN unidades_param ON\n\n" .
        "unidades.unidad_id = unidades_param.unidad_id";
        $this->SQL = "SELECT entorno_desc, unidades.unidad_id AS unidad_id, unidad_p_nombre, unidad_p_responsable, unidad_nombre, entornos.entorno_id AS entorno_id \n\n" .
        "FROM (unidades INNER JOIN entornos ON\n\n" .
        "unidades.entorno_id = entornos.entorno_id) LEFT JOIN unidades_param ON\n\n" .
        "unidades.unidad_id = unidades_param.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-5989F270
    function SetValues()
    {
        $this->entorno_desc->SetDBValue($this->f("entorno_desc"));
        $this->unidad_nombre->SetDBValue($this->f("unidad_nombre"));
        $this->unidad_p_responsable->SetDBValue($this->f("unidad_p_responsable"));
    }
//End SetValues Method

} //End entornos_unidades_unidade1DataSource Class @2-FCB6E20C

//Initialize Page @1-D224B89E
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
$TemplateFileName = "gridUnidades.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-08727F5D
include_once("./gridUnidades_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D5CB1191
$DBunidades = new clsDBunidades();
$MainPage->Connections["unidades"] = & $DBunidades;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$entornos_unidades_unidade = new clsRecordentornos_unidades_unidade("", $MainPage);
$entornos_unidades_unidade1 = new clsGridentornos_unidades_unidade1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->entornos_unidades_unidade = & $entornos_unidades_unidade;
$MainPage->entornos_unidades_unidade1 = & $entornos_unidades_unidade1;
$entornos_unidades_unidade1->Initialize();

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

//Execute Components @1-0293F8EF
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$entornos_unidades_unidade->Operation();
//End Execute Components

//Go to destination page @1-E759926F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBunidades->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($entornos_unidades_unidade);
    unset($entornos_unidades_unidade1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BA1A7543
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$entornos_unidades_unidade->Show();
$entornos_unidades_unidade1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.oidutS>-- SCC --!< ;101#&;301#&rah;76#&edoC>-- SCC --!< h;611#&i;911#&>-- SCC --!< ;001#&;101#&tar;101#&;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.oidutS>-- SCC --!< ;101#&;301#&rah;76#&edoC>-- SCC --!< h;611#&i;911#&>-- SCC --!< ;001#&;101#&tar;101#&;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.oidutS>-- SCC --!< ;101#&;301#&rah;76#&edoC>-- SCC --!< h;611#&i;911#&>-- SCC --!< ;001#&;101#&tar;101#&;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-3625388B
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBunidades->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($entornos_unidades_unidade);
unset($entornos_unidades_unidade1);
unset($Tpl);
//End Unload Page


?>
