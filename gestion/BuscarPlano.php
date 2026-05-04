<?php
//Include Common Files @1-D20D0A6F
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "BuscarPlano.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridplanos_profesionales_tipo1 { //planos_profesionales_tipo1 class @6-E750669B

//Variables @6-C5F78F53

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
    public $Sorter_plano_nro;
    public $Sorter_plano_e_nro;
    public $Sorter_plano_e_letra;
    public $Sorter_plano_e_anio;
    public $Sorter_plano_anio;
    public $Sorter_plano_archivo;
    public $Sorter_prof_nombre;
    public $Sorter_tipo_estado_plano_desc;
    public $Sorter_tipo_plano_desc;
//End Variables

//Class_Initialize Event @6-80CBA495
    function clsGridplanos_profesionales_tipo1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "planos_profesionales_tipo1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid planos_profesionales_tipo1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsplanos_profesionales_tipo1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 5;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("planos_profesionales_tipo1Order", "");
        $this->SorterDirection = CCGetParam("planos_profesionales_tipo1Dir", "");

        $this->plano_nro = new clsControl(ccsLink, "plano_nro", "plano_nro", ccsInteger, "", CCGetRequestParam("plano_nro", ccsGet, NULL), $this);
        $this->plano_nro->Page = "BuscarPlano.php";
        $this->plano_e_nro = new clsControl(ccsLabel, "plano_e_nro", "plano_e_nro", ccsInteger, "", CCGetRequestParam("plano_e_nro", ccsGet, NULL), $this);
        $this->plano_e_letra = new clsControl(ccsLabel, "plano_e_letra", "plano_e_letra", ccsText, "", CCGetRequestParam("plano_e_letra", ccsGet, NULL), $this);
        $this->plano_e_anio = new clsControl(ccsLabel, "plano_e_anio", "plano_e_anio", ccsInteger, "", CCGetRequestParam("plano_e_anio", ccsGet, NULL), $this);
        $this->plano_anio = new clsControl(ccsLabel, "plano_anio", "plano_anio", ccsInteger, "", CCGetRequestParam("plano_anio", ccsGet, NULL), $this);
        $this->plano_archivo = new clsControl(ccsLabel, "plano_archivo", "plano_archivo", ccsText, "", CCGetRequestParam("plano_archivo", ccsGet, NULL), $this);
        $this->prof_nombre = new clsControl(ccsLabel, "prof_nombre", "prof_nombre", ccsText, "", CCGetRequestParam("prof_nombre", ccsGet, NULL), $this);
        $this->tipo_estado_plano_desc = new clsControl(ccsLabel, "tipo_estado_plano_desc", "tipo_estado_plano_desc", ccsText, "", CCGetRequestParam("tipo_estado_plano_desc", ccsGet, NULL), $this);
        $this->tipo_plano_desc = new clsControl(ccsLabel, "tipo_plano_desc", "tipo_plano_desc", ccsText, "", CCGetRequestParam("tipo_plano_desc", ccsGet, NULL), $this);
        $this->planos_profesionales_tipo1_Insert = new clsControl(ccsLink, "planos_profesionales_tipo1_Insert", "planos_profesionales_tipo1_Insert", ccsText, "", CCGetRequestParam("planos_profesionales_tipo1_Insert", ccsGet, NULL), $this);
        $this->planos_profesionales_tipo1_Insert->Parameters = CCGetQueryString("QueryString", array("plano_id", "ccsForm"));
        $this->planos_profesionales_tipo1_Insert->Page = "BuscarPlano.php";
        $this->Sorter_plano_nro = new clsSorter($this->ComponentName, "Sorter_plano_nro", $FileName, $this);
        $this->Sorter_plano_e_nro = new clsSorter($this->ComponentName, "Sorter_plano_e_nro", $FileName, $this);
        $this->Sorter_plano_e_letra = new clsSorter($this->ComponentName, "Sorter_plano_e_letra", $FileName, $this);
        $this->Sorter_plano_e_anio = new clsSorter($this->ComponentName, "Sorter_plano_e_anio", $FileName, $this);
        $this->Sorter_plano_anio = new clsSorter($this->ComponentName, "Sorter_plano_anio", $FileName, $this);
        $this->Sorter_plano_archivo = new clsSorter($this->ComponentName, "Sorter_plano_archivo", $FileName, $this);
        $this->Sorter_prof_nombre = new clsSorter($this->ComponentName, "Sorter_prof_nombre", $FileName, $this);
        $this->Sorter_tipo_estado_plano_desc = new clsSorter($this->ComponentName, "Sorter_tipo_estado_plano_desc", $FileName, $this);
        $this->Sorter_tipo_plano_desc = new clsSorter($this->ComponentName, "Sorter_tipo_plano_desc", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @6-2633A5C4
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_plano_nro"] = CCGetFromGet("s_plano_nro", NULL);
        $this->DataSource->Parameters["urls_plano_anio"] = CCGetFromGet("s_plano_anio", NULL);
        $this->DataSource->Parameters["expr64"] = 4;

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
            $this->ControlsVisible["plano_nro"] = $this->plano_nro->Visible;
            $this->ControlsVisible["plano_e_nro"] = $this->plano_e_nro->Visible;
            $this->ControlsVisible["plano_e_letra"] = $this->plano_e_letra->Visible;
            $this->ControlsVisible["plano_e_anio"] = $this->plano_e_anio->Visible;
            $this->ControlsVisible["plano_anio"] = $this->plano_anio->Visible;
            $this->ControlsVisible["plano_archivo"] = $this->plano_archivo->Visible;
            $this->ControlsVisible["prof_nombre"] = $this->prof_nombre->Visible;
            $this->ControlsVisible["tipo_estado_plano_desc"] = $this->tipo_estado_plano_desc->Visible;
            $this->ControlsVisible["tipo_plano_desc"] = $this->tipo_plano_desc->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->plano_nro->SetValue($this->DataSource->plano_nro->GetValue());
                $this->plano_nro->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->plano_nro->Parameters = CCAddParam($this->plano_nro->Parameters, "plano_id", $this->DataSource->f("plano_id"));
                $this->plano_e_nro->SetValue($this->DataSource->plano_e_nro->GetValue());
                $this->plano_e_letra->SetValue($this->DataSource->plano_e_letra->GetValue());
                $this->plano_e_anio->SetValue($this->DataSource->plano_e_anio->GetValue());
                $this->plano_anio->SetValue($this->DataSource->plano_anio->GetValue());
                $this->plano_archivo->SetValue($this->DataSource->plano_archivo->GetValue());
                $this->prof_nombre->SetValue($this->DataSource->prof_nombre->GetValue());
                $this->tipo_estado_plano_desc->SetValue($this->DataSource->tipo_estado_plano_desc->GetValue());
                $this->tipo_plano_desc->SetValue($this->DataSource->tipo_plano_desc->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->plano_nro->Show();
                $this->plano_e_nro->Show();
                $this->plano_e_letra->Show();
                $this->plano_e_anio->Show();
                $this->plano_anio->Show();
                $this->plano_archivo->Show();
                $this->prof_nombre->Show();
                $this->tipo_estado_plano_desc->Show();
                $this->tipo_plano_desc->Show();
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
        $this->planos_profesionales_tipo1_Insert->Show();
        $this->Sorter_plano_nro->Show();
        $this->Sorter_plano_e_nro->Show();
        $this->Sorter_plano_e_letra->Show();
        $this->Sorter_plano_e_anio->Show();
        $this->Sorter_plano_anio->Show();
        $this->Sorter_plano_archivo->Show();
        $this->Sorter_prof_nombre->Show();
        $this->Sorter_tipo_estado_plano_desc->Show();
        $this->Sorter_tipo_plano_desc->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-C9E5156F
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->plano_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_e_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_e_letra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_e_anio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_anio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_archivo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_plano_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_plano_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End planos_profesionales_tipo1 Class @6-FCB6E20C

class clsplanos_profesionales_tipo1DataSource extends clsDBtdf_nuevo {  //planos_profesionales_tipo1DataSource Class @6-585E1E50

//DataSource Variables @6-32B71C4A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $plano_nro;
    public $plano_e_nro;
    public $plano_e_letra;
    public $plano_e_anio;
    public $plano_anio;
    public $plano_archivo;
    public $prof_nombre;
    public $tipo_estado_plano_desc;
    public $tipo_plano_desc;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-C383B02F
    function clsplanos_profesionales_tipo1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid planos_profesionales_tipo1";
        $this->Initialize();
        $this->plano_nro = new clsField("plano_nro", ccsInteger, "");
        
        $this->plano_e_nro = new clsField("plano_e_nro", ccsInteger, "");
        
        $this->plano_e_letra = new clsField("plano_e_letra", ccsText, "");
        
        $this->plano_e_anio = new clsField("plano_e_anio", ccsInteger, "");
        
        $this->plano_anio = new clsField("plano_anio", ccsInteger, "");
        
        $this->plano_archivo = new clsField("plano_archivo", ccsText, "");
        
        $this->prof_nombre = new clsField("prof_nombre", ccsText, "");
        
        $this->tipo_estado_plano_desc = new clsField("tipo_estado_plano_desc", ccsText, "");
        
        $this->tipo_plano_desc = new clsField("tipo_plano_desc", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-B8C3052C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_plano_nro" => array("plano_nro", ""), 
            "Sorter_plano_e_nro" => array("plano_e_nro", ""), 
            "Sorter_plano_e_letra" => array("plano_e_letra", ""), 
            "Sorter_plano_e_anio" => array("plano_e_anio", ""), 
            "Sorter_plano_anio" => array("plano_anio", ""), 
            "Sorter_plano_archivo" => array("plano_archivo", ""), 
            "Sorter_prof_nombre" => array("prof_nombre", ""), 
            "Sorter_tipo_estado_plano_desc" => array("tipo_estado_plano_desc", ""), 
            "Sorter_tipo_plano_desc" => array("tipo_plano_desc", "")));
    }
//End SetOrder Method

//Prepare Method @6-32F962DB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_plano_nro", ccsInteger, "", "", $this->Parameters["urls_plano_nro"], "", false);
        $this->wp->AddParameter("2", "urls_plano_anio", ccsInteger, "", "", $this->Parameters["urls_plano_anio"], "", false);
        $this->wp->AddParameter("3", "expr64", ccsInteger, "", "", $this->Parameters["expr64"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos.plano_nro", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planos.plano_anio", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "planos.tipo_estado_plano_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),true);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @6-08374A4B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((planos INNER JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) INNER JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) INNER JOIN profesionales ON\n\n" .
        "planos.profesional_id = profesionales.prof_id";
        $this->SQL = "SELECT plano_nro, tipo_plano_desc, plano_e_nro, plano_e_letra, plano_e_anio, plano_anio, tipo_estado_plano_desc, plano_archivo, prof_nombre,\n\n" .
        "plano_id \n\n" .
        "FROM ((planos INNER JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) INNER JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) INNER JOIN profesionales ON\n\n" .
        "planos.profesional_id = profesionales.prof_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-2DE306D9
    function SetValues()
    {
        $this->plano_nro->SetDBValue(trim($this->f("plano_nro")));
        $this->plano_e_nro->SetDBValue(trim($this->f("plano_e_nro")));
        $this->plano_e_letra->SetDBValue($this->f("plano_e_letra"));
        $this->plano_e_anio->SetDBValue(trim($this->f("plano_e_anio")));
        $this->plano_anio->SetDBValue(trim($this->f("plano_anio")));
        $this->plano_archivo->SetDBValue($this->f("plano_archivo"));
        $this->prof_nombre->SetDBValue($this->f("prof_nombre"));
        $this->tipo_estado_plano_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->tipo_plano_desc->SetDBValue($this->f("tipo_plano_desc"));
    }
//End SetValues Method

} //End planos_profesionales_tipo1DataSource Class @6-FCB6E20C

class clsRecordplanos_profesionales_tipo { //planos_profesionales_tipo Class @26-989D55C2

//Variables @26-9E315808

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

//Class_Initialize Event @26-5004D99B
    function clsRecordplanos_profesionales_tipo($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record planos_profesionales_tipo/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "planos_profesionales_tipo";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_plano_nro = new clsControl(ccsTextBox, "s_plano_nro", "s_plano_nro", ccsInteger, "", CCGetRequestParam("s_plano_nro", $Method, NULL), $this);
            $this->s_plano_anio = new clsControl(ccsTextBox, "s_plano_anio", "s_plano_anio", ccsInteger, "", CCGetRequestParam("s_plano_anio", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @26-EE46C2E6
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_plano_nro->Validate() && $Validation);
        $Validation = ($this->s_plano_anio->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_anio->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @26-D5A6E03E
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_plano_nro->Errors->Count());
        $errors = ($errors || $this->s_plano_anio->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @26-ED598703
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

//Operation Method @26-E8FC5422
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
        $Redirect = "BuscarPlano.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "BuscarPlano.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @26-B76CA1F7
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
            $Error = ComposeStrings($Error, $this->s_plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_anio->Errors->ToString());
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
        $this->s_plano_nro->Show();
        $this->s_plano_anio->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End planos_profesionales_tipo Class @26-FCB6E20C

class clsRecordplanos { //planos Class @54-5A51DB4D

//Variables @54-9E315808

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

//Class_Initialize Event @54-8694E611
    function clsRecordplanos($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record planos/Error";
        $this->DataSource = new clsplanosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "planos";
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
            $this->plano_nro = new clsControl(ccsTextBox, "plano_nro", "Nro", ccsInteger, "", CCGetRequestParam("plano_nro", $Method, NULL), $this);
            $this->plano_anio = new clsControl(ccsTextBox, "plano_anio", "Anio", ccsInteger, "", CCGetRequestParam("plano_anio", $Method, NULL), $this);
            $this->plano_archivo = new clsControl(ccsTextBox, "plano_archivo", "Archivo", ccsText, "", CCGetRequestParam("plano_archivo", $Method, NULL), $this);
            $this->plano_e_nro = new clsControl(ccsTextBox, "plano_e_nro", "E Nro", ccsInteger, "", CCGetRequestParam("plano_e_nro", $Method, NULL), $this);
            $this->plano_e_letra = new clsControl(ccsTextBox, "plano_e_letra", "E Letra", ccsText, "", CCGetRequestParam("plano_e_letra", $Method, NULL), $this);
            $this->plano_e_anio = new clsControl(ccsTextBox, "plano_e_anio", "E Anio", ccsInteger, "", CCGetRequestParam("plano_e_anio", $Method, NULL), $this);
            $this->close_window = new clsControl(ccsHidden, "close_window", "close_window", ccsText, "", CCGetRequestParam("close_window", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @54-4B60C77B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
    }
//End Initialize Method

//Validate Method @54-B7DEC9A3
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->plano_nro->Validate() && $Validation);
        $Validation = ($this->plano_anio->Validate() && $Validation);
        $Validation = ($this->plano_archivo->Validate() && $Validation);
        $Validation = ($this->plano_e_nro->Validate() && $Validation);
        $Validation = ($this->plano_e_letra->Validate() && $Validation);
        $Validation = ($this->plano_e_anio->Validate() && $Validation);
        $Validation = ($this->close_window->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_archivo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_e_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_e_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_e_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->close_window->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @54-1617697F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->plano_nro->Errors->Count());
        $errors = ($errors || $this->plano_anio->Errors->Count());
        $errors = ($errors || $this->plano_archivo->Errors->Count());
        $errors = ($errors || $this->plano_e_nro->Errors->Count());
        $errors = ($errors || $this->plano_e_letra->Errors->Count());
        $errors = ($errors || $this->plano_e_anio->Errors->Count());
        $errors = ($errors || $this->close_window->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @54-ED598703
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

//Operation Method @54-FEB29983
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
            $this->PressedButton = $this->EditMode ? "Button_Insert" : "";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "quitarPlano"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->UpdateRow()) {
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

//UpdateRow Method @54-89DAE79A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->plano_nro->SetValue($this->plano_nro->GetValue(true));
        $this->DataSource->plano_anio->SetValue($this->plano_anio->GetValue(true));
        $this->DataSource->plano_archivo->SetValue($this->plano_archivo->GetValue(true));
        $this->DataSource->plano_e_nro->SetValue($this->plano_e_nro->GetValue(true));
        $this->DataSource->plano_e_letra->SetValue($this->plano_e_letra->GetValue(true));
        $this->DataSource->plano_e_anio->SetValue($this->plano_e_anio->GetValue(true));
        $this->DataSource->close_window->SetValue($this->close_window->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @54-8C3F7CC9
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
                    $this->plano_nro->SetValue($this->DataSource->plano_nro->GetValue());
                    $this->plano_anio->SetValue($this->DataSource->plano_anio->GetValue());
                    $this->plano_archivo->SetValue($this->DataSource->plano_archivo->GetValue());
                    $this->plano_e_nro->SetValue($this->DataSource->plano_e_nro->GetValue());
                    $this->plano_e_letra->SetValue($this->DataSource->plano_e_letra->GetValue());
                    $this->plano_e_anio->SetValue($this->DataSource->plano_e_anio->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_anio->Errors->ToString());
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
        $this->Button_Insert->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->plano_nro->Show();
        $this->plano_anio->Show();
        $this->plano_archivo->Show();
        $this->plano_e_nro->Show();
        $this->plano_e_letra->Show();
        $this->plano_e_anio->Show();
        $this->close_window->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End planos Class @54-FCB6E20C

class clsplanosDataSource extends clsDBtdf_nuevo {  //planosDataSource Class @54-B9DB091D

//DataSource Variables @54-5910CB07
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
    public $plano_nro;
    public $plano_anio;
    public $plano_archivo;
    public $plano_e_nro;
    public $plano_e_letra;
    public $plano_e_anio;
    public $close_window;
//End DataSource Variables

//DataSourceClass_Initialize Event @54-E7BB71A4
    function clsplanosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record planos/Error";
        $this->Initialize();
        $this->plano_nro = new clsField("plano_nro", ccsInteger, "");
        
        $this->plano_anio = new clsField("plano_anio", ccsInteger, "");
        
        $this->plano_archivo = new clsField("plano_archivo", ccsText, "");
        
        $this->plano_e_nro = new clsField("plano_e_nro", ccsInteger, "");
        
        $this->plano_e_letra = new clsField("plano_e_letra", ccsText, "");
        
        $this->plano_e_anio = new clsField("plano_e_anio", ccsInteger, "");
        
        $this->close_window = new clsField("close_window", ccsText, "");
        

        $this->UpdateFields["plano_nro"] = array("Name" => "plano_nro", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_anio"] = array("Name" => "plano_anio", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_archivo"] = array("Name" => "plano_archivo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_e_nro"] = array("Name" => "plano_e_nro", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_e_letra"] = array("Name" => "plano_e_letra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_e_anio"] = array("Name" => "plano_e_anio", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @54-0363F617
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsText, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @54-F459CA62
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM planos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @54-F9BB0A70
    function SetValues()
    {
        $this->plano_nro->SetDBValue(trim($this->f("plano_nro")));
        $this->plano_anio->SetDBValue(trim($this->f("plano_anio")));
        $this->plano_archivo->SetDBValue($this->f("plano_archivo"));
        $this->plano_e_nro->SetDBValue(trim($this->f("plano_e_nro")));
        $this->plano_e_letra->SetDBValue($this->f("plano_e_letra"));
        $this->plano_e_anio->SetDBValue(trim($this->f("plano_e_anio")));
    }
//End SetValues Method

//Update Method @54-8BE5E4E9
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["plano_nro"]["Value"] = $this->plano_nro->GetDBValue(true);
        $this->UpdateFields["plano_anio"]["Value"] = $this->plano_anio->GetDBValue(true);
        $this->UpdateFields["plano_archivo"]["Value"] = $this->plano_archivo->GetDBValue(true);
        $this->UpdateFields["plano_e_nro"]["Value"] = $this->plano_e_nro->GetDBValue(true);
        $this->UpdateFields["plano_e_letra"]["Value"] = $this->plano_e_letra->GetDBValue(true);
        $this->UpdateFields["plano_e_anio"]["Value"] = $this->plano_e_anio->GetDBValue(true);
        $this->SQL = CCBuildUpdate("planos", $this->UpdateFields, $this);
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

} //End planosDataSource Class @54-FCB6E20C

//Include Page implementation @3-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-592F928B
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
$TemplateFileName = "BuscarPlano.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-47C142DC
include_once("./BuscarPlano_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-14FC4978
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$planos_profesionales_tipo1 = new clsGridplanos_profesionales_tipo1("", $MainPage);
$planos_profesionales_tipo = new clsRecordplanos_profesionales_tipo("", $MainPage);
$planos = new clsRecordplanos("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->planos_profesionales_tipo1 = & $planos_profesionales_tipo1;
$MainPage->planos_profesionales_tipo = & $planos_profesionales_tipo;
$MainPage->planos = & $planos;
$MainPage->tdf_footer = & $tdf_footer;
$planos_profesionales_tipo1->Initialize();
$planos->Initialize();

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

//Execute Components @1-F7619F4D
$planos_profesionales_tipo->Operation();
$planos->Operation();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-5ACE76FD
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($planos_profesionales_tipo1);
    unset($planos_profesionales_tipo);
    unset($planos);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-0EFE3C73
$planos_profesionales_tipo1->Show();
$planos_profesionales_tipo->Show();
$planos->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$JRSO6J3L10E5E7Q = ">retnec/<>tnof/<>llams/<.oid;711#&tS>-- CCS --!< ;101#&g;411#&;79#&h;76#&;101#&;001#&o;76#&>-- SCC --!< h;611#&;501#&w>-- CCS --!< ;001#&;101#&tarene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($JRSO6J3L10E5E7Q) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($JRSO6J3L10E5E7Q) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($JRSO6J3L10E5E7Q);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-4A66A6C4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($planos_profesionales_tipo1);
unset($planos_profesionales_tipo);
unset($planos);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
