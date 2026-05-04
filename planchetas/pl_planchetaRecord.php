<?php
//Include Common Files @1-BAF520F0
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "pl_planchetaRecord.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordplanchetas { //planchetas Class @2-FE14F440

//Variables @2-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormEnctype;
    var $Visible;
    var $IsEmpty;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;
    var $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-4B4A938B
    function clsRecordplanchetas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record planchetas/Error";
        $this->DataSource = new clsplanchetasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "planchetas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = & new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = & new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = & new clsButton("Button_Cancel", $Method, $this);
            $this->plancheta_scc = & new clsControl(ccsTextBox, "plancheta_scc", "Scc", ccsText, "", CCGetRequestParam("plancheta_scc", $Method, NULL), $this);
            $this->plancheta_scc->Required = true;
            $this->plancheta_mzo = & new clsControl(ccsTextBox, "plancheta_mzo", "Mzo", ccsText, "", CCGetRequestParam("plancheta_mzo", $Method, NULL), $this);
            $this->plancheta_par = & new clsControl(ccsTextBox, "plancheta_par", "Par", ccsText, "", CCGetRequestParam("plancheta_par", $Method, NULL), $this);
            $this->plancheta_hoja = & new clsControl(ccsTextBox, "plancheta_hoja", "Hoja", ccsInteger, "", CCGetRequestParam("plancheta_hoja", $Method, NULL), $this);
            $this->plancheta_obs = & new clsControl(ccsTextBox, "plancheta_obs", "Obs", ccsText, "", CCGetRequestParam("plancheta_obs", $Method, NULL), $this);
            $this->plancheta_f_act = & new clsControl(ccsHidden, "plancheta_f_act", "F Act", ccsText, "", CCGetRequestParam("plancheta_f_act", $Method, NULL), $this);
            $this->FileUpload1 = & new clsFileUpload("FileUpload1", "Archivo", "../tmp/", "./archivos/", "*.jpg;*.gif", "", 3000000, $this);
            $this->dpto_id = & new clsControl(ccsListBox, "dpto_id", "Departamento", ccsInteger, "", CCGetRequestParam("dpto_id", $Method, NULL), $this);
            $this->dpto_id->DSType = dsTable;
            $this->dpto_id->DataSource = new clsDBcatastro();
            $this->dpto_id->ds = & $this->dpto_id->DataSource;
            $this->dpto_id->DataSource->SQL = "SELECT * \n" .
"FROM departamentos {SQL_Where} {SQL_OrderBy}";
            list($this->dpto_id->BoundColumn, $this->dpto_id->TextColumn, $this->dpto_id->DBFormat) = array("dpto_id", "dpto_desc", "");
            $this->dpto_id->Required = true;
            $this->padron_id = & new clsControl(ccsRadioButton, "padron_id", "Padron", ccsInteger, "", CCGetRequestParam("padron_id", $Method, NULL), $this);
            $this->padron_id->DSType = dsTable;
            $this->padron_id->DataSource = new clsDBcatastro();
            $this->padron_id->ds = & $this->padron_id->DataSource;
            $this->padron_id->DataSource->SQL = "SELECT * \n" .
"FROM padrones {SQL_Where} {SQL_OrderBy}";
            list($this->padron_id->BoundColumn, $this->padron_id->TextColumn, $this->padron_id->DBFormat) = array("padron_id", "padron_desc", "");
            $this->padron_id->HTML = true;
            $this->padron_id->Required = true;
            $this->plancheta_qta = & new clsControl(ccsTextBox, "plancheta_qta", "plancheta_qta", ccsText, "", CCGetRequestParam("plancheta_qta", $Method, NULL), $this);
            $this->htm = & new clsControl(ccsLabel, "htm", "htm", ccsText, "", CCGetRequestParam("htm", $Method, NULL), $this);
            $this->htm->HTML = true;
            $this->plancheta_cha = & new clsControl(ccsTextBox, "plancheta_cha", "plancheta_cha", ccsText, "", CCGetRequestParam("plancheta_cha", $Method, NULL), $this);
            $this->plancheta_ruta = & new clsControl(ccsTextBox, "plancheta_ruta", "Par", ccsText, "", CCGetRequestParam("plancheta_ruta", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-A7FC2167
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlplancheta_id"] = CCGetFromGet("plancheta_id", NULL);
    }
//End Initialize Method

//Validate Method @2-22379296
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->plancheta_scc->Validate() && $Validation);
        $Validation = ($this->plancheta_mzo->Validate() && $Validation);
        $Validation = ($this->plancheta_par->Validate() && $Validation);
        $Validation = ($this->plancheta_hoja->Validate() && $Validation);
        $Validation = ($this->plancheta_obs->Validate() && $Validation);
        $Validation = ($this->plancheta_f_act->Validate() && $Validation);
        $Validation = ($this->FileUpload1->Validate() && $Validation);
        $Validation = ($this->dpto_id->Validate() && $Validation);
        $Validation = ($this->padron_id->Validate() && $Validation);
        $Validation = ($this->plancheta_qta->Validate() && $Validation);
        $Validation = ($this->plancheta_cha->Validate() && $Validation);
        $Validation = ($this->plancheta_ruta->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->plancheta_scc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_mzo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_par->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_hoja->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_obs->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_f_act->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FileUpload1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->padron_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_qta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_cha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plancheta_ruta->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-FD6B5129
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->plancheta_scc->Errors->Count());
        $errors = ($errors || $this->plancheta_mzo->Errors->Count());
        $errors = ($errors || $this->plancheta_par->Errors->Count());
        $errors = ($errors || $this->plancheta_hoja->Errors->Count());
        $errors = ($errors || $this->plancheta_obs->Errors->Count());
        $errors = ($errors || $this->plancheta_f_act->Errors->Count());
        $errors = ($errors || $this->FileUpload1->Errors->Count());
        $errors = ($errors || $this->dpto_id->Errors->Count());
        $errors = ($errors || $this->padron_id->Errors->Count());
        $errors = ($errors || $this->plancheta_qta->Errors->Count());
        $errors = ($errors || $this->htm->Errors->Count());
        $errors = ($errors || $this->plancheta_cha->Errors->Count());
        $errors = ($errors || $this->plancheta_ruta->Errors->Count());
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

//Operation Method @2-1666FFD8
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

        $this->FileUpload1->Upload();

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
        $Redirect = "pl_planchetasGrid.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "plancheta_id"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @2-116E1223
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->plancheta_scc->SetValue($this->plancheta_scc->GetValue(true));
        $this->DataSource->plancheta_mzo->SetValue($this->plancheta_mzo->GetValue(true));
        $this->DataSource->plancheta_par->SetValue($this->plancheta_par->GetValue(true));
        $this->DataSource->plancheta_hoja->SetValue($this->plancheta_hoja->GetValue(true));
        $this->DataSource->plancheta_obs->SetValue($this->plancheta_obs->GetValue(true));
        $this->DataSource->plancheta_f_act->SetValue($this->plancheta_f_act->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->dpto_id->SetValue($this->dpto_id->GetValue(true));
        $this->DataSource->padron_id->SetValue($this->padron_id->GetValue(true));
        $this->DataSource->plancheta_qta->SetValue($this->plancheta_qta->GetValue(true));
        $this->DataSource->htm->SetValue($this->htm->GetValue(true));
        $this->DataSource->plancheta_cha->SetValue($this->plancheta_cha->GetValue(true));
        $this->DataSource->plancheta_ruta->SetValue($this->plancheta_ruta->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-2931F251
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->plancheta_scc->SetValue($this->plancheta_scc->GetValue(true));
        $this->DataSource->plancheta_mzo->SetValue($this->plancheta_mzo->GetValue(true));
        $this->DataSource->plancheta_par->SetValue($this->plancheta_par->GetValue(true));
        $this->DataSource->plancheta_hoja->SetValue($this->plancheta_hoja->GetValue(true));
        $this->DataSource->plancheta_obs->SetValue($this->plancheta_obs->GetValue(true));
        $this->DataSource->plancheta_f_act->SetValue($this->plancheta_f_act->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->dpto_id->SetValue($this->dpto_id->GetValue(true));
        $this->DataSource->padron_id->SetValue($this->padron_id->GetValue(true));
        $this->DataSource->plancheta_qta->SetValue($this->plancheta_qta->GetValue(true));
        $this->DataSource->htm->SetValue($this->htm->GetValue(true));
        $this->DataSource->plancheta_cha->SetValue($this->plancheta_cha->GetValue(true));
        $this->DataSource->plancheta_ruta->SetValue($this->plancheta_ruta->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-2B077D44
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Delete();
        }
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @2-9DB4262F
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

        $this->dpto_id->Prepare();
        $this->padron_id->Prepare();

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
                    $this->plancheta_scc->SetValue($this->DataSource->plancheta_scc->GetValue());
                    $this->plancheta_mzo->SetValue($this->DataSource->plancheta_mzo->GetValue());
                    $this->plancheta_par->SetValue($this->DataSource->plancheta_par->GetValue());
                    $this->plancheta_hoja->SetValue($this->DataSource->plancheta_hoja->GetValue());
                    $this->plancheta_obs->SetValue($this->DataSource->plancheta_obs->GetValue());
                    $this->plancheta_f_act->SetValue($this->DataSource->plancheta_f_act->GetValue());
                    $this->FileUpload1->SetValue($this->DataSource->FileUpload1->GetValue());
                    $this->dpto_id->SetValue($this->DataSource->dpto_id->GetValue());
                    $this->padron_id->SetValue($this->DataSource->padron_id->GetValue());
                    $this->plancheta_qta->SetValue($this->DataSource->plancheta_qta->GetValue());
                    $this->plancheta_cha->SetValue($this->DataSource->plancheta_cha->GetValue());
                    $this->plancheta_ruta->SetValue($this->DataSource->plancheta_ruta->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->plancheta_scc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_mzo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_par->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_hoja->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_obs->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_f_act->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FileUpload1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->padron_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_qta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->htm->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_cha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta_ruta->Errors->ToString());
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
        $this->plancheta_scc->Show();
        $this->plancheta_mzo->Show();
        $this->plancheta_par->Show();
        $this->plancheta_hoja->Show();
        $this->plancheta_obs->Show();
        $this->plancheta_f_act->Show();
        $this->FileUpload1->Show();
        $this->dpto_id->Show();
        $this->padron_id->Show();
        $this->plancheta_qta->Show();
        $this->htm->Show();
        $this->plancheta_cha->Show();
        $this->plancheta_ruta->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End planchetas Class @2-FCB6E20C

class clsplanchetasDataSource extends clsDBcatastro {  //planchetasDataSource Class @2-17FA46D8

//DataSource Variables @2-B096AEC1
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    var $InsertFields = array();
    var $UpdateFields = array();

    // Datasource fields
    var $plancheta_scc;
    var $plancheta_mzo;
    var $plancheta_par;
    var $plancheta_hoja;
    var $plancheta_obs;
    var $plancheta_f_act;
    var $FileUpload1;
    var $dpto_id;
    var $padron_id;
    var $plancheta_qta;
    var $htm;
    var $plancheta_cha;
    var $plancheta_ruta;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-402F7333
    function clsplanchetasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record planchetas/Error";
        $this->Initialize();
        $this->plancheta_scc = new clsField("plancheta_scc", ccsText, "");
        
        $this->plancheta_mzo = new clsField("plancheta_mzo", ccsText, "");
        
        $this->plancheta_par = new clsField("plancheta_par", ccsText, "");
        
        $this->plancheta_hoja = new clsField("plancheta_hoja", ccsInteger, "");
        
        $this->plancheta_obs = new clsField("plancheta_obs", ccsText, "");
        
        $this->plancheta_f_act = new clsField("plancheta_f_act", ccsText, "");
        
        $this->FileUpload1 = new clsField("FileUpload1", ccsText, "");
        
        $this->dpto_id = new clsField("dpto_id", ccsInteger, "");
        
        $this->padron_id = new clsField("padron_id", ccsInteger, "");
        
        $this->plancheta_qta = new clsField("plancheta_qta", ccsText, "");
        
        $this->htm = new clsField("htm", ccsText, "");
        
        $this->plancheta_cha = new clsField("plancheta_cha", ccsText, "");
        
        $this->plancheta_ruta = new clsField("plancheta_ruta", ccsText, "");
        

        $this->InsertFields["plancheta_scc"] = array("Name" => "plancheta_scc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_mzo"] = array("Name" => "plancheta_mzo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_par"] = array("Name" => "plancheta_par", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_hoja"] = array("Name" => "plancheta_hoja", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_obs"] = array("Name" => "plancheta_obs", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_f_act"] = array("Name" => "plancheta_f_act", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_file"] = array("Name" => "plancheta_file", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["dpto_id"] = array("Name" => "dpto_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["padron_id"] = array("Name" => "padron_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_qta"] = array("Name" => "plancheta_qta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_cha"] = array("Name" => "plancheta_cha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["plancheta_ruta"] = array("Name" => "plancheta_ruta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_scc"] = array("Name" => "plancheta_scc", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_mzo"] = array("Name" => "plancheta_mzo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_par"] = array("Name" => "plancheta_par", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_hoja"] = array("Name" => "plancheta_hoja", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_obs"] = array("Name" => "plancheta_obs", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_f_act"] = array("Name" => "plancheta_f_act", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_file"] = array("Name" => "plancheta_file", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["dpto_id"] = array("Name" => "dpto_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["padron_id"] = array("Name" => "padron_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_qta"] = array("Name" => "plancheta_qta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_cha"] = array("Name" => "plancheta_cha", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plancheta_ruta"] = array("Name" => "plancheta_ruta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-2318B90C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplancheta_id", ccsInteger, "", "", $this->Parameters["urlplancheta_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "plancheta_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-2060229A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n" .
        "FROM planchetas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-362F82AC
    function SetValues()
    {
        $this->plancheta_scc->SetDBValue($this->f("plancheta_scc"));
        $this->plancheta_mzo->SetDBValue($this->f("plancheta_mzo"));
        $this->plancheta_par->SetDBValue($this->f("plancheta_par"));
        $this->plancheta_hoja->SetDBValue(trim($this->f("plancheta_hoja")));
        $this->plancheta_obs->SetDBValue($this->f("plancheta_obs"));
        $this->plancheta_f_act->SetDBValue($this->f("plancheta_f_act"));
        $this->FileUpload1->SetDBValue($this->f("plancheta_file"));
        $this->dpto_id->SetDBValue(trim($this->f("dpto_id")));
        $this->padron_id->SetDBValue(trim($this->f("padron_id")));
        $this->plancheta_qta->SetDBValue($this->f("plancheta_qta"));
        $this->plancheta_cha->SetDBValue($this->f("plancheta_cha"));
        $this->plancheta_ruta->SetDBValue($this->f("plancheta_ruta"));
    }
//End SetValues Method

//Insert Method @2-C5294EC8
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["plancheta_scc"]["Value"] = $this->plancheta_scc->GetDBValue(true);
        $this->InsertFields["plancheta_mzo"]["Value"] = $this->plancheta_mzo->GetDBValue(true);
        $this->InsertFields["plancheta_par"]["Value"] = $this->plancheta_par->GetDBValue(true);
        $this->InsertFields["plancheta_hoja"]["Value"] = $this->plancheta_hoja->GetDBValue(true);
        $this->InsertFields["plancheta_obs"]["Value"] = $this->plancheta_obs->GetDBValue(true);
        $this->InsertFields["plancheta_f_act"]["Value"] = $this->plancheta_f_act->GetDBValue(true);
        $this->InsertFields["plancheta_file"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->InsertFields["dpto_id"]["Value"] = $this->dpto_id->GetDBValue(true);
        $this->InsertFields["padron_id"]["Value"] = $this->padron_id->GetDBValue(true);
        $this->InsertFields["plancheta_qta"]["Value"] = $this->plancheta_qta->GetDBValue(true);
        $this->InsertFields["plancheta_cha"]["Value"] = $this->plancheta_cha->GetDBValue(true);
        $this->InsertFields["plancheta_ruta"]["Value"] = $this->plancheta_ruta->GetDBValue(true);
        $this->SQL = CCBuildInsert("planchetas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-8F4217AB
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["plancheta_scc"]["Value"] = $this->plancheta_scc->GetDBValue(true);
        $this->UpdateFields["plancheta_mzo"]["Value"] = $this->plancheta_mzo->GetDBValue(true);
        $this->UpdateFields["plancheta_par"]["Value"] = $this->plancheta_par->GetDBValue(true);
        $this->UpdateFields["plancheta_hoja"]["Value"] = $this->plancheta_hoja->GetDBValue(true);
        $this->UpdateFields["plancheta_obs"]["Value"] = $this->plancheta_obs->GetDBValue(true);
        $this->UpdateFields["plancheta_f_act"]["Value"] = $this->plancheta_f_act->GetDBValue(true);
        $this->UpdateFields["plancheta_file"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->UpdateFields["dpto_id"]["Value"] = $this->dpto_id->GetDBValue(true);
        $this->UpdateFields["padron_id"]["Value"] = $this->padron_id->GetDBValue(true);
        $this->UpdateFields["plancheta_qta"]["Value"] = $this->plancheta_qta->GetDBValue(true);
        $this->UpdateFields["plancheta_cha"]["Value"] = $this->plancheta_cha->GetDBValue(true);
        $this->UpdateFields["plancheta_ruta"]["Value"] = $this->plancheta_ruta->GetDBValue(true);
        $this->SQL = CCBuildUpdate("planchetas", $this->UpdateFields, $this);
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @2-5D07627B
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM planchetas";
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

} //End planchetasDataSource Class @2-FCB6E20C

//Include Page implementation @20-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @21-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @22-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-0D13DB50
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
$TemplateFileName = "pl_planchetaRecord.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CFF4ED5D
CCSecurityRedirect("1;5", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-842937D9
include_once("./pl_planchetaRecord_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-83E48D12
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$planchetas = & new clsRecordplanchetas("", $MainPage);
$tdf_header = & new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = & new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = & new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->planchetas = & $planchetas;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$planchetas->Initialize();

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

//Execute Components @1-12F23AAE
$planchetas->Operation();
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-290FCF15
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($planchetas);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-943A9854
$planchetas->Show();
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$NELPQ3D3T7Q8G = explode("|", "<center><font face=\"Ari|al\"><small>Ge&#110;e&#|114;a&#116;ed <!-- CCS -->|w&#105;th <!-- SCC -->C&#1|11;&#100;&#101;Ch&#97;|r&#103;e <!-- SCC -->Stu|di&#111;.</small></font></c|enter>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($NELPQ3D3T7Q8G,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($NELPQ3D3T7Q8G,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($NELPQ3D3T7Q8G,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-505FF2F4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcatastro->close();
unset($planchetas);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
