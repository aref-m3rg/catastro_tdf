<?php
//Include Common Files @1-36222386
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_planosGrid.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
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



class clsRecorddepartamentos_planos_plan1 { //departamentos_planos_plan1 Class @44-D91595C0

//Variables @44-9E315808

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

//Class_Initialize Event @44-22D6EFAC
    function clsRecorddepartamentos_planos_plan1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record departamentos_planos_plan1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "departamentos_planos_plan1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_dpto_id = new clsControl(ccsListBox, "s_dpto_id", "s_dpto_id", ccsInteger, "", CCGetRequestParam("s_dpto_id", $Method, NULL), $this);
            $this->s_dpto_id->DSType = dsTable;
            $this->s_dpto_id->DataSource = new clsDBtdf_nuevo();
            $this->s_dpto_id->ds = & $this->s_dpto_id->DataSource;
            $this->s_dpto_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_dpto_id->BoundColumn, $this->s_dpto_id->TextColumn, $this->s_dpto_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->s_tipo_plano_id = new clsControl(ccsListBox, "s_tipo_plano_id", "s_tipo_plano_id", ccsInteger, "", CCGetRequestParam("s_tipo_plano_id", $Method, NULL), $this);
            $this->s_tipo_plano_id->DSType = dsTable;
            $this->s_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_plano_id->ds = & $this->s_tipo_plano_id->DataSource;
            $this->s_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_plano_id->BoundColumn, $this->s_tipo_plano_id->TextColumn, $this->s_tipo_plano_id->DBFormat) = array("tipo_plano_id", "tipo_plano_desc", "");
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->s_plano_e_nro = new clsControl(ccsTextBox, "s_plano_e_nro", "E Nro", ccsInteger, "", CCGetRequestParam("s_plano_e_nro", $Method, NULL), $this);
            $this->s_plano_e_letra = new clsControl(ccsTextBox, "s_plano_e_letra", "E Letra", ccsText, "", CCGetRequestParam("s_plano_e_letra", $Method, NULL), $this);
            $this->s_plano_e_anio = new clsControl(ccsTextBox, "s_plano_e_anio", "E Anio", ccsInteger, "", CCGetRequestParam("s_plano_e_anio", $Method, NULL), $this);
            $this->s_parcela_seccion = new clsControl(ccsTextBox, "s_parcela_seccion", "s_parcela_seccion", ccsText, "", CCGetRequestParam("s_parcela_seccion", $Method, NULL), $this);
            $this->s_parcela_chacra = new clsControl(ccsTextBox, "s_parcela_chacra", "s_parcela_chacra", ccsText, "", CCGetRequestParam("s_parcela_chacra", $Method, NULL), $this);
            $this->s_parcela_quinta = new clsControl(ccsTextBox, "s_parcela_quinta", "s_parcela_quinta", ccsText, "", CCGetRequestParam("s_parcela_quinta", $Method, NULL), $this);
            $this->s_parcela_macizo = new clsControl(ccsTextBox, "s_parcela_macizo", "s_parcela_macizo", ccsText, "", CCGetRequestParam("s_parcela_macizo", $Method, NULL), $this);
            $this->s_parcela_fraccion = new clsControl(ccsTextBox, "s_parcela_fraccion", "s_parcela_fraccion", ccsText, "", CCGetRequestParam("s_parcela_fraccion", $Method, NULL), $this);
            $this->s_parcela_parcela = new clsControl(ccsTextBox, "s_parcela_parcela", "s_parcela_parcela", ccsText, "", CCGetRequestParam("s_parcela_parcela", $Method, NULL), $this);
            $this->s_parcela_uf = new clsControl(ccsTextBox, "s_parcela_uf", "s_parcela_uf", ccsText, "", CCGetRequestParam("s_parcela_uf", $Method, NULL), $this);
            $this->s_prof_id = new clsControl(ccsListBox, "s_prof_id", "s_prof_id", ccsInteger, "", CCGetRequestParam("s_prof_id", $Method, NULL), $this);
            $this->s_prof_id->DSType = dsTable;
            $this->s_prof_id->DataSource = new clsDBtdf_nuevo();
            $this->s_prof_id->ds = & $this->s_prof_id->DataSource;
            $this->s_prof_id->DataSource->SQL = "SELECT * \n" .
"FROM profesionales {SQL_Where} {SQL_OrderBy}";
            list($this->s_prof_id->BoundColumn, $this->s_prof_id->TextColumn, $this->s_prof_id->DBFormat) = array("prof_id", "prof_nombre", "");
            $this->s_tipo_estado_plano_id = new clsControl(ccsListBox, "s_tipo_estado_plano_id", "Est Id", ccsInteger, "", CCGetRequestParam("s_tipo_estado_plano_id", $Method, NULL), $this);
            $this->s_tipo_estado_plano_id->DSType = dsTable;
            $this->s_tipo_estado_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_estado_plano_id->ds = & $this->s_tipo_estado_plano_id->DataSource;
            $this->s_tipo_estado_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_planos {SQL_Where} {SQL_OrderBy}";
            $this->s_tipo_estado_plano_id->DataSource->Order = "tipo_estado_plano_desc";
            list($this->s_tipo_estado_plano_id->BoundColumn, $this->s_tipo_estado_plano_id->TextColumn, $this->s_tipo_estado_plano_id->DBFormat) = array("tipo_estado_plano_id", "tipo_estado_plano_desc", "");
            $this->s_tipo_estado_plano_id->DataSource->Order = "tipo_estado_plano_desc";
            $this->s_plano_nro = new clsControl(ccsTextBox, "s_plano_nro", "s_plano_nro", ccsInteger, "", CCGetRequestParam("s_plano_nro", $Method, NULL), $this);
            $this->s_plano_anio = new clsControl(ccsListBox, "s_plano_anio", "s_plano_anio", ccsInteger, "", CCGetRequestParam("s_plano_anio", $Method, NULL), $this);
            $this->s_plano_anio->DSType = dsTable;
            $this->s_plano_anio->DataSource = new clsDBtdf_nuevo();
            $this->s_plano_anio->ds = & $this->s_plano_anio->DataSource;
            $this->s_plano_anio->DataSource->SQL = "SELECT * \n" .
"FROM planos {SQL_Where}\n" .
"GROUP BY plano_anio {SQL_OrderBy}";
            $this->s_plano_anio->DataSource->Order = "plano_anio";
            list($this->s_plano_anio->BoundColumn, $this->s_plano_anio->TextColumn, $this->s_plano_anio->DBFormat) = array("plano_anio", "plano_anio", "");
            $this->s_plano_anio->DataSource->Order = "plano_anio";
            $this->s_persona_denominacion = new clsControl(ccsTextBox, "s_persona_denominacion", "s_persona_denominacion", ccsText, "", CCGetRequestParam("s_persona_denominacion", $Method, NULL), $this);
            $this->s_persona_nro_doc = new clsControl(ccsTextBox, "s_persona_nro_doc", "s_persona_nro_doc", ccsText, "", CCGetRequestParam("s_persona_nro_doc", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @44-0D59C211
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_dpto_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->s_plano_e_nro->Validate() && $Validation);
        $Validation = ($this->s_plano_e_letra->Validate() && $Validation);
        $Validation = ($this->s_plano_e_anio->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf->Validate() && $Validation);
        $Validation = ($this->s_prof_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_estado_plano_id->Validate() && $Validation);
        $Validation = ($this->s_plano_nro->Validate() && $Validation);
        $Validation = ($this->s_plano_anio->Validate() && $Validation);
        $Validation = ($this->s_persona_denominacion->Validate() && $Validation);
        $Validation = ($this->s_persona_nro_doc->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_e_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_e_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_e_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_prof_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_estado_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_nro_doc->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @44-137B6F0E
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_dpto_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->s_plano_e_nro->Errors->Count());
        $errors = ($errors || $this->s_plano_e_letra->Errors->Count());
        $errors = ($errors || $this->s_plano_e_anio->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf->Errors->Count());
        $errors = ($errors || $this->s_prof_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_estado_plano_id->Errors->Count());
        $errors = ($errors || $this->s_plano_nro->Errors->Count());
        $errors = ($errors || $this->s_plano_anio->Errors->Count());
        $errors = ($errors || $this->s_persona_denominacion->Errors->Count());
        $errors = ($errors || $this->s_persona_nro_doc->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @44-ED598703
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

//Operation Method @44-30124D0F
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
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "tc_planosGrid.php";
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tc_planosGrid.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @44-74AC39C4
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

        $this->s_dpto_id->Prepare();
        $this->s_tipo_plano_id->Prepare();
        $this->s_prof_id->Prepare();
        $this->s_tipo_estado_plano_id->Prepare();
        $this->s_plano_anio->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_e_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_e_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_e_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_prof_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_estado_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_nro_doc->Errors->ToString());
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

        $this->Button_DoSearch->Show();
        $this->s_dpto_id->Show();
        $this->s_tipo_plano_id->Show();
        $this->Button1->Show();
        $this->s_plano_e_nro->Show();
        $this->s_plano_e_letra->Show();
        $this->s_plano_e_anio->Show();
        $this->s_parcela_seccion->Show();
        $this->s_parcela_chacra->Show();
        $this->s_parcela_quinta->Show();
        $this->s_parcela_macizo->Show();
        $this->s_parcela_fraccion->Show();
        $this->s_parcela_parcela->Show();
        $this->s_parcela_uf->Show();
        $this->s_prof_id->Show();
        $this->s_tipo_estado_plano_id->Show();
        $this->s_plano_nro->Show();
        $this->s_plano_anio->Show();
        $this->s_persona_denominacion->Show();
        $this->s_persona_nro_doc->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End departamentos_planos_plan1 Class @44-FCB6E20C

class clsGridplanos_listado { //planos_listado class @352-E9A3357D

//Variables @352-6E51DF5A

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

//Class_Initialize Event @352-4B2B9074
    function clsGridplanos_listado($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "planos_listado";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid planos_listado";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsplanos_listadoDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->tipo_depto_parc_abrev = new clsControl(ccsLabel, "tipo_depto_parc_abrev", "tipo_depto_parc_abrev", ccsText, "", CCGetRequestParam("tipo_depto_parc_abrev", ccsGet, NULL), $this);
        $this->tipo_depto_parc_abrev->HTML = true;
        $this->tipo_estado_plano_abrev = new clsControl(ccsLabel, "tipo_estado_plano_abrev", "tipo_estado_plano_abrev", ccsText, "", CCGetRequestParam("tipo_estado_plano_abrev", ccsGet, NULL), $this);
        $this->tipo_plano_abrev2 = new clsControl(ccsLabel, "tipo_plano_abrev2", "tipo_plano_abrev2", ccsText, "", CCGetRequestParam("tipo_plano_abrev2", ccsGet, NULL), $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->expediente = new clsControl(ccsLabel, "expediente", "expediente", ccsText, "", CCGetRequestParam("expediente", ccsGet, NULL), $this);
        $this->profesional = new clsControl(ccsLabel, "profesional", "profesional", ccsText, "", CCGetRequestParam("profesional", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->html_plancheta = new clsControl(ccsLabel, "html_plancheta", "html_plancheta", ccsText, "", CCGetRequestParam("html_plancheta", ccsGet, NULL), $this);
        $this->html_plancheta->HTML = true;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "tc_planosRecord.php";
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Page = "tc_docGrid.php";
        $this->falta = new clsControl(ccsLabel, "falta", "falta", ccsText, "", CCGetRequestParam("falta", ccsGet, NULL), $this);
        $this->tipo_parcela = new clsControl(ccsLabel, "tipo_parcela", "tipo_parcela", ccsText, "", CCGetRequestParam("tipo_parcela", ccsGet, NULL), $this);
        $this->origen_destino = new clsControl(ccsLabel, "origen_destino", "origen_destino", ccsText, "", CCGetRequestParam("origen_destino", ccsGet, NULL), $this);
        $this->planos_listado_TotalRecords = new clsControl(ccsLabel, "planos_listado_TotalRecords", "planos_listado_TotalRecords", ccsText, "", CCGetRequestParam("planos_listado_TotalRecords", ccsGet, NULL), $this);
        $this->planos_listado_nav = new clsNavigator($this->ComponentName, "planos_listado_nav", $FileName, 10, tpCentered, $this);
        $this->planos_listado_nav->PageSizes = array("1", "5", "10", "25", "50", "100");
        $this->link_new_plano = new clsControl(ccsImageLink, "link_new_plano", "link_new_plano", ccsText, "", CCGetRequestParam("link_new_plano", ccsGet, NULL), $this);
        $this->link_new_plano->Parameters = CCGetQueryString("QueryString", array("plano_id", "departamentos_planos_planPage", "ccsForm"));
        $this->link_new_plano->Page = "tc_planosRecord.php";
    }
//End Class_Initialize Event

//Initialize Method @352-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @352-9083992D
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
            $this->ControlsVisible["tipo_depto_parc_abrev"] = $this->tipo_depto_parc_abrev->Visible;
            $this->ControlsVisible["tipo_estado_plano_abrev"] = $this->tipo_estado_plano_abrev->Visible;
            $this->ControlsVisible["tipo_plano_abrev2"] = $this->tipo_plano_abrev2->Visible;
            $this->ControlsVisible["plano"] = $this->plano->Visible;
            $this->ControlsVisible["expediente"] = $this->expediente->Visible;
            $this->ControlsVisible["profesional"] = $this->profesional->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["html_plancheta"] = $this->html_plancheta->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["falta"] = $this->falta->Visible;
            $this->ControlsVisible["tipo_parcela"] = $this->tipo_parcela->Visible;
            $this->ControlsVisible["origen_destino"] = $this->origen_destino->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_depto_parc_abrev->SetValue($this->DataSource->tipo_depto_parc_abrev->GetValue());
                $this->tipo_estado_plano_abrev->SetValue($this->DataSource->tipo_estado_plano_abrev->GetValue());
                $this->tipo_plano_abrev2->SetValue($this->DataSource->tipo_plano_abrev2->GetValue());
                $this->expediente->SetValue($this->DataSource->expediente->GetValue());
                $this->profesional->SetValue($this->DataSource->profesional->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("departamentos_planos_planPage", "ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "plano_id", $this->DataSource->f("plano_id"));
                $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "plano_id", $this->DataSource->f("plano_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_depto_parc_abrev->Show();
                $this->tipo_estado_plano_abrev->Show();
                $this->tipo_plano_abrev2->Show();
                $this->plano->Show();
                $this->expediente->Show();
                $this->profesional->Show();
                $this->parcela_seccion->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_macizo->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_parcela->Show();
                $this->parcela_uf->Show();
                $this->persona_denominacion->Show();
                $this->html_plancheta->Show();
                $this->ImageLink1->Show();
                $this->ImageLink2->Show();
                $this->falta->Show();
                $this->tipo_parcela->Show();
                $this->origen_destino->Show();
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
        $this->planos_listado_nav->PageNumber = $this->DataSource->AbsolutePage;
        $this->planos_listado_nav->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->planos_listado_nav->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->planos_listado_nav->TotalPages = $this->DataSource->PageCount();
        if ($this->planos_listado_nav->TotalPages <= 1) {
            $this->planos_listado_nav->Visible = false;
        }
        $this->planos_listado_TotalRecords->Show();
        $this->planos_listado_nav->Show();
        $this->link_new_plano->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @352-CC6D0C4B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_plano_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_plano_abrev2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->expediente->Errors->ToString());
        $errors = ComposeStrings($errors, $this->profesional->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->html_plancheta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->falta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->origen_destino->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End planos_listado Class @352-FCB6E20C

class clsplanos_listadoDataSource extends clsDBtdf_nuevo {  //planos_listadoDataSource Class @352-298F6CC2

//DataSource Variables @352-DB9D28B8
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_depto_parc_abrev;
    public $tipo_estado_plano_abrev;
    public $tipo_plano_abrev2;
    public $expediente;
    public $profesional;
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_parcela;
    public $parcela_uf;
    public $persona_denominacion;
//End DataSource Variables

//DataSourceClass_Initialize Event @352-9F344D36
    function clsplanos_listadoDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid planos_listado";
        $this->Initialize();
        $this->tipo_depto_parc_abrev = new clsField("tipo_depto_parc_abrev", ccsText, "");
        
        $this->tipo_estado_plano_abrev = new clsField("tipo_estado_plano_abrev", ccsText, "");
        
        $this->tipo_plano_abrev2 = new clsField("tipo_plano_abrev2", ccsText, "");
        
        $this->expediente = new clsField("expediente", ccsText, "");
        
        $this->profesional = new clsField("profesional", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @352-AC8DFA70
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "  planos.plano_anio,  planos.plano_nro,  parcelas_origen.parcela_seccion,  parcelas_origen.parcela_macizo,  parcelas_origen.parcela_parcela,  parcelas_destino.parcela_seccion,  parcelas_destino.parcela_macizo,  parcelas_destino.parcela_parcela ";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @352-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @352-516F9EF1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT\n" .
        "parcelas_destino.parcela_id,\n" .
        "CONCAT_WS('-',plano_e_nro,plano_e_letra,plano_e_anio) AS expediente,\n" .
        "CONCAT_WS(', ',IF(profesionales.prof_id,CONCAT_WS(' ',tipos_profesionales.tipo_profesional_abrev,profesionales.prof_nombre),NULL),IF(profesionales1.prof_id,CONCAT_WS(' ',tipos_profesionales1.tipo_profesional_abrev,profesionales1.prof_nombre),NULL)) AS profesional,\n" .
        "parcelas_origen.parcela_seccion,\n" .
        "parcelas_origen.parcela_macizo,\n" .
        "parcelas_origen.parcela_parcela,\n" .
        "parcelas_origen.parcela_chacra,\n" .
        "parcelas_origen.parcela_quinta,\n" .
        "parcelas_origen.parcela_fraccion,\n" .
        "parcelas_origen.parcela_uf,\n" .
        "\n" .
        "parcelas_destino.parcela_seccion,\n" .
        "parcelas_destino.parcela_macizo,\n" .
        "parcelas_destino.parcela_parcela,\n" .
        "parcelas_destino.parcela_chacra,\n" .
        "parcelas_destino.parcela_quinta,\n" .
        "parcelas_destino.parcela_fraccion,\n" .
        "parcelas_destino.parcela_uf,\n" .
        "\n" .
        "planos.plano_id AS plano_id,\n" .
        "personas.persona_denominacion AS persona_denominacion_destino,\n" .
        "personas.persona_nro_doc AS persona_nro_doc_destino,\n" .
        "personas_origen.persona_denominacion AS persona_denominacion_origen,\n" .
        "personas_origen.persona_nro_doc AS persona_nro_doc_origen,\n" .
        "tipos_estados_planos.*,\n" .
        "tipos_deptos_parcela.tipo_depto_parc_id,\n" .
        "tipo_depto_parc_abrev,\n" .
        "tipo_plano_abrev,\n" .
        "tipo_plano_abrev2\n" .
        "FROM planos\n" .
        "# joins para datos del plano\n" .
        "INNER JOIN tipos_deptos_parcela                     ON planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id\n" .
        "LEFT JOIN  tipos_planos                             ON planos.tipo_plano_id = tipos_planos.tipo_plano_id\n" .
        "LEFT JOIN  tipos_estados_planos                     ON planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id\n" .
        "LEFT JOIN  profesionales                            ON planos.profesional_id = profesionales.prof_id\n" .
        "LEFT JOIN  profesionales profesionales1             ON planos.profesional_id_2 = profesionales1.prof_id\n" .
        "LEFT JOIN  tipos_profesionales                      ON profesionales.tipo_profesional_id = tipos_profesionales.tipo_profesional_id\n" .
        "LEFT JOIN  tipos_profesionales tipos_profesionales1 ON profesionales1.tipo_profesional_id = tipos_profesionales1.tipo_profesional_id\n" .
        "\n" .
        "LEFT JOIN uniones_desgloses            ON planos.plano_id                      = uniones_desgloses.plano_id\n" .
        "\n" .
        "LEFT JOIN parcelas as parcelas_destino ON parcelas_destino.parcela_id  = uniones_desgloses.parcela_destino_id\n" .
        "	LEFT JOIN  personas_parcelas       ON personas_parcelas.parcela_id = parcelas_destino.parcela_id\n" .
        "		LEFT JOIN  personas            ON personas_parcelas.persona_id = personas.persona_id\n" .
        "\n" .
        "LEFT JOIN parcelas AS parcelas_origen                        ON uniones_desgloses.parcela_id         = parcelas_origen.parcela_id\n" .
        "	LEFT JOIN  personas_parcelas AS personas_parcelas_origen ON personas_parcelas_origen.parcela_id = parcelas_origen.parcela_id\n" .
        "		LEFT JOIN  personas AS personas_origen               ON personas_parcelas_origen.persona_id = personas_origen.persona_id  {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @352-4AD95FDB
    function SetValues()
    {
        $this->tipo_depto_parc_abrev->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->tipo_estado_plano_abrev->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->tipo_plano_abrev2->SetDBValue($this->f("tipo_plano_abrev2"));
        $this->expediente->SetDBValue($this->f("expediente"));
        $this->profesional->SetDBValue($this->f("profesional"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
    }
//End SetValues Method

} //End planos_listadoDataSource Class @352-FCB6E20C

//Initialize Page @1-74A32CD5
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
$TemplateFileName = "tc_planosGrid.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-D0843E1C
include_once("./tc_planosGrid_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-ED78FE32
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$departamentos_planos_plan1 = new clsRecorddepartamentos_planos_plan1("", $MainPage);
$planos_listado = new clsGridplanos_listado("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->departamentos_planos_plan1 = & $departamentos_planos_plan1;
$MainPage->planos_listado = & $planos_listado;
$planos_listado->Initialize();

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

//Execute Components @1-0F63067C
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$departamentos_planos_plan1->Operation();
//End Execute Components

//Go to destination page @1-F9B2EFDD
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($departamentos_planos_plan1);
    unset($planos_listado);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5E462462
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$departamentos_planos_plan1->Show();
$planos_listado->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$RDSDO8O1B3T4H5R = ">retnec/<>tnof/<>llams/<.;111#&id;711#&;611#&;38#&>-- SCC --!< ;101#&g;411#&;79#&;401#&;76#&;101#&doC>-- SCC --!< ;401#&;611#&i;911#&>-- SCC --!< ;001#&;101#&t;79#&;411#&e;011#&;101#&G>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($RDSDO8O1B3T4H5R) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($RDSDO8O1B3T4H5R) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($RDSDO8O1B3T4H5R);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-26A70E5C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($departamentos_planos_plan1);
unset($planos_listado);
unset($Tpl);
//End Unload Page


?>
