<?php
//Include Common Files @1-4F08652A
define("RelativePath", "..");
define("PathToCurrentPage", "/panel/");
define("FileName", "iframeNoticiasHilos_old.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files



class clsGridnoticias_hilos_usuarios1 { //noticias_hilos_usuarios1 class @26-743EFEA0

//Variables @26-6E51DF5A

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
//End Variables

//Class_Initialize Event @26-014A295C
    function clsGridnoticias_hilos_usuarios1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "noticias_hilos_usuarios1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid noticias_hilos_usuarios1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsnoticias_hilos_usuarios1DataSource($this);
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

        $this->noti_hilo_fecha = new clsControl(ccsLabel, "noti_hilo_fecha", "noti_hilo_fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn"), CCGetRequestParam("noti_hilo_fecha", ccsGet, NULL), $this);
        $this->noti_hilo_texto = new clsControl(ccsLabel, "noti_hilo_texto", "noti_hilo_texto", ccsMemo, "", CCGetRequestParam("noti_hilo_texto", ccsGet, NULL), $this);
        $this->noti_hilo_texto->HTML = true;
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->not_h_desc = new clsControl(ccsLabel, "not_h_desc", "not_h_desc", ccsText, "", CCGetRequestParam("not_h_desc", ccsGet, NULL), $this);
        $this->not_h_icono = new clsControl(ccsImage, "not_h_icono", "not_h_icono", ccsText, "", CCGetRequestParam("not_h_icono", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @26-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @26-318F1336
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlnoticia_id"] = CCGetFromGet("noticia_id", NULL);

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
            $this->ControlsVisible["not_h_icono"] = $this->not_h_icono->Visible;
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
                $this->not_h_icono->SetValue($this->DataSource->not_h_icono->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->noti_hilo_fecha->Show();
                $this->noti_hilo_texto->Show();
                $this->usuario_nombre->Show();
                $this->not_h_desc->Show();
                $this->not_h_icono->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @26-45878859
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->noti_hilo_fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_hilo_texto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->not_h_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->not_h_icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End noticias_hilos_usuarios1 Class @26-FCB6E20C

class clsnoticias_hilos_usuarios1DataSource extends clsDBtdf_nuevo {  //noticias_hilos_usuarios1DataSource Class @26-AB555B4B

//DataSource Variables @26-099C3EC6
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
    public $not_h_icono;
//End DataSource Variables

//DataSourceClass_Initialize Event @26-F2FA90B3
    function clsnoticias_hilos_usuarios1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid noticias_hilos_usuarios1";
        $this->Initialize();
        $this->noti_hilo_fecha = new clsField("noti_hilo_fecha", ccsDate, $this->DateFormat);
        
        $this->noti_hilo_texto = new clsField("noti_hilo_texto", ccsMemo, "");
        
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->not_h_desc = new clsField("not_h_desc", ccsText, "");
        
        $this->not_h_icono = new clsField("not_h_icono", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @26-B5340E47
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "noticias_hilos.noti_hilo_fecha desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @26-DC0C7D95
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlnoticia_id", ccsInteger, "", "", $this->Parameters["urlnoticia_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "noticias_hilos.noticia_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @26-F55FE444
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (noticias_hilos INNER JOIN usuarios ON\n\n" .
        "noticias_hilos.usuario_id = usuarios.usuario_id) INNER JOIN noticias_h_estados ON\n\n" .
        "noticias_hilos.not_h_est_id = noticias_h_estados.not_h_est_id";
        $this->SQL = "SELECT usuario_nombre, noti_hilo_id, noti_hilo_fecha, noti_hilo_texto, not_h_desc, not_h_abrev, not_h_icono \n\n" .
        "FROM (noticias_hilos INNER JOIN usuarios ON\n\n" .
        "noticias_hilos.usuario_id = usuarios.usuario_id) INNER JOIN noticias_h_estados ON\n\n" .
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

//SetValues Method @26-EA6AB177
    function SetValues()
    {
        $this->noti_hilo_fecha->SetDBValue(trim($this->f("noti_hilo_fecha")));
        $this->noti_hilo_texto->SetDBValue($this->f("noti_hilo_texto"));
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->not_h_desc->SetDBValue($this->f("not_h_desc"));
        $this->not_h_icono->SetDBValue($this->f("not_h_icono"));
    }
//End SetValues Method

} //End noticias_hilos_usuarios1DataSource Class @26-FCB6E20C

//Initialize Page @1-9FE7B162
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
$TemplateFileName = "iframeNoticiasHilos_old.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-0CE247D9
include_once("./iframeNoticiasHilos_old_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-EB8A7EDB
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$noticias_hilos_usuarios1 = new clsGridnoticias_hilos_usuarios1("", $MainPage);
$MainPage->noticias_hilos_usuarios1 = & $noticias_hilos_usuarios1;
$noticias_hilos_usuarios1->Initialize();

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

//Go to destination page @1-EAB6C1D4
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($noticias_hilos_usuarios1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-CB36FAD8
$noticias_hilos_usuarios1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\">" . "<small>Genera&#116;e&#100; <" . "!-- CCS -->&#119;&#105;&#116;" . "&#104; <!-- SCC -->C&#111;&#10" . "0;&#101;&#67;&#104;arge <!-- S" . "CC -->S&#116;&#117;&#100;i&" . "#111;.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\">" . "<small>Genera&#116;e&#100; <" . "!-- CCS -->&#119;&#105;&#116;" . "&#104; <!-- SCC -->C&#111;&#10" . "0;&#101;&#67;&#104;arge <!-- S" . "CC -->S&#116;&#117;&#100;i&" . "#111;.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\">" . "<small>Genera&#116;e&#100; <" . "!-- CCS -->&#119;&#105;&#116;" . "&#104; <!-- SCC -->C&#111;&#10" . "0;&#101;&#67;&#104;arge <!-- S" . "CC -->S&#116;&#117;&#100;i&" . "#111;.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D9614DB4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($noticias_hilos_usuarios1);
unset($Tpl);
//End Unload Page


?>
