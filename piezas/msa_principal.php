<?php
//Include Common Files @1-ECEA8606
define("RelativePath", "..");
define("PathToCurrentPage", "/piezas/");
define("FileName", "msa_principal.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsMenuMenu1 extends clsMenu { //Menu1 class @2-FEAC4CDE

//Class_Initialize Event @2-BBA014FD
    function clsMenuMenu1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "Menu1";
        $this->Visible = True;
        $this->controls = array();
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->ErrorBlock = "Menu Menu1";

        $this->StaticItems = array();
        $this->StaticItems[] = array("item_id" => "MenuItem1", "item_id_parent" => null, "item_caption" => "Crear", "item_url" => array("Page" => "", "Parameters" => null), "item_target" => "", "item_title" => "Alta de Piezas");
        $this->StaticItems[] = array("item_id" => "MenuItem1Item1", "item_id_parent" => "MenuItem1", "item_caption" => "Expediente", "item_url" => array("Page" => "msa_altaExp.php", "Parameters" => null), "item_target" => "", "item_title" => "Nuevo expediente");
        $this->StaticItems[] = array("item_id" => "MenuItem1Item2", "item_id_parent" => "MenuItem1", "item_caption" => "Nota", "item_url" => array("Page" => "msa_altaNota.php", "Parameters" => null), "item_target" => "", "item_title" => "Nueva Nota");
        $this->StaticItems[] = array("item_id" => "MenuItem1Item3", "item_id_parent" => "MenuItem1", "item_caption" => "Pieza Externa", "item_url" => array("Page" => "msa_altaPiezaExt.php", "Parameters" => null), "item_target" => "", "item_title" => "Nueva Pieza Externa");
        $this->StaticItems[] = array("item_id" => "MenuItem2", "item_id_parent" => null, "item_caption" => "Consultas", "item_url" => array("Page" => "msa_gralPiezas.php", "Parameters" => null), "item_target" => "", "item_title" => "Consulta Genral de Piezas");
        $this->StaticItems[] = array("item_id" => "MenuItem10", "item_id_parent" => null, "item_caption" => "Cambiar Area", "item_url" => array("Page" => "msa_preppal.php", "Parameters" => null), "item_target" => "", "item_title" => "Trabajar con otra area");
        $this->StaticItems[] = array("item_id" => "MenuItem8", "item_id_parent" => null, "item_caption" => "Archivo", "item_url" => array("Page" => "msa_archivo.php", "Parameters" => null), "item_target" => "", "item_title" => "Archivo de Piezas");

        $this->DataSource = new clsMenu1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->DataSource->SetProvider(array("DBLib" => "Array"));

        parent::clsMenu("item_id_parent", "item_id", null);

        $this->ItemLink = new clsControl(ccsLink, "ItemLink", "ItemLink", ccsText, "", CCGetRequestParam("ItemLink", ccsGet, NULL), $this);
        $this->controls["ItemLink"] = & $this->ItemLink;
        $this->ItemLink->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->ItemLink->Page = "";
        $this->LinkStartParameters = $this->ItemLink->Parameters;
    }
//End Class_Initialize Event

//SetControlValues Method @2-B7BF812B
    function SetControlValues() {
        $this->ItemLink->SetValue($this->DataSource->ItemLink->GetValue());
        $LinkUrl = $this->DataSource->f("item_url");
        $this->ItemLink->Page = $LinkUrl["Page"];
        $this->ItemLink->Parameters = $this->SetParamsFromDB($this->LinkStartParameters, $LinkUrl["Parameters"]);
    }
//End SetControlValues Method

//ShowAttributes @2-045A7B9A
    function ShowAttributes() {
        $this->Attributes->SetValue("MenuType", "menu_vlr");
        $this->Attributes->Show();
    }
//End ShowAttributes

} //End Menu1 Class @2-FCB6E20C

//Menu1DataSource Class @2-201CC8D7
class clsMenu1DataSource extends DB_Adapter {
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;
    var $wp;
    var $Record = array();
    var $Index;
    var $FieldsList = array();

    function clsMenu1DataSource($parent) {
        $this->Parent = & $parent;
        $this->ErrorBlock = "Menu Menu1";
        $this->ItemLink = new clsField("ItemLink", ccsText, "");
        $this->FieldsList["ItemLink"] = & $this->ItemLink;
    }

    function Prepare()
    {
    }

    function Open()
    {
        $this->query($this->Parent->StaticItems);
    }

    function SetValues()
    {
        $this->ItemLink->SetDBValue($this->f("item_caption"));
    }
}
//End Menu1DataSource Class

//Include Page implementation @366-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @367-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @368-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

class clsEditableGridenviadas { //enviadas Class @20-36394385

//Variables @20-F9538F3C

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

//Class_Initialize Event @20-5DD0C2DE
    function clsEditableGridenviadas($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid enviadas/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "enviadas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["piezas.pieza_id"][0] = "piezas.pieza_id";
        $this->CachedColumns["pase_id"][0] = "pase_id";
        $this->CachedColumns["pieza_id"][0] = "pieza_id";
        $this->CachedColumns["pieza_tipo_id"][0] = "pieza_tipo_id";
        $this->CachedColumns["unidad_p_id"][0] = "unidad_p_id";
        $this->CachedColumns["adjunto_id"][0] = "adjunto_id";
        $this->CachedColumns["entorno_id"][0] = "entorno_id";
        $this->DataSource = new clsenviadasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
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

        $this->pieza = new clsControl(ccsLabel, "pieza", "Pieza", ccsText, "", NULL, $this);
        $this->pase_n_fojas = new clsControl(ccsLabel, "pase_n_fojas", "Pase N Fojas", ccsInteger, "", NULL, $this);
        $this->pieza_tm_nro = new clsControl(ccsLabel, "pieza_tm_nro", "Pieza Tm Nro", ccsInteger, "", NULL, $this);
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "Pieza Descripcion", ccsText, "", NULL, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", NULL, $this);
        $this->pieza_tipo_abrev = new clsControl(ccsLabel, "pieza_tipo_abrev", "Pieza Tipo Abrev", ccsText, "", NULL, $this);
        $this->pieza_cp_nro = new clsControl(ccsLabel, "pieza_cp_nro", "pieza_cp_nro", ccsText, "", NULL, $this);
        $this->canceLnk = new clsControl(ccsImageLink, "canceLnk", "canceLnk", ccsText, "", NULL, $this);
        $this->canceLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->canceLnk->Page = "";
        $this->pase_f_pase = new clsControl(ccsLabel, "pase_f_pase", "pase_f_pase", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", NULL, $this);
        $this->entorno_abrev = new clsControl(ccsLabel, "entorno_abrev", "entorno_abrev", ccsText, "", NULL, $this);
        $this->pase_comentario = new clsControl(ccsLabel, "pase_comentario", "pase_comentario", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @20-0828C7DA
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["expr145"] = 1;
        $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
        $this->DataSource->Parameters["expr147"] = 0;
        $this->DataSource->Parameters["expr206"] = 1;
        $this->DataSource->Parameters["expr344"] = 1;
    }
//End Initialize Method

//SetPrimaryKeys Method @20-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @20-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @20-097BD644
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
        }
    }
//End GetFormParameters Method

//Validate Method @20-331A3BB8
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
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
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

//ValidateRow Method @20-BEFC2A36
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

//CheckInsert Method @20-FC0A7F41
    function CheckInsert()
    {
        $filed = false;
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @20-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @20-9ADF79E4
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

//UpdateGrid Method @20-67C1FABD
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
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
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

//FormScript Method @20-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @20-06093C9B
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 7)  {
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
                $piece = $pieces[$i + 6];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["entorno_id"][$RowNumber] = $piece;
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
                $this->CachedColumns["entorno_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @20-AC6322AA
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
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["entorno_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @20-DE9C9969
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
        $this->ControlsVisible["pieza"] = $this->pieza->Visible;
        $this->ControlsVisible["pase_n_fojas"] = $this->pase_n_fojas->Visible;
        $this->ControlsVisible["pieza_tm_nro"] = $this->pieza_tm_nro->Visible;
        $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
        $this->ControlsVisible["unidad_p_nombre"] = $this->unidad_p_nombre->Visible;
        $this->ControlsVisible["pieza_tipo_abrev"] = $this->pieza_tipo_abrev->Visible;
        $this->ControlsVisible["pieza_cp_nro"] = $this->pieza_cp_nro->Visible;
        $this->ControlsVisible["canceLnk"] = $this->canceLnk->Visible;
        $this->ControlsVisible["pase_f_pase"] = $this->pase_f_pase->Visible;
        $this->ControlsVisible["entorno_abrev"] = $this->entorno_abrev->Visible;
        $this->ControlsVisible["pase_comentario"] = $this->pase_comentario->Visible;
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
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = $this->DataSource->CachedColumns["entorno_id"];
                    $this->canceLnk->SetText("");
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->pase_comentario->SetValue($this->DataSource->pase_comentario->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->canceLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->pase_comentario->SetText("");
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->pase_comentario->SetValue($this->DataSource->pase_comentario->GetValue());
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pase_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = "";
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = "";
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->canceLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->pase_comentario->SetText("");
                } else {
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->canceLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->pase_comentario->SetText("");
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza->Show($this->RowNumber);
                $this->pase_n_fojas->Show($this->RowNumber);
                $this->pieza_tm_nro->Show($this->RowNumber);
                $this->pieza_descripcion->Show($this->RowNumber);
                $this->unidad_p_nombre->Show($this->RowNumber);
                $this->pieza_tipo_abrev->Show($this->RowNumber);
                $this->pieza_cp_nro->Show($this->RowNumber);
                $this->canceLnk->Show($this->RowNumber);
                $this->pase_f_pase->Show($this->RowNumber);
                $this->entorno_abrev->Show($this->RowNumber);
                $this->pase_comentario->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["unidad_p_id"] == $this->CachedColumns["unidad_p_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["entorno_id"] == $this->CachedColumns["entorno_id"][$this->RowNumber])) {
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
        $this->Label1->Show();

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

} //End enviadas Class @20-FCB6E20C

class clsenviadasDataSource extends clsDBmesa {  //enviadasDataSource Class @20-0F4FC9A6

//DataSource Variables @20-F63C9B0D
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
    public $pieza;
    public $pase_n_fojas;
    public $pieza_tm_nro;
    public $pieza_descripcion;
    public $unidad_p_nombre;
    public $pieza_tipo_abrev;
    public $pieza_cp_nro;
    public $canceLnk;
    public $pase_f_pase;
    public $entorno_abrev;
    public $pase_comentario;
//End DataSource Variables

//DataSourceClass_Initialize Event @20-10BAD715
    function clsenviadasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid enviadas/Error";
        $this->Initialize();
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pase_n_fojas = new clsField("pase_n_fojas", ccsInteger, "");
        
        $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->unidad_p_nombre = new clsField("unidad_p_nombre", ccsText, "");
        
        $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
        
        $this->pieza_cp_nro = new clsField("pieza_cp_nro", ccsText, "");
        
        $this->canceLnk = new clsField("canceLnk", ccsText, "");
        
        $this->pase_f_pase = new clsField("pase_f_pase", ccsDate, $this->DateFormat);
        
        $this->entorno_abrev = new clsField("entorno_abrev", ccsText, "");
        
        $this->pase_comentario = new clsField("pase_comentario", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @20-C2E9B71C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pases.pase_f_pase desc, pase_id desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @20-EFB60997
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr145", ccsInteger, "", "", $this->Parameters["expr145"], "", false);
        $this->wp->AddParameter("2", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
        $this->wp->AddParameter("3", "expr147", ccsInteger, "", "", $this->Parameters["expr147"], "", false);
        $this->wp->AddParameter("4", "expr206", ccsInteger, "", "", $this->Parameters["expr206"], "", false);
        $this->wp->AddParameter("5", "expr344", ccsInteger, "", "", $this->Parameters["expr344"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.ori_unidad_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
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

//Open Method @20-3EB0F7AE
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((piezas INNER JOIN pases ON\n\n" .
        "piezas.pieza_id = pases.pieza_id) LEFT JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) LEFT JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id) INNER JOIN unidades_param ON\n\n" .
        "pases.des_unidad_id = unidades_param.unidad_id";
        $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
        "pase_n_fojas, unidad_p_nombre, pieza_cp_nro, pase_id, pase_f_pase, adjuntos.*, entorno_abrev, pase_comentario \n\n" .
        "FROM ((((piezas INNER JOIN pases ON\n\n" .
        "piezas.pieza_id = pases.pieza_id) LEFT JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) LEFT JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id) INNER JOIN unidades_param ON\n\n" .
        "pases.des_unidad_id = unidades_param.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @20-14BF5894
    function SetValues()
    {
        $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pase_id"] = $this->f("pase_id");
        $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
        $this->CachedColumns["unidad_p_id"] = $this->f("unidad_p_id");
        $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
        $this->CachedColumns["entorno_id"] = $this->f("entorno_id");
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
        $this->pieza_cp_nro->SetDBValue($this->f("pieza_cp_nro"));
        $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
        $this->entorno_abrev->SetDBValue($this->f("entorno_abrev"));
        $this->pase_comentario->SetDBValue($this->f("pase_comentario"));
    }
//End SetValues Method

} //End enviadasDataSource Class @20-FCB6E20C

class clsEditableGridrecibidas { //recibidas Class @80-65EC89ED

//Variables @80-F9538F3C

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

//Class_Initialize Event @80-8FFFA9F7
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
        $this->CachedColumns["entorno_id"][0] = "entorno_id";
        $this->DataSource = new clsrecibidasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
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
        $this->unidad_p_nombre = new clsControl(ccsLabel, "unidad_p_nombre", "unidad_p_nombre", ccsText, "", NULL, $this);
        $this->pieza_cp_nro = new clsControl(ccsLabel, "pieza_cp_nro", "pieza_cp_nro", ccsText, "", NULL, $this);
        $this->confirmLnk = new clsControl(ccsImageLink, "confirmLnk", "confirmLnk", ccsText, "", NULL, $this);
        $this->confirmLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->confirmLnk->Page = "";
        $this->pase_f_pase = new clsControl(ccsLabel, "pase_f_pase", "pase_f_pase", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", NULL, $this);
        $this->entorno_abrev = new clsControl(ccsLabel, "entorno_abrev", "entorno_abrev", ccsText, "", NULL, $this);
        $this->pase_comentario = new clsControl(ccsLabel, "pase_comentario", "pase_comentario", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @80-6C72DA99
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["expr148"] = 1;
        $this->DataSource->Parameters["expr149"] = 0;
        $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
        $this->DataSource->Parameters["expr216"] = 1;
        $this->DataSource->Parameters["expr334"] = 1;
    }
//End Initialize Method

//SetPrimaryKeys Method @80-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @80-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @80-097BD644
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
        }
    }
//End GetFormParameters Method

//Validate Method @80-331A3BB8
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
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
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

//ValidateRow Method @80-BEFC2A36
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

//CheckInsert Method @80-FC0A7F41
    function CheckInsert()
    {
        $filed = false;
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @80-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @80-9ADF79E4
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

//UpdateGrid Method @80-67C1FABD
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
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
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

//FormScript Method @80-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @80-06093C9B
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 7)  {
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
                $piece = $pieces[$i + 6];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["entorno_id"][$RowNumber] = $piece;
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
                $this->CachedColumns["entorno_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @80-AC6322AA
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
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["entorno_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @80-1D51A8F7
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
        $this->ControlsVisible["entorno_abrev"] = $this->entorno_abrev->Visible;
        $this->ControlsVisible["pase_comentario"] = $this->pase_comentario->Visible;
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
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = $this->DataSource->CachedColumns["entorno_id"];
                    $this->confirmLnk->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->pase_comentario->SetValue($this->DataSource->pase_comentario->GetValue());
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
                    $this->entorno_abrev->SetText("");
                    $this->pase_comentario->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->unidad_p_nombre->SetValue($this->DataSource->unidad_p_nombre->GetValue());
                    $this->pieza_cp_nro->SetValue($this->DataSource->pieza_cp_nro->GetValue());
                    $this->pase_f_pase->SetValue($this->DataSource->pase_f_pase->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->pase_comentario->SetValue($this->DataSource->pase_comentario->GetValue());
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pase_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["unidad_p_id"][$this->RowNumber] = "";
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = "";
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->unidad_p_nombre->SetText("");
                    $this->pieza_cp_nro->SetText("");
                    $this->confirmLnk->SetText("");
                    $this->pase_f_pase->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->pase_comentario->SetText("");
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
                    $this->entorno_abrev->SetText("");
                    $this->pase_comentario->SetText("");
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
                $this->entorno_abrev->Show($this->RowNumber);
                $this->pase_comentario->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["unidad_p_id"] == $this->CachedColumns["unidad_p_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["entorno_id"] == $this->CachedColumns["entorno_id"][$this->RowNumber])) {
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
        $this->Label1->Show();

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

} //End recibidas Class @80-FCB6E20C

class clsrecibidasDataSource extends clsDBmesa {  //recibidasDataSource Class @80-226CD5CD

//DataSource Variables @80-A003BF80
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
    public $entorno_abrev;
    public $pase_comentario;
//End DataSource Variables

//DataSourceClass_Initialize Event @80-A5F1F395
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
        
        $this->entorno_abrev = new clsField("entorno_abrev", ccsText, "");
        
        $this->pase_comentario = new clsField("pase_comentario", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @80-C2E9B71C
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pases.pase_f_pase desc, pase_id desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @80-7D14CEDC
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr148", ccsInteger, "", "", $this->Parameters["expr148"], "", false);
        $this->wp->AddParameter("2", "expr149", ccsInteger, "", "", $this->Parameters["expr149"], "", false);
        $this->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
        $this->wp->AddParameter("4", "expr216", ccsInteger, "", "", $this->Parameters["expr216"], "", false);
        $this->wp->AddParameter("5", "expr334", ccsInteger, "", "", $this->Parameters["expr334"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.des_unidad_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "unidades_param.unidad_p_activo", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
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

//Open Method @80-FD75E9BD
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) LEFT JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) LEFT JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id) INNER JOIN unidades_param ON\n\n" .
        "pases.ori_unidad_id = unidades_param.unidad_id";
        $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
        "pase_n_fojas, pieza_cp_nro, unidad_p_nombre, pase_id, pase_f_pase, adjuntos.*, entorno_abrev, pase_comentario \n\n" .
        "FROM ((((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) LEFT JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) LEFT JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id) INNER JOIN unidades_param ON\n\n" .
        "pases.ori_unidad_id = unidades_param.unidad_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @80-8E9ABB5F
    function SetValues()
    {
        $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pase_id"] = $this->f("pase_id");
        $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
        $this->CachedColumns["unidad_p_id"] = $this->f("unidad_p_id");
        $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
        $this->CachedColumns["entorno_id"] = $this->f("entorno_id");
        $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->unidad_p_nombre->SetDBValue($this->f("unidad_p_nombre"));
        $this->pieza_cp_nro->SetDBValue($this->f("pieza_cp_nro"));
        $this->pase_f_pase->SetDBValue(trim($this->f("pase_f_pase")));
        $this->entorno_abrev->SetDBValue($this->f("entorno_abrev"));
        $this->pase_comentario->SetDBValue($this->f("pase_comentario"));
    }
//End SetValues Method

} //End recibidasDataSource Class @80-FCB6E20C

class clsEditableGridarea { //area Class @102-31688929

//Variables @102-F9538F3C

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

//Class_Initialize Event @102-196076EF
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
        $this->CachedColumns["entorno_id"][0] = "entorno_id";
        $this->DataSource = new clsareaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
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
        $this->pieza_descripcion = new clsControl(ccsLabel, "pieza_descripcion", "Pieza Descripcion", ccsText, "", NULL, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->paseLnk = new clsControl(ccsImageLink, "paseLnk", "paseLnk", ccsText, "", NULL, $this);
        $this->paseLnk->Page = "msa_pase.php";
        $this->rutaLnk = new clsControl(ccsImageLink, "rutaLnk", "rutaLnk", ccsText, "", NULL, $this);
        $this->rutaLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->rutaLnk->Page = "";
        $this->ImageLink1 = new clsControl(ccsImageLink, "ImageLink1", "ImageLink1", ccsText, "", NULL, $this);
        $this->ImageLink1->Page = "msa_viewPieza.php";
        $this->pieza_f_alta = new clsControl(ccsLabel, "pieza_f_alta", "pieza_f_alta", ccsDate, $DefaultDateFormat, NULL, $this);
        $this->archLnk = new clsControl(ccsImageLink, "archLnk", "archLnk", ccsText, "", NULL, $this);
        $this->archLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->archLnk->Page = "";
        $this->adjLnk = new clsControl(ccsImageLink, "adjLnk", "adjLnk", ccsText, "", NULL, $this);
        $this->adjLnk->Page = "";
        $this->entorno_abrev = new clsControl(ccsLabel, "entorno_abrev", "entorno_abrev", ccsText, "", NULL, $this);
        $this->adjAddLnk = new clsControl(ccsImageLink, "adjAddLnk", "adjAddLnk", ccsText, "", NULL, $this);
        $this->adjAddLnk->Page = "msa_adjuntar.php";
        $this->tmoAddLnk = new clsControl(ccsImageLink, "tmoAddLnk", "tmoAddLnk", ccsText, "", NULL, $this);
        $this->tmoAddLnk->Page = "";
        $this->pieza_tm_nro = new clsControl(ccsLabel, "pieza_tm_nro", "Pieza Tm Nro", ccsInteger, "", NULL, $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @102-1E437FE7
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["expr151"] = 1;
        $this->DataSource->Parameters["expr152"] = 1;
        $this->DataSource->Parameters["sesunidad_id"] = CCGetSession("unidad_id", NULL);
        $this->DataSource->Parameters["expr296"] = 1;
        $this->DataSource->Parameters["expr388"] = 1;
    }
//End Initialize Method

//SetPrimaryKeys Method @102-EBC3F86C
    function SetPrimaryKeys($PrimaryKeys) {
        $this->PrimaryKeys = $PrimaryKeys;
        return $this->PrimaryKeys;
    }
//End SetPrimaryKeys Method

//GetPrimaryKeys Method @102-74F9A772
    function GetPrimaryKeys() {
        return $this->PrimaryKeys;
    }
//End GetPrimaryKeys Method

//GetFormParameters Method @102-097BD644
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
        }
    }
//End GetFormParameters Method

//Validate Method @102-B7BD652E
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
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
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

//ValidateRow Method @102-BEFC2A36
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

//CheckInsert Method @102-FC0A7F41
    function CheckInsert()
    {
        $filed = false;
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @102-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @102-9ADF79E4
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

//UpdateGrid Method @102-831C0E87
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
            $this->DataSource->CachedColumns["entorno_id"] = $this->CachedColumns["entorno_id"][$this->RowNumber];
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

//FormScript Method @102-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @102-8C69E069
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
                $this->CachedColumns["adjunto_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["entorno_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["piezas.pieza_id"][$RowNumber] = "";
                $this->CachedColumns["pase_id"][$RowNumber] = "";
                $this->CachedColumns["pieza_id"][$RowNumber] = "";
                $this->CachedColumns["pieza_tipo_id"][$RowNumber] = "";
                $this->CachedColumns["adjunto_id"][$RowNumber] = "";
                $this->CachedColumns["entorno_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @102-7D1B7353
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
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["entorno_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @102-204253FD
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
        $this->ControlsVisible["pieza_descripcion"] = $this->pieza_descripcion->Visible;
        $this->ControlsVisible["paseLnk"] = $this->paseLnk->Visible;
        $this->ControlsVisible["rutaLnk"] = $this->rutaLnk->Visible;
        $this->ControlsVisible["ImageLink1"] = $this->ImageLink1->Visible;
        $this->ControlsVisible["pieza_f_alta"] = $this->pieza_f_alta->Visible;
        $this->ControlsVisible["archLnk"] = $this->archLnk->Visible;
        $this->ControlsVisible["adjLnk"] = $this->adjLnk->Visible;
        $this->ControlsVisible["entorno_abrev"] = $this->entorno_abrev->Visible;
        $this->ControlsVisible["adjAddLnk"] = $this->adjAddLnk->Visible;
        $this->ControlsVisible["tmoAddLnk"] = $this->tmoAddLnk->Visible;
        $this->ControlsVisible["pieza_tm_nro"] = $this->pieza_tm_nro->Visible;
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
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = $this->DataSource->CachedColumns["entorno_id"];
                    $this->paseLnk->SetText("");
                    $this->rutaLnk->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->archLnk->SetText("");
                    $this->adjLnk->SetText("");
                    $this->adjAddLnk->SetText("");
                    $this->tmoAddLnk->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->paseLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
                    $this->ImageLink1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                    $this->adjLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                    $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->adjAddLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                    $this->adjAddLnk->Parameters = CCAddParam($this->adjAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->tmoAddLnk->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                    $this->tmoAddLnk->Parameters = CCAddParam($this->tmoAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->paseLnk->SetText("");
                    $this->rutaLnk->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->pieza_f_alta->SetText("");
                    $this->archLnk->SetText("");
                    $this->adjLnk->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->adjAddLnk->SetText("");
                    $this->tmoAddLnk->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->pieza_tipo_abrev->SetValue($this->DataSource->pieza_tipo_abrev->GetValue());
                    $this->pieza->SetValue($this->DataSource->pieza->GetValue());
                    $this->pase_n_fojas->SetValue($this->DataSource->pase_n_fojas->GetValue());
                    $this->pieza_descripcion->SetValue($this->DataSource->pieza_descripcion->GetValue());
                    $this->pieza_f_alta->SetValue($this->DataSource->pieza_f_alta->GetValue());
                    $this->entorno_abrev->SetValue($this->DataSource->entorno_abrev->GetValue());
                    $this->pieza_tm_nro->SetValue($this->DataSource->pieza_tm_nro->GetValue());
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->adjAddLnk->Parameters = CCAddParam($this->adjAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->tmoAddLnk->Parameters = CCAddParam($this->tmoAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["piezas.pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pase_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_id"][$this->RowNumber] = "";
                    $this->CachedColumns["pieza_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["adjunto_id"][$this->RowNumber] = "";
                    $this->CachedColumns["entorno_id"][$this->RowNumber] = "";
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->paseLnk->SetText("");
                    $this->rutaLnk->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->pieza_f_alta->SetText("");
                    $this->archLnk->SetText("");
                    $this->adjLnk->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->adjAddLnk->SetText("");
                    $this->tmoAddLnk->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->adjAddLnk->Parameters = CCAddParam($this->adjAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->tmoAddLnk->Parameters = CCAddParam($this->tmoAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                } else {
                    $this->pieza_tipo_abrev->SetText("");
                    $this->pieza->SetText("");
                    $this->pase_n_fojas->SetText("");
                    $this->pieza_descripcion->SetText("");
                    $this->paseLnk->SetText("");
                    $this->rutaLnk->SetText("");
                    $this->ImageLink1->SetText("");
                    $this->pieza_f_alta->SetText("");
                    $this->archLnk->SetText("");
                    $this->adjLnk->SetText("");
                    $this->entorno_abrev->SetText("");
                    $this->adjAddLnk->SetText("");
                    $this->tmoAddLnk->SetText("");
                    $this->pieza_tm_nro->SetText("");
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->paseLnk->Parameters = CCAddParam($this->paseLnk->Parameters, "tipo_tramites_id", $this->DataSource->f("tipo_tramites_id"));
                    $this->ImageLink1->Parameters = CCAddParam($this->ImageLink1->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->adjLnk->Parameters = CCAddParam($this->adjLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->adjAddLnk->Parameters = CCAddParam($this->adjAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                    $this->tmoAddLnk->Parameters = CCAddParam($this->tmoAddLnk->Parameters, "pieza_id", $this->DataSource->f("pieza_id"));
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->pieza_tipo_abrev->Show($this->RowNumber);
                $this->pieza->Show($this->RowNumber);
                $this->pase_n_fojas->Show($this->RowNumber);
                $this->pieza_descripcion->Show($this->RowNumber);
                $this->paseLnk->Show($this->RowNumber);
                $this->rutaLnk->Show($this->RowNumber);
                $this->ImageLink1->Show($this->RowNumber);
                $this->pieza_f_alta->Show($this->RowNumber);
                $this->archLnk->Show($this->RowNumber);
                $this->adjLnk->Show($this->RowNumber);
                $this->entorno_abrev->Show($this->RowNumber);
                $this->adjAddLnk->Show($this->RowNumber);
                $this->tmoAddLnk->Show($this->RowNumber);
                $this->pieza_tm_nro->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["piezas.pieza_id"] == $this->CachedColumns["piezas.pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pase_id"] == $this->CachedColumns["pase_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_id"] == $this->CachedColumns["pieza_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["pieza_tipo_id"] == $this->CachedColumns["pieza_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["adjunto_id"] == $this->CachedColumns["adjunto_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["entorno_id"] == $this->CachedColumns["entorno_id"][$this->RowNumber])) {
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
        $this->Label1->Show();

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

} //End area Class @102-FCB6E20C

class clsareaDataSource extends clsDBmesa {  //areaDataSource Class @102-D8CC5B5C

//DataSource Variables @102-8549A438
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
    public $pieza_descripcion;
    public $paseLnk;
    public $rutaLnk;
    public $ImageLink1;
    public $pieza_f_alta;
    public $archLnk;
    public $adjLnk;
    public $entorno_abrev;
    public $adjAddLnk;
    public $tmoAddLnk;
    public $pieza_tm_nro;
//End DataSource Variables

//DataSourceClass_Initialize Event @102-2474891C
    function clsareaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid area/Error";
        $this->Initialize();
        $this->pieza_tipo_abrev = new clsField("pieza_tipo_abrev", ccsText, "");
        
        $this->pieza = new clsField("pieza", ccsText, "");
        
        $this->pase_n_fojas = new clsField("pase_n_fojas", ccsInteger, "");
        
        $this->pieza_descripcion = new clsField("pieza_descripcion", ccsText, "");
        
        $this->paseLnk = new clsField("paseLnk", ccsText, "");
        
        $this->rutaLnk = new clsField("rutaLnk", ccsText, "");
        
        $this->ImageLink1 = new clsField("ImageLink1", ccsText, "");
        
        $this->pieza_f_alta = new clsField("pieza_f_alta", ccsDate, $this->DateFormat);
        
        $this->archLnk = new clsField("archLnk", ccsText, "");
        
        $this->adjLnk = new clsField("adjLnk", ccsText, "");
        
        $this->entorno_abrev = new clsField("entorno_abrev", ccsText, "");
        
        $this->adjAddLnk = new clsField("adjAddLnk", ccsText, "");
        
        $this->tmoAddLnk = new clsField("tmoAddLnk", ccsText, "");
        
        $this->pieza_tm_nro = new clsField("pieza_tm_nro", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @102-A9206C1F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "pases.pase_f_pase desc, piezas.pieza_tm_nro desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @102-FEF62E3E
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr151", ccsInteger, "", "", $this->Parameters["expr151"], "", false);
        $this->wp->AddParameter("2", "expr152", ccsInteger, "", "", $this->Parameters["expr152"], "", false);
        $this->wp->AddParameter("3", "sesunidad_id", ccsInteger, "", "", $this->Parameters["sesunidad_id"], "", false);
        $this->wp->AddParameter("4", "expr296", ccsInteger, "", "", $this->Parameters["expr296"], "", false);
        $this->wp->AddParameter("5", "expr388", ccsInteger, "", "", $this->Parameters["expr388"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "pases.pase_confirmado", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "pases.pase_activo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "pases.des_unidad_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opIsNull, "adjuntos.adjunto_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opNotEqual, "piezas.pieza_archivada", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
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

//Open Method @102-C0BD8E62
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id";
        $this->SQL = "SELECT pieza_tipo_abrev, piezas.pieza_id AS pieza_id, CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) AS pieza, pieza_tm_nro, pieza_descripcion,\n\n" .
        "pase_n_fojas, pieza_f_alta, entorno_abrev, piezas_tipos.pieza_tipo_id AS pieza_tipo_id, tipo_tramites_id, unidad_id \n\n" .
        "FROM (((piezas INNER JOIN pases ON\n\n" .
        "pases.pieza_id = piezas.pieza_id) INNER JOIN piezas_tipos ON\n\n" .
        "piezas.pieza_tipo_id = piezas_tipos.pieza_tipo_id) LEFT JOIN adjuntos ON\n\n" .
        "piezas.pieza_id = adjuntos.adj_pieza_id) INNER JOIN entornos ON\n\n" .
        "piezas.entorno_id = entornos.entorno_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @102-D67A1F4D
    function SetValues()
    {
        $this->CachedColumns["piezas.pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pase_id"] = $this->f("pase_id");
        $this->CachedColumns["pieza_id"] = $this->f("pieza_id");
        $this->CachedColumns["pieza_tipo_id"] = $this->f("pieza_tipo_id");
        $this->CachedColumns["adjunto_id"] = $this->f("adjunto_id");
        $this->CachedColumns["entorno_id"] = $this->f("entorno_id");
        $this->pieza_tipo_abrev->SetDBValue($this->f("pieza_tipo_abrev"));
        $this->pieza->SetDBValue($this->f("pieza"));
        $this->pase_n_fojas->SetDBValue(trim($this->f("pase_n_fojas")));
        $this->pieza_descripcion->SetDBValue($this->f("pieza_descripcion"));
        $this->pieza_f_alta->SetDBValue(trim($this->f("pieza_f_alta")));
        $this->entorno_abrev->SetDBValue($this->f("entorno_abrev"));
        $this->pieza_tm_nro->SetDBValue(trim($this->f("pieza_tm_nro")));
    }
//End SetValues Method

} //End areaDataSource Class @102-FCB6E20C

//Initialize Page @1-C707F245
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
$TemplateFileName = "msa_principal.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-98910CB0
include_once("./msa_principal_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-8F037114
$DBmesa = new clsDBmesa();
$MainPage->Connections["mesa"] = & $DBmesa;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Menu1 = new clsMenuMenu1("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$area_activa = new clsControl(ccsLabel, "area_activa", "area_activa", ccsText, "", CCGetRequestParam("area_activa", ccsGet, NULL), $MainPage);
$archivo = new clsControl(ccsLabel, "archivo", "archivo", ccsInteger, "", CCGetRequestParam("archivo", ccsGet, NULL), $MainPage);
$enviadas = new clsEditableGridenviadas("", $MainPage);
$recibidas = new clsEditableGridrecibidas("", $MainPage);
$area = new clsEditableGridarea("", $MainPage);
$Panel1 = new clsPanel("Panel1", $MainPage);
$cant_ext_pend = new clsControl(ccsLabel, "cant_ext_pend", "cant_ext_pend", ccsText, "", CCGetRequestParam("cant_ext_pend", ccsGet, NULL), $MainPage);
$Link_ext = new clsControl(ccsLink, "Link_ext", "Link_ext", ccsText, "", CCGetRequestParam("Link_ext", ccsGet, NULL), $MainPage);
$Link_ext->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
$Link_ext->Page = "msa_ext_pend.php";
$MainPage->Menu1 = & $Menu1;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->area_activa = & $area_activa;
$MainPage->archivo = & $archivo;
$MainPage->enviadas = & $enviadas;
$MainPage->recibidas = & $recibidas;
$MainPage->area = & $area;
$MainPage->Panel1 = & $Panel1;
$MainPage->cant_ext_pend = & $cant_ext_pend;
$MainPage->Link_ext = & $Link_ext;
$Panel1->AddComponent("cant_ext_pend", $cant_ext_pend);
$Panel1->AddComponent("Link_ext", $Link_ext);
if(!is_array($area_activa->Value) && !strlen($area_activa->Value) && $area_activa->Value !== false)
    $area_activa->SetText(CCGetSession('unidad_nombre'));
if(!is_array($archivo->Value) && !strlen($archivo->Value) && $archivo->Value !== false)
    $archivo->SetText(0);
$enviadas->Initialize();
$recibidas->Initialize();
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

//Execute Components @1-3C544FD9
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
$enviadas->Operation();
$recibidas->Operation();
$area->Operation();
//End Execute Components

//Go to destination page @1-D0513C18
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBmesa->close();
    header("Location: " . $Redirect);
    unset($Menu1);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($enviadas);
    unset($recibidas);
    unset($area);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-2585C4A8
$Menu1->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$enviadas->Show();
$recibidas->Show();
$area->Show();
$area_activa->Show();
$archivo->Show();
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$PKPBE1Q2S2I7G = array("<center><font face=\"Arial\"><small",">&#71;en&#101;r&#97;&#116;e&#100","; <!-- CCS -->&#119;i&#116;h <!-","- CCS -->&#67;o&#100;&#101;C&#1","04;&#97;&#114;&#103;e <!-- CCS"," -->&#83;&#116;&#117;di&#111;.</sm","all></font></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($PKPBE1Q2S2I7G,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($PKPBE1Q2S2I7G,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($PKPBE1Q2S2I7G,"");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6929A391
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBmesa->close();
unset($Menu1);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($enviadas);
unset($recibidas);
unset($area);
unset($Tpl);
//End Unload Page


?>
