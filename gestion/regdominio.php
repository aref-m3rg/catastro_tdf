<?php
//Include Common Files @1-9D630B6B
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "regdominio.php");
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

//Include Page implementation @6-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

class clsGridparcelas_dominiales { //parcelas_dominiales class @7-CC70AD40

//Variables @7-5012EAF0

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
    public $Sorter_parcela_dominial_partida;
    public $Sorter_tipo_instrumento_id;
    public $Sorter_tipo_depto_parc_id;
    public $Sorter_tipo_padron_parc_id;
    public $Sorter_parcela_dominial_seccion;
    public $Sorter_parcela_dominial_chacra;
    public $Sorter_parcela_dominial_quinta;
    public $Sorter_parcela_dominial_macizo;
    public $Sorter_parcela_dominial_fraccion;
    public $Sorter_parcela_dominial_parcela;
    public $Sorter_parcela_dominial_uf;
    public $Sorter_parcela_dominial_mzna;
    public $Sorter_parcela_dominial_lote;
    public $Sorter_parcela_dominial_intrumento_nro;
//End Variables

//Class_Initialize Event @7-8C52810E
    function clsGridparcelas_dominiales($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "parcelas_dominiales";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid parcelas_dominiales";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsparcelas_dominialesDataSource($this);
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
        $this->SorterName = CCGetParam("parcelas_dominialesOrder", "");
        $this->SorterDirection = CCGetParam("parcelas_dominialesDir", "");

        $this->parcela_dominial_partida = new clsControl(ccsLink, "parcela_dominial_partida", "parcela_dominial_partida", ccsInteger, "", CCGetRequestParam("parcela_dominial_partida", ccsGet, NULL), $this);
        $this->parcela_dominial_partida->Page = "regdominio.php";
        $this->tipo_instrumento_abrev = new clsControl(ccsLabel, "tipo_instrumento_abrev", "tipo_instrumento_abrev", ccsText, "", CCGetRequestParam("tipo_instrumento_abrev", ccsGet, NULL), $this);
        $this->tipo_depto_parc_abrev = new clsControl(ccsLabel, "tipo_depto_parc_abrev", "tipo_depto_parc_abrev", ccsText, "", CCGetRequestParam("tipo_depto_parc_abrev", ccsGet, NULL), $this);
        $this->tipo_padron_parc_abrev = new clsControl(ccsLabel, "tipo_padron_parc_abrev", "tipo_padron_parc_abrev", ccsText, "", CCGetRequestParam("tipo_padron_parc_abrev", ccsGet, NULL), $this);
        $this->parcela_dominial_seccion = new clsControl(ccsLabel, "parcela_dominial_seccion", "parcela_dominial_seccion", ccsText, "", CCGetRequestParam("parcela_dominial_seccion", ccsGet, NULL), $this);
        $this->parcela_dominial_chacra = new clsControl(ccsLabel, "parcela_dominial_chacra", "parcela_dominial_chacra", ccsText, "", CCGetRequestParam("parcela_dominial_chacra", ccsGet, NULL), $this);
        $this->parcela_dominial_quinta = new clsControl(ccsLabel, "parcela_dominial_quinta", "parcela_dominial_quinta", ccsText, "", CCGetRequestParam("parcela_dominial_quinta", ccsGet, NULL), $this);
        $this->parcela_dominial_macizo = new clsControl(ccsLabel, "parcela_dominial_macizo", "parcela_dominial_macizo", ccsText, "", CCGetRequestParam("parcela_dominial_macizo", ccsGet, NULL), $this);
        $this->parcela_dominial_fraccion = new clsControl(ccsLabel, "parcela_dominial_fraccion", "parcela_dominial_fraccion", ccsText, "", CCGetRequestParam("parcela_dominial_fraccion", ccsGet, NULL), $this);
        $this->parcela_dominial_parcela = new clsControl(ccsLabel, "parcela_dominial_parcela", "parcela_dominial_parcela", ccsText, "", CCGetRequestParam("parcela_dominial_parcela", ccsGet, NULL), $this);
        $this->parcela_dominial_uf = new clsControl(ccsLabel, "parcela_dominial_uf", "parcela_dominial_uf", ccsText, "", CCGetRequestParam("parcela_dominial_uf", ccsGet, NULL), $this);
        $this->parcela_dominial_mzna = new clsControl(ccsLabel, "parcela_dominial_mzna", "parcela_dominial_mzna", ccsText, "", CCGetRequestParam("parcela_dominial_mzna", ccsGet, NULL), $this);
        $this->parcela_dominial_lote = new clsControl(ccsLabel, "parcela_dominial_lote", "parcela_dominial_lote", ccsText, "", CCGetRequestParam("parcela_dominial_lote", ccsGet, NULL), $this);
        $this->parcela_dominial_intrumento_nro = new clsControl(ccsLabel, "parcela_dominial_intrumento_nro", "parcela_dominial_intrumento_nro", ccsText, "", CCGetRequestParam("parcela_dominial_intrumento_nro", ccsGet, NULL), $this);
        $this->Sorter_parcela_dominial_partida = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_partida", $FileName, $this);
        $this->Sorter_tipo_instrumento_id = new clsSorter($this->ComponentName, "Sorter_tipo_instrumento_id", $FileName, $this);
        $this->Sorter_tipo_depto_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_depto_parc_id", $FileName, $this);
        $this->Sorter_tipo_padron_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_padron_parc_id", $FileName, $this);
        $this->Sorter_parcela_dominial_seccion = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_seccion", $FileName, $this);
        $this->Sorter_parcela_dominial_chacra = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_chacra", $FileName, $this);
        $this->Sorter_parcela_dominial_quinta = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_quinta", $FileName, $this);
        $this->Sorter_parcela_dominial_macizo = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_macizo", $FileName, $this);
        $this->Sorter_parcela_dominial_fraccion = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_fraccion", $FileName, $this);
        $this->Sorter_parcela_dominial_parcela = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_parcela", $FileName, $this);
        $this->Sorter_parcela_dominial_uf = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_uf", $FileName, $this);
        $this->Sorter_parcela_dominial_mzna = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_mzna", $FileName, $this);
        $this->Sorter_parcela_dominial_lote = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_lote", $FileName, $this);
        $this->Sorter_parcela_dominial_intrumento_nro = new clsSorter($this->ComponentName, "Sorter_parcela_dominial_intrumento_nro", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @7-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @7-B1D1F56D
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);

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
            $this->ControlsVisible["parcela_dominial_partida"] = $this->parcela_dominial_partida->Visible;
            $this->ControlsVisible["tipo_instrumento_abrev"] = $this->tipo_instrumento_abrev->Visible;
            $this->ControlsVisible["tipo_depto_parc_abrev"] = $this->tipo_depto_parc_abrev->Visible;
            $this->ControlsVisible["tipo_padron_parc_abrev"] = $this->tipo_padron_parc_abrev->Visible;
            $this->ControlsVisible["parcela_dominial_seccion"] = $this->parcela_dominial_seccion->Visible;
            $this->ControlsVisible["parcela_dominial_chacra"] = $this->parcela_dominial_chacra->Visible;
            $this->ControlsVisible["parcela_dominial_quinta"] = $this->parcela_dominial_quinta->Visible;
            $this->ControlsVisible["parcela_dominial_macizo"] = $this->parcela_dominial_macizo->Visible;
            $this->ControlsVisible["parcela_dominial_fraccion"] = $this->parcela_dominial_fraccion->Visible;
            $this->ControlsVisible["parcela_dominial_parcela"] = $this->parcela_dominial_parcela->Visible;
            $this->ControlsVisible["parcela_dominial_uf"] = $this->parcela_dominial_uf->Visible;
            $this->ControlsVisible["parcela_dominial_mzna"] = $this->parcela_dominial_mzna->Visible;
            $this->ControlsVisible["parcela_dominial_lote"] = $this->parcela_dominial_lote->Visible;
            $this->ControlsVisible["parcela_dominial_intrumento_nro"] = $this->parcela_dominial_intrumento_nro->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_dominial_partida->SetValue($this->DataSource->parcela_dominial_partida->GetValue());
                $this->parcela_dominial_partida->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->parcela_dominial_partida->Parameters = CCAddParam($this->parcela_dominial_partida->Parameters, "parcela_dominial_id", $this->DataSource->f("parcela_dominial_id"));
                $this->tipo_instrumento_abrev->SetValue($this->DataSource->tipo_instrumento_abrev->GetValue());
                $this->tipo_depto_parc_abrev->SetValue($this->DataSource->tipo_depto_parc_abrev->GetValue());
                $this->tipo_padron_parc_abrev->SetValue($this->DataSource->tipo_padron_parc_abrev->GetValue());
                $this->parcela_dominial_seccion->SetValue($this->DataSource->parcela_dominial_seccion->GetValue());
                $this->parcela_dominial_chacra->SetValue($this->DataSource->parcela_dominial_chacra->GetValue());
                $this->parcela_dominial_quinta->SetValue($this->DataSource->parcela_dominial_quinta->GetValue());
                $this->parcela_dominial_macizo->SetValue($this->DataSource->parcela_dominial_macizo->GetValue());
                $this->parcela_dominial_fraccion->SetValue($this->DataSource->parcela_dominial_fraccion->GetValue());
                $this->parcela_dominial_parcela->SetValue($this->DataSource->parcela_dominial_parcela->GetValue());
                $this->parcela_dominial_uf->SetValue($this->DataSource->parcela_dominial_uf->GetValue());
                $this->parcela_dominial_mzna->SetValue($this->DataSource->parcela_dominial_mzna->GetValue());
                $this->parcela_dominial_lote->SetValue($this->DataSource->parcela_dominial_lote->GetValue());
                $this->parcela_dominial_intrumento_nro->SetValue($this->DataSource->parcela_dominial_intrumento_nro->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_dominial_partida->Show();
                $this->tipo_instrumento_abrev->Show();
                $this->tipo_depto_parc_abrev->Show();
                $this->tipo_padron_parc_abrev->Show();
                $this->parcela_dominial_seccion->Show();
                $this->parcela_dominial_chacra->Show();
                $this->parcela_dominial_quinta->Show();
                $this->parcela_dominial_macizo->Show();
                $this->parcela_dominial_fraccion->Show();
                $this->parcela_dominial_parcela->Show();
                $this->parcela_dominial_uf->Show();
                $this->parcela_dominial_mzna->Show();
                $this->parcela_dominial_lote->Show();
                $this->parcela_dominial_intrumento_nro->Show();
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
        $this->Sorter_parcela_dominial_partida->Show();
        $this->Sorter_tipo_instrumento_id->Show();
        $this->Sorter_tipo_depto_parc_id->Show();
        $this->Sorter_tipo_padron_parc_id->Show();
        $this->Sorter_parcela_dominial_seccion->Show();
        $this->Sorter_parcela_dominial_chacra->Show();
        $this->Sorter_parcela_dominial_quinta->Show();
        $this->Sorter_parcela_dominial_macizo->Show();
        $this->Sorter_parcela_dominial_fraccion->Show();
        $this->Sorter_parcela_dominial_parcela->Show();
        $this->Sorter_parcela_dominial_uf->Show();
        $this->Sorter_parcela_dominial_mzna->Show();
        $this->Sorter_parcela_dominial_lote->Show();
        $this->Sorter_parcela_dominial_intrumento_nro->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @7-0634B4A7
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_dominial_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_instrumento_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_depto_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_padron_parc_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_mzna->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_lote->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_dominial_intrumento_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas_dominiales Class @7-FCB6E20C

class clsparcelas_dominialesDataSource extends clsDBtdf_nuevo {  //parcelas_dominialesDataSource Class @7-5D68A3AA

//DataSource Variables @7-EFF68910
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_dominial_partida;
    public $tipo_instrumento_abrev;
    public $tipo_depto_parc_abrev;
    public $tipo_padron_parc_abrev;
    public $parcela_dominial_seccion;
    public $parcela_dominial_chacra;
    public $parcela_dominial_quinta;
    public $parcela_dominial_macizo;
    public $parcela_dominial_fraccion;
    public $parcela_dominial_parcela;
    public $parcela_dominial_uf;
    public $parcela_dominial_mzna;
    public $parcela_dominial_lote;
    public $parcela_dominial_intrumento_nro;
//End DataSource Variables

//DataSourceClass_Initialize Event @7-FEC3CE59
    function clsparcelas_dominialesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas_dominiales";
        $this->Initialize();
        $this->parcela_dominial_partida = new clsField("parcela_dominial_partida", ccsInteger, "");
        
        $this->tipo_instrumento_abrev = new clsField("tipo_instrumento_abrev", ccsText, "");
        
        $this->tipo_depto_parc_abrev = new clsField("tipo_depto_parc_abrev", ccsText, "");
        
        $this->tipo_padron_parc_abrev = new clsField("tipo_padron_parc_abrev", ccsText, "");
        
        $this->parcela_dominial_seccion = new clsField("parcela_dominial_seccion", ccsText, "");
        
        $this->parcela_dominial_chacra = new clsField("parcela_dominial_chacra", ccsText, "");
        
        $this->parcela_dominial_quinta = new clsField("parcela_dominial_quinta", ccsText, "");
        
        $this->parcela_dominial_macizo = new clsField("parcela_dominial_macizo", ccsText, "");
        
        $this->parcela_dominial_fraccion = new clsField("parcela_dominial_fraccion", ccsText, "");
        
        $this->parcela_dominial_parcela = new clsField("parcela_dominial_parcela", ccsText, "");
        
        $this->parcela_dominial_uf = new clsField("parcela_dominial_uf", ccsText, "");
        
        $this->parcela_dominial_mzna = new clsField("parcela_dominial_mzna", ccsText, "");
        
        $this->parcela_dominial_lote = new clsField("parcela_dominial_lote", ccsText, "");
        
        $this->parcela_dominial_intrumento_nro = new clsField("parcela_dominial_intrumento_nro", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @7-173EB04A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_dominial_partida" => array("parcela_dominial_partida", ""), 
            "Sorter_tipo_instrumento_id" => array("tipo_instrumento_id", ""), 
            "Sorter_tipo_depto_parc_id" => array("tipo_depto_parc_id", ""), 
            "Sorter_tipo_padron_parc_id" => array("tipo_padron_parc_id", ""), 
            "Sorter_parcela_dominial_seccion" => array("parcela_dominial_seccion", ""), 
            "Sorter_parcela_dominial_chacra" => array("parcela_dominial_chacra", ""), 
            "Sorter_parcela_dominial_quinta" => array("parcela_dominial_quinta", ""), 
            "Sorter_parcela_dominial_macizo" => array("parcela_dominial_macizo", ""), 
            "Sorter_parcela_dominial_fraccion" => array("parcela_dominial_fraccion", ""), 
            "Sorter_parcela_dominial_parcela" => array("parcela_dominial_parcela", ""), 
            "Sorter_parcela_dominial_uf" => array("parcela_dominial_uf", ""), 
            "Sorter_parcela_dominial_mzna" => array("parcela_dominial_mzna", ""), 
            "Sorter_parcela_dominial_lote" => array("parcela_dominial_lote", ""), 
            "Sorter_parcela_dominial_intrumento_nro" => array("parcela_dominial_intrumento_nro", "")));
    }
//End SetOrder Method

//Prepare Method @7-72BF9358
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas_dominiales.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @7-58BA6DED
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((parcelas_dominiales LEFT JOIN tipos_instrumentos ON\n\n" .
        "parcelas_dominiales.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas_dominiales.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas_dominiales.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id";
        $this->SQL = "SELECT parcela_dominial_id, parcela_dominial_partida, parcelas_dominiales.tipo_instrumento_id AS parcelas_dominiales_tipo_instrumento_id,\n\n" .
        "parcelas_dominiales.tipo_depto_parc_id AS parcelas_dominiales_tipo_depto_parc_id, parcelas_dominiales.tipo_padron_parc_id AS parcelas_dominiales_tipo_padron_parc_id,\n\n" .
        "parcela_dominial_seccion, parcela_dominial_chacra, parcela_dominial_quinta, parcela_dominial_macizo, parcela_dominial_fraccion,\n\n" .
        "parcela_dominial_parcela, parcela_dominial_uf, parcela_dominial_mzna, parcela_dominial_lote, parcela_dominial_intrumento_nro,\n\n" .
        "tipo_padron_parc_abrev, tipo_depto_parc_abrev, tipo_instrumento_abrev \n\n" .
        "FROM ((parcelas_dominiales LEFT JOIN tipos_instrumentos ON\n\n" .
        "parcelas_dominiales.tipo_instrumento_id = tipos_instrumentos.tipo_instrumento_id) LEFT JOIN tipos_deptos_parcela ON\n\n" .
        "parcelas_dominiales.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id) LEFT JOIN tipos_padrones_parcela ON\n\n" .
        "parcelas_dominiales.tipo_padron_parc_id = tipos_padrones_parcela.tipo_padron_parc_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @7-23BB3FE6
    function SetValues()
    {
        $this->parcela_dominial_partida->SetDBValue(trim($this->f("parcela_dominial_partida")));
        $this->tipo_instrumento_abrev->SetDBValue($this->f("tipo_instrumento_abrev"));
        $this->tipo_depto_parc_abrev->SetDBValue($this->f("tipo_depto_parc_abrev"));
        $this->tipo_padron_parc_abrev->SetDBValue($this->f("tipo_padron_parc_abrev"));
        $this->parcela_dominial_seccion->SetDBValue($this->f("parcela_dominial_seccion"));
        $this->parcela_dominial_chacra->SetDBValue($this->f("parcela_dominial_chacra"));
        $this->parcela_dominial_quinta->SetDBValue($this->f("parcela_dominial_quinta"));
        $this->parcela_dominial_macizo->SetDBValue($this->f("parcela_dominial_macizo"));
        $this->parcela_dominial_fraccion->SetDBValue($this->f("parcela_dominial_fraccion"));
        $this->parcela_dominial_parcela->SetDBValue($this->f("parcela_dominial_parcela"));
        $this->parcela_dominial_uf->SetDBValue($this->f("parcela_dominial_uf"));
        $this->parcela_dominial_mzna->SetDBValue($this->f("parcela_dominial_mzna"));
        $this->parcela_dominial_lote->SetDBValue($this->f("parcela_dominial_lote"));
        $this->parcela_dominial_intrumento_nro->SetDBValue($this->f("parcela_dominial_intrumento_nro"));
    }
//End SetValues Method

} //End parcelas_dominialesDataSource Class @7-FCB6E20C

class clsRecordparcelas_dominiales1 { //parcelas_dominiales1 Class @54-43C9AA74

//Variables @54-9E315808

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

//Class_Initialize Event @54-3C694410
    function clsRecordparcelas_dominiales1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelas_dominiales1/Error";
        $this->DataSource = new clsparcelas_dominiales1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelas_dominiales1";
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
            $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "Tipo Instrumento Id", ccsInteger, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
            $this->tipo_instrumento_id->DSType = dsTable;
            $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
            $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
            $this->tipo_instrumento_id->DataSource->Order = "tipo_instrumento_descrip";
            list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
            $this->tipo_instrumento_id->DataSource->Order = "tipo_instrumento_descrip";
            $this->parcela_dominial_intrumento_nro = new clsControl(ccsTextBox, "parcela_dominial_intrumento_nro", "Parcela Dominial Intrumento Nro", ccsText, "", CCGetRequestParam("parcela_dominial_intrumento_nro", $Method, NULL), $this);
            $this->parcela_dominial_partida = new clsControl(ccsTextBox, "parcela_dominial_partida", "Parcela Dominial Partida", ccsInteger, "", CCGetRequestParam("parcela_dominial_partida", $Method, NULL), $this);
            $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Tipo Depto Parc Id", ccsInteger, "", CCGetRequestParam("tipo_depto_parc_id", $Method, NULL), $this);
            $this->tipo_depto_parc_id->DSType = dsTable;
            $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
            $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_abrev", "");
            $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "Tipo Padron Parc Id", ccsInteger, "", CCGetRequestParam("tipo_padron_parc_id", $Method, NULL), $this);
            $this->tipo_padron_parc_id->DSType = dsTable;
            $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
            $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
            $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_abrev", "");
            $this->parcela_dominial_seccion = new clsControl(ccsTextBox, "parcela_dominial_seccion", "Parcela Dominial Seccion", ccsText, "", CCGetRequestParam("parcela_dominial_seccion", $Method, NULL), $this);
            $this->parcela_dominial_chacra = new clsControl(ccsTextBox, "parcela_dominial_chacra", "Parcela Dominial Chacra", ccsText, "", CCGetRequestParam("parcela_dominial_chacra", $Method, NULL), $this);
            $this->parcela_dominial_quinta = new clsControl(ccsTextBox, "parcela_dominial_quinta", "Parcela Dominial Quinta", ccsText, "", CCGetRequestParam("parcela_dominial_quinta", $Method, NULL), $this);
            $this->parcela_dominial_macizo = new clsControl(ccsTextBox, "parcela_dominial_macizo", "Parcela Dominial Macizo", ccsText, "", CCGetRequestParam("parcela_dominial_macizo", $Method, NULL), $this);
            $this->parcela_dominial_fraccion = new clsControl(ccsTextBox, "parcela_dominial_fraccion", "Parcela Dominial Fraccion", ccsText, "", CCGetRequestParam("parcela_dominial_fraccion", $Method, NULL), $this);
            $this->parcela_dominial_parcela = new clsControl(ccsTextBox, "parcela_dominial_parcela", "Parcela Dominial Parcela", ccsText, "", CCGetRequestParam("parcela_dominial_parcela", $Method, NULL), $this);
            $this->parcela_dominial_uf = new clsControl(ccsTextBox, "parcela_dominial_uf", "Parcela Dominial Uf", ccsText, "", CCGetRequestParam("parcela_dominial_uf", $Method, NULL), $this);
            $this->parcela_dominial_mzna = new clsControl(ccsTextBox, "parcela_dominial_mzna", "Parcela Dominial Mzna", ccsText, "", CCGetRequestParam("parcela_dominial_mzna", $Method, NULL), $this);
            $this->parcela_dominial_lote = new clsControl(ccsTextBox, "parcela_dominial_lote", "Parcela Dominial Lote", ccsText, "", CCGetRequestParam("parcela_dominial_lote", $Method, NULL), $this);
            $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "Parcela Id", ccsInteger, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
            $this->usuario_id = new clsControl(ccsHidden, "usuario_id", "Usuario Id", ccsInteger, "", CCGetRequestParam("usuario_id", $Method, NULL), $this);
            $this->parcela_dominial_f_pro = new clsControl(ccsHidden, "parcela_dominial_f_pro", "Parcela Dominial F Pro", ccsDate, $DefaultDateFormat, CCGetRequestParam("parcela_dominial_f_pro", $Method, NULL), $this);
            $this->volver = new clsButton("volver", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_clear = new clsButton("Button_clear", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->parcela_dominial_partida->Value) && !strlen($this->parcela_dominial_partida->Value) && $this->parcela_dominial_partida->Value !== false)
                    $this->parcela_dominial_partida->SetText(0);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @54-3B2ACBBE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlparcela_dominial_id"] = CCGetFromGet("parcela_dominial_id", NULL);
    }
//End Initialize Method

//Validate Method @54-2B944B21
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_intrumento_nro->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_partida->Validate() && $Validation);
        $Validation = ($this->tipo_depto_parc_id->Validate() && $Validation);
        $Validation = ($this->tipo_padron_parc_id->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_seccion->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_chacra->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_quinta->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_macizo->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_fraccion->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_parcela->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_uf->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_mzna->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_lote->Validate() && $Validation);
        $Validation = ($this->parcela_id->Validate() && $Validation);
        $Validation = ($this->usuario_id->Validate() && $Validation);
        $Validation = ($this->parcela_dominial_f_pro->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_intrumento_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_depto_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_padron_parc_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_mzna->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_lote->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->parcela_dominial_f_pro->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @54-6CE8DACB
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_intrumento_nro->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_partida->Errors->Count());
        $errors = ($errors || $this->tipo_depto_parc_id->Errors->Count());
        $errors = ($errors || $this->tipo_padron_parc_id->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_seccion->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_chacra->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_quinta->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_macizo->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_fraccion->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_parcela->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_uf->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_mzna->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_lote->Errors->Count());
        $errors = ($errors || $this->parcela_id->Errors->Count());
        $errors = ($errors || $this->usuario_id->Errors->Count());
        $errors = ($errors || $this->parcela_dominial_f_pro->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @54-ED598703
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

//Operation Method @54-D65A5F36
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
            } else if($this->volver->Pressed) {
                $this->PressedButton = "volver";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_clear->Pressed) {
                $this->PressedButton = "Button_clear";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Update") {
            if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "volver") {
            $Redirect = "recordParcela.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_dominial_id"));
            if(!CCGetEvent($this->volver->CCSEvents, "OnClick", $this->volver)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Delete") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_dominial_id"));
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_clear") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "parcela_dominial_id"));
            if(!CCGetEvent($this->Button_clear->CCSEvents, "OnClick", $this->Button_clear)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
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

//InsertRow Method @54-F6E8D206
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
        $this->DataSource->parcela_dominial_intrumento_nro->SetValue($this->parcela_dominial_intrumento_nro->GetValue(true));
        $this->DataSource->parcela_dominial_partida->SetValue($this->parcela_dominial_partida->GetValue(true));
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
        $this->DataSource->parcela_dominial_seccion->SetValue($this->parcela_dominial_seccion->GetValue(true));
        $this->DataSource->parcela_dominial_chacra->SetValue($this->parcela_dominial_chacra->GetValue(true));
        $this->DataSource->parcela_dominial_quinta->SetValue($this->parcela_dominial_quinta->GetValue(true));
        $this->DataSource->parcela_dominial_macizo->SetValue($this->parcela_dominial_macizo->GetValue(true));
        $this->DataSource->parcela_dominial_fraccion->SetValue($this->parcela_dominial_fraccion->GetValue(true));
        $this->DataSource->parcela_dominial_parcela->SetValue($this->parcela_dominial_parcela->GetValue(true));
        $this->DataSource->parcela_dominial_uf->SetValue($this->parcela_dominial_uf->GetValue(true));
        $this->DataSource->parcela_dominial_mzna->SetValue($this->parcela_dominial_mzna->GetValue(true));
        $this->DataSource->parcela_dominial_lote->SetValue($this->parcela_dominial_lote->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->parcela_dominial_f_pro->SetValue($this->parcela_dominial_f_pro->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @54-E828A64D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
        $this->DataSource->parcela_dominial_intrumento_nro->SetValue($this->parcela_dominial_intrumento_nro->GetValue(true));
        $this->DataSource->parcela_dominial_partida->SetValue($this->parcela_dominial_partida->GetValue(true));
        $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
        $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
        $this->DataSource->parcela_dominial_seccion->SetValue($this->parcela_dominial_seccion->GetValue(true));
        $this->DataSource->parcela_dominial_chacra->SetValue($this->parcela_dominial_chacra->GetValue(true));
        $this->DataSource->parcela_dominial_quinta->SetValue($this->parcela_dominial_quinta->GetValue(true));
        $this->DataSource->parcela_dominial_macizo->SetValue($this->parcela_dominial_macizo->GetValue(true));
        $this->DataSource->parcela_dominial_fraccion->SetValue($this->parcela_dominial_fraccion->GetValue(true));
        $this->DataSource->parcela_dominial_parcela->SetValue($this->parcela_dominial_parcela->GetValue(true));
        $this->DataSource->parcela_dominial_uf->SetValue($this->parcela_dominial_uf->GetValue(true));
        $this->DataSource->parcela_dominial_mzna->SetValue($this->parcela_dominial_mzna->GetValue(true));
        $this->DataSource->parcela_dominial_lote->SetValue($this->parcela_dominial_lote->GetValue(true));
        $this->DataSource->parcela_id->SetValue($this->parcela_id->GetValue(true));
        $this->DataSource->usuario_id->SetValue($this->usuario_id->GetValue(true));
        $this->DataSource->parcela_dominial_f_pro->SetValue($this->parcela_dominial_f_pro->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @54-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @54-9B7406EF
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

        $this->tipo_instrumento_id->Prepare();
        $this->tipo_depto_parc_id->Prepare();
        $this->tipo_padron_parc_id->Prepare();

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
                    $this->tipo_instrumento_id->SetValue($this->DataSource->tipo_instrumento_id->GetValue());
                    $this->parcela_dominial_intrumento_nro->SetValue($this->DataSource->parcela_dominial_intrumento_nro->GetValue());
                    $this->parcela_dominial_partida->SetValue($this->DataSource->parcela_dominial_partida->GetValue());
                    $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
                    $this->tipo_padron_parc_id->SetValue($this->DataSource->tipo_padron_parc_id->GetValue());
                    $this->parcela_dominial_seccion->SetValue($this->DataSource->parcela_dominial_seccion->GetValue());
                    $this->parcela_dominial_chacra->SetValue($this->DataSource->parcela_dominial_chacra->GetValue());
                    $this->parcela_dominial_quinta->SetValue($this->DataSource->parcela_dominial_quinta->GetValue());
                    $this->parcela_dominial_macizo->SetValue($this->DataSource->parcela_dominial_macizo->GetValue());
                    $this->parcela_dominial_fraccion->SetValue($this->DataSource->parcela_dominial_fraccion->GetValue());
                    $this->parcela_dominial_parcela->SetValue($this->DataSource->parcela_dominial_parcela->GetValue());
                    $this->parcela_dominial_uf->SetValue($this->DataSource->parcela_dominial_uf->GetValue());
                    $this->parcela_dominial_mzna->SetValue($this->DataSource->parcela_dominial_mzna->GetValue());
                    $this->parcela_dominial_lote->SetValue($this->DataSource->parcela_dominial_lote->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->usuario_id->SetValue($this->DataSource->usuario_id->GetValue());
                    $this->parcela_dominial_f_pro->SetValue($this->DataSource->parcela_dominial_f_pro->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_intrumento_nro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_depto_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_padron_parc_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_mzna->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_lote->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->parcela_dominial_f_pro->Errors->ToString());
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
        $this->tipo_instrumento_id->Show();
        $this->parcela_dominial_intrumento_nro->Show();
        $this->parcela_dominial_partida->Show();
        $this->tipo_depto_parc_id->Show();
        $this->tipo_padron_parc_id->Show();
        $this->parcela_dominial_seccion->Show();
        $this->parcela_dominial_chacra->Show();
        $this->parcela_dominial_quinta->Show();
        $this->parcela_dominial_macizo->Show();
        $this->parcela_dominial_fraccion->Show();
        $this->parcela_dominial_parcela->Show();
        $this->parcela_dominial_uf->Show();
        $this->parcela_dominial_mzna->Show();
        $this->parcela_dominial_lote->Show();
        $this->parcela_id->Show();
        $this->usuario_id->Show();
        $this->parcela_dominial_f_pro->Show();
        $this->volver->Show();
        $this->Button_Delete->Show();
        $this->Button_clear->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End parcelas_dominiales1 Class @54-FCB6E20C

class clsparcelas_dominiales1DataSource extends clsDBtdf_nuevo {  //parcelas_dominiales1DataSource Class @54-4C04E3E6

//DataSource Variables @54-AC42A6F9
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
    public $tipo_instrumento_id;
    public $parcela_dominial_intrumento_nro;
    public $parcela_dominial_partida;
    public $tipo_depto_parc_id;
    public $tipo_padron_parc_id;
    public $parcela_dominial_seccion;
    public $parcela_dominial_chacra;
    public $parcela_dominial_quinta;
    public $parcela_dominial_macizo;
    public $parcela_dominial_fraccion;
    public $parcela_dominial_parcela;
    public $parcela_dominial_uf;
    public $parcela_dominial_mzna;
    public $parcela_dominial_lote;
    public $parcela_id;
    public $usuario_id;
    public $parcela_dominial_f_pro;
//End DataSource Variables

//DataSourceClass_Initialize Event @54-D877F86D
    function clsparcelas_dominiales1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record parcelas_dominiales1/Error";
        $this->Initialize();
        $this->tipo_instrumento_id = new clsField("tipo_instrumento_id", ccsInteger, "");
        
        $this->parcela_dominial_intrumento_nro = new clsField("parcela_dominial_intrumento_nro", ccsText, "");
        
        $this->parcela_dominial_partida = new clsField("parcela_dominial_partida", ccsInteger, "");
        
        $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
        
        $this->tipo_padron_parc_id = new clsField("tipo_padron_parc_id", ccsInteger, "");
        
        $this->parcela_dominial_seccion = new clsField("parcela_dominial_seccion", ccsText, "");
        
        $this->parcela_dominial_chacra = new clsField("parcela_dominial_chacra", ccsText, "");
        
        $this->parcela_dominial_quinta = new clsField("parcela_dominial_quinta", ccsText, "");
        
        $this->parcela_dominial_macizo = new clsField("parcela_dominial_macizo", ccsText, "");
        
        $this->parcela_dominial_fraccion = new clsField("parcela_dominial_fraccion", ccsText, "");
        
        $this->parcela_dominial_parcela = new clsField("parcela_dominial_parcela", ccsText, "");
        
        $this->parcela_dominial_uf = new clsField("parcela_dominial_uf", ccsText, "");
        
        $this->parcela_dominial_mzna = new clsField("parcela_dominial_mzna", ccsText, "");
        
        $this->parcela_dominial_lote = new clsField("parcela_dominial_lote", ccsText, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsInteger, "");
        
        $this->usuario_id = new clsField("usuario_id", ccsInteger, "");
        
        $this->parcela_dominial_f_pro = new clsField("parcela_dominial_f_pro", ccsDate, $this->DateFormat);
        

        $this->InsertFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_intrumento_nro"] = array("Name" => "parcela_dominial_intrumento_nro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_partida"] = array("Name" => "parcela_dominial_partida", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_seccion"] = array("Name" => "parcela_dominial_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_chacra"] = array("Name" => "parcela_dominial_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_quinta"] = array("Name" => "parcela_dominial_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_macizo"] = array("Name" => "parcela_dominial_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_fraccion"] = array("Name" => "parcela_dominial_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_parcela"] = array("Name" => "parcela_dominial_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_uf"] = array("Name" => "parcela_dominial_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_mzna"] = array("Name" => "parcela_dominial_mzna", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_lote"] = array("Name" => "parcela_dominial_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["parcela_dominial_f_pro"] = array("Name" => "parcela_dominial_f_pro", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_intrumento_nro"] = array("Name" => "parcela_dominial_intrumento_nro", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_partida"] = array("Name" => "parcela_dominial_partida", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_seccion"] = array("Name" => "parcela_dominial_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_chacra"] = array("Name" => "parcela_dominial_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_quinta"] = array("Name" => "parcela_dominial_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_macizo"] = array("Name" => "parcela_dominial_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_fraccion"] = array("Name" => "parcela_dominial_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_parcela"] = array("Name" => "parcela_dominial_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_uf"] = array("Name" => "parcela_dominial_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_mzna"] = array("Name" => "parcela_dominial_mzna", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_lote"] = array("Name" => "parcela_dominial_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_id"] = array("Name" => "parcela_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["parcela_dominial_f_pro"] = array("Name" => "parcela_dominial_f_pro", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @54-E429D88A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_dominial_id", ccsInteger, "", "", $this->Parameters["urlparcela_dominial_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_dominial_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @54-6CFE206E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM parcelas_dominiales {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @54-FE08EE39
    function SetValues()
    {
        $this->tipo_instrumento_id->SetDBValue(trim($this->f("tipo_instrumento_id")));
        $this->parcela_dominial_intrumento_nro->SetDBValue($this->f("parcela_dominial_intrumento_nro"));
        $this->parcela_dominial_partida->SetDBValue(trim($this->f("parcela_dominial_partida")));
        $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
        $this->tipo_padron_parc_id->SetDBValue(trim($this->f("tipo_padron_parc_id")));
        $this->parcela_dominial_seccion->SetDBValue($this->f("parcela_dominial_seccion"));
        $this->parcela_dominial_chacra->SetDBValue($this->f("parcela_dominial_chacra"));
        $this->parcela_dominial_quinta->SetDBValue($this->f("parcela_dominial_quinta"));
        $this->parcela_dominial_macizo->SetDBValue($this->f("parcela_dominial_macizo"));
        $this->parcela_dominial_fraccion->SetDBValue($this->f("parcela_dominial_fraccion"));
        $this->parcela_dominial_parcela->SetDBValue($this->f("parcela_dominial_parcela"));
        $this->parcela_dominial_uf->SetDBValue($this->f("parcela_dominial_uf"));
        $this->parcela_dominial_mzna->SetDBValue($this->f("parcela_dominial_mzna"));
        $this->parcela_dominial_lote->SetDBValue($this->f("parcela_dominial_lote"));
        $this->parcela_id->SetDBValue(trim($this->f("parcela_id")));
        $this->usuario_id->SetDBValue(trim($this->f("usuario_id")));
        $this->parcela_dominial_f_pro->SetDBValue(trim($this->f("parcela_dominial_f_pro")));
    }
//End SetValues Method

//Insert Method @54-F3755DDB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_instrumento_id"]["Value"] = $this->tipo_instrumento_id->GetDBValue(true);
        $this->InsertFields["parcela_dominial_intrumento_nro"]["Value"] = $this->parcela_dominial_intrumento_nro->GetDBValue(true);
        $this->InsertFields["parcela_dominial_partida"]["Value"] = $this->parcela_dominial_partida->GetDBValue(true);
        $this->InsertFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->InsertFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
        $this->InsertFields["parcela_dominial_seccion"]["Value"] = $this->parcela_dominial_seccion->GetDBValue(true);
        $this->InsertFields["parcela_dominial_chacra"]["Value"] = $this->parcela_dominial_chacra->GetDBValue(true);
        $this->InsertFields["parcela_dominial_quinta"]["Value"] = $this->parcela_dominial_quinta->GetDBValue(true);
        $this->InsertFields["parcela_dominial_macizo"]["Value"] = $this->parcela_dominial_macizo->GetDBValue(true);
        $this->InsertFields["parcela_dominial_fraccion"]["Value"] = $this->parcela_dominial_fraccion->GetDBValue(true);
        $this->InsertFields["parcela_dominial_parcela"]["Value"] = $this->parcela_dominial_parcela->GetDBValue(true);
        $this->InsertFields["parcela_dominial_uf"]["Value"] = $this->parcela_dominial_uf->GetDBValue(true);
        $this->InsertFields["parcela_dominial_mzna"]["Value"] = $this->parcela_dominial_mzna->GetDBValue(true);
        $this->InsertFields["parcela_dominial_lote"]["Value"] = $this->parcela_dominial_lote->GetDBValue(true);
        $this->InsertFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->usuario_id->GetDBValue(true);
        $this->InsertFields["parcela_dominial_f_pro"]["Value"] = $this->parcela_dominial_f_pro->GetDBValue(true);
        $this->SQL = CCBuildInsert("parcelas_dominiales", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @54-770C1FE5
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_instrumento_id"]["Value"] = $this->tipo_instrumento_id->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_intrumento_nro"]["Value"] = $this->parcela_dominial_intrumento_nro->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_partida"]["Value"] = $this->parcela_dominial_partida->GetDBValue(true);
        $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
        $this->UpdateFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_seccion"]["Value"] = $this->parcela_dominial_seccion->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_chacra"]["Value"] = $this->parcela_dominial_chacra->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_quinta"]["Value"] = $this->parcela_dominial_quinta->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_macizo"]["Value"] = $this->parcela_dominial_macizo->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_fraccion"]["Value"] = $this->parcela_dominial_fraccion->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_parcela"]["Value"] = $this->parcela_dominial_parcela->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_uf"]["Value"] = $this->parcela_dominial_uf->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_mzna"]["Value"] = $this->parcela_dominial_mzna->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_lote"]["Value"] = $this->parcela_dominial_lote->GetDBValue(true);
        $this->UpdateFields["parcela_id"]["Value"] = $this->parcela_id->GetDBValue(true);
        $this->UpdateFields["usuario_id"]["Value"] = $this->usuario_id->GetDBValue(true);
        $this->UpdateFields["parcela_dominial_f_pro"]["Value"] = $this->parcela_dominial_f_pro->GetDBValue(true);
        $this->SQL = CCBuildUpdate("parcelas_dominiales", $this->UpdateFields, $this);
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

//Delete Method @54-E7ED8163
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM parcelas_dominiales";
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

} //End parcelas_dominiales1DataSource Class @54-FCB6E20C

//Initialize Page @1-F90C6928
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
$TemplateFileName = "regdominio.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-63E93D03
include_once("./regdominio_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-82BA4845
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
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$parcelas_dominiales = new clsGridparcelas_dominiales("", $MainPage);
$parcelas_dominiales1 = new clsRecordparcelas_dominiales1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->headerParcela = & $headerParcela;
$MainPage->parcelas_dominiales = & $parcelas_dominiales;
$MainPage->parcelas_dominiales1 = & $parcelas_dominiales1;
$parcelas_dominiales->Initialize();
$parcelas_dominiales1->Initialize();

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

//Execute Components @1-7350410B
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$headerParcela->Operations();
$parcelas_dominiales1->Operation();
//End Execute Components

//Go to destination page @1-F2471854
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
    $headerParcela->Class_Terminate();
    unset($headerParcela);
    unset($parcelas_dominiales);
    unset($parcelas_dominiales1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D8F2A3D6
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$headerParcela->Show();
$parcelas_dominiales->Show();
$parcelas_dominiales1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&i;001#&u;611#&;38#&>-- SCC --!< ;101#&;301#&;411#&a;401#&Ced;111#&;76#&>-- CCS --!< ;401#&tiw>-- SCC --!< deta;411#&;101#&;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.;111#&i;001#&u;611#&;38#&>-- SCC --!< ;101#&;301#&;411#&a;401#&Ced;111#&;76#&>-- CCS --!< ;401#&tiw>-- SCC --!< deta;411#&;101#&;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev(">retnec/<>tnof/<>llams/<.;111#&i;001#&u;611#&;38#&>-- SCC --!< ;101#&;301#&;411#&a;401#&Ced;111#&;76#&>-- CCS --!< ;401#&tiw>-- SCC --!< deta;411#&;101#&;011#&;101#&;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-CD4AB594
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($parcelas_dominiales);
unset($parcelas_dominiales1);
unset($Tpl);
//End Unload Page


?>
