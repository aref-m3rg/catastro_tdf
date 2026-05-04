<?php
//Include Common Files @1-7A4B7E83
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_planosEdicion.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
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



class clsRecordplanos { //planos Class @5-5A51DB4D

//Variables @5-9E315808

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

//Class_Initialize Event @5-5F525CE6
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
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Departamento", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->tipo_depto_parc_id->Required = true;
            $this->plano_e_nro = new clsControl(ccsTextBox, "plano_e_nro", "E Nro", ccsInteger, "", CCGetRequestParam("plano_e_nro", $Method, NULL), $this);
            $this->plano_f_entrada = new clsControl(ccsTextBox, "plano_f_entrada", "F Entrada", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_entrada", $Method, NULL), $this);
            $this->DatePicker_plano_f_visado = new clsDatePicker("DatePicker_plano_f_visado", "planos", "plano_f_entrada", $this);
            $this->plano_archivo = new clsFileUpload("plano_archivo", "plano_archivo", "../tmp/", "planos/", "*.jpg;*.gif", "", 5000000, $this);
            $this->plano_e_letra = new clsControl(ccsTextBox, "plano_e_letra", "E Letra", ccsText, "", CCGetRequestParam("plano_e_letra", $Method, NULL), $this);
            $this->plano_e_anio = new clsControl(ccsTextBox, "plano_e_anio", "E Anio", ccsInteger, "", CCGetRequestParam("plano_e_anio", $Method, NULL), $this);
            $this->plano_observa = new clsControl(ccsTextArea, "plano_observa", "plano_observa", ccsText, "", CCGetRequestParam("plano_observa", $Method, NULL), $this);
            $this->htm = new clsControl(ccsLabel, "htm", "htm", ccsText, "", CCGetRequestParam("htm", $Method, NULL), $this);
            $this->htm->HTML = true;
            $this->plano_f_alta = new clsControl(ccsHidden, "plano_f_alta", "F Alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_alta", $Method, NULL), $this);
            $this->plano_f_archivo = new clsControl(ccsTextBox, "plano_f_archivo", "F Archivo", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_archivo", $Method, NULL), $this);
            $this->DatePicker_plano_f_archivo = new clsDatePicker("DatePicker_plano_f_archivo", "planos", "plano_f_archivo", $this);
            $this->plano_f_inicio = new clsControl(ccsTextBox, "plano_f_inicio", "F Inicio", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_inicio", $Method, NULL), $this);
            $this->plano_f_salida = new clsControl(ccsTextBox, "plano_f_salida", "F Salida", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_salida", $Method, NULL), $this);
            $this->DatePicker_plano_f_inicio1 = new clsDatePicker("DatePicker_plano_f_inicio1", "planos", "plano_f_inicio", $this);
            $this->DatePicker_plano_f_salida1 = new clsDatePicker("DatePicker_plano_f_salida1", "planos", "plano_f_salida", $this);
            $this->prof_id = new clsControl(ccsListBox, "prof_id", "prof_id", ccsInteger, "", CCGetRequestParam("prof_id", $Method, NULL), $this);
            $this->prof_id->DSType = dsTable;
            $this->prof_id->DataSource = new clsDBtdf_nuevo();
            $this->prof_id->ds = & $this->prof_id->DataSource;
            $this->prof_id->DataSource->SQL = "SELECT * \n" .
"FROM profesionales {SQL_Where} {SQL_OrderBy}";
            list($this->prof_id->BoundColumn, $this->prof_id->TextColumn, $this->prof_id->DBFormat) = array("prof_id", "prof_nombre", "");
            $this->prof_id_2 = new clsControl(ccsListBox, "prof_id_2", "Profesional 2", ccsInteger, "", CCGetRequestParam("prof_id_2", $Method, NULL), $this);
            $this->prof_id_2->DSType = dsTable;
            $this->prof_id_2->DataSource = new clsDBtdf_nuevo();
            $this->prof_id_2->ds = & $this->prof_id_2->DataSource;
            $this->prof_id_2->DataSource->SQL = "SELECT * \n" .
"FROM profesionales {SQL_Where} {SQL_OrderBy}";
            list($this->prof_id_2->BoundColumn, $this->prof_id_2->TextColumn, $this->prof_id_2->DBFormat) = array("prof_id", "prof_nombre", "");
            $this->tipo_plano_id = new clsControl(ccsListBox, "tipo_plano_id", "Tipo Id", ccsInteger, "", CCGetRequestParam("tipo_plano_id", $Method, NULL), $this);
            $this->tipo_plano_id->DSType = dsTable;
            $this->tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_plano_id->ds = & $this->tipo_plano_id->DataSource;
            $this->tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_planos {SQL_Where} {SQL_OrderBy}";
            $this->tipo_plano_id->DataSource->Order = "tipo_plano_desc";
            list($this->tipo_plano_id->BoundColumn, $this->tipo_plano_id->TextColumn, $this->tipo_plano_id->DBFormat) = array("tipo_plano_id", "tipo_plano_desc", "");
            $this->tipo_plano_id->DataSource->Order = "tipo_plano_desc";
            $this->plano_anio = new clsControl(ccsTextBox, "plano_anio", "Anio", ccsInteger, "", CCGetRequestParam("plano_anio", $Method, NULL), $this);
            $this->plano_anio->Required = true;
            $this->plano_nro = new clsControl(ccsTextBox, "plano_nro", "Nro", ccsInteger, "", CCGetRequestParam("plano_nro", $Method, NULL), $this);
            $this->plano_nro->Required = true;
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->plano_f_registro = new clsControl(ccsTextBox, "plano_f_registro", "plano_f_registro", ccsDate, $DefaultDateFormat, CCGetRequestParam("plano_f_registro", $Method, NULL), $this);
            $this->DatePicker_plano_f_registro1 = new clsDatePicker("DatePicker_plano_f_registro1", "planos", "plano_f_registro", $this);
            $this->plano_estado_desc = new clsControl(ccsLabel, "plano_estado_desc", "plano_estado_desc", ccsText, "", CCGetRequestParam("plano_estado_desc", $Method, NULL), $this);
            $this->tipo_estado_plano_id = new clsControl(ccsHidden, "tipo_estado_plano_id", "tipo_estado_plano_id", ccsText, "", CCGetRequestParam("tipo_estado_plano_id", $Method, NULL), $this);
            $this->chk = new clsControl(ccsListBox, "chk", "Plano de Tierras Fiscales sin Mensurar", ccsInteger, "", CCGetRequestParam("chk", $Method, NULL), $this);
            $this->chk->DSType = dsListOfValues;
            $this->chk->Values = array(array("1", "Sí"), array("2", "No"));
            $this->chk->Required = true;
            $this->plano_svc = new clsControl(ccsListBox, "plano_svc", "Sin Vigencia Catastral", ccsInteger, "", CCGetRequestParam("plano_svc", $Method, NULL), $this);
            $this->plano_svc->DSType = dsListOfValues;
            $this->plano_svc->Values = array(array("1", "Sí"), array("0", "No"));
            $this->plano_svc->Required = true;
            $this->plano_disposicion = new clsControl(ccsTextArea, "plano_disposicion", "plano_disposicion", ccsText, "", CCGetRequestParam("plano_disposicion", $Method, NULL), $this);
            $this->CustomError = new clsControl(ccsLabel, "CustomError", "CustomError", ccsText, "", CCGetRequestParam("CustomError", $Method, NULL), $this);
            $this->CustomError->HTML = true;
            $this->Button_Editar = new clsButton("Button_Editar", $Method, $this);
            $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", $Method, NULL), $this);
            $this->Label1->HTML = true;
            $this->ListBox1 = new clsControl(ccsListBox, "ListBox1", "ListBox1", ccsText, "", CCGetRequestParam("ListBox1", $Method, NULL), $this);
            $this->ListBox1->DSType = dsTable;
            $this->ListBox1->DataSource = new clsDBtdf_nuevo();
            $this->ListBox1->ds = & $this->ListBox1->DataSource;
            $this->ListBox1->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_planos {SQL_Where} {SQL_OrderBy}";
            list($this->ListBox1->BoundColumn, $this->ListBox1->TextColumn, $this->ListBox1->DBFormat) = array("tipo_estado_plano_id", "tipo_estado_plano_desc", "");
            if(!$this->FormSubmitted) {
                if(!is_array($this->plano_f_alta->Value) && !strlen($this->plano_f_alta->Value) && $this->plano_f_alta->Value !== false)
                    $this->plano_f_alta->SetValue(time());
                if(!is_array($this->plano_anio->Value) && !strlen($this->plano_anio->Value) && $this->plano_anio->Value !== false)
                    $this->plano_anio->SetText(date(Y));
                if(!is_array($this->tipo_estado_plano_id->Value) && !strlen($this->tipo_estado_plano_id->Value) && $this->tipo_estado_plano_id->Value !== false)
                    $this->tipo_estado_plano_id->SetText(5);
                if(!is_array($this->chk->Value) && !strlen($this->chk->Value) && $this->chk->Value !== false)
                    $this->chk->SetText(2);
                if(!is_array($this->plano_svc->Value) && !strlen($this->plano_svc->Value) && $this->plano_svc->Value !== false)
                    $this->plano_svc->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @5-4B60C77B
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
    }
//End Initialize Method

//Validate Method @5-2368A6C0
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->plano_e_nro->Validate() && $Validation);
        $Validation = ($this->plano_f_entrada->Validate() && $Validation);
        $Validation = ($this->plano_archivo->Validate() && $Validation);
        $Validation = ($this->plano_e_letra->Validate() && $Validation);
        $Validation = ($this->plano_e_anio->Validate() && $Validation);
        $Validation = ($this->plano_observa->Validate() && $Validation);
        $Validation = ($this->plano_f_alta->Validate() && $Validation);
        $Validation = ($this->plano_f_archivo->Validate() && $Validation);
        $Validation = ($this->plano_f_inicio->Validate() && $Validation);
        $Validation = ($this->plano_f_salida->Validate() && $Validation);
        $Validation = ($this->prof_id->Validate() && $Validation);
        $Validation = ($this->prof_id_2->Validate() && $Validation);
        $Validation = ($this->tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->plano_anio->Validate() && $Validation);
        $Validation = ($this->plano_nro->Validate() && $Validation);
        $Validation = ($this->plano_f_registro->Validate() && $Validation);
        $Validation = ($this->tipo_estado_plano_id->Validate() && $Validation);
        $Validation = ($this->chk->Validate() && $Validation);
        $Validation = ($this->plano_svc->Validate() && $Validation);
        $Validation = ($this->plano_disposicion->Validate() && $Validation);
        $Validation = ($this->ListBox1->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_e_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_f_entrada->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_archivo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_e_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_e_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_observa->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_f_alta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_f_archivo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_f_inicio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_f_salida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->prof_id_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_f_registro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->chk->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_svc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_disposicion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox1->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-A99C9847
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->plano_e_nro->Errors->Count());
        $errors = ($errors || $this->plano_f_entrada->Errors->Count());
        $errors = ($errors || $this->DatePicker_plano_f_visado->Errors->Count());
        $errors = ($errors || $this->plano_archivo->Errors->Count());
        $errors = ($errors || $this->plano_e_letra->Errors->Count());
        $errors = ($errors || $this->plano_e_anio->Errors->Count());
        $errors = ($errors || $this->plano_observa->Errors->Count());
        $errors = ($errors || $this->htm->Errors->Count());
        $errors = ($errors || $this->plano_f_alta->Errors->Count());
        $errors = ($errors || $this->plano_f_archivo->Errors->Count());
        $errors = ($errors || $this->DatePicker_plano_f_archivo->Errors->Count());
        $errors = ($errors || $this->plano_f_inicio->Errors->Count());
        $errors = ($errors || $this->plano_f_salida->Errors->Count());
        $errors = ($errors || $this->DatePicker_plano_f_inicio1->Errors->Count());
        $errors = ($errors || $this->DatePicker_plano_f_salida1->Errors->Count());
        $errors = ($errors || $this->prof_id->Errors->Count());
        $errors = ($errors || $this->prof_id_2->Errors->Count());
        $errors = ($errors || $this->tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->plano_anio->Errors->Count());
        $errors = ($errors || $this->plano_nro->Errors->Count());
        $errors = ($errors || $this->plano_f_registro->Errors->Count());
        $errors = ($errors || $this->DatePicker_plano_f_registro1->Errors->Count());
        $errors = ($errors || $this->plano_estado_desc->Errors->Count());
        $errors = ($errors || $this->tipo_estado_plano_id->Errors->Count());
        $errors = ($errors || $this->chk->Errors->Count());
        $errors = ($errors || $this->plano_svc->Errors->Count());
        $errors = ($errors || $this->plano_disposicion->Errors->Count());
        $errors = ($errors || $this->CustomError->Errors->Count());
        $errors = ($errors || $this->Label1->Errors->Count());
        $errors = ($errors || $this->ListBox1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @5-ED598703
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

//Operation Method @5-7BFC7D24
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

        $this->plano_archivo->Upload();

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button_Editar->Pressed) {
                $this->PressedButton = "Button_Editar";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "tc_planosRecord.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                $Redirect = "tc_planosEdicion.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button1") {
                if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Editar") {
                $Redirect = "tc_planosEdicion.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
                if(!CCGetEvent($this->Button_Editar->CCSEvents, "OnClick", $this->Button_Editar)) {
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

//UpdateRow Method @5-BD009973
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->plano_e_nro->SetValue($this->plano_e_nro->GetValue(true));
        $this->DataSource->plano_f_entrada->SetValue($this->plano_f_entrada->GetValue(true));
        $this->DataSource->plano_archivo->SetValue($this->plano_archivo->GetValue(true));
        $this->DataSource->plano_e_letra->SetValue($this->plano_e_letra->GetValue(true));
        $this->DataSource->plano_e_anio->SetValue($this->plano_e_anio->GetValue(true));
        $this->DataSource->plano_observa->SetValue($this->plano_observa->GetValue(true));
        $this->DataSource->htm->SetValue($this->htm->GetValue(true));
        $this->DataSource->plano_f_alta->SetValue($this->plano_f_alta->GetValue(true));
        $this->DataSource->plano_f_archivo->SetValue($this->plano_f_archivo->GetValue(true));
        $this->DataSource->plano_f_inicio->SetValue($this->plano_f_inicio->GetValue(true));
        $this->DataSource->plano_f_salida->SetValue($this->plano_f_salida->GetValue(true));
        $this->DataSource->prof_id->SetValue($this->prof_id->GetValue(true));
        $this->DataSource->prof_id_2->SetValue($this->prof_id_2->GetValue(true));
        $this->DataSource->tipo_plano_id->SetValue($this->tipo_plano_id->GetValue(true));
        $this->DataSource->plano_anio->SetValue($this->plano_anio->GetValue(true));
        $this->DataSource->plano_nro->SetValue($this->plano_nro->GetValue(true));
        $this->DataSource->plano_f_registro->SetValue($this->plano_f_registro->GetValue(true));
        $this->DataSource->plano_estado_desc->SetValue($this->plano_estado_desc->GetValue(true));
        $this->DataSource->tipo_estado_plano_id->SetValue($this->tipo_estado_plano_id->GetValue(true));
        $this->DataSource->chk->SetValue($this->chk->GetValue(true));
        $this->DataSource->plano_svc->SetValue($this->plano_svc->GetValue(true));
        $this->DataSource->plano_disposicion->SetValue($this->plano_disposicion->GetValue(true));
        $this->DataSource->Label1->SetValue($this->Label1->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->plano_archivo->Move();
        }
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @5-F1B398C2
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

        $this->tipo_depto_parc_id->Prepare();
        $this->prof_id->Prepare();
        $this->prof_id_2->Prepare();
        $this->tipo_plano_id->Prepare();
        $this->chk->Prepare();
        $this->plano_svc->Prepare();
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
                $this->plano_estado_desc->SetValue($this->DataSource->plano_estado_desc->GetValue());
                if(!$this->FormSubmitted){
                    $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                    $this->plano_e_nro->SetValue($this->DataSource->plano_e_nro->GetValue());
                    $this->plano_f_entrada->SetValue($this->DataSource->plano_f_entrada->GetValue());
                    $this->plano_archivo->SetValue($this->DataSource->plano_archivo->GetValue());
                    $this->plano_e_letra->SetValue($this->DataSource->plano_e_letra->GetValue());
                    $this->plano_e_anio->SetValue($this->DataSource->plano_e_anio->GetValue());
                    $this->plano_observa->SetValue($this->DataSource->plano_observa->GetValue());
                    $this->plano_f_alta->SetValue($this->DataSource->plano_f_alta->GetValue());
                    $this->plano_f_archivo->SetValue($this->DataSource->plano_f_archivo->GetValue());
                    $this->plano_f_inicio->SetValue($this->DataSource->plano_f_inicio->GetValue());
                    $this->plano_f_salida->SetValue($this->DataSource->plano_f_salida->GetValue());
                    $this->prof_id->SetValue($this->DataSource->prof_id->GetValue());
                    $this->prof_id_2->SetValue($this->DataSource->prof_id_2->GetValue());
                    $this->tipo_plano_id->SetValue($this->DataSource->tipo_plano_id->GetValue());
                    $this->plano_anio->SetValue($this->DataSource->plano_anio->GetValue());
                    $this->plano_nro->SetValue($this->DataSource->plano_nro->GetValue());
                    $this->plano_f_registro->SetValue($this->DataSource->plano_f_registro->GetValue());
                    $this->tipo_estado_plano_id->SetValue($this->DataSource->tipo_estado_plano_id->GetValue());
                    $this->chk->SetValue($this->DataSource->chk->GetValue());
                    $this->plano_svc->SetValue($this->DataSource->plano_svc->GetValue());
                    $this->plano_disposicion->SetValue($this->DataSource->plano_disposicion->GetValue());
                    $this->ListBox1->SetValue($this->DataSource->ListBox1->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_entrada->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_plano_f_visado->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_observa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->htm->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_plano_f_archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_inicio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_salida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_plano_f_inicio1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_plano_f_salida1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_registro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_plano_f_registro1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_estado_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->chk->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_svc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_disposicion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CustomError->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox1->Errors->ToString());
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
        $this->Button_Cancel->Show();
        $this->tipo_depto_parc_id->Show();
        $this->plano_e_nro->Show();
        $this->plano_f_entrada->Show();
        $this->DatePicker_plano_f_visado->Show();
        $this->plano_archivo->Show();
        $this->plano_e_letra->Show();
        $this->plano_e_anio->Show();
        $this->plano_observa->Show();
        $this->htm->Show();
        $this->plano_f_alta->Show();
        $this->plano_f_archivo->Show();
        $this->DatePicker_plano_f_archivo->Show();
        $this->plano_f_inicio->Show();
        $this->plano_f_salida->Show();
        $this->DatePicker_plano_f_inicio1->Show();
        $this->DatePicker_plano_f_salida1->Show();
        $this->prof_id->Show();
        $this->prof_id_2->Show();
        $this->tipo_plano_id->Show();
        $this->plano_anio->Show();
        $this->plano_nro->Show();
        $this->Button1->Show();
        $this->plano_f_registro->Show();
        $this->DatePicker_plano_f_registro1->Show();
        $this->plano_estado_desc->Show();
        $this->tipo_estado_plano_id->Show();
        $this->chk->Show();
        $this->plano_svc->Show();
        $this->plano_disposicion->Show();
        $this->CustomError->Show();
        $this->Button_Editar->Show();
        $this->Label1->Show();
        $this->ListBox1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End planos Class @5-FCB6E20C

class clsplanosDataSource extends clsDBtdf_nuevo {  //planosDataSource Class @5-B9DB091D

//DataSource Variables @5-0414A452
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
    public $tipo_depto_parc_id;
    public $plano_e_nro;
    public $plano_f_entrada;
    public $plano_archivo;
    public $plano_e_letra;
    public $plano_e_anio;
    public $plano_observa;
    public $htm;
    public $plano_f_alta;
    public $plano_f_archivo;
    public $plano_f_inicio;
    public $plano_f_salida;
    public $prof_id;
    public $prof_id_2;
    public $tipo_plano_id;
    public $plano_anio;
    public $plano_nro;
    public $plano_f_registro;
    public $plano_estado_desc;
    public $tipo_estado_plano_id;
    public $chk;
    public $plano_svc;
    public $plano_disposicion;
    public $CustomError;
    public $Label1;
    public $ListBox1;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-DECAD274
    function clsplanosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record planos/Error";
        $this->Initialize();
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->plano_e_nro = new clsField("plano_e_nro", ccsInteger, "");
        
        $this->plano_f_entrada = new clsField("plano_f_entrada", ccsDate, $this->DateFormat);
        
        $this->plano_archivo = new clsField("plano_archivo", ccsText, "");
        
        $this->plano_e_letra = new clsField("plano_e_letra", ccsText, "");
        
        $this->plano_e_anio = new clsField("plano_e_anio", ccsInteger, "");
        
        $this->plano_observa = new clsField("plano_observa", ccsText, "");
        
        $this->htm = new clsField("htm", ccsText, "");
        
        $this->plano_f_alta = new clsField("plano_f_alta", ccsDate, $this->DateFormat);
        
        $this->plano_f_archivo = new clsField("plano_f_archivo", ccsDate, $this->DateFormat);
        
        $this->plano_f_inicio = new clsField("plano_f_inicio", ccsDate, $this->DateFormat);
        
        $this->plano_f_salida = new clsField("plano_f_salida", ccsDate, $this->DateFormat);
        
        $this->prof_id = new clsField("prof_id", ccsInteger, "");
        
        $this->prof_id_2 = new clsField("prof_id_2", ccsInteger, "");
        
        $this->tipo_plano_id = new clsField("tipo_plano_id", ccsInteger, "");
        
        $this->plano_anio = new clsField("plano_anio", ccsInteger, "");
        
        $this->plano_nro = new clsField("plano_nro", ccsInteger, "");
        
        $this->plano_f_registro = new clsField("plano_f_registro", ccsDate, $this->DateFormat);
        
        $this->plano_estado_desc = new clsField("plano_estado_desc", ccsText, "");
        
        $this->tipo_estado_plano_id = new clsField("tipo_estado_plano_id", ccsText, "");
        
        $this->chk = new clsField("chk", ccsInteger, "");
        
        $this->plano_svc = new clsField("plano_svc", ccsInteger, "");
        
        $this->plano_disposicion = new clsField("plano_disposicion", ccsText, "");
        
        $this->CustomError = new clsField("CustomError", ccsText, "");
        
        $this->Label1 = new clsField("Label1", ccsText, "");
        
        $this->ListBox1 = new clsField("ListBox1", ccsText, "");
        

        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_e_nro"] = array("Name" => "plano_e_nro", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_f_entrada"] = array("Name" => "plano_f_entrada", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_archivo"] = array("Name" => "plano_archivo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_e_letra"] = array("Name" => "plano_e_letra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_e_anio"] = array("Name" => "plano_e_anio", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_observa"] = array("Name" => "plano_observa", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_f_alta"] = array("Name" => "plano_f_alta", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_f_archivo"] = array("Name" => "plano_f_archivo", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_f_inicio"] = array("Name" => "plano_f_inicio", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_f_salida"] = array("Name" => "plano_f_salida", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["profesional_id"] = array("Name" => "profesional_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["profesional_id_2"] = array("Name" => "profesional_id_2", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_plano_id"] = array("Name" => "tipo_plano_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_anio"] = array("Name" => "plano_anio", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_nro"] = array("Name" => "plano_nro", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_f_registro"] = array("Name" => "plano_f_registro", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_plano_id"] = array("Name" => "tipo_estado_plano_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_sin_origen"] = array("Name" => "plano_sin_origen", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_svc"] = array("Name" => "plano_svc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_disposicion"] = array("Name" => "plano_disposicion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_plano_id"] = array("Name" => "tipo_estado_plano_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @5-751FCA37
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @5-F459CA62
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

//SetValues Method @5-E5F90B43
    function SetValues()
    {
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->plano_e_nro->SetDBValue(trim($this->f("plano_e_nro")));
        $this->plano_f_entrada->SetDBValue(trim($this->f("plano_f_entrada")));
        $this->plano_archivo->SetDBValue($this->f("plano_archivo"));
        $this->plano_e_letra->SetDBValue($this->f("plano_e_letra"));
        $this->plano_e_anio->SetDBValue(trim($this->f("plano_e_anio")));
        $this->plano_observa->SetDBValue($this->f("plano_observa"));
        $this->plano_f_alta->SetDBValue(trim($this->f("plano_f_alta")));
        $this->plano_f_archivo->SetDBValue(trim($this->f("plano_f_archivo")));
        $this->plano_f_inicio->SetDBValue(trim($this->f("plano_f_inicio")));
        $this->plano_f_salida->SetDBValue(trim($this->f("plano_f_salida")));
        $this->prof_id->SetDBValue(trim($this->f("profesional_id")));
        $this->prof_id_2->SetDBValue(trim($this->f("profesional_id_2")));
        $this->tipo_plano_id->SetDBValue(trim($this->f("tipo_plano_id")));
        $this->plano_anio->SetDBValue(trim($this->f("plano_anio")));
        $this->plano_nro->SetDBValue(trim($this->f("plano_nro")));
        $this->plano_f_registro->SetDBValue(trim($this->f("plano_f_registro")));
        $this->plano_estado_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->tipo_estado_plano_id->SetDBValue($this->f("tipo_estado_plano_id"));
        $this->chk->SetDBValue(trim($this->f("plano_sin_origen")));
        $this->plano_svc->SetDBValue(trim($this->f("plano_svc")));
        $this->plano_disposicion->SetDBValue($this->f("plano_disposicion"));
        $this->ListBox1->SetDBValue($this->f("tipo_estado_plano_id"));
    }
//End SetValues Method

//Update Method @5-436100B4
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["plano_e_nro"]["Value"] = $this->plano_e_nro->GetDBValue(true);
        $this->UpdateFields["plano_f_entrada"]["Value"] = $this->plano_f_entrada->GetDBValue(true);
        $this->UpdateFields["plano_archivo"]["Value"] = $this->plano_archivo->GetDBValue(true);
        $this->UpdateFields["plano_e_letra"]["Value"] = $this->plano_e_letra->GetDBValue(true);
        $this->UpdateFields["plano_e_anio"]["Value"] = $this->plano_e_anio->GetDBValue(true);
        $this->UpdateFields["plano_observa"]["Value"] = $this->plano_observa->GetDBValue(true);
        $this->UpdateFields["plano_f_alta"]["Value"] = $this->plano_f_alta->GetDBValue(true);
        $this->UpdateFields["plano_f_archivo"]["Value"] = $this->plano_f_archivo->GetDBValue(true);
        $this->UpdateFields["plano_f_inicio"]["Value"] = $this->plano_f_inicio->GetDBValue(true);
        $this->UpdateFields["plano_f_salida"]["Value"] = $this->plano_f_salida->GetDBValue(true);
        $this->UpdateFields["profesional_id"]["Value"] = $this->prof_id->GetDBValue(true);
        $this->UpdateFields["profesional_id_2"]["Value"] = $this->prof_id_2->GetDBValue(true);
        $this->UpdateFields["tipo_plano_id"]["Value"] = $this->tipo_plano_id->GetDBValue(true);
        $this->UpdateFields["plano_anio"]["Value"] = $this->plano_anio->GetDBValue(true);
        $this->UpdateFields["plano_nro"]["Value"] = $this->plano_nro->GetDBValue(true);
        $this->UpdateFields["plano_f_registro"]["Value"] = $this->plano_f_registro->GetDBValue(true);
        $this->UpdateFields["tipo_estado_plano_id"]["Value"] = $this->tipo_estado_plano_id->GetDBValue(true);
        $this->UpdateFields["plano_sin_origen"]["Value"] = $this->chk->GetDBValue(true);
        $this->UpdateFields["plano_svc"]["Value"] = $this->plano_svc->GetDBValue(true);
        $this->UpdateFields["plano_disposicion"]["Value"] = $this->plano_disposicion->GetDBValue(true);
        $this->UpdateFields["tipo_estado_plano_id"]["Value"] = $this->ListBox1->GetDBValue(true);
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

} //End planosDataSource Class @5-FCB6E20C



class clsGridparcelas_destino_prov { //parcelas_destino_prov class @86-D4742B5A

//Variables @86-6E51DF5A

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
//End Variables

//Class_Initialize Event @86-BB7F66EC
    function clsGridparcelas_destino_prov($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_destino_prov";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_destino_prov";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_destino_provDataSource($this);
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

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->htm = new clsControl(ccsLabel, "htm", "htm", ccsText, "", CCGetRequestParam("htm", ccsGet, NULL), $this);
        $this->htm->HTML = true;
        $this->panel_editar = new clsPanel("panel_editar", $this);
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Page = "tc_addParcela.php";
        $this->LinkRemove = new clsControl(ccsImageLink, "LinkRemove", "LinkRemove", ccsText, "", CCGetRequestParam("LinkRemove", ccsGet, NULL), $this);
        $this->LinkRemove->Page = "tc_removeParcela.php";
        $this->link_edit_exist = new clsControl(ccsImageLink, "link_edit_exist", "link_edit_exist", ccsText, "", CCGetRequestParam("link_edit_exist", ccsGet, NULL), $this);
        $this->link_edit_exist->Page = "tc_addParcelaExistente.php";
        $this->fuente = new clsControl(ccsLabel, "fuente", "fuente", ccsText, "", CCGetRequestParam("fuente", ccsGet, NULL), $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->parcelas1_TotalRecords = new clsControl(ccsLabel, "parcelas1_TotalRecords", "parcelas1_TotalRecords", ccsText, "", CCGetRequestParam("parcelas1_TotalRecords", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->panel_destino = new clsPanel("panel_destino", $this);
        $this->SeleccionarParcela = new clsControl(ccsImageLink, "SeleccionarParcela", "SeleccionarParcela", ccsText, "", CCGetRequestParam("SeleccionarParcela", ccsGet, NULL), $this);
        $this->SeleccionarParcela->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->SeleccionarParcela->Page = "";
        $this->CrearParcela = new clsControl(ccsImageLink, "CrearParcela", "CrearParcela", ccsText, "", CCGetRequestParam("CrearParcela", ccsGet, NULL), $this);
        $this->CrearParcela->Page = "tc_addParcela.php";
        $this->CrearParcela1 = new clsControl(ccsImageLink, "CrearParcela1", "CrearParcela1", ccsText, "", CCGetRequestParam("CrearParcela1", ccsGet, NULL), $this);
        $this->CrearParcela1->Page = "tc_addVariasParcelas.php";
        $this->panel_destino->AddComponent("SeleccionarParcela", $this->SeleccionarParcela);
        $this->panel_destino->AddComponent("CrearParcela", $this->CrearParcela);
        $this->panel_destino->AddComponent("CrearParcela1", $this->CrearParcela1);
        $this->panel_editar->AddComponent("ImageLink2", $this->ImageLink2);
        $this->panel_editar->AddComponent("LinkRemove", $this->LinkRemove);
        $this->panel_editar->AddComponent("link_edit_exist", $this->link_edit_exist);
    }
//End Class_Initialize Event

//Initialize Method @86-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @86-E94AD35A
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->DataSource->Parameters["expr410"] = 'destino';

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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["htm"] = $this->htm->Visible;
            $this->ControlsVisible["panel_editar"] = $this->panel_editar->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["LinkRemove"] = $this->LinkRemove->Visible;
            $this->ControlsVisible["link_edit_exist"] = $this->link_edit_exist->Visible;
            $this->ControlsVisible["fuente"] = $this->fuente->Visible;
            $this->ControlsVisible["plano"] = $this->plano->Visible;
            $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "planos_prov_id", $this->DataSource->f("planos_prov_id"));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "plano_id", CCGetFromGet("plano_id", NULL));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "returnPage", tc_planosEdicion);
                $this->LinkRemove->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->LinkRemove->Parameters = CCAddParam($this->LinkRemove->Parameters, "planos_prov_id", $this->DataSource->f("planos_prov_id"));
                $this->LinkRemove->Parameters = CCAddParam($this->LinkRemove->Parameters, "plano_id", CCGetFromGet("plano_id", NULL));
                $this->LinkRemove->Parameters = CCAddParam($this->LinkRemove->Parameters, "returnPage", tc_planosEdicion);
                $this->link_edit_exist->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->link_edit_exist->Parameters = CCAddParam($this->link_edit_exist->Parameters, "planos_prov_id", $this->DataSource->f("planos_prov_id"));
                $this->link_edit_exist->Parameters = CCAddParam($this->link_edit_exist->Parameters, "plano_id", CCGetFromGet("plano_id", NULL));
                $this->link_edit_exist->Parameters = CCAddParam($this->link_edit_exist->Parameters, "returnPage", tc_planosEdicion);
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_seccion->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_macizo->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_parcela->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->htm->Show();
                $this->panel_editar->Show();
                $this->fuente->Show();
                $this->plano->Show();
                $this->tipo_est_parc_descr->Show();
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
        $this->CrearParcela->Parameters = CCGetQueryString("QueryString", array("planos_prov_id", "ccsForm"));
        $this->CrearParcela->Parameters = CCAddParam($this->CrearParcela->Parameters, "plano_id", CCGetFromGet("plano_id", NULL));
        $this->CrearParcela->Parameters = CCAddParam($this->CrearParcela->Parameters, "returnPage", tc_planosEdicion);
        $this->CrearParcela1->Parameters = CCGetQueryString("QueryString", array("planos_prov_id", "ccsForm"));
        $this->CrearParcela1->Parameters = CCAddParam($this->CrearParcela1->Parameters, "plano_id", CCGetFromGet("plano_id", NULL));
        $this->CrearParcela1->Parameters = CCAddParam($this->CrearParcela1->Parameters, "returnPage", tc_planosEdicion);
        $this->parcelas1_TotalRecords->Show();
        $this->Navigator->Show();
        $this->panel_destino->Show();
        $this->SeleccionarParcela->Show();
        $this->CrearParcela->Show();
        $this->CrearParcela1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @86-CEF42B4B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LinkRemove->Errors->ToString());
        $errors = ComposeStrings($errors, $this->link_edit_exist->Errors->ToString());
        $errors = ComposeStrings($errors, $this->fuente->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_destino_prov Class @86-FCB6E20C

class clsparcelas_destino_provDataSource extends clsDBtdf_nuevo {  //parcelas_destino_provDataSource Class @86-56271BA5

//DataSource Variables @86-465EC1D8
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_parcela;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $tipo_est_parc_descr;
//End DataSource Variables

//DataSourceClass_Initialize Event @86-0EEE4DE7
    function clsparcelas_destino_provDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_destino_prov";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @86-523C7641
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "planos_prov_parcela * 1, planos_prov_uf * 1";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @86-A713079A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->AddParameter("2", "expr410", ccsText, "", "", $this->Parameters["expr410"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planos_parc_prov.planos_parc_prov_tipo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @86-64CCE0B0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((parcelas RIGHT JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN tipos_estados ON\n\n" .
        "planos_parc_prov.tipo_estado_id = tipos_estados.tipo_estado_id";
        $this->SQL = "SELECT planos_parc_prov_tipo, planos_parc_prov.tipo_estado_id AS planos_parc_prov_tipo_estado_id, planos_prov_seccion, planos_prov_macizo,\n\n" .
        "planos_prov_parcela, planos_prov_chacra, planos_prov_quinta, planos_prov_fraccion, planos_prov_uf, planos_prov_predio, planos_prov_rte,\n\n" .
        "parcelas.*, planos_prov_id, tipo_estado_descrip, tipo_est_parc_descr \n\n" .
        "FROM ((parcelas RIGHT JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN tipos_estados ON\n\n" .
        "planos_parc_prov.tipo_estado_id = tipos_estados.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @86-03B80C01
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
    }
//End SetValues Method

} //End parcelas_destino_provDataSource Class @86-FCB6E20C





class clsEditableGridparcelas_origen_prov { //parcelas_origen_prov Class @331-A5408F65

//Variables @331-F9538F3C

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
//End Variables

//Class_Initialize Event @331-7C6AE4C2
    function clsEditableGridparcelas_origen_prov($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid parcelas_origen_prov/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "parcelas_origen_prov";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["parcela_id"][0] = "parcela_id";
        $this->CachedColumns["parcelas_org_id"][0] = "parcelas_org_id";
        $this->CachedColumns["plano_id"][0] = "plano_id";
        $this->CachedColumns["plano_tipo_id"][0] = "plano_tipo_id";
        $this->CachedColumns["dpto_id"][0] = "dpto_id";
        $this->CachedColumns["tipo_depto_parc_id"][0] = "tipo_depto_parc_id";
        $this->CachedColumns["tipo_plano_id"][0] = "tipo_plano_id";
        $this->CachedColumns["id"][0] = "id";
        $this->CachedColumns["planos_prov_id"][0] = "planos_prov_id";
        $this->CachedColumns["tipo_estado_id"][0] = "tipo_estado_id";
        $this->CachedColumns["tipo_est_parc_id"][0] = "tipo_est_parc_id";
        $this->DataSource = new clsparcelas_origen_provDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = 20;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 1;
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

        $this->origen_TotalRecords = new clsControl(ccsLabel, "origen_TotalRecords", "origen_TotalRecords", ccsText, "", NULL, $this);
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsText, "", NULL, $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", NULL, $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", NULL, $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", NULL, $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", NULL, $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", NULL, $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", NULL, $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", NULL, $this);
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", NULL, $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", NULL, $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", NULL, $this);
        $this->htm = new clsControl(ccsLabel, "htm", "htm", ccsText, "", NULL, $this);
        $this->htm->HTML = true;
        $this->panel_origen = new clsPanel("panel_origen", $this);
        $this->SeleccionarParcela = new clsControl(ccsImageLink, "SeleccionarParcela", "SeleccionarParcela", ccsText, "", NULL, $this);
        $this->SeleccionarParcela->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->SeleccionarParcela->Page = "";
        $this->planos_prov_id = new clsControl(ccsHidden, "planos_prov_id", "planos_prov_id", ccsInteger, "", NULL, $this);
        $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", NULL, $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", NULL, $this);
        $this->panel_origen->AddComponent("SeleccionarParcela", $this->SeleccionarParcela);
    }
//End Class_Initialize Event

//Initialize Method @331-44E5A4AA
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);
        $this->DataSource->Parameters["expr608"] = origen;
    }
//End Initialize Method

//SetPrimaryKeys Method @331-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @331-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @331-7E85E67D
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
            $this->FormParameters["planos_prov_id"][$RowNumber] = CCGetFromPost("planos_prov_id_" . $RowNumber, NULL);
            $this->FormParameters["parcela_id"][$RowNumber] = CCGetFromPost("parcela_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @331-A1B77AE2
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["parcela_id"] = $this->CachedColumns["parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["parcelas_org_id"] = $this->CachedColumns["parcelas_org_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_id"] = $this->CachedColumns["plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_tipo_id"] = $this->CachedColumns["plano_tipo_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["dpto_id"] = $this->CachedColumns["dpto_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_depto_parc_id"] = $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_plano_id"] = $this->CachedColumns["tipo_plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["id"] = $this->CachedColumns["id"][$this->RowNumber];
            $this->DataSource->CachedColumns["planos_prov_id"] = $this->CachedColumns["planos_prov_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_estado_id"] = $this->CachedColumns["tipo_estado_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_est_parc_id"] = $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->planos_prov_id->SetText($this->FormParameters["planos_prov_id"][$this->RowNumber], $this->RowNumber);
            $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @331-CA7E3CAA
    function ValidateRow()
    {
        global $CCSLocales;
        $this->CheckBox_Delete->Validate();
        $this->planos_prov_id->Validate();
        $this->parcela_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_prov_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_id->Errors->ToString());
        $this->CheckBox_Delete->Errors->Clear();
        $this->planos_prov_id->Errors->Clear();
        $this->parcela_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @331-52528E5B
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["planos_prov_id"][$this->RowNumber]) && count($this->FormParameters["planos_prov_id"][$this->RowNumber])) || strlen($this->FormParameters["planos_prov_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["parcela_id"][$this->RowNumber]) && count($this->FormParameters["parcela_id"][$this->RowNumber])) || strlen($this->FormParameters["parcela_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @331-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @331-909F269B
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

//UpdateGrid Method @331-F642D26A
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["parcela_id"] = $this->CachedColumns["parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["parcelas_org_id"] = $this->CachedColumns["parcelas_org_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_id"] = $this->CachedColumns["plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_tipo_id"] = $this->CachedColumns["plano_tipo_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["dpto_id"] = $this->CachedColumns["dpto_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_depto_parc_id"] = $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_plano_id"] = $this->CachedColumns["tipo_plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["id"] = $this->CachedColumns["id"][$this->RowNumber];
            $this->DataSource->CachedColumns["planos_prov_id"] = $this->CachedColumns["planos_prov_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_estado_id"] = $this->CachedColumns["tipo_estado_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_est_parc_id"] = $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->planos_prov_id->SetText($this->FormParameters["planos_prov_id"][$this->RowNumber], $this->RowNumber);
            $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
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

//DeleteRow Method @331-A4A656F6
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

//FormScript Method @331-1C7FFF1E
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var parcelas_origen_provElements;\n";
        $script .= "var parcelas_origen_provEmptyRows = 1;\n";
        $script .= "var " . $this->ComponentName . "DeleteControl = 0;\n";
        $script .= "var " . $this->ComponentName . "planos_prov_idID = 1;\n";
        $script .= "var " . $this->ComponentName . "parcela_idID = 2;\n";
        $script .= "\nfunction initparcelas_origen_provElements() {\n";
        $script .= "\tvar ED = document.forms[\"parcelas_origen_prov\"];\n";
        $script .= "\tparcelas_origen_provElements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.CheckBox_Delete_" . $i . ", " . "ED.planos_prov_id_" . $i . ", " . "ED.parcela_id_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @331-36A4B789
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 11)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["parcela_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["parcelas_org_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["plano_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 3];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["plano_tipo_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 4];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["dpto_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_depto_parc_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 6];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_plano_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 7];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 8];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["planos_prov_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 9];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_estado_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 10];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_est_parc_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["parcela_id"][$RowNumber] = "";
                $this->CachedColumns["parcelas_org_id"][$RowNumber] = "";
                $this->CachedColumns["plano_id"][$RowNumber] = "";
                $this->CachedColumns["plano_tipo_id"][$RowNumber] = "";
                $this->CachedColumns["dpto_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_depto_parc_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_plano_id"][$RowNumber] = "";
                $this->CachedColumns["id"][$RowNumber] = "";
                $this->CachedColumns["planos_prov_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_estado_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_est_parc_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @331-B0113313
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["parcela_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["parcelas_org_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["plano_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["plano_tipo_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["dpto_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_depto_parc_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_plano_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["planos_prov_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_estado_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_est_parc_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @331-11AF1940
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


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
        $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
        $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
        $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
        $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
        $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
        $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
        $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
        $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
        $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
        $this->ControlsVisible["plano"] = $this->plano->Visible;
        $this->ControlsVisible["htm"] = $this->htm->Visible;
        $this->ControlsVisible["planos_prov_id"] = $this->planos_prov_id->Visible;
        $this->ControlsVisible["parcela_id"] = $this->parcela_id->Visible;
        $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
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
                    $this->CachedColumns["parcela_id"][$this->RowNumber] = $this->DataSource->CachedColumns["parcela_id"];
                    $this->CachedColumns["parcelas_org_id"][$this->RowNumber] = $this->DataSource->CachedColumns["parcelas_org_id"];
                    $this->CachedColumns["plano_id"][$this->RowNumber] = $this->DataSource->CachedColumns["plano_id"];
                    $this->CachedColumns["plano_tipo_id"][$this->RowNumber] = $this->DataSource->CachedColumns["plano_tipo_id"];
                    $this->CachedColumns["dpto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["dpto_id"];
                    $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_depto_parc_id"];
                    $this->CachedColumns["tipo_plano_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_plano_id"];
                    $this->CachedColumns["id"][$this->RowNumber] = $this->DataSource->CachedColumns["id"];
                    $this->CachedColumns["planos_prov_id"][$this->RowNumber] = $this->DataSource->CachedColumns["planos_prov_id"];
                    $this->CachedColumns["tipo_estado_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_estado_id"];
                    $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_est_parc_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->htm->SetText("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                    $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->plano->SetValue($this->DataSource->plano->GetValue());
                    $this->planos_prov_id->SetValue($this->DataSource->planos_prov_id->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->parcela_partida->SetText("");
                    $this->parcela_seccion->SetText("");
                    $this->parcela_chacra->SetText("");
                    $this->parcela_quinta->SetText("");
                    $this->parcela_macizo->SetText("");
                    $this->parcela_fraccion->SetText("");
                    $this->parcela_uf->SetText("");
                    $this->parcela_predio->SetText("");
                    $this->parcela_rte->SetText("");
                    $this->parcela_parcela->SetText("");
                    $this->plano->SetText("");
                    $this->htm->SetText("");
                    $this->tipo_est_parc_descr->SetText("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                    $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->plano->SetValue($this->DataSource->plano->GetValue());
                    $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->planos_prov_id->SetText($this->FormParameters["planos_prov_id"][$this->RowNumber], $this->RowNumber);
                    $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["parcela_id"][$this->RowNumber] = "";
                    $this->CachedColumns["parcelas_org_id"][$this->RowNumber] = "";
                    $this->CachedColumns["plano_id"][$this->RowNumber] = "";
                    $this->CachedColumns["plano_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["dpto_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_plano_id"][$this->RowNumber] = "";
                    $this->CachedColumns["id"][$this->RowNumber] = "";
                    $this->CachedColumns["planos_prov_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_estado_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber] = "";
                    $this->parcela_partida->SetText("");
                    $this->parcela_seccion->SetText("");
                    $this->parcela_chacra->SetText("");
                    $this->parcela_quinta->SetText("");
                    $this->parcela_macizo->SetText("");
                    $this->parcela_fraccion->SetText("");
                    $this->parcela_uf->SetText("");
                    $this->parcela_predio->SetText("");
                    $this->parcela_rte->SetText("");
                    $this->parcela_parcela->SetText("");
                    $this->plano->SetText("");
                    $this->htm->SetText("");
                    $this->planos_prov_id->SetText("");
                    $this->parcela_id->SetText("");
                    $this->tipo_est_parc_descr->SetText("");
                } else {
                    $this->parcela_partida->SetText("");
                    $this->parcela_seccion->SetText("");
                    $this->parcela_chacra->SetText("");
                    $this->parcela_quinta->SetText("");
                    $this->parcela_macizo->SetText("");
                    $this->parcela_fraccion->SetText("");
                    $this->parcela_uf->SetText("");
                    $this->parcela_predio->SetText("");
                    $this->parcela_rte->SetText("");
                    $this->parcela_parcela->SetText("");
                    $this->plano->SetText("");
                    $this->htm->SetText("");
                    $this->tipo_est_parc_descr->SetText("");
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->planos_prov_id->SetText($this->FormParameters["planos_prov_id"][$this->RowNumber], $this->RowNumber);
                    $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show($this->RowNumber);
                $this->parcela_seccion->Show($this->RowNumber);
                $this->parcela_chacra->Show($this->RowNumber);
                $this->parcela_quinta->Show($this->RowNumber);
                $this->parcela_macizo->Show($this->RowNumber);
                $this->parcela_fraccion->Show($this->RowNumber);
                $this->parcela_uf->Show($this->RowNumber);
                $this->parcela_predio->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->parcela_rte->Show($this->RowNumber);
                $this->parcela_parcela->Show($this->RowNumber);
                $this->plano->Show($this->RowNumber);
                $this->htm->Show($this->RowNumber);
                $this->planos_prov_id->Show($this->RowNumber);
                $this->parcela_id->Show($this->RowNumber);
                $this->tipo_est_parc_descr->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["parcela_id"] == $this->CachedColumns["parcela_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["parcelas_org_id"] == $this->CachedColumns["parcelas_org_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["plano_id"] == $this->CachedColumns["plano_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["plano_tipo_id"] == $this->CachedColumns["plano_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["dpto_id"] == $this->CachedColumns["dpto_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_depto_parc_id"] == $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_plano_id"] == $this->CachedColumns["tipo_plano_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["id"] == $this->CachedColumns["id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["planos_prov_id"] == $this->CachedColumns["planos_prov_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_estado_id"] == $this->CachedColumns["tipo_estado_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_est_parc_id"] == $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber])) {
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
        $this->origen_TotalRecords->Show();
        $this->Button_Submit->Show();
        $this->Navigator->Show();
        $this->panel_origen->Show();

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

} //End parcelas_origen_prov Class @331-FCB6E20C

class clsparcelas_origen_provDataSource extends clsDBtdf_nuevo {  //parcelas_origen_provDataSource Class @331-559E2B7C

//DataSource Variables @331-72BE7946
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;

    // Datasource fields
    public $parcela_partida;
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $CheckBox_Delete;
    public $parcela_rte;
    public $parcela_parcela;
    public $plano;
    public $htm;
    public $planos_prov_id;
    public $parcela_id;
    public $tipo_est_parc_descr;
//End DataSource Variables

//DataSourceClass_Initialize Event @331-BF9378A0
    function clsparcelas_origen_provDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid parcelas_origen_prov/Error";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->htm = new clsField("htm", ccsText, "");
        
        $this->planos_prov_id = new clsField("planos_prov_id", ccsInteger, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @331-7661BA59
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcelas.parcela_seccion, parcelas.parcela_chacra, parcelas.parcela_quinta, parcela_macizo * 1, parcelas.parcela_fraccion, parcela_parcela * 1, parcela_uf * 1, parcelas.parcela_predio, parcelas.parcela_rte";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @331-2A05399D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->AddParameter("2", "expr608", ccsText, "", "", $this->Parameters["expr608"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planos_parc_prov.planos_parc_prov_tipo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @331-3CCFC041
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (parcelas INNER JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id";
        $this->SQL = "SELECT planos_parc_prov.*, parcelas.*, tipo_est_parc_descr \n\n" .
        "FROM (parcelas INNER JOIN planos_parc_prov ON\n\n" .
        "planos_parc_prov.parcela_id = parcelas.parcela_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @331-2F480E9A
    function SetValues()
    {
        $this->CachedColumns["parcela_id"] = $this->f("parcela_id");
        $this->CachedColumns["parcelas_org_id"] = $this->f("parcelas_org_id");
        $this->CachedColumns["plano_id"] = $this->f("plano_id");
        $this->CachedColumns["plano_tipo_id"] = $this->f("plano_tipo_id");
        $this->CachedColumns["dpto_id"] = $this->f("dpto_id");
        $this->CachedColumns["tipo_depto_parc_id"] = $this->f("tipo_depto_parc_id");
        $this->CachedColumns["tipo_plano_id"] = $this->f("tipo_plano_id");
        $this->CachedColumns["id"] = $this->f("id");
        $this->CachedColumns["planos_prov_id"] = $this->f("planos_prov_id");
        $this->CachedColumns["tipo_estado_id"] = $this->f("tipo_estado_id");
        $this->CachedColumns["tipo_est_parc_id"] = $this->f("tipo_est_parc_id");
        $this->parcela_partida->SetDBValue($this->f("parcela_partida"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->plano->SetDBValue($this->f("plano"));
        $this->planos_prov_id->SetDBValue(trim($this->f("planos_prov_id")));
        $this->parcela_id->SetDBValue($this->f("parcela_id"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
    }
//End SetValues Method

//Delete Method @331-4169A1C3
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End parcelas_origen_provDataSource Class @331-FCB6E20C











//Initialize Page @1-E658BED5
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
$TemplateFileName = "tc_planosEdicion.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CBFD1E0E
CCSecurityRedirect("1;2", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-C285ACC8
include_once("./tc_planosEdicion_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-69924FD7
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$planos = new clsRecordplanos("", $MainPage);
$parcelas_destino_prov = new clsGridparcelas_destino_prov("", $MainPage);
$parcelas_origen_prov = new clsEditableGridparcelas_origen_prov("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->planos = & $planos;
$MainPage->parcelas_destino_prov = & $parcelas_destino_prov;
$MainPage->parcelas_origen_prov = & $parcelas_origen_prov;
$planos->Initialize();
$parcelas_destino_prov->Initialize();
$parcelas_origen_prov->Initialize();

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

//Execute Components @1-7A56957C
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$planos->Operation();
$parcelas_origen_prov->Operation();
//End Execute Components

//Go to destination page @1-592D3D39
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBcatastro->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($planos);
    unset($parcelas_destino_prov);
    unset($parcelas_origen_prov);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D9ABD336
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$planos->Show();
$parcelas_destino_prov->Show();
$parcelas_origen_prov->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;ene&#114;&#97;&#116;e&#100; <!-- SCC -->&#119;&#105;&#116;&#104; <!-- SCC -->&#67;od&#101;&#67;h&#97;&#114;g&#101; <!-- SCC -->&#83;&#116;udio.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;ene&#114;&#97;&#116;e&#100; <!-- SCC -->&#119;&#105;&#116;&#104; <!-- SCC -->&#67;od&#101;&#67;h&#97;&#114;g&#101; <!-- SCC -->&#83;&#116;udio.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>&#71;ene&#114;&#97;&#116;e&#100; <!-- SCC -->&#119;&#105;&#116;&#104; <!-- SCC -->&#67;od&#101;&#67;h&#97;&#114;g&#101; <!-- SCC -->&#83;&#116;udio.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-FFEEBE1C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBcatastro->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($planos);
unset($parcelas_destino_prov);
unset($parcelas_origen_prov);
unset($Tpl);
//End Unload Page


?>
