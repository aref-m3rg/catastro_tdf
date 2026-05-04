<?php
//Include Common Files @1-E1E9D2AB
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "inscdominio.php");
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

class clsRecordparcelas { //parcelas Class @6-F41C09A9

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

//Class_Initialize Event @6-DF66A221
  function clsRecordparcelas($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record parcelas/Error";
    $this->ReadAllowed = true;
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
    if($this->Visible)
    {
      $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
      $this->ComponentName = "parcelas";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->cant = new clsControl(ccsTextBox, "cant", "Cantidad", ccsInteger, "", CCGetRequestParam("cant", $Method, NULL), $this);
      $this->cant->Required = true;
      $this->Button1 = new clsButton("Button1", $Method, $this);
      $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
    }
  }
//End Class_Initialize Event

//Validate Method @6-C0586257
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->cant->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->cant->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @6-69EBA00B
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->cant->Errors->Count());
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

//Operation Method @6-42130BFD
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
      $this->PressedButton = "Button1";
      if($this->Button1->Pressed) {
        $this->PressedButton = "Button1";
      } else if($this->Button_DoSearch->Pressed) {
        $this->PressedButton = "Button_DoSearch";
      }
    }
    $Redirect = "inscdominio.php";
    if($this->PressedButton == "Button1") {
      $Redirect = "recordParcela.php";
      if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_DoSearch") {
        if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
          $Redirect = "";
        }
      }
    } else {
      $Redirect = "";
    }
  }
//End Operation Method

//Show Method @6-853C0A45
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
      $Error = ComposeStrings($Error, $this->cant->Errors->ToString());
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

    $this->cant->Show();
    $this->Button1->Show();
    $this->Button_DoSearch->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
  }
//End Show Method

} //End parcelas Class @6-FCB6E20C

//Include Page implementation @9-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

class clsEditableGridtmp_dominio { //tmp_dominio Class @13-D0820714

//Variables @13-19977926

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
  public $Sorter_tipo_depto_parc_id;
  public $Sorter_tipo_padron_parc_id;
  public $Sorter_parcela_seccion;
  public $Sorter_parcela_macizo;
  public $Sorter_parcela_parcela;
  public $Sorter_parcela_chacra;
  public $Sorter_parcela_quinta;
  public $Sorter_parcela_fraccion;
  public $Sorter_parcela_uf;
  public $Sorter_parcela_mzna;
  public $Sorter_parcela_lote;
  public $Sorter_tipo_parcela_partida;
  public $Sorter_parcela_instrumento;
  public $Sorter_tipo_instrumento_id;
//End Variables

//Class_Initialize Event @13-875DE2E7
  function clsEditableGridtmp_dominio($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "EditableGrid tmp_dominio/Error";
    $this->ControlsErrors = array();
    $this->ComponentName = "tmp_dominio";
    $this->Attributes = new clsAttributes($this->ComponentName . ":");
    $this->CachedColumns["parcela_id"][0] = "parcela_id";
    $this->CachedColumns["tmp_dominio_id"][0] = "tmp_dominio_id";
    $this->DataSource = new clstmp_dominioDataSource($this);
    $this->ds = & $this->DataSource;
    $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
    if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
      $this->PageSize = 50;
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
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
    if(!$this->Visible) return;

    $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
    $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "1;2");
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

    $this->SorterName = CCGetParam("tmp_dominioOrder", "");
    $this->SorterDirection = CCGetParam("tmp_dominioDir", "");

    $this->Sorter_tipo_depto_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_depto_parc_id", $FileName, $this);
    $this->Sorter_tipo_padron_parc_id = new clsSorter($this->ComponentName, "Sorter_tipo_padron_parc_id", $FileName, $this);
    $this->Sorter_parcela_seccion = new clsSorter($this->ComponentName, "Sorter_parcela_seccion", $FileName, $this);
    $this->Sorter_parcela_macizo = new clsSorter($this->ComponentName, "Sorter_parcela_macizo", $FileName, $this);
    $this->Sorter_parcela_parcela = new clsSorter($this->ComponentName, "Sorter_parcela_parcela", $FileName, $this);
    $this->Sorter_parcela_chacra = new clsSorter($this->ComponentName, "Sorter_parcela_chacra", $FileName, $this);
    $this->Sorter_parcela_quinta = new clsSorter($this->ComponentName, "Sorter_parcela_quinta", $FileName, $this);
    $this->Sorter_parcela_fraccion = new clsSorter($this->ComponentName, "Sorter_parcela_fraccion", $FileName, $this);
    $this->Sorter_parcela_uf = new clsSorter($this->ComponentName, "Sorter_parcela_uf", $FileName, $this);
    $this->Sorter_parcela_mzna = new clsSorter($this->ComponentName, "Sorter_parcela_mzna", $FileName, $this);
    $this->Sorter_parcela_lote = new clsSorter($this->ComponentName, "Sorter_parcela_lote", $FileName, $this);
    $this->tipo_depto_parc_id = new clsControl(ccsListBox, "tipo_depto_parc_id", "Departamento", ccsInteger, "", NULL, $this);
    $this->tipo_depto_parc_id->DSType = dsTable;
    $this->tipo_depto_parc_id->DataSource = new clsDBtdf_nuevo();
    $this->tipo_depto_parc_id->ds = & $this->tipo_depto_parc_id->DataSource;
    $this->tipo_depto_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_deptos_parcela {SQL_Where} {SQL_OrderBy}";
    list($this->tipo_depto_parc_id->BoundColumn, $this->tipo_depto_parc_id->TextColumn, $this->tipo_depto_parc_id->DBFormat) = array("tipo_depto_parc_id", "tipo_depto_parc_desc", "");
    $this->tipo_depto_parc_id->Required = true;
    $this->tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "Padron", ccsInteger, "", NULL, $this);
    $this->tipo_padron_parc_id->DSType = dsTable;
    $this->tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
    $this->tipo_padron_parc_id->ds = & $this->tipo_padron_parc_id->DataSource;
    $this->tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
    list($this->tipo_padron_parc_id->BoundColumn, $this->tipo_padron_parc_id->TextColumn, $this->tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
    $this->tipo_padron_parc_id->Required = true;
    $this->parcela_seccion = new clsControl(ccsTextBox, "parcela_seccion", "Seccion", ccsText, "", NULL, $this);
    $this->parcela_macizo = new clsControl(ccsTextBox, "parcela_macizo", "Macizo", ccsText, "", NULL, $this);
    $this->parcela_parcela = new clsControl(ccsTextBox, "parcela_parcela", "Parcela", ccsText, "", NULL, $this);
    $this->parcela_chacra = new clsControl(ccsTextBox, "parcela_chacra", "Chacra", ccsText, "", NULL, $this);
    $this->parcela_quinta = new clsControl(ccsTextBox, "parcela_quinta", "Quinta", ccsText, "", NULL, $this);
    $this->parcela_fraccion = new clsControl(ccsTextBox, "parcela_fraccion", "Fraccion", ccsText, "", NULL, $this);
    $this->parcela_uf = new clsControl(ccsTextBox, "parcela_uf", "Uf", ccsText, "", NULL, $this);
    $this->parcela_mzna = new clsControl(ccsTextBox, "parcela_mzna", "Mzna", ccsText, "", NULL, $this);
    $this->parcela_lote = new clsControl(ccsTextBox, "parcela_lote", "lote", ccsText, "", NULL, $this);
    $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
    $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
    $this->macizo = new clsControl(ccsTextBox, "macizo", "macizo", ccsText, "", NULL, $this);
    $this->parcela = new clsControl(ccsTextBox, "parcela", "parcela", ccsText, "", NULL, $this);
    $this->chacra = new clsControl(ccsTextBox, "chacra", "chacra", ccsText, "", NULL, $this);
    $this->quinta = new clsControl(ccsTextBox, "quinta", "quinta", ccsText, "", NULL, $this);
    $this->fraccion = new clsControl(ccsTextBox, "fraccion", "fraccion", ccsText, "", NULL, $this);
    $this->uf = new clsControl(ccsTextBox, "uf", "uf", ccsText, "", NULL, $this);
    $this->mzna = new clsControl(ccsTextBox, "mzna", "mzna", ccsText, "", NULL, $this);
    $this->lote = new clsControl(ccsTextBox, "lote", "lote", ccsText, "", NULL, $this);
    $this->aplicar = new clsButton("aplicar", $Method, $this);
    $this->increment = new clsButton("increment", $Method, $this);
    $this->partida = new clsControl(ccsTextBox, "partida", "partida", ccsText, "", NULL, $this);
    $this->copia = new clsButton("copia", $Method, $this);
    $this->check = new clsControl(ccsHidden, "check", "check", ccsInteger, "", NULL, $this);
    $this->cant = new clsControl(ccsHidden, "cant", "cant", ccsText, "", NULL, $this);
    $this->deshacer = new clsButton("deshacer", $Method, $this);
    $this->Sorter_tipo_parcela_partida = new clsSorter($this->ComponentName, "Sorter_tipo_parcela_partida", $FileName, $this);
    $this->parcela_partida = new clsControl(ccsTextBox, "parcela_partida", "Partida", ccsInteger, "", NULL, $this);
    $this->parcela_partida->Required = true;
    $this->Sorter_parcela_instrumento = new clsSorter($this->ComponentName, "Sorter_parcela_instrumento", $FileName, $this);
    $this->Sorter_tipo_instrumento_id = new clsSorter($this->ComponentName, "Sorter_tipo_instrumento_id", $FileName, $this);
    $this->parcela_instrumento_grid = new clsControl(ccsTextBox, "parcela_instrumento_grid", "parcela_instrumento_grid", ccsText, "", NULL, $this);
    $this->parcela_instrumento_grid->Required = true;
    $this->tipo_instrumento_id_grid = new clsControl(ccsListBox, "tipo_instrumento_id_grid", "tipo_instrumento_id_grid", ccsInteger, "", NULL, $this);
    $this->tipo_instrumento_id_grid->DSType = dsTable;
    $this->tipo_instrumento_id_grid->DataSource = new clsDBtdf_nuevo();
    $this->tipo_instrumento_id_grid->ds = & $this->tipo_instrumento_id_grid->DataSource;
    $this->tipo_instrumento_id_grid->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
    list($this->tipo_instrumento_id_grid->BoundColumn, $this->tipo_instrumento_id_grid->TextColumn, $this->tipo_instrumento_id_grid->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
    $this->tipo_instrumento_id_grid->Required = true;
    $this->seccion = new clsControl(ccsTextBox, "seccion", "seccion", ccsText, "", NULL, $this);
    $this->parcela_instrumento = new clsControl(ccsTextBox, "parcela_instrumento", "parcela_instrumento", ccsText, "", NULL, $this);
    $this->tipo_instrumento_id = new clsControl(ccsListBox, "tipo_instrumento_id", "tipo_instrumento_id", ccsInteger, "", NULL, $this);
    $this->tipo_instrumento_id->DSType = dsTable;
    $this->tipo_instrumento_id->DataSource = new clsDBtdf_nuevo();
    $this->tipo_instrumento_id->ds = & $this->tipo_instrumento_id->DataSource;
    $this->tipo_instrumento_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_instrumentos {SQL_Where} {SQL_OrderBy}";
    list($this->tipo_instrumento_id->BoundColumn, $this->tipo_instrumento_id->TextColumn, $this->tipo_instrumento_id->DBFormat) = array("tipo_instrumento_id", "tipo_instrumento_descrip", "");
    $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", NULL, $this);
    $this->Label1->HTML = true;
    $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", NULL, $this);
    $this->Label2->HTML = true;
  }
//End Class_Initialize Event

//Initialize Method @13-99529F7C
  function Initialize()
  {
    if(!$this->Visible) return;

    $this->DataSource->PageSize = & $this->PageSize;
    $this->DataSource->AbsolutePage = & $this->PageNumber;
    $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

    $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
  }
//End Initialize Method

//SetPrimaryKeys Method @13-EBC3F86C
  function SetPrimaryKeys($PrimaryKeys) {
    $this->PrimaryKeys = $PrimaryKeys;
    return $this->PrimaryKeys;
  }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @13-74F9A772
  function GetPrimaryKeys() {
    return $this->PrimaryKeys;
  }
//End GetPrimaryKeys Method

//GetFormParameters Method @13-A2B3FFEE
  function GetFormParameters()
  {
    for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
    {
      $this->FormParameters["tipo_depto_parc_id"][$RowNumber] = CCGetFromPost("tipo_depto_parc_id_" . $RowNumber, NULL);
      $this->FormParameters["tipo_padron_parc_id"][$RowNumber] = CCGetFromPost("tipo_padron_parc_id_" . $RowNumber, NULL);
      $this->FormParameters["parcela_seccion"][$RowNumber] = CCGetFromPost("parcela_seccion_" . $RowNumber, NULL);
      $this->FormParameters["parcela_macizo"][$RowNumber] = CCGetFromPost("parcela_macizo_" . $RowNumber, NULL);
      $this->FormParameters["parcela_parcela"][$RowNumber] = CCGetFromPost("parcela_parcela_" . $RowNumber, NULL);
      $this->FormParameters["parcela_chacra"][$RowNumber] = CCGetFromPost("parcela_chacra_" . $RowNumber, NULL);
      $this->FormParameters["parcela_quinta"][$RowNumber] = CCGetFromPost("parcela_quinta_" . $RowNumber, NULL);
      $this->FormParameters["parcela_fraccion"][$RowNumber] = CCGetFromPost("parcela_fraccion_" . $RowNumber, NULL);
      $this->FormParameters["parcela_uf"][$RowNumber] = CCGetFromPost("parcela_uf_" . $RowNumber, NULL);
      $this->FormParameters["parcela_mzna"][$RowNumber] = CCGetFromPost("parcela_mzna_" . $RowNumber, NULL);
      $this->FormParameters["parcela_lote"][$RowNumber] = CCGetFromPost("parcela_lote_" . $RowNumber, NULL);
      $this->FormParameters["parcela_partida"][$RowNumber] = CCGetFromPost("parcela_partida_" . $RowNumber, NULL);
      $this->FormParameters["parcela_instrumento_grid"][$RowNumber] = CCGetFromPost("parcela_instrumento_grid_" . $RowNumber, NULL);
      $this->FormParameters["tipo_instrumento_id_grid"][$RowNumber] = CCGetFromPost("tipo_instrumento_id_grid_" . $RowNumber, NULL);
    }
  }
//End GetFormParameters Method

//Validate Method @13-4347D6B6
  function Validate()
  {
    $Validation = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

    for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
    {
      $this->DataSource->CachedColumns["parcela_id"] = $this->CachedColumns["parcela_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["tmp_dominio_id"] = $this->CachedColumns["tmp_dominio_id"][$this->RowNumber];
      $this->DataSource->CurrentRow = $this->RowNumber;
      $this->tipo_depto_parc_id->SetText($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber], $this->RowNumber);
      $this->tipo_padron_parc_id->SetText($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber], $this->RowNumber);
      $this->parcela_seccion->SetText($this->FormParameters["parcela_seccion"][$this->RowNumber], $this->RowNumber);
      $this->parcela_macizo->SetText($this->FormParameters["parcela_macizo"][$this->RowNumber], $this->RowNumber);
      $this->parcela_parcela->SetText($this->FormParameters["parcela_parcela"][$this->RowNumber], $this->RowNumber);
      $this->parcela_chacra->SetText($this->FormParameters["parcela_chacra"][$this->RowNumber], $this->RowNumber);
      $this->parcela_quinta->SetText($this->FormParameters["parcela_quinta"][$this->RowNumber], $this->RowNumber);
      $this->parcela_fraccion->SetText($this->FormParameters["parcela_fraccion"][$this->RowNumber], $this->RowNumber);
      $this->parcela_uf->SetText($this->FormParameters["parcela_uf"][$this->RowNumber], $this->RowNumber);
      $this->parcela_mzna->SetText($this->FormParameters["parcela_mzna"][$this->RowNumber], $this->RowNumber);
      $this->parcela_lote->SetText($this->FormParameters["parcela_lote"][$this->RowNumber], $this->RowNumber);
      $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
      $this->parcela_instrumento_grid->SetText($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber], $this->RowNumber);
      $this->tipo_instrumento_id_grid->SetText($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @13-39068D0B
  function ValidateRow()
  {
    global $CCSLocales;
    $this->tipo_depto_parc_id->Validate();
    $this->tipo_padron_parc_id->Validate();
    $this->parcela_seccion->Validate();
    $this->parcela_macizo->Validate();
    $this->parcela_parcela->Validate();
    $this->parcela_chacra->Validate();
    $this->parcela_quinta->Validate();
    $this->parcela_fraccion->Validate();
    $this->parcela_uf->Validate();
    $this->parcela_mzna->Validate();
    $this->parcela_lote->Validate();
    $this->parcela_partida->Validate();
    $this->parcela_instrumento_grid->Validate();
    $this->tipo_instrumento_id_grid->Validate();
    $this->RowErrors = new clsErrors();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
    $errors = "";
    $errors = ComposeStrings($errors, $this->tipo_depto_parc_id->Errors->ToString());
    $errors = ComposeStrings($errors, $this->tipo_padron_parc_id->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_seccion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_macizo->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_parcela->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_chacra->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_quinta->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_fraccion->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_uf->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_mzna->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_lote->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_partida->Errors->ToString());
    $errors = ComposeStrings($errors, $this->parcela_instrumento_grid->Errors->ToString());
    $errors = ComposeStrings($errors, $this->tipo_instrumento_id_grid->Errors->ToString());
    $this->tipo_depto_parc_id->Errors->Clear();
    $this->tipo_padron_parc_id->Errors->Clear();
    $this->parcela_seccion->Errors->Clear();
    $this->parcela_macizo->Errors->Clear();
    $this->parcela_parcela->Errors->Clear();
    $this->parcela_chacra->Errors->Clear();
    $this->parcela_quinta->Errors->Clear();
    $this->parcela_fraccion->Errors->Clear();
    $this->parcela_uf->Errors->Clear();
    $this->parcela_mzna->Errors->Clear();
    $this->parcela_lote->Errors->Clear();
    $this->parcela_partida->Errors->Clear();
    $this->parcela_instrumento_grid->Errors->Clear();
    $this->tipo_instrumento_id_grid->Errors->Clear();
    $errors = ComposeStrings($errors, $this->RowErrors->ToString());
    $this->RowsErrors[$this->RowNumber] = $errors;
    return $errors != "" ? 0 : 1;
  }
//End ValidateRow Method

//CheckInsert Method @13-36C7888E
  function CheckInsert()
  {
    $filed = false;
    $filed = ($filed || (is_array($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber]) && count($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber])) || strlen($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber]) && count($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber])) || strlen($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_seccion"][$this->RowNumber]) && count($this->FormParameters["parcela_seccion"][$this->RowNumber])) || strlen($this->FormParameters["parcela_seccion"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_macizo"][$this->RowNumber]) && count($this->FormParameters["parcela_macizo"][$this->RowNumber])) || strlen($this->FormParameters["parcela_macizo"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_parcela"][$this->RowNumber]) && count($this->FormParameters["parcela_parcela"][$this->RowNumber])) || strlen($this->FormParameters["parcela_parcela"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_chacra"][$this->RowNumber]) && count($this->FormParameters["parcela_chacra"][$this->RowNumber])) || strlen($this->FormParameters["parcela_chacra"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_quinta"][$this->RowNumber]) && count($this->FormParameters["parcela_quinta"][$this->RowNumber])) || strlen($this->FormParameters["parcela_quinta"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_fraccion"][$this->RowNumber]) && count($this->FormParameters["parcela_fraccion"][$this->RowNumber])) || strlen($this->FormParameters["parcela_fraccion"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_uf"][$this->RowNumber]) && count($this->FormParameters["parcela_uf"][$this->RowNumber])) || strlen($this->FormParameters["parcela_uf"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_mzna"][$this->RowNumber]) && count($this->FormParameters["parcela_mzna"][$this->RowNumber])) || strlen($this->FormParameters["parcela_mzna"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_lote"][$this->RowNumber]) && count($this->FormParameters["parcela_lote"][$this->RowNumber])) || strlen($this->FormParameters["parcela_lote"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_partida"][$this->RowNumber]) && count($this->FormParameters["parcela_partida"][$this->RowNumber])) || strlen($this->FormParameters["parcela_partida"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber]) && count($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber])) || strlen($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber]));
    $filed = ($filed || (is_array($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber]) && count($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber])) || strlen($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber]));
    return $filed;
  }
//End CheckInsert Method

//CheckErrors Method @13-F5A3B433
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->Errors->Count());
    $errors = ($errors || $this->DataSource->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//Operation Method @13-DDFBCD95
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
    $this->PressedButton = "Button_Submit";
    if($this->Button_Submit->Pressed) {
      $this->PressedButton = "Button_Submit";
    } else if($this->aplicar->Pressed) {
      $this->PressedButton = "aplicar";
    } else if($this->increment->Pressed) {
      $this->PressedButton = "increment";
    } else if($this->copia->Pressed) {
      $this->PressedButton = "copia";
    } else if($this->deshacer->Pressed) {
      $this->PressedButton = "deshacer";
    }

    $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if($this->PressedButton == "Button_Submit") {
      if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
        $Redirect = "";
      }
    } else if($this->PressedButton == "aplicar") {
      if(!CCGetEvent($this->aplicar->CCSEvents, "OnClick", $this->aplicar)) {
        $Redirect = "";
      }
    } else if($this->PressedButton == "increment") {
      if(!CCGetEvent($this->increment->CCSEvents, "OnClick", $this->increment)) {
        $Redirect = "";
      }
    } else if($this->PressedButton == "copia") {
      if(!CCGetEvent($this->copia->CCSEvents, "OnClick", $this->copia)) {
        $Redirect = "";
      }
    } else if($this->PressedButton == "deshacer") {
      if(!CCGetEvent($this->deshacer->CCSEvents, "OnClick", $this->deshacer)) {
        $Redirect = "";
      }
    } else {
      $Redirect = "";
    }
    if ($Redirect)
      $this->DataSource->close();
  }
//End Operation Method

//UpdateGrid Method @13-8D80177B
  function UpdateGrid()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
    if(!$this->Validate()) return;
    $Validation = true;
    for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
    {
      $this->DataSource->CachedColumns["parcela_id"] = $this->CachedColumns["parcela_id"][$this->RowNumber];
      $this->DataSource->CachedColumns["tmp_dominio_id"] = $this->CachedColumns["tmp_dominio_id"][$this->RowNumber];
      $this->DataSource->CurrentRow = $this->RowNumber;
      $this->tipo_depto_parc_id->SetText($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber], $this->RowNumber);
      $this->tipo_padron_parc_id->SetText($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber], $this->RowNumber);
      $this->parcela_seccion->SetText($this->FormParameters["parcela_seccion"][$this->RowNumber], $this->RowNumber);
      $this->parcela_macizo->SetText($this->FormParameters["parcela_macizo"][$this->RowNumber], $this->RowNumber);
      $this->parcela_parcela->SetText($this->FormParameters["parcela_parcela"][$this->RowNumber], $this->RowNumber);
      $this->parcela_chacra->SetText($this->FormParameters["parcela_chacra"][$this->RowNumber], $this->RowNumber);
      $this->parcela_quinta->SetText($this->FormParameters["parcela_quinta"][$this->RowNumber], $this->RowNumber);
      $this->parcela_fraccion->SetText($this->FormParameters["parcela_fraccion"][$this->RowNumber], $this->RowNumber);
      $this->parcela_uf->SetText($this->FormParameters["parcela_uf"][$this->RowNumber], $this->RowNumber);
      $this->parcela_mzna->SetText($this->FormParameters["parcela_mzna"][$this->RowNumber], $this->RowNumber);
      $this->parcela_lote->SetText($this->FormParameters["parcela_lote"][$this->RowNumber], $this->RowNumber);
      $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
      $this->parcela_instrumento_grid->SetText($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber], $this->RowNumber);
      $this->tipo_instrumento_id_grid->SetText($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber], $this->RowNumber);
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

//UpdateRow Method @13-2ADB6248
  function UpdateRow()
  {
    if(!$this->UpdateAllowed) return false;
    $this->DataSource->tipo_depto_parc_id->SetValue($this->tipo_depto_parc_id->GetValue(true));
    $this->DataSource->tipo_padron_parc_id->SetValue($this->tipo_padron_parc_id->GetValue(true));
    $this->DataSource->parcela_seccion->SetValue($this->parcela_seccion->GetValue(true));
    $this->DataSource->parcela_macizo->SetValue($this->parcela_macizo->GetValue(true));
    $this->DataSource->parcela_parcela->SetValue($this->parcela_parcela->GetValue(true));
    $this->DataSource->parcela_chacra->SetValue($this->parcela_chacra->GetValue(true));
    $this->DataSource->parcela_quinta->SetValue($this->parcela_quinta->GetValue(true));
    $this->DataSource->parcela_fraccion->SetValue($this->parcela_fraccion->GetValue(true));
    $this->DataSource->parcela_uf->SetValue($this->parcela_uf->GetValue(true));
    $this->DataSource->parcela_mzna->SetValue($this->parcela_mzna->GetValue(true));
    $this->DataSource->parcela_lote->SetValue($this->parcela_lote->GetValue(true));
    $this->DataSource->parcela_partida->SetValue($this->parcela_partida->GetValue(true));
    $this->DataSource->parcela_instrumento_grid->SetValue($this->parcela_instrumento_grid->GetValue(true));
    $this->DataSource->tipo_instrumento_id_grid->SetValue($this->tipo_instrumento_id_grid->GetValue(true));
    $this->DataSource->Update();
    $errors = "";
    if($this->DataSource->Errors->Count() > 0) {
      $errors = $this->DataSource->Errors->ToString();
      $this->RowsErrors[$this->RowNumber] = $errors;
      $this->DataSource->Errors->Clear();
    }
    return (($this->Errors->Count() == 0) && !strlen($errors));
  }
//End UpdateRow Method

//FormScript Method @13-CC6B733A
  function FormScript($TotalRows)
  {
    $script = "";
    $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
    $script .= "var tmp_dominioElements;\n";
    $script .= "var tmp_dominioEmptyRows = 0;\n";
    $script .= "var " . $this->ComponentName . "tipo_depto_parc_idID = 0;\n";
    $script .= "var " . $this->ComponentName . "tipo_padron_parc_idID = 1;\n";
    $script .= "var " . $this->ComponentName . "parcela_seccionID = 2;\n";
    $script .= "var " . $this->ComponentName . "parcela_macizoID = 3;\n";
    $script .= "var " . $this->ComponentName . "parcela_parcelaID = 4;\n";
    $script .= "var " . $this->ComponentName . "parcela_chacraID = 5;\n";
    $script .= "var " . $this->ComponentName . "parcela_quintaID = 6;\n";
    $script .= "var " . $this->ComponentName . "parcela_fraccionID = 7;\n";
    $script .= "var " . $this->ComponentName . "parcela_ufID = 8;\n";
    $script .= "var " . $this->ComponentName . "parcela_mznaID = 9;\n";
    $script .= "var " . $this->ComponentName . "parcela_loteID = 10;\n";
    $script .= "var " . $this->ComponentName . "parcela_partidaID = 11;\n";
    $script .= "var " . $this->ComponentName . "parcela_instrumento_gridID = 12;\n";
    $script .= "var " . $this->ComponentName . "tipo_instrumento_id_gridID = 13;\n";
    $script .= "\nfunction inittmp_dominioElements() {\n";
    $script .= "\tvar ED = document.forms[\"tmp_dominio\"];\n";
    $script .= "\ttmp_dominioElements = new Array (\n";
    for($i = 1; $i <= $TotalRows; $i++) {
      $script .= "\t\tnew Array(" . "ED.tipo_depto_parc_id_" . $i . ", " . "ED.tipo_padron_parc_id_" . $i . ", " . "ED.parcela_seccion_" . $i . ", " . "ED.parcela_macizo_" . $i . ", " . "ED.parcela_parcela_" . $i . ", " . "ED.parcela_chacra_" . $i . ", " . "ED.parcela_quinta_" . $i . ", " . "ED.parcela_fraccion_" . $i . ", " . "ED.parcela_uf_" . $i . ", " . "ED.parcela_mzna_" . $i . ", " . "ED.parcela_lote_" . $i . ", " . "ED.parcela_partida_" . $i . ", " . "ED.parcela_instrumento_grid_" . $i . ", " . "ED.tipo_instrumento_id_grid_" . $i . ")";
      if($i != $TotalRows) $script .= ",\n";
    }
    $script .= ");\n";
    $script .= "}\n";
    $script .= "\n//-->\n</script>";
    return $script;
  }
//End FormScript Method

//SetFormState Method @13-5201E41E
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
      for($i = 2; $i < sizeof($pieces); $i = $i + 2)  {
        $piece = $pieces[$i + 0];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["parcela_id"][$RowNumber] = $piece;
        $piece = $pieces[$i + 1];
        $piece = str_replace("\\" . ord("\\"), "\\", $piece);
        $piece = str_replace("\\" . ord(";"), ";", $piece);
        $this->CachedColumns["tmp_dominio_id"][$RowNumber] = $piece;
        $RowNumber++;
      }

      if(!$RowNumber) { $RowNumber = 1; }
      for($i = 1; $i <= $this->EmptyRows; $i++) {
        $this->CachedColumns["parcela_id"][$RowNumber] = "";
        $this->CachedColumns["tmp_dominio_id"][$RowNumber] = "";
        $RowNumber++;
      }
    }
  }
//End SetFormState Method

//GetFormState Method @13-593329A0
  function GetFormState($NonEmptyRows)
  {
    if(!$this->FormSubmitted) {
      $this->FormState  = $NonEmptyRows . ";";
      $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
      if($NonEmptyRows) {
        for($i = 0; $i <= $NonEmptyRows; $i++) {
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["parcela_id"][$i]));
          $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tmp_dominio_id"][$i]));
        }
      }
    }
    return $this->FormState;
  }
//End GetFormState Method

//Show Method @13-CEBFD288
  function Show()
  {
    global $Tpl;
    global $FileName;
    global $CCSLocales;
    global $CCSUseAmp;
    $Error = "";

    if(!$this->Visible) { return; }

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

    $this->tipo_depto_parc_id->Prepare();
    $this->tipo_padron_parc_id->Prepare();
    $this->tipo_instrumento_id_grid->Prepare();
    $this->tipo_instrumento_id->Prepare();

    $this->DataSource->open();
    $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
    $this->IsEmpty = ! $is_next_record;

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if(!$this->Visible) { return; }

    $this->Attributes->Show();
    $this->Button_Submit->Visible = $this->Button_Submit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
    $ParentPath = $Tpl->block_path;
    $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
    $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
    $Tpl->block_path = $EditableGridRowPath;
    $this->RowNumber = 0;
    $NonEmptyRows = 0;
    $EmptyRowsLeft = $this->EmptyRows;
    $this->ControlsVisible["tipo_depto_parc_id"] = $this->tipo_depto_parc_id->Visible;
    $this->ControlsVisible["tipo_padron_parc_id"] = $this->tipo_padron_parc_id->Visible;
    $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
    $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
    $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
    $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
    $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
    $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
    $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
    $this->ControlsVisible["parcela_mzna"] = $this->parcela_mzna->Visible;
    $this->ControlsVisible["parcela_lote"] = $this->parcela_lote->Visible;
    $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
    $this->ControlsVisible["parcela_instrumento_grid"] = $this->parcela_instrumento_grid->Visible;
    $this->ControlsVisible["tipo_instrumento_id_grid"] = $this->tipo_instrumento_id_grid->Visible;
    if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
      do {
        $this->RowNumber++;
        if($is_next_record) {
          $NonEmptyRows++;
          $this->DataSource->SetValues();
        }
        if (!($this->FormSubmitted) && $is_next_record) {
          $this->CachedColumns["parcela_id"][$this->RowNumber] = $this->DataSource->CachedColumns["parcela_id"];
          $this->CachedColumns["tmp_dominio_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tmp_dominio_id"];
          $this->tipo_depto_parc_id->SetValue($this->DataSource->tipo_depto_parc_id->GetValue());
          $this->tipo_padron_parc_id->SetValue($this->DataSource->tipo_padron_parc_id->GetValue());
          $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
          $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
          $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
          $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
          $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
          $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
          $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
          $this->parcela_mzna->SetValue($this->DataSource->parcela_mzna->GetValue());
          $this->parcela_lote->SetValue($this->DataSource->parcela_lote->GetValue());
          $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
          $this->parcela_instrumento_grid->SetValue($this->DataSource->parcela_instrumento_grid->GetValue());
          $this->tipo_instrumento_id_grid->SetValue($this->DataSource->tipo_instrumento_id_grid->GetValue());
        } elseif ($this->FormSubmitted && $is_next_record) {
          $this->tipo_depto_parc_id->SetText($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber], $this->RowNumber);
          $this->tipo_padron_parc_id->SetText($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber], $this->RowNumber);
          $this->parcela_seccion->SetText($this->FormParameters["parcela_seccion"][$this->RowNumber], $this->RowNumber);
          $this->parcela_macizo->SetText($this->FormParameters["parcela_macizo"][$this->RowNumber], $this->RowNumber);
          $this->parcela_parcela->SetText($this->FormParameters["parcela_parcela"][$this->RowNumber], $this->RowNumber);
          $this->parcela_chacra->SetText($this->FormParameters["parcela_chacra"][$this->RowNumber], $this->RowNumber);
          $this->parcela_quinta->SetText($this->FormParameters["parcela_quinta"][$this->RowNumber], $this->RowNumber);
          $this->parcela_fraccion->SetText($this->FormParameters["parcela_fraccion"][$this->RowNumber], $this->RowNumber);
          $this->parcela_uf->SetText($this->FormParameters["parcela_uf"][$this->RowNumber], $this->RowNumber);
          $this->parcela_mzna->SetText($this->FormParameters["parcela_mzna"][$this->RowNumber], $this->RowNumber);
          $this->parcela_lote->SetText($this->FormParameters["parcela_lote"][$this->RowNumber], $this->RowNumber);
          $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
          $this->parcela_instrumento_grid->SetText($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber], $this->RowNumber);
          $this->tipo_instrumento_id_grid->SetText($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber], $this->RowNumber);
        } elseif (!$this->FormSubmitted) {
          $this->CachedColumns["parcela_id"][$this->RowNumber] = "";
          $this->CachedColumns["tmp_dominio_id"][$this->RowNumber] = "";
          $this->tipo_depto_parc_id->SetText("");
          $this->tipo_padron_parc_id->SetText("");
          $this->parcela_seccion->SetText("");
          $this->parcela_macizo->SetText("");
          $this->parcela_parcela->SetText("");
          $this->parcela_chacra->SetText("");
          $this->parcela_quinta->SetText("");
          $this->parcela_fraccion->SetText("");
          $this->parcela_uf->SetText("");
          $this->parcela_mzna->SetText("");
          $this->parcela_lote->SetText("");
          $this->parcela_partida->SetText("");
          $this->parcela_instrumento_grid->SetText("");
          $this->tipo_instrumento_id_grid->SetText("");
        } else {
          $this->tipo_depto_parc_id->SetText($this->FormParameters["tipo_depto_parc_id"][$this->RowNumber], $this->RowNumber);
          $this->tipo_padron_parc_id->SetText($this->FormParameters["tipo_padron_parc_id"][$this->RowNumber], $this->RowNumber);
          $this->parcela_seccion->SetText($this->FormParameters["parcela_seccion"][$this->RowNumber], $this->RowNumber);
          $this->parcela_macizo->SetText($this->FormParameters["parcela_macizo"][$this->RowNumber], $this->RowNumber);
          $this->parcela_parcela->SetText($this->FormParameters["parcela_parcela"][$this->RowNumber], $this->RowNumber);
          $this->parcela_chacra->SetText($this->FormParameters["parcela_chacra"][$this->RowNumber], $this->RowNumber);
          $this->parcela_quinta->SetText($this->FormParameters["parcela_quinta"][$this->RowNumber], $this->RowNumber);
          $this->parcela_fraccion->SetText($this->FormParameters["parcela_fraccion"][$this->RowNumber], $this->RowNumber);
          $this->parcela_uf->SetText($this->FormParameters["parcela_uf"][$this->RowNumber], $this->RowNumber);
          $this->parcela_mzna->SetText($this->FormParameters["parcela_mzna"][$this->RowNumber], $this->RowNumber);
          $this->parcela_lote->SetText($this->FormParameters["parcela_lote"][$this->RowNumber], $this->RowNumber);
          $this->parcela_partida->SetText($this->FormParameters["parcela_partida"][$this->RowNumber], $this->RowNumber);
          $this->parcela_instrumento_grid->SetText($this->FormParameters["parcela_instrumento_grid"][$this->RowNumber], $this->RowNumber);
          $this->tipo_instrumento_id_grid->SetText($this->FormParameters["tipo_instrumento_id_grid"][$this->RowNumber], $this->RowNumber);
        }
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        $this->Attributes->Show();
        $this->tipo_depto_parc_id->Show($this->RowNumber);
        $this->tipo_padron_parc_id->Show($this->RowNumber);
        $this->parcela_seccion->Show($this->RowNumber);
        $this->parcela_macizo->Show($this->RowNumber);
        $this->parcela_parcela->Show($this->RowNumber);
        $this->parcela_chacra->Show($this->RowNumber);
        $this->parcela_quinta->Show($this->RowNumber);
        $this->parcela_fraccion->Show($this->RowNumber);
        $this->parcela_uf->Show($this->RowNumber);
        $this->parcela_mzna->Show($this->RowNumber);
        $this->parcela_lote->Show($this->RowNumber);
        $this->parcela_partida->Show($this->RowNumber);
        $this->parcela_instrumento_grid->Show($this->RowNumber);
        $this->tipo_instrumento_id_grid->Show($this->RowNumber);
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
            if (($this->DataSource->CachedColumns["parcela_id"] == $this->CachedColumns["parcela_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tmp_dominio_id"] == $this->CachedColumns["tmp_dominio_id"][$this->RowNumber])) {
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
    if(!is_array($this->check->Value) && !strlen($this->check->Value) && $this->check->Value !== false)
      $this->check->SetText(1);
    $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
    $this->Navigator->PageSize = $this->PageSize;
    if ($this->DataSource->RecordsCount == "CCS not counted")
      $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
    else
      $this->Navigator->TotalPages = $this->DataSource->PageCount();
    if ($this->Navigator->TotalPages <= 1) {
      $this->Navigator->Visible = false;
    }
    $this->Sorter_tipo_depto_parc_id->Show();
    $this->Sorter_tipo_padron_parc_id->Show();
    $this->Sorter_parcela_seccion->Show();
    $this->Sorter_parcela_macizo->Show();
    $this->Sorter_parcela_parcela->Show();
    $this->Sorter_parcela_chacra->Show();
    $this->Sorter_parcela_quinta->Show();
    $this->Sorter_parcela_fraccion->Show();
    $this->Sorter_parcela_uf->Show();
    $this->Sorter_parcela_mzna->Show();
    $this->Sorter_parcela_lote->Show();
    $this->Navigator->Show();
    $this->Button_Submit->Show();
    $this->macizo->Show();
    $this->parcela->Show();
    $this->chacra->Show();
    $this->quinta->Show();
    $this->fraccion->Show();
    $this->uf->Show();
    $this->mzna->Show();
    $this->lote->Show();
    $this->aplicar->Show();
    $this->increment->Show();
    $this->partida->Show();
    $this->copia->Show();
    $this->check->Show();
    $this->cant->Show();
    $this->deshacer->Show();
    $this->Sorter_tipo_parcela_partida->Show();
    $this->Sorter_parcela_instrumento->Show();
    $this->Sorter_tipo_instrumento_id->Show();
    $this->seccion->Show();
    $this->parcela_instrumento->Show();
    $this->tipo_instrumento_id->Show();
    $this->Label1->Show();
    $this->Label2->Show();

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

} //End tmp_dominio Class @13-FCB6E20C

class clstmp_dominioDataSource extends clsDBtdf_nuevo {  //tmp_dominioDataSource Class @13-583427C9

//DataSource Variables @13-7BBEFA9A
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $UpdateParameters;
  public $CountSQL;
  public $wp;
  public $AllParametersSet;

  public $CachedColumns;
  public $CurrentRow;
  public $UpdateFields = array();

  // Datasource fields
  public $tipo_depto_parc_id;
  public $tipo_padron_parc_id;
  public $parcela_seccion;
  public $parcela_macizo;
  public $parcela_parcela;
  public $parcela_chacra;
  public $parcela_quinta;
  public $parcela_fraccion;
  public $parcela_uf;
  public $parcela_mzna;
  public $parcela_lote;
  public $parcela_partida;
  public $parcela_instrumento_grid;
  public $tipo_instrumento_id_grid;
//End DataSource Variables

//DataSourceClass_Initialize Event @13-EDB6E3CF
  function clstmp_dominioDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "EditableGrid tmp_dominio/Error";
    $this->Initialize();
    $this->tipo_depto_parc_id = new clsField("tipo_depto_parc_id", ccsInteger, "");
    
    $this->tipo_padron_parc_id = new clsField("tipo_padron_parc_id", ccsInteger, "");
    
    $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
    
    $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
    
    $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
    
    $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
    
    $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
    
    $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
    
    $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
    
    $this->parcela_mzna = new clsField("parcela_mzna", ccsText, "");
    
    $this->parcela_lote = new clsField("parcela_lote", ccsText, "");
    
    $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
    
    $this->parcela_instrumento_grid = new clsField("parcela_instrumento_grid", ccsText, "");
    
    $this->tipo_instrumento_id_grid = new clsField("tipo_instrumento_id_grid", ccsInteger, "");
    

    $this->UpdateFields["tipo_depto_parc_id"] = array("Name" => "tipo_depto_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_padron_parc_id"] = array("Name" => "tipo_padron_parc_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_seccion"] = array("Name" => "parcela_seccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_macizo"] = array("Name" => "parcela_macizo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_parcela"] = array("Name" => "parcela_parcela", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_chacra"] = array("Name" => "parcela_chacra", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_quinta"] = array("Name" => "parcela_quinta", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_fraccion"] = array("Name" => "parcela_fraccion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_uf"] = array("Name" => "parcela_uf", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_mzna"] = array("Name" => "parcela_mzna", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_lote"] = array("Name" => "parcela_lote", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_partida"] = array("Name" => "parcela_partida", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    $this->UpdateFields["parcela_instrumento"] = array("Name" => "parcela_instrumento", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    $this->UpdateFields["tipo_instrumento_id"] = array("Name" => "tipo_instrumento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
  }
//End DataSourceClass_Initialize Event

//SetOrder Method @13-491E2140
  function SetOrder($SorterName, $SorterDirection)
  {
    $this->Order = "tmp_dominio_id";
    $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
      array("Sorter_tipo_depto_parc_id" => array("tipo_depto_parc_id", ""), 
      "Sorter_tipo_padron_parc_id" => array("tipo_padron_parc_id", ""), 
      "Sorter_parcela_seccion" => array("parcela_seccion", ""), 
      "Sorter_parcela_macizo" => array("parcela_macizo", ""), 
      "Sorter_parcela_parcela" => array("parcela_parcela", ""), 
      "Sorter_parcela_chacra" => array("parcela_chacra", ""), 
      "Sorter_parcela_quinta" => array("parcela_quinta", ""), 
      "Sorter_parcela_fraccion" => array("parcela_fraccion", ""), 
      "Sorter_parcela_uf" => array("parcela_uf", ""), 
      "Sorter_parcela_mzna" => array("parcela_mzna", ""), 
      "Sorter_parcela_lote" => array("parcela_lote", ""), 
      "Sorter_tipo_parcela_partida" => array("parcela_partida", ""), 
      "Sorter_parcela_instrumento" => array("parcela_instrumento", ""), 
      "Sorter_tipo_instrumento_id" => array("tipo_instrumento_id", "")));
  }
//End SetOrder Method

//Prepare Method @13-CCE5C7B7
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
    $this->AllParametersSet = $this->wp->AllParamsSet();
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->Where = 
       $this->wp->Criterion[1];
  }
//End Prepare Method

//Open Method @13-980BF752
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->CountSQL = "SELECT COUNT(*)\n\n" .
    "FROM tmp_dominio";
    $this->SQL = "SELECT * \n\n" .
    "FROM tmp_dominio {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    if ($this->CountSQL) 
      $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
    else
      $this->RecordsCount = "CCS not counted";
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @13-C4BFC0DE
  function SetValues()
  {
    $this->CachedColumns["parcela_id"] = $this->f("parcela_id");
    $this->CachedColumns["tmp_dominio_id"] = $this->f("tmp_dominio_id");
    $this->tipo_depto_parc_id->SetDBValue(trim($this->f("tipo_depto_parc_id")));
    $this->tipo_padron_parc_id->SetDBValue(trim($this->f("tipo_padron_parc_id")));
    $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
    $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
    $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
    $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
    $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
    $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
    $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
    $this->parcela_mzna->SetDBValue($this->f("parcela_mzna"));
    $this->parcela_lote->SetDBValue($this->f("parcela_lote"));
    $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
    $this->parcela_instrumento_grid->SetDBValue($this->f("parcela_instrumento"));
    $this->tipo_instrumento_id_grid->SetDBValue(trim($this->f("tipo_instrumento_id")));
  }
//End SetValues Method

//Update Method @13-0338B084
  function Update()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
    $SelectWhere = $this->Where;
    $this->Where = "parcela_id=" . $this->ToSQL($this->CachedColumns["parcela_id"], ccsInteger) . " AND tmp_dominio_id=" . $this->ToSQL($this->CachedColumns["tmp_dominio_id"], ccsInteger);
    $this->UpdateFields["tipo_depto_parc_id"]["Value"] = $this->tipo_depto_parc_id->GetDBValue(true);
    $this->UpdateFields["tipo_padron_parc_id"]["Value"] = $this->tipo_padron_parc_id->GetDBValue(true);
    $this->UpdateFields["parcela_seccion"]["Value"] = $this->parcela_seccion->GetDBValue(true);
    $this->UpdateFields["parcela_macizo"]["Value"] = $this->parcela_macizo->GetDBValue(true);
    $this->UpdateFields["parcela_parcela"]["Value"] = $this->parcela_parcela->GetDBValue(true);
    $this->UpdateFields["parcela_chacra"]["Value"] = $this->parcela_chacra->GetDBValue(true);
    $this->UpdateFields["parcela_quinta"]["Value"] = $this->parcela_quinta->GetDBValue(true);
    $this->UpdateFields["parcela_fraccion"]["Value"] = $this->parcela_fraccion->GetDBValue(true);
    $this->UpdateFields["parcela_uf"]["Value"] = $this->parcela_uf->GetDBValue(true);
    $this->UpdateFields["parcela_mzna"]["Value"] = $this->parcela_mzna->GetDBValue(true);
    $this->UpdateFields["parcela_lote"]["Value"] = $this->parcela_lote->GetDBValue(true);
    $this->UpdateFields["parcela_partida"]["Value"] = $this->parcela_partida->GetDBValue(true);
    $this->UpdateFields["parcela_instrumento"]["Value"] = $this->parcela_instrumento_grid->GetDBValue(true);
    $this->UpdateFields["tipo_instrumento_id"]["Value"] = $this->tipo_instrumento_id_grid->GetDBValue(true);
    $this->SQL = CCBuildUpdate("tmp_dominio", $this->UpdateFields, $this);
    $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
    if (!strlen($this->Where) && $this->Errors->Count() == 0) 
      $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
    if($this->Errors->Count() == 0 && $this->CmdExecution) {
      $this->query($this->SQL);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
    }
    $this->Where = $SelectWhere;
  }
//End Update Method

} //End tmp_dominioDataSource Class @13-FCB6E20C

//Include Page implementation @90-000D2F68
include_once(RelativePath . "/gestion/headerParcela.php");
//End Include Page implementation

//Initialize Page @1-0DBD1BBA
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
$TemplateFileName = "inscdominio.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-1DA99E84
include_once("./inscdominio_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-4CB976DF
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$parcelas = new clsRecordparcelas("", $MainPage);
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$tmp_dominio = new clsEditableGridtmp_dominio("", $MainPage);
$headerParcela = new clsheaderParcela("", "headerParcela", $MainPage);
$headerParcela->Initialize();
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->parcelas = & $parcelas;
$MainPage->footerParcela = & $footerParcela;
$MainPage->tmp_dominio = & $tmp_dominio;
$MainPage->headerParcela = & $headerParcela;
$tmp_dominio->Initialize();

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

//Execute Components @1-D1E8B986
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$parcelas->Operation();
$footerParcela->Operations();
$tmp_dominio->Operation();
$headerParcela->Operations();
//End Execute Components

//Go to destination page @1-52570097
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
  unset($parcelas);
  $footerParcela->Class_Terminate();
  unset($footerParcela);
  unset($tmp_dominio);
  $headerParcela->Class_Terminate();
  unset($headerParcela);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-CEEC04AC
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$parcelas->Show();
$footerParcela->Show();
$tmp_dominio->Show();
$headerParcela->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>Gene&#114;&#97;&#116;ed <!-- SCC -->wi&#116;&#104; <!-- SCC -->Cod&#101;&#67;&#104;arg&#101; <!-- CCS -->&#83;t&#117;&#100;io.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>Gene&#114;&#97;&#116;ed <!-- SCC -->wi&#116;&#104; <!-- SCC -->Cod&#101;&#67;&#104;arg&#101; <!-- CCS -->&#83;t&#117;&#100;io.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= "<center><font face=\"Arial\"><small>Gene&#114;&#97;&#116;ed <!-- SCC -->wi&#116;&#104; <!-- SCC -->Cod&#101;&#67;&#104;arg&#101; <!-- CCS -->&#83;t&#117;&#100;io.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-4399F72E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($parcelas);
$footerParcela->Class_Terminate();
unset($footerParcela);
unset($tmp_dominio);
$headerParcela->Class_Terminate();
unset($headerParcela);
unset($Tpl);
//End Unload Page


?>
