<?php
//Include Common Files @1-284D90ED
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_noticias_categorias.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridnoticias_categoria { //noticias_categoria Class @2-5EE6AE72

//Variables @2-96DACC12

    // Public variables
    public $ComponentType = "EditableGrid";
    public $ComponentName;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormParameters;
    public $StoredValues;
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

//Class_Initialize Event @2-C2A273B0
    function clsEditableGridnoticias_categoria($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid noticias_categoria/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "noticias_categoria";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["noti_cat_id"][0] = "noti_cat_id";
        $this->DataSource = new clsnoticias_categoriaDataSource($this);
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

        $this->noti_cat_descr = new clsControl(ccsTextBox, "noti_cat_descr", "Descripción", ccsText, "", NULL, $this);
        $this->noti_cat_descr->Required = true;
        $this->noti_cat_abrev = new clsControl(ccsTextBox, "noti_cat_abrev", "Abreviatura", ccsText, "", NULL, $this);
        $this->noti_cat_abrev->Required = true;
        $this->noti_cat_icono = new clsControl(ccsTextBox, "noti_cat_icono", "Path del ícono", ccsText, "", NULL, $this);
        $this->noti_cat_icono->Required = true;
        $this->not_h_est_id = new clsControl(ccsListBox, "not_h_est_id", "Estado del hilo", ccsInteger, "", NULL, $this);
        $this->not_h_est_id->DSType = dsTable;
        $this->not_h_est_id->DataSource = new clsDBtdf_nuevo();
        $this->not_h_est_id->ds = & $this->not_h_est_id->DataSource;
        $this->not_h_est_id->DataSource->SQL = "SELECT * \n" .
"FROM noticias_h_estados {SQL_Where} {SQL_OrderBy}";
        list($this->not_h_est_id->BoundColumn, $this->not_h_est_id->TextColumn, $this->not_h_est_id->DBFormat) = array("not_h_est_id", "not_h_desc", "");
        $this->not_h_est_id->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
        $this->icon_preview = new clsControl(ccsImage, "icon_preview", "icon_preview", ccsText, "", NULL, $this);
        $this->noti_cat_id = new clsControl(ccsHidden, "noti_cat_id", "noti_cat_id", ccsInteger, "", NULL, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-C9C05A05
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_noti_cat_descr"] = CCGetFromGet("s_noti_cat_descr", NULL);
        $this->DataSource->Parameters["urls_not_h_est_id"] = CCGetFromGet("s_not_h_est_id", NULL);
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

//GetFormParameters Method @2-EB57203E
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["noti_cat_descr"][$RowNumber] = CCGetFromPost("noti_cat_descr_" . $RowNumber, NULL);
            $this->FormParameters["noti_cat_abrev"][$RowNumber] = CCGetFromPost("noti_cat_abrev_" . $RowNumber, NULL);
            $this->FormParameters["noti_cat_icono"][$RowNumber] = CCGetFromPost("noti_cat_icono_" . $RowNumber, NULL);
            $this->FormParameters["not_h_est_id"][$RowNumber] = CCGetFromPost("not_h_est_id_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
            $this->FormParameters["noti_cat_id"][$RowNumber] = CCGetFromPost("noti_cat_id_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-E412EABD
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $this->StoredValues = array();

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["noti_cat_id"] = $this->CachedColumns["noti_cat_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->noti_cat_descr->SetText($this->FormParameters["noti_cat_descr"][$this->RowNumber], $this->RowNumber);
            $this->noti_cat_abrev->SetText($this->FormParameters["noti_cat_abrev"][$this->RowNumber], $this->RowNumber);
            $this->noti_cat_icono->SetText($this->FormParameters["noti_cat_icono"][$this->RowNumber], $this->RowNumber);
            $this->not_h_est_id->SetText($this->FormParameters["not_h_est_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->noti_cat_id->SetText($this->FormParameters["noti_cat_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-7F1815A6
    function ValidateRow()
    {
        global $CCSLocales;
        if(strlen($this->CachedColumns["noti_cat_id"][$this->RowNumber])) 
            $Where = " AND noti_cat_id <> " . $this->DataSource->ToSQL($this->CachedColumns["noti_cat_id"][$this->RowNumber], ccsInteger); 
        else
            $Where = "";
        if (!isset($this->StoredValues["noti_cat_descr"])) $this->StoredValues["noti_cat_descr"] = array();
        $this->DataSource->noti_cat_descr->SetValue($this->noti_cat_descr->GetValue());
        if(CCDLookUp("COUNT(*)", "noticias_categoria", "noti_cat_descr=" . $this->DataSource->ToSQL($this->DataSource->noti_cat_descr->GetDBValue(), $this->DataSource->noti_cat_descr->DataType) . $Where, $this->DataSource) > 0)
            $this->noti_cat_descr->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        else if (in_array($this->noti_cat_descr->GetValue(), $this->StoredValues["noti_cat_descr"]))
            $this->noti_cat_descr->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripción"));
        $this->StoredValues["noti_cat_descr"][] = $this->noti_cat_descr->GetValue();
        $this->noti_cat_descr->Validate();
        $this->noti_cat_abrev->Validate();
        $this->noti_cat_icono->Validate();
        $this->not_h_est_id->Validate();
        $this->CheckBox_Delete->Validate();
        $this->noti_cat_id->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->noti_cat_descr->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_cat_abrev->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_cat_icono->Errors->ToString());
        $errors = ComposeStrings($errors, $this->not_h_est_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $errors = ComposeStrings($errors, $this->noti_cat_id->Errors->ToString());
        $this->noti_cat_descr->Errors->Clear();
        $this->noti_cat_abrev->Errors->Clear();
        $this->noti_cat_icono->Errors->Clear();
        $this->not_h_est_id->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $this->noti_cat_id->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-11838FCE
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["noti_cat_descr"][$this->RowNumber]) && count($this->FormParameters["noti_cat_descr"][$this->RowNumber])) || strlen($this->FormParameters["noti_cat_descr"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["noti_cat_abrev"][$this->RowNumber]) && count($this->FormParameters["noti_cat_abrev"][$this->RowNumber])) || strlen($this->FormParameters["noti_cat_abrev"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["noti_cat_icono"][$this->RowNumber]) && count($this->FormParameters["noti_cat_icono"][$this->RowNumber])) || strlen($this->FormParameters["noti_cat_icono"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["not_h_est_id"][$this->RowNumber]) && count($this->FormParameters["not_h_est_id"][$this->RowNumber])) || strlen($this->FormParameters["not_h_est_id"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["noti_cat_id"][$this->RowNumber]) && count($this->FormParameters["noti_cat_id"][$this->RowNumber])) || strlen($this->FormParameters["noti_cat_id"][$this->RowNumber]));
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

//Operation Method @2-6B923CC2
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
        } else if($this->Cancel->Pressed) {
            $this->PressedButton = "Cancel";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick", $this->Cancel)) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @2-76D64328
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["noti_cat_id"] = $this->CachedColumns["noti_cat_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->noti_cat_descr->SetText($this->FormParameters["noti_cat_descr"][$this->RowNumber], $this->RowNumber);
            $this->noti_cat_abrev->SetText($this->FormParameters["noti_cat_abrev"][$this->RowNumber], $this->RowNumber);
            $this->noti_cat_icono->SetText($this->FormParameters["noti_cat_icono"][$this->RowNumber], $this->RowNumber);
            $this->not_h_est_id->SetText($this->FormParameters["not_h_est_id"][$this->RowNumber], $this->RowNumber);
            $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
            $this->noti_cat_id->SetText($this->FormParameters["noti_cat_id"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-54F80C28
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->noti_cat_descr->SetValue($this->noti_cat_descr->GetValue(true));
        $this->DataSource->noti_cat_abrev->SetValue($this->noti_cat_abrev->GetValue(true));
        $this->DataSource->noti_cat_icono->SetValue($this->noti_cat_icono->GetValue(true));
        $this->DataSource->not_h_est_id->SetValue($this->not_h_est_id->GetValue(true));
        $this->DataSource->icon_preview->SetValue($this->icon_preview->GetValue(true));
        $this->DataSource->noti_cat_id->SetValue($this->noti_cat_id->GetValue(true));
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

//UpdateRow Method @2-B4D8E409
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->noti_cat_descr->SetValue($this->noti_cat_descr->GetValue(true));
        $this->DataSource->noti_cat_abrev->SetValue($this->noti_cat_abrev->GetValue(true));
        $this->DataSource->noti_cat_icono->SetValue($this->noti_cat_icono->GetValue(true));
        $this->DataSource->not_h_est_id->SetValue($this->not_h_est_id->GetValue(true));
        $this->DataSource->icon_preview->SetValue($this->icon_preview->GetValue(true));
        $this->DataSource->noti_cat_id->SetValue($this->noti_cat_id->GetValue(true));
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

//FormScript Method @2-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @2-878607CF
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
                $this->CachedColumns["noti_cat_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["noti_cat_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-784A74BA
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["noti_cat_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-7BEC4274
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->not_h_est_id->Prepare();

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
        $this->ControlsVisible["noti_cat_descr"] = $this->noti_cat_descr->Visible;
        $this->ControlsVisible["noti_cat_abrev"] = $this->noti_cat_abrev->Visible;
        $this->ControlsVisible["noti_cat_icono"] = $this->noti_cat_icono->Visible;
        $this->ControlsVisible["not_h_est_id"] = $this->not_h_est_id->Visible;
        $this->ControlsVisible["CheckBox_Delete"] = $this->CheckBox_Delete->Visible;
        $this->ControlsVisible["icon_preview"] = $this->icon_preview->Visible;
        $this->ControlsVisible["noti_cat_id"] = $this->noti_cat_id->Visible;
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
                    $this->CachedColumns["noti_cat_id"][$this->RowNumber] = $this->DataSource->CachedColumns["noti_cat_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->noti_cat_descr->SetValue($this->DataSource->noti_cat_descr->GetValue());
                    $this->noti_cat_abrev->SetValue($this->DataSource->noti_cat_abrev->GetValue());
                    $this->noti_cat_icono->SetValue($this->DataSource->noti_cat_icono->GetValue());
                    $this->not_h_est_id->SetValue($this->DataSource->not_h_est_id->GetValue());
                    $this->icon_preview->SetValue($this->DataSource->icon_preview->GetValue());
                    $this->noti_cat_id->SetValue($this->DataSource->noti_cat_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->icon_preview->SetText("");
                    $this->icon_preview->SetValue($this->DataSource->icon_preview->GetValue());
                    $this->noti_cat_descr->SetText($this->FormParameters["noti_cat_descr"][$this->RowNumber], $this->RowNumber);
                    $this->noti_cat_abrev->SetText($this->FormParameters["noti_cat_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->noti_cat_icono->SetText($this->FormParameters["noti_cat_icono"][$this->RowNumber], $this->RowNumber);
                    $this->not_h_est_id->SetText($this->FormParameters["not_h_est_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->noti_cat_id->SetText($this->FormParameters["noti_cat_id"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["noti_cat_id"][$this->RowNumber] = "";
                    $this->noti_cat_descr->SetText("");
                    $this->noti_cat_abrev->SetText("");
                    $this->noti_cat_icono->SetText("");
                    $this->not_h_est_id->SetText("");
                    $this->icon_preview->SetText("");
                    $this->noti_cat_id->SetText("");
                } else {
                    $this->icon_preview->SetText("");
                    $this->noti_cat_descr->SetText($this->FormParameters["noti_cat_descr"][$this->RowNumber], $this->RowNumber);
                    $this->noti_cat_abrev->SetText($this->FormParameters["noti_cat_abrev"][$this->RowNumber], $this->RowNumber);
                    $this->noti_cat_icono->SetText($this->FormParameters["noti_cat_icono"][$this->RowNumber], $this->RowNumber);
                    $this->not_h_est_id->SetText($this->FormParameters["not_h_est_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                    $this->noti_cat_id->SetText($this->FormParameters["noti_cat_id"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->noti_cat_descr->Show($this->RowNumber);
                $this->noti_cat_abrev->Show($this->RowNumber);
                $this->noti_cat_icono->Show($this->RowNumber);
                $this->not_h_est_id->Show($this->RowNumber);
                $this->CheckBox_Delete->Show($this->RowNumber);
                $this->icon_preview->Show($this->RowNumber);
                $this->noti_cat_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["noti_cat_id"] == $this->CachedColumns["noti_cat_id"][$this->RowNumber])) {
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
        $this->Cancel->Show();

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

} //End noticias_categoria Class @2-FCB6E20C

class clsnoticias_categoriaDataSource extends clsDBtdf_nuevo {  //noticias_categoriaDataSource Class @2-6441CDB2

//DataSource Variables @2-DB3DFA77
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
    public $noti_cat_descr;
    public $noti_cat_abrev;
    public $noti_cat_icono;
    public $not_h_est_id;
    public $CheckBox_Delete;
    public $icon_preview;
    public $noti_cat_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-3FF96823
    function clsnoticias_categoriaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid noticias_categoria/Error";
        $this->Initialize();
        $this->noti_cat_descr = new clsField("noti_cat_descr", ccsText, "");
        
        $this->noti_cat_abrev = new clsField("noti_cat_abrev", ccsText, "");
        
        $this->noti_cat_icono = new clsField("noti_cat_icono", ccsText, "");
        
        $this->not_h_est_id = new clsField("not_h_est_id", ccsInteger, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        
        $this->icon_preview = new clsField("icon_preview", ccsText, "");
        
        $this->noti_cat_id = new clsField("noti_cat_id", ccsInteger, "");
        

        $this->InsertFields["noti_cat_descr"] = array("Name" => "noti_cat_descr", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["noti_cat_abrev"] = array("Name" => "noti_cat_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["noti_cat_icono"] = array("Name" => "noti_cat_icono", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["not_h_est_id"] = array("Name" => "not_h_est_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["noti_cat_id"] = array("Name" => "noti_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["noti_cat_descr"] = array("Name" => "noti_cat_descr", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["noti_cat_abrev"] = array("Name" => "noti_cat_abrev", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["noti_cat_icono"] = array("Name" => "noti_cat_icono", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["not_h_est_id"] = array("Name" => "not_h_est_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["noti_cat_id"] = array("Name" => "noti_cat_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-970063C9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "noti_cat_descr";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-4742FF0F
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_noti_cat_descr", ccsText, "", "", $this->Parameters["urls_noti_cat_descr"], "", false);
        $this->wp->AddParameter("2", "urls_not_h_est_id", ccsInteger, "", "", $this->Parameters["urls_not_h_est_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "noti_cat_descr", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "not_h_est_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-0D985FF1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM noticias_categoria";
        $this->SQL = "SELECT * \n\n" .
        "FROM noticias_categoria {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-E6E5D9C2
    function SetValues()
    {
        $this->CachedColumns["noti_cat_id"] = $this->f("noti_cat_id");
        $this->noti_cat_descr->SetDBValue($this->f("noti_cat_descr"));
        $this->noti_cat_abrev->SetDBValue($this->f("noti_cat_abrev"));
        $this->noti_cat_icono->SetDBValue($this->f("noti_cat_icono"));
        $this->not_h_est_id->SetDBValue(trim($this->f("not_h_est_id")));
        $this->icon_preview->SetDBValue($this->f("noti_cat_icono"));
        $this->noti_cat_id->SetDBValue(trim($this->f("noti_cat_id")));
    }
//End SetValues Method

//Insert Method @2-6393098A
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["noti_cat_descr"]["Value"] = $this->noti_cat_descr->GetDBValue(true);
        $this->InsertFields["noti_cat_abrev"]["Value"] = $this->noti_cat_abrev->GetDBValue(true);
        $this->InsertFields["noti_cat_icono"]["Value"] = $this->noti_cat_icono->GetDBValue(true);
        $this->InsertFields["not_h_est_id"]["Value"] = $this->not_h_est_id->GetDBValue(true);
        $this->InsertFields["noti_cat_id"]["Value"] = $this->noti_cat_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("noticias_categoria", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-FE5790E7
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "noti_cat_id=" . $this->ToSQL($this->CachedColumns["noti_cat_id"], ccsInteger);
        $this->UpdateFields["noti_cat_descr"]["Value"] = $this->noti_cat_descr->GetDBValue(true);
        $this->UpdateFields["noti_cat_abrev"]["Value"] = $this->noti_cat_abrev->GetDBValue(true);
        $this->UpdateFields["noti_cat_icono"]["Value"] = $this->noti_cat_icono->GetDBValue(true);
        $this->UpdateFields["not_h_est_id"]["Value"] = $this->not_h_est_id->GetDBValue(true);
        $this->UpdateFields["noti_cat_id"]["Value"] = $this->noti_cat_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("noticias_categoria", $this->UpdateFields, $this);
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

//Delete Method @2-BCF64506
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "noti_cat_id=" . $this->ToSQL($this->CachedColumns["noti_cat_id"], ccsInteger);
        $this->SQL = "DELETE FROM noticias_categoria";
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

} //End noticias_categoriaDataSource Class @2-FCB6E20C

class clsRecordnoticias_categoriaSearch { //noticias_categoriaSearch Class @3-98A8018E

//Variables @3-9E315808

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

//Class_Initialize Event @3-BD12120B
    function clsRecordnoticias_categoriaSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record noticias_categoriaSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "noticias_categoriaSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_noti_cat_descr = new clsControl(ccsTextBox, "s_noti_cat_descr", "s_noti_cat_descr", ccsText, "", CCGetRequestParam("s_noti_cat_descr", $Method, NULL), $this);
            $this->s_not_h_est_id = new clsControl(ccsListBox, "s_not_h_est_id", "s_not_h_est_id", ccsInteger, "", CCGetRequestParam("s_not_h_est_id", $Method, NULL), $this);
            $this->s_not_h_est_id->DSType = dsTable;
            $this->s_not_h_est_id->DataSource = new clsDBtdf_nuevo();
            $this->s_not_h_est_id->ds = & $this->s_not_h_est_id->DataSource;
            $this->s_not_h_est_id->DataSource->SQL = "SELECT * \n" .
"FROM noticias_h_estados {SQL_Where} {SQL_OrderBy}";
            list($this->s_not_h_est_id->BoundColumn, $this->s_not_h_est_id->TextColumn, $this->s_not_h_est_id->DBFormat) = array("not_h_est_id", "not_h_desc", "");
        }
    }
//End Class_Initialize Event

//Validate Method @3-15968D52
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_noti_cat_descr->Validate() && $Validation);
        $Validation = ($this->s_not_h_est_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_noti_cat_descr->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_not_h_est_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-11844714
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_noti_cat_descr->Errors->Count());
        $errors = ($errors || $this->s_not_h_est_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @3-ED598703
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

//Operation Method @3-5FD19B4A
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
        $Redirect = "pa_noticias_categorias.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_noticias_categorias.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-C5C46DB4
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

        $this->s_not_h_est_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_noti_cat_descr->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_not_h_est_id->Errors->ToString());
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
        $this->s_noti_cat_descr->Show();
        $this->s_not_h_est_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End noticias_categoriaSearch Class @3-FCB6E20C

//Include Page implementation @21-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @22-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @24-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-3622A968
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
$TemplateFileName = "pa_noticias_categorias.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-1869A67C
include_once("./pa_noticias_categorias_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-EC84E82C
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$noticias_categoria = new clsEditableGridnoticias_categoria("", $MainPage);
$noticias_categoriaSearch = new clsRecordnoticias_categoriaSearch("", $MainPage);
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$MainPage->noticias_categoria = & $noticias_categoria;
$MainPage->noticias_categoriaSearch = & $noticias_categoriaSearch;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$noticias_categoria->Initialize();

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

//Execute Components @1-408E1017
$noticias_categoria->Operation();
$noticias_categoriaSearch->Operation();
$tdf_footer->Operations();
$tdf_header->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-735FB6B9
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($noticias_categoria);
    unset($noticias_categoriaSearch);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-86B91BAB
$noticias_categoria->Show();
$noticias_categoriaSearch->Show();
$tdf_footer->Show();
$tdf_header->Show();
$tdf_menu->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$DGCNLON4G3H7B = "<center><font face=\"Arial\"><small>Gener&#97;&#116;ed <!-- CCS -->with <!-- SCC -->Co&#100;&#101;&#67;h&#97;&#114;g&#101; <!-- SCC -->St&#117;d&#105;&#111;.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $DGCNLON4G3H7B . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $DGCNLON4G3H7B . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $DGCNLON4G3H7B;
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9F1241B0
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($noticias_categoria);
unset($noticias_categoriaSearch);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
