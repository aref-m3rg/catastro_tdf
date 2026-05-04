<?php
//Include Common Files @1-2D710B02
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "gridParcelas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridparcelas_unidades_medidas1 { //parcelas_unidades_medidas1 class @37-62817F06

//Variables @37-28BFA76F

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
    public $Sorter_parcela_super_mensura;
    public $Sorter_parcela_avaluo;
    public $Sorter_parcela_padron;
    public $Sorter_parcela_avaluo1;
    public $Sorter_parcela_avaluo2;
    public $Sorter_parcela_avaluo3;
//End Variables

//Class_Initialize Event @37-FA978A79
    function clsGridparcelas_unidades_medidas1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_unidades_medidas1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_unidades_medidas1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_unidades_medidas1DataSource($this);
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
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        $this->SorterName = CCGetParam("parcelas_unidades_medidas1Order", "");
        $this->SorterDirection = CCGetParam("parcelas_unidades_medidas1Dir", "");

        $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsFloat, "", CCGetRequestParam("parcela_super_mensura", ccsGet, NULL), $this);
        $this->n6 = new clsControl(ccsLabel, "n6", "n6", ccsText, "", CCGetRequestParam("n6", ccsGet, NULL), $this);
        $this->unidades_medidas_htm = new clsControl(ccsLabel, "unidades_medidas_htm", "unidades_medidas_htm", ccsText, "", CCGetRequestParam("unidades_medidas_htm", ccsGet, NULL), $this);
        $this->unidades_medidas_htm->HTML = true;
        $this->n1 = new clsControl(ccsLabel, "n1", "n1", ccsText, "", CCGetRequestParam("n1", ccsGet, NULL), $this);
        $this->n2 = new clsControl(ccsLabel, "n2", "n2", ccsText, "", CCGetRequestParam("n2", ccsGet, NULL), $this);
        $this->n3 = new clsControl(ccsLabel, "n3", "n3", ccsText, "", CCGetRequestParam("n3", ccsGet, NULL), $this);
        $this->n4 = new clsControl(ccsLabel, "n4", "n4", ccsText, "", CCGetRequestParam("n4", ccsGet, NULL), $this);
        $this->n5 = new clsControl(ccsLabel, "n5", "n5", ccsText, "", CCGetRequestParam("n5", ccsGet, NULL), $this);
        $this->parcela_val_tierra = new clsControl(ccsLabel, "parcela_val_tierra", "parcela_val_tierra", ccsText, "", CCGetRequestParam("parcela_val_tierra", ccsGet, NULL), $this);
        $this->n7 = new clsControl(ccsLabel, "n7", "n7", ccsText, "", CCGetRequestParam("n7", ccsGet, NULL), $this);
        $this->n8 = new clsControl(ccsLabel, "n8", "n8", ccsText, "", CCGetRequestParam("n8", ccsGet, NULL), $this);
        $this->n9 = new clsControl(ccsLabel, "n9", "n9", ccsText, "", CCGetRequestParam("n9", ccsGet, NULL), $this);
        $this->n10 = new clsControl(ccsLabel, "n10", "n10", ccsText, "", CCGetRequestParam("n10", ccsGet, NULL), $this);
        $this->n11 = new clsControl(ccsLabel, "n11", "n11", ccsText, "", CCGetRequestParam("n11", ccsGet, NULL), $this);
        $this->tipo_est_parc_descr = new clsControl(ccsLabel, "tipo_est_parc_descr", "tipo_est_parc_descr", ccsText, "", CCGetRequestParam("tipo_est_parc_descr", ccsGet, NULL), $this);
        $this->Link_Edit = new clsControl(ccsLink, "Link_Edit", "Link_Edit", ccsText, "", CCGetRequestParam("Link_Edit", ccsGet, NULL), $this);
        $this->Link_Edit->Page = "recordParcela.php";
        $this->plancheta_html = new clsControl(ccsLabel, "plancheta_html", "plancheta_html", ccsText, "", CCGetRequestParam("plancheta_html", ccsGet, NULL), $this);
        $this->plancheta_html->HTML = true;
        $this->editar = new clsControl(ccsImageLink, "editar", "editar", ccsText, "", CCGetRequestParam("editar", ccsGet, NULL), $this);
        $this->editar->Page = "recordParcela.php";
        $this->direcciones = new clsControl(ccsImageLink, "direcciones", "direcciones", ccsText, "", CCGetRequestParam("direcciones", ccsGet, NULL), $this);
        $this->direcciones->Page = "gridDirParcela.php";
        $this->titularidad = new clsControl(ccsImageLink, "titularidad", "titularidad", ccsText, "", CCGetRequestParam("titularidad", ccsGet, NULL), $this);
        $this->titularidad->Page = "gridPersonas.php";
        $this->mejoras = new clsControl(ccsImageLink, "mejoras", "mejoras", ccsText, "", CCGetRequestParam("mejoras", ccsGet, NULL), $this);
        $this->mejoras->Page = "gridMejoras.php";
        $this->poligono = new clsControl(ccsImageLink, "poligono", "poligono", ccsText, "", CCGetRequestParam("poligono", ccsGet, NULL), $this);
        $this->poligono->Page = "../cartografia/cartografia.php";
        $this->preparar_certificado = new clsControl(ccsImageLink, "preparar_certificado", "preparar_certificado", ccsText, "", CCGetRequestParam("preparar_certificado", ccsGet, NULL), $this);
        $this->preparar_certificado->Page = "rpt_nomenclatura.php";
        $this->certificado_parcela = new clsControl(ccsImageLink, "certificado_parcela", "certificado_parcela", ccsText, "", CCGetRequestParam("certificado_parcela", ccsGet, NULL), $this);
        $this->certificado_parcela->Page = "../reportes/rpt_nom_pdf.php";
        $this->parcela_val_mejora = new clsControl(ccsLabel, "parcela_val_mejora", "parcela_val_mejora", ccsText, "", CCGetRequestParam("parcela_val_mejora", ccsGet, NULL), $this);
        $this->parcela_val_ampliac = new clsControl(ccsLabel, "parcela_val_ampliac", "parcela_val_ampliac", ccsText, "", CCGetRequestParam("parcela_val_ampliac", ccsGet, NULL), $this);
        $this->parcela_val_total = new clsControl(ccsLabel, "parcela_val_total", "parcela_val_total", ccsText, "", CCGetRequestParam("parcela_val_total", ccsGet, NULL), $this);
        $this->parcela_id = new clsControl(ccsLabel, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", ccsGet, NULL), $this);
        $this->plano_nro = new clsControl(ccsLabel, "plano_nro", "plano_nro", ccsText, "", CCGetRequestParam("plano_nro", ccsGet, NULL), $this);
        $this->Sorter_parcela_super_mensura = new clsSorter($this->ComponentName, "Sorter_parcela_super_mensura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_parcela_avaluo = new clsSorter($this->ComponentName, "Sorter_parcela_avaluo", $FileName, $this);
        $this->Sorter_parcela_padron = new clsSorter($this->ComponentName, "Sorter_parcela_padron", $FileName, $this);
        $this->Sorter_parcela_avaluo1 = new clsSorter($this->ComponentName, "Sorter_parcela_avaluo1", $FileName, $this);
        $this->Sorter_parcela_avaluo2 = new clsSorter($this->ComponentName, "Sorter_parcela_avaluo2", $FileName, $this);
        $this->Sorter_parcela_avaluo3 = new clsSorter($this->ComponentName, "Sorter_parcela_avaluo3", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @37-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @37-6E6C5310
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlparcela_partida"] = CCGetFromGet("parcela_partida", NULL);
        $this->DataSource->Parameters["urlpart_val"] = CCGetFromGet("part_val", NULL);
        $this->DataSource->Parameters["urltipo_est_parc_id"] = CCGetFromGet("tipo_est_parc_id", NULL);
        $this->DataSource->Parameters["urltipo_parcela_uso_id"] = CCGetFromGet("tipo_parcela_uso_id", NULL);
        $this->DataSource->Parameters["urltipo_depto_parc_id"] = CCGetFromGet("tipo_depto_parc_id", NULL);
        $this->DataSource->Parameters["urltipo_padron_parc_id"] = CCGetFromGet("tipo_padron_parc_id", NULL);
        $this->DataSource->Parameters["urlparcela_seccion"] = CCGetFromGet("parcela_seccion", NULL);
        $this->DataSource->Parameters["urlparcela_chacra"] = CCGetFromGet("parcela_chacra", NULL);
        $this->DataSource->Parameters["urlparcela_quinta"] = CCGetFromGet("parcela_quinta", NULL);
        $this->DataSource->Parameters["urlparcela_macizo"] = CCGetFromGet("parcela_macizo", NULL);
        $this->DataSource->Parameters["urlparcela_fraccion"] = CCGetFromGet("parcela_fraccion", NULL);
        $this->DataSource->Parameters["urlparcela_parcela"] = CCGetFromGet("parcela_parcela", NULL);
        $this->DataSource->Parameters["urlparcela_uf"] = CCGetFromGet("parcela_uf", NULL);
        $this->DataSource->Parameters["urlparcela_predio"] = CCGetFromGet("parcela_predio", NULL);
        $this->DataSource->Parameters["urlparcela_rte"] = CCGetFromGet("parcela_rte", NULL);
        $this->DataSource->Parameters["urltipo_instrumento_id"] = CCGetFromGet("tipo_instrumento_id", NULL);
        $this->DataSource->Parameters["urlparcela_instrumento"] = CCGetFromGet("parcela_instrumento", NULL);
        $this->DataSource->Parameters["urltipo_parcela_id"] = CCGetFromGet("tipo_parcela_id", NULL);
        $this->DataSource->Parameters["urlsup_min"] = CCGetFromGet("sup_min", NULL);
        $this->DataSource->Parameters["urlsup_max"] = CCGetFromGet("sup_max", NULL);
        $this->DataSource->Parameters["urlunidades_medidas_id"] = CCGetFromGet("unidades_medidas_id", NULL);
        $this->DataSource->Parameters["urltipo_restricc_parcela_id"] = CCGetFromGet("tipo_restricc_parcela_id", NULL);
        $this->DataSource->Parameters["urlparcela_observa"] = CCGetFromGet("parcela_observa", NULL);
        $this->DataSource->Parameters["urls_persona_denominacion"] = CCGetFromGet("s_persona_denominacion", NULL);
        $this->DataSource->Parameters["urls_tipo_documento_id"] = CCGetFromGet("s_tipo_documento_id", NULL);
        $this->DataSource->Parameters["urls_persona_nro_doc"] = CCGetFromGet("s_persona_nro_doc", NULL);
        $this->DataSource->Parameters["urls_persona_cuit"] = CCGetFromGet("s_persona_cuit", NULL);
        $this->DataSource->Parameters["urls_persona_conyuge"] = CCGetFromGet("s_persona_conyuge", NULL);
        $this->DataSource->Parameters["urls_tipo_persona_id"] = CCGetFromGet("s_tipo_persona_id", NULL);
        $this->DataSource->Parameters["urls_persona_parcela_num_int"] = CCGetFromGet("s_persona_parcela_num_int", NULL);
        $this->DataSource->Parameters["urls_tipo_instrumento_id"] = CCGetFromGet("s_tipo_instrumento_id", NULL);
        $this->DataSource->Parameters["urls_plano_nro"] = CCGetFromGet("s_plano_nro", NULL);
        $this->DataSource->Parameters["urls_tipo_plano_id"] = CCGetFromGet("s_tipo_plano_id", NULL);
        $this->DataSource->Parameters["urls_plano_ano"] = CCGetFromGet("s_plano_ano", NULL);
        $this->DataSource->Parameters["urls_plano_e_nro"] = CCGetFromGet("s_plano_e_nro", NULL);
        $this->DataSource->Parameters["urls_plano_e_letra"] = CCGetFromGet("s_plano_e_letra", NULL);
        $this->DataSource->Parameters["urls_plano_e_ano"] = CCGetFromGet("s_plano_e_ano", NULL);
        $this->DataSource->Parameters["urls_tipo_estado_plano_id"] = CCGetFromGet("s_tipo_estado_plano_id", NULL);
        $this->DataSource->Parameters["urls_planos_depto"] = CCGetFromGet("s_planos_depto", NULL);
        $this->DataSource->Parameters["urls_plano_profesional"] = CCGetFromGet("s_plano_profesional", NULL);

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
            $this->ControlsVisible["parcela_super_mensura"] = $this->parcela_super_mensura->Visible;
            $this->ControlsVisible["n6"] = $this->n6->Visible;
            $this->ControlsVisible["unidades_medidas_htm"] = $this->unidades_medidas_htm->Visible;
            $this->ControlsVisible["n1"] = $this->n1->Visible;
            $this->ControlsVisible["n2"] = $this->n2->Visible;
            $this->ControlsVisible["n3"] = $this->n3->Visible;
            $this->ControlsVisible["n4"] = $this->n4->Visible;
            $this->ControlsVisible["n5"] = $this->n5->Visible;
            $this->ControlsVisible["parcela_val_tierra"] = $this->parcela_val_tierra->Visible;
            $this->ControlsVisible["n7"] = $this->n7->Visible;
            $this->ControlsVisible["n8"] = $this->n8->Visible;
            $this->ControlsVisible["n9"] = $this->n9->Visible;
            $this->ControlsVisible["n10"] = $this->n10->Visible;
            $this->ControlsVisible["n11"] = $this->n11->Visible;
            $this->ControlsVisible["tipo_est_parc_descr"] = $this->tipo_est_parc_descr->Visible;
            $this->ControlsVisible["Link_Edit"] = $this->Link_Edit->Visible;
            $this->ControlsVisible["plancheta_html"] = $this->plancheta_html->Visible;
            $this->ControlsVisible["editar"] = $this->editar->Visible;
            $this->ControlsVisible["direcciones"] = $this->direcciones->Visible;
            $this->ControlsVisible["titularidad"] = $this->titularidad->Visible;
            $this->ControlsVisible["mejoras"] = $this->mejoras->Visible;
            $this->ControlsVisible["poligono"] = $this->poligono->Visible;
            $this->ControlsVisible["preparar_certificado"] = $this->preparar_certificado->Visible;
            $this->ControlsVisible["certificado_parcela"] = $this->certificado_parcela->Visible;
            $this->ControlsVisible["parcela_val_mejora"] = $this->parcela_val_mejora->Visible;
            $this->ControlsVisible["parcela_val_ampliac"] = $this->parcela_val_ampliac->Visible;
            $this->ControlsVisible["parcela_val_total"] = $this->parcela_val_total->Visible;
            $this->ControlsVisible["parcela_id"] = $this->parcela_id->Visible;
            $this->ControlsVisible["plano_nro"] = $this->plano_nro->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->n6->SetValue($this->DataSource->n6->GetValue());
                $this->unidades_medidas_htm->SetValue($this->DataSource->unidades_medidas_htm->GetValue());
                $this->n1->SetValue($this->DataSource->n1->GetValue());
                $this->n2->SetValue($this->DataSource->n2->GetValue());
                $this->n3->SetValue($this->DataSource->n3->GetValue());
                $this->n4->SetValue($this->DataSource->n4->GetValue());
                $this->n5->SetValue($this->DataSource->n5->GetValue());
                $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                $this->n7->SetValue($this->DataSource->n7->GetValue());
                $this->n8->SetValue($this->DataSource->n8->GetValue());
                $this->n9->SetValue($this->DataSource->n9->GetValue());
                $this->n10->SetValue($this->DataSource->n10->GetValue());
                $this->n11->SetValue($this->DataSource->n11->GetValue());
                $this->tipo_est_parc_descr->SetValue($this->DataSource->tipo_est_parc_descr->GetValue());
                $this->Link_Edit->SetValue($this->DataSource->Link_Edit->GetValue());
                $this->Link_Edit->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link_Edit->Parameters = CCAddParam($this->Link_Edit->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->editar->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->direcciones->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->direcciones->Parameters = CCAddParam($this->direcciones->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->titularidad->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->titularidad->Parameters = CCAddParam($this->titularidad->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->mejoras->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->mejoras->Parameters = CCAddParam($this->mejoras->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->poligono->Parameters = CCGetQueryString("QueryString", array("new", "direcciones", "persona_id", "nro_partida", "parcela_partida", "ccsForm"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "old_parcela_id", $this->DataSource->f("parcela_id"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "old_parcela_partida", $this->DataSource->f("parcela_partida"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "servicio", $this->DataSource->f("gis_srv_name"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "departamento", $this->DataSource->f("parcelas_tipo_depto_parc_id"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "seccion", $this->DataSource->f("parcela_seccion"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "macizo", $this->DataSource->f("parcela_macizo"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "parcela", $this->DataSource->f("parcela_parcela"));
                $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "padron", $this->DataSource->f("parcelas_tipo_padron_parc_id"));
                $this->preparar_certificado->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->preparar_certificado->Parameters = CCAddParam($this->preparar_certificado->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->certificado_parcela->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->certificado_parcela->Parameters = CCAddParam($this->certificado_parcela->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->parcela_val_mejora->SetValue($this->DataSource->parcela_val_mejora->GetValue());
                $this->parcela_val_ampliac->SetValue($this->DataSource->parcela_val_ampliac->GetValue());
                $this->parcela_val_total->SetValue($this->DataSource->parcela_val_total->GetValue());
                $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_super_mensura->Show();
                $this->n6->Show();
                $this->unidades_medidas_htm->Show();
                $this->n1->Show();
                $this->n2->Show();
                $this->n3->Show();
                $this->n4->Show();
                $this->n5->Show();
                $this->parcela_val_tierra->Show();
                $this->n7->Show();
                $this->n8->Show();
                $this->n9->Show();
                $this->n10->Show();
                $this->n11->Show();
                $this->tipo_est_parc_descr->Show();
                $this->Link_Edit->Show();
                $this->plancheta_html->Show();
                $this->editar->Show();
                $this->direcciones->Show();
                $this->titularidad->Show();
                $this->mejoras->Show();
                $this->poligono->Show();
                $this->preparar_certificado->Show();
                $this->certificado_parcela->Show();
                $this->parcela_val_mejora->Show();
                $this->parcela_val_ampliac->Show();
                $this->parcela_val_total->Show();
                $this->parcela_id->Show();
                $this->plano_nro->Show();
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
        $this->Sorter_parcela_super_mensura->Show();
        $this->Navigator->Show();
        $this->Sorter_parcela_avaluo->Show();
        $this->Sorter_parcela_padron->Show();
        $this->Sorter_parcela_avaluo1->Show();
        $this->Sorter_parcela_avaluo2->Show();
        $this->Sorter_parcela_avaluo3->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @37-A3892AB7
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_super_mensura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n6->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidades_medidas_htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n5->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_tierra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n7->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n8->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n9->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n10->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n11->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_est_parc_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link_Edit->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->editar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->direcciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->titularidad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejoras->Errors->ToString());
        $errors = ComposeStrings($errors, $this->poligono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->preparar_certificado->Errors->ToString());
        $errors = ComposeStrings($errors, $this->certificado_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_mejora->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_ampliac->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_total->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_unidades_medidas1 Class @37-FCB6E20C

class clsparcelas_unidades_medidas1DataSource extends clsDBtdf_nuevo {  //parcelas_unidades_medidas1DataSource Class @37-3D2DBE63

//DataSource Variables @37-F1E888E4
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_super_mensura;
    public $n6;
    public $unidades_medidas_htm;
    public $n1;
    public $n2;
    public $n3;
    public $n4;
    public $n5;
    public $parcela_val_tierra;
    public $n7;
    public $n8;
    public $n9;
    public $n10;
    public $n11;
    public $tipo_est_parc_descr;
    public $Link_Edit;
    public $parcela_val_mejora;
    public $parcela_val_ampliac;
    public $parcela_val_total;
    public $parcela_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @37-B8983F6D
    function clsparcelas_unidades_medidas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_unidades_medidas1";
        $this->Initialize();
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->n6 = new clsField("n6", ccsText, "");
        
        $this->unidades_medidas_htm = new clsField("unidades_medidas_htm", ccsText, "");
        
        $this->n1 = new clsField("n1", ccsText, "");
        
        $this->n2 = new clsField("n2", ccsText, "");
        
        $this->n3 = new clsField("n3", ccsText, "");
        
        $this->n4 = new clsField("n4", ccsText, "");
        
        $this->n5 = new clsField("n5", ccsText, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsText, "");
        
        $this->n7 = new clsField("n7", ccsText, "");
        
        $this->n8 = new clsField("n8", ccsText, "");
        
        $this->n9 = new clsField("n9", ccsText, "");
        
        $this->n10 = new clsField("n10", ccsText, "");
        
        $this->n11 = new clsField("n11", ccsText, "");
        
        $this->tipo_est_parc_descr = new clsField("tipo_est_parc_descr", ccsText, "");
        
        $this->Link_Edit = new clsField("Link_Edit", ccsText, "");
        
        $this->parcela_val_mejora = new clsField("parcela_val_mejora", ccsText, "");
        
        $this->parcela_val_ampliac = new clsField("parcela_val_ampliac", ccsText, "");
        
        $this->parcela_val_total = new clsField("parcela_val_total", ccsText, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @37-25DDF895
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_partida desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_super_mensura" => array("parcela_super_mensura", ""), 
            "Sorter_parcela_avaluo" => array("parcelas.parcela_avaluo", ""), 
            "Sorter_parcela_padron" => array("parcela_partida", ""), 
            "Sorter_parcela_avaluo1" => array("parcelas.parcela_avaluo", ""), 
            "Sorter_parcela_avaluo2" => array("parcelas.parcela_avaluo", ""), 
            "Sorter_parcela_avaluo3" => array("parcelas.parcela_avaluo", "")));
    }
//End SetOrder Method

//Prepare Method @37-84A81335
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_partida", ccsInteger, "", "", $this->Parameters["urlparcela_partida"], "", false);
        $this->wp->AddParameter("2", "urlpart_val", ccsInteger, "", "", $this->Parameters["urlpart_val"], "", false);
        $this->wp->AddParameter("3", "urltipo_est_parc_id", ccsInteger, "", "", $this->Parameters["urltipo_est_parc_id"], "", false);
        $this->wp->AddParameter("4", "urltipo_parcela_uso_id", ccsInteger, "", "", $this->Parameters["urltipo_parcela_uso_id"], "", false);
        $this->wp->AddParameter("5", "urltipo_depto_parc_id", ccsInteger, "", "", $this->Parameters["urltipo_depto_parc_id"], "", false);
        $this->wp->AddParameter("6", "urltipo_padron_parc_id", ccsInteger, "", "", $this->Parameters["urltipo_padron_parc_id"], "", false);
        $this->wp->AddParameter("7", "urlparcela_seccion", ccsText, "", "", $this->Parameters["urlparcela_seccion"], "", false);
        $this->wp->AddParameter("8", "urlparcela_chacra", ccsText, "", "", $this->Parameters["urlparcela_chacra"], "", false);
        $this->wp->AddParameter("9", "urlparcela_quinta", ccsText, "", "", $this->Parameters["urlparcela_quinta"], "", false);
        $this->wp->AddParameter("10", "urlparcela_macizo", ccsText, "", "", $this->Parameters["urlparcela_macizo"], "", false);
        $this->wp->AddParameter("11", "urlparcela_fraccion", ccsText, "", "", $this->Parameters["urlparcela_fraccion"], "", false);
        $this->wp->AddParameter("12", "urlparcela_parcela", ccsText, "", "", $this->Parameters["urlparcela_parcela"], "", false);
        $this->wp->AddParameter("13", "urlparcela_uf", ccsText, "", "", $this->Parameters["urlparcela_uf"], "", false);
        $this->wp->AddParameter("14", "urlparcela_predio", ccsText, "", "", $this->Parameters["urlparcela_predio"], "", false);
        $this->wp->AddParameter("15", "urlparcela_rte", ccsText, "", "", $this->Parameters["urlparcela_rte"], "", false);
        $this->wp->AddParameter("16", "urltipo_instrumento_id", ccsInteger, "", "", $this->Parameters["urltipo_instrumento_id"], "", false);
        $this->wp->AddParameter("17", "urlparcela_instrumento", ccsText, "", "", $this->Parameters["urlparcela_instrumento"], "", false);
        $this->wp->AddParameter("18", "urltipo_parcela_id", ccsInteger, "", "", $this->Parameters["urltipo_parcela_id"], "", false);
        $this->wp->AddParameter("19", "urlsup_min", ccsFloat, "", "", $this->Parameters["urlsup_min"], "", false);
        $this->wp->AddParameter("20", "urlsup_max", ccsFloat, "", "", $this->Parameters["urlsup_max"], "", false);
        $this->wp->AddParameter("21", "urlunidades_medidas_id", ccsInteger, "", "", $this->Parameters["urlunidades_medidas_id"], "", false);
        $this->wp->AddParameter("22", "urltipo_restricc_parcela_id", ccsInteger, "", "", $this->Parameters["urltipo_restricc_parcela_id"], "", false);
        $this->wp->AddParameter("23", "urlparcela_observa", ccsText, "", "", $this->Parameters["urlparcela_observa"], "", false);
        $this->wp->AddParameter("24", "urls_persona_denominacion", ccsText, "", "", $this->Parameters["urls_persona_denominacion"], "", false);
        $this->wp->AddParameter("25", "urls_tipo_documento_id", ccsInteger, "", "", $this->Parameters["urls_tipo_documento_id"], "", false);
        $this->wp->AddParameter("26", "urls_persona_nro_doc", ccsInteger, "", "", $this->Parameters["urls_persona_nro_doc"], "", false);
        $this->wp->AddParameter("27", "urls_persona_cuit", ccsText, "", "", $this->Parameters["urls_persona_cuit"], "", false);
        $this->wp->AddParameter("28", "urls_persona_conyuge", ccsText, "", "", $this->Parameters["urls_persona_conyuge"], "", false);
        $this->wp->AddParameter("29", "urls_tipo_persona_id", ccsInteger, "", "", $this->Parameters["urls_tipo_persona_id"], "", false);
        $this->wp->AddParameter("30", "urls_persona_parcela_num_int", ccsText, "", "", $this->Parameters["urls_persona_parcela_num_int"], "", false);
        $this->wp->AddParameter("31", "urls_tipo_instrumento_id", ccsInteger, "", "", $this->Parameters["urls_tipo_instrumento_id"], "", false);
        $this->wp->AddParameter("32", "urls_plano_nro", ccsInteger, "", "", $this->Parameters["urls_plano_nro"], "", false);
        $this->wp->AddParameter("33", "urls_tipo_plano_id", ccsInteger, "", "", $this->Parameters["urls_tipo_plano_id"], "", false);
        $this->wp->AddParameter("34", "urls_plano_ano", ccsInteger, "", "", $this->Parameters["urls_plano_ano"], "", false);
        $this->wp->AddParameter("35", "urls_plano_e_nro", ccsInteger, "", "", $this->Parameters["urls_plano_e_nro"], "", false);
        $this->wp->AddParameter("36", "urls_plano_e_letra", ccsText, "", "", $this->Parameters["urls_plano_e_letra"], "", false);
        $this->wp->AddParameter("37", "urls_plano_e_ano", ccsInteger, "", "", $this->Parameters["urls_plano_e_ano"], "", false);
        $this->wp->AddParameter("38", "urls_tipo_estado_plano_id", ccsInteger, "", "", $this->Parameters["urls_tipo_estado_plano_id"], "", false);
        $this->wp->AddParameter("39", "urls_planos_depto", ccsInteger, "", "", $this->Parameters["urls_planos_depto"], "", false);
        $this->wp->AddParameter("40", "urls_plano_profesional", ccsInteger, "", "", $this->Parameters["urls_plano_profesional"], "", false);
        $this->wp->AddParameter("41", "urls_plano_profesional", ccsInteger, "", "", $this->Parameters["urls_plano_profesional"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opGreaterThanOrEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "parcelas.tipo_est_parc_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "parcelas.tipo_parcela_uso_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "parcelas.tipo_depto_parc_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "parcelas.tipo_padron_parc_id", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "parcelas.parcela_seccion", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "parcelas.parcela_chacra", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "parcelas.parcela_quinta", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsText),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opEqual, "parcelas.parcela_macizo", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opEqual, "parcelas.parcela_fraccion", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
        $this->wp->Criterion[12] = $this->wp->Operation(opEqual, "parcelas.parcela_parcela", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
        $this->wp->Criterion[13] = $this->wp->Operation(opEqual, "parcelas.parcela_uf", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsText),false);
        $this->wp->Criterion[14] = $this->wp->Operation(opEqual, "parcelas.parcela_predio", $this->wp->GetDBValue("14"), $this->ToSQL($this->wp->GetDBValue("14"), ccsText),false);
        $this->wp->Criterion[15] = $this->wp->Operation(opEqual, "parcelas.parcela_rte", $this->wp->GetDBValue("15"), $this->ToSQL($this->wp->GetDBValue("15"), ccsText),false);
        $this->wp->Criterion[16] = $this->wp->Operation(opEqual, "parcelas.tipo_instrumento_id", $this->wp->GetDBValue("16"), $this->ToSQL($this->wp->GetDBValue("16"), ccsInteger),false);
        $this->wp->Criterion[17] = $this->wp->Operation(opEqual, "parcelas.parcela_instrumento", $this->wp->GetDBValue("17"), $this->ToSQL($this->wp->GetDBValue("17"), ccsText),false);
        $this->wp->Criterion[18] = $this->wp->Operation(opEqual, "parcelas.tipo_parcela_id", $this->wp->GetDBValue("18"), $this->ToSQL($this->wp->GetDBValue("18"), ccsInteger),false);
        $this->wp->Criterion[19] = $this->wp->Operation(opGreaterThanOrEqual, "parcelas.parcela_super_mensura", $this->wp->GetDBValue("19"), $this->ToSQL($this->wp->GetDBValue("19"), ccsFloat),false);
        $this->wp->Criterion[20] = $this->wp->Operation(opLessThanOrEqual, "parcelas.parcela_super_mensura", $this->wp->GetDBValue("20"), $this->ToSQL($this->wp->GetDBValue("20"), ccsFloat),false);
        $this->wp->Criterion[21] = $this->wp->Operation(opEqual, "parcelas.unidades_medidas_id", $this->wp->GetDBValue("21"), $this->ToSQL($this->wp->GetDBValue("21"), ccsInteger),false);
        $this->wp->Criterion[22] = $this->wp->Operation(opEqual, "parcelas.tipo_restricc_parcela_id", $this->wp->GetDBValue("22"), $this->ToSQL($this->wp->GetDBValue("22"), ccsInteger),false);
        $this->wp->Criterion[23] = $this->wp->Operation(opContains, "parcelas.parcela_observa", $this->wp->GetDBValue("23"), $this->ToSQL($this->wp->GetDBValue("23"), ccsText),false);
        $this->wp->Criterion[24] = $this->wp->Operation(opContains, "personas.persona_denominacion", $this->wp->GetDBValue("24"), $this->ToSQL($this->wp->GetDBValue("24"), ccsText),false);
        $this->wp->Criterion[25] = $this->wp->Operation(opEqual, "personas.tipo_documento_id", $this->wp->GetDBValue("25"), $this->ToSQL($this->wp->GetDBValue("25"), ccsInteger),false);
        $this->wp->Criterion[26] = $this->wp->Operation(opEqual, "personas.persona_nro_doc", $this->wp->GetDBValue("26"), $this->ToSQL($this->wp->GetDBValue("26"), ccsInteger),false);
        $this->wp->Criterion[27] = $this->wp->Operation(opEqual, "personas.persona_cuit", $this->wp->GetDBValue("27"), $this->ToSQL($this->wp->GetDBValue("27"), ccsText),false);
        $this->wp->Criterion[28] = $this->wp->Operation(opContains, "personas.persona_conyuge", $this->wp->GetDBValue("28"), $this->ToSQL($this->wp->GetDBValue("28"), ccsText),false);
        $this->wp->Criterion[29] = $this->wp->Operation(opEqual, "personas.tipo_persona_id", $this->wp->GetDBValue("29"), $this->ToSQL($this->wp->GetDBValue("29"), ccsInteger),false);
        $this->wp->Criterion[30] = $this->wp->Operation(opContains, "personas_parcelas.persona_parcela_num_int", $this->wp->GetDBValue("30"), $this->ToSQL($this->wp->GetDBValue("30"), ccsText),false);
        $this->wp->Criterion[31] = $this->wp->Operation(opEqual, "personas_parcelas.tipo_instrumento_id", $this->wp->GetDBValue("31"), $this->ToSQL($this->wp->GetDBValue("31"), ccsInteger),false);
        $this->wp->Criterion[32] = $this->wp->Operation(opEqual, "planos.plano_nro", $this->wp->GetDBValue("32"), $this->ToSQL($this->wp->GetDBValue("32"), ccsInteger),false);
        $this->wp->Criterion[33] = $this->wp->Operation(opEqual, "planos.tipo_plano_id", $this->wp->GetDBValue("33"), $this->ToSQL($this->wp->GetDBValue("33"), ccsInteger),false);
        $this->wp->Criterion[34] = $this->wp->Operation(opEqual, "planos.plano_anio", $this->wp->GetDBValue("34"), $this->ToSQL($this->wp->GetDBValue("34"), ccsInteger),false);
        $this->wp->Criterion[35] = $this->wp->Operation(opEqual, "planos.plano_e_nro", $this->wp->GetDBValue("35"), $this->ToSQL($this->wp->GetDBValue("35"), ccsInteger),false);
        $this->wp->Criterion[36] = $this->wp->Operation(opContains, "planos.plano_e_letra", $this->wp->GetDBValue("36"), $this->ToSQL($this->wp->GetDBValue("36"), ccsText),false);
        $this->wp->Criterion[37] = $this->wp->Operation(opEqual, "planos.plano_e_anio", $this->wp->GetDBValue("37"), $this->ToSQL($this->wp->GetDBValue("37"), ccsInteger),false);
        $this->wp->Criterion[38] = $this->wp->Operation(opEqual, "planos.tipo_estado_plano_id", $this->wp->GetDBValue("38"), $this->ToSQL($this->wp->GetDBValue("38"), ccsInteger),false);
        $this->wp->Criterion[39] = $this->wp->Operation(opEqual, "planos.tipo_depto_parc_id", $this->wp->GetDBValue("39"), $this->ToSQL($this->wp->GetDBValue("39"), ccsInteger),false);
        $this->wp->Criterion[40] = $this->wp->Operation(opEqual, "planos.profesional_id", $this->wp->GetDBValue("40"), $this->ToSQL($this->wp->GetDBValue("40"), ccsInteger),false);
        $this->wp->Criterion[41] = $this->wp->Operation(opEqual, "planos.profesional_id_2", $this->wp->GetDBValue("41"), $this->ToSQL($this->wp->GetDBValue("41"), ccsInteger),false);
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
             $this->wp->Criterion[26]), 
             $this->wp->Criterion[27]), 
             $this->wp->Criterion[28]), 
             $this->wp->Criterion[29]), 
             $this->wp->Criterion[30]), 
             $this->wp->Criterion[31]), 
             $this->wp->Criterion[32]), 
             $this->wp->Criterion[33]), 
             $this->wp->Criterion[34]), 
             $this->wp->Criterion[35]), 
             $this->wp->Criterion[36]), 
             $this->wp->Criterion[37]), 
             $this->wp->Criterion[38]), 
             $this->wp->Criterion[39]), $this->wp->opOR(
             true, 
             $this->wp->Criterion[40], 
             $this->wp->Criterion[41]));
    }
//End Prepare Method

//Open Method @37-5F9E555F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT unidades_medidas_htm, parcelas.parcela_super_mensura AS parcela_super_mensura, parcelas.parcela_id AS parcela_id, parcelas.parcela_seccion AS parcela_seccion,\n\n" .
        "parcelas.parcela_parcela AS parcela_parcela, parcela_partida, parcela_macizo, parcela_chacra, parcela_quinta, parcela_fraccion,\n\n" .
        "parcela_uf, parcela_predio, parcela_rte, parcela_val_tierra, parcela_val_mejora, parcela_val_ampliac, parcela_val_total,\n\n" .
        "tipo_depto_parc_abrev, tipo_padron_parc_abrev, gis_srv_name, tipo_est_parc_descr, parcelas.tipo_depto_parc_id AS parcelas_tipo_depto_parc_id,\n\n" .
        "parcelas.tipo_padron_parc_id AS parcelas_tipo_padron_parc_id, parcela_receptividad, persona_denominacion, union_desglose_id,\n\n" .
        "planos.* \n\n" .
        "FROM ((((((((parcelas LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN gis_servicios ON\n\n" .
        "parcelas.tipo_depto_parc_id = gis_servicios.dpto_id AND parcelas.tipo_padron_parc_id = gis_servicios.padron_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.parcela_id = parcelas.parcela_id) LEFT JOIN uniones_desgloses ON\n\n" .
        "uniones_desgloses.parcela_destino_id = parcelas.parcela_id) LEFT JOIN personas ON\n\n" .
        "personas_parcelas.persona_id = personas.persona_id) LEFT JOIN planos ON\n\n" .
        "uniones_desgloses.plano_id = planos.plano_id {SQL_Where}\n\n" .
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

//SetValues Method @37-5D526179
    function SetValues()
    {
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->n6->SetDBValue($this->f("parcela_macizo"));
        $this->unidades_medidas_htm->SetDBValue($this->f("unidades_medidas_htm"));
        $this->n1->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->n2->SetDBValue($this->f("tipo_padron_parc_abrev"));
        $this->n3->SetDBValue($this->f("parcela_seccion"));
        $this->n4->SetDBValue($this->f("parcela_chacra"));
        $this->n5->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_val_tierra->SetDBValue($this->f("parcela_val_tierra"));
        $this->n7->SetDBValue($this->f("parcela_fraccion"));
        $this->n8->SetDBValue($this->f("parcela_parcela"));
        $this->n9->SetDBValue($this->f("parcela_uf"));
        $this->n10->SetDBValue($this->f("parcela_predio"));
        $this->n11->SetDBValue($this->f("parcela_rte"));
        $this->tipo_est_parc_descr->SetDBValue($this->f("tipo_est_parc_descr"));
        $this->Link_Edit->SetDBValue($this->f("parcela_partida"));
        $this->parcela_val_mejora->SetDBValue($this->f("parcela_val_mejora"));
        $this->parcela_val_ampliac->SetDBValue($this->f("parcela_val_ampliac"));
        $this->parcela_val_total->SetDBValue($this->f("parcela_val_total"));
        $this->parcela_id->SetDBValue($this->f("parcela_id"));
    }
//End SetValues Method

} //End parcelas_unidades_medidas1DataSource Class @37-FCB6E20C



class clsGridparcelas1 { //parcelas1 class @324-0E869545

//Variables @324-2BC4DDCA

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
    public $Sorter_parcela_seccion;
    public $Sorter_parcela_macizo;
    public $Sorter_parcela_parcela;
    public $Sorter_parcela_chacra;
    public $Sorter_parcela_quinta;
    public $Sorter_parcela_fraccion;
    public $Sorter_parcela_uf;
    public $Sorter_parcela_predio;
    public $Sorter_parcela_rte;
//End Variables

//Class_Initialize Event @324-0BACF8F1
    function clsGridparcelas1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas1DataSource($this);
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
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        $this->SorterName = CCGetParam("parcelas1Order", "");
        $this->SorterDirection = CCGetParam("parcelas1Dir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "recordParcela.php";
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_seccion = new clsSorter($this->ComponentName, "Sorter_parcela_seccion", $FileName, $this);
        $this->Sorter_parcela_macizo = new clsSorter($this->ComponentName, "Sorter_parcela_macizo", $FileName, $this);
        $this->Sorter_parcela_parcela = new clsSorter($this->ComponentName, "Sorter_parcela_parcela", $FileName, $this);
        $this->Sorter_parcela_chacra = new clsSorter($this->ComponentName, "Sorter_parcela_chacra", $FileName, $this);
        $this->Sorter_parcela_quinta = new clsSorter($this->ComponentName, "Sorter_parcela_quinta", $FileName, $this);
        $this->Sorter_parcela_fraccion = new clsSorter($this->ComponentName, "Sorter_parcela_fraccion", $FileName, $this);
        $this->Sorter_parcela_uf = new clsSorter($this->ComponentName, "Sorter_parcela_uf", $FileName, $this);
        $this->Sorter_parcela_predio = new clsSorter($this->ComponentName, "Sorter_parcela_predio", $FileName, $this);
        $this->Sorter_parcela_rte = new clsSorter($this->ComponentName, "Sorter_parcela_rte", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @324-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @324-51A7F87A
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
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->Link1->SetValue($this->DataSource->Link1->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_seccion->Show();
                $this->parcela_macizo->Show();
                $this->parcela_parcela->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->Link1->Show();
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
        $this->Sorter_parcela_seccion->Show();
        $this->Sorter_parcela_macizo->Show();
        $this->Sorter_parcela_parcela->Show();
        $this->Sorter_parcela_chacra->Show();
        $this->Sorter_parcela_quinta->Show();
        $this->Sorter_parcela_fraccion->Show();
        $this->Sorter_parcela_uf->Show();
        $this->Sorter_parcela_predio->Show();
        $this->Sorter_parcela_rte->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @324-DF3CAB9C
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas1 Class @324-FCB6E20C

class clsparcelas1DataSource extends clsDBtdf_nuevo {  //parcelas1DataSource Class @324-E4E477A5

//DataSource Variables @324-E25EB6EE
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
    public $parcela_macizo;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $Link1;
//End DataSource Variables

//DataSourceClass_Initialize Event @324-98A6AE34
    function clsparcelas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas1";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @324-07CD1310
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_seccion" => array("parcela_seccion", ""), 
            "Sorter_parcela_macizo" => array("parcela_macizo", ""), 
            "Sorter_parcela_parcela" => array("parcela_parcela", ""), 
            "Sorter_parcela_chacra" => array("parcela_chacra", ""), 
            "Sorter_parcela_quinta" => array("parcela_quinta", ""), 
            "Sorter_parcela_fraccion" => array("parcela_fraccion", ""), 
            "Sorter_parcela_uf" => array("parcela_uf", ""), 
            "Sorter_parcela_predio" => array("parcela_predio", ""), 
            "Sorter_parcela_rte" => array("parcela_rte", "")));
    }
//End SetOrder Method

//Prepare Method @324-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @324-6E2C0151
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM parcelas";
        $this->SQL = "SELECT * \n\n" .
        "FROM parcelas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @324-4C2DA0A7
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->Link1->SetDBValue($this->f("parcela_partida"));
    }
//End SetValues Method

} //End parcelas1DataSource Class @324-FCB6E20C

//Include Page implementation @414-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @415-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @416-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordpadrones_parcelas_parcela { //padrones_parcelas_parcela Class @5-F3F45EC7

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

//Class_Initialize Event @5-8173B3FF
    function clsRecordpadrones_parcelas_parcela($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record padrones_parcelas_parcela/Error";
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "padrones_parcelas_parcela";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
            $this->parcela_predio = new clsControl(ccsTextBox, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", $Method, NULL), $this);
            $this->parcela_rte = new clsControl(ccsTextBox, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", $Method, NULL), $this);
            $this->tipo_est_parc_id = new clsControl(ccsListBox, "tipo_est_parc_id", "tipo_est_parc_id", ccsInteger, "", CCGetRequestParam("tipo_est_parc_id", $Method, NULL), $this);
            $this->tipo_est_parc_id->DSType = dsTable;
            $this->tipo_est_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_est_parc_id->ds = & $this->tipo_est_parc_id->DataSource;
            $this->tipo_est_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_est_parc_id->BoundColumn, $this->tipo_est_parc_id->TextColumn, $this->tipo_est_parc_id->DBFormat) = array("tipo_est_parc_id", "tipo_est_parc_descr", "");
            $this->tipo_parcela_uso_id = new clsControl(ccsListBox, "tipo_parcela_uso_id", "tipo_parcela_uso_id", ccsInteger, "", CCGetRequestParam("tipo_parcela_uso_id", $Method, NULL), $this);
            $this->tipo_parcela_uso_id->DSType = dsTable;
            $this->tipo_parcela_uso_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_parcela_uso_id->ds = & $this->tipo_parcela_uso_id->DataSource;
            $this->tipo_parcela_uso_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas_usos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_parcela_uso_id->BoundColumn, $this->tipo_parcela_uso_id->TextColumn, $this->tipo_parcela_uso_id->DBFormat) = array("tipo_parcela_uso_id", "tipo_parcela_uso_descrip", "");
            $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "tipo_instrumento_id", ccsInteger, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
            $this->tipo_instrumento_id->DSType = dsTable;
            $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
            $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_abrev", "");
            $this->parcela_instrumento = new clsControl(ccsTextBox, "parcela_instrumento", "parcela_instrumento", ccsText, "", CCGetRequestParam("parcela_instrumento", $Method, NULL), $this);
            $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
            $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
            $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "tipo_padron_parc_id", ccsInteger, "", CCGetRequestParam("tipo_padron_parc_id", $Method, NULL), $this);
            $this->tipo_padron_parc_id->DSType = dsTable;
            $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
            $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "tipo_depto_parc_id", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->part_val = new clsControl(ccsCheckBox, "part_val", "part_val", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("part_val", $Method, NULL), $this);
            $this->part_val->CheckedValue = true;
            $this->part_val->UncheckedValue = false;
            $this->parcela_partida = new clsControl(ccsTextBox, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", $Method, NULL), $this);
            $this->sup_min = new clsControl(ccsTextBox, "sup_min", "sup_min", ccsText, "", CCGetRequestParam("sup_min", $Method, NULL), $this);
            $this->sup_max = new clsControl(ccsTextBox, "sup_max", "sup_max", ccsText, "", CCGetRequestParam("sup_max", $Method, NULL), $this);
            $this->unidades_medidas_id = new clsControl(ccsListBox, "unidades_medidas_id", "unidades_medidas_id", ccsInteger, "", CCGetRequestParam("unidades_medidas_id", $Method, NULL), $this);
            $this->unidades_medidas_id->DSType = dsTable;
            $this->unidades_medidas_id->DataSource = new clsDBtdf_nuevo();
            $this->unidades_medidas_id->ds = & $this->unidades_medidas_id->DataSource;
            $this->unidades_medidas_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_medidas {SQL_Where} {SQL_OrderBy}";
            list($this->unidades_medidas_id->BoundColumn, $this->unidades_medidas_id->TextColumn, $this->unidades_medidas_id->DBFormat) = array("unidades_medidas_id", "unidades_medidas_abrev", "");
            $this->tipo_parcela_id = new clsControl(ccsListBox, "tipo_parcela_id", "tipo_parcela_id", ccsInteger, "", CCGetRequestParam("tipo_parcela_id", $Method, NULL), $this);
            $this->tipo_parcela_id->DSType = dsTable;
            $this->tipo_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_parcela_id->ds = & $this->tipo_parcela_id->DataSource;
            $this->tipo_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_parcelas {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_parcela_id->BoundColumn, $this->tipo_parcela_id->TextColumn, $this->tipo_parcela_id->DBFormat) = array("tipo_parcela_id", "tipo_parcela_descrip", "");
            $this->tipo_restricc_parcela_id = new clsControl(ccsListBox, "tipo_restricc_parcela_id", "tipo_restricc_parcela_id", ccsText, "", CCGetRequestParam("tipo_restricc_parcela_id", $Method, NULL), $this);
            $this->tipo_restricc_parcela_id->DSType = dsTable;
            $this->tipo_restricc_parcela_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_restricc_parcela_id->ds = & $this->tipo_restricc_parcela_id->DataSource;
            $this->tipo_restricc_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_restricc_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_restricc_parcela_id->BoundColumn, $this->tipo_restricc_parcela_id->TextColumn, $this->tipo_restricc_parcela_id->DBFormat) = array("tipo_restricc_parcela_id", "tipo_restricc_parcela_desc", "");
            $this->pasop = new clsControl(ccsHidden, "pasop", "pasop", ccsText, "", CCGetRequestParam("pasop", $Method, NULL), $this);
            $this->parcela_observa = new clsControl(ccsTextArea, "parcela_observa", "parcela_observa", ccsText, "", CCGetRequestParam("parcela_observa", $Method, NULL), $this);
            $this->s_persona_denominacion = new clsControl(ccsTextBox, "s_persona_denominacion", "s_persona_denominacion", ccsText, "", CCGetRequestParam("s_persona_denominacion", $Method, NULL), $this);
            $this->s_tipo_persona_id = new clsControl(ccsListBox, "s_tipo_persona_id", "s_tipo_persona_id", ccsText, "", CCGetRequestParam("s_tipo_persona_id", $Method, NULL), $this);
            $this->s_tipo_persona_id->DSType = dsTable;
            $this->s_tipo_persona_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_persona_id->ds = & $this->s_tipo_persona_id->DataSource;
            $this->s_tipo_persona_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_persona_id->BoundColumn, $this->s_tipo_persona_id->TextColumn, $this->s_tipo_persona_id->DBFormat) = array("tipo_persona_id", "tipo_persona_descrip", "");
            $this->s_tipo_documento_id = new clsControl(ccsListBox, "s_tipo_documento_id", "s_tipo_documento_id", ccsText, "", CCGetRequestParam("s_tipo_documento_id", $Method, NULL), $this);
            $this->s_tipo_documento_id->DSType = dsTable;
            $this->s_tipo_documento_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_documento_id->ds = & $this->s_tipo_documento_id->DataSource;
            $this->s_tipo_documento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_documento_id->BoundColumn, $this->s_tipo_documento_id->TextColumn, $this->s_tipo_documento_id->DBFormat) = array("tipo_documento_id", "tipo_documento_descrip", "");
            $this->s_persona_nro_doc = new clsControl(ccsTextBox, "s_persona_nro_doc", "s_persona_nro_doc", ccsInteger, "", CCGetRequestParam("s_persona_nro_doc", $Method, NULL), $this);
            $this->s_persona_cuit = new clsControl(ccsTextBox, "s_persona_cuit", "s_persona_cuit", ccsText, "", CCGetRequestParam("s_persona_cuit", $Method, NULL), $this);
            $this->s_persona_parcela_num_int = new clsControl(ccsTextBox, "s_persona_parcela_num_int", "s_persona_parcela_num_int", ccsText, "", CCGetRequestParam("s_persona_parcela_num_int", $Method, NULL), $this);
            $this->s_tipo_instrumento_id = new clsControl(ccsListBox, "s_tipo_instrumento_id", "s_tipo_instrumento_id", ccsText, "", CCGetRequestParam("s_tipo_instrumento_id", $Method, NULL), $this);
            $this->s_tipo_instrumento_id->DSType = dsTable;
            $this->s_tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_instrumento_id->ds = & $this->s_tipo_instrumento_id->DataSource;
            $this->s_tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_instrumento_id->BoundColumn, $this->s_tipo_instrumento_id->TextColumn, $this->s_tipo_instrumento_id->DBFormat) = array("", "", "");
            $this->s_persona_conyuge = new clsControl(ccsTextBox, "s_persona_conyuge", "s_persona_conyuge", ccsText, "", CCGetRequestParam("s_persona_conyuge", $Method, NULL), $this);
            $this->s_plano_nro = new clsControl(ccsTextBox, "s_plano_nro", "s_plano_nro", ccsInteger, "", CCGetRequestParam("s_plano_nro", $Method, NULL), $this);
            $this->s_plano_e_nro = new clsControl(ccsTextBox, "s_plano_e_nro", "s_plano_e_nro", ccsInteger, "", CCGetRequestParam("s_plano_e_nro", $Method, NULL), $this);
            $this->s_plano_ano = new clsControl(ccsTextBox, "s_plano_ano", "s_plano_ano", ccsInteger, "", CCGetRequestParam("s_plano_ano", $Method, NULL), $this);
            $this->s_plano_profesional = new clsControl(ccsListBox, "s_plano_profesional", "s_plano_profesional", ccsInteger, "", CCGetRequestParam("s_plano_profesional", $Method, NULL), $this);
            $this->s_plano_profesional->DSType = dsTable;
            $this->s_plano_profesional->DataSource = new clsDBtdf_nuevo();
            $this->s_plano_profesional->ds = & $this->s_plano_profesional->DataSource;
            $this->s_plano_profesional->DataSource->SQL = "SELECT * \n" .
"FROM profesionales {SQL_Where} {SQL_OrderBy}";
            $this->s_plano_profesional->DataSource->Order = "prof_nombre";
            list($this->s_plano_profesional->BoundColumn, $this->s_plano_profesional->TextColumn, $this->s_plano_profesional->DBFormat) = array("prof_id", "prof_nombre", "");
            $this->s_plano_profesional->DataSource->Order = "prof_nombre";
            $this->s_plano_e_letra = new clsControl(ccsTextBox, "s_plano_e_letra", "s_plano_e_letra", ccsText, "", CCGetRequestParam("s_plano_e_letra", $Method, NULL), $this);
            $this->s_tipo_estado_plano_id = new clsControl(ccsListBox, "s_tipo_estado_plano_id", "s_tipo_estado_plano_id", ccsText, "", CCGetRequestParam("s_tipo_estado_plano_id", $Method, NULL), $this);
            $this->s_tipo_estado_plano_id->DSType = dsTable;
            $this->s_tipo_estado_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_estado_plano_id->ds = & $this->s_tipo_estado_plano_id->DataSource;
            $this->s_tipo_estado_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_estado_plano_id->BoundColumn, $this->s_tipo_estado_plano_id->TextColumn, $this->s_tipo_estado_plano_id->DBFormat) = array("tipo_estado_plano_id", "tipo_estado_plano_desc", "");
            $this->s_plano_e_ano = new clsControl(ccsTextBox, "s_plano_e_ano", "s_plano_e_ano", ccsText, "", CCGetRequestParam("s_plano_e_ano", $Method, NULL), $this);
            $this->s_tipo_plano_id = new clsControl(ccsListBox, "s_tipo_plano_id", "s_tipo_plano_id", ccsText, "", CCGetRequestParam("s_tipo_plano_id", $Method, NULL), $this);
            $this->s_tipo_plano_id->DSType = dsTable;
            $this->s_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_plano_id->ds = & $this->s_tipo_plano_id->DataSource;
            $this->s_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_plano_id->BoundColumn, $this->s_tipo_plano_id->TextColumn, $this->s_tipo_plano_id->DBFormat) = array("tipo_plano_id", "tipo_plano_desc", "");
            $this->s_planos_depto = new clsControl(ccsListBox, "s_planos_depto", "s_planos_depto", ccsInteger, "", CCGetRequestParam("s_planos_depto", $Method, NULL), $this);
            $this->s_planos_depto->DSType = dsTable;
            $this->s_planos_depto->DataSource = new clsDBtdf_nuevo();
            $this->s_planos_depto->ds = & $this->s_planos_depto->DataSource;
            $this->s_planos_depto->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_planos_depto->BoundColumn, $this->s_planos_depto->TextColumn, $this->s_planos_depto->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
            $this->cancel = new clsButton("cancel", $Method, $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->alta_pura = new clsButton("alta_pura", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_est_parc_id->Value) && !strlen($this->tipo_est_parc_id->Value) && $this->tipo_est_parc_id->Value !== false)
                    $this->tipo_est_parc_id->SetText(1);
                if(!is_array($this->part_val->Value) && !strlen($this->part_val->Value) && $this->part_val->Value !== false)
                    $this->part_val->SetValue(true);
                if(!is_array($this->pasop->Value) && !strlen($this->pasop->Value) && $this->pasop->Value !== false)
                    $this->pasop->SetText(parcela);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @5-80AF299D
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->parcela_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_uf->Validate() && $Validation);
        $Validation = ($this->parcela_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_predio->Validate() && $Validation);
        $Validation = ($this->parcela_rte->Validate() && $Validation);
        $Validation = ($this->tipo_est_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_uso_id->Validate() && $Validation);
        $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->parcela_instrumento->Validate() && $Validation);
        $Validation = ($this->parcela_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_seccion->Validate() && $Validation);
        $Validation = ($this->tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->part_val->Validate() && $Validation);
        $Validation = ($this->parcela_partida->Validate() && $Validation);
        $Validation = ($this->sup_min->Validate() && $Validation);
        $Validation = ($this->sup_max->Validate() && $Validation);
        $Validation = ($this->unidades_medidas_id->Validate() && $Validation);
        $Validation = ($this->tipo_parcela_id->Validate() && $Validation);
        $Validation = ($this->tipo_restricc_parcela_id->Validate() && $Validation);
        $Validation = ($this->pasop->Validate() && $Validation);
        $Validation = ($this->parcela_observa->Validate() && $Validation);
        $Validation = ($this->s_persona_denominacion->Validate() && $Validation);
        $Validation = ($this->s_tipo_persona_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_documento_id->Validate() && $Validation);
        $Validation = ($this->s_persona_nro_doc->Validate() && $Validation);
        $Validation = ($this->s_persona_cuit->Validate() && $Validation);
        $Validation = ($this->s_persona_parcela_num_int->Validate() && $Validation);
        $Validation = ($this->s_tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->s_persona_conyuge->Validate() && $Validation);
        $Validation = ($this->s_plano_nro->Validate() && $Validation);
        $Validation = ($this->s_plano_e_nro->Validate() && $Validation);
        $Validation = ($this->s_plano_ano->Validate() && $Validation);
        $Validation = ($this->s_plano_profesional->Validate() && $Validation);
        $Validation = ($this->s_plano_e_letra->Validate() && $Validation);
        $Validation = ($this->s_tipo_estado_plano_id->Validate() && $Validation);
        $Validation = ($this->s_plano_e_ano->Validate() && $Validation);
        $Validation = ($this->s_tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->s_planos_depto->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_predio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_rte->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_est_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_uso_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_instrumento->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->part_val->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_min->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_max->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidades_medidas_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_restricc_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pasop->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_observa->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_persona_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_documento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_nro_doc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_cuit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_parcela_num_int->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_persona_conyuge->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_e_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_ano->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_profesional->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_e_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_estado_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plano_e_ano->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_planos_depto->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-0B2F9BBE
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->parcela_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_uf->Errors->Count());
        $errors = ($errors || $this->parcela_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_predio->Errors->Count());
        $errors = ($errors || $this->parcela_rte->Errors->Count());
        $errors = ($errors || $this->tipo_est_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_uso_id->Errors->Count());
        $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->parcela_instrumento->Errors->Count());
        $errors = ($errors || $this->parcela_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_seccion->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->part_val->Errors->Count());
        $errors = ($errors || $this->parcela_partida->Errors->Count());
        $errors = ($errors || $this->sup_min->Errors->Count());
        $errors = ($errors || $this->sup_max->Errors->Count());
        $errors = ($errors || $this->unidades_medidas_id->Errors->Count());
        $errors = ($errors || $this->tipo_parcela_id->Errors->Count());
        $errors = ($errors || $this->tipo_restricc_parcela_id->Errors->Count());
        $errors = ($errors || $this->pasop->Errors->Count());
        $errors = ($errors || $this->parcela_observa->Errors->Count());
        $errors = ($errors || $this->s_persona_denominacion->Errors->Count());
        $errors = ($errors || $this->s_tipo_persona_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_documento_id->Errors->Count());
        $errors = ($errors || $this->s_persona_nro_doc->Errors->Count());
        $errors = ($errors || $this->s_persona_cuit->Errors->Count());
        $errors = ($errors || $this->s_persona_parcela_num_int->Errors->Count());
        $errors = ($errors || $this->s_tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->s_persona_conyuge->Errors->Count());
        $errors = ($errors || $this->s_plano_nro->Errors->Count());
        $errors = ($errors || $this->s_plano_e_nro->Errors->Count());
        $errors = ($errors || $this->s_plano_ano->Errors->Count());
        $errors = ($errors || $this->s_plano_profesional->Errors->Count());
        $errors = ($errors || $this->s_plano_e_letra->Errors->Count());
        $errors = ($errors || $this->s_tipo_estado_plano_id->Errors->Count());
        $errors = ($errors || $this->s_plano_e_ano->Errors->Count());
        $errors = ($errors || $this->s_tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->s_planos_depto->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
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

//Operation Method @5-B5BCA497
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
            if($this->cancel->Pressed) {
                $this->PressedButton = "cancel";
            } else if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            } else if($this->alta_pura->Pressed) {
                $this->PressedButton = "alta_pura";
            }
        }
        $Redirect = $FileName;
        if($this->PressedButton == "cancel") {
            if(!CCGetEvent($this->cancel->CCSEvents, "OnClick", $this->cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "alta_pura") {
            if(!CCGetEvent($this->alta_pura->CCSEvents, "OnClick", $this->alta_pura)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("cancel", "cancel_x", "cancel_y", "Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "alta_pura", "alta_pura_x", "alta_pura_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @5-072BEDC6
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

        $this->tipo_est_parc_id->Prepare();
        $this->tipo_parcela_uso_id->Prepare();
        $this->tipo_instrumento_id->Prepare();
        $this->tipo_padron_parc_id->Prepare();
        $this->tipo_depto_parc_id->Prepare();
        $this->unidades_medidas_id->Prepare();
        $this->tipo_parcela_id->Prepare();
        $this->tipo_restricc_parcela_id->Prepare();
        $this->s_tipo_persona_id->Prepare();
        $this->s_tipo_documento_id->Prepare();
        $this->s_tipo_instrumento_id->Prepare();
        $this->s_plano_profesional->Prepare();
        $this->s_tipo_estado_plano_id->Prepare();
        $this->s_tipo_plano_id->Prepare();
        $this->s_planos_depto->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_predio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_rte->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_est_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_uso_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_instrumento->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->part_val->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_min->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_max->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidades_medidas_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_restricc_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pasop->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_observa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_persona_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_documento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_nro_doc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_cuit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_parcela_num_int->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_persona_conyuge->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_e_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_ano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_profesional->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_e_letra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_estado_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plano_e_ano->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_planos_depto->Errors->ToString());
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

        $this->parcela_parcela->Show();
        $this->parcela_quinta->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_uf->Show();
        $this->parcela_macizo->Show();
        $this->parcela_predio->Show();
        $this->parcela_rte->Show();
        $this->tipo_est_parc_id->Show();
        $this->tipo_parcela_uso_id->Show();
        $this->tipo_instrumento_id->Show();
        $this->parcela_instrumento->Show();
        $this->parcela_chacra->Show();
        $this->parcela_seccion->Show();
        $this->tipo_padron_parc_id->Show();
        $this->tipo_depto_parc_id->Show();
        $this->part_val->Show();
        $this->parcela_partida->Show();
        $this->sup_min->Show();
        $this->sup_max->Show();
        $this->unidades_medidas_id->Show();
        $this->tipo_parcela_id->Show();
        $this->tipo_restricc_parcela_id->Show();
        $this->pasop->Show();
        $this->parcela_observa->Show();
        $this->s_persona_denominacion->Show();
        $this->s_tipo_persona_id->Show();
        $this->s_tipo_documento_id->Show();
        $this->s_persona_nro_doc->Show();
        $this->s_persona_cuit->Show();
        $this->s_persona_parcela_num_int->Show();
        $this->s_tipo_instrumento_id->Show();
        $this->s_persona_conyuge->Show();
        $this->s_plano_nro->Show();
        $this->s_plano_e_nro->Show();
        $this->s_plano_ano->Show();
        $this->s_plano_profesional->Show();
        $this->s_plano_e_letra->Show();
        $this->s_tipo_estado_plano_id->Show();
        $this->s_plano_e_ano->Show();
        $this->s_tipo_plano_id->Show();
        $this->s_planos_depto->Show();
        $this->cancel->Show();
        $this->Button_DoSearch->Show();
        $this->alta_pura->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End padrones_parcelas_parcela Class @5-FCB6E20C



//Initialize Page @1-E832B0A1
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
$TemplateFileName = "gridParcelas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-AEED68BA
include_once("./gridParcelas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D94A846A
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$parcelas_unidades_medidas1 = new clsGridparcelas_unidades_medidas1("", $MainPage);
$parcelas1 = new clsGridparcelas1("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$Panel1 = new clsPanel("Panel1", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$padrones_parcelas_parcela = new clsRecordpadrones_parcelas_parcela("", $MainPage);
$MainPage->parcelas_unidades_medidas1 = & $parcelas_unidades_medidas1;
$MainPage->parcelas1 = & $parcelas1;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->Panel1 = & $Panel1;
$MainPage->Panel2 = & $Panel2;
$MainPage->padrones_parcelas_parcela = & $padrones_parcelas_parcela;
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("padrones_parcelas_parcela", $padrones_parcelas_parcela);
$parcelas_unidades_medidas1->Initialize();
$parcelas1->Initialize();

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

//Execute Components @1-B9FDB1E4
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$padrones_parcelas_parcela->Operation();
//End Execute Components

//Go to destination page @1-8A080E58
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($parcelas_unidades_medidas1);
    unset($parcelas1);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($padrones_parcelas_parcela);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7BC18E34
$parcelas_unidades_medidas1->Show();
$parcelas1->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$PQKIMAJ9C10Q7Q0J9R = ">retnec/<>tnof/<>llams/<.;111#&;501#&du;611#&;38#&>-- SCC --!< e;301#&rahCe;001#&;111#&C>-- SCC --!< ;401#&tiw>-- CCS --!< d;101#&ta;411#&e;011#&e;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($PQKIMAJ9C10Q7Q0J9R) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($PQKIMAJ9C10Q7Q0J9R) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($PQKIMAJ9C10Q7Q0J9R);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D6B134C2
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($parcelas_unidades_medidas1);
unset($parcelas1);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($padrones_parcelas_parcela);
unset($Tpl);
//End Unload Page


?>
