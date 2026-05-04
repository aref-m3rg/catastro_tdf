<?php
//Include Common Files @1-CE3D2CA9
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "EditPersona.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordpersonas { //personas Class @2-9339D5E2

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

//Class_Initialize Event @2-B8FE28D5
    function clsRecordpersonas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record personas/Error";
        $this->DataSource = new clspersonasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "personas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->tipo_persona_id = new clsControl(ccsListBox, "tipo_persona_id", "Tipo Persona Id", ccsInteger, "", CCGetRequestParam("tipo_persona_id", $Method, NULL), $this);
            $this->tipo_persona_id->DSType = dsTable;
            $this->tipo_persona_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_persona_id->ds = & $this->tipo_persona_id->DataSource;
            $this->tipo_persona_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_persona_id->BoundColumn, $this->tipo_persona_id->TextColumn, $this->tipo_persona_id->DBFormat) = array("tipo_persona_id", "tipo_persona_descrip", "");
            $this->tipo_persona_id->Required = true;
            $this->tipo_documento_id = new clsControl(ccsListBox, "tipo_documento_id", "Tipo de Documento", ccsInteger, "", CCGetRequestParam("tipo_documento_id", $Method, NULL), $this);
            $this->tipo_documento_id->DSType = dsTable;
            $this->tipo_documento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_documento_id->ds = & $this->tipo_documento_id->DataSource;
            $this->tipo_documento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_documento_id->BoundColumn, $this->tipo_documento_id->TextColumn, $this->tipo_documento_id->DBFormat) = array("tipo_documento_id", "tipo_documento_abrev", "");
            $this->persona_cuit = new clsControl(ccsTextBox, "persona_cuit", "Cuit", ccsText, "", CCGetRequestParam("persona_cuit", $Method, NULL), $this);
            $this->persona_denominacion = new clsControl(ccsHidden, "persona_denominacion", "Nombre y Apellido", ccsText, "", CCGetRequestParam("persona_denominacion", $Method, NULL), $this);
            $this->persona_conyuge = new clsControl(ccsTextBox, "persona_conyuge", "Conyuge", ccsText, "", CCGetRequestParam("persona_conyuge", $Method, NULL), $this);
            $this->persona_fecha_nac = new clsControl(ccsTextBox, "persona_fecha_nac", "Fecha Nac", ccsDate, $DefaultDateFormat, CCGetRequestParam("persona_fecha_nac", $Method, NULL), $this);
            $this->DatePicker_persona_fecha_nac = new clsDatePicker("DatePicker_persona_fecha_nac", "personas", "persona_fecha_nac", $this);
            $this->pais_id = new clsControl(ccsListBox, "pais_id", "Pais Id", ccsInteger, "", CCGetRequestParam("pais_id", $Method, NULL), $this);
            $this->pais_id->DSType = dsTable;
            $this->pais_id->DataSource = new clsDBtdf_nuevo();
            $this->pais_id->ds = & $this->pais_id->DataSource;
            $this->pais_id->DataSource->SQL = "SELECT * \n" .
"FROM paises {SQL_Where} {SQL_OrderBy}";
            list($this->pais_id->BoundColumn, $this->pais_id->TextColumn, $this->pais_id->DBFormat) = array("pais_id", "pais_nombre", "");
            $this->persona_tel_movil = new clsControl(ccsTextBox, "persona_tel_movil", "Tel Movil", ccsText, "", CCGetRequestParam("persona_tel_movil", $Method, NULL), $this);
            $this->persona_email = new clsControl(ccsTextBox, "persona_email", "Email", ccsText, "", CCGetRequestParam("persona_email", $Method, NULL), $this);
            $this->persona_nro_doc = new clsControl(ccsTextBox, "persona_nro_doc", "Nro Documento", ccsInteger, "", CCGetRequestParam("persona_nro_doc", $Method, NULL), $this);
            $this->persona_f_proce = new clsControl(ccsHidden, "persona_f_proce", "persona_f_proce", ccsText, "", CCGetRequestParam("persona_f_proce", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->persona_apellido = new clsControl(ccsTextBox, "persona_apellido", "Apellido / Razón Social", ccsText, "", CCGetRequestParam("persona_apellido", $Method, NULL), $this);
            $this->persona_nombre = new clsControl(ccsTextBox, "persona_nombre", "Nombre", ccsText, "", CCGetRequestParam("persona_nombre", $Method, NULL), $this);
            $this->ListBox1 = new clsControl(ccsListBox, "ListBox1", "ListBox1", ccsText, "", CCGetRequestParam("ListBox1", $Method, NULL), $this);
            $this->ListBox1->DSType = dsTable;
            $this->ListBox1->DataSource = new clsDBtdf_nuevo();
            $this->ListBox1->ds = & $this->ListBox1->DataSource;
            $this->ListBox1->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_juridicas {SQL_Where} {SQL_OrderBy}";
            list($this->ListBox1->BoundColumn, $this->ListBox1->TextColumn, $this->ListBox1->DBFormat) = array("tipo_perso_jur_id", "tipo_perso_jur_descrip", "");
            $this->persona_relacionada = new clsControl(ccsLabel, "persona_relacionada", "persona_relacionada", ccsText, "", CCGetRequestParam("persona_relacionada", $Method, NULL), $this);
            $this->add_persona = new clsControl(ccsImageLink, "add_persona", "add_persona", ccsText, "", CCGetRequestParam("add_persona", $Method, NULL), $this);
            $this->add_persona->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->add_persona->Page = "buscaPersonasGral.php";
            $this->remove_persona = new clsControl(ccsImageLink, "remove_persona", "remove_persona", ccsText, "", CCGetRequestParam("remove_persona", $Method, NULL), $this);
            $this->remove_persona->Page = "EditPersona.php";
            $this->persona_relacionada_id = new clsControl(ccsHidden, "persona_relacionada_id", "persona_relacionada_id", ccsInteger, "", CCGetRequestParam("persona_relacionada_id", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->persona_nro_doc->Value) && !strlen($this->persona_nro_doc->Value) && $this->persona_nro_doc->Value !== false)
                    $this->persona_nro_doc->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-AF060F1F
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlpersona_id"] = CCGetFromGet("persona_id", NULL);
    }
//End Initialize Method

//Validate Method @2-43D94059
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if(strlen($this->persona_email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->persona_email->GetText())) {
            $this->persona_email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "Email"));
        }
        $Validation = ($this->tipo_persona_id->Validate() && $Validation);
        $Validation = ($this->tipo_documento_id->Validate() && $Validation);
        $Validation = ($this->persona_cuit->Validate() && $Validation);
        $Validation = ($this->persona_denominacion->Validate() && $Validation);
        $Validation = ($this->persona_conyuge->Validate() && $Validation);
        $Validation = ($this->persona_fecha_nac->Validate() && $Validation);
        $Validation = ($this->pais_id->Validate() && $Validation);
        $Validation = ($this->persona_tel_movil->Validate() && $Validation);
        $Validation = ($this->persona_email->Validate() && $Validation);
        $Validation = ($this->persona_nro_doc->Validate() && $Validation);
        $Validation = ($this->persona_f_proce->Validate() && $Validation);
        $Validation = ($this->persona_apellido->Validate() && $Validation);
        $Validation = ($this->persona_nombre->Validate() && $Validation);
        $Validation = ($this->ListBox1->Validate() && $Validation);
        $Validation = ($this->persona_relacionada_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_persona_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_documento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_cuit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_conyuge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_fecha_nac->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pais_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_tel_movil->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_nro_doc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_f_proce->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_apellido->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->persona_relacionada_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-C2ACD7CD
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_persona_id->Errors->Count());
        $errors = ($errors || $this->tipo_documento_id->Errors->Count());
        $errors = ($errors || $this->persona_cuit->Errors->Count());
        $errors = ($errors || $this->persona_denominacion->Errors->Count());
        $errors = ($errors || $this->persona_conyuge->Errors->Count());
        $errors = ($errors || $this->persona_fecha_nac->Errors->Count());
        $errors = ($errors || $this->DatePicker_persona_fecha_nac->Errors->Count());
        $errors = ($errors || $this->pais_id->Errors->Count());
        $errors = ($errors || $this->persona_tel_movil->Errors->Count());
        $errors = ($errors || $this->persona_email->Errors->Count());
        $errors = ($errors || $this->persona_nro_doc->Errors->Count());
        $errors = ($errors || $this->persona_f_proce->Errors->Count());
        $errors = ($errors || $this->persona_apellido->Errors->Count());
        $errors = ($errors || $this->persona_nombre->Errors->Count());
        $errors = ($errors || $this->ListBox1->Errors->Count());
        $errors = ($errors || $this->persona_relacionada->Errors->Count());
        $errors = ($errors || $this->add_persona->Errors->Count());
        $errors = ($errors || $this->remove_persona->Errors->Count());
        $errors = ($errors || $this->persona_relacionada_id->Errors->Count());
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

//Operation Method @2-08E030E2
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button1";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            $Redirect = "gridPersonas.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "remove"));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
                $Redirect = "gridPersonas.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "remove"));
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

//UpdateRow Method @2-3C546032
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_persona_id->SetValue($this->tipo_persona_id->GetValue(true));
        $this->DataSource->tipo_documento_id->SetValue($this->tipo_documento_id->GetValue(true));
        $this->DataSource->persona_cuit->SetValue($this->persona_cuit->GetValue(true));
        $this->DataSource->persona_denominacion->SetValue($this->persona_denominacion->GetValue(true));
        $this->DataSource->persona_conyuge->SetValue($this->persona_conyuge->GetValue(true));
        $this->DataSource->persona_fecha_nac->SetValue($this->persona_fecha_nac->GetValue(true));
        $this->DataSource->pais_id->SetValue($this->pais_id->GetValue(true));
        $this->DataSource->persona_tel_movil->SetValue($this->persona_tel_movil->GetValue(true));
        $this->DataSource->persona_email->SetValue($this->persona_email->GetValue(true));
        $this->DataSource->persona_nro_doc->SetValue($this->persona_nro_doc->GetValue(true));
        $this->DataSource->persona_f_proce->SetValue($this->persona_f_proce->GetValue(true));
        $this->DataSource->persona_apellido->SetValue($this->persona_apellido->GetValue(true));
        $this->DataSource->persona_nombre->SetValue($this->persona_nombre->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->persona_relacionada->SetValue($this->persona_relacionada->GetValue(true));
        $this->DataSource->add_persona->SetValue($this->add_persona->GetValue(true));
        $this->DataSource->remove_persona->SetValue($this->remove_persona->GetValue(true));
        $this->DataSource->persona_relacionada_id->SetValue($this->persona_relacionada_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-5DE11290
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

        $this->tipo_persona_id->Prepare();
        $this->tipo_documento_id->Prepare();
        $this->pais_id->Prepare();
        $this->ListBox1->Prepare();

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
                    $this->tipo_persona_id->SetValue($this->DataSource->tipo_persona_id->GetValue());
                    $this->tipo_documento_id->SetValue($this->DataSource->tipo_documento_id->GetValue());
                    $this->persona_cuit->SetValue($this->DataSource->persona_cuit->GetValue());
                    $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                    $this->persona_conyuge->SetValue($this->DataSource->persona_conyuge->GetValue());
                    $this->persona_fecha_nac->SetValue($this->DataSource->persona_fecha_nac->GetValue());
                    $this->pais_id->SetValue($this->DataSource->pais_id->GetValue());
                    $this->persona_tel_movil->SetValue($this->DataSource->persona_tel_movil->GetValue());
                    $this->persona_email->SetValue($this->DataSource->persona_email->GetValue());
                    $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                    $this->persona_f_proce->SetValue($this->DataSource->persona_f_proce->GetValue());
                    $this->persona_apellido->SetValue($this->DataSource->persona_apellido->GetValue());
                    $this->persona_nombre->SetValue($this->DataSource->persona_nombre->GetValue());
                    $this->persona_relacionada_id->SetValue($this->DataSource->persona_relacionada_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }
        $this->remove_persona->Parameters = CCGetQueryString("QueryString", array("persona_relacionada_id", "ccsForm"));
        $this->remove_persona->Parameters = CCAddParam($this->remove_persona->Parameters, "remove", 1);

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_persona_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_documento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_cuit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_conyuge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_fecha_nac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_persona_fecha_nac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pais_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_tel_movil->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_nro_doc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_f_proce->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_apellido->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_relacionada->Errors->ToString());
            $Error = ComposeStrings($Error, $this->add_persona->Errors->ToString());
            $Error = ComposeStrings($Error, $this->remove_persona->Errors->ToString());
            $Error = ComposeStrings($Error, $this->persona_relacionada_id->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->tipo_persona_id->Show();
        $this->tipo_documento_id->Show();
        $this->persona_cuit->Show();
        $this->persona_denominacion->Show();
        $this->persona_conyuge->Show();
        $this->persona_fecha_nac->Show();
        $this->DatePicker_persona_fecha_nac->Show();
        $this->pais_id->Show();
        $this->persona_tel_movil->Show();
        $this->persona_email->Show();
        $this->persona_nro_doc->Show();
        $this->persona_f_proce->Show();
        $this->Button1->Show();
        $this->persona_apellido->Show();
        $this->persona_nombre->Show();
        $this->ListBox1->Show();
        $this->persona_relacionada->Show();
        $this->add_persona->Show();
        $this->remove_persona->Show();
        $this->persona_relacionada_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End personas Class @2-FCB6E20C

class clspersonasDataSource extends clsDBtdf_nuevo {  //personasDataSource Class @2-9C37F6CB

//DataSource Variables @2-FB24C7C6
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
    public $tipo_persona_id;
    public $tipo_documento_id;
    public $persona_cuit;
    public $persona_denominacion;
    public $persona_conyuge;
    public $persona_fecha_nac;
    public $pais_id;
    public $persona_tel_movil;
    public $persona_email;
    public $persona_nro_doc;
    public $persona_f_proce;
    public $persona_apellido;
    public $persona_nombre;
    public $ListBox1;
    public $persona_relacionada;
    public $add_persona;
    public $remove_persona;
    public $persona_relacionada_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-373039A7
    function clspersonasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record personas/Error";
        $this->Initialize();
        $this->tipo_persona_id = new clsField("tipo_persona_id", ccsInteger, "");
        
        $this->tipo_documento_id = new clsField("tipo_documento_id", ccsInteger, "");
        
        $this->persona_cuit = new clsField("persona_cuit", ccsText, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->persona_conyuge = new clsField("persona_conyuge", ccsText, "");
        
        $this->persona_fecha_nac = new clsField("persona_fecha_nac", ccsDate, $this->DateFormat);
        
        $this->pais_id = new clsField("pais_id", ccsInteger, "");
        
        $this->persona_tel_movil = new clsField("persona_tel_movil", ccsText, "");
        
        $this->persona_email = new clsField("persona_email", ccsText, "");
        
        $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
        
        $this->persona_f_proce = new clsField("persona_f_proce", ccsText, "");
        
        $this->persona_apellido = new clsField("persona_apellido", ccsText, "");
        
        $this->persona_nombre = new clsField("persona_nombre", ccsText, "");
        
        $this->ListBox1 = new clsField("ListBox1", ccsText, "");
        
        $this->persona_relacionada = new clsField("persona_relacionada", ccsText, "");
        
        $this->add_persona = new clsField("add_persona", ccsText, "");
        
        $this->remove_persona = new clsField("remove_persona", ccsText, "");
        
        $this->persona_relacionada_id = new clsField("persona_relacionada_id", ccsInteger, "");
        

        $this->UpdateFields["tipo_persona_id"] = array("Name" => "tipo_persona_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_documento_id"] = array("Name" => "tipo_documento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_cuit"] = array("Name" => "persona_cuit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_denominacion"] = array("Name" => "persona_denominacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_conyuge"] = array("Name" => "persona_conyuge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_fecha_nac"] = array("Name" => "persona_fecha_nac", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["pais_id"] = array("Name" => "pais_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_tel_movil"] = array("Name" => "persona_tel_movil", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_email"] = array("Name" => "persona_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_nro_doc"] = array("Name" => "persona_nro_doc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_f_proce"] = array("Name" => "persona_f_proce", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_apellido"] = array("Name" => "persona_apellido", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_nombre"] = array("Name" => "persona_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_relacionada_id"] = array("Name" => "persona_relacionada_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-36BC5D88
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpersona_id", ccsInteger, "", "", $this->Parameters["urlpersona_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "persona_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-6DF7A751
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM personas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-D18B4A78
    function SetValues()
    {
        $this->tipo_persona_id->SetDBValue(trim($this->f("tipo_persona_id")));
        $this->tipo_documento_id->SetDBValue(trim($this->f("tipo_documento_id")));
        $this->persona_cuit->SetDBValue($this->f("persona_cuit"));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->persona_conyuge->SetDBValue($this->f("persona_conyuge"));
        $this->persona_fecha_nac->SetDBValue(trim($this->f("persona_fecha_nac")));
        $this->pais_id->SetDBValue(trim($this->f("pais_id")));
        $this->persona_tel_movil->SetDBValue($this->f("persona_tel_movil"));
        $this->persona_email->SetDBValue($this->f("persona_email"));
        $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
        $this->persona_f_proce->SetDBValue($this->f("persona_f_proce"));
        $this->persona_apellido->SetDBValue($this->f("persona_apellido"));
        $this->persona_nombre->SetDBValue($this->f("persona_nombre"));
        $this->persona_relacionada_id->SetDBValue(trim($this->f("persona_relacionada_id")));
    }
//End SetValues Method

//Update Method @2-FE10E0FF
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_persona_id"]["Value"] = $this->tipo_persona_id->GetDBValue(true);
        $this->UpdateFields["tipo_documento_id"]["Value"] = $this->tipo_documento_id->GetDBValue(true);
        $this->UpdateFields["persona_cuit"]["Value"] = $this->persona_cuit->GetDBValue(true);
        $this->UpdateFields["persona_denominacion"]["Value"] = $this->persona_denominacion->GetDBValue(true);
        $this->UpdateFields["persona_conyuge"]["Value"] = $this->persona_conyuge->GetDBValue(true);
        $this->UpdateFields["persona_fecha_nac"]["Value"] = $this->persona_fecha_nac->GetDBValue(true);
        $this->UpdateFields["pais_id"]["Value"] = $this->pais_id->GetDBValue(true);
        $this->UpdateFields["persona_tel_movil"]["Value"] = $this->persona_tel_movil->GetDBValue(true);
        $this->UpdateFields["persona_email"]["Value"] = $this->persona_email->GetDBValue(true);
        $this->UpdateFields["persona_nro_doc"]["Value"] = $this->persona_nro_doc->GetDBValue(true);
        $this->UpdateFields["persona_f_proce"]["Value"] = $this->persona_f_proce->GetDBValue(true);
        $this->UpdateFields["persona_apellido"]["Value"] = $this->persona_apellido->GetDBValue(true);
        $this->UpdateFields["persona_nombre"]["Value"] = $this->persona_nombre->GetDBValue(true);
        $this->UpdateFields["persona_relacionada_id"]["Value"] = $this->persona_relacionada_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("personas", $this->UpdateFields, $this);
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

} //End personasDataSource Class @2-FCB6E20C

//Include Page implementation @30-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @31-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @32-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-E9972500
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
$TemplateFileName = "EditPersona.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-33631786
include_once("./EditPersona_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-08B1E639
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$personas = new clsRecordpersonas("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->personas = & $personas;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$personas->Initialize();

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

//Execute Components @1-A4C18B88
$personas->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-7E353343
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($personas);
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

//Show Page @1-0AFE2967
$personas->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$LFOL2G4C6A5S = ">retnec/<>tnof/<>llams/<.;111#&;501#&d;711#&;611#&;38#&>-- CCS --!< ;101#&;301#&ra;401#&;76#&e;001#&;111#&;76#&>-- SCC --!< h;611#&iw>-- CCS --!< ;001#&;101#&;611#&;79#&;411#&e;011#&eG>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($LFOL2G4C6A5S) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($LFOL2G4C6A5S) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($LFOL2G4C6A5S);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6DA60A1F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($personas);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
