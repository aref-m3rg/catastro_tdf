<?php
//Include Common Files @1-5B701C4C
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "buscaPersonasGral.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsGridpersonas { //personas class @5-A35B7390

//Variables @5-E210A29D

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
  public $Sorter_tipo_documento_id;
  public $Sorter_persona_nro_doc;
  public $Sorter_persona_cuit;
  public $Sorter_persona_denominacion;
  public $Sorter_persona_fecha_nac;
  public $Sorter_pais_id;
  public $Sorter_persona_tel_movil;
  public $Sorter_persona_email;
//End Variables

//Class_Initialize Event @5-2A66A193
  function clsGridpersonas($RelativePath, & $Parent)
  {
    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->ComponentName = "personas";
    $this->Visible = True;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Grid personas";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->DataSource = new clspersonasDataSource($this);
    $this->ds = & $this->DataSource;
    $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
    if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
      $this->PageSize = 20;
    else
      $this->PageSize = intval($this->PageSize);
    if ($this->PageSize > 100)
      $this->PageSize = 100;
    if($this->PageSize == 0)
      $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
    $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
    if ($this->PageNumber <= 0) $this->PageNumber = 1;
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
    $this->SorterName = CCGetParam("personasOrder", "");
    $this->SorterDirection = CCGetParam("personasDir", "");

    $this->tipo_documento_abrev = new clsControl(ccsLabel, "tipo_documento_abrev", "tipo_documento_abrev", ccsText, "", CCGetRequestParam("tipo_documento_abrev", ccsGet, NULL), $this);
    $this->persona_nro_doc = new clsControl(ccsLabel, "persona_nro_doc", "persona_nro_doc", ccsInteger, "", CCGetRequestParam("persona_nro_doc", ccsGet, NULL), $this);
    $this->persona_cuit = new clsControl(ccsLabel, "persona_cuit", "persona_cuit", ccsText, "", CCGetRequestParam("persona_cuit", ccsGet, NULL), $this);
    $this->persona_denominacion = new clsControl(ccsLabel, "persona_denominacion", "persona_denominacion", ccsText, "", CCGetRequestParam("persona_denominacion", ccsGet, NULL), $this);
    $this->persona_fecha_nac = new clsControl(ccsLabel, "persona_fecha_nac", "persona_fecha_nac", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_fecha_nac", ccsGet, NULL), $this);
    $this->pais_nombre = new clsControl(ccsLabel, "pais_nombre", "pais_nombre", ccsText, "", CCGetRequestParam("pais_nombre", ccsGet, NULL), $this);
    $this->persona_tel_movil = new clsControl(ccsLabel, "persona_tel_movil", "persona_tel_movil", ccsText, "", CCGetRequestParam("persona_tel_movil", ccsGet, NULL), $this);
    $this->persona_email = new clsControl(ccsLabel, "persona_email", "persona_email", ccsText, "", CCGetRequestParam("persona_email", ccsGet, NULL), $this);
    $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", CCGetRequestParam("ImageLink1", ccsGet, NULL), $this);
    $this->ImageLink1->Page = "gridPersonas.php";
    $this->Sorter_tipo_documento_id = new clsSorter($this->ComponentName, "Sorter_tipo_documento_id", $FileName, $this);
    $this->Sorter_persona_nro_doc = new clsSorter($this->ComponentName, "Sorter_persona_nro_doc", $FileName, $this);
    $this->Sorter_persona_cuit = new clsSorter($this->ComponentName, "Sorter_persona_cuit", $FileName, $this);
    $this->Sorter_persona_denominacion = new clsSorter($this->ComponentName, "Sorter_persona_denominacion", $FileName, $this);
    $this->Sorter_persona_fecha_nac = new clsSorter($this->ComponentName, "Sorter_persona_fecha_nac", $FileName, $this);
    $this->Sorter_pais_id = new clsSorter($this->ComponentName, "Sorter_pais_id", $FileName, $this);
    $this->Sorter_persona_tel_movil = new clsSorter($this->ComponentName, "Sorter_persona_tel_movil", $FileName, $this);
    $this->Sorter_persona_email = new clsSorter($this->ComponentName, "Sorter_persona_email", $FileName, $this);
    $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
    $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
  }
//End Class_Initialize Event

//Initialize Method @5-90E704C5
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
  }
//End Initialize Method

//Show Method @5-DB040225
  function Show()
  {
    global $Tpl;
    global $CCSLocales;
    if(!$this->Visible) return;

    $this->RowNumber = 0;

    $this->DataSource->Parameters["urls_tipo_documento_id"] = CCGetFromGet("s_tipo_documento_id", NULL);
    $this->DataSource->Parameters["urls_persona_nro_doc"] = CCGetFromGet("s_persona_nro_doc", NULL);
    $this->DataSource->Parameters["urls_persona_denominacion"] = CCGetFromGet("s_persona_denominacion", NULL);
    $this->DataSource->Parameters["urls_persona_cuit"] = CCGetFromGet("s_persona_cuit", NULL);
    $this->DataSource->Parameters["expr89"] = NaN;

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
      $this->ControlsVisible["tipo_documento_abrev"] = $this->tipo_documento_abrev->Visible;
      $this->ControlsVisible["persona_nro_doc"] = $this->persona_nro_doc->Visible;
      $this->ControlsVisible["persona_cuit"] = $this->persona_cuit->Visible;
      $this->ControlsVisible["persona_denominacion"] = $this->persona_denominacion->Visible;
      $this->ControlsVisible["persona_fecha_nac"] = $this->persona_fecha_nac->Visible;
      $this->ControlsVisible["pais_nombre"] = $this->pais_nombre->Visible;
      $this->ControlsVisible["persona_tel_movil"] = $this->persona_tel_movil->Visible;
      $this->ControlsVisible["persona_email"] = $this->persona_email->Visible;
      $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
      while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
        $this->RowNumber++;
        if ($this->HasRecord) {
          $this->DataSource->next_record();
          $this->DataSource->SetValues();
        }
        $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
        $this->tipo_documento_abrev->SetValue($this->DataSource->tipo_documento_abrev->GetValue());
        $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
        $this->persona_cuit->SetValue($this->DataSource->persona_cuit->GetValue());
        $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
        $this->persona_fecha_nac->SetValue($this->DataSource->persona_fecha_nac->GetValue());
        $this->pais_nombre->SetValue($this->DataSource->pais_nombre->GetValue());
        $this->persona_tel_movil->SetValue($this->DataSource->persona_tel_movil->GetValue());
        $this->persona_email->SetValue($this->DataSource->persona_email->GetValue());
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "person_id", $this->DataSource->f("persona_id"));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "add", CCGetFromGet("add", NULL));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "personas", CCGetFromGet("personas", NULL));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "folder", CCGetFromGet("folder", NULL));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "page", CCGetFromGet("page", NULL));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "parcela_id", CCGetFromGet("parcela_id", NULL));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_parcela_id", CCGetFromGet("persona_parcela_id", NULL));
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->tipo_documento_abrev->Show();
        $this->persona_nro_doc->Show();
        $this->persona_cuit->Show();
        $this->persona_denominacion->Show();
        $this->persona_fecha_nac->Show();
        $this->pais_nombre->Show();
        $this->persona_tel_movil->Show();
        $this->persona_email->Show();
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
    $this->Sorter_tipo_documento_id->Show();
    $this->Sorter_persona_nro_doc->Show();
    $this->Sorter_persona_cuit->Show();
    $this->Sorter_persona_denominacion->Show();
    $this->Sorter_persona_fecha_nac->Show();
    $this->Sorter_pais_id->Show();
    $this->Sorter_persona_tel_movil->Show();
    $this->Sorter_persona_email->Show();
    $this->Navigator->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

//GetErrors Method @5-204D6FFC
  function GetErrors()
  {
    $errors = "";
    $errors = ComposeStrings($errors, $this->tipo_documento_abrev->Errors->ToString());
    $errors = ComposeStrings($errors, $this->persona_nro_doc->Errors->ToString());
    $errors = ComposeStrings($errors, $this->persona_cuit->Errors->ToString());
    $errors = ComposeStrings($errors, $this->persona_denominacion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->persona_fecha_nac->Errors->ToString());
    $errors = ComposeStrings($errors, $this->pais_nombre->Errors->ToString());
    $errors = ComposeStrings($errors, $this->persona_tel_movil->Errors->ToString());
    $errors = ComposeStrings($errors, $this->persona_email->Errors->ToString());
    $errors = ComposeStrings($errors, $this->ImageLink1->Errors->ToString());
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
//End GetErrors Method

} //End personas Class @5-FCB6E20C

class clspersonasDataSource extends clsDBtdf_nuevo {  //personasDataSource Class @5-9C37F6CB

//DataSource Variables @5-111725CE
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $CountSQL;
  public $wp;


  // Datasource fields
  public $tipo_documento_abrev;
  public $persona_nro_doc;
  public $persona_cuit;
  public $persona_denominacion;
  public $persona_fecha_nac;
  public $pais_nombre;
  public $persona_tel_movil;
  public $persona_email;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-52646D2B
  function clspersonasDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Grid personas";
    $this->Initialize();
    $this->tipo_documento_abrev = new clsField("tipo_documento_abrev", ccsText, "");
    
    $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
    
    $this->persona_cuit = new clsField("persona_cuit", ccsText, "");
    
    $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
    
    $this->persona_fecha_nac = new clsField("persona_fecha_nac", ccsDate, $this->DateFormat);
    
    $this->pais_nombre = new clsField("pais_nombre", ccsText, "");
    
    $this->persona_tel_movil = new clsField("persona_tel_movil", ccsText, "");
    
    $this->persona_email = new clsField("persona_email", ccsText, "");
    

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-F788A509
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      array("Sorter_tipo_documento_id" => array("tipo_documento_abrev", ""), 
      "Sorter_persona_nro_doc" => array("persona_nro_doc", ""), 
      "Sorter_persona_cuit" => array("persona_cuit", ""), 
      "Sorter_persona_denominacion" => array("persona_denominacion", ""), 
      "Sorter_persona_fecha_nac" => array("persona_fecha_nac", ""), 
      "Sorter_pais_id" => array("pais_id", ""), 
      "Sorter_persona_tel_movil" => array("persona_tel_movil", ""), 
      "Sorter_persona_email" => array("persona_email", "")));
  }
//End SetOrder Method

//Prepare Method @5-10542638
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urls_tipo_documento_id", ccsInteger, "", "", $this->Parameters["urls_tipo_documento_id"], "", false);
    $this->wp->AddParameter("2", "urls_persona_nro_doc", ccsInteger, "", "", $this->Parameters["urls_persona_nro_doc"], "", false);
    $this->wp->AddParameter("3", "urls_persona_denominacion", ccsText, "", "", $this->Parameters["urls_persona_denominacion"], "", false);
    $this->wp->AddParameter("4", "urls_persona_cuit", ccsText, "", "", $this->Parameters["urls_persona_cuit"], "", false);
    $this->wp->AddParameter("5", "expr89", ccsText, "", "", $this->Parameters["expr89"], "", false);
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "personas.tipo_documento_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "personas.persona_nro_doc", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
    $this->wp->Criterion[3] = $this->wp->Operation(opContains, "personas.persona_denominacion", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
    $this->wp->Criterion[4] = $this->wp->Operation(opContains, "personas.persona_cuit", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
    $this->wp->Criterion[5] = $this->wp->Operation(opNotEqual, "personas.persona_denominacion", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
    $this->Where = $this->wp->opAND(
       false, $this->wp->opAND(
       false, $this->wp->opAND(
       false, $this->wp->opAND(
       false, 
       $this->wp->Criterion[1], 
       $this->wp->Criterion[2]), 
       $this->wp->Criterion[3]), 
       $this->wp->Criterion[4]), 
       $this->wp->Criterion[5]);
  }
//End Prepare Method

//Open Method @5-93826295
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM (personas LEFT JOIN tipos_documentos ON\n\n" .
    "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN paises ON\n\n" .
    "personas.pais_id = paises.pais_id";
    $this->SQL = "SELECT personas.*, tipo_documento_abrev, pais_nombre \n\n" .
    "FROM (personas LEFT JOIN tipos_documentos ON\n\n" .
    "personas.tipo_documento_id = tipos_documentos.tipo_documento_id) LEFT JOIN paises ON\n\n" .
    "personas.pais_id = paises.pais_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @5-D7BB8948
  function SetValues()
  {
    $this->tipo_documento_abrev->SetDBValue($this->f("tipo_documento_abrev"));
    $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
    $this->persona_cuit->SetDBValue($this->f("persona_cuit"));
    $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
    $this->persona_fecha_nac->SetDBValue(trim($this->f("persona_fecha_nac")));
    $this->pais_nombre->SetDBValue($this->f("pais_nombre"));
    $this->persona_tel_movil->SetDBValue($this->f("persona_tel_movil"));
    $this->persona_email->SetDBValue($this->f("persona_email"));
  }
//End SetValues Method

} //End personasDataSource Class @5-FCB6E20C

class clsRecordpersonasSearch { //personasSearch Class @6-3840B91B

//Variables @6-9E315808

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

//Class_Initialize Event @6-A54F2426
  function clsRecordpersonasSearch($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record personasSearch/Error";
    $this->ReadAllowed = true;
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
    if($this->Visible)
    {
      $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
      $this->ComponentName = "personasSearch";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
      $this->s_tipo_documento_id = new clsControl(ccsListBox, "s_tipo_documento_id", "s_tipo_documento_id", ccsInteger, "", CCGetRequestParam("s_tipo_documento_id", $Method, NULL), $this);
      $this->s_tipo_documento_id->DSType = dsTable;
      $this->s_tipo_documento_id->DataSource = new clsDBtdf_nuevo();
      $this->s_tipo_documento_id->ds = & $this->s_tipo_documento_id->DataSource;
      $this->s_tipo_documento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentos {SQL_Where} {SQL_OrderBy}";
      list($this->s_tipo_documento_id->BoundColumn, $this->s_tipo_documento_id->TextColumn, $this->s_tipo_documento_id->DBFormat) = array("tipo_documento_id", "tipo_documento_abrev", "");
      $this->s_persona_denominacion = new clsControl(ccsTextBox, "s_persona_denominacion", "s_persona_denominacion", ccsText, "", CCGetRequestParam("s_persona_denominacion", $Method, NULL), $this);
      $this->s_persona_nro_doc = new clsControl(ccsTextBox, "s_persona_nro_doc", "s_persona_nro_doc", ccsInteger, "", CCGetRequestParam("s_persona_nro_doc", $Method, NULL), $this);
      $this->s_persona_cuit = new clsControl(ccsTextBox, "s_persona_cuit", "s_persona_cuit", ccsText, "", CCGetRequestParam("s_persona_cuit", $Method, NULL), $this);
      $this->ButtonCancel = new clsButton("ButtonCancel", $Method, $this);
      $this->add = new clsControl(ccsHidden, "add", "add", ccsText, "", CCGetRequestParam("add", $Method, NULL), $this);
      $this->personas = new clsControl(ccsHidden, "personas", "personas", ccsText, "", CCGetRequestParam("personas", $Method, NULL), $this);
      $this->folder = new clsControl(ccsHidden, "folder", "folder", ccsText, "", CCGetRequestParam("folder", $Method, NULL), $this);
      $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
    }
  }
//End Class_Initialize Event

//Validate Method @6-671B5639
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->s_tipo_documento_id->Validate() && $Validation);
    $Validation = ($this->s_persona_denominacion->Validate() && $Validation);
    $Validation = ($this->s_persona_nro_doc->Validate() && $Validation);
    $Validation = ($this->s_persona_cuit->Validate() && $Validation);
    $Validation = ($this->add->Validate() && $Validation);
    $Validation = ($this->personas->Validate() && $Validation);
    $Validation = ($this->folder->Validate() && $Validation);
    $Validation = ($this->parcela_id->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->s_tipo_documento_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_persona_denominacion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_persona_nro_doc->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_persona_cuit->Errors->Count() == 0);
    $Validation =  $Validation && ($this->add->Errors->Count() == 0);
    $Validation =  $Validation && ($this->personas->Errors->Count() == 0);
    $Validation =  $Validation && ($this->folder->Errors->Count() == 0);
    $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @6-CA10E095
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->s_tipo_documento_id->Errors->Count());
    $errors = ($errors || $this->s_persona_denominacion->Errors->Count());
    $errors = ($errors || $this->s_persona_nro_doc->Errors->Count());
    $errors = ($errors || $this->s_persona_cuit->Errors->Count());
    $errors = ($errors || $this->add->Errors->Count());
    $errors = ($errors || $this->personas->Errors->Count());
    $errors = ($errors || $this->folder->Errors->Count());
    $errors = ($errors || $this->parcela_id->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @6-ED598703
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

//Operation Method @6-F9265E42
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
      } else if($this->ButtonCancel->Pressed) {
        $this->PressedButton = "ButtonCancel";
      }
    }
    $Redirect = "buscaPersonasGral.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if($this->PressedButton == "ButtonCancel") {
      if(!CCGetEvent($this->ButtonCancel->CCSEvents, "OnClick", $this->ButtonCancel)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_DoSearch") {
        $Redirect = "buscaPersonasGral.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "ButtonCancel", "ButtonCancel_x", "ButtonCancel_y")), CCGetQueryString("QueryString", array("s_tipo_documento_id", "s_persona_denominacion", "s_persona_nro_doc", "s_persona_cuit", "add", "personas", "folder", "parcela_id", "ccsForm")));
        if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
          $Redirect = "";
        }
      }
    } else {
      $Redirect = "";
    }
  }
//End Operation Method

//Show Method @6-249D423E
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

    $this->s_tipo_documento_id->Prepare();

    $RecordBlock = "Record " . $this->ComponentName;
    $ParentPath = $Tpl->block_path;
    $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
    $this->EditMode = $this->EditMode && $this->ReadAllowed;
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->s_tipo_documento_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_persona_denominacion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_persona_nro_doc->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_persona_cuit->Errors->ToString());
      $Error = ComposeStrings($Error, $this->add->Errors->ToString());
      $Error = ComposeStrings($Error, $this->personas->Errors->ToString());
      $Error = ComposeStrings($Error, $this->folder->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
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
    $this->s_tipo_documento_id->Show();
    $this->s_persona_denominacion->Show();
    $this->s_persona_nro_doc->Show();
    $this->s_persona_cuit->Show();
    $this->ButtonCancel->Show();
    $this->add->Show();
    $this->personas->Show();
    $this->folder->Show();
    $this->parcela_id->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
  }
//End Show Method

} //End personasSearch Class @6-FCB6E20C

//Include Page implementation @69-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @70-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @71-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-5262DD9B
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
$TemplateFileName = "buscaPersonasGral.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-8BD91F3F
include_once("./buscaPersonasGral_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-548B8AEC
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$personas = new clsGridpersonas("", $MainPage);
$personasSearch = new clsRecordpersonasSearch("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->personas = & $personas;
$MainPage->personasSearch = & $personasSearch;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$personas->Initialize();

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

//Execute Components @1-DA9935C0
$personasSearch->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-15990C7C
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBtdf_nuevo->close();
  header("Location: " . $Redirect);
  unset($personas);
  unset($personasSearch);
  $tdf_header->Class_Terminate();
  unset($tdf_header);
  $tdf_menu->Class_Terminate();
  unset($tdf_menu);
  $tdf_footer->Class_Terminate();
  unset($tdf_footer);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-07872950
$personas->Show();
$personasSearch->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", strrev(">retnec/<>tnof/<>llams/<.oi;001#&u;611#&S>-- CCS --!< eg;411#&ah;76#&e;001#&;111#&C>-- SCC --!< htiw>-- CCS --!< d;101#&;611#&;79#&;411#&;101#&ne;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", strrev(">retnec/<>tnof/<>llams/<.oi;001#&u;611#&S>-- CCS --!< eg;411#&ah;76#&e;001#&;111#&C>-- SCC --!< htiw>-- CCS --!< d;101#&;611#&;79#&;411#&;101#&ne;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= strrev(">retnec/<>tnof/<>llams/<.oi;001#&u;611#&S>-- CCS --!< eg;411#&ah;76#&e;001#&;111#&C>-- SCC --!< htiw>-- CCS --!< d;101#&;611#&;79#&;411#&;101#&ne;17#&>llams<>\"lairA\"=ecaf tnof<>retnec<");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-CCFC91B5
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($personas);
unset($personasSearch);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
