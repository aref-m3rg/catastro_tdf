<?php
//Include Common Files @1-245762C1
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "recordUnidades.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @12-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @13-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @14-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordunidades { //unidades Class @2-284A8035

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

//Class_Initialize Event @2-54918859
    function clsRecordunidades($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record unidades/Error";
        $this->DataSource = new clsunidadesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "unidades";
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
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->jerarquia_id = new clsControl(ccsListBox, "jerarquia_id", "Jerarquia Id", ccsInteger, "", CCGetRequestParam("jerarquia_id", $Method, NULL), $this);
            $this->jerarquia_id->DSType = dsTable;
            $this->jerarquia_id->DataSource = new clsDBunidades();
            $this->jerarquia_id->ds = & $this->jerarquia_id->DataSource;
            $this->jerarquia_id->DataSource->SQL = "SELECT * \n" .
"FROM jeraquias {SQL_Where} {SQL_OrderBy}";
            list($this->jerarquia_id->BoundColumn, $this->jerarquia_id->TextColumn, $this->jerarquia_id->DBFormat) = array("jerarquia_id", "jerarquia_desc", "");
            $this->estado_id = new clsControl(ccsRadioButton, "estado_id", "Estado Id", ccsInteger, "", CCGetRequestParam("estado_id", $Method, NULL), $this);
            $this->estado_id->DSType = dsTable;
            $this->estado_id->DataSource = new clsDBunidades();
            $this->estado_id->ds = & $this->estado_id->DataSource;
            $this->estado_id->DataSource->SQL = "SELECT * \n" .
"FROM estados {SQL_Where} {SQL_OrderBy}";
            list($this->estado_id->BoundColumn, $this->estado_id->TextColumn, $this->estado_id->DBFormat) = array("estado_id", "estado_desc", "");
            $this->estado_id->HTML = true;
            $this->entorno_id = new clsControl(ccsRadioButton, "entorno_id", "Entorno Id", ccsInteger, "", CCGetRequestParam("entorno_id", $Method, NULL), $this);
            $this->entorno_id->DSType = dsTable;
            $this->entorno_id->DataSource = new clsDBunidades();
            $this->entorno_id->ds = & $this->entorno_id->DataSource;
            $this->entorno_id->DataSource->SQL = "SELECT * \n" .
"FROM entornos {SQL_Where} {SQL_OrderBy}";
            list($this->entorno_id->BoundColumn, $this->entorno_id->TextColumn, $this->entorno_id->DBFormat) = array("entorno_id", "entorno_desc", "");
            $this->entorno_id->HTML = true;
            $this->unidad_nombre = new clsControl(ccsTextBox, "unidad_nombre", "unidad_nombre", ccsText, "", CCGetRequestParam("unidad_nombre", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-A296254D
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlunidad_id"] = CCGetFromGet("unidad_id", NULL);
    }
//End Initialize Method

//Validate Method @2-B605BEA8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->jerarquia_id->Validate() && $Validation);
        $Validation = ($this->estado_id->Validate() && $Validation);
        $Validation = ($this->entorno_id->Validate() && $Validation);
        $Validation = ($this->unidad_nombre->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->jerarquia_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->entorno_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidad_nombre->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-AA72BA2C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->jerarquia_id->Errors->Count());
        $errors = ($errors || $this->estado_id->Errors->Count());
        $errors = ($errors || $this->entorno_id->Errors->Count());
        $errors = ($errors || $this->unidad_nombre->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
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

//Operation Method @2-ADECEE39
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
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "unidad_id"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "gridUnidades.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "unidad_id", "unidad_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
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

//InsertRow Method @2-00A28A6D
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->jerarquia_id->SetValue($this->jerarquia_id->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
        $this->DataSource->entorno_id->SetValue($this->entorno_id->GetValue(true));
        $this->DataSource->unidad_nombre->SetValue($this->unidad_nombre->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-AA3DBF4F
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->jerarquia_id->SetValue($this->jerarquia_id->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
        $this->DataSource->entorno_id->SetValue($this->entorno_id->GetValue(true));
        $this->DataSource->unidad_nombre->SetValue($this->unidad_nombre->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-F039A249
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

        $this->jerarquia_id->Prepare();
        $this->estado_id->Prepare();
        $this->entorno_id->Prepare();

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
                    $this->jerarquia_id->SetValue($this->DataSource->jerarquia_id->GetValue());
                    $this->estado_id->SetValue($this->DataSource->estado_id->GetValue());
                    $this->entorno_id->SetValue($this->DataSource->entorno_id->GetValue());
                    $this->unidad_nombre->SetValue($this->DataSource->unidad_nombre->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->jerarquia_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->entorno_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidad_nombre->Errors->ToString());
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
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->jerarquia_id->Show();
        $this->estado_id->Show();
        $this->entorno_id->Show();
        $this->unidad_nombre->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End unidades Class @2-FCB6E20C

class clsunidadesDataSource extends clsDBunidades {  //unidadesDataSource Class @2-45ECF98A

//DataSource Variables @2-74E06183
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
    public $jerarquia_id;
    public $estado_id;
    public $entorno_id;
    public $unidad_nombre;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-E223A218
    function clsunidadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record unidades/Error";
        $this->Initialize();
        $this->jerarquia_id = new clsField("jerarquia_id", ccsInteger, "");
        
        $this->estado_id = new clsField("estado_id", ccsInteger, "");
        
        $this->entorno_id = new clsField("entorno_id", ccsInteger, "");
        
        $this->unidad_nombre = new clsField("unidad_nombre", ccsText, "");
        

        $this->InsertFields["jerarquia_id"] = array("Name" => "jerarquia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["entorno_id"] = array("Name" => "entorno_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["unidad_nombre"] = array("Name" => "unidad_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["jerarquia_id"] = array("Name" => "jerarquia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["entorno_id"] = array("Name" => "entorno_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_nombre"] = array("Name" => "unidad_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-309858EF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlunidad_id", ccsInteger, "", "", $this->Parameters["urlunidad_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "unidad_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-2D44DB3E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM unidades {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-20DE5F35
    function SetValues()
    {
        $this->jerarquia_id->SetDBValue(trim($this->f("jerarquia_id")));
        $this->estado_id->SetDBValue(trim($this->f("estado_id")));
        $this->entorno_id->SetDBValue(trim($this->f("entorno_id")));
        $this->unidad_nombre->SetDBValue($this->f("unidad_nombre"));
    }
//End SetValues Method

//Insert Method @2-E1BBA0DE
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["jerarquia_id"]["Value"] = $this->jerarquia_id->GetDBValue(true);
        $this->InsertFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->InsertFields["entorno_id"]["Value"] = $this->entorno_id->GetDBValue(true);
        $this->InsertFields["unidad_nombre"]["Value"] = $this->unidad_nombre->GetDBValue(true);
        $this->SQL = CCBuildInsert("unidades", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-1C4DE28D
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["jerarquia_id"]["Value"] = $this->jerarquia_id->GetDBValue(true);
        $this->UpdateFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->UpdateFields["entorno_id"]["Value"] = $this->entorno_id->GetDBValue(true);
        $this->UpdateFields["unidad_nombre"]["Value"] = $this->unidad_nombre->GetDBValue(true);
        $this->SQL = CCBuildUpdate("unidades", $this->UpdateFields, $this);
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

} //End unidadesDataSource Class @2-FCB6E20C

class clsEditableGridunidades_param { //unidades_param Class @16-525AAEF7

//Variables @16-431A9010

    // Public variables
    public $ComponentType = "EditableGrid";
    public $ComponentName;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormParameters;
    public $FormState;
    public $FormEnctype;
    public $CachedColumns;
    public $TotalRows;
    public $UpdatedRows;
    public $EmptyRows;
    public $Visible;
    public $RowsErrors;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode;
    public $ValidatingControls;
    public $Controls;
    public $ControlsErrors;
    public $RowNumber;
    public $Attributes;
    public $PrimaryKeys;

    // Class variables
    public $Sorter_unidad_p_f_vig;
    public $Sorter_unidad_p_responsable;
    public $Sorter_dep_unidad_id;
//End Variables

//Class_Initialize Event @16-1CAE8FDA
    function clsEditableGridunidades_param($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid unidades_param/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "unidades_param";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["unidad_p_id"][0] = "unidad_p_id";
        $this->DataSource = new clsunidades_paramDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 1;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if(!$this->Visible) return;

        $CCSForm = CCGetFromGet("ccsForm", "");
        $this->FormEnctype = "application/x-www-form-urlencoded";
        $this->FormSubmitted = ($CCSForm == $this->ComponentName);
        if($this->FormSubmitted) {
            $this->FormState = CCGetFromPost("FormState", "");
            $this->SetFormState($this->FormState);
        } else {
            $this->FormState = "";
        }
        $Method = $this->FormSubmitted ? ccsPost : ccsGet;

        $this->SorterName = CCGetParam("unidades_paramOrder", "");
        $this->SorterDirection = CCGetParam("unidades_paramDir", "");

        $this->unidades_param_TotalRecords = new clsControl(ccsLabel, "unidades_param_TotalRecords", "unidades_param_TotalRecords", ccsText, "", NULL, $this);
        $this->Sorter_unidad_p_f_vig = new clsSorter($this->ComponentName, "Sorter_unidad_p_f_vig", $FileName, $this);
        $this->Sorter_unidad_p_responsable = new clsSorter($this->ComponentName, "Sorter_unidad_p_responsable", $FileName, $this);
        $this->Sorter_dep_unidad_id = new clsSorter($this->ComponentName, "Sorter_dep_unidad_id", $FileName, $this);
        $this->unidad_p_f_vig = new clsControl(ccsTextBox, "unidad_p_f_vig", "F. Vigencia", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->unidad_p_f_vig->Required = true;
        $this->DatePicker_unidad_p_f_vig = new clsDatePicker("DatePicker_unidad_p_f_vig", "unidades_param", "unidad_p_f_vig", $this);
        $this->unidad_p_responsable = new clsControl(ccsTextBox, "unidad_p_responsable", "Referente", ccsText, "", NULL, $this);
        $this->unidad_p_responsable->Required = true;
        $this->dep_unidad_id = new clsControl(ccsListBox, "dep_unidad_id", "Dep Unidad Id", ccsInteger, "", NULL, $this);
        $this->dep_unidad_id->DSType = dsTable;
        $this->dep_unidad_id->DataSource = new clsDBunidades();
        $this->dep_unidad_id->ds = & $this->dep_unidad_id->DataSource;
        $this->dep_unidad_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades {SQL_Where} {SQL_OrderBy}";
        $this->dep_unidad_id->DataSource->Order = "unidad_nombre";
        list($this->dep_unidad_id->BoundColumn, $this->dep_unidad_id->TextColumn, $this->dep_unidad_id->DBFormat) = array("unidad_id", "unidad_nombre", "");
        $this->dep_unidad_id->DataSource->Order = "unidad_nombre";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->delete = new clsControl(ccsCheckBox, "delete", "delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->delete->CheckedValue = true;
        $this->delete->UncheckedValue = false;
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsBoolean, array("Activo", "", ""), NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @16-8B0773BC
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlunidad_id"] = CCGetFromGet("unidad_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @16-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @16-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @16-0B0F6412
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["unidad_p_f_vig"][$RowNumber] = CCGetFromPost("unidad_p_f_vig_" . $RowNumber, NULL);
            $this->FormParameters["unidad_p_responsable"][$RowNumber] = CCGetFromPost("unidad_p_responsable_" . $RowNumber, NULL);
            $this->FormParameters["dep_unidad_id"][$RowNumber] = CCGetFromPost("dep_unidad_id_" . $RowNumber, NULL);
            $this->FormParameters["delete"][$RowNumber] = CCGetFromPost("delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @16-C6D143E8
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["unidad_p_id"] = $this->CachedColumns["unidad_p_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->unidad_p_f_vig->SetText($this->FormParameters["unidad_p_f_vig"][$this->RowNumber], $this->RowNumber);
            $this->unidad_p_responsable->SetText($this->FormParameters["unidad_p_responsable"][$this->RowNumber], $this->RowNumber);
            $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
            $this->delete->SetText($this->FormParameters["delete"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if(!$this->delete->Value)
                    $Validation = ($this->ValidateRow() && $Validation);
            }
            else if($this->CheckInsert())
            {
                $Validation = ($this->ValidateRow() && $Validation);
            }
        }
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//ValidateRow Method @16-EEC64696
    function ValidateRow()
    {
        global $CCSLocales;
        $this->unidad_p_f_vig->Validate();
        $this->unidad_p_responsable->Validate();
        $this->dep_unidad_id->Validate();
        $this->delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->unidad_p_f_vig->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_responsable->Errors->ToString());
        $errors = ComposeStrings($errors, $this->dep_unidad_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->delete->Errors->ToString());
        $this->unidad_p_f_vig->Errors->Clear();
        $this->unidad_p_responsable->Errors->Clear();
        $this->dep_unidad_id->Errors->Clear();
        $this->delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @16-C64F6271
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["unidad_p_f_vig"][$this->RowNumber]) && count($this->FormParameters["unidad_p_f_vig"][$this->RowNumber])) || strlen($this->FormParameters["unidad_p_f_vig"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["unidad_p_responsable"][$this->RowNumber]) && count($this->FormParameters["unidad_p_responsable"][$this->RowNumber])) || strlen($this->FormParameters["unidad_p_responsable"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["dep_unidad_id"][$this->RowNumber]) && count($this->FormParameters["dep_unidad_id"][$this->RowNumber])) || strlen($this->FormParameters["dep_unidad_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @16-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @16-909F269B
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted)
            return;

        $this->GetFormParameters();
        $this->PressedButton = "Button_Submit";
        if($this->Button_Submit->Pressed) {
            $this->PressedButton = "Button_Submit";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @16-3024F1A9
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["unidad_p_id"] = $this->CachedColumns["unidad_p_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->unidad_p_f_vig->SetText($this->FormParameters["unidad_p_f_vig"][$this->RowNumber], $this->RowNumber);
            $this->unidad_p_responsable->SetText($this->FormParameters["unidad_p_responsable"][$this->RowNumber], $this->RowNumber);
            $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
            $this->delete->SetText($this->FormParameters["delete"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if($this->delete->Value) {
                    if($this->DeleteAllowed) { $Validation = ($this->DeleteRow() && $Validation); }
                } else if($this->UpdateAllowed) {
                    $Validation = ($this->UpdateRow() && $Validation);
                }
            }
            else if($this->CheckInsert() && $this->InsertAllowed)
            {
                $Validation = ($Validation && $this->InsertRow());
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterSubmit", $this);
        if ($this->Errors->Count() == 0 && $Validation){
            $this->DataSource->close();
            return true;
        }
        return false;
    }
//End UpdateGrid Method

//InsertRow Method @16-739A0AFB
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->unidad_p_f_vig->SetValue($this->unidad_p_f_vig->GetValue(true));
        $this->DataSource->unidad_p_responsable->SetValue($this->unidad_p_responsable->GetValue(true));
        $this->DataSource->dep_unidad_id->SetValue($this->dep_unidad_id->GetValue(true));
        $this->DataSource->Insert();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End InsertRow Method

//UpdateRow Method @16-091CE06D
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->unidad_p_f_vig->SetValue($this->unidad_p_f_vig->GetValue(true));
        $this->DataSource->unidad_p_responsable->SetValue($this->unidad_p_responsable->GetValue(true));
        $this->DataSource->dep_unidad_id->SetValue($this->dep_unidad_id->GetValue(true));
        $this->DataSource->delete->SetValue($this->delete->GetValue(true));
        $this->DataSource->Label1->SetValue($this->Label1->GetValue(true));
        $this->DataSource->Update();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End UpdateRow Method

//DeleteRow Method @16-A4A656F6
    function DeleteRow()
    {
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End DeleteRow Method

//FormScript Method @16-FB8039BA
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var unidades_paramElements;\n";
        $script .= "var unidades_paramEmptyRows = 1;\n";
        $script .= "var " . $this->ComponentName . "unidad_p_f_vigID = 0;\n";
        $script .= "var " . $this->ComponentName . "unidad_p_responsableID = 1;\n";
        $script .= "var " . $this->ComponentName . "dep_unidad_idID = 2;\n";
        $script .= "var " . $this->ComponentName . "DeleteControl = 3;\n";
        $script .= "\nfunction initunidades_paramElements() {\n";
        $script .= "\tvar ED = document.forms[\"unidades_param\"];\n";
        $script .= "\tunidades_paramElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.unidad_p_f_vig_" . $i . ", " . "ED.unidad_p_responsable_" . $i . ", " . "ED.dep_unidad_id_" . $i . ", " . "ED.delete_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @16-D041996E
    function SetFormState($FormState)
    {
        if(strlen($FormState)) {
            $FormState = str_replace("\\\\", "\\" . ord("\\"), $FormState);
            $FormState = str_replace("\\;", "\\" . ord(";"), $FormState);
            $pieces = explode(";", $FormState);
            $this->UpdatedRows = $pieces[0];
            $this->EmptyRows   = $pieces[1];
            $this->TotalRows = $this->UpdatedRows + $this->EmptyRows;
            $RowNumber = 0;
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["unidad_p_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["unidad_p_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @16-EAC10879
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["unidad_p_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @16-DDA0493E
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->dep_unidad_id->Prepare();

        $this->DataSource->open();
        $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
        $this->IsEmpty = ! $is_next_record;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->Attributes->Show();
        $this->Button_Submit->Visible = $this->Button_Submit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $this->RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $this->ControlsVisible["unidad_p_f_vig"] = $this->unidad_p_f_vig->Visible;
        $this->ControlsVisible["DatePicker_unidad_p_f_vig"] = $this->DatePicker_unidad_p_f_vig->Visible;
        $this->ControlsVisible["unidad_p_responsable"] = $this->unidad_p_responsable->Visible;
        $this->ControlsVisible["dep_unidad_id"] = $this->dep_unidad_id->Visible;
        $this->ControlsVisible["delete"] = $this->delete->Visible;
        $this->ControlsVisible["Label1"] = $this->Label1->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                // Parse Separator
                if($this->RowNumber) {
                    $Tpl->block_path = $EditableGridPath;
                    $this->Attributes->Show();
                    $Tpl->parseto("Separator", true, "Row");
                    $Tpl->block_path = $EditableGridRowPath;
                }
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($is_next_record) || !($this->DeleteAllowed)) {
                    $this->delete->Visible = false;
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidad_p_id"];
                    $this->delete->SetValue("");
                    $this->unidad_p_f_vig->SetValue($this->DataSource->unidad_p_f_vig->GetValue());
                    $this->unidad_p_responsable->SetValue($this->DataSource->unidad_p_responsable->GetValue());
                    $this->dep_unidad_id->SetValue($this->DataSource->dep_unidad_id->GetValue());
                    $this->Label1->SetValue($this->DataSource->Label1->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->Label1->SetText("");
                    $this->Label1->SetValue($this->DataSource->Label1->GetValue());
                    $this->unidad_p_f_vig->SetText($this->FormParameters["unidad_p_f_vig"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_p_responsable->SetText($this->FormParameters["unidad_p_responsable"][$this->RowNumber], $this->RowNumber);
                    $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
                    $this->delete->SetText($this->FormParameters["delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = "";
                    $this->unidad_p_f_vig->SetText("");
                    $this->unidad_p_responsable->SetText("");
                    $this->dep_unidad_id->SetText("");
                    $this->delete->SetValue("");
                    $this->Label1->SetText("");
                } else {
                    $this->Label1->SetText("");
                    $this->unidad_p_f_vig->SetText($this->FormParameters["unidad_p_f_vig"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_p_responsable->SetText($this->FormParameters["unidad_p_responsable"][$this->RowNumber], $this->RowNumber);
                    $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
                    $this->delete->SetText($this->FormParameters["delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->unidad_p_f_vig->Show($this->RowNumber);
                $this->DatePicker_unidad_p_f_vig->Show($this->RowNumber);
                $this->unidad_p_responsable->Show($this->RowNumber);
                $this->dep_unidad_id->Show($this->RowNumber);
                $this->delete->Show($this->RowNumber);
                $this->Label1->Show($this->RowNumber);
                if (isset($this->RowsErrors[$this->RowNumber]) && ($this->RowsErrors[$this->RowNumber] != "")) {
                    $Tpl->setblockvar("RowError", "");
                    $Tpl->setvar("Error", $this->RowsErrors[$this->RowNumber]);
                    $this->Attributes->Show();
                    $Tpl->parse("RowError", false);
                } else {
                    $Tpl->setblockvar("RowError", "");
                }
                $Tpl->setvar("FormScript", $this->FormScript($this->RowNumber));
                $Tpl->parse();
                if ($is_next_record) {
                    if ($this->FormSubmitted) {
                        $is_next_record = $this->RowNumber < $this->UpdatedRows;
                        if (($this->DataSource->CachedColumns["unidad_p_id"] == $this->CachedColumns["unidad_p_id"][$this->RowNumber])) {
                            if ($this->ReadAllowed) $this->DataSource->next_record();
                        }
                    }else{
                        $is_next_record = ($this->RowNumber < $this->PageSize) &&  $this->ReadAllowed && $this->DataSource->next_record();
                    }
                } else { 
                    $EmptyRowsLeft--;
                }
            } while($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed));
        } else {
            $Tpl->block_path = $EditableGridPath;
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $Tpl->block_path = $EditableGridPath;
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->unidades_param_TotalRecords->Show();
        $this->Sorter_unidad_p_f_vig->Show();
        $this->Sorter_unidad_p_responsable->Show();
        $this->Sorter_dep_unidad_id->Show();
        $this->Navigator->Show();
        $this->Button_Submit->Show();

        if($this->CheckErrors()) {
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        if (!$CCSUseAmp) {
            $Tpl->SetVar("HTMLFormProperties", "method=\"POST\" action=\"" . $this->HTMLFormAction . "\" name=\"" . $this->ComponentName . "\"");
        } else {
            $Tpl->SetVar("HTMLFormProperties", "method=\"post\" action=\"" . str_replace("&", "&amp;", $this->HTMLFormAction) . "\" id=\"" . $this->ComponentName . "\"");
        }
        $Tpl->SetVar("FormState", CCToHTML($this->GetFormState($NonEmptyRows)));
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End unidades_param Class @16-FCB6E20C

class clsunidades_paramDataSource extends clsDBunidades {  //unidades_paramDataSource Class @16-82CDC3EE

//DataSource Variables @16-9E612593
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $unidad_p_f_vig;
    public $unidad_p_responsable;
    public $dep_unidad_id;
    public $delete;
    public $Label1;
//End DataSource Variables

//DataSourceClass_Initialize Event @16-296C4936
    function clsunidades_paramDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid unidades_param/Error";
        $this->Initialize();
        $this->unidad_p_f_vig = new clsField("unidad_p_f_vig", ccsDate, $this->DateFormat);
        
        $this->unidad_p_responsable = new clsField("unidad_p_responsable", ccsText, "");
        
        $this->dep_unidad_id = new clsField("dep_unidad_id", ccsInteger, "");
        
        $this->delete = new clsField("delete", ccsBoolean, $this->BooleanFormat);
        
        $this->Label1 = new clsField("Label1", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["unidad_p_f_vig"] = array("Name" => "unidad_p_f_vig", "Value" => "", "DataType" => ccsDate);
        $this->InsertFields["unidad_p_responsable"] = array("Name" => "unidad_p_responsable", "Value" => "", "DataType" => ccsText);
        $this->InsertFields["dep_unidad_id"] = array("Name" => "dep_unidad_id", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_p_f_vig"] = array("Name" => "unidad_p_f_vig", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_p_responsable"] = array("Name" => "unidad_p_responsable", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["dep_unidad_id"] = array("Name" => "dep_unidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @16-FC4D36A8
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_unidad_p_f_vig" => array("unidad_p_f_vig", ""), 
            "Sorter_unidad_p_responsable" => array("unidad_p_responsable", ""), 
            "Sorter_dep_unidad_id" => array("dep_unidad_id", "")));
    }
//End SetOrder Method

//Prepare Method @16-309858EF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlunidad_id", ccsInteger, "", "", $this->Parameters["urlunidad_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "unidad_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @16-13B621D0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM unidades_param";
        $this->SQL = "SELECT * \n\n" .
        "FROM unidades_param {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @16-817263DB
    function SetValues()
    {
        $this->CachedColumns["unidad_p_id"] = $this->f("unidad_p_id");
        $this->unidad_p_f_vig->SetDBValue(trim($this->f("unidad_p_f_vig")));
        $this->unidad_p_responsable->SetDBValue($this->f("unidad_p_responsable"));
        $this->dep_unidad_id->SetDBValue(trim($this->f("dep_unidad_id")));
        $this->Label1->SetDBValue(trim($this->f("unidad_p_activo")));
    }
//End SetValues Method

//Insert Method @16-38B4DE70
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["unidad_p_f_vig"] = new clsSQLParameter("ctrlunidad_p_f_vig", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->unidad_p_f_vig->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["unidad_p_responsable"] = new clsSQLParameter("ctrlunidad_p_responsable", ccsText, "", "", $this->unidad_p_responsable->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["dep_unidad_id"] = new clsSQLParameter("ctrldep_unidad_id", ccsInteger, "", "", $this->dep_unidad_id->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["unidad_id"] = new clsSQLParameter("urlunidad_id", ccsInteger, "", "", CCGetFromGet("unidad_id", NULL), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["unidad_p_f_vig"]->GetValue()) and !strlen($this->cp["unidad_p_f_vig"]->GetText()) and !is_bool($this->cp["unidad_p_f_vig"]->GetValue())) 
            $this->cp["unidad_p_f_vig"]->SetValue($this->unidad_p_f_vig->GetValue(true));
        if (!is_null($this->cp["unidad_p_responsable"]->GetValue()) and !strlen($this->cp["unidad_p_responsable"]->GetText()) and !is_bool($this->cp["unidad_p_responsable"]->GetValue())) 
            $this->cp["unidad_p_responsable"]->SetValue($this->unidad_p_responsable->GetValue(true));
        if (!is_null($this->cp["dep_unidad_id"]->GetValue()) and !strlen($this->cp["dep_unidad_id"]->GetText()) and !is_bool($this->cp["dep_unidad_id"]->GetValue())) 
            $this->cp["dep_unidad_id"]->SetValue($this->dep_unidad_id->GetValue(true));
        if (!is_null($this->cp["unidad_id"]->GetValue()) and !strlen($this->cp["unidad_id"]->GetText()) and !is_bool($this->cp["unidad_id"]->GetValue())) 
            $this->cp["unidad_id"]->SetText(CCGetFromGet("unidad_id", NULL));
        $this->InsertFields["unidad_p_f_vig"]["Value"] = $this->cp["unidad_p_f_vig"]->GetDBValue(true);
        $this->InsertFields["unidad_p_responsable"]["Value"] = $this->cp["unidad_p_responsable"]->GetDBValue(true);
        $this->InsertFields["dep_unidad_id"]["Value"] = $this->cp["dep_unidad_id"]->GetDBValue(true);
        $this->InsertFields["unidad_id"]["Value"] = $this->cp["unidad_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("unidades_param", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @16-CA149E44
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "unidad_p_id=" . $this->ToSQL($this->CachedColumns["unidad_p_id"], ccsInteger);
        $this->UpdateFields["unidad_p_f_vig"]["Value"] = $this->unidad_p_f_vig->GetDBValue(true);
        $this->UpdateFields["unidad_p_responsable"]["Value"] = $this->unidad_p_responsable->GetDBValue(true);
        $this->UpdateFields["dep_unidad_id"]["Value"] = $this->dep_unidad_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("unidades_param", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Update Method

//Delete Method @16-DEE99F93
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "unidad_p_id=" . $this->ToSQL($this->CachedColumns["unidad_p_id"], ccsInteger);
        $this->SQL = "DELETE FROM unidades_param";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Delete Method

} //End unidades_paramDataSource Class @16-FCB6E20C

//Initialize Page @1-41D1FD67
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
$TemplateFileName = "recordUnidades.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-7A6B20AE
include_once("./recordUnidades_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-B2DE9820
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
$unidades = new clsRecordunidades("", $MainPage);
$unidades_param = new clsEditableGridunidades_param("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->unidades = & $unidades;
$MainPage->unidades_param = & $unidades_param;
$unidades->Initialize();
$unidades_param->Initialize();

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

//Execute Components @1-0004CD6C
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$unidades->Operation();
$unidades_param->Operation();
//End Execute Components

//Go to destination page @1-26643DDF
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
    unset($unidades);
    unset($unidades_param);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-CBD23BD5
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$unidades->Show();
$unidades_param->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#" . "101;&#110;&#101;&#114;&#97;ted <!--" . " SCC -->wi&#116;h <!-- CCS -->C&#111" . ";d&#101;C&#104;arg&#101; <!-- CCS -" . "->&#83;tu&#100;i&#111;.</small></fo" . "nt></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#" . "101;&#110;&#101;&#114;&#97;ted <!--" . " SCC -->wi&#116;h <!-- CCS -->C&#111" . ";d&#101;C&#104;arg&#101; <!-- CCS -" . "->&#83;tu&#100;i&#111;.</small></fo" . "nt></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>G&#" . "101;&#110;&#101;&#114;&#97;ted <!--" . " SCC -->wi&#116;h <!-- CCS -->C&#111" . ";d&#101;C&#104;arg&#101; <!-- CCS -" . "->&#83;tu&#100;i&#111;.</small></fo" . "nt></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-EF53B210
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBunidades->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($unidades);
unset($unidades_param);
unset($Tpl);
//End Unload Page


?>
