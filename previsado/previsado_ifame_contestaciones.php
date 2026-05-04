<?php
//Include Common Files @1-B9DAA6FF
define("RelativePath", "..");
define("PathToCurrentPage", "/previsado/");
define("FileName", "previsado_ifame_contestaciones.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridprevisados_contestaciones { //previsados_contestaciones class @6-20F5E6DD

//Variables @6-60D8D263

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
    public $Sorter_previsado_contestacion_f;
    public $Sorter_usuario_id;
//End Variables

//Class_Initialize Event @6-D85C2DE6
    function clsGridprevisados_contestaciones($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "previsados_contestaciones";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid previsados_contestaciones";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsprevisados_contestacionesDataSource($this);
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
        $this->SorterName = CCGetParam("previsados_contestacionesOrder", "");
        $this->SorterDirection = CCGetParam("previsados_contestacionesDir", "");

        $this->previsado_contestacion_f = new clsControl(ccsLabel, "previsado_contestacion_f", "previsado_contestacion_f", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn"), CCGetRequestParam("previsado_contestacion_f", ccsGet, NULL), $this);
        $this->previsado_contestacion_texto = new clsControl(ccsLabel, "previsado_contestacion_texto", "previsado_contestacion_texto", ccsMemo, "", CCGetRequestParam("previsado_contestacion_texto", ccsGet, NULL), $this);
        $this->previsado_contestacion_texto->HTML = true;
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->Sorter_previsado_contestacion_f = new clsSorter($this->ComponentName, "Sorter_previsado_contestacion_f", $FileName, $this);
        $this->Sorter_usuario_id = new clsSorter($this->ComponentName, "Sorter_usuario_id", $FileName, $this);
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

//Show Method @6-9A84E2F6
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["sesprevisado_respuesta_id"] = CCGetSession("previsado_respuesta_id", NULL);

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
            $this->ControlsVisible["previsado_contestacion_f"] = $this->previsado_contestacion_f->Visible;
            $this->ControlsVisible["previsado_contestacion_texto"] = $this->previsado_contestacion_texto->Visible;
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->previsado_contestacion_f->SetValue($this->DataSource->previsado_contestacion_f->GetValue());
                $this->previsado_contestacion_texto->SetValue($this->DataSource->previsado_contestacion_texto->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->previsado_contestacion_f->Show();
                $this->previsado_contestacion_texto->Show();
                $this->usuario_nombre->Show();
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
        $this->Sorter_previsado_contestacion_f->Show();
        $this->Sorter_usuario_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @6-BAC2C6DA
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->previsado_contestacion_f->Errors->ToString());
        $errors = ComposeStrings($errors, $this->previsado_contestacion_texto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End previsados_contestaciones Class @6-FCB6E20C

class clsprevisados_contestacionesDataSource extends clsDBtdf_nuevo {  //previsados_contestacionesDataSource Class @6-5E68D396

//DataSource Variables @6-EA357771
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $previsado_contestacion_f;
    public $previsado_contestacion_texto;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-EBB5FB27
    function clsprevisados_contestacionesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid previsados_contestaciones";
        $this->Initialize();
        $this->previsado_contestacion_f = new clsField("previsado_contestacion_f", ccsDate, $this->DateFormat);
        
        $this->previsado_contestacion_texto = new clsField("previsado_contestacion_texto", ccsMemo, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-85E87872
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "previsado_contestacion_f desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_previsado_contestacion_f" => array("previsado_contestacion_f", ""), 
            "Sorter_usuario_id" => array("usuario_id", "")));
    }
//End SetOrder Method

//Prepare Method @6-16776381
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesprevisado_respuesta_id", ccsInteger, "", "", $this->Parameters["sesprevisado_respuesta_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "previsado_respuesta_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-BD165ED0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM previsados_contestaciones";
        $this->SQL = "SELECT * \n\n" .
        "FROM previsados_contestaciones {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-AD810177
    function SetValues()
    {
        $this->previsado_contestacion_f->SetDBValue(trim($this->f("previsado_contestacion_f")));
        $this->previsado_contestacion_texto->SetDBValue($this->f("previsado_contestacion_texto"));
    }
//End SetValues Method

} //End previsados_contestacionesDataSource Class @6-FCB6E20C

//Initialize Page @1-B2B52830
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
$TemplateFileName = "previsado_ifame_contestaciones.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-50717D68
include_once("./previsado_ifame_contestaciones_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-0EBBA455
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$previsados_contestaciones = new clsGridprevisados_contestaciones("", $MainPage);
$MainPage->previsados_contestaciones = & $previsados_contestaciones;
$previsados_contestaciones->Initialize();

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

//Go to destination page @1-6CAF4F9B
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($previsados_contestaciones);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-0E054F8C
$previsados_contestaciones->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;era&#116;&#101;d <!-- CCS -->with <!-- CCS -->&#67;o&#100;&#101;&#67;ha&#114;ge <!-- CCS -->&#83;&#116;&#117;&#100;io.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#101;&#110;era&#116;&#101;d <!-- CCS -->with <!-- CCS -->&#67;o&#100;&#101;&#67;ha&#114;ge <!-- CCS -->&#83;&#116;&#117;&#100;io.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>G&#101;&#110;era&#116;&#101;d <!-- CCS -->with <!-- CCS -->&#67;o&#100;&#101;&#67;ha&#114;ge <!-- CCS -->&#83;&#116;&#117;&#100;io.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B60E35FD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($previsados_contestaciones);
unset($Tpl);
//End Unload Page


?>
