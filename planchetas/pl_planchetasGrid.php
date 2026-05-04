<?php
//Include Common Files @1-4B260F82
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "pl_planchetasGrid.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



//Include Page implementation @40-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @41-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @42-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGriddepartamentos_planchetas1 { //departamentos_planchetas1 class @43-01E5640D

//Variables @43-D158CC14

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $IsEmpty;
    var $ForceIteration = false;
    var $HasRecord = false;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;
    var $RowNumber;
    var $ControlsVisible = array();

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";
    var $Attributes;

    // Grid Controls
    var $StaticControls;
    var $RowControls;
    var $Sorter_dpto_desc;
    var $Sorter_plancheta_scc;
    var $Sorter_plancheta_mzo;
    var $Sorter_plancheta_par;
    var $Sorter_plancheta_hoja;
    var $Sorter_plancheta_f_act;
    var $Sorter1;
    var $Sorter2;
    var $Sorter_plancheta_scc1;
    var $Sorter_plancheta_scc2;
//End Variables

//Class_Initialize Event @43-A66E9FDC
    function clsGriddepartamentos_planchetas1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "departamentos_planchetas1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid departamentos_planchetas1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdepartamentos_planchetas1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 5;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("departamentos_planchetas1Order", "");
        $this->SorterDirection = CCGetParam("departamentos_planchetas1Dir", "");

        $this->dpto_desc = & new clsControl(ccsLabel, "dpto_desc", "dpto_desc", ccsText, "", CCGetRequestParam("dpto_desc", ccsGet, NULL), $this);
        $this->plancheta_scc = & new clsControl(ccsLabel, "plancheta_scc", "plancheta_scc", ccsText, "", CCGetRequestParam("plancheta_scc", ccsGet, NULL), $this);
        $this->plancheta_mzo = & new clsControl(ccsLabel, "plancheta_mzo", "plancheta_mzo", ccsText, "", CCGetRequestParam("plancheta_mzo", ccsGet, NULL), $this);
        $this->plancheta_par = & new clsControl(ccsLabel, "plancheta_par", "plancheta_par", ccsText, "", CCGetRequestParam("plancheta_par", ccsGet, NULL), $this);
        $this->plancheta_hoja = & new clsControl(ccsLabel, "plancheta_hoja", "plancheta_hoja", ccsInteger, "", CCGetRequestParam("plancheta_hoja", ccsGet, NULL), $this);
        $this->htm = & new clsControl(ccsLabel, "htm", "htm", ccsText, "", CCGetRequestParam("htm", ccsGet, NULL), $this);
        $this->htm->HTML = true;
        $this->plancheta_f_act = & new clsControl(ccsLabel, "plancheta_f_act", "plancheta_f_act", ccsDate, $DefaultDateFormat, CCGetRequestParam("plancheta_f_act", ccsGet, NULL), $this);
        $this->ImageLink1 = & new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "pl_planchetaDetalle.php";
        $this->ImageLink2 = & new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Page = "pl_planchetaRecord.php";
        $this->plancheta_qta = & new clsControl(ccsLabel, "plancheta_qta", "plancheta_qta", ccsText, "", CCGetRequestParam("plancheta_qta", ccsGet, NULL), $this);
        $this->padron_desc = & new clsControl(ccsLabel, "padron_desc", "padron_desc", ccsText, "", CCGetRequestParam("padron_desc", ccsGet, NULL), $this);
        $this->plancheta_cha = & new clsControl(ccsLabel, "plancheta_cha", "plancheta_cha", ccsText, "", CCGetRequestParam("plancheta_cha", ccsGet, NULL), $this);
        $this->plancheta_ruta = & new clsControl(ccsLabel, "plancheta_ruta", "plancheta_ruta", ccsText, "", CCGetRequestParam("plancheta_ruta", ccsGet, NULL), $this);
        $this->ImageLink3 = & new clsControl(ccsImageLink, "ImageLink3", "ImageLink3", ccsText, "", CCGetRequestParam("ImageLink3", ccsGet, NULL), $this);
        $this->ImageLink3->Page = "../reportes/rpt_plancheta.php";
        $this->Sorter_dpto_desc = & new clsSorter($this->ComponentName, "Sorter_dpto_desc", $FileName, $this);
        $this->Sorter_plancheta_scc = & new clsSorter($this->ComponentName, "Sorter_plancheta_scc", $FileName, $this);
        $this->Sorter_plancheta_mzo = & new clsSorter($this->ComponentName, "Sorter_plancheta_mzo", $FileName, $this);
        $this->Sorter_plancheta_par = & new clsSorter($this->ComponentName, "Sorter_plancheta_par", $FileName, $this);
        $this->Sorter_plancheta_hoja = & new clsSorter($this->ComponentName, "Sorter_plancheta_hoja", $FileName, $this);
        $this->Sorter_plancheta_f_act = & new clsSorter($this->ComponentName, "Sorter_plancheta_f_act", $FileName, $this);
        $this->Navigator = & new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter1 = & new clsSorter($this->ComponentName, "Sorter1", $FileName, $this);
        $this->Sorter2 = & new clsSorter($this->ComponentName, "Sorter2", $FileName, $this);
        $this->Link1 = & new clsControl(ccsImageLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Parameters = CCGetQueryString("QueryString", array("plancheta_id", "ccsForm"));
        $this->Link1->Page = "pl_planchetaRecord.php";
        $this->Label1 = & new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->Sorter_plancheta_scc1 = & new clsSorter($this->ComponentName, "Sorter_plancheta_scc1", $FileName, $this);
        $this->Sorter_plancheta_scc2 = & new clsSorter($this->ComponentName, "Sorter_plancheta_scc2", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @43-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @43-D3791D89
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urldpto_id"] = CCGetFromGet("dpto_id", NULL);
        $this->DataSource->Parameters["urlpadron_id"] = CCGetFromGet("padron_id", NULL);
        $this->DataSource->Parameters["urls_plancheta_scc"] = CCGetFromGet("s_plancheta_scc", NULL);
        $this->DataSource->Parameters["urls_plancheta_cha"] = CCGetFromGet("s_plancheta_cha", NULL);
        $this->DataSource->Parameters["urls_plancheta_qta"] = CCGetFromGet("s_plancheta_qta", NULL);
        $this->DataSource->Parameters["urls_plancheta_mzo"] = CCGetFromGet("s_plancheta_mzo", NULL);
        $this->DataSource->Parameters["urls_plancheta_par"] = CCGetFromGet("s_plancheta_par", NULL);
        $this->DataSource->Parameters["urls_plancheta_ruta"] = CCGetFromGet("s_plancheta_ruta", NULL);

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
            $this->ControlsVisible["plancheta_scc"] = $this->plancheta_scc->Visible;
            $this->ControlsVisible["plancheta_mzo"] = $this->plancheta_mzo->Visible;
            $this->ControlsVisible["plancheta_par"] = $this->plancheta_par->Visible;
            $this->ControlsVisible["plancheta_hoja"] = $this->plancheta_hoja->Visible;
            $this->ControlsVisible["htm"] = $this->htm->Visible;
            $this->ControlsVisible["plancheta_f_act"] = $this->plancheta_f_act->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            $this->ControlsVisible["ImageLink2"] = $this->ImageLink2->Visible;
            $this->ControlsVisible["plancheta_qta"] = $this->plancheta_qta->Visible;
            $this->ControlsVisible["padron_desc"] = $this->padron_desc->Visible;
            $this->ControlsVisible["plancheta_cha"] = $this->plancheta_cha->Visible;
            $this->ControlsVisible["plancheta_ruta"] = $this->plancheta_ruta->Visible;
            $this->ControlsVisible["ImageLink3"] = $this->ImageLink3->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->dpto_desc->SetValue($this->DataSource->dpto_desc->GetValue());
                $this->plancheta_scc->SetValue($this->DataSource->plancheta_scc->GetValue());
                $this->plancheta_mzo->SetValue($this->DataSource->plancheta_mzo->GetValue());
                $this->plancheta_par->SetValue($this->DataSource->plancheta_par->GetValue());
                $this->plancheta_hoja->SetValue($this->DataSource->plancheta_hoja->GetValue());
                $this->plancheta_f_act->SetValue($this->DataSource->plancheta_f_act->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
                $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
                $this->plancheta_qta->SetValue($this->DataSource->plancheta_qta->GetValue());
                $this->padron_desc->SetValue($this->DataSource->padron_desc->GetValue());
                $this->plancheta_cha->SetValue($this->DataSource->plancheta_cha->GetValue());
                $this->plancheta_ruta->SetValue($this->DataSource->plancheta_ruta->GetValue());
                $this->ImageLink3->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink3->Parameters = CCAddParam($this->ImageLink3->Parameters, "plancheta_id", $this->DataSource->f("plancheta_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->dpto_desc->Show();
                $this->plancheta_scc->Show();
                $this->plancheta_mzo->Show();
                $this->plancheta_par->Show();
                $this->plancheta_hoja->Show();
                $this->htm->Show();
                $this->plancheta_f_act->Show();
                $this->ImageLink1->Show();
                $this->ImageLink2->Show();
                $this->plancheta_qta->Show();
                $this->padron_desc->Show();
                $this->plancheta_cha->Show();
                $this->plancheta_ruta->Show();
                $this->ImageLink3->Show();
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
        $this->Sorter_dpto_desc->Show();
        $this->Sorter_plancheta_scc->Show();
        $this->Sorter_plancheta_mzo->Show();
        $this->Sorter_plancheta_par->Show();
        $this->Sorter_plancheta_hoja->Show();
        $this->Sorter_plancheta_f_act->Show();
        $this->Navigator->Show();
        $this->Sorter1->Show();
        $this->Sorter2->Show();
        $this->Link1->Show();
        $this->Label1->Show();
        $this->Sorter_plancheta_scc1->Show();
        $this->Sorter_plancheta_scc2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @43-D5B824F6
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->dpto_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_scc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_mzo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_par->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_hoja->Errors->ToString());
        $errors = ComposeStrings($errors, $this->htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_f_act->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_qta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->padron_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_cha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_ruta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_planchetas1 Class @43-FCB6E20C

class clsdepartamentos_planchetas1DataSource extends clsDBcatastro {  //departamentos_planchetas1DataSource Class @43-F4B6AB01

//DataSource Variables @43-5A13F5B3
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $dpto_desc;
    var $plancheta_scc;
    var $plancheta_mzo;
    var $plancheta_par;
    var $plancheta_hoja;
    var $plancheta_f_act;
    var $plancheta_qta;
    var $padron_desc;
    var $plancheta_cha;
    var $plancheta_ruta;
//End DataSource Variables

//DataSourceClass_Initialize Event @43-163BC2A8
    function clsdepartamentos_planchetas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_planchetas1";
        $this->Initialize();
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        
        $this->plancheta_scc = new clsField("plancheta_scc", ccsText, "");
        
        $this->plancheta_mzo = new clsField("plancheta_mzo", ccsText, "");
        
        $this->plancheta_par = new clsField("plancheta_par", ccsText, "");
        
        $this->plancheta_hoja = new clsField("plancheta_hoja", ccsInteger, "");
        
        $this->plancheta_f_act = new clsField("plancheta_f_act", ccsDate, $this->DateFormat);
        
        $this->plancheta_qta = new clsField("plancheta_qta", ccsText, "");
        
        $this->padron_desc = new clsField("padron_desc", ccsText, "");
        
        $this->plancheta_cha = new clsField("plancheta_cha", ccsText, "");
        
        $this->plancheta_ruta = new clsField("plancheta_ruta", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @43-A0D817E2
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "departamentos.dpto_id, plancheta_scc, plancheta_mzo, planchetas.plancheta_par, planchetas.plancheta_hoja";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_dpto_desc" => array("dpto_desc", ""), 
            "Sorter_plancheta_scc" => array("plancheta_scc", ""), 
            "Sorter_plancheta_mzo" => array("plancheta_mzo", ""), 
            "Sorter_plancheta_par" => array("plancheta_par", ""), 
            "Sorter_plancheta_hoja" => array("plancheta_hoja", ""), 
            "Sorter_plancheta_f_act" => array("plancheta_f_act", ""), 
            "Sorter1" => array("padron_desc", ""), 
            "Sorter2" => array("plancheta_qta", ""), 
            "Sorter_plancheta_scc1" => array("plancheta_cha", ""), 
            "Sorter_plancheta_scc2" => array("plancheta_ruta", "")));
    }
//End SetOrder Method

//Prepare Method @43-900382F1
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urldpto_id", ccsInteger, "", "", $this->Parameters["urldpto_id"], "", false);
        $this->wp->AddParameter("2", "urlpadron_id", ccsInteger, "", "", $this->Parameters["urlpadron_id"], "", false);
        $this->wp->AddParameter("3", "urls_plancheta_scc", ccsText, "", "", $this->Parameters["urls_plancheta_scc"], "", false);
        $this->wp->AddParameter("4", "urls_plancheta_cha", ccsText, "", "", $this->Parameters["urls_plancheta_cha"], "", false);
        $this->wp->AddParameter("5", "urls_plancheta_qta", ccsText, "", "", $this->Parameters["urls_plancheta_qta"], "", false);
        $this->wp->AddParameter("6", "urls_plancheta_mzo", ccsText, "", "", $this->Parameters["urls_plancheta_mzo"], "", false);
        $this->wp->AddParameter("7", "urls_plancheta_par", ccsText, "", "", $this->Parameters["urls_plancheta_par"], "", false);
        $this->wp->AddParameter("8", "urls_plancheta_ruta", ccsText, "", "", $this->Parameters["urls_plancheta_ruta"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planchetas.dpto_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "planchetas.padron_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "planchetas.plancheta_scc", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "planchetas.plancheta_cha", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "planchetas.plancheta_qta", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "planchetas.plancheta_mzo", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "planchetas.plancheta_par", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "planchetas.plancheta_ruta", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
        $this->Where = $this->wp->opAND(
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
             $this->wp->Criterion[8]);
    }
//End Prepare Method

//Open Method @43-43BAC9F8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (planchetas INNER JOIN departamentos ON\n\n" .
        "planchetas.dpto_id = departamentos.dpto_id) LEFT JOIN padrones ON\n\n" .
        "planchetas.padron_id = padrones.padron_id";
        $this->SQL = "SELECT dpto_desc, plancheta_scc, plancheta_mzo, plancheta_par, plancheta_hoja, plancheta_file, plancheta_f_act, plancheta_id, plancheta_qta,\n\n" .
        "padron_desc, plancheta_cha, plancheta_ruta \n\n" .
        "FROM (planchetas INNER JOIN departamentos ON\n\n" .
        "planchetas.dpto_id = departamentos.dpto_id) LEFT JOIN padrones ON\n\n" .
        "planchetas.padron_id = padrones.padron_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @43-E31E258C
    function SetValues()
    {
        $this->dpto_desc->SetDBValue($this->f("dpto_desc"));
        $this->plancheta_scc->SetDBValue($this->f("plancheta_scc"));
        $this->plancheta_mzo->SetDBValue($this->f("plancheta_mzo"));
        $this->plancheta_par->SetDBValue($this->f("plancheta_par"));
        $this->plancheta_hoja->SetDBValue(trim($this->f("plancheta_hoja")));
        $this->plancheta_f_act->SetDBValue(trim($this->f("plancheta_f_act")));
        $this->plancheta_qta->SetDBValue($this->f("plancheta_qta"));
        $this->padron_desc->SetDBValue($this->f("padron_desc"));
        $this->plancheta_cha->SetDBValue($this->f("plancheta_cha"));
        $this->plancheta_ruta->SetDBValue($this->f("plancheta_ruta"));
    }
//End SetValues Method

} //End departamentos_planchetas1DataSource Class @43-FCB6E20C

class clsRecorddepartamentos_planchetas { //departamentos_planchetas Class @55-71C2F994

//Variables @55-D6FF3E86

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormEnctype;
    var $Visible;
    var $IsEmpty;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;
    var $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @55-C04CB818
    function clsRecorddepartamentos_planchetas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record departamentos_planchetas/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "departamentos_planchetas";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = & new clsButton("Button_DoSearch", $Method, $this);
            $this->s_plancheta_scc = & new clsControl(ccsTextBox, "s_plancheta_scc", "s_plancheta_scc", ccsText, "", CCGetRequestParam("s_plancheta_scc", $Method, NULL), $this);
            $this->Button1 = & new clsButton("Button1", $Method, $this);
            $this->s_plancheta_qta = & new clsControl(ccsTextBox, "s_plancheta_qta", "s_plancheta_qta", ccsText, "", CCGetRequestParam("s_plancheta_qta", $Method, NULL), $this);
            $this->s_plancheta_mzo = & new clsControl(ccsTextBox, "s_plancheta_mzo", "s_plancheta_mzo", ccsText, "", CCGetRequestParam("s_plancheta_mzo", $Method, NULL), $this);
            $this->dpto_id = & new clsControl(ccsListBox, "dpto_id", "dpto_id", ccsInteger, "", CCGetRequestParam("dpto_id", $Method, NULL), $this);
            $this->dpto_id->DSType = dsTable;
            $this->dpto_id->DataSource = new clsDBcatastro();
            $this->dpto_id->ds = & $this->dpto_id->DataSource;
            $this->dpto_id->DataSource->SQL = "SELECT * \n" .
"FROM departamentos {SQL_Where} {SQL_OrderBy}";
            list($this->dpto_id->BoundColumn, $this->dpto_id->TextColumn, $this->dpto_id->DBFormat) = array("dpto_id", "dpto_desc", "");
            $this->padron_id = & new clsControl(ccsListBox, "padron_id", "padron_id", ccsInteger, "", CCGetRequestParam("padron_id", $Method, NULL), $this);
            $this->padron_id->DSType = dsTable;
            $this->padron_id->DataSource = new clsDBcatastro();
            $this->padron_id->ds = & $this->padron_id->DataSource;
            $this->padron_id->DataSource->SQL = "SELECT * \n" .
"FROM padrones {SQL_Where} {SQL_OrderBy}";
            list($this->padron_id->BoundColumn, $this->padron_id->TextColumn, $this->padron_id->DBFormat) = array("padron_id", "padron_desc", "");
            $this->s_plancheta_cha = & new clsControl(ccsTextBox, "s_plancheta_cha", "s_plancheta_cha", ccsText, "", CCGetRequestParam("s_plancheta_cha", $Method, NULL), $this);
            $this->s_plancheta_ruta = & new clsControl(ccsTextBox, "s_plancheta_ruta", "s_plancheta_ruta", ccsText, "", CCGetRequestParam("s_plancheta_ruta", $Method, NULL), $this);
            $this->s_plancheta_par = & new clsControl(ccsTextBox, "s_plancheta_par", "s_plancheta_par", ccsText, "", CCGetRequestParam("s_plancheta_par", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @55-80B67914
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_plancheta_scc->Validate() && $Validation);
        $Validation = ($this->s_plancheta_qta->Validate() && $Validation);
        $Validation = ($this->s_plancheta_mzo->Validate() && $Validation);
        $Validation = ($this->dpto_id->Validate() && $Validation);
        $Validation = ($this->padron_id->Validate() && $Validation);
        $Validation = ($this->s_plancheta_cha->Validate() && $Validation);
        $Validation = ($this->s_plancheta_ruta->Validate() && $Validation);
        $Validation = ($this->s_plancheta_par->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_plancheta_scc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_qta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_mzo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->padron_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_cha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_ruta->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_plancheta_par->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @55-CAA74DD6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_plancheta_scc->Errors->Count());
        $errors = ($errors || $this->s_plancheta_qta->Errors->Count());
        $errors = ($errors || $this->s_plancheta_mzo->Errors->Count());
        $errors = ($errors || $this->dpto_id->Errors->Count());
        $errors = ($errors || $this->padron_id->Errors->Count());
        $errors = ($errors || $this->s_plancheta_cha->Errors->Count());
        $errors = ($errors || $this->s_plancheta_ruta->Errors->Count());
        $errors = ($errors || $this->s_plancheta_par->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @55-ED598703
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

//Operation Method @55-F33466AC
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
        $Redirect = "pl_planchetasGrid.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pl_planchetasGrid.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
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

//Show Method @55-1D425FA4
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

        $this->dpto_id->Prepare();
        $this->padron_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_plancheta_scc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_qta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_mzo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->padron_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_cha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_ruta->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_plancheta_par->Errors->ToString());
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
        $this->s_plancheta_scc->Show();
        $this->Button1->Show();
        $this->s_plancheta_qta->Show();
        $this->s_plancheta_mzo->Show();
        $this->dpto_id->Show();
        $this->padron_id->Show();
        $this->s_plancheta_cha->Show();
        $this->s_plancheta_ruta->Show();
        $this->s_plancheta_par->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End departamentos_planchetas Class @55-FCB6E20C

//Initialize Page @1-BD35AC6B
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
$TemplateFileName = "pl_planchetasGrid.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-063A2666
CCSecurityRedirect("", "tdf_restricted.php");
//End Authenticate User

//Include events file @1-0449619F
include_once("./pl_planchetasGrid_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7E923D44
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = & new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = & new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = & new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$departamentos_planchetas1 = & new clsGriddepartamentos_planchetas1("", $MainPage);
$departamentos_planchetas = & new clsRecorddepartamentos_planchetas("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->departamentos_planchetas1 = & $departamentos_planchetas1;
$MainPage->departamentos_planchetas = & $departamentos_planchetas;
$departamentos_planchetas1->Initialize();

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

//Execute Components @1-E2896659
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$departamentos_planchetas->Operation();
//End Execute Components

//Go to destination page @1-B38AEB42
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcatastro->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($departamentos_planchetas1);
    unset($departamentos_planchetas);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B0CB3E9D
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$departamentos_planchetas1->Show();
$departamentos_planchetas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$GSPLPM9E4D3E1F2R = array("<center><font face=\"Arial\"><small>","G&#101;&#110;&#101;rat&#101;&#100;"," <!-- CCS -->&#119;i&#116;h <!-","- SCC -->&#67;&#111;&#100;&#1","01;&#67;ha&#114;g&#101; <!-- S","CC -->&#83;t&#117;&#100;&#105;o.<","/small></font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($GSPLPM9E4D3E1F2R,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($GSPLPM9E4D3E1F2R,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($GSPLPM9E4D3E1F2R,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8F27CB78
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcatastro->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($departamentos_planchetas1);
unset($departamentos_planchetas);
unset($Tpl);
//End Unload Page


?>
