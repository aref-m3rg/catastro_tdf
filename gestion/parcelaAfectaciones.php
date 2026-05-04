<?php
//Include Common Files @1-F3A8A8C1
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "parcelaAfectaciones.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @4-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @5-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @6-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @8-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

class clsGridafectaciones { //afectaciones class @10-6368A79F

//Variables @10-B9D6A486

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
    public $Sorter_afectacion_id;
    public $Sorter_plano_id;
    public $Sorter_tipo_afectacion_id;
    public $Sorter_afectacion_superficie;
    public $Sorter_afectacion_descripcion;
//End Variables

//Class_Initialize Event @10-B12E2881
    function clsGridafectaciones($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "afectaciones";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid afectaciones";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsafectacionesDataSource($this);
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
        $this->SorterName = CCGetParam("afectacionesOrder", "");
        $this->SorterDirection = CCGetParam("afectacionesDir", "");

        $this->afectacion_id = new clsControl(ccsLabel, "afectacion_id", "afectacion_id", ccsInteger, "", CCGetRequestParam("afectacion_id", ccsGet, NULL), $this);
        $this->plano_nro = new clsControl(ccsLabel, "plano_nro", "plano_nro", ccsText, "", CCGetRequestParam("plano_nro", ccsGet, NULL), $this);
        $this->tipo_afectacion_id = new clsControl(ccsLabel, "tipo_afectacion_id", "tipo_afectacion_id", ccsText, "", CCGetRequestParam("tipo_afectacion_id", ccsGet, NULL), $this);
        $this->afectacion_superficie = new clsControl(ccsLabel, "afectacion_superficie", "afectacion_superficie", ccsFloat, "", CCGetRequestParam("afectacion_superficie", ccsGet, NULL), $this);
        $this->afectacion_descripcion = new clsControl(ccsLabel, "afectacion_descripcion", "afectacion_descripcion", ccsText, "", CCGetRequestParam("afectacion_descripcion", ccsGet, NULL), $this);
        $this->afectacion_observaciones = new clsControl(ccsLabel, "afectacion_observaciones", "afectacion_observaciones", ccsMemo, "", CCGetRequestParam("afectacion_observaciones", ccsGet, NULL), $this);
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
        $this->ImageLink1->Page = "parcelaAfectacionesRecord.php";
        $this->afectaciones_TotalRecords = new clsControl(ccsLabel, "afectaciones_TotalRecords", "afectaciones_TotalRecords", ccsText, "", CCGetRequestParam("afectaciones_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_afectacion_id = new clsSorter($this->ComponentName, "Sorter_afectacion_id", $FileName, $this);
        $this->Sorter_plano_id = new clsSorter($this->ComponentName, "Sorter_plano_id", $FileName, $this);
        $this->Sorter_tipo_afectacion_id = new clsSorter($this->ComponentName, "Sorter_tipo_afectacion_id", $FileName, $this);
        $this->Sorter_afectacion_superficie = new clsSorter($this->ComponentName, "Sorter_afectacion_superficie", $FileName, $this);
        $this->Sorter_afectacion_descripcion = new clsSorter($this->ComponentName, "Sorter_afectacion_descripcion", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->ImageLink2 = new clsControl(ccsImageLink, "ImageLink2", "ImageLink2", ccsText, "", CCGetRequestParam("ImageLink2", ccsGet, NULL), $this);
        $this->ImageLink2->Parameters = CCGetQueryString("QueryString", array("afectacion_id", "ccsForm"));
        $this->ImageLink2->Parameters = CCAddParam($this->ImageLink2->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->ImageLink2->Page = "parcelaAfectacionesRecord.php";
    }
//End Class_Initialize Event

//Initialize Method @10-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @10-EF472AD6
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
            $this->ControlsVisible["afectacion_id"] = $this->afectacion_id->Visible;
            $this->ControlsVisible["plano_nro"] = $this->plano_nro->Visible;
            $this->ControlsVisible["tipo_afectacion_id"] = $this->tipo_afectacion_id->Visible;
            $this->ControlsVisible["afectacion_superficie"] = $this->afectacion_superficie->Visible;
            $this->ControlsVisible["afectacion_descripcion"] = $this->afectacion_descripcion->Visible;
            $this->ControlsVisible["afectacion_observaciones"] = $this->afectacion_observaciones->Visible;
            $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                // Parse Separator
                if($this->RowNumber) {
                    $this->Attributes->Show();
                    $Tpl->parseto("Separator", true, "Row");
                }
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->afectacion_id->SetValue($this->DataSource->afectacion_id->GetValue());
                $this->tipo_afectacion_id->SetValue($this->DataSource->tipo_afectacion_id->GetValue());
                $this->afectacion_superficie->SetValue($this->DataSource->afectacion_superficie->GetValue());
                $this->afectacion_descripcion->SetValue($this->DataSource->afectacion_descripcion->GetValue());
                $this->afectacion_observaciones->SetValue($this->DataSource->afectacion_observaciones->GetValue());
                $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "afectacion_id", $this->DataSource->f("afectacion_id"));
                $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->afectacion_id->Show();
                $this->plano_nro->Show();
                $this->tipo_afectacion_id->Show();
                $this->afectacion_superficie->Show();
                $this->afectacion_descripcion->Show();
                $this->afectacion_observaciones->Show();
                $this->ImageLink1->Show();
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
        $this->afectaciones_TotalRecords->Show();
        $this->Sorter_afectacion_id->Show();
        $this->Sorter_plano_id->Show();
        $this->Sorter_tipo_afectacion_id->Show();
        $this->Sorter_afectacion_superficie->Show();
        $this->Sorter_afectacion_descripcion->Show();
        $this->Navigator->Show();
        $this->ImageLink2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @10-3686C9B9
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->afectacion_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->plano_nro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_afectacion_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->afectacion_superficie->Errors->ToString());
        $errors = ComposeStrings($errors, $this->afectacion_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->afectacion_observaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End afectaciones Class @10-FCB6E20C

class clsafectacionesDataSource extends clsDBtdf_nuevo {  //afectacionesDataSource Class @10-E70834C3

//DataSource Variables @10-86A22F45
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $afectacion_id;
    public $tipo_afectacion_id;
    public $afectacion_superficie;
    public $afectacion_descripcion;
    public $afectacion_observaciones;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-5BFD6DC3
    function clsafectacionesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid afectaciones";
        $this->Initialize();
        $this->afectacion_id = new clsField("afectacion_id", ccsInteger, "");
        
        $this->tipo_afectacion_id = new clsField("tipo_afectacion_id", ccsText, "");
        
        $this->afectacion_superficie = new clsField("afectacion_superficie", ccsFloat, "");
        
        $this->afectacion_descripcion = new clsField("afectacion_descripcion", ccsText, "");
        
        $this->afectacion_observaciones = new clsField("afectacion_observaciones", ccsMemo, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @10-51B95820
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "afectaciones.afectacion_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_afectacion_id" => array("afectacion_id", ""), 
            "Sorter_plano_id" => array("plano_id", ""), 
            "Sorter_tipo_afectacion_id" => array("tipo_afectacion_id", ""), 
            "Sorter_afectacion_superficie" => array("afectacion_superficie", ""), 
            "Sorter_afectacion_descripcion" => array("afectacion_descripcion", "")));
    }
//End SetOrder Method

//Prepare Method @10-FD0F0AE5
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "afectaciones.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @10-6C9EFBCB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (afectaciones LEFT JOIN planos ON\n\n" .
        "afectaciones.plano_id = planos.plano_id) INNER JOIN tipos_afectaciones ON\n\n" .
        "afectaciones.tipo_afectacion_id = tipos_afectaciones.tipo_afectacion_id";
        $this->SQL = "SELECT afectaciones.*, plano_e_nro, plano_e_letra, plano_e_anio, plano_nro, tipo_afectacion_nombre \n\n" .
        "FROM (afectaciones LEFT JOIN planos ON\n\n" .
        "afectaciones.plano_id = planos.plano_id) INNER JOIN tipos_afectaciones ON\n\n" .
        "afectaciones.tipo_afectacion_id = tipos_afectaciones.tipo_afectacion_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-DF04FFD8
    function SetValues()
    {
        $this->afectacion_id->SetDBValue(trim($this->f("afectacion_id")));
        $this->tipo_afectacion_id->SetDBValue($this->f("tipo_afectacion_nombre"));
        $this->afectacion_superficie->SetDBValue(trim($this->f("afectacion_superficie")));
        $this->afectacion_descripcion->SetDBValue($this->f("afectacion_descripcion"));
        $this->afectacion_observaciones->SetDBValue($this->f("afectacion_observaciones"));
    }
//End SetValues Method

} //End afectacionesDataSource Class @10-FCB6E20C

//Initialize Page @1-B32EBCAE
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
$TemplateFileName = "parcelaAfectaciones.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-C5F18882
include_once("./parcelaAfectaciones_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-65827D27
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
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$afectaciones = new clsGridafectaciones("", $MainPage);
$css = new clsControl(ccsHidden, "css", "css", ccsText, "", CCGetRequestParam("css", ccsGet, NULL), $MainPage);
$jsapi = new clsControl(ccsHidden, "jsapi", "jsapi", ccsText, "", CCGetRequestParam("jsapi", ccsGet, NULL), $MainPage);
$image = new clsControl(ccsHidden, "image", "image", ccsText, "", CCGetRequestParam("image", ccsGet, NULL), $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->footerParcela = & $footerParcela;
$MainPage->headerParcela = & $headerParcela;
$MainPage->afectaciones = & $afectaciones;
$MainPage->css = & $css;
$MainPage->jsapi = & $jsapi;
$MainPage->image = & $image;
$afectaciones->Initialize();

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

//Execute Components @1-51139AD4
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$footerParcela->Operations();
$headerParcela->Operations();
//End Execute Components

//Go to destination page @1-1785D953
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
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    $headerParcela->Class_Terminate();
    unset($headerParcela);
    unset($afectaciones);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-8FE62C48
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$footerParcela->Show();
$headerParcela->Show();
$afectaciones->Show();
$css->Show();
$jsapi->Show();
$image->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$FKCMA10Q7C5P6T7J = explode("|", "<center><font face=\"Ar|ial\"><small>Ge&#110;&#10|1;&#114;at&#101;&#100; <!|-- SCC -->w&#105;&#11|6;h <!-- CCS -->&#67;odeC|&#104;a&#114;ge <!-- S|CC -->St&#117;&#100;&#10|5;&#111;.</small></fo|nt></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($FKCMA10Q7C5P6T7J,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($FKCMA10Q7C5P6T7J,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($FKCMA10Q7C5P6T7J,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9A9AB279
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$footerParcela->Class_Terminate();
unset($footerParcela);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($afectaciones);
unset($Tpl);
//End Unload Page


?>
