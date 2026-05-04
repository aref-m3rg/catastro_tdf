<?php
//Include Common Files @1-3A2B98CD
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_recordProfesional.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordprofesionales { //profesionales Class @2-425EDF12

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

//Class_Initialize Event @2-FC90AA13
    function clsRecordprofesionales($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record profesionales/Error";
        $this->DataSource = new clsprofesionalesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "profesionales";
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
            $this->tipo_profesional_id = new clsControl(ccsListBox, "tipo_profesional_id", "Profesión", ccsInteger, "", CCGetRequestParam("tipo_profesional_id", $Method, NULL), $this);
            $this->tipo_profesional_id->DSType = dsTable;
            $this->tipo_profesional_id->DataSource = new clsDBcatastro();
            $this->tipo_profesional_id->ds = & $this->tipo_profesional_id->DataSource;
            $this->tipo_profesional_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_profesionales {SQL_Where} {SQL_OrderBy}";
            $this->tipo_profesional_id->DataSource->Order = "tipo_profesional_descrip";
            list($this->tipo_profesional_id->BoundColumn, $this->tipo_profesional_id->TextColumn, $this->tipo_profesional_id->DBFormat) = array("tipo_profesional_id", "tipo_profesional_descrip", "");
            $this->tipo_profesional_id->DataSource->Order = "tipo_profesional_descrip";
            $this->tipo_profesional_id->Required = true;
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Departamento", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBcatastro();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->tipo_depto_parc_id->Required = true;
            $this->prof_nombre = new clsControl(ccsTextBox, "prof_nombre", "Nombre", ccsText, "", CCGetRequestParam("prof_nombre", $Method, NULL), $this);
            $this->prof_nombre->Required = true;
            $this->prof_direccion = new clsControl(ccsTextBox, "prof_direccion", "Prof Direccion", ccsText, "", CCGetRequestParam("prof_direccion", $Method, NULL), $this);
            $this->prof_telefono = new clsControl(ccsTextBox, "prof_telefono", "Prof Telefono", ccsText, "", CCGetRequestParam("prof_telefono", $Method, NULL), $this);
            $this->prof_matricula = new clsControl(ccsTextBox, "prof_matricula", "Prof Matricula", ccsText, "", CCGetRequestParam("prof_matricula", $Method, NULL), $this);
            $this->prof_observaciones = new clsControl(ccsTextArea, "prof_observaciones", "Prof Observaciones", ccsText, "", CCGetRequestParam("prof_observaciones", $Method, NULL), $this);
            $this->prof_f_alta = new clsControl(ccsTextBox, "prof_f_alta", "Prof F Alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("prof_f_alta", $Method, NULL), $this);
            $this->DatePicker_prof_f_alta = new clsDatePicker("DatePicker_prof_f_alta", "profesionales", "prof_f_alta", $this);
            $this->prof_nro_pta = new clsControl(ccsTextBox, "prof_nro_pta", "Prof Nro Pta", ccsText, "", CCGetRequestParam("prof_nro_pta", $Method, NULL), $this);
            $this->prof_mail = new clsControl(ccsTextBox, "prof_mail", "Email", ccsText, "", CCGetRequestParam("prof_mail", $Method, NULL), $this);
            $this->prof_telefono_celular = new clsControl(ccsTextBox, "prof_telefono_celular", "prof_telefono_celular", ccsText, "", CCGetRequestParam("prof_telefono_celular", $Method, NULL), $this);
            $this->prof_dni = new clsControl(ccsTextBox, "prof_dni", "prof_dni", ccsText, "", CCGetRequestParam("prof_dni", $Method, NULL), $this);
            $this->prof_matricula_tdf = new clsControl(ccsTextBox, "prof_matricula_tdf", "prof_matricula_tdf", ccsText, "", CCGetRequestParam("prof_matricula_tdf", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "tipo_estado_id", ccsText, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->tipo_estado_id->DSType = dsTable;
            $this->tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
            $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->tipo_estado_id->DataSource->Parameters["expr34"] = 3;
            $this->tipo_estado_id->DataSource->wp = new clsSQLParameters();
            $this->tipo_estado_id->DataSource->wp->AddParameter("1", "expr34", ccsInteger, "", "", $this->tipo_estado_id->DataSource->Parameters["expr34"], "", false);
            $this->tipo_estado_id->DataSource->wp->Criterion[1] = $this->tipo_estado_id->DataSource->wp->Operation(opNotEqual, "tipo_estado_id", $this->tipo_estado_id->DataSource->wp->GetDBValue("1"), $this->tipo_estado_id->DataSource->ToSQL($this->tipo_estado_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->tipo_estado_id->DataSource->Where = 
                 $this->tipo_estado_id->DataSource->wp->Criterion[1];
            if(!$this->FormSubmitted) {
                if(!is_array($this->prof_f_alta->Value) && !strlen($this->prof_f_alta->Value) && $this->prof_f_alta->Value !== false)
                    $this->prof_f_alta->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-7CAA9EF8
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlprof_id"] = CCGetFromGet("prof_id", NULL);
    }
//End Initialize Method

//Validate Method @2-EDCFA3CF
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if(strlen($this->prof_mail->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->prof_mail->GetText())) {
            $this->prof_mail->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "Email"));
        }
        $Validation = ($this->tipo_profesional_id->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->prof_nombre->Validate() && $Validation);
        $Validation = ($this->prof_direccion->Validate() && $Validation);
        $Validation = ($this->prof_telefono->Validate() && $Validation);
        $Validation = ($this->prof_matricula->Validate() && $Validation);
        $Validation = ($this->prof_observaciones->Validate() && $Validation);
        $Validation = ($this->prof_f_alta->Validate() && $Validation);
        $Validation = ($this->prof_nro_pta->Validate() && $Validation);
        $Validation = ($this->prof_mail->Validate() && $Validation);
        $Validation = ($this->prof_telefono_celular->Validate() && $Validation);
        $Validation = ($this->prof_dni->Validate() && $Validation);
        $Validation = ($this->prof_matricula_tdf->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_profesional_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_direccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_telefono->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_matricula->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_observaciones->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_f_alta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_nro_pta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_mail->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_telefono_celular->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_dni->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_matricula_tdf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-A3CF89D1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_profesional_id->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->prof_nombre->Errors->Count());
        $errors = ($errors || $this->prof_direccion->Errors->Count());
        $errors = ($errors || $this->prof_telefono->Errors->Count());
        $errors = ($errors || $this->prof_matricula->Errors->Count());
        $errors = ($errors || $this->prof_observaciones->Errors->Count());
        $errors = ($errors || $this->prof_f_alta->Errors->Count());
        $errors = ($errors || $this->DatePicker_prof_f_alta->Errors->Count());
        $errors = ($errors || $this->prof_nro_pta->Errors->Count());
        $errors = ($errors || $this->prof_mail->Errors->Count());
        $errors = ($errors || $this->prof_telefono_celular->Errors->Count());
        $errors = ($errors || $this->prof_dni->Errors->Count());
        $errors = ($errors || $this->prof_matricula_tdf->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
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

//Operation Method @2-6940C5F2
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
            }
        }
        $Redirect = "tc_gridProfesionales.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @2-EF3DC1A8
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_profesional_id->SetValue($this->tipo_profesional_id->GetValue(true));
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->prof_nombre->SetValue($this->prof_nombre->GetValue(true));
        $this->DataSource->prof_direccion->SetValue($this->prof_direccion->GetValue(true));
        $this->DataSource->prof_telefono->SetValue($this->prof_telefono->GetValue(true));
        $this->DataSource->prof_matricula->SetValue($this->prof_matricula->GetValue(true));
        $this->DataSource->prof_observaciones->SetValue($this->prof_observaciones->GetValue(true));
        $this->DataSource->prof_f_alta->SetValue($this->prof_f_alta->GetValue(true));
        $this->DataSource->prof_nro_pta->SetValue($this->prof_nro_pta->GetValue(true));
        $this->DataSource->prof_mail->SetValue($this->prof_mail->GetValue(true));
        $this->DataSource->prof_telefono_celular->SetValue($this->prof_telefono_celular->GetValue(true));
        $this->DataSource->prof_dni->SetValue($this->prof_dni->GetValue(true));
        $this->DataSource->prof_matricula_tdf->SetValue($this->prof_matricula_tdf->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-2EFCA748
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_profesional_id->SetValue($this->tipo_profesional_id->GetValue(true));
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->prof_nombre->SetValue($this->prof_nombre->GetValue(true));
        $this->DataSource->prof_direccion->SetValue($this->prof_direccion->GetValue(true));
        $this->DataSource->prof_telefono->SetValue($this->prof_telefono->GetValue(true));
        $this->DataSource->prof_matricula->SetValue($this->prof_matricula->GetValue(true));
        $this->DataSource->prof_observaciones->SetValue($this->prof_observaciones->GetValue(true));
        $this->DataSource->prof_f_alta->SetValue($this->prof_f_alta->GetValue(true));
        $this->DataSource->prof_nro_pta->SetValue($this->prof_nro_pta->GetValue(true));
        $this->DataSource->prof_mail->SetValue($this->prof_mail->GetValue(true));
        $this->DataSource->prof_telefono_celular->SetValue($this->prof_telefono_celular->GetValue(true));
        $this->DataSource->prof_dni->SetValue($this->prof_dni->GetValue(true));
        $this->DataSource->prof_matricula_tdf->SetValue($this->prof_matricula_tdf->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-78358C79
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

        $this->tipo_profesional_id->Prepare();
        $this->tipo_depto_parc_id->Prepare();
        $this->tipo_estado_id->Prepare();

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
                    $this->tipo_profesional_id->SetValue($this->DataSource->tipo_profesional_id->GetValue());
                    $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                    $this->prof_nombre->SetValue($this->DataSource->prof_nombre->GetValue());
                    $this->prof_direccion->SetValue($this->DataSource->prof_direccion->GetValue());
                    $this->prof_telefono->SetValue($this->DataSource->prof_telefono->GetValue());
                    $this->prof_matricula->SetValue($this->DataSource->prof_matricula->GetValue());
                    $this->prof_observaciones->SetValue($this->DataSource->prof_observaciones->GetValue());
                    $this->prof_f_alta->SetValue($this->DataSource->prof_f_alta->GetValue());
                    $this->prof_nro_pta->SetValue($this->DataSource->prof_nro_pta->GetValue());
                    $this->prof_mail->SetValue($this->DataSource->prof_mail->GetValue());
                    $this->prof_telefono_celular->SetValue($this->DataSource->prof_telefono_celular->GetValue());
                    $this->prof_dni->SetValue($this->DataSource->prof_dni->GetValue());
                    $this->prof_matricula_tdf->SetValue($this->DataSource->prof_matricula_tdf->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_profesional_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_direccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_telefono->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_matricula->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_observaciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_f_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_prof_f_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_nro_pta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_mail->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_telefono_celular->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_dni->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_matricula_tdf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
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
        $this->tipo_profesional_id->Show();
        $this->tipo_depto_parc_id->Show();
        $this->prof_nombre->Show();
        $this->prof_direccion->Show();
        $this->prof_telefono->Show();
        $this->prof_matricula->Show();
        $this->prof_observaciones->Show();
        $this->prof_f_alta->Show();
        $this->DatePicker_prof_f_alta->Show();
        $this->prof_nro_pta->Show();
        $this->prof_mail->Show();
        $this->prof_telefono_celular->Show();
        $this->prof_dni->Show();
        $this->prof_matricula_tdf->Show();
        $this->tipo_estado_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End profesionales Class @2-FCB6E20C

class clsprofesionalesDataSource extends clsDBtdf_nuevo {  //profesionalesDataSource Class @2-2116572D

//DataSource Variables @2-DFD6884D
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
    public $tipo_profesional_id;
    public $tipo_depto_parc_id;
    public $prof_nombre;
    public $prof_direccion;
    public $prof_telefono;
    public $prof_matricula;
    public $prof_observaciones;
    public $prof_f_alta;
    public $prof_nro_pta;
    public $prof_mail;
    public $prof_telefono_celular;
    public $prof_dni;
    public $prof_matricula_tdf;
    public $tipo_estado_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-377353C4
    function clsprofesionalesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record profesionales/Error";
        $this->Initialize();
        $this->tipo_profesional_id = new clsField("tipo_profesional_id", ccsInteger, "");
        
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->prof_nombre = new clsField("prof_nombre", ccsText, "");
        
        $this->prof_direccion = new clsField("prof_direccion", ccsText, "");
        
        $this->prof_telefono = new clsField("prof_telefono", ccsText, "");
        
        $this->prof_matricula = new clsField("prof_matricula", ccsText, "");
        
        $this->prof_observaciones = new clsField("prof_observaciones", ccsText, "");
        
        $this->prof_f_alta = new clsField("prof_f_alta", ccsDate, $this->DateFormat);
        
        $this->prof_nro_pta = new clsField("prof_nro_pta", ccsText, "");
        
        $this->prof_mail = new clsField("prof_mail", ccsText, "");
        
        $this->prof_telefono_celular = new clsField("prof_telefono_celular", ccsText, "");
        
        $this->prof_dni = new clsField("prof_dni", ccsText, "");
        
        $this->prof_matricula_tdf = new clsField("prof_matricula_tdf", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsText, "");
        

        $this->InsertFields["tipo_profesional_id"] = array("Name" => "tipo_profesional_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_nombre"] = array("Name" => "prof_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_direccion"] = array("Name" => "prof_direccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_telefono"] = array("Name" => "prof_telefono", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_matricula"] = array("Name" => "prof_matricula", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_observaciones"] = array("Name" => "prof_observaciones", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_f_alta"] = array("Name" => "prof_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_nro_pta"] = array("Name" => "prof_nro_pta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_mail"] = array("Name" => "prof_mail", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_telefono_celular"] = array("Name" => "prof_telefono_celular", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_dni"] = array("Name" => "prof_dni", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["prof_matricula_tdf"] = array("Name" => "prof_matricula_tdf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_profesional_id"] = array("Name" => "tipo_profesional_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_nombre"] = array("Name" => "prof_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_direccion"] = array("Name" => "prof_direccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_telefono"] = array("Name" => "prof_telefono", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_matricula"] = array("Name" => "prof_matricula", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_observaciones"] = array("Name" => "prof_observaciones", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_f_alta"] = array("Name" => "prof_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_nro_pta"] = array("Name" => "prof_nro_pta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_mail"] = array("Name" => "prof_mail", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_telefono_celular"] = array("Name" => "prof_telefono_celular", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_dni"] = array("Name" => "prof_dni", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["prof_matricula_tdf"] = array("Name" => "prof_matricula_tdf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-91E0C83B
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprof_id", ccsInteger, "", "", $this->Parameters["urlprof_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "prof_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-7B2B81B1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM profesionales {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-329BBB1E
    function SetValues()
    {
        $this->tipo_profesional_id->SetDBValue(trim($this->f("tipo_profesional_id")));
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->prof_nombre->SetDBValue($this->f("prof_nombre"));
        $this->prof_direccion->SetDBValue($this->f("prof_direccion"));
        $this->prof_telefono->SetDBValue($this->f("prof_telefono"));
        $this->prof_matricula->SetDBValue($this->f("prof_matricula"));
        $this->prof_observaciones->SetDBValue($this->f("prof_observaciones"));
        $this->prof_f_alta->SetDBValue(trim($this->f("prof_f_alta")));
        $this->prof_nro_pta->SetDBValue($this->f("prof_nro_pta"));
        $this->prof_mail->SetDBValue($this->f("prof_mail"));
        $this->prof_telefono_celular->SetDBValue($this->f("prof_telefono_celular"));
        $this->prof_dni->SetDBValue($this->f("prof_dni"));
        $this->prof_matricula_tdf->SetDBValue($this->f("prof_matricula_tdf"));
        $this->tipo_estado_id->SetDBValue($this->f("tipo_estado_id"));
    }
//End SetValues Method

//Insert Method @2-DDABF28E
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_profesional_id"]["Value"] = $this->tipo_profesional_id->GetDBValue(true);
        $this->InsertFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->InsertFields["prof_nombre"]["Value"] = $this->prof_nombre->GetDBValue(true);
        $this->InsertFields["prof_direccion"]["Value"] = $this->prof_direccion->GetDBValue(true);
        $this->InsertFields["prof_telefono"]["Value"] = $this->prof_telefono->GetDBValue(true);
        $this->InsertFields["prof_matricula"]["Value"] = $this->prof_matricula->GetDBValue(true);
        $this->InsertFields["prof_observaciones"]["Value"] = $this->prof_observaciones->GetDBValue(true);
        $this->InsertFields["prof_f_alta"]["Value"] = $this->prof_f_alta->GetDBValue(true);
        $this->InsertFields["prof_nro_pta"]["Value"] = $this->prof_nro_pta->GetDBValue(true);
        $this->InsertFields["prof_mail"]["Value"] = $this->prof_mail->GetDBValue(true);
        $this->InsertFields["prof_telefono_celular"]["Value"] = $this->prof_telefono_celular->GetDBValue(true);
        $this->InsertFields["prof_dni"]["Value"] = $this->prof_dni->GetDBValue(true);
        $this->InsertFields["prof_matricula_tdf"]["Value"] = $this->prof_matricula_tdf->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("profesionales", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-D22BF34C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_profesional_id"]["Value"] = $this->tipo_profesional_id->GetDBValue(true);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["prof_nombre"]["Value"] = $this->prof_nombre->GetDBValue(true);
        $this->UpdateFields["prof_direccion"]["Value"] = $this->prof_direccion->GetDBValue(true);
        $this->UpdateFields["prof_telefono"]["Value"] = $this->prof_telefono->GetDBValue(true);
        $this->UpdateFields["prof_matricula"]["Value"] = $this->prof_matricula->GetDBValue(true);
        $this->UpdateFields["prof_observaciones"]["Value"] = $this->prof_observaciones->GetDBValue(true);
        $this->UpdateFields["prof_f_alta"]["Value"] = $this->prof_f_alta->GetDBValue(true);
        $this->UpdateFields["prof_nro_pta"]["Value"] = $this->prof_nro_pta->GetDBValue(true);
        $this->UpdateFields["prof_mail"]["Value"] = $this->prof_mail->GetDBValue(true);
        $this->UpdateFields["prof_telefono_celular"]["Value"] = $this->prof_telefono_celular->GetDBValue(true);
        $this->UpdateFields["prof_dni"]["Value"] = $this->prof_dni->GetDBValue(true);
        $this->UpdateFields["prof_matricula_tdf"]["Value"] = $this->prof_matricula_tdf->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("profesionales", $this->UpdateFields, $this);
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

} //End profesionalesDataSource Class @2-FCB6E20C

//Include Page implementation @19-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @20-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @21-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-AADB965C
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
$TemplateFileName = "tc_recordProfesional.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CBFD1E0E
CCSecurityRedirect("1;2", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-3D0DAEDC
include_once("./tc_recordProfesional_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-56483CF1
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$profesionales = new clsRecordprofesionales("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->profesionales = & $profesionales;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$profesionales->Initialize();

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

//Execute Components @1-5C7ADA9E
$profesionales->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-41F775E2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($profesionales);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5F94A512
$profesionales->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;&#101;&#110;erat&#101;d <!-- SCC -->&#119;&#105;&#116;h <!-- CCS -->&#67;&#111;deCha&#114;&#103;&#101; <!-- CCS -->S&#116;udio.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;&#101;&#110;erat&#101;d <!-- SCC -->&#119;&#105;&#116;h <!-- CCS -->&#67;&#111;deCha&#114;&#103;&#101; <!-- CCS -->S&#116;udio.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>&#71;&#101;&#110;erat&#101;d <!-- SCC -->&#119;&#105;&#116;h <!-- CCS -->&#67;&#111;deCha&#114;&#103;&#101; <!-- CCS -->S&#116;udio.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-73BA50DB
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBcatastro->close();
unset($profesionales);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
