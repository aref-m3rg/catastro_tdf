<?php
//Include Common Files @1-AE7E39C4
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "union5.php");
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

class clsGridparcelas_unidades_medidas1 { //parcelas_unidades_medidas1 class @37-62817F06

//Variables @37-181698BA

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
    public $Sorter_parcela_padron;
    public $Sorter_parcela_super_mensura;
    public $Sorter_parcela_avaluo;
//End Variables

//Class_Initialize Event @37-323F4A97
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
        $this->SorterName = CCGetParam("parcelas_unidades_medidas1Order", "");
        $this->SorterDirection = CCGetParam("parcelas_unidades_medidas1Dir", "");

        $this->editar = new clsControl(ccsImageLink, "editar", "editar", ccsText, "", CCGetRequestParam("editar", ccsGet, NULL), $this);
        $this->editar->Page = "union5.php";
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->n1 = new clsControl(ccsLabel, "n1", "n1", ccsText, "", CCGetRequestParam("n1", ccsGet, NULL), $this);
        $this->n2 = new clsControl(ccsLabel, "n2", "n2", ccsText, "", CCGetRequestParam("n2", ccsGet, NULL), $this);
        $this->n3 = new clsControl(ccsLabel, "n3", "n3", ccsText, "", CCGetRequestParam("n3", ccsGet, NULL), $this);
        $this->n4 = new clsControl(ccsLabel, "n4", "n4", ccsText, "", CCGetRequestParam("n4", ccsGet, NULL), $this);
        $this->n5 = new clsControl(ccsLabel, "n5", "n5", ccsText, "", CCGetRequestParam("n5", ccsGet, NULL), $this);
        $this->n6 = new clsControl(ccsLabel, "n6", "n6", ccsText, "", CCGetRequestParam("n6", ccsGet, NULL), $this);
        $this->n7 = new clsControl(ccsLabel, "n7", "n7", ccsText, "", CCGetRequestParam("n7", ccsGet, NULL), $this);
        $this->n8 = new clsControl(ccsLabel, "n8", "n8", ccsText, "", CCGetRequestParam("n8", ccsGet, NULL), $this);
        $this->n9 = new clsControl(ccsLabel, "n9", "n9", ccsText, "", CCGetRequestParam("n9", ccsGet, NULL), $this);
        $this->n10 = new clsControl(ccsLabel, "n10", "n10", ccsText, "", CCGetRequestParam("n10", ccsGet, NULL), $this);
        $this->n11 = new clsControl(ccsLabel, "n11", "n11", ccsText, "", CCGetRequestParam("n11", ccsGet, NULL), $this);
        $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsFloat, "", CCGetRequestParam("parcela_super_mensura", ccsGet, NULL), $this);
        $this->unidades_medidas_htm = new clsControl(ccsLabel, "unidades_medidas_htm", "unidades_medidas_htm", ccsText, "", CCGetRequestParam("unidades_medidas_htm", ccsGet, NULL), $this);
        $this->unidades_medidas_htm->HTML = true;
        $this->parcela_val_tierra = new clsControl(ccsLabel, "parcela_val_tierra", "parcela_val_tierra", ccsText, "", CCGetRequestParam("parcela_val_tierra", ccsGet, NULL), $this);
        $this->denominacion = new clsControl(ccsLabel, "denominacion", "denominacion", ccsText, "", CCGetRequestParam("denominacion", ccsGet, NULL), $this);
        $this->Sorter_parcela_padron = new clsSorter($this->ComponentName, "Sorter_parcela_padron", $FileName, $this);
        $this->Sorter_parcela_super_mensura = new clsSorter($this->ComponentName, "Sorter_parcela_super_mensura", $FileName, $this);
        $this->Sorter_parcela_avaluo = new clsSorter($this->ComponentName, "Sorter_parcela_avaluo", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @37-DA25BD11
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlparcela_partida"] = CCGetFromGet("parcela_partida", NULL);

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
            $this->ControlsVisible["editar"] = $this->editar->Visible;
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["n1"] = $this->n1->Visible;
            $this->ControlsVisible["n2"] = $this->n2->Visible;
            $this->ControlsVisible["n3"] = $this->n3->Visible;
            $this->ControlsVisible["n4"] = $this->n4->Visible;
            $this->ControlsVisible["n5"] = $this->n5->Visible;
            $this->ControlsVisible["n6"] = $this->n6->Visible;
            $this->ControlsVisible["n7"] = $this->n7->Visible;
            $this->ControlsVisible["n8"] = $this->n8->Visible;
            $this->ControlsVisible["n9"] = $this->n9->Visible;
            $this->ControlsVisible["n10"] = $this->n10->Visible;
            $this->ControlsVisible["n11"] = $this->n11->Visible;
            $this->ControlsVisible["parcela_super_mensura"] = $this->parcela_super_mensura->Visible;
            $this->ControlsVisible["unidades_medidas_htm"] = $this->unidades_medidas_htm->Visible;
            $this->ControlsVisible["parcela_val_tierra"] = $this->parcela_val_tierra->Visible;
            $this->ControlsVisible["denominacion"] = $this->denominacion->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->editar->Parameters = CCGetQueryString("QueryString", array("parcela_id_menos", "ccsForm"));
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "parcela_id_mas", $this->DataSource->f("parcela_id"));
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->n1->SetValue($this->DataSource->n1->GetValue());
                $this->n2->SetValue($this->DataSource->n2->GetValue());
                $this->n3->SetValue($this->DataSource->n3->GetValue());
                $this->n4->SetValue($this->DataSource->n4->GetValue());
                $this->n5->SetValue($this->DataSource->n5->GetValue());
                $this->n6->SetValue($this->DataSource->n6->GetValue());
                $this->n7->SetValue($this->DataSource->n7->GetValue());
                $this->n8->SetValue($this->DataSource->n8->GetValue());
                $this->n9->SetValue($this->DataSource->n9->GetValue());
                $this->n10->SetValue($this->DataSource->n10->GetValue());
                $this->n11->SetValue($this->DataSource->n11->GetValue());
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->unidades_medidas_htm->SetValue($this->DataSource->unidades_medidas_htm->GetValue());
                $this->parcela_val_tierra->SetValue($this->DataSource->parcela_val_tierra->GetValue());
                $this->denominacion->SetValue($this->DataSource->denominacion->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->editar->Show();
                $this->parcela_partida->Show();
                $this->n1->Show();
                $this->n2->Show();
                $this->n3->Show();
                $this->n4->Show();
                $this->n5->Show();
                $this->n6->Show();
                $this->n7->Show();
                $this->n8->Show();
                $this->n9->Show();
                $this->n10->Show();
                $this->n11->Show();
                $this->parcela_super_mensura->Show();
                $this->unidades_medidas_htm->Show();
                $this->parcela_val_tierra->Show();
                $this->denominacion->Show();
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
        $this->Sorter_parcela_padron->Show();
        $this->Sorter_parcela_super_mensura->Show();
        $this->Sorter_parcela_avaluo->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @37-77C0DCD7
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->editar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n5->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n6->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n7->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n8->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n9->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n10->Errors->ToString());
        $errors = ComposeStrings($errors, $this->n11->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_super_mensura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidades_medidas_htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_val_tierra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_unidades_medidas1 Class @37-FCB6E20C

class clsparcelas_unidades_medidas1DataSource extends clsDBtdf_nuevo {  //parcelas_unidades_medidas1DataSource Class @37-3D2DBE63

//DataSource Variables @37-5171927A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $n1;
    public $n2;
    public $n3;
    public $n4;
    public $n5;
    public $n6;
    public $n7;
    public $n8;
    public $n9;
    public $n10;
    public $n11;
    public $parcela_super_mensura;
    public $unidades_medidas_htm;
    public $parcela_val_tierra;
    public $denominacion;
//End DataSource Variables

//DataSourceClass_Initialize Event @37-7E813EB7
    function clsparcelas_unidades_medidas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_unidades_medidas1";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->n1 = new clsField("n1", ccsText, "");
        
        $this->n2 = new clsField("n2", ccsText, "");
        
        $this->n3 = new clsField("n3", ccsText, "");
        
        $this->n4 = new clsField("n4", ccsText, "");
        
        $this->n5 = new clsField("n5", ccsText, "");
        
        $this->n6 = new clsField("n6", ccsText, "");
        
        $this->n7 = new clsField("n7", ccsText, "");
        
        $this->n8 = new clsField("n8", ccsText, "");
        
        $this->n9 = new clsField("n9", ccsText, "");
        
        $this->n10 = new clsField("n10", ccsText, "");
        
        $this->n11 = new clsField("n11", ccsText, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsFloat, "");
        
        $this->unidades_medidas_htm = new clsField("unidades_medidas_htm", ccsText, "");
        
        $this->parcela_val_tierra = new clsField("parcela_val_tierra", ccsText, "");
        
        $this->denominacion = new clsField("denominacion", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @37-0249EAD4
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_partida desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_padron" => array("parcela_partida", ""), 
            "Sorter_parcela_super_mensura" => array("parcela_super_mensura", ""), 
            "Sorter_parcela_avaluo" => array("parcelas.parcela_avaluo", "")));
    }
//End SetOrder Method

//Prepare Method @37-0679C8FD
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_partida", ccsInteger, "", "", $this->Parameters["urlparcela_partida"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_partida", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @37-E8D8F925
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT unidades_medidas_htm, parcelas.parcela_super_mensura AS parcela_super_mensura, parcelas.parcela_id AS parcela_id, parcelas.parcela_seccion AS parcela_seccion,\n\n" .
        "parcelas.parcela_parcela AS parcela_parcela, persona_denominacion, parcela_partida, parcela_macizo, parcela_chacra, parcela_quinta,\n\n" .
        "parcela_fraccion, parcela_uf, parcela_predio, parcela_rte, parcela_val_tierra, parcela_val_mejora, parcela_val_ampliac,\n\n" .
        "parcela_val_total, tipo_depto_parc_abrev, tipo_padron_parc_abrev \n\n" .
        "FROM ((((parcelas LEFT JOIN personas_parcelas ON\n\n" .
        "personas_parcelas.parcela_id = parcelas.parcela_id) LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id) LEFT JOIN personas ON\n\n" .
        "personas.persona_id = personas_parcelas.persona_id {SQL_Where}\n\n" .
        "GROUP BY parcelas.tipo_depto_parc_id, parcelas.tipo_padron_parc_id, parcela_partida {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @37-32F58FAE
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->n1->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->n2->SetDBValue($this->f("tipo_padron_parc_abrev"));
        $this->n3->SetDBValue($this->f("parcela_seccion"));
        $this->n4->SetDBValue($this->f("parcela_chacra"));
        $this->n5->SetDBValue($this->f("parcela_quinta"));
        $this->n6->SetDBValue($this->f("parcela_macizo"));
        $this->n7->SetDBValue($this->f("parcela_fraccion"));
        $this->n8->SetDBValue($this->f("parcela_parcela"));
        $this->n9->SetDBValue($this->f("parcela_uf"));
        $this->n10->SetDBValue($this->f("parcela_predio"));
        $this->n11->SetDBValue($this->f("parcela_rte"));
        $this->parcela_super_mensura->SetDBValue(trim($this->f("parcela_super_mensura")));
        $this->unidades_medidas_htm->SetDBValue($this->f("unidades_medidas_htm"));
        $this->parcela_val_tierra->SetDBValue($this->f("parcela_val_tierra"));
        $this->denominacion->SetDBValue($this->f("persona_denominacion"));
    }
//End SetValues Method

} //End parcelas_unidades_medidas1DataSource Class @37-FCB6E20C

class clsRecordpadrones_parcelas_parcela { //padrones_parcelas_parcela Class @120-F3F45EC7

//Variables @120-9E315808

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

//Class_Initialize Event @120-AF52BBF9
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
        if($this->Visible)
        {
            $this->ComponentName = "padrones_parcelas_parcela";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
            $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
            $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
            $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
            $this->cancel = new clsButton("cancel", $Method, $this);
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
            $this->plano_nro = new clsControl(ccsTextBox, "plano_nro", "plano_nro", ccsText, "", CCGetRequestParam("plano_nro", $Method, NULL), $this);
            $this->plano_anio = new clsControl(ccsTextBox, "plano_anio", "plano_anio", ccsText, "", CCGetRequestParam("plano_anio", $Method, NULL), $this);
            $this->tipo_plano_id = new clsControl(ccsListBox, "tipo_plano_id", "tipo_plano_id", ccsInteger, "", CCGetRequestParam("tipo_plano_id", $Method, NULL), $this);
            $this->tipo_plano_id->DSType = dsTable;
            $this->tipo_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_plano_id->ds = & $this->tipo_plano_id->DataSource;
            $this->tipo_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_planos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_plano_id->BoundColumn, $this->tipo_plano_id->TextColumn, $this->tipo_plano_id->DBFormat) = array("tipo_plano_id", "tipo_plano_desc", "");
            $this->tipo_estado_plano_id = new clsControl(ccsListBox, "tipo_estado_plano_id", "tipo_estado_plano_id", ccsInteger, "", CCGetRequestParam("tipo_estado_plano_id", $Method, NULL), $this);
            $this->tipo_estado_plano_id->DSType = dsTable;
            $this->tipo_estado_plano_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_estado_plano_id->ds = & $this->tipo_estado_plano_id->DataSource;
            $this->tipo_estado_plano_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_planos {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_plano_id->BoundColumn, $this->tipo_estado_plano_id->TextColumn, $this->tipo_estado_plano_id->DBFormat) = array("tipo_estado_plano_id", "tipo_estado_plano_desc", "");
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
            $this->tipo_restricc_parcela_id = new clsControl(ccsListBox, "tipo_restricc_parcela_id", "tipo_restricc_parcela_id", ccsInteger, "", CCGetRequestParam("tipo_restricc_parcela_id", $Method, NULL), $this);
            $this->tipo_restricc_parcela_id->DSType = dsTable;
            $this->tipo_restricc_parcela_id->DataSource = new clsDBcatastro();
            $this->tipo_restricc_parcela_id->ds = & $this->tipo_restricc_parcela_id->DataSource;
            $this->tipo_restricc_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_restricc_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_restricc_parcela_id->BoundColumn, $this->tipo_restricc_parcela_id->TextColumn, $this->tipo_restricc_parcela_id->DBFormat) = array("tipo_restricc_parcela_id", "tipo_restricc_parcela_desc", "");
            $this->persona_denominacion = new clsControl(ccsTextBox, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", $Method, NULL), $this);
            $this->h1 = new clsControl(ccsHidden, "h1", "h1", ccsText, "", CCGetRequestParam("h1", $Method, NULL), $this);
            $this->h2 = new clsControl(ccsTextBox, "h2", "h2", ccsText, "", CCGetRequestParam("h2", $Method, NULL), $this);
            $this->Button2 = new clsButton("Button2", $Method, $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->tipo_est_parc_id->Value) && !strlen($this->tipo_est_parc_id->Value) && $this->tipo_est_parc_id->Value !== false)
                    $this->tipo_est_parc_id->SetText(1);
                if(!is_array($this->part_val->Value) && !strlen($this->part_val->Value) && $this->part_val->Value !== false)
                    $this->part_val->SetValue(true);
                if(!is_array($this->h1->Value) && !strlen($this->h1->Value) && $this->h1->Value !== false)
                    $this->h1->SetText(1);
                if(!is_array($this->h2->Value) && !strlen($this->h2->Value) && $this->h2->Value !== false)
                    $this->h2->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @120-090F6525
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
        $Validation = ($this->plano_nro->Validate() && $Validation);
        $Validation = ($this->plano_anio->Validate() && $Validation);
        $Validation = ($this->tipo_plano_id->Validate() && $Validation);
        $Validation = ($this->tipo_estado_plano_id->Validate() && $Validation);
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
        $Validation = ($this->persona_denominacion->Validate() && $Validation);
        $Validation = ($this->h1->Validate() && $Validation);
        $Validation = ($this->h2->Validate() && $Validation);
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
        $Validation =  $Validation && ($this->plano_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_plano_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_plano_id->Errors->Count() == 0);
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
        $Validation =  $Validation && ($this->persona_denominacion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->h1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->h2->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @120-DA43590E
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
        $errors = ($errors || $this->plano_nro->Errors->Count());
        $errors = ($errors || $this->plano_anio->Errors->Count());
        $errors = ($errors || $this->tipo_plano_id->Errors->Count());
        $errors = ($errors || $this->tipo_estado_plano_id->Errors->Count());
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
        $errors = ($errors || $this->persona_denominacion->Errors->Count());
        $errors = ($errors || $this->h1->Errors->Count());
        $errors = ($errors || $this->h2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @120-ED598703
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

//Operation Method @120-05920761
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
            } else if($this->cancel->Pressed) {
                $this->PressedButton = "cancel";
            } else if($this->Button2->Pressed) {
                $this->PressedButton = "Button2";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "cancel", "cancel_x", "cancel_y", "Button2", "Button2_x", "Button2_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "cancel") {
                if(!CCGetEvent($this->cancel->CCSEvents, "OnClick", $this->cancel)) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button2") {
                if(!CCGetEvent($this->Button2->CCSEvents, "OnClick", $this->Button2)) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button1") {
                if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @120-BFD0C2D1
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
        $this->tipo_plano_id->Prepare();
        $this->tipo_estado_plano_id->Prepare();
        $this->tipo_instrumento_id->Prepare();
        $this->tipo_padron_parc_id->Prepare();
        $this->tipo_depto_parc_id->Prepare();
        $this->unidades_medidas_id->Prepare();
        $this->tipo_parcela_id->Prepare();
        $this->tipo_restricc_parcela_id->Prepare();

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
            $Error = ComposeStrings($Error, $this->plano_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_anio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_plano_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_plano_id->Errors->ToString());
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
            $Error = ComposeStrings($Error, $this->persona_denominacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->h1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->h2->Errors->ToString());
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
        $this->parcela_parcela->Show();
        $this->parcela_quinta->Show();
        $this->parcela_fraccion->Show();
        $this->parcela_uf->Show();
        $this->cancel->Show();
        $this->parcela_macizo->Show();
        $this->parcela_predio->Show();
        $this->parcela_rte->Show();
        $this->tipo_est_parc_id->Show();
        $this->tipo_parcela_uso_id->Show();
        $this->plano_nro->Show();
        $this->plano_anio->Show();
        $this->tipo_plano_id->Show();
        $this->tipo_estado_plano_id->Show();
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
        $this->persona_denominacion->Show();
        $this->h1->Show();
        $this->h2->Show();
        $this->Button2->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End padrones_parcelas_parcela Class @120-FCB6E20C

class clsGridparcelas_tmp { //parcelas_tmp class @112-577B9E36

//Variables @112-10C8FD28

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
    public $Sorter_parcela_nomenclatura;
//End Variables

//Class_Initialize Event @112-3BE8EC73
    function clsGridparcelas_tmp($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_tmp";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_tmp";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_tmpDataSource($this);
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
        $this->SorterName = CCGetParam("parcelas_tmpOrder", "");
        $this->SorterDirection = CCGetParam("parcelas_tmpDir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_nomenclatura = new clsControl(ccsLabel, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", ccsGet, NULL), $this);
        $this->editar = new clsControl(ccsImageLink, "editar", "editar", ccsText, "", CCGetRequestParam("editar", ccsGet, NULL), $this);
        $this->editar->Page = "union5.php";
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_nomenclatura = new clsSorter($this->ComponentName, "Sorter_parcela_nomenclatura", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @112-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @112-80BAB037
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);

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
            $this->ControlsVisible["parcela_nomenclatura"] = $this->parcela_nomenclatura->Visible;
            $this->ControlsVisible["editar"] = $this->editar->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                $this->editar->Parameters = CCGetQueryString("QueryString", array("parcela_id_mas", "ccsForm"));
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "parcela_id_menos", $this->DataSource->f("parcela_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->parcela_nomenclatura->Show();
                $this->editar->Show();
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
        $this->Sorter_parcela_nomenclatura->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @112-777716F8
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_nomenclatura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->editar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_tmp Class @112-FCB6E20C

class clsparcelas_tmpDataSource extends clsDBtdf_nuevo {  //parcelas_tmpDataSource Class @112-1AB92E1D

//DataSource Variables @112-39371997
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $parcela_nomenclatura;
//End DataSource Variables

//DataSourceClass_Initialize Event @112-387DDBA5
    function clsparcelas_tmpDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_tmp";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @112-6F6EDCD9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_nomenclatura" => array("parcela_nomenclatura", "")));
    }
//End SetOrder Method

//Prepare Method @112-36B48386
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tmp.usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @112-8A19A27B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tmp INNER JOIN parcelas ON\n\n" .
        "tmp.tmp_parcela_id = parcelas.parcela_id";
        $this->SQL = "SELECT * \n\n" .
        "FROM tmp INNER JOIN parcelas ON\n\n" .
        "tmp.tmp_parcela_id = parcelas.parcela_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @112-DBE407AE
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
    }
//End SetValues Method

} //End parcelas_tmpDataSource Class @112-FCB6E20C

class clsGridmejoras_personas_tipos_do { //mejoras_personas_tipos_do class @318-22B72D68

//Variables @318-023811AD

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
    public $Sorter_mejora_sup_cub;
    public $Sorter_mejora_anio_construccion;
    public $Sorter_persona_denominacion;
    public $Sorter_parcela_partida;
//End Variables

//Class_Initialize Event @318-A5646B8D
    function clsGridmejoras_personas_tipos_do($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mejoras_personas_tipos_do";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mejoras_personas_tipos_do";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmejoras_personas_tipos_doDataSource($this);
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
        $this->SorterName = CCGetParam("mejoras_personas_tipos_doOrder", "");
        $this->SorterDirection = CCGetParam("mejoras_personas_tipos_doDir", "");

        $this->mejora_sup_cub = new clsControl(ccsLabel, "mejora_sup_cub", "mejora_sup_cub", ccsText, "", CCGetRequestParam("mejora_sup_cub", ccsGet, NULL), $this);
        $this->mejora_anio_construccion = new clsControl(ccsLabel, "mejora_anio_construccion", "mejora_anio_construccion", ccsInteger, "", CCGetRequestParam("mejora_anio_construccion", ccsGet, NULL), $this);
        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $this);
        $this->Sorter_mejora_sup_cub = new clsSorter($this->ComponentName, "Sorter_mejora_sup_cub", $FileName, $this);
        $this->Sorter_mejora_anio_construccion = new clsSorter($this->ComponentName, "Sorter_mejora_anio_construccion", $FileName, $this);
        $this->Sorter_persona_denominacion = new clsSorter($this->ComponentName, "Sorter_persona_denominacion", $FileName, $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @318-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @318-0AB72E7F
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);

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
            $this->ControlsVisible["mejora_sup_cub"] = $this->mejora_sup_cub->Visible;
            $this->ControlsVisible["mejora_anio_construccion"] = $this->mejora_anio_construccion->Visible;
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["Label1"] = $this->Label1->Visible;
            $this->ControlsVisible["Label2"] = $this->Label2->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->mejora_sup_cub->SetValue($this->DataSource->mejora_sup_cub->GetValue());
                $this->mejora_anio_construccion->SetValue($this->DataSource->mejora_anio_construccion->GetValue());
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->Label1->SetValue($this->DataSource->Label1->GetValue());
                $this->Label2->SetValue($this->DataSource->Label2->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mejora_sup_cub->Show();
                $this->mejora_anio_construccion->Show();
                $this->persona_denominacion->Show();
                $this->parcela_partida->Show();
                $this->Label1->Show();
                $this->Label2->Show();
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
        $this->Sorter_mejora_sup_cub->Show();
        $this->Sorter_mejora_anio_construccion->Show();
        $this->Sorter_persona_denominacion->Show();
        $this->Sorter_parcela_partida->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @318-10052FE2
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mejora_sup_cub->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejora_anio_construccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mejoras_personas_tipos_do Class @318-FCB6E20C

class clsmejoras_personas_tipos_doDataSource extends clsDBtdf_nuevo {  //mejoras_personas_tipos_doDataSource Class @318-7A922F91

//DataSource Variables @318-A60C90F4
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mejora_sup_cub;
    public $mejora_anio_construccion;
    public $persona_denominacion;
    public $parcela_partida;
    public $Label1;
    public $Label2;
//End DataSource Variables

//DataSourceClass_Initialize Event @318-AC3D479E
    function clsmejoras_personas_tipos_doDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mejoras_personas_tipos_do";
        $this->Initialize();
        $this->mejora_sup_cub = new clsField("mejora_sup_cub", ccsText, "");
        
        $this->mejora_anio_construccion = new clsField("mejora_anio_construccion", ccsInteger, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->Label1 = new clsField("Label1", ccsText, "");
        
        $this->Label2 = new clsField("Label2", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @318-20DD7522
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_partida, mejora_anio_construccion";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_mejora_sup_cub" => array("mejora_sup_cub", ""), 
            "Sorter_mejora_anio_construccion" => array("mejora_anio_construccion", ""), 
            "Sorter_persona_denominacion" => array("persona_denominacion", ""), 
            "Sorter_parcela_partida" => array("parcela_partida", "")));
    }
//End SetOrder Method

//Prepare Method @318-7006F395
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tmp2.usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @318-1ED04917
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((tmp2 LEFT JOIN tmp_mejoras ON\n\n" .
        "tmp_mejoras.tmp2_id = tmp2.tmp2_id) LEFT JOIN personas ON\n\n" .
        "tmp2.persona_id = personas.persona_id) LEFT JOIN mejoras ON\n\n" .
        "tmp_mejoras.mejora_id = mejoras.mejora_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id";
        $this->SQL = "SELECT tmp_mejoras.*, tipo_documento_descrip, persona_nro_doc, persona_denominacion, parcela_partida, mejora_nro_exp, mejora_letra_exp,\n\n" .
        "mejora_fecha_exp, mejora_anio_construccion, mejora_sup_cub, mejora_sup_semi_cub, concat(mejora_nro_exp,\"-\",mejora_letra_exp,\"-\",YEAR(mejora_fecha_exp)) AS Expr1,\n\n" .
        "concat(tipo_documento_abrev,\"-\",persona_nro_doc) AS Expr2 \n\n" .
        "FROM (((tmp2 LEFT JOIN tmp_mejoras ON\n\n" .
        "tmp_mejoras.tmp2_id = tmp2.tmp2_id) LEFT JOIN personas ON\n\n" .
        "tmp2.persona_id = personas.persona_id) LEFT JOIN mejoras ON\n\n" .
        "tmp_mejoras.mejora_id = mejoras.mejora_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @318-F0430993
    function SetValues()
    {
        $this->mejora_sup_cub->SetDBValue($this->f("mejora_sup_cub"));
        $this->mejora_anio_construccion->SetDBValue(trim($this->f("mejora_anio_construccion")));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->Label1->SetDBValue($this->f("Expr1"));
        $this->Label2->SetDBValue($this->f("Expr2"));
    }
//End SetValues Method

} //End mejoras_personas_tipos_doDataSource Class @318-FCB6E20C

class clsEditableGridtmp_mejoras { //tmp_mejoras Class @219-0B5362AB

//Variables @219-79C46721

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
    public $Sorter_tmp2_id;
    public $Sorter_mejora_id;
//End Variables

//Class_Initialize Event @219-05A6A90F
    function clsEditableGridtmp_mejoras($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tmp_mejoras/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tmp_mejoras";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["secuencia"][0] = "secuencia";
        $this->DataSource = new clstmp_mejorasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 0;
        $this->UpdateAllowed = true;
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

        $this->SorterName = CCGetParam("tmp_mejorasOrder", "");
        $this->SorterDirection = CCGetParam("tmp_mejorasDir", "");

        $this->Sorter_tmp2_id = new clsSorter($this->ComponentName, "Sorter_tmp2_id", $FileName, $this);
        $this->Sorter_mejora_id = new clsSorter($this->ComponentName, "Sorter_mejora_id", $FileName, $this);
        $this->tmp2_id = new clsControl(ccsListBox, "tmp2_id", "Partida", ccsInteger, "", NULL, $this);
        $this->tmp2_id->DSType = dsTable;
        $this->tmp2_id->DataSource = new clsDBtdf_nuevo();
        $this->tmp2_id->ds = & $this->tmp2_id->DataSource;
        $this->tmp2_id->DataSource->SQL = "SELECT persona_denominacion, tmp2_id, parcela_partida, concat(parcela_partida, \" - \", persona_denominacion) AS Expr1 \n" .
"FROM tmp2 INNER JOIN personas ON\n" .
"tmp2.persona_id = personas.persona_id {SQL_Where} {SQL_OrderBy}";
        list($this->tmp2_id->BoundColumn, $this->tmp2_id->TextColumn, $this->tmp2_id->DBFormat) = array("tmp2_id", "Expr1", "");
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->lmejora = new clsControl(ccsLabel, "lmejora", "lmejora", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @219-33BA221B
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @219-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @219-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @219-A4FDD7FB
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tmp2_id"][$RowNumber] = CCGetFromPost("tmp2_id_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @219-91375EDE
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["secuencia"] = $this->CachedColumns["secuencia"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tmp2_id->SetText($this->FormParameters["tmp2_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @219-587E9A87
    function ValidateRow()
    {
        global $CCSLocales;
        $this->tmp2_id->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tmp2_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->tmp2_id->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @219-04852C6D
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tmp2_id"][$this->RowNumber]) && count($this->FormParameters["tmp2_id"][$this->RowNumber])) || strlen($this->FormParameters["tmp2_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @219-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @219-909F269B
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

//UpdateGrid Method @219-340CAD54
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["secuencia"] = $this->CachedColumns["secuencia"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tmp2_id->SetText($this->FormParameters["tmp2_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
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

//UpdateRow Method @219-53BACB57
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tmp2_id->SetValue($this->tmp2_id->GetValue(true));
        $this->DataSource->Update();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End UpdateRow Method

//DeleteRow Method @219-A4A656F6
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

//FormScript Method @219-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @219-251974FC
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["secuencia"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["secuencia"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @219-C2691A6B
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["secuencia"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @219-E1C8EF9E
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->tmp2_id->Prepare();

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
        $this->ControlsVisible["tmp2_id"] = $this->tmp2_id->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["lmejora"] = $this->lmejora->Visible;
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
                    $this->CachedColumns["secuencia"][$this->RowNumber] = $this->DataSource->CachedColumns["secuencia"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->lmejora->SetText("");
                    $this->tmp2_id->SetValue($this->DataSource->tmp2_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->lmejora->SetText("");
                    $this->tmp2_id->SetText($this->FormParameters["tmp2_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["secuencia"][$this->RowNumber] = "";
                    $this->tmp2_id->SetText("");
                    $this->lmejora->SetText("");
                } else {
                    $this->lmejora->SetText("");
                    $this->tmp2_id->SetText($this->FormParameters["tmp2_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tmp2_id->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->lmejora->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["secuencia"] == $this->CachedColumns["secuencia"][$this->RowNumber])) {
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
        $this->Sorter_tmp2_id->Show();
        $this->Sorter_mejora_id->Show();
        $this->Navigator->Show();
        $this->Button_Submit->Show();

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

} //End tmp_mejoras Class @219-FCB6E20C

class clstmp_mejorasDataSource extends clsDBtdf_nuevo {  //tmp_mejorasDataSource Class @219-19371A61

//DataSource Variables @219-EC0D142D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $UpdateFields = array();

    // Datasource fields
    public $tmp2_id;
    public $CheckBox_Delete;
    public $lmejora;
//End DataSource Variables

//DataSourceClass_Initialize Event @219-5FB4FD83
    function clstmp_mejorasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tmp_mejoras/Error";
        $this->Initialize();
        $this->tmp2_id = new clsField("tmp2_id", ccsInteger, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->lmejora = new clsField("lmejora", ccsText, "");
        

        $this->UpdateFields["tmp2_id"] = array("Name" => "tmp2_id", "Value" => "", "DataType" => ccsInteger);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @219-CDDAAA22
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_tmp2_id" => array("tmp2_id", ""), 
            "Sorter_mejora_id" => array("mejora_id", "")));
    }
//End SetOrder Method

//Prepare Method @219-F5931BA1
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @219-7ED76814
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tmp_mejoras";
        $this->SQL = "SELECT * \n\n" .
        "FROM tmp_mejoras {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @219-82CDCDAE
    function SetValues()
    {
        $this->CachedColumns["secuencia"] = $this->f("secuencia");
        $this->tmp2_id->SetDBValue(trim($this->f("tmp2_id")));
    }
//End SetValues Method

//Update Method @219-C0460D3C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["tmp2_id"] = new clsSQLParameter("ctrltmp2_id", ccsInteger, "", "", $this->tmp2_id->GetValue(true), "", false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "sesUID", ccsInteger, "", "", CCGetSession("UID", NULL), "", true);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $wp->AddParameter("2", "dssecuencia", ccsInteger, "", "", $this->CachedColumns["secuencia"], "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["tmp2_id"]->GetValue()) and !strlen($this->cp["tmp2_id"]->GetText()) and !is_bool($this->cp["tmp2_id"]->GetValue())) 
            $this->cp["tmp2_id"]->SetValue($this->tmp2_id->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "usuario_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),true);
        $wp->Criterion[2] = $wp->Operation(opEqual, "secuencia", $wp->GetDBValue("2"), $this->ToSQL($wp->GetDBValue("2"), ccsInteger),false);
        $Where = $wp->opAND(
             false, 
             $wp->Criterion[1], 
             $wp->Criterion[2]);
        $this->UpdateFields["tmp2_id"]["Value"] = $this->cp["tmp2_id"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tmp_mejoras", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @219-A552E46E
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["UID"] = new clsSQLParameter("sesUID", ccsInteger, "", "", CCGetSession("UID", NULL), 0, false, $this->ErrorBlock);
        $this->cp["secuencia"] = new clsSQLParameter("dssecuencia", ccsInteger, "", "", $this->CachedColumns["secuencia"], 0, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        if (!is_null($this->cp["UID"]->GetValue()) and !strlen($this->cp["UID"]->GetText()) and !is_bool($this->cp["UID"]->GetValue())) 
            $this->cp["UID"]->SetValue(CCGetSession("UID", NULL));
        if (!strlen($this->cp["UID"]->GetText()) and !is_bool($this->cp["UID"]->GetValue(true))) 
            $this->cp["UID"]->SetText(0);
        if (!is_null($this->cp["secuencia"]->GetValue()) and !strlen($this->cp["secuencia"]->GetText()) and !is_bool($this->cp["secuencia"]->GetValue())) 
            $this->cp["secuencia"]->SetValue($this->CachedColumns["secuencia"]);
        if (!strlen($this->cp["secuencia"]->GetText()) and !is_bool($this->cp["secuencia"]->GetValue(true))) 
            $this->cp["secuencia"]->SetText(0);
        $this->SQL = "UPDATE tmp_mejoras SET secuencia = 999 WHERE  usuario_id = " . $this->SQLValue($this->cp["UID"]->GetDBValue(), ccsInteger) . " And secuencia = " . $this->SQLValue($this->cp["secuencia"]->GetDBValue(), ccsInteger) . "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End tmp_mejorasDataSource Class @219-FCB6E20C

class clsRecordNewRecord1 { //NewRecord1 Class @382-D7EDAFB1

//Variables @382-9E315808

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

//Class_Initialize Event @382-B3088279
    function clsRecordNewRecord1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record NewRecord1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "NewRecord1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @382-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @382-E8CE9E37
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @382-ED598703
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

//Operation Method @382-20CEF869
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
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @382-2FCC0DC8
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
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

        $this->Button_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End NewRecord1 Class @382-FCB6E20C

class clsGridpersonas_tipos_documentos { //personas_tipos_documentos class @388-71DDBE1C

//Variables @388-5BA6DE97

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
    public $Sorter_persona_denominacion;
    public $Sorter_cantidad;
//End Variables

//Class_Initialize Event @388-2A06CCF6
    function clsGridpersonas_tipos_documentos($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "personas_tipos_documentos";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid personas_tipos_documentos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspersonas_tipos_documentosDataSource($this);
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
        $this->SorterName = CCGetParam("personas_tipos_documentosOrder", "");
        $this->SorterDirection = CCGetParam("personas_tipos_documentosDir", "");

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->documento = new clsControl(ccsLabel, "documento", "documento", ccsText, "", CCGetRequestParam("documento", ccsGet, NULL), $this);
        $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
        $this->cantidad = new clsControl(ccsLabel, "cantidad", "cantidad", ccsInteger, "", CCGetRequestParam("cantidad", ccsGet, NULL), $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_persona_denominacion = new clsSorter($this->ComponentName, "Sorter_persona_denominacion", $FileName, $this);
        $this->Sorter_cantidad = new clsSorter($this->ComponentName, "Sorter_cantidad", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @388-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @388-4440C5F7
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);

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
            $this->ControlsVisible["documento"] = $this->documento->Visible;
            $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
            $this->ControlsVisible["cantidad"] = $this->cantidad->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->documento->SetValue($this->DataSource->documento->GetValue());
                $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
                $this->cantidad->SetValue($this->DataSource->cantidad->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show();
                $this->documento->Show();
                $this->persona_denominacion->Show();
                $this->cantidad->Show();
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
        $this->Sorter_persona_denominacion->Show();
        $this->Sorter_cantidad->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @388-3DA01694
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->documento->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->cantidad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End personas_tipos_documentos Class @388-FCB6E20C

class clspersonas_tipos_documentosDataSource extends clsDBtdf_nuevo {  //personas_tipos_documentosDataSource Class @388-1E55142F

//DataSource Variables @388-112FF6A3
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida;
    public $documento;
    public $persona_denominacion;
    public $cantidad;
//End DataSource Variables

//DataSourceClass_Initialize Event @388-64D5A8C8
    function clspersonas_tipos_documentosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid personas_tipos_documentos";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->documento = new clsField("documento", ccsText, "");
        
        $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
        
        $this->cantidad = new clsField("cantidad", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @388-71730A4B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tmp2.secuencia";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_persona_denominacion" => array("persona_denominacion", ""), 
            "Sorter_cantidad" => array("cantidad", "")));
    }
//End SetOrder Method

//Prepare Method @388-7006F395
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tmp2.usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @388-6E3A60B7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT count(tmp_mejoras.tmp_mejora_id) AS cantidad, tipo_documento_abrev, persona_nro_doc, persona_denominacion, parcela_partida,\n\n" .
        "tmp2.tmp2_id AS tmp2_tmp2_id, tmp2.secuencia AS tmp2_secuencia, concat(tipo_documento_abrev,\"-\",persona_nro_doc) AS documento \n\n" .
        "FROM ((tmp2 LEFT JOIN tmp_mejoras ON\n\n" .
        "tmp_mejoras.tmp2_id = tmp2.tmp2_id) LEFT JOIN personas ON\n\n" .
        "tmp2.persona_id = personas.persona_id) LEFT JOIN tipos_documentos ON\n\n" .
        "personas.tipo_documento_id = tipos_documentos.tipo_documento_id {SQL_Where}\n\n" .
        "GROUP BY tmp2.tmp2_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @388-8EB2B5EB
    function SetValues()
    {
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->documento->SetDBValue($this->f("documento"));
        $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
        $this->cantidad->SetDBValue(trim($this->f("cantidad")));
    }
//End SetValues Method

} //End personas_tipos_documentosDataSource Class @388-FCB6E20C

class clsGridparcelas_tmp_u_d { //parcelas_tmp_u_d class @433-F34B3F01

//Variables @433-0E58318A

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
//End Variables

//Class_Initialize Event @433-A2F762A5
    function clsGridparcelas_tmp_u_d($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_tmp_u_d";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_tmp_u_d";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_tmp_u_dDataSource($this);
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
        $this->SorterName = CCGetParam("parcelas_tmp_u_dOrder", "");
        $this->SorterDirection = CCGetParam("parcelas_tmp_u_dDir", "");

        $this->preparar_certificado = new clsControl(ccsImageLink, "preparar_certificado", "preparar_certificado", ccsText, "", CCGetRequestParam("preparar_certificado", ccsGet, NULL), $this);
        $this->preparar_certificado->Page = "rpt_nomenclatura.php";
        $this->editar = new clsControl(ccsImageLink, "editar", "editar", ccsText, "", CCGetRequestParam("editar", ccsGet, NULL), $this);
        $this->editar->Page = "recordParcela.php";
        $this->titularidad = new clsControl(ccsImageLink, "titularidad", "titularidad", ccsText, "", CCGetRequestParam("titularidad", ccsGet, NULL), $this);
        $this->titularidad->Page = "gridPersonas.php";
        $this->mejoras = new clsControl(ccsImageLink, "mejoras", "mejoras", ccsText, "", CCGetRequestParam("mejoras", ccsGet, NULL), $this);
        $this->mejoras->Page = "gridMejoras.php";
        $this->direcciones = new clsControl(ccsImageLink, "direcciones", "direcciones", ccsText, "", CCGetRequestParam("direcciones", ccsGet, NULL), $this);
        $this->direcciones->Page = "gridDirParcela.php";
        $this->certificado_parcela = new clsControl(ccsImageLink, "certificado_parcela", "certificado_parcela", ccsText, "", CCGetRequestParam("certificado_parcela", ccsGet, NULL), $this);
        $this->certificado_parcela->Page = "../reportes/rpt_nom_pdf.php";
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "../cartografia/cartografia.php";
        $this->parcela_partida1 = new clsControl(ccsLabel, "parcela_partida1", "parcela_partida1", ccsInteger, "", CCGetRequestParam("parcela_partida1", ccsGet, NULL), $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @433-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @433-FDF1370F
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);

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
            $this->ControlsVisible["preparar_certificado"] = $this->preparar_certificado->Visible;
            $this->ControlsVisible["editar"] = $this->editar->Visible;
            $this->ControlsVisible["titularidad"] = $this->titularidad->Visible;
            $this->ControlsVisible["mejoras"] = $this->mejoras->Visible;
            $this->ControlsVisible["direcciones"] = $this->direcciones->Visible;
            $this->ControlsVisible["certificado_parcela"] = $this->certificado_parcela->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["parcela_partida1"] = $this->parcela_partida1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->preparar_certificado->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->preparar_certificado->Parameters = CCAddParam($this->preparar_certificado->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->editar->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->editar->Parameters = CCAddParam($this->editar->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->titularidad->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->titularidad->Parameters = CCAddParam($this->titularidad->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->mejoras->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->mejoras->Parameters = CCAddParam($this->mejoras->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->direcciones->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->direcciones->Parameters = CCAddParam($this->direcciones->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->certificado_parcela->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "part_val", "tipo_est_parc_id", "tipo_parcela_uso_id", "tipo_depto_parc_id", "tipo_padron_parc_id", "parcela_seccion", "parcela_chacra=", "parcela_quinta=", "parcela_macizo", "parcela_fraccion", "parcela_parcela", "parcela_uf", "parcela_predio", "parcela_rte", "tipo_instrumento_id", "parcela_instrumento", "tipo_parcela_id", "sup_min", "sup_max", "unidades_medidas_id", "plano_nro", "plano_anio", "tipo_plano_id", "tipo_estado_plano_id", "persona_denominacion", "tipo_restricc_parcela_id", "parcela_chacra", "parcela_quinta", "ccsForm"));
                $this->certificado_parcela->Parameters = CCAddParam($this->certificado_parcela->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("parcelas_unidades_medidas1Order", "parcelas_unidades_medidas1Dir", "parcelas_unidades_medidas1Page", "ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_partida", $this->DataSource->f("parcela_partida"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "servicio", $this->DataSource->f("gis_srv_name"));
                $this->parcela_partida1->SetValue($this->DataSource->parcela_partida1->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->preparar_certificado->Show();
                $this->editar->Show();
                $this->titularidad->Show();
                $this->mejoras->Show();
                $this->direcciones->Show();
                $this->certificado_parcela->Show();
                $this->ImageLink1->Show();
                $this->parcela_partida1->Show();
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
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @433-249CB518
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->preparar_certificado->Errors->ToString());
        $errors = ComposeStrings($errors, $this->editar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->titularidad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->mejoras->Errors->ToString());
        $errors = ComposeStrings($errors, $this->direcciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->certificado_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_tmp_u_d Class @433-FCB6E20C

class clsparcelas_tmp_u_dDataSource extends clsDBtdf_nuevo {  //parcelas_tmp_u_dDataSource Class @433-2ED0B1E8

//DataSource Variables @433-AAB7A287
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_partida1;
//End DataSource Variables

//DataSourceClass_Initialize Event @433-8C8ED921
    function clsparcelas_tmp_u_dDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_tmp_u_d";
        $this->Initialize();
        $this->parcela_partida1 = new clsField("parcela_partida1", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @433-2EA2DE59
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", "")));
    }
//End SetOrder Method

//Prepare Method @433-28A95D24
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "tmp_u_d.usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @433-2307E0AB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT parcela_partida, parcela_id \n\n" .
        "FROM tmp_u_d INNER JOIN parcelas ON\n\n" .
        "tmp_u_d.tmp_u_d_parcela_id2 = parcelas.parcela_id {SQL_Where}\n\n" .
        "GROUP BY parcela_id {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @433-832136C2
    function SetValues()
    {
        $this->parcela_partida1->SetDBValue(trim($this->f("parcela_partida")));
    }
//End SetValues Method

} //End parcelas_tmp_u_dDataSource Class @433-FCB6E20C

class clsRecordNewRecord2 { //NewRecord2 Class @489-FCC0FC72

//Variables @489-9E315808

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

//Class_Initialize Event @489-812DFB64
    function clsRecordNewRecord2($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record NewRecord2/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "NewRecord2";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @489-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @489-E8CE9E37
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @489-ED598703
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

//Operation Method @489-DD94EE4C
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
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @489-25F37D65
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End NewRecord2 Class @489-FCB6E20C

class clsEditableGridtmp2 { //tmp2 Class @172-1A69B91E

//Variables @172-992A3ABD

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
    public $Sorter_parcela_partida;
    public $Sorter_persona_id;
//End Variables

//Class_Initialize Event @172-002A7FD9
    function clsEditableGridtmp2($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tmp2/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tmp2";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tmp2_id"][0] = "tmp2_id";
        $this->DataSource = new clstmp2DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 0;
        $this->UpdateAllowed = true;
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

        $this->SorterName = CCGetParam("tmp2Order", "");
        $this->SorterDirection = CCGetParam("tmp2Dir", "");

        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->parcela_partida = new clsControl(ccsTextBox, "parcela_partida", "Partida", ccsInteger, "", NULL, $this);
        $this->parcela_partida->Required = true;
        $this->persona_id = new clsControl(ccsListBox, "persona_id", "Titular principal", ccsInteger, "", NULL, $this);
        $this->persona_id->DSType = dsTable;
        $this->persona_id->DataSource = new clsDBtdf_nuevo();
        $this->persona_id->ds = & $this->persona_id->DataSource;
        $this->persona_id->DataSource->SQL = "SELECT personas.persona_id AS personas_persona_id, persona_denominacion \n" .
"FROM (personas_parcelas LEFT JOIN personas ON\n" .
"personas_parcelas.persona_id = personas.persona_id) RIGHT JOIN tmp ON\n" .
"tmp.tmp_parcela_id = personas_parcelas.parcela_id {SQL_Where} {SQL_OrderBy}";
        list($this->persona_id->BoundColumn, $this->persona_id->TextColumn, $this->persona_id->DBFormat) = array("personas_persona_id", "persona_denominacion", "");
        $this->persona_id->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);
        $this->persona_id->DataSource->wp = new clsSQLParameters();
        $this->persona_id->DataSource->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->persona_id->DataSource->Parameters["sesUID"], "", true);
        $this->persona_id->DataSource->wp->Criterion[1] = $this->persona_id->DataSource->wp->Operation(opEqual, "tmp.usuario_id", $this->persona_id->DataSource->wp->GetDBValue("1"), $this->persona_id->DataSource->ToSQL($this->persona_id->DataSource->wp->GetDBValue("1"), ccsInteger),true);
        $this->persona_id->DataSource->Where = 
             $this->persona_id->DataSource->wp->Criterion[1];
        $this->persona_id->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter_persona_id = new clsSorter($this->ComponentName, "Sorter_persona_id", $FileName, $this);
        $this->her = new clsControl(ccsHidden, "her", "her", ccsText, "", NULL, $this);
        $this->Button1 = new clsButton("Button1", $Method, $this);
        $this->persona_parcela_num_int = new clsControl(ccsTextBox, "persona_parcela_num_int", "Número de instrumento", ccsText, "", NULL, $this);
        $this->persona_parcela_num_int->Required = true;
        $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "Tipo de instrumento", ccsInteger, "", NULL, $this);
        $this->tipo_instrumento_id->DSType = dsTable;
        $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
        $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
        $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
        list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_abrev", "");
        $this->tipo_instrumento_id->Required = true;
        $this->tipos_personas_parcelas = new clsControl(ccsListBox, "tipos_personas_parcelas", "Figura", ccsText, "", NULL, $this);
        $this->tipos_personas_parcelas->DSType = dsTable;
        $this->tipos_personas_parcelas->DataSource = new clsDBtdf_nuevo();
        $this->tipos_personas_parcelas->ds = & $this->tipos_personas_parcelas->DataSource;
        $this->tipos_personas_parcelas->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_parcelas {SQL_Where} {SQL_OrderBy}";
        list($this->tipos_personas_parcelas->BoundColumn, $this->tipos_personas_parcelas->TextColumn, $this->tipos_personas_parcelas->DBFormat) = array("tipo_persona_parcela_id", "tipo_persona_parcela_abrev", "");
    }
//End Class_Initialize Event

//Initialize Method @172-33BA221B
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["sesUID"] = CCGetSession("UID", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @172-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @172-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @172-EB783DBE
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["parcela_partida"][$RowNumber] = CCGetFromPost("parcela_partida_" . $RowNumber, NULL);
            $this->FormParameters["persona_id"][$RowNumber] = CCGetFromPost("persona_id_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
            $this->FormParameters["persona_parcela_num_int"][$RowNumber] = CCGetFromPost("persona_parcela_num_int_" . $RowNumber, NULL);
            $this->FormParameters["tipo_instrumento_id"][$RowNumber] = CCGetFromPost("tipo_instrumento_id_" . $RowNumber, NULL);
            $this->FormParameters["tipos_personas_parcelas"][$RowNumber] = CCGetFromPost("tipos_personas_parcelas_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @172-F8E8E198
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tmp2_id"] = $this->CachedColumns["tmp2_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
            $this->persona_id->SetText($this->FormParameters["persona_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->persona_parcela_num_int->SetText($this->FormParameters["persona_parcela_num_int"][$this->RowNumber], $this->RowNumber);
            $this->tipo_instrumento_id->SetText($this->FormParameters["tipo_instrumento_id"][$this->RowNumber], $this->RowNumber);
            $this->tipos_personas_parcelas->SetText($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @172-99D93F96
    function ValidateRow()
    {
        global $CCSLocales;
        $this->parcela_partida->Validate();
        $this->persona_id->Validate();
        $this->CheckBox_Delete->Validate();
        $this->persona_parcela_num_int->Validate();
        $this->tipo_instrumento_id->Validate();
        $this->tipos_personas_parcelas->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $errors = ComposeStrings($errors, $this->persona_parcela_num_int->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_instrumento_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipos_personas_parcelas->Errors->ToString());
        $this->parcela_partida->Errors->Clear();
        $this->persona_id->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $this->persona_parcela_num_int->Errors->Clear();
        $this->tipo_instrumento_id->Errors->Clear();
        $this->tipos_personas_parcelas->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @172-9E7EA67D
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["parcela_partida"][$this->RowNumber]) && count($this->FormParameters["parcela_partida"][$this->RowNumber])) || strlen($this->FormParameters["parcela_partida"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["persona_id"][$this->RowNumber]) && count($this->FormParameters["persona_id"][$this->RowNumber])) || strlen($this->FormParameters["persona_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["persona_parcela_num_int"][$this->RowNumber]) && count($this->FormParameters["persona_parcela_num_int"][$this->RowNumber])) || strlen($this->FormParameters["persona_parcela_num_int"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_instrumento_id"][$this->RowNumber]) && count($this->FormParameters["tipo_instrumento_id"][$this->RowNumber])) || strlen($this->FormParameters["tipo_instrumento_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber]) && count($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber])) || strlen($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @172-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @172-F1039215
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
        $this->PressedButton = "Button1";
        if($this->Button1->Pressed) {
            $this->PressedButton = "Button1";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @172-D2FC6873
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tmp2_id"] = $this->CachedColumns["tmp2_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
            $this->persona_id->SetText($this->FormParameters["persona_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->persona_parcela_num_int->SetText($this->FormParameters["persona_parcela_num_int"][$this->RowNumber], $this->RowNumber);
            $this->tipo_instrumento_id->SetText($this->FormParameters["tipo_instrumento_id"][$this->RowNumber], $this->RowNumber);
            $this->tipos_personas_parcelas->SetText($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber], $this->RowNumber);
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

//UpdateRow Method @172-17701782
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->parcela_partida->SetValue($this->parcela_partida->GetValue(true));
        $this->DataSource->persona_id->SetValue($this->persona_id->GetValue(true));
        $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
        $this->DataSource->persona_parcela_num_int->SetValue($this->persona_parcela_num_int->GetValue(true));
        $this->DataSource->tipos_personas_parcelas->SetValue($this->tipos_personas_parcelas->GetValue(true));
        $this->DataSource->Update();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End UpdateRow Method

//DeleteRow Method @172-A4A656F6
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

//FormScript Method @172-18965D7A
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var tmp2Elements;\n";
        $script .= "var tmp2EmptyRows = 0;\n";
        $script .= "var " . $this->ComponentName . "parcela_partidaID = 0;\n";
        $script .= "var " . $this->ComponentName . "persona_idID = 1;\n";
        $script .= "var " . $this->ComponentName . "DeleteControl = 2;\n";
        $script .= "var " . $this->ComponentName . "persona_parcela_num_intID = 3;\n";
        $script .= "var " . $this->ComponentName . "tipo_instrumento_idID = 4;\n";
        $script .= "var " . $this->ComponentName . "tipos_personas_parcelasID = 5;\n";
        $script .= "\nfunction inittmp2Elements() {\n";
        $script .= "\tvar ED = document.forms[\"tmp2\"];\n";
        $script .= "\ttmp2Elements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.parcela_partida_" . $i . ", " . "ED.persona_id_" . $i . ", " . "ED.CheckBox_Delete_" . $i . ", " . "ED.persona_parcela_num_int_" . $i . ", " . "ED.tipo_instrumento_id_" . $i . ", " . "ED.tipos_personas_parcelas_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @172-9B780746
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tmp2_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tmp2_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @172-105CFD4D
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tmp2_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @172-87AEFB0C
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->persona_id->Prepare();
        $this->tipo_instrumento_id->Prepare();
        $this->tipos_personas_parcelas->Prepare();

        $this->DataSource->open();
        $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
        $this->IsEmpty = ! $is_next_record;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->Attributes->Show();
        $this->Button1->Visible = $this->Button1->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $this->RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
        $this->ControlsVisible["persona_id"] = $this->persona_id->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["persona_parcela_num_int"] = $this->persona_parcela_num_int->Visible;
        $this->ControlsVisible["tipo_instrumento_id"] = $this->tipo_instrumento_id->Visible;
        $this->ControlsVisible["tipos_personas_parcelas"] = $this->tipos_personas_parcelas->Visible;
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
                    $this->CachedColumns["tmp2_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tmp2_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->persona_id->SetValue($this->DataSource->persona_id->GetValue());
                    $this->persona_parcela_num_int->SetValue($this->DataSource->persona_parcela_num_int->GetValue());
                    $this->tipo_instrumento_id->SetValue($this->DataSource->tipo_instrumento_id->GetValue());
                    $this->tipos_personas_parcelas->SetValue($this->DataSource->tipos_personas_parcelas->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
                    $this->persona_id->SetText($this->FormParameters["persona_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->persona_parcela_num_int->SetText($this->FormParameters["persona_parcela_num_int"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_instrumento_id->SetText($this->FormParameters["tipo_instrumento_id"][$this->RowNumber], $this->RowNumber);
                    $this->tipos_personas_parcelas->SetText($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tmp2_id"][$this->RowNumber] = "";
                    $this->parcela_partida->SetText("");
                    $this->persona_id->SetText("");
                    $this->persona_parcela_num_int->SetText("");
                    $this->tipo_instrumento_id->SetText("");
                    $this->tipos_personas_parcelas->SetText("");
                } else {
                    $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
                    $this->persona_id->SetText($this->FormParameters["persona_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->persona_parcela_num_int->SetText($this->FormParameters["persona_parcela_num_int"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_instrumento_id->SetText($this->FormParameters["tipo_instrumento_id"][$this->RowNumber], $this->RowNumber);
                    $this->tipos_personas_parcelas->SetText($this->FormParameters["tipos_personas_parcelas"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show($this->RowNumber);
                $this->persona_id->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->persona_parcela_num_int->Show($this->RowNumber);
                $this->tipo_instrumento_id->Show($this->RowNumber);
                $this->tipos_personas_parcelas->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tmp2_id"] == $this->CachedColumns["tmp2_id"][$this->RowNumber])) {
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
        if(!is_array($this->her->Value) && !strlen($this->her->Value) && $this->her->Value !== false)
            $this->her->SetText(1);
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
        $this->Navigator->Show();
        $this->Sorter_persona_id->Show();
        $this->her->Show();
        $this->Button1->Show();

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

} //End tmp2 Class @172-FCB6E20C

class clstmp2DataSource extends clsDBtdf_nuevo {  //tmp2DataSource Class @172-E7F9C8F5

//DataSource Variables @172-6EF6284F
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $UpdateFields = array();

    // Datasource fields
    public $parcela_partida;
    public $persona_id;
    public $CheckBox_Delete;
    public $persona_parcela_num_int;
    public $tipo_instrumento_id;
    public $tipos_personas_parcelas;
//End DataSource Variables

//DataSourceClass_Initialize Event @172-F362CE4C
    function clstmp2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tmp2/Error";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->persona_id = new clsField("persona_id", ccsInteger, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->persona_parcela_num_int = new clsField("persona_parcela_num_int", ccsText, "");
        
        $this->tipo_instrumento_id = new clsField("tipo_instrumento_id", ccsInteger, "");
        
        $this->tipos_personas_parcelas = new clsField("tipos_personas_parcelas", ccsText, "");
        

        $this->UpdateFields["parcela_partida"] = array("Name" => "parcela_partida", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["persona_id"] = array("Name" => "persona_id", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["avance"] = array("Name" => "avance", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["persona_parcela_num_int"] = array("Name" => "persona_parcela_num_int", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_persona_parcela_id"] = array("Name" => "tipo_persona_parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @172-E07BED6B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "secuencia";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_persona_id" => array("persona_id", "")));
    }
//End SetOrder Method

//Prepare Method @172-F5931BA1
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUID", ccsInteger, "", "", $this->Parameters["sesUID"], "", true);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @172-5CFDC2C8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tmp2";
        $this->SQL = "SELECT * \n\n" .
        "FROM tmp2 {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @172-8C10088B
    function SetValues()
    {
        $this->CachedColumns["tmp2_id"] = $this->f("tmp2_id");
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->persona_id->SetDBValue(trim($this->f("persona_id")));
        $this->persona_parcela_num_int->SetDBValue($this->f("persona_parcela_num_int"));
        $this->tipo_instrumento_id->SetDBValue(trim($this->f("tipo_instrumento_id")));
        $this->tipos_personas_parcelas->SetDBValue($this->f("tipo_persona_parcela_id"));
    }
//End SetValues Method

//Update Method @172-616EFB72
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["parcela_partida"] = new clsSQLParameter("ctrlparcela_partida", ccsInteger, "", "", $this->parcela_partida->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["persona_id"] = new clsSQLParameter("ctrlpersona_id", ccsInteger, "", "", $this->persona_id->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["avance"] = new clsSQLParameter("expr218", ccsInteger, "", "", 3, NULL, false, $this->ErrorBlock);
        $this->cp["tipo_instrumento_id"] = new clsSQLParameter("ctrltipo_instrumento_id", ccsInteger, "", "", $this->tipo_instrumento_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["persona_parcela_num_int"] = new clsSQLParameter("ctrlpersona_parcela_num_int", ccsText, "", "", $this->persona_parcela_num_int->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_persona_parcela_id"] = new clsSQLParameter("ctrltipos_personas_parcelas", ccsInteger, "", "", $this->tipos_personas_parcelas->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "dstmp2_id", ccsInteger, "", "", $this->CachedColumns["tmp2_id"], "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["parcela_partida"]->GetValue()) and !strlen($this->cp["parcela_partida"]->GetText()) and !is_bool($this->cp["parcela_partida"]->GetValue())) 
            $this->cp["parcela_partida"]->SetValue($this->parcela_partida->GetValue(true));
        if (!is_null($this->cp["persona_id"]->GetValue()) and !strlen($this->cp["persona_id"]->GetText()) and !is_bool($this->cp["persona_id"]->GetValue())) 
            $this->cp["persona_id"]->SetValue($this->persona_id->GetValue(true));
        if (!is_null($this->cp["avance"]->GetValue()) and !strlen($this->cp["avance"]->GetText()) and !is_bool($this->cp["avance"]->GetValue())) 
            $this->cp["avance"]->SetValue(3);
        if (!is_null($this->cp["tipo_instrumento_id"]->GetValue()) and !strlen($this->cp["tipo_instrumento_id"]->GetText()) and !is_bool($this->cp["tipo_instrumento_id"]->GetValue())) 
            $this->cp["tipo_instrumento_id"]->SetValue($this->tipo_instrumento_id->GetValue(true));
        if (!is_null($this->cp["persona_parcela_num_int"]->GetValue()) and !strlen($this->cp["persona_parcela_num_int"]->GetText()) and !is_bool($this->cp["persona_parcela_num_int"]->GetValue())) 
            $this->cp["persona_parcela_num_int"]->SetValue($this->persona_parcela_num_int->GetValue(true));
        if (!is_null($this->cp["tipo_persona_parcela_id"]->GetValue()) and !strlen($this->cp["tipo_persona_parcela_id"]->GetText()) and !is_bool($this->cp["tipo_persona_parcela_id"]->GetValue())) 
            $this->cp["tipo_persona_parcela_id"]->SetValue($this->tipos_personas_parcelas->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "tmp2_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["parcela_partida"]["Value"] = $this->cp["parcela_partida"]->GetDBValue(true);
        $this->UpdateFields["persona_id"]["Value"] = $this->cp["persona_id"]->GetDBValue(true);
        $this->UpdateFields["avance"]["Value"] = $this->cp["avance"]->GetDBValue(true);
        $this->UpdateFields["tipo_instrumento_id"]["Value"] = $this->cp["tipo_instrumento_id"]->GetDBValue(true);
        $this->UpdateFields["persona_parcela_num_int"]["Value"] = $this->cp["persona_parcela_num_int"]->GetDBValue(true);
        $this->UpdateFields["tipo_persona_parcela_id"]["Value"] = $this->cp["tipo_persona_parcela_id"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tmp2", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @172-8A70120F
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "dstmp2_id", ccsInteger, "", "", $this->CachedColumns["tmp2_id"], "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $wp->Criterion[1] = $wp->Operation(opEqual, "tmp2_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->SQL = "DELETE FROM tmp2";
        $this->SQL = CCBuildSQL($this->SQL, $Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End tmp2DataSource Class @172-FCB6E20C

class clsRecordcantidad { //cantidad Class @131-DA3BF2FC

//Variables @131-9E315808

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

//Class_Initialize Event @131-D7332703
    function clsRecordcantidad($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record cantidad/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "cantidad";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->cantparce = new clsControl(ccsTextBox, "cantparce", "Cantidad", ccsText, "", CCGetRequestParam("cantparce", $Method, NULL), $this);
            $this->cantparce->Required = true;
            $this->ch = new clsControl(ccsCheckBox, "ch", "ch", ccsText, "", CCGetRequestParam("ch", $Method, NULL), $this);
            $this->ch->CheckedValue = $this->ch->GetParsedValue(si);
            $this->ch->UncheckedValue = $this->ch->GetParsedValue(no);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->Link1->Page = "BuscarPlano.php";
            $this->TextBox1 = new clsControl(ccsTextBox, "TextBox1", "TextBox1", ccsText, "", CCGetRequestParam("TextBox1", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @131-7CC1E7E2
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->cantparce->Validate() && $Validation);
        $Validation = ($this->ch->Validate() && $Validation);
        $Validation = ($this->TextBox1->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->cantparce->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ch->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextBox1->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @131-40A9B20B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->cantparce->Errors->Count());
        $errors = ($errors || $this->ch->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->TextBox1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @131-ED598703
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

//Operation Method @131-DD94EE4C
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
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @131-04003AFF
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
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->cantparce->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ch->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextBox1->Errors->ToString());
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

        $this->cantparce->Show();
        $this->ch->Show();
        $this->Button_DoSearch->Show();
        $this->Link1->Show();
        $this->TextBox1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End cantidad Class @131-FCB6E20C













//Initialize Page @1-E8403072
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
$TemplateFileName = "union5.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-9D3380AC
include_once("./union5_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F9AD60DE
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$parcelas_unidades_medidas1 = new clsGridparcelas_unidades_medidas1("", $MainPage);
$padrones_parcelas_parcela = new clsRecordpadrones_parcelas_parcela("", $MainPage);
$parcelas_tmp = new clsGridparcelas_tmp("", $MainPage);
$mejoras_personas_tipos_do = new clsGridmejoras_personas_tipos_do("", $MainPage);
$tmp_mejoras = new clsEditableGridtmp_mejoras("", $MainPage);
$NewRecord1 = new clsRecordNewRecord1("", $MainPage);
$personas_tipos_documentos = new clsGridpersonas_tipos_documentos("", $MainPage);
$parcelas_tmp_u_d = new clsGridparcelas_tmp_u_d("", $MainPage);
$css = new clsControl(ccsHidden, "css", "css", ccsText, "", CCGetRequestParam("css", ccsGet, NULL), $MainPage);
$jsapi = new clsControl(ccsHidden, "jsapi", "jsapi", ccsText, "", CCGetRequestParam("jsapi", ccsGet, NULL), $MainPage);
$NewRecord2 = new clsRecordNewRecord2("", $MainPage);
$tmp2 = new clsEditableGridtmp2("", $MainPage);
$cantidad = new clsRecordcantidad("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->parcelas_unidades_medidas1 = & $parcelas_unidades_medidas1;
$MainPage->padrones_parcelas_parcela = & $padrones_parcelas_parcela;
$MainPage->parcelas_tmp = & $parcelas_tmp;
$MainPage->mejoras_personas_tipos_do = & $mejoras_personas_tipos_do;
$MainPage->tmp_mejoras = & $tmp_mejoras;
$MainPage->NewRecord1 = & $NewRecord1;
$MainPage->personas_tipos_documentos = & $personas_tipos_documentos;
$MainPage->parcelas_tmp_u_d = & $parcelas_tmp_u_d;
$MainPage->css = & $css;
$MainPage->jsapi = & $jsapi;
$MainPage->NewRecord2 = & $NewRecord2;
$MainPage->tmp2 = & $tmp2;
$MainPage->cantidad = & $cantidad;
$parcelas_unidades_medidas1->Initialize();
$parcelas_tmp->Initialize();
$mejoras_personas_tipos_do->Initialize();
$tmp_mejoras->Initialize();
$personas_tipos_documentos->Initialize();
$parcelas_tmp_u_d->Initialize();
$tmp2->Initialize();

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

//Execute Components @1-3AD04DCD
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$padrones_parcelas_parcela->Operation();
$tmp_mejoras->Operation();
$NewRecord1->Operation();
$NewRecord2->Operation();
$tmp2->Operation();
$cantidad->Operation();
//End Execute Components

//Go to destination page @1-2C380CB1
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBcatastro->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($parcelas_unidades_medidas1);
    unset($padrones_parcelas_parcela);
    unset($parcelas_tmp);
    unset($mejoras_personas_tipos_do);
    unset($tmp_mejoras);
    unset($NewRecord1);
    unset($personas_tipos_documentos);
    unset($parcelas_tmp_u_d);
    unset($NewRecord2);
    unset($tmp2);
    unset($cantidad);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-93E81C3C
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$parcelas_unidades_medidas1->Show();
$padrones_parcelas_parcela->Show();
$parcelas_tmp->Show();
$mejoras_personas_tipos_do->Show();
$tmp_mejoras->Show();
$NewRecord1->Show();
$personas_tipos_documentos->Show();
$parcelas_tmp_u_d->Show();
$NewRecord2->Show();
$tmp2->Show();
$cantidad->Show();
$css->Show();
$jsapi->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CHTRMG2Q7H9R5A = explode("|", "<center><font face=\"Arial\"><sm|all>&#71;ene&#114;ate&#100; <!-- |CCS -->&#119;it&#104; <!-- SCC -|->C&#111;&#100;eCha&#114;&#10|3;&#101; <!-- SCC -->&#83;tu|&#100;&#105;&#111;.</small><|/font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($CHTRMG2Q7H9R5A,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($CHTRMG2Q7H9R5A,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($CHTRMG2Q7H9R5A,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8ED34333
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBcatastro->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelas_unidades_medidas1);
unset($padrones_parcelas_parcela);
unset($parcelas_tmp);
unset($mejoras_personas_tipos_do);
unset($tmp_mejoras);
unset($NewRecord1);
unset($personas_tipos_documentos);
unset($parcelas_tmp_u_d);
unset($NewRecord2);
unset($tmp2);
unset($cantidad);
unset($Tpl);
//End Unload Page


?>
