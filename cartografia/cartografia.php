<?php
//Include Common Files @1-6C45542A
define("RelativePath", "..");
define("PathToCurrentPage", "/cartografia/");
define("FileName", "cartografia.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordselect { //select Class @27-257CBC0B

//Variables @27-9E315808

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

//Class_Initialize Event @27-B7A3D96C
    function clsRecordselect($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record select/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "select";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->servicio = new clsControl(ccsListBox, "servicio", "servicio", ccsText, "", CCGetRequestParam("servicio", $Method, NULL), $this);
            $this->servicio->DSType = dsTable;
            $this->servicio->DataSource = new clsDBtdf_nuevo();
            $this->servicio->ds = & $this->servicio->DataSource;
            $this->servicio->DataSource->SQL = "SELECT gis_srv_label, gis_srv_name \n" .
"FROM gis_servicios {SQL_Where}\n" .
"GROUP BY gis_srv_name {SQL_OrderBy}";
            $this->servicio->DataSource->Order = "gis_srv_label";
            list($this->servicio->BoundColumn, $this->servicio->TextColumn, $this->servicio->DBFormat) = array("gis_srv_name", "gis_srv_label", "");
            $this->servicio->DataSource->Order = "gis_srv_label";
            $this->Button1 = new clsButton("Button1", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->servicio->Value) && !strlen($this->servicio->Value) && $this->servicio->Value !== false)
                    $this->servicio->SetText(TDF_catastro_ush);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @27-31FB9BA6
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->servicio->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->servicio->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @27-B698E7D3
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->servicio->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @27-ED598703
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

//Operation Method @27-38787D37
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
            }
        }
        $Redirect = $FileName;
        if($this->PressedButton == "Button1") {
            $Redirect = $FileName . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button1", "Button1_x", "Button1_y")));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @27-88DB7A43
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

        $this->servicio->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->servicio->Errors->ToString());
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

        $this->servicio->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End select Class @27-FCB6E20C

//Include Page implementation @38-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @40-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @46-6A9CF48F
include_once(RelativePath . "/gestion/footerParcela.php");
//End Include Page implementation

//Include Page implementation @60-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-0F0DBDA7
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
$TemplateFileName = "cartografia.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-9A54B776
include_once("./cartografia_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-BFA8BBEC
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$jsapi = new clsControl(ccsHidden, "jsapi", "jsapi", ccsText, "", CCGetRequestParam("jsapi", ccsGet, NULL), $MainPage);
$server = new clsControl(ccsHidden, "server", "server", ccsText, "", CCGetRequestParam("server", ccsGet, NULL), $MainPage);
$servicio = new clsControl(ccsHidden, "servicio", "servicio", ccsText, "", CCGetRequestParam("servicio", ccsGet, NULL), $MainPage);
$capa_parcelario = new clsControl(ccsHidden, "capa_parcelario", "capa_parcelario", ccsText, "", CCGetRequestParam("capa_parcelario", ccsGet, NULL), $MainPage);
$select = new clsRecordselect("", $MainPage);
$Button1 = new clsButton("Button1", ccsGet, $MainPage);
$servidor = new clsControl(ccsHidden, "servidor", "servidor", ccsText, "", CCGetRequestParam("servidor", ccsGet, NULL), $MainPage);
$plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", CCGetRequestParam("plano", ccsGet, NULL), $MainPage);
$plano->HTML = true;
$css = new clsControl(ccsHidden, "css", "css", ccsText, "", CCGetRequestParam("css", ccsGet, NULL), $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tipo_padron_parc_id = new clsControl(ccsListBox, "tipo_padron_parc_id", "tipo_padron_parc_id", ccsText, "", CCGetRequestParam("tipo_padron_parc_id", ccsGet, NULL), $MainPage);
$tipo_padron_parc_id->DSType = dsTable;
$tipo_padron_parc_id->DataSource = new clsDBtdf_nuevo();
$tipo_padron_parc_id->ds = & $tipo_padron_parc_id->DataSource;
$tipo_padron_parc_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_padrones_parcela {SQL_Where} {SQL_OrderBy}";
list($tipo_padron_parc_id->BoundColumn, $tipo_padron_parc_id->TextColumn, $tipo_padron_parc_id->DBFormat) = array("tipo_padron_parc_id", "tipo_padron_parc_desc", "");
$footerParcela = new clsfooterParcela("../gestion/", "footerParcela", $MainPage);
$footerParcela->Initialize();
$dojo = new clsControl(ccsHidden, "dojo", "dojo", ccsText, "", CCGetRequestParam("dojo", ccsGet, NULL), $MainPage);
$query_layer = new clsControl(ccsHidden, "query_layer", "query_layer", ccsText, "", CCGetRequestParam("query_layer", ccsGet, NULL), $MainPage);
$query_layer_2 = new clsControl(ccsHidden, "query_layer_2", "query_layer_2", ccsText, "", CCGetRequestParam("query_layer_2", ccsGet, NULL), $MainPage);
$proxy = new clsControl(ccsHidden, "proxy", "proxy", ccsText, "", CCGetRequestParam("proxy", ccsGet, NULL), $MainPage);
$geometry = new clsControl(ccsHidden, "geometry", "geometry", ccsText, "", CCGetRequestParam("geometry", ccsGet, NULL), $MainPage);
$Button2 = new clsButton("Button2", ccsGet, $MainPage);
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->jsapi = & $jsapi;
$MainPage->server = & $server;
$MainPage->servicio = & $servicio;
$MainPage->capa_parcelario = & $capa_parcelario;
$MainPage->select = & $select;
$MainPage->Button1 = & $Button1;
$MainPage->servidor = & $servidor;
$MainPage->plano = & $plano;
$MainPage->css = & $css;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tipo_padron_parc_id = & $tipo_padron_parc_id;
$MainPage->footerParcela = & $footerParcela;
$MainPage->dojo = & $dojo;
$MainPage->query_layer = & $query_layer;
$MainPage->query_layer_2 = & $query_layer_2;
$MainPage->proxy = & $proxy;
$MainPage->geometry = & $geometry;
$MainPage->Button2 = & $Button2;
$MainPage->tdf_menu = & $tdf_menu;

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

//Execute Components @1-90D15E08
$select->Operation();
$tdf_header->Operations();
$tdf_footer->Operations();
$footerParcela->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-8186E8D7
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($select);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $footerParcela->Class_Terminate();
    unset($footerParcela);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B0F60752
$tipo_padron_parc_id->Prepare();
$select->Show();
$Button1->Show();
$tdf_header->Show();
$tdf_footer->Show();
$tipo_padron_parc_id->Show();
$footerParcela->Show();
$Button2->Show();
$tdf_menu->Show();
$jsapi->Show();
$server->Show();
$servicio->Show();
$capa_parcelario->Show();
$servidor->Show();
$plano->Show();
$css->Show();
$dojo->Show();
$query_layer->Show();
$query_layer_2->Show();
$proxy->Show();
$geometry->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;e&#110;e&#114;&#97;t&#101;&#100; <!-- CCS -->&#119;&#105;th <!-- SCC -->&#67;&#111;&#100;&#101;&#67;&#104;a&#114;ge <!-- SCC -->&#83;t&#117;&#100;io.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;e&#110;e&#114;&#97;t&#101;&#100; <!-- CCS -->&#119;&#105;th <!-- SCC -->&#67;&#111;&#100;&#101;&#67;&#104;a&#114;ge <!-- SCC -->&#83;t&#117;&#100;io.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>&#71;e&#110;e&#114;&#97;t&#101;&#100; <!-- CCS -->&#119;&#105;th <!-- SCC -->&#67;&#111;&#100;&#101;&#67;&#104;a&#114;ge <!-- SCC -->&#83;t&#117;&#100;io.</small></font></center>";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A2755A6E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($select);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$footerParcela->Class_Terminate();
unset($footerParcela);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
