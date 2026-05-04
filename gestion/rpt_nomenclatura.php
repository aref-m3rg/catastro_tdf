<?php
//Include Common Files @1-02033EE1
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "rpt_nomenclatura.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @56-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @57-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @60-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @61-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsRecordpre { //pre Class @2-22CC23EF

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

//Class_Initialize Event @2-F707D196
  function clsRecordpre($RelativePath, & $Parent)
  {

    global $FileName;
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->Visible = true;
    $this->Parent = & $Parent;
    $this->RelativePath = $RelativePath;
    $this->Errors = new clsErrors();
    $this->ErrorBlock = "Record pre/Error";
    $this->DataSource = new clspreDataSource($this);
    $this->ds = & $this->DataSource;
    $this->ReadAllowed = true;
    $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
    if($this->Visible)
    {
      $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
      $this->ComponentName = "pre";
      $this->Attributes = new clsAttributes($this->ComponentName . ":");
      $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
      if(sizeof($CCSForm) == 1)
        $CCSForm[1] = "";
      list($FormName, $FormMethod) = $CCSForm;
      $this->EditMode = ($FormMethod == "Edit");
      $this->FormEnctype = "application/x-www-form-urlencoded";
      $this->FormSubmitted = ($FormName == $this->ComponentName);
      $Method = $this->FormSubmitted ? ccsPost : ccsGet;
      $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
      $this->dpto_abrev = new clsControl(ccsLabel, "dpto_abrev", "dpto_abrev", ccsText, "", CCGetRequestParam("dpto_abrev", $Method, NULL), $this);
      $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "parcela_partida", ccsText, "", CCGetRequestParam("parcela_partida", $Method, NULL), $this);
      $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "parcela_seccion", ccsText, "", CCGetRequestParam("parcela_seccion", $Method, NULL), $this);
      $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "parcela_chacra", ccsText, "", CCGetRequestParam("parcela_chacra", $Method, NULL), $this);
      $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "parcela_quinta", ccsText, "", CCGetRequestParam("parcela_quinta", $Method, NULL), $this);
      $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "parcela_macizo", ccsText, "", CCGetRequestParam("parcela_macizo", $Method, NULL), $this);
      $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "parcela_fraccion", ccsText, "", CCGetRequestParam("parcela_fraccion", $Method, NULL), $this);
      $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "parcela_parcela", ccsText, "", CCGetRequestParam("parcela_parcela", $Method, NULL), $this);
      $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "parcela_uf", ccsText, "", CCGetRequestParam("parcela_uf", $Method, NULL), $this);
      $this->plano = new clsControl(ccsTextBox, "plano", "plano", ccsText, "", CCGetRequestParam("plano", $Method, NULL), $this);
      $this->obs = new clsControl(ccsTextArea, "obs", "obs", ccsText, "", CCGetRequestParam("obs", $Method, NULL), $this);
      $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsText, "", CCGetRequestParam("parcela_id", $Method, NULL), $this);
      $this->descrip = new clsControl(ccsCheckBox, "descrip", "descrip", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("descrip", $Method, NULL), $this);
      $this->descrip->CheckedValue = true;
      $this->descrip->UncheckedValue = false;
      if(!$this->FormSubmitted) {
        if(!is_array($this->descrip->Value) && !strlen($this->descrip->Value) && $this->descrip->Value !== false)
          $this->descrip->SetValue(false);
      }
    }
  }
//End Class_Initialize Event

//Initialize Method @2-16FD92D0
  function Initialize()
  {

    if(!$this->Visible)
      return;

    $this->DataSource->Parameters["urlparcela_id"] = CCGetFromGet("parcela_id", NULL);
  }
//End Initialize Method

//Validate Method @2-04BCCC41
  function Validate()
  {
    global $CCSLocales;
    $Validation = true;
    $Where = "";
    $Validation = ($this->plano->Validate() && $Validation);
    $Validation = ($this->obs->Validate() && $Validation);
    $Validation = ($this->parcela_id->Validate() && $Validation);
    $Validation = ($this->descrip->Validate() && $Validation);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    $Validation =  $Validation && ($this->plano->Errors->Count() == 0);
    $Validation =  $Validation && ($this->obs->Errors->Count() == 0);
    $Validation =  $Validation && ($this->parcela_id->Errors->Count() == 0);
    $Validation =  $Validation && ($this->descrip->Errors->Count() == 0);
    return (($this->Errors->Count() == 0) && $Validation);
  }
//End Validate Method

//CheckErrors Method @2-C78483EE
  function CheckErrors()
  {
    $errors = false;
    $errors = ($errors || $this->dpto_abrev->Errors->Count());
    $errors = ($errors || $this->parcela_partida->Errors->Count());
    $errors = ($errors || $this->parcela_seccion->Errors->Count());
    $errors = ($errors || $this->parcela_chacra->Errors->Count());
    $errors = ($errors || $this->parcela_quinta->Errors->Count());
    $errors = ($errors || $this->parcela_macizo->Errors->Count());
    $errors = ($errors || $this->parcela_fraccion->Errors->Count());
    $errors = ($errors || $this->parcela_parcela->Errors->Count());
    $errors = ($errors || $this->parcela_uf->Errors->Count());
    $errors = ($errors || $this->plano->Errors->Count());
    $errors = ($errors || $this->obs->Errors->Count());
    $errors = ($errors || $this->parcela_id->Errors->Count());
    $errors = ($errors || $this->descrip->Errors->Count());
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

//Operation Method @2-5D27A1BC
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
      $this->PressedButton = "Button_DoSearch";
      if($this->Button_DoSearch->Pressed) {
        $this->PressedButton = "Button_DoSearch";
      }
    }
    $Redirect = $FileName;
    if($this->Validate()) {
      if($this->PressedButton == "Button_DoSearch") {
        $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
        if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
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

//Show Method @2-A7F7183E
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
    if($this->EditMode) {
      if($this->DataSource->Errors->Count()){
        $this->Errors->AddErrors($this->DataSource->Errors);
        $this->DataSource->Errors->clear();
      }
      $this->DataSource->Open();
      if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
        $this->DataSource->SetValues();
        $this->dpto_abrev->SetValue($this->DataSource->dpto_abrev->GetValue());
        $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
        $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
        $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
        $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
        $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
        $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
        $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
        $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
        if(!$this->FormSubmitted){
          $this->obs->SetValue($this->DataSource->obs->GetValue());
        }
      } else {
        $this->EditMode = false;
      }
    }
    if (!$this->FormSubmitted) {
    }

    if($this->FormSubmitted || $this->CheckErrors()) {
      $Error = "";
      $Error = ComposeStrings($Error, $this->dpto_abrev->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_partida->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_seccion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_chacra->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_quinta->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_macizo->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_fraccion->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_parcela->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_uf->Errors->ToString());
      $Error = ComposeStrings($Error, $this->plano->Errors->ToString());
      $Error = ComposeStrings($Error, $this->obs->Errors->ToString());
      $Error = ComposeStrings($Error, $this->parcela_id->Errors->ToString());
      $Error = ComposeStrings($Error, $this->descrip->Errors->ToString());
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

    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    $this->Attributes->Show();
    if(!$this->Visible) {
      $Tpl->block_path = $ParentPath;
      return;
    }

    $this->Button_DoSearch->Show();
    $this->dpto_abrev->Show();
    $this->parcela_partida->Show();
    $this->parcela_seccion->Show();
    $this->parcela_chacra->Show();
    $this->parcela_quinta->Show();
    $this->parcela_macizo->Show();
    $this->parcela_fraccion->Show();
    $this->parcela_parcela->Show();
    $this->parcela_uf->Show();
    $this->plano->Show();
    $this->obs->Show();
    $this->parcela_id->Show();
    $this->descrip->Show();
    $Tpl->parse();
    $Tpl->block_path = $ParentPath;
    $this->DataSource->close();
  }
//End Show Method

} //End pre Class @2-FCB6E20C

class clspreDataSource extends clsDBcatastro {  //preDataSource Class @2-1FD23649

//DataSource Variables @2-214BA2E4
  public $Parent = "";
  public $CCSEvents = "";
  public $CCSEventResult;
  public $ErrorBlock;
  public $CmdExecution;

  public $wp;
  public $AllParametersSet;


  // Datasource fields
  public $dpto_abrev;
  public $parcela_partida;
  public $parcela_seccion;
  public $parcela_chacra;
  public $parcela_quinta;
  public $parcela_macizo;
  public $parcela_fraccion;
  public $parcela_parcela;
  public $parcela_uf;
  public $plano;
  public $obs;
  public $parcela_id;
  public $descrip;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-F992560B
  function clspreDataSource(& $Parent)
  {
    $this->Parent = & $Parent;
    $this->ErrorBlock = "Record pre/Error";
    $this->Initialize();
    $this->dpto_abrev = new clsField("dpto_abrev", ccsText, "");
    
    $this->parcela_partida = new clsField("parcela_partida", ccsText, "");
    
    $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
    
    $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
    
    $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
    
    $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
    
    $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
    
    $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
    
    $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
    
    $this->plano = new clsField("plano", ccsText, "");
    
    $this->obs = new clsField("obs", ccsText, "");
    
    $this->parcela_id = new clsField("parcela_id", ccsText, "");
    
    $this->descrip = new clsField("descrip", ccsBoolean, $this->BooleanFormat);
    

  }
//End DataSourceClass_Initialize Event

//Prepare Method @2-1FDC5EE8
  function Prepare()
  {
    global $CCSLocales;
    global $DefaultDateFormat;
    $this->wp = new clsSQLParameters($this->ErrorBlock);
    $this->wp->AddParameter("1", "urlparcela_id", ccsInteger, "", "", $this->Parameters["urlparcela_id"], "", false);
    $this->AllParametersSet = $this->wp->AllParamsSet();
    $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.parcela_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
    $this->Where = 
       $this->wp->Criterion[1];
  }
//End Prepare Method

//Open Method @2-A76E28CF
  function Open()
  {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
    $this->SQL = "SELECT parcela_partida, IF(parcela_seccion='R','RURAL',parcela_seccion) AS parcela_seccion, parcela_macizo, parcela_parcela, parcela_chacra,\n\n" .
    "parcela_quinta, parcela_fraccion, parcela_uf, tipo_depto_parc_abrev, parcela_cert \n\n" .
    "FROM parcelas LEFT JOIN tipos_deptos_parcela ON\n\n" .
    "parcelas.tipo_depto_parc_id = tipos_deptos_parcela.tipo_depto_parc_id {SQL_Where} {SQL_OrderBy}";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
    $this->PageSize = 1;
    $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
  }
//End Open Method

//SetValues Method @2-83FFF1F6
  function SetValues()
  {
    $this->dpto_abrev->SetDBValue($this->f("tipo_depto_parc_abrev"));
    $this->parcela_partida->SetDBValue($this->f("parcela_partida"));
    $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
    $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
    $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
    $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
    $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
    $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
    $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
    $this->obs->SetDBValue($this->f("parcela_cert"));
  }
//End SetValues Method

} //End preDataSource Class @2-FCB6E20C

//Initialize Page @1-27D222B6
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
$TemplateFileName = "rpt_nomenclatura.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-424F6F63
include_once("./rpt_nomenclatura_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A4EE39DC
$DBcatastro = new clsDBcatastro();
$MainPage->Connections["catastro"] = & $DBcatastro;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$footerParcela = new clsfooterParcela("", "footerParcela", $MainPage);
$footerParcela->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$pre = new clsRecordpre("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->footerParcela = & $footerParcela;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->pre = & $pre;
$pre->Initialize();

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

//Execute Components @1-C12C6ADE
$tdf_header->Operations();
$tdf_menu->Operations();
$footerParcela->Operations();
$tdf_footer->Operations();
$pre->Operation();
//End Execute Components

//Go to destination page @1-80831AE2
if($Redirect)
{
  $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
  $DBcatastro->close();
  header("Location: " . $Redirect);
  $tdf_header->Class_Terminate();
  unset($tdf_header);
  $tdf_menu->Class_Terminate();
  unset($tdf_menu);
  $footerParcela->Class_Terminate();
  unset($footerParcela);
  $tdf_footer->Class_Terminate();
  unset($tdf_footer);
  unset($pre);
  unset($Tpl);
  exit;
}
//End Go to destination page

//Show Page @1-F59DE4D5
$tdf_header->Show();
$tdf_menu->Show();
$footerParcela->Show();
$tdf_footer->Show();
$pre->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
  $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\">" . "<small>&#71;&#101;&#110;&#10" . "1;&#114;a&#116;e&#100; <!-- " . "SCC -->&#119;&#105;&#116;&#1" . "04; <!-- SCC -->C&#111;de&" . "#67;ha&#114;&#103;&#101;" . " <!-- CCS -->S&#116;udio.</" . "small></font></center>" . "" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
  $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\">" . "<small>&#71;&#101;&#110;&#10" . "1;&#114;a&#116;e&#100; <!-- " . "SCC -->&#119;&#105;&#116;&#1" . "04; <!-- SCC -->C&#111;de&" . "#67;ha&#114;&#103;&#101;" . " <!-- CCS -->S&#116;udio.</" . "small></font></center>" . "" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
  $main_block .= "<center><font face=\"Arial\">" . "<small>&#71;&#101;&#110;&#10" . "1;&#114;a&#116;e&#100; <!-- " . "SCC -->&#119;&#105;&#116;&#1" . "04; <!-- SCC -->C&#111;de&" . "#67;ha&#114;&#103;&#101;" . " <!-- CCS -->S&#116;udio.</" . "small></font></center>" . "";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-5DCC21B5
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcatastro->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$footerParcela->Class_Terminate();
unset($footerParcela);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($pre);
unset($Tpl);
//End Unload Page


?>
