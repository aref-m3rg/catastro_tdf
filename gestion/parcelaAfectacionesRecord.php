<?php
//Include Common Files @1-8D2E9506
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "parcelaAfectacionesRecord.php");
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

//Include Page implementation @6-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @8-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

class clsRecordafectaciones { //afectaciones Class @10-0EB9D7D3

//Variables @10-9E315808

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

//Class_Initialize Event @10-44B66367
    function clsRecordafectaciones($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record afectaciones/Error";
        $this->DataSource = new clsafectacionesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "afectaciones";
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
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "Parcela Id", ccsInteger, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->parcela_id->Required = true;
            $this->plano = new clsControl(ccsLabel, "plano", "Plano Id", ccsInteger, "", CCGetRequestParam("plano", $Method, NULL), $this);
            $this->tipo_afectacion_id = new clsControl(ccsListBox, "tipo_afectacion_id", "Tipo", ccsInteger, "", CCGetRequestParam("tipo_afectacion_id", $Method, NULL), $this);
            $this->tipo_afectacion_id->DSType = dsTable;
            $this->tipo_afectacion_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_afectacion_id->ds = & $this->tipo_afectacion_id->DataSource;
            $this->tipo_afectacion_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_afectaciones {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_afectacion_id->BoundColumn, $this->tipo_afectacion_id->TextColumn, $this->tipo_afectacion_id->DBFormat) = array("tipo_afectacion_id", "tipo_afectacion_nombre", "");
            $this->tipo_afectacion_id->Required = true;
            $this->afectacion_superficie = new clsControl(ccsTextBox, "afectacion_superficie", "Superficie", ccsFloat, "", CCGetRequestParam("afectacion_superficie", $Method, NULL), $this);
            $this->afectacion_descripcion = new clsControl(ccsTextBox, "afectacion_descripcion", "Afectacion Descripcion", ccsText, "", CCGetRequestParam("afectacion_descripcion", $Method, NULL), $this);
            $this->afectacion_observaciones = new clsControl(ccsTextArea, "afectacion_observaciones", "Afectacion Observaciones", ccsMemo, "", CCGetRequestParam("afectacion_observaciones", $Method, NULL), $this);
            $this->open_plano_busq = new clsControl(ccsLink, "open_plano_busq", "open_plano_busq", ccsText, "", CCGetRequestParam("open_plano_busq", $Method, NULL), $this);
            $this->open_plano_busq->Parameters = CCGetQueryString("QueryString", array("quitarPlano", "ccsForm"));
            $this->open_plano_busq->Page = "BuscarPlano.php";
            $this->plano_id = new clsControl(ccsHidden, "plano_id", "plano_id", ccsText, "", CCGetRequestParam("plano_id", $Method, NULL), $this);
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Page = "parcelaAfectacionesRecord.php";
        }
    }
//End Class_Initialize Event

//Initialize Method @10-1706FDCE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlafectacion_id"] = CCGetFromGet("afectacion_id", NULL);
    }
//End Initialize Method

//Validate Method @10-F8DCA199
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->tipo_afectacion_id->Validate() && $Validation);
        $Validation = ($this->afectacion_superficie->Validate() && $Validation);
        $Validation = ($this->afectacion_descripcion->Validate() && $Validation);
        $Validation = ($this->afectacion_observaciones->Validate() && $Validation);
        $Validation = ($this->plano_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_afectacion_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->afectacion_superficie->Errors->Count() == 0);
        $Validation =  $Validation && ($this->afectacion_descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->afectacion_observaciones->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @10-991BA5F4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->plano->Errors->Count());
        $errors = ($errors || $this->tipo_afectacion_id->Errors->Count());
        $errors = ($errors || $this->afectacion_superficie->Errors->Count());
        $errors = ($errors || $this->afectacion_descripcion->Errors->Count());
        $errors = ($errors || $this->afectacion_observaciones->Errors->Count());
        $errors = ($errors || $this->open_plano_busq->Errors->Count());
        $errors = ($errors || $this->plano_id->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @10-ED598703
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

//Operation Method @10-E3EFB8B8
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
        $Redirect = "parcelaAfectaciones.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            $Redirect = "parcelaAfectaciones.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "quitarPlano"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "parcelaAfectaciones.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "quitarPlano"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                $Redirect = "parcelaAfectaciones.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "quitarPlano"));
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                $Redirect = "parcelaAfectaciones.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "quitarPlano"));
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

//InsertRow Method @10-719137BA
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->plano->SetValue($this->plano->GetValue(true));
        $this->DataSource->tipo_afectacion_id->SetValue($this->tipo_afectacion_id->GetValue(true));
        $this->DataSource->afectacion_superficie->SetValue($this->afectacion_superficie->GetValue(true));
        $this->DataSource->afectacion_descripcion->SetValue($this->afectacion_descripcion->GetValue(true));
        $this->DataSource->afectacion_observaciones->SetValue($this->afectacion_observaciones->GetValue(true));
        $this->DataSource->open_plano_busq->SetValue($this->open_plano_busq->GetValue(true));
        $this->DataSource->plano_id->SetValue($this->plano_id->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @10-043FEB56
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->plano->SetValue($this->plano->GetValue(true));
        $this->DataSource->tipo_afectacion_id->SetValue($this->tipo_afectacion_id->GetValue(true));
        $this->DataSource->afectacion_superficie->SetValue($this->afectacion_superficie->GetValue(true));
        $this->DataSource->afectacion_descripcion->SetValue($this->afectacion_descripcion->GetValue(true));
        $this->DataSource->afectacion_observaciones->SetValue($this->afectacion_observaciones->GetValue(true));
        $this->DataSource->open_plano_busq->SetValue($this->open_plano_busq->GetValue(true));
        $this->DataSource->plano_id->SetValue($this->plano_id->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @10-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @10-ECB8C8AF
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

        $this->tipo_afectacion_id->Prepare();

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
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->tipo_afectacion_id->SetValue($this->DataSource->tipo_afectacion_id->GetValue());
                    $this->afectacion_superficie->SetValue($this->DataSource->afectacion_superficie->GetValue());
                    $this->afectacion_descripcion->SetValue($this->DataSource->afectacion_descripcion->GetValue());
                    $this->afectacion_observaciones->SetValue($this->DataSource->afectacion_observaciones->GetValue());
                    $this->plano_id->SetValue($this->DataSource->plano_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "quitarPlano", 1);

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_afectacion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->afectacion_superficie->Errors->ToString());
            $Error = ComposeStrings($Error, $this->afectacion_descripcion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->afectacion_observaciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->open_plano_busq->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
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
        $this->parcela_id->Show();
        $this->plano->Show();
        $this->tipo_afectacion_id->Show();
        $this->afectacion_superficie->Show();
        $this->afectacion_descripcion->Show();
        $this->afectacion_observaciones->Show();
        $this->open_plano_busq->Show();
        $this->plano_id->Show();
        $this->Link1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End afectaciones Class @10-FCB6E20C

class clsafectacionesDataSource extends clsDBtdf_nuevo {  //afectacionesDataSource Class @10-E70834C3

//DataSource Variables @10-2110D513
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
    public $parcela_id;
    public $plano;
    public $tipo_afectacion_id;
    public $afectacion_superficie;
    public $afectacion_descripcion;
    public $afectacion_observaciones;
    public $open_plano_busq;
    public $plano_id;
    public $Link1;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-A6A544F9
    function clsafectacionesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record afectaciones/Error";
        $this->Initialize();
        $this->parcela_id = new clsField("parcela_id", ccsInteger, "");
        
        $this->plano = new clsField("plano", ccsInteger, "");
        
        $this->tipo_afectacion_id = new clsField("tipo_afectacion_id", ccsInteger, "");
        
        $this->afectacion_superficie = new clsField("afectacion_superficie", ccsFloat, "");
        
        $this->afectacion_descripcion = new clsField("afectacion_descripcion", ccsText, "");
        
        $this->afectacion_observaciones = new clsField("afectacion_observaciones", ccsMemo, "");
        
        $this->open_plano_busq = new clsField("open_plano_busq", ccsText, "");
        
        $this->plano_id = new clsField("plano_id", ccsText, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        

        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_afectacion_id"] = array("Name" => "tipo_afectacion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["afectacion_superficie"] = array("Name" => "afectacion_superficie", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["afectacion_descripcion"] = array("Name" => "afectacion_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["afectacion_observaciones"] = array("Name" => "afectacion_observaciones", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->InsertFields["plano_id"] = array("Name" => "plano_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_afectacion_id"] = array("Name" => "tipo_afectacion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["afectacion_superficie"] = array("Name" => "afectacion_superficie", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["afectacion_descripcion"] = array("Name" => "afectacion_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["afectacion_observaciones"] = array("Name" => "afectacion_observaciones", "Value" => "", "DataType" => ccsMemo, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_id"] = array("Name" => "plano_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @10-3B77B4B7
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlafectacion_id", ccsInteger, "", "", $this->Parameters["urlafectacion_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "afectacion_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @10-16C8347C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM afectaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-ACBF5D6C
    function SetValues()
    {
        $this->parcela_id->SetDBValue(trim($this->f("parcela_id")));
        $this->tipo_afectacion_id->SetDBValue(trim($this->f("tipo_afectacion_id")));
        $this->afectacion_superficie->SetDBValue(trim($this->f("afectacion_superficie")));
        $this->afectacion_descripcion->SetDBValue($this->f("afectacion_descripcion"));
        $this->afectacion_observaciones->SetDBValue($this->f("afectacion_observaciones"));
        $this->plano_id->SetDBValue($this->f("plano_id"));
    }
//End SetValues Method

//Insert Method @10-9C3E37C9
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->InsertFields["tipo_afectacion_id"]["Value"] = $this->tipo_afectacion_id->GetDBValue(true);
        $this->InsertFields["afectacion_superficie"]["Value"] = $this->afectacion_superficie->GetDBValue(true);
        $this->InsertFields["afectacion_descripcion"]["Value"] = $this->afectacion_descripcion->GetDBValue(true);
        $this->InsertFields["afectacion_observaciones"]["Value"] = $this->afectacion_observaciones->GetDBValue(true);
        $this->InsertFields["plano_id"]["Value"] = $this->plano_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("afectaciones", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @10-ECC31148
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->UpdateFields["tipo_afectacion_id"]["Value"] = $this->tipo_afectacion_id->GetDBValue(true);
        $this->UpdateFields["afectacion_superficie"]["Value"] = $this->afectacion_superficie->GetDBValue(true);
        $this->UpdateFields["afectacion_descripcion"]["Value"] = $this->afectacion_descripcion->GetDBValue(true);
        $this->UpdateFields["afectacion_observaciones"]["Value"] = $this->afectacion_observaciones->GetDBValue(true);
        $this->UpdateFields["plano_id"]["Value"] = $this->plano_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("afectaciones", $this->UpdateFields, $this);
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

//Delete Method @10-20181911
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM afectaciones";
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

} //End afectacionesDataSource Class @10-FCB6E20C

//Include Page implementation @33-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-E66371DE
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
$TemplateFileName = "parcelaAfectacionesRecord.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-D659D312
include_once("./parcelaAfectacionesRecord_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D5B58A84
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$afectaciones = new clsRecordafectaciones("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->footerParcela = & $footerParcela;
$MainPage->headerParcela = & $headerParcela;
$MainPage->afectaciones = & $afectaciones;
$MainPage->tdf_footer = & $tdf_footer;
$afectaciones->Initialize();

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

//Execute Components @1-6C143260
$tdf_header->Operations();
$tdf_menu->Operations();
$footerParcela->Operations();
$headerParcela->Operations();
$afectaciones->Operation();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-56F05A1D
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    $headerParcela->Class_Terminate();
    unset($headerParcela);
    unset($afectaciones);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1CADE1EC
$tdf_header->Show();
$tdf_menu->Show();
$footerParcela->Show();
$headerParcela->Show();
$afectaciones->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font fa" . "ce=\"Arial\"><smal" . "l>&#71;e&#110;&#101" . ";&#114;&#97;ted <!" . "-- CCS -->w&#105;" . "&#116;h <!-- CCS " . "-->&#67;ode&#6" . "7;&#104;&#97;rg&#" . "101; <!-- SCC -" . "->S&#116;u&#100;io" . ".</small></font><" . "/center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font fa" . "ce=\"Arial\"><smal" . "l>&#71;e&#110;&#101" . ";&#114;&#97;ted <!" . "-- CCS -->w&#105;" . "&#116;h <!-- CCS " . "-->&#67;ode&#6" . "7;&#104;&#97;rg&#" . "101; <!-- SCC -" . "->S&#116;u&#100;io" . ".</small></font><" . "/center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font fa" . "ce=\"Arial\"><smal" . "l>&#71;e&#110;&#101" . ";&#114;&#97;ted <!" . "-- CCS -->w&#105;" . "&#116;h <!-- CCS " . "-->&#67;ode&#6" . "7;&#104;&#97;rg&#" . "101; <!-- SCC -" . "->S&#116;u&#100;io" . ".</small></font><" . "/center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-EBD9219E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$footerParcela->Class_Terminate();
unset($footerParcela);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($afectaciones);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
