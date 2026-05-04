<?php
//Include Common Files @1-1F90AB88
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_viewPieza.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @54-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @55-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @56-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridpiezas_piezas_tipos_trami { //piezas_piezas_tipos_trami class @4-739B4FF9

//Variables @4-6E51DF5A

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

//Class_Initialize Event @4-B5CBF2ED
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
    $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
    $this->pieza_observaciones = new clsControl(ccsLabel, "pieza_observaciones", "pieza_observaciones", ccsText, "", CCGetRequestParam("pieza_observaciones", ccsGet, NULL), $this);
    $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", CCGetRequestParam("unidad_p_nombre", ccsGet, NULL), $this);
    $this->entorno_desc = new clsControl(ccsLabel, "entorno_desc", "entorno_desc", ccsText, "", CCGetRequestParam("entorno_desc", ccsGet, NULL), $this);
    $this->tramite_desc = new clsControl(ccsLabel, "tramite_desc", "tramite_desc", ccsText, "", CCGetRequestParam("tramite_desc", ccsGet, NULL), $this);
    $this->tipo_tramites_descript = new clsControl(ccsLabel, "tipo_tramites_descript", "tipo_tramites_descript", ccsText, "", CCGetRequestParam("tipo_tramites_descript", ccsGet, NULL), $this);
    $this->pasar = new clsPanel("pasar", $this);
    $this->pass = new clsControl(ccsImageLink, "pass", "pass", ccsText, "", CCGetRequestParam("pass", ccsGet, NULL), $this);
    $this->pass->Page = "msa_pase.php";
    $this->editar = new clsPanel("editar", $this);
    $this->edit = new clsControl(ccsImageLink, "edit", "edit", ccsText, "", CCGetRequestParam("edit", ccsGet, NULL), $this);
    $this->edit->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    $this->edit->Page = "";
    $this->imprimir = new clsPanel("imprimir", $this);
    $this->print = new clsControl(ccsImageLink, "print", "print", ccsText, "", CCGetRequestParam("print", ccsGet, NULL), $this);
    $this->print->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    $this->print->Parameters = CCAddParam($this->print->Parameters, "pieza_id", CCGetFromGet("pieza_id", NULL));
    $this->print->Page = "msa_viewPieza.php";
    $this->inicio = new clsPanel("inicio", $this);
    $this->home = new clsControl(ccsImageLink, "home", "home", ccsText, "", CCGetRequestParam("home", ccsGet, NULL), $this);
    $this->home->Parameters = CCGetQueryString("QueryString", array("pieza_id", "ccsForm"));
    $this->home->Page = "msa_principal.php";
    $this->pasar->AddComponent("pass", $this->pass);
    $this->editar->AddComponent("edit", $this->edit);
    $this->imprimir->AddComponent("print", $this->print);
    $this->inicio->AddComponent("home", $this->home);
  }
//End Class_Initialize Event

//Initialize Method @4-90E704C5
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
  }
//End Initialize Method

//Show Method @4-A912BEA6
  function Show()
  {
    global $Tpl;
    global $CCSLocales;
    if(!$this->Visible) return;

    $this->RowNumber = 0;

    $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
    $this->DataSource->Parameters["expr31"] = 1;

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
      $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
      $this->ControlsVisible["pieza_observaciones"] = $this->pieza_observaciones->Visible;
      $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
      $this->ControlsVisible["entorno_desc"] = $this->entorno_desc->Visible;
      $this->ControlsVisible["tramite_desc"] = $this->tramite_desc->Visible;
      $this->ControlsVisible["tipo_tramites_descript"] = $this->tipo_tramites_descript->Visible;
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
        $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
        $this->pieza_observaciones->SetValue($this->DataSource->pieza_observaciones->GetValue());
        $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
        $this->entorno_desc->SetValue($this->DataSource->entorno_desc->GetValue());
        $this->tramite_desc->SetValue($this->DataSource->tramite_desc->GetValue());
        $this->tipo_tramites_descript->SetValue($this->DataSource->tipo_tramites_descript->GetValue());
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->pieza_iniciador->Show();
        $this->pieza_descripcion->Show();
        $this->pieza_tipo_desc->Show();
        $this->pieza->Show();
        $this->pieza_f_alta->Show();
        $this->pieza_observaciones->Show();
        $this->unidad_p_nombre->Show();
        $this->entorno_desc->Show();
        $this->tramite_desc->Show();
        $this->tipo_tramites_descript->Show();
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
    $this->pass->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    $this->pass->Parameters = CCAddParam($this->pass->Parameters, "pieza_id", CCGetFromGet("pieza_id", NULL));
    $this->pass->Parameters = CCAddParam($this->pass->Parameters, "tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
    $this->pasar->Show();
    $this->pass->Show();
    $this->editar->Show();
    $this->edit->Show();
    $this->imprimir->Show();
    $this->print->Show();
    $this->inicio->Show();
    $this->home->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

//GetErrors Method @4-826CC3D6
  function GetErrors()
  {
    $errors = "";
    $errors = ComposeStrings($errors, $this->pieza_iniciador->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_tipo_desc->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_observaciones->Errors->ToString());
    $errors = ComposeStrings($errors, $this->unidad_p_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->entorno_desc->Errors->ToString());
    $errors = ComposeStrings($errors, $this->tramite_desc->Errors->ToString());
    $errors = ComposeStrings($errors, $this->tipo_tramites_descript->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
//End GetErrors Method

} //End piezas_piezas_tipos_trami Class @4-FCB6E20C

class clspiezas_piezas_tipos_tramiDataSource extends clsDBmesa {  //piezas_piezas_tipos_tramiDataSource Class @4-70A9BED9

//DataSource Variables @4-17FF9DA7
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
  public $pieza_f_alta;
  public $pieza_observaciones;
  public $unidad_p_nombre;
  public $entorno_desc;
  public $tramite_desc;
  public $tipo_tramites_descript;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-ABE1BC85
  function clspiezas_piezas_tipos_tramiDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Grid piezas_piezas_tipos_trami";
    $this->Initialize();
    $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
    
    $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
    
    $this->pieza_tipo_desc = new clsField("pieza_tipo_desc", ccsText, "");
    
    $this->pieza = new clsField("pieza", ccsText, "");
    
    $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
    
    $this->pieza_observaciones = new clsField("pieza_observaciones", ccsText, "");
    
    $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
    
    $this->entorno_desc = new clsField("entorno_desc", ccsText, "");
    
    $this->tramite_desc = new clsField("tramite_desc", ccsText, "");
    
    $this->tipo_tramites_descript = new clsField("tipo_tramites_descript", ccsText, "");
    

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-9E1383D1
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      "");
  }
//End SetOrder Method

//Prepare Method @4-AAB30B59
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
    $this->wp->AddParameter("2", "expr31", ccsInteger, "", "", $this->Parameters["expr31"], "", false);
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "piezas.pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
    $this->Where = $this->wp->opAND(
       false, 
       $this->wp->Criterion[1], 
       $this->wp->Criterion[2]);
  }
//End Prepare Method

//Open Method @4-90A93698
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM ((((piezas INNER JOIN entornos ON\n\n" .
    "piezas.entorno_id = entornos.entorno_id) INNER JOIN unidades_param ON\n\n" .
    "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN piezas_tipos ON\n\n" .
    "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN tramites ON\n\n" .
    "piezas.tramite_id = tramites.tramite_id) LEFT JOIN tipos_tramites ON\n\n" .
    "piezas.tipo_tramites_id = tipos_tramites.tipo_tramites_id";
    $this->SQL = "SELECT pieza_tipo_desc, tramite_desc, unidad_p_nombre, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_id, pieza_iniciador,\n\n" .
    "pieza_descripcion, pieza_f_alta, piezas_tipos.pieza_tipo_id AS tipo, pieza_observaciones, piezas.unidad_id AS unidad_id,\n\n" .
    "entorno_desc, tipo_tramites_descript, piezas.tipo_tramites_id AS piezas_tipo_tramites_id \n\n" .
    "FROM ((((piezas INNER JOIN entornos ON\n\n" .
    "piezas.entorno_id = entornos.entorno_id) INNER JOIN unidades_param ON\n\n" .
    "piezas.unidad_id = unidades_param.unidad_id) INNER JOIN piezas_tipos ON\n\n" .
    "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN tramites ON\n\n" .
    "piezas.tramite_id = tramites.tramite_id) LEFT JOIN tipos_tramites ON\n\n" .
    "piezas.tipo_tramites_id = tipos_tramites.tipo_tramites_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @4-2D2AB5AF
  function SetValues()
  {
    $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
    $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
    $this->pieza_tipo_desc->SetDBValue($this->f("pieza_tipo_desc"));
    $this->pieza->SetDBValue($this->f("pieza"));
    $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
    $this->pieza_observaciones->SetDBValue($this->f("pieza_observaciones"));
    $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
    $this->entorno_desc->SetDBValue($this->f("entorno_desc"));
    $this->tramite_desc->SetDBValue($this->f("tramite_desc"));
    $this->tipo_tramites_descript->SetDBValue($this->f("tipo_tramites_descript"));
  }
//End SetValues Method

} //End piezas_piezas_tipos_tramiDataSource Class @4-FCB6E20C

//Initialize Page @1-77842CFF
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
$TemplateFileName = "msa_viewPieza.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-467B2DBE
include_once("./msa_viewPieza_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C8CDC5A9
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$piezas_piezas_tipos_trami = new clsGridpiezas_piezas_tipos_trami("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->piezas_piezas_tipos_trami = & $piezas_piezas_tipos_trami;
$piezas_piezas_tipos_trami->Initialize();

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

//Go to destination page @1-9E80E048
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBmesa->close();
  header("Location: " . $Redirect);
  $tdf_header->Class_Terminate();
  unset($tdf_header);
  $tdf_menu->Class_Terminate();
  unset($tdf_menu);
  $tdf_footer->Class_Terminate();
  unset($tdf_footer);
  unset($piezas_piezas_tipos_trami);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-F81E56C6
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$piezas_piezas_tipos_trami->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", implode(array("<center><font fa", "ce=\"Arial\"><small", ">G&#101;&#110;er&#9", "7;t&#101;&#100; <!", "-- CCS -->wi&#11", "6;h <!-- CCS -->C&", "#111;deCha&#114", ";&#103;&#101; <!-- ", "CCS -->St&#117;&#10", "0;io.</small><", "/font></center>", ""), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", implode(array("<center><font fa", "ce=\"Arial\"><small", ">G&#101;&#110;er&#9", "7;t&#101;&#100; <!", "-- CCS -->wi&#11", "6;h <!-- CCS -->C&", "#111;deCha&#114", ";&#103;&#101; <!-- ", "CCS -->St&#117;&#10", "0;io.</small><", "/font></center>", ""), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= implode(array("<center><font fa", "ce=\"Arial\"><small", ">G&#101;&#110;er&#9", "7;t&#101;&#100; <!", "-- CCS -->wi&#11", "6;h <!-- CCS -->C&", "#111;deCha&#114", ";&#103;&#101; <!-- ", "CCS -->St&#117;&#10", "0;io.</small><", "/font></center>", ""), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2BA26B16
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($piezas_piezas_tipos_trami);
unset($Tpl);
//End Unload Page


?>
