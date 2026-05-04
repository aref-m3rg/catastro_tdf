<?php
//Include Common Files @1-CE159FE5
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_planosVista.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

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

//Class_Initialize Event @5-9800F222
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
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->tipo_depto_parc_id = new clsControl(ccsLabel, "tipo_depto_parc_id", "Departamento", ccsText, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->plano_e_nro = new clsControl(ccsLabel, "plano_e_nro", "E Nro", ccsInteger, "", CCGetRequestParam("plano_e_nro", $Method, NULL), $this);
            $this->plano_f_entrada = new clsControl(ccsLabel, "plano_f_entrada", "F Entrada", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("plano_f_entrada", $Method, NULL), $this);
            $this->plano_e_letra = new clsControl(ccsLabel, "plano_e_letra", "E Letra", ccsText, "", CCGetRequestParam("plano_e_letra", $Method, NULL), $this);
            $this->plano_e_anio = new clsControl(ccsLabel, "plano_e_anio", "E Anio", ccsInteger, "", CCGetRequestParam("plano_e_anio", $Method, NULL), $this);
            $this->plano_observa = new clsControl(ccsLabel, "plano_observa", "plano_observa", ccsText, "", CCGetRequestParam("plano_observa", $Method, NULL), $this);
            $this->plano_f_archivo = new clsControl(ccsLabel, "plano_f_archivo", "F Archivo", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("plano_f_archivo", $Method, NULL), $this);
            $this->plano_f_inicio = new clsControl(ccsLabel, "plano_f_inicio", "F Inicio", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("plano_f_inicio", $Method, NULL), $this);
            $this->plano_f_salida = new clsControl(ccsLabel, "plano_f_salida", "F Salida", ccsDate, array("mm", "/", "dd", "/", "yyyy"), CCGetRequestParam("plano_f_salida", $Method, NULL), $this);
            $this->prof_id_2 = new clsControl(ccsLabel, "prof_id_2", "Profesional 2", ccsText, "", CCGetRequestParam("prof_id_2", $Method, NULL), $this);
            $this->tipo_plano_id = new clsControl(ccsLabel, "tipo_plano_id", "Tipo Id", ccsText, "", CCGetRequestParam("tipo_plano_id", $Method, NULL), $this);
            $this->plano_anio = new clsControl(ccsLabel, "plano_anio", "Anio", ccsInteger, "", CCGetRequestParam("plano_anio", $Method, NULL), $this);
            $this->plano_nro = new clsControl(ccsLabel, "plano_nro", "Nro", ccsInteger, "", CCGetRequestParam("plano_nro", $Method, NULL), $this);
            $this->plano_f_registro = new clsControl(ccsLabel, "plano_f_registro", "plano_f_registro", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("plano_f_registro", $Method, NULL), $this);
            $this->plano_estado_desc = new clsControl(ccsLabel, "plano_estado_desc", "plano_estado_desc", ccsText, "", CCGetRequestParam("plano_estado_desc", $Method, NULL), $this);
            $this->plano_sin_origen = new clsControl(ccsLabel, "plano_sin_origen", "Plano de Tierras Fiscales sin Mensurar", ccsInteger, "", CCGetRequestParam("plano_sin_origen", $Method, NULL), $this);
            $this->plano_svc = new clsControl(ccsLabel, "plano_svc", "Sin Vigencia Catastral", ccsText, "", CCGetRequestParam("plano_svc", $Method, NULL), $this);
            $this->plano_disposicion = new clsControl(ccsLabel, "plano_disposicion", "plano_disposicion", ccsInteger, "", CCGetRequestParam("plano_disposicion", $Method, NULL), $this);
            $this->plano_en_edicion = new clsControl(ccsLabel, "plano_en_edicion", "plano_en_edicion", ccsBoolean, array("Sí", "No", ""), CCGetRequestParam("plano_en_edicion", $Method, NULL), $this);
            $this->plano_archivo = new clsControl(ccsLabel, "plano_archivo", "plano_archivo", ccsText, "", CCGetRequestParam("plano_archivo", $Method, NULL), $this);
            $this->plano_f_alta = new clsControl(ccsLabel, "plano_f_alta", "F Alta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("plano_f_alta", $Method, NULL), $this);
            $this->profesional_1 = new clsControl(ccsLabel, "profesional_1", "profesional_1", ccsText, "", CCGetRequestParam("profesional_1", $Method, NULL), $this);
            if(!is_array($this->plano_anio->Value) && !strlen($this->plano_anio->Value) && $this->plano_anio->Value !== false)
                $this->plano_anio->SetText(date(Y));
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

//Validate Method @5-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-74687807
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->plano_e_nro->Errors->Count());
        $errors = ($errors || $this->plano_f_entrada->Errors->Count());
        $errors = ($errors || $this->plano_e_letra->Errors->Count());
        $errors = ($errors || $this->plano_e_anio->Errors->Count());
        $errors = ($errors || $this->plano_observa->Errors->Count());
        $errors = ($errors || $this->plano_f_archivo->Errors->Count());
        $errors = ($errors || $this->plano_f_inicio->Errors->Count());
        $errors = ($errors || $this->plano_f_salida->Errors->Count());
        $errors = ($errors || $this->prof_id_2->Errors->Count());
        $errors = ($errors || $this->tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->plano_anio->Errors->Count());
        $errors = ($errors || $this->plano_nro->Errors->Count());
        $errors = ($errors || $this->plano_f_registro->Errors->Count());
        $errors = ($errors || $this->plano_estado_desc->Errors->Count());
        $errors = ($errors || $this->plano_sin_origen->Errors->Count());
        $errors = ($errors || $this->plano_svc->Errors->Count());
        $errors = ($errors || $this->plano_disposicion->Errors->Count());
        $errors = ($errors || $this->plano_en_edicion->Errors->Count());
        $errors = ($errors || $this->plano_archivo->Errors->Count());
        $errors = ($errors || $this->plano_f_alta->Errors->Count());
        $errors = ($errors || $this->profesional_1->Errors->Count());
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

//Operation Method @5-17DC9883
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

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//Show Method @5-F02CE27C
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
                $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                $this->plano_e_nro->SetValue($this->DataSource->plano_e_nro->GetValue());
                $this->plano_f_entrada->SetValue($this->DataSource->plano_f_entrada->GetValue());
                $this->plano_e_letra->SetValue($this->DataSource->plano_e_letra->GetValue());
                $this->plano_e_anio->SetValue($this->DataSource->plano_e_anio->GetValue());
                $this->plano_observa->SetValue($this->DataSource->plano_observa->GetValue());
                $this->plano_f_archivo->SetValue($this->DataSource->plano_f_archivo->GetValue());
                $this->plano_f_inicio->SetValue($this->DataSource->plano_f_inicio->GetValue());
                $this->plano_f_salida->SetValue($this->DataSource->plano_f_salida->GetValue());
                $this->prof_id_2->SetValue($this->DataSource->prof_id_2->GetValue());
                $this->tipo_plano_id->SetValue($this->DataSource->tipo_plano_id->GetValue());
                $this->plano_anio->SetValue($this->DataSource->plano_anio->GetValue());
                $this->plano_nro->SetValue($this->DataSource->plano_nro->GetValue());
                $this->plano_f_registro->SetValue($this->DataSource->plano_f_registro->GetValue());
                $this->plano_estado_desc->SetValue($this->DataSource->plano_estado_desc->GetValue());
                $this->plano_sin_origen->SetValue($this->DataSource->plano_sin_origen->GetValue());
                $this->plano_svc->SetValue($this->DataSource->plano_svc->GetValue());
                $this->plano_disposicion->SetValue($this->DataSource->plano_disposicion->GetValue());
                $this->plano_en_edicion->SetValue($this->DataSource->plano_en_edicion->GetValue());
                $this->plano_archivo->SetValue($this->DataSource->plano_archivo->GetValue());
                $this->plano_f_alta->SetValue($this->DataSource->plano_f_alta->GetValue());
                $this->profesional_1->SetValue($this->DataSource->profesional_1->GetValue());
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_entrada->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_e_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_observa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_inicio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_salida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->prof_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_registro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_estado_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_sin_origen->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_svc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_disposicion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_en_edicion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_archivo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_f_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->profesional_1->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->tipo_depto_parc_id->Show();
        $this->plano_e_nro->Show();
        $this->plano_f_entrada->Show();
        $this->plano_e_letra->Show();
        $this->plano_e_anio->Show();
        $this->plano_observa->Show();
        $this->plano_f_archivo->Show();
        $this->plano_f_inicio->Show();
        $this->plano_f_salida->Show();
        $this->prof_id_2->Show();
        $this->tipo_plano_id->Show();
        $this->plano_anio->Show();
        $this->plano_nro->Show();
        $this->plano_f_registro->Show();
        $this->plano_estado_desc->Show();
        $this->plano_sin_origen->Show();
        $this->plano_svc->Show();
        $this->plano_disposicion->Show();
        $this->plano_en_edicion->Show();
        $this->plano_archivo->Show();
        $this->plano_f_alta->Show();
        $this->profesional_1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End planos Class @5-FCB6E20C

class clsplanosDataSource extends clsDBtdf_nuevo {  //planosDataSource Class @5-B9DB091D

//DataSource Variables @5-8339F803
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $tipo_depto_parc_id;
    public $plano_e_nro;
    public $plano_f_entrada;
    public $plano_e_letra;
    public $plano_e_anio;
    public $plano_observa;
    public $plano_f_archivo;
    public $plano_f_inicio;
    public $plano_f_salida;
    public $prof_id_2;
    public $tipo_plano_id;
    public $plano_anio;
    public $plano_nro;
    public $plano_f_registro;
    public $plano_estado_desc;
    public $plano_sin_origen;
    public $plano_svc;
    public $plano_disposicion;
    public $plano_en_edicion;
    public $plano_archivo;
    public $plano_f_alta;
    public $profesional_1;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-B7852E44
    function clsplanosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record planos/Error";
        $this->Initialize();
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsText, "");
        
        $this->plano_e_nro = new clsField("plano_e_nro", ccsInteger, "");
        
        $this->plano_f_entrada = new clsField("plano_f_entrada", ccsDate, $this->DateFormat);
        
        $this->plano_e_letra = new clsField("plano_e_letra", ccsText, "");
        
        $this->plano_e_anio = new clsField("plano_e_anio", ccsInteger, "");
        
        $this->plano_observa = new clsField("plano_observa", ccsText, "");
        
        $this->plano_f_archivo = new clsField("plano_f_archivo", ccsDate, $this->DateFormat);
        
        $this->plano_f_inicio = new clsField("plano_f_inicio", ccsDate, $this->DateFormat);
        
        $this->plano_f_salida = new clsField("plano_f_salida", ccsDate, $this->DateFormat);
        
        $this->prof_id_2 = new clsField("prof_id_2", ccsText, "");
        
        $this->tipo_plano_id = new clsField("tipo_plano_id", ccsText, "");
        
        $this->plano_anio = new clsField("plano_anio", ccsInteger, "");
        
        $this->plano_nro = new clsField("plano_nro", ccsInteger, "");
        
        $this->plano_f_registro = new clsField("plano_f_registro", ccsDate, $this->DateFormat);
        
        $this->plano_estado_desc = new clsField("plano_estado_desc", ccsText, "");
        
        $this->plano_sin_origen = new clsField("plano_sin_origen", ccsInteger, "");
        
        $this->plano_svc = new clsField("plano_svc", ccsText, "");
        
        $this->plano_disposicion = new clsField("plano_disposicion", ccsInteger, "");
        
        $this->plano_en_edicion = new clsField("plano_en_edicion", ccsBoolean, $this->BooleanFormat);
        
        $this->plano_archivo = new clsField("plano_archivo", ccsText, "");
        
        $this->plano_f_alta = new clsField("plano_f_alta", ccsDate, $this->DateFormat);
        
        $this->profesional_1 = new clsField("profesional_1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @5-911DE3E6
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @5-AE8FB24B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT planos.*, tipo_depto_parc_desc, tipos_planos.*, profesionales.prof_nombre AS profesionales_prof_nombre, profesionales2.prof_nombre AS profesionales2_prof_nombre \n\n" .
        "FROM (((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id) LEFT JOIN profesionales ON\n\n" .
        "planos.profesional_id = profesionales.prof_id) LEFT JOIN profesionales profesionales2 ON\n\n" .
        "planos.profesional_id_2 = profesionales2.prof_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-52B8F036
    function SetValues()
    {
        $this->tipo_depto_parc_id->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->plano_e_nro->SetDBValue(trim($this->f("plano_e_nro")));
        $this->plano_f_entrada->SetDBValue(trim($this->f("plano_f_entrada")));
        $this->plano_e_letra->SetDBValue($this->f("plano_e_letra"));
        $this->plano_e_anio->SetDBValue(trim($this->f("plano_e_anio")));
        $this->plano_observa->SetDBValue($this->f("plano_observa"));
        $this->plano_f_archivo->SetDBValue(trim($this->f("plano_f_archivo")));
        $this->plano_f_inicio->SetDBValue(trim($this->f("plano_f_inicio")));
        $this->plano_f_salida->SetDBValue(trim($this->f("plano_f_salida")));
        $this->prof_id_2->SetDBValue($this->f("profesionales2_prof_nombre"));
        $this->tipo_plano_id->SetDBValue($this->f("tipo_plano_desc"));
        $this->plano_anio->SetDBValue(trim($this->f("plano_anio")));
        $this->plano_nro->SetDBValue(trim($this->f("plano_nro")));
        $this->plano_f_registro->SetDBValue(trim($this->f("plano_f_registro")));
        $this->plano_estado_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->plano_sin_origen->SetDBValue(trim($this->f("plano_sin_origen")));
        $this->plano_svc->SetDBValue($this->f("plano_svc"));
        $this->plano_disposicion->SetDBValue(trim($this->f("plano_disposicion")));
        $this->plano_en_edicion->SetDBValue(trim($this->f("plano_en_edicion")));
        $this->plano_archivo->SetDBValue($this->f("plano_archivo"));
        $this->plano_f_alta->SetDBValue(trim($this->f("plano_f_alta")));
        $this->profesional_1->SetDBValue($this->f("profesionales_prof_nombre"));
    }
//End SetValues Method

} //End planosDataSource Class @5-FCB6E20C



class clsGridparcelas_destino { //parcelas_destino class @437-500892BD

//Variables @437-6E51DF5A

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

//Class_Initialize Event @437-959D6026
    function clsGridparcelas_destino($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_destino";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_destino";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_destinoDataSource($this);
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
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @437-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @437-4C6A943B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);

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
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @437-81CF7466
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
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_destino Class @437-FCB6E20C

class clsparcelas_destinoDataSource extends clsDBtdf_nuevo {  //parcelas_destinoDataSource Class @437-8D5A2ED2

//DataSource Variables @437-465EC1D8
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

//DataSourceClass_Initialize Event @437-13DC2AF8
    function clsparcelas_destinoDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_destino";
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

//SetOrder Method @437-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @437-2286F396
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "uniones_desgloses.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @437-129D0FD7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT parcelas.*, tipo_est_parc_descr \n\n" .
        "FROM (parcelas LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) INNER JOIN uniones_desgloses ON\n\n" .
        "uniones_desgloses.parcela_destino_id = parcelas.parcela_id {SQL_Where}\n\n" .
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

//SetValues Method @437-03B80C01
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

} //End parcelas_destinoDataSource Class @437-FCB6E20C

class clsGridparcelas_origen { //parcelas_origen class @541-6561CDBF

//Variables @541-6E51DF5A

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

//Class_Initialize Event @541-422E16ED
    function clsGridparcelas_origen($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_origen";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_origen";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_origenDataSource($this);
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
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @541-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @541-4C6A943B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplano_id"] = CCGetFromGet("plano_id", NULL);

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
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @541-81CF7466
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
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_origen Class @541-FCB6E20C

class clsparcelas_origenDataSource extends clsDBtdf_nuevo {  //parcelas_origenDataSource Class @541-C56AC843

//DataSource Variables @541-465EC1D8
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

//DataSourceClass_Initialize Event @541-051747A5
    function clsparcelas_origenDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_origen";
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

//SetOrder Method @541-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @541-2286F396
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "uniones_desgloses.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @541-676A879F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT parcelas.*, tipo_est_parc_descr \n\n" .
        "FROM (parcelas LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) INNER JOIN uniones_desgloses ON\n\n" .
        "uniones_desgloses.parcela_id = parcelas.parcela_id {SQL_Where}\n\n" .
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

//SetValues Method @541-03B80C01
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

} //End parcelas_origenDataSource Class @541-FCB6E20C











//Initialize Page @1-EDBC54AD
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
$TemplateFileName = "tc_planosVista.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-E99D6B2A
include_once("./tc_planosVista_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7A616202
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$planos = new clsRecordplanos("", $MainPage);
$parcelas_destino = new clsGridparcelas_destino("", $MainPage);
$parcelas_origen = new clsGridparcelas_origen("", $MainPage);
$MainPage->planos = & $planos;
$MainPage->parcelas_destino = & $parcelas_destino;
$MainPage->parcelas_origen = & $parcelas_origen;
$planos->Initialize();
$parcelas_destino->Initialize();
$parcelas_origen->Initialize();

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

//Execute Components @1-E03A0277
$planos->Operation();
//End Execute Components

//Go to destination page @1-3C82E975
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($planos);
    unset($parcelas_destino);
    unset($parcelas_origen);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-F64732F1
$planos->Show();
$parcelas_destino->Show();
$parcelas_origen->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$ETSOJR9D5K2E = explode("|", "<center><font| face=\"Arial|\"><small>G&#101;|nera&#116;&#10|1;&#100; <!-|- SCC -->wi&#|116;h <!-- C|CS -->CodeChar&#1|03;&#101; <!-- CC|S -->&#83;tu&#|100;io.</small><|/font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($ETSOJR9D5K2E,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($ETSOJR9D5K2E,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($ETSOJR9D5K2E,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-81C763C6
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBcatastro->close();
unset($planos);
unset($parcelas_destino);
unset($parcelas_origen);
unset($Tpl);
//End Unload Page


?>
