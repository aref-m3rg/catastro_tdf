<?php
//Include Common Files @1-40345A17
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_altaNota.php");
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

//Class_Initialize Event @2-60A01F94
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
      $this->pieza_iniciador = new clsControl(ccsTextBox, "pieza_iniciador", "Iniciador", ccsText, "", CCGetRequestParam("pieza_iniciador", $Method, NULL), $this);
      $this->pieza_iniciador->Required = true;
      $this->pieza_descripcion = new clsControl(ccsTextBox, "pieza_descripcion", "Descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", $Method, NULL), $this);
      $this->pieza_descripcion->Required = true;
      $this->pieza_observaciones = new clsControl(ccsTextBox, "pieza_observaciones", "Observaciones", ccsText, "", CCGetRequestParam("pieza_observaciones", $Method, NULL), $this);
      $this->pieza_ref = new clsControl(ccsTextBox, "pieza_ref", "Ref", ccsText, "", CCGetRequestParam("pieza_ref", $Method, NULL), $this);
      $this->pieza_destinatario = new clsControl(ccsTextBox, "pieza_destinatario", "Destinatario", ccsText, "", CCGetRequestParam("pieza_destinatario", $Method, NULL), $this);
      $this->pieza_destinatario->Required = true;
      $this->pieza_of_destinatario = new clsControl(ccsTextBox, "pieza_of_destinatario", "Of Destinatario", ccsText, "", CCGetRequestParam("pieza_of_destinatario", $Method, NULL), $this);
      $this->pieza_autor = new clsControl(ccsTextBox, "pieza_autor", "Autor", ccsText, "", CCGetRequestParam("pieza_autor", $Method, NULL), $this);
      $this->pieza_autor->Required = true;
      $this->tramite_id = new clsControl(ccsListBox, "tramite_id", "Tipo de trámite", ccsInteger, "", CCGetRequestParam("tramite_id", $Method, NULL), $this);
      $this->tramite_id->DSType = dsTable;
      $this->tramite_id->DataSource = new clsDBmesa();
      $this->tramite_id->ds = & $this->tramite_id->DataSource;
      $this->tramite_id->DataSource->SQL = "SELECT tramite_id, tramite_desc \n" .
"FROM tramites {SQL_Where} {SQL_OrderBy}";
      $this->tramite_id->DataSource->Order = "tramite_desc";
      list($this->tramite_id->BoundColumn, $this->tramite_id->TextColumn, $this->tramite_id->DBFormat) = array("tramite_id", "tramite_desc", "");
      $this->tramite_id->DataSource->Parameters["expr14"] = 1;
      $this->tramite_id->DataSource->wp = new clsSQLParameters();
      $this->tramite_id->DataSource->wp->AddParameter("1", "expr14", ccsInteger, "", "", $this->tramite_id->DataSource->Parameters["expr14"], "", false);
      $this->tramite_id->DataSource->wp->Criterion[1] = $this->tramite_id->DataSource->wp->Operation(opEqual, "estado_id", $this->tramite_id->DataSource->wp->GetDBValue("1"), $this->tramite_id->DataSource->ToSQL($this->tramite_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
      $this->tramite_id->DataSource->Where = 
         $this->tramite_id->DataSource->wp->Criterion[1];
      $this->tramite_id->DataSource->Order = "tramite_desc";
      $this->tramite_id->Required = true;
      $this->pieza_txt = new clsControl(ccsTextArea, "pieza_txt", "Texto", ccsText, "", CCGetRequestParam("pieza_txt", $Method, NULL), $this);
      $this->Button1 = new clsButton("Button1", $Method, $this);
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

//Initialize Method @2-BE045A5C
  function Initialize()
  {

    if(!$this->Visible)
      return;

    $this->DataSource->Parameters["expr4"] = 7;
  }
//End Initialize Method

//Validate Method @2-4B435AAC
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->pieza_iniciador->Validate() && $Validation);
    $Validation = ($this->pieza_descripcion->Validate() && $Validation);
    $Validation = ($this->pieza_observaciones->Validate() && $Validation);
    $Validation = ($this->pieza_ref->Validate() && $Validation);
    $Validation = ($this->pieza_destinatario->Validate() && $Validation);
    $Validation = ($this->pieza_of_destinatario->Validate() && $Validation);
    $Validation = ($this->pieza_autor->Validate() && $Validation);
    $Validation = ($this->tramite_id->Validate() && $Validation);
    $Validation = ($this->pieza_txt->Validate() && $Validation);
    $Validation = ($this->tipo_tramites_id->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->pieza_iniciador->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_descripcion->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_observaciones->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_ref->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_destinatario->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_of_destinatario->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_autor->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tramite_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->pieza_txt->Errors->Count() == 0);
    $Validation =  $Validation && ($this->tipo_tramites_id->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @2-2BD4E489
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->pieza_iniciador->Errors->Count());
    $errors = ($errors || $this->pieza_descripcion->Errors->Count());
    $errors = ($errors || $this->pieza_observaciones->Errors->Count());
    $errors = ($errors || $this->pieza_ref->Errors->Count());
    $errors = ($errors || $this->pieza_destinatario->Errors->Count());
    $errors = ($errors || $this->pieza_of_destinatario->Errors->Count());
    $errors = ($errors || $this->pieza_autor->Errors->Count());
    $errors = ($errors || $this->tramite_id->Errors->Count());
    $errors = ($errors || $this->pieza_txt->Errors->Count());
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

//InsertRow Method @2-E1F48500
  function InsertRow()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
    if(!$this->InsertAllowed) return false;
    $this->DataSource->pieza_iniciador->SetValue($this->pieza_iniciador->GetValue(true));
    $this->DataSource->pieza_descripcion->SetValue($this->pieza_descripcion->GetValue(true));
    $this->DataSource->pieza_observaciones->SetValue($this->pieza_observaciones->GetValue(true));
    $this->DataSource->pieza_ref->SetValue($this->pieza_ref->GetValue(true));
    $this->DataSource->pieza_destinatario->SetValue($this->pieza_destinatario->GetValue(true));
    $this->DataSource->pieza_of_destinatario->SetValue($this->pieza_of_destinatario->GetValue(true));
    $this->DataSource->pieza_autor->SetValue($this->pieza_autor->GetValue(true));
    $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
    $this->DataSource->pieza_txt->SetValue($this->pieza_txt->GetValue(true));
    $this->DataSource->tipo_tramites_id->SetValue($this->tipo_tramites_id->GetValue(true));
    $this->DataSource->Insert();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
    return (!$this->CheckErrors());
  }
//End InsertRow Method

//Show Method @2-31D3935A
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
          $this->pieza_iniciador->SetValue($this->DataSource->pieza_iniciador->GetValue());
          $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
          $this->pieza_observaciones->SetValue($this->DataSource->pieza_observaciones->GetValue());
          $this->pieza_ref->SetValue($this->DataSource->pieza_ref->GetValue());
          $this->pieza_destinatario->SetValue($this->DataSource->pieza_destinatario->GetValue());
          $this->pieza_of_destinatario->SetValue($this->DataSource->pieza_of_destinatario->GetValue());
          $this->pieza_autor->SetValue($this->DataSource->pieza_autor->GetValue());
          $this->tramite_id->SetValue($this->DataSource->tramite_id->GetValue());
          $this->pieza_txt->SetValue($this->DataSource->pieza_txt->GetValue());
          $this->tipo_tramites_id->SetValue($this->DataSource->tipo_tramites_id->GetValue());
        }
      } else {
        $this->EditMode = false;
      }
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->pieza_iniciador->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_descripcion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_observaciones->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_ref->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_destinatario->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_of_destinatario->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_autor->Errors->ToString());
      $Error = ComposeStrings($Error, $this->tramite_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->pieza_txt->Errors->ToString());
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

    $this->pieza_iniciador->Show();
    $this->pieza_descripcion->Show();
    $this->pieza_observaciones->Show();
    $this->pieza_ref->Show();
    $this->pieza_destinatario->Show();
    $this->pieza_of_destinatario->Show();
    $this->pieza_autor->Show();
    $this->tramite_id->Show();
    $this->pieza_txt->Show();
    $this->Button1->Show();
    $this->tipo_tramites_id->Show();
    $this->Button_Insert->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

} //End piezas Class @2-FCB6E20C

class clspiezasDataSource extends clsDBmesa {  //piezasDataSource Class @2-BA74C8BE

//DataSource Variables @2-C1B0E032
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $InsertParameters;
  public $wp;
  public $AllParametersSet;


  // Datasource fields
  public $pieza_iniciador;
  public $pieza_descripcion;
  public $pieza_observaciones;
  public $pieza_ref;
  public $pieza_destinatario;
  public $pieza_of_destinatario;
  public $pieza_autor;
  public $tramite_id;
  public $pieza_txt;
  public $tipo_tramites_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-1711C953
  function clspiezasDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Record piezas/Error";
    $this->Initialize();
    $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
    
    $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
    
    $this->pieza_observaciones = new clsField("pieza_observaciones", ccsText, "");
    
    $this->pieza_ref = new clsField("pieza_ref", ccsText, "");
    
    $this->pieza_destinatario = new clsField("pieza_destinatario", ccsText, "");
    
    $this->pieza_of_destinatario = new clsField("pieza_of_destinatario", ccsText, "");
    
    $this->pieza_autor = new clsField("pieza_autor", ccsText, "");
    
    $this->tramite_id = new clsField("tramite_id", ccsInteger, "");
    
    $this->pieza_txt = new clsField("pieza_txt", ccsText, "");
    
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

//SetValues Method @2-82FE0A4E
  function SetValues()
  {
    $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
    $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
    $this->pieza_observaciones->SetDBValue($this->f("pieza_observaciones"));
    $this->pieza_ref->SetDBValue($this->f("pieza_ref"));
    $this->pieza_destinatario->SetDBValue($this->f("pieza_destinatario"));
    $this->pieza_of_destinatario->SetDBValue($this->f("pieza_of_destinatario"));
    $this->pieza_autor->SetDBValue($this->f("pieza_autor"));
    $this->tramite_id->SetDBValue(trim($this->f("tramite_id")));
    $this->pieza_txt->SetDBValue($this->f("pieza_txt"));
    $this->tipo_tramites_id->SetDBValue(trim($this->f("tipo_tramites_id")));
  }
//End SetValues Method

//Insert Method @2-CE0C910A
  function Insert()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->CmdExecution = true;
    $this->cp["pieza_iniciador"] = new clsSQLParameter("ctrlpieza_iniciador", ccsText, "", "", $this->pieza_iniciador->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_descripcion"] = new clsSQLParameter("ctrlpieza_descripcion", ccsText, "", "", $this->pieza_descripcion->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_observaciones"] = new clsSQLParameter("ctrlpieza_observaciones", ccsText, "", "", $this->pieza_observaciones->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_ref"] = new clsSQLParameter("ctrlpieza_ref", ccsText, "", "", $this->pieza_ref->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_destinatario"] = new clsSQLParameter("ctrlpieza_destinatario", ccsText, "", "", $this->pieza_destinatario->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_of_destinatario"] = new clsSQLParameter("ctrlpieza_of_destinatario", ccsText, "", "", $this->pieza_of_destinatario->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_autor"] = new clsSQLParameter("ctrlpieza_autor", ccsText, "", "", $this->pieza_autor->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["tramite_id"] = new clsSQLParameter("ctrltramite_id", ccsInteger, "", "", $this->tramite_id->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["pieza_txt"] = new clsSQLParameter("ctrlpieza_txt", ccsText, "", "", $this->pieza_txt->GetValue(true), "", false, $this->ErrorBlock);
    $this->cp["tipo_tramites_id"] = new clsSQLParameter("ctrltipo_tramites_id", ccsInteger, "", "", $this->tipo_tramites_id->GetValue(true), 0, false, $this->ErrorBlock);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
    if (!is_null($this->cp["pieza_iniciador"]->GetValue()) and !strlen($this->cp["pieza_iniciador"]->GetText()) and !is_bool($this->cp["pieza_iniciador"]->GetValue())) 
      $this->cp["pieza_iniciador"]->SetValue($this->pieza_iniciador->GetValue(true));
    if (!is_null($this->cp["pieza_descripcion"]->GetValue()) and !strlen($this->cp["pieza_descripcion"]->GetText()) and !is_bool($this->cp["pieza_descripcion"]->GetValue())) 
      $this->cp["pieza_descripcion"]->SetValue($this->pieza_descripcion->GetValue(true));
    if (!is_null($this->cp["pieza_observaciones"]->GetValue()) and !strlen($this->cp["pieza_observaciones"]->GetText()) and !is_bool($this->cp["pieza_observaciones"]->GetValue())) 
      $this->cp["pieza_observaciones"]->SetValue($this->pieza_observaciones->GetValue(true));
    if (!is_null($this->cp["pieza_ref"]->GetValue()) and !strlen($this->cp["pieza_ref"]->GetText()) and !is_bool($this->cp["pieza_ref"]->GetValue())) 
      $this->cp["pieza_ref"]->SetValue($this->pieza_ref->GetValue(true));
    if (!is_null($this->cp["pieza_destinatario"]->GetValue()) and !strlen($this->cp["pieza_destinatario"]->GetText()) and !is_bool($this->cp["pieza_destinatario"]->GetValue())) 
      $this->cp["pieza_destinatario"]->SetValue($this->pieza_destinatario->GetValue(true));
    if (!is_null($this->cp["pieza_of_destinatario"]->GetValue()) and !strlen($this->cp["pieza_of_destinatario"]->GetText()) and !is_bool($this->cp["pieza_of_destinatario"]->GetValue())) 
      $this->cp["pieza_of_destinatario"]->SetValue($this->pieza_of_destinatario->GetValue(true));
    if (!is_null($this->cp["pieza_autor"]->GetValue()) and !strlen($this->cp["pieza_autor"]->GetText()) and !is_bool($this->cp["pieza_autor"]->GetValue())) 
      $this->cp["pieza_autor"]->SetValue($this->pieza_autor->GetValue(true));
    if (!is_null($this->cp["tramite_id"]->GetValue()) and !strlen($this->cp["tramite_id"]->GetText()) and !is_bool($this->cp["tramite_id"]->GetValue())) 
      $this->cp["tramite_id"]->SetValue($this->tramite_id->GetValue(true));
    if (!is_null($this->cp["pieza_txt"]->GetValue()) and !strlen($this->cp["pieza_txt"]->GetText()) and !is_bool($this->cp["pieza_txt"]->GetValue())) 
      $this->cp["pieza_txt"]->SetValue($this->pieza_txt->GetValue(true));
    if (!is_null($this->cp["tipo_tramites_id"]->GetValue()) and !strlen($this->cp["tipo_tramites_id"]->GetText()) and !is_bool($this->cp["tipo_tramites_id"]->GetValue())) 
      $this->cp["tipo_tramites_id"]->SetValue($this->tipo_tramites_id->GetValue(true));
    if (!strlen($this->cp["tipo_tramites_id"]->GetText()) and !is_bool($this->cp["tipo_tramites_id"]->GetValue(true))) 
      $this->cp["tipo_tramites_id"]->SetText(0);
    $this->SQL = "Select 1";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
    if($this->Errors->Count() == 0 && $this->CmdExecution) {
      $this->query($this->SQL);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
    }
  }
//End Insert Method

} //End piezasDataSource Class @2-FCB6E20C

//Initialize Page @1-88D4E123
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
$TemplateFileName = "msa_altaNota.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-0154A6AF
include_once("./msa_altaNota_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-584F4A4D
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
$piezas = new clsRecordpiezas("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
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

//Execute Components @1-9379ADBF
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$piezas->Operation();
//End Execute Components

//Go to destination page @1-BDB268A8
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
  unset($piezas);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-748E7305
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$piezas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"><sma", "ll>Gen&#101;&#114;at&#101;d <!-- ", "CCS -->w&#105;t&#104; <!-- CCS -->C", "o&#100;e&#67;&#104;&#97;&#114;g&", "#101; <!-- SCC -->&#83;tudio.</sm", "all></font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"><sma", "ll>Gen&#101;&#114;at&#101;d <!-- ", "CCS -->w&#105;t&#104; <!-- CCS -->C", "o&#100;e&#67;&#104;&#97;&#114;g&", "#101; <!-- SCC -->&#83;tudio.</sm", "all></font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= implode(array("<center><font face=\"Arial\"><sma", "ll>Gen&#101;&#114;at&#101;d <!-- ", "CCS -->w&#105;t&#104; <!-- CCS -->C", "o&#100;e&#67;&#104;&#97;&#114;g&", "#101; <!-- SCC -->&#83;tudio.</sm", "all></font></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-BE4F920B
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($piezas);
unset($Tpl);
//End Unload Page


?>
