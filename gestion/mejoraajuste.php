<?php
//Include Common Files @1-20C0F38B
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "mejoraajuste.php");
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

class clsGridtipos_coef_ajustes { //tipos_coef_ajustes class @6-99A4AAF5

//Variables @6-338CF5F0

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
    public $Sorter_tipo_coef_ajuste_f_ini;
    public $Sorter_tipo_coef_ajuste_f_fin;
    public $Sorter_tipo_coef_ajuste_valor;
//End Variables

//Class_Initialize Event @6-BB436706
    function clsGridtipos_coef_ajustes($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tipos_coef_ajustes";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid tipos_coef_ajustes";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstipos_coef_ajustesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 25;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("tipos_coef_ajustesOrder", "");
        $this->SorterDirection = CCGetParam("tipos_coef_ajustesDir", "");

        $this->tipo_coef_ajuste_f_ini = new clsControl(ccsLabel, "tipo_coef_ajuste_f_ini", "tipo_coef_ajuste_f_ini", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("tipo_coef_ajuste_f_ini", ccsGet, NULL), $this);
        $this->tipo_coef_ajuste_f_fin = new clsControl(ccsLabel, "tipo_coef_ajuste_f_fin", "tipo_coef_ajuste_f_fin", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("tipo_coef_ajuste_f_fin", ccsGet, NULL), $this);
        $this->tipo_coef_ajuste_valor = new clsControl(ccsLabel, "tipo_coef_ajuste_valor", "tipo_coef_ajuste_valor", ccsText, "", CCGetRequestParam("tipo_coef_ajuste_valor", ccsGet, NULL), $this);
        $this->Sorter_tipo_coef_ajuste_f_ini = new clsSorter($this->ComponentName, "Sorter_tipo_coef_ajuste_f_ini", $FileName, $this);
        $this->Sorter_tipo_coef_ajuste_f_fin = new clsSorter($this->ComponentName, "Sorter_tipo_coef_ajuste_f_fin", $FileName, $this);
        $this->Sorter_tipo_coef_ajuste_valor = new clsSorter($this->ComponentName, "Sorter_tipo_coef_ajuste_valor", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
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

//Show Method @6-D22DAEC1
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


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
            $this->ControlsVisible["tipo_coef_ajuste_f_ini"] = $this->tipo_coef_ajuste_f_ini->Visible;
            $this->ControlsVisible["tipo_coef_ajuste_f_fin"] = $this->tipo_coef_ajuste_f_fin->Visible;
            $this->ControlsVisible["tipo_coef_ajuste_valor"] = $this->tipo_coef_ajuste_valor->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_coef_ajuste_f_ini->SetValue($this->DataSource->tipo_coef_ajuste_f_ini->GetValue());
                $this->tipo_coef_ajuste_f_fin->SetValue($this->DataSource->tipo_coef_ajuste_f_fin->GetValue());
                $this->tipo_coef_ajuste_valor->SetValue($this->DataSource->tipo_coef_ajuste_valor->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_coef_ajuste_f_ini->Show();
                $this->tipo_coef_ajuste_f_fin->Show();
                $this->tipo_coef_ajuste_valor->Show();
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
        $this->Sorter_tipo_coef_ajuste_f_ini->Show();
        $this->Sorter_tipo_coef_ajuste_f_fin->Show();
        $this->Sorter_tipo_coef_ajuste_valor->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-CA18794E
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_coef_ajuste_f_ini->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_coef_ajuste_f_fin->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_coef_ajuste_valor->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End tipos_coef_ajustes Class @6-FCB6E20C

class clstipos_coef_ajustesDataSource extends clsDBtdf_nuevo {  //tipos_coef_ajustesDataSource Class @6-EF417917

//DataSource Variables @6-314D479A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_coef_ajuste_f_ini;
    public $tipo_coef_ajuste_f_fin;
    public $tipo_coef_ajuste_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-3878A807
    function clstipos_coef_ajustesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid tipos_coef_ajustes";
        $this->Initialize();
        $this->tipo_coef_ajuste_f_ini = new clsField("tipo_coef_ajuste_f_ini", ccsDate, $this->DateFormat);
        
        $this->tipo_coef_ajuste_f_fin = new clsField("tipo_coef_ajuste_f_fin", ccsDate, $this->DateFormat);
        
        $this->tipo_coef_ajuste_valor = new clsField("tipo_coef_ajuste_valor", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-E1797ABA
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_coef_ajuste_f_ini desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_coef_ajuste_f_ini" => array("tipo_coef_ajuste_f_ini", ""), 
            "Sorter_tipo_coef_ajuste_f_fin" => array("tipo_coef_ajuste_f_fin", ""), 
            "Sorter_tipo_coef_ajuste_valor" => array("tipo_coef_ajuste_valor", "")));
    }
//End SetOrder Method

//Prepare Method @6-DBA6A5EF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->Criterion[1] = "( tipo_coef_ajuste_f_fin IS NOT NULL )";
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-F4796300
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_coef_ajustes";
        $this->SQL = "SELECT tipo_coef_ajuste_id, tipo_coef_ajuste_f_ini, tipo_coef_ajuste_f_fin, tipo_coef_ajuste_valor \n\n" .
        "FROM tipos_coef_ajustes {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-8ABD6082
    function SetValues()
    {
        $this->tipo_coef_ajuste_f_ini->SetDBValue(trim($this->f("tipo_coef_ajuste_f_ini")));
        $this->tipo_coef_ajuste_f_fin->SetDBValue(trim($this->f("tipo_coef_ajuste_f_fin")));
        $this->tipo_coef_ajuste_valor->SetDBValue($this->f("tipo_coef_ajuste_valor"));
    }
//End SetValues Method

} //End tipos_coef_ajustesDataSource Class @6-FCB6E20C

class clsRecordtipos_coef_ajustes1 { //tipos_coef_ajustes1 Class @20-275D2974

//Variables @20-9E315808

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

//Class_Initialize Event @20-CAF579BE
    function clsRecordtipos_coef_ajustes1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_coef_ajustes1/Error";
        $this->DataSource = new clstipos_coef_ajustes1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_coef_ajustes1";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->tipo_coef_ajuste_valor = new clsControl(ccsTextBox, "tipo_coef_ajuste_valor", "Tipo Coef Ajuste Valor", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("tipo_coef_ajuste_valor", $Method, NULL), $this);
            $this->tipo_coef_ajuste_valor->Required = true;
            $this->Button_clear = new clsButton("Button_clear", $Method, $this);
            $this->tipo_coef_ajuste_f_ini = new clsControl(ccsHidden, "tipo_coef_ajuste_f_ini", "Tipo Coef Ajuste F Ini", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("tipo_coef_ajuste_f_ini", $Method, NULL), $this);
            $this->tipo_coef_ajuste_f_ini->Required = true;
            $this->tipo_coef_ajuste_f_fin = new clsControl(ccsHidden, "tipo_coef_ajuste_f_fin", "Tipo Coef Ajuste F Fin", ccsDate, $DefaultDateFormat, CCGetRequestParam("tipo_coef_ajuste_f_fin", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_coef_ajuste_f_ini->Value) && !strlen($this->tipo_coef_ajuste_f_ini->Value) && $this->tipo_coef_ajuste_f_ini->Value !== false)
                    $this->tipo_coef_ajuste_f_ini->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @20-8C5DEF18
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urltipo_coef_ajuste_id"] = CCGetFromGet("tipo_coef_ajuste_id", NULL);
    }
//End Initialize Method

//Validate Method @20-32B935F4
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_coef_ajuste_valor->Validate() && $Validation);
        $Validation = ($this->tipo_coef_ajuste_f_ini->Validate() && $Validation);
        $Validation = ($this->tipo_coef_ajuste_f_fin->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_coef_ajuste_valor->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_coef_ajuste_f_ini->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_coef_ajuste_f_fin->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @20-D906D3B9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_coef_ajuste_valor->Errors->Count());
        $errors = ($errors || $this->tipo_coef_ajuste_f_ini->Errors->Count());
        $errors = ($errors || $this->tipo_coef_ajuste_f_fin->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @20-ED598703
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

//Operation Method @20-9E57DBF1
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->Button_clear->Pressed) {
                $this->PressedButton = "Button_clear";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "gridMejoras.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_Insert", "Button_Insert_x", "Button_Insert_y", "Button_Update", "Button_Update_x", "Button_Update_y", "Button_Cancel", "Button_Cancel_x", "Button_Cancel_y", "Button_clear", "Button_clear_x", "Button_clear_y", "tipo_coef_ajuste_id")), CCGetQueryString("QueryString", array("tipo_coef_ajuste_valor", "tipo_coef_ajuste_f_ini", "tipo_coef_ajuste_f_fin", "ccsForm", "tipo_coef_ajuste_id")));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_clear") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "tipo_coef_ajuste_id"));
            if(!CCGetEvent($this->Button_clear->CCSEvents, "OnClick", $this->Button_clear)) {
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

//InsertRow Method @20-6EFEE8B6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_coef_ajuste_valor->SetValue($this->tipo_coef_ajuste_valor->GetValue(true));
        $this->DataSource->tipo_coef_ajuste_f_ini->SetValue($this->tipo_coef_ajuste_f_ini->GetValue(true));
        $this->DataSource->tipo_coef_ajuste_f_fin->SetValue($this->tipo_coef_ajuste_f_fin->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @20-C4A7846D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_coef_ajuste_valor->SetValue($this->tipo_coef_ajuste_valor->GetValue(true));
        $this->DataSource->tipo_coef_ajuste_f_ini->SetValue($this->tipo_coef_ajuste_f_ini->GetValue(true));
        $this->DataSource->tipo_coef_ajuste_f_fin->SetValue($this->tipo_coef_ajuste_f_fin->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @20-250EC2A7
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
                    $this->tipo_coef_ajuste_valor->SetValue($this->DataSource->tipo_coef_ajuste_valor->GetValue());
                    $this->tipo_coef_ajuste_f_ini->SetValue($this->DataSource->tipo_coef_ajuste_f_ini->GetValue());
                    $this->tipo_coef_ajuste_f_fin->SetValue($this->DataSource->tipo_coef_ajuste_f_fin->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_coef_ajuste_valor->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_coef_ajuste_f_ini->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_coef_ajuste_f_fin->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->tipo_coef_ajuste_valor->Show();
        $this->Button_clear->Show();
        $this->tipo_coef_ajuste_f_ini->Show();
        $this->tipo_coef_ajuste_f_fin->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End tipos_coef_ajustes1 Class @20-FCB6E20C

class clstipos_coef_ajustes1DataSource extends clsDBtdf_nuevo {  //tipos_coef_ajustes1DataSource Class @20-F966050D

//DataSource Variables @20-C7A3A158
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $tipo_coef_ajuste_valor;
    public $tipo_coef_ajuste_f_ini;
    public $tipo_coef_ajuste_f_fin;
//End DataSource Variables

//DataSourceClass_Initialize Event @20-6C31B694
    function clstipos_coef_ajustes1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record tipos_coef_ajustes1/Error";
        $this->Initialize();
        $this->tipo_coef_ajuste_valor = new clsField("tipo_coef_ajuste_valor", ccsFloat, "");
        
        $this->tipo_coef_ajuste_f_ini = new clsField("tipo_coef_ajuste_f_ini", ccsDate, $this->DateFormat);
        
        $this->tipo_coef_ajuste_f_fin = new clsField("tipo_coef_ajuste_f_fin", ccsDate, $this->DateFormat);
        

        $this->InsertFields["tipo_coef_ajuste_valor"] = array("Name" => "tipo_coef_ajuste_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_coef_ajuste_f_ini"] = array("Name" => "tipo_coef_ajuste_f_ini", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_coef_ajuste_f_fin"] = array("Name" => "tipo_coef_ajuste_f_fin", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_coef_ajuste_valor"] = array("Name" => "tipo_coef_ajuste_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_coef_ajuste_f_ini"] = array("Name" => "tipo_coef_ajuste_f_ini", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_coef_ajuste_f_fin"] = array("Name" => "tipo_coef_ajuste_f_fin", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @20-630966CA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urltipo_coef_ajuste_id", ccsInteger, "", "", $this->Parameters["urltipo_coef_ajuste_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tipo_coef_ajuste_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @20-EC490791
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_coef_ajustes {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @20-F811F8A7
    function SetValues()
    {
        $this->tipo_coef_ajuste_valor->SetDBValue(trim($this->f("tipo_coef_ajuste_valor")));
        $this->tipo_coef_ajuste_f_ini->SetDBValue(trim($this->f("tipo_coef_ajuste_f_ini")));
        $this->tipo_coef_ajuste_f_fin->SetDBValue(trim($this->f("tipo_coef_ajuste_f_fin")));
    }
//End SetValues Method

//Insert Method @20-91444272
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_coef_ajuste_valor"]["Value"] = $this->tipo_coef_ajuste_valor->GetDBValue(true);
        $this->InsertFields["tipo_coef_ajuste_f_ini"]["Value"] = $this->tipo_coef_ajuste_f_ini->GetDBValue(true);
        $this->InsertFields["tipo_coef_ajuste_f_fin"]["Value"] = $this->tipo_coef_ajuste_f_fin->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_coef_ajustes", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @20-553F71A1
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_coef_ajuste_valor"]["Value"] = $this->tipo_coef_ajuste_valor->GetDBValue(true);
        $this->UpdateFields["tipo_coef_ajuste_f_ini"]["Value"] = $this->tipo_coef_ajuste_f_ini->GetDBValue(true);
        $this->UpdateFields["tipo_coef_ajuste_f_fin"]["Value"] = $this->tipo_coef_ajuste_f_fin->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_coef_ajustes", $this->UpdateFields, $this);
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

} //End tipos_coef_ajustes1DataSource Class @20-FCB6E20C

class clsGridtipos_coef_ajustes2 { //tipos_coef_ajustes2 class @32-F920114C

//Variables @32-338CF5F0

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
    public $Sorter_tipo_coef_ajuste_f_ini;
    public $Sorter_tipo_coef_ajuste_f_fin;
    public $Sorter_tipo_coef_ajuste_valor;
//End Variables

//Class_Initialize Event @32-E43A10E7
    function clsGridtipos_coef_ajustes2($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "tipos_coef_ajustes2";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid tipos_coef_ajustes2";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstipos_coef_ajustes2DataSource($this);
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
        $this->SorterName = CCGetParam("tipos_coef_ajustes2Order", "");
        $this->SorterDirection = CCGetParam("tipos_coef_ajustes2Dir", "");

        $this->tipo_coef_ajuste_f_ini = new clsControl(ccsLink, "tipo_coef_ajuste_f_ini", "tipo_coef_ajuste_f_ini", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("tipo_coef_ajuste_f_ini", ccsGet, NULL), $this);
        $this->tipo_coef_ajuste_f_ini->Page = "";
        $this->tipo_coef_ajuste_f_fin = new clsControl(ccsLabel, "tipo_coef_ajuste_f_fin", "tipo_coef_ajuste_f_fin", ccsText, "", CCGetRequestParam("tipo_coef_ajuste_f_fin", ccsGet, NULL), $this);
        $this->tipo_coef_ajuste_valor = new clsControl(ccsLabel, "tipo_coef_ajuste_valor", "tipo_coef_ajuste_valor", ccsText, "", CCGetRequestParam("tipo_coef_ajuste_valor", ccsGet, NULL), $this);
        $this->Sorter_tipo_coef_ajuste_f_ini = new clsSorter($this->ComponentName, "Sorter_tipo_coef_ajuste_f_ini", $FileName, $this);
        $this->Sorter_tipo_coef_ajuste_f_fin = new clsSorter($this->ComponentName, "Sorter_tipo_coef_ajuste_f_fin", $FileName, $this);
        $this->Sorter_tipo_coef_ajuste_valor = new clsSorter($this->ComponentName, "Sorter_tipo_coef_ajuste_valor", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @32-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @32-55FCE42B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


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
            $this->ControlsVisible["tipo_coef_ajuste_f_ini"] = $this->tipo_coef_ajuste_f_ini->Visible;
            $this->ControlsVisible["tipo_coef_ajuste_f_fin"] = $this->tipo_coef_ajuste_f_fin->Visible;
            $this->ControlsVisible["tipo_coef_ajuste_valor"] = $this->tipo_coef_ajuste_valor->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                if(!is_array($this->tipo_coef_ajuste_f_fin->Value) && !strlen($this->tipo_coef_ajuste_f_fin->Value) && $this->tipo_coef_ajuste_f_fin->Value !== false)
                    $this->tipo_coef_ajuste_f_fin->SetText("a la fecha actual");
                $this->tipo_coef_ajuste_f_ini->SetValue($this->DataSource->tipo_coef_ajuste_f_ini->GetValue());
                $this->tipo_coef_ajuste_f_ini->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->tipo_coef_ajuste_f_ini->Parameters = CCAddParam($this->tipo_coef_ajuste_f_ini->Parameters, "tipo_coef_ajuste_id", $this->DataSource->f("tipo_coef_ajuste_id"));
                $this->tipo_coef_ajuste_valor->SetValue($this->DataSource->tipo_coef_ajuste_valor->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_coef_ajuste_f_ini->Show();
                $this->tipo_coef_ajuste_f_fin->Show();
                $this->tipo_coef_ajuste_valor->Show();
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
        $this->Sorter_tipo_coef_ajuste_f_ini->Show();
        $this->Sorter_tipo_coef_ajuste_f_fin->Show();
        $this->Sorter_tipo_coef_ajuste_valor->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @32-CA18794E
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_coef_ajuste_f_ini->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_coef_ajuste_f_fin->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_coef_ajuste_valor->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End tipos_coef_ajustes2 Class @32-FCB6E20C

class clstipos_coef_ajustes2DataSource extends clsDBtdf_nuevo {  //tipos_coef_ajustes2DataSource Class @32-A271B418

//DataSource Variables @32-F40FBDDF
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_coef_ajuste_f_ini;
    public $tipo_coef_ajuste_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @32-136AB2C0
    function clstipos_coef_ajustes2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid tipos_coef_ajustes2";
        $this->Initialize();
        $this->tipo_coef_ajuste_f_ini = new clsField("tipo_coef_ajuste_f_ini", ccsDate, $this->DateFormat);
        
        $this->tipo_coef_ajuste_valor = new clsField("tipo_coef_ajuste_valor", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @32-5141807D
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tipo_coef_ajuste_f_ini" => array("tipo_coef_ajuste_f_ini", ""), 
            "Sorter_tipo_coef_ajuste_f_fin" => array("tipo_coef_ajuste_f_fin", ""), 
            "Sorter_tipo_coef_ajuste_valor" => array("tipo_coef_ajuste_valor", "")));
    }
//End SetOrder Method

//Prepare Method @32-C29C60DA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->Criterion[1] = "( tipo_coef_ajuste_f_fin IS NULL )";
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @32-771C11FF
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_coef_ajustes";
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_coef_ajustes {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @32-4F376267
    function SetValues()
    {
        $this->tipo_coef_ajuste_f_ini->SetDBValue(trim($this->f("tipo_coef_ajuste_f_ini")));
        $this->tipo_coef_ajuste_valor->SetDBValue($this->f("tipo_coef_ajuste_valor"));
    }
//End SetValues Method

} //End tipos_coef_ajustes2DataSource Class @32-FCB6E20C

//Initialize Page @1-F7A8F82A
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
$TemplateFileName = "mejoraajuste.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-64FE7868
include_once("./mejoraajuste_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C3BBC57D
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
$tipos_coef_ajustes = new clsGridtipos_coef_ajustes("", $MainPage);
$tipos_coef_ajustes1 = new clsRecordtipos_coef_ajustes1("", $MainPage);
$tipos_coef_ajustes2 = new clsGridtipos_coef_ajustes2("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tipos_coef_ajustes = & $tipos_coef_ajustes;
$MainPage->tipos_coef_ajustes1 = & $tipos_coef_ajustes1;
$MainPage->tipos_coef_ajustes2 = & $tipos_coef_ajustes2;
$tipos_coef_ajustes->Initialize();
$tipos_coef_ajustes1->Initialize();
$tipos_coef_ajustes2->Initialize();

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

//Execute Components @1-0936561B
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$tipos_coef_ajustes1->Operation();
//End Execute Components

//Go to destination page @1-B97A0AB1
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
    unset($tipos_coef_ajustes);
    unset($tipos_coef_ajustes1);
    unset($tipos_coef_ajustes2);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-2468334E
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$tipos_coef_ajustes->Show();
$tipos_coef_ajustes1->Show();
$tipos_coef_ajustes2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&idut;38#&>-- SCC --!< egr;79#&;401#&;76#&ed;111#&;76#&>-- CCS --!< h;611#&;501#&;911#&>-- SCC --!< ;001#&et;79#&rene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&idut;38#&>-- SCC --!< egr;79#&;401#&;76#&ed;111#&;76#&>-- CCS --!< h;611#&;501#&;911#&>-- SCC --!< ;001#&et;79#&rene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.;111#&idut;38#&>-- SCC --!< egr;79#&;401#&;76#&ed;111#&;76#&>-- CCS --!< h;611#&;501#&;911#&>-- SCC --!< ;001#&et;79#&rene;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-F73A782F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($tipos_coef_ajustes);
unset($tipos_coef_ajustes1);
unset($tipos_coef_ajustes2);
unset($Tpl);
//End Unload Page


?>
