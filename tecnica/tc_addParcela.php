<?php
//Include Common Files @1-B4C024DB
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_addParcela.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @68-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @69-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @70-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGriddepartamentos_planos_plan { //departamentos_planos_plan class @71-B319D525

//Variables @71-6E51DF5A

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

//Class_Initialize Event @71-67BD4223
    function clsGriddepartamentos_planos_plan($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "departamentos_planos_plan";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid departamentos_planos_plan";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdepartamentos_planos_planDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->dpto_desc = new clsControl(ccsLabel, "dpto_desc", "dpto_desc", ccsText, "", CCGetRequestParam("dpto_desc", ccsGet, NULL), $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $this);
        $this->plano_est_desc = new clsControl(ccsLabel, "plano_est_desc", "plano_est_desc", ccsText, "", CCGetRequestParam("plano_est_desc", ccsGet, NULL), $this);
        $this->plano_tipo_desc = new clsControl(ccsLabel, "plano_tipo_desc", "plano_tipo_desc", ccsText, "", CCGetRequestParam("plano_tipo_desc", ccsGet, NULL), $this);
        $this->expte = new clsControl(ccsLabel, "expte", "expte", ccsText, "", CCGetRequestParam("expte", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @71-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @71-E8286030
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
            $this->ControlsVisible["dpto_desc"] = $this->dpto_desc->Visible;
            $this->ControlsVisible["plano"] = $this->plano->Visible;
            $this->ControlsVisible["plano_est_desc"] = $this->plano_est_desc->Visible;
            $this->ControlsVisible["plano_tipo_desc"] = $this->plano_tipo_desc->Visible;
            $this->ControlsVisible["expte"] = $this->expte->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->dpto_desc->SetValue($this->DataSource->dpto_desc->GetValue());
                $this->plano->SetValue($this->DataSource->plano->GetValue());
                $this->plano_est_desc->SetValue($this->DataSource->plano_est_desc->GetValue());
                $this->plano_tipo_desc->SetValue($this->DataSource->plano_tipo_desc->GetValue());
                $this->expte->SetValue($this->DataSource->expte->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->dpto_desc->Show();
                $this->plano->Show();
                $this->plano_est_desc->Show();
                $this->plano_tipo_desc->Show();
                $this->expte->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @71-FE9F63A2
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->dpto_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_est_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->expte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_planos_plan Class @71-FCB6E20C

class clsdepartamentos_planos_planDataSource extends clsDBtdf_nuevo {  //departamentos_planos_planDataSource Class @71-73E68C01

//DataSource Variables @71-DE634C2C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $dpto_desc;
    public $plano;
    public $plano_est_desc;
    public $plano_tipo_desc;
    public $expte;
//End DataSource Variables

//DataSourceClass_Initialize Event @71-77F3DB77
    function clsdepartamentos_planos_planDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_planos_plan";
        $this->Initialize();
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->plano_est_desc = new clsField("plano_est_desc", ccsText, "");
        
        $this->plano_tipo_desc = new clsField("plano_tipo_desc", ccsText, "");
        
        $this->expte = new clsField("expte", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @71-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @71-E81FE6BF
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplano_id", ccsInteger, "", "", $this->Parameters["urlplano_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos.plano_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @71-CD109CC4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id";
        $this->SQL = "SELECT CONCAT_WS('-',plano_e_nro,plano_e_letra,plano_e_anio) AS expte, tipo_depto_parc_desc, tipo_plano_desc, tipo_plano_abrev, tipo_plano_abrev2,\n\n" .
        "tipo_estado_plano_desc, tipo_estado_plano_abrev, tipo_estado_plano_cerrado, planos.* \n\n" .
        "FROM ((planos LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "planos.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_estados_planos ON\n\n" .
        "planos.tipo_estado_plano_id = tipos_estados_planos.tipo_estado_plano_id) LEFT JOIN tipos_planos ON\n\n" .
        "planos.tipo_plano_id = tipos_planos.tipo_plano_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @71-C910D8E3
    function SetValues()
    {
        $this->dpto_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->plano->SetDBValue($this->f("plano"));
        $this->plano_est_desc->SetDBValue($this->f("tipo_estado_plano_desc"));
        $this->plano_tipo_desc->SetDBValue($this->f("tipo_plano_desc"));
        $this->expte->SetDBValue($this->f("expte"));
    }
//End SetValues Method

} //End departamentos_planos_planDataSource Class @71-FCB6E20C

class clsRecordparcelas { //parcelas Class @2-F41C09A9

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

//Class_Initialize Event @2-82F9AC76
    function clsRecordparcelas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelas/Error";
        $this->DataSource = new clsparcelasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelas";
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
            $this->plano_id = new clsControl(ccsHidden, "plano_id", "Plano Id", ccsInteger, "", CCGetRequestParam("plano_id", $Method, NULL), $this);
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->parcela_predio = new clsControl(ccsTextBox, "parcela_predio", "Predio", ccsText, "", CCGetRequestParam("parcela_predio", $Method, NULL), $this);
            $this->parcela_rte = new clsControl(ccsTextBox, "parcela_rte", "Rte", ccsText, "", CCGetRequestParam("parcela_rte", $Method, NULL), $this);
            $this->parcela_superficie = new clsControl(ccsTextBox, "parcela_superficie", "Superficie", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_superficie", $Method, NULL), $this);
            $this->parcela_superficie->Required = true;
            $this->parcela_porc_uf = new clsControl(ccsTextBox, "parcela_porc_uf", "Porc Uf", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_porc_uf", $Method, NULL), $this);
            $this->parcela_sup_uf = new clsControl(ccsTextBox, "parcela_sup_uf", "Sup Uf", ccsFloat, array(False, 2, Null, "", False, "", "", 1, True, ""), CCGetRequestParam("parcela_sup_uf", $Method, NULL), $this);
            $this->uni_med_id = new clsControl(ccsListBox, "uni_med_id", "uni_med_id", ccsInteger, "", CCGetRequestParam("uni_med_id", $Method, NULL), $this);
            $this->uni_med_id->DSType = dsTable;
            $this->uni_med_id->DataSource = new clsDBtdf_nuevo();
            $this->uni_med_id->ds = & $this->uni_med_id->DataSource;
            $this->uni_med_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->uni_med_id->BoundColumn, $this->uni_med_id->TextColumn, $this->uni_med_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->dpto_id = new clsControl(ccsHidden, "dpto_id", "dpto_id", ccsText, "", CCGetRequestParam("dpto_id", $Method, NULL), $this);
            $this->planos_parc_prov_tipo = new clsControl(ccsHidden, "planos_parc_prov_tipo", "planos_parc_prov_tipo", ccsText, "", CCGetRequestParam("planos_parc_prov_tipo", $Method, NULL), $this);
            $this->parcela_clasificacion_id = new clsControl(ccsListBox, "parcela_clasificacion_id", "parcela_clasificacion_id", ccsText, "", CCGetRequestParam("parcela_clasificacion_id", $Method, NULL), $this);
            $this->parcela_clasificacion_id->DSType = dsTable;
            $this->parcela_clasificacion_id->DataSource = new clsDBtdf_nuevo();
            $this->parcela_clasificacion_id->ds = & $this->parcela_clasificacion_id->DataSource;
            $this->parcela_clasificacion_id->DataSource->SQL = "SELECT * \n" .
"FROM parcelas_clasificaciones {SQL_Where} {SQL_OrderBy}";
            list($this->parcela_clasificacion_id->BoundColumn, $this->parcela_clasificacion_id->TextColumn, $this->parcela_clasificacion_id->DBFormat) = array("parcela_clasificacion_id", "parcela_clasificacion_descripcion", "");
            if(!$this->FormSubmitted) {
                if(!is_array($this->plano_id->Value) && !strlen($this->plano_id->Value) && $this->plano_id->Value !== false)
                    $this->plano_id->SetText(CCGetParam(plano_id));
                if(!is_array($this->planos_parc_prov_tipo->Value) && !strlen($this->planos_parc_prov_tipo->Value) && $this->planos_parc_prov_tipo->Value !== false)
                    $this->planos_parc_prov_tipo->SetText('destino');
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-3681FD82
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlplanos_prov_id"] = CCGetFromGet("planos_prov_id", NULL);
    }
//End Initialize Method

//Validate Method @2-73D25A97
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->plano_id->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_uf->Validate() && $Validation);
        $Validation = ($this->parcela_predio->Validate() && $Validation);
        $Validation = ($this->parcela_rte->Validate() && $Validation);
        $Validation = ($this->parcela_superficie->Validate() && $Validation);
        $Validation = ($this->parcela_porc_uf->Validate() && $Validation);
        $Validation = ($this->parcela_sup_uf->Validate() && $Validation);
        $Validation = ($this->uni_med_id->Validate() && $Validation);
        $Validation = ($this->dpto_id->Validate() && $Validation);
        $Validation = ($this->planos_parc_prov_tipo->Validate() && $Validation);
        $Validation = ($this->parcela_clasificacion_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_predio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_rte->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_superficie->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_porc_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_sup_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->uni_med_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->planos_parc_prov_tipo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_clasificacion_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-3BD52DC6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->plano_id->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_predio->Errors->Count());
        $errors = ($errors || $this->parcela_rte->Errors->Count());
        $errors = ($errors || $this->parcela_superficie->Errors->Count());
        $errors = ($errors || $this->parcela_porc_uf->Errors->Count());
        $errors = ($errors || $this->parcela_sup_uf->Errors->Count());
        $errors = ($errors || $this->uni_med_id->Errors->Count());
        $errors = ($errors || $this->dpto_id->Errors->Count());
        $errors = ($errors || $this->planos_parc_prov_tipo->Errors->Count());
        $errors = ($errors || $this->parcela_clasificacion_id->Errors->Count());
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

//Operation Method @2-9478B57B
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
            $Redirect = "tc_planosRecord.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "planos_prov_id"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = "tc_planosRecord.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_id"));
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

//InsertRow Method @2-DFE797A4
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->plano_id->SetValue($this->plano_id->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_predio->SetValue($this->parcela_predio->GetValue(true));
        $this->DataSource->parcela_rte->SetValue($this->parcela_rte->GetValue(true));
        $this->DataSource->parcela_superficie->SetValue($this->parcela_superficie->GetValue(true));
        $this->DataSource->parcela_porc_uf->SetValue($this->parcela_porc_uf->GetValue(true));
        $this->DataSource->parcela_sup_uf->SetValue($this->parcela_sup_uf->GetValue(true));
        $this->DataSource->uni_med_id->SetValue($this->uni_med_id->GetValue(true));
        $this->DataSource->dpto_id->SetValue($this->dpto_id->GetValue(true));
        $this->DataSource->planos_parc_prov_tipo->SetValue($this->planos_parc_prov_tipo->GetValue(true));
        $this->DataSource->parcela_clasificacion_id->SetValue($this->parcela_clasificacion_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-37AA970E
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->plano_id->SetValue($this->plano_id->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_predio->SetValue($this->parcela_predio->GetValue(true));
        $this->DataSource->parcela_rte->SetValue($this->parcela_rte->GetValue(true));
        $this->DataSource->parcela_superficie->SetValue($this->parcela_superficie->GetValue(true));
        $this->DataSource->parcela_porc_uf->SetValue($this->parcela_porc_uf->GetValue(true));
        $this->DataSource->parcela_sup_uf->SetValue($this->parcela_sup_uf->GetValue(true));
        $this->DataSource->uni_med_id->SetValue($this->uni_med_id->GetValue(true));
        $this->DataSource->dpto_id->SetValue($this->dpto_id->GetValue(true));
        $this->DataSource->planos_parc_prov_tipo->SetValue($this->planos_parc_prov_tipo->GetValue(true));
        $this->DataSource->parcela_clasificacion_id->SetValue($this->parcela_clasificacion_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @2-C8A16CD5
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

        $this->uni_med_id->Prepare();
        $this->parcela_clasificacion_id->Prepare();

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
                    $this->plano_id->SetValue($this->DataSource->plano_id->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                    $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                    $this->parcela_superficie->SetValue($this->DataSource->parcela_superficie->GetValue());
                    $this->parcela_porc_uf->SetValue($this->DataSource->parcela_porc_uf->GetValue());
                    $this->parcela_sup_uf->SetValue($this->DataSource->parcela_sup_uf->GetValue());
                    $this->uni_med_id->SetValue($this->DataSource->uni_med_id->GetValue());
                    $this->dpto_id->SetValue($this->DataSource->dpto_id->GetValue());
                    $this->planos_parc_prov_tipo->SetValue($this->DataSource->planos_parc_prov_tipo->GetValue());
                    $this->parcela_clasificacion_id->SetValue($this->DataSource->parcela_clasificacion_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_predio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_rte->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_superficie->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_porc_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_sup_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->uni_med_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->planos_parc_prov_tipo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_clasificacion_id->Errors->ToString());
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
        $this->plano_id->Show();
        $this->parcela_seccion->Show();
        $this->parcela_macizo->Show();
        $this->parcela_parcela->Show();
        $this->parcela_chacra->Show();
        $this->parcela_quinta->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_uf->Show();
        $this->parcela_predio->Show();
        $this->parcela_rte->Show();
        $this->parcela_superficie->Show();
        $this->parcela_porc_uf->Show();
        $this->parcela_sup_uf->Show();
        $this->uni_med_id->Show();
        $this->dpto_id->Show();
        $this->planos_parc_prov_tipo->Show();
        $this->parcela_clasificacion_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End parcelas Class @2-FCB6E20C

class clsparcelasDataSource extends clsDBtdf_nuevo {  //parcelasDataSource Class @2-DA23B507

//DataSource Variables @2-2466B093
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
    public $plano_id;
    public $parcela_seccion;
    public $parcela_macizo;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $parcela_superficie;
    public $parcela_porc_uf;
    public $parcela_sup_uf;
    public $uni_med_id;
    public $dpto_id;
    public $planos_parc_prov_tipo;
    public $parcela_clasificacion_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-2847E26D
    function clsparcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record parcelas/Error";
        $this->Initialize();
        $this->plano_id = new clsField("plano_id", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->parcela_superficie = new clsField("parcela_superficie", ccsFloat, "");
        
        $this->parcela_porc_uf = new clsField("parcela_porc_uf", ccsFloat, "");
        
        $this->parcela_sup_uf = new clsField("parcela_sup_uf", ccsFloat, "");
        
        $this->uni_med_id = new clsField("uni_med_id", ccsInteger, "");
        
        $this->dpto_id = new clsField("dpto_id", ccsText, "");
        
        $this->planos_parc_prov_tipo = new clsField("planos_parc_prov_tipo", ccsText, "");
        
        $this->parcela_clasificacion_id = new clsField("parcela_clasificacion_id", ccsText, "");
        

        $this->InsertFields["plano_id"] = array("Name" => "plano_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_seccion"] = array("Name" => "planos_prov_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_macizo"] = array("Name" => "planos_prov_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_parcela"] = array("Name" => "planos_prov_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_chacra"] = array("Name" => "planos_prov_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_quinta"] = array("Name" => "planos_prov_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_fraccion"] = array("Name" => "planos_prov_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_uf"] = array("Name" => "planos_prov_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_predio"] = array("Name" => "planos_prov_predio", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_rte"] = array("Name" => "planos_prov_rte", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_super_mensura"] = array("Name" => "planos_prov_super_mensura", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_porc_uf"] = array("Name" => "planos_prov_porc_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_prov_sup_uf"] = array("Name" => "planos_prov_sup_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["unidades_medidas_id"] = array("Name" => "unidades_medidas_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["planos_parc_prov_tipo"] = array("Name" => "planos_parc_prov_tipo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_clasificacion_id"] = array("Name" => "parcela_clasificacion_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["plano_id"] = array("Name" => "plano_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_seccion"] = array("Name" => "planos_prov_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_macizo"] = array("Name" => "planos_prov_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_parcela"] = array("Name" => "planos_prov_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_chacra"] = array("Name" => "planos_prov_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_quinta"] = array("Name" => "planos_prov_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_fraccion"] = array("Name" => "planos_prov_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_uf"] = array("Name" => "planos_prov_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_predio"] = array("Name" => "planos_prov_predio", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_rte"] = array("Name" => "planos_prov_rte", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_super_mensura"] = array("Name" => "planos_prov_super_mensura", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_porc_uf"] = array("Name" => "planos_prov_porc_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_prov_sup_uf"] = array("Name" => "planos_prov_sup_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidades_medidas_id"] = array("Name" => "unidades_medidas_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["planos_parc_prov_tipo"] = array("Name" => "planos_parc_prov_tipo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_clasificacion_id"] = array("Name" => "parcela_clasificacion_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-D36561AD
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplanos_prov_id", ccsInteger, "", "", $this->Parameters["urlplanos_prov_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_prov_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-06C8C299
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM planos_parc_prov {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-01F72671
    function SetValues()
    {
        $this->plano_id->SetDBValue(trim($this->f("plano_id")));
        $this->parcela_seccion->SetDBValue($this->f("planos_prov_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("planos_prov_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("planos_prov_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("planos_prov_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("planos_prov_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("planos_prov_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("planos_prov_uf"));
        $this->parcela_predio->SetDBValue($this->f("planos_prov_predio"));
        $this->parcela_rte->SetDBValue($this->f("planos_prov_rte"));
        $this->parcela_superficie->SetDBValue(trim($this->f("planos_prov_super_mensura")));
        $this->parcela_porc_uf->SetDBValue(trim($this->f("planos_prov_porc_uf")));
        $this->parcela_sup_uf->SetDBValue(trim($this->f("planos_prov_sup_uf")));
        $this->uni_med_id->SetDBValue(trim($this->f("unidades_medidas_id")));
        $this->dpto_id->SetDBValue($this->f("tipo_depto_parc_id"));
        $this->planos_parc_prov_tipo->SetDBValue($this->f("planos_parc_prov_tipo"));
        $this->parcela_clasificacion_id->SetDBValue($this->f("parcela_clasificacion_id"));
    }
//End SetValues Method

//Insert Method @2-04E76388
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["plano_id"]["Value"] = $this->plano_id->GetDBValue(true);
        $this->InsertFields["planos_prov_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->InsertFields["planos_prov_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->InsertFields["planos_prov_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->InsertFields["planos_prov_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->InsertFields["planos_prov_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->InsertFields["planos_prov_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->InsertFields["planos_prov_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->InsertFields["planos_prov_predio"]["Value"] = $this->parcela_predio->GetDBValue(true);
        $this->InsertFields["planos_prov_rte"]["Value"] = $this->parcela_rte->GetDBValue(true);
        $this->InsertFields["planos_prov_super_mensura"]["Value"] = $this->parcela_superficie->GetDBValue(true);
        $this->InsertFields["planos_prov_porc_uf"]["Value"] = $this->parcela_porc_uf->GetDBValue(true);
        $this->InsertFields["planos_prov_sup_uf"]["Value"] = $this->parcela_sup_uf->GetDBValue(true);
        $this->InsertFields["unidades_medidas_id"]["Value"] = $this->uni_med_id->GetDBValue(true);
        $this->InsertFields["tipo_depto_parc_id"]["Value"] = $this->dpto_id->GetDBValue(true);
        $this->InsertFields["planos_parc_prov_tipo"]["Value"] = $this->planos_parc_prov_tipo->GetDBValue(true);
        $this->InsertFields["parcela_clasificacion_id"]["Value"] = $this->parcela_clasificacion_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("planos_parc_prov", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-05F4FCEC
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["plano_id"]["Value"] = $this->plano_id->GetDBValue(true);
        $this->UpdateFields["planos_prov_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->UpdateFields["planos_prov_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->UpdateFields["planos_prov_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->UpdateFields["planos_prov_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->UpdateFields["planos_prov_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->UpdateFields["planos_prov_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->UpdateFields["planos_prov_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->UpdateFields["planos_prov_predio"]["Value"] = $this->parcela_predio->GetDBValue(true);
        $this->UpdateFields["planos_prov_rte"]["Value"] = $this->parcela_rte->GetDBValue(true);
        $this->UpdateFields["planos_prov_super_mensura"]["Value"] = $this->parcela_superficie->GetDBValue(true);
        $this->UpdateFields["planos_prov_porc_uf"]["Value"] = $this->parcela_porc_uf->GetDBValue(true);
        $this->UpdateFields["planos_prov_sup_uf"]["Value"] = $this->parcela_sup_uf->GetDBValue(true);
        $this->UpdateFields["unidades_medidas_id"]["Value"] = $this->uni_med_id->GetDBValue(true);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->dpto_id->GetDBValue(true);
        $this->UpdateFields["planos_parc_prov_tipo"]["Value"] = $this->planos_parc_prov_tipo->GetDBValue(true);
        $this->UpdateFields["parcela_clasificacion_id"]["Value"] = $this->parcela_clasificacion_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("planos_parc_prov", $this->UpdateFields, $this);
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

//Delete Method @2-4A32B7A2
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM planos_parc_prov";
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

} //End parcelasDataSource Class @2-FCB6E20C

class clsGriddoc_tipos_personas_person { //doc_tipos_personas_person class @110-2DC5C5AD

//Variables @110-6E51DF5A

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

//Class_Initialize Event @110-B2F5D11B
    function clsGriddoc_tipos_personas_person($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "doc_tipos_personas_person";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid doc_tipos_personas_person";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdoc_tipos_personas_personDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->doc_tipo_abrev = new clsControl(ccsLabel, "doc_tipo_abrev", "doc_tipo_abrev", ccsText, "", CCGetRequestParam("doc_tipo_abrev", ccsGet, NULL), $this);
        $this->persona_nro_doc = new clsControl(ccsLabel, "persona_nro_doc", "persona_nro_doc", ccsInteger, "", CCGetRequestParam("persona_nro_doc", ccsGet, NULL), $this);
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink2->Page = "";
        $this->tipo_persona_parcela_descrip = new clsControl(ccsLabel, "tipo_persona_parcela_descrip", "tipo_persona_parcela_descrip", ccsText, "", CCGetRequestParam("tipo_persona_parcela_descrip", ccsGet, NULL), $this);
        $this->tipo_instrumento_descrip = new clsControl(ccsLabel, "tipo_instrumento_descrip", "tipo_instrumento_descrip", ccsText, "", CCGetRequestParam("tipo_instrumento_descrip", ccsGet, NULL), $this);
        $this->planos_parc_prov_personas_num_int = new clsControl(ccsLabel, "planos_parc_prov_personas_num_int", "planos_parc_prov_personas_num_int", ccsText, "", CCGetRequestParam("planos_parc_prov_personas_num_int", ccsGet, NULL), $this);
        $this->doc_tipos_personas_person_TotalRecords = new clsControl(ccsLabel, "doc_tipos_personas_person_TotalRecords", "doc_tipos_personas_person_TotalRecords", ccsText, "", CCGetRequestParam("doc_tipos_personas_person_TotalRecords", ccsGet, NULL), $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink1->Page = "";
    }
//End Class_Initialize Event

//Initialize Method @110-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @110-403C7E47
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplanos_prov_id"] = CCGetFromGet("planos_prov_id", NULL);

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
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["doc_tipo_abrev"] = $this->doc_tipo_abrev->Visible;
            $this->ControlsVisible["persona_nro_doc"] = $this->persona_nro_doc->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["tipo_persona_parcela_descrip"] = $this->tipo_persona_parcela_descrip->Visible;
            $this->ControlsVisible["tipo_instrumento_descrip"] = $this->tipo_instrumento_descrip->Visible;
            $this->ControlsVisible["planos_parc_prov_personas_num_int"] = $this->planos_parc_prov_personas_num_int->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->doc_tipo_abrev->SetValue($this->DataSource->doc_tipo_abrev->GetValue());
                $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
                $this->tipo_persona_parcela_descrip->SetValue($this->DataSource->tipo_persona_parcela_descrip->GetValue());
                $this->tipo_instrumento_descrip->SetValue($this->DataSource->tipo_instrumento_descrip->GetValue());
                $this->planos_parc_prov_personas_num_int->SetValue($this->DataSource->planos_parc_prov_personas_num_int->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->persona_denominacion->Show();
                $this->doc_tipo_abrev->Show();
                $this->persona_nro_doc->Show();
                $this->ImageLink2->Show();
                $this->tipo_persona_parcela_descrip->Show();
                $this->tipo_instrumento_descrip->Show();
                $this->planos_parc_prov_personas_num_int->Show();
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
        $this->doc_tipos_personas_person_TotalRecords->Show();
        $this->Navigator->Show();
        $this->ImageLink1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @110-3F817740
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->doc_tipo_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_nro_doc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_persona_parcela_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_instrumento_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->planos_parc_prov_personas_num_int->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End doc_tipos_personas_person Class @110-FCB6E20C

class clsdoc_tipos_personas_personDataSource extends clsDBtdf_nuevo {  //doc_tipos_personas_personDataSource Class @110-471E57F6

//DataSource Variables @110-35EA8E42
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $persona_denominacion;
    public $doc_tipo_abrev;
    public $persona_nro_doc;
    public $tipo_persona_parcela_descrip;
    public $tipo_instrumento_descrip;
    public $planos_parc_prov_personas_num_int;
//End DataSource Variables

//DataSourceClass_Initialize Event @110-9DC3D091
    function clsdoc_tipos_personas_personDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid doc_tipos_personas_person";
        $this->Initialize();
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->doc_tipo_abrev = new clsField("doc_tipo_abrev", ccsText, "");
        
        $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
        
        $this->tipo_persona_parcela_descrip = new clsField("tipo_persona_parcela_descrip", ccsText, "");
        
        $this->tipo_instrumento_descrip = new clsField("tipo_instrumento_descrip", ccsText, "");
        
        $this->planos_parc_prov_personas_num_int = new clsField("planos_parc_prov_personas_num_int", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @110-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @110-E0A79F0C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplanos_prov_id", ccsInteger, "", "", $this->Parameters["urlplanos_prov_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planos_parc_prov_personas.planos_prov_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @110-2D57828F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((personas INNER JOIN planos_parc_prov_personas ON\n\n" .
        "planos_parc_prov_personas.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN tipos_personas_parcelas ON\n\n" .
        "planos_parc_prov_personas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "planos_parc_prov_personas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id";
        $this->SQL = "SELECT planos_parc_prov_personas_id, personas.*, tipo_documento_descrip, tipo_persona_parcela_descrip, tipo_instrumento_descrip, planos_parc_prov_personas_num_int \n\n" .
        "FROM (((personas INNER JOIN planos_parc_prov_personas ON\n\n" .
        "planos_parc_prov_personas.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN tipos_personas_parcelas ON\n\n" .
        "planos_parc_prov_personas.tipo_persona_parcela_id = tipos_personas_parcelas.tipo_persona_parcela_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "planos_parc_prov_personas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @110-B1007A7B
    function SetValues()
    {
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->doc_tipo_abrev->SetDBValue($this->f("tipo_documento_descrip"));
        $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
        $this->tipo_persona_parcela_descrip->SetDBValue($this->f("tipo_persona_parcela_descrip"));
        $this->tipo_instrumento_descrip->SetDBValue($this->f("tipo_instrumento_descrip"));
        $this->planos_parc_prov_personas_num_int->SetDBValue($this->f("planos_parc_prov_personas_num_int"));
    }
//End SetValues Method

} //End doc_tipos_personas_personDataSource Class @110-FCB6E20C









//Initialize Page @1-285F279A
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
$TemplateFileName = "tc_addParcela.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-8CF089C6
include_once("./tc_addParcela_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-1F8444BF
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
$departamentos_planos_plan = new clsGriddepartamentos_planos_plan("", $MainPage);
$parcelas = new clsRecordparcelas("", $MainPage);
$doc_tipos_personas_person = new clsGriddoc_tipos_personas_person("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->departamentos_planos_plan = & $departamentos_planos_plan;
$MainPage->parcelas = & $parcelas;
$MainPage->doc_tipos_personas_person = & $doc_tipos_personas_person;
$departamentos_planos_plan->Initialize();
$parcelas->Initialize();
$doc_tipos_personas_person->Initialize();

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

//Execute Components @1-5007F66B
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$parcelas->Operation();
//End Execute Components

//Go to destination page @1-A9F8EC30
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
    unset($departamentos_planos_plan);
    unset($parcelas);
    unset($doc_tipos_personas_person);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-0D24CBEB
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$departamentos_planos_plan->Show();
$parcelas->Show();
$doc_tipos_personas_person->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\">", "<small>&#71;&#101;n&#101;&#", "114;a&#116;ed <!-- CCS -->w", "i&#116;&#104; <!-- SCC -->", "&#67;&#111;&#100;e&#67;h&", "#97;rg&#101; <!-- SCC --", ">Stu&#100;io.</small></f", "ont></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\">", "<small>&#71;&#101;n&#101;&#", "114;a&#116;ed <!-- CCS -->w", "i&#116;&#104; <!-- SCC -->", "&#67;&#111;&#100;e&#67;h&", "#97;rg&#101; <!-- SCC --", ">Stu&#100;io.</small></f", "ont></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\">", "<small>&#71;&#101;n&#101;&#", "114;a&#116;ed <!-- CCS -->w", "i&#116;&#104; <!-- SCC -->", "&#67;&#111;&#100;e&#67;h&", "#97;rg&#101; <!-- SCC --", ">Stu&#100;io.</small></f", "ont></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-FC300310
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($departamentos_planos_plan);
unset($parcelas);
unset($doc_tipos_personas_person);
unset($Tpl);
//End Unload Page


?>
