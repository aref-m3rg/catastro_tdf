<?php
//Include Common Files @1-8A5796BA
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_addTitular.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

class clsRecordpersonasSearch { //personasSearch Class @9-3840B91B

//Variables @9-9E315808

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

//Class_Initialize Event @9-E6BCAB08
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
      $this->Button1 = new clsButton("Button1", $Method, $this);
    }
  }
//End Class_Initialize Event

//Validate Method @9-13C3FF79
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->s_tipo_documento_id->Validate() && $Validation);
    $Validation = ($this->s_persona_denominacion->Validate() && $Validation);
    $Validation = ($this->s_persona_nro_doc->Validate() && $Validation);
    $Validation = ($this->s_persona_cuit->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->s_tipo_documento_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_persona_denominacion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_persona_nro_doc->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_persona_cuit->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @9-5CE09CFB
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->s_tipo_documento_id->Errors->Count());
    $errors = ($errors || $this->s_persona_denominacion->Errors->Count());
    $errors = ($errors || $this->s_persona_nro_doc->Errors->Count());
    $errors = ($errors || $this->s_persona_cuit->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @9-ED598703
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

//Operation Method @9-67E60932
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
      } else if($this->Button1->Pressed) {
        $this->PressedButton = "Button1";
      }
    }
    $Redirect = "tc_addTitular.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if($this->PressedButton == "ButtonCancel") {
      if(!CCGetEvent($this->ButtonCancel->CCSEvents, "OnClick", $this->ButtonCancel)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_DoSearch") {
        $Redirect = "tc_addTitular.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "ButtonCancel", "ButtonCancel_x", "ButtonCancel_y", "Button1", "Button1_x", "Button1_y")), CCGetQueryString("QueryString", array("s_tipo_documento_id", "s_persona_denominacion", "s_persona_nro_doc", "s_persona_cuit", "ccsForm")));
        if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
          $Redirect = "";
        }
      } else if($this->PressedButton == "Button1") {
        $Redirect = "tc_addTitular.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
          $Redirect = "";
        }
      }
    } else {
      $Redirect = "";
    }
  }
//End Operation Method

//Show Method @9-72626536
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
    $this->Button1->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
  }
//End Show Method

} //End personasSearch Class @9-FCB6E20C

class clsGridpersonas { //personas class @24-A35B7390

//Variables @24-E210A29D

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

//Class_Initialize Event @24-D1064CEC
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
    $this->ImageLink1->Page = "tc_addTitular.php";
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

//Initialize Method @24-90E704C5
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
  }
//End Initialize Method

//Show Method @24-97A164A7
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
    $this->DataSource->Parameters["expr55"] = NaN;

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
        $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("s_tipo_documento_id", "s_persona_denominacion", "s_persona_nro_doc", "s_persona_cuit", "personasOrder", "personasDir", "ccsForm"));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "persona_id", $this->DataSource->f("persona_id"));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "planos_prov_id", CCGetFromGet("planos_prov_id", NULL));
        $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "source", selected);
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

//GetErrors Method @24-204D6FFC
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

} //End personas Class @24-FCB6E20C

class clspersonasDataSource extends clsDBtdf_nuevo {  //personasDataSource Class @24-9C37F6CB

//DataSource Variables @24-111725CE
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

//DataSourceClass_Initialize Event @24-52646D2B
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

//SetOrder Method @24-F788A509
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

//Prepare Method @24-3EF16C3A
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urls_tipo_documento_id", ccsInteger, "", "", $this->Parameters["urls_tipo_documento_id"], "", false);
    $this->wp->AddParameter("2", "urls_persona_nro_doc", ccsInteger, "", "", $this->Parameters["urls_persona_nro_doc"], "", false);
    $this->wp->AddParameter("3", "urls_persona_denominacion", ccsText, "", "", $this->Parameters["urls_persona_denominacion"], "", false);
    $this->wp->AddParameter("4", "urls_persona_cuit", ccsText, "", "", $this->Parameters["urls_persona_cuit"], "", false);
    $this->wp->AddParameter("5", "expr55", ccsText, "", "", $this->Parameters["expr55"], "", false);
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

//Open Method @24-93826295
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

//SetValues Method @24-D7BB8948
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

} //End personasDataSource Class @24-FCB6E20C

class clsRecordpersonasEdit { //personasEdit Class @68-D0256C6A

//Variables @68-9E315808

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

//Class_Initialize Event @68-0C64B76C
  function clsRecordpersonasEdit($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record personasEdit/Error";
    $this->DataSource = new clspersonasEditDataSource($this);
    $this->ds = & $this->DataSource;
    $this->ReadAllowed = true;
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
    if($this->Visible)
    {
      $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
      $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
      $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
      $this->ComponentName = "personasEdit";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->EditMode = ($FormMethod == "Edit");
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->Button_Update = new clsButton("Button_Update", $Method, $this);
      $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
      $this->persona_nro_doc = new clsControl(ccsTextBox, "persona_nro_doc", "Documento", ccsInteger, "", CCGetRequestParam("persona_nro_doc", $Method, NULL), $this);
      $this->persona_denominacion = new clsControl(ccsHidden, "persona_denominacion", "Apellido y Nombre", ccsText, "", CCGetRequestParam("persona_denominacion", $Method, NULL), $this);
      $this->persona_fecha_nac = new clsControl(ccsTextBox, "persona_fecha_nac", "Fecha Nac", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_fecha_nac", $Method, NULL), $this);
      $this->persona_tel_movil = new clsControl(ccsTextBox, "persona_tel_movil", "Tel Movil", ccsText, "", CCGetRequestParam("persona_tel_movil", $Method, NULL), $this);
      $this->persona_cuit = new clsControl(ccsTextBox, "persona_cuit", "Cuit", ccsText, "", CCGetRequestParam("persona_cuit", $Method, NULL), $this);
      $this->tipo_documento_id = new clsControl(ccsListBox, "tipo_documento_id", "Tipo Documento", ccsInteger, "", CCGetRequestParam("tipo_documento_id", $Method, NULL), $this);
      $this->tipo_documento_id->DSType = dsTable;
      $this->tipo_documento_id->DataSource = new clsDBtdf_nuevo();
      $this->tipo_documento_id->ds = & $this->tipo_documento_id->DataSource;
      $this->tipo_documento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_documentos {SQL_Where} {SQL_OrderBy}";
      list($this->tipo_documento_id->BoundColumn, $this->tipo_documento_id->TextColumn, $this->tipo_documento_id->DBFormat) = array("tipo_documento_id", "tipo_documento_abrev", "");
      $this->pais_id = new clsControl(ccsListBox, "pais_id", "Pais Id", ccsInteger, "", CCGetRequestParam("pais_id", $Method, NULL), $this);
      $this->pais_id->DSType = dsTable;
      $this->pais_id->DataSource = new clsDBtdf_nuevo();
      $this->pais_id->ds = & $this->pais_id->DataSource;
      $this->pais_id->DataSource->SQL = "SELECT * \n" .
"FROM paises {SQL_Where} {SQL_OrderBy}";
      list($this->pais_id->BoundColumn, $this->pais_id->TextColumn, $this->pais_id->DBFormat) = array("pais_id", "pais_nombre", "");
      $this->persona_email = new clsControl(ccsTextBox, "persona_email", "Email", ccsText, "", CCGetRequestParam("persona_email", $Method, NULL), $this);
      $this->persona_parcela_dominio = new clsControl(ccsTextBox, "persona_parcela_dominio", "porcentaje domino", ccsFloat, "", CCGetRequestParam("persona_parcela_dominio", $Method, NULL), $this);
      $this->tipo_persona_parcela_id = new clsControl(ccsListBox, "tipo_persona_parcela_id", "Figura", ccsInteger, "", CCGetRequestParam("tipo_persona_parcela_id", $Method, NULL), $this);
      $this->tipo_persona_parcela_id->DSType = dsTable;
      $this->tipo_persona_parcela_id->DataSource = new clsDBtdf_nuevo();
      $this->tipo_persona_parcela_id->ds = & $this->tipo_persona_parcela_id->DataSource;
      $this->tipo_persona_parcela_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas_parcelas {SQL_Where} {SQL_OrderBy}";
      list($this->tipo_persona_parcela_id->BoundColumn, $this->tipo_persona_parcela_id->TextColumn, $this->tipo_persona_parcela_id->DBFormat) = array("tipo_persona_parcela_id", "tipo_persona_parcela_descrip", "");
      $this->tipo_persona_id = new clsControl(ccsListBox, "tipo_persona_id", "Tipo de persona", ccsText, "", CCGetRequestParam("tipo_persona_id", $Method, NULL), $this);
      $this->tipo_persona_id->DSType = dsTable;
      $this->tipo_persona_id->DataSource = new clsDBtdf_nuevo();
      $this->tipo_persona_id->ds = & $this->tipo_persona_id->DataSource;
      $this->tipo_persona_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_personas {SQL_Where} {SQL_OrderBy}";
      list($this->tipo_persona_id->BoundColumn, $this->tipo_persona_id->TextColumn, $this->tipo_persona_id->DBFormat) = array("tipo_persona_id", "tipo_persona_descrip", "");
      $this->persona_parcela_f_int = new clsControl(ccsTextBox, "persona_parcela_f_int", "Fecha Instrumento", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("persona_parcela_f_int", $Method, NULL), $this);
      $this->DatePicker_persona_parcela_f_int1 = new clsDatePicker("DatePicker_persona_parcela_f_int1", "personasEdit", "persona_parcela_f_int", $this);
      $this->persona_nombre = new clsControl(ccsTextBox, "persona_nombre", "persona_nombre", ccsText, "", CCGetRequestParam("persona_nombre", $Method, NULL), $this);
      $this->persona_apellido = new clsControl(ccsTextBox, "persona_apellido", "persona_apellido", ccsText, "", CCGetRequestParam("persona_apellido", $Method, NULL), $this);
      $this->persona_conyuge = new clsControl(ccsTextBox, "persona_conyuge", "Conyuge", ccsText, "", CCGetRequestParam("persona_conyuge", $Method, NULL), $this);
      $this->persona_parcela_num_int = new clsControl(ccsTextBox, "persona_parcela_num_int", "Nro Instrumento", ccsText, "", CCGetRequestParam("persona_parcela_num_int", $Method, NULL), $this);
      $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "Tipo Instrumento", ccsInteger, "", CCGetRequestParam("tipo_instrumento_id", $Method, NULL), $this);
      $this->tipo_instrumento_id->DSType = dsTable;
      $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
      $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
      $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
      list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
      $this->planos_prov_id = new clsControl(ccsHidden, "planos_prov_id", "planos_prov_id", ccsText, "", CCGetRequestParam("planos_prov_id", $Method, NULL), $this);
      $this->persona_id = new clsControl(ccsHidden, "persona_id", "persona_id", ccsText, "", CCGetRequestParam("persona_id", $Method, NULL), $this);
      $this->planos_parc_prov_personas_id = new clsControl(ccsHidden, "planos_parc_prov_personas_id", "planos_parc_prov_personas_id", ccsText, "", CCGetRequestParam("planos_parc_prov_personas_id", $Method, NULL), $this);
      $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
      $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
      $this->persona_f_proce = new clsControl(ccsHidden, "persona_f_proce", "persona_f_proce", ccsText, "", CCGetRequestParam("persona_f_proce", $Method, NULL), $this);
      $this->persona_f_alta = new clsControl(ccsHidden, "persona_f_alta", "persona_f_alta", ccsText, "", CCGetRequestParam("persona_f_alta", $Method, NULL), $this);
      if(!$this->FormSubmitted) {
        if(!is_array($this->pais_id->Value) && !strlen($this->pais_id->Value) && $this->pais_id->Value !== false)
          $this->pais_id->SetText(12);
        if(!is_array($this->planos_prov_id->Value) && !strlen($this->planos_prov_id->Value) && $this->planos_prov_id->Value !== false)
          $this->planos_prov_id->SetText(CCGetParam('planos_prov_id'));
        if(!is_array($this->persona_id->Value) && !strlen($this->persona_id->Value) && $this->persona_id->Value !== false)
          $this->persona_id->SetText(CCGetParam('persona_id'));
      }
    }
  }
//End Class_Initialize Event

//Initialize Method @68-AF060F1F
  function Initialize()
  {

    if(!$this->Visible)
      return;

    $this->DataSource->Parameters["urlpersona_id"] = CCGetFromGet("persona_id", NULL);
  }
//End Initialize Method

//Validate Method @68-F5B7A34F
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    if(strlen($this->persona_email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->persona_email->GetText())) {
      $this->persona_email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "Email"));
    }
    $Validation = ($this->persona_nro_doc->Validate() && $Validation);
    $Validation = ($this->persona_denominacion->Validate() && $Validation);
    $Validation = ($this->persona_fecha_nac->Validate() && $Validation);
    $Validation = ($this->persona_tel_movil->Validate() && $Validation);
    $Validation = ($this->persona_cuit->Validate() && $Validation);
    $Validation = ($this->tipo_documento_id->Validate() && $Validation);
    $Validation = ($this->pais_id->Validate() && $Validation);
    $Validation = ($this->persona_email->Validate() && $Validation);
    $Validation = ($this->persona_parcela_dominio->Validate() && $Validation);
    $Validation = ($this->tipo_persona_parcela_id->Validate() && $Validation);
    $Validation = ($this->tipo_persona_id->Validate() && $Validation);
    $Validation = ($this->persona_parcela_f_int->Validate() && $Validation);
    $Validation = ($this->persona_nombre->Validate() && $Validation);
    $Validation = ($this->persona_apellido->Validate() && $Validation);
    $Validation = ($this->persona_conyuge->Validate() && $Validation);
    $Validation = ($this->persona_parcela_num_int->Validate() && $Validation);
    $Validation = ($this->tipo_instrumento_id->Validate() && $Validation);
    $Validation = ($this->planos_prov_id->Validate() && $Validation);
    $Validation = ($this->persona_id->Validate() && $Validation);
    $Validation = ($this->planos_parc_prov_personas_id->Validate() && $Validation);
    $Validation = ($this->persona_f_proce->Validate() && $Validation);
    $Validation = ($this->persona_f_alta->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->persona_nro_doc->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_denominacion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_fecha_nac->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_tel_movil->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_cuit->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_documento_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pais_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_email->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_parcela_dominio->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_persona_parcela_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_persona_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_parcela_f_int->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_nombre->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_apellido->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_conyuge->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_parcela_num_int->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_instrumento_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->planos_prov_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->planos_parc_prov_personas_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_f_proce->Errors->Count() == 0);
    $Validation =  $Validation && ($this->persona_f_alta->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @68-AAA91808
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->persona_nro_doc->Errors->Count());
    $errors = ($errors || $this->persona_denominacion->Errors->Count());
    $errors = ($errors || $this->persona_fecha_nac->Errors->Count());
    $errors = ($errors || $this->persona_tel_movil->Errors->Count());
    $errors = ($errors || $this->persona_cuit->Errors->Count());
    $errors = ($errors || $this->tipo_documento_id->Errors->Count());
    $errors = ($errors || $this->pais_id->Errors->Count());
    $errors = ($errors || $this->persona_email->Errors->Count());
    $errors = ($errors || $this->persona_parcela_dominio->Errors->Count());
    $errors = ($errors || $this->tipo_persona_parcela_id->Errors->Count());
    $errors = ($errors || $this->tipo_persona_id->Errors->Count());
    $errors = ($errors || $this->persona_parcela_f_int->Errors->Count());
    $errors = ($errors || $this->DatePicker_persona_parcela_f_int1->Errors->Count());
    $errors = ($errors || $this->persona_nombre->Errors->Count());
    $errors = ($errors || $this->persona_apellido->Errors->Count());
    $errors = ($errors || $this->persona_conyuge->Errors->Count());
    $errors = ($errors || $this->persona_parcela_num_int->Errors->Count());
    $errors = ($errors || $this->tipo_instrumento_id->Errors->Count());
    $errors = ($errors || $this->planos_prov_id->Errors->Count());
    $errors = ($errors || $this->persona_id->Errors->Count());
    $errors = ($errors || $this->planos_parc_prov_personas_id->Errors->Count());
    $errors = ($errors || $this->persona_f_proce->Errors->Count());
    $errors = ($errors || $this->persona_f_alta->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    $errors = ($errors || $this->DataSource->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @68-ED598703
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

//Operation Method @68-CFD4A32B
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
      if($this->Button_Update->Pressed) {
        $this->PressedButton = "Button_Update";
      } else if($this->Button_Cancel->Pressed) {
        $this->PressedButton = "Button_Cancel";
      } else if($this->Button_Delete->Pressed) {
        $this->PressedButton = "Button_Delete";
      } else if($this->Button_Insert->Pressed) {
        $this->PressedButton = "Button_Insert";
      }
    }
    $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if($this->PressedButton == "Button_Cancel") {
      $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "persona_id", "persona_parcela_id", "personas", "direcciones", "direccion_id", "add"));
      if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
        if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
          $Redirect = "";
        }
      } else if($this->PressedButton == "Button_Delete") {
        if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete)) {
          $Redirect = "";
        }
      } else if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
        if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
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

//InsertRow Method @68-865FED4F
  function InsertRow()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
    if(!$this->InsertAllowed) return false;
    $this->DataSource->persona_nro_doc->SetValue($this->persona_nro_doc->GetValue(true));
    $this->DataSource->persona_denominacion->SetValue($this->persona_denominacion->GetValue(true));
    $this->DataSource->persona_fecha_nac->SetValue($this->persona_fecha_nac->GetValue(true));
    $this->DataSource->persona_tel_movil->SetValue($this->persona_tel_movil->GetValue(true));
    $this->DataSource->persona_cuit->SetValue($this->persona_cuit->GetValue(true));
    $this->DataSource->tipo_documento_id->SetValue($this->tipo_documento_id->GetValue(true));
    $this->DataSource->pais_id->SetValue($this->pais_id->GetValue(true));
    $this->DataSource->persona_email->SetValue($this->persona_email->GetValue(true));
    $this->DataSource->persona_parcela_dominio->SetValue($this->persona_parcela_dominio->GetValue(true));
    $this->DataSource->tipo_persona_parcela_id->SetValue($this->tipo_persona_parcela_id->GetValue(true));
    $this->DataSource->tipo_persona_id->SetValue($this->tipo_persona_id->GetValue(true));
    $this->DataSource->persona_parcela_f_int->SetValue($this->persona_parcela_f_int->GetValue(true));
    $this->DataSource->persona_nombre->SetValue($this->persona_nombre->GetValue(true));
    $this->DataSource->persona_apellido->SetValue($this->persona_apellido->GetValue(true));
    $this->DataSource->persona_conyuge->SetValue($this->persona_conyuge->GetValue(true));
    $this->DataSource->persona_parcela_num_int->SetValue($this->persona_parcela_num_int->GetValue(true));
    $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
    $this->DataSource->planos_prov_id->SetValue($this->planos_prov_id->GetValue(true));
    $this->DataSource->persona_id->SetValue($this->persona_id->GetValue(true));
    $this->DataSource->planos_parc_prov_personas_id->SetValue($this->planos_parc_prov_personas_id->GetValue(true));
    $this->DataSource->persona_f_proce->SetValue($this->persona_f_proce->GetValue(true));
    $this->DataSource->persona_f_alta->SetValue($this->persona_f_alta->GetValue(true));
    $this->DataSource->Insert();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
    return (!$this->CheckErrors());
  }
//End InsertRow Method

//UpdateRow Method @68-0E933B2B
  function UpdateRow()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
    if(!$this->UpdateAllowed) return false;
    $this->DataSource->persona_nro_doc->SetValue($this->persona_nro_doc->GetValue(true));
    $this->DataSource->persona_denominacion->SetValue($this->persona_denominacion->GetValue(true));
    $this->DataSource->persona_fecha_nac->SetValue($this->persona_fecha_nac->GetValue(true));
    $this->DataSource->persona_tel_movil->SetValue($this->persona_tel_movil->GetValue(true));
    $this->DataSource->persona_cuit->SetValue($this->persona_cuit->GetValue(true));
    $this->DataSource->tipo_documento_id->SetValue($this->tipo_documento_id->GetValue(true));
    $this->DataSource->pais_id->SetValue($this->pais_id->GetValue(true));
    $this->DataSource->persona_email->SetValue($this->persona_email->GetValue(true));
    $this->DataSource->persona_parcela_dominio->SetValue($this->persona_parcela_dominio->GetValue(true));
    $this->DataSource->tipo_persona_parcela_id->SetValue($this->tipo_persona_parcela_id->GetValue(true));
    $this->DataSource->tipo_persona_id->SetValue($this->tipo_persona_id->GetValue(true));
    $this->DataSource->persona_parcela_f_int->SetValue($this->persona_parcela_f_int->GetValue(true));
    $this->DataSource->persona_nombre->SetValue($this->persona_nombre->GetValue(true));
    $this->DataSource->persona_apellido->SetValue($this->persona_apellido->GetValue(true));
    $this->DataSource->persona_conyuge->SetValue($this->persona_conyuge->GetValue(true));
    $this->DataSource->persona_parcela_num_int->SetValue($this->persona_parcela_num_int->GetValue(true));
    $this->DataSource->tipo_instrumento_id->SetValue($this->tipo_instrumento_id->GetValue(true));
    $this->DataSource->planos_prov_id->SetValue($this->planos_prov_id->GetValue(true));
    $this->DataSource->persona_id->SetValue($this->persona_id->GetValue(true));
    $this->DataSource->planos_parc_prov_personas_id->SetValue($this->planos_parc_prov_personas_id->GetValue(true));
    $this->DataSource->persona_f_proce->SetValue($this->persona_f_proce->GetValue(true));
    $this->DataSource->persona_f_alta->SetValue($this->persona_f_alta->GetValue(true));
    $this->DataSource->Update();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
    return (!$this->CheckErrors());
  }
//End UpdateRow Method

//Show Method @68-F0684F6E
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

    $this->tipo_documento_id->Prepare();
    $this->pais_id->Prepare();
    $this->tipo_persona_parcela_id->Prepare();
    $this->tipo_persona_id->Prepare();
    $this->tipo_instrumento_id->Prepare();

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
          $this->persona_nro_doc->SetValue($this->DataSource->persona_nro_doc->GetValue());
          $this->persona_denominacion->SetValue($this->DataSource->persona_denominacion->GetValue());
          $this->persona_fecha_nac->SetValue($this->DataSource->persona_fecha_nac->GetValue());
          $this->persona_tel_movil->SetValue($this->DataSource->persona_tel_movil->GetValue());
          $this->persona_cuit->SetValue($this->DataSource->persona_cuit->GetValue());
          $this->tipo_documento_id->SetValue($this->DataSource->tipo_documento_id->GetValue());
          $this->pais_id->SetValue($this->DataSource->pais_id->GetValue());
          $this->persona_email->SetValue($this->DataSource->persona_email->GetValue());
          $this->tipo_persona_id->SetValue($this->DataSource->tipo_persona_id->GetValue());
          $this->persona_nombre->SetValue($this->DataSource->persona_nombre->GetValue());
          $this->persona_apellido->SetValue($this->DataSource->persona_apellido->GetValue());
          $this->persona_conyuge->SetValue($this->DataSource->persona_conyuge->GetValue());
          $this->persona_f_proce->SetValue($this->DataSource->persona_f_proce->GetValue());
          $this->persona_f_alta->SetValue($this->DataSource->persona_f_alta->GetValue());
        }
      } else {
        $this->EditMode = false;
      }
    }
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->persona_nro_doc->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_denominacion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_fecha_nac->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_tel_movil->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_cuit->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_documento_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pais_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_email->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_parcela_dominio->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_persona_parcela_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_persona_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_parcela_f_int->Errors->ToString());
      $Error = ComposeStrings($Error, $this->DatePicker_persona_parcela_f_int1->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_nombre->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_apellido->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_conyuge->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_parcela_num_int->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_instrumento_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->planos_prov_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->planos_parc_prov_personas_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_f_proce->Errors->ToString());
      $Error = ComposeStrings($Error, $this->persona_f_alta->Errors->ToString());
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
    $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
    $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    $this->Attributes->Show();
    if(!$this->Visible) {
      $Tpl->block_path = $ParentPath;
      return;
    }

    $this->Button_Update->Show();
    $this->Button_Cancel->Show();
    $this->persona_nro_doc->Show();
    $this->persona_denominacion->Show();
    $this->persona_fecha_nac->Show();
    $this->persona_tel_movil->Show();
    $this->persona_cuit->Show();
    $this->tipo_documento_id->Show();
    $this->pais_id->Show();
    $this->persona_email->Show();
    $this->persona_parcela_dominio->Show();
    $this->tipo_persona_parcela_id->Show();
    $this->tipo_persona_id->Show();
    $this->persona_parcela_f_int->Show();
    $this->DatePicker_persona_parcela_f_int1->Show();
    $this->persona_nombre->Show();
    $this->persona_apellido->Show();
    $this->persona_conyuge->Show();
    $this->persona_parcela_num_int->Show();
    $this->tipo_instrumento_id->Show();
    $this->planos_prov_id->Show();
    $this->persona_id->Show();
    $this->planos_parc_prov_personas_id->Show();
    $this->Button_Delete->Show();
    $this->Button_Insert->Show();
    $this->persona_f_proce->Show();
    $this->persona_f_alta->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

} //End personasEdit Class @68-FCB6E20C

class clspersonasEditDataSource extends clsDBtdf_nuevo {  //personasEditDataSource Class @68-83A7408C

//DataSource Variables @68-CA8BBF73
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
  public $persona_nro_doc;
  public $persona_denominacion;
  public $persona_fecha_nac;
  public $persona_tel_movil;
  public $persona_cuit;
  public $tipo_documento_id;
  public $pais_id;
  public $persona_email;
  public $persona_parcela_dominio;
  public $tipo_persona_parcela_id;
  public $tipo_persona_id;
  public $persona_parcela_f_int;
  public $persona_nombre;
  public $persona_apellido;
  public $persona_conyuge;
  public $persona_parcela_num_int;
  public $tipo_instrumento_id;
  public $planos_prov_id;
  public $persona_id;
  public $planos_parc_prov_personas_id;
  public $persona_f_proce;
  public $persona_f_alta;
//End DataSource Variables

//DataSourceClass_Initialize Event @68-CF11BC61
  function clspersonasEditDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Record personasEdit/Error";
    $this->Initialize();
    $this->persona_nro_doc = new clsField("persona_nro_doc", ccsInteger, "");
    
    $this->persona_denominacion = new clsField("persona_denominacion", ccsText, "");
    
    $this->persona_fecha_nac = new clsField("persona_fecha_nac", ccsDate, $this->DateFormat);
    
    $this->persona_tel_movil = new clsField("persona_tel_movil", ccsText, "");
    
    $this->persona_cuit = new clsField("persona_cuit", ccsText, "");
    
    $this->tipo_documento_id = new clsField("tipo_documento_id", ccsInteger, "");
    
    $this->pais_id = new clsField("pais_id", ccsInteger, "");
    
    $this->persona_email = new clsField("persona_email", ccsText, "");
    
    $this->persona_parcela_dominio = new clsField("persona_parcela_dominio", ccsFloat, "");
    
    $this->tipo_persona_parcela_id = new clsField("tipo_persona_parcela_id", ccsInteger, "");
    
    $this->tipo_persona_id = new clsField("tipo_persona_id", ccsText, "");
    
    $this->persona_parcela_f_int = new clsField("persona_parcela_f_int", ccsDate, $this->DateFormat);
    
    $this->persona_nombre = new clsField("persona_nombre", ccsText, "");
    
    $this->persona_apellido = new clsField("persona_apellido", ccsText, "");
    
    $this->persona_conyuge = new clsField("persona_conyuge", ccsText, "");
    
    $this->persona_parcela_num_int = new clsField("persona_parcela_num_int", ccsText, "");
    
    $this->tipo_instrumento_id = new clsField("tipo_instrumento_id", ccsInteger, "");
    
    $this->planos_prov_id = new clsField("planos_prov_id", ccsText, "");
    
    $this->persona_id = new clsField("persona_id", ccsText, "");
    
    $this->planos_parc_prov_personas_id = new clsField("planos_parc_prov_personas_id", ccsText, "");
    
    $this->persona_f_proce = new clsField("persona_f_proce", ccsText, "");
    
    $this->persona_f_alta = new clsField("persona_f_alta", ccsText, "");
    

    $this->InsertFields["persona_nro_doc"] = array("Name" => "persona_nro_doc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_denominacion"] = array("Name" => "persona_denominacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_fecha_nac"] = array("Name" => "persona_fecha_nac", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_tel_movil"] = array("Name" => "persona_tel_movil", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_cuit"] = array("Name" => "persona_cuit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["tipo_documento_id"] = array("Name" => "tipo_documento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["pais_id"] = array("Name" => "pais_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_email"] = array("Name" => "persona_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["tipo_persona_id"] = array("Name" => "tipo_persona_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_nombre"] = array("Name" => "persona_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_apellido"] = array("Name" => "persona_apellido", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_conyuge"] = array("Name" => "persona_conyuge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_f_proce"] = array("Name" => "persona_f_proce", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->InsertFields["persona_f_alta"] = array("Name" => "persona_f_alta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_nro_doc"] = array("Name" => "persona_nro_doc", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_denominacion"] = array("Name" => "persona_denominacion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_fecha_nac"] = array("Name" => "persona_fecha_nac", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_tel_movil"] = array("Name" => "persona_tel_movil", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_cuit"] = array("Name" => "persona_cuit", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_documento_id"] = array("Name" => "tipo_documento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["pais_id"] = array("Name" => "pais_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_email"] = array("Name" => "persona_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_persona_id"] = array("Name" => "tipo_persona_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_nombre"] = array("Name" => "persona_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_apellido"] = array("Name" => "persona_apellido", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_conyuge"] = array("Name" => "persona_conyuge", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_f_proce"] = array("Name" => "persona_f_proce", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["persona_f_alta"] = array("Name" => "persona_f_alta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
  }
//End DataSourceClass_Initialize Event

//Prepare Method @68-36BC5D88
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urlpersona_id", ccsInteger, "", "", $this->Parameters["urlpersona_id"], "", false);
    $this->AllParametersSet = $this->wp->AllParamsSet();
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "persona_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->Where = 
       $this->wp->Criterion[1];
  }
//End Prepare Method

//Open Method @68-6DF7A751
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->SQL = "SELECT * \n\n" .
    "FROM personas {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    $this->PageSize = 1;
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @68-55D37796
  function SetValues()
  {
    $this->persona_nro_doc->SetDBValue(trim($this->f("persona_nro_doc")));
    $this->persona_denominacion->SetDBValue($this->f("persona_denominacion"));
    $this->persona_fecha_nac->SetDBValue(trim($this->f("persona_fecha_nac")));
    $this->persona_tel_movil->SetDBValue($this->f("persona_tel_movil"));
    $this->persona_cuit->SetDBValue($this->f("persona_cuit"));
    $this->tipo_documento_id->SetDBValue(trim($this->f("tipo_documento_id")));
    $this->pais_id->SetDBValue(trim($this->f("pais_id")));
    $this->persona_email->SetDBValue($this->f("persona_email"));
    $this->tipo_persona_id->SetDBValue($this->f("tipo_persona_id"));
    $this->persona_nombre->SetDBValue($this->f("persona_nombre"));
    $this->persona_apellido->SetDBValue($this->f("persona_apellido"));
    $this->persona_conyuge->SetDBValue($this->f("persona_conyuge"));
    $this->persona_f_proce->SetDBValue($this->f("persona_f_proce"));
    $this->persona_f_alta->SetDBValue($this->f("persona_f_alta"));
  }
//End SetValues Method

//Insert Method @68-E7D2E10D
  function Insert()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
    $this->InsertFields["persona_nro_doc"]["Value"] = $this->persona_nro_doc->GetDBValue(true);
    $this->InsertFields["persona_denominacion"]["Value"] = $this->persona_denominacion->GetDBValue(true);
    $this->InsertFields["persona_fecha_nac"]["Value"] = $this->persona_fecha_nac->GetDBValue(true);
    $this->InsertFields["persona_tel_movil"]["Value"] = $this->persona_tel_movil->GetDBValue(true);
    $this->InsertFields["persona_cuit"]["Value"] = $this->persona_cuit->GetDBValue(true);
    $this->InsertFields["tipo_documento_id"]["Value"] = $this->tipo_documento_id->GetDBValue(true);
    $this->InsertFields["pais_id"]["Value"] = $this->pais_id->GetDBValue(true);
    $this->InsertFields["persona_email"]["Value"] = $this->persona_email->GetDBValue(true);
    $this->InsertFields["tipo_persona_id"]["Value"] = $this->tipo_persona_id->GetDBValue(true);
    $this->InsertFields["persona_nombre"]["Value"] = $this->persona_nombre->GetDBValue(true);
    $this->InsertFields["persona_apellido"]["Value"] = $this->persona_apellido->GetDBValue(true);
    $this->InsertFields["persona_conyuge"]["Value"] = $this->persona_conyuge->GetDBValue(true);
    $this->InsertFields["persona_f_proce"]["Value"] = $this->persona_f_proce->GetDBValue(true);
    $this->InsertFields["persona_f_alta"]["Value"] = $this->persona_f_alta->GetDBValue(true);
    $this->SQL = CCBuildInsert("personas", $this->InsertFields, $this);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
    if($this->Errors->Count() == 0 && $this->CmdExecution) {
      $this->query($this->SQL);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
    }
  }
//End Insert Method

//Update Method @68-668E5924
  function Update()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
    $this->UpdateFields["persona_nro_doc"]["Value"] = $this->persona_nro_doc->GetDBValue(true);
    $this->UpdateFields["persona_denominacion"]["Value"] = $this->persona_denominacion->GetDBValue(true);
    $this->UpdateFields["persona_fecha_nac"]["Value"] = $this->persona_fecha_nac->GetDBValue(true);
    $this->UpdateFields["persona_tel_movil"]["Value"] = $this->persona_tel_movil->GetDBValue(true);
    $this->UpdateFields["persona_cuit"]["Value"] = $this->persona_cuit->GetDBValue(true);
    $this->UpdateFields["tipo_documento_id"]["Value"] = $this->tipo_documento_id->GetDBValue(true);
    $this->UpdateFields["pais_id"]["Value"] = $this->pais_id->GetDBValue(true);
    $this->UpdateFields["persona_email"]["Value"] = $this->persona_email->GetDBValue(true);
    $this->UpdateFields["tipo_persona_id"]["Value"] = $this->tipo_persona_id->GetDBValue(true);
    $this->UpdateFields["persona_nombre"]["Value"] = $this->persona_nombre->GetDBValue(true);
    $this->UpdateFields["persona_apellido"]["Value"] = $this->persona_apellido->GetDBValue(true);
    $this->UpdateFields["persona_conyuge"]["Value"] = $this->persona_conyuge->GetDBValue(true);
    $this->UpdateFields["persona_f_proce"]["Value"] = $this->persona_f_proce->GetDBValue(true);
    $this->UpdateFields["persona_f_alta"]["Value"] = $this->persona_f_alta->GetDBValue(true);
    $this->SQL = CCBuildUpdate("personas", $this->UpdateFields, $this);
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

} //End personasEditDataSource Class @68-FCB6E20C

//Initialize Page @1-3B8E5A17
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
$TemplateFileName = "tc_addTitular.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-833283F3
include_once("./tc_addTitular_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-26BE8330
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$personasSearch = new clsRecordpersonasSearch("", $MainPage);
$personas = new clsGridpersonas("", $MainPage);
$personasEdit = new clsRecordpersonasEdit("", $MainPage);
$MainPage->personasSearch = & $personasSearch;
$MainPage->personas = & $personas;
$MainPage->personasEdit = & $personasEdit;
$personas->Initialize();
$personasEdit->Initialize();

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

//Execute Components @1-A50E70AF
$personasSearch->Operation();
$personasEdit->Operation();
//End Execute Components

//Go to destination page @1-FA9B8233
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBtdf_nuevo->close();
  header("Location: " . $Redirect);
  unset($personasSearch);
  unset($personas);
  unset($personasEdit);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-463F5A8D
$personasSearch->Show();
$personas->Show();
$personasEdit->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$LARP2H6Q6Q4P = explode("|", "<center><font| face=\"Arial\"><sma|ll>&#71;e&#11|0;erate&#100; <!-|- SCC -->&#119;|i&#116;&#104; |<!-- SCC -->C&#1|11;&#100;eC&#1|04;&#97;rge <!-- C|CS -->Stu&#100|;&#105;&#111;.</sm|all></font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", join($LARP2H6Q6Q4P,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", join($LARP2H6Q6Q4P,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= join($LARP2H6Q6Q4P,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D220C5BC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($personasSearch);
unset($personas);
unset($personasEdit);
unset($Tpl);
//End Unload Page


?>
