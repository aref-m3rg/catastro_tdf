<?php
//Include Common Files @1-9E036A73
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_editExp.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

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

//Class_Initialize Event @2-B65B9822
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
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
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
            $this->pieza_tipo_id = new clsControl(ccsHidden, "pieza_tipo_id", "Tipo Id", ccsInteger, "", CCGetRequestParam("pieza_tipo_id", $Method, NULL), $this);
            $this->pieza_descripcion = new clsControl(ccsTextArea, "pieza_descripcion", "Descripcion", ccsText, "", CCGetRequestParam("pieza_descripcion", $Method, NULL), $this);
            $this->pieza_descripcion->Required = true;
            $this->pieza_observaciones = new clsControl(ccsTextArea, "pieza_observaciones", "Observaciones", ccsText, "", CCGetRequestParam("pieza_observaciones", $Method, NULL), $this);
            $this->pieza_iniciador = new clsControl(ccsTextBox, "pieza_iniciador", "Iniciador", ccsText, "", CCGetRequestParam("pieza_iniciador", $Method, NULL), $this);
            $this->pieza_iniciador->Required = true;
            $this->unidad_id = new clsControl(ccsHidden, "unidad_id", "Unidad Id", ccsInteger, "", CCGetRequestParam("unidad_id", $Method, NULL), $this);
            $this->tramite_id = new clsControl(ccsListBox, "tramite_id", "Tramite", ccsInteger, "", CCGetRequestParam("tramite_id", $Method, NULL), $this);
            $this->tramite_id->DSType = dsTable;
            $this->tramite_id->DataSource = new clsDBmesa();
            $this->tramite_id->ds = & $this->tramite_id->DataSource;
            $this->tramite_id->DataSource->SQL = "SELECT tramite_id, tramite_desc \n" .
"FROM tramites {SQL_Where} {SQL_OrderBy}";
            $this->tramite_id->DataSource->Order = "tramite_desc";
            list($this->tramite_id->BoundColumn, $this->tramite_id->TextColumn, $this->tramite_id->DBFormat) = array("", "", "");
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
            $this->Button2 = new clsButton("Button2", $Method, $this);
            $this->expediente = new clsControl(ccsLabel, "expediente", "expediente", ccsText, "", CCGetRequestParam("expediente", $Method, NULL), $this);
            $this->tipo_tramites_id = new clsControl(ccsListBox, "tipo_tramites_id", "tipo_tramites_id", ccsText, "", CCGetRequestParam("tipo_tramites_id", $Method, NULL), $this);
            $this->tipo_tramites_id->DSType = dsTable;
            $this->tipo_tramites_id->DataSource = new clsDBmesa();
            $this->tipo_tramites_id->ds = & $this->tipo_tramites_id->DataSource;
            $this->tipo_tramites_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_tramites {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_tramites_id->BoundColumn, $this->tipo_tramites_id->TextColumn, $this->tipo_tramites_id->DBFormat) = array("tipo_tramites_id", "tipo_tramites_descript", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @2-EEC5201A
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlpieza_id"] = CCGetFromGet("pieza_id", NULL);
    }
//End Initialize Method

//Validate Method @2-67F5D1B7
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->pieza_tipo_id->Validate() && $Validation);
        $Validation = ($this->pieza_descripcion->Validate() && $Validation);
        $Validation = ($this->pieza_observaciones->Validate() && $Validation);
        $Validation = ($this->pieza_iniciador->Validate() && $Validation);
        $Validation = ($this->unidad_id->Validate() && $Validation);
        $Validation = ($this->tramite_id->Validate() && $Validation);
        $Validation = ($this->entorno_id->Validate() && $Validation);
        $Validation = ($this->estado_id->Validate() && $Validation);
        $Validation = ($this->tipo_tramites_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->pieza_tipo_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pieza_descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pieza_observaciones->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pieza_iniciador->Errors->Count() == 0);
        $Validation =  $Validation && ($this->unidad_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tramite_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->entorno_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_tramites_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-84A58797
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->pieza_tipo_id->Errors->Count());
        $errors = ($errors || $this->pieza_descripcion->Errors->Count());
        $errors = ($errors || $this->pieza_observaciones->Errors->Count());
        $errors = ($errors || $this->pieza_iniciador->Errors->Count());
        $errors = ($errors || $this->unidad_id->Errors->Count());
        $errors = ($errors || $this->tramite_id->Errors->Count());
        $errors = ($errors || $this->entorno_id->Errors->Count());
        $errors = ($errors || $this->estado_id->Errors->Count());
        $errors = ($errors || $this->expediente->Errors->Count());
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

//Operation Method @2-2273EFD6
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
            $this->PressedButton = $this->EditMode ? "Button2" : "Button1";
            if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button2->Pressed) {
                $this->PressedButton = "Button2";
            }
        }
        $Redirect = "msa_viewPieza.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button2") {
                if(!CCGetEvent($this->Button2->CCSEvents, "OnClick", $this->Button2) || !$this->UpdateRow()) {
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

//UpdateRow Method @2-5541437C
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->pieza_tipo_id->SetValue($this->pieza_tipo_id->GetValue(true));
        $this->DataSource->pieza_descripcion->SetValue($this->pieza_descripcion->GetValue(true));
        $this->DataSource->pieza_observaciones->SetValue($this->pieza_observaciones->GetValue(true));
        $this->DataSource->pieza_iniciador->SetValue($this->pieza_iniciador->GetValue(true));
        $this->DataSource->unidad_id->SetValue($this->unidad_id->GetValue(true));
        $this->DataSource->tramite_id->SetValue($this->tramite_id->GetValue(true));
        $this->DataSource->entorno_id->SetValue($this->entorno_id->GetValue(true));
        $this->DataSource->estado_id->SetValue($this->estado_id->GetValue(true));
        $this->DataSource->expediente->SetValue($this->expediente->GetValue(true));
        $this->DataSource->tipo_tramites_id->SetValue($this->tipo_tramites_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @2-61C1291E
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
                $this->expediente->SetValue($this->DataSource->expediente->GetValue());
                if(!$this->FormSubmitted){
                    $this->pieza_tipo_id->SetValue($this->DataSource->pieza_tipo_id->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->pieza_observaciones->SetValue($this->DataSource->pieza_observaciones->GetValue());
                    $this->pieza_iniciador->SetValue($this->DataSource->pieza_iniciador->GetValue());
                    $this->unidad_id->SetValue($this->DataSource->unidad_id->GetValue());
                    $this->tramite_id->SetValue($this->DataSource->tramite_id->GetValue());
                    $this->entorno_id->SetValue($this->DataSource->entorno_id->GetValue());
                    $this->estado_id->SetValue($this->DataSource->estado_id->GetValue());
                    $this->tipo_tramites_id->SetValue($this->DataSource->tipo_tramites_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->pieza_tipo_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pieza_descripcion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pieza_observaciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pieza_iniciador->Errors->ToString());
            $Error = ComposeStrings($Error, $this->unidad_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tramite_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->entorno_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->expediente->Errors->ToString());
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
        $this->Button2->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->pieza_tipo_id->Show();
        $this->pieza_descripcion->Show();
        $this->pieza_observaciones->Show();
        $this->pieza_iniciador->Show();
        $this->unidad_id->Show();
        $this->tramite_id->Show();
        $this->entorno_id->Show();
        $this->estado_id->Show();
        $this->Button1->Show();
        $this->Button2->Show();
        $this->expediente->Show();
        $this->tipo_tramites_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End piezas Class @2-FCB6E20C

class clspiezasDataSource extends clsDBmesa {  //piezasDataSource Class @2-BA74C8BE

//DataSource Variables @2-7ABA2FD1
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $pieza_tipo_id;
    public $pieza_descripcion;
    public $pieza_observaciones;
    public $pieza_iniciador;
    public $unidad_id;
    public $tramite_id;
    public $entorno_id;
    public $estado_id;
    public $expediente;
    public $tipo_tramites_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-350CA09B
    function clspiezasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record piezas/Error";
        $this->Initialize();
        $this->pieza_tipo_id = new clsField("pieza_tipo_id", ccsInteger, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->pieza_observaciones = new clsField("pieza_observaciones", ccsText, "");
        
        $this->pieza_iniciador = new clsField("pieza_iniciador", ccsText, "");
        
        $this->unidad_id = new clsField("unidad_id", ccsInteger, "");
        
        $this->tramite_id = new clsField("tramite_id", ccsInteger, "");
        
        $this->entorno_id = new clsField("entorno_id", ccsInteger, "");
        
        $this->estado_id = new clsField("estado_id", ccsInteger, "");
        
        $this->expediente = new clsField("expediente", ccsText, "");
        
        $this->tipo_tramites_id = new clsField("tipo_tramites_id", ccsText, "");
        

        $this->UpdateFields["pieza_tipo_id"] = array("Name" => "pieza_tipo_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["pieza_descripcion"] = array("Name" => "pieza_descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["pieza_observaciones"] = array("Name" => "pieza_observaciones", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["pieza_iniciador"] = array("Name" => "pieza_iniciador", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tramite_id"] = array("Name" => "tramite_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["entorno_id"] = array("Name" => "entorno_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_id"] = array("Name" => "estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_tramites_id"] = array("Name" => "tipo_tramites_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-F01B80F8
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpieza_id", ccsInteger, "", "", $this->Parameters["urlpieza_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pieza_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-3ADD26D2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *,  CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS expediente\n\n" .
        "FROM piezas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-FC6D2C41
    function SetValues()
    {
        $this->pieza_tipo_id->SetDBValue(trim($this->f("pieza_tipo_id")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_observaciones->SetDBValue($this->f("pieza_observaciones"));
        $this->pieza_iniciador->SetDBValue($this->f("pieza_iniciador"));
        $this->unidad_id->SetDBValue(trim($this->f("unidad_id")));
        $this->tramite_id->SetDBValue(trim($this->f("tramite_id")));
        $this->entorno_id->SetDBValue(trim($this->f("entorno_id")));
        $this->estado_id->SetDBValue(trim($this->f("estado_id")));
        $this->expediente->SetDBValue($this->f("expediente"));
        $this->tipo_tramites_id->SetDBValue($this->f("tipo_tramites_id"));
    }
//End SetValues Method

//Update Method @2-58AA51E6
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["pieza_tipo_id"]["Value"] = $this->pieza_tipo_id->GetDBValue(true);
        $this->UpdateFields["pieza_descripcion"]["Value"] = $this->pieza_descripcion->GetDBValue(true);
        $this->UpdateFields["pieza_observaciones"]["Value"] = $this->pieza_observaciones->GetDBValue(true);
        $this->UpdateFields["pieza_iniciador"]["Value"] = $this->pieza_iniciador->GetDBValue(true);
        $this->UpdateFields["unidad_id"]["Value"] = $this->unidad_id->GetDBValue(true);
        $this->UpdateFields["tramite_id"]["Value"] = $this->tramite_id->GetDBValue(true);
        $this->UpdateFields["entorno_id"]["Value"] = $this->entorno_id->GetDBValue(true);
        $this->UpdateFields["estado_id"]["Value"] = $this->estado_id->GetDBValue(true);
        $this->UpdateFields["tipo_tramites_id"]["Value"] = $this->tipo_tramites_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("piezas", $this->UpdateFields, $this);
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

} //End piezasDataSource Class @2-FCB6E20C

//Include Page implementation @47-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @48-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @49-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-5AE4B88A
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
$TemplateFileName = "msa_editExp.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-D17B0769
include_once("./msa_editExp_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-8BA5B223
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$piezas = new clsRecordpiezas("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->piezas = & $piezas;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
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

//Execute Components @1-CFE20756
$piezas->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-BF2AA194
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($piezas);
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

//Show Page @1-86D7BF25
$piezas->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"", "><small>&#71;&#101;n&#101;", "&#114;a&#116;e&#100; <!-- SCC", " -->with <!-- CCS -->&#67;o", "&#100;&#101;Char&#103;e <!--", " SCC -->&#83;t&#117;d&#105;o.", "</small></font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"", "><small>&#71;&#101;n&#101;", "&#114;a&#116;e&#100; <!-- SCC", " -->with <!-- CCS -->&#67;o", "&#100;&#101;Char&#103;e <!--", " SCC -->&#83;t&#117;d&#105;o.", "</small></font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\"", "><small>&#71;&#101;n&#101;", "&#114;a&#116;e&#100; <!-- SCC", " -->with <!-- CCS -->&#67;o", "&#100;&#101;Char&#103;e <!--", " SCC -->&#83;t&#117;d&#105;o.", "</small></font></center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9DDE25A8
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($piezas);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
