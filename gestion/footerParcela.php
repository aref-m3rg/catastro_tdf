<?php

class clsGridfooterParcelaopciones { //opciones class @15-4AE4886F

//Variables @15-6E51DF5A

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

//Class_Initialize Event @15-FA22A3E4
  function clsGridfooterParcelaopciones($RelativePath, & $Parent)
  {
    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->ComponentName = "opciones";
    $this->Visible = True;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Grid opciones";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->DataSource = new clsfooterParcelaopcionesDataSource($this);
    $this->ds = & $this->DataSource;
    $this->PageSize = 20;
    if($this->PageSize == 0)
      $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
    $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
    if ($this->PageNumber <= 0) $this->PageNumber = 1;
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");

    $this->lnk_edit = new clsControl(ccsImageLink, "lnk_edit", "lnk_edit", ccsText, "", CCGetRequestParam("lnk_edit", ccsGet, NULL), $this);
    $this->lnk_edit->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "ccsForm"));
    $this->lnk_edit->Page = $this->RelativePath . "recordParcela.php";
    $this->direcciones = new clsControl(ccsImageLink, "direcciones", "direcciones", ccsText, "", CCGetRequestParam("direcciones", ccsGet, NULL), $this);
    $this->direcciones->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "ccsForm"));
    $this->direcciones->Parameters = CCAddParam($this->direcciones->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
    $this->direcciones->Page = $this->RelativePath . "gridDirParcela.php";
    $this->mejoras = new clsControl(ccsImageLink, "mejoras", "mejoras", ccsText, "", CCGetRequestParam("mejoras", ccsGet, NULL), $this);
    $this->mejoras->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "ccsForm"));
    $this->mejoras->Parameters = CCAddParam($this->mejoras->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
    $this->mejoras->Page = $this->RelativePath . "gridMejoras.php";
    $this->titular = new clsControl(ccsImageLink, "titular", "titular", ccsText, "", CCGetRequestParam("titular", ccsGet, NULL), $this);
    $this->titular->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "ccsForm"));
    $this->titular->Parameters = CCAddParam($this->titular->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
    $this->titular->Page = $this->RelativePath . "gridPersonas.php";
    $this->reporte = new clsControl(ccsImageLink, "reporte", "reporte", ccsText, "", CCGetRequestParam("reporte", ccsGet, NULL), $this);
    $this->reporte->Page = "../reportes/rpt_nom_pdf.php";
    $this->vuelta = new clsControl(ccsImageLink, "vuelta", "vuelta", ccsText, "", CCGetRequestParam("vuelta", ccsGet, NULL), $this);
    $this->vuelta->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "parcela_id", "ccsForm"));
    $this->vuelta->Page = $this->RelativePath . "gridParcelas.php";
    $this->poligono = new clsControl(ccsImageLink, "poligono", "poligono", ccsText, "", CCGetRequestParam("poligono", ccsGet, NULL), $this);
    $this->poligono->Page = "../cartografia/cartografia.php";
    $this->preparar = new clsControl(ccsImageLink, "preparar", "preparar", ccsText, "", CCGetRequestParam("preparar", ccsGet, NULL), $this);
    $this->preparar->Page = $this->RelativePath . "rpt_nomenclatura.php";
    $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
    $this->Label1->HTML = true;
    $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $this);
    $this->Label2->HTML = true;
    $this->afectaciones = new clsControl(ccsImageLink, "afectaciones", "afectaciones", ccsText, "", CCGetRequestParam("afectaciones", ccsGet, NULL), $this);
    $this->afectaciones->Page = "../gestion/parcelaAfectaciones.php";
  }
//End Class_Initialize Event

//Initialize Method @15-90E704C5
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
  }
//End Initialize Method

//Show Method @15-A96FD02A
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
    $this->Attributes->SetValue("RowNumber", "");
    $this->Attributes->Show();

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if(!$this->Visible) return;

    $GridBlock = "Grid " . $this->ComponentName;
    $ParentPath = $Tpl->block_path;
    $Tpl->block_path = $ParentPath . "/" . $GridBlock;


    if (!$this->IsEmpty) {
      $this->ControlsVisible["lnk_edit"] = $this->lnk_edit->Visible;
      $this->ControlsVisible["direcciones"] = $this->direcciones->Visible;
      $this->ControlsVisible["mejoras"] = $this->mejoras->Visible;
      $this->ControlsVisible["titular"] = $this->titular->Visible;
      $this->ControlsVisible["reporte"] = $this->reporte->Visible;
      $this->ControlsVisible["vuelta"] = $this->vuelta->Visible;
      $this->ControlsVisible["poligono"] = $this->poligono->Visible;
      $this->ControlsVisible["preparar"] = $this->preparar->Visible;
      $this->ControlsVisible["Label1"] = $this->Label1->Visible;
      $this->ControlsVisible["Label2"] = $this->Label2->Visible;
      $this->ControlsVisible["afectaciones"] = $this->afectaciones->Visible;
      while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
        $this->RowNumber++;
        if ($this->HasRecord) {
          $this->DataSource->next_record();
          $this->DataSource->SetValues();
        }
        $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
        $this->reporte->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "ccsForm"));
        $this->reporte->Parameters = CCAddParam($this->reporte->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->poligono->Parameters = CCGetQueryString("QueryString", array("new", "direcciones", "persona_id", "nro_partida", "parcela_partida", "ccsForm"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "old_parcela_partida", $this->DataSource->f("parcela_partida"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "old_parcela_id", $this->DataSource->f("parcela_id"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "servicio", $this->DataSource->f("gis_srv_name"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "departamento", $this->DataSource->f("tipo_depto_parc_id"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "seccion", $this->DataSource->f("parcela_seccion"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "macizo", $this->DataSource->f("parcela_macizo"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "parcela", $this->DataSource->f("parcela_parcela"));
        $this->poligono->Parameters = CCAddParam($this->poligono->Parameters, "padron", $this->DataSource->f("tipo_padron_parc_id"));
        $this->preparar->Parameters = CCGetQueryString("QueryString", array("new", "parcela_partida", "servicio", "ccsForm"));
        $this->preparar->Parameters = CCAddParam($this->preparar->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->afectaciones->Parameters = CCGetQueryString("QueryString", array("new", "direcciones", "persona_id", "ccsForm"));
        $this->afectaciones->Parameters = CCAddParam($this->afectaciones->Parameters, "parcela_partida", $this->DataSource->f("parcela_partida"));
        $this->afectaciones->Parameters = CCAddParam($this->afectaciones->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->afectaciones->Parameters = CCAddParam($this->afectaciones->Parameters, "servicio", $this->DataSource->f("gis_srv_name"));
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->lnk_edit->Show();
        $this->direcciones->Show();
        $this->mejoras->Show();
        $this->titular->Show();
        $this->reporte->Show();
        $this->vuelta->Show();
        $this->poligono->Show();
        $this->preparar->Show();
        $this->Label1->Show();
        $this->Label2->Show();
        $this->afectaciones->Show();
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

//GetErrors Method @15-AB3FA6CF
  function GetErrors()
  {
    $errors = "";
    $errors = ComposeStrings($errors, $this->lnk_edit->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direcciones->Errors->ToString());
    $errors = ComposeStrings($errors, $this->mejoras->Errors->ToString());
    $errors = ComposeStrings($errors, $this->titular->Errors->ToString());
    $errors = ComposeStrings($errors, $this->reporte->Errors->ToString());
    $errors = ComposeStrings($errors, $this->vuelta->Errors->ToString());
    $errors = ComposeStrings($errors, $this->poligono->Errors->ToString());
    $errors = ComposeStrings($errors, $this->preparar->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Label2->Errors->ToString());
    $errors = ComposeStrings($errors, $this->afectaciones->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
//End GetErrors Method

} //End opciones Class @15-FCB6E20C

class clsfooterParcelaopcionesDataSource extends clsDBtdf_nuevo {  //opcionesDataSource Class @15-BC4F3992

//DataSource Variables @15-404AA26D
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $CountSQL;
  public $wp;


//End DataSource Variables

//DataSourceClass_Initialize Event @15-CBEE7127
  function clsfooterParcelaopcionesDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Grid opciones";
    $this->Initialize();

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @15-24FF35BF
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "";
  }
//End SetOrder Method

//Prepare Method @15-0D07B81E
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], -1, false);
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->Where = 
       $this->wp->Criterion[1];
  }
//End Prepare Method

//Open Method @15-C2F24FEB
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM parcelas LEFT JOIN gis_servicios ON\n\n" .
    "parcelas.tipo_depto_parc_id = gis_servicios.dpto_id AND parcelas.tipo_padron_parc_id = gis_servicios.padron_id";
    $this->SQL = "SELECT parcelas.*, gis_srv_name \n\n" .
    "FROM parcelas LEFT JOIN gis_servicios ON\n\n" .
    "parcelas.tipo_depto_parc_id = gis_servicios.dpto_id AND parcelas.tipo_padron_parc_id = gis_servicios.padron_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @15-BAF0975B
  function SetValues()
  {
  }
//End SetValues Method

} //End opcionesDataSource Class @15-FCB6E20C

class clsfooterParcela { //footerParcela class @1-2A2B60C2

//Variables @1-51D7F06F
  public $ComponentType = "IncludablePage";
  public $Connections = array();
  public $FileName = "";
  public $Redirect = "";
  public $Tpl = "";
  public $TemplateFileName = "";
  public $BlockToParse = "";
  public $ComponentName = "";
  public $Attributes = "";

  // Events;
  public $CCSEvents = "";
  public $CCSEventResult = "";
  public $RelativePath;
  public $Visible;
  public $Parent;
//End Variables

//Class_Initialize Event @1-ADC91077
  function clsfooterParcela($RelativePath, $ComponentName, & $Parent)
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->ComponentName = $ComponentName;
    $this->RelativePath = $RelativePath;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->FileName = "footerParcela.php";
    $this->Redirect = "";
    $this->TemplateFileName = "footerParcela.html";
    $this->BlockToParse = "main";
    $this->TemplateEncoding = "CP1252";
    $this->ContentType = "text/html";
  }
//End Class_Initialize Event

//Class_Terminate Event @1-8D4CFB3E
  function Class_Terminate()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
    unset($this->opciones);
  }
//End Class_Terminate Event

//BindEvents Method @1-4DBC345E
  function BindEvents()
  {
    $this->opciones->lnk_edit->CCSEvents["BeforeShow"] = "footerParcela_opciones_lnk_edit_BeforeShow";
    $this->opciones->reporte->CCSEvents["BeforeShow"] = "footerParcela_opciones_reporte_BeforeShow";
    $this->opciones->CCSEvents["BeforeShowRow"] = "footerParcela_opciones_BeforeShowRow";
    $this->opciones->CCSEvents["BeforeShow"] = "footerParcela_opciones_BeforeShow";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize", $this);
  }
//End BindEvents Method

//Operations Method @1-7E2A14CF
  function Operations()
  {
    global $Redirect;
    if(!$this->Visible)
      return "";
  }
//End Operations Method

//Initialize Method @1-5C602B25
  function Initialize()
  {
    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CCSEvents["BeforeInitialize"] = "footerParcela_BeforeInitialize";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInitialize", $this);
    if(!$this->Visible)
      return "";
    $this->DBtdf_nuevo = new clsDBtdf_nuevo();
    $this->Connections["tdf_nuevo"] = & $this->DBtdf_nuevo;
    $this->Attributes = & $this->Parent->Attributes;

    // Create Components
    $this->opciones = new clsGridfooterParcelaopciones($this->RelativePath, $this);
    $this->opciones->Initialize();
    $this->BindEvents();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
  }
//End Initialize Method

//Show Method @1-70459E55
  function Show()
  {
    global $Tpl;
    global $CCSLocales;
    $block_path = $Tpl->block_path;
    $Tpl->LoadTemplate("/gestion/" . $this->TemplateFileName, $this->ComponentName, $this->TemplateEncoding, "remove");
    $Tpl->block_path = $Tpl->block_path . "/" . $this->ComponentName;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if(!$this->Visible) {
      $Tpl->block_path = $block_path;
      $Tpl->SetVar($this->ComponentName, "");
      return "";
    }
    $this->Attributes->Show();
    $this->opciones->Show();
    $Tpl->Parse();
    $Tpl->block_path = $block_path;
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeOutput", $this);
    $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
  }
//End Show Method

} //End footerParcela Class @1-FCB6E20C

//Include Event File @1-AC267D8B
include_once(RelativePath . "/gestion/footerParcela_events.php");
//End Include Event File
?>
