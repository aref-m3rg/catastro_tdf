<?php
//Include Common Files @1-A575D84A
define("RelativePath", "..");
define("PathToCurrentPage", "/estadisticas/");
define("FileName", "est_parcela_cant_mejora.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
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



class clsRecordparcelasSearch { //parcelasSearch Class @7-CBAE5345

//Variables @7-9E315808

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

//Class_Initialize Event @7-7FB875FE
    function clsRecordparcelasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_tipo_padron_parc_id = new clsControl(ccsListBox, "s_tipo_padron_parc_id", "s_tipo_padron_parc_id", ccsInteger, "", CCGetRequestParam("s_tipo_padron_parc_id", $Method, NULL), $this);
            $this->s_tipo_padron_parc_id->DSType = dsTable;
            $this->s_tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_padron_parc_id->ds = & $this->s_tipo_padron_parc_id->DataSource;
            $this->s_tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_padron_parc_id->BoundColumn, $this->s_tipo_padron_parc_id->TextColumn, $this->s_tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->s_tipo_depto_parc_id = new clsControl(ccsListBox, "s_tipo_depto_parc_id", "s_tipo_depto_parc_id", ccsInteger, "", CCGetRequestParam("s_tipo_depto_parc_id", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id->DSType = dsTable;
            $this->s_tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_depto_parc_id->ds = & $this->s_tipo_depto_parc_id->DataSource;
            $this->s_tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_depto_parc_id->BoundColumn, $this->s_tipo_depto_parc_id->TextColumn, $this->s_tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_abrev", "");
            $this->s_parcela_seccion = new clsControl(ccsTextBox, "s_parcela_seccion", "s_parcela_seccion", ccsText, "", CCGetRequestParam("s_parcela_seccion", $Method, NULL), $this);
            $this->s_parcela_macizo = new clsControl(ccsTextBox, "s_parcela_macizo", "s_parcela_macizo", ccsText, "", CCGetRequestParam("s_parcela_macizo", $Method, NULL), $this);
            $this->s_parcela_parcela = new clsControl(ccsTextBox, "s_parcela_parcela", "s_parcela_parcela", ccsText, "", CCGetRequestParam("s_parcela_parcela", $Method, NULL), $this);
            $this->s_parcela_chacra = new clsControl(ccsTextBox, "s_parcela_chacra", "s_parcela_chacra", ccsText, "", CCGetRequestParam("s_parcela_chacra", $Method, NULL), $this);
            $this->s_parcela_quinta = new clsControl(ccsTextBox, "s_parcela_quinta", "s_parcela_quinta", ccsText, "", CCGetRequestParam("s_parcela_quinta", $Method, NULL), $this);
            $this->s_parcela_fraccion = new clsControl(ccsTextBox, "s_parcela_fraccion", "s_parcela_fraccion", ccsText, "", CCGetRequestParam("s_parcela_fraccion", $Method, NULL), $this);
            $this->s_parcela_uf = new clsControl(ccsTextBox, "s_parcela_uf", "s_parcela_uf", ccsText, "", CCGetRequestParam("s_parcela_uf", $Method, NULL), $this);
            $this->s_parcela_predio = new clsControl(ccsTextBox, "s_parcela_predio", "s_parcela_predio", ccsText, "", CCGetRequestParam("s_parcela_predio", $Method, NULL), $this);
            $this->s_parcela_rte = new clsControl(ccsTextBox, "s_parcela_rte", "s_parcela_rte", ccsText, "", CCGetRequestParam("s_parcela_rte", $Method, NULL), $this);
            $this->sup_max = new clsControl(ccsTextBox, "sup_max", "sup_max", ccsText, "", CCGetRequestParam("sup_max", $Method, NULL), $this);
            $this->s_tipo_restricc_parcela_id = new clsControl(ccsListBox, "s_tipo_restricc_parcela_id", "s_tipo_restricc_parcela_id", ccsInteger, "", CCGetRequestParam("s_tipo_restricc_parcela_id", $Method, NULL), $this);
            $this->s_tipo_restricc_parcela_id->DSType = dsTable;
            $this->s_tipo_restricc_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_restricc_parcela_id->ds = & $this->s_tipo_restricc_parcela_id->DataSource;
            $this->s_tipo_restricc_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_restricc_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_restricc_parcela_id->BoundColumn, $this->s_tipo_restricc_parcela_id->TextColumn, $this->s_tipo_restricc_parcela_id->DBFormat) = array("tipo_restricc_parcela_id", "tipo_restricc_parcela_desc", "");
            $this->s_tipo_est_parc_id = new clsControl(ccsListBox, "s_tipo_est_parc_id", "s_tipo_est_parc_id", ccsInteger, "", CCGetRequestParam("s_tipo_est_parc_id", $Method, NULL), $this);
            $this->s_tipo_est_parc_id->DSType = dsTable;
            $this->s_tipo_est_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_est_parc_id->ds = & $this->s_tipo_est_parc_id->DataSource;
            $this->s_tipo_est_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_est_parc_id->BoundColumn, $this->s_tipo_est_parc_id->TextColumn, $this->s_tipo_est_parc_id->DBFormat) = array("tipo_est_parc_id", "tipo_est_parc_descr", "");
            $this->s_tipo_est_parc_id->DataSource->wp = new clsSQLParameters();
            $this->s_tipo_est_parc_id->DataSource->wp->Criterion[1] = "( tipo_est_parc_descr <> '' )";
            $this->s_tipo_est_parc_id->DataSource->Where = 
                 $this->s_tipo_est_parc_id->DataSource->wp->Criterion[1];
            $this->s_tipo_parcela_id = new clsControl(ccsListBox, "s_tipo_parcela_id", "s_tipo_parcela_id", ccsInteger, "", CCGetRequestParam("s_tipo_parcela_id", $Method, NULL), $this);
            $this->s_tipo_parcela_id->DSType = dsTable;
            $this->s_tipo_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_parcela_id->ds = & $this->s_tipo_parcela_id->DataSource;
            $this->s_tipo_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_parcela_id->BoundColumn, $this->s_tipo_parcela_id->TextColumn, $this->s_tipo_parcela_id->DBFormat) = array("tipo_parcela_id", "tipo_parcela_descrip", "");
            $this->s_tipo_parcela_id->DataSource->wp = new clsSQLParameters();
            $this->s_tipo_parcela_id->DataSource->wp->Criterion[1] = "( tipo_parcela_descrip <> '' )";
            $this->s_tipo_parcela_id->DataSource->Where = 
                 $this->s_tipo_parcela_id->DataSource->wp->Criterion[1];
            $this->s_tipo_parcela_uso_id = new clsControl(ccsListBox, "s_tipo_parcela_uso_id", "s_tipo_parcela_uso_id", ccsInteger, "", CCGetRequestParam("s_tipo_parcela_uso_id", $Method, NULL), $this);
            $this->s_tipo_parcela_uso_id->DSType = dsTable;
            $this->s_tipo_parcela_uso_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_parcela_uso_id->ds = & $this->s_tipo_parcela_uso_id->DataSource;
            $this->s_tipo_parcela_uso_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas_usos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_parcela_uso_id->BoundColumn, $this->s_tipo_parcela_uso_id->TextColumn, $this->s_tipo_parcela_uso_id->DBFormat) = array("tipo_parcela_uso_id", "tipo_parcela_uso_descrip", "");
            $this->s_tipo_parcela_uso_id->DataSource->wp = new clsSQLParameters();
            $this->s_tipo_parcela_uso_id->DataSource->wp->Criterion[1] = "( tipo_parcela_uso_descrip <> '' )";
            $this->s_tipo_parcela_uso_id->DataSource->Where = 
                 $this->s_tipo_parcela_uso_id->DataSource->wp->Criterion[1];
            $this->s_tipo_instrumento_id = new clsControl(ccsListBox, "s_tipo_instrumento_id", "s_tipo_instrumento_id", ccsText, "", CCGetRequestParam("s_tipo_instrumento_id", $Method, NULL), $this);
            $this->s_tipo_instrumento_id->DSType = dsTable;
            $this->s_tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_instrumento_id->ds = & $this->s_tipo_instrumento_id->DataSource;
            $this->s_tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_instrumento_id->BoundColumn, $this->s_tipo_instrumento_id->TextColumn, $this->s_tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
            $this->s_tipo_instrumento_id->DataSource->wp = new clsSQLParameters();
            $this->s_tipo_instrumento_id->DataSource->wp->Criterion[1] = "( tipo_instrumento_descrip <> '' )";
            $this->s_tipo_instrumento_id->DataSource->Where = 
                 $this->s_tipo_instrumento_id->DataSource->wp->Criterion[1];
            $this->s_persona_parcela_num_int = new clsControl(ccsTextBox, "s_persona_parcela_num_int", "s_persona_parcela_num_int", ccsText, "", CCGetRequestParam("s_persona_parcela_num_int", $Method, NULL), $this);
            $this->sup_min = new clsControl(ccsTextBox, "sup_min", "sup_min", ccsText, "", CCGetRequestParam("sup_min", $Method, NULL), $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_dist = new clsControl(ccsCheckBox, "s_dist", "s_dist", ccsInteger, "", CCGetRequestParam("s_dist", $Method, NULL), $this);
            $this->s_dist->CheckedValue = $this->s_dist->GetParsedValue(1);
            $this->s_dist->UncheckedValue = false;
            $this->buscar = new clsControl(ccsHidden, "buscar", "buscar", ccsText, "", CCGetRequestParam("buscar", $Method, NULL), $this);
            $this->s_persona_denominacion = new clsControl(ccsTextBox, "s_persona_denominacion", "s_persona_denominacion", ccsText, "", CCGetRequestParam("s_persona_denominacion", $Method, NULL), $this);
            $this->s_tipo_estado_id = new clsControl(ccsListBox, "s_tipo_estado_id", "s_tipo_estado_id", ccsInteger, "", CCGetRequestParam("s_tipo_estado_id", $Method, NULL), $this);
            $this->s_tipo_estado_id->DSType = dsTable;
            $this->s_tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_estado_id->ds = & $this->s_tipo_estado_id->DataSource;
            $this->s_tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_estado_id->BoundColumn, $this->s_tipo_estado_id->TextColumn, $this->s_tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            $this->s_tipo_plano_id = new clsControl(ccsListBox, "s_tipo_plano_id", "s_tipo_plano_id", ccsInteger, "", CCGetRequestParam("s_tipo_plano_id", $Method, NULL), $this);
            $this->s_tipo_plano_id->DSType = dsTable;
            $this->s_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_plano_id->ds = & $this->s_tipo_plano_id->DataSource;
            $this->s_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_plano_id->BoundColumn, $this->s_tipo_plano_id->TextColumn, $this->s_tipo_plano_id->DBFormat) = array("tipo_plano_id", "tipo_plano_desc", "");
            $this->s_tipos_estados_planos = new clsControl(ccsListBox, "s_tipos_estados_planos", "s_tipos_estados_planos", ccsInteger, "", CCGetRequestParam("s_tipos_estados_planos", $Method, NULL), $this);
            $this->s_tipos_estados_planos->DSType = dsTable;
            $this->s_tipos_estados_planos->DataSource = new clsDBtdf_nuevo();
            $this->s_tipos_estados_planos->ds = & $this->s_tipos_estados_planos->DataSource;
            $this->s_tipos_estados_planos->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipos_estados_planos->BoundColumn, $this->s_tipos_estados_planos->TextColumn, $this->s_tipos_estados_planos->DBFormat) = array("tipo_estado_plano_id", "tipo_estado_plano_desc", "");
            $this->s_plano_nro = new clsControl(ccsTextBox, "s_plano_nro", "s_plano_nro", ccsText, "", CCGetRequestParam("s_plano_nro", $Method, NULL), $this);
            $this->s_plano_anio = new clsControl(ccsTextBox, "s_plano_anio", "s_plano_anio", ccsText, "", CCGetRequestParam("s_plano_anio", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->s_dist->Value) && !strlen($this->s_dist->Value) && $this->s_dist->Value !== false)
                    $this->s_dist->SetValue(true);
                if(!is_array($this->buscar->Value) && !strlen($this->buscar->Value) && $this->buscar->Value !== false)
                    $this->buscar->SetText(1);
                if(!is_array($this->s_tipo_estado_id->Value) && !strlen($this->s_tipo_estado_id->Value) && $this->s_tipo_estado_id->Value !== false)
                    $this->s_tipo_estado_id->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @7-CE85409F
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf->Validate() && $Validation);
        $Validation = ($this->s_parcela_predio->Validate() && $Validation);
        $Validation = ($this->s_parcela_rte->Validate() && $Validation);
        $Validation = ($this->sup_max->Validate() && $Validation);
        $Validation = ($this->s_tipo_restricc_parcela_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_est_parc_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_parcela_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_parcela_uso_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->s_persona_parcela_num_int->Validate() && $Validation);
        $Validation = ($this->sup_min->Validate() && $Validation);
        $Validation = ($this->s_dist->Validate() && $Validation);
        $Validation = ($this->buscar->Validate() && $Validation);
        $Validation = ($this->s_persona_denominacion->Validate() && $Validation);
        $Validation = ($this->s_tipo_estado_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->s_tipos_estados_planos->Validate() && $Validation);
        $Validation = ($this->s_plano_nro->Validate() && $Validation);
        $Validation = ($this->s_plano_anio->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_predio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_rte->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_max->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_restricc_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_est_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_parcela_uso_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_parcela_num_int->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_min->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_dist->Errors->Count() == 0);
        $Validation =  $Validation && ($this->buscar->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipos_estados_planos->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_anio->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @7-1B870A75
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf->Errors->Count());
        $errors = ($errors || $this->s_parcela_predio->Errors->Count());
        $errors = ($errors || $this->s_parcela_rte->Errors->Count());
        $errors = ($errors || $this->sup_max->Errors->Count());
        $errors = ($errors || $this->s_tipo_restricc_parcela_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_est_parc_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_parcela_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_parcela_uso_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->s_persona_parcela_num_int->Errors->Count());
        $errors = ($errors || $this->sup_min->Errors->Count());
        $errors = ($errors || $this->s_dist->Errors->Count());
        $errors = ($errors || $this->buscar->Errors->Count());
        $errors = ($errors || $this->s_persona_denominacion->Errors->Count());
        $errors = ($errors || $this->s_tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->s_tipos_estados_planos->Errors->Count());
        $errors = ($errors || $this->s_plano_nro->Errors->Count());
        $errors = ($errors || $this->s_plano_anio->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @7-ED598703
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

//Operation Method @7-9A0F2A79
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
            $this->PressedButton = "Button1";
            if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "est_parcela_cant_mejora.php";
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "est_parcela_cant_mejora.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button1", "Button1_x", "Button1_y", "Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @7-C1A63A24
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

        $this->s_tipo_padron_parc_id->Prepare();
        $this->s_tipo_depto_parc_id->Prepare();
        $this->s_tipo_restricc_parcela_id->Prepare();
        $this->s_tipo_est_parc_id->Prepare();
        $this->s_tipo_parcela_id->Prepare();
        $this->s_tipo_parcela_uso_id->Prepare();
        $this->s_tipo_instrumento_id->Prepare();
        $this->s_tipo_estado_id->Prepare();
        $this->s_tipo_plano_id->Prepare();
        $this->s_tipos_estados_planos->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_predio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_rte->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_max->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_restricc_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_est_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_parcela_uso_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_parcela_num_int->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_min->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_dist->Errors->ToString());
            $Error = ComposeStrings($Error, $this->buscar->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipos_estados_planos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_anio->Errors->ToString());
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

        $this->s_tipo_padron_parc_id->Show();
        $this->s_tipo_depto_parc_id->Show();
        $this->s_parcela_seccion->Show();
        $this->s_parcela_macizo->Show();
        $this->s_parcela_parcela->Show();
        $this->s_parcela_chacra->Show();
        $this->s_parcela_quinta->Show();
        $this->s_parcela_fraccion->Show();
        $this->s_parcela_uf->Show();
        $this->s_parcela_predio->Show();
        $this->s_parcela_rte->Show();
        $this->sup_max->Show();
        $this->s_tipo_restricc_parcela_id->Show();
        $this->s_tipo_est_parc_id->Show();
        $this->s_tipo_parcela_id->Show();
        $this->s_tipo_parcela_uso_id->Show();
        $this->s_tipo_instrumento_id->Show();
        $this->s_persona_parcela_num_int->Show();
        $this->sup_min->Show();
        $this->Button1->Show();
        $this->Button_DoSearch->Show();
        $this->s_dist->Show();
        $this->buscar->Show();
        $this->s_persona_denominacion->Show();
        $this->s_tipo_estado_id->Show();
        $this->s_tipo_plano_id->Show();
        $this->s_tipos_estados_planos->Show();
        $this->s_plano_nro->Show();
        $this->s_plano_anio->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End parcelasSearch Class @7-FCB6E20C

class clsGridparcelas { //parcelas class @27-C47EAFDB

//Variables @27-24C77345

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
    public $Sorter_parcela_partida;
    public $Sorter_parcela_super_mensura;
    public $Sorter_parcela_sup_uf;
    public $Sorter_tipo_parcela_uso_id;
    public $Sorter_tipo_est_parc_id;
    public $Sorter_tipo_depto_parc_id;
    public $Sorter_tipo_padron_parc_id;
    public $Sorter_tipo_parcela_id;
    public $Sorter_parcela_seccion;
    public $Sorter_parcela_macizo;
    public $Sorter_parcela_parcela;
    public $Sorter_parcela_chacra;
    public $Sorter_parcela_quinta;
    public $Sorter_parcela_fraccion;
    public $Sorter_parcela_uf;
    public $Sorter_parcela_predio;
    public $Sorter_parcela_rte;
    public $Sorter_parcela_mzna;
    public $Sorter_parcela_lote;
    public $Sorter_parcela_val_tierra;
    public $Sorter_parcela_val_mejora;
    public $Sorter_parcela_val_ampliac;
    public $Sorter_parcela_val_total;
    public $Sorter_persona_denominacion;
//End Variables

//Class_Initialize Event @27-9C2358DD
    function clsGridparcelas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("parcelasOrder", "");
        $this->SorterDirection = CCGetParam("parcelasDir", "");

        $this->parcela_partida = new clsControl(ccsLink, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_partida->Page = "../gestion/gridMejoras.php";
        $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_super_mensura", ccsGet, NULL), $this);
        $this->parcela_sup_uf = new clsControl(ccsLabel, "parcela_sup_uf", "parcela_sup_uf", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_sup_uf", ccsGet, NULL), $this);
        $this->tipo_parcela_uso_descrip = new clsControl(ccsLabel, "tipo_parcela_uso_descrip", "tipo_parcela_uso_descrip", ccsText, "", CCGetRequestParam("tipo_parcela_uso_descrip", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", ccsGet, NULL), $this);
        $this->tipo_padron_parc_desc = new clsControl(ccsLabel, "tipo_padron_parc_desc", "tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("tipo_padron_parc_desc", ccsGet, NULL), $this);
        $this->tipo_parcela_descrip = new clsControl(ccsLabel, "tipo_parcela_descrip", "tipo_parcela_descrip", ccsText, "", CCGetRequestParam("tipo_parcela_descrip", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->parcela_mzna = new clsControl(ccsLabel, "parcela_mzna", "parcela_mzna", ccsText, "", CCGetRequestParam("parcela_mzna", ccsGet, NULL), $this);
        $this->parcela_lote = new clsControl(ccsLabel, "parcela_lote", "parcela_lote", ccsText, "", CCGetRequestParam("parcela_lote", ccsGet, NULL), $this);
        $this->parcela_val_tierra = new clsControl(ccsLabel, "parcela_val_tierra", "parcela_val_tierra", ccsText, "", CCGetRequestParam("parcela_val_tierra", ccsGet, NULL), $this);
        $this->parcela_val_mejora = new clsControl(ccsLabel, "parcela_val_mejora", "parcela_val_mejora", ccsText, "", CCGetRequestParam("parcela_val_mejora", ccsGet, NULL), $this);
        $this->parcela_val_ampliac = new clsControl(ccsLabel, "parcela_val_ampliac", "parcela_val_ampliac", ccsText, "", CCGetRequestParam("parcela_val_ampliac", ccsGet, NULL), $this);
        $this->parcela_val_total = new clsControl(ccsLabel, "parcela_val_total", "parcela_val_total", ccsText, "", CCGetRequestParam("parcela_val_total", ccsGet, NULL), $this);
        $this->unidades_medidas_htm = new clsControl(ccsLabel, "unidades_medidas_htm", "unidades_medidas_htm", ccsText, "", CCGetRequestParam("unidades_medidas_htm", ccsGet, NULL), $this);
        $this->unidades_medidas_htm->HTML = true;
        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->mejora_sup_cub = new clsControl(ccsLabel, "mejora_sup_cub", "mejora_sup_cub", ccsText, "", CCGetRequestParam("mejora_sup_cub", ccsGet, NULL), $this);
        $this->mejora_sup_semi_cub = new clsControl(ccsLabel, "mejora_sup_semi_cub", "mejora_sup_semi_cub", ccsText, "", CCGetRequestParam("mejora_sup_semi_cub", ccsGet, NULL), $this);
        $this->mejora_sup_cub_2 = new clsControl(ccsLabel, "mejora_sup_cub_2", "mejora_sup_cub_2", ccsText, "", CCGetRequestParam("mejora_sup_cub_2", ccsGet, NULL), $this);
        $this->mejora_anio_construccion = new clsControl(ccsLabel, "mejora_anio_construccion", "mejora_anio_construccion", ccsText, "", CCGetRequestParam("mejora_anio_construccion", ccsGet, NULL), $this);
        $this->mejora_f_alta = new clsControl(ccsLabel, "mejora_f_alta", "mejora_f_alta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("mejora_f_alta", ccsGet, NULL), $this);
        $this->tipo_mejora_decla_descrip = new clsControl(ccsLabel, "tipo_mejora_decla_descrip", "tipo_mejora_decla_descrip", ccsText, "", CCGetRequestParam("tipo_mejora_decla_descrip", ccsGet, NULL), $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_super_mensura = new clsSorter($this->ComponentName, "Sorter_parcela_super_mensura", $FileName, $this);
        $this->Sorter_parcela_sup_uf = new clsSorter($this->ComponentName, "Sorter_parcela_sup_uf", $FileName, $this);
        $this->Sorter_tipo_parcela_uso_id = new clsSorter($this->ComponentName, "Sorter_tipo_parcela_uso_id", $FileName, $this);
        $this->Sorter_tipo_est_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_est_parc_id", $FileName, $this);
        $this->Sorter_tipo_depto_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_depto_parc_id", $FileName, $this);
        $this->Sorter_tipo_padron_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_padron_parc_id", $FileName, $this);
        $this->Sorter_tipo_parcela_id = new clsSorter($this->ComponentName, "Sorter_tipo_parcela_id", $FileName, $this);
        $this->Sorter_parcela_seccion = new clsSorter($this->ComponentName, "Sorter_parcela_seccion", $FileName, $this);
        $this->Sorter_parcela_macizo = new clsSorter($this->ComponentName, "Sorter_parcela_macizo", $FileName, $this);
        $this->Sorter_parcela_parcela = new clsSorter($this->ComponentName, "Sorter_parcela_parcela", $FileName, $this);
        $this->Sorter_parcela_chacra = new clsSorter($this->ComponentName, "Sorter_parcela_chacra", $FileName, $this);
        $this->Sorter_parcela_quinta = new clsSorter($this->ComponentName, "Sorter_parcela_quinta", $FileName, $this);
        $this->Sorter_parcela_fraccion = new clsSorter($this->ComponentName, "Sorter_parcela_fraccion", $FileName, $this);
        $this->Sorter_parcela_uf = new clsSorter($this->ComponentName, "Sorter_parcela_uf", $FileName, $this);
        $this->Sorter_parcela_predio = new clsSorter($this->ComponentName, "Sorter_parcela_predio", $FileName, $this);
        $this->Sorter_parcela_rte = new clsSorter($this->ComponentName, "Sorter_parcela_rte", $FileName, $this);
        $this->Sorter_parcela_mzna = new clsSorter($this->ComponentName, "Sorter_parcela_mzna", $FileName, $this);
        $this->Sorter_parcela_lote = new clsSorter($this->ComponentName, "Sorter_parcela_lote", $FileName, $this);
        $this->Sorter_parcela_val_tierra = new clsSorter($this->ComponentName, "Sorter_parcela_val_tierra", $FileName, $this);
        $this->Sorter_parcela_val_mejora = new clsSorter($this->ComponentName, "Sorter_parcela_val_mejora", $FileName, $this);
        $this->Sorter_parcela_val_ampliac = new clsSorter($this->ComponentName, "Sorter_parcela_val_ampliac", $FileName, $this);
        $this->Sorter_parcela_val_total = new clsSorter($this->ComponentName, "Sorter_parcela_val_total", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 100, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50", "100");
        $this->super_mensura = new clsControl(ccsLabel, "super_mensura", "super_mensura", ccsText, "", CCGetRequestParam("super_mensura", ccsGet, NULL), $this);
        $this->super_uf = new clsControl(ccsLabel, "super_uf", "super_uf", ccsText, "", CCGetRequestParam("super_uf", ccsGet, NULL), $this);
        $this->sum_val_tierra = new clsControl(ccsLabel, "sum_val_tierra", "sum_val_tierra", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_val_tierra", ccsGet, NULL), $this);
        $this->sum_val_mejora = new clsControl(ccsLabel, "sum_val_mejora", "sum_val_mejora", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_val_mejora", ccsGet, NULL), $this);
        $this->sum_val_amp = new clsControl(ccsLabel, "sum_val_amp", "sum_val_amp", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_val_amp", ccsGet, NULL), $this);
        $this->sum_val_tot = new clsControl(ccsLabel, "sum_val_tot", "sum_val_tot", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("sum_val_tot", ccsGet, NULL), $this);
        $this->toXls = new clsControl(ccsImageLink, "toXls", "toXls", ccsText, "", CCGetRequestParam("toXls", ccsGet, NULL), $this);
        $this->toXls->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->toXls->Page = "../preXls.php";
        $this->contador = new clsControl(ccsLabel, "contador", "contador", ccsText, "", CCGetRequestParam("contador", ccsGet, NULL), $this);
        $this->Sorter_persona_denominacion = new clsSorter($this->ComponentName, "Sorter_persona_denominacion", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @27-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @27-6F733CD8
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_tipo_parcela_uso_id"] = CCGetFromGet("s_tipo_parcela_uso_id", NULL);
        $this->DataSource->Parameters["urls_tipo_est_parc_id"] = CCGetFromGet("s_tipo_est_parc_id", NULL);
        $this->DataSource->Parameters["urls_tipo_parcela_id"] = CCGetFromGet("s_tipo_parcela_id", NULL);
        $this->DataSource->Parameters["urls_tipo_depto_parc_id"] = CCGetFromGet("s_tipo_depto_parc_id", NULL);
        $this->DataSource->Parameters["urls_tipo_padron_parc_id"] = CCGetFromGet("s_tipo_padron_parc_id", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion"] = CCGetFromGet("s_parcela_seccion", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo"] = CCGetFromGet("s_parcela_macizo", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela"] = CCGetFromGet("s_parcela_parcela", NULL);
        $this->DataSource->Parameters["urls_parcela_chacra"] = CCGetFromGet("s_parcela_chacra", NULL);
        $this->DataSource->Parameters["urls_parcela_quinta"] = CCGetFromGet("s_parcela_quinta", NULL);
        $this->DataSource->Parameters["urls_parcela_fraccion"] = CCGetFromGet("s_parcela_fraccion", NULL);
        $this->DataSource->Parameters["urls_parcela_uf"] = CCGetFromGet("s_parcela_uf", NULL);
        $this->DataSource->Parameters["urls_parcela_predio"] = CCGetFromGet("s_parcela_predio", NULL);
        $this->DataSource->Parameters["urlsup_min"] = CCGetFromGet("sup_min", NULL);
        $this->DataSource->Parameters["urlsup_max"] = CCGetFromGet("sup_max", NULL);
        $this->DataSource->Parameters["urls_tipo_restricc_parcela_id"] = CCGetFromGet("s_tipo_restricc_parcela_id", NULL);
        $this->DataSource->Parameters["urls_tipo_instrumento_id"] = CCGetFromGet("s_tipo_instrumento_id", NULL);
        $this->DataSource->Parameters["urls_persona_parcela_num_int"] = CCGetFromGet("s_persona_parcela_num_int", NULL);
        $this->DataSource->Parameters["urls_dist"] = CCGetFromGet("s_dist", NULL);
        $this->DataSource->Parameters["urls_persona_denominacion"] = CCGetFromGet("s_persona_denominacion", NULL);
        $this->DataSource->Parameters["urls_tipo_estado_id"] = CCGetFromGet("s_tipo_estado_id", NULL);
        $this->DataSource->Parameters["urls_tipo_plano_id"] = CCGetFromGet("s_tipo_plano_id", NULL);
        $this->DataSource->Parameters["urls_tipo_estado_plano_id"] = CCGetFromGet("s_tipo_estado_plano_id", NULL);
        $this->DataSource->Parameters["urls_plano_nro"] = CCGetFromGet("s_plano_nro", NULL);
        $this->DataSource->Parameters["urls_plano_anio"] = CCGetFromGet("s_plano_anio", NULL);
        $this->DataSource->Parameters["expr447"] = 1;

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
            $this->ControlsVisible["parcela_super_mensura"] = $this->parcela_super_mensura->Visible;
            $this->ControlsVisible["parcela_sup_uf"] = $this->parcela_sup_uf->Visible;
            $this->ControlsVisible["tipo_parcela_uso_descrip"] = $this->tipo_parcela_uso_descrip->Visible;
            $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
            $this->ControlsVisible["tipo_depto_parc_desc"] = $this->tipo_depto_parc_desc->Visible;
            $this->ControlsVisible["tipo_padron_parc_desc"] = $this->tipo_padron_parc_desc->Visible;
            $this->ControlsVisible["tipo_parcela_descrip"] = $this->tipo_parcela_descrip->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["parcela_mzna"] = $this->parcela_mzna->Visible;
            $this->ControlsVisible["parcela_lote"] = $this->parcela_lote->Visible;
            $this->ControlsVisible["parcela_val_tierra"] = $this->parcela_val_tierra->Visible;
            $this->ControlsVisible["parcela_val_mejora"] = $this->parcela_val_mejora->Visible;
            $this->ControlsVisible["parcela_val_ampliac"] = $this->parcela_val_ampliac->Visible;
            $this->ControlsVisible["parcela_val_total"] = $this->parcela_val_total->Visible;
            $this->ControlsVisible["unidades_medidas_htm"] = $this->unidades_medidas_htm->Visible;
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["mejora_sup_cub"] = $this->mejora_sup_cub->Visible;
            $this->ControlsVisible["mejora_sup_semi_cub"] = $this->mejora_sup_semi_cub->Visible;
            $this->ControlsVisible["mejora_sup_cub_2"] = $this->mejora_sup_cub_2->Visible;
            $this->ControlsVisible["mejora_anio_construccion"] = $this->mejora_anio_construccion->Visible;
            $this->ControlsVisible["mejora_f_alta"] = $this->mejora_f_alta->Visible;
            $this->ControlsVisible["tipo_mejora_decla_descrip"] = $this->tipo_mejora_decla_descrip->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_partida->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->parcela_partida->Parameters = CCAddParam($this->parcela_partida->Parameters, "parcela_id", $this->DataSource->f("personas_parcelas_parcela_id"));
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->parcela_sup_uf->SetValue($this->DataSource->parcela_sup_uf->GetValue());
                $this->tipo_parcela_uso_descrip->SetValue($this->DataSource->tipo_parcela_uso_descrip->GetValue());
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->tipo_padron_parc_desc->SetValue($this->DataSource->tipo_padron_parc_desc->GetValue());
                $this->tipo_parcela_descrip->SetValue($this->DataSource->tipo_parcela_descrip->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->parcela_mzna->SetValue($this->DataSource->parcela_mzna->GetValue());
                $this->parcela_lote->SetValue($this->DataSource->parcela_lote->GetValue());
                $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                $this->parcela_val_mejora->SetValue($this->DataSource->parcela_val_mejora->GetValue());
                $this->parcela_val_ampliac->SetValue($this->DataSource->parcela_val_ampliac->GetValue());
                $this->parcela_val_total->SetValue($this->DataSource->parcela_val_total->GetValue());
                $this->unidades_medidas_htm->SetValue($this->DataSource->unidades_medidas_htm->GetValue());
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                $this->mejora_sup_semi_cub->SetValue($this->DataSource->mejora_sup_semi_cub->GetValue());
                $this->mejora_sup_cub_2->SetValue($this->DataSource->mejora_sup_cub_2->GetValue());
                $this->mejora_anio_construccion->SetValue($this->DataSource->mejora_anio_construccion->GetValue());
                $this->mejora_f_alta->SetValue($this->DataSource->mejora_f_alta->GetValue());
                $this->tipo_mejora_decla_descrip->SetValue($this->DataSource->tipo_mejora_decla_descrip->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_super_mensura->Show();
                $this->parcela_sup_uf->Show();
                $this->tipo_parcela_uso_descrip->Show();
                $this->tipo_est_parc_descr->Show();
                $this->tipo_depto_parc_desc->Show();
                $this->tipo_padron_parc_desc->Show();
                $this->tipo_parcela_descrip->Show();
                $this->parcela_seccion->Show();
                $this->parcela_macizo->Show();
                $this->parcela_parcela->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->parcela_mzna->Show();
                $this->parcela_lote->Show();
                $this->parcela_val_tierra->Show();
                $this->parcela_val_mejora->Show();
                $this->parcela_val_ampliac->Show();
                $this->parcela_val_total->Show();
                $this->unidades_medidas_htm->Show();
                $this->persona_denominacion->Show();
                $this->mejora_sup_cub->Show();
                $this->mejora_sup_semi_cub->Show();
                $this->mejora_sup_cub_2->Show();
                $this->mejora_anio_construccion->Show();
                $this->mejora_f_alta->Show();
                $this->tipo_mejora_decla_descrip->Show();
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
        $this->Sorter_parcela_partida->Show();
        $this->Sorter_parcela_super_mensura->Show();
        $this->Sorter_parcela_sup_uf->Show();
        $this->Sorter_tipo_parcela_uso_id->Show();
        $this->Sorter_tipo_est_parc_id->Show();
        $this->Sorter_tipo_depto_parc_id->Show();
        $this->Sorter_tipo_padron_parc_id->Show();
        $this->Sorter_tipo_parcela_id->Show();
        $this->Sorter_parcela_seccion->Show();
        $this->Sorter_parcela_macizo->Show();
        $this->Sorter_parcela_parcela->Show();
        $this->Sorter_parcela_chacra->Show();
        $this->Sorter_parcela_quinta->Show();
        $this->Sorter_parcela_fraccion->Show();
        $this->Sorter_parcela_uf->Show();
        $this->Sorter_parcela_predio->Show();
        $this->Sorter_parcela_rte->Show();
        $this->Sorter_parcela_mzna->Show();
        $this->Sorter_parcela_lote->Show();
        $this->Sorter_parcela_val_tierra->Show();
        $this->Sorter_parcela_val_mejora->Show();
        $this->Sorter_parcela_val_ampliac->Show();
        $this->Sorter_parcela_val_total->Show();
        $this->Navigator->Show();
        $this->super_mensura->Show();
        $this->super_uf->Show();
        $this->sum_val_tierra->Show();
        $this->sum_val_mejora->Show();
        $this->sum_val_amp->Show();
        $this->sum_val_tot->Show();
        $this->toXls->Show();
        $this->contador->Show();
        $this->Sorter_persona_denominacion->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @27-58853550
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_super_mensura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_sup_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_parcela_uso_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_parcela_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_mzna->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_lote->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_tierra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_mejora->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_ampliac->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_total->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidades_medidas_htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_cub->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_semi_cub->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_sup_cub_2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_anio_construccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_decla_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas Class @27-FCB6E20C

class clsparcelasDataSource extends clsDBtdf_nuevo {  //parcelasDataSource Class @27-DA23B507

//DataSource Variables @27-A5759FFC
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_super_mensura;
    public $parcela_sup_uf;
    public $tipo_parcela_uso_descrip;
    public $tipo_est_parc_descr;
    public $tipo_depto_parc_desc;
    public $tipo_padron_parc_desc;
    public $tipo_parcela_descrip;
    public $parcela_seccion;
    public $parcela_macizo;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $parcela_mzna;
    public $parcela_lote;
    public $parcela_val_tierra;
    public $parcela_val_mejora;
    public $parcela_val_ampliac;
    public $parcela_val_total;
    public $unidades_medidas_htm;
    public $persona_denominacion;
    public $mejora_sup_cub;
    public $mejora_sup_semi_cub;
    public $mejora_sup_cub_2;
    public $mejora_anio_construccion;
    public $mejora_f_alta;
    public $tipo_mejora_decla_descrip;
//End DataSource Variables

//DataSourceClass_Initialize Event @27-6F8F79CB
    function clsparcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->parcela_sup_uf = new clsField("parcela_sup_uf", ccsFloat, "");
        
        $this->tipo_parcela_uso_descrip = new clsField("tipo_parcela_uso_descrip", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->tipo_padron_parc_desc = new clsField("tipo_padron_parc_desc", ccsText, "");
        
        $this->tipo_parcela_descrip = new clsField("tipo_parcela_descrip", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->parcela_mzna = new clsField("parcela_mzna", ccsText, "");
        
        $this->parcela_lote = new clsField("parcela_lote", ccsText, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsText, "");
        
        $this->parcela_val_mejora = new clsField("parcela_val_mejora", ccsText, "");
        
        $this->parcela_val_ampliac = new clsField("parcela_val_ampliac", ccsText, "");
        
        $this->parcela_val_total = new clsField("parcela_val_total", ccsText, "");
        
        $this->unidades_medidas_htm = new clsField("unidades_medidas_htm", ccsText, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsText, "");
        
        $this->mejora_sup_semi_cub = new clsField("mejora_sup_semi_cub", ccsText, "");
        
        $this->mejora_sup_cub_2 = new clsField("mejora_sup_cub_2", ccsText, "");
        
        $this->mejora_anio_construccion = new clsField("mejora_anio_construccion", ccsText, "");
        
        $this->mejora_f_alta = new clsField("mejora_f_alta", ccsDate, $this->DateFormat);
        
        $this->tipo_mejora_decla_descrip = new clsField("tipo_mejora_decla_descrip", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @27-64C5B5B5
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcelas.parcela_partida desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_super_mensura" => array("parcela_super_mensura", ""), 
            "Sorter_parcela_sup_uf" => array("parcela_sup_uf", ""), 
            "Sorter_tipo_parcela_uso_id" => array("tipo_parcela_uso_id", ""), 
            "Sorter_tipo_est_parc_id" => array("tipo_est_parc_id", ""), 
            "Sorter_tipo_depto_parc_id" => array("tipo_depto_parc_id", ""), 
            "Sorter_tipo_padron_parc_id" => array("tipo_padron_parc_id", ""), 
            "Sorter_tipo_parcela_id" => array("tipo_parcela_id", ""), 
            "Sorter_parcela_seccion" => array("parcela_seccion", ""), 
            "Sorter_parcela_macizo" => array("parcela_macizo", ""), 
            "Sorter_parcela_parcela" => array("parcela_parcela", ""), 
            "Sorter_parcela_chacra" => array("parcela_chacra", ""), 
            "Sorter_parcela_quinta" => array("parcela_quinta", ""), 
            "Sorter_parcela_fraccion" => array("parcela_fraccion", ""), 
            "Sorter_parcela_uf" => array("parcela_uf", ""), 
            "Sorter_parcela_predio" => array("parcela_predio", ""), 
            "Sorter_parcela_rte" => array("parcela_rte", ""), 
            "Sorter_parcela_mzna" => array("parcela_mzna", ""), 
            "Sorter_parcela_lote" => array("parcela_lote", ""), 
            "Sorter_parcela_val_tierra" => array("parcela_val_tierra", ""), 
            "Sorter_parcela_val_mejora" => array("parcela_val_mejora", ""), 
            "Sorter_parcela_val_ampliac" => array("parcela_val_ampliac", ""), 
            "Sorter_parcela_val_total" => array("parcela_val_total", ""), 
            "Sorter_persona_denominacion" => array("persona_denominacion", "")));
    }
//End SetOrder Method

//Prepare Method @27-CDF01865
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_parcela_uso_id", ccsInteger, "", "", $this->Parameters["urls_tipo_parcela_uso_id"], "", false);
        $this->wp->AddParameter("2", "urls_tipo_est_parc_id", ccsInteger, "", "", $this->Parameters["urls_tipo_est_parc_id"], "", false);
        $this->wp->AddParameter("3", "urls_tipo_parcela_id", ccsInteger, "", "", $this->Parameters["urls_tipo_parcela_id"], "", false);
        $this->wp->AddParameter("4", "urls_tipo_depto_parc_id", ccsInteger, "", "", $this->Parameters["urls_tipo_depto_parc_id"], "", false);
        $this->wp->AddParameter("5", "urls_tipo_padron_parc_id", ccsInteger, "", "", $this->Parameters["urls_tipo_padron_parc_id"], "", false);
        $this->wp->AddParameter("6", "urls_parcela_seccion", ccsText, "", "", $this->Parameters["urls_parcela_seccion"], "", false);
        $this->wp->AddParameter("7", "urls_parcela_macizo", ccsText, "", "", $this->Parameters["urls_parcela_macizo"], "", false);
        $this->wp->AddParameter("8", "urls_parcela_parcela", ccsText, "", "", $this->Parameters["urls_parcela_parcela"], "", false);
        $this->wp->AddParameter("9", "urls_parcela_chacra", ccsText, "", "", $this->Parameters["urls_parcela_chacra"], "", false);
        $this->wp->AddParameter("10", "urls_parcela_quinta", ccsText, "", "", $this->Parameters["urls_parcela_quinta"], "", false);
        $this->wp->AddParameter("11", "urls_parcela_fraccion", ccsText, "", "", $this->Parameters["urls_parcela_fraccion"], "", false);
        $this->wp->AddParameter("12", "urls_parcela_uf", ccsText, "", "", $this->Parameters["urls_parcela_uf"], "", false);
        $this->wp->AddParameter("13", "urls_parcela_predio", ccsText, "", "", $this->Parameters["urls_parcela_predio"], "", false);
        $this->wp->AddParameter("14", "urlsup_min", ccsText, "", "", $this->Parameters["urlsup_min"], "", false);
        $this->wp->AddParameter("15", "urlsup_max", ccsText, "", "", $this->Parameters["urlsup_max"], "", false);
        $this->wp->AddParameter("16", "urls_tipo_restricc_parcela_id", ccsInteger, "", "", $this->Parameters["urls_tipo_restricc_parcela_id"], "", false);
        $this->wp->AddParameter("17", "urls_tipo_instrumento_id", ccsInteger, "", "", $this->Parameters["urls_tipo_instrumento_id"], "", false);
        $this->wp->AddParameter("18", "urls_persona_parcela_num_int", ccsText, "", "", $this->Parameters["urls_persona_parcela_num_int"], "", false);
        $this->wp->AddParameter("19", "urls_dist", ccsInteger, "", "", $this->Parameters["urls_dist"], "", false);
        $this->wp->AddParameter("20", "urls_persona_denominacion", ccsText, "", "", $this->Parameters["urls_persona_denominacion"], "", false);
        $this->wp->AddParameter("21", "urls_tipo_estado_id", ccsInteger, "", "", $this->Parameters["urls_tipo_estado_id"], "", false);
        $this->wp->AddParameter("22", "urls_tipo_plano_id", ccsInteger, "", "", $this->Parameters["urls_tipo_plano_id"], "", false);
        $this->wp->AddParameter("23", "urls_tipo_estado_plano_id", ccsInteger, "", "", $this->Parameters["urls_tipo_estado_plano_id"], "", false);
        $this->wp->AddParameter("24", "urls_plano_nro", ccsInteger, "", "", $this->Parameters["urls_plano_nro"], "", false);
        $this->wp->AddParameter("25", "urls_plano_anio", ccsInteger, "", "", $this->Parameters["urls_plano_anio"], "", false);
        $this->wp->AddParameter("26", "expr447", ccsInteger, "", "", $this->Parameters["expr447"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.tipo_parcela_uso_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "parcelas.tipo_est_parc_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "parcelas.tipo_parcela_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "parcelas.tipo_depto_parc_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "parcelas.tipo_padron_parc_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "parcelas.parcela_seccion", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "parcelas.parcela_macizo", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opContains, "parcelas.parcela_parcela", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "parcelas.parcela_chacra", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsText),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opEqual, "parcelas.parcela_quinta", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opEqual, "parcelas.parcela_fraccion", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
        $this->wp->Criterion[12] = $this->wp->Operation(opEqual, "parcelas.parcela_uf", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
        $this->wp->Criterion[13] = $this->wp->Operation(opEqual, "parcelas.parcela_predio", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsText),false);
        $this->wp->Criterion[14] = $this->wp->Operation(opGreaterThanOrEqual, "parcelas.parcela_super_mensura", $this->wp->GetDBValue("14"), $this->ToSQL($this->wp->GetDBValue("14"), ccsText),false);
        $this->wp->Criterion[15] = $this->wp->Operation(opLessThanOrEqual, "parcelas.parcela_nomenclatura", $this->wp->GetDBValue("15"), $this->ToSQL($this->wp->GetDBValue("15"), ccsText),false);
        $this->wp->Criterion[16] = $this->wp->Operation(opEqual, "parcelas_tipos_restricc.tipo_restricc_parcela_id", $this->wp->GetDBValue("16"), $this->ToSQL($this->wp->GetDBValue("16"), ccsInteger),false);
        $this->wp->Criterion[17] = $this->wp->Operation(opEqual, "personas_parcelas.tipo_instrumento_id", $this->wp->GetDBValue("17"), $this->ToSQL($this->wp->GetDBValue("17"), ccsInteger),false);
        $this->wp->Criterion[18] = $this->wp->Operation(opEqual, "personas_parcelas.persona_parcela_num_int", $this->wp->GetDBValue("18"), $this->ToSQL($this->wp->GetDBValue("18"), ccsText),false);
        $this->wp->Criterion[19] = $this->wp->Operation(opGreaterThanOrEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("19"), $this->ToSQL($this->wp->GetDBValue("19"), ccsInteger),false);
        $this->wp->Criterion[20] = $this->wp->Operation(opContains, "personas.persona_denominacion", $this->wp->GetDBValue("20"), $this->ToSQL($this->wp->GetDBValue("20"), ccsText),false);
        $this->wp->Criterion[21] = $this->wp->Operation(opEqual, "personas_parcelas.tipo_estado_id", $this->wp->GetDBValue("21"), $this->ToSQL($this->wp->GetDBValue("21"), ccsInteger),false);
        $this->wp->Criterion[22] = $this->wp->Operation(opEqual, "planos.tipo_plano_id", $this->wp->GetDBValue("22"), $this->ToSQL($this->wp->GetDBValue("22"), ccsInteger),false);
        $this->wp->Criterion[23] = $this->wp->Operation(opEqual, "planos.tipo_estado_plano_id", $this->wp->GetDBValue("23"), $this->ToSQL($this->wp->GetDBValue("23"), ccsInteger),false);
        $this->wp->Criterion[24] = $this->wp->Operation(opEqual, "planos.plano_nro", $this->wp->GetDBValue("24"), $this->ToSQL($this->wp->GetDBValue("24"), ccsInteger),false);
        $this->wp->Criterion[25] = $this->wp->Operation(opEqual, "planos.plano_anio", $this->wp->GetDBValue("25"), $this->ToSQL($this->wp->GetDBValue("25"), ccsInteger),false);
        $this->wp->Criterion[26] = $this->wp->Operation(opEqual, "mejoras.tipo_estado_id", $this->wp->GetDBValue("26"), $this->ToSQL($this->wp->GetDBValue("26"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]), 
             $this->wp->Criterion[6]), 
             $this->wp->Criterion[7]), 
             $this->wp->Criterion[8]), 
             $this->wp->Criterion[9]), 
             $this->wp->Criterion[10]), 
             $this->wp->Criterion[11]), 
             $this->wp->Criterion[12]), 
             $this->wp->Criterion[13]), 
             $this->wp->Criterion[14]), 
             $this->wp->Criterion[15]), 
             $this->wp->Criterion[16]), 
             $this->wp->Criterion[17]), 
             $this->wp->Criterion[18]), 
             $this->wp->Criterion[19]), 
             $this->wp->Criterion[20]), 
             $this->wp->Criterion[21]), 
             $this->wp->Criterion[22]), 
             $this->wp->Criterion[23]), 
             $this->wp->Criterion[24]), 
             $this->wp->Criterion[25]), 
             $this->wp->Criterion[26]);
    }
//End Prepare Method

//Open Method @27-7334F6BA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT parcelas.parcela_id AS parcelas_parcela_id, parcela_partida, parcela_super_mensura, parcela_sup_uf, parcelas.tipo_parcela_uso_id AS parcelas_tipo_parcela_uso_id,\n\n" .
        "parcelas.tipo_parcela_alta_id AS parcelas_tipo_parcela_alta_id, parcelas.tipo_est_parc_id AS parcelas_tipo_est_parc_id,\n\n" .
        "parcelas.tipo_depto_parc_id AS parcelas_tipo_depto_parc_id, parcelas.tipo_padron_parc_id AS parcelas_tipo_padron_parc_id,\n\n" .
        "parcelas.tipo_parcela_id AS parcelas_tipo_parcela_id, parcela_seccion, parcela_macizo, parcela_parcela, parcela_chacra,\n\n" .
        "parcela_quinta, parcela_fraccion, parcela_uf, parcela_predio, parcela_rte, parcela_mzna, parcela_lote, parcela_val_tierra,\n\n" .
        "parcela_val_mejora, parcela_val_ampliac, parcela_val_total, tipo_parcela_uso_descrip, tipo_est_parc_descr, tipo_parcela_descrip,\n\n" .
        "tipo_depto_parc_desc, tipo_padron_parc_desc, parcelas_tipos_restricc.tipo_restricc_parcela_id AS parcelas_tipos_restricc_tipo_restricc_parcela_id,\n\n" .
        "personas_parcelas.tipo_instrumento_id AS personas_parcelas_tipo_instrumento_id, persona_parcela_num_int, unidades_medidas_htm,\n\n" .
        "tipo_depto_parc_abrev, tipo_padron_parc_abrev, parcela_porc_uf, parcela_receptividad, parcela_obs_rural, parcela_dist_pto,\n\n" .
        "parcela_notas_nom, parcela_observa, unidades_medidas_abrev, tipo_parcela_abrev, tipo_est_parc_abrev, tipo_parcela_uso_abrev,\n\n" .
        "persona_denominacion, mejora_sup_cub, mejora_sup_semi_cub, mejora_sup_cub_2, mejora_anio_construccion, mejora_f_alta, mejoras.tipo_mejora_decla_id AS mejoras_tipo_mejora_decla_id,\n\n" .
        "tipo_mejora_decla_descrip, personas_parcelas.parcela_id AS personas_parcelas_parcela_id \n\n" .
        "FROM ((((((((((((parcelas LEFT JOIN tipos_parcelas_usos ON\n\n" .
        "parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN tipos_parcelas ON\n\n" .
        "parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id) LEFT JOIN parcelas_tipos_restricc ON\n\n" .
        "parcelas_tipos_restricc.parcela_id = parcelas.parcela_id) INNER JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.parcela_id = parcelas.parcela_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN uniones_desgloses ON\n\n" .
        "uniones_desgloses.parcela_destino_id = parcelas.parcela_id) LEFT JOIN mejoras ON\n\n" .
        "mejoras.parcela_id = parcelas.parcela_id) INNER JOIN personas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id) LEFT JOIN planos ON\n\n" .
        "uniones_desgloses.plano_id = planos.plano_id) LEFT JOIN tipos_mejoras_decla ON\n\n" .
        "mejoras.tipo_mejora_decla_id = tipos_mejoras_decla.tipo_mejora_decla_id {SQL_Where}\n\n" .
        "GROUP BY parcelas.parcela_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @27-F437D0D8
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->parcela_sup_uf->SetDBValue(trim($this->f("parcela_sup_uf")));
        $this->tipo_parcela_uso_descrip->SetDBValue($this->f("tipo_parcela_uso_descrip"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->tipo_padron_parc_desc->SetDBValue($this->f("tipo_padron_parc_desc"));
        $this->tipo_parcela_descrip->SetDBValue($this->f("tipo_parcela_descrip"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->parcela_mzna->SetDBValue($this->f("parcela_mzna"));
        $this->parcela_lote->SetDBValue($this->f("parcela_lote"));
        $this->parcela_val_tierra->SetDBValue($this->f("parcela_val_tierra"));
        $this->parcela_val_mejora->SetDBValue($this->f("parcela_val_mejora"));
        $this->parcela_val_ampliac->SetDBValue($this->f("parcela_val_ampliac"));
        $this->parcela_val_total->SetDBValue($this->f("parcela_val_total"));
        $this->unidades_medidas_htm->SetDBValue($this->f("unidades_medidas_htm"));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->mejora_sup_cub->SetDBValue($this->f("mejora_sup_cub"));
        $this->mejora_sup_semi_cub->SetDBValue($this->f("mejora_sup_semi_cub"));
        $this->mejora_sup_cub_2->SetDBValue($this->f("mejora_sup_cub_2"));
        $this->mejora_anio_construccion->SetDBValue($this->f("mejora_anio_construccion"));
        $this->mejora_f_alta->SetDBValue(trim($this->f("mejora_f_alta")));
        $this->tipo_mejora_decla_descrip->SetDBValue($this->f("tipo_mejora_decla_descrip"));
    }
//End SetValues Method

} //End parcelasDataSource Class @27-FCB6E20C

//Initialize Page @1-FD6598CD
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
$TemplateFileName = "est_parcela_cant_mejora.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-17B9EBFA
include_once("./est_parcela_cant_mejora_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-8B4DEAD1
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
$parcelasSearch = new clsRecordparcelasSearch("", $MainPage);
$parcelas = new clsGridparcelas("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->parcelasSearch = & $parcelasSearch;
$MainPage->parcelas = & $parcelas;
$parcelas->Initialize();

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

//Execute Components @1-82DAD84E
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$parcelasSearch->Operation();
//End Execute Components

//Go to destination page @1-03123FC4
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
    unset($parcelasSearch);
    unset($parcelas);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-FC1E63FB
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$parcelasSearch->Show();
$parcelas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font fa" . "ce=\"Arial\"><small>G" . "e&#110;&#101;rat" . "e&#100; <!-- SCC " . "-->w&#105;&#116;&" . "#104; <!-- SCC -->&#" . "67;&#111;de&#67" . ";h&#97;r&#103;&#1" . "01; <!-- SCC -->&#" . "83;tu&#100;io.</s" . "mall></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font fa" . "ce=\"Arial\"><small>G" . "e&#110;&#101;rat" . "e&#100; <!-- SCC " . "-->w&#105;&#116;&" . "#104; <!-- SCC -->&#" . "67;&#111;de&#67" . ";h&#97;r&#103;&#1" . "01; <!-- SCC -->&#" . "83;tu&#100;io.</s" . "mall></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font fa" . "ce=\"Arial\"><small>G" . "e&#110;&#101;rat" . "e&#100; <!-- SCC " . "-->w&#105;&#116;&" . "#104; <!-- SCC -->&#" . "67;&#111;de&#67" . ";h&#97;r&#103;&#1" . "01; <!-- SCC -->&#" . "83;tu&#100;io.</s" . "mall></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A88C3E53
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelasSearch);
unset($parcelas);
unset($Tpl);
//End Unload Page


?>
