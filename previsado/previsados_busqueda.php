<?php
//Include Common Files @1-EB29AA36
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsados_busqueda.php");
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

class clsGridprevisados_cargas { //previsados_cargas class @4-9E0F350E

//Variables @4-4108C4E6

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
    public $Sorter_previsado_carga_proc;
    public $Sorter_user_id;
    public $Sorter_previsado_tipo_plano_id;
    public $Sorter_previsado_tipo_estado_carga_id;
//End Variables

//Class_Initialize Event @4-89CB0BFA
    function clsGridprevisados_cargas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_cargas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_cargas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_cargasDataSource($this);
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
        $this->SorterName = CCGetParam("previsados_cargasOrder", "");
        $this->SorterDirection = CCGetParam("previsados_cargasDir", "");

        $this->previsado_carga_proc = new clsControl(ccsLabel, "previsado_carga_proc", "previsado_carga_proc", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("previsado_carga_proc", ccsGet, NULL), $this);
        $this->prof_nombre = new clsControl(ccsLabel, "prof_nombre", "prof_nombre", ccsText, "", CCGetRequestParam("prof_nombre", ccsGet, NULL), $this);
        $this->previsado_tipo_plano_descrip = new clsControl(ccsLabel, "previsado_tipo_plano_descrip", "previsado_tipo_plano_descrip", ccsText, "", CCGetRequestParam("previsado_tipo_plano_descrip", ccsGet, NULL), $this);
        $this->previsado_tipo_estado_carga_descrip_html = new clsControl(ccsLabel, "previsado_tipo_estado_carga_descrip_html", "previsado_tipo_estado_carga_descrip_html", ccsText, "", CCGetRequestParam("previsado_tipo_estado_carga_descrip_html", ccsGet, NULL), $this);
        $this->previsado_tipo_estado_carga_descrip_html->HTML = true;
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "previsados_respuesta.php";
        $this->usuario_catastro = new clsControl(ccsLabel, "usuario_catastro", "usuario_catastro", ccsText, "", CCGetRequestParam("usuario_catastro", ccsGet, NULL), $this);
        $this->usuario_catastro->HTML = true;
        $this->titulares = new clsControl(ccsLabel, "titulares", "titulares", ccsText, "", CCGetRequestParam("titulares", ccsGet, NULL), $this);
        $this->titulares->HTML = true;
        $this->icono = new clsControl(ccsLabel, "icono", "icono", ccsText, "", CCGetRequestParam("icono", ccsGet, NULL), $this);
        $this->icono->HTML = true;
        $this->Sorter_previsado_carga_proc = new clsSorter($this->ComponentName, "Sorter_previsado_carga_proc", $FileName, $this);
        $this->Sorter_user_id = new clsSorter($this->ComponentName, "Sorter_user_id", $FileName, $this);
        $this->Sorter_previsado_tipo_plano_id = new clsSorter($this->ComponentName, "Sorter_previsado_tipo_plano_id", $FileName, $this);
        $this->Sorter_previsado_tipo_estado_carga_id = new clsSorter($this->ComponentName, "Sorter_previsado_tipo_estado_carga_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @4-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @4-FA40C690
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_user_id"] = CCGetFromGet("s_user_id", NULL);
        $this->DataSource->Parameters["urls_previsado_titular"] = CCGetFromGet("s_previsado_titular", NULL);
        $this->DataSource->Parameters["urls_previsado_tipo_plano_id"] = CCGetFromGet("s_previsado_tipo_plano_id", NULL);
        $this->DataSource->Parameters["urls_previsado_tipo_estado_carga_id"] = CCGetFromGet("s_previsado_tipo_estado_carga_id", NULL);
        $this->DataSource->Parameters["urls_tipo_depto_parc_id_o"] = CCGetFromGet("s_tipo_depto_parc_id_o", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion_o"] = CCGetFromGet("s_parcela_seccion_o", NULL);
        $this->DataSource->Parameters["urls_parcela_chacra_o"] = CCGetFromGet("s_parcela_chacra_o", NULL);
        $this->DataSource->Parameters["urls_parcela_quinta_o"] = CCGetFromGet("s_parcela_quinta_o", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo_o"] = CCGetFromGet("s_parcela_macizo_o", NULL);
        $this->DataSource->Parameters["urls_parcela_fraccion_o"] = CCGetFromGet("s_parcela_fraccion_o", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela_o"] = CCGetFromGet("s_parcela_parcela_o", NULL);
        $this->DataSource->Parameters["urls_parcela_uf_o"] = CCGetFromGet("s_parcela_uf_o", NULL);
        $this->DataSource->Parameters["urls_tipo_depto_parc_id_d"] = CCGetFromGet("s_tipo_depto_parc_id_d", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion_d"] = CCGetFromGet("s_parcela_seccion_d", NULL);
        $this->DataSource->Parameters["urls_parcela_chacra_d"] = CCGetFromGet("s_parcela_chacra_d", NULL);
        $this->DataSource->Parameters["urls_parcela_quinta_d"] = CCGetFromGet("s_parcela_quinta_d", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo_d"] = CCGetFromGet("s_parcela_macizo_d", NULL);
        $this->DataSource->Parameters["urls_parcela_fraccion_d"] = CCGetFromGet("s_parcela_fraccion_d", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela_d"] = CCGetFromGet("s_parcela_parcela_d", NULL);
        $this->DataSource->Parameters["urls_parcela_uf_d"] = CCGetFromGet("s_parcela_uf_d", NULL);
        $this->DataSource->Parameters["urls_previsado_carga_alta"] = CCGetFromGet("s_previsado_carga_alta", NULL);
        $this->DataSource->Parameters["urls_previsado_carga_cierre"] = CCGetFromGet("s_previsado_carga_cierre", NULL);

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
            $this->ControlsVisible["previsado_carga_proc"] = $this->previsado_carga_proc->Visible;
            $this->ControlsVisible["prof_nombre"] = $this->prof_nombre->Visible;
            $this->ControlsVisible["previsado_tipo_plano_descrip"] = $this->previsado_tipo_plano_descrip->Visible;
            $this->ControlsVisible["previsado_tipo_estado_carga_descrip_html"] = $this->previsado_tipo_estado_carga_descrip_html->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["usuario_catastro"] = $this->usuario_catastro->Visible;
            $this->ControlsVisible["titulares"] = $this->titulares->Visible;
            $this->ControlsVisible["icono"] = $this->icono->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_carga_proc->SetValue($this->DataSource->previsado_carga_proc->GetValue());
                $this->prof_nombre->SetValue($this->DataSource->prof_nombre->GetValue());
                $this->previsado_tipo_plano_descrip->SetValue($this->DataSource->previsado_tipo_plano_descrip->GetValue());
                $this->previsado_tipo_estado_carga_descrip_html->SetValue($this->DataSource->previsado_tipo_estado_carga_descrip_html->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("s_user_id", "s_previsado_nro_plano", "s_previsado_tipo_plano_id", "s_previsado_tipo_estado_carga_id", "ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "previsado_carga_id", $this->DataSource->f("previsado_carga_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_carga_proc->Show();
                $this->prof_nombre->Show();
                $this->previsado_tipo_plano_descrip->Show();
                $this->previsado_tipo_estado_carga_descrip_html->Show();
                $this->ImageLink1->Show();
                $this->usuario_catastro->Show();
                $this->titulares->Show();
                $this->icono->Show();
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
        $this->Sorter_previsado_carga_proc->Show();
        $this->Sorter_user_id->Show();
        $this->Sorter_previsado_tipo_plano_id->Show();
        $this->Sorter_previsado_tipo_estado_carga_id->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-AF731AC4
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_carga_proc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->prof_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_tipo_plano_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_tipo_estado_carga_descrip_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_catastro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->titulares->Errors->ToString());
        $errors = ComposeStrings($errors, $this->icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_cargas Class @4-FCB6E20C

class clsprevisados_cargasDataSource extends clsDBtdf_nuevo {  //previsados_cargasDataSource Class @4-D9184292

//DataSource Variables @4-2A0B3252
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_carga_proc;
    public $prof_nombre;
    public $previsado_tipo_plano_descrip;
    public $previsado_tipo_estado_carga_descrip_html;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-C78D6ABD
    function clsprevisados_cargasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_cargas";
        $this->Initialize();
        $this->previsado_carga_proc = new clsField("previsado_carga_proc", ccsDate, $this->DateFormat);
        
        $this->prof_nombre = new clsField("prof_nombre", ccsText, "");
        
        $this->previsado_tipo_plano_descrip = new clsField("previsado_tipo_plano_descrip", ccsText, "");
        
        $this->previsado_tipo_estado_carga_descrip_html = new clsField("previsado_tipo_estado_carga_descrip_html", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-E02648B9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "previsados_tipos_estados_cargas.previsado_tipo_estado_carga_orden, previsados_cargas.previsado_carga_proc desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_previsado_carga_proc" => array("previsado_carga_proc", ""), 
            "Sorter_user_id" => array("user_id", ""), 
            "Sorter_previsado_tipo_plano_id" => array("previsado_tipo_plano_id", ""), 
            "Sorter_previsado_tipo_estado_carga_id" => array("previsado_tipo_estado_carga_id", "")));
    }
//End SetOrder Method

//Prepare Method @4-D1B5A864
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_user_id", ccsInteger, "", "", $this->Parameters["urls_user_id"], "", false);
        $this->wp->AddParameter("2", "urls_previsado_titular", ccsText, "", "", $this->Parameters["urls_previsado_titular"], "", false);
        $this->wp->AddParameter("3", "urls_previsado_tipo_plano_id", ccsInteger, "", "", $this->Parameters["urls_previsado_tipo_plano_id"], "", false);
        $this->wp->AddParameter("4", "urls_previsado_tipo_estado_carga_id", ccsInteger, "", "", $this->Parameters["urls_previsado_tipo_estado_carga_id"], "", false);
        $this->wp->AddParameter("5", "urls_tipo_depto_parc_id_o", ccsInteger, "", "", $this->Parameters["urls_tipo_depto_parc_id_o"], "", false);
        $this->wp->AddParameter("6", "urls_parcela_seccion_o", ccsText, "", "", $this->Parameters["urls_parcela_seccion_o"], "", false);
        $this->wp->AddParameter("7", "urls_parcela_chacra_o", ccsText, "", "", $this->Parameters["urls_parcela_chacra_o"], "", false);
        $this->wp->AddParameter("8", "urls_parcela_quinta_o", ccsText, "", "", $this->Parameters["urls_parcela_quinta_o"], "", false);
        $this->wp->AddParameter("9", "urls_parcela_macizo_o", ccsText, "", "", $this->Parameters["urls_parcela_macizo_o"], "", false);
        $this->wp->AddParameter("10", "urls_parcela_fraccion_o", ccsText, "", "", $this->Parameters["urls_parcela_fraccion_o"], "", false);
        $this->wp->AddParameter("11", "urls_parcela_parcela_o", ccsText, "", "", $this->Parameters["urls_parcela_parcela_o"], "", false);
        $this->wp->AddParameter("12", "urls_parcela_uf_o", ccsText, "", "", $this->Parameters["urls_parcela_uf_o"], "", false);
        $this->wp->AddParameter("13", "urls_tipo_depto_parc_id_d", ccsInteger, "", "", $this->Parameters["urls_tipo_depto_parc_id_d"], "", false);
        $this->wp->AddParameter("14", "urls_parcela_seccion_d", ccsText, "", "", $this->Parameters["urls_parcela_seccion_d"], "", false);
        $this->wp->AddParameter("15", "urls_parcela_chacra_d", ccsText, "", "", $this->Parameters["urls_parcela_chacra_d"], "", false);
        $this->wp->AddParameter("16", "urls_parcela_quinta_d", ccsText, "", "", $this->Parameters["urls_parcela_quinta_d"], "", false);
        $this->wp->AddParameter("17", "urls_parcela_macizo_d", ccsText, "", "", $this->Parameters["urls_parcela_macizo_d"], "", false);
        $this->wp->AddParameter("18", "urls_parcela_fraccion_d", ccsText, "", "", $this->Parameters["urls_parcela_fraccion_d"], "", false);
        $this->wp->AddParameter("19", "urls_parcela_parcela_d", ccsText, "", "", $this->Parameters["urls_parcela_parcela_d"], "", false);
        $this->wp->AddParameter("20", "urls_parcela_uf_d", ccsText, "", "", $this->Parameters["urls_parcela_uf_d"], "", false);
        $this->wp->AddParameter("21", "urls_previsado_carga_alta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"), $this->Parameters["urls_previsado_carga_alta"], "", false);
        $this->wp->AddParameter("22", "urls_previsado_carga_cierre", ccsDate, array("dd", "/", "mm", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"), $this->Parameters["urls_previsado_carga_cierre"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsados_cargas.user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "previsados_titulares.previsado_titular_nombre", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "previsados_cargas.previsado_tipo_plano_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "previsados_cargas.previsado_tipo_estado_carga_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.tipo_depto_parc_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_seccion", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_chacra", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_quinta", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_macizo", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsText),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_fraccion", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opEqual, "previsados_parcelas_origenes.parcela_parcela", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
        $this->wp->Criterion[12] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_uf", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
        $this->wp->Criterion[13] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.tipo_depto_parc_id", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsInteger),false);
        $this->wp->Criterion[14] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_seccion", $this->wp->GetDBValue("14"), $this->ToSQL($this->wp->GetDBValue("14"), ccsText),false);
        $this->wp->Criterion[15] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_chacra", $this->wp->GetDBValue("15"), $this->ToSQL($this->wp->GetDBValue("15"), ccsText),false);
        $this->wp->Criterion[16] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_quinta", $this->wp->GetDBValue("16"), $this->ToSQL($this->wp->GetDBValue("16"), ccsText),false);
        $this->wp->Criterion[17] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_macizo", $this->wp->GetDBValue("17"), $this->ToSQL($this->wp->GetDBValue("17"), ccsText),false);
        $this->wp->Criterion[18] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_fraccion", $this->wp->GetDBValue("18"), $this->ToSQL($this->wp->GetDBValue("18"), ccsText),false);
        $this->wp->Criterion[19] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_parcela", $this->wp->GetDBValue("19"), $this->ToSQL($this->wp->GetDBValue("19"), ccsText),false);
        $this->wp->Criterion[20] = $this->wp->Operation(opEqual, "previsados_parcelas_destinos.parcela_uf", $this->wp->GetDBValue("20"), $this->ToSQL($this->wp->GetDBValue("20"), ccsText),false);
        $this->wp->Criterion[21] = $this->wp->Operation(opEqual, "previsados_cargas.previsado_carga_alta", $this->wp->GetDBValue("21"), $this->ToSQL($this->wp->GetDBValue("21"), ccsDate),false);
        $this->wp->Criterion[22] = $this->wp->Operation(opEqual, "previsados_cargas.previsado_carga_cierre", $this->wp->GetDBValue("22"), $this->ToSQL($this->wp->GetDBValue("22"), ccsDate),false);
        $this->wp->Criterion[23] = "( NOT ISNULL(previsados_cargas.previsado_tipo_estado_carga_id) )";
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
             $this->wp->Criterion[23]);
    }
//End Prepare Method

//Open Method @4-486000EC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT previsados_cargas.*, previsado_tipo_plano_descrip, previsado_tipo_estado_carga_descrip, prof_nombre, previsado_tipo_estado_carga_descrip_html,\n\n" .
        "previsado_tipo_estado_carga_orden, previsados_parcelas_destinos.tipo_depto_parc_id AS previsados_parcelas_destinos_tipo_depto_parc_id,\n\n" .
        "previsados_parcelas_destinos.parcela_seccion AS previsados_parcelas_destinos_parcela_seccion, previsados_parcelas_destinos.parcela_chacra AS previsados_parcelas_destinos_parcela_chacra,\n\n" .
        "previsados_parcelas_destinos.parcela_quinta AS previsados_parcelas_destinos_parcela_quinta, previsados_parcelas_destinos.parcela_fraccion AS previsados_parcelas_destinos_parcela_fraccion,\n\n" .
        "previsados_parcelas_destinos.parcela_macizo AS previsados_parcelas_destinos_parcela_macizo, previsados_parcelas_destinos.parcela_parcela AS previsados_parcelas_destinos_parcela_parcela,\n\n" .
        "previsados_parcelas_destinos.parcela_uf AS previsados_parcelas_destinos_parcela_uf, previsados_parcelas_origenes.tipo_depto_parc_id AS previsados_parcelas_origenes_tipo_depto_parc_id,\n\n" .
        "previsados_parcelas_origenes.parcela_seccion AS previsados_parcelas_origenes_parcela_seccion, previsados_parcelas_origenes.parcela_quinta AS previsados_parcelas_origenes_parcela_quinta,\n\n" .
        "previsados_parcelas_origenes.parcela_chacra AS previsados_parcelas_origenes_parcela_chacra, previsados_parcelas_origenes.parcela_macizo AS previsados_parcelas_origenes_parcela_macizo,\n\n" .
        "previsados_parcelas_origenes.parcela_fraccion AS previsados_parcelas_origenes_parcela_fraccion, previsados_parcelas_origenes.parcela_parcela AS previsados_parcelas_origenes_parcela_parcela,\n\n" .
        "previsados_parcelas_origenes.parcela_uf AS previsados_parcelas_origenes_parcela_uf, previsado_titular_nombre \n\n" .
        "FROM (((((previsados_cargas LEFT JOIN profesionales ON\n\n" .
        "previsados_cargas.user_id = profesionales.user_id) LEFT JOIN previsados_tipos_estados_cargas ON\n\n" .
        "previsados_cargas.previsado_tipo_estado_carga_id = previsados_tipos_estados_cargas.previsado_tipo_estado_carga_id) LEFT JOIN previsados_tipos_planos ON\n\n" .
        "previsados_cargas.previsado_tipo_plano_id = previsados_tipos_planos.previsado_tipo_plano_id) LEFT JOIN previsados_parcelas_destinos ON\n\n" .
        "previsados_cargas.previsado_carga_id = previsados_parcelas_destinos.previsado_carga_id) LEFT JOIN previsados_parcelas_origenes ON\n\n" .
        "previsados_cargas.previsado_carga_id = previsados_parcelas_origenes.previsado_carga_id) LEFT JOIN previsados_titulares ON\n\n" .
        "previsados_cargas.previsado_carga_id = previsados_titulares.previsado_carga_id {SQL_Where}\n\n" .
        "GROUP BY previsados_cargas.previsado_carga_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-CCEBC8ED
    function SetValues()
    {
        $this->previsado_carga_proc->SetDBValue(trim($this->f("previsado_carga_alta")));
        $this->prof_nombre->SetDBValue($this->f("prof_nombre"));
        $this->previsado_tipo_plano_descrip->SetDBValue($this->f("previsado_tipo_plano_descrip"));
        $this->previsado_tipo_estado_carga_descrip_html->SetDBValue($this->f("previsado_tipo_estado_carga_descrip_html"));
    }
//End SetValues Method

} //End previsados_cargasDataSource Class @4-FCB6E20C

class clsRecordprevisados_cargasSearch { //previsados_cargasSearch Class @5-CE037FB3

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

//Class_Initialize Event @5-A01D8937
    function clsRecordprevisados_cargasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record previsados_cargasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "previsados_cargasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_previsado_titular = new clsControl(ccsTextBox, "s_previsado_titular", "s_previsado_titular", ccsText, "", CCGetRequestParam("s_previsado_titular", $Method, NULL), $this);
            $this->Button_limpiar = new clsButton("Button_limpiar", $Method, $this);
            $this->s_previsado_tipo_plano_id = new clsControl(ccsListBox, "s_previsado_tipo_plano_id", "s_previsado_tipo_plano_id", ccsInteger, "", CCGetRequestParam("s_previsado_tipo_plano_id", $Method, NULL), $this);
            $this->s_previsado_tipo_plano_id->DSType = dsTable;
            $this->s_previsado_tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->s_previsado_tipo_plano_id->ds = & $this->s_previsado_tipo_plano_id->DataSource;
            $this->s_previsado_tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM previsados_tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->s_previsado_tipo_plano_id->BoundColumn, $this->s_previsado_tipo_plano_id->TextColumn, $this->s_previsado_tipo_plano_id->DBFormat) = array("previsado_tipo_plano_id", "previsado_tipo_plano_descrip", "");
            $this->s_tipo_depto_parc_id_o = new clsControl(ccsListBox, "s_tipo_depto_parc_id_o", "s_tipo_depto_parc_id_o", ccsInteger, "", CCGetRequestParam("s_tipo_depto_parc_id_o", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id_o->DSType = dsTable;
            $this->s_tipo_depto_parc_id_o->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_depto_parc_id_o->ds = & $this->s_tipo_depto_parc_id_o->DataSource;
            $this->s_tipo_depto_parc_id_o->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_depto_parc_id_o->BoundColumn, $this->s_tipo_depto_parc_id_o->TextColumn, $this->s_tipo_depto_parc_id_o->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_abrev", "");
            $this->s_parcela_seccion_o = new clsControl(ccsTextBox, "s_parcela_seccion_o", "s_parcela_seccion_o", ccsText, "", CCGetRequestParam("s_parcela_seccion_o", $Method, NULL), $this);
            $this->s_parcela_chacra_o = new clsControl(ccsTextBox, "s_parcela_chacra_o", "s_parcela_chacra_o", ccsText, "", CCGetRequestParam("s_parcela_chacra_o", $Method, NULL), $this);
            $this->s_parcela_quinta_o = new clsControl(ccsTextBox, "s_parcela_quinta_o", "s_parcela_quinta_o", ccsText, "", CCGetRequestParam("s_parcela_quinta_o", $Method, NULL), $this);
            $this->s_parcela_macizo_o = new clsControl(ccsTextBox, "s_parcela_macizo_o", "s_parcela_macizo_o", ccsText, "", CCGetRequestParam("s_parcela_macizo_o", $Method, NULL), $this);
            $this->s_parcela_fraccion_o = new clsControl(ccsTextBox, "s_parcela_fraccion_o", "s_parcela_fraccion_o", ccsText, "", CCGetRequestParam("s_parcela_fraccion_o", $Method, NULL), $this);
            $this->s_parcela_parcela_o = new clsControl(ccsTextBox, "s_parcela_parcela_o", "s_parcela_parcela_o", ccsText, "", CCGetRequestParam("s_parcela_parcela_o", $Method, NULL), $this);
            $this->s_parcela_uf_o = new clsControl(ccsTextBox, "s_parcela_uf_o", "s_parcela_uf_o", ccsText, "", CCGetRequestParam("s_parcela_uf_o", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id_d = new clsControl(ccsListBox, "s_tipo_depto_parc_id_d", "s_tipo_depto_parc_id_d", ccsInteger, "", CCGetRequestParam("s_tipo_depto_parc_id_d", $Method, NULL), $this);
            $this->s_tipo_depto_parc_id_d->DSType = dsTable;
            $this->s_tipo_depto_parc_id_d->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_depto_parc_id_d->ds = & $this->s_tipo_depto_parc_id_d->DataSource;
            $this->s_tipo_depto_parc_id_d->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_depto_parc_id_d->BoundColumn, $this->s_tipo_depto_parc_id_d->TextColumn, $this->s_tipo_depto_parc_id_d->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_abrev", "");
            $this->s_parcela_seccion_d = new clsControl(ccsTextBox, "s_parcela_seccion_d", "s_parcela_seccion_d", ccsText, "", CCGetRequestParam("s_parcela_seccion_d", $Method, NULL), $this);
            $this->s_parcela_chacra_d = new clsControl(ccsTextBox, "s_parcela_chacra_d", "s_parcela_chacra_d", ccsText, "", CCGetRequestParam("s_parcela_chacra_d", $Method, NULL), $this);
            $this->s_parcela_quinta_d = new clsControl(ccsTextBox, "s_parcela_quinta_d", "s_parcela_quinta_d", ccsText, "", CCGetRequestParam("s_parcela_quinta_d", $Method, NULL), $this);
            $this->s_parcela_macizo_d = new clsControl(ccsTextBox, "s_parcela_macizo_d", "s_parcela_macizo_d", ccsText, "", CCGetRequestParam("s_parcela_macizo_d", $Method, NULL), $this);
            $this->s_parcela_fraccion_d = new clsControl(ccsTextBox, "s_parcela_fraccion_d", "s_parcela_fraccion_d", ccsText, "", CCGetRequestParam("s_parcela_fraccion_d", $Method, NULL), $this);
            $this->s_parcela_parcela_d = new clsControl(ccsTextBox, "s_parcela_parcela_d", "s_parcela_parcela_d", ccsText, "", CCGetRequestParam("s_parcela_parcela_d", $Method, NULL), $this);
            $this->s_parcela_uf_d = new clsControl(ccsTextBox, "s_parcela_uf_d", "s_parcela_uf_d", ccsText, "", CCGetRequestParam("s_parcela_uf_d", $Method, NULL), $this);
            $this->s_previsado_tipo_estado_carga_id = new clsControl(ccsListBox, "s_previsado_tipo_estado_carga_id", "s_previsado_tipo_estado_carga_id", ccsInteger, "", CCGetRequestParam("s_previsado_tipo_estado_carga_id", $Method, NULL), $this);
            $this->s_previsado_tipo_estado_carga_id->DSType = dsTable;
            $this->s_previsado_tipo_estado_carga_id->DataSource = new clsDBtdf_nuevo();
            $this->s_previsado_tipo_estado_carga_id->ds = & $this->s_previsado_tipo_estado_carga_id->DataSource;
            $this->s_previsado_tipo_estado_carga_id->DataSource->SQL = "SELECT * \n" .
"FROM previsados_tipos_estados_cargas {SQL_Where} {SQL_OrderBy}";
            $this->s_previsado_tipo_estado_carga_id->DataSource->Order = "previsado_tipo_estado_carga_orden";
            list($this->s_previsado_tipo_estado_carga_id->BoundColumn, $this->s_previsado_tipo_estado_carga_id->TextColumn, $this->s_previsado_tipo_estado_carga_id->DBFormat) = array("previsado_tipo_estado_carga_id", "previsado_tipo_estado_carga_descrip", "");
            $this->s_previsado_tipo_estado_carga_id->DataSource->Order = "previsado_tipo_estado_carga_orden";
            $this->s_previsado_carga_alta = new clsControl(ccsTextBox, "s_previsado_carga_alta", "s_previsado_carga_alta", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("s_previsado_carga_alta", $Method, NULL), $this);
            $this->s_previsado_carga_cierre = new clsControl(ccsTextBox, "s_previsado_carga_cierre", "s_previsado_carga_cierre", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("s_previsado_carga_cierre", $Method, NULL), $this);
            $this->DatePicker_s_previsado_carga_alta1 = new clsDatePicker("DatePicker_s_previsado_carga_alta1", "previsados_cargasSearch", "s_previsado_carga_alta", $this);
            $this->DatePicker_s_previsado_carga_cierre1 = new clsDatePicker("DatePicker_s_previsado_carga_cierre1", "previsados_cargasSearch", "s_previsado_carga_cierre", $this);
            $this->s_user_id = new clsControl(ccsListBox, "s_user_id", "s_user_id", ccsInteger, "", CCGetRequestParam("s_user_id", $Method, NULL), $this);
            $this->s_user_id->DSType = dsTable;
            $this->s_user_id->DataSource = new clsDBtdf_nuevo();
            $this->s_user_id->ds = & $this->s_user_id->DataSource;
            $this->s_user_id->DataSource->SQL = "SELECT * \n" .
"FROM profesionales {SQL_Where} {SQL_OrderBy}";
            list($this->s_user_id->BoundColumn, $this->s_user_id->TextColumn, $this->s_user_id->DBFormat) = array("prof_id", "prof_nombre", "");
        }
    }
//End Class_Initialize Event

//Validate Method @5-4AD9F816
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_previsado_titular->Validate() && $Validation);
        $Validation = ($this->s_previsado_tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_depto_parc_id_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela_o->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf_o->Validate() && $Validation);
        $Validation = ($this->s_tipo_depto_parc_id_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela_d->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf_d->Validate() && $Validation);
        $Validation = ($this->s_previsado_tipo_estado_carga_id->Validate() && $Validation);
        $Validation = ($this->s_previsado_carga_alta->Validate() && $Validation);
        $Validation = ($this->s_previsado_carga_cierre->Validate() && $Validation);
        $Validation = ($this->s_user_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_previsado_titular->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_depto_parc_id_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf_o->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_depto_parc_id_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf_d->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_tipo_estado_carga_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_carga_alta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_previsado_carga_cierre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_user_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-3B7BC0A2
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_previsado_titular->Errors->Count());
        $errors = ($errors || $this->s_previsado_tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_depto_parc_id_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela_o->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf_o->Errors->Count());
        $errors = ($errors || $this->s_tipo_depto_parc_id_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela_d->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf_d->Errors->Count());
        $errors = ($errors || $this->s_previsado_tipo_estado_carga_id->Errors->Count());
        $errors = ($errors || $this->s_previsado_carga_alta->Errors->Count());
        $errors = ($errors || $this->s_previsado_carga_cierre->Errors->Count());
        $errors = ($errors || $this->DatePicker_s_previsado_carga_alta1->Errors->Count());
        $errors = ($errors || $this->DatePicker_s_previsado_carga_cierre1->Errors->Count());
        $errors = ($errors || $this->s_user_id->Errors->Count());
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

//Operation Method @5-DC29D075
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
            } else if($this->Button_limpiar->Pressed) {
                $this->PressedButton = "Button_limpiar";
            }
        }
        $Redirect = "previsados_busqueda.php";
        if($this->PressedButton == "Button_limpiar") {
            if(!CCGetEvent($this->Button_limpiar->CCSEvents, "OnClick", $this->Button_limpiar)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "previsados_busqueda.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_limpiar", "Button_limpiar_x", "Button_limpiar_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @5-CC823611
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

        $this->s_previsado_tipo_plano_id->Prepare();
        $this->s_tipo_depto_parc_id_o->Prepare();
        $this->s_tipo_depto_parc_id_d->Prepare();
        $this->s_previsado_tipo_estado_carga_id->Prepare();
        $this->s_user_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_previsado_titular->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_depto_parc_id_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf_o->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_depto_parc_id_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf_d->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_tipo_estado_carga_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_carga_alta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_previsado_carga_cierre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_s_previsado_carga_alta1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_s_previsado_carga_cierre1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_user_id->Errors->ToString());
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
        $this->s_previsado_titular->Show();
        $this->Button_limpiar->Show();
        $this->s_previsado_tipo_plano_id->Show();
        $this->s_tipo_depto_parc_id_o->Show();
        $this->s_parcela_seccion_o->Show();
        $this->s_parcela_chacra_o->Show();
        $this->s_parcela_quinta_o->Show();
        $this->s_parcela_macizo_o->Show();
        $this->s_parcela_fraccion_o->Show();
        $this->s_parcela_parcela_o->Show();
        $this->s_parcela_uf_o->Show();
        $this->s_tipo_depto_parc_id_d->Show();
        $this->s_parcela_seccion_d->Show();
        $this->s_parcela_chacra_d->Show();
        $this->s_parcela_quinta_d->Show();
        $this->s_parcela_macizo_d->Show();
        $this->s_parcela_fraccion_d->Show();
        $this->s_parcela_parcela_d->Show();
        $this->s_parcela_uf_d->Show();
        $this->s_previsado_tipo_estado_carga_id->Show();
        $this->s_previsado_carga_alta->Show();
        $this->s_previsado_carga_cierre->Show();
        $this->DatePicker_s_previsado_carga_alta1->Show();
        $this->DatePicker_s_previsado_carga_cierre1->Show();
        $this->s_user_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End previsados_cargasSearch Class @5-FCB6E20C

//Include Page implementation @64-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-52DBADF6
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
$TemplateFileName = "previsados_busqueda.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CBFD1E0E
CCSecurityRedirect("1;2", "../tdf_restricted.php");
//End Authenticate User

//Include events file @1-35DCB872
include_once("./previsados_busqueda_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-5A71A817
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$previsados_cargas = new clsGridprevisados_cargas("", $MainPage);
$previsados_cargasSearch = new clsRecordprevisados_cargasSearch("", $MainPage);
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->previsados_cargas = & $previsados_cargas;
$MainPage->previsados_cargasSearch = & $previsados_cargasSearch;
$MainPage->tdf_menu = & $tdf_menu;
$previsados_cargas->Initialize();

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

//Execute Components @1-00789BAE
$tdf_header->Operations();
$tdf_footer->Operations();
$previsados_cargasSearch->Operation();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-09D6136A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($previsados_cargas);
    unset($previsados_cargasSearch);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-2A94810A
$tdf_header->Show();
$tdf_footer->Show();
$previsados_cargas->Show();
$previsados_cargasSearch->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$OQJLSKJ7I2R6M = "<center><font face=\"Arial\"><small>Gen&#101;r&#97;t&#101;d <!-- SCC -->&#119;&#105;th <!-- CCS -->C&#111;&#100;&#101;Cha&#114;&#103;&#101; <!-- CCS -->&#83;t&#117;&#100;&#105;o.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $OQJLSKJ7I2R6M . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $OQJLSKJ7I2R6M . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $OQJLSKJ7I2R6M;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-985CB35F
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($previsados_cargas);
unset($previsados_cargasSearch);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
