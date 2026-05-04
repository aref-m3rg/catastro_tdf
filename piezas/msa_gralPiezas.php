<?php
//Include Common Files @1-26E0A8AC
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_gralPiezas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @102-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @103-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @104-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsGridcreador_destino_origen_pa { //creador_destino_origen_pa class @2-350F84A9

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

//Class_Initialize Event @2-37A2E187
  function clsGridcreador_destino_origen_pa($RelativePath, & $Parent)
  {
    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->ComponentName = "creador_destino_origen_pa";
    $this->Visible = True;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Grid creador_destino_origen_pa";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->DataSource = new clscreador_destino_origen_paDataSource($this);
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

    $this->creador_unidad_p_nombre = new clsControl(ccsLabel, "creador_unidad_p_nombre", "creador_unidad_p_nombre", ccsText, "", CCGetRequestParam("creador_unidad_p_nombre", ccsGet, NULL), $this);
    $this->destino_unidad_p_nombre = new clsControl(ccsLabel, "destino_unidad_p_nombre", "destino_unidad_p_nombre", ccsText, "", CCGetRequestParam("destino_unidad_p_nombre", ccsGet, NULL), $this);
    $this->origen_unidad_p_nombre = new clsControl(ccsLabel, "origen_unidad_p_nombre", "origen_unidad_p_nombre", ccsText, "", CCGetRequestParam("origen_unidad_p_nombre", ccsGet, NULL), $this);
    $this->pase_f_pase = new clsControl(ccsLabel, "pase_f_pase", "pase_f_pase", ccsDate, array("dd", "/", "mm", "/", "yy"), CCGetRequestParam("pase_f_pase", ccsGet, NULL), $this);
    $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "pieza_descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", ccsGet, NULL), $this);
    $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, array("dd", "/", "mm", "/", "yy"), CCGetRequestParam("pieza_f_alta", ccsGet, NULL), $this);
    $this->pieza_tipo_abrev = new clsControl(ccsLabel, "pieza_tipo_abrev", "pieza_tipo_abrev", ccsText, "", CCGetRequestParam("pieza_tipo_abrev", ccsGet, NULL), $this);
    $this->tramite_abrev = new clsControl(ccsLabel, "tramite_abrev", "tramite_abrev", ccsText, "", CCGetRequestParam("tramite_abrev", ccsGet, NULL), $this);
    $this->pieza = new clsControl(ccsLabel, "pieza", "pieza", ccsText, "", CCGetRequestParam("pieza", ccsGet, NULL), $this);
    $this->confirmacion = new clsControl(ccsLabel, "confirmacion", "confirmacion", ccsText, "", CCGetRequestParam("confirmacion", ccsGet, NULL), $this);
    $this->rutaLnk = new clsControl(ccsImageLink, "rutaLnk", "rutaLnk", ccsText, "", CCGetRequestParam("rutaLnk", ccsGet, NULL), $this);
    $this->rutaLnk->Page = "../consultas/cns_ruta.php";
    $this->piezaLnk = new clsControl(ccsImageLink, "piezaLnk", "piezaLnk", ccsText, "", CCGetRequestParam("piezaLnk", ccsGet, NULL), $this);
    $this->piezaLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    $this->piezaLnk->Page = "";
    $this->entorno_abrev = new clsControl(ccsLabel, "entorno_abrev", "entorno_abrev", ccsText, "", CCGetRequestParam("entorno_abrev", ccsGet, NULL), $this);
    $this->tipo_tramites_descript = new clsControl(ccsLabel, "tipo_tramites_descript", "tipo_tramites_descript", ccsText, "", CCGetRequestParam("tipo_tramites_descript", ccsGet, NULL), $this);
    $this->creador_destino_origen_pa_TotalRecords = new clsControl(ccsLabel, "creador_destino_origen_pa_TotalRecords", "creador_destino_origen_pa_TotalRecords", ccsText, "", CCGetRequestParam("creador_destino_origen_pa_TotalRecords", ccsGet, NULL), $this);
    $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
    $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
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

//Show Method @2-29A25418
  function Show()
  {
    global $Tpl;
    global $CCSLocales;
    if(!$this->Visible) return;

    $this->RowNumber = 0;

    $this->DataSource->Parameters["expr26"] = 1;
    $this->DataSource->Parameters["expr27"] = 1;
    $this->DataSource->Parameters["expr54"] = 1;
    $this->DataSource->Parameters["expr55"] = 1;
    $this->DataSource->Parameters["urls_pieza_tipo_id"] = CCGetFromGet("s_pieza_tipo_id", NULL);
    $this->DataSource->Parameters["urls_tramite_id"] = CCGetFromGet("s_tramite_id", NULL);
    $this->DataSource->Parameters["urls_pieza_nro"] = CCGetFromGet("s_pieza_nro", NULL);
    $this->DataSource->Parameters["urls_pieza_letra"] = CCGetFromGet("s_pieza_letra", NULL);
    $this->DataSource->Parameters["urls_pieza_anio"] = CCGetFromGet("s_pieza_anio", NULL);
    $this->DataSource->Parameters["urls_pieza_descripcion"] = CCGetFromGet("s_pieza_descripcion", NULL);
    $this->DataSource->Parameters["urls_unidad_id"] = CCGetFromGet("s_unidad_id", NULL);
    $this->DataSource->Parameters["urlpase_confir_ext"] = CCGetFromGet("pase_confir_ext", NULL);

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
      $this->ControlsVisible["creador_unidad_p_nombre"] = $this->creador_unidad_p_nombre->Visible;
      $this->ControlsVisible["destino_unidad_p_nombre"] = $this->destino_unidad_p_nombre->Visible;
      $this->ControlsVisible["origen_unidad_p_nombre"] = $this->origen_unidad_p_nombre->Visible;
      $this->ControlsVisible["pase_f_pase"] = $this->pase_f_pase->Visible;
      $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
      $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
      $this->ControlsVisible["pieza_tipo_abrev"] = $this->pieza_tipo_abrev->Visible;
      $this->ControlsVisible["tramite_abrev"] = $this->tramite_abrev->Visible;
      $this->ControlsVisible["pieza"] = $this->pieza->Visible;
      $this->ControlsVisible["confirmacion"] = $this->confirmacion->Visible;
      $this->ControlsVisible["rutaLnk"] = $this->rutaLnk->Visible;
      $this->ControlsVisible["piezaLnk"] = $this->piezaLnk->Visible;
      $this->ControlsVisible["entorno_abrev"] = $this->entorno_abrev->Visible;
      $this->ControlsVisible["tipo_tramites_descript"] = $this->tipo_tramites_descript->Visible;
      while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
        $this->RowNumber++;
        if ($this->HasRecord) {
          $this->DataSource->next_record();
          $this->DataSource->SetValues();
        }
        $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
        $this->creador_unidad_p_nombre->SetValue($this->DataSource->creador_unidad_p_nombre->GetValue());
        $this->destino_unidad_p_nombre->SetValue($this->DataSource->destino_unidad_p_nombre->GetValue());
        $this->origen_unidad_p_nombre->SetValue($this->DataSource->origen_unidad_p_nombre->GetValue());
        $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
        $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
        $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
        $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
        $this->tramite_abrev->SetValue($this->DataSource->tramite_abrev->GetValue());
        $this->pieza->SetValue($this->DataSource->pieza->GetValue());
        $this->confirmacion->SetValue($this->DataSource->confirmacion->GetValue());
        $this->rutaLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->rutaLnk->Parameters = CCAddParam($this->rutaLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
        $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
        $this->tipo_tramites_descript->SetValue($this->DataSource->tipo_tramites_descript->GetValue());
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->creador_unidad_p_nombre->Show();
        $this->destino_unidad_p_nombre->Show();
        $this->origen_unidad_p_nombre->Show();
        $this->pase_f_pase->Show();
        $this->pieza_descripcion->Show();
        $this->pieza_f_alta->Show();
        $this->pieza_tipo_abrev->Show();
        $this->tramite_abrev->Show();
        $this->pieza->Show();
        $this->confirmacion->Show();
        $this->rutaLnk->Show();
        $this->piezaLnk->Show();
        $this->entorno_abrev->Show();
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
    $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
    $this->Navigator->PageSize = $this->PageSize;
    if ($this->DataSource->RecordsCount == "CCS not counted")
      $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
    else
      $this->Navigator->TotalPages = $this->DataSource->PageCount();
    if ($this->Navigator->TotalPages <= 1) {
      $this->Navigator->Visible = false;
    }
    $this->creador_destino_origen_pa_TotalRecords->Show();
    $this->Navigator->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

//GetErrors Method @2-DFCC9A99
  function GetErrors()
  {
    $errors = "";
    $errors = ComposeStrings($errors, $this->creador_unidad_p_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->destino_unidad_p_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->origen_unidad_p_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pase_f_pase->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_descripcion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_f_alta->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza_tipo_abrev->Errors->ToString());
    $errors = ComposeStrings($errors, $this->tramite_abrev->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pieza->Errors->ToString());
    $errors = ComposeStrings($errors, $this->confirmacion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->rutaLnk->Errors->ToString());
    $errors = ComposeStrings($errors, $this->piezaLnk->Errors->ToString());
    $errors = ComposeStrings($errors, $this->entorno_abrev->Errors->ToString());
    $errors = ComposeStrings($errors, $this->tipo_tramites_descript->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
//End GetErrors Method

} //End creador_destino_origen_pa Class @2-FCB6E20C

class clscreador_destino_origen_paDataSource extends clsDBmesa {  //creador_destino_origen_paDataSource Class @2-A214726E

//DataSource Variables @2-F3F11013
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $CountSQL;
  public $wp;


  // Datasource fields
  public $creador_unidad_p_nombre;
  public $destino_unidad_p_nombre;
  public $origen_unidad_p_nombre;
  public $pase_f_pase;
  public $pieza_descripcion;
  public $pieza_f_alta;
  public $pieza_tipo_abrev;
  public $tramite_abrev;
  public $pieza;
  public $confirmacion;
  public $entorno_abrev;
  public $tipo_tramites_descript;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-5984FF74
  function clscreador_destino_origen_paDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Grid creador_destino_origen_pa";
    $this->Initialize();
    $this->creador_unidad_p_nombre = new clsField("creador_unidad_p_nombre", ccsText, "");
    
    $this->destino_unidad_p_nombre = new clsField("destino_unidad_p_nombre", ccsText, "");
    
    $this->origen_unidad_p_nombre = new clsField("origen_unidad_p_nombre", ccsText, "");
    
    $this->pase_f_pase = new clsField("pase_f_pase", ccsDate, $this->DateFormat);
    
    $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
    
    $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
    
    $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
    
    $this->tramite_abrev = new clsField("tramite_abrev", ccsText, "");
    
    $this->pieza = new clsField("pieza", ccsText, "");
    
    $this->confirmacion = new clsField("confirmacion", ccsText, "");
    
    $this->entorno_abrev = new clsField("entorno_abrev", ccsText, "");
    
    $this->tipo_tramites_descript = new clsField("tipo_tramites_descript", ccsText, "");
    

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-E6E219B8
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "piezas.pieza_f_alta desc";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      "");
  }
//End SetOrder Method

//Prepare Method @2-637D094D
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "expr26", ccsInteger, "", "", $this->Parameters["expr26"], "", false);
    $this->wp->AddParameter("2", "expr27", ccsInteger, "", "", $this->Parameters["expr27"], "", false);
    $this->wp->AddParameter("3", "expr54", ccsInteger, "", "", $this->Parameters["expr54"], "", false);
    $this->wp->AddParameter("4", "expr55", ccsInteger, "", "", $this->Parameters["expr55"], "", false);
    $this->wp->AddParameter("5", "urls_pieza_tipo_id", ccsInteger, "", "", $this->Parameters["urls_pieza_tipo_id"], "", false);
    $this->wp->AddParameter("6", "urls_tramite_id", ccsInteger, "", "", $this->Parameters["urls_tramite_id"], "", false);
    $this->wp->AddParameter("7", "urls_pieza_nro", ccsInteger, "", "", $this->Parameters["urls_pieza_nro"], "", false);
    $this->wp->AddParameter("8", "urls_pieza_letra", ccsText, "", "", $this->Parameters["urls_pieza_letra"], "", false);
    $this->wp->AddParameter("9", "urls_pieza_anio", ccsInteger, "", "", $this->Parameters["urls_pieza_anio"], "", false);
    $this->wp->AddParameter("10", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("11", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("12", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("13", "urls_pieza_descripcion", ccsMemo, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("14", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("15", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("16", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("17", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("18", "urls_pieza_descripcion", ccsText, "", "", $this->Parameters["urls_pieza_descripcion"], "", false);
    $this->wp->AddParameter("19", "urls_unidad_id", ccsInteger, "", "", $this->Parameters["urls_unidad_id"], "", false);
    $this->wp->AddParameter("20", "urlpase_confir_ext", ccsInteger, "", "", $this->Parameters["urlpase_confir_ext"], "", false);
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "creador.unidad_p_activo", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
    $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "destino.unidad_p_activo", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
    $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "origen.unidad_p_activo", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
    $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "piezas.pieza_tipo_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
    $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "tramites.tramite_id", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
    $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "piezas.pieza_nro", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsInteger),false);
    $this->wp->Criterion[8] = $this->wp->Operation(opContains, "piezas.pieza_letra", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsText),false);
    $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "piezas.pieza_anio", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsInteger),false);
    $this->wp->Criterion[10] = $this->wp->Operation(opContains, "piezas.pieza_descripcion", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
    $this->wp->Criterion[11] = $this->wp->Operation(opContains, "piezas.pieza_letra", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
    $this->wp->Criterion[12] = $this->wp->Operation(opContains, "piezas.pieza_iniciador", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
    $this->wp->Criterion[13] = $this->wp->Operation(opContains, "piezas.pieza_txt", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsMemo),false);
    $this->wp->Criterion[14] = $this->wp->Operation(opContains, "piezas.pieza_ref", $this->wp->GetDBValue("14"), $this->ToSQL($this->wp->GetDBValue("14"), ccsText),false);
    $this->wp->Criterion[15] = $this->wp->Operation(opContains, "piezas.pieza_destinatario", $this->wp->GetDBValue("15"), $this->ToSQL($this->wp->GetDBValue("15"), ccsText),false);
    $this->wp->Criterion[16] = $this->wp->Operation(opContains, "piezas.pieza_of_destinatario", $this->wp->GetDBValue("16"), $this->ToSQL($this->wp->GetDBValue("16"), ccsText),false);
    $this->wp->Criterion[17] = $this->wp->Operation(opContains, "piezas.pieza_autor", $this->wp->GetDBValue("17"), $this->ToSQL($this->wp->GetDBValue("17"), ccsText),false);
    $this->wp->Criterion[18] = $this->wp->Operation(opContains, "piezas.pieza_observaciones", $this->wp->GetDBValue("18"), $this->ToSQL($this->wp->GetDBValue("18"), ccsText),false);
    $this->wp->Criterion[19] = $this->wp->Operation(opEqual, "creador.unidad_id", $this->wp->GetDBValue("19"), $this->ToSQL($this->wp->GetDBValue("19"), ccsInteger),false);
    $this->wp->Criterion[20] = $this->wp->Operation(opEqual, "pases.pase_confir_ext", $this->wp->GetDBValue("20"), $this->ToSQL($this->wp->GetDBValue("20"), ccsInteger),false);
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
       $this->wp->Criterion[9]), $this->wp->opOR(
       true, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, 
       $this->wp->Criterion[10], 
       $this->wp->Criterion[11]), 
       $this->wp->Criterion[12]), 
       $this->wp->Criterion[13]), 
       $this->wp->Criterion[14]), 
       $this->wp->Criterion[15]), 
       $this->wp->Criterion[16]), 
       $this->wp->Criterion[17]), 
       $this->wp->Criterion[18])), 
       $this->wp->Criterion[19]), 
       $this->wp->Criterion[20]);
  }
//End Prepare Method

//Open Method @2-B2C98D3A
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM ((((((((piezas INNER JOIN pases ON\n\n" .
    "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
    "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
    "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param creador ON\n\n" .
    "piezas.unidad_id = creador.unidad_id) LEFT JOIN adjuntos ON\n\n" .
    "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN entornos ON\n\n" .
    "piezas.entorno_id = entornos.entorno_id) INNER JOIN tipos_tramites ON\n\n" .
    "piezas.tipo_tramites_id = tipos_tramites.tipo_tramites_id) INNER JOIN unidades_param origen ON\n\n" .
    "pases.ori_unidad_id = origen.unidad_id) INNER JOIN unidades_param destino ON\n\n" .
    "pases.des_unidad_id = destino.unidad_id";
    $this->SQL = "SELECT tramite_abrev, pieza_tipo_abrev, creador.unidad_p_nombre AS creador_unidad_p_nombre, pase_f_pase, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza,\n\n" .
    "piezas.pieza_id AS pieza_id, pieza_descripcion, pieza_f_alta, origen.unidad_p_nombre AS origen_unidad_p_nombre, CONCAT_WS('',destino.unidad_p_nombre,IF(pieza_archivada,' (archivada)','')) AS destino_unidad_p_nombre,\n\n" .
    "pase_id, pase_f_confirma, IF(pase_confirmado,IF(pase_confir_ext,'Pendiente a Confirmar','Confirmado'),'Sin Confirmar') AS confirmacion,\n\n" .
    "pase_confirmado, entorno_abrev, tipo_tramites_descript \n\n" .
    "FROM ((((((((piezas INNER JOIN pases ON\n\n" .
    "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
    "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) INNER JOIN tramites ON\n\n" .
    "piezas.tramite_id = tramites.tramite_id) INNER JOIN unidades_param creador ON\n\n" .
    "piezas.unidad_id = creador.unidad_id) LEFT JOIN adjuntos ON\n\n" .
    "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN entornos ON\n\n" .
    "piezas.entorno_id = entornos.entorno_id) INNER JOIN tipos_tramites ON\n\n" .
    "piezas.tipo_tramites_id = tipos_tramites.tipo_tramites_id) INNER JOIN unidades_param origen ON\n\n" .
    "pases.ori_unidad_id = origen.unidad_id) INNER JOIN unidades_param destino ON\n\n" .
    "pases.des_unidad_id = destino.unidad_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @2-8DC14601
  function SetValues()
  {
    $this->creador_unidad_p_nombre->SetDBValue($this->f("creador_unidad_p_nombre"));
    $this->destino_unidad_p_nombre->SetDBValue($this->f("destino_unidad_p_nombre"));
    $this->origen_unidad_p_nombre->SetDBValue($this->f("origen_unidad_p_nombre"));
    $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
    $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
    $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
    $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
    $this->tramite_abrev->SetDBValue($this->f("tramite_abrev"));
    $this->pieza->SetDBValue($this->f("pieza"));
    $this->confirmacion->SetDBValue($this->f("confirmacion"));
    $this->entorno_abrev->SetDBValue($this->f("entorno_abrev"));
    $this->tipo_tramites_descript->SetDBValue($this->f("tipo_tramites_descript"));
  }
//End SetValues Method

} //End creador_destino_origen_paDataSource Class @2-FCB6E20C

class clsRecordcreador_destino_origen_pa1 { //creador_destino_origen_pa1 Class @60-3D9D4C9A

//Variables @60-9E315808

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

//Class_Initialize Event @60-85F42F37
  function clsRecordcreador_destino_origen_pa1($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record creador_destino_origen_pa1/Error";
    $this->ReadAllowed = true;
    if($this->Visible)
    {
      $this->ComponentName = "creador_destino_origen_pa1";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
      $this->s_pieza_tipo_id = new clsControl(ccsListBox, "s_pieza_tipo_id", "s_pieza_tipo_id", ccsInteger, "", CCGetRequestParam("s_pieza_tipo_id", $Method, NULL), $this);
      $this->s_pieza_tipo_id->DSType = dsTable;
      $this->s_pieza_tipo_id->DataSource = new clsDBmesa();
      $this->s_pieza_tipo_id->ds = & $this->s_pieza_tipo_id->DataSource;
      $this->s_pieza_tipo_id->DataSource->SQL = "SELECT * \n" .
"FROM piezas_tipos {SQL_Where} {SQL_OrderBy}";
      list($this->s_pieza_tipo_id->BoundColumn, $this->s_pieza_tipo_id->TextColumn, $this->s_pieza_tipo_id->DBFormat) = array("pieza_tipo_id", "pieza_tipo_desc", "");
      $this->s_tramite_id = new clsControl(ccsListBox, "s_tramite_id", "s_tramite_id", ccsInteger, "", CCGetRequestParam("s_tramite_id", $Method, NULL), $this);
      $this->s_tramite_id->DSType = dsTable;
      $this->s_tramite_id->DataSource = new clsDBmesa();
      $this->s_tramite_id->ds = & $this->s_tramite_id->DataSource;
      $this->s_tramite_id->DataSource->SQL = "SELECT * \n" .
"FROM tramites {SQL_Where} {SQL_OrderBy}";
      list($this->s_tramite_id->BoundColumn, $this->s_tramite_id->TextColumn, $this->s_tramite_id->DBFormat) = array("tramite_id", "tramite_desc", "");
      $this->s_pieza_nro = new clsControl(ccsTextBox, "s_pieza_nro", "s_pieza_nro", ccsInteger, "", CCGetRequestParam("s_pieza_nro", $Method, NULL), $this);
      $this->s_pieza_descripcion = new clsControl(ccsTextBox, "s_pieza_descripcion", "s_pieza_descripcion", ccsText, "", CCGetRequestParam("s_pieza_descripcion", $Method, NULL), $this);
      $this->s_unidad_id = new clsControl(ccsListBox, "s_unidad_id", "s_unidad_id", ccsInteger, "", CCGetRequestParam("s_unidad_id", $Method, NULL), $this);
      $this->s_unidad_id->DSType = dsTable;
      $this->s_unidad_id->DataSource = new clsDBunidades();
      $this->s_unidad_id->ds = & $this->s_unidad_id->DataSource;
      $this->s_unidad_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades_param {SQL_Where} {SQL_OrderBy}";
      list($this->s_unidad_id->BoundColumn, $this->s_unidad_id->TextColumn, $this->s_unidad_id->DBFormat) = array("unidad_id", "unidad_p_nombre", "");
      $this->s_unidad_id->DataSource->Parameters["expr77"] = 1;
      $this->s_unidad_id->DataSource->wp = new clsSQLParameters();
      $this->s_unidad_id->DataSource->wp->AddParameter("1", "expr77", ccsInteger, "", "", $this->s_unidad_id->DataSource->Parameters["expr77"], "", false);
      $this->s_unidad_id->DataSource->wp->Criterion[1] = $this->s_unidad_id->DataSource->wp->Operation(opEqual, "unidad_p_activo", $this->s_unidad_id->DataSource->wp->GetDBValue("1"), $this->s_unidad_id->DataSource->ToSQL($this->s_unidad_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
      $this->s_unidad_id->DataSource->Where = 
         $this->s_unidad_id->DataSource->wp->Criterion[1];
      $this->s_pieza_letra = new clsControl(ccsTextBox, "s_pieza_letra", "s_pieza_letra", ccsText, "", CCGetRequestParam("s_pieza_letra", $Method, NULL), $this);
      $this->s_pieza_anio = new clsControl(ccsTextBox, "s_pieza_anio", "s_pieza_anio", ccsInteger, "", CCGetRequestParam("s_pieza_anio", $Method, NULL), $this);
      $this->Button1 = new clsButton("Button1", $Method, $this);
      $this->Button2 = new clsButton("Button2", $Method, $this);
      $this->pase_confir_ext = new clsControl(ccsCheckBox, "pase_confir_ext", "pase_confir_ext", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("pase_confir_ext", $Method, NULL), $this);
      $this->pase_confir_ext->CheckedValue = true;
      $this->pase_confir_ext->UncheckedValue = false;
      if(!$this->FormSubmitted) {
        if(!is_array($this->pase_confir_ext->Value) && !strlen($this->pase_confir_ext->Value) && $this->pase_confir_ext->Value !== false)
          $this->pase_confir_ext->SetValue(false);
      }
    }
  }
//End Class_Initialize Event

//Validate Method @60-21434527
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->s_pieza_tipo_id->Validate() && $Validation);
    $Validation = ($this->s_tramite_id->Validate() && $Validation);
    $Validation = ($this->s_pieza_nro->Validate() && $Validation);
    $Validation = ($this->s_pieza_descripcion->Validate() && $Validation);
    $Validation = ($this->s_unidad_id->Validate() && $Validation);
    $Validation = ($this->s_pieza_letra->Validate() && $Validation);
    $Validation = ($this->s_pieza_anio->Validate() && $Validation);
    $Validation = ($this->pase_confir_ext->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->s_pieza_tipo_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_tramite_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_pieza_nro->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_pieza_descripcion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_unidad_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_pieza_letra->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_pieza_anio->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pase_confir_ext->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @60-1A897AD7
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->s_pieza_tipo_id->Errors->Count());
    $errors = ($errors || $this->s_tramite_id->Errors->Count());
    $errors = ($errors || $this->s_pieza_nro->Errors->Count());
    $errors = ($errors || $this->s_pieza_descripcion->Errors->Count());
    $errors = ($errors || $this->s_unidad_id->Errors->Count());
    $errors = ($errors || $this->s_pieza_letra->Errors->Count());
    $errors = ($errors || $this->s_pieza_anio->Errors->Count());
    $errors = ($errors || $this->pase_confir_ext->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @60-ED598703
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

//Operation Method @60-6A722A84
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
      } else if($this->Button2->Pressed) {
        $this->PressedButton = "Button2";
      }
    }
    $Redirect = "msa_gralPiezas.php";
    if($this->PressedButton == "Button1") {
      $Redirect = "msa_principal.php";
      if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
        $Redirect = "";
      }
    } else if($this->PressedButton == "Button2") {
      if(!CCGetEvent($this->Button2->CCSEvents, "OnClick", $this->Button2)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_DoSearch") {
        $Redirect = "msa_gralPiezas.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y", "Button2", "Button2_x", "Button2_y")));
        if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
          $Redirect = "";
        }
      }
    } else {
      $Redirect = "";
    }
  }
//End Operation Method

//Show Method @60-EF3289E9
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

    $this->s_pieza_tipo_id->Prepare();
    $this->s_tramite_id->Prepare();
    $this->s_unidad_id->Prepare();

    $RecordBlock = "Record " . $this->ComponentName;
    $ParentPath = $Tpl->block_path;
    $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
    $this->EditMode = $this->EditMode && $this->ReadAllowed;
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->s_pieza_tipo_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_tramite_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_pieza_nro->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_pieza_descripcion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_unidad_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_pieza_letra->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_pieza_anio->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pase_confir_ext->Errors->ToString());
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
    $this->s_pieza_tipo_id->Show();
    $this->s_tramite_id->Show();
    $this->s_pieza_nro->Show();
    $this->s_pieza_descripcion->Show();
    $this->s_unidad_id->Show();
    $this->s_pieza_letra->Show();
    $this->s_pieza_anio->Show();
    $this->Button1->Show();
    $this->Button2->Show();
    $this->pase_confir_ext->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
  }
//End Show Method

} //End creador_destino_origen_pa1 Class @60-FCB6E20C





//Initialize Page @1-1FC299EA
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
$TemplateFileName = "msa_gralPiezas.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-29707889
include_once("./msa_gralPiezas_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-AF1DA7E0
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$DBunidades = new clsDBunidades();
$MainPage->Connections["unidades"] = & $DBunidades;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$creador_destino_origen_pa = new clsGridcreador_destino_origen_pa("", $MainPage);
$creador_destino_origen_pa1 = new clsRecordcreador_destino_origen_pa1("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->creador_destino_origen_pa = & $creador_destino_origen_pa;
$MainPage->creador_destino_origen_pa1 = & $creador_destino_origen_pa1;
$creador_destino_origen_pa->Initialize();

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

//Execute Components @1-0E882187
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$creador_destino_origen_pa1->Operation();
//End Execute Components

//Go to destination page @1-FE72829C
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBmesa->close();
  $DBunidades->close();
  header("Location: " . $Redirect);
  $tdf_header->Class_Terminate();
  unset($tdf_header);
  $tdf_menu->Class_Terminate();
  unset($tdf_menu);
  $tdf_footer->Class_Terminate();
  unset($tdf_footer);
  unset($creador_destino_origen_pa);
  unset($creador_destino_origen_pa1);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-0B2307B5
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$creador_destino_origen_pa->Show();
$creador_destino_origen_pa1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$IKGRPK5E1N6N = "<center><font face=\"Arial\"><small>G&#101;&#110;erate&#100; <!-- CCS -->&#119;it&#104; <!-- CCS -->&#67;ode&#67;h&#97;rg&#101; <!-- CCS -->St&#117;d&#105;&#111;.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", $IKGRPK5E1N6N . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", $IKGRPK5E1N6N . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= $IKGRPK5E1N6N;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-DC0110FB
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$DBunidades->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($creador_destino_origen_pa);
unset($creador_destino_origen_pa1);
unset($Tpl);
//End Unload Page


?>
