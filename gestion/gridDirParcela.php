<?php
//Include Common Files @1-2C521C5F
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "gridDirParcela.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsGridd_real { //d_real class @6-28E25EB5

//Variables @6-6E51DF5A

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

//Class_Initialize Event @6-1AF468A7
  function clsGridd_real($RelativePath, & $Parent)
  {
    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->ComponentName = "d_real";
    $this->Visible = True;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Grid d_real";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->DataSource = new clsd_realDataSource($this);
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

    $this->calles_calle_nombre = new clsControl(ccsLabel, "calles_calle_nombre", "calles_calle_nombre", ccsText, "", CCGetRequestParam("calles_calle_nombre", ccsGet, NULL), $this);
    $this->barrios_barrio_nombre = new clsControl(ccsLabel, "barrios_barrio_nombre", "barrios_barrio_nombre", ccsText, "", CCGetRequestParam("barrios_barrio_nombre", ccsGet, NULL), $this);
    $this->localidades_localidad_nombre = new clsControl(ccsLabel, "localidades_localidad_nombre", "localidades_localidad_nombre", ccsText, "", CCGetRequestParam("localidades_localidad_nombre", ccsGet, NULL), $this);
    $this->direccion_manzana = new clsControl(ccsLabel, "direccion_manzana", "direccion_manzana", ccsText, "", CCGetRequestParam("direccion_manzana", ccsGet, NULL), $this);
    $this->direccion_casa = new clsControl(ccsLabel, "direccion_casa", "direccion_casa", ccsText, "", CCGetRequestParam("direccion_casa", ccsGet, NULL), $this);
    $this->editR = new clsControl(ccsImageLink, "editR", "editR", ccsText, "", CCGetRequestParam("editR", ccsGet, NULL), $this);
    $this->editR->Page = "";
    $this->calles_calle_nro = new clsControl(ccsLabel, "calles_calle_nro", "calles_calle_nro", ccsInteger, "", CCGetRequestParam("calles_calle_nro", ccsGet, NULL), $this);
    $this->direccion_depto = new clsControl(ccsLabel, "direccion_depto", "direccion_depto", ccsText, "", CCGetRequestParam("direccion_depto", ccsGet, NULL), $this);
    $this->direccion_piso = new clsControl(ccsLabel, "direccion_piso", "direccion_piso", ccsText, "", CCGetRequestParam("direccion_piso", ccsGet, NULL), $this);
    $this->panel = new clsPanel("panel", $this);
    $this->addDr = new clsControl(ccsImageLink, "addDr", "addDr", ccsText, "", CCGetRequestParam("addDr", ccsGet, NULL), $this);
    $this->addDr->Page = "";
    $this->panel->AddComponent("addDr", $this->addDr);
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

//Show Method @6-C50C52CE
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
      $this->ControlsVisible["calles_calle_nombre"] = $this->calles_calle_nombre->Visible;
      $this->ControlsVisible["barrios_barrio_nombre"] = $this->barrios_barrio_nombre->Visible;
      $this->ControlsVisible["localidades_localidad_nombre"] = $this->localidades_localidad_nombre->Visible;
      $this->ControlsVisible["direccion_manzana"] = $this->direccion_manzana->Visible;
      $this->ControlsVisible["direccion_casa"] = $this->direccion_casa->Visible;
      $this->ControlsVisible["editR"] = $this->editR->Visible;
      $this->ControlsVisible["calles_calle_nro"] = $this->calles_calle_nro->Visible;
      $this->ControlsVisible["direccion_depto"] = $this->direccion_depto->Visible;
      $this->ControlsVisible["direccion_piso"] = $this->direccion_piso->Visible;
      while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
        $this->RowNumber++;
        if ($this->HasRecord) {
          $this->DataSource->next_record();
          $this->DataSource->SetValues();
        }
        $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
        $this->calles_calle_nombre->SetValue($this->DataSource->calles_calle_nombre->GetValue());
        $this->barrios_barrio_nombre->SetValue($this->DataSource->barrios_barrio_nombre->GetValue());
        $this->localidades_localidad_nombre->SetValue($this->DataSource->localidades_localidad_nombre->GetValue());
        $this->direccion_manzana->SetValue($this->DataSource->direccion_manzana->GetValue());
        $this->direccion_casa->SetValue($this->DataSource->direccion_casa->GetValue());
        $this->editR->Parameters = CCGetQueryString("QueryString", array("add", "ccsForm"));
        $this->editR->Parameters = CCAddParam($this->editR->Parameters, "direccion_id", $this->DataSource->f("direccion_id"));
        $this->editR->Parameters = CCAddParam($this->editR->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->editR->Parameters = CCAddParam($this->editR->Parameters, "tipo", R);
        $this->calles_calle_nro->SetValue($this->DataSource->calles_calle_nro->GetValue());
        $this->direccion_depto->SetValue($this->DataSource->direccion_depto->GetValue());
        $this->direccion_piso->SetValue($this->DataSource->direccion_piso->GetValue());
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->calles_calle_nombre->Show();
        $this->barrios_barrio_nombre->Show();
        $this->localidades_localidad_nombre->Show();
        $this->direccion_manzana->Show();
        $this->direccion_casa->Show();
        $this->editR->Show();
        $this->calles_calle_nro->Show();
        $this->direccion_depto->Show();
        $this->direccion_piso->Show();
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
    $this->addDr->Parameters = CCGetQueryString("QueryString", array("direccion_id", "ccsForm"));
    $this->addDr->Parameters = CCAddParam($this->addDr->Parameters, "tipo", R);
    $this->addDr->Parameters = CCAddParam($this->addDr->Parameters, "add", 1);
    $this->panel->Show();
    $this->addDr->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

//GetErrors Method @6-276EE652
  function GetErrors()
  {
    $errors = "";
    $errors = ComposeStrings($errors, $this->calles_calle_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->barrios_barrio_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->localidades_localidad_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_manzana->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_casa->Errors->ToString());
    $errors = ComposeStrings($errors, $this->editR->Errors->ToString());
    $errors = ComposeStrings($errors, $this->calles_calle_nro->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_depto->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_piso->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
//End GetErrors Method

} //End d_real Class @6-FCB6E20C

class clsd_realDataSource extends clsDBtdf_nuevo {  //d_realDataSource Class @6-7E5642D5

//DataSource Variables @6-017F58A0
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $CountSQL;
  public $wp;


  // Datasource fields
  public $calles_calle_nombre;
  public $barrios_barrio_nombre;
  public $localidades_localidad_nombre;
  public $direccion_manzana;
  public $direccion_casa;
  public $calles_calle_nro;
  public $direccion_depto;
  public $direccion_piso;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-8A04F53B
  function clsd_realDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Grid d_real";
    $this->Initialize();
    $this->calles_calle_nombre = new clsField("calles_calle_nombre", ccsText, "");
    
    $this->barrios_barrio_nombre = new clsField("barrios_barrio_nombre", ccsText, "");
    
    $this->localidades_localidad_nombre = new clsField("localidades_localidad_nombre", ccsText, "");
    
    $this->direccion_manzana = new clsField("direccion_manzana", ccsText, "");
    
    $this->direccion_casa = new clsField("direccion_casa", ccsText, "");
    
    $this->calles_calle_nro = new clsField("calles_calle_nro", ccsInteger, "");
    
    $this->direccion_depto = new clsField("direccion_depto", ccsText, "");
    
    $this->direccion_piso = new clsField("direccion_piso", ccsText, "");
    

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-9E1383D1
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      "");
  }
//End SetOrder Method

//Prepare Method @6-0D07B81E
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

//Open Method @6-E1255541
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM (((((direcciones LEFT JOIN barrios ON\n\n" .
    "direcciones.barrio_id = barrios.barrio_id) LEFT JOIN calles ON\n\n" .
    "direcciones.calle_id = calles.calle_id) LEFT JOIN tipos_direcciones ON\n\n" .
    "direcciones.tipo_direccion_id = tipos_direcciones.tipo_direccion_id) RIGHT JOIN parcelas ON\n\n" .
    "parcelas.direccion_id_real = direcciones.direccion_id) LEFT JOIN localidades ON\n\n" .
    "direcciones.localidad_id = localidades.localidad_id) LEFT JOIN departamentos ON\n\n" .
    "departamentos.dpto_id = direcciones.departamento_id";
    $this->SQL = "SELECT IFNULL(calles.calle_nombre,parcela_calle) AS calles_calle_nombre, barrios.barrio_nombre AS barrios_barrio_nombre, tipo_direccion_descrip,\n\n" .
    "IFNULL(direccion_numeracion,parcela_nro) AS calles_calle_nro, localidades.localidad_nombre AS localidades_localidad_nombre,\n\n" .
    "direcciones.barrio_nombre AS direcciones_barrio_nombre, direccion_manzana, direccion_casa, direccion_piso, direccion_depto,\n\n" .
    "direccion_area, direccion_torre, direccion_lote, direccion_id, parcela_id, dpto_desc \n\n" .
    "FROM (((((direcciones LEFT JOIN barrios ON\n\n" .
    "direcciones.barrio_id = barrios.barrio_id) LEFT JOIN calles ON\n\n" .
    "direcciones.calle_id = calles.calle_id) LEFT JOIN tipos_direcciones ON\n\n" .
    "direcciones.tipo_direccion_id = tipos_direcciones.tipo_direccion_id) RIGHT JOIN parcelas ON\n\n" .
    "parcelas.direccion_id_real = direcciones.direccion_id) LEFT JOIN localidades ON\n\n" .
    "direcciones.localidad_id = localidades.localidad_id) LEFT JOIN departamentos ON\n\n" .
    "departamentos.dpto_id = direcciones.departamento_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @6-12B50FF4
  function SetValues()
  {
    $this->calles_calle_nombre->SetDBValue($this->f("calles_calle_nombre"));
    $this->barrios_barrio_nombre->SetDBValue($this->f("barrios_barrio_nombre"));
    $this->localidades_localidad_nombre->SetDBValue($this->f("localidades_localidad_nombre"));
    $this->direccion_manzana->SetDBValue($this->f("direccion_manzana"));
    $this->direccion_casa->SetDBValue($this->f("direccion_casa"));
    $this->calles_calle_nro->SetDBValue(trim($this->f("calles_calle_nro")));
    $this->direccion_depto->SetDBValue($this->f("direccion_depto"));
    $this->direccion_piso->SetDBValue($this->f("direccion_piso"));
  }
//End SetValues Method

} //End d_realDataSource Class @6-FCB6E20C

class clsGridd_postal { //d_postal class @117-F21F3F77

//Variables @117-6E51DF5A

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

//Class_Initialize Event @117-EE17194B
  function clsGridd_postal($RelativePath, & $Parent)
  {
    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->ComponentName = "d_postal";
    $this->Visible = True;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Grid d_postal";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->DataSource = new clsd_postalDataSource($this);
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

    $this->calles_calle_nombre = new clsControl(ccsLabel, "calles_calle_nombre", "calles_calle_nombre", ccsText, "", CCGetRequestParam("calles_calle_nombre", ccsGet, NULL), $this);
    $this->barrios_barrio_nombre = new clsControl(ccsLabel, "barrios_barrio_nombre", "barrios_barrio_nombre", ccsText, "", CCGetRequestParam("barrios_barrio_nombre", ccsGet, NULL), $this);
    $this->localidades_localidad_nombre = new clsControl(ccsLabel, "localidades_localidad_nombre", "localidades_localidad_nombre", ccsText, "", CCGetRequestParam("localidades_localidad_nombre", ccsGet, NULL), $this);
    $this->direccion_manzana = new clsControl(ccsLabel, "direccion_manzana", "direccion_manzana", ccsText, "", CCGetRequestParam("direccion_manzana", ccsGet, NULL), $this);
    $this->direccion_casa = new clsControl(ccsLabel, "direccion_casa", "direccion_casa", ccsText, "", CCGetRequestParam("direccion_casa", ccsGet, NULL), $this);
    $this->editP = new clsControl(ccsImageLink, "editP", "editP", ccsText, "", CCGetRequestParam("editP", ccsGet, NULL), $this);
    $this->editP->Page = "";
    $this->departamentos_departamento_nombre = new clsControl(ccsLabel, "departamentos_departamento_nombre", "departamentos_departamento_nombre", ccsText, "", CCGetRequestParam("departamentos_departamento_nombre", ccsGet, NULL), $this);
    $this->provincias_provincia_nombre = new clsControl(ccsLabel, "provincias_provincia_nombre", "provincias_provincia_nombre", ccsText, "", CCGetRequestParam("provincias_provincia_nombre", ccsGet, NULL), $this);
    $this->direccion_numeracion = new clsControl(ccsLabel, "direccion_numeracion", "direccion_numeracion", ccsInteger, "", CCGetRequestParam("direccion_numeracion", ccsGet, NULL), $this);
    $this->direccion_piso = new clsControl(ccsLabel, "direccion_piso", "direccion_piso", ccsText, "", CCGetRequestParam("direccion_piso", ccsGet, NULL), $this);
    $this->direccion_depto = new clsControl(ccsLabel, "direccion_depto", "direccion_depto", ccsText, "", CCGetRequestParam("direccion_depto", ccsGet, NULL), $this);
    $this->panel = new clsPanel("panel", $this);
    $this->addDp = new clsControl(ccsImageLink, "addDp", "addDp", ccsText, "", CCGetRequestParam("addDp", ccsGet, NULL), $this);
    $this->addDp->Page = "";
    $this->panel->AddComponent("addDp", $this->addDp);
  }
//End Class_Initialize Event

//Initialize Method @117-90E704C5
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
  }
//End Initialize Method

//Show Method @117-29B79EC8
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
      $this->ControlsVisible["calles_calle_nombre"] = $this->calles_calle_nombre->Visible;
      $this->ControlsVisible["barrios_barrio_nombre"] = $this->barrios_barrio_nombre->Visible;
      $this->ControlsVisible["localidades_localidad_nombre"] = $this->localidades_localidad_nombre->Visible;
      $this->ControlsVisible["direccion_manzana"] = $this->direccion_manzana->Visible;
      $this->ControlsVisible["direccion_casa"] = $this->direccion_casa->Visible;
      $this->ControlsVisible["editP"] = $this->editP->Visible;
      $this->ControlsVisible["departamentos_departamento_nombre"] = $this->departamentos_departamento_nombre->Visible;
      $this->ControlsVisible["provincias_provincia_nombre"] = $this->provincias_provincia_nombre->Visible;
      $this->ControlsVisible["direccion_numeracion"] = $this->direccion_numeracion->Visible;
      $this->ControlsVisible["direccion_piso"] = $this->direccion_piso->Visible;
      $this->ControlsVisible["direccion_depto"] = $this->direccion_depto->Visible;
      while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
        $this->RowNumber++;
        if ($this->HasRecord) {
          $this->DataSource->next_record();
          $this->DataSource->SetValues();
        }
        $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
        $this->calles_calle_nombre->SetValue($this->DataSource->calles_calle_nombre->GetValue());
        $this->barrios_barrio_nombre->SetValue($this->DataSource->barrios_barrio_nombre->GetValue());
        $this->localidades_localidad_nombre->SetValue($this->DataSource->localidades_localidad_nombre->GetValue());
        $this->direccion_manzana->SetValue($this->DataSource->direccion_manzana->GetValue());
        $this->direccion_casa->SetValue($this->DataSource->direccion_casa->GetValue());
        $this->editP->Parameters = CCGetQueryString("QueryString", array("add", "ccsForm"));
        $this->editP->Parameters = CCAddParam($this->editP->Parameters, "direccion_id", $this->DataSource->f("direccion_id"));
        $this->editP->Parameters = CCAddParam($this->editP->Parameters, "parcela_id", $this->DataSource->f("parcela_id"));
        $this->editP->Parameters = CCAddParam($this->editP->Parameters, "tipo", P);
        $this->departamentos_departamento_nombre->SetValue($this->DataSource->departamentos_departamento_nombre->GetValue());
        $this->provincias_provincia_nombre->SetValue($this->DataSource->provincias_provincia_nombre->GetValue());
        $this->direccion_numeracion->SetValue($this->DataSource->direccion_numeracion->GetValue());
        $this->direccion_piso->SetValue($this->DataSource->direccion_piso->GetValue());
        $this->direccion_depto->SetValue($this->DataSource->direccion_depto->GetValue());
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->calles_calle_nombre->Show();
        $this->barrios_barrio_nombre->Show();
        $this->localidades_localidad_nombre->Show();
        $this->direccion_manzana->Show();
        $this->direccion_casa->Show();
        $this->editP->Show();
        $this->departamentos_departamento_nombre->Show();
        $this->provincias_provincia_nombre->Show();
        $this->direccion_numeracion->Show();
        $this->direccion_piso->Show();
        $this->direccion_depto->Show();
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
    $this->addDp->Parameters = CCGetQueryString("QueryString", array("direccion_id", "ccsForm"));
    $this->addDp->Parameters = CCAddParam($this->addDp->Parameters, "tipo", P);
    $this->addDp->Parameters = CCAddParam($this->addDp->Parameters, "add", 1);
    $this->panel->Show();
    $this->addDp->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

//GetErrors Method @117-59F3BFF1
  function GetErrors()
  {
    $errors = "";
    $errors = ComposeStrings($errors, $this->calles_calle_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->barrios_barrio_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->localidades_localidad_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_manzana->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_casa->Errors->ToString());
    $errors = ComposeStrings($errors, $this->editP->Errors->ToString());
    $errors = ComposeStrings($errors, $this->departamentos_departamento_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->provincias_provincia_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_numeracion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_piso->Errors->ToString());
    $errors = ComposeStrings($errors, $this->direccion_depto->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
//End GetErrors Method

} //End d_postal Class @117-FCB6E20C

class clsd_postalDataSource extends clsDBtdf_nuevo {  //d_postalDataSource Class @117-255A6A38

//DataSource Variables @117-0D1615F5
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $CountSQL;
  public $wp;


  // Datasource fields
  public $calles_calle_nombre;
  public $barrios_barrio_nombre;
  public $localidades_localidad_nombre;
  public $direccion_manzana;
  public $direccion_casa;
  public $departamentos_departamento_nombre;
  public $provincias_provincia_nombre;
  public $direccion_numeracion;
  public $direccion_piso;
  public $direccion_depto;
//End DataSource Variables

//DataSourceClass_Initialize Event @117-8C846640
  function clsd_postalDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Grid d_postal";
    $this->Initialize();
    $this->calles_calle_nombre = new clsField("calles_calle_nombre", ccsText, "");
    
    $this->barrios_barrio_nombre = new clsField("barrios_barrio_nombre", ccsText, "");
    
    $this->localidades_localidad_nombre = new clsField("localidades_localidad_nombre", ccsText, "");
    
    $this->direccion_manzana = new clsField("direccion_manzana", ccsText, "");
    
    $this->direccion_casa = new clsField("direccion_casa", ccsText, "");
    
    $this->departamentos_departamento_nombre = new clsField("departamentos_departamento_nombre", ccsText, "");
    
    $this->provincias_provincia_nombre = new clsField("provincias_provincia_nombre", ccsText, "");
    
    $this->direccion_numeracion = new clsField("direccion_numeracion", ccsInteger, "");
    
    $this->direccion_piso = new clsField("direccion_piso", ccsText, "");
    
    $this->direccion_depto = new clsField("direccion_depto", ccsText, "");
    

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @117-9E1383D1
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      "");
  }
//End SetOrder Method

//Prepare Method @117-0D07B81E
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

//Open Method @117-05039EF9
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM ((((((direcciones LEFT JOIN barrios ON\n\n" .
    "direcciones.barrio_id = barrios.barrio_id) LEFT JOIN calles ON\n\n" .
    "direcciones.calle_id = calles.calle_id) LEFT JOIN tipos_direcciones ON\n\n" .
    "direcciones.tipo_direccion_id = tipos_direcciones.tipo_direccion_id) LEFT JOIN localidades ON\n\n" .
    "direcciones.localidad_id = localidades.localidad_id) LEFT JOIN provincias ON\n\n" .
    "direcciones.provincia_id = provincias.provincia_id) INNER JOIN parcelas ON\n\n" .
    "parcelas.direccion_id_postal = direcciones.direccion_id) LEFT JOIN departamentos ON\n\n" .
    "departamentos.dpto_id = direcciones.departamento_id";
    $this->SQL = "SELECT calles.calle_nombre AS calles_calle_nombre, barrios.barrio_nombre AS barrios_barrio_nombre, tipo_direccion_descrip, direccion_numeracion,\n\n" .
    "localidades.localidad_nombre AS localidades_localidad_nombre, direcciones.barrio_nombre AS direcciones_barrio_nombre, direccion_manzana,\n\n" .
    "direccion_casa, direccion_piso, direccion_depto, direccion_area, direccion_torre, direccion_lote, provincias.provincia_nombre AS provincias_provincia_nombre,\n\n" .
    "direccion_id, parcela_id, direccion_id_real, direccion_id_postal, dpto_desc \n\n" .
    "FROM ((((((direcciones LEFT JOIN barrios ON\n\n" .
    "direcciones.barrio_id = barrios.barrio_id) LEFT JOIN calles ON\n\n" .
    "direcciones.calle_id = calles.calle_id) LEFT JOIN tipos_direcciones ON\n\n" .
    "direcciones.tipo_direccion_id = tipos_direcciones.tipo_direccion_id) LEFT JOIN localidades ON\n\n" .
    "direcciones.localidad_id = localidades.localidad_id) LEFT JOIN provincias ON\n\n" .
    "direcciones.provincia_id = provincias.provincia_id) INNER JOIN parcelas ON\n\n" .
    "parcelas.direccion_id_postal = direcciones.direccion_id) LEFT JOIN departamentos ON\n\n" .
    "departamentos.dpto_id = direcciones.departamento_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @117-7806D463
  function SetValues()
  {
    $this->calles_calle_nombre->SetDBValue($this->f("calles_calle_nombre"));
    $this->barrios_barrio_nombre->SetDBValue($this->f("barrios_barrio_nombre"));
    $this->localidades_localidad_nombre->SetDBValue($this->f("localidades_localidad_nombre"));
    $this->direccion_manzana->SetDBValue($this->f("direccion_manzana"));
    $this->direccion_casa->SetDBValue($this->f("direccion_casa"));
    $this->departamentos_departamento_nombre->SetDBValue($this->f("dpto_desc"));
    $this->provincias_provincia_nombre->SetDBValue($this->f("provincias_provincia_nombre"));
    $this->direccion_numeracion->SetDBValue(trim($this->f("direccion_numeracion")));
    $this->direccion_piso->SetDBValue($this->f("direccion_piso"));
    $this->direccion_depto->SetDBValue($this->f("direccion_depto"));
  }
//End SetValues Method

} //End d_postalDataSource Class @117-FCB6E20C

class clsRecorddirecciones { //direcciones Class @183-B996BB24

//Variables @183-9E315808

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

//Class_Initialize Event @183-6D5DED73
  function clsRecorddirecciones($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record direcciones/Error";
    $this->DataSource = new clsdireccionesDataSource($this);
    $this->ds = & $this->DataSource;
    $this->InsertAllowed = true;
    $this->UpdateAllowed = true;
    $this->ReadAllowed = true;
    if($this->Visible)
    {
      $this->ComponentName = "direcciones";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->EditMode = ($FormMethod == "Edit");
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
      $this->Button_Update = new clsButton("Button_Update", $Method, $this);
      $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
      $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
      $this->localidad_id = new clsControl(ccsListBox, "localidad_id", "Localidad", ccsInteger, "", CCGetRequestParam("localidad_id", $Method, NULL), $this);
      $this->localidad_id->DSType = dsTable;
      $this->localidad_id->DataSource = new clsDBtdf_nuevo();
      $this->localidad_id->ds = & $this->localidad_id->DataSource;
      $this->localidad_id->DataSource->SQL = "SELECT localidad_id, localidad_nombre \n" .
"FROM localidades {SQL_Where} {SQL_OrderBy}";
      $this->localidad_id->DataSource->Order = "localidad_nombre";
      list($this->localidad_id->BoundColumn, $this->localidad_id->TextColumn, $this->localidad_id->DBFormat) = array("localidad_id", "localidad_nombre", "");
      $this->localidad_id->DataSource->Order = "localidad_nombre";
      $this->barrio_id = new clsControl(ccsHidden, "barrio_id", "Barrio", ccsInteger, "", CCGetRequestParam("barrio_id", $Method, NULL), $this);
      $this->direccion_manzana = new clsControl(ccsTextBox, "direccion_manzana", "Direccion Manzana", ccsText, "", CCGetRequestParam("direccion_manzana", $Method, NULL), $this);
      $this->direccion_piso = new clsControl(ccsTextBox, "direccion_piso", "Direccion Piso", ccsInteger, "", CCGetRequestParam("direccion_piso", $Method, NULL), $this);
      $this->direccion_area = new clsControl(ccsTextBox, "direccion_area", "Direccion Area", ccsText, "", CCGetRequestParam("direccion_area", $Method, NULL), $this);
      $this->direccion_lote = new clsControl(ccsTextBox, "direccion_lote", "Direccion Lote", ccsText, "", CCGetRequestParam("direccion_lote", $Method, NULL), $this);
      $this->direccion_observ = new clsControl(ccsTextBox, "direccion_observ", "Direccion Observ", ccsText, "", CCGetRequestParam("direccion_observ", $Method, NULL), $this);
      $this->direccion_numeracion = new clsControl(ccsTextBox, "direccion_numeracion", "Direccion Numeracion", ccsInteger, "", CCGetRequestParam("direccion_numeracion", $Method, NULL), $this);
      $this->direccion_casa = new clsControl(ccsTextBox, "direccion_casa", "Direccion Casa", ccsText, "", CCGetRequestParam("direccion_casa", $Method, NULL), $this);
      $this->direccion_depto = new clsControl(ccsTextBox, "direccion_depto", "Direccion Depto", ccsText, "", CCGetRequestParam("direccion_depto", $Method, NULL), $this);
      $this->direccion_torre = new clsControl(ccsTextBox, "direccion_torre", "Direccion Torre", ccsText, "", CCGetRequestParam("direccion_torre", $Method, NULL), $this);
      $this->tipo_estado_id = new clsControl(ccsHidden, "tipo_estado_id", "Tipo Estado Id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
      $this->tipo_direccion_id = new clsControl(ccsHidden, "tipo_direccion_id", "Tipo Direccion Id", ccsInteger, "", CCGetRequestParam("tipo_direccion_id", $Method, NULL), $this);
      $this->tipo = new clsControl(ccsLabel, "tipo", "tipo", ccsText, "", CCGetRequestParam("tipo", $Method, NULL), $this);
      $this->accion = new clsControl(ccsLabel, "accion", "accion", ccsText, "", CCGetRequestParam("accion", $Method, NULL), $this);
      $this->extras = new clsPanel("extras", $this);
      $this->provincia_id = new clsControl(ccsListBox, "provincia_id", "Provincia Id", ccsInteger, "", CCGetRequestParam("provincia_id", $Method, NULL), $this);
      $this->provincia_id->DSType = dsTable;
      $this->provincia_id->DataSource = new clsDBtdf_nuevo();
      $this->provincia_id->ds = & $this->provincia_id->DataSource;
      $this->provincia_id->DataSource->SQL = "SELECT provincia_nombre, provincia_id \n" .
"FROM provincias {SQL_Where} {SQL_OrderBy}";
      $this->provincia_id->DataSource->Order = "provincia_nombre";
      list($this->provincia_id->BoundColumn, $this->provincia_id->TextColumn, $this->provincia_id->DBFormat) = array("provincia_id", "provincia_nombre", "");
      $this->provincia_id->DataSource->Order = "provincia_nombre";
      $this->departamento_id = new clsControl(ccsListBox, "departamento_id", "Departamento Id", ccsInteger, "", CCGetRequestParam("departamento_id", $Method, NULL), $this);
      $this->departamento_id->DSType = dsTable;
      $this->departamento_id->DataSource = new clsDBtdf_nuevo();
      $this->departamento_id->ds = & $this->departamento_id->DataSource;
      $this->departamento_id->DataSource->SQL = "SELECT departamento_id, departamento_nombre \n" .
"FROM departamentos {SQL_Where} {SQL_OrderBy}";
      $this->departamento_id->DataSource->Order = "departamento_nombre";
      list($this->departamento_id->BoundColumn, $this->departamento_id->TextColumn, $this->departamento_id->DBFormat) = array("dpto_id", "dpto_desc", "");
      $this->departamento_id->DataSource->Order = "departamento_nombre";
      $this->direccion_cp = new clsControl(ccsTextBox, "direccion_cp", "direccion_cp", ccsText, "", CCGetRequestParam("direccion_cp", $Method, NULL), $this);
      $this->audit_string = new clsControl(ccsHidden, "audit_string", "audit_string", ccsText, "", CCGetRequestParam("audit_string", $Method, NULL), $this);
      $this->direccion_f_proce = new clsControl(ccsHidden, "direccion_f_proce", "direccion_f_proce", ccsText, "", CCGetRequestParam("direccion_f_proce", $Method, NULL), $this);
      $this->tipo_puerta_id = new clsControl(ccsListBox, "tipo_puerta_id", "Tipo Puerta", ccsInteger, "", CCGetRequestParam("tipo_puerta_id", $Method, NULL), $this);
      $this->tipo_puerta_id->DSType = dsTable;
      $this->tipo_puerta_id->DataSource = new clsDBtdf_nuevo();
      $this->tipo_puerta_id->ds = & $this->tipo_puerta_id->DataSource;
      $this->tipo_puerta_id->DataSource->SQL = "SELECT tipo_puerta_id, tipo_puerta_descrip \n" .
"FROM tipos_puertas {SQL_Where} {SQL_OrderBy}";
      $this->tipo_puerta_id->DataSource->Order = "tipo_puerta_descrip";
      list($this->tipo_puerta_id->BoundColumn, $this->tipo_puerta_id->TextColumn, $this->tipo_puerta_id->DBFormat) = array("tipo_puerta_id", "tipo_puerta_descrip", "");
      $this->tipo_puerta_id->DataSource->Order = "tipo_puerta_descrip";
      $this->tipo_puerta_id->Required = true;
      $this->tipo_calle_id = new clsControl(ccsListBox, "tipo_calle_id", "Tipo Calle", ccsInteger, "", CCGetRequestParam("tipo_calle_id", $Method, NULL), $this);
      $this->tipo_calle_id->DSType = dsTable;
      $this->tipo_calle_id->DataSource = new clsDBtdf_nuevo();
      $this->tipo_calle_id->ds = & $this->tipo_calle_id->DataSource;
      $this->tipo_calle_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_calles {SQL_Where} {SQL_OrderBy}";
      list($this->tipo_calle_id->BoundColumn, $this->tipo_calle_id->TextColumn, $this->tipo_calle_id->DBFormat) = array("tipo_calle_id", "tipo_calle_descrip", "");
      $this->tipo_calle_id->Required = true;
      $this->error_fatal = new clsControl(ccsLabel, "error_fatal", "error_fatal", ccsText, "", CCGetRequestParam("error_fatal", $Method, NULL), $this);
      $this->error_fatal->HTML = true;
      $this->calle_id = new clsControl(ccsHidden, "calle_id", "calle_id", ccsText, "", CCGetRequestParam("calle_id", $Method, NULL), $this);
      $this->nombre_calle = new clsControl(ccsTextBox, "nombre_calle", "nombre_calle", ccsText, "", CCGetRequestParam("nombre_calle", $Method, NULL), $this);
      $this->nombre_barrio = new clsControl(ccsTextBox, "nombre_barrio", "nombre_barrio", ccsText, "", CCGetRequestParam("nombre_barrio", $Method, NULL), $this);
      $this->extras->AddComponent("provincia_id", $this->provincia_id);
      $this->extras->AddComponent("departamento_id", $this->departamento_id);
      if(!$this->FormSubmitted) {
        if(!is_array($this->tipo_estado_id->Value) && !strlen($this->tipo_estado_id->Value) && $this->tipo_estado_id->Value !== false)
          $this->tipo_estado_id->SetText(1);
        if(!is_array($this->provincia_id->Value) && !strlen($this->provincia_id->Value) && $this->provincia_id->Value !== false)
          $this->provincia_id->SetText(22);
        if(!is_array($this->departamento_id->Value) && !strlen($this->departamento_id->Value) && $this->departamento_id->Value !== false)
          $this->departamento_id->SetText(4);
      }
    }
  }
//End Class_Initialize Event

//Initialize Method @183-876AF09E
  function Initialize()
  {

    if(!$this->Visible)
      return;

    $this->DataSource->Parameters["urldireccion_id"] = CCGetFromGet("direccion_id", NULL);
  }
//End Initialize Method

//Validate Method @183-419A8AF0
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->localidad_id->Validate() && $Validation);
    $Validation = ($this->barrio_id->Validate() && $Validation);
    $Validation = ($this->direccion_manzana->Validate() && $Validation);
    $Validation = ($this->direccion_piso->Validate() && $Validation);
    $Validation = ($this->direccion_area->Validate() && $Validation);
    $Validation = ($this->direccion_lote->Validate() && $Validation);
    $Validation = ($this->direccion_observ->Validate() && $Validation);
    $Validation = ($this->direccion_numeracion->Validate() && $Validation);
    $Validation = ($this->direccion_casa->Validate() && $Validation);
    $Validation = ($this->direccion_depto->Validate() && $Validation);
    $Validation = ($this->direccion_torre->Validate() && $Validation);
    $Validation = ($this->tipo_estado_id->Validate() && $Validation);
    $Validation = ($this->tipo_direccion_id->Validate() && $Validation);
    $Validation = ($this->provincia_id->Validate() && $Validation);
    $Validation = ($this->departamento_id->Validate() && $Validation);
    $Validation = ($this->direccion_cp->Validate() && $Validation);
    $Validation = ($this->audit_string->Validate() && $Validation);
    $Validation = ($this->direccion_f_proce->Validate() && $Validation);
    $Validation = ($this->tipo_puerta_id->Validate() && $Validation);
    $Validation = ($this->tipo_calle_id->Validate() && $Validation);
    $Validation = ($this->calle_id->Validate() && $Validation);
    $Validation = ($this->nombre_calle->Validate() && $Validation);
    $Validation = ($this->nombre_barrio->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->localidad_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->barrio_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_manzana->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_piso->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_area->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_lote->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_observ->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_numeracion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_casa->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_depto->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_torre->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_direccion_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->provincia_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->departamento_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_cp->Errors->Count() == 0);
    $Validation =  $Validation && ($this->audit_string->Errors->Count() == 0);
    $Validation =  $Validation && ($this->direccion_f_proce->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_puerta_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_calle_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->calle_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->nombre_calle->Errors->Count() == 0);
    $Validation =  $Validation && ($this->nombre_barrio->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @183-7A91B757
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->localidad_id->Errors->Count());
    $errors = ($errors || $this->barrio_id->Errors->Count());
    $errors = ($errors || $this->direccion_manzana->Errors->Count());
    $errors = ($errors || $this->direccion_piso->Errors->Count());
    $errors = ($errors || $this->direccion_area->Errors->Count());
    $errors = ($errors || $this->direccion_lote->Errors->Count());
    $errors = ($errors || $this->direccion_observ->Errors->Count());
    $errors = ($errors || $this->direccion_numeracion->Errors->Count());
    $errors = ($errors || $this->direccion_casa->Errors->Count());
    $errors = ($errors || $this->direccion_depto->Errors->Count());
    $errors = ($errors || $this->direccion_torre->Errors->Count());
    $errors = ($errors || $this->tipo_estado_id->Errors->Count());
    $errors = ($errors || $this->tipo_direccion_id->Errors->Count());
    $errors = ($errors || $this->tipo->Errors->Count());
    $errors = ($errors || $this->accion->Errors->Count());
    $errors = ($errors || $this->provincia_id->Errors->Count());
    $errors = ($errors || $this->departamento_id->Errors->Count());
    $errors = ($errors || $this->direccion_cp->Errors->Count());
    $errors = ($errors || $this->audit_string->Errors->Count());
    $errors = ($errors || $this->direccion_f_proce->Errors->Count());
    $errors = ($errors || $this->tipo_puerta_id->Errors->Count());
    $errors = ($errors || $this->tipo_calle_id->Errors->Count());
    $errors = ($errors || $this->error_fatal->Errors->Count());
    $errors = ($errors || $this->calle_id->Errors->Count());
    $errors = ($errors || $this->nombre_calle->Errors->Count());
    $errors = ($errors || $this->nombre_barrio->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    $errors = ($errors || $this->DataSource->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @183-ED598703
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

//Operation Method @183-F9D75493
  function Operation()
  {
    if(!$this->Visible)
      return;

    global $Redirect;
    global $FileName;

    $this->DataSource->Prepare();
    if(!$this->FormSubmitted) {
      $this->EditMode = $this->DataSource->AllParametersSet;
      return;
    }

    if($this->FormSubmitted) {
      $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
      if($this->Button_Insert->Pressed) {
        $this->PressedButton = "Button_Insert";
      } else if($this->Button_Update->Pressed) {
        $this->PressedButton = "Button_Update";
      } else if($this->Button_Delete->Pressed) {
        $this->PressedButton = "Button_Delete";
      } else if($this->Button_Cancel->Pressed) {
        $this->PressedButton = "Button_Cancel";
      }
    }
    $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if($this->PressedButton == "Button_Delete") {
      if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
        $Redirect = "";
      }
    } else if($this->PressedButton == "Button_Cancel") {
      $Redirect = "gridDirParcela.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "direccion_id", "tipo", "add"));
      if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_Insert") {
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "direccion_id", "tipo", "add"));
        if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
          $Redirect = "";
        }
      } else if($this->PressedButton == "Button_Update") {
        if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
          $Redirect = "";
        }
      }
    } else {
      $Redirect = "";
    }
    if ($Redirect)
      $this->DataSource->close();
  }
//End Operation Method

//InsertRow Method @183-90AC3073
  function InsertRow()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
    if(!$this->InsertAllowed) return false;
    $this->DataSource->localidad_id->SetValue($this->localidad_id->GetValue(true));
    $this->DataSource->barrio_id->SetValue($this->barrio_id->GetValue(true));
    $this->DataSource->direccion_manzana->SetValue($this->direccion_manzana->GetValue(true));
    $this->DataSource->direccion_piso->SetValue($this->direccion_piso->GetValue(true));
    $this->DataSource->direccion_area->SetValue($this->direccion_area->GetValue(true));
    $this->DataSource->direccion_lote->SetValue($this->direccion_lote->GetValue(true));
    $this->DataSource->direccion_observ->SetValue($this->direccion_observ->GetValue(true));
    $this->DataSource->direccion_numeracion->SetValue($this->direccion_numeracion->GetValue(true));
    $this->DataSource->direccion_casa->SetValue($this->direccion_casa->GetValue(true));
    $this->DataSource->direccion_depto->SetValue($this->direccion_depto->GetValue(true));
    $this->DataSource->direccion_torre->SetValue($this->direccion_torre->GetValue(true));
    $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
    $this->DataSource->tipo_direccion_id->SetValue($this->tipo_direccion_id->GetValue(true));
    $this->DataSource->tipo->SetValue($this->tipo->GetValue(true));
    $this->DataSource->accion->SetValue($this->accion->GetValue(true));
    $this->DataSource->provincia_id->SetValue($this->provincia_id->GetValue(true));
    $this->DataSource->departamento_id->SetValue($this->departamento_id->GetValue(true));
    $this->DataSource->direccion_cp->SetValue($this->direccion_cp->GetValue(true));
    $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
    $this->DataSource->direccion_f_proce->SetValue($this->direccion_f_proce->GetValue(true));
    $this->DataSource->tipo_puerta_id->SetValue($this->tipo_puerta_id->GetValue(true));
    $this->DataSource->tipo_calle_id->SetValue($this->tipo_calle_id->GetValue(true));
    $this->DataSource->error_fatal->SetValue($this->error_fatal->GetValue(true));
    $this->DataSource->calle_id->SetValue($this->calle_id->GetValue(true));
    $this->DataSource->nombre_calle->SetValue($this->nombre_calle->GetValue(true));
    $this->DataSource->nombre_barrio->SetValue($this->nombre_barrio->GetValue(true));
    $this->DataSource->Insert();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
    return (!$this->CheckErrors());
  }
//End InsertRow Method

//UpdateRow Method @183-A1625848
  function UpdateRow()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
    if(!$this->UpdateAllowed) return false;
    $this->DataSource->localidad_id->SetValue($this->localidad_id->GetValue(true));
    $this->DataSource->barrio_id->SetValue($this->barrio_id->GetValue(true));
    $this->DataSource->direccion_manzana->SetValue($this->direccion_manzana->GetValue(true));
    $this->DataSource->direccion_piso->SetValue($this->direccion_piso->GetValue(true));
    $this->DataSource->direccion_area->SetValue($this->direccion_area->GetValue(true));
    $this->DataSource->direccion_lote->SetValue($this->direccion_lote->GetValue(true));
    $this->DataSource->direccion_observ->SetValue($this->direccion_observ->GetValue(true));
    $this->DataSource->direccion_numeracion->SetValue($this->direccion_numeracion->GetValue(true));
    $this->DataSource->direccion_casa->SetValue($this->direccion_casa->GetValue(true));
    $this->DataSource->direccion_depto->SetValue($this->direccion_depto->GetValue(true));
    $this->DataSource->direccion_torre->SetValue($this->direccion_torre->GetValue(true));
    $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
    $this->DataSource->tipo_direccion_id->SetValue($this->tipo_direccion_id->GetValue(true));
    $this->DataSource->tipo->SetValue($this->tipo->GetValue(true));
    $this->DataSource->accion->SetValue($this->accion->GetValue(true));
    $this->DataSource->provincia_id->SetValue($this->provincia_id->GetValue(true));
    $this->DataSource->departamento_id->SetValue($this->departamento_id->GetValue(true));
    $this->DataSource->direccion_cp->SetValue($this->direccion_cp->GetValue(true));
    $this->DataSource->audit_string->SetValue($this->audit_string->GetValue(true));
    $this->DataSource->direccion_f_proce->SetValue($this->direccion_f_proce->GetValue(true));
    $this->DataSource->tipo_puerta_id->SetValue($this->tipo_puerta_id->GetValue(true));
    $this->DataSource->tipo_calle_id->SetValue($this->tipo_calle_id->GetValue(true));
    $this->DataSource->error_fatal->SetValue($this->error_fatal->GetValue(true));
    $this->DataSource->calle_id->SetValue($this->calle_id->GetValue(true));
    $this->DataSource->nombre_calle->SetValue($this->nombre_calle->GetValue(true));
    $this->DataSource->nombre_barrio->SetValue($this->nombre_barrio->GetValue(true));
    $this->DataSource->Update();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
    return (!$this->CheckErrors());
  }
//End UpdateRow Method

//Show Method @183-D4791202
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

    $this->localidad_id->Prepare();
    $this->provincia_id->Prepare();
    $this->departamento_id->Prepare();
    $this->tipo_puerta_id->Prepare();
    $this->tipo_calle_id->Prepare();

    $RecordBlock = "Record " . $this->ComponentName;
    $ParentPath = $Tpl->block_path;
    $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
    $this->EditMode = $this->EditMode && $this->ReadAllowed;
    if($this->EditMode) {
      if($this->DataSource->Errors->Count()){
        $this->Errors->AddErrors($this->DataSource->Errors);
        $this->DataSource->Errors->clear();
      }
      $this->DataSource->Open();
      if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
        $this->DataSource->SetValues();
        if(!$this->FormSubmitted){
          $this->localidad_id->SetValue($this->DataSource->localidad_id->GetValue());
          $this->barrio_id->SetValue($this->DataSource->barrio_id->GetValue());
          $this->direccion_manzana->SetValue($this->DataSource->direccion_manzana->GetValue());
          $this->direccion_piso->SetValue($this->DataSource->direccion_piso->GetValue());
          $this->direccion_area->SetValue($this->DataSource->direccion_area->GetValue());
          $this->direccion_lote->SetValue($this->DataSource->direccion_lote->GetValue());
          $this->direccion_observ->SetValue($this->DataSource->direccion_observ->GetValue());
          $this->direccion_numeracion->SetValue($this->DataSource->direccion_numeracion->GetValue());
          $this->direccion_casa->SetValue($this->DataSource->direccion_casa->GetValue());
          $this->direccion_depto->SetValue($this->DataSource->direccion_depto->GetValue());
          $this->direccion_torre->SetValue($this->DataSource->direccion_torre->GetValue());
          $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
          $this->tipo_direccion_id->SetValue($this->DataSource->tipo_direccion_id->GetValue());
          $this->provincia_id->SetValue($this->DataSource->provincia_id->GetValue());
          $this->departamento_id->SetValue($this->DataSource->departamento_id->GetValue());
          $this->direccion_cp->SetValue($this->DataSource->direccion_cp->GetValue());
          $this->audit_string->SetValue($this->DataSource->audit_string->GetValue());
          $this->direccion_f_proce->SetValue($this->DataSource->direccion_f_proce->GetValue());
          $this->tipo_puerta_id->SetValue($this->DataSource->tipo_puerta_id->GetValue());
          $this->tipo_calle_id->SetValue($this->DataSource->tipo_calle_id->GetValue());
          $this->calle_id->SetValue($this->DataSource->calle_id->GetValue());
        }
      } else {
        $this->EditMode = false;
      }
    }
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->localidad_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->barrio_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_manzana->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_piso->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_area->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_lote->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_observ->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_numeracion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_casa->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_depto->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_torre->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_direccion_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo->Errors->ToString());
      $Error = ComposeStrings($Error, $this->accion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->provincia_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->departamento_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_cp->Errors->ToString());
      $Error = ComposeStrings($Error, $this->audit_string->Errors->ToString());
      $Error = ComposeStrings($Error, $this->direccion_f_proce->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_puerta_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_calle_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->error_fatal->Errors->ToString());
      $Error = ComposeStrings($Error, $this->calle_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->nombre_calle->Errors->ToString());
      $Error = ComposeStrings($Error, $this->nombre_barrio->Errors->ToString());
      $Error = ComposeStrings($Error, $this->Errors->ToString());
      $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
      $Tpl->SetVar("Error", $Error);
      $Tpl->Parse("Error", false);
    }
    $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
    $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
    $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
    $Tpl->SetVar("HTMLFormName", $this->ComponentName);
    $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
    $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
    $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
    $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    $this->Attributes->Show();
    if(!$this->Visible) {
      $Tpl->block_path = $ParentPath;
      return;
    }

    $this->Button_Insert->Show();
    $this->Button_Update->Show();
    $this->Button_Delete->Show();
    $this->Button_Cancel->Show();
    $this->localidad_id->Show();
    $this->barrio_id->Show();
    $this->direccion_manzana->Show();
    $this->direccion_piso->Show();
    $this->direccion_area->Show();
    $this->direccion_lote->Show();
    $this->direccion_observ->Show();
    $this->direccion_numeracion->Show();
    $this->direccion_casa->Show();
    $this->direccion_depto->Show();
    $this->direccion_torre->Show();
    $this->tipo_estado_id->Show();
    $this->tipo_direccion_id->Show();
    $this->tipo->Show();
    $this->accion->Show();
    $this->extras->Show();
    $this->direccion_cp->Show();
    $this->audit_string->Show();
    $this->direccion_f_proce->Show();
    $this->tipo_puerta_id->Show();
    $this->tipo_calle_id->Show();
    $this->error_fatal->Show();
    $this->calle_id->Show();
    $this->nombre_calle->Show();
    $this->nombre_barrio->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

} //End direcciones Class @183-FCB6E20C

class clsdireccionesDataSource extends clsDBtdf_nuevo {  //direccionesDataSource Class @183-53D75AFA

//DataSource Variables @183-5805C359
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $InsertParameters;
  public $UpdateParameters;
  public $wp;
  public $AllParametersSet;

  public $InsertFields = array();
  public $UpdateFields = array();

  // Datasource fields
  public $localidad_id;
  public $barrio_id;
  public $direccion_manzana;
  public $direccion_piso;
  public $direccion_area;
  public $direccion_lote;
  public $direccion_observ;
  public $direccion_numeracion;
  public $direccion_casa;
  public $direccion_depto;
  public $direccion_torre;
  public $tipo_estado_id;
  public $tipo_direccion_id;
  public $tipo;
  public $accion;
  public $provincia_id;
  public $departamento_id;
  public $direccion_cp;
  public $audit_string;
  public $direccion_f_proce;
  public $tipo_puerta_id;
  public $tipo_calle_id;
  public $error_fatal;
  public $calle_id;
  public $nombre_calle;
  public $nombre_barrio;
//End DataSource Variables

//DataSourceClass_Initialize Event @183-5D1C910C
  function clsdireccionesDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Record direcciones/Error";
    $this->Initialize();
    $this->localidad_id = new clsField("localidad_id", ccsInteger, "");
    
    $this->barrio_id = new clsField("barrio_id", ccsInteger, "");
    
    $this->direccion_manzana = new clsField("direccion_manzana", ccsText, "");
    
    $this->direccion_piso = new clsField("direccion_piso", ccsInteger, "");
    
    $this->direccion_area = new clsField("direccion_area", ccsText, "");
    
    $this->direccion_lote = new clsField("direccion_lote", ccsText, "");
    
    $this->direccion_observ = new clsField("direccion_observ", ccsText, "");
    
    $this->direccion_numeracion = new clsField("direccion_numeracion", ccsInteger, "");
    
    $this->direccion_casa = new clsField("direccion_casa", ccsText, "");
    
    $this->direccion_depto = new clsField("direccion_depto", ccsText, "");
    
    $this->direccion_torre = new clsField("direccion_torre", ccsText, "");
    
    $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
    
    $this->tipo_direccion_id = new clsField("tipo_direccion_id", ccsInteger, "");
    
    $this->tipo = new clsField("tipo", ccsText, "");
    
    $this->accion = new clsField("accion", ccsText, "");
    
    $this->provincia_id = new clsField("provincia_id", ccsInteger, "");
    
    $this->departamento_id = new clsField("departamento_id", ccsInteger, "");
    
    $this->direccion_cp = new clsField("direccion_cp", ccsText, "");
    
    $this->audit_string = new clsField("audit_string", ccsText, "");
    
    $this->direccion_f_proce = new clsField("direccion_f_proce", ccsText, "");
    
    $this->tipo_puerta_id = new clsField("tipo_puerta_id", ccsInteger, "");
    
    $this->tipo_calle_id = new clsField("tipo_calle_id", ccsInteger, "");
    
    $this->error_fatal = new clsField("error_fatal", ccsText, "");
    
    $this->calle_id = new clsField("calle_id", ccsText, "");
    
    $this->nombre_calle = new clsField("nombre_calle", ccsText, "");
    
    $this->nombre_barrio = new clsField("nombre_barrio", ccsText, "");
    

    $this->InsertFields["localidad_id"] = array("Name" => "localidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["barrio_id"] = array("Name" => "barrio_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_manzana"] = array("Name" => "direccion_manzana", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_piso"] = array("Name" => "direccion_piso", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_area"] = array("Name" => "direccion_area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_lote"] = array("Name" => "direccion_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_observ"] = array("Name" => "direccion_observ", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_numeracion"] = array("Name" => "direccion_numeracion", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_casa"] = array("Name" => "direccion_casa", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_depto"] = array("Name" => "direccion_depto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_torre"] = array("Name" => "direccion_torre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["tipo_direccion_id"] = array("Name" => "tipo_direccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["provincia_id"] = array("Name" => "provincia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["departamento_id"] = array("Name" => "departamento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_cp"] = array("Name" => "direccion_cp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["direccion_f_proce"] = array("Name" => "direccion_f_proce", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["tipo_puerta_id"] = array("Name" => "tipo_puerta_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["tipo_calle_id"] = array("Name" => "tipo_calle_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["calle_id"] = array("Name" => "calle_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["localidad_id"] = array("Name" => "localidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["barrio_id"] = array("Name" => "barrio_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_manzana"] = array("Name" => "direccion_manzana", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_piso"] = array("Name" => "direccion_piso", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_area"] = array("Name" => "direccion_area", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_lote"] = array("Name" => "direccion_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_observ"] = array("Name" => "direccion_observ", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_numeracion"] = array("Name" => "direccion_numeracion", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_casa"] = array("Name" => "direccion_casa", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_depto"] = array("Name" => "direccion_depto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_torre"] = array("Name" => "direccion_torre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_direccion_id"] = array("Name" => "tipo_direccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["provincia_id"] = array("Name" => "provincia_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["departamento_id"] = array("Name" => "departamento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_cp"] = array("Name" => "direccion_cp", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["audit_string"] = array("Name" => "audit_string", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["direccion_f_proce"] = array("Name" => "direccion_f_proce", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_puerta_id"] = array("Name" => "tipo_puerta_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_calle_id"] = array("Name" => "tipo_calle_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["calle_id"] = array("Name" => "calle_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
  }
//End DataSourceClass_Initialize Event

//Prepare Method @183-E90898C8
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urldireccion_id", ccsInteger, "", "", $this->Parameters["urldireccion_id"], "", false);
    $this->AllParametersSet = $this->wp->AllParamsSet();
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "direccion_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->Where = 
       $this->wp->Criterion[1];
  }
//End Prepare Method

//Open Method @183-89FDF0EC
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->SQL = "SELECT * \n\n" .
    "FROM direcciones {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    $this->PageSize = 1;
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @183-598817AE
  function SetValues()
  {
    $this->localidad_id->SetDBValue(trim($this->f("localidad_id")));
    $this->barrio_id->SetDBValue(trim($this->f("barrio_id")));
    $this->direccion_manzana->SetDBValue($this->f("direccion_manzana"));
    $this->direccion_piso->SetDBValue(trim($this->f("direccion_piso")));
    $this->direccion_area->SetDBValue($this->f("direccion_area"));
    $this->direccion_lote->SetDBValue($this->f("direccion_lote"));
    $this->direccion_observ->SetDBValue($this->f("direccion_observ"));
    $this->direccion_numeracion->SetDBValue(trim($this->f("direccion_numeracion")));
    $this->direccion_casa->SetDBValue($this->f("direccion_casa"));
    $this->direccion_depto->SetDBValue($this->f("direccion_depto"));
    $this->direccion_torre->SetDBValue($this->f("direccion_torre"));
    $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    $this->tipo_direccion_id->SetDBValue(trim($this->f("tipo_direccion_id")));
    $this->provincia_id->SetDBValue(trim($this->f("provincia_id")));
    $this->departamento_id->SetDBValue(trim($this->f("departamento_id")));
    $this->direccion_cp->SetDBValue($this->f("direccion_cp"));
    $this->audit_string->SetDBValue($this->f("audit_string"));
    $this->direccion_f_proce->SetDBValue($this->f("direccion_f_proce"));
    $this->tipo_puerta_id->SetDBValue(trim($this->f("tipo_puerta_id")));
    $this->tipo_calle_id->SetDBValue(trim($this->f("tipo_calle_id")));
    $this->calle_id->SetDBValue($this->f("calle_id"));
  }
//End SetValues Method

//Insert Method @183-80A8B53E
  function Insert()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
    $this->InsertFields["localidad_id"]["Value"] = $this->localidad_id->GetDBValue(true);
    $this->InsertFields["barrio_id"]["Value"] = $this->barrio_id->GetDBValue(true);
    $this->InsertFields["direccion_manzana"]["Value"] = $this->direccion_manzana->GetDBValue(true);
    $this->InsertFields["direccion_piso"]["Value"] = $this->direccion_piso->GetDBValue(true);
    $this->InsertFields["direccion_area"]["Value"] = $this->direccion_area->GetDBValue(true);
    $this->InsertFields["direccion_lote"]["Value"] = $this->direccion_lote->GetDBValue(true);
    $this->InsertFields["direccion_observ"]["Value"] = $this->direccion_observ->GetDBValue(true);
    $this->InsertFields["direccion_numeracion"]["Value"] = $this->direccion_numeracion->GetDBValue(true);
    $this->InsertFields["direccion_casa"]["Value"] = $this->direccion_casa->GetDBValue(true);
    $this->InsertFields["direccion_depto"]["Value"] = $this->direccion_depto->GetDBValue(true);
    $this->InsertFields["direccion_torre"]["Value"] = $this->direccion_torre->GetDBValue(true);
    $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
    $this->InsertFields["tipo_direccion_id"]["Value"] = $this->tipo_direccion_id->GetDBValue(true);
    $this->InsertFields["provincia_id"]["Value"] = $this->provincia_id->GetDBValue(true);
    $this->InsertFields["departamento_id"]["Value"] = $this->departamento_id->GetDBValue(true);
    $this->InsertFields["direccion_cp"]["Value"] = $this->direccion_cp->GetDBValue(true);
    $this->InsertFields["audit_string"]["Value"] = $this->audit_string->GetDBValue(true);
    $this->InsertFields["direccion_f_proce"]["Value"] = $this->direccion_f_proce->GetDBValue(true);
    $this->InsertFields["tipo_puerta_id"]["Value"] = $this->tipo_puerta_id->GetDBValue(true);
    $this->InsertFields["tipo_calle_id"]["Value"] = $this->tipo_calle_id->GetDBValue(true);
    $this->InsertFields["calle_id"]["Value"] = $this->calle_id->GetDBValue(true);
    $this->SQL = CCBuildInsert("direcciones", $this->InsertFields, $this);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
    if($this->Errors->Count() == 0 && $this->CmdExecution) {
      $this->query($this->SQL);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
    }
  }
//End Insert Method

//Update Method @183-8C99335A
  function Update()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
    $this->UpdateFields["localidad_id"]["Value"] = $this->localidad_id->GetDBValue(true);
    $this->UpdateFields["barrio_id"]["Value"] = $this->barrio_id->GetDBValue(true);
    $this->UpdateFields["direccion_manzana"]["Value"] = $this->direccion_manzana->GetDBValue(true);
    $this->UpdateFields["direccion_piso"]["Value"] = $this->direccion_piso->GetDBValue(true);
    $this->UpdateFields["direccion_area"]["Value"] = $this->direccion_area->GetDBValue(true);
    $this->UpdateFields["direccion_lote"]["Value"] = $this->direccion_lote->GetDBValue(true);
    $this->UpdateFields["direccion_observ"]["Value"] = $this->direccion_observ->GetDBValue(true);
    $this->UpdateFields["direccion_numeracion"]["Value"] = $this->direccion_numeracion->GetDBValue(true);
    $this->UpdateFields["direccion_casa"]["Value"] = $this->direccion_casa->GetDBValue(true);
    $this->UpdateFields["direccion_depto"]["Value"] = $this->direccion_depto->GetDBValue(true);
    $this->UpdateFields["direccion_torre"]["Value"] = $this->direccion_torre->GetDBValue(true);
    $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
    $this->UpdateFields["tipo_direccion_id"]["Value"] = $this->tipo_direccion_id->GetDBValue(true);
    $this->UpdateFields["provincia_id"]["Value"] = $this->provincia_id->GetDBValue(true);
    $this->UpdateFields["departamento_id"]["Value"] = $this->departamento_id->GetDBValue(true);
    $this->UpdateFields["direccion_cp"]["Value"] = $this->direccion_cp->GetDBValue(true);
    $this->UpdateFields["audit_string"]["Value"] = $this->audit_string->GetDBValue(true);
    $this->UpdateFields["direccion_f_proce"]["Value"] = $this->direccion_f_proce->GetDBValue(true);
    $this->UpdateFields["tipo_puerta_id"]["Value"] = $this->tipo_puerta_id->GetDBValue(true);
    $this->UpdateFields["tipo_calle_id"]["Value"] = $this->tipo_calle_id->GetDBValue(true);
    $this->UpdateFields["calle_id"]["Value"] = $this->calle_id->GetDBValue(true);
    $this->SQL = CCBuildUpdate("direcciones", $this->UpdateFields, $this);
    $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
    if (!strlen($this->Where) && $this->Errors->Count() == 0) 
      $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
    if($this->Errors->Count() == 0 && $this->CmdExecution) {
      $this->query($this->SQL);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
    }
  }
//End Update Method

} //End direccionesDataSource Class @183-FCB6E20C

//Include Page implementation @283-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @284-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @285-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @269-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @5-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

//Initialize Page @1-1D84880C
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
$TemplateFileName = "gridDirParcela.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-5B697CE9
include_once("./gridDirParcela_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-AE3D27B8
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$d_real = new clsGridd_real("", $MainPage);
$d_postal = new clsGridd_postal("", $MainPage);
$direcciones = new clsRecorddirecciones("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$MainPage->d_real = & $d_real;
$MainPage->d_postal = & $d_postal;
$MainPage->direcciones = & $direcciones;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->footerParcela = & $footerParcela;
$MainPage->headerParcela = & $headerParcela;
$d_real->Initialize();
$d_postal->Initialize();
$direcciones->Initialize();

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

//Execute Components @1-9882E274
$direcciones->Operation();
$tdf_footer->Operations();
$tdf_header->Operations();
$tdf_menu->Operations();
$footerParcela->Operations();
$headerParcela->Operations();
//End Execute Components

//Go to destination page @1-71D37050
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBtdf_nuevo->close();
  header("Location: " . $Redirect);
  unset($d_real);
  unset($d_postal);
  unset($direcciones);
  $tdf_footer->Class_Terminate();
  unset($tdf_footer);
  $tdf_header->Class_Terminate();
  unset($tdf_header);
  $tdf_menu->Class_Terminate();
  unset($tdf_menu);
  $footerParcela->Class_Terminate();
  unset($footerParcela);
  $headerParcela->Class_Terminate();
  unset($headerParcela);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-53ABBB85
$d_real->Show();
$d_postal->Show();
$direcciones->Show();
$tdf_footer->Show();
$tdf_header->Show();
$tdf_menu->Show();
$footerParcela->Show();
$headerParcela->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$GNJJO5O1K1H0M = "<center><font face=\"Arial\"><small>&#71;e&#110;e&#114;ated <!-- CCS -->&#119;&#105;&#116;h <!-- CCS -->&#67;&#111;de&#67;ha&#114;&#103;&#101; <!-- SCC -->S&#116;&#117;dio.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", $GNJJO5O1K1H0M . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", $GNJJO5O1K1H0M . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= $GNJJO5O1K1H0M;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-75C166AF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($d_real);
unset($d_postal);
unset($direcciones);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$footerParcela->Class_Terminate();
unset($footerParcela);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($Tpl);
//End Unload Page


?>
