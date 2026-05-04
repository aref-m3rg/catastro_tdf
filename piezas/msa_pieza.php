<?php
//Include Common Files @1-0757A5EB
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_pieza.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridpiezas_piezas_tipos_trami { //piezas_piezas_tipos_trami class @2-739B4FF9

//Variables @2-6E51DF5A

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

//Class_Initialize Event @2-559ECB5D
    function clsGridpiezas_piezas_tipos_trami($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "piezas_piezas_tipos_trami";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspiezas_piezas_tipos_tramiDataSource($this);
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

        $this->pieza_iniciador = new clsControl(ccsLabel, "pieza_iniciador", "pieza_iniciador", ccsText, "", CCGetRequestParam("pieza_iniciador", ccsGet, NULL), $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
        $this->pieza_tipo_desc = new clsControl(ccsLabel, "pieza_tipo_desc", "pieza_tipo_desc", ccsText, "", CCGetRequestParam("pieza_tipo_desc", ccsGet, NULL), $this);
        $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
        $this->tramite_desc = new clsControl(ccsLabel, "tramite_desc", "tramite_desc", ccsText, "", CCGetRequestParam("tramite_desc", ccsGet, NULL), $this);
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
        $this->pieza_observaciones = new clsControl(ccsLabel, "pieza_observaciones", "pieza_observaciones", ccsText, "", CCGetRequestParam("pieza_observaciones", ccsGet, NULL), $this);
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", CCGetRequestParam("unidad_p_nombre", ccsGet, NULL), $this);
        $this->entorno_desc = new clsControl(ccsLabel, "entorno_desc", "entorno_desc", ccsText, "", CCGetRequestParam("entorno_desc", ccsGet, NULL), $this);
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

//Show Method @2-ECAAE96B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
        $this->DataSource->Parameters["expr13"] = 1;

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
            $this->ControlsVisible["pieza_iniciador"] = $this->pieza_iniciador->Visible;
            $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
            $this->ControlsVisible["pieza_tipo_desc"] = $this->pieza_tipo_desc->Visible;
            $this->ControlsVisible["pieza"] = $this->pieza->Visible;
            $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
            $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
            $this->ControlsVisible["pieza_observaciones"] = $this->pieza_observaciones->Visible;
            $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
            $this->ControlsVisible["entorno_desc"] = $this->entorno_desc->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->pieza_iniciador->SetValue($this->DataSource->pieza_iniciador->GetValue());
                $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                $this->pieza_tipo_desc->SetValue($this->DataSource->pieza_tipo_desc->GetValue());
                $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
                $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                $this->pieza_observaciones->SetValue($this->DataSource->pieza_observaciones->GetValue());
                $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                $this->entorno_desc->SetValue($this->DataSource->entorno_desc->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_iniciador->Show();
                $this->pieza_descripcion->Show();
                $this->pieza_tipo_desc->Show();
                $this->pieza->Show();
                $this->tramite_desc->Show();
                $this->pieza_f_alta->Show();
                $this->pieza_observaciones->Show();
                $this->unidad_p_nombre->Show();
                $this->entorno_desc->Show();
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

//GetErrors Method @2-D61B5B57
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->pieza_iniciador->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_tipo_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
        $errors = ComposeStrings($errors, $this->pieza_observaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->unidad_p_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->entorno_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End piezas_piezas_tipos_trami Class @2-FCB6E20C

class clspiezas_piezas_tipos_tramiDataSource extends clsDBmesa {  //piezas_piezas_tipos_tramiDataSource Class @2-70A9BED9

//DataSource Variables @2-A7396E37
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $pieza_iniciador;
    public $pieza_descripcion;
    public $pieza_tipo_desc;
    public $pieza;
    public $tramite_desc;
    public $pieza_f_alta;
    public $pieza_observaciones;
    public $unidad_p_nombre;
    public $entorno_desc;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-7D8B69F3
    function clspiezas_piezas_tipos_tramiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
        $this->Initialize();
        $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->pieza_tipo_desc = new clsField("pieza_tipo_desc", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        
        $this->pieza_observaciones = new clsField("pieza_observaciones", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->entorno_desc = new clsField("entorno_desc", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-F239C0D0
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->wp->AddParameter("2", "expr13", ccsInteger, "", "", $this->Parameters["expr13"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-E1095EF3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id";
        $this->SQL = "SELECT pieza_tipo_desc, tramite_desc, unidad_p_nombre, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_id, pieza_iniciador,\n\n" .
        "pieza_descripcion, pieza_f_alta, piezas_tipos.pieza_tipo_id AS tipo, pieza_observaciones, piezas.unidad_id AS unidad_id,\n\n" .
        "entorno_desc \n\n" .
        "FROM (((piezas INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
        "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param ON\n\n" .
        "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-4E9ABD3A
    function SetValues()
    {
        $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_tipo_desc->SetDBValue($this->f("pieza_tipo_desc"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
        $this->pieza_observaciones->SetDBValue($this->f("pieza_observaciones"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->entorno_desc->SetDBValue($this->f("entorno_desc"));
    }
//End SetValues Method

} //End piezas_piezas_tipos_tramiDataSource Class @2-FCB6E20C

//Initialize Page @1-20E2768E
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
$TemplateFileName = "msa_pieza.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-4AE5A3CC
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$piezas_piezas_tipos_trami = new clsGridpiezas_piezas_tipos_trami("", $MainPage);
$MainPage->piezas_piezas_tipos_trami = & $piezas_piezas_tipos_trami;
$piezas_piezas_tipos_trami->Initialize();

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

//Go to destination page @1-A71B61DC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($piezas_piezas_tipos_trami);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-C9E8EB05
$piezas_piezas_tipos_trami->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$LNGAA5C9G1D6T4P = explode("|", "<center><font face=\"|Arial\"><small>&#71;|en&#101;&#114;ate|d <!-- SCC -->&#119;|&#105;t&#104; <!|-- SCC -->Code&#|67;&#104;&#97;&#114|;&#103;e <!-- SCC --|>S&#116;u&#100;&#105;|o.</small></font>|</center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($LNGAA5C9G1D6T4P,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($LNGAA5C9G1D6T4P,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($LNGAA5C9G1D6T4P,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2518EE6E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($piezas_piezas_tipos_trami);
unset($Tpl);
//End Unload Page


?>
