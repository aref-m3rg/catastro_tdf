<?php
//Include Common Files @1-409F55DF
define("RelativePath", "..");
define("PathToCurrentPage", "/permisos/");
define("FileName", "tc_gridPerfil.php");
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

class clsGridperfiles_tipos_estados { //perfiles_tipos_estados class @8-5CF15B85

//Variables @8-6E51DF5A

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

//Class_Initialize Event @8-378C7794
    function clsGridperfiles_tipos_estados($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "perfiles_tipos_estados";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid perfiles_tipos_estados";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsperfiles_tipos_estadosDataSource($this);
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

        $this->perfil_nombre = new clsControl(ccsLabel, "perfil_nombre", "perfil_nombre", ccsText, "", CCGetRequestParam("perfil_nombre", ccsGet, NULL), $this);
        $this->perfil_abrev = new clsControl(ccsLabel, "perfil_abrev", "perfil_abrev", ccsText, "", CCGetRequestParam("perfil_abrev", ccsGet, NULL), $this);
        $this->perfil_descr = new clsControl(ccsLabel, "perfil_descr", "perfil_descr", ccsText, "", CCGetRequestParam("perfil_descr", ccsGet, NULL), $this);
        $this->tipo_estado_descrip = new clsControl(ccsLabel, "tipo_estado_descrip", "tipo_estado_descrip", ccsText, "", CCGetRequestParam("tipo_estado_descrip", ccsGet, NULL), $this);
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

//Show Method @8-C11AE89C
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlperfil_id"] = CCGetFromGet("perfil_id", NULL);

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
            $this->ControlsVisible["perfil_nombre"] = $this->perfil_nombre->Visible;
            $this->ControlsVisible["perfil_abrev"] = $this->perfil_abrev->Visible;
            $this->ControlsVisible["perfil_descr"] = $this->perfil_descr->Visible;
            $this->ControlsVisible["tipo_estado_descrip"] = $this->tipo_estado_descrip->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->perfil_nombre->SetValue($this->DataSource->perfil_nombre->GetValue());
                $this->perfil_abrev->SetValue($this->DataSource->perfil_abrev->GetValue());
                $this->perfil_descr->SetValue($this->DataSource->perfil_descr->GetValue());
                $this->tipo_estado_descrip->SetValue($this->DataSource->tipo_estado_descrip->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->perfil_nombre->Show();
                $this->perfil_abrev->Show();
                $this->perfil_descr->Show();
                $this->tipo_estado_descrip->Show();
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

//GetErrors Method @8-2D176407
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->perfil_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->perfil_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->perfil_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End perfiles_tipos_estados Class @8-FCB6E20C

class clsperfiles_tipos_estadosDataSource extends clsDBtdf_nuevo {  //perfiles_tipos_estadosDataSource Class @8-0C9B89DB

//DataSource Variables @8-A37FE8FC
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $perfil_nombre;
    public $perfil_abrev;
    public $perfil_descr;
    public $tipo_estado_descrip;
//End DataSource Variables

//DataSourceClass_Initialize Event @8-19DF4785
    function clsperfiles_tipos_estadosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid perfiles_tipos_estados";
        $this->Initialize();
        $this->perfil_nombre = new clsField("perfil_nombre", ccsText, "");
        
        $this->perfil_abrev = new clsField("perfil_abrev", ccsText, "");
        
        $this->perfil_descr = new clsField("perfil_descr", ccsText, "");
        
        $this->tipo_estado_descrip = new clsField("tipo_estado_descrip", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @8-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @8-261FBC15
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlperfil_id", ccsInteger, "", "", $this->Parameters["urlperfil_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "_perfiles.perfil_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @8-76EEB7B2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM _perfiles INNER JOIN tipos_estados ON\n\n" .
        "_perfiles.tipo_estado_id = tipos_estados.tipo_estado_id";
        $this->SQL = "SELECT _perfiles.*, tipo_estado_descrip \n\n" .
        "FROM _perfiles INNER JOIN tipos_estados ON\n\n" .
        "_perfiles.tipo_estado_id = tipos_estados.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @8-723F9466
    function SetValues()
    {
        $this->perfil_nombre->SetDBValue($this->f("perfil_nombre"));
        $this->perfil_abrev->SetDBValue($this->f("perfil_abrev"));
        $this->perfil_descr->SetDBValue($this->f("perfil_descr"));
        $this->tipo_estado_descrip->SetDBValue($this->f("tipo_estado_descrip"));
    }
//End SetValues Method

} //End perfiles_tipos_estadosDataSource Class @8-FCB6E20C

//Initialize Page @1-1EFC288C
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
$TemplateFileName = "tc_gridPerfil.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-3E77A3A1
include_once("./tc_gridPerfil_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-09D81516
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$permissions_html = new clsControl(ccsLabel, "permissions_html", "permissions_html", ccsText, "", CCGetRequestParam("permissions_html", ccsGet, NULL), $MainPage);
$permissions_html->HTML = true;
$perfiles_tipos_estados = new clsGridperfiles_tipos_estados("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->permissions_html = & $permissions_html;
$MainPage->perfiles_tipos_estados = & $perfiles_tipos_estados;
$perfiles_tipos_estados->Initialize();

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

//Execute Components @1-84EEC634
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-0B2481BA
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
    unset($perfiles_tipos_estados);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E73BBBE4
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$perfiles_tipos_estados->Show();
$permissions_html->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$BQTKHK3O6B6Q = array("<center><font face=\"Ari","al\"><small>Ge&#110;&#1","01;&#114;a&#116;ed <!-","- SCC -->wi&#116;&#104","; <!-- SCC -->&#67;&#111;d","e&#67;h&#97;r&#103;&#101; ","<!-- CCS -->S&#116;ud&#1","05;o.</small></font><","/center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($BQTKHK3O6B6Q,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($BQTKHK3O6B6Q,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($BQTKHK3O6B6Q,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0AFF85DD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($perfiles_tipos_estados);
unset($Tpl);
//End Unload Page


?>
