<?php
//Include Common Files @1-D9343E65
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_archivo.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @43-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @44-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @45-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordarea1 { //area1 Class @46-E2E9F6FC

//Variables @46-9E315808

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

//Class_Initialize Event @46-7B61578E
  function clsRecordarea1($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record area1/Error";
    $this->ReadAllowed = true;
    if($this->Visible)
    {
      $this->ComponentName = "area1";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->s_pieza_nro = new clsControl(ccsTextBox, "s_pieza_nro", "s_pieza_nro", ccsInteger, "", CCGetRequestParam("s_pieza_nro", $Method, NULL), $this);
      $this->s_pieza_letra = new clsControl(ccsTextBox, "s_pieza_letra", "s_pieza_letra", ccsText, "", CCGetRequestParam("s_pieza_letra", $Method, NULL), $this);
      $this->s_pieza_anio = new clsControl(ccsTextBox, "s_pieza_anio", "s_pieza_anio", ccsInteger, "", CCGetRequestParam("s_pieza_anio", $Method, NULL), $this);
      $this->s_texto = new clsControl(ccsTextBox, "s_texto", "s_texto", ccsText, "", CCGetRequestParam("s_texto", $Method, NULL), $this);
      $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
      $this->Button1 = new clsButton("Button1", $Method, $this);
    }
  }
//End Class_Initialize Event

//Validate Method @46-33CCDE74
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->s_pieza_nro->Validate() && $Validation);
    $Validation = ($this->s_pieza_letra->Validate() && $Validation);
    $Validation = ($this->s_pieza_anio->Validate() && $Validation);
    $Validation = ($this->s_texto->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->s_pieza_nro->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_pieza_letra->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_pieza_anio->Errors->Count() == 0);
    $Validation =  $Validation && ($this->s_texto->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @46-13102EFA
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->s_pieza_nro->Errors->Count());
    $errors = ($errors || $this->s_pieza_letra->Errors->Count());
    $errors = ($errors || $this->s_pieza_anio->Errors->Count());
    $errors = ($errors || $this->s_texto->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @46-ED598703
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

//Operation Method @46-321B3890
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
      }
    }
    $Redirect = "msa_archivo.php";
    if($this->PressedButton == "Button1") {
      $Redirect = "msa_principal.php";
      if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_DoSearch") {
        $Redirect = "msa_archivo.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
        if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
          $Redirect = "";
        }
      }
    } else {
      $Redirect = "";
    }
  }
//End Operation Method

//Show Method @46-F95C1807
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


    $RecordBlock = "Record " . $this->ComponentName;
    $ParentPath = $Tpl->block_path;
    $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
    $this->EditMode = $this->EditMode && $this->ReadAllowed;
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->s_pieza_nro->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_pieza_letra->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_pieza_anio->Errors->ToString());
      $Error = ComposeStrings($Error, $this->s_texto->Errors->ToString());
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

    $this->s_pieza_nro->Show();
    $this->s_pieza_letra->Show();
    $this->s_pieza_anio->Show();
    $this->s_texto->Show();
    $this->Button_DoSearch->Show();
    $this->Button1->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
  }
//End Show Method

} //End area1 Class @46-FCB6E20C

class clsEditableGridarea { //area Class @2-31688929

//Variables @2-F9538F3C

  // Public variables
  public $ComponentType = "EditableGrid";
  public $ComponentName;
  public $HTMLFormAction;
  public $PressedButton;
  public $Errors;
  public $ErrorBlock;
  public $FormSubmitted;
  public $FormParameters;
  public $FormState;
  public $FormEnctype;
  public $CachedColumns;
  public $TotalRows;
  public $UpdatedRows;
  public $EmptyRows;
  public $Visible;
  public $RowsErrors;
  public $ds;
  public $DataSource;
  public $PageSize;
  public $IsEmpty;
  public $SorterName = "";
  public $SorterDirection = "";
  public $PageNumber;
  public $ControlsVisible = array();

  public $CCSEvents = "";
  public $CCSEventResult;

  public $RelativePath = "";

  public $InsertAllowed = false;
  public $UpdateAllowed = false;
  public $DeleteAllowed = false;
  public $ReadAllowed   = false;
  public $EditMode;
  public $ValidatingControls;
  public $Controls;
  public $ControlsErrors;
  public $RowNumber;
  public $Attributes;
  public $PrimaryKeys;

  // Class variables
//End Variables

//Class_Initialize Event @2-CD4DBFD2
  function clsEditableGridarea($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "EditableGrid area/Error";
    $this->ControlsErrors = array();
    $this->ComponentName = "area";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->CachedColumns["piezas.pieza_id"][0] = "piezas.pieza_id";
    $this->CachedColumns["pase_id"][0] = "pase_id";
    $this->CachedColumns["pieza_id"][0] = "pieza_id";
    $this->CachedColumns["pieza_tipo_id"][0] = "pieza_tipo_id";
    $this->CachedColumns["adjunto_id"][0] = "adjunto_id";
    $this->DataSource = new clsareaDataSource($this);
    $this->ds = & $this->DataSource;
    $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
    if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
      $this->PageSize = 10;
    else
      $this->PageSize = intval($this->PageSize);
    if ($this->PageSize > 100)
      $this->PageSize = 100;
    if($this->PageSize == 0)
      $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
    $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
    if ($this->PageNumber <= 0) $this->PageNumber = 1;

    $this->EmptyRows = 0;
    $this->ReadAllowed = true;
    if(!$this->Visible) return;

    $CCSForm = CCGetFromGet("ccsForm", "");
    $this->FormEnctype = "application/x-www-form-urlencoded";
    $this->FormSubmitted = ($CCSForm == $this->ComponentName);
    if($this->FormSubmitted) {
      $this->FormState = CCGetFromPost("FormState", "");
      $this->SetFormState($this->FormState);
    } else {
      $this->FormState = "";
    }
    $Method = $this->FormSubmitted ? ccsPost : ccsGet;

    $this->pieza_tipo_abrev = new clsControl(ccsLabel, "pieza_tipo_abrev", "Pieza Tipo Abrev", ccsText, "", NULL, $this);
    $this->pieza = new clsControl(ccsLabel, "pieza", "Pieza", ccsText, "", NULL, $this);
    $this->pase_n_fojas = new clsControl(ccsLabel, "pase_n_fojas", "Pase N Fojas", ccsInteger, "", NULL, $this);
    $this->pieza_tm_nro = new clsControl(ccsLabel, "pieza_tm_nro", "Pieza Tm Nro", ccsInteger, "", NULL, $this);
    $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "Pieza Descripcion", ccsText, "", NULL, $this);
    $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
    $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    $this->rutaLnk = new clsControl(ccsImageLink, "rutaLnk", "rutaLnk", ccsText, "", NULL, $this);
    $this->rutaLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    $this->rutaLnk->Page = "";
    $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, NULL, $this);
    $this->archLnk = new clsControl(ccsImageLink, "archLnk", "archLnk", ccsText, "", NULL, $this);
    $this->archLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
    $this->archLnk->Page = "";
    $this->adjLnk = new clsControl(ccsImageLink, "adjLnk", "adjLnk", ccsText, "", NULL, $this);
    $this->adjLnk->Page = "";
    $this->cant = new clsControl(ccsLabel, "cant", "cant", ccsText, "", NULL, $this);
    $this->pieza_archivo = new clsControl(ccsLabel, "pieza_archivo", "pieza_archivo", ccsText, "", NULL, $this);
  }
//End Class_Initialize Event

//Initialize Method @2-BBD1B31F
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

    $this->DataSource->Parameters["expr19"] = 1;
    $this->DataSource->Parameters["expr20"] = 1;
    $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
    $this->DataSource->Parameters["expr22"] = 1;
    $this->DataSource->Parameters["expr23"] = 1;
    $this->DataSource->Parameters["urls_pieza_nro"] = CCGetFromGet("s_pieza_nro", NULL);
    $this->DataSource->Parameters["urls_pieza_letra"] = CCGetFromGet("s_pieza_letra", NULL);
    $this->DataSource->Parameters["urls_pieza_anio"] = CCGetFromGet("s_pieza_anio", NULL);
    $this->DataSource->Parameters["urls_texto"] = CCGetFromGet("s_texto", NULL);
  }
//End Initialize Method

//SetPrimaryKeys Method @2-EBC3F86C
  function SetPrimaryKeys($PrimaryKeys) {
    $this->PrimaryKeys = $PrimaryKeys;
    return $this->PrimaryKeys;
  }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @2-74F9A772
  function GetPrimaryKeys() {
    return $this->PrimaryKeys;
  }
//End GetPrimaryKeys Method

//GetFormParameters Method @2-097BD644
  function GetFormParameters()
  {
    for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
    {
    }
  }
//End GetFormParameters Method

//Validate Method @2-115A8D67
  function Validate()
  {
    $Validation = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

    for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
    {
      $this->DataSource->CachedColumns["piezas.pieza_id"] = $this->CachedColumns["piezas.pieza_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["pase_id"] = $this->CachedColumns["pase_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["pieza_id"] = $this->CachedColumns["pieza_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["pieza_tipo_id"] = $this->CachedColumns["pieza_tipo_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["adjunto_id"] = $this->CachedColumns["adjunto_id"][$this->RowNumber];
      $this->DataSource->CurrentRow = $this->RowNumber;
      if ($this->UpdatedRows >= $this->RowNumber) {
        $Validation = ($this->ValidateRow($this->RowNumber) && $Validation);
      }
      else if($this->CheckInsert())
      {
        $Validation = ($this->ValidateRow() && $Validation);
      }
    }
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//ValidateRow Method @2-BEFC2A36
  function ValidateRow()
  {
    global $CCSLocales;
    $this->RowErrors = new clsErrors();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
    $errors = "";
    $errors = ComposeStrings($errors, $this->RowErrors->ToString());
    $this->RowsErrors[$this->RowNumber] = $errors;
    return $errors != "" ? 0 : 1;
  }
//End ValidateRow Method

//CheckInsert Method @2-FC0A7F41
  function CheckInsert()
  {
    $filed = false;
    return $filed;
  }
//End CheckInsert Method

//CheckErrors Method @2-F5A3B433
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->Errors->Count());
    $errors = ($errors || $this->DataSource->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//Operation Method @2-9ADF79E4
  function Operation()
  {
    if(!$this->Visible)
      return;

    global $Redirect;
    global $FileName;

    $this->DataSource->Prepare();
    if(!$this->FormSubmitted)
      return;

    $this->GetFormParameters();

    $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if ($Redirect)
      $this->DataSource->close();
  }
//End Operation Method

//UpdateGrid Method @2-2D275729
  function UpdateGrid()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
    if(!$this->Validate()) return;
    $Validation = true;
    for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
    {
      $this->DataSource->CachedColumns["piezas.pieza_id"] = $this->CachedColumns["piezas.pieza_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["pase_id"] = $this->CachedColumns["pase_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["pieza_id"] = $this->CachedColumns["pieza_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["pieza_tipo_id"] = $this->CachedColumns["pieza_tipo_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["adjunto_id"] = $this->CachedColumns["adjunto_id"][$this->RowNumber];
      $this->DataSource->CurrentRow = $this->RowNumber;
      if ($this->UpdatedRows >= $this->RowNumber) {
        if($this->UpdateAllowed) { $Validation = ($this->UpdateRow() && $Validation); }
      }
      else if($this->CheckInsert() && $this->InsertAllowed)
      {
        $Validation = ($Validation && $this->InsertRow());
      }
    }
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterSubmit", $this);
    if ($this->Errors->Count() == 0 && $Validation){
      $this->DataSource->close();
      return true;
    }
    return false;
  }
//End UpdateGrid Method

//FormScript Method @2-59800DB5
  function FormScript($TotalRows)
  {
    $script = "";
    return $script;
  }
//End FormScript Method

//SetFormState Method @2-860A032D
  function SetFormState($FormState)
  {
    if(strlen($FormState)) {
      $FormState = str_replace("\\\\", "\\" . ord("\\"), $FormState);
      $FormState = str_replace("\\;", "\\" . ord(";"), $FormState);
      $pieces = explode(";", $FormState);
      $this->UpdatedRows = $pieces[0];
      $this->EmptyRows   = $pieces[1];
      $this->TotalRows = $this->UpdatedRows + $this->EmptyRows;
      $RowNumber = 0;
      for($i = 2; $i < sizeof($pieces); $i = $i + 5)  {
        $piece = $pieces[$i + 0];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["piezas.pieza_id"][$RowNumber] = $piece;
        $piece = $pieces[$i + 1];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["pase_id"][$RowNumber] = $piece;
        $piece = $pieces[$i + 2];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["pieza_id"][$RowNumber] = $piece;
        $piece = $pieces[$i + 3];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["pieza_tipo_id"][$RowNumber] = $piece;
        $piece = $pieces[$i + 4];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["adjunto_id"][$RowNumber] = $piece;
        $RowNumber++;
      }

      if(!$RowNumber) { $RowNumber = 1; }
      for($i = 1; $i <= $this->EmptyRows; $i++) {
        $this->CachedColumns["piezas.pieza_id"][$RowNumber] = "";
        $this->CachedColumns["pase_id"][$RowNumber] = "";
        $this->CachedColumns["pieza_id"][$RowNumber] = "";
        $this->CachedColumns["pieza_tipo_id"][$RowNumber] = "";
        $this->CachedColumns["adjunto_id"][$RowNumber] = "";
        $RowNumber++;
      }
    }
  }
//End SetFormState Method

//GetFormState Method @2-D886C39A
  function GetFormState($NonEmptyRows)
  {
    if(!$this->FormSubmitted) {
      $this->FormState  = $NonEmptyRows . ";";
      $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
      if($NonEmptyRows) {
        for($i = 0; $i <= $NonEmptyRows; $i++) {
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["piezas.pieza_id"][$i]));
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pase_id"][$i]));
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pieza_id"][$i]));
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["pieza_tipo_id"][$i]));
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["adjunto_id"][$i]));
        }
      }
    }
    return $this->FormState;
  }
//End GetFormState Method

//Show Method @2-ECE44F48
  function Show()
  {
    global $Tpl;
    global $FileName;
    global $CCSLocales;
    global $CCSUseAmp;
    $Error = "";

    if(!$this->Visible) { return; }

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


    $this->DataSource->open();
    $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
    $this->IsEmpty = ! $is_next_record;

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if(!$this->Visible) { return; }

    $this->Attributes->Show();
    $ParentPath = $Tpl->block_path;
    $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
    $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
    $Tpl->block_path = $EditableGridRowPath;
    $this->RowNumber = 0;
    $NonEmptyRows = 0;
    $EmptyRowsLeft = $this->EmptyRows;
    $this->ControlsVisible["pieza_tipo_abrev"] = $this->pieza_tipo_abrev->Visible;
    $this->ControlsVisible["pieza"] = $this->pieza->Visible;
    $this->ControlsVisible["pase_n_fojas"] = $this->pase_n_fojas->Visible;
    $this->ControlsVisible["pieza_tm_nro"] = $this->pieza_tm_nro->Visible;
    $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
    $this->ControlsVisible["rutaLnk"] = $this->rutaLnk->Visible;
    $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
    $this->ControlsVisible["archLnk"] = $this->archLnk->Visible;
    $this->ControlsVisible["adjLnk"] = $this->adjLnk->Visible;
    $this->ControlsVisible["pieza_archivo"] = $this->pieza_archivo->Visible;
    if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
      do {
        $this->RowNumber++;
        if($is_next_record) {
          $NonEmptyRows++;
          $this->DataSource->SetValues();
        }
        if (!($this->FormSubmitted) && $is_next_record) {
          $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = $this->DataSource->CachedColumns["piezas.pieza_id"];
          $this->CachedColumns["pase_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pase_id"];
          $this->CachedColumns["pieza_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pieza_id"];
          $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = $this->DataSource->CachedColumns["pieza_tipo_id"];
          $this->CachedColumns["adjunto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["adjunto_id"];
          $this->rutaLnk->SetText("");
          $this->archLnk->SetText("");
          $this->adjLnk->SetText("");
          $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
          $this->pieza->SetValue($this->DataSource->pieza->GetValue());
          $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
          $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
          $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
          $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
          $this->adjLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
          $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
          $this->pieza_archivo->SetValue($this->DataSource->pieza_archivo->GetValue());
        } elseif ($this->FormSubmitted && $is_next_record) {
          $this->pieza_tipo_abrev->SetText("");
          $this->pieza->SetText("");
          $this->pase_n_fojas->SetText("");
          $this->pieza_tm_nro->SetText("");
          $this->pieza_descripcion->SetText("");
          $this->rutaLnk->SetText("");
          $this->pieza_f_alta->SetText("");
          $this->archLnk->SetText("");
          $this->adjLnk->SetText("");
          $this->pieza_archivo->SetText("");
          $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
          $this->pieza->SetValue($this->DataSource->pieza->GetValue());
          $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
          $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
          $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
          $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
          $this->pieza_archivo->SetValue($this->DataSource->pieza_archivo->GetValue());
          $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
        } elseif (!$this->FormSubmitted) {
          $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
          $this->CachedColumns["pase_id"][$this->RowNumber] = "";
          $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
          $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
          $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
          $this->pieza_tipo_abrev->SetText("");
          $this->pieza->SetText("");
          $this->pase_n_fojas->SetText("");
          $this->pieza_tm_nro->SetText("");
          $this->pieza_descripcion->SetText("");
          $this->rutaLnk->SetText("");
          $this->pieza_f_alta->SetText("");
          $this->archLnk->SetText("");
          $this->adjLnk->SetText("");
          $this->pieza_archivo->SetText("");
          $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
        } else {
          $this->pieza_tipo_abrev->SetText("");
          $this->pieza->SetText("");
          $this->pase_n_fojas->SetText("");
          $this->pieza_tm_nro->SetText("");
          $this->pieza_descripcion->SetText("");
          $this->rutaLnk->SetText("");
          $this->pieza_f_alta->SetText("");
          $this->archLnk->SetText("");
          $this->adjLnk->SetText("");
          $this->pieza_archivo->SetText("");
          $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
        }
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->pieza_tipo_abrev->Show($this->RowNumber);
        $this->pieza->Show($this->RowNumber);
        $this->pase_n_fojas->Show($this->RowNumber);
        $this->pieza_tm_nro->Show($this->RowNumber);
        $this->pieza_descripcion->Show($this->RowNumber);
        $this->rutaLnk->Show($this->RowNumber);
        $this->pieza_f_alta->Show($this->RowNumber);
        $this->archLnk->Show($this->RowNumber);
        $this->adjLnk->Show($this->RowNumber);
        $this->pieza_archivo->Show($this->RowNumber);
        if (isset($this->RowsErrors[$this->RowNumber]) && ($this->RowsErrors[$this->RowNumber] != "")) {
          $Tpl->setblockvar("RowError", "");
          $Tpl->setvar("Error", $this->RowsErrors[$this->RowNumber]);
          $this->Attributes->Show();
          $Tpl->parse("RowError", false);
        } else {
          $Tpl->setblockvar("RowError", "");
        }
        $Tpl->setvar("FormScript", $this->FormScript($this->RowNumber));
        $Tpl->parse();
        if ($is_next_record) {
          if ($this->FormSubmitted) {
            $is_next_record = $this->RowNumber < $this->UpdatedRows;
            if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber])) {
              if ($this->ReadAllowed) $this->DataSource->next_record();
            }
          }else{
            $is_next_record = ($this->RowNumber < $this->PageSize) &&  $this->ReadAllowed && $this->DataSource->next_record();
          }
        } else { 
          $EmptyRowsLeft--;
        }
      } while($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed));
    } else {
      $Tpl->block_path = $EditableGridPath;
      $this->Attributes->Show();
      $Tpl->parse("NoRecords", false);
    }

    $Tpl->block_path = $EditableGridPath;
    $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
    $this->Navigator->PageSize = $this->PageSize;
    if ($this->DataSource->RecordsCount == "CCS not counted")
      $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
    else
      $this->Navigator->TotalPages = $this->DataSource->PageCount();
    if ($this->Navigator->TotalPages <= 1) {
      $this->Navigator->Visible = false;
    }
    $this->Navigator->Show();
    $this->cant->Show();

    if($this->CheckErrors()) {
      $Error = ComposeStrings($Error, $this->Errors->ToString());
      $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
      $Tpl->SetVar("Error", $Error);
      $Tpl->Parse("Error", false);
    }
    $CCSForm = $this->ComponentName;
    $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
    $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
    $Tpl->SetVar("HTMLFormName", $this->ComponentName);
    $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
    if (!$CCSUseAmp) {
      $Tpl->SetVar("HTMLFormProperties", "method=\"POST\" action=\"" . $this->HTMLFormAction . "\" name=\"" . $this->ComponentName . "\"");
    } else {
      $Tpl->SetVar("HTMLFormProperties", "method=\"post\" action=\"" . str_replace("&", "&amp;", $this->HTMLFormAction) . "\" id=\"" . $this->ComponentName . "\"");
    }
    $Tpl->SetVar("FormState", CCToHTML($this->GetFormState($NonEmptyRows)));
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

} //End area Class @2-FCB6E20C

class clsareaDataSource extends clsDBmesa {  //areaDataSource Class @2-D8CC5B5C

//DataSource Variables @2-D9DDCEBA
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $CountSQL;
  public $wp;
  public $AllParametersSet;

  public $CachedColumns;
  public $CurrentRow;

  // Datasource fields
  public $pieza_tipo_abrev;
  public $pieza;
  public $pase_n_fojas;
  public $pieza_tm_nro;
  public $pieza_descripcion;
  public $rutaLnk;
  public $pieza_f_alta;
  public $archLnk;
  public $adjLnk;
  public $pieza_archivo;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-B3932961
  function clsareaDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "EditableGrid area/Error";
    $this->Initialize();
    $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
    
    $this->pieza = new clsField("pieza", ccsText, "");
    
    $this->pase_n_fojas = new clsField("pase_n_fojas", ccsInteger, "");
    
    $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
    
    $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
    
    $this->rutaLnk = new clsField("rutaLnk", ccsText, "");
    
    $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
    
    $this->archLnk = new clsField("archLnk", ccsText, "");
    
    $this->adjLnk = new clsField("adjLnk", ccsText, "");
    
    $this->pieza_archivo = new clsField("pieza_archivo", ccsText, "");
    

  }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-BFB46204
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "pases.pase_f_pase desc";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      "");
  }
//End SetOrder Method

//Prepare Method @2-429BB79F
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "expr19", ccsInteger, "", "", $this->Parameters["expr19"], "", false);
    $this->wp->AddParameter("2", "expr20", ccsInteger, "", "", $this->Parameters["expr20"], "", false);
    $this->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
    $this->wp->AddParameter("4", "expr22", ccsInteger, "", "", $this->Parameters["expr22"], "", false);
    $this->wp->AddParameter("5", "expr23", ccsInteger, "", "", $this->Parameters["expr23"], "", false);
    $this->wp->AddParameter("6", "urls_pieza_nro", ccsInteger, "", "", $this->Parameters["urls_pieza_nro"], "", false);
    $this->wp->AddParameter("7", "urls_pieza_letra", ccsText, "", "", $this->Parameters["urls_pieza_letra"], "", false);
    $this->wp->AddParameter("8", "urls_pieza_anio", ccsInteger, "", "", $this->Parameters["urls_pieza_anio"], "", false);
    $this->wp->AddParameter("9", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("10", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("11", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("12", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("13", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("14", "urls_texto", ccsMemo, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("15", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("16", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->wp->AddParameter("17", "urls_texto", ccsText, "", "", $this->Parameters["urls_texto"], "", false);
    $this->AllParametersSet = $this->wp->AllParamsSet();
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
    $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.des_unidad_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
    $this->wp->Criterion[4] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
    $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "piezas.pieza_archivada", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
    $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "piezas.pieza_nro", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
    $this->wp->Criterion[7] = $this->wp->Operation(opContains, "piezas.pieza_letra", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
    $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "piezas.pieza_anio", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsInteger),false);
    $this->wp->Criterion[9] = $this->wp->Operation(opContains, "piezas.pieza_letra", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsText),false);
    $this->wp->Criterion[10] = $this->wp->Operation(opContains, "piezas.pieza_iniciador", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsText),false);
    $this->wp->Criterion[11] = $this->wp->Operation(opContains, "piezas.pieza_descripcion", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText),false);
    $this->wp->Criterion[12] = $this->wp->Operation(opContains, "piezas.pieza_observaciones", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText),false);
    $this->wp->Criterion[13] = $this->wp->Operation(opContains, "piezas.pieza_ref", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsText),false);
    $this->wp->Criterion[14] = $this->wp->Operation(opContains, "piezas.pieza_txt", $this->wp->GetDBValue("14"), $this->ToSQL($this->wp->GetDBValue("14"), ccsMemo),false);
    $this->wp->Criterion[15] = $this->wp->Operation(opContains, "piezas.pieza_destinatario", $this->wp->GetDBValue("15"), $this->ToSQL($this->wp->GetDBValue("15"), ccsText),false);
    $this->wp->Criterion[16] = $this->wp->Operation(opEqual, "piezas.pieza_of_destinatario", $this->wp->GetDBValue("16"), $this->ToSQL($this->wp->GetDBValue("16"), ccsText),false);
    $this->wp->Criterion[17] = $this->wp->Operation(opContains, "piezas.pieza_autor", $this->wp->GetDBValue("17"), $this->ToSQL($this->wp->GetDBValue("17"), ccsText),false);
    $this->Where = $this->wp->opAND(
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
       $this->wp->Criterion[8]), $this->wp->opOR(
       true, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, $this->wp->opOR(
       false, 
       $this->wp->Criterion[9], 
       $this->wp->Criterion[10]), 
       $this->wp->Criterion[11]), 
       $this->wp->Criterion[12]), 
       $this->wp->Criterion[13]), 
       $this->wp->Criterion[14]), 
       $this->wp->Criterion[15]), 
       $this->wp->Criterion[16]), 
       $this->wp->Criterion[17]));
  }
//End Prepare Method

//Open Method @2-77270EC6
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM ((piezas INNER JOIN pases ON\n\n" .
    "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
    "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
    "piezas.pieza_id = adjuntos.adj_pieza_id";
    $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
    "pase_n_fojas, pieza_f_alta, pieza_archivo \n\n" .
    "FROM ((piezas INNER JOIN pases ON\n\n" .
    "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
    "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
    "piezas.pieza_id = adjuntos.adj_pieza_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @2-33C22385
  function SetValues()
  {
    $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
    $this->CachedColumns["pase_id"] = $this->f("pase_id");
    $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
    $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
    $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
    $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
    $this->pieza->SetDBValue($this->f("pieza"));
    $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
    $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
    $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
    $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
    $this->pieza_archivo->SetDBValue($this->f("pieza_archivo"));
  }
//End SetValues Method

} //End areaDataSource Class @2-FCB6E20C



//Initialize Page @1-C28B94C4
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
$TemplateFileName = "msa_archivo.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-63FBFB96
include_once("./msa_archivo_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C748A3DE
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
$area1 = new clsRecordarea1("", $MainPage);
$area = new clsEditableGridarea("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->area1 = & $area1;
$MainPage->area = & $area;
$area->Initialize();

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

//Execute Components @1-C1572E78
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$area1->Operation();
$area->Operation();
//End Execute Components

//Go to destination page @1-6B87C728
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
  unset($area1);
  unset($area);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-8954E5D1
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$area1->Show();
$area->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>G&#101;n&#101;r&#97;t&#101;d <!-- SCC -->&#119;i&#116;h <!-- CCS -->&#67;ode&#67;ha&#114;&#103;&#101; <!-- CCS -->&#83;tudio.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>G&#101;n&#101;r&#97;t&#101;d <!-- SCC -->&#119;i&#116;h <!-- CCS -->&#67;ode&#67;ha&#114;&#103;&#101; <!-- CCS -->&#83;tudio.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= "<center><font face=\"Arial\"><small>G&#101;n&#101;r&#97;t&#101;d <!-- SCC -->&#119;i&#116;h <!-- CCS -->&#67;ode&#67;ha&#114;&#103;&#101; <!-- CCS -->&#83;tudio.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-873880EE
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($area1);
unset($area);
unset($Tpl);
//End Unload Page


?>
