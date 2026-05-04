<?php
//Include Common Files @1-582BE1D5
define("RelativePath", "..");
define("PathToCurrentPage", "/usuarios/");
define("FileName", "adm_usuario.php");
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

class clsGridusuarios_secciones1 { //usuarios_secciones1 class @5-A97386B1

//Variables @5-13AAE338

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
    public $Sorter_usuario_nombre;
    public $Sorter_usuario_login;
    public $Sorter_seccion_descrip;
    public $Sorter1;
//End Variables

//Class_Initialize Event @5-908A983E
    function clsGridusuarios_secciones1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "usuarios_secciones1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid usuarios_secciones1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsusuarios_secciones1DataSource($this);
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
        $this->SorterName = CCGetParam("usuarios_secciones1Order", "");
        $this->SorterDirection = CCGetParam("usuarios_secciones1Dir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet, NULL), $this);
        $this->Detail->Page = "adm_usuario.php";
        $this->usuario_nombre = new clsControl(ccsLabel, "usuario_nombre", "usuario_nombre", ccsText, "", CCGetRequestParam("usuario_nombre", ccsGet, NULL), $this);
        $this->usuario_login = new clsControl(ccsLabel, "usuario_login", "usuario_login", ccsText, "", CCGetRequestParam("usuario_login", ccsGet, NULL), $this);
        $this->seccion_descrip = new clsControl(ccsLabel, "seccion_descrip", "seccion_descrip", ccsText, "", CCGetRequestParam("seccion_descrip", ccsGet, NULL), $this);
        $this->tipo_estado_descrip = new clsControl(ccsLabel, "tipo_estado_descrip", "tipo_estado_descrip", ccsText, "", CCGetRequestParam("tipo_estado_descrip", ccsGet, NULL), $this);
        $this->perfil_nombre = new clsControl(ccsLabel, "perfil_nombre", "perfil_nombre", ccsText, "", CCGetRequestParam("perfil_nombre", ccsGet, NULL), $this);
        $this->usuarios_secciones1_Insert = new clsControl(ccsLink, "usuarios_secciones1_Insert", "usuarios_secciones1_Insert", ccsText, "", CCGetRequestParam("usuarios_secciones1_Insert", ccsGet, NULL), $this);
        $this->usuarios_secciones1_Insert->Parameters = CCGetQueryString("QueryString", array("usuario_id", "ccsForm"));
        $this->usuarios_secciones1_Insert->Page = "adm_usuario.php";
        $this->Sorter_usuario_nombre = new clsSorter($this->ComponentName, "Sorter_usuario_nombre", $FileName, $this);
        $this->Sorter_usuario_login = new clsSorter($this->ComponentName, "Sorter_usuario_login", $FileName, $this);
        $this->Sorter_seccion_descrip = new clsSorter($this->ComponentName, "Sorter_seccion_descrip", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Sorter1 = new clsSorter($this->ComponentName, "Sorter1", $FileName, $this);
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

//Show Method @5-1E73A74F
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_usuario_nombre"] = CCGetFromGet("s_usuario_nombre", NULL);
        $this->DataSource->Parameters["urls_usuario_login"] = CCGetFromGet("s_usuario_login", NULL);
        $this->DataSource->Parameters["urls_secciones_seccion_id"] = CCGetFromGet("s_secciones_seccion_id", NULL);

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
            $this->ControlsVisible["Detail"] = $this->Detail->Visible;
            $this->ControlsVisible["usuario_nombre"] = $this->usuario_nombre->Visible;
            $this->ControlsVisible["usuario_login"] = $this->usuario_login->Visible;
            $this->ControlsVisible["seccion_descrip"] = $this->seccion_descrip->Visible;
            $this->ControlsVisible["tipo_estado_descrip"] = $this->tipo_estado_descrip->Visible;
            $this->ControlsVisible["perfil_nombre"] = $this->perfil_nombre->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->Detail->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "usuario_id", $this->DataSource->f("usuario_id"));
                $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                $this->usuario_login->SetValue($this->DataSource->usuario_login->GetValue());
                $this->seccion_descrip->SetValue($this->DataSource->seccion_descrip->GetValue());
                $this->tipo_estado_descrip->SetValue($this->DataSource->tipo_estado_descrip->GetValue());
                $this->perfil_nombre->SetValue($this->DataSource->perfil_nombre->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->Detail->Show();
                $this->usuario_nombre->Show();
                $this->usuario_login->Show();
                $this->seccion_descrip->Show();
                $this->tipo_estado_descrip->Show();
                $this->perfil_nombre->Show();
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
        $this->usuarios_secciones1_Insert->Show();
        $this->Sorter_usuario_nombre->Show();
        $this->Sorter_usuario_login->Show();
        $this->Sorter_seccion_descrip->Show();
        $this->Navigator->Show();
        $this->Sorter1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @5-B94E8ADF
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->Detail->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->seccion_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->perfil_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End usuarios_secciones1 Class @5-FCB6E20C

class clsusuarios_secciones1DataSource extends clsDBtdf_nuevo {  //usuarios_secciones1DataSource Class @5-CFF056B4

//DataSource Variables @5-6046217E
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $usuario_nombre;
    public $usuario_login;
    public $seccion_descrip;
    public $tipo_estado_descrip;
    public $perfil_nombre;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-2F828B52
    function clsusuarios_secciones1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid usuarios_secciones1";
        $this->Initialize();
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->usuario_login = new clsField("usuario_login", ccsText, "");
        
        $this->seccion_descrip = new clsField("seccion_descrip", ccsText, "");
        
        $this->tipo_estado_descrip = new clsField("tipo_estado_descrip", ccsText, "");
        
        $this->perfil_nombre = new clsField("perfil_nombre", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-DB52CC77
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_usuario_nombre" => array("usuario_nombre", ""), 
            "Sorter_usuario_login" => array("usuario_login", ""), 
            "Sorter_seccion_descrip" => array("seccion_descrip", ""), 
            "Sorter1" => array("tipo_estado_descrip", "")));
    }
//End SetOrder Method

//Prepare Method @5-AA087B31
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_usuario_nombre", ccsText, "", "", $this->Parameters["urls_usuario_nombre"], "", false);
        $this->wp->AddParameter("2", "urls_usuario_login", ccsText, "", "", $this->Parameters["urls_usuario_login"], "", false);
        $this->wp->AddParameter("3", "urls_secciones_seccion_id", ccsInteger, "", "", $this->Parameters["urls_secciones_seccion_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "_usuarios.usuario_nombre", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "_usuarios.usuario_login", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "secciones.seccion_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @5-66DA1900
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((_usuarios INNER JOIN secciones ON\n\n" .
        "_usuarios.seccion_id = secciones.seccion_id) INNER JOIN tipos_estados ON\n\n" .
        "_usuarios.tipo_estado_id = tipos_estados.tipo_estado_id) INNER JOIN _perfiles ON\n\n" .
        "_usuarios.perfil_id = _perfiles.perfil_id";
        $this->SQL = "SELECT usuario_id, usuario_nombre, usuario_login, seccion_descrip, tipo_estado_descrip, _perfiles.* \n\n" .
        "FROM ((_usuarios INNER JOIN secciones ON\n\n" .
        "_usuarios.seccion_id = secciones.seccion_id) INNER JOIN tipos_estados ON\n\n" .
        "_usuarios.tipo_estado_id = tipos_estados.tipo_estado_id) INNER JOIN _perfiles ON\n\n" .
        "_usuarios.perfil_id = _perfiles.perfil_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-D191F12A
    function SetValues()
    {
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->usuario_login->SetDBValue($this->f("usuario_login"));
        $this->seccion_descrip->SetDBValue($this->f("seccion_descrip"));
        $this->tipo_estado_descrip->SetDBValue($this->f("tipo_estado_descrip"));
        $this->perfil_nombre->SetDBValue($this->f("perfil_nombre"));
    }
//End SetValues Method

} //End usuarios_secciones1DataSource Class @5-FCB6E20C

class clsRecordusuarios_secciones { //usuarios_secciones Class @9-09E49668

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

//Class_Initialize Event @9-D3DEFA22
    function clsRecordusuarios_secciones($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record usuarios_secciones/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "usuarios_secciones";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_usuario_nombre = new clsControl(ccsTextBox, "s_usuario_nombre", "s_usuario_nombre", ccsText, "", CCGetRequestParam("s_usuario_nombre", $Method, NULL), $this);
            $this->s_usuario_login = new clsControl(ccsTextBox, "s_usuario_login", "s_usuario_login", ccsText, "", CCGetRequestParam("s_usuario_login", $Method, NULL), $this);
            $this->s_secciones_seccion_id = new clsControl(ccsListBox, "s_secciones_seccion_id", "s_secciones_seccion_id", ccsInteger, "", CCGetRequestParam("s_secciones_seccion_id", $Method, NULL), $this);
            $this->s_secciones_seccion_id->DSType = dsTable;
            $this->s_secciones_seccion_id->DataSource = new clsDBtdf_nuevo();
            $this->s_secciones_seccion_id->ds = & $this->s_secciones_seccion_id->DataSource;
            $this->s_secciones_seccion_id->DataSource->SQL = "SELECT * \n" .
"FROM secciones {SQL_Where} {SQL_OrderBy}";
            list($this->s_secciones_seccion_id->BoundColumn, $this->s_secciones_seccion_id->TextColumn, $this->s_secciones_seccion_id->DBFormat) = array("seccion_id", "seccion_descrip", "");
        }
    }
//End Class_Initialize Event

//Validate Method @9-EEA41CEF
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_usuario_nombre->Validate() && $Validation);
        $Validation = ($this->s_usuario_login->Validate() && $Validation);
        $Validation = ($this->s_secciones_seccion_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_usuario_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_usuario_login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_secciones_seccion_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @9-9AC1DD8B
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_usuario_nombre->Errors->Count());
        $errors = ($errors || $this->s_usuario_login->Errors->Count());
        $errors = ($errors || $this->s_secciones_seccion_id->Errors->Count());
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

//Operation Method @9-B9C30C61
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
            }
        }
        $Redirect = "adm_usuario.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "adm_usuario.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @9-6EFB737E
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

        $this->s_secciones_seccion_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_usuario_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_usuario_login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_secciones_seccion_id->Errors->ToString());
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
        $this->s_usuario_nombre->Show();
        $this->s_usuario_login->Show();
        $this->s_secciones_seccion_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End usuarios_secciones Class @9-FCB6E20C



class clsRecordusuarios1 { //usuarios1 Class @51-7F149410

//Variables @51-9E315808

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

//Class_Initialize Event @51-992A40F6
    function clsRecordusuarios1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record usuarios1/Error";
        $this->DataSource = new clsusuarios1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->UpdateAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->DeleteAllowed = CCUserInGroups(CCGetGroupID(), "2");
            $this->ComponentName = "usuarios1";
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
            $this->usuario_nombre = new clsControl(ccsTextBox, "usuario_nombre", "Usuario Nombre", ccsText, "", CCGetRequestParam("usuario_nombre", $Method, NULL), $this);
            $this->usuario_nombre->Required = true;
            $this->usuario_login = new clsControl(ccsTextBox, "usuario_login", "Usuario Login", ccsText, "", CCGetRequestParam("usuario_login", $Method, NULL), $this);
            $this->usuario_login->Required = true;
            $this->usuario_clave = new clsControl(ccsTextBox, "usuario_clave", "Usuario Clave", ccsText, "", CCGetRequestParam("usuario_clave", $Method, NULL), $this);
            $this->usuario_clave_old = new clsControl(ccsHidden, "usuario_clave_old", "Usuario Clave Old", ccsText, "", CCGetRequestParam("usuario_clave_old", $Method, NULL), $this);
            $this->seccion_id = new clsControl(ccsListBox, "seccion_id", "Seccion Id", ccsInteger, "", CCGetRequestParam("seccion_id", $Method, NULL), $this);
            $this->seccion_id->DSType = dsTable;
            $this->seccion_id->DataSource = new clsDBtdf_nuevo();
            $this->seccion_id->ds = & $this->seccion_id->DataSource;
            $this->seccion_id->DataSource->SQL = "SELECT * \n" .
"FROM secciones {SQL_Where} {SQL_OrderBy}";
            list($this->seccion_id->BoundColumn, $this->seccion_id->TextColumn, $this->seccion_id->DBFormat) = array("seccion_id", "seccion_descrip", "");
            $this->perfil_id = new clsControl(ccsListBox, "perfil_id", "perfil_id", ccsText, "", CCGetRequestParam("perfil_id", $Method, NULL), $this);
            $this->perfil_id->DSType = dsTable;
            $this->perfil_id->DataSource = new clsDBtdf_nuevo();
            $this->perfil_id->ds = & $this->perfil_id->DataSource;
            $this->perfil_id->DataSource->SQL = "SELECT * \n" .
"FROM _perfiles {SQL_Where} {SQL_OrderBy}";
            list($this->perfil_id->BoundColumn, $this->perfil_id->TextColumn, $this->perfil_id->DBFormat) = array("perfil_id", "perfil_nombre", "");
            $this->Button_retorno = new clsButton("Button_retorno", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @51-B03D04AE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlusuario_id"] = CCGetFromGet("usuario_id", NULL);
    }
//End Initialize Method

//Validate Method @51-6F1FB17A
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->usuario_nombre->SetValue($this->usuario_nombre->GetValue());
        if(CCDLookUp("COUNT(*)", "_usuarios", "usuario_nombre=" . $this->DataSource->ToSQL($this->DataSource->usuario_nombre->GetDBValue(), $this->DataSource->usuario_nombre->DataType) . $Where, $this->DataSource) > 0)
            $this->usuario_nombre->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Usuario Nombre"));
        $this->DataSource->usuario_login->SetValue($this->usuario_login->GetValue());
        if(CCDLookUp("COUNT(*)", "_usuarios", "usuario_login=" . $this->DataSource->ToSQL($this->DataSource->usuario_login->GetDBValue(), $this->DataSource->usuario_login->DataType) . $Where, $this->DataSource) > 0)
            $this->usuario_login->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Usuario Login"));
        $Validation = ($this->usuario_nombre->Validate() && $Validation);
        $Validation = ($this->usuario_login->Validate() && $Validation);
        $Validation = ($this->usuario_clave->Validate() && $Validation);
        $Validation = ($this->usuario_clave_old->Validate() && $Validation);
        $Validation = ($this->seccion_id->Validate() && $Validation);
        $Validation = ($this->perfil_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->usuario_nombre->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_clave->Errors->Count() == 0);
        $Validation =  $Validation && ($this->usuario_clave_old->Errors->Count() == 0);
        $Validation =  $Validation && ($this->seccion_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->perfil_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @51-BD159426
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->usuario_nombre->Errors->Count());
        $errors = ($errors || $this->usuario_login->Errors->Count());
        $errors = ($errors || $this->usuario_clave->Errors->Count());
        $errors = ($errors || $this->usuario_clave_old->Errors->Count());
        $errors = ($errors || $this->seccion_id->Errors->Count());
        $errors = ($errors || $this->perfil_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @51-ED598703
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

//Operation Method @51-0EB5CC01
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
            } else if($this->Button_retorno->Pressed) {
                $this->PressedButton = "Button_retorno";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete" && $this->DeleteAllowed) {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "usuario_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_retorno") {
            if(!CCGetEvent($this->Button_retorno->CCSEvents, "OnClick", $this->Button_retorno)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update" && $this->UpdateAllowed) {
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

//InsertRow Method @51-22CF08E6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->usuario_nombre->SetValue($this->usuario_nombre->GetValue(true));
        $this->DataSource->usuario_login->SetValue($this->usuario_login->GetValue(true));
        $this->DataSource->usuario_clave->SetValue($this->usuario_clave->GetValue(true));
        $this->DataSource->usuario_clave_old->SetValue($this->usuario_clave_old->GetValue(true));
        $this->DataSource->seccion_id->SetValue($this->seccion_id->GetValue(true));
        $this->DataSource->perfil_id->SetValue($this->perfil_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @51-CFC25AB7
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->usuario_nombre->SetValue($this->usuario_nombre->GetValue(true));
        $this->DataSource->usuario_login->SetValue($this->usuario_login->GetValue(true));
        $this->DataSource->usuario_clave->SetValue($this->usuario_clave->GetValue(true));
        $this->DataSource->usuario_clave_old->SetValue($this->usuario_clave_old->GetValue(true));
        $this->DataSource->seccion_id->SetValue($this->seccion_id->GetValue(true));
        $this->DataSource->perfil_id->SetValue($this->perfil_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @51-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @51-C7AB8BE2
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

        $this->seccion_id->Prepare();
        $this->perfil_id->Prepare();

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
                    $this->usuario_nombre->SetValue($this->DataSource->usuario_nombre->GetValue());
                    $this->usuario_login->SetValue($this->DataSource->usuario_login->GetValue());
                    $this->usuario_clave->SetValue($this->DataSource->usuario_clave->GetValue());
                    $this->usuario_clave_old->SetValue($this->DataSource->usuario_clave_old->GetValue());
                    $this->seccion_id->SetValue($this->DataSource->seccion_id->GetValue());
                    $this->perfil_id->SetValue($this->DataSource->perfil_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->usuario_nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_clave->Errors->ToString());
            $Error = ComposeStrings($Error, $this->usuario_clave_old->Errors->ToString());
            $Error = ComposeStrings($Error, $this->seccion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->perfil_id->Errors->ToString());
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
        $this->usuario_nombre->Show();
        $this->usuario_login->Show();
        $this->usuario_clave->Show();
        $this->usuario_clave_old->Show();
        $this->seccion_id->Show();
        $this->perfil_id->Show();
        $this->Button_retorno->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End usuarios1 Class @51-FCB6E20C

class clsusuarios1DataSource extends clsDBtdf_nuevo {  //usuarios1DataSource Class @51-644223BE

//DataSource Variables @51-E85F94BF
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $usuario_nombre;
    public $usuario_login;
    public $usuario_clave;
    public $usuario_clave_old;
    public $seccion_id;
    public $perfil_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @51-06C17536
    function clsusuarios1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record usuarios1/Error";
        $this->Initialize();
        $this->usuario_nombre = new clsField("usuario_nombre", ccsText, "");
        
        $this->usuario_login = new clsField("usuario_login", ccsText, "");
        
        $this->usuario_clave = new clsField("usuario_clave", ccsText, "");
        
        $this->usuario_clave_old = new clsField("usuario_clave_old", ccsText, "");
        
        $this->seccion_id = new clsField("seccion_id", ccsInteger, "");
        
        $this->perfil_id = new clsField("perfil_id", ccsText, "");
        

        $this->InsertFields["usuario_nombre"] = array("Name" => "usuario_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_login"] = array("Name" => "usuario_login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_clave"] = array("Name" => "usuario_clave", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["usuario_clave_old"] = array("Name" => "usuario_clave_old", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["seccion_id"] = array("Name" => "seccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["perfil_id"] = array("Name" => "perfil_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_nombre"] = array("Name" => "usuario_nombre", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_login"] = array("Name" => "usuario_login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_clave"] = array("Name" => "usuario_clave", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["usuario_clave_old"] = array("Name" => "usuario_clave_old", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["seccion_id"] = array("Name" => "seccion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["perfil_id"] = array("Name" => "perfil_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @51-D7640FC7
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlusuario_id", ccsInteger, "", "", $this->Parameters["urlusuario_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @51-74D2FE57
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM _usuarios {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @51-EAAB8D60
    function SetValues()
    {
        $this->usuario_nombre->SetDBValue($this->f("usuario_nombre"));
        $this->usuario_login->SetDBValue($this->f("usuario_login"));
        $this->usuario_clave->SetDBValue($this->f("usuario_clave"));
        $this->usuario_clave_old->SetDBValue($this->f("usuario_clave_old"));
        $this->seccion_id->SetDBValue(trim($this->f("seccion_id")));
        $this->perfil_id->SetDBValue($this->f("perfil_id"));
    }
//End SetValues Method

//Insert Method @51-9B79DDD0
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["usuario_nombre"]["Value"] = $this->usuario_nombre->GetDBValue(true);
        $this->InsertFields["usuario_login"]["Value"] = $this->usuario_login->GetDBValue(true);
        $this->InsertFields["usuario_clave"]["Value"] = $this->usuario_clave->GetDBValue(true);
        $this->InsertFields["usuario_clave_old"]["Value"] = $this->usuario_clave_old->GetDBValue(true);
        $this->InsertFields["seccion_id"]["Value"] = $this->seccion_id->GetDBValue(true);
        $this->InsertFields["perfil_id"]["Value"] = $this->perfil_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("_usuarios", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @51-F0280D26
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["usuario_nombre"]["Value"] = $this->usuario_nombre->GetDBValue(true);
        $this->UpdateFields["usuario_login"]["Value"] = $this->usuario_login->GetDBValue(true);
        $this->UpdateFields["usuario_clave"]["Value"] = $this->usuario_clave->GetDBValue(true);
        $this->UpdateFields["usuario_clave_old"]["Value"] = $this->usuario_clave_old->GetDBValue(true);
        $this->UpdateFields["seccion_id"]["Value"] = $this->seccion_id->GetDBValue(true);
        $this->UpdateFields["perfil_id"]["Value"] = $this->perfil_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("_usuarios", $this->UpdateFields, $this);
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

//Delete Method @51-86F74A88
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM _usuarios";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End usuarios1DataSource Class @51-FCB6E20C

class clsEditableGridusuarios_unidades { //usuarios_unidades Class @82-D2A54264

//Variables @82-69E85E68

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
    public $Sorter_unidad_id;
//End Variables

//Class_Initialize Event @82-B9E7EA1D
    function clsEditableGridusuarios_unidades($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid usuarios_unidades/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "usuarios_unidades";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["usr_uni_id"][0] = "usr_uni_id";
        $this->DataSource = new clsusuarios_unidadesDataSource($this);
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

        $this->EmptyRows = 1;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
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

        $this->SorterName = CCGetParam("usuarios_unidadesOrder", "");
        $this->SorterDirection = CCGetParam("usuarios_unidadesDir", "");

        $this->Sorter_unidad_id = new clsSorter($this->ComponentName, "Sorter_unidad_id", $FileName, $this);
        $this->unidad_id = new clsControl(ccsListBox, "unidad_id", "Unidad Id", ccsInteger, "", NULL, $this);
        $this->unidad_id->DSType = dsTable;
        $this->unidad_id->DataSource = new clsDBunidades();
        $this->unidad_id->ds = & $this->unidad_id->DataSource;
        $this->unidad_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades {SQL_Where} {SQL_OrderBy}";
        $this->unidad_id->DataSource->Order = "unidad_nombre";
        list($this->unidad_id->BoundColumn, $this->unidad_id->TextColumn, $this->unidad_id->DBFormat) = array("unidad_id", "unidad_nombre", "");
        $this->unidad_id->DataSource->Order = "unidad_nombre";
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @82-3F920902
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlusuario_id"] = CCGetFromGet("usuario_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @82-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @82-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @82-F325C5F2
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["unidad_id"][$RowNumber] = CCGetFromPost("unidad_id_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @82-A98FA3C7
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["usr_uni_id"] = $this->CachedColumns["usr_uni_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if(!$this->CheckBox_Delete->Value)
                    $Validation = ($this->ValidateRow() && $Validation);
            }
            else if($this->CheckInsert())
            {
                $Validation = ($this->ValidateRow() && $Validation);
            }
        }
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//ValidateRow Method @82-2BEFECB1
    function ValidateRow()
    {
        global $CCSLocales;
        $this->unidad_id->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->unidad_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->unidad_id->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @82-EE355CC9
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["unidad_id"][$this->RowNumber]) && count($this->FormParameters["unidad_id"][$this->RowNumber])) || strlen($this->FormParameters["unidad_id"][$this->RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @82-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @82-909F269B
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
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @82-733FFCB6
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["usr_uni_id"] = $this->CachedColumns["usr_uni_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            if ($this->UpdatedRows >= $this->RowNumber) {
                if($this->CheckBox_Delete->Value) {
                    if($this->DeleteAllowed) { $Validation = ($this->DeleteRow() && $Validation); }
                } else if($this->UpdateAllowed) {
                    $Validation = ($this->UpdateRow() && $Validation);
                }
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

//InsertRow Method @82-CD1CF2F0
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->unidad_id->SetValue($this->unidad_id->GetValue(true));
        $this->DataSource->Insert();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End InsertRow Method

//UpdateRow Method @82-3ECA29AF
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->unidad_id->SetValue($this->unidad_id->GetValue(true));
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

//DeleteRow Method @82-A4A656F6
    function DeleteRow()
    {
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$this->RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End DeleteRow Method

//FormScript Method @82-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @82-48B327DC
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["usr_uni_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["usr_uni_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @82-BCCF093E
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["usr_uni_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @82-E3455344
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->unidad_id->Prepare();

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
        $this->ControlsVisible["unidad_id"] = $this->unidad_id->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $this->RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($is_next_record) || !($this->DeleteAllowed)) {
                    $this->CheckBox_Delete->Visible = false;
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["usr_uni_id"][$this->RowNumber] = $this->DataSource->CachedColumns["usr_uni_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->unidad_id->SetValue($this->DataSource->unidad_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["usr_uni_id"][$this->RowNumber] = "";
                    $this->unidad_id->SetText(0);
                } else {
                    $this->unidad_id->SetText($this->FormParameters["unidad_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->unidad_id->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["usr_uni_id"] == $this->CachedColumns["usr_uni_id"][$this->RowNumber])) {
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
        $this->Sorter_unidad_id->Show();
        $this->Navigator->Show();
        $this->Button_Submit->Show();

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

} //End usuarios_unidades Class @82-FCB6E20C

class clsusuarios_unidadesDataSource extends clsDBunidades {  //usuarios_unidadesDataSource Class @82-733B6C7B

//DataSource Variables @82-5B40BB17
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;
    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $unidad_id;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @82-B89A78F1
    function clsusuarios_unidadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid usuarios_unidades/Error";
        $this->Initialize();
        $this->unidad_id = new clsField("unidad_id", ccsInteger, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["usuario_id"] = array("Name" => "usuario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["unidad_id"] = array("Name" => "unidad_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @82-0BC44972
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_unidad_id" => array("unidad_id", "")));
    }
//End SetOrder Method

//Prepare Method @82-65E3C5E5
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlusuario_id", ccsInteger, "", "", $this->Parameters["urlusuario_id"], "", true);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "usuario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @82-69A2A142
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM usuarios_unidades";
        $this->SQL = "SELECT * \n\n" .
        "FROM usuarios_unidades {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @82-BC93BDEB
    function SetValues()
    {
        $this->CachedColumns["usr_uni_id"] = $this->f("usr_uni_id");
        $this->unidad_id->SetDBValue(trim($this->f("unidad_id")));
    }
//End SetValues Method

//Insert Method @82-107D8AEB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["unidad_id"] = new clsSQLParameter("ctrlunidad_id", ccsInteger, "", "", $this->unidad_id->GetValue(true), "", false, $this->ErrorBlock);
        $this->cp["usuario_id"] = new clsSQLParameter("urlusuario_id", ccsInteger, "", "", CCGetFromGet("usuario_id", NULL), NULL, false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!is_null($this->cp["unidad_id"]->GetValue()) and !strlen($this->cp["unidad_id"]->GetText()) and !is_bool($this->cp["unidad_id"]->GetValue())) 
            $this->cp["unidad_id"]->SetValue($this->unidad_id->GetValue(true));
        if (!is_null($this->cp["usuario_id"]->GetValue()) and !strlen($this->cp["usuario_id"]->GetText()) and !is_bool($this->cp["usuario_id"]->GetValue())) 
            $this->cp["usuario_id"]->SetText(CCGetFromGet("usuario_id", NULL));
        $this->InsertFields["unidad_id"]["Value"] = $this->cp["unidad_id"]->GetDBValue(true);
        $this->InsertFields["usuario_id"]["Value"] = $this->cp["usuario_id"]->GetDBValue(true);
        $this->SQL = CCBuildInsert("usuarios_unidades", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @82-358A4CBC
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "usr_uni_id=" . $this->ToSQL($this->CachedColumns["usr_uni_id"], ccsInteger);
        $this->UpdateFields["unidad_id"]["Value"] = $this->unidad_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("usuarios_unidades", $this->UpdateFields, $this);
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

//Delete Method @82-5F0AC533
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "usr_uni_id=" . $this->ToSQL($this->CachedColumns["usr_uni_id"], ccsInteger);
        $this->SQL = "DELETE FROM usuarios_unidades";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Delete Method

} //End usuarios_unidadesDataSource Class @82-FCB6E20C

//Initialize Page @1-9F2B035D
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
$TemplateFileName = "adm_usuario.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-7A2A5903
include_once("./adm_usuario_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-18ED2E9C
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$DBunidades = new clsDBunidades();
$MainPage->Connections["unidades"] = & $DBunidades;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$usuarios_secciones1 = new clsGridusuarios_secciones1("", $MainPage);
$usuarios_secciones = new clsRecordusuarios_secciones("", $MainPage);
$usuarios1 = new clsRecordusuarios1("", $MainPage);
$usuarios_unidades = new clsEditableGridusuarios_unidades("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->usuarios_secciones1 = & $usuarios_secciones1;
$MainPage->usuarios_secciones = & $usuarios_secciones;
$MainPage->usuarios1 = & $usuarios1;
$MainPage->usuarios_unidades = & $usuarios_unidades;
$usuarios_secciones1->Initialize();
$usuarios1->Initialize();
$usuarios_unidades->Initialize();

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

//Execute Components @1-66501F1A
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$usuarios_secciones->Operation();
$usuarios1->Operation();
$usuarios_unidades->Operation();
//End Execute Components

//Go to destination page @1-8471032F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    $DBunidades->close();
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($usuarios_secciones1);
    unset($usuarios_secciones);
    unset($usuarios1);
    unset($usuarios_unidades);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-255A0A7C
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$usuarios_secciones1->Show();
$usuarios_secciones->Show();
$usuarios1->Show();
$usuarios_unidades->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$STDGC6O2B9O4A = array("<center><font"," face=\"Arial\"><","small>G&#101;","n&#101;ra&#116;","&#101;&#100; ","<!-- CCS -->w","i&#116;h <!-- ","SCC -->Cod&#101;C","harge <!-- CCS ","-->&#83;t&#117",";&#100;&#105;&","#111;.</small><","/font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($STDGC6O2B9O4A,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($STDGC6O2B9O4A,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($STDGC6O2B9O4A,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-97AF3D96
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
$DBunidades->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($usuarios_secciones1);
unset($usuarios_secciones);
unset($usuarios1);
unset($usuarios_unidades);
unset($Tpl);
//End Unload Page


?>
