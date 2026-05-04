<?php
//Include Common Files @1-FB726108
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "union.php");
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

class clsGridparcelas { //parcelas class @8-C47EAFDB

//Variables @8-BE6E787F

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
    public $Sorter_parcela_id;
    public $Sorter_parcela_partida;
    public $Sorter_parcela_nomenclatura;
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

//Class_Initialize Event @8-94844756
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
            $this->PageSize = 10;
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

        $this->parcela_id = new clsControl(ccsLink, "parcela_id", "parcela_id", ccsInteger, "", CCGetRequestParam("parcela_id", ccsGet, NULL), $this);
        $this->parcela_id->Page = "";
        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsInteger, "", CCGetRequestParam("parcela_partida", ccsGet, NULL), $this);
        $this->parcela_nomenclatura = new clsControl(ccsLabel, "parcela_nomenclatura", "parcela_nomenclatura", ccsText, "", CCGetRequestParam("parcela_nomenclatura", ccsGet, NULL), $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", ccsGet, NULL), $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", ccsGet, NULL), $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", ccsGet, NULL), $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", ccsGet, NULL), $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", ccsGet, NULL), $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", ccsGet, NULL), $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", ccsGet, NULL), $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "parcela_predio", ccsText, "", CCGetRequestParam("parcela_predio", ccsGet, NULL), $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "parcela_rte", ccsText, "", CCGetRequestParam("parcela_rte", ccsGet, NULL), $this);
        $this->parcela_super_mensura = new clsControl(ccsLabel, "parcela_super_mensura", "parcela_super_mensura", ccsText, "", CCGetRequestParam("parcela_super_mensura", ccsGet, NULL), $this);
        $this->Sorter_parcela_id = new clsSorter($this->ComponentName, "Sorter_parcela_id", $FileName, $this);
        $this->Sorter_parcela_partida = new clsSorter($this->ComponentName, "Sorter_parcela_partida", $FileName, $this);
        $this->Sorter_parcela_nomenclatura = new clsSorter($this->ComponentName, "Sorter_parcela_nomenclatura", $FileName, $this);
        $this->Sorter_parcela_seccion = new clsSorter($this->ComponentName, "Sorter_parcela_seccion", $FileName, $this);
        $this->Sorter_parcela_macizo = new clsSorter($this->ComponentName, "Sorter_parcela_macizo", $FileName, $this);
        $this->Sorter_parcela_parcela = new clsSorter($this->ComponentName, "Sorter_parcela_parcela", $FileName, $this);
        $this->Sorter_parcela_chacra = new clsSorter($this->ComponentName, "Sorter_parcela_chacra", $FileName, $this);
        $this->Sorter_parcela_quinta = new clsSorter($this->ComponentName, "Sorter_parcela_quinta", $FileName, $this);
        $this->Sorter_parcela_fraccion = new clsSorter($this->ComponentName, "Sorter_parcela_fraccion", $FileName, $this);
        $this->Sorter_parcela_uf = new clsSorter($this->ComponentName, "Sorter_parcela_uf", $FileName, $this);
        $this->Sorter_parcela_predio = new clsSorter($this->ComponentName, "Sorter_parcela_predio", $FileName, $this);
        $this->Sorter_parcela_rte = new clsSorter($this->ComponentName, "Sorter_parcela_rte", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @8-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @8-4CE41CFF
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_parcela_id"] = CCGetFromGet("s_parcela_id", NULL);
        $this->DataSource->Parameters["urls_parcela_partida"] = CCGetFromGet("s_parcela_partida", NULL);
        $this->DataSource->Parameters["urls_parcela_nomenclatura"] = CCGetFromGet("s_parcela_nomenclatura", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion"] = CCGetFromGet("s_parcela_seccion", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo"] = CCGetFromGet("s_parcela_macizo", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela"] = CCGetFromGet("s_parcela_parcela", NULL);
        $this->DataSource->Parameters["urls_parcela_chacra"] = CCGetFromGet("s_parcela_chacra", NULL);
        $this->DataSource->Parameters["urls_parcela_quinta"] = CCGetFromGet("s_parcela_quinta", NULL);
        $this->DataSource->Parameters["urls_parcela_fraccion"] = CCGetFromGet("s_parcela_fraccion", NULL);
        $this->DataSource->Parameters["urls_parcela_uf"] = CCGetFromGet("s_parcela_uf", NULL);
        $this->DataSource->Parameters["urls_parcela_predio"] = CCGetFromGet("s_parcela_predio", NULL);

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
            $this->ControlsVisible["parcela_id"] = $this->parcela_id->Visible;
            $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
            $this->ControlsVisible["parcela_nomenclatura"] = $this->parcela_nomenclatura->Visible;
            $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
            $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
            $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
            $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
            $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
            $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
            $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
            $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
            $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
            $this->ControlsVisible["parcela_super_mensura"] = $this->parcela_super_mensura->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                $this->parcela_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->parcela_id->Parameters = CCAddParam($this->parcela_id->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                $this->parcela_nomenclatura->SetValue($this->DataSource->parcela_nomenclatura->GetValue());
                $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                $this->parcela_super_mensura->SetValue($this->DataSource->parcela_super_mensura->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_id->Show();
                $this->parcela_partida->Show();
                $this->parcela_nomenclatura->Show();
                $this->parcela_seccion->Show();
                $this->parcela_macizo->Show();
                $this->parcela_parcela->Show();
                $this->parcela_chacra->Show();
                $this->parcela_quinta->Show();
                $this->parcela_fraccion->Show();
                $this->parcela_uf->Show();
                $this->parcela_predio->Show();
                $this->parcela_rte->Show();
                $this->parcela_super_mensura->Show();
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
        $this->Sorter_parcela_id->Show();
        $this->Sorter_parcela_partida->Show();
        $this->Sorter_parcela_nomenclatura->Show();
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

//GetErrors Method @8-49A6EE17
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->parcela_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_nomenclatura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_predio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_rte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_super_mensura->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End parcelas Class @8-FCB6E20C

class clsparcelasDataSource extends clsDBtdf_nuevo {  //parcelasDataSource Class @8-DA23B507

//DataSource Variables @8-418511F0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $parcela_id;
    public $parcela_partida;
    public $parcela_nomenclatura;
    public $parcela_seccion;
    public $parcela_macizo;
    public $parcela_parcela;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_fraccion;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $parcela_super_mensura;
//End DataSource Variables

//DataSourceClass_Initialize Event @8-49A93306
    function clsparcelasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid parcelas";
        $this->Initialize();
        $this->parcela_id = new clsField("parcela_id", ccsInteger, "");
        
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_nomenclatura = new clsField("parcela_nomenclatura", ccsText, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->parcela_super_mensura = new clsField("parcela_super_mensura", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @8-C9731A2B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_parcela_id" => array("parcela_id", ""), 
            "Sorter_parcela_partida" => array("parcela_partida", ""), 
            "Sorter_parcela_nomenclatura" => array("parcela_nomenclatura", ""), 
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

//Prepare Method @8-D1AECD08
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_parcela_id", ccsInteger, "", "", $this->Parameters["urls_parcela_id"], "", false);
        $this->wp->AddParameter("2", "urls_parcela_partida", ccsInteger, "", "", $this->Parameters["urls_parcela_partida"], "", false);
        $this->wp->AddParameter("3", "urls_parcela_nomenclatura", ccsText, "", "", $this->Parameters["urls_parcela_nomenclatura"], "", false);
        $this->wp->AddParameter("4", "urls_parcela_seccion", ccsText, "", "", $this->Parameters["urls_parcela_seccion"], "", false);
        $this->wp->AddParameter("5", "urls_parcela_macizo", ccsText, "", "", $this->Parameters["urls_parcela_macizo"], "", false);
        $this->wp->AddParameter("6", "urls_parcela_parcela", ccsText, "", "", $this->Parameters["urls_parcela_parcela"], "", false);
        $this->wp->AddParameter("7", "urls_parcela_chacra", ccsText, "", "", $this->Parameters["urls_parcela_chacra"], "", false);
        $this->wp->AddParameter("8", "urls_parcela_quinta", ccsText, "", "", $this->Parameters["urls_parcela_quinta"], "", false);
        $this->wp->AddParameter("9", "urls_parcela_fraccion", ccsText, "", "", $this->Parameters["urls_parcela_fraccion"], "", false);
        $this->wp->AddParameter("10", "urls_parcela_uf", ccsText, "", "", $this->Parameters["urls_parcela_uf"], "", false);
        $this->wp->AddParameter("11", "urls_parcela_predio", ccsText, "", "", $this->Parameters["urls_parcela_predio"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "parcela_partida", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "parcela_nomenclatura", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "parcela_seccion", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "parcela_macizo", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "parcela_parcela", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opContains, "parcela_chacra", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opContains, "parcela_quinta", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opContains, "parcela_fraccion", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsText),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opContains, "parcela_uf", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opContains, "parcela_predio", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
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
             $this->wp->Criterion[11]);
    }
//End Prepare Method

//Open Method @8-6E2C0151
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

//SetValues Method @8-F22221CE
    function SetValues()
    {
        $this->parcela_id->SetDBValue(trim($this->f("parcela_id")));
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_nomenclatura->SetDBValue($this->f("parcela_nomenclatura"));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->parcela_super_mensura->SetDBValue($this->f("parcela_super_mensura"));
    }
//End SetValues Method

} //End parcelasDataSource Class @8-FCB6E20C

class clsRecordparcelasSearch { //parcelasSearch Class @9-CBAE5345

//Variables @9-9E315808

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

//Class_Initialize Event @9-4EB3FC66
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
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_parcela_id = new clsControl(ccsTextBox, "s_parcela_id", "s_parcela_id", ccsInteger, "", CCGetRequestParam("s_parcela_id", $Method, NULL), $this);
            $this->s_parcela_partida = new clsControl(ccsTextBox, "s_parcela_partida", "s_parcela_partida", ccsInteger, "", CCGetRequestParam("s_parcela_partida", $Method, NULL), $this);
            $this->s_parcela_nomenclatura = new clsControl(ccsTextBox, "s_parcela_nomenclatura", "s_parcela_nomenclatura", ccsText, "", CCGetRequestParam("s_parcela_nomenclatura", $Method, NULL), $this);
            $this->s_parcela_seccion = new clsControl(ccsTextBox, "s_parcela_seccion", "s_parcela_seccion", ccsText, "", CCGetRequestParam("s_parcela_seccion", $Method, NULL), $this);
            $this->s_parcela_macizo = new clsControl(ccsTextBox, "s_parcela_macizo", "s_parcela_macizo", ccsText, "", CCGetRequestParam("s_parcela_macizo", $Method, NULL), $this);
            $this->s_parcela_parcela = new clsControl(ccsTextBox, "s_parcela_parcela", "s_parcela_parcela", ccsText, "", CCGetRequestParam("s_parcela_parcela", $Method, NULL), $this);
            $this->s_parcela_chacra = new clsControl(ccsTextBox, "s_parcela_chacra", "s_parcela_chacra", ccsText, "", CCGetRequestParam("s_parcela_chacra", $Method, NULL), $this);
            $this->s_parcela_quinta = new clsControl(ccsTextBox, "s_parcela_quinta", "s_parcela_quinta", ccsText, "", CCGetRequestParam("s_parcela_quinta", $Method, NULL), $this);
            $this->s_parcela_fraccion = new clsControl(ccsTextBox, "s_parcela_fraccion", "s_parcela_fraccion", ccsText, "", CCGetRequestParam("s_parcela_fraccion", $Method, NULL), $this);
            $this->s_parcela_uf = new clsControl(ccsTextBox, "s_parcela_uf", "s_parcela_uf", ccsText, "", CCGetRequestParam("s_parcela_uf", $Method, NULL), $this);
            $this->s_parcela_predio = new clsControl(ccsTextBox, "s_parcela_predio", "s_parcela_predio", ccsText, "", CCGetRequestParam("s_parcela_predio", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @9-EC9C5EE3
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_parcela_id->Validate() && $Validation);
        $Validation = ($this->s_parcela_partida->Validate() && $Validation);
        $Validation = ($this->s_parcela_nomenclatura->Validate() && $Validation);
        $Validation = ($this->s_parcela_seccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela->Validate() && $Validation);
        $Validation = ($this->s_parcela_chacra->Validate() && $Validation);
        $Validation = ($this->s_parcela_quinta->Validate() && $Validation);
        $Validation = ($this->s_parcela_fraccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_uf->Validate() && $Validation);
        $Validation = ($this->s_parcela_predio->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_parcela_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_partida->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_nomenclatura->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_chacra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_quinta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_fraccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_uf->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_predio->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @9-131BA0B8
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_parcela_id->Errors->Count());
        $errors = ($errors || $this->s_parcela_partida->Errors->Count());
        $errors = ($errors || $this->s_parcela_nomenclatura->Errors->Count());
        $errors = ($errors || $this->s_parcela_seccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela->Errors->Count());
        $errors = ($errors || $this->s_parcela_chacra->Errors->Count());
        $errors = ($errors || $this->s_parcela_quinta->Errors->Count());
        $errors = ($errors || $this->s_parcela_fraccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_uf->Errors->Count());
        $errors = ($errors || $this->s_parcela_predio->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @9-ED598703
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

//Operation Method @9-DD94EE4C
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

//Show Method @9-64F995E8
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
            $Error = ComposeStrings($Error, $this->s_parcela_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_partida->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_nomenclatura->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_chacra->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_quinta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_fraccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_uf->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_predio->Errors->ToString());
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
        $this->s_parcela_id->Show();
        $this->s_parcela_partida->Show();
        $this->s_parcela_nomenclatura->Show();
        $this->s_parcela_seccion->Show();
        $this->s_parcela_macizo->Show();
        $this->s_parcela_parcela->Show();
        $this->s_parcela_chacra->Show();
        $this->s_parcela_quinta->Show();
        $this->s_parcela_fraccion->Show();
        $this->s_parcela_uf->Show();
        $this->s_parcela_predio->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End parcelasSearch Class @9-FCB6E20C





//Initialize Page @1-09817525
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
$TemplateFileName = "union.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-C4C61A7A
include_once("./union_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-42FCEE46
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
$parcelas = new clsGridparcelas("", $MainPage);
$parcelasSearch = new clsRecordparcelasSearch("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->parcelas = & $parcelas;
$MainPage->parcelasSearch = & $parcelasSearch;
$parcelas->Initialize();

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

//Go to destination page @1-7BC5670D
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
    unset($parcelas);
    unset($parcelasSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-06EB485F
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$parcelas->Show();
$parcelasSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font", " face=\"Arial\"><sma", "ll>G&#101;&#110;&", "#101;&#114;at&#1", "01;&#100; <!--", " CCS -->&#119;&", "#105;&#116;h <", "!-- CCS -->&#67", ";ode&#67;h&#97;rg&", "#101; <!-- SCC --", ">S&#116;ud&#105;", "&#111;.</small></f", "ont></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font", " face=\"Arial\"><sma", "ll>G&#101;&#110;&", "#101;&#114;at&#1", "01;&#100; <!--", " CCS -->&#119;&", "#105;&#116;h <", "!-- CCS -->&#67", ";ode&#67;h&#97;rg&", "#101; <!-- SCC --", ">S&#116;ud&#105;", "&#111;.</small></f", "ont></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font", " face=\"Arial\"><sma", "ll>G&#101;&#110;&", "#101;&#114;at&#1", "01;&#100; <!--", " CCS -->&#119;&", "#105;&#116;h <", "!-- CCS -->&#67", ";ode&#67;h&#97;rg&", "#101; <!-- SCC --", ">S&#116;ud&#105;", "&#111;.</small></f", "ont></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-DFBC6C57
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelas);
unset($parcelasSearch);
unset($Tpl);
//End Unload Page


?>
