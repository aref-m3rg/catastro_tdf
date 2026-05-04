<?php
//Include Common Files @1-9829D919
define("RelativePath", "..");
define("PathToCurrentPage", "/planchetas/");
define("FileName", "pl_planchetaDetalle.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGriddepartamentos_planchetas { //departamentos_planchetas class @2-A776D392

//Variables @2-AC1EDBB9

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
//End Variables

//Class_Initialize Event @2-F91E9329
    function clsGriddepartamentos_planchetas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "departamentos_planchetas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid departamentos_planchetas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsdepartamentos_planchetasDataSource($this);
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

        $this->dpto_desc = & new clsControl(ccsLabel, "dpto_desc", "dpto_desc", ccsText, "", CCGetRequestParam("dpto_desc", ccsGet, NULL), $this);
        $this->plancheta_scc = & new clsControl(ccsLabel, "plancheta_scc", "plancheta_scc", ccsText, "", CCGetRequestParam("plancheta_scc", ccsGet, NULL), $this);
        $this->plancheta_mzo = & new clsControl(ccsLabel, "plancheta_mzo", "plancheta_mzo", ccsText, "", CCGetRequestParam("plancheta_mzo", ccsGet, NULL), $this);
        $this->plancheta_par = & new clsControl(ccsLabel, "plancheta_par", "plancheta_par", ccsText, "", CCGetRequestParam("plancheta_par", ccsGet, NULL), $this);
        $this->plancheta_hoja = & new clsControl(ccsLabel, "plancheta_hoja", "plancheta_hoja", ccsInteger, "", CCGetRequestParam("plancheta_hoja", ccsGet, NULL), $this);
        $this->plancheta_obs = & new clsControl(ccsLabel, "plancheta_obs", "plancheta_obs", ccsText, "", CCGetRequestParam("plancheta_obs", ccsGet, NULL), $this);
        $this->plancheta_f_act = & new clsControl(ccsLabel, "plancheta_f_act", "plancheta_f_act", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("plancheta_f_act", ccsGet, NULL), $this);
        $this->htm = & new clsControl(ccsLabel, "htm", "htm", ccsText, "", CCGetRequestParam("htm", ccsGet, NULL), $this);
        $this->htm->HTML = true;
        $this->padron_desc = & new clsControl(ccsLabel, "padron_desc", "padron_desc", ccsText, "", CCGetRequestParam("padron_desc", ccsGet, NULL), $this);
        $this->plancheta_cha = & new clsControl(ccsLabel, "plancheta_cha", "plancheta_cha", ccsText, "", CCGetRequestParam("plancheta_cha", ccsGet, NULL), $this);
        $this->plancheta_qta = & new clsControl(ccsLabel, "plancheta_qta", "plancheta_qta", ccsText, "", CCGetRequestParam("plancheta_qta", ccsGet, NULL), $this);
        $this->plancheta_ruta = & new clsControl(ccsLabel, "plancheta_ruta", "plancheta_ruta", ccsText, "", CCGetRequestParam("plancheta_ruta", ccsGet, NULL), $this);
        $this->ImageLink1 = & new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("plancheta_id", "ccsForm"));
        $this->ImageLink1->Page = "pl_planchetasGrid.php";
        $this->ImageLink2 = & new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "plancheta_id", CCGetFromGet("plancheta_id", NULL));
        $this->ImageLink2->Page = "pl_planchetaRecord.php";
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-4E54F274
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlplancheta_id"] = CCGetFromGet("plancheta_id", NULL);

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
            $this->ControlsVisible["plancheta_obs"] = $this->plancheta_obs->Visible;
            $this->ControlsVisible["plancheta_f_act"] = $this->plancheta_f_act->Visible;
            $this->ControlsVisible["htm"] = $this->htm->Visible;
            $this->ControlsVisible["padron_desc"] = $this->padron_desc->Visible;
            $this->ControlsVisible["plancheta_cha"] = $this->plancheta_cha->Visible;
            $this->ControlsVisible["plancheta_qta"] = $this->plancheta_qta->Visible;
            $this->ControlsVisible["plancheta_ruta"] = $this->plancheta_ruta->Visible;
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
                $this->plancheta_obs->SetValue($this->DataSource->plancheta_obs->GetValue());
                $this->plancheta_f_act->SetValue($this->DataSource->plancheta_f_act->GetValue());
                $this->padron_desc->SetValue($this->DataSource->padron_desc->GetValue());
                $this->plancheta_cha->SetValue($this->DataSource->plancheta_cha->GetValue());
                $this->plancheta_qta->SetValue($this->DataSource->plancheta_qta->GetValue());
                $this->plancheta_ruta->SetValue($this->DataSource->plancheta_ruta->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->dpto_desc->Show();
                $this->plancheta_scc->Show();
                $this->plancheta_mzo->Show();
                $this->plancheta_par->Show();
                $this->plancheta_hoja->Show();
                $this->plancheta_obs->Show();
                $this->plancheta_f_act->Show();
                $this->htm->Show();
                $this->padron_desc->Show();
                $this->plancheta_cha->Show();
                $this->plancheta_qta->Show();
                $this->plancheta_ruta->Show();
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
        $this->ImageLink1->Show();
        $this->ImageLink2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-BF8411DC
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->dpto_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_scc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_mzo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_par->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_hoja->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_obs->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_f_act->Errors->ToString());
        $errors = ComposeStrings($errors, $this->htm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->padron_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_cha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_qta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plancheta_ruta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End departamentos_planchetas Class @2-FCB6E20C

class clsdepartamentos_planchetasDataSource extends clsDBcatastro {  //departamentos_planchetasDataSource Class @2-69066618

//DataSource Variables @2-116C5A12
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
    var $plancheta_obs;
    var $plancheta_f_act;
    var $padron_desc;
    var $plancheta_cha;
    var $plancheta_qta;
    var $plancheta_ruta;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-1C171781
    function clsdepartamentos_planchetasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid departamentos_planchetas";
        $this->Initialize();
        $this->dpto_desc = new clsField("dpto_desc", ccsText, "");
        
        $this->plancheta_scc = new clsField("plancheta_scc", ccsText, "");
        
        $this->plancheta_mzo = new clsField("plancheta_mzo", ccsText, "");
        
        $this->plancheta_par = new clsField("plancheta_par", ccsText, "");
        
        $this->plancheta_hoja = new clsField("plancheta_hoja", ccsInteger, "");
        
        $this->plancheta_obs = new clsField("plancheta_obs", ccsText, "");
        
        $this->plancheta_f_act = new clsField("plancheta_f_act", ccsDate, $this->DateFormat);
        
        $this->padron_desc = new clsField("padron_desc", ccsText, "");
        
        $this->plancheta_cha = new clsField("plancheta_cha", ccsText, "");
        
        $this->plancheta_qta = new clsField("plancheta_qta", ccsText, "");
        
        $this->plancheta_ruta = new clsField("plancheta_ruta", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-6A2193A1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "plancheta_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-A7879954
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlplancheta_id", ccsInteger, "", "", $this->Parameters["urlplancheta_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "planchetas.plancheta_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-A721E05C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (planchetas INNER JOIN departamentos ON\n\n" .
        "planchetas.dpto_id = departamentos.dpto_id) LEFT JOIN padrones ON\n\n" .
        "planchetas.padron_id = padrones.padron_id";
        $this->SQL = "SELECT dpto_desc, plancheta_scc, plancheta_mzo, plancheta_par, plancheta_hoja, plancheta_obs, plancheta_file, plancheta_f_act, padron_desc,\n" .
        "plancheta_qta, plancheta_cha, plancheta_ruta \n" .
        "FROM (planchetas INNER JOIN departamentos ON\n" .
        "planchetas.dpto_id = departamentos.dpto_id) LEFT JOIN padrones ON\n" .
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

//SetValues Method @2-8E06F214
    function SetValues()
    {
        $this->dpto_desc->SetDBValue($this->f("dpto_desc"));
        $this->plancheta_scc->SetDBValue($this->f("plancheta_scc"));
        $this->plancheta_mzo->SetDBValue($this->f("plancheta_mzo"));
        $this->plancheta_par->SetDBValue($this->f("plancheta_par"));
        $this->plancheta_hoja->SetDBValue(trim($this->f("plancheta_hoja")));
        $this->plancheta_obs->SetDBValue($this->f("plancheta_obs"));
        $this->plancheta_f_act->SetDBValue(trim($this->f("plancheta_f_act")));
        $this->padron_desc->SetDBValue($this->f("padron_desc"));
        $this->plancheta_cha->SetDBValue($this->f("plancheta_cha"));
        $this->plancheta_qta->SetDBValue($this->f("plancheta_qta"));
        $this->plancheta_ruta->SetDBValue($this->f("plancheta_ruta"));
    }
//End SetValues Method

} //End departamentos_planchetasDataSource Class @2-FCB6E20C

//Include Page implementation @27-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @28-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @29-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-EE66A982
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
$TemplateFileName = "pl_planchetaDetalle.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-872FD3D7
CCSecurityRedirect("", "");
//End Authenticate User

//Include events file @1-84DB32A7
include_once("./pl_planchetaDetalle_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-4387E33F
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$departamentos_planchetas = & new clsGriddepartamentos_planchetas("", $MainPage);
$tdf_header = & new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = & new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = & new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->departamentos_planchetas = & $departamentos_planchetas;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$departamentos_planchetas->Initialize();

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

//Execute Components @1-1BB09E23
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-ECE17696
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcatastro->close();
    header("Location: " . $Redirect);
    unset($departamentos_planchetas);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-5F7BE4CB
$departamentos_planchetas->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$AQFLPS9C3P8J = array("<center><font fac","e=\"Arial\"><small",">Gen&#101;rated"," <!-- CCS -->&#119;","ith <!-- CCS --",">C&#111;&#100;&#10","1;C&#104;&#97;r&#10","3;e <!-- SCC -->S&","#116;u&#100;i&#111",";.</small></fon","t></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($AQFLPS9C3P8J,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($AQFLPS9C3P8J,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($AQFLPS9C3P8J,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-5B0320D4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcatastro->close();
unset($departamentos_planchetas);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
