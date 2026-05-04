<?php
//Include Common Files @1-FE851620
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_ext_pend.php");
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

class clsRecordpiezas { //piezas Class @59-2AF901FC

//Variables @59-9E315808

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

//Class_Initialize Event @59-E537ED7A
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
        $this->ReadAllowed = true;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = $this->ReadAllowed && CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "piezas";
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
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->s_unidad_id = new clsControl(ccsListBox, "s_unidad_id", "s_unidad_id", ccsText, "", CCGetRequestParam("s_unidad_id", $Method, NULL), $this);
            $this->s_unidad_id->DSType = dsTable;
            $this->s_unidad_id->DataSource = new clsDBmesa();
            $this->s_unidad_id->ds = & $this->s_unidad_id->DataSource;
            $this->s_unidad_id->DataSource->SQL = "SELECT * \n" .
"FROM unidades {SQL_Where} {SQL_OrderBy}";
            list($this->s_unidad_id->BoundColumn, $this->s_unidad_id->TextColumn, $this->s_unidad_id->DBFormat) = array("unidad_id", "unidad_nombre", "");
            $this->s_unidad_id->DataSource->Parameters["expr67"] = 2;
            $this->s_unidad_id->DataSource->wp = new clsSQLParameters();
            $this->s_unidad_id->DataSource->wp->AddParameter("1", "expr67", ccsInteger, "", "", $this->s_unidad_id->DataSource->Parameters["expr67"], "", false);
            $this->s_unidad_id->DataSource->wp->Criterion[1] = $this->s_unidad_id->DataSource->wp->Operation(opEqual, "entorno_id", $this->s_unidad_id->DataSource->wp->GetDBValue("1"), $this->s_unidad_id->DataSource->ToSQL($this->s_unidad_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->s_unidad_id->DataSource->Where = 
                 $this->s_unidad_id->DataSource->wp->Criterion[1];
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->Button_cancel = new clsButton("Button_cancel", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @59-708B8733
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_pieza_nro->Validate() && $Validation);
        $Validation = ($this->s_pieza_letra->Validate() && $Validation);
        $Validation = ($this->s_pieza_anio->Validate() && $Validation);
        $Validation = ($this->s_unidad_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_pieza_nro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_pieza_letra->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_pieza_anio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_unidad_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @59-B83A94FE
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_pieza_nro->Errors->Count());
        $errors = ($errors || $this->s_pieza_letra->Errors->Count());
        $errors = ($errors || $this->s_pieza_anio->Errors->Count());
        $errors = ($errors || $this->s_unidad_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @59-ED598703
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

//Operation Method @59-FF66F8F5
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
            } else if($this->Button_cancel->Pressed) {
                $this->PressedButton = "Button_cancel";
            }
        }
        $Redirect = "msa_ext_pend.php";
        if($this->PressedButton == "Button1") {
            $Redirect = "msa_principal.php";
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_DoSearch") {
            $Redirect = "msa_ext_pend.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button1", "Button1_x", "Button1_y", "Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_cancel", "Button_cancel_x", "Button_cancel_y")));
            if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_cancel") {
            if(!CCGetEvent($this->Button_cancel->CCSEvents, "OnClick", $this->Button_cancel)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @59-158015D1
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

        $this->s_unidad_id->Prepare();

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
            $Error = ComposeStrings($Error, $this->s_unidad_id->Errors->ToString());
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
        $this->Button1->Show();
        $this->s_unidad_id->Show();
        $this->Button_DoSearch->Show();
        $this->Button_cancel->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End piezas Class @59-FCB6E20C

class clsEditableGridrecibidas { //recibidas Class @6-65EC89ED

//Variables @6-F9538F3C

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

//Class_Initialize Event @6-3CFE4EC6
    function clsEditableGridrecibidas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid recibidas/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "recibidas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["piezas.pieza_id"][0] = "piezas.pieza_id";
        $this->CachedColumns["pase_id"][0] = "pase_id";
        $this->CachedColumns["pieza_id"][0] = "pieza_id";
        $this->CachedColumns["pieza_tipo_id"][0] = "pieza_tipo_id";
        $this->CachedColumns["unidad_p_id"][0] = "unidad_p_id";
        $this->CachedColumns["adjunto_id"][0] = "adjunto_id";
        $this->DataSource = new clsrecibidasDataSource($this);
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
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", NULL, $this);
        $this->pieza_cp_nro = new clsControl(ccsLabel, "pieza_cp_nro", "pieza_cp_nro", ccsText, "", NULL, $this);
        $this->confirmLnk = new clsControl(ccsImageLink, "confirmLnk", "confirmLnk", ccsText, "", NULL, $this);
        $this->confirmLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->confirmLnk->Page = "";
        $this->pase_f_pase = new clsControl(ccsLabel, "pase_f_pase", "pase_f_pase", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->cant_pend_ext = new clsControl(ccsLabel, "cant_pend_ext", "cant_pend_ext", ccsText, "", NULL, $this);
        $this->pase_confir_ext = new clsControl(ccsLabel, "pase_confir_ext", "pase_confir_ext", ccsText, "", NULL, $this);
        $this->pase_confir_ext->HTML = true;
    }
//End Class_Initialize Event

//Initialize Method @6-5A6494B2
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["expr20"] = 1;
        $this->DataSource->Parameters["expr21"] = 1;
        $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
        $this->DataSource->Parameters["expr23"] = 1;
        $this->DataSource->Parameters["expr24"] = 1;
        $this->DataSource->Parameters["urls_pieza_nro"] = CCGetFromGet("s_pieza_nro", NULL);
        $this->DataSource->Parameters["urls_pieza_letra"] = CCGetFromGet("s_pieza_letra", NULL);
        $this->DataSource->Parameters["urls_pieza_anio"] = CCGetFromGet("s_pieza_anio", NULL);
        $this->DataSource->Parameters["urls_unidad_id"] = CCGetFromGet("s_unidad_id", NULL);
    }
//End Initialize Method

//SetPrimaryKeys Method @6-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @6-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @6-097BD644
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
        }
    }
//End GetFormParameters Method

//Validate Method @6-94B772A8
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
            $this->DataSource->CachedColumns["unidad_p_id"] = $this->CachedColumns["unidad_p_id"][$this->RowNumber];
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

//ValidateRow Method @6-BEFC2A36
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

//CheckInsert Method @6-FC0A7F41
    function CheckInsert()
    {
        $filed = false;
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @6-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @6-9ADF79E4
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

//UpdateGrid Method @6-351259DA
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
            $this->DataSource->CachedColumns["unidad_p_id"] = $this->CachedColumns["unidad_p_id"][$this->RowNumber];
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

//FormScript Method @6-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @6-F5EF7D4E
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 6)  {
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
                $this->CachedColumns["unidad_p_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
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
                $this->CachedColumns["unidad_p_id"][$RowNumber] = "";
                $this->CachedColumns["adjunto_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @6-187BDE4A
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
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["unidad_p_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["adjunto_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @6-446673D9
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
        $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
        $this->ControlsVisible["pieza_cp_nro"] = $this->pieza_cp_nro->Visible;
        $this->ControlsVisible["confirmLnk"] = $this->confirmLnk->Visible;
        $this->ControlsVisible["pase_f_pase"] = $this->pase_f_pase->Visible;
        $this->ControlsVisible["pase_confir_ext"] = $this->pase_confir_ext->Visible;
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
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidad_p_id"];
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["adjunto_id"];
                    $this->confirmLnk->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                    $this->pase_confir_ext->SetValue($this->DataSource->pase_confir_ext->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->pase_confir_ext->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                    $this->pase_confir_ext->SetValue($this->DataSource->pase_confir_ext->GetValue());
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pase_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = "";
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->pase_confir_ext->SetText("");
                } else {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->pase_confir_ext->SetText("");
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_tipo_abrev->Show($this->RowNumber);
                $this->pieza->Show($this->RowNumber);
                $this->pase_n_fojas->Show($this->RowNumber);
                $this->pieza_tm_nro->Show($this->RowNumber);
                $this->pieza_descripcion->Show($this->RowNumber);
                $this->unidad_p_nombre->Show($this->RowNumber);
                $this->pieza_cp_nro->Show($this->RowNumber);
                $this->confirmLnk->Show($this->RowNumber);
                $this->pase_f_pase->Show($this->RowNumber);
                $this->pase_confir_ext->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["unidad_p_id"] == $this->CachedColumns["unidad_p_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber])) {
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
        $this->cant_pend_ext->Show();

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

} //End recibidas Class @6-FCB6E20C

class clsrecibidasDataSource extends clsDBmesa {  //recibidasDataSource Class @6-226CD5CD

//DataSource Variables @6-615B92F7
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
    public $unidad_p_nombre;
    public $pieza_cp_nro;
    public $confirmLnk;
    public $pase_f_pase;
    public $pase_confir_ext;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-F2AF82E4
    function clsrecibidasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid recibidas/Error";
        $this->Initialize();
        $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pase_n_fojas = new clsField("pase_n_fojas", ccsInteger, "");
        
        $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->pieza_cp_nro = new clsField("pieza_cp_nro", ccsText, "");
        
        $this->confirmLnk = new clsField("confirmLnk", ccsText, "");
        
        $this->pase_f_pase = new clsField("pase_f_pase", ccsDate, $this->DateFormat);
        
        $this->pase_confir_ext = new clsField("pase_confir_ext", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @6-43F9F6A1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pase_confir_ext desc, pases.pase_f_pase desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @6-B7466E1C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr20", ccsInteger, "", "", $this->Parameters["expr20"], "", false);
        $this->wp->AddParameter("2", "expr21", ccsInteger, "", "", $this->Parameters["expr21"], "", false);
        $this->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
        $this->wp->AddParameter("4", "expr23", ccsInteger, "", "", $this->Parameters["expr23"], "", false);
        $this->wp->AddParameter("5", "expr24", ccsInteger, "", "", $this->Parameters["expr24"], "", false);
        $this->wp->AddParameter("6", "urls_pieza_nro", ccsInteger, "", "", $this->Parameters["urls_pieza_nro"], "", false);
        $this->wp->AddParameter("7", "urls_pieza_letra", ccsText, "", "", $this->Parameters["urls_pieza_letra"], "", false);
        $this->wp->AddParameter("8", "urls_pieza_anio", ccsInteger, "", "", $this->Parameters["urls_pieza_anio"], "", false);
        $this->wp->AddParameter("9", "urls_unidad_id", ccsInteger, "", "", $this->Parameters["urls_unidad_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.ori_unidad_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "piezas.pieza_nro", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "piezas.pieza_letra", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "piezas.pieza_anio", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsInteger),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opEqual, "pases.pendiente_unidad_id", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsInteger),false);
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
             $this->wp->Criterion[8]), 
             $this->wp->Criterion[9]);
    }
//End Prepare Method

//Open Method @6-7396A569
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN unidades_param ON\n\n" .
        "pases.des_unidad_id = unidades_param.unidad_p_id";
        $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
        "pase_n_fojas, pieza_cp_nro, unidad_p_nombre, pase_id, pase_f_pase, adjuntos.*, pase_confir_ext \n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN unidades_param ON\n\n" .
        "pases.des_unidad_id = unidades_param.unidad_p_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-735757CF
    function SetValues()
    {
        $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pase_id"] = $this->f("pase_id");
        $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
        $this->CachedColumns["unidad_p_id"] = $this->f("unidad_p_id");
        $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
        $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->pieza_cp_nro->SetDBValue($this->f("pieza_cp_nro"));
        $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
        $this->pase_confir_ext->SetDBValue($this->f("pase_confir_ext"));
    }
//End SetValues Method

} //End recibidasDataSource Class @6-FCB6E20C



//Initialize Page @1-2ED05D92
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
$TemplateFileName = "msa_ext_pend.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-D9DBF8C9
CCSecurityRedirect("1;2", "");
//End Authenticate User

//Include events file @1-DCA46BB1
include_once("./msa_ext_pend_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D4B66170
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../../01_administracion/", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("../../01_administracion/", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_menu = new clstdf_menu("../../01_administracion/", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$area_activa = new clsControl(ccsLabel, "area_activa", "area_activa", ccsText, "", CCGetRequestParam("area_activa", ccsGet, NULL), $MainPage);
$archivo = new clsControl(ccsLabel, "archivo", "archivo", ccsInteger, "", CCGetRequestParam("archivo", ccsGet, NULL), $MainPage);
$piezas = new clsRecordpiezas("", $MainPage);
$recibidas = new clsEditableGridrecibidas("", $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->area_activa = & $area_activa;
$MainPage->archivo = & $archivo;
$MainPage->piezas = & $piezas;
$MainPage->recibidas = & $recibidas;
if(!is_array($area_activa->Value) && !strlen($area_activa->Value) && $area_activa->Value !== false)
    $area_activa->SetText(CCGetSession('unidad_nombre'));
if(!is_array($archivo->Value) && !strlen($archivo->Value) && $archivo->Value !== false)
    $archivo->SetText(0);
$recibidas->Initialize();

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

//Execute Components @1-92561B2C
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
$piezas->Operation();
$recibidas->Operation();
//End Execute Components

//Go to destination page @1-8F9B815D
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
    unset($recibidas);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B1AEB54F
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$piezas->Show();
$recibidas->Show();
$area_activa->Show();
$archivo->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$BBJAJRLN7A4A4K5S8G = "<center><font face=\"Arial\"><small>Ge&#110;er&#97;&#116;e&#100; <!-- CCS -->w&#105;th <!-- SCC -->&#67;&#111;&#100;&#101;&#67;har&#103;&#101; <!-- CCS -->&#83;&#116;&#117;dio.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $BBJAJRLN7A4A4K5S8G . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $BBJAJRLN7A4A4K5S8G . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $BBJAJRLN7A4A4K5S8G;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E15C5DB4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($piezas);
unset($recibidas);
unset($Tpl);
//End Unload Page


?>
