<?php
//Include Common Files @1-F471DBA0
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_unidadesRecord.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @4-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @5-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordunidades { //unidades Class @6-284A8035

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

//Class_Initialize Event @6-1E41F1B1
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
        $this->DeleteAllowed = true;
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
            $this->unidad_nombre = new clsControl(ccsTextBox, "unidad_nombre", "Nombre", ccsText, "", CCGetRequestParam("unidad_nombre", $Method, NULL), $this);
            $this->unidad_nombre->Required = true;
            $this->jerarquia_id = new clsControl(ccsListBox, "jerarquia_id", "Jerarquía", ccsInteger, "", CCGetRequestParam("jerarquia_id", $Method, NULL), $this);
            $this->jerarquia_id->DSType = dsTable;
            $this->jerarquia_id->DataSource = new clsDBmesa();
            $this->jerarquia_id->ds = & $this->jerarquia_id->DataSource;
            $this->jerarquia_id->DataSource->SQL = "SELECT * \n" .
"FROM jeraquias {SQL_Where} {SQL_OrderBy}";
            list($this->jerarquia_id->BoundColumn, $this->jerarquia_id->TextColumn, $this->jerarquia_id->DBFormat) = array("jerarquia_id", "jerarquia_desc", "");
            $this->jerarquia_id->Required = true;
            $this->estado_id = new clsControl(ccsListBox, "estado_id", "Estado", ccsInteger, "", CCGetRequestParam("estado_id", $Method, NULL), $this);
            $this->estado_id->DSType = dsTable;
            $this->estado_id->DataSource = new clsDBmesa();
            $this->estado_id->ds = & $this->estado_id->DataSource;
            $this->estado_id->DataSource->SQL = "SELECT * \n" .
"FROM estados {SQL_Where} {SQL_OrderBy}";
            list($this->estado_id->BoundColumn, $this->estado_id->TextColumn, $this->estado_id->DBFormat) = array("estado_id", "estado_desc", "");
            $this->estado_id->Required = true;
            $this->entorno_id = new clsControl(ccsListBox, "entorno_id", "Entorno", ccsInteger, "", CCGetRequestParam("entorno_id", $Method, NULL), $this);
            $this->entorno_id->DSType = dsTable;
            $this->entorno_id->DataSource = new clsDBmesa();
            $this->entorno_id->ds = & $this->entorno_id->DataSource;
            $this->entorno_id->DataSource->SQL = "SELECT * \n" .
"FROM entornos {SQL_Where} {SQL_OrderBy}";
            list($this->entorno_id->BoundColumn, $this->entorno_id->TextColumn, $this->entorno_id->DBFormat) = array("entorno_id", "entorno_desc", "");
            $this->entorno_id->Required = true;
            $this->unidad_pase_externo = new clsControl(ccsListBox, "unidad_pase_externo", "Pase externo", ccsInteger, "", CCGetRequestParam("unidad_pase_externo", $Method, NULL), $this);
            $this->unidad_pase_externo->DSType = dsListOfValues;
            $this->unidad_pase_externo->Values = array(array("1", "Sí"), array("2", "No"));
            $this->unidad_pase_externo->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @6-A296254D
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlunidad_id"] = CCGetFromGet("unidad_id", NULL);
    }
//End Initialize Method

//Validate Method @6-F58441FE
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->unidad_nombre->SetValue($this->unidad_nombre->GetValue());
        if(CCDLookUp("COUNT(*)", "unidades", "unidad_nombre=" . $this->DataSource->ToSQL($this->DataSource->unidad_nombre->GetDBValue(), $this->DataSource->unidad_nombre->DataType) . $Where, $this->DataSource) > 0)
            $this->unidad_nombre->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Nombre"));
        $Validation = ($this->unidad_nombre->Validate() && $Validation);
        $Validation = ($this->jerarquia_id->Validate() && $Validation);
        $Validation = ($this->estado_id->Validate() && $Validation);
        $Validation = ($this->entorno_id->Validate() && $Validation);
        $Validation = ($this->unidad_pase_externo->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->unidad_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->jerarquia_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->entorno_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidad_pase_externo->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-ADB94AD5
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->unidad_nombre->Errors->Count());
        $errors = ($errors || $this->jerarquia_id->Errors->Count());
        $errors = ($errors || $this->estado_id->Errors->Count());
        $errors = ($errors || $this->entorno_id->Errors->Count());
        $errors = ($errors || $this->unidad_pase_externo->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
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

//Operation Method @6-C7C6A8B8
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
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = "pa_unidadesGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "unidad_id"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "pa_unidadesGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "unidad_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                $Redirect = "pa_unidadesGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "unidad_id"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                $Redirect = "pa_unidadesGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "unidad_id"));
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

//InsertRow Method @6-EC34F738
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->unidad_nombre->SetValue($this->unidad_nombre->GetValue(true));
        $this->DataSource->jerarquia_id->SetValue($this->jerarquia_id->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
        $this->DataSource->entorno_id->SetValue($this->entorno_id->GetValue(true));
        $this->DataSource->unidad_pase_externo->SetValue($this->unidad_pase_externo->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @6-0CB9DC7F
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->unidad_nombre->SetValue($this->unidad_nombre->GetValue(true));
        $this->DataSource->jerarquia_id->SetValue($this->jerarquia_id->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
        $this->DataSource->entorno_id->SetValue($this->entorno_id->GetValue(true));
        $this->DataSource->unidad_pase_externo->SetValue($this->unidad_pase_externo->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @6-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @6-F956235F
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
        $this->unidad_pase_externo->Prepare();

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
                    $this->unidad_nombre->SetValue($this->DataSource->unidad_nombre->GetValue());
                    $this->jerarquia_id->SetValue($this->DataSource->jerarquia_id->GetValue());
                    $this->estado_id->SetValue($this->DataSource->estado_id->GetValue());
                    $this->entorno_id->SetValue($this->DataSource->entorno_id->GetValue());
                    $this->unidad_pase_externo->SetValue($this->DataSource->unidad_pase_externo->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->unidad_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->jerarquia_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->entorno_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidad_pase_externo->Errors->ToString());
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
        $this->unidad_nombre->Show();
        $this->jerarquia_id->Show();
        $this->estado_id->Show();
        $this->entorno_id->Show();
        $this->unidad_pase_externo->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End unidades Class @6-FCB6E20C

class clsunidadesDataSource extends clsDBmesa {  //unidadesDataSource Class @6-416CB45A

//DataSource Variables @6-86738A71
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $unidad_nombre;
    public $jerarquia_id;
    public $estado_id;
    public $entorno_id;
    public $unidad_pase_externo;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-FEBB53BA
    function clsunidadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record unidades/Error";
        $this->Initialize();
        $this->unidad_nombre = new clsField("unidad_nombre", ccsText, "");
        
        $this->jerarquia_id = new clsField("jerarquia_id", ccsInteger, "");
        
        $this->estado_id = new clsField("estado_id", ccsInteger, "");
        
        $this->entorno_id = new clsField("entorno_id", ccsInteger, "");
        
        $this->unidad_pase_externo = new clsField("unidad_pase_externo", ccsInteger, "");
        

        $this->InsertFields["unidad_nombre"] = array("Name" => "unidad_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["jerarquia_id"] = array("Name" => "jerarquia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["entorno_id"] = array("Name" => "entorno_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["unidad_pase_externo"] = array("Name" => "unidad_pase_externo", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_nombre"] = array("Name" => "unidad_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["jerarquia_id"] = array("Name" => "jerarquia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["entorno_id"] = array("Name" => "entorno_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_pase_externo"] = array("Name" => "unidad_pase_externo", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @6-309858EF
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

//Open Method @6-2D44DB3E
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

//SetValues Method @6-E13A6EC4
    function SetValues()
    {
        $this->unidad_nombre->SetDBValue($this->f("unidad_nombre"));
        $this->jerarquia_id->SetDBValue(trim($this->f("jerarquia_id")));
        $this->estado_id->SetDBValue(trim($this->f("estado_id")));
        $this->entorno_id->SetDBValue(trim($this->f("entorno_id")));
        $this->unidad_pase_externo->SetDBValue(trim($this->f("unidad_pase_externo")));
    }
//End SetValues Method

//Insert Method @6-4121F80D
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["unidad_nombre"]["Value"] = $this->unidad_nombre->GetDBValue(true);
        $this->InsertFields["jerarquia_id"]["Value"] = $this->jerarquia_id->GetDBValue(true);
        $this->InsertFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->InsertFields["entorno_id"]["Value"] = $this->entorno_id->GetDBValue(true);
        $this->InsertFields["unidad_pase_externo"]["Value"] = $this->unidad_pase_externo->GetDBValue(true);
        $this->SQL = CCBuildInsert("unidades", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-D3DD907B
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["unidad_nombre"]["Value"] = $this->unidad_nombre->GetDBValue(true);
        $this->UpdateFields["jerarquia_id"]["Value"] = $this->jerarquia_id->GetDBValue(true);
        $this->UpdateFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->UpdateFields["entorno_id"]["Value"] = $this->entorno_id->GetDBValue(true);
        $this->UpdateFields["unidad_pase_externo"]["Value"] = $this->unidad_pase_externo->GetDBValue(true);
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

//Delete Method @6-E782B331
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM unidades";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End unidadesDataSource Class @6-FCB6E20C

class clsEditableGridunidades_parametros { //unidades_parametros Class @21-0CD2C2B9

//Variables @21-EC0DDE90

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
    public $Sorter_unidad_p_activo;
    public $Sorter_unidad_p_f_vig;
    public $Sorter_unidad_p_responsable;
//End Variables

//Class_Initialize Event @21-8332FD86
    function clsEditableGridunidades_parametros($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid unidades_parametros/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "unidades_parametros";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["unidad_p_id"][0] = "unidad_p_id";
        $this->DataSource = new clsunidades_parametrosDataSource($this);
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

        $this->SorterName = CCGetParam("unidades_parametrosOrder", "");
        $this->SorterDirection = CCGetParam("unidades_parametrosDir", "");

        $this->Sorter_unidad_p_activo = new clsSorter($this->ComponentName, "Sorter_unidad_p_activo", $FileName, $this);
        $this->Sorter_unidad_p_f_vig = new clsSorter($this->ComponentName, "Sorter_unidad_p_f_vig", $FileName, $this);
        $this->Sorter_unidad_p_responsable = new clsSorter($this->ComponentName, "Sorter_unidad_p_responsable", $FileName, $this);
        $this->unidad_p_activo = new clsControl(ccsLabel, "unidad_p_activo", "Estado", ccsBoolean, array("Activo", "-", ""), NULL, $this);
        $this->unidad_p_f_vig = new clsControl(ccsTextBox, "unidad_p_f_vig", "Fecha vigencia", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->DatePicker_unidad_p_f_vig = new clsDatePicker("DatePicker_unidad_p_f_vig", "unidades_parametros", "unidad_p_f_vig", $this);
        $this->unidad_p_responsable = new clsControl(ccsTextBox, "unidad_p_responsable", "Responsable", ccsText, "", NULL, $this);
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->unidad_id = new clsControl(ccsHidden, "unidad_id", "unidad_id", ccsText, "", NULL, $this);
        $this->unidad_p_id = new clsControl(ccsHidden, "unidad_p_id", "unidad_p_id", ccsText, "", NULL, $this);
        $this->dep_unidad_id = new clsControl(ccsListBox, "dep_unidad_id", "Depende de", ccsText, "", NULL, $this);
        $this->dep_unidad_id->DSType = dsTable;
        $this->dep_unidad_id->DataSource = new clsDBmesa();
        $this->dep_unidad_id->ds = & $this->dep_unidad_id->DataSource;
        $this->dep_unidad_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades {SQL_Where} {SQL_OrderBy}";
        $this->dep_unidad_id->DataSource->Order = "unidad_nombre";
        list($this->dep_unidad_id->BoundColumn, $this->dep_unidad_id->TextColumn, $this->dep_unidad_id->DBFormat) = array("unidad_id", "unidad_nombre", "");
        $this->dep_unidad_id->DataSource->Order = "unidad_nombre";
    }
//End Class_Initialize Event

//Initialize Method @21-8B0773BC
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlunidad_id"] = CCGetFromGet("unidad_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @21-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @21-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @21-9D45560C
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["unidad_p_f_vig"][$RowNumber] = CCGetFromPost("unidad_p_f_vig_" . $RowNumber, NULL);
            $this->FormParameters["unidad_p_responsable"][$RowNumber] = CCGetFromPost("unidad_p_responsable_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
            $this->FormParameters["unidad_id"][$RowNumber] = CCGetFromPost("unidad_id_" . $RowNumber, NULL);
            $this->FormParameters["unidad_p_id"][$RowNumber] = CCGetFromPost("unidad_p_id_" . $RowNumber, NULL);
            $this->FormParameters["dep_unidad_id"][$RowNumber] = CCGetFromPost("dep_unidad_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @21-067FC552
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
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
            $this->unidad_p_id->SetText($this->FormParameters["unidad_p_id"][$this->RowNumber], $this->RowNumber);
            $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if(!$this->CheckBox_Delete->Value)
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

//ValidateRow Method @21-92670FB4
    function ValidateRow()
    {
        global $CCSLocales;
        $this->unidad_p_f_vig->Validate();
        $this->unidad_p_responsable->Validate();
        $this->CheckBox_Delete->Validate();
        $this->unidad_id->Validate();
        $this->unidad_p_id->Validate();
        $this->dep_unidad_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->unidad_p_f_vig->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_responsable->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->dep_unidad_id->Errors->ToString());
        $this->unidad_p_f_vig->Errors->Clear();
        $this->unidad_p_responsable->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $this->unidad_id->Errors->Clear();
        $this->unidad_p_id->Errors->Clear();
        $this->dep_unidad_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @21-F331484C
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["unidad_p_f_vig"][$this->RowNumber]) && count($this->FormParameters["unidad_p_f_vig"][$this->RowNumber])) || strlen($this->FormParameters["unidad_p_f_vig"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["unidad_p_responsable"][$this->RowNumber]) && count($this->FormParameters["unidad_p_responsable"][$this->RowNumber])) || strlen($this->FormParameters["unidad_p_responsable"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["unidad_id"][$this->RowNumber]) && count($this->FormParameters["unidad_id"][$this->RowNumber])) || strlen($this->FormParameters["unidad_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["unidad_p_id"][$this->RowNumber]) && count($this->FormParameters["unidad_p_id"][$this->RowNumber])) || strlen($this->FormParameters["unidad_p_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["dep_unidad_id"][$this->RowNumber]) && count($this->FormParameters["dep_unidad_id"][$this->RowNumber])) || strlen($this->FormParameters["dep_unidad_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @21-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @21-909F269B
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

//UpdateGrid Method @21-3A788FE7
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
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
            $this->unidad_p_id->SetText($this->FormParameters["unidad_p_id"][$this->RowNumber], $this->RowNumber);
            $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if($this->CheckBox_Delete->Value) {
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

//InsertRow Method @21-ECB28FE3
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->unidad_p_activo->SetValue($this->unidad_p_activo->GetValue(true));
        $this->DataSource->unidad_p_f_vig->SetValue($this->unidad_p_f_vig->GetValue(true));
        $this->DataSource->unidad_p_responsable->SetValue($this->unidad_p_responsable->GetValue(true));
        $this->DataSource->unidad_id->SetValue($this->unidad_id->GetValue(true));
        $this->DataSource->unidad_p_id->SetValue($this->unidad_p_id->GetValue(true));
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

//UpdateRow Method @21-758B05EE
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->unidad_p_activo->SetValue($this->unidad_p_activo->GetValue(true));
        $this->DataSource->unidad_p_f_vig->SetValue($this->unidad_p_f_vig->GetValue(true));
        $this->DataSource->unidad_p_responsable->SetValue($this->unidad_p_responsable->GetValue(true));
        $this->DataSource->unidad_id->SetValue($this->unidad_id->GetValue(true));
        $this->DataSource->unidad_p_id->SetValue($this->unidad_p_id->GetValue(true));
        $this->DataSource->dep_unidad_id->SetValue($this->dep_unidad_id->GetValue(true));
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

//DeleteRow Method @21-A4A656F6
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

//FormScript Method @21-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @21-D041996E
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

//GetFormState Method @21-EAC10879
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

//Show Method @21-F5A962D1
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
        $this->ControlsVisible["unidad_p_activo"] = $this->unidad_p_activo->Visible;
        $this->ControlsVisible["unidad_p_f_vig"] = $this->unidad_p_f_vig->Visible;
        $this->ControlsVisible["DatePicker_unidad_p_f_vig"] = $this->DatePicker_unidad_p_f_vig->Visible;
        $this->ControlsVisible["unidad_p_responsable"] = $this->unidad_p_responsable->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["unidad_id"] = $this->unidad_id->Visible;
        $this->ControlsVisible["unidad_p_id"] = $this->unidad_p_id->Visible;
        $this->ControlsVisible["dep_unidad_id"] = $this->dep_unidad_id->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($is_next_record) || !($this->DeleteAllowed)) {
                    $this->CheckBox_Delete->Visible = false;
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidad_p_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->unidad_p_activo->SetValue($this->DataSource->unidad_p_activo->GetValue());
                    $this->unidad_p_f_vig->SetValue($this->DataSource->unidad_p_f_vig->GetValue());
                    $this->unidad_p_responsable->SetValue($this->DataSource->unidad_p_responsable->GetValue());
                    $this->unidad_id->SetValue($this->DataSource->unidad_id->GetValue());
                    $this->unidad_p_id->SetValue($this->DataSource->unidad_p_id->GetValue());
                    $this->dep_unidad_id->SetValue($this->DataSource->dep_unidad_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->unidad_p_activo->SetText("");
                    $this->unidad_p_activo->SetValue($this->DataSource->unidad_p_activo->GetValue());
                    $this->unidad_p_f_vig->SetText($this->FormParameters["unidad_p_f_vig"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_p_responsable->SetText($this->FormParameters["unidad_p_responsable"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_p_id->SetText($this->FormParameters["unidad_p_id"][$this->RowNumber], $this->RowNumber);
                    $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = "";
                    $this->unidad_p_activo->SetText("");
                    $this->unidad_p_f_vig->SetText("");
                    $this->unidad_p_responsable->SetText("");
                    $this->unidad_id->SetText(CCGetParam('unidad_id'));
                    $this->unidad_p_id->SetText("");
                    $this->dep_unidad_id->SetText("");
                } else {
                    $this->unidad_p_activo->SetText("");
                    $this->unidad_p_f_vig->SetText($this->FormParameters["unidad_p_f_vig"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_p_responsable->SetText($this->FormParameters["unidad_p_responsable"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
                    $this->unidad_p_id->SetText($this->FormParameters["unidad_p_id"][$this->RowNumber], $this->RowNumber);
                    $this->dep_unidad_id->SetText($this->FormParameters["dep_unidad_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->unidad_p_activo->Show($this->RowNumber);
                $this->unidad_p_f_vig->Show($this->RowNumber);
                $this->DatePicker_unidad_p_f_vig->Show($this->RowNumber);
                $this->unidad_p_responsable->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->unidad_id->Show($this->RowNumber);
                $this->unidad_p_id->Show($this->RowNumber);
                $this->dep_unidad_id->Show($this->RowNumber);
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
        $this->Sorter_unidad_p_activo->Show();
        $this->Sorter_unidad_p_f_vig->Show();
        $this->Sorter_unidad_p_responsable->Show();
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

} //End unidades_parametros Class @21-FCB6E20C

class clsunidades_parametrosDataSource extends clsDBmesa {  //unidades_parametrosDataSource Class @21-BC963FE5

//DataSource Variables @21-2E6DC3D4
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
    public $unidad_p_activo;
    public $unidad_p_f_vig;
    public $unidad_p_responsable;
    public $CheckBox_Delete;
    public $unidad_id;
    public $unidad_p_id;
    public $dep_unidad_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @21-A219FBCD
    function clsunidades_parametrosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid unidades_parametros/Error";
        $this->Initialize();
        $this->unidad_p_activo = new clsField("unidad_p_activo", ccsBoolean, $this->BooleanFormat);
        
        $this->unidad_p_f_vig = new clsField("unidad_p_f_vig", ccsDate, $this->DateFormat);
        
        $this->unidad_p_responsable = new clsField("unidad_p_responsable", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->unidad_id = new clsField("unidad_id", ccsText, "");
        
        $this->unidad_p_id = new clsField("unidad_p_id", ccsText, "");
        
        $this->dep_unidad_id = new clsField("dep_unidad_id", ccsText, "");
        

        $this->InsertFields["unidad_p_f_vig"] = array("Name" => "unidad_p_f_vig", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["unidad_p_responsable"] = array("Name" => "unidad_p_responsable", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["unidad_p_id"] = array("Name" => "unidad_p_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["dep_unidad_id"] = array("Name" => "dep_unidad_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_p_f_vig"] = array("Name" => "unidad_p_f_vig", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_p_responsable"] = array("Name" => "unidad_p_responsable", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_p_id"] = array("Name" => "unidad_p_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["dep_unidad_id"] = array("Name" => "dep_unidad_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @21-E2C7460E
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "unidad_p_f_vig desc, unidad_p_activo desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_unidad_p_activo" => array("unidad_p_activo", ""), 
            "Sorter_unidad_p_f_vig" => array("unidad_p_f_vig", ""), 
            "Sorter_unidad_p_responsable" => array("unidad_p_responsable", "")));
    }
//End SetOrder Method

//Prepare Method @21-309858EF
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

//Open Method @21-13B621D0
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

//SetValues Method @21-9D86762D
    function SetValues()
    {
        $this->CachedColumns["unidad_p_id"] = $this->f("unidad_p_id");
        $this->unidad_p_activo->SetDBValue(trim($this->f("unidad_p_activo")));
        $this->unidad_p_f_vig->SetDBValue(trim($this->f("unidad_p_f_vig")));
        $this->unidad_p_responsable->SetDBValue($this->f("unidad_p_responsable"));
        $this->unidad_id->SetDBValue($this->f("unidad_id"));
        $this->unidad_p_id->SetDBValue($this->f("unidad_p_id"));
        $this->dep_unidad_id->SetDBValue($this->f("dep_unidad_id"));
    }
//End SetValues Method

//Insert Method @21-CD75E9AC
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["unidad_p_f_vig"]["Value"] = $this->unidad_p_f_vig->GetDBValue(true);
        $this->InsertFields["unidad_p_responsable"]["Value"] = $this->unidad_p_responsable->GetDBValue(true);
        $this->InsertFields["unidad_id"]["Value"] = $this->unidad_id->GetDBValue(true);
        $this->InsertFields["unidad_p_id"]["Value"] = $this->unidad_p_id->GetDBValue(true);
        $this->InsertFields["dep_unidad_id"]["Value"] = $this->dep_unidad_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("unidades_param", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @21-2E44293E
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
        $this->UpdateFields["unidad_id"]["Value"] = $this->unidad_id->GetDBValue(true);
        $this->UpdateFields["unidad_p_id"]["Value"] = $this->unidad_p_id->GetDBValue(true);
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

//Delete Method @21-DEE99F93
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

} //End unidades_parametrosDataSource Class @21-FCB6E20C

//Initialize Page @1-E98B1DE4
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
$TemplateFileName = "pa_unidadesRecord.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-462BD96E
include_once("./pa_unidadesRecord_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-825E0C94
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
$unidades = new clsRecordunidades("", $MainPage);
$unidades_parametros = new clsEditableGridunidades_parametros("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->unidades = & $unidades;
$MainPage->unidades_parametros = & $unidades_parametros;
$unidades->Initialize();
$unidades_parametros->Initialize();

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

//Execute Components @1-54DB8029
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$unidades->Operation();
$unidades_parametros->Operation();
//End Execute Components

//Go to destination page @1-E26C1D7F
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
    unset($unidades_parametros);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-15E23E1D
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$unidades->Show();
$unidades_parametros->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"><small>G&", "#101;ne&#114;&#97;&#116;e&#100; ", "<!-- CCS -->w&#105;&#116;h <!-- SCC ", "-->C&#111;deCh&#97;rg&#101; <!-- CCS ", "-->&#83;&#116;u&#100;&#105;o.</smal", "l></font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"><small>G&", "#101;ne&#114;&#97;&#116;e&#100; ", "<!-- CCS -->w&#105;&#116;h <!-- SCC ", "-->C&#111;deCh&#97;rg&#101; <!-- CCS ", "-->&#83;&#116;u&#100;&#105;o.</smal", "l></font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\"><small>G&", "#101;ne&#114;&#97;&#116;e&#100; ", "<!-- CCS -->w&#105;&#116;h <!-- SCC ", "-->C&#111;deCh&#97;rg&#101; <!-- CCS ", "-->&#83;&#116;u&#100;&#105;o.</smal", "l></font></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A88745F1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($unidades);
unset($unidades_parametros);
unset($Tpl);
//End Unload Page


?>
