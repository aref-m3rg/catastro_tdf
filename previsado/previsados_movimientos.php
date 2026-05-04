<?php
//Include Common Files @1-CDC6867D
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_movimientos.php");
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

class clsRecordprevisados_movimientosSearch { //previsados_movimientosSearch Class @7-DEF8CC7C

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

//Class_Initialize Event @7-269E34F7
    function clsRecordprevisados_movimientosSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_movimientosSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_movimientosSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_previsado_carga_id = new clsControl(ccsTextBox, "s_previsado_carga_id", "s_previsado_carga_id", ccsInteger, "", CCGetRequestParam("s_previsado_carga_id", $Method, NULL), $this);
            $this->s_previsado_movimiento_fecha = new clsControl(ccsTextBox, "s_previsado_movimiento_fecha", "s_previsado_movimiento_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("s_previsado_movimiento_fecha", $Method, NULL), $this);
            $this->DatePicker_s_previsado_movimiento_fecha = new clsDatePicker("DatePicker_s_previsado_movimiento_fecha", "previsados_movimientosSearch", "s_previsado_movimiento_fecha", $this);
            $this->Button_cancel = new clsButton("Button_cancel", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @7-4AC87EFB
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_previsado_carga_id->Validate() && $Validation);
        $Validation = ($this->s_previsado_movimiento_fecha->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_previsado_carga_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_movimiento_fecha->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @7-56BF1789
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_previsado_carga_id->Errors->Count());
        $errors = ($errors || $this->s_previsado_movimiento_fecha->Errors->Count());
        $errors = ($errors || $this->DatePicker_s_previsado_movimiento_fecha->Errors->Count());
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

//Operation Method @7-BC071AD9
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
            } else if($this->Button_cancel->Pressed) {
                $this->PressedButton = "Button_cancel";
            }
        }
        $Redirect = "previsados_movimientos.php";
        if($this->PressedButton == "Button_cancel") {
            if(!CCGetEvent($this->Button_cancel->CCSEvents, "OnClick", $this->Button_cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "previsados_movimientos.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_cancel", "Button_cancel_x", "Button_cancel_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @7-ED07DBC8
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
            $Error = ComposeStrings($Error, $this->s_previsado_carga_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_movimiento_fecha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_s_previsado_movimiento_fecha->Errors->ToString());
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
        $this->s_previsado_carga_id->Show();
        $this->s_previsado_movimiento_fecha->Show();
        $this->DatePicker_s_previsado_movimiento_fecha->Show();
        $this->Button_cancel->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End previsados_movimientosSearch Class @7-FCB6E20C

class clsGridprevisados_movimientos { //previsados_movimientos class @6-CFDB67E9

//Variables @6-199D238B

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
    public $Sorter_previsado_movimiento_fecha;
    public $Sorter_previsado_carga_id;
    public $Sorter_usuario_id;
    public $Sorter_previsado_movimiento_observacion;
//End Variables

//Class_Initialize Event @6-E03392E8
    function clsGridprevisados_movimientos($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_movimientos";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_movimientos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_movimientosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("previsados_movimientosOrder", "");
        $this->SorterDirection = CCGetParam("previsados_movimientosDir", "");

        $this->previsado_movimiento_fecha = new clsControl(ccsLabel, "previsado_movimiento_fecha", "previsado_movimiento_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn"), CCGetRequestParam("previsado_movimiento_fecha", ccsGet, NULL), $this);
        $this->previsado_carga_id = new clsControl(ccsLabel, "previsado_carga_id", "previsado_carga_id", ccsInteger, "", CCGetRequestParam("previsado_carga_id", ccsGet, NULL), $this);
        $this->usuario_id = new clsControl(ccsLabel, "usuario_id", "usuario_id", ccsInteger, "", CCGetRequestParam("usuario_id", ccsGet, NULL), $this);
        $this->previsado_movimiento_observacion = new clsControl(ccsLabel, "previsado_movimiento_observacion", "previsado_movimiento_observacion", ccsText, "", CCGetRequestParam("previsado_movimiento_observacion", ccsGet, NULL), $this);
        $this->tipo_usuario = new clsControl(ccsLabel, "tipo_usuario", "tipo_usuario", ccsText, "", CCGetRequestParam("tipo_usuario", ccsGet, NULL), $this);
        $this->Sorter_previsado_movimiento_fecha = new clsSorter($this->ComponentName, "Sorter_previsado_movimiento_fecha", $FileName, $this);
        $this->Sorter_previsado_carga_id = new clsSorter($this->ComponentName, "Sorter_previsado_carga_id", $FileName, $this);
        $this->Sorter_usuario_id = new clsSorter($this->ComponentName, "Sorter_usuario_id", $FileName, $this);
        $this->Sorter_previsado_movimiento_observacion = new clsSorter($this->ComponentName, "Sorter_previsado_movimiento_observacion", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Parameters = CCGetQueryString("QueryString", array("origen", "s_previsado_carga_id", "ccsForm"));
        $this->Link1->Page = "previsados_busqueda.php";
    }
//End Class_Initialize Event

//Initialize Method @6-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @6-DDCE8656
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_previsado_carga_id"] = CCGetFromGet("s_previsado_carga_id", NULL);
        $this->DataSource->Parameters["urls_previsado_movimiento_fecha"] = CCGetFromGet("s_previsado_movimiento_fecha", NULL);

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
            $this->ControlsVisible["previsado_movimiento_fecha"] = $this->previsado_movimiento_fecha->Visible;
            $this->ControlsVisible["previsado_carga_id"] = $this->previsado_carga_id->Visible;
            $this->ControlsVisible["usuario_id"] = $this->usuario_id->Visible;
            $this->ControlsVisible["previsado_movimiento_observacion"] = $this->previsado_movimiento_observacion->Visible;
            $this->ControlsVisible["tipo_usuario"] = $this->tipo_usuario->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_movimiento_fecha->SetValue($this->DataSource->previsado_movimiento_fecha->GetValue());
                $this->previsado_carga_id->SetValue($this->DataSource->previsado_carga_id->GetValue());
                $this->usuario_id->SetValue($this->DataSource->usuario_id->GetValue());
                $this->previsado_movimiento_observacion->SetValue($this->DataSource->previsado_movimiento_observacion->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_movimiento_fecha->Show();
                $this->previsado_carga_id->Show();
                $this->usuario_id->Show();
                $this->previsado_movimiento_observacion->Show();
                $this->tipo_usuario->Show();
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
        $this->Sorter_previsado_movimiento_fecha->Show();
        $this->Sorter_previsado_carga_id->Show();
        $this->Sorter_usuario_id->Show();
        $this->Sorter_previsado_movimiento_observacion->Show();
        $this->Navigator->Show();
        $this->Link1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-78808B6C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_movimiento_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_carga_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_movimiento_observacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_usuario->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_movimientos Class @6-FCB6E20C

class clsprevisados_movimientosDataSource extends clsDBtdf_nuevo {  //previsados_movimientosDataSource Class @6-6D22AD45

//DataSource Variables @6-89CF1279
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_movimiento_fecha;
    public $previsado_carga_id;
    public $usuario_id;
    public $previsado_movimiento_observacion;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-316D24DF
    function clsprevisados_movimientosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_movimientos";
        $this->Initialize();
        $this->previsado_movimiento_fecha = new clsField("previsado_movimiento_fecha", ccsDate, $this->DateFormat);
        
        $this->previsado_carga_id = new clsField("previsado_carga_id", ccsInteger, "");
        
        $this->usuario_id = new clsField("usuario_id", ccsInteger, "");
        
        $this->previsado_movimiento_observacion = new clsField("previsado_movimiento_observacion", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-9F7BC9FC
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "previsado_movimiento_fecha desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_previsado_movimiento_fecha" => array("previsado_movimiento_fecha", ""), 
            "Sorter_previsado_carga_id" => array("previsado_carga_id", ""), 
            "Sorter_usuario_id" => array("usuario_id", ""), 
            "Sorter_previsado_movimiento_observacion" => array("previsado_movimiento_observacion", "")));
    }
//End SetOrder Method

//Prepare Method @6-0F2981BB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_previsado_carga_id", ccsInteger, "", "", $this->Parameters["urls_previsado_carga_id"], "", false);
        $this->wp->AddParameter("2", "urls_previsado_movimiento_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd"), $this->Parameters["urls_previsado_movimiento_fecha"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsado_carga_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "previsado_movimiento_fecha", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsDate),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @6-2519DF0A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM previsados_movimientos";
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_movimientos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-78674387
    function SetValues()
    {
        $this->previsado_movimiento_fecha->SetDBValue(trim($this->f("previsado_movimiento_fecha")));
        $this->previsado_carga_id->SetDBValue(trim($this->f("previsado_carga_id")));
        $this->usuario_id->SetDBValue(trim($this->f("usuario_id")));
        $this->previsado_movimiento_observacion->SetDBValue($this->f("previsado_movimiento_observacion"));
    }
//End SetValues Method

} //End previsados_movimientosDataSource Class @6-FCB6E20C



//Initialize Page @1-FFE97AE6
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
$TemplateFileName = "previsados_movimientos.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-D509831D
include_once("./previsados_movimientos_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C61E3C22
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
$previsados_movimientosSearch = new clsRecordprevisados_movimientosSearch("", $MainPage);
$previsados_movimientos = new clsGridprevisados_movimientos("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->previsados_movimientosSearch = & $previsados_movimientosSearch;
$MainPage->previsados_movimientos = & $previsados_movimientos;
$previsados_movimientos->Initialize();

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

//Execute Components @1-A66CEF46
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$previsados_movimientosSearch->Operation();
//End Execute Components

//Go to destination page @1-6537AB00
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
    unset($previsados_movimientosSearch);
    unset($previsados_movimientos);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7741C026
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$previsados_movimientosSearch->Show();
$previsados_movimientos->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><fon" . "t face=\"Arial\">" . "<small>&#71;" . "ene&#114;&#97;te" . "d <!-- CCS -->wi" . "t&#104; <!--" . " SCC -->&#67;" . "odeCh&#97;&#" . "114;&#103;e <" . "!-- CCS -->S&#1" . "16;udi&#111;." . "</small></font>" . "</center>" . "" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><fon" . "t face=\"Arial\">" . "<small>&#71;" . "ene&#114;&#97;te" . "d <!-- CCS -->wi" . "t&#104; <!--" . " SCC -->&#67;" . "odeCh&#97;&#" . "114;&#103;e <" . "!-- CCS -->S&#1" . "16;udi&#111;." . "</small></font>" . "</center>" . "" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><fon" . "t face=\"Arial\">" . "<small>&#71;" . "ene&#114;&#97;te" . "d <!-- CCS -->wi" . "t&#104; <!--" . " SCC -->&#67;" . "odeCh&#97;&#" . "114;&#103;e <" . "!-- CCS -->S&#1" . "16;udi&#111;." . "</small></font>" . "</center>" . "";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-1FC9735F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($previsados_movimientosSearch);
unset($previsados_movimientos);
unset($Tpl);
//End Unload Page


?>
