<?php
//Include Common Files @1-F5C2A8C4
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_unidadesGrid.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @4-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridunidades { //unidades class @5-18282647

//Variables @5-1FA0296C

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
    public $Sorter_jerarquia_id;
    public $Sorter_estado_id;
    public $Sorter_entorno_id;
    public $Sorter_unidad_nombre;
    public $Sorter_unidad_pase_externo;
//End Variables

//Class_Initialize Event @5-92F7A8C5
    function clsGridunidades($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "unidades";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid unidades";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsunidadesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("unidadesOrder", "");
        $this->SorterDirection = CCGetParam("unidadesDir", "");

        $this->jerarquia_desc = new clsControl(ccsLabel, "jerarquia_desc", "jerarquia_desc", ccsText, "", CCGetRequestParam("jerarquia_desc", ccsGet, NULL), $this);
        $this->estado_desc = new clsControl(ccsLabel, "estado_desc", "estado_desc", ccsText, "", CCGetRequestParam("estado_desc", ccsGet, NULL), $this);
        $this->entorno_desc = new clsControl(ccsLabel, "entorno_desc", "entorno_desc", ccsText, "", CCGetRequestParam("entorno_desc", ccsGet, NULL), $this);
        $this->unidad_nombre = new clsControl(ccsLabel, "unidad_nombre", "unidad_nombre", ccsText, "", CCGetRequestParam("unidad_nombre", ccsGet, NULL), $this);
        $this->unidad_pase_externo = new clsControl(ccsLabel, "unidad_pase_externo", "unidad_pase_externo", ccsText, "", CCGetRequestParam("unidad_pase_externo", ccsGet, NULL), $this);
        $this->unidad_p_responsable = new clsControl(ccsLabel, "unidad_p_responsable", "unidad_p_responsable", ccsText, "", CCGetRequestParam("unidad_p_responsable", ccsGet, NULL), $this);
        $this->link_edit = new clsControl(ccsImageLink, "link_edit", "link_edit", ccsText, "", CCGetRequestParam("link_edit", ccsGet, NULL), $this);
        $this->link_edit->Page = "pa_unidadesRecord.php";
        $this->unidades_TotalRecords = new clsControl(ccsLabel, "unidades_TotalRecords", "unidades_TotalRecords", ccsText, "", CCGetRequestParam("unidades_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_jerarquia_id = new clsSorter($this->ComponentName, "Sorter_jerarquia_id", $FileName, $this);
        $this->Sorter_estado_id = new clsSorter($this->ComponentName, "Sorter_estado_id", $FileName, $this);
        $this->Sorter_entorno_id = new clsSorter($this->ComponentName, "Sorter_entorno_id", $FileName, $this);
        $this->Sorter_unidad_nombre = new clsSorter($this->ComponentName, "Sorter_unidad_nombre", $FileName, $this);
        $this->Sorter_unidad_pase_externo = new clsSorter($this->ComponentName, "Sorter_unidad_pase_externo", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("unidad_id", "ccsForm"));
        $this->ImageLink1->Page = "pa_unidadesRecord.php";
        $this->Link3 = new clsControl(ccsLink, "Link3", "Link3", ccsText, "", CCGetRequestParam("Link3", ccsGet, NULL), $this);
        $this->Link3->Parameters = CCGetQueryString("QueryString", array("unidad_id", "ccsForm"));
        $this->Link3->Page = "pa_unidadesRecord.php";
    }
//End Class_Initialize Event

//Initialize Method @5-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @5-0645D3C7
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_jerarquia_id"] = CCGetFromGet("s_jerarquia_id", NULL);
        $this->DataSource->Parameters["urls_estado_id"] = CCGetFromGet("s_estado_id", NULL);
        $this->DataSource->Parameters["urls_entorno_id"] = CCGetFromGet("s_entorno_id", NULL);
        $this->DataSource->Parameters["urls_unidad_nombre"] = CCGetFromGet("s_unidad_nombre", NULL);

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
            $this->ControlsVisible["jerarquia_desc"] = $this->jerarquia_desc->Visible;
            $this->ControlsVisible["estado_desc"] = $this->estado_desc->Visible;
            $this->ControlsVisible["entorno_desc"] = $this->entorno_desc->Visible;
            $this->ControlsVisible["unidad_nombre"] = $this->unidad_nombre->Visible;
            $this->ControlsVisible["unidad_pase_externo"] = $this->unidad_pase_externo->Visible;
            $this->ControlsVisible["unidad_p_responsable"] = $this->unidad_p_responsable->Visible;
            $this->ControlsVisible["link_edit"] = $this->link_edit->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->jerarquia_desc->SetValue($this->DataSource->jerarquia_desc->GetValue());
                $this->estado_desc->SetValue($this->DataSource->estado_desc->GetValue());
                $this->entorno_desc->SetValue($this->DataSource->entorno_desc->GetValue());
                $this->unidad_nombre->SetValue($this->DataSource->unidad_nombre->GetValue());
                $this->unidad_pase_externo->SetValue($this->DataSource->unidad_pase_externo->GetValue());
                $this->unidad_p_responsable->SetValue($this->DataSource->unidad_p_responsable->GetValue());
                $this->link_edit->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->link_edit->Parameters = CCAddParam($this->link_edit->Parameters, "unidad_id", $this->DataSource->f("unidad_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->jerarquia_desc->Show();
                $this->estado_desc->Show();
                $this->entorno_desc->Show();
                $this->unidad_nombre->Show();
                $this->unidad_pase_externo->Show();
                $this->unidad_p_responsable->Show();
                $this->link_edit->Show();
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
        $this->unidades_TotalRecords->Show();
        $this->Sorter_jerarquia_id->Show();
        $this->Sorter_estado_id->Show();
        $this->Sorter_entorno_id->Show();
        $this->Sorter_unidad_nombre->Show();
        $this->Sorter_unidad_pase_externo->Show();
        $this->Navigator->Show();
        $this->ImageLink1->Show();
        $this->Link3->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @5-827DDB98
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->jerarquia_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estado_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->entorno_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_pase_externo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_responsable->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_edit->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End unidades Class @5-FCB6E20C

class clsunidadesDataSource extends clsDBmesa {  //unidadesDataSource Class @5-416CB45A

//DataSource Variables @5-B0450472
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $jerarquia_desc;
    public $estado_desc;
    public $entorno_desc;
    public $unidad_nombre;
    public $unidad_pase_externo;
    public $unidad_p_responsable;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-8CE9ADCD
    function clsunidadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid unidades";
        $this->Initialize();
        $this->jerarquia_desc = new clsField("jerarquia_desc", ccsText, "");
        
        $this->estado_desc = new clsField("estado_desc", ccsText, "");
        
        $this->entorno_desc = new clsField("entorno_desc", ccsText, "");
        
        $this->unidad_nombre = new clsField("unidad_nombre", ccsText, "");
        
        $this->unidad_pase_externo = new clsField("unidad_pase_externo", ccsText, "");
        
        $this->unidad_p_responsable = new clsField("unidad_p_responsable", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-541926AF
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "entornos.entorno_desc desc, unidad_nombre, unidad_p_activo desc, unidad_p_f_vig desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_jerarquia_id" => array("jerarquia_id", ""), 
            "Sorter_estado_id" => array("estado_id", ""), 
            "Sorter_entorno_id" => array("entorno_id", ""), 
            "Sorter_unidad_nombre" => array("unidad_nombre", ""), 
            "Sorter_unidad_pase_externo" => array("unidad_pase_externo", "")));
    }
//End SetOrder Method

//Prepare Method @5-CFB7862D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_jerarquia_id", ccsInteger, "", "", $this->Parameters["urls_jerarquia_id"], "", false);
        $this->wp->AddParameter("2", "urls_estado_id", ccsInteger, "", "", $this->Parameters["urls_estado_id"], "", false);
        $this->wp->AddParameter("3", "urls_entorno_id", ccsInteger, "", "", $this->Parameters["urls_entorno_id"], "", false);
        $this->wp->AddParameter("4", "urls_unidad_nombre", ccsText, "", "", $this->Parameters["urls_unidad_nombre"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "unidades.jerarquia_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "unidades.estado_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "unidades.entorno_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "unidades.unidad_nombre", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @5-D5E1EC04
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT unidades.*, entorno_desc, estado_desc, jerarquia_desc, unidad_p_responsable \n\n" .
        "FROM (((unidades LEFT JOIN entornos ON\n\n" .
        "unidades.entorno_id = entornos.entorno_id) LEFT JOIN estados ON\n\n" .
        "unidades.estado_id = estados.estado_id) LEFT JOIN jeraquias ON\n\n" .
        "unidades.jerarquia_id = jeraquias.jerarquia_id) LEFT JOIN unidades_param ON\n\n" .
        "unidades.unidad_id = unidades_param.unidad_id {SQL_Where}\n\n" .
        "GROUP BY unidades.unidad_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-9082CBE1
    function SetValues()
    {
        $this->jerarquia_desc->SetDBValue($this->f("jerarquia_desc"));
        $this->estado_desc->SetDBValue($this->f("estado_desc"));
        $this->entorno_desc->SetDBValue($this->f("entorno_desc"));
        $this->unidad_nombre->SetDBValue($this->f("unidad_nombre"));
        $this->unidad_pase_externo->SetDBValue($this->f("unidad_pase_externo"));
        $this->unidad_p_responsable->SetDBValue($this->f("unidad_p_responsable"));
    }
//End SetValues Method

} //End unidadesDataSource Class @5-FCB6E20C

class clsRecordunidadesSearch { //unidadesSearch Class @6-7709CBB4

//Variables @6-9E315808

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

//Class_Initialize Event @6-F8868124
    function clsRecordunidadesSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record unidadesSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "unidadesSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_jerarquia_id = new clsControl(ccsListBox, "s_jerarquia_id", "s_jerarquia_id", ccsInteger, "", CCGetRequestParam("s_jerarquia_id", $Method, NULL), $this);
            $this->s_jerarquia_id->DSType = dsTable;
            $this->s_jerarquia_id->DataSource = new clsDBmesa();
            $this->s_jerarquia_id->ds = & $this->s_jerarquia_id->DataSource;
            $this->s_jerarquia_id->DataSource->SQL = "SELECT * \n" .
"FROM jeraquias {SQL_Where} {SQL_OrderBy}";
            list($this->s_jerarquia_id->BoundColumn, $this->s_jerarquia_id->TextColumn, $this->s_jerarquia_id->DBFormat) = array("jerarquia_id", "jerarquia_desc", "");
            $this->s_estado_id = new clsControl(ccsListBox, "s_estado_id", "s_estado_id", ccsInteger, "", CCGetRequestParam("s_estado_id", $Method, NULL), $this);
            $this->s_estado_id->DSType = dsTable;
            $this->s_estado_id->DataSource = new clsDBmesa();
            $this->s_estado_id->ds = & $this->s_estado_id->DataSource;
            $this->s_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM estados {SQL_Where} {SQL_OrderBy}";
            list($this->s_estado_id->BoundColumn, $this->s_estado_id->TextColumn, $this->s_estado_id->DBFormat) = array("estado_id", "estado_desc", "");
            $this->s_entorno_id = new clsControl(ccsListBox, "s_entorno_id", "s_entorno_id", ccsInteger, "", CCGetRequestParam("s_entorno_id", $Method, NULL), $this);
            $this->s_entorno_id->DSType = dsTable;
            $this->s_entorno_id->DataSource = new clsDBmesa();
            $this->s_entorno_id->ds = & $this->s_entorno_id->DataSource;
            $this->s_entorno_id->DataSource->SQL = "SELECT * \n" .
"FROM entornos {SQL_Where} {SQL_OrderBy}";
            list($this->s_entorno_id->BoundColumn, $this->s_entorno_id->TextColumn, $this->s_entorno_id->DBFormat) = array("entorno_id", "entorno_desc", "");
            $this->s_unidad_nombre = new clsControl(ccsTextBox, "s_unidad_nombre", "s_unidad_nombre", ccsText, "", CCGetRequestParam("s_unidad_nombre", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @6-7B83DD01
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_jerarquia_id->Validate() && $Validation);
        $Validation = ($this->s_estado_id->Validate() && $Validation);
        $Validation = ($this->s_entorno_id->Validate() && $Validation);
        $Validation = ($this->s_unidad_nombre->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_jerarquia_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_entorno_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_unidad_nombre->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-A3C2C1B9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_jerarquia_id->Errors->Count());
        $errors = ($errors || $this->s_estado_id->Errors->Count());
        $errors = ($errors || $this->s_entorno_id->Errors->Count());
        $errors = ($errors || $this->s_unidad_nombre->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @6-ED598703
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

//Operation Method @6-F86FE826
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
        $Redirect = "pa_unidadesGrid.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_unidadesGrid.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
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
    }
//End Operation Method

//Show Method @6-D8901721
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

        $this->s_jerarquia_id->Prepare();
        $this->s_estado_id->Prepare();
        $this->s_entorno_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_jerarquia_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_entorno_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_unidad_nombre->Errors->ToString());
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
        $this->s_jerarquia_id->Show();
        $this->s_estado_id->Show();
        $this->s_entorno_id->Show();
        $this->s_unidad_nombre->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End unidadesSearch Class @6-FCB6E20C

//Initialize Page @1-19C2AF89
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
$TemplateFileName = "pa_unidadesGrid.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-89C0F2BA
include_once("./pa_unidadesGrid_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-8EAC6FD0
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
$unidades = new clsGridunidades("", $MainPage);
$unidadesSearch = new clsRecordunidadesSearch("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->unidades = & $unidades;
$MainPage->unidadesSearch = & $unidadesSearch;
$unidades->Initialize();

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

//Execute Components @1-9BDDDCEE
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$unidadesSearch->Operation();
//End Execute Components

//Go to destination page @1-E1D361BF
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
    unset($unidades);
    unset($unidadesSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7A73C123
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$unidades->Show();
$unidadesSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=" . "\"Arial\"><small>&" . "#71;&#101;&#110;e" . "&#114;&#97;t&#101;d" . " <!-- SCC -->w&" . "#105;t&#104; <!" . "-- CCS -->CodeC" . "&#104;&#97;&#11" . "4;ge <!-- CCS -->&#" . "83;t&#117;&#100" . ";&#105;&#111;.</s" . "mall></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=" . "\"Arial\"><small>&" . "#71;&#101;&#110;e" . "&#114;&#97;t&#101;d" . " <!-- SCC -->w&" . "#105;t&#104; <!" . "-- CCS -->CodeC" . "&#104;&#97;&#11" . "4;ge <!-- CCS -->&#" . "83;t&#117;&#100" . ";&#105;&#111;.</s" . "mall></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=" . "\"Arial\"><small>&" . "#71;&#101;&#110;e" . "&#114;&#97;t&#101;d" . " <!-- SCC -->w&" . "#105;t&#104; <!" . "-- CCS -->CodeC" . "&#104;&#97;&#11" . "4;ge <!-- CCS -->&#" . "83;t&#117;&#100" . ";&#105;&#111;.</s" . "mall></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2BABF09E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($unidades);
unset($unidadesSearch);
unset($Tpl);
//End Unload Page


?>
