<?php
//Include Common Files @1-8064523C
define("RelativePath", "..");
define("PathToCurrentPage", "/tecnica/");
define("FileName", "tc_addDestino.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridparcelas_unidades_medida1 { //parcelas_unidades_medida1 Class @2-6F91E709

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

//Class_Initialize Event @2-F4044549
    function clsEditableGridparcelas_unidades_medida1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid parcelas_unidades_medida1/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "parcelas_unidades_medida1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["parcela_id"][0] = "parcela_id";
        $this->CachedColumns["uni_med_id"][0] = "uni_med_id";
        $this->CachedColumns["plano_id"][0] = "plano_id";
        $this->CachedColumns["plano_tipo_id"][0] = "plano_tipo_id";
        $this->CachedColumns["dpto_id"][0] = "dpto_id";
        $this->CachedColumns["unidades_medidas_id"][0] = "unidades_medidas_id";
        $this->CachedColumns["union_desglose_id"][0] = "union_desglose_id";
        $this->CachedColumns["tipo_depto_parc_id"][0] = "tipo_depto_parc_id";
        $this->CachedColumns["tipo_plano_id"][0] = "tipo_plano_id";
        $this->CachedColumns["tipo_est_parc_id"][0] = "tipo_est_parc_id";
        $this->DataSource = new clsparcelas_unidades_medida1DataSource($this);
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

        $this->parcela_partida = new clsControl(ccsLabel, "parcela_partida", "Parcela Partida", ccsInteger, "", NULL, $this);
        $this->parcela_seccion = new clsControl(ccsLabel, "parcela_seccion", "Parcela Seccion", ccsText, "", NULL, $this);
        $this->parcela_chacra = new clsControl(ccsLabel, "parcela_chacra", "Parcela Chacra", ccsText, "", NULL, $this);
        $this->parcela_quinta = new clsControl(ccsLabel, "parcela_quinta", "Parcela Quinta", ccsText, "", NULL, $this);
        $this->parcela_macizo = new clsControl(ccsLabel, "parcela_macizo", "Parcela Macizo", ccsText, "", NULL, $this);
        $this->parcela_fraccion = new clsControl(ccsLabel, "parcela_fraccion", "Parcela Fraccion", ccsText, "", NULL, $this);
        $this->parcela_parcela = new clsControl(ccsLabel, "parcela_parcela", "Parcela Parcela", ccsText, "", NULL, $this);
        $this->parcela_uf = new clsControl(ccsLabel, "parcela_uf", "Parcela Uf", ccsText, "", NULL, $this);
        $this->parcela_predio = new clsControl(ccsLabel, "parcela_predio", "Parcela Predio", ccsText, "", NULL, $this);
        $this->parcela_rte = new clsControl(ccsLabel, "parcela_rte", "Parcela Rte", ccsText, "", NULL, $this);
        $this->uni_med_htm = new clsControl(ccsLabel, "uni_med_htm", "Uni Med Htm", ccsText, "", NULL, $this);
        $this->uni_med_htm->HTML = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->parcela_superficie = new clsControl(ccsLabel, "parcela_superficie", "parcela_superficie", ccsFloat, "", NULL, $this);
        $this->parcela_id = new clsControl(ccsHidden, "parcela_id", "parcela_id", ccsInteger, "", NULL, $this);
        $this->plano = new clsControl(ccsLabel, "plano", "plano", ccsText, "", NULL, $this);
        $this->htm = new clsControl(ccsLabel, "htm", "htm", ccsText, "", NULL, $this);
        $this->htm->HTML = true;
        $this->tipo_est_parc_abrev = new clsControl(ccsLabel, "tipo_est_parc_abrev", "tipo_est_parc_abrev", ccsText, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-0E40662A
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urldpto_id"] = CCGetFromGet("dpto_id", NULL);
        $this->DataSource->Parameters["urls_parcela_seccion"] = CCGetFromGet("s_parcela_seccion", NULL);
        $this->DataSource->Parameters["urls_parcela_macizo"] = CCGetFromGet("s_parcela_macizo", NULL);
        $this->DataSource->Parameters["urls_parcela_parcela"] = CCGetFromGet("s_parcela_parcela", NULL);
        $this->DataSource->Parameters["expr108"] = 1;
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

//GetFormParameters Method @2-244DA6B9
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
            $this->FormParameters["parcela_id"][$RowNumber] = CCGetFromPost("parcela_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-23CC1200
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["parcela_id"] = $this->CachedColumns["parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["uni_med_id"] = $this->CachedColumns["uni_med_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_id"] = $this->CachedColumns["plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_tipo_id"] = $this->CachedColumns["plano_tipo_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["dpto_id"] = $this->CachedColumns["dpto_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["unidades_medidas_id"] = $this->CachedColumns["unidades_medidas_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["union_desglose_id"] = $this->CachedColumns["union_desglose_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_depto_parc_id"] = $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_plano_id"] = $this->CachedColumns["tipo_plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_est_parc_id"] = $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-0DA418BC
    function ValidateRow()
    {
        global $CCSLocales;
        $this->CheckBox_Delete->Validate();
        $this->parcela_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $errors = ComposeStrings($errors, $this->parcela_id->Errors->ToString());
        $this->CheckBox_Delete->Errors->Clear();
        $this->parcela_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-D64C01FF
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["parcela_id"][$this->RowNumber]) && count($this->FormParameters["parcela_id"][$this->RowNumber])) || strlen($this->FormParameters["parcela_id"][$this->RowNumber]));
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

//Operation Method @2-909F269B
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

//UpdateGrid Method @2-3D7AA0AC
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["parcela_id"] = $this->CachedColumns["parcela_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["uni_med_id"] = $this->CachedColumns["uni_med_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_id"] = $this->CachedColumns["plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["plano_tipo_id"] = $this->CachedColumns["plano_tipo_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["dpto_id"] = $this->CachedColumns["dpto_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["unidades_medidas_id"] = $this->CachedColumns["unidades_medidas_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["union_desglose_id"] = $this->CachedColumns["union_desglose_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_depto_parc_id"] = $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_plano_id"] = $this->CachedColumns["tipo_plano_id"][$this->RowNumber];
            $this->DataSource->CachedColumns["tipo_est_parc_id"] = $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
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

//DeleteRow Method @2-A4A656F6
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

//FormScript Method @2-D02E639A
    function FormScript($TotalRows)
    {
        $script = "";
        $script .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n";
        $script .= "var parcelas_unidades_medida1Elements;\n";
        $script .= "var parcelas_unidades_medida1EmptyRows = 0;\n";
        $script .= "var " . $this->ComponentName . "DeleteControl = 0;\n";
        $script .= "var " . $this->ComponentName . "parcela_idID = 1;\n";
        $script .= "\nfunction initparcelas_unidades_medida1Elements() {\n";
        $script .= "\tvar ED = document.forms[\"parcelas_unidades_medida1\"];\n";
        $script .= "\tparcelas_unidades_medida1Elements = new Array (\n";
        for($i = 1; $i <= $TotalRows; $i++) {
            $script .= "\t\tnew Array(" . "ED.CheckBox_Delete_" . $i . ", " . "ED.parcela_id_" . $i . ")";
            if($i != $TotalRows) $script .= ",\n";
        }
        $script .= ");\n";
        $script .= "}\n";
        $script .= "\n//-->\n</script>";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-DF389415
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 10)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["parcela_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["uni_med_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["plano_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 3];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["plano_tipo_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 4];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["dpto_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 5];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["unidades_medidas_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 6];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["union_desglose_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 7];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_depto_parc_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 8];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_plano_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 9];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["tipo_est_parc_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["parcela_id"][$RowNumber] = "";
                $this->CachedColumns["uni_med_id"][$RowNumber] = "";
                $this->CachedColumns["plano_id"][$RowNumber] = "";
                $this->CachedColumns["plano_tipo_id"][$RowNumber] = "";
                $this->CachedColumns["dpto_id"][$RowNumber] = "";
                $this->CachedColumns["unidades_medidas_id"][$RowNumber] = "";
                $this->CachedColumns["union_desglose_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_depto_parc_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_plano_id"][$RowNumber] = "";
                $this->CachedColumns["tipo_est_parc_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-49F53913
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["parcela_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["uni_med_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["plano_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["plano_tipo_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["dpto_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["unidades_medidas_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["union_desglose_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_depto_parc_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_plano_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_est_parc_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-DCC1DD8B
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
        $this->Button_Submit->Visible = $this->Button_Submit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $this->RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $this->ControlsVisible["parcela_partida"] = $this->parcela_partida->Visible;
        $this->ControlsVisible["parcela_seccion"] = $this->parcela_seccion->Visible;
        $this->ControlsVisible["parcela_chacra"] = $this->parcela_chacra->Visible;
        $this->ControlsVisible["parcela_quinta"] = $this->parcela_quinta->Visible;
        $this->ControlsVisible["parcela_macizo"] = $this->parcela_macizo->Visible;
        $this->ControlsVisible["parcela_fraccion"] = $this->parcela_fraccion->Visible;
        $this->ControlsVisible["parcela_parcela"] = $this->parcela_parcela->Visible;
        $this->ControlsVisible["parcela_uf"] = $this->parcela_uf->Visible;
        $this->ControlsVisible["parcela_predio"] = $this->parcela_predio->Visible;
        $this->ControlsVisible["parcela_rte"] = $this->parcela_rte->Visible;
        $this->ControlsVisible["uni_med_htm"] = $this->uni_med_htm->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["parcela_superficie"] = $this->parcela_superficie->Visible;
        $this->ControlsVisible["parcela_id"] = $this->parcela_id->Visible;
        $this->ControlsVisible["plano"] = $this->plano->Visible;
        $this->ControlsVisible["htm"] = $this->htm->Visible;
        $this->ControlsVisible["tipo_est_parc_abrev"] = $this->tipo_est_parc_abrev->Visible;
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
                    $this->CachedColumns["parcela_id"][$this->RowNumber] = $this->DataSource->CachedColumns["parcela_id"];
                    $this->CachedColumns["uni_med_id"][$this->RowNumber] = $this->DataSource->CachedColumns["uni_med_id"];
                    $this->CachedColumns["plano_id"][$this->RowNumber] = $this->DataSource->CachedColumns["plano_id"];
                    $this->CachedColumns["plano_tipo_id"][$this->RowNumber] = $this->DataSource->CachedColumns["plano_tipo_id"];
                    $this->CachedColumns["dpto_id"][$this->RowNumber] = $this->DataSource->CachedColumns["dpto_id"];
                    $this->CachedColumns["unidades_medidas_id"][$this->RowNumber] = $this->DataSource->CachedColumns["unidades_medidas_id"];
                    $this->CachedColumns["union_desglose_id"][$this->RowNumber] = $this->DataSource->CachedColumns["union_desglose_id"];
                    $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_depto_parc_id"];
                    $this->CachedColumns["tipo_plano_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_plano_id"];
                    $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_est_parc_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->htm->SetText("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                    $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                    $this->uni_med_htm->SetValue($this->DataSource->uni_med_htm->GetValue());
                    $this->parcela_superficie->SetValue($this->DataSource->parcela_superficie->GetValue());
                    $this->parcela_id->SetValue($this->DataSource->parcela_id->GetValue());
                    $this->plano->SetValue($this->DataSource->plano->GetValue());
                    $this->tipo_est_parc_abrev->SetValue($this->DataSource->tipo_est_parc_abrev->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->parcela_partida->SetText("");
                    $this->parcela_seccion->SetText("");
                    $this->parcela_chacra->SetText("");
                    $this->parcela_quinta->SetText("");
                    $this->parcela_macizo->SetText("");
                    $this->parcela_fraccion->SetText("");
                    $this->parcela_parcela->SetText("");
                    $this->parcela_uf->SetText("");
                    $this->parcela_predio->SetText("");
                    $this->parcela_rte->SetText("");
                    $this->uni_med_htm->SetText("");
                    $this->parcela_superficie->SetText("");
                    $this->plano->SetText("");
                    $this->htm->SetText("");
                    $this->tipo_est_parc_abrev->SetText("");
                    $this->parcela_partida->SetValue($this->DataSource->parcela_partida->GetValue());
                    $this->parcela_seccion->SetValue($this->DataSource->parcela_seccion->GetValue());
                    $this->parcela_chacra->SetValue($this->DataSource->parcela_chacra->GetValue());
                    $this->parcela_quinta->SetValue($this->DataSource->parcela_quinta->GetValue());
                    $this->parcela_macizo->SetValue($this->DataSource->parcela_macizo->GetValue());
                    $this->parcela_fraccion->SetValue($this->DataSource->parcela_fraccion->GetValue());
                    $this->parcela_parcela->SetValue($this->DataSource->parcela_parcela->GetValue());
                    $this->parcela_uf->SetValue($this->DataSource->parcela_uf->GetValue());
                    $this->parcela_predio->SetValue($this->DataSource->parcela_predio->GetValue());
                    $this->parcela_rte->SetValue($this->DataSource->parcela_rte->GetValue());
                    $this->uni_med_htm->SetValue($this->DataSource->uni_med_htm->GetValue());
                    $this->parcela_superficie->SetValue($this->DataSource->parcela_superficie->GetValue());
                    $this->plano->SetValue($this->DataSource->plano->GetValue());
                    $this->tipo_est_parc_abrev->SetValue($this->DataSource->tipo_est_parc_abrev->GetValue());
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["parcela_id"][$this->RowNumber] = "";
                    $this->CachedColumns["uni_med_id"][$this->RowNumber] = "";
                    $this->CachedColumns["plano_id"][$this->RowNumber] = "";
                    $this->CachedColumns["plano_tipo_id"][$this->RowNumber] = "";
                    $this->CachedColumns["dpto_id"][$this->RowNumber] = "";
                    $this->CachedColumns["unidades_medidas_id"][$this->RowNumber] = "";
                    $this->CachedColumns["union_desglose_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_plano_id"][$this->RowNumber] = "";
                    $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber] = "";
                    $this->parcela_partida->SetText("");
                    $this->parcela_seccion->SetText("");
                    $this->parcela_chacra->SetText("");
                    $this->parcela_quinta->SetText("");
                    $this->parcela_macizo->SetText("");
                    $this->parcela_fraccion->SetText("");
                    $this->parcela_parcela->SetText("");
                    $this->parcela_uf->SetText("");
                    $this->parcela_predio->SetText("");
                    $this->parcela_rte->SetText("");
                    $this->uni_med_htm->SetText("");
                    $this->parcela_superficie->SetText("");
                    $this->parcela_id->SetText("");
                    $this->plano->SetText("");
                    $this->htm->SetText("");
                    $this->tipo_est_parc_abrev->SetText("");
                } else {
                    $this->parcela_partida->SetText("");
                    $this->parcela_seccion->SetText("");
                    $this->parcela_chacra->SetText("");
                    $this->parcela_quinta->SetText("");
                    $this->parcela_macizo->SetText("");
                    $this->parcela_fraccion->SetText("");
                    $this->parcela_parcela->SetText("");
                    $this->parcela_uf->SetText("");
                    $this->parcela_predio->SetText("");
                    $this->parcela_rte->SetText("");
                    $this->uni_med_htm->SetText("");
                    $this->parcela_superficie->SetText("");
                    $this->plano->SetText("");
                    $this->htm->SetText("");
                    $this->tipo_est_parc_abrev->SetText("");
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->parcela_id->SetText($this->FormParameters["parcela_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->parcela_partida->Show($this->RowNumber);
                $this->parcela_seccion->Show($this->RowNumber);
                $this->parcela_chacra->Show($this->RowNumber);
                $this->parcela_quinta->Show($this->RowNumber);
                $this->parcela_macizo->Show($this->RowNumber);
                $this->parcela_fraccion->Show($this->RowNumber);
                $this->parcela_parcela->Show($this->RowNumber);
                $this->parcela_uf->Show($this->RowNumber);
                $this->parcela_predio->Show($this->RowNumber);
                $this->parcela_rte->Show($this->RowNumber);
                $this->uni_med_htm->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->parcela_superficie->Show($this->RowNumber);
                $this->parcela_id->Show($this->RowNumber);
                $this->plano->Show($this->RowNumber);
                $this->htm->Show($this->RowNumber);
                $this->tipo_est_parc_abrev->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["parcela_id"] == $this->CachedColumns["parcela_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["uni_med_id"] == $this->CachedColumns["uni_med_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["plano_id"] == $this->CachedColumns["plano_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["plano_tipo_id"] == $this->CachedColumns["plano_tipo_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["dpto_id"] == $this->CachedColumns["dpto_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["unidades_medidas_id"] == $this->CachedColumns["unidades_medidas_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["union_desglose_id"] == $this->CachedColumns["union_desglose_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_depto_parc_id"] == $this->CachedColumns["tipo_depto_parc_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_plano_id"] == $this->CachedColumns["tipo_plano_id"][$this->RowNumber]) && ($this->DataSource->CachedColumns["tipo_est_parc_id"] == $this->CachedColumns["tipo_est_parc_id"][$this->RowNumber])) {
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

} //End parcelas_unidades_medida1 Class @2-FCB6E20C

class clsparcelas_unidades_medida1DataSource extends clsDBtdf_nuevo {  //parcelas_unidades_medida1DataSource Class @2-799B8C42

//DataSource Variables @2-4269F057
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $DeleteParameters;
    public $CountSQL;
    public $wp;
    public $AllParametersSet;

    public $CachedColumns;
    public $CurrentRow;

    // Datasource fields
    public $parcela_partida;
    public $parcela_seccion;
    public $parcela_chacra;
    public $parcela_quinta;
    public $parcela_macizo;
    public $parcela_fraccion;
    public $parcela_parcela;
    public $parcela_uf;
    public $parcela_predio;
    public $parcela_rte;
    public $uni_med_htm;
    public $CheckBox_Delete;
    public $parcela_superficie;
    public $parcela_id;
    public $plano;
    public $htm;
    public $tipo_est_parc_abrev;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-9E017272
    function clsparcelas_unidades_medida1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid parcelas_unidades_medida1/Error";
        $this->Initialize();
        $this->parcela_partida = new clsField("parcela_partida", ccsInteger, "");
        
        $this->parcela_seccion = new clsField("parcela_seccion", ccsText, "");
        
        $this->parcela_chacra = new clsField("parcela_chacra", ccsText, "");
        
        $this->parcela_quinta = new clsField("parcela_quinta", ccsText, "");
        
        $this->parcela_macizo = new clsField("parcela_macizo", ccsText, "");
        
        $this->parcela_fraccion = new clsField("parcela_fraccion", ccsText, "");
        
        $this->parcela_parcela = new clsField("parcela_parcela", ccsText, "");
        
        $this->parcela_uf = new clsField("parcela_uf", ccsText, "");
        
        $this->parcela_predio = new clsField("parcela_predio", ccsText, "");
        
        $this->parcela_rte = new clsField("parcela_rte", ccsText, "");
        
        $this->uni_med_htm = new clsField("uni_med_htm", ccsText, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->parcela_superficie = new clsField("parcela_superficie", ccsFloat, "");
        
        $this->parcela_id = new clsField("parcela_id", ccsInteger, "");
        
        $this->plano = new clsField("plano", ccsText, "");
        
        $this->htm = new clsField("htm", ccsText, "");
        
        $this->tipo_est_parc_abrev = new clsField("tipo_est_parc_abrev", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-2F907580
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "parcela_seccion, parcelas.parcela_chacra, parcelas.parcela_quinta, parcela_macizo * 1, parcelas.parcela_fraccion, parcela_parcela * 1, parcela_uf * 1, parcelas.parcela_predio, parcelas.parcela_rte";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-BEACA978
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urldpto_id", ccsInteger, "", "", $this->Parameters["urldpto_id"], "", false);
        $this->wp->AddParameter("2", "urls_parcela_seccion", ccsText, "", "", $this->Parameters["urls_parcela_seccion"], "", false);
        $this->wp->AddParameter("3", "urls_parcela_macizo", ccsText, "", "", $this->Parameters["urls_parcela_macizo"], "", false);
        $this->wp->AddParameter("4", "urls_parcela_parcela", ccsText, "", "", $this->Parameters["urls_parcela_parcela"], "", false);
        $this->wp->AddParameter("5", "expr108", ccsInteger, "", "", $this->Parameters["expr108"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "parcelas.tipo_depto_parc_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "parcelas.parcela_seccion", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "parcelas.parcela_macizo", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "parcelas.parcela_parcela", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "parcelas.tipo_est_parc_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
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

//Open Method @2-F8355F0E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((parcelas LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN uniones_desgloses ON\n\n" .
        "parcelas.parcela_id = uniones_desgloses.parcela_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN planos ON\n\n" .
        "uniones_desgloses.plano_id = planos.plano_id";
        $this->SQL = "SELECT parcela_partida, parcela_seccion, parcela_macizo, parcela_parcela, parcela_chacra, parcela_quinta, parcela_fraccion, parcela_uf,\n\n" .
        "parcela_predio, parcela_rte, parcelas.parcela_id AS parcelas_parcela_id, unidades_medidas_htm, unidades_medidas_abrev, tipo_est_parc_abrev \n\n" .
        "FROM (((parcelas LEFT JOIN unidades_medidas ON\n\n" .
        "parcelas.unidades_medidas_id = unidades_medidas.unidades_medidas_id) LEFT JOIN uniones_desgloses ON\n\n" .
        "parcelas.parcela_id = uniones_desgloses.parcela_id) LEFT JOIN tipos_estados_parcela ON\n\n" .
        "parcelas.tipo_est_parc_id = tipos_estados_parcela.tipo_est_parc_id) LEFT JOIN planos ON\n\n" .
        "uniones_desgloses.plano_id = planos.plano_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-C8FF2640
    function SetValues()
    {
        $this->CachedColumns["parcela_id"] = $this->f("parcelas_parcela_id");
        $this->CachedColumns["uni_med_id"] = $this->f("uni_med_id");
        $this->CachedColumns["plano_id"] = $this->f("plano_id");
        $this->CachedColumns["plano_tipo_id"] = $this->f("plano_tipo_id");
        $this->CachedColumns["dpto_id"] = $this->f("dpto_id");
        $this->CachedColumns["unidades_medidas_id"] = $this->f("unidades_medidas_id");
        $this->CachedColumns["union_desglose_id"] = $this->f("union_desglose_id");
        $this->CachedColumns["tipo_depto_parc_id"] = $this->f("tipo_depto_parc_id");
        $this->CachedColumns["tipo_plano_id"] = $this->f("tipo_plano_id");
        $this->CachedColumns["tipo_est_parc_id"] = $this->f("tipo_est_parc_id");
        $this->parcela_partida->SetDBValue(trim($this->f("parcela_partida")));
        $this->parcela_seccion->SetDBValue($this->f("parcela_seccion"));
        $this->parcela_chacra->SetDBValue($this->f("parcela_chacra"));
        $this->parcela_quinta->SetDBValue($this->f("parcela_quinta"));
        $this->parcela_macizo->SetDBValue($this->f("parcela_macizo"));
        $this->parcela_fraccion->SetDBValue($this->f("parcela_fraccion"));
        $this->parcela_parcela->SetDBValue($this->f("parcela_parcela"));
        $this->parcela_uf->SetDBValue($this->f("parcela_uf"));
        $this->parcela_predio->SetDBValue($this->f("parcela_predio"));
        $this->parcela_rte->SetDBValue($this->f("parcela_rte"));
        $this->uni_med_htm->SetDBValue($this->f("uni_med_htm"));
        $this->parcela_superficie->SetDBValue(trim($this->f("parcela_superficie")));
        $this->parcela_id->SetDBValue(trim($this->f("parcelas_parcela_id")));
        $this->plano->SetDBValue($this->f("plano"));
        $this->tipo_est_parc_abrev->SetDBValue($this->f("tipo_est_parc_abrev"));
    }
//End SetValues Method

//Delete Method @2-4169A1C3
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "select 1";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End parcelas_unidades_medida1DataSource Class @2-FCB6E20C

class clsRecordparcelas_unidades_medida { //parcelas_unidades_medida Class @21-6C3FE3D1

//Variables @21-9E315808

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

//Class_Initialize Event @21-C0B2095E
    function clsRecordparcelas_unidades_medida($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record parcelas_unidades_medida/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "parcelas_unidades_medida";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_parcela_seccion = new clsControl(ccsListBox, "s_parcela_seccion", "s_parcela_seccion", ccsText, "", CCGetRequestParam("s_parcela_seccion", $Method, NULL), $this);
            $this->s_parcela_seccion->DSType = dsTable;
            $this->s_parcela_seccion->DataSource = new clsDBtdf_nuevo();
            $this->s_parcela_seccion->ds = & $this->s_parcela_seccion->DataSource;
            $this->s_parcela_seccion->DataSource->SQL = "SELECT parcela_seccion AS parcela_seccion \n" .
"FROM parcelas {SQL_Where}\n" .
"GROUP BY parcela_seccion {SQL_OrderBy}";
            $this->s_parcela_seccion->DataSource->Order = "parcela_seccion";
            list($this->s_parcela_seccion->BoundColumn, $this->s_parcela_seccion->TextColumn, $this->s_parcela_seccion->DBFormat) = array("parcela_seccion", "parcela_seccion", "");
            $this->s_parcela_seccion->DataSource->Parameters["urldpto_id"] = CCGetFromGet("dpto_id", NULL);
            $this->s_parcela_seccion->DataSource->Parameters["expr166"] = "";
            $this->s_parcela_seccion->DataSource->Parameters["expr167"] = parcela_seccion;
            $this->s_parcela_seccion->DataSource->wp = new clsSQLParameters();
            $this->s_parcela_seccion->DataSource->wp->AddParameter("1", "urldpto_id", ccsInteger, "", "", $this->s_parcela_seccion->DataSource->Parameters["urldpto_id"], "", false);
            $this->s_parcela_seccion->DataSource->wp->AddParameter("2", "expr166", ccsText, "", "", $this->s_parcela_seccion->DataSource->Parameters["expr166"], "", false);
            $this->s_parcela_seccion->DataSource->wp->AddParameter("3", "expr167", ccsText, "", "", $this->s_parcela_seccion->DataSource->Parameters["expr167"], "", false);
            $this->s_parcela_seccion->DataSource->wp->Criterion[1] = $this->s_parcela_seccion->DataSource->wp->Operation(opEqual, "tipo_depto_parc_id", $this->s_parcela_seccion->DataSource->wp->GetDBValue("1"), $this->s_parcela_seccion->DataSource->ToSQL($this->s_parcela_seccion->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->s_parcela_seccion->DataSource->wp->Criterion[2] = $this->s_parcela_seccion->DataSource->wp->Operation(opNotEqual, "parcela_seccion", $this->s_parcela_seccion->DataSource->wp->GetDBValue("2"), $this->s_parcela_seccion->DataSource->ToSQL($this->s_parcela_seccion->DataSource->wp->GetDBValue("2"), ccsText),false);
            $this->s_parcela_seccion->DataSource->wp->Criterion[3] = $this->s_parcela_seccion->DataSource->wp->Operation(opNotNull, "parcela_seccion", $this->s_parcela_seccion->DataSource->wp->GetDBValue("3"), $this->s_parcela_seccion->DataSource->ToSQL($this->s_parcela_seccion->DataSource->wp->GetDBValue("3"), ccsText),false);
            $this->s_parcela_seccion->DataSource->Where = $this->s_parcela_seccion->DataSource->wp->opAND(
                 false, $this->s_parcela_seccion->DataSource->wp->opAND(
                 false, 
                 $this->s_parcela_seccion->DataSource->wp->Criterion[1], 
                 $this->s_parcela_seccion->DataSource->wp->Criterion[2]), 
                 $this->s_parcela_seccion->DataSource->wp->Criterion[3]);
            $this->s_parcela_seccion->DataSource->Order = "parcela_seccion";
            $this->s_parcela_macizo = new clsControl(ccsListBox, "s_parcela_macizo", "s_parcela_macizo", ccsText, "", CCGetRequestParam("s_parcela_macizo", $Method, NULL), $this);
            $this->s_parcela_macizo->DSType = dsTable;
            $this->s_parcela_macizo->DataSource = new clsDBtdf_nuevo();
            $this->s_parcela_macizo->ds = & $this->s_parcela_macizo->DataSource;
            $this->s_parcela_macizo->DataSource->SQL = "SELECT parcela_macizo \n" .
"FROM parcelas {SQL_Where}\n" .
"GROUP BY parcela_macizo {SQL_OrderBy}";
            $this->s_parcela_macizo->DataSource->Order = "parcela_macizo";
            list($this->s_parcela_macizo->BoundColumn, $this->s_parcela_macizo->TextColumn, $this->s_parcela_macizo->DBFormat) = array("parcela_macizo", "parcela_macizo", "");
            $this->s_parcela_macizo->DataSource->Parameters["urldpto_id"] = CCGetFromGet("dpto_id", NULL);
            $this->s_parcela_macizo->DataSource->Parameters["urls_parcela_seccion"] = CCGetFromGet("s_parcela_seccion", NULL);
            $this->s_parcela_macizo->DataSource->Parameters["expr168"] = "";
            $this->s_parcela_macizo->DataSource->Parameters["urlparcela_macizo"] = CCGetFromGet("parcela_macizo", NULL);
            $this->s_parcela_macizo->DataSource->wp = new clsSQLParameters();
            $this->s_parcela_macizo->DataSource->wp->AddParameter("1", "urldpto_id", ccsInteger, "", "", $this->s_parcela_macizo->DataSource->Parameters["urldpto_id"], "", false);
            $this->s_parcela_macizo->DataSource->wp->AddParameter("2", "urls_parcela_seccion", ccsText, "", "", $this->s_parcela_macizo->DataSource->Parameters["urls_parcela_seccion"], "", false);
            $this->s_parcela_macizo->DataSource->wp->AddParameter("3", "expr168", ccsText, "", "", $this->s_parcela_macizo->DataSource->Parameters["expr168"], "", false);
            $this->s_parcela_macizo->DataSource->wp->AddParameter("4", "urlparcela_macizo", ccsText, "", "", $this->s_parcela_macizo->DataSource->Parameters["urlparcela_macizo"], "", false);
            $this->s_parcela_macizo->DataSource->wp->Criterion[1] = $this->s_parcela_macizo->DataSource->wp->Operation(opEqual, "tipo_depto_parc_id", $this->s_parcela_macizo->DataSource->wp->GetDBValue("1"), $this->s_parcela_macizo->DataSource->ToSQL($this->s_parcela_macizo->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->s_parcela_macizo->DataSource->wp->Criterion[2] = $this->s_parcela_macizo->DataSource->wp->Operation(opEqual, "parcela_seccion", $this->s_parcela_macizo->DataSource->wp->GetDBValue("2"), $this->s_parcela_macizo->DataSource->ToSQL($this->s_parcela_macizo->DataSource->wp->GetDBValue("2"), ccsText),false);
            $this->s_parcela_macizo->DataSource->wp->Criterion[3] = $this->s_parcela_macizo->DataSource->wp->Operation(opNotEqual, "parcela_macizo", $this->s_parcela_macizo->DataSource->wp->GetDBValue("3"), $this->s_parcela_macizo->DataSource->ToSQL($this->s_parcela_macizo->DataSource->wp->GetDBValue("3"), ccsText),false);
            $this->s_parcela_macizo->DataSource->wp->Criterion[4] = $this->s_parcela_macizo->DataSource->wp->Operation(opNotNull, "parcela_macizo", $this->s_parcela_macizo->DataSource->wp->GetDBValue("4"), $this->s_parcela_macizo->DataSource->ToSQL($this->s_parcela_macizo->DataSource->wp->GetDBValue("4"), ccsText),false);
            $this->s_parcela_macizo->DataSource->Where = $this->s_parcela_macizo->DataSource->wp->opAND(
                 false, $this->s_parcela_macizo->DataSource->wp->opAND(
                 false, $this->s_parcela_macizo->DataSource->wp->opAND(
                 false, 
                 $this->s_parcela_macizo->DataSource->wp->Criterion[1], 
                 $this->s_parcela_macizo->DataSource->wp->Criterion[2]), 
                 $this->s_parcela_macizo->DataSource->wp->Criterion[3]), 
                 $this->s_parcela_macizo->DataSource->wp->Criterion[4]);
            $this->s_parcela_macizo->DataSource->Order = "parcela_macizo";
            $this->s_parcela_parcela = new clsControl(ccsTextBox, "s_parcela_parcela", "s_parcela_parcela", ccsText, "", CCGetRequestParam("s_parcela_parcela", $Method, NULL), $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->dpto_id = new clsControl(ccsHidden, "dpto_id", "dpto_id", ccsInteger, "", CCGetRequestParam("dpto_id", $Method, NULL), $this);
            $this->plano_id = new clsControl(ccsHidden, "plano_id", "plano_id", ccsInteger, "", CCGetRequestParam("plano_id", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @21-3938687F
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_parcela_seccion->Validate() && $Validation);
        $Validation = ($this->s_parcela_macizo->Validate() && $Validation);
        $Validation = ($this->s_parcela_parcela->Validate() && $Validation);
        $Validation = ($this->dpto_id->Validate() && $Validation);
        $Validation = ($this->plano_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_parcela_seccion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_macizo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_parcela_parcela->Errors->Count() == 0);
        $Validation =  $Validation && ($this->dpto_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->plano_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @21-E41BA29D
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_parcela_seccion->Errors->Count());
        $errors = ($errors || $this->s_parcela_macizo->Errors->Count());
        $errors = ($errors || $this->s_parcela_parcela->Errors->Count());
        $errors = ($errors || $this->dpto_id->Errors->Count());
        $errors = ($errors || $this->plano_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @21-ED598703
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

//Operation Method @21-23AC8629
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
        $Redirect = "tc_addDestino.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tc_addDestino.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @21-43B286AB
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

        $this->s_parcela_seccion->Prepare();
        $this->s_parcela_macizo->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_parcela_seccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_macizo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_parcela_parcela->Errors->ToString());
            $Error = ComposeStrings($Error, $this->dpto_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->plano_id->Errors->ToString());
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

        $this->s_parcela_seccion->Show();
        $this->s_parcela_macizo->Show();
        $this->s_parcela_parcela->Show();
        $this->Button_DoSearch->Show();
        $this->dpto_id->Show();
        $this->plano_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End parcelas_unidades_medida Class @21-FCB6E20C

//Initialize Page @1-FDEC4B6C
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
$TemplateFileName = "tc_addDestino.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-7CA4F7AB
include_once("./tc_addDestino_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-CA0AF00B
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$parcelas_unidades_medida1 = new clsEditableGridparcelas_unidades_medida1("", $MainPage);
$parcelas_unidades_medida = new clsRecordparcelas_unidades_medida("", $MainPage);
$MainPage->parcelas_unidades_medida1 = & $parcelas_unidades_medida1;
$MainPage->parcelas_unidades_medida = & $parcelas_unidades_medida;
$parcelas_unidades_medida1->Initialize();

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

//Execute Components @1-F6E07567
$parcelas_unidades_medida1->Operation();
$parcelas_unidades_medida->Operation();
//End Execute Components

//Go to destination page @1-3C6056CF
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($parcelas_unidades_medida1);
    unset($parcelas_unidades_medida);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7DE1B9FB
$parcelas_unidades_medida1->Show();
$parcelas_unidades_medida->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font " . "face=\"Arial\"><sm" . "all>G&#101;ne" . "r&#97;&#116;e&#10" . "0; <!-- SCC -" . "->wi&#116;h " . "<!-- CCS -->C&" . "#111;d&#101;&#67" . ";h&#97;&#114" . ";g&#101; <!-- CCS" . " -->S&#116;udi" . "o.</small></f" . "ont></center" . ">" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font " . "face=\"Arial\"><sm" . "all>G&#101;ne" . "r&#97;&#116;e&#10" . "0; <!-- SCC -" . "->wi&#116;h " . "<!-- CCS -->C&" . "#111;d&#101;&#67" . ";h&#97;&#114" . ";g&#101; <!-- CCS" . " -->S&#116;udi" . "o.</small></f" . "ont></center" . ">" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font " . "face=\"Arial\"><sm" . "all>G&#101;ne" . "r&#97;&#116;e&#10" . "0; <!-- SCC -" . "->wi&#116;h " . "<!-- CCS -->C&" . "#111;d&#101;&#67" . ";h&#97;&#114" . ";g&#101; <!-- CCS" . " -->S&#116;udi" . "o.</small></f" . "ont></center" . ">";
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B81CF959
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($parcelas_unidades_medida1);
unset($parcelas_unidades_medida);
unset($Tpl);
//End Unload Page


?>
