<?php
//Include Common Files @1-5A474EC3
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_altaPiezaExt.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @38-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @39-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @40-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

class clsRecordpiezas { //piezas Class @2-2AF901FC

//Variables @2-9E315808

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

//Class_Initialize Event @2-9A8FED74
  function clsRecordpiezas($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record piezas/Error";
    $this->DataSource = new clspiezasDataSource($this);
    $this->ds = & $this->DataSource;
    $this->InsertAllowed = true;
    if($this->Visible)
    {
      $this->ComponentName = "piezas";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->EditMode = ($FormMethod == "Edit");
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->pieza_descripcion = new clsControl(ccsTextArea, "pieza_descripcion", "Descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", $Method, NULL), $this);
      $this->pieza_descripcion->Required = true;
      $this->pieza_observaciones = new clsControl(ccsTextArea, "pieza_observaciones", "Observaciones", ccsText, "", CCGetRequestParam("pieza_observaciones", $Method, NULL), $this);
      $this->pieza_iniciador = new clsControl(ccsTextBox, "pieza_iniciador", "Iniciador", ccsText, "", CCGetRequestParam("pieza_iniciador", $Method, NULL), $this);
      $this->pieza_iniciador->Required = true;
      $this->tramite_id = new clsControl(ccsListBox, "tramite_id", "Tipo de trámite", ccsInteger, "", CCGetRequestParam("tramite_id", $Method, NULL), $this);
      $this->tramite_id->DSType = dsTable;
      $this->tramite_id->DataSource = new clsDBmesa();
      $this->tramite_id->ds = & $this->tramite_id->DataSource;
      $this->tramite_id->DataSource->SQL = "SELECT tramite_id, tramite_desc \n" .
"FROM tramites {SQL_Where} {SQL_OrderBy}";
      $this->tramite_id->DataSource->Order = "tramite_desc";
      list($this->tramite_id->BoundColumn, $this->tramite_id->TextColumn, $this->tramite_id->DBFormat) = array("tramite_id", "tramite_desc", "");
      $this->tramite_id->DataSource->Parameters["expr37"] = 1;
      $this->tramite_id->DataSource->wp = new clsSQLParameters();
      $this->tramite_id->DataSource->wp->AddParameter("1", "expr37", ccsInteger, "", "", $this->tramite_id->DataSource->Parameters["expr37"], "", false);
      $this->tramite_id->DataSource->wp->Criterion[1] = $this->tramite_id->DataSource->wp->Operation(opEqual, "estado_id", $this->tramite_id->DataSource->wp->GetDBValue("1"), $this->tramite_id->DataSource->ToSQL($this->tramite_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
      $this->tramite_id->DataSource->Where = 
         $this->tramite_id->DataSource->wp->Criterion[1];
      $this->tramite_id->DataSource->Order = "tramite_desc";
      $this->tramite_id->Required = true;
      $this->entorno_id = new clsControl(ccsHidden, "entorno_id", "Entorno Id", ccsInteger, "", CCGetRequestParam("entorno_id", $Method, NULL), $this);
      $this->estado_id = new clsControl(ccsHidden, "estado_id", "Estado Id", ccsInteger, "", CCGetRequestParam("estado_id", $Method, NULL), $this);
      $this->Button1 = new clsButton("Button1", $Method, $this);
      $this->fojas = new clsControl(ccsTextBox, "fojas", "Numero de Fojas", ccsInteger, "", CCGetRequestParam("fojas", $Method, NULL), $this);
      $this->fojas->Required = true;
      $this->pieza_tipo_id = new clsControl(ccsRadioButton, "pieza_tipo_id", "Tipo", ccsInteger, "", CCGetRequestParam("pieza_tipo_id", $Method, NULL), $this);
      $this->pieza_tipo_id->DSType = dsTable;
      $this->pieza_tipo_id->DataSource = new clsDBmesa();
      $this->pieza_tipo_id->ds = & $this->pieza_tipo_id->DataSource;
      $this->pieza_tipo_id->DataSource->SQL = "SELECT * \n" .
"FROM piezas_tipos {SQL_Where} {SQL_OrderBy}";
      list($this->pieza_tipo_id->BoundColumn, $this->pieza_tipo_id->TextColumn, $this->pieza_tipo_id->DBFormat) = array("pieza_tipo_id", "pieza_tipo_desc", "");
      $this->pieza_tipo_id->HTML = true;
      $this->pieza_tipo_id->Required = true;
      $this->pieza_nro = new clsControl(ccsTextBox, "pieza_nro", "Nro", ccsInteger, "", CCGetRequestParam("pieza_nro", $Method, NULL), $this);
      $this->pieza_letra = new clsControl(ccsTextBox, "pieza_letra", "Letra", ccsText, "", CCGetRequestParam("pieza_letra", $Method, NULL), $this);
      $this->pieza_anio = new clsControl(ccsTextBox, "pieza_anio", "Año", ccsInteger, "", CCGetRequestParam("pieza_anio", $Method, NULL), $this);
      $this->unidad_id = new clsControl(ccsListBox, "unidad_id", "unidad_id", ccsText, "", CCGetRequestParam("unidad_id", $Method, NULL), $this);
      $this->unidad_id->DSType = dsTable;
      $this->unidad_id->DataSource = new clsDBmesa();
      $this->unidad_id->ds = & $this->unidad_id->DataSource;
      $this->unidad_id->DataSource->SQL = "SELECT unidades.unidad_id AS unidad_id, unidad_nombre AS descripcion \n" .
"FROM unidades_param INNER JOIN unidades ON\n" .
"unidades_param.unidad_id = unidades.unidad_id {SQL_Where} {SQL_OrderBy}";
      $this->unidad_id->DataSource->Order = "unidad_nombre";
      list($this->unidad_id->BoundColumn, $this->unidad_id->TextColumn, $this->unidad_id->DBFormat) = array("unidad_id", "descripcion", "");
      $this->unidad_id->DataSource->Parameters["expr49"] = 1;
      $this->unidad_id->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
      $this->unidad_id->DataSource->Parameters["expr52"] = 2;
      $this->unidad_id->DataSource->wp = new clsSQLParameters();
      $this->unidad_id->DataSource->wp->AddParameter("1", "expr49", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["expr49"], "", false);
      $this->unidad_id->DataSource->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["sesunidad_id"], "", false);
      $this->unidad_id->DataSource->wp->AddParameter("4", "expr52", ccsInteger, "", "", $this->unidad_id->DataSource->Parameters["expr52"], "", false);
      $this->unidad_id->DataSource->wp->Criterion[1] = $this->unidad_id->DataSource->wp->Operation(opEqual, "unidades.estado_id", $this->unidad_id->DataSource->wp->GetDBValue("1"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
      $this->unidad_id->DataSource->wp->Criterion[2] = "( unidad_p_id = (SELECT unidad_p_id FROM unidades_param WHERE unidades_param.unidad_id = unidades.unidad_id ORDER BY unidad_p_f_vig DESC LIMIT 1) )";
      $this->unidad_id->DataSource->wp->Criterion[3] = $this->unidad_id->DataSource->wp->Operation(opNotEqual, "unidades.unidad_id", $this->unidad_id->DataSource->wp->GetDBValue("3"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("3"), ccsInteger),false);
      $this->unidad_id->DataSource->wp->Criterion[4] = $this->unidad_id->DataSource->wp->Operation(opEqual, "unidades.entorno_id", $this->unidad_id->DataSource->wp->GetDBValue("4"), $this->unidad_id->DataSource->ToSQL($this->unidad_id->DataSource->wp->GetDBValue("4"), ccsInteger),false);
      $this->unidad_id->DataSource->Where = $this->unidad_id->DataSource->wp->opAND(
         false, $this->unidad_id->DataSource->wp->opAND(
         false, $this->unidad_id->DataSource->wp->opAND(
         false, 
         $this->unidad_id->DataSource->wp->Criterion[1], 
         $this->unidad_id->DataSource->wp->Criterion[2]), 
         $this->unidad_id->DataSource->wp->Criterion[3]), 
         $this->unidad_id->DataSource->wp->Criterion[4]);
      $this->unidad_id->DataSource->Order = "unidad_nombre";
      $this->tipo_tramites_id = new clsControl(ccsListBox, "tipo_tramites_id", "Trámite", ccsInteger, "", CCGetRequestParam("tipo_tramites_id", $Method, NULL), $this);
      $this->tipo_tramites_id->DSType = dsTable;
      $this->tipo_tramites_id->DataSource = new clsDBmesa();
      $this->tipo_tramites_id->ds = & $this->tipo_tramites_id->DataSource;
      $this->tipo_tramites_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_tramites {SQL_Where} {SQL_OrderBy}";
      list($this->tipo_tramites_id->BoundColumn, $this->tipo_tramites_id->TextColumn, $this->tipo_tramites_id->DBFormat) = array("tipo_tramites_id", "tipo_tramites_descript", "");
      $this->tipo_tramites_id->Required = true;
      $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
    }
  }
//End Class_Initialize Event

//Initialize Method @2-BB4B4CD9
  function Initialize()
  {

    if(!$this->Visible)
      return;

    $this->DataSource->Parameters["expr4"] = 0;
  }
//End Initialize Method

//Validate Method @2-6E3BDB54
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->pieza_descripcion->Validate() && $Validation);
    $Validation = ($this->pieza_observaciones->Validate() && $Validation);
    $Validation = ($this->pieza_iniciador->Validate() && $Validation);
    $Validation = ($this->tramite_id->Validate() && $Validation);
    $Validation = ($this->entorno_id->Validate() && $Validation);
    $Validation = ($this->estado_id->Validate() && $Validation);
    $Validation = ($this->fojas->Validate() && $Validation);
    $Validation = ($this->pieza_tipo_id->Validate() && $Validation);
    $Validation = ($this->pieza_nro->Validate() && $Validation);
    $Validation = ($this->pieza_letra->Validate() && $Validation);
    $Validation = ($this->pieza_anio->Validate() && $Validation);
    $Validation = ($this->unidad_id->Validate() && $Validation);
    $Validation = ($this->tipo_tramites_id->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->pieza_descripcion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_observaciones->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_iniciador->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tramite_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->entorno_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->estado_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->fojas->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_tipo_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_nro->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_letra->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_anio->Errors->Count() == 0);
    $Validation =  $Validation && ($this->unidad_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_tramites_id->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @2-6AF2DAFF
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->pieza_descripcion->Errors->Count());
    $errors = ($errors || $this->pieza_observaciones->Errors->Count());
    $errors = ($errors || $this->pieza_iniciador->Errors->Count());
    $errors = ($errors || $this->tramite_id->Errors->Count());
    $errors = ($errors || $this->entorno_id->Errors->Count());
    $errors = ($errors || $this->estado_id->Errors->Count());
    $errors = ($errors || $this->fojas->Errors->Count());
    $errors = ($errors || $this->pieza_tipo_id->Errors->Count());
    $errors = ($errors || $this->pieza_nro->Errors->Count());
    $errors = ($errors || $this->pieza_letra->Errors->Count());
    $errors = ($errors || $this->pieza_anio->Errors->Count());
    $errors = ($errors || $this->unidad_id->Errors->Count());
    $errors = ($errors || $this->tipo_tramites_id->Errors->Count());
    $errors = ($errors || $this->Errors->Count());
    $errors = ($errors || $this->DataSource->Errors->Count());
    return $errors;
  }
//End CheckErrors Method

//MasterDetail @2-ED598703
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

//Operation Method @2-EA5479A7
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
      $this->PressedButton = "Button_Insert";
      if($this->Button1->Pressed) {
        $this->PressedButton = "Button1";
      } else if($this->Button_Insert->Pressed) {
        $this->PressedButton = "Button_Insert";
      }
    }
    $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
    if($this->PressedButton == "Button1") {
      $Redirect = "msa_principal.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
      if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
        $Redirect = "";
      }
    } else if($this->Validate()) {
      if($this->PressedButton == "Button_Insert") {
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

//InsertRow Method @2-E119C7CC
  function InsertRow()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
    if(!$this->InsertAllowed) return false;
    $this->DataSource->pieza_tipo_id->SetValue($this->pieza_tipo_id->GetValue(true));
    $this->DataSource->pieza_descripcion->SetValue($this->pieza_descripcion->GetValue(true));
    $this->DataSource->pieza_observaciones->SetValue($this->pieza_observaciones->GetValue(true));
    $this->DataSource->pieza_iniciador->SetValue($this->pieza_iniciador->GetValue(true));
    $this->DataSource->unidad_id->SetValue($this->unidad_id->GetValue(true));
    $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
    $this->DataSource->entorno_id->SetValue($this->entorno_id->GetValue(true));
    $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
    $this->DataSource->Insert();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
    return (!$this->CheckErrors());
  }
//End InsertRow Method

//Show Method @2-2505E581
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

    $this->tramite_id->Prepare();
    $this->pieza_tipo_id->Prepare();
    $this->unidad_id->Prepare();
    $this->tipo_tramites_id->Prepare();

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
          $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
          $this->pieza_observaciones->SetValue($this->DataSource->pieza_observaciones->GetValue());
          $this->pieza_iniciador->SetValue($this->DataSource->pieza_iniciador->GetValue());
          $this->tramite_id->SetValue($this->DataSource->tramite_id->GetValue());
          $this->entorno_id->SetValue($this->DataSource->entorno_id->GetValue());
          $this->estado_id->SetValue($this->DataSource->estado_id->GetValue());
          $this->pieza_tipo_id->SetValue($this->DataSource->pieza_tipo_id->GetValue());
          $this->pieza_nro->SetValue($this->DataSource->pieza_nro->GetValue());
          $this->pieza_letra->SetValue($this->DataSource->pieza_letra->GetValue());
          $this->pieza_anio->SetValue($this->DataSource->pieza_anio->GetValue());
          $this->tipo_tramites_id->SetValue($this->DataSource->tipo_tramites_id->GetValue());
        }
      } else {
        $this->EditMode = false;
      }
    }
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->pieza_descripcion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_observaciones->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_iniciador->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tramite_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->entorno_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->estado_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->fojas->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_tipo_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_nro->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_letra->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_anio->Errors->ToString());
      $Error = ComposeStrings($Error, $this->unidad_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tipo_tramites_id->Errors->ToString());
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

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    $this->Attributes->Show();
    if(!$this->Visible) {
      $Tpl->block_path = $ParentPath;
      return;
    }

    $this->pieza_descripcion->Show();
    $this->pieza_observaciones->Show();
    $this->pieza_iniciador->Show();
    $this->tramite_id->Show();
    $this->entorno_id->Show();
    $this->estado_id->Show();
    $this->Button1->Show();
    $this->fojas->Show();
    $this->pieza_tipo_id->Show();
    $this->pieza_nro->Show();
    $this->pieza_letra->Show();
    $this->pieza_anio->Show();
    $this->unidad_id->Show();
    $this->tipo_tramites_id->Show();
    $this->Button_Insert->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

} //End piezas Class @2-FCB6E20C

class clspiezasDataSource extends clsDBmesa {  //piezasDataSource Class @2-BA74C8BE

//DataSource Variables @2-7291EAF3
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $InsertParameters;
  public $wp;
  public $AllParametersSet;


  // Datasource fields
  public $pieza_descripcion;
  public $pieza_observaciones;
  public $pieza_iniciador;
  public $tramite_id;
  public $entorno_id;
  public $estado_id;
  public $fojas;
  public $pieza_tipo_id;
  public $pieza_nro;
  public $pieza_letra;
  public $pieza_anio;
  public $unidad_id;
  public $tipo_tramites_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-56ECBE08
  function clspiezasDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Record piezas/Error";
    $this->Initialize();
    $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
    
    $this->pieza_observaciones = new clsField("pieza_observaciones", ccsText, "");
    
    $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
    
    $this->tramite_id = new clsField("tramite_id", ccsInteger, "");
    
    $this->entorno_id = new clsField("entorno_id", ccsInteger, "");
    
    $this->estado_id = new clsField("estado_id", ccsInteger, "");
    
    $this->fojas = new clsField("fojas", ccsInteger, "");
    
    $this->pieza_tipo_id = new clsField("pieza_tipo_id", ccsInteger, "");
    
    $this->pieza_nro = new clsField("pieza_nro", ccsInteger, "");
    
    $this->pieza_letra = new clsField("pieza_letra", ccsText, "");
    
    $this->pieza_anio = new clsField("pieza_anio", ccsInteger, "");
    
    $this->unidad_id = new clsField("unidad_id", ccsText, "");
    
    $this->tipo_tramites_id = new clsField("tipo_tramites_id", ccsInteger, "");
    

  }
//End DataSourceClass_Initialize Event

//Prepare Method @2-7627E4E3
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "expr4", ccsInteger, "", "", $this->Parameters["expr4"], "", false);
    $this->AllParametersSet = $this->wp->AllParamsSet();
    $this->wp->Criterion[1] = $this->wp->Operation(opIsNull, "pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->Where = 
       $this->wp->Criterion[1];
  }
//End Prepare Method

//Open Method @2-7FB6F565
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->SQL = "SELECT * \n\n" .
    "FROM piezas {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    $this->PageSize = 1;
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @2-B0AD2DE0
  function SetValues()
  {
    $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
    $this->pieza_observaciones->SetDBValue($this->f("pieza_observaciones"));
    $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
    $this->tramite_id->SetDBValue(trim($this->f("tramite_id")));
    $this->entorno_id->SetDBValue(trim($this->f("entorno_id")));
    $this->estado_id->SetDBValue(trim($this->f("estado_id")));
    $this->pieza_tipo_id->SetDBValue(trim($this->f("pieza_tipo_id")));
    $this->pieza_nro->SetDBValue(trim($this->f("pieza_nro")));
    $this->pieza_letra->SetDBValue($this->f("pieza_letra"));
    $this->pieza_anio->SetDBValue(trim($this->f("pieza_anio")));
    $this->tipo_tramites_id->SetDBValue(trim($this->f("tipo_tramites_id")));
  }
//End SetValues Method

//Insert Method @2-AA3580F9
  function Insert()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->cp["pieza_tipo_id"] = new clsSQLParameter("ctrlpieza_tipo_id", ccsInteger, "", "", $this->pieza_tipo_id->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_descripcion"] = new clsSQLParameter("ctrlpieza_descripcion", ccsText, "", "", $this->pieza_descripcion->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_observaciones"] = new clsSQLParameter("ctrlpieza_observaciones", ccsText, "", "", $this->pieza_observaciones->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_iniciador"] = new clsSQLParameter("ctrlpieza_iniciador", ccsText, "", "", $this->pieza_iniciador->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["unidad_id"] = new clsSQLParameter("ctrlunidad_id", ccsInteger, "", "", $this->unidad_id->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["tramite_id"] = new clsSQLParameter("ctrltramite_id", ccsInteger, "", "", $this->tramite_id->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["entorno_id"] = new clsSQLParameter("ctrlentorno_id", ccsInteger, "", "", $this->entorno_id->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["estado_id"] = new clsSQLParameter("ctrlestado_id", ccsInteger, "", "", $this->estado_id->GetValue(true), "", false, $this->ErrorBlock);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
    if (!is_null($this->cp["pieza_tipo_id"]->GetValue()) and !strlen($this->cp["pieza_tipo_id"]->GetText()) and !is_bool($this->cp["pieza_tipo_id"]->GetValue())) 
      $this->cp["pieza_tipo_id"]->SetValue($this->pieza_tipo_id->GetValue(true));
    if (!is_null($this->cp["pieza_descripcion"]->GetValue()) and !strlen($this->cp["pieza_descripcion"]->GetText()) and !is_bool($this->cp["pieza_descripcion"]->GetValue())) 
      $this->cp["pieza_descripcion"]->SetValue($this->pieza_descripcion->GetValue(true));
    if (!is_null($this->cp["pieza_observaciones"]->GetValue()) and !strlen($this->cp["pieza_observaciones"]->GetText()) and !is_bool($this->cp["pieza_observaciones"]->GetValue())) 
      $this->cp["pieza_observaciones"]->SetValue($this->pieza_observaciones->GetValue(true));
    if (!is_null($this->cp["pieza_iniciador"]->GetValue()) and !strlen($this->cp["pieza_iniciador"]->GetText()) and !is_bool($this->cp["pieza_iniciador"]->GetValue())) 
      $this->cp["pieza_iniciador"]->SetValue($this->pieza_iniciador->GetValue(true));
    if (!is_null($this->cp["unidad_id"]->GetValue()) and !strlen($this->cp["unidad_id"]->GetText()) and !is_bool($this->cp["unidad_id"]->GetValue())) 
      $this->cp["unidad_id"]->SetValue($this->unidad_id->GetValue(true));
    if (!is_null($this->cp["tramite_id"]->GetValue()) and !strlen($this->cp["tramite_id"]->GetText()) and !is_bool($this->cp["tramite_id"]->GetValue())) 
      $this->cp["tramite_id"]->SetValue($this->tramite_id->GetValue(true));
    if (!is_null($this->cp["entorno_id"]->GetValue()) and !strlen($this->cp["entorno_id"]->GetText()) and !is_bool($this->cp["entorno_id"]->GetValue())) 
      $this->cp["entorno_id"]->SetValue($this->entorno_id->GetValue(true));
    if (!is_null($this->cp["estado_id"]->GetValue()) and !strlen($this->cp["estado_id"]->GetText()) and !is_bool($this->cp["estado_id"]->GetValue())) 
      $this->cp["estado_id"]->SetValue($this->estado_id->GetValue(true));
    $this->SQL = "Select 1";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
    if($this->Errors->Count() == 0 && $this->CmdExecution) {
      $this->query($this->SQL);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
    }
  }
//End Insert Method

} //End piezasDataSource Class @2-FCB6E20C

//Initialize Page @1-195F1AA7
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
$TemplateFileName = "msa_altaPiezaExt.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-88C2DC38
include_once("./msa_altaPiezaExt_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-3651220C
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$piezas = new clsRecordpiezas("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->piezas = & $piezas;
$piezas->Initialize();

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

//Execute Components @1-451F3BCF
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$piezas->Operation();
//End Execute Components

//Go to destination page @1-40049456
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBmesa->close();
  header("Location: " . $Redirect);
  $tdf_header->Class_Terminate();
  unset($tdf_header);
  $tdf_footer->Class_Terminate();
  unset($tdf_footer);
  $tdf_menu->Class_Terminate();
  unset($tdf_menu);
  unset($piezas);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-D297F43C
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$piezas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;en&#101;r&#97;&#116;&#101;d <!-- SCC -->&#119;&#105;t&#104; <!-- SCC -->&#67;&#111;&#100;&#101;C&#104;&#97;r&#103;&#101; <!-- SCC -->S&#116;&#117;&#100;&#105;&#111;.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;en&#101;r&#97;&#116;&#101;d <!-- SCC -->&#119;&#105;t&#104; <!-- SCC -->&#67;&#111;&#100;&#101;C&#104;&#97;r&#103;&#101; <!-- SCC -->S&#116;&#117;&#100;&#105;&#111;.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= "<center><font face=\"Arial\"><small>&#71;en&#101;r&#97;&#116;&#101;d <!-- SCC -->&#119;&#105;t&#104; <!-- SCC -->&#67;&#111;&#100;&#101;C&#104;&#97;r&#103;&#101; <!-- SCC -->S&#116;&#117;&#100;&#105;&#111;.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A27ABAFA
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($piezas);
unset($Tpl);
//End Unload Page


?>
