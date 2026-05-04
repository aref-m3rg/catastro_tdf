<?php
//Include Common Files @1-9EF1A3E4
define("RelativePath", "..");
define("PathToCurrentPage", "/panel/");
define("FileName", "iframeNoticiasHilos1.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridusuarios_noticias_h_estad { //usuarios_noticias_h_estad class @6-F9E85116

//Variables @6-8CD8878A

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
    public $Sorter_noti_hilo_fecha;
    public $Sorter_usuario_nombre;
    public $Sorter_not_h_desc;
//End Variables

//Class_Initialize Event @6-62F2BF06
    function clsGridusuarios_noticias_h_estad($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "usuarios_noticias_h_estad";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid usuarios_noticias_h_estad";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsusuarios_noticias_h_estadDataSource($this);
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
        $this->SorterName = CCGetParam("usuarios_noticias_h_estadOrder", "");
        $this->SorterDirection = CCGetParam("usuarios_noticias_h_estadDir", "");

        $this->noti_hilo_fecha = new clsControl(ccsLabel, "noti_hilo_fecha", "noti_hilo_fecha", ccsDate, $DefaultDateFormat, CCGetRequestParam("noti_hilo_fecha", ccsGet, NULL), $this);
        $this->noti_hilo_texto = new clsControl(ccsLabel, "noti_hilo_texto", "noti_hilo_texto", ccsMemo, "", CCGetRequestParam("noti_hilo_texto", ccsGet, NULL), $this);
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->not_h_desc = new clsControl(ccsLabel, "not_h_desc", "not_h_desc", ccsText, "", CCGetRequestParam("not_h_desc", ccsGet, NULL), $this);
        $this->Sorter_noti_hilo_fecha = new clsSorter($this->ComponentName, "Sorter_noti_hilo_fecha", $FileName, $this);
        $this->Sorter_usuario_nombre = new clsSorter($this->ComponentName, "Sorter_usuario_nombre", $FileName, $this);
        $this->Sorter_not_h_desc = new clsSorter($this->ComponentName, "Sorter_not_h_desc", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @6-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @6-1A8BDDF3
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
            $this->ControlsVisible["noti_hilo_fecha"] = $this->noti_hilo_fecha->Visible;
            $this->ControlsVisible["noti_hilo_texto"] = $this->noti_hilo_texto->Visible;
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            $this->ControlsVisible["not_h_desc"] = $this->not_h_desc->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->noti_hilo_fecha->SetValue($this->DataSource->noti_hilo_fecha->GetValue());
                $this->noti_hilo_texto->SetValue($this->DataSource->noti_hilo_texto->GetValue());
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->not_h_desc->SetValue($this->DataSource->not_h_desc->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->noti_hilo_fecha->Show();
                $this->noti_hilo_texto->Show();
                $this->usuario_nombre->Show();
                $this->not_h_desc->Show();
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
        $this->Sorter_noti_hilo_fecha->Show();
        $this->Sorter_usuario_nombre->Show();
        $this->Sorter_not_h_desc->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-F78A03B4
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->noti_hilo_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_hilo_texto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->not_h_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End usuarios_noticias_h_estad Class @6-FCB6E20C

class clsusuarios_noticias_h_estadDataSource extends clsDBtdf_nuevo {  //usuarios_noticias_h_estadDataSource Class @6-827B1A30

//DataSource Variables @6-A9F26284
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $noti_hilo_fecha;
    public $noti_hilo_texto;
    public $usuario_nombre;
    public $not_h_desc;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-4787BAF8
    function clsusuarios_noticias_h_estadDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid usuarios_noticias_h_estad";
        $this->Initialize();
        $this->noti_hilo_fecha = new clsField("noti_hilo_fecha", ccsDate, $this->DateFormat);
        
        $this->noti_hilo_texto = new clsField("noti_hilo_texto", ccsMemo, "");
        
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->not_h_desc = new clsField("not_h_desc", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-3A953999
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_noti_hilo_fecha" => array("noti_hilo_fecha", ""), 
            "Sorter_usuario_nombre" => array("usuario_nombre", ""), 
            "Sorter_not_h_desc" => array("not_h_desc", "")));
    }
//End SetOrder Method

//Prepare Method @6-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @6-D55AFFAE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (noticias_hilos INNER JOIN _usuarios ON\n\n" .
        "noticias_hilos.usuario_id = _usuarios.usuario_id) INNER JOIN noticias_h_estados ON\n\n" .
        "noticias_hilos.not_h_est_id = noticias_h_estados.not_h_est_id";
        $this->SQL = "SELECT * \n\n" .
        "FROM (noticias_hilos INNER JOIN _usuarios ON\n\n" .
        "noticias_hilos.usuario_id = _usuarios.usuario_id) INNER JOIN noticias_h_estados ON\n\n" .
        "noticias_hilos.not_h_est_id = noticias_h_estados.not_h_est_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-0F37B227
    function SetValues()
    {
        $this->noti_hilo_fecha->SetDBValue(trim($this->f("noti_hilo_fecha")));
        $this->noti_hilo_texto->SetDBValue($this->f("noti_hilo_texto"));
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->not_h_desc->SetDBValue($this->f("not_h_desc"));
    }
//End SetValues Method

} //End usuarios_noticias_h_estadDataSource Class @6-FCB6E20C

//Initialize Page @1-5968574E
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
$TemplateFileName = "iframeNoticiasHilos1.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-A3FAAA09
include_once("./iframeNoticiasHilos1_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-AB2AEB45
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$usuarios_noticias_h_estad = new clsGridusuarios_noticias_h_estad("", $MainPage);
$MainPage->usuarios_noticias_h_estad = & $usuarios_noticias_h_estad;
$usuarios_noticias_h_estad->Initialize();

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

//Go to destination page @1-61D1F923
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($usuarios_noticias_h_estad);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-665ACC03
$usuarios_noticias_h_estad->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CBBAQDSI8J6Q6E = array("<center><fon","t face=\"Aria","l\"><small>&#7","1;enera&#116;","e&#100; <!-- S","CC -->&#119;ith ","<!-- CCS -->","&#67;odeCh&#97;","&#114;ge <!","-- CCS -->&#83;","&#116;&#117;di","&#111;.</smal","l></font></ce","nter>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($CBBAQDSI8J6Q6E,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($CBBAQDSI8J6Q6E,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($CBBAQDSI8J6Q6E,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8A30A3C6
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($usuarios_noticias_h_estad);
unset($Tpl);
//End Unload Page


?>
