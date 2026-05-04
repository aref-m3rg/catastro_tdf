<?php
//Include Common Files @1-54374A9E
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_newTomo.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridpiezas_piezas_tipos_trami { //piezas_piezas_tipos_trami class @2-739B4FF9

//Variables @2-6E51DF5A

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
//End Variables

//Class_Initialize Event @2-352E9380
    function clsGridpiezas_piezas_tipos_trami($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "piezas_piezas_tipos_trami";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspiezas_piezas_tipos_tramiDataSource($this);
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

        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
        $this->pieza_tipo_desc = new clsControl(ccsLabel, "pieza_tipo_desc", "pieza_tipo_desc", ccsText, "", CCGetRequestParam("pieza_tipo_desc", ccsGet, NULL), $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
        $this->tramite_desc = new clsControl(ccsLabel, "tramite_desc", "tramite_desc", ccsText, "", CCGetRequestParam("tramite_desc", ccsGet, NULL), $this);
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
        $this->tomos = new clsControl(ccsLabel, "tomos", "tomos", ccsInteger, "", CCGetRequestParam("tomos", ccsGet, NULL), $this);
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

//Show Method @2-EA0BA4A8
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
        $this->DataSource->Parameters["expr25"] = 1;

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
            $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
            $this->ControlsVisible["pieza_tipo_desc"] = $this->pieza_tipo_desc->Visible;
            $this->ControlsVisible["pieza"] = $this->pieza->Visible;
            $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
            $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
            $this->ControlsVisible["tomos"] = $this->tomos->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                $this->pieza_tipo_desc->SetValue($this->DataSource->pieza_tipo_desc->GetValue());
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
                $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_descripcion->Show();
                $this->pieza_tipo_desc->Show();
                $this->pieza->Show();
                $this->tramite_desc->Show();
                $this->pieza_f_alta->Show();
                $this->tomos->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-84259931
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tomos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End piezas_piezas_tipos_trami Class @2-FCB6E20C

class clspiezas_piezas_tipos_tramiDataSource extends clsDBmesa {  //piezas_piezas_tipos_tramiDataSource Class @2-70A9BED9

//DataSource Variables @2-038BF009
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $pieza_descripcion;
    public $pieza_tipo_desc;
    public $pieza;
    public $tramite_desc;
    public $pieza_f_alta;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-5D9E2973
    function clspiezas_piezas_tipos_tramiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Initialize();
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->pieza_tipo_desc = new clsField("pieza_tipo_desc", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-8C9398B6
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->AddParameter("2", "expr25", ccsInteger, "", "", $this->Parameters["expr25"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-461E91F8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id";
        $this->SQL = "SELECT pieza_tipo_desc, tramite_desc, unidad_p_nombre, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_id, pieza_iniciador,\n\n" .
        "pieza_descripcion, pieza_f_alta, piezas_tipos.pieza_tipo_id AS tipo, pieza_observaciones, piezas.unidad_id AS unidad_id,\n\n" .
        "entorno_desc, pieza_nro, pieza_letra, pieza_anio \n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-AD5C8802
    function SetValues()
    {
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_tipo_desc->SetDBValue($this->f("pieza_tipo_desc"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
    }
//End SetValues Method

} //End piezas_piezas_tipos_tramiDataSource Class @2-FCB6E20C

class clsRecordNewRecord1 { //NewRecord1 Class @47-D7EDAFB1

//Variables @47-9E315808

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

//Class_Initialize Event @47-D733F812
    function clsRecordNewRecord1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record NewRecord1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "NewRecord1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ctomos = new clsControl(ccsTextBox, "ctomos", "Tomos a crear", ccsInteger, "", CCGetRequestParam("ctomos", $Method, NULL), $this);
            $this->ctomos->Required = true;
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @47-2648879F
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->ctomos->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->ctomos->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @47-CF4B60F9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ctomos->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @47-ED598703
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

//Operation Method @47-57B93F98
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
            $this->PressedButton = "Button1";
            if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = $FileName;
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button1", "Button1_x", "Button1_y", "Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @47-DD4A215D
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
            $Error = ComposeStrings($Error, $this->ctomos->Errors->ToString());
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

        $this->ctomos->Show();
        $this->Button1->Show();
        $this->Button_DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End NewRecord1 Class @47-FCB6E20C

//Initialize Page @1-44867534
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
$TemplateFileName = "msa_newTomo.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-A09270EF
include_once("./msa_newTomo_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-1EE59E5B
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$piezas_piezas_tipos_trami = new clsGridpiezas_piezas_tipos_trami("", $MainPage);
$NewRecord1 = new clsRecordNewRecord1("", $MainPage);
$MainPage->piezas_piezas_tipos_trami = & $piezas_piezas_tipos_trami;
$MainPage->NewRecord1 = & $NewRecord1;
$piezas_piezas_tipos_trami->Initialize();

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

//Execute Components @1-A09052E6
$NewRecord1->Operation();
//End Execute Components

//Go to destination page @1-B867F605
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($piezas_piezas_tipos_trami);
    unset($NewRecord1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-CC75B706
$piezas_piezas_tipos_trami->Show();
$NewRecord1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$INOS1B5S9O9B = array("<center><font face=","\"Arial\"><small>G&","#101;nerat&#101;","&#100; <!-- CCS -->&#","119;&#105;th <!-- S","CC -->&#67;o&#100",";&#101;&#67;h&#97;&#1","14;&#103;&#101; <!--"," SCC -->&#83;&#116;u&","#100;i&#111;.</small>","</font></center>","");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($INOS1B5S9O9B,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($INOS1B5S9O9B,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($INOS1B5S9O9B,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-09A8E8A4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($piezas_piezas_tipos_trami);
unset($NewRecord1);
unset($Tpl);
//End Unload Page


?>
