<?php
//Include Common Files @1-04215AD8
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_cambiar_nomencla.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
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

class clsRecordprevisados_parcelas_desti { //previsados_parcelas_desti Class @6-99C2DFAC

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

//Class_Initialize Event @6-3E0FA897
    function clsRecordprevisados_parcelas_desti($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_parcelas_desti/Error";
        $this->DataSource = new clsprevisados_parcelas_destiDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_parcelas_desti";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Tipo Depto Parc Id", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Parcela Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Parcela Chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Parcela Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Parcela Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Parcela Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_super_mensura = new clsControl(ccsTextBox, "parcela_super_mensura", "Parcela Super Mensura", ccsFloat, "", CCGetRequestParam("parcela_super_mensura", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Parcela Uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->parcela_super_uf = new clsControl(ccsTextBox, "parcela_super_uf", "Parcela Super Uf", ccsFloat, "", CCGetRequestParam("parcela_super_uf", $Method, NULL), $this);
            $this->unidades_medidas_id = new clsControl(ccsListBox, "unidades_medidas_id", "Unidades Medidas Id", ccsInteger, "", CCGetRequestParam("unidades_medidas_id", $Method, NULL), $this);
            $this->unidades_medidas_id->DSType = dsTable;
            $this->unidades_medidas_id->DataSource = new clsDBtdf_nuevo();
            $this->unidades_medidas_id->ds = & $this->unidades_medidas_id->DataSource;
            $this->unidades_medidas_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->unidades_medidas_id->BoundColumn, $this->unidades_medidas_id->TextColumn, $this->unidades_medidas_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->unidades_medidas_uf_id = new clsControl(ccsListBox, "unidades_medidas_uf_id", "Unidades Medidas Uf Id", ccsInteger, "", CCGetRequestParam("unidades_medidas_uf_id", $Method, NULL), $this);
            $this->unidades_medidas_uf_id->DSType = dsTable;
            $this->unidades_medidas_uf_id->DataSource = new clsDBtdf_nuevo();
            $this->unidades_medidas_uf_id->ds = & $this->unidades_medidas_uf_id->DataSource;
            $this->unidades_medidas_uf_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->unidades_medidas_uf_id->BoundColumn, $this->unidades_medidas_uf_id->TextColumn, $this->unidades_medidas_uf_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->tipo_depto_parc_id_2 = new clsControl(ccsHidden, "tipo_depto_parc_id_2", "tipo_depto_parc_id_2", ccsText, "", CCGetRequestParam("tipo_depto_parc_id_2", $Method, NULL), $this);
            $this->parcela_seccion_2 = new clsControl(ccsHidden, "parcela_seccion_2", "parcela_seccion_2", ccsText, "", CCGetRequestParam("parcela_seccion_2", $Method, NULL), $this);
            $this->parcela_chacra_2 = new clsControl(ccsHidden, "parcela_chacra_2", "parcela_chacra_2", ccsText, "", CCGetRequestParam("parcela_chacra_2", $Method, NULL), $this);
            $this->parcela_quinta_2 = new clsControl(ccsHidden, "parcela_quinta_2", "parcela_quinta_2", ccsText, "", CCGetRequestParam("parcela_quinta_2", $Method, NULL), $this);
            $this->parcela_macizo_2 = new clsControl(ccsHidden, "parcela_macizo_2", "parcela_macizo_2", ccsText, "", CCGetRequestParam("parcela_macizo_2", $Method, NULL), $this);
            $this->parcela_fraccion_2 = new clsControl(ccsHidden, "parcela_fraccion_2", "parcela_fraccion_2", ccsText, "", CCGetRequestParam("parcela_fraccion_2", $Method, NULL), $this);
            $this->parcela_parcela_2 = new clsControl(ccsHidden, "parcela_parcela_2", "parcela_parcela_2", ccsText, "", CCGetRequestParam("parcela_parcela_2", $Method, NULL), $this);
            $this->parcela_uf_2 = new clsControl(ccsHidden, "parcela_uf_2", "parcela_uf_2", ccsText, "", CCGetRequestParam("parcela_uf_2", $Method, NULL), $this);
            $this->parcela_super_mensura_2 = new clsControl(ccsHidden, "parcela_super_mensura_2", "parcela_super_mensura_2", ccsText, "", CCGetRequestParam("parcela_super_mensura_2", $Method, NULL), $this);
            $this->parcela_super_uf_2 = new clsControl(ccsHidden, "parcela_super_uf_2", "parcela_super_uf_2", ccsText, "", CCGetRequestParam("parcela_super_uf_2", $Method, NULL), $this);
            $this->unidades_medidas_id_2 = new clsControl(ccsHidden, "unidades_medidas_id_2", "unidades_medidas_id_2", ccsText, "", CCGetRequestParam("unidades_medidas_id_2", $Method, NULL), $this);
            $this->unidades_medidas_uf_id_2 = new clsControl(ccsHidden, "unidades_medidas_uf_id_2", "unidades_medidas_uf_id_2", ccsText, "", CCGetRequestParam("unidades_medidas_uf_id_2", $Method, NULL), $this);
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @6-022B04ED
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlprevisado_parcela_destino_id"] = CCGetFromGet("previsado_parcela_destino_id", NULL);
    }
//End Initialize Method

//Validate Method @6-519D2156
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_super_mensura->Validate() && $Validation);
        $Validation = ($this->parcela_uf->Validate() && $Validation);
        $Validation = ($this->parcela_super_uf->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_id->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_uf_id->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id_2->Validate() && $Validation);
        $Validation = ($this->parcela_seccion_2->Validate() && $Validation);
        $Validation = ($this->parcela_chacra_2->Validate() && $Validation);
        $Validation = ($this->parcela_quinta_2->Validate() && $Validation);
        $Validation = ($this->parcela_macizo_2->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion_2->Validate() && $Validation);
        $Validation = ($this->parcela_parcela_2->Validate() && $Validation);
        $Validation = ($this->parcela_uf_2->Validate() && $Validation);
        $Validation = ($this->parcela_super_mensura_2->Validate() && $Validation);
        $Validation = ($this->parcela_super_uf_2->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_id_2->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_uf_id_2->Validate() && $Validation);
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_super_mensura->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_super_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_uf_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_parcela_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_super_mensura_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_super_uf_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_id_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_uf_id_2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-43EA5837
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_super_mensura->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_super_uf->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_id->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_uf_id->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id_2->Errors->Count());
        $errors = ($errors || $this->parcela_seccion_2->Errors->Count());
        $errors = ($errors || $this->parcela_chacra_2->Errors->Count());
        $errors = ($errors || $this->parcela_quinta_2->Errors->Count());
        $errors = ($errors || $this->parcela_macizo_2->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion_2->Errors->Count());
        $errors = ($errors || $this->parcela_parcela_2->Errors->Count());
        $errors = ($errors || $this->parcela_uf_2->Errors->Count());
        $errors = ($errors || $this->parcela_super_mensura_2->Errors->Count());
        $errors = ($errors || $this->parcela_super_uf_2->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_id_2->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_uf_id_2->Errors->Count());
        $errors = ($errors || $this->parcela_id->Errors->Count());
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

//Operation Method @6-757DC6B6
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "previsados_respuesta.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "previsado_parcela_destino_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
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

//UpdateRow Method @6-229FA1F8
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
        $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
        $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
        $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
        $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
        $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
        $this->DataSource->parcela_super_mensura->SetValue($this->parcela_super_mensura->GetValue(true));
        $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
        $this->DataSource->parcela_super_uf->SetValue($this->parcela_super_uf->GetValue(true));
        $this->DataSource->unidades_medidas_id->SetValue($this->unidades_medidas_id->GetValue(true));
        $this->DataSource->unidades_medidas_uf_id->SetValue($this->unidades_medidas_uf_id->GetValue(true));
        $this->DataSource->tipo_depto_parc_id_2->SetValue($this->tipo_depto_parc_id_2->GetValue(true));
        $this->DataSource->parcela_seccion_2->SetValue($this->parcela_seccion_2->GetValue(true));
        $this->DataSource->parcela_chacra_2->SetValue($this->parcela_chacra_2->GetValue(true));
        $this->DataSource->parcela_quinta_2->SetValue($this->parcela_quinta_2->GetValue(true));
        $this->DataSource->parcela_macizo_2->SetValue($this->parcela_macizo_2->GetValue(true));
        $this->DataSource->parcela_fraccion_2->SetValue($this->parcela_fraccion_2->GetValue(true));
        $this->DataSource->parcela_parcela_2->SetValue($this->parcela_parcela_2->GetValue(true));
        $this->DataSource->parcela_uf_2->SetValue($this->parcela_uf_2->GetValue(true));
        $this->DataSource->parcela_super_mensura_2->SetValue($this->parcela_super_mensura_2->GetValue(true));
        $this->DataSource->parcela_super_uf_2->SetValue($this->parcela_super_uf_2->GetValue(true));
        $this->DataSource->unidades_medidas_id_2->SetValue($this->unidades_medidas_id_2->GetValue(true));
        $this->DataSource->unidades_medidas_uf_id_2->SetValue($this->unidades_medidas_uf_id_2->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @6-C95D3A87
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
        $this->unidades_medidas_id->Prepare();
        $this->unidades_medidas_uf_id->Prepare();

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
                    $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_super_uf->SetValue($this->DataSource->parcela_super_uf->GetValue());
                    $this->unidades_medidas_id->SetValue($this->DataSource->unidades_medidas_id->GetValue());
                    $this->unidades_medidas_uf_id->SetValue($this->DataSource->unidades_medidas_uf_id->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_super_mensura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_super_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_uf_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_super_mensura_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_super_uf_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_uf_id_2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
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
        $this->parcela_seccion->Show();
        $this->parcela_chacra->Show();
        $this->parcela_quinta->Show();
        $this->parcela_macizo->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_parcela->Show();
        $this->parcela_super_mensura->Show();
        $this->parcela_uf->Show();
        $this->parcela_super_uf->Show();
        $this->unidades_medidas_id->Show();
        $this->unidades_medidas_uf_id->Show();
        $this->tipo_depto_parc_id_2->Show();
        $this->parcela_seccion_2->Show();
        $this->parcela_chacra_2->Show();
        $this->parcela_quinta_2->Show();
        $this->parcela_macizo_2->Show();
        $this->parcela_fraccion_2->Show();
        $this->parcela_parcela_2->Show();
        $this->parcela_uf_2->Show();
        $this->parcela_super_mensura_2->Show();
        $this->parcela_super_uf_2->Show();
        $this->unidades_medidas_id_2->Show();
        $this->unidades_medidas_uf_id_2->Show();
        $this->parcela_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End previsados_parcelas_desti Class @6-FCB6E20C

class clsprevisados_parcelas_destiDataSource extends clsDBtdf_nuevo {  //previsados_parcelas_destiDataSource Class @6-8370FC28

//DataSource Variables @6-8B246460
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
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_parcela;
    public $parcela_super_mensura;
    public $parcela_uf;
    public $parcela_super_uf;
    public $unidades_medidas_id;
    public $unidades_medidas_uf_id;
    public $tipo_depto_parc_id_2;
    public $parcela_seccion_2;
    public $parcela_chacra_2;
    public $parcela_quinta_2;
    public $parcela_macizo_2;
    public $parcela_fraccion_2;
    public $parcela_parcela_2;
    public $parcela_uf_2;
    public $parcela_super_mensura_2;
    public $parcela_super_uf_2;
    public $unidades_medidas_id_2;
    public $unidades_medidas_uf_id_2;
    public $parcela_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-606499AA
    function clsprevisados_parcelas_destiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record previsados_parcelas_desti/Error";
        $this->Initialize();
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_super_uf = new clsField("parcela_super_uf", ccsFloat, "");
        
        $this->unidades_medidas_id = new clsField("unidades_medidas_id", ccsInteger, "");
        
        $this->unidades_medidas_uf_id = new clsField("unidades_medidas_uf_id", ccsInteger, "");
        
        $this->tipo_depto_parc_id_2 = new clsField("tipo_depto_parc_id_2", ccsText, "");
        
        $this->parcela_seccion_2 = new clsField("parcela_seccion_2", ccsText, "");
        
        $this->parcela_chacra_2 = new clsField("parcela_chacra_2", ccsText, "");
        
        $this->parcela_quinta_2 = new clsField("parcela_quinta_2", ccsText, "");
        
        $this->parcela_macizo_2 = new clsField("parcela_macizo_2", ccsText, "");
        
        $this->parcela_fraccion_2 = new clsField("parcela_fraccion_2", ccsText, "");
        
        $this->parcela_parcela_2 = new clsField("parcela_parcela_2", ccsText, "");
        
        $this->parcela_uf_2 = new clsField("parcela_uf_2", ccsText, "");
        
        $this->parcela_super_mensura_2 = new clsField("parcela_super_mensura_2", ccsText, "");
        
        $this->parcela_super_uf_2 = new clsField("parcela_super_uf_2", ccsText, "");
        
        $this->unidades_medidas_id_2 = new clsField("unidades_medidas_id_2", ccsText, "");
        
        $this->unidades_medidas_uf_id_2 = new clsField("unidades_medidas_uf_id_2", ccsText, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsText, "");
        

        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_seccion"] = array("Name" => "parcela_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_chacra"] = array("Name" => "parcela_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_quinta"] = array("Name" => "parcela_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_macizo"] = array("Name" => "parcela_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_fraccion"] = array("Name" => "parcela_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_parcela"] = array("Name" => "parcela_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_super_mensura"] = array("Name" => "parcela_super_mensura", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_uf"] = array("Name" => "parcela_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_super_uf"] = array("Name" => "parcela_super_uf", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidades_medidas_id"] = array("Name" => "unidades_medidas_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidades_medidas_uf_id"] = array("Name" => "unidades_medidas_uf_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @6-F29F1EFE
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlprevisado_parcela_destino_id", ccsInteger, "", "", $this->Parameters["urlprevisado_parcela_destino_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsado_parcela_destino_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-A8A78D5C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_parcelas_destinos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-CAFFDC55
    function SetValues()
    {
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_super_uf->SetDBValue(trim($this->f("parcela_super_uf")));
        $this->unidades_medidas_id->SetDBValue(trim($this->f("unidades_medidas_id")));
        $this->unidades_medidas_uf_id->SetDBValue(trim($this->f("unidades_medidas_uf_id")));
        $this->parcela_id->SetDBValue($this->f("parcela_id"));
    }
//End SetValues Method

//Update Method @6-D180A8D4
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["parcela_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
        $this->UpdateFields["parcela_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
        $this->UpdateFields["parcela_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
        $this->UpdateFields["parcela_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
        $this->UpdateFields["parcela_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
        $this->UpdateFields["parcela_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
        $this->UpdateFields["parcela_super_mensura"]["Value"] = $this->parcela_super_mensura->GetDBValue(true);
        $this->UpdateFields["parcela_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
        $this->UpdateFields["parcela_super_uf"]["Value"] = $this->parcela_super_uf->GetDBValue(true);
        $this->UpdateFields["unidades_medidas_id"]["Value"] = $this->unidades_medidas_id->GetDBValue(true);
        $this->UpdateFields["unidades_medidas_uf_id"]["Value"] = $this->unidades_medidas_uf_id->GetDBValue(true);
        $this->UpdateFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("previsados_parcelas_destinos", $this->UpdateFields, $this);
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

} //End previsados_parcelas_destiDataSource Class @6-FCB6E20C

//Initialize Page @1-93943973
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
$TemplateFileName = "previsados_cambiar_nomencla.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-679CD64E
include_once("./previsados_cambiar_nomencla_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-69F0179A
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$previsados_parcelas_desti = new clsRecordprevisados_parcelas_desti("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->previsados_parcelas_desti = & $previsados_parcelas_desti;
$previsados_parcelas_desti->Initialize();

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

//Execute Components @1-4821E928
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$previsados_parcelas_desti->Operation();
//End Execute Components

//Go to destination page @1-025F1AB4
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
    unset($previsados_parcelas_desti);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-987016B0
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$previsados_parcelas_desti->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CLKQPHOK3I7H5L2O1N = explode("|", "<center><font face=\"Ari|al\"><small>&#71;&#101|;n&#101;&#114;&#97;&#|116;&#101;&#100; <!--| SCC -->w&#105;th <!--| SCC -->C&#111;&#1|00;&#101;&#67;harge |<!-- CCS -->S&#116;&#11|7;&#100;&#105;o.</small|></font></center>|");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($CLKQPHOK3I7H5L2O1N,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($CLKQPHOK3I7H5L2O1N,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($CLKQPHOK3I7H5L2O1N,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-3C8DC524
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($previsados_parcelas_desti);
unset($Tpl);
//End Unload Page


?>
