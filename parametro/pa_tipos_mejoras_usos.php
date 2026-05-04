<?php
//Include Common Files @1-1BBF7CCB
define("RelativePath", "..");
define("PathToCurrentPage", "/parametro/");
define("FileName", "pa_tipos_mejoras_usos.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridtipos_mejoras_usos { //tipos_mejoras_usos Class @2-90189330

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

//Class_Initialize Event @2-FE8A1024
    function clsEditableGridtipos_mejoras_usos($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid tipos_mejoras_usos/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "tipos_mejoras_usos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->CachedColumns["tipo_mejora_uso_id"][0] = "tipo_mejora_uso_id";
        $this->DataSource = new clstipos_mejoras_usosDataSource($this);
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

        $this->tipo_mejora_uso_codold = new clsControl(ccsTextBox, "tipo_mejora_uso_codold", "Codold", ccsText, "", NULL, $this);
        $this->tipo_mejora_uso_codold->Required = true;
        $this->tipo_mejora_uso_codigo = new clsControl(ccsTextBox, "tipo_mejora_uso_codigo", "Código", ccsInteger, "", NULL, $this);
        $this->tipo_mejora_uso_codigo->Required = true;
        $this->tipo_mejora_uso_descrip = new clsControl(ccsTextBox, "tipo_mejora_uso_descrip", "Descripción", ccsText, "", NULL, $this);
        $this->tipo_mejora_uso_descrip->Required = true;
        $this->tipo_estado_id = new clsControl(ccsListBox, "tipo_estado_id", "Estado", ccsInteger, "", NULL, $this);
        $this->tipo_estado_id->DSType = dsTable;
        $this->tipo_estado_id->DataSource = new clsDBtdf_nuevo();
        $this->tipo_estado_id->ds = & $this->tipo_estado_id->DataSource;
        $this->tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
        list($this->tipo_estado_id->BoundColumn, $this->tipo_estado_id->TextColumn, $this->tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
        $this->tipo_estado_id->Required = true;
        $this->CheckBox_Delete = new clsControl(ccsCheckBox, "CheckBox_Delete", "CheckBox_Delete", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), NULL, $this);
        $this->CheckBox_Delete->CheckedValue = true;
        $this->CheckBox_Delete->UncheckedValue = false;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Button_Submit = new clsButton("Button_Submit", $Method, $this);
        $this->Cancel = new clsButton("Cancel", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @2-333C8C21
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urls_tipo_mejora_uso_descrip"] = CCGetFromGet("s_tipo_mejora_uso_descrip", NULL);
        $this->DataSource->Parameters["urls_tipo_mejora_uso_codigo"] = CCGetFromGet("s_tipo_mejora_uso_codigo", NULL);
        $this->DataSource->Parameters["urls_tipo_estado_id"] = CCGetFromGet("s_tipo_estado_id", NULL);
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

//GetFormParameters Method @2-01169AE1
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["tipo_mejora_uso_codold"][$RowNumber] = CCGetFromPost("tipo_mejora_uso_codold_" . $RowNumber, NULL);
            $this->FormParameters["tipo_mejora_uso_codigo"][$RowNumber] = CCGetFromPost("tipo_mejora_uso_codigo_" . $RowNumber, NULL);
            $this->FormParameters["tipo_mejora_uso_descrip"][$RowNumber] = CCGetFromPost("tipo_mejora_uso_descrip_" . $RowNumber, NULL);
            $this->FormParameters["tipo_estado_id"][$RowNumber] = CCGetFromPost("tipo_estado_id_" . $RowNumber, NULL);
            $this->FormParameters["CheckBox_Delete"][$RowNumber] = CCGetFromPost("CheckBox_Delete_" . $RowNumber, NULL);
        }
    }
//End GetFormParameters Method

//Validate Method @2-B6B11299
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_mejora_uso_id"] = $this->CachedColumns["tipo_mejora_uso_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_mejora_uso_codold->SetText($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber], $this->RowNumber);
            $this->tipo_mejora_uso_codigo->SetText($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber], $this->RowNumber);
            $this->tipo_mejora_uso_descrip->SetText($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber], $this->RowNumber);
            $this->tipo_estado_id->SetText($this->FormParameters["tipo_estado_id"][$this->RowNumber], $this->RowNumber);
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

//ValidateRow Method @2-6A671595
    function ValidateRow()
    {
        global $CCSLocales;
        $this->tipo_mejora_uso_codold->Validate();
        $this->tipo_mejora_uso_codigo->Validate();
        $this->tipo_mejora_uso_descrip->Validate();
        $this->tipo_estado_id->Validate();
        $this->CheckBox_Delete->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_mejora_uso_codold->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_uso_codigo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mejora_uso_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox_Delete->Errors->ToString());
        $this->tipo_mejora_uso_codold->Errors->Clear();
        $this->tipo_mejora_uso_codigo->Errors->Clear();
        $this->tipo_mejora_uso_descrip->Errors->Clear();
        $this->tipo_estado_id->Errors->Clear();
        $this->CheckBox_Delete->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$this->RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @2-A7264585
    function CheckInsert()
    {
        $filed = false;
        $filed = ($filed || (is_array($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber]) && count($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber])) || strlen($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber]) && count($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber])) || strlen($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber]) && count($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber])) || strlen($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber]));
        $filed = ($filed || (is_array($this->FormParameters["tipo_estado_id"][$this->RowNumber]) && count($this->FormParameters["tipo_estado_id"][$this->RowNumber])) || strlen($this->FormParameters["tipo_estado_id"][$this->RowNumber]));
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

//UpdateGrid Method @2-1248AA32
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($this->RowNumber = 1; $this->RowNumber <= $this->TotalRows; $this->RowNumber++)
        {
            $this->DataSource->CachedColumns["tipo_mejora_uso_id"] = $this->CachedColumns["tipo_mejora_uso_id"][$this->RowNumber];
            $this->DataSource->CurrentRow = $this->RowNumber;
            $this->tipo_mejora_uso_codold->SetText($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber], $this->RowNumber);
            $this->tipo_mejora_uso_codigo->SetText($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber], $this->RowNumber);
            $this->tipo_mejora_uso_descrip->SetText($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber], $this->RowNumber);
            $this->tipo_estado_id->SetText($this->FormParameters["tipo_estado_id"][$this->RowNumber], $this->RowNumber);
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

//InsertRow Method @2-C0860C41
    function InsertRow()
    {
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_mejora_uso_codold->SetValue($this->tipo_mejora_uso_codold->GetValue(true));
        $this->DataSource->tipo_mejora_uso_codigo->SetValue($this->tipo_mejora_uso_codigo->GetValue(true));
        $this->DataSource->tipo_mejora_uso_descrip->SetValue($this->tipo_mejora_uso_descrip->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
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

//UpdateRow Method @2-2AA5E2B2
    function UpdateRow()
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_mejora_uso_codold->SetValue($this->tipo_mejora_uso_codold->GetValue(true));
        $this->DataSource->tipo_mejora_uso_codigo->SetValue($this->tipo_mejora_uso_codigo->GetValue(true));
        $this->DataSource->tipo_mejora_uso_descrip->SetValue($this->tipo_mejora_uso_descrip->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
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

//SetFormState Method @2-5550D3A0
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
                $this->CachedColumns["tipo_mejora_uso_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["tipo_mejora_uso_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @2-49EFB393
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["tipo_mejora_uso_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @2-55A97980
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        global $CCSUseAmp;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->tipo_estado_id->Prepare();

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
        $this->ControlsVisible["tipo_mejora_uso_codold"] = $this->tipo_mejora_uso_codold->Visible;
        $this->ControlsVisible["tipo_mejora_uso_codigo"] = $this->tipo_mejora_uso_codigo->Visible;
        $this->ControlsVisible["tipo_mejora_uso_descrip"] = $this->tipo_mejora_uso_descrip->Visible;
        $this->ControlsVisible["tipo_estado_id"] = $this->tipo_estado_id->Visible;
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
                    $this->CachedColumns["tipo_mejora_uso_id"][$this->RowNumber] = $this->DataSource->CachedColumns["tipo_mejora_uso_id"];
                    $this->CheckBox_Delete->SetValue("");
                    $this->tipo_mejora_uso_codold->SetValue($this->DataSource->tipo_mejora_uso_codold->GetValue());
                    $this->tipo_mejora_uso_codigo->SetValue($this->DataSource->tipo_mejora_uso_codigo->GetValue());
                    $this->tipo_mejora_uso_descrip->SetValue($this->DataSource->tipo_mejora_uso_descrip->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->tipo_mejora_uso_codold->SetText($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_mejora_uso_codigo->SetText($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_mejora_uso_descrip->SetText($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_estado_id->SetText($this->FormParameters["tipo_estado_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["tipo_mejora_uso_id"][$this->RowNumber] = "";
                    $this->tipo_mejora_uso_codold->SetText("");
                    $this->tipo_mejora_uso_codigo->SetText("");
                    $this->tipo_mejora_uso_descrip->SetText("");
                    $this->tipo_estado_id->SetText("");
                } else {
                    $this->tipo_mejora_uso_codold->SetText($this->FormParameters["tipo_mejora_uso_codold"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_mejora_uso_codigo->SetText($this->FormParameters["tipo_mejora_uso_codigo"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_mejora_uso_descrip->SetText($this->FormParameters["tipo_mejora_uso_descrip"][$this->RowNumber], $this->RowNumber);
                    $this->tipo_estado_id->SetText($this->FormParameters["tipo_estado_id"][$this->RowNumber], $this->RowNumber);
                    $this->CheckBox_Delete->SetText($this->FormParameters["CheckBox_Delete"][$this->RowNumber], $this->RowNumber);
                }
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_mejora_uso_codold->Show($this->RowNumber);
                $this->tipo_mejora_uso_codigo->Show($this->RowNumber);
                $this->tipo_mejora_uso_descrip->Show($this->RowNumber);
                $this->tipo_estado_id->Show($this->RowNumber);
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
                        if (($this->DataSource->CachedColumns["tipo_mejora_uso_id"] == $this->CachedColumns["tipo_mejora_uso_id"][$this->RowNumber])) {
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

} //End tipos_mejoras_usos Class @2-FCB6E20C

class clstipos_mejoras_usosDataSource extends clsDBtdf_nuevo {  //tipos_mejoras_usosDataSource Class @2-59E3F997

//DataSource Variables @2-844CC411
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
    public $tipo_mejora_uso_codold;
    public $tipo_mejora_uso_codigo;
    public $tipo_mejora_uso_descrip;
    public $tipo_estado_id;
    public $CheckBox_Delete;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-830746FA
    function clstipos_mejoras_usosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid tipos_mejoras_usos/Error";
        $this->Initialize();
        $this->tipo_mejora_uso_codold = new clsField("tipo_mejora_uso_codold", ccsText, "");
        
        $this->tipo_mejora_uso_codigo = new clsField("tipo_mejora_uso_codigo", ccsInteger, "");
        
        $this->tipo_mejora_uso_descrip = new clsField("tipo_mejora_uso_descrip", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->CheckBox_Delete = new clsField("CheckBox_Delete", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["tipo_mejora_uso_codold"] = array("Name" => "tipo_mejora_uso_codold", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_uso_codigo"] = array("Name" => "tipo_mejora_uso_codigo", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_mejora_uso_descrip"] = array("Name" => "tipo_mejora_uso_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_uso_codold"] = array("Name" => "tipo_mejora_uso_codold", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_uso_codigo"] = array("Name" => "tipo_mejora_uso_codigo", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mejora_uso_descrip"] = array("Name" => "tipo_mejora_uso_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-54FD59CE
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_mejora_uso_descrip";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-D11CFD05
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_tipo_mejora_uso_descrip", ccsText, "", "", $this->Parameters["urls_tipo_mejora_uso_descrip"], "", false);
        $this->wp->AddParameter("2", "urls_tipo_mejora_uso_codigo", ccsInteger, "", "", $this->Parameters["urls_tipo_mejora_uso_codigo"], "", false);
        $this->wp->AddParameter("3", "urls_tipo_estado_id", ccsInteger, "", "", $this->Parameters["urls_tipo_estado_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "tipo_mejora_uso_descrip", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "tipo_mejora_uso_codigo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "tipo_estado_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @2-DDCEEC2A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM tipos_mejoras_usos";
        $this->SQL = "SELECT * \n\n" .
        "FROM tipos_mejoras_usos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-8A2CE4F7
    function SetValues()
    {
        $this->CachedColumns["tipo_mejora_uso_id"] = $this->f("tipo_mejora_uso_id");
        $this->tipo_mejora_uso_codold->SetDBValue($this->f("tipo_mejora_uso_codold"));
        $this->tipo_mejora_uso_codigo->SetDBValue(trim($this->f("tipo_mejora_uso_codigo")));
        $this->tipo_mejora_uso_descrip->SetDBValue($this->f("tipo_mejora_uso_descrip"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
    }
//End SetValues Method

//Insert Method @2-6F769C4D
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_mejora_uso_codold"]["Value"] = $this->tipo_mejora_uso_codold->GetDBValue(true);
        $this->InsertFields["tipo_mejora_uso_codigo"]["Value"] = $this->tipo_mejora_uso_codigo->GetDBValue(true);
        $this->InsertFields["tipo_mejora_uso_descrip"]["Value"] = $this->tipo_mejora_uso_descrip->GetDBValue(true);
        $this->InsertFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("tipos_mejoras_usos", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-F589D851
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_mejora_uso_id=" . $this->ToSQL($this->CachedColumns["tipo_mejora_uso_id"], ccsInteger);
        $this->UpdateFields["tipo_mejora_uso_codold"]["Value"] = $this->tipo_mejora_uso_codold->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_uso_codigo"]["Value"] = $this->tipo_mejora_uso_codigo->GetDBValue(true);
        $this->UpdateFields["tipo_mejora_uso_descrip"]["Value"] = $this->tipo_mejora_uso_descrip->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->tipo_estado_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("tipos_mejoras_usos", $this->UpdateFields, $this);
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

//Delete Method @2-35BBCA49
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "tipo_mejora_uso_id=" . $this->ToSQL($this->CachedColumns["tipo_mejora_uso_id"], ccsInteger);
        $this->SQL = "DELETE FROM tipos_mejoras_usos";
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

} //End tipos_mejoras_usosDataSource Class @2-FCB6E20C

class clsRecordtipos_mejoras_usosSearch { //tipos_mejoras_usosSearch Class @3-7E010C00

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

//Class_Initialize Event @3-A14CFC05
    function clsRecordtipos_mejoras_usosSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record tipos_mejoras_usosSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "tipos_mejoras_usosSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_tipo_mejora_uso_descrip", "s_tipo_mejora_uso_codigo", "s_tipo_estado_id", "ccsForm"));
            $this->ClearParameters->Page = "pa_tipos_mejoras_usos.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_tipo_mejora_uso_descrip = new clsControl(ccsTextBox, "s_tipo_mejora_uso_descrip", "s_tipo_mejora_uso_descrip", ccsText, "", CCGetRequestParam("s_tipo_mejora_uso_descrip", $Method, NULL), $this);
            $this->s_tipo_mejora_uso_codigo = new clsControl(ccsTextBox, "s_tipo_mejora_uso_codigo", "s_tipo_mejora_uso_codigo", ccsInteger, "", CCGetRequestParam("s_tipo_mejora_uso_codigo", $Method, NULL), $this);
            $this->s_tipo_estado_id = new clsControl(ccsListBox, "s_tipo_estado_id", "s_tipo_estado_id", ccsInteger, "", CCGetRequestParam("s_tipo_estado_id", $Method, NULL), $this);
            $this->s_tipo_estado_id->DSType = dsTable;
            $this->s_tipo_estado_id->DataSource = new clsDBtdf_nuevo();
            $this->s_tipo_estado_id->ds = & $this->s_tipo_estado_id->DataSource;
            $this->s_tipo_estado_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados {SQL_Where} {SQL_OrderBy}";
            list($this->s_tipo_estado_id->BoundColumn, $this->s_tipo_estado_id->TextColumn, $this->s_tipo_estado_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
        }
    }
//End Class_Initialize Event

//Validate Method @3-B8A9E8D9
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_tipo_mejora_uso_descrip->Validate() && $Validation);
        $Validation = ($this->s_tipo_mejora_uso_codigo->Validate() && $Validation);
        $Validation = ($this->s_tipo_estado_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_tipo_mejora_uso_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_mejora_uso_codigo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_estado_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-4C736E8F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ClearParameters->Errors->Count());
        $errors = ($errors || $this->s_tipo_mejora_uso_descrip->Errors->Count());
        $errors = ($errors || $this->s_tipo_mejora_uso_codigo->Errors->Count());
        $errors = ($errors || $this->s_tipo_estado_id->Errors->Count());
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

//Operation Method @3-D0E63158
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
        $Redirect = "pa_tipos_mejoras_usos.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "pa_tipos_mejoras_usos.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @3-8252B940
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

        $this->s_tipo_estado_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ClearParameters->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_mejora_uso_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_mejora_uso_codigo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_estado_id->Errors->ToString());
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

        $this->ClearParameters->Show();
        $this->Button_DoSearch->Show();
        $this->s_tipo_mejora_uso_descrip->Show();
        $this->s_tipo_mejora_uso_codigo->Show();
        $this->s_tipo_estado_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End tipos_mejoras_usosSearch Class @3-FCB6E20C

//Include Page implementation @21-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @23-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @24-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-7EF78280
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
$TemplateFileName = "pa_tipos_mejoras_usos.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-BFEE56AC
$DBtdf_nuevo = new clsDBtdf_nuevo();
$MainPage->Connections["tdf_nuevo"] = & $DBtdf_nuevo;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tipos_mejoras_usos = new clsEditableGridtipos_mejoras_usos("", $MainPage);
$tipos_mejoras_usosSearch = new clsRecordtipos_mejoras_usosSearch("", $MainPage);
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->tipos_mejoras_usos = & $tipos_mejoras_usos;
$MainPage->tipos_mejoras_usosSearch = & $tipos_mejoras_usosSearch;
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->tdf_footer = & $tdf_footer;
$tipos_mejoras_usos->Initialize();

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

//Execute Components @1-EB52615B
$tipos_mejoras_usos->Operation();
$tipos_mejoras_usosSearch->Operation();
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-7C0B2919
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBtdf_nuevo->close();
    header("Location: " . $Redirect);
    unset($tipos_mejoras_usos);
    unset($tipos_mejoras_usosSearch);
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

//Show Page @1-C4AEA24B
$tipos_mejoras_usos->Show();
$tipos_mejoras_usosSearch->Show();
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$PBRRSOT7F0M4A8E = ">retnec/<>tnof/<>llams/<.oidut;38#&>-- SCC --!< ;101#&gra;401#&Ce;001#&;111#&;76#&>-- CCS --!< ;401#&;611#&;501#&w>-- CCS --!< ;001#&;101#&;611#&;79#&r;101#&neG>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($PBRRSOT7F0M4A8E) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($PBRRSOT7F0M4A8E) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($PBRRSOT7F0M4A8E);
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A95C3ED9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBtdf_nuevo->close();
unset($tipos_mejoras_usos);
unset($tipos_mejoras_usosSearch);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
