<?php

class clsRecordheaderParcelaparcela { //parcela Class @2-C05FC798

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

//Class_Initialize Event @2-089E41FE
    function clsRecordheaderParcelaparcela($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcela/Error";
        $this->DataSource = new clsheaderParcelaparcelaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "parcela";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->parcela_nomenclatura = new clsControl(ccsLabel, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", $Method, NULL), $this);
            $this->tipo_padron_parc_desc = new clsControl(ccsLabel, "tipo_padron_parc_desc", "tipo_padron_parc_desc", ccsText, "", CCGetRequestParam("tipo_padron_parc_desc", $Method, NULL), $this);
            $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", $Method, NULL), $this);
            $this->tipo_depto_parc_desc = new clsControl(ccsLabel, "tipo_depto_parc_desc", "tipo_depto_parc_desc", ccsText, "", CCGetRequestParam("tipo_depto_parc_desc", $Method, NULL), $this);
            $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", $Method, NULL), $this);
            $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsFloat, "", CCGetRequestParam("parcela_super_mensura", $Method, NULL), $this);
            $this->parcela_sup_uf = new clsControl(ccsLabel, "parcela_sup_uf", "parcela_sup_uf", ccsFloat, "", CCGetRequestParam("parcela_sup_uf", $Method, NULL), $this);
            $this->parcela_porc_uf = new clsControl(ccsLabel, "parcela_porc_uf", "parcela_porc_uf", ccsFloat, "", CCGetRequestParam("parcela_porc_uf", $Method, NULL), $this);
            $this->tipo_parcela_uso_descrip = new clsControl(ccsLabel, "tipo_parcela_uso_descrip", "tipo_parcela_uso_descrip", ccsText, "", CCGetRequestParam("tipo_parcela_uso_descrip", $Method, NULL), $this);
            $this->tipo_parcela_descrip = new clsControl(ccsLabel, "tipo_parcela_descrip", "tipo_parcela_descrip", ccsText, "", CCGetRequestParam("tipo_parcela_descrip", $Method, NULL), $this);
            $this->parcela_val_tierra = new clsControl(ccsLabel, "parcela_val_tierra", "parcela_val_tierra", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_tierra", $Method, NULL), $this);
            $this->parcela_val_mejora = new clsControl(ccsLabel, "parcela_val_mejora", "parcela_val_mejora", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_mejora", $Method, NULL), $this);
            $this->parcela_val_ampliac = new clsControl(ccsLabel, "parcela_val_ampliac", "parcela_val_ampliac", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_ampliac", $Method, NULL), $this);
            $this->unidades_medidas_abrev = new clsControl(ccsLabel, "unidades_medidas_abrev", "unidades_medidas_abrev", ccsText, "", CCGetRequestParam("unidades_medidas_abrev", $Method, NULL), $this);
            $this->parcela_observa = new clsControl(ccsLabel, "parcela_observa", "parcela_observa", ccsText, "", CCGetRequestParam("parcela_observa", $Method, NULL), $this);
            $this->parcela_notas_nom = new clsControl(ccsLabel, "parcela_notas_nom", "parcela_notas_nom", ccsText, "", CCGetRequestParam("parcela_notas_nom", $Method, NULL), $this);
            $this->parcela_restr = new clsControl(ccsLabel, "parcela_restr", "parcela_restr", ccsText, "", CCGetRequestParam("parcela_restr", $Method, NULL), $this);
            $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", $Method, NULL), $this);
            $this->instrumento = new clsControl(ccsLabel, "instrumento", "instrumento", ccsText, "", CCGetRequestParam("instrumento", $Method, NULL), $this);
            $this->parcela_descrip = new clsControl(ccsLabel, "parcela_descrip", "parcela_descrip", ccsText, "", CCGetRequestParam("parcela_descrip", $Method, NULL), $this);
            $this->tipo_restricc_parcela_desc = new clsControl(ccsLabel, "tipo_restricc_parcela_desc", "tipo_restricc_parcela_desc", ccsText, "", CCGetRequestParam("tipo_restricc_parcela_desc", $Method, NULL), $this);
            $this->tipo_restricc_parcela_desc->HTML = true;
            $this->plancheta = new clsControl(ccsLabel, "plancheta", "plancheta", ccsText, "", CCGetRequestParam("plancheta", $Method, NULL), $this);
            $this->plancheta->HTML = true;
            $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", $Method, NULL), $this);
            $this->parcela_val_total = new clsControl(ccsLabel, "parcela_val_total", "parcela_val_total", ccsFloat, array(False, 2, Null, "", False, "\$", "", 1, True, ""), CCGetRequestParam("parcela_val_total", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-16FD92D0
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
    }
//End Initialize Method

//Validate Method @2-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-C82FB0E4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_nomenclatura->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_desc->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_partida->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_desc->Errors->Count());
        $errors = ($errors || $this->parcela_predio->Errors->Count());
        $errors = ($errors || $this->parcela_rte->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_super_mensura->Errors->Count());
        $errors = ($errors || $this->parcela_sup_uf->Errors->Count());
        $errors = ($errors || $this->parcela_porc_uf->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_uso_descrip->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_descrip->Errors->Count());
        $errors = ($errors || $this->parcela_val_tierra->Errors->Count());
        $errors = ($errors || $this->parcela_val_mejora->Errors->Count());
        $errors = ($errors || $this->parcela_val_ampliac->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_abrev->Errors->Count());
        $errors = ($errors || $this->parcela_observa->Errors->Count());
        $errors = ($errors || $this->parcela_notas_nom->Errors->Count());
        $errors = ($errors || $this->parcela_restr->Errors->Count());
        $errors = ($errors || $this->plano->Errors->Count());
        $errors = ($errors || $this->instrumento->Errors->Count());
        $errors = ($errors || $this->parcela_descrip->Errors->Count());
        $errors = ($errors || $this->tipo_restricc_parcela_desc->Errors->Count());
        $errors = ($errors || $this->plancheta->Errors->Count());
        $errors = ($errors || $this->tipo_est_parc_descr->Errors->Count());
        $errors = ($errors || $this->parcela_val_total->Errors->Count());
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

//Operation Method @2-17DC9883
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

//Show Method @2-BED2DC0C
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
                $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                $this->tipo_padron_parc_desc->SetValue($this->DataSource->tipo_padron_parc_desc->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->tipo_depto_parc_desc->SetValue($this->DataSource->tipo_depto_parc_desc->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->parcela_sup_uf->SetValue($this->DataSource->parcela_sup_uf->GetValue());
                $this->parcela_porc_uf->SetValue($this->DataSource->parcela_porc_uf->GetValue());
                $this->tipo_parcela_uso_descrip->SetValue($this->DataSource->tipo_parcela_uso_descrip->GetValue());
                $this->tipo_parcela_descrip->SetValue($this->DataSource->tipo_parcela_descrip->GetValue());
                $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                $this->parcela_val_mejora->SetValue($this->DataSource->parcela_val_mejora->GetValue());
                $this->parcela_val_ampliac->SetValue($this->DataSource->parcela_val_ampliac->GetValue());
                $this->unidades_medidas_abrev->SetValue($this->DataSource->unidades_medidas_abrev->GetValue());
                $this->parcela_observa->SetValue($this->DataSource->parcela_observa->GetValue());
                $this->parcela_notas_nom->SetValue($this->DataSource->parcela_notas_nom->GetValue());
                $this->parcela_restr->SetValue($this->DataSource->parcela_restr->GetValue());
                $this->parcela_descrip->SetValue($this->DataSource->parcela_descrip->GetValue());
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->parcela_val_total->SetValue($this->DataSource->parcela_val_total->GetValue());
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_nomenclatura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_predio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_rte->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_super_mensura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_sup_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_porc_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_uso_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_tierra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_mejora->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_ampliac->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_abrev->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_observa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_notas_nom->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_restr->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->instrumento->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_restricc_parcela_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plancheta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_est_parc_descr->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_val_total->Errors->ToString());
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

        $this->parcela_nomenclatura->Show();
        $this->tipo_padron_parc_desc->Show();
        $this->parcela_seccion->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_uf->Show();
        $this->parcela_partida->Show();
        $this->tipo_depto_parc_desc->Show();
        $this->parcela_predio->Show();
        $this->parcela_rte->Show();
        $this->parcela_chacra->Show();
        $this->parcela_macizo->Show();
        $this->parcela_quinta->Show();
        $this->parcela_parcela->Show();
        $this->parcela_super_mensura->Show();
        $this->parcela_sup_uf->Show();
        $this->parcela_porc_uf->Show();
        $this->tipo_parcela_uso_descrip->Show();
        $this->tipo_parcela_descrip->Show();
        $this->parcela_val_tierra->Show();
        $this->parcela_val_mejora->Show();
        $this->parcela_val_ampliac->Show();
        $this->unidades_medidas_abrev->Show();
        $this->parcela_observa->Show();
        $this->parcela_notas_nom->Show();
        $this->parcela_restr->Show();
        $this->plano->Show();
        $this->instrumento->Show();
        $this->parcela_descrip->Show();
        $this->tipo_restricc_parcela_desc->Show();
        $this->plancheta->Show();
        $this->tipo_est_parc_descr->Show();
        $this->parcela_val_total->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End parcela Class @2-FCB6E20C

class clsheaderParcelaparcelaDataSource extends clsDBtdf_nuevo {  //parcelaDataSource Class @2-386705FC

//DataSource Variables @2-407E45E3
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $parcela_nomenclatura;
    public $tipo_padron_parc_desc;
    public $parcela_seccion;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_partida;
    public $tipo_depto_parc_desc;
    public $parcela_predio;
    public $parcela_rte;
    public $parcela_chacra;
    public $parcela_macizo;
    public $parcela_quinta;
    public $parcela_parcela;
    public $parcela_super_mensura;
    public $parcela_sup_uf;
    public $parcela_porc_uf;
    public $tipo_parcela_uso_descrip;
    public $tipo_parcela_descrip;
    public $parcela_val_tierra;
    public $parcela_val_mejora;
    public $parcela_val_ampliac;
    public $unidades_medidas_abrev;
    public $parcela_observa;
    public $parcela_notas_nom;
    public $parcela_restr;
    public $plano;
    public $instrumento;
    public $parcela_descrip;
    public $tipo_restricc_parcela_desc;
    public $plancheta;
    public $tipo_est_parc_descr;
    public $parcela_val_total;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-B0726FBE
    function clsheaderParcelaparcelaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record parcela/Error";
        $this->Initialize();
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        
        $this->tipo_padron_parc_desc = new clsField("tipo_padron_parc_desc", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->tipo_depto_parc_desc = new clsField("tipo_depto_parc_desc", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->parcela_sup_uf = new clsField("parcela_sup_uf", ccsFloat, "");
        
        $this->parcela_porc_uf = new clsField("parcela_porc_uf", ccsFloat, "");
        
        $this->tipo_parcela_uso_descrip = new clsField("tipo_parcela_uso_descrip", ccsText, "");
        
        $this->tipo_parcela_descrip = new clsField("tipo_parcela_descrip", ccsText, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsFloat, "");
        
        $this->parcela_val_mejora = new clsField("parcela_val_mejora", ccsFloat, "");
        
        $this->parcela_val_ampliac = new clsField("parcela_val_ampliac", ccsFloat, "");
        
        $this->unidades_medidas_abrev = new clsField("unidades_medidas_abrev", ccsText, "");
        
        $this->parcela_observa = new clsField("parcela_observa", ccsText, "");
        
        $this->parcela_notas_nom = new clsField("parcela_notas_nom", ccsText, "");
        
        $this->parcela_restr = new clsField("parcela_restr", ccsText, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->instrumento = new clsField("instrumento", ccsText, "");
        
        $this->parcela_descrip = new clsField("parcela_descrip", ccsText, "");
        
        $this->tipo_restricc_parcela_desc = new clsField("tipo_restricc_parcela_desc", ccsText, "");
        
        $this->plancheta = new clsField("plancheta", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        
        $this->parcela_val_total = new clsField("parcela_val_total", ccsFloat, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1FDC5EE8
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-D42192C4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT parcelas.*, tipos_deptos_parcela.*, tipos_padrones_parcela.*, tipos_parcelas_usos.*, unidades_medidas_abrev, tipos_estados_parcela.*,\n\n" .
        "tipo_instrumento_descrip, tipo_parcela_descrip \n\n" .
        "FROM ((((((parcelas LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_parcelas_usos ON\n\n" .
        "parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id AND parcelas.tipo_parcela_uso_id = tipos_parcelas_usos.tipo_parcela_uso_id) LEFT JOIN tipos_parcelas ON\n\n" .
        "parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id AND parcelas.tipo_parcela_id = tipos_parcelas.tipo_parcela_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id AND parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id AND parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_instrumentos ON\n\n" .
        "parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id AND parcelas.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-F74BCABD
    function SetValues()
    {
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
        $this->tipo_padron_parc_desc->SetDBValue($this->f("tipo_padron_parc_desc"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->tipo_depto_parc_desc->SetDBValue($this->f("tipo_depto_parc_desc"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->parcela_sup_uf->SetDBValue(trim($this->f("parcela_sup_uf")));
        $this->parcela_porc_uf->SetDBValue(trim($this->f("parcela_porc_uf")));
        $this->tipo_parcela_uso_descrip->SetDBValue($this->f("tipo_parcela_uso_descrip"));
        $this->tipo_parcela_descrip->SetDBValue($this->f("tipo_parcela_descrip"));
        $this->parcela_val_tierra->SetDBValue(trim($this->f("parcela_val_tierra")));
        $this->parcela_val_mejora->SetDBValue(trim($this->f("parcela_val_mejora")));
        $this->parcela_val_ampliac->SetDBValue(trim($this->f("parcela_val_ampliac")));
        $this->unidades_medidas_abrev->SetDBValue($this->f("unidades_medidas_abrev"));
        $this->parcela_observa->SetDBValue($this->f("parcela_observa"));
        $this->parcela_notas_nom->SetDBValue($this->f("parcela_notas_nom"));
        $this->parcela_restr->SetDBValue($this->f("parcela_restr"));
        $this->parcela_descrip->SetDBValue($this->f("parcela_descrip"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
        $this->parcela_val_total->SetDBValue(trim($this->f("parcela_val_total")));
    }
//End SetValues Method

} //End parcelaDataSource Class @2-FCB6E20C

class clsheaderParcela { //headerParcela class @1-9C2844B1

//Variables @1-51D7F06F
    public $ComponentType = "IncludablePage";
    public $Connections = array();
    public $FileName = "";
    public $Redirect = "";
    public $Tpl = "";
    public $TemplateFileName = "";
    public $BlockToParse = "";
    public $ComponentName = "";
    public $Attributes = "";

    // Events;
    public $CCSEvents = "";
    public $CCSEventResult = "";
    public $RelativePath;
    public $Visible;
    public $Parent;
//End Variables

//Class_Initialize Event @1-8BAB15B4
    function clsheaderParcela($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        $this->FileName = "headerParcela.php";
        $this->Redirect = "";
        $this->TemplateFileName = "headerParcela.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "CP1252";
        $this->ContentType = "text/html";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-E0BA81A9
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
        unset($this->parcela);
    }
//End Class_Terminate Event

//BindEvents Method @1-42285168
    function BindEvents()
    {
        $this->parcela->CCSEvents["BeforeShow"] = "headerParcela_parcela_BeforeShow";
        $this->CCSEvents["AfterInitialize"] = "headerParcela_AfterInitialize";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize", $this);
    }
//End BindEvents Method

//Operations Method @1-FB94522B
    function Operations()
    {
        global $Redirect;
        if(!$this->Visible)
            return "";
        $this->parcela->Operation();
    }
//End Operations Method

//Initialize Method @1-283DCC30
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CCSEvents["BeforeInitialize"] = "headerParcela_BeforeInitialize";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
        if(!$this->Visible)
            return "";
        $this->DBtdf_nuevo = new clsDBtdf_nuevo();
        $this->Connections["tdf_nuevo"] = & $this->DBtdf_nuevo;
        $this->Attributes = & $this->Parent->Attributes;

        // Create Components
        $this->parcela = new clsRecordheaderParcelaparcela($this->RelativePath, $this);
        $this->parcela->Initialize();
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-E2410C92
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        $block_path = $Tpl->block_path;
        $Tpl->LoadTemplate("/gestion/" . $this->TemplateFileName, $this->ComponentName, $this->TemplateEncoding, "remove");
        $Tpl->block_path = $Tpl->block_path . "/" . $this->ComponentName;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $block_path;
            $Tpl->SetVar($this->ComponentName, "");
            return "";
        }
        $this->Attributes->Show();
        $this->parcela->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End headerParcela Class @1-FCB6E20C

//Include Event File @1-AA251039
include_once(RelativePath . "/gestion/headerParcela_events.php");
//End Include Event File
?>
