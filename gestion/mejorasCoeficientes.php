<?php
//Include Common Files @1-18C5D46A
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "mejorasCoeficientes.php");
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

class clsRecordmejoras_coeficientes1 { //mejoras_coeficientes1 Class @23-51249F95

//Variables @23-9E315808

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

//Class_Initialize Event @23-FF4EF5D7
    function clsRecordmejoras_coeficientes1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mejoras_coeficientes1/Error";
        $this->DataSource = new clsmejoras_coeficientes1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "mejoras_coeficientes1";
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
            $this->tipo_mejora_cat_id = new clsControl(ccsListBox, "tipo_mejora_cat_id", "Categoria", ccsInteger, "", CCGetRequestParam("tipo_mejora_cat_id", $Method, NULL), $this);
            $this->tipo_mejora_cat_id->DSType = dsTable;
            $this->tipo_mejora_cat_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_cat_id->ds = & $this->tipo_mejora_cat_id->DataSource;
            $this->tipo_mejora_cat_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_cat {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_cat_id->BoundColumn, $this->tipo_mejora_cat_id->TextColumn, $this->tipo_mejora_cat_id->DBFormat) = array("tipo_mejora_cat_id", "tipo_mejora_cat_descript", "");
            $this->tipo_mejora_cat_id->Required = true;
            $this->tipo_mejora_conserva_id = new clsControl(ccsListBox, "tipo_mejora_conserva_id", "Conservacion", ccsInteger, "", CCGetRequestParam("tipo_mejora_conserva_id", $Method, NULL), $this);
            $this->tipo_mejora_conserva_id->DSType = dsTable;
            $this->tipo_mejora_conserva_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_mejora_conserva_id->ds = & $this->tipo_mejora_conserva_id->DataSource;
            $this->tipo_mejora_conserva_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_mejoras_conserva {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mejora_conserva_id->BoundColumn, $this->tipo_mejora_conserva_id->TextColumn, $this->tipo_mejora_conserva_id->DBFormat) = array("tipo_mejora_conserva_id", "tipo_mejora_conserva_descrip", "");
            $this->tipo_mejora_conserva_id->Required = true;
            $this->mejora_coeficiente_anio = new clsControl(ccsTextBox, "mejora_coeficiente_anio", "Mejora Coeficiente Anio", ccsInteger, "", CCGetRequestParam("mejora_coeficiente_anio", $Method, NULL), $this);
            $this->mejora_coeficiente_anio->Required = true;
            $this->mejora_coeficiente_valor = new clsControl(ccsTextBox, "mejora_coeficiente_valor", "Mejora Coeficiente Valor", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("mejora_coeficiente_valor", $Method, NULL), $this);
            $this->mejora_coeficiente_valor->Required = true;
            $this->volver = new clsButton("volver", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @23-1EF849D5
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlmejora_coeficiente_id"] = CCGetFromGet("mejora_coeficiente_id", NULL);
    }
//End Initialize Method

//Validate Method @23-2E6DC3AB
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_mejora_cat_id->Validate() && $Validation);
        $Validation = ($this->tipo_mejora_conserva_id->Validate() && $Validation);
        $Validation = ($this->mejora_coeficiente_anio->Validate() && $Validation);
        $Validation = ($this->mejora_coeficiente_valor->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_mejora_cat_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_mejora_conserva_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_coeficiente_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mejora_coeficiente_valor->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @23-A3D8E3C9
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_mejora_cat_id->Errors->Count());
        $errors = ($errors || $this->tipo_mejora_conserva_id->Errors->Count());
        $errors = ($errors || $this->mejora_coeficiente_anio->Errors->Count());
        $errors = ($errors || $this->mejora_coeficiente_valor->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @23-ED598703
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

//Operation Method @23-379E6587
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
            } else if($this->volver->Pressed) {
                $this->PressedButton = "volver";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_coeficiente_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "volver") {
            $Redirect = "gridMejoras.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "mejora_coeficiente_id"));
            if(!CCGetEvent($this->volver->CCSEvents, "OnClick", $this->volver)) {
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

//InsertRow Method @23-0CBC5DCE
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        $this->DataSource->mejora_coeficiente_anio->SetValue($this->mejora_coeficiente_anio->GetValue(true));
        $this->DataSource->mejora_coeficiente_valor->SetValue($this->mejora_coeficiente_valor->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @23-2BD267DE
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_mejora_cat_id->SetValue($this->tipo_mejora_cat_id->GetValue(true));
        $this->DataSource->tipo_mejora_conserva_id->SetValue($this->tipo_mejora_conserva_id->GetValue(true));
        $this->DataSource->mejora_coeficiente_anio->SetValue($this->mejora_coeficiente_anio->GetValue(true));
        $this->DataSource->mejora_coeficiente_valor->SetValue($this->mejora_coeficiente_valor->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @23-8A4051C9
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

        $this->tipo_mejora_cat_id->Prepare();
        $this->tipo_mejora_conserva_id->Prepare();

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
                    $this->tipo_mejora_cat_id->SetValue($this->DataSource->tipo_mejora_cat_id->GetValue());
                    $this->tipo_mejora_conserva_id->SetValue($this->DataSource->tipo_mejora_conserva_id->GetValue());
                    $this->mejora_coeficiente_anio->SetValue($this->DataSource->mejora_coeficiente_anio->GetValue());
                    $this->mejora_coeficiente_valor->SetValue($this->DataSource->mejora_coeficiente_valor->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_mejora_cat_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_mejora_conserva_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_coeficiente_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mejora_coeficiente_valor->Errors->ToString());
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
        $this->tipo_mejora_cat_id->Show();
        $this->tipo_mejora_conserva_id->Show();
        $this->mejora_coeficiente_anio->Show();
        $this->mejora_coeficiente_valor->Show();
        $this->volver->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mejoras_coeficientes1 Class @23-FCB6E20C

class clsmejoras_coeficientes1DataSource extends clsDBtdf_nuevo {  //mejoras_coeficientes1DataSource Class @23-BA8472AD

//DataSource Variables @23-E4CCDC50
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
    public $tipo_mejora_cat_id;
    public $tipo_mejora_conserva_id;
    public $mejora_coeficiente_anio;
    public $mejora_coeficiente_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @23-0829194C
    function clsmejoras_coeficientes1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mejoras_coeficientes1/Error";
        $this->Initialize();
        $this->tipo_mejora_cat_id = new clsField("tipo_mejora_cat_id", ccsInteger, "");
        
        $this->tipo_mejora_conserva_id = new clsField("tipo_mejora_conserva_id", ccsInteger, "");
        
        $this->mejora_coeficiente_anio = new clsField("mejora_coeficiente_anio", ccsInteger, "");
        
        $this->mejora_coeficiente_valor = new clsField("mejora_coeficiente_valor", ccsFloat, "");
        

        $this->InsertFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_conserva_id"] = array("Name" => "tipo_mejora_conserva_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_coeficiente_anio"] = array("Name" => "mejora_coeficiente_anio", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["mejora_coeficiente_valor"] = array("Name" => "mejora_coeficiente_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_cat_id"] = array("Name" => "tipo_mejora_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_conserva_id"] = array("Name" => "tipo_mejora_conserva_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_coeficiente_anio"] = array("Name" => "mejora_coeficiente_anio", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["mejora_coeficiente_valor"] = array("Name" => "mejora_coeficiente_valor", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @23-55429625
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlmejora_coeficiente_id", ccsInteger, "", "", $this->Parameters["urlmejora_coeficiente_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mejora_coeficiente_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @23-7B0D2C36
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM mejoras_coeficientes {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @23-2C26D21E
    function SetValues()
    {
        $this->tipo_mejora_cat_id->SetDBValue(trim($this->f("tipo_mejora_cat_id")));
        $this->tipo_mejora_conserva_id->SetDBValue(trim($this->f("tipo_mejora_conserva_id")));
        $this->mejora_coeficiente_anio->SetDBValue(trim($this->f("mejora_coeficiente_anio")));
        $this->mejora_coeficiente_valor->SetDBValue(trim($this->f("mejora_coeficiente_valor")));
    }
//End SetValues Method

//Insert Method @23-389353AC
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_mejora_cat_id"]["Value"] = $this->tipo_mejora_cat_id->GetDBValue(true);
        $this->InsertFields["tipo_mejora_conserva_id"]["Value"] = $this->tipo_mejora_conserva_id->GetDBValue(true);
        $this->InsertFields["mejora_coeficiente_anio"]["Value"] = $this->mejora_coeficiente_anio->GetDBValue(true);
        $this->InsertFields["mejora_coeficiente_valor"]["Value"] = $this->mejora_coeficiente_valor->GetDBValue(true);
        $this->SQL = CCBuildInsert("mejoras_coeficientes", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @23-C4A63250
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_mejora_cat_id"]["Value"] = $this->tipo_mejora_cat_id->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_conserva_id"]["Value"] = $this->tipo_mejora_conserva_id->GetDBValue(true);
        $this->UpdateFields["mejora_coeficiente_anio"]["Value"] = $this->mejora_coeficiente_anio->GetDBValue(true);
        $this->UpdateFields["mejora_coeficiente_valor"]["Value"] = $this->mejora_coeficiente_valor->GetDBValue(true);
        $this->SQL = CCBuildUpdate("mejoras_coeficientes", $this->UpdateFields, $this);
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

} //End mejoras_coeficientes1DataSource Class @23-FCB6E20C

class clsGridmejoras_coeficientes { //mejoras_coeficientes class @6-49660C1D

//Variables @6-19698AB3

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
    public $Sorter_mejora_coeficiente_anio;
    public $Sorter_tipo_mejora_cat_id;
    public $Sorter_tipo_mejora_conserva_id;
    public $Sorter_mejora_coeficiente_valor;
//End Variables

//Class_Initialize Event @6-C36AF0D6
    function clsGridmejoras_coeficientes($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras_coeficientes";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras_coeficientes";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejoras_coeficientesDataSource($this);
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
        $this->SorterName = CCGetParam("mejoras_coeficientesOrder", "");
        $this->SorterDirection = CCGetParam("mejoras_coeficientesDir", "");

        $this->mejora_coeficiente_anio = new clsControl(ccsLink, "mejora_coeficiente_anio", "mejora_coeficiente_anio", ccsInteger, "", CCGetRequestParam("mejora_coeficiente_anio", ccsGet, NULL), $this);
        $this->mejora_coeficiente_anio->Page = "mejorasCoeficientes.php";
        $this->tipo_mejora_cat_descript = new clsControl(ccsLabel, "tipo_mejora_cat_descript", "tipo_mejora_cat_descript", ccsText, "", CCGetRequestParam("tipo_mejora_cat_descript", ccsGet, NULL), $this);
        $this->tipo_mejora_conserva_descrip = new clsControl(ccsLabel, "tipo_mejora_conserva_descrip", "tipo_mejora_conserva_descrip", ccsText, "", CCGetRequestParam("tipo_mejora_conserva_descrip", ccsGet, NULL), $this);
        $this->mejora_coeficiente_valor = new clsControl(ccsLabel, "mejora_coeficiente_valor", "mejora_coeficiente_valor", ccsFloat, "", CCGetRequestParam("mejora_coeficiente_valor", ccsGet, NULL), $this);
        $this->Sorter_mejora_coeficiente_anio = new clsSorter($this->ComponentName, "Sorter_mejora_coeficiente_anio", $FileName, $this);
        $this->Sorter_tipo_mejora_cat_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_cat_id", $FileName, $this);
        $this->Sorter_tipo_mejora_conserva_id = new clsSorter($this->ComponentName, "Sorter_tipo_mejora_conserva_id", $FileName, $this);
        $this->Sorter_mejora_coeficiente_valor = new clsSorter($this->ComponentName, "Sorter_mejora_coeficiente_valor", $FileName, $this);
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

//Show Method @6-11961909
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
            $this->ControlsVisible["mejora_coeficiente_anio"] = $this->mejora_coeficiente_anio->Visible;
            $this->ControlsVisible["tipo_mejora_cat_descript"] = $this->tipo_mejora_cat_descript->Visible;
            $this->ControlsVisible["tipo_mejora_conserva_descrip"] = $this->tipo_mejora_conserva_descrip->Visible;
            $this->ControlsVisible["mejora_coeficiente_valor"] = $this->mejora_coeficiente_valor->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->mejora_coeficiente_anio->SetValue($this->DataSource->mejora_coeficiente_anio->GetValue());
                $this->mejora_coeficiente_anio->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->mejora_coeficiente_anio->Parameters = CCAddParam($this->mejora_coeficiente_anio->Parameters, "mejora_coeficiente_id", $this->DataSource->f("mejora_coeficiente_id"));
                $this->tipo_mejora_cat_descript->SetValue($this->DataSource->tipo_mejora_cat_descript->GetValue());
                $this->tipo_mejora_conserva_descrip->SetValue($this->DataSource->tipo_mejora_conserva_descrip->GetValue());
                $this->mejora_coeficiente_valor->SetValue($this->DataSource->mejora_coeficiente_valor->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mejora_coeficiente_anio->Show();
                $this->tipo_mejora_cat_descript->Show();
                $this->tipo_mejora_conserva_descrip->Show();
                $this->mejora_coeficiente_valor->Show();
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
        $this->Sorter_mejora_coeficiente_anio->Show();
        $this->Sorter_tipo_mejora_cat_id->Show();
        $this->Sorter_tipo_mejora_conserva_id->Show();
        $this->Sorter_mejora_coeficiente_valor->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-312C7062
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mejora_coeficiente_anio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_cat_descript->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_conserva_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_coeficiente_valor->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras_coeficientes Class @6-FCB6E20C

class clsmejoras_coeficientesDataSource extends clsDBtdf_nuevo {  //mejoras_coeficientesDataSource Class @6-64DFB37F

//DataSource Variables @6-F8CA3457
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mejora_coeficiente_anio;
    public $tipo_mejora_cat_descript;
    public $tipo_mejora_conserva_descrip;
    public $mejora_coeficiente_valor;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-25B5DADC
    function clsmejoras_coeficientesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras_coeficientes";
        $this->Initialize();
        $this->mejora_coeficiente_anio = new clsField("mejora_coeficiente_anio", ccsInteger, "");
        
        $this->tipo_mejora_cat_descript = new clsField("tipo_mejora_cat_descript", ccsText, "");
        
        $this->tipo_mejora_conserva_descrip = new clsField("tipo_mejora_conserva_descrip", ccsText, "");
        
        $this->mejora_coeficiente_valor = new clsField("mejora_coeficiente_valor", ccsFloat, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-CFCBF0F2
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "mejoras_coeficientes.mejora_coeficiente_anio desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_mejora_coeficiente_anio" => array("mejora_coeficiente_anio", ""), 
            "Sorter_tipo_mejora_cat_id" => array("tipo_mejora_cat_descript", ""), 
            "Sorter_tipo_mejora_conserva_id" => array("tipo_mejora_conserva_descrip", ""), 
            "Sorter_mejora_coeficiente_valor" => array("mejora_coeficiente_valor", "")));
    }
//End SetOrder Method

//Prepare Method @6-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @6-21C74499
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (mejoras_coeficientes INNER JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras_coeficientes.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) INNER JOIN tipos_mejoras_conserva ON\n\n" .
        "mejoras_coeficientes.tipo_mejora_conserva_id = tipos_mejoras_conserva.tipo_mejora_conserva_id";
        $this->SQL = "SELECT mejora_coeficiente_anio, mejora_coeficiente_valor, tipo_mejora_conserva_descrip, tipo_mejora_cat_descript, mejora_coeficiente_id \n\n" .
        "FROM (mejoras_coeficientes INNER JOIN tipos_mejoras_cat ON\n\n" .
        "mejoras_coeficientes.tipo_mejora_cat_id = tipos_mejoras_cat.tipo_mejora_cat_id) INNER JOIN tipos_mejoras_conserva ON\n\n" .
        "mejoras_coeficientes.tipo_mejora_conserva_id = tipos_mejoras_conserva.tipo_mejora_conserva_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-64A9B6C8
    function SetValues()
    {
        $this->mejora_coeficiente_anio->SetDBValue(trim($this->f("mejora_coeficiente_anio")));
        $this->tipo_mejora_cat_descript->SetDBValue($this->f("tipo_mejora_cat_descript"));
        $this->tipo_mejora_conserva_descrip->SetDBValue($this->f("tipo_mejora_conserva_descrip"));
        $this->mejora_coeficiente_valor->SetDBValue(trim($this->f("mejora_coeficiente_valor")));
    }
//End SetValues Method

} //End mejoras_coeficientesDataSource Class @6-FCB6E20C

//Initialize Page @1-3C3F0874
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
$TemplateFileName = "mejorasCoeficientes.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-8439BB5A
include_once("./mejorasCoeficientes_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-B44B90D2
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$mejoras_coeficientes1 = new clsRecordmejoras_coeficientes1("", $MainPage);
$mejoras_coeficientes = new clsGridmejoras_coeficientes("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->mejoras_coeficientes1 = & $mejoras_coeficientes1;
$MainPage->mejoras_coeficientes = & $mejoras_coeficientes;
$mejoras_coeficientes1->Initialize();
$mejoras_coeficientes->Initialize();

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

//Execute Components @1-41CB79F1
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$mejoras_coeficientes1->Operation();
//End Execute Components

//Go to destination page @1-8B80A073
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
    unset($mejoras_coeficientes1);
    unset($mejoras_coeficientes);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-95233201
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$mejoras_coeficientes1->Show();
$mejoras_coeficientes->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.o;501#&;001#&ut;38#&>-- SCC --!< egra;401#&;76#&;101#&;001#&oC>-- CCS --!< ;401#&;611#&;501#&;911#&>-- CCS --!< d;101#&t;79#&;411#&e;011#&eG>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.o;501#&;001#&ut;38#&>-- SCC --!< egra;401#&;76#&;101#&;001#&oC>-- CCS --!< ;401#&;611#&;501#&;911#&>-- CCS --!< d;101#&t;79#&;411#&e;011#&eG>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.o;501#&;001#&ut;38#&>-- SCC --!< egra;401#&;76#&;101#&;001#&oC>-- CCS --!< ;401#&;611#&;501#&;911#&>-- CCS --!< d;101#&t;79#&;411#&e;011#&eG>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-CF7325D3
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($mejoras_coeficientes1);
unset($mejoras_coeficientes);
unset($Tpl);
//End Unload Page


?>
